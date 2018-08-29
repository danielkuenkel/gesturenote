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

        <script src="js/resumable/resumable.js"></script>
        <script src="js/chance.min.js"></script>
        <script src="js/color-thief/color-thief.js"></script>
        <script src="js/sha512.js"></script>

        <!-- gesturenote specific sources -->
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/study-preview.css">
        <link rel="stylesheet" href="css/gesture.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">

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
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar">

        <div id="template-previews"></div>

        <div class="root" id="shared-scenario" style="width: 100%;">

            <div style="position: absolute; width: 100%; height:auto;">
                <div id="scene-container" class="text-center" style="position: absolute; width: 100%; height:auto; overflow:auto" allowtransparency></div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                checkDomain();
                keepSessionAlive();

                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#template-previews', PATH_EXTERNALS + 'template-previews.php']);
                    loadExternals(externals);
                });

                window.onmessage = function (event) {
                    if (event.origin !== "https://gesturenote.de")
                        return;

                    switch (event.data.message) {
                        case MESSAGE_RENDER_SCENE:
                            renderSceneItem(event.data.scene);
                            break;
                    }
                };
            });

            function onAllExternalsLoadedSuccessfully() {
                var query = getQueryParams(document.location.search);
                var phaseStepData = getLocalItem(query.phaseId + '.data');
                var startScene = null;
                switch (query.type) {
                    case SCENARIO:
                        startScene = getSceneById(phaseStepData.scene);
                        break;
                    case IDENTIFICATION:
                        startScene = getSceneById(phaseStepData.identification[0].transitionScenes[0].sceneId);
                        break;
                    case EXPLORATION:
                        startScene = getSceneById(phaseStepData.exploration[0].transitionScenes[0].sceneId);
                        break;
                    case GESTURE_TRAINING:
                        startScene = getSceneById(phaseStepData.training[0].transitionScenes[0].sceneId);
                        break;
                    case FOCUS_GROUP_INTERVIEW:
                        startScene = getSceneById(phaseStepData.scenes[0]);
                        break;
                }

                console.log(query.phaseId, phaseStepData, startScene);
                renderSceneItem(startScene);
            }

            function renderSceneItem(scene) {
                $('#shared-scenario').find('#scene-container').empty();
                if (scene && scene !== null) {
                    var sceneItem = $('#item-container-tester').find('#' + scene.type).clone().removeAttr('id');
                    $('#shared-scenario').find('#scene-container').append(sceneItem);
                    $('#shared-scenario').find('#scene-container').css({backgroundColor: "rgb(255,255,255)"});

                    switch (scene.type) {
                        case SCENE_WEB:
                            sceneItem[0].src = scene.parameters.url;
                            break;
                        case SCENE_IMAGE:
                            sceneItem[0].onload = function () {
                                var image = sceneItem[0];
                                var colorThief = new ColorThief();
                                var dominantColor = colorThief.getColor(image);
                                $('#shared-scenario').find('#scene-container').css("backgroundColor", "rgb(" + dominantColor[0] + "," + dominantColor[1] + "," + dominantColor[2] + ")");
                            };
                            sceneItem[0].src = scene.parameters.url;
                            break;
                        case SCENE_PIDOCO:
                            sceneItem[0].src = scene.parameters.url;
                            break;
                        case SCENE_VIDEO_EMBED:
                            sceneItem.find('.videoContainer').addClass(scene.options[0] === 'ratio_16_9' ? 'embed-responsive-16by9' : 'embed-responsive-4by3');
                            sceneItem.find('.videoContainer').html(scene.parameters.url);
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

                    sceneItem.css({marginTop: generalPanelHeight + 'px'});
                    // calcuation of the new window height and resizing the window
                    $(window).resize(function () {

                        var height;
                        if (study.phase === TYPE_PHASE_ELICITATION && scene.type === SCENE_VIDEO_EMBED) {
                            height = $(window).height() - containerOffsetTop - generalPanelHeight - generalPanelHeight;
                        } else {
                            height = $(window).height() - generalPanelHeight;
                        }

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
                }
            }

        </script>
    </body>
</html>
