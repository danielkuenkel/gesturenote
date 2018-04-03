<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

session_start();
if (login_check($mysqli) == true) {
    if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'tester') {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $lang->gestureNoteStudyPreview ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/study-preview.css">
        <link rel="stylesheet" href="css/gesture.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.4.4/randomColor.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>
        
        <script src="js/stomp/stomp.js"></script>
        <script src="js/websocket.js"></script>
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
        <script src="js/goto-evaluator.js"></script>       
        <script src="js/ajax.js"></script> 
        <script src="js/gesture.js"></script>
        <script src="js/forms.js"></script>
        <script src="js/joint-selection.js"></script>
        <!--<script src="js/screen-sharing.js"></script>-->
        <script src="js/study-execution.js"></script>
        <script src="js/study-execution-tester.js"></script>
        <script src="js/study-execution-tester-save.js"></script>
        <script src="js/study-execution-moderator.js"></script>

        <!-- screen sharing sources -->
<!--        <script src="//cdn.webrtc-experiment.com/getScreenId.js"></script>
        <script src="muaz-khan/screen.js"></script>
        <script src="//cdn.webrtc-experiment.com/firebase.js"></script>-->

        <!--gesture recorder--> 
        <script src="js/gestureRecorder/gestureRecorder.js"></script>
        <script src="js/gestureRecorder/webcamRecorder.js"></script>
        <script src="js/gestureRecorder/leapRecorder.js"></script>
        
        <!-- bootstrap slider -->
        <link rel="stylesheet" href="js/bootstrap-slider/css/bootstrap-slider.css">
        <script src="js/bootstrap-slider/js/bootstrap-slider.js"></script>
    </head>
    <body>

        <div id="alerts"></div>
        <div id="template-general"></div>
        <div id="template-gesture"></div>
        <div id="template-previews"></div>
        <div id="template-study"></div>
        <div id="template-gesture-recorder"></div>

        <div id="preview-bar-top" style="padding: 10px; position: fixed">

            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default" id="btnViewModerator"><span class="hidden-sm hidden-xs">Moderator</span><span class="hidden-md hidden-lg">M</span></button>
                    <button type="button" class="btn btn-default" id="btnViewTester"><span class="hidden-sm hidden-xs">Tester</span><span class="hidden-md hidden-lg">T</span></button>
                </div>
                <input class="form-control item-input-text option-phase-steps show-dropdown text-center readonly" type="text" value=""/>
                <div class="input-group-btn phaseStepsSelect select" role="group">
                    <button class="btn btn-default btn-dropdown dropdown-toggle" id="btn-phaseStepSelect" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                    <ul class="dropdown-menu option" role="menu">
                    </ul>
                    <button type="button" class="btn btn-default previous disabled"><span aria-hidden="true">&larr;</span></span><span class="hidden-sm hidden-xs"> <?php echo $lang->previous ?></span></button>
                    <button type="button" class="btn btn-default next disabled"><span class="hidden-sm hidden-xs"><?php echo $lang->next ?></span> <span aria-hidden="true">&rarr;</span></button>
                    <button role="button" class="btn btn-default" id="btn-introduction"><i class="fa fa-support"></i> <span class="hidden-xs hidden-sm"><?php echo $lang->help ?></span></button>
                    <button type="button" class="btn btn-danger" id="btn-close-study-preview"><i class="glyphicon glyphicon-remove"></i><span class="hidden-sm hidden-xs"> <?php echo $lang->close ?></span></button>
                </div>
            </div>
        </div>

        <div style="position: fixed; top: 53px; width: 100%; z-index: 500">
            <button class="btn-cancel btn btn-danger btn-block" style="border-radius: 0" id="btn-cancel"><span class="btn-text"><?php echo $lang->cancelStudy ?></span> <i class="fa fa-close"></i></button>
        </div>


        <!-- progress bar -->
        <div id="progressTop">
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 0%">
                    0%
                </div>
            </div>
        </div>

        <!-- modals -->
        <div id="custom-modal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">

                </div>
            </div>
        </div>

        <div id="draggableRTC" class="hidden" style="position: fixed; z-index: 99; top: 150px; left:100px; display: block">
            <img src="img/resize.png" id="resize-sign" style="position: absolute; bottom: 0; right: 0;"/>
        </div>

        <!-- main content -->
        <div class="mainContent" id="mainContent" style="padding-top: 54px;">
            <div id="viewTester" class="hidden">
                <!--<div id="fixedRTC" style="position: fixed"></div>-->
                <div id="phase-content"></div>
            </div>

            <div id="viewModerator" class="hidden" style="padding-left: 20px; padding-right: 20px;">
                <div id="pinnedRTC" style="position: fixed"></div>

                <div id="phase-content"></div>
            </div>
        </div>

        <script>
            var currentView;
            $(document).ready(function () {
                checkDomain();
                keepSessionAlive();
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                    externals.push(['#template-gesture', PATH_EXTERNALS + 'template-gesture.php']);
                    externals.push(['#template-previews', PATH_EXTERNALS + 'template-previews.php']);
                    externals.push(['#template-study', PATH_EXTERNALS + 'template-study.php']);
                    externals.push(['#template-gesture-recorder', PATH_EXTERNALS + 'template-gesture-recorder.php']);
                    loadExternals(externals);
                });
            });

            $(window).on('resize', function () {
                if (!$('#pinnedRTC').hasClass('hidden') && (!$('#viewModerator #column-left').hasClass('rtc-scalable') || ($(document).scrollTop() === 0))) {
                    updateRTCHeight($('#viewModerator #column-left').width());
                }
            });

            function updateRTCHeight(newWidth) {
                var height = newWidth * 3 / 4;
                TweenMax.to($('#web-rtc-placeholder'), .1, {width: newWidth, height: height, onComplete: onResizeComplete});
            }

            function onResizeComplete() {
                TweenMax.to($('#viewModerator #column-left'), .2, {css: {marginTop: $('#web-rtc-placeholder').height() + 20, opacity: 1.0}});
            }

            var resetRTCTimeout;
            $(window).scroll(function () {
                if ($('#viewModerator #column-left').hasClass('rtc-scalable') && !$('#pinnedRTC').hasClass('hidden')) {
                    if ($(document).scrollTop() <= 0 && ($('#viewModerator #column-left').width() !== $('#web-rtc-placeholder').width() || $('#web-rtc-placeholder').height() !== $('#viewModerator #column-left').offset().top - 40)) {
                        resetRTCTimeout = setTimeout(resetRTC(), 100);
                        return false;
                    } else {
                        clearTimeout(resetRTCTimeout);
                    }

                    var ratio = 4 / 3;
                    var newHeight = Math.min($('#viewModerator #column-left').offset().top - 95 - parseInt($('#mainContent').css('padding-top')), Math.max($('#viewModerator #column-left').offset().top - $(document).scrollTop() - 95 - parseInt($('#mainContent').css('padding-top')), 170));
                    $('#web-rtc-placeholder').width(Math.min(newHeight * ratio, $('#viewModerator #column-left').width()));
                    $('#web-rtc-placeholder').height(newHeight);
                }
            });

            function resetRTC() {
                clearTimeout(resetRTCTimeout);
                $(window).resize();
            }

            function onAllExternalsLoadedSuccessfully() {
                var showTutorial = parseInt(<?php echo $_SESSION['tutorialStudyPreview'] ?>);
                if (showTutorial === 1) {
                    $('#btn-introduction').click();
//                    loadHTMLintoModal('custom-modal', 'externals/modal-introduction-study-preview.php', 'modal-lg');
                }

                previewModeEnabled = true;
                var query = getQueryParams(document.location.search);
                var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                var status = window.location.hash.substr(1);
                var statusAddressMatch = statusAddressMatchIndex(status);

                if (status !== '' && statusAddressMatch !== null) {
                    currentPhaseStepIndex = statusAddressMatch.index;
                }

                if (query.studyId && query.edit && (query.edit === true || query.edit === "true")) {
                    checkStorage();
                    $('#btn-close-study-preview').on('click', function (event) {
                        event.preventDefault();
                        goto("study-create.php?edit=true&studyId=" + query.studyId);
                    });
                } else if (query.studyId && query.h === hash) {
                    if (currentPhaseStepIndex === 0) {
                        getStudyById({studyId: query.studyId}, function (result) {
                            if (result.status === RESULT_SUCCESS) {
                                setStudyData(result);
                                checkStorage();
                            }
                        });
                    } else {
                        checkStorage();
                    }

                    $('#btn-close-study-preview').on('click', function (event) {
                        event.preventDefault();
//                        clearLocalItems();
                        var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                        goto("study.php?studyId=" + query.studyId + "&h=" + hash);
                    });
                } else {
                    checkStorage();
                    $('#btn-close-study-preview').on('click', function (event) {
                        event.preventDefault();
                        goto('study-create.php');
                    });
                }
            }

            $('.previous').on('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    previousStep();
                }
            });

            $('.phaseStepsSelect').on('change', function () {
                currentPhaseStepIndex = getCurrentPhaseStepIndex();
                updateProgress();
                renderPhaseStep();
                updatePager();
            });

            $('#btnViewModerator').on('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('active') && !$(this).hasClass('disabled')) {
                    showModeratorView();
                    renderPhaseStepForModerator();
                }
            });

            $('#btnViewTester').on('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('active')) {
                    showTesterView();
                    pinRTC();
                    renderPhaseStepForTester();
                }
            });

            function showModeratorView() {
                currentView = VIEW_MODERATOR;
                $('#btnViewModerator').addClass('active font-bold');
                $('#btnViewTester').removeClass('active font-bold');
                $('#viewTester').addClass('hidden');
                $('#viewModerator').removeClass('hidden');
            }

            function showTesterView() {
                currentView = VIEW_TESTER;
                $('#btnViewTester').addClass('active font-bold');
                $('#btnViewModerator').removeClass('active font-bold');
                $('#viewTester').removeClass('hidden');
                $('#viewModerator').addClass('hidden');
            }

            function renderPhaseStep() {
                removeAlert($('#mainContent'), ALERT_NO_PHASE_DATA);
                if (currentView === VIEW_TESTER) {
                    renderPhaseStepForTester();
                } else {
                    renderPhaseStepForModerator();
                }

                window.location.hash = getCurrentPhase().id;
            }

            function resetRenderedContent() {
                $('#viewTester').find('#phase-content').empty();
                $('#viewModerator').find('#phase-content').empty();
            }

            function renderPhaseStepForModerator() {
                resetRenderedContent();
                Moderator.renderView();
            }

            function renderPhaseStepForTester() {
                resetRenderedContent();
                Tester.renderView();
            }

            $(document).on('click', '.btn-toggle-rtc-fixed', function (event) {
                event.preventDefault();
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    $(this).find('.glyphicon').removeClass('glyphicon-pushpin');
                    $(this).find('.glyphicon').addClass('glyphicon-new-window');
                    pinRTC();
                } else {
                    $(this).addClass('selected');
                    $(this).find('.glyphicon').removeClass('glyphicon-new-window');
                    $(this).find('.glyphicon').addClass('glyphicon-pushpin');
                    dragRTC();
                }
            });

            $('#btn-introduction').on('click', function (event) {
                event.preventDefault();
                $('#custom-modal').attr('data-help-items-key', 'introductionPreviewStudy');
                $('#custom-modal').attr('data-help-context', 'studyPreview');
                $('#custom-modal').attr('data-help-show-tutorial', <?php echo $_SESSION['tutorialStudyPreview'] ?>);
                loadHTMLintoModal('custom-modal', 'externals/modal-introduction.php', 'modal-lg');
            });
        </script>
    </body>
</html>