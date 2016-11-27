<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

session_start();
$loggedIn = login_check($mysqli) == true ? true : false;
$h = getv('h');
$studyId = getv('studyId');
if ($h && $studyId) {
    if ($loggedIn == true) {
        if (isset($_SESSION['usertype'], $_SESSION['user_id'])) {
            $hash = hash('sha512', $studyId . $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname']);
            if ($_SESSION['usertype'] == 'tester' || $_SESSION['usertype'] == 'guest') {
                header('Location: study-prepare-tester.php?studyId=' . $studyId . '&token=' . $h . '&h=' . $hash);
            } else if ($_SESSION['usertype'] == 'evaluator') {
                header('Location: study-prepare-evaluator.php?studyId=' . $studyId . '&token=' . $h . '&h=' . $hash);
            }
        }
    }
} else {
    header('Location: study-prepare-failure.php');
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
        <script type="text/JavaScript" src="js/login.js"></script>
        <script type="text/JavaScript" src="js/checkForms.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/sha512.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-subpages"></div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" data-backdrop="static" data-keyboard="false" role="dialog">
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
                    <li class="active"><?php echo $lang->breadcrump->study ?></li>
                </ol>
            </div>
        </div>

        <!--         Container (Landing Section)  
                <div class="container-fluid text-center bg-grey" id="landingText">
                    <div class="container">
                        <h1><i class="fa fa-tasks" style="font-size: 60pt" aria-hidden="true"></i> <span class="uppercase">An Studie teilnehmen</span></h1>
                        <p class="text">Haben Sie ein Account bei GestureNote? Dann loggen Sie sich bitte ein. </p>
                        <p class="text">Sind Sie auf dieser Seite gelandet, weil Sie einen Link für die Teilnahme an einer Studie erhalten haben? Sie können ohne Account fortfahren indem Sie auf "Teilnahme ohne Account" klicken. Oder Sie registrieren sich bei GestureNote und können in Zukunft an weiteren interessanten Studien teilnehmen, ganz ohne Einladung.</p>
                    </div>
                </div>-->

        <!-- Container (Panel Section) -->
        <div class="container mainContent" style="margin-top: 0px;">
            <div class="row">

                <div class="col-sm-6 col-md-7" id="study-details">
                    <h2 class="address" style="margin-top: 0">An Studie teilnehmen</h2>
                    <hr>
                    <p class="text">Haben Sie ein Account bei GestureNote? Dann loggen Sie sich bitte ein. </p>
                    <p class="text">Sind Sie auf dieser Seite gelandet, weil Sie einen Link für die Teilnahme an einer Studie erhalten haben? Sie können ohne Account fortfahren indem Sie auf "Teilnahme ohne Account" klicken. Oder Sie registrieren sich bei GestureNote und können in Zukunft an weiteren interessanten Studien teilnehmen, ganz ohne Einladung.</p>
                    <!--                <h2 id="study-headline" style="margin-top: 0"></h2>
                                    <hr>-->
                    <!--                <div class="label label-default" id="type-phase"></div>
                                    <div class="label label-default" id="type-survey"></div>-->

                    <!--                <div id="study-description">
                                        <h3 class="address"></h3>
                                        <p class="text"></p>
                                    </div>-->

                </div>

                <div class="col-sm-6 col-md-5" id="login">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title"><?php echo $lang->signIn ?></h2>
                        </div>
                        <div class="panel-body">

                            <div id="login-form">
                                <div class="alert-space alert-general-error"></div>
                                <div class="alert-space alert-missing-fields"></div>
                                <div class="alert-space alert-account-logged"></div>
                                <div class="alert-space alert-wrong-password"></div>
                                <div class="alert-space alert-no-user-exists"></div>

                                <div class="form-group">
                                    <label for="email"><?php echo $lang->email ?></label>
                                    <input type="text" class="form-control" name="email" value="" id="email">
                                </div>
                                <div class="form-group">
                                    <label for="password"><?php echo $lang->password ?></label>
                                    <input type="password" class="form-control" name="password" value="" id="password">
                                </div>
                                <div class="btn-group-vertical btn-block">
                                    <button type="button" class="btn btn-success" id="btn-login"><i class="glyphicon glyphicon-log-in"></i> <span class="btn-text"><?php echo $lang->signIn ?></button>
                                    <button type="button" class="btn btn-primary disabled" id="btn-forgot"><i class="glyphicon glyphicon-time"></i> <span class="btn-text"><?php echo $lang->forgotPassword ?></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title"><?php echo $lang->noAccount ?>?</h2>
                        </div>
                        <div class="panel-body">
                            <div class="btn-group-vertical btn-block">
                                <button type="button" class="btn btn-gn" id="btn-open-register"><i class="fa fa-user-plus" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->register ?></span></button>
                                <button type="button" class="btn btn-default" id="btn-participate-without-account"><i class="fa fa-user-times" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->participateWithoutAccount ?></span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <script>
            $(document).ready(function () {
                checkDomain();
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements(false);
                var query = getQueryParams(document.location.search);
                if (query.studyId && query.h) {
//                    getStudyById({studyId: query.studyId}, function (result) {
//                        if (result.status === RESULT_SUCCESS) {
////                            if (result.data) {
//                                renderData(result);
////                            } else {
////                                //                            appendAlert($('#item-view'), ALERT_NO_STUDIES);
////                            }
//                        }
//                    });
                }

                $('#login-form').on('loginSuccess', function (event, result) {
                    var hash = hex_sha512(parseInt(query.studyId) + result.userId + result.forename + result.surname);
                    if (result.userType === 'evaluator') {
                        goto('study-prepare-evaluator.php?studyId=' + query.studyId + '&token=' + query.h + "&h=" + hash);
                    } else if (result.userType === 'tester') {
                        goto('study-prepare-tester.php?studyId=' + query.studyId + '&token=' + query.h + "&h=" + hash);
                    }
                });

                $('#register-form').on('registerSuccess', function (event, result) {
                    var hash = hex_sha512(parseInt(query.studyId) + result.userId + result.forename + result.surname);
                    if (result.userType === 'evaluator') {
                        goto('study-prepare-evaluator.php?studyId=' + query.studyId + '&token=' + query.h + "&h=" + hash);
                    } else if (result.userType === 'tester') {
                        goto('study-prepare-tester.php?studyId=' + query.studyId + '&token=' + query.h + "&h=" + hash);
                    }
                });

                $('#btn-participate-without-account').on('click', function (event) {
                    event.preventDefault();
                    var hash = hex_sha512(parseInt(query.studyId) + 'guest');
                    goto('study-prepare-tester.php?studyId=' + query.studyId + '&token=' + query.h + "&h=" + hash);
                });
            }

            function renderData(data) {
                var studyData = data.studyData;
//                $('#study-headline').text(studyData.generalData.title);
//                $('#type-survey').text(translation.surveyType[studyData.generalData.surveyType]);
//                $('#type-phase').text(translation.phaseType[studyData.generalData.phase]);
//                $('#study-description .address').text(translation.description);
//                $('#study-description .text').text(studyData.generalData.description);
            }

            $('#btn-open-register').on('click', function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'modal-register.php', 'modal-md');
//    $('#modal-register').modal('show');
            });
        </script>
    </body>
</html>
