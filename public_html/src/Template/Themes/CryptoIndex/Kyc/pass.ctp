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

    <?php
    \App\Lib\Sandbox::runFromStorageOrIgnore('beforeCss', ['user' => $user]);
    ?>

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
                <div class="cab-tabs-item js-item">
                    <div class="cab-blc cab-authentication cab-tabs-item__blc js-cases-slide" style="display: block;">
                        <h2 class="cab-tabs-item__title"><?= __('KYC') ?></h2>
                        <div class="cab-authentication__wrap">
                            <div class="cab-authentication__main" style="width: 100%;">

                                <?php if ($accessToken['success']) { ?>
                                <div id="idensic"></div>
                                <script src="<?= $url ?>/idensic/static/idensic.js"></script>
                                <script>
                                    var id = idensic.init(
                                        '#idensic',
                                        {
                                            accessToken: "<?=$accessToken['data']?>",
                                            applicantId: "<?=$applicantId?>",
                                            lang: '<?= h(\Cake\I18n\I18n::locale()) ?>'
                                            /*
                                            userId: '<?=$userId?>',
                                        userAgreementUrl: "",
                                        privacyPolicyUrl: "",
                                        requiredDocuments: "IDENTITY:PASSPORT,DRIVERS;SELFIE:SELFIE;",

                                        applicantDataPage: {
                                            enabled: true,
                                            "fields": [
                                                {
                                                    "name": "firstName",
                                                    "required": true
                                                },
                                                {
                                                    "name": "lastName",
                                                    "required": true
                                                },
                                                {
                                                    "name": "email",
                                                    "required": false
                                                }
                                            ]
                                        }
                                        */
                                        },
                                        function (messageType, payload) {
                                            // idCheck.onReady, idCheck.onResize, idCheck.onCancel, idCheck.onSuccess, idCheck.onApplicantCreated
                                            console.log('[IDENSIC DEMO] Idensic message:', messageType, payload);
                                            // resizing iframe to the inner content size
                                            if(messageType == 'idCheck.onResize') {
                                                idensic.iframe.height = payload.height;
                                            }
                                        }
                                    );
                                </script>
                                <?php } else { ?>
                                <div style="color: red; text-align: center;">
                                    <?= 'AccessToken error: ' . $accessToken['data'] ?><br/>
                                </div>
                                <?php } ?>

                                <br />
                                <a href="<?= URL_PREFIX ?>/cabinet/home" class="btn cab-btn--blue cab-copylink__copy"><?= __('Back') ?></a>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <?= $this->element('cabFooter') ?>

</div>

<?php
\App\Lib\Sandbox::runFromStorageOrIgnore('beforeClosedBody', ['user' => $user]);
?>

<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/vendors/jquery.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/vendors/nariko.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/page.js"></script>

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