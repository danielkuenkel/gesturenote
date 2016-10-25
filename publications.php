<?php
include './includes/language.php';
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
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

        <script src="js/storage.js"></script>
        <!--<script src="js/alert.js"></script>-->
        <script src="js/ajax.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/globalFunctions.js"></script>
<!--        <script src="js/sha512.js"></script>
        <script src="js/checkForms.js"></script>-->
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <!--<div id="alerts"></div>-->
        <div id="template-subpages"></div>



        <!-- Container (Landing Section) -->
        <div class=" container-fluid bg-grey wall" id="landingText">
            <!-- Container (Breadcrump) -->
            <div class="container" id="breadcrumb">
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a class="breadcrump-btn" id="btn-index"><?php echo $lang->breadcrump->home ?></a></li>
                        <li><a class="breadcrump-btn" id="btn-dashboard"><?php echo $lang->breadcrump->dashboard ?></a></li>
                        <li class="active"><?php echo $lang->breadcrump->publications ?></li>
                    </ol>
                </div>
            </div>

            <div class="container text-center dropShadowText">
                <h1><i class="fa fa-graduation-cap" style="font-size: 60pt" aria-hidden="true"></i> VERÖFFENTLICHUNGEN</h1>
            </div>
        </div>

        <div class="container mainContent" style="margin-top: 50px">
            <div class="row">

            </div>
        </div>

        <script>
            $(document).ready(function () {
                checkDomain();
                checkLanguage(function () {
                    var externals = new Array();
//                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
            }
        </script>

    </body>
</html>