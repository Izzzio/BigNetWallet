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

use App\Controller\Component\IndianAuthComponent;
use App\Controller\AclController as Acl;
use App\Lib\Calculator;
use App\Lib\CPA;
use App\Lib\Crypt;
use App\Lib\CurrentUser;
use App\Lib\Email;
use App\Lib\Emails;
use App\Lib\FAQ;
use App\Lib\KeyValue;
use App\Lib\Misc;

use App\Model\Entity\User;
use App\Model\Table\LogTable;
use App\Model\Table\UsersTable;
use App\Model\Table\UsersSettingsTable;
use Cake\Cache\Cache;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Date;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;
use Cake\I18n\I18n;
use Cake\Filesystem\Folder;
use Cake\Log\Log;
use Cake\Network\Exception\InternalErrorException;
use Cake\Utility\Security;

/**
 * @property \App\Controller\Component\IndianAuthComponent $IndianAuth
 */
class AppController extends Controller
{

    const LOGIN_ATTEMPTS_MAX = 20;

    public $currentUser;
    public $appName;
    public $clickId;

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');

        $this->loadComponent('Cookie');
        $this->Cookie->config('path', '/');
        $this->Cookie->config([
            'expires'  => '+5 days',
            'httpOnly' => true,
        ]);
        $this->Cookie->configKey('Long', 'path', '/');
        $this->Cookie->configKey('Long', [
            'expires'  => '+30 days',
            'httpOnly' => true,
        ]);

        if (!empty($_GET['lang'])) {
            $this->request->session()->write('lang', $_GET['lang']);
        }

        if (!empty($_GET['clickid'])) {
            $this->request->session()->write('clickid', $_GET['clickid']);
            $this->Cookie->write('Long.clickid', $_GET['clickid']);

        }

        if (!empty($_GET['ref'])) {
            $userId = Crypt::dcrypt($_GET['ref']);
            if (!empty($userId)) {
                $this->request->session()->write('refUser', $userId);
                $this->Cookie->write('Long.refUser', $userId);
            }
        }

        if (!empty($this->Cookie->read('Long.clickid'))) {
            $this->request->session()->write('clickid', $this->Cookie->read('Long.clickid'));
        }

        if (!empty($_GET['esub'])) {
            $this->request->session()->write('clickid', $_GET['esub']);
        }

        if (!empty($this->request->session()->read('clickid'))) {
            $this->clickId = $this->request->session()->read('clickid');
        }


        Time::setToStringFormat('yyyy-MM-dd HH:mm:ss');  // For any mutable DateTime
        FrozenTime::setToStringFormat('yyyy-MM-dd HH:mm:ss');  // For any immutable DateTime
        Date::setToStringFormat('yyyy-MM-dd');  // For any mutable Date
        FrozenDate::setToStringFormat('yyyy-MM-dd');  // For any immutable Date

        $this->loadComponent('Flash');
        $this->request->session()->options(['session.name' => 'PHPSESSID']);

        $this->appName = Configure::read('App.appName');

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
            //$this->IndianAuth->allow(['checkEmail'], 'all');
            //$this->IndianAuth->allow(['login', 'logout', 'register', 'restore', 'checkEmail', 'changeLang'], 'all');
            $this->set('IndianAuth', $this->IndianAuth);
        }
    }

    public function index()
    {
        $this->redirect(['action' => 'login']);
    }


    protected function connectAPI(){
        require_once('Api/V1/php/NodeRPC.php');
        require_once('Api/V1/php/EcmaSmartRPC.php');
        try {
            $izNode = new \EcmaSmartRPC(Configure::read('Api.host'), Configure::read('Api.pass'));
        } catch (\Exception $e) {
            $result['msg'] = $e->getMessage();
        }
    }
    /**
     * Change selected language
     */
    public function changeLang()
    {
        if (!empty($this->request->params['pass'][0])) {
            $lang = substr($this->request->params['pass'][0], 0, 3);
            $this->request->session()->write('lang', $lang);
        }
        $this->redirect('/');
    }

    /**
     * Автоматически прописывает свойства title, name, description, canonical, если они есть в свойстве $_pagesInfo
     *
     * @return void
     * */
    protected function _setPageInfo()
    {
        $action = $this->request->param('action');
        if (empty($action) || empty($this->_pagesInfo[$action])) {
            return;
        }
        foreach (['title', 'name', 'description', 'canonical'] as $infoName) {
            if (!empty($this->_pagesInfo[$action][$infoName])) {
                $this->{'meta' . ucfirst($infoName)} = $this->_pagesInfo[$action][$infoName];
            }
        }
    }


    /**
     * @param Event $event
     * @return \Cake\Network\Response|null|void
     * @throws \Exception
     */
    public function beforeFilter(Event $event)
    {
        if (!empty($this->request->data('_CSRF'))) {
            if (strpos(Crypt::dcrypt($this->request->data('_CSRF')), 'CSRF_') === false) {
                throw new \Exception('Invalid CSRF token');
            }
        }

        I18n::locale('en');
        if (!empty($this->request->session()->read('lang'))) {
            I18n::locale($this->request->session()->read('lang'));
        }
        $langs = (new Folder(ROOT . '/src/Locale'))->read()[0];
        $this->set('langs', $langs);


        $this->_setPageInfo();
        $this->set([
            'metaTitle'       => '',
            'robotsMethod'    => '',
            'metaDescription' => '',
            'metaCanonical'   => '',
            'metaName'        => '',
        ]);


        parent::beforeFilter($event);
    }

    public function beforeRender(Event $event)
    {
        if (!in_array($this->request->controller, ['Required']) && !$this->request->is('ajax')) {
            if ($this->currentUser) {
                if ('0' == $this->currentUser['email']) {
                    return $this->redirect(['controller' => 'required', 'action' => 'email']);
                }
            }
        }

        $this->set('currentUser', $this->currentUser);
        $this->set('metaPropertyCollection', $this->metaPropertyCollection);
        $this->set('schemaSnippetCollection', $this->schemaSnippetCollection);
        $this->set('breadcumbCollection', $this->breadcumbCollection);
        $this->set('robotsMethod', $this->robotsMethod);
        $this->set('metaTitle', $this->metaTitle);
        $this->set('metaName', $this->metaName);
        $this->set('metaDescription', $this->metaDescription);
        $this->set('metaCanonical', $this->metaCanonical);
        $this->set('bodyClass', $this->bodyClass);

        $this->set('crmLeftMenu', $this->crmLeftMenu);
        $this->set('wikiHelpUrl', $this->wikiHelpUrl);

        parent::beforeRender($event);

        if (!empty($this->currentUser)) {
            if ($this->request->session()->read('cake_user.password') !== UsersTable::instance()->get($this->currentUser['id'])->password) {
                $this->request->session()->clear();
                $this->redirect(['action' => 'login']);

                return;
            }
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

        return null;
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


    /**
     * User login
     * @return \Cake\Network\Response|null
     */
    public function login()
    {

        $this->checkCsrf();

        $this->viewBuilder()->layout('ajax')->templatePath('App');

        $accessToken = $this->request->query('accessToken') ? $this->request->query('accessToken') : false;
        $this->set(compact('accessToken'));

        $loginAttemptsByIp = KeyValue::read('BANNED_IP_' . Misc::getIp(), 0);
        if ($loginAttemptsByIp >= self::LOGIN_ATTEMPTS_MAX + 1 || $loginAttemptsByIp === 'banned') {
            $this->Flash->error(__('Your IP in stop list. Please, contact with support.'));

            return $this->redirect(['action' => 'login']);
        }

        if ($this->request->is('post')) {
            if (count($this->request->data) && !empty($this->request->data['email'])) {


                $lastRequestTimestamp = KeyValue::read($this->request->data('email') . '_login', 0);

                if ((time() - $lastRequestTimestamp) < (5)) {
                    $this->Flash->error(__('Try again later'));

                    return $this->redirect(['action' => 'login']);
                }

                KeyValue::write($this->request->data('email') . '_login', time());

                /**
                 * @var User $user
                 */
                $user = UsersTable::f()->where(['email' => $this->request->data['email']])->first();
                if (!empty($user) && (!Configure::read('App.allowAutoverify') && $user->status !== User::STATUS_VERIFIED)) {
                    $this->Flash->error(__('User not verified. Check you email.'));

                    return $this->redirect(['action' => 'login']);
                }

                //MD5 fallback
                if ($user && $user->password === md5($this->request->data['password'])) {
                    $user->password = IndianAuthComponent::makeHash($this->request->data['password']);
                    UsersTable::instance()->save($user);
                }
                //MD5 fallback


                if ($this->IndianAuth->isAuthDataCorrect($this->request->data['email'], $this->request->data['password'])) {
                    $userSettings = UsersSettingsTable::instance()->getAll($user->id);
                    if (!empty($userSettings) && $userSettings['2fa']['enable']) {
                        //записать в сессию уникальный хэш, показать страницу ввода 2f кода
                        $user->otp_hash = Crypt::ecrypt($user->id);
                        UsersTable::instance()->save($user);
                        $this->request->session()->write('otp', $user->otp_hash);
                        $this->request->session()->write('ua', env('HTTP_USER_AGENT'));

                        return $this->redirect(['controller' => 'required', 'action' => 'twoFactorCode']);
                    } else {
                        if ($this->IndianAuth->login($user->id)) {
                            $this->_login_attempt($user->id, true);
                            $redirectUrl = URL_PREFIX . '/' . $this->request->url;
                            if (strstr($redirectUrl, 'login')) {
                                $redirectUrl = ['controller' => 'cabinet', 'action' => 'home'];
                            }

                            $userRole = CurrentUser::get('roles')[0];
                            if (in_array($userRole, [Acl::ROLE_MODERATOR])) {
                                $redirectUrl = ['controller' => 'admin'];
                            }

                            if (in_array($userRole, [Acl::ROLE_SYSTEM])) {
                                if ($this->_notExistAccessToken()) {
                                    $this->Flash->error(__('Access closed.'));
                                    $this->IndianAuth->logout();

                                    return $this->redirect(['action' => 'login']);
                                }
                            }

                            $this->redirect($redirectUrl);
                            $this->request->session()->write('gtmOkLogin', true);

                            KeyValue::write('BANNED_IP_' . Misc::getIp(), 0);

                            return;
                        }
                    }
                } else {

                    if ($loginAttemptsByIp < self::LOGIN_ATTEMPTS_MAX) {
                        KeyValue::write('BANNED_IP_' . Misc::getIp(), $loginAttemptsByIp + 1);
                    }
                    if ($loginAttemptsByIp >= self::LOGIN_ATTEMPTS_MAX) {
                        KeyValue::write('BANNED_IP_' . Misc::getIp(), 'banned');
                        LogTable::write('IP_BAN', [
                            'ip'     => Misc::getIp(),
                            'reason' => 'Banned by: Too many login attempts ' . $loginAttemptsByIp,
                        ]);
                    }


                    if (empty($user)) {
                        /*LogTable::write('LOGIN_NOT_FOUND', [
                            'data'    => $this->request->data,
                            'user'    => $user,
                            'REQUEST' => $_REQUEST,
                            'SERVER'  => $_SERVER,
                        ]);*/
                    } else {
                        $this->_login_attempt($user->id, false);
                    }


                    $this->Flash->error(__('Incorrect email or password'));
                    $this->redirect(['action' => 'login']);

                }
            } else {
                //аутентификация через соцсеть
                $user = $this->Auth->identify();
                if ($user) {
                    $this->Auth->setUser($user);
                    $this->request->session()->write('gtmOkLogin', true);

                    return $this->redirect($this->Auth->redirectUrl());
                }


                $this->Auth->logout();
            }
        }
    }

    /**
     * Check exist access token
     * @return boolean
     */
    private function _notExistAccessToken()
    {
        $res = true;
        if ((!empty($this->request->data['accessToken']) && !empty(Configure::read('App.accessToken'))
            && ($this->request->data['accessToken'] === Configure::read('App.accessToken')))) {
            $res = false;
        }

        return $res;
    }

    /**
     * User registration
     * @param bool $code
     * @return \Cake\Network\Response|null|void
     */
    public function register($code = false)
    {
        $this->viewBuilder()->layout('ajax')->templatePath('App');


        $this->set('email', empty($this->request->query('email')) ? '' :
            htmlentities(strip_tags($this->request->query('email'))));

        if (!empty($code)) {
            $userId = Crypt::dcrypt($code);
            if (!empty($userId)) {
                $userEntity = UsersTable::instance()->get($userId);
                $userEntity->status = User::STATUS_VERIFIED;

                /*if (!empty($this->request->session()->read('refUser'))) {
                    $userEntity->ref_user = $this->request->session()->read('refUser');
                }*/

                if (!UsersTable::instance()->save($userEntity)) {
                    throw new InternalErrorException(__('Ooops! Saving error'));
                }

                $this->Flash->success(__('Account verified. Use you login data for sign in'));

                CPA::confirm($userEntity->clickid, $userEntity->id, $userEntity->ref_user);

                return $this->redirect(['action' => 'login']);
            }
        }

        if (!empty($this->request->data)) {


            //Sleep(1);

            if (!Misc::isValidEmail($this->request->data['email'])) {
                $this->Flash->error(__('Bad email'));

                return;
            }

            if (in_array($this->request->data['email'], ['sample@email.tst'])) {
                $this->Flash->error(__('Password confirmation doesn\'t match Password'));
            }

            if ($this->request->data['password'] !== $this->request->data['passwordRepeat']) {
                $this->Flash->error(__('Password confirmation doesn\'t match Password'));

                return;// $this->redirect('/');
            }
            if (!empty(UsersTable::f()->where(['email' => $this->request->data['email']])->toArray())) {
                $this->Flash->error(__('User with same email already registred'));

                return;// $this->redirect('/');
            }

            if (Configure::read('App.enableSaftDataFilling') && empty($this->request->data['registration_data'])) {
                $this->Flash->error('Fill the SAFT data');

                return;
            }

            $this->request->data['phone'] = empty($this->request->data['phone']) ? '' : $this->request->data['phone'];
            $this->request->data['age'] = empty($this->request->data['age']) ? '' : $this->request->data['age'];
            $this->request->data['country'] = empty($this->request->data['country']) ? '' :
                $this->request->data['country'];

            $this->request->data['registration_data'] = empty($this->request->data['registration_data']) ? null :
                $this->request->data['registration_data'];

            $this->request->data['password'] = IndianAuthComponent::makeHash($this->request->data['password']);
            $user = UsersTable::instance()->newEntity(
                [
                    'email'             => htmlentities(trim($this->request->data['email'])),
                    'password'          => htmlentities($this->request->data['password']),
                    'phone'             => htmlentities($this->request->data['phone']),
                    'age'               => htmlentities($this->request->data['age']),
                    'country'           => htmlentities($this->request->data['country']),
                    'name'              => empty($this->request->data['name']) ? $this->request->data['email'] :
                        htmlentities($this->request->data['name']),
                    'clickid'           => $this->clickId,
                    'status'            => Configure::read('App.allowAutoverify') ? User::STATUS_VERIFIED :
                        User::STATUS_NOTVERIFY,
                    'registration_data' => $this->request->data['registration_data'],
                ]);

            if (!empty($this->request->session()->read('refUser'))) {
                $user->ref_user = $this->request->session()->read('refUser');
            }

            if (!UsersTable::instance()->save($user)) {
                throw new InternalErrorException(__('Saving error' . print_r($user, true)));
            }

            $this->request->session()->write('gtmOkRegister', true);
            CPA::register($this->clickId, $user->id);
            $result = Emails::confirm(trim($this->request->data['email']), $user->id);


            if (Configure::read('App.allowAutoverify')) {
                $this->Flash->success(__('You already registered'));
            } else {
                $this->Flash->success(__('Check you email for verification code'));
            }
            $this->redirect(['action' => 'login']);

            return;// $this->redirect('/');
        }

    }

    /**
     * Restore password
     * @param bool $code
     * @return \Cake\Network\Response|null
     * @throws \Exception
     */
    public function restore($code = false)
    {
        $this->checkCsrf();
        $this->viewBuilder()->layout('ajax')->templatePath('App');
        if (!empty($this->request->data('email'))) {

            $lastRequestTimestamp = KeyValue::read($this->request->data('email') . '_restore', 0);

            if ((time() - $lastRequestTimestamp) < (5 * 60)) {
                $this->Flash->error(__('Try again later'));

                return;
            }

            KeyValue::write($this->request->data('email') . '_restore', time());

            //Sleep(1);

            if (strpos($this->request->data['email'], '@') === false) {
                $this->Flash->error(__('Bad email'));

                return;
            }


            $user = UsersTable::f()->where(['email' => $this->request->data('email')])->first();
            if (!empty($user) && $user->status !== User::STATUS_NOTVERIFY) {
                $result = Emails::restore($this->request->data['email'], $user->id);
            }

            $this->Flash->success(__('Restore code sended to Email'));
        }

        if (!empty($code)) {
            $codeData = Misc::parseRestoreCode($code);
            if (time() > $codeData['t']) {
                $this->Flash->error(__('Link expired'));

                return $this->redirect(['action' => 'login']);
            }
            $userId = $codeData['id'];
            if (!empty($userId)) {
                $newPass = Misc::generatePassword();
                $userEntity = UsersTable::instance()->get($userId);
                $userEntity->password = IndianAuthComponent::makeHash($newPass);
                if (!UsersTable::instance()->save($userEntity)) {
                    throw new InternalErrorException(__('Ooops! Saving error'));
                }

                $result = Emails::password($userEntity->email, $newPass);

                $this->Flash->success(__('We send you new password to email'));

                return $this->redirect(['action' => 'login']);
            }
        }
    }

    /**
     * Выход, что тут еще сказать...
     */
    public function logout()
    {
        $this->IndianAuth->logout();
        $this->Flash->success(__('Goodbye'));

        //return $this->redirect('/');

        return $this->redirect(['controller' => 'app', 'action' => 'login']);
    }

    /**
     * Check email registred
     * @param string $email
     */
    public function checkEmail($email)
    {

        if (!Misc::isValidEmail($email)) {
            $this->sendJsonError(__('Invalid email'));

            return;
        }

        $user = UsersTable::f()->where(['email' => $email])->first();
        if (!empty($user)) {
            $this->sendJsonError(__('User with same email already registred'));

            return;
        }

        $this->sendJsonOk([]);
    }

    public function display()
    {

    }

    /**
     * Проверка на наличие Csrf токена
     * @throws \Exception
     */
    public function checkCsrf()
    {
        if (empty($this->request->data('_CSRF')) && !empty($this->request->data())) {
            throw new \Exception('CSRF token requied');
        }
    }

    /**
     * @throws \Exception
     */
    public function checkRefer()
    {
        if (strpos(strtolower($this->request->referer()), strtolower(BASE_DOMAIN)) === false) {

            $this->redirect('/');

            return false;
        }

        return true;
    }

    /**
     * Save login attempts history
     *
     * @param int $userId
     * @param bool $isSuccessful
     */
    protected function _login_attempt($userId, $isSuccessful)
    {
        if (!isset($userId)) {
            return;
        }

        $loginInfo = KeyValue::read('login_info_' . $userId, []);

        if (count($loginInfo) > 50) {
            array_shift($loginInfo);
        }

        $lastLogin = [
            'user'       => $userId,
            'ip'         => Misc::getIp(),
            'userAgent'  => env('HTTP_USER_AGENT'),
            'successful' => $isSuccessful,
            'date'       => date('Y-m-d H:i:s'),
        ];

        $loginInfo[] = $lastLogin;

        KeyValue::write('login_info_' . $userId, $loginInfo);
        KeyValue::write('last_login_' . $userId, $lastLogin);

        $userEntity = UsersTable::instance()->get($userId);

        CPA::login($userEntity->clickid, $userEntity->id);
    }
}