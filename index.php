<?php
include_once './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

if (login_check($mysqli) == true) {
    if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'evaluator') {
        header('Location: dashboard.php');
    } else if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'tester') {
        header('Location: dashboard-tester.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $lang->gestureNote ?></title>
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

        <script type="text/JavaScript" src="js/storage.js"></script> 
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/login.js"></script>
        <script type="text/JavaScript" src="js/checkForms.js"></script>
        <script type="text/JavaScript" src="js/ajax.js"></script>
        <script type="text/JavaScript" src="js/constants.js"></script>
        <script type="text/JavaScript" src="js/goto-general.js"></script>
        <script type="text/JavaScript" src="js/goto-evaluator.js"></script>
        <script type="text/JavaScript" src="js/language.js"></script>
        <script type="text/JavaScript" src="js/externals.js"></script>
        <script type="text/JavaScript" src="js/alert.js"></script>
        <script type="text/JavaScript" src="js/globalFunctions.js"></script>
    </head>
    <body id="pageBody">

        <!-- externals -->
        <div id="alerts"></div>


        <div id="loading-indicator" class="window-sized-loading text-center">
            <i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw"></i>
        </div>



        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content root">
                </div>
            </div>
        </div>





        <div class="mainContent hidden">

            <div class="nav-wrapper" style="min-height: 366px">
                <div class="navbar-fixed-index-container" data-spy="affix" data-offset-top="266">
                    <div class="jumbotron text-center">
                        <div><h1><i class="glyphicon glyphicon-stats"></i> <?php echo $lang->gestureNote ?> <sup><span class="label label-success uppercase" style="position: relative; font-size: 8pt; top: -15px"><?php echo $lang->beta ?></span></sup></h1></div>
                        <p><?php echo $lang->gesturenoteSubline ?></p> 
                    </div>

                    <nav class="navbar-fixed-index" id="">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="" id="affix-logo" style="opacity: 0">
                                        <a class="navbar-brand" style="color: white !important"><i class="glyphicon glyphicon-stats"></i> <span style="letter-spacing: 0pt; margin-left: -5px"><?php echo $lang->gestureNote ?></span> <sup><span class="label label-success uppercase" style="position: relative; font-size: 6pt; letter-spacing: normal"><?php echo $lang->beta ?></span></sup></a>
                                    </div>

                                    <div class="pull-right" style="display: flex">
                                        <div id="btn-imprint" class="btn-imprint" data-id="btn-imprint" style="padding-right: 10px; cursor: pointer">
                                            <span style="position: relative; top: 17px; letter-spacing: normal; color: white; text-transform: uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $lang->breadcrump->imprint ?></span>
                                        </div>
                                        <div class="pull-right text-center" id="toggle-dark-mode" style="padding-right: 0px; cursor: pointer; font-size: 13pt; color: white; width: 22px">
                                            <i class="fa fa-moon-o" style="top: 13px; position: relative"></i>
                                        </div>
                                        <div class="dropdown pull-right language-selection" id="language-selection" style="padding-left: 10px;">
                                            <div class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="height: 49px">
                                                <img class="flag-small" src="" style="top: 16px; position: relative">
                                            </div>
                                            <ul class="dropdown-menu">
                                                <li><a href="#" id="de" style="margin-top: 1px"><img class="flag-small" src="img/flags/de.png"> <span><?php echo $lang->languages->de->language ?></span></a></li>
                                                <li><a href="#" id="en"><img class="flag-small" src="img/flags/en.png"> <span><?php echo $lang->languages->en->language ?></span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </nav>
                    <div class="line"></div>
                </div>
            </div>
            <!-- Container (Login Section) -->
            <div id="login" class="container" style="padding-bottom: 60px; padding-top: 0px">
                <div class="row">

                    <div class="col-sm-6 col-sm-push-6 col-md-6" style="margin-top: 40px;">
                        <div class="panel panel-default panel-shadow">
                            <div class="panel-heading">
                                <h2 class="panel-title"><?php echo $lang->signInOrRegister ?></h2>
                            </div>
                            <div class="panel-body">

                                <div id="login-form">
                                    <div class="alert-space alert-general-error"></div>
                                    <div class="alert-space alert-missing-fields"></div>
                                    <div class="alert-space alert-missing-email"></div>
                                    <div class="alert-space alert-check-email"></div>
                                    <div class="alert-space alert-invalid-email"></div>
                                    <div class="alert-space alert-account-logged"></div>
                                    <div class="alert-space alert-wrong-password"></div>
                                    <div class="alert-space alert-no-user-exists"></div>
                                    <div class="alert-space alert-password-reset-send"></div>

                                    <div class="form-group">
                                        <label for="email"><?php echo $lang->email ?></label>
                                        <input type="text" class="form-control" name="email" value="" id="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="password"><?php echo $lang->password ?></label>
                                        <input type="password" class="form-control" name="password" value="" id="password">
                                    </div>
                                    <div class="btn-group-vertical btn-block">
                                        <button type="button" class="btn btn-success btn-shadow" id="btn-login"><i class="fa fa-unlock-alt"></i> <span class="btn-text"><?php echo $lang->signIn ?></button>
                                        <button type="button" class="btn btn-default btn-shadow" id="btn-forgot-password"><i class="fa fa-question"></i> <span class="btn-text"><?php echo $lang->forgotPassword ?></button>
                                        <button type="button" class="btn btn-default btn-shadow" id="btn-open-register"><i class="fa fa-user-plus" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->register ?></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Container (About Section) -->
                    <div class="col-sm-6 col-sm-pull-6 col-md-6" id="about">
                        <div class="info">
                            <div class="page-header">
                                <h2 class="uppercase"><?php echo $lang->whatIsGesturenote ?></h2>
                            </div>
                            <div class="info-text text">
                                <p><?php echo $lang->whatIsGesturenote2 ?></p>
                                <p><?php echo $lang->whatIsGesturenote3 ?></p>
                                <button class="btn btn-default btn-shadow btn-more-infos"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->moreInfos ?></span></button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


            <!-- Container (Services Section) -->
            <div id="services" class="container-fluid text-center bg-grey">
                <div class="container">
                    <h2 class="uppercase"><?php echo $lang->whatOffersGesturenote ?></h2>
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            <i class="fa fa-users logo-small" style="font-size: 50px"></i>
                            <h4 class="uppercase"><?php echo $lang->whatOffersGesturenote2headline ?></h4>
                            <p><?php echo $lang->whatOffersGesturenote2text ?></p>
                        </div>
                        <div class="col-sm-4">
                            <i class="fa fa-sign-language logo-small" style="font-size: 50px"></i>
                            <h4 class="uppercase"><?php echo $lang->whatOffersGesturenote3headline ?></h4>
                            <p><?php echo $lang->whatOffersGesturenote3text ?></p>
                        </div>
                        <div class="col-sm-4">
                            <i class="fa fa-pencil logo-small" style="font-size: 50px"></i>
                            <h4 class="uppercase"><?php echo $lang->whatOffersGesturenote4headline ?></h4>
                            <p><?php echo $lang->whatOffersGesturenote4text ?></p>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-sm-4">
                            <i class="fa fa-bar-chart logo-small" style="font-size: 50px"></i>
                            <h4 class="uppercase"><?php echo $lang->whatOffersGesturenote5headline ?></h4>
                            <p><?php echo $lang->whatOffersGesturenote5text ?></p>
                        </div>
                        <div class="col-sm-4">
                            <i class="fa fa-map-signs logo-small" style="font-size: 50px"></i>
                            <h4 class="uppercase"><?php echo $lang->whatOffersGesturenote6headline ?></h4>
                            <p><?php echo $lang->whatOffersGesturenote6text ?></p>
                        </div>
                        <div class="col-sm-4">
                            <i class="fa fa-code logo-small" style="font-size: 50px"></i>
                            <h4 class="uppercase"><?php echo $lang->whatOffersGesturenote7headline ?></h4>
                            <p><?php echo $lang->whatOffersGesturenote7text ?></p>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-sm-4 col-sm-offset-4">
                            <i class="fa fa-lock logo-small" style="font-size: 50px"></i>
                            <h4 class="uppercase"><?php echo $lang->whatOffersGesturenote8headline ?></h4>
                            <p>
                                <a href="https://www.positivessl.com" style="font-family: arial; font-size: 10px; color: #212121; text-decoration: none;"><img src="img/PositiveSSL_tl_trans.png" alt="SSL Certificate" title="SSL Certificate" border="0" /></a>
                            </p>
                        </div>
                    </div>
                    <br/><br/>
                    <div class="row">
                        <button class="btn btn-default btn-shadow btn-more-infos"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->moreInfos ?></span></button>
                    </div>
                </div>
            </div>


            <!-- Container (News Section) -->
            <div id="news" class="container-fluid">
                <div class="container">
                    <h2 class="uppercase"><?php echo $lang->news ?></h2>
                    <br>
                    <div id="news-list"></div>
                    <br/><br/>
                    <div class="text-center">
                        <button class="btn btn-default btn-shadow" id="btn-more-news"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->moreNews ?></span></button>
                    </div>
                </div>
            </div>


            <!-- Container (Contact Section) -->
            <div id="contact" class="container-fluid bg-grey">
                <div class="container">
                    <h2 class="uppercase"><?php echo $lang->contact ?></h2>
                    <div class="row">
                        <div class="col-sm-5">
                            <p><?php echo $lang->contactText ?></p>
                            <div class="row">
                                <div class="col-xs-1">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="col-xs-11">
                                    <p><?php echo $lang->contactAdress1 ?><br>
                                        <?php echo $lang->contactAdress2 ?></p>
                                </div>
                                <div class="col-xs-1">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="col-xs-11">
                                    <p> <a href="mailto:admin@gesturenote.de">admin@gesturenote.de</a></p>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-7" id="contact-form">
                            <div class="alert-space alert-contact-success"></div>
                            <div class="alert-space alert-general-error"></div>
                            <div class="alert-space alert-missing-fields"></div>
                            <div class="alert-space alert-invalid-email"></div>
                            <div class="alert-space alert-missing-email"></div>

                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <input class="form-control" id="name" name="name" placeholder="<?php echo $lang->name ?>" type="text" required>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <input class="form-control" id="email" name="email" placeholder="<?php echo $lang->email ?>" type="email" required>
                                </div>
                            </div>
                            <textarea class="form-control" id="comment" name="comments" placeholder="<?php echo $lang->whatDoYouWantToTellUs ?>" rows="5"></textarea><br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-default pull-right btn-shadow" id="btn-contact-us"><i class="fa fa-send" aria-hidden="true"></i> <?php echo $lang->send ?></button>
                                </div>
                            </div>	
                        </div>
                    </div>
                </div>
            </div>

            <div id="googleMap" style="height:600px; width:100vw;"></div>

            <!-- Google Maps -->
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzo6c0KN02aScKccnj-Cs7JD00gcLYkZA"></script>
            <script>
                var myCenter = new google.maps.LatLng(50.564726, 9.685376);

                function initialize() {
                    setTimeout(function () {
                        var mapProp = {
                            center: myCenter,
                            zoom: 15,
                            scrollwheel: false,
//                            draggable: false,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        };

                        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

                        var marker = new google.maps.Marker({
                            position: myCenter
                        });

                        marker.setMap(map);
                    }, 1000);

                }

                google.maps.event.addDomListener(window, 'load', initialize);
            </script>

            <footer class="container-fluid text-center">
                <a href="#pageBody" title="To Top">
                    <div class="fa fa-chevron-up" id="btn-to-top"></div>
                </a>	
            </footer>

            <div class="text-center">
                <i class="fa fa-copyright"></i> <?php echo $lang->copyrightName ?>
            </div>

        </div>


        <script>
            $(document).ready(function () {
                checkDomain();
                checkCookies(parseInt('<?php echo checkCookiesAccepted(); ?>'));

                checkLanguage(function () {
                    updateLanguageIndicator($('#language-selection'));
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                checkDarkMode(parseInt('<?php echo checkDarkMode(); ?>'));
                $('.mainContent').removeClass('hidden');
                TweenMax.to($('#loading-indicator'), .4, {opacity: 0, onComplete: function () {
                        $('#loading-indicator').remove();
                    }});
                TweenMax.from($('.mainContent'), .3, {delay: .3, opacity: 0});

                $('#login-form #password, #login-form #email').keypress(function (event) {
                    if (event.keyCode === 13) {
                        $('#login-form #btn-login').click();
                    }
                });

                $('#login-form').on('loginSuccess', function (event, result) {
                    gotoDashboard();
                });

                $('#register-form').on('registerSuccess', function (event, result) {
                    gotoDashboard();
                });

                var allNews = translation.allNews;
                for (var i = 0; i < Math.min(allNews.length, 2); i++) {
                    var newsItem = document.createElement('div');
                    $(newsItem).addClass('row');
                    $('#news-list').append(newsItem);

                    var col = document.createElement('div');
                    $(col).addClass('col-xs-12 col-sm-2 col-lg-1');
                    $(newsItem).append(col);

                    var date = new Date(allNews[i].date);
                    var newsDate = document.createElement('span');
                    $(newsDate).text(date.toLocaleDateString());
                    $(col).append(newsDate);

                    var col = document.createElement('div');
                    $(col).addClass('col-xs-12 col-sm-10 col-lg-11');
                    $(newsItem).append(col);

                    var newsTitle = document.createElement('span');
                    $(newsTitle).text(allNews[i].title);
                    $(newsTitle).addClass('text font-bold');
                    $(col).append(newsTitle);

                    var newsContent = document.createElement('div');
                    $(newsContent).html(allNews[i].content);
                    $(newsContent).addClass('text');
                    $(col).append(newsContent);

                    if (i > 0) {
                        $(newsItem).css({marginTop: '40px'});
                    }
                }

                initPopover();
            }

            $('#btn-open-register').on('click', function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'externals/modal-register.php', 'modal-md');
            });

            $('#contact-form').find('#btn-contact-us').on('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    lockButton($(this), true, 'fa-send');
                    clearAlerts($('#contact-form'));

                    // validate name
                    var nameInput = $('#contact-form').find('#name');
                    if ($(nameInput).val().trim() === '') {
                        $(nameInput).focus();
                        appendAlert($('#contact-form'), ALERT_MISSING_FIELDS);
                        resetContactFormInput();
                        return false;
                    }

                    // validate email
                    var emailInput = $('#contact-form').find('#email');
                    if ($(emailInput).val().trim() === '') {
                        appendAlert($('#contact-form'), ALERT_MISSING_EMAIL);
                        $(emailInput).focus();
                        resetContactFormInput();
                        return false;
                    }

                    if (!validateEmail($(emailInput).val().trim())) {
                        $(emailInput).focus();
                        appendAlert($('#contact-form'), ALERT_INVALID_EMAIL);
                        resetContactFormInput();
                        return false;
                    }

                    // validate comment
                    var commentInput = $('#contact-form').find('#comment');
                    if ($(commentInput).val().trim() === '') {
                        $(commentInput).focus();
                        appendAlert($('#contact-form'), ALERT_MISSING_FIELDS);
                        resetContactFormInput();
                        return false;
                    }

                    var name = nameInput.val();
                    var email = emailInput.val();
                    var comment = commentInput.val();
                    requestContact({name: name, email: email, comment: comment}, function (result) {
                        resetContactFormInput();
                        if (result.status === RESULT_SUCCESS) {
                            $(nameInput).val('');
                            $(emailInput).val('');
                            $(commentInput).val('');
                            appendAlert($('#contact-form'), ALERT_CONTACT_SUCCESS);

                            setTimeout(function () {
                                clearAlerts($('#contact-form'));
                            }, 7000);
                        } else {
                            appendAlert($('#contact-form'), ALERT_GENERAL_ERROR);
                        }
                    });
                }
            });

            $('#btn-to-top').on('click', function () {
                $("html, body").animate({scrollTop: 0}, 200);
            });

            $('.btn-more-infos').on('click', function () {
                goto('informations.php');
            });

            $('#btn-more-news').on('click', function () {
                goto('news.php');
            });

            function resetContactFormInput() {
                unlockButton($('#contact-form').find('#btn-contact-us'), true, 'fa-send');
            }

            $(window).on('scroll', function () {
                if ($('.navbar-fixed-index-container').hasClass('affix')) {
                    TweenMax.to($('#affix-logo'), .2, {opacity: 1});
                } else {
                    TweenMax.to($('#affix-logo'), .2, {opacity: 0});
                }
            });
        </script>

    </body>
</html>