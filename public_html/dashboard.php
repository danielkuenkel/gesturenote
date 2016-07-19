<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

session_start();

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
        <link rel="stylesheet" href="externals/font-awesome/css/font-awesome.min.css">
        <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="js/gotoPage.js"></script>
        <script src="js/subPages.js"></script>
        <script src="js/mainLanding.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

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
        <div class="container center-text mainContent">

            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-projects">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-tasks" aria-hidden="true"></i> Projekte</div>
                        <div class="panel-body">Panel Body</div>
                        <div class="panel-footer">Panel Footer</div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-gesture-styleguides">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-map-signs" aria-hidden="true"></i> Gesten Styleguides</div>
                        <div class="panel-body">Panel Body</div>
                        <div class="panel-footer">Panel Footer</div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-gesture-catalog">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-sign-language" aria-hidden="true"></i> Gestenkatalog</div>
                        <div class="panel-body">Panel Body</div>
                        <div class="panel-footer">Panel Footer</div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-profile">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-user" aria-hidden="true"></i> Profil</div>
                        <div class="panel-footer">Edit your profile</div>
                        <!--<div class="panel-footer">Panel Footer</div>-->
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
