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
    urls: 'stun:stun.l.google.com:19302'
};

var TURN = {
    urls: 'turn:numb.viagenie.ca',
    username: 'danielkuenkel@googlemail.com',
    credential: 'GpE-y3D-9YC-d9o'
};

function PeerConnection(isRecordingNeeded) {
    connection = this;
//    console.log('is recording needed:', isRecordingNeeded, isRecordingNeededInFuture());
//    if (isRecordingNeeded === true && isRecordingNeededInFuture() && webrtc) {
//        connection.initRecording();
//    }
}

PeerConnection.prototype.destroy = function () {
    console.warn('destroy PeerConnection');

    if (webrtc) {
        webrtc.stopLocalVideo();
        webrtc.off('readyToCall');
        webrtc.off('joinedRoom');
        webrtc.off('leftRoom');
        webrtc.off('videoAdded');
        webrtc.off('videoRemoved');
        webrtc.destroy();
        webrtc = null;
    }

    if (webRTCPeer) {
        webRTCPeer = null;
    }

    if (connection) {
        connection = null;
    }

    if (peerConnection) {
        peerConnection = null;
    }
};

PeerConnection.prototype.initialize = function (options) {
    console.log('initialize peer connection');
    if (options) {
        this.options = options;

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
            console.log('got devices for webcam recorder', deviceInfos);
            var videoSource = null;
            var audioSource = null;

            if (options.configElement) {
                var videoSources = [];
                var audioSources = [];
                for (var i = 0; i < deviceInfos.length; i++) {
                    if (deviceInfos[i].kind === 'videoinput' && !deviceInfos[i].label.toLowerCase().includes('leap') && !deviceInfos[i].label.toLowerCase().includes('kinect')) {
                        videoSources.push(deviceInfos[i]);
                    } else if (deviceInfos[i].kind === 'audioinput' && !deviceInfos[i].label.toLowerCase().includes('xbox')) {
                        audioSources.push(deviceInfos[i]);
                    }
                }
            }

            for (var i = 0; i < deviceInfos.length; i++) {
                if (!videoSource && deviceInfos[i].kind === 'videoinput' && !deviceInfos[i].label.toLowerCase().includes('leap') && !deviceInfos[i].label.toLowerCase().includes('kinect')) {
                    console.log('standard video input device:', deviceInfos[i]);
                    videoSource = deviceInfos[i].deviceId;
                } else if (!audioSource && deviceInfos[i].kind === 'audioinput' && !deviceInfos[i].label.toLowerCase().includes('xbox')) {
                    console.log('standard audio input device:', deviceInfos[i]);
                    audioSource = deviceInfos[i].deviceId;
                }

                if (audioSource && videoSource) {
                    break;
                }
            }

            if (options.videoSource && options.videoSource !== null) {
                videoSource = options.videoSource;
            }

            if (options.audioSource && options.audioSource !== null) {
                audioSource = options.audioSource;
            }

            options.sources = {video: videoSource, audio: audioSource};

            console.log('selected source:', options.sources);
            if (options.configElement && options.configPanel) {
                renderAssembledVideoSources($(options.configPanel).find('#video-input-select'), videoSources, videoSource);
                renderAssembledAudioSources($(options.configPanel).find('#audio-input-select'), audioSources, audioSource);
            }

            initWebRTC();
        }

        function errorCallback(deviceInfos) {
            console.error('error', deviceInfos);
        }

        function initWebRTC() {

            // set constraints
            var constraints = null;
            if (getBrowser() === "Chrome") {
                constraints = {audio: {deviceId: {exact: options.sources.audio}},
                    video: {deviceId: {exact: options.sources.video, "mandatory": {"minWidth": 320, "maxWidth": 320, "minHeight": 240, "maxHeight": 240}, frameRate: {ideal: 20, min: 10}, "optional": []}
                    }};
            } else if (getBrowser() === "Firefox") {
                constraints = {audio: {deviceId: {exact: options.sources.audio}},
                    video: {deviceId: {exact: options.sources.video, width: {min: 320, ideal: 320, max: 320}, height: {min: 240, ideal: 240, max: 240}}
                    }};
            }

            webrtc = new SimpleWebRTC({
//            debug: true,
                // the id/element dom element that will hold "our" video
                localVideoEl: options.localVideoElement,
                // the id/element dom element that will hold remote videos
                remoteVideosEl: options.remoteVideoElement,
                // immediately ask for camera access
                autoRequestMedia: options.autoRequestMedia, // immediately ask for camera access
                nick: options.nick || null,
                localVideo: {
                    autoplay: true, // automatically play the video stream on the page
                    mirror: true, // flip the local video to mirror mode (for UX)
                    muted: true // mute local video stream to prevent echo
                },
                peerConnectionConfig: {'iceServers': [STUN, TURN]},
                enableDataChannels: options.enableDataChannels,
//            receiveMedia: {
//                offerToReceiveAudio: options.enableWebcamStream && options.enableWebcamStream === true ? 1 : 0,
//                offerToReceiveVideo: options.enableWebcamStream && options.enableWebcamStream === true ? 1 : 0
//            }
                media: constraints ? constraints : {audio: true, video: true}
            });


            if (getBrowser() === BROWSER_FIREFOX) {
                options.iceTransports = 'relay';
            }
            webrtc.webrtc.config.peerConnectionConfig.iceTransports = options.iceTransports || 'all';
            console.log('ice transports:', webrtc.webrtc.config.peerConnectionConfig.iceTransports);


            var controlsTween = new TweenMax(options.streamControls, .3, {opacity: 1.0, paused: true});
            if (options.localMuteElement && options.callerElement) {

                $(options.callerElement).unbind('click').bind('mouseenter', function (event) {
                    event.preventDefault();
                    if (!options.configElement || (options.configElement && !$(options.configElement).hasClass('opened'))) {
                        controlsTween.play();
                    }
                });

                $(options.callerElement).unbind('click').bind('mouseleave', function (event) {
                    event.preventDefault();
                    controlsTween.reverse();
                });

                $(options.localMuteElement).unbind('click').bind('click', function (event) {
                    event.preventDefault();
//                    console.log('mute local');
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

                $(options.pauseStreamElement).unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    $(this).popover('hide');
//                    console.log('mute local stream');

                    if (!$(this).hasClass('paused')) {
                        $(this).addClass('paused');
                        $(this).find('.fa').removeClass('fa-pause').addClass('fa-play');
                        $(this).attr('data-content', translation.resumeOwnWebRTC).data('bs.popover').setContent();
                        webrtc.pause(); // pauses sending audio and video to all peers

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
                        webrtc.resume(); // resumes sending audio and video to all peers

                        if (options.localMuteElement) {
                            $(options.indicator).find('#mute-local-audio').addClass('hidden');
                            $(options.indicator).find('#pause-local-stream').addClass('hidden');
                        }
                    }
                    $(this).blur();
                });

                $(options.remoteMuteElement).unbind('click').bind('click', function (event) {
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
                    $(options.togglePinnedElement).unbind('click').bind('click', function (event) {
                        event.preventDefault();
                        if (!$(this).hasClass('disabled')) {
                            $(this).popover('hide');
                            if ($(this).hasClass('pinned')) {
                                dragRTC();
                            } else {
                                pinRTC();
                            }
                        }
                        $(this).blur();
                    });
                }
            }

            if (options.configElement && options.callerElement && options.configPanel) {
                $(options.configElement).unbind('click').bind('click', function (event) {
                    event.preventDefault();

                    if (!$(this).hasClass('disabled')) {
                        $(this).popover('hide');
                        if ($(options.configPanel).hasClass('hidden')) {
                            $(options.callerElement).find('#' + options.localVideoElement).css({filter: 'blur(2px)'});
                            $(options.callerElement).find('#' + options.remoteVideoElement).css({filter: 'blur(2px)'});
                            $(options.callerElement).parent().parent().find('#btn-leave-room').addClass('hidden'); // for conversation window
                            controlsTween.reverse();
                            $(options.configPanel).removeClass('hidden');
                        }
                    }
                    $(this).blur();
                });

                $(options.configPanel).find('#btn-close-config').unbind('click').bind('click', function (event) {
                    event.preventDefault();

                    $(options.callerElement).find('#' + options.localVideoElement).css({filter: ''});
                    $(options.callerElement).find('#' + options.remoteVideoElement).css({filter: ''});
                    controlsTween.play();

                    $(options.configPanel).addClass('hidden');
                    $(options.callerElement).parent().parent().find('#btn-leave-room').removeClass('hidden'); // for conversation window
                });

                $(options.configPanel).find('#video-input-select').unbind('change').bind('change', function (event, activeId) {
                    event.preventDefault();

                    if (window.history.replaceState) {
                        setParam(window.location.href, 'vSource', activeId);
                    }

                    renegotiation = true;
                    options.videoSource = activeId;
                    $(connection).trigger('renegotiate', [options.videoSource, options.audioSource]);
                });

                $(options.configPanel).find('#audio-input-select').unbind('change').bind('change', function (event, activeId) {
                    event.preventDefault();

                    if (window.history.replaceState) {
                        setParam(window.location.href, 'aSource', activeId);
                    }

                    renegotiation = true;
                    options.audioSource = activeId;
                    $(connection).trigger('renegotiate', [options.videoSource, options.audioSource]);
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
                localMediaStream = stream;
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
                if (options.target && options.remoteVideoElement) {
                    $(video).addClass('hidden');
                    $(options.target).find('#' + options.remoteVideoElement).append(video);
                }
            });

            // a peer video has been added
            webrtc.on('videoAdded', function (video, peer) {

                if (peer.type === TYPE_PEER_SCREEN) {
                    console.log('screen added', peer);
                    $(connection).trigger(MESSAGE_SHARED_SCREEN_ADDED, [video]);
                } else {
                    var peers = webrtc.getPeers();
                    if (connection.options.maxParticipants && connection.options.maxParticipants && peers.length > connection.options.maxParticipants) {
                        console.warn('only 4 participants for one room allowed');
                        connection.sendMessage('roomIsFull');
                        return false;
                    }
                    console.log('webrtc stream added', peer);
                    $(video).attr('data-role', peer.nick);

                    if (peer.nick === options.selectedRole) {
                        connection.sendMessage('duplicatedRoles', {role: options.selectedRole});
                    } else {
                        arrangePeerStreams();
                    }

                    $(connection).trigger('videoAdded', [video, peer]);
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
                    peer.pc.on('iceConnectionStateChange', function (event) {
                        var state = null;
                        switch (peer.pc.iceConnectionState) {
                            case CONNECTION_STATE_CHECKING:
                                state = 'Connecting to peer ...';
                                break;
                            case CONNECTION_STATE_CONNECTED:
                                state = 'Connected.';
                                break;
                            case CONNECTION_STATE_COMPLETED: // on caller side
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
                        console.log('peer connection state: ', state);
                    });
                }
            });

            // a peer video has been removed
            webrtc.on('videoRemoved', function (video, peer) {
                console.log('web rtc video removed', video, peer);
                if (peer && peer.type === TYPE_PEER_SCREEN || $(video).attr('id') === 'localScreen') {
//                $(video).remove();
                    $(connection).trigger('localScreenRemoved', [video, peer]);
                    currentSharedScreen = null;
                } else if (peer && peer.type === TYPE_PEER_VIDEO) {
                    $(connection).trigger('videoRemoved', [video, peer]);
                    arrangePeerStreams();

                    if (options.indicator) {
                        $(options.indicator).find('#mute-remote-audio').addClass('hidden');
                        $(options.indicator).find('#pause-remote-stream').addClass('hidden');
                    }

                    if (options.remoteMuteElement) {
                        $(options.remoteMuteElement).removeClass('muted');
                        $(options.remoteMuteElement).find('.fa').removeClass('fa-volume-off').addClass('fa-volume-up');
                        $(options.remoteMuteElement).find('video').attr('volume', 1);
                        $(options.remoteMuteElement).attr('data-content', translation.pauseOtherWebRTC).data('bs.popover').setContent();
                    }

                    if ((peer.nick === VIEW_TESTER || peer.nick === VIEW_MODERATOR) && connection.options.localStream.record === 'yes') {
                        connection.stopRecording(null, false);
                    }

                    if (options.remoteMuteElement && webrtc.getPeers().length === 0) {
                        $(options.remoteMuteElement).addClass('disabled');
                    }
                }
            });

            // handle mute stream from other person
            webrtc.on('mute', function (data) { // show muted symbol
                webrtc.getPeers(data.id).forEach(function (peer) {
                    if (options.visibleRoles.indexOf(peer.nick) > -1) {
                        if (data.name === 'audio' && options.indicator) {
                            $(options.indicator).find('#mute-remote-audio').removeClass('hidden');
                        } else if (data.name === 'video') {
                            $(options.indicator).find('#pause-remote-stream').removeClass('hidden');
                        }
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

            webrtc.on('joinedRoom', function (roomName) {
                console.log('joined room:', roomName);
                connection.showLocalStream();
                $(connection).trigger('joinedRoom', [roomName]);
            });

            var renegotiation = false;
            webrtc.on('leftRoom', function (roomName) {
                console.log('left room:', roomName, renegotiation);
                connection.hideLocalStream();

                if (renegotiation === true) {
                    renegotiation = false;
//                    $(connection).trigger('renegotiate', [options, videoSource, audioSource]);
                } else {
                    $(connection).trigger('leftRoom', [roomName]);
                }
                connection.destroy();
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
                console.error('local p2p/ice failure');
                console.log('had local relay candidate', pc.hadLocalRelayCandidate);
                console.log('had remote relay candidate', pc.hadRemoteRelayCandidate);

                if (connection.options.localStream.record === 'yes') {
//                connection.stopRecording(null, false);
                }
            });

            // remote p2p/ice failure
            webrtc.on('connectivityError', function (peer) {
                var pc = peer.pc;
                console.error('remote p2p/ice failure');
                console.log('had local relay candidate', pc.hadLocalRelayCandidate);
                console.log('had remote relay candidate', pc.hadRemoteRelayCandidate);

                if (connection.options.localStream.record === 'yes') {
//                connection.stopRecording(null, false);
                }
            });

//        // called when a peer is created
            webrtc.on('createdPeer', function (peer) {
                console.log('webrtc created peer', peer);
                if (!webRTCPeer) {
                    webRTCPeer = peer; // check if this is working, if more than one peer is created -> moderator peer, wizard peer, etc.
                }
            });

            $(connection).unbind('duplicatedRoles').bind('duplicatedRoles', function (event, payload) {
                event.preventDefault();
                console.log('duplicated roles detected');
                if (options.selectedRole === payload.role) {
                    $(connection).trigger('leaveRoomDuplicatedRoles');
                    connection.leaveRoom();
                }
            });

            $(connection).unbind('roomIsFull').bind('roomIsFull', function (event) {
                event.preventDefault();
                console.log('full room detected');
                $(connection).trigger('leaveFullRoom');
                connection.leaveRoom();
            });
        }
    } else {
        console.log('no options for webrtc');
    }

    initPopover();

    function arrangePeerStreams() {
        var peers = webrtc.getPeers();
        var localVideoElement = $('#' + options.localVideoElement);

        if (options.ignoreRole === 'no') {
            if (peers && peers.length > 0) {
                $(localVideoElement).css({width: '30%', top: '5px', left: '5px'});
                $(localVideoElement).addClass('rtc-shadow');

                for (var i = 0; i < peers.length; i++) {
                    var remoteVideoElement = $(peers[i].videoEl);
                    if (peers[i].type === TYPE_PEER_VIDEO) {
                        $(remoteVideoElement).removeClass('main-remote side-remote');
                        var peerVisible = options.visibleRoles === 'all' || options.visibleRoles.indexOf(peers[i].nick) > -1;

                        if (peerVisible) {
                            $(remoteVideoElement).removeClass('hidden');

                            if (options.selectedRole !== 'tester' && peers[i].nick === 'tester') {
                                $(remoteVideoElement).removeClass('rtc-shadow').addClass('main-remote');
                                $(remoteVideoElement).css({position: '', float: '', zIndex: '', width: '', height: 'auto', top: '', left: ''});
                            } else if (options.selectedRole === 'tester' && peers[i].nick === 'moderator') {
                                $(remoteVideoElement).removeClass('rtc-shadow').addClass('main-remote');
                                $(remoteVideoElement).css({position: '', float: '', zIndex: '', width: '', height: 'auto', top: '', left: ''});
                            } else {
//                            lastVideoElement = remoteVideoElement;
                                $(remoteVideoElement).addClass('rtc-shadow side-remote').removeClass('main-remote');
                            }
                        } else {
                            $(remoteVideoElement).addClass('hidden');
                        }
                    }
                }

                connection.checkRemoteStreamsPositions();
            } else {
                console.log('only local stream', localVideoElement);
                $(localVideoElement).removeClass('rtc-shadow');
                $(localVideoElement).css({width: '', top: '', left: ''});
            }
        } else {
            if (peers && peers.length > 1) {
                $(localVideoElement).css({width: '30%', top: '5px', left: '5px'});
                $(localVideoElement).addClass('rtc-shadow');

                for (var i = 0; i < peers.length; i++) {
                    var remoteVideoElement = $(peers[i].videoEl);
                    if (peers[i].type === TYPE_PEER_VIDEO) {
                        $(remoteVideoElement).removeClass('main-remote side-remote');

                        if (i === 0) {
                            $(remoteVideoElement).removeClass('rtc-shadow hidden').addClass('main-remote');
                            $(remoteVideoElement).css({position: '', float: '', zIndex: '', width: '', height: 'auto', top: '', left: ''});
                        } else {
                            $(remoteVideoElement).addClass('rtc-shadow side-remote');
                        }
                    }
                }

                connection.checkRemoteStreamsPositions();
            } else if (peers && peers.length === 1) {
                $(localVideoElement).css({width: '30%', top: '5px', left: '5px'});
                $(localVideoElement).addClass('rtc-shadow');

                var remoteVideoElement = $(peers[0].videoEl);
                $(remoteVideoElement).removeClass('rtc-shadow hidden').addClass('main-remote');
                $(remoteVideoElement).css({position: '', float: '', zIndex: '', width: '', height: 'auto', top: '', left: ''});
            } else {
                $(localVideoElement).css({width: '', top: '', left: ''});
                $(localVideoElement).removeClass('rtc-shadow');
            }
        }
    }

    $(window).on('resize', function () {
        if (connection) {
            connection.checkRemoteStreamsPositions(); // don't do this. arrange video elements through getRemoteVideos(), because videos should be swapable
        }
    });
};

PeerConnection.prototype.checkRemoteStreamsPositions = function () {
    var currentOptions = this.options;
    setTimeout(function () {

        var remoteVideoElement = $('#' + currentOptions.remoteVideoElement);
        var remoteVideos = $(remoteVideoElement).children();


        if (remoteVideos && remoteVideos.length > 0) {
            var localVideoElement = $('#' + currentOptions.localVideoElement);
            var offsetTop = $(localVideoElement).height() + 8;
            var firstSideRemote = true;

            for (var i = 0; i < remoteVideos.length; i++) {
                var remoteVideoElement = $(remoteVideos[i]);
                if ($(remoteVideoElement).hasClass('side-remote')) {
                    $(remoteVideoElement).css({position: 'relative', float: 'right', zIndex: 2, width: '25%', height: 'auto', top: offsetTop + 'px'});
                    var offsetLeft = $(remoteVideoElement).width() - 5;
                    $(remoteVideoElement).css({left: (firstSideRemote === true ? '-5px' : offsetLeft + 'px')});
                    offsetTop += $(remoteVideoElement).height() + 3;
                    firstSideRemote = false;
                }
            }
        } else {

        }
    }, 300);
};

PeerConnection.prototype.getPeers = function () {
    if (webrtc) {
        return webrtc.getPeers();
    }
    return null;
};

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
            if (options.localStream.record === 'yes') {
                connection.startRecording(true);
                connection.showRecordIndicator();
            } else {
                connection.hideRecordInidicator();
            }
        } else {
            console.log('no options, no states update');
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
    var currentOptions = connection.options;
    $('#' + currentOptions.localVideoElement).addClass('rtc-shadow');
    $('#' + currentOptions.localVideoElement).css({width: '30%', height: 'auto', left: 5, top: 5});
    $('#' + currentOptions.remoteVideoElement).css({opacity: 1});
};

PeerConnection.prototype.hideRemoteStream = function () {
    var currentOptions = this.options;
    $('#' + currentOptions.localVideoElement).removeClass('rtc-shadow');
    $('#' + currentOptions.remoteVideoElement).css({opacity: 0});
    $('#' + currentOptions.localVideoElement).css({width: '', height: '', left: '', top: ''});
};

PeerConnection.prototype.showRecordIndicator = function () {
    var currentOptions = this.options;

    var stream = $(currentOptions.callerElement);
    var indicator = $(stream).find('.record-stream-indicator').removeClass('hidden');
    TweenMax.to(indicator, 1, {opacity: 1, onComplete: function () {
            TweenMax.to(indicator, 1, {opacity: .2, yoyo: true, repeat: -1});
        }});

    showRecordIndicator();
};

PeerConnection.prototype.hideRecordInidicator = function () {
    var currentOptions = this.options;

    var stream = $(currentOptions.callerElement);
    var indicator = $(stream).find('.record-stream-indicator');
    TweenMax.to(indicator, .3, {opacity: 0, onComplete: function () {
            $(indicator).addClass('hidden');
        }});

    $(connection).trigger('hideRecordIndicator');
};


PeerConnection.prototype.mediaSources = function () {
    var currentOptions = this.options;
    return currentOptions.sources ? currentOptions.sources : null;
};


/*
 * recording
 */
var chunks = {};
var localMediaStream = null;
var mediaRecorder = null;
PeerConnection.prototype.initRecording = function (startRecording) {
    if (!mediaRecorder) {
        console.log('init local stream recording');
        mediaRecorder = new MediaRecorder(localMediaStream);

        mediaRecorder.ondataavailable = function (event) {
            console.log('on data available');

            if (event.data && event.data.size > 0) {
                var currentPhase = getCurrentPhase();
                chunks[currentPhase.id].push(event.data);
            }
        };

        mediaRecorder.onstart = function () {
            console.log('Start recording ...');

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
            if (mediaRecorder) {
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

                mediaRecorder = null;
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
    } else if (mediaRecorder.state !== 'recording' && startRecording) {
        mediaRecorder.start(1000);
    }
};

PeerConnection.prototype.startRecording = function () {
    if (isWebRTCNeededForPhaseStep(getCurrentPhase())) {
        connection.initRecording(true);
    }
};

var stopRecordingCallback = null;
var saveRecording = false;
PeerConnection.prototype.stopRecording = function (callback, save) {
    console.log('stop recording');
    saveRecording = save;

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

var screenChunks = [];
var screenMediaRecorder = null;
PeerConnection.prototype.initScreenRecording = function () {
    var localScreenStream = webrtc.getLocalScreen();
    console.log('initScreenRecording');
    screenMediaRecorder = new MediaRecorder(localScreenStream);

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
    console.log('stop record screen sharing');
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

var snapshotTimer = null;
PeerConnection.prototype.takeSnapshot = function (upload) {
    var snapshotUrl = getLocalItem(STUDY).snapshot;

    if (snapshotUrl && snapshotUrl !== '') {
        return snapshotUrl;
    } else {
        clearTimeout(snapshotTimer);
        snapshotTimer = setTimeout(function () {
            var localStream = $('#' + connection.options.localVideoElement)[0];

            // create snapshot from stream
            var canvas = document.createElement('canvas');
            canvas.width = $(localStream).width();
            canvas.height = $(localStream).height();
            var ctx = canvas.getContext('2d');

            ctx.drawImage($(localStream)[0], 0, 0, canvas.width, canvas.height);
            canvas.toBlob(function (blob) {
                var colorThief = new ColorThief();
                var dominantColor = colorThief.getColor(canvas);

                // black frame detection
                if (dominantColor && (dominantColor[0] + dominantColor[1] + dominantColor[2]) > 0) {

                    if (upload && upload === true) {
                        var filename = hex_sha512(new Date().getTime() + "" + chance.natural()) + '.jpg';
                        var snapshotUploadQueue = new UploadQueue();
                        $(snapshotUploadQueue).bind(EVENT_ALL_FILES_UPLOADED, function () {
                            var url = snapshotUploadQueue.getUploadURLs()[0];
                            var study = getLocalItem(STUDY);
                            study.snapshot = url;
                            setLocalItem(STUDY, study);
                        });
                        snapshotUploadQueue.upload([blob], filename);
                    }
                } else {
                    console.log('black frame of snapshot detected');
                }
            }, 'image/jpeg', 0.8);
        }, 10000);
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
        webrtc.shareScreen(function (error) {
            if (error) {
                if (errorCallback) {
                    errorCallback(error);
                }
            } else {
                if (successCallback) {
                    successCallback();
                }
            }
        });
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
};

PeerConnection.prototype.keepStreamsPlaying = function () {
    if (webrtc && this.status !== STATUS_UNINITIALIZED) {
        var peers = webrtc.getPeers();
        if (peers && peers.length > 0) {
            for (var i = 0; i < peers.length; i++) {
                var videoElement = peers[i].videoEl;
                if (videoElement && videoElement !== undefined) {
                    videoElement.play();
                }
            }
        }

        var localContainer = webrtc.getLocalVideoContainer();
        if (localContainer) {
            localContainer.play();
        }
    }
};


PeerConnection.prototype.isObserverConnected = function () {
    var peers = connection.getPeers();
    if (peers && peers.length > 0) {
        for (var i = 0; i < peers.length; i++) {
            if (peers[i].nick === VIEW_OBSERVER) {
                return true;
            }
        }
    }

    return false;
};


PeerConnection.prototype.isWizardConnected = function () {
    var peers = connection.getPeers();
    if (peers && peers.length > 0) {
        for (var i = 0; i < peers.length; i++) {
            if (peers[i].nick === VIEW_WIZARD) {
                return true;
            }
        }
    }

    return false;
};