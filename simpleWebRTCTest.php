<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $lang->gestureNote ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- third party sources -->
        <link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/greensock/TweenMax.min.js"></script>

        <script src="js/andyet/simplewebrtc-with-adapter.bundle.js"></script>

        <!-- gesturenote specific sources -->
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">

        <script src="js/ajax.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/globalFunctions.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="template-subpages"></div>


        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb"style="margin-top: 40px">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li class="active"><?php echo $lang->breadcrump->informations ?></li>
                </ol>
            </div>
        </div>


        <!-- Container (Landing Section) -->
        <div class="container">
            <button class="btn btn-default" id="startButton">Start</button>
            <button class="btn btn-default" id="callButton">Call</button>
            <button class="btn btn-default" id="hangupButton">Hangup</button>
        </div>

        <div class="container mainContent" style="margin-top: 0px">
            <video id="localVideo" autoplay muted></video>
            <video id="remoteVideo" autoplay></video>
        </div>

        <script>
            $(document).ready(function () {
                checkDomain();
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();

                var iceServers = [
                    {
                        'urls': 'stun:stun.l.google.com:19302'
                    },

                    {
                        urls: 'turn:numb.viagenie.ca',
                        username: 'danielkuenkel%40googlemail.com',
                        credential: 'jyjYhjFdVXygdGKJHHt6EVV9asapAms'
                    }
                ];

                var webrtc = new SimpleWebRTC({
                    // the id/element dom element that will hold "our" video
                    localVideoEl: 'localVideo',
                    // the id/element dom element that will hold remote videos
                    remoteVideosEl: 'remotesVideos',
                    // immediately ask for camera access
                    autoRequestMedia: true,
                    peerConnectionConfig: {'iceServers': iceServers},
                });

                webrtc.on('readyToCall', function () {
                    // you can name it anything
                    webrtc.joinRoom('test5690380958230948230958409458');
                });
            }
        </script>

    </body>
</html>