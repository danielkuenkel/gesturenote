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
        <script src="js/study-execution.js"></script>

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
        <div id="custom-modal" class="modal fade custom-modal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content root">
                </div>
            </div>
        </div>


        <!-- main content -->
        <div class="container mainContent" style="margin-top: 0px;" id="general-view">
            <div>
                <h2 id="main-headline" style="margin-top: 0; display: inline"></h2>
                <a role="button" class="pull-right" id="btn-introduction" style=" clear: both;"><i class="fa fa-support"></i> <?php echo $lang->help ?></a>
            </div>

            <hr>

            <nav>
                <ul class="pager"style="margin-bottom: 2px">
                    <li class="btn-sm btn-prev-participant disabled pull-left" style="padding: 0"><a href="#"><span aria-hidden="true">&larr;</span> <?php echo $lang->previousParticipant ?></a></li>
                    <li class="btn-sm btn-next-participant disabled pull-right" style="padding: 0"><a href="#"><?php echo $lang->nextParticipant ?> <span aria-hidden="true">&rarr;</span></a></li>
                </ul>
            </nav>

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

                        <div class="form-group form-group-margin-top root pretest-select" style="opacity:0">
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

                        </div>

                        <div class="btn-group-vertical btn-block" id="phase-results-nav" style="margin-top: 20px"></div>
                        <div class="btn-group-vertical btn-block" id="delete-results-nav" style="margin-top: 20px">
                            <button class="btn btn-danger btn-shadow" id="btn-delete-result" style="opacity: 0"><i class="fa fa-trash"></i> <?php echo $lang->deleteParticipantResults ?></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div id="phase-result"></div>
                </div>
            </div>
        </div>

        <div class="container mainContent" id="pager-bottom" style="margin-top: 0px; padding-bottom: 0px">
            <nav>
                <ul class="pager"style="margin-bottom: 2px">
                    <li class="btn-sm btn-prev-participant disabled pull-left" style="padding: 0"><a href="#"><span aria-hidden="true">&larr;</span> <?php echo $lang->previousParticipant ?></a></li>
                    <li class="btn-sm btn-next-participant disabled pull-right" style="padding: 0"><a href="#"><?php echo $lang->nextParticipant ?> <span aria-hidden="true">&rarr;</span></a></li>
                </ul>
            </nav>
        </div>

        <div id="ueq-arrows-container" style="position: absolute; top:0px; left:0px"></div>


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
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();

                var query = getQueryParams(document.location.search);
                var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');

                var showTutorial = parseInt(<?php echo $_SESSION['tutorialParticipant'] ?>);
                if (showTutorial === 1) {
                    $('#btn-introduction').click();
                }

                if (query.studyId && query.participantId && query.h === hash) {
                    $('.breadcrumb #btn-study').on('click', function (event) {
                        event.preventDefault();
                        goto('study.php?studyId=' + query.studyId + '&h=' + hash + '#participants');
                    });

                    $('body').find('.main-burger-menu .btn-study').removeClass('hidden');
                    $('body').find('.main-burger-menu .btn-study').unbind('click').bind('click', function (event) {
                        event.preventDefault();
                        goto('study.php?studyId=' + query.studyId + '&h=' + hash + '#participants');
                    });

                    getStudyParticipant({studyId: query.studyId, participantId: query.participantId}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            console.log(result);
                            setLocalItem(GESTURE_CATALOG, result.gestureCatalog);
                            getGestureSets(function (setResult) {
                                setStudyData(result);
                                setLocalItem(GESTURE_SETS, setResult.gestureSets);
                                renderData(result);
                            });
                        }
                    });
                }
                animateBreadcrump();
            }

            function renderData(data) {
                var studyData = data.studyData;
                var resultData = data.resultData;
                var results = resultData.results;

                $('.pretest-select').attr('data-participant-id', data.resultData.id);
                $('.pretest-select').attr('data-evaluator-id', null);
                if (data.evaluatorData) {
                    $('.pretest-select').attr('data-evaluator-id', data.evaluatorData.id);
                }
                $('.pretest-select').addClass('disabled');
                $('.pretest-select').find('#' + data.resultData.executionPhase).click();
                $('.pretest-select').removeClass('disabled');

                // general data view
                $('#execution-date').text(convertSQLTimestampToDate(resultData.created).toLocaleString());
                $('#main-headline').text(studyData.generalData.title);

                if (results.aborted === 'no' && results.studySuccessfull === 'yes') {
                    $('#phase-results').find('#execution-success').removeClass('hidden');
                    $('#phase-results').find('#execution-success .label-text').text(translation.studySuccessful);

                    var start = null;
                    var end = null;
                    for (var j = 0; j < results.phases.length; j++) {
                        if (results.phases[j].startTime) {
                            if (results.phases[j].format === LETTER_OF_ACCEPTANCE) {
                                start = parseInt(results.phases[j].startTime);
                            } else if (results.phases[j].format === THANKS) {
                                end = parseInt(results.phases[j - 1].endTime);
                            }
                        }
                    }

                    if (start && end) {
                        var duration = getTimeBetweenTimestamps(start, end);
                        $('#phase-results').find('#execution-duration').removeClass('hidden');
                        $('#phase-results').find('#execution-duration .label-text').text(getTimeString(duration, true));
                    }
                } else {
                    $('#phase-results').find('#execution-fault').removeClass('hidden');
                    $('#phase-results').find('#execution-fault .label-text').text(translation.studyFault);
                }

                // participants navigation view
                getStudyResults({studyId: data.id}, function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        if (result.studyResults && result.studyResults.length > 1) { // check if there are study results
                            var query = getQueryParams(document.location.search);
                            var disablePrevButton = false;
                            var disableNextButton = false;
                            var nextParticipantId = null;
                            var prevParticipantId = null;

                            for (var i = 0; i < result.studyResults.length; i++) {
                                if (query.participantId === result.studyResults[i].userId) {
                                    if (i === 0) {
                                        disablePrevButton = true;
                                        nextParticipantId = result.studyResults[i + 1].userId;
                                    } else if (i === result.studyResults.length - 1) {
                                        disableNextButton = true;
                                        prevParticipantId = result.studyResults[i - 1].userId;
                                    } else {
                                        nextParticipantId = result.studyResults[i + 1].userId;
                                        prevParticipantId = result.studyResults[i - 1].userId;
                                    }
                                    break;
                                }

                            }

                            function getParticipantStatusHash() {
                                var status = window.location.hash.substr(1);
                                var statusAddressMatch = statusAddressMatchIndex(status);
                                var statusHash = '';
                                if (status !== '' && statusAddressMatch !== null) {
                                    statusHash = statusAddressMatch.id;
                                }
                                return statusHash;
                            }

                            $('#pageBody').find('.btn-prev-participant').removeClass('disabled').unbind('click');
                            $('#pageBody').find('.btn-next-participant').removeClass('disabled').unbind('click');
                            if (disablePrevButton) {
                                $('#pageBody').find('.btn-prev-participant').addClass('disabled');
                                $('#pageBody').find('.btn-next-participant').bind('click', function (event) {
                                    event.preventDefault();
                                    var status = getParticipantStatusHash();
                                    clearLocalItems();
                                    goto('study-participant.php?studyId=' + query.studyId + '&participantId=' + nextParticipantId + '&h=' + query.h + '#' + status);
                                });
                            } else if (disableNextButton) {
                                $('#pageBody').find('.btn-next-participant').addClass('disabled');
                                $('#pageBody').find('.btn-prev-participant').bind('click', function (event) {
                                    event.preventDefault();
                                    var status = getParticipantStatusHash();
                                    clearLocalItems();
                                    goto('study-participant.php?studyId=' + query.studyId + '&participantId=' + prevParticipantId + '&h=' + query.h + '#' + status);
                                });
                            } else {
                                $('#pageBody').find('.btn-next-participant').bind('click', function (event) {
                                    event.preventDefault();
                                    var status = getParticipantStatusHash();
                                    clearLocalItems();
                                    goto('study-participant.php?studyId=' + query.studyId + '&participantId=' + nextParticipantId + '&h=' + query.h + '#' + status);
                                });

                                $('#pageBody').find('.btn-prev-participant').bind('click', function (event) {
                                    event.preventDefault();
                                    var status = getParticipantStatusHash();
                                    clearLocalItems();
                                    goto('study-participant.php?studyId=' + query.studyId + '&participantId=' + prevParticipantId + '&h=' + query.h + '#' + status);
                                });
                            }
                        } else {
                        }
                    }
                });

                // phase nav view
                TweenMax.to($('.pretest-select'), .3, {opacity: 1, clearProps: 'all'});
                if (studyData.phases && studyData.phases.length > 0) {

                    for (var i = 0; i < studyData.phases.length; i++) {
                        var navItem = document.createElement('button');
                        $(navItem).attr('role', 'presentation');
                        $(navItem).addClass('btn btn-default');
                        $(navItem).attr('id', studyData.phases[i].id);
                        $('#phase-results-nav').append(navItem);

                        var text = document.createElement('span');
                        $(text).text(studyData.phases[i].title);
                        $(navItem).append(text);

                        TweenMax.from($(navItem), .3, {delay: 0.2 + (i * .05), y: -10, opacity: 0, clearProps: 'all'});
                    }

                    TweenMax.to($('#btn-delete-result'), {opacity: 0});
                    TweenMax.to($('#btn-delete-result'), .3, {delay: 0.4 + (studyData.phases.length * .05), opacity: 1, clearProps: 'all'});

                    var status = window.location.hash.substr(1);
                    var statusAddressMatch = statusAddressMatchIndex(status);
                    if (status !== '' && statusAddressMatch !== null) {
                        $('#phase-results-nav').find('#' + statusAddressMatch.id).click();
                    } else {
                        $('#phase-results-nav').children().first().click();
                    }

                    var study = getLocalItem(STUDY);

                    if (study.isOwner === 'false' || study.isOwner === false) {
//                        console.log(study, study.isOwner);
                        $('#btn-delete-result').remove();
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
                            var visibleHeight = $(window).height() - 100 - 35;
                            var scrollTop = $(window).scrollTop();

                            var scrollOffset = 0;
                            if (barHeight > visibleHeight) {
                                var scrollOffset = barHeight - visibleHeight;
                            }

                            if (scrollTop >= 220 + scrollOffset) {
                                var top = 46 - scrollOffset;
                                $(navigationBarContent).addClass('affix');
                                $(navigationBarContent).css({top: top + 'px'});
                                if (scrollOffset > 0) {
                                    $('#pager-bottom').addClass('hidden');
                                }
                            } else {
                                $(navigationBarContent).removeClass('affix');
                                $(navigationBarContent).css({top: ''});
                                $('#pager-bottom').removeClass('hidden');
                            }
                        } else {
                            $(navigationBarContent).removeClass('affix');
                            $(navigationBarContent).css({top: ''});
                            $('#pager-bottom').removeClass('hidden');
                        }
                    });

                    $('#btn-delete-result').unbind('click').bind('click', function (event) {
                        event.preventDefault();
                        var button = $(this);

                        if (!$(this).hasClass('disabled')) {
                            lockButton(button, true, 'fa-trash');
                            loadHTMLintoModal('custom-modal', 'externals/modal-delete-study-result.php', 'modal-md');
                            var study = getLocalItem(STUDY);
                            var tester = getLocalItem(STUDY_RESULTS);
//                            console.log(study, tester);

                            $('#custom-modal').unbind('deleteData').bind('deleteData', function () {
                                deleteStudyResult({studyId: study.id, testerId: tester.userId}, function (result) {
                                    unlockButton(button, true, 'fa-trash');
                                    if (result.status === RESULT_SUCCESS) {
                                        var prevParticipant = $('#pageBody').find('.btn-prev-participant');
                                        var nextParticipant = $('#pageBody').find('.btn-next-participant');
                                        if (!$(nextParticipant).hasClass('disabled')) {
                                            $(nextParticipant).click();
                                        } else if (!$(prevParticipant).hasClass('disabled')) {
                                            $(prevParticipant).click();
                                        } else {
                                            $('.breadcrumb #btn-study').click();
                                        }
                                    } else {
                                        console.warn('ERROR: ', result.status);
                                    }
                                });
                            });

                            $('#custom-modal').unbind('cancel').bind('cancel', function () {
                                unlockButton(button, true, 'fa-trash');
                            });
                        }
                    });
                }
            }

            $(document).on('click', '#phase-results-nav button', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('active')) {
                    cacheNotes(true);
                    $(this).parent().children().removeClass('active');
                    $(this).addClass('active');
                    var selectedId = $(this).attr('id');
                    $("html, body").animate({scrollTop: 0}, 100);
                    window.location.hash = selectedId;
                    renderStudyPhaseResult(selectedId);
                }
            });

            function renderStudyPhaseResult(phaseId) {
                var phaseData = getLocalItem(phaseId + '.data');
                var testerResults = getLocalItem(phaseId + '.results');
                var evaluatorResults = getLocalItem(phaseId + '.evaluator');
                var study = getLocalItem(STUDY);
                console.log(phaseData, testerResults, evaluatorResults);

                if (phaseData && testerResults && ((study.surveyType === TYPE_SURVEY_MODERATED && ((evaluatorResults && evaluatorResults.startTime) || (testerResults && testerResults.startTime))) || (study.surveyType === TYPE_SURVEY_UNMODERATED && testerResults && testerResults.startTime))) {
                    var content = $('#template-study-container').find('#' + testerResults.format).clone().removeAttr('id');
                    $(content).find('#headline').text(translation.formats[testerResults.format].text);
                    $('#phase-result').empty().append(content);

                    var executionTime = study.surveyType === TYPE_SURVEY_MODERATED ? getTimeBetweenTimestamps(evaluatorResults.startTime, evaluatorResults.endTime) : getTimeBetweenTimestamps(testerResults.startTime, testerResults.endTime);
                    console.log(executionTime);
                    if (!isEmpty(executionTime)) {
                        var badge = document.createElement('span');
                        $(badge).addClass('badge pull-right');
                        $(badge).text(translation.lapse + ': ' + getTimeString(executionTime, true));
                        $(content).find('#headline').append(badge);
                    }

                    if (translation.formats[testerResults.format].notes === 'yes') {
                        var notesData = getLocalItem(phaseId + '.notes');
                        var notes = $('#template-study-container').find('#notes').clone();
                        $('#phase-result').append(notes);
                        TweenMax.from(notes, .2, {delay: .1, opacity: 0, y: -60});

                        if (notesData) {
                            notes.find('#notes-input').val(notesData);
                        }

                        notes.find('#notes-input').on('input', function (event) {
                            event.preventDefault();
                            cacheNotes();
                        });
                    }

//                    console.log('content', content);
                    // check and add recorded stream data
                    if (isWebRTCPlaybackNeededForPhaseStep(testerResults)) {
//                        console.log('web rtc is needed for phase step');

                        if (testerResults && testerResults.recordUrl && testerResults.recordUrl !== '') {
                            resultsPlayer = new RTCResultsPlayer(testerResults, evaluatorResults, phaseData, executionTime, content);
                            $(resultsPlayer.player).unbind('initialized').bind('initialized', function (event) {
                                event.preventDefault();
                                $(resultsPlayer.player).unbind('initialized');
//                                console.log('results player initialized');
                                switchDataRendering();
                            });

                            if (getBrowser() !== 'Safari') {
                                $(content).find('#horizontalLine').after(resultsPlayer.domElement);
                            } else {
                                appendAlert(content, ALERT_WEBM_UNSUPPORTED);
                            }
                        } else {
                            appendAlert(content, ALERT_NO_RECORD);
                        }
                    } else {
//                        console.log('switch data rendering else');
                        switchDataRendering();
                    }

                    $(content).css({y: 0, opacity: 1});
                    TweenMax.from(content, .2, {opacity: 0, y: -60});

                    function switchDataRendering() {
//                        console.log('switch data rendering');
                        switch (testerResults.format) {
                            case LETTER_OF_ACCEPTANCE:
                                renderLetterOfAcceptance(content, phaseData, testerResults);
                                break;
                            case THANKS:
                                renderThanks(content, phaseData);
                                break;
                            case QUESTIONNAIRE:
                                renderQuestionnaireAnswers(content, phaseData, testerResults, true);
                                break;
                            case INTERVIEW:
                                renderQuestionnaireAnswers(content, phaseData, evaluatorResults, true);
                                break;
                            case SUS:
                                renderSUS(content, phaseData, testerResults);
                                break;
                            case UEQ:
                                renderQuestionnaireAnswers(content, phaseData, testerResults, true);
                                renderUEQ(content, phaseData, testerResults);
                                break;
                            case GUS_SINGLE_GESTURES:
                                renderSingleGUS(content, phaseData, testerResults);
                                break;
                            case GUS_MULTIPLE_GESTURES:
                                renderQuestionnaireAnswers(content, getAssembledItems(phaseData.gus), testerResults, true);
                                break;
                            case GESTURE_TRAINING:
                                renderGestureTraining(content, phaseData, testerResults, evaluatorResults);
                                break;
                            case SLIDESHOW_GESTURES:
                                renderGestureSlideshow(content, phaseData, testerResults, evaluatorResults);
                                break;
                            case SLIDESHOW_TRIGGER:
                                renderTriggerSlideshow(content, phaseData, testerResults);
                                break;
                            case PHYSICAL_STRESS_TEST:
                                renderPhysicalStressTest(content, phaseData, testerResults);
                                break;
                            case SCENARIO:
                                renderScenario(content, phaseData, testerResults);
                                break;
                            case IDENTIFICATION:
                                renderIdentification(content, phaseData, testerResults);
                                break;
                            case EXPLORATION:
                                renderExploration(content, phaseData, testerResults, evaluatorResults);
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

            var saveTimer = null;
            function cacheNotes(instantSave) {
                var phaseId = $('#phase-results-nav').find('.active').attr('id');

                if (phaseId) {
                    var phaseResults = getLocalItem(phaseId + '.results');
                    if (phaseResults && translation.formats[phaseResults.format].notes === 'yes') {
                        var note = $('#phase-result').find('#notes-input').val();
                        setLocalItem(phaseId + '.notes', note);

                        var phases = getLocalItem(STUDY_PHASE_STEPS);
                        var notesArray = new Array();
                        for (var i = 0; i < phases.length; i++) {
                            var phaseNote = getLocalItem(phases[i].id + '.notes');
                            if (phaseNote) {
                                notesArray.push({phaseId: phases[i].id, note: phaseNote});
                            }
                        }

                        clearTimeout(saveTimer);
                        if (instantSave === true) {
                            saveNotes({studyId: getLocalItem(STUDY).id, testerId: getLocalItem(STUDY_RESULTS).userId, notes: notesArray});
                        } else {
                            saveTimer = setTimeout(function () {
                                saveNotes({studyId: getLocalItem(STUDY).id, testerId: getLocalItem(STUDY_RESULTS).userId, notes: notesArray});
                            }, 1000);
                        }
                    }
                }
            }

            function renderStudyGestures(gestures) {
                $('#study-gestures-catalog').removeClass('hidden');
                $('#study-gestures-catalog .address').text(translation.studyCatalogs.gestures);

                for (var i = 0; i < gestures.length; i++) {
                    var item = getGestureCatalogListThumbnail(gestures[i]);
                    $('#study-gestures-catalog .list-container').append(item);
                    TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                }
            }

            function renderLetterOfAcceptance(content, studyData, resultsData) {
                if (resultsData.accepted === 'yes') {
                    $(content).find('#letter-accepted').removeClass('hidden');
                } else {
                    $(content).find('#letter-not-accepted').removeClass('hidden');
                }
                $(content).find('#letter-text').text(studyData);
            }

            function renderThanks(content, studyData) {
                $(content).find('#thanks-text').text(studyData);
            }

            function renderSUS(content, studyData, resultsData) {
//                console.log(studyData, resultsData);
                renderQuestionnaireAnswers(content, studyData, resultsData, true);

                // calculate the average sus score
                var susResultsValid = true;
                var count = 0;
                for (var i = 0; i < resultsData.answers.length; i++) {
                    console.log(resultsData.answers[i], resultsData.answers[i].answer.scales);
                    if (parseInt(resultsData.answers[i].answer.scales) !== -1) {
                        var negative = studyData[i].parameters.negative === 'yes';
                        if (negative) {
                            count += translation.susOptions.length - (parseInt(resultsData.answers[i].answer.scales) + 1);
                        } else {
                            count += parseInt(parseInt(resultsData.answers[i].answer.scales));
                        }
                    } else {
                        susResultsValid = false;
                    }
                }
                count *= 2.5;

                if (susResultsValid) {
                    var fittedScore = getSUSAdjective(count);
                    $(content).find('.alert-space').remove();
//                    $(content).find('#average-score').text(count);
                    $(content).find('#average-score').css({color: fittedScore.color});
                    $(content).find('#score-adjective .address').text(translation.systemIs);
                    $(content).find('#score-adjective .text').text(fittedScore.adjective);
                    $(content).find('#score-adjective .tail').text(translation.rated);
                    renderSUSProgress($(content), translation.susScores, count);
                } else {
                    $(content).find('#sus-score-results').remove();
                    appendAlert(content, ALERT_SUS_INVALID);
                }
            }

            function renderSUSProgress(container, susQuartiles, score) {
//                <div class="progress-bar progress-bar-danger" style="width: 35%; background-color: #003399 !important;">
                var currentWidth = 0.0;
                var oldWidth = 0.0;
                var targetWidth = $(container).find('#sus-score-progress').width();

                for (var i = 0; i < susQuartiles.length; i++) {
                    currentWidth = parseFloat(i < susQuartiles.length - 1 ? susQuartiles[i + 1].score : 100) - oldWidth;
                    oldWidth = parseFloat(i < susQuartiles.length - 1 ? susQuartiles[i + 1].score : susQuartiles[i].score);

                    var progressBar = document.createElement('div');
                    $(progressBar).addClass('progress-bar');
                    $(progressBar).css('background-color', susQuartiles[i].color);
                    $(progressBar).css({width: currentWidth + '%'});
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
                    TweenMax.from(markerItem, .2, {delay: 2.4 + (i * .05), opacity: 0, y: -10});
                }

                TweenMax.to($(container).find('#sus-score-pointer'), 3, {left: score + '%'});

                var counter = {var : 0};
                TweenMax.to(counter, 3, {
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
                // calculate ueq scales
                var scales = {
                    attractiveness: {sum: 0, max: 0, present: false},
                    efficiency: {sum: 0, max: 0, present: false},
                    perspicuity: {sum: 0, max: 0, present: false},
                    dependability: {sum: 0, max: 0, present: false},
                    stimulation: {sum: 0, max: 0, present: false},
                    novelty: {sum: 0, max: 0, present: false}
                };
                var ueqDimensions = translation.ueqDimensions;

                // calculate sums for each dimension
                for (var key in ueqDimensions) {
                    if (ueqDimensions.hasOwnProperty(key)) {
                        for (var j = 0; j < studyData.length; j++) {
                            if (key === studyData[j].dimension) {
                                var ueqId = parseInt(studyData[j].id);
                                for (var k = 0; k < resultsData.answers.length; k++) {
                                    var answerId = parseInt(resultsData.answers[k].id);
                                    var value = 0;
                                    if (ueqId === answerId) {
                                        if (studyData[j].parameters.negative === 'yes') {
                                            value = 6 - parseInt(resultsData.answers[k].answer.selectedOption) - 3;
                                        } else {
                                            value = parseInt(resultsData.answers[k].answer.selectedOption) - 3;
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

                console.log('scales', scales);

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

                console.log('qualities', qualities);

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
                currentGUSData = studyData;
                renderQuestionnaireAnswers(content, getAssembledItems(studyData.gus), resultsData, true);

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


            function renderGestureTraining(container, studyData, testerResults, evaluatorResults) {
//                console.log('visData: ', studyData.training, evaluatorResults);

                var startTrainingTimes = new Array;
                for (var j = 0; j < evaluatorResults.annotations.length; j++) {
                    if (evaluatorResults.annotations[j].action === ACTION_START_GESTURE_TRAINING) {
                        startTrainingTimes.push(evaluatorResults.annotations[j]);
                    }
                }

                for (var i = 0; i < studyData.training.length; i++) {
                    var gesture = getGestureById(studyData.training[i].gestureId);
                    var trigger = getTriggerById(studyData.training[i].triggerId);
                    var feedback = getFeedbackById(studyData.training[i].feedbackId);

                    //                    console.log(gesture);

                    var item = $('#template-study-container').find('#training-gesture-item').clone().removeAttr('id');
                    container.find('#gestures-container').append(item);
//                    renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage);
//                    $(item).find('#gesture .address').text(translation.gesture + ': ');
//                    $(item).find('#gesture .text').text(gesture.title);
                    $(item).find('#trigger .address').text(translation.trigger + ': ');
                    $(item).find('#trigger .text').text(trigger.title);
                    $(item).find('#repeats .address').text(translation.repeats + ': ');
                    $(item).find('#repeats .text').text(studyData.training[i].repeats);
//                    $(item).find('#recognition-time .address').text(translation.recognitionTime + ': ');
//                    var recognitionSeconds = parseInt(studyData.training[i].recognitionTime);
//                    $(item).find('#recognition-time .text').text(recognitionSeconds + ' ' + (recognitionSeconds === 1 ? translation.timesSingular.seconds : translation.times.seconds));

                    $(item).find('#feedback .address').text(translation.feedback + ': ');

                    var gestureThumbnail = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12');
                    $(gestureThumbnail).removeClass('deleteable');
                    $(item).find('.gesture-container').append(gestureThumbnail);

                    if (feedback) {
                        var feedbackItem = $('#template-study-container').find('#feedback-catalog-thumbnail').clone().removeAttr('id');
                        feedbackItem.find('.text').text(feedback.title);
                        feedbackItem.find('#' + feedback.type).removeClass('hidden');
                        if (feedback.type === TYPE_FEEDBACK_SOUND) {
                            feedbackItem.find('.audio-holder').attr('src', feedback.data);
                        }
                        $(item).find('#feedback .text').append(feedbackItem);
                    } else {
                        $(item).find('#feedback .text').text(translation.none);
                    }

//                    console.log('start training times', startTrainingTimes);
                    if (evaluatorResults.annotations && evaluatorResults.annotations.length) {
                        var trainingStart, trainingEnd = null;
                        for (var j = 0; j < startTrainingTimes.length; j++) {
                            if (parseInt(gesture.id) === parseInt(startTrainingTimes[j].gestureId)) {
                                trainingStart = startTrainingTimes[j].time;
                                if (j < startTrainingTimes.length - 1) {
                                    trainingEnd = parseInt(startTrainingTimes[j + 1].time);
                                    break;
                                } else {
                                    trainingEnd = parseInt(evaluatorResults.endTime);
                                }
                            }
                        }

                        if (trainingStart && trainingEnd) {
                            var execution = getTimeBetweenTimestamps(trainingStart, trainingEnd);
                            $(item).find('#training-time .address').text(translation.execution + ': ');
//                            if (testerResults && testerResults.training && testerResults.training[i].gestureTrainingStart && testerResults.training[i].gestureTrainingEnd) {
//                                var executionTime = getTimeBetweenTimestamps(testerResults.training[i].gestureTrainingStart, testerResults.training[i].gestureTrainingEnd);
                            $(item).find('#training-time .text').text(getTimeString(execution, false, true));
//                            } else {
//                                $(item).find('#training-time .text').text('-');
//                            }
                        } else {
                            $(item).find('#training-time').remove();
                        }
                    } else {
                        $(item).find('#training-time').remove();
                    }
                }

                renderObservation($(container).find('#observations'), studyData, getObservationResults($('#phase-results-nav').find('.active').attr('id')));
//                addObservationsDropdown(container);
            }


            function renderGestureSlideshow(container, studyData, resultsData, evaluatorResults) {
//                console.log(studyData, resultsData, evaluatorResults);

                $(container).find('#restarts .address').text(parseInt(resultsData.restarts) === 1 ? translation.restart : translation.restarts);
                $(container).find('#restarts .text').text(resultsData.restarts);

                for (var i = 0; i < studyData.slideshow.length; i++) {
                    var gesture = getGestureById(studyData.slideshow[i].gestureId);
                    var trigger = getTriggerById(studyData.slideshow[i].triggerId);
                    //                    var feedback = getFeedbackById(studyData.slideshow[i].feedbackId);
//                    console.log('gesture for gesture slideshow', gesture, item);


                    var item = $('#template-study-container').find('#slideshow-gesture-item').clone().removeAttr('id');
                    container.find('#gestures-container').append(item);
//                    renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage);
//                    $(item).find('#gesture .address').text(translation.gesture + ': ');
//                    $(item).find('#gesture .text').text(gesture.title);
                    $(item).find('#trigger .address').text(translation.trigger + ': ');
                    $(item).find('#trigger .text').text(trigger.title);
//                    $(item).find('#repeats .address').text(translation.repeats + ': ');
                    //                    $(item).find('#repeats .text').text(studyData.training[i].repeats);
                    $(item).find('#recognition-time .address').text(translation.recognitionTime + ': ');
                    var recognitionSeconds = parseInt(studyData.slideshow[i].recognitionTime);
                    $(item).find('#recognition-time .text').text(recognitionSeconds + ' ' + (recognitionSeconds === 1 ? translation.timesSingular.seconds : translation.times.seconds));

                    var gestureThumbnail = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12');
                    $(gestureThumbnail).removeClass('deleteable');
                    $(item).find('.gesture-container').append(gestureThumbnail);

                    if (resultsData.annotations && resultsData.annotations.length > 0) {
                        var count = 0;
                        for (var j = 0; j < resultsData.annotations.length; j++) {
//                            console.log(resultsData.annotations[j]);
                            if (resultsData.annotations[j].action === ACTION_NO_GESTURE_FIT_FOUND && parseInt(resultsData.annotations[j].gestureId) === parseInt(gesture.id)) {
                                count++;
                            }
                        }

                        if (count > 0) {
                            $(item).find('#fits-false .address').text(translation.fitsCorrect + ': ');
                            $(item).find('#fits-false .text').text(count + ' ' + (count === 1 ? translation.fault : translation.faults));
                            $(item).find('#fits-false').removeClass('hidden');
                        } else {
                            $(item).find('#fits-correct .address').text(translation.fitsCorrect + ': ');
                            $(item).find('#fits-correct .text').text(translation.allFitsCorrect);
                            $(item).find('#fits-correct').removeClass('hidden');
                        }
                    }
                }

                renderObservation($(container).find('#observations'), studyData, getObservationResults($('#phase-results-nav').find('.active').attr('id')));
            }

            function renderTriggerSlideshow(container, studyData, resultsData) {
                console.log(studyData, resultsData);
                var globalFaults = 0;
                for (var i = 0; i < studyData.slideshow.length; i++) {
                    var gesture = getGestureById(studyData.slideshow[i].gestureId);
                    var trigger = getTriggerById(studyData.slideshow[i].triggerId);
                    var item = $('#template-study-container').find('#slideshow-trigger-item').clone().removeAttr('id');
                    container.find('#gestures-container').append(item);
//                    renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage);
//                    $(item).find('#gesture .address').text(translation.gesture + ': ');
//                    $(item).find('#gesture .text').text(gesture.title);
                    $(item).find('#trigger .address').text(translation.trigger + ': ');
                    $(item).find('#trigger .text').text(trigger.title);
                    $(item).find('#selection .address').text(translation.trigger + ' ' + translation.answer + ': ');

                    var gestureThumbnail = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12');
                    $(gestureThumbnail).removeClass('deleteable');
                    $(item).find('.gesture-container').append(gestureThumbnail);

                    var fault = 0;
                    var realTriggerId = parseInt(studyData.slideshow[i].triggerId);
                    if (resultsData.selectedOptions && resultsData.selectedOptions.length > 0) {
                        for (var j = 0; j < resultsData.selectedOptions.length; j++) {
                            var option = resultsData.selectedOptions[j];
                            if (parseInt(option.correctTriggerId) === realTriggerId) {
                                var selectedOption = parseInt(resultsData.selectedOptions[j].selectedId);
                                if (selectedOption === -1) {
                                    fault = -1;
                                    $(item).find('#selection .text').text(translation.none);
                                    $(item).find('#no-answer').removeClass('hidden');
                                } else {
                                    $(item).find('#selection .text').text(getTriggerById(selectedOption).title);
                                    if (selectedOption !== realTriggerId) {
                                        globalFaults++;
                                        //                                    $(item).find('#fits-false .address').text(translation.allocation + ': ');
                                        $(item).find('#fits-false').removeClass('hidden');
                                    } else {
                                        //                                    $(item).find('#fits-correct .address').text(translation.allocation + ': ');
                                        $(item).find('#fits-correct').removeClass('hidden');
                                    }
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
                    console.log('selection fault');
                    $(container).find('#score #no-fault-score').removeClass('hidden');
                } else {
                    $(container).find('#score #fault-score').removeClass('hidden');
                    var faultScore = globalFaults / studyData.slideshow.length;
                    console.log('globalFaults: ' + globalFaults + ' fault: ' + fault + ', score: ' + faultScore);
                    var faultPercentage = (1 - faultScore) * 100;
                    $(container).find('#score .text').text(faultPercentage + '%');
                }
            }


            function renderPhysicalStressTest(container, studyData, resultsData) {
//                console.log(studyData, resultsData);
                for (var i = 0; i < studyData.stressTestItems.length; i++) {
                    var item = $('#template-study-container').find('#physicalStressTest-item').clone().removeAttr('id');
                    container.find('#gestures-container').append(item);

                    var gestures = studyData.stressTestItems[i].gestures;
                    for (var g = 0; g < gestures.length; g++) {
                        var gesture = getGestureById(gestures[g]);
                        var gestureThumbnail = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12');
                        $(gestureThumbnail).removeClass('deleteable');
                        $(item).find('.gesture-container').append(gestureThumbnail);
                    }

                    $(item).find('#trigger .address').text(translation.trigger + ': ');
                    $(item).find('#trigger .text').text(trigger.title);
                    $(item).find('#selection .address').text(translation.trigger + ' ' + translation.answer + ': ');


                    // check if answers are there
                    if (resultsData && resultsData.answers && !$.isEmptyObject(resultsData.answers)) {

                        // single questions joint section
                        var singleStressGraphicsRating = studyData.singleStressGraphicsRating;
                        if (singleStressGraphicsRating !== 'none') {
                            var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
                            $(jointAnswers).insertAfter($(item).find('#headline-single-questions'));
                            if (singleStressGraphicsRating === 'hands') {
                                $(jointAnswers).find('#joint-answers-body').remove();
                                renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData.answers, gesture.id, 'single');
                            } else if (singleStressGraphicsRating === 'body') {
                                $(jointAnswers).find('#joint-answers-hands').remove();
                                renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData.answers, gesture.id, 'single');
                            } else {
                                renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData.answers, gesture.id, 'single');
                                renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData.answers, gesture.id, 'single');
                            }
                        }

                        // sequence questions joint section
                        var sequenceStressGraphicsRating = studyData.sequenceStressGraphicsRating;
                        if (sequenceStressGraphicsRating !== 'none') {
                            var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
                            $(jointAnswers).insertAfter($(item).find('#headline-sequence-questions'));

                            if (sequenceStressGraphicsRating === 'hands') {
                                $(jointAnswers).find('#joint-answers-body').remove();
                                renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData.answers, gesture.id, 'sequence');
                            } else if (sequenceStressGraphicsRating === 'body') {
                                $(jointAnswers).find('#joint-answers-hands').remove();
                                renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData.answers, gesture.id, 'sequence');
                            } else {
                                renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData.answers, gesture.id, 'sequence');
                                renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData.answers, gesture.id, 'sequence');
                            }
                        }

                        // single answers section
                        var singleStressQuestionnaire = studyData.singleStressQuestions;
                        if (singleStressQuestionnaire && singleStressQuestionnaire.length > 0) {
                            var results = new Object();
                            results.answers = new Array();
                            var questions = new Array();

                            for (var j = 0; j < resultsData.answers.singleAnswers.length; j++) {
                                if (parseInt(resultsData.answers.singleAnswers[j].stressTestIndex) === i) {
                                    results.answers = results.answers.concat(resultsData.answers.singleAnswers[j].answers);
                                    questions = questions.concat(singleStressQuestionnaire);
                                }
                            }

                            if (questions.length > 0 && results.answers.length > 0) {
//                                console.log(results, questions);
                                renderQuestionnaireAnswers($(item).find('#single-stress-answers'), questions, results, false, true);
                            }
                        }

                        // sequence answers section
                        var sequenceStressQuestionnaire = studyData.sequenceStressQuestions;
                        if (sequenceStressQuestionnaire && sequenceStressQuestionnaire.length > 0) {
                            var results = new Object();
                            results.answers = new Array();
                            var questions = new Array();

                            for (var j = 0; j < resultsData.answers.sequenceAnswers.length; j++) {
                                if (parseInt(resultsData.answers.sequenceAnswers[j].stressTestIndex) === i) {
                                    results.answers = results.answers.concat(resultsData.answers.sequenceAnswers[j].answers);
                                    questions = questions.concat(sequenceStressQuestionnaire);
                                }
                            }

                            if (questions.length > 0 && results.answers.length > 0) {
                                renderQuestionnaireAnswers($(item).find('#sequence-stress-answers'), questions, results, false, true);
                            }
                        }
                    }
                }

                renderObservation($(container).find('#observations'), studyData, getObservationResults($('#phase-results-nav').find('.active').attr('id')));
            }

            function renderScenario(container, studyData, resultsData) {
                renderObservation($(container).find('#observations'), studyData, getObservationResults($('#phase-results-nav').find('.active').attr('id')));
            }

            function renderIdentification(container, studyData, phaseResults) {
                if (studyData.identificationFor === 'gestures') {
                    $(container).find('#search-gestures').removeClass('hidden');
                    var elicitedGestures = getLocalItem(GESTURE_CATALOG);
                    var gestureTriggerPairs, triggerGesturePairs;
                    if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_MODERATED) {
                        gestureTriggerPairs = getLocalItem(phaseResults.id + '.evaluator').gestures;
                    }

                    if (elicitedGestures && elicitedGestures.length > 0 && gestureTriggerPairs) {
                        for (var i = 0; i < gestureTriggerPairs.length; i++) {
                            var gesture = getGestureById(gestureTriggerPairs[i].id);
                            var column = document.createElement('div');
                            $(column).addClass('col-xs-12');
                            $(container).find('.list-container').append(column);

                            var row = document.createElement('div');
                            $(row).addClass('row');
                            $(column).append(row);

                            var item = getGestureCatalogListThumbnail(gesture, null, 'col-xs-6 col-lg-4');
                            $(item).removeClass('deleteable');
                            $(row).append(item);

                            var triggerText = document.createElement('div');
                            $(triggerText).addClass('col-xs-6 col-lg-8');
                            $(triggerText).html('<span>' + translation.trigger + ':</span> <span class=text>' + getTriggerById(gestureTriggerPairs[i].triggerId).title + '</span>');
                            $(row).append(triggerText);

                            if (i < gestureTriggerPairs.length - 1) {
                                var line = document.createElement('hr');
                                $(line).css({margin: 0, marginBottom: 20});
                                $(column).append(line);
                            }
                            TweenMax.from(item, .2, {delay: i * .1, opacity: 0, y: -10});
                        }
                    } else {
                        appendAlert(container, ALERT_NO_PHASE_DATA);
                    }
                } else if (studyData.identificationFor === 'trigger') {
                    var triggerGesturePairs;
                    if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_MODERATED) {
                        triggerGesturePairs = getLocalItem(phaseResults.id + '.evaluator').trigger;
                    }

                    $(container).find('#search-trigger').removeClass('hidden');

                    var gestures = getLocalItem(GESTURE_CATALOG);
                    if (gestures && triggerGesturePairs && triggerGesturePairs.length > 0) {
                        for (var i = 0; i < gestures.length; i++) {
                            var column = document.createElement('div');
                            $(column).addClass('col-xs-12');
                            $(container).find('.list-container').append(column);

                            var gesture = gestures[i];
                            var gestureItem = getGestureCatalogListThumbnail(gesture, null, 'col-xs-6 col-lg-4');

                            for (var j = 0; j < triggerGesturePairs.length; j++) {
                                if (parseInt(triggerGesturePairs[j].gestureId) === parseInt(gesture.id)) {
                                    var trigger = triggerGesturePairs[j].preferredTrigger.answers[0].answer;
                                    var item = $('#template-study-container').find('#trigger-identification').clone();
                                    $(item).prepend(gestureItem);
                                    $(item).find('#trigger-name .address').text(translation.trigger + ':');
                                    $(item).find('#trigger-name .text').text(trigger.openAnswer);
                                    $(item).find('#trigger-justification .address').text(translation.justification + ':');
                                    $(item).find('#trigger-justification .text').text(trigger.justification);
                                    $(column).append(item);

                                    if (i < gestures.length - 1) {
                                        var line = document.createElement('hr');
                                        $(line).css({margin: 0, marginBottom: 20});
                                        $(column).append(line);
                                    }
                                    TweenMax.from(column, .2, {delay: i * .1, opacity: 0, y: -10});
                                }
                            }
                        }
                    } else {
                        console.log('no triggers there');
                    }
                }

                renderObservation($(container).find('#observations'), studyData, getObservationResults($('#phase-results-nav').find('.active').attr('id')));
            }

            function renderExploration(container, phaseData, testerResults, evaluatorResults) {
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
                if (studyData.observations && studyData.observations.length > 0) {
                    renderQuestionnaire(target, studyData.observations, observationResults && observationResults.length > 0 ? {answers: observationResults} : null);
                    $(target).find('#observations-container').on('change', function () {
                        saveObservationAnwers($(target).find('#observations-container'), getLocalItem(STUDY).id, getLocalItem(STUDY_RESULTS).userId, $('#phase-results-nav').find('.active').attr('id'));
                    });
                } else {
                    $(target).addClass('hidden');
                }
            }

            function addObservationsDropdown(container) {
                var dropdown = $('#template-study-container').find('#add-observations-dropdown').clone().removeAttr('id');
                $(container).find('#headline-observations').after(dropdown);
                $(dropdown).find('#btn-add-observation').on('click', function (event) {
                    event.preventDefault();
                    if (event.handled !== true && dropdown.find('.chosen').attr('id') !== 'unselected') {
                        event.handled = true;
                        var format = dropdown.find('.chosen').attr('id');
                        var item = $('#template-study-editable-container').find('#' + format).clone();
                        $(container).find('#observations-container').prepend(item);
                        checkCurrentListState($(container).find('#observations-container'));
                        updateBadges($(container).find('#observations-container'), format);
                        TweenMax.from(item, .3, {y: -20, opacity: 0, clearProps: 'all'});
                    }
                });
            }


            $('#btn-introduction').on('click', function (event) {
                event.preventDefault();
                $('#custom-modal').attr('data-help-items-key', 'introductionParticipant');
                $('#custom-modal').attr('data-help-context', 'participant');
                $('#custom-modal').attr('data-help-show-tutorial', parseInt(<?php echo $_SESSION['tutorialParticipant'] ?>));
                loadHTMLintoModal('custom-modal', 'externals/modal-introduction.php', 'modal-lg');
            });

            $('.pretest-select').unbind('change').bind('change', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    var participantId = $(this).attr('data-participant-id');
                    var evaluatorId = $(this).attr('data-evaluator-id') || null;
                    var executionPhase = $(this).find('.btn-option-checked').attr('id');

                    console.log('pretest selection changed', participantId, evaluatorId, executionPhase);
                    updateExecutionPhase(evaluatorId ? {participantId: participantId, evaluatorId: evaluatorId, executionPhase: executionPhase} : {participantId: participantId, executionPhase: executionPhase}, function (result) {

                    });
                }
            });

        </script>
    </body>
</html>
