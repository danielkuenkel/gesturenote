<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" onclick="saveData()" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Überprüfung</h4>
</div>

<div id="gesture-details" class="modal-body">
    <h4>Klassifizierte Gesten</h4>
    <div class="row" style="margin-top: 10px">
        <div id="gestures-list-container"></div>
    </div>
</div>

<hr style="margin: 0">

<div id="modal-body" class="modal-body">
    <h4>Checkliste</h4>
    <div id="editable-checklist" style="margin-top: 10px;">
        <div class="question-container"></div>
    </div>
</div>

<hr style="margin: 0">

<div class="modal-body" id="objective-question">
    <h4>Eignung der Geste</h4>
    <p class="question text"><?php echo $lang->objectiveExtractionChecklistQuestion ?></p>
    <div class="btn-group switch">
        <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="well" name="btn-success"><?php echo $lang->yes ?></button>
        <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="less-even" name="btn-danger"><?php echo $lang->no ?></button>
        <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="even" name="btn-warning"><?php echo $lang->dontKnow ?></button>
    </div>
</div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="saveData()"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo $lang->saveAndClose ?></button>
</div>

<script>
    $(document).ready(function () {
        renderData();
    });

    function renderData() {

        for (var k = 0; k < currentAssignment.gestures.length; k++) {
            var gesture = getGestureById(currentAssignment.gestures[k], ELICITED_GESTURES);
            var involvedGesture = getSimpleGestureListThumbnail($('#simple-gesture-thumbnail').clone(), gesture, 'col-xs-6 col-md-4 col-lg-3', parseInt(currentAssignment.mainGestureId) === parseInt(gesture.id) ? 'panel-info' : 'panel-default');
            $('#gesture-details').find('#gestures-list-container').append(involvedGesture);
        }

        var classification = getLocalItem(CLASSIFICATION);
        var items = getAssembledItems(classification.checklist.items);

        if (currentAssignment && currentAssignment.checklist && currentAssignment.checklist.answers && currentAssignment.checklist.answers.length > 0) {
            renderQuestionnaire(('#editable-checklist'), items, currentAssignment.checklist.answers);
        } else {
            renderQuestionnaire(('#editable-checklist'), items, null);
        }
        
        if (currentAssignment.cognitiveRelationship && currentAssignment.checklist.objectiveAnswer) {
            $('#objective-question').find('.switch #' + currentAssignment.checklist.objectiveAnswer).click();
        }
    }

    function saveData() {
        var answers = getQuestionnaireAnswers($('#editable-checklist .question-container').children());

        var classification = getLocalItem(CLASSIFICATION);
        var objectiveAnswer = $('#objective-question').find('.switch .active').attr('id');

        for (var i = 0; i < classification.assignments.length; i++) {
            if (parseInt(classification.assignments[i].mainGestureId) === parseInt(currentAssignment.mainGestureId) &&
                    parseInt(classification.assignments[i].triggerId) === parseInt(currentAssignment.triggerId)) {
                classification.assignments[i].checklist = {answers: answers, objectiveAnswer: objectiveAnswer};
                break;
            }
        }

        setLocalItem(CLASSIFICATION, classification);
        saveClassification();
        renderPotentialGestures();
    }
</script>