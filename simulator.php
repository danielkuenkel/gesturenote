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
        <script src="js/filesaver/FileSaver.min.js"></script>
        <script src="js\joint-selection.js"></script>
        <script src="js\collaborativeVideo.js"></script>


        <!-- bootstrap slider -->
        <link rel="stylesheet" href="js/bootstrap-slider/css/bootstrap-slider.css">
        <script src="js/bootstrap-slider/js/bootstrap-slider.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-general"></div>
        <div id="template-simulator"></div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" data-backdrop="static" data-keyboard="false" role="dialog">
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

        <script>
            $(document).ready(function () {
                checkDomain();
                keepSessionAlive();

                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
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
                                console.log('select prefered mappings for gesture set id:', gestureSetId);
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


            var isVideoShown = true;
            var pauseGetPosition = false;
            var staticContinuousTimer = null;

            $('#gesture-sets-select').unbind('change').bind('change', function (event) {
                event.preventDefault();
                currentPreviewGestureSet = {set: getGestureSetById($(event.target).attr('id'))};
                console.log(currentPreviewGestureSet);

                currentGestureSet = $('#pageBody').find('#simulator-content');
                currentGestureSet.empty();
                var clone = getGestureCatalogGestureSetPanel(currentPreviewGestureSet.set);
                currentGestureSet.append(clone);
                initPopover();

                $(clone).find('#btn-show-hide-video').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    if(isVideoShown){
                        $(clone).find("#gestures-list-container .embed-responsive").hide();
                        $(clone).find('#btn-show-hide-video').find('i').removeClass("fa-compress").addClass("fa-expand");
                        isVideoShown = false;
                    } else {
                        $(clone).find("#gestures-list-container").find(".embed-responsive").show();
                        $(clone).find('#btn-show-hide-video').find('i').removeClass("fa-expand").addClass("fa-compress");
                        isVideoShown = true;
                    }
                });


                for (var i = currentPreviewGestureSet.set.gestures.length - 1; i >= 0; i--) {
                    var gesture = getGestureById(currentPreviewGestureSet.set.gestures[i]);
                    if(gesture.interactionType === TYPE_GESTURE_DISCRETE)                     {
                        $(clone).find('#'+gesture.id).find('.simulator-trigger').removeClass("hidden");
                        $(clone).find('#'+gesture.id).find('.static-continuous-controls').remove();
                    } else{
                        if(gesture.continuousValueType === PERCENT){
                            $(clone).find('#'+gesture.id).find('#control-continuous-slider').removeClass('hidden');
                            $(clone).find('#'+gesture.id).find('.continuous-gesture-controls').removeClass('hidden');
                            //$(clone).find('#'+gesture.id).find('#control-continuous-slider-status').removeClass('hidden');

                            var continuousSlider = $(clone).find('#'+gesture.id).find('#control-continuous-slider #continuous-slider');

                            var sliderOptions = {
                                value: 50,
                                min: 0,
                                max: 100,
                                enabled: true
                            };

                            $(continuousSlider).slider(sliderOptions);
                            $(continuousSlider).unbind('change').bind('change', {gesture: gesture}, function (event) {
                                event.preventDefault();
                                var inverted = $(this).hasClass('inverted');
                                var percent = parseInt(event.value.newValue);
                                var imagePercent = inverted ? (100 - percent) : percent;
                                var gestureId = event.data.gesture.id;
                                $(continuousSlider).closest('.root').find('.control-continuous-slider-status').text(percent + '%');
                                var gestureImages = $(continuousSlider).closest('.root').find('.gestureImage');
                                $(gestureImages).removeClass('active').addClass('hidden');
                                $($(gestureImages)[Math.max(0, (Math.min(parseInt(gestureImages.length * imagePercent / 100), gestureImages.length - 1)))]).addClass('active').removeClass('hidden');
                                sendContinuousPGGesture(gestureId, percent);
                            });
                        } else if (gesture.continuousValueType === "position"){
                            $(clone).find('#'+gesture.id).find('.simulator-continuous-trigger').removeClass('hidden');
                            $(clone).find('#'+gesture.id).find('#btn-trigger-continuous-gesture').unbind('click').bind('click', {gesture: gesture} , function(event) {
                                event.preventDefault();
                                loadHTMLintoModal('custom-modal', 'externals/modal-simPosition.php', 'modal-lg');
                                $('#custom-modal').on('shown.bs.modal', function () {
                                    $(this).find('#viewer_positionScreen_type').val(event.data.gesture.continuousValueType);
                                    $(this).find('.root').attr('id', event.data.gesture.id);
                                });
                            });
                        } else if (gesture.continuousValueType === "mouseSimulation"){
                            $(clone).find('#'+gesture.id).find('.simulator-continuous-trigger').removeClass('hidden');
                            $(clone).find('#'+gesture.id).find('#btn-trigger-continuous-gesture').unbind('click').bind('click', {gesture: gesture} , function(event) {
                                event.preventDefault();
                                loadHTMLintoModal('custom-modal', 'externals/modal-simPosition.php', 'modal-lg');
                                $('#custom-modal').on('shown.bs.modal', function () {
                                    $(this).find('#viewer_positionScreen_type').val(event.data.gesture.continuousValueType);
                                    $(this).find('.root').attr('id', event.data.gesture.id);
                                });
                            });
                        } else {
                            $(clone).find('#'+gesture.id).find('.static-continuous-controls').removeClass('hidden');

                            $(clone).find('#'+gesture.id).find('.btn-start-static-continuous-gesture').unbind('click').bind('click', {gesture: gesture}, function (event) {
                                event.preventDefault();
                                if (!$(this).hasClass('disabled')) {
                                    $(this).addClass('disabled');
                                    $(this).closest('.static-continuous-controls').find('.btn-stop-static-continuous-gesture').removeClass('disabled');
                                    staticContinuousTimer = setInterval(function () {
                                        sendPGGesture(event.data.gesture.id);
                                    }, 500);
                                }
                            });

                            $(clone).find('#'+gesture.id).find('.btn-stop-static-continuous-gesture').unbind('click').bind('click', {gesture: gesture}, function (event) {
                                event.preventDefault();
                                if (!$(this).hasClass('disabled')) {
                                    $(this).addClass('disabled');
                                    $(this).closest('.static-continuous-controls').find('.btn-start-static-continuous-gesture').removeClass('disabled');
                                    if (staticContinuousTimer) {
                                        clearInterval(staticContinuousTimer);
                                    }
                                }
                            });
                        }
                    }
                }


                $(clone).find('#btn-trigger-gesture').unbind('click').bind('click', function(event){
                    event.preventDefault();
                    var gestureId = $(this).closest('.root').attr('id');
                    sendPGGesture(gestureId);
                });

                $(document).on('click', '.positionArea', function(event) {
                    var gesture = getGestureById($(this).closest('.root').attr('id'));
                    var pos = getMousePosition(this);
                    var positionType = $('#viewer_positionScreen_type').val();
                    console.log(positionType);
                    sendContinuousPGPosition($(this).closest('.root').prop('id'), positionType, pos.relPosX, pos.relPosY, true);
                });

                $(document).on('mousemove', '.positionArea', function(event) {
                    var gesture = getGestureById($(this).closest('.root').attr('id'));
                    if (!pauseGetPosition) {
                        var pos = getMousePosition(this);
                        var positionType = $('#viewer_positionScreen_type').val();
                        console.log(positionType);
                        sendContinuousPGPosition($(this).closest('.root').prop('id'), positionType, pos.relPosX, pos.relPosY, false);

                    }

                });

                var getMousePosition = function(element) {
                    var offset = $(element).offset();
                    var width = $(element).width();
                    var height = $(element).height();
                    var posx = 0;
                    var posy = 0;
                    var relPosx = 0;
                    var relPosy = 0;
                    if (!event) var event = window.event;
                    if (event.pageX || event.pageY) {
                        posx = event.pageX;
                        posy = event.pageY;
                    } else if (event.clientX || event.clientY) {
                        posx = event.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
                        posy = event.clientY + document.body.scrollTop + document.documentElement.scrollTop;
                    }


                    posx = parseInt(posx - offset.left);
                    posy = parseInt(posy - offset.top);

                    relPosx = posx / width;
                    relPosy = posy / height;

                    var coor = "rel X coords: " + relPosx + ",<br/> rel Y coords: " + relPosy;
                    $(".output").html(coor);
                    pauseGetPosition = true;
                    window.setTimeout(function() {
                        pauseGetPosition = false
                    }, GESTURE_GET_MOUSE_POSITION_SPEED);
                    return {
                        relPosX: relPosx,
                        relPosY: relPosy
                    };
                }
            });
        </script>

    </body>
</html>