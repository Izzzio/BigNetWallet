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
use App\Lib\Calculator;
use App\Lib\CBRF;
use App\Lib\CPA;
use App\Lib\CoinMarketCap;
use App\Lib\Crypt;
use App\Lib\CurrentUser;
use App\Lib\KeyValue;
use App\Lib\Misc;
use App\Lib\Payments\CoinPayments;
use App\Lib\Payments\Payment;
use App\Lib\Referal;
use App\Lib\Sandbox;

use App\Model\Table\KycAttemptsTable;
use App\Model\Table\LogTable;
use App\Model\Table\TransactionsTable;
use App\Model\Table\UsersSettingsTable;
use App\Model\Table\UsersTable;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Event\Event;

use App\Lib\Email;
use Cake\Filesystem\Folder;
use Cake\I18n\I18n;
use Cake\I18n\Time;

use RuntimeException;


class CabinetController extends AppController
{

    /** @inheritdoc */
    public function beforeFilter(Event $event)
    {
        $langs = (new Folder(ROOT . '/src/Locale'))->read()[0];
        $this->set('langs', $langs);
        parent::beforeFilter($event);

        $this->IndianAuth->allow(['index', 'ref', 'getCrowdsaleData'], $this->IndianAuth::PERMISSION_ALL);

        if (!empty($this->Cookie->read('Long.refUser'))) {
            $this->request->session()->write('refUser', $this->Cookie->read('Long.refUser'));
        }

    }

    /** @inheritdoc */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        $this->set('user', false);
        Sandbox::setInternalExternal('Flash', $this->Flash);

        try {
            if (!$this->currentUser) {
                //проверить: возможно есть логин через соц. сеть
                $this->loadComponent('Auth', [
                    'authenticate'  => [
                        'Form',
                        'ADmad/HybridAuth.HybridAuth' => [
                            // All keys shown below are defaults
                            'fields' => [
                                'provider'          => 'provider',
                                'openid_identifier' => 'openid_identifier',
                                'email'             => 'email',
                            ],

                            'profileModel'        => 'ADmad/HybridAuth.SocialProfiles',
                            'profileModelFkField' => 'user_id',

                            'userModel' => 'Users',

                            // The URL Hybridauth lib should redirect to after authentication.
                            // If no value is specified you are redirect to this plugin's
                            // HybridAuthController::authenticated() which handles persisting
                            // user info to AuthComponent and redirection.

                            'hauth_return_to' => 'cabinet2'
                            //'hauth_return_to' => null,
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
                $user = $this->Auth->identify();
                if ($user) {
                    $this->request->session()->write('authenticated_user_id', $user['id']);
                    $this->IndianAuth->loginSocial();

                    return $this->redirect($this->request->here());
                }
            }
        } catch (RuntimeException $e) {
            return $this->redirect($this->request->here);
        }


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
     * Cabinet home
     */
    public function home()
    {
        $this->viewBuilder()->layout('ajax');
        $refLink = (empty(URL_PREFIX) ? (BASE_PROTOCOL . '://' . BASE_DOMAIN) :
                URL_PREFIX) . '/cabinet/ref/' . Crypt::ecrypt($this->currentUser['id']);
        $this->set('refLink', $refLink);

        $this->set('refs', Referal::getUserReferals($this->currentUser['id']));
        //$this->Flash->error('Ethereum payments temporarily unavailable. We apologize for the inconvenience. <br> You can make a deposit manually, by contacting us at <a href="mailto:support@bitcoen.zendesk.com">support@bitcoen.zendesk.com</a>');

        //$this->Flash->error('If you have any problems with the bonus, please contact as at <a href="mailto:support@bitcoen.zendesk.com">support@bitcoen.zendesk.com</a>');
        //$this->Flash->error('USD payments temporarily unavailable. We try integrate new exchange.');

        if (Misc::tcfg('currenciesTable')) {
            $this->set('currencies', Misc::getCurrenciesData());
        }

        $KYCLastAttempt = false;
        if (!$this->currentUser['kyc_reached']) {
            $KYCLastAttempt = KycAttemptsTable
                ::f()
                ->where(
                    [
                        'user_id ' => $this->currentUser['id'],
                    ]
                )
                ->order(
                    [
                        'start' => 'DESC',
                    ]
                )
                ->first();
        }
        $this->set(compact('KYCLastAttempt'));
        $this->set('currenciesEnabledList', Misc::getCurrensiesList());

        $stagesConfig = Misc::getPeriodSales();
        $stages = [];
        $dateCurrent = new \DateTime("now");
        $stageActualFirstKey = -1;
        foreach ($stagesConfig['periods'] as $key => $stage) {
            if ($dateCurrent > new \DateTime($stage['end'])) {
                continue;
            }
            $stageActualFirstKey = $key;
            break;
        }
        if ($stageActualFirstKey >= 0) {
            $stageFirst = $stagesConfig['periods'][$stageActualFirstKey];
            $stageFirst['live'] = 0;
            if ($dateCurrent >= new \DateTime($stageFirst['start']) && $dateCurrent <= new \DateTime($stageFirst['end'])) {
                $stageFirst['live'] = 1;
            }
            $stages['periods'][] = $stageFirst;
            $stages['periodSales'][] = $stagesConfig['periodSales'][$stageActualFirstKey];
            $stages['tokenCurrencyPrice'] = $stagesConfig['tokenCurrencyPrice'];

            $stageActualNextKey = $stageActualFirstKey + 1;
            if (isset($stagesConfig['periods'][$stageActualNextKey])) {
                $stages['periods'][] = $stagesConfig['periods'][$stageActualNextKey];
                $stages['periodSales'][] = $stagesConfig['periodSales'][$stageActualNextKey];
            }
        }

        $this->set(compact('stages'));
    }

    public function index()
    {
        return $this->redirect(['action' => 'home']);
    }

    /**
     * View and edit profile
     * @param $id
     */
    public function profile()
    {
        if (!$this->checkRefer()) {
            return;
        }

        $this->checkCsrf();

        switch ($this->request->query('section')) {
            case 'profile':
                $activeSectionNumber = 0;
                break;
            case 'pswd':
                $activeSectionNumber = 1;
                break;
            default:
                $activeSectionNumber = 0;
        }

        $id = $this->currentUser['id'];
        $userEntity = UsersTable::instance()->get($id);

        $transactions = TransactionsTable::f()->where(['user_id' => $id, 'amount > 0'])->toArray();
        $userSettings = UsersSettingsTable::instance()->getAll($id);
        $userEntity->transactions = $transactions;
        $loginAttempts = KeyValue::read('login_info_' . $id, []);
        $userEntity->isEnable2fa = $userSettings['2fa']['enable'];

        if (!empty($this->request->data)) {
            if (!empty($this->request->data['oldpass']) && !empty($this->request->data['password']) && !empty($this->request->data['passwordconfirm'])) {
                $oldpass = IndianAuthComponent::makeHash($this->request->data['oldpass']);
                if ($userEntity->password !== $oldpass) {
                    $this->Flash->error(__('Wrong password'));
                    $this->redirect(['action' => 'profile', 'section' => 'pswd']);

                    return;
                }

                if ($this->request->data['password'] !== $this->request->data['passwordconfirm']) {
                    $this->Flash->error(__('Password confirmation doesn\'t match Password'));
                    $this->redirect(['action' => 'profile', 'section' => 'pswd']);

                    return;
                }

                $newPass = IndianAuthComponent::makeHash($this->request->data['password']);
                $userEntity->password = $newPass;
                $this->request->session()->write('cake_user.password', $newPass);
                if (!UsersTable::instance()->save($userEntity)) {
                    $this->Flash->error(__('Internal error. Try again later.'));
                    $this->redirect(['action' => 'profile', 'section' => 'pswd']);

                    return;
                } else {
                    $this->Flash->success(__('Password updated'));
                    $this->redirect(['action' => 'profile', 'section' => 'pswd']);

                    return;
                }
            } /*else { //Хз зачем это, она ломало логику сохранения профиля. Если пароль не заполнен, то значит типа заполнен профиль
                $this->Flash->error(__('Please, fill all fields.'));
                $this->redirect(['action' => 'profile', 'section' => 'pswd']);

                return;
            }*/
        }

        if (!empty($this->request->data)) {

            //Profile edit hook
            $newProfileArr = Sandbox::runFromStorageOrIgnore('userEditProfile', [
                'user'   => $this->request->data,
                'userId' => $this->currentUser['id'],
            ]);
            if (is_array($newProfileArr) && !empty($newProfileArr['name'])) {
                $this->request->data = $newProfileArr;
            }

            //Явно выбор свойств который надо перезаписать надежнее убирания только пароля
            $userEntity = UsersTable::instance()->patchEntity($userEntity, [
                'name'              => $this->request->data['name'],
                'phone'             => $this->request->data['phone'],
                'age'               => $this->request->data['age'],
                'country'           => $this->request->data['country'],
                'registration_data' => empty($this->request->data['registration_data']) ? [] :
                    $this->request->data['registration_data'],
            ]);
            if ($userEntity->kyc_reached) {
                $this->Flash->error(__('Editing account data is not available after KYC passing'));
                $this->redirect(['action' => 'profile']);

                return;
            }

            if (!UsersTable::instance()->save($userEntity)) {
                $this->Flash->error(__('Internal error. Try again later.'));
                $this->redirect(['action' => 'profile']);

                return;
            } else {
                $this->Flash->success(__('Account updated'));
            }

            /*if (!empty($_FILES)) {
                $basePath = Misc::userUploadPath();
                @mkdir($basePath, 0777, true);
                $basePath .= DS;

                foreach ($_FILES['userFiles']['tmp_name'] as $index => $file) {
                    move_uploaded_file($file, $basePath . uniqid() . '_' . $_FILES['userFiles']['name'][$index]);
                }
                $this->Flash->success(__('Files successfuly uploaded'));
            }*/
        }

        $this->viewBuilder()->layout('ajax');
        $this->set(compact('userEntity'));
        $this->set(compact('activeSectionNumber'));
        $this->set('loginAttempts', $loginAttempts);
    }

    /**
     * Other currency 2 token
     * @param $amount
     * @param $currency
     */
    public function calcMoney2Token($amount, $currency, $resultAsJSON = true)
    {
        try {
            $amount = abs(floatval($amount));
            if ($currency !== 'RUR') {
                if ($currency !== 'EUR') {
                    $usd = CoinMarketCap::token2usd($amount, $currency);
                } else {
                    $ethers = $amount / ExternalApiController::dalongCourse('ETH')['course'];
                    $usd = CoinMarketCap::token2usd($ethers, 'ETH');
                }
            } else {
                $usd = CBRF::rur2currency($amount, 'USD');
            }
            $complex = Calculator::getComplexUsd2Token($usd, null, CurrentUser::get('id'));

            $result = $complex + [
                    'money' => $amount,
                    'usd'   => $usd,
                    'token' => round(Calculator::usdToToken($usd), 6),
                ];

            return $resultAsJSON ? $this->sendJsonOk($result) : $result;
        } catch (\Exception $e) {
            $result = $e->getMessage();

            return $resultAsJSON ? $this->sendJsonError($result) : $result;
        }
    }

    /**
     * Our token 2 other currency
     * @param $amount
     * @param $currency
     */
    public function calcToken2Money($amount, $currency, $resultAsJSON = true)
    {
        try {
            $amount = abs(floatval($amount));
            $amountInUSD = Calculator::token2Usd($amount);

            if ($currency === Misc::internalCurrency()) {
                $money = ($amount * (Calculator::getTokenCurrencyPrice() * 100)) / 100;
            } else {
                if ($currency === 'RUR') {
                    $money = CBRF::currency2rur($amountInUSD, 'USD');
                } else {
                    if ($currency === 'EUR') {
                        $money = CoinMarketCap::usd2token($amountInUSD, 'ETH', 10);
                        $money = ExternalApiController::dalongCourse('ETH')['course'] * $money;
                    } else {
                        $money = CoinMarketCap::usd2token($amountInUSD, $currency, 10);
                    }
                }
            }

            $complex = Calculator::getComplexUsd2Token($amountInUSD, null, CurrentUser::get('id'));
            $result = $complex + [
                    'money' => strval($money),
                    'usd'   => $amountInUSD,
                    'token' => $amount,
                    $currency,
                    Misc::internalCurrency(),
                ];

            return $resultAsJSON ? $this->sendJsonOk($result) : $result;
        } catch (\Exception $e) {
            $result = $e->getMessage();

            return $resultAsJSON ? $this->sendJsonError($result) : $result;
        }
    }

    /**
     * Creates and cache transaction
     * @param float $amount
     * @param string $currency
     */
    public function generateTransaction($amount, $currency, $deposit)
    {
        try {
            $amount = abs(floatval($amount));

            if ($amount <= 0 || !is_numeric($amount)) {
                $this->sendJsonError('Incorrect amount');

                return;
            }

            $user = UsersTable::instance()->get($this->currentUser['id']);

            $deposit = !!intval($deposit);
            $hash = md5($currency . $this->currentUser['id'] . $deposit . Misc::projectName());

            $transaction = Cache::read($hash, 'short');

            if (empty($transaction)) {
                $transaction = Payment::createDeposit(
                    $amount,
                    $currency,
                    $hash,
                    [
                        'userId'      => $this->currentUser['id'],
                        'deposit'     => $deposit,
                        'clickId'     => $this->clickId,
                        'buyer_email' => $user->email,
                    ]
                );
                Cache::write($hash, $transaction, 'short');
            }

            //CPA::request($this->clickId, 'order');
            CPA::newOrder($this->clickId, $this->currentUser['id'], $amount, $currency);

            $transaction['email'] = $user->email;
            $transaction['label_btn_pay'] = __('Pay');
            $transaction['label_tag'] = __('Destination tag');

            $this->sendJsonOk($transaction);
        } catch (\Exception $e) {
            $this->sendJsonError($e->getMessage());
        }
    }

    /**
     * Edit wallet address
     */
    public function editWallet()
    {
        if (!$this->checkRefer()) {
            return;
        }

        $user = UsersTable::instance()->get($this->currentUser['id']);
        /*if (!empty($user->wallet)) {
            $this->Flash->error(__('You can\'t edit wallet address'));
            $this->redirect(['action' => 'home']);

            return;
        }*/

        LogTable::write('USER_WALLETCHANGE', [
            'old' => $user->wallet,
            'new' => $this->request->data('wallet'),
        ], $user->id);

        $user->wallet = $this->request->data('wallet');
        if (!UsersTable::instance()->save($user)) {
            $this->Flash->error(__('Unknown error. Try again later.'));

        } else {
            $this->Flash->success(__('Wallet address saved'));
        }

        $this->redirect(['action' => 'home']);
    }

    /**
     * Buy tokens from deposit
     */
    public function buyTokens()
    {
        if (!$this->checkRefer()) {
            return;
        }

        if (!empty($this->request->data('tokens'))) {
            $amount = abs(floatval($this->request->data('tokens')));

            if ($amount <= 0 || !is_numeric($amount)) {
                $this->Flash->error(__('Incorrect amount'));
                $this->redirect(['action' => 'home']);

                return;
            }

            $user = UsersTable::instance()->get($this->currentUser['id']);

            //Вычисляем количество токенов с бонусом исходя из суммы
            $usd = Calculator::token2Usd($amount);
            $amount = Calculator::usdToTokenSale($usd, null, CurrentUser::get('id'));

            if ($user->balance < $usd) {
                $this->Flash->error(__('Insufficient funds. Current balance ' . $user->balance . ' need ' . $usd));
                $this->redirect(['action' => 'home']);

                return;
            }

            $money['BTC'] = CoinMarketCap::usd2token($usd, 'BTC');
            $money['ETH'] = CoinMarketCap::usd2token($usd, 'ETH');

            //Создаем транзакцию-трату
            $transaction = TransactionsTable::instance()->newEntity([
                'amount'         => -$amount,
                'currency'       => 'token',
                'user_id'        => $user->id,
                'usd'            => -$usd,
                'rawdata'        => 'Buying from deposit',
                'currencys_rate' => @json_encode($money, JSON_UNESCAPED_UNICODE),
                'type'           => 'TOKEN_BUY',
            ]);

            if (!TransactionsTable::instance()->save($transaction)) {
                throw  new \Exception('Transaction saving error ' . print_r($transaction, true));
            }

            //Вычисляем финальный баланс
            $user->tokens += $amount;
            $user->balance -= $usd;

            Referal::referalBuy($user, Calculator::usdToToken($usd));


            if (!UsersTable::instance()->save($user)) {
                throw new \Exception('Cant change token or balance for user ' . $user->id . ' on ' . (-$usd) . ' USD Tokens: ' . $amount);
            }

            /*  CPA::request($this->clickId, 'paid', [
                  'sum'       => $usd,
                  'currency'  => 'USD',
                  'action_id' => $transaction->id,
                  'revenue'   => $usd * 0.15,
              ]);*/
            CPA::pay($this->clickId, $user->id, $usd, 'USD', $transaction->id, $amount);

            $this->Flash->success(__('Token successfully purchased'));
        }
        $this->redirect(['action' => 'home']);
    }


    /**
     * Referal link
     * @param $code
     */
    public function ref($code = null)
    {
        if (!empty($code)) {
            $userId = Crypt::dcrypt($code);
            if (!empty($userId)) {
                $this->request->session()->write('refUser', $userId);
                $this->Cookie->write('refUser', $userId);
            }
        }

        $this->redirect(['controller' => 'app', 'action' => 'register']);
    }


    /**
     * Crowdsale data
     */
    public function getCrowdsaleData()
    {
        $this->response->header('Access-Control-Allow-Origin: *');
        $this->sendJsonOk(self::getCrowdsaleDataLegacy());
    }

    /**
     * Get crowdsale data
     * @return array
     * @throws \Exception
     */
    public static function getCrowdsaleDataLegacy()
    {
        $totalIn = TransactionsTable::f()->select(['sum' => TransactionsTable::f()->func()->sum('usd')])->where(['amount >' => 0])->first()->sum;
        $totalTokens = UsersTable::f()->select(['sum' => UsersTable::f()->func()->sum('tokens')])->first()->sum;


        return [
            'totalUSD'      => empty($totalIn) ? 0 : $totalIn,
            'tokenPerUSD'   => Calculator::usdToTokenSale(1, null, null),
            'bonus'         => Calculator::getTokenBonus(PHP_INT_MAX),
            'period'        => \App\Lib\Calculator::getPeriods()[\App\Lib\Calculator::getPeriod()],
            'totalCurrency' => CoinMarketCap::usd2token($totalIn, Misc::internalCurrency()),
            'totalTokens'   => $totalTokens,
            'currencies'    => Misc::getCurrenciesValue(),
        ];
    }
}

