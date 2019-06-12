<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= \App\Lib\Misc::projectName() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="shortcut icon" href="<?= \App\Lib\Misc::tcfg('favicon') ?>">
    <meta name="msapplication-TileColor" content="#603cba">
    <meta name="theme-color" content="#ffffff">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/css/sign.css">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/style/flash.css">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_CSS_BASE ?>/customize.css?_=<?= CORE_VERSION ?>">
    <?= $this->element('ga'); ?>
    <?= $this->element('gtag'); ?>

    <?php
    \App\Lib\Sandbox::runFromStorageOrIgnore('loginBeforeClosedHead');
    ?>

</head>
<body class="login-body">


<?= $this->Flash->render() ?>
<div class="site sign-in-page login-site" id="site">
    <div class="sign-header row">
        <div class="sign-name sign-header-col">
            <a href="<?= \App\Lib\Misc::mainSite() ?>">
                <picture>
                    <source
                            srcset="<?= \App\Lib\Misc::tcfg('logo') ?>">
                    <img src="<?= \App\Lib\Misc::tcfg('logo') ?>"
                         alt="logo">
                </picture>
            </a>
        </div>


    </div>
    <div class="sign-block-wrapper">
        <div class="sb-bg1 sb-bg">
            <picture>
                <source
                        srcset="/img/sb-bg1.png,
										/img/sb-bg1_2x.png 2x">
                <img class="sb-bg" src="/img/sb-bg1.png"
                     alt="">
            </picture>
        </div>
        <div class="sb-bg2 sb-bg">
            <picture>
                <source
                        srcset="/img/sb-bg2.png,
										/img/sb-bg2_2x.png 2x">
                <img class="sb-bg" src="/img/sb-bg2.png"
                     alt="">
            </picture>
        </div>
        <div class="sign-block">
            <form class="sign-in-form" action="<?= URL_PREFIX ?>/app/login" method="POST">
                <input name="_CSRF" type="hidden" value="<?= \App\Lib\Crypt::ecrypt('CSRF_' . rand()) ?>">
                <div class="sign-block-title"><?= __('Sign in') ?></div>
                <div class="input-block">
                    <label for="email"><?= __('Email') ?></label>
                    <input class="input-field" type="text" id="email" name="email" required>
                </div>
                <div class="input-block">
                    <label for="pass"><?= __('Password') ?></label>
                    <input class="input-field" type="password" id="pass" name="password" autocomplete="off" required>
                </div>
                <div class="input-block sbm-block">
                    <input class="btn-sbm" type="submit" value="<?= __('Sign in') ?>">
                </div>
                <a class="sign-link" href="<?= URL_PREFIX ?>/app/restore"><?= __('Forgot password') ?></a>
                <a class="sign-link sign-up-link" href="<?= URL_PREFIX ?>/app/register"><?= __('Sign up') ?></a>
            </form>

            <?php if (\Cake\Core\Configure::read('App.enableSocial')) { ?>
                <div class="input-block sbm-block">
                    <?php

                    foreach (\Cake\Core\Configure::read('HybridAuth.providers') as $provider => $value) {
                        if ($value['enabled'] === false) {
                            continue;
                        }
                        echo $this->Form->postLink(
                            $this->Html->image(
                                URL_PREFIX . APP_THEME_BASE . "/img/social/" . strtolower($provider) . ".png",
                                [
                                    "alt"   => "Sign in with {$provider}",
                                    'class' => 'social-logo',
                                    'style' => 'padding-left: 10px',
                                ]
                            ),
                            ['controller' => 'App', 'action' => 'login', '?' => ['provider' => $provider]],
                            ['escape' => false]
                        );

                    } ?>
                </div>

            <?php } ?>

        </div>
    </div>

</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/jquery-1.12.4.min.js"></script>


<script>
    $('.close').click(function () {
        $(this).parent().parent().parent().remove();
    });
</script>

<?php
\App\Lib\Sandbox::runFromStorageOrIgnore('loginBeforeClosedBody');
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

</body>
</html>