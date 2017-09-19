/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var STATUS_UNINITIALIZED = 'uninitialized';
var STATUS_INITIALIZED = 'initialized';
var STATUS_STOPPED = 'stopped';
var STATUS_STARTED = 'started';

ScreenSharing.prototype.status = STATUS_UNINITIALIZED;

var screenSharingRecorder = null;
var recordedChunks = [];
var screen = null;
function ScreenSharing(roomId, recording) {
    sharing = this;
    if (!screen) {
        screen = new Screen(roomId); // argument is optional
    } else {
        screen.check();
        return false;
    }

    screen.onaddstream = function (event) {
        console.log('on add stream', event);

        if (recording && recording === true) {
            screenSharingRecorder = new MediaRecorder(event.stream);
            screenSharingRecorder.ondataavailable = function (event) {
                console.log('on data available');
                recordedChunks.push(event.data);
            };

            screenSharingRecorder.onstop = function (event) {
                console.log('Stopped and save recording, state = ' + screenSharingRecorder.state + ', ' + new Date());
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
        }

        sharing.status = STATUS_STARTED;
        $(sharing).trigger('started');
    };

    screen.onuserleft = function (event) {
        sharing.status = STATUS_STOPPED;
        $(sharing).trigger('stopped');
        console.log('on user left', event);
    };

    screen.check();
    this.status = STATUS_INITIALIZED;
}

var stopSharingCallback = null;

ScreenSharing.prototype.stop = function () {
    screen.leave();
//    screen = null;

    if (screenSharingRecorder && screenSharingRecorder.state !== 'inactive') {
        screenSharingRecorder.stop();
    }

    sharing.status = STATUS_STOPPED;
    $(sharing).trigger('stopped');
};

ScreenSharing.prototype.start = function () {
    screen.share();
};

ScreenSharing.prototype.upload = function (callback) {
    var filename = hex_sha512(new Date().getTime() + "" + chance.natural()) + '.webm';
    uploadQueue.upload(recordedChunks, filename, getCurrentPhase().id);

    recordedChunks = [];

    if (callback) {
        callback();
    }
};