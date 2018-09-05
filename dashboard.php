<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

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

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();

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
        </script>

    </body>
</html>
