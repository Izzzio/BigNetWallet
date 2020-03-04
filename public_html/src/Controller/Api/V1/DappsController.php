<?php

namespace App\Controller\Api\v1;

use Cake\Event\Event;
use Cake\Core\Configure;

class DappsController extends ApiController
{
    /**
     * beforeFilter callback.
     *
     * @param \Cake\Event\Event $event Event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        //$this->viewBuilder()->layout('main');
        $this->IndianAuth->allow(['getApp', 'callMethod', 'deployMethod'], $this->IndianAuth::PERMISSION_ALL);
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

    public function getApp($contractAddr = 0)
    {
        $result = [
            'success' => false,
            'msg' => '',
            'data' => [],
        ];
        if ($this->request->is('get') && $this->request->is('ajax')) {
            $contractAddr = intval($contractAddr);
            try {
                $app = $this->_iz3Node->ecmaCallMethod($contractAddr, 'getAppData', []);
                if (isset($app['error']) && true == $app['error']) {
                    throw new \Exception($app['message']);
                } else {
                    if (isset($app['result'])) {
                        $result['success'] = true;
                        $result['data'] = $app['result'];
                    }
                }
            } catch (\Exception $e) {
                $result['msg'] = $e->getMessage();
            }

            return $this->sendJsonResponse($result);
        }
    }

    public function callMethod($contractAddr = 0)
    {
        $result = [
            'success' => false,
            'msg' => '',
            'data' => [],
        ];
        if ($this->request->is('post') && $this->request->is('ajax')) {
            $contractAddr = intval($contractAddr);
            $method = isset($this->request->data['method']) ? $this->request->data['method'] : false;
            $params = (isset($this->request->data['params']) && is_array($this->request->data['params'])) ? $this->request->data['params'] : [];

            try {
                $res = $this->_iz3Node->ecmaCallMethod($contractAddr, $method, $params);
                if (isset($res['error']) && true == $res['error']) {
                    throw new \Exception($res['message']);
                } else {
                    if (isset($res['result'])) {
                        $result['success'] = true;
                        $result['data'] = $res['result'];
                    }
                }
            } catch (\Exception $e) {
                $result['msg'] = $e->getMessage();
            }

            return $this->sendJsonResponse($result);
        }
    }

    public function deployMethod($contractAddr = 0)
    {
        $result = [
            'success' => false,
            'msg' => '',
            'data' => [],
        ];
        if ($this->request->is('post') && $this->request->is('ajax')) {
            $contractAddr = intval($contractAddr);
            $method = isset($this->request->data['method']) ? $this->request->data['method'] : false;
            $params = (isset($this->request->data['params']) && is_array($this->request->data['params'])) ? $this->request->data['params'] : [];

            try {
                $res = $this->_iz3Node->ecmaCallMethod($contractAddr, $method, $params);
                if (isset($res['error']) && true == $res['error']) {
                    throw new \Exception($res['message']);
                } else {
                    if (isset($res['result'])) {
                        $result['success'] = true;
                        $result['data'] = $res['result'];
                    }
                }
            } catch (\Exception $e) {
                $result['msg'] = $e->getMessage();
            }

            return $this->sendJsonResponse($result);
        }
    }
}