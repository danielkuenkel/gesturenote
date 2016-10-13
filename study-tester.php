<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

session_start();
if (login_check($mysqli) == true) {
    if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'evaluator') {
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
        <script src="js/goto-tester.js"></script>
        <!--<script src="js/gesture.js"></script>-->
        <!--<script src="js/joint-selection.js"></script>-->
        <script src="js/ajax.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/sha512.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="templage-subpages"></div>
        <div id="templage-study"></div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content root">
                </div>
            </div>
        </div>


        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index">Home</a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard">Dashboard</a></li>
                    <li><a class="breadcrump-btn" id="btn-studies">Studien</a></li>
                    <li class="active">Studie</li>
                </ol>
            </div>
        </div>

        <!-- Container (Panel Section) -->
        <div class="container mainContent" style="margin-top: 35px;" id="item-view">
            <h2 id="study-headline" style="margin-top: 0"></h2>
            <hr>
            <!--<div class="label label-default" id="type-phase"></div>-->
            <div class="label label-default" id="type-survey"></div>
            <div class="label label-default hidden" id="panel-survey">Panel-Befragung</div>

            <div class="row" style="margin-top: 20px">
                <div class="col-sm-6 col-lg-7">
                    <div id="study-description">
                        <h3 class="address"></h3>
                        <p class="text"></p>
                    </div>
                    <div class="hidden study-plan"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>
                </div>
                <div class="col-sm-5 col-sm-offset-1 col-lg-4 col-lg-offset-1">
                    <div id="study-phases">
                        <!--<h3 class="address"></h3>-->
                        <div class="alert-space alert-no-phase-data" style="margin-bottom: 20px"></div>
                        <!--<div id="phase-steps-container"></div>-->
                    </div>
                    <div class="btn-group-vertical btn-block">
                        <button class="btn btn-info btn-shadow hidden" type="button" id="btn-enter-unmoderated-study"><span class="btn-text">An Studie teilnehmen</span></button>
<!--                        <button class="btn btn-default btn-shadow" type="button" id="btn-preview-study"><i class="fa fa-eye" aria-hidden="true"></i> <span class="btn-text">Vorschau der Studie</span></button>
                        <button class="btn btn-default btn-shadow" type="button" id="btn-delete-study"><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-text">Studie löschen</span></button>-->
                    </div>
                </div>
            </div>

            <!--<hr>-->

            <!--            <div class="row" style="margin-top: 20px">
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
            
                        <div class="row" style="margin-top: 20px">
                            <div class="col-xs-12">
                                <div id="study-participants">
                                    <h3 class="address">Teilnahmen</h3>
                                    <div class="alert-space alert-no-phase-data"></div>
                                </div>
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
                    externals.push(['#templage-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    externals.push(['#templage-study', PATH_EXTERNALS + 'template-study.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
                var query = getQueryParams(document.location.search);
                var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');

                if (query.studyId && query.h === hash) {
                    getStudyById({studyId: query.studyId}, function (result) {
//                        console.log(result);
                        if (result.status === RESULT_SUCCESS) {
                            if (result.data) {
                                renderData(result);
                            } else {
                                //                            appendAlert($('#item-view'), ALERT_NO_STUDIES);
                            }
                        }
                    });
                }
            }

            function renderData(data) {
                console.log(studyData);

                var studyData = data.data;

                // general data view
                $('#study-headline').text(studyData.generalData.title);
                $('#type-survey').text(translation.surveyType[studyData.generalData.surveyType]);
//                $('#type-phase').text(translation.phaseType[studyData.generalData.phase]);
                $('#study-description .address').text(translation.description);
                $('#study-description .text').text(studyData.generalData.description);
                var absoluteStaticStudyUrl = 'https://gesturenote.de/study-prepare.php?studyId=' + data.id + '&h=' + data.urlToken;
                var relativeStaticStudyUrl = 'study-prepare.php?studyId=' + data.id + '&h=' + data.urlToken;

                if (studyData.generalData.surveyType === TYPE_SURVEY_MODERATED) {
                    $('#btn-enter-unmoderated-study').remove();

//                    $('#panel-survey, .panel-survey').removeClass('hidden');
//                    $('.panel-survey .address').text(translation.panelSurvey + ":");
//                    var ageFrom = studyData.generalData.ageRange.split(',')[0];
//                    var ageTo = studyData.generalData.ageRange.split(',')[1];
//                    console.log(studyData.generalData);
//                    $('.panel-survey .text').text(translation.gender[studyData.generalData.gender] + " " + translation.of + " " + ageFrom + " " + translation.to + " " + ageTo);
                } else {
                    $('#btn-enter-unmoderated-study').removeClass('hidden');
                    $('#btn-enter-unmoderated-study').on('click', function (event) {
                        event.preventDefault();
                        if (!$(this).hasClass('disabled')) {
                            goto(relativeStaticStudyUrl);
                        }
                    });
                }


                // date range view
                var now = new Date().getTime();
                var dateFrom = studyData.generalData.dateFrom * 1000;
                var dateTo = addDays(studyData.generalData.dateTo * 1000, 1);
                var totalDays = rangeDays(dateFrom, dateTo);

                if (now > dateFrom && now < dateTo) {
                    $('#btn-enter-unmoderated-study').removeClass('hidden');
                } else {
                    $('#btn-enter-unmoderated-study').removeClass('hidden').addClass('disabled');
                }

                $('.study-plan').find('.address').text(now > dateTo ? translation.studyRuns : translation.studyRun + " " + translation.from + ":");
                $('.study-plan').find('.text').text(new Date(dateFrom).toLocaleDateString() + " " + translation.to + " " + new Date(dateTo).toLocaleDateString() + ", " + totalDays + " " + (totalDays === 1 ? translation.day : translation.days));
                $('.study-plan').removeClass('hidden');
            }
        </script>
    </body>
</html>
