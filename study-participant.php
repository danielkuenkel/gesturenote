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
        <title><?php echo $lang->gestureNote ?></title>
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
        <script src="js/forms.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/rtc-result-player.js"></script>

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
        <div class="container" id="breadcrumb" style="padding-top: 40px">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-studies"><i class="fa fa-tasks" aria-hidden="true"></i> <?php echo $lang->breadcrump->studies ?></a></li>
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
        <div class="container mainContent" style="margin-top: 0px;" id="general-view">
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
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-gesture', PATH_EXTERNALS + 'template-gesture.php']);
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                    externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    externals.push(['#template-study', PATH_EXTERNALS + 'template-study.php']);
                    externals.push(['#template-previews', PATH_EXTERNALS + 'template-previews.php']);
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

                if (results.aborted === 'no' && results.studySuccessfull === 'yes') {
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
                        $(text).text(studyData.phases[i].title);
                        $(navItem).append(text);

                        TweenMax.from($(navItem), .3, {delay: 0.2 + (i * .05), y: -10, opacity: 0, clearProps: 'all'});
                    }

                    var status = window.location.hash.substr(1);
                    var statusAddressMatch = statusAddressMatchIndex(status);
                    if (status !== '' && statusAddressMatch !== null) {
                        $('#phase-results-nav').find('#' + statusAddressMatch.id).click();
                    } else {
                        $('#phase-results-nav').children().first().click();
                    }
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
                    renderStudyPhaseResult(selectedId);
                    window.location.hash = selectedId;
                }
            });

            function renderStudyPhaseResult(phaseId) {
                var phaseData = getLocalItem(phaseId + '.data');
                var testerResults = getLocalItem(phaseId + '.results');
                var evaluatorResults = getLocalItem(phaseId + '.evaluator');
//                console.log(phaseData, phaseResults);

                if (phaseData && testerResults) {
                    var content = $('#template-study-container').find('#' + testerResults.format).clone().removeAttr('id');
                    $(content).find('#headline').text(translation.formats[testerResults.format].text);
                    $('#phase-result').empty().append(content);

                    var executionTime = getLocalItem(STUDY).surveyType === TYPE_SURVEY_MODERATED ? getTimeBetweenTimestamps(evaluatorResults.startTime, evaluatorResults.endTime) : getTimeBetweenTimestamps(testerResults.startTime, testerResults.endTime);

//                    console.log(executionTime);
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
                    if (isWebRTCNeededForPhaseStep(testerResults)) {
                        if (testerResults && testerResults.recordUrl && testerResults.recordUrl !== '') {
                            var resultsPlayer = new RTCResultsPlayer(testerResults, evaluatorResults, phaseData, executionTime);
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

                    console.log('render phase step: ' + testerResults.format);
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
                        case GUS_SINGLE_GESTURES:
                            renderSingleGUS(content, phaseData, testerResults);
                            break;
                        case GUS_MULTIPLE_GESTURES:
                            renderQuestionnaireAnswers(content, getAssembledItems(phaseData.gus), testerResults, true);
                            break;
                        case GESTURE_TRAINING:
                            renderGestureTraining(content, phaseData, testerResults);
                            break;
                        case SLIDESHOW_GESTURES:
                            renderGestureSlideshow(content, phaseData, testerResults);
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

            function renderSUS(content, studyData, resultsData) {
//                console.log(studyData, resultsData);
                renderQuestionnaireAnswers(content, studyData, resultsData, true);

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
                renderQuestionnaireAnswers(content, getAssembledItems(studyData.gus), resultsData, true);

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

                renderObservation($(container), studyData, getObservationResults($('#phase-results-nav').find('.active').attr('id')));
//                addObservationsDropdown(container);
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

                console.log($('#phase-results-nav').find('.active').attr('id'));
                renderObservation($(container), studyData, getObservationResults($('#phase-results-nav').find('.active').attr('id')));
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
                            var results = new Object();
                            results.answers = new Array();
                            var questions = new Array();

                            for (var j = 0; j < resultsData.answers.length; j++) {
                                if (parseInt(resultsData.answers[j].gestureId) === parseInt(gesture.id) && resultsData.answers[j].singleAnswers) {
                                    results.answers = results.answers.concat(resultsData.answers[j].singleAnswers.answers);
                                    questions = questions.concat(singleStressQuestionnaire);
                                }
                            }

                            if (questions.length > 0 && results.answers.length > 0) {
                                renderQuestionnaireAnswers($(item).find('#single-stress-answers'), questions, results, true, true);
                            }
                        }

                        // sequence answers section
                        var sequenceStressQuestionnaire = studyData.sequenceStressQuestions;
                        if (sequenceStressQuestionnaire && sequenceStressQuestionnaire.length > 0) {
                            var results = new Object();
                            results.answers = new Array();
                            var questions = new Array();

                            for (var j = 0; j < resultsData.answers.length; j++) {
                                if (parseInt(resultsData.answers[j].gestureId) === parseInt(gesture.id) && resultsData.answers[j].sequenceAnswers) {
                                    results.answers = results.answers.concat(resultsData.answers[j].sequenceAnswers.answers);
                                    questions = questions.concat(sequenceStressQuestionnaire);
                                }
                            }

                            if (questions.length > 0 && results.answers.length > 0) {
                                renderQuestionnaireAnswers($(item).find('#sequence-stress-answers'), questions, results, true, true);
                            }
                        }
                    }
                }

                renderObservation($(container), studyData, getObservationResults($('#phase-results-nav').find('.active').attr('id')));
            }

            function renderScenario(container, studyData, resultsData) {
                console.log($('#phase-results-nav').find('.active').attr('id'));
                renderObservation($(container), studyData, getObservationResults($('#phase-results-nav').find('.active').attr('id')));
//                addObservationsDropdown(container);
            }

            function renderIdentification(container, studyData, phaseResults) {
                console.log(studyData, phaseResults, getLocalItem(GESTURE_CATALOG));

//                if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_MODERATED) {
//
//                } else {
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
                            $(row).append(item);

                            var triggerText = document.createElement('div');
                            $(triggerText).addClass('col-xs-6 col-lg-8');
                            $(triggerText).html('<span class=text>' + translation.trigger + ':</span> <span>' + getTriggerById(gestureTriggerPairs[i].triggerId).title + '</span>');
                            $(row).append(triggerText);

                            if (i < gestureTriggerPairs.length - 1) {
                                var line = document.createElement('hr');
                                $(line).css({margin: 0, marginBottom: 20});
                                $(column).append(line);
                            }
                            TweenMax.from(item, .2, {delay: i * .1, opacity: 0, y: -10});
                        }
                    } else {
                        console.log('no gestures there');
                        appendAlert(content, ALERT_NO_PHASE_DATA);
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
//                }
                renderObservation($(container), studyData, getObservationResults($('#phase-results-nav').find('.active').attr('id')));
            }

            function renderExploration(container, phaseData, testerResults, evaluatorResults) {
                console.log(phaseData, testerResults, evaluatorResults);

                console.log('exploration type: ' + phaseData.explorationType);
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
                        for (var i = 0; i < testerResults.answers.length; i++) {
                            var trigger = getTriggerById(testerResults.answers[i].triggerId);

                            var preferredGesture = testerResults.answers[i].preferredGestures[0];
                            var answer = preferredGesture;

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

                        renderQuestionnaireAnswers($(answerItem), questionnaire, {answers: [answer]}, true, false);
                    }
                }

                renderObservation($(container).find('#observations'), phaseData, getObservationResults($('#phase-results-nav').find('.active').attr('id')));
            }

            function renderObservation(target, studyData, observationResults) {
                console.log('observationResults', studyData.observations);
                if (observationResults && observationResults.length > 0) {
                    console.log(observationResults);
                    renderQuestionnaire(target, studyData.observations, {answers: observationResults});
//                    renderEditableObservations(target, studyData.observations, {answers:observationResults});
                } else {
                    renderQuestionnaire(target, studyData.observations, null);
                }


                $(target).find('#observations-container').on('change', function (event) {
                    console.log('change observations');
                    saveObservationAnwers($(target).find('#observations-container'), getLocalItem(STUDY).id, getLocalItem(STUDY_RESULTS).userId, $('#phase-results-nav').find('.active').attr('id'));
                });
            }

            function addObservationsDropdown(container) {
//                console.log(container);
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

        </script>
    </body>
</html>
