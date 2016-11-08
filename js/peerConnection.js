/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var TYPE_MESSAGE_CONTROL = 'controlMessage';

var webrtc = null;
var connection = null;
var timeline = null;

function PeerConnection(options) {
    connection = this;
    if (options) {
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

            if (!timeline) {
                var width = Math.floor($('#' + options.localVideoElement).width() * .3);
                var height = Math.floor(width * 3 / 4);
                timeline = new TimelineMax({paused: true, delay: 1.0, onComplete: onAddStreamTweenComplete});
                timeline.add(TweenMax.to($('#' + options.localVideoElement), .3, {width: width, height: height, left: 5, top: 5, ease: Quad.easeIn}));
                timeline.add(TweenMax.to($('#' + options.remoteVideoElement), .3, {opacity: 1.0}));
            }

            connection.update(options);
        });

        // a peer video has been added
        webrtc.on('videoRemoved', function (video, peer) {
            $(connection).trigger('videoRemoved');
            $('#local-stream').removeClass('rtc-shadow');
            if (timeline) {
                timeline.reverse();
            }
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

$(window).on('resize', function () {
//            console.log($('#column-right'))
    var offset = $('.rtc-remote-container').find('video').height() - $('#local-stream').height();
    $('#local-stream').css({marginBottom: offset + 'px'});
//            $('.rtc-remote-container')
});

function onAddStreamTweenComplete() {
    $(window).resize();
}

PeerConnection.prototype.update = function (options) {
    if (webrtc && options) {
        console.log('update caller states', options);

        if (options.localStream.video === 'yes' && options.localStream.visualize === 'yes') {
            $('#' + options.localVideoElement).removeClass('hidden');
            TweenMax.to($('#' + options.localVideoElement), .3, {opacity: 1.0});

            if (options.remoteStream.video === 'yes') {
                $('#' + options.remoteVideoElement).removeClass('hidden');
                $('#' + options.localVideoElement).addClass('rtc-shadow');
                timeline.play();
            } else {
                $('#' + options.remoteVideoElement).addClass('hidden');
                $('#' + options.localVideoElement).removeClass('rtc-shadow');
                timeline.reverse();
            }
        } else {
            $('#' + options.localVideoElement).addClass('hidden');

            if (options.remoteStream.video === 'yes') {
                $('#' + options.remoteVideoElement).removeClass('hidden');
                TweenMax.to($('#' + options.remoteVideoElement), .3, {opacity: 1.0});
            } else {
                $('#' + options.remoteVideoElement).addClass('hidden');
            }
        }
    } else {
        console.log('no options no states update');
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

PeerConnection.prototype.sendMessage = function (message, options) {
    if (webrtc) {
        webrtc.sendToAll(TYPE_MESSAGE_CONTROL, {message: message, options: options || null});
    }
};