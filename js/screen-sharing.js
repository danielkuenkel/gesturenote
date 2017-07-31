/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var screenSharingRecorder = null;
var recordedChunks = [];
var screen = null;
function ScreenSharing(roomId, recording) {
    sharing = this;

    screen = new Screen(roomId); // argument is optional

    if (recording && recording === true) {

        screen.onaddstream = function (event) {
            console.log('on add stream', event);
            screenSharingRecorder = new MediaRecorder(event.stream);

            screenSharingRecorder.ondataavailable = function (event) {
                console.log('on data available');
                recordedChunks.push(event.data);
            };

            screenSharingRecorder.onstop = function (event) {
                console.log('Stopped and save recording, state = ' + screenSharingRecorder.state + ', ' + new Date());
                if (saveSharedScreenRecording) {
                    var filename = hex_sha512(new Date().getTime() + "" + chance.natural()) + '.webm';
                    uploadQueue.upload(chunks, filename, getCurrentPhase().id);
                }

                chunks = [];

                if (stopSharingCallback) {
                    stopSharingCallback();
                }
            };

            screenSharingRecorder.onstart = function () {
                console.log('Start recording ... ' + new Date());
            };

            screenSharingRecorder.onerror = function (event) {
                console.log('Error: ', event);
            };

            screenSharingRecorder.onwarning = function (event) {
                console.log('Warning: ' + event);
            };
            screenSharingRecorder.start(5000);
        };
    }

    screen.onuserleft = function (event) {
        console.log('on user left', event);
    };

    screen.check();
}

var stopSharingCallback = null;
var saveSharedScreenRecording = false;
ScreenSharing.prototype.stop = function (callback, save) {
    saveSharedScreenRecording = save;
    screen.leave();

    if (screenSharingRecorder && screenSharingRecorder.state !== 'inactive') {
        stopSharingCallback = null;
        if (callback) {
            stopSharingCallback = callback;
        }
        screenSharingRecorder.stop();
    } else if (callback) {
        callback();
    }
};

ScreenSharing.prototype.start = function () {
    screen.share();
};