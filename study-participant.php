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
        <title>GestureNote</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/study.css">
        <link rel="stylesheet" href="css/gesture.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>

        <!--        <link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
                <script src="http://vjs.zencdn.net/5.8.8/video.js"></script>-->

        <link href="vis/vis.css" rel="stylesheet">
        <script src="vis/vis.min.js"></script>

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
        <script src="js/storageFunctions.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/rtc-result-player.js"></script>

    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-gesture"></div>
        <div id="template-subpages"></div>
        <div id="template-study"></div>

        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-studies"><?php echo $lang->breadcrump->studies ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-study"><?php echo $lang->breadcrump->study ?></a></li>
                    <li class="active"><?php echo $lang->breadcrump->studyParticipant ?></li>
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
        <div class="container mainContent" style="margin-top: 35px;" id="general-view">
            <h2 id="main-headline" style="margin-top: 0"></h2>
            <hr>
            <span class="text pull-right" id="execution-date"></span>
            <span class="label label-default" id="user"><i class="fa fa-user"></i> <span class="label-text"></span></span>
            <span class="label label-success hidden" id="execution-success"><i class="fa fa-check"></i> <span class="label-text hidden-xs"></span></span>
            <span class="label label-danger hidden" id="execution-fault"><i class="fa fa-bolt"></i> <span class="label-text hidden-xs"></span></span>
        </div>

        <div class="container" id="phase-results" style="margin-bottom: 60px;">
            <div class="row">
                <div class="col-md-3" style="margin-bottom: 30px;">
                    <div class="btn-group-vertical btn-block" id="phase-results-nav">
                    </div>
                </div>
                <div class="col-md-9">
                    <div id="phase-result"></div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                checkDomain();
                checkLanguage(function () {
                    var externals = new Array();
                    var path = PATH_EXTERNALS + '/' + currentLanguage + '/';
                    externals.push(['#alerts', path + '/alerts.html']);
                    externals.push(['#template-gesture', path + 'template-gesture.html']);
                    externals.push(['#template-subpages', path + '/template-sub-pages.html']);
                    externals.push(['#template-study', path + '/template-study.html']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
                var query = getQueryParams(document.location.search);
                var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');

                if (query.studyId && query.participantId && query.h === hash) {
                    $('.breadcrumb #btn-study').on('click', function (event) {
                        event.preventDefault();
                        goto('study.php?studyId=' + query.studyId + '&h=' + hash);
                    });

                    getStudyParticipant({studyId: query.studyId, participantId: query.participantId}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            console.log(result);
//                            console.log(result.resultData);
                            setStudyData(result);
                            renderData(result);
                        }
                    });
                }
            }

            function renderData(data) {
                var studyData = data.studyData;
                var resultData = data.resultData;
                var results = resultData.results;

                // general data view
                $('#execution-date').text(convertSQLTimestampToDate(resultData.created).toLocaleString());
                $('#main-headline').text(studyData.generalData.title);
                if (isNaN(resultData.userId)) {
                    $('#general-view').find('#user .label-text').text(translation.userTypes.guest);
                } else {
                    $('#general-view').find('#user .label-text').text(translation.userTypes.registered);
                }

                if (results.studySuccessfull === 'yes') {
                    $('#general-view').find('.panel').addClass('panel-success');
                    $('#general-view').find('#execution-success').removeClass('hidden');
                    $('#general-view').find('#execution-success .label-text').text(translation.studySuccessful);
                } else {
                    $('#general-view').find('.panel').addClass('panel-danger');
                    $('#general-view').find('#execution-fault').removeClass('hidden');
                    $('#general-view').find('#execution-fault .label-text').text(translation.studyFault);
                }

                // phase nav view
                if (studyData.phases && studyData.phases.length > 0) {
                    for (var i = 0; i < studyData.phases.length; i++) {
                        var navItem = document.createElement('button');
                        $(navItem).attr('role', 'presentation');
                        $(navItem).addClass('btn btn-default');
                        $(navItem).attr('id', studyData.phases[i].id);
                        $('#phase-results-nav').append(navItem);

                        var text = document.createElement('span');
                        $(text).text(translation.formats[studyData.phases[i].format].text);
                        $(navItem).append(text);

                        TweenMax.from($(navItem), .3, {delay: 0.2 + (i * .05), y: -10, opacity: 0, clearProps: 'all'});
                    }
                    $('#phase-results-nav').children().first().click();
                }
            }

            $(document).on('click', '#phase-results-nav button', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('active')) {
                    cacheNotes(true);
                    $(this).parent().children().removeClass('active');
                    $(this).addClass('active');
                    renderStudyPhaseResult($(this).attr('id'));
                }
            });

            function renderStudyPhaseResult(phaseId) {
                var phaseData = getLocalItem(phaseId + '.data');
                var phaseResults = getLocalItem(phaseId + '.results');
//                console.log(phaseData, phaseResults);

                if (phaseData && phaseResults) {
                    var content = $('#template-study-container').find('#' + phaseResults.format).clone().removeAttr('id');
                    $(content).find('#headline').text(translation.formats[phaseResults.format].text);
                    $('#phase-result').empty().append(content);

                    var executionTime = getTimeBetweenTimestamps(phaseResults.startTime, phaseResults.endTime);
//                    console.log(executionTime);
                    if (!isEmpty(executionTime)) {
                        var badge = document.createElement('span');
                        $(badge).addClass('badge pull-right');
                        $(badge).text(translation.lapse + ': ' + getTimeString(executionTime));
                        $(content).find('#headline').append(badge);
                    }

                    if (translation.formats[phaseResults.format].notes === 'yes') {
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

                    // check and add recorded stream data
                    if (isWebRTCNeededForPhaseStep(phaseResults)) {
                        if (phaseResults && phaseResults.recordUrl && phaseResults.recordUrl !== '') {
                            var timelineData = {phaseData: phaseData, phaseResults: phaseResults, executionTime: executionTime};
                            var resultsPlayer = new RTCResultsPlayer(phaseResults.recordUrl, timelineData);
                            if (getBrowser() !== 'Safari') {
                                $(content).find('#horizontalLine').after(resultsPlayer);
                            } else {
//                            console.log('webm not supported');
                                appendAlert(content, ALERT_WEBM_UNSUPPORTED);
                            }
                        } else {
                            appendAlert(content, ALERT_NO_RECORD);
                        }
                    }

                    console.log('render phase step: ' + phaseResults.format);
                    switch (phaseResults.format) {
                        case LETTER_OF_ACCEPTANCE:
                            renderLetterOfAcceptance(content, phaseData, phaseResults);
                            break;
                        case THANKS:
                            renderThanks(content, phaseData);
                            break;
                        case QUESTIONNAIRE:
                            renderQuestionnaire(content, phaseData.reverse(), phaseResults);
                            break;
                        case IDENTIFICATION:
                            renderIdentification(content, phaseData, phaseResults);
                            break;
                        case SUS:
                            renderSUS(content, phaseData, phaseResults);
                            break;
                        case GUS_SINGLE_GESTURES:
                            renderSingleGUS(content, phaseData, phaseResults);
                            break;
                        case GUS_MULTIPLE_GESTURES:
                            renderQuestionnaire(content, getAssembledItems(phaseData.gus.reverse()), phaseResults);
                            break;
                        case GESTURE_TRAINING:
                            renderGestureTraining(content, phaseData, phaseResults);
                            break;
                        case SLIDESHOW_GESTURES:
                            renderGestureSlideshow(content, phaseData, phaseResults);
                            break;
                        case SLIDESHOW_TRIGGER:
                            renderTriggerSlideshow(content, phaseData, phaseResults);
                            break;
                        case PHYSICAL_STRESS_TEST:
                            renderPhysicalStressTest(content, phaseData, phaseResults);
                            break;
                        case SCENARIO:
                            renderScenario(content, phaseData, phaseResults);
                            break;
                    }

                    $(content).css({y: 0, opacity: 1});
                    TweenMax.from(content, .2, {opacity: 0, y: -60});
                } else {
//                    console.log('no results');
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

            function renderIdentification(content, phaseData, phaseResults) {
//                console.log(phaseData, phaseResults);

                if (phaseData.identificationFor === 'gestures') {
                    $(content).find('#search-gestures').removeClass('hidden');
                    var elicitedGestures = getLocalItem(GESTURE_CATALOG);
                    if (phaseResults.gestures && phaseResults.gestures.length > 0 && elicitedGestures) {
                        for (var i = 0; i < elicitedGestures.length; i++) {
                            var item = getGestureCatalogListThumbnail(elicitedGestures[i], 'col-xs-6 col-lg-4');
                            $(content).find('.list-container').append(item);
                            TweenMax.from(item, .2, {delay: i * .1, opacity: 0, y: -10});
                        }
                    }
                } else if (phaseData.identificationFor === 'trigger') {
                    $(content).find('#search-trigger').removeClass('hidden');
                    var gestures = phaseData.identification;
                    for (var i = 0; i < gestures.length; i++) {
                        var gesture = getGestureById(gestures[i]);
                        var gestureItem = getGestureCatalogListThumbnail(gesture, 'col-xs-6 col-lg-4');

                        var item = $('#template-study-container').find('#trigger-identification').clone();
                        $(item).prepend(gestureItem);
                        $(item).find('#trigger-name .address').text(translation.trigger + ':');
                        $(item).find('#trigger-name .text').text(phaseResults.trigger[i].name);
                        $(item).find('#trigger-justification .address').text(translation.justification + ':');
                        $(item).find('#trigger-justification .text').text(phaseResults.trigger[i].justification);
                        $(content).find('.list-container').append(item);

                        if (i < gestures.length - 1) {
                            var line = document.createElement('hr');
                            $(line).css({margin: 0, marginBottom: 20});
                            $(content).find('.list-container').append(line);
                        }
                        TweenMax.from(item, .2, {delay: i * .1, opacity: 0, y: -10});
                    }
                }
            }

            function renderSUS(content, studyData, resultsData) {
//                console.log(studyData, resultsData);
                renderQuestionnaire(content, studyData, resultsData);

                // calculate the average sus score
                var susResultsValid = true;
                var count = 0;
                for (var i = 0; i < resultsData.answers.length; i++) {
                    if (parseInt(resultsData.answers[i].selectedOption) !== -1) {
                        var negative = studyData[i].parameters.negative === 'yes';
                        if (negative) {
                            count += translation.susOptions.length - (parseInt(resultsData.answers[i].selectedOption) + 1);
                        } else {
                            count += parseInt(resultsData.answers[i].selectedOption);
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

            var currentGUSData = null;
            function renderSingleGUS(content, studyData, resultsData) {
//                console.log(studyData, resultsData);
                currentGUSData = studyData;
                renderQuestionnaire(content, getAssembledItems(studyData.gus.reverse()), resultsData);

                var gesture = getGestureById(studyData.gestureId);
                if (gesture && isGestureAssembled(studyData.gestureId)) {
                    content.find('#title').text(gesture.title);
                    renderGestureImages(content.find('.previewGesture'), gesture.images, gesture.previewImage, null);
                    var trigger = getTriggerById(studyData.triggerId);
                    var feedback = getFeedbackById(studyData.feedbackId);
                    $(content).find('#gesture .address').text(translation.gesture + ':');
                    $(content).find('#gesture .text').text(gesture.title);
                    $(content).find('#trigger .address').text(translation.trigger + ':');
                    $(content).find('#trigger .text').text(trigger.title);
                    $(content).find('#feedback .address').text(translation.feedback + ':');
                    $(content).find('#feedback .text').text(feedback.title);

                    if (feedback) {
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

//            function renderMultipleGUS(content, studyData, resultsData) {
//                console.log(studyData, resultsData);
//            }


            // questionnaire rendering
            function renderQuestionnaire(content, studyData, resultsData) {
//                console.log(studyData.length);
                for (var i = 0; i < studyData.length; i++) {
//                    console.log(studyData[i].format);
                    var listItem = $('#template-study-container').find('#' + studyData[i].format).clone();
                    listItem.find('#format .format-text').text(translation.questionFormats[studyData[i].format].text);
                    $(content).find('.list-container').append(listItem);

                    if (studyData[i].dimension !== DIMENSION_ANY) {
                        $(listItem).find('#item-factors').removeClass('hidden');
                        $(listItem).find('#factor-primary').text(translation.dimensions[studyData[i].dimension]);
                        $(listItem).find('#factor-main').text(translation.mainDimensions[getMainDimensionForDimension(studyData[i].dimension)]);
                    }

                    switch (studyData[i].format) {
                        case COUNTER:
                            renderCounter(listItem, studyData[i], resultsData.answers[i]);
                            break;
                        case OPEN_QUESTION:
                        case OPEN_QUESTION_GUS:
                            renderOpenQuestion(listItem, studyData[i], resultsData.answers[i]);
                            break;
                        case DICHOTOMOUS_QUESTION:
                            renderDichotomousQuestion(listItem, studyData[i], resultsData.answers[i]);
                            break;
                        case DICHOTOMOUS_QUESTION_GUS:
                            renderDichotomousQuestion(listItem, studyData[i], resultsData.answers[i]);
                            break;
                        case GROUPING_QUESTION:
                            renderGroupingQuestion(listItem, studyData[i], resultsData.answers[i]);
                            break;
                        case GROUPING_QUESTION_GUS:
                            renderGroupingQuestionGUS(listItem, studyData[i], resultsData.answers[i]);
                            break;
                        case RATING:
                            renderRating(listItem, studyData[i], resultsData.answers[i]);
                            break;
                        case SUM_QUESTION:
                            renderSumQuestion(listItem, studyData[i], resultsData.answers[i]);
                            break;
                        case RANKING:
                            renderRanking(listItem, studyData[i], resultsData.answers[i]);
                            break;
                        case ALTERNATIVE_QUESTION:
                            renderAlternativeQuestion(listItem, studyData[i], resultsData.answers[i]);
                            break;
                        case GUS_SINGLE:
                            renderGUS(listItem, studyData[i], resultsData.answers[i]);
                            break;
                        case SUS_ITEM:
                            renderSUSItem(listItem, studyData[i], resultsData.answers[i]);
                            break;
//                        case 'human-body-selection-rating':
//                            break;
//                        case 'hand-selection-rating':
//                            break;
                    }
                    $(listItem).css({y: 0, opacity: 1});
                    TweenMax.from(listItem, .1, {delay: i * .1, opacity: 0, y: -10});
                }
            }

            function renderCounter(item, studyData, resultsData) {
                var parameters = studyData.parameters;
                $(item).find('.question').text(studyData.question);
                $(item).find('#counter-label .counter-from').text(translation.of + ' ' + translation.atLeast + ' ' + parameters.countFrom);
                $(item).find('#counter-label .counter-to').text(translation.to + ' ' + translation.maximal + ' ' + parameters.countTo);
                if (resultsData.count && resultsData.count !== '') {
                    $(item).find('.answer').text(resultsData.count);
                } else {
                    $(item).find('#no-answer').removeClass('hidden');
                }
            }

            function renderOpenQuestion(item, studyData, resultsData) {

                $(item).find('.question').text(studyData.question);
                if (resultsData.openAnswer && resultsData.openAnswer !== '') {
                    $(item).find('.answer').text(resultsData.openAnswer);
                } else {
                    $(item).find('#no-answer').removeClass('hidden');
                }
            }

            function renderDichotomousQuestion(item, studyData, resultsData) {
//                console.log(studyData, resultsData);
                $(item).find('.question').text(studyData.question);

                if (resultsData.selectedSwitch === 'none') {
                    $(item).find('#no-answer').removeClass('hidden');
                    $(item).find('#selection').remove();
                } else {
//                    console.log(translation[resultsData.selectedSwitch])
                    $(item).find('#selection .text').text(translation[resultsData.selectedSwitch]);
                }

                if (studyData.parameters.justification === 'yes') {
                    $(item).find('#justification').removeClass('hidden');
                    $(item).find('#' + studyData.parameters.justificationFor).removeClass('hidden');

                    if ((resultsData.selectedSwitch === studyData.parameters.justificationFor || studyData.parameters.justificationFor === 'always') && resultsData.justification !== '') {
                        $(item).find('#justification-content').removeClass('hidden');
                        $(item).find('#justification-content .text').text(resultsData.justification);
                    } else if (resultsData.justification === '' && (resultsData.selectedSwitch === studyData.parameters.justificationFor || studyData.parameters.justificationFor === 'always')) {
                        $(item).find('#no-justification-result').removeClass('hidden');
                    }
                } else {
                    $(item).find('#no-justification').removeClass('hidden');
                }
            }

            function renderGroupingQuestion(item, studyData, resultsData) {
                console.log(studyData, resultsData);
                $(item).find('.question').text(studyData.question);

                if (studyData.parameters.multiselect === 'yes') {
                    $(item).find('#multiselect').removeClass('hidden');
                } else {
                    $(item).find('#singleselect').removeClass('hidden');
                }

                if (studyData.parameters.optionalanswer === 'yes') {
//                    $(item).find('#optionalanswer, #optionalanswer-headline').removeClass('hidden');

                    if (resultsData.optionalAnswer !== '') {
                        $(item).find('#optionalanswer-content').removeClass('hidden');
                        $(item).find('#optionalanswer-content .text').text(resultsData.optionalAnswer);
                    } else {
                        $(item).find('#no-optional-answer').removeClass('hidden');
                    }
                }

                if ((resultsData.selectedOptions && parseInt(resultsData.selectedOptions) === -1) || !resultsData.selectedOptions) {
                    $(item).find('#no-answer').removeClass('hidden');
                }

                for (var i = 0; i < studyData.options.length; i++) {
                    var optionItem = $('#template-study-container').find('#grouping-question-item').clone();
                    $(optionItem).text(studyData.options[i].title);
                    $(item).find('.option-container').append(optionItem);

                    if (i < studyData.options.length - 1) {
                        item.find('.option-container').append(document.createElement('br'));
                    }

                    if (resultsData.selectedOptions && resultsData.selectedOptions.length > 0) {
//                        console.log(resultsData.selectedOptions);
                        for (var j = 0; j < resultsData.selectedOptions.length; j++) {
                            if (parseInt(resultsData.selectedOptions[j]) === parseInt(studyData.options[i].id)) {
                                $(optionItem).addClass('bordered-scale-item');
                                if (i > 0) {
                                    $(optionItem).css({marginTop: '5px'});
                                }
                                break;
                            } else {
//                                $(optionItem).css({paddingLeft: "0px"});
                            }
                        }
                    } else {
                        $(optionItem).css({paddingLeft: "0px"});
                    }
                }
            }


            function renderGroupingQuestionGUS(item, studyData, resultsData) {
//                console.log(studyData, resultsData);
                $(item).find('.question').text(studyData.question);
                var options;
                switch (studyData.parameters.optionSource) {
                    case 'gestures':
                        options = assembledGestures();
                        break;
                    case 'triggers':
                        options = getLocalItem(ASSEMBLED_TRIGGER);
                        break;
                    case 'feedbacks':
                        options = getLocalItem(ASSEMBLED_FEEDBACK);
                        break;
                }

                if (studyData.parameters.multiselect === 'yes') {
                    item.find('#multiselect').removeClass('hidden');
                } else {
                    item.find('#singleselect').removeClass('hidden');
                }

                if (studyData.parameters.justification === 'yes') {
                    item.find('#justification').removeClass('hidden');
                    item.find('#' + studyData.parameters.justificationFor).removeClass('hidden');

                    if (studyData.parameters.justificationFor === 'selectOne' && resultsData.selectedOptions && resultsData.selectedOptions.length > 0 && resultsData.justification !== '') {
                        $(item).find('#justification-content').removeClass('hidden');
                        $(item).find('#justification-content .text').text(resultsData.justification);
                    } else if (studyData.parameters.justificationFor === 'selectNothing' && !resultsData.selectedOptions && resultsData.justification !== '') {
                        $(item).find('#justification-content').removeClass('hidden');
                        $(item).find('#justification-content .text').text(resultsData.justification);
                    } else if (studyData.parameters.justificationFor === 'always' && resultsData.justification !== '') {
                        $(item).find('#justification-content').removeClass('hidden');
                        $(item).find('#justification-content .text').text(resultsData.justification);
                    } else if (resultsData.selectedOptions && resultsData.selectedOptions.length > 0 && resultsData.justification === '') {
                        $(item).find('#no-answer').removeClass('hidden');
                    }
                } else {
                    item.find('#no-justification').removeClass('hidden');
                }


                if (options && options.length > 0) {
                    for (var i = 0; i < options.length; i++) {
                        var optionItem = $('#template-study-container').find('#grouping-question-gus-' + studyData.parameters.optionSource + '-option').clone(false);
                        optionItem.attr('id', options[i].id);
                        optionItem.find('.text').text(options[i].title);
                        item.find('.option-container').append(optionItem);

                        if (i < options.length - 1) {
                            item.find('.option-container').append(document.createElement('br'));
                        }

                        if (studyData.parameters.optionSource === 'gestures') {
                            $(optionItem).find('.btn-popover-gesture-preview').attr('name', options[i].id);
                        }

                        if (resultsData.selectedOptions && resultsData.selectedOptions.length > 0) {
                            for (var j = 0; j < resultsData.selectedOptions.length; j++) {
                                if (parseInt(resultsData.selectedOptions[j]) === parseInt(options[i].id)) {
                                    $(optionItem).addClass('bordered-scale-item');
                                    break;
                                } else {
//                                    $(optionItem).css({paddingLeft: "0px"});
                                }
                            }
                        } else {
                            $(optionItem).css({paddingLeft: "0px"});
                        }
                    }
                }
            }

            function renderRating(item, studyData, resultsData) {
                $(item).find('.question').text(studyData.question);

                for (var i = 0; i < studyData.options.length; i++) {
                    var optionItem = $('#template-study-container').find('#rating-item').clone();
                    $(optionItem).find('#rating-option').text(studyData.options[i].option);
                    $(item).find('.option-container').append(optionItem);

                    var score = 0;
                    if (studyData.options[i].negative === 'yes') {
                        $(optionItem).find('#negative').removeClass('hidden');
                        score = studyData.options.length - parseInt(resultsData.scales[i]);
                    } else {
                        $(optionItem).find('#positive').removeClass('hidden');
                        score = parseInt(resultsData.scales[i]) + 1;
                    }

                    if (i < studyData.options.length - 1) {
                        var hr = document.createElement('hr');
                        $(hr).css({marginTop: "15px", marginBottom: "5px"});
                        $(item).find('.option-container').append(hr);
                    }

                    var selectedScale = parseInt(resultsData.scales[i]);

                    if (selectedScale === -1) {
                        $(item).find('#score-container').remove();
                        $(item).find('#no-answer').removeClass('hidden');
                    } else {
                        renderRatingSigns($(item).find('#score-container'), score);
                    }

                    for (var j = 0; j < studyData.options[i].scales.length; j++) {
                        var scaleItem = $('#template-study-container').find('#rating-scale-item').clone();
                        $(optionItem).find('#scale-container').append(scaleItem);
                        $(scaleItem).text((j + 1) + '. ' + studyData.options[i].scales[j]);

                        if (j === selectedScale) {
                            $(scaleItem).addClass('bordered-scale-item');
                        } else if (j === 0) {
                            $(scaleItem).css({paddingLeft: "0px"});
                        }
                    }
                }
            }

            function renderSumQuestion(item, studyData, resultsData) {
                $(item).find('.question').text(studyData.question);
                $(item).find('#maximum .label-text').text(translation.maximum + ': ' + studyData.parameters.maximum);
                $(item).find('#allocation .label-text').text(translation.scales[studyData.parameters.allocation]);

                var count = 0;
                for (var i = 0; i < resultsData.sumCounts.length; i++) {
                    var listItemAnswer = $('#template-study-container').find('#sum-question-item').clone();
                    count += parseInt(resultsData.sumCounts[i]);
                    $(listItemAnswer).text(studyData.options[i] + ': ' + resultsData.sumCounts[i] + ' ' + translation.scales[studyData.parameters.allocation]);
                    $(item).find('.option-container').append(listItemAnswer);
                }

                if (count === parseInt(studyData.parameters.maximum)) {
                    $(item).find('#distributeAllPoints').removeClass('hidden');
                } else {
                    $(item).find('#distributeNotAllPoints').removeClass('hidden');
                }
            }

            function renderRanking(item, studyData, resultsData) {
                $(item).find('.question').text(studyData.question);

                for (var i = 0; i < resultsData.arrangement.length; i++) {
                    var listItemAnswer = $('#template-study-container').find('#ranking-item').clone();
                    $(listItemAnswer).text((i + 1) + '. ' + studyData.options[parseInt(resultsData.arrangement[i])]);
                    $(item).find('.option-container').append(listItemAnswer);
                }
            }

            function renderAlternativeQuestion(item, studyData, resultsData) {
//                console.log(studyData, resultsData);

                $(item).find('.question').text(studyData.question);

                if (studyData.parameters.optionalanswer === 'yes') {
                    $(item).find('#optionalanswer').removeClass('hidden');
                }

                if (studyData.parameters.justification === 'yes') {
                    $(item).find('#justification').removeClass('hidden');
                    $(item).find('#' + studyData.parameters.justificationFor).removeClass('hidden');

                    if (studyData.parameters.justificationFor === 'selectOne' && resultsData.selectedOptions && resultsData.selectedOptions.length > 0 && resultsData.justification !== '') {
                        $(item).find('#justification-content').removeClass('hidden');
                        $(item).find('#justification-content .text').text(resultsData.justification);
                    } else if (studyData.parameters.justificationFor === 'selectNothing' && !resultsData.selectedOptions && resultsData.justification !== '') {
                        $(item).find('#justification-content').removeClass('hidden');
                        $(item).find('#justification-content .text').text(resultsData.justification);
                    } else if (studyData.parameters.justificationFor === 'always' && resultsData.justification !== '') {
                        $(item).find('#justification-content').removeClass('hidden');
                        $(item).find('#justification-content .text').text(resultsData.justification);
                    } else if (resultsData.selectedOptions && resultsData.selectedOptions.length > 0 && resultsData.justification === '') {
                        $(item).find('#no-answer').removeClass('hidden');
                    }
                } else {
                    $(item).find('#no-justification').removeClass('hidden');
                }

                if (studyData.parameters.alternative === 'gestures' && studyData.parameters.alternativeFor === 'alternativeGesture') {
                    $(item).find('#gesturesForGesture').removeClass('hidden');
                } else if (studyData.parameters.alternative === 'gestures' && studyData.parameters.alternativeFor === 'alternativeTrigger') {
                    $(item).find('#gesturesForTrigger').removeClass('hidden');
                } else if (studyData.parameters.alternative === 'triggers' && studyData.parameters.alternativeFor === 'alternativeTrigger') {
                    $(item).find('#triggersForTrigger').removeClass('hidden');
                } else {
                    $(item).find('#triggersForGesture').removeClass('hidden');
                }

                var options = null;
                var cloneItem = null;
                if (studyData.parameters.alternative === 'triggers') {
                    options = getLocalItem(ASSEMBLED_TRIGGER);
                    cloneItem = '#alternativeQuestion-trigger-item';

                } else if (studyData.parameters.alternative === 'gestures') {
                    options = assembledGestures();
                    cloneItem = '#alternativeQuestion-gesture-item';
                }

                for (var i = 0; i < options.length; i++) {
                    if (parseInt(options[i].id) !== parseInt(currentGUSData.gestureId)) {
                        var optionItem = $('#template-study-container').find(cloneItem).clone();
                        $(optionItem).find('.text').text(options[i].title);
                        $(item).find('.option-container').append(optionItem);

                        if (i < options.length - 1) {
                            $(item).find('.option-container').append(document.createElement('br'));
                        }

                        if (studyData.parameters.alternative === 'gestures') {
                            $(optionItem).find('.btn-popover-gesture-preview').attr('name', options[i].id);
                        }

                        if (resultsData.selectedOptions && resultsData.selectedOptions.length > 0) {
                            for (var j = 0; j < resultsData.selectedOptions.length; j++) {
                                if (parseInt(resultsData.selectedOptions[j]) === parseInt(options[i].id)) {
                                    $(optionItem).addClass('bordered-scale-item');
                                    break;
                                }
                            }
                        } else {
                            if (i === 0) {
//                                $(optionItem).css({paddingLeft: "0px"});
                            }
                        }
                    }
                }

                if (resultsData.optionalAnswer !== '') {
                    $(item).find('#optionalanswer-content').removeClass('hidden');
                    $(item).find('#optionalanswer-content .text').text(resultsData.optionalAnswer);
                } else {
                    $(item).find('#no-optional-answer').removeClass('hidden');
                }
            }

            function renderGUS(item, studyData, resultsData) {
                $(item).find('.question').text(studyData.question);

                var score = 0;
                if (studyData.parameters.negative === 'yes') {
                    $(item).find('#negative').removeClass('hidden');
                    score = translation.gusOptions.length - parseInt(resultsData.selectedOption);
                } else {
                    $(item).find('#positive').removeClass('hidden');
                    score = parseInt(resultsData.selectedOption) + 1;
                }

                var selectedOption = parseInt(resultsData.selectedOption);
                if (selectedOption === -1) {
                    $(item).find('#score-container').remove();
                    $(item).find('#no-answer').removeClass('hidden');
                } else {
                    renderRatingSigns($(item).find('#score-container'), score);
                }

                var options = translation.gusOptions;
                for (var i = 0; i < options.length; i++) {
                    var option = $('#template-study-container').find('#gus-single-item-option').clone();
                    $(option).text(options[i]);
                    $(item).find('.option-container').append(option);

                    if (i === selectedOption) {
                        $(option).addClass('bordered-scale-item');
                    } else if (i === 0) {
                        $(option).css({paddingLeft: "0px"});
                    }
                }
            }

            function renderSUSItem(item, studyData, resultsData) {
                $(item).find('.question').text(studyData.question);

                var score = 0;
                if (studyData.parameters.negative === 'yes') {
                    $(item).find('#negative').removeClass('hidden');
                    score = translation.susOptions.length - parseInt(resultsData.selectedOption);
                } else {
                    $(item).find('#positive').removeClass('hidden');
                    score = parseInt(resultsData.selectedOption) + 1;
                }

                var selectedOption = parseInt(resultsData.selectedOption);
                if (selectedOption === -1) {
                    $(item).find('#score-container').remove();
                    $(item).find('#no-answer').removeClass('hidden');
                } else {
                    renderRatingSigns($(item).find('#score-container'), score);
                }

                var options = translation.susOptions;
                for (var i = 0; i < options.length; i++) {
                    var option = $('#template-study-container').find('#sus-item-option').clone();
                    $(option).text(options[i]);
                    $(item).find('.option-container').append(option);

                    if (i === selectedOption) {
                        $(option).addClass('bordered-scale-item');
                    } else if (i === 0) {
                        $(option).css({paddingLeft: "0px"});
                    }
                }
            }

            function renderRatingSigns(container, score) {
                $(container).find('.score-text').text(score);
                if (score >= 4) {
                    $(container).find('.fa').addClass('fa-thumbs-up');
                } else if (score === 3) {
                    $(container).find('.fa').addClass('fa-caret-left');
                } else {
                    $(container).find('.fa').addClass('fa-thumbs-down');
                }
            }


            function renderGestureTraining(container, studyData, resultsData) {
                console.log(studyData, resultsData);

//                if (!resultsData.training) {
//                    appendAlert(container, )
//                }

                for (var i = 0; i < studyData.training.length; i++) {
                    var gesture = getGestureById(studyData.training[i].gestureId);
                    var trigger = getTriggerById(studyData.training[i].triggerId);
                    var feedback = getFeedbackById(studyData.training[i].feedbackId);

//                    console.log(gesture);

                    var item = $('#template-study-container').find('#training-gesture-item').clone().removeAttr('id');
                    container.find('#gestures-container').append(item);
                    renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage);
                    $(item).find('#gesture .address').text(translation.gesture + ': ');
                    $(item).find('#gesture .text').text(gesture.title);
                    $(item).find('#trigger .address').text(translation.trigger + ': ');
                    $(item).find('#trigger .text').text(trigger.title);
                    $(item).find('#repeats .address').text(translation.repeats + ': ');
                    $(item).find('#repeats .text').text(studyData.training[i].repeats);
                    $(item).find('#recognition-time .address').text(translation.recognitionTime + ': ');
                    var recognitionSeconds = parseInt(studyData.training[i].recognitionTime);
                    $(item).find('#recognition-time .text').text(recognitionSeconds + ' ' + (recognitionSeconds === 1 ? translation.timesSingular.seconds : translation.times.seconds));

                    $(item).find('#feedback .address').text(translation.feedback + ': ');
                    var feedbackItem = $('#template-study-container').find('#feedback-catalog-thumbnail').clone().removeAttr('id');
                    feedbackItem.find('.text').text(feedback.title);
                    feedbackItem.find('#' + feedback.type).removeClass('hidden');
                    if (feedback.type === TYPE_FEEDBACK_SOUND) {
                        feedbackItem.find('.audio-holder').attr('src', feedback.data);
                    }
                    $(item).find('#feedback .content').append(feedbackItem);

                    $(item).find('#training-time .address').text(translation.execution + ': ');
                    if (resultsData && resultsData.training && resultsData.training[i].gestureTrainingStart && resultsData.training[i].gestureTrainingEnd) {
                        var executionTime = getTimeBetweenTimestamps(resultsData.training[i].gestureTrainingStart, resultsData.training[i].gestureTrainingEnd);
                        $(item).find('#training-time .text').text(getTimeString(executionTime, false, true));
                    } else {
                        $(item).find('#training-time .text').text('-');
                    }
                }
            }


            function renderGestureSlideshow(container, studyData, resultsData) {
                console.log(studyData, resultsData);

                $(container).find('#restarts .address').text(parseInt(resultsData.restarts) === 1 ? translation.restart : translation.restarts);
                $(container).find('#restarts .text').text(resultsData.restarts);

                for (var i = 0; i < studyData.slideshow.length; i++) {
                    var gesture = getGestureById(studyData.slideshow[i].gestureId);
                    var trigger = getTriggerById(studyData.slideshow[i].triggerId);
//                    var feedback = getFeedbackById(studyData.slideshow[i].feedbackId);

                    var item = $('#template-study-container').find('#slideshow-gesture-item').clone().removeAttr('id');
                    container.find('#gestures-container').append(item);
                    renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage);
                    $(item).find('#gesture .address').text(translation.gesture + ': ');
                    $(item).find('#gesture .text').text(gesture.title);
                    $(item).find('#trigger .address').text(translation.trigger + ': ');
                    $(item).find('#trigger .text').text(trigger.title);
//                    $(item).find('#repeats .address').text(translation.repeats + ': ');
//                    $(item).find('#repeats .text').text(studyData.training[i].repeats);
                    $(item).find('#recognition-time .address').text(translation.recognitionTime + ': ');
                    var recognitionSeconds = parseInt(studyData.slideshow[i].recognitionTime);
                    $(item).find('#recognition-time .text').text(recognitionSeconds + ' ' + (recognitionSeconds === 1 ? translation.timesSingular.seconds : translation.times.seconds));

                    if (resultsData.actions && resultsData.actions.length > 0) {
                        var count = 0;
                        for (var j = 0; j < resultsData.actions.length; j++) {
                            if (resultsData.actions[j].action === ACTION_SELECT_GESTURE && parseInt(resultsData.actions[j].gestureId) === parseInt(gesture.id) && resultsData.actions[j].fit === 'false') {
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
            }

            function renderTriggerSlideshow(container, studyData, resultsData) {
                console.log(studyData, resultsData);
                var globalFaults = 0;
                for (var i = 0; i < studyData.slideshow.length; i++) {
                    var gesture = getGestureById(studyData.slideshow[i].gestureId);
                    var trigger = getTriggerById(studyData.slideshow[i].triggerId);
                    var item = $('#template-study-container').find('#slideshow-trigger-item').clone().removeAttr('id');
                    container.find('#gestures-container').append(item);
                    renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage);
                    $(item).find('#gesture .address').text(translation.gesture + ': ');
                    $(item).find('#gesture .text').text(gesture.title);
                    $(item).find('#trigger .address').text(translation.trigger + ': ');
                    $(item).find('#trigger .text').text(trigger.title);
                    $(item).find('#selection .address').text(translation.trigger + ' ' + translation.answer + ': ');

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
                    $(container).find('#score #error').removeClass('hidden');
                } else {

                    var faultScore = globalFaults / studyData.slideshow.length;
                    console.log('globalFaults: ' + globalFaults + ' fault: ' + fault + ', score: ' + faultScore);
                    $(container).find('#score .text').text(faultScore);
                }
            }


            function renderPhysicalStressTest(container, studyData, resultsData) {
                console.log(studyData, resultsData);
                for (var i = 0; i < studyData.stressTestItems.length; i++) {
                    var gesture = getGestureById(studyData.stressTestItems[i]);
                    var item = $('#template-study-container').find('#physicalStressTest-item').clone().removeAttr('id');
                    container.find('#gestures-container').append(item);
                    renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage);
                    $(item).find('#gesture .address').text(translation.gesture + ': ');
                    $(item).find('#gesture .text').text(gesture.title);
                    $(item).find('#trigger .address').text(translation.trigger + ': ');
                    $(item).find('#trigger .text').text(trigger.title);
                    $(item).find('#selection .address').text(translation.trigger + ' ' + translation.answer + ': ');


                    // check if answers are there
                    if (resultsData && resultsData.answers && resultsData.answers.length > 0) {
                        
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
//                        singleStressQuestionnaire = singleStressQuestionnaire.reverse();
                            var results = new Object();
                            results.answers = new Array();
                            var questions = new Array();

                            for (var j = 0; j < resultsData.answers.length; j++) {
                                if (parseInt(resultsData.answers[j].gestureId) === parseInt(gesture.id) && resultsData.answers[j].singleAnswers) {
                                    results.answers = results.answers.concat(resultsData.answers[j].singleAnswers.answers.reverse());
                                    questions = questions.concat(singleStressQuestionnaire);
                                }
                            }

                            if (questions.length > 0 && results.answers.length > 0) {
//                            results.answers = results.answers.reverse();
//                            console.log('singleStressQuestionnaire');
//                            console.log(questions, results);
                                renderQuestionnaire($(item).find('#single-stress-answers'), questions.reverse(), results);
                            }
                        }

                        // sequence answers section
                        var sequenceStressQuestionnaire = studyData.sequenceStressQuestions;
                        if (sequenceStressQuestionnaire && sequenceStressQuestionnaire.length > 0) {
//                        sequenceStressQuestionnaire = sequenceStressQuestionnaire.reverse();
                            var results = new Object();
                            results.answers = new Array();
                            var questions = new Array();

                            for (var j = 0; j < resultsData.answers.length; j++) {
                                if (parseInt(resultsData.answers[j].gestureId) === parseInt(gesture.id) && resultsData.answers[j].sequenceAnswers) {
//                                console.log(resultsData.answers[j].sequenceAnswers.answers);
                                    results.answers = results.answers.concat(resultsData.answers[j].sequenceAnswers.answers.reverse());
                                    questions = questions.concat(sequenceStressQuestionnaire);
                                }
                            }

                            if (questions.length > 0 && results.answers.length > 0) {
                                results.answers = results.answers.reverse();
//                            console.log('sequenceStressQuestionnaire');
//                            console.log(questions, results);
                                renderQuestionnaire($(item).find('#sequence-stress-answers'), questions.reverse(), results);
                            }
                        }
                    }
                }
            }

            function renderScenario(container, studyData, resultsData) {
                console.log(studyData, resultsData);
            }
        </script>
        <!--<script src="https://vjs.zencdn.net/5.8.8/video.js"></script>-->
    </body>
</html>
