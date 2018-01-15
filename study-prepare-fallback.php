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
            if ($_SESSION['usertype'] == 'guest') {
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
        <title><?php echo $lang->gestureNote ?></title>
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
        <script type="text/JavaScript" src="js/login.js"></script>
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
                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                    <li class="active"><?php echo $lang->breadcrump->study ?></li>
                </ol>
            </div>
        </div>

        <!-- Container (Panel Section) -->
        <div class="container mainContent" style="margin-top: 0px;">
            <div class="row">

                <div class="col-sm-6 col-md-7" id="study-details">
                    <h2 class="address" style="margin-top: 0"><?php echo $lang->participateStudy ?></h2>
                    <hr>
                    <p class="text"><?php echo $lang->participateAccountQuestion ?></p>
                    <p class="text"><?php echo $lang->participateAccountDecision ?></p>
                </div>


                <div class="col-sm-6 col-md-5" id="login">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title"><?php echo $lang->studyParticipant ?>?</h2>
                        </div>
                        <div class="panel-body">
                            <div class="btn-group-vertical btn-block">
                                <!--<button type="button" class="btn btn-primary" id="btn-open-register"><i class="fa fa-user-plus" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->register ?></span></button>-->
                                <button type="button" class="btn btn-default" id="btn-participate-without-account"><i class="fa fa-user-times" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->participateWithoutAccount ?></span></button>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title"><?php echo $lang->signIn ?></h2>
                        </div>
                        <div class="panel-body">

                            <div id="login-form">
                                <div class="alert-space alert-general-error"></div>
                                <div class="alert-space alert-missing-fields"></div>
                                <div class="alert-space alert-missing-email"></div>
                                <div class="alert-space alert-check-email"></div>
                                <div class="alert-space alert-invalid-email"></div>
                                <div class="alert-space alert-account-logged"></div>
                                <div class="alert-space alert-wrong-password"></div>
                                <div class="alert-space alert-no-user-exists"></div>
                                <div class="alert-space alert-password-reset-send"></div>

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
                                    <button type="button" class="btn btn-default" id="btn-forgot-password"><i class="glyphicon glyphicon-time"></i> <span class="btn-text"><?php echo $lang->forgotPassword ?></button>
                                </div>
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

                $('#login-form #password, #login-form #email').keypress(function (event) {
                    if (event.keyCode === 13) {
                        $('#login-form #btn-login').click();
                    }
                });

                $('#login-form').on('loginSuccess', function (event, result) {
                    var hash = hex_sha512(parseInt(query.studyId) + result.userId + result.forename + result.surname);
                    if (result.userType === 'evaluator') {
                        goto('study-prepare-evaluator.php?studyId=' + query.studyId + '&token=' + query.h + "&h=" + hash);
                    }
                });

//                $('#register-form').on('registerSuccess', function (event, result) {
//                    event.preventDefault();
//                    var hash = hex_sha512(parseInt(query.studyId) + result.userId + result.forename + result.surname);
//                    if (result.userType === 'evaluator') {
//                        goto('study-prepare-evaluator.php?studyId=' + query.studyId + '&token=' + query.h + "&h=" + hash);
//                    } else if (result.userType === 'tester') {
//                        goto('study-prepare-tester.php?studyId=' + query.studyId + '&token=' + query.h + "&h=" + hash);
//                    }
//                });

                $('#btn-participate-without-account').on('click', function (event) {
                    event.preventDefault();
                    var hash = hex_sha512(parseInt(query.studyId) + 'guest');
                    goto('study-prepare-tester.php?studyId=' + query.studyId + '&token=' + query.h + "&h=" + hash);
                });
            }

//            $('#btn-open-register').on('click', function (event) {
//                event.preventDefault();
//                loadHTMLintoModal('custom-modal', 'modal-register.php', 'modal-md');
//            });
        </script>
    </body>
</html>
