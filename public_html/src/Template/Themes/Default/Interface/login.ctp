<section>
    <br/>
    <div class="row col-md-12">
        <div class="col-md-4">
            <div class="info-box bg-purple">
                <span class="info-box-icon" style="background: none;"><i class="fas fa-font fa-lg"></i></span>
                <div class="info-box-content" style="min-height: 95px;">
                    <span class="info-box-number">Address</span>
                    <span class="info-box-text" style="overflow-wrap: break-word;white-space: unset;">
                        0x9f5457694611261B987EdD0763843ce3FC5A8dbe
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
                                <i class="far fa-lg fa-copy"></i>
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
                    <span class="info-box-text">0 ETH</span>
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
                    <div>bignet.izzz.io (ETH)</div>
                    <div>Last block# : 7882452</div>
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

    <div class="row col-md-12" id="tnsn_online">
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
                                        <option value="ETH">ETH - Ethereum</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group form-group-lg">
                                    <label for="amount">Amount</label>
                                    <input type="text" class="form-control" name="amount" id="amount">
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
                            <hr />
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
                    <button type="button" class="btn btn-primary btn-lg disabled send" disabled="disabled">Send Transaction</button>
                </div>
            </div>
        </div>
    </div>
</section>