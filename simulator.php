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
        <title><?php echo $lang->gestureNoteSimulator ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- third party sources -->
        <link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/greensock/TweenMax.min.js"></script>
        <script src="js/lines/jquery.line.js"></script>

        <!-- gesturenote specific sources -->
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/gesture.css">
        <link rel="stylesheet" href="css/simulator.css">
        <link rel="stylesheet" href="css/study.css">

        <script src="js/refreshSession.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/sha512.js"></script>
        <script src="js/checkForms.js"></script>
        <script src="js/gesture.js"></script>
        <script src="js/websocket.js"></script>
        <script src="js/stomp/stomp.js"></script>
        <script src="js/simulation/simulator.js"></script>

        <script src="js/joint-selection.js"></script>

        <script src="js/upload-queue.js"></script>
        <script src="js/chance.min.js"></script>
        <script src="js/gifshot/gifshot.min.js"></script>
        <script src="js/color-thief/color-thief.js"></script> 
        <script src="js/filesaver/FileSaver.min.js"></script>
        <script src="js/jszip/jszip.min.js"></script>
        <script src="js/jszip/jszip-utils.min.js"></script>

        <!-- leap and plugins -->
        <script src="js/leapjs/leap-0.6.4.min.js"></script>
        <script src="js/leapjs/leap-plugins-0.1.12.min.js"></script>
        <script src="js/three/three.min.js"></script>
        <script src="js/riggedHand/leap.rigged-hand-0.1.7.js"></script>
        <script src="js/leapjs-playback/leap.playback-0.2.1.js"></script>

        <!--gesture recorder--> 
        <script src="js/gestureRecorder/gestureRecorder.js"></script>
        <script src="js/gestureRecorder/webcamRecorder.js"></script>
        <script src="js/gestureRecorder/leapRecorder.js"></script>
        <script src="js/resumable/resumable.js"></script>


        <!-- bootstrap slider -->
        <link rel="stylesheet" href="js/bootstrap-slider/css/bootstrap-slider.css">
        <script src="js/bootstrap-slider/js/bootstrap-slider.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-general"></div>
        <div id="template-gesture-recorder"></div>
        <div id="template-gesture"></div>
        <div id="template-simulator"></div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" data-conv-allowed="false" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog root">

                <!-- Modal content-->
                <div class="modal-content">
                </div>
            </div>
        </div>


        <div id="loading-indicator" class="window-sized-loading text-center">
            <i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw"></i>
        </div>

        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb"style="">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li class="active" data-id="btn-simulator"><i class="fa fa-sign-language" aria-hidden="true"></i> <?php echo $lang->breadcrump->simulator ?></li>
                </ol>
            </div>
        </div>

        <div class="hidden-xs hidden-sm study-edit-controls" id="fixed-quick-controls" style="position: fixed; top: 50%; transform: translateY(-50%); z-index: 100; opacity: 0; left:-201px">
            <div class="btn-group-vertical">
                <div>
                    <button type="button" class="btn btn-lg btn-default btn-shadow btn-record-simulation disabled" style="position: relative; float: right; border-radius: 0px; border-top-right-radius: 8px"><?php echo $lang->recordSimulation ?> <i class="fa fa-dot-circle-o" style="margin-left: 15px"></i></button>
                </div>
                <div>
                    <button type="button" class="btn btn-lg btn-default btn-shadow btn-stop-record-simulation hidden" style="position: relative; float: right; border-radius: 0px; border-top-right-radius: 8px"><?php echo $lang->stopRecordSimulation ?>  <i class="fa fa-stop" style="margin-left: 15px"></i></button>
                </div>
                <div>
                    <button type="button" class="btn btn-lg btn-default btn-shadow btn-pause-record-simulation hidden" style="position: relative; float: right; border-radius: 0px;"><?php echo $lang->pauseRecordSimulation ?>  <i class="fa fa-pause" style="margin-left: 15px"></i></button>
                </div>
                <div>
                    <button type="button" class="btn btn-lg btn-default btn-shadow btn-resume-record-simulation hidden" style="position: relative; float: right; border-radius: 0px;"><?php echo $lang->resumeRecordSimulation ?>  <i class="fa fa-play" style="margin-left: 15px"></i></button>
                </div>
                <div>
                    <button type="button" class="btn btn-lg btn-default btn-shadow btn-load-simulation-recording" style="position: relative; float: right; border-radius: 0px; border-bottom-right-radius: 8px"><?php echo $lang->loadSimulation ?> <i class="fa fa-folder-open" style="margin-left: 15px"></i></button>
                </div>
            </div>
        </div>




        <!-- Container (gesture set simulator content) -->
        <div class="container mainContent" id="" style="margin-top: 20px">

            <!-- Nav tabs -->
            <ul class="nav nav-pills" role="tablist" id="main-tab-pane" style="opacity:0; display: flex; justify-content: center;">
                <li role="presentation" id="btn-gestureSet"><a href="#gestureSetContent" aria-controls="gestureSetsContent" role="tab" data-toggle="tab"><i class="fa fa-sign-language"></i> <?php echo $lang->breadcrump->simulator ?></a></li>
                <li role="presentation" id="btn-player"><a href="#playerContent" aria-controls="playerContent" role="tab" data-toggle="tab"><i class="fa fa-play"></i> <?php echo $lang->simulationPlayer ?></a></li>
                <li role="presentation" id="btn-mapping"><a href="#mappingContent" aria-controls="mappingContent" role="tab" data-toggle="tab"><i class="fa fa-sign-language"></i> <?php echo $lang->mapping ?></a></li>
            </ul>


            <!-- Tab panes -->
            <div class="tab-content" style="margin-top: 20px">
                <div role="tabpanel" class="tab-pane" id="gestureSetContent">
                    <div class="" id="gesture-sets-content" style="">
                        <div class="input-group" id="gesture-sets-select">
                            <input class="form-control item-input-text option-gesture-sets show-dropdown" tabindex="-1" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                            <div class="input-group-btn select select-gesture-sets" role="group">
                                <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                            </div>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-shadow disabled" id="btn-download-as-json" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsPidocoJSON ?>"><i class="fa fa-download"></i></button>
                                <button class="btn btn-default btn-shadow disabled" id="btn-show-hide-video" data-preview-present="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showHideGestureVideo ?>"><i class="fa fa-compress"></i></button>
                            </div>
                        </div>
                        <div class="input-group">

                        </div>
                    </div>

                    <div class="mainContent" id="simulator-content" style=""></div>
                </div>

                <div role="tabpanel" class="tab-pane" id="playerContent">
                    <div class="" id="simulation-player-content">
                        <div class="row">
                            <div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">
                                <div class="btn-group btn-group-justified">
                                    <div class="btn-group">
                                        <button class="btn btn-default btn-shadow" id="btn-play-simulation" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->playSimulation ?>"><i class="fa fa-play"></i></button>
                                    </div>
                                    <div class="btn-group hidden">
                                        <button class="btn btn-default btn-shadow disabled" id="btn-pause-simulation" style="border-radius: 8px 0px 0px 8px;"  data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->pauseSimulation ?>"><i class="fa fa-pause"></i></button>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-default btn-shadow disabled" id="btn-prev-gesture" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->stepBackwardGesture ?>"><i class="fa fa-fast-backward"></i></button>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-default btn-shadow disabled" id="btn-step-backward-simulation" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->stepBackwardSimulation ?>"><i class="fa fa-step-backward"></i></button>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-default btn-shadow disabled" id="btn-step-forward-simulation" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->stepForwardSimulation ?>"><i class="fa fa-step-forward"></i></button>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-default btn-shadow disabled" id="btn-next-gesture" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->stepForwardGesture ?>"><i class="fa fa-fast-forward"></i></button>
                                    </div>
                                    <div class="btn-group select" id="update-time-select" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->chooseSimulationTimeout ?>">
                                        <button type="button" class="btn btn-default btn-shadow dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu option">
                                            <li id="standard" data-milliseconds="standard" class="selected"><a href="#">Standard</a></li>
                                            <li id="seconds1" data-milliseconds="1000"><a href="#"><?php echo $lang->seconds1 ?></a></li>
                                            <li id="seconds1-5" data-milliseconds="1500"><a href="#"><?php echo $lang->seconds15 ?></a></li>
                                            <li id="seconds2" data-milliseconds="2000"><a href="#"><?php echo $lang->seconds2 ?></a></li>
                                            <li id="seconds2-5" data-milliseconds="2500"><a href="#"><?php echo $lang->seconds25 ?></a></li>
                                            <li id="seconds3" data-milliseconds="3000"><a href="#"><?php echo $lang->seconds3 ?></a></li>
                                            <li id="seconds3-5" data-milliseconds="3500"><a href="#"><?php echo $lang->seconds35 ?></a></li>
                                            <li id="seconds4" data-milliseconds="4000"><a href="#"><?php echo $lang->seconds4 ?></a></li>
                                            <li id="seconds4-5" data-milliseconds="4500"><a href="#"><?php echo $lang->seconds45 ?></a></li>
                                            <li id="seconds5" data-milliseconds="5000"><a href="#"><?php echo $lang->seconds5 ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
                                <div id="playback-slider-container" class="" style="margin-top: -10px">
                                    <input id="playback-slider" style="width: 100%; height: 34px;" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="50" data-slider-tooltip="hide" />
                                </div>
                                <div id="seek-bar-meta-info-container" style="position: absolute; left: 15px; right: 15px; top:34px"></div>
                            </div>
                        </div>

                        <div id="simulation-thumbnail-container" class="row" style="margin-top: 40px"></div>
                        <div class="row" style="height: 60px">
                            <div class="col-xs-12 text-center" id="current-time-code">
                                <span class="time-code-current-time">00:00:00</span>
                                <span> / </span>
                                <span class="time-code-duration">00:00:00</span>
                            </div>
                            <div class="col-xs-12" style="">
                                <div class="corner-background"></div>
                                <div class="corner-left"></div>
                                <div class="corner-center"></div>
                                <div class="corner-right"></div>
                            </div>

                        </div>
                        <div id="simulation-thumbnail-info-panel" style="margin-top: 35px"></div>

                    </div>

                </div>

                <div role="tabpanel" class="tab-pane" id="mappingContent">

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
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                    externals.push(['#template-gesture', PATH_EXTERNALS + 'template-gesture.php']);
                    externals.push(['#template-gesture-recorder', PATH_EXTERNALS + 'template-gesture-recorder.php']);
                    externals.push(['#template-simulator', PATH_EXTERNALS + 'template-simulator.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
                animateBreadcrump();
                checkDarkMode(parseInt('<?php echo checkDarkMode(); ?>'));

                var fixedControlsTween = new TimelineMax({paused: true});
                fixedControlsTween.add("parallel", .3)
                        .to($('#fixed-quick-controls'), .2, {opacity: 1, ease: Quad.easeInOut}, 'parallel')
                        .from($('#fixed-quick-controls'), .2, {x: -20, ease: Quad.easeInOut}, 'parallel');

                getGestureCatalog(function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        getGestureSets(function (result) {
                            if (result.status === RESULT_SUCCESS) {
                                setLocalItem(GESTURE_SETS, result.gestureSets);
                                renderAssembledGestureSets(result.gestureSets, $('#gesture-sets-select'));
                            }

                            var query = getQueryParams(document.location.search);
                            if (query.gestureSetId) {
                                console.log('temp save recorded simulation');

                                var gestureSetId = parseInt(query.gestureSetId);
                                var recordedSimulation = getLocalItem(RECORDED_SIMULATION);
                                $('#gesture-sets-select').find('#' + gestureSetId).click();
                                if (recordedSimulation) {
                                    setLocalItem(RECORDED_SIMULATION, recordedSimulation);
                                }
                            }

                            if (query.recordingId) {
                                getSimulationRecording({recordingId: query.recordingId}, function (result) {
                                    if (result.status === RESULT_SUCCESS) {
                                        setLocalItem(RECORDED_SIMULATION, {id: result.id, gestureSetId: result.gestureSetId, title: result.title, track: result.data.track, created: result.created});
                                        $('#main-tab-pane').find('#btn-player').removeClass('disabled');
                                        renderRecordedGestureSetSimulation();
                                    }
                                });
                            }

                            if (query.state) {
                                currentSimulationState = query.state;
                                switch (currentSimulationState) {
                                    case STATE_SIMULATOR_RECORD:
                                        $(recordSimulationButton).click();
                                        break;
                                    case STATE_SIMULATOR_PAUSE_RECORDING:
                                        $(recordSimulationButton).click();
                                        $(pauseRecordSimulationButton).click();
                                        break;
                                    case STATE_SIMULATOR_STOP_RECORDING:
                                        saveSimulationRecording();
                                        break;
                                }
                            }

                            showPageContent();
                            initWebSocket();
                            fixedControlsTween.play();
                        });
                    }
                });
            }

            function showPageContent() {
                $('.mainContent').removeClass('hidden');
                TweenMax.to($('#loading-indicator'), .4, {opacity: 0, onComplete: function () {
                        $('#loading-indicator').remove();
                    }});
                TweenMax.from($('.mainContent'), .3, {delay: .3, opacity: 0});

                TweenMax.to($('#main-tab-pane'), .4, {opacity: 1});

                $('#main-tab-pane a').on('click', function (event) {
                    event.preventDefault();
                    if ($(event.target).parent().hasClass('disabled')) {
                        event.stopImmediatePropagation();
                    }
                });

                $('#main-tab-pane a[data-toggle="tab"]').on('show.bs.tab', function (event) {
                    $('#simulator-content, #simulation-thumbnail-container').empty();
                    $(recordSimulationButton).addClass('disabled');

                    switch ($(event.target).attr('href')) {
                        case '#gestureSetContent':
                            setParam(window.location.href, 'tab', 'gestureSet');
                            $(recordSimulationButton).removeClass('disabled');
                            renderGestureSetContent();
                            break;
                        case '#playerContent':
                            setParam(window.location.href, 'tab', 'player');
                            renderRecordedGestureSetSimulation();
                            break;
                        case '#mappingContent':
                            setParam(window.location.href, 'tab', 'mapping');
                            break;
                    }
                });

                var query = getQueryParams(document.location.search);
                if (query.tab) {
                    var recordedSimulation = getLocalItem(RECORDED_SIMULATION);
                    if (query.tab === 'player' && recordedSimulation) {
                        setLocalItem(RECORDED_SIMULATION, recordedSimulation);
                        $('#btn-player').removeClass('disabled');
                        $('#main-tab-pane').find('#btn-' + query.tab + ' a').click();
                    } else {
                        $('#main-tab-pane').find('#btn-gestureSet a').click();
                    }
                } else {
                    $('#main-tab-pane').find('#btn-gestureSet a').click();
                }
            }

            $('#gesture-sets-select').unbind('change').bind('change', function (event) {
                event.preventDefault();
                removeLocalItem(SIMULATION_RECORDING);
                removeLocalItem(RECORDED_SIMULATION);
                $('#btn-player').addClass('disabled');
                setParam(window.location.href, 'gestureSetId', $(event.target).attr('id'));
                renderGestureSetContent();
            });


            $('#custom-modal').unbind('gestureUpdated').bind('gestureUpdated', function (event, gesture) {
                event.preventDefault();
                var isInSimulationMode = $('#gestureSetContent').hasClass('active');
                updateGestureSimluationThumbnail(gesture.id, $('#pageBody').find('#simulator-content'), isInSimulationMode);
            });


            // fixed buttons tweening

            var recordSimulationButton = $('#fixed-quick-controls .btn-record-simulation');
            var recordSimulationButtonTimeline = new TimelineMax({paused: true, onStart: function () {
                    $(recordSimulationButton).css({borderBottomRightRadius: '8px'});
                    $(recordSimulationButton).addClass('btn-primary');
                }, onReverseComplete: function () {
                    $(recordSimulationButton).css({borderBottomRightRadius: '0px'});
                    $(recordSimulationButton).removeClass('btn-primary');
                }});

            recordSimulationButtonTimeline.add("recordSimulation", 0)
                    .to(recordSimulationButton, .3, {left: +200, ease: Quad.easeInOut}, "recordSimulation");

            $(recordSimulationButton).unbind('mouseenter').bind('mouseenter', function (event) {
                event.preventDefault();
                recordSimulationButtonTimeline.play();
            });

            $(recordSimulationButton).unbind('mouseleave').bind('mouseleave', function (event) {
                event.preventDefault();
                recordSimulationButtonTimeline.reverse();
            });

            $(recordSimulationButton).unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('hidden') && !$(this).hasClass('disabled')) {
                    $(this).addClass('hidden');
                    $('#fixed-quick-controls').css({left: '-208px'});
                    $(stopRecordSimulationButton).removeClass('hidden');
                    $(pauseRecordSimulationButton).removeClass('hidden');
                    currentSimulationState = STATE_SIMULATOR_RECORD;
                    setParam(window.location.href, 'state', currentSimulationState);
                }
            });




            var stopRecordSimulationButton = $('#fixed-quick-controls .btn-stop-record-simulation');
            var stopRecordSimulationButtonTimeline = new TimelineMax({paused: true, onStart: function () {
                    $(stopRecordSimulationButton).css({borderBottomRightRadius: '8px'});
                    $(stopRecordSimulationButton).addClass('btn-primary');
                }, onReverseComplete: function () {
                    $(stopRecordSimulationButton).css({borderBottomRightRadius: '0px'});
                    $(stopRecordSimulationButton).removeClass('btn-primary');
                }});

            stopRecordSimulationButtonTimeline.add("stopRecordSimulation", 0)
                    .to(stopRecordSimulationButton, .3, {left: +192, ease: Quad.easeInOut}, "stopRecordSimulation");

            $(stopRecordSimulationButton).unbind('mouseenter').bind('mouseenter', function (event) {
                event.preventDefault();
                stopRecordSimulationButtonTimeline.play();
            });

            $(stopRecordSimulationButton).unbind('mouseleave').bind('mouseleave', function (event) {
                event.preventDefault();
                stopRecordSimulationButtonTimeline.reverse();
            });

            $(stopRecordSimulationButton).unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('hidden')) {
                    $(this).addClass('hidden');
                    $('#fixed-quick-controls').css({left: '-201px'});
                    $(recordSimulationButton).removeClass('hidden');
                    $(pauseRecordSimulationButton).addClass('hidden');
                    $(resumeRecordSimulationButton).addClass('hidden');
                    currentSimulationState = STATE_SIMULATOR_STOP_RECORDING;
                    setParam(window.location.href, 'state', currentSimulationState);
                    saveSimulationRecording();
                }
            });




            var pauseRecordSimulationButton = $('#fixed-quick-controls .btn-pause-record-simulation');
            var pauseRecordSimulationButtonTimeline = new TimelineMax({paused: true, onStart: function () {
                    $(pauseRecordSimulationButton).css({borderBottomRightRadius: '8px', borderTopRightRadius: '8px'});
                    $(pauseRecordSimulationButton).addClass('btn-primary');
                }, onReverseComplete: function () {
                    $(pauseRecordSimulationButton).css({borderBottomRightRadius: '0px', borderTopRightRadius: '0px'});
                    $(pauseRecordSimulationButton).removeClass('btn-primary');
                }});

            pauseRecordSimulationButtonTimeline.add("pauseRecordSimulation", 0)
                    .to(pauseRecordSimulationButton, .3, {left: +207, ease: Quad.easeInOut}, "pauseRecordSimulation");

            $(pauseRecordSimulationButton).unbind('mouseenter').bind('mouseenter', function (event) {
                event.preventDefault();
                pauseRecordSimulationButtonTimeline.play();
            });

            $(pauseRecordSimulationButton).unbind('mouseleave').bind('mouseleave', function (event) {
                event.preventDefault();
                pauseRecordSimulationButtonTimeline.reverse();
            });

            $(pauseRecordSimulationButton).unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('hidden')) {
                    $(this).addClass('hidden');
                    $('#fixed-quick-controls').css({left: '-211px'});
                    $(resumeRecordSimulationButton).removeClass('hidden');
                    currentSimulationState = STATE_SIMULATOR_PAUSE_RECORDING;
                    setParam(window.location.href, 'state', currentSimulationState);
                }
            });




            var resumeRecordSimulationButton = $('#fixed-quick-controls .btn-resume-record-simulation');
            var resumeRecordSimulationButtonTimeline = new TimelineMax({paused: true, onStart: function () {
                    $(resumeRecordSimulationButton).css({borderBottomRightRadius: '8px', borderTopRightRadius: '8px'});
                    $(resumeRecordSimulationButton).addClass('btn-primary');
                }, onReverseComplete: function () {
                    $(resumeRecordSimulationButton).css({borderBottomRightRadius: '0px', borderTopRightRadius: '0px'});
                    $(resumeRecordSimulationButton).removeClass('btn-primary');
                }});

            resumeRecordSimulationButtonTimeline.add("resumeRecordSimulation", 0)
                    .to(resumeRecordSimulationButton, .3, {left: +207, ease: Quad.easeInOut}, "resumeRecordSimulation");

            $(resumeRecordSimulationButton).unbind('mouseenter').bind('mouseenter', function (event) {
                event.preventDefault();
                resumeRecordSimulationButtonTimeline.play();
            });

            $(resumeRecordSimulationButton).unbind('mouseleave').bind('mouseleave', function (event) {
                event.preventDefault();
                resumeRecordSimulationButtonTimeline.reverse();
            });

            $(resumeRecordSimulationButton).unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('hidden')) {
                    $(this).addClass('hidden');
                    $('#fixed-quick-controls').css({left: '-208px'});
                    $(pauseRecordSimulationButton).removeClass('hidden');
                    currentSimulationState = STATE_SIMULATOR_RECORD;
                    setParam(window.location.href, 'state', currentSimulationState);
                }
            });



            var loadSimulationButton = $('#fixed-quick-controls .btn-load-simulation-recording');
            var loadSimulationButtonTimeline = new TimelineMax({paused: true, onStart: function () {
                    $(loadSimulationButton).css({borderTopRightRadius: '8px'});
                    $(loadSimulationButton).addClass('btn-primary');
                }, onReverseComplete: function () {
                    $(loadSimulationButton).css({borderTopRightRadius: '0px'});
                    $(loadSimulationButton).removeClass('btn-primary');
                }});

            loadSimulationButtonTimeline.add("loadSimulation", 0)
                    .to(loadSimulationButton, .3, {left: +176, ease: Quad.easeInOut}, "loadSimulation");

            $(loadSimulationButton).unbind('mouseenter').bind('mouseenter', function (event) {
                event.preventDefault();
                loadSimulationButtonTimeline.play();
            });

            $(loadSimulationButton).unbind('mouseleave').bind('mouseleave', function (event) {
                event.preventDefault();
                loadSimulationButtonTimeline.reverse();
            });

            $(loadSimulationButton).unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    loadHTMLintoModal('custom-modal', 'externals/modal-load-simulation-recording.php');
                    $('#custom-modal').unbind('loadGestureSetSimulation').bind('loadGestureSetSimulation', function (event) {
                        event.preventDefault();

                        var recordedSimulation = getLocalItem(RECORDED_SIMULATION);
                        $('#gestureSetContent').find('#gesture-sets-select #' + recordedSimulation.gestureSetId).click();
                        setLocalItem(RECORDED_SIMULATION, recordedSimulation);
                        $('#main-tab-pane').find('#btn-player').removeClass('disabled');

                        if ($('#main-tab-pane').find('#btn-player').hasClass('active')) {
                            renderRecordedGestureSetSimulation();
                        } else {
                            $('#main-tab-pane').find('#btn-player a').click();
                        }
                    });
                }
            });
        </script>

    </body>
</html>