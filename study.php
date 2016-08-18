<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

session_start();

if (login_check($mysqli) == false) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GestureNote</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/study.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>

        <script src="js/constants.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/gotoPage.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/sha512.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="templage-subpages"></div>


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

        <!-- Container (Landing Section) -->
        <!--        <div class="container-fluid text-center bg-grey" id="landingText">
                    <div class="container">
                        <h1><i class="fa fa-tasks" style="font-size: 60pt" aria-hidden="true"></i> STUDIEN</h1>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>-->

        <!-- Container (Panel Section) -->
        <div class="container mainContent" style="margin-top: 35px;" id="item-view">
            <h2 id="study-headline" style="margin-top: 0"></h2>
            <hr>
            <div class="label label-default" id="type-phase"></div>
            <div class="label label-default" id="type-survey"></div>

            <div class="row" style="margin-top: 20px">
                <div class="col-sm-6 col-lg-7">
                    <div id="study-description">
                        <h3 class="address"></h3>
                        <p class="text"></p>
                    </div>
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
                    </div>
                </div>
            </div>

            <hr>

            <div class="row" style="margin-top: 20px">
                <div class="col-xs-12">
                    <div id="study-participants">
                        <h3 class="address">Teilnahmen</h3>
                    </div>
                </div>
            </div>

            <hr>

        </div>


        <script>
            $(document).ready(function () {
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + '/' + currentLanguage + '/alerts.html']);
                    externals.push(['#templage-subpages', PATH_EXTERNALS + '/' + currentLanguage + '/template-sub-pages.html']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
                var query = getQueryParams(document.location.search);
                var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');

                if (query.studyId && query.h === hash) {
                    getStudyById({studyId: query.studyId}, function (result) {
                        console.log(result);
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
                var studyData = data.data;
                $('#study-headline').text(studyData.generalData.name);
                $('#type-survey').text(translation.surveyType[studyData.generalData.surveyType]);
                $('#type-phase').text(translation.phaseType[studyData.generalData.phase]);
                $('#study-description .address').text(translation.description);
                $('#study-description .text').text(studyData.generalData.description);
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
                        $(iconMiddle).addClass('study-phase-step-middle-icon');
                        $(iconMiddle).text(i + 1);
                        $(iconContainer).append(iconMiddle);

                        var text = document.createElement('span');
                        $(text).addClass('text');
                        $(text).text(translation.formats[studyData.phases[i].format]);
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
            }

        </script>
    </body>
</html>
