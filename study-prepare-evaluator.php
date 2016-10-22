<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

session_start();
$h = getv('h');
$studyId = getv('studyId');
$token = getv('token');

if ($h && $token && $studyId) {
    if (login_check($mysqli) == true) {
        $hash = hash('sha512', $studyId . $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname']);
        if ($hash != $h) {
            header('Location: study-prepare-failure.php');
        }
    } else {
        header('Location: study-prepare-fallback.php?studyId=' . $studyId . '&h=' . $h);
    }
} else {
    header('Location: study-prepare-failure.php');
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GestureNote</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>

        <script src="https://simplewebrtc.com/latest-v2.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script type="text/JavaScript" src="js/login.js"></script>
        <script type="text/JavaScript" src="js/register.js"></script>
        <script type="text/JavaScript" src="js/checkForms.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/sha512.js"></script>
        <!--<script src="http://cdn.peerjs.com/0.3/peer.min.js"></script>-->


        <!-- webrtc sources -->
        <script src="https://cdn.webrtc-experiment.com/gumadapter.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-subpages"></div>

        <!-- Container (Breadcrump) --> 
        <div class="container" id="breadcrumb">

        </div>

        <!-- Container (Landing Section) --> 
        <!--        <div class="container-fluid text-center bg-grey" id="landingText">
                    <div class="container">
                        <h1><i class="fa fa-tasks" style="font-size: 60pt" aria-hidden="true"></i> <span class="uppercase">An Studie teilnehmen</span></h1>
                        <p class="text">Haben Sie ein Account bei GestureNote? Dann loggen Sie sich bitte ein. </p>
                        <p class="text">Sind Sie auf dieser Seite gelandet, weil Sie einen Link für die Teilnahme an einer Studie erhalten haben? Sie können ohne Account fortfahren indem Sie auf "Teilnahme ohne Account" klicken. Oder Sie registrieren sich bei GestureNote und können in Zukunft an weiteren interessanten Studien teilnehmen, ganz ohne Einladung.</p>
                    </div>
                </div>-->

        <!-- Container (Panel Section) -->
        <div class="container mainContent" style="margin-top: 85px;">

            <div class="row hidden" id="study-details">
                <div class="col-xs-12">
                    <h2 id="study-headline" style="margin-top: 0"></h2>
                    <hr>
                    <div class="label label-default" id="type-phase"></div>
                    <div class="label label-default" id="type-survey"></div>

                    <div id="study-description">
                        <h3 class="address"></h3>
                        <p class="text"></p>
                    </div>

                    <div class="alert-space alert-study-unmoderated"></div>

                </div>
            </div>

            <div class="row hidden" id="technical-check" style="margin-top: 40px">
                <div class="col-xs-12">
                    <h2 id="check-headline" style="margin-top: 0">Überprüfung der Webcam</h2>
                    <hr>

                </div>

                <div class="col-sm-6">
                    <div class="alert-space alert-web-rtc-not-supported"></div>
                    <video autoplay id="rtc-video" class="rtc-stream hidden" style="width: 100%; height: auto; overflow: hidden; border-radius: 4px;"></video>
                </div>
                <div class="col-sm-6 text">
                    <p><strong>Diese Studie benötigt Zugriff auf Ihre Webcam.</strong> Falls Ihr Browser die Technologie unterstützt, erhalten Sie einen Hinweis, dass diese Seite auf Ihre Kamera und Ihr Mikrofon zugreifen möchte. Akzeptieren Sie bitte den Zugriff auf Kamera und Mikrofon, wenn Sie an dieser Studie teilnehmen möchten. </p>
                    <p>Danach prüfen Sie bitte, ob der Kamerastream funktioniert und Sie sich links sehen können. Beantworten Sie bitte die Frage. </p>

                    <div id="web-rtc-working">
                        <p>Können Sie sich sehen? </p>
                        <div class="btn-group">
                            <button class="btn btn-danger btn-shadow" id="btn-no"><?php echo $lang->no ?></button>
                            <button class="btn btn-success btn-shadow" id="btn-yes"><?php echo $lang->yes ?></button>
                        </div>
                    </div>

                    <div id="web-rtc-not-working" class="hidden">
                        <p>Sehen Sie eine Meldung mit dem Hinweis einen anderen Browser zu nutzen? </p>
                        <div class="btn-group">
                            <button class="btn btn-danger btn-shadow" id="btn-no"><?php echo $lang->no ?></button>
                            <button class="btn btn-success btn-shadow" id="btn-yes"><?php echo $lang->yes ?></button>
                        </div>
                    </div>

                    <div class="alert-space alert-another-browser-needed-for-web-rtc"></div>
                    <div class="alert-space alert-contact-support"></div>
                </div>
            </div>

            <div class="row hidden" id="participation-queue" style="margin-top: 20px">
                <div class="col-xs-12">
                    <h2 style="margin-top: 0">Wartende Probanden</h2>
                    <hr>
                    <div class="alert-space alert-no-participation-requests"></div>
                    <div id="list-container" class="row"></div>
                </div>
            </div>


            <div id="call-screen" class="row hidden">
                <div class="col-xs-12">
                    <div class="alert-space alert-waiting-for-moderator"></div>
                </div>
                <div class="col-xs-12 text-center">
                    <button class="btn btn-danger btn-shadow btn-block" id="btn-close-call"><?php echo $lang->close ?></button>
                </div>

                <div class="col-xs-12 col-md-6 col-md-offset-3" id="video-caller" style="margin-top: 10px">
                    <div id="remote-stream" class="rtc-remote-container rtc-stream" style="border-radius: 4px;"></div>
                    <div class="rtc-local-container">
                        <video autoplay id="local-stream" class="rtc-stream" style=""></video>
                    </div>
                </div>

                <div style="clear: both;"></div>



                <!--                <video autoplay id="local-stream" class="rtc-stream" style="width: 450px; height: auto; overflow: hidden; border-radius: 4px;"></video>
                                <div id="remote-stream" class="rtc-remote-container rtc-stream" style="border-radius: 4px;"></div>-->
            </div>

        </div>

        <div class="root col-xs-12 col-sm-6 col-lg-4 hidden" id="queue-thumbnail">
            <div class="panel panel-default btn-shadow">
                <!--<div class="panel-heading"></div>-->

                <div class="panel-body">
                    <span class="label label-default" id="user"><i class="fa fa-user"></i> <span class="label-text"></span></span>
                    <span id="waiting" style="margin-left: 6px"><span class="address">wartet:</span> <span class="text"></span></span>
                    <!--<span class="label label-success hidden" id="execution-success"><i class="fa fa-check"></i> <span class="label-text hidden-xs hidden-sm"></span></span>-->
                    <!--<span class="label label-danger hidden" id="execution-fault"><i class="fa fa-bolt"></i> <span class="label-text hidden-xs hidden-sm"></span></span>-->
                </div>
            </div>
        </div>


        <script>
            $(document).ready(function () {
                checkDomain();
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    loadExternals(externals);
                });
            });
            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements(false);
                var query = getQueryParams(document.location.search);
                if (query.studyId && query.h && query.token) {
                    getStudyById({studyId: query.studyId}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            //                            if (result.data) {
                            setStudyData(result);
                            renderData(result);
                            //                            } else {
                            //                                //                            appendAlert($('#item-view'), ALERT_NO_STUDIES);
                            //                            }
                        }
                    });
                }
            }

            var requestInterval = null;
            function renderData(data) {
                var studyData = data.studyData;
                $('#study-headline').text(studyData.generalData.title);
                $('#type-survey').text(translation.surveyType[studyData.generalData.surveyType]);
                $('#type-phase').text(translation.phaseType[studyData.generalData.phase]);
                $('#study-description .address').text(translation.description);
                $('#study-description .text').text(studyData.generalData.description);

                if (studyData.generalData.surveyType === TYPE_SURVEY_MODERATED) {
                    // check rtc is needed
                    //                    if (isWebRTCNeeded(studyData.phases)) {
                    //                        $('#technical-check').removeClass('hidden');
                    //                        renderRTCCheck();
                    //                    } else {
                    //                        $('#technical-check').remove();
                    //                        $('#participation-queue, #study-details').removeClass('hidden');
                    //                    }
                    //
                    //                    // check supported rtc
                    //                    if (isWebRTCSupported() === false) {
                    //                        $('#web-rtc-working').addClass('hidden');
                    //                        $('#web-rtc-not-working').removeClass('hidden');
                    //                    }
                    //
                    //                    // questionnaire about rtc
                    //
                    //                    $('#web-rtc-working #btn-yes').on('click', function (event) {
                    //                        event.preventDefault();
                    //                        $('#web-rtc-working, #technical-check').addClass('hidden');
                    //                        $('#participation-queue, #study-details').removeClass('hidden');
                    //                        appendAlert($('#participation-queue'), ALERT_NO_PARTICIPATION_REQUESTS);
                    //                        getParticipantRequests();
                    ////                        resetRTC();
                    //                    });
                    //                    $('#web-rtc-working #btn-no').on('click', function (event) {
                    //                        event.preventDefault();
                    //                        $('#web-rtc-working').addClass('hidden');
                    //                        $('#web-rtc-not-working').removeClass('hidden');
                    //                    });
                    //                    $('#web-rtc-not-working #btn-yes').on('click', function (event) {
                    //                        event.preventDefault();
                    //                        $('#web-rtc-not-working').addClass('hidden');
                    //                        appendAlert($('#technical-check'), ALERT_ANOTHER_BROWSER_NEEDED_FOR_WEB_RTC);
                    //                    });
                    //                    $('#web-rtc-not-working #btn-no').on('click', function (event) {
                    //                        event.preventDefault();
                    //                        $('#web-rtc-not-working').addClass('hidden');
                    //                        clearAlerts($('#technical-check'));
                    //                        appendAlert($('#technical-check'), ALERT_CONTACT_SUPPORT);
                    //                    });
                    initializeRTC($('#local-stream'), true, false);
                    appendAlert($('#participation-queue'), ALERT_NO_PARTICIPATION_REQUESTS);
                    $('#participation-queue, #study-details').removeClass('hidden');
                    getParticipantRequests();
                } else {
                    $('#study-details').removeClass('hidden');
                    appendAlert($('#study-details'), ALERT_STUDY_UNMODERATED);
                    $('#study-details').find('#btn-open-study-details').on('click', function (event) {
                        event.preventDefault();
                        var query = getQueryParams(document.location.search);
                        var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                        goto("study.php?studyId=" + query.studyId + "&h=" + hash);
                    });
                }
            }

            function getParticipantRequests() {
                var studyData = getLocalItem(STUDY);
                requestInterval = setInterval(function () {
                    getParticipationRequests({studyId: studyData.id}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            renderQueue(result.requests);
                        }
                    });
                }, 4000);
            }

            function renderQueue(requests) {
                $('#participation-queue').find('#list-container').empty();
                if (requests && requests.length > 0) {
                    clearAlerts($('#participation-queue'));
                    for (var i = 0; i < requests.length; i++) {
                        var request = requests[i];
                        var item = $('#queue-thumbnail').clone().removeAttr('id').removeClass('hidden');
                        $('#participation-queue').find('#list-container').append(item);
                        var created = convertSQLTimestampToDate(request.created);
                        var current = convertSQLTimestampToDate(request.current);
                        var waitingTime = getTimeBetweenTimestamps(created.getTime(), current.getTime());
                        $(item).find('#waiting .text').text(getTimeString(waitingTime, true));
                        if (isNaN(request.testerId)) {
                            $(item).find('#user .label-text').text(translation.userTypes.guest);
                        } else {
                            $(item).find('#user .label-text').text(translation.userTypes.registered);
                        }

                        $(item).find('.panel').on('click', {requestId: request.id}, function (event) {
                            clearInterval(requestInterval);
                            resetRTC();
                            //                            initializeRTC($('#local-stream'), true, false);
                            //                            console.log(request.id);
                            approveParticipation({requestId: event.data.requestId}, function (result) {
                                console.log(result);
                                if (result.status === RESULT_SUCCESS) {
                                    $('#participation-queue').addClass('hidden');
                                    $('#call-screen').removeClass('hidden');
                                    $('#call-screen').attr('name', event.data.requestId);
                                    initializeRTCPeerConnection(result.data.rtcToken);
                                }
                            });
                        });
                        //                        if (!isNaN(parseInt(request.moderatorId))) {
                        //                            $(item).find('.panel').click();
                        //                        }
                    }
                } else {
                    appendAlert($('#participation-queue'), ALERT_NO_PARTICIPATION_REQUESTS);
                }
            }

            $('#btn-close-call').on('click', function (event) {
                event.preventDefault();
                var requestId = $('#call-screen').attr('name');
                reapproveParticipation({requestId: requestId}, function (result) {
                    // reset rtcPerConnection
                    resetRTC();
                    webrtc.leaveRoom();
                    $('#participation-queue').removeClass('hidden');
                    $('#call-screen').addClass('hidden');
                    getParticipantRequests();
                });
            });

            function renderRTCCheck() {
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    initializeRTC($('#rtc-video'), true, false);
                } else {
                    appendAlert($('#technical-check'), ALERT_WEB_RTC_NOT_SUPPORTED);
                    console.log('Native device media streaming (getUserMedia) not supported in this browser.');
                }
            }

            function resetRTC() {
                $('#rtc-video').addClass('hidden');
                if (liveStream) {
                    //                    liveStream.getAudioTracks()[0].stop();
                    liveStream.getVideoTracks()[0].stop();
                }
            }

            var localStreamTarget = null;
            function initializeRTC(localTarget, video, audio) {
                //                clearAlerts($('#technical-check'));
                localStreamTarget = localTarget;
                if (!liveStream) {
                    var mediaConstraints = {video: video, audio: audio};
                    navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
                } else {
                    successCallback(liveStream);
                }
            }

            function errorCallback(error) {
                alert(error);
                // maybe another application is using the device
            }

            var liveStream;
            function successCallback(stream) {
                liveStream = stream;
                $(localStreamTarget).removeClass('hidden').attr('src', URL.createObjectURL(stream));
            }

            var freeIceServers = [
                {url: 'stun.l.google.com:19302'},
                {url: 'stun1.l.google.com:19302'},
                {url: 'stun2.l.google.com:19302'},
                {url: 'stun3.l.google.com:19302'},
                {url: 'stun4.l.google.com:19302'},
                {url: 'stun.ekiga.net'},
                {url: 'stun.ideasip.com'},
                {url: 'stun.rixtelecom.se'},
                {url: 'stun.schlund.de'},
                {url: 'stun.stunprotocol.org:3478'},
                {url: 'stun.voiparound.com'},
                {url: 'stun.voipbuster.com'},
                {url: 'stun.voipstunt.com'},
                {url: 'stun.voxgratia.org'}
            ];

            var webrtc = null;
            function initializeRTCPeerConnection(rtcToken) {
                console.log('initializeRTCPeerConnection', rtcToken);
                if (webrtc !== null) {
                    webrtc.joinRoom(rtcToken);
                } else {
                    webrtc = new SimpleWebRTC({
                        // the id/element dom element that will hold "our" video
                        localVideoEl: 'local-stream',
                        // the id/element dom element that will hold remote videos
                        remoteVideosEl: 'remote-stream',
                        // immediately ask for camera access
                        autoRequestMedia: true,
                        localVideo: {
                            autoplay: true, // automatically play the video stream on the page
                            mirror: true, // flip the local video to mirror mode (for UX)
                            muted: true // mute local video stream to prevent echo
                        }
                    });
                }

                // we have to wait until it's ready
                webrtc.on('readyToCall', function () {
                    // you can name it anything
                    console.log('ready to call', rtcToken);
                    webrtc.joinRoom(rtcToken);
                });

                var timeline = new TimelineMax({paused: true});
                timeline.add(TweenMax.to($('#local-stream'), .3, {width: 200, height: 150, left: 5, top: 5, ease: Quad.easeIn}));
                timeline.add(TweenMax.to($('#remote-stream'), .3, {opacity: 1.0}));

                // a peer video has been added
                webrtc.on('videoAdded', function (video, peer) {
                    console.log('video added', peer);
                    timeline.play();
                });

                // a peer video has been added
                webrtc.on('videoRemoved', function (video, peer) {
                    console.log('video removed', peer);
                    timeline.reverse();
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
        </script>
    </body>
</html>
