<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

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
                header('Location: study-prepare-moderator.php?studyId=' . $studyId . '&token=' . $h . '&h=' . $hash);
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

        <!-- third party sources -->
        <link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/greensock/TweenMax.min.js"></script>

        <!-- gesturenote specific sources -->
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">

        <script src="js/constants.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/login.js"></script>
        <script src="js/checkForms.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/sha512.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-general"></div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content root">
                </div>
            </div>
        </div>


        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb" style="">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                    <li class="active"><i class="fa fa-clipboard"></i> <?php echo $lang->breadcrump->study ?></li>
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
                    <div class="panel panel-default panel-shadow">
                        <div class="panel-heading">
                            <div class="font-bold"><?php echo $lang->studyParticipant ?></div>
                        </div>
                        <div class="panel-body">
                            <div class="btn-group-vertical btn-block">
                                <button type="button" class="btn btn-default btn-shadow" id="btn-participate-without-account"><i class="fa fa-comments" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->participateWithoutAccount ?></span></button>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default panel-shadow">
                        <div class="panel-heading">
                            <div class="font-bold"><?php echo $lang->participateAsModerator ?></div>
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
                                    <button type="button" class="btn btn-success btn-shadow" id="btn-login"><i class="fa fa-unlock-alt"></i> <span class="btn-text"><?php echo $lang->signIn ?></button>
                                    <button type="button" class="btn btn-default btn-shadow" id="btn-forgot-password"><i class="fa fa-clock-o"></i> <span class="btn-text"><?php echo $lang->forgotPassword ?></button>
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
                checkCookies(parseInt('<?php echo checkCookiesAccepted(); ?>'));
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements(false);
                animateBreadcrump();
                var query = getQueryParams(document.location.search);

                $('#login-form #password, #login-form #email').keypress(function (event) {
                    if (event.keyCode === 13) {
                        $('#login-form #btn-login').click();
                    }
                });

                $('#login-form').on('loginSuccess', function (event, result) {
                    event.preventDefault();
                    var hash = hex_sha512(parseInt(query.studyId) + result.userId + result.forename + result.surname);
                    if (result.userType === 'evaluator') {
                        goto('study-prepare-moderator.php?studyId=' + query.studyId + '&token=' + query.h + "&h=" + hash);
                    }
                });

                $('#btn-participate-without-account').on('click', function (event) {
                    event.preventDefault();

                    var origin = window.location.origin;
                    if (origin.includes('localhost')) {
                        origin += '/gesturenote';
                    }

                    getStudyById({studyId: query.studyId}, function (result) {
                        console.log(result);
                        if (result.status === RESULT_SUCCESS) {
                            var hash = hex_sha512(parseInt(query.studyId) + 'guest');
                            var testerUrl = origin + '/study-prepare-tester.php?studyId=' + query.studyId + '&token=' + query.h + "&h=" + hash;
                            var moderatorUrl = origin + '/study-prepare.php?studyId=' + query.studyId + '&h=' + query.h;

                            if (result.studyData.surveyType === TYPE_SURVEY_MODERATED) {
                                prepareStudyExecution({studyId: query.studyId, executionUrl: moderatorUrl}, function (result) {
                                    if (result.status === RESULT_SUCCESS) {
                                        goto(testerUrl);
                                    } else {
                                        console.error(result.status);
                                    }
                                });
                            } else {
                                goto(testerUrl);
                            }
                        } else {
                            console.error('error: ', result.status);
                        }
                    });
                });
            }
        </script>
    </body>
</html>
