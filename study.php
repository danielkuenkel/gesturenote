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

        <div class="container">
            <ul class="nav nav-tabs" role="tablist" id="tab-pane">
                <li role="presentation" id="general"><a href="#general-infos" aria-controls="general-infos" role="tab" data-toggle="tab">Allgemeines</a></li>
                <li role="presentation" id="catalogs"><a href="#study-catalogs" aria-controls="study-catalogs" role="tab" data-toggle="tab">Kataloge</a></li>
                <!--                <li role="presentation" class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                        Kataloge <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li role="presentation"><a href="#study-gestures" aria-controls="study-gestures" role="tab" data-toggle="tab">Studien-Gesten</a></li>
                                        <li role="presentation"><a href="#study-scenes" aria-controls="study-scenes" role="tab" data-toggle="tab">Studien-Zustände</a></li>
                                        <li role="presentation"><a href="#study-trigger" aria-controls="study-trigger" role="tab" data-toggle="tab">Studien-Funktionen</a></li>
                                        <li role="presentation"><a href="#study-feedback" aria-controls="study-feedback" role="tab" data-toggle="tab">Studien-Feedback</a></li>
                                    </ul>
                                </li>-->
                <li role="presentation" id="participants"><a href="#study-participants" aria-controls="study-participants" role="tab" data-toggle="tab">Teilnahmen</a></li>
                <li role="presentation" class="hidden" id="extraction"><a href="#gesture-extraction" aria-controls="gesture-extraction" role="tab" data-toggle="tab">Extraktion</a></li>
            </ul>
        </div>


        <!-- Container (Panel Section) -->
        <div class="container mainContent tab-content" id="main-content">

            <div role="tabpanel" class="tab-pane" id="general-infos">
                <h2 id="study-headline" style="margin-top: 0"></h2>
                <!--<hr>-->
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
            </div>

            <div role="tabpanel" class="tab-pane" id="study-catalogs">
                <!--                <div class="row">
                                    <div class="col-xs-12">-->
                <!--<div id="study-catalogs">-->
                <!--<h3 class="address">Kataloge</h3>-->
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
                <!--</div>-->
                <!--</div>-->
                <!--</div>-->
            </div>

            <!--            <div role="tabpanel" class="tab-pane" id="study-gestures">
                            <div id="study-gestures-catalog" class="hidden">
                                <h4 class="address"></h4>
                                <div class="list-container row" id="gestures-list-container"></div>
                            </div>
                        </div>
            
                        <div role="tabpanel" class="tab-pane" id="study-scenes">
                            <div id="study-scenes-catalog" class="hidden" style="margin-top: 20px;">
                                <h4 class="address"></h4>
                                <div class="list-container"></div>
                            </div>
                        </div>
            
                        <div role="tabpanel" class="tab-pane" id="study-trigger">
                            <div id="study-trigger-catalog" class="hidden col-sm-6">
                                <h4 class="address"></h4>
                                <div class="list-container"></div>
                            </div>
                        </div>
            
                        <div role="tabpanel" class="tab-pane" id="study-feedback">
                            <div id="study-feedback-catalog" class="hidden col-sm-6" style="margin-top: 20px;">
                                <h4 class="address"></h4>
                                <div class="list-container"></div>
                            </div>
                        </div>-->

            <div role="tabpanel" class="tab-pane" id="study-participants">
                <!--<div class="row">-->
                <!--<div class="col-xs-12">-->
                <!--<h3 class="address">Teilnahmen</h3>-->
                <div class="alert-space alert-no-phase-data"></div>
                <div class="alert-space alert-no-plan"></div>

                <div class="list-container row"></div>
                <!--</div>-->
                <!--</div>-->
            </div>

            <div role="tabpanel" class="tab-pane" id="gesture-extraction">
                <div class="alert-space alert-no-phase-data"></div>

                <div id="extraction-content" class="row">

                    <div class="col-sm-4 col-md-3" id="extraction-navigation">
                        <h5 class="text">Vorbereitung</h5>
                        <div class="btn-group-vertical btn-block" id="btns-general">
                            <button class="btn btn-default btn-shadow" type="button" id="btn-all-gestures"><span class="btn-text">Alle ermittelten Gesten</span></button>
                            <button class="btn btn-default btn-shadow" type="button" id="btn-gesture-classification"><span class="btn-text">Gesten-Klassifizierung</span></button>
                        </div>

                        <h5 class="text" style="margin-top: 20px">Extraktion</h5>
                        <div class="btn-group-vertical btn-block" id="btns-extraction">
                            <button class="btn btn-default btn-shadow disabled" type="button" id="btn-number-of-gestures"><span class="btn-text">Anzahl der Gesten</span></button>
                            <button class="btn btn-default btn-shadow disabled" type="button" id="btn-guessability"><span class="btn-text">Formel der Erratbarkeit</span></button>
                            <button class="btn btn-default btn-shadow disabled" type="button" id="btn-cognitive-relationships"><span class="btn-text">Sinnzusammenhänge</span></button>
                            <button class="btn btn-default btn-shadow disabled" type="button" id="btn-preferred-gestures"><span class="btn-text">Bevorzugte Gesten</span></button>
                            <button class="btn btn-default btn-shadow disabled" type="button" id="btn-checklist"><span class="btn-text">Checkliste</span></button>
                        </div>
                    </div>

                    <div class="col-sm-8 col-md-9" id="extraction-navigation-content" style="margin-top: 5px">
                        <div id="content-btn-all-gestures" class="hidden"></div>
                        <div id="content-btn-gesture-classification" class="hidden">
                            <div><span class="text">Gesten klassifizieren</span> 
                                <button type="button" class="btn btn-xs btn-default btn-shadow disabled" id="btn-reclassify-gestures" style="margin-left:5px"><i class="fa fa-refresh" aria-hidden="true"></i> <span class="btn-text">Neu initiieren</span></button>
                            </div>
                            <!--                            <div class="row text-center text" style="margin-top:20px">
                                                            
                                                        </div>-->
                            <div class="alert-space alert-no-more-gestures-for-classification" style="margin-top:20px"></div>

                            <div id="gesture-classification-parameters" class="hidden text-center" style="margin-top:20px">
                                <div class="form-group root text" id="classification-type">
                                    <label>Wie sollen die Gesten klassifiziert werden? Nach</label><br>

                                    <div class="btn-group" id="radio">
                                        <button class="btn btn-default btn-radio" id="appearance" name="primary">
                                            <span id="icons" style="margin-right: 6px">
                                                <i class="fa fa-circle-thin" id="normal"></i>
                                                <i class="fa fa-circle hidden" id="over"></i>
                                                <i class="fa fa-check-circle hidden" id="checked"></i>
                                            </span>
                                            <span class="option-text"><?php echo $lang->classificationTypes->appearance ?></span>
                                        </button>
                                    </div>

                                    <br/>
                                    <!--
                                    -->                                    <div class="btn-group" id="radio">
                                        <button class="btn btn-default btn-radio btn-option-checked" id="appearanceTrigger" name="primary">
                                            <span id="icons" style="margin-right: 6px">
                                                <i class="fa fa-circle-thin hidden" id="normal"></i>
                                                <i class="fa fa-circle hidden" id="over"></i>
                                                <i class="fa fa-check-circle " id="checked"></i>
                                            </span>
                                            <span class="option-text"><?php echo $lang->classificationTypes->appearanceTrigger ?></span>
                                        </button>
                                    </div>

                                    <!--<br/>-->

                                    <!--                                    <div class="btn-group" id="radio">
                                                                            <button class="btn btn-default btn-radio " id="gestureType" name="primary">
                                                                                <span id="icons" style="margin-right: 6px">
                                                                                    <i class="fa fa-circle-thin" id="normal"></i>
                                                                                    <i class="fa fa-circle hidden" id="over"></i>
                                                                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                                                                </span>
                                                                                <span class="option-text"></span>
                                                                            </button>
                                                                        </div>
                                    
                                                                        <br/>
                                    
                                                                        <div class="btn-group" id="radio">
                                                                            <button class="btn btn-default btn-radio disabled" id="gestureTypeTrigger" name="primary">
                                                                                <span id="icons" style="margin-right: 6px">
                                                                                    <i class="fa fa-circle-thin" id="normal"></i>
                                                                                    <i class="fa fa-circle hidden" id="over"></i>
                                                                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                                                                </span>
                                                                                <span class="option-text"></span>
                                                                            </button>
                                                                        </div>
                                    
                                                                        <br/>-->

                                </div>
                                <div class="btn-group-vertical">
                                    <button type="button" class="btn btn-default btn-shadow" id="btn-help-classification"><i class="fa fa-question-circle"></i> <span class="btn-text">Mehr Infos zur Klassifizierung</span></button>
                                    <button type="button" class="btn btn-info btn-shadow" id="btn-start-classification"><i class="fa fa-archive"></i> <span class="btn-text">Klassifizierung jetzt starten</span></button>
                                </div>

                            </div>

                            <div id="gesture-classification" class="row hidden" style="margin-top:20px">
                                <div class="col-xs-4 col-sm-4"><div class="row"><div id="gesture-left"></div></div></div>
                                <div class="col-xs-4 col-sm-4 text-center" id="match-controls">

                                    <p class="text">Enspricht die Geste auf der linken Seite der auf der rechten Seite?</p>
                                    <div class="btn-group btn-group-justified" role="group">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-danger btn-shadow" id="btn-gesture-no"><i class="fa fa-thumbs-down"></i> <span class="btn-text">Nein</span></button>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success btn-shadow" id="btn-gesture-yes"><i class="fa fa-thumbs-up"></i> <span class="btn-text">Ja</span></button>
                                        </div>
                                    </div>
                                    <!--<div class="btn-group-vertical btn-block" role="group" style="margin-top:10px">-->
                                    <button type="button" class="btn btn-default disabled btn-block btn-shadow" id="btn-redo" style="margin-top:10px"><i class="fa fa-undo" aria-hidden="true"></i> <span class="btn-text">Rückgängig</span></button>
                                    <!--                                                                            <button type="button" class="btn btn-default">Abbrechen</button>
                                                                                                                <button type="button" class="btn btn-default">Fertig</button>
                                                                                                            </div>-->
                                </div>
                                <div class="col-xs-4 col-sm-4"><div class="row"><div id="gesture-right"></div></div></div>
                            </div>
                            <div style="margin-top:30px" class="text">Klassifizierte Gesten</div>
                            <hr>
                            <div id="classified-gestures"></div>
                            <div class="alert-space alert-no-gestures-classified"></div>
                        </div>
                        <div id="content-btn-number-of-gesturess" class="hidden"></div>
                    </div>

                </div>

            </div>



            <!--            <hr>
            
                        

            <!--<hr>-->

            <!--            <div class="row" style="margin-top: 20px" id="study-participants">
                            <div class="col-xs-12">
                                <h3 class="address">Teilnahmen</h3>
                                <div class="alert-space alert-no-phase-data"></div>
                                <div class="list-container row" style="margin-top: 20px"></div>
                            </div>
                        </div>
            
                        <hr>-->

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
                            setStudyData(result);
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
                console.log(studyData);
                if (studyData.generalData.panelSurvey === 'yes') {
                    $('#panel-survey, .panel-survey').removeClass('hidden');
                    $('.panel-survey .address').text(translation.panelSurvey + ":");
                    var ageFrom = studyData.generalData.ageRange.split(',')[0];
                    var ageTo = studyData.generalData.ageRange.split(',')[1];
                    if (studyData.generalData.gender !== undefined) {
                        $('.panel-survey .text').text(translation.genderTypes[studyData.generalData.gender] + " " + translation.of + " " + ageFrom + " " + translation.to + " " + ageTo);
                    } else {
                        $('.panel-survey .text').text(translation.incompleteData);
                    }
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
                    appendAlert($('#study-participants'), ALERT_NO_PLAN);
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
                    appendAlert($('#main-content'), ALERT_NO_PHASE_DATA);
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


                // gesture/trigger extraction view
                if (studyData.generalData.phase === TYPE_PHASE_ELICITATION) {
                    $('#extraction').removeClass('hidden');
                    var trigger = false;
                    var gestures = false;
                    //                    console.log(data.studyData.phases);
                    for (var i = 0; i < data.studyData.phases.length; i++) {
                        if (data.studyData.phases[i].format === IDENTIFICATION) {
                            var phaseData = getLocalItem(data.studyData.phases[i].id + '.data');
                            console.log(phaseData);
                            if (phaseData.identificationFor === 'gestures') {
                                gestures = true;
                            } else {
                                trigger = true;
                            }
                        }
                    }

                    console.log('getExtractionData', gestures, trigger);
                    getExtractionData({studyId: data.id}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            if (gestures && !trigger && result.elicitedGestures && result.elicitedGestures.length > 0) {
                                console.log('result classification', result.classification);
                                setLocalItem(ELICITED_GESTURES, result.elicitedGestures);
                                if (result.classification && result.classification.data) {

                                    setLocalItem(CLASSIFICATION, result.classification.data);
                                } else {
                                    setLocalItem(CLASSIFICATION, null);
                                }

                            }
                            renderExtraction();
                        }
                    });
                }

                $('#tab-pane li a').on('click', function (event) {
                    event.preventDefault();
                    $(this).trigger('change', [$(this).closest('li').attr('id')]);
                });
                $('#tab-pane').on('change', function (event, activeId) {
                    event.preventDefault();
                    window.location.hash = activeId;
                    TweenMax.from($('#main-content'), .2, {y: -10, opacity: 0.0, clearProps: 'all'});
                });
                var status = window.location.hash.substr(1);
                if (status !== '') {
                    $('#tab-pane').find('#' + status + " a").click();
                } else {
                    $('#tab-pane').find('#general a').click();
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

                    if (result.aborted === 'no' && result.studySuccessfull === 'no') {
                        successfullStudies++;
                        $(item).find('.panel').addClass('panel-success');
                        $(item).find('#execution-success').removeClass('hidden');
                        $(item).find('#execution-success .label-text').text(translation.studySuccessful);
                    } 
//                    else if (result.aborted === 'no' && result.studySuccessfull === 'yes') {
//                        $(item).find('.panel').addClass('panel-warning');
//                        $(item).find('#execution-error').removeClass('hidden');
//                        $(item).find('#execution-error .label-text').text(translation.studyFault);
//                    }
                    else {
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


            function renderExtraction() {
                var elicitedGestures = getLocalItem(ELICITED_GESTURES);
                if (elicitedGestures && elicitedGestures.length > 0)
                {

//                    for (var i = 0; i < elicitedGestures.length; i++) {
//                        console.log('renderExtraction', elicitedGestures[i]);
//                    }
                } else {
                    appendAlert($('#gesture-extraction'), ALERT_NO_PHASE_DATA);
                    $('#extraction-content').addClass('hidden');
                }

                $('#btn-all-gestures').click();
            }

            $(document).on('click', '#extraction-navigation button', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('active') && !$(this).hasClass('disabled')) {
                    $(this).parent().children().removeClass('active');
                    $(this).addClass('active');
                    var selectedId = $(this).attr('id');
                    renderExtractionContent(selectedId);
                    $("html, body").animate({scrollTop: 0}, 100);
                    $('#extraction-navigation-content').children().addClass('hidden');
                    var activeContent = $('#extraction-navigation-content').find('#content-' + selectedId);
                    activeContent.removeClass('hidden');
                    TweenMax.from(activeContent, .2, {y: -20, opacity: 0, clearProps: 'all'});
                }
            });
            function renderExtractionContent(id) {
                switch (id) {
                    case 'btn-all-gestures':
                        renderAllGestures();
                        break;
                    case 'btn-gesture-classification':
                        renderGestureClassification();
                        break;
                    case 'btn-number-of-gestures':
                        break;
                    case 'btn-guessability':
                        break;
                    case 'btn-cognitive-relationships':
                        break;
                    case 'btn-preferred-gestures':
                        break;
                    case 'btn-checklist':
                        break;
                }
            }

            function renderAllGestures() {
                $('#content-btn-all-gestures').empty();
                var gestures = getLocalItem(ELICITED_GESTURES);
                var trigger = getLocalItem(ASSEMBLED_TRIGGER);
                if (trigger && trigger.length > 0 && gestures && gestures.length > 0) {
                    for (var i = 0; i < trigger.length; i++) {
                        var triggerTitle = document.createElement('div');
//                        var headlineText = document.createElement('span');
                        $(triggerTitle).addClass('text');
//                        $(triggerTitle).css({margin: '0px', float: 'left'});
                        $(triggerTitle).text(translation.trigger + ": " + trigger[i].title);
                        $('#content-btn-all-gestures').append(triggerTitle);
                        var container = document.createElement('div');
                        $(container).addClass('container-root row root');
                        $(container).attr('id', 'gestures-list-container');
                        $(container).css({marginTop: '20px', marginBottom: '30px'});
                        $('#content-btn-all-gestures').append(container);
                        var gestureCount = 0;
                        for (var j = 0; j < gestures.length; j++) {
                            var gesture = gestures[j];
                            if (parseInt(trigger[i].id) === parseInt(gesture.triggerId)) {
                                var clone = getGestureCatalogListThumbnail(gestures[j], 'col-xs-6 col-sm-6 col-md-4', ELICITED_GESTURES);
                                $(container).append(clone);
                                TweenMax.from(clone, .2, {delay: j * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                                gestureCount++;
                            }
                        }

                        var countText = document.createElement('span');
                        $(countText).addClass('badge');
                        $(countText).css({marginLeft: '6px'});
                        $(countText).text(gestureCount === 1 ? gestureCount + " " + translation.gesture : gestureCount + " " + translation.gestures);
                        $(triggerTitle).append(countText);
                    }
                } else {
                    // append alert
                }
            }

            var gesturesLeft = null;
            var gesturesLeftIndex = 0;
            var gesturesRight = null;
            var gesturesRightIndex = 0;
            function renderGestureClassification() {
                gesturesLeftIndex = 0;
                gesturesRightIndex = 0;
                var classification = getLocalItem(CLASSIFICATION);
                var elicitedGestures = getLocalItem(ELICITED_GESTURES);
                console.log("classification: ", classification, "elicited gestures: ", elicitedGestures);
                if (elicitedGestures && elicitedGestures.length > 0) {
                    if (classification && classification.assignments && classification.assignments.length > 0) {
                        // check classified gestures and render them. gesturesLeft must be the matched unclassified gestures
                        console.log('there is classification data');
                        $('#btn-reclassify-gestures').removeClass('disabled');
                        $('#gesture-classification-parameters').addClass('hidden');
                        gesturesLeft = getUnclassifiedGestures();
                        gesturesRight = classification.assignments;
                        if (gesturesLeft && gesturesLeft.length > 0) {
                            $('#gesture-classification').removeClass('hidden');
                            updateMatchingView();
                        } else {
                            appendAlert($('#content-btn-gesture-classification'), ALERT_NO_MORE_GESTURES_FOR_CLASSIFICATION);
                        }
                        renderClassifiedGestures();
                    } else {
                        appendAlert($('#content-btn-gesture-classification'), ALERT_NO_GESTURES_CLASSIFIED);
                        console.log('there is NO classification data');
                        $('#gesture-classification-parameters').removeClass('hidden');
                        $('#gesture-classification').addClass('hidden');
                        $('#classification-type').on('change', function (event) {
                            event.preventDefault();
                            $('#btn-start-classification').removeClass('disabled');
                        });
                        $('#btn-help-classification').on('click', function (event) {
                            event.preventDefault();
                            loadHTMLintoModal('custom-modal', 'modal-classification.php', 'modal-lg');
                        });
                        $('#btn-start-classification').on('click', function (event) {
                            event.preventDefault();
                            if (!$(this).hasClass('disabled')) {
                                $('#gesture-classification-parameters').addClass('hidden');
                                $('#gesture-classification').removeClass('hidden');
                                var checked = $('#classification-type').find('.btn-option-checked').attr('id');
                                classification = {type: checked};
                                setLocalItem(CLASSIFICATION, classification);
                                saveClassification();
                                gesturesRight = new Array();
                                gesturesRight.push({mainGestureId: elicitedGestures[0].id, gestures: [elicitedGestures[0]]});
                                gesturesLeft = elicitedGestures;
                                updateMatchingView();
                            }
                        });
                    }
                } else {
                    appendAlert($('#content-btn-gesture-classification'), ALERT_NO_GESTURES_CLASSIFIED);
                }

                $('#btn-reclassify-gestures').on('click', function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
                        $(this).addClass('disabled');
                        removeAlert($('#content-btn-gesture-classification'), ALERT_NO_MORE_GESTURES_FOR_CLASSIFICATION);
                        setLocalItem(CLASSIFICATION, null);
                        saveClassification();
                        renderClassifiedGestures();
                        renderGestureClassification();
                    }
                });
                $('#btn-redo').on('click', function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
                        reclassifiyGesture(gesturesLeft[gesturesLeftIndex - 1]);
                        gesturesLeftIndex--;
                        gesturesRightIndex = 0;
                        saveClassification();
                        updateMatchingView();
                    }
                });
            }

            function updateMatchingView() {
                if (gesturesLeftIndex < gesturesLeft.length - 1) {

                    if (gesturesLeftIndex > 0) {
                        $('#btn-redo').removeClass('disabled');
                    } else {
                        $('#btn-redo').addClass('disabled');
                    }

                    var leftGesture = gesturesLeft[gesturesLeftIndex];
                    var rightGesture = getGestureById(gesturesRight[gesturesRightIndex].mainGestureId, ELICITED_GESTURES);
                    console.log("update matching view", leftGesture, rightGesture);
                    var leftItem = getGestureCatalogListThumbnail(leftGesture, 'col-xs-12', ELICITED_GESTURES);
                    var rightItem = getGestureCatalogListThumbnail(rightGesture, 'col-xs-12', ELICITED_GESTURES);
                    $('#gesture-left').empty().append(leftItem);
                    $('#gesture-right').empty().append(rightItem);
                    renderClassifiedGestures();
                    TweenMax.from($('#match-controls'), .3, {opacity: 0, scaleX: 0.5, scaleY: 0.5, clearProps: 'all'});
                }
            }

            function getClassifiedGestures() {
                var classification = getLocalItem(CLASSIFICATION).assignments;
                var array = new Array();
                if (classification) {
                    for (var i = 0; i < classification.length; i++) {
                        array.push(classification[i].mainGesture);
                    }
                    return array;
                }
                return null;
            }

            function getUnclassifiedGestures() {
                var elicitedGestures = getLocalItem(ELICITED_GESTURES);
                var classification = getLocalItem(CLASSIFICATION).assignments;
                var array = new Array();
                if (classification) {
                    for (var i = 0; i < elicitedGestures.length; i++) {
                        var gestureIsClassified = false;
                        for (var j = 0; j < classification.length; j++) {
                            for (var k = 0; k < classification[j].gestures.length; k++) {
                                if (parseInt(classification[j].gestures[k]) === parseInt(elicitedGestures[i].id)) {
//                                    console.log('this gesture is classified', elicitedGestures[i].id);
                                    gestureIsClassified = true;
                                    break;
                                } else if (j === classification.length - 1 && k === classification[j].gestures.length - 1) {
//                                    console.log('this gesture is not classified', elicitedGestures[i].id);
                                    array.push(elicitedGestures[i]);
                                }
                            }

                            if (gestureIsClassified) {
                                break;
                            }
                        }
                    }
                    console.log(array);
                    return array;
                }

                return null;
            }

            function renderClassifiedGestures() {
                var classification = getLocalItem(CLASSIFICATION);
                $('#classified-gestures').empty();
                if (classification) {
                    var assignments = classification.assignments;
                    if (assignments && assignments.length > 0) {
                        for (var i = 0; i < assignments.length; i++) {
                            var row = document.createElement('div');
//                        $(row).addClass('row');
//                        $('#classified-gestures').append(row);

                            var mainGesture = getGestureById(assignments[i].mainGestureId, ELICITED_GESTURES);
                            var trigger = getTriggerById(mainGesture.triggerId);
                            var headline = document.createElement('h4');
                            $('#classified-gestures').append(headline);
                            if (classification.type === TYPE_CLASSIFICATION_APPEARANCE) {
                                $(headline).text('Geste ' + (i + 1));
                            } else if (classification.type === TYPE_CLASSIFICATION_APPEARANCE_TRIGGER) {
                                $(headline).text('Funktion: ' + trigger.title + ', Geste ' + getClassifiedGestureIndex(mainGesture));
                            }

                            row = document.createElement('div');
                            $(row).addClass('row');
                            $('#classified-gestures').append(row);
                            for (var j = 0; j < assignments[i].gestures.length; j++) {
                                var gestureThumbnail = getGestureCatalogListThumbnail(getGestureById(assignments[i].gestures[j], ELICITED_GESTURES), 'col-xs-6 col-sm-6 col-md-4', ELICITED_GESTURES);
                                $(row).append(gestureThumbnail);
                            }
                        }
                    }

                }
            }

            function getClassifiedGestureIndex(gesture) {
                var classification = getLocalItem(CLASSIFICATION).assignments;
                var count = 0;
                for (var i = 0; i < classification.length; i++) {
                    var mainGesture = getGestureById(classification[i].mainGestureId, ELICITED_GESTURES);
                    if (parseInt(mainGesture.triggerId) === parseInt(gesture.triggerId)) {
                        count++;
                    }

                    if (parseInt(mainGesture.id) === parseInt(gesture.id)) {
                        return count;
                    }
                }
            }

            $('#btn-gesture-yes').on('click', function (event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                var leftId = parseInt($('#gesture-left').children().attr('id'));
                var leftGesture = getGestureById(leftId, ELICITED_GESTURES);
                classifyGesture(leftGesture, true);
                gesturesLeftIndex++;
                gesturesRightIndex = 0;
                updateMatchingView();
                removeAlert($('#content-btn-gesture-classification'), ALERT_NO_GESTURES_CLASSIFIED);
            });
            $('#btn-gesture-no').on('click', function (event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                var leftId = parseInt($('#gesture-left').children().attr('id'));
                var leftGesture = getGestureById(leftId, ELICITED_GESTURES);
                if (gesturesRightIndex < gesturesRight.length - 1) {
                    gesturesRightIndex++;
                } else {
                    classifyGesture(leftGesture, false);
                    gesturesLeftIndex++;
                    gesturesRightIndex = 0;
                    removeAlert($('#content-btn-gesture-classification'), ALERT_NO_GESTURES_CLASSIFIED);
                }

                // error lays down here
                var elicitedGestures = getLocalItem(ELICITED_GESTURES);
                if (gesturesLeftIndex < elicitedGestures.length - 1 && elicitedGestures.length > 0) {
                    updateMatchingView();
                } else {
                    renderClassifiedGestures();
                    $('#gesture-classification').addClass('hidden');
                    appendAlert($('#content-btn-gesture-classification'), ALERT_NO_MORE_GESTURES_FOR_CLASSIFICATION);
                }
            });
            function classifyGesture(gesture, foundMatch) {
                var classification = getLocalItem(CLASSIFICATION);
                if (foundMatch) {
                    if (classification && classification.assignments && classification.assignments.length > 0) {
                        var matchedSourceGesture = getGestureById(classification.assignments[gesturesRightIndex].gestures[0], ELICITED_GESTURES);
//                        console.log(classification.assignments[gesturesRightIndex].gestures[0]);

                        if (classification.type === TYPE_CLASSIFICATION_APPEARANCE ||
                                (classification.type === TYPE_CLASSIFICATION_APPEARANCE_TRIGGER && parseInt(matchedSourceGesture.triggerId) === parseInt(gesture.triggerId)))
                        {
                            classification.assignments[gesturesRightIndex].gestures.push(gesture.id);
                        } else {
                            classification.assignments.push({mainGestureId: gesture.id, gestures: [gesture.id]});
                        }
                    } else {
                        classification.assignments = [{mainGestureId: gesture.id, gestures: [gesture.id]}];
                    }
                } else {
                    if (classification && classification.assignments && classification.assignments.length > 0) {
                        classification.assignments.push({mainGestureId: gesture.id, gestures: [gesture.id]});
                    } else {
                        classification.assignments = [{mainGestureId: gesture.id, gestures: [gesture.id]}];
                    }
                }

                gesturesRight = classification.assignments;
                setLocalItem(CLASSIFICATION, classification);
                console.log(classification);
                saveClassification();
                $('#btn-reclassify-gestures').removeClass('disabled');
            }

            function reclassifiyGesture(gesture) {
                console.log('reclassify gesture:', gesture);
                var classification = getLocalItem(CLASSIFICATION);
                var assignments = classification.assignments;
                for (var i = 0; i < assignments.length; i++) {
                    var gestures = assignments[i].gestures;
                    for (var j = 0; j < gestures.length; j++) {
                        if (parseInt(gestures[j]) === parseInt(gesture.id)) {
                            if (gestures.length === 1) {
                                assignments.splice(i, 1);
                                break;
                            } else {
                                gestures.splice(j, 1);
                                break;
                            }
                        }
                    }
                }

                gesturesRight = assignments;
//                console.log(classification);
                setLocalItem(CLASSIFICATION, classification);
            }

            function saveClassification() {
                var classification = getLocalItem(CLASSIFICATION);
                var studyId = getLocalItem(STUDY).id;
                saveExtractionData({studyId: studyId, classification: classification}, function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        console.log('classification saved');
                    } else {
                        console.log('save classification error');
                    }
                });
            }
        </script>
    </body>
</html>
