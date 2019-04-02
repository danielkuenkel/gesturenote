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
        <link href="js/vis/vis.min.css" rel="stylesheet">
        <script src="js/vis/vis.min.js"></script>
        <script src="js/color-thief/color-thief.js"></script> 
        <script src="js/randomColor/randomColor.js"></script>

        <!-- gesturenote specific sources -->
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/study.css">
        <link rel="stylesheet" href="css/gesture.css">

        <script src="js/chance.min.js"></script>
        <script src="js/refreshSession.js"></script>
        <script src="js/sha512.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/gesture.js"></script>
        <script src="js/joint-selection.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/forms.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/rtc-result-player.js"></script>
        <!--<script src="js/study-execution.js"></script>-->
        <script src="js/upload-queue.js"></script>

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
        <script src="js/gifshot/gifshot.min.js"></script>

        <!-- peer connection with webrtc -->
        <script src="js/collaborativeVideo.js"></script>
        <script src="js/peerConnection.js"></script>
        <script src="js/andyet/simplewebrtc.bundle.js"></script>

        <!-- bootstrap slider -->
        <link rel="stylesheet" href="js/bootstrap-slider/css/bootstrap-slider.css">
        <script src="js/bootstrap-slider/js/bootstrap-slider.js"></script>

    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-gesture"></div>
        <div id="template-general"></div>
        <div id="template-subpages"></div>
        <div id="template-study"></div>
        <div id="template-previews"></div>
        <div id="template-gesture-recorder"></div>


        <div class="hidden-xs hidden-sm study-participant-controls" id="fixed-study-participant-controls" style="position: fixed; top: 50%; transform: translateY(-50%); z-index: 10001; opacity: 0; left:-204px">
            <div class="btn-group-vertical">
                <div>
                    <button type="button" class="btn btn-lg btn-default btn-shadow btn-join-conversation" style="position: relative;  float: right; border-radius: 0px; border-bottom-right-radius: 8px; border-top-right-radius: 8px"><?php echo $lang->joinConversation ?> <i class="fa fa-group" style="margin-left: 15px"></i></button>
                </div>
                <div>
                    <button type="button" class="btn btn-lg btn-default btn-shadow btn-leave-conversation hidden" style="position: relative;  float: right; border-radius: 0px; border-bottom-right-radius: 8px; border-top-right-radius: 8px"><?php echo $lang->leaveConversation ?> 
                        <span style="margin-left: 15px">
                            <i class="fa fa-group"></i>
                            <i class="fa fa-ban" style="
                               font-size: 9pt;
                               position: absolute;
                               right: 9px;
                               top: 9px;"></i>
                        </span></button>
                </div>
            </div>
        </div>


        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb" style="">
            <div class="row">
                <ol class="breadcrumb">
                    <!--<li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>-->
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-studies"><i class="fa fa-tasks" aria-hidden="true"></i> <?php echo $lang->breadcrump->studies ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-study"><i class="fa fa-clipboard"></i> <?php echo $lang->breadcrump->study ?></a></li>
                    <li class="active"><i class="fa fa-user-circle-o"></i> <?php echo $lang->breadcrump->studyParticipant ?></li>
                </ol>
            </div>
        </div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" role="dialog" data-conv-allowed="false">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content root">
                </div>
            </div>
        </div>


        <!-- main content -->
        <div class="container mainContent" style="margin-top: 0px; padding-bottom: 0px" id="general-view">
            <div>
                <h2 id="main-headline" style="margin-top: 0; display: inline"></h2>
                <a role="button" class="pull-right" id="btn-introduction" style=" clear: both;"><i class="fa fa-support"></i> <?php echo $lang->help ?></a>
            </div>

            <hr>

            <!--        <nav>
                        <ul class="pager"style="margin-bottom: 2px">
                            <li class="btn-sm btn-prev-participant disabled pull-left" style="padding: 0"><a href="#"><span aria-hidden="true">&larr;</span> <?php echo $lang->previousParticipant ?></a></li>
                            <li class="btn-sm btn-next-participant disabled pull-right" style="padding: 0"><a href="#"><?php echo $lang->nextParticipant ?> <span aria-hidden="true">&rarr;</span></a></li>
                        </ul>
                    </nav>-->

        </div>

        <div class="container" id="phase-results" style="margin-bottom: 0px;">
            <div class="row">
                <div class="col-md-3" style="margin-bottom: 30px;">
                    <div id="phase-results-navigation-bar">
                        <div class="" style="">
                            <div class="text" id="execution-date"></div>
                            <span class="label label-success hidden" id="execution-success"><i class="fa fa-check"></i> <span class="label-text"></span></span>
                            <span class="label label-danger hidden" id="execution-fault"><i class="fa fa-bolt"></i> <span class="label-text"></span></span>
                            <span class="label label-default hidden" id="execution-duration"><i class="fa fa-clock-o"></i> <span class="label-text"></span></span>
                        </div>

                        <!--                    <div class="form-group form-group-margin-top root pretest-select" style="opacity:0">
                                                <label style="margin: 0"><?php echo $lang->isPretest ?></label><br>
                        
                                                <div class="btn-group" id="radio" style="margin: 0">
                                                    <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="real">
                                                        <span id="icons" style="margin-right: 6px">
                                                            <i class="fa fa-circle-thin hidden" id="normal"></i>
                                                            <i class="fa fa-circle hidden" id="over"></i>
                                                            <i class="fa fa-check-circle" id="checked"></i>
                                                        </span>
                                                        <span class="option-text"><?php echo $lang->no ?></span>
                                                    </button>
                                                </div>
                                                <div class="btn-group" id="radio" style="margin: 0">
                                                    <button class="btn btn-default btn-radio" name="primary" id="pretest">
                                                        <span id="icons" style="margin-right: 6px">
                                                            <i class="fa fa-circle-thin" id="normal"></i>
                                                            <i class="fa fa-circle hidden" id="over"></i>
                                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                                        </span>
                                                        <span class="option-text"><?php echo $lang->yes ?></span>
                                                    </button>
                                                </div>
                        
                                            </div>-->

                    <!--<img id="participant-image" class="hidden" style="width:100%; max-width: 300px; border-radius: 8px; margin-top: 10px" />-->

                        <div class="btn-group-vertical btn-block hidden-lg hidden-md" id="phase-results-control-nav" style="margin-top: 20px">
    <!--                        <button class="btn btn-default btn-shadow btn-prev-participant disabled" type="button"><i class="fa fa-arrow-left"></i> <span class="btn-text"><?php echo $lang->previousParticipant ?></span></button>
                            <button class="btn btn-default btn-shadow btn-next-participant disabled" type="button"><i class="fa fa-arrow-right"></i> <span class="btn-text"><?php echo $lang->nextParticipant ?></span></button>-->
                            <button class="btn btn-default btn-shadow btn-join-conversation" type="button"><i class="fa fa-group"></i> <span class="btn-text"><?php echo $lang->joinConversation ?></span></button>
                            <button class="btn btn-default btn-shadow btn-leave-conversation hidden" type="button"><i class="fa fa-group"></i><i class="fa fa-ban" style="font-size: 9pt; position: relative; right: 3px; top: -6px;"></i> <span class="btn-text"><?php echo $lang->leaveConversation ?></span></button>
                        </div>
                        <div class="btn-group-vertical btn-block" id="phase-results-nav" style=""></div>
                        <!--                    <div class="btn-group-vertical btn-block" id="delete-results-nav" style="margin-top: 20px">
                                                <button class="btn btn-danger btn-shadow btn-delete-result hidden-lg hidden-md" id="btn-delete-result" style="opacity: 0"><i class="fa fa-trash"></i> <?php echo $lang->deleteParticipantResult ?></button>
                                            </div>-->
                    </div>
                </div>
                <div class="col-md-9">
                    <div id="phase-result"></div>
                </div>
            </div>
        </div>

        <!--    <div class="container mainContent" id="pager-bottom" style="margin-top: 0px; padding-bottom: 0px">
                <nav>
                    <ul class="pager"style="margin-bottom: 2px">
                        <li class="btn-sm btn-prev-participant disabled pull-left" style="padding: 0"><a href="#"><span aria-hidden="true">&larr;</span> <?php echo $lang->previousParticipant ?></a></li>
                        <li class="btn-sm btn-next-participant disabled pull-right" style="padding: 0"><a href="#"><?php echo $lang->nextParticipant ?> <span aria-hidden="true">&rarr;</span></a></li>
                    </ul>
                </nav>
            </div>-->

        <div id="ueq-arrows-container" style="position: absolute; top:0px; left:0px"></div>






        <div id="draggableCollaborativeRTC" class="hidden" style="position: fixed; z-index: 10002; top: 150px; left:100px; display: block; opacity: .7">
            <div style="width: 300px; border-radius: 8px" id="video-caller-container" class="shadow">
                <div class="embed-responsive embed-responsive-4by3" id="video-caller">

                    <div class="embed-responsive-item" style="border-radius: 8px; background-color: #eee; display: flex; justify-content: center; align-items: center;">
                        <i class="fa fa-circle-o-notch fa-spin fa-3x"></i>
                    </div>

                    <div id="remoteVideo" class="rtc-remote-container rtc-stream embed-responsive-item" style="border-radius: 8px;"></div>

                    <div class="rtc-local-container embed-responsive-item">
                        <video autoplay id="localVideo" class="rtc-stream" style="position: relative; height: auto"></video>
                    </div>

                    <div class="btn-group" id="stream-controls" style="position: absolute; bottom: 6px; left: 50%; transform: translate(-50%, 0); opacity: 0">
                        <button type="button" class="btn btn-sm stream-control" id="btn-stream-local-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->muteMicrofone ?>"><i class="fa fa-microphone-slash"></i> </button>
                        <button type="button" class="btn btn-sm stream-control" id="btn-pause-stream" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOwnWebRTC ?>"><i class="fa fa-pause"></i> </button>
                        <button type="button" class="btn btn-sm stream-control disabled" id="btn-stream-remote-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOtherWebRTC ?>"><i class="fa fa-volume-up"></i> </button>
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

            <img src="img/resize-white.png" id="resize-sign" style="position: absolute; bottom: 0; right: 0;"/>
            <div id="btn-leave-room" class="" style="font-size: 14pt; position: absolute; top: -5px; right: 4px; cursor: pointer; color: white; text-shadow: 0px 0px 3px rgba(0, 0, 0, 1.0);"><i class="fa fa-close"></i></div>

        </div>


        <script>
            var resultsPlayer = null;

            $(document).ready(function () {
                checkDomain();
                keepSessionAlive();
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-gesture', PATH_EXTERNALS + 'template-gesture.php']);
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                    externals.push(['#template-study', PATH_EXTERNALS + 'template-study.php']);
                    externals.push(['#template-previews', PATH_EXTERNALS + 'template-previews.php']);
                    externals.push(['#template-gesture-recorder', PATH_EXTERNALS + 'template-gesture-recorder.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
                checkDarkMode(parseInt('<?php echo checkDarkMode(); ?>'));

                var query = getQueryParams(document.location.search);
                var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');

                var showTutorial = parseInt(<?php echo $_SESSION['tutorialParticipant'] ?>);
                if (showTutorial === 1) {
                    $('#btn-introduction').click();
                }

                if (query.studyId && query.h === hash) {
                    $('.breadcrumb #btn-study').on('click', function (event) {
                        event.preventDefault();
                        goto('study.php?studyId=' + query.studyId + '&h=' + hash + '&joinedConv=' + joinedRoom + getWebRTCSources() + '#participants');
                    });

                    $('body').find('.main-burger-menu .btn-study').removeClass('hidden');
                    $('body').find('.main-burger-menu .btn-study').unbind('click').bind('click', function (event) {
                        event.preventDefault();
                        goto('study.php?studyId=' + query.studyId + '&h=' + hash + '&joinedConv=' + joinedRoom + getWebRTCSources() + '#participants');
                    });

                    getAllStudyParticipants({studyId: query.studyId}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            console.log(result);
                            setStudyData(result);
                            setLocalItem(GESTURE_CATALOG, result.gestureCatalog);
                            renderData();
                        }
                    });
                }

                animateBreadcrump();
            }

            function renderData() {
                var studyData = getLocalItem(STUDY);
                var phaseSteps = getLocalItem(STUDY_PHASE_STEPS);

                // general data view
                $('#main-headline').text(studyData.title);

                // phase nav view
                TweenMax.to($('.pretest-select'), .3, {opacity: 1, clearProps: 'all'});
                if (phaseSteps && phaseSteps.length > 0) {
                    for (var i = 0; i < phaseSteps.length; i++) {
                        if (phaseSteps[i].format !== THANKS && phaseSteps[i].format !== LETTER_OF_ACCEPTANCE) {
                            var navItem = document.createElement('button');
                            $(navItem).attr('role', 'presentation');
                            $(navItem).addClass('btn btn-default');
                            $(navItem).attr('id', phaseSteps[i].id);
                            $('#phase-results-nav').append(navItem);

                            var text = document.createElement('span');
                            $(text).text(phaseSteps[i].title);
                            $(navItem).append(text);

                            TweenMax.from($(navItem), .3, {delay: 0.2 + (i * .05), y: -10, opacity: 0, clearProps: 'all'});
                        }
                    }

                    var status = window.location.hash.substr(1);
                    var statusAddressMatch = statusAddressMatchIndex(status);
                    if (status !== '' && statusAddressMatch !== null) {
                        $('#phase-results-nav').find('#' + statusAddressMatch.id).click();
                    } else {
                        $('#phase-results-nav').children().first().click();
                    }

                    var navigationBarContent = $('#phase-results-navigation-bar');
                    $(window).on('resize', function (event) {
                        event.preventDefault();

                        var windowWidth = $(window).width();
                        var row = $(navigationBarContent).parent();
                        var rowWidth = $(row).width();
                        if (windowWidth < 992) {
                            $(navigationBarContent).removeClass('affix');
                            $(navigationBarContent).css({width: '', top: ''});
                        } else {
                            //                            $(navigationBarContent).addClass('affix');
                            $(navigationBarContent).css({width: rowWidth + 'px'});
                        }
                    }).resize();

                    $(window).on('scroll', function (event) {
                        event.preventDefault();
                        var windowWidth = $(window).width();
                        var resultHeight = $('#phase-result').height();
                        var barHeight = navigationBarContent.height();

                        if (windowWidth >= 992 && barHeight < resultHeight) {
                            var visibleHeight = $(window).height();
                            var scrollTop = $(window).scrollTop();

                            var scrollOffset = 0;
                            if (barHeight > visibleHeight) {
                                var scrollOffset = barHeight - visibleHeight + 30;
                            }

                            if (scrollTop >= 190 + scrollOffset) {
                                var top = 46 - scrollOffset - 35;
                                $(navigationBarContent).addClass('affix');
                                $(navigationBarContent).css({top: top + 'px'});
                            } else {
                                $(navigationBarContent).removeClass('affix');
                                $(navigationBarContent).css({top: ''});
                            }
                        } else {
                            $(navigationBarContent).removeClass('affix');
                            $(navigationBarContent).css({top: ''});
                        }
                    });
                }



                var joinConversationButton = $('#fixed-study-participant-controls .btn-join-conversation');
                var conversationButtonTimeline = new TimelineMax({paused: true, onStart: function () {
                        $(joinConversationButton).css({borderBottomRightRadius: '8px', borderTopRightRadius: '8px'});
                        $(joinConversationButton).addClass('btn-primary');
                    }, onReverseComplete: function () {
                        $(joinConversationButton).removeClass('btn-primary');
                    }});

                conversationButtonTimeline.add("saveStudy", 0)
                        .to(joinConversationButton, .3, {left: +202, ease: Quad.easeInOut}, "saveStudy");

                $(joinConversationButton).unbind('mouseenter').bind('mouseenter', function (event) {
                    event.preventDefault();
                    conversationButtonTimeline.play();
                });

                $(joinConversationButton).unbind('mouseleave').bind('mouseleave', function (event) {
                    event.preventDefault();
                    conversationButtonTimeline.reverse();
                });


                var leaveConversationButton = $('#fixed-study-participant-controls .btn-leave-conversation');
                var leaveConversationButtonTimeline = new TimelineMax({paused: true, onStart: function () {
                        $(leaveConversationButton).css({borderBottomRightRadius: '8px', borderTopRightRadius: '8px'});
                        $(leaveConversationButton).addClass('btn-danger');
                    }, onReverseComplete: function () {
                        $(leaveConversationButton).removeClass('btn-danger');
                    }});

                leaveConversationButtonTimeline.add("saveStudy", 0)
                        .to(leaveConversationButton, .3, {left: +203, ease: Quad.easeInOut}, "saveStudy");

                $(leaveConversationButton).unbind('mouseenter').bind('mouseenter', function (event) {
                    event.preventDefault();
                    leaveConversationButtonTimeline.play();
                });

                $(leaveConversationButton).unbind('mouseleave').bind('mouseleave', function (event) {
                    event.preventDefault();
                    leaveConversationButtonTimeline.reverse();
                });


                $('.btn-join-conversation').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    var query = getQueryParams(document.location.search);
                    initCollaborativeVideoCaller('study' + query.studyId);
                });

                $('.btn-leave-conversation').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    leaveCollaborativeVideoCaller();
                });

                TweenMax.to($('#fixed-study-participant-controls'), .3, {opacity: 1});
                TweenMax.from($('#fixed-study-participant-controls'), .3, {x: -20, ease: Quad.easeInOut});
                checkCollaborativeConversation();
            }

            $(document).on('click', '#phase-results-nav button', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('active')) {
                    //                cacheNotes(true);
                    $(this).parent().children().removeClass('active');
                    $(this).addClass('active');
                    var selectedId = $(this).attr('id');
                    $("html, body").animate({scrollTop: 0}, 100);
                    window.location.hash = selectedId;
                    renderStudyPhaseResult(selectedId);
                }
            });

            function getResultsForPhaseId(phaseStepId) {
                var allResults = getLocalItem('allStudyResults');
                var selectedResults = [];
                if (allResults && allResults.length > 0) {
                    for (var i = 0; i < allResults.length; i++) {
                        var tempTesterResults = null;
                        var tempEvaluatorResults = {results: null, notes: null, observations: null};
                        var tempObserverResults = null;
                        var tempWizardResults = null;

                        // searching tester result for phase step id
                        if (allResults[i].testerResultData && allResults[i].testerResultData.phases && allResults[i].testerResultData.phases.length > 0) {
                            for (var j = 0; j < allResults[i].testerResultData.phases.length; j++) {
                                if (parseInt(allResults[i].testerResultData.phases[j].id) === parseInt(phaseStepId)) {
                                    tempTesterResults = allResults[i].testerResultData.phases[j];
                                    tempTesterResults.snapshot = allResults[i].testerResultData.snapshot;
                                    break;
                                }
                            }
                        }

                        // searching evaluator result for phase step id
                        if (allResults[i].evaluatorResultData && allResults[i].evaluatorResultData.phases && allResults[i].evaluatorResultData.phases.length > 0) {
                            for (var j = 0; j < allResults[i].evaluatorResultData.phases.length; j++) {
                                if (parseInt(allResults[i].evaluatorResultData.phases[j].id) === parseInt(phaseStepId)) {
                                    tempEvaluatorResults.results = allResults[i].evaluatorResultData.phases[j];
                                    tempEvaluatorResults.notes = allResults[i].evaluatorResultData.notes;
                                    tempEvaluatorResults.observations = allResults[i].evaluatorResultData.observations;
                                    break;
                                }
                            }
                        }

                        if (allResults[i].evaluatorResultData && allResults[i].evaluatorResultData.notes && allResults[i].evaluatorResultData.notes.length > 0) {
                            for (var j = 0; j < allResults[i].evaluatorResultData.notes.length; j++) {
                                if (parseInt(allResults[i].evaluatorResultData.notes[j].phaseId) === parseInt(phaseStepId)) {
                                    tempEvaluatorResults.notes = allResults[i].evaluatorResultData.notes[j];
                                    break;
                                }
                            }
                        }

                        if (allResults[i].evaluatorResultData && allResults[i].evaluatorResultData.observations && allResults[i].evaluatorResultData.observations.length > 0) {
                            for (var j = 0; j < allResults[i].evaluatorResultData.observations.length; j++) {
                                if (parseInt(allResults[i].evaluatorResultData.observations[j].phaseId) === parseInt(phaseStepId)) {
                                    tempEvaluatorResults.observations = allResults[i].evaluatorResultData.observations[j];
                                    break;
                                }
                            }
                        }

                        // searching observer result for phase step id
                        if (allResults[i].observerResultData && allResults[i].observerResultData.phases && allResults[i].observerResultData.phases.length > 0) {
                            for (var j = 0; j < allResults[i].observerResultData.phases.length; j++) {
                                if (parseInt(allResults[i].observerResultData.phases[j].id) === parseInt(phaseStepId)) {
                                    tempObserverResults = allResults[i].observerResultData.phases[j];
                                    break;
                                }
                            }
                        }

                        // searching wizard result for phase step id
                        if (allResults[i].wizardResultData && allResults[i].wizardResultData.phases && allResults[i].wizardResultData.phases.length > 0) {
                            for (var j = 0; j < allResults[i].wizardResultData.phases.length; j++) {
                                if (parseInt(allResults[i].wizardResultData.phases[j].id) === parseInt(phaseStepId)) {
                                    tempWizardResults = allResults[i].wizardResultData.phases[j];
                                    break;
                                }
                            }
                        }

                        selectedResults.push({
                            id: allResults[i].id,
                            userId: allResults[i].userId,
                            created: allResults[i].created,
                            tester: tempTesterResults,
                            evaluator: tempEvaluatorResults,
                            observer: tempObserverResults,
                            wizard: tempWizardResults});
                    }
                }

                return selectedResults;
            }

            function renderStudyPhaseResult(phaseId) {
                var study = getLocalItem(STUDY);
                var phaseData = getLocalItem(phaseId + '.data');
                var phaseStep = getPhaseById(phaseId);
                var results = getResultsForPhaseId(phaseId);

                console.log('STUDY DATA: ', study);
                console.log('PHASE STEP DATA: ', phaseStep);
                console.log('PHASE DATA: ', phaseData);
                console.log('RESULTS DATA: ', results);



                if (results !== null && results.length > 0) {
                    var content = $('#template-study-all-container').find('#' + phaseStep.format).clone().removeAttr('id');
                    $(content).find('#headline').text(translation.formats[phaseStep.format].text);
                    $('#phase-result').empty().append(content);

                    switchDataRendering();

                    $(content).css({y: 0, opacity: 1});
                    TweenMax.from(content, .2, {opacity: 0, y: -60});

                    function switchDataRendering() {
                        switch (phaseStep.format) {
                            case LETTER_OF_ACCEPTANCE:
                                renderLetterOfAcceptance(content, phaseData, results);
                                break;
                            case THANKS:
                                renderThanks(content, phaseData);
                                break;
                            case QUESTIONNAIRE:
                                renderQuestionnaireResults(content, phaseData, results);
                                break;
                            case INTERVIEW:
                                renderInterview(content, phaseData, results);
                                break;
                            case SUS:
                                renderSUS(content, phaseData, results);
                                break;
                            case UEQ:
                                renderUEQ(content, phaseData, results);
                                break;
                            case GUS_SINGLE_GESTURES:
                                renderSingleGUS(content, phaseData, results);
                                break;
                            case GUS_MULTIPLE_GESTURES:
                                renderQuestionnaireResults(content, getAssembledItems(phaseData.gus), results);
                                break;
                            case GESTURE_TRAINING:
                                renderGestureTraining(content, phaseData, results);
                                break;
                            case SLIDESHOW_GESTURES:
                                renderGestureSlideshow(content, phaseData, results);
                                break;
                            case SLIDESHOW_TRIGGER:
                                renderTriggerSlideshow(content, phaseData, results);
                                break;
                            case PHYSICAL_STRESS_TEST:
                                renderPhysicalStressTest(content, phaseData, results);
                                break;
                            case SCENARIO:
                                renderScenario(content, phaseData, results);
                                break;
                            case IDENTIFICATION:
                                renderIdentification(content, phaseData, results);
                                break;
                            case EXPLORATION:
                                renderExploration(content, phaseData, results);
                                break;
                        }

                        initPopover();
                    }
                } else {
                    var noResultsContent = $('#template-study-container').find('#no-phase-results').clone().removeAttr('id');
                    $('#phase-result').empty().append(noResultsContent);
                    $(noResultsContent).css({y: 0, opacity: 1});
                    TweenMax.from(noResultsContent, .2, {opacity: 0, y: -60});
                }
            }

            function renderLetterOfAcceptance(content, studyData, resultsData) {
                if (resultsData.accepted === 'yes') {
                    $(content).find('#letter-accepted').removeClass('hidden');
                } else {
                    $(content).find('#letter-not-accepted').removeClass('hidden');
                }
                $(content).find('#letter-text').html(studyData);
            }

            function renderThanks(content, studyData) {
                $(content).find('#thanks-text').text(studyData);
            }

            function renderQuestionnaireResults(content, phaseData, results, format) {
//                console.log('render questionnaire', phaseData, results);
                renderQuestionnaireAnswers(content, phaseData);
                renderQuestionnaireStatistics(content, phaseData, results, format);
            }

            function renderInterview(content, phaseData, results) {
                renderQuestionnaireResults(content, phaseData, results, INTERVIEW);
            }

            function renderQuestionnaireStatistics(content, phaseData, results, format) {
                var allAnswers = [];
//                console.log('results', format, results);
                for (var i = 0; i < phaseData.length; i++) {

                    allAnswers.push({id: phaseData[i].id, answers: []});

                    for (var j = 0; j < results.length; j++) {
                        if (format === INTERVIEW && results[j].evaluator && results[j].evaluator.results && results[j].evaluator.results.answers && results[j].evaluator.results.answers.length > 0) {
                            var tempAnswers = getAnswerForQuestion(phaseData[i], results[j].evaluator.results.answers);
                            allAnswers[i].answers = allAnswers[i].answers.concat(tempAnswers);
                        } else if (results[j].tester && results[j].tester.answers && results[j].tester.answers.length > 0) {
                            var tempAnswers = getAnswerForQuestion(phaseData[i], results[j].tester.answers);
                            allAnswers[i].answers = allAnswers[i].answers.concat(tempAnswers);
                        }
                    }
                    var missedCount = Math.max(results.length - allAnswers[i].answers.length, 0);

                    // render statistics for current question
                    console.log(phaseData[i].format, allAnswers[i]);
                    var scalesMissing = [];
                    var questionPanel = $(content).find('[data-id=' + phaseData[i].id + ']');

                    if (allAnswers[i].answers && allAnswers[i].answers.length > 0) {
                        for (var j = 0; j < allAnswers[i].answers.length; j++) {
                            $(questionPanel).find('#no-answer').remove();
                            $(questionPanel).find('.count-badge').css({marginRight: '5px'}).removeClass('hidden');

                            switch (phaseData[i].format) {
                                case OPEN_QUESTION:
                                case OPEN_QUESTION_GUS:
                                    var openAnswer = document.createElement('div');
                                    $(openAnswer).text(allAnswers[i].answers[j].answer.openAnswer);
                                    if (j === 0) {
                                        $(questionPanel).find('.answer').html(openAnswer);
                                    } else {
                                        $(questionPanel).find('.answer').append(openAnswer);
                                    }
                                    break;
                                case DICHOTOMOUS_QUESTION:
                                case DICHOTOMOUS_QUESTION_GUS:
                                    var option = $(questionPanel).find('[data-id=' + allAnswers[i].answers[j].selectedSwitch + ']');
                                    var currentCount = parseInt($(option).find('.count-badge .count-label').text());
                                    $(option).find('.count-badge .count-label').text(isNaN(currentCount) ? 1 : currentCount + 1);
                                    if (allAnswers[i].answers[j].justification !== '') {
                                        $(option).find('#justification-content').removeClass('hidden').find('.text').text($(option).find('#justification-content').find('.text').text() + allAnswers[i].answers[j].justification + '; ');
                                    }
                                    break;
                                case GROUPING_QUESTION:
                                case GROUPING_QUESTION_OPTIONS:
                                case GROUPING_QUESTION_GUS:
                                    if (allAnswers[i].answers[j] !== null) {
                                        var option = $(questionPanel).find('[data-id=' + allAnswers[i].answers[j].id + ']');
                                        var currentCount = parseInt($(option).find('.count-badge .count-label').text());
                                        $(option).find('.count-badge .count-label').text(isNaN(currentCount) ? 1 : currentCount + 1);
                                        if (allAnswers[i].answers[j].id === 'optionalAnswer' && allAnswers[i].answers[j].content !== '') {
                                            var optionAnswerContent = $(questionPanel).find('#optionalanswer-content');
                                            $(optionAnswerContent).find('#no-optional-answer').remove();
                                            var currentTextContent = $(optionAnswerContent).find('.text').text().trim();
                                            $(optionAnswerContent).find('.text').text((currentTextContent === '-' || currentTextContent === '') ? allAnswers[i].answers[j].content + '; ' : currentTextContent + allAnswers[i].answers[j].content + '; ');
                                        }

                                        if (allAnswers[i].answers[j].justification !== '') {
                                            $(option).find('#justification-content').removeClass('hidden').find('.text').text($(option).find('#justification-content').find('.text').text() + allAnswers[i].answers[j].justification + '; ');
                                        }
                                    } else {
                                        missedCount++;
                                    }
                                    break;
                                case RATING:
                                    var option = $(questionPanel).find('[data-id=' + allAnswers[i].answers[j].id + ']');
                                    var currentCount = parseInt($(option).find('.count-badge .count-label').text());
                                    $(option).find('.count-badge .count-label').text(isNaN(currentCount) ? 1 : currentCount + 1);
                                    break;
                                case MATRIX:
                                    var matrixItems = $(questionPanel).find('#matrix-item');
                                    for (var k = 0; k < allAnswers[i].answers[j].scales.length; k++) {
                                        var scaleKey = allAnswers[i].answers[j].scales[k].id;
                                        var option = $(questionPanel).find('.option-container #' + scaleKey);
                                        var currentCount = parseInt($(option).find('.count-badge .count-label').text());
                                        $(option).find('.count-badge .count-label').text(isNaN(currentCount) ? 1 : currentCount + 1);
                                        scalesMissing[$(option).closest('#matrix-item').attr('data-id')] = isNaN(parseInt(scalesMissing[$(option).closest('#matrix-item').attr('data-id')])) ? 1 : parseInt(scalesMissing[$(option).closest('#matrix-item').attr('data-id')]) + 1;
                                    }

                                    for (var k = 0; k < matrixItems.length; k++) {
                                        renderUnansweredParticipantCount($(matrixItems[k]), phaseData[i].format, results.length - scalesMissing[$(matrixItems[k]).attr('data-id')]);
                                    }
                                    break;
                                case SUM_QUESTION:
                                    if (allAnswers[i].answers[j].sumCounts && allAnswers[i].answers[j].sumCounts.length > 0) {
                                        for (var k = 0; k < allAnswers[i].answers[j].sumCounts.length; k++) {
                                            var currentTextContent = $(questionPanel).find('[data-id=' + allAnswers[i].answers[j].sumCounts[k].id + '] .answer').text();
                                            $(questionPanel).find('[data-id=' + allAnswers[i].answers[j].sumCounts[k].id + '] .answer').text(currentTextContent + allAnswers[i].answers[j].sumCounts[k].count + '; ');
                                        }
                                    }
                                    $(questionPanel).find('#distributeNotAllPoints').remove();
                                    break;
                                case RANKING:
                                    if (allAnswers[i].answers[j].arrangement && allAnswers[i].answers[j].arrangement.length > 0) {
                                        if (j === 0) {
                                            $(questionPanel).find('.option-container').empty();
                                        }
                                        var currentTextContent = document.createElement('div');
                                        $(questionPanel).find('.option-container').append(currentTextContent);
                                        var address = document.createElement('span');
                                        $(address).text(translation.participant + ' ' + (j + 1) + ': ');
                                        $(currentTextContent).append(address);
                                        var answerContents = document.createElement('span');
                                        $(answerContents).addClass('text');
                                        $(currentTextContent).append(answerContents);

                                        for (var k = 0; k < allAnswers[i].answers[j].arrangement.length; k++) {
                                            for (var m = 0; m < phaseData[i].options.length; m++) {
                                                if (parseInt(phaseData[i].options[m].id) === parseInt(allAnswers[i].answers[j].arrangement[k])) {
                                                    $(answerContents).text($(answerContents).text() + phaseData[i].options[m].text + '; ');
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                    break;
                                case COUNTER:
                                    if (j === 0) {
                                        $(questionPanel).find('.answer').text(allAnswers[i].answers[j].count + '; ');
                                    } else {
                                        var currentTextContent = $(questionPanel).find('.answer').text();
                                        $(questionPanel).find('.answer').text(currentTextContent + allAnswers[i].answers[j].count + '; ');
                                    }
                                    break;
                                case UEQ_ITEM:
                                    $(questionPanel).find('#participant-answers').removeClass('hidden');
                                    var participantAnswer = document.createElement('div');
                                    $(questionPanel).find('#participant-answers').append(participantAnswer);
                                    var address = document.createElement('span');
                                    $(address).text(translation.participant + ' ' + (j + 1) + ': ');
                                    $(participantAnswer).append(address);
                                    var answer = document.createElement('span');
                                    $(participantAnswer).append(answer);

                                    var score = 0;
                                    if (phaseData[i].parameters.negative === 'yes') {
                                        if (answer) {
                                            score = 7 - (parseInt(allAnswers[i].answers[j].selectedOption) + 1) - 3;
                                        }
                                    } else {
                                        if (answer) {
                                            score = parseInt(allAnswers[i].answers[j].selectedOption) - 3;
                                        }
                                    }
                                    //                                score *= -1;

                                    $(answer).addClass('text score').text(score);
                                    break;
                            }
                        }

                        if (missedCount > 0 && phaseData[i].format !== MATRIX) {
                            renderUnansweredParticipantCount(questionPanel, phaseData[i].format, missedCount, true);
                        }
                    } else {
                        renderUnansweredParticipantCount(questionPanel, phaseData[i].format, missedCount);
                    }
                }
            }

            function renderUnansweredParticipantCount(content, format, count, append) {
                if (count > 0) {
                    switch (format) {
                        case OPEN_QUESTION:
                        case OPEN_QUESTION_GUS:
                            var missedAnswers = document.createElement('div');
                            $(missedAnswers).text('Frage von ' + count + ' ' + (count === 1 ? translation.participant : translation.participants) + ' ' + translation.questionNotAnswered);
                            $(content).find('#missed-answers').removeClass('hidden').html(missedAnswers);
                            break;
                        case DICHOTOMOUS_QUESTION:
                            var missedAnswers = document.createElement('div');
                            $(missedAnswers).text('Frage von ' + count + ' ' + (count === 1 ? translation.participant : translation.participants) + ' ' + translation.questionNotAnswered);
                            $(content).find('#missed-answers').removeClass('hidden').html(missedAnswers);
                            break;
                        case GROUPING_QUESTION:
                        case GROUPING_QUESTION_OPTIONS:
                        case GROUPING_QUESTION_GUS:
                            var missedAnswers = document.createElement('div');
                            $(missedAnswers).text('Frage von ' + count + ' ' + (count === 1 ? translation.participant : translation.participants) + ' ' + translation.questionNotAnswered);
                            $(content).find('#missed-answers').removeClass('hidden').html(missedAnswers);
                            break;
                        case MATRIX:
                            var missedAnswers = document.createElement('div');
                            $(missedAnswers).text('Frage von ' + count + ' ' + (count === 1 ? translation.participant : translation.participants) + ' ' + translation.questionNotAnswered);
                            $(content).find('#missed-answers').removeClass('hidden').html(missedAnswers);
                            break;
                        case SUM_QUESTION:
                            var missedAnswers = document.createElement('div');
                            $(missedAnswers).text('Frage von ' + count + ' ' + (count === 1 ? translation.participant : translation.participants) + ' ' + translation.questionNotAnswered);
                            $(content).find('#missed-answers').removeClass('hidden').html(missedAnswers);
                            break;
                        case RANKING:
                            var missedAnswers = document.createElement('div');
                            $(missedAnswers).text('Frage von ' + count + ' ' + (count === 1 ? translation.participant : translation.participants) + ' ' + translation.questionNotAnswered);
                            $(content).find('#missed-answers').removeClass('hidden').html(missedAnswers);
                            break;
                        case COUNTER:
                            var missedAnswers = document.createElement('div');
                            $(missedAnswers).text('Frage von ' + count + ' ' + (count === 1 ? translation.participant : translation.participants) + ' ' + translation.questionNotAnswered);
                            $(content).find('#missed-answers').removeClass('hidden').html(missedAnswers);
                            break;
                        case UEQ_ITEM:
                            break;
                    }
                } else {
                    $(content).find('#missed-answers').addClass('hidden');
                }
            }

            function getAnswerForQuestion(questionData, answers) {
                var tempAnswers = [];
//                console.log('get answer for question', questionData, answers);
                for (var i = 0; i < answers.length; i++) {
                    if (parseInt(answers[i].id) === parseInt(questionData.id)) {
                        switch (questionData.format) {
                            case OPEN_QUESTION:
                            case OPEN_QUESTION_GUS:
                                if (new String(answers[i].answer.openAnswer).trim() !== '') {
                                    tempAnswers.push(answers[i]);
                                }
                                break;
                            case DICHOTOMOUS_QUESTION:
                            case DICHOTOMOUS_QUESTION_GUS:
                                if (answers[i].answer.selectedSwitch !== 'none') {
                                    tempAnswers.push(answers[i].answer);
                                }
                                break;
                            case GROUPING_QUESTION:
                            case GROUPING_QUESTION_OPTIONS:
                            case GROUPING_QUESTION_GUS:
                                for (var j = 0; j < answers[i].answer.selections.length; j++) {
                                    if (answers[i].answer.selections[j].selected === 'yes' || (questionData.parameters.optionalanswer === 'yes' && answers[i].answer.selections[j].id === 'optionalAnswer')) {
                                        tempAnswers.push(answers[i].answer.selections[j]);
                                    } else if (answers[i].answer.selections[j].selected === 'no' && (questionData.parameters.optionalanswer === 'yes' && answers[i].answer.selections[j].content === '')) {
                                        tempAnswers.push(null);
                                    }
                                }
                                break;
                            case RATING:
                                if (parseInt(answers[i].answer.scales) > -1) {
                                    tempAnswers.push(answers[i].answer);
                                }
                                break;
                            case MATRIX:
                                var tempScales = {scales: []};
                                for (var j = 0; j < answers[i].answer.scales.length; j++) {
                                    if (parseInt(answers[i].answer.scales[j].scale) > -1) {
                                        tempScales.scales.push(answers[i].answer.scales[j]);
                                    }

                                    if (j >= answers[i].answer.scales.length - 1 && tempScales.scales.length > 0) {
                                        tempAnswers.push(tempScales);
                                    }
                                }
                                break;
                            case SUM_QUESTION:
                                tempAnswers.push(answers[i].answer);
                                break;
                            case RANKING:
                                tempAnswers.push(answers[i].answer);
                                break;
                            case COUNTER:
                                tempAnswers.push(answers[i].answer);
                                break;
                            case UEQ_ITEM:
                                if (answers[i].answer.selectedOption !== -1) {
                                    tempAnswers.push(answers[i].answer);
                                }
                                break;
                        }
                    }
                }

                return tempAnswers;
            }

            function renderSUS(content, studyData, resultsData) {
                renderQuestionnaireResults(content, studyData, resultsData);

                // calculate the average sus score
                var missingCount = 0;
                var meanScore = 0;
                for (var k = 0; k < resultsData.length; k++) {
                    var susResultsValid = true;
                    var count = 0;

                    for (var i = 0; i < resultsData[k].tester.answers.length; i++) {
                        if (parseInt(resultsData[k].tester.answers[i].answer.scales) !== -1) {
                            var negative = studyData[i].parameters.negative === 'yes';
                            if (negative) {
                                count += translation.susOptions.length - (parseInt(resultsData[k].tester.answers[i].answer.scales) + 1);
                            } else {
                                count += parseInt(parseInt(resultsData[k].tester.answers[i].answer.scales));
                            }
                        } else {
                            susResultsValid = false;
                        }
                    }

                    count *= 2.5;
                    if (susResultsValid) {
                        if (k === 0) {
                            meanScore = count;
                        } else {
                            meanScore = (meanScore + count) / (k + 1);
                        }
                    } else {
                        missingCount++;
                    }
                }

                if (resultsData.length - missingCount > 0) {
                    var fittedScore = getSUSAdjective(meanScore);
                    $(content).find('.alert-space').remove();
                    $(content).find('#average-score').css({color: fittedScore.adjective.color});
                    $(content).find('#score-adjective .address').text(translation.systemIs);
                    $(content).find('#score-adjective .text').text(fittedScore.adjective.adjective);
                    $(content).find('#score-adjective .tail').text(translation.rated);
                    $(content).find('#sus-grade .address').text(translation.grade);
                    $(content).find('#sus-grade .text').text(fittedScore.susGrade);
                    $(content).find('#sus-grade .tail').text(translation.received);
                    $(content).find('#sus-acceptability .text').text(fittedScore.susAcceptability);
                    renderSUSProgress($(content), translation.susScores, meanScore);
                } else {
                    $(content).find('#sus-score-results').remove();
                    appendAlert(content, ALERT_SUS_INVALID);
                }
            }

            function renderSUSProgress(container, susQuartiles, score) {
                var currentWidth = 0.0;
                var oldWidth = 0.0;
                var targetWidth = $(container).find('#sus-score-progress').width();

                for (var i = 0; i < susQuartiles.length; i++) {
                    currentWidth = parseFloat(i < susQuartiles.length - 1 ? susQuartiles[i + 1].score : 100) - oldWidth;
                    oldWidth = parseFloat(i < susQuartiles.length - 1 ? susQuartiles[i + 1].score : susQuartiles[i].score);

                    var progressBar = document.createElement('div');
                    $(progressBar).addClass('progress-bar');
                    $(progressBar).css({width: currentWidth + '%', backgroundColor: susQuartiles[i].color, boxShadow: 'none'});
                    $(container).find('#sus-score-progress').append(progressBar);

                    var markerItem = $('#template-study-container').find('#sus-marker-item').clone().removeAttr('id');
                    $(markerItem).find('.text').text(translation.susScores[i].adjective);
                    $(markerItem).find('.score').text(translation.susScores[i].score);
                    $(container).find('#sus-marker-container').append(markerItem);

                    if (i === 0 || i === susQuartiles.length - 1) {
                        $(markerItem).css({marginTop: '27px'});
                    }

                    var markerOffset = ($(markerItem).width() / 2) / targetWidth * 100;
                    var markerPercentage = parseFloat(susQuartiles[i].score) - markerOffset;
                    $(markerItem).css({left: markerPercentage + '%'});
                    TweenMax.from(markerItem, .2, {delay: 1.4 + (i * .05), opacity: 0, y: -10});
                }

                var gradeScales = translation.susGradeScale;
                for (var i = 0; i < gradeScales; i++) {

                }

                TweenMax.to($(container).find('#sus-score-pointer'), 2, {left: score + '%'});

                var counter = {var : 0};
                TweenMax.to(counter, 2, {
                    var : score,
                    onUpdate: function () {
                        $(container).find('#average-score').text(Math.floor(counter.var));
                    },
                    onComplete: function () {
                        $(container).find('#average-score').text(score);
                    },
                    ease: Circ.easeOut
                });
            }

            function renderUEQ(content, studyData, resultsData) {
                renderQuestionnaireResults(content, studyData, resultsData);

                // calculate ueq scales
                var ueqDimensions = translation.ueqDimensions;
                var ueqScores = [];

                // calculate sums for each dimension
                for (var r = 0; r < resultsData.length; r++) {
                    var ueqAnswers = resultsData[r].tester.answers;
//                    console.log('calc ueq for', ueqAnswers);

                    var scales = {
                        attractiveness: {sum: 0, max: 0, present: false},
                        efficiency: {sum: 0, max: 0, present: false},
                        perspicuity: {sum: 0, max: 0, present: false},
                        dependability: {sum: 0, max: 0, present: false},
                        stimulation: {sum: 0, max: 0, present: false},
                        novelty: {sum: 0, max: 0, present: false}
                    };

                    for (var key in ueqDimensions) {
                        if (ueqDimensions.hasOwnProperty(key)) {
                            for (var j = 0; j < studyData.length; j++) {
                                if (key === studyData[j].dimension) {
                                    var ueqId = parseInt(studyData[j].id);
                                    for (var k = 0; k < ueqAnswers.length; k++) {
                                        var answerId = parseInt(ueqAnswers[k].id);
                                        var value = 0;
                                        if (ueqId === answerId) {
                                            if (studyData[j].parameters.negative === 'yes') {
                                                value = 6 - parseInt(ueqAnswers[k].answer.selectedOption) - 3;
                                            } else {
                                                value = parseInt(ueqAnswers[k].answer.selectedOption) - 3;
                                            }

                                            scales[key].sum = scales[key].sum + value;
                                            scales[key].max++;
                                            scales[key].present = true;
                                        }
                                    }
                                }
                            }
                        }

                    }
                    ueqScores.push(scales);
                }

                var scales = {
                    attractiveness: {sum: 0, max: 0, present: false},
                    efficiency: {sum: 0, max: 0, present: false},
                    perspicuity: {sum: 0, max: 0, present: false},
                    dependability: {sum: 0, max: 0, present: false},
                    stimulation: {sum: 0, max: 0, present: false},
                    novelty: {sum: 0, max: 0, present: false}
                };

                for (var i = 0; i < ueqScores.length; i++) {
                    for (var key in ueqDimensions) {
                        for (var scoreKey in ueqScores[i]) {
                            if (key === scoreKey && ueqScores[i][key].present === true) {
                                scales[key].sum = scales[key].sum + ueqScores[i][key].sum;
                                scales[key].max = scales[key].max + ueqScores[i][key].max;
                                scales[key].present = ueqScores[i][key].present;
                            }
                        }
                    }
                }

                var qualities = {
                    attractiveness: {sum: 0.0, max: 0, presentMax: 1},
                    pragmaticQuality: {sum: 0.0, max: 0, presentMax: 3},
                    hedonicQuality: {sum: 0.0, max: 0, presentMax: 2}
                };

                for (var key in scales) {
                    var scaleValue = parseFloat(parseInt(scales[key].sum) / parseInt(scales[key].max)).toFixed(2);
                    if (scales[key].present === true) {
                        $(content).find('.ueq-scales-statistics .' + key + ' .text').text(scaleValue);

                        var arrow = null;
                        if (scaleValue < -0.8) {
                            arrow = $(content).find('.ueq-scales-statistics .' + key + ' .arrow-red');
                            $(arrow).removeClass('hidden');
                        } else if (scaleValue > 0.8) {
                            arrow = $(content).find('.ueq-scales-statistics .' + key + ' .arrow-green');
                            $(arrow).removeClass('hidden');
                        } else {
                            arrow = $(content).find('.ueq-scales-statistics .' + key + ' .arrow-yellow');
                            $(arrow).removeClass('hidden');
                        }
                        $(arrow).attr('data-quality-id', translation.ueqMainDimensionsForDimension[key]);

                        var qualityValue = parseFloat(qualities[translation.ueqMainDimensionsForDimension[key]].sum);
                        qualities[translation.ueqMainDimensionsForDimension[key]].sum = qualityValue + parseFloat(scaleValue);
                        qualities[translation.ueqMainDimensionsForDimension[key]].max++;
                    } else {
                        $(content).find('.ueq-scales-statistics .' + key + ' .text').text(translation.noDataCollected);
                    }
                }

                //            console.log('qualities', qualities);

                var timeline = null;
                var firstOffsetY = -4;
                var playTweenTimeout = 0;
                $(window).on('resize', function () {
                    clearTimeout(playTweenTimeout);
                    playTweenTimeout = setTimeout(function () {
                        var count = 0;
                        timeline = new TimelineMax({paused: true});
                        $('body').find('.tweenable-arrow').remove();

                        for (var key in qualities) {
                            var qualityValue = (parseFloat(qualities[key].sum) / parseInt(qualities[key].max)).toFixed(2);

                            if (qualities[key].max === qualities[key].presentMax) {
                                $(content).find('.ueq-quality-statistics .' + key + ' .text').text(qualityValue);

                                var arrow = null;
                                if (qualityValue < -0.8) {
                                    arrow = $(content).find('.ueq-quality-statistics .' + key + ' .arrow-red');
                                    $(arrow).removeClass('hidden');
                                } else if (qualityValue > 0.8) {
                                    arrow = $(content).find('.ueq-quality-statistics .' + key + ' .arrow-green');
                                    $(arrow).removeClass('hidden');
                                } else {
                                    arrow = $(content).find('.ueq-quality-statistics .' + key + ' .arrow-yellow');
                                    $(arrow).removeClass('hidden');
                                }
                                var tweenToPosition = $(arrow).offset();

                                var tweenArrows = $(content).find('.ueq-scales-statistics [data-quality-id=' + key + ']');
                                for (var i = 0; i < tweenArrows.length; i++) {
                                    var originPosition = $(tweenArrows[i]).offset();
                                    var tweenArrow = $(tweenArrows[i]).clone().removeAttr('data-quality-id');
                                    $(tweenArrow).addClass('tweenable-arrow');
                                    $('body').append(tweenArrow);
                                    $(tweenArrow).css({opacity: 0, position: 'absolute', top: (originPosition.top + firstOffsetY) + 'px', left: originPosition.left + 'px', pointerEvents: 'none'});
                                    timeline.add("start", 0)
                                            .to(tweenArrow, .1, {delay: (count * .3), css: {opacity: 1}}, "start")
                                            .to(tweenArrow, 1.0, {delay: .1 + (count * .3), css: {top: (tweenToPosition.top + firstOffsetY) + 'px', left: tweenToPosition.left + 'px'}, ease: Quad.easeInOut}, "start")
                                            .to(tweenArrow, .1, {delay: 1 + (count * .3), css: {opacity: 0}}, "start");
                                }
                            } else if (qualities[key].max < qualities[key].presentMax && qualities[key].max > 0) {
                                $(content).find('.ueq-quality-statistics .' + key + ' .text').text(translation.noEnoughDataCollected);
                            } else {
                                $(content).find('.ueq-quality-statistics .' + key + ' .text').text(translation.noDataCollected);
                            }

                            count++;
                        }
                        timeline.reverse();
                        firstOffsetY = -4;

                        timeline.invalidate().restart();
                        addArrowEvents();
                    }, 300);
                }).resize();

                function addArrowEvents() {
                    var clickableArrows = $(content).find('.arrow-green:not(.hidden), .arrow-yellow:not(.hidden), .arrow-red:not(.hidden)');
                    $(clickableArrows).css({cursor: 'pointer'});
                    $(clickableArrows).unbind('click').bind('click', function (event) {
                        event.preventDefault();
                        timeline.reversed() ? timeline.play() : timeline.reverse();
                    });
                }
            }

            var currentGUSData = null;
            function renderSingleGUS(content, studyData, resultsData) {
//                console.log('render single gus', resultsData);
                currentGUSData = studyData;
                renderQuestionnaireResults(content, getAssembledItems(studyData.gus), resultsData);
                //            renderQuestionnaireAnswers(content, , resultsData, true);

                var gesture = getGestureById(studyData.gestureId);
                if (gesture && isGestureAssembled(studyData.gestureId)) {
                    content.find('#title').text(gesture.title);
                    renderGestureImages(content.find('.previewGesture'), gesture.images, gesture.previewImage, null);
                    $(content).find('#gesture .address').text(translation.gesture + ':');
                    $(content).find('#gesture .text').text(gesture.title);

                    var trigger = getTriggerById(studyData.triggerId);
                    $(content).find('#trigger .address').text(translation.trigger + ':');
                    $(content).find('#trigger .text').text(trigger.title);


                    var feedback = getFeedbackById(studyData.feedbackId);
                    if (feedback) {
                        $(content).find('#feedback .address').text(translation.feedback + ':');
                        $(content).find('#feedback .text').text(feedback.title);

                        var icon = document.createElement('i');
                        var label = document.createElement('div');
                        $(label).addClass('label label-default');
                        switch (feedback.type) {
                            case TYPE_FEEDBACK_SOUND:
                                $(label).text(' Sound');
                                $(icon).addClass('fa fa-volume-up');
                                break;
                            case TYPE_FEEDBACK_TEXT:
                                $(label).text(' Text');
                                $(icon).addClass('fa fa-font');
                                break;
                        }

                        content.find('#feedback .text').text(" " + feedback.title);
                        $(label).prepend(icon);
                        content.find('#feedback .text').prepend(label);
                    }

                } else {
                    //                    $(content).find('#gesturePreview').addClass('hidden');
                }
            }


            function renderGestureTraining(content, studyData, results) {
                if (results && results.length > 0) {
                    for (var i = 0; i < results.length; i++) {
                        var evaluatorResults = results[i].evaluator;

                        var item = $('#template-study-all-container').find('#gesture-training-item').clone().css({marginTop: i === 0 ? '0px' : '80px'});
                        $(item).find('#headline-participant').text(translation.participant + ' ' + (i + 1));
                        renderTesterSnapshot($(item).find('#headline-participant'), results[i].tester);
                        renderSingleResultsButton($(item).find('#btn-open-participant-results'), results[i].userId);
                        $(content).find('#gesture-training-item-container').append(item);

                        if (evaluatorResults && evaluatorResults.results) {
                            var startTrainingTimes = new Array;
                            for (var j = 0; j < evaluatorResults.results.annotations.length; j++) {
                                if (evaluatorResults.results.annotations[j].action === ACTION_START_GESTURE_TRAINING) {
                                    startTrainingTimes.push(evaluatorResults.results.annotations[j]);
                                }
                            }

                            for (var j = 0; j < studyData.training.length; j++) {
                                var gesture = getGestureById(studyData.training[j].gestureId);
                                var trigger = getTriggerById(studyData.training[j].triggerId);
                                var feedback = getFeedbackById(studyData.training[j].feedbackId);

                                var trainingGestureItem = $('#template-study-container').find('#training-gesture-item').clone().removeAttr('id');
                                item.find('#traing-gestures-container').append(trainingGestureItem);
                                $(trainingGestureItem).find('#trigger .address').text(translation.trigger + ': ');
                                $(trainingGestureItem).find('#trigger .text').text(trigger.title);
                                $(trainingGestureItem).find('#repeats .address').text(translation.repeats + ': ');
                                $(trainingGestureItem).find('#repeats .text').text(studyData.training[j].repeats);
                                $(trainingGestureItem).find('#feedback .address').text(translation.feedback + ': ');

                                var gestureThumbnail = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12');
                                $(gestureThumbnail).removeClass('deleteable');
                                $(trainingGestureItem).find('.gesture-container').append(gestureThumbnail);

                                if (feedback) {
                                    var feedbackItem = $('#template-study-container').find('#feedback-catalog-thumbnail').clone().removeAttr('id');
                                    feedbackItem.find('.text').text(feedback.title);
                                    feedbackItem.find('#' + feedback.type).removeClass('hidden');
                                    if (feedback.type === TYPE_FEEDBACK_SOUND) {
                                        feedbackItem.find('.audio-holder').attr('src', feedback.data);
                                    }
                                    $(trainingGestureItem).find('#feedback .text').append(feedbackItem);
                                } else {
                                    $(trainingGestureItem).find('#feedback .text').text(translation.none);
                                }

                                if (evaluatorResults.results.annotations && evaluatorResults.results.annotations.length) {
                                    var trainingStart, trainingEnd = null;
                                    for (var k = 0; k < startTrainingTimes.length; k++) {
                                        if (parseInt(gesture.id) === parseInt(startTrainingTimes[k].gestureId)) {
                                            trainingStart = startTrainingTimes[k].time;
                                            if (k < startTrainingTimes.length - 1) {
                                                trainingEnd = parseInt(startTrainingTimes[k + 1].time);
                                                break;
                                            } else {
                                                trainingEnd = parseInt(evaluatorResults.results.endTime);
                                            }
                                        }
                                    }

                                    if (trainingStart && trainingEnd) {
                                        var execution = getTimeBetweenTimestamps(trainingStart, trainingEnd);
                                        $(trainingGestureItem).find('#training-time .address').text(translation.execution + ': ');
                                        $(trainingGestureItem).find('#training-time .text').text(getTimeString(execution, false, true));
                                    } else {
                                        $(trainingGestureItem).find('#training-time').remove();
                                    }
                                } else {
                                    $(trainingGestureItem).find('#training-time').remove();
                                }
                            }

                            renderAnnotatedNotes($(item).find('#annotated-notes'), getAnnotatedNotes(evaluatorResults.results.annotations));
                            renderNotes($(item).find('#notes'), evaluatorResults.notes);
                        }

                        renderObservation($(item).find('#observations'), studyData, evaluatorResults.observations);
                    }
                }
            }


            function renderGestureSlideshow(content, studyData, results) {
//                console.log('render gesture slideshow', studyData, results);

                if (results && results.length > 0) {
                    var fits = [];
                    for (var i = 0; i < results.length; i++) {
                        var evaluatorResults = results[i].evaluator;
                        var testerResults = results[i].tester;
                        if (testerResults) {
                            var item = $('#template-study-all-container').find('#gesture-slideshow-item').clone().css({marginTop: '80px'});
                            $(item).find('#headline-participant').text(translation.participant + ' ' + (i + 1));
                            renderTesterSnapshot($(item).find('#headline-participant'), results[i].tester);
                            renderSingleResultsButton($(item).find('#btn-open-participant-results'), results[i].userId);
                            $(content).find('#gesture-slideshow-item-container').append(item);

                            $(item).find('#restarts .address').text(parseInt(testerResults.restarts) === 1 ? translation.restart : translation.restarts);
                            $(item).find('#restarts .text').text(testerResults.restarts);

                            for (var j = 0; j < studyData.slideshow.length; j++) {
                                var gesture = getGestureById(studyData.slideshow[j].gestureId);
                                var trigger = getTriggerById(studyData.slideshow[j].triggerId);

                                var gestureSlideshowItem = $('#template-study-container').find('#slideshow-gesture-item').clone().removeAttr('id');
                                item.find('#gestures-container').append(gestureSlideshowItem);
                                $(gestureSlideshowItem).find('#trigger .address').text(translation.trigger + ': ');
                                $(gestureSlideshowItem).find('#trigger .text').text(trigger.title);
                                $(gestureSlideshowItem).find('#recognition-time .address').text(translation.recognitionTime + ': ');
                                var recognitionSeconds = parseInt(studyData.slideshow[j].recognitionTime);
                                $(gestureSlideshowItem).find('#recognition-time .text').text(recognitionSeconds + ' ' + (recognitionSeconds === 1 ? translation.timesSingular.seconds : translation.times.seconds));

                                var gestureThumbnail = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12');
                                $(gestureThumbnail).removeClass('deleteable');
                                $(gestureSlideshowItem).find('.gesture-container').append(gestureThumbnail);

                                if (testerResults.annotations && testerResults.annotations.length > 0) {
                                    var count = 0;
                                    for (var k = 0; k < testerResults.annotations.length; k++) {
                                        if (testerResults.annotations[k].action === ACTION_NO_GESTURE_FIT_FOUND && parseInt(testerResults.annotations[k].gestureId) === parseInt(gesture.id)) {
                                            count++;
                                        }
                                    }

                                    fits.push({gestureId: gesture.id, triggerId: trigger.id, errors: count});

                                    if (count > 0) {
                                        $(gestureSlideshowItem).find('#fits-false .address').text(translation.fitsCorrect + ': ');
                                        $(gestureSlideshowItem).find('#fits-false .text').text(count + ' ' + (count === 1 ? translation.fault : translation.faults));
                                        $(gestureSlideshowItem).find('#fits-false').removeClass('hidden');
                                    } else {
                                        $(gestureSlideshowItem).find('#fits-correct .address').text(translation.fitsCorrect + ': ');
                                        $(gestureSlideshowItem).find('#fits-correct .text').text(translation.allFitsCorrect);
                                        $(gestureSlideshowItem).find('#fits-correct').removeClass('hidden');
                                    }
                                }
                            }

                            renderAnnotatedNotes($(item).find('#annotated-notes'), getAnnotatedNotes(testerResults.annotations));
                            renderNotes($(item).find('#notes'), evaluatorResults.notes);
                        }

                        renderObservation($(item).find('#observations'), studyData, evaluatorResults.observations);
                    }

                    for (var i = 0; i < studyData.slideshow.length; i++) {
                        var gesture = getGestureById(studyData.slideshow[i].gestureId);
                        var trigger = getTriggerById(studyData.slideshow[i].triggerId);

                        var summaryItem = $('#template-study-all-container').find('#slideshow-summary-item').clone();
                        $(content).find('#summary-item-container').append(summaryItem);
                        $(summaryItem).find('#trigger .address').text(translation.trigger + ': ');
                        $(summaryItem).find('#trigger .text').text(trigger.title);

                        var gestureThumbnail = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12');
                        $(gestureThumbnail).removeClass('deleteable');
                        $(summaryItem).find('.gesture-container').append(gestureThumbnail);

                        var errors = 0;
                        for (var j = 0; j < fits.length; j++) {
                            if (parseInt(gesture.id) === parseInt(fits[j].gestureId)) {
                                errors = Math.max(errors, fits[j].errors);
                            }
                        }

                        $(summaryItem).find('#answered-correct').remove();
                        $(summaryItem).find('#answered-wrong').remove();
                        $(summaryItem).find('#gesture-quota .content').text(errors + ' ' + translation.faults + ', ' + ((studyData.slideshow.length - errors) / studyData.slideshow.length * 100) + '% ' + translation.assignedCorrectly);
                    }
                }
            }

            function renderTriggerSlideshow(content, studyData, results) {
                if (results && results.length > 0) {
                    var fits = [];
                    for (var i = 0; i < results.length; i++) {
                        var evaluatorResults = results[i].evaluator;
                        var testerResults = results[i].tester;
                        if (testerResults) {
                            var item = $('#template-study-all-container').find('#trigger-slideshow-item').clone().css({marginTop: '80px'});
                            $(item).find('#headline-participant').text(translation.participant + ' ' + (i + 1));
                            renderTesterSnapshot($(item).find('#headline-participant'), results[i].tester
                                    );
                            renderSingleResultsButton($(item).find('#btn-open-participant-results'), results[i].userId);
                            $(content).find('#trigger-slideshow-item-container').append(item);


                            var globalFaults = 0;
                            for (var j = 0; j < studyData.slideshow.length; j++) {
                                var gesture = getGestureById(studyData.slideshow[j].gestureId);
                                var trigger = getTriggerById(studyData.slideshow[j].triggerId);
                                var slideshowTriggerItem = $('#template-study-container').find('#slideshow-trigger-item').clone().removeAttr('id');
                                $(item).find('#gestures-container').append(slideshowTriggerItem);
                                $(slideshowTriggerItem).find('#trigger .address').text(translation.trigger + ': ');
                                $(slideshowTriggerItem).find('#trigger .text').text(trigger.title);
                                $(slideshowTriggerItem).find('#selection .address').text(translation.trigger + ' ' + translation.answer + ': ');

                                var gestureThumbnail = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12');
                                $(gestureThumbnail).removeClass('deleteable');
                                $(slideshowTriggerItem).find('.gesture-container').append(gestureThumbnail);

                                var fault = 0;
                                if (testerResults.selectedOptions && testerResults.selectedOptions.length > 0) {
                                    for (var k = 0; k < testerResults.selectedOptions.length; k++) {
                                        var option = testerResults.selectedOptions[k];
                                        if (parseInt(option.correctTriggerId) === parseInt(trigger.id)) {
                                            var selectedOption = parseInt(testerResults.selectedOptions[k].selectedId);
                                            if (selectedOption === -1) {
                                                fault = -1;
                                                $(slideshowTriggerItem).find('#selection .text').text(translation.none);
                                                $(slideshowTriggerItem).find('#no-answer').removeClass('hidden');
                                            } else {
                                                $(slideshowTriggerItem).find('#selection .text').text(getTriggerById(selectedOption).title);
                                                if (selectedOption !== parseInt(trigger.id)) {
                                                    globalFaults++;
                                                    $(slideshowTriggerItem).find('#fits-false').removeClass('hidden');
                                                } else {
                                                    $(slideshowTriggerItem).find('#fits-correct').removeClass('hidden');
                                                }
                                                fits.push({gestureId: gesture.id, triggerId: trigger.id, selectedTriggerId: selectedOption});
                                            }
                                        }
                                    }

                                    if (fault === -1) {
                                        globalFaults = -1;
                                    }
                                } else {
                                    globalFaults = -1;
                                }
                            }

                            if (globalFaults === -1) {
                                $(item).find('#score #no-fault-score').removeClass('hidden');
                            } else {
                                $(item).find('#score #fault-score').removeClass('hidden');
                                var faultScore = globalFaults / studyData.slideshow.length;
                                var faultPercentage = (1 - faultScore) * 100;
                                $(item).find('#score .text').text(faultPercentage + '%');
                            }

                            renderAnnotatedNotes($(item).find('#annotated-notes'), getAnnotatedNotes(testerResults.annotations));
                            renderNotes($(item).find('#notes'), evaluatorResults.notes);
                        }

                        renderObservation($(item).find('#observations'), studyData, evaluatorResults.observations);
                    }

                    for (var i = 0; i < studyData.slideshow.length; i++) {
                        var gesture = getGestureById(studyData.slideshow[i].gestureId);
                        var trigger = getTriggerById(studyData.slideshow[i].triggerId);

                        var summaryItem = $('#template-study-all-container').find('#slideshow-summary-item').clone();
                        $(content).find('#summary-item-container').append(summaryItem);
                        $(summaryItem).find('#trigger .address').text(translation.trigger + ': ');
                        $(summaryItem).find('#trigger .text').text(trigger.title);

                        var gestureThumbnail = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12');
                        $(gestureThumbnail).removeClass('deleteable');
                        $(summaryItem).find('.gesture-container').append(gestureThumbnail);

                        var answeredCorrect = 0;
                        for (var j = 0; j < fits.length; j++) {
                            if (parseInt(gesture.id) === parseInt(fits[j].gestureId)) {
                                if (parseInt(trigger.id) === parseInt(fits[j].selectedTriggerId)) {
                                    answeredCorrect++;
                                }
                            }
                        }

                        var wrongAnswered = studyData.slideshow.length - answeredCorrect;
                        $(summaryItem).find('#answered-correct .content').text(answeredCorrect === 1 ? answeredCorrect + ' ' + translation.participant : answeredCorrect + ' ' + translation.participants);
                        $(summaryItem).find('#answered-wrong .content').text(wrongAnswered === 1 ? wrongAnswered + ' ' + translation.participant : wrongAnswered + ' ' + translation.participants);
                        $(summaryItem).find('#gesture-quota .content').text((answeredCorrect / studyData.slideshow.length * 100) + '% ' + translation.assignedCorrectly);
                    }
//                    console.log('fits', fits);
                }
            }


            function renderPhysicalStressTest(content, studyData, results) {
                //                console.log(studyData, resultsData);
                if (results && results.length > 0) {
                    var summarizedAnswers = {singleAnswers: [], sequenceAnswers: []};
//                    var summarizedAnswers = [];
                    var singleStressGraphicsRating = studyData.singleStressGraphicsRating;
                    var sequenceStressGraphicsRating = studyData.sequenceStressGraphicsRating;

                    for (var i = 0; i < results.length; i++) {
                        var evaluatorResults = results[i].evaluator;
                        var testerResults = results[i].tester;
                        if (testerResults) {
//                            summarizedAnswers.push(testerResults.answers);
                            if (singleStressGraphicsRating !== 'none') {
                                summarizedAnswers.singleAnswers = summarizedAnswers.singleAnswers.concat(testerResults.answers.singleAnswers);
                            }
//
                            if (sequenceStressGraphicsRating !== 'none') {
                                summarizedAnswers.sequenceAnswers = summarizedAnswers.sequenceAnswers.concat(testerResults.answers.sequenceAnswers);
                            }

                            var item = $('#template-study-all-container').find('#stress-test-item').clone().css({marginTop: '80px'});
                            $(item).find('#headline-participant').text(translation.participant + ' ' + (i + 1));
                            renderTesterSnapshot($(item).find('#headline-participant'), results[i].tester);
                            renderSingleResultsButton($(item).find('#btn-open-participant-results'), results[i].userId);
                            $(content).find('#stress-test-item-container').append(item);

                            for (var j = 0; j < studyData.stressTestItems.length; j++) {
                                var physicalStressTestItem = $('#template-study-container').find('#physicalStressTest-item').clone().removeAttr('id');
                                $(item).find('#answers-container').append(physicalStressTestItem);

                                var gestures = studyData.stressTestItems[j].gestures;
                                for (var g = 0; g < gestures.length; g++) {
                                    var gesture = getGestureById(gestures[g]);
                                    var gestureThumbnail = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12');
                                    $(gestureThumbnail).removeClass('deleteable');
                                    $(physicalStressTestItem).find('.gesture-container').append(gestureThumbnail);
                                }

                                $(physicalStressTestItem).find('#trigger .address').text(translation.trigger + ': ');
                                $(physicalStressTestItem).find('#trigger .text').text(trigger.title);
                                $(physicalStressTestItem).find('#selection .address').text(translation.trigger + ' ' + translation.answer + ': ');


                                // check if answers are there
                                if (testerResults.answers && !$.isEmptyObject(testerResults.answers)) {

                                    // single questions joint section
                                    if (singleStressGraphicsRating !== 'none') {
                                        var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
                                        $(jointAnswers).insertAfter($(physicalStressTestItem).find('#headline-single-questions'));
                                        if (singleStressGraphicsRating === 'hands') {
                                            $(jointAnswers).find('#joint-answers-body').remove();
                                            renderHandJointAnswers($(jointAnswers).find('#human-hand'), testerResults.answers, studyData.stressTestItems[j].id, 'single');
                                        } else if (singleStressGraphicsRating === 'body') {
                                            $(jointAnswers).find('#joint-answers-hands').remove();
                                            renderBodyJointAnswers($(jointAnswers).find('#human-body'), testerResults.answers, studyData.stressTestItems[j].id, 'single');
                                        } else {
                                            renderHandJointAnswers($(jointAnswers).find('#human-hand'), testerResults.answers, studyData.stressTestItems[j].id, 'single');
                                            renderBodyJointAnswers($(jointAnswers).find('#human-body'), testerResults.answers, studyData.stressTestItems[j].id, 'single');
                                        }
                                    }

                                    // sequence questions joint section
                                    if (sequenceStressGraphicsRating !== 'none') {
                                        var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
                                        $(jointAnswers).insertAfter($(physicalStressTestItem).find('#headline-sequence-questions'));

                                        if (sequenceStressGraphicsRating === 'hands') {
                                            $(jointAnswers).find('#joint-answers-body').remove();
                                            renderHandJointAnswers($(jointAnswers).find('#human-hand'), testerResults.answers, studyData.stressTestItems[j].id, 'sequence');
                                        } else if (sequenceStressGraphicsRating === 'body') {
                                            $(jointAnswers).find('#joint-answers-hands').remove();
                                            renderBodyJointAnswers($(jointAnswers).find('#human-body'), testerResults.answers, studyData.stressTestItems[j].id, 'sequence');
                                        } else {
                                            renderBodyJointAnswers($(jointAnswers).find('#human-body'), testerResults.answers, studyData.stressTestItems[j].id, 'sequence');
                                            renderHandJointAnswers($(jointAnswers).find('#human-hand'), testerResults.answers, studyData.stressTestItems[j].id, 'sequence');
                                        }
                                    }

                                    // single answers section
                                    var singleStressQuestionnaire = studyData.singleStressQuestions;
                                    if (singleStressQuestionnaire && singleStressQuestionnaire.length > 0) {
                                        var questionAnswers = {answers: []};
                                        var questions = [];

                                        for (var k = 0; k < testerResults.answers.singleAnswers.length; k++) {
                                            if (parseInt(testerResults.answers.singleAnswers[k].stressTestIndex) === i) {
                                                questionAnswers.answers = questionAnswers.answers.concat(testerResults.answers.singleAnswers[k].answers);
                                                questions = questions.concat(singleStressQuestionnaire);
                                            }
                                        }

//                                        console.log(questionAnswers, questions);
                                        if (questions.length > 0 && questionAnswers.answers.length > 0) {
                                            renderQuestionnaireAnswers($(physicalStressTestItem).find('#single-stress-answers'), questions, questionAnswers, false, true);
                                        }
                                    }

                                    // sequence answers section
                                    var sequenceStressQuestionnaire = studyData.sequenceStressQuestions;
                                    if (sequenceStressQuestionnaire && sequenceStressQuestionnaire.length > 0) {
                                        var questionAnswers = {answers: []};
                                        var questions = [];

                                        for (var k = 0; k < results.tester.answers.sequenceAnswers.length; k++) {
                                            if (parseInt(testerResults.answers.sequenceAnswers[k].stressTestIndex) === i) {
                                                questionAnswers.answers = questionAnswers.answers.concat(testerResults.answers.sequenceAnswers[k].answers);
                                                questions = questions.concat(sequenceStressQuestionnaire);
                                            }
                                        }

                                        if (questions.length > 0 && questionAnswers.answers.length > 0) {
                                            renderQuestionnaireAnswers($(physicalStressTestItem).find('#sequence-stress-answers'), questions, questionAnswers, false, true);
                                        }
                                    }
                                }
                            }

                            renderAnnotatedNotes($(item).find('#annotated-notes'), getAnnotatedNotes(testerResults.annotations));
                            renderNotes($(item).find('#notes'), evaluatorResults.notes);
                        }

                        renderObservation($(item).find('#observations'), studyData, evaluatorResults.observations);
                    }


//                    console.log('summarizedAnswers', summarizedAnswers);
//                    var jointAnswers = null;
                    for (var j = 0; j < studyData.stressTestItems.length; j++) {
                        // render body joints for summary section
                        var summaryJointsItem = $('#template-study-all-container').find('#stress-test-summary-joints-item').clone().css({marginTop: j > 0 ? '80px' : '0px'});
                        $(summaryJointsItem).find('#headline-summary').text(translation.gestureSequence + ' ' + (j + 1) + ' ' + translation.of + ' ' + studyData.stressTestItems.length);
                        $(content).find('#summary-joints-container').append(summaryJointsItem);

                        var gestures = studyData.stressTestItems[j].gestures;
                        for (var g = 0; g < gestures.length; g++) {
                            var gesture = getGestureById(gestures[g]);
                            var gestureThumbnail = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12');
                            $(gestureThumbnail).removeClass('deleteable');
                            $(summaryJointsItem).find('#gesture-thumbnail-container').append(gestureThumbnail);
                        }

                        if (singleStressGraphicsRating !== 'none') {
                            var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
                            $(summaryJointsItem).find('#single-answers').append(jointAnswers);

                            if (singleStressGraphicsRating === 'hands') {
                                $(jointAnswers).find('#joint-answers-body').remove();
                                renderHandJointAnswers($(jointAnswers).find('#human-hand'), summarizedAnswers, studyData.stressTestItems[j].id, 'single');
                            } else if (singleStressGraphicsRating === 'body') {
                                $(jointAnswers).find('#joint-answers-hands').remove();
                                renderBodyJointAnswers($(jointAnswers).find('#human-body'), summarizedAnswers, studyData.stressTestItems[j].id, 'single');
                            } else {
                                renderHandJointAnswers($(jointAnswers).find('#human-hand'), summarizedAnswers, studyData.stressTestItems[j].id, 'single');
                                renderBodyJointAnswers($(jointAnswers).find('#human-body'), summarizedAnswers, studyData.stressTestItems[j].id, 'single');
                            }
                        }

                        if (sequenceStressGraphicsRating !== 'none') {
                            var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
                            $(summaryJointsItem).find('#sequence-answers').append(jointAnswers);

                            if (sequenceStressGraphicsRating === 'hands') {
                                $(jointAnswers).find('#joint-answers-body').remove();
                                renderHandJointAnswers($(jointAnswers).find('#human-hand'), summarizedAnswers, studyData.stressTestItems[j].id, 'sequence', true);
                            } else if (sequenceStressGraphicsRating === 'body') {
                                $(jointAnswers).find('#joint-answers-hands').remove();
                                renderBodyJointAnswers($(jointAnswers).find('#human-body'), summarizedAnswers, studyData.stressTestItems[j].id, 'sequence', true);
                            } else {
                                renderBodyJointAnswers($(jointAnswers).find('#human-body'), summarizedAnswers, studyData.stressTestItems[j].id, 'sequence', true);
                                renderHandJointAnswers($(jointAnswers).find('#human-hand'), summarizedAnswers, studyData.stressTestItems[j].id, 'sequence', true);
                            }
                        }
                    }
                }
            }

            function renderScenario(content, studyData, results) {
                if (results && results.length > 0) {
                    for (var i = 0; i < results.length; i++) {
                        var evaluatorResults = results[i].evaluator;
                        var identificationItem = $('#template-study-all-container').find('#scenario-item').clone().css({marginTop: i === 0 ? '0px' : '80px'});
                        $(identificationItem).find('#headline-participant').text(translation.participant + ' ' + (i + 1));
                        renderTesterSnapshot($(identificationItem).find('#headline-participant'), results[i].tester);
                        renderSingleResultsButton($(identificationItem).find('#btn-open-participant-results'), results[i].userId);
                        $(content).find('#scenario-item-container').append(identificationItem);

                        if (evaluatorResults && evaluatorResults.results) {
                            renderParticipantSummary(identificationItem, getAllAnnotations(results[i]), evaluatorResults.results.annotations);
                            renderAnnotatedNotes($(identificationItem).find('#annotated-notes'), getAnnotatedNotes(evaluatorResults.results.annotations));
                            renderNotes($(identificationItem).find('#notes'), evaluatorResults.notes);
                        }
                        renderObservation($(identificationItem).find('#observations'), studyData, evaluatorResults.observations);
                    }
                }

                function getAllAnnotations(results) {
                    var tempAnnotations = [];
                    var evaluatorResults = results.evaluator;
                    if (evaluatorResults && evaluatorResults.results && evaluatorResults.results.annotations) {
                        for (var i = 0; i < evaluatorResults.results.annotations.length; i++) {
                            var annotation = evaluatorResults.results.annotations[i];
                            annotation.source = 'evaluator';
                            tempAnnotations.push(annotation);
                        }
                    }

                    var observerResults = results.observer;
                    if (observerResults && observerResults.results && observerResults.results.annotations) {
                        for (var i = 0; i < observerResults.results.annotations.length; i++) {
                            var annotation = observerResults.results.annotations[i];
                            annotation.source = 'observer';
                            tempAnnotations.push(annotation);
                        }
                    }

                    var wizardResults = results.wizard;
                    if (wizardResults && wizardResults.results && wizardResults.results.annotations) {
                        for (var i = 0; i < wizardResults.results.annotations.length; i++) {
                            var annotation = wizardResults.results.annotations[i];
                            annotation.source = 'wizard';
                            tempAnnotations.push(annotation);
                        }
                    }
                    return tempAnnotations;
                }

                function renderParticipantSummary(container, annotations, evaluatorAnnotations) {
                    if (annotations && annotations.length > 0) {
                        // task section
                        var success = 0;
                        var help = 0;
                        var failure = 0;
                        var taskCanceled = 0;
                        var scenarioCanceled = 0;
                        var problemTaskIds = [];

                        // annotation section
                        var duringExecution = 0;
                        var afterExecution = 0;
                        var fromModerator = 0;
                        var fromObserver = 0;
                        var fromWizard = 0;

                        for (var i = 0; i < annotations.length; i++) {
                            if (annotations[i].action === ACTION_CUSTOM) {
                                afterExecution++;
                            } else {
                                duringExecution++;
                            }

                            if (annotations[i].source === 'evaluator' && annotations[i].action !== ACTION_CUSTOM) {
                                fromModerator++;
                            } else if (annotations[i].source === 'observer') {
                                fromObserver++;
                            } else if (annotations[i].source === 'wizard') {
                                fromWizard++;
                            }

                            if (annotations[i].action === ACTION_ASSESSMENT) {
                                switch (annotations[i].assessmentType) {
                                    case 'success':
                                        success++;
                                        break;
                                    case 'help':
                                        help++;
                                        problemTaskIds.push(annotations[i]);
                                        break;
                                    case 'failure':
                                        failure++;
                                        problemTaskIds.push(annotations[i]);
                                        break;
                                    case 'cancelTask':
                                        taskCanceled++;
                                        problemTaskIds.push(annotations[i]);
                                        break;
                                    case 'cancelScenario':
                                        scenarioCanceled++;
                                        break;
                                }
                            }
                        }

                        // task section
                        var taskSuccessRate = Math.min(100, parseInt(Math.round(success / studyData.tasks.length * 100)));
                        var taskFailureRate = 100 - taskSuccessRate;

                        $(container).find('#task-success-rate').text(taskSuccessRate + '%');
                        $(container).find('#task-failure-rate').text(taskFailureRate + '%');
                        $(container).find('#total-tasks').text(studyData.tasks.length);
                        $(container).find('#task-success').text(success > 0 ? success : '-');
                        $(container).find('#task-help').text(help > 0 ? help : '-');
                        $(container).find('#task-failure').text(failure > 0 ? failure : '-');
                        $(container).find('#task-canceled').text(taskCanceled > 0 ? taskCanceled : '-');
                        $(container).find('#scenario-canceled').text(scenarioCanceled > 0 ? scenarioCanceled : '-');

                        $(container).find('#task-problems').empty();
                        if (problemTaskIds.length > 0) {
                            problemTaskIds = sortByKey(problemTaskIds, 'timestamp');

                            for (var i = 0; i < problemTaskIds.length; i++) {
                                var taskStart = getAssessmentTaskStart(evaluatorAnnotations, problemTaskIds[i].time);
                                var linkListItem = $('#template-study-container').find('#link-list-item').clone().removeAttr('id');
                                $(linkListItem).find('.btn-delete-annotation').remove();
                                $(linkListItem).find('.btn-edit-annotation').remove();
                                $(linkListItem).find('.link-list-item-title').text(taskStart.task.title);
                                $(container).find('#task-problems').append(linkListItem);
                            }
                        } else {
                            $(container).find('#task-problems').text(translation.noTaskProblems);
                        }

                        // annotation section
                        $(container).find('#annotations-during-execution').text(duringExecution > 0 ? duringExecution : '-');
                        $(container).find('#annotations-after-execution').text(afterExecution > 0 ? afterExecution : '-');
                        $(container).find('#from-evaluator').text(fromModerator > 0 ? fromModerator : '-');
                        $(container).find('#from-observer').text(fromObserver > 0 ? fromObserver : '-');
                        $(container).find('#from-wizard').text(fromWizard > 0 ? fromWizard : '-');
                    }
                }

                function getAssessmentTaskStart(annotations, annotationTime) {
                    for (var i = annotations.length - 1; i >= 0; i--) {
                        if (annotations[i].action === ACTION_START_TASK && parseFloat(annotationTime) > parseFloat(annotations[i].time).toFixed(3)) {
                            return {task: getTaskById(annotations[i].taskId), time: annotations[i].time};
                        }
                    }
                    return null;
                }

                function getTaskById(id) {
                    if (studyData && studyData.tasks && studyData.tasks.length > 0) {
                        for (var i = 0; i < studyData.tasks.length; i++) {
                            if (parseInt(studyData.tasks[i].id) === parseInt(id)) {
                                return studyData.tasks[i];
                            }
                        }
                    }
                    return null;
                }
            }

            function renderIdentification(content, studyData, results) {
                if (studyData.identificationFor === 'gestures') {
                    if (results && results.length > 0) {
                        for (var i = 0; i < results.length; i++) {
                            var evaluatorResults = results[i].evaluator;
                            var identificationItem = $('#template-study-all-container').find('#identification-gesture-item').clone().css({marginTop: i === 0 ? '0px' : '80px'});
                            $(identificationItem).find('#headline-participant').text(translation.participant + ' ' + (i + 1));
                            renderTesterSnapshot($(identificationItem).find('#headline-participant'), results[i].tester);
                            renderSingleResultsButton($(identificationItem).find('#btn-open-participant-results'), results[i].userId);
                            $(content).find('#identification-item-container').append(identificationItem);

                            if (evaluatorResults && evaluatorResults.results) {
                                if (evaluatorResults.results.gestures && evaluatorResults.results.gestures.length > 0) {
                                    for (var j = 0; j < studyData.identification.length; j++) {
                                        var count = 0;
                                        var triggerHeadline = document.createElement('h5');
                                        $(triggerHeadline).addClass('col-xs-12').text(getTriggerById(studyData.identification[j].triggerId).title);
                                        $(identificationItem).find('#gestures-list-container').append(triggerHeadline);

                                        for (var k = 0; k < evaluatorResults.results.gestures.length; k++) {
                                            if (parseInt(studyData.identification[j].triggerId) === parseInt(evaluatorResults.results.gestures[k].triggerId)) {
                                                var gesture = getGestureById(evaluatorResults.results.gestures[k].id);
                                                if (gesture) {
                                                    count++;
                                                    var thumbnail = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12 col-sm-4 col-md-4 col-lg-4');
                                                    $(identificationItem).find('#gestures-list-container').append(thumbnail);
                                                }
                                            }
                                        }

                                        if (count === 0) {
                                            $(triggerHeadline).remove();
                                        } else {
                                            var badge = document.createElement('span');
                                            $(badge).addClass('badge').text(count === 1 ? count + ' ' + translation.gesture : count + ' ' + translation.gestures).css({marginLeft: '5px'});
                                            $(triggerHeadline).append(badge);
                                        }
                                    }
                                } else {
                                    // append alert, no gestures trimmed
                                    appendAlert(identificationItem, ALERT_NO_PHASE_DATA);
                                }

                                renderAnnotatedNotes($(identificationItem).find('#annotated-notes'), getAnnotatedNotes(evaluatorResults.results.annotations));
                                renderNotes($(identificationItem).find('#notes'), evaluatorResults.notes);
                            } else {
                                // append alert, no result data
                                appendAlert(identificationItem, ALERT_NO_PHASE_DATA);
                            }

                            renderObservation($(identificationItem).find('#observations'), studyData, evaluatorResults.observations);
                        }
                    }
                } else if (studyData.identificationFor === 'trigger') {
                    if (results && results.length > 0) {
                        for (var i = 0; i < results.length; i++) {
                            var evaluatorResults = results[i].evaluator;
                            var identificationItem = $('#template-study-all-container').find('#identification-trigger-item').clone().css({marginTop: i === 0 ? '0px' : '80px'});
                            $(identificationItem).find('#headline-participant').text(translation.participant + ' ' + (i + 1));
                            renderTesterSnapshot($(identificationItem).find('#headline-participant'), results[i].tester);
                            renderSingleResultsButton($(identificationItem).find('#btn-open-participant-results'), results[i].userId);
                            $(content).find('#identification-item-container').append(identificationItem);

                            if (evaluatorResults && evaluatorResults.results) {
                                if (evaluatorResults.results.trigger && evaluatorResults.results.trigger.length > 0) {
                                    for (var j = 0; j < studyData.identification.length; j++) {
                                        var count = 0;

                                        for (var k = 0; k < evaluatorResults.results.trigger.length; k++) {
                                            if (parseInt(studyData.identification[j].gestureId) === parseInt(evaluatorResults.results.trigger[k].gestureId)) {
                                                count++;

                                                var gesture = getGestureById(evaluatorResults.results.trigger[k].gestureId);
                                                var gestureItem = getGestureCatalogListThumbnail(gesture, null, 'col-xs-6 col-lg-4');
                                                $(identificationItem).find('#trigger-list-container').append(gestureItem);

                                                var trigger = evaluatorResults.results.trigger[k].preferredTrigger.answers[0].answer;
                                                var item = $('#template-study-container').find('#trigger-identification').clone();
                                                $(item).prepend(gestureItem);
                                                $(item).find('#trigger-name .address').text(translation.trigger + ':');
                                                $(item).find('#trigger-name .text').text(trigger.openAnswer);
                                                $(item).find('#trigger-justification .address').text(translation.justification + ':');
                                                $(item).find('#trigger-justification .text').text(trigger.justification);

                                                $(identificationItem).find('#trigger-list-container').append(item);
                                            }
                                        }
                                    }
                                } else {
                                    // append alert, no gestures trimmed
                                    appendAlert(identificationItem, ALERT_NO_PHASE_DATA);
                                }

                                renderAnnotatedNotes($(identificationItem).find('#annotated-notes'), getAnnotatedNotes(evaluatorResults.results.annotations));
                                renderNotes($(identificationItem).find('#notes'), evaluatorResults.notes);
                            } else {
                                // append alert, no result data
                                appendAlert(identificationItem, ALERT_NO_PHASE_DATA);
                            }

                            renderObservation($(identificationItem).find('#observations'), studyData, evaluatorResults.observations);
                        }
                    }
                }
            }

            function renderExploration(content, phaseData, results) {
//                console.log(phaseData, results);
                if (phaseData.explorationType === 'gestures') {
                    if (results && results.length > 0 && phaseData.askPreferredGesture === "yes") {
                        var allAnswers = {answers: [], questions: null};
                        for (var i = 0; i < results.length; i++) {
                            var evaluatorResults = results[i].evaluator;
                            var testerResults = results[i].tester;
                            var explorationItem = $('#template-study-all-container').find('#exploration-gesture-item').clone().css({marginTop: '80px'});
                            $(explorationItem).find('#headline-participant').text(translation.participant + ' ' + (i + 1));
                            renderTesterSnapshot($(explorationItem).find('#headline-participant'), results[i].tester);
                            renderSingleResultsButton($(explorationItem).find('#btn-open-participant-results'), results[i].userId);
                            $(content).find('#exploration-item-container').append(explorationItem);

                            if (testerResults) {
                                var answerItem = $('#template-study-container').find('#exploration-answer-item-for-gesture').clone().removeClass('id');
                                $(explorationItem).find('#item-view').append(answerItem);

                                var questionnaire = [];
                                var answers = [];
                                for (var j = 0; j < testerResults.answers.length; j++) {
                                    var trigger = getTriggerById(testerResults.answers[j].triggerId);

                                    var preferredGesture = testerResults.answers[j].preferredGestures[0];
                                    answers.push(preferredGesture);

                                    var questionText = translation.askPreferredGesturesForTrigger;
                                    questionText = questionText.replace('{trigger}', trigger.title);

                                    var gestures = phaseData.exploration[j].gestures;
                                    var options = [];
                                    for (var k = 0; k < gestures.length; k++) {
                                        options.push(getGestureById(gestures[k]));
                                    }
                                    var question = {id: preferredGesture.id, dimension: DIMENSION_ANY, format: GROUPING_QUESTION_OPTIONS, question: questionText, parameters: {multiselect: 'yes', optionSource: 'gestures', justification: 'yes', justificationFor: 'selectOne', optionalanswer: 'yes', options: options}};
                                    questionnaire.push(question);
                                }

                                allAnswers.answers.push({tester: {answers: answers}});
                                renderQuestionnaireAnswers($(answerItem), questionnaire, {answers: answers}, true, false);
                                if (i === 0) {
                                    allAnswers.questions = questionnaire;
                                }
                            }

                            if (evaluatorResults && evaluatorResults.results) {
                                renderAnnotatedNotes($(explorationItem).find('#annotated-notes'), getAnnotatedNotes(evaluatorResults.results.annotations));
                                renderNotes($(explorationItem).find('#notes'), evaluatorResults.notes);
                            }
                            renderObservation($(explorationItem).find('#observations'), phaseData, evaluatorResults.observations);
                        }

                        // render summary questionnaire
                        renderQuestionnaireResults(content.find('#summary'), allAnswers.questions, allAnswers.answers);
                    } else {
                        appendAlert($(content).find('#summary'), ALERT_NO_PHASE_DATA);
                    }
                } else if (phaseData.explorationType === 'trigger') {
                    if (results && results.length > 0 && phaseData.askPreferredTrigger === "yes") {
                        var allAnswers = {answers: [], questions: []};
                        for (var i = 0; i < results.length; i++) {
                            var evaluatorResults = results[i].evaluator;
                            var testerResults = results[i].tester;
                            var explorationItem = $('#template-study-all-container').find('#exploration-gesture-item').clone().css({marginTop: '80px'});
                            $(explorationItem).find('#headline-participant').text(translation.participant + ' ' + (i + 1));
                            renderTesterSnapshot($(explorationItem).find('#headline-participant'), results[i].tester);
                            renderSingleResultsButton($(explorationItem).find('#btn-open-participant-results'), results[i].userId);
                            $(content).find('#exploration-item-container').append(explorationItem);

                            if (testerResults) {
                                var questionnaire = [];
                                var answers = [];
                                for (var j = 0; j < testerResults.answers.length; j++) {
                                    var gesture = getGestureById(testerResults.answers[j].gestureId);
                                    var gestureItem = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12 col-sm-4 col-md-4 col-lg-3');

                                    var answerItem = $('#template-study-container').find('#exploration-answer-item-for-trigger').clone().removeClass('id');
                                    $(explorationItem).find('#item-view').append(answerItem);
                                    $(answerItem).find('#gestures-list-container').prepend(gestureItem);

                                    if (j > 0) {
                                        $(answerItem).css({marginTop: '40px'});
                                    }

                                    var preferredTrigger = testerResults.answers[j].preferredTrigger[0];
                                    var answer = preferredTrigger;
                                    var questionnaire = [];
                                    var question = {id: preferredTrigger.id, dimension: DIMENSION_ANY, format: GROUPING_QUESTION_OPTIONS, question: translation.askPreferredTriggerForGesture, parameters: {multiselect: 'yes', optionSource: 'triggers', justification: 'yes', justificationFor: 'selectOne', optionalanswer: 'yes'}};
//                                    var triggerOptions = [];
//                                    
//                                    console.log(phaseData.exploration[i])
//                                    for (var k = 0; k < phaseData.exploration[i].trigger.length; k++) {
//                                        triggerOptions.push(getTriggerById(phaseData.exploration[i].trigger[k]));
//                                    }

                                    answers.push(answer);
                                    questionnaire.push(question);
                                    if (i === 0) {
                                        allAnswers.questions.push(question);
                                    }
                                    renderQuestionnaireAnswers($(answerItem), questionnaire, {answers: [answer]}, true, false);
                                }

                                allAnswers.answers.push({tester: {answers: answers}});
                            }

                            if (evaluatorResults && evaluatorResults.results) {
                                renderAnnotatedNotes($(explorationItem).find('#annotated-notes'), getAnnotatedNotes(evaluatorResults.results.annotations));
                                renderNotes($(explorationItem).find('#notes'), evaluatorResults.notes);
                            }
                            renderObservation($(explorationItem).find('#observations'), phaseData, evaluatorResults.observations);
                        }

                        // render summary questionnaire
                        $(content).find('#summary-item-container').empty();
                        for (var j = 0; j < allAnswers.questions.length; j++) {
                            var summaryItem = $('#template-study-container').find('#exploration-answer-item-for-trigger').clone();
                            $(content).find('#summary-item-container').append(summaryItem);
                            var gesture = getGestureById(testerResults.answers[j].gestureId);
                            var gestureItem = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12 col-sm-4 col-md-4 col-lg-3');
                            $(summaryItem).find('#gestures-list-container').prepend(gestureItem);
                            renderQuestionnaireResults(summaryItem, [allAnswers.questions[j]], allAnswers.answers);
                            if (j > 0) {
                                $(summaryItem).css({marginTop: '40px'});
                            }
                        }
                    } else {
                        appendAlert($(content).find('#summary'), ALERT_NO_PHASE_DATA);
                    }
                }


                return null;

                if (testerResults.answers) {
                    $(container).find('#extraction-item-container').removeClass('hidden');
                    $(container).find('#headline-extraction-items').text(phaseData.explorationType === 'trigger' ? translation.favoriteTrigger : translation.favoriteGestures);

                    if (phaseData.explorationType === 'trigger') {
                        for (var i = 0; i < testerResults.answers.length; i++) {
                            var gesture = getGestureById(testerResults.answers[i].gestureId);
                            var gestureItem = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12 col-sm-6 col-md-4 col-lg-3');

                            var answerItem = $('#template-study-container').find('#exploration-answer-item-for-trigger').clone().removeClass('id');
                            $(container).find('#item-view').append(answerItem);
                            $(answerItem).find('#gestures-list-container').prepend(gestureItem);

                            if (i > 0) {
                                $(answerItem).css({marginTop: '40px'});
                            }

                            var preferredTrigger = testerResults.answers[i].preferredTrigger[0];
                            var answer = preferredTrigger;
                            var questionnaire = [];
                            var question = {id: preferredTrigger.id, dimension: DIMENSION_ANY, format: GROUPING_QUESTION_OPTIONS, question: translation.askPreferredTriggerForGesture, parameters: {multiselect: 'yes', optionSource: 'triggers', justification: 'yes', justificationFor: 'selectOne', optionalanswer: 'yes'}};
                            var triggerOptions = [];

                            for (var j = 0; j < phaseData.exploration[i].trigger.length; j++) {
                                triggerOptions.push(getTriggerById(phaseData.exploration[i].trigger[j]));
                            }

                            questionnaire.push(question);
                            renderQuestionnaireAnswers($(answerItem), questionnaire, {answers: [answer]}, true, false);
                        }
                    } else {
                        var answerItem = $('#template-study-container').find('#exploration-answer-item-for-gesture').clone().removeClass('id');
                        $(container).find('#item-view').append(answerItem);

                        var questionnaire = [];
                        var answers = [];
                        for (var i = 0; i < testerResults.answers.length; i++) {
                            var trigger = getTriggerById(testerResults.answers[i].triggerId);

                            var preferredGesture = testerResults.answers[i].preferredGestures[0];
                            answers.push(preferredGesture);

                            var questionText = translation.askPreferredGesturesForTrigger;
                            questionText = questionText.replace('{trigger}', trigger.title);

                            var gestures = phaseData.exploration[i].gestures;
                            var options = [];
                            for (var j = 0; j < gestures.length; j++) {
                                options.push(getGestureById(gestures[j]));
                            }
                            var question = {id: preferredGesture.id, dimension: DIMENSION_ANY, format: GROUPING_QUESTION_OPTIONS, question: questionText, parameters: {multiselect: 'yes', optionSource: 'gestures', justification: 'yes', justificationFor: 'selectOne', optionalanswer: 'yes', options: options}};
                            questionnaire.push(question);
                        }

                        renderQuestionnaireAnswers($(answerItem), questionnaire, {answers: answers}, true, false);
                    }
                }

                renderObservation($(container).find('#observations'), phaseData, getObservationResults($('#phase-results-nav').find('.active').attr('id')));
            }

            function renderObservation(target, studyData, observationResults) {
                console.log('renderObservation', target, studyData, observationResults);
                if (studyData.observations && studyData.observations.length > 0) {
                    renderQuestionnaireAnswers(target, studyData.observations, observationResults && observationResults.length > 0 ? {answers: observationResults[0].answers} : null);

                } else {
                    $(target).addClass('hidden');
                }
            }

            function renderAnnotatedNotes(target, annotations) {
                if (annotations && annotations.length > 0) {
                    var list = document.createElement('ul');
                    $(list).css({listStylePosition: 'inside', paddingLeft: 0}).addClass('text');
                    $(target).find('#annotated-notes-container').empty().append(list);

                    for (var i = 0; i < annotations.length; i++) {
                        var listItem = document.createElement('li');
                        $(listItem).text(annotations[i].content).addClass(annotations[i].annotationColor);
                        $(list).append(listItem);
                    }
                } else {
                    appendAlert(target, ALERT_NO_PHASE_DATA);
                }
            }

            function getAnnotatedNotes(annotations) {
                if (annotations && annotations.length > 0) {
                    var tempAnnotations = [];
                    for (var i = 0; i < annotations.length; i++) {
                        if (annotations[i].action === ACTION_NOTE || annotations[i].action === ACTION_CUSTOM) {
                            tempAnnotations.push(annotations[i]);
                        }
                    }
                    if (tempAnnotations.length > 0) {
                        tempAnnotations = sortByKey(tempAnnotations, 'time');
                        return tempAnnotations;
                    }
                }
                return null;
            }

            function renderNotes(target, notes) {
                if (notes && notes.note) {
                    $(target).find('#note-container').text(notes.note);
                } else {
                    appendAlert(target, ALERT_NO_PHASE_DATA);
                }
            }

            function renderTesterSnapshot(target, testerData) {
                if (testerData && testerData.snapshot) {
                    $(target).css({cursor: 'pointer'});
                    $(target).unbind('mouseenter').bind('mouseenter', function (event) {
                        event.preventDefault();
                        renderImagePopoverPreview(testerData.snapshot, function (popover) {
                            var top = $(target).offset().top - popover.height() - 2;
                            var left = $(target).offset().left + parseInt(((target.width() - popover.width()) / 2));
                            popover.css({left: left, top: top, zIndex: 10000, position: 'absolute'});
                            TweenMax.to(popover, .3, {autoAlpha: 1});
                        });
                    });

                    $(target).unbind('mouseleave').bind('mouseleave', function (event) {
                        event.preventDefault();
                        resetImagePopover();
                    });
                }
            }

            function renderSingleResultsButton(button, userId) {
                $(button).unbind('click').bind('click', function (event) {
                    event.preventDefault();

                    var query = getQueryParams(document.location.search);
                    var status = getWindowStatusHash();
                    var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                    clearLocalItems();
                    goto('study-participant.php?studyId=' + query.studyId + '&participantId=' + userId + '&h=' + hash + "&joinedConv=" + joinedRoom + getWebRTCSources() + '#' + status);
                });
            }

            //        function addObservationsDropdown(container) {
            //            var dropdown = $('#template-study-container').find('#add-observations-dropdown').clone().removeAttr('id');
            //            $(container).find('#headline-observations').after(dropdown);
            //            $(dropdown).find('#btn-add-observation').on('click', function (event) {
            //                event.preventDefault();
            //                if (event.handled !== true && dropdown.find('.chosen').attr('id') !== 'unselected') {
            //                    event.handled = true;
            //                    var format = dropdown.find('.chosen').attr('id');
            //                    var item = $('#template-study-editable-container').find('#' + format).clone();
            //                    $(container).find('#observations-container').prepend(item);
            //                    checkCurrentListState($(container).find('#observations-container'));
            //                    updateBadges($(container).find('#observations-container'), format);
            //                    TweenMax.from(item, .3, {y: -20, opacity: 0, clearProps: 'all'});
            //                }
            //            });
            //        }


            $('#btn-introduction').on('click', function (event) {
                event.preventDefault();
                $('#custom-modal').attr('data-help-items-key', 'introductionParticipant');
                $('#custom-modal').attr('data-help-context', 'participant');
                $('#custom-modal').attr('data-help-show-tutorial', parseInt(<?php echo $_SESSION['tutorialParticipant'] ?>));
                loadHTMLintoModal('custom-modal', 'externals/modal-introduction.php', 'modal-lg');
            }
            );

            //        $('.pretest-select').unbind('change').bind('change', function (event) {
            //            event.preventDefault();
            //            if (!$(this).hasClass('disabled')) {
            //                var participantId = $(this).attr('data-participant-id');
            //                var evaluatorId = $(this).attr('data-evaluator-id') || null;
            //                var executionPhase = $(this).find('.btn-option-checked').attr('id');
            //
            ////                console.log('pretest selection changed', participantId, evaluatorId, executionPhase);
            //                updateExecutionPhase(evaluatorId ? {participantId: participantId, evaluatorId: evaluatorId, executionPhase: executionPhase} : {participantId: participantId, executionPhase: executionPhase}, function (result) {
            //
            //                });
            //            }
            //        });

        </script>
    </body>
</html>
