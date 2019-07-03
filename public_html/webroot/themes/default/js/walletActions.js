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
                    dialogRef.getModalContent().find('#startLogin').addClass('btn-success');
                    dialogRef.enableButtons(true);
                });
            },
        });

        if($('#login').length){
            walletOpenDlg.open();
        }

        function getDlgContent() {
            return '<button class="wallet-option">Click</button>';
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