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
        <link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/ajhifddimkapgcifgcodmmfdlknahffk">

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
        <script src="simplewebrtc/simplewebrtc.bundle.js"></script>
        <script src="js/peerConnection.js"></script>
        <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>

        <!-- gesture recorder sources -->
<!--        <script src="js/gesture-recorder.js"></script>
        <script src="https://cdn.WebRTC-Experiment.com/RecordRTC.js"></script>
        <script src="https://cdn.webrtc-experiment.com/gumadapter.js"></script>
        <script src="https://cdn.webrtc-experiment.com/RecordRTC/Whammy.js"></script>-->
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar">

        <!-- externals -->
        <!--<div id="alerts"></div>-->
        <div id="template-previews"></div>

        <!--        <div class="btn-group">
                    <button type="button" id="btn-start-screen-sharing" class="btn btn-info">Start Screensharing</button>
                    <button type="button" id="btn-stop-screen-sharing" class="btn btn-warning disabled">Stop Screensharing</button>
                </div>-->

        <!--<video id="savedVideo" src=""></video>-->

        <!--<button class="btn" onclick="openExtension('https://chrome.google.com/webstore/detail/ajhifddimkapgcifgcodmmfdlknahffk')" id="install-button">Add to Chrome</button>-->


        <div class="root" id="shared-scenario" style="width: 100%;">

            <div style="position: absolute; width: 100%; height:auto;">
                <div id="scene-container" class="text-center" style="position: absolute; width: 100%; height:auto; overflow:auto" allowtransparency>
                    <!--<iframe id="webframe" src="" frameborder="0" style="display: block; background: #fff; border: none; height: 100vh; width: 100vw;" height="100%" width="100%" scrolling="yes" ></iframe>-->
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                checkDomain();
                keepSessionAlive();

                checkLanguage(function () {
                    var externals = new Array();
//                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-previews', PATH_EXTERNALS + 'template-previews.php']);
                    loadExternals(externals);
                });

                window.onmessage = function (event) {
                    if (event.origin !== "https://gesturenote.de")
                        return;

                    console.log(event.data);
                    switch (event.data.message) {
                        case MESSAGE_TRIGGER_WOZ:
                            renderSceneItem(event.data.currentWOZScene);
                            break;
                    }
                };
            });

            var checkInterval;
            function onAllExternalsLoadedSuccessfully() {
                console.log('all externals loaded');

//                console.log(getLocalItem(STUDY));
                var query = getQueryParams(document.location.search);

                var phaseStepData = getLocalItem(query.phaseId + '.data');
                console.log(query.phaseId, phaseStepData);
                if (phaseStepData.scene) {
                    
                    var scene = getSceneById(phaseStepData.scene); // get the starting scene
                    renderSceneItem(scene);
                    console.log(scene);

//                    $('#shared-scenario').find('#webframe').attr('src', scene.data[0]);
                }
                return false;

//                initializeWOZConnection();
            }

            function renderSceneItem(scene) {
                if (scene && scene !== null) {
                    var sceneItem = $('#item-container-tester').find('#' + scene.type).clone().removeAttr('id');
                   $('#shared-scenario').find('#scene-container').empty().append(sceneItem);
//                    var currentPhaseData = getCurrentPhaseData();
//                    var helpData = getItemsForSceneId(currentPhaseData.help, scene.id);
//                    if (helpData && helpData.length > 0) {
//                        $(container).find('#btn-getting-help').removeClass('hidden');
//                    } else {
//                        $(container).find('#btn-getting-help').addClass('hidden');
//                    }

//                    var wozData = getItemsForSceneId(currentPhaseData.woz, scene.id);
//                    if (wozData && wozData.length > 0) {
//                        $(container).find('#btn-perform-gesture').removeClass('hidden');
////            $(container).find('#btn-done').addClass('hidden');
//                    } else {
//                        $(container).find('#btn-perform-gesture').addClass('hidden');
////            $(container).find('#btn-done').removeClass('hidden');
//                    }

                    $('#shared-scenario').find('#scene-container').css({backgroundColor: "rgb(255,255,255)"});
                    switch (scene.type) {
                        case SCENE_WEB:
                            sceneItem.attr('src', scene.data[0]);
                            break;
                        case SCENE_IMAGE:
                            sceneItem[0].onload = function () {
                                var image = sceneItem[0];
                                var colorThief = new ColorThief();
                                var dominantColor = colorThief.getColor(image);
                                $('#shared-scenario').find('#scene-container').css("backgroundColor", "rgb(" + dominantColor[0] + "," + dominantColor[1] + "," + dominantColor[2] + ")");
                            };
                            sceneItem[0].src = scene.data;
                            break;
                        case SCENE_PIDOCO:
                            sceneItem[0].src = scene.data;
                            break;
                        case SCENE_VIDEO_EMBED:
                            sceneItem.find('.videoContainer').addClass(scene.options[0] === 'ratio_16_9' ? 'embed-responsive-16by9' : 'embed-responsive-4by3');
                            sceneItem.find('.videoContainer').html(scene.data);
                            var video = $(sceneItem).find('iframe');
                            var src = video.attr('src');
                            video.attr('src', src + "?autoplay=1");
                            $(video).addClass('embed-responsive-item');
                            $('#shared-scenario').find('#scene-container').css("backgroundColor", "rgb(0,0,0)");
                            break;
                    }

// scene positioning
                    var containerOffsetTop = 0;
                    var generalPanelHeight = 0;
                    var study = getLocalItem(STUDY);


//        if(!previewModeEnabled === false) {
//            generalPanelHeight = 0;
//        }
//        console.log(containerOffsetTop);
                    sceneItem.css({marginTop: generalPanelHeight + 'px'});
                    // calcuation of the new window height if resizing the window
                    $(window).resize(function () {

                        var height;

//                        if (study.surveyType === TYPE_SURVEY_UNMODERATED) {
//                            height = $(window).height() - containerOffsetTop - generalPanelHeight;
//                        } else {
                            if (study.phase === TYPE_PHASE_ELICITATION && scene.type === SCENE_VIDEO_EMBED) {
                                height = $(window).height() - containerOffsetTop - generalPanelHeight - generalPanelHeight;
                            } else {
                                height = $(window).height() - generalPanelHeight;
                            }
//                        }

                        if (scene.type === SCENE_VIDEO_EMBED) {
                            var width;
                            if (scene.options[0] === 'ratio_16_9') {
                                width = height / 9 * 16;
                            } else {
                                width = height / 3 * 4;
                            }
                            width = Math.min($(window).width(), width);
                            sceneItem.width(width);
                        }

                        sceneItem.height(height);
                    }).resize();
                    return sceneItem;
                } 
//                else {
//                    $(container).find('#btn-refresh-scene').addClass('hidden');
//                }
            }

//            var wozConnection = null;
//            function initializeWOZConnection() {
//                if (!wozConnection) {
//                    var query = getQueryParams(document.location.search);
//                    var callerOptions = {
////                        target: $('#viewModerator').find('#pinnedRTC'),
////                        callerElement: $('#video-caller'),
//                        localVideoElement: '',
//                        remoteVideoElement: '',
//                        autoRequestMedia: false,
//                        enableWebcamStream: false,
//                        enableDataChannels: true,
//                        roomId: query.roomId + "WOZ"
////                        localStream: {audio: options.moderator.audio, video: options.moderator.video, visualize: options.moderator.visualizeStream},
////                        remoteStream: {audio: options.tester.audio, video: options.tester.video}
//                    };
//
//                    wozConnection = new PeerConnection(false);
//                    wozConnection.update(callerOptions);
//                    wozConnection.joinRoom(query.roomId);
////                    peerConnection.sendMessage('testNachricht', null);
//                }
//            }

        </script>
    </body>
</html>
