<?php
/**
 * @var \App\Model\Entity\User $user
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Izzz.io - iZ³ Tokensale platform</title>
    <meta name="description" content="iZ³ Tokensale platform"/>
    <meta name="keywords" content="HTML, CSS, XML"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="https://izzz.io/favicon.ico">

    <!-- bootstrap -->
    <link rel="stylesheet" href="<?= URL_PREFIX ?>/bootstrap/css/bootstrap.min.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="<?= URL_PREFIX ?>/bootstrap/css/bootstrap-theme.min.css" type="text/css" media="all"/>

    <!-- fonts -->
    <link rel="stylesheet" href="<?= URL_PREFIX ?>/fonts/MyriadProLight/MyriadProLight.css" type="text/css" media="all"/>

    <!-- fancyBox -->
    <link rel="stylesheet" href="<?= URL_PREFIX ?>/js/fancyBox/source/jquery.fancybox.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?= URL_PREFIX ?>/js/fancyBox/source/helpers/jquery.fancybox-buttons.css" type="text/css"
          media="screen"/>

    <!-- slider -->
    <link rel="stylesheet" href="<?= URL_PREFIX ?>/js/owl.carousel/assets/owl.carousel.css" type="text/css" media="all"/>

    <!-- timer -->
    <link rel="stylesheet" href="<?= URL_PREFIX ?>/js/timeTo/timeTo.css" type="text/css" media="all"/>

    <link rel="stylesheet" href="<?= URL_PREFIX ?>/style/style.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="<?= URL_PREFIX ?>/style/material.css" type="text/css" media="all"/>
    <!-- <link rel="stylesheet" href="/style/style2.css" type="text/css" media="all"/> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hamburgers/0.9.1/hamburgers.min.css"
          integrity="sha256-hCM6SsLZUT2/Vkykg2meK/x+qOo9SJPfYif9agoSGOk=" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
          integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous"/>

    <script src="<?= URL_PREFIX ?>/js/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

    <style>
        .alert.alert-success {
            color: #0b0b0b;
        }
    </style>
</head>
<body class="home-page">

<!-- container -->
<div>


    <div>
        <div class="b-promo"
             style="padding: 10px;background-image: url(https://static.tildacdn.com/tild6530-6161-4631-a137-633538393266/back.png);">
            <div class="container">
                <div style="">
                </div>
                <a href="<?= URL_PREFIX ?>/"> <img title="izzz.io - iZ³ Tokensale platform" src="<?= URL_PREFIX ?>/images/logo-white.svg"
                                  style="max-height: 70px;     width: 100px; position: absolute; "></a>
                <div class="headerTool">
                    <?php
                    if (isset($user) && $user) {
                    ?>
                    <?= $user->email ?>&nbsp;
                    <a href="<?= URL_PREFIX ?>/app/logout">
                        <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                    </a>
                    <?php
                    }
                    ?>
                </div>


            </div>
        </div>

    </div>

    <div id="main">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>


    <div class="col-md-12" style="background-color: black; min-height: 100px; color: white; position: absolute; width: 100%">
        <div style="padding-top: 35px; padding-left: 15px; padding-right: 15px">
            <div class="col-md-5">
                <a id="about" target="_blank" href="https://izzz.io/en/cabinet/?client=<?=urlencode(\App\Lib\Misc::projectName())?>">About iZ³ Tokensale platform</a>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-5" style="text-align: right">
                <a href="https://izzz.io/en/?client=<?=urlencode(\App\Lib\Misc::projectName())?>" target="_blank">izzz.io</a>
            </div>
        </div>
    </div>

    <script src="<?= URL_PREFIX ?>/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= URL_PREFIX ?>/js/bootstrap-select.js" type="text/javascript"></script>
    <script src="<?= URL_PREFIX ?>/js/fancyBox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
    <script src="<?= URL_PREFIX ?>/js/fancyBox/source/helpers/jquery.fancybox-buttons.js" type="text/javascript"></script>
    <script src="<?= URL_PREFIX ?>/js/fancyBox/source/helpers/jquery.fancybox-media.js" type="text/javascript"></script>
    <script src="<?= URL_PREFIX ?>/js/jquery.maskedinput.min.js" type="text/javascript"></script>
    <script src="<?= URL_PREFIX ?>/js/owl.carousel/owl.carousel.min.js" type="text/javascript"></script>
    <script src="<?= URL_PREFIX ?>/js/timeTo/jquery.time-to.js" type="text/javascript"></script>
    <script src="<?= URL_PREFIX ?>/js/main.js" type="text/javascript"></script>
    <script src="<?= URL_PREFIX ?>/js/admin.js" type="text/javascript"></script>

    <script>
        console.log("%cDon't Panic!", 'color: red; font-size: 48px');
        console.log("%c   " + " %cTokensale Platform", 'color: black; background: url(<?= URL_PREFIX ?>/images/logo-white.svg) no-repeat black; font-size: 48px', 'font-size: 48px; background-color:black; color:white');
        console.log("%cwill do all the hard work itself!", 'background-color:black; color:white; font-size: 30px');
        console.log("%cMore at " + $('#about').attr('href'), 'background-color:black; color:white; font-size: 30px');

    </script>


    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter47787229 = new Ya.Metrika2({
                        id:47787229,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true,
                        webvisor:true
                    });
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/tag.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks2");
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/47787229" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

</body>
</html>