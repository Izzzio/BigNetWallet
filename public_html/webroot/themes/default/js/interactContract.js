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

    getAdditionalFieldsOfMethod(methodName){
        methodName = methodName || 'empty name method';
        let fields = [];

        for (let i = 0; i < this._abi.length; i++) {
            if (this._abi[i].hasOwnProperty('name') && methodName === this._abi[i].name) {
                if(this._abi[i].hasOwnProperty('constant') && !this._abi[i].constant){
                    fields = (this._abi[i].inputs || []);
                }
            }
        }

        return fields;
    }

    fieldToHTMLBlock(field) {
        field = field || [];
        field['label'] = field['label'] || field['name'] || '';
        field['type'] = field['type'] || 'text';
        field['name'] = field['name'] || '';
        let HTMLblock = blockWithFieldTpl;
        HTMLblock = HTMLblock.replace(/%LABEL%/g, field['label']);
        HTMLblock = HTMLblock.replace(/%TYPE%/g, field['type']);
        HTMLblock = HTMLblock.replace(/%NAME%/g, field['name']);
        HTMLblock = HTMLblock.replace(/%ID%/g, field['name']);
        HTMLblock = HTMLblock.replace(/%VALUE%/g, '');
        HTMLblock = HTMLblock.replace(/%PLACEHOLDER%/g, '');

        return HTMLblock;
    }
}