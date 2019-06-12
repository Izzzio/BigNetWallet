<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\Log\Log;

class AclController extends AppController
{

    const ROLE_SYSTEM = 'SYSTEM';
    const ROLE_ADMIN = 'ADMIN';
    const ROLE_MODERATOR = 'MODERATOR';
    const ROLE_ANALYST = 'ANALYST';
    const ROLE_USER = 'USER';

    /** @inheritdoc */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    /*
     * Проверяет: имеет ли роль доступ к контроллеру/методу
     */
    public static function havePermission($controller = '', $action = '')
    {
        $res = false;

        $controller = mb_strtolower($controller);

        if (empty($controller) || 'pages' == $controller) {
            $res = true;
        } else {
            $userRole = isset($_SESSION['cake_user']['roles']) ? $_SESSION['cake_user']['roles'] : '';
            switch ($userRole) {
                case self::ROLE_SYSTEM:
                    $actionsAllowed = self::getActionsSystem();
                    break;
                case self::ROLE_ADMIN:
                    $actionsAllowed = self::getActionsAdmin();
                    break;
                case self::ROLE_MODERATOR:
                    $actionsAllowed = self::getActionsModerator();
                    break;
                case self::ROLE_ANALYST:
                    $actionsAllowed = self::getActionsAnalyst();
                    break;
                case self::ROLE_USER:
                    $actionsAllowed = self::getActionsUser();
                    break;
                default:
                    $actionsAllowed = self::getActionsDefault();
            }

            if (isset($actionsAllowed['all'])) {
                $res = true;
            } else if (isset($actionsAllowed[$controller])) {
                if (in_array($action, $actionsAllowed[$controller]) || in_array('all', $actionsAllowed[$controller])) {
                    $res = true;
                }
                if(in_array($action, ['img', 'images'])){
                    $res = true;
                }
            }
        }

        if (!$res) {
            Log::error('FORBIDDEN: ' . $controller . ' --- ' . $action);
        }

        return $res;
    }

    /*
     * Возвращает массив допустимых действий для пользователя с ролью "система"
     */
    private static function getActionsSystem()
    {
        return [
            'all' => [
                'all',
            ],
        ];
    }

    /*
     * Возвращает массив допустимых действий для пользователя с ролью "администратор"
     */
    private static function getActionsAdmin()
    {
        return [
            'app' => [
                'logout',
            ],
            'admin' => [
                'all'
            ],
            'cabinet' => [
                'all'
            ],
            'twofactorauth' => [
                'all'
            ],
            'kyc' => [
                'all',
            ],
            'required' => [
                'all'
            ],
        ];
    }

    /*
     * Возвращает массив допустимых действий для пользователя с ролью "модератор"
     */
    private static function getActionsModerator()
    {
        return [
            'app' => [
                'logout',
            ],
            'admin' => [
                'index',
                'users',
                'user',
                'transact',
                'transactTokens',
                'withdrawTokens',
                'confirmUser',
                'confirmKYC',
                'disable2FA',
                'getUserFile',
                'sendConfirmationEmail',
                'userExport',
                'transactions',
                'transaction',
                'transactionsstats',
                'tranasctionsExport',
            ],
        ];
    }

    /*
     * Возвращает массив допустимых действий для пользователя с ролью "аналитик"
     */
    private static function getActionsAnalyst()
    {
        return [
            'app' => [
                'logout',
            ],
            'cabinet' => [
                'index',
                'home',
                'calcToken2Money',
                'changeLang',
            ],
            'admin' => [
                'index',
                'transactions',
                'transaction',
                'transactionsstats',
                'tranasctionsExport',
            ],
        ];
    }

    /*
     * Возвращает массив допустимых действий для пользователя с ролью "пользователь"
     */
    private static function getActionsUser()
    {
        return [
            'app' => [
                'login',
                'logout',
            ],
            'cabinet' => [
                'index',
                'home',
                'profile',
                'calcToken2Money',
                'generateTransaction',
                'editWallet',
                'buyTokens',
                'changeLang',
            ],
            'twofactorauth' => [
                'activate',
                'deactivate',
                'isOTPCorrect',
            ],
            'kyc' => [
                'pass',
            ],
            'required' => [
                'email',
                'confirmPass',
                'twoFactorCode',
                'login',
            ],
        ];
    }

    /*
     * Возвращает массив допустимых действий для незалогиненного пользователя
     */
    private static function getActionsDefault()
    {
        return [
            'app' => [
                'login',
                'register',
                'restore',
                'checkEmail',
            ],
            'cabinet' => [
                'index',
                'home',
                'ref',
                'changeLang',
            ],
            'kyc' => [
                'result',
            ],
            'payment' => [
                'process',
            ],
            'required' => [
                'twoFactorCode',
                'login',
            ],
            'api'       => [
                'bots',
            ]
        ];
    }

    /*
     * Страница, на которую необходимо перенаправить, если доступ для роли запрещён.
     */
    public static function getRoleHomePage()
    {
        $userRole = isset($_SESSION['cake_user']['roles']) ? $_SESSION['cake_user']['roles'] : '';
        switch ($userRole) {
            case self::ROLE_SYSTEM:
            case self::ROLE_ADMIN:
            case self::ROLE_MODERATOR:
                $page = 'admin';
                break;
            case self::ROLE_ANALYST:
            case self::ROLE_USER:
                $page = 'cabinet';
                break;
            default:
                $page = 'app';
        }
        return $page;
    }

    /*
     * Проверка: входит ли группа пользователя в массив разрешённых групп
     */
    public static function isUserRole($roles = [])
    {
        $result = false;
        $userRole = isset($_SESSION['cake_user']['roles']) ? $_SESSION['cake_user']['roles'] : '';
        if (is_array($roles) && count($roles)) {
            {
                foreach ($roles as $key => $role) {
                    if (constant('self::' . $role) == $userRole) {
                        $result = true;
                        break;
                    }
                }
            }
        }

        return $result;
    }

    /*
     * Проверка: НЕ входит ли группа пользователя в массив запрещённых групп
     */
    public static function isNotUserRole($forbiddenRoles = [])
    {
        return self::isUserRole($forbiddenRoles) ? false : true;
    }

    public static function getRoles()
    {
        $allRoles = [
            self::ROLE_ADMIN,
            self::ROLE_ANALYST,
            self::ROLE_MODERATOR,
            self::ROLE_SYSTEM,
            self::ROLE_USER,
        ];
        return array_combine($allRoles, $allRoles);
    }
}