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
            header('Location: study-prepare-fallback.php?studyId=' . $studyId . '&h=' . $token);
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
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/greensock/TweenMax.min.js"></script>
        <script src="resumable/resumable.js"></script>

        <!-- gesturenote specific sources -->
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/study-preview.css">
        <link rel="stylesheet" href="css/gesture.css">

        <script src="js/chance.min.js"></script>
        <script src="js/color-thief/color-thief.js"></script>
        <script src="js/sha512.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/refreshSession.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/language.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-tester.js"></script>       
        <script src="js/ajax.js"></script> 
        <script src="js/gesture.js"></script>
        <script src="js/forms.js"></script>
        <script src="js/joint-selection.js"></script>
        <script src="js/study-execution.js"></script>
        <script src="js/study-execution-tester.js"></script>
        <script src="js/study-execution-tester-save.js"></script>
        <script src="js/upload-queue.js"></script>

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
    <body id="pageBody">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-gesture"></div>
        <div id="template-previews"></div>
        <div id="template-gesture-recorder"></div>

        <!-- modals -->
        <div id="custom-modal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">

                </div>
            </div>
        </div>

        <div style="position: fixed;top: 0;  width: 100%; z-index: 500">
            <button class="btn-cancel btn btn-danger btn-block" style="border-radius: 0" id="btn-cancel"><span class="btn-text"><?php echo $lang->cancelStudy ?></span> <i class="fa fa-close"></i></button>
        </div>

        <!-- progress bar -->
        <div id="progressTop" style="position: fixed; top: 34px; left: 0; right: 0">
            <div class="progress" style="border-radius: 0px">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 0%">
                    0%
                </div>
            </div>
        </div>


        <!-- Container (Panel Section) -->
        <div class="mainContent" id="mainContent" style="margin-top:60px">
            <div id="viewTester">
                <div class="alert-space alert-please-wait" style="padding-left:10px; padding-right: 10px;"></div>
                <div id="pinnedRTC" style="position: fixed; left: 18px; opacity: 0"></div>
                <div id="phase-content" class="hidden"></div>
            </div>
        </div>

        <div id="video-caller-holder" class="hidden">
            <div class="embed-responsive embed-responsive-4by3" id="video-caller">
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
            <!--            <div id="video-caller" style="width: 100%">
                            <div id="remote-stream" class="rtc-remote-container rtc-stream" style="border-radius: 4px;"></div>
                            <div class="rtc-local-container" style="position: absolute">
                                <video autoplay id="local-stream" class="rtc-stream" style="display:block"></video>
                            </div>
                            <div class="btn-group" id="stream-controls" style="position: absolute; bottom: 11px; display: block; left: 50%; transform: translate(-50%, 0); opacity: 0">
                                <button type="button" class="btn stream-control" id="btn-stream-local-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->muteMicrofone ?>"><i class="fa fa-microphone-slash"></i> </button>
                                <button type="button" class="btn stream-control" id="btn-pause-stream" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOwnWebRTC ?>"><i class="fa fa-pause"></i> </button>
                                <button type="button" class="btn stream-control" id="btn-stream-remote-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOtherWebRTC ?>"><i class="fa fa-volume-up"></i> </button>
                            </div>
                            <div id="stream-control-indicator">
                                <div style="position: absolute; top: 2px; display: block; left: 10px; opacity: 1; color: white">
                                    <i id="mute-local-audio" class="hidden fa fa-microphone-slash" style="margin-right: 3px"></i>
                                    <i id="pause-local-stream" class="hidden fa fa-pause"></i>
                                </div>
                                <div style="position: absolute; top: 2px; display: block; right:10px; opacity: 1; color: white">
                                    <i id="mute-remote-audio" class="hidden fa fa-microphone-slash"></i>
                                    <i id="pause-remote-stream" class="hidden fa fa-pause" style="margin-left: 3px"></i>
                                </div>
                            </div>
                        </div>-->
        </div>


        <script>
            $(document).ready(function () {
                checkDomain();
                keepSessionAlive();

                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-gesture', PATH_EXTERNALS + 'template-gesture.php']);
                    externals.push(['#template-previews', PATH_EXTERNALS + 'template-previews.php']);
                    externals.push(['#template-gesture-recorder', PATH_EXTERNALS + 'template-gesture-recorder.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                appendAlert($('#viewTester'), ALERT_PLEASE_WAIT);
                initPopover();

                var query = getQueryParams(document.location.search);
                if (query.studyId && query.h && query.token) {
                    currentView = VIEW_TESTER;
                    var status = window.location.hash.substr(1);
                    var statusAddressMatch = statusAddressMatchIndex(status);

                    // check if there was a page reload, status = '' for debugging
                    if (status !== '' && statusAddressMatch !== null) {
                        currentPhaseStepIndex = statusAddressMatch.index;
                        if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_MODERATED) {
                            syncPhaseStep = true;
                        }

                        checkStorage();
                    } else {
                        getStudyById({studyId: query.studyId}, function (result) {
                            if (result.status === RESULT_SUCCESS) {
                                setStudyData(result);
                                checkStorage();
                            }
                        });
                    }
                }
            }

            function renderPhaseStep() {
                var preparedSensors = JSON.parse('<?php echo json_encode($_SESSION['preparedSensors']) ?>');
                console.log(preparedSensors);
                setLocalItem('preparedSensors', preparedSensors || null);

                rescueVideoCaller();
                removeAlert($('#mainContent'), ALERT_NO_PHASE_DATA);
                $('#viewTester').find('#phase-content').empty();
                Tester.renderView();
                window.location.hash = getCurrentPhase().id;
            }


            // resize rtc placeholder functionalities
            $(window).on('resize', function () {
                if (!$('#pinnedRTC').hasClass('hidden') && $('#viewTester #column-left').hasClass('rtc-scalable')) {
                    if ($(document).scrollTop() === 0) {
                        updateRTCHeight($('#viewTester #column-left').width(), true);
                    } else {
                        $(document).scrollTop(0);
                    }
                }
            });

            $(window).scroll(function () {
                updateRTCHeight($('#viewTester #column-left').width());
            });

            function resetRTC() {
                $(window).resize();
            }

            function updateRTCHeight(updateWidth, updateColumn) {
                var scrollTop = $(document).scrollTop();
                var newHeight = 3 / 4 * updateWidth - scrollTop;
                var newWidth = 4 / 3 * newHeight;
                if (newWidth > DRAGGABLE_MIN_WIDTH) {
                    $('#viewTester #video-caller').css({height: newHeight + 'px', width: newWidth + 'px'});
                }

                if (updateColumn) {
                    TweenMax.to($('#viewTester #column-left'), .2, {css: {marginTop: newHeight + 20, opacity: 1.0}});
                }
            }
        </script>
    </body>
</html>
