<?php
    //echo $this->Html->script('/themes/default/js/walletActions.js', array('inline' => 'false'));
?>

<div class="content-wrapper wallet">
    <section class="content-header">
        <h1 data-i18n="wallet_create:main.header"></h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-12">
                <div class="box text-center">
                    <div class="box-body">
                        <form role="form">
                            <h4 data-i18n="wallet_create:main.description1"></h4>
                            <h4 data-i18n="wallet_create:main.description2"></h4>
                            <br />
                            <button type="button" data-i18n="wallet_create:main.btn_create" class="btn btn-lg btn-primary" id="create"></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="content-wrapper file" style="display: none;">
    <section class="content-header">
        <h1 data-i18n="wallet_create:file.header"></h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-12">
                <div class="box text-center">
                    <div class="box-body">
                        <h4 data-i18n="[html]wallet_create:file.description1"></h4>
                        <br />

                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8">
                                <button type="button" data-i18n="wallet_create:file.btn_download" class="btn btn-lg btn-primary" id="save_file"></button>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                        <br />

                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-6" style="background-color: #eeeeee70;">
                                <div class="col-md-3 col-xs-3 text-center" style="color: #3c8dbc80;">
                                    <i class="fas fa-shield-alt fa-3x fa-border"></i>
                                </div>
                                <div class="col-md-9 col-xs-9 text-left">
                                    <h4 data-i18n="wallet_create:file.help1_header"></h4>
                                    <p class="text-muted" data-i18n="wallet_create:file.help1_text"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-6" style="background-color: #eeeeee70;">
                                <div class="col-md-3 col-xs-3 text-center" style="color: #3c8dbc80;">
                                    <i class="fas fa-user-secret fa-3x fa-border"></i>
                                </div>
                                <div class="col-md-9 col-xs-9 text-left">
                                    <h4 data-i18n="wallet_create:file.help2_header"></h4>
                                    <p class="text-muted" data-i18n="wallet_create:file.help2_text"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-6" style="background-color: #eeeeee70;">
                                <div class="col-md-3 col-xs-3 text-center" style="color: #3c8dbc80;">
                                    <i class="fas fa-archive fa-3x fa-border"></i>
                                </div>
                                <div class="col-md-9 col-xs-9 text-left">
                                    <h4 data-i18n="wallet_create:file.help3_header"></h4>
                                    <p class="text-muted" data-i18n="wallet_create:file.help3_text"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>

                        <br />
                        <br />
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                <button type="button" data-i18n="wallet_create:file.btn_continue" class="btn btn-lg btn-danger disabled" disabled="disabled" id="continue"></button>
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="content-wrapper key" style="display: none;">
    <section class="content-header">
        <h1 data-i18n="wallet_create:key.header"></h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-12">
                <div class="box text-center">
                    <div class="box-body">
                        <h4 data-i18n="[html]wallet_create:key.description1"></h4>
                        <br />

                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-10">
                                <textarea readonly="readonly" id="s_key" rows="3" style="width: 100%; max-width: 100%; min-width: 100%; height: auto; font-size: 18px; background-color: #ececec;">
                                </textarea>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                        <br />

                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8">
                                <button type="button" data-i18n="wallet_create:key.btn_print" class="btn btn-lg btn-primary" id="print_wallet"></button>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                        <br />

                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-6" style="background-color: #eeeeee70;">
                                <div class="col-md-3 col-xs-3 text-center" style="color: #3c8dbc80;">
                                    <i class="fas fa-shield-alt fa-3x fa-border"></i>
                                </div>
                                <div class="col-md-9 col-xs-9 text-left">
                                    <h4 data-i18n="wallet_create:key.help1_header"></h4>
                                    <p class="text-muted" data-i18n="wallet_create:key.help1_text"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-6" style="background-color: #eeeeee70;">
                                <div class="col-md-3 col-xs-3 text-center" style="color: #3c8dbc80;">
                                    <i class="fas fa-user-secret fa-3x fa-border"></i>
                                </div>
                                <div class="col-md-9 col-xs-9 text-left">
                                    <h4 data-i18n="wallet_create:key.help2_header"></h4>
                                    <p class="text-muted" data-i18n="wallet_create:key.help2_text"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-6" style="background-color: #eeeeee70;">
                                <div class="col-md-3 col-xs-3 text-center" style="color: #3c8dbc80;">
                                    <i class="fas fa-archive fa-3x fa-border"></i>
                                </div>
                                <div class="col-md-9 col-xs-9 text-left">
                                    <h4 data-i18n="wallet_create:key.help3_header"></h4>
                                    <p class="text-muted" data-i18n="wallet_create:key.help3_text"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>

                        <br />
                        <br />
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                <a href="<?= URL_PREFIX ?>/wallet/login" data-i18n="wallet_create:key.btn_login" class="btn btn-lg btn-danger" id="save_address"></a>
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>