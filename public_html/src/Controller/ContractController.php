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
    public function getMethods($contractId = '')
    {
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

        if (!empty($contractId)) {
            $contracts = Configure::read('Contracts.popular');
            if (false !== $key = array_search($contractId, array_column($contracts, 'id'))) {
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
    public function getInfo($contractAddress = '')
    {
        $result = [
            'success' => false,
            'msg' => 'Wrong contract address or public address',
            'data' => [],
        ];

        $publicAddress = false;
        //$this->request->param('pass')[0]);
        $contractAddress = intval($contractAddress);
        if (isset($this->request->query['addr'])) {
            $publicAddress = substr($this->request->query['addr'], 0, 70);
        }

        if ($contractAddress && $publicAddress) {
            require_once('Api/V1/php/NodeRPC.php');
            require_once('Api/V1/php/EcmaSmartRPC.php');

            try {
                $izNode = new \EcmaSmartRPC(Configure::read('Api.host'), Configure::read('Api.pass'));
                $contractInfo = $izNode->ecmaGetContractProperty($contractAddress, 'contract');
                if (isset($contractInfo['error']) && true == $contractInfo['error']) {
                    throw new \Exception('Contract on address not exist or wrong');
                } else {
                    $tokenName = [];
                    if (isset($contractInfo['result']['ticker']) && !empty($contractInfo['result']['ticker'])) {
                        $tokenName[] = $contractInfo['result']['ticker'];
                    }
                    if (isset($contractInfo['result']['name']) && !empty($contractInfo['result']['name'])) {
                        $tokenName[] = $contractInfo['result']['name'];
                    }

                    $balance = $izNode->ecmaCallMethod($contractAddress, 'balanceOf', [$publicAddress]);
                    if (isset($balance['error']) && true == $balance['error']) {
                        throw new \Exception($balance['message']);
                    } else {
                        if (isset($balance['result'])) {
                            $result['success'] = true;
                            $result['msg'] = '';
                            $result['data']['balance'] = $balance['result'];
                            $result['data']['token'] = [
                                'name' => implode(' - ', $tokenName),
                                'from_contract' => $contractAddress,
                            ];
                        }
                    }
                }
            } catch (\Exception $e) {
                $result['msg'] = $e->getMessage();
            }
        }

        return $this->sendJsonResponse($result);
    }
}