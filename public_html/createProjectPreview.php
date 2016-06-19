<?php
include './includes/language.php';
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
        <link rel="stylesheet" href="css/createProjectPreview.css">
        <link rel="stylesheet" href="css/gesture.css">
        <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.4.4/randomColor.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>
        <script src="http://chancejs.com/chance.min.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/localforage.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/language.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/gotoPage.js"></script>       
        <script src="js/gesture.js"></script>
        <script src="js/thumbscrubber.js"></script>
        <script src="js/createProjectPreview.js"></script>

    </head>
    <body>

        <div id="alerts"></div>
        <div id="template-gesture"></div>
        <div id="template-forms"></div>
        <div id="template-previews"></div>

        <div class="navbar-fixed-top" id="preview-bar-top" style="padding: 10px;">

            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default" id="btnViewModerator">Moderator</button>
                    <button type="button" class="btn btn-default" id="btnViewTester">Tester</button>
                </div>
                <input class="form-control item-input-text option-phase-steps show-dropdown text-center readonly" type="text" value=""/>
                <div class="input-group-btn phaseStepsSelect select" role="group">
                    <button class="btn btn-default btn-dropdown dropdown-toggle" id="btn-phaseStepSelect" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                    <ul class="dropdown-menu option" role="menu">
                    </ul>
                    <button type="button" class="btn btn-danger" onclick="gotoCreateProject()"><i class="glyphicon glyphicon-remove"></i> <?php echo $lang->close ?></button>
                </div>
            </div>
        </div>

        <!-- progress bar -->
        <div id="progressTop">
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 0%">
                    0%
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">

                </div>
            </div>
        </div>

        <!-- affixed pager-->
        <nav id="pager-top">
            <ul class="pager">
                <li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> <?php echo $lang->previous ?></a></li>
                <li class="next disabled"><a href="#"><?php echo $lang->next ?> <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>

        <!-- main content -->
        <div class="mainContent" id="mainContent" style="padding-top: 145px; padding-left: 20px; padding-right: 20px;">

            <div class="alert-space alert-no-phase-data"></div>

            <div id="viewTester" class="hidden container">
                <div id="phase-content"></div>
            </div>

            <div id="viewModerator" class="hidden">
                <div id="web-rtc-placeholder" class="web-rtc-placeholder" style="position: fixed">
                    <img src="img/web-rtc-placeholder.jpg" width="100%" height="auto"/>
                </div>

                <div id="phase-content"></div>

                <!--                <div class="row">
                                    <div class="col-md-6 col-lg-4" id="column-left" style="margin-bottom: 20px;">
                
                
                                        <div class="phase-content-left">
                
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-8 phase-content-right" id="column-right">
                
                                    </div>
                                </div>-->
            </div>

        </div>

        <script src="js/template-forms.js"></script>
        <script>
                        var currentView;

                        $(document).ready(function () {
                            checkLanguage();

                            var externals = new Array();
                            var path = PATH_EXTERNALS + '/' + currentLanguage + '/';
                            externals.push(['#alerts', path + 'alerts.html']);
                            externals.push(['#template-gesture', path + 'template-gesture.html']);
                            externals.push(['#template-forms', path + 'template-inputs.html']);
                            externals.push(['#template-previews', path + 'template-previews.html']);
                            loadExternals(externals);
                        });

                        $(window).on('resize', function () {
                            var contentLeftWidth = $('#phase-content #column-left').width();
                            TweenMax.to($('#web-rtc-placeholder'), .2, {width: contentLeftWidth, onUpdate: onResizeUpdate});
                        });

                        function onResizeUpdate() {
                            $('#phase-content #column-left').css('margin-top', $('#web-rtc-placeholder').height() + 20);
                        }

                        function onAllExternalsLoadedSuccessfully() {
                            if (typeof (Storage) !== "undefined") {
                                checkStorage();
                            } else {
                                console.log("Sorry, your browser do not support Web Session Storage.");
                            }
                        }


                        $('.previous').on('click', function (event) {
                            event.preventDefault();
                            if (!$(this).hasClass('disabled')) {
                                previousStep();
                            }
                        });

                        $('.next').on('click', function (event) {
                            event.preventDefault();
                            if (!$(this).hasClass('disabled')) {
                                nextStep();
                            }
                        });

                        $('body').on('click', '.phaseStepsSelect .option li', function (event) {
                            setTimeout(function () {
                                updateProgress();
                                renderPhaseStep();
                                updatePager();
                            }, 50);
                        });

                        $('#btnViewModerator').on('click', function (event) {
                            event.preventDefault();
                            if (!$(this).hasClass('btn-gn') && !$(this).hasClass('disabled')) {
                                showModeratorView();
                                renderPhaseStepForModerator();
                            }
                        });

                        $('#btnViewTester').on('click', function (event) {
                            event.preventDefault();
                            if (!$(this).hasClass('btn-gn')) {
                                showTesterView();
                                renderPhaseStepForTester();
                            }
                        });

                        function showModeratorView() {
                            currentView = VIEW_MODERATOR;
                            $('#btnViewModerator').addClass('btn-gn');
                            $('#btnViewTester').removeClass('btn-gn');
                            $('#viewTester').addClass('hidden');
                            $('#viewModerator').removeClass('hidden');
                        }

                        function showTesterView() {
                            currentView = VIEW_TESTER;
                            $('#btnViewTester').addClass('btn-gn');
                            $('#btnViewModerator').removeClass('btn-gn');
                            $('#viewTester').removeClass('hidden');
                            $('#viewModerator').addClass('hidden');
                        }

                        function renderPhaseStep() {
                            removeAlert($('#mainContent'), ALERT_NO_PHASE_DATA);

                            if (currentView === VIEW_TESTER) {
                                renderPhaseStepForTester();
                            } else {
                                renderPhaseStepForModerator();
                            }
                        }

                        function resetRenderedContent() {
                            $('.phase-content-left').empty();
                            $('.phase-content-right').empty();
                        }

                        function renderPhaseStepForTester() {
                            resetRenderedContent();
                            var currentStepId = $('#btn-phaseStepSelect .chosen').attr('id');
                            var data = getLocalItem(currentStepId + ".data");

                            console.log(data);
                            if (data || (data && $.isArray(data) && data.length > 0)) {
                                renderTesterView();
                            } else {
                                appendAlert($('#mainContent'), ALERT_NO_PHASE_DATA);
                            }
                        }

                        function renderPhaseStepForModerator() {
                            resetRenderedContent();
                            var currentStepId = $('#btn-phaseStepSelect .chosen').attr('id');
                            var data = getLocalItem(currentStepId + ".data");
                            if (data || (data && $.isArray(data) && data.length > 0)) {
                                renderModeratorView();
                            } else {
                                appendAlert($('#mainContent'), ALERT_NO_PHASE_DATA);
                            }
                        }

        </script>
    </body>
</html>