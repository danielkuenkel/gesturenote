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
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="js/alert.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-tester.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/sha512.js"></script>
        <script src="js/checkForms.js"></script>
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
                    <li class="active">Profil</li>
                </ol>
            </div>
        </div>

        <!-- Container (Landing Section) -->
        <div class=" container-fluid text-center bg-grey" id="landingText">
            <div class="container">
                <h1><i class="fa fa-user" style="font-size: 60pt" aria-hidden="true"></i> BENUTZERPROFIL</h1>
            </div>
        </div>

        <div class="container mainContent" style="margin-top: 50px">
            <div class="col-md-7">
                <div class="panel panel-default" id="general-preview">
                    <div class="panel-heading">
                        <h2 class="panel-title"></h2>
                    </div>
                    <div class="panel-body">
                        <div id="user-forename"><span class="address"></span> <span class="text"></span></div>
                        <div id="user-surname"><span class="address"></span> <span class="text"></span></div>
                        <div id="user-email"><span class="address"></span> <span class="text"></span></div>
                        <div id="user-type"><span class="address"></span> <span class="text"></span></div>
                        <div id="user-birthday"><span class="address"></span> <span class="text"></span></div>
                        <div id="user-registered"><span class="address"></span> <span class="text"></span></div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-default btn-shadow pull-right disabled" id="btn-edit-profile"><i class="fa fa-pencil" aria-hidden="true"></i> <span class="btn-text"></span></button>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="panel panel-default hidden" id="general-edit">
                    <div class="panel-heading">
                        <h2 class="panel-title"></h2>
                    </div>
                    <div class="panel-body">

                        <div id="update-form">
                            <div class="alert-space alert-general-error"></div>
                            <div class="alert-space alert-missing-fields"></div>

                            <div class="form-group">
                                <label for="forename" id="label-forename"></label>
                                <input type="text" class="form-control" name="forename" id="input-forename" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="surname" id="label-surname"></label>
                                <input type="text" class="form-control" name="surname" id="input-surname" placeholder="">
                            </div>

                            <!--                            <div class="alert-space alert-user-exists"></div>
                                                        <div class="alert-space alert-invalid-email"></div>
                            
                                                        <div class="form-group">
                                                            <label for="email" id="label-email"></label>
                                                            <input type="email" class="form-control" name="email" id="input-email" placeholder="">
                                                        </div>-->

                            <hr>

                            <div class="alert-space alert-wrong-current-password"></div>

                            <div class="form-group">
                                <label for="input-current-password" id="label-current-password"></label>
                                <input type="password" class="form-control" name="password" id="input-current-password" placeholder="">
                            </div>

                            <div class="alert-space alert-password-short"></div>
                            <div class="alert-space alert-password-invalid"></div>
                            <div class="alert-space alert-passwords-not-matching"></div>

                            <div class="form-group">
                                <label for="password" id="label-new-password"></label>
                                <input type="password" class="form-control" name="password" id="input-new-password" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="input-confirm-password" id="label-confirm-new-password"></label>
                                <input type="password" class="form-control" name="confirmPassword" id="input-confirm-new-password" placeholder="">
                            </div>

                            <hr>

                            <div class="alert-space alert-invalid-birthday"></div>

                            <div class="form-group">
                                <label id="label-birthday"></label>
                                <div class="input-group" id="input-birthday">
                                    <span class="input-group-addon" id="label-date"></span>
                                    <input class="form-control" id="input-date" type="text" placeholder="z.B. 1" minlength="1" maxlength="2"/>
                                    <span class="input-group-addon" id="label-month"></span>
                                    <input class="form-control" id="input-month" type="text" placeholder="z.B. 12" minlength="1" maxlength="2"/>
                                    <span class="input-group-addon" id="label-year"></span>
                                    <input class="form-control" id="input-year" type="text" placeholder="z.B. 1980" minlength="4" maxlength="4"/>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer">
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-danger btn-shadow" id="btn-cancel-edit-profile"><i class="fa fa-close" aria-hidden="true"></i> <span class="btn-text"></span></button>
                            <button type="button" class="btn btn-default btn-shadow" id="btn-update-profile"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"></span></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel panel-default" id="gestures-overview">
                    <div class="panel-heading"></div>
                    <div class="panel-body">

                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                checkDomain();
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + '/' + currentLanguage + '/alerts.html']);
                    externals.push(['#templage-subpages', PATH_EXTERNALS + '/' + currentLanguage + '/template-sub-pages.html']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
                $('#btn-edit-profile .btn-text').text(translation.editProfile);
                $('#general-preview .panel-title').text(translation.general);
                $('#general-edit .panel-title').text(translation.generalEdit);
                $('#btn-cancel-edit-profile .btn-text').text(translation.cancel);
                $('#btn-update-profile .btn-text').text(translation.updateProfile);

                getUser(function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        var user = result.user[0];

                        $('#btn-edit-profile').removeClass('disabled');

                        $('#user-forename .address').text(translation.forename + ": ");
                        $('#label-forename').text(translation.forename);
                        $('#user-forename .text').text(user.forename);
                        $('#input-forename').val(user.forename);

                        $('#user-surname .address').text(translation.surname + ": ");
                        $('#label-surname').text(translation.surname);
                        $('#user-surname .text').text(user.surname);
                        $('#input-surname').val(user.surname);

                        $('#user-email .address').text(translation.email + ": ");
                        $('#label-email').text(translation.email);
                        $('#user-email .text').text(user.email);
//                        $('#input-email').val(user.email);

                        $('#label-current-password').text(translation.currentPassword);
                        $('#label-new-password').text(translation.newPassword);
                        $('#label-confirm-new-password').text(translation.confirmNewPassword);

                        $('#user-type .address').text(translation.userType + ": ");
                        $('#user-type .text').text(translation.userTypes[user.userType]);

                        var birthday = new Date(user.birthday * 1000);
                        $('#user-birthday .address').text(translation.birthday + ": ");
                        $('#label-birthday').text(translation.birthday);
                        $('#user-birthday .text').text(birthday.toLocaleDateString());
                        $('#label-date').text(translation.day);
                        $('#input-date').val(birthday.getDate());
                        $('#label-month').text(translation.month);
                        $('#input-month').val(parseInt(birthday.getMonth()) + 1);
                        $('#label-year').text(translation.year);
                        $('#input-year').val(birthday.getFullYear());

                        $('#user-registered .address').text(translation.userRegistered + ": ");
                        $('#user-registered .text').text(convertSQLTimestampToDate(user.created).toLocaleDateString());
                    }
                });
            }

            $('#btn-edit-profile').on('click', function (event) {
                event.preventDefault();
                if (!event.handled && !$(this).hasClass('disabled')) {
                    event.handled = true;
                    $('#general-edit').removeClass('hidden');
                    $('#general-preview').addClass('hidden');
                }
            });

            $('#btn-cancel-edit-profile').on('click', function (event) {
                if (!event.handled) {
                    event.handled = true;
                    $('#general-edit').addClass('hidden');
                    $('#general-preview').removeClass('hidden');
                }
            });

            $('#btn-update-profile').on('click', function (event) {
                if (!event.handled) {
                    event.handled = true;
                    clearAlerts($('#update-form'));
                    updateFormhash($('#update-form'), $('#update-form'));
                }
            });

            $('#update-form').on('submit', function (event) {
                event.preventDefault();

                clearAlerts($(this));

                var forename = $('#update-form #input-forename').val().trim();
                var surname = $('#update-form #input-surname').val().trim();
//                var email = $('#update-form #input-email').val().trim();
                var p, pO = null;
                if ($('#update-form #p') !== undefined && $('#update-form #p').length !== 0) {
                    p = $('#update-form #p').val().trim();
                }
                if ($('#update-form #pO') !== undefined && $('#update-form #pO').length !== 0) {
                    pO = $('#update-form #pO').val().trim();
                }
                var date = parseInt($('#update-form #input-date').val().trim());
                var month = parseInt($('#update-form #input-month').val().trim());
                var year = parseInt($('#update-form #input-year').val().trim());
                var birthday = year + "-" + month + "-" + date;

                if (p !== null && pO !== null) {
                    updateUser({forename: forename, surname: surname, email: email, p: p, pO: pO, birthday: birthday}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            $('#user-forename .text').text(forename);
                            $('#user-surname .text').text(surname);
//                            $('#user-email .text').text(email);
                            $('#user-birthday .text').text(new Date(year, month - 1, date, 0, 0, 0, 0).toLocaleDateString());
                            $('#general-edit').addClass('hidden');
                            $('#general-preview').removeClass('hidden');
                            $('#input-current-password').val('');
                            $('#input-new-password').val('');
                            $('#input-confirm-new-password').val('');
                            $('#update-form').find('#p').remove();
                            $('#update-form').find('#pO').remove();
                        } else if (result.status === RESULT_WRONG_CURRENT_PASSWORD) {
                            appendAlert($('#update-form'), ALERT_WRONG_CURRENT_PASSWORD);
                        } else {
                            appendAlert($('#update-form'), ALERT_GENERAL_ERROR);
                        }
                    });
                } else {
                    updateUser({forename: forename, surname: surname, birthday: birthday}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            $('#user-forename .text').text(forename);
                            $('#user-surname .text').text(surname);
//                            $('#user-email .text').text(email);
                            $('#user-birthday .text').text(new Date(year, month - 1, date, 0, 0, 0, 0).toLocaleDateString());
                            $('#general-edit').addClass('hidden');
                            $('#general-preview').removeClass('hidden');
                            $('#input-current-password').val('');
                            $('#input-new-password').val('');
                            $('#input-confirm-new-password').val('');
                            $('#update-form').find('#p').remove();
                            $('#update-form').find('#pO').remove();
                        } else {
                            appendAlert($('#update-form'), ALERT_GENERAL_ERROR);
                        }
                    });
                }
            });
        </script>

    </body>
</html>