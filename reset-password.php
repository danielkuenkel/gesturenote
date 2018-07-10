<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
$h = getv('h');

if (!$h) {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $lang->gestureNoteResetPassword ?></title>
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

        <script src="js/alert.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/sha512.js"></script>
        <script src="js/checkForms.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-general"></div>



        <!-- Container (Landing Section) -->
        <div class="container" id="breadcrumb" style="margin-top: 50px">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                    <li class="active"><?php echo $lang->breadcrump->resetPassword ?></li>
                </ol>
            </div>
        </div>

        <div class="container mainContent" style="margin-top: 0px">
            <div class="row" id="password-reset">
                <div class="col-md-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title"><?php echo $lang->updatePassword ?></h2>
                        </div>
                        <div class="panel-body">

                            <div id="reset-password-form">
                                <div class="alert-space alert-general-error"></div>
                                <div class="alert-space alert-missing-fields"></div>
                                <div class="alert-space alert-reset-password-error"></div>

                                <div id="form-groups">
                                    <div class="alert-space alert-invalid-email"></div>
                                    <div class="alert-space alert-check-email"></div>

                                    <div class="form-group">
                                        <label for="email"><?php echo $lang->email ?></label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="">
                                    </div>

                                    <div class="alert-space alert-password-short"></div>
                                    <div class="alert-space alert-password-invalid"></div>
                                    <div class="alert-space alert-passwords-not-matching"></div>

                                    <div class="form-group">
                                        <label for="password"><?php echo $lang->newPassword ?></label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmPassword"><?php echo $lang->newPasswordConfirm ?></label>
                                        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="">
                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-default btn-shadow pull-right" id="btn-reset-password"><i class="fa fa-pencil" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->saveUpdatedPassword ?></span></button>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                </div>
                <div class="col-md-5 text">
                    <?php echo $lang->resetPasswordInfo ?>
                </div>
            </div>
            <div class="row hidden" id="goto-login">
                <div class="col-md-12">
                    <div class="alert-space alert-password-reset-success"></div>
                    <button type="button" class="btn btn-success btn-shadow btn-block" id="btn-goto-login"><span class="btn-text"><?php echo $lang->loginNow ?></span></button>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                checkDomain();
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements(false);

                $('#btn-reset-password').on('click', function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
                        clearAlerts($('#reset-password-form'));
                        resetPasswordFormhash($('#reset-password-form'));
                    }
                });

                $(document).on('submit', '#reset-password-form', function (event) {
                    event.preventDefault();
                    var formElement = $(this);
                    clearAlerts(formElement);
                    var button = $(this);
                    lockButton($(button), true, 'fa-pencil');

                    var query = getQueryParams(document.location.search);
                    if (query && query.h) {
                        var data = {email: $(formElement).find('#email').val().trim(), p: $(formElement).find('#p').val(), hash: query.h};
                        resetPassword(data, function (result) {
                            unlockButton($(button), true, 'fa-pencil');
                            if (result.status === RESULT_SUCCESS) {
                                appendAlert($('#goto-login'), ALERT_PASSWORD_RESET_SUCCESS);
                                $('#password-reset').addClass('hidden');
                                $('#goto-login').removeClass('hidden');
                            } else if (result.status === 'resetPasswordError') {
                                appendAlert($('#reset-password-form'), ALERT_RESET_PASSWORD_ERROR);
                            } else if (result.status === 'checkEmail') {
                                appendAlert($('#reset-password-form'), ALERT_CHECK_EMAIL);
                            } else {
                                appendAlert($('#reset-password-form'), ALERT_GENERAL_ERROR);
                            }
                        });

                    }
                });
            }

            $('#btn-goto-login').on('click', function (event) {
                gotoIndex();
            });
        </script>

    </body>
</html>