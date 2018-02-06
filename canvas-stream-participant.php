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
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">

        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>
        <script src="js/resumable/resumable.js"></script>

        <script src="js/chance.min.js"></script>
        <script src="js/color-thief/color-thief.js"></script>
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
        <script src="https://simplewebrtc.com/latest-v2.js"></script>
        <!--<script src="js/peerConnectionSharing.js"></script>-->

        <!-- gesture recorder sources -->
        <!--<script src="js/gesture-recorder.js"></script>-->
<!--        <script src="https://cdn.WebRTC-Experiment.com/RecordRTC.js"></script>
        <script src="https://cdn.webrtc-experiment.com/gumadapter.js"></script>
        <script src="https://cdn.webrtc-experiment.com/RecordRTC/Whammy.js"></script>-->

        <style>
            /*            video {
                            display: table;
                            margin: 0 auto;
                        }*/
        </style>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-gesture"></div>
        <div id="template-previews"></div>
        <div id="template-gesture-recorder"></div>

<!--        <script src="//cdn.webrtc-experiment.com/getScreenId.js"></script>
        <script src="//cdn.webrtc-experiment.com/screen.js"></script>
        <script src="//cdn.webrtc-experiment.com/firebase.js"></script>-->

        <div id="video-embed" class="" style="width: 400px; height: auto"></div>

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
                initializePeerConnection();
            }

            var syncPhaseStep = false;
            var peerConnection = null;
            function initializePeerConnection() {
                if (!peerConnection) {
                    var query = getQueryParams(document.location.search);
                    var callerOptions = {
//                        target: $('#viewModerator').find('#pinnedRTC'),
//                        callerElement: $('#video-caller'),
                        localVideoElement: '',
                        remoteVideoElement: '',
                        sharingVideoElement: '#video-embed',
                        enableWebcamStream: false,
                        enableDataChannels: false,
                        autoRequestMedia: true,
                        roomId: "rtcToken",
                        localStream: {audio: 'no', video: 'no', visualize: 'no'},
                        remoteStream: {audio: 'no', video: 'no'}
                    };

                    peerConnection = new PeerConnectionSharing(false);


//                    $(peerConnection).unbind('localScreenAdded').bind('localScreenAdded', function(event, video) {
//                        $('#video-embed').empty().append(video);
//                        console.log(video);
//                    });
//                    
//                    $(peerConnection).unbind('localScreenRemoved').bind('localScreenRemoved', function(event) {
//                        $('#video-embed').empty();
//                    });

//                    $(peerConnection).unbind('reinitializeScreenSharing').bind('reinitializeScreenSharing', function (event) {
//                        console.log('reinitializeScreenSharing');
//                        peerConnection.leaveRoom();
//                        peerConnection.joinRoom('rtcToken');
//                    });
                    peerConnection.initialize(callerOptions);
//                    $(peerConnection).unbind('testNachricht').bind('testNachricht', function (event, payload) {
//                        console.log('on test message');
//                        $('#savedVideo').attr('src', payload.videoDocURL);
//                    });
                }
            }
        </script>
    </body>
</html>