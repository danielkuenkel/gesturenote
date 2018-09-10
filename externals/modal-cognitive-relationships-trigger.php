<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" onclick="saveData()" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->cognitiveRelationsForTrigger ?></h4>
</div>

<div id="modal-body" class="modal-body">
    <div id="list-container"></div>
</div>

<hr style="margin: 0">

<div class="modal-body" id="objective-question">
    <h4><?php echo $lang->fitnessOfTrigger ?></h4>

    <div id="switch" style="margin-top: 10px">
        <label class="text"><<?php echo $lang->objectiveExtractionChecklistQuestion ?></label> 
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
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="saveData()"><span class="fa fa-save"></span> <?php echo $lang->saveAndClose ?></button>
</div>

<script>
    $(document).ready(function () {
        renderData();
    });

    function renderData() {
        var row = document.createElement('div');
        $(row).addClass('row');
        $('#modal-body').find('#list-container').append(row);

        var gesture = getGestureById(currentAssignment.gestureId);
        var gesturePreview = getSimpleGestureListThumbnail(gesture, 'rudimentary-gesture-thumbnail', 'col-xs-12 col-sm-5 col-md-4 col-lg-3');
        $(row).append(gesturePreview);
        
        var triggerCol = document.createElement('div');
        $(triggerCol).addClass('col-xs-12 col-sm-5 col-md-8 col-lg-9');
        $(row).append(triggerCol);

        for (var k = 0; k < currentAssignment.trigger.length; k++) {
            var trigger = getTriggerById(currentAssignment.trigger[k], ELICITED_TRIGGER);
            var triggerColItem = document.createElement('div');
            $(triggerCol).append(triggerColItem);

            var title = document.createElement('div');
            $(triggerCol).append(title);

            var titleLabel = document.createElement('span');
            $(titleLabel).text(translation.trigger + ' ' + (k+1) + ': ');
            $(title).append(titleLabel);

            var titleText = document.createElement('span');
            $(titleText).addClass('text');
            $(titleText).text(gesture.title);
            $(title).append(titleText);

            var relationship = document.createElement('div');
            $(triggerCol).append(relationship);

            var relationshipLabel = document.createElement('span');
            $(relationshipLabel).text(translation.gestureAssociation + ': ');
            $(relationship).append(relationshipLabel);

            var relationshipText = document.createElement('span');
            $(relationshipText).addClass('text');
            $(relationship).append(relationshipText);

            if (trigger.justification && (trigger.justification !== null || trigger.justification !== '')) {
                $(relationshipText).text(trigger.justification);
            } else {
                $(relationshipText).text(translation.noAssociation);
            }

            if (k > 0) {
                $(triggerColItem).css({marginTop: '16px'});
            }
        }

        if (currentAssignment.cognitiveRelationship && currentAssignment.cognitiveRelationship.objectiveAnswer) {
            $('#objective-question').find('#switch #' + currentAssignment.cognitiveRelationship.objectiveAnswer).click();
        }
    }

    function saveData() {
        var classification = getLocalItem(CLASSIFICATION_TRIGGER);
        var objectiveAnswer = $('#objective-question').find('#switch .btn-option-checked').attr('id');

        for (var i = 0; i < classification.assignments.length; i++) {
            if (parseInt(classification.assignments[i].mainTriggerId) === parseInt(currentAssignment.mainTriggerId) &&
                    parseInt(classification.assignments[i].gestureId) === parseInt(currentAssignment.gestureId)) {
                classification.assignments[i].cognitiveRelationship = {objectiveAnswer: objectiveAnswer};
                break;
            }
        }

        setLocalItem(CLASSIFICATION_TRIGGER, classification);
        saveClassification();
        updateTriggerAssignmentInfos($('#content-btn-potential-trigger'), POTENTIAL_TRIGGER, currentAssignment.mainTriggerId, getAssignmentForTriggerId(currentAssignment.mainTriggerId));
    }
</script>