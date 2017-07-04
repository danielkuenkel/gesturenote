<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GestureNote</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/study-preview.css">
        <link rel="stylesheet" href="css/gesture.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">

        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>
        <script src="resumable/resumable.js"></script>

        <script src="js/chance.min.js"></script>
        <script src="color-thief/color-thief.js"></script>
        <script src="js/sha512.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/refreshSession.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/language.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-tester.js"></script>       
        <script src="js/ajax.js"></script> 
        <!--<script src="js/gesture.js"></script>-->
        <!--<script src="js/forms.js"></script>-->
        <!--<script src="js/joint-selection.js"></script>-->
        <!--<script src="js/study-execution.js"></script>-->
        <!--<script src="js/study-execution-tester.js"></script>-->
        <!--<script src="js/study-execution-tester-save.js"></script>-->
        <!--<script src="js/upload-queue.js"></script>-->

        <!-- streaming -->
        <script src="simplewebrtc/simplewebrtc.bundle.js"></script>
        <script src="js/peerConnection.js"></script>

        <!-- gesture recorder sources -->
        <!--<script src="js/gesture-recorder.js"></script>-->
<!--        <script src="https://cdn.WebRTC-Experiment.com/RecordRTC.js"></script>
        <script src="https://cdn.webrtc-experiment.com/gumadapter.js"></script>
        <script src="https://cdn.webrtc-experiment.com/RecordRTC/Whammy.js"></script>-->
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-gesture"></div>
        <div id="template-previews"></div>
        <div id="template-gesture-recorder"></div>

        <script src="//cdn.webrtc-experiment.com/getScreenId.js"></script>
        <script src="//cdn.webrtc-experiment.com/screen.js"></script>
        <script src="//cdn.webrtc-experiment.com/firebase.js"></script>

        <div id="video-embed" class="embed-responsive embed-responsive-16by9"></div>

        <script>
            $(document).ready(function () {
                checkDomain();
                keepSessionAlive();

                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
//                    externals.push(['#template-gesture', PATH_EXTERNALS + 'template-gesture.php']);
//                    externals.push(['#template-previews', PATH_EXTERNALS + 'template-previews.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                var screen = new Screen('screen-unique-id'); // argument is optional

                screen.onaddstream = function (e) {
                    console.log('on add screen');
                    var video = e.video;
                    $('#video-embed').append(video);
                };
                
                screen.onuserleft = function (userid) {
                    var video = $('#video-embed').find('#' + userid);
                    if (video)
                        $('#video-embed').empty();
                };

                screen.check();

            }
        </script>
    </body>
</html>