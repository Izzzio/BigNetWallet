class dappOuter {

    constructor(contractAddress, contract) {
        this.contract = {
            addr: contractAddress || 0,
            code: contract.code || false,
            methods: {
                info: contract.infoMethods || [],
                deploy: contract.deployMethods || [],
            }
        };
    }

    init() {
        let eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
        let eventer = window[eventMethod];
        let messageEvent = eventMethod === "attachEvent" ? "onmessage" : "message";
        eventer(messageEvent, this.listenerEvents);

        this.createFrame();
    }

    createFrame() {
        this.contract.code = '\
        <meta charset="utf-8">\
        <meta http-equiv="X-Frame-Options" value="sameorigin">\
        <script type="text/javascript" src="/themes/default/plugins/jquery-i18next/jquery-i18next.min.js"><\/script>\
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/i18next/15.0.5/i18next.min.js"><\/script>\
        <script type="text/javascript" src="/themes/default/js/dappInner.js"></script>\
        ' + this.contract.code;

        /*
        if($("idModalCSS"))
        {
            this.contract.code += $("idModalCSS").outerHTML;
            this.contract.code += $("idOverlay").outerHTML;
            this.contract.code += $("idConfirm").outerHTML;
        }
        */

        $('#dapps_wrapper', $('#dapps')).html(
            $('<iframe>', {


                //onload: () => { alert('Iframe is loaded'); },


                srcdoc: this.contract.code,
                sandbox: 'allow-scripts',
                referrerpolicy: 'same-origin',
                id: 'dapp_content',
                name: 'dapp_content'
            })
        );
    }

    listenerEvents(event) {

        const sendMessage = (data) => {
            let frame = window.frames.dapp_content;
            if (!frame) {
                setTimeout(function () {
                    frame.postMessage(data, "*");
                }, 200);
                return;
            }
            frame.postMessage(data, "*");
        };

        console.log('------------------------------------');
        console.log(event);

        /*
        // if (event.origin !== 'http://the-trusted-iframe-origin.com') return;
        sendMessage('answer to iframe');
        // can message back using event.source.postMessage(...)
        */

        let data = event.data;
        if (!data || typeof data !== "object") {
            return;
        }
        /*
        var CurStorage = Storage;
        var CurSessionStorage = sessionStorage;
        if(EmulateStorage)
            CurStorage = EmulateStorage;
        if(EmulateSessionStorage)
            CurSessionStorage = EmulateSessionStorage;
        */
        switch (data.cmd) {
            case 'test': {
                data.resp = {'success': true, 'answer': 'tested'};

                sendMessage(data);
                break;
                //return;
            }
            /*
            case "DappStaticCall":
            {
                if(!Data.Account)
                    Data.Account = BASE_ACCOUNT.Num;
                DoGetData("DappStaticCall", {Account:Data.Account, MethodName:Data.MethodName, Params:Data.Params}, function (SetData)
                {
                    if(SetData)
                    {
                        Data.Err = !SetData.result;
                        Data.RetValue = SetData.RetValue;
                    }
                    else
                    {
                        Data.Err = 1;
                    }
                    SendMessage(Data);
                });
                break;
            }
            case "DappSendCall":
            {
                if(!Data.Account)
                    Data.Account = BASE_ACCOUNT.Num;
                if(!Data.FromNum)
                    Data.FromNum = 0;
                SendCallMethod(Data.Account, Data.MethodName, Data.Params, Data.FromNum, glSmart);
                break;
            }
            case "DappInfo":
            {
                DoDappInfo(Data);
                break;
            }
            case "DappWalletList":
                var Key = GetPubKey();
                Data.Params = {Smart:glSmart, Key:Key};
            case "DappSmartHTMLFile":
            case "DappBlockFile":
            case "DappAccountList":
            case "DappSmartList":
            case "DappBlockList":
            case "DappTransactionList":
            {
                if(Data.cmd === "DappBlockFile" && Data.Params.BlockNum <= CONFIG_DATA.CurBlockNum - MAX_DELTA_IGNORE_BUFFER)
                {
                    var StrKeyStorage = Data.Params.BlockNum + "-" + Data.Params.TrNum;
                    var Storage2 = CurSessionStorage;
                    var SavedTextData = Storage2[StrKeyStorage];
                    if(SavedTextData)
                    {
                        var SetData = JSON.parse(SavedTextData);
                        Data.Err = !SetData.result;
                        Data.arr = SetData.arr;
                        Data.Body = SetData.Body;
                        SendMessage(Data);
                        return ;
                    }
                }
                Data.Params.Session = glSession;
                DoGetData(Data.cmd, Data.Params, function (SetData,responseText)
                {
                    if(SetData)
                    {
                        Data.Err = !SetData.result;
                        Data.arr = SetData.arr;
                        Data.Body = SetData.Body;
                        SendMessage(Data);
                        if(StrKeyStorage && SetData.result)
                        {
                            Storage2[StrKeyStorage] = responseText;
                        }
                    }
                });
                break;
            }
            case "translate":
            {
                DoTranslate(Data);
                break;
            }
            case "setstorage":
            {
                CurStorage.setItem(DAPPPREFIX + DapNumber + "-" + Data.Key, JSON.stringify(Data.Value));
                break;
            }
            case "getstorage":
            {
                Data.Value = CurStorage.getItem(DAPPPREFIX + DapNumber + "-" + Data.Key);
                if(Data.Value && Data.Value !== "undefined")
                    try
                    {
                        Data.Value = JSON.parse(Data.Value);
                    }
                    catch(e)
                    {
                    }
                SendMessage(Data);
                break;
            }
            case "setcommon":
            {
                CurStorage.setItem(DAPPPREFIX + "COMMON-" + Data.Key, JSON.stringify(Data.Value));
                break;
            }
            case "getcommon":
            {
                Data.Value = CurStorage.getItem(DAPPPREFIX + "COMMON-" + Data.Key);
                if(Data.Value && Data.Value !== "undefined")
                    try
                    {
                        Data.Value = JSON.parse(Data.Value);
                    }
                    catch(e)
                    {
                    }
                SendMessage(Data);
                break;
            }
            case "SetStatus":
            {
                SetStatus(escapeHtml(Data.Message));
                break;
            }
            case "SetError":
            {
                SetError(escapeHtml(Data.Message));
                break;
            }
            case "CheckInstall":
            {
                CheckInstall();
                break;
            }
            case "SetLocationHash":
            {
                SetLocationHash("#" + Data.Message);
                break;
            }
            case "OpenLink":
            {
                var Path = Data.Message.substr(0, 200);
                if(IsLocalClient() && Path.substr(0, 6) === "/dapp/")
                    Path = "?dapp=" + Path.substr(6);
                OpenWindow(Path, 1);
                break;
            }
            case "ComputeSecret":
            {
                DoComputeSecret(Data.Account, Data.PubKey, function (Result)
                {
                    Data.Result = Result;
                    SendMessage(Data);
                });
                break;
            }
            case "SetMobileMode":
            {
                SetMobileMode();
                break;
            }
            case "CreateNewAccount":
            {
                CreateNewAccount(Data.Currency);
                break;
            }
            case "ReloadDapp":
            {
                ReloadDapp();
                break;
            }
            */
            default: {
                alert('Undefined action.');
            }
        }
    }
}