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

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content root">
                </div>
            </div>
        </div>


        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb" style="padding-top: 40px">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-studies"><?php echo $lang->breadcrump->studies ?></a></li>
                    <li class="active"><?php echo $lang->breadcrump->study ?></li>
                </ol>
            </div>
        </div>

        <!-- Container (Landing Section) -->
        <!--        <div class="container-fluid text-center bg-grey" id="landingText">
                    <div class="container">
                        <h1><i class="fa fa-tasks" style="font-size: 60pt" aria-hidden="true"></i> STUDIEN</h1>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>-->

        <!-- Container (Panel Section) -->
        <div class="container mainContent" id="item-view">
            <h2 id="study-headline" style="margin-top: 0"></h2>
            <hr>
            <div class="label label-default" id="type-phase"></div>
            <div class="label label-default" id="type-survey"></div>
            <div class="label label-default hidden" id="panel-survey"><?php echo $lang->panelSurvey ?></div>

            <div class="row" style="margin-top: 20px">
                <div class="col-sm-6 col-lg-7">
                    <div id="study-description">
                        <h3 class="address"></h3>
                        <p class="text"></p>
                    </div>
                    <div class="hidden study-no-plan"><i class="fa fa-calendar-times-o" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>
                    <div class="hidden study-plan"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>
                    <div class="hidden panel-survey"><i class="fa fa-users" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>
                </div>
                <div class="col-sm-5 col-sm-offset-1 col-lg-4 col-lg-offset-1">
                    <div id="study-phases">
                        <h3 class="address"></h3>
                        <div class="alert-space alert-no-phase-data"></div>
                        <div id="phase-steps-container" style="margin-top: 15px"></div>
                    </div>
                    <div class="btn-group-vertical btn-block" style="margin-top: 50px">
                        <button class="btn btn-default btn-shadow" type="button" id="btn-edit-study"><i class="fa fa-pencil" aria-hidden="true"></i> <span class="btn-text">Studie bearbeiten</span></button>
                        <button class="btn btn-default btn-shadow" type="button" id="btn-preview-study"><i class="fa fa-eye" aria-hidden="true"></i> <span class="btn-text">Vorschau der Studie</span></button>
                        <button class="btn btn-default btn-shadow" type="button" id="btn-delete-study"><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-text">Studie löschen</span></button>
                        <button class="btn btn-default btn-shadow" type="button" id="btn-prepare-study"><i class="fa fa-inbox" aria-hidden="true"></i> <span class="btn-text">Studie durchführen</span></button>
                    </div>
                </div>

                <div class="col-sm-12" style="margin-top: 20px;" id="copy-to-clipboard">
                    <div class="input-group">
                        <div class="input-group-addon">Studien-URL</div>
                        <input type="text" class="form-control" id="static-study-url">
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-shadow" type="button" id="btn-open-static-study-url"><i class="fa fa-external-link" aria-hidden="true"></i> <span><?php echo $lang->openStudyUrl ?></span></button>
                        </span>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row" style="margin-top: 20px">
                <div class="col-xs-12">
                    <div id="study-catalogs">
                        <h3 class="address">Kataloge</h3>
                        <div class="alert-space alert-no-phase-data"></div>
                        <div id="study-gestures-catalog" class="hidden">
                            <h4 class="address"></h4>
                            <div class="list-container row" id="gestures-list-container"></div>
                        </div>
                        <div id="study-scenes-catalog" class="hidden" style="margin-top: 20px;">
                            <h4 class="address"></h4>
                            <div class="list-container"></div>
                        </div>
                        <div class="row" style="margin-top: 20px;">
                            <div id="study-trigger-catalog" class="hidden col-sm-6">
                                <h4 class="address"></h4>
                                <div class="list-container"></div>
                            </div>
                            <div id="study-feedback-catalog" class="hidden col-sm-6" style="margin-top: 20px;">
                                <h4 class="address"></h4>
                                <div class="list-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row" style="margin-top: 20px" id="study-participants">
                <div class="col-xs-12">
                    <h3 class="address">Teilnahmen</h3>
                    <div class="alert-space alert-no-phase-data"></div>
                    <div class="list-container row" style="margin-top: 20px"></div>
                </div>
            </div>

            <hr>

        </div>


        <script>
            $(document).ready(function () {
                checkDomain();
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    externals.push(['#template-study', PATH_EXTERNALS + 'template-study.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
                var query = getQueryParams(document.location.search);
                var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');

                if (query.studyId && query.h === hash) {
                    getStudyById({studyId: query.studyId}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
//                            if (result.data) {
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

                // general data view
                $('#study-headline').text(studyData.generalData.title);
                $('#type-survey').text(translation.surveyType[studyData.generalData.surveyType]);
                $('#type-phase').text(translation.phaseType[studyData.generalData.phase]);
                $('#study-description .address').text(translation.description);
                $('#study-description .text').text(studyData.generalData.description);

                if (studyData.generalData.panelSurvey === 'yes') {
                    $('#panel-survey, .panel-survey').removeClass('hidden');
                    $('.panel-survey .address').text(translation.panelSurvey + ":");
                    var ageFrom = studyData.generalData.ageRange.split(',')[0];
                    var ageTo = studyData.generalData.ageRange.split(',')[1];
                    $('.panel-survey .text').text(translation.genderTypes[studyData.generalData.gender] + " " + translation.of + " " + ageFrom + " " + translation.to + " " + ageTo);
                }

                // date range view
                var now = new Date().getTime();
                var dateFrom = studyData.generalData.dateFrom * 1000;
                var dateTo = addDays(studyData.generalData.dateTo * 1000, 1);
                var totalDays = rangeDays(dateFrom, dateTo);

                if ((studyData.generalData.dateFrom !== null && studyData.generalData.dateFrom !== "") &&
                        (studyData.generalData.dateTo !== null && studyData.generalData.dateTo !== "")) {
                    $('.study-plan').find('.address').text(now > dateTo ? translation.studyRuns : translation.studyRun + " " + translation.from + ":");
                    $('.study-plan').find('.text').text(new Date(dateFrom).toLocaleDateString() + " " + translation.to + " " + new Date(dateTo).toLocaleDateString() + ", " + totalDays + " " + (totalDays === 1 ? translation.day : translation.days));
                    $('.study-plan').removeClass('hidden');

                    getStudyResults({studyId: data.id}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            if (now > dateFrom && result.studyResults && result.studyResults.length > 0) { // check either if there are study results
//                                $('#btn-edit-study, #btn-delete-study').remove();
                                renderStudyParticipants(result.studyResults);
                            } else {
                                appendAlert($('#study-participants'), ALERT_NO_PHASE_DATA);
                            }
                        }
                    });

                } else {
                    $('#study-range-days .text').text('0 ' + translation.days);
                    $('.study-no-plan').removeClass('hidden').find('.text').text(translation.studyNoPlan);
                }


                if (studyData.phases && studyData.phases.length > 0 &&
                        (studyData.generalData.dateFrom !== null && studyData.generalData.dateFrom !== "") &&
                        (studyData.generalData.dateTo !== null && studyData.generalData.dateTo !== "")) {

                    // url copy clipboard view
                    var absoluteStaticStudyUrl = 'https://gesturenote.de/study-prepare.php?studyId=' + data.id + '&h=' + data.urlToken;
                    var relativeStaticStudyUrl = 'study-prepare.php?studyId=' + data.id + '&h=' + data.urlToken;
                    $('#static-study-url').val(absoluteStaticStudyUrl);
                    $('#static-study-url').click(function () {
                        $('#static-study-url').select();
                    });

                    // prepare study
                    if (studyData.generalData.surveyType === TYPE_SURVEY_MODERATED &&
                            now > dateFrom && now < dateTo) {
                        $('#btn-prepare-study, #btn-open-static-study-url').on('click', {url: relativeStaticStudyUrl}, function (event) {
                            event.preventDefault();
                            if (!$(this).hasClass('disabled')) {
                                goto(event.data.url);
                            }
                        });
                    } else {
                        $('#btn-prepare-study').remove();
                        $('#btn-open-static-study-url').parent().remove();
                    }
                } else {
                    $('#copy-to-clipboard').remove();
                    $('#btn-prepare-study').remove();
                }


                // phase view
                $('#study-phases .address').text(translation.phases);
                if (studyData.phases && studyData.phases.length > 0) {
                    for (var i = 0; i < studyData.phases.length; i++) {
                        var step = document.createElement('div');
                        $(step).addClass('study-phase-step');
                        $('#phase-steps-container').append(step);

                        var iconContainer = document.createElement('div');
                        $(iconContainer).addClass('study-phase-icon-container');
                        $(step).append(iconContainer);

                        var colorIcon = document.createElement('i');
                        $(colorIcon).addClass('study-phase-step-color-icon fa fa-circle');
                        $(colorIcon).css({color: studyData.phases[i].color});
                        $(iconContainer).append(colorIcon);

                        var icon = document.createElement('i');
                        $(icon).addClass('study-phase-step-icon fa fa-circle-thin');
                        $(iconContainer).append(icon);

                        var iconMiddle = document.createElement('span');
                        $(iconMiddle).addClass((i > 8) ? 'study-phase-step-middle-icon-small' : 'study-phase-step-middle-icon');
                        $(iconMiddle).text(i + 1);
                        $(iconContainer).append(iconMiddle);

                        var text = document.createElement('span');
                        $(text).addClass('text');
                        $(text).text(translation.formats[studyData.phases[i].format].text);
                        $(step).append(text);

                        if (i < studyData.phases.length - 1) {
                            var transition = document.createElement('i');
                            $(transition).addClass('study-phase-step-transition fa fa-long-arrow-down');
                            $('#phase-steps-container').append(transition);
                            TweenMax.from($(transition), .2, {delay: (i * .05), y: -10, opacity: 0.0, clearProps: 'all'});
                        }
                        TweenMax.from($(step), .3, {delay: 0.2 + (i * .05), y: -10, opacity: 0, clearProps: 'all'});
                    }
                } else {
                    appendAlert($('#item-view'), ALERT_NO_PHASE_DATA);
                    $('#btn-preview-study').addClass('disabled');
                }

                $('#btn-edit-study').on('click', {studyId: data.id}, function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
                        var hash = hex_sha512(parseInt(event.data.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                        goto("study-create.php?studyId=" + event.data.studyId + "&h=" + hash);
                    }
                });

                $('#btn-preview-study').on('click', {studyId: data.id}, function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
                        var hash = hex_sha512(parseInt(event.data.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                        goto("study-preview.php?studyId=" + event.data.studyId + "&h=" + hash);
                    }
                });

                $('#btn-delete-study').on('click', {studyId: data.id}, function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
                        deleteStudy({studyId: event.data.studyId}, function (result) {
                            if (result.status === RESULT_SUCCESS) {
                                gotoStudies();
                            } else {

                            }
                        });
                    }
                });


                // catalogs view
                // check if there are study catalog data
                var studyGestures = data.gestureCatalog;
                var studyFeedback = studyData.assembledFeedback;
                var studyScenes = studyData.assembledScenes;
                var studyTrigger = studyData.assembledTrigger;
                var noCatalogData = true;

                if (studyGestures && studyGestures.length > 0) {
                    setLocalItem(GESTURE_CATALOG, studyGestures);
                    renderStudyGestures(studyGestures);
                    noCatalogData = false;
                }
                if (studyScenes && studyScenes.length > 0) {
                    renderStudyScenes(studyScenes);
                    noCatalogData = false;
                }
                if (studyTrigger && studyTrigger.length > 0) {
                    renderStudyTrigger(studyTrigger);
                    noCatalogData = false;
                }
                if (studyFeedback && studyFeedback.length > 0) {
                    renderStudyFeedback(studyFeedback);
                    noCatalogData = false;
                }

                if (noCatalogData) {
                    appendAlert($('#study-catalogs'), ALERT_NO_PHASE_DATA);
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

            function renderStudyScenes(scenes) {
                $('#study-scenes-catalog').removeClass('hidden');
                $('#study-scenes-catalog .address').text(translation.studyCatalogs.scenes);
                setLocalItem(ASSEMBLED_SCENES, scenes);

                for (var i = 0; i < scenes.length; i++) {
                    var item = $('#template-study-container').find('#scenes-catalog-thumbnail').clone().removeAttr('id');
                    item.find('.text').text(scenes[i].title);
                    item.find('.label-text').text(translation.sceneTypes[scenes[i].type]);
                    item.find('#' + scenes[i].type).removeClass('hidden');
                    $('#study-scenes-catalog .list-container').append(item);
                    TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});

                    $(item).find('#btn-preview-scene').click({sceneId: scenes[i].id}, function (event) {
                        event.preventDefault();
                        currentSceneId = event.data.sceneId;
                        loadHTMLintoModal('custom-modal', 'modal-scene.php', 'modal-lg');
                    });
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
//                console.log(feedback);

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
                    var result = data[i].data;

                    var item = $('#template-study-container').find('#participant-thumbnail').clone().removeAttr('id');
                    $(item).find('.panel-heading').text(convertSQLTimestampToDate(data[i].created).toUTCString());
//                    console.log($(item).find('.panel-heading').text('test'));
                    $('#study-participants .list-container').append(item);

                    if (isNaN(data[i].userId)) {
                        guestUsers++;
                        $(item).find('#user .label-text').text(translation.userTypes.guest);
                    } else {
                        registeredUsers++;
                        $(item).find('#user .label-text').text(translation.userTypes.registered);
                    }
                    
                    if (result.aborted === 'no') {
                        successfullStudies++;
                        $(item).find('.panel').addClass('panel-success');
                        $(item).find('#execution-success').removeClass('hidden');
                        $(item).find('#execution-success .label-text').text(translation.studySuccessful);
                    } else {
                        $(item).find('.panel').addClass('panel-danger');
                        $(item).find('#execution-fault').removeClass('hidden');
                        $(item).find('#execution-fault .label-text').text(translation.studyFault);
                    }

                    $(item).find('.panel').on('click', {studyId: data[i].studyId, participantId: data[i].userId}, function (event) {
                        event.preventDefault();
                        var hash = hex_sha512(event.data.studyId + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                        clearLocalItems();
                        goto('study-participant.php?studyId=' + event.data.studyId + '&participantId=' + event.data.participantId + '&h=' + hash);
                    });
                }

                console.log('guests: ' + guestUsers + ', registered: ' + registeredUsers + ', success: ' + successfullStudies);
            }
        </script>
    </body>
</html>
