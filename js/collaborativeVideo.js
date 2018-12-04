/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var peerConnection = null;
var syncPhaseStep = false;
var joinedRoom = false;
var selectedVideoSource = null;
var selectedAudioSource = null;

function checkCollaborativeConversation() {
    var query = getQueryParams(document.location.search);

    if (query && query.joinedConv && query.joinedConv === 'true') {
        $($('.btn-join-conversation')[0]).click();
    } else {
        $('.btn-join-conversation').removeClass('hidden');
    }
}

function initCollaborativeVideoCaller(roomId) {
    var mainElement = $('#video-caller');
    var selectedRole = chance.natural();
    var query = getQueryParams(document.location.search);

    var callerOptions = {
        callerElement: mainElement,
        localVideoElement: 'localVideo',
        remoteVideoElement: 'remoteVideo',
        streamControls: $(mainElement).find('#stream-controls'),
        localMuteElement: $(mainElement).find('#btn-stream-local-mute'),
        pauseStreamElement: $(mainElement).find('#btn-pause-stream'),
        remoteMuteElement: $(mainElement).find('#btn-stream-remote-mute'),
        indicator: $(mainElement).find('#stream-control-indicator'),
        configPanel: $('#video-caller-container').find('#rtc-config-panel'),
        configElement: $(mainElement).find('#btn-config-rtc'),
        enableWebcamStream: true,
        enableDataChannels: true,
        autoRequestMedia: true,
        roomId: roomId,
        nick: selectedRole,
        ignoreRole: 'yes',
        selectedRole: selectedRole,
        maxParticipants: 3,
        videoSource: query.vSource ? query.vSource : null,
        audioSource: query.aSource ? query.aSource : null,
        localStream: {audio: 'yes', video: 'yes', visualize: 'yes'},
        remoteStream: {audio: 'yes', video: 'yes'}
    };

    peerConnection = new PeerConnection();
    peerConnection.initialize(callerOptions);

    $(peerConnection).on('joinedRoom', function (event, roomName) {
        event.preventDefault();
        joinedRoom = true;

        if (window.history.replaceState) {
            setParam(window.location.href, 'joinedConv', 'true');
        }

        $('.btn-join-conversation').addClass('hidden');
        $('.btn-leave-conversation').removeClass('hidden');
        $('#draggableCollaborativeRTC').removeClass('hidden');
    });

    $(peerConnection).on('leftRoom', function (event, roomName) {
        event.preventDefault();
        joinedRoom = false;

        if (window.history.replaceState) {
            setParam(window.location.href, 'joinedConv', 'false');
        }

        $('.btn-join-conversation').removeClass('hidden');
        $('.btn-leave-conversation').addClass('hidden');
        $('#draggableCollaborativeRTC').addClass('hidden');
    });

    $(peerConnection).on('renegotiate', function (event, videoSource, audioSource) {
        event.preventDefault();
        peerConnection.leaveRoom();
        initCollaborativeVideoCaller(roomId);
    });

    var draggableRTC = $('#draggableCollaborativeRTC');
    var resizing = false;
    var resizable = false;
    var draggable = null;

    $(draggableRTC).unbind('mousemove').bind('mousemove', function (event) {
        var x = event.pageX - $(this).offset().left;
        var y = event.pageY - $(this).offset().top;

        if (!resizing) {
            if (x > this.scrollWidth - 20 && y > this.scrollHeight - 20) {
                showCursor($(this), CURSOR_NWSE_RESIZE);
                resizable = true;
            } else {
                resizable = false;
                showCursor($(this), CURSOR_MOVE);
            }
        }
    });

    $(window).mousemove(function (event) {
        event.preventDefault();
        if (draggable) {
            $('body').addClass('readonly-without-mouse');
            if (resizable) {
                var newWidth = Math.min(Math.max(event.pageX - $(draggableRTC).offset().left, DRAGGABLE_CONVERSATION_MIN_WIDTH), DRAGGABLE_MAX_WIDTH);
                $(draggableRTC).find('#video-caller-container').css({width: newWidth + 'px', height: 'auto'});
            } else {
                var x = event.pageX - draggable.offsetLeft;
                var y = event.pageY - draggable.offsetTop;
                $(draggableRTC).offset({
                    left: x,
                    top: y
                });
            }
        }
    });

    $(draggableRTC).unbind('mousedown').bind('mousedown', function (event) {
        draggable = {offsetLeft: event.pageX - $(draggableRTC).offset().left, offsetTop: event.pageY - $(draggableRTC).offset().top};
        if (resizable) {
            resizing = true;
        }
    });

    $(window).unbind('mouseup').bind('mouseup', function (event) {
        draggable = null;
        $('body').removeClass('readonly-without-mouse');
        if (resizable && resizable === true) {
            resizable = false;
            resizing = false;
            $(draggableRTC).css({opacity: .7});
        }
    });

    $(draggableRTC).unbind('mouseenter').bind('mouseenter', function (event) {
        event.preventDefault();
        $(draggableRTC).css({opacity: 1});
    });

    $(draggableRTC).unbind('mouseleave').bind('mouseleave', function (event) {
        if (draggable) {
            event.stopImmediatePropagation();
        } else {
            event.preventDefault();
            if (!resizing) {
                $(draggableRTC).css({opacity: .7});
                draggable = null;
                resizable = false;
                showCursor($(this), CURSOR_AUTO);
            }
        }
    });

    $(draggableRTC).find('#btn-leave-room').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $('.btn-leave-conversation').click();
    });
}

function leaveCollaborativeVideoCaller() {
    if (peerConnection) {
        peerConnection.leaveRoom();
    }
}