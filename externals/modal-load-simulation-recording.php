<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->loadSimulation ?></h4>
</div>
<div id="modal-body" class="modal-body">

    <div class="form-group root" id="select-simulation-recording">
        <label class="text"><?php echo $lang->nameOfSimulation ?></label>
        <div class="option-container" style="display: grid"></div>
    </div>

</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" style="float:left"><i class="fa fa-close"></i> <?php echo $lang->cancel ?></button>
    <button type="button" class="btn btn-default btn-shadow" id="btn-load-simulation-recording"><i class="fa fa-save"></i> <?php echo $lang->acceptAndClose ?></button>
</div>

<script>
    var recordings = null;
    $(document).ready(function () {
        var modal = $('#custom-modal');
        var query = getQueryParams(document.location.search);
        getSimulationRecordings({gestureSetId: query.gestureSetId}, function (result) {
            if (result.status === RESULT_SUCCESS) {
                recordings = result.recordings;
                for (var i = 0; i < result.recordings.length; i++) {
                    var option = $('#template-general-container').find('#radio').clone();
                    option.find('.option-text').text(result.recordings[i].title);
                    option.find('.btn-radio').attr('id', result.recordings[i].id);
                    $(modal).find('#select-simulation-recording .option-container').append(option);
                }
            }
        });
    });


    $('#btn-load-simulation-recording').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var modal = $('#custom-modal');
        var selectedRecording = getSimulationRecordingById($('#select-simulation-recording').find('.btn-option-checked').attr('id'));
        if (selectedRecording) {
            setLocalItem(RECORDED_SIMULATION, {id: selectedRecording.id, title: selectedRecording.title, created: selectedRecording.created, gestureSetId: selectedRecording.gestureSetId, track: selectedRecording.data.track});
            $(modal).trigger('loadGestureSetSimulation');
            $(modal).modal('hide');
        } else {
        }
    });

    function getSimulationRecordingById(id) {
        if (recordings && recordings.length > 0) {
            for (var i = 0; i < recordings.length; i++) {
                if (parseInt(recordings[i].id) === parseInt(id)) {
                    return recordings[i];
                }
            }
        }
        return null;
    }
</script>