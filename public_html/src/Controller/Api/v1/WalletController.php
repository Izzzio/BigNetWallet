<?php

namespace App\Controller\Api\v1;

use Cake\Event\Event;
use Cake\Core\Configure;

class WalletController extends ApiController
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

        $this->viewBuilder()->layout('main');
        $this->IndianAuth->allow(['create', 'login', 'balanceOf'], $this->IndianAuth::PERMISSION_ALL);
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

    public function login()
    {
        $result = [
            'success' => false,
            'msg' => '',
            'data' => [],
        ];
        if ($this->request->is('get') && $this->request->is('ajax')) {
            $address = false;
            $balance = 0;
            $network = Configure::read('Networks')[0];
            $contractsPopular = Configure::read('Contracts.popular');

            if (isset($this->request->query['addr'])) {
                $address = substr($this->request->query['addr'], 0, 70);
            }
            if ($address) {
                try {
                    $networkInfo = $this->_iz3Node->getInfo();

                    if (!isset($networkInfo['maxBlock'])) {
                        throw new \Exception('Network is not ready. Please try again later.');
                    }
                    $network['lastBlock'] = $networkInfo['maxBlock'];

                    $wallet = $this->_iz3Node->ecmaCallMethod($network['masterContract'], 'balanceOf', [$address]);
                    if (isset($wallet['error']) && true == $wallet['error']) {
                        throw new \Exception($wallet['message']);
                    } else {
                        if (isset($wallet['result'])) {
                            $result['success'] = true;
                            $balance = $wallet['result'];
                        }
                    }
                } catch (\Exception $e) {
                    $result['msg'] = $e->getMessage() . '<br />Access not granted';
                }
            } else {
                $result['msg'] = 'Enter your key, please';
            }

            // create a builder (hint: new ViewBuilder() constructor works too)
            $builder = $this->viewBuilder();
            $builder
                //->layoutPath('Admin')
                ->layout('ajax')
                ->templatePath('Interface')
                ->template('menu');

            // create a view instance
            $view = $builder->build();

            // render to a variable
            $result['data']['menu'] = $view->render();

            $builder->template('login');
            $view = $builder->build(compact(['address', 'balance', 'network', 'contractsPopular']));
            $result['data']['page'] = $view->render();

            $this->set([
                'result' => $result,
                '_serialize' => 'result',
            ]);
            $this->RequestHandler->renderAs($this, 'json');
        }
    }

    public function balanceOf($address = false)
    {
        $result = [
            'success' => false,
            'msg' => '',
            'data' => [],
        ];
        if ($this->request->is('get') && $this->request->is('ajax')) {
            if ($address) {
                $address = substr($address, 0, 70);

                $contract = Configure::read('Networks')[0]['masterContract'];
                /*
                if (isset($this->request->query['contract'])) {
                    $contract = intval($this->request->query['contract']);
                }
                */

                try {
                    $wallet = $this->_iz3Node->ecmaCallMethod($contract, 'balanceOf', [$address]);
                    if (isset($wallet['error']) && true == $wallet['error']) {
                        throw new \Exception($wallet['message']);
                    } else {
                        if (isset($wallet['result'])) {
                            $result['success'] = true;
                            $result['data']['balance'] = $wallet['result'];
                        }
                    }
                } catch (\Exception $e) {
                    $result['msg'] = $e->getMessage();
                }
            } else {
                $result['msg'] = 'not found address';
            }
        }

        return $this->sendJsonResponse($result);
    }
}