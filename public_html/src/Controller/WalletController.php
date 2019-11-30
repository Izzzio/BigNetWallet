<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\Core\Configure;

class WalletController extends AppController
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
        $this->IndianAuth->allow(['create', 'login'], $this->IndianAuth::PERMISSION_ALL);
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
     * Create new wallet
     */
    public function create()
    {
        /*
        require_once ('Api/V1/php/NodeRPC.php');
        $izNode = new \NodeRPC(Configure::read('Api.host'), Configure::read('Api.pass'));

        $wallet = $izNode->createWallet();

        print("<pre>");
        var_dump($wallet);
        //$izNode->changeWallet($wallet);

        print_r($izNode->getInfo());
        die("STOP");


        echo "New wallet address: " . $wallet['id'] . "\n";
        //echo "New tiny address: " . \NodeRPC::getTinyAddress($wallet) . "\n";
        echo "Current address: " . $izNode->getWallet() . "\n";
        echo "\n";
        echo "Info about master wallet: \n";

        try {
            $masterWallet = $izNode->getWalletInfo('BL_1');
            echo "Full address: " . $masterWallet['id'] . "\n";
            echo "Balance: " . \NodeRPC::mil2IZ($masterWallet['balance']) . "\n";
        } catch (\ReturnException $e) {
            echo "Address not found\n";
        }

        try {
            var_dump($izNode->createTransaction('7a6545dbbfff0f4d9723d6f83bee85dc8b93cb47a9d178cbea9157eaffda3c09', \NodeRPC::IZ2Mil(1)));
        } catch (\ReturnException $e) {
            echo "Can't create transaction\n";
        }
        */

    }

    public function login()
    {
        $result = [
            'success' => false,
            'msg' => '',
            'data' => [],
        ];
        if ($this->request->is('get') && $this->request->is('ajax')) {

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
            $view = $builder->build();
            $result['data']['page'] = $view->render();

            $this->set([
                'result' => $result,
                '_serialize' => 'result',
            ]);
            $this->RequestHandler->renderAs($this, 'json');
        }
    }
}