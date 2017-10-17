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
var EVENT_FILE_TRANSFER = 'fileTransfer';
var EVENT_RECEIVED_FILE = 'receivedFile';

var TYPE_PEER_SCREEN = 'screen';
var TYPE_PEER_VIDEO = 'video';

PeerConnection.prototype.status = STATUS_UNINITIALIZED;
PeerConnection.prototype.options = null;

var TYPE_MESSAGE_CONTROL = 'controlMessage';

var webrtc = null;
var webRTCPeer = null;
var connection = null;
//var syncPhaseStep = false;

var STUN = {
    'url': 'stun:stun.l.google.com:19302'
};

var TURN = {
    url: 'turn: danielkuenkel%40googlemail.com%40numb.viagenie.ca: 3478',
    credential: 'GpE-y3D-9YC-d9o'
};

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
            autoRequestMedia: options.autoRequestMedia, // immediately ask for camera access
            localVideo: {
                autoplay: true, // automatically play the video stream on the page
                mirror: true, // flip the local video to mirror mode (for UX)
                muted: true // mute local video stream to prevent echo
            },
            peerConnectionConfig: {'iceServers': [STUN, TURN]},
            enableDataChannels: options.enableDataChannels,
            receiveMedia: {
                offerToReceiveAudio: options.enableWebcamStream && options.enableWebcamStream === true ? 1 : 0,
                offerToReceiveVideo: options.enableWebcamStream && options.enableWebcamStream === true ? 1 : 0
            }
        });


        if (options.localMuteElement && options.callerElement) {
            var tween = new TweenMax(options.streamControls, .3, {opacity: 1.0, paused: true});
            console.log(options.callerElement);
            $(options.callerElement).on('mouseenter', function (event) {
                event.preventDefault();
                tween.play();
            });

            $(options.callerElement).on('mouseleave', function (event) {
                event.preventDefault();
                tween.reverse();
            });

            $(options.localMuteElement).on('click', function (event) {
                event.preventDefault();
                console.log('mute local');
                if (!$(this).hasClass('muted')) {
                    $(this).addClass('muted');
                    $(this).find('.fa').removeClass('fa fa-microphone-slash').addClass('fa fa-microphone');
                    $('#' + options.localVideoElement).attr('volume', 0);
                    $(this).attr('title', 'Mikrofon anschalten')
                            .tooltip('fixTitle')
                            .tooltip('setContent')
                            .tooltip('show');
                    webrtc.mute();
                    if (options.indicator) {
                        $(options.indicator).find('#mute-local-audio').removeClass('hidden');
                    }
                } else {
                    $(this).removeClass('muted');
                    $(this).find('.fa').removeClass('fa fa-microphone').addClass('fa fa-microphone-slash');
                    $('#' + options.localVideoElement).attr('volume', 1);
                    $(this).attr('title', 'Mikrofon stummschalten')
                            .tooltip('fixTitle')
                            .tooltip('setContent')
                            .tooltip('show');
                    webrtc.unmute();
                    if (options.indicator) {
                        $(options.indicator).find('#mute-local-audio').addClass('hidden');
                    }
                }
                $(this).blur();
            });

            $(options.pauseStreamElement).on('click', function (event) {
                event.preventDefault();
                console.log('pause/resume stream');
                if (!$(this).hasClass('paused')) {
                    $(this).addClass('paused');
                    $(this).find('.fa').removeClass('fa-pause').addClass('fa-play');
                    $(this).attr('title', 'Übertragung fortsetzen')
                            .tooltip('fixTitle')
                            .tooltip('setContent')
                            .tooltip('show');
                    webrtc.pause();

                    if (options.localMuteElement) {
                        $(options.indicator).find('#mute-local-audio').removeClass('hidden');
                        $(options.indicator).find('#pause-local-stream').removeClass('hidden');
                        $(options.localMuteElement).removeClass('muted');
                        $(options.localMuteElement).find('.fa').removeClass('fa fa-microphone').addClass('fa fa-microphone-slash');
                        $(options.localMuteElement).attr('title', 'Mikrofon stummschalten')
                                .tooltip('fixTitle')
                                .tooltip('setContent');
                    }
                } else {
                    $(this).removeClass('paused');
                    $(this).find('.fa').removeClass('fa-play').addClass('fa-pause');
                    $(this).attr('title', 'Übertragung pausieren')
                            .tooltip('fixTitle')
                            .tooltip('setContent')
                            .tooltip('show');
                    webrtc.resume();

                    if (options.localMuteElement) {
                        $(options.indicator).find('#mute-local-audio').addClass('hidden');
                        $(options.indicator).find('#pause-local-stream').addClass('hidden');
                    }
                }
                $(this).blur();
            });

            $(options.remoteMuteElement).on('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    if (!$(this).hasClass('muted')) {
                        $(this).addClass('muted');
                        $(this).find('.fa').removeClass('fa-volume-up').addClass('fa-volume-off');
                        $('#' + options.remoteVideoElement).find('video').attr('volume', 0);
                        $(this).attr('title', 'Gesprächspartner anschalten')
                                .tooltip('fixTitle')
                                .tooltip('setContent')
                                .tooltip('show');
                    } else {
                        $(this).removeClass('muted');
                        $(this).find('.fa').removeClass('fa-volume-off').addClass('fa-volume-up');
                        $('#' + options.remoteVideoElement).find('video').attr('volume', 1);
                        $(this).attr('title', 'Gesprächspartner stummschalten')
                                .tooltip('fixTitle')
                                .tooltip('setContent')
                                .tooltip('show');
                    }
                }
                $(this).blur();
            });
        }

        // we have to wait until it's ready
        webrtc.on('readyToCall', function () {
            if (connection.options.roomId !== undefined) {
                console.log('ready to call', connection.options.roomId);
                webrtc.joinRoom(connection.options.roomId);
            }

            if (!syncPhaseStep && connection.options.remoteStream.video === 'no') {
                connection.update(connection.options);
            }
        });

        // we got access to the camera
        webrtc.on('localStream', function (stream) {
            console.log('on local stream');
        });

        // we did not get access to the camera
        webrtc.on('localMediaError', function (err) {
            console.log('local media error');
        });

        webrtc.connection.on('message', function (data) {
//            console.log('on message', data);
            if (data.roomType === 'video') {
                $(connection).trigger(data.type, [data.payload]);
            }
        });

        // local screen obtained
        webrtc.on('localScreenAdded', function (video) {
            console.log('local screen added');
//            video.onclick = function () {
//                video.style.width = video.videoWidth + 'px';
//                video.style.height = video.videoHeight + 'px';
//            };
            if (options.target && options.remoteVideoElement) {
                $(video).addClass('hidden');
                $(options.target).find('#' + options.remoteVideoElement).append(video);
            }
//            $('#localScreenContainer').empty().append(video);
//            $('#localScreenContainer').show();
        });

        // a peer video has been added
        webrtc.on('videoAdded', function (video, peer) {
            console.log('webrtc video added', peer);
            if (peer.type === TYPE_PEER_SCREEN) {
                console.log('screen added');
                $(connection).trigger(MESSAGE_SHARED_SCREEN_ADDED, [video]);
            } else {
                $(connection).trigger('videoAdded', [video]);
                if (!syncPhaseStep) {
                    connection.update(connection.options);
                }

                if (options.remoteMuteElement) {
                    $(options.remoteMuteElement).removeClass('disabled');
                }
            }


            // show the ice connection state
            if (peer && peer.pc) {
                var connstate = document.createElement('div');
                connstate.className = 'connectionstate';
//                container.appendChild(connstate);
                peer.pc.on('iceConnectionStateChange', function (event) {
                    var state = null;
                    switch (peer.pc.iceConnectionState) {
                        case 'checking':
                            state = 'Connecting to peer ...';
                            break;
                        case 'connected':
                        case 'completed': // on caller side
//                            $(vol).show();
                            state = 'Connection established.';
                            break;
                        case 'disconnected':
                            state = 'Disconnected.';
                            break;
                        case 'failed':
                            state = 'Connection failed.';
                            break;
                        case 'closed':
                            state = 'Connection closed.';
                            break;
                    }
                    console.log('peer connection state', state);
                });

            }
        });

        // a peer video has been removed
        webrtc.on('videoRemoved', function (video, peer) {
            console.log('web rtc video removed', video, peer);
            if (peer && peer.type === TYPE_PEER_SCREEN || $(video).attr('id') === 'localScreen') {
//                $(video).remove();
                $(connection).trigger('localScreenRemoved', [video]);
            } else if (peer && peer.type === TYPE_PEER_VIDEO) {
                $(connection).trigger('videoRemoved');
                $('#local-stream').removeClass('rtc-shadow');
                if (options.indicator) {
                    $(options.indicator).find('#mute-remote-audio').addClass('hidden');
                    $(options.indicator).find('#pause-remote-stream').addClass('hidden');
                }

                if (options.remoteMuteElement) {
                    $(options.remoteMuteElement).removeClass('muted');
                    $(options.remoteMuteElement).find('.fa').removeClass('fa-volume-off').addClass('fa-volume-up');
                    $(options.remoteMuteElement).find('video').attr('volume', 1);
                    $(options.remoteMuteElement).attr('title', 'Gesprächspartner stummschalten')
                            .tooltip('fixTitle')
                            .tooltip('setContent');
                }

                connection.hideRemoteStream();

                if (connection.options.localStream.record === 'yes') {
                    connection.stopRecording(null, false);
                }

                if (options.remoteMuteElement) {
                    $(options.remoteMuteElement).addClass('disabled');
                }
            }
        });

        // handle mute stream from other person
        webrtc.on('mute', function (data) { // show muted symbol
            webrtc.getPeers(data.id).forEach(function (peer) {
                if (data.name === 'audio' && options.indicator) {
                    $(options.indicator).find('#mute-remote-audio').removeClass('hidden');
                } else if (data.name === 'video') {
                    $(options.indicator).find('#pause-remote-stream').removeClass('hidden');
                }
            });
        });

        webrtc.on('unmute', function (data) { // hide muted symbol
            webrtc.getPeers(data.id).forEach(function (peer) {
                if (data.name === 'audio') {
                    $(options.indicator).find('#mute-remote-audio').addClass('hidden');
                } else if (data.name === 'video') {
                    $(options.indicator).find('#pause-remote-stream').addClass('hidden');
                }
            });
        });

        webrtc.on('stunservers', function (event) {
            console.log('on stun servers', event);
        });

        webrtc.on('turnservers', function (event) {
            console.log('on turn servers', event);
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
            connection.stopRecording(null, false);
        });

        // called when a peer is created
        webrtc.on('createdPeer', function (peer) {
            webRTCPeer = peer;
            console.log('webrtc created peer', peer);

            webRTCPeer.on('fileTransfer', function (metadata, receiver) {
                console.log('incoming filetransfer', metadata.name, metadata);
                receiver.on('progress', function (bytesReceived) {
//                    console.log('receive progress', bytesReceived, 'out of', metadata.size);
                    $(connection).trigger(EVENT_FILE_TRANSFER, [bytesReceived, metadata.size]);
                });

                // get notified when file is done
                receiver.on('receivedFile', function (file, metadata) {
                    console.log('received file', file, metadata.name, metadata.size);
                    $(connection).trigger(EVENT_RECEIVED_FILE, [file, metadata]);
                    // close the channel
                    receiver.channel.close();
                });
            });
        });
    } else {
        console.log('no options for webrtc');
    }
};

$(window).on('resize', function () {
    onTweenComplete();
});

function onTweenComplete() {
    var remoteHeight = $('.rtc-remote-container').find('video').height();
    var offset = 0;
    if (remoteHeight > 0) {
        offset = remoteHeight - $('#local-stream').height() - 5;
    }
    $('#local-stream').css({marginBottom: offset + 'px'});
}

function onLocalTweenComplete() {
    $('#local-stream').css({width: '30%', height: 'auto'});
}

PeerConnection.prototype.update = function (options) {
    this.status = STATUS_INITIALIZED;
    var currentOptions = this.options = options;

    if (webrtc) {
        if (currentOptions) {
            console.log('update caller states', currentOptions);

            // check specific phase step constraints
            if (currentOptions.localStream.video === 'yes' && currentOptions.localStream.visualize === 'yes') {
                connection.showLocalStream();
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
                connection.hideLocalStream();
                if (currentOptions.remoteStream.video === 'yes') {
                    TweenMax.to($('#' + currentOptions.remoteVideoElement), .3, {opacity: 1.0, onComplete: onTweenComplete});
                } else {
                    TweenMax.to($('#' + currentOptions.remoteVideoElement), .3, {opacity: 0, onComplete: onTweenComplete});
                }
            }

            // check if stream has to be recorded
//            console.log('check if stream has to be recorded', options.localStream.record);
            if (options.localStream.record === 'yes') {
                connection.startRecording(true);
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

PeerConnection.prototype.showLocalStream = function () {
    var currentOptions = this.options;
    TweenMax.to($('#' + currentOptions.localVideoElement), .3, {opacity: 1.0});
};

PeerConnection.prototype.hideLocalStream = function () {
    var currentOptions = this.options;
    TweenMax.to($('#' + currentOptions.localVideoElement), .3, {opacity: 0});
};

PeerConnection.prototype.showRemoteStream = function () {
    setTimeout(function () {
        var currentOptions = connection.options;
        var width = Math.floor($('#' + currentOptions.remoteVideoElement).width() * .3);
        var height = Math.floor(width * 3 / 4);
        TweenMax.to($('#' + currentOptions.localVideoElement), .3, {delay: .6, width: width, height: height, left: 5, top: 5, ease: Quad.easeIn, onComplete: onLocalTweenComplete});
        TweenMax.to($('#' + currentOptions.remoteVideoElement), .3, {delay: .6, opacity: 1.0, onComplete: onTweenComplete});
    }, 500);
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
PeerConnection.prototype.initRecording = function (startRecording) {
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
            console.log('init recorder', mediaRecorder, stream);
            recordingStream = stream;
            if (!mediaRecorder || mediaRecorder === undefined) {
                mediaRecorder = new MediaRecorder(stream);

                mediaRecorder.ondataavailable = function (e) {
                    console.log('on data available');
                    chunks.push(e.data);

                    if (separateChunksRecording === true) {
                        separateChunks.push(e.data);
                    }
                };

                mediaRecorder.onstart = function () {
                    console.log('Start recording ... ');
                    // save start recording time
                    if (previewModeEnabled === false) {
                        var currentPhase = getCurrentPhase();
                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                        getGMT(function (timestamp) {
                            tempData.startRecordingTime = timestamp;
                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                        });
                    }
                };

                mediaRecorder.onstop = function () {
                    console.log('Stopped recording, state = ' + mediaRecorder.state);
                    if (saveRecording) {
                        console.log('Save recording');

                        getGMT(function (timestamp) {
                            var currentPhase = getCurrentPhase();
                            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                            tempData.endRecordingTime = timestamp;
                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);

                            var filename = hex_sha512(timestamp + "" + chance.natural()) + '.webm';
                            uploadQueue.upload(chunks, filename, getCurrentPhase().id, 'recordUrl');
                            chunks = [];
                        });

                    }



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

                console.log('startRecording', startRecording);
                if (startRecording === true) {

                    mediaRecorder.start(1000);
                }
            }
        }
    } else {
        console.log('startRecording init', startRecording);
        if (mediaRecorder.state !== 'recording' && startRecording) {

            mediaRecorder.start(1000);
        }
    }
};

PeerConnection.prototype.startRecording = function () {
    if (isWebRTCNeededForPhaseStep(getCurrentPhase())) {
//        console.log('check start: start recording');
        connection.initRecording(true);
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

var separateChunks = [];
var separateChunksRecording = false;
PeerConnection.prototype.startRecordSeparateChunks = function () {
    console.log('start record separate chunks');
    separateChunks = [];
    separateChunksRecording = true;
    connection.initRecording(true);
};

PeerConnection.prototype.stopRecordSeparateChunks = function () {
    console.log('stop record separate chunks');
    if (isUploadRecordingNeeded() === false) {
        connection.stopRecording(null, false);
    }
    separateChunksRecording = false;
    return separateChunks;
};


var screenChunks = [];
var screenMediaRecorder = null;
PeerConnection.prototype.initScreenRecording = function () {
    var localScreenStream = webrtc.getLocalScreen();
    screenMediaRecorder = new MediaRecorder(localScreenStream);

    screenMediaRecorder.ondataavailable = function (e) {
        console.log('on screen sharing data available');
        screenChunks.push(e.data);
    };

    screenMediaRecorder.onstart = function () {
        console.log('Start screen recording ... ');
        // save start recording time
        if (previewModeEnabled === false) {
            var currentPhase = getCurrentPhase();
            getGMT(function (timestamp) {
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.startScreenRecordingTime = timestamp;
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            });
        }
    };

    screenMediaRecorder.onstop = function () {
        console.log('Stopped screen recording, state = ' + screenMediaRecorder.state);
        if (saveScreenRecording) {
            getGMT(function (timestamp) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.endScreenRecordingTime = timestamp;
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);

                console.log('Save screen recording');
                var filename = hex_sha512(timestamp + "" + chance.natural()) + '.webm';
                uploadQueue.upload(screenChunks, filename, getCurrentPhase().id, 'screenRecordUrl');
                screenChunks = [];
            });
        }

        if (stopScreenRecordingCallback) {
            stopScreenRecordingCallback();
        }
    };

    screenMediaRecorder.start(1000);
};

PeerConnection.prototype.startScreenRecording = function () {
    console.log('start record screen sharing');
    connection.initScreenRecording();
};

var stopScreenRecordingCallback = null;
var saveScreenRecording = false;
PeerConnection.prototype.stopScreenRecording = function (save, callback) {
    console.log('stop recording screen sharing');
    saveScreenRecording = save;
    if (screenMediaRecorder && screenMediaRecorder.state !== 'inactive') {
        stopScreenRecordingCallback = null;
        if (callback) {
            stopScreenRecordingCallback = callback;
        }
        screenMediaRecorder.stop();
    } else if (callback) {
        callback();
    }
};

PeerConnection.prototype.transferFile = function (file) {
    if (webRTCPeer) {
        webRTCPeer.sendFile(file);
    } else {
        console.error('no peer created yet');
    }
};

PeerConnection.prototype.shareScreen = function (errorCallback, successCallback) {

    if (webrtc && webrtc.capabilities.supportScreenSharing) {
        try {
            webrtc.shareScreen(function (error) {
                if (error) {
                    if (errorCallback) {
                        errorCallback(error);
                    }
                } else {
                    console.log('start share screen');
                    if (successCallback) {
                        successCallback();
                    }
                }
            });
        } catch (error) {
            console.log('error:', error);
        }

    }
};

PeerConnection.prototype.stopShareScreen = function (save, callback) {
    connection.stopScreenRecording(save, callback);
    if (webrtc) {
        console.log('stop screen sharing');
        webrtc.stopScreenShare();
    }
};