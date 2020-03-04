<?php
/**
 * @var string $refLink
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\User[] $refs
 * @var array $refsMoney
 * @var array $langs
 * @var \App\View\AppView $this
 * @var \Cake\Controller\Component\FlashComponent $FlashInstance
 *
 */

$enabledCurrency = \Cake\Core\Configure::read('App.enabledCurrencies');
$countDownTo = \App\Lib\Calculator::getPeriods()[\App\Lib\Calculator::getPeriod()][(TOKENSALE_ACTIVE ?
    'end' : 'start')];

$countDown = strtotime($countDownTo) * 1000;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= \App\Lib\Misc::projectName() ?></title>

    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- Набор иконок для сайта -->
    <link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
    <link rel="icon" type="image/gif" href="images/favicon.png" >
    <link rel="apple-touch-icon" href="img/favicon/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-touch-icon-114x114.png">

    <!-- Цветовое оформление окон браузеров -->
    <meta name="theme-color" content="#000"><!-- Chrome, Firefox OS and Opera -->
    <meta name="msapplication-navbutton-color" content="#000"><!-- Windows Phone -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#000"><!-- iOS Safari -->

    <link rel="shortcut icon" href="<?= \App\Lib\Misc::tcfg('favicon') ?>">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/css/cabinet.css"/>
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/css/flash.css"/>
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_CSS_BASE ?>/customize.css?_=<?= CORE_VERSION ?>">

    <?= $this->element('ga'); ?>
    <?= $this->element('gtag'); ?>

    <?php
    /*
    \App\Lib\Sandbox::runFromStorageOrIgnore('beforeClosedHead', ['user' => $user]);
    */
    ?>

</head>
<body>
<!--[if lt IE 8]>
<p class="browserhappy">
    Your browser is <strong>out of date</strong>. Please <a href="https://browsehappy.com/"  target="_blank">update it</a> его.
</p>
<![endif]-->

<script>
    var countDown = <?= $countDown ?>;
    var activeSectionNumber = <?= $activeSectionNumber ?>;
</script>

<div class="cab-wrapper">
    <header class="cab-header">
        <div class="cab-container">
            <div class="cab-header__wrap">
                <div class="cab-header__left">
                    <a href="<?= \App\Lib\Misc::mainSite() ?>" class="cab-header__logo main-logo"><img src="<?= \App\Lib\Misc::tcfg('logo') ?>" alt="logo"></a>
                    <div class="cab-header__counter-wrap">
                        <div class="cab-header__counter-txt"><?= __('Stage ends in') ?></div>
                        <div class="cab-header__counter js-timer-days">
                            <span class="js-days"></span>:
                            <span class="js-hours"></span>:
                            <span class="js-minutes"></span>:
                            <span class="js-seconds"></span>
                        </div>
                    </div>
                </div>
                <div class="cab-header__right">
                    <div class="cab-header__cix"><?= $this->Number->format($user->tokens - $user->in_chain) .' '. \App\Lib\Misc::tokenName() ?> / <span><?= $user->tokens_bonus.' '.__('Bonus') ?> <?= \App\Lib\Misc::tokenName() ?></span></div>
                    <button class="btn cab-btn--blue cab-header__btn"><?= __('Withdraw tokens'); ?></button>
                    <div class="cab-header__user js-dropblock">
                        <div class="cab-header__user-val"><?= h($user->name) ?></div>
                        <div class="cab-header__drop cab-header__user-drop js-droplist">
                            <?php if ($user->is_admin) { ?>
                            <a class="btn cab-header__user-item" href="<?= URL_PREFIX ?>/admin"><?= __('Admin') ?></a>
                            <?php } ?>
                            <a class="btn cab-header__user-item cab-header__user-item--user" href="<?= URL_PREFIX ?>/cabinet/home"><?= __('Tokens') ?></a>
                            <a class="btn cab-header__user-item cab-header__user-item--out" href="<?= URL_PREFIX ?>/app/logout"><?= __('Log out') ?></a>
                        </div>
                    </div>
                    <div class="cab-header__lang js-dropblock">
                        <div class="cab-header__lang-val" id="js-lang-val"><?= ucfirst(h(\Cake\I18n\I18n::locale())) ?></div>
                        <div class="cab-header__drop cab-header__lang-drop js-droplist">
                            <?php
                        foreach ($langs as $lang) {
                        ?>
                            <a class="btn cab-header__lang-item js-lang-item" href="<?= URL_PREFIX ?>/cabinet/changeLang/<?= h($lang) ?>"><?= ucfirst(h($lang)) ?></a>
                            <?php
                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main class="cab-main">
        <div class="cab-container">

            <br />
            <?= $this->Flash->render() ?>

            <section class="cab-sec js-tabs" id="js-tabs">
                <div id="js-tabs-wrap">
                    <div class="cab-tabs-wrap">
                        <button class="btn cab-tab js-tab"><?= __('Profile') ?></button>
                        <button class="btn cab-tab js-tab"><?= __('Password') ?></button>
                        <button class="btn cab-tab js-tab"><?= __('Incoming transactions') ?></button>
                        <button class="btn cab-tab js-tab"><?= __('Login attempts history') ?></button>
                        <?php
                        if (!empty($user->password)) {
                        ?>
                            <button class="btn cab-tab js-tab"><?= __('Two-factor Authentication') ?></button>
                        <?php
                        }
                        ?>
                        <div class="cab-tab-roll" id="js-roll"></div>
                    </div>
                    <div class="cab-tabs-items">
                        <div class="cab-tabs-item js-item">
                            <div class="cab-tabs-name js-cases-name"><?= __('Profile') ?></div>
                            <div class="cab-blc cab-account cab-tabs-item__blc js-cases-slide">
                                <h2 class="cab-tabs-item__title"><?= __('Account') ?></h2>
                                <?php if ($user->kyc_reached) { ?>
                                    <p class="text-warning"><?= __('Editing account data is not available after KYC passing') ?></p>
                                <?php } ?>
                                <form method="post" class="accountForm cab-account__form" enctype="multipart/form-data"
                                      action="<?= URL_PREFIX ?>/cabinet/profile">
                                    <input name="_CSRF" type="hidden" value="<?= \App\Lib\Crypt::ecrypt('CSRF_' . rand()) ?>">

                                    <div class="cab-account__col">
                                        <label class="input-wrap input-wrap--name">
                                                <span class="input--nariko">
                                                    <input class="input__field input__field--nariko" type="text" name="name"
                                                           value="<?= h($user->name) ?>"
                                                            <?= $user->kyc_reached ? 'disabled="disabled"' : ''; ?>
                                                    >
                                                    <span class="input__label--nariko">
                                                        <span class="input__label-content input__label-content--nariko"><?= __('Full name') ?></span>
                                                    </span>
                                                </span>
                                        </label>
                                        <label class="input-wrap input-wrap--name">
                                                <span class="input--nariko">
                                                    <input class="input__field input__field--nariko js-numb" type="date" name="date_of_birth">
                                                    <span class="input__label--nariko">
                                                        <span class="input__label-content input__label-content--nariko">Date of Birth</span>
                                                    </span>
                                                </span>
                                        </label>
                                        <label class="input-wrap input-wrap--name">
                                                <span class="input--nariko">
                                                    <input class="input__field input__field--nariko js-numb" type="text" name="id">
                                                    <span class="input__label--nariko">
                                                        <span class="input__label-content input__label-content--nariko">Passport / ID number</span>
                                                    </span>
                                                </span>
                                        </label>
                                        <div class="cab-account__row">
                                            <div class="input-wrap input-wrap--name cab-main-form__dropgroup js-dropgroup">
                                                    <span class="input--nariko">
                                                        <input class="input__field input__field--nariko" type="text" name="nationality">
                                                        <span class="input__label--nariko">
                                                            <span class="input__label-content input__label-content--nariko">Nationality</span>
                                                        </span>
                                                    </span>
                                                <div class="cab-main-form__drop js-mainform-drop">
                                                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="America">America</div>
                                                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="Trinidad and Tobago">Trinidad and Tobago</div>
                                                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="Russia">Russia</div>
                                                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="North Korea">North Korea</div>
                                                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="Papua New Guinea">Papua New Guinea</div>
                                                </div>
                                            </div>



                                            <div class="input-wrap input-wrap--name cab-main-form__dropgroup js-dropgroup">
                                                    <span class="input--nariko">
                                                        <input class="input__field input__field--nariko" type="text" name="country">
                                                        <span class="input__label--nariko">
                                                            <span class="input__label-content input__label-content--nariko">Country</span>
                                                        </span>
                                                    </span>
                                                <div class="cab-main-form__drop js-mainform-drop">
                                                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="America">America</div>
                                                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="Trinidad and Tobago">Trinidad and Tobago</div>
                                                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="Russia">Russia</div>
                                                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="North Korea">North Korea</div>
                                                    <div class="cab-main-form__drop-item js-mainform-drop-item" data-val="Papua New Guinea">Papua New Guinea</div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="input-wrap input-wrap--name">
                                                <span class="input--nariko">
                                                    <input class="input__field input__field--nariko" type="text" name="city">
                                                    <span class="input__label--nariko">
                                                        <span class="input__label-content input__label-content--nariko">City</span>
                                                    </span>
                                                </span>
                                        </label>
                                        <label class="input-wrap input-wrap--name">
                                                <span class="input--nariko">
                                                    <input class="input__field input__field--nariko" type="text" name="address">
                                                    <span class="input__label--nariko">
                                                        <span class="input__label-content input__label-content--nariko">Address</span>
                                                    </span>
                                                </span>
                                        </label>
                                        <label class="input-wrap input-wrap--name">
                                                <span class="input--nariko">
                                                    <input class="input__field input__field--nariko js-numb" type="text" name="zipcode">
                                                    <span class="input__label--nariko">
                                                        <span class="input__label-content input__label-content--nariko">Zipcode</span>
                                                    </span>
                                                </span>
                                        </label>
                                        <button class="btn cab-btn--blue cab-account__submit" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="cab-tabs-item js-item">
                            <div class="cab-tabs-name js-cases-name"><?= __('Password') ?></div>
                            <div class="cab-blc cab-account cab-tabs-item__blc js-cases-slide">
                                <h2 class="cab-tabs-item__title"><?= __('Password') ?></h2>
                                <form method="post" class="accountForm cab-account__form">
                                    <input name="_CSRF" type="hidden" value="<?= \App\Lib\Crypt::ecrypt('CSRF_' . rand()) ?>">
                                    <div class="cab-account__col">
                                        <label class="input-wrap input-wrap--name">
                                                <span class="input--nariko">
                                                    <input class="input__field input__field--nariko" type="password" id="oldpass" name="oldpass">
                                                    <span class="input__label--nariko">
                                                        <span class="input__label-content input__label-content--nariko"><?= __('Old password') ?></span>
                                                    </span>
                                                </span>
                                        </label>
                                        <label class="input-wrap input-wrap--name">
                                                <span class="input--nariko">
                                                    <input class="input__field input__field--nariko" type="password" id="password" name="password">
                                                    <span class="input__label--nariko">
                                                        <span class="input__label-content input__label-content--nariko"><?= __('New password') ?></span>
                                                    </span>
                                                </span>
                                        </label>
                                        <label class="input-wrap input-wrap--name">
                                                <span class="input--nariko">
                                                    <input class="input__field input__field--nariko" type="password" id="passwordconfirm" name="passwordconfirm">
                                                    <span class="input__label--nariko">
                                                        <span class="input__label-content input__label-content--nariko"><?= __('Repeat password') ?></span>
                                                    </span>
                                                </span>
                                        </label>
                                        <button class="btn cab-btn--blue cab-account__submit" type="submit"><?= __('Save new password') ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="cab-tabs-item js-item">
                            <div class="cab-tabs-name js-cases-name"><?= __('Incoming transactions') ?></div>
                            <div class="cab-blc cab-transactions cab-tabs-item__blc js-cases-slide">
                                <h2 class="cab-tabs-item__title"><?= __('Incoming transactions') ?></h2>
                                <div class="cab-transactions__wrap">
                                    <div class="cab-transactions__row cab-tab__row cab-tab__row--thead">
                                        <div class="cab-tab__col"><div class="cab-tab__th"><?= __('Date') ?></div></div>
                                        <div class="cab-tab__col"><div class="cab-tab__th"><?= __('Amount') ?></div></div>
                                        <div class="cab-tab__col"><div class="cab-tab__th"><?= __('Currency') ?></div></div>
                                        <div class="cab-tab__col"><div class="cab-tab__th"><?= __('Address') ?></div></div>
                                    </div>

                                    <?php if (!empty($userEntity->transactions)) : ?>
                                    <?php foreach ($userEntity->transactions as $transaction) : ?>
                                        <div class="cab-transactions__row cab-tab__row">
                                            <div class="cab-tab__col">
                                                <div class="cab-tab__hide"><?= __('Date') ?></div>
                                                <time class="cab-tab__time" datetime="2010-01-01T10:12:41+03:00"><?= $transaction->created ?></time>
                                            </div>
                                            <div class="cab-tab__col">
                                                <div class="cab-tab__hide"><?= __('Amount') ?></div>
                                                <div><?= $transaction->amount ?></div>
                                            </div>
                                            <div class="cab-tab__col">
                                                <div class="cab-tab__hide"><?= __('Currency') ?></div>
                                                <div><?= $transaction->currency ?></div>
                                            </div>
                                            <div class="cab-tab__col">
                                                <div class="cab-tab__hide"><?= __('Address') ?></div>
                                                <div class="cab-tab__long"><?= \App\Lib\Misc::extractPaymentAddr($transaction->rawdata) ?></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <?php else : ?>
                                        <br />
                                        <div><?= __('Empty') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="cab-tabs-item js-item">
                            <div class="cab-tabs-name js-cases-name"><?= __('Login attempts history') ?></div>
                            <div class="cab-blc cab-history cab-tabs-item__blc js-cases-slide">
                                <h2 class="cab-tabs-item__title"><?= __('Login attempts history') ?></h2>
                                <div class="cab-history__wrap">
                                    <div class="cab-history__row cab-tab__row cab-tab__row--thead">
                                        <div class="cab-tab__col"><div class="cab-tab__th"><?= __('Date') ?></div></div>
                                        <div class="cab-tab__col"><div class="cab-tab__th"><?= __('IP') ?></div></div>
                                        <div class="cab-tab__col"><div class="cab-tab__th"><?= __('User Agent') ?></div></div>
                                        <div class="cab-tab__col"><div class="cab-tab__th"></div></div>
                                    </div>

                                    <?php if (!empty($loginAttempts)) {
                                        $loginAttempts = array_reverse($loginAttempts);
                                        foreach ($loginAttempts as $loginAttempt) { ?>
                                            <div class="cab-history__row cab-tab__row">
                                                <div class="cab-tab__col">
                                                    <div class="cab-tab__hide"><?= __('Date') ?></div>
                                                    <time class="cab-tab__time" datetime="2010-01-01T10:12:41+03:00"><?= (new DateTime($loginAttempt['date']))->format('d F Y, H:i:s') ?></time>
                                                </div>
                                                <div class="cab-tab__col">
                                                    <div class="cab-tab__hide"><?= __('IP') ?></div>
                                                    <div><?= $loginAttempt['ip'] ?></div>
                                                </div>
                                                <div class="cab-tab__col">
                                                    <div class="cab-tab__hide"><?= __('User Agent') ?></div>
                                                    <div class="cab-tab__long"><?= $loginAttempt['userAgent'] ?></div>
                                                </div>
                                                <div class="cab-tab__col">
                                                    <div class="cab-tab__check cab-tab__check--<?= $loginAttempt['successful'] ? 'ok' : 'error' ?>"></div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <br />
                                        <div><?= __('Empty') ?></div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                        <?php
                        if (!empty($user->password)) {
                        ?>
                        <div class="cab-tabs-item js-item">
                            <div class="cab-tabs-name js-cases-name"><?= __('Two-factor Authentication') ?></div>
                            <div class="cab-blc cab-authentication cab-tabs-item__blc js-cases-slide">
                                <h2 class="cab-tabs-item__title"><?= __('Two-factor Authentication') ?></h2>
                                <div class="cab-authentication__wrap">
                                    <div style="width: 238px; margin-bottom: 20px;">
                                        <a href="<?= URL_PREFIX ?>/TwoFactorAuth/<?= $user->isEnable2fa ? 'deactivate' :
                                                'activate' ?>" class="btn cab-btn--blue"><?= $user->isEnable2fa ? __('Deactivate') : __('Activate') ?>
                                        </a>
                                    </div>
                                    <div class="cab-authentication__main">
                                        <div class="cab-authentication__txt">
                                            <?= __('Two-factor authentication (2FA) - is a security process that requires users to provide two means of authentication before accessing the account. Two levels of security - it\'s your password and unique code generated by a special application for authentication installed on your smartphone.') ?>
                                            <?= __('This code will be used to sign in to your account.') ?>
                                            <br /><br />
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>


            </section>
        </div>
    </main>

    <?= $this->element('cabFooter') ?>

</div>

<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/vendors/jquery.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/vendors/nariko.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/page.js"></script>

</body>
</html>