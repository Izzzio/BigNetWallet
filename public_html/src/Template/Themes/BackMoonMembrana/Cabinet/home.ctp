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
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= \App\Lib\Misc::projectName() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="<?= \App\Lib\Misc::tcfg('favicon') ?>">
    <meta name="theme-color" content="#ffffff">
    <base href="<?= URL_PREFIX ?>" />
    <?php
    \App\Lib\Sandbox::runFromStorageOrIgnore('beforeCss', ['user' => $user]);
    ?>

    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/css/account.css?_=<?= CORE_VERSION ?>">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/style/flash.css">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/style/cabinet.css?_=<?= CORE_VERSION ?>">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/libs/popup/magnific-popup.css">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/css/style.css">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_CSS_BASE ?>/customize.css?_=<?= CORE_VERSION ?>">

    <script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/jquery-1.12.4.min.js"></script>
    <script src="<?= URL_PREFIX?>/i18n.js?_=<?= CORE_VERSION ?>"></script>


    <?= $this->element('ga'); ?>
    <?= $this->element('gtag'); ?>


    <?php
    \App\Lib\Sandbox::runFromStorageOrIgnore('beforeClosedHead', ['user' => $user]);
    ?>


</head>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=<?= \App\Lib\Misc::tcfg('gtm') ?>"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<script>
    var second = 1000,
        minute = second * 60,
        hour = minute * 60,
        day = hour * 24;
    var now = <?= time() * 1000 ?>;
    var countDown = <?= $countDown ?>,
    x = setInterval(function () {

        now += second;
        var distance = countDown - now;

        if(distance < 0){
            distance = 0;
        }

        try {
        $('.days-counter').html(("0" + Math.floor(distance / (day))).slice(-2));
        $('.hours-counter').html(("0" + Math.floor((distance % (day)) / (hour))).slice(-2));
        $('.minutes-counter').html(("0" + Math.floor((distance % (hour)) / (minute))).slice(-2));
        $('.seconds-counter').html(("0" + Math.floor((distance % (minute)) / second)).slice(-2));
    } catch (e) {
    }


    }, second);


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
<div class="site" id="site">
    <header class="site-header">
        <div class="container">
            <div class="header-list row">
                <div class="header-logo">
                    <a href="<?= URL_PREFIX ?>">
                        <picture>
                            <source
                                    srcset="<?= \App\Lib\Misc::tcfg('logo') ?>">
                            <img src="<?= \App\Lib\Misc::tcfg('logo') ?>"
                                 alt="logo">
                        </picture>
                    </a>
                </div>

                <div class="account-info">
                    <div class="account-name"><?= h($user->name) ?>
                        <svg class="arrow" width="10px" height="20px" viewBox="0 0 50 80" xml:space="preserve">
    <polyline fill="none" stroke="currentcolor" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" points="
	45.63,75.8 0.375,38.087 45.63,0.375 "/>
  </svg>
                    </div>
                    <div class="account-menu">
                        <ul>
                            <?php if ($user->is_admin) { ?>
                            <li class="account-item"><a class="account-link"
                                                        href="<?= URL_PREFIX ?>/admin"><?= __('Admin') ?></a>
                            </li>
                            <?php } ?>
                            <li class="account-item"><a class="account-link"
                                                        href="<?= URL_PREFIX ?>/cabinet/profile"><?= __('Profile') ?></a>
                            <li class="account-item"><a class="account-link"
                                                        href="<?= URL_PREFIX ?>/app/logout"><?= __('Log out') ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="lang">
                    <div class="lang-current"><?= h(\Cake\I18n\I18n::locale()) ?></div>
                    <ul class="lang-list">
                        <?php foreach ($langs as $lang) {
                            ?>
                        <li class="lang-item"><a class="lang-link"
                                                 href="<?= URL_PREFIX ?>/cabinet/changeLang/<?= h($lang) ?>"><?= h(strtoupper($lang)) ?></a>
                        </li><?php

                        } ?>
                    </ul>
                </div>
                <div class="header-btn mobile-top-btn">
                    <span></span>
                </div>
            </div>
        </div>
    </header>
    <div class="header-mobile-menu">
        <div class="mobile-menu-btn mobile-top-btn active">
            <span></span>
        </div>
        <div class="mobile-menu-inner">
            <ul class="mobile-menu-list row">
                <li class="mobile-menu-item"><a href="#period" class="mobile-menu-link"><?= __('Steps') ?></a></li>
                <li class="mobile-menu-item"><a href="#command" class="mobile-menu-link"><?= __('Our team') ?></a></li>
                <li class="mobile-menu-item"><a href="#projects" class="mobile-menu-link"><?= __('Our projects') ?></a>
                </li>
                <!--<li class="mobile-menu-item"><a href="" class="mobile-menu-link">Регистрация</a></li>-->
            </ul>
            <div class="mobile-menu-email">
                <a class="mobile-email-link"
                   href="mailto:<?= \App\Lib\Misc::supportEmail() ?>"><?= \App\Lib\Misc::supportEmail() ?></a>
            </div>

        </div>
    </div>
    <section class="one">
        <div class="container">
            <?= $this->Flash->render() ?>

            <?php if(true/*$user->tokens - $user->in_chain > 0*/){ ?>
            <div class="lk-block top-block">
                <div class="top-block-list row">
                    <div class="top-block-item top-block-bitcoen tokenInfo">
                        <div class="top-block-title"><?= __('My') . ' ' . \App\Lib\Misc::tokenName() ?></div>
                        <div class="top-block-summ"><?= $this->Number->format($user->tokens - $user->in_chain) ?>
                            <span><?= \App\Lib\Misc::tokenName() ?></span>
                        </div>
                        <?php if (!empty($user->wallet) && TOKENSALE_ACTIVE && false) { ?>
                            <div class="top-block-btn"><a class="top-block-link" href=""><?= __('Send to Wallet') ?></a>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if (\App\Lib\Misc::depositEnabled()) { ?>
                        <div class="top-block-item top-block-deposit">
                            <div class="top-block-title"><?= __('Deposit') ?></div>
                            <div class="top-block-summ"><span class="cur">USD</span> <?= $user->balance ?> <span
                                        class="quest"
                                        data-text="<?= __('The balance is indicated in conventional units equal to the US dollar') ?>"></span>
                            </div>
                            <!-- <div class="top-block-btn"><a class="top-block-link popup" href="#deposit"><?= __('Withdraw') ?></a></div> -->
                        </div>
                    <?php } ?>
                    <?php if (\App\Lib\Misc::tcfg('enableWalletEnter')) { ?>
                        <div class="top-block-item top-block-wallet wallet-block">
                            <div class="top-block-title"><?= __('Wallet') ?></div>
                            <?php if (empty($user->wallet)) {
                                ?>
                                <div class="top-block-summ"><?= __(' ') ?></div>
                                <div class="top-block-btn"><a class="top-block-link popup enterWalletAddress"
                                                              href="#wallet"><?= __('Enter wallet address') ?></a></div>

                                <?php
                            } else {
                                ?>
                                <div class="top-block-summ"><?= $user->wallet ?></div>
                                <div class="top-block-btn"><a class="top-block-link popup changeWalletAddress"
                                                              href="#wallet"><?= __('Change wallet address') ?></a>
                                </div>
                                <?php
                            } ?>

                        </div>
                    <?php } ?>

                    <?php if (\Cake\Core\Configure::read('KYC.enabled')) { ?>
                        <div class="top-block-item kyc-block" style="width: 324px;">
                            <div class="top-block-title"><?= __('KYC') ?></div>
                            <?php
                            if ($user->kyc_reached) {
                                ?>
                                <div class="top-block-btn">
                                    <?= __('KYC successfully passed') ?>
                                </div>
                                <?php
                            } else {
                                if ($KYCLastAttempt) {
                                    if ($KYCLastAttempt->finish) {
                                        ?>
                                        <div>
                                            <p class="text-danger"><?= __('Previous attempt KYC failed: ');
                                                echo $KYCLastAttempt->comment; ?></p>
                                        </div>
                                        <a href="<?= URL_PREFIX ?>/kyc/pass" class="btn btn-dark-green"
                                           style="width: 100%;"><?= __('Start') ?></a>
                                        <?php
                                    } else {
                                        ?>
                                        <p><?= __('Pending KYC status.') ?></p>
                                        <a href="<?= URL_PREFIX ?>/kyc/pass" class="btn btn-dark-green"
                                           style="width: 100%;"><?= __('Continue') ?></a>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <a href="<?= URL_PREFIX ?>/kyc/pass" class="btn btn-dark-green"
                                       style="width: 100%;"><?= __('Start') ?></a>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <?php } ?>

            <?php if (\App\Lib\Misc::tcfg('enableReferal')) { ?>
                <div class="lk-block bottom-block referalBlock">
                    <div class="referal-title"><?= __('Referral link') ?></div>
                    <form class="referal-link" onsubmit="return false;">
                        <input type="text" style="width: 76%;" name="link" class="input-field" value="<?= $refLink ?>"
                               readonly>
                        <button class="btn-sbm copyRef" name="subscribe"
                                data-clipboard-text="<?= $refLink ?>"><?= __('Copy') ?></button>
                    </form>
                    <div class="referal-text">
                        <?= __('Your reward amounts to {0}% of all tokens purchased by your referrals.', \App\Lib\Referal::getReferalBonus()); ?>
                    </div>

                    <?php if (count($refs) > 0) { ?>
                    <br>
                    <br>
                    <div class="referal-title"><?= __('Your referrals') ?></div>

                        <div style="overflow-x: scroll">
                            <table cellpadding="0" cellspacing="0" class="table table-striped text-left"
                                   style="width: 100%; text-align: center">
                                <thead>
                                <tr>
                                    <th style="text-align: center" scope="col"><?= __('User') ?></th>
                                    <th style="text-align: center" scope="col"><?= __('Registration date') ?></th>
                                    <th style="text-align: center" scope="col"><?= __('Tokens') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($refs as $ref): ?>
                                    <tr>
                                        <td>
                                            <?= \App\Lib\Misc::maskEmail($ref['name']) ?>
                                        </td>
                                        <td><?= $ref['created'] ?></td>
                                        <td>
                                            <?= $ref['amount'] ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                    <?php } ?>

                </div>
            <?php } ?>


            <div class="lk-main-list row">
                <div class="lk-block main-block left-block">
                    <div class="main-block-inner">
                        <h2 class="main-block-title"><?= __('Invest in Membrana Blockchain Platform') ?> </h2>

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

                        <div class="main-block-step">
                            <?= __('STEP 1. Calculate token amount') ?>
                        </div>
                        <div class="main-block-step">
                            <div style="    font-size: 16px; font-weight: 400; line-height: 1.63;">
                           <?= __('1. Choose token amount for investment') ?><br>
                           <?= __('2. Choose payment system: Ethereum, Bitcoin, Litecoin, Visa') ?><br>
                           <?= __('3. If you would like to pay in FIAT - please follow the instructions in FAQ') ?><br>
                           <?= __('4. Price per token: $0,02 USD') ?><br>
                           <?= __('5. Min investment: 0.8 ETH / 0.02 BTC / 2.6 LTC') ?><br>
                            </div>
                        </div>
                        <div class="main-block-step">

                        </div>
                        <div class="main-block-choose row">
                            <div class="choose-block-item">
                                <div class="choose-block-item-inner">
                                    <input class="choose-input" type="text" id="tokenInput" autofocus placeholder=""
                                           value="<?= \App\Lib\Misc::tcfg('startValue') ?>">
                                </div>
                            </div>
                            <div class="choose-block-item currency-input">
                                <div class="choose-block-item-inner">
                                    <span><?= __('Payment currency') ?>:</span>
                                    <input class="choose-input" type="text" id="currencyInput" placeholder="">
                                </div>
                            </div>
                            <div class="choose-block-item">
                                <div class="choose-block-item-inner"><?= \App\Lib\Misc::tokenName() ?></div>
                            </div>
                            <div class="choose-block-item">
                                <div class="choose-block-item-inner choose-block-currency">
                                    <div class="choose-currency"><span id="currency">Ethereum</span>
                                        <svg class="arrow" width="10px" height="20px" viewBox="0 0 50 80"
                                             xml:space="preserve">
    <polyline fill="none" stroke="currentcolor" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" points="
	45.63,75.8 0.375,38.087 45.63,0.375 "/>
  </svg>
                                    </div>
                                    <ul class="currency-list">
                                        <?php if (in_array('ETH', $enabledCurrency)) { ?>
                                        <li class="currency-item">
                                            <svg class="svg-ether-dims">
                                                <use xlink:href='#ether'/>
                                            </svg>
                                            <span>Ethereum</span>
                                        </li>
                                        <?php } ?>
                                        <?php if (in_array('BTC', $enabledCurrency)) { ?>
                                        <li class="currency-item">
                                            <svg class="svg-bitcoin-dims">
                                                <use xlink:href='#bitcoin'/>
                                            </svg>
                                            <span>Bitcoin</span>
                                        </li>
                                        <?php } ?>
                                        <?php if (in_array('LTC', $enabledCurrency)) { ?>
                                        <li class="currency-item">
                                            <svg class="svg-litecoin-dims">
                                                <use xlink:href='#litecoin'/>
                                            </svg>
                                            <span>Litecoin</span>
                                        </li>
                                        <?php } ?>
                                        <?php if (in_array('BCH', $enabledCurrency)) { ?>
                                        <li class="currency-item">
                                            <svg class="svg-bitcoin_cash-dims">
                                                <use xlink:href='#bitcoin_cash'/>
                                            </svg>
                                            <span>Bitcoin Cash</span>
                                        </li>
                                        <?php } ?>
                                        <?php if (in_array('DASH', $enabledCurrency)) { ?>
                                        <li class="currency-item">
                                            <svg class="svg-dash-dims">
                                                <use xlink:href='#dash'/>
                                            </svg>
                                            <span>Dash</span>
                                        </li>
                                        <?php } ?>
                                        <?php if (in_array('ETC', $enabledCurrency)) { ?>
                                        <li class="currency-item">
                                            <svg class="svg-ether_classic-dims">
                                                <use xlink:href='#ether_classic'/>
                                            </svg>
                                            <span>Ether Classic</span>
                                        </li>
                                        <?php } ?>
                                        <?php if (in_array('USD', $enabledCurrency)) { ?>
                                        <li class="currency-item">
                                            <svg class="svg-USD-dims">
                                                <use xlink:href='#USD'/>
                                            </svg>
                                            <span>USD</span>
                                        </li>
                                        <?php } ?>
                                        <?php if (in_array('RUR', $enabledCurrency)) { ?>
                                        <li class="currency-item">
                                            <svg class="svg-RUR-dims">
                                                <use xlink:href='#RUR'/>
                                            </svg>
                                            <span>RUR</span>
                                        </li>
                                        <?php } ?>
                                        <?php if (in_array('EUR', $enabledCurrency)) { ?>
                                        <li class="currency-item">
                                            <svg class="svg-EUR-dims">
                                                <use xlink:href='#EUR'/>
                                            </svg>
                                            <span>EUR</span>
                                        </li>
                                        <?php } ?>
                                        <?php

                                        foreach ($enabledCurrency as $item) {
                                            if (in_array($item, [
                                                'BTC',
                                                'ETH',
                                                'ETC',
                                                'BCH',
                                                'LTC',
                                                'DASH',
                                                'BTC',
                                                'USD',
                                                'RUR',
                                                'EUR',
                                            ])) {
                                                continue;
                                            }
                                            ?>
                                        <li class="currency-item">
                                            <svg class="svg-none-dims">
                                                <use xlink:href='#<?= $item ?>'/>
                                            </svg>
                                            <span><?= $item ?></span>
                                        </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="bonus-block row">
                            <div class="bitcoin-sum">
                                <div class="bitcoin-sum-inner">
                                    <span><?= __('Total') ?></span>
                                    <div class="bitcoin-sum-total">14 000</div>
                                </div>
                            </div>
                            <div class="bonus-sum-wrapper">
                                <div class="bonus-sum-block">
                                    <div class="bonus-rate"><?= __('Bonus') ?> <span>40%</span></div>
                                    <div class="bonus-sum">4 000</div>
                                </div>
                            </div>

                        </div>
                        <?php if (\App\Lib\Misc::depositEnabled() || TOKENSALE_ACTIVE) { ?>
                        <div class="main-block-step">
                            <?= __('STEP 2. Buy Membrana (MBN) tokens') ?>
                        </div>
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
                        <a style="cursor: pointer"
                           class="get-link btn-dark-green btn getAdress"><?= __('Get payment address') ?></a>
                        <div class="addressHolder" style="text-align: center"></div>
                        <div class="link-text">
                            <p><?= __('Go to your wallet account and send money to the showed address. Please make sure that your deposit exceeds the minimum purchase amount.') ?></p>
                            <p><?= __('Deposit will appear on your account only after a few block confirmations. It can take from 10 minutes to 2 hours or more, depending on your payment method.') ?> </p>
                        </div>
                        <?php } else {
                            if (!empty($countDownTo)) {
                                ?>
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



                        <?php if (\App\Lib\Misc::tcfg('enableFAQ')) {
                            echo $this->element('faq');
                        } ?>

                    </div>
                </div>
                <div class="lk-block main-block right-block">
                    <div class="main-block-inner">
                        <?php if (!TOKENSALE_ACTIVE && !empty($countDownTo)) { ?>
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
                        <?php } else {
                            if (!empty($countDownTo)) {
                                ?>
                        <h2 class="main-block-title endofthestage"><?= __('The end of the stage in') ?><?php /*= \App\Lib\Calculator::PERIODS[\App\Lib\Calculator::getPeriod()]['end']*/ ?></h2>
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
                        <!-- <p class="currenttime"><?= __('Current time') ?>: <?= date('Y-m-d H:i:s') ?></p> -->
                        <?php
                            }
                        } ?>
                        <div class="token-block">
                            <?php
                            {
                                $result = \App\Lib\Sandbox::runFromStorageOrIgnore('periods', ['allow_escaping' => true]);
                            if (!$result) {
                            echo $this->element(\App\Lib\Misc::tcfg('periodsTemplate'));
                            }
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if(isset($currencies) && count($currencies)): ?>
            <div class="row" style="margin-left: 0px;" id="currencies-block">
                <div class="lk-block left-block">
                    <div class="top-block-title" style="margin-bottom: 4px;"><?= __('Currencies rate') ?></div>
                    <div style="color: grey; margin-bottom: 16px;"><?= __('from CoinMarketCap') ?></div>
                    <div class="profile-transactions" style="overflow-x: scroll">
                        <table style="width: 100%">
                            <thead>
                            <tr>
                                <th style="text-align: center"><?= __('Name') ?></th>
                                <th style="text-align: center"><?= __('Symbol') ?></th>
                                <th style="text-align: center"><?= __('Price, usd') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($currencies as $data): ?>
                            <tr>
                                <td><?=$data['name']?></td>
                                <td><?=$data['symbol']?></td>
                                <td>$ <?=$data['price_usd']?></td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>




        </div>
    </section>
    <?= $this->element('cabFooter') ?>


    <div class="hidden">
        <div id="wallet" class="wallet">
            <div class="wallet-block">
                <form method="POST" action="<?= URL_PREFIX ?>/cabinet/editWallet" onsubmit="try{ return checkWalletAddressHook();}catch(e){return true;}">
                    <div class="wallet-title"><?= __('Wallet') ?></div>
                    <input name="wallet" class="wallet-input" type="text" placeholder="">
                    <div class="wallet-text"><?= __('The subsequent change of wallet address is possible only through the administrator.') ?>
                    </div>
                    <button type="submit" class="wallet-btn btn btn-dark-green"><?= __('Accept') ?></button>
                </form>
            </div>
        </div>

    </div>
</div>
<svg style="display: none;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <symbol id="bell" viewBox="0 0 21 23" xmlns="http://www.w3.org/2000/svg">
        <style>.ast0 {
            fill: #efd4e8
        }</style>
        <path id="aФигура_938" class="ast0"
              d="M10.5 23c-1.4 0-2.6-1-2.8-2.3h5.7c-.3 1.3-1.5 2.3-2.9 2.3zM21 18.4v.1c-.1.6-.7 1.1-1.3 1.1H1.4c-.6 0-1.2-.5-1.3-1.1v-.1c-.1-.7.2-1.3.8-1.7.8-.5 1.4-1.3 1.7-2.1 1.2-3.7.2-9.4 4.7-11.2.5-.2 1-.3 1.6-.4 0-.1.1-.2.1-.3 0-.1 0-.1-.1-.1-.4-.8-.2-1.9.6-2.4s1.8-.2 2.3.6c.3.5.3 1.2 0 1.7-.1.1-.1.2 0 .3l.1.1c.6.1 1.2.3 1.8.5 4.2 1.9 3.5 7.5 4.7 11.1.3.9.9 1.6 1.7 2.1.6.5.9 1.2.9 1.8z"/>
    </symbol>
    <symbol id="bitcoen" viewBox="0 0 13.9 18" xmlns="http://www.w3.org/2000/svg">
        <style>.bst0 {
            fill: #a298ca
        }</style>
        <path id="bФигура_5" class="bst0"
              d="M12.9 5.4c-.2-2-2-2.6-4.3-2.7V0H6.8v2.6H5.4V-.1H3.6v2.7H.1v1.8h1.3c.5-.1.9.2 1 .7v3.1h.2-.2v4.3c0 .3-.3.6-.7.6H.4l-.4 2h3.6v2.7h1.8v-2.7h1.4v2.7h1.8v-2.7c3-.2 5.1-1 5.3-3.6.3-1.5-.6-3-2.1-3.3-.1 0-.3-.1-.4-.1 1-.4 1.7-1.5 1.5-2.7zm-2.5 5.9c0 2-3.8 1.9-5 1.9V9.6c1.2 0 5-.4 5 1.7zm-.8-5.1c0 1.9-3.2 1.7-4.2 1.7V4.6c1 0 4.2-.3 4.2 1.6z"/>
    </symbol>
    <symbol id="facebook" viewBox="0 0 7.7 16" xmlns="http://www.w3.org/2000/svg">
        <style>.cst0 {
            fill: #6dd8ba
        }</style>
        <path id="cФигура_1" class="cst0"
              d="M.2 5.2h1.9V2.8c0-.7.2-1.3.5-1.9C3 .3 3.7 0 4.4 0h3.1c.1 0 .2.1.2.2v2.5c0 .1-.1.2-.2.2H6.3c-.3-.1-.5-.1-.7.1-.2.2-.3.4-.3.6v1.6h2.2c.1 0 .2.1.2.2V8c0 .1-.1.2-.2.2H5.3v7.7c0 .1-.1.2-.2.2H2.3c-.1 0-.2-.1-.2-.2V8.2H.2C.1 8.2 0 8.1 0 8V5.4c0-.1.1-.2.2-.2z"/>
    </symbol>
    <symbol viewBox="0 0 7.5 15.6" id="fb" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <style>.dcls-1 {
                fill: currentcolor;
                fill-rule: evenodd
            }</style>
        </defs>
        <path id="dФигура_1" data-name="Фигура 1" class="dcls-1"
              d="M1141.23 14536.8h1.87v-2.3a.34.34 0 0 1 .01-.1 3.123 3.123 0 0 1 .52-1.8 2.053 2.053 0 0 1 1.74-.9h3.01a.2.2 0 0 1 .17.2v2.4a.2.2 0 0 1-.17.2h-1.19a1.3 1.3 0 0 0-.68.1l-.11-.1.11.1a.158.158 0 0 1-.01.1.732.732 0 0 0-.23.6v1.5h2.11a.2.2 0 0 1 .17.2v2.6a.27.27 0 0 1-.17.1h-2.11v7.5a.2.2 0 0 1-.17.2h-2.83a.2.2 0 0 1-.17-.2v-7.5h-1.87a.24.24 0 0 1-.17-.1v-2.6a.189.189 0 0 1 .17-.2z"
              transform="translate(-1141.06 -14531.8)"/>
    </symbol>
    <symbol id="fb1" viewBox="0 0 7.7 16" xmlns="http://www.w3.org/2000/svg">
        <style>.est0 {
            fill: #b1a8d7
        }</style>
        <path class="est0"
              d="M.2 5.2h1.9V2.8c0-.7.2-1.4.5-1.9.4-.6 1-.9 1.8-.9h3.1c.1 0 .2.1.2.2v2.5c0 .1-.1.2-.2.2H6.3c-.3-.1-.6-.1-.7.1-.2.1-.2.3-.3.6v1.6h2.2c.1 0 .2.1.2.2V8c0 .1-.1.2-.2.2H5.3v7.7c0 .1-.1.2-.2.2H2.3c-.1 0-.2-.1-.2-.2V8.2H.2C.1 8.2 0 8.1 0 8V5.4c0-.1.1-.2.2-.2z"
              id="eLayer_x0020_1"/>
    </symbol>
    <symbol id="fond" viewBox="0 0 58 58" xmlns="http://www.w3.org/2000/svg">
        <style>.fst0 {
            fill: #e5208a
        }

        .fst0, .fst1, .fst2, .fst3 {
            opacity: .75;
            enable-background: new
        }

        .fst1 {
            fill: #6dd8ba
        }

        .fst2 {
            fill: #9b5fbe
        }

        .fst3 {
            fill: #01aef0
        }</style>
        <path class="fst0"
              d="M46.7 21.5c-1-2.3-2.3-4.3-4.1-6.1-1.8-1.8-3.8-3.1-6.1-4.1-2.4-1-4.9-1.5-7.5-1.5-1.3 0-2.3 1-2.3 2.3 0 1.3 1 2.3 2.3 2.3 2 0 3.9.4 5.6 1.1 1.7.7 3.3 1.8 4.6 3.1 1.3 1.3 2.4 2.9 3.1 4.6.8 1.8 1.1 3.7 1.1 5.6 0 2-.4 3.9-1.1 5.7-.7 1.7-1.8 3.3-3.1 4.6-.4.4-.7 1-.7 1.6 0 .6.2 1.2.7 1.6.4.4 1 .7 1.6.7s1.2-.2 1.6-.7c1.8-1.8 3.1-3.8 4.1-6.1 1-2.4 1.5-4.9 1.5-7.5.2-2.3-.3-4.8-1.3-7.2z"/>
        <path class="fst1"
              d="M29 43.5c-2 0-3.9-.4-5.6-1.1-1.7-.7-3.3-1.8-4.6-3.1-1.3-1.3-2.4-2.9-3.1-4.6-.8-1.8-1.1-3.7-1.1-5.7s.4-3.9 1.1-5.6c.7-1.7 1.8-3.3 3.1-4.6.4-.4.7-1 .7-1.6 0-.6-.2-1.2-.7-1.6-.9-.9-2.4-.9-3.3 0-1.8 1.8-3.1 3.8-4.1 6.1-1 2.4-1.5 4.9-1.5 7.5 0 2.6.5 5.1 1.5 7.5 1 2.3 2.3 4.3 4.1 6.1 1.8 1.8 3.8 3.1 6.1 4.1 2.4 1 4.9 1.5 7.5 1.5 1.3 0 2.3-1 2.3-2.3-.1-1.5-1.1-2.6-2.4-2.6z"/>
        <path class="fst2"
              d="M29 0C13 0 0 13 0 29s13 29 29 29 29-13 29-29S45 0 29 0zm0 52.5C16 52.5 5.5 42 5.5 29S16 5.5 29 5.5 52.5 16 52.5 29 42 52.5 29 52.5z"/>
        <path class="fst3"
              d="M35.5 31c-.2-.5-.4-.9-.8-1.2-.3-.3-.7-.6-1.1-.8-.4-.2-.9-.4-1.4-.5.8-.3 1.5-.7 2.1-1.4.5-.6.8-1.4.8-2.4 0-.9-.2-1.6-.5-2.2-.4-.6-.8-1-1.4-1.4-.6-.3-1.2-.6-1.9-.7-.3-.1-.7-.1-1-.2l-1.8-1.8-1.8 1.8H23c-.3 0-.6.3-.6.6V37c0 .3.3.6.6.6h3.6l1.9 1.9 1.9-1.9c.4 0 .9-.1 1.3-.2.8-.2 1.5-.5 2.1-.8.6-.4 1.1-.9 1.5-1.6.4-.6.6-1.4.6-2.4-.1-.6-.2-1.1-.4-1.6zm-9.2-6.8c0-.3.3-.6.6-.6h1.4c.9 0 1.5.1 2 .4.4.3.7.7.7 1.3 0 .6-.2 1.1-.6 1.4-.4.3-1 .5-1.8.5H27c-.3 0-.6-.3-.6-.6v-2.4zm5 9c-.2.3-.4.5-.7.6-.3.1-.6.2-1 .3-.4.1-.7.1-1 .1h-1.7c-.3 0-.6-.3-.6-.6v-2.7c0-.3.3-.6.6-.6h1.7c.9 0 1.6.1 2.2.4.5.3.8.8.8 1.5 0 .4-.1.8-.3 1z"/>
    </symbol>
    <symbol id="go" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
        <style>.gst0 {
            fill: currentcolor
        }</style>
        <path class="gst0"
              d="M11.5 5.1L6.7.4c-.5-.5-1.3-.5-1.8 0s-.5 1.3 0 1.8l2.5 2.5h-6c-.3 0-.7.1-.9.4-.2.2-.3.6-.3.9 0 .3.1.7.4.9.2.2.6.4.9.4h6L4.9 9.8c-.2.2-.4.6-.4.9 0 .3.1.7.4.9.2.3.6.4.9.4.3 0 .7-.1.9-.4l4.7-4.7c.2-.2.4-.6.4-.9 0-.3-.1-.7-.3-.9z"/>
    </symbol>
    <symbol id="identify" viewBox="0 0 101 39" xmlns="http://www.w3.org/2000/svg">
        <style>.hst0 {
            fill: #f78a38
        }

        .hst0, .hst1, .hst2, .hst3, .hst4 {
            opacity: .75;
            enable-background: new
        }

        .hst1 {
            fill: #9b5fbe
        }

        .hst2 {
            fill: #6dd8ba
        }

        .hst3 {
            fill: #01aef0
        }

        .hst4 {
            fill: #e5208a
        }</style>
        <path class="hst0"
              d="M98.9 16.2v-.4h-4.7C92.3 5.9 83-.9 72.9.3c-7.6 1-13.9 6.3-16.1 13.6-2.1-.5-4.2-.7-6.3-.7-2.2 0-4.3.3-6.4.8-1.3-4.4-4.1-8.1-8-10.7C31.8.5 26.6-.5 21.6.6 13.9 2.2 8 8.2 6.6 15.8H3.7c-2 0-3.6 1.6-3.6 3.6S1.7 23 3.7 23h2.9c.9 4.6 3.4 8.7 7.1 11.6 4.1 3.2 9.1 4.6 14.3 4 9.1-1.1 16-8.3 16.9-17.4 1.3-.5 4.2-1.1 7.7-.8h.1c1.2 0 2.3.3 3.4.7.9 9.9 9.3 17.6 19.2 17.6h.9c9.1-.4 16.5-6.9 18.1-15.7h3.2c2 0 3.6-1.6 3.6-3.6 0-1.4-.9-2.6-2.2-3.2zM66.7 28c-2.3-2.3-3.6-5.3-3.6-8.5s1.2-6.3 3.5-8.6 5.3-3.6 8.5-3.6 6.2 1.3 8.5 3.5c2.3 2.3 3.6 5.3 3.6 8.5 0 6.6-5.4 12.1-12.1 12.1-3.1.1-6.1-1.1-8.4-3.4zm-29.1-8.6c0 6.7-5.4 12.1-12.1 12.1-3.2 0-6.3-1.3-8.5-3.5-2.3-2.3-3.5-5.3-3.6-8.6 0-3.2 1.3-6.3 3.5-8.6s5.3-3.5 8.6-3.6c3.2 0 6.3 1.3 8.5 3.5 2.4 2.5 3.6 5.5 3.6 8.7z"/>
        <path class="hst1"
              d="M84 9.1c1.1 1 1.3 2.7.3 3.8L70.2 29.3c-1 1.1-2.7 1.3-3.8.3s-1.3-2.7-.3-3.8l14-16.4c1-1.2 2.7-1.3 3.9-.3-.1 0-.1 0 0 0z"/>
        <path class="hst2"
              d="M64.9 21.4c-1.5 0-2.7-1.2-2.8-2.7 0-.7.2-1.3.7-1.9L70.4 8c1-1.1 2.7-1.3 3.8-.3 1.1 1 1.3 2.7.3 3.8L67 20.4c-.5.6-1.3 1-2.1 1z"/>
        <path class="hst3"
              d="M34.2 9.1c1.1 1 1.3 2.7.3 3.8l-14 16.4c-1 1.1-2.7 1.3-3.8.3s-1.3-2.7-.3-3.8l14-16.4c.9-1.2 2.6-1.3 3.8-.3z"/>
        <path class="hst4"
              d="M15.2 21.4c-1.5 0-2.7-1.2-2.8-2.7 0-.7.2-1.3.7-1.9L20.6 8c1-1.1 2.7-1.3 3.8-.3 1.1 1 1.3 2.7.3 3.8l-7.6 8.9c-.4.6-1.1 1-1.9 1z"/>
    </symbol>
    <symbol id="instagram" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
        <style>.ist0 {
            fill: #6dd8ba
        }</style>
        <path class="ist0"
              d="M8 3.8C5.7 3.8 3.9 5.7 3.9 8s1.8 4.1 4.1 4.1 4.1-1.9 4.1-4.1S10.3 3.8 8 3.8zm0 6.8c-1.5 0-2.6-1.2-2.6-2.6S6.5 5.3 8 5.3s2.6 1.2 2.6 2.6-1.1 2.7-2.6 2.7z"/>
        <circle class="ist0" cx="12.3" cy="3.7" r=".9"/>
        <path class="ist0"
              d="M14.7 1.3c-.8-.9-2-1.3-3.4-1.3H4.7C1.9 0 0 1.9 0 4.7v6.6c0 1.4.5 2.6 1.4 3.5.9.8 2 1.3 3.4 1.3h6.6c1.4 0 2.5-.5 3.4-1.3.9-.8 1.3-2 1.3-3.4V4.7c-.1-1.4-.6-2.5-1.4-3.4zm-.1 10c0 1-.4 1.8-.9 2.4-.6.5-1.4.8-2.4.8H4.7c-1 0-1.8-.3-2.4-.8-.6-.6-.9-1.4-.9-2.4V4.7c0-1 .3-1.8.9-2.4.5-.5 1.4-.8 2.4-.8h6.6c1 0 1.8.3 2.4.9.5.6.9 1.4.9 2.3v6.6z"/>
    </symbol>
    <symbol id="linkedin" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
        <style>.jst0 {
            fill: currentcolor
        }</style>
        <path class="jst0"
              d="M0 4.5h3.5V16H0zm12 0c-2 0-2.6.7-3 1.5V4.5H5.5V16H9V9.5c0-1 0-2 1.8-2s1.8 1 1.8 2V16H16V9.5c0-3-.5-5-4-5z"/>
        <circle class="jst0" cx="1.8" cy="1.8" r="1.8"/>
    </symbol>
    <symbol id="loyalnost" viewBox="0 0 51 46" xmlns="http://www.w3.org/2000/svg">
        <style>.kst0 {
            fill: #01aef0
        }

        .kst0, .kst1, .kst2 {
            opacity: .7;
            enable-background: new
        }

        .kst1 {
            fill: #f78a38
        }

        .kst2 {
            fill: #fdc625
        }</style>
        <path id="kПрямоугольник_скругл._углы_6_копия_1_" class="kst0"
              d="M4.3 18.7h42.3c2.4 0 4.3 1.9 4.3 4.3s-1.9 4.3-4.3 4.3H4.3C1.9 27.3 0 25.4 0 23s1.9-4.3 4.3-4.3z"/>
        <path id="kПрямоугольник_скругл._углы_6_копия_3_1_" class="kst1"
              d="M11.2 39.1L32.3 2.5c1.2-2.1 3.9-2.8 6-1.6 2.1 1.2 2.8 3.8 1.6 5.9L18.7 43.4c-1.2 2.1-3.9 2.8-6 1.6-2-1.2-2.7-3.8-1.5-5.9z"/>
        <path id="kПрямоугольник_скругл._углы_6_копия_2_1_" class="kst2"
              d="M18.7 2.5L39.8 39c1.2 2.1.5 4.8-1.6 6-2.1 1.2-4.8.5-6-1.6L11.1 6.9c-1.2-2.1-.5-4.8 1.6-5.9 2.2-1.2 4.8-.5 6 1.5z"/>
    </symbol>
    <symbol id="market" viewBox="0 0 55 50" xmlns="http://www.w3.org/2000/svg">
        <style>.lst0 {
            fill: #6dd8ba
        }

        .lst0, .lst1, .lst2 {
            opacity: .75;
            enable-background: new
        }

        .lst1 {
            fill: #e5208a
        }

        .lst2 {
            fill: #fdc625
        }</style>
        <path class="lst0"
              d="M51.9 33.1H5.8V6.3h27.9c1.6 0 2.9-1.3 2.9-2.9v-.1c0-1.6-1.3-2.9-2.9-2.9h-29C2.1.3 0 2.4 0 5v29.4c0 2.6 2.1 4.7 4.7 4.7h16.5v4.6h-2.8c-.9 0-1.5.7-1.5 1.5v2.9c0 .9.7 1.5 1.5 1.5h16c.9 0 1.5-.7 1.5-1.5v-2.9c0-.9-.7-1.5-1.5-1.5h-2.8v-4.6h16.5c2.6 0 4.7-1.3 4.7-3.9v-1.1c.1-.6-.4-1-.9-1z"/>
        <path class="lst1"
              d="M27.5 13.5c.7 1.2 2 2 3.3 2.1 1.3.1 2.6-.4 3.5-1.3.8.9 2 1.3 3.2 1.3 1.2 0 2.3-.5 3.2-1.3.8.8 2 1.3 3.2 1.3 1.2 0 2.4-.5 3.2-1.3.8.9 2 1.3 3.2 1.3h.3c1.4-.1 2.6-.9 3.3-2.1.7-1.2.8-2.8.2-4.1L50.9 2C50.4 1 49.5.4 48.4.4H33.2c-1.1 0-2.1.6-2.5 1.6l-3.3 7.4c-.7 1.3-.6 2.9.1 4.1z"/>
        <path class="lst2"
              d="M52.6 23.6h-.2v-6.5c-.5.2-1.1.3-1.6.3h-.4c-1 0-1.9-.2-2.8-.7v6.8H34v-6.8c-.9.4-1.8.7-2.8.7h-.4c-.6 0-1.1-.2-1.6-.3v6.5H29c-1.3.1-2.3 1.1-2.3 2.3-.1 1.3 1 2.5 2.3 2.5h23.8c1.3 0 2.4-1.1 2.4-2.4-.2-1.3-1.2-2.4-2.6-2.4z"/>
    </symbol>
    <symbol id="medium" viewBox="0 0 16 14" xmlns="http://www.w3.org/2000/svg">
        <style>.mst0 {
            fill: currentcolor
        }</style>
        <g id="mXMLID_526_">
            <path id="mXMLID_530_" class="mst0"
                  d="M5.3 8.2v5.6c-.1.2-.2.2-.4.2-.3-.1-.5-.3-.8-.4l-1.8-.9c-.7-.3-1.3-.7-2-1-.2-.2-.3-.4-.3-.7V.3C0 .2.1.1.2.2l.6.3 2.4 1.2c.7.3 1.3.7 2 1 .1.1.1.1.1.2v5.3z"/>
            <path id="mXMLID_529_" class="mst0"
                  d="M15.9 2.8c0 .1 0 .1-.1.1-.9 1.5-1.8 3-2.8 4.5-.7 1.1-1.4 2.3-2.1 3.5-.1.1-.1.1-.2 0-.7-1.1-1.3-2.1-2-3.2-.3-.8-.8-1.6-1.3-2.3-.1-.1-.1-.1 0-.2.4-.7.9-1.4 1.3-2.1.6-.9 1.1-1.8 1.7-2.8.2-.3.3-.3.6-.2.7.3 1.4.7 2 1 .9.5 1.9.9 2.8 1.4 0 .1.1.2.1.3z"/>
            <path id="mXMLID_528_" class="mst0"
                  d="M16 8.6v5.1c0 .2-.2.3-.4.3l-.6-.3c-.7-.3-1.4-.7-2.1-1l-1.8-.9c-.1-.1-.1-.2-.1-.2.5-.9 1.1-1.8 1.7-2.7.3-.5.7-1.1 1-1.6l1.8-3c.1-.2.2-.3.3-.5 0 0 0-.1.1-.1s0 .1.1.1v4.8z"/>
            <path id="mXMLID_527_" class="mst0"
                  d="M5.8 6.2V3.5c.1 0 .1.1.1.1L7.4 6c.7 1.3 1.6 2.7 2.4 4 .3.4.5.9.8 1.3 0 0 .1.1 0 .1 0 .1-.1 0-.1 0-1-.5-2-1-2.9-1.5-.6-.2-1.2-.6-1.8-.8-.1-.1-.2-.1-.2-.2.2-.9.2-1.8.2-2.7z"/>
        </g>
    </symbol>
    <symbol id="nezavisit" viewBox="0 0 57 57" xmlns="http://www.w3.org/2000/svg">
        <style>.nst0 {
            fill: #fdc625
        }

        .nst0, .nst1, .nst2, .nst3, .nst4, .nst5 {
            opacity: .75;
            enable-background: new
        }

        .nst1 {
            fill: #e5208a
        }

        .nst2 {
            fill: #01aef0
        }

        .nst3 {
            fill: #f78a38
        }

        .nst4 {
            fill: #9b5fbe
        }

        .nst5 {
            fill: #6dd8ba
        }</style>
        <path class="nst0"
              d="M2.1 22.8c-.7-.2-1.2-.5-1.4-1.1-.4-.6-.4-1.1-.3-1.7.2-.6.5-1 1.1-1.3.6-.3 1.2-.4 1.9-.2h.1L15 21.3c.7.2 1.2.5 1.5 1.1.4.6.4 1.1.2 1.7-.2.6-.6 1.1-1.1 1.4-.6.3-1.3.4-1.9.2L2.1 22.8z"/>
        <path class="nst1"
              d="M.9.6c.5-.4 1-.6 1.6-.6.6 0 1.2.2 1.6.6l7.6 7.6c.4.4.7 1 .7 1.6 0 .6-.2 1.2-.7 1.6-.4.4-.9.7-1.6.7s-1.1-.2-1.5-.6L.9 3.8c-.4-.4-.6-1-.6-1.6 0-.6.2-1.1.6-1.6z"/>
        <path class="nst2"
              d="M21.4.3c.5.4.9.9 1 1.5l2.8 11.9c.2.7.1 1.3-.2 1.9-.3.6-.8 1-1.4 1.2-.6.2-1.2.1-1.7-.3-.5-.3-.9-.8-1-1.5L18.1 3.2c-.2-.7-.1-1.3.2-1.9.3-.6.7-1 1.3-1.2.7-.2 1.2-.1 1.8.2z"/>
        <path class="nst3"
              d="M32 43.8c-.2-.6-.1-1.3.2-1.9.3-.6.8-1 1.4-1.2.6-.2 1.2-.1 1.7.3.5.3.9.9 1 1.5l2.8 11.4c.2.7.1 1.3-.2 1.8-.3.6-.7 1-1.3 1.1-.6.2-1.1.1-1.7-.2-.6-.3-.9-.8-1.1-1.4L32 43.8z"/>
        <path class="nst4"
              d="M46.8 44.9c.6 0 1.2.2 1.6.6l7.7 7.6c.4.4.7 1 .7 1.6 0 .6-.2 1.2-.7 1.6-.4.4-.9.7-1.6.7-.6 0-1.2-.2-1.6-.7l-7.6-7.6c-.4-.4-.6-.9-.6-1.6 0-.6.2-1.2.6-1.6.3-.4.9-.6 1.5-.6z"/>
        <path class="nst5"
              d="M54.9 34.1c.7.2 1.1.5 1.4 1 .3.6.4 1.1.3 1.7-.2.6-.5 1-1.1 1.3-.6.3-1.2.4-1.8.2l-11.2-2.8c-.7-.2-1.1-.5-1.5-1.1-.3-.6-.4-1.1-.2-1.7.2-.6.5-1.1 1.1-1.4.6-.3 1.2-.4 1.9-.2l11.1 3z"/>
        <path class="nst4"
              d="M52.7 4C50.2 1.4 47 .1 43.4 0c-3.2-.1-6.2.9-8.7 2.9l-.1-.1-11.5 11.6c-2.7 2.6-4 5.9-4 9.6 0 3.7 1.3 6.9 4 9.6 2.6 2.7 5.9 4 9.6 4 3.7 0 7-1.3 9.6-4l10.9-10.9c2.4-2.7 3.5-5.8 3.5-9.4-.1-3.6-1.4-6.8-4-9.3zM39.4 9.7l.1-.1c1.1-.9 2.3-1.3 3.7-1.2 1.4.1 2.6.6 3.6 1.5 1 1 1.5 2.2 1.6 3.6.1 1.4-.3 2.6-1.2 3.6L36.6 27.7c-1.1 1.1-2.3 1.6-3.8 1.6s-2.7-.5-3.8-1.6c-1.1-1-1.6-2.3-1.6-3.8s.5-2.7 1.6-3.8l.3-.3L39.4 9.7z"/>
        <path class="nst1"
              d="M33.9 23.4c-2.5-2.6-5.7-3.9-9.3-4-3.3 0-6.2.9-8.7 2.9l-.1-.1L4.3 33.8c-2.7 2.6-4 5.9-4 9.6 0 3.7 1.3 6.9 4 9.6 2.6 2.7 5.9 4 9.6 4 3.7 0 7-1.3 9.6-4l10.9-10.9c2.4-2.7 3.5-5.8 3.5-9.4-.1-3.6-1.4-6.8-4-9.3zm-13.3 5.7l.1-.1c1.1-.9 2.3-1.3 3.7-1.2 1.4.1 2.6.6 3.6 1.5 1 1 1.5 2.2 1.6 3.6.1 1.4-.3 2.6-1.2 3.6L17.8 47.1c-1.1 1.1-2.3 1.6-3.8 1.6s-2.7-.5-3.8-1.6c-1.1-1-1.6-2.3-1.6-3.8s.5-2.7 1.6-3.8l.3-.3 10.1-10.1z"/>
    </symbol>
    <symbol id="payments" viewBox="0 0 60 57" xmlns="http://www.w3.org/2000/svg">
        <style>.ost0 {
            fill: #e5208a
        }

        .ost0, .ost1, .ost2 {
            opacity: .75;
            enable-background: new
        }

        .ost1 {
            fill: #9b5fbe
        }

        .ost2 {
            fill: #6dd8ba
        }</style>
        <path class="ost0"
              d="M49.1 11.9H14.4c-1.6 0-2.8 1.3-2.8 2.8v30.4c0 1.6 1.3 2.8 2.8 2.8 1.6 0 2.8-1.3 2.8-2.8V17.5h29V28c0 1.6 1.3 2.8 2.8 2.8s2.8-1.3 2.8-2.8V14.7c.1-1.6-1.2-2.8-2.7-2.8z"/>
        <path class="ost1"
              d="M50 .2H10C4.5.2.1 4.6 0 10v28.6c.1 5.4 4.5 9.8 9.9 9.8h12.8c1.6 0 2.8-1.3 2.8-2.8 0-1.6-1.3-2.8-2.8-2.8H10c-2.3.1-4.3-1.8-4.3-4.1V10.1c0-2.3 2-4.2 4.4-4.2H50c2.3 0 4.3 1.8 4.3 4.1v23.1c0 1.6 1.3 2.8 2.8 2.8s2.8-1.3 2.8-2.8V10c0-5.5-4.5-9.9-9.9-9.8z"/>
        <path class="ost2"
              d="M55.2 30.5c-.4 0-.8 0-1.2.1-.8-1.3-2.1-2.2-3.6-2.5-.6-.1-1.1-.1-1.7.1-.7-1.3-1.9-2.2-3.4-2.4-.6-.1-1.3-.1-1.9 0l-.2-8.2c-.1-2.4-1.8-4.4-4.2-4.8-1.3-.2-2.6.2-3.6 1s-1.7 1.9-1.9 3.2v.5L32.8 37l-1-1.7c-1.5-2.6-4.4-4-7.3-3.6-2 .3-3.4 2.1-3.1 4 .1.4.2.8.4 1.2l6.4 12.3c.6 1.2 1.6 2.2 2.8 2.9l3.4 1.4h.1c.4.1.7.4.8.8l.3 1c.4 1 1.5 1.6 2.5 1.2 1-.4 1.5-1.5 1.2-2.5l-.3-1c-.5-1.5-1.7-2.7-3.2-3.2l-3-1.2c-.5-.3-.9-.7-1.2-1.3l-6.2-11.9c1.2 0 2.3.6 3 1.7l1.7 2.9c0 .1.1.1.1.2 1.3 1.7 3.6 2.8 5.5 1.5.5-.3.9-.9.9-1.6l.7-22.7c0-.3.1-.5.3-.7.2-.2.4-.3.7-.3h.1c.5.1.8.5.8 1l.3 11.9c0 1.1.9 1.9 2 1.9h.1c.8 0 1.5-.5 1.8-1.3.2-.5.7-.8 1.2-.7.5.1.9.6.9 1.2v.3c0 1.1.9 2 2 2 .6 0 1.1-.2 1.5-.7.2-.3.6-.4.9-.4.6.1.9.6.9 1.2v.3c0 .5.2 1 .6 1.4.4.4.9.6 1.4.6.6 0 1.1-.2 1.5-.7.2-.2.5-.4.8-.4.6.1 1.1.6 1.1 1.2V45c0 2.9-1.9 5-2.5 5.6-.6.6-1 1.3-1.3 2.1l-.4 1c-.2.5-.2 1 0 1.5s.6.9 1.1 1.1c.2.1.5.1.7.1.8 0 1.5-.5 1.8-1.2 0-.1 0-.1.1-.2l.4-1c.1-.2.2-.5.4-.7 1.4-1.4 3.6-4.3 3.6-8.3v-9.8c-.1-2.3-2.2-4.5-4.9-4.7z"/>
    </symbol>
    <symbol id="platform" viewBox="0 0 65 60" xmlns="http://www.w3.org/2000/svg">
        <style>.pst0 {
            fill: #01aef0
        }

        .pst0, .pst1 {
            opacity: .75;
            enable-background: new
        }

        .pst2 {
            fill: #6dd8ba
        }

        .pst3, .pst4 {
            opacity: .75;
            fill: #fdc625;
            enable-background: new
        }

        .pst4 {
        </symbol>
          <symbol id="telegram" viewBox="0 0 16 14" xmlns="http://www.w3.org/2000/svg">
                                                                                      <style>.tst0 {
                                                                                          fill: currentcolor
                                                                                      }</style>
        <path id="tpath9" class="tst0"
              d="M14.9.4L.7 5.8c-1 .4-1 .9-.2 1.2L4 8.1l1.4 4.1c.2.5.1.6.6.6.4 0 .5-.2.7-.4.1-.1.9-.9 1.8-1.7l3.7 2.7c.7.4 1.2.2 1.3-.6l2.4-11.4c.3-.9-.3-1.3-1-1zM4.7 7.9l8-5c.3-.3.7-.2.4.1L6.3 9.1 6 12 4.7 7.9z"/>
    </symbol>
    <symbol id="top_bottom" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
        <style>.ust0 {
            fill: #fff
        }</style>
        <path class="ust0"
              d="M6.9 11.5l4.7-4.8c.5-.5.5-1.3 0-1.8s-1.3-.5-1.8 0L7.3 7.4v-6c0-.3-.1-.7-.4-.9C6.7.3 6.3.2 6 .2c-.3 0-.7.1-.9.4-.3.2-.4.5-.4.9v6L2.2 4.9c-.2-.3-.6-.4-.9-.4-.3 0-.7.1-.9.4-.3.2-.4.6-.4.9 0 .3.1.7.4.9l4.7 4.7c.2.2.6.4.9.4.3 0 .7-.1.9-.3z"/>
    </symbol>
    <symbol id="vk" viewBox="0 0 23.4 13.5" xmlns="http://www.w3.org/2000/svg">
        <style>.vst0 {
            fill: currentcolor
        }</style>
        <path id="vrect2989-7" class="vst0"
              d="M12.6.4H9.5c-.9 0-1.4.4-1.4.6 0 .2.5.4.7.5.3.2.5.7.5 1.1v3.2c0 .3-.1.5-.3.7-.1.1-.2.1-.4.1-.1 0-.3 0-.4-.2C7 4.9 7 4.7 5.3 1.5c-.1-.1-.1-.3-.3-.4-.2-.1-.4-.2-.8-.2H1.1c-.8 0-.8.5-.6.8 1 2.1 2 4.1 3.2 6.2 1.4 2.4 2.6 3.8 4.8 4.9.5.2 1.4.5 2.4.5H13c.3 0 .7-.2.7-.5V11c0-.5.5-.6.7-.8.3-.1.6.1.8.2 1.2 1.3 1.1 1.2 2.2 2.3.3.3.4.4.9.4h4c.2 0 .5-.3.6-.4.1-.2.3-.7 0-1.1-1.1-1.3-2.3-2.4-3.4-3.6-.1-.1-.1-.2-.1-.3 0-.1.1-.3.1-.4 1.2-1.7 2.3-3.2 3.4-5 .4-.6.3-1 .2-1.1-.1-.2-.3-.4-.6-.4h-3.7c-.5 0-.9 0-1.1.5-.7 1.5-1.8 3.8-2.8 4.8-.2.2-.4.3-.6.3-.2 0-.4-.1-.5-.5V1.2c0-.5-.2-.6-.4-.7-.2-.1-.6-.1-.8-.1z"/>
    </symbol>
    <symbol id="USD" viewBox="0 0 79.5 79.5" xmlns="http://www.w3.org/2000/svg">
        <style>.ast0 {
            fill: currentcolor
        }</style>
        <path class="ast0"
              d="M36.1 60.8V42.1c-6.9-1.7-11.9-4.2-15.2-7.5-3.2-3.4-4.8-7.4-4.8-12.2 0-4.9 1.8-9 5.5-12.3 3.6-3.3 8.5-5.2 14.5-5.7V0h7.6v4.4c5.6.6 10 2.2 13.3 4.8 3.3 2.7 5.4 6.2 6.3 10.6L50 21.3c-.8-3.5-2.9-5.9-6.3-7.1v17.4c8.4 1.9 14.2 4.4 17.2 7.5 3.1 3.1 4.6 7 4.6 11.8 0 5.4-1.9 9.9-5.8 13.6-3.8 3.7-9.2 5.9-16 6.8v8.3h-7.6v-8.1c-6.1-.6-11-2.5-14.8-5.7C17.5 62.5 15 58 14 52.1l13.8-1.2c.6 2.4 1.6 4.4 3.2 6.1 1.5 1.8 3.2 3 5.1 3.8zm0-46.7c-2.1.6-3.7 1.6-5 3-1.2 1.4-1.8 3-1.8 4.7 0 1.6.6 3 1.7 4.4 1.1 1.4 2.8 2.4 5.1 3.3V14.1zm7.6 47.3c2.6-.4 4.8-1.4 6.4-3.1 1.7-1.7 2.5-3.6 2.5-5.8 0-2-.7-3.7-2.1-5.1-1.4-1.4-3.7-2.5-6.8-3.3v17.3z"/>
    </symbol>
    <symbol id="bitcoin" viewBox="0 0 226.8 226.8" xmlns="http://www.w3.org/2000/svg">
        <style>.bst0 {
            fill: currentcolor
        }</style>
        <path class="bst0"
              d="M183 112.9c-7.3-5.5-17.7-7.7-17.7-7.7s8.8-5.1 12.4-10.2c3.6-5.1 5.4-13 5.7-17.1.3-4.1 1-21.3-12.4-31.2C160.6 39 148.7 36 132.8 35V.3h-21.4v34.3H95.1V.3H73.7v34.3H31.6v22.2H44c3.4 0 9.4.4 11.9 3.2 2.5 2.8 3 4.3 3 9.9v88.5c0 2.1-.4 4.7-2.2 6.4-1.8 1.7-3.6 2.1-7.9 2.1H36l-4.4 25.7h42.1v34.2h21.4v-34.2h16.3v34.2h21.4V192c5.5-.3 10.7-.7 13.7-1.1 6.1-.8 19.9-2.4 32.8-11.4 12.9-9 15.8-23.1 16.1-37.3.3-14.1-5.1-23.8-12.4-29.3zM95.1 58.8s6.8-.6 13.5-.5c6.7.1 12.6.3 21.4 3 8.8 2.7 14 9.3 14.2 17.1.2 7.8-3.2 13-9.2 16.3-6 3.3-14.3 5.1-22.1 5.4-7.8.3-17.8 0-17.8 0V58.8zM143 161c-4.9 2.7-14.7 5.1-24.2 5.8-9.5.7-23.7.4-23.7.4v-45.9s13.6-.7 24.2 0 19.5 3.4 23.5 5.4c4 2 11 6.4 11 16.9 0 10.5-5.9 14.7-10.8 17.4z"/>
    </symbol>
    <symbol id="bitcoin_cash" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
        <style>.cst0 {
            fill: currentcolor
        }</style>
        <circle class="cst0" cx="60" cy="60" r="50"/>
    </symbol>
    <symbol id="dash" viewBox="0 0 226.8 226.8" xmlns="http://www.w3.org/2000/svg">
        <style>.dst0 {
            fill: currentcolor
        }</style>
        <path class="dst0" d="M92.7 97.7H10.2l-9.5 31h82.5l9.5-31z"/>
        <path class="dst0"
              d="M223.9 57.9c-4.5-8.8-13.9-12.1-20.9-12.1H48.8L38.4 79.6h138.1l-20.8 67.6H16.5L6.1 181h148c14.5 0 18.3-2.5 28.7-8.6s18.4-16.6 22.8-29.3c4.4-12.6 15.1-48.2 18.3-60 3.3-11.8 4.5-16.4 0-25.2z"/>
    </symbol>
    <symbol id="ether" viewBox="0 0 226.8 226.8" xmlns="http://www.w3.org/2000/svg">
        <style>.est0 {
            fill: currentcolor
        }</style>
        <path class="est0"
              d="M112.6 157V87l-68.4 30 68.4 40zm0-74.8V-.1L46.4 111.2l66.2-29zM117-.1v82.3l67.1 29.4L117-.1zm0 87.1v70l68.4-40L117 87zm-4.4 140.4v-56.3l-67.9-39.8 67.9 96.1zm4.4 0l67.9-96.1-67.9 39.8v56.3z"/>
    </symbol>
    <symbol id="ether_classic" viewBox="0 0 226.8 226.8" xmlns="http://www.w3.org/2000/svg">
        <style>.fst0 {
            fill: currentcolor
        }</style>
        <path class="fst0"
              d="M113.4 0C50.8 0 0 50.8 0 113.4s50.8 113.4 113.4 113.4S226.8 176 226.8 113.4 176 0 113.4 0zm.3 38.2l43 67.8-43-19.2-44.3 18.7 44.3-67.3zM114 96l44.9 20-44.9 25.1-46.2-25.6L114 96zm.2 92.6l-44.7-62.3 44.3 25.6 45.1-25.6-44.7 62.3z"/>
    </symbol>
    <symbol id="litecoin" viewBox="0 0 226.8 226.8" xmlns="http://www.w3.org/2000/svg">
        <style>.gst0 {
            fill: currentcolor
        }</style>
        <path class="gst0"
              d="M94.7 184.1l12.8-60.8L172.1 79l7.6-36.2-64.6 44.5L133.4 0H83.8L57.1 127.2 30 145.9l-6.3 34.9 26-17.8-13.4 63.8h158.9l8.8-42.6-109.3-.1z"/>
    </symbol>
    <symbol id="ripple" viewBox="0 0 226.8 226.8" xmlns="http://www.w3.org/2000/svg">
        <style>.hst0 {
            fill: currentcolor
        }</style>
        <path class="hst0"
              d="M196.2 139.5c-7.6-4.2-15.8-6.1-24-6h.1c-11.2.1-20.3-8.6-20.4-19.4-.1-10.7 8.6-19.5 19.5-19.8 8.3 0 16.6-2.1 24.3-6.5C218.5 74.6 226 46 212.4 23.9c-13.6-22.1-43-29.4-65.9-16.3-22.8 13.2-30.3 41.8-16.7 63.9 5.6 9.2 2.5 21.2-7 26.6-9.4 5.4-21.4 2.5-27.2-6.4-4.1-7-10.2-13-17.9-17.2-23.1-12.7-52.4-4.8-65.5 17.7-13.1 22.4-4.9 50.9 18.2 63.6 23.1 12.7 52.4 4.8 65.5-17.7.1-.1.1-.3.2-.4 5.5-9.1 17.6-12.2 27-7 9.6 5.3 13 17.1 7.6 26.5-13.1 22.4-4.9 50.9 18.2 63.6 23.1 12.7 52.4 4.8 65.5-17.7 13.1-22.5 4.9-50.9-18.2-63.6z"/>
    </symbol>
    <symbol id="tehter_usd" viewBox="0 0 226.8 226.8" xmlns="http://www.w3.org/2000/svg">
        <style>.ist0 {
            fill: currentcolor
        }</style>
        <path class="ist0"
              d="M127.3 100.3v17c-9.7.5-19.4.5-29-.1v-16.9c-26.7 1.3-46.4 5.9-46.4 11.4 0 6.5 27.5 11.7 61.5 11.7s61.5-5.3 61.5-11.7c0-5.5-20.3-10.2-47.6-11.4z"/>
        <path class="ist0"
              d="M113.4 0C50.8 0 0 50.8 0 113.4 0 176 50.8 226.8 113.4 226.8S226.8 176 226.8 113.4C226.8 50.8 176 0 113.4 0zm13.9 132.6v50h-29v-50.1c-31.1-1.8-54.3-9-54.3-17.7 0-8.6 23.2-15.9 54.3-17.7v-14H58.8v-29h108.1v29h-39.5V97c31.7 1.7 55.5 9 55.5 17.7-.1 8.9-23.9 16.3-55.6 17.9z"/>
    </symbol>
    <symbol id="EUR" viewBox="0 0 14.994 14.994" xmlns="http://www.w3.org/2000/svg">
        <style>.ast0 {
            fill: currentcolor
        }</style>
        <!--
        <path class="ast0"
              d="M15 18.5c-2.51 0-4.68-1.42-5.76-3.5H15v-2H8.58c-.05-.33-.08-.66-.08-1s.03-.67.08-1H15V9H9.24C10.32 6.92 12.5 5.5 15 5.5c1.61 0 3.09.59 4.23 1.57L21 5.3C19.41 3.87 17.3 3 15 3c-3.92 0-7.24 2.51-8.48 6H3v2h3.06c-.04.33-.06.66-.06 1 0 .34.02.67.06 1H3v2h3.52c1.24 3.49 4.56 6 8.48 6 2.31 0 4.41-.87 6-2.3l-1.78-1.77c-1.13.98-2.6 1.57-4.22 1.57z"/>
              -->
        <path class="ast0"
              d="M12.774,11.67c-0.47,0.246-1.519,0.58-2.543,0.58c-1.116,0-2.166-0.334-2.879-1.139c-0.336-0.377-0.581-0.893-0.737-1.562h5.602V7.965H6.304c0-0.111,0-0.222,0-0.357c0-0.246,0-0.467,0.021-0.692h5.893V5.332H6.661c0.158-0.58,0.378-1.093,0.715-1.45c0.69-0.827,1.674-1.206,2.723-1.206c0.979,0,1.918,0.291,2.498,0.536l0.623-2.543C12.416,0.313,11.213,0,9.873,0C7.754,0,5.968,0.847,4.72,2.299c-0.713,0.803-1.271,1.83-1.54,3.034H1.684v1.583h1.251c0,0.225-0.023,0.447-0.023,0.67c0,0.133,0,0.27,0,0.379H1.684V9.55h1.452c0.201,1.185,0.646,2.142,1.249,2.9c1.251,1.651,3.235,2.544,5.443,2.544c1.429,0,2.724-0.424,3.482-0.846L12.774,11.67z"/>
    </symbol>
</svg>

<div style="display: none">
    <a href="https://izzz.io">Powered by iZ³ Crowdsale Platform </a>
</div>


<script>
    $(".token-show-link").on("click", function () {
        $(".token-price").slideUp();
        $(".token-show-link").slideDown();
        $(this).slideUp().prev().slideDown();
    });

    var balance = <?=$user->balance?>;
    var tokens = <?=$user->balance?>;
    var tokenName = '<?=\App\Lib\Misc::tokenName()?>';
    var viewTokenPrecision = <?=\App\Lib\Misc::tcfg('viewTokenPrecision')?>;
    var viewPrecision = <?=\App\Lib\Misc::tcfg('viewPrecision')?>;
    var baseAddress = '<?= URL_PREFIX ?>';
    var currentLang = '<?=h(\Cake\I18n\I18n::locale())?>';

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


<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/libs/popup/jquery.magnific-popup.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/common.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/cabinet.js?_=<?= rand() ?>"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/libs/qrcodejs/qrcode.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>


<?php
\App\Lib\Sandbox::runFromStorageOrIgnore('beforeClosedBody', ['user' => $user]);
?>


<script>
    function inIframe() {
        try {
            return window.self !== window.top;
        } catch (e) {
            return true;
        }
    }

    if(inIframe()) {
        document.getElementsByTagName('body')[0].innerHTML = "";
        window.parent.location = self.location;
    }
</script>


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