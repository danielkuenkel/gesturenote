<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

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
        <title><?php echo $lang->gestureNoteProfile ?></title>
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

        <script src="js/refreshSession.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/sha512.js"></script>
        <script src="js/checkForms.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-subpages"></div>


        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb"style="margin-top: 40px">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li class="active"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $lang->breadcrump->profile ?></li>
                </ol>
            </div>
        </div>


        <!-- Container (Landing Section) -->
        <div class="container mainContent" style="margin-top: 0px">
            <div class="row">
                <div class="col-md-7">
                    <h4><?php echo $lang->general ?></h4>
                    <hr style="margin-top: 0">
                    <div class="" id="general-preview">
                        <div class="form-group">
                            <div id="user-forename"><span class="address"></span> <span class="text"></span></div>
                            <div id="user-surname"><span class="address"></span> <span class="text"></span></div>
                            <div id="user-email"><span class="address"></span> <span class="text"></span></div>
                            <!--<div id="user-type"><span class="address"></span> <span class="text"></span></div>-->
                            <div id="user-registered"><span class="address"></span> <span class="text"></span></div>
                        </div>
                        <button type="button" class="btn btn-default btn-shadow disabled" id="btn-edit-profile"><i class="fa fa-pencil" aria-hidden="true"></i> <span class="btn-text"></span></button>
                    </div>
                    <div class=" hidden" id="general-edit">
                        <div class="">

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

                            </div>

                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger btn-shadow" id="btn-cancel-edit-profile"><i class="fa fa-close" aria-hidden="true"></i> <span class="btn-text"></span></button>
                            <button type="button" class="btn btn-default btn-shadow" id="btn-update-profile"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"></span></button>
                        </div>
                    </div>



                    <div id="introduction-settings" style="margin-top: 40px">
                        <h4>Hilfe</h4>
                        <hr style="margin-top: 0">
                        <div class="form-group root" id="tutorialStudyCreation" data-help-context="studyCreation">
                            <label><?php echo $lang->tutorialStudyCreationQuestion ?></label><br/>

                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="no">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->no ?></span>
                                </button>
                            </div>
                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="yes">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->yes ?></span>
                                </button>
                            </div>
                        </div>

                        <div class="form-group root" id="tutorialStudyPreview" data-help-context="studyPreview">
                            <label><?php echo $lang->tutorialStudyPreviewQuestion ?></label><br/>

                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="no">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->no ?></span>
                                </button>
                            </div>
                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="yes">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->yes ?></span>
                                </button>
                            </div>
                        </div>

                        <div class="form-group root" id="tutorialStudy" data-help-context="study">
                            <label><?php echo $lang->tutorialStudyQuestion ?></label><br/>

                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="no">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->no ?></span>
                                </button>
                            </div>
                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="yes">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->yes ?></span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group root" id="tutorialParticipant" data-help-context="participant">
                            <label><?php echo $lang->tutorialParticipantQuestion ?></label><br/>

                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="no">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->no ?></span>
                                </button>
                            </div>
                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="yes">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->yes ?></span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group root" id="tutorialGestureCatalog" data-help-context="gestureCatalog">
                            <label><?php echo $lang->tutorialGestureCatalogQuestion ?></label><br/>

                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="no">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->no ?></span>
                                </button>
                            </div>
                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="yes">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->yes ?></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="panel panel-default" id="statistics">
                        <div class="panel-heading"><?php echo $lang->statistic ?></div>
                        <div class="panel-body">
                            <div id="stats-studies"><?php echo $lang->stats->studies ?>: <span class="amount text"></span></div>
                            <div id="stats-gestures"><?php echo $lang->stats->gestures ?>: <span class="amount text"></span></div>
                            <div id="stats-gestures-shared"><?php echo $lang->stats->gesturesShared ?>: <span class="amount text"></span></div>
                            <div id="stats-gestures-liked"><?php echo $lang->stats->gesturesLiked ?>: <span class="amount text"></span></div>
                            <div id="stats-gestures-rated"><?php echo $lang->stats->gesturesRated ?>: <span class="amount text"></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                checkDomain();
                keepSessionAlive();
                
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
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
                        setLocalItem(USER, user);

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

                        $('#label-current-password').text(translation.currentPassword);
                        $('#label-new-password').text(translation.newPassword);
                        $('#label-confirm-new-password').text(translation.confirmNewPassword);

//                        $('#user-type .address').text(translation.userType + ": ");
//                        $('#user-type .text').text(translation.userTypes[user.userType]);

                        $('#user-registered .address').text(translation.userRegistered + ": ");
                        $('#user-registered .text').text(convertSQLTimestampToDate(user.created).toLocaleDateString());

                        $('#tutorialStudyCreation').find(parseInt(user.tutorialStudyCreation) === 0 ? '#no' : '#yes').click();
                        $('#tutorialStudyPreview').find(parseInt(user.tutorialStudyPreview) === 0 ? '#no' : '#yes').click();
                        $('#tutorialStudy').find(parseInt(user.tutorialStudy) === 0 ? '#no' : '#yes').click();
                        $('#tutorialParticipant').find(parseInt(user.tutorialParticipant) === 0 ? '#no' : '#yes').click();
                        $('#tutorialGestureCatalog').find(parseInt(user.tutorialGestureCatalog) === 0 ? '#no' : '#yes').click();

                        // render statistics
                        $('#stats-studies .amount').text(user.statistics.totalStudies);
                        $('#stats-gestures .amount').text(user.statistics.totalGestures);
                        $('#stats-gestures-shared .amount').text(user.statistics.sharedGestures);
                        $('#stats-gestures-liked .amount').text(user.statistics.likedGestures);
                        $('#stats-gestures-rated .amount').text(user.statistics.ratedGestures);
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
                    updateFormhashEvaluator($('#update-form'));
                }
            });

            $('#update-form').on('submit', function (event) {
                event.preventDefault();

                clearAlerts($(this));

                var forename = $('#update-form #input-forename').val().trim();
                var surname = $('#update-form #input-surname').val().trim();
                var p, pO = null;
                if ($('#update-form #p') !== undefined && $('#update-form #p').length !== 0) {
                    p = $('#update-form #p').val().trim();
                }
                if ($('#update-form #pO') !== undefined && $('#update-form #pO').length !== 0) {
                    pO = $('#update-form #pO').val().trim();
                }

                if (p !== null && pO !== null) {
                    console.log(p, pO);
                    updateUser({forename: forename, surname: surname, p: p, pO: pO}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            $('#user-forename .text').text(forename);
                            $('#user-surname .text').text(surname);
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
                    updateUser({forename: forename, surname: surname}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            $('#user-forename .text').text(forename);
                            $('#user-surname .text').text(surname);
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

            $('#tutorialStudyCreation, #tutorialStudyPreview, #tutorialStudy, #tutorialParticipant, #tutorialGestureCatalog').unbind('change').bind('change', function (event) {
                event.preventDefault();
                var context = $(this).attr('data-help-context');
                var showTutorial = $(this).find('.btn-option-checked').attr('id') === 'yes' ? 1 : 0;
                updateIntroduction({context: context, dontShowIntroduction: showTutorial});
            });
        </script>

    </body>
</html>