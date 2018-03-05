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

        <!-- leap -->
        <script src="//js.leapmotion.com/leap-0.6.4.js"></script>
        <script src="js/three/three.min.js"></script>
        <script src="//js.leapmotion.com/leap-plugins-0.1.8.js"></script>
        <!--<script src="//js.leapmotion.com/leap.rigged-hand-0.1.5.js"></script>-->
        <script src="js/riggedHand/build/leap.rigged-hand-0.1.7.js"></script>
        <!--<script src="js/riggedHand/build/leapmotionPlayer.js"></script>-->


        <!--        <link rel="stylesheet" href="js/leapjs-playback/stylesheets/controls.css">
                <link rel="stylesheet" href="js/leapjs-playback/stylesheets/data-collection.css">
                <link rel="stylesheet" href="js/leapjs-playback/stylesheets/main.css">
                <link rel="stylesheet" href="js/leapjs-playback/stylesheets/lib/angular.rangeSlider.css">
                <link rel="stylesheet" href="js/leapjs-playback/stylesheets/lib/xeditable.css">-->

<!--        <script src="js/leapjs-playback/javascripts/lib/angular.js"></script>
        <script src="js/leapjs-playback/javascripts/lib/angular.rangeSlider.js"></script>
        <script src="js/leapjs-playback/javascripts/lib/angular-spinner.min.js"></script>
        <script src="js/leapjs-playback/javascripts/lib/xeditable.min.js"></script>-->

        <!--<script src="js/leapjs-playback/javascripts/data-collection.js"></script>-->
        <script src="js/leapjs-playback/build/leap.playback-0.2.1.js"></script>
<!--        <script src="js/leapjs-playback/javascripts/controls.js"></script>
        <script src="js/leapjs-playback/javascripts/metadata.js"></script>
        <script src="js/leapjs-playback/javascripts/recorder.js"></script>-->
<!--        <script src="js/leapjs-playback/src/player.js"></script>
        <script src="js/leapjs-playback/src/recording.js"></script>-->
        <script src="js/leapjs-playback/src/lib/lz-string-1.3.3.js"></script>

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
            <div class="alert-space alert-please-wait"></div>
            <div class="btn-group">
                <button class="btn btn-default" id="btn-start-recording">RECORD</button>
                <button class="btn btn-default disabled" id="btn-crop-recording">CROP</button>
                <button class="btn btn-default" id="btn-toggle-playback"><i class="fa fa-play"></i></button>
                <!--<button class="btn btn-default disabled" id="btn-stop-recording">STOP RECORD</button>-->
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
                        <div id="leap-playback-slider-container" class="leap-playback-slider-container" style="width: 100%">
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
                appendAlert($('.mainContent'), ALERT_PLEASE_WAIT);
                var controller = new Leap.Controller({enableGestures: false});
                controller.use('playback', {
                    recordEmptyHands: true,
                    recording: 'js/leapjs-playback/recorder/recordings/leap-playback-recording-55fps_1.json',
                    requiredProtocolVersion: 6,
                    pauseOnHand: false
                });
//                controller.use('handHold', {
//                    materialOptions: {
//                        wireframe: true,
//                        color: new THREE.Color(0xff0000)
//                    }
//                });
//                controller.use('transform', {
//                    position: new THREE.Vector3(0, -150, 0)
//                });
                controller.use('riggedHand', {
                    checkWebGL: false,
                    offset: {x: 0, y: 150, z: 0}
//                    parent: document.getElementById('renderArea')
                });
                controller.connect();
                controller.on('connect', onConnect);
                function onConnect()
                {
                    console.log("controller connected ");
                    clearAlerts($('.mainContent'));
                }

                controller.on('deviceAttached', onAttached);
                function onAttached()
                {
                    console.log("device attached");
                    clearAlerts($('.mainContent'));
                }

                controller.on('deviceRemoved', onDeviceRemoved);
                function onDeviceRemoved()
                {
                    console.log("device removed ");
                    appendAlert($('.mainContent'), ALERT_PLEASE_WAIT);
                }

                controller.on('deviceStopped', onDeviceStopped);
                function onDeviceStopped()
                {
                    console.log("device stopped ");
                    appendAlert($('.mainContent'), ALERT_PLEASE_WAIT);
                }

                controller.on('deviceStreaming', onDeviceStreaming);
                function onDeviceStreaming()
                {
//                    var riggedHand = controller.plugins.riggedHand;
//                    console.log(riggedHand);
                    console.log("device streaming ");
//                    controller.plugins.playback.player.play()
                    clearAlerts($('.mainContent'));
                }

                controller.on('blur', onBlur);
                function onBlur()
                {
                    console.log("controller blur event");
                }

                $('#btn-start-recording').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
                        controller.plugins.playback.player.record();
                    }
                });
//                $('#btn-stop-recording').unbind('click').bind('click', function (event) {
//                    event.preventDefault();
//                    var button = $(this);
//                    if (!$(button).hasClass('disabled')) {
//                        $(button).addClass('disabled');
//                    }
//                });

                $('#btn-download-recording-as-json').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    if (controller && controller.plugins && controller.plugins.playback.player) {
                        controller.plugins.playback.player.recording.save('json');
                    }
                });

                $('#btn-download-recording-as-compressed').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    if (controller && controller.plugins && controller.plugins.playback.player) {
                        controller.plugins.playback.player.recording.save('lz');
                    }
                });

                $('#btn-load-recording').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    $('#upload-leap-recording').find('.fileUpload').click();
                });

                $('#upload-leap-recording').find('.fileUpload').on('change', function (event) {
                    event.preventDefault();
                    if (event.handled !== true)
                    {
                        event.handled = true;
                        var uploadFiles = $(this)[0].files[0];
                        if (uploadFiles) {
                            var fr = new FileReader();
                            fr.onload = function (evt) {
                                controller.plugins.playback.player.recording.readFileData(evt.target.result, uploadFiles, function (frames) {
                                    console.log('file loaded successfully ');
                                    initializeControls(controller);
                                });
                            };
                            fr.readAsText($(this)[0].files[0]);
                        }
                    }
                });

                if (controller) {
                    controller.on('playback.ajax:complete', function () {
                        initializeControls(controller);

                        controller.on('playback.beforeSendFrame', function () {
                            $('#leap-playback-slider').slider('setValue', controller.plugins.playback.player.recording.frameIndex);
                        });
                    });
                }
            }

            function initializeControls(controller) {
                var autoPlay = controller.plugins.playback.player.autoPlay;

                function initPlaybackSlider() {
                    var frameLength = Math.max(controller.plugins.playback.player.recording.frameData.length - 1, 0);
                    var crops = {left: controller.plugins.playback.player.recording.leftCropPosition, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition - 1, 0)};
                    $('#leap-playback-slider').slider({
                        min: 0,
                        max: frameLength,
                        step: 1,
                        value: crops.left,
                        rangeHighlights: [{start: crops.left, end: crops.right, class: "category1"}]
                    });

                    $('#leap-playback-slider').unbind('slide').bind('slide', function (event) {
                        if (controller.plugins.playback.player.state === 'playing') {
                            controller.plugins.playback.player.pause();
                        } else {
                            controller.plugins.playback.player.setFrameIndex(parseInt(event.value, 10));
                        }
                    });
                    controller.plugins.playback.player.setFrameIndex(parseInt(crops.left, 10));
                }
                initPlaybackSlider();

                $('#btn-crop-recording').removeClass('disabled');
                controller.on('playback.record', function () {
                    $('#btn-start-recording').addClass('disabled');
                    $('#btn-crop-recording').addClass('disabled');
                });

                controller.on('playback.recordingFinished', function () {
                    $('#btn-start-recording').removeClass('disabled');
                    $('#btn-crop-recording').removeClass('disabled');
                    initializeControls(controller, controller.plugins.playback.player.recording.frameData.length - 1);
                });

                if (autoPlay) {
                    controller.plugins.playback.player.setFrameIndex(0);
                    $('#btn-toggle-playback').find('.fa').removeClass('fa-play').addClass('fa-pause');
                    controller.plugins.playback.player.play();
                }
                $('#btn-toggle-playback').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    if ($('#btn-crop-recording').hasClass('cropping')) {
                        $('#btn-crop-recording').click();
                    }

                    console.log(controller.plugins.playback.player.state);
                    if (controller.plugins.playback.player.state === 'playing') {
                        $(this).find('.fa').removeClass('fa-pause').addClass('fa-play');
                        controller.plugins.playback.player.pause();
                    } else if (controller.plugins.playback.player.state === 'idle') {
                        $(this).find('.fa').removeClass('fa-play').addClass('fa-pause');
                        controller.plugins.playback.player.play();

                        $('#btn-crop-recording').removeClass('cropping');
                        $('#leap-playback-slider-container').removeClass('hidden');
                        $('#leap-playback-crop-slider-container').addClass('hidden');
                    }
                });

                $('#btn-crop-recording').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
                        if (controller.plugins.playback.player.state === 'playing') {
                            $('#btn-toggle-playback').click();
                        }

                        if ($(this).hasClass('cropping')) {
                            $('#leap-playback-slider').slider('destroy');
//                            var crops = {left: controller.plugins.playback.player.recording.leftCropPosition, right: controller.plugins.playback.player.recording.rightCropPosition};
//                            console.log(crops);
                            initPlaybackSlider();

                            $(this).removeClass('cropping');
                            $('#leap-playback-slider-container').removeClass('hidden');
                            $('#leap-playback-crop-slider-container').addClass('hidden');
                        } else {
                            $(this).addClass('cropping');
                            $('#leap-playback-slider-container').addClass('hidden');
                            $('#leap-playback-crop-slider-container').removeClass('hidden');

//                            var frameLength = Math.max(controller.plugins.playback.player.recording.frameData.length - 1, 0);
//                            console.log(controller.plugins.playback.player.recording.leftCropPosition, controller.plugins.playback.player.recording.rightCropPosition);

                            var currentCropValues;
                            $('#leap-playback-crop-slider').slider({
                                min: 0,
                                max: controller.plugins.playback.player.recording.rightCropPosition,
                                value: [0, controller.plugins.playback.player.recording.rightCropPosition]
                            });

                            $('#leap-playback-crop-slider').unbind('slide').bind('slide', function (event) {
//                                console.log(event.value);
                                var cropPositions = {left: controller.plugins.playback.player.recording.leftCropPosition, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition, 0)};
                                if (!currentCropValues) {
                                    currentCropValues = cropPositions;
                                } else {
                                    if (parseInt(currentCropValues.left) !== parseInt(cropPositions.left)) {
                                        controller.plugins.playback.player.setFrameIndex(parseInt(event.value[0], 10));
                                        controller.plugins.playback.player.recording.leftCrop();
                                    } else if (parseInt(currentCropValues.right) !== parseInt(cropPositions.right)) {
                                        controller.plugins.playback.player.setFrameIndex(parseInt(event.value[1], 10));
                                        controller.plugins.playback.player.recording.rightCrop();
                                    }
                                    currentCropValues = {left: event.value[0], right: event.value[1]};
                                }
                            });
                        }
                    }
                });
            }
        </script>

    </body>
</html>