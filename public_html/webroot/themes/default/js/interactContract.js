'use strict';

const blockWithFieldTpl = '' +
    '<div class="col-md-7">' +
    '<div class="form-group form-group-lg">' +
    '<label for="%NAME%">%LABEL%</label>' +
    '<input type="%TYPE%" step="any" class="form-control without-arrow" name="%NAME%" id="%ID%" value="%VALUE%" placeholder="%PLACEHOLDER%">' +
    '</div>' +
    '</div>';


class interactContract {

    constructor() {
        //ABI/JSON with methods from contract
        this._abi = '';
    }

    set abi(abi) {
        abi = JSON.parse(abi) || '';
        this._abi = abi;
    }

    getMethods(){
        let methods = [];
        for (let i = 0; i < this._abi.length; i++) {
            if (this._abi[i].hasOwnProperty('name')) {
                methods.push(this._abi[i].name);
            }

            /*
            for (let [key, value] of Object.entries(this._abi[i])) {
                name
                console.log(`${key}: ${value}`);
            }
            */

        }

        return methods;
    }

    async getHTMLBlocksWithAdditionalFields() {
        let result = [];
        let blockNew = '';
        let additionalFields = await this.getAdditionalFields();
        for (let i = 0; i < additionalFields.length; i++) {
            blockNew = blockWithFieldTpl;
            blockNew = blockNew.replace(/%LABEL%/g, additionalFields[i]['label']);
            blockNew = blockNew.replace(/%TYPE%/g, additionalFields[i]['type']);
            blockNew = blockNew.replace(/%NAME%/g, additionalFields[i]['id']);
            blockNew = blockNew.replace(/%ID%/g, additionalFields[i]['id']);
            blockNew = blockNew.replace(/%VALUE%/g, '');
            blockNew = blockNew.replace(/%PLACEHOLDER%/g, '');
            result.push(blockNew);
        }

        return result;
    }
}