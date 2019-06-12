<?php
/*
 * iZ³ Crowdsale platform
 * Copyright (c) iZ³ | Izzz.io platform (izzz.io)
 * You can contact the copyright holder by e-mail info@izzz.io
 *
 * @copyright iZ³ | Izzz.io platform (izzz.io)
 * @link https://izzz.io
 * @author Andrey Nedobylsky (andrey@izzz.io)
 *
 */

namespace App\Controller;

use App\Lib\Sandbox;
use Cake\Event\Event;
use Cake\Filesystem\Folder;
use Cake\I18n\I18n;

/**
 * Custom controller. Provide Sandbox functional for page and API creation
 * @property \App\Controller\Component\IndianAuthComponent $IndianAuth
 */
class CustomController extends CabinetController
{

    /** @inheritdoc */
    public function beforeFilter(Event $event)
    {
        $this->IndianAuth->allow(['call', 'cpaScript'], 'all');
        parent::beforeFilter($event);


    }

    /**
     * Call sandboxed method
     * @param $method
     * @throws \Exception
     */
    public function call($method)
    {
        $this->response->header('Access-Control-Allow-Origin: *');
        $this->viewBuilder()->layout('ajax');
        Sandbox::runFromStorage($method);
    }

    /**
     * Formats CPA script
     */
    public function cpaScript()
    {
        $this->response->header(['Content-Type' => 'application/javascript']);
        $this->viewBuilder()->layout('ajax');
    }

}