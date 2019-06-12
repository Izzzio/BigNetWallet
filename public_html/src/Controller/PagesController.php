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


class PagesController extends AppController
{


    /** @inheritdoc */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->IndianAuth->allow(['index', 'saft'], 'all');

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
      //  $this->viewBuilder()->layout('landing');
        return $this->redirect(['controller' => 'cabinet']);

    }

    /**
     * Get SAFT document
     *
     * @param $param
     * @throws \Exception
     */
    public function saft($param)
    {
        $this->viewBuilder()->layout('ajax');
        if ($param != 's' && $param != 'd') {
            throw new \Exception('Incorrect param');
        }

        $data = json_decode(
            $this->currentUser['registration_data']
        );
        $this->set('param', $param);
        if (empty($data)) {

            $this->set('data', []);
        } else {

            $data = [
                'user' => [
                    'name'    => $this->currentUser['name'],
                    'title'   => '',
                    'address' => $data->country . ', ' . $data->city . ', ' . $data->address . ', ' . $data->zipcode,
                    'email'   => $this->currentUser['email'],
                ],
            ];

            $this->set('data', $data);
        }


    }


}

