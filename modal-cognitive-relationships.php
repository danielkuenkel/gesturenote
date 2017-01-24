<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" onclick="saveData()" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Sinnzusammenhänge für Geste</h4>
</div>

<div id="modal-body" class="modal-body">
    <div id="list-container"></div>
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
            var row = document.createElement('div');
            $(row).addClass('row');
            $('#modal-body').find('#list-container').append(row);

            var gesture = getGestureById(currentAssignment.gestures[k], ELICITED_GESTURES);
            var gesturePreview = $('#rudimentary-gesture-thumbnail').clone();
            $(gesturePreview).addClass('col-xs-5 col-md-4 col-lg-3');
            renderGestureImages($(gesturePreview).find('.previewGesture'), gesture.images, gesture.previewImage, null);
            $(row).append(gesturePreview);


//            var involvedGesture = getSimpleGestureListThumbnail($('#simple-gesture-thumbnail').clone(), gesture, 'col-xs-5 col-md-4 col-lg-3', parseInt(currentAssignment.mainGestureId) === parseInt(gesture.id) ? 'panel-info' : 'panel-default');
//            $(row).append(involvedGesture);

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

            if (k > 0) {
                $(row).css({marginTop: '16px'});
            }
            console.log(gesture);
        }

        console.log(currentAssignment.cognitiveRelationship);

        if (currentAssignment.cognitiveRelationship && currentAssignment.cognitiveRelationship.objectiveAnswer) {
            $('#objective-question').find('.switch #' + currentAssignment.cognitiveRelationship.objectiveAnswer).click();
        }
    }

    function saveData() {
        var classification = getLocalItem(CLASSIFICATION);
        var objectiveAnswer = $('#objective-question').find('.switch .active').attr('id');

        for (var i = 0; i < classification.assignments.length; i++) {
            if (parseInt(classification.assignments[i].mainGestureId) === parseInt(currentAssignment.mainGestureId) &&
                    parseInt(classification.assignments[i].triggerId) === parseInt(currentAssignment.triggerId)) {
                classification.assignments[i].cognitiveRelationship = {objectiveAnswer: objectiveAnswer};
                break;
            }
        }

        setLocalItem(CLASSIFICATION, classification);
        saveClassification();
        renderPotentialGestures();
    }
</script>