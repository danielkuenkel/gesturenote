/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var STATUS_UNINITIALIZED = 'uninitialized';
var STATUS_INITIALIZED = 'initialized';
var STATUS_STOPPED = 1;
var STATUS_STARTED = 2;
var EVENT_FILE_SAVED = 'fileSaved';
var EVENT_ALL_FILES_UPLOADED = 'allFilesUploaded';

PeerConnection.prototype.status = STATUS_UNINITIALIZED;
PeerConnection.prototype.options = null;

var TYPE_MESSAGE_CONTROL = 'controlMessage';

var webrtc = null;
var connection = null;
//var syncPhaseStep = false;

function PeerConnection(isRecordingNeeded) {
    connection = this;
    if (isRecordingNeeded === true && isRecordingNeededInFuture()) {
        connection.initRecording();
    }
}

PeerConnection.prototype.initialize = function (options) {
    console.log('initialize peer connection');
    if (options) {
        this.options = options;
        webrtc = new SimpleWebRTC({
            // the id/element dom element that will hold "our" video
            localVideoEl: options.localVideoElement,
            // the id/element dom element that will hold remote videos
            remoteVideosEl: options.remoteVideoElement,
            // immediately ask for camera access
            autoRequestMedia: true, // immediately ask for camera access
            localVideo: {
                autoplay: true, // automatically play the video stream on the page
                mirror: true, // flip the local video to mirror mode (for UX)
                muted: true // mute local video stream to prevent echo
            },
            enableDataChannels: options.enableDataChannels ? true : false
        });

        webrtc.connection.on('message', function (data) {
//            if (data.type === TYPE_MESSAGE_CONTROL) {
//                console.log('PEERCONNECTION: on message', data.type, data.playload);

            $(connection).trigger(data.type, [data.payload]);
//            }
        });

        // we have to wait until it's ready
        webrtc.on('readyToCall', function () {
            if (connection.options.roomId !== undefined) {
                console.log('ready to call', connection.options.roomId);
                webrtc.joinRoom(connection.options.roomId);
            }

//            if (options.localStream.record === 'yes') {
//                connection.startRecording();
//            }
            if (!syncPhaseStep && connection.options.remoteStream.video === 'no') {
                connection.update(connection.options);
            }
        });

        // a peer video has been added
        webrtc.on('videoAdded', function (video, peer) {
            console.log('videoAdded');
            $(connection).trigger('videoAdded');
            if (!syncPhaseStep) {
                connection.update(connection.options);
            }
        });

        // a peer video has been added
        webrtc.on('videoRemoved', function (video, peer) {
            $(connection).trigger('videoRemoved');
            $('#local-stream').removeClass('rtc-shadow');
            connection.hideRemoteStream();

            if (connection.options.localStream.record === 'yes') {
                connection.stopRecording(null, false);
            }
        });

        // local p2p/ice failure
        webrtc.on('iceFailed', function (peer) {
            var pc = peer.pc;
            console.log('had local relay candidate', pc.hadLocalRelayCandidate);
            console.log('had remote relay candidate', pc.hadRemoteRelayCandidate);
            
            if (connection.options.localStream.record === 'yes') {
                connection.stopRecording(null, false);
            }
        });

        // remote p2p/ice failure
        webrtc.on('connectivityError', function (peer) {
            var pc = peer.pc;
            console.log('had local relay candidate', pc.hadLocalRelayCandidate);
            console.log('had remote relay candidate', pc.hadRemoteRelayCandidate);
            
//            if (options.localStream.record === 'yes') {
                connection.stopRecording(null, false);
//            }
        });


    }
};

$(window).on('resize', function () {
    var remoteHeight = $('.rtc-remote-container').find('video').height();
    var offset = 0;

    if (remoteHeight > 0) {
        offset = remoteHeight - $('#local-stream').height();
    }
//    console.log(remoteHeight, offset, $('#local-stream'));
    $('#local-stream').css({marginBottom: offset + 'px'});
});

function onTweenComplete() {
    $(window).resize();
}

PeerConnection.prototype.update = function (options) {
    this.status = STATUS_INITIALIZED;
    var currentOptions = this.options = options;
//    console.log(webrtc, options);
    if (webrtc) {
        if (currentOptions) {
//            console.log('update caller states', currentOptions);

            // check specific phase step constraints
            if (currentOptions.localStream.video === 'yes' && currentOptions.localStream.visualize === 'yes') {
                TweenMax.to($('#' + currentOptions.localVideoElement), .3, {opacity: 1.0});

                if (currentOptions.remoteStream.video === 'yes') {
                    $('#' + currentOptions.remoteVideoElement).removeClass('hidden');
                    $('#' + currentOptions.localVideoElement).addClass('rtc-shadow');
                    connection.showRemoteStream();
                } else {
                    $('#' + currentOptions.remoteVideoElement).addClass('hidden');
                    $('#' + currentOptions.localVideoElement).removeClass('rtc-shadow');
                    connection.hideRemoteStream();
                }
            } else {
                TweenMax.to($('#' + currentOptions.localVideoElement), .3, {opacity: 0});
                if (currentOptions.remoteStream.video === 'yes') {
                    TweenMax.to($('#' + currentOptions.remoteVideoElement), .3, {opacity: 1.0, onComplete: onTweenComplete});
                } else {
                    TweenMax.to($('#' + currentOptions.remoteVideoElement), .3, {opacity: 0, onComplete: onTweenComplete});
                }
            }

            // check if stream has to be recorded
            if (options.localStream.record === 'yes') {
                connection.startRecording();
            }
        } else {
            console.log('no options no states update');
        }
    } else {
        console.log('initilize caller');
        this.initialize(currentOptions);
    }
};

PeerConnection.prototype.joinRoom = function (roomId) {
    if (webrtc) {
        webrtc.joinRoom(roomId);
    }
};

PeerConnection.prototype.leaveRoom = function () {
    if (webrtc) {
        webrtc.leaveRoom();
    }
};

PeerConnection.prototype.sendMessage = function (message, payload) {
    if (webrtc) {
        console.log("SEND:", message, payload);
        webrtc.sendToAll(message, payload || null);
    }
};

PeerConnection.prototype.showRemoteStream = function () {
    var currentOptions = this.options;
    var width = Math.floor($('#' + currentOptions.remoteVideoElement).width() * .3);
    var height = Math.floor(width * 3 / 4);
    TweenMax.to($('#' + currentOptions.localVideoElement), .3, {delay: .6, width: width, height: height, left: 5, top: 5, ease: Quad.easeIn});
    TweenMax.to($('#' + currentOptions.remoteVideoElement), .3, {delay: .6, opacity: 1.0, onComplete: onTweenComplete});
};

PeerConnection.prototype.hideRemoteStream = function () {
    var currentOptions = this.options;
    TweenMax.to($('#' + currentOptions.localVideoElement), .3, {width: '100%', height: 'auto', left: 0, top: 0, ease: Quad.easeIn});
    TweenMax.to($('#' + currentOptions.remoteVideoElement), .3, {opacity: 0, onComplete: onTweenComplete});
};


/*
 * recording
 */
var chunks = [];
var recordingStream = null;
var mediaRecorder = null;
PeerConnection.prototype.initRecording = function () {
    if (!recordingStream) {
        // check current browser for building constraints
        if (getBrowser() == "Chrome") {
            var constraints = {"audio": true, "video": {"mandatory": {"minWidth": 320, "maxWidth": 320, "minHeight": 240, "maxHeight": 240}, "optional": []}};
        } else if (getBrowser() == "Firefox") {
            var constraints = {audio: true, video: {width: {min: 320, ideal: 320, max: 320}, height: {min: 240, ideal: 240, max: 240}}};
        }

        // set user media for specifig browsers
        navigator.getUserMedia = (navigator.getUserMedia ||
                navigator.mozGetUserMedia ||
                navigator.msGetUserMedia ||
                navigator.webkitGetUserMedia);
        if (navigator.getUserMedia) {
            navigator.getUserMedia(constraints, onSuccess, onError);
        } else {
            console.log('Sorry! This requires Firefox 30 and up or Chrome 47 and up.');
        }

        // media recorder functions
        function onError(error) {
            console.log(error);
        }

        function onSuccess(stream) {
            console.log('initRecorder');
            recordingStream = stream;
            if (!mediaRecorder || mediaRecorder === undefined) {
                mediaRecorder = new MediaRecorder(stream);

                mediaRecorder.ondataavailable = function (e) {
                    console.log('on data available');
                    chunks.push(e.data);
                };

                mediaRecorder.onstart = function () {
                    console.log('Start recording ... ' + new Date());
                    // save start recording time
                    if (previewModeEnabled === false) {
                        var currentPhase = getCurrentPhase();
                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                        if (tempData) {
                            tempData.startRecordingTime = new Date().getTime();
                        }
                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                    }
                };

                mediaRecorder.onstop = function () {
                    if (saveRecording) {
                        console.log('Stopped and save recording, state = ' + mediaRecorder.state + ', ' + new Date());
                        var filename = hex_sha512(new Date().getTime() + "" + chance.natural()) + '.webm';
                        uploadQueue.upload(chunks, filename, getCurrentPhase().id);
                        chunks = [];
                    }

                    chunks = [];

                    if (stopRecordingCallback) {
                        stopRecordingCallback();
                    }
                };

                mediaRecorder.onerror = function (e) {
                    console.log('Error: ', e);
                };

                mediaRecorder.onwarning = function (e) {
                    console.log('Warning: ' + e);
                };

//                connection.startRecording();
            }
        }
    } else {
        mediaRecorder.start(5000);
    }
};

PeerConnection.prototype.startRecording = function () {
    if (isWebRTCNeededForPhaseStep(getCurrentPhase())) {
        console.log('check start: start recording');
        connection.initRecording();
    }
};

var stopRecordingCallback = null;
var saveRecording = false;
PeerConnection.prototype.stopRecording = function (callback, save) {
    saveRecording = save;
    console.log('stop recording');
    if (mediaRecorder && mediaRecorder.state !== 'inactive') {
        stopRecordingCallback = null;
        if (callback) {
            stopRecordingCallback = callback;
        }
        mediaRecorder.stop();
    } else if (callback) {
        callback();
    }
};