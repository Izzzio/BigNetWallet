<?php
/**
 * @var array $currentStatistics
 * @var bool $canViewIncome
 * @var \App\View\AppView $this
 * @var object $financeAims
 * @var array $responseInfo
 * @var int $questionsNumber
 * @var array $ticks
 * @var array $likeForLikeGraphs
 */
?>
<div class="col" style="margin-top: 16.3vh; margin-bottom: 15vh; text-align: center">
    <div style="box-shadow: 0px 0px 20px 6px rgba(26, 126, 173, 0.6); padding-top: 50px">
        <h3>Вы можете оставить заявку на покупку BitCoen прямо сейчас.<br>Сумма будет зарезервирована за вами до момента
            выкупа.</h3>


        <div class="b-counter">
            <div class="b-counter__title">До старта Pre-ICO:</div>
            <div class="b-counter__content">
                <div class="counter timeTo timeTo-white"
                     data-timeto="Sun Aug 09 2017 12:00:00 GMT+0300 (Россия (лето))">
                    <figure style="">
                        <div class="first" style="">
                            <ul style="left:3px; top:-30px">
                                <li>0</li>
                                <li>0</li>
                            </ul>
                        </div>
                        <div style="">
                            <ul style="left:3px; top:-30px">
                                <li>4</li>
                                <li>4</li>
                            </ul>
                        </div>
                        <figcaption>дней</figcaption>
                    </figure>
                    <figure style="">
                        <div class="first" style="">
                            <ul style="left:3px; top:-30px">
                                <li>1</li>
                                <li>1</li>
                            </ul>
                        </div>
                        <div style="">
                            <ul style="left:3px; top:-30px">
                                <li>1</li>
                                <li>1</li>
                            </ul>
                        </div>
                        <figcaption style="">часов</figcaption>
                    </figure>
                    <span>:</span>
                    <figure style="">
                        <div class="first" style="">
                            <ul style="left:3px; top:-30px">
                                <li>4</li>
                                <li>4</li>
                            </ul>
                        </div>
                        <div style="">
                            <ul style="left: 3px; top: -30px;" class="">
                                <li>0</li>
                                <li>0</li>
                            </ul>
                        </div>
                        <figcaption style="">минут</figcaption>
                    </figure>
                    <span>:</span>
                    <figure style="">
                        <div class="first" style="">
                            <ul style="left: 3px; top: -30px;" class="">
                                <li>3</li>
                                <li>3</li>
                            </ul>
                        </div>
                        <div style="">
                            <ul style="left: 3px; top: 0px;" class="transition">
                                <li>1</li>
                                <li>2</li>
                            </ul>
                        </div>
                        <figcaption style="">секунд</figcaption>
                    </figure>
                </div>
            </div>
        </div>


        <div class="b-form b-form_pay" style="">
            <form class="form" method="POST" action="/pages/buy">
                <div class="b-form__content">
                    <div class="row">
                        <div class="col col-md-4 col-xs-12">
                            <div class="input-container b-quantity">
                                <input class="input-text" name="coins" value="1000" min="100" max="50000" required="" id="coins" type="text">
                                <span class="b-quantity__btn b-quantity__btn_minus"></span>
                                <span class="b-quantity__btn b-quantity__btn_plus"></span>
                            </div>

                            <div class="short-info">
                                Мин. сумма 100 BEN<br>
                                Макс. сумма 50000 BEN
                            </div>

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
                            <div class="short-info" id="short-info">>
                                Выберите валюту
                            </div>
                        </div>
                        <div class="col col-md-4 col-xs-12">
                            <button class="b-btn" type="submit">Купить</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

