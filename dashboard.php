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
        <title><?php echo $lang->gestureNoteDashboard ?></title>
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
        <link rel="stylesheet" href="css/generalSubPages.css">

        <script src="js/storage.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/refreshSession.js"></script>
        <script src="js/masonry/masonry.min.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-general"></div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content root">
                </div>
            </div>
        </div>

        <!-- Container (Landing Section) --> 
        <div class="container hidden" id="breadcrumb" style="">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                    <li class="active" data-id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></li>
                </ol>
            </div>
        </div>

        <div class="hidden-xs hidden-sm study-edit-controls" id="fixed-quick-controls" style="position: fixed; top: 50%; transform: translateY(-50%); z-index: 100; opacity: 0; left:-187px">
            <div class="btn-group-vertical">
                <div>
                    <button type="button" class="btn btn-lg btn-default btn-shadow btn-create-study" style="position: relative; float: right; border-radius: 0px; border-top-right-radius: 8px"><?php echo $lang->createNewStudy ?> <i class="fa fa-plus" style="margin-left: 15px"></i></button>
                </div>
                <div>
                    <button type="button" class="btn btn-lg btn-default btn-shadow btn-record-gesture" onclick="goto('gestures-catalog.php#recorder')" style="position: relative; float: right; border-radius: 0px; "><?php echo $lang->recordGesture ?> <i class="fa fa-video-camera" style="margin-left: 15px"></i></button>
                </div>
                <div>
                    <button type="button" class="btn btn-lg btn-default btn-shadow btn-gesture-sets" onclick="goto('gestures-catalog.php#sets')" style="position: relative; float: right; border-radius: 0px; border-bottom-right-radius: 8px"><?php echo $lang->gestureSets ?> <i class="fa fa-paperclip" style="margin-left: 15px"></i></button>
                </div>
            </div>
        </div>

        <!-- Container (Panel Section) -->
        <div class="container center-text mainContent" style="margin-top: 0px">
            <h3><?php echo $lang->breadcrump->dashboard ?></h3>

            <div class="row" id="dashboard-items-container" style="margin-top: 20px">
                <div class="col-md-4 col-sm-6 dashboard-item" style="opacity: 0">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-studies">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-tasks" aria-hidden="true"></i> <?php echo $lang->breadcrump->studies ?></div>
                        <div class="panel-body panel-content"><?php echo $lang->dashboard->studiesPanelBody ?></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 dashboard-item" style="opacity: 0">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-gesture-styleguides">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-map-signs" aria-hidden="true"></i> <?php echo $lang->breadcrump->gestureStyleguides ?></div>
                        <div class="panel-body panel-content"><?php echo $lang->dashboard->gesturesStyleguidesPanelBody ?></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 dashboard-item" style="opacity: 0">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-gesture-catalog">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-sign-language" aria-hidden="true"></i> <?php echo $lang->breadcrump->gestureCatalog ?></div>
                        <div class="panel-body panel-content">
                            <div id="total-gestures"><span class="address"></span> <span class="text"></span></div>
                            <div id="public-gestures"><span class="address"></span> <span class="text"></span></div>
                            <div id="user-gestures"><span class="address"></span> <span class="text"></span></div>
                            <div id="user-public-gestures"><span class="address"></span> <span class="text"></span></div>
                            <div id="elicited-gestures"><span class="address"></span> <span class="text"></span></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 dashboard-item" style="opacity: 0">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-panel-simulator">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-sign-language" aria-hidden="true"></i> <?php echo $lang->breadcrump->simulator ?></div>
                        <div class="panel-body panel-content"><?php echo $lang->dashboard->simulatorPanelBody ?></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 dashboard-item" style="opacity: 0">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-news">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <?php echo $lang->breadcrump->news ?></div>
                        <div class="panel-body panel-content"><?php echo $lang->dashboard->newsPanelBody ?></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 dashboard-item" style="opacity: 0">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-publications">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <?php echo $lang->breadcrump->publications ?></div>
                        <div class="panel-body panel-content"><?php echo $lang->dashboard->publicationsPanelBody ?></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 dashboard-item" style="opacity: 0">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-profile">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $lang->breadcrump->profile ?></div>
                        <div class="panel-body panel-content"><?php echo $lang->dashboard->profilePanelBody ?></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 dashboard-item" style="opacity: 0">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-support">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-support" aria-hidden="true"></i> <?php echo $lang->breadcrump->help ?></div>
                        <div class="panel-body panel-content"><?php echo $lang->dashboard->helpPanelBody ?></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 dashboard-item" style="opacity: 0">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-informations">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-file-text-o" aria-hidden="true"></i> <?php echo $lang->breadcrump->informations ?></div>
                        <div class="panel-body panel-content"><?php echo $lang->dashboard->informationsPanelBody ?></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 dashboard-item" style="opacity: 0">
                    <div class="panel panel-default btn-shadow btn-panel" id="btn-imprint">
                        <div class="panel-heading ellipsis" style="font-size: 18pt"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $lang->breadcrump->imprint ?></div>
                        <div class="panel-body panel-content"><?php echo $lang->dashboard->imprintPanelBody ?></div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                checkDomain();
                checkCookies(parseInt('<?php echo checkCookiesAccepted(); ?>'));
                keepSessionAlive();

                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                    loadExternals(externals);
                });
            });


            // fixed buttons tweening

            var createStudyButton = $('#fixed-quick-controls .btn-create-study');
            var createStudyButtonTimeline = new TimelineMax({paused: true, onStart: function () {
                    $(createStudyButton).css({borderBottomRightRadius: '8px'});
                    $(createStudyButton).removeClass('btn-default').addClass('btn-primary');
                }, onReverseComplete: function () {
                    $(createStudyButton).css({borderBottomRightRadius: '0px'});
                    $(createStudyButton).removeClass('btn-primary').addClass('btn-default');
                }});

            createStudyButtonTimeline.add("createStudy", 0)
                    .to(createStudyButton, .3, {left: +186, ease: Quad.easeInOut}, "previewStudy");

            $(createStudyButton).unbind('mouseenter').bind('mouseenter', function (event) {
                event.preventDefault();
                createStudyButtonTimeline.play();
            });

            $(createStudyButton).unbind('mouseleave').bind('mouseleave', function (event) {
                event.preventDefault();
                createStudyButtonTimeline.reverse();
            });


            var recordGestureButton = $('#fixed-quick-controls .btn-record-gesture');
            var recordGestureButtonTimeline = new TimelineMax({paused: true, onStart: function () {
                    $(recordGestureButton).css({borderBottomRightRadius: '8px', borderTopRightRadius: '8px'});
                    $(recordGestureButton).removeClass('btn-default').addClass('btn-primary');
                }, onReverseComplete: function () {
                    $(recordGestureButton).css({borderBottomRightRadius: '0px', borderTopRightRadius: '0px'});
                    $(recordGestureButton).removeClass('btn-primary').addClass('btn-default');
                }});

            recordGestureButtonTimeline.add("cacheStudy", 0)
                    .to(recordGestureButton, .3, {left: +166, ease: Quad.easeInOut}, "cacheStudy");

            $(recordGestureButton).unbind('mouseenter').bind('mouseenter', function (event) {
                event.preventDefault();
                recordGestureButtonTimeline.play();
            });

            $(recordGestureButton).unbind('mouseleave').bind('mouseleave', function (event) {
                event.preventDefault();
                recordGestureButtonTimeline.reverse();
            });


            var gestureSetsButton = $('#fixed-quick-controls .btn-gesture-sets');
            var gestureSetsButtonTimeline = new TimelineMax({paused: true, onStart: function () {
                    $(gestureSetsButton).css({borderTopRightRadius: '8px'});
                    $(gestureSetsButton).removeClass('btn-default').addClass('btn-primary');
                }, onReverseComplete: function () {
                    $(gestureSetsButton).css({borderTopRightRadius: '0px'});
                    $(gestureSetsButton).removeClass('btn-primary').addClass('btn-default');
                }});

            gestureSetsButtonTimeline.add("saveStudy", 0)
                    .to(gestureSetsButton, .3, {left: +113, ease: Quad.easeInOut}, "saveStudy");

            $(gestureSetsButton).unbind('mouseenter').bind('mouseenter', function (event) {
                event.preventDefault();
                gestureSetsButtonTimeline.play();
            });

            $(gestureSetsButton).unbind('mouseleave').bind('mouseleave', function (event) {
                event.preventDefault();
                gestureSetsButtonTimeline.reverse();
            });



            // rendering
            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
                checkDarkMode(parseInt('<?php echo checkDarkMode(); ?>'));

                var fixedControlsTween = new TimelineMax({paused: true});
                fixedControlsTween.add("parallel", .3)
                        .to($('#fixed-quick-controls'), .2, {opacity: 1, ease: Quad.easeInOut}, 'parallel')
                        .from($('#fixed-quick-controls'), .2, {x: -20, ease: Quad.easeInOut}, 'parallel');
                fixedControlsTween.play();

                getDashboardInfos(function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        // gestures catalog infos
                        var item = $('#btn-gesture-catalog');
                        $(item).find('#total-gestures .address').text(translation.gesturesCatalog.totalGestures + ":");
                        $(item).find('#total-gestures .text').text(result.totalGestures);
                        $(item).find('#public-gestures .address').text(translation.gesturesCatalog.publicGestures + ":");
                        $(item).find('#public-gestures .text').text(result.publicGestures);
                        $(item).find('#user-gestures .address').text(translation.gesturesCatalog.userGestures + ":");
                        $(item).find('#user-gestures .text').text(result.userGestures);
                        $(item).find('#user-public-gestures .address').text(translation.gesturesCatalog.publicUserGestures + ":");
                        $(item).find('#user-public-gestures .text').text(result.publicUserGestures);
                        $(item).find('#elicited-gestures .address').text(translation.gesturesCatalog.elicitedGestures + ":");
                        $(item).find('#elicited-gestures .text').text(result.elicitedGestures);
                        renderMasonryTest();
                        animateStart();
                    } else {

                    }

                    animateBreadcrump();
                });
            }

            function animateStart() {
                var items = $('#dashboard-items-container').children();
                for (var i = 0; i < items.length; i++) {
                    var item = $(items[i]);
                    $(item).css({opacity: 1});
                    TweenMax.from(item, .2, {opacity: 0, delay: i * 0.05, scaleX: 0.5, scaleY: 0.5});
                }
            }

//            $('#btn-create-study').click(function (event) {
//                event.preventDefault();
//                event.stopPropagation();
//                gotoCreateStudy();
//            });

            function renderMasonryTest() {
                var $container = $('#dashboard-items-container');
                $container.masonry({
                    columnWidth: '.dashboard-item',
                    itemSelector: '.dashboard-item'
                });
            }

            $('#btn-panel-simulator').unbind('click').bind('click', function (event) {
                event.preventDefault();
                gotoSimulator();
            });

            $('.btn-create-study').unbind('click').bind('click', function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'externals/modal-create-study-picker.php', 'modal-md');
            });
        </script>

    </body>
</html>
