<?php
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
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
        <script src="js/register.js"></script>
        <script type="text/JavaScript" src="js/sha512.js"></script>  
        <script type="text/JavaScript" src="js/forms.js"></script>

    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>   
                    </button>
                    <a class="navbar-brand" href="index.html">GestureNote</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.html#about">ABOUT</a></li>
                        <li><a href="index.html#services">SERVICES</a></li>
                        <li><a href="index.html#contact">CONTACT</a></li>
                        <li><a href="index.html#login">SIGN IN</a></li>
                    </ul>
                </div>
            </div>
        </nav> 

        <div class="line text-center"></div>

        <!-- Breadcrump -->
        <div class="container" id="breadcrumb">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" onclick="gotoIndex()">Home</a></li>
                    <li class="active">Register</li>
                </ol>
            </div>
        </div>

        <!-- Header Section -->
        <div class=" container-fluid text-center bg-grey" id="landingText">
            <div class="container">
                <span><h2>REGISTER</h2></span>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
            </div>
        </div>

        <!-- Main Content Container -->
        <div class="container-fluid text-center">
            <?php
            if (!empty($error_msg)) {
                echo $error_msg;
            }
            ?>
            <form role="form" 
                  action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>"
                  method="post" 
                  name="registration_form"
                  id="registerform">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="form-group">
                        <label for="forename" class="sr-only">Vorname</label>
                        <input type="text" class="form-control" name="forename" id="forename" placeholder="Vorname">
                    </div>
                    <div class="form-group">
                        <label for="surname" class="sr-only">Nachname</label>
                        <input type="text" class="form-control" name="surname" id="surname" placeholder="Nachname">
                    </div>
                    <div class="form-group">
                        <label for="email" class="sr-only">E-Mail-Adresse</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="E-Mail-Adresse">
                    </div>
                    <div class="form-group">
                        <label for="password" class="sr-only">Passwort</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Passwort">
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword" class="sr-only">Passwort wiederholen</label>
                        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Passwort wiederholen">
                    </div>

                    <div class="form-group" id="usertype">
                        <label class="radio-inline"><input type="radio" name="usertype" value="tester">I would like to take part in interesting studies as tester</label>
                        <label class="radio-inline"><input type="radio" name="usertype" value="evaluator">I want to create and evaluate studies</label>
                    </div>

                    <input type="button" class="btn btn-default btn-block" value="Register" id="btn-register"/>
                </div>
            </form>

<!--            <form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" 
                  method="post" 
                  name="registration_form">
                Username: <input type='text' 
                                 name='username' 
                                 id='username' /><br>
                Email: <input type="text" name="email" id="email" /><br>
                Password: <input type="password"
                                 name="password" 
                                 id="password"/><br>
                Confirm password: <input type="password" 
                                         name="confirmpwd" 
                                         id="confirmpwd" /><br>
                <input type="button" 
                       value="Register" 
                       onclick="return regformhash($('#registerform'),
                                       $('#forename'),
                                       $('#email'),
                                       $('#password'),
                                       $('#confirmpwd'));" /> 
            </form>-->
        </div>
    </div>

    <!-- Fixed Footer -->
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xs-5">
                    <ul class="nav nav-pills">
                        <li role="presentation"><a href=""><span class="glyphicon glyphicon-copyright-mark"></span> DANIEL KUENKEL</a></li>
                    </ul>
                </div>
                <div class="col-xs-7">
                    <ul class="nav nav-pills navbar-right">
                        <li role="presentation"><a href="#">forgot password</a></li>
                        <li role="presentation"><a href="#">imprint</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <script>
        choosedUsertype = null;
        
        $("#btn-register").on('click', function (event) {
            event.preventDefault();
            
            return regformhash($('#registerform'),
                    $('#forename'),
                    $('#surname'),
                    $('#email'),
                    $('#password'),
                    $('#confirmPassword'),
                    choosedUsertype
                    );
        });
        
        $('#usertype input').on('click', function() {
            choosedUsertype = $(this).val();
        });
    </script>
</body>
</html>
