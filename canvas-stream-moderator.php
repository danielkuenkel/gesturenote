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

        <script src="//cdn.webrtc-experiment.com/getScreenId.js"></script>
        <script src="muaz-khan/screen.js"></script>
        <script src="//cdn.webrtc-experiment.com/firebase.js"></script>

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
    <body id="pageBody" data-spy="scroll" data-target=".navbar">

        <!-- externals -->
        <div id="alerts"></div>

        <div class="btn-group">
            <button type="button" id="btn-start-screen-sharing" class="btn btn-info">Start Screensharing</button>
            <button type="button" id="btn-stop-screen-sharing" class="btn btn-warning disabled">Stop Screensharing</button>
        </div>
        
        <video id="savedVideo" src=""></video>

        <!--<button class="btn" onclick="openExtension('https://chrome.google.com/webstore/detail/ajhifddimkapgcifgcodmmfdlknahffk')" id="install-button">Add to Chrome</button>-->


        <div class="root" id="scenario" style="width: 100%;">

            <div style="position: absolute; width: 100%; height:auto;">
                <div id="scene-container" class="text-center" style="position: absolute; width: 100%; height:auto; overflow:auto" allowtransparency>
                    <iframe id="webframe" src="https://pidoco.com/rabbit/api/prototypes/98189/pages/page0001.xhtml?mode=sketched&api_key=WM22VGXsa0mwk5AAS0bLXzlBXyO509GEBKuOAfVb" frameborder="0" style="display: block; background: #fff; border: none; height: 100vh; width: 100vw;" height="100%" width="100%" scrolling="yes" ></iframe>
                </div>
            </div>
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

            var checkInterval;
            function onAllExternalsLoadedSuccessfully() {
                console.log('all externals loaded');

                var screen = new Screen('screen-unique-id'); // argument is optional

                var screenSharingRecorder = null;
                var recordedChunks = [];

                screen.onaddstream = function (event) {
//                    document.body.appendChild(e.video);
                    console.log('on add stream', event);
                    screenSharingRecorder = new MediaRecorder(event.stream);

                    screenSharingRecorder.ondataavailable = function (event) {
                        console.log('on data available');
                        recordedChunks.push(event.data);
                    };
                    
                    screenSharingRecorder.onstop = function (event) {
                        console.log('Stopped and save recording, state = ' + screenSharingRecorder.state + ', ' + new Date());
                        var blob = new Blob(recordedChunks, {'type': 'video/webm;codecs=vp9'});
                        recordedChunks = [];
                        var docURL = URL.createObjectURL(blob);
                        $('#savedVideo').attr('src', docURL);
                    };

                    screenSharingRecorder.onstart = function () {
                        console.log('Start recording ... ' + new Date());
                    };
                    
                    screenSharingRecorder.onerror = function (event) {
                        console.log('Error: ', event);
                    };

                    screenSharingRecorder.onwarning = function (event) {
                        console.log('Warning: ' + event);
                    };
                    screenSharingRecorder.start(5000);
                };

                screen.onuserleft = function (event) {
                    console.log('on user left', event);
                };

                screen.check();

                $('#btn-start-screen-sharing').on('click', function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
                        $(this).addClass('disabled');
                        $('#btn-stop-screen-sharing').removeClass('disabled');
                        screen.share();
                    }
                });

                $('#btn-stop-screen-sharing').on('click', function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
                        $(this).addClass('disabled');
                        $('#btn-start-screen-sharing').removeClass('disabled');
                        if(screenSharingRecorder.state !== 'inactive') {
                            screenSharingRecorder.stop();
                        }
                        screen.leave();

                    }
                });
            }


//            function checkInstalledExtension() {
//                console.log(chrome);
////                var myPort = chrome.extension.connect('ajhifddimkapgcifgcodmmfdlknahffk', {test: 'test'});
//                console.log('checkInstalledExtension');
//                if (chrome.app.isInstalled) {
//                    clearInterval(checkInterval);
//                    document.getElementById('install-button').style.display = 'none';
//                } else {
//                    console.log('chrome extension not installed');
//                }
////                checkInterval = setTimeout(checkInstalledExtension(), 100000);
//
//
//            }

            function openExtension(url) {
                var win = window.open(url, '_blank');
                win.focus();
            }

            function checkScreenSharingExtension() {
                var isChrome = !!navigator.webkitGetUserMedia;

                // DetectRTC.js - https://github.com/muaz-khan/WebRTC-Experiment/tree/master/DetectRTC
                // Below code is taken from RTCMultiConnection-v1.8.js (http://www.rtcmulticonnection.org/changes-log/#v1.8)
                var DetectRTC = {};

                (function () {

                    var screenCallback;

                    DetectRTC.screen = {
                        chromeMediaSource: 'screen',
                        getSourceId: function (callback) {
                            if (!callback)
                                throw '"callback" parameter is mandatory.';
                            screenCallback = callback;
                            window.postMessage('get-sourceId', '*');
                        },
                        isChromeExtensionAvailable: function (callback) {
                            if (!callback)
                                return;

                            if (DetectRTC.screen.chromeMediaSource == 'desktop')
                                return callback(true);

                            // ask extension if it is available
                            window.postMessage('are-you-there', '*');

                            setTimeout(function () {
                                if (DetectRTC.screen.chromeMediaSource == 'screen') {
                                    callback(false);
                                } else
                                    callback(true);
                            }, 2000);
                        },
                        onMessageCallback: function (data) {
                            if (!(typeof data == 'string' || !!data.sourceId))
                                return;

                            console.log('chrome message', data);

                            // "cancel" button is clicked
                            if (data == 'PermissionDeniedError') {
                                DetectRTC.screen.chromeMediaSource = 'PermissionDeniedError';
                                if (screenCallback)
                                    return screenCallback('PermissionDeniedError');
                                else
                                    throw new Error('PermissionDeniedError');
                            }

                            // extension notified his presence
                            if (data == 'rtcmulticonnection-extension-loaded') {
                                if (document.getElementById('install-button')) {
                                    document.getElementById('install-button').parentNode.innerHTML = '<strong>Great!</strong> <a href="https://chrome.google.com/webstore/detail/screen-capturing/ajhifddimkapgcifgcodmmfdlknahffk" target="_blank">Google chrome extension</a> is installed.';
                                }
                                DetectRTC.screen.chromeMediaSource = 'desktop';
                            }

                            // extension shared temp sourceId
                            if (data.sourceId) {
                                DetectRTC.screen.sourceId = data.sourceId;
                                if (screenCallback)
                                    screenCallback(DetectRTC.screen.sourceId);
                            }
                        },
                        getChromeExtensionStatus: function (callback) {
                            if (!!navigator.mozGetUserMedia)
                                return callback('not-chrome');

                            var extensionid = 'ajhifddimkapgcifgcodmmfdlknahffk';

                            var image = document.createElement('img');
                            image.src = 'chrome-extension://' + extensionid + '/icon.png';
                            image.onload = function () {
                                DetectRTC.screen.chromeMediaSource = 'screen';
                                window.postMessage('are-you-there', '*');
                                setTimeout(function () {
                                    if (!DetectRTC.screen.notInstalled) {
                                        callback('installed-enabled');
                                    }
                                }, 2000);
                            };
                            image.onerror = function () {
                                DetectRTC.screen.notInstalled = true;
                                callback('not-installed');
                            };
                        }
                    };

                    // check if desktop-capture extension installed.
                    if (window.postMessage && isChrome) {
                        DetectRTC.screen.isChromeExtensionAvailable();
                    }
                })();

                DetectRTC.screen.getChromeExtensionStatus(function (status) {
                    if (status == 'installed-enabled') {
                        if (document.getElementById('install-button')) {
                            document.getElementById('install-button').parentNode.innerHTML = '<strong>Great!</strong> <a href="https://chrome.google.com/webstore/detail/screen-capturing/ajhifddimkapgcifgcodmmfdlknahffk" target="_blank">Google chrome extension</a> is installed.';
                        }
                        DetectRTC.screen.chromeMediaSource = 'desktop';
                    }
                });

                window.addEventListener('message', function (event) {
                    if (event.origin != window.location.origin) {
                        return;
                    }

                    DetectRTC.screen.onMessageCallback(event.data);
                });

                console.log('current chromeMediaSource', DetectRTC.screen.chromeMediaSource);
            }
        </script>
    </body>
</html>
