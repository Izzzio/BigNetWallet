$(function () {
    (function () {
        const wallet = {'address': false, 'main': {}};
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

        $('body').on('click', 'ul.sidebar-menu li', function(e){
            e.stopPropagation();
            let $this = $(this);
            $('ul.treeview-menu li').removeClass('active');
            if(!$this.parent().hasClass('treeview-menu')){
                $('ul.sidebar-menu li').removeClass('active');
            }
            $this.addClass('active');
            $('.box-wrapper').hide();
            let box = $this.attr('box') || false;
            if(box){
                $('#'+box).slideDown('normal');
            }
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
                        $.getJSON('login', {addr: wallet.address})
                            .done(function (resp) {
                                if (resp.success) {

                                    $('section.sidebar', $('body')).html(resp.data.menu);
                                    $('.content-wrapper', $('body')).html(resp.data.page);
                                    dialogRef.close();

                                    //window.history.pushState({"html":resp.data,"pageTitle":'TITLE 1'},"", '/interface/send-online');
                                    //window.location.replace("/send/online");

                                } else if ('DEMO' === resp.msg) {
                                    //document.body.innerHTML = resp.data;
                                    $('section.sidebar', $('body')).html(resp.data.menu);
                                    $('.content-wrapper', $('body')).html(resp.data.page);
                                    dialogRef.close();

                                    walletIZ3.setEventListeners();

                                    //window.history.pushState({"html":resp.data,"pageTitle":'TITLE 2'},"", '/interface/send-online');
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
            setEventListeners: function () {
                $('#tnsn_online form', $('body')).validate({
                    rules: {
                        type: {
                            required: true
                        },
                        amount: {
                            required: true
                        },
                        payee: {
                            required: true
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
                            required: 'This field is required'
                        }
                    },
                    highlight: function (element) {
                        $(element).addClass('error');
                    },
                    onkeyup: function (element) {
                        $(element).valid();
                        if ($('#tnsn_online form').valid()) {
                            $('button', $('#tnsn_online'))
                                .prop('disabled', false)
                                .removeClass('disabled');
                        } else {
                            $('button', $('#tnsn_online'))
                                .prop('disabled', true)
                                .addClass('disabled');
                        }
                    }
                });

                $('#tnsn_online .send').on('click', function () {
                    walletIZ3.HTTPRequest.init({
                        url: '/transaction/online',
                        method: 'POST',
                        data: $('#tnsn_online form').serialize() + '&addr=' + wallet.address
                    });
                    walletIZ3.HTTPRequest.send('resTnsnOnline');
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
                send: function (callback) {
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
                                walletIZ3.callbacks[callback](resp);
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
                            title: 'Result',
                            message: 'Transaction succesfull created',
                            type: BootstrapDialog.TYPE_INFO,
                            size: BootstrapDialog.SIZE_LARGE,
                            closable: true
                        });
                        $('button', $('#tnsn_online'))
                            .prop('disabled', true)
                            .addClass('disabled');
                        $('input', $('#tnsn_online')).val('');
                    } else if ('DEMO' === resp.msg) {
                        BootstrapDialog.alert({
                            title: 'Result',
                            message: 'Transaction succesfull created',
                            type: BootstrapDialog.TYPE_INFO,
                            size: BootstrapDialog.SIZE_LARGE,
                            closable: true
                        });
                        $('button', $('#tnsn_online'))
                            .prop('disabled', true)
                            .addClass('disabled');
                        $('input', $('#tnsn_online')).val('');
                    } else {
                    }
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