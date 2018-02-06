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
        <!--<link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/apdfllckaahabafndbhieahigkjlhalf">-->
        <!--<link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/ajhifddimkapgcifgcodmmfdlknahffk">-->
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">

        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>
        <script src="js/resumable/resumable.js"></script>

        <script src="js/chance.min.js"></script>
        <!--<script src="color-thief/color-thief.js"></script>-->
        <script src="js/sha512.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/forms.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/refreshSession.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/language.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>    
        <script src="js/ajax.js"></script>

<!--        <script src="//cdn.webrtc-experiment.com/getScreenId.js"></script>
        <script src="muaz-khan/screen.js"></script>
        <script src="//cdn.webrtc-experiment.com/firebase.js"></script>-->

<!--<script src="js/gesture.js"></script>-->
<!--<script src="js/joint-selection.js"></script>-->
<!--        <script src="js/study-execution.js"></script>
<script src="js/study-execution-moderator.js"></script>
<script src="js/study-execution-moderator-save.js"></script>-->
<!--<script src="js/upload-queue.js"></script>-->

        <!-- streaming -->
        <script src="js/andyet/simplewebrtcbundle.js"></script>
        <!--<script src="js/peerConnectionSharing.js"></script>-->
        <!--<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>-->

        <!-- gesture recorder sources -->
<!--        <script src="js/gesture-recorder.js"></script>
        <script src="https://cdn.WebRTC-Experiment.com/RecordRTC.js"></script>
        <script src="https://cdn.webrtc-experiment.com/gumadapter.js"></script>
        <script src="https://cdn.webrtc-experiment.com/RecordRTC/Whammy.js"></script>-->
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar">

        <!-- externals -->
        <div id="alerts"></div>

        <!--        <div class="btn-group">
                    <button type="button" id="btn-start-screen-sharing" class="btn btn-info">Start Screensharing</button>
                    <button type="button" id="btn-stop-screen-sharing" class="btn btn-warning disabled">Stop Screensharing</button>
                </div>-->

        <!--<video id="savedVideo" src=""></video>-->
        <button type="button" class="btn btn-default" id="btn-start-screensharing">Screensharing starten</button>
        <button type="button" class="btn btn-default hidden" id="btn-stop-screensharing">Screensharing stoppen</button>

        <!--<button class="btn" onclick="openExtension('https://chrome.google.com/webstore/detail/ajhifddimkapgcifgcodmmfdlknahffk')" id="install-button">Add to Chrome</button>-->


        <!--        <div class="root" id="scenario" style="width: 100%;">
        
                    <div style="position: absolute; width: 100%; height:auto;">
                        <div id="scene-container" class="text-center" style="position: absolute; width: 100%; height:auto; overflow:auto" allowtransparency>
                            <iframe id="webframe" src="https://pidoco.com/rabbit/api/prototypes/98189/pages/page0001.xhtml?mode=sketched&api_key=WM22VGXsa0mwk5AAS0bLXzlBXyO509GEBKuOAfVb" frameborder="0" style="display: block; background: #fff; border: none; height: 100vh; width: 100vw;" height="100%" width="100%" scrolling="yes" ></iframe>
                        </div>
                    </div>
                </div>-->

        <div id="video-embed" class="" style="width: 400px; height: auto"></div>

        <script>
            $(document).ready(function () {
                checkDomain();
                keepSessionAlive();

                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    loadExternals(externals);
                });
            });

            var checkInterval;
            function onAllExternalsLoadedSuccessfully() {
                console.log('all externals loaded');
                window.open("study-execution-prototype-sharing.php", "Test");
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
                        shareScreen: true,
                        errorCallback: onError,
                        successCallback: onSuccess,
                        localStream: {audio: 'no', video: 'no', visualize: 'no'},
                        remoteStream: {audio: 'no', video: 'no'}
                    };

                    peerConnection = new PeerConnectionSharing(false);
                    peerConnection.initialize(callerOptions);
                }
            }

            $('#btn-start-screensharing').unbind('click').bind('click', function (event) {
                event.preventDefault();
//                if(!peerConnection) {
                peerConnection.shareScreen(onError, onSuccess);
//                } else {
//                    peerConnection.joinRoom('rtcToken');
//                    peerConnection.shareScreen(onError, onSuccess);
//                    peerConnection.sendMessage('reinitializeScreenSharing');
//                }
            });

            function onError(error) {
                console.log(error);
            }

            function onSuccess() {
                $('#btn-start-screensharing').addClass('hidden');
                $('#btn-stop-screensharing').removeClass('hidden');
                console.log('on success');
                peerConnection.startScreenRecording();
            }

            $('#btn-stop-screensharing').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (peerConnection) {
                    peerConnection.stopShareScreen();
                    $('#btn-start-screensharing').removeClass('hidden');
                    $('#btn-stop-screensharing').addClass('hidden');
                    peerConnection.stopScreenRecording(function (objectURL) {
                        var video = document.createElement('video');
                        $(video).attr('src', objectURL);
                        $('#video-embed').append(video);
                    }, false);
//                    peerConnection.leaveRoom();
                }
            });
        </script>
    </body>
</html>
