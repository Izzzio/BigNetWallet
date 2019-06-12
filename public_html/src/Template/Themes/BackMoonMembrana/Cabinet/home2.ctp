<div class="content">
    <div class="wrap">
        <div class="row main-page">
            <div id="main-container" class="col-lg-8 col-sm-8 col-xs-12 shift-top">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h2>Welcome to your <?= \App\Lib\Misc::projectName() ?> Crowdsale account!</h2>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                        voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                        non proident, sunt in culpa qui officia deserunt mollit anim id est laborum

                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="step">Step 1</div>
                        <h2><?= \App\Lib\Misc::tokenName() ?> tokens</h2>
                        <p>You are able to buy <?= \App\Lib\Misc::tokenName() ?> tokens using BTC, BCH, ETH, ETC, LTC,
                            DASH, USDT, XRP, Visa, Mastercard or USD (wire transfer for any amount over $50).</p>
                        <p>The calculator is provided for your convenience. You can enter a number
                            of <?= \App\Lib\Misc::tokenName() ?> Tokens you want to buy and calculate the amount you
                            would need to have in your account wallets.</p>
                        <p>Please note that transfer of funds to your account wallets does not constitute a purchase of
                            the <?= \App\Lib\Misc::tokenName() ?> tokens. After the funds are deposited, you’ll need to
                            complete Step 3 to purchase the required number of <?= \App\Lib\Misc::tokenName() ?> tokens
                            with the deposited funds.</p>
                        <p>If you want to purchase <?= \App\Lib\Misc::tokenName() ?> tokens with any currency other than
                            BTC, please note that the price of <?= \App\Lib\Misc::tokenName() ?> tokens would be
                            calculated at the time of actual purchase of the <?= \App\Lib\Misc::tokenName() ?> tokens
                            and not at the time of transfer of the funds to your account wallets.</p>
                        <br>
                        <!--calculator-->
                        <div class="calculator">
                            <div class="left">
                                <div class="form-group">
                                    <input id="coin-amount" type="text" class="form-control" value="1">
                                    <label><?= \App\Lib\Misc::tokenName() ?></label>
                                </div>
                                <a href="javascript:void(0)" class="direction" data-direction="right"><i
                                            class="fa fa-arrow-right" aria-hidden="true"></i></a>
                            </div>
                            <div class="right">
                                <div class="form-group is-empty">
                                    <input type="text" id="coin-price" class="form-control" value="" disabled="">


                                    <!-- <div class="list-currency">
                                         <a data-code="BTC" id="calculator-currency-btn" href="javascript:void(0)"
                                            class="btn btn-raised btn-select current-currency list-currency-icon">
           <span>
             <img class="currency-select-bg"
                  src="https://tokensale.crypterium.io/assets/currency-icons/BTC-07fdedf3e3359c6fc51a80b1af084a164f5006f8a35ac5e0c2dddbfc3e02b0e8.svg"
                  alt="Btc">
             Bitcoin
           </span>
                                         </a>
                                         <div class="btn-group-vertical">
                                             <a data-code="BTC" href="javascript:void(0)"
                                                class="btn btn-raised calculator-currency list-currency-icon">
               <span>
                 <img class="currency-select-bg"
                      src="https://tokensale.crypterium.io/assets/currency-icons/BTC-07fdedf3e3359c6fc51a80b1af084a164f5006f8a35ac5e0c2dddbfc3e02b0e8.svg"
                      alt="Btc">
                 Bitcoin
               </span>
                                             </a>
                                             <a data-code="LTC" href="javascript:void(0)"
                                                class="btn btn-raised calculator-currency list-currency-icon">
               <span>
                 <img class="currency-select-bg"
                      src="https://tokensale.crypterium.io/assets/currency-icons/LTC-6fc830cbe9b0e4ff541fbdcbd0624bcb3c84cbf96d93f06990a9f628f41c428a.svg"
                      alt="Ltc">
                 Litecoin
               </span>
                                             </a>
                                             <a data-code="XRP" href="javascript:void(0)"
                                                class="btn btn-raised calculator-currency list-currency-icon">
               <span>
                 <img class="currency-select-bg"
                      src="https://tokensale.crypterium.io/assets/currency-icons/XRP-2e6e9a8741b361c5f56c1e0427616c90dc1ea5ec280a83f7a58bde02f8bda0a6.svg"
                      alt="Xrp">
                 Ripple
               </span>
                                             </a>
                                             <a data-code="BCH" href="javascript:void(0)"
                                                class="btn btn-raised calculator-currency list-currency-icon">
               <span>
                 <img class="currency-select-bg"
                      src="https://tokensale.crypterium.io/assets/currency-icons/default-00faa8cd795a0f7c52aa6e3446b573a275fd5a4356a9c04c2bab9ead4950722d.svg"
                      alt="Default">
                 Bitcoin Cash
               </span>
                                             </a>
                                             <a data-code="DASH" href="javascript:void(0)"
                                                class="btn btn-raised calculator-currency list-currency-icon">
               <span>
                 <img class="currency-select-bg"
                      src="https://tokensale.crypterium.io/assets/currency-icons/DASH-055be16d632ab38b8501c78332e9e1b34815a0c041475b7703e5f476d9d4a748.svg"
                      alt="Dash">
                 Dash
               </span>
                                             </a>
                                             <a data-code="ETC" href="javascript:void(0)"
                                                class="btn btn-raised calculator-currency list-currency-icon">
               <span>
                 <img class="currency-select-bg"
                      src="https://tokensale.crypterium.io/assets/currency-icons/ETC-fae1629fad87cbb19492b50b30d83d0b0aab51b721b6f27a9aafad5d2b6c56a6.svg"
                      alt="Etc">
                 Ether Classic
               </span>
                                             </a>
                                             <a data-code="ETH" href="javascript:void(0)"
                                                class="btn btn-raised calculator-currency list-currency-icon">
               <span>
                 <img class="currency-select-bg"
                      src="https://tokensale.crypterium.io/assets/currency-icons/ETH-06d12a0d0d6a19555d690e647be5bb57549d0e081e96c875ab0cf70097274e85.svg"
                      alt="Eth">
                 Ether
               </span>
                                             </a>
                                             <a data-code="USDT" href="javascript:void(0)"
                                                class="btn btn-raised calculator-currency list-currency-icon">
               <span>
                 <img class="currency-select-bg"
                      src="https://tokensale.crypterium.io/assets/currency-icons/USDT-6ba486d9295f2c45766ec98ef0e46ee854cef370d7bd73fc80b4938c308352a0.svg"
                      alt="Usdt">
                 TetherUSD
               </span>
                                             </a>
                                             <a data-code="USD" href="javascript:void(0)"
                                                class="btn btn-raised calculator-currency list-currency-icon">
               <span>
                 <img class="currency-select-bg"
                      src="https://tokensale.crypterium.io/assets/currency-icons/USD-818e8477c9355c633215e540a7854da570e67a678553a2b39e23fb9a35707342.svg"
                      alt="Usd">
                 USD
               </span>
                                             </a>
                                         </div>
                                     </div> -->

                                    <select title="Select your spell" class="selectpicker">
                                        <option value="BTC" selected>Bitcoin</option>
                                        <option value="LTC">Litecoin</option>
                                        <option value="ETH">ETH</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="bonus">
                                <span><span id="coin-bonus-percent">20%</span> BONUS:</span>
                                <div id="coin-bonus">0.2</div>
                            </div>
                            <div class="total">
                                <span>TOTAL:</span>
                                <div id="coin-total">1.2</div>
                            </div>
                        </div>
                        <!--calculator-->
                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="step" id="make-deposit">Step 2</div>
                        <h2>Make a deposit</h2>

                        <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                            <li class="active"><a href="#BTC" data-toggle="tab">Bitcoin&nbsp;(BTC)</a></li>
                            <li><a href="#LTC" data-toggle="tab">Litecoin&nbsp;(LTC)</a></li>
                            <li><a href="#XRP" data-toggle="tab">Ripple&nbsp;(XRP)</a></li>
                            <li><a href="#BCH" data-toggle="tab">Bitcoin Cash&nbsp;(BCH)</a></li>
                            <li><a href="#DASH" data-toggle="tab">Dash&nbsp;(DASH)</a></li>
                            <li><a href="#ETC" data-toggle="tab">Ether Classic&nbsp;(ETC)</a></li>
                            <li><a href="#ETH" data-toggle="tab">Ether&nbsp;(ETH)</a></li>
                            <li><a href="#USDT" data-toggle="tab">TetherUSD&nbsp;(USDT)</a></li>
                            <li><a href="#USD" data-toggle="tab">Cash, Wire Transfers, Checks</a></li>
                            <li><a href="#BankCard" data-toggle="tab">Visa/MasterCard</a></li>
                        </ul>

                        <div id="myTabContent" class="tab-content">

                            <div class="tab-pane fade in active" id="BTC">
                                <div><p>1. Generate your personal unique address for payment:</p></div>
                                <a href="javascript:void(0)" class="btn btn-raised get-address " data-code="BTC">Get
                                    Address for Payment</a>
                                <div>
                                    <div class="hide payment-block">
                                        <div class="row">
                                            <div class="col-md-5 col-xs-12 col-sm-12 text-center left">
                                                <p class="title">Deposit funds by scanning below</p>
                                                <div class="box quare-code">

                                                </div>
                                            </div>
                                            <div class="col-md-7 col-xs-12 col-sm-12 text-center right">
                                                <p class="title">Or Direct Deposit to</p>
                                                <div class="box" style="word-break: break-all;">
                                                    <img class="currency-tab-bg"
                                                         src="https://tokensale.crypterium.io/assets/currency-icons/BTC-07fdedf3e3359c6fc51a80b1af084a164f5006f8a35ac5e0c2dddbfc3e02b0e8.svg"
                                                         alt="Btc">
                                                    <div class="vertical-align-in-block">
                                                        <p class="payment-address"></p>
                                                        <p class="pubkey"></p>
                                                        <p class="dest-tag"></p>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div><p>2. Go to your wallet / exchange / mining pool account and send funds to this
                                            address.
                                            Please make sure your deposit equals or exceeds the minimum purchase amount
                                            (at the current exchange rate, it is <span
                                                    class="min-amount">0.0001 BTC</span>)
                                        </p>
                                    </div>
                                    <div>3. Funds will appear in your Crypterium account only after the transaction gets
                                        a few confirmations from network. This can take from 10 minutes to 2 hours and
                                        more, depending on network current load and your transaction fee.
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade in" id="LTC">
                                <div><p>1. Generate your personal unique address for payment:</p></div>
                                <a href="javascript:void(0)" class="btn btn-raised get-address " data-code="LTC">Get
                                    Address for Payment</a>
                                <div>
                                    <div class="hide payment-block">
                                        <div class="row">
                                            <div class="col-md-5 col-xs-12 col-sm-12 text-center left">
                                                <p class="title">Deposit funds by scanning below</p>
                                                <div class="box quare-code">

                                                </div>
                                            </div>
                                            <div class="col-md-7 col-xs-12 col-sm-12 text-center right">
                                                <p class="title">Or Direct Deposit to</p>
                                                <div class="box" style="word-break: break-all;">
                                                    <img class="currency-tab-bg"
                                                         src="https://tokensale.crypterium.io/assets/currency-icons/LTC-6fc830cbe9b0e4ff541fbdcbd0624bcb3c84cbf96d93f06990a9f628f41c428a.svg"
                                                         alt="Ltc">
                                                    <div class="vertical-align-in-block">
                                                        <p class="payment-address"></p>
                                                        <p class="pubkey"></p>
                                                        <p class="dest-tag"></p>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div><p>2. Go to your wallet / exchange / mining pool account and send funds to this
                                            address.
                                            Please make sure your deposit equals or exceeds the minimum purchase amount
                                            (at the current exchange rate, it is <span class="min-amount">0.0132583705064896 LTC</span>)
                                        </p>
                                    </div>
                                    <div>3. Funds will appear in your Crypterium account only after the transaction gets
                                        a few confirmations from network. This can take from 10 minutes to 2 hours and
                                        more, depending on network current load and your transaction fee.
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade in" id="XRP">
                                <p style="color:#D0011B;"><b>WARNING:</b> We have temporary issues with receiving XRP
                                    transfers from Coinpayments.net users. Please do not send us funds from
                                    Coinpayments.net wallets.</p>
                                <div><p>1. Generate your personal unique address for payment:</p></div>
                                <a href="javascript:void(0)" class="btn btn-raised get-address " data-code="XRP">Get
                                    Address for Payment</a>
                                <div>
                                    <div class="hide payment-block">
                                        <div class="row">
                                            <div class="col-md-5 col-xs-12 col-sm-12 text-center left">
                                                <p class="title">Deposit funds by scanning below</p>
                                                <div class="box quare-code">

                                                </div>
                                            </div>
                                            <div class="col-md-7 col-xs-12 col-sm-12 text-center right">
                                                <p class="title">Or Direct Deposit to</p>
                                                <div class="box" style="word-break: break-all;">
                                                    <img class="currency-tab-bg"
                                                         src="https://tokensale.crypterium.io/assets/currency-icons/XRP-2e6e9a8741b361c5f56c1e0427616c90dc1ea5ec280a83f7a58bde02f8bda0a6.svg"
                                                         alt="Xrp">
                                                    <div class="vertical-align-in-block">
                                                        <p class="payment-address"></p>
                                                        <p class="pubkey"></p>
                                                        <p class="dest-tag"></p>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div><p>2. Go to your wallet / exchange / mining pool account and send funds to this
                                            address.
                                            Please make sure your deposit equals or exceeds the minimum purchase amount
                                            (at the current exchange rate, it is <span class="min-amount">3.50344914568393 XRP</span>)
                                        </p>
                                    </div>
                                    <div>3. Funds will appear in your Crypterium account only after the transaction gets
                                        a few confirmations from network. This can take from 10 minutes to 2 hours and
                                        more, depending on network current load and your transaction fee.
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade in" id="BCH">
                                <div><p>1. Generate your personal unique address for payment:</p></div>
                                <a href="javascript:void(0)" class="btn btn-raised get-address " data-code="BCH">Get
                                    Address for Payment</a>
                                <div>
                                    <div class="hide payment-block">
                                        <div class="row">
                                            <div class="col-md-5 col-xs-12 col-sm-12 text-center left">
                                                <p class="title">Deposit funds by scanning below</p>
                                                <div class="box quare-code">

                                                </div>
                                            </div>
                                            <div class="col-md-7 col-xs-12 col-sm-12 text-center right">
                                                <p class="title">Or Direct Deposit to</p>
                                                <div class="box" style="word-break: break-all;">
                                                    <img class="currency-tab-bg"
                                                         src="https://tokensale.crypterium.io/assets/currency-icons/default-00faa8cd795a0f7c52aa6e3446b573a275fd5a4356a9c04c2bab9ead4950722d.svg"
                                                         alt="Default">
                                                    <div class="vertical-align-in-block">
                                                        <p class="payment-address"></p>
                                                        <p class="pubkey"></p>
                                                        <p class="dest-tag"></p>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div><p>2. Go to your wallet / exchange / mining pool account and send funds to this
                                            address.
                                            Please make sure your deposit equals or exceeds the minimum purchase amount
                                            (at the current exchange rate, it is <span class="min-amount">0.00106609694445955 BCH</span>)
                                        </p>
                                    </div>
                                    <div>3. Funds will appear in your Crypterium account only after the transaction gets
                                        a few confirmations from network. This can take from 10 minutes to 2 hours and
                                        more, depending on network current load and your transaction fee.
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade in" id="DASH">
                                <div><p>1. Generate your personal unique address for payment:</p></div>
                                <a href="javascript:void(0)" class="btn btn-raised get-address " data-code="DASH">Get
                                    Address for Payment</a>
                                <div>
                                    <div class="hide payment-block">
                                        <div class="row">
                                            <div class="col-md-5 col-xs-12 col-sm-12 text-center left">
                                                <p class="title">Deposit funds by scanning below</p>
                                                <div class="box quare-code">

                                                </div>
                                            </div>
                                            <div class="col-md-7 col-xs-12 col-sm-12 text-center right">
                                                <p class="title">Or Direct Deposit to</p>
                                                <div class="box" style="word-break: break-all;">
                                                    <img class="currency-tab-bg"
                                                         src="https://tokensale.crypterium.io/assets/currency-icons/DASH-055be16d632ab38b8501c78332e9e1b34815a0c041475b7703e5f476d9d4a748.svg"
                                                         alt="Dash">
                                                    <div class="vertical-align-in-block">
                                                        <p class="payment-address"></p>
                                                        <p class="pubkey"></p>
                                                        <p class="dest-tag"></p>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div><p>2. Go to your wallet / exchange / mining pool account and send funds to this
                                            address.
                                            Please make sure your deposit equals or exceeds the minimum purchase amount
                                            (at the current exchange rate, it is <span class="min-amount">0.00267452316762233 DASH</span>)
                                        </p>
                                    </div>
                                    <div>3. Funds will appear in your Crypterium account only after the transaction gets
                                        a few confirmations from network. This can take from 10 minutes to 2 hours and
                                        more, depending on network current load and your transaction fee.
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade in" id="ETC">
                                <div><p>1. Generate your personal unique address for payment:</p></div>
                                <a href="javascript:void(0)" class="btn btn-raised get-address " data-code="ETC">Get
                                    Address for Payment</a>
                                <div>
                                    <div class="hide payment-block">
                                        <div class="row">
                                            <div class="col-md-5 col-xs-12 col-sm-12 text-center left">
                                                <p class="title">Deposit funds by scanning below</p>
                                                <div class="box quare-code">

                                                </div>
                                            </div>
                                            <div class="col-md-7 col-xs-12 col-sm-12 text-center right">
                                                <p class="title">Or Direct Deposit to</p>
                                                <div class="box" style="word-break: break-all;">
                                                    <img class="currency-tab-bg"
                                                         src="https://tokensale.crypterium.io/assets/currency-icons/ETC-fae1629fad87cbb19492b50b30d83d0b0aab51b721b6f27a9aafad5d2b6c56a6.svg"
                                                         alt="Etc">
                                                    <div class="vertical-align-in-block">
                                                        <p class="payment-address"></p>
                                                        <p class="pubkey"></p>
                                                        <p class="dest-tag"></p>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div><p>2. Go to your wallet / exchange / mining pool account and send funds to this
                                            address.
                                            Please make sure your deposit equals or exceeds the minimum purchase amount
                                            (at the current exchange rate, it is <span class="min-amount">0.0668753176577589 ETC</span>)
                                        </p>
                                    </div>
                                    <div>3. Funds will appear in your Crypterium account only after the transaction gets
                                        a few confirmations from network. This can take from 10 minutes to 2 hours and
                                        more, depending on network current load and your transaction fee.
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade in" id="ETH">
                                <div><p>1. Generate your personal unique address for payment:</p></div>
                                <a href="javascript:void(0)" class="btn btn-raised get-address " data-code="ETH">Get
                                    Address for Payment</a>
                                <div>
                                    <div class="hide payment-block">
                                        <div class="row">
                                            <div class="col-md-5 col-xs-12 col-sm-12 text-center left">
                                                <p class="title">Deposit funds by scanning below</p>
                                                <div class="box quare-code">

                                                </div>
                                            </div>
                                            <div class="col-md-7 col-xs-12 col-sm-12 text-center right">
                                                <p class="title">Or Direct Deposit to</p>
                                                <div class="box" style="word-break: break-all;">
                                                    <img class="currency-tab-bg"
                                                         src="https://tokensale.crypterium.io/assets/currency-icons/ETH-06d12a0d0d6a19555d690e647be5bb57549d0e081e96c875ab0cf70097274e85.svg"
                                                         alt="Eth">
                                                    <div class="vertical-align-in-block">
                                                        <p class="payment-address"></p>
                                                        <p class="pubkey"></p>
                                                        <p class="dest-tag"></p>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div><p>2. Go to your wallet / exchange / mining pool account and send funds to this
                                            address.
                                            Please make sure your deposit equals or exceeds the minimum purchase amount
                                            (at the current exchange rate, it is <span class="min-amount">0.00244463124143386 ETH</span>)
                                        </p>
                                    </div>
                                    <div>3. Funds will appear in your Crypterium account only after the transaction gets
                                        a few confirmations from network. This can take from 10 minutes to 2 hours and
                                        more, depending on network current load and your transaction fee.
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade in" id="USDT">
                                <div><p>1. Generate your personal unique address for payment:</p></div>
                                <a href="javascript:void(0)" class="btn btn-raised get-address " data-code="USDT">Get
                                    Address for Payment</a>
                                <div>
                                    <div class="hide payment-block">
                                        <div class="row">
                                            <div class="col-md-5 col-xs-12 col-sm-12 text-center left">
                                                <p class="title">Deposit funds by scanning below</p>
                                                <div class="box quare-code">

                                                </div>
                                            </div>
                                            <div class="col-md-7 col-xs-12 col-sm-12 text-center right">
                                                <p class="title">Or Direct Deposit to</p>
                                                <div class="box" style="word-break: break-all;">
                                                    <img class="currency-tab-bg"
                                                         src="https://tokensale.crypterium.io/assets/currency-icons/USDT-6ba486d9295f2c45766ec98ef0e46ee854cef370d7bd73fc80b4938c308352a0.svg"
                                                         alt="Usdt">
                                                    <div class="vertical-align-in-block">
                                                        <p class="payment-address"></p>
                                                        <p class="pubkey"></p>
                                                        <p class="dest-tag"></p>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div><p>2. Go to your wallet / exchange / mining pool account and send funds to this
                                            address.
                                            Please make sure your deposit equals or exceeds the minimum purchase amount
                                            (at the current exchange rate, it is <span class="min-amount">0.725598836719945 USDT</span>)
                                        </p>
                                    </div>
                                    <div>3. Funds will appear in your Crypterium account only after the transaction gets
                                        a few confirmations from network. This can take from 10 minutes to 2 hours and
                                        more, depending on network current load and your transaction fee.
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade in" id="USD">
                                <p>You can transfer funds to bank account of our escrow, Blockchain Law Group, US, from
                                    any country in the world (SWIFT transfers available from outside US). It can be
                                    done, using wire transfer, cash or check. Exact payment details and instructions
                                    will be available in your invoice. Minimal amount is $50. Please note, that funds
                                    will appear in your Crypterium account within 24 hours after received in the bank
                                    account.</p>
                                <a href="javascript:void(0)" class="btn btn-raised generate-invoices" data-code="USD">Generate
                                    Invoice</a>
                            </div>
                            <div class="tab-pane fade in" id="BankCard">
                                <p style="color:#D0011B;"><b>WARNING!</b></p>
                                <p style="color:#D0011B;">This is instant, but very expensive way to pay. Exchange
                                    commission may be up to 25%. We do not recommend using this payment method if you
                                    have another option.</p>
                                <p>You can pay with Visa/MasterCard credit or debit card. Technically, we will generate
                                    your personal unique BTC address, and then, you will buy BTC to this address with
                                    third party service, Indacoin, with its exchange rate. You will have the limit of
                                    $50 for the first transaction, $100 for the second transaction available after 4
                                    days of the initial purchase and $500 after 7 days of the first buy. Be prepared to
                                    pass Indacoin's KYC.</p>
                                <p>
                                    <a href="javascript:void(0)" class="btn btn-raised fill-bankcard " data-code="BTC">Get
                                        Address for Payment</a>
                                </p>
                                <div class="hide payment-block">
                                    <p>Your BTC address: <span class="transfer-address"></span><br>
                                        Please, do not change it.</p>
                                    <a href="https://indacoin.com/change/buy-bitcoin-with-cardusd/EN-en?addrOut="
                                       class="btn btn-raised pay-bankcard" target="_blank">Pay with Visa/MasterCard</a>
                                </div>
                            </div>

                            <p>Please note that deposit of funds is not a purchase of CRPT tokens. You need to complete
                                Step 3 and purchase the required number of tokens with the deposited funds.</p>
                        </div>
                        <br><br>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="buy-form" class="step">Step 3</div>
                        <h2>Buy CRPT tokens</h2>
                        <form class="buy-tokens-form" role="form">
                            <div class="alert alert-dismissible alert-warning">Please make a deposit first to buy
                                tokens.
                            </div>


                            <div id="tokens-form-wrap" class="row">
                                <div class="col-xs-12 form-token-label"><label>PAY WITH</label></div>
                                <div class="col-md-5 col-xs-12">
                                    <div class="list-currency">
                                        <a href="javascript:void(0)"
                                           class="btn btn-raised btn-select current-currency btn-block disabled-list">No
                                            coins yet</a>
                                    </div>
                                </div>
                                <div class="col-md-7 col-xs-12">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input id="form-token-spend-all-checkbox" autocomplete="off"
                                                       type="checkbox" disabled="disabled"><span
                                                        class="checkbox-material"><span class="check"></span></span>
                                                Spend all funds in your account to buy tokens
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="form-token-label-amount" class="col-md-5 col-xs-12 form-token-label"><label>AMOUNT</label>
                                </div>
                                <div id="form-token-label-bonus" class="col-md-3 col-xs-12 form-token-label"
                                     style="display: block;">
                                    <label>BONUS</label>
                                </div>
                                <div id="form-token-label-total" class="col-md-4 col-xs-12 form-token-label"><label>TOTAL
                                        PRICE</label></div>

                                <div id="form-token-input-amount" class="col-md-5 col-xs-12">
                                    <div class="input-group input-amount">
        <span class="input-group-btn">
          <button type="button" class="btn btn-default btn-number" id="btn-minus" data-type="minus"
                  data-field="quant[1]" disabled="disabled">
            <span class="glyphicon glyphicon-minus"></span>
          </button>
        </span>
                                        <input type="text" name="quant[1]" class="input-number coin-amount"
                                               disabled="disabled">
                                        <span class="input-group-btn">
            <button type="button" class="btn btn-default btn-number" id="btn-plus" data-type="plus"
                    data-field="quant[1]" disabled="disabled">
              <span class="glyphicon glyphicon-plus"></span>
            </button>
        </span>
                                    </div>
                                </div>

                                <div id="bonus-amount-box" class="col-md-3 col-xs-12" style="display: block;">
                                    <p><span class="coins-bonus">0.2</span></p>
                                </div>
                                <div id="total-price-box" class="col-md-4 col-xs-12">
                                    <div class="buy-form-user-deposits"></div>
                                    <div class="price-box-separator"></div>
                                    <p><span class="coin-price"></span> <span class="coin-price-currency"></span></p>
                                </div>

                                <div class="col-md-12 row-delimiter "></div>

                                <!--<div id="add-promotional-code-label" class="col-xs-12 col-md-12 ">
                                  <label>ADD PROMO CODE</label>
                                </div>
                                <div id="active-promotional-code-label" class="col-xs-12 col-md-7 " style="display: none">
                                  <label>ACTIVE PROMO CODE</label>
                                </div>
                                <div id="form-token-promocode-box" class="col-xs-12 col-md-12 ">
                                  <div class="promo-code-form">
                                    <div class="box" style="height: 40px;">
                                      <input type="text" id="input-form-token-promocode">
                                    </div>
                                    <button type="button" id="btn-token-promocode-add" class="btn">add</button>
                                  </div>
                                </div>
                                <div id="form-token-promocode-current-box" class="col-xs-12 col-md-7" style="display: none">
                                  <p><span class="current-promocode"></span></p>
                                </div>-->
                            </div>


                            <div class="divider"></div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button type="button" class="btn btn-primary btn-raised btn-block buy-now"
                                            disabled="disabled">BUY NOW
                                    </button>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="step">Your referral link</div>
                        <form class="refer-link">
                            <div class="box">
                                <p id="refer-link-box">https://tokensale.crypterium.io/?ref=e51c7227a3ae4eb9ebf99964</p>
                            </div>
                            <button type="button" data-clipboard-target="#refer-link-box" id="refer-copy-link"
                                    class="btn">Copy link
                            </button>
                        </form>
                        <p>This is your Crypterium referral link. You can use it to share the project with your friends
                            and other interested parties. If any of them sign up with this link, they will get reward
                            amounts to 1% and will be added to your referral program. Your reward amounts to 5.0% of all
                            CRPT tokens purchased by your referrals.</p>
                        <div class="social-share-button" data-title="Crypterium — Cryptobank for Cryptopeople"
                             data-img="" data-url="https://tokensale.crypterium.io/?ref=e51c7227a3ae4eb9ebf99964"
                             data-desc="" data-via="">
                            <a rel="nofollow " data-site="twitter" class="ssb-icon ssb-twitter"
                               onclick="return SocialShareButton.share(this);" title="Share to Twitter" href="#"></a>
                            <a rel="nofollow " data-site="facebook" class="ssb-icon ssb-facebook"
                               onclick="return SocialShareButton.share(this);" title="Share to Facebook" href="#"></a>
                            <a rel="nofollow " data-site="google_plus" class="ssb-icon ssb-google_plus"
                               onclick="return SocialShareButton.share(this);" title="Share to Google+" href="#"></a>
                            <a rel="nofollow " data-site="weibo" class="ssb-icon ssb-weibo"
                               onclick="return SocialShareButton.share(this);" title="Share to Sina Weibo" href="#"></a>
                            <a rel="nofollow " data-site="qq" class="ssb-icon ssb-qq"
                               onclick="return SocialShareButton.share(this);" title="Share to Qzone" href="#"></a>
                            <a rel="nofollow " data-site="douban" class="ssb-icon ssb-douban"
                               onclick="return SocialShareButton.share(this);" title="Share to Douban" href="#"></a>
                            <a rel="nofollow " data-site="google_bookmark" class="ssb-icon ssb-google_bookmark"
                               onclick="return SocialShareButton.share(this);" title="Share to Google Bookmark"
                               href="#"></a>
                            <a rel="nofollow " data-site="delicious" class="ssb-icon ssb-delicious"
                               onclick="return SocialShareButton.share(this);" title="Share to Delicious" href="#"></a>
                            <a rel="nofollow " data-site="tumblr" class="ssb-icon ssb-tumblr"
                               onclick="return SocialShareButton.share(this);" title="Share to Tumblr" href="#"></a>
                            <a rel="nofollow " data-site="pinterest" class="ssb-icon ssb-pinterest"
                               onclick="return SocialShareButton.share(this);" title="Share to Pinterest" href="#"></a>
                            <a rel="nofollow " data-site="email" class="ssb-icon ssb-email"
                               onclick="return SocialShareButton.share(this);" title="Share to Email" href="#"></a>
                            <a rel="nofollow " data-site="linkedin" class="ssb-icon ssb-linkedin"
                               onclick="return SocialShareButton.share(this);" title="Share to Linkedin" href="#"></a>
                            <a rel="nofollow " data-site="wechat" class="ssb-icon ssb-wechat"
                               onclick="return SocialShareButton.share(this);" title="Share to WeChat"
                               data-wechat-footer="Open your WeChat, click &quot;Discover&quot; button then click the &quot;Scan QR Code&quot; menu."
                               href="#"></a>
                            <a rel="nofollow " data-site="vkontakte" class="ssb-icon ssb-vkontakte"
                               onclick="return SocialShareButton.share(this);" title="Share to Vkontakte" href="#"></a>
                            <a rel="nofollow " data-site="xing" class="ssb-icon ssb-xing"
                               onclick="return SocialShareButton.share(this);" title="Share to Xing" href="#"></a>
                            <a rel="nofollow " data-site="reddit" class="ssb-icon ssb-reddit"
                               onclick="return SocialShareButton.share(this);" title="Share to Reddit" href="#"></a>
                            <a rel="nofollow " data-site="hacker_news" class="ssb-icon ssb-hacker_news"
                               onclick="return SocialShareButton.share(this);" title="Share to Hacker News"
                               href="#"></a>
                            <a rel="nofollow " data-site="telegram" class="ssb-icon ssb-telegram"
                               onclick="return SocialShareButton.share(this);" title="Share to Telegram" href="#"></a>
                            <a rel="nofollow " data-site="odnoklassniki" class="ssb-icon ssb-odnoklassniki"
                               onclick="return SocialShareButton.share(this);" title="Share to Odnoklassniki"
                               href="#"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="aside" class="col-lg-4 col-sm-4 col-xs-12 ">
                <div class="panel panel-default aside">
                    <div class="panel-body">
                        <div class="row balance-btn">
                            <div class="col-xs-6 col-sm-12 col-md-6">
                                <a href="#buy-form" class="btn btn-raised btn-danger btn-lg btn-block user-balance-btn">BUY</a>
                            </div>
                            <div class="col-xs-6 col-sm-12 col-md-6">
                                <a href="#make-deposit"
                                   class="btn btn-raised btn-danger btn-lg btn-block user-balance-btn">DEPOSIT</a>
                            </div>

                        </div>


                        <div class="divider balance-separator"></div>

                        <h4>My CRPT Tokens</h4>
                        <p>0</p>
                        <a class="customLink" href="/profile/edit">Set wallet for withdrawal</a>
                        <div class="divider"></div>

                        <h4>My CRPT Referral Tokens</h4>
                        <p>0</p>
                        <a class="customLink" href="#refer-link-box">Get more free tokens</a>
                        <div class="divider"></div>

                        <h4>CRPT Token Price</h4>
                        <p>
                            0.0001 BTC
                        </p>
                        <span class="bonus">20.0% Bonus</span> for purchase ≥ 1 CRPT <br>
                        <span class="bonus">23.0% Bonus</span> for purchase ≥ 3000 CRPT <br>
                        <span class="bonus">26.0% Bonus</span> for purchase ≥ 10000 CRPT <br>
                        <span class="bonus">33.0% Bonus</span> for purchase ≥ 30000 CRPT <br>
                        <div class="divider"></div>

                        <div id="sidebar-countdown">
                            <h4>Early Sale</h4>
                            <div id="flipcountdown-box" data-date-end="2017-11-07T00:00:00-05:00" class="xdsoft">
                                <div class="xdsoft_flipcountdown xdsoft_size_sm">
                                    <div class="xdsoft_digit" style="background-position: 0px -211px;"></div>
                                    <div class="xdsoft_digit" style="background-position: 0px -841px;"></div>
                                    <div class="xdsoft_digit xdsoft_space"></div>
                                    <div class="xdsoft_digit" style="background-position: 0px -421px;"></div>
                                    <div class="xdsoft_digit" style="background-position: 0px -211px;"></div>
                                    <div class="xdsoft_digit xdsoft_space"></div>
                                    <div class="xdsoft_digit" style="background-position: 0px -1261px;"></div>
                                    <div class="xdsoft_digit" style="background-position: 0px -1471px;"></div>
                                    <div class="xdsoft_digit xdsoft_space"></div>
                                    <div class="xdsoft_digit" style="background-position: 0px -1261px;"></div>
                                    <div class="xdsoft_digit" style="background-position: 0px -631px;"></div>
                                    <div class="xdsoft_clearex"></div>
                                </div>
                            </div>
                            <table align="center" class="flipcountdown-footer">
                                <tbody>
                                <tr>
                                    <td class="flipcountdown-footer-labels" style="width: 48px;">Days</td>
                                    <td class="flipcountdown-footer-sep"></td>
                                    <td class="flipcountdown-footer-labels" style="width: 48px;">Hours</td>
                                    <td class="flipcountdown-footer-sep"></td>
                                    <td class="flipcountdown-footer-labels" style="width: 48px;">Minutes</td>
                                    <td class="flipcountdown-footer-sep"></td>
                                    <td class="flipcountdown-footer-labels" style="width: 48px;">Seconds</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="divider"></div>
                        <h4> BTC Raised</h4>
                        <p> 1299.9499370347 </p>
                    </div>
                </div>
            </div>

        </div>

        <div id="invoice-modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Generate invoice</h4>
                    </div>
                    <form class="form-horizontal backtesting_form" id="generate-invoice-form"
                          action="/coinbox/generate-invoice.json" accept-charset="UTF-8" data-remote="true"
                          method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="_method"
                                                                                          value="patch">
                        <div class="modal-body">

                            <div class="validate-error hide form-group">
                                <div class="col-xs-offset-3 col-xs-9">
                                </div>
                            </div>
                            <div class="form-group is-empty">
                                <label class="col-xs-3 control-label"
                                       for="forms_invoice_create_form_full_name">Name</label>
                                <div class="col-xs-9">
                                    <input class="form-control" type="text" name="forms_invoice_create_form[full_name]"
                                           id="forms_invoice_create_form_full_name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-3 control-label"
                                       for="forms_invoice_create_form_email">Email</label>
                                <div class="col-xs-9">
                                    <input class="form-control" disabled="disabled" type="text"
                                           value="admin@twister-vl.ru" name="forms_invoice_create_form[email]"
                                           id="forms_invoice_create_form_email">
                                </div>
                            </div>

                            <div class="form-group is-empty">
                                <label class="col-xs-3 control-label"
                                       for="forms_invoice_create_form_phone">Phone</label>
                                <div class="col-xs-9">
                                    <input class="form-control" type="text" name="forms_invoice_create_form[phone]"
                                           id="forms_invoice_create_form_phone">
                                </div>
                            </div>

                            <div class="form-group is-empty">
                                <label class="col-xs-3 control-label"
                                       for="forms_invoice_create_form_country">Country</label>
                                <div class="col-xs-9">
                                    <select class="form-control" name="forms_invoice_create_form[country]"
                                            id="forms_invoice_create_form_country">
                                        <option value=""></option>
                                        <option value="US">United States</option>
                                        <option value="GB">United Kingdom</option>
                                        <option disabled="disabled" value="---------------">---------------</option>
                                        <option value="AF">Afghanistan</option>
                                        <option value="AX">Åland Islands</option>
                                        <option value="AL">Albania</option>
                                        <option value="DZ">Algeria</option>
                                        <option value="AS">American Samoa</option>
                                        <option value="AD">Andorra</option>
                                        <option value="AO">Angola</option>
                                        <option value="AI">Anguilla</option>
                                        <option value="AQ">Antarctica</option>
                                        <option value="AG">Antigua and Barbuda</option>
                                        <option value="AR">Argentina</option>
                                        <option value="AM">Armenia</option>
                                        <option value="AW">Aruba</option>
                                        <option value="AU">Australia</option>
                                        <option value="AT">Austria</option>
                                        <option value="AZ">Azerbaijan</option>
                                        <option value="BS">Bahamas</option>
                                        <option value="BH">Bahrain</option>
                                        <option value="BD">Bangladesh</option>
                                        <option value="BB">Barbados</option>
                                        <option value="BY">Belarus</option>
                                        <option value="BE">Belgium</option>
                                        <option value="BZ">Belize</option>
                                        <option value="BJ">Benin</option>
                                        <option value="BM">Bermuda</option>
                                        <option value="BT">Bhutan</option>
                                        <option value="BO">Bolivia, Plurinational State of</option>
                                        <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                        <option value="BA">Bosnia and Herzegovina</option>
                                        <option value="BW">Botswana</option>
                                        <option value="BV">Bouvet Island</option>
                                        <option value="BR">Brazil</option>
                                        <option value="IO">British Indian Ocean Territory</option>
                                        <option value="BN">Brunei Darussalam</option>
                                        <option value="BG">Bulgaria</option>
                                        <option value="BF">Burkina Faso</option>
                                        <option value="BI">Burundi</option>
                                        <option value="KH">Cambodia</option>
                                        <option value="CM">Cameroon</option>
                                        <option value="CA">Canada</option>
                                        <option value="CV">Cape Verde</option>
                                        <option value="KY">Cayman Islands</option>
                                        <option value="CF">Central African Republic</option>
                                        <option value="TD">Chad</option>
                                        <option value="CL">Chile</option>
                                        <option value="CN">China</option>
                                        <option value="CX">Christmas Island</option>
                                        <option value="CC">Cocos (Keeling) Islands</option>
                                        <option value="CO">Colombia</option>
                                        <option value="KM">Comoros</option>
                                        <option value="CG">Congo</option>
                                        <option value="CD">Congo, The Democratic Republic of the</option>
                                        <option value="CK">Cook Islands</option>
                                        <option value="CR">Costa Rica</option>
                                        <option value="CI">Côte d'Ivoire</option>
                                        <option value="HR">Croatia</option>
                                        <option value="CU">Cuba</option>
                                        <option value="CW">Curaçao</option>
                                        <option value="CY">Cyprus</option>
                                        <option value="CZ">Czech Republic</option>
                                        <option value="DK">Denmark</option>
                                        <option value="DJ">Djibouti</option>
                                        <option value="DM">Dominica</option>
                                        <option value="DO">Dominican Republic</option>
                                        <option value="EC">Ecuador</option>
                                        <option value="EG">Egypt</option>
                                        <option value="SV">El Salvador</option>
                                        <option value="GQ">Equatorial Guinea</option>
                                        <option value="ER">Eritrea</option>
                                        <option value="EE">Estonia</option>
                                        <option value="ET">Ethiopia</option>
                                        <option value="FK">Falkland Islands (Malvinas)</option>
                                        <option value="FO">Faroe Islands</option>
                                        <option value="FJ">Fiji</option>
                                        <option value="FI">Finland</option>
                                        <option value="FR">France</option>
                                        <option value="GF">French Guiana</option>
                                        <option value="PF">French Polynesia</option>
                                        <option value="TF">French Southern Territories</option>
                                        <option value="GA">Gabon</option>
                                        <option value="GM">Gambia</option>
                                        <option value="GE">Georgia</option>
                                        <option value="DE">Germany</option>
                                        <option value="GH">Ghana</option>
                                        <option value="GI">Gibraltar</option>
                                        <option value="GR">Greece</option>
                                        <option value="GL">Greenland</option>
                                        <option value="GD">Grenada</option>
                                        <option value="GP">Guadeloupe</option>
                                        <option value="GU">Guam</option>
                                        <option value="GT">Guatemala</option>
                                        <option value="GG">Guernsey</option>
                                        <option value="GN">Guinea</option>
                                        <option value="GW">Guinea-Bissau</option>
                                        <option value="GY">Guyana</option>
                                        <option value="HT">Haiti</option>
                                        <option value="HM">Heard Island and McDonald Islands</option>
                                        <option value="VA">Holy See (Vatican City State)</option>
                                        <option value="HN">Honduras</option>
                                        <option value="HK">Hong Kong</option>
                                        <option value="HU">Hungary</option>
                                        <option value="IS">Iceland</option>
                                        <option value="IN">India</option>
                                        <option value="ID">Indonesia</option>
                                        <option value="IR">Iran, Islamic Republic of</option>
                                        <option value="IQ">Iraq</option>
                                        <option value="IE">Ireland</option>
                                        <option value="IM">Isle of Man</option>
                                        <option value="IL">Israel</option>
                                        <option value="IT">Italy</option>
                                        <option value="JM">Jamaica</option>
                                        <option value="JP">Japan</option>
                                        <option value="JE">Jersey</option>
                                        <option value="JO">Jordan</option>
                                        <option value="KZ">Kazakhstan</option>
                                        <option value="KE">Kenya</option>
                                        <option value="KI">Kiribati</option>
                                        <option value="KP">Korea, Democratic People's Republic of</option>
                                        <option value="KR">Korea, Republic of</option>
                                        <option value="KW">Kuwait</option>
                                        <option value="KG">Kyrgyzstan</option>
                                        <option value="LA">Lao People's Democratic Republic</option>
                                        <option value="LV">Latvia</option>
                                        <option value="LB">Lebanon</option>
                                        <option value="LS">Lesotho</option>
                                        <option value="LR">Liberia</option>
                                        <option value="LY">Libya</option>
                                        <option value="LI">Liechtenstein</option>
                                        <option value="LT">Lithuania</option>
                                        <option value="LU">Luxembourg</option>
                                        <option value="MO">Macao</option>
                                        <option value="MK">Macedonia, Republic of</option>
                                        <option value="MG">Madagascar</option>
                                        <option value="MW">Malawi</option>
                                        <option value="MY">Malaysia</option>
                                        <option value="MV">Maldives</option>
                                        <option value="ML">Mali</option>
                                        <option value="MT">Malta</option>
                                        <option value="MH">Marshall Islands</option>
                                        <option value="MQ">Martinique</option>
                                        <option value="MR">Mauritania</option>
                                        <option value="MU">Mauritius</option>
                                        <option value="YT">Mayotte</option>
                                        <option value="MX">Mexico</option>
                                        <option value="FM">Micronesia, Federated States of</option>
                                        <option value="MD">Moldova, Republic of</option>
                                        <option value="MC">Monaco</option>
                                        <option value="MN">Mongolia</option>
                                        <option value="ME">Montenegro</option>
                                        <option value="MS">Montserrat</option>
                                        <option value="MA">Morocco</option>
                                        <option value="MZ">Mozambique</option>
                                        <option value="MM">Myanmar</option>
                                        <option value="NA">Namibia</option>
                                        <option value="NR">Nauru</option>
                                        <option value="NP">Nepal</option>
                                        <option value="NL">Netherlands</option>
                                        <option value="NC">New Caledonia</option>
                                        <option value="NZ">New Zealand</option>
                                        <option value="NI">Nicaragua</option>
                                        <option value="NE">Niger</option>
                                        <option value="NG">Nigeria</option>
                                        <option value="NU">Niue</option>
                                        <option value="NF">Norfolk Island</option>
                                        <option value="MP">Northern Mariana Islands</option>
                                        <option value="NO">Norway</option>
                                        <option value="OM">Oman</option>
                                        <option value="PK">Pakistan</option>
                                        <option value="PW">Palau</option>
                                        <option value="PS">Palestine, State of</option>
                                        <option value="PA">Panama</option>
                                        <option value="PG">Papua New Guinea</option>
                                        <option value="PY">Paraguay</option>
                                        <option value="PE">Peru</option>
                                        <option value="PH">Philippines</option>
                                        <option value="PN">Pitcairn</option>
                                        <option value="PL">Poland</option>
                                        <option value="PT">Portugal</option>
                                        <option value="PR">Puerto Rico</option>
                                        <option value="QA">Qatar</option>
                                        <option value="RE">Réunion</option>
                                        <option value="RO">Romania</option>
                                        <option value="RU">Russian Federation</option>
                                        <option value="RW">Rwanda</option>
                                        <option value="BL">Saint Barthélemy</option>
                                        <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                                        <option value="KN">Saint Kitts and Nevis</option>
                                        <option value="LC">Saint Lucia</option>
                                        <option value="MF">Saint Martin (French part)</option>
                                        <option value="PM">Saint Pierre and Miquelon</option>
                                        <option value="VC">Saint Vincent and the Grenadines</option>
                                        <option value="WS">Samoa</option>
                                        <option value="SM">San Marino</option>
                                        <option value="ST">Sao Tome and Principe</option>
                                        <option value="SA">Saudi Arabia</option>
                                        <option value="SN">Senegal</option>
                                        <option value="RS">Serbia</option>
                                        <option value="SC">Seychelles</option>
                                        <option value="SL">Sierra Leone</option>
                                        <option value="SG">Singapore</option>
                                        <option value="SX">Sint Maarten (Dutch part)</option>
                                        <option value="SK">Slovakia</option>
                                        <option value="SI">Slovenia</option>
                                        <option value="SB">Solomon Islands</option>
                                        <option value="SO">Somalia</option>
                                        <option value="ZA">South Africa</option>
                                        <option value="GS">South Georgia and the South Sandwich Islands</option>
                                        <option value="SS">South Sudan</option>
                                        <option value="ES">Spain</option>
                                        <option value="LK">Sri Lanka</option>
                                        <option value="SD">Sudan</option>
                                        <option value="SR">Suriname</option>
                                        <option value="SJ">Svalbard and Jan Mayen</option>
                                        <option value="SZ">Swaziland</option>
                                        <option value="SE">Sweden</option>
                                        <option value="CH">Switzerland</option>
                                        <option value="SY">Syrian Arab Republic</option>
                                        <option value="TW">Taiwan</option>
                                        <option value="TJ">Tajikistan</option>
                                        <option value="TZ">Tanzania, United Republic of</option>
                                        <option value="TH">Thailand</option>
                                        <option value="TL">Timor-Leste</option>
                                        <option value="TG">Togo</option>
                                        <option value="TK">Tokelau</option>
                                        <option value="TO">Tonga</option>
                                        <option value="TT">Trinidad and Tobago</option>
                                        <option value="TN">Tunisia</option>
                                        <option value="TR">Turkey</option>
                                        <option value="TM">Turkmenistan</option>
                                        <option value="TC">Turks and Caicos Islands</option>
                                        <option value="TV">Tuvalu</option>
                                        <option value="UG">Uganda</option>
                                        <option value="UA">Ukraine</option>
                                        <option value="AE">United Arab Emirates</option>
                                        <option value="GB">United Kingdom</option>
                                        <option value="UM">United States Minor Outlying Islands</option>
                                        <option value="US">United States</option>
                                        <option value="UY">Uruguay</option>
                                        <option value="UZ">Uzbekistan</option>
                                        <option value="VU">Vanuatu</option>
                                        <option value="VE">Venezuela, Bolivarian Republic of</option>
                                        <option value="VN">Viet Nam</option>
                                        <option value="VG">Virgin Islands, British</option>
                                        <option value="VI">Virgin Islands, U.S.</option>
                                        <option value="WF">Wallis and Futuna</option>
                                        <option value="EH">Western Sahara</option>
                                        <option value="YE">Yemen</option>
                                        <option value="ZM">Zambia</option>
                                        <option value="ZW">Zimbabwe</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group is-empty">
                                <label class="col-xs-3 control-label"
                                       for="forms_invoice_create_form_state">State</label>
                                <div class="col-xs-9">
                                    <input class="form-control" type="text" name="forms_invoice_create_form[state]"
                                           id="forms_invoice_create_form_state">
                                </div>
                            </div>

                            <div class="form-group is-empty">
                                <label class="col-xs-3 control-label" for="forms_invoice_create_form_city">City</label>
                                <div class="col-xs-9">
                                    <input class="form-control" type="text" name="forms_invoice_create_form[city]"
                                           id="forms_invoice_create_form_city">
                                </div>
                            </div>

                            <div class="form-group is-empty">
                                <label class="col-xs-3 control-label"
                                       for="forms_invoice_create_form_address">Address</label>
                                <div class="col-xs-9">
                                    <input class="form-control" type="text" name="forms_invoice_create_form[address]"
                                           id="forms_invoice_create_form_address">
                                </div>
                            </div>

                            <div class="form-group is-empty">
                                <label class="col-xs-3 control-label" for="forms_invoice_create_form_postal_code">Postal
                                    Code</label>
                                <div class="col-xs-9">
                                    <input class="form-control" type="text"
                                           name="forms_invoice_create_form[postal_code]"
                                           id="forms_invoice_create_form_postal_code">
                                </div>
                            </div>

                            <div class="form-group is-empty">
                                <label class="col-xs-3 control-label" for="forms_invoice_create_form_amount">Amount,
                                    USD</label>
                                <div class="col-xs-9">
                                    <input class="form-control" type="text" name="forms_invoice_create_form[amount]"
                                           id="forms_invoice_create_form_amount">
                                    <div class="remark-to-input"> Minimum amount for wire transfer is $50.0</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button name="button" type="submit" class="btn btn-primary">Generate invoice</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal -->

        <div id="invoice-success-modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Generate invoice</h4>
                    </div>
                    <div class="modal-body">
                        <p>The invoice has been sent to your email address. <br>Please download and pay it.</p>
                    </div>
                    <div class="modal-footer">
                        <a target="_blank" class="btn btn-primary without-margin" id="invoice-pdf-url" href="/">DOWNLOAD
                            NOW</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal -->

        <div id="contract-modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Purchase of CRPT Tokens</h4>
                    </div>
                    <div class="modal-body">
                        <p>You are going to purchase <span class="coin-amount"> </span> CRPT <span
                                    class="token-pluralize"> </span> at the price of <span class="coin-rate"> </span>
                            <span class="currency"> </span> per CRPT Token.
                            <span class="contract-modal-bonus-block">
          You will also receive <span class="coins-bonus"></span> additional tokens to your account as a bonus.
        </span>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary accept">Agree</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal -->

    </div>
</div>
