$(function() {
    (function(){
        let wallet = {};
        $('#create').on('click', function () {
            wallet = iz3BitcoreCrypto.generateWallet();
        });

        $('#save_file').on('click', function () {
            download(
                JSON.stringify({'address': wallet.keysPair.public}),
                'UTC--' + ((new Date()).toISOString()) + '--' + wallet.keysPair.public,
                'text/plain'
            );
            $('#continue')
                .prop("disabled", false)
                .removeClass('disabled');
        });

        $('#continue').on('click', function () {
            $('#s_key').val(wallet.keysPair.private);
        });

        var walletOpenDlg = new BootstrapDialog({
            title: 'Access by Software',
            closable: true,
            closeByBackdrop: false,
            closeByKeyboard: true,
            size: BootstrapDialog.SIZE_LARGE,
            spinicon: 'fas fa-spinner fa-pulse',
            message: getDlgContent(),
            buttons: [{
                id: 'startLogin',
                label: ' Continue',
                cssClass: 'btn',
                action: function(dialogRef){
                    dialogRef.enableButtons(false);
                    dialogRef.setClosable(false);
                    var $button = this;
                    $button.spin();
                    setTimeout(function(){
                        dialogRef.close();
                    }, 10000);
                }
            }],
            onshow: function(dialogRef){
                dialogRef.enableButtons(false);
            },
            onshown: function(dialogRef){
                $('.wallet-option').on('click', function () {
                    let alreadySelected = false;
                    let modalContent = dialogRef.getModalContent();
                    if($(this).hasClass('selected')){
                        alreadySelected = true;
                    }
                    modalContent.find('.wallet-option').removeClass('selected');
                    modalContent.find('.sign-selected').addClass('hidden');
                    if(alreadySelected){
                        modalContent.find('#startLogin').removeClass('btn-success');
                        dialogRef.enableButtons(false);
                    } else {
                        $(this).addClass('selected');
                        $('.sign-selected', $(this)).removeClass('hidden');

                        modalContent.find('#startLogin').addClass('btn-success');
                        dialogRef.enableButtons(true);
                    }
                });
            },
        });

        if($('#login').length){
            walletOpenDlg.open();
        }

        function getDlgContent() {
            return '' +
                '<div class="col-md-12 col-xs-12 wallet-option">' +
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
                '<div class="col-md-12 col-xs-12 wallet-option">' +
                '<div class="col-md-2 col-xs-2 text-right">' +
                '<i class="fas fa-key fa-2x" style="color: #00a65a;"></i>' +
                '</div>' +
                '<div class="col-md-8 col-xs-8" style="margin-top: 5px;">' +
                'Private Key' +
                '</div>' +
                '<div class="col-md-2 col-xs-2 sign-selected hidden" style="margin-top: 7px;">' +
                '<i class="fas fa-check-circle" style="color: #00a65a;"></i>' +
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