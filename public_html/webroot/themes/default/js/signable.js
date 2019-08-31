/**
 * Signable object
 * Many objects require a sign
 */
class signable {
    constructor() {
        this.data = '';
        this.sign = '';
        this.pubkey = '';
        this.type = 'Empty';
    }

    isSigned() {
        return this.sign.length !== 0;
    }
}