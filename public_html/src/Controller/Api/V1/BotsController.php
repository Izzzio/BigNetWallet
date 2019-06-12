<?php

namespace App\Controller\Api\V1;

use Cake\Event\Event;

use Cake\Core\Configure;

use App\Controller\CabinetController;

use App\Model\Entity\User;
use App\Model\Table\UsersTable;

use App\Lib\Crypt;
use App\Lib\Misc;
use App\Lib\Payments\Payment;

use App\Controller\Component\IndianAuthComponent;

//use App\Controller\Api\v1\ApiController;

class BotsController extends ApiController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

    }

    /**
     * Авторизация
     * @return \Cake\Network\Response|null
     */
    public function authorize()
    {
        $token = null;
        if (!$this->request->is('post')) {
            return $this->redirect($this->_errorURL . '/2');
        }
        if (count($this->request->data)) {
            $email = $this->request->data['email'];
            $passwd = IndianAuthComponent::makeHash($this->request->data['passwd']);

            $user = UsersTable::f()->where(['email' => $email, 'password' => $passwd])->first();

            if (!$user) {
                return $this->redirect($this->_errorURL . '/20');
            }
            if (!empty($user) && (!Configure::read('App.allowAutoverify') && $user->status !== User::STATUS_VERIFIED)) {
                return $this->redirect($this->_errorURL . '/21');
            }

            $token = $this->_getAccessToken($user->id);
        }
        $this->set('token', $token);
        $this->set('_serialize', ['token']);

        //$this->autoRender = false;
        /*
        $articles = ['1' => ['11' => 111]];
        $comments = ['qwqw' => 2];
        $this->set(compact('articles', 'comments'));
        $this->set('_serialize', ['articles', 'comments']);
        */

        /*
        $resultJ = json_encode(array('result' => 'success'));
        $this->response->type('json');
        $this->response->body($resultJ);
        return $this->response;
        */
    }

    /**
     * Получить информацию об аккаунте
     * @return \Cake\Network\Response|null
     */
    public function getAccount()
    {
        try {
            $token = $this->_checkAccessToken();
            $userMain = UsersTable::f()->where(['id' => $token->user_id])->first();

            if (!$userMain) {
                throw new \Exception('', 20);
            }

            $user = [];
            $user['phone'] = $userMain['phone'];
            $user['name'] = $userMain['name'];
            $user['age'] = $userMain['age'];
            $user['country'] = $userMain['country'];

            $refLink = (empty(URL_PREFIX) ? (BASE_PROTOCOL . '://' . BASE_DOMAIN) :
                    URL_PREFIX) . '/cabinet/ref/' . Crypt::ecrypt($token->user_id);
            $user['ref_link'] = $refLink;
            $user['tokens'] = [
                'abbr'  => \App\Lib\Misc::tokenName(),
                'main'  => $userMain->tokens - $userMain->in_chain,
                'bonus' => $userMain->tokens_bonus,
            ];
            $user['tokens']['total'] = $user['tokens']['main'] + $user['tokens']['bonus'];

            $this->set('user', $user);
            $this->set('_serialize', ['user']);
        } catch (\Exception $e) {
            return $this->redirect($this->_errorURL . '/' . $e->getCode() . '/' . $e->getMessage());
        }
    }

    /**
     * Получить адрес кошелька для перевода
     * @return \Cake\Network\Response|null
     */
    public function getWallet()
    {
        try {
            $token = $this->_checkAccessToken();

            $currency = $this->_getOrPostVar('currency');
            if (!$currency) {
                throw new \Exception('', 100);
            }


            $deposit = false;
            $hash = md5($currency . $token->user_id . $deposit . Misc::projectName());
            $transaction = Payment::createDeposit(
                0,
                $currency,
                $hash
            );


            if (!is_array($transaction) || !isset($transaction['address'])) {
                throw new \Exception('', 101);
            }

            $this->set('wallet', $transaction['address']);
            $this->set('_serialize', ['wallet']);
        } catch (\Exception $e) {
            return $this->redirect($this->_errorURL . '/' . $e->getCode() . '/' . $e->getMessage());
        }
    }

    /**
     * Список активных валют
     * @return \Cake\Network\Response|null
     */
    public function getCurrencies()
    {
        try {
            $this->_checkAccessToken();

            $this->set('currencys', Misc::getCurrensiesList());
            $this->set('_serialize', ['currencys']);
        } catch (\Exception $e) {
            return $this->redirect($this->_errorURL . '/' . $e->getCode() . '/' . $e->getMessage());
        }
    }

    /**
     * Конвертация токенов в люту
     * @return \Cake\Network\Response|null
     */
    public function convertTokensToCurrency()
    {
        try {
            $this->_checkAccessToken();

            $tokensCount = $this->_getOrPostVar('tkn_count', 0);
            $toCurrency = $this->_getOrPostVar('to_currency');

            $cabinet = new CabinetController();
            $converted = $cabinet->calcToken2Money($tokensCount, $toCurrency, false);
            if (!is_array($converted) || !isset($converted['money'])) {
                throw new \Exception($converted);
            }

            $this->set('converted', $converted);
            $this->set('_serialize', ['converted']);
        } catch (\Exception $e) {
            return $this->redirect($this->_errorURL . '/' . $e->getCode() . '/' . $e->getMessage());
        }
    }

    /**
     * Конвертация валюты в токены
     * @return \Cake\Network\Response|null
     */
    public function convertCurrencyToTokens()
    {
        try {
            $this->_checkAccessToken();

            $amount = $this->_getOrPostVar('amount', 0);
            $currency = $this->_getOrPostVar('currency');

            $cabinet = new CabinetController();
            $converted = $cabinet->calcMoney2Token($amount, $currency, false);
            if (!is_array($converted) || !isset($converted['money'])) {
                throw new \Exception($converted);
            }

            $this->set('converted', $converted);
            $this->set('_serialize', ['converted']);
        } catch (\Exception $e) {
            return $this->redirect($this->_errorURL . '/' . $e->getCode() . '/' . $e->getMessage());
        }
    }
}