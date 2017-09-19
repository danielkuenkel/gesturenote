<?php
include 'includes/language.php';
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
                <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
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

        var data = [{id: 'identifiedTrigger', dimension: DIMENSION_ANY, format: GROUPING_QUESTION_OPTIONS, question: translation.askPreferredTriggerForGesture, parameters: {multiselect: 'yes', optionSource: 'triggers', justification: 'yes', justificationFor: 'selectOne', optionalanswer: 'yes'}}];
        renderQuestionnaire($('#custom-modal'), data);

        $('#custom-modal').find('#btn-done-select').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var answers = getQuestionnaireAnswers($(this).parent().parent().find('.question-container').children());
            if (!previewModeEnabled) {
//                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                tempData.actions.push({action: action, time: new Date().getTime()});
//                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);

                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_RESPONSE_TRIGGER, answers);
                }
            } else {
                currentQuestionnaireAnswers = answers;
            }

            $('#custom-modal').modal('hide');
        });
    });
</script>