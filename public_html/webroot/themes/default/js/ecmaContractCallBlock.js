/**
 * ecmaContract block
 */
class ecmaContractCallBlock {
    /**
     * Create EcmaContract calling block
     * @param {string} address
     * @param {string} method
     * @param {Object} args
     * @param {Object} state
     */
    constructor(address, method, args, state) {
        this.data = '';
        this.sign = '';
        this.pubkey = '';
        this.type = 'EcmaContractCallBlock';

        this.address = address;
        this.method = method;
        this.args = args;
        this.state = state;
        this.generateData();
    }

    /**
     * Data hash for sign
     */
    generateData() {
        this.data = CryptoJS.SHA256(this.type + this.address + JSON.stringify(this.state) + JSON.stringify(this.args) + this.method).toString();
    }

    isSigned() {
        return this.sign.length !== 0;
    }
}