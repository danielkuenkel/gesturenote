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
        <script src="js/sha512.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
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

        <div class="container mainContent" style="margin-top: 35px;" id="item-view">
            <h2 id="main-headline" style="margin-top: 0"></h2>
            <hr>
            <span class="text pull-right" id="execution-date"></span>
            <span class="label label-default" id="user"><i class="fa fa-user"></i> <span class="label-text"></span></span>
            <span class="label label-success hidden" id="execution-success"><i class="fa fa-check"></i> <span class="label-text hidden-xs"></span></span>
            <span class="label label-danger hidden" id="execution-fault"><i class="fa fa-times"></i> <span class="label-text hidden-xs"></span></span>
        </div>

        <div class="container-fluid hidden" id="annotation-view"></div>

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
                    externals.push(['#alerts', PATH_EXTERNALS + '/' + currentLanguage + '/alerts.html']);
                    externals.push(['#template-subpages', PATH_EXTERNALS + '/' + currentLanguage + '/template-sub-pages.html']);
                    externals.push(['#template-study', PATH_EXTERNALS + '/' + currentLanguage + '/template-study.html']);
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
                            console.log(result.resultData);
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
                    $('#item-view').find('#user .label-text').text(translation.userTypes.guest);
                } else {
                    $('#item-view').find('#user .label-text').text(translation.userTypes.registered);
                }

                if (results.studySuccessfull === 'yes') {
                    $('#item-view').find('.panel').addClass('panel-success');
                    $('#item-view').find('#execution-success').removeClass('hidden');
                    $('#item-view').find('#execution-success .label-text').text(translation.studySuccessful);
                } else {
                    $('#item-view').find('.panel').addClass('panel-danger');
                    $('#item-view').find('#execution-fault').removeClass('hidden');
                    $('#item-view').find('#execution-fault .label-text').text(translation.studyFault);
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


//                // catalogs view
//                // check if there are study catalog data
//                var studyGestures = data.gestureCatalog;
//
//                if (studyGestures && studyGestures.length > 0) {
//                    setLocalItem(GESTURE_CATALOG, studyGestures);
//                    renderStudyGestures(studyGestures);
//                }
//                
            }

            $(document).on('click', '#phase-results-nav button', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('active')) {
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

                    var executionTime = getTimeBetweenTimestamps(parseInt(phaseResults.startTime), parseInt(phaseResults.endTime));
                    if (!isEmpty(executionTime)) {
                        var badge = document.createElement('span');
                        $(badge).addClass('badge pull-right');
                        $(badge).text(translation.lapse + ' ' + getTimeString(executionTime));
                        $(content).find('#headline').append(badge);
                    }

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
                    }

                    $(content).css({y: 0, opacity: 1});
                    TweenMax.from(content, .2, {opacity: 0, y: -60});
                } else {
                    console.log('no results');
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

            function renderQuestionnaire(content, studyData, resultsData) {
                for (var i = 0; i < studyData.length; i++) {
                    var listItem = $('#template-study-container').find('#' + studyData[i].format).clone();
                    listItem.find('#format .format-text').text(translation.questionFormats[studyData[i].format].text);
                    $(content).find('.list-container').append(listItem);

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
                            break;
                        case GROUPING_QUESTION:
                            renderGroupingQuestion(listItem, studyData[i], resultsData.answers[i]);
                            break;
                        case GROUPING_QUESTION_GUS:
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
                            break;
                        case GUS_SINGLE:
                            break;
                        case SUS:
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
                console.log(studyData, resultsData);
                var parameters = studyData.parameters;
                $(item).find('.question').text(studyData.question);
                $(item).find('#counter-label .counter-from').text(translation.of + ' ' + translation.atLeast + ' ' + parameters.countFrom);
                $(item).find('#counter-label .counter-to').text(translation.to + ' ' + translation.maximal + ' ' + parameters.countTo);
                if (resultsData.count && resultsData.count !== '') {
                    $(item).find('.answer').text(resultsData.count);
                } else {

                }
            }

            function renderOpenQuestion(item, studyData, resultsData) {
                console.log(studyData, resultsData);
                $(item).find('.question').text(studyData.question);
                if (resultsData.openAnswer && resultsData.openAnswer !== '') {
                    $(item).find('.answer').text(resultsData.openAnswer);
                } else {

                }
            }

            function renderDichotomousQuestion(item, studyData, resultsData) {
                console.log(studyData, resultsData);
                $(item).find('.question').text(studyData.question);

            }

            function renderGroupingQuestion(item, studyData, resultsData) {
                console.log(studyData, resultsData);
                $(item).find('.question').text(studyData.question);
            }

            function renderRating(item, studyData, resultsData) {
                console.log(studyData, resultsData);
                $(item).find('.question').text(studyData.question);
            }

            function renderSumQuestion(item, studyData, resultsData) {
//                console.log(studyData, resultsData);
                $(item).find('.question').text(studyData.question);
                $(item).find('#maximum .label-text').text(translation.maximum + ': ' + studyData.parameters.maximum);
                $(item).find('#allocation .label-text').text(translation.scales[studyData.parameters.allocation]);

                var count = 0;
                for (var i = 0; i < resultsData.sumCounts.length; i++) {
                    var listItemAnswer = $('#template-study-container').find('#sum-question-item').clone();
                    count += parseInt(resultsData.sumCounts[i]);
                    $(listItemAnswer).text(studyData.options[i] + ': ' + resultsData.sumCounts[i] + ' ' + translation.scales[studyData.parameters.allocation]);
                    $(item).find('.options-container').append(listItemAnswer);
                }

                console.log(count, studyData.parameters.maximum);
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
                    $(item).find('.options-container').append(listItemAnswer);
                }
            }

        </script>
    </body>
</html>
