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
        $this->IndianAuth->allow(['getApp'], $this->IndianAuth::PERMISSION_ALL);
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
}