<?php
/**
 * @var array $caps
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>BitCoen - Первый  еврейский крипто-токен и blockchain экосистема</title>
    <meta name="description"
          content="BitCoen - Первый  еврейский крипто-токен и blockchain экосистема. На этом сайте вы сможете подробнее узнать о проекте биткоэн"/>
    <meta name="keywords"
          content="bitcoin, bitcoen, cryptocurrency, crypto, jewish, kosher, биткоэн, биткоин, кошерная, еврейская"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/images/favicon.ico">

    <!-- bootstrap -->
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" type="text/css" media="all"/>

    <!-- fonts -->
    <link rel="stylesheet" href="/fonts/MyriadProLight/MyriadProLight.css" type="text/css" media="all"/>

    <!-- fancyBox -->
    <link rel="stylesheet" href="/js/fancyBox/source/jquery.fancybox.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="/js/fancyBox/source/helpers/jquery.fancybox-buttons.css" type="text/css"
          media="screen"/>

    <!-- slider -->
    <link rel="stylesheet" href="/js/owl.carousel/assets/owl.carousel.css" type="text/css" media="all"/>

    <!-- timer -->
    <link rel="stylesheet" href="/js/timeTo/timeTo.css" type="text/css" media="all"/>

    <link rel="stylesheet" href="/style/style.css" type="text/css" media="all"/>
</head>
<body class="home-page">


<!-- container -->
<div id="container">
    <?= $this->Flash->render() ?>
    <!-- header -->
    <header id="header">
        <div class="container">
            <div class="header-content">
                <a class="b-logo"><img src="/images/logo.png" alt=""></a>
      <div class="b-counter">
                 <!--  <div class="b-counter__title">PRE ICO завершено:</div> -->
                         <!--     <div class="b-counter__content">
                        <div class="counter" data-timeTo="Sun Oct 09 2017 12:00:00 GMT+0300 (Россия (лето))"></div> 
                    </div>-->
                </div>
                <!-- <a class="b-btn form-btn" href="#form-reg" data-form-title="Принять участие">Принять участие</a>  -->

                <!-- nav -->
                <nav class="b-menu">
                    <a href="#" class="b-menu__mobile-icon"><span></span></a>
                    <div id="nav" class="b-menu__content">
                        <ul class="b-menu__list nav">
                            <li><a class="anchor" href="#section-steps">Этапы</a></li>
                            <li><a class="anchor" href="#section-team">Наша команда</a></li>
                            <li><a class="anchor" href="#section-projects">Наши проекты</a></li>
                            <!-- <li><a class="white-paper" href="#" target="_blank">White paper</a></li> -->
                        </ul>

                        <div class="b-lang">
                              <span class="b-lang__lang-item b-lang__lang-item_nav b-nav-btn"><span
                                          class="icon-lang ru"><img src="/images/flags/Russia.png"
                                                                    alt=""></span>RU</span>

                            <div class="b-lang__content">
                                <ul class="b-lang__content-list">
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang gb"><img
                                                        src="/images/flags/Russia.png" alt=""></span>RU</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang gb"><img
                                                        src="/images/flags/United-kingdom.png" alt=""></span>EN</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang iw"><img
                                                        src="images/flags/Israel.png" style="width: 16" alt=""></span>IW</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang al"><img
                                                        src="images/flags/Albania.png" alt=""></span>AL</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang ad"><img
                                                        src="images/flags/Andorra.png" alt=""></span>AD</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang am"><img
                                                        src="images/flags/Armenia.png" alt=""></span>AM</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang at"><img
                                                        src="images/flags/Austria.png" alt=""></span>AT</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang az"><img
                                                        src="images/flags/Azerbaijan.png" alt=""></span>AZ</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang bg"><img
                                                        src="images/flags/Bulgaria.png" alt=""></span>BG</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang be"><img
                                                        src="images/flags/Belgium.png" alt=""></span>BE</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang ba"><img
                                                        src="images/flags/Bosnian.png" alt=""></span>BA</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang=m"><span class="icon-lang hr"><img
                                                        src="images/flags/Croatian.png" alt=""></span>HR</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang=pt-"><span class="icon-lang ptbr"><img
                                                        src="images/flags/Cyprus.png" alt=""></span>PT</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang cz"><img
                                                        src="images/flags/Czech-republic.png" alt=""></span>CZ</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang ee"><img
                                                        src="images/flags/Estonia.png" alt=""></span>EE</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang fl"><img
                                                        src="images/flags/Finland.png" alt=""></span>FL</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang fr"><img
                                                        src="images/flags/France.png" alt=""></span>FR</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang ge"><img
                                                        src="images/flags/Georgia.png" alt=""></span>GE</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang de"><img
                                                        src="images/flags/Germany.png" alt=""></span>DE</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang gr"><img
                                                        src="images/flags/Greece.png" alt=""></span>GR</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang hu"><img
                                                        src="images/flags/Hungary.png" alt=""></span>HU</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang ic"><img
                                                        src="images/flags/Iceland.png" alt=""></span>IC</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang ie"><img
                                                        src="images/flags/Ireland.png" alt=""></span>IE</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang it"><img
                                                        src="images/flags/Italy.png" alt=""></span>IT</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang xk"><img
                                                        src="images/flags/Kosovo.png" alt=""></span>XK</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang lv"><img
                                                        src="images/flags/Latvia.png" alt=""></span>LV</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang li"><img
                                                        src="images/flags/Liechtenstein.png" alt=""></span>LI</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang lt"><img
                                                        src="images/flags/Lithuania.png" alt=""></span>LT</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang lu"><img
                                                        src="images/flags/Luxembourg.png" alt=""></span>LU</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang mk"><img
                                                        src="images/flags/Macedonia.png" alt=""></span>MK</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang mt"><img
                                                        src="images/flags/Malta.png" alt=""></span>MT</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang md"><img
                                                        src="images/flags/Moldova.png" alt=""></span>MD</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang mc"><img
                                                        src="images/flags/Monaco.png" alt=""></span>MC</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang me"><img
                                                        src="images/flags/Montenegro.png" alt=""></span>ME</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang nl"><img
                                                        src="images/flags/Netherlands.png" alt=""></span>NL</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang no"><img
                                                        src="images/flags/Norway.png" alt=""></span>NO</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang pl"><img
                                                        src="images/flags/Poland.png" alt=""></span>PL</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang pt"><img
                                                        src="images/flags/Portugal.png" alt=""></span>PT</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang ro"><img
                                                        src="images/flags/Romania.png" alt=""></span>RO</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang sm"><img
                                                        src="images/flags/San-marino.png" alt=""></span>SM</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang rs"><img
                                                        src="images/flags/Serbia.png" alt=""></span>RS</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang sk"><img
                                                        src="images/flags/Slovakia.png" alt=""></span>SK</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang si"><img
                                                        src="images/flags/Slovenia.png" alt=""></span>SI</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang es"><img
                                                        src="images/flags/Spain.png" alt=""></span>ES</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang se"><img
                                                        src="images/flags/Sweden.png" alt=""></span>SE</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang ch"><img
                                                        src="images/flags/Switzerland.png" alt=""></span>CH</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang tr"><img
                                                        src="images/flags/Turkey.png" alt=""></span>TR</a>
                                    </li>
                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang ua"><img
                                                        src="images/flags/Ukraine.png" alt=""></span>UA</a>
                                    </li>

                                    <li class="b-lang-list__item-wrapper">
                                        <a class="b-lang__lang-item" href="/?lang="><span class="icon-lang va"><img
                                                        src="images/flags/Vatican-city.png" alt=""></span>VA</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php
                        if(!empty($currentUser)) {
                            ?>
                            <a class="b-nav-btn" href="/pages/home"><?=$currentUser['email']?></a>
                            <?php
                        }else{
                            ?>
                            <a class="b-nav-btn form-btn" href="#form-login" id="loginButton"><?=__('Личный кабинет')?></a>
                            <?php
                        }?>

                        <a class="reg-btn form-btn" href="#form-reg"
                           data-form-title="Регистрация в BitCoen"><?=__('Регистрация')?></a>
                                               <a class="chat" href="https://telegram.me/Bit_coen" target="_blank"><img
                                    src="images/b-contacts/4.png" alt=""></a>
                        <a class="chat" href="https://medium.com/@bitcoen" target="_blank"><img
                                    src="images/b-contacts/6.png" alt=""></a>
                    </div>
                </nav><!-- //nav -->

            <!--    <div class="b-small-contact">
                    <div class="b-small-contact__item b-small-contact__item_phone">
                        <a href="tel:+74994505524">+ 7 (499) 450-55-24</a><br/>
                        <?=__('Горячая линия')?>
                    </div>
                </div> -->
            </div>
        </div>
    </header><!-- //site-header -->

    <!-- main -->
    <div id="main">
        <div class="b-promo landing-section">
            <div class="container">
                <div class="b-promo__img"></div>
                <div class="b-promo__content">
                    <div class="b-logo">
                        <img src="images/logo.png" alt="">
                    </div>
                    <h1><?=__('BitCoen - Первый  еврейский крипто-токен и blockchain экосистема')?> <span>BitCoen <a class="anchor" href="#section-global-info"><img
                                        src="images/question-icon.png" alt=""></a></span></h1>


                    <div class="b-promo__video">
 

                        <a class="b-promo__video-content video-fancybox fancybox.iframe"
                           href="https://www.youtube.com/embed/TSWur2O7uIA?rel=0&autoplay=1">
                            <img src="images/b-promo/video.png" alt="">
                            <div class="b-promo__video-content-nav">
                                <div class="b-promo__video-content-nav-play"><img src="/images/play.png" alt=""></div>
                                Смотреть подробнее о BitCoen
                            </div>
                        </a>
                        <a class="b-promo__ntv video-fancybox fancybox.iframe"
                           href="https://www.youtube.com/embed/NSZ3mfF0m44?rel=0&autoplay=1"><img src="/images/ntv.png"
                                                                                                  alt=""></a>
                                                                                                  
                                                                 <a 
                           href="https://www.1tv.ru/shows/dobroe-utro/pro-dengi/kriptovalyuta-dengi-ili-ne-dengi-dobroe-utro-fragment-vypuska-ot-25-09-2017

" target="_blank" ><img src="/images/1tv.jpg"
                                                                                                  alt=""></a>                                   
                                                                                                  
                    </div>

                    <div class="b-form b-form_pay">
                        <form class="form" method="POST" action="/pages/buy">
                            <div class="b-form__header">
                                 Pre-Token Sale: <?=__('успешно завершено')?> <br><span>собрано 150 695.25 USD</span>
                            </div>
                            <div class="b-form__content">
                                <div class="row">
                                    <div class="col col-md-4 col-xs-12">
                                        <div class="input-container b-quantity">
                                            <input class="input-text" name="coins" value="1500" max="50000" min="1500"
                                                   id="coins" required=""
                                                   type="text">
                                            <span class="b-quantity__btn b-quantity__btn_minus"></span>
                                            <span class="b-quantity__btn b-quantity__btn_plus"></span>
                                        </div>
                                      <!--  <div class="short-info">
                                            <?=__('Мин. сумма')?> 1500 BEN<br>
                                            <?=__('Макс. сумма')?> 50000 BEN
                                        </div> -->
                                    </div>
                                    <div class="col col-md-4 col-xs-12">
                                        <div class="input-container">
                                            <select class="input-text" name="currency" id="currency">
                                                <!-- <option value="USD">USD</option>
                                                <option value="EUR">EUR</option> -->
                                                <!--  <option value="рубли">рубли</option> -->
                                                <option value="Bitcoin">Bitcoin</option>
                                                <option value="Waves">Waves</option>
                                                <option value="Ethereum">Ethereum</option>
                                                <option value="Litecoin">Litecoin</option>
                                                <!--  <option value="Dash">Dash</option> -->
                                            </select>
                                        </div>
                                        <div class="short-info" id="short-info">
                                            1000 BEN (BitCoen) = 750$
                                        </div>
                                    </div>
                                    <div class="col col-md-4 col-xs-12">
                                        <?php if (!empty($currentUser)) { ?>
                                           <!-- <button class="b-btn" type="submit">Купить</button> -->
                                            <a class=" form-btn b-btn" onclick="window.location.href='/pages/preIco';" href="/pages/preIco"
                                               data-form-title="Регистрация в BitCoen"><?=__('Купить')?></a>
                                        <?php } else {
                                            ?>
                                            <a class="reg-btn form-btn b-btn" href="#form-reg"
                                               data-form-title="Регистрация в BitCoen"><?=__('Купить')?></a>
                                            <?php
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <!--    <br>
                        <?=__('Оплата возможна только с помощью криптовалюты')?>.<br>
                        <a target="_blank" href="/promo/Terms and instruction Bitcoen.pdf">Как купить криптовалюту</a> <a target="_blank" href="/promo/Terms%20and%20Conditions%20Bitcoin%20Pre-ICO%20(ENG)_final.pdf">Terms and conditions ENG</a> -->
                    </div>

              <!--          <div class="b-scale">
                        <div class="b-scale__content">
                            <div class="b-scale__content-slider" style="width: <?=((($summary['usd']/150000)*100)/4)?>%;"></div>
                            <div class="b-scale__pointer-list">
                                <div class="b-scale__pointer-list-item" style="left: 0">
                                    <div class="val">0</div>
                                </div>
                                <div class="b-scale__pointer-list-item" style="left: 25%">
                                    <div class="val">150 000$</div>
                                </div>
                                <div class="b-scale__pointer-list-item" style="left: 50%">
                                    <div class="val">5 000 000$</div>
                                </div>
                                <div class="b-scale__pointer-list-item" style="left: 75%">
                                    <div class="val">10 000 000$</div>
                                </div>
                                <div class="b-scale__pointer-list-item" style="left: 100%">
                                    <div class="val">25 000 000$</div>
                                </div>
                            </div>
                        </div>
                        <div class="b-scale__footer">
                            <div class="col">Pre Token Sale</div>
                            <div class="col"><span>Token Sale</span></div>
                            <div class="col"></div>
                        </div>

                        <div class="b-invest-list">
                            <div class="b-invest-list__item">
                                <div class="b-invest-list__item-icon"><i class="icon"><img
                                                src="images/b-invest-list/1.png" alt=""></i></div>
                                <div class="b-invest-list__item-content"><?= $summary['bitcoin'] ?> BTC</div>
                            </div>
                            <div class="b-invest-list__item">
                                <div class="b-invest-list__item-icon"><i class="icon"><img
                                                src="images/b-invest-list/2.png" alt=""></i></div>
                                <div class="b-invest-list__item-content"><?= $summary['ethereum'] ?> ETH</div>
                            </div>
                            <div class="b-invest-list__item">
                                <div class="b-invest-list__item-icon"><i class="icon"><img
                                                src="images/b-invest-list/3.png" alt=""></i></div>
                                <div class="b-invest-list__item-content"><?= $summary['litecoin'] ?> LTC</div>
                            </div>
                            <div class="b-invest-list__item">
                                <div class="b-invest-list__item-icon"><i class="icon"><img
                                                src="images/b-invest-list/dash.png" alt=""></i></div>
                                <div class="b-invest-list__item-content"><?= $summary['waves'] ?> WAVES</div>
                            </div>
                            <!-- <div class="b-invest-list__item">
                                 <div class="b-invest-list__item-icon"><i class="icon"><img
                                                 src="images/b-invest-list/4.png" alt=""></i></div>
                                 <div class="b-invest-list__item-content">0 USD</div>
                             </div>
                             <div class="b-invest-list__item">
                                 <div class="b-invest-list__item-icon"><i class="icon"><img
                                                 src="images/b-invest-list/e.png" alt=""></i></div>
                                 <div class="b-invest-list__item-content">0 EUR</div>
                             </div>
                             <div class="b-invest-list__item">
                                 <div class="b-invest-list__item-icon"><i class="icon"><img
                                                 src="images/b-invest-list/rub.png" alt=""></i></div>
                                 <div class="b-invest-list__item-content">0 RUB</div>
                             </div> -->

<!--
                        </div>
                        <div style="margin-bottom: -10px;">
                            В сумме это:
                        </div>
                        <div class="b-invest-list">
                            <div class="b-invest-list__item">
                                <div class="b-invest-list__item-icon"><i class="icon"><img
                                                src="images/b-invest-list/4.png" alt=""></i></div>
                                <div class="b-invest-list__item-content"><?= $summary['usd'] ?> USD</div>
                            </div>
                        </div>
-->
                    </div>
                </div>
            </div>
        </div> 

        <div class="b-media landing-section">
            <div class="container">
                <div class="b-media__content">
                    <h2>СМИ о BitCoen</h2>
                    <div class="b-media__list">
                        <div class="owl-carousel">
                            <div class="b-media__list-item">
                                <a class="b-info-box" href="http://www.rbc.ru/money/04/08/2017/5984465a9a79471374291dc6"
                                   target="_blank">
                                    <div class="b-info-box__icon">
                                        <i class="icon">
                                            <img src="images/b-media/1.png" alt="">
                                        </i>
                                    </div>
                                    <div class="b-info-box__content">РБК</div>
                                </a>
                            </div>
                            <div class="b-media__list-item">
                                <a class="b-info-box"
                                   href="https://www.vedomosti.ru/finance/articles/2017/08/04/728059-koshernaya-kriptovalyuta"
                                   target="_blank">
                                    <div class="b-info-box__icon">
                                        <i class="icon">
                                            <img src="images/b-media/2.png" alt="">
                                        </i>
                                    </div>
                                    <div class="b-info-box__content">Ведомости</div>
                                </a>
                            </div>
                            <div class="b-media__list-item">
                                <a class="b-info-box"
                                   href="http://incrussia.ru/news/predprinimatel-iz-rossii-zapustil-pervuyu-v-mire-koshernuyu-kriptovalyutu/"
                                   target="_blank">
                                    <div class="b-info-box__icon">
                                        <i class="icon">
                                            <img src="images/b-media/3.png" alt="">
                                        </i>
                                    </div>
                                    <div class="b-info-box__content">Inc</div>
                                </a>
                            </div>
                            <div class="b-media__list-item">
                                <a class="b-info-box"
                                   href="https://secretmag.ru/news/rossiiskii-biznesmen-zapustil-pervuyu-v-mire-koshernuyu-kriptovalyutu-04-08-2017.htm?utm_source=sffb&utm_medium=social&utm_campaign=rossiyskiy-biznesmen-zapustil-pervuyu-v-m"
                                   target="_blank">
                                    <div class="b-info-box__icon">
                                        <i class="icon">
                                            <img src="images/b-media/4.png" alt="">
                                        </i>
                                    </div>
                                    <div class="b-info-box__content">Секрет фирмы</div>
                                </a>
                            </div>
                            <div class="b-media__list-item">
                                <a class="b-info-box"
                                   href="http://www.cnews.ru/news/top/2017-08-04_v_rossii_sozdali_koshernuyu_kriptovalyutu"
                                   target="_blank">
                                    <div class="b-info-box__icon">
                                        <i class="icon">
                                            <img src="images/b-media/5.png" alt="">
                                        </i>
                                    </div>
                                    <div class="b-info-box__content">CNews</div>
                                </a>
                            </div>
                            <div class="b-media__list-item">
                                <a class="b-info-box" href="https://rb.ru/news/bitcoen/" target="_blank">
                                    <div class="b-info-box__icon">
                                        <i class="icon">
                                            <img src="images/b-media/6.png" alt="">
                                        </i>
                                    </div>
                                    <div class="b-info-box__content">RusBase</div>
                                </a>
                            </div>
                            <div class="b-media__list-item">
                                <a class="b-info-box"
                                   href="http://www.banki.ru/news/lenta/?id=9922705&r1=rss&r2=yandex.news"
                                   target="_blank">
                                    <div class="b-info-box__icon">
                                        <i class="icon">
                                            <img src="images/b-media/7.png" alt="">
                                        </i>
                                    </div>
                                    <div class="b-info-box__content">Banki</div>
                                </a>
                            </div>
                            <div class="b-media__list-item">
                                <a class="b-info-box" href="https://m.lenta.ru/news/2017/08/04/bitcoen/"
                                   target="_blank">
                                    <div class="b-info-box__icon">
                                        <i class="icon">
                                            <img src="images/b-media/8.png" alt="">
                                        </i>
                                    </div>
                                    <div class="b-info-box__content">Lenta.ru</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="section-global-info" class="b-global-info landing-section">
            <div class="container">
                <div class="b-global-info__content">
                    <h2>
                             BitCoen – первый  еврейский крипто-токен и блокчейн экосистема, которая создана
                        для еврейских общин всего мира.
                    </h2>
                    <p>
                  Эта крипто-токен и блокчейн экосистема вобрала в себя все плюсы цифрового мира и объединила их с ценностями, обычаями
                        и древними устоями в рамках еврейского закона.
                    </p>
                    <p>
                        Это уникальная возможность для вас диверсифицировать свои сбережения. <br/>
                        Даже если упадет доллар или евро, обесценится рубль, у вас всегда будет валюта, которая
                        признается внутри общин.

                    </p>

                    <div class="b-global-info__list">
                        <div class="owl-carousel">
                            <div class="b-coin-info__list-item">
                                <div class="b-info-box">
                                    <div class="b-info-box__icon"><i class="icon"><img src="images/b-global-info/1.png"
                                                                                       alt=""></i></div>
                                    <div class="b-info-box__content">
                                        Не контролируется
                                        никем
                                    </div>
                                </div>
                            </div>
                            <div class="b-coin-info__list-item">
                                <div class="b-info-box">
                                    <div class="b-info-box__icon"><i class="icon"><img src="images/b-global-info/2.png"
                                                                                       alt=""></i></div>
                                    <div class="b-info-box__content">
                                        Невозможно
                                        отключить
                                    </div>
                                </div>
                            </div>
                            <div class="b-coin-info__list-item">
                                <div class="b-info-box">
                                    <div class="b-info-box__icon"><i class="icon"><img src="images/b-global-info/3.png"
                                                                                       alt=""></i></div>
                                    <div class="b-info-box__content">
                                        Невозможно
                                        подделать
                                    </div>
                                </div>
                            </div>
                            <div class="b-coin-info__list-item">
                                <div class="b-info-box">
                                    <div class="b-info-box__icon"><i class="icon"><img src="images/b-global-info/4.png"
                                                                                       alt=""></i></div>
                                    <div class="b-info-box__content">
                                        Невозможно
                                        идентифицировать
                                    </div>
                                </div>
                            </div>
                            <div class="b-coin-info__list-item">
                                <div class="b-info-box">
                                    <div class="b-info-box__icon"><i class="icon"><img src="images/b-global-info/5.png"
                                                                                       alt=""></i></div>
                                    <div class="b-info-box__content">
                                        Соответствует
                                        еврейскому закону
                                    </div>
                                </div>
                            </div>
                            <div class="b-coin-info__list-item">
                                <div class="b-info-box">
                                    <div class="b-info-box__icon"><i class="icon"><img src="images/b-global-info/6.png"
                                                                                       alt=""></i></div>
                                    <div class="b-info-box__content">
                                        Не зависит от
                                        других блокчейнов
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="b-subscribe landing-section">
            <div class="container">
                <div class="b-form">
                    <form class="form" method="POST" action="/subscribe/subscribe.php">
                        <input name="subject" value="Подписка" type="hidden">

                        <div class="b-form__header">
                            <div class="b-form__header-title">
                              Получи уведомление о начале ICO
                            </div>
                        </div>
                        <div class="b-form__content">
                            <div class="row">
                                <div class="col col-sm-7 col-xs-12">
                                    <div class="input-container">
                                        <input class="input-text" name="email" placeholder="Ваш e-mail" required=""
                                               type="email">
                                    </div>
                                </div>
                                <div class="col col-sm-5 col-xs-12">
                                    <button class="b-btn btn-submit" type="submit">Подписаться на рассылку</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="b-about landing-section">
            <div class="container">
                <div class="b-about__content">
                    <h2>Кто такие коэны?</h2>
                    <p>
                        Евреи называют коэнами особое сословие
                        священнослужителей из рода Аарона,
                        самого первого еврейского первосвященника.
                    </p>
                    <p>
                        Согласно Пятикнижию Моисея, после помазания Аарона в первосвященники было установлено, чтобы
                        высокий сан передавался по наследству от отца к старшему сыну, все же остальные прямые потомки
                        Аарона должны были становиться священниками.
                    </p>
                </div>
            </div>
        </div>

        <div class="b-global-info landing-section">
            <div class="container">
                <div class="b-global-info__content">
                    <h2>Всего будет выпущено 100.000.000 BitCoen монет</h2>
                    <p>
                        Все монеты окажутся на рынке за 5 лет. Это позволит добиться плавного постепенного
                        проникновения криптовалюты в сообщество.
                    </p>
                </div>
            </div>
        </div>

        <div id="section-steps" class="b-steps landing-section">
            <div class="container">
                <div class="b-steps__content">
                    <h2>Этапы запуска проекта</h2>
                    <div class="b-steps__list">
                        <div class="b-steps__list-item-wrapper">
                            <div class="b-steps__list-item-connector"></div>
                            <div class="b-steps__list-item active">
                                <div class="b-steps__list-item-header">
                                    <div class="b-steps__list-item-header-title">Pre- Token Sale:  Завершено</div>
                                   Успешно собрано 150695.25 USD
                                </div>
                                <div class="b-steps__list-item-content">
                                    <div class="col">
                                        <ul class="check-list">
                                            <li>Разработка Ethereum смарт-контракта</li>
                                            <li>Юридическое структурирование</li>
                                            <li>Маркетинг проекта и ICO</li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <div class="b-counter">
                                            <div class="b-counter__title">Сбор средств pre-ICO завершен</div>
                                           <!-- <div class="b-counter__content">
                                                <div class="counter"
                                                     data-timeTo="Sun Aug 09 2017 12:00:00 GMT+0300 (Россия (лето))"></div>
                                            </div> -->
                                        </div>
                                       <!-- <a class="b-btn form-btn" href="#form-reg"
                                           data-form-title="Принять участие в Token Sale">Принять участие в Token Sale</a> -->
                                    </div>
                                    <div class="col">
                                      <!--  <div class="info-box">
                                            1 BEN / 0.75 USD
                                            <span>25% скидка</span>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="b-steps__list-item-footer">

                                    <div class="b-steps__list-item-footer-title">
                                        <b>Принимаемые валюты:</b><br>
                                        Bitcoin, Litecoin, Ethereum, Waves
                                        <br>
                                        <br>
                                    </div>

                                    <div class="b-steps__list-item-footer-title">
                                        Уже привлечено:
                                    </div>
                                    <div class="b-invest-list">
                                        <div class="b-invest-list__item">
                                            <div class="b-invest-list__item-icon"><i class="icon"><img
                                                            src="images/b-invest-list/1.png" alt=""></i></div>
                                            <div class="b-invest-list__item-content"><?= $summary['bitcoin'] ?> BTC
                                            </div>
                                        </div>
                                        <div class="b-invest-list__item">
                                            <div class="b-invest-list__item-icon"><i class="icon"><img
                                                            src="images/b-invest-list/2.png" alt=""></i></div>
                                            <div class="b-invest-list__item-content"><?= $summary['ethereum'] ?> ETH
                                            </div>
                                        </div>
                                        <div class="b-invest-list__item">
                                            <div class="b-invest-list__item-icon"><i class="icon"><img
                                                            src="images/b-invest-list/3.png" alt=""></i></div>
                                            <div class="b-invest-list__item-content"><?= $summary['litecoin'] ?> LTC
                                            </div>
                                        </div>

                                        <div class="b-invest-list__item">
                                            <div class="b-invest-list__item-icon"><i class="icon"><img
                                                            src="images/b-invest-list/dash.png" alt=""></i></div>
                                            <div class="b-invest-list__item-content"><?= $summary['waves'] ?> WAVES
                                            </div>
                                        </div>


                                   
                                    </div>
                                    <div style="margin-bottom: -10px;">
                                        В сумме это:
                                    </div>
                                    <div class="b-invest-list">
                                        <div class="b-invest-list__item">
                                            <div class="b-invest-list__item-icon"><i class="icon"><img
                                                            src="images/b-invest-list/4.png" alt=""></i></div>
                                            <div class="b-invest-list__item-content"><?= $summary['usd'] ?> USD</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                                <div class="b-steps__list-item-wrapper">
                            <div class="b-steps__list-item-connector"></div>
                            <div class="b-steps__list-item active">
                                <div class="b-steps__list-item-header">
                                    <div class="b-steps__list-item-header-title">ICO:  ноябрь 2017</div>
                                    до 25.000.000  монет + до 2 500 000 монет цдака
                                </div>
                                <div class="b-steps__list-item-content">
                                    <div class="col">
                                        <ul class="check-list">
                                            <li>Вывод токенов Bitcoen на специализированные криптовалютные биржи</li>
                                            <li>Разработка конструктора токенов и проведения ICO</li>
                                            <li>Развитие экосистемы</li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <!--   <div class="b-counter">
                                            <div class="b-counter__title">До старта ICO:</div>
                                            <div class="b-counter__content">
                                                <div class="counter"
                                                     data-timeTo="Sun Oct 9 2017 12:00:00 GMT+0300 (Россия (лето))"></div>
                                            </div>
                                        </div> -->


                                        <a class="b-btn form-btn" href="#form-reg"
                                           data-form-title="Принять участие в ICO">Принять участие в ICO</a>
                                    </div>
                                    <div class="col">
                                        <div class="info-box">
                                            1 BEN / 1 USD
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="b-steps__list-item-footer">
                                    <div class="b-steps__list-item-footer-title">
                                        Уже привлечено:
                                    </div>
                                    <div class="b-invest-list">
                                        <div class="b-invest-list__item">
                                            <div class="b-invest-list__item-icon"><i class="icon"><img
                                                            src="images/b-invest-list/1.png" alt=""></i></div>
                                            <div class="b-invest-list__item-content">0 BTC</div>
                                        </div>
                                        <div class="b-invest-list__item">
                                            <div class="b-invest-list__item-icon"><i class="icon"><img
                                                            src="images/b-invest-list/2.png" alt=""></i></div>
                                            <div class="b-invest-list__item-content">0 ETH</div>
                                        </div>
                                        <div class="b-invest-list__item">
                                            <div class="b-invest-list__item-icon"><i class="icon"><img
                                                            src="images/b-invest-list/3.png" alt=""></i></div>
                                            <div class="b-invest-list__item-content">0 LTC</div>
                                        </div>

                                        <div class="b-invest-list__item">
                                            <div class="b-invest-list__item-icon"><i class="icon"><img
                                                            src="images/b-invest-list/dash.png" alt=""></i></div>
                                            <div class="b-invest-list__item-content">0 WAVES</div>
                                        </div>
                                        <!--   <div class="b-invest-list__item">
                                               <div class="b-invest-list__item-icon"><i class="icon"><img
                                                               src="images/b-invest-list/4.png" alt=""></i></div>
                                               <div class="b-invest-list__item-content">0 USD</div>
                                           </div>
                                           <div class="b-invest-list__item">
                                               <div class="b-invest-list__item-icon"><i class="icon"><img
                                                               src="images/b-invest-list/e.png" alt=""></i></div>
                                               <div class="b-invest-list__item-content">0 EUR</div>
                                           </div>
                                           <div class="b-invest-list__item">
                                               <div class="b-invest-list__item-icon"><i class="icon"><img
                                                               src="images/b-invest-list/rub.png" alt=""></i></div>
                                               <div class="b-invest-list__item-content">0 RUB</div>
                                           </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="b-distribution landing-section">
        <div class="container">
            <div class="b-distribution__content">
                <h2>Распределение</h2>
                <h3>Начальное распределение</h3>
                <div class="b-distribution__list">
                    <div class="col">
                        <div class="b-distribution__list-item">
                            <div class="b-distribution__list-item-icon"><i class="icon"><img
                                            src="images/b-distribution/1.png" alt=""></i></div>
                            <div class="b-distribution__list-item-content">
                                10% токенов цдака
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-distribution__list-item">
                            <div class="b-distribution__list-item-icon"><i class="icon"><img
                                            src="images/b-distribution/2.png" alt=""></i></div>
                            <div class="b-distribution__list-item-content">
                                2% маркетинг в сообществе
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-distribution__list-item">
                            <div class="b-distribution__list-item-icon"><i class="icon"><img
                                            src="images/b-distribution/3.png" alt=""></i></div>
                            <div class="b-distribution__list-item-content">
                                5% совет директоров и совет шести
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-distribution__list-item">
                            <div class="b-distribution__list-item-icon"><i class="icon"><img
                                            src="images/b-distribution/4.png" alt=""></i></div>
                            <div class="b-distribution__list-item-content">
                                13% токенов - команда проекта
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-distribution__list-item">
                            <div class="b-distribution__list-item-icon"><i class="icon"><img
                                            src="images/b-distribution/5.png" alt=""></i></div>
                            <div class="b-distribution__list-item-content">
                                70% токенов идут на открытый рынок
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-distribution__list-item">
                            <div class="b-distribution__list-item-icon"><i class="icon"><img
                                            src="images/b-distribution/6.png" alt=""></i></div>
                            <div class="b-distribution__list-item-content">
                                10% создание и развитие криптобанка
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-distribution__list-item">
                            <div class="b-distribution__list-item-icon"><i class="icon"><img
                                            src="images/b-distribution/7.png" alt=""></i></div>
                            <div class="b-distribution__list-item-content">
                                20% поддержка мерчантов
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-distribution__list-item">
                            <div class="b-distribution__list-item-icon"><i class="icon"><img
                                            src="images/b-distribution/8.png" alt=""></i></div>
                            <div class="b-distribution__list-item-content">
                                40% развитие экосистемы BitCoen
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="b-feature-perspective landing-section">
        <div class="container">
            <div class="b-feature-perspective__content">
                <h2>BitCoen — будущее общины</h2>
                <div class="b-feature-perspective__list owl-carousel">
                    <div class="col col-md-6">
                        <div class="b-feature-perspective__list-item">
                            <div class="b-info-box b-info-box_horizontal">
                                <div class="b-info-box__icon"><i class="icon"><img
                                                src="images/b-feature-perspective/1.png" alt=""></i></div>
                                <div class="b-info-box__content">
                                    Все монеты окажутся на рынке за 5 лет.
                                    Это позволит добиться плавного постепенного проникновения криптовалюты в
                                    сообщество.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="b-advantages__list-item">
                            <div class="b-info-box b-info-box_horizontal">
                                <div class="b-info-box__icon"><i class="icon"><img
                                                src="images/b-feature-perspective/2.png" alt=""></i></div>
                                <div class="b-info-box__content">
                                    Мы не HYPE, мы не акции. Мы стабильный
                                    инструмент сохранения и конечной гарантии платежеспособности.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="b-advantages__list-item">
                            <div class="b-info-box b-info-box_horizontal">
                                <div class="b-info-box__icon"><i class="icon"><img
                                                src="images/b-feature-perspective/3.png" alt=""></i></div>
                                <div class="b-info-box__content">
                                   Bitcoen будут принимать кошерные рестораны, магазины, фирмы, т.д. 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="b-advantages__list-item">
                            <div class="b-info-box b-info-box_horizontal">
                                <div class="b-info-box__icon"><i class="icon"><img
                                                src="images/b-feature-perspective/4.png" alt=""></i></div>
                                <div class="b-info-box__content">
                                    BitCoen можно будет использовать в программах лояльности, кешбек сервисах и
                                    других проектах.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--
    <div class="b-advantages landing-section">
        <div class="container">
            <div class="b-advantages__content">
                <h2>Чем уникален Блокчейн BitCoen:</h2>
                <div class="b-advantages__list owl-carousel">
                    <div class="col col-md-6">
                        <div class="b-advantages__list-item">
                            <div class="b-info-box b-info-box_horizontal">
                                <div class="b-info-box__icon"><i class="icon"><img src="images/b-advantages/1.png"
                                                                                   alt=""></i></div>
                                <div class="b-info-box__content">
                                    Уникальные Тьюринг полные контракты с расширенным функционалом
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="b-advantages__list-item">
                            <div class="b-info-box b-info-box_horizontal">
                                <div class="b-info-box__icon"><i class="icon"><img src="images/b-advantages/2.png"
                                                                                   alt=""></i></div>
                                <div class="b-info-box__content">
                                    Автоматическая балансировка характеристик сети
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="b-advantages__list-item">
                            <div class="b-info-box b-info-box_horizontal">
                                <div class="b-info-box__icon"><i class="icon"><img src="images/b-advantages/3.png"
                                                                                   alt=""></i></div>
                                <div class="b-info-box__content">
                                    Неограниченный размер блока
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="b-advantages__list-item">
                            <div class="b-info-box b-info-box_horizontal">
                                <div class="b-info-box__icon"><i class="icon"><img src="images/b-advantages/4.png"
                                                                                   alt=""></i></div>
                                <div class="b-info-box__content">
                                    Не требуется полная синхронизация с сетью
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="b-advantages__list-item">
                            <div class="b-info-box b-info-box_horizontal">
                                <div class="b-info-box__icon"><i class="icon"><img src="images/b-advantages/5.png"
                                                                                   alt=""></i></div>
                                <div class="b-info-box__content">
                                    Мгновенные транзакции
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="b-advantages__list-item">
                            <div class="b-info-box b-info-box_horizontal">
                                <div class="b-info-box__icon"><i class="icon"><img src="images/b-advantages/6.png"
                                                                                   alt=""></i></div>
                                <div class="b-info-box__content">
                                    Дополнительная защита от ошибочных переводов
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="b-advantages__list-item">
                            <div class="b-info-box b-info-box_horizontal">
                                <div class="b-info-box__icon"><i class="icon"><img src="images/b-advantages/7.png"
                                                                                   alt=""></i></div>
                                <div class="b-info-box__content">
                                    Удобные номера кошельков
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="b-advantages__list-item">
                            <div class="b-info-box b-info-box_horizontal">
                                <div class="b-info-box__icon"><i class="icon"><img src="images/b-advantages/8.png"
                                                                                   alt=""></i></div>
                                <div class="b-info-box__content">
                                    Простота использования
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      -->
    <div class="b-stable-info landing-section">
        <div class="container">
            <div class="b-stable-info__content">
                <h2>Почему ценность BitCoen всегда стабильна</h2>
                <div class="b-stable-info__list">
                    <div class="owl-carousel">
                        <div class="b-stable-info__list-item">
                            <div class="b-info-box">
                                <div class="b-info-box__icon"><i class="icon"><img src="images/b-stable-info/1.png"
                                                                                   alt=""></i></div>
                                <div class="b-info-box__content">
                                    Валюта исключает
                                    спекуляции
                                </div>
                            </div>
                        </div>
                        <!-- <div class="b-stable-info__list-item">
                             <div class="b-info-box">
                                 <div class="b-info-box__icon"><i class="icon"><img src="images/b-stable-info/2.png"
                                                                                    alt=""></i></div>
                                 <div class="b-info-box__content">
                                     Цена и ценность стабильны за счет общин их признания
                                 </div>
                             </div>
                         </div> -->
                        <div class="b-stable-info__list-item">
                            <div class="b-info-box">
                                <div class="b-info-box__icon"><i class="icon"><img src="images/b-stable-info/3.png"
                                                                                   alt=""></i></div>
                                <div class="b-info-box__content">
                                    Небольшое количество токенов на рынке + их постепенная передача в комьюнити
                                </div>
                            </div>
                        </div>
                        <div class="b-stable-info__list-item">
                            <div class="b-info-box">
                                <div class="b-info-box__icon"><i class="icon"><img src="images/b-stable-info/4.png"
                                                                                   alt=""></i></div>
                                <div class="b-info-box__content">
                                    Признание и поддержка всеми общинами во всех странах мира
                                </div>
                            </div>
                        </div>
                        <div class="b-stable-info__list-item">
                            <div class="b-info-box">
                                <div class="b-info-box__icon"><i class="icon"><img src="images/b-stable-info/5.png"
                                                                                   alt=""></i></div>
                                <div class="b-info-box__content">
                                    Прием большим
                                    количеством мерчантов
                                    без необходимости вывода
                                    в реальные деньги
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="b-coin-info landing-section">
        <div class="container">
            <div class="b-coin-info__content">
                <h2>Капитализация мировых криптовалют</h2>
                <h3>BitCoen первый  еврейский крипто-токен в мире, также как BitCoin первая в мире криптовалюта</h3>
                <div class="b-coin-info__list">
                    <div class="owl-carousel">
                        <div class="b-coin-info__list-item">
                            <div class="b-info-box">
                                <div class="b-info-box__icon"><i class="icon"><img src="images/b-coin-info/1.png"
                                                                                   alt=""></i></div>
                                <div class="b-info-box__content">
                                    BitCoin
                                    <small>капитализация:</small>
                                    <?= $this->Number->currency($caps['bitcoin']['market_cap_usd'], 'USD', [
                                        'precision' => 0,
                                        'places'    => 0,
                                    ]); ?>
                                </div>
                            </div>
                        </div>
                        <div class="b-coin-info__list-item">
                            <div class="b-info-box">
                                <div class="b-info-box__icon"><i class="icon"><img src="images/b-coin-info/2.png"
                                                                                   alt=""></i></div>
                                <div class="b-info-box__content">
                                    Ethereum
                                    <small>капитализация:</small>
                                    <?= $this->Number->currency($caps['ethereum']['market_cap_usd'], 'USD'); ?>

                                </div>
                            </div>
                        </div>
                        <div class="b-coin-info__list-item">
                            <div class="b-info-box">
                                <div class="b-info-box__icon"><i class="icon"><img src="images/b-coin-info/3.png"
                                                                                   alt=""></i></div>
                                <div class="b-info-box__content">
                                    Ripple
                                    <small>капитализация:</small>
                                    <?= $this->Number->currency($caps['ripple']['market_cap_usd'], 'USD'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="b-coin-info__list-item">
                            <div class="b-info-box">
                                <div class="b-info-box__icon"><i class="icon"><img src="images/b-coin-info/4.png"
                                                                                   alt=""></i></div>
                                <div class="b-info-box__content">
                                    Litecoin
                                    <small>капитализация:</small>
                                    <?= $this->Number->currency($caps['litecoin']['market_cap_usd'], 'USD'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="b-coin-info__list-item">
                            <div class="b-info-box">
                                <div class="b-info-box__icon"><i class="icon"><img src="images/b-coin-info/5.png"
                                                                                   alt=""></i></div>
                                <div class="b-info-box__content">
                                    Ethereum Classic
                                    <small>капитализация:</small>
                                    <?= $this->Number->currency($caps['ethereum-classic']['market_cap_usd'], 'USD'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div id="section-team" class="b-team landing-section">
        <div class="container">
            <div class="b-team__content">
                <h2>Команда проекта</h2>
                <div class="b-team__list owl-carousel">
                
                           <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/3.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">David Dishko
                                
                                 <a href="https://www.linkedin.com/in/david-dyshko-b49307149/"
                                   target="_blank">
                                  
                                            <img src="images/5555.png" alt=""> </a> 
                                
                                </div>
                                <div class="b-team__list-item-content-info">VP</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                        Занимался привлечением инвестиций в частные проекты, собственная
                                            кейтеринг-компания по организации и проведению барных мероприятий.
                                            Последние несколько лет занимается девелоперскими проектами.          
                                    </p>
                                    <div class="read-more"><a href="#">Читать подробнее</a></div>
                                    <div class="text-overflow">
                                        <p>Занимался связями с общественностью в еврейском молодежном клубе , а
                                            также организацией и проведением мероприятий в еврейском клубе. </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                
                
                
                    <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/1.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Slava Semenchuk
                                
                                <a href="http://linkedin.com/in/viacheslav"
                                   target="_blank"> <img src="images/5555.png" alt=""> </a> 
                                
                                </div>
                                <div class="b-team__list-item-content-info">СЕO</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                        Серийный предприниматель. Создатель более 30 стартапов.
                                        Резидент Бюро-спикеров Игоря Манна. Специалист №1 по запуску и оптимизации
                                        бизнесов и созданию людей брендов в России и СНГ. 15 летний опыт создания
                                        it-проектов.
                                    </p>
                                    <div class="read-more"><a href="#">Читать подробнее</a></div>
                                    <div class="text-overflow">
                                        <p>Последние 5 лет занимается фин.тех проектами.</p>
                                        <p>
                                            Позже основал сервис Life-pay.ru – лидера российского рынка mpos. 23500
                                            компаний клиентов за 3 года (2,5 миллиарда оборота в 2015 году). <br>
                                            Лучший Молодой предприниматель 2014 года по версии EY. Финалиcт и
                                            победитель GSEA 2013, премия рунета 2013, Лучшая телеком идея МТС (2012)
                                            , MBA Московской школы управления Сколково.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                     <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                    <div class="img"><img src="images/b-team/6.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Julia Zhuravleva
                                
                       <a href="https://www.linkedin.com/in/yulia-zhuravleva-34b50695/"
                                   target="_blank">
                                  
                                            <img src="images/5555.png" alt=""> </a>         
                                </div>
                                <div class="b-team__list-item-content-info">Юрист</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                 Консультант юридической компании «Лемчик, Крупский и Партнеры. Структурный и налоговый консалтинг».
                                       
                                    </p>
                                    <div class="read-more"><a href="#">Читать подробнее</a></div>
                                    <div class="text-overflow">
                                        <p>Специалист в области структурирования и налогового планирования международного бизнеса. </p>
                                        <p>
                                            Реализованы проекты во многих странах Европы и Азии: Сингапуре, Швейцарии, Англии, Франции и многих других.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    
         
                    
                     <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/5.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Александр Викторов
                                
                                        <a href="https://www.linkedin.com/in/aleksander-viktorov-07897714a/"
                                   target="_blank">
                                  
                                            <img src="images/5555.png" alt=""> </a> 
                                
                                </div>
                                <div class="b-team__list-item-content-info">CBDO</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                        Директор по развитию в zion1.ru, Предприниматель. Тренер рукопашного боя,
                                        инструктор ножевого боя.
                                    </p>
                                    <p>
                                        Соавтор методики ускоренного обучения прикладного рукопашного боя для
                                        спецслужб.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                 
                     <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/15.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Mike Terentev
                                
                                <a href="https://www.linkedin.com/in/mtrntv/"
                                   target="_blank">
                                  
                                            <img src="images/5555.png" alt=""> </a> 
                                
                                </div>
                                <div class="b-team__list-item-content-info">Email Marketing Expert</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                       Founder/CEO Mailfit  
                                    </p>
                                    <p>
                                                 MailFit.com is an online app where you can create an email template without coding and Photoshop. Also you can test it in popular email clients and export to the popular business platforms, such as CRM, ESP, CMS.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                 
                 
                      <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/13.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Alexey Savchenko
                                
                                <a href="https://www.linkedin.com/in/aleksey-savchenko"
                                   target="_blank">
                                  
                                            <img src="images/5555.png" alt=""> </a>
                                
                                </div>
                                <div class="b-team__list-item-content-info">WEB-developer</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                          Основатель веб-студии Hawk Style Design.        
                                    </p>
                                    <p>
                                       С 2010 года занимается разработкой сайтов, а также комплексной упаковкой бизнесов.
<br>
За 7 лет разработано более 260 сайтов, среди которых такие клиенты как: Lego, Amway, 3M и другие.
<br>
Оформил более 400 групп в социальных сетях Вконтакте и Facebook, а также более 15 презентаций для компаний.                                      </p>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                  
                    
                        <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/10.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Dima Gorozhalkin
                                
                                 <a href="https://www.linkedin.com/in/dmitriy-gorozhankin-94657222/"
                                   target="_blank">
                                  
                                            <img src="images/5555.png" alt=""> </a> 
                                
                                </div>
                                <div class="b-team__list-item-content-info">Операционный директор</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                         Коммерческий директор Европейский медицинский центр
                                    </p>
                                    <p>
EMC
Начальник управления по работе с физическими лицами, партнерами и юридическими лицами, ЗАО Группа компаний «Медси»                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/21.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Игорь Терехов
                                
    
                                
                                </div>
                                <div class="b-team__list-item-content-info">Aplica</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                   CEO Aplika
                                    </p>
                                    <p>
                                  Продуктовый менеджер с фокусом на разработке мобильных приложений. В его портфолио десятки реализованных проектов для крупнейших брендов и стартапов и собственные проекты с наградами Red Dot, Creativity Awards, публикациями в The Next Web, Adweek, A.V.Club, Forbes.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                              <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/22.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Yury Chizh
                                

                                
                                </div>
                                <div class="b-team__list-item-content-info">PM</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                       ex Amediateka
                                    </p>
                                    <p>
                                        Ex. Akado
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>      
                    
                    
                  
                  
                <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/8.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Tania Roik
                                
                                 <a href="https://www.linkedin.com/in/tatianaroik"
                                   target="_blank">
                                  
                                            <img src="images/5555.png" alt=""> </a> 
                                
                                </div>
                                <div class="b-team__list-item-content-info">PR Director</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                       Founder в Lotus Communications
                                    </p>
                                    <p>
                                        Работала Head of Marketing & Communications в компании «Ekonomika+»  
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>      
                  
     
         <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/12.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Alex Ovcharenko
                                
                             <a href="https://www.linkedin.com/in/александр-овчаренко-99573785/"
                                   target="_blank">
                                  
                                            <img src="images/5555.png" alt=""> </a> 
                                
                                </div>
                                <div class="b-team__list-item-content-info">Директор партнерской сети</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                   Sales Manager Life-pay
                                    </p>
                                    <p>
                                   Успешное развитие партнерских сетей зарубежных проектов.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                             <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/16.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Alex Martynenko
                                
                             <a href="https://www.linkedin.com/in/aleksmart/"
                                   target="_blank">
                                  
                                            <img src="images/5555.png" alt=""> </a> 
                                
                                </div>
                                <div class="b-team__list-item-content-info">Mobile technologies entrepreneur.</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                   CEO Aplika
                                    </p>
                                    <p>
                                  Успешная разработка мобильных решений для крупнейших мировых берндов
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                                   
                    
                        <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/2.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Mila Kretova
                                
                                <a href="https://www.linkedin.com/in/mila-kretova-5a39b114/"
                                   target="_blank">
                                  
                                            <img src="images/5555.png" alt=""> </a> 
                                
                                </div>
                                <div class="b-team__list-item-content-info">Редактор-консультант</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                            Редактор Журнала компания
                                    </p>
                                    <p>
                                        Автор более 10 White Paper
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                        <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/11.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Andrew Kareev</div>
                                <div class="b-team__list-item-content-info">GR</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                              Владелец компании «Интерторг».
                                    </p>
                                    <p>
                                        Человек, который умеет договариватся с каждым и имеет ключи от всех дверей. 

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                

                </div>
            </div>
        </div>
    </div>
    
    
        <div id="section-team" class="b-team landing-section">
        <div class="container">
            <div class="b-team__content">
                <h2>Эдвайзеры проекта</h2>
                <div class="b-team__list owl-carousel">
                
                   <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/20.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Dmitry Marinichev
                                
  
                                </div>
                                
                                                      
                                <div class="b-team__list-item-content-info">Интернет-омбудсмен, член экспертного совета «Агентства стратегических инициатив» и генерального совета «Деловой России».</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                       Основатель Russian Miner Coin (rmc.one)          </p>
                                    <p>
                              Президент Radius Group
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>   

                
                
                
                    
                     <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/19.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Sergej Tschernjawskij
                                
  
                                </div>
                                
                                                      
                                <div class="b-team__list-item-content-info">Вице председатель центрального правительсвенного комитета ХСС Баварии по миграции и интеграции</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                       первый секретарь обкома по миграции и интеграции Аугсбурга                             </p>
                                    <p>
                              член правления обл. комитетов по политике внешней безопасности и здравоохранения
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>   
  
                    
                    
                    
                    
                                       <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/7.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Alex Lemchik
                                
                              <a href="https://www.linkedin.com/in/лемчик-александр-83583337/"
                                   target="_blank">
                                  
                                            <img src="images/5555.png" alt=""> </a>
  
                                
                                </div>
                                
                                                      
                                <div class="b-team__list-item-content-info">Лемчик, Крупский и Партнеры</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                       Управляющий партнер юридической компании «Лемчик, Крупский и Партнеры. Структурный и налоговый консалтинг».                                    </p>
                                    <p>
                                   Один из лучших налоговых консультантов России согласно рейтингу Коммерсантъ., более 15 лет опыта в области структурирования бизнеса.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>  
                    
                    
                            

             <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                <div class="img"><img src="images/b-team/14.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Nailia Zamashkina
                                 <a href="https://ru.linkedin.com/in/nailyazamashkina"
                                   target="_blank">
                                  
                                            <img src="images/5555.png" alt=""> </a>
                                
                                </div>
                                <div class="b-team__list-item-content-info">Fintech Lab</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                      Операционный директор межбанковского акселератора Финтех Лаб                                 </p>
                                    <div class="read-more"><a href="#">Читать подробнее</a></div>
                                    <div class="text-overflow">
                                        <p>В Яндекс.Деньгах
занималась развитием партнерского отдела и маркетинговых коммуникаций, в
Деньгах@Mail.Ru развивала партнерские отношения и открыла проект «Карта
Денег@Mail.Ru @Mastercard», в МОБИ.Деньгах запустила «с нуля» направление интернет-
эквайринга, запускала «Автоплатеж Теле2», пополнение карты «Тройка» и другие.
</p>
                                        <p>
                                           Текущая деятельность:
- Операционный директор межбанковского акселератора Финтех Лаб
- Трекер заочного акселератора ФРИИ
- партнер в Сервисе аренды Look100.ru
- партнер в Маркетинговом бюро «МЁД»
Проекты с компаниями:
Rentmania.org, Аэроэкспресс, Concert.ru, ФОНБЕТ, ABBYY Language Services, AGIOTAGE
Fashion Market.
Профессиональные компетенции:
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
         
                    
                                      <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/17.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Andrey Shmergelskiy
                                
                              <a href="https://www.linkedin.com/in/andrey-shmergelskiy-8a738097/"
                                   target="_blank">
                                  
                                            <img src="images/5555.png" alt=""> </a>
  
                                
                                </div>
                                
                                                      
                                <div class="b-team__list-item-content-info">Chief Executive Officer – Mercedes-Benz Art-Motors Ltd</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                      MSc Finance and Banking                             </p>
                                   
                                </div>
                            </div>
                        </div>
                    </div>   
                    
                    
                                   <div class="col col-lg-6 col-xs-12">
                        <div class="b-team__list-item">
                            <div class="b-team__list-item-img">
                                <div class="img"><img src="images/b-team/18.png" alt=""></div>
                            </div>
                            <div class="b-team__list-item-content">
                                <div class="b-team__list-item-content-title">Dmitry Gafin
                                
                              <a href="https://www.linkedin.com/in/dmitry-gafin-7702b621/"
                                   target="_blank">
                                  
                                            <img src="images/5555.png" alt=""> </a>
  
                                
                                </div>
                                
                                                      
                                <div class="b-team__list-item-content-info">Deputy Director General at Pyrotechnic Technologies</div>
                                <div class="b-team__list-item-content-text read-more-container">
                                    <p>
                                       Ex. VP Deutsche Bank                              </p>
                                    <p>
                              First onshore private wealth management by a foreign bank in Russia
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>   
                    
                    
                    
                    
                    
               </div>
            </div>
        </div>
    </div>
    
    
    
    
    
    

    <div class="b-security-info landing-section">
        <div class="container">
            <div class="b-security-info__content">
                <div class="row">
                    <div class="col col-md-6 col-xs-12">
                        <div class="b-security-info__list owl-carousel">
                            <div class="b-info-box b-info-box_horizontal">
                                <div class="b-info-box__icon"><i class="icon"><img
                                                src="images/b-security-info/1.png" alt=""></i></div>
                                <div class="b-info-box__content">
                                     В рамках проекта создан совет директоров 
                                </div>
                            </div>
                            <div class="b-info-box b-info-box_horizontal">
                                <div class="b-info-box__icon"><i class="icon"><img
                                                src="images/b-security-info/2.png" alt=""></i></div>
                                <div class="b-info-box__content">
                                    Члены совета директоров помогают основателям проекта развивать Bitcoen в правильном направлении. 
                                </div>
                            </div>
                            <div class="b-info-box b-info-box_horizontal">
                                <div class="b-info-box__icon"><i class="icon"><img
                                                src="images/b-security-info/3.png" alt=""></i></div>
                                <div class="b-info-box__content">
                                      Совет директоров это топовые люди: общины, технологий, искусства
                                    и политики, финансов и безопасности.
                                </div>
                            </div>
                            <div class="b-info-box b-info-box_horizontal">
                                <div class="b-info-box__icon"><i class="icon"><img
                                                src="images/b-security-info/4.png" alt=""></i></div>
                                <div class="b-info-box__content">
                                    Все крупные решения должны быть согласованы с советом директоров
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6 col-xs-12">
                        <div class="b-security-info__star">
                            <img src="images/b-security-info/star.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="b-map landing-section">
        <div class="container">
            <div class="b-map__content">
                <h2>
                  Карта общин,  на которые нацелен проект
                    BitCoen в момент запуска
                </h2>
                <div class="b-map__map">
                    <img src="images/b-map/map.png" alt="">
                </div>
              <!--    <div class="b-map__info">
                    <div class="b-map__info-item">
                        <span class="b-map__info-item-point"></span>
                        Община
                    </div>
                    <div class="b-map__info-item">
                        <span class="b-map__info-item-point b-map__info-item-point_coen"></span>
                        Община поддерживает BitCoen
                    </div>
                </div> -->
                <div class="b-map__btn">
                    <a class="b-btn form-btn" href="#form-community">Наша община готова поддержать BitCoen</a>
                </div>
            </div> 
        </div>
    </div>



    <div id="section-projects" class="b-projects landing-section">
        <div class="container">
            <div class="b-projects__content">
                <h2>Наши проекты</h2>
                <div class="b-projects__list owl-carousel">
                    <div class="col">
                        <div class="b-projects__list-item "> <!-- active -->
                            <div class="b-projects__list-item-icon">
                                <img src="images/b-projects/1.png" alt="">
                            </div>
                            <div class="b-projects__list-item-content">
                                <div class="b-projects__list-item-content-title">Кошелек</div>
                                В работе
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-projects__list-item">
                            <div class="b-projects__list-item-icon">
                                <img src="images/b-projects/2.png" alt="">
                            </div>
                            <div class="b-projects__list-item-content">
                                <div class="b-projects__list-item-content-title">Мобильный кошелек</div>
                                В работе
                            </div>
                            <div class="b-projects__list-item-content-hidden">
                                Проект в разработке
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-projects__list-item">
                            <div class="b-projects__list-item-icon">
                                <img src="images/b-projects/3.png" alt="">
                            </div>
                            <div class="b-projects__list-item-content">
                                <div class="b-projects__list-item-content-title">Биржа</div>
                                В работе
                            </div>
                            <div class="b-projects__list-item-content-hidden">
                                Проект в разработке
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-projects__list-item">
                            <div class="b-projects__list-item-icon">
                                <img src="images/b-projects/4.png" alt="">
                            </div>
                            <div class="b-projects__list-item-content">
                                <div class="b-projects__list-item-content-title">Криптобанк</div>
                                В работе
                            </div>
                            <div class="b-projects__list-item-content-hidden">
                                Проект в разработке
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-projects__list-item">
                            <div class="b-projects__list-item-icon">
                                <img src="images/b-projects/5.png" alt="">
                            </div>
                            <div class="b-projects__list-item-content">
                                <div class="b-projects__list-item-content-title">Криптофонд</div>
                                В работе
                            </div>
                            <div class="b-projects__list-item-content-hidden">
                                Проект в разработке
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-projects__list-item">
                            <div class="b-projects__list-item-icon">
                                <img src="images/b-projects/6.png" alt="">
                            </div>
                            <div class="b-projects__list-item-content">
                                <div class="b-projects__list-item-content-title">Конструктор проведения ICO</div>
                                В работе
                            </div>
                            <div class="b-projects__list-item-content-hidden">
                                Проект в разработке
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-projects__list-item">
                            <div class="b-projects__list-item-icon">
                                <img src="images/b-projects/7.png" alt="">
                            </div>
                            <div class="b-projects__list-item-content">
                                <div class="b-projects__list-item-content-title">Крипто ТВ</div>
                                В работе
                            </div>
                            <div class="b-projects__list-item-content-hidden">
                                Проект в разработке
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-projects__list-item">
                            <div class="b-projects__list-item-icon">
                                <img src="images/b-projects/8.png" alt="">
                            </div>
                            <div class="b-projects__list-item-content">
                                <div class="b-projects__list-item-content-title">Блокчейн лояльность</div>
                                В работе
                            </div>
                            <div class="b-projects__list-item-content-hidden">
                                Проект в разработке
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-projects__list-item">
                            <div class="b-projects__list-item-icon">
                                <img src="images/b-projects/9.png" alt="">
                            </div>
                            <div class="b-projects__list-item-content">
                                <div class="b-projects__list-item-content-title">Блокчейн Кешбек</div>
                                В работе
                            </div>
                            <div class="b-projects__list-item-content-hidden">
                                Проект в разработке
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-projects__list-item">
                            <div class="b-projects__list-item-icon">
                                <img src="images/b-projects/10.png" alt="">
                            </div>
                            <div class="b-projects__list-item-content">
                                <div class="b-projects__list-item-content-title">Blockchain Акселератор проектов
                                </div>
                                В работе
                            </div>
                            <div class="b-projects__list-item-content-hidden">
                                Проект в разработке
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-projects__list-item">
                            <div class="b-projects__list-item-icon">
                                <img src="images/b-projects/11.png" alt="">
                            </div>
                            <div class="b-projects__list-item-content">
                                <div class="b-projects__list-item-content-title">Свой блокчейн-крипто университет
                                </div>
                                В работе
                            </div>
                            <div class="b-projects__list-item-content-hidden">
                                Проект в разработке
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-projects__list-item">
                            <div class="b-projects__list-item-icon">
                                <img src="images/b-projects/12.png" alt="">
                            </div>
                            <div class="b-projects__list-item-content">
                                <div class="b-projects__list-item-content-title">Информационный портал</div>
                                В работе
                            </div>
                            <div class="b-projects__list-item-content-hidden">
                                Проект в разработке
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-projects__list-item">
                            <div class="b-projects__list-item-icon">
                                <img src="images/b-projects/13.png" alt="">
                            </div>
                            <div class="b-projects__list-item-content">
                                <div class="b-projects__list-item-content-title">Система приема оплаты он-лайн</div>
                                В работе
                            </div>
                            <div class="b-projects__list-item-content-hidden">
                                Проект в разработке
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-projects__list-item">
                            <div class="b-projects__list-item-icon">
                                <img src="images/b-projects/14.png" alt="">
                            </div>
                            <div class="b-projects__list-item-content">
                                <div class="b-projects__list-item-content-title">Офлайн терминалы приема платежей
                                    BitCoen
                                </div>
                                В работе
                            </div>
                            <div class="b-projects__list-item-content-hidden">
                                Проект в разработке
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="b-projects__list-item">
                            <div class="b-projects__list-item-icon">
                                <img src="images/b-projects/15.png" alt="">
                            </div>
                            <div class="b-projects__list-item-content">
                                <div class="b-projects__list-item-content-title">Крупная блокчейн конференция +
                                    выставка проектов
                                </div>
                                В работе
                            </div>
                            <div class="b-projects__list-item-content-hidden">
                                Проект в разработке
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="b-contacts landing-section">
        <div class="container">
            <div class="b-contacts__content">
                <h2>Контакты</h2>
                <div class="b-contacts__list">
                    <div class="col col-md-2 col-sm-4 col-xs-6">
                    <!--    <a class="b-info-box" href="tel:+74994505524" target="_blank">
                            <div class="b-info-box__icon"><i class="icon"><img src="images/b-contacts/1.png" alt=""></i>
                            </div>
                            <div class="b-info-box__content">+ 7 (499) 450-55-24</div>
                        </a>  -->
                    </div>
                    <div class="col col-md-2 col-sm-4 col-xs-6">
                        <a class="b-info-box" href="mailto:sales@bitcoen.co.il">
                            <div class="b-info-box__icon"><i class="icon"><img src="images/b-contacts/2.png" alt=""></i>
                            </div>
                            <div class="b-info-box__content">sales@bitcoen.co.il</div>
                        </a>
                    </div>
                    <div class="col col-md-2 col-sm-4 col-xs-6">
                        <a class="b-info-box" href="https://telegram.me/Bit_coen" target="_blank">
                            <div class="b-info-box__icon"><i class="icon"><img src="images/b-contacts/4.png" alt=""></i>
                            </div>
                            <div class="b-info-box__content">/Bit_coen</div>
                        </a>
                    </div>
                    <div class="col col-md-2 col-sm-4 col-xs-6">
                        <a class="b-info-box" href="https://www.facebook.com/bitcoen" target="_blank">
                            <div class="b-info-box__icon"><i class="icon"><img src="images/b-contacts/3.png" alt=""></i>
                            </div>
                            <div class="b-info-box__content">/bitcoen</div>
                        </a>
                    </div>
                                        <div class="col col-md-2 col-sm-4 col-xs-6">
                        <a class="b-info-box" href="https://medium.com/@bitcoen" target="_blank">
                            <div class="b-info-box__icon"><i class="icon"><img src="images/b-contacts/6.png" alt=""></i>
                            </div>
                            <div class="b-info-box__content">Medium</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="b-subscribe landing-section">
        <div class="container">
            <div class="b-form">
                <form class="form" method="POST" action="/subscribe/subscribe.php">
                    <input name="subject" value="Подписка" type="hidden">

                    <div class="b-form__header">
                        <div class="b-form__header-title">
                            Получи уведомление о начале ICO
                        </div>
                    </div>
                    <div class="b-form__content">
                        <div class="row">
                            <div class="col col-sm-7 col-xs-12">
                                <div class="input-container">
                                    <input class="input-text" name="email" placeholder="Ваш e-mail" required=""
                                           type="email">
                                </div>
                            </div>
                            <div class="col col-sm-5 col-xs-12">
                                <button class="b-btn btn-submit" type="submit">Подписаться на рассылку</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- //main -->

<!-- footer -->
<footer id="footer">
    <div class="container">
        <div class="footer-content">
            <div class="b-logo">
                <a href="/">
                    <div class="b-logo__img">
                        <img src="images/logo.png" alt="">
                    </div>
                </a>
            </div>

            <div id="google_translate_element"></div>
            <script type="text/javascript">
                function googleTranslateElementInit() {
                    new google.translate.TranslateElement({
                        pageLanguage: 'ru',
                        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                    }, 'google_translate_element');
                }
            </script>
            <script type="text/javascript"
                    src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>


        </div>
    </div>
</footer><!-- //site-footer -->
</div>
<!-- //container -->


<!-- Modal -->
<div class="modal fade modal-skin" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        <div class="modal-content">

        </div>
    </div>
</div>


<div id="thanks" class="b-modal">
    <div class="b-modal__header">
        Ваш запрос отправлен, <br/>
        мы свяжемся в ближайшее время.
    </div>
</div>

<div id="projects-modal" class="b-modal">

</div>

<div class="b-modal-form" id="form-reg">
    <div class="b-form">
        <form class="form" method="POST" action="/pages/register">
            <input name="subject" value="Регистрация в BitCoen" type="hidden">

            <div class="b-form__header">
                <div class="b-form__header-title">
                   <?=__('Регистрация в BitCoen')?>
                </div>
            </div>
            <div class="b-form__content">
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="input-container">
                            <input class="input-text" name="email" placeholder="* Email" required type="email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="input-container">
                            <input class="input-text" name="phone" placeholder="* Номер телефона / Phone" required type="text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="input-container">
                            <input class="input-text" name="password" placeholder="* Пароль / Password" required type="password">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="input-container">
                            <input class="input-text" name="passwordRepeat" placeholder="* Повторите пароль / Repeat password" required
                                   type="password">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="input-container">
                            <input type="checkbox" id="acceptallrulesandsoulsale" required="required">
                            <label for="acceptallrulesandsoulsale">Не являюсь гражданином США / I'm not a US citizen</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12">
                        <button class="b-btn" type="submit"> <?=__('Зарегистрироваться / Signup')?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="b-modal-form" id="form-login">
    <div class="b-form">
        <form class="form" method="POST" action="/app/login">
            <div class="b-form__header">
                <div class="b-form__header-title">
                    <?=__('Личный кабинет')?>
                </div>
            </div>
            <div class="b-form__content">
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="input-container">
                            <input class="input-text" name="email" placeholder="Ваш e-mail" required type="login">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="input-container">
                            <input class="input-text" name="password" placeholder="Ваш пароль" required type="password">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12">
                        <button class="b-btn" type="submit"><?=__('Войти')?></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="restore-btn">
                           <!-- <a href="#">Восстановить пароль</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="b-modal-form" id="form-community">
    <div class="b-form">
        <form class="form" method="POST" action="/pages/feedback">
            <input name="subject" value="Община" type="hidden">

            <div class="b-form__header">
                <div class="b-form__header-title">
                    Наша община готова поддержать BitCoen
                </div>
            </div>
            <div class="b-form__content">
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="input-container">
                            <input class="input-text" name="name" placeholder="* ФИО" required type="text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="input-container">
                            <input class="input-text" name="phone" placeholder="* Номер телефона" required type="text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="input-container">
                            <input class="input-text" name="email" placeholder="* Ваш e-mail" required type="email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="input-container">
                            <input class="input-text" name="community" placeholder="* Община" required type="text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="input-container">
                            <textarea class="input-text" name="message" placeholder="Сообщение"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12">
                        <button class="b-btn" type="submit">Отправить запрос</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    var course = {
        'USD': 0.75,
        'EUR': 0.64,
        'RUB': 45.5,
        'Bitcoin': <?=is_finite($benbtc)?floatval($benbtc):0.00022245?>,
        'Ethereum': <?=is_finite($benetc)?floatval($benetc):0.00257406?>,
        'Litecoin': <?=is_finite($benltc)?floatval($benltc):0.01532739?>,
        'Dash': 0.00409253,
        'Waves': <?=is_finite($benwaves)!=0?floatval($benwaves):0.14531561?>
    };
</script>


<script src="/js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/js/fancyBox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
<script src="/js/fancyBox/source/helpers/jquery.fancybox-buttons.js" type="text/javascript"></script>
<script src="/js/fancyBox/source/helpers/jquery.fancybox-media.js" type="text/javascript"></script>
<script src="/js/jquery.maskedinput.min.js" type="text/javascript"></script>
<script src="/js/owl.carousel/owl.carousel.min.js" type="text/javascript"></script>
<script src="/js/timeTo/jquery.time-to.js" type="text/javascript"></script>
<script src="/js/main.js?_=<?= rand() ?>" type="text/javascript"></script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter45509076 = new Ya.Metrika({
                    id: 45509076,
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
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if(w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/45509076" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>
<!-- /Yandex.Metrika counter -->

<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', '.btn-submit', function (e) {
            e.preventDefault();
            var form = $(this).parents('form');

            var proceed = true;

            //simple input validation
            $(form.find("input[required], textarea[required]")).each(function () {
                if(!$.trim($(this).val())) { //if this field is empty
                    $(this).addClass('error');
                    proceed = false; //set do not proceed flag
                } else {
                    $(this).removeClass('error');
                }
            });

            //if everything's ok, continue with Ajax form submit
            if(proceed) {
                var form_data = new FormData(form[0]); //Creates new FormData object

                $.ajax({ //ajax form submit
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form_data,
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function () {
                        $.fancybox($('#thanks'), {
                            padding: 0,
                            maxHeight: '90%'
                        });
                    }
                });
            }
        });

        $('body').on('click', '.form-btn', function (e) {
            e.preventDefault();
            var that = $(this);
            var href = $(this).attr('href');
            var form = $(href);
            var formTitle = that.attr('data-form-title');

            form.trigger('reset');
            $('input', form).val('');

            if(formTitle) {
                $('input[name="subject"]').val(formTitle);
            }

            $.fancybox(href, {
                padding: 0,
                maxHeight: '90%'
            });
        });
    });
</script>


<!-- BEGIN JIVOSITE CODE -->
<script type='text/javascript'>
    (function () {
        var widget_id = 'Jh3iVLT7Dl';
        var d = document;
        var w = window;

        function l() {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = '//code.jivosite.com/script/widget/' + widget_id;
            var ss = document.getElementsByTagName('script')[0];
            ss.parentNode.insertBefore(s, ss);
        }

        if(d.readyState == 'complete') {
            l();
        } else {
            if(w.attachEvent) {
                w.attachEvent('onload', l);
            } else {
                w.addEventListener('load', l, false);
            }
        }
    })();
</script>
<!-- END JIVOSITE CODE -->

</body>
</html>