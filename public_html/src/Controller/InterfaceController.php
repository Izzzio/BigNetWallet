<?php

namespace App\Controller;

use App\Controller\Component\IndianAuthComponent;
use App\Lib\Calculator;
use App\Lib\CBRF;
use App\Lib\CPA;
use App\Lib\CoinMarketCap;
use App\Lib\Crypt;
use App\Lib\CurrentUser;
use App\Lib\KeyValue;
use App\Lib\Misc;
use App\Lib\Payments\Payment;
use App\Lib\Referal;
use App\Lib\Sandbox;

use Cake\Cache\Cache;
use Cake\Event\Event;

use Cake\Filesystem\Folder;

use RuntimeException;


class InterfaceController extends AppController
{
    /** @inheritdoc */
    public function beforeFilter(Event $event)
    {
        $langs = (new Folder(ROOT . '/src/Locale'))->read()[0];
        $this->set('langs', $langs);
        parent::beforeFilter($event);

        $this->viewBuilder()->layout('interface');
        $this->IndianAuth->allow(['index'], $this->IndianAuth::PERMISSION_ALL);

        /*
        if (!empty($this->Cookie->read('Long.refUser'))) {
            $this->request->session()->write('refUser', $this->Cookie->read('Long.refUser'));
        }
        */
    }

    /** @inheritdoc */
    public function beforeRender(Event $event)
    {
    }

    public function index()
    {
    }
}