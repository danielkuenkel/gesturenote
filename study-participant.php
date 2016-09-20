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

        <div class="container" id="phase-results">
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
//                    console.log(query, hash);
                    $('.breadcrumb #btn-study').on('click', function (event) {
                        event.preventDefault();
                        goto('study.php?studyId=' + query.studyId + '&h=' + hash);
                    });

                    getStudyParticipant({studyId: query.studyId, participantId: query.participantId}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
//                            if (result.data) {
                            console.log(result);
                            console.log(result.resultData);
                            renderData(result);
//                            } else {
//                                //                            appendAlert($('#item-view'), ALERT_NO_STUDIES);
//                            }
                        }
                    });
                }
            }

            function renderData(data) {
                var studyData = data.studyData;
                var resultData = data.resultData;

                // general data view
                $('#execution-date').text(convertSQLTimestampToDate(resultData.created).toLocaleString());
                $('#main-headline').text(studyData.generalData.title);
                if (isNaN(resultData.userId)) {
                    $('#item-view').find('#user .label-text').text(translation.userTypes.guest);
                } else {
                    $('#item-view').find('#user .label-text').text(translation.userTypes.registered);
                }

                if (resultData.data.studySuccessfull === 'yes') {
                    $('#item-view').find('.panel').addClass('panel-success');
                    $('#item-view').find('#execution-success').removeClass('hidden');
                    $('#item-view').find('#execution-success .label-text').text(translation.studySuccessful);
                } else {
                    $('#item-view').find('.panel').addClass('panel-danger');
                    $('#item-view').find('#execution-fault').removeClass('hidden');
                    $('#item-view').find('#execution-fault .label-text').text(translation.studyFault);
                }


//                // phase view
//                $('#study-phases .address').text(translation.phases);
                if (studyData.phases && studyData.phases.length > 0) {
                    for (var i = 0; i < studyData.phases.length; i++) {
                        var item = $('#template-study-container').find('#participant-phase').clone().removeAttr('id');
                        $(item).find('#headline').text((i + 1) + '. ' + translation.formats[studyData.phases[i].format].text);
                        $('#phase-results').append(item);
//                        var step = document.createElement('div');
//                        $(step).addClass('study-phase-step');
//                        $('#phase-steps-container').append(step);
//
//                        var iconContainer = document.createElement('div');
//                        $(iconContainer).addClass('study-phase-icon-container');
//                        $(step).append(iconContainer);
//
//                        var colorIcon = document.createElement('i');
//                        $(colorIcon).addClass('study-phase-step-color-icon fa fa-circle');
//                        $(colorIcon).css({color: studyData.phases[i].color});
//                        $(iconContainer).append(colorIcon);
//
//                        var icon = document.createElement('i');
//                        $(icon).addClass('study-phase-step-icon fa fa-circle-thin');
//                        $(iconContainer).append(icon);
//
//                        var iconMiddle = document.createElement('span');
//                        $(iconMiddle).addClass((i > 8) ? 'study-phase-step-middle-icon-small' : 'study-phase-step-middle-icon');
//                        $(iconMiddle).text(i + 1);
//                        $(iconContainer).append(iconMiddle);
//
//                        var text = document.createElement('span');
//                        $(text).addClass('text');
//                        $(text).text(translation.formats[studyData.phases[i].format].text);
//                        $(step).append(text);
//
//                        if (i < studyData.phases.length - 1) {
//                            var transition = document.createElement('i');
//                            $(transition).addClass('study-phase-step-transition fa fa-long-arrow-down');
//                            $('#phase-steps-container').append(transition);
//                            TweenMax.from($(transition), .2, {delay: (i * .05), y: -10, opacity: 0.0, clearProps: 'all'});
//                        }
//                        TweenMax.from($(step), .3, {delay: 0.2 + (i * .05), y: -10, opacity: 0, clearProps: 'all'});
                    }
                }
//
//                $('#btn-edit-study').on('click', {studyId: data.id}, function (event) {
//                    event.preventDefault();
//                    if (!$(this).hasClass('disabled')) {
//                        var hash = hex_sha512(parseInt(event.data.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
//                        goto("study-create.php?studyId=" + event.data.studyId + "&h=" + hash);
//                    }
//                });
//
//                $('#btn-preview-study').on('click', {studyId: data.id}, function (event) {
//                    event.preventDefault();
//                    if (!$(this).hasClass('disabled')) {
//                        var hash = hex_sha512(parseInt(event.data.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
//                        goto("study-preview.php?studyId=" + event.data.studyId + "&h=" + hash);
//                    }
//                });
//
//                $('#btn-delete-study').on('click', {studyId: data.id}, function (event) {
//                    event.preventDefault();
//                    if (!$(this).hasClass('disabled')) {
//                        deleteStudy({studyId: event.data.studyId}, function (result) {
//                            if (result.status === RESULT_SUCCESS) {
//                                gotoStudies();
//                            } else {
//
//                            }
//                        });
//                    }
//                });
//
//
//                // catalogs view
//                // check if there are study catalog data
//                var studyGestures = data.gestureCatalog;
//                var studyFeedback = studyData.assembledFeedback;
//                var studyScenes = studyData.assembledScenes;
//                var studyTrigger = studyData.assembledTrigger;
//                var noCatalogData = true;
//
//                if (studyGestures && studyGestures.length > 0) {
//                    setLocalItem(GESTURE_CATALOG, studyGestures);
//                    renderStudyGestures(studyGestures);
//                    noCatalogData = false;
//                }
//                if (studyScenes && studyScenes.length > 0) {
//                    renderStudyScenes(studyScenes);
//                    noCatalogData = false;
//                }
//                if (studyTrigger && studyTrigger.length > 0) {
//                    renderStudyTrigger(studyTrigger);
//                    noCatalogData = false;
//                }
//                if (studyFeedback && studyFeedback.length > 0) {
//                    renderStudyFeedback(studyFeedback);
//                    noCatalogData = false;
//                }
//
//                if (noCatalogData) {
//                    appendAlert($('#study-catalogs'), ALERT_NO_PHASE_DATA);
//                }
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

            function renderStudyScenes(scenes) {
                $('#study-scenes-catalog').removeClass('hidden');
                $('#study-scenes-catalog .address').text(translation.studyCatalogs.scenes);
                console.log(scenes);

                for (var i = 0; i < scenes.length; i++) {
                    var item = $('#template-study-container').find('#scenes-catalog-thumbnail').clone().removeAttr('id');
                    item.find('.text').text(scenes[i].title);
                    item.find('.label-text').text(translation.scenes[scenes[i].type]);
                    item.find('#' + scenes[i].type).removeClass('hidden');
                    $('#study-scenes-catalog .list-container').append(item);
                    TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                }
            }

            function renderStudyTrigger(trigger) {
                $('#study-trigger-catalog').removeClass('hidden');
                $('#study-trigger-catalog .address').text(translation.studyCatalogs.trigger);

                for (var i = 0; i < trigger.length; i++) {
                    var item = $('#template-study-container').find('#trigger-catalog-thumbnail').clone().removeAttr('id');
                    item.text(trigger[i].title);
                    $('#study-trigger-catalog .list-container').append(item);
                    TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                }
            }

            function renderStudyFeedback(feedback) {
                console.log(feedback);

                $('#study-feedback-catalog').removeClass('hidden');
                $('#study-feedback-catalog .address').text(translation.studyCatalogs.feedback);

                for (var i = 0; i < feedback.length; i++) {
                    var item = $('#template-study-container').find('#feedback-catalog-thumbnail').clone().removeAttr('id');
                    item.find('.text').text(feedback[i].title);
                    item.find('#' + feedback[i].type).removeClass('hidden');
                    if (feedback[i].type === TYPE_FEEDBACK_SOUND) {
                        item.find('.audio-holder').attr('src', feedback[i].data);
                    }
                    $('#study-feedback-catalog .list-container').append(item);
                    TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                }
            }


            function renderStudyParticipants(data) {
                var guestUsers = 0;
                var registeredUsers = 0;
                var successfullStudies = 0;

                for (var i = 0; i < data.length; i++) {
                    console.log(data[i].created);
                    var result = data[i].data;

                    var item = $('#template-study-container').find('#participant-thumbnail').clone().removeAttr('id');
                    $(item).find('.panel-heading').text(data[i].created);
//                    console.log($(item).find('.panel-heading').text('test'));
                    $('#study-participants .list-container').append(item);

                    if (isNaN(data[i].userId)) {
                        guestUsers++;
                        $(item).find('#user .label-text').text(translation.userTypes.guest);
                    } else {
                        registeredUsers++;
                        $(item).find('#user .label-text').text(translation.userTypes.registered);
                    }

                    if (result.studySuccessfull === 'yes') {
                        successfullStudies++;
                        $(item).find('.panel').addClass('panel-success');
                        $(item).find('#execution-success').removeClass('hidden');
                        $(item).find('#execution-success .label-text').text(translation.studySuccessful);
                    } else {
                        $(item).find('.panel').addClass('panel-danger');
                        $(item).find('#execution-fault').removeClass('hidden');
                        $(item).find('#execution-fault .label-text').text(translation.studyFault);
                    }
                }

                console.log('guests: ' + guestUsers + ', registered: ' + registeredUsers + ', success: ' + successfullStudies);
            }
        </script>
    </body>
</html>
