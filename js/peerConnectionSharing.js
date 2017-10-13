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

PeerConnectionSharing.prototype.status = STATUS_UNINITIALIZED;
PeerConnectionSharing.prototype.options = null;

var TYPE_MESSAGE_CONTROL = 'controlMessage';

var sharingWebrtc = null;
var sharingConnection = null;
//var syncPhaseStep = false;

var STUN = {
    'url': 'stun:stun.l.google.com:19302'
};

var TURN = {
    url: 'turn: danielkuenkel%40googlemail.com%40numb.viagenie.ca: 3478',
    credential: 'GpE-y3D-9YC-d9o'
};

function PeerConnectionSharing(isRecordingNeeded) {
    sharingConnection = this;
    if (isRecordingNeeded === true && isRecordingNeededInFuture()) {
        sharingConnection.initScreenRecording();
    }
}

PeerConnectionSharing.prototype.initialize = function (options) {
    if (options) {
        console.log('initialize sharing peer connection');
        this.options = options;

        sharingWebrtc = new SimpleWebRTC({
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

        // we have to wait until it's ready
        sharingWebrtc.on('readyToCall', function () {
            if (sharingConnection.options.roomId !== undefined) {
                console.log('ready to call', sharingConnection.options.roomId);
                sharingWebrtc.joinRoom(sharingConnection.options.roomId);
            }

//            if (!syncPhaseStep && connection.options.remoteStream.video === 'no') {
//                connection.update(connection.options);
//            }
        });

        // we got access to the camera
        sharingWebrtc.on('localStream', function (stream) {
            console.log('on local stream');
        });

        // we did not get access to the camera
        sharingWebrtc.on('localMediaError', function (err) {
            console.log('local media error');
        });

        sharingWebrtc.connection.on('message', function (data) {
//            console.log('on message', data);
            $(sharingConnection).trigger(data.type, [data.payload]);
        });

        // a peer video has been added
        sharingWebrtc.on('videoAdded', function (video, peer) {
            console.log('webrtc video added', peer);
            if (peer && peer.type === TYPE_PEER_SCREEN) {
                if (options.sharingVideoElement) {
                    $(options.sharingVideoElement).empty().append(video);
                }
            } else {
                $(sharingConnection).trigger('videoAdded', [video]);
//                if (!syncPhaseStep) {
//                    connection.update(connection.options);
//                }

                if (options.remoteMuteElement) {
                    $(options.remoteMuteElement).removeClass('disabled');
                }
            }
        });

        // a peer video has been removed
        sharingWebrtc.on('videoRemoved', function (video, peer) {
            console.log('web rtc video removed', video);
            if (options.sharingVideoElement) {
                $(video).remove();
            }

            $(sharingConnection).trigger('videoRemoved');
            $('#local-stream').removeClass('rtc-shadow');
        });

        // local screen obtained
        sharingWebrtc.on('localScreenAdded', function (video) {
            console.log('local screen added');
//            video.onclick = function () {
//                video.style.width = video.videoWidth + 'px';
//                video.style.height = video.videoHeight + 'px';
//            };
//            document.getElementById('localScreenContainer').appendChild(video);
//            $('#localScreenContainer').show();
            if (options.sharingVideoElement) {
                $(options.sharingVideoElement).empty().append(video);
            }
        });

        sharingWebrtc.on('stunservers', function (event) {
            console.log('on stun servers', event);
        });

        sharingWebrtc.on('turnservers', function (event) {
            console.log('on turn servers', event);
        });

        // local p2p/ice failure
        sharingWebrtc.on('iceFailed', function (peer) {
            var pc = peer.pc;
            console.log('had local relay candidate', pc.hadLocalRelayCandidate);
            console.log('had remote relay candidate', pc.hadRemoteRelayCandidate);

            if (sharingConnection.options.localStream.record === 'yes') {
                sharingConnection.stopRecording(null, false);
            }
        });

        // remote p2p/ice failure
        sharingWebrtc.on('connectivityError', function (peer) {
            var pc = peer.pc;
            console.log('had local relay candidate', pc.hadLocalRelayCandidate);
            console.log('had remote relay candidate', pc.hadRemoteRelayCandidate);
            sharingConnection.stopRecording(null, false);
        });

        // called when a peer is created
        sharingWebrtc.on('createdPeer', function (peer) {
            webRTCPeer = peer;
            console.log('webrtc created peer', peer);

            webRTCPeer.on('fileTransfer', function (metadata, receiver) {
                console.log('incoming filetransfer', metadata.name, metadata);
                receiver.on('progress', function (bytesReceived) {
//                    console.log('receive progress', bytesReceived, 'out of', metadata.size);
                    $(sharingConnection).trigger(EVENT_FILE_TRANSFER, [bytesReceived, metadata.size]);
                });

                // get notified when file is done
                receiver.on('receivedFile', function (file, metadata) {
                    console.log('received file', file, metadata.name, metadata.size);
                    $(sharingConnection).trigger(EVENT_RECEIVED_FILE, [file, metadata]);
                    // close the channel
                    receiver.channel.close();
                });
            });
        });
    } else {
        console.log('no options for webrtc');
    }
};




PeerConnectionSharing.prototype.joinRoom = function (roomId) {
    if (sharingWebrtc) {
        sharingWebrtc.joinRoom(roomId);
    }
};

PeerConnectionSharing.prototype.leaveRoom = function () {
    if (sharingWebrtc) {
        sharingWebrtc.leaveRoom();
    }
};

PeerConnectionSharing.prototype.sendMessage = function (message, payload) {
    if (sharingWebrtc) {
        console.log("SEND:", message, payload);
        sharingWebrtc.sendToAll(message, payload || null);
    }
};

var screenChunks = [];
var screenMediaRecorder = null;
PeerConnectionSharing.prototype.initScreenRecording = function () {
    var localScreenStream = sharingWebrtc.getLocalScreen();
    screenMediaRecorder = new MediaRecorder(localScreenStream);

    screenMediaRecorder.ondataavailable = function (e) {
        console.log('on screen sharing data available');
        screenChunks.push(e.data);
    };

    screenMediaRecorder.onstop = function () {
        console.log('Stopped screen recording, state = ' + screenMediaRecorder.state + ', ' + new Date());
        if (saveScreenRecording) {
            console.log('Save screen recording');
            var filename = hex_sha512(new Date().getTime() + "" + chance.natural()) + '.webm';
            uploadQueue.upload(screenChunks, filename, getCurrentPhase().id);
        }
        
        screenChunks = [];

        if (stopScreenRecordingCallback) {
            stopScreenRecordingCallback();
        }
    };

    screenMediaRecorder.start(1000);
};

PeerConnectionSharing.prototype.startScreenRecording = function () {
    console.log('start record screen sharing');
    sharingConnection.initScreenRecording();
};

var stopScreenRecordingCallback = null;
var saveScreenRecording = false;
PeerConnectionSharing.prototype.stopScreenRecording = function (save, callback) {
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

//PeerConnectionSharing.prototype.transferFile = function (file) {
//    if (webRTCPeer) {
//        webRTCPeer.sendFile(file);
//    } else {
//        console.error('no peer created yet');
//    }
//};

PeerConnectionSharing.prototype.shareScreen = function (errorCallback, successCallback) {
    if (sharingWebrtc && sharingWebrtc.capabilities.supportScreenSharing) {
        try {
            sharingWebrtc.shareScreen(function (error) {
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

PeerConnectionSharing.prototype.stopShareScreen = function (save, callback) {
    sharingConnection.stopScreenRecording(save, callback);
    if (sharingWebrtc) {
        console.log('stop screen sharing');
        sharingWebrtc.stopScreenShare();
    }
};