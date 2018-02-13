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
        $_SESSION['usertype'] = 'guest';
        if (!isset($_SESSION['user_id'])) {
            $time = time();
            $_SESSION['user_id'] = hash('sha512', $time . $_SESSION['usertype']);
        }

        if (studyExecutionExists($studyId, $mysqli)) {
            header('Location: study-execution-exists.php');
        }

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
        <script src="js/alert.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script type="text/JavaScript" src="js/storage.js"></script>
        <script type="text/JavaScript" src="js/storageFunctions.js"></script>
        <script type="text/JavaScript" src="js/login.js"></script>
        <script type="text/JavaScript" src="js/checkForms.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/sha512.js"></script>
        <script src="js/chance.min.js"></script>

        <!-- streaming -->
                <!--<script src="https://simplewebrtc.com/latest-v2.js"></script>-->
        <script src="js/andyet/simplewebrtcbundle.js"></script>
        <script src="js/peerConnection.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-subpages"></div>


        <!-- Container (Panel Section) -->
        <div class="container mainContent" style="margin-top: 15px;">

            <div class="row hidden" id="study-details">
                <div class="col-xs-12">
                    <h2 id="study-headline" style="margin-top: 0"></h2>
                    <hr style="">

                    <div class="row">
                        <div class="col-sm-7">
                            <div id="study-description">
                                <p class="text"></p>
                            </div>

                            <div class="hidden study-plan"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>
                            <button class="btn btn-block btn-info btn-shadow" id="btn-enter-study"><?php echo $lang->enterStudyAsTester ?></button>
                        </div>
                        <div class="col-sm-5 hidden" id="study-participation">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="alert-hints">
                                        <div class="alert-space alert-study-over-range"></div>
                                        <div class="alert-space alert-study-under-range"></div>
                                        <div class="alert-space alert-waiting-for-moderator"></div>
                                        <div class="alert-space alert-web-rtc-not-supported"></div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="hidden" id="video-caller">
                                        <div id="remote-stream" class="rtc-remote-container rtc-stream" style="border-radius: 4px;"></div>
                                        <div class="rtc-local-container">
                                            <video autoplay id="local-stream" class="rtc-stream" style="display:block"></video>
                                        </div>
                                        <div class="btn-group" id="stream-controls" style="position: absolute; bottom: 6px; display: inline; left: 50%; transform: translate(-50%, 0); opacity: 0">
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

                </div>
            </div>

            <div class="row hidden" id="technical-check" style="margin-top: 40px">
                <div class="col-xs-12">
                    <h2 id="check-headline" style="margin-top: 0"><?php echo $lang->checkWebcam ?></h2>
                    <hr>
                </div>

                <div class="col-sm-6">
                    <div class="alert-space alert-web-rtc-not-supported"></div>
                    <video autoplay id="rtc-video" class="rtc-stream hidden" style="width: 100%; height: auto; overflow: hidden; border-radius: 4px;"></video>
                </div>
                <div class="col-sm-6 text">
                    <p><?php echo $lang->checkWebcamText1 ?></p>
                    <p><?php echo $lang->checkWebcamText2 ?></p>

                    <div id="web-rtc-working">
                        <p><?php echo $lang->seeYourselfQuestion ?></p>
                        <div class="btn-group">
                            <button class="btn btn-danger btn-shadow" id="btn-no"><?php echo $lang->no ?></button>
                            <button class="btn btn-success btn-shadow" id="btn-yes"><?php echo $lang->yes ?></button>
                        </div>
                    </div>

                    <div id="web-rtc-not-working" class="hidden">
                        <p><?php echo $lang->seeBrowserQuestion ?></p>
                        <div class="btn-group">
                            <button class="btn btn-danger btn-shadow" id="btn-no"><?php echo $lang->no ?></button>
                            <button class="btn btn-success btn-shadow" id="btn-yes"><?php echo $lang->yes ?></button>
                        </div>
                    </div>

                    <div class="alert-space alert-another-browser-needed-for-web-rtc"></div>
                    <div class="alert-space alert-contact-support"></div>

                </div>
            </div>

        </div>

    </div>


    <script>
        var syncPhaseStep = false;
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
            initPopover();
            renderSubPageElements(false);

            console.log('tester id: <?php echo $_SESSION['user_id'] ?>');

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
//            console.log(data);
            var studyData = data.studyData;
            $('#study-headline').text(studyData.generalData.title);
//            $('#type-survey').text(translation.surveyType[studyData.generalData.surveyType]);
//            $('#study-description .address').text(translation.description);
            $('#study-description .text').text(studyData.generalData.description);

            // date range view
            var now = new Date().getTime();
            var dateFrom = studyData.generalData.dateFrom * 1000;
            var dateTo = addDays(studyData.generalData.dateTo * 1000, 1);
            var totalDays = rangeDays(dateFrom, dateTo);

//            $('.study-plan').find('.address').text(now > dateTo ? translation.studyRuns : translation.studyRun + " " + translation.from + ":");
//            $('.study-plan').find('.text').text(new Date(dateFrom).toLocaleDateString() + " " + translation.to + " " + new Date(dateTo).toLocaleDateString() + ", " + totalDays + " " + (totalDays === 1 ? translation.day : translation.days));
//            $('.study-plan').removeClass('hidden');

            $('#study-participation, #study-details').removeClass('hidden');

            if (now > dateFrom && now < dateTo) {
                if (data.studyData.generalData.surveyType === TYPE_SURVEY_MODERATED) {
                    $('#btn-enter-study').addClass('hidden');

                    var rtcToken = hex_sha512(new Date().getTime() + " " + chance.natural());
                    var study = getLocalItem(STUDY);

                    requestParticipation({studyId: study.id, rtcToken: rtcToken}, function (result) {
                        if (result.status === RESULT_SUCCESS && result.data) {
                            initVideoCaller(result.data.rtcToken);
                        } else {
                            console.log('an error occured');
                        }
                    });

                    if (getBrowser() !== BROWSER_CHROME) {
                        appendAlert($('#alert-hints'), ALERT_WEB_RTC_NOT_SUPPORTED);
                    } else {
                        appendAlert($('#alert-hints'), ALERT_WAITING_FOR_MODERATOR);
                        requestInterval = setInterval(function () {
                            requestParticipation({studyId: study.id, rtcToken: rtcToken}, function (result) {
                                if (result.status === RESULT_SUCCESS) {
                                    if (!result.data) {
                                        appendAlert($('#alert-hints'), ALERT_WAITING_FOR_MODERATOR);
                                    }
                                }
                            });
                        }, 1000);
                    }
                } else {
                    $('#btn-enter-study').on('click', function (event) {
                        event.preventDefault();
                        var query = getQueryParams(document.location.search);
                        goto('study-execution-tester.php?studyId=' + query.studyId + '&token=' + query.token + '&h=' + query.h);
                    });
                }
            } else {
                if (now > dateFrom) {
                    appendAlert($('#alert-hints'), ALERT_STUDY_OVER_RANGE);
                } else {
                    appendAlert($('#alert-hints'), ALERT_STUDY_UNDER_RANGE);
                }

                if (data.studyData.generalData.surveyType === TYPE_SURVEY_MODERATED) {
                    $('#btn-enter-study').addClass('hidden');
                } else {
                    $('#btn-enter-study').addClass('disabled');
                }
            }
        }

        var peerConnection = null;
        function initVideoCaller(rtcToken) {
            console.log('initializeRTCPeerConnection', rtcToken);
            $('#video-caller').removeClass('hidden');
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

            peerConnection = new PeerConnection(callerOptions);
            peerConnection.initialize(callerOptions);
            peerConnection.showLocalStream();

            // a peer video has been added
            $(peerConnection).on('videoAdded', function () {
                clearAlerts($('#alert-hints'));
            });

            // a peer video has been removed
            $(peerConnection).on('videoRemoved', function () {
                appendAlert($('#alert-hints'), ALERT_WAITING_FOR_MODERATOR);
            });

            $(peerConnection).on(MESSAGE_ENTER_SURVEY, function (event, payload) {
                console.log('enter survey', payload);
                var query = getQueryParams(document.location.search);
                goto('study-execution-tester.php?studyId=' + query.studyId + '&token=' + query.token + '&h=' + query.h + '&roomId=' + payload.rtcToken);
            });
        }
    </script>
</body>
</html>
