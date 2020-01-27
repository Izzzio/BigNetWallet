(function () {
    document.addEventListener("DOMContentLoaded", function () {
        window.dappInner = {};
        window.dappInner = new dappInner();
    });




    function test(methodName, params, f) {
        let data = {cmd: "test", methodName: methodName, params: params};
        dappInner.sendData(data, f);
    }
    test('methodTest', {'test': true, a: 3}, 'callbackFunction');




    function call(methodName, params, f) {
        let data = {cmd: "DappStaticCall", methodName: methodName, params: params};
        dappInner.sendData(data, f);
    }

    function sendCall(Account, MethodName, Params, FromNum) {
        if (!INFO.WalletCanSign) {
            SetError("PLS, OPEN WALLET");
            return 0;
        }
        var Data = {cmd: "DappSendCall", MethodName: MethodName, Params: Params, Account: Account, FromNum: FromNum};
        SendData(Data);
        return 1;
    }


    class dappInner {

        constructor() {
            this.init();
        }

        init() {
            let eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
            let eventer = window[eventMethod];
            let messageEvent = eventMethod === "attachEvent" ? "onmessage" : "message";
            eventer(messageEvent, this.listenerEvents);

            window.addEventListener('load', function () {
                /*
                UpdateDappInfo();
                setInterval(UpdateDappInfo, 1000);
                InitTranslater();
                */
            });
        }

        static sendData(data, f) {
            if (!window.parent)
                return;
            if (f) {
                glKeyF++;
                data.callId = glKeyF;
                glMapF[glKeyF] = f;
            }
            window.parent.postMessage(data, "*");
        }

        static listenerEvents(event) {
            var data = event.data;
            if (!data || typeof data !== "object") {
                return;
            }
            var callId = data.callId;
            var cmd = data.cmd;
            if (callId) {
                var F = glMapF[callId];
                if (F) {
                    delete data.callId;
                    delete data.cmd;
                    switch (cmd) {
                        case "translate":
                            F(Data.Str, Data.Str2);
                            break;
                        case "getstorage":
                        case "getcommon":
                            F(Data.Key, Data.Value);
                            break;
                        case "DappStaticCall":
                            F(Data.Err, Data.RetValue);
                            break;
                        case "DappInfo":
                            F(Data.Err, Data);
                            break;
                        case "DappWalletList":
                        case "DappAccountList":
                        case "DappSmartList":
                        case "DappBlockList":
                        case "DappTransactionList":
                            F(Data.Err, Data.arr);
                            break;
                        case "DappBlockFile":
                        case "DappSmartHTMLFile":
                            F(Data.Err, Data.Body);
                            break;
                        case "ComputeSecret":
                            F(Data.Result);
                            break;
                        default:
                            console.log("Error cmd: " + cmd);
                    }
                    delete glMapF[CallID];
                }
            } else {
                switch (cmd) {
                    case "History":
                        var eventEvent = new CustomEvent("History", {detail: Data});
                        window.dispatchEvent(eventEvent);
                        break;
                    case "OnEvent":
                        if (window.OnEvent) {
                            window.OnEvent(Data);
                        }
                        var eventEvent = new CustomEvent("Event", {detail: Data});
                        window.dispatchEvent(eventEvent);
                }
            }
        }
    }
})();