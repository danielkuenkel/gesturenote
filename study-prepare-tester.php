<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

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

        <!-- third party sources -->
        <link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/greensock/TweenMax.min.js"></script>
        
        <!-- gesturenote specific sources -->
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/study-preview.css">
        <link rel="stylesheet" href="css/generalSubPages.css">

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
        <script src="js/andyet/simplewebrtcbundle.js"></script>
        <script src="js/peerConnection.js"></script>

        <!-- leap and plugins -->
        <script src="js/leapjs/leap-0.6.4.min.js"></script>
        <script src="js/leapjs/leap-plugins-0.1.12.min.js"></script>
        <script src="js/three/three.min.js"></script>
        <script src="js/riggedHand/leap.rigged-hand-0.1.7.js"></script>
        <script src="js/leapjs-playback/leap.playback-0.2.1.js"></script>

        <!-- gesture recorder sources -->
        <script src="js/gestureRecorder/gestureRecorder.js"></script>
        <script src="js/gestureRecorder/webcamRecorder.js"></script>
        <script src="js/gestureRecorder/leapRecorder.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-subpages"></div>
        <div id="template-previews"></div>


        <!-- Container (Panel Section) -->
        <div class="container mainContent" style="margin-top: 15px;">

            <div class="row hidden" id="study-details">
                <div class="col-xs-12">
                    <h2 id="study-headline" style="margin-top: 0"></h2>
                    <hr style="">

                    <div class="row">
                        <div class="col-sm-5 col-md-6">
                            <div id="study-description">
                                <p class="text"></p>
                            </div>

                            <div class="hidden study-plan"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>
                            <button class="btn btn-block btn-info btn-shadow" id="btn-enter-study"><?php echo $lang->enterStudyAsTester ?></button>
                        </div>
                        <div class="col-sm-7 col-md-6 hidden" id="study-participation">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="hidden embed-responsive embed-responsive-4by3" id="video-caller">
                                        <div class="embed-responsive-item" style="border-radius: 4px; background-color: #eee;display: flex; justify-content: center; align-items: center;">
                                            <i class="fa fa-circle-o-notch fa-spin fa-3x"></i>
                                        </div>
                                        <div id="remote-stream" class="rtc-remote-container rtc-stream embed-responsive-item" style="border-radius: 4px;"></div>
                                        <div class="rtc-local-container embed-responsive-item">
                                            <video autoplay id="local-stream" class="rtc-stream" style="display:block;"></video>
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
                                <div class="col-xs-12 hidden" id="technical-check" style="margin-top: 10px">
                                    <div id="initialize-recorders-list" class="text-center"></div>
                                </div>
                                <div class="col-xs-12" style="margin-top: 10px">
                                    <div id="alert-hints">
                                        <div class="alert-space alert-study-over-range"></div>
                                        <div class="alert-space alert-study-under-range"></div>
                                        <div class="alert-space alert-waiting-for-moderator"></div>
                                        <div class="alert-space alert-web-rtc-not-supported"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!--            <div class="row hidden" id="technical-check" style="margin-top: 40px">
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
                        </div>-->

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
                externals.push(['#template-previews', PATH_EXTERNALS + 'template-previews.php']);
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
            $('#video-caller').removeClass('hidden');
            var mainElement = $('#video-caller');
            var callerOptions = {
                callerElement: mainElement,
                localVideoElement: 'local-stream',
                remoteVideoElement: 'remote-stream',
                streamControls: $(mainElement).find('#stream-controls'),
                localMuteElement: $(mainElement).find('#btn-stream-local-mute'),
                pauseStreamElement: $(mainElement).find('#btn-pause-stream'),
                remoteMuteElement: $(mainElement).find('#btn-stream-remote-mute'),
                indicator: $(mainElement).find('#stream-control-indicator'),
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
            var sensors = [];

            // a peer video has been added
            var gestureRecorder = null;
            $(peerConnection).on('videoAdded', function () {
                clearAlerts($('#alert-hints'));
                $('#study-participation #initialize-recorders-list').empty();

                // check if sensor has be connected
                var studyData = getLocalItem(STUDY);
                if (studyData.phase === TYPE_PHASE_ELICITATION) {
                    var phaseSteps = getLocalItem(STUDY_PHASE_STEPS);
                    var sensorCount = 0;
                    var options = {
                        startState: GR_STATE_INITIALIZE,
                        usedStates: [GR_STATE_INITIALIZE],
                        record: [],
                        initRecorders: []
                    };

                    for (var i = 0; i < phaseSteps.length; i++) {
                        if (phaseSteps[i].format === IDENTIFICATION) {
                            var stepData = getLocalItem(phaseSteps[i].id + '.data');
                            if (stepData.identificationFor === 'gestures' && stepData.sensor !== 'none') {
                                sensorCount++;

                                if (!sensorArrayHasType(options.record, stepData.sensor)) {
                                    options.record.push({type: stepData.sensor, banned: false, initialized: false});
                                    options.initRecorders.push({type: stepData.sensor});
                                    sensors.push({type: stepData.sensor});

                                    var listItem = $('#item-container-prepare').find('#initialize-recorders-list-item').clone();
                                    $(listItem).attr('data-sensor', stepData.sensor);
                                    $(listItem).find('.text').text(translation.sensors[stepData.sensor].initialize);
                                    $('#study-participation #technical-check').removeClass('hidden');
                                    $('#study-participation #initialize-recorders-list').append(listItem);

                                    $(listItem).find('.btn-ban-sensor').unbind('click').bind('click', {type: stepData.sensor}, function (event) {
                                        event.preventDefault();
                                        if (sensorBanned(options.record, event.data.type)) {
                                            $(this).removeClass('btn-success').addClass('btn-danger');
                                            $(this).find('.fa').removeClass('fa-check').addClass('fa-ban');
                                            $(this).find('.btn-text').text(translation.banSensor);
                                            unbanSensor(options.record, event.data.type);
                                        } else {
                                            $(this).removeClass('btn-danger').addClass('btn-success');
                                            $(this).find('.fa').removeClass('fa-ban').addClass('fa-check');
                                            $(this).find('.btn-text').text(translation.unbanSensor);
                                            banSensor(options.record, event.data.type);
                                        }

                                        saveSensors(options.record);
                                        peerConnection.sendMessage(MESSAGE_SYNC_SENSORS, {sensors: options.record});
                                    });
                                }
                            }
                        }
                    }

                    if (sensorCount > 0) {
                        gestureRecorder = new GestureRecorder(options);
                        $(gestureRecorder).unbind('recorderReady').bind('recorderReady', function (event, type) {
                            event.preventDefault();
                            var listItem = $('#study-participation #initialize-recorders-list').find('[data-sensor=' + type + ']');
                            $(listItem).find('.init-icon').removeClass('fa-spin fa-circle-o-notch').addClass('fa-check success');
                            $(listItem).find('.text').text(translation.sensors[type].title);
                            initSensor(options.record, type);
                            saveSensors(options.record);
                            peerConnection.sendMessage(MESSAGE_RECORDER_READY, {type: type});
                        });

                        $(gestureRecorder).unbind('recorderDisconnected').bind('recorderDisconnected', function (event, type) {
                            event.preventDefault();
                            var listItem = $('#study-participation #initialize-recorders-list').find('[data-sensor=' + type + ']');
                            $(listItem).find('.init-icon').removeClass('fa-check success').addClass('fa-spin fa-circle-o-notch');
                            $(listItem).find('.text').text(translation.sensors[type].initialize);
                            saveSensors(options.record);
                            peerConnection.sendMessage(MESSAGE_RECORDER_LOST, {type: type});
                        });

                        $(gestureRecorder).unbind('allRecorderReady').bind('allRecorderReady', function (event) {
                            event.preventDefault();
                            saveSensors(options.record);
                            peerConnection.sendMessage(MESSAGE_ALL_RECORDER_READY, {sensors: options.record});
                        });

                        $(peerConnection).unbind(MESSAGE_SYNC_SENSORS).bind(MESSAGE_SYNC_SENSORS, function (event, payload) {
                            event.preventDefault();
                            options.record = payload.sensors;
                            for (var i = 0; i < options.record.length; i++) {
                                var button = $('#study-participation #initialize-recorders-list').find('[data-sensor=' + options.record[i].type + '] .btn-ban-sensor');
                                if (options.record[i].banned === true) {
                                    $(button).removeClass('btn-danger').addClass('btn-success');
                                    $(button).find('.fa').removeClass('fa-ban').addClass('fa-check');
                                    $(button).find('.btn-text').text(translation.unbanSensor);
                                } else {
                                    $(button).removeClass('btn-success').addClass('btn-danger');
                                    $(button).find('.fa').removeClass('fa-check').addClass('fa-ban');
                                    $(button).find('.btn-text').text(translation.banSensor);
                                }
                            }
                            saveSensors(options.record);
                        });

                        $(peerConnection).unbind(MESSAGE_REQUEST_SENSOR_STATUS).bind(MESSAGE_REQUEST_SENSOR_STATUS, function (event) {
                            event.preventDefault();
                            if (options.record.length > 0) {
                                var readyCount = 0;
                                for (var i = 0; i < options.record.length; i++) {
                                    if (options.record[i].initialized === true) {
                                        readyCount++;
                                        peerConnection.sendMessage(MESSAGE_RECORDER_READY, {type: options.record[i].type});
                                    }
                                }

                                if (readyCount === options.record.length) {
                                    peerConnection.sendMessage(MESSAGE_ALL_RECORDER_READY, {sensors: options.record});
                                    saveSensors(options.record);
                                }
                            }
                        });
                    }
                }
            });

            // a peer video has been removed
            $(peerConnection).on('videoRemoved', function () {
                appendAlert($('#alert-hints'), ALERT_WAITING_FOR_MODERATOR);
                $('#study-participation #technical-check').addClass('hidden');
                if (gestureRecorder) {
                    gestureRecorder.destroy();
                    gestureRecorder = null;
                }
            });

            $(peerConnection).on(MESSAGE_ENTER_SURVEY, function (event, payload) {
                console.log('enter survey', payload);
                var query = getQueryParams(document.location.search);
                goto('study-execution-tester.php?studyId=' + query.studyId + '&token=' + query.token + '&h=' + query.h + '&roomId=' + payload.rtcToken);
            });

            function sensorArrayHasType(sensors, type) {
                if (sensors && sensors.length > 0) {
                    for (var i = 0; i < sensors.length; i++) {
                        if (sensors[i].type === type) {
                            return true;
                        }
                    }
                }
                return false;
            }

            function sensorBanned(sensors, type) {
                if (sensors && sensors.length > 0) {
                    for (var i = 0; i < sensors.length; i++) {
                        if (sensors[i].type === type) {
                            return sensors[i].banned;
                        }
                    }
                }
                return false;
            }

            function banSensor(sensors, type) {
                if (sensors && sensors.length > 0) {
                    for (var i = 0; i < sensors.length; i++) {
                        if (sensors[i].type === type) {
                            sensors[i].banned = true;

                            break;
                        }
                    }
                }
            }

            function unbanSensor(sensors, type) {
                if (sensors && sensors.length > 0) {
                    for (var i = 0; i < sensors.length; i++) {
                        if (sensors[i].type === type) {
                            sensors[i].banned = false;
                            break;
                        }
                    }
                }
            }

            function initSensor(sensors, type) {
                if (sensors && sensors.length > 0) {
                    for (var i = 0; i < sensors.length; i++) {
                        if (sensors[i].type === type) {
                            sensors[i].initialized = true;
                            break;
                        }
                    }
                }
            }

            function saveSensors(sensors) {
                savePreparedSensors({preparedSensors: sensors}, function (result) {
                    console.log(result);

                });
            }
        }
    </script>
</body>
</html>
