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
            namespaces: ['wallet_create', 'wallet_manage'],
            defaultNS: 'wallet_create'
        },
        resources: {
            en: {
                page: {
                    logo: {
                        big: "<b>iZ³</b> BigNet Wallets"
                    },
                    copyrights: "All rights reserved."
                },
                wallet_manage: {
                    block_main: {
                        header: 'Wallets',
                        btn: 'Create wallet'
                    }
                },
                wallet_create: {
                    menu: {
                        create: "Wallet create"
                    },
                    header: {
                        main: "Create New Wallet",
                        description1: "A wallet will be created - to manage tokens",
                        description2: "and a key - to access the wallet."
                    },
                    header2: {
                        main: "Save file",
                        description1: "Save your <span class='label label-danger'>Keystore</span> file."
                    },
                    header3: {
                        main: "Save key",
                        description1: "Save your <span class='label label-danger'>Private Key</span>."
                    },
                    fields: {
                        name: {
                            label: "Token name:",
                            placeholder: "MyToken",
                            help: "Enter name of the project without spaces, usually 5-25 symbols. Lower and uppercase can be used"
                        },
                        symbol: {
                            label: "Token symbol:",
                            placeholder: "NEW",
                            help: "Usually 3-4 Letters like ETH, BTC, NEO, WISH etc..."
                        },
                        decimals: {
                            label: "Decimals:",
                            help: "Defines the number of decimals for the token. 0-50 numerals are accepted. 18 as common practice"
                        },
                        type_1: {
                            label: "ERC-20",
                            help: "ERC-20 is recommended option. Accepted by the most exchanges."
                        },
                        type_2: {
                            label: "ERC-223",
                            help: "ERC-223 is almost the same as ERC-20. Provides extra safety during token transfers."
                        },
                        owner: {
                            label: "Token Owner:",
                            placeholder: "izM1Tr1nhKaeDMqUaZjHqaWzjZmCndnUhML",
                            help: "Owner or smart contract address. This address will be owner of the token. Double check the address (and access to it) before submission"
                        },
                        mint: {
                            label: "<i class='fas fa-plus-circle'></i>&nbsp;&nbsp;Mint tokens",
                            help: "You can reserve the tokens for Team, Bonuses, Bounties - these tokens will be created, but can’t be sold until token sale completion."
                        },
                        mint_new: {
                            label: "<i class='fas fa-plus-circle'></i>&nbsp;&nbsp;Mint tokens",
                            help: "You can reserve the tokens for Team, Bonuses, Bounties - these tokens will be created, but can’t be sold until token sale completion."
                        },
                        future_minting: {
                            label: "<i class='far fa-stop-circle text-primary'></i>&nbsp;&nbsp;Future Minting",
                            help: "Yes - you can create more tokens in the future.<br />No - no more tokens will be created in the future."
                        }
                    },
                    blocks: {
                        mint_new: {
                            address: {
                                label: "Address",
                                placeholder: "Enter address of the recipient's wallet"
                            },
                            name: {
                                label: "Name"
                            },
                            amount: {
                                label: "Token amount"
                            },
                            frozen: {
                                label: "<i class='far fa-snowflake text-primary'></i>&nbsp;&nbsp;Frozen until date (UTC)"
                            }
                        },
                    },
                    tkn_type: {
                        label: "Choose Type of Token",
                    },
                    mint_new: {
                        label: "Define address for tokens (after minting it will be sent to this address)"
                    },
                    button: {
                        create: "Create New Wallet",
                        save: "Download Keystore File (UTC / JSON)",
                        continue: "I understand. Continue.",
                        print_wallet: "Print Paper Wallet",
                        save_address: "View Your Address"
                    },
                    preview: {
                        label: "Result: contract token code",
                    },
                },
                addresses: {
                    menu: {
                        list: "Address"
                    }
                },
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
                interface: {

                },
            },
            ru: {
                eth_tkn_contract: {
                    menu: {
                        create: "Создать контракт"
                    },
                }
            }
        }
    }, (err, t) => {
        jqueryI18next.init(i18next, $);
        updateContent();

        $('.lang-select').click(function () {
            i18next.changeLanguage(this.innerHTML);
        });

        i18next.on('languageChanged', () => {
            updateContent();
        });
    });

    function updateContent() {
        $('.main-header').localize();
        $('.sidebar').localize();
        $('.content-wrapper').localize();
        $('.main-footer').localize();
        $('#mint_new_tpl').localize();
    }
});