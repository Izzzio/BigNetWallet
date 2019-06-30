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
        });

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