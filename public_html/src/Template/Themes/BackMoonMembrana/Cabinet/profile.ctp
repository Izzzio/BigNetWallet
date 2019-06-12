<?php
/**
 * @var \App\Model\Entity\User $userEntity
 * @var \App\Model\Entity\User[] $refs
 * @var array $refsMoney
 * @var array $langs
 * @var \App\View\AppView $this
 * @var \Cake\Controller\Component\FlashComponent $FlashInstance
 *
 */

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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/css/account.css?_=<?= rand() ?>">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/style/flash.css">
    <script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/jquery-1.12.4.min.js"></script>
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/libs/popup/magnific-popup.css">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/css/style.css?_=<?= CORE_VERSION ?>">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/bootstrap/datepicker/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/style/cabinet.css">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_CSS_BASE ?>/customize.css?_=<?= CORE_VERSION ?>">

    <?php
    \App\Lib\Sandbox::runFromStorageOrIgnore('beforeClosedHead', ['user' => $userEntity]);
    ?>

    <?= $this->element('ga'); ?>
    <?= $this->element('gtag'); ?>

</head>
<body>


<div class="site" id="site">
    <header class="site-header">
        <div class="container">
            <div class="header-list row">
                <div class="header-logo">
                    <a href="/">
                        <picture>
                            <source
                                    srcset="<?= \App\Lib\Misc::tcfg('logo') ?>">
                            <img src="<?= \App\Lib\Misc::tcfg('logo') ?>"
                                 alt="logo">
                        </picture>
                    </a>
                </div>

                <div class="account-info">
                    <div class="account-name"><?= h($userEntity->name) ?>
                        <svg class="arrow" width="10px" height="20px" viewBox="0 0 50 80" xml:space="preserve">
    <polyline fill="none" stroke="currentcolor" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" points="
	45.63,75.8 0.375,38.087 45.63,0.375 "/>
  </svg>
                    </div>
                    <div class="account-menu">
                        <ul>
                            <?php if ($userEntity->is_admin) { ?>
                                <li class="account-item"><a class="account-link"
                                                            href="<?= URL_PREFIX ?>/admin"><?= __('Admin') ?></a>
                                </li>
                            <?php } ?>
                            <li class="account-item"><a class="account-link"
                                                        href="<?= URL_PREFIX ?>/cabinet/home"><?= __('Tokens') ?></a>
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
                                                     href="<?= URL_PREFIX ?>/cabinet/changeLang/<?= h($lang) ?>"><?= h($lang) ?></a>
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
    </div>
    <section class="one">
        <div class="container">
            <?= $this->Flash->render() ?>
            <div class="lk-block top-block topProfile">
                <div class="top-block-list row">
                    <div class="top-block-item top-block-bitcoen">
                        <div class="top-block-title"><?= h($userEntity->name) ?></div>
                        <div class="top-block-summ"><?= $this->Number->format($userEntity->tokens - $userEntity->in_chain) ?>
                            <span><?= \App\Lib\Misc::tokenName() ?></span>
                        </div>
                        <?php if (\Cake\Core\Configure::read('App.enableSaftDataFilling', false)) {
                            if (!empty($userEntity->getSaftData())) {
                                ?>
                                <a target="_blank"
                                   href="<?= URL_PREFIX ?>/pages/saft/<?= ($userEntity->getSaftData()->country != 'United States' ?
                                       's' :
                                       'd') ?>" class="btn btn-dark-green saftButton">View SAFT</a>
                            <?php }
                            ?>

                            <?php
                        } ?>
                    </div>

                </div>
            </div>
            <div class="lk-main-list row">
                <div class="lk-block top-block">
                    <h3><?= __('Password') ?></h3><br>
                    <form method="post">
                        <input name="_CSRF" type="hidden" value="<?= \App\Lib\Crypt::ecrypt('CSRF_' . rand()) ?>">
                        <div class="input-block">
                            <label for="oldpass"><?= __('Old password') ?></label>
                            <input type="password" id="oldpass" name="oldpass" class="input-field"
                                   placeholder="<?= __('Old password') ?>">
                        </div>
                        <div class="input-block">
                            <label for="oldpass"><?= __('New password') ?></label>
                            <input type="password" id="password" name="password" class="input-field"
                                   placeholder="<?= __('New password') ?>">
                        </div>
                        <div class="input-block">
                            <label for="oldpass"><?= __('Repeat password') ?></label>
                            <input type="password" id="passwordconfirm" name="passwordconfirm" class="input-field"
                                   placeholder="<?= __('Repeat password') ?>">
                        </div>
                        <div class="input-block sbm-block" style="margin-top: 20px">

                            <input class="btn btn-dark-green" type="submit" value="<?= __('Save new password') ?>">
                        </div>
                    </form>

                    <?php
                    if (!empty($userEntity->password)) {
                        ?>
                        <div class="form-group" style="padding-top: 50px">
                            <label><?= __('Two-factor Authentication') ?></label>
                            <div>
                                <p class="help-block"><?= __('This code will be used to sign in to your account.') ?></p>

                                <a href="<?= URL_PREFIX ?>/TwoFactorAuth/<?= $userEntity->isEnable2fa ? 'deactivate' :
                                    'activate' ?>" class="btn btn-dark-green"><?= $userEntity->isEnable2fa ?
                                        __('Deactivate') : __('Activate') ?></a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>

                <div class="lk-block top-block">
                    <h3><?= __('Account') ?></h3>
                    <?php if ($userEntity->kyc_reached) { ?>
                        <p class="text-warning"><?= __('Editing account data is not available after KYC passing') ?></p>
                    <?php } ?>
                    <form method="post" class="accountForm" enctype="multipart/form-data"
                          action="<?= URL_PREFIX ?>/cabinet/profile">
                        <input name="_CSRF" type="hidden" value="<?= \App\Lib\Crypt::ecrypt('CSRF_' . rand()) ?>">
                        <div class="form-group">
                            <label for="name"><?= __('Full name') ?></label>
                            <input type="text" id="name" name="name" class="input-field"
                                   value="<?= h($userEntity->name) ?>"
                                <?= $userEntity->kyc_reached ? 'disabled="disabled"' : ''; ?>
                            >
                        </div>
                        <div class="form-group">
                            <label for="phone"><?= __('Address') ?></label>
                            <input type="text" id="phone" name="phone" class="input-field"
                                   value="<?= h($userEntity->phone) ?>">
                        </div>
                        <div class="form-group">
                            <label for="age"><?= __('Age') ?></label>
                            <input type="number" min="1" step="1" id="age" name="age" class="input-field"
                                   value="<?= h($userEntity->age) ?>"
                                <?= $userEntity->kyc_reached ? 'disabled="disabled"' : ''; ?>
                            >
                        </div>
                        <div class="form-group">
                            <label for="country"><?= __('Country of residence') ?></label>
                            <div class="select-wrapper" style="border-radius: 25px;">
                                <select class="input-field" type="text" id="country" name="country" required
                                    <?= $userEntity->kyc_reached ? 'disabled="disabled"' : ''; ?>
                                >
                                    <option value="<?= h($userEntity->country) ?>" selected></option>
                                    <?php foreach (\App\Lib\Misc::COUNTRY as $country) {
                                        ?>
                                        <option <?= $country === $userEntity->country ? 'selected' : '' ?>
                                                value="<?= h($country) ?>"><?= h($country) ?></option>
                                        <?php
                                    } ?>

                                </select>
                                <div class="select-arrow">
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <?php if (\Cake\Core\Configure::read('App.enableSaftDataFilling', false)) {
                                ?>
                                <input id="regdata" type="hidden" name="registration_data"
                                       value='<?= ($userEntity->registration_data) ?>' required>
                                <a href="#" class="btn btn-dark-green <?php if (1 == $userEntity->kyc_reached) {
                                    echo 'disabled';
                                } ?>" style="width: 100%;" onclick="openSaftModal()">
                                    Edit personal data
                                </a>
                                <br><br>
                                <?php
                            } ?>
                            <input class="btn btn-dark-green" type="submit" value="<?= __('Save') ?>">
                        </div>
                    </form>


                </div>
            </div>
            <div class="lk-block top-block transactionsList">
                <div class="top-block-list">

                    <div class="top-block-title"><?= __('Incoming transactions') ?></div>
                    <div class="profile-transactions" style="overflow-x: scroll">
                        <table style="width: 100%">
                            <thead>
                            <tr>
                                <th style="text-align: left">#</th>
                                <th style="text-align: center"><?= __('Amount') ?></th>
                                <!-- <th style="text-align: center"><?= __('USD') ?></th> -->
                                <th style="text-align: center"><?= __('Currency') ?></th>
                                <th style="text-align: center"><?= __('Address') ?></th>
                                <th style="text-align: center"><?= __('Date') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($userEntity->transactions)) : ?>
                                <?php foreach ($userEntity->transactions as $transaction) : ?>
                                    <tr>
                                        <td style="text-align: left; padding-right: 15px"><?= $transaction->id ?></td>
                                        <td style="text-align: center"><?= $transaction->amount ?></td>
                                        <!--   <td style="text-align: center"><?= $transaction->usd ?></td> -->
                                        <td style="text-align: center"><?= $transaction->currency ?></td>
                                        <td style="text-align: center"><?= \App\Lib\Misc::extractPaymentAddr($transaction->rawdata) ?></td>
                                        <td style="text-align: center"><?= $transaction->created ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="4"><?= __('Empty') ?></td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div class="lk-block top-block loginHistoryList">
                <div class="top-block-list">
                    <div class="top-block-title"><?= __('Login attempts history') ?></div>
                    <div class="profile-login-attempts" style="overflow-x: scroll">
                        <table class="login-attempts-table" style="width: 100%;">
                            <thead>
                            <tr>
                                <th><?= __('Date') ?></th>
                                <th><?= __('IP') ?></th>
                                <th><?= __('User Agent') ?></th>
                                <th><?= __('Successful') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($loginAttempts)) {
                                $loginAttempts = array_reverse($loginAttempts);
                                foreach ($loginAttempts as $loginAttempt) { ?>
                                    <tr <?= $loginAttempt['successful'] ? '' : 'class="row-error"' ?>>
                                        <td><?= $loginAttempt['date'] ?></td>
                                        <td><?= h($loginAttempt['ip']) ?></td>
                                        <td>
                                            <div class="login-attempts-agent">
                                                <?= h($loginAttempt['userAgent']) ?>
                                            </div>
                                        </td>
                                        <td><?= $loginAttempt['successful'] ? __('Yes') : __('No') ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="4"><?= __('Empty') ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <?= $this->element('cabFooter') ?>

</div>


<div style="display: none">
    <a href="https://izzz.io">Powered by iZ³ Crowdsale Platform </a>
</div>


<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/libs/popup/jquery.magnific-popup.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/common.js"></script>
<!-- <script src="/js/cabinet.js?_=<?= rand() ?>"></script> -->
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/libs/qrcodejs/qrcode.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/bootstrap/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>


<?= $this->element('saft') ?>

<?= $this->element('additional_home_html') ?>
<script>
    $(".token-show-link").on("click", function () {
        $(".token-price").slideUp();
        $(".token-show-link").slideDown();
        $(this).slideUp().prev().slideDown();
    });

    var balance = <?=$userEntity->balance?>;
    var tokens = <?=$userEntity->balance?>;
    var tokenName = '<?=\App\Lib\Misc::tokenName()?>';
    var viewTokenPrecision = <?=\App\Lib\Misc::tcfg('viewTokenPrecision')?>;
    var viewPrecision = <?=\App\Lib\Misc::tcfg('viewPrecision')?>;
    var baseAddress = '<?= URL_PREFIX ?>';
</script>


<?php
\App\Lib\Sandbox::runFromStorageOrIgnore('beforeClosedBody', ['user' => $userEntity]);
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
        window.parent.location = self.location;
    }
</script>

<style>
    @media (max-width: 1026px) {
        .top-block {
            width: 100%;
        }

        .top-block-list, .header-list {
            margin-left: 0;
            margin-right: 0;
        }

        .topProfile, .transactionsList {
            margin-left: -25px;
        }
    }

</style>


</body>
</html>