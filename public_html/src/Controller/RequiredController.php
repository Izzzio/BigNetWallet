<?php

namespace App\Controller;

use App\Controller\AppController;

use App\Lib\Crypt;
use App\Lib\CurrentUser;
use App\Lib\Sandbox;
use App\Model\Table\UsersTable;

use Cake\Event\Event;

use Cake\Filesystem\Folder;
use Cake\I18n\I18n;
use Cake\I18n\Time;

use App\Controller\TwoFactorAuthController;

class RequiredController extends AppController
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
        $this->viewBuilder()->layout('ajax')->templatePath('Required');

        $this->set('user', false);
        Sandbox::setInternalExternal('Flash', $this->Flash);
        if (!empty($this->currentUser['id'])) {
            $user = UsersTable::instance()->get($this->currentUser['id']);
            if (!empty($user->clickid)) {
                $this->clickId = $user->clickid;
                $this->request->session()->write('clickid', $user->clickid);
            }
            $this->set('user', $user);
        }
    }

    /**
     * Page: required fill email
     */
    public function email()
    {
        if (!empty($this->request->data) && !empty($this->request->data['email'])) {
            if (strpos($this->request->data['email'], '@') === false) {
                $this->Flash->error(__('Bad email'));

                return;
            }
            if (!empty(UsersTable::f()->where(['email' => $this->request->data['email']])->toArray())) {
                $this->Flash->error(__('User with same email already registred'));

                return;
            }

            $newProfileArr = Sandbox::runFromStorageOrIgnore('userEditProfile', [
                'user'   => $this->request->data,
                'userId' => $this->currentUser['id'],
            ]);

            if (is_array($newProfileArr) && !empty($newProfileArr['email'])) {
                $this->request->data = $newProfileArr;
            }

            $userEntity = UsersTable::instance()->get($this->currentUser['id']);

            if (!$userEntity->name) {
                $userEntity->name = $this->request->data['email'];
            }

            $userEntity = UsersTable::instance()->patchEntity($userEntity, $this->request->data);
            if (!UsersTable::instance()->save($userEntity)) {
                $this->Flash->error(__('Internal error. Try again later.'));
                $this->redirect(['action' => 'email']);

                return;
            } else {
                $this->IndianAuth->updateCurrentUser();
                $this->Flash->success(__('Account updated'));
                $this->redirect(['controller' => 'cabinet', 'action' => 'home']);
            }
        }
    }

    public function confirmPass()
    {
        $this->request->session()->delete('pass.confirmed');
        if (empty($this->currentUser['password'])) {
            //ignore if user entered through social network
            return $this->redirect('cabinet/home');
        }

        $returnURL = $this->request->session()->read('return.url');
        if (!$returnURL) {
            $this->request->session()->write('return.url', $this->request->referer());
        }

        if (!empty($this->request->data) && !empty($this->request->data('pass'))) {
            $this->loadComponent('IndianAuth');
            $currPass = $this->IndianAuth->makeHash($this->request->data['pass']);
            $userEntity = UsersTable::instance()->get($this->currentUser['id']);
            if ($userEntity->password !== $currPass) {
                $this->Flash->error(__('Wrong password'));

                return $this->redirect($this->request->here());
            }
            $this->request->session()->write('pass.confirmed', true);

            return $this->redirect($returnURL);
        }
    }

    public function twoFactorCode()
    {
    }

    public function login()
    {
        /*
         * TODO
         * можно будет переписать, если понадобится использовать 2fa не только при логине
         */

        $this->viewBuilder()->template('two_factor_code');

        $otpHash = $this->request->session()->read('otp');
        if (!($otpHash)) {
            return $this->redirect(['controller' => 'cabinet', 'action' => 'home']);
        }
        if (!empty($this->request->data) && !empty($this->request->data('code'))) {
            //получение данных о браузере, для проверки
            $browserUserAgent = htmlentities($this->request->session()->read('ua'));
            if (!$browserUserAgent || $browserUserAgent != env('HTTP_USER_AGENT')) {
                $this->Flash->error(__('Code wrong. Try login again.'));

                return $this->redirect(['controller' => 'app', 'action' => 'login']);
            }
            if (!$user = UsersTable::f()->where(['id' => Crypt::dcrypt($otpHash)])->first()) {
                $this->Flash->error(__('User not exist.'.$otpHash));

                return $this->redirect(['controller' => 'app', 'action' => 'login']);
            }
            $otpCode = htmlentities($this->request->data('code'));
            $TwoFactorAuth = new TwoFactorAuthController();
            if ($TwoFactorAuth->isOTPCorrect($user->id, $otpCode)) {
                $this->request->session()->delete('otp');
                $this->request->session()->delete('ua');
                if (!$this->IndianAuth->login($user->id)) {
                    $this->_login_attempt($user->id, false);
                    $this->Flash->error(__('Login error. Try again later.'));
                } else {
                    $this->request->session()->write('gtmOkLogin', true);
                }

                return $this->redirect(['controller' => 'cabinet', 'action' => 'home']);
            }
            $this->_login_attempt($user->id, false);
            $this->Flash->error(__('Code wrong. Try again letter with new correct code.'));

            return $this->redirect($this->request->here);
        }
    }
}