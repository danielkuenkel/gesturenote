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
        <!--<script src="js/gesture.js"></script>-->
        <!--<script src="js/joint-selection.js"></script>-->
<!--        <script src="js/study-execution.js"></script>
        <script src="js/study-execution-moderator.js"></script>
        <script src="js/study-execution-moderator-save.js"></script>-->
        <!--<script src="js/upload-queue.js"></script>-->

        <!-- streaming -->
<!--        <script src="simplewebrtc/simplewebrtc.bundle.js"></script>
        <script src="js/peerConnection.js"></script>-->
        <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>

        <!-- gesture recorder sources -->
<!--        <script src="js/gesture-recorder.js"></script>
        <script src="https://cdn.WebRTC-Experiment.com/RecordRTC.js"></script>
        <script src="https://cdn.webrtc-experiment.com/gumadapter.js"></script>
        <script src="https://cdn.webrtc-experiment.com/RecordRTC/Whammy.js"></script>-->
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <!--        <div id="template-gesture"></div>
                <div id="template-previews"></div>
                <div id="template-study"></div>-->

        <!-- modals -->
        <div id="custom-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">

                </div>
            </div>
        </div>

        <!--        <div style="position: fixed;top: 0;  width: 100%; z-index: 500">
                    <button class="btn-cancel btn btn-danger btn-block" style="border-radius: 0" id="btn-cancel"><span class="btn-text"><?php echo $lang->cancelStudy ?></span> <i class="fa fa-close"></i></button>
                </div>-->

        <!-- progress bar -->
        <!--        <div id="progressTop" style="position: fixed; top: 34px; left: 0; right: 0">
                    <div class="progress" style="border-radius: 0px">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 0%">
                            0%
                        </div>
                    </div>
                </div>-->

        <canvas>test</canvas>
        <video autoplay></video>

        <!-- Container (Panel Section) -->
        <div class="mainContent" id="mainContent" style="padding:20px; margin-top:60px">
            <div id="viewModerator">
                <div id="pinnedRTC" style="position: fixed">
                    <!--                    <div id="rtc-controls" class="btn-group" style="position: absolute; top: 0; left: 0;">
                                            <button type="button" id="btn-toggle-rtc-fixed" class="btn btn-link btn-no-shadow"><i class="glyphicon glyphicon-new-window"></i></button>
                                        </div>-->
                </div>

                <div id="phase-content">
                    <!--<canvas id="canvas">test</canvas>-->
                </div>
            </div>
        </div>

        <!--<div id="video-caller-holder" class="hidden">-->
        <!--<div id="video-caller" style="width: 100%">-->
        <!--<div id="remote-stream" class="rtc-remote-container rtc-stream"></div>-->
        <!--<div class="rtc-local-container">-->
        <!--<video autoplay id="local-stream" class="rtc-stream" style=""></video>-->
        <!--</div>-->
        <!--</div>-->
    </div>


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

        function onAllExternalsLoadedSuccessfully() {

            console.log('all externals loaded');
            initPeerConnection("test");
        }

        function initPeerConnection(rtcToken) {
            var canvas = document.querySelector('canvas');
            var video = document.querySelector('video');
            var ctx = canvas.getContext("2d");
            ctx.font = "30px Arial";
            ctx.fillText("Hello World", 10, 50);

            console.log(canvas, video);

            var pc1;
            var pc2;
            var offerOptions = {
                offerToReceiveAudio: 1,
                offerToReceiveVideo: 1
            };

            var startTime;

            video.addEventListener('loadedmetadata', function () {
                console.log('Remote video videoWidth: ' + this.videoWidth +
                        'px,  videoHeight: ' + this.videoHeight + 'px');
            });

            video.onresize = function () {
                console.log('Remote video size changed to ' +
                        video.videoWidth + 'x' + video.videoHeight);
                // We'll use the first onsize callback as an indication that video has started
                // playing out.

                if (startTime) {
                    var elapsedTime = window.performance.now() - startTime;
                    console.log('Setup time: ' + elapsedTime.toFixed(3) + 'ms');
                    startTime = null;
                }
            };

            var stream = canvas.captureStream();
            console.log('Got stream from canvas');

            call();

            function call() {
                console.log('Starting call');
                startTime = window.performance.now();
                var videoTracks = stream.getVideoTracks();
                var audioTracks = stream.getAudioTracks();
                if (videoTracks.length > 0) {
                    console.log('Using video device: ' + videoTracks[0].label);
                }
                if (audioTracks.length > 0) {
                    console.log('Using audio device: ' + audioTracks[0].label);
                }
                var servers = null;
                pc1 = new RTCPeerConnection(servers);
                console.log('Created local peer connection object pc1');
                pc1.onicecandidate = function (event) {
                    onIceCandidate(pc1, event);
                };

                pc2 = new RTCPeerConnection(servers);
                console.log('Created remote peer connection object pc2');

                pc2.onicecandidate = function (event) {
                    onIceCandidate(pc2, event);
                };
                pc1.oniceconnectionstatechange = function (event) {
                    onIceStateChange(pc1, event);
                };
                pc2.oniceconnectionstatechange = function (event) {
                    onIceStateChange(pc2, event);
                };
                pc2.ontrack = gotRemoteStream;

                stream.getTracks().forEach(
                        function (track) {
                            pc1.addTrack(
                                    track,
                                    stream
                                    );
                        }
                );
                console.log('Added local stream to pc1');

                console.log('pc1 createOffer start');
                pc1.createOffer(onCreateOfferSuccess, onCreateSessionDescriptionError,
                        offerOptions);
            }

            function onCreateSessionDescriptionError(error) {
                console.log('Failed to create session description: ' + error.toString());
            }

            function onCreateOfferSuccess(desc) {
                console.log('Offer from pc1\n' + desc.sdp);
                console.log('pc1 setLocalDescription start');
                pc1.setLocalDescription(desc, function () {
                    onSetLocalSuccess(pc1);
                }, onSetSessionDescriptionError);
                console.log('pc2 setRemoteDescription start');
                pc2.setRemoteDescription(desc, function () {
                    onSetRemoteSuccess(pc2);
                }, onSetSessionDescriptionError);
                console.log('pc2 createAnswer start');
                // Since the 'remote' side has no media stream we need
                // to pass in the right constraints in order for it to
                // accept the incoming offer of audio and video.
                pc2.createAnswer(onCreateAnswerSuccess, onCreateSessionDescriptionError);
            }

            function onSetLocalSuccess(pc) {
                console.log(getName(pc) + ' setLocalDescription complete');
            }

            function onSetRemoteSuccess(pc) {
                console.log(getName(pc) + ' setRemoteDescription complete');
            }

            function onSetSessionDescriptionError(error) {
                console.log('Failed to set session description: ' + error.toString());
            }

            function gotRemoteStream(e) {
                if (video.srcObject !== e.streams[0]) {
                    video.srcObject = e.streams[0];
                    console.log('pc2 received remote stream');
                }
            }

            function onCreateAnswerSuccess(desc) {
                console.log('Answer from pc2:\n' + desc.sdp);
                console.log('pc2 setLocalDescription start');
                pc2.setLocalDescription(desc, function () {
                    onSetLocalSuccess(pc2);
                }, onSetSessionDescriptionError);
                console.log('pc1 setRemoteDescription start');
                pc1.setRemoteDescription(desc, function () {
                    onSetRemoteSuccess(pc1);
                }, onSetSessionDescriptionError);
            }

            function onIceCandidate(pc, event) {
                getOtherPc(pc).addIceCandidate(event.candidate)
                        .then(
                                function () {
                                    onAddIceCandidateSuccess(pc);
                                },
                                function (err) {
                                    onAddIceCandidateError(pc, err);
                                }
                        );
                console.log(getName(pc) + ' ICE candidate: \n' + (event.candidate ?
                        event.candidate.candidate : '(null)'));
            }

            function onAddIceCandidateSuccess(pc) {
                console.log(getName(pc) + ' addIceCandidate success');
            }

            function onAddIceCandidateError(pc, error) {
                console.log(getName(pc) + ' failed to add ICE Candidate: ' + error.toString());
            }

            function onIceStateChange(pc, event) {
                if (pc) {
                    console.log(getName(pc) + ' ICE state: ' + pc.iceConnectionState);
                    console.log('ICE state change event: ', event);
                }
            }

            function getName(pc) {
                return (pc === pc1) ? 'pc1' : 'pc2';
            }

            function getOtherPc(pc) {
                return (pc === pc1) ? pc2 : pc1;
            }
        }
    </script>
</body>
</html>
