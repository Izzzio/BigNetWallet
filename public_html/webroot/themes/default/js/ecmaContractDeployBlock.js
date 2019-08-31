/**
 * ecmaContract block
 */
class ecmaContractDeployBlock extends signable {

    /**
     * Create EcmaContract block
     * @param {string} ecmaCode
     * @param {Object} state
     */
    constructor(ecmaCode, state) {
        super();
        this.type = 'EcmaContractDeployBlock';
        this.ecmaCode = ecmaCode;
        this.state = state;
        this.state.codeHash = CryptoJS.SHA256(this.ecmaCode).toString();
        this.generateData();
    }

    /**
     * Data hash for sign
     */
    generateData() {
        this.data = CryptoJS.SHA256(this.type + this.ecmaCode + JSON.stringify(this.state)).toString();
    }
}