<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

session_start();
if (login_check($mysqli) == true) {
    if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'evaluator') {
        header('Location: dashboard-evaluator.php');
    } else if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'tester') {
        header('Location: dashboard-tester.php');
    }
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
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/login.js"></script>
        <script type="text/JavaScript" src="js/register.js"></script>
        <script type="text/JavaScript" src="js/checkForms.js"></script>
        <script type="text/JavaScript" src="js/ajax.js"></script>
        <script type="text/JavaScript" src="js/constants.js"></script>
        <script type="text/JavaScript" src="js/goto-general.js"></script>
        <script type="text/JavaScript" src="js/language.js"></script>
        <script type="text/JavaScript" src="js/externals.js"></script>
        <script type="text/JavaScript" src="js/alert.js"></script>
        <script type="text/JavaScript" src="js/globalFunctions.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>

        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <!--                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>   
                                    </button>
                                    <a class="navbar-brand" href="#pageBody"><span class="glyphicon glyphicon-stats"></span> GestureNote</a>
                                </div>-->
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#about"><span class="btn-text uppercase"><?php echo $lang->about ?></span></a></li>
                        <li><a href="#services"><span class="btn-text uppercase"><?php echo $lang->services ?></span></a></li>
                        <li><a href="#contact"><span class="btn-text uppercase"><?php echo $lang->contact ?></span></a></li>
                        <li><a href="#login"><span class="glyphicon glyphicon-log-in"></span> <span class="btn-text uppercase"><?php echo $lang->signIn ?></span></a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="jumbotron text-center">
            <div><h1><i class="glyphicon glyphicon-stats"></i> <?php echo $lang->gesturenote ?> <sup><span class="label label-success uppercase" style="position: relative; font-size: 8pt; top: -15px"><?php echo $lang->alpha ?></span></sup></h1></div>
            <p><?php echo $lang->gesturenoteSubline ?></p> 
        </div>
        <div class="line text-center" data-spy="affix" data-offset-top="376"></div>


        <!-- register modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-register">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><?php echo $lang->createAccount ?></h4>
                    </div>
                    <div class="modal-body">

                        <div id="register-form">
                            <div class="alert-space alert-general-error"></div>
                            <div class="alert-space alert-missing-fields"></div>
                            <div class="alert-space alert-register-success"></div>

                            <div class="form-group">
                                <label for="forename"><?php echo $lang->forename ?></label>
                                <input type="text" class="form-control" name="forename" id="forename" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="surname"><?php echo $lang->surname ?></label>
                                <input type="text" class="form-control" name="surname" id="surname" placeholder="">
                            </div>

                            <div class="alert-space alert-user-exists"></div>
                            <div class="alert-space alert-invalid-email"></div>

                            <div class="form-group">
                                <label for="email"><?php echo $lang->email ?></label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="">
                            </div>

                            <div class="alert-space alert-password-short"></div>
                            <div class="alert-space alert-password-invalid"></div>
                            <div class="alert-space alert-passwords-not-matching"></div>

                            <div class="form-group">
                                <label for="password"><?php echo $lang->password ?></label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword"><?php echo $lang->passwordConfirm ?></label>
                                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="">
                            </div>

                            <div class="alert-space alert-invalid-birthday"></div>

                            <div class="form-group">
                                <label><?php echo $lang->birthdate ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo $lang->day ?></span>
                                    <input class="form-control" id="date" type="text" placeholder="z.B. 1" minlength="1" maxlength="2"/>
                                    <span class="input-group-addon"><?php echo $lang->month ?></span>
                                    <input class="form-control" id="month" type="text" placeholder="z.B. 12" minlength="1" maxlength="2"/>
                                    <span class="input-group-addon"><?php echo $lang->year ?></span>
                                    <input class="form-control" id="year" type="text" placeholder="z.B. 1980" minlength="4" maxlength="4"/>
                                </div>
                            </div>

                            <div class="form-group root" id="gender">
                                <label><?php echo $lang->gender ?></label><br>

                                <div class="btn-group" id="radio">
                                    <button class="btn btn-default btn-radio" name="primary" id="female">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->gendersRegister->female ?></span>
                                    </button>
                                </div>

                                <div class="btn-group" id="radio">
                                    <button class="btn btn-default btn-radio" name="primary" id="male">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->gendersRegister->male ?></span>
                                    </button>
                                </div>

                            </div>

                            <div class="form-group root" id="userType">
                                <label><?php echo $lang->userType ?></label><br>

                                <div class="btn-group" id="radio">
                                    <button class="btn btn-default btn-radio" name="primary" id="tester">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->userTypesRegister->tester ?></span>
                                    </button>
                                </div>

                                <div class="btn-group" id="radio">
                                    <button class="btn btn-default btn-radio" name="primary" id="evaluator">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->userTypesRegister->evaluator ?></span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-block btn-success hidden" id="btn-close"><span class="btn-text"><?php echo $lang->close ?></span></button>
                        <button type="button" class="btn btn-block btn-gn" id="btn-register"><i class="fa fa-user-plus" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->register ?></span></button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Container (Login Section) -->
        <div id="login" class="container" style="padding-bottom: 60px; padding-top: 50px">
            <div class="row">

                <div class="col-sm-6 col-sm-push-6 col-md-6" style="margin-top: 40px;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title"><?php echo $lang->signInOrRegister ?></h2>
                        </div>
                        <div class="panel-body">

                            <div id="login-form">
                                <div class="alert-space alert-general-error"></div>
                                <div class="alert-space alert-missing-fields"></div>
                                <div class="alert-space alert-account-logged"></div>
                                <div class="alert-space alert-wrong-password"></div>
                                <div class="alert-space alert-no-user-exists"></div>

                                <div class="form-group">
                                    <label for="email"><?php echo $lang->email ?></label>
                                    <input type="text" class="form-control" name="email" value="" id="email">
                                </div>
                                <div class="form-group">
                                    <label for="password"><?php echo $lang->password ?></label>
                                    <input type="password" class="form-control" name="password" value="" id="password">
                                </div>
                                <div class="btn-group-vertical btn-block">
                                    <button type="button" class="btn btn-success" id="btn-login"><i class="glyphicon glyphicon-log-in"></i> <span class="btn-text"><?php echo $lang->signIn ?></button>
                                    <button type="button" class="btn btn-primary disabled" id="btn-forgot"><i class="glyphicon glyphicon-time"></i> <span class="btn-text"><?php echo $lang->forgotPassword ?></button>
                                    <button type="button" class="btn btn-gn" id="btn-open-register"><i class="fa fa-user-plus" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->register ?></span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Container (About Section) -->
                <div class="col-sm-6 col-sm-pull-6 col-md-6" id="about">
                    <div class="info">
                        <div class="page-header">
                            <h2>WAS IST GESTURENOTE?</h2>
                        </div>
                        <div class="info-text">
                            <p>Die Vision von GestureNote ist, unterschiedliche und typisch verwendete Vorgehensweisen, Ansätze und Methoden in einem einzigen Tool zu vereinen.</p>
                            <p><strong>Weg von ortsgebundenen Gesten-Ermittlungen und -Evaluierungen, hin zu schnellen und einfachen Remote-Gesten-Design-Studien. Die Einbettung in den Usability-Engineering-Lifecycle ist für GestureNote kein Problem.</strong></p>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        <!-- Container (Services Section) -->
        <div id="services" class="container-fluid text-center bg-grey">
            <div class="container">
                <h2>WAS BIETET GESTURENOTE?</h2>
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <i class="fa fa-users logo-small" style="font-size: 50px"></i>
                        <h4>REMOTE USABILITY-TESTS</h4>
                        <p>Befragen Sie einfach und umkompliziert ihre Zielgruppe - Weltweit!</p>
                    </div>
                    <div class="col-sm-4">
                        <i class="fa fa-sign-language logo-small" style="font-size: 50px"></i>
                        <h4>DESIGN VON GESTEN</h4>
                        <p>Die Designphasen <em>Ermittlung</em>, <em>Extraktion</em> und <em>Evaluierung</em> werden unterstützt.</p>
                    </div>
                    <div class="col-sm-4">
                        <i class="fa fa-pencil logo-small" style="font-size: 50px"></i>
                        <h4>EINFACHE STUDIEN-ERSTELLUNG</h4>
                        <p>Schnelle und einfache Erstellung von Leitfäden.</p>
                    </div>
                </div>
                <div class="row" style="margin-top: 30px;">
                    <div class="col-sm-4">
                        <i class="fa fa-archive logo-small" style="font-size: 50px"></i>

                        <h4>MESSINSTRUMENTE</h4>
                        <p>Gesture Usability Scales, Beobachtungsleitfäden, etc. Speziell entwickelt für Gesteninteraktionen.</p>
                    </div>
                    <div class="col-sm-4">
                        <i class="fa fa-map-signs logo-small" style="font-size: 50px"></i>
                        <h4>STYLEGUIDES</h4>
                        <p>Sie wissen nicht weiter? GestureNote bietet Styleguides für gebrauchstaugliche Gesten an.</p>
                    </div>
                    <div class="col-sm-4">
                        <i class="fa fa-wrench logo-small" style="font-size: 50px"></i>
                        <h4>AKTUELLE TECHNOLOGIEN</h4>
                        <p>Einsatz von AJAX, WebRTC, sowie aktuellen Frameworks und APIs.</p>
                    </div>
                </div>
                <div class="row" style="margin-top: 30px;">
                    <div class="col-sm-4 col-sm-offset-4">
                        <i class="fa fa-lock logo-small" style="font-size: 50px"></i>
                        <h4>SSL VERSCHLÜSSELUNG</h4>
                        <p>
                            <a href="https://www.positivessl.com" style="font-family: arial; font-size: 10px; color: #212121; text-decoration: none;"><img src="https://www.positivessl.com/images-new/PositiveSSL_tl_trans.png" alt="SSL Certificate" title="SSL Certificate" border="0" /></a>
                        </p>
                    </div>

                </div>
                <br/><br/>
                <div class="row">
                    <button class="btn btn-gn"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="btn-text">Hier mehr erfahren</span></button>
                </div>
            </div>
        </div>


        <!-- Container (Contact Section) -->
        <div id="contact" class="container-fluid">
            <div class="container">
                <h2>KONTAKT</h2>
                <div class="row">
                    <div class="col-sm-5">
                        <p>Lob, Kritik, Ideen oder Visionen. Kontaktieren Sie uns einfach, denn Ihre Meinung ist uns wichtig! Wir freuen uns auf Sie.</p>
                        <div class="row">
                            <div class="col-xs-1">
                                <i class="glyphicon glyphicon-map-marker"></i>
                            </div>
                            <div class="col-xs-11">
                                <p> Hochschule Fulda - University of Applied Sciences<br>
                                    Leipziger Straße 123, 36037 Fulda, Germany</p>
                            </div>
                            <div class="col-xs-1">
                                <i class="glyphicon glyphicon-envelope"></i>
                            </div>
                            <div class="col-xs-11">
                                <p> <a href="mailto:danielkuenkel@gesturenote.de">danielkuenkel@gesturenote.de</a></p>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-7">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <input class="form-control" id="email" name="email" placeholder="E-Mail-Adresse" type="email" required>
                            </div>
                        </div>
                        <textarea class="form-control" id="comments" name="comments" placeholder="Was möchten Sie uns mitteilen?" rows="5"></textarea><br>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-gn pull-right disabled" id="btn-send-feedback"><i class="fa fa-paper-plane" aria-hidden="true"></i> Senden</button>
                            </div>
                        </div>	
                    </div>
                </div>
            </div>
        </div>

        <div id="googleMap" style="height:400px;width:100%;"></div>

        <!-- Google Maps -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzo6c0KN02aScKccnj-Cs7JD00gcLYkZA"></script>
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
            <p><a href="#pageBody">nach oben</a></p>		
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
                            <li role="presentation"><a href="imprint.php" class="no-scrolling">IMPRESSUM</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>


        <script>
            $(document).ready(function () {
                checkDomain();
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                // Add smooth scrolling to all links in navbar + footer link
                $(".navbar a, footer a[href='#pageBody']").on('click', function (event) {
                    if (!$(this).hasClass('no-scrolling')) {
                        event.preventDefault();

                        // Store hash
                        var hash = this.hash;

                        // Using jQuery's animate() method to add smooth page scroll
                        // The optional number (400) specifies the number of milliseconds it takes to scroll to the specified area
                        $('html, body').animate({
                            scrollTop: $(hash).offset().top - 50
                        }, 400, function () {

                            // Add hash (#) to URL when done scrolling (default click behavior)
                            window.location.hash = hash;
                        });
                    }
                });

                $('#login-form #password, #login-form #email').keypress(function (event) {
                    if (event.keyCode === 13) {
                        console.log('enter pressed');
                        $('#login-form #btn-login').click();
                    }
                });

                $('#login-form').on('loginSuccess', function (event, result) {
                    if (result.userType === 'evaluator') {
                        goto('dashboard-evaluator.php');
                    } else if (result.userType === 'tester') {
                        goto('dashboard-tester.php');
                    }
                });

                $('#register-form').on('registerSuccess', function (event, result) {
                    if (result.userType === 'evaluator') {
                        goto('dashboard-evaluator.php');
                    } else if (result.userType === 'tester') {
                        goto('dashboard-tester.php');
                    }
                });
            }
        </script>

    </body>
</html>