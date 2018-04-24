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

var CONNECTION_STATE_CONNECTED = 'connected';
var CONNECTION_STATE_COMPLETED = 'completed';
var CONNECTION_STATE_DISCONNECTED = 'disconnected';
var CONNECTION_STATE_CHECKING = 'checking';
var CONNECTION_STATE_FAILED = 'failed';
var CONNECTION_STATE_CLOSED = 'closed';

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
    url: 'turn: danielkuenkel%40googlemail.com%40numb.viagenie.ca: 86400',
    credential: 'GpE-y3D-9YC-d9o'
};

function PeerConnection(isRecordingNeeded) {
    connection = this;
//    console.log('is recording needed:', isRecordingNeeded, isRecordingNeededInFuture());
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
                $(this).popover('hide');

                if (!$(this).hasClass('muted')) {
                    $(this).addClass('muted');
                    $(this).find('.fa').removeClass('fa fa-microphone-slash').addClass('fa fa-microphone');
                    $('#' + options.localVideoElement).attr('volume', 0);

                    $(this).attr('data-content', translation.unmuteMicrofone).data('bs.popover').setContent();
                    webrtc.mute();
                    if (options.indicator) {
                        $(options.indicator).find('#mute-local-audio').removeClass('hidden');
                    }
                } else {
                    $(this).removeClass('muted');
                    $(this).find('.fa').removeClass('fa fa-microphone').addClass('fa fa-microphone-slash');
                    $('#' + options.localVideoElement).attr('volume', 1);
                    $(this).attr('data-content', translation.muteMicrofone).data('bs.popover').setContent();
                    webrtc.unmute();
                    if (options.indicator) {
                        $(options.indicator).find('#mute-local-audio').addClass('hidden');
                    }
                }
                $(this).blur();
            });

            $(options.pauseStreamElement).on('click', function (event) {
                event.preventDefault();
                $(this).popover('hide');
                if (!$(this).hasClass('paused')) {
                    $(this).addClass('paused');
                    $(this).find('.fa').removeClass('fa-pause').addClass('fa-play');
                    $(this).attr('data-content', translation.resumeOwnWebRTC).data('bs.popover').setContent();
                    webrtc.pause();

                    if (options.localMuteElement) {
                        $(options.indicator).find('#mute-local-audio').removeClass('hidden');
                        $(options.indicator).find('#pause-local-stream').removeClass('hidden');
                        $(options.localMuteElement).removeClass('muted');
                        $(options.localMuteElement).find('.fa').removeClass('fa fa-microphone').addClass('fa fa-microphone-slash');
                        $(options.localMuteElement).attr('data-content', translation.muteMicrofone).data('bs.popover').setContent();
                    }
                } else {
                    $(this).removeClass('paused');
                    $(this).find('.fa').removeClass('fa-play').addClass('fa-pause');
                    $(this).attr('data-content', translation.pauseOwnWebRTC).data('bs.popover').setContent();
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
                    $(this).popover('hide');
                    if (!$(this).hasClass('muted')) {
                        $(this).addClass('muted');
                        $(this).find('.fa').removeClass('fa-volume-up').addClass('fa-volume-off');
                        $('#' + options.remoteVideoElement).find('video').attr('volume', 0);
                        $(this).attr('data-content', translation.resumeOtherWebRTC).data('bs.popover').setContent();
                    } else {
                        $(this).removeClass('muted');
                        $(this).find('.fa').removeClass('fa-volume-off').addClass('fa-volume-up');
                        $('#' + options.remoteVideoElement).find('video').attr('volume', 1);
                        $(this).attr('data-content', translation.pauseOtherWebRTC).data('bs.popover').setContent();
                    }
                }
                $(this).blur();
            });

            if (options.togglePinnedElement) {
                $(options.togglePinnedElement).on('click', function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
                        $(this).popover('hide');
                        if ($(this).hasClass('pinned')) {
                            $(this).removeClass('pinned');
                            $(this).find('.fa').removeClass('fa-window-restore').addClass('fa-window-maximize');
                            $(this).attr('data-content', translation.pinRTC).data('bs.popover').setContent();
                            dragRTC();
                        } else {
                            $(this).addClass('pinned');
                            $(this).find('.fa').removeClass('fa-window-maximize').addClass('fa-window-restore');
                            $(this).attr('data-content', translation.dragRTC).data('bs.popover').setContent();
                            pinRTC();
                        }
                    }
                    $(this).blur();
                });
            }
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
            console.log('local screen added', video);
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

                webRTCPeer = peer;
                peer.on('fileTransfer', function (metadata, receiver) {
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
            }

            // show the ice connection state
            if (peer && peer.pc && peer.type === TYPE_PEER_VIDEO) {
                var connstate = document.createElement('div');
                connstate.className = 'connectionstate';
//                container.appendChild(connstate);
                peer.pc.on('iceConnectionStateChange', function (event) {
                    var state = null;
                    switch (peer.pc.iceConnectionState) {
                        case CONNECTION_STATE_CHECKING:
                            state = 'Connecting to peer ...';
                            break;
                        case CONNECTION_STATE_CONNECTED:
                        case CONNECTION_STATE_COMPLETED: // on caller side
//                            $(vol).show();
                            state = 'Connection established.';
                            break;
                        case CONNECTION_STATE_DISCONNECTED:
                            state = 'Disconnected.';
                            break;
                        case CONNECTION_STATE_FAILED:
                            state = 'Connection failed.';
                            break;
                        case CONNECTION_STATE_CLOSED:
                            state = 'Connection closed.';
                            break;
                    }

                    $(connection).trigger(peer.pc.iceConnectionState);
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

                if (options.indicator) {
                    $(options.indicator).find('#mute-remote-audio').addClass('hidden');
                    $(options.indicator).find('#pause-remote-stream').addClass('hidden');
                }

                if (options.remoteMuteElement) {
                    $(options.remoteMuteElement).removeClass('muted');
                    $(options.remoteMuteElement).find('.fa').removeClass('fa-volume-off').addClass('fa-volume-up');
                    $(options.remoteMuteElement).find('video').attr('volume', 1);
                    $(options.remoteMuteElement).attr('data-content', translation.pauseOtherWebRTC).data('bs.popover').setContent();
//                    $(options.remoteMuteElement).attr('title', 'Gesprächspartner stummschalten')
//                            .tooltip('fixTitle')
//                            .tooltip('setContent');
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

//        // called when a peer is created
//        webrtc.on('createdPeer', function (peer) {
//            console.log('webrtc created peer', peer);
//            if (!webRTCPeer) {
//                webRTCPeer = peer;
//
//                
//            }
//        });
    } else {
        console.log('no options for webrtc');
    }
};

//$(window).on('resize', function () {
//    onTweenComplete();
//});
//
function onTweenComplete() {
//    var remoteHeight = $('.rtc-remote-container').find('video').height();
//    var offset = 0;
//    if (remoteHeight > 0) {
//        offset = remoteHeight - $('#local-stream').height() - 5;
//    }
//    $('#local-stream').css({marginBottom: offset + 'px'});
}

function onLocalTweenComplete() {
//    $('#local-stream').css({width: '30%', height: 'auto'});
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
//                    $('#' + currentOptions.localVideoElement).addClass('rtc-shadow');
                    connection.showRemoteStream();
                } else {
                    $('#' + currentOptions.remoteVideoElement).addClass('hidden');

                    connection.hideRemoteStream();
                }
            } else {
                connection.hideLocalStream();
                if (currentOptions.remoteStream.video === 'yes') {
                    TweenMax.to($('#' + currentOptions.remoteVideoElement), .3, {opacity: 1.0});
                } else {
                    TweenMax.to($('#' + currentOptions.remoteVideoElement), .3, {opacity: 0});
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
//    setTimeout(function () {
    var currentOptions = connection.options;
//        var width = Math.floor($('#' + currentOptions.remoteVideoElement).width() * .3);
//        var height = Math.floor(width * 3 / 4);
    $('#' + currentOptions.localVideoElement).addClass('rtc-shadow');
    TweenMax.to($('#' + currentOptions.localVideoElement), .3, {css: {width: '30%', height: 'auto', left: 5, top: 5}, ease: Quad.easeIn});
    TweenMax.to($('#' + currentOptions.remoteVideoElement), .3, {delay: .2, opacity: 1.0});
//    }, 500);
};

PeerConnection.prototype.hideRemoteStream = function () {
    var currentOptions = this.options;
    $('#' + currentOptions.localVideoElement).removeClass('rtc-shadow');
    TweenMax.to($('#' + currentOptions.localVideoElement), .3, {delay: .2, css: {width: '100%', height: 'auto', left: 0, top: 0}, ease: Quad.easeIn, clearProps: 'all'});
    TweenMax.to($('#' + currentOptions.remoteVideoElement), .3, {opacity: 0});
};


/*
 * recording
 */
var chunks = {};
var recordingStream = null;
var mediaRecorder = null;
PeerConnection.prototype.initRecording = function (startRecording) {
    if (!recordingStream) {
        navigator.getUserMedia = navigator.getUserMedia ||
                navigator.webkitGetUserMedia ||
                navigator.mozGetUserMedia;

        if (navigator.getUserMedia) {
            navigator.mediaDevices.enumerateDevices()
                    .then(gotDevices)
                    .catch(errorCallback);
        } else {
            console.warn('Native device media streaming (getUserMedia) not supported in this browser.');
        }

        function gotDevices(deviceInfos) {
            var videoSource = null;
            for (var i = 0; i < deviceInfos.length; i++) {
                if (deviceInfos[i].kind === 'videoinput') {
                    videoSource = deviceInfos[i].deviceId;
                    break;
                }
            }

            if (getBrowser() === "Chrome") {
                var constraints = {audio: true,
                    video: {deviceId: {exact: videoSource, "mandatory": {"minWidth": 320, "maxWidth": 320, "minHeight": 240, "maxHeight": 240}}
                    }};
            } else if (getBrowser() === "Firefox") {
                var constraints = {audio: true,
                    video: {deviceId: {exact: videoSource, width: {min: 320, ideal: 320, max: 320}, height: {min: 240, ideal: 240, max: 240}}
                    }};
            }

            navigator.mediaDevices.getUserMedia(constraints).then(onSuccess).catch(onError);
        }

        function errorCallback(deviceInfos) {
            console.error('error', deviceInfos);
        }

        // check current browser for building constraints
//        if (getBrowser() == "Chrome") {
//            var constraints = {"audio": true, "video": {"mandatory": {"minWidth": 320, "maxWidth": 320, "minHeight": 240, "maxHeight": 240}, "optional": []}};
//        } else if (getBrowser() == "Firefox") {
//            var constraints = {audio: true, video: {width: {min: 320, ideal: 320, max: 320}, height: {min: 240, ideal: 240, max: 240}}};
//        }
//
//        // set user media for specifig browsers
//        navigator.getUserMedia = navigator.getUserMedia ||
//                navigator.webkitGetUserMedia ||
//                navigator.mozGetUserMedia;
////        navigator.getUserMedia = (navigator.getUserMedia ||
////                navigator.mozGetUserMedia ||
////                navigator.msGetUserMedia ||
////                navigator.webkitGetUserMedia);
//        if (navigator.getUserMedia) {
//            console.log(navigator.getUserMedia);
//            navigator.mediaDevices.getUserMedia(constraints).then(onSuccess).catch(onError);
////            navigator.getUserMedia(constraints, onSuccess, onError);
//        } else {
//            console.log('Sorry! This requires Firefox 30 and up or Chrome 47 and up.');
//        }

        // media recorder functions
        function onError(error) {
            console.log(error);
        }

        function onSuccess(stream) {
            console.log('init recorder', mediaRecorder, stream);
            recordingStream = stream;
            if (!mediaRecorder || mediaRecorder === undefined) {
                mediaRecorder = new MediaRecorder(stream);

                mediaRecorder.ondataavailable = function (event) {
                    console.log('on data available');

                    if (event.data && event.data.size > 0) {
                        var currentPhase = getCurrentPhase();
                        chunks[currentPhase.id].push(event.data);
                    }
                };

                mediaRecorder.onstart = function () {
                    console.log('Start recording ... ');
                    // save start recording time
                    if (previewModeEnabled === false) {
                        getGMT(function (timestamp) {
                            var currentPhase = getCurrentPhase();
                            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                            tempData.startRecordingTime = timestamp;
                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                            chunks[currentPhase.id] = [];
                        });
                    }
                };

                mediaRecorder.onstop = function () {
                    console.log('Stopped recording, state = ' + mediaRecorder.state);
                    if (saveRecording) {
                        console.log('Save recording');
                        uploadQueue.uploadIsPending();

                        var currentPhase = getCurrentPhase();
                        getGMT(function (timestamp) {
                            var filename = hex_sha512(timestamp + "" + chance.natural()) + '.webm';
                            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                            tempData.endRecordingTime = timestamp;
                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);

                            uploadQueue.upload(chunks[currentPhase.id], filename, currentPhase.id, 'recordUrl');
                            chunks[currentPhase.id] = [];

                            if (stopRecordingCallback) {
                                stopRecordingCallback();
                            }
                        });
                    } else {
                        if (stopRecordingCallback) {
                            stopRecordingCallback();
                        }
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


var separateRecordingStream = null;
var separateMediaRecorder = null;
PeerConnection.prototype.initSeparateRecording = function (startRecording) {
    if (!separateRecordingStream) {
        // check current browser for building constraints
        if (getBrowser() == "Chrome") {
            var constraints = {"audio": true, "video": {"mandatory": {"minWidth": 320, "maxWidth": 320, "minHeight": 240, "maxHeight": 240}, "optional": []}};
        } else if (getBrowser() == "Firefox") {
            var constraints = {audio: true, video: {width: {min: 320, ideal: 320, max: 320}, height: {min: 240, ideal: 240, max: 240}}};
        }

        // set user media for specific browsers
        navigator.getUserMedia = (navigator.getUserMedia ||
                navigator.mozGetUserMedia ||
                navigator.msGetUserMedia ||
                navigator.webkitGetUserMedia);
        if (navigator.getUserMedia) {
            navigator.getUserMedia(constraints)
                    .then(function (stream) {
                        onSuccess(stream);
                    })
                    .catch(function (err) {
                        onError(err);
                    });
        } else {
            console.log('Sorry! This requires Firefox 30 and up or Chrome 47 and up.');
        }

        // media recorder functions
        function onError(error) {
            console.log(error);
        }

        function onSuccess(stream) {
            console.log('init recorder', separateMediaRecorder, stream);
            separateRecordingStream = stream;
            if (!separateMediaRecorder || separateMediaRecorder === undefined) {
                separateMediaRecorder = new MediaRecorder(stream);

                separateMediaRecorder.ondataavailable = function (event) {
                    console.log('on separate data available');
                    if (event.data && event.data.size > 0) {
                        separateChunks.push(event.data);
                    }
                };

                separateMediaRecorder.onerror = function (e) {
                    console.log('Error: ', e);
                };

                separateMediaRecorder.onwarning = function (e) {
                    console.log('Warning: ' + e);
                };

                console.log('startRecording', startRecording);
                if (startRecording === true) {
                    separateMediaRecorder.start(1000);
                }
            }
        }
    } else {
        console.log('start separate ecording init', startRecording);
        if (separateMediaRecorder.state !== 'recording' && startRecording) {
            separateMediaRecorder.start(1000);
        }
    }
};

var separateChunks = [];
PeerConnection.prototype.initSeparateChunksRecording = function () {
    console.log('init separate chunks recording');
    separateChunks = [];
    connection.initSeparateRecording(false);
};

PeerConnection.prototype.startRecordSeparateChunks = function () {
    console.log('start record separate chunks');
    separateChunks = [];
    connection.initSeparateRecording(true);
};

PeerConnection.prototype.stopRecordSeparateChunks = function () {
    console.log('stop record separate chunks');
    if (separateMediaRecorder && separateMediaRecorder.state !== 'inactive') {
        separateMediaRecorder.stop();
    }
//    console.log(window.URL.createObjectURL(new Blob(separateChunks, {type: 'video/webm'})));
    return separateChunks;
};


var screenChunks = [];
var screenMediaRecorder = null;
PeerConnection.prototype.initScreenRecording = function () {

    var localScreenStream = webrtc.getLocalScreen();
    console.log('initScreenRecording');
    screenMediaRecorder = new MediaRecorder(localScreenStream);
    console.log(webrtc, screenMediaRecorder);

    screenMediaRecorder.ondataavailable = function (e) {
        console.log('on screen sharing data available');
        screenChunks.push(e.data);
    };

    screenMediaRecorder.onstart = function () {
        console.log('Start screen recording ... ');
        // save start recording time
        if (previewModeEnabled === false) {

            getGMT(function (timestamp) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.startScreenRecordingTime = timestamp;
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            });
        }
    };

    screenMediaRecorder.onstop = function () {
        if (screenMediaRecorder) {
            console.log('Stopped screen recording, state = ' + screenMediaRecorder);
            if (saveScreenRecording) {
                var currentPhase = getCurrentPhase();
                uploadQueue.uploadIsPending();

                getGMT(function (timestamp) {
                    console.log('Save screen recording');
                    var filename = hex_sha512(timestamp + "" + chance.natural()) + '.webm';
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    tempData.endScreenRecordingTime = timestamp;
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);

                    uploadQueue.upload(screenChunks, filename, currentPhase.id, 'screenRecordUrl');
                    screenChunks = [];

                    if (stopScreenRecordingCallback) {
                        stopScreenRecordingCallback();
                    }

                    webrtc.webrtc.localScreens = [];
                });
            } else {
                if (stopScreenRecordingCallback) {
                    stopScreenRecordingCallback();
                }
            }

            screenMediaRecorder = null;
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
        console.log('transfer file:', file);
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

PeerConnection.prototype.reset = function () {
//    if (screenMediaRecorder) {
//        screenMediaRecorder = null;
//    }
};