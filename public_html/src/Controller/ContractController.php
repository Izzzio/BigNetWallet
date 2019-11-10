<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\Filesystem\Folder;

use Cake\Core\Configure;

class ContractController extends AppController
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

        $this->viewBuilder()->layout('main');
        $this->IndianAuth->allow(['getInfo', 'getMethods'], $this->IndianAuth::PERMISSION_ALL);
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

    /**
     * Get allowed methods from contract
     */
    public function getMethods($contractId = ''){
        $result = [
            'success' => false,
            'msg' => 'Contract not found',
            'data' => [],
        ];

        //$this->request->param('pass')[0]);
        $contractId = substr($contractId, 0, 30);
        $contractId = filter_var($contractId, FILTER_SANITIZE_STRING);

        /*
         * TODO
         * Если в блоке с номером X действительно есть контракт с названием NAME,
         * то получаем список методов данного контракта
         */

        if(!empty($contractId)){
            $contracts = Configure::read('Contracts.popular');
            if(false !== $key = array_search($contractId, array_column($contracts, 'id'))){
                $result['success'] = true;
                $result['msg'] = '';
                $result['data'] = [
                    'contract' => [
                        'id' => $contracts[$key]['id'],
                        //'methods' => $contracts[$key]['methods'],
                        'abi' => json_encode(json_decode($contracts[$key]['abi'])),
                    ],
                ];
            }
        }

        return $this->sendJsonResponse($result);
    }

    /**
     * Get main info about contract
     * @param integer $address Contract address
     * @return string json
     */
    public function getInfo($address = ''){
        $result = [
            'success' => false,
            'msg' => 'Contract not found',
            'data' => [],
        ];

        //$this->request->param('pass')[0]);
        $address = intval($address);

        if($address){
            require_once ('Api/V1/php/NodeRPC.php');
            require_once ('Api/V1/php/EcmaSmartRPC.php');

            try{
                $izNode = new \EcmaSmartRPC(Configure::read('Api.host'), Configure::read('Api.pass'));
                $contractInfo = $izNode->ecmaGetContractProperty($address, 'contract');
                if (isset($contractInfo['error']) && true == $contractInfo['error']) {
                    throw new \Exception('Contract on address not exist or wrong');
                } else {

                    var_dump($contractInfo);

                }

                die(" --- ");


                $networkInfo = $izNode->getInfo();
                if(!isset($networkInfo['maxBlock'])) {
                    throw new \Exception('Network is not ready. Please try again later.');
                }
                $network['lastBlock'] = $networkInfo['maxBlock'];



                $wallet = $izNode->ecmaCallMethod($network['masterContract'], 'balanceOf', [$address]);
                if(isset($wallet['error']) && true == $wallet['error']){
                    throw new \Exception($wallet['message']);
                } else {
                    if(isset($wallet['result'])){
                        $result['success'] = true;
                        $balance = $wallet['result'];
                    }
                }
            } catch (\Exception $e) {
                $result['msg'] = $e->getMessage();
            }
        }

        return $this->sendJsonResponse($result);
    }

}