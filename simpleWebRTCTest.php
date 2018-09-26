<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $lang->gestureNote ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- third party sources -->
        <link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/greensock/TweenMax.min.js"></script>
        <script src="js/chance.min.js"></script>
        <script src="js/sha512.js"></script>

        <script src="js/peerConnection.js"></script>
        <script src="js/andyet/simplewebrtc.bundle.js"></script>
        <script src="js/muazkhan/DetectRTC.min.js"></script>


        <!-- gesturenote specific sources -->
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">

        <script src="js/ajax.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/globalFunctions.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60" style="padding-bottom: 0px">

        <!-- externals -->
        <div id="template-general"></div>


        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb"style="margin-top: 0px">
            <!--            <div class="row">
                            <ol class="breadcrumb">-->
            <!--                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                                <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                                <li class="active"><?php echo $lang->breadcrump->informations ?></li>-->
            <!--                </ol>
                        </div>-->
        </div>


        <!-- Container (Landing Section) -->
        <!--        <div class="container">
                    <button class="btn btn-default" id="startButton">Start</button>
                    <button class="btn btn-default" id="callButton">Call</button>
                    <button class="btn btn-default" id="hangupButton">Hangup</button>
                </div>-->

        <div class="container mainContent" style="margin-top: 0px">
            <!--            <div id="check-rtc-status" class="hidden">
                            <h3>Technische Überprüfung</h3>
                            <div class="check-web-rtc">
                                <span class="status-check-indicator">
                                    <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                                    <i class="status-warn fa fa-warning warning hidden"></i>
                                    <i class="status-supported fa fa-check success hidden"></i>
                                </span>
                                <span class="status-check-text text">WebRTC</span>
                            </div>
                            <div class="check-webcam">
                                <span class="status-check-indicator">
                                    <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                                    <i class="status-warn fa fa-warning warning hidden"></i>
                                    <i class="status-supported fa fa-check success hidden"></i>
                                </span>
                                <span class="status-check-text text">Webcam</span>
                            </div>
                            <div class="check-microphone">
                                <span class="status-check-indicator">
                                    <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                                    <i class="status-warn fa fa-warning warning hidden"></i>
                                    <i class="status-supported fa fa-check success hidden"></i>
                                </span>
                                <span class="status-check-text text">Mikrofon</span>
                            </div>
                            <div class="check-speakers">
                                <span class="status-check-indicator">
                                    <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                                    <i class="status-warn fa fa-warning warning hidden"></i>
                                    <i class="status-supported fa fa-check success hidden"></i>
                                </span>
                                <span class="status-check-text text">Audioausgabe</span>
                            </div>
            
                            <div class="hidden progress" id="init-timer-progress" style="height: 10px; border-radius: 5px; margin-top: 10px">
                                <div class="progress-bar progress-bar-primary" id="init-timer-progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%; width: 100%; background-color: #5cb85c"></div>
                            </div>
                            <div class="text-center" style="margin-top: -20px; margin-bottom: 20px">initialisieren …</div>
                        </div>-->

            <div>
                <div class="select">
                    <label for="audioSource">Audio input source: </label><select id="audioSource"></select>
                </div>

                <div class="select">
                    <label for="audioOutput">Audio output destination: </label><select id="audioOutput"></select>
                </div>

                <div class="select">
                    <label for="videoSource">Video source: </label> <select id="videoSource"></select>
                </div>


                <div class="select">
                    <label for="participantRole">Role ignorieren? </label> 
                    <select id="ignoreRole">
                        <option value="yes">Ja</option>
                        <option value="no">Nein</option>
                    </select>
                </div>

                <div class="select">
                    <label for="participantRole">Role: </label> 
                    <select id="participantRole">
                        <option value="tester">Proband</option>
                        <option value="moderator">Modarator</option>
                        <option value="wizard">Wizard</option>
                        <option value="observer">Beobachter</option>
                    </select>
                </div>

                <button id="btn-join-room" class="btn btn-default btn-block"><i class="fa"></i> Konversation beitreten</button>
                <button id="btn-leave-room" class="btn btn-default btn-block hidden"><i class="fa"></i> Konversation verlassen</button>
            </div>                


            <!--<video id="localVideo" autoplay muted></video>-->
            <!--<div id="remoteVideo"></div>-->
            <div style="max-width: 400px; margin: 0 auto" id="video-caller-container" class="hidden">
                <div class="embed-responsive embed-responsive-4by3" id="video-caller" style="margin-top: 20px">
                    <div class="embed-responsive-item" style="border-radius: 4px; background-color: #eee; display: flex; justify-content: center; align-items: center;">
                        <i class="fa fa-circle-o-notch fa-spin fa-3x"></i>
                    </div>
                    <div id="remoteVideo" class="rtc-remote-container rtc-stream embed-responsive-item" style="border-radius: 4px;"></div>
                    <div class="rtc-local-container embed-responsive-item">
                        <video autoplay id="localVideo" class="rtc-stream" style="position: relative; height: auto"></video>
                    </div>
                </div>

                <div class="btn-group" id="stream-controls" style="position: absolute; bottom: 6px; left: 50%; transform: translate(-50%, 0); opacity: 0">
                    <button type="button" class="btn stream-control" id="btn-stream-local-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->muteMicrofone ?>"><i class="fa fa-microphone-slash"></i> </button>
                    <button type="button" class="btn stream-control" id="btn-pause-stream" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOwnWebRTC ?>"><i class="fa fa-pause"></i> </button>
                    <button type="button" class="btn stream-control" id="btn-stream-remote-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOtherWebRTC ?>"><i class="fa fa-volume-up"></i> </button>
                </div>
                <div id="stream-control-indicator">
                    <div style="position: absolute; top: 4px; display: block; left: 10px; opacity: 1; color: white">
                        <i id="mute-local-audio" class="hidden fa fa-microphone-slash" style="margin-right: 3px"></i>
                        <i id="pause-local-stream" class="hidden fa fa-pause"></i>
                    </div>
                    <div style="position: absolute; top: 4px; display: block; right: 10px; opacity: 1; color: white">
                        <i id="mute-remote-audio" class="hidden fa fa-microphone-slash"></i>
                        <i id="pause-remote-stream" class="hidden fa fa-pause" style="margin-left: 3px"></i>
                    </div>
                </div>
            </div>

        </div>

        <script>
            var selectedRole = null;
            var ignoreRole = null;
            var webrtc = null;
            var peerConnection = null;
            var syncPhaseStep = false;

            $(document).ready(function () {
                checkDomain();
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements(false);
                checkRTC($('#check-rtc-status'));
            }

            function checkRTC(target) {
                DetectRTC.load(function () {
                    navigator.mediaDevices.getUserMedia({
                        audio: true, // { deviceId: 'mic-id' }
                        video: true // { deviceId: 'camera-id' }
                    }).then(function (stream) {
                        var indicator = null;
                        var errors = 0;

                        if (DetectRTC.isWebRTCSupported === false) {
                            errors++;
                            indicator = $(target).find('.check-web-rtc .status-check-indicator');
                            $(indicator).find('.status-wait').addClass('hidden');
                            $(indicator).find('.status-warn').removeClass('hidden');
                        } else {
                            indicator = $(target).find('.check-web-rtc .status-check-indicator');
                            $(indicator).find('.status-wait').addClass('hidden');
                            $(indicator).find('.status-supported').removeClass('hidden');
                        }

                        if (DetectRTC.hasWebcam === false) {
                            errors++
                            indicator = $(target).find('.check-webcam .status-check-indicator');
                            $(indicator).find('.status-wait').addClass('hidden');
                            $(indicator).find('.status-warn').removeClass('hidden');
                        } else {
                            indicator = $(target).find('.check-webcam .status-check-indicator');
                            $(indicator).find('.status-wait').addClass('hidden');
                            $(indicator).find('.status-supported').removeClass('hidden');
                        }

                        if (DetectRTC.hasMicrophone === false) {
                            errors++;
                            indicator = $(target).find('.check-microphone .status-check-indicator');
                            $(indicator).find('.status-wait').addClass('hidden');
                            $(indicator).find('.status-warn').removeClass('hidden');
                        } else {
                            indicator = $(target).find('.check-microphone .status-check-indicator');
                            $(indicator).find('.status-wait').addClass('hidden');
                            $(indicator).find('.status-supported').removeClass('hidden');
                        }

                        if (DetectRTC.hasSpeakers === false && (DetectRTC.browser.name === 'Chrome' || DetectRTC.browser.name === 'Edge')) {
                            errors++;
                            indicator = $(target).find('.check-speakers .status-check-indicator');
                            $(indicator).find('.status-wait').addClass('hidden');
                            $(indicator).find('.status-warn').removeClass('hidden');
                        } else {
                            indicator = $(target).find('.check-speakers .status-check-indicator');
                            $(indicator).find('.status-wait').addClass('hidden');
                            $(indicator).find('.status-supported').removeClass('hidden');
                        }

                        $(target).find('#init-timer-progress').removeClass('hidden');
                        if (errors === 0) {
//                            var progressBar = $('#init-timer-progress-bar');
//                            $(progressBar).css({width: '100%'});
//                            TweenMax.to(progressBar, 5, {width: '0%', ease: Linear.easeNone, onComplete: function () {
                            $('#check-rtc-status').addClass('hidden');
                            renderDevices();
//                                    initVideoCaller();
//                                }});
                        } else {
                        }
                    });
                });
            }


            function renderDevices() {
                var videoElement = $('#localVideo');//document.querySelector('localVideo');
                var audioInputSelect = document.querySelector('select#audioSource');
                var audioOutputSelect = document.querySelector('select#audioOutput');
                var videoSelect = document.querySelector('select#videoSource');
                var selectors = [audioInputSelect, audioOutputSelect, videoSelect];

                audioOutputSelect.disabled = !('sinkId' in HTMLMediaElement.prototype);

                function gotDevices(deviceInfos) {
                    // Handles being called several times to update labels. Preserve values.
                    var values = selectors.map(function (select) {
                        return select.value;
                    });
                    selectors.forEach(function (select) {
                        while (select.firstChild) {
                            select.removeChild(select.firstChild);
                        }
                    });

                    for (var i = 0; i !== deviceInfos.length; ++i) {
                        var deviceInfo = deviceInfos[i];
                        var option = document.createElement('option');
                        option.value = deviceInfo.deviceId;
                        if (deviceInfo.kind === 'audioinput') {
                            option.text = deviceInfo.label ||
                                    'microphone ' + (audioInputSelect.length + 1);
                            audioInputSelect.appendChild(option);
                        } else if (deviceInfo.kind === 'audiooutput') {
                            option.text = deviceInfo.label || 'speaker ' +
                                    (audioOutputSelect.length + 1);
                            audioOutputSelect.appendChild(option);
                        } else if (deviceInfo.kind === 'videoinput') {
                            option.text = deviceInfo.label || 'camera ' + (videoSelect.length + 1);
                            videoSelect.appendChild(option);
                        } else {
                            console.log('Some other kind of source/device: ', deviceInfo);
                        }
                    }

                    selectors.forEach(function (select, selectorIndex) {
                        if (Array.prototype.slice.call(select.childNodes).some(function (n) {
                            return n.value === values[selectorIndex];
                        })) {
                            select.value = values[selectorIndex];
                        }
                    });
                }

                navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);

                // Attach audio output device to video element using device/sink ID.
                function attachSinkId(element, sinkId) {
                    if (typeof element.sinkId !== 'undefined') {
                        element.setSinkId(sinkId)
                                .then(function () {
                                    console.log('Success, audio output device attached: ' + sinkId);
                                })
                                .catch(function (error) {
                                    var errorMessage = error;
                                    if (error.name === 'SecurityError') {
                                        errorMessage = 'You need to use HTTPS for selecting audio output ' +
                                                'device: ' + error;
                                    }
                                    console.error(errorMessage);
                                    // Jump back to first output device in the list as it's the default.
                                    audioOutputSelect.selectedIndex = 0;
                                });
                    } else {
                        console.warn('Browser does not support output device selection.');
                    }
                }

                function changeAudioDestination() {
                    var audioDestination = audioOutputSelect.value;
                    attachSinkId(videoElement, audioDestination);
                }

                function gotStream(stream) {
                    console.log('got stream', videoElement, $(videoElement)[0]);
                    window.stream = stream; // make stream available to console
                    // Refresh button list in case labels have become available
                    initVideoCaller();
                    return navigator.mediaDevices.enumerateDevices();
                }

                function start() {
                    selectedRole = document.querySelector('select#participantRole').value;
                    ignoreRole = document.querySelector('select#ignoreRole').value;

                    if (window.stream) {
                        window.stream.getTracks().forEach(function (track) {
                            track.stop();
                        });
                    }
                    var audioSource = audioInputSelect.value;
                    var videoSource = videoSelect.value;
                    var constraints = {
                        audio: {deviceId: audioSource ? {exact: audioSource} : undefined},
                        video: {deviceId: videoSource ? {exact: videoSource} : undefined}
                    };

                    navigator.mediaDevices.getUserMedia(constraints).
                            then(gotStream).then(gotDevices).catch(handleError);
                }

//                audioInputSelect.onchange = start;
                audioOutputSelect.onchange = changeAudioDestination;
//                videoSelect.onchange = start;

                function handleError(error) {
                    console.log('navigator.getUserMedia error: ', error);
                }


                $('#btn-join-room').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
                        lockButton($(this), true);
                        start();
                        $('#video-caller-container').removeClass('hidden');
                    }
                });

                $('#btn-leave-room').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
                        if (webrtc) {
                            webrtc.leaveRoom();
                        }
                        $('#video-caller-container').addClass('hidden');
                    }
                });
            }

            function initVideoCaller() {
                var mainElement = $('#video-caller');
                console.log(mainElement);
                var callerOptions = {
                    callerElement: mainElement,
                    localVideoElement: 'localVideo',
                    remoteVideoElement: 'remoteVideo',
                    streamControls: $(mainElement).find('#stream-controls'),
                    localMuteElement: $(mainElement).find('#btn-stream-local-mute'),
                    pauseStreamElement: $(mainElement).find('#btn-pause-stream'),
                    remoteMuteElement: $(mainElement).find('#btn-stream-remote-mute'),
                    indicator: $(mainElement).find('#stream-control-indicator'),
                    enableWebcamStream: true,
                    enableDataChannels: true,
                    autoRequestMedia: true,
                    roomId: hex_sha512(window.location),
//                    iceTransports: iceTransports !== '' ? iceTransports : null,
                    nick: ignoreRole === 'yes' ? chance.natural() : selectedRole,
                    localStream: {audio: 'yes', video: 'yes', visualize: 'yes'},
                    remoteStream: {audio: 'yes', video: 'yes'}
                };

                peerConnection = new PeerConnection();
                peerConnection.initialize(callerOptions);

//                var iceServers = [
//                    {
//                        'urls': 'stun:stun.l.google.com:19302'
//                    },
//                    {
//                        urls: 'turn:numb.viagenie.ca',
//                        username: 'danielkuenkel%40googlemail.com',
//                        credential: 'jyjYhjFdVXygdGKJHHt6EVV9asapAms'
//                    }
//                ];
//
//                webrtc = new SimpleWebRTC({
//                    // the id/element dom element that will hold "our" video
//                    localVideoEl: 'localVideo',
//                    // the id/element dom element that will hold remote videos
//                    remoteVideosEl: 'remoteVideo',
//                    // immediately ask for camera access
//                    autoRequestMedia: true,
//                    nick: ignoreRole === 'yes' ? chance.natural() : selectedRole,
//                    peerConnectionConfig: {'iceServers': iceServers}
//                });
//
//                webrtc.on('readyToCall', function () {
//                    webrtc.joinRoom(hex_sha512(window.location));
//                });

//                webrtc.connection.on('message', function (data) {
//                    if (data.roomType === 'video') {
//                        $('#video-caller').trigger(data.type, [data.payload]);
//                    }
//                });

                $(peerConnection).unbind('duplicatedRoles').bind('duplicatedRoles', function (event, payload) {
                    if (selectedRole === payload.role) {
                        $('#btn-leave-room').click();
                        alert('Pro Konversation darf nur eine Rolle vergeben werden. Diese Rolle gibt es schon. Wählen Sie eine andere aus.');
                    }
                });

                $(peerConnection).on('joinedRoom', function (roomName) {
                    $('#localVideo').css({opacity: 1});
                    unlockButton($('#btn-join-room'), true);
                    $('#btn-join-room').addClass('hidden');
                    $('#btn-leave-room').removeClass('hidden');
                });

                $(peerConnection).on('leftRoom', function (roomName) {
//                    var localVideoElement = webrtc.getLocalVideoContainer();
                    $('#localVideo').css({opacity: 0});

                    peerConnection.destroy();

                    unlockButton($('#btn-leave-room'), true);
                    $('#btn-leave-room').addClass('hidden');
                    $('#btn-join-room').removeClass('hidden');
                });

                $(peerConnection).on('videoAdded', function (videoElement, peer) {
                    $(videoElement).attr('data-role', peer.nick);
                    if (peer.nick === selectedRole) {
                        peerConnection.sendMessage('duplicatedRoles', {role: selectedRole});
                    } else {
                        arrangePeerStreams();
                    }
                });

                $(peerConnection).on('videoRemoved', function (videoElement, peer) {
                    arrangePeerStreams();
                });

                function arrangePeerStreams() {
                    var peers = peerConnection.getPeers();
                    var localVideoElement = $('#localVideo');

                    if (ignoreRole === 'no') {
                        if (peers && peers.length > 1) {
                            $(localVideoElement).css({width: '30%', top: '5px', left: '5px'});
                            $(localVideoElement).addClass('rtc-shadow');

                            var lastVideoElement = null;
                            for (var i = 0; i < peers.length; i++) {
                                var remoteVideoElement = $(peers[i].videoEl);
                                $(remoteVideoElement).removeClass('main-remote side-remote');
                                if ((selectedRole === 'moderator' || selectedRole === 'wizard' || selectedRole === 'observer') && peers[i].nick === 'tester') {
                                    $(remoteVideoElement).removeClass('rtc-shadow').addClass('main-remote');
                                    $(remoteVideoElement).css({position: '', float: '', zIndex: '', width: '', height: 'auto', top: '', left: ''});
                                } else if (selectedRole === 'tester' && peers[i].nick === 'moderator') {
                                    $(remoteVideoElement).removeClass('rtc-shadow').addClass('main-remote');
                                    $(remoteVideoElement).css({position: '', float: '', zIndex: '', width: '', height: 'auto', top: '', left: ''});

                                } else {
                                    lastVideoElement = remoteVideoElement;
                                    $(remoteVideoElement).addClass('rtc-shadow side-remote').removeClass('main-remote');
//                                    var offsetTop = $('#localVideo').height() + 8;
//                                    $(remoteVideoElement).css({position: 'relative', float: 'right', zIndex: 2, width: '25%', height: 'auto', top: offsetTop + 'px', left: '-5px'});
                                }

                                if (selectedRole === 'tester' && $(remoteVideoElement).attr('data-role') !== 'moderator') {
                                    $(remoteVideoElement).addClass('hidden');
                                } else {
                                    $(remoteVideoElement).removeClass('hidden');
                                }
                            }

                            checkRemoteStreamsPositions();
                        } else if (peers.length === 1) {
                            $(localVideoElement).addClass('rtc-shadow');
                            $(localVideoElement).css({width: '30%', top: '5px', left: '5px'});

                            var remoteVideoElement = $(peers[0].videoEl);
                            $(remoteVideoElement).removeClass('rtc-shadow').addClass('main-remote');
                            $(remoteVideoElement).css({position: '', float: '', zIndex: '', width: '', height: 'auto', top: '', left: ''});

                            if (selectedRole === 'tester' && $(remoteVideoElement).attr('data-role') !== 'moderator') {
                                $(remoteVideoElement).addClass('hidden');
                            } else {
                                $(remoteVideoElement).removeClass('hidden');
                            }
                        } else {
                            $(localVideoElement).removeClass('rtc-shadow');
                            $(localVideoElement).css({width: '', top: '', left: ''});
                        }
                    } else {
                        if (peers && peers.length > 1) {
                            $(localVideoElement).css({width: '30%', top: '5px', left: '5px'});
                            $(localVideoElement).addClass('rtc-shadow');

                            var lastVideoElement = null;
                            for (var i = 0; i < peers.length; i++) {
                                var remoteVideoElement = $(peers[i].videoEl);
                                $(remoteVideoElement).removeClass('main-remote side-remote');

                                if (i === 0) {
                                    $(remoteVideoElement).removeClass('rtc-shadow hidden').addClass('main-remote');
                                    $(remoteVideoElement).css({position: '', float: '', zIndex: '', width: '', height: 'auto', top: '', left: ''});
                                } else {
//                                    lastVideoElement = remoteVideoElement;
                                    $(remoteVideoElement).addClass('rtc-shadow side-remote');
                                }
                            }

                            checkRemoteStreamsPositions();
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

                var checkTimer = null;
                function checkRemoteStreamsPositions(checkRoles) {
                    clearTimeout(checkTimer);
                    if (peerConnection) {
                        checkTimer = setTimeout(function () {
                            var remoteVideos = $('#remoteVideo').children();

                            if (remoteVideos && remoteVideos.length > 0) {
                                var offsetTop = $('#localVideo').height() + 8;
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
                    }
                }

                $(window).on('resize', function () {
                    checkRemoteStreamsPositions(); // don't do this. arrange video elements through getRemoteVideos(), because videos should be swapable
                });
            }
        </script>

    </body>
</html>