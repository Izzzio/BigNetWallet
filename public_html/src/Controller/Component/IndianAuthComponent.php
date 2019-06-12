<?php

namespace App\Controller\Component;

use App\Controller\AppController;
use App\Lib\CurrentUser;
use App\Model\Table\VtigerGroupsTable;
use App\Model\Table\VtigerLoginhistoryTable;
use App\Model\Table\VtigerUsersTable;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\Core\Exception\Exception;
use Cake\Utility\Security;

class IndianAuthComponent extends Component
{
    const LEFT_APP_ID = 1;// VTIGERCRM_APP_ID;

    /**
     * Разрешён анонимный доступ
     */
    const PERMISSION_ALL = 'all';
    /**
     * Доступ для всех авторизованных
     */
    const PERMISSION_AUTH = 'auth';
    /**
     * Доступ ко всем методам контроллера
     */
    const ACTIONS_ALL = 'all';

    /**
     * Объект сессии
     *
     * @var Session|null
     */
    private $_session = null;

    /**
     * Информация о юзере
     *
     * @var array
     */
    private $_currentUser = [];

    /**
     * Разрешённые экшны
     *
     * @var array
     */
    private $_allowedActions = [
        'login'  => self::PERMISSION_ALL,
        'logout' => self::PERMISSION_ALL,
        'register'   => self::PERMISSION_ALL,
        'test'   => self::PERMISSION_ALL,
        'restore'   => self::PERMISSION_ALL,
    ];

    /** @inheritdoc */
    public function initialize(array $config)
    {
        $controller = $this->_registry->getController();
        $this->_session = $controller->request->session();
        parent::initialize($config);
    }

    /**
     * @inheritdoc
     * Проверки, что юзеру можно в этот экшн
     */
    public function startup(Event $event)
    {
        /** @var AppController $controller */
        $controller = $event->subject();

        $action = strtolower($controller->request->params['action']);
        if (!defined('INDIAN_AUTH_TEST') && !$controller->isAction($action)) {
            return;
        }

        $currentUserId = $this->_session->read('authenticated_user_id');
        $appUniqueKey = $this->_session->read('app_unique_key');
        $currentUser = $this->_session->read('cake_user');

        if ($currentUserId === null || $appUniqueKey != IndianAuthComponent::LEFT_APP_ID) { // юзер не авторизирован
            $currentUser = false;
        } elseif (!$currentUser || ($currentUser['id'] != $currentUserId)) {
            $currentUser = $this->_buildUserSession($currentUserId);
        }/* elseif ($currentUser['login_time'] > $currentUser['reset_time']) {// автовыход
			$this->logout();
			return $controller->redirect('/' . $controller->request->url);
		}*/

        $this->_setCurrentUser($currentUser);

        if (!$this->_isAllowed($controller)) {
            if (!defined('INDIAN_AUTH_TEST') && !empty($this->_currentUser)) {
                $controller->Flash->error(__('Access closed.'));
            }

            return $controller->setAction('login');
        }
    }

    /**
     * Возвращает текущего юзера
     *
     * @return array
     */
    public function getUser()
    {
        return $this->_currentUser;
    }

    /**
     * Логаут
     */
    public function logout()
    {
        $userId = $this->_session->read('authenticated_user_id');
        if ($userId > 0) {
            /*$loginHistoryTable = TableRegistry::get('VtigerLoginhistory');
            $lastLoginRecord = $loginHistoryTable->find()
                ->contain('VtigerUsers')
                ->where(['VtigerUsers.id' => $userId])
                ->orderDesc('login_id')
                ->first();
            if ($lastLoginRecord) {
                $lastLoginRecord->logout_time = date('Y-m-d H:i:s');
                $lastLoginRecord->status = 'Signed off';
                $loginHistoryTable->save($lastLoginRecord);
            }*/
        }
        $this->_session->delete('app_unique_key');
        $this->_session->delete('authenticated_user_id');
        $this->_session->delete('cake_user');
        $this->_emptyCurrentUser();
    }

    /**
     * Makes salted password
     * @param string $password
     * @return string
     */
    public static function makeHash($password)
    {
        $salt = Security::salt();

        return md5($salt . md5($password . $salt));
    }

    /**
     * Логин
     *
     * @param string $login
     * @param string $password
     * @return bool|null|string
     */
    public function login($userId = 0)
    {
        $this->_buildUserSession($userId, true, false);
        $currentUser = $this->_session->read('cake_user');
        $this->_setCurrentUser($currentUser);

        return $currentUser;
    }


    public function isAuthDataCorrect($login, $password)
    {
        if ($this->_session->read('authenticated_user_id') !== null) { // если был авторищирован до этого, то убиваем старье
            $this->_session->delete('app_unique_key');
            $this->_session->delete('authenticated_user_id');
            $this->_emptyCurrentUser();
        }

        $usersTable = TableRegistry::get('Users');
        $userInfo = $usersTable->find()
            ->where([
                'OR' => [
                    'email' => $login,
                ],
            ])
            ->first();
        if (!$userInfo) {
            return false;
        }
        if ($login != $userInfo->barcode || empty($userInfo->barcode)) {
            if (self::makeHash($password) != $userInfo->password) {
                // не совпал пароль
                return false;
            }
        }
        return true;
    }

    /**
     * Логин через соцсети
     *
     * @return bool|null|array
     */
    public function loginSocial(){
        $userId = $this->_session->read('authenticated_user_id');
        $currentUser = $this->updateUserSession($userId);
        return $currentUser;
    }

    public function updateCurrentUser(){
        $currentUser = null;
        $userId = $this->_session->read('authenticated_user_id');
        $userId = intval($userId);
        if($userId > 0){
            $currentUser = $this->updateUserSession($userId);
        }
        return $currentUser;
    }

    /**
     * Обновление данных сесси пользователя, залогиненного в текущий момент
     *
     * @param int $userId
     * @return bool|null|array
     */
    private function updateUserSession($userId = null){
        if ($userId && $userId == $this->_session->read('authenticated_user_id')) { // если был авторищирован до этого, то убиваем старье
            $this->_session->delete('app_unique_key');
            $this->_session->delete('authenticated_user_id');
            $this->_emptyCurrentUser();
        }
        $this->_buildUserSession($userId, true, false);
        $currentUser = $this->_session->read('cake_user');
        $this->_setCurrentUser($currentUser);

        return $currentUser;
    }

    /**
     * Составить массив сессии
     *
     * @param int $userId
     * @param bool $fullBuild
     * @param bool $reincarnation
     * @return bool
     */
    private
    function _buildUserSession($userId, $fullBuild = false, $reincarnation = false)
    {
        $usersTable = TableRegistry::get('Users');

        // инфа по юзеру
        $userInfo = $usersTable->find()
            ->hydrate(false)
            ->where([
                'id' => $userId,
                //'status' => 'active'
            ])
            ->first();
        if (!$userInfo) {
            $this->_session->delete('app_unique_key');
            $this->_session->delete('authenticated_user_id');

            return false;
        }

        $userInfo['login_time'] = date('Y-m-d H:i:s');

        $this->_session->write('cake_user', $userInfo);
        if ($fullBuild) {
            $this->_session->write('authenticated_user_id', $userId);
            $this->_session->write('app_unique_key', IndianAuthComponent::LEFT_APP_ID);
            $this->_session->write('authenticated_user_language', 'ru_ru');
            //$this->_session->write('vtiger_authenticated_user_theme', 'softed');
            //$this->_session->write('VTIGER_DB_VERSION', '5.4.0-201211');
            $this->_session->write('internal_mailer', 1);
        }

        return $userInfo;
    }

    /**
     * Checks whether current action is accessible without authentication.
     *
     * @param \Cake\Controller\Controller $controller A reference to the instantiating
     *   controller object
     * @return bool True if action is accessible without authentication else false
     */
    private
    function _isAllowed(Controller $controller)
    {
        $action = $controller->request->params['action'];
        if (!isset($this->_allowedActions[$action])) {
            return !empty($this->_currentUser); // дефолтовое правило - только авторизированный
        }

        $perms = $this->_allowedActions[$action];

        if (!is_array($perms)) {
            return ($perms == self::PERMISSION_ALL)
                || (($perms == self::PERMISSION_AUTH) && !empty($this->_currentUser));
        }
        if (empty($this->_currentUser)) {
            return false;
        }

        if (isset($perms['group']) && count(array_intersect($this->_currentUser['groups'], $perms['group']))) {
            return true;
        }
        if (isset($perms['role']) && count(array_intersect($this->_currentUser['roles'], $perms['role']))) {
            return true;
        }

        if (isset($perms['tabPermission']) && isset($this->_currentUser['tabPermissions'][$perms['tabPermission']])
            && $this->_currentUser['tabPermissions'][$perms['tabPermission']][$perms['action']] == true
        ) {
            return true;
        }

        return false;
    }

    /**
     * Разрешаем доступ. Возможные варианты permission:
     * - all - доступ всем авторозированным + анонимным
     * - auth - доступ только всем авторизированным
     * - ['group' => $groupList] $groupList - список доступных групп, либо одна группа (можно просто строкой, а не
     * массивом)
     * - ['role' => $roleList] то же самое, но с ролями
     * - ['tabPermission' => $moduleName, 'action' => $actionName] $moduleName - модуль, $actionName - соответственно
     * action. Может быть следующих видов: create, delete, view
     *
     * @param array|string|null $actions
     * @param array|string $permission
     */
    public
    function allow($actions, $permission)
    {
        $hasPermissions = array_intersect_key((array)$permission, ['tabPermission' => 1, 'group' => 1, 'role' => 1]);
        if (!in_array($permission, [self::PERMISSION_ALL, self::PERMISSION_AUTH]) && empty($hasPermissions)) {
            throw new Exception('Bad permission');
        }

        if (is_array($permission)) {
            if (isset($permission['tabPermission']) && (!isset($permission['action']) || !in_array($permission['action'], [
                        'create',
                        'delete',
                        'view',
                    ]))
            ) {
                throw new Exception('Bad tabPermission action');
            }

            if (!empty($permission['group'])) {
                $permission['group'] = (array)$permission['group'];
            }
            if (!empty($permission['role'])) {
                $permission['role'] = (array)$permission['role'];
            }
        }

        if ($actions === null || $actions === self::ACTIONS_ALL) {
            $controller = $this->_registry->getController();
            $actions = get_class_methods($controller);
        } else {
            if (!is_array($actions)) {
                $actions = [$actions];
            }
        }

        foreach ($actions as $act) {
            $this->_allowedActions[$act] = $permission;
        }
    }

    /**
     * Разрешен ли доступ к определенной группе/группам
     *
     * @param string|array $groupName
     * @return bool
     */
    public
    function isGroupAllowed($groupName)
    {
        if (!$this->_currentUser) {
            return false;
        }

        if (!is_array($groupName)) {
            return in_array($groupName, $this->_currentUser['groups']);
        } else {
            foreach ($groupName as $gr) {
                if (in_array($gr, $this->_currentUser['groups'])) {
                    return true;
                }
            }

            return false;
        }
    }

    /**
     * Разрешен ли доступ к определенной роли/ролям
     *
     * @param string|array $roleName
     * @return bool
     */
    public
    function isRoleAllowed($roleName)
    {
        if (empty($this->_currentUser)) {
            return false;
        }
        $hasRoles = array_intersect($this->_currentUser['roles'], (array)$roleName);

        return !empty($hasRoles);
    }

    /**
     * Резрешен ли доступ к определенному действию в модуле/модулях
     *
     * @param string|array $tabName
     * @param string|bool $actionName
     * @return bool
     */
    public
    function isTabPermissionAllowed($tabName, $actionName = false)
    {
        if (!$actionName) {
            $actionName = 'view';
        }

        if (!$this->_currentUser) {
            return false;
        }

        if (!is_array($tabName)) {
            if (!isset($this->_currentUser['tabPermissions'][$tabName]) || !isset($this->_currentUser['tabPermissions'][$tabName][$actionName])) {
                return false;
            } else {
                return $this->_currentUser['tabPermissions'][$tabName][$actionName];
            }
        } else {
            foreach ($tabName as $tab) {
                if (isset($this->_currentUser['tabPermissions'][$tab]) && isset($this->_currentUser['tabPermissions'][$tab][$actionName]) && $this->_currentUser['tabPermissions'][$tab][$actionName] == true) {
                    return true;
                }
            }

            return false;
        }
    }

    /**
     * Запоминаем текущего юзера в разных местах
     *
     * @param array $currentUser
     */
    private
    function _setCurrentUser($currentUser)
    {
        if($currentUser){
            $currentUser['roles'] = isset($currentUser['roles']) ? [$currentUser['roles']] : ['USER'];
        }

        $this->_currentUser = $currentUser;
        $this->_registry->getController()->currentUser = $currentUser;
        CurrentUser::set($currentUser);
    }

    /**
     * Учистим все переменные
     */
    private
    function _emptyCurrentUser()
    {
        $this->_setCurrentUser([]);
    }
}