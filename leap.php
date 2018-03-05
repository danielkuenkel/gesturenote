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
        <script src="//js.leapmotion.com/leap-0.6.3.js"></script>
        <!--<script src="js/leapjs-playback/recorder/javascripts/lib/leap-0.6.0-beta2-master.js"></script>-->
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
                    recording: 'js/leapjs-playback/recorder/recordings/leap-playback-recording-55fps_1.json',
                    requiredProtocolVersion: 6,
                    pauseOnHand: true
                });
//                controller.use('handHold');
                controller.use('transform', {
                    position: new THREE.Vector3(0, -150, 0)
                });
                controller.use('riggedHand', {
                    checkWebGL: true
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
                    var button = $(this);
                    if (!$(button).hasClass('disabled')) {
                        $(button).addClass('disabled');
                        $('#btn-stop-recording').removeClass('disabled');
                        controller.plugins.playback.player.record();
                    }
                });

//                $('#btn-stop-recording').unbind('click').bind('click', function (event) {
//                    event.preventDefault();
//                    var button = $(this);
//                    if (!$(button).hasClass('disabled')) {
//                        $(button).addClass('disabled');
//                        $('#btn-start-recording').removeClass('disabled');
//                        recording = false;
//
////                        console.log(recordings.framesData);
////                        setMetaData(recordings.framesData);
////                        console.log(packedFrameData(recordings.framesData));
////                        controller.plugins.riggedHand.renderRecordedFrames(packedFrameData(recordings.framesData), metadata.framerate);
////
////                        if (!riggedHandPlayer) {
////                            var options = {renderArea: $('#renderArea'), recording: recordings.framesData};
////                            riggedHandPlayer = new LeapMotionPlayer(options);
////                        }
//
////                        saveFrames('json', recordings.framesData);
////                        recordings.framesData = [];
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
                                });
                            };
                            fr.readAsText($(this)[0].files[0]);
                        }
                    }
                });
            }
        </script>

    </body>
</html>