<?php
include 'includes/language.php';
?>

<div class="modal-header">
    <h4 class="modal-title">Gestenauswahl</h4>
</div>
<div id="modal-body" class="modal-body">
    <div class="question-container"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success pull-right" id="btn-done-select"><i class="fa fa-check"></i> <?php echo $lang->done ?></button>
</div>

<script>
    $(document).ready(function () {
        var currentPhaseData = getCurrentPhaseData();
//        var gesture = getGestureById(currentPhaseData.identification[currentIdentificationIndex].gestureId);
//        if (gesture) {
//            renderGestureImages($('#custom-modal').find('.previewGesture'), gesture.images, gesture.previewImage, function () {
//            });
//        }
        var trigger = getTriggerById(currentPhaseData.exploration[currentExplorationIndex].triggerId);
        var gestures = currentPhaseData.exploration[currentExplorationIndex].gestures;
        var options = [];
        for (var i = 0; i < gestures.length; i++) {
            options.push(getGestureById(gestures[i]));
        }
        console.log(options);

        var question = translation.askPreferredGesturesForTrigger;
        question = question.replace('{trigger}', trigger.title);
        var data = [{id: chance.natural(), dimension: DIMENSION_ANY, format: GROUPING_QUESTION_OPTIONS, question: question, parameters: {multiselect: 'yes', optionSource: 'gestures', justification: 'yes', justificationFor: 'selectOne', optionalanswer: 'yes', options: options}}];
        renderQuestionnaire($('#custom-modal'), data);

        $('#custom-modal').find('.question-container').unbind('change').bind('change', function (event) {
            saveAnswers($(this).children());
        });

        $('#custom-modal').find('#btn-done-select').unbind('click').bind('click', function (event) {
            event.preventDefault();
            saveAnswers($(this).parent().parent().find('.question-container').children());
            $('#custom-modal').modal('hide');
        });

        function saveAnswers(questionnaire) {
            var answers = {answers: getQuestionnaireAnswers(questionnaire)};
            if (!previewModeEnabled) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                if (tempData && tempData.gestures) {
                    tempData.answers.push({triggerId: trigger.id, preferredGestures: answers});
                } else {
                    tempData.answers = [{triggerId: trigger.id, preferredGestures: answers}];
                }
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);

                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_RESPONSE_PREFERRED_GESTURES, {data: data, answers: answers});
                }
            } else {
                currentQuestionnaireAnswers = {data: data, answers: answers};
            }
        }
    });
</script>