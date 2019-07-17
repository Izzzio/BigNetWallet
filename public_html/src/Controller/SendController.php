<?php

namespace App\Controller;

use Cake\Cache\Cache;
use Cake\Event\Event;

use Cake\Filesystem\Folder;

class SendController extends AppController
{
    /** @inheritdoc */
    public function beforeFilter(Event $event)
    {
        $langs = (new Folder(ROOT . '/src/Locale'))->read()[0];
        $this->set('langs', $langs);
        parent::beforeFilter($event);

        $this->viewBuilder()->layout('interface');
        $this->IndianAuth->allow(['index', 'online'], $this->IndianAuth::PERMISSION_ALL);

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

    public function online()
    {
    }

    public function offline()
    {
    }
}