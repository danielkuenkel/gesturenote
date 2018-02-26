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

        <!-- leap -->
        <script src="js/leapjs/leap-0.6.4.min.js"></script>
        <script src="js/three/three.min.js"></script>
<!--        <script src="js/leapjs-playback/recording.js"></script>
        <script src="js/leapjs-playback/player.js"></script>-->
        <script src="//js.leapmotion.com/leap-plugins-0.1.12.min.js"></script>
        <script src="//js.leapmotion.com/leap.rigged-hand-0.1.7.min.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

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
        </div>

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

                (window.controller = new Leap.Controller)
                        .use('riggedHand')
                        .connect();

                $('#pageBody').find('canvas').css({top: '400px'});

                window.controller.on('connect', onConnect);
                function onConnect()
                {
                    clearAlerts($('.mainContent'));
                    console.log("controller connected ");
                }

                window.controller.on('frame', onFrame);
                function onFrame(frame)
                {
                    var hand = frame.hands[0];
                    if (hand) {
//                        var handMesh = frame.hands[0].data('riggedHand.mesh');
//                        handMesh.scenePosition(hand.indexFinger.tipPosition, sphere.position);
//                        var screenPosition = handMesh.screenPosition(hand.fingers[1].tipPosition);
                        console.log(hand);
//                        cursor.style.left = screenPosition.x
//                        cursor.style.bottom = screenPosition.y
//                    console.log("Frame event for frame ");
                    }
                }

                window.controller.on('deviceAttached', onAttached);
                function onAttached()
                {
                    clearAlerts($('.mainContent'));
                    console.log("Device attached");
                }

                window.controller.on('deviceRemoved', onDeviceRemoved);
                function onDeviceRemoved()
                {
                    appendAlert($('.mainContent'), ALERT_PLEASE_WAIT);
                    console.log("device removed ");
                }

                window.controller.on('deviceStopped', onDeviceStopped);
                function onDeviceStopped()
                {
                    appendAlert($('.mainContent'), ALERT_PLEASE_WAIT);
                    console.log("device stopped ");
                }

                window.controller.on('deviceStreaming', onDeviceStreaming);
                function onDeviceStreaming()
                {
                    clearAlerts($('.mainContent'));
                    console.log("device streaming ");
                }
            }
        </script>

    </body>
</html>