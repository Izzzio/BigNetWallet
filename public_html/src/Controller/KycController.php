<?php

namespace App\Controller;

use App\Lib\Emails;
use App\Lib\Sandbox;
use App\Lib\KYC;
use App\Lib\Misc;
use App\Model\Entity\KycAttempts;
use App\Model\Table\CountriesTable;
use App\Model\Table\KycAttemptsTable;
use App\Model\Table\LogTable;
use App\Model\Table\UsersTable;

use Cake\Event\Event;
use Cake\Filesystem\Folder;

use Cake\Core\Configure;
use Cake\Log\Log;

class KycController extends AppController
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

        $this->IndianAuth->allow(['result'], 'all');
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
        $this->viewBuilder()->layout('ajax');

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
     * Start online verification
     */
    public function pass()
    {
        $KYCConfig = $this->getConfig();
        KYC::init($KYCConfig);
        $KYCUserId = KYC::createUserId($this->currentUser['email'], $this->currentUser['created']);

        $addNewAttempt = false;
        $attemptExisted = KycAttemptsTable::instance()->findLastAttempt($this->currentUser['id'], $KYCUserId);
        if ($attemptExisted) {
            $applicant['data'] = $attemptExisted->applicant_id;
            if ($attemptExisted->finish) {
                $addNewAttempt = true;
            }
        } else {
            $addNewAttempt = true;
            $applicant = KYC::createApplicantId(BASE_DOMAIN, $KYCUserId);
            if (!$applicant['success']) {
                Log::write('error', 'KYC: error create applicant id for ' . $KYCUserId . '; ' . $applicant['data']);
                $this->Flash->error(__('Unable to start identification. Please contact us.'));
                $this->redirect(['controller' => 'cabinet', 'action' => 'home']);

                return;
            }
        }

        if ($addNewAttempt) {
            $attemptNew = KycAttemptsTable::instance()->newEntity([
                'user_id'      => $this->currentUser['id'],
                'kyc_user_id'  => $KYCUserId,
                'applicant_id' => $applicant['data'],
            ]);
            if (!KycAttemptsTable::instance()->save($attemptNew)) {
                Log::write('error', 'KYC: new attempt saving error ' . print_r($attemptNew, true));
                $this->Flash->error(__('Unable to start identification. Please contact us.'));
                $this->redirect(['controller' => 'cabinet', 'action' => 'home']);

                return;
            }
        }

        $accessToken = KYC::createAccessToken($KYCUserId);

        $this->set('applicantId', $applicant['data']);
        $this->set('accessToken', $accessToken);
        $this->set('url', $KYCConfig['url']);
        $this->set('userId', $KYCUserId);
    }

    /*
     * Callback for receive data of result verification
     */
    public function result()
    {
        $this->autoRender = false;

        if (!$this->request->is('post') || !$this->request->input()) {

            return;
        }
        $originRes = $this->request->input();
        $verifyRes = json_decode($originRes, true);

        LogTable::write('KYC_RESPONSE', $originRes);

        try {
            $sign = hash_hmac('sha1', $originRes, Configure::read('KYC.keySign'));
            if ($sign !== $this->request->query('digest')) {
                Log::write('error', 'KYC: signatures not exist OR do not match.' . print_r($verifyRes, true));

                return;
            }

            if ('INSPECTION_REVIEW_COMPLETED' != $verifyRes['type']) {
                //любой другой тип не интересен, т.к. не даёт информации о результате проверки личности

                return;
            }

            $applicantId = $verifyRes['applicantId'];
            $KYCUserId = $verifyRes['externalUserId'];
            /**
             * @var KycAttempts $KYCAttempt
             */
            $KYCAttempt = KycAttemptsTable::f()->where([
                'kyc_user_id'  => $KYCUserId,
                'applicant_id' => $applicantId,
                'finish IS'    => null,
            ])->first();
            if (!$KYCAttempt) {
                Log::write('error', 'KYC: not exist not finished attempt record.' . print_r($verifyRes, true));

                return;
            }

            $finish = date('Y-m-d H:i:s');
            KycAttemptsTable::instance()->updateAll(
                [
                    'result'  => $originRes,
                    'comment' => $verifyRes['review']['moderationComment'] . ' ' . $verifyRes['review']['clientComment'],
                    'finish'  => $finish,
                ],
                [
                    'kyc_user_id'  => $KYCUserId,
                    'applicant_id' => $applicantId,
                    'finish IS'    => null,
                ]
            );

            if ('GREEN' === $verifyRes['review']['reviewAnswer']) {
                //идентификация прошла успешно =>
                //получение информации, которую вводил и загружал пользователь при прохождении
                $KYCConfig = $this->getConfig();
                KYC::init($KYCConfig);
                $verifiedData = KYC::getVerifiedData($applicantId);

                LogTable::write('KYC_VERIFY_DATA', $verifiedData, $KYCAttempt->user_id);

                $dataUpdate = [
                    'kyc_reached' => true,
                ];

                $verifiedData = json_decode($verifiedData, true);
                $info = [];

                if (isset($verifiedData['list']['items'][0]['info'])) {
                    $info = $verifiedData['list']['items'][0]['info'];
                }

                $firstName = isset($info['firstName']) ? $info['firstName'] : '';
                $lastName = isset($info['lastName']) ? $info['lastName'] : '';
                $dateOfBirthday = isset($info['dob']) ? $info['dob'] : null;
                $countryAbbr = isset($info['country']) ? $info['country'] : null;

                if (!empty($firstName) || !empty($lastName)) {
                    $dataUpdate['name'] = $firstName . ' ' . $lastName;
                }

                if ($dateOfBirthday) {
                    $dataUpdate['age'] = Misc::calculateAge($dateOfBirthday);
                }

                if ($countryAbbr) {
                    $dataUpdate['country'] = $countryAbbr;
                    $country = CountriesTable::f()->where(['alpha_3' => $countryAbbr])->first();
                    if ($country) {
                        $dataUpdate['country'] = $country['name_en'];
                    }
                }

                UsersTable::instance()->updateAll(
                    $dataUpdate,
                    [
                        'id' => $KYCAttempt->user_id,
                    ]
                );

                Emails::kycSuccess(UsersTable::instance()->get($KYCAttempt->user_id)->email);
            } else {
                Emails::kycFail(UsersTable::instance()->get($KYCAttempt->user_id)->email, $verifyRes['review']['clientComment']);
            }

        } catch (\Exception $e) {
            Log::write('error', 'KYC attempt error: ' . $e->getMessage() . print_r($verifyRes, true));
        }
    }

    /*
     * Return actual config for KYC
     */
    private function getConfig()
    {
        $config = [
            'verifyAddress' => Configure::read('KYC.verifyAddress'),
        ];
        if (Configure::read('KYC.testing') || Configure::read('KYC.testing') === null) {
            $config['url'] = Configure::read('KYC.test.url');
            $config['key'] = Configure::read('KYC.test.key');
            $config['usa'] = Configure::read('KYC.test.usa');
        } else {
            $config['url'] = Configure::read('KYC.production.url');
            $config['key'] = Configure::read('KYC.production.key');
            $config['usa'] = Configure::read('KYC.production.usa');
        }

        return $config;
    }
}