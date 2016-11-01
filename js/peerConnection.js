/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var TYPE_MESSAGE_CONTROL = 'controlMessage';

var webrtc = null;
function PeerConnection(options) {
    if (options) {
        var connection = this;
        webrtc = new SimpleWebRTC({
            // the id/element dom element that will hold "our" video
            localVideoEl: options.localVideoElement || null,
            // the id/element dom element that will hold remote videos
            remoteVideosEl: options.remoteVideoElement || null,
            // immediately ask for camera access
            autoRequestMedia: true, // immediately ask for camera access
            localVideo: {
                autoplay: true, // automatically play the video stream on the page
                mirror: true, // flip the local video to mirror mode (for UX)
                muted: true // mute local video stream to prevent echo
            },
            enableDataChannels: options.enableDataChannels || false
        });

        webrtc.connection.on('message', function (data) {
            if (data.type === TYPE_MESSAGE_CONTROL) {
                $(connection).trigger('controlMessage', [data.payload]);
            }
        });

        // we have to wait until it's ready
        webrtc.on('readyToCall', function () {
            console.log('ready to call', options.roomId);
            webrtc.joinRoom(options.roomId);
        });

        // a peer video has been added
        webrtc.on('videoAdded', function (video, peer) {
            $(connection).trigger('videoAdded');
        });

        // a peer video has been added
        webrtc.on('videoRemoved', function (video, peer) {
            $(connection).trigger('videoRemoved');
        });

        // local p2p/ice failure
        webrtc.on('iceFailed', function (peer) {
            var pc = peer.pc;
            console.log('had local relay candidate', pc.hadLocalRelayCandidate);
            console.log('had remote relay candidate', pc.hadRemoteRelayCandidate);
        });

        // remote p2p/ice failure
        webrtc.on('connectivityError', function (peer) {
            var pc = peer.pc;
            console.log('had local relay candidate', pc.hadLocalRelayCandidate);
            console.log('had remote relay candidate', pc.hadRemoteRelayCandidate);
        });
    }
}

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

PeerConnection.prototype.sendMessage = function (message, options) {
    if (webrtc) {
        webrtc.sendToAll(TYPE_MESSAGE_CONTROL, {message: message, options: options || null});
    }
};