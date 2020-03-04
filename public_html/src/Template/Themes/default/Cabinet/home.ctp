<?php
/**
 * @var string $refLink
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\User[] $refs
 * @var array $refsMoney
 * @var array $langs
 * @var \App\View\AppView $this
 * @var \Cake\Controller\Component\FlashComponent $FlashInstance
 * @var \App\Model\Entity\KycAttempts $KYCLastAttempt
 *
 */

$enabledCurrency = \Cake\Core\Configure::read('App.enabledCurrencies');
$countDownTo = \App\Lib\Calculator::getPeriods()[\App\Lib\Calculator::getPeriod()][(TOKENSALE_ACTIVE ?
    'end' : 'start')];

$countDown = strtotime($countDownTo) * 1000;
$stageLive = (count($stages) && $stages['periods'][0]['live']) ? $stages['periods'][0]['live'] : 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= \App\Lib\Misc::projectName() ?></title>

    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="profile" href="http://gmpg.org/xfn/11">

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

    <base href="<?= URL_PREFIX ?>" />

    <?php
    \App\Lib\Sandbox::runFromStorageOrIgnore('beforeCss', ['user' => $user]);
    ?>

    <link rel="shortcut icon" href="<?= \App\Lib\Misc::tcfg('favicon') ?>">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/css/cabinet.css?_=<?= CORE_VERSION ?>"/>
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/css/flash.css?_=<?= CORE_VERSION ?>"/>
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

<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=<?= \App\Lib\Misc::tcfg('gtm') ?>"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
<script>
    var stageLive = <?= $stageLive ?>;
</script>
<script>
    var countDown = <?= $countDown ?>;

    <?php
    if(!empty($this->request->session()->read('gtmOkLogin'))){
        $this->request->session()->delete('gtmOkLogin');
        ?>

        try {
        dataLayer.push({
        'event': 'signed in',
        'attributes': {
        'userid': '<?=$user->id?>',
        'timestamp': <?= time()?>
        }
        });
        } catch (e) {
        }

        <?php
        }
    ?>


    <?php
    if(!empty($this->request->session()->read('gtmOkRegister'))){
    $this->request->session()->delete('gtmOkRegister');
    ?>

    try {

        dataLayer.push({
            'event': 'signed up',
            'attributes': {
                'userid': '<?=$user->id?>',
                'timestamp': <?= time()?>
        }
        });
        } catch (e) {
    }

    <?php
    }
    ?>

    try {
        dataLayer.push({
            'attributes': {
                'userid': '<?=$user->id?>',
                'timestamp': <?= time()?>
        }
        });
        } catch (e) {
    }
</script>

<div class="cab-wrapper">
    <header class="cab-header">
        <div class="cab-container">
            <div class="cab-header__wrap">
                <div class="cab-header__left">
                    <a href="<?= \App\Lib\Misc::mainSite() ?>" class="cab-header__logo main-logo"><img src="<?= \App\Lib\Misc::tcfg('logo') ?>" alt="logo"></a>
                    <?php
                    if($stageLive){
                    ?>
                        <div class="cab-header__counter-wrap">
                            <div class="cab-header__counter-txt"><?= __('Stage ends in') ?></div>
                            <div class="cab-header__counter js-timer-days">
                                <span class="js-days"></span>:
                                <span class="js-hours"></span>:
                                <span class="js-minutes"></span>:
                                <span class="js-seconds"></span>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
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
                            <a class="btn cab-header__user-item cab-header__user-item--user" href="<?= URL_PREFIX ?>/cabinet/profile"><?= __('Profile') ?></a>
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

            <section class="cab-sec">
                <h1 class="cab-main-header"><?= __('How to buy') . ' ' . \App\Lib\Misc::tokenName() ?></h1>
                <div class="cab-blc cab-step-1">
                    <div class="cab-blc__numb">1</div>

                    <div class="cab-step-1__top">
                        <div class="cab-blc-small-title"><?= __('Choose tokens amount and payment currency') ?></div>

                        <?php if (\Cake\Core\Configure::read('KYC.enabled')) {
                            if ($user->kyc_reached) {
                        ?>
                            <span class="cab-step-1__message ok"><?= __('KYC successfully passed') ?></span>
                        <?php
                            } else {
                                if ($KYCLastAttempt) {
                                    if ($KYCLastAttempt->finish) {
                        ?>
                                        <div>
                                            <div class="cab-step-1__message error">
                                                <?= __('Previous attempt KYC failed: ') .' '. $KYCLastAttempt->comment; ?>
                                            </div>
                                            <a href="<?= URL_PREFIX ?>/kyc/pass" class="btn cab-btn--blue cab-header__btn" style="margin-right: 0px;"><?= __('Start') ?></a>
                                        </div>

                                        <?php
                                    } else {
                                    ?>
                                        <div>
                                            <span><?= __('Pending KYC status.') ?></span>
                                            <a href="<?= URL_PREFIX ?>/kyc/pass" class="btn cab-btn--blue cab-header__btn"><?= __('Continue') ?></a>
                                        </div>

                                    <?php
                                    }
                                } else {
                                    ?>
                                    <a href="<?= URL_PREFIX ?>/kyc/pass" class="cab-step-1__message error"><?= __('Pass KYC to buy over 10 000 USD') ?></a>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>

                    <div class="cab-step-1__wrap">



                        <?php if (!empty($user->balance) && TOKENSALE_ACTIVE) { ?>
                        <div id="step3">
                            <div class="main-block-step third-step"><?= __('Buy tokens from deposit') ?></div>
                            <form method="post" action="<?= URL_PREFIX ?>/cabinet/buyTokens">
                                <div class="buy-tokens-list row">
                                    <div class="buy-tokens-item">
                                        <div class="buy-tokens-title"><?= __('Token count') ?>:</div>
                                        <div class="buy-tokens-amount tokens-input">
                                            <input class="choose-input" name="tokens" id="tokenBuyInput" type="text"
                                                   placeholder="">
                                        </div>
                                    </div>
                                    <div class="buy-tokens-item">
                                        <div class="buy-tokens-title"><?= __('Bonus') ?>:</div>
                                        <div class="buy-tokens-amount" id="tokenBuyBonus">0</div>
                                    </div>
                                    <div class="buy-tokens-item">
                                        <div class="buy-tokens-title"><?= __('Total') ?>:</div>
                                        <div class="buy-tokens-amount" id="tokenBuyUsd">$ 0</div>
                                    </div>
                                    <div class="tokens-radio">
                                        <input id="deposit-checkbox" type="checkbox"><label
                                            class="deposit-checkbox-label"
                                            for="deposit-checkbox"><?= __('Spend all funds in your account to buy tokens') ?></label>
                                    </div>
                                    <div class="tokens-submit">
                                        <input class="btn btn-dark-green disabled" id="tokensBuy" type="submit"
                                               value="<?= __('Buy') ?>">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <br>
                        <br>
                        <?php } ?>



                        <div class="cab-step-1__col">
                            <div class="cab-step-1__col-main">
                                <input class="input cab-step-1__col-val js-numb" type="text" id="tokenInput" autofocus value="<?= \App\Lib\Misc::tcfg('startValue') ?>">
                                <div class="cab-step-1__col-unuts">
                                    <div class="cab-step-1__col-unuts-val"><?= \App\Lib\Misc::tokenName() ?></div>
                                </div>
                            </div>
                            <div class="cab-step-1__col-bar">
                                <div class="cab-step-1__col-bar-bonus bonus-rate">
                                    <span>0%</span>
                                    <?= __('Bonus') ?>
                                </div>
                                <div class="cab-step-1__col-bar-txt">
                                    <span class="bonus-sum">0 <?= \App\Lib\Misc::tokenName() ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="cab-step-1__icn"></div>

                        <?php if (count($currenciesEnabledList)) {
                        ?>
                        <div class="cab-step-1__col">
                            <div class="cab-step-1__col-main">
                                <input class="input cab-step-1__col-val js-numb" type="text" value="0" id="currencyInput">
                                <div class="cab-step-1__col-unuts cab-step-1__col-unuts--drop js-dropblock">
                                    <div class="cab-step-1__col-unuts-val cab-step-1__col-unuts-val--logo <?= $currenciesEnabledList[0]['name']?>"><span id="currency" data-currency-name="<?= $currenciesEnabledList[0]['name'] ?>"><?= $currenciesEnabledList[0]['abbr']?></span></div>
                                    <div class="cab-step-1__col-unuts-drop-blc js-droplist">
                                        <?php
                                        foreach($currenciesEnabledList as $key => $currency){
                                            $active = (0 == $key) ? 'active' : '';
                                        ?>
                                            <a class="btn cab-step-1__col-unuts-drop-btn currency-item <?= $currency['name']; ?> <?= $active;?>"><span data-currency-name="<?= $currency['name']; ?>"><?= $currency['abbr']; ?></span></a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="cab-step-1__col-bar">
                                <div class="cab-step-1__col-bar-txt"><?= __('Total') ?></div>
                                <div class="cab-step-1__col-bar-txt cab-step-1__col-bar-txt--big bitcoin-sum-total">0 <?= \App\Lib\Misc::tokenName() ?></div>
                            </div>
                        </div>
                        <?php
                         }
                        ?>
                    </div>
                </div>

                <?php if (\App\Lib\Misc::depositEnabled() || TOKENSALE_ACTIVE) { ?>
                    <div class="cab-blc cab-step-2">
                        <div class="cab-blc__numb">2</div>
                        <div class="cab-blc-small-title"><?= __('Get payment information') ?></div>

                        <div id="depositSelector">
                            <?php if (\App\Lib\Misc::depositEnabled() && TOKENSALE_ACTIVE) { ?>
                            <p><input name="deposit" type="radio" value="1"> <?= __('Make a deposit') ?></p>
                            <p><input name="deposit" type="radio" value="0" checked> <?= __('Buy tokens') ?></p>
                            <?php } else {
                                    if (TOKENSALE_ACTIVE) {
                                        ?>
                            <input name="deposit" type="hidden" value="0">
                            <?php
                                    } else { ?>
                            <input name="deposit" type="hidden" value="1">
                            <?php
                                    }
                                } ?>
                        </div>

                        <div class="cab-step-2__wrap">
                            <div class="cab-step-2__col">
                                <div class="cab-step-2__txt">
                                    <p><?= __('Go to your wallet account and send money to the showed address. Please make sure that your deposit exceeds the minimum purchase amount.') ?></p>
                                    <p><?= __('Deposit will appear on your account only after a few block confirmations. It can take from 10 minutes to 2 hours or more, depending on your payment method.') ?> </p>
                                </div>
                                <button class="btn cab-btn--blue cab-step-2__btn getAdress"><?= __('Get payment address') ?></button>
                            </div>

                            <div class="cab-step-2__col loader" style="height: 250px; display: none;">
                            </div>
                            <div class="cab-step-2__col addressHolder" style="display: none;"></div>
                            <div class="cab-step-2__col addressHolderTpl">
                                <div class="cab-qr">
                                    <div class="cab-qr__pic">
                                        <div class="cab-qr__pic-wrap cab-qr__pic-wrap--no-qr">
                                        </div>
                                    </div>
                                    <div class="cab-qr__main">
                                        <div class="cab-qr__top">
                                            <div class="cab-qr__logo cab-qr__logo--no-qr"></div>
                                            <div class="cab-qr__title cab-qr__title--no-qr"></div>
                                        </div>
                                        <div class="cab-qr__code"><span class="cab-qr__code-mask">&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;&#8194;</span></div>
                                        <input type="text" id="js-qr" value="">

                                        <div class="cab-qr__copy cab-qr__copy--no-qr"></div>
                                        <div class="cab-qr__bar" id="qr-copy-cont" style="display: none;">
                                            <button class="btn cab-qr__copy" id="js-qr-button"></button>
                                            <div class="cab-copy-effect cab-qr__copy-effect"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php } else {
                    if (!empty($countDownTo)) { ?>
                        <h2 class="main-block-title"><?= __('Token sale starts in') ?></h2>
                        <div class="one-timer">
                            <div id="clock-block" class="clock-block">
                                <div class="clock-box day-box">
                                    <span id="days" class="clock-num days-counter"></span>
                                </div>
                                <span class="clock-devider">:</span>
                                <div class="clock-box day-box">
                                    <span id="hours" class="clock-num hours-counter"></span>
                                </div>
                                <span class="clock-devider">:</span>
                                <div class="clock-box day-box">
                                    <span id="minutes" class="clock-num minutes-counter"></span>
                                </div>
                                <span class="clock-devider">:</span>
                                <div class="clock-box day-box">
                                    <span id="seconds" class="clock-num seconds-counter"></span>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                } ?>


                <?php
                    if(count($stages)) {
                ?>
                <div class="cab-blc cab-curent">
                    <div class="cab-curent__wrap">
                        <?php
                            if($stages['periods'][0]['live'] && isset($stages['periodSales'][0])) {
                        ?>
                                <div class="cab-curent__curent">
                                <h2 class="cab-curent__title"><?= __('Current') ?></h2>
                                <div class="cab-curent__time-blc">
                                    <div class="cab-curent__time-title"><?= __('Stage ends in') ?></div>
                                    <div class="cab-curent__counter js-timer-days">
                                        <div class="cab-curent__counter-item">
                                            <div class="cab-curent__counter-val"><span class="js-days"></span></div>
                                            <div class="cab-curent__counter-txt"><?= __('days') ?></div>
                                        </div>
                                        <div class="cab-curent__counter-dots">:</div>
                                        <div class="cab-curent__counter-item">
                                            <div class="cab-curent__counter-val"><span class="js-hours"></span></div>
                                            <div class="cab-curent__counter-txt"><?= __('hours') ?></div>
                                        </div>
                                        <div class="cab-curent__counter-dots">:</div>
                                        <div class="cab-curent__counter-item">
                                            <div class="cab-curent__counter-val"><span class="js-minutes"></span></div>
                                            <div class="cab-curent__counter-txt"><?= __('minutes') ?></div>
                                        </div>
                                        <div class="cab-curent__counter-dots">:</div>
                                        <div class="cab-curent__counter-item">
                                            <div class="cab-curent__counter-val"><span class="js-seconds"></span></div>
                                            <div class="cab-curent__counter-txt"><?= __('seconds') ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cab-curent__tab-blc">
                                    <div class="cab-curent__tab-title"><?= __('Current bonus') ?></div>
                                    <div class="cab-curent__tab cab-curent__tab--blue">
                                        <?php
                                        foreach($stages['periodSales'][0] as $bonus => $value)
                                        {
                                        ?>
                                            <div class="cab-curent__tab-col">
                                                <div class="cab-curent__tab-col-name">
                                                    <?php
                                                    if($value['max'] >= 922337203685)
                                                    {
                                                        echo __('from').'&nbsp;'.$value['min'].'<br />';
                                                    }
                                                    else
                                                    {
                                                        echo $value['min'].'-'.$value['max'];
                                                    }
                                                        echo '&nbsp;'.\App\Lib\Misc::tokenName();
                                                    ?>
                                                </div>
                                                <div class="cab-curent__tab-col-val"><?= $bonus;?>%</div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        ?>
                        <?php
                        foreach($stages['periods'] as $key => $stage){
                            if(isset($stage['live']) && $stage['live']){
                                continue;
                            }
                        ?>
                            <div class="cab-curent__next" style="border-right: 1px solid #231480;">
                                <h2 class="cab-curent__title"><?= __('Next') ?></h2>
                                <div class="cab-curent__time-blc">
                                    <div class="cab-curent__time-title"><?= __('Stage ends in') ?></div>
                                    <div class="cab-curent__counter-val">
                                        <?php
                                            $date = new DateTime($stages['periods'][$key]['end']);
                                            if('Ru' == ucfirst(h(\Cake\I18n\I18n::locale())))
                                            {
                                                echo $date->format('j F');
                                            }
                                            else
                                            {
                                                echo $date->format('F, j');
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="cab-curent__tab-blc">
                                    <div class="cab-curent__tab-title"><?= __('Next bonus') ?></div>
                                    <div class="cab-curent__tab">
                                        <?php
                                            foreach($stages['periodSales'][$key] as $bonus => $value)
                                        {
                                        ?>
                                        <div class="cab-curent__tab-col">
                                            <div class="cab-curent__tab-col-name">
                                                <?php
                                                if($value['max'] >= 922337203685)
                                                {
                                                    echo __('from').'&nbsp;'.$value['min'].'<br />';
                                                }
                                                else
                                                {
                                                    echo $value['min'].'-'.$value['max'];
                                                }
                                                echo '&nbsp;'.\App\Lib\Misc::tokenName();
                                                ?>
                                            </div>
                                            <div class="cab-curent__tab-col-val"><?= $bonus;?>%</div>
                                        </div>
                                        <?php
                                            }
                                            ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
                    }
                ?>
            </section>

            <?php if (\App\Lib\Misc::tcfg('enableReferal')) { ?>
                <section class="cab-sec">
                    <h2 class="cab-sec-header"><?= __('Referal link') ?></h2>
                    <div class="cab-sec-message"><?= __('Your reward amounts to {0}% of all tokens purchased by your referrals.', \App\Lib\Referal::getReferalBonus()); ?></div>
                    <div class="cab-blc cab-copylink">
                        <div class="cab-copylink__wrap">
                            <div class="cab-copylink__form" id="js-link-cont">
                                <input type="text" class="input cab-copylink__input" value="<?= $refLink ?>" id="js-copy-txt">
                                <button class="btn cab-btn--blue cab-copylink__copy" id="js-copy-btn"><?= __('Copy address') ?></button>
                                <div class="cab-copy-effect cab-copy-effect-position-2 cab-qr__copy-effect"><?= __('Copied') ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="cab-blc cab-referals">
                        <h2 class="cab-blc-title"><?= __('Your referals') ?></h2>
                        <?php if (count($refs) > 0) { ?>
                            <div class="cab-referals__wrap">
                                <div class="cab-referals__row cab-referals__theader">
                                    <div class="cab-referals__col"><?= __('User') ?></div>
                                    <div class="cab-referals__col"><?= __('Registration date') ?></div>
                                    <div class="cab-referals__col"><?= __('Tokens') ?></div>
                                </div>
                                <?php foreach ($refs as $ref): ?>
                                    <div class="cab-referals__row cab-referals__tr">
                                        <div class="cab-referals__col"><?= \App\Lib\Misc::maskEmail($ref['name']) ?></div>
                                        <div class="cab-referals__col"><?= (new DateTime($ref['created']))->format('d F Y, H:i:s') ?></div>
                                        <div class="cab-referals__col"><?= $ref['amount'] ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php } else { ?>
                        <div class="referal-title"><?= __('Empty') ?></div>
                        <?php } ?>
                    </div>
                </section>
            <?php } ?>


            <?php if (\App\Lib\Misc::tcfg('enableFAQ')) {
                echo $this->element('faq');
            } ?>

        </div>
    </main>

    <?= $this->element('cabFooter') ?>

</div>

<script>
    var balance = <?=$user->balance?>;
    var tokens = <?=$user->balance?>;
    var tokenName = '<?=\App\Lib\Misc::tokenName()?>';
    var viewTokenPrecision = <?=\App\Lib\Misc::tcfg('viewTokenPrecision')?>;
    var viewPrecision = <?=\App\Lib\Misc::tcfg('viewPrecision')?>;
    var baseAddress = '<?= URL_PREFIX ?>';
    var assetsAddress = '<?= \App\Lib\Misc::mainSite() . URL_PREFIX . APP_THEME_BASE; ?>';

    var txtWalletAddress = '<?= __('your wallet address')?>';
    var txtCopy = '<?= __('Copy address') ?>';
    var txtCopied = '<?= __('Copied') ?>';

    // GOOGLE ANALYTICS AND EVENT TRACKER
    window.GA = JSON.parse('<?=json_encode(\App\Lib\Misc::tcfg('gevents'))?>');

    <?php
    $lastTokens = \App\Lib\KeyValue::read('ga_mutex_' . $user->id, 0);
    //debug($lastTokens);
    //debug($user->tokens);
    if($lastTokens != $user->tokens){
    \App\Lib\KeyValue::write('ga_mutex_' . $user->id, $user->tokens);
    ?>
    dataLayer.push({
        'event': window.GA.purchased.event,
        'amount': '<?= \App\Lib\Calculator::token2Usd($user->tokens - $lastTokens)?>',
        'usd_price': '<?= \App\Lib\Calculator::token2Usd($user->tokens - $lastTokens)?>',
        'userid': '<?=$user->id?>',
        'email': '<?=$user->email?>',
        'timestamp': <?=time()?>,
        'quantity': '<?=$user->tokens - $lastTokens?>',
        'currency': 'USD',
        'userId': '<?= $user->id ?>'
        });

    <?php
    }
    ?>
    // GOOGLE ANALYTICS AND EVENT TRACKER

</script>

<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/vendors/jquery.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/page.js?_=<?= CORE_VERSION ?>"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/cabinet.js?_=<?= CORE_VERSION ?>"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/libs/qrcodejs/qrcode.js"></script>

<?php
\App\Lib\Sandbox::runFromStorageOrIgnore('beforeClosedBody', ['user' => $user]);
?>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter47787229 = new Ya.Metrika2({
                    id: 47787229,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true
                });
            } catch (e) {
            }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () {
                n.parentNode.insertBefore(s, n);
            };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if(w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/47787229" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>
<!-- /Yandex.Metrika counter -->

</body>
</html>