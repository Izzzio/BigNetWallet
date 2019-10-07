<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="info-box bg-purple">
                <span class="info-box-icon" style="background: none;"><i class="fas fa-font fa-lg"></i></span>
                <div class="info-box-content" style="min-height: 95px;">
                    <span class="info-box-number">Address</span>
                    <span class="info-box-text" id="payer"
                          style="overflow-wrap: break-word;white-space: unset; text-transform: none;">
                        <?= $address; ?>
                    </span>
                </div>
                <div class="info-box-content" style="margin-top: 6px;">
                        <span class="info-box-text">
                            <span data-container="body" data-toggle="popover" data-placement="top"
                                  data-content="Address in QRcode" data-trigger="hover">
                                <i class="fas fa-lg fa-qrcode"></i>
                            </span>
                            &nbsp;
                            <span data-container="body" data-toggle="popover" data-placement="top"
                                  data-content="Print" data-trigger="hover">
                                <i class="fas fa-lg fa-print"></i>
                            </span>
                            &nbsp;
                            <span data-container="body" data-toggle="popover" data-placement="top"
                                  data-content="Copy" data-trigger="hover">
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
                    <span class="info-box-number">Balance</span>
                    <span class="info-box-text"
                          style="text-transform: none;"><?= $balance; ?> <?= $network['ticker']; ?></span>
                </div>
                <div class="info-box-content" style="margin-top: 6px;">
                        <span class="info-box-text">
                            <span data-container="body" data-toggle="popover" data-placement="top"
                                  data-content="Check Balance" data-trigger="hover">
                                <i class="fab fa-lg fa-creative-commons-nd"></i>
                            </span>
                            &nbsp;
                            <span data-container="body" data-toggle="popover" data-placement="top"
                                  data-content="Refresh Balance" data-trigger="hover">
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
                    <span class="info-box-number">Network</span>
                    <div><?= $network['name'].' ('.$network['ticker'].')'; ?></div>
                    <div>Last block# : <?= $network['lastBlock']; ?></div>
                </div>
                <div class="info-box-content" style="margin-top: 6px;">
                        <span class="info-box-text">
                            <span data-container="body" data-toggle="popover" data-placement="top"
                                  data-content="Open Networks" data-trigger="hover">
                                <button type="button" class="btn btn-default btn-xs">Change</button>
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
                    <h3 class="box-title"><strong>Send transaction</strong></h3>
                </div>
                <div class="box-body">
                    <form>
                        <div class="row col-md-12">
                            <div class="col-md-5">
                                <div class="form-group form-group-lg">
                                    <label for="type">Type</label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="IZ3">IZ3 - IZZZIO main token</option>
                                        <!--
                                        <option value="ETH">ETH - Ethereum</option>
                                        -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group form-group-lg">
                                    <label for="amount">Amount</label>
                                    <input type="number" step="any" class="form-control without-arrow" name="amount"
                                           id="amount">
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <div class="form-group form-group-lg">
                                    <label for="payee">To address</label>
                                    <input type="text" class="form-control" name="payee" id="payee" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr/>
                            <h4 style="font-weight: 600;">Advanced</h4>
                        </div>

                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <div class="form-group form-group-lg">
                                    <label for="data">Add data</label>
                                    <input type="text" class="form-control" id="data" autocomplete="off">
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
                                    disabled="disabled">Send Transaction
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
                    <h3 class="box-title"><strong>Send Offline</strong></h3>
                </div>
                <div class="box-body">
                    <form>
                        <div class="row col-md-12">
                            <div class="col-md-5">
                                <div class="form-group form-group-lg">
                                    <label for="type">Type</label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="IZ3">IZ3 - IZZZIO main token</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group form-group-lg">
                                    <label for="amount">Amount</label>
                                    <input type="number" step="any" class="form-control without-arrow" name="amount"
                                           id="amount" placeholder="Deposit Amount">
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <div class="form-group form-group-lg">
                                    <label for="payee">To address</label>
                                    <textarea
                                            class="form-control" name="payee" id="payee" autocomplete="off"
                                            placeholder="Please Enter The Address" style="height: 115px;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <div class="form-group form-group-lg">
                                    <label for="data">Data</label>
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
                                    onclick="document.getElementById('tnsn_import').click();">Import JSON
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
                                    disabled="disabled">Generate Transaction
                            </button>
                        </div>
                        <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row box-wrapper" id="exchange" style="display: none;">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><strong>Exchange</strong></h3>
                </div>
                <div class="box-body">
                    Coming soon...
                </div>
                <div class="box-footer text-center">
                </div>
            </div>
        </div>
    </div>

    <div class="row box-wrapper" id="dapps" style="display: none;">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><strong>Dapps</strong></h3>
                </div>
                <div class="box-body">
                    Coming soon...
                </div>
                <div class="box-footer text-center">
                </div>
            </div>
        </div>
    </div>

    <div class="row box-wrapper" id="contract_interact" style="display: none;">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><strong>Interact with deployed Contract</strong></h3>
                </div>
                <div id="step1">
                    <div class="box-body">
                        <form>
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group form-group-lg">
                                        <label for="deployed_contract_name">Contract name</label>
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
                                        <label for="interact_who">Contract Address</label>
                                        <input type="text" class="form-control" name="interact_who" id="interact_who" placeholder="Enter Contract Address">
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
                                <button type="button" class="btn btn-success btn-lg btn-block disabled continue" disabled="disabled">
                                    Continue
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
                                    <span id="interact_with">Read/Write Contract</span>
                                    <div class="form-group form-group-lg">
                                        <label for="interacting">Contract Address</label>
                                        <input class="form-control" name="interacting" id="interacting"
                                               value="izNUhVKtDpmgCnVycSMUPusX8sdnErzAD9T" readonly="readonly" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="col-md-7">
                                    <div class="form-group form-group-lg">
                                        <label for="deployed_contract_action">Execute action</label>
                                        <select class="form-control" name="deployed_contract_action" id="deployed_contract_action">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="add_fields">
                            </div>
                            <div class="row col-md-12">
                                <div class="col-md-7">
                                    <div class="form-group form-group-lg">
                                        <label for="resources">Value in ETH</label>
                                        <input type="number" step="any" class="form-control without-arrow"
                                               name="resources" id="resources" value="0" placeholder="ETH">

                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group form-group-lg">
                                        <label for="interacting">Result</label>
                                        <input class="form-control" value="valid" name="interacting_result" id="interacting_result" readonly="readonly" disabled="disabled">
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
                                <button type="button" class="btn btn-default btn-lg btn-block back">
                                    Back
                                </button>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <button type="button" class="btn btn-default btn-lg btn-block disabled do-interact" disabled="disabled">
                                    Read
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
                    <h3 class="box-title"><strong>Deploy new contract</strong></h3>
                </div>
                <div class="box-body">
                    <form>
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <div class="form-group form-group-lg">
                                    <label for="contract_code">Contract code</label>
                                    <textarea
                                            class="form-control" name="contract_code" id="contract_code"
                                            autocomplete="off"
                                            style="height: 225px;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <div class="form-group form-group-lg">
                                    <label for="contract_rent">Resource rent</label>
                                    <input type="number" step="any" class="form-control without-arrow"
                                           name="contract_rent" id="contract_rent" autocomplete="off"
                                           placeholder="Amount resources for deploy contract">
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
                            <button type="button" class="btn btn-success btn-lg btn-block disabled sign" disabled="disabled">
                                Sign Transaction
                            </button>
                        </div>
                        <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs">
                        </div>
                    </div>
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