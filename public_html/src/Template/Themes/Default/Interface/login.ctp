<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="info-box bg-purple">
                <span class="info-box-icon" style="background: none;"><i class="fas fa-font fa-lg"></i></span>
                <div class="info-box-content" style="min-height: 95px;">
                    <span class="info-box-number" data-i18n="logged_in:blocks.address.label"></span>
                    <span class="info-box-text" id="payer"
                          style="overflow-wrap: break-word;white-space: unset; text-transform: none;">
                        <?= $address; ?>
                    </span>
                </div>
                <div class="info-box-content" style="margin-top: 6px;">
                        <span class="info-box-text">
                            <!--
                            <span data-container="body" data-toggle="popover" data-placement="top"
                                  data-content="Address in QRcode" data-trigger="hover">
                                <i class="fas fa-lg fa-qrcode"></i>
                            </span>
                            &nbsp;
                            <span data-container="body" data-toggle="popover" data-placement="top"
                                  data-content="Print" data-trigger="hover">
                                <i class="fas fa-lg fa-print"></i>
                            </span>
                            -->
                            <span data-container="body" data-toggle="popover" data-placement="top"
                                  data-i18n="[data-content]logged_in:blocks.address.icon_copy" data-trigger="hover">
                                <i class="far fa-lg fa-copy autocopy" data-iz3-need-copy="payer"></i>
                            </span>
                        </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-blue">
                <span class="info-box-icon" style="background: none;"><i class="fas fa-lg fa-wallet fa-lg"></i></span>
                <div class="info-box-content" style="min-height: 95px;">
                    <span class="info-box-number" data-i18n="logged_in:blocks.balance.label"></span>
                    <span class="info-box-text"
                          style="text-transform: none;"><span id="balance"><?= $balance; ?></span> <?= $network['ticker']; ?></span>
                </div>
                <div class="info-box-content" style="margin-top: 6px;">
                        <span class="info-box-text">
                            <!--
                            <span data-container="body" data-toggle="popover" data-placement="top"
                                  data-content="Check Balance" data-trigger="hover">
                                <i class="fab fa-lg fa-creative-commons-nd"></i>
                            </span>
                            -->
                            <span data-container="body" data-toggle="popover" data-placement="top"
                                  data-i18n="[data-content]logged_in:blocks.balance.icon_refresh" data-trigger="hover" id="balance_refresh">
                                <i class="fas fa-lg fa-sync-alt"></i>
                            </span>
                        </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-light-blue ">
                    <span class="info-box-icon" style="background: none;"><img
                            src="https://bignet.izzz.io/img/logo.svg"
                            style="width: 82%; margin-bottom: 14px; margin-left: 10px;"></span>

                <div class="info-box-content" style="min-height: 95px;">
                    <span class="info-box-number" data-i18n="logged_in:blocks.network.label"></span>
                    <div><?= $network['name'].' ('.$network['ticker'].')'; ?></div>
                    <div><span data-i18n="logged_in:blocks.network.last_block"></span><?= $network['lastBlock']; ?></div>
                </div>
                <div class="info-box-content" style="margin-top: 6px;">
                        <span class="info-box-text">
                            <span data-container="body" data-toggle="popover" data-placement="top"
                                  data-i18n="[data-content]logged_in:blocks.network.title" data-trigger="hover">
                                <button type="button" class="btn btn-default btn-xs" data-i18n="logged_in:blocks.network.btn_change"></button>
                            </span>
                        </span>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="network" value="<?= $network['name']; ?>">
    <input type="hidden" id="masterContract" value="<?= $network['masterContract']; ?>">
    <input type="hidden" id="ticker" value="<?= $network['ticker']; ?>">
    <input type="hidden" id="icon" value="<?= $network['icon']; ?>">

    <div class="row box-wrapper" id="tnsn_online">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title" data-i18n="[html]tnsn_send_online:header"></h3>
                </div>
                <div class="box-body">
                    <form>
                        <div class="row col-md-12">
                            <div class="col-md-5 col-xs-7">
                                <div class="form-group form-group-lg">
                                    <label for="contract_address" data-i18n="tnsn_send_online:contract_addr_label"></label>
                                    <input type="number" step="any" class="form-control without-arrow" name="contract_address"
                                           id="contract_address" data-i18n="[placeholder]tnsn_send_online:contract_addr_placeholder">
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-5">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-success btn-lg btn-block find-tokens" data-i18n="tnsn_send_online:btn_find_tokens"></button>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group form-group-lg">
                                    <p class="text-muted" data-i18n="tnsn_send_online:dscr_find_tokens"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>

                        <div class="row col-md-12">
                            <div class="col-md-6 col-sm-7 col-xs-12">
                                <div class="form-group form-group-lg">
                                    <label for="type" data-i18n="tnsn_send_online:tkn_type_label"></label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="<?= $network['masterContract']; ?>" data-max="<?= $balance; ?>">IZ3 - IZZZIO main token</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-5 col-xs-12">
                                <div class="form-group form-group-lg">
                                    <label for="amount">
                                        <span data-i18n="tnsn_send_online:tkn_amount_label"></span>
                                        <span id="token-max" class="label label-warning">
                                            <span data-i18n="tnsn_send_online:tkn_amount_max_label"></span>
                                            <span><?= $balance; ?></span>
                                        </span>
                                    </label>
                                    <input type="number" step="any" class="form-control without-arrow" name="amount"
                                           id="amount">
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <div class="form-group form-group-lg">
                                    <label for="payee" data-i18n="tnsn_send_online:tkn_to_addr_label"></label>
                                    <input type="text" class="form-control" name="payee" id="payee" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr/>
                            <h4 style="font-weight: 600;" data-i18n="tnsn_send_online:sub_header"></h4>
                        </div>

                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <div class="form-group form-group-lg">
                                    <label for="data" data-i18n="tnsn_send_online:data_add_label"></label>
                                    <input type="text" class="form-control disabled" id="data" autocomplete="off" disabled="disabled" readonly="readonly">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-footer text-center">
                    <div class="row">
                        <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <button type="button" class="btn btn-success btn-lg btn-block disabled send"
                                    disabled="disabled" data-i18n="tnsn_send_online:btn_send">
                            </button>
                        </div>
                        <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs">
                        </div>
                    </div>
                </div>
                <div class="overlay" style="display: none;">
                    <i class="fas fa-spinner fa-pulse fa-3x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row box-wrapper" id="tnsn_offline" style="display: none;">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title" data-i18n="[html]tnsn_send_offline:header"></h3>
                </div>
                <div class="box-body">
                    <form>
                        <div class="row col-md-12">
                            <div class="col-md-5">
                                <div class="form-group form-group-lg">
                                    <label for="type" data-i18n="tnsn_send_offline:tkn_type_label"></label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="IZ3">IZ3 - IZZZIO main token</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group form-group-lg">
                                    <label for="amount" data-i18n="tnsn_send_offline:tkn_amount_label"></label>
                                    <input type="number" step="any" class="form-control without-arrow" name="amount"
                                           id="amount" data-i18n="[placeholder]tnsn_send_offline:tkn_amount_placeholder">
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <div class="form-group form-group-lg">
                                    <label for="payee" data-i18n="tnsn_send_offline:tkn_to_addr_label"></label>
                                    <textarea
                                            class="form-control" name="payee" id="payee" autocomplete="off"
                                            data-i18n="[placeholder]tnsn_send_offline:tkn_to_addr_placeholder" style="height: 115px;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <div class="form-group form-group-lg">
                                    <label for="data" data-i18n="tnsn_send_offline:data_label"></label>
                                    <input type="text" class="form-control" id="data" autocomplete="off" value="0x"
                                           disabled="disabled">
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <div class="form-group form-group-lg">
                                    <label for="gas_limit">Gas limit</label>
                                    &nbsp;&nbsp;
                                    <span data-container="body" data-toggle="popover" data-placement="top"
                                          data-content="This refers to the maximum allowance of gas you will give
                                          for a transaction. All excess gas will be refunded from successful transactions.
                                          This field should autogenerate based on network congestion." data-trigger="hover" class="mini">
                                        <i class="fas fa-exclamation-circle sign-help sign-muted"></i>
                                    </span>
                                    <input type="number" step="any" class="form-control without-arrow" id="gas_limit" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        -->
                    </form>
                </div>
                <div class="box-footer text-center">
                    <div class="row">
                        <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <button type="button" class="btn btn-default btn-lg btn-block import"
                                    onclick="document.getElementById('tnsn_import').click();" data-i18n="tnsn_send_offline:btn_import_json">
                            </button>
                            <input id="tnsn_import" type="file" style="display: none;"/>
                        </div>
                        <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <button type="button" class="btn btn-success btn-lg btn-block disabled send"
                                    disabled="disabled" data-i18n="tnsn_send_offline:btn_generate_tnsn">
                            </button>
                        </div>
                        <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row box-wrapper" id="dapps" style="display: none;">
        <div id="dapps_select">
            <div class="col-md-8">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title" data-i18n="[html]dapps:header"></h3>
                    </div>
                    <div class="box-body">
                        <form>
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group form-group-lg">
                                        <label for="dapp_contract_addr" data-i18n="dapps:contract_addr_label"></label>
                                        <input type="number" step="any" class="form-control without-arrow" name="dapp_contract_addr" id="dapp_contract_addr" data-i18n="[placeholder]dapps:contract_addr_placeholder">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="box-footer text-center">
                        <div class="row">
                            <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <button type="button" class="btn btn-success btn-lg btn-block disabled load-app" disabled="disabled" data-i18n="dapps:btn_get_app">
                                </button>
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs">
                            </div>
                        </div>
                    </div>
                    <div class="overlay" style="display: none;">
                        <i class="fas fa-spinner fa-pulse fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div id="dapps_view">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title" data-i18n="[html]dapps:app_content_info"></h3>
                    </div>
                    <div class="box-body" id="dapps_wrapper">
                    </div>
                    <div class="overlay" style="display: none;">
                        <i class="fas fa-spinner fa-pulse fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row box-wrapper" id="contract_interact" style="display: none;">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title" data-i18n="[html]contract_interact_s1:header"></h3>
                </div>
                <div id="step1">
                    <div class="box-body">
                        <form>
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group form-group-lg">
                                        <label for="deployed_contract_name" data-i18n="contract_interact_s1:contract_name_label"></label>
                                        <select class="form-control" name="deployed_contract_name" id="deployed_contract_name">
                                            <option value=""></option>
                                            <?php
                                                foreach($contractsPopular as $key => $contract){
                                            ?>
                                                    <option value="<?= $contract['id']; ?>" data-from="<?= $contract['from']; ?>"><?= $contract['name']; ?></option>
                                            <?php
                                                }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group form-group-lg">
                                        <label for="interact_who" data-i18n="contract_interact_s1:contract_addr_label"></label>
                                        <input type="text" class="form-control" name="interact_who" id="interact_who" data-i18n="[placeholder]contract_interact_s1:contract_addr_placeholder">
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group form-group-lg">
                                        <label for="contract_code" data-i18n="contract_interact_s1:abi_interface_label"></label>
                                        <textarea class="form-control" name="abi" id="abi" autocomplete="off" style="height: 225px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="box-footer text-center">
                        <div class="row">
                            <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <button type="button" class="btn btn-success btn-lg btn-block disabled continue" disabled="disabled" data-i18n="contract_interact_s1:btn_continue">
                                </button>
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="step2" style="display: none;">
                    <div class="box-body">
                        <form>
                            <div class="row col-md-12">
                                <div class="col-md-12">
                                    <span id="interact_with" data-i18n="contract_interact_s2:info"></span>
                                    <div class="form-group form-group-lg">
                                        <label for="interacting" data-i18n="contract_interact_s2:contract_addr_label"></label>
                                        <input class="form-control" name="interacting" id="interacting"
                                               value="izNUhVKtDpmgCnVycSMUPusX8sdnErzAD9T" readonly="readonly" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="col-md-7">
                                    <div class="form-group form-group-lg">
                                        <label for="deployed_contract_action" data-i18n="contract_interact_s2:contract_action_label"></label>
                                        <select class="form-control" name="deployed_contract_action" id="deployed_contract_action">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12" id="add_fields">
                            </div>
                            <div class="row col-md-12">
                                <div class="col-md-7">
                                    <div class="form-group form-group-lg">
                                        <label for="resources" data-i18n="contract_interact_s2:resources_label"></label>
                                        <input type="number" step="any" class="form-control without-arrow"
                                               name="resources" id="resources" value="0" placeholder="ETH">

                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group form-group-lg">
                                        <label for="interacting" data-i18n="contract_interact_s2:result_label"></label>
                                        <input class="form-control" name="interacting_result" id="interacting_result" readonly="readonly" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="box-footer text-center">
                        <div class="row">
                            <div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <button type="button" class="btn btn-default btn-lg btn-block back" data-i18n="contract_interact_s2:btn_back">
                                </button>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <button type="button" class="btn btn-default btn-lg btn-block disabled do-interact" disabled="disabled" data-i18n="contract_interact_s2:btn_read">
                                </button>
                            </div>
                            <div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overlay" style="display: none;">
                    <i class="fas fa-spinner fa-pulse fa-3x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row box-wrapper" id="contract_deploy" style="display: none;">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title" data-i18n="[html]contract_deploy:header"></h3>
                </div>
                <div class="box-body">
                    <form>
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <div class="form-group form-group-lg">
                                    <label for="contract_code" data-i18n="contract_deploy:contract_code_label"></label>
                                    <textarea
                                            class="form-control" name="contract_code" id="contract_code"
                                            autocomplete="off"
                                            style="height: 225px;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <label for="contract_rent" data-i18n="contract_deploy:contract_rent_label"></label>
                                <div class="input-group input-group-lg">
                                    <input type="number" step="any" class="form-control without-arrow"
                                           name="contract_rent" id="contract_rent" autocomplete="off"
                                           data-i18n="[placeholder]contract_deploy:contract_rent_placeholder">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-success calc-resource" data-i18n="contract_deploy:btn_calc_resource"></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <div class="form-group form-group-lg" style="margin-top: 14px; line-height: 0.9;">
                                    <label data-i18n="contract_deploy:contract_rent_available_label"></label>
                                    <p class="text-muted" id="resources_calculated" style="font-size: 17px;" data-i18n="contract_deploy:contract_rent_available_min_label"></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-footer text-center">
                    <div class="row">
                        <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <button type="button" class="btn btn-success btn-lg btn-block disabled sign" disabled="disabled" data-i18n="contract_deploy:btn_sign_tnsn">
                            </button>
                        </div>
                        <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs">
                        </div>
                    </div>
                </div>
                <div class="overlay" style="display: none;">
                    <i class="fas fa-spinner fa-pulse fa-3x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row box-wrapper" id="message_write" style="display: none;">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><strong>Sign message</strong></h3>
                </div>
                <div class="box-body">
                    Coming soon...
                </div>
                <div class="box-footer text-center">
                </div>
            </div>
        </div>
    </div>

    <div class="row box-wrapper" id="message_read" style="display: none;">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><strong>Verify message</strong></h3>
                </div>
                <div class="box-body">
                    Coming soon...
                </div>
                <div class="box-footer text-center">
                </div>
            </div>
        </div>
    </div>
</section>