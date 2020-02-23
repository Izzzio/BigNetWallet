$(function () {
    'use strict';

    i18next.init({
        tName: 't', // --> appends $.t = i18next.t
        i18nName: 'i18n', // --> appends $.i18n = i18next
        handleName: 'localize', // --> appends $(selector).localize(opts);
        selectorAttr: 'data-i18n', // selector for translating elements
        targetAttr: 'i18n-target', // data-() attribute to grab target element to translate (if different than itself)
        optionsAttr: 'i18n-options', // data-() attribute that contains options, will load/set if useOptionsAttr = true
        useOptionsAttr: false, // see optionsAttr
        parseDefaultValueFromContent: true, // parses default values from content ele.val or ele.text

        debug: false,
        lng: 'en',
        ns: {
            namespaces: ['index', 'main', 'logged_in'],
            //namespaces: ['wallet_create', 'wallet_manage'],
            //defaultNS: 'wallet_create'
            defaultNS: 'index'
        },
        resources: {
            en: {
                main: {
                    header: {
                    },
                    footer: {
                        copyrights: 'All rights reserved.',
                    },
                    logo: {
                        big: '<b>iZ³</b> BigNet Wallets',
                        mini: '<b>iZ³</b>',
                    }
                },
                index: {
                    menu: {
                        wallet_create: 'Wallet create',
                        wallet_login: 'Address',
                    },
                    blocks: {
                        wallet: {
                            header: 'Wallets',
                            btn: 'Create wallet',
                        },
                    },
                },
                login: {
                    main: {
                        header: 'Access by Software',
                        by_file_text: 'Keystore File',
                        by_key_text: 'Private Key',
                        btn_continue: ' Continue',
                    },
                    by_file: {
                        header: 'Access by Keystore File',
                        btn_select_file: 'Select file',
                        btn_login: ' Access Wallet',
                        error_file: 'Keystore file error: ',
                        error_wrong_json: 'wrong JSON structure in file',
                        error_wrong_key: 'Wrong private key. Re-check file ant try again.',
                    },
                    by_key: {
                        header: 'Access by Private Key',
                        key_placeholder: 'Enter Private Key',
                        btn_login: ' Access Wallet',
                        error1: 'Wrong private key. Re-check key ant try again.',
                    },
                },
                logged_in: {
                    menu: {
                        tnsn_send: 'Send',
                        tnsn_online: 'Transaction ONline',
                        tnsn_offline: 'Transaction OFFline',
                        dapps: 'Dapps',
                        contract: 'Contract',
                        contract_interact: 'Work with contract',
                        contract_deploy: 'Deploy contract',
                    },
                    blocks: {
                        address: {
                            label: 'Address',
                            icon_copy: 'Copy',
                        },
                        balance: {
                            label: 'Balance',
                            icon_refresh: 'Refresh Balance',
                        },
                        network: {
                            label: 'Network',
                            last_block: 'Last block# : ',
                            title: 'Open Networks',
                            btn_change: 'Change',
                        },
                    },
                },
                tnsn_send_online: {
                    header: '<strong>Send transaction</strong>',
                    contract_addr_label: 'Contract address',
                    contract_addr_placeholder: 'Contract address',
                    btn_find_tokens: 'Find',
                    dscr_find_tokens: "Find token and add it into field 'Type'. Token from contract. Contract from block with number 'Contract address'.",
                    tkn_type_label: 'Type',
                    tkn_amount_label: 'Amount',
                    tkn_amount_max_label: 'max: ',
                    tkn_to_addr_label: 'To address',
                    sub_header: 'Advanced',
                    data_add_label: 'Add data',
                    btn_send: 'Send Transaction',
                    tkn_type_exist: 'Token type already exist',
                    tkn_type_added: 'Token type succesfull added',
                },
                tnsn_send_offline: {
                    header: '<strong>Send Offline</strong>',
                    tkn_type_label: 'Type',
                    tkn_amount_label: 'Amount',
                    tkn_amount_placeholder: 'Deposit Amount',
                    tkn_to_addr_label: 'To address',
                    tkn_to_addr_placeholder: 'Please Enter The Address',
                    data_label: 'Data',
                    btn_import_json: 'Import JSON',
                    btn_generate_tnsn: 'Generate Transaction',
                    import_success: 'File successfull imported',
                    error: {
                        file_too_big: 'File size is too big. Import impossible',
                        no_parsed: 'Error when trying to parse json: ',
                    },
                    tnsn_generated: {
                        header: 'Signed Transaction',
                        tnsn_signed_label: 'Signed Transaction',
                        tnsn_qr_code_label: 'Scan QR code',
                        tnsn_in_json: 'Download JSON',
                        tnsn_raw_label: 'RAW',
                        btn_continue: 'Copy and Continue',
                    },
                },
                dapps: {
                    header: '<strong>Decentralized Applications</strong>',
                    contract_addr_label: 'Block with Web contract',
                    contract_addr_placeholder: 'Enter Contract Block',
                    btn_get_app: 'Get app',
                    app_content_info: '<strong>Application will be shown here when you load it.</strong>',
                    error: {
                        not_found: 'Not found application in contract',
                    },
                },
                contract_interact_s1: {
                    header: '<strong>Interact with deployed Contract</strong>',
                    contract_name_label: 'Contract name',
                    contract_addr_label: 'Contract Address',
                    contract_addr_placeholder: 'Enter Contract Address',
                    abi_interface_label: 'ABI/JSON Interface',
                    btn_continue: 'Continue',
                },
                contract_interact_s2: {
                    info: 'Read/Write Contract - ',
                    contract_addr_label: 'Contract Address',
                    contract_action_label: 'Execute action',
                    addr: 'Contract address (block number)',
                    to: 'To',
                    tokens: 'Tokens count',
                    resources_label: 'Value in ETH',
                    result_label: 'Result',
                    btn_back: 'Back',
                    btn_read: 'Read',
                },
                contract_deploy: {
                    header: '<strong>Deploy new contract</strong>',
                    contract_code_label: 'Contract code',
                    contract_rent_label: 'Resource rent',
                    contract_rent_placeholder: 'Cost resources for deploy contract',
                    contract_rent_available_label: 'Resource available',
                    contract_rent_available_min_label: 'minimum amount of resources',
                    btn_calc_resource: 'Calculate',
                    btn_sign_tnsn: 'Sign Transaction',
                    confirm: {
                        header: 'Confirmation',
                        addr_label: 'From Address',
                        details_header: 'Detail Information',
                        detail_network: 'Network',
                        btn_send: ' Confirm and Send',
                        error1: 'Error sending transaction. Please try again later',
                    },
                    success: {
                        header: 'Success',
                        description1: 'Transaction sent to network',
                        btn_check_status: 'Check Status',
                        btn_ok: 'Okay',
                    },
                    error: {
                        sign_create: 'Error create signature for transaction. Please, check contract code and try again',
                    },
                },
                wallet_create: {
                    main: {
                        header: 'Create New Wallet',
                        description1: 'A wallet will be created - to manage tokens',
                        description2: 'and a key - to access the wallet.',
                        btn_create: 'Create New Wallet',
                    },
                    file: {
                        header: 'Save file',
                        description1: "Save your <span class='label label-danger'>Keystore</span> file.",
                        btn_download: 'Download Keystore File (UTC / JSON)',
                        btn_continue: 'I understand. Continue.',
                        help1_header: 'Do not lose it',
                        help1_text: 'It cannot be recovered if you lose it.',
                        help2_header: 'Do not share it.',
                        help2_text: 'Your funds will be stolen if you use this file on a malicious/phishing site.',
                        help3_header: 'Make a backup.',
                        help3_text: 'Secure it like the millions of dollars it may one day be worth.',
                    },
                    key: {
                        header: 'Save key',
                        description1: "Save your <span class='label label-danger'>Private Key</span>.",
                        btn_print: 'Print Paper Wallet',
                        btn_login: 'View Your Address',
                        help1_header: 'Do not lose it',
                        help1_text: 'It cannot be recovered if you lose it.',
                        help2_header: 'Do not share it.',
                        help2_text: 'Your funds will be stolen if you use this file on a malicious/phishing site.',
                        help3_header: 'Make a backup.',
                        help3_text: 'Secure it like the millions of dollars it may one day be worth.',
                    },
                },
                dialog_alerts: {
                    header_error: 'Error',
                    header_success: 'Success',
                },
                copy_alerts: {
                    success: 'Copied',
                    error: 'Automatic copying is not supported in your browser. Update your browser to the latest version or select the text manually and copy it.',
                },
                    /*
                wallet_unlock: {
                    header: {
                        main: "Unlock your wallet",
                        description1: "Unlock your wallet to see your address",
                        description2: "Your Address can also be known as you <strong><span class='text-danger'>Account #</span></strong> or your <strong><span class='text-danger'>Public Key</span></strong>. <br />It is what you share with people so they can send you Tokens. <br />Find the colorful address icon. Make sure it matches your paper wallet & whenever you enter your address somewhere.",
                        description3: "Select Your Wallet File",
                    },
                    button: {
                        select: "Select Wallet File",
                    },
                },
                */
            },
            ru: {
                main: {
                    header: {
                    },
                    footer: {
                        copyrights: "Все права защищены."
                    },
                    logo: {
                        big: "<b>iZ³</b> BigNet Wallets",
                        mini: "<b>iZ³</b>",
                    }
                },
                index: {
                    menu: {
                        wallet_create: "Создать кошелёк",
                        wallet_login: "Открыть кошелёк",
                    },
                },
                dapps: {
                    app_content_info: '<strong>Здесь будет показано приложение, когда вы загрузите его.</strong>',
                },
            }
        }
    }, (err, t) => {
        jqueryI18next.init(i18next, $);
        updateContent();

        $('.lang-item').on('click', function () {
            i18next.changeLanguage(this.getAttribute('language'));
        });

        i18next.on('languageChanged', () => {
            updateContent();
        });
    });

    function updateContent() {
        $('.wrapper').localize();
    }
});