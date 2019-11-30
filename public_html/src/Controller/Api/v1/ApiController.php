<?php

namespace App\Controller\Api\v1;

use Cake\Core\Configure;
use Cake\Controller\Controller;
use Cake\Log\Log;

use Cake\I18n\Date;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;
use Cake\I18n\I18n;

class ApiController extends Controller
{
    protected $_iz3Node = '';

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');

        Time::setToStringFormat('yyyy-MM-dd HH:mm:ss');  // For any mutable DateTime
        FrozenTime::setToStringFormat('yyyy-MM-dd HH:mm:ss');  // For any immutable DateTime
        Date::setToStringFormat('yyyy-MM-dd');  // For any mutable Date
        FrozenDate::setToStringFormat('yyyy-MM-dd');  // For any immutable Date

        if (!empty($_GET['provider'])
            || (in_array($this->request->controller, ['HybridAuth']))) {
            $this->loadComponent('Auth', [
                'authenticate'  => [
                    'Form',
                    'ADmad/HybridAuth.HybridAuth' => [
                        // All keys shown below are defaults
                        'fields'              => [
                            'provider'          => 'provider',
                            'openid_identifier' => 'openid_identifier',
                            'email'             => 'email',
                        ],
                        'profileModel'        => 'ADmad/HybridAuth.SocialProfiles',
                        'profileModelFkField' => 'user_id',
                        'userModel'           => 'Users',
                        'hauth_return_to'     => 'cabinet/home',
                    ],
                ],
                'loginAction'   => [
                    'controller' => 'App',
                    'action'     => 'login',
                    'plugin'     => false,
                ],
                'loginRedirect' => [
                    'controller' => 'Cabinet',
                    'action'     => 'home',
                    'plugin'     => false,
                ],
            ]);
        } else {
            $this->loadComponent('IndianAuth');
            $this->set('IndianAuth', $this->IndianAuth);
        }

        $this->_iz3Node = $this->_connectApi();
    }

    public function index()
    {
    }

    private function _connectApi()
    {
        require_once('php/NodeRPC.php');
        require_once('php/EcmaSmartRPC.php');
        try {
            return new \EcmaSmartRPC(Configure::read('Api.host'), Configure::read('Api.pass'));
        } catch (\Exception $e) {
            $result = [
                'success' => false,
                'msg' => $e->getMessage(),
                'data' => [],
            ];
            $this->sendJsonResponse($result);
        }
    }

    /**
     * Отправляет JSON ответ
     *
     * @param $json_array
     * @return NULL
     */
    protected function sendJsonResponse($json_array)
    {
        $json_array['_serialize'] = array_keys($json_array);
        $json_array['_jsonOptions'] = JSON_UNESCAPED_UNICODE;

        $this->set($json_array);
        $this->viewBuilder()->className('Json');

        return;
    }

    /**
     * Возвращает ответ без ошибки и прерывает выполнение
     *
     * @param array $jsonData
     * @return NULL
     */

    public function sendJsonOk($jsonData)
    {
        return $this->sendJsonResponse(['status' => 'ok'] + $jsonData);
    }

    /**
     * Возвращает ответ с ошибкой, сообщением, и прерывает выполнение
     *
     * @param string $message
     * @param array $jsonData дополнительные параметры если нужны
     * @return NULL
     */
    public function sendJsonError($message, $jsonData = [])
    {
        return $this->sendJsonResponse(['status' => 'error', 'message' => $message] + $jsonData);
    }
}