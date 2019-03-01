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
        <title><?php echo $lang->gestureNoteProfile ?></title>
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
        <link rel="stylesheet" href="css/gesture.css">
        <link rel="stylesheet" href="css/simulator.css">

        <script src="js/refreshSession.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/sha512.js"></script>
        <script src="js/checkForms.js"></script>
        <script src="js/gesture.js"></script>
        <script src="js/websocket.js"></script>
        <script src="js/stomp/stomp.js"></script>
        <script src="js/simulation/simulator.js"></script>

        <script src="js/joint-selection.js"></script>

        <script src="js/upload-queue.js"></script>
        <script src="js/gifshot/gifshot.min.js"></script>
        <script src="js/color-thief/color-thief.js"></script> 
        <script src="js/filesaver/FileSaver.min.js"></script>
        <script src="js/jszip/jszip.min.js"></script>
        <script src="js/jszip/jszip-utils.min.js"></script>

        <!-- leap and plugins -->
        <script src="js/leapjs/leap-0.6.4.min.js"></script>
        <script src="js/leapjs/leap-plugins-0.1.12.min.js"></script>
        <script src="js/three/three.min.js"></script>
        <script src="js/riggedHand/leap.rigged-hand-0.1.7.js"></script>
        <script src="js/leapjs-playback/leap.playback-0.2.1.js"></script>

        <!--gesture recorder--> 
        <script src="js/gestureRecorder/gestureRecorder.js"></script>
        <script src="js/gestureRecorder/webcamRecorder.js"></script>
        <script src="js/gestureRecorder/leapRecorder.js"></script>
        <script src="js/resumable/resumable.js"></script>


        <!-- bootstrap slider -->
        <link rel="stylesheet" href="js/bootstrap-slider/css/bootstrap-slider.css">
        <script src="js/bootstrap-slider/js/bootstrap-slider.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-general"></div>
        <div id="template-gesture-recorder"></div>
        <div id="template-simulator"></div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" data-conv-allowed="false" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog root">

                <!-- Modal content-->
                <div class="modal-content">
                </div>
            </div>
        </div>


        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb"style="">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li class="active" data-id="btn-simulator"><i class="fa fa-sign-language" aria-hidden="true"></i> <?php echo $lang->breadcrump->simulator ?></li>
                </ol>
            </div>
        </div>

        <div id="loading-indicator" class="window-sized-loading text-center">
            <i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw"></i>
        </div>

        <!-- Container (Landing Section) -->
        <div class="container mainContent" id="gesture-sets-content" style="margin-top: 0px">
            <div class="input-group" id="gesture-sets-select">
                <input class="form-control item-input-text option-gesture-sets show-dropdown" tabindex="-1" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                <div class="input-group-btn select select-gesture-sets" role="group">
                    <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                    <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                </div>
            </div>
        </div>

        <!-- Container (Landing Section) -->
        <div class="container mainContent hidden" id="simulator-content" style="margin-top: 0px">
        </div>

        <div class="container mainContent hidden" id="simulation-recorder-content">

        </div>

        <script>
            $(document).ready(function () {
                checkDomain();
                keepSessionAlive();

                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                    externals.push(['#template-gesture-recorder', PATH_EXTERNALS + 'template-gesture-recorder.php']);
                    externals.push(['#template-simulator', PATH_EXTERNALS + 'template-simulator.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
                animateBreadcrump();
                getGestureCatalog(function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        getGestureSets(function (result) {
                            if (result.status === RESULT_SUCCESS) {
                                setLocalItem(GESTURE_SETS, result.gestureSets);
                                renderAssembledGestureSets(result.gestureSets, $('#gesture-sets-select'));
                            }

                            var query = getQueryParams(document.location.search);
                            if (query.gestureSetId) {
                                var gestureSetId = parseInt(query.gestureSetId);
                                $('#gesture-sets-select').find('#' + gestureSetId).click();
                            }

                            showPageContent();
                            initWebSocket();
                        });
                    }
                });
            }

            function showPageContent() {
                $('#simulator-content').removeClass('hidden');
                TweenMax.to($('#loading-indicator'), .4, {opacity: 0, onComplete: function () {
                        $('#loading-indicator').remove();
                    }});
            }

            $('#gesture-sets-select').unbind('change').bind('change', function (event) {
                event.preventDefault();
                var selectedSet = getGestureSetById($(event.target).attr('id'));
                var currentPreviewGestureSet = {set: selectedSet};
                setParam(window.location.href, 'gestureSetId', selectedSet.id);
                var clone = getGestureSimulationSetPanel(currentPreviewGestureSet.set);
                $('#pageBody').find('#simulator-content').empty().append(clone);
                initPopover();
            });

            $('#custom-modal').unbind('gestureUpdated').bind('gestureUpdated', function (event, gesture) {
                event.preventDefault();
                updateGestureSimluationThumbnail(gesture.id, $('#pageBody').find('#simulator-content'));
            });
        </script>

    </body>
</html>