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
        <script src="js/leapjs/leap-0.6.4.min.js"></script>
        <script src="js/leapjs/leap-plugins-0.1.12.min.js"></script>
        <script src="js/three/three.min.js"></script>
        <script src="js/riggedHand/leap.rigged-hand-0.1.7.js"></script>
        <script src="js/leapjs-playback/leap.playback-0.2.1.js"></script>
        <script src="js/gestureRecorder/leapRecorder.js"></script>
        
        <!-- gesture recognizers -->
        <script src="js/gestureRecognizer/leapStandardRecognizer.js"></script>

        <!-- bootstrap slider -->
        <link rel="stylesheet" href="js/bootstrap-slider/css/bootstrap-slider.css">
        <script src="js/bootstrap-slider/js/bootstrap-slider.js"></script>
    </head>

    <body id="pageBody" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-general"></div>


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
                    <li><a class="breadcrump-btn" id="">Leap Motion Daten Demonstrator</a></li>
                </ol>
            </div>
        </div>

        <div class="container mainContent" style="margin-top: 0px">
            <div id="alert-hints">
                <div class="alert-space alert-please-wait"></div>
            </div>

            <div class="btn-group">
                <button class="btn btn-default" id="btn-start-recording">RECORD</button>
                <button class="btn btn-default disabled" id="btn-stop-recording">STOP RECORD</button>
                <button class="btn btn-default disabled" id="btn-crop-recording">CROP</button>
                <button class="btn btn-default disabled btn-toggle-playback"><i class="fa fa-play"></i></button>
            </div>
            <div class="btn-group">
                <button class="btn btn-default" id="btn-download-recording-as-json">DOWNLOAD JSON</button>
                <button class="btn btn-default" id="btn-download-recording-as-compressed">DOWNLOAD COMPRESSED</button>
                <button class="btn btn-default" id="btn-load-recording">LOAD FILE</button>
            </div>
            <form enctype="multipart/form-data" id="upload-leap-recording" class="hidden">
                <input class="fileUpload hidden" name="image" type="file" accept="application/json, .lz" />
            </form>
            <div class="row">
                <div class="col-xs-12">
                    <div id="playback-controls">
                        <div id="dev-leap-playback-slider-container" class="leap-playback-slider-container hidden" style="width: 100%">
                            <input id="leap-playback-slider" data-slider-id="sliderLeap" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                        </div>
                        <div id="dev-leap-playback-crop-slider-container" class="leap-playback-slider-container hidden" style="width: 100%">
                            <input id="leap-playback-crop-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="[0,100]" data-slider-tooltip="hide" />
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!--        <div class="container">
                    <div class="row">
                        <div class="col-xs-6 col-md-4 col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-heading">test</div>
                                <div class="panel-body">
                                    <div class="embed-responsive embed-responsive-4by3">
                                        <div id="renderArea" class="embed-responsive-item" ></div>
                                    </div>
        
                                </div>
                            </div>
        
                        </div>
                    </div>
                </div>-->


        <script>
            $(document).ready(function () {
//                initializeLeapMotion();
                initializeLeapMotionTracking();

                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                    loadExternals(externals);
                });
            });
            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
            }

            function initializeLeapMotion() {
                var options = {
                    offset: {x: 0, y: 200, z: 0},
                    previewOnly: true,
                    pauseOnHand: false,
                    autoplay: true,
                    initPlaybackControlsAfterRecord: true,
                    recordEmptyHands: true,
                    recording: 'uploads/000fbc0274032e4810b8801ee465a1306abece9fb3c5b001b283c0a385efc942a3af87d8c52bf6f7264e6a970aad99aa8cf99a765212d78cad701f129a40812b.lz',
                    overlays: $('#alert-hints'),
//                    renderTarget: $('#renderArea'),
                    recordElement: $('#btn-start-recording'),
                    stopRecordElement: $('#btn-stop-recording'),
                    playbackElement: $('.btn-toggle-playback'),
                    downloadJsonElement: $('#btn-download-recording-as-json'),
                    downloadCompressedElement: $('#btn-download-recording-as-compressed'),
                    loadRecordingElement: $('#btn-load-recording'),
                    loadInputElement: $('#upload-leap-recording'),
                    cropRecordElement: $('#btn-crop-recording'),
                    playbackSliderElement: $('#leap-playback-slider'),
                    cropSliderElement: $('#leap-playback-crop-slider')
                };
                new LeapRecorder(options); // destroy leap motion recorder instance via variable, e.g. lmr = new LeapMotionRecorder(options); lmr.destroy(); lmr = null;
            }

            function initializeLeapMotionTracking() {
                var leapRecognizer = new LeapStandardRecognizer(null);
            }
        </script>

    </body>
</html>