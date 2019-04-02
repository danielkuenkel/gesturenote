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

        <!-- third party sources -->
        <link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/greensock/TweenMax.min.js"></script>
        <script src="js/muazkhan/DetectRTC.min.js"></script>

        <!-- gesturenote specific sources -->
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">

        <script src="js/constants.js"></script>
        <script src="js/refreshSession.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/login.js"></script>
        <script src="js/checkForms.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/sha512.js"></script>
        <script src="js/execution/study-execution.js"></script>

        <!-- streaming -->
        <script src="js/andyet/simplewebrtc.bundle.js"></script>
        <script src="js/peerConnection.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-general"></div>
        <div id="template-previews"></div>

        <!-- Container (Breadcrump) --> 
        <div class="container" id="breadcrumb" style="">
            <div class="row">
                <ol class="breadcrumb">
                    <!--<li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>-->
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-studies"><i class="fa fa-tasks" aria-hidden="true"></i> <?php echo $lang->breadcrump->studies ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-study"><i class="fa fa-clipboard"></i> <?php echo $lang->breadcrump->study ?></a></li>
                    <li class="active"><?php echo $lang->breadcrump->studyPrepare ?></li>
                </ol>
            </div>
        </div>

        <div id="loading-indicator" class="window-sized-loading text-center">
            <i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw"></i>
        </div>

        <!-- Container (Panel Section) -->
        <div class="container mainContent hidden">

            <div class="row">
                <div class="col-xs-12">
                    <h2 id="study-headline" style="margin-top: 0; margin-bottom: 0px"></h2>
                    <!--<hr>-->
                    <div class="label label-default" id="type-phase"></div>
                    <div class="label label-default" id="type-survey"></div>
                </div>
            </div>

            <div class="row hidden" id="study-details">
                <div class="col-sm-5 col-md-6 col-lg-5" style="margin-bottom: 40px">
                    <div id="study-description">
                        <h3 class="address"></h3>
                        <p class="text"></p>
                    </div>

                    <div class="hidden study-plan"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>
                </div>

                <div class="col-sm-7 col-md-6 col-lg-7">

                    <div id="alert-hints" class="">
                        <div class="alert-space alert-study-over-range"></div>
                        <div class="alert-space alert-study-under-range"></div>
                        <div class="alert-space alert-study-unmoderated"></div>
                        <div class="alert-space alert-web-rtc-not-supported"></div>
                        <div class="alert-space alert-another-browser-needed-for-web-rtc"></div>
                        <div class="alert-space alert-contact-support"></div>
                    </div>

                    <div id="role-selection-container" class="">
                        <h3><?php echo $lang->roleSelection ?></h3>
                        <div class="alert-space alert-duplicated-role-detected"></div>
                        <div class="form-group root roleSelect">
                            <!--                            <label style="margin: 0">
                                                            <span><?php echo $lang->roleSelection ?></span> 
                                                            <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->physicalStressTestSingleGraphic ?>"></i>
                                                        </label><br>-->

                            <div class="btn-group" id="radio" style="">
                                <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="moderator">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin hidden" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->userTypes->evaluator ?></span>
                                </button>
                            </div>
                            <div class="btn-group" id="radio" style="">
                                <button class="btn btn-default btn-radio" name="primary" id="observer">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->userTypes->observer ?></span>
                                </button>
                            </div>
                            <div class="btn-group" id="radio" style="">
                                <button class="btn btn-default btn-radio" name="primary" id="wizard">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->userTypes->wizard ?></span>
                                </button>
                            </div>

                        </div>

                        <button class="btn btn-block btn-default btn-shadow" id="btn-check-rtc"><?php echo $lang->applySelection ?></button>
                    </div>

                    <div id="check-rtc-status" class="hidden">
                        <h3><?php echo $lang->technicalTest ?></h3>
                        <div class="check-web-rtc">
                            <span class="status-check-indicator">
                                <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                                <i class="status-warn fa fa-warning warning hidden"></i>
                                <i class="status-supported fa fa-check success hidden"></i>
                            </span>
                            <span class="status-check-text text"><?php echo $lang->webrtc ?></span>
                        </div>
                        <div class="check-webcam">
                            <span class="status-check-indicator">
                                <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                                <i class="status-warn fa fa-warning warning hidden"></i>
                                <i class="status-supported fa fa-check success hidden"></i>
                            </span>
                            <span class="status-check-text text"><?php echo $lang->webcam ?></span>
                        </div>
                        <div class="check-microphone">
                            <span class="status-check-indicator">
                                <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                                <i class="status-warn fa fa-warning warning hidden"></i>
                                <i class="status-supported fa fa-check success hidden"></i>
                            </span>
                            <span class="status-check-text text"><?php echo $lang->audioInput ?></span>
                        </div>
                        <div class="check-speakers">
                            <span class="status-check-indicator">
                                <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                                <i class="status-warn fa fa-warning warning hidden"></i>
                                <i class="status-supported fa fa-check success hidden"></i>
                            </span>
                            <span class="status-check-text text"><?php echo $lang->audioOutput ?></span>
                        </div>
                        <!--                        <div class="check-stream-capturing">
                                                    <span class="status-check-indicator">
                                                        <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                                                        <i class="status-warn fa fa-warning warning hidden"></i>
                                                        <i class="status-supported fa fa-check success hidden"></i>
                                                    </span>
                                                    <span class="status-check-text text">Streaming</span>
                                                </div>-->
                        <div class="check-screen-capturing">
                            <span class="status-check-indicator">
                                <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                                <i class="status-warn fa fa-warning warning hidden"></i>
                                <i class="status-supported fa fa-check success hidden"></i>
                            </span>
                            <span class="status-check-text text"><?php echo $lang->screensharing ?></span>
                        </div>
                    </div>

                    <div id="participation-queue" class="hidden" style="margin-top: 40px">
                        <h3><?php echo $lang->waitingParticipants ?></h3>

                        <div class="form-group hidden root iceTransportsSelect">
                            <label style="margin: 0">
                                <span><?php echo $lang->bypassFirewall ?></span> 
                                <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->execution->bypassFirewall ?>"></i>
                            </label><br>

                            <div class="btn-group" id="radio" style="">
                                <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="no">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin hidden" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->no ?></span>
                                </button>
                            </div>
                            <div class="btn-group" id="radio" style="">
                                <button class="btn btn-default btn-radio" name="primary" id="yes">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->yes ?></span>
                                </button>
                            </div>

                        </div>

                        <div class="alert-space alert-search-participation-requests"></div>
                        <div id="list-container" class="row"></div>
                    </div>

                    <div id="call-screen" class="row hidden">
                        <div class="col-xs-12">
                            <div class="embed-responsive embed-responsive-4by3" id="video-caller">
                                <div class="embed-responsive-item" style="border-radius: 8px; background-color: #eee;display: flex; justify-content: center; align-items: center;">
                                    <i class="fa fa-circle-o-notch fa-spin fa-3x"></i>
                                </div>
                                <div id="remote-stream" class="rtc-remote-container rtc-stream embed-responsive-item" style="border-radius: 8px;"></div>
                                <div class="rtc-local-container embed-responsive-item">
                                    <video autoplay id="local-stream" class="rtc-stream" style="display:block;"></video>
                                </div>
                                <div class="btn-group" id="stream-controls" style="position: absolute; bottom: 6px; left: 50%; transform: translate(-50%, 0); opacity: 0">
                                    <button type="button" class="btn btn-sm stream-control" id="btn-stream-local-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->muteMicrofone ?>"><i class="fa fa-microphone-slash"></i> </button>
                                    <button type="button" class="btn btn-sm stream-control" id="btn-pause-stream" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOwnWebRTC ?>"><i class="fa fa-pause"></i> </button>
                                    <button type="button" class="btn btn-sm stream-control" id="btn-stream-remote-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOtherWebRTC ?>"><i class="fa fa-volume-up"></i> </button>
                                    <button type="button" class="btn btn-sm stream-control" id="btn-config-rtc" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->configRTC ?>"><i class="fa fa-cog"></i> </button>
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

                                <div id="rtc-config-panel" class="hidden" style="border-radius: 8px; background-color: rgba(0,0,0,.4); padding: 15px 15px 0px 15px; position: absolute; top:0px; bottom:0px; left: 0px; right: 0px">
                                    <div class="form-group" id="video-input-select">
                                        <label style="margin: 0; color: white"><?php echo $lang->chooseVideoInput ?></label><br>

                                        <div class="input-group">
                                            <input class="form-control item-input-text show-dropdown" tabindex="-1" type="text" value=""/>
                                            <div class="input-group-btn select select-video-input" role="group">
                                                <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="audio-input-select">
                                        <label style="margin: 0; color: white"><?php echo $lang->chooseAudioInput ?></label><br>

                                        <div class="input-group">
                                            <input class="form-control item-input-text show-dropdown" tabindex="-1" type="text" value=""/>
                                            <div class="input-group-btn select select-audio-input" role="group">
                                                <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-default btn-block btn-shadow" id="btn-close-config"><i class="fa fa-check"></i></button>
                                </div>

                            </div>



                        </div>
                        <div class="col-xs-12 hidden" id="technical-check" style="margin-top: 10px">
                            <div id="initialize-recorders-list" class="text-center"></div>
                        </div>
                        <div class="col-xs-12 text-center" style="margin-top: 10px;">
                            <div class="btn-group">
                                <button class="btn btn-danger btn-shadow" id="btn-close-call"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
                                <button class="btn btn-success btn-shadow disabled" id="btn-enter-study"><i class="fa fa-chevron-right"></i> <?php echo $lang->enterStudyAsModerator ?></button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="root col-xs-12 hidden" id="queue-thumbnail">
            <div class="panel panel-shadow panel-sm btn-shadow">
                <div class="panel-body">
                    <span id="waiting" style="font-size: 9pt;"><span class="participant-name" style="font-weight: bold; color: black;"></span> <span class="address"><?php echo $lang->waiting ?>:</span> <span class="text"></span></span>
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
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                    externals.push(['#template-previews', PATH_EXTERNALS + 'template-previews.php']);
                    loadExternals(externals);
                });
            });
            function onAllExternalsLoadedSuccessfully() {
                initPopover();
                renderSubPageElements(false);
                checkDarkMode(parseInt('<?php echo checkDarkMode(); ?>'));

                var query = getQueryParams(document.location.search);
                if (query.studyId && query.h && query.token) {
                    getStudyById({studyId: query.studyId}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            setStudyData(result);
                            renderData(result);
                            animateBreadcrump();
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

                $('.study-plan').find('.address').text(now > dateTo ? translation.studyRuns : translation.studyRun + ": ");
                $('.study-plan').find('.text').text(totalDays + " " + (totalDays === 1 ? translation.day : translation.days) + ", " + translation.from + ' ' + (totalDays === 1 ? new Date(dateFrom).toLocaleDateString() : new Date(dateFrom).toLocaleDateString() + " " + translation.to + " " + new Date(dateTo).toLocaleDateString()));
                $('.study-plan').removeClass('hidden');

                if (studyData.generalData.surveyType === TYPE_SURVEY_MODERATED) {
                    $('#study-details').removeClass('hidden');
                    if (now > dateFrom && now < dateTo) {

                        checkRoles();

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
                                $('#btn-enter-study').addClass('disabled');
                                $('#btn-close-call').addClass('disabled');

                                var rtcToken = $('#call-screen').attr('data-rtc-token');
                                var testerId = $('#call-screen').attr('data-tester-id');
                                var iceTransports = $('.iceTransportsSelect').find('.btn-option-checked').attr('id') === 'yes' ? 'relay' : 'all';
                                var mediaSources = peerConnection.mediaSources();
                                if (mediaSources && mediaSources.video && mediaSources.audio) {
                                    $(peerConnection).unbind(MESSAGE_PARTICIPANT_ENTERED_STUDY).bind(MESSAGE_PARTICIPANT_ENTERED_STUDY, function (event) {
                                        event.preventDefault();
                                        startExecution({iceTransports: iceTransports, rtcToken: rtcToken, testerId: testerId});
//                                        setTimeout(function () {
//                                        var query = getQueryParams(document.location.search);
//                                        if (iceTransports !== '') {
//                                            goto('study-execution-evaluator.php?studyId=' + query.studyId + '&token=' + query.token + '&h=' + query.h + '&roomId=' + rtcToken + '&testerId=' + testerId + '&vSource=' + mediaSources.video + '&aSource=' + mediaSources.audio + '&iceTransports=' + iceTransports);
//                                        } else {
//                                            goto('study-execution-evaluator.php?studyId=' + query.studyId + '&token=' + query.token + '&h=' + query.h + '&roomId=' + rtcToken + '&testerId=' + testerId + '&vSource=' + mediaSources.video + '&aSource=' + mediaSources.audio);
//                                        }
//                                        }, 1000);
                                    });

                                    peerConnection.sendMessage(MESSAGE_ENTER_SURVEY, {rtcToken: rtcToken, iceTransports: iceTransports, testerId: testerId});
                                }
                            }
                        });
                    } else if (now > dateFrom) {
                        appendAlert($('#alert-hints'), ALERT_STUDY_OVER_RANGE);
                    } else {
                        appendAlert($('#alert-hints'), ALERT_STUDY_UNDER_RANGE);
                    }
                } else {
                    $('#study-details').removeClass('hidden');
                    appendAlert($('#study-details'), ALERT_STUDY_UNMODERATED);
                    $('#study-details').find('#btn-open-study-details').on('click', function (event) {
                        event.preventDefault();
                        returnToStudyDetails();
                    });
                }

                $('.mainContent').removeClass('hidden');
                TweenMax.to($('#loading-indicator'), .4, {opacity: 0, onComplete: function () {
                        $('#loading-indicator').remove();
                    }});
                TweenMax.from($('.mainContent'), .3, {delay: .3, opacity: 0});
            }


            function checkRoles() {
                var studyData = getLocalItem(STUDY);
                var phaseSteps = getLocalItem(STUDY_PHASE_STEPS);
                var needObserver = true;
                var needWizard = false;

                for (var i = 0; i < phaseSteps.length; i++) {
                    var phaseStep = phaseSteps[i];
                    var phaseStepData = getLocalItem(phaseStep.id + '.data');

                    console.log(phaseStep, phaseStepData);
                    switch (phaseStep.format) {
                        case SCENARIO:
                            if (phaseStepData.tasks && phaseStepData.tasks.length > 0) {
                                needWizard = true;
                            }
                            break;
                    }
                }

                if (!needWizard) {
                    $('.roleSelect #wizard').addClass('disabled');
                }

                if (!needObserver) {
                    $('.roleSelect #observer').addClass('disabled');
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
                    $('.iceTransportsSelect').removeClass('hidden');

                    for (var i = 0; i < requests.length; i++) {

                        var request = requests[i];
                        var item = $('#queue-thumbnail').clone().removeAttr('id').removeClass('hidden');
                        $('#participation-queue').find('#list-container').append(item);
                        var created = convertSQLTimestampToDate(request.created);
                        var current = convertSQLTimestampToDate(request.current);
                        var waitingTime = getTimeBetweenTimestamps(created.getTime(), current.getTime());
                        $(item).find('#waiting .text').text(getTimeString(waitingTime, true));
                        $(item).find('#waiting .participant-name').text(request.name);

                        if (isNaN(request.testerId)) {
                            $(item).find('#user .label-text').text(translation.userTypes.guest);
                        } else {
                            $(item).find('#user .label-text').text(translation.userTypes.registered);
                        }

                        $(item).find('.panel').on('click', {requestId: request.id}, function (event) {
                            clearInterval(requestInterval);
                            approveParticipation({requestId: event.data.requestId}, function (result) {
//                                console.log(result);
                                if (result.status === RESULT_SUCCESS) {
                                    $('#participation-queue, #check-rtc-status, #role-selection-container').addClass('hidden');
                                    $('#call-screen').removeClass('hidden');
                                    $('#call-screen').attr('data-request-id', event.data.requestId);
                                    $('#call-screen').attr('data-rtc-token', result.data.rtcToken);
                                    $('#call-screen').attr('data-tester-id', result.data.testerId);
                                    initPeerConnection(result.data.rtcToken + '.prepare', selectedVideoSource, selectedAudioSource);
                                    $('.iceTransportsSelect').addClass('hidden');
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
                var requestId = $('#call-screen').attr('data-request-id');
                reapproveParticipation({requestId: requestId}, function (result) {
                    peerConnection.leaveRoom();
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
                goto("study.php?studyId=" + query.studyId + "&h=" + hash + '#participants');
            }

            var sources = {video: null, mic: null, constraints: null};
            function checkRTC(target) {
                $('#participation-queue').addClass('hidden');
                $('#check-rtc-status').removeClass('hidden');

                navigator.getUserMedia = navigator.getUserMedia ||
                        navigator.webkitGetUserMedia ||
                        navigator.mozGetUserMedia;

                if (navigator.getUserMedia) {
                    navigator.mediaDevices.enumerateDevices()
                            .then(gotDevices)
                            .catch(errorCallback);
                } else {
                    console.warn('Native device media streaming (getUserMedia) not supported in this browser.');
                }

                function gotDevices(deviceInfos) {
                    console.log('got devices for webcam recorder', deviceInfos);
                    var videoSource = null;
                    var audioSource = null;

                    for (var i = 0; i < deviceInfos.length; i++) {
                        if (!videoSource && deviceInfos[i].kind === 'videoinput' && !deviceInfos[i].label.toLowerCase().includes('leap') && !deviceInfos[i].label.toLowerCase().includes('kinect')) {
                            console.log('rtc check: standard video input device´', deviceInfos[i]);
                            videoSource = deviceInfos[i].deviceId;
                        } else if (!audioSource && deviceInfos[i].kind === 'audioinput' && !deviceInfos[i].label.toLowerCase().includes('xbox')) {
                            console.log('rtc check: standard audio input device:', deviceInfos[i]);
                            audioSource = deviceInfos[i].deviceId;
                        }

                        if (audioSource && videoSource) {
                            selectedVideoSource = videoSource;
                            selectedAudioSource = audioSource;
                            break;
                        }
                    }

                    loadDevice();
                }

                function errorCallback(deviceInfos) {
                    console.error('error', deviceInfos);
                }

                function loadDevice() {

                    DetectRTC.load(function () {
                        navigator.mediaDevices.getUserMedia({
                            audio: selectedAudioSource ? {deviceId: selectedAudioSource} : true, // { deviceId: 'mic-id' }
                            video: selectedVideoSource ? {deviceId: selectedVideoSource} : true // { deviceId: 'camera-id' }
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
                                errors++;
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

                            if (DetectRTC.isScreenCapturingSupported === false) {
                                errors++;
                                indicator = $(target).find('.check-screen-capturing .status-check-indicator');
                                $(indicator).find('.status-wait').addClass('hidden');
                                $(indicator).find('.status-warn').removeClass('hidden');
                            } else {
                                indicator = $(target).find('.check-screen-capturing .status-check-indicator');
                                $(indicator).find('.status-wait').addClass('hidden');
                                $(indicator).find('.status-supported').removeClass('hidden');
                            }

                            if (errors === 0) {
                                $('#participation-queue').removeClass('hidden');
                                $('#check-rtc-status').addClass('hidden');
                            }
                        });
                    });
                }
            }

            var peerConnection = null;
            var selectedVideoSource = null;
            var selectedAudioSource = null;
            function initPeerConnection(rtcToken, videoSource, audioSource) {
                console.log('initializeRTCPeerConnection', rtcToken);
//                if (peerConnection !== null) {
//                    peerConnection.joinRoom(rtcToken);
//                } 
//                else {
                var selectedRole = $('.roleSelect').find('.btn-option-checked').attr('id');
                var iceTransports = $('.iceTransportsSelect').find('.btn-option-checked').attr('id') === 'yes' ? 'relay' : '';
                console.log('ice transports: ', iceTransports);
                var mainElement = $('#video-caller');
                var callerOptions = {
                    callerElement: mainElement,
                    localVideoElement: 'local-stream',
                    remoteVideoElement: 'remote-stream',
                    streamControls: $(mainElement).find('#stream-controls'),
                    localMuteElement: $(mainElement).find('#btn-stream-local-mute'),
                    pauseStreamElement: $(mainElement).find('#btn-pause-stream'),
                    remoteMuteElement: $(mainElement).find('#btn-stream-remote-mute'),
                    configElement: $(mainElement).find('#btn-config-rtc'),
                    configPanel: $('#call-screen').find('#rtc-config-panel'),
                    indicator: $(mainElement).find('#stream-control-indicator'),
                    enableWebcamStream: true,
                    enableDataChannels: true,
                    autoRequestMedia: true,
                    roomId: rtcToken,
                    iceTransports: iceTransports !== '' ? iceTransports : null,
                    nick: selectedRole,
                    ignoreRole: 'no',
                    selectedRole: selectedRole,
                    visibleRoles: ['moderator', 'tester', 'observer', 'wizard'],
                    videoSource: videoSource,
                    audioSource: audioSource,
                    localStream: {audio: 'yes', video: 'yes', visualize: 'yes'},
                    remoteStream: {audio: 'yes', video: 'yes'}
                };

                peerConnection = new PeerConnection();
                peerConnection.initialize(callerOptions);
                peerConnection.showLocalStream();

                // joined the a specific room
                $(peerConnection).on('joinedRoom', function (event, roomName) {
                    event.preventDefault();

                    clearAlerts($('#study-participation, #role-selection-container'));
                    $('#study-details #initialize-recorders-list').empty();

                    // check if sensor has be connected
                    var studyData = getLocalItem(STUDY);
                    if (studyData.phase === TYPE_PHASE_ELICITATION) {
                        var phaseSteps = getLocalItem(STUDY_PHASE_STEPS);
                        var sensorCount = 0;
                        var options = {
                            record: []
                        };

                        for (var i = 0; i < phaseSteps.length; i++) {

                            if (phaseSteps[i].format === IDENTIFICATION) {
                                var stepData = getLocalItem(phaseSteps[i].id + '.data');
                                if (stepData.identificationFor === 'gestures' && stepData.sensor !== 'none') {
                                    sensorCount++;

                                    if (!sensorArrayHasType(options.record, stepData.sensor)) {
                                        options.record.push({type: stepData.sensor, banned: false, initialized: false});

                                        var listItem = $('#item-container-prepare').find('#initialize-recorders-list-item').clone();
                                        $(listItem).attr('data-sensor', stepData.sensor);
                                        $(listItem).find('.text').text(translation.sensors[stepData.sensor].initialize);
                                        $('#study-details #technical-check').removeClass('hidden');
                                        $('#study-details #initialize-recorders-list').append(listItem);

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
                                            checkSensorStates(options.record);
                                            peerConnection.sendMessage(MESSAGE_SYNC_SENSORS, {sensors: options.record});
                                        });
                                    }
                                }
                            }
                        }

                        if (sensorCount > 0) {
                            $(peerConnection).unbind(MESSAGE_RECORDER_READY).bind(MESSAGE_RECORDER_READY, function (event, payload) {
                                console.log(MESSAGE_RECORDER_READY, payload);
                                event.preventDefault();
                                var listItem = $('#study-details #initialize-recorders-list').find('[data-sensor=' + payload.type + ']');
                                $(listItem).find('.init-icon').removeClass('fa-spin fa-circle-o-notch').addClass('fa-check success');
                                $(listItem).find('.text').text(translation.sensors[payload.type].title);
                            });

                            $(peerConnection).unbind(MESSAGE_RECORDER_LOST).bind(MESSAGE_RECORDER_LOST, function (event, payload) {
                                console.log(MESSAGE_RECORDER_LOST, payload);
                                event.preventDefault();
                                var listItem = $('#study-details #initialize-recorders-list').find('[data-sensor=' + payload.type + ']');
                                $(listItem).find('.init-icon').removeClass('fa-check success').addClass('fa-spin fa-circle-o-notch');
                                $(listItem).find('.text').text(translation.sensors[payload.type].initialize);
                                $('#btn-enter-study').addClass('disabled');
                                saveSensors(null);
                                checkSensorStates();
                            });

                            $(peerConnection).unbind(MESSAGE_ALL_RECORDER_READY).bind(MESSAGE_ALL_RECORDER_READY, function (event, payload) {
                                event.preventDefault();
                                console.log(MESSAGE_ALL_RECORDER_READY, payload);
                                $('#btn-enter-study').removeClass('disabled');
                                options.record = payload.sensors;
                                saveSensors(options.record);
                                checkSensorStates();
                            });

                            $(peerConnection).unbind(MESSAGE_SYNC_SENSORS).bind(MESSAGE_SYNC_SENSORS, function (event, payload) {
                                event.preventDefault();
                                options.record = payload.sensors;
                                for (var i = 0; i < options.record.length; i++) {
                                    var button = $('#study-details #initialize-recorders-list').find('[data-sensor=' + options.record[i].type + '] .btn-ban-sensor');
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
                                checkSensorStates();
                            });

                            peerConnection.sendMessage(MESSAGE_REQUEST_SENSOR_STATUS);
                        } else {
//                            $('#btn-enter-study').removeClass('disabled');
//                            checkExecutionRole();
                        }
                    } else {
//                        $('#btn-enter-study').removeClass('disabled');
//                        checkExecutionRole();
                    }
                });

                // a peer video has been added
                $(peerConnection).on('videoAdded', function (event, video, peer) {
                    event.preventDefault();
                    if (peer.nick === USER_ROLE_TESTER) {
                        $('#btn-enter-study').removeClass('disabled');
                    }
                    checkExecutionRole();
                    console.log('VIDEO ADDED', video, peer);
                });

                // a peer video has been removed
                $(peerConnection).on('videoRemoved', function (event, video, peer) {
                    event.preventDefault();
                    if (peer.nick === USER_ROLE_TESTER) {
                        $('#btn-enter-study').addClass('disabled');
                    }
                    console.log('VIDEO REMOVED', video, peer);
                });

                $(peerConnection).on('leaveRoomDuplicatedRoles', function (event) {
                    event.preventDefault();
                    console.log('leaveRoomDuplicatedRoles');
                    appendAlert($('#role-selection-container'), ALERT_DUPLICATED_ROLE_DETECTED);
                });

                $(peerConnection).on('leftRoom', function (event, roomName) {
                    event.preventDefault();
                    console.log('LEFT ROOM');

                    clearAlerts($('#study-participation'));
                    $('#participation-queue, #role-selection-container').removeClass('hidden');
                    $('#call-screen').addClass('hidden');
                    $('#btn-enter-study').addClass('disabled');
                });


                $(peerConnection).on('renegotiate', function (event, videoSource, audioSource) {
                    event.preventDefault();
                    console.log('RENEGOTIATE');
                    peerConnection.leaveRoom();

                    selectedVideoSource = videoSource;
                    selectedAudioSource = audioSource;
                    initPeerConnection(rtcToken, videoSource, audioSource);
                });

                if (selectedRole !== VIEW_MODERATOR) {
                    $('#btn-close-call').css({borderTopRightRadius: '8px', borderBottomRightRadius: '8px'});
                    $('#btn-enter-study').remove();
                } else {
                    $('#btn-close-call').css({borderTopRightRadius: '', borderBottomRightRadius: ''});
                    $('#btn-enter-study').removeClass('hidden');
                }
            }

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

            function saveSensors(sensors) {
                savePreparedSensors({preparedSensors: sensors}, function (result) {
                    console.log('save sensors', result);
                });
            }

            function checkSensorStates(sensors) {
                var readyForExecution = true;
                if (sensors && sensors.length > 0) {
                    for (var i = 0; i < sensors.length; i++) {
                        if (sensors[i].banned === false && sensors[i].initialized === false) {
                            readyForExecution = false;
                            break;
                        }
                    }
                }

                if (readyForExecution) {
                    $('#btn-enter-study').removeClass('disabled');
                    checkExecutionRole();
                } else {
                    $('#btn-enter-study').addClass('disabled');
                }
            }

            $('#btn-check-rtc').unbind('click').bind('click', function (event) {
                checkRTC($('#check-rtc-status'));
            });

            function checkExecutionRole() {
                console.log('check execution role', peerConnection);
                var selectedRole = $('.roleSelect').find('.btn-option-checked').attr('id');
                if (selectedRole !== VIEW_MODERATOR) {
                    $(peerConnection).unbind(MESSAGE_ENTER_SURVEY).bind(MESSAGE_ENTER_SURVEY, function (event, payload) {
                        event.preventDefault();
                        startExecution(payload);
                    });
                }
            }


            function startExecution(payload) {
                console.log('start execution', payload);
                var selectedRole = $('.roleSelect').find('.btn-option-checked').attr('id');
                var query = getQueryParams(document.location.search);
                var mediaSources = peerConnection.mediaSources();

                if (payload.iceTransports !== '') {
                    goto('study-execution-' + selectedRole + '.php?studyId=' + query.studyId + '&token=' + query.token + '&h=' + query.h + '&roomId=' + payload.rtcToken + '&testerId=' + payload.testerId + '&vSource=' + mediaSources.video + '&aSource=' + mediaSources.audio + '&iceTransports=' + payload.iceTransports);
                } else {
                    goto('study-execution-' + selectedRole + '.php?studyId=' + query.studyId + '&token=' + query.token + '&h=' + query.h + '&roomId=' + payload.rtcToken + '&testerId=' + payload.testerId + '&vSource=' + mediaSources.video + '&aSource=' + mediaSources.audio);
                }
            }
        </script>
    </body>
</html>
