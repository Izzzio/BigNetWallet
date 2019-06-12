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
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/libs/izi_modal/css/iziModal.min.css"/>
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_CSS_BASE ?>/customize.css?_=<?= CORE_VERSION ?>">

    <?= $this->element('ga'); ?>
    <?= $this->element('gtag'); ?>

    <?php
    \App\Lib\Sandbox::runFromStorageOrIgnore('registerBeforeClosedHead');
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
            <img src="<?= \App\Lib\Misc::tcfg('logo') ?>" alt="logo" class="form-page__logo main-logo">
        </a>
        <nav class="form-page__nav">
            <a href="<?= URL_PREFIX ?>/app/login"><?= __('Sign in') ?></a>
            <a href="#" class="active"><?= __('Sign up') ?></a>
        </nav>
        <form action="<?= URL_PREFIX ?>/app/register" method="post" class="form-page__form sign-up-form">
            <input name="_CSRF" type="hidden" value="<?= \App\Lib\Crypt::ecrypt('CSRF_' . rand()) ?>">
            <label class="form-page__label">
                <input type="email" class="input form-page__input required" name="email" id="email" placeholder="<?= __('Email') ?>">
                <span class="form-page__error-sign"></span>
                <span class="form-page__error-message" id="emailEmptyError"><?= __('Please fill in this field') ?></span>
                <span class="form-page__error-message" id="emailError"></span>
            </label>
            <label class="form-page__label">
                <input type="password" class="input form-page__input required" name="password" id="password" placeholder="<?= __('Password') ?>">
                <span class="form-page__error-sign"></span>
                <span class="form-page__error-message" id="passwordError"><?= __('At least 8 characters, one lowercase letter, one uppercase letter') ?></span>
            </label>
            <label class="form-page__label">
                <input type="password" class="input form-page__input required" name="passwordRepeat" id="passwordRepeat" placeholder="<?= __('Repeat password') ?>">
                <span class="form-page__error-sign"></span>
                <span class="form-page__error-message" id="passwordRepeatError"><?= __('Passwords do not match') ?></span>
            </label>
            <div class="form-page__checkgroup">
                <label class="form-page__check">
                    <input type="checkbox" value="I agree with Privacy Policy" name="privacy-policy" class="agree-required">
                    <span class="form-page__check-dop"></span>
                    <span class="form-page__check-name">
                        <?= __('I agree with') ?>
                        <a href="<?= \App\Lib\Misc::policyUrl() ?>" target="_blank"><?= __('Privacy Policy') ?></a>
                    </span>
                    <span class="form-page__error-sign"></span>
                </label>
                <label class="form-page__check">
                    <input type="checkbox" value="I agree with Whitepaper" name="whitepaper" class="agree-required">
                    <span class="form-page__check-dop"></span>
                    <span class="form-page__check-name">
                        <?= __('I agree with&nbsp;') ?><a href="<?= \App\Lib\Misc::whitepaperUrl() ?>" target="_blank"><?= __('Whitepaper') ?></a>
                    </span>
                    <span class="form-page__error-sign"></span>
                </label>
                <label class="form-page__check">
                    <input type="checkbox" value="I agree with Tokensale" name="tokensale" class="agree-required">
                    <span class="form-page__check-dop"></span>
                    <span class="form-page__check-name">
                        <?= __('I agree with') ?>
                        <a href="<?= \Cake\Core\Configure::read('App.tokenSaleAgreement') ?>" target="_blank"><?= __('Tokensale agreement') ?></a>
                    </span>
                    <span class="form-page__error-sign"></span>
                </label>
            </div>

            <?php if (\Cake\Core\Configure::read('App.enableUserData')) { ?>
            <button name="next" class="btn btn--blue form-page__submit btn-next" type="button"><?= __('Continue') ?></button>
            <?php } else { ?>
            <button class="btn btn--blue form-page__submit" type="submit"><?= __('Continue') ?></button>
            <?php } ?>

        </form>
    </div>
</div>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/vendors/jquery.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/form.js"></script>
<script>
    $(document).ready(function(){
        let URL_PREFIX = '<?= URL_PREFIX ?>';
        checkEmail(URL_PREFIX);
    })




    function checkerClick(e) {
        e.preventDefault();

        var result = true;
        var element;
        var element_value = 0;

        $('.form-page__error-message', $(this)).hide();
        $('.form-page__error-sign', $(this)).hide();

        $('.required', $(this)).each(function(i, el) {
            element = $(el);
            element_value = element.val() || '';
            if(element_value.length <= 0){
                element.parent().find('.form-page__error-message').show();
                result = false;
            }
        });

        var element_checked = false;
        $('.agree-required', $(this)).each(function(i, el) {
            element = $(el);
            element_checked = element.is(':checked');
            if(!element_checked){
                element.parent().find('.form-page__error-sign').show();
                result = false;
            }
        });

        if(!result){
            return;
        }

        <?php if (\Cake\Core\Configure::read('App.enableSaftDataFilling')) { ?>
        openSaftModal();
        $('.sign-up-form').off('submit', checkerClick);
        <?php }elseif (\Cake\Core\Configure::read('App.enableUserData')){?>
        $(this).closest(".form-step").removeClass("active");
        $(this).closest(".form-step").next(".form-step").addClass("active");
        $(".btn-next").off("click", checkerClick);
        $('.sign-up-form').off('submit', checkerClick);
        <?php
        }else{?>

        $(".btn-next").off("click", checkerClick);
        $('.sign-up-form').off('submit', checkerClick);
        $('.sign-up-form').submit();
        <?php

        } ?>


    }

    $(".btn-next").on("click", checkerClick);
    $('.sign-up-form').on('submit', checkerClick);




</script>

<?= $this->element('saft') ?>

<?php
\App\Lib\Sandbox::runFromStorageOrIgnore('registerBeforeClosedBody');
?>

</body>
</html>