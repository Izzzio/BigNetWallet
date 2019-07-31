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
            $paramsTransaction['amount'] = false;
            $paramsTransaction['to'] = false;

            if (isset($this->request->data['amount'])) {
                $paramsTransaction['amount'] = substr($this->request->data['amount'], 0, 30);
            }
            if (isset($this->request->data['payee'])) {
                $paramsTransaction['to'] = substr($this->request->data['payee'], 0, 70);
            }

            $payer = false;
            if (isset($this->request->data['addr'])) {
                $payer = substr($this->request->data['addr'], 0, 70);
            }

            if (!$paramsTransaction['to'] || !$paramsTransaction['amount']) {
                $result['msg'] = 'Please fill all required fields';
                return $this->sendJsonResponse($result);
            }

            require_once('Api/V1/php/NodeRPC.php');
            require_once('Api/V1/php/EcmaSmartRPC.php');
            try {
                $izNode = new \EcmaSmartRPC(Configure::read('Api.host'), Configure::read('Api.pass'));
                $wallet = $izNode->ecmaCallMethod($payer, 'transfer', $paramsTransaction);
                if (isset($wallet['error']) && 1 == $wallet['error']) {


                    /*
                     * TODO
                     * Когда будет реализована возможность создавать кошелки по API(прямо на ноде, а не в браузере),
                     * то переписать код получения баланса адреса.
                     */
                    $result['msg'] = 'DEMO';


                }
            } catch (\Exception $e) {
                $result['msg'] = 'Unable connect to wallet';
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