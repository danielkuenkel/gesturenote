function initWebSocket(debug) {
    if (window.WebSocket) {
        var url = APOLLO_URL;
        var login = APOLLO_LOGIN;
        var passcode = APOLLO_PASSWORD;

        try {
            client = Stomp.client(url);
        } catch (error) {
            console.log(error);
        }


        if (!client.connected) {
        }

        if (debug && debug === true) {
            // this allows to display debug logs directly on the web page
            client.debug = function (str) {
                console.log(str);
                $("#debug").append(str + "\n");
            };
        }

        var headers = {
            login: login,
            passcode: passcode,
            "content-type": "text/plain"
        };

        // the client is notified when it is connected to the server.
        client.connect(headers, function (frame) {
            console.log('Frame: ' + frame);
            client.debug("connected to Stomp");
            client.subscribe('/topic/model.simulation.out', function (message) {
                handleWebsocketRequest(message);
            });
        });
        return false;
    } else {
        console.warn("Your browser does not support WebSockets. This example will not work properly.<br>\
            Please use a Web Browser with WebSockets support (WebKit or Google Chrome).");
    }
}

function sendGesture(gestureId, yakindu) {
    client.send(APOLLO_DESTINATION, {}, gestureId);
    client.send(APOLLO_DESTINATION, {}, JSON.stringify({
        messageId: gestureId
    }));

    client.debug("send gesture: " + gestureId);
    if (yakindu) {
        client.send('/topic/model.simulation.in', {
            "content-type": "text/plain"
        }, jsonString);
        client.debug("send mapping: " + jsonString);
    }
}

function sendContinuousGesture(gestureId, value) {
    client.send(APOLLO_DESTINATION, {}, JSON.stringify({
        messageId: gestureId,
        value: value
    }));
    client.debug("send continuous gesture: " + gestureId + "value: " + value);
}


function handleWebsocketRequest(message) {
    var jsonObj = JSON.parse(message.body);
    if (jsonObj.type === "event") {
        var gestureId = findGestureForMapping(jsonObj.name);
        sendGesture(gestureId, false);
        triggerGestureVideo(gestureId);
    }
}