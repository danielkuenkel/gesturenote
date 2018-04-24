<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $lang->gestureNoteImprint ?></title>
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
        <script src="js/ajax.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/globalFunctions.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <!--<div id="alerts"></div>-->
        <div id="template-subpages"></div>


        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb"style="margin-top: 40px">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li class="active"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $lang->breadcrump->imprint ?></li>
                </ol>
            </div>
        </div>


        <!-- Container (Landing Section) -->
        <div class="container mainContent" style="margin-top: 0px">
            <div class="">
                <div class="page-header" style="margin-top: 0px">
                    <h2><?php echo $lang->imprintContent->mainHeadline ?>:</h2>
                </div>
                <div class="info-text text">
                    <p><?php echo $lang->imprintContent->adress ?></p>
                    <p><?php echo $lang->email ?>: <a href="mailto:admin@gesturenote.de"><i class="glyphicon glyphicon-link"></i> admin@gesturenote.de</a></p>
                    <p><?php echo $lang->imprintContent->source ?>: <a href="https://www.e-recht24.de"><i class="glyphicon glyphicon-link"></i> e-recht24.de</a></p>
                </div>
            </div>

            <div class="">
                <div class="page-header">
                    <h2><?php echo $lang->imprintContent->disclaimerHeadline ?></h2>
                </div>
                <div class="info-text text">
                    <?php echo $lang->imprintContent->disclaimerContent ?>
                </div>
            </div>

            <div class="">
                <div class="page-header">
                    <h2><?php echo $lang->imprintContent->dataProtectionHeadline ?></h2>
                </div>
                <div class="info-text text">
                    <?php echo $lang->imprintContent->dataProtectionContent ?>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                checkDomain();
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {

                var loggedIn = parseInt('<?php echo login_check($mysqli) ?>') === 1;
                renderSubPageElements(loggedIn, true);
                if (loggedIn === false) {
                    $('#btn-dashboard').parent().remove();
                }
            }
        </script>

    </body>
</html>