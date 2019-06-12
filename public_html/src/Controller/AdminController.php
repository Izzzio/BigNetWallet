<?php

namespace App\Controller;


use App\Lib\Crypt;
use App\Lib\Csv;
use App\Lib\CsvWriter;
use App\Lib\CurrentUser;
use App\Lib\Emails;
use App\Lib\KeyValue;
use App\Lib\Misc;
use App\Lib\Referal;
use App\Lib\Sandbox;
use App\Lib\UserUtils;
use App\Lib\CoinMarketCap;

use App\Model\Entity\User;
use App\Model\Entity\UserSettings;
use App\Model\Table\FaqTable;
use App\Model\Table\LogTable;
use App\Model\Table\TransactionsTable;
use App\Model\Table\UsersSettingsTable;
use App\Model\Table\UsersTable;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Database\Connection;
use Cake\Event\Event;

use App\Lib\Email;
use Cake\Filesystem\Folder;
use Cake\I18n\Time;
use Cake\Routing\Router;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Inflector;


class AdminController extends AppController
{


    const WHATS_NEW = [
        [
            'title' => 'Появился список "Что нового?"',
            'text'  => 'Теперь вы смоежте быстро узнавать об обновлениях системы сборов iZ³',
        ],
        [
            'title' => 'Персональный бонус',
            'text'  => 'Появилась возможность устанавливать каждому клиенту персональное значение бонуса, а также персональный процент, получаемый от рефералов. Стоит помнить, что значение будет добавлятся к текущим настройкам системы. Например: Если у пользовалетя с id 1 установлен персональный бонус 5%, а в системе глобально установлен бонус 50%, то пользователь будет получать бонус - 55%. Для задания персонального бонуса для пользователя используется поле "Personal Bonus". Для повышения реферального бонуса - "Personal Referal Bonus"',
        ],
        [
            'title' => 'Выгрузка транзакций',
            'text'  => 'В списке транзакций теперь можно выгрузить список транзакций в формате CSV',
        ],
        [
            'title' => 'Графики траназкций',
            'text'  => 'Теперь можно посмотреть % валют в сборах в разделе статистики транзакций Transactions > Stats',
        ],
        [
            'title' => 'Повышенный бонус для привлеченных рефералов',
            'text'  => 'Теперь также можно указать размер дополнительного бонуса, для зарегестрировавшихся по рефферальной ссылке. Поле "Additional buying bonus for all refferals" реализует этот функционал',
        ],
        [
            'title' => 'Новые хуки для интеграции CPA сетей',
            'text'  => 'В разделе Scripts появились хуки, подходящие для интеграции CPA сетей.',
        ],
        [
            'title' => 'Custom pages',
            'text'  => 'Custom pages позволяет создавать статичные и страницы, использующие PHP скрипты для отображения  контента или использования в качестве API интерфейса.',
        ],
        [
            'title' => 'Social Auth',
            'text'  => 'Наконец появилась долгожданная функция: Авторизация и регистрация через соц сети. <a href="http://telegra.ph/Avtorizaciya-i-registraciya-cherez-soc-seti--iZ-03-30" target="_blank">Подробнее</a>',
        ],
        [
            'title' => 'Раскладка по валютам',
            'text'  => 'В API методе getCrowdsaleData появился вывод информации о сборах отдельных криптовалют',
        ],
        [
            'title' => '2FA',
            'text'  => 'Теперь пользователи могут включить вход с помощью двухфакторной авторизации, используя Google Authenticator или схожее приложение для генерации кодов',
        ],
        [
            'title' => 'KYC',
            'text'  => 'Наконец интегрирована поддержка процедуры KYC с помощью нашего партнёра. Для активации, напишите в общий чат проекта.',
        ],
        [
            'title' => 'ERC20',
            'text'  => 'Появилась возможность создавать автоматические переводы ERC20 токенов пользователям с кошелька.',
        ],
        [
            'title' => 'Скрипт для упрощённой интеграции CPA на сайт',
            'text'  => 'Мы сделали скрипт, который позволяет упростить встраивание интеграции CPA сетей в ваш сайт и кабинет. Для этого просто подключите скрипт //адрес_кабинета/custom/cpaScript к странице сайта. Базово используется параметр clickid. Для добавления доолнительных параметров сообщите в общем чате.',
        ],
        [
            'title' => 'Разграничение прав доступа',
            'text'  => 'Теперь у доступа в админскую панель существет несколько вариантов прав доступа. Изменить их можно в редактировании карточки пользователя',
        ],
        [
            'title' => 'Отдельный подсчёт бонусов',
            'text'  => 'Теперь для каждого пользователя подсчёт количества полученных бонусных токенов',
        ],
        [
            'title' => 'Курсы BTC и ETC на момент транзакции',
            'text'  => 'С этого момента все транзакции содержат информацию о стоимости транзакции в USD, BTC и ETH',
        ],
        [
            'title' => 'Bots API',
            'text'  => 'теперь по адресу /api/v1/bots/ доступно API для Телеграм ботов и внешних клиентов. Для включения API сообщите нам о желании в общем чате.',
        ],
        [
            'title' => 'Новое оформление панели администратора',
            'text'  => 'Мы обновили дизайн и структуру панели администраирования. Теперь стало удобнее.',
        ],
        [
            'title' => 'PayKassa.pro',
            'text'  => 'Также мы подключили дополнительную платёжную систему PayKassa.pro В этой системе комиссии на некоторые валюты ниже, а также в качестве альтернативы другим платёжны системам.',
        ],
    ];

    const USER_EXPORT_ADDITIONAL_FIELDS = [
        'case',
        'company_name',
        'address',
        'city',
        'zipcode',
        'country',
        'company_registration_number',
        'representative_name',
        'representative_birthdate',
        'fullname',
        'phone',
        'passport',
        'nationality',
        'birthdate',
    ];

    /** @inheritdoc */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->set('user', false);

        $action = $this->request->params['action'];
        $permission = AclController::havePermission($this->request->params['controller'], $action);
        if (!$permission) {
            if ($action && !in_array($action, ['index'])) {
                $this->Flash->error(__('Access closed.'));

                return $this->redirect(['controller' => AclController::getRoleHomePage(), 'action' => 'index']);
            }
        }
    }

    /** @inheritdoc */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        if (!empty($this->currentUser['id'])) {
            $user = UsersTable::instance()->get($this->currentUser['id']);
            $this->set('user', $user);
        }

        if (empty($this->currentUser['is_admin'])) {
            $this->Flash->error(__('Access closed.') . '&nbsp;' . __('Insufficient rights.'));

            if (AclController::isNotUserRole(['ROLE_USER'])) {
                $redirect = ['controller' => 'cabinet', 'action' => 'index'];
            } else {
                if (AclController::isUserRole(['ROLE_USER'])) {
                    $redirect = ['controller' => 'cabinet', 'action' => 'index'];
                } else {
                    $redirect = ['controller' => 'app', 'action' => 'index'];
                }
            }

            return $this->redirect($redirect);
        }

        $this->set('activeMenu', $this->_hilightActiveMenuItem());
        $this->viewBuilder()
            ->layoutPath('Admin')
            ->layout('lte')
            ->templatePath('Admin' . DS . 'lte');
    }

    /**
     * Check is user admin or accessToken provided
     * @return \Cake\Network\Response|false
     */
    private function _requireAccessTokenOrAdmin()
    {
        if ((empty($this->request->query['accessToken']) || empty(Configure::read('App.accessToken')) || !($this->request->query['accessToken'] === Configure::read('App.accessToken')))) {
            if (empty($this->currentUser['is_admin'])) {
                return $this->redirect(['controller' => 'app', 'action' => 'login']);
            }
        }

        return false;
    }


    /**
     * Dashboard
     */
    public function index()
    {
        $this->set('totalUsers', UsersTable::f()->count());
        $this->set('notverifiedUsers', UsersTable::f()->where(['status' => User::STATUS_NOTVERIFY])->count());
        $this->set('verifiedUsers', UsersTable::f()->where(['status' => User::STATUS_VERIFIED])->count());
        $this->set('totalBalance', UsersTable::f()->select(['sum' => UsersTable::f()->func()->sum('balance')])->first()->sum);
        $this->set('totalTokens', UsersTable::f()->select(['sum' => UsersTable::f()->func()->sum('tokens')])->first()->sum);

        $this->set('totalTx', TransactionsTable::f()->count());
        $this->set('totalIncome', TransactionsTable::f()->select(['sum' => TransactionsTable::f()->func()->sum('usd')])->where(['amount >' => 0])->first()->sum);
        $this->set('totalOutcome', -TransactionsTable::f()->select(['sum' => TransactionsTable::f()->func()->sum('usd')])->where(['amount <' => 0])->first()->sum);
        $this->set('frozen', TransactionsTable::f()->select(['sum' => TransactionsTable::f()->func()->sum('usd')])->first()->sum);
        $this->set('lastTx', TransactionsTable::f()->where(['amount > ' => 0])->order(['created' => 'DESC'])->first());

        /* $transChart = TransactionsTable::f()->select([
             'sum' => TransactionsTable::f()->func()->sum('usd'),
             'DATE_FORMAT(created, \'%Y-%m-%d\') as date',
         ])->toArray();*/


        /**
         * @var Connection $conn
         */
        $conn = ConnectionManager::get('default');
        $transChart = $conn->query("SELECT sum(usd) AS usd, DATE_FORMAT(created, '%Y-%m-%d') AS date FROM transactions WHERE usd>0 GROUP BY DATE_FORMAT(created, '%Y-%m-%d')")->fetchAll();
        $this->set(compact('transChart'));
    }


    /**
     * Users list
     */
    public function users()
    {

        $this->paginate = [
            'limit' => 150,
        ];

        $where = [];

        $search = $this->_getSearchString();

        if (!empty($search)) {
            $where = [
                'OR' => [
                    'email LIKE'   => '%' . $search . '%',
                    'name LIKE'    => '%' . $search . '%',
                    'id LIKE'      => $search . '%',
                    'clickid LIKE' => '%' . $search . '%',
                ],
            ];
        }

        $users = UsersTable::f()->where($where);
        $users = $this->paginate($users);

        $this->set(compact('users'));
    }


    /**
     * Transactions list
     */
    public function transactions()
    {

        $where = [];

        $search = $this->_getSearchString();

        if (!empty($search)) {
            $where = [
                'OR' => [
                    'rawdata LIKE'         => '%' . $search . '%',
                    'type LIKE'            => '%' . $search . '%',
                    'Transactions.id LIKE' => $search . '%',
                    // 'name LIKE' => '%'.$this->request->data('search').'%',
                ],
            ];
        }

        $transactions = TransactionsTable::f()->where($where)->contain(['Users']);//->order(['id' => "DESC"]);
        $transactions = $this->paginate($transactions);

        $this->set(compact('transactions'));
    }

    private function _getSearchString()
    {
        $search = $this->request->query('search');
        if (empty($search)) {
            $this->request->data('search');
        }

        return $search;
    }

    /**
     * Logs list
     */
    public function logs()
    {

        $this->paginate = [
            'order' => [
                'id' => 'desc',
            ],
        ];

        $where = [];

        $search = $this->_getSearchString();

        if (!empty($search)) {
            $where = [
                'OR' => [
                    'type LIKE'  => '%' . $search . '%',
                    'data LIKE'  => '%' . $search . '%',
                    'email LIKE' => '%' . $search . '%',
                ],
            ];
        }

        $logs = LogTable::f()->where($where)->contain(['Users']);
        $logs = $this->paginate($logs);

        $this->set(compact('logs'));
        $this->set('search', $this->request->data('search'));
    }


    /**
     * User edit
     * @param int $id
     */
    public function user($id)
    {
        $user = UsersTable::instance()->get($id);
        $txs = TransactionsTable::f()->where(['user_id' => $id])->order(['id' => 'DESC']);
        $tfa = UsersSettingsTable::f()->where(['block' => '2fa', 'name' => 'enable', 'user_id' => $id])->first();
        $this->set('editUser', $user);
        $this->set('txs', $txs);
        $this->set('tfa', $tfa);
        $this->set('refs', Referal::getUserReferals($id));
        if (!empty($this->request->data)) {

            if (AclController::isNotUserRole(['ROLE_SYSTEM', 'ROLE_ADMIN'])) {
                if (isset($this->request->data['roles'])) {
                    unset($this->request->data['roles']);
                }
            }

            UsersTable::instance()->patchEntity($user, $this->request->data);
            LogTable::write('USER_CHANGE', ['user_id' => $id], CurrentUser::get('id'));
            if (!UsersTable::instance()->save($user)) {
                $this->Flash->error(__('Saving error'));

                return;
            }

            $this->Flash->success(__('User saved'));

            return;
        }


    }

    /**
     * Manual transaction to user balance
     * @param $userId
     * @throws \Exception
     */
    public function transact($userId)
    {
        $amount = floatval($this->request->data('amount'));
        $user = UsersTable::instance()->get($userId);

        if (empty($amount)) {
            throw  new \Exception('Incorrect amount');
        }

        $money['BTC'] = CoinMarketCap::usd2token($amount, 'BTC');
        $money['ETH'] = CoinMarketCap::usd2token($amount, 'ETH');


        $transaction = TransactionsTable::instance()->newEntity([
            'amount'         => $amount,
            'currency'       => 'Manual',
            'user_id'        => $userId,
            'usd'            => $amount,
            'rawdata'        => 'Manual created transaction by user_id ' . CurrentUser::get('id'),
            'currencys_rate' => @json_encode($money, JSON_UNESCAPED_UNICODE),
        ]);


        $user->balance += $amount;

        if (!UsersTable::instance()->save($user)) {
            throw  new \Exception('User saving error ' . print_r($user, true));
        }

        if (!TransactionsTable::instance()->save($transaction)) {
            throw  new \Exception('Transaction saving error ' . print_r($transaction, true));
        }

        $this->Flash->success('Transaction created.');
        $this->redirect(['action' => 'user', $userId]);
    }

    /**
     * Manual transaction to user balance
     * @param $userId
     * @throws \Exception
     */
    public function transactTokens($userId)
    {
        UserUtils::transactTokens($userId, $this->request->data('amount'), 'Manual created transaction by user_id ' . CurrentUser::get('id'));

        $this->Flash->success('Transaction created');
        $this->redirect(['action' => 'user', $userId]);
    }

    /**
     * Withdraw user tokens
     * @param $userId
     * @throws \Exception
     */
    public function withdrawTokens($userId)
    {
        $amount = floatval($this->request->data('amount'));
        $user = UsersTable::instance()->get($userId);
        if (empty($amount)) {
            throw  new \Exception('Incorrect amount');
        }

        $transaction = TransactionsTable::instance()->newEntity([
            'amount'   => -$amount,
            'currency' => Misc::tokenName(),
            'user_id'  => $userId,
            'usd'      => 0,
            'rawdata'  => 'Token Withdraw by user_id ' . CurrentUser::get('id'),
        ]);


        $user->in_chain += $amount;

        if (!UsersTable::instance()->save($user)) {
            throw  new \Exception('User saving error ' . print_r($user, true));
        }

        if (!TransactionsTable::instance()->save($transaction)) {
            throw  new \Exception('Transaction saving error ' . print_r($transaction, true));
        }

        $this->Flash->success('Transaction created');
        $this->redirect(['action' => 'user', $userId]);
    }

    /**
     * Transaction view
     * @param $id
     */
    public function transaction($id)
    {
        $tx = TransactionsTable::f()->contain([UsersTable::getAlias()])->where(['Transactions.id' => $id])->first();

        $this->set('tx', $tx);
    }

    public function scripts()
    {

    }

    /**
     * Scripts
     * @param int $script
     */
    public function script($script)
    {
        $this->response->header('X-XSS-Protection', '0');
        $scriptSource = $this->request->data('script');

        if (!empty($scriptSource)) {
            try {
                /* $result = Sandbox::run($scriptSource, [
                     'login'       => $this->currentUser['email'],
                     'code'        => Misc::makeUserCode($this->currentUser['id']),
                     'password'    => Misc::generatePassword(),
                     'sold_tokens' => PHP_INT_MAX,
                     'tokens'      => PHP_INT_MAX,
                 ]);
                 $this->Flash->success(print_r($result, true));*/
                LogTable::write('SCRIPT_CHANGE', ['old' => KeyValue::read($script)], CurrentUser::get('id'));
                KeyValue::write($script, $scriptSource);
            } catch (\Exception $e) {
                $this->Flash->error($e->getMessage());
                // $this->Flash->error($e->getTraceAsString());
            }


        } else {
            $scriptSource = KeyValue::read($script, "<?php\n//Redefine this code\nreturn false;\n ?>");
        }
        $this->set('script', $script);
        $this->set('scriptSource', $scriptSource);
    }


    public function faq()
    {
        $langs = (new Folder(ROOT . '/src/Locale'))->read()[0];
        $this->set(compact('langs'));

        if (!empty($this->request->data('addnew'))) {
            $newQuestion = FaqTable::instance()->newEntity(['q' => 'New question', 'a' => 'New answer']);
            FaqTable::instance()->save($newQuestion);
        }

        $faqs = FaqTable::f()->order(['id' => 'DESC']);
        $this->set(compact('faqs'));

    }

    public function faqedit($id)
    {

        $langs = (new Folder(ROOT . '/src/Locale'))->read()[0];
        $this->set(compact('langs'));
        $faq = FaqTable::instance()->get($id);

        LogTable::write('FAQ_EDIT', ['faq' => $faq], CurrentUser::get('id'));

        if (!empty($this->request->data('q'))) {
            $faq->q = $this->request->data('q');
            $faq->a = $this->request->data('a');
            FaqTable::instance()->save($faq);

            foreach ($langs as $lang) {
                if ($lang === \Cake\Core\Configure::read('App.defaultLocale')) {
                    continue;
                }

                $keyStr = $lang . '_' . $faq->id . '_q';
                if (isset($this->request->data[$keyStr])) {
                    KeyValue::write($keyStr, $this->request->data($keyStr));
                    $keyStr = $lang . '_' . $faq->id . '_a';
                    if (!empty($this->request->data($keyStr))) {
                        KeyValue::write($keyStr, $this->request->data($keyStr));
                    }
                }


            }
        }

        $this->set(compact('faq'));
    }

    /**
     * Delete question
     * @param int $id
     */
    public function faqdelete($id)
    {

        $faq = FaqTable::instance()->get($id);
        LogTable::write('FAQ_DELETE', ['faq' => $faq], CurrentUser::get('id'));
        if (FaqTable::instance()->delete($faq)) {
            $this->Flash->success('Question deleted');

        } else {
            $this->Flash->error('Question delete error');
        }
        $this->redirect(['action' => 'faq']);
    }

    /**
     * Confirm user
     *
     * @param $userId
     */
    public function confirmUser($userId)
    {
        $user = UsersTable::instance()->get($userId);
        $user->status = User::STATUS_VERIFIED;

        if (!UsersTable::instance()->save($user)) {
            $this->Flash->error('User saving error');

            return;
        }

        LogTable::write('CONFIRM_USER', ['user' => $userId], CurrentUser::get('id'));

        $this->Flash->success('User confirmed');
        $this->redirect(['action' => 'user', $userId]);
    }

    /**
     * Confirm KYC
     *
     * @param $userId
     */
    public function confirmKYC($userId)
    {

        if ($this->request->is('post')) {


            $user = UsersTable::instance()->get($userId);

            if ($user->kyc_reached == User::KYC_NOT_REACHED) {
                $user->kyc_reached = User::KYC_REACHED;
            } else {
                $user->kyc_reached = User::KYC_NOT_REACHED;
            }

            if (!UsersTable::instance()->save($user)) {
                $this->Flash->error('User saving error');

                return;
            }

            LogTable::write('TOGGLE_USER_KYC', [
                'user'   => $userId,
                'status' => $user->kyc_reached,
            ], CurrentUser::get('id'));

            $this->Flash->success('KYC set to: ' . ($user->kyc_reached == User::KYC_REACHED ? 'KYC Passed' :
                    'KYC not verified'));
            $this->redirect(['action' => 'user', $userId]);
        }
    }

    /**
     * Confirm KYC
     *
     * @param $userId
     */
    public function disable2FA($userId)
    {

        if ($this->request->is('post')) {


            /**
             * @var UserSettings $user
             */
            $user = UsersSettingsTable::f()->where([
                'block'   => '2fa',
                'name'    => 'enable',
                'user_id' => $userId,
            ])->first();

            if ($user->value == 1) {
                $user->value = null;
            } else {
                $user->value = 1;
            }

            if (!UsersSettingsTable::instance()->save($user)) {
                $this->Flash->error('User settings saving error');

                return;
            }

            LogTable::write('TOGGLE_USER_2FA', ['user' => $userId, 'status' => $user->value], CurrentUser::get('id'));

            $this->Flash->success('2FA set to: ' . ($user->value == 1 ? 'Enabled' :
                    'Disabled'));
        }
        $this->redirect(['action' => 'user', $userId]);
    }

    /**
     * Download users file
     * @param $file
     * @param $filename
     */
    public function getUserFile($userId, $file)
    {
        $filename = $file;
        $file = \App\Lib\Misc::userUploadPath($userId) . DS . $file;
        $this->response->file($file, [
            'download' => true,
            'name'     => $filename,
        ]);

        return $this->response;
    }

    /**
     * Send confirmation email to user
     *
     * @param $userId
     */
    public function sendConfirmationEmail($userId)
    {
        $user = UsersTable::instance()->get($userId);
        $result = Emails::confirm($user->email, $user->id);
        $this->Flash->success('Confirmation email sent to ' . $user->email . '. Status: ' . (print_r($result, true)));
        $this->redirect(['action' => 'user', $userId]);
    }

    /**
     * Generate and send CSV file with user emails & referral link
     *
     * @return mixed
     */
    public function userExport()
    {

        $check = $this->_requireAccessTokenOrAdmin();
        if ($check) {
            return $check;
        }

        $users = UsersTable::instance()->f()
            ->select(['income' => UsersTable::instance()->f()->func()->sum('Transactions.usd')])
            ->leftJoinWith('Transactions', function ($q) {
                //return $q->where(['Transactions.user_id' => 'awesome', 'Transactions.usd > ' => 0]);
                return $q->where([
                    'Transactions.usd > ' => 0,
                    //'Transactions.type ' => 'INCOME',
                ]);
            })
            ->group(['Users.id'])
            ->autoFields(true);


        $data[] = array_merge([
            'Email',
            'Verified',
            'Name',
            'Phone',
            'Country',
            'Age',
            'Referal',
            'Tokens',
            'Tokens in chain',
            'Balance(Tokens)',
            'Income(USD)',
            'Balance(USD)',
            'ClickId',
            'Wallet',
            'User Data',
            'KYC reached',
        ], self::USER_EXPORT_ADDITIONAL_FIELDS, is_array(Configure::read('App.userExportFields')) ?
            Configure::read('App.userExportFields') : []);

        /**
         * @var User[] $users
         */
        foreach ($users as $user) {
            $row = [
                $user->email,
                $user->status == User::STATUS_VERIFIED ? 'Yes' : 'No',
                $user->name,
                $user->phone,
                $user->country,
                $user->age,
                Router::url('/cabinet/ref/' . Misc::makeUserCode($user->id), true),
                $user->tokens,
                $user->in_chain,
                $user->tokens - $user->in_chain,
                $user->income,
                $user->balance,
                $user->clickid,
                $user->wallet,
                $user->registration_data,
                $user->kyc_reached ? 'Yes' : 'No',
            ];

            $userData = json_decode($user->registration_data, true);

            foreach (self::USER_EXPORT_ADDITIONAL_FIELDS as $field) {
                if (!empty($userData[$field])) {
                    $row[] = $userData[$field];
                } else {
                    $row[] = '';
                }
            }

            $data[] = $row;
        }

        $filename = TMP . '/users-referral.csv';

        LogTable::write('EXPORT_USERS', [], CurrentUser::get('id'));

        $csvFile = CsvWriter::writeCsv($filename, $data);
        $this->response->file($filename, [
            'download' => true,
            'name'     => 'Users' . Configure::read('App.appName') . '_' . date('Y-m-d H:i:s') . '.csv',
        ]);

        return $this->response;
    }

    /**
     * Generate mysql dump
     *
     * @return mixed
     */
    public function sqldump()
    {


        $check = $this->_requireAccessTokenOrAdmin();
        if ($check) {
            return $check;
        }

        $source = ConnectionManager::get('default')->config();
        $filename = TMP . '/dump.sql';

        exec('mysqldump -u' . $source['username'] . ' --password=' . $source['password'] . '  ' . $source['database'] . ' > ' . $filename);

        LogTable::write('SQL_DUMP', [], CurrentUser::get('id'));

        $this->response->file($filename, [
            'download' => true,
            'name'     => str_replace(' ', '_', 'mysqldump ' . Configure::read('App.appName') . '_' . date('Y-m-d H:i:s')) . '.sql',
        ]);

        return $this->response;
    }

    /**
     * Generate and send CSV file with transactions
     *
     * @return mixed
     */
    public function tranasctionsExport()
    {
        $transactions = TransactionsTable::instance()->f(
            'all',
            [
                'contain'    => ['Users'],
                'conditions' => [],
                'order'      => 'Transactions.created DESC',
            ]
        );

        //column heading
        $data[] = [
            'User',
            'Amount',
            'Currency',
            'USD',
            'Type',
            'Created',
            'Description',
        ];

        foreach ($transactions as $transaction) {
            $data[] = [
                $transaction->user->email,
                $transaction->amount,
                $transaction->currency,
                $transaction->usd,
                $transaction->type,
                $transaction->created,
                $transaction->rawdata,
            ];
        }

        $filename = TMP . '/users-transactions.csv';

        LogTable::write('EXPORT_TRANSACTIONS', [], CurrentUser::get('id'));

        $csvFile = CsvWriter::writeCsv($filename, $data);
        $this->response->file($filename, [
            'download' => true,
            'name'     => 'Transactions' . Configure::read('App.appName') . '_' . date('Y-m-d H:i:s') . '.csv',
        ]);

        return $this->response;
    }

    /**
     * Transactions stats
     */
    public function transactionsstats()
    {
        /**
         * @var Connection $conn
         */
        $conn = ConnectionManager::get('default');
        $transChart = $conn->query("SELECT sum(usd) AS usd, DATE_FORMAT(created, '%Y-%m-%d') AS date FROM transactions WHERE usd>0 GROUP BY DATE_FORMAT(created, '%Y-%m-%d')")->fetchAll();
        $this->set(compact('transChart'));

        $currenciesList = \Cake\Core\Configure::read('App.enabledCurrencies');
        $currencies = [
            'names'  => [],
            'values' => [],
        ];
        foreach ($currenciesList as $key => $currencyName) {
            $currencies['names'][] = $currencyName . ' (' . TransactionsTable::f()->select(['sum' => TransactionsTable::f()->func()->sum('amount')])->where(['currency' => $currencyName])->first()->sum . ' ' . $currencyName . ')';
            $value = TransactionsTable::f()->select(['sum' => TransactionsTable::f()->func()->sum('usd')])->where(['currency' => $currencyName])->first()->sum;
            $currencies['values'][] = $value;
        }
        $currencies['names'] = json_encode($currencies['names']);
        $currencies['values'] = json_encode($currencies['values']);

        $this->set('currencies', $currencies);
    }

    /**
     * Custom pages list
     */
    public function customPages()
    {
        $pagesList = KeyValue::read('customPages', []);
        if (!empty($this->request->data['alias'])) {
            $alias = $this->request->data['alias'];
            $alias = Inflector::camelize($alias);
            $pagesList[$alias] = ['alias' => $alias];
            KeyValue::write('customPages', $pagesList);
            $this->Flash->success('New page created');
        }

        $this->set('pages', $pagesList);
    }

    /**
     * Custom page editor
     * @param string $page
     */
    public function customPage($page, $editor = 'php')
    {
        $this->response->header('X-XSS-Protection', '0');
        $scriptSource = $this->request->data('script');

        if (!empty($scriptSource)) {
            try {
                LogTable::write('CUSTOM_CHANGE', ['old' => KeyValue::read($page)], CurrentUser::get('id'));
                KeyValue::write($page, $scriptSource);
            } catch (\Exception $e) {
                $this->Flash->error($e->getMessage());
                // $this->Flash->error($e->getTraceAsString());
            }


        } else {
            $scriptSource = KeyValue::read($page, "");
        }
        $this->set('script', $page);
        $this->set('scriptSource', $scriptSource);
        $this->set('editor', $editor);
    }

    /**
     * Delete custom page
     * @param string $page
     */
    public function deleteCustomPage($page)
    {
        LogTable::write('CUSTOM_DELETE', ['old' => KeyValue::read($page)], CurrentUser::get('id'));
        $pagesList = KeyValue::read('customPages', []);
        unset($pagesList[$page]);
        KeyValue::write('customPages', $pagesList);
        KeyValue::delete($page);
        $this->redirect(['action' => 'customPages']);
    }

    private function _hilightActiveMenuItem()
    {
        $allMenuItems = [
            'dashboard'  => '',
            'users'      => '',
            'txn_list'   => '',
            'txn_stat'   => '',
            'dev_script' => '',
            'dev_page'   => '',
            'dev_logs'   => '',
            'faq'        => '',
        ];

        $action = $this->request->action;
        switch ($action) {
            case 'index':
                $menuItem = 'dashboard';
                break;
            case 'users':
            case 'user':
                $menuItem = 'users';
                break;
            case 'transactions':
            case 'transaction':
                $menuItem = 'txn_list';
                break;
            case 'transactionsstats':
                $menuItem = 'txn_stat';
                break;
            case 'scripts':
            case 'script':
                $menuItem = 'dev_script';
                break;
            case 'logs':
                $menuItem = 'dev_logs';
                break;
            case 'customPages':
            case 'customPage':
                $menuItem = 'dev_page';
                break;
            case 'faq':
            case 'faqedit':
                $menuItem = 'faq';
                break;
            default:
                $menuItem = 'dashboard';
        }
        $allMenuItems[$menuItem] = 'active';

        return $allMenuItems;
    }
}