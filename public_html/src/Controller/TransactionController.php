<?php

namespace App\Controller;

use App\Lib\Emails;
use App\Lib\Sandbox;
use App\Lib\KYC;
use App\Lib\Misc;

use Cake\Event\Event;
use Cake\Filesystem\Folder;

use Cake\Core\Configure;
use Cake\Log\Log;

class TransactionController extends AppController
{
    /**
     * beforeFilter callback.
     *
     * @param \Cake\Event\Event $event Event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        $langs = (new Folder(ROOT . '/src/Locale'))->read()[0];
        $this->set('langs', $langs);
        parent::beforeFilter($event);

        //$this->viewBuilder()->layout('main');
        $this->IndianAuth->allow(['online'], $this->IndianAuth::PERMISSION_ALL);
    }

    /**
     * beforeRender callback.
     *
     * @param \Cake\Event\Event $event Event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
    }

    public function online()
    {
        $result = [
            'success' => false,
            'msg' => '',
            'data' => [],
        ];
        if ($this->request->is('post') && $this->request->is('ajax')) {
            $block = $this->request->data;

            if (isset($block['address'])) {
                $block['address'] = substr($block['address'], 0, 70);
            }

            require_once('Api/V1/php/NodeRPC.php');
            require_once('Api/V1/php/EcmaSmartRPC.php');
            try {
                $izNode = new \EcmaSmartRPC(Configure::read('Api.host'), Configure::read('Api.pass'));
                $wallet = $izNode->ecmaDeployMethodSignedBLock(Configure::read('Networks')[0]['masterContract'], $block);
                if (isset($wallet['error']) && true == $wallet['error']) {
                    throw new \Exception($wallet['message']);
                } else {
                    if (isset($wallet['result'])) {
                        $result['success'] = true;
                        $result['msg'] = 'Transaction succesfull created';
                    }
                }
            } catch (\Exception $e) {
                $result['msg'] = $e->getMessage();
            }

            return $this->sendJsonResponse($result);
        }
    }

    protected function sendJsonResponse($dataForJSON)
    {
        $dataForJSON['_serialize'] = array_keys($dataForJSON);
        $dataForJSON['_jsonOptions'] = JSON_UNESCAPED_UNICODE;

        $this->set($dataForJSON);
        $this->viewBuilder()->className('Json');

        return null;
    }
}