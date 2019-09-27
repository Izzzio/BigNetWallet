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
        $this->IndianAuth->allow(['getMethods'], $this->IndianAuth::PERMISSION_ALL);
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
            'msg' => 'No methods found in the contract',
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
                        'methods' => $contracts[$key]['methods'],
                    ],
                ];
            }
        }

        return $this->sendJsonResponse($result);
    }

}