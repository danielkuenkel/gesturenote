<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';


sec_session_start();
print_r($_SESSION);

if (login_check($mysqli) == true) {
    // Add your protected page content here!
} else {
    print_r("logged out");
//        header('Location: index.php');
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
                    <li><a class="breadcrump-btn" onclick="gotoIndex()">Home</a></li>
                    <li class="active">Main menu</li>
                </ol>
            </div>
        </div>

        <!-- Container (Landing Section) -->
        <div class=" container-fluid text-center bg-grey" id="landingText">
            <div class="container">
                <h2>WELCOME</h2>
                <p>Please select the desired section.</p>
            </div>
        </div>
        
        
        <?php if (login_check($mysqli) == true) : ?>
            <p>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>
            <p>
                This is an example protected page.  To access this page, users
                must be logged in.  At some stage, we'll also check the role of
                the user, so pages will be able to determine the type of user
                authorised to access the page.
            </p>
            <p>Return to <a href="index.php">login page</a></p>
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="index.php">login</a>.
            </p>
        <?php endif; ?>

        <!-- Container (Panel Section) -->
        <div class="container center-text mainContent">

            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="panel panel-custom panel-custom-pink" onclick="gotoProjects()">
                        <div class="panel-heading">Projects</div>
                        <div class="panel-body">Panel Body</div>
                        <div class="panel-footer">Panel Footer</div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="panel panel-custom panel-custom-pink" onclick="gotoGestureStyleguides()">
                        <div class="panel-heading">Gesture Styleguides</div>
                        <div class="panel-body">Panel Body</div>
                        <div class="panel-footer">Panel Footer</div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="panel panel-custom panel-custom-pink" onclick="gotoGesturesCatalog()">
                        <div class="panel-heading">Gesture Catalog</div>
                        <div class="panel-body">Panel Body</div>
                        <div class="panel-footer">Panel Footer</div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="panel panel-custom panel-custom-pink" onclick="gotoProfile()">
                        <div class="panel-heading">Profile</div>
                        <div class="panel-footer">Edit your profile</div>
                        <!--<div class="panel-footer">Panel Footer</div>-->
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
