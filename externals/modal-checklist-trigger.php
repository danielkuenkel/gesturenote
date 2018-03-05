<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" onclick="saveData()" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->check ?></h4>
</div>

<div id="gesture-details" class="modal-body">
    <h4><?php echo $lang->ClassifiedTriggers ?></h4>
    <div class="row" style="margin-top: 10px">
        <div id="trigger-list-container"></div>
    </div>
</div>

<hr style="margin: 0">

<div id="modal-body" class="modal-body">
    <h4><?php echo $lang->checklist ?></h4>
    <div id="editable-checklist" style="margin-top: 10px;">
        <div class="question-container"></div>
    </div>
</div>

<hr style="margin: 0">

<div class="modal-body" id="objective-question">
    <h4><?php echo $lang->fitnessOfTrigger ?></h4>

    <div id="switch" style="margin-top: 10px">
        <label class="text"><?php echo $lang->objectiveExtractionChecklistQuestion ?></label> 
        <div class="switch root">
            <div class="btn-group" style="margin: 0">
                <button class="btn btn-default btn-radio" name="primary" id="well">
                    <span id="icons" style="margin-right: 6px">
                        <i class="fa fa-circle-thin" id="normal"></i>
                        <i class="fa fa-circle hidden" id="over"></i>
                        <i class="fa fa-check-circle hidden" id="checked"></i>
                    </span>
                    <span class="option-text"><?php echo $lang->yes ?></span>
                </button>
            </div>
            <div class="btn-group" style="margin: 0">
                <button class="btn btn-default btn-radio" name="primary" id="less-well">
                    <span id="icons" style="margin-right: 6px">
                        <i class="fa fa-circle-thin hidden" id="normal"></i>
                        <i class="fa fa-circle hidden" id="over"></i>
                        <i class="fa fa-check-circle hidden" id="checked"></i>
                    </span>
                    <span class="option-text"><?php echo $lang->no ?></span>
                </button>
            </div>
            <div class="btn-group" style="margin: 0">
                <button class="btn btn-default btn-radio" name="primary" id="even">
                    <span id="icons" style="margin-right: 6px">
                        <i class="fa fa-circle-thin" id="normal"></i>
                        <i class="fa fa-circle hidden" id="over"></i>
                        <i class="fa fa-check-circle hidden" id="checked"></i>
                    </span>
                    <span class="option-text"><?php echo $lang->dontKnow ?></span>
                </button>
            </div>
        </div>
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
        var gesture = getGestureById(currentAssignment.gestureId);
//        var involvedGesture = getSimpleGestureListThumbnail(gesture, 'simple-gesture-thumbnail', 'col-xs-6 col-md-4 col-lg-3');
//            $('#gesture-details').find('#gestures-list-container').append(involvedGesture);
        
        for (var k = 0; k < currentAssignment.trigger.length; k++) {
            
        }

        var classification = getLocalItem(CLASSIFICATION);
        var items = getAssembledItems(classification.checklist.items);

        if (currentAssignment && currentAssignment.checklist && currentAssignment.checklist.answers && currentAssignment.checklist.answers.length > 0) {
            console.log(currentAssignment.checklist.answers);
            renderQuestionnaire(('#editable-checklist'), items, {answers: currentAssignment.checklist.answers});
        } else {
            renderQuestionnaire(('#editable-checklist'), items, null);
        }

        if (currentAssignment.checklist && currentAssignment.checklist.objectiveAnswer) {
            $('#objective-question #switch').find('#' + currentAssignment.checklist.objectiveAnswer).click();
        }
    }

    function saveData() {
        var answers = getQuestionnaireAnswers($('#editable-checklist .question-container').children());

        var classification = getLocalItem(CLASSIFICATION);
        var objectiveAnswer = $('#objective-question').find('#switch .btn-option-checked').attr('id');

        for (var i = 0; i < classification.assignments.length; i++) {
            if (parseInt(classification.assignments[i].mainTriggerId) === parseInt(currentAssignment.mainTriggerId)) {
                classification.assignments[i].checklist = {answers: answers, objectiveAnswer: objectiveAnswer};
                break;
            }
        }
        
        console.log(answers);
        setLocalItem(CLASSIFICATION, classification);
        saveClassification();
        updateTriggerAssignmentInfos($('#content-btn-potential-trigger'), POTENTIAL_TRIGGER, currentAssignment.mainTriggerId, getAssignmentForTriggerId(currentAssignment.mainTriggerId));
    }
</script>