$(function () {
    (function () {
        const wallet = {
            'address': false,
            'main': {
                'keysPair': {
                    'public': '',
                    'private': ''
                }
            }
        };
        $('#create').on('click', function () {
            wallet.main = iz3BitcoreCrypto.generateWallet();
        });

        $('#save_file').on('click', function () {
            download(
                JSON.stringify({'address': wallet.main.keysPair.public}),
                'UTC--' + ((new Date()).toISOString()) + '--' + wallet.main.keysPair.public,
                'text/plain'
            );
            $('#continue')
                .prop("disabled", false)
                .removeClass('disabled');
        });

        $('#continue').on('click', function () {
            $('#s_key').val(wallet.main.keysPair.private);
        });

        var selectLoginWayDlg = new BootstrapDialog({
            title: 'Access by Software',
            closable: true,
            closeByBackdrop: false,
            closeByKeyboard: true,
            size: BootstrapDialog.SIZE_LARGE,
            spinicon: 'fas fa-spinner fa-pulse',
            message: getLoginWayDlgContent(),
            buttons: [{
                id: 'setWaySeleted',
                label: ' Continue',
                cssClass: 'btn',
                action: function (dialogRef) {
                    dialogRef.enableButtons(false);
                    dialogRef.setClosable(false);
                    var $button = this;
                    $button.spin();
                    let loginWay = dialogRef.getModalContent().find('.wallet-option.selected').data('option-login') || 0;
                    dialogRef.close();
                    switch (loginWay) {
                        case 1:
                            //askLoginFileDlg.open();
                            break;
                        case 2:
                            askLoginKeyDlg.open();
                            break;
                        default:
                    }
                }
            }],
            onshow: function (dialogRef) {
                dialogRef.enableButtons(false);
                dialogRef.getModalFooter().css('text-align', 'center')
            },
            onshown: function (dialogRef) {
                $('.wallet-option').on('click', function () {
                    let alreadySelected = false;
                    let modalContent = dialogRef.getModalContent();
                    if ($(this).hasClass('selected')) {
                        alreadySelected = true;
                    }
                    modalContent.find('.wallet-option').removeClass('selected');
                    modalContent.find('.sign-selected').addClass('hidden');
                    if (alreadySelected) {
                        modalContent.find('#setWaySeleted').removeClass('btn-success');
                        dialogRef.enableButtons(false);
                    } else {
                        $(this).addClass('selected');
                        $('.sign-selected', $(this)).removeClass('hidden');

                        modalContent.find('#setWaySeleted').addClass('btn-success');
                        dialogRef.enableButtons(true);
                    }
                });
            },
        });

        if ($('#login').length) {
            selectLoginWayDlg.open();
        }

        function getLoginWayDlgContent() {
            return '' +
                '<div class="container-fluid">' +
                '<div class="row">' +
                '<div class="col-md-12 col-xs-12 wallet-option" data-option-login="1">' +
                '<div class="col-md-2 col-xs-2 text-right">' +
                '<i class="far fa-file-code fa-2x" style="color: #00a65a;"></i>' +
                '</div>' +
                '<div class="col-md-8 col-xs-8" style="margin-top: 5px;">' +
                'Keystore File' +
                '</div>' +
                '<div class="col-md-2 col-xs-2 sign-selected hidden" style="margin-top: 7px;">' +
                '<i class="fas fa-check-circle" style="color: #00a65a;"></i>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-12 col-xs-12 wallet-option" data-option-login="2">' +
                '<div class="col-md-2 col-xs-2 text-right">' +
                '<i class="fas fa-key fa-2x" style="color: #00a65a;"></i>' +
                '</div>' +
                '<div class="col-md-8 col-xs-8" style="margin-top: 5px;">' +
                'Private Key' +
                '</div>' +
                '<div class="col-md-2 col-xs-2 sign-selected hidden" style="margin-top: 7px;">' +
                '<i class="fas fa-check-circle" style="color: #00a65a;"></i>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
        }

        function download(content, fileName, contentType) {
            let link = document.createElement("a");
            let file = new Blob([content], {type: contentType});
            link.href = URL.createObjectURL(file);
            link.download = fileName;
            link.click();
        }

        var askLoginKeyDlg = new BootstrapDialog({
            title: 'Access by Private Key',
            closable: true,
            closeByBackdrop: false,
            closeByKeyboard: true,
            size: BootstrapDialog.SIZE_LARGE,
            spinicon: 'fas fa-spinner fa-pulse',
            message: getLoginKeyDlgContent(),
            buttons: [{
                id: 'login',
                label: ' Access Wallet',
                cssClass: 'btn',
                action: function (dialogRef) {
                    dialogRef
                        .enableButtons(false)
                        .setClosable(false);
                    let content = dialogRef.getModalContent();
                    let key = String(content.find('#key').val() || false);
                    let $button = this;
                    $button.spin();
                    content.find('#message').hide();
                    try {
                        wallet.address = iz3BitcoreCrypto.private2address(key);
                        wallet.main.keysPair.private = key;
                        $.getJSON('login', {addr: wallet.address})
                            .done(function (resp) {
                                if (resp.success) {
                                    $('section.sidebar', $('body')).html(resp.data.menu);
                                    $('.content-wrapper', $('body')).html(resp.data.page);
                                    dialogRef.close();
                                    walletIZ3.setCurrentNetwork();
                                    walletIZ3.setEventListeners();

                                    //window.history.pushState({"html":resp.data,"pageTitle":'TITLE 1'},"", '/interface/send-online');
                                    //window.location.replace("/send/online");

                                } else {
                                    content.find('#message')
                                        .html(resp.msg)
                                        .show();
                                }
                            })
                            .fail(function (resp) {
                                content.find('#message')
                                    .html(resp.msg)
                                    .show();
                            })
                            .always(function (resp) {
                                dialogRef
                                    .enableButtons(true)
                                    .setClosable(true);
                                $button.stopSpin();
                            });
                    } catch (e) {
                        console.log(e);
                        content.find('#message')
                            .html('Wrong private key. Re-check key ant try again.')
                            .show();
                        dialogRef
                            .enableButtons(true)
                            .setClosable(true);
                        $button.stopSpin();
                    }
                }
            }],
            onshow: function (dialogRef) {
                dialogRef.enableButtons(false);
                dialogRef.getModalFooter().css('text-align', 'center')
            },
            onshown: function (dialogRef) {
                let btn = dialogRef.getModalContent().find('#login') || false;
                if (btn) {
                    $('#key').on('keyup', function () {
                        if ($(this).val().length >= 1) {
                            if (!btn.hasClass('btn-success')) {
                                btn.addClass('btn-success');
                                dialogRef.enableButtons(true);
                            }
                        } else {
                            btn.removeClass('btn-success');
                            dialogRef.enableButtons(false);
                        }
                    });
                }
            },
        });

        function getLoginKeyDlgContent() {
            return '' +
                '<div id="message" class="row alert alert-danger" role="alert" style="border-radius: 0px; display: none;">' +
                '</div>' +
                '<div class="container-fluid">' +
                '<div class="row">' +
                '<div class="col-md-12 col-xs-12 form-group">' +
                '<input type="text" id="key" placeholder="Enter Private Key" class="form-control input-lg" autocomplete="off">' +
                '</div>' +
                '</div>' +
                '</div>';
        }





        var walletIZ3 = {
            tnsnOnlineForm: $('#tnsn_online'),
            tnsnOfflineForm: $('#tnsn_offline'),
            contractDeployForm: $('#contract_deploy'),
            network: {
                name: '',
                ticker: '',
                masterContract: false,
                icon: ''
            },
            setCurrentNetwork: function(){
                this.network.name = $('#network').val() || '';
                this.network.ticker = $('#ticker').val() || '';
                this.network.masterContract = String($('#masterContract').val() || false);
                this.network.icon = $('#icon').val() || '';
            },

            setEventListeners: function () {
                let body = $('body');
                $('#tnsn_online form', body).validate({
                    rules: {
                        type: {
                            required: true
                        },
                        amount: {
                            required: true,
                            number: true,
                            min: 0.00000000000000000001,
                        },
                        payee: {
                            required: true,
                            minlength: 30,
                            alphanumeric: true
                        }
                    },
                    messages: {
                        type: {
                            required: 'This field is required'
                        },
                        amount: {
                            required: 'This field is required',
                            number: "Please enter numbers only",
                            min: "Minimum value 0.00000000000000000001"
                        },
                        payee: {
                            required: 'This field is required',
                            minlength: 'Wrong address: too short',
                            alphanumeric: 'Only alpah and numeric symbols allowed'
                        }
                    },
                    highlight: function (element) {
                        $(element).addClass('error');
                    },
                    onkeyup: function (element) {
                        $(element).valid();
                        if ($('#tnsn_online form').valid()) {
                            $('button', this.tnsnOnlineForm)
                                .prop('disabled', false)
                                .removeClass('disabled');
                        } else {
                            $('button', this.tnsnOnlineForm)
                                .prop('disabled', true)
                                .addClass('disabled');
                        }
                    }
                });

                $('#tnsn_online .send').on('click', function () {
                    let block = new ecmaContractCallBlock(
                            walletIZ3.network.masterContract,
                            'transfer',
                            [
                                String($('#payee', this.tnsnOnlineForm).val() || false),
                                String($('#amount', this.tnsnOnlineForm).val() || false),
                            ],
                            {
                                'from': wallet.address,
                                'contractAddress': walletIZ3.network.masterContract
                            }
                        );
                    block.sign = iz3BitcoreCrypto.sign(block.data, wallet.main.keysPair.private);
                    block.pubkey = wallet.address;

                    $(this)
                        .prop('disabled', true)
                        .addClass('disabled');
                    $('.overlay', this.tnsnOnlineForm).show();

                    walletIZ3.HTTPRequest.init({
                        url: '/transaction/online',
                        method: 'POST',
                        data: block
                    });
                    walletIZ3.HTTPRequest.send('resTnsnOnline');
                });


                $('#tnsn_offline form', body).validate({
                    rules: {
                        type: {
                            required: true
                        },
                        amount: {
                            required: true
                        },
                        payee: {
                            required: true,
                            minlength: 30
                        }
                    },
                    messages: {
                        type: {
                            required: 'This field is required'
                        },
                        amount: {
                            required: 'This field is required'
                        },
                        payee: {
                            required: 'This field is required',
                            minlength: 'Wrong address'
                        }
                    },
                    highlight: function (element) {
                        $(element).addClass('error');
                    },
                    onkeyup: function (element) {
                        $(element).valid();
                        if ($('#tnsn_offline form').valid()) {
                            $('button', this.tnsnOfflineForm)
                                .prop('disabled', false)
                                .removeClass('disabled');
                        } else {
                            $('button.send', this.tnsnOfflineForm)
                                .prop('disabled', true)
                                .addClass('disabled');
                        }
                    }
                });

                $('#tnsn_offline .send').on('click', function () {
                    showSendedOfflineTransaction
                        .realize()
                        .getModalFooter().css('text-align', 'center');
                    let modalContent = showSendedOfflineTransaction.getModalContent();
                    let tnsnData = {
                        'to': $('#tnsn_offline #payee').val(),
                        'amount': $('#tnsn_offline #amount').val()
                    };
                    let tnsnSign = iz3BitcoreCrypto.sign(JSON.stringify(tnsnData), wallet.main.keysPair.private);

                    modalContent.find('#tnsn_id code').html(tnsnSign);
                    modalContent.find('#qrcode').qrcode({width: 140, height: 140, text: tnsnSign});
                    modalContent.find('#tnsn_row code').html(JSON.stringify(tnsnData));

                    $('#download', modalContent).on('click', function () {
                        download(
                            JSON.stringify({'rawTransaction': tnsnSign, 'tx': tnsnData}),
                            'signetTransaction-' + (Date.now()) + '.json',
                            'text/plain'
                        );
                    });

                    showSendedOfflineTransaction.open();
                });

                $('#tnsn_import').on('change', function () {
                    let file = this.files[0] || false;
                    let fileSize = file ? file.size : 0;
                    if(fileSize > 5120){
                        toastr['warning']('File size is too big. Import impossible');
                    } else {
                        let reader = new FileReader();
                        reader.onload = (function () {
                            return function (e) {
                                try {
                                    let tnsn = JSON.parse(e.target.result);
                                    $('#amount', this.tnsnOfflineForm).val((tnsn.tx.amount || ''));
                                    $('#payee', this.tnsnOfflineForm).val((tnsn.tx.to || ''));
                                    toastr['success']('File successfull imported');

                                    if ($('#tnsn_offline form').valid()) {
                                        $('button', this.tnsnOfflineForm)
                                            .prop('disabled', false)
                                            .removeClass('disabled');
                                    } else {
                                        $('button.send', this.tnsnOfflineForm)
                                            .prop('disabled', true)
                                            .addClass('disabled');
                                    }
                                } catch (e) {
                                    toastr['warning']('Error when trying to parse json: ' + e);
                                    $('button.send', this.tnsnOfflineForm)
                                        .prop('disabled', true)
                                        .addClass('disabled');
                                }
                            }
                        })();
                        reader.readAsText(file);
                    }
                });


                $('#step1 form', $('#contract_interact')).validate({
                    rules: {
                        deployed_contract_name: {
                            required: true
                        },
                        interact_who: {
                            required: true,
                        },
                        abi: {
                            required: true,
                            validJSON: true
                        }
                    },
                    messages: {
                        deployed_contract_name: {
                            required: 'This field is required'
                        },
                        interact_who: {
                            required: 'This field is required'
                        },
                        abi: {
                            required: 'This field is required'
                        }
                    },
                    highlight: function (element) {
                        $(element).addClass('error');
                    },
                    onkeyup: function (element) {
                        $(element).valid();
                        let buttons = $('#step1 button', $('#contract_interact'));
                        if ($('#step1 form', $('#contract_interact')).valid()) {
                            buttons
                                .prop('disabled', false)
                                .removeClass('disabled');
                        } else {
                            buttons
                                .prop('disabled', true)
                                .addClass('disabled');
                        }
                    },
                    onclick: function (element) {
                        $(element).valid();
                        let buttons = $('#step1 button', $('#contract_interact'));
                        if ($('#step1 form', $('#contract_interact')).valid()) {
                            buttons
                                .prop('disabled', false)
                                .removeClass('disabled');
                        } else {
                            buttons
                                .prop('disabled', true)
                                .addClass('disabled');
                        }
                    }
                });

                $('#step2 form', $('#contract_interact')).validate({
                    rules: {
                        deployed_contract_action: {
                            required: true
                        },
                        resources: {
                            required: true,
                            number: true,
                            min: 0,
                        }
                    },
                    messages: {
                        deployed_contract_action: {
                            required: 'This field is required'
                        },
                        resources: {
                            required: 'This field is required',
                            number: "Please enter numbers only",
                            min: "Minimum value 0"
                        }
                    },
                    highlight: function (element) {
                        $(element).addClass('error');
                    },
                    onkeyup: function (element) {
                        $(element).valid();
                        let buttons = $('#step2 button.do-interact', $('#contract_interact'));
                        if ($('#step2 form', $('#contract_interact')).valid()) {
                            buttons
                                .prop('disabled', false)
                                .removeClass('disabled');
                        } else {
                            buttons
                                .prop('disabled', true)
                                .addClass('disabled');
                        }
                    },
                    onclick: function (element) {
                        $(element).valid();
                        let buttons = $('#step2 button.do-interact', $('#contract_interact'));
                        if ($('#step2 form', $('#contract_interact')).valid()) {
                            buttons
                                .prop('disabled', false)
                                .removeClass('disabled');
                        } else {
                            buttons
                                .prop('disabled', true)
                                .addClass('disabled');
                        }
                    }
                });

                $('#deployed_contract_name', $('#contract_interact')).on('change', function () {
                    let selected = $(this).find(':selected');
                    let from = selected.data('from') || '';
                    $('#interact_who', $('#contract_interact')).val(from);
                    $('#abi', $('#contract_interact')).val('');
                    $('#interact_with', $('#contract_interact')).text('Read/Write Contract - '+selected.text());

                    let id = $(this).val() || '';
                    if(id.length){
                        $('.overlay', $('#contract_interact')).show();
                        walletIZ3.HTTPRequest.init({
                            url: '/contract/getInfo/'+id,
                            method: 'GET',
                        });
                        walletIZ3.HTTPRequest.send('resGetContractInfo');
                    }
                });

                var interactedContract = new interactContract();
                $('#contract_interact .continue').on('click', function () {
                    $('#step1', $('#contract_interact')).hide();
                    $('#step2', $('#contract_interact')).show();
                    $('#interacting', $('#contract_interact')).val($('#interact_who', $('#contract_interact')).val() || '');

                    $('#add_fields', $('#contract_interact')).html('');

                    interactedContract.abi = $('#abi', $('#contract_interact')).val();
                    let methods = interactedContract.getMethods();

                    let el = $('#deployed_contract_action', $('#contract_interact'));
                    el.children('option:not(:first)').remove();
                    $.each(methods, function (key, value) {
                    el
                        .append($("<option></option>")
                        .attr("value", value)
                        .text(value));
                    });

                    if (!$('#step2 form', $('#contract_interact')).valid()) {
                        let buttons = $('#step2 button.do-interact', $('#contract_interact'));
                        buttons
                            .prop('disabled', true)
                            .addClass('disabled');
                    }
                });
                $('#contract_interact .back').on('click', function () {
                    $('#step2', $('#contract_interact')).hide();
                    $('#step1', $('#contract_interact')).show();
                });

                let method = '';
                $('#deployed_contract_action', $('#contract_interact')).on('change', function () {
                    method = $(this).find(':selected').val();

                    $('#add_fields', $('#contract_interact')).html('');
                    $('#interacting_result', $('#contract_interact')).val('');

                    (async function () {
                        let blockNew = '';
                        let fields = interactedContract.getAdditionalFieldsOfMethod(method);
                        for (let i = 0; i < fields.length; i++) {
                            blockNew = await interactedContract.fieldToHTMLBlock(fields[i]);
                            $('#add_fields', $('#contract_interact')).append(blockNew);
                        }
                    })();
                });

                $('.do-interact', $('#contract_interact')).on('click', function () {
                    $('button', $('#contract_interact'))
                        .prop('disabled', true)
                        .addClass('disabled');
                    $('.overlay', $('#contract_interact')).show();

                    let data = {
                        'contract': $('#deployed_contract_name', $('#contract_interact')).find(':selected').val(),
                        'method': method
                    };
                    $('#add_fields input', $('#contract_interact')).each(function (i, v) {
                        data[$(this).attr('name')] = $(this).val();
                    });
                    data.waitingInResponse = '[{"name":"","type":"string"}]';

                    walletIZ3.HTTPRequest.init({
                        url: '/transaction/contractInteract',
                        method: 'GET',
                        data: data
                    });
                    walletIZ3.HTTPRequest.send('resInteractContract', data.waitingInResponse);
                });


                $('#contract_deploy form', body).validate({
                    rules: {
                        contract_code: {
                            required: true
                        },
                        contract_rent: {
                            required: false,
                            number: true,
                            min: 0,
                        }
                    },
                    messages: {
                        contract_code: {
                            required: 'This field is required'
                        },
                        contract_rent: {
                            required: 'This field is required',
                            number: "Please enter numbers only",
                            min: "Minimum value 0"
                        }
                    },
                    highlight: function (element) {
                        $(element).addClass('error');
                    },
                    onkeyup: function (element) {
                        $(element).valid();
                        if ($('#contract_deploy form').valid()) {
                            $('button', this.contractDeployForm)
                                .prop('disabled', false)
                                .removeClass('disabled');
                        } else {
                            $('button', this.contractDeployForm)
                                .prop('disabled', true)
                                .addClass('disabled');
                        }
                    }
                });

                let block = '';
                let resourceRent = '';
                $('#contract_deploy .sign').on('click', function () {
                        resourceRent = ($('#contract_rent', this.contractDeployForm).val() || 0);
                        block = new ecmaContractDeployBlock(
                        String(($('#contract_code', this.contractDeployForm).val() || false)),
                        {
                            'resourceRent': resourceRent,
                            'from': wallet.address,
                            'contractAddress': walletIZ3.network.masterContract,
                            'randomSeed': walletIZ3.utility.getRandomInt()
                        }
                    );
                    block.sign = iz3BitcoreCrypto.sign(block.data, wallet.main.keysPair.private);
                    block.pubkey = wallet.address;
                    if(block.isSigned()){
                        confirmContractDeployDlg
                            .realize()
                            .getModalFooter().css('text-align', 'center');
                        let modalContent = confirmContractDeployDlg.getModalContent();
                        modalContent.find('img').attr('src', walletIZ3.network.icon);
                        modalContent.find('.amount').html('- ' + resourceRent);
                        modalContent.find('.currency').html(' ' + walletIZ3.network.ticker);
                        modalContent.find('.network').html(' ' + walletIZ3.network.ticker + ' by ' + walletIZ3.network.name);
                        modalContent.find('.address').html(($('#payer').html() || ''));
                        confirmContractDeployDlg.open();
                    } else {
                        BootstrapDialog.alert({
                            title: 'Error',
                            message: 'Error create signature for transaction. Please, check contract code and try again',
                            type: BootstrapDialog.TYPE_DANGER,
                            size: BootstrapDialog.SIZE_LARGE,
                            closable: true
                        });
                    }
                });

                let successContractDeployDlg = new BootstrapDialog({
                    closable: true,
                    closeByBackdrop: false,
                    size: BootstrapDialog.SIZE_LARGE,
                    message: getSuccessContractDeployDlgContent()
                });

                let confirmContractDeployDlg = new BootstrapDialog({
                    title: 'Confirmation',
                    closable: true,
                    closeByBackdrop: false,
                    size: BootstrapDialog.SIZE_LARGE,
                    spinicon: 'fas fa-spinner fa-pulse',
                    message: getConfirmContractDeployDlgContent(),
                    buttons: [{
                        label: ' Confirm and Send',
                        cssClass: 'btn btn-success',
                        action: function (dialogRef) {
                            dialogRef
                                .enableButtons(false)
                                .setClosable(false);
                            let content = dialogRef.getModalContent();
                            let $button = this;
                            $button.spin();
                            content.find('#message').hide();
                            try {
                                $.post(
                                    '/transaction/contractDeploy',
                                    {
                                    'block': block,
                                    'rent': resourceRent
                                    },
                                    "json")
                                    .done(function (resp) {
                                        if (resp.success) {
                                            dialogRef.close();

                                            successContractDeployDlg.realize();
                                            successContractDeployDlg.getModalHeader().hide();
                                            successContractDeployDlg.getModalFooter().hide();
                                            let modalContent = successContractDeployDlg.getModalContent();
                                            $('#tnsn-check-status', modalContent).on('click', function () {
                                                alert('Open new window');
                                            });
                                            $('#close', modalContent).on('click', {dialogRef: successContractDeployDlg}, function (event) {
                                                $('#contract_code', this.contractDeployForm).val('');
                                                $('.sign', this.contractDeployForm)
                                                    .addClass('disabled')
                                                    .prop('disabled', true);
                                                event.data.dialogRef.close();
                                            });
                                            successContractDeployDlg.open();
                                        } else {
                                            content.find('#message')
                                                .html(resp.msg)
                                                .show();
                                        }
                                    })
                                    .fail(function (resp) {
                                        content.find('#message')
                                            .html(resp.msg)
                                            .show();
                                    })
                                    .always(function (resp) {
                                        dialogRef
                                            .enableButtons(true)
                                            .setClosable(true);
                                        $button.stopSpin();
                                    });
                            } catch (e) {
                                console.log(e);
                                content.find('#message')
                                    .html('Error sending transaction. Please try again later')
                                    .show();
                                dialogRef
                                    .enableButtons(true)
                                    .setClosable(true);
                                $button.stopSpin();
                            }
                        }
                    }]
                });

                function getConfirmContractDeployDlgContent() {
                    return '' +
                        '<div id="message" class="row alert alert-danger" role="alert" style="border-radius: 0px; display: none;">' +
                        '</div>' +
                        '<div class="container-fluid confirmation-contract-deploy">' +
                        '<div class="row">' +
                        '<div class="col-md-6 col-xs-12 main">' +
                        '<div class="icon-bg"><img></div>' +
                        '<p>' +
                        '<span class="amount"></span>' +
                        '<span class="currency"></span>' +
                        '</p>' +
                        '<div class="address-label">From Address</div>' +
                        '<div class="address"></div>' +
                        '</div>' +
                        '</div>' +
                        '<hr style=" position: fixed; width: 100%; left: 0px; ">' +
                        '<div class="row detail-header">' +
                        '<div class="col-md-12 col-xs-12"><h4>Detail Information</h4></div>' +
                        '</div>' +
                        '<div class="row detail-item">' +
                            '<div class="col-md-6 col-sm-6 hidden-xs text-left">Network</div>' +
                            '<div class="col-md-6 col-sm-6 hidden-xs text-right network"></div>' +
                                '<div class="hidden-lg hidden-md hidden-sm col-xs-12">' +
                                    '<dl><dt>Network</dt><dd class="network"></dd></dl>'
                                '</div>' +
                            '</div>' +
                        '</div>';
                }

                function getSuccessContractDeployDlgContent() {
                    return '' +
                        '<div class="container-fluid text-center">' +
                        '<div class="row">' +
                        '<i class="far fa-check-circle fa-7x text-success"></i>' +
                        '</div>' +
                        '<div class="row">' +
                        '<h2 style=" font-weight: 700; color: #003945; ">Success</h2>'+
                        '</div>' +
                        '<div class="row" style=" color: #506175; font-size: 16px; margin-top: 15px; margin-bottom: 40px;">' +
                        'Transaction sent to network' +
                        '</div>' +
                        '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<div class="col-lg-2 col-md-2 col-sm-1 hidden-xs">' +
                        '</div>' +
                        '<div class="col-lg-8 col-md-8 col-sm-10 col-xs-12">' +
                        '<button class="btn btn-default btn-lg btn-block disabled" disabled id="tnsn-check-status">Check Status</button>' +
                        '</div>' +
                        '<div class="col-lg-2 col-md-2 col-sm-1 hidden-xs">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<br />' +
                        '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<div class="col-lg-2 col-md-2 col-sm-1 hidden-xs">' +
                        '</div>' +
                        '<div class="col-lg-8 col-md-8 col-sm-10 col-xs-12">' +
                        '<button class="btn btn-success btn-lg btn-block" id="close">Okay</button>' +
                        '</div>' +
                        '<div class="col-lg-2 col-md-2 col-sm-1 hidden-xs">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>'
                    ;
                }


                body.off('click', '.autocopy');
                body.on('click', '.autocopy', function () {
                    let target = $(this).data('iz3-need-copy') || false;
                    walletIZ3.utility.copy(target);
                });
            },
            HTTPRequest: {
                defaults: {
                    method: 'GET'
                },
                settings: {},
                data: '',
                init: function (options) {
                    options = options || false;
                    if (options) {
                        this.settings = walletIZ3.utility.extend(this.defaults, options);
                    } else {
                        this.settings = walletIZ3.utility.extend(this.defaults, this.defaults);
                    }
                },
                send: function (callback, waitingInResponse) {
                    $.ajax({
                        url: this.settings.url,
                        method: this.settings.method,
                        data: this.settings.data,
                        dataType: 'json',
                    })
                    /*
                    .done(function (resp) {
                        if (callback) {
                            walletIZ3.callbacks[callback](resp);
                        }
                    })
                    .fail(function (resp) {
                        if (callback) {
                            walletIZ3.callbacks[callback](resp);
                        }
                    })
                    */
                        .always(function (resp) {
                            if (callback) {
                                walletIZ3.callbacks[callback](resp, waitingInResponse);
                            }
                        });
                },
                collectData: function (wrapper_id) {
                    var block = document.getElementById(wrapper_id) || false;
                    if (block) {
                        var element = '';
                        var name = '';
                        var value = '';
                        var urlEncodedDataPairs = [];
                        var elements = block.querySelectorAll("input, select, textarea");
                        for (var i = 0; i < elements.length; ++i) {
                            element = elements[i];
                            if ('radio' === element.type) {
                                name = element.name + '_' + element.value;
                                value = 0;
                                if (element.checked) {
                                    value = 1;
                                }
                            } else {
                                name = element.name;
                                value = element.checked ? 1 : element.value;
                            }
                            urlEncodedDataPairs.push(encodeURIComponent(name) + '=' + encodeURIComponent(value));
                        }
                        this.data = urlEncodedDataPairs.join('&').replace(/%20/g, '+');
                    }
                }
                /*
                parseResponse: function (response) {
                    var result = JSON.parse(response);
                    if (!result['success']) {
                        var block = document.getElementById(PAW.form.fid).querySelector('#paw_message') || false;
                        if (block) {
                            var message = '';
                            for (var i = 0; i < result['messages'].length; ++i) {
                                message += '<div class="paw-text-row">' + result['messages'][i] + '</div>';
                            }
                            block.innerHTML = message;
                        } else {
                            alert(result['messages'].join("\r"));
                        }
                        return false;
                    }
                    if (result['data']) {
                        var paw_div = document.createElement('div');
                        paw_div.innerHTML = result['data'];
                        var el = document.getElementById(PAW.form.fid).parentNode;
                        el.appendChild(paw_div);
                        el.querySelector('#paw_mnt_form').submit();
                    }
                }
                */
            },
            callbacks: {
                resTnsnOnline: function (resp) {
                    if (resp.success) {
                        BootstrapDialog.alert({
                            title: 'Success',
                            message: resp.msg,
                            type: BootstrapDialog.TYPE_INFO,
                            size: BootstrapDialog.SIZE_LARGE,
                            closable: true
                        });
                        $('input', $('#tnsn_online')).val('');
                    } else {
                        BootstrapDialog.alert({
                            title: 'Error',
                            message: resp.msg,
                            type: BootstrapDialog.TYPE_DANGER,
                            size: BootstrapDialog.SIZE_LARGE,
                            closable: true
                        });
                        $('button', $('#tnsn_online'))
                            .prop('disabled', false)
                            .removeClass('disabled');
                    }
                    $('.overlay', this.tnsnOnlineForm).hide();
                },

                resGetContractInfo: function (resp) {
                    if (resp.success) {
                        $('#abi', $('#contract_interact')).val(resp.data.contract.abi);
                    } else {
                        BootstrapDialog.alert({
                            title: 'Error',
                            message: resp.msg,
                            type: BootstrapDialog.TYPE_DANGER,
                            size: BootstrapDialog.SIZE_LARGE,
                            closable: true
                        });
                    }

                    let buttons = $('#step1 button', $('#contract_interact'));
                    if ($('#step1 form', $('#contract_interact')).valid()) {
                        buttons
                            .prop('disabled', false)
                            .removeClass('disabled');
                    } else {
                        buttons
                            .prop('disabled', true)
                            .addClass('disabled');
                    }
                    $('.overlay', $('#contract_interact')).hide();
                },

                resInteractContract: function (resp, waitingInResponse) {
                    let fieldName = '';
                    let result = '';
                    waitingInResponse = JSON.parse(waitingInResponse) || [];
                    switch (waitingInResponse.length) {
                        case 0:
                            break;
                        case 1:
                            resp.data = JSON.parse(resp.data) || [];
                            for(let i = 0; i < waitingInResponse.length; i ++){
                                fieldName = waitingInResponse[i].name || false;
                                if(fieldName){
                                    if(fieldName.length){
                                        if (resp.data.hasOwnProperty(fieldName)) {
                                            result = resp.data[fieldName];
                                        }
                                    } else {
                                        result = resp.data;
                                    }
                                }
                            }
                            break;
                        default:
                            resp.data = JSON.parse(resp.data) || [];


                            console.log(resp.data);


                            for(let i = 0; i < waitingInResponse.length; i ++){
                                fieldName = waitingInResponse[i].name || false;
                                if(fieldName){

                                    console.log('fieldName = '+fieldName);
                                    console.log('fieldName length = '+fieldName.length);

                                    if(fieldName.length){
                                        if (resp.data.hasOwnProperty(fieldName)) {
                                            result += fieldName+': '+resp.data[fieldName]+', ';


                                            console.log(result);


                                        }
                                    } else {
                                        console.log('Сюда заходить не должен; > 1.');
                                    }
                                }
                            }
                    }

                    if (resp.success) {
                        $('#interacting_result', $('#contract_interact')).val(result);
                    } else {
                        BootstrapDialog.alert({
                            title: 'Error',
                            message: resp.msg,
                            type: BootstrapDialog.TYPE_DANGER,
                            size: BootstrapDialog.SIZE_LARGE,
                            closable: true
                        });
                    }
                    $('button', $('#contract_interact'))
                        .prop('disabled', false)
                        .removeClass('disabled');
                    $('.overlay', $('#contract_interact')).hide();
                }
            },
            utility: {
                extend: function (defaults, options) {
                    var extended = {};
                    var prop;
                    for (prop in defaults) {
                        if (Object.prototype.hasOwnProperty.call(defaults, prop)) {
                            extended[prop] = defaults[prop];
                        }
                    }
                    for (prop in options) {
                        if (Object.prototype.hasOwnProperty.call(options, prop)) {
                            extended[prop] = options[prop];
                        }
                    }
                    return extended;
                },
                copy: function (selector) {
                    try {
                        var range, selection;
                        if (document.body.createTextRange) {
                            range = document.body.createTextRange();
                            range.moveToElementText(selector);
                            range.select();
                        } else if (window.getSelection) {
                            selection = window.getSelection();
                            range = document.createRange();
                            range.selectNodeContents(document.getElementById(selector));
                            selection.removeAllRanges();
                            selection.addRange(range);
                        }
                        document.execCommand('copy');

                        if (window.getSelection) {
                            window.getSelection().removeAllRanges();
                        } else if (document.selection) {
                            document.selection.empty();
                        }
                        toastr['info']('Copied');
                    } catch (e) {
                        toastr['warning']("Automatic copying is not supported in your browser. Update your browser to the latest version or select the text manually and copy it.");
                        console.log(e);
                    }
                },
                getRandomInt: function(min, max) {
                    min = min || 100;
                    max = max || 1000000;
                    return Math.floor(Math.random() * (max - min + 1)) + min;
                }
    },
            transaction: {
                online: {
                    checkReady: function () {
                        $('#amount').on('change', function () {
                            alert($(this).val());
                        })
                    }
                },
                offline: {}
            }
        };

        var showSendedOfflineTransaction = new BootstrapDialog({
            title: 'Signed Transaction',
            closable: true,
            closeByBackdrop: false,
            closeByKeyboard: true,
            size: BootstrapDialog.SIZE_LARGE,
            message: getSendedOfflineTransactionDlgContent(),
            buttons: [{
                id: 'continue',
                label: 'Copy and Continue',
                cssClass: 'btn btn-success autocopy',
                data: {'iz3-need-copy': 'tnsn_id'},
                action: function (dialogRef) {
                    dialogRef.close();
                }
            }],
            onshow: function (dialogRef) {
            },
            onshown: function (dialogRef) {
            },
        });

        function getSendedOfflineTransactionDlgContent() {
            return '' +
                '<div class="container-fluid tnsn-offline-result">' +
                '<h4>Signed Transaction</h4>' +
                '<div class="row">' +
                '<div class="col-md-12 col-xs-12">' +
                '<div id="tnsn_id" class="tnsn_block" style="word-break: break-word;">' +
                '<code></code>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<h4>Scan QR code</h4>' +
                '<div class="row">' +
                '<div class="col-md-4 hidden-xs">' +
                '</div>' +
                '<div class="col-md-4 col-xs-12 text-center">' +
                '<div id="qrcode">' +
                '</div>' +
                '<div style="font-size: 15px; margin-top: 10px;">or<br /><a href="#" id="download">Download JSON</a></div>' +
                '</div>' +
                '<div class="col-md-4 hidden-xs">' +
                '</div>' +
                '</div>' +
                '<h4>Raw</h4>' +
                '<div class="row">' +
                '<div class="col-md-12 col-xs-12">' +
                '<div id="tnsn_row" class="tnsn_block" style="word-break: break-word;">' +
                '<code style="color: darkgrey;"></code>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
        }
    })();

    /*
    function encode( s ) {
        var out = [];
        for ( var i = 0; i < s.length; i++ ) {
            out[i] = s.charCodeAt(i);
        }
        return new Uint8Array( out );
    }
    */
});