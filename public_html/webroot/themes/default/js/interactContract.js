'use strict';

const contractInteractFields = {
    'main': {
        'checkContractAddress': {
            'fields': [
                {
                    'id': 'block',
                    'type': 'number',
                    'label': 'Contract address (block number)',
                    'rules': {
                        required: true,
                        number: true,
                        messages: {
                            required: 'This field is required',
                            number: "Please enter numbers only",
                        }
                    }
                }
            ]
        }
    }
};

const blockWithFieldTpl = '' +
    '<div class="row col-md-12">' +
    '<div class="col-md-7">' +
    '<div class="form-group form-group-lg">' +
    '<label for="%NAME%">%LABEL%</label>' +
    '<input type="%TYPE%" step="any" class="form-control without-arrow" name="%NAME%" id="%ID%" value="%VALUE%" placeholder="%PLACEHOLDER%">' +
    '</div>' +
    '</div>' +
    '</div>';


class interactContract {

    constructor() {
        //contract name
        this._name = '';

        //method name from contract
        this._methodName = '';
    }

    set name(name) {
        name = name || '';
        this._name = name;
    }

    set methodName(name) {
        name = name || '';
        this._methodName = name;
    }

    getAdditionalFields() {
        let fields = [];
        if (contractInteractFields[this._name]) {
            if (contractInteractFields[this._name][this._methodName]) {
                fields = contractInteractFields[this._name][this._methodName]['fields'];
            }
        }

        return fields;
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

    getFieldsForDelRulesValidation() {
        let result = [];
        for (let contractNameAsKey in contractInteractFields) {
            if (contractInteractFields.hasOwnProperty(contractNameAsKey)) {
                for (let methodNameAsKey in contractInteractFields[contractNameAsKey]) {
                    if (contractInteractFields[contractNameAsKey].hasOwnProperty(methodNameAsKey)) {
                        let fields = contractInteractFields[contractNameAsKey][methodNameAsKey]['fields'] ? contractInteractFields[contractNameAsKey][methodNameAsKey]['fields'] : [];
                        for (let i = 0; i < fields.length; i++) {
                            result.push(fields[i].id);
                        }
                    }
                }
            }
        }

        return result;
    }

    getFieldsForAddRulesValidation() {
        let result = [];
        for (let contractNameAsKey in contractInteractFields) {
            if (contractInteractFields.hasOwnProperty(contractNameAsKey)) {
                for (let methodNameAsKey in contractInteractFields[contractNameAsKey]) {
                    if (contractInteractFields[contractNameAsKey].hasOwnProperty(methodNameAsKey)) {
                        let fields = contractInteractFields[contractNameAsKey][methodNameAsKey]['fields'] ? contractInteractFields[contractNameAsKey][methodNameAsKey]['fields'] : [];
                        if (contractNameAsKey === this._name && methodNameAsKey === this._methodName) {
                            result = fields;
                            break;
                        }
                    }
                }
            }
        }

        return result;
    }
}