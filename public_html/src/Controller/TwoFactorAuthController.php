<?php

namespace App\Controller;

use App\Lib\CurrentUser;
use App\Lib\Sandbox;
use App\Model\Table\LogTable;
use App\Model\Table\UsersSettingsTable;
use App\Model\Table\UsersTable;

use Cake\Event\Event;
use Cake\Filesystem\Folder;
use Cake\Core\Configure;

//use Cake\I18n\I18n;
//use Cake\I18n\Time;

use Google\Authenticator\GoogleAuthenticator;
use Google\Authenticator\GoogleQrUrl;

class TwoFactorAuthController extends AppController
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
        $this->viewBuilder()->layout('ajax')->templatePath('Cabinet');

        $this->set('user', false);
        Sandbox::setInternalExternal('Flash', $this->Flash);
        if (!empty(CurrentUser::get('id'))) {
            $user = UsersTable::instance()->get(CurrentUser::get('id'));
            if (!empty($user->clickid)) {
                $this->clickId = $user->clickid;
                $this->request->session()->write('clickid', $user->clickid);
            }
            $this->set('user', $user);
        }
    }

    /**
     * Set two-authentication enable
     */
    public function activate()
    {
        if (!$this->request->session()->check('pass.confirmed')) {
            $this->request->session()->write('return.url', $this->request->here());

            return $this->redirect(
                [
                    'controller' => 'Required',
                    'action'     => 'confirmPass',
                ]
            );
        }

        $this->viewBuilder()->template('two_factor_auth');
        $id = CurrentUser::get('id');
        $settingsModel = UsersSettingsTable::instance();
        $setting2fa = $settingsModel->getByBlock($id, '2fa');
        if ($this->request->is('post') && !empty($this->request->data)) {
            $codeFromApp = isset($this->request->data['code_app']) ? $this->request->data['code_app'] : null;
            if (!$codeFromApp) {
                $this->Flash->error(__('Please, input code from app for continue.'));

                return $this->redirect($this->request->here);
            }

            //Check if the submitted token is the right one
            if (!$this->_compareCodes($setting2fa['code'], $codeFromApp)) {
                //OTP is wrong, tell the user to try again
                $this->Flash->error(__('Code wrong. Try again with new correct code.'));

                return $this->redirect($this->request->here);
            }
            if ($settingsModel->updateAll(
                [
                    'value' => 1,
                ],
                [
                    'user_id' => $id,
                    'block'   => '2fa',
                    'name'    => 'enable',
                ])
            ) {
                $this->request->session()->delete('pass.confirmed');
                $this->Flash->success(__('Two-factor Authentication successfully enabled.'));

                LogTable::write('2FA_ENABLED', [], $id);

                return $this->redirect(['controller' => 'cabinet', 'action' => 'home']);
            } else {
                $this->Flash->error(__('Error while activating two-factor authentication. Please contact us.'));

                return $this->redirect($this->request->here);
            }
        }

        $secret = $setting2fa['code'];

        if (!$secret) {
            $this->loadComponent('TwoFactorAuth');
            $secret = $this->TwoFactorAuth->generateSecret();
            if (!$settingsModel->updateAll(
                [
                    'value' => $secret,
                ],
                [
                    'user_id' => $id,
                    'block'   => '2fa',
                    'name'    => 'code',
                ])
            ) {
                throw  new \Exception('Update 2fa code error. U: ' . $id);
            }
        }
        $config = Configure::read('App');
        $link = GoogleQrUrl::generate($this->currentUser['name'], $secret, $config['baseDomain']);
        $this->set('code_qr_link', $link);
        $this->set('code_text', $secret);
    }

    /**
     * Set two-authentication disabled
     */
    public function deactivate()
    {
        if (!$this->request->session()->check('pass.confirmed')) {
            $this->request->session()->write('return.url', $this->request->here());

            return $this->redirect(
                [
                    'controller' => 'Required',
                    'action'     => 'confirmPass',
                ]
            );
        }
        $id = CurrentUser::get('id');
        $settingsModel = UsersSettingsTable::instance();
        if ($settingsModel->updateAll(
                [
                    'value' => null,
                ],
                [
                    'user_id' => $id,
                    'block'   => '2fa',
                    'name'    => 'enable',
                ])
            &&
            $settingsModel->updateAll(
                [
                    'value' => null,
                ],
                [
                    'user_id' => $id,
                    'block'   => '2fa',
                    'name'    => 'code',
                ])
        ) {
            $this->request->session()->delete('pass.confirmed');
            $this->Flash->success(__('Two-factor Authentication successfully disabled.'));
            LogTable::write('2FA_DISABLED', [], $id);
        } else {
            $this->Flash->error(__('Error while deactivating two-factor authentication. Please contact us.'));
        }

        return $this->redirect(['controller' => 'cabinet', 'action' => 'home']);
    }

    /*
     * Check 2f code getted from user
     * @param integer
     * @param string
     * @return bool
     */
    public function isOTPCorrect($userId = false, $otpCode = false)
    {
        $res = false;
        if ($userId && $otpCode) {
            $settingsModel = UsersSettingsTable::instance();
            $setting2fa = $settingsModel->getByBlock($userId, '2fa');
            $res = $this->_compareCodes($setting2fa['code'], $otpCode);
        }

        return $res;
    }

    /**
     * Compare two codes: from users and from db
     * @param string
     * @param string
     * @return bool
     */
    private function _compareCodes($codeDb, $codeUser)
    {
        $res = false;
        $g = new \Google\Authenticator\GoogleAuthenticator();
        if ($g->checkCode($codeDb, $codeUser)) {
            $res = true;
        }

        return $res;
    }
}