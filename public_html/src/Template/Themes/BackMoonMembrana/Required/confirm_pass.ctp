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


    <?= $this->element('ga'); ?>
    <?= $this->element('gtag'); ?>


    <?php
    \App\Lib\Sandbox::runFromStorageOrIgnore('beforeClosedHead', ['user' => $user]);
    ?>


</head>
<body>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <header class="site-header">
                <div class="container">
                    <div class="header-list row">
                        <div class="header-logo col-md-8 col-xs-4">
                            <a href="<?= \App\Lib\Misc::mainSite() ?>">
                                <picture>
                                    <source
                                            srcset="<?= \App\Lib\Misc::tcfg('logo') ?>">
                                    <img src="<?= \App\Lib\Misc::tcfg('logo') ?>"
                                         alt="logo">
                                </picture>
                            </a>
                        </div>
                        <div class="account-info col-md-3 col-xs-6 text-right">
                            <div class="account-name"><?= h($user->name) ?>
                                <svg class="arrow" width="10px" height="20px" viewBox="0 0 50 80" xml:space="preserve">
                                    <polyline fill="none" stroke="currentcolor" stroke-width="8" stroke-linecap="round"
                                              stroke-linejoin="round" points="
                                    45.63,75.8 0.375,38.087 45.63,0.375 "/>
                                </svg>
                            </div>
                            <div class="account-menu" style="margin-left: 47%;">
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
                        <div class="lang col-md-1 col-xs-2 text-right" style="margin-left: 0px;">
                            <div class="lang-current"><?= h(\Cake\I18n\I18n::locale()) ?></div>
                            <ul class="lang-list" style="margin-left: 20px;">
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

            <section class="one">
                <div class="container">
                    <?= $this->Flash->render() ?>


                    <div class="">
                        <div class="lk-block top-block">
                            <h3><?= __('Please, input you password for continue') ?></h3><br>
                            <form method="post" class="accountForm">
                                <br/>
                                <div class="form-group">
                                    <label for="pass"><?= __('Password') ?></label>
                                    <input type="password" id="pass" name="pass" class="input-field"
                                           placeholder="<?= __('Password') ?>">
                                </div>
                                <input type="submit" class="btn btn-dark-green" style="margin-top: 25px"
                                       value="<?= __('Continue') ?>">
                            </form>
                        </div>
                    </div>

                </div>
            </section>

        </div>
    </div>
</div>


<?= $this->element('cabFooter') ?>


<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/libs/popup/jquery.magnific-popup.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/common.js"></script>


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