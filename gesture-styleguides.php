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
        <script src="js/alert.js"></script>
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
                    <li><a class="breadcrump-btn" id="btn-index">Home</a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard">Dashboard</a></li>
                    <li class="active">Gesten-Styleguides</li>
                </ol>
            </div>
        </div>

        <!-- Container (Landing Section) -->
        <div class="container-fluid text-center bg-grey" id="landingText">
            <div class="container">
                <h1><i class="fa fa-map-signs" style="font-size: 60pt" aria-hidden="true"></i> GESTEN-STYLEGUIDES</h1>
            </div>
        </div>

        <div class="container" id="general-styleguides" style="margin-top: 50px">
            <h2>Gesten-Designprozess</h2>
            <hr>
            <div class="text">
                Allgemeines zum Designprozess, um die Styleguides zu verstehen.
            </div>
        </div>

        <div class="container" id="general-styleguides" style="margin-top: 50px">
            <h2>Allgemeine Styleguides</h2>
            <hr>
            <p>Diese Styleguides beziehen sich auf den Gesten-Designprozess in seiner Gänze. Sie dienen als Wegweiser.</p>
            <div class="text">
                <ul>
                    <li>Ergebnis eines Gestendesigns sind ergnonomische, komfortable und benutzbare (d.h. effiziente, einfache und intuitive) Gesten.</li>
                    <li>Jede Iteration des Gestendesigns sollte mit Endanwendern durchgeführt werden.</li>
                    <li>Gesten sollten von Nutzern bewertet werden.</li>
                    <li>Beim Gestendesign sollten kulturelle Aspekte berücksichtigt werden.</li>
                    <ul>
                        <li>Befragung von potentiellen Nutzern aus anderen Gebieten und Kulturen.</li>
                        <li>Beim Design von statischen Gesten sollte vorsichtig agiert werden, da diese in anderen Kulturen anders aufgefasst werden können.</li>
                    </ul>
                    <li>…</li>
                </ul>
            </div>
        </div>
        <div class="container" id="heuristics-styleguides">
            <h2 style="margin-top: 40px">Heuristiken</h2>
            <hr>
            <p></p>
            <div class="text">

            </div>
        </div>
        <div class="container" id="gus-styleguides" style="margin-bottom: 60px;">
            <h2 style="margin-top: 40px">Gesture Usability Scale</h2>
            <hr>
            <p>Der Gesture Usability Scale (GUS) ist ein Baukasten zum Erstellen von Fragebögen für die subjektive Bewertung der Gebrauchstauglichkeit von Gesten durch den Benutzer. Beim Konfigurieren einer neuen Studie kann der GUS in zwei Varianten genutzt werden. Nachfolgend wird ein Überblick über die einzelnen Items und deren zugrunde liegenden Styleguides gegeben.</p>
            <div class="text">

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
                console.log('onAllExternalsLoadedSuccessfully');
                renderSubPageElements();
            }
        </script>

    </body>
</html>