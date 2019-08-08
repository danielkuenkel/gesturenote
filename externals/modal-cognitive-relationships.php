<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" onclick="saveData()" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->cognitiveRelationsForGesture ?></h4>
</div>

<div class="modal-body" id="modal-body">
    <div id="list-container" class="cognitive-relationships-list-container"></div>
</div>

<hr style="margin: 0">

<div class="modal-body" id="objective-question">
    <h4><?php echo $lang->fitnessOfGesture ?></h4>

    <div class="panel panel-default panel-shadow root">
        <div class="panel-body">
            <div id="switch" style="">
                <label class="text"><?php echo $lang->objectiveCognitiveRelationshipQuestion ?></label> 
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
                                <i class="fa fa-circle-thin" id="normal"></i>
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
        for (var k = 0; k < currentAssignment.gestures.length; k++) {
            var row = document.createElement('div');
            $(row).addClass('row');


            var gesture = getGestureById(currentAssignment.gestures[k].id, ELICITED_GESTURES);
            var gesturePreview = getSimpleGestureListThumbnail(gesture, 'simple-gesture-thumbnail', 'col-xs-5 col-md-4 col-lg-3');
            $(gesturePreview).attr('data-weighting', currentAssignment.gestures[k].weighting).find('.weighting-text').text(currentAssignment.gestures[k].weighting);
            if (parseInt(gesture.id) !== parseInt(currentAssignment.mainGestureId)) {
                $(gesturePreview).find('.weighting-info').removeClass('hidden');
                $('#modal-body').find('#list-container').append(row);
            } else {
                $('#modal-body').find('#list-container').prepend(row);
            }

            $(row).append(gesturePreview);

            var details = document.createElement('div');
            $(details).addClass('col-xs-7 col-md-8 col-lg-9');
            $(row).append(details);

            var title = document.createElement('div');
            $(details).append(title);

            var titleLabel = document.createElement('span');
            $(titleLabel).text(translation.title + ': ');
            $(title).append(titleLabel);

            var titleText = document.createElement('span');
            $(titleText).addClass('text');
            $(titleText).text(gesture.title);
            $(title).append(titleText);

            var relationship = document.createElement('div');
            $(details).append(relationship);

            var relationshipLabel = document.createElement('span');
            $(relationshipLabel).text(translation.gestureAssociation + ': ');
            $(relationship).append(relationshipLabel);

            var relationshipText = document.createElement('span');
            $(relationshipText).addClass('text');
            $(relationship).append(relationshipText);

            if (gesture.association && (gesture.association !== null || gesture.association !== '')) {
                $(relationshipText).text(gesture.association);
            } else {
                $(relationshipText).text(translation.noAssociation);
            }

//            if (k > 0) {
            $(row).css({paddingTop: '16px'});
//            }
        }

        if (currentAssignment.cognitiveRelationship && currentAssignment.cognitiveRelationship.objectiveAnswer) {
            $('#objective-question').find('#switch #' + currentAssignment.cognitiveRelationship.objectiveAnswer).click();
        }
    }

    function saveData() {
        var classification = getLocalItem(CLASSIFICATION_GESTURES);
        var objectiveAnswer = $('#objective-question').find('#switch .btn-option-checked').attr('id');

        for (var i = 0; i < classification.assignments.length; i++) {
            if (parseInt(classification.assignments[i].mainGestureId) === parseInt(currentAssignment.mainGestureId) &&
                    parseInt(classification.assignments[i].triggerId) === parseInt(currentAssignment.triggerId)) {
                classification.assignments[i].cognitiveRelationship = {objectiveAnswer: objectiveAnswer};
                break;
            }
        }

        setLocalItem(CLASSIFICATION_GESTURES, classification);
        saveClassification();
        updateGestureAssignmentInfos($('#content-btn-potential-gestures'), POTENTIAL_GESTURES, currentAssignment.mainGestureId, getAssignmentForGestureId(currentAssignment.mainGestureId));
    }
</script>