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
        <title><?php echo $lang->gestureNote ?></title>
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

        <script src="js/constants.js"></script>
        <script src="js/refreshSession.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script type="text/JavaScript" src="js/login.js"></script>
        <script type="text/JavaScript" src="js/checkForms.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/sha512.js"></script>

        <!-- streaming -->
        <script src="js/andyet/simplewebrtcbundle.js"></script>
        <script src="js/peerConnection.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-subpages"></div>

        <!-- Container (Breadcrump) --> 
        <div class="container" id="breadcrumb" style="padding-top: 40px">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-studies"><i class="fa fa-tasks" aria-hidden="true"></i> <?php echo $lang->breadcrump->studies ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-study"><?php echo $lang->breadcrump->study ?></a></li>
                    <li class="active"><?php echo $lang->breadcrump->studyPrepare ?></li>
                </ol>
            </div>
        </div>

        <!-- Container (Panel Section) -->
        <div class="container mainContent" >

            <div class="row">
                <div class="col-xs-12">
                    <h2 id="study-headline" style="margin-top: 0; margin-bottom: 0px"></h2>
                    <!--<hr>-->
                    <div class="label label-default" id="type-phase"></div>
                    <div class="label label-default" id="type-survey"></div>
                </div>
            </div>

            <div class="row hidden" id="study-details">
                <div class="col-sm-7" style="margin-bottom: 20px">
                    <div id="study-description">
                        <h3 class="address"></h3>
                        <p class="text"></p>
                    </div>

                    <div class="hidden study-plan"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>
                </div>

                <div class="col-sm-5">

                    <div id="alert-hints" class="hidden">
                        <div class="alert-space alert-study-unmoderated"></div>
                        <div class="alert-space alert-web-rtc-not-supported"></div>
                        <div class="alert-space alert-another-browser-needed-for-web-rtc"></div>
                        <div class="alert-space alert-contact-support"></div>
                    </div>

                    <div id="participation-queue" class="hidden">
                        <h3>Wartende Probanden</h3>

                        <div class="alert-space alert-search-participation-requests"></div>
                        <div id="list-container" class="row"></div>
                    </div>

                    <div id="call-screen" class="row hidden">
                        <div class="col-xs-12 text-center">
                            <div class="btn-group">
                                <button class="btn btn-danger btn-shadow" id="btn-close-call"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
                                <button class="btn btn-success btn-shadow disabled" id="btn-enter-study"><i class="fa fa-chevron-right"></i> <?php echo $lang->enterStudyAsModerator ?></button>
                            </div>
                        </div>

                        <div class="col-xs-12" id="video-caller" style="margin-top: 10px;">
                            <i class="fa fa-circle-o-notch fa-spin" style="position: absolute; left:50%; top: 50% "></i>
                            <div id="remote-stream" class="rtc-remote-container rtc-stream" style="border-radius: 4px;"></div>
                            <div class="rtc-local-container">
                                <video autoplay id="local-stream" class="rtc-stream" style="display:block"></video>
                            </div>
                            <div class="btn-group" id="stream-controls" style="position: absolute; bottom: 6px; display: block; left: 50%; transform: translate(-50%, 0); opacity: 0">
                                <button type="button" class="btn stream-control" id="btn-stream-local-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->muteMicrofone ?>"><i class="fa fa-microphone-slash"></i> </button>
                                <button type="button" class="btn stream-control" id="btn-pause-stream" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOwnWebRTC ?>"><i class="fa fa-pause"></i> </button>
                                <button type="button" class="btn stream-control" id="btn-stream-remote-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOtherWebRTC ?>"><i class="fa fa-volume-up"></i> </button>
                            </div>
                            <div id="stream-control-indicator">
                                <div style="position: absolute; top: 4px; display: block; left: 25px; opacity: 1; color: white">
                                    <i id="mute-local-audio" class="hidden fa fa-microphone-slash" style="margin-right: 3px"></i>
                                    <i id="pause-local-stream" class="hidden fa fa-pause"></i>
                                </div>
                                <div style="position: absolute; top: 4px; display: block; right: 25px; opacity: 1; color: white">
                                    <i id="mute-remote-audio" class="hidden fa fa-microphone-slash"></i>
                                    <i id="pause-remote-stream" class="hidden fa fa-pause" style="margin-left: 3px"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="root col-xs-12 col-lg-6 hidden" id="queue-thumbnail">
            <div class="panel panel-default panel-sm btn-shadow">
                <div class="panel-body">
                    <span class="label label-default" id="user"><i class="fa fa-user"></i> <span class="label-text"></span></span>
                    <span id="waiting" style="margin-left: 6px; font-size: 9pt"><span class="address"><?php echo $lang->waiting ?>:</span> <span class="text"></span></span>
                </div>
            </div>
        </div>


        <script>
            var syncPhaseStep = false;
            $(document).ready(function () {
                checkDomain();
                keepSessionAlive();

                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    loadExternals(externals);
                });
            });
            function onAllExternalsLoadedSuccessfully() {
                initPopover();
                renderSubPageElements(false);

                var query = getQueryParams(document.location.search);
                if (query.studyId && query.h && query.token) {
                    getStudyById({studyId: query.studyId}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            setStudyData(result);
                            renderData(result);
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

                // date range view
                var now = new Date().getTime();
                var dateFrom = studyData.generalData.dateFrom * 1000;
                var dateTo = addDays(studyData.generalData.dateTo * 1000, 1);
                var totalDays = rangeDays(dateFrom, dateTo);

                $('.study-plan').find('.address').text(now > dateTo ? translation.studyRuns : translation.studyRun + " " + translation.from + ":");
                $('.study-plan').find('.text').text(new Date(dateFrom).toLocaleDateString() + " " + translation.to + " " + new Date(dateTo).toLocaleDateString() + ", " + totalDays + " " + (totalDays === 1 ? translation.day : translation.days));
                $('.study-plan').removeClass('hidden');

                if (studyData.generalData.surveyType === TYPE_SURVEY_MODERATED) {

                    $('#study-details').removeClass('hidden');

                    // check rtc is needed
                    if (isWebRTCSupported()) {
                        $('#participation-queue').removeClass('hidden');
                        appendAlert($('#participation-queue'), ALERT_SEARCH_PARTICIPATION_REQUESTS);

                        getParticipationRequests({studyId: studyData.generalData.id}, function (result) {
                            if (result.status === RESULT_SUCCESS) {
                                currentRequests = result.requests;
                                requestParticipations();
                            }
                        });

                        $('#btn-enter-study').on('click', function (event) {
                            event.preventDefault();
                            if (!$(this).hasClass('disabled')) {
                                var name = $('#call-screen').attr('name').split('_');
                                var rtcToken = name[1];
                                var testerId = name[2];
//                                console.log(rtcToken);
                                peerConnection.sendMessage(MESSAGE_ENTER_SURVEY, {rtcToken: rtcToken});
                                var query = getQueryParams(document.location.search);
                                goto('study-execution-evaluator.php?studyId=' + query.studyId + '&token=' + query.token + '&h=' + query.h + '&roomId=' + rtcToken + '&testerId=' + testerId);

                            }
                        });
                    } else {
                        console.log('no webRTC supported in this browser');
                        appendAlert($('#study-details'), ALERT_WEB_RTC_NOT_SUPPORTED);
                    }
                } else {
                    $('#study-details').removeClass('hidden');
                    appendAlert($('#study-details'), ALERT_STUDY_UNMODERATED);
                    $('#study-details').find('#btn-open-study-details').on('click', function (event) {
                        event.preventDefault();
                        returnToStudyDetails();
                    });
                }
            }

            var currentRequests = null;
            function checkRequests(newRequests) {
                if (newRequests && newRequests.length > 0) {
                    var requests = new Array();
                    if (!currentRequests || (currentRequests && currentRequests.length === 0)) {
                        requests = currentRequests = newRequests;
                    } else {
                        for (var i = 0; i < newRequests.length; i++) {
                            var newRequest = newRequests[i];
                            var newRequestCurrentTime = convertSQLTimestampToDate(newRequest.current);
                            for (var j = 0; j < currentRequests.length; j++) {
                                var currentRequest = currentRequests[j];
                                var currentRequestTime = convertSQLTimestampToDate(currentRequest.current);
                                if (parseInt(newRequest.id) === parseInt(currentRequest.id)) {
                                    if (newRequestCurrentTime.getTime() > currentRequestTime.getTime()) {
                                        currentRequest.current = newRequest.current;
                                        requests.push(newRequest);
                                    }
                                    break;
                                } else if (j === currentRequests.length - 1) {
                                    currentRequests.push(newRequest);
                                    requests.push(newRequest);
                                }
                            }
                        }
                    }
                    return requests;
                }

                currentRequests = null;
                return null;
            }

            function requestParticipations() {
                var studyData = getLocalItem(STUDY);
                requestInterval = setInterval(function () {
                    getParticipationRequests({studyId: studyData.id}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            renderQueue(checkRequests(result.requests));
                        }
                    });
                }, 1513);
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
                        console.log(request.testerId);
                        if (isNaN(request.testerId)) {
                            $(item).find('#user .label-text').text(translation.userTypes.guest);
                        } else {
                            $(item).find('#user .label-text').text(translation.userTypes.registered);
                        }

                        $(item).find('.panel').on('click', {requestId: request.id}, function (event) {
                            clearInterval(requestInterval);
                            approveParticipation({requestId: event.data.requestId}, function (result) {
                                console.log(result);
                                if (result.status === RESULT_SUCCESS) {
                                    $('#participation-queue').addClass('hidden');
                                    $('#call-screen').removeClass('hidden');
                                    $('#call-screen').attr('name', event.data.requestId + '_' + result.data.rtcToken + '_' + result.data.testerId);
                                    initPeerConnection(result.data.rtcToken);
                                }
                            });
                        });
                    }
                } else {
                    appendAlert($('#participation-queue'), ALERT_SEARCH_PARTICIPATION_REQUESTS);
                }
            }

            $('#btn-close-call').on('click', function (event) {
                event.preventDefault();
                var requestId = $('#call-screen').attr('name').split('_')[0];
                reapproveParticipation({requestId: requestId}, function (result) {
                    peerConnection.leaveRoom();
                    $('#participation-queue').removeClass('hidden');
                    $('#call-screen').addClass('hidden');
                    $('#btn-enter-study').addClass('disabled');
                    $('#btn-start-screen-sharing').addClass('disabled');
                    requestParticipations();
                });
            });

            $('#btn-study').on('click', function (event) {
                event.preventDefault();
                returnToStudyDetails();
            });

            function returnToStudyDetails() {
                var query = getQueryParams(document.location.search);
                var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                goto("study.php?studyId=" + query.studyId + "&h=" + hash);
            }

            var peerConnection = null;
            function initPeerConnection(rtcToken) {
                console.log('initializeRTCPeerConnection', rtcToken);
                if (peerConnection !== null) {
                    peerConnection.joinRoom(rtcToken);
                } else {
                    var callerOptions = {
                        callerElement: $('#video-caller'),
                        localVideoElement: 'local-stream',
                        remoteVideoElement: 'remote-stream',
                        streamControls: $('#stream-controls'),
                        localMuteElement: $('#btn-stream-local-mute'),
                        pauseStreamElement: $('#btn-pause-stream'),
                        remoteMuteElement: $('#btn-stream-remote-mute'),
                        indicator: $('#stream-control-indicator'),
                        enableWebcamStream: true,
                        enableDataChannels: true,
                        autoRequestMedia: true,
                        roomId: rtcToken,
                        localStream: {audio: 'yes', video: 'yes', visualize: 'yes'},
                        remoteStream: {audio: 'yes', video: 'yes'}
                    };

                    peerConnection = new PeerConnection();
                    peerConnection.initialize(callerOptions);

                    // a peer video has been added
                    $(peerConnection).on('videoAdded', function () {
                        clearAlerts($('#study-participation'));
                        $('#btn-enter-study').removeClass('disabled');
                        $('#btn-start-screen-sharing').removeClass('disabled');
                    });

                    // a peer video has been removed
                    $(peerConnection).on('videoRemoved', function () {
                        clearAlerts($('#study-participation'));
                        $('#btn-enter-study').addClass('disabled');
                        $('#btn-start-screen-sharing').addClass('disabled');
                    });

//                    $('#btn-start-screen-sharing').on('click', function (event) {
//                        event.preventDefault();
//                        if (!$(this).hasClass('active')) {
//                            $(this).addClass('active');
//                            peerConnection.shareScreen(function (error) {
//                                $('#btn-start-screen-sharing').removeClass('active');
//                                console.log(error);
//                            }, function () {
//                                console.log('screen sharing successful started');
//                            });
//                        } else {
//                            $(this).removeClass('active');
//                            peerConnection.stopShareScreen();
//                        }
//                    });
                }
            }
        </script>
    </body>
</html>
