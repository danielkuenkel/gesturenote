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
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-tester.js"></script>
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
                    <li><a class="breadcrump-btn" id="btn-index">Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </div>
        </div>

        <!-- Container (Landing Section) -->
        <div class=" container-fluid text-center bg-grey" id="landingText">
            <div class="container">
                <h1><i class="fa fa-tachometer" style="font-size: 60pt" aria-hidden="true"></i> DASHBOARD</h1>
                <h2><?php echo htmlentities($_SESSION['forename']) . ' ' . htmlentities($_SESSION['surname']); ?></h2>
                <p>Um fortzufahren wählen Sie bitte aus einer der unten stehenden Kategorien.</p>
            </div>
        </div>

        <!-- Container (Panel Section) -->
        <div class="container center-text mainContent" style="margin-top: 40px">

            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-studies">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-tasks" aria-hidden="true"></i> Studien</div>
                        <div class="panel-body">Panel Body</div>
<!--                        <div class="panel-footer">
                            <button type="button" class="btn btn-success btn-block" id="btn-create-study"><i class="glyphicon glyphicon-plus"></i> Neue Studie erstellen</button>
                        </div>-->
                    </div>
                </div>
<!--                <div class="col-md-4 col-sm-6">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-gesture-styleguides">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-map-signs" aria-hidden="true"></i> Gesten Styleguides</div>
                        <div class="panel-body">Panel Body</div>
                        <div class="panel-footer">Panel Footer</div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-gesture-catalog">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-sign-language" aria-hidden="true"></i> Gestenkatalog</div>
                        <div class="panel-body">
                            <div id="total-gestures"><span class="address"></span> <span class="text"></span></div>
                            <div id="public-gestures"><span class="address"></span> <span class="text"></span></div>
                            <div id="user-gestures"><span class="address"></span> <span class="text"></span></div>
                            <div id="user-public-gestures"><span class="address"></span> <span class="text"></span></div>
                            <div id="elicited-gestures"><span class="address"></span> <span class="text"></span></div>
                        </div>
                        <div class="panel-footer">Panel Footer</div>
                    </div>
                </div>-->
                <div class="col-sm-6">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-profile">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-user" aria-hidden="true"></i> Profil</div>
                        <div class="panel-body">Anzeigen und bearbeiten der Nutzerdaten</div>
                        <!--<div class="panel-footer">Panel Footer</div>-->
                    </div>
                </div>
            </div>
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
//                getDashboardInfos(function (result) {
//                    console.log(result);
//                    if (result.status === RESULT_SUCCESS) {
//                        // gestures catalog infos
//                        var item = $('#btn-gesture-catalog');
//                        $(item).find('#total-gestures .address').text(translation.gesturesCatalog.totalGestures + ":");
//                        $(item).find('#total-gestures .text').text(result.totalGestures);
//                        $(item).find('#public-gestures .address').text(translation.gesturesCatalog.publicGestures + ":");
//                        $(item).find('#public-gestures .text').text(result.publicGestures);
//                        $(item).find('#user-gestures .address').text(translation.gesturesCatalog.userGestures + ":");
//                        $(item).find('#user-gestures .text').text(result.userGestures);
//                        $(item).find('#user-public-gestures .address').text(translation.gesturesCatalog.publicUserGestures + ":");
//                        $(item).find('#user-public-gestures .text').text(result.publicUserGestures);
//                        $(item).find('#elicited-gestures .address').text(translation.gesturesCatalog.elicitedGestures + ":");
//                        $(item).find('#elicited-gestures .text').text(result.elicitedGestures);
//                    } else {
//
//                    }
//                });
            }

//            $('#btn-create-study').click(function (event) {
//                event.preventDefault();
//                event.stopPropagation();
//                gotoCreateStudy();
//            });
        </script>

    </body>
</html>
