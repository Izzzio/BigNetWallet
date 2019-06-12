<?php

namespace App\Controller\Api\V1;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;

use Cake\I18n\Date;
use Cake\I18n\FrozenDate;
use Cake\I18n\Time;
use Cake\I18n\FrozenTime;

use App\Model\Table\ApiTokensTable;

class ApiController extends Controller
{
    protected $_errorURL = 'api/v1/errors/createResponseError';

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');

        Time::setToStringFormat('yyyy-MM-dd HH:mm:ss');  // For any mutable DateTime
        FrozenTime::setToStringFormat('yyyy-MM-dd HH:mm:ss');  // For any immutable DateTime
        Date::setToStringFormat('yyyy-MM-dd');  // For any mutable Date
        FrozenDate::setToStringFormat('yyyy-MM-dd');  // For any immutable Date
    }

    public function startupProcess()
    {
        if ($this->_checkKey()) {
            return parent::startupProcess();
        }

        return $this->redirect($this->_errorURL . '/1');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    protected function _getAccessToken($userId = null)
    {
        $token = $this->_findAccessToken($userId);
        if (!$token) {
            $token = $this->_createAccessToken($userId);
        }

        return $token;
    }

    protected function _checkAccessToken()
    {
        $token = $this->request->query('token') ? $this->request->query('token') : false;
        $token = $this->request->data('token') ? $this->request->data('token') : $token;
        if (!$token) {
            throw new \Exception('', 40);
        }

        $result = ApiTokensTable::f()
            ->where([
                'token' => $token,
            ])
            ->orderDesc('expiration')
            ->first();

        if (!$result) {
            throw new \Exception('', 41);
        }

        if (!$this->_isValidAccessToken($result)) {
            throw new \Exception('', 42);
        }

        return $result;
    }

    private function _isValidAccessToken($tokenParams)
    {
        $valid = false;
        $dateNow = new \DateTime();
        $dateTokenExp = new \DateTime($tokenParams->expiration);
        if ($dateNow <= $dateTokenExp) {
            $valid = true;
        }

        return $valid;
    }

    private function _checkKey()
    {
        $result = false;
        $key = isset($this->request->data['key']) ? $this->request->data['key'] : null;
        if (!$key) {
            $key = (null !== $this->request->query('key')) ? $this->request->query('key') : null;
        }
        if ($key === Configure::read('Api.key') && !empty($key)) {
            $result = true;
        }

        return $result;
    }

    private function _findAccessToken($userId)
    {
        $token = null;
        $row = ApiTokensTable::f()
            ->where([
                'user_id' => $userId,
            ])
            ->orderDesc('expiration')
            ->first();

        if ($row && $this->_isValidAccessToken($row)) {
            $token = $row->token;
        }

        return $token;
    }

    private function _createAccessToken($userId = 0)
    {
        $expiration = (new \DateTimeImmutable())->modify('+' . Configure::read('Api.tokenLifeTime') . ' minutes');
        $tokenNew = ApiTokensTable::instance()->newEntity([
            'token'      => bin2hex(random_bytes(30)),
            'user_id'    => $userId,
            'expiration' => $expiration->format('Y-m-d H:i:s'),
        ]);
        if (!ApiTokensTable::instance()->save($tokenNew)) {
            throw new \Exception('', 43);
        }

        return $tokenNew->token;
    }

    public function _getOrPostVar($name, $default = null)
    {
        if (!empty($this->request->data($name))) {
            return $this->request->data($name);
        }
        if (!empty($this->request->query($name))) {
            return $this->request->query($name);
        }

        return $default;
    }

}