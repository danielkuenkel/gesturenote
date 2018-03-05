<?php
include './includes/language.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GestureNote</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/gesture.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

        <script src="js/storage.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/filesaver/FileSaver.min.js"></script>
        <script src="js/sha512.js"></script>
        <script src="js/chance.min.js"></script>

        <!-- leap and plugins -->
        <script src="//js.leapmotion.com/leap-0.6.4.js"></script>
        <script src="js/three/three.min.js"></script>
        <script src="//js.leapmotion.com/leap-plugins-0.1.8.js"></script>
        <script src="js/riggedHand/leap.rigged-hand-0.1.7.js"></script>
        <script src="js/gestureRecorder/leap.js"></script>
        <script src="js/leapjs-playback/leap.playback-0.2.1.js"></script>
        <script src="js/leapjs-playback/lz-string-1.3.3.js"></script>

        <!-- bootstrap slider -->
        <link rel="stylesheet" href="js/bootstrap-slider/css/bootstrap-slider.css">
        <script src="js/bootstrap-slider/js/bootstrap-slider.js"></script>
    </head>

    <body id="pageBody" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-subpages"></div>


        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" role="dialog">
            <div class="modal-dialog">

                <!--Modal content-->
                <div class="modal-content root">
                </div>
            </div>
        </div>


        <!-- Container (Breadcrump) --> 
        <div class="container" id="breadcrumb" style="padding-top: 40px">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><?php echo $lang->breadcrump->home ?></a></li>
                </ol>
            </div>
        </div>

        <div class="container mainContent" style="margin-top: 0px">
            <div id="alert-hints">
                <div class="alert-space alert-please-wait"></div>
            </div>

            <div class="btn-group">
                <button class="btn btn-default" id="btn-start-recording">RECORD</button>
                <button class="btn btn-default disabled" id="btn-crop-recording">CROP</button>
                <button class="btn btn-default" id="btn-toggle-playback"><i class="fa fa-play"></i></button>
            </div>
            <div class="btn-group">
                <button class="btn btn-default" id="btn-download-recording-as-json">DOWNLOAD JSON</button>
                <button class="btn btn-default" id="btn-download-recording-as-compressed">DOWNLOAD COMPRESSED</button>
                <button class="btn btn-default" id="btn-load-recording">LOAD FILE</button>
            </div>
            <form enctype="multipart/form-data" id="upload-leap-recording" class="hidden">
                <input class="fileUpload hidden" name="image" type="file" accept="text/json, text/lz" />
            </form>
            <div class="row">
                <div class="col-xs-12">
                    <div id="playback-controls">
                        <div id="leap-playback-slider-container" class="leap-playback-slider-container hidden" style="width: 100%">
                            <input id="leap-playback-slider" data-slider-id="sliderLeap" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                        </div>
                        <div id="leap-playback-crop-slider-container" class="leap-playback-slider-container hidden" style="width: 100%">
                            <input id="leap-playback-crop-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="[0,100]" data-slider-tooltip="hide" />
                        </div>
                    </div>
                </div>
            </div>

        </div>



        <canvas id="renderArea" style="width: 400px; height: 300px"></canvas>

        <script>
            $(document).ready(function () {
                initializeLeapMotion();
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    loadExternals(externals);
                });
            });
            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
            }

            function initializeLeapMotion() {
                var options = {
                    previewOnly: true,
                    recording: 'uploads/0d594090ce033136c4d7e359738ffbe56628ba80ee463fa3328644c851ee8c53be5877c75bb94b49e87b30a630343688fc1239bcebff293b1bf76f579d5ac78f.json.lz',
                    overlays: $('#alert-hints'),
                    renderTarget: $('#renderArea'),
                    recordElement: $('#btn-start-recording'),
                    playbackElement: $('#btn-toggle-playback'),
                    downloadJsonElement: $('#btn-download-recording-as-json'),
                    downloadCompressedElement: $('#btn-download-recording-as-compressed'),
                    loadRecordingElement: $('#btn-load-recording'),
                    loadInputElement: $('#upload-leap-recording'),
                    cropRecordElement: $('#btn-crop-recording'),
                    playbackSliderElement: $('#leap-playback-slider'),
                    cropSliderElement: $('#leap-playback-crop-slider')
                };
                new LeapMotionRecorder(options);
            }

//            function initializeControls(controller) {
//                var autoPlay = controller.plugins.playback.player.autoPlay;
//                function initPlaybackSlider(highlightRange) {
//                    var frameLength = Math.max(controller.plugins.playback.player.recording.frameData.length - 1, 0);
//                    var crops = {left: controller.plugins.playback.player.recording.leftCropPosition, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition - 1, 0)};
//                    var options = {
//                        min: 0,
//                        max: frameLength,
//                        step: 1,
//                        value: crops.left
//                    };
//                    if (highlightRange === true && (crops.left > 0 || crops.right < frameLength)) {
//                        options.rangeHighlights = [{start: crops.left, end: crops.right, class: "category1"}];
//                    }
//                    $('#leap-playback-slider').slider(options);
//                    $('#leap-playback-slider').unbind('slide').bind('slide', function (event) {
//                        if (controller.plugins.playback.player.state === 'playing') {
//                            $('#btn-toggle-playback').click();
//                        } else {
//                            controller.plugins.playback.player.setFrameIndex(parseInt(event.value, 10));
//                        }
//                    });
//                    controller.plugins.playback.player.setFrameIndex(parseInt(crops.left, 10));
//                }
//                initPlaybackSlider();
//                $('#btn-crop-recording').removeClass('disabled');
//
//                
//
//                controller.on('playback.recordingFinished', function () {
//                    $('#btn-start-recording').removeClass('disabled');
//                    $('#btn-crop-recording').removeClass('disabled');
//                    initPlaybackSlider();
//                });
//                
//                if (autoPlay) {
//                    controller.plugins.playback.player.setFrameIndex(0);
//                    $('#btn-toggle-playback').find('.fa').removeClass('fa-play').addClass('fa-pause');
//                    controller.plugins.playback.player.play();
//                }
//
//                $('#btn-toggle-playback').unbind('click').bind('click', function (event) {
//                    event.preventDefault();
//                    if ($('#btn-crop-recording').hasClass('cropping')) {
//                        $('#btn-crop-recording').click();
//                    }
//
//                    if (controller.plugins.playback.player.state === 'playing') {
//                        $(this).find('.fa').removeClass('fa-pause').addClass('fa-play');
//                        controller.plugins.playback.player.pause();
//                    } else if (controller.plugins.playback.player.state === 'idle') {
//                        $(this).find('.fa').removeClass('fa-play').addClass('fa-pause');
//                        controller.plugins.playback.player.play();
//                        $('#btn-crop-recording').removeClass('cropping');
//                        $('#leap-playback-slider-container').removeClass('hidden');
//                        $('#leap-playback-crop-slider-container').addClass('hidden');
//                    }
//                });
//
//                $('#btn-crop-recording').unbind('click').bind('click', function (event) {
//                    event.preventDefault();
//                    if (!$(this).hasClass('disabled')) {
//                        if (controller.plugins.playback.player.state === 'playing') {
//                            $('#btn-toggle-playback').click();
//                        }
//
//                        if ($(this).hasClass('cropping')) {
//                            $('#leap-playback-slider').slider('destroy');
//                            initPlaybackSlider(true);
//                            $(this).removeClass('cropping');
//                            $('#leap-playback-slider-container').removeClass('hidden');
//                            $('#leap-playback-crop-slider-container').addClass('hidden');
//                        } else {
//                            $(this).addClass('cropping');
//                            $('#leap-playback-slider-container').addClass('hidden');
//                            $('#leap-playback-crop-slider-container').removeClass('hidden');
//                            var currentCropValues;
//                            $('#leap-playback-crop-slider').slider({
//                                min: 0,
//                                max: controller.plugins.playback.player.recording.rightCropPosition,
//                                value: [0, controller.plugins.playback.player.recording.rightCropPosition]
//                            });
//                            $('#leap-playback-crop-slider').unbind('slide').bind('slide', function (event) {
////                                console.log(event.value);
//                                var cropPositions = {left: controller.plugins.playback.player.recording.leftCropPosition, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition, 0)};
//                                if (!currentCropValues) {
//                                    currentCropValues = cropPositions;
//                                } else {
//                                    if (parseInt(currentCropValues.left) !== parseInt(cropPositions.left)) {
//                                        controller.plugins.playback.player.setFrameIndex(parseInt(event.value[0], 10));
//                                        controller.plugins.playback.player.recording.leftCrop();
//                                    } else if (parseInt(currentCropValues.right) !== parseInt(cropPositions.right)) {
//                                        controller.plugins.playback.player.setFrameIndex(parseInt(event.value[1], 10));
//                                        controller.plugins.playback.player.recording.rightCrop();
//                                    }
//                                    currentCropValues = {left: event.value[0], right: event.value[1]};
//                                }
//                            });
//                        }
//                    }
//                });
//            }
        </script>

    </body>
</html>