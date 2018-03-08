<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <h4 class="modal-title">Funktionsauswahl</h4>
</div>
<div id="modal-body" class="modal-body">
    <div class="text-center root" style="max-width: 400px; margin: 0 auto; margin-bottom: 20px" id="gesturePreview">
        <div data-sensor-source="webcam" id="webcam-preview" class="autoplay">
            <div class="root embed-responsive embed-responsive-4by3 hidden-controls">
                <div id="" class="webcam-image-container"></div>
                <div class="controls-container embed-responsive-item">
                    <div class="hidden-control text-center" id="btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                </div>
            </div>

            <div id="webcam-playback-slider-controls" class="hidden" style="margin-top: -10px" data-visible="true">
                <div id="webcam-playback-slider-container" class="webcam-playback-slider-container" style="width: 100%;">
                    <input id="webcam-playback-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                </div>
            </div>
        </div>
        <!--        <div class="previewGesture mouseScrollable btn-shadow autoplay embed-responsive embed-responsive-4by3"></div>
                <div class="progress gesture-progress">
                    <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                </div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="fa fa-stop"></i></button>
                    </div>
                </div>-->
    </div>

    <div class="question-container"></div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success pull-right" id="btn-done-select"><i class="fa fa-check"></i> <?php echo $lang->done ?></button>
</div>

<script>
    $(document).ready(function () {
        var container = $('#custom-modal');
        var currentPhaseData = getCurrentPhaseData();
        var gesture = getGestureById(currentPhaseData.exploration[currentExplorationIndex].gestureId);
        if (gesture) {
            renderGesturePreview(container.find('#webcam-preview'), gesture);
//            renderGestureImages($(container.find('.previewGesture'), gesture.images, gesture.previewImage, function () {
//            });
        }

        var data = [{id: chance.natural(), dimension: DIMENSION_ANY, format: GROUPING_QUESTION_OPTIONS, question: translation.askPreferredTriggerForGesture, parameters: {multiselect: 'yes', optionSource: 'triggers', justification: 'yes', justificationFor: 'selectOne', optionalanswer: 'yes'}}];
        if (getCurrentPhase().format === EXPLORATION) {
            var triggerOptions = [];
            for (var i = 0; i < currentPhaseData.exploration[currentExplorationIndex].trigger.length; i++) {
                triggerOptions.push(getTriggerById(currentPhaseData.exploration[currentExplorationIndex].trigger[i]));
            }
            data.options = triggerOptions;
        }

        renderQuestionnaire($(container), data);

        $(container).find('.question-container').unbind('change').bind('change', function (event) {
            event.preventDefault();
            saveAnswers($(this).children());
        });

        $(container).find('#btn-done-select').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(container).find('.question-container').unbind('change');
            saveAnswers($(this).parent().parent().find('.question-container').children(), true);
            $(container).modal('hide');
        });

        function saveAnswers(questionnaire, saveAnswers) {
            var answers = getQuestionnaireAnswers(questionnaire);

            if (!previewModeEnabled) {
                if (saveAnswers) {
                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    if (tempData && tempData.answers) {
                        tempData.answers.push({gestureId: gesture.id, preferredTrigger: answers});
                    } else {
                        tempData.answers = [{gestureId: gesture.id, preferredTrigger: answers}];
                    }
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                }

                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_RESPONSE_PREFERRED_TRIGGER, {data: data, answers: {answers: answers}, saveAnswers: saveAnswers || false});
                }
            } else {
                currentQuestionnaireAnswers = {data: data, answers: {answers: answers}};
            }
        }
    });
</script>