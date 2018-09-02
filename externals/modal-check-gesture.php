<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <h4 class="modal-title"><?php echo $lang->whichGestureWasDemonstrated ?></h4>
</div>
<div id="modal-body" class="modal-body">
    <div class="container-root row" id="list-container"></div>

    <div class="btn-group-vertical btn-block" style="margin-top: 10px;">
        <button type="button" class="btn btn-default btn-other-gesture-fit" id="no-gesture-fit-found"><?php echo $lang->anotherGestureWasDemonstrated ?></button>
        <button type="button" class="btn btn-default btn-other-gesture-fit" id="no-gesture-demonstrated"><?php echo $lang->noGestureWasDemonstrated ?></button>
    </div>

    <div class="col-sm-6 col-md-4 root hidden" id="tester-check-item">
        <div class="btn-shadow">
            <div class="previewGesture mousePlayable embed-responsive embed-responsive-4by3" style="border-radius: 0px; border-top-left-radius: 4px; border-top-right-radius: 4px"></div>
            <div class="text-center hidden gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                    <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                </div>
            </div>

            <button type="button" class="btn btn-default btn-block" id="btn-select-item" style="border-top-left-radius: 0px; border-top-right-radius: 0px"><?php echo $lang->thisGesture ?></button>
        </div>
    </div>

</div>

<script>
    $(document).ready(function () {
        var currentPhaseData = getCurrentPhaseData();
        var items = currentPhaseData.slideshow;
        var correctGesture = getGestureById(items[currentSlideIndex].gestureId);
        var triggerId = items[currentSlideIndex].triggerId;

        $('.btn-other-gesture-fit').on('click', function (event) {
            if (!event.handled) {
                event.handled = true;
                var action = null;
                if ($(this).attr('id') === 'no-gesture-fit-found') {
                    action = ACTION_NO_GESTURE_FIT_FOUND;
//                    slidesRestartCount++;
//                    slideRestarted = true;
//                    currentSlideIndex = 0;
//                    slideTriggered = false;
                } else if ($(this).attr('id') === 'no-gesture-demonstrated') {
                    action = ACTION_NO_GESTURE_DEMONSTRATED;
                }


//                if (!previewModeEnabled) {
//                    getGMT(function (timestamp) {
//                        $('#custom-modal').trigger(ACTION_NO_GESTURE_FIT_FOUND, [{action: action, correctGesture: correctGesture, triggerId: triggerId, timestamp: timestamp}]);
//                        console.log(action, peerConnection, getLocalItem(STUDY).surveyType);
//                        if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
//                            var currentPhase = getCurrentPhase();
//                            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                            tempData.annotations.push({id: tempData.annotations.length, action: action, gestureId: correctGesture.id, triggerId: triggerId, selectedGestureId: null, time: timestamp});
//                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                        } else {

//                        }

//                        $('#custom-modal').trigger('noGestureFitFound');
//                        $('#custom-modal').modal('hide');
//                });
//                } else {
                $('#custom-modal').trigger(ACTION_NO_GESTURE_FIT_FOUND, [{action: action, correctGestureId: correctGesture.id, triggerId: triggerId}]);
//                    $('#custom-modal').modal('hide');
//                }

//                if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
//                    Tester.renderUnmoderatedGestureSlideshow(getSourceContainer(VIEW_TESTER), $('#viewTester #phase-content'), currentPhaseData, false);
//                } else {
//                    Moderator.renderGestureSlide(getSourceContainer(VIEW_MODERATOR), $('#viewModerator #phase-content'), currentPhaseData);
//                }
            }
        });

        for (var i = 0; i < items.length; i++) {
            var clone = $('#tester-check-item').clone().removeClass('hidden').removeAttr('id');
            $('#list-container').append(clone);
            $(clone).css({marginBottom: '20px'});
            var gesture = getGestureById(items[i].gestureId);
            renderGestureImages(clone.find('.previewGesture'), gesture.images, gesture.previewImage, null);

            $(clone).find('#btn-select-item').click({gesture: gesture}, function (event) {
                event.preventDefault();
                if (!event.handled) {
                    event.handled = true;

                    var gestureFit = parseInt(correctGesture.id) === parseInt(event.data.gesture.id);
                    if (gestureFit === true) {
//                        $('#custom-modal').trigger('gestureFitFound');
                        $('#custom-modal').trigger(ACTION_SELECT_GESTURE, [{action: ACTION_SELECT_GESTURE, correctGestureId: correctGesture.id, triggerId: triggerId, gestureId: gesture.id, fit: gestureFit}]);
                    } else {
                        $('#custom-modal').trigger(ACTION_NO_GESTURE_FIT_FOUND, [{action: ACTION_NO_GESTURE_FIT_FOUND, correctGestureId: correctGesture.id, triggerId: triggerId, gestureId: gesture.id, fit: gestureFit}]);
                    }

//                    if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
//                    if (!previewModeEnabled) {
//                        getGMT(function (timestamp) {
//                                var currentPhase = getCurrentPhase();
//                                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                tempData.restarts = slidesRestartCount;
//                                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_SELECT_GESTURE, gestureId: correctGesture.id, triggerId: triggerId, selectedGestureId: event.data.gesture.id, fit: gestureFit, time: timestamp});
//                                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                                Tester.renderUnmoderatedGestureSlideshow(getSourceContainer(VIEW_TESTER), $('#viewTester #phase-content'), currentPhaseData, false);
//                        });
//                    } else {
////                            Tester.renderUnmoderatedGestureSlideshow(getSourceContainer(VIEW_TESTER), $('#viewTester #phase-content'), currentPhaseData, false);
//                    }
//                    } else {

//                    Moderator.renderGestureSlide(getSourceContainer(VIEW_MODERATOR), $('#viewModerator #phase-content'), currentPhaseData);
//                    }

//                    $('#custom-modal').modal('hide');
                }
            });
        }
    });
</script>