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
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>
        
        <script src="js/storage.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/globalFunctions.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="templage-subpages"></div>

        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><?php echo $lang->breadcrump->home ?></a></li>
                    <li class="active"><?php echo $lang->breadcrump->dashboard ?></li>
                </ol>
            </div>
        </div>

        <!-- Container (Landing Section) -->
        <div class=" container-fluid text-center bg-grey" id="landingText">
            <div class="container">
                <h1><i class="fa fa-tachometer" style="font-size: 60pt" aria-hidden="true"></i> <span class="uppercase"><?php echo $lang->dashboard->dashboard ?></span></h1>
                <h2><?php echo htmlentities($_SESSION['forename']) . ' ' . htmlentities($_SESSION['surname']); ?></h2>
                <p><?php echo $lang->dashboard->dashboardInfo ?></p>
            </div>
        </div>

        <!-- Container (Panel Section) -->
        <div class="container center-text mainContent" style="margin-top: 40px">

            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-studies" style="opacity: 0">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-tasks" aria-hidden="true"></i> <?php echo $lang->dashboard->studies ?></div>
                        <div class="panel-body"><?php echo $lang->dashboard->studiesPanelBody ?></div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-success btn-block" id="btn-create-study"><i class="glyphicon glyphicon-plus"></i> <span class="btn-text"><?php echo $lang->createNewStudy ?></span></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-gesture-styleguides" style="opacity: 0">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-map-signs" aria-hidden="true"></i> <?php echo $lang->dashboard->gesturesStyleguides ?></div>
                        <div class="panel-body"><?php echo $lang->dashboard->gesturesStyleguidesPanelBody ?></div>
                        <!--<div class="panel-footer">Panel Footer</div>-->
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-gesture-catalog" style="opacity: 0">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-sign-language" aria-hidden="true"></i> <?php echo $lang->dashboard->gesturesCatalog ?></div>
                        <div class="panel-body">
                            <div id="total-gestures"><span class="address"></span> <span class="text"></span></div>
                            <div id="public-gestures"><span class="address"></span> <span class="text"></span></div>
                            <div id="user-gestures"><span class="address"></span> <span class="text"></span></div>
                            <div id="user-public-gestures"><span class="address"></span> <span class="text"></span></div>
                            <div id="elicited-gestures"><span class="address"></span> <span class="text"></span></div>
                        </div>
                        <!--<div class="panel-footer">Panel Footer</div>-->
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-profile" style="opacity: 0">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $lang->dashboard->profile ?></div>
                        <div class="panel-body"><?php echo $lang->dashboard->profilePanelBody ?></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-publications" style="opacity: 0">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <?php echo $lang->dashboard->publications ?></div>
                        <div class="panel-body"><?php echo $lang->dashboard->publicationsPanelBody ?></div>
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
                    externals.push(['#templage-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
                getDashboardInfos(function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        // gestures catalog infos
                        var item = $('#btn-gesture-catalog');
                        $(item).find('#total-gestures .address').text(translation.gesturesCatalog.totalGestures + ":");
                        $(item).find('#total-gestures .text').text(result.totalGestures);
                        $(item).find('#public-gestures .address').text(translation.gesturesCatalog.publicGestures + ":");
                        $(item).find('#public-gestures .text').text(result.publicGestures);
                        $(item).find('#user-gestures .address').text(translation.gesturesCatalog.userGestures + ":");
                        $(item).find('#user-gestures .text').text(result.userGestures);
                        $(item).find('#user-public-gestures .address').text(translation.gesturesCatalog.publicUserGestures + ":");
                        $(item).find('#user-public-gestures .text').text(result.publicUserGestures);
                        $(item).find('#elicited-gestures .address').text(translation.gesturesCatalog.elicitedGestures + ":");
                        $(item).find('#elicited-gestures .text').text(result.elicitedGestures);
                        animateStart();
                    } else {

                    }
                });
            }

            function animateStart() {
                $('#btn-studies').css({opacity: 1});
                TweenMax.from($('#btn-studies'), .2, {delay: 0, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                $('#btn-gesture-styleguides').css({opacity: 1});
                TweenMax.from($('#btn-gesture-styleguides'), .2, {delay: .05, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                $('#btn-gesture-catalog').css({opacity: 1});
                TweenMax.from($('#btn-gesture-catalog'), .2, {delay: .1, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                $('#btn-profile').css({opacity: 1});
                TweenMax.from($('#btn-profile'), .2, {delay: .15, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                $('#btn-publications').css({opacity: 1});
                TweenMax.from($('#btn-publications'), .2, {delay: .2, opacity: 0, scaleX: 0.5, scaleY: 0.5});
            }

            $('#btn-create-study').click(function (event) {
                event.preventDefault();
                event.stopPropagation();
                gotoCreateStudy();
            });
        </script>

    </body>
</html>
