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
        if (!isset($_SESSION['user_id']) || (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == 0 || $_SESSION['user_id'] == '0'))) {
            $time = time();
            $_SESSION['user_id'] = hash('sha512', $time . $_SESSION['usertype']);
        }
        $_SESSION['usertype'] = 'guest';
        $hash = hash('sha512', $studyId . $_SESSION['usertype']);
        if ($hash != $h) {
            header('Location: study-prepare-failure.php');
        }
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
        <script src="js/alert.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script type="text/JavaScript" src="js/storage.js"></script>
        <script type="text/JavaScript" src="js/storageFunctions.js"></script>
        <script type="text/JavaScript" src="js/login.js"></script>
        <script type="text/JavaScript" src="js/register.js"></script>
        <script type="text/JavaScript" src="js/checkForms.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/sha512.js"></script>
        <script src="js/chance.min.js"></script>

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
                    <!--<div class="label label-default" id="type-phase"></div>-->
                    <div class="label label-default" id="type-survey"></div>

                    <div id="study-description">
                        <h3 class="address"></h3>
                        <p class="text"></p>
                    </div>

                    <div class="hidden study-plan"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>

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


            <div class="row hidden" id="study-participation" style="margin-top: 20px">
                <div class="col-xs-12">
                    <div class="alert-space alert-waiting-for-moderator"></div>
                    <button class="btn btn-block btn-info btn-shadow" id="btn-enter-study"><?php echo $lang->enterStudyAsTester ?></button>
                </div>
                <div class="col-xs-12 col-md-6 col-md-offset-3" id="video-caller">
                    <div id="remote-stream" class="rtc-remote-container rtc-stream" style="border-radius: 4px;"></div>
                    <div class="rtc-local-container">
                        <video autoplay id="local-stream" class="rtc-stream" style=""></video>
                    </div>
                </div>
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
            console.log(data);
            var studyData = data.studyData;
            $('#study-headline').text(studyData.generalData.title);
            $('#type-survey').text(translation.surveyType[studyData.generalData.surveyType]);
//                $('#type-phase').text(translation.phaseType[studyData.generalData.phase]);
            $('#study-description .address').text(translation.description);
            $('#study-description .text').text(studyData.generalData.description);

            // date range view
            var now = new Date().getTime();
            var dateFrom = studyData.generalData.dateFrom * 1000;
            var dateTo = addDays(studyData.generalData.dateTo * 1000, 1);
            var totalDays = rangeDays(dateFrom, dateTo);

            if (now > dateFrom && now < dateTo) {
                if (data.studyData.generalData.surveyType === TYPE_SURVEY_MODERATED) {
                    $('#btn-enter-study').addClass('hidden');

                    // show waiting screen
                    $('#study-participation, #study-details').removeClass('hidden');
//                        if (data.studyData.generalData.surveyType === TYPE_SURVEY_MODERATED) {
                    appendAlert($('#study-participation'), ALERT_WAITING_FOR_MODERATOR);

//                            resetRTC();
//                        initializeRTC($('#local-stream'), true, false);
                    // initialize rtcPerConnection

                    var rtcToken = hex_sha512(new Date().getTime() + " " + chance.natural());
                    var study = getLocalItem(STUDY);

                    requestParticipation({studyId: study.id, rtcToken: rtcToken}, function (result) {
                        if (result.status === RESULT_SUCCESS && result.data) {
                            initializeRTCPeerConnection(result.data.rtcToken);
                        } else {
                            console.log('an error occured');
                        }
                    });

                    requestInterval = setInterval(function () {
                        requestParticipation({studyId: study.id, rtcToken: rtcToken}, function (result) {
                            if (result.status === RESULT_SUCCESS) {
                                if (result.data) {
//                                        clearInterval(requestInterval);
//                                        console.log(result.data.moderatorId);
                                    // initialize rtcPerConnection
                                    if (webRTCInitialized === false) {
                                        initializeRTCPeerConnection(result.data.rtcToken);
                                    }

                                    if (!isNaN(parseInt(result.data.moderatorId))) {
                                        clearAlerts($('#study-participation'));
                                    }
                                } else {
                                    // reset rtcPerConnection
                                    appendAlert($('#study-participation'), ALERT_WAITING_FOR_MODERATOR);
                                }
                            }
                        });
                    }, 5000);

                } else {
                    $('#btn-enter-study').on('click', function (event) {
                        event.preventDefault();
                        var query = getQueryParams(document.location.search);
                        goto('study-execution-tester.php?studyId=' + query.studyId + '&token=' + query.token + '&h=' + query.h);
                    });
                }
            } else {
                if (data.studyData.generalData.surveyType === TYPE_SURVEY_MODERATED) {
                    $('#btn-enter-study').addClass('hidden');
                } else {
                    $('#btn-enter-study').addClass('disabled');
                }
            }

            $('.study-plan').find('.address').text(now > dateTo ? translation.studyRuns : translation.studyRun + " " + translation.from + ":");
            $('.study-plan').find('.text').text(new Date(dateFrom).toLocaleDateString() + " " + translation.to + " " + new Date(dateTo).toLocaleDateString() + ", " + totalDays + " " + (totalDays === 1 ? translation.day : translation.days));
            $('.study-plan').removeClass('hidden');

            // check rtc is needed
//                if (isWebRTCNeeded(studyData.phases)) {
//                    $('#technical-check').removeClass('hidden');
//                    renderRTCCheck();
//                } else {
//                    $('#technical-check').remove();
//                    $('#study-participation, #study-details').removeClass('hidden');
//                }
//
//                // check supported rtc
//                if (isWebRTCSupported() === false) {
//                    $('#web-rtc-working').addClass('hidden');
//                    $('#web-rtc-not-working').removeClass('hidden');
//                }

            // check supported local storage
            if (typeof (Storage) !== "undefined") {
                console.log("Yes, your browser supports Web Session Storage.");
            } else {
                console.log("Sorry, your browser do not support Web Session Storage.");
            }

            // questionnaire about rtc
//                $('#web-rtc-working #btn-yes').on('click', function (event) {
//                    event.preventDefault();
//                    $('#web-rtc-working, #technical-check').addClass('hidden');
//                    $('#study-participation, #study-details').removeClass('hidden');
//
//                    if (data.studyData.generalData.surveyType === TYPE_SURVEY_MODERATED) {
//                        appendAlert($('#study-participation'), ALERT_WAITING_FOR_MODERATOR);
//
//                        resetRTC();
////                        initializeRTC($('#local-stream'), true, false);
//
//                        var rtcToken = hex_sha512(new Date().getTime() + " " + chance.natural());
//                        requestInterval = setInterval(function () {
//                            var study = getLocalItem(STUDY);
//                            requestParticipation({studyId: study.id, rtcToken: rtcToken}, function (result) {
//                                if (result.status === RESULT_SUCCESS) {
//                                    if (result.data && !isNaN(parseInt(result.data.moderatorId))) {
//                                        clearInterval(requestInterval);
////                                        console.log(result.data.moderatorId);
//                                        // initialize rtcPerConnection
//                                        initializeRTCPeerConnection(result.data.rtcToken);
//                                        clearAlerts($('#study-participation'));
//                                    } else {
//                                        // reset rtcPerConnection
//                                        appendAlert($('#study-participation'), ALERT_WAITING_FOR_MODERATOR);
//                                    }
//                                }
//                            });
//                        }, 5000);
//                    }
//                });

//                $('#web-rtc-working #btn-no').on('click', function (event) {
//                    event.preventDefault();
//                    $('#web-rtc-working').addClass('hidden');
//                    $('#web-rtc-not-working').removeClass('hidden');
//                });
//
//                $('#web-rtc-not-working #btn-yes').on('click', function (event) {
//                    event.preventDefault();
//                    $('#web-rtc-not-working').addClass('hidden');
//                    appendAlert($('#technical-check'), ALERT_ANOTHER_BROWSER_NEEDED_FOR_WEB_RTC);
//                });
//
//                $('#web-rtc-not-working #btn-no').on('click', function (event) {
//                    event.preventDefault();
//                    $('#web-rtc-not-working').addClass('hidden');
//                    clearAlerts($('#technical-check'));
//                    appendAlert($('#technical-check'), ALERT_CONTACT_SUPPORT);
//                });
        }

        function renderRTCCheck() {
            if (isWebRTCSupported()) {
                initializeRTC($('#rtc-video'), true, false);
            } else {
                appendAlert($('#technical-check'), ALERT_WEB_RTC_NOT_SUPPORTED);
                console.log('Native device media streaming (getUserMedia) not supported in this browser.');
            }
        }

        function resetRTC() {
//                $(localStreamTarget).addClass('hidden');
            if (liveStream) {
//                    liveStream.getAudioTracks()[0].stop();
                liveStream.getVideoTracks()[0].stop();
            }
        }

        var localStreamTarget = null;
        function initializeRTC(localTarget, video, audio) {
            localStreamTarget = localTarget;
            clearAlerts($('#technical-check'));
            var mediaConstraints = {video: video, audio: audio};
            if (!liveStream) {
                navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
            } else {
                successCallback(liveStream);
            }
        }

        function errorCallback(error) {
            alert(error);
            // maybe another application is using the device
        }

        var liveStream = null;
        function successCallback(stream) {
            liveStream = stream;
            $(localStreamTarget).removeClass('hidden').attr('src', URL.createObjectURL(stream));
        }

//            function initializeCall() {
//                $(localStreamTarget).attr('src', URL.createObjectURL(liveStream));
//            }

        var freeIceServers = [
            {urls: ['stun.l.google.com:19302',
                    'stun1.l.google.com:19302',
                    'stun2.l.google.com:19302',
                    'stun3.l.google.com:19302',
                    'stun4.l.google.com:19302',
                    'stun.ekiga.net',
                    'stun.ideasip.com',
                    'stun.rixtelecom.se',
                    'stun.schlund.de',
                    'stun.stunprotocol.org:3478',
                    'stun.voiparound.com',
                    'stun.voipbuster.com',
                    'stun.voipstunt.com',
                    'stun.voxgratia.org']}
        ];

        var webrtc = null;
        var webRTCInitialized = false;
        function initializeRTCPeerConnection(rtcToken) {
            console.log('initializeRTCPeerConnection', rtcToken);
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

            // we have to wait until it's ready
            webrtc.on('readyToCall', function () {
                // you can name it anything
                webRTCInitialized = true;
                console.log('ready to call', rtcToken);
                webrtc.joinRoom(rtcToken);

                
            });

            var timeline = new TimelineMax({paused: true});
                timeline.add(TweenMax.to($('#local-stream'), .3, {width: 200, height: 150, left: 5, top: 5, ease: Quad.easeIn}));
                timeline.add(TweenMax.to($('#remote-stream'), .3, {opacity: 1.0}));

            // a peer video has been added
            webrtc.on('videoAdded', function (video, peer) {
                console.log('video added', peer);
                clearAlerts($('#study-participation'));
                timeline.play();
            });

            // a peer video has been added
            webrtc.on('videoRemoved', function (video, peer) {
                console.log('video removed', peer);
                appendAlert($('#study-participation'), ALERT_WAITING_FOR_MODERATOR);
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
