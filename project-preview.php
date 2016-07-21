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
        <link rel="stylesheet" href="css/custom-controls.css">
        <link rel="stylesheet" href="externals/font-awesome/css/font-awesome.min.css">
        <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.4.4/randomColor.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>
        <script src="http://chancejs.com/chance.min.js"></script>
        <script src="color-thief/color-thief.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/language.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/gotoPage.js"></script>       
        <script src="js/gesture.js"></script>
        <script src="js/thumbscrubber.js"></script>
        <script src="js/project-preview.js"></script>
        <script src="js/renderForms.js"></script>
        <script src="js/moderator.js"></script>
        <script src="js/tester.js"></script>

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

        <!-- modals -->
        <div id="custom-modal" class="modal fade custom-modal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">

                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="help-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Hilfe</h4>
                    </div>
                    <div class="modal-body">
                        <p id="help-text" style="color: #303030"></p>
                        <div class="imageContainer autoplay hidden"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-lg btn-info btn-block" data-dismiss="modal"><span class="text">Okay</span></button>
                    </div>
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

        <div id="draggableRTC" class="hidden" style="position: fixed; z-index: 99; top: 150px; left:100px; display: block">
            <img src="img/resize.png" id="resize-sign" style="position: absolute; bottom: 0; right: 0;"/>
        </div>

        <!-- main content -->
        <div class="mainContent" id="mainContent" style="padding-top: 145px;">

            <!--<div class="alert-space alert-no-phase-data"></div>-->

            <div id="viewTester" class="hidden">
                <div id="phase-content"></div>
            </div>

            <div id="viewModerator" class="hidden" style="padding-left: 20px; padding-right: 20px;">
                <div id="pinnedRTC" style="position: fixed">
                    <div id="web-rtc-placeholder" class="web-rtc-placeholder" style="width: 100%">
                        <img src="img/web-rtc-placeholder.jpg" width="100%" height="auto"/>
                        <div id="rtc-controls" class="btn-group" style="position: absolute; top: 0; left: 0;">
                            <button type="button" id="btn-toggle-rtc-fixed" class="btn btn-link btn-no-shadow"><i class="glyphicon glyphicon-new-window"></i></button>
                        </div>
                    </div>
                </div>

                <div id="phase-content"></div>
            </div>
        </div>

        <script src="js/template-forms.js"></script>
        <script>
                        var currentView;
                        $(document).ready(function () {
                            checkLanguage(function () {
                                var externals = new Array();
                                var path = PATH_EXTERNALS + '/' + currentLanguage + '/';
                                externals.push(['#alerts', path + 'alerts.html']);
                                externals.push(['#template-gesture', path + 'template-gesture.html']);
                                externals.push(['#template-previews', path + 'template-previews.html']);
                                loadExternals(externals);
                            });
                        });

//                        var lastScrollTop;
                        $(window).on('resize', function () {
//                            console.log('resize: ' + $(document).scrollTop());
                            if (!$('#pinnedRTC').hasClass('hidden') && (!$('#phase-content #column-left').hasClass('rtc-scalable') || ($(document).scrollTop() === 0))) {
                                updateRTCHeight($('#phase-content #column-left').width());
                            }
//                            else if ($(document).scrollTop() > 0) {
//                                $(document).scrollTop(0);
//                                updateRTCHeight($('#phase-content #column-left').width());
//                            }
//                            lastScrollTop = $(document).scrollTop();
                        });

                        function updateRTCHeight(newWidth) {
                            TweenMax.to($('#web-rtc-placeholder'), .1, {width: newWidth, onComplete: onResizeComplete});
                        }

                        function onResizeComplete() {
                            var ratio = $('#web-rtc-placeholder').width() / $('#web-rtc-placeholder').height();
                            $('#web-rtc-placeholder').attr('ratio', ratio);
                            TweenMax.to($('#phase-content #column-left'), .2, {css: {marginTop: $('#web-rtc-placeholder').height() + 20, opacity: 1.0}});
                        }

                        var resetRTCTimeout;
                        $(window).scroll(function () {
                            if ($('#phase-content #column-left').hasClass('rtc-scalable') && !$('#pinnedRTC').hasClass('hidden')) {
                                if ($(document).scrollTop() <= 0 && ($('#phase-content #column-left').width() !== $('#web-rtc-placeholder').width() || $('#web-rtc-placeholder').height() !== $('#phase-content #column-left').offset().top - 20)) {
                                    resetRTCTimeout = setTimeout(resetRTC(), 100);
                                    return false;
                                } else {
                                    clearTimeout(resetRTCTimeout);
                                }

                                var ratio = $('#web-rtc-placeholder').attr('ratio');
                                var newHeight = Math.min($('#phase-content #column-left').offset().top - 20 - parseInt($('#mainContent').css('padding-top')), Math.max($('#phase-content #column-left').offset().top - $(document).scrollTop() - 20 - parseInt($('#mainContent').css('padding-top')), 170));
                                $('#web-rtc-placeholder').width(Math.min(newHeight * ratio, $('#phase-content #column-left').width()));
                            }
                        });

                        function resetRTC() {
                            clearTimeout(resetRTCTimeout);
                            $(window).resize();
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

                        $('body').on('click', '.next', function (event) {
                            event.preventDefault();
                            if (!$(this).hasClass('disabled')) {
                                nextStep();
                            }
                        });

                        $('body').on('click', '.phaseStepsSelect .option li', function (event) {
                            if (!$(this).hasClass('selected')) {
                                setTimeout(function () {
                                    updateProgress();
                                    renderPhaseStep();
                                    updatePager();
                                }, 50);
                            }
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
                                pinRTC();
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
                            $('#viewTester').find('#phase-content').empty();
                            $('#viewModerator').find('#phase-content').empty();
                        }

                        function renderPhaseStepForModerator() {
                            resetRenderedContent();
                            var currentStepId = $('#btn-phaseStepSelect .chosen').attr('id');
                            var data = getLocalItem(currentStepId + ".data");
                            if (data || (data && $.isArray(data) && data.length > 0)) {
                                Moderator.renderView();
                            } else {
                                Moderator.renderNoDataView();
                            }
                        }

                        function renderPhaseStepForTester() {
                            resetRenderedContent();
                            var currentStepId = $('#btn-phaseStepSelect .chosen').attr('id');
                            var data = getLocalItem(currentStepId + ".data");

                            if (data || (data && $.isArray(data) && data.length > 0)) {
                                Tester.renderView();
                            } else {
                                Tester.renderNoDataView();
                            }
                        }

                        $('#btn-toggle-rtc-fixed').on('click', function (event) {
                            event.preventDefault();
                            if ($(this).hasClass('selected')) {
                                $(this).removeClass('selected');
                                $(this).find('.glyphicon').removeClass('glyphicon-pushpin');
                                $(this).find('.glyphicon').addClass('glyphicon-new-window');
                                pinRTC();
                            } else {
                                $(this).addClass('selected');
                                $(this).find('.glyphicon').removeClass('glyphicon-new-window');
                                $(this).find('.glyphicon').addClass('glyphicon-pushpin');
                                dragRTC();
                            }
                        });

        </script>
    </body>
</html>