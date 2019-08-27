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
            $paramsTransaction = [];
            $block = $this->request->data;

            if (isset($block['address'])) {
                $block['address'] = substr($block['address'], 0, 70);
            }

            /*
            if (4 != count($paramsTransaction)) {
                $result['msg'] = 'Please fill all required fields';
                return $this->sendJsonResponse($result);
            }
            */

            require_once('Api/V1/php/NodeRPC.php');
            require_once('Api/V1/php/EcmaSmartRPC.php');
            try {
                $izNode = new \EcmaSmartRPC(Configure::read('Api.host'), Configure::read('Api.pass'));

                /*
                $networkInfo = $izNode->ecmaGetInfo();
                if(!isset($networkInfo['lastBlock'])) {
                    throw new \Exception('Network is not ready. Please try again later.');
                }
                */

                $wallet = $izNode->ecmaDeployMethodSignedBLock($block['address'], $block);

                /*
                $networkInfo2 = $izNode->getInfo();
                if(!isset($networkInfo['lastBlock'])) {
                    throw new \Exception('Network is not ready. Please try again later.');
                }

                print_r($networkInfo2);
                die(" --- ");
                */
                /*

                $wallet = $izNode->changeWallet(
                    [
                    $paramsTransaction[0],
                    'af65405770b747ceef98cb38ecca0e037c08d0c0361d719a727a2413c54df2ac',
                    $paramsTransaction[0],
                    ]
                );
                var_dump($wallet);
                print_r($izNode->getInfo());
                die("STOP");
                */

                //$wallet = $izNode->ecmaDeployMethod($networkInfo['lastBlock'], 'transfer', $paramsTransaction);



                if(isset($wallet['error']) && true == $wallet['error']){
                    throw new \Exception($wallet['message']);
                } else {
                    if(isset($wallet['result'])){
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