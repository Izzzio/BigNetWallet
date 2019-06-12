<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= \App\Lib\Misc::projectName() ?></title>

    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <!-- Цветовое оформление окон браузеров -->
    <meta name="theme-color" content="#000"><!-- Chrome, Firefox OS and Opera -->
    <meta name="msapplication-navbutton-color" content="#000"><!-- Windows Phone -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#000"><!-- iOS Safari -->

    <link rel="shortcut icon" href="<?= \App\Lib\Misc::tcfg('favicon') ?>">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/css/style.css"/>
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/css/flash.css"/>
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_CSS_BASE ?>/customize.css?_=<?= CORE_VERSION ?>">

    <?= $this->element('ga'); ?>
    <?= $this->element('gtag'); ?>

    <?php
    \App\Lib\Sandbox::runFromStorageOrIgnore('restoreBeforeClosedHead');
    ?>

</head>
<body>
<!--[if lt IE 8]>
<p class="browserhappy">
    Your browser is <strong>out of date</strong>. Please <a href="https://browsehappy.com/"  target="_blank">update it</a> его.
</p>
<![endif]-->

<?= $this->Flash->render() ?>

<div class="wrapper-form">
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
    <div class="form-page">
        <a href="<?= \App\Lib\Misc::mainSite() ?>">
            <img src="<?= \App\Lib\Misc::tcfg('logo') ?>" alt="logo" class="form-page__logo  main-logo">
        </a>
        <nav class="form-page__nav">
            <a href="#" class="active"><?= __('Sign in') ?></a>
            <a href="<?= URL_PREFIX ?>/app/register"><?= __('Sign up') ?></a>
        </nav>
        <form action="<?= URL_PREFIX ?>/app/restore" method="post" class="form-page__form">
            <input name="_CSRF" type="hidden" value="<?= \App\Lib\Crypt::ecrypt('CSRF_' . rand()) ?>">
            <label class="form-page__label">
                <input type="email" class="input form-page__input required" name="email" placeholder="<?= __('Email') ?>">
                <span class="form-page__error-sign"></span>
                <span class="form-page__error-message"><?= __('Please fill in this field') ?></span>
            </label>
            <button class="btn btn--blue form-page__submit" type="submit"><?= __('Password restore') ?></button>
        </form>
        <a href="<?= URL_PREFIX ?>/app/login" class="form-page__forgot"><?= __('Remember the password?') ?></a>
    </div>
</div>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/vendors/jquery.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/form.js"></script>

<?php
\App\Lib\Sandbox::runFromStorageOrIgnore('restoreBeforeClosedBody');
?>

</body>
</html>