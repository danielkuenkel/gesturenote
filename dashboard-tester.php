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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>

        <script src="js/storage.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-tester.js"></script>
        <script src="js/globalFunctions.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-subpages"></div>



        <!-- Container (Landing Section) -->
        <div class=" container-fluid bg-grey wall" id="landingText">
            
            <!-- Container (Breadcrump) -->
            <div class="container" id="breadcrumb">
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                        <li class="active"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></li>
                    </ol>
                </div>
            </div>

            <div class="container text-center dropShadowText">
                <h1><i class="fa fa-tachometer" style="font-size: 60pt" aria-hidden="true"></i> DASHBOARD</h1>
                <h2><?php echo htmlentities($_SESSION['forename']) . ' ' . htmlentities($_SESSION['surname']); ?></h2>
                <p>Um fortzufahren wählen Sie bitte aus einer der unten stehenden Kategorien.</p>
            </div>
        </div>

        <!-- Container (Panel Section) -->
        <div class="container center-text mainContent" style="margin-top: 40px">

            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-studies" style="opacity: 0">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-tasks" aria-hidden="true"></i> <?php echo $lang->dashboard->studies ?></div>
                        <div class="panel-body">Panel Body</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-profile" style="opacity: 0">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $lang->dashboard->profile ?></div>
                        <div class="panel-body">Anzeigen und bearbeiten der Nutzerdaten</div>
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
                renderSubPageElements();
                animateStart();
            }

            function animateStart() {
                $('#btn-studies').css({opacity: 1});
                TweenMax.from($('#btn-studies'), .2, {delay: 0, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                $('#btn-profile').css({opacity: 1});
                TweenMax.from($('#btn-profile'), .2, {delay: .1, opacity: 0, scaleX: 0.5, scaleY: 0.5});
            }
        </script>

    </body>
</html>
