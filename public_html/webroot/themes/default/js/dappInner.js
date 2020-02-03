(function () {
    dappInnerInst = {};
    document.addEventListener("DOMContentLoaded", function () {
        dappInnerInst = new dappInner();

        callMethod = (methodName, params, cb) => {
            let data = {cmd: "callMethod", methodName: methodName, params: params};
            dappInner.sendData(data, cb);
        };

        deployMethod = (methodName, params, cb) => {
            let data = {cmd: "deployMethod", methodName: methodName, params: params};
            dappInner.sendData(data, cb);
        }
    });

    let cbMap = {};
    let cbKey = 0;

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

        static sendData = (data, cb) => {
            if (!window.parent)
                return;
            if (cb) {
                cbKey++;
                data.callId = cbKey;
                cbMap[cbKey] = cb;
            }
            window.parent.postMessage(data, "*");
        };

        listenerEvents(event) {
            var data = event.data;
            if (!data || typeof data !== "object") {
                return;
            }
            var callId = data.callId;
            var cmd = data.cmd;
            if (callId) {
                let cb = cbMap[callId];
                if (cb) {
                    delete data.callId;
                    delete data.cmd;
                    switch (cmd) {
                        case "callMethod":
                            cb(data.resp);
                            break;
                        /*
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
                        */
                        default:
                            console.log("Error cmd: " + cmd);
                    }
                    delete cbMap[callId];
                }
            } else {
                /*
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
                */
            }
        }
    }
})();