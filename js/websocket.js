function initWebSocket() {
    if (window.WebSocket) {
        var url = APOLLO_URL;
        var login = APOLLO_LOGIN;
        var passcode = APOLLO_PASSWORD;

        try {
            client = Stomp.client(url);
//            $('#showWebsocket').removeClass('list-group-item-danger');
//            $('#showWebsocket').removeClass('list-group-item-info');
//            $('#showWebsocket').addClass('list-group-item-success');
        } catch (error) {
            console.log(error);
//            $('#showWebsocket').removeClass('list-group-item-info');
//            $('#showWebSocket').removeClass('list-group-item-success');
//            $('#showWebsocket').addClass('list-group-item-danger');
        }

//        console.log(client);

        if (!client.connected) {
//            $('#showWebsocket').removeClass('list-group-item-info');
//            $('#showWebSocket').removeClass('list-group-item-success');
//            $('#showWebsocket').addClass('list-group-item-danger');
        }

        // this allows to display debug logs directly on the web page
        client.debug = function (str) {
            console.log(str);
            $("#debug").append(str + "\n");
        };

        var headers = {
            login: login,
            passcode: passcode,
            "content-type": "text/plain"
        };

        // the client is notified when it is connected to the server.
        client.connect(headers, function (frame) {
            console.log('Frame: ' + frame);
//            $('#showWebsocket').removeClass('list-group-item-danger');
//            $('#showWebsocket').removeClass('list-group-item-info');
//            $('#showWebsocket').addClass('list-group-item-success');
            client.debug("connected to Stomp");
            client.subscribe('/topic/model.simulation.out', function (message) {
                handleWebsocketRequest(message);
            });
        });
        return false;
    } else {
        console.warn("Your browser does not support WebSockets. This example will not work properly.<br>\
            Please use a Web Browser with WebSockets support (WebKit or Google Chrome).");
//        appendAlert($('#alerts-body'), ALERT_NO_WEBSOCKETS);
//        $("#connect")
//                .html(
//                        "\
//            <h1>Get a new Web Browser!</h1>\
//            <p>\
//            Your browser does not support WebSockets. This example will not work properly.<br>\
//            Please use a Web Browser with WebSockets support (WebKit or Google Chrome).\
//            </p>\
//        ");
    }
}

function sendGesture(gestureId, yakindu) {
    client.send(APOLLO_DESTINATION, {}, gestureId);
    client.send(APOLLO_DESTINATION, {}, JSON.stringify({
        messageId: gestureId
    }));

    client.debug("send gesture: " + gestureId);
    var mapping = findMappingForGesture(gestureId);
    var jsonString = '{"type":"event","name":"' + mapping + '"}';
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