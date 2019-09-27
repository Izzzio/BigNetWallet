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
        $this->IndianAuth->allow(['online', 'contractInteract', 'contractDeploy'], $this->IndianAuth::PERMISSION_ALL);
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

    public function contractInteract()
    {
        $result = [
            'success' => false,
            'msg' => '',
            'data' => [],
        ];
        if ($this->request->is('get') && $this->request->is('ajax')) {
            $contractAddress = $this->request->query('addr') ? $this->request->query('addr') : '';
            $contractAddress = '1';
            $method = strval($this->request->query('method') ? $this->request->query('method') : '');

            switch ($method){
                case 'checkContractAddress':
                    break;
                default:
                    $result['msg'] = 'Error: select action, please';
                    break;
            }

            if(!empty($result['msg'])){
                return $this->sendJsonResponse($result);
            }

            require_once('Api/V1/php/NodeRPC.php');
            require_once('Api/V1/php/EcmaSmartRPC.php');
            try {
                $izNode = new \EcmaSmartRPC(Configure::read('Api.host'), Configure::read('Api.pass'));
                $request = $izNode->ecmaCallMethod($contractAddress, $method, ['1']);
                if (isset($request['error']) && true == $request['error']) {
                    throw new \Exception($request['message']);
                } else {


                    var_dump($request);


                    if (isset($request['result'])) {
                        $result['success'] = true;
                    }
                }
            } catch (\Exception $e) {
                $result['msg'] = $e->getMessage();
            }

            return $this->sendJsonResponse($result);
        }
    }

    public function contractDeploy()
    {
        $result = [
            'success' => false,
            'msg' => '',
            'data' => [],
        ];
        if ($this->request->is('post') && $this->request->is('ajax')) {
            $block = isset($this->request->data['block']) ? $this->request->data['block'] : [];
            $rent = isset($this->request->data['rent']) ? intval($this->request->data['rent']) : 0;

            $blockChecked = [];
            if(isset($block['data'])){
                $blockChecked['data'] = true;
            }
            if(isset($block['sign'])){
                $blockChecked['sign'] = true;
            }
            if(isset($block['pubkey'])){
                $blockChecked['pubkey'] = true;
            }
            if(isset($block['ecmaCode']) && !empty($block['ecmaCode'] && mb_strlen($block['ecmaCode']) > 100 )){
                $blockChecked['ecmaCode'] = true;
            }
            if(isset($block['state']) && is_array($block['state']) && count($block['state']) > 0){
                $blockChecked['state'] = true;
            }
            if(5 != count($blockChecked) || $rent < 0){
                $result['msg'] = 'Error: wrong contract code or wrong block';
                return $this->sendJsonResponse($result);
            }

            require_once('Api/V1/php/NodeRPC.php');
            require_once('Api/V1/php/EcmaSmartRPC.php');
            try {
                $izNode = new \EcmaSmartRPC(Configure::read('Api.host'), Configure::read('Api.pass'));
                $deployContract = $izNode->ecmaDeployContractSignedBlock($block, $rent);
                if (isset($deployContract['error']) && true == $deployContract['error']) {
                    throw new \Exception($deployContract['message']);
                } else {
                    if (isset($deployContract['result'])) {
                        $result['success'] = true;
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