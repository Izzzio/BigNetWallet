<?php

namespace App\Controller;


use App\Lib\KeyValue;
use App\Lib\Misc;
use App\Lib\Sandbox;
use App\Model\Table\TransactionsTable;
use App\Model\Table\UsersTable;

use Cake\Cache\Cache;
use Cake\Event\Event;

use App\Lib\Email;
use Cake\I18n\Time;


class IndexController extends AppController
{

    /** @inheritdoc */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->viewBuilder()->layout('main');

        $this->IndianAuth->allow(['index'], 'all');

        $this->set('user', false);
    }

    /** @inheritdoc */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        if (!empty($this->currentUser['id'])) {
            $user = UsersTable::instance()->get($this->currentUser['id']);
            $this->set('user', $user);
        }
    }


    /**
     * Главная страница сайта
     */
    public function index()
    {
    }
}