<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

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

        <!-- third party sources -->
        <link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/greensock/TweenMax.min.js"></script>

        <!-- gesturenote specific sources -->
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/study-preview.css">
        <link rel="stylesheet" href="css/gesture.css">

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
        <script src="js/study-execution.js"></script>
        <script src="js/study-execution-tester.js"></script>
        <script src="js/study-execution-tester-save.js"></script>
        <script src="js/study-execution-moderator.js"></script>

        <!-- phase step formats -->
        <script src="js/execution/exploration.js"></script>
        <script src="js/execution/focus-group-interview.js"></script>
        <script src="js/execution/gesture-slideshow.js"></script>
        <script src="js/execution/gesture-training.js"></script>
        <script src="js/execution/gesture-usability-scale-multiple.js"></script>
        <script src="js/execution/gesture-usability-scale-single.js"></script>
        <script src="js/execution/identification.js"></script>
        <script src="js/execution/interview.js"></script>
        <script src="js/execution/letter-of-acceptance.js"></script>
        <script src="js/execution/physical-stress-test.js"></script>
        <script src="js/execution/questionnaire.js"></script>
        <script src="js/execution/system-usability-scale.js"></script>
        <script src="js/execution/thanks.js"></script>
        <script src="js/execution/trigger-slideshow.js"></script>
        <script src="js/execution/user-experience-questionnaire.js"></script>
        <script src="js/execution/user-test.js"></script>


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

        <div id="preview-bar-top" style="padding: 10px; position: fixed; width: 100%">

            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default" id="btnViewModerator"><span class="hidden-sm hidden-xs"><?php echo $lang->userTypes->evaluator ?></span><span class="hidden-md hidden-lg">M</span></button>
                    <button type="button" class="btn btn-default" id="btnViewTester"><span class="hidden-sm hidden-xs"><?php echo $lang->userTypes->tester ?></span><span class="hidden-md hidden-lg">T</span></button>
                </div>
                <input class="form-control item-input-text option-phase-steps show-dropdown text-center readonly" type="text" value=""/>
                <div class="input-group-btn phaseStepsSelect select" role="group">
                    <button class="btn btn-default btn-dropdown dropdown-toggle" id="btn-phaseStepSelect" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                    <ul class="dropdown-menu option" role="menu">
                    </ul>
                    <button type="button" class="btn btn-default previous disabled"><span aria-hidden="true">&larr;</span></span><span class="hidden-sm hidden-xs"> <?php echo $lang->previous ?></span></button>
                    <button type="button" class="btn btn-default next disabled"><span class="hidden-sm hidden-xs"><?php echo $lang->next ?></span> <span aria-hidden="true">&rarr;</span></button>
                    <button role="button" class="btn btn-default" id="btn-introduction"><i class="fa fa-support"></i> <span class="hidden-xs hidden-sm"><?php echo $lang->help ?></span></button>
                    <button type="button" class="btn btn-danger" id="btn-close-study-preview"><i class="fa fa-close"></i><span class="hidden-sm hidden-xs"> <?php echo $lang->close ?></span></button>
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
        </div>

        <!-- main content -->
        <div class="mainContent" id="mainContent" style="padding-top: 54px;">
            <div id="viewTester" class="hidden">
                <div id="phase-content"></div>
            </div>

            <div id="viewModerator" class="hidden" style="padding-left: 20px; padding-right: 20px;">
                <div id="pinnedRTC" style="position: fixed; z-index: 99"></div>
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

            // resize rtc placeholder functionalities
            $(window).on('resize', function () {
                if (!$('#viewModerator #pinnedRTC').hasClass('hidden') && $('#viewModerator #column-left').hasClass('rtc-scalable')) {
                    if ($(document).scrollTop() === 0) {
                        updateRTCHeight($('#viewModerator #column-left').width(), true);
                    } else {
                        $(document).scrollTop(0);
                    }
                } else {
                    var width = $('#viewModerator #column-left').width();
                    var height = 3 / 4 * width;
                    $('#viewModerator #web-rtc-placeholder').css({width: width + 'px', height: height + 'px'});
                }
            });

            $(window).scroll(function () {
                if (!$('#viewModerator #pinnedRTC').hasClass('hidden') && $('#viewModerator #column-left').hasClass('rtc-scalable')) {
                    updateRTCHeight($('#viewModerator #column-left').width());
                }
            });

            function resetRTC() {
                $(window).resize();
            }

            function updateRTCHeight(updateWidth, updateColumn) {
                var scrollTop = $(document).scrollTop();
                var newHeight = 3 / 4 * updateWidth - scrollTop;
                var newWidth = 4 / 3 * newHeight;
                if (newWidth > DRAGGABLE_MIN_WIDTH) {
                    $('#viewModerator #web-rtc-placeholder').css({height: newHeight + 'px', width: newWidth + 'px'});
                }

                if (scrollTop > 0) {
                    $('#viewModerator #web-rtc-placeholder').css({opacity: .7});
                } else {
                    $('#viewModerator #web-rtc-placeholder').css({opacity: 1});
                }

                if (updateColumn) {
                    TweenMax.to($('#viewModerator #column-left'), .2, {css: {marginTop: newHeight + 20}});
                }
            }

            // render data if all templates where loaded
            function onAllExternalsLoadedSuccessfully() {
                var showTutorial = parseInt(<?php echo $_SESSION['tutorialStudyPreview'] ?>);
                if (showTutorial === 1) {
                    $('#btn-introduction').click();
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

                var tween = new TweenMax($('#web-rtc-placeholder').find('#stream-controls'), .3, {opacity: 1.0, paused: true});
                $(document).find('#viewModerator #web-rtc-placeholder').on('mouseenter', function (event) {
                    event.preventDefault();
                    tween.play();
                });

                $('#viewModerator #web-rtc-placeholder').on('mouseleave', function (event) {
                    event.preventDefault();
                    tween.reverse();
                });
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
                window.location.hash = getCurrentPhase().id;
                if (currentView === VIEW_TESTER) {
                    renderPhaseStepForTester();
                } else {
                    renderPhaseStepForModerator();
                }
            }

            function resetRenderedContent() {
                $('#viewTester').find('#phase-content').empty();
                $('#viewModerator').find('#phase-content').empty();
            }

            function renderPhaseStepForModerator() {
                resetRenderedContent();
                Moderator.renderView();
                initPopover();
            }

            function renderPhaseStepForTester() {
                resetRenderedContent();
                Tester.renderView();
            }


            $(document).on('click', '#btn-toggle-rtc-fixed', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $(this).popover('hide');
                    if ($(this).hasClass('pinned')) {
                        $(this).removeClass('pinned');
                        $(this).find('.fa').removeClass('fa-window-restore').addClass('fa-window-maximize');
                        $(this).attr('data-content', translation.pinRTC).data('bs.popover').setContent();
                        dragRTC();
                    } else {
                        $(this).addClass('pinned');
                        $(this).find('.fa').removeClass('fa-window-maximize').addClass('fa-window-restore');
                        $(this).attr('data-content', translation.dragRTC).data('bs.popover').setContent();
                        pinRTC();
                    }
                }
                $(this).blur();
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