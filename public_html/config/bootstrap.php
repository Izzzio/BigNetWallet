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

$isCli = PHP_SAPI === 'cli';


\Cake\I18n\Date::setToStringFormat('yyyy-MM-dd');
\Cake\I18n\FrozenDate::setToStringFormat('yyyy-MM-dd');
\Cake\I18n\Time::setToStringFormat('yyyy-MM-dd HH:mm:ss');


if (version_compare(PHP_VERSION, '5.5.9') < 0) {
    trigger_error('Your PHP version must be equal or higher than 5.5.9 to use  iZ³ Crowdsale platfrom.', E_USER_ERROR);
}

if (!extension_loaded('intl')) {
    trigger_error('You must enable the intl extension to use iZ³ Crowdsale platfrom.', E_USER_ERROR);
}


if (!extension_loaded('mbstring')) {
    trigger_error('You must enable the mbstring extension to use  iZ³ Crowdsale platfrom.', E_USER_ERROR);
}

require __DIR__ . '/paths.php';


require CORE_PATH . 'config' . DS . 'bootstrap.php';

use Cake\Cache\Cache;
use Cake\Console\ConsoleErrorHandler;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Core\Plugin;
use Cake\Database\Type;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorHandler;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\Network\Request;
use Cake\Utility\Security;

try {
    Configure::config('default', new PhpConfig());
    Configure::load('app', 'default', false);

    //Load APP config
    if (!$isCli) {
        $appConfig = str_replace('.', '_', $_SERVER['HTTP_HOST']);
        define('CURRENT_CONFIG', 'cabinets/' . $appConfig);
        Configure::load(CURRENT_CONFIG, 'default', true);
    }else{
        define('CURRENT_CONFIG', 'app');
    }
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}


//Project Base domain
define('BASE_DOMAIN', Configure::read('App.baseDomain'));
//Project base protocol
define('BASE_PROTOCOL', Configure::read('App.baseProtocol'));

define('APP_DEFAULT_LOCALE', Configure::read('App.defaultLocale'));
define('TOKENSALE_ACTIVE', Configure::read('App.tokensaleActive'));

define('DEBUG', Configure::read('debug'));

//Custom css files for each clients sites
define('APP_CSS_BASE', Configure::read('App.appCssBaseUrl'));

if(!defined('TPL_THEME_NAME')){
    define('TPL_THEME_NAME', 'backmoon');
}
if(!defined('TPL_THEME_NAME_ADMIN')){
    define('TPL_THEME_NAME_ADMIN', 'lte');
}

//Subpath for css, js and other files for selected theme
define('APP_THEME_BASE',  Configure::read('App.Template.subpath') . TPL_THEME_NAME);
define('ADMIN_THEME_BASE',  Configure::read('App.Template.subpath') . TPL_THEME_NAME_ADMIN);

date_default_timezone_set(Configure::read('App.timezone'));


/**
 * Auto domain redirect
 */
if (!$isCli) {
    if ($_SERVER['HTTP_HOST'] !== BASE_DOMAIN) {
        header('Location: ' . BASE_PROTOCOL . '://' . BASE_DOMAIN . mb_substr($_SERVER['REQUEST_URI'], 0, mb_strlen($_SERVER['REQUEST_URI']) - 1, 'utf-8'), 301);
        die();
    }
}


/*
 * Load an environment local configuration file.
 * You can use a file like app_local.php to provide local overrides to your
 * shared configuration.
 */
//Configure::load('app_local', 'default');

/*
 * When debug = false the metadata cache should last
 * for a very very long time, as we don't want
 * to refresh the cache while users are doing requests.
 */
if (!Configure::read('debug')) {
    Configure::write('Cache._cake_model_.duration', '+1 years');
    Configure::write('Cache._cake_core_.duration', '+1 years');
}

/*
 * Set server timezone to UTC. You can change it to another timezone of your
 * choice but using UTC makes time calculations / conversions easier.
 */
// date_default_timezone_set('UTC'+7);

/*
 * Configure the mbstring extension to use the correct encoding.
 */
mb_internal_encoding(Configure::read('App.encoding'));

/*
 * Set the default locale. This controls how dates, number and currency is
 * formatted and sets the default language to use for translations.
 */
//ini_set('intl.default_locale', Configure::read('App.defaultLocale'));

/*
 * Register application error and exception handlers.
 */
if ($isCli) {
    (new ConsoleErrorHandler(Configure::read('Error')))->register();
} else {
    //  (new ErrorHandler(Configure::read('Error')))->register();
    $errorHandler = new \App\Error\AppError(Configure::read('Error'));
    $errorHandler->register();
}

/*
 * Include the CLI bootstrap overrides.
 */
if ($isCli) {
    require __DIR__ . '/bootstrap_cli.php';
}

/*
 * Set the full base URL.
 * This URL is used as the base of all absolute links.
 *
 * If you define fullBaseUrl in your config file you can remove this.
 */
if (!Configure::read('App.fullBaseUrl')) {
    $s = null;
    if (env('HTTPS')) {
        $s = 's';
    }

    $httpHost = env('HTTP_HOST');
    if (isset($httpHost)) {
        Configure::write('App.fullBaseUrl', 'http' . $s . '://' . $httpHost);
    }
    unset($httpHost, $s);
}

Cache::config(Configure::consume('Cache'));
ConnectionManager::config(Configure::consume('Datasources'));
Email::configTransport(Configure::consume('EmailTransport'));
Email::config(Configure::consume('Email'));
Log::config(Configure::consume('Log'));
Security::salt(Configure::consume('Security.salt'));

/*
 * The default crypto extension in 3.0 is OpenSSL.
 * If you are migrating from 2.x uncomment this code to
 * use a more compatible Mcrypt based implementation
 */
//Security::engine(new \Cake\Utility\Crypto\Mcrypt());

/*
 * Setup detectors for mobile and tablet.
 */
Request::addDetector('mobile', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isMobile();
});
Request::addDetector('tablet', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isTablet();
});

/*
 * Enable immutable time objects in the ORM.
 *
 * You can enable default locale format parsing by adding calls
 * to `useLocaleParser()`. This enables the automatic conversion of
 * locale specific date formats. For details see
 * @link http://book.cakephp.org/3.0/en/core-libraries/internationalization-and-localization.html#parsing-localized-datetime-data
 */
Type::build('time')
    ->useImmutable();
Type::build('date')
    ->useImmutable();
Type::build('datetime')
    ->useImmutable();

/*
 * Custom Inflector rules, can be set to correctly pluralize or singularize
 * table, model, controller names or whatever other string is passed to the
 * inflection functions.
 */
//Inflector::rules('plural', ['/^(inflect)or$/i' => '\1ables']);
//Inflector::rules('irregular', ['red' => 'redlings']);
//Inflector::rules('uninflected', ['dontinflectme']);
//Inflector::rules('transliteration', ['/å/' => 'aa']);

/*
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on Plugin to use more
 * advanced ways of loading plugins
 *
 * Plugin::loadAll(); // Loads all plugins at once
 * Plugin::load('Migrations'); //Loads a single plugin named Migrations
 *
 */

/*
 * Only try to load DebugKit in development mode
 * Debug Kit should not be installed on a production system
 */

Configure::write('debug', DEBUG);

if (Configure::read('debug')) {
    Plugin::load('DebugKit', ['bootstrap' => true]);
}

Plugin::load('Migrations');

Plugin::load('Cake/Localized');
//Configure::write('Config.language', 'ru');


Configure::write('Session', [
    'defaults'       => 'php',
    'timeout'        => 1440,
    // The session will timeout after 30 minutes of inactivity
    'cookieTimeout'  => 1440,
    // The session cookie will live for at most 24 hours, this does not effect session timeouts
    'checkAgent'     => false,
    'autoRegenerate' => true,
    // causes the session expiration time to reset on each page load
]);

Plugin::load('ADmad/HybridAuth', ['bootstrap' => true, 'routes' => true]);