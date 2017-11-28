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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

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
        <div id="template-subpages"></div>



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
                            <h2 class="panel-title">Neues Passwort vergeben</h2>
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
                            <button type="button" class="btn btn-default btn-shadow pull-right" id="btn-reset-password"><i class="fa fa-pencil" aria-hidden="true"></i> <span class="btn-text">Neues Passwort speichern</span></button>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                </div>
                <div class="col-md-5 text">
                    Um Ihr Passwort zurückzusetzen, geben Sie bitte ihre E-Mail-Adresse und ihr neues Passwort ein. Wiederholen Sie zur Sicherheit ihr neues Passwort.
                </div>
            </div>
            <div class="row hidden" id="goto-login">
                <div class="col-md-12">
                    <div class="alert-space alert-password-reset-success"></div>
                    <button type="button" class="btn btn-success btn-shadow btn-block" id="btn-goto-login"><span class="btn-text">Jetzt einloggen</span></button>
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