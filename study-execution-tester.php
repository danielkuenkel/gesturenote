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
        <title>GestureNote</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/study-preview.css">
        <link rel="stylesheet" href="css/gesture.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">

        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>
        <script src="resumable/resumable.js"></script>

        <script src="js/chance.min.js"></script>
        <script src="color-thief/color-thief.js"></script>
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
        <script src="andyet/simplewebrtcbundle.js"></script>
        <script src="js/peerConnection.js"></script>
        <!--<script src="js/peerConnectionSharing.js"></script>-->

        <!-- screen sharing -->
<!--        <script src="//cdn.webrtc-experiment.com/getScreenId.js"></script>
        <script src="//cdn.webrtc-experiment.com/screen.js"></script>-->
        <!--<script src="//cdn.webrtc-experiment.com/firebase.js"></script>-->

        <!-- gesture recorder sources -->
        <script src="js/gesture-recorder.js"></script>
        <script src="https://cdn.WebRTC-Experiment.com/RecordRTC.js"></script>
        <script src="https://cdn.webrtc-experiment.com/gumadapter.js"></script>
        <script src="https://cdn.webrtc-experiment.com/RecordRTC/Whammy.js"></script>
    </head>
    <body id="pageBody">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-gesture"></div>
        <div id="template-previews"></div>
        <div id="template-gesture-recorder"></div>
        
        <!--<div id="screenSharingTarget" class="hidden"></div>-->

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
        <div class="mainContent" id="mainContent">
            <div id="viewTester">
                <div id="pinnedRTC" style="position: fixed; left: 18px"></div>
                <div id="phase-content"></div>
            </div>
        </div>

        <!-- rtc live stream -->
        <!--        <div id="web-rtc-live-stream" class="hidden" >
                    <video autoplay class="rtc-stream" style="width: 100%; height: auto; overflow: hidden; border-radius: 4px;"></video>
                </div>-->

        <div id="video-caller-holder" class="hidden">
            <div id="video-caller" style="width: 100%">
                <div id="remote-stream" class="rtc-remote-container rtc-stream" style="border-radius: 4px;"></div>
                <div class="rtc-local-container" style="position: absolute">
                    <video autoplay id="local-stream" class="rtc-stream" style="display:block"></video>
                </div>
                <div class="btn-group" id="stream-controls" style="position: absolute; bottom: 11px; display: block; left: 50%; transform: translate(-50%, 0); opacity: 0">
                    <button type="button" class="btn stream-control" id="btn-stream-local-mute" data-toggle="tooltip" data-placement="top" title="Mikrofon stummschalten"><i class="fa fa-microphone-slash"></i> </button>
                    <button type="button" class="btn stream-control" id="btn-pause-stream" data-toggle="tooltip" data-placement="top" title="Übertragung pausieren"><i class="fa fa-pause"></i> </button>
                    <button type="button" class="btn stream-control" id="btn-stream-remote-mute" data-toggle="tooltip" data-placement="top" title="Gesprächspartner stummschalten"><i class="fa fa-volume-up"></i> </button>
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
            </div>
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
                $('[data-toggle="tooltip"]').tooltip({container: 'body'});
                console.log('tester id: <?php echo $_SESSION['user_id'] ?>');

                var query = getQueryParams(document.location.search);
                if (query.studyId && query.h && query.token) {
                    currentView = VIEW_TESTER;
                    var status = window.location.hash.substr(1);
                    var statusAddressMatch = statusAddressMatchIndex(status);

                    // check if there was a page reload
//                    status = ''; // for testing
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
                rescueVideoCaller();
                removeAlert($('#mainContent'), ALERT_NO_PHASE_DATA);
                $('#viewTester').find('#phase-content').empty();
                Tester.renderView();
                window.location.hash = getCurrentPhase().id;
            }

            $(window).on('resize', function () {
                if (!$('#pinnedRTC').hasClass('hidden') && (!$('#viewTester #column-left').hasClass('rtc-scalable') || ($(document).scrollTop() === 0))) {
                    updateRTCHeight($('#viewTester #column-left').width());
                }
            });

            function updateRTCHeight(newWidth) {
                var height = newWidth * 3 / 4;
                TweenMax.to($('#video-caller'), .1, {width: newWidth, height: height, onComplete: onResizeComplete});
            }

            function onResizeComplete() {
                TweenMax.to($('#viewTester #column-left'), .2, {css: {marginTop: $('#video-caller').height() + 20, opacity: 1.0}});
            }

            var resetRTCTimeout;
            $(window).scroll(function () {
//                return null;
                if ($('#viewTester #column-left').hasClass('rtc-scalable') && !$('#pinnedRTC').hasClass('hidden')) {
                    if ($(document).scrollTop() <= 0 && ($('#viewTester #column-left').width() !== $('#video-caller').width() || $('#video-caller').height() !== $('#viewTester #column-left').offset().top - 40)) {
                        resetRTCTimeout = setTimeout(resetRTC(), 100);
                        return false;
                    } else {
                        clearTimeout(resetRTCTimeout);
                    }

                    var ratio = 4 / 3;
                    var newHeight = Math.min($('#viewTester #column-left').offset().top - 75 - parseInt($('#mainContent').css('padding-top')), Math.max($('#viewTester #column-left').offset().top - $(document).scrollTop() - 75 - parseInt($('#mainContent').css('padding-top')), 170));
                    $('#video-caller').width(Math.min(newHeight * ratio, $('#viewTester #column-left').width()));
                    $('#video-caller').height(newHeight);
                }
            });

            function resetRTC() {
                clearTimeout(resetRTCTimeout);
                $(window).resize();
            }
        </script>
    </body>
</html>
