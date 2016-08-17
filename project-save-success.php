<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

session_start();
//print_r(ini_get('upload_max_filesize'));
if (login_check($mysqli) == false) {
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
        <script src="js/sha512.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/gotoPage.js"></script>
        <script src="js/globalFunctions.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="templage-subpages"></div>

        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index">Home</a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard">Dashboard</a></li>
                    <li><a class="breadcrump-btn" id="btn-studies">Studien</a></li>
                </ol>
            </div>
        </div>

        <!-- Container (Landing Section) -->
        <div class=" container-fluid text-center bg-grey" id="landingText">
            <div class="container">
                <h1><i class="fa fa-check" style="font-size: 60pt" aria-hidden="true"></i> STUDIE GESPEICHERT</h1>
            </div>
        </div>

        <div class="container mainContent">
            <button class="btn btn-success btn-lg btn-block" id="btn-open-study">Zur Studie</button>
            <button class="btn btn-success btn-lg btn-block" onclick="gotoProjects()">Zu den Studien</button>
        </div>

        <script>
            $(document).ready(function () {
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#templage-subpages', PATH_EXTERNALS + '/' + currentLanguage + '/template-sub-pages.html']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();

                var query = getQueryParams(document.location.search);
                var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');

                if (query.studyId) {
                    if (hash === query.h) {
                        $('#btn-open-study').on('click', {studyId: query.studyId}, function (event) {
                            event.preventDefault();
                            var hash = hex_sha512(parseInt(event.data.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                            goto("study.php?studyId=" + event.data.studyId + "&h=" + hash);
                        });
                    }
                }
            }
        </script>

    </body>
</html>