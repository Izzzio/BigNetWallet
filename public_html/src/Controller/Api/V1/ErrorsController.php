<?php

namespace App\Controller\Api\V1;

use Cake\Controller\Controller;
use Cake\Event\Event;

class ErrorsController extends Controller
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    public function createResponseError($code = null, $msg = null)
    {
        $code = intval($code);
        if(!$msg){
            switch ($code){
                case 1:
                    $msg = 'key error';
                    break;
                case 2:
                    $msg = 'only post request allowed';
                    break;

                case 20:
                    $msg = 'user not exist';
                    break;
                case 21:
                    $msg = 'user not verified';
                    break;

                case 40:
                    $msg = 'request does not include a token';
                    break;
                case 41:
                    $msg = 'token not found';
                    break;
                case 42:
                    $msg = 'token expired';
                    break;
                case 43:
                    $msg = 'unable create access token';
                    break;

                case 100:
                    $msg = 'specify currency to create a wallet';
                    break;

                default:
                    $code = null;
                    $msg = 'unknown error code';
            }
        }
        $this->set('error', ['code' => $code, 'msg' => $msg]);
        $this->set('_serialize', ['error']);
        $this->viewBuilder()->className('Json');

        return null;
    }
}