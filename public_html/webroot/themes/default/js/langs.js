$(function () {
    'use strict';

    let langActve = sessionStorage.getItem('language') || 'en';

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
        lng: langActve,
        ns: {
            namespaces: ['index', 'main', 'logged_in'],
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
                    menu_top: {
                        lang_en: 'English',
                        lang_ru: 'Russian',
                        lang_en_short: 'EN',
                        lang_ru_short: 'RU',
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
                    menu_top: {
                        lang_en: 'Английский',
                        lang_ru: 'Русский',
                        lang_en_short: 'EN',
                        lang_ru_short: 'RU',
                    },
                    blocks: {
                        wallet: {
                            header: 'Кошельки',
                            btn: 'Создать кошелёк',
                        },
                    },
                },
                login: {
                    main: {
                        header: 'Открытие кошелька',
                        by_file_text: 'Файл-хранилище ключа',
                        by_key_text: 'Закрытый (приватный) ключ',
                        btn_continue: ' Продолжить',
                    },
                    by_file: {
                        header: 'Доступ по файлу-хранилищу ключа',
                        btn_select_file: 'Выбрать файл',
                        btn_login: ' Войти в кошелёк',
                        error_file: 'Ошибка файла-хранилища: ',
                        error_wrong_json: 'неверная структура JSON в файле',
                        error_wrong_key: 'Неверный приватный ключ. Перепроверьте файл-хранилище и попробуйте снова.',
                    },
                    by_key: {
                        header: 'Доступ по приватному ключу',
                        key_placeholder: 'Введите приватный ключ',
                        btn_login: ' Войти в кошелёк',
                        error1: 'Неверный приватный ключ. Перепроверьте ключ и попробуйте снова.',
                    },
                },
                logged_in: {
                    menu: {
                        tnsn_send: 'Транзакции',
                        tnsn_online: 'ОНлайн',
                        tnsn_offline: 'ОФлайн',
                        dapps: 'Приложения (Dapps)',
                        contract: 'Смарт-контракты',
                        contract_interact: 'Работа с контрактом',
                        contract_deploy: 'Добавить контракт в сеть',
                    },
                    blocks: {
                        address: {
                            label: 'Адрес',
                            icon_copy: 'Копировать',
                        },
                        balance: {
                            label: 'Баланс',
                            icon_refresh: 'Обновить баланс',
                        },
                        network: {
                            label: 'Сеть',
                            last_block: 'Последний блок# : ',
                            title: 'Открыть список сетей',
                            btn_change: 'Изменить',
                        },
                    },
                },
                tnsn_send_online: {
                    header: '<strong>Новая транзакция ОНлайн</strong>',
                    contract_addr_label: 'Адрес контракта',
                    contract_addr_placeholder: 'Введите адрес контракта',
                    btn_find_tokens: 'Найти',
                    dscr_find_tokens: "Найдёт токен и добавит его в поле 'Тип'. Токен из смарт-контракта. Контракт из блока с номером 'Адрес смарт-контракта'.",
                    tkn_type_label: 'Тип',
                    tkn_amount_label: 'Количество',
                    tkn_amount_max_label: 'максимум: ',
                    tkn_to_addr_label: 'Адрес получателя',
                    sub_header: 'Расширенные параметры',
                    data_add_label: 'Дополнительные данные',
                    btn_send: 'Отправить транзакцию',
                    tkn_type_exist: 'Тип токена уже существует',
                    tkn_type_added: 'Тип токена успешно добавлен',
                },
                tnsn_send_offline: {
                    header: '<strong>Новая транзакция ОФлайн</strong>',
                    tkn_type_label: 'Тип',
                    tkn_amount_label: 'Количество',
                    tkn_amount_placeholder: 'Сколько токенов отправить',
                    tkn_to_addr_label: 'Адрес получателя',
                    tkn_to_addr_placeholder: 'Введите адрес пожалуйста',
                    data_label: 'Данные',
                    btn_import_json: 'Импорт из JSON',
                    btn_generate_tnsn: 'Создать транзакцию',
                    import_success: 'Файл успешно импортирован',
                    error: {
                        file_too_big: 'Слишком большой размер файла. Импорт невозможен.',
                        no_parsed: 'Ошибка при разборе JSON: ',
                    },
                    tnsn_generated: {
                        header: 'Подписанная транзакция',
                        tnsn_signed_label: 'Подписанная транзакция',
                        tnsn_qr_code_label: 'Сканировать QR код',
                        tnsn_in_json: 'Скачать в формате JSON',
                        tnsn_raw_label: 'Поля',
                        btn_continue: 'Скопировать и продолжить',
                    },
                },
                dapps: {
                    header: '<strong>Децентрализованные приложения</strong>',
                    contract_addr_label: 'Блок с веб-контрактом',
                    contract_addr_placeholder: 'Введите номер блока',
                    btn_get_app: 'Получить приложение',
                    app_content_info: '<strong>Здесь будет показано приложение, когда вы загрузите его.</strong>',
                    error: {
                        not_found: 'Не найдено приложение в контракте',
                    },
                },
                contract_interact_s1: {
                    header: '<strong>Взаимодействие с добавленным смарт-контрактом</strong>',
                    contract_name_label: 'Имя контракта',
                    contract_addr_label: 'Адрес контракта',
                    contract_addr_placeholder: 'Введите адрес контракта',
                    abi_interface_label: 'ABI/JSON интерфейс',
                    btn_continue: 'Продолжить',
                },
                contract_interact_s2: {
                    info: 'Чтение/Запись смарт-контракта - ',
                    contract_addr_label: 'Адрес контракта',
                    contract_action_label: 'Выполнить действие',
                    addr: 'Адрес контракта (номер блока)',
                    to: 'Адрес получателя',
                    tokens: 'Количество токенов',
                    resources_label: 'Значение в ETH',
                    result_label: 'Результат',
                    btn_back: 'Назад',
                    btn_read: 'Читать',
                },
                contract_deploy: {
                    header: '<strong>Добавление нового контракта в сеть</strong>',
                    contract_code_label: 'Код смарт-контракта',
                    contract_rent_label: 'Аренда вычислительных ресурсов',
                    contract_rent_placeholder: 'Количество токенов за аренду ресурсов',
                    contract_rent_available_label: 'Доступные ресурсы',
                    contract_rent_available_min_label: 'минимальное количество ресурсов',
                    btn_calc_resource: 'Рассчитать',
                    btn_sign_tnsn: 'Подписать транзакцию',
                    confirm: {
                        header: 'Подтверждение',
                        addr_label: 'С адреса',
                        details_header: 'Детальная информация',
                        detail_network: 'Сеть',
                        btn_send: ' Подтвердить и отправить',
                        error1: 'Ошибка добавления транзакции в сеть. Пожалуйста, повторите позднее.',
                    },
                    success: {
                        header: 'Успешно',
                        description1: 'Транзакция отправлена в сеть',
                        btn_check_status: 'Проверить статус',
                        btn_ok: 'Ок',
                    },
                    error: {
                        sign_create: 'Ошибка создания подписи для транзакции. Пожалуйста, проверьте код контракта и повторите попытку.',
                    },
                },
                dialog_alerts: {
                    header_error: 'Ошибка',
                    header_success: 'Успешно',
                },
                copy_alerts: {
                    success: 'Скопировано',
                    error: 'Автоматическое копирование не поддерживается вашим браузером. Обновите браузер до последней версии или выделите текст вручную и скопируйте его',
                },
            }
        }
    }, (err, t) => {
        jqueryI18next.init(i18next, $);
        updateContent();

        $('.lang-item').on('click', function () {
            let lang = this.getAttribute('language');
            sessionStorage.setItem('language', lang);
            i18next.changeLanguage(lang);
            $.extend($.validator.messages, languages[lang]);
            $('li', $('ul.menu')).show();
            $( "li[language='"+lang+"']", $('ul.menu')).hide();
            $('#curr-language').text($.i18n.t('index:menu_top.lang_'+lang+'_short'));
        });

        i18next.on('languageChanged', () => {
            updateContent();
        });
    });

    function updateContent() {
        $('.wrapper').localize();
    }

    let languages = {
        en: {
            required: "This field is required",
            number: "Please enter numbers only",
            min: $.validator.format("Minimum value {0}."),
            minlength: "Wrong address: too short",
            alphanumeric: 'Only alpah and numeric symbols allowed',
            digits: "Please enter only digits",
            validJSON: "This field is required valid ABI/JSON",
            /*
            remote: "Please fix this field.",
            email: "Please enter a valid email address.",
            url: "Please enter a valid URL.",
            date: "Please enter a valid date.",
            dateISO: "Please enter a valid date ( ISO ).",
            creditcard: "Please enter a valid credit card number.",
            equalTo: "Please enter the same value again.",
            maxlength: $.validator.format("Please enter no more than {0} characters."),
            rangelength: $.validator.format("Please enter a value between {0} and {1} characters long."),
            range: $.validator.format("Please enter a value between {0} and {1}."),
            max: $.validator.format("Please enter a value less than or equal to {0}."),
            integer: "Please enter a positive or negative integer.",
            lettersonly: "Please enter only alphabetic characters.",
            letterswithbasicpunc: "Please enter the letters or punctuation.",
            dateRU: "Please type the date in the format 01.12.2014",
            phoneRU: "Please enter a phone number in a format +38XXXXXXXXXX",
            require_from_select: "Please select from the list value",
            equal: "The value entered not match the required",
            require_if_select: $.validator.format('This field must be filled, if selected "{0}".'),
            edrpou: "Please enter the correct code EDRPOU",
            cents_for_dollar: "Please enter the correct number of cents",
            minlength_with_cleaning: $.validator.format("Please enter at least {0} characters."),
            required_with_cleaning: "This field is required."
            */
        },
        ru: {
            required: "Это поле необходимо заполнить",
            number: "Пожалуйста, введите число",
            min: $.validator.format("Минимальное значение {0}."),
            minlength: "Неверный адрес: очень короткий",
            alphanumeric: "азрешены только буквы и цифры",
            digits: "Пожалуйста, вводите только цифры",
            validJSON: "Пожалуйста, введите корректный ABI/JSON",
            /*
            remote: "Пожалуйста, введите правильное значение.",
            email: "Пожалуйста, введите корректный адрес электронной почты.",
            url: "Пожалуйста, введите корректный URL.",
            date: "Пожалуйста, введите корректную дату.",
            dateISO: "Пожалуйста, введите корректную дату в формате ISO.",
            creditcard: "Пожалуйста, введите правильный номер кредитной карты.",
            equalTo: "Пожалуйста, введите такое же значение ещё раз.",
            extension: "Пожалуйста, выберите файл с правильным расширением.",
            maxlength: $.validator.format( "Пожалуйста, введите не больше {0} символов." ),
            rangelength: $.validator.format( "Пожалуйста, введите значение длиной от {0} до {1} символов." ),
            range: $.validator.format( "Пожалуйста, введите число от {0} до {1}." ),
            max: $.validator.format( "Пожалуйста, введите число, меньшее или равное {0}." ),
            */
        },
    };

    $.extend($.validator.messages, languages[langActve]);
    sessionStorage.setItem('language', langActve);
    $( "li[language='"+langActve+"']", $('ul.menu')).hide();
    $('#curr-language').text($.i18n.t('index:menu_top.lang_'+langActve+'_short'));
});