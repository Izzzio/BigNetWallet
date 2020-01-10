if (window.addEventListener) {
    window.addEventListener("message", DappListener);
} else {
    window.attachEvent("onmessage", DappListener);
}

class dapps {

    constructor(contractAddress, contract) {
        this.contract = {
            addr: contractAddress || 0,
            code: contract.code || false,
            methods: {
                info: contract.infoMethods || [],
                deploy: contract.deployMethods || [],
            }
        };
    }

    init() {
        this.contract.code = '\
        <meta charset="utf-8">\
        <meta http-equiv="X-Frame-Options" value="sameorigin">\
        <script type="text/javascript" src="/themes/default/plugins/jquery-i18next/jquery-i18next.min.js"><\/script>\
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/i18next/15.0.5/i18next.min.js"><\/script>\
        '+ this.contract.code;

        /*
        if($("idModalCSS"))
        {
            this.contract.code += $("idModalCSS").outerHTML;
            this.contract.code += $("idOverlay").outerHTML;
            this.contract.code += $("idConfirm").outerHTML;
        }
        */

        $('#dapps_wrapper', $('#dapps')).html(
            $('<iframe>', {
                srcdoc: this.contract.code,
                sandbox: 'allow-scripts',
                referrerpolicy: 'same-origin',
                id: 'dapp_content',
                name: 'dapp_content'
            })
        );
    }
}

function DappListener(event)
{

}