<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <h4 class="modal-title">Welche Geste wurde vorgeführt?</h4>
</div>
<div id="modal-body" class="modal-body">
    <div class="container-root row" id="list-container"></div>

    <div class="btn-group-vertical btn-block" style="margin-top: 10px;">
        <button type="button" class="btn btn-default btn-other-gesture-fit" id="no-gesture-fit-found">Ich habe eine ganz andere Geste vorgeführt</button>
        <button type="button" class="btn btn-default btn-other-gesture-fit" id="no-gesture-demonstrated">Ich habe keine Geste vorgeführt</button>
    </div>

    <div class="col-sm-6 col-md-4 root hidden" id="tester-woz-item">
        <div class="panel panel-default btn-shadow">
            <div class="panel-body">
                <div class="previewGesture mousePlayable"></div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                    </div>
                </div>

                <button type="button" class="btn btn-success btn-block" id="btn-select-item" style="margin-top: 10px;">Diese</button>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function () {
        var currentPhaseData = getCurrentPhaseData();
        var items = getWOZItemsForSceneId(currentPhaseData.woz, currentWOZScene.id);

        $('.btn-other-gesture-fit').on('click', function (event) {
            if (!event.handled) {
                event.handled = true;

                var action = null;
                if ($(this).attr('id') === 'no-gesture-fit-found') {
                    action = ACTION_NO_GESTURE_FIT_FOUND;
                    slidesRestartCount++;
                    slideRestarted = true;
                    currentSlideIndex = 0;
                    slideTriggered = false;
                } else if ($(this).attr('id') === 'no-gesture-demonstrated') {
                    action = ACTION_NO_GESTURE_DEMONSTRATED;
                }

                if (!previewModeEnabled) {
                    getGMT(function (timestamp) {
                        var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                        tempData.annotations.push({id: tempData.annotations.length, action: action, time: timestamp});
                        setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                    });
                }

                $('#custom-modal').modal('hide');
            }
        });

        for (var i = 0; i < items.length; i++) {
            var clone = $('#tester-woz-item').clone().removeClass('hidden').removeAttr('id');
            $('#list-container').append(clone);
            var gesture = getGestureById(items[i].gestureId);
            if (gesture) {
                renderGestureImages(clone.find('.previewGesture'), gesture.images, gesture.previewImage, function () {
                });
            }

            $(clone).find('.panel').mouseenter(function (event) {
                event.preventDefault();
                $(this).find('#btn-play-gesture').click();
            });

            $(clone).find('.panel').mouseleave(function (event) {
                event.preventDefault();
                $(this).find('#btn-stop-gesture').click();
            });

            $(clone).find('#btn-select-item').click({wozData: items[i]}, function (event) {
                event.preventDefault();
                var wozData = event.data.wozData;

                if (wozData.transitionId && wozData.transitionId !== 'none') {
                    currentWOZScene = getSceneById(wozData.transitionId);
                }

                // temp data 
                if (!previewModeEnabled) {
                    getGMT(function (timestamp) {
                        var currentPhase = getCurrentPhase();
                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_SELECT_GESTURE, selectedGestureId: wozData.gestureId, time: timestamp});
                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, scene: currentWOZScene.id || null, time: timestamp});
                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                    });
                }

                // modal and hint hiding, trigger transition to scene for a gesture
                $('#custom-modal').modal('hide');
                var feedback = getFeedbackById(wozData.feedbackId);
                if (feedback) {
                    var hint = appendHint(getSourceContainer(VIEW_TESTER), $('body'), wozData, TYPE_SURVEY_UNMODERATED);
                    $(hint).on('hint.hidden', function () {
                        renderSceneItem(getSourceContainer(VIEW_TESTER), $('#viewTester #phase-content'), currentWOZScene.id);
                    });
                } else {
                    renderSceneItem(getSourceContainer(VIEW_TESTER), $('#viewTester #phase-content'), currentWOZScene.id);
                }
            });
        }
    });
</script>