<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Checkliste für Geste</h4>
</div>
<div id="gesture-details" class="modal-body">

</div>
<hr style="margin: 0">
<div id="modal-body" class="modal-body">

    <div id="editable-checklist">
        <div class="question-container"></div>
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
        var classification = getLocalItem(CLASSIFICATION);

        var items = getAssembledItems(classification.checklist.items);
        console.log(currentAssignment, items, currentAssignment.checklist);

        if (currentAssignment.checklist && currentAssignment.checklist.answers && currentAssignment.checklist.answers.length > 0) {
            renderQuestionnaire(('#editable-checklist'), items, currentAssignment.checklist.answers);
//            renderEditableObservations($('#editable-checklist'), items, currentAssignment.checklist.answers);
        } else {
            renderQuestionnaire(('#editable-checklist'), items, null);
        }
    }

    function saveData() {
        var answers = getQuestionnaireAnswers($('#editable-checklist .question-container').children());
        console.log(answers);
        var classification = getLocalItem(CLASSIFICATION);
        for (var i = 0; i < classification.assignments.length; i++) {
            if (parseInt(classification.assignments[i].mainGestureId) === parseInt(currentAssignment.mainGestureId) &&
                    parseInt(classification.assignments[i].triggerId) === parseInt(currentAssignment.triggerId)) {
                classification.assignments[i].checklist = {answers: answers};
                break;
            }
        }
        setLocalItem(CLASSIFICATION, classification);
        saveClassification();
//        setLocalItem(currentIdForModal + '.data', questionnaire);
    }
</script>