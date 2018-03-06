<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <h4 class="modal-title">Funktionsauswahl</h4>
</div>
<div id="modal-body" class="modal-body">
    <div class="text-center root" style="margin-bottom: 15px; max-width: 400px; margin: 0 auto; margin-bottom: 20px" id="gesturePreview">
        <div class="previewGesture mouseScrollable btn-shadow autoplay embed-responsive embed-responsive-4by3"></div>
        <div class="progress gesture-progress">
            <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
        </div>
        <div class="text-center gestureControls">
            <div class="btn-group">
                <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="fa fa-play"></i></button>
                <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="fa fa-stop"></i></button>
            </div>
        </div>
    </div>

    <div class="question-container"></div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success pull-right" id="btn-done-select"><i class="fa fa-check"></i> <?php echo $lang->done ?></button>
</div>

<script>
    $(document).ready(function () {
        var currentPhaseData = getCurrentPhaseData();
        var gesture = getGestureById(currentPhaseData.identification[currentIdentificationIndex].gestureId);
        if (gesture) {
            renderGestureImages($('#custom-modal').find('.previewGesture'), gesture.images, gesture.previewImage, function () {
            });
        }

        var data = [{id: chance.natural(), dimension: DIMENSION_ANY, format: OPEN_QUESTION, question: translation.requestPreferredTriggerForGesture, parameters: {justification: 'yes'}}];
        renderQuestionnaire($('#custom-modal'), data);

        $('#custom-modal').find('.question-container').unbind('change').bind('change', function (event) {
            saveAnswers($(this).children(), false);
        });

        $('#custom-modal').find('#btn-done-select').unbind('click').bind('click', function (event) {
            event.preventDefault();
            saveAnswers($(this).parent().parent().find('.question-container').children(), true);
            $('#custom-modal').modal('hide');
        });

        function saveAnswers(questionnaire, saveAnswers) {
            var answers = {answers: getQuestionnaireAnswers(questionnaire)};

            if (!previewModeEnabled) {
                if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_MODERATED) {
                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_RESPONSE_TRIGGER, {data: data, gestureId: gesture.id, answers: answers, saveAnswers: saveAnswers});
                    }
                } else {
                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    tempData.trigger.push({gestureId: gesture.id, preferredTrigger: answers});
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                }
            } else {
                currentQuestionnaireAnswers = {data: data, answers: answers};
            }
        }
    });
</script>