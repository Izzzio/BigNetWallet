<?php

namespace App\Lib;


use App\Controller\CabinetController;
use App\Model\Table\LogTable;
use App\Model\Table\UsersTable;
use App\Shell\SendTokensShell;
use Cake\Controller\Component\FlashComponent;
use Cake\Core\Configure;
use PHPSandbox\PHPSandbox;

class Sandbox
{


    const FUNC_BLACKLIST = [
        'escapeshellarg',
        'escapeshellcmd',
        'exec',
        'passthru',
        'proc_​close',
        'proc_​get_​status',
        'proc_​nice',
        'proc_​open',
        'proc_​terminate',
        'shell_​exec',
        'system',
        'phpinfo',
        'chdir',
        'chroot',
        'closedir',
        'dir',
        'getcwd',
        'opendir',
        'readdir',
        'rewinddir',
        'scandir',
        'basename',
        'chgrp',
        'chmod',
        'chown',
        'clearstatcache',
        'copy',
        'delete',
        'dirname',
        'disk_​free_​space',
        'disk_​total_​space',
        'diskfreespace',
        'fclose',
        'feof',
        'fflush',
        'fgetc',
        'fgetcsv',
        'fgets',
        'fgetss',
        'file_​exists',
        'file_​get_​contents',
        'file_​put_​contents',
        'file',
        'fileatime',
        'filectime',
        'filegroup',
        'fileinode',
        'filemtime',
        'fileowner',
        'fileperms',
        'filesize',
        'filetype',
        'flock',
        'fnmatch',
        'fopen',
        'fpassthru',
        'fputcsv',
        'fputs',
        'fread',
        'fscanf',
        'fseek',
        'fstat',
        'ftell',
        'ftruncate',
        'fwrite',
        'glob',
        'is_​dir',
        'is_​executable',
        'is_​file',
        'is_​link',
        'is_​readable',
        'is_​uploaded_​file',
        'is_​writable',
        'is_​writeable',
        'lchgrp',
        'lchown',
        'link',
        'linkinfo',
        'lstat',
        'mkdir',
        'move_​uploaded_​file',
        'parse_​ini_​file',
        'parse_​ini_​string',
        'pathinfo',
        'pclose',
        'popen',
        'readfile',
        'readlink',
        'realpath_​cache_​get',
        'realpath_​cache_​size',
        'realpath',
        'rename',
        'rewind',
        'rmdir',
        'set_​file_​buffer',
        'stat',
        'symlink',
        'tempnam',
        'tmpfile',
        'touch',
        'umask',
        'unlink',
        'dio_​close',
        'dio_​fcntl',
        'dio_​open',
        'dio_​read',
        'dio_​seek',
        'dio_​stat',
        'dio_​tcsetattr',
        'dio_​truncate',
        'dio_​write',
        'curl_​close',
        'curl_​copy_​handle',
        'curl_​errno',
        'curl_​error',
        'curl_​escape',
        'curl_​exec',
        'curl_​file_​create',
        'curl_​getinfo',
        'curl_​init',
        'curl_​multi_​add_​handle',
        'curl_​multi_​close',
        'curl_​multi_​errno',
        'curl_​multi_​exec',
        'curl_​multi_​getcontent',
        'curl_​multi_​info_​read',
        'curl_​multi_​init',
        'curl_​multi_​remove_​handle',
        'curl_​multi_​select',
        'curl_​multi_​setopt',
        'curl_​multi_​strerror',
        'curl_​pause',
        'curl_​reset',
        'curl_​setopt_​array',
        'curl_​setopt',
        'curl_​share_​close',
        'curl_​share_​errno',
        'curl_​share_​init',
        'curl_​share_​setopt',
        'curl_​share_​strerror',
        'curl_​strerror',
        'curl_​unescape',
        'curl_​version',
        'ftp_connect',
        'ftp_​alloc',
        'ftp_​append',
        'ftp_​cdup',
        'ftp_​chdir',
        'ftp_​chmod',
        'ftp_​close',
        'ftp_​connect',
        'ftp_​delete',
        'ftp_​exec',
        'ftp_​fget',
        'ftp_​fput',
        'ftp_​get_​option',
        'ftp_​get',
        'ftp_​login',
        'ftp_​mdtm',
        'ftp_​mkdir',
        'ftp_​mlsd',
        'ftp_​nb_​continue',
        'ftp_​nb_​fget',
        'ftp_​nb_​fput',
        'ftp_​nb_​get',
        'ftp_​nb_​put',
        'ftp_​nlist',
        'ftp_​pasv',
        'ftp_​put',
        'ftp_​pwd',
        'ftp_​quit',
        'ftp_​raw',
        'ftp_​rawlist',
        'ftp_​rename',
        'ftp_​rmdir',
        'ftp_​set_​option',
        'ftp_​site',
        'ftp_​size',
        'ftp_​ssl_​connect',
        'ftp_​systype',
        'posix_​access',
        'posix_​ctermid',
        'posix_​errno',
        'posix_​get_​last_​error',
        'posix_​getcwd',
        'posix_​getegid',
        'posix_​geteuid',
        'posix_​getgid',
        'posix_​getgrgid',
        'posix_​getgrnam',
        'posix_​getgroups',
        'posix_​getlogin',
        'posix_​getpgid',
        'posix_​getpgrp',
        'posix_​getpid',
        'posix_​getppid',
        'posix_​getpwnam',
        'posix_​getpwuid',
        'posix_​getrlimit',
        'posix_​getsid',
        'posix_​getuid',
        'posix_​initgroups',
        'posix_​isatty',
        'posix_​kill',
        'posix_​mkfifo',
        'posix_​mknod',
        'posix_​setegid',
        'posix_​seteuid',
        'posix_​setgid',
        'posix_​setpgid',
        'posix_​setrlimit',
        'posix_​setsid',
        'posix_​setuid',
        'posix_​strerror',
        'posix_​times',
        'posix_​ttyname',
        'posix_​uname',
        'pcntl_​alarm',
        'pcntl_​async_​signals',
        'pcntl_​errno',
        'pcntl_​exec',
        'pcntl_​fork',
        'pcntl_​get_​last_​error',
        'pcntl_​getpriority',
        'pcntl_​setpriority',
        'pcntl_​signal_​dispatch',
        'pcntl_​signal_​get_​handler',
        'pcntl_​signal',
        'pcntl_​sigprocmask',
        'pcntl_​sigtimedwait',
        'pcntl_​sigwaitinfo',
        'pcntl_​strerror',
        'pcntl_​wait',
        'pcntl_​waitpid',
        'pcntl_​wexitstatus',
        'pcntl_​wifexited',
        'pcntl_​wifsignaled',
        'pcntl_​wifstopped',
        'pcntl_​wstopsig',
        'pcntl_​wtermsig',
    ];

    /**
     * @var PHPSandbox
     */
    private static $_sandbox = null;

    private static $_internalExternal = [];

    /**
     * Returns instance
     * @return \PHPSandbox\PHPSandbox|null
     */
    public static function instance()
    {
        if (empty(static::$_sandbox)) {
            self::$_sandbox = new PHPSandbox();
            self::$_sandbox->defineVars([
                'domain'           => BASE_DOMAIN,
                'protocol'         => BASE_PROTOCOL,
                'tokenName'        => Misc::tokenName(),
                'supportEmail'     => Misc::supportEmail(),
                'depositEnabled'   => Misc::depositEnabled(),
                'internalCurrency' => Misc::internalCurrency(),
                'saleShowRatio'    => Misc::saleShowRatio(),
                'currentLang'      => \Cake\I18n\I18n::locale(),
                'calculator'       => Configure::read('App.calculator'),
                'getRequest'       => $_GET,
                'postRequest'      => $_POST,
                'cookie'           => $_COOKIE,
                'requestMethod'    => $_SERVER['REQUEST_METHOD'],

                //Define fix
                'tokens'           => null,
                'usd'              => null,
            ]);
            self::$_sandbox->defineFuncs([
                'mc_token2usd'     => function ($token, $currency) {
                    return CoinMarketCap::token2usd($token, $currency);
                },
                'mc_usd2token'     => function ($usd, $currency) {
                    return CoinMarketCap::usd2token($usd, $currency);
                },
                'calc_usd2token' => function($usd, $userId = null, $date = null){
                    return  Calculator::getComplexUsd2Token($usd, $date, $userId);
                },
                'keyvalue_write'   => function ($key, $value) {
                    return KeyValue::write($key, $value);
                },
                'keyvalue_read'    => function ($key, $default = null) {
                    return KeyValue::read($key, $default);
                },
                'debug'            => function ($data) {
                    debug($data);
                },
                'var_dump'         => function ($data) {
                    var_dump($data);
                },
                'log'              => function ($type, $data = null, $userId = null) {
                    LogTable::write($type, $data, $userId);
                },
                'print_r'          => function ($expression, $return = null) {
                    return print_r($expression, $return);
                },
                'str_replace'      => function ($a, $b, $c) {
                    return str_replace($a, $b, $c);
                },
                'email'            => function ($email, $subject, $message) {
                    return Emails::custom($email, $subject, $message);
                },
                'array2View'       => function ($array) {
                    Misc::array2View($array);
                },
                'makeUserCode'     => function ($userId) {
                    return Misc::makeUserCode($userId);
                },
                'get_user'         => function ($id = null) {
                    if (empty($id)) {
                        $id = CurrentUser::get('id');
                    }

                    if (empty($id)) {
                        return null;
                    }

                    return UsersTable::instance()->get($id)->toArray();
                },
                'find_user' => function($query){
                    return UsersTable::f()->where($query)->toArray();
                },
                'http_get'         => function ($url) {
                    if (str_replace(['http:/', 'https:/'], '', strtolower($url)) === strtolower($url)) {
                        return false;
                    }

                    return file_get_contents($url);
                },
                'http_post'        => function ($url, $data = []) {
                    return Misc::httpPost($url, $data);
                },
                'flash_error'      => function ($message) {
                    if (isset(self::$_internalExternal['Flash'])) {
                        self::$_internalExternal['Flash']->error($message);
                    }
                },
                'flash_success'    => function ($message) {
                    if (isset(self::$_internalExternal['Flash'])) {
                        self::$_internalExternal['Flash']->success($message);
                    }
                },
                'strlen'           => function ($string) {
                    return strlen($string);
                },
                'empty'            => function ($var) {
                    return empty($var);
                },
                'getCrowdsaleData' => function () {
                    return CabinetController::getCrowdsaleDataLegacy();
                },
                'getIp'            => function () {
                    return Misc::getIp();
                },
                'getUserGaVar'     => function ($userId, $var) {
                    switch ($var) {
                        case 'cid':
                            return KeyValue::read($userId . '_cid', Misc::tcfg('cidEmpty'));
                        case 'cfduid':
                            return KeyValue::read($userId . '_cfduid', '');
                    }

                    return '';
                },
                'getUserLastLogin' => function ($userId) {
                    return Misc::getUserLastLogin($userId);
                },
                'getUserCPAParam'  => function ($userId, $param = '') {
                    $user = UsersTable::instance()->get($userId);
                    if (empty($param)) {
                        return $user->clickid;
                    }
                    $params = json_decode($user->clickid, true);
                    if (empty($params)) {
                        if (empty($user->clickid)) {
                            return '';
                        } else {
                            return $user->clickid;
                        }
                    }

                    if (!isset($params[$param])) {
                        return '';
                    } else {
                        return $params[$param];
                    }
                },
                'ga'               => function ($event, $params, $userId) {
                    $url = 'https://www.google-analytics.com/collect';
                    $cid = KeyValue::read($userId . '_cid', Misc::tcfg('cidEmpty'));


                    if (DEBUG) {
                        LogTable::write('GA_DEBUG', ['cid' => $cid, 'data' => $params, 'user' => $userId], $userId);
                    }

                    $result = Misc::httpPost($url, [
                            'v'   => '1',
                            't'   => $event,
                            'tid' => Misc::tcfg('ga'),
                            'cid' => $cid,
                        ] + $params);

                    if (DEBUG) {
                        LogTable::write('GA_DEBUG_RESULT', $result, $userId);
                    }


                    return $result;
                },
                'SQLite3'          => function ($dbName) {
                    $basePath = Configure::read('App.sandboxSqlitePath');
                    if (is_null($basePath) || empty($basePath)) {
                        echo 'Error. Define base path before.';

                        return false;
                    }
                    $dbPath = $basePath . DS . CurrentUser::get('id');
                    File::createPathIfNotExist($dbPath);

                    return new \SQLite3($dbPath . DS . $dbName);
                },
                'transferTokens'   => function ($userId, $amount = false) {
                    return SendTokensShell::addTransfer($userId, $amount);
                },
                'getCsv'           => function ($data) {
                    $filename = TMP . uniqid() . '.csv';
                    CsvWriter::writeCsv($filename, $data);
                    $csv = file_get_contents($filename);;
                    unlink($filename);

                    return $csv;
                },
            ]);
            self::$_sandbox->setOption('allow_escaping', true);
            self::$_sandbox->blacklistFunc(self::FUNC_BLACKLIST);
        }

        return static::$_sandbox;
    }

    /**
     * Run code in sandbox
     * @param string|mixed $code
     * @param array $vars
     * @param array $options
     * @return mixed
     * @throws \Exception
     */
    public static function run($code, $vars = [], $options = [])
    {
        return self::instance()->defineVars($vars)->setOptions($options)->execute('<?php ?>' . $code);
    }

    /**
     * Run code in sandbox from storage
     * @param string $key
     * @param array $options
     * @throws \Exception
     * @return mixed
     */
    public static function runFromStorage($key, $vars = [], $options = [])
    {
        $script = KeyValue::read($key, '<?php return false;?>');

        return self::run($script, $vars, $options);
    }

    /**
     * Run code return false on exceptions
     * @param $code
     * @param array $options
     * @return bool|mixed
     */
    public static function runOrIgnore($code, $vars = [], $options = [])
    {
        try {
            return self::run($code, $vars, $options);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Run code from key-value storage return false on exception
     * @param $key
     * @param array $options
     * @return bool|mixed
     */
    public static function runFromStorageOrIgnore($key, $vars = [], $options = [])
    {
        try {
            return self::runFromStorage($key, $vars, $options);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Setup internal-external interface
     * @param $key
     * @param $instance
     */
    public static function setInternalExternal($key, $instance)
    {
        self::$_internalExternal[$key] = $instance;
    }

}
