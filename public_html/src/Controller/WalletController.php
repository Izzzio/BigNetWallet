<?php

namespace App\Controller;

use App\Lib\Emails;
use App\Lib\Sandbox;
use App\Lib\KYC;
use App\Lib\Misc;
use App\Model\Entity\KycAttempts;
use App\Model\Table\CountriesTable;
use App\Model\Table\KycAttemptsTable;
use App\Model\Table\LogTable;
use App\Model\Table\UsersTable;

use Cake\Event\Event;
use Cake\Filesystem\Folder;

use Cake\Core\Configure;
use Cake\Log\Log;

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
        $langs = (new Folder(ROOT . '/src/Locale'))->read()[0];
        $this->set('langs', $langs);
        parent::beforeFilter($event);

        $this->IndianAuth->allow(['result'], 'all');
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
        die("1");
    }
}