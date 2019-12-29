class dapps {

    constructor(contractAddress, contract) {
        this.contract = {
            addr: contractAddress || 0,
            code: contract.code || false,
            methods: {
                info: contract.infoMethods || false,
                deploy: contract.deployMethods || false,
            }
        };
    }

    init() {
        $('#dapps_wrapper', $('#dapps')).html(
            $('<iframe>', {
                srcdoc: this.contract.code,
                sandbox: 'allow-scripts allow-modals',
                referrerpolicy: 'same-origin',
                frameborder: 0,
                id: 'dapps_content'
            })
        );
    }
}