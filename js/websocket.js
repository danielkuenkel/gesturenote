var client = null;
function initWebSocket(debug) {
    if (window.WebSocket && getBrowser() === BROWSER_FIREFOX) {
        var url = APOLLO_URL;
        var login = APOLLO_LOGIN;
        var passcode = APOLLO_PASSWORD;

        try {
            client = Stomp.client(url);
        } catch (error) {
            console.log(error);
        }


        if (client && !client.connected) {
        } else {
            return false;
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
            client.subscribe(APOLLO_DESTINATION, function (message) {
                handleWebsocketRequest(message);
            });
        });
        return false;
    } else {
        console.warn("Your browser does not support WebSockets. This example will not work properly.<br>\
            Please use a Web Browser with WebSockets support (WebKit or Google Chrome).");
    }
}

function sendGesture(gestureId) {
    if (client) {
        client.send(APOLLO_DESTINATION, {}, JSON.stringify({
            messageId: gestureId
        }));

        client.debug("send gesture: " + gestureId);
    } else {
        console.warn('no stomp client');
    }
}

function sendContinuousGesture(gestureId, value) {
    if (client) {
        client.send(APOLLO_DESTINATION, {}, JSON.stringify({
            messageId: gestureId,
            value: value
        }));
    } else {
        console.warn('no stomp client');
    }
}

function sendContinuousPosition(gestureId, type, relPosX, relPosY, isClick) {
    if (client) {
        client.send(APOLLO_DESTINATION, {}, JSON.stringify({
            messageId: gestureId,
            relPosX: relPosX,
            relPosY: relPosY,
            type: (type === PIDOCO_TYPE_MOUSE_SIMULATION ? PIDOCO_TYPE_MOUSE_SIMULATION : ''),
            isClick: isClick
        }));
    } else {
        console.warn('no stomp client');
    }
}


function sendContinuousPGPosition(gestureId, type, relPosX, relPosY, isClick) {
    if (client) {
        var positionType = "mouseSimulation";
        client.send(APOLLO_DESTINATION, {}, JSON.stringify({
            messageId: gestureId,
            relPosX: relPosX,
            relPosY: relPosY,
            type: (type ===  positionType? PIDOCO_TYPE_MOUSE_SIMULATION : ''),
            isClick: isClick
        }));
    } else {
        console.warn('no stomp client');
    }
}


function handleWebsocketRequest(message) {
    var jsonObj = JSON.parse(message.body);
    if (jsonObj.type === "event") {
        var gestureId = findGestureForMapping(jsonObj.name);
        sendGesture(gestureId, false);
        triggerGestureVideo(gestureId);
    }
}

function destroyWebsocket() {
    if (client) {
        client.disconnect();
        client = null;
    }
}

function sendPGGesture(gestureId) {
    // if (parseInt(lastSentItem) === parseInt(gestureId)) {
    //     return false;
    // }
    if (client) {
        client.send(APOLLO_DESTINATION, {}, JSON.stringify({
            messageId: gestureId
        }));

        client.debug("send gesture: " + gestureId);
    } else {
        console.warn('no stomp client');
    }
    // var mappingArray = findMappingForGesture(gestureId);
    // var jsonString = "";
    // if (yakindu) {
    //     for (var i = mappingArray.length - 1; i >= 0; i--) {
    //         jsonString = '{"type":"event","name":"' + mappingArray[i] + '"}';

    //         client.send('/topic/model.simulation.in', {
    //             "content-type": "text/plain"
    //         }, jsonString);
    //         client.debug("send mapping: " + jsonString);
    //     }
    // }
    // triggerGestureVideo(gestureId);
    // lastSentItem = parseInt(gestureId);
    // clearInterval(sentItemIntervall);
    // sentItemIntervall = setInterval(function() {
    //     lastSentItem = null;
    //     clearInterval(sentItemIntervall);
    // }, intervall);
    // return true;
}


function sendContinuousPGGesture(gestureId, value) {
    if (client) {
        client.send(APOLLO_DESTINATION, {}, JSON.stringify({
            messageId: gestureId,
            value: value
        }));
    } else {
        console.warn('no stomp client');
    }

    // var mappingArray = findMappingForGesture(gestureId);
    // var jsonString = "";
    // if (yakindu) {
    //     for (var i = mappingArray.length - 1; i >= 0; i--) {
    //         jsonString = '{"type":"event","name":"' + mappingArray[i] + '","value":' + parseInt(value) + '}';

    //         client.send('/topic/model.simulation.in', {
    //             "content-type": "text/plain"
    //         }, jsonString);
    //         client.debug("send mapping: " + jsonString);
    //     }
    // }

    // lastSentItem = parseInt(gestureId);
    // sentItemIntervall = setInterval(function() {
    //     lastSentItem = null;
    //     clearInterval(sentItemIntervall);
    // }, intervall);

}