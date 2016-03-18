<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();
$_SESSION['test'] = 'test';
print_r($_SESSION);

if (login_check($mysqli) == true) {
    $logged = 'in';
    print_r($logged);
//    header('Location: mainLanding.php');
} else {
    $logged = 'out';
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
        <link rel="stylesheet" href="css/index.css">
        <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="js/gotoPage.js"></script>
        <script src="js/index.js"></script>
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
                    <a class="navbar-brand" href="#pageBody"><span class="glyphicon glyphicon-stats"></span> GestureNote</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#about">ABOUT</a></li>
                        <li><a href="#services">SERVICES</a></li>
                        <li><a href="#contact">CONTACT</a></li>
                        <li><a href="#login"><span class="glyphicon glyphicon-log-in"></span> SING IN</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="jumbotron text-center">
            <h1><span class="glyphicon glyphicon-stats"></span> GestureNote</h1> 
            <p>Specialized in usability engineering for gesture interaction</p> 
        </div>
        <div class="line text-center" data-spy="affix" data-offset-top="372"></div>

        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?> 

        <!-- Container (Login Section) -->
        <div id="login" class="container-fluid text-center">
            <h2>LOGIN</h2>

            <!--            <form action="includes/process_login.php" method="post" name="login_form">                      
                            Email: <input type="text" name="email" />
                            Password: <input type="password" 
                                             name="password" 
                                             id="password"/>
                            <input type="button" 
                                   value="Login" 
                                   onclick="formhash(this.form, this.form.password);" /> 
                        </form>-->

            <form role="form" 
                  action="includes/process_login.php"
                  method="post" 
                  name="login_form"
                  id="loginform">



                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4">
                        <label for="email" class="sr-only">E-Mail-Adresse</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="E-Mail-Adresse">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4">
                        <label for="password" class="sr-only">Passwort</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Passwort">
                    </div>
                </div>


                <div class="col-sm-offset-2 col-sm-8">
                    <!--<input type="button" class="btn btn-default btn-block" value="Einloggen" id="btn-login"/>-->
                    <button type="button" class="btn btn-gn btn-block btn-lg" id="btn-login" onclick="formhash(this.form, this.form.password);">
                        <span class="glyphicon glyphicon-log-in"></span> Einloggen
                    </button>
                </div>

            </form>
            <div class="col-sm-8 col-sm-offset-2 form-group">
                <div class="btn-group btn-group-justified" id="forgot-register-button-group">
                    <div class="btn-group ">
                        <button type="button" class="btn btn-gn btn-block" id="btn-forgot" onclick="gotoForgotPassword()">
                            <span class="glyphicon glyphicon-time"></span> Passwort vergessen
                        </button>

                    </div>
                    <!--                        <span>OR</span>-->
                    <div class="btn-group">
                        <button type="button" class="btn btn-gn btn-block" id="btn-register" onclick="gotoRegister()">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Konto anlegen
                        </button>
                    </div>
                </div></div>
        </div>





        <!--            <div class="col-sm-offset-2 col-sm-4 form-group">
                        <input type="email" class="form-control" id="input-email" size="50" placeholder="Email Address" required>
                    </div>
                    <div class="col-sm-4 form-group">
                        <input type="password" class="form-control" id="input-password" size="50" placeholder="Password" required>
                    </div>-->


        <!--        <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 form-group">
                        <button type="button" class="btn btn-gn btn-block btn-lg" id="btn-login" onclick="gotoMainLanding()">
                            <span class="glyphicon glyphicon-log-in"></span> Einloggen
                        </button>
                        <div class="btn-group btn-group-justified" id="forgot-register-button-group">
                            <div class="btn-group">
                                <button type="button" class="btn btn-gn btn-block" id="btn-forgot" onclick="gotoForgotPassword()">
                                    <span class="glyphicon glyphicon-time"></span> Passwort vergessen
                                </button>
        
                            </div>
                                                    <span>OR</span>
                            <div class="btn-group">
                                <button type="button" class="btn btn-gn btn-block" id="btn-register" onclick="gotoRegister()">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Konto anlegen
                                </button>
                            </div>
                        </div>
                    </div>
                </div>-->


        <!-- Container (About Section) -->
        <div id="about" class="container-fluid bg-grey">
            <div class="row">
                <div class="col-sm-3 col-sm-offset-2">
                    <span class="glyphicon glyphicon-info-sign logo slideanim"></span>
                </div>
                <div class="col-sm-6 col-sm-offset-1">
                    <h2>About GestureNote</h2><br>
                    <h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</h4><br>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <!--<br><button class="btn btn-default btn-sm">Get in Touch</button>-->
                </div>
            </div>
        </div>


        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2 col-sm-offset-2">
                    <span class="glyphicon glyphicon-star logo slideanim"></span>
                </div>
                <div class="col-sm-6 col-sm-offset-1">
                    <h2>Our Values</h2><br>
                    <p><strong>MISSION:</strong> Our mission lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><br>
                    <p><strong>VISION:</strong> Our vision Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
            </div>
        </div>

        <!-- Container (Services Section) -->
        <div id="services" class="container-fluid text-center bg-grey">
            <h2>SERVICES</h2>
            <h4>What we offer</h4>
            <br>
            <div class="row slideanim">
                <div class="col-sm-2 col-sm-offset-3">
                    <span class="glyphicon glyphicon-off logo-small"></span>
                    <h4>POWER</h4>
                    <p>Lorem ipsum dolor sit amet..</p>
                </div>
                <div class="col-sm-2">
                    <span class="glyphicon glyphicon-heart logo-small"></span>
                    <h4>LOVE</h4>
                    <p>Lorem ipsum dolor sit amet..</p>
                </div>
                <div class="col-sm-2">
                    <span class="glyphicon glyphicon-lock logo-small"></span>
                    <h4>JOB DONE</h4>
                    <p>Lorem ipsum dolor sit amet..</p>
                </div>
            </div>
            <br><br>
            <div class="row slideanim">
                <div class="col-sm-2 col-sm-offset-3">
                    <span class="glyphicon glyphicon-leaf logo-small"></span>
                    <h4>GREEN</h4>
                    <p>Lorem ipsum dolor sit amet..</p>
                </div>
                <div class="col-sm-2">
                    <span class="glyphicon glyphicon-certificate logo-small"></span>
                    <h4>CERTIFIED</h4>
                    <p>Lorem ipsum dolor sit amet..</p>
                </div>
                <div class="col-sm-2">
                    <span class="glyphicon glyphicon-wrench logo-small"></span>
                    <h4 style="color:#303030;">HARD WORK</h4>
                    <p>Lorem ipsum dolor sit amet..</p>
                </div>
            </div>
        </div>


        <!-- Container (Contact Section) -->
        <div id="contact" class="container-fluid">
            <h2 class="text-center">CONTACT</h2>
            <div class="row">
                <div class="col-sm-5">
                    <p>Contact us and we'll get back to you within 24 hours.</p>
                    <p><span class="glyphicon glyphicon-map-marker"></span> Hochschule Fulda - University of Applied Sciences, 36037 Fulda, Germany</p>
                    <!--<p><span class="glyphicon glyphicon-phone"></span> +00 1515151515</p>-->
                    <p><span class="glyphicon glyphicon-envelope"></span> Daniel.Kuenkel@informatik.hs-fulda.de</p>	   
                </div>
                <div class="col-sm-7 slideanim">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
                        </div>
                    </div>
                    <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea><br>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <button class="btn btn-default btn-gn btn-sm btn-block" type="submit">Send</button>
                        </div>
                    </div>	
                </div>
            </div>
        </div>

        <div id="googleMap" style="height:400px;width:100%;"></div>

        <!-- Add Google Maps -->
        <script src="http://maps.googleapis.com/maps/api/js"></script>
        <script>
                            var myCenter = new google.maps.LatLng(50.564726, 9.685376);

                            function initialize() {
                                var mapProp = {
                                    center: myCenter,
                                    zoom: 15,
                                    scrollwheel: false,
                                    draggable: false,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                };

                                var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

                                var marker = new google.maps.Marker({
                                    position: myCenter,
                                });

                                marker.setMap(map);
                            }

                            google.maps.event.addDomListener(window, 'load', initialize);
        </script>

        <footer class="container-fluid text-center">
            <a href="#pageBody" title="To Top">
                <span class="glyphicon glyphicon-chevron-up"></span>
            </a>
            <p>test</p>		
        </footer>

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
            $(document).ready(function () {
                // Add smooth scrolling to all links in navbar + footer link
                $(".navbar a, footer a[href='#pageBody']").on('click', function (event) {

                    // Prevent default anchor click behavior
                    event.preventDefault();

                    // Store hash
                    var hash = this.hash;

                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (400) specifies the number of milliseconds it takes to scroll to the specified area
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 400, function () {

                        // Add hash (#) to URL when done scrolling (default click behavior)
                        window.location.hash = hash;
                    });
                });

                $(window).scroll(function () {
                    $(".slideanim").each(function () {
                        var pos = $(this).offset().top;

                        var winTop = $(window).scrollTop();
                        if (pos < winTop + 1000) {
                            $(this).addClass("slide");
                        }
                    });
                });
            });
        </script>

    </body>
</html>