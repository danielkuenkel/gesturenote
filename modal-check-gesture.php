<div class="modal-header">
    <h4 class="modal-title">Welche Geste wurde vorgeführt?</h4>
</div>
<div id="modal-body" class="modal-body">
    <div class="container-root row" id="list-container"></div>
    
    <div class="btn-group-vertical btn-block" style="margin-top: 10px;">
        <button type="button" class="btn btn-default btn-other-gesture-fit" id="no-gesture-fit-found">Ich habe eine ganz andere Geste vorgeführt</button>
        <button type="button" class="btn btn-default btn-other-gesture-fit" id="no-gesture-demonstrated">Ich habe keine Geste vorgeführt</button>
    </div>

    <div class="col-sm-6 col-md-4 root hidden" id="tester-check-item">
        <div class="panel panel-default btn-shadow">
            <div class="panel-body">
                <div class="previewGesture mousePlayable"></div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
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
        var items = currentPhaseData.slideshow;
        var correctGesture = getGestureById(items[currentSlideIndex].gestureId);
        var triggerId = items[currentSlideIndex].triggerId;

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
                } else if($(this).attr('id') === 'no-gesture-demonstrated') {
                    action = ACTION_NO_GESTURE_DEMONSTRATED;
                }

                if (!previewModeEnabled) {
                    var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                    tempData.actions.push({action: action, gestureId: correctGesture.id, triggerId: triggerId, selectedGestureId: null, time: new Date().getTime()});
                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                }

                $('#custom-modal').modal('hide');
            }
            Tester.renderUnmoderatedGestureSlideshow($('#item-container-tester'), $('#viewTester #phase-content'), currentPhaseData, false);
        });


        for (var i = 0; i < items.length; i++) {
            var clone = $('#tester-check-item').clone().removeClass('hidden').removeAttr('id');
            $('#list-container').append(clone);
            var gesture = getGestureById(items[i].gestureId);
            renderGestureImages(clone.find('.previewGesture'), gesture.images, gesture.previewImage, function () {
            });

            $(clone).find('#btn-select-item').click({gesture: gesture}, function (event) {
                event.preventDefault();
//                console.log('btn-select-item clicked');
                var gestureFit = parseInt(correctGesture.id) === parseInt(event.data.gesture.id);
                if (gestureFit === true) {
                    currentSlideIndex++;
                } else {
                    slidesRestartCount++;
                    slideRestarted = true;
                    currentSlideIndex = 0;
                    slideTriggered = false;
                }

                if (!previewModeEnabled) {
                    var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                    tempData.restarts = slidesRestartCount;
//                    console.log(tempData.actions);
                    tempData.actions.push({action: ACTION_SELECT_GESTURE, gestureId: correctGesture.id, triggerId: triggerId, selectedGestureId: event.data.gesture.id, fit: gestureFit, time: new Date().getTime()});
                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                }

                $('#custom-modal').modal('hide');
                Tester.renderUnmoderatedGestureSlideshow($('#item-container-tester'), $('#viewTester #phase-content'), currentPhaseData, false);
            });
        }
    });
</script>