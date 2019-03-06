<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->saveSimulation ?></h4>
</div>
<div id="modal-body" class="modal-body">

    <div class="form-group">
        <label class="text"><?php echo $lang->nameOfSimulation ?></label>
        <input type="text" class="form-control" id="simulation-name" minlength="8" maxlength="50" placeholder="<?php echo $lang->nameOfSimulationPlaceholder ?>">
    </div>

</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" style="float:left"><i class="fa fa-close"></i> <?php echo $lang->cancel ?></button>
    <button type="button" class="btn btn-default btn-shadow" id="btn-save-simulation-recording"><i class="fa fa-save"></i> <?php echo $lang->saveAndClose ?></button>
</div>

<script>
    $('#btn-save-simulation-recording').unbind('click').bind('click', function (event) {
        event.preventDefault();

        // check input field
        var modal = $('#custom-modal');
        var title = $(modal).find('#simulation-name').val();
        if (title.trim().length === 0 && (title.length < 8 || title.length > 50)) {
            // append alert
            return false;
        }

        var commitData = getLocalItem(SIMULATION_RECORDING);
        var query = getQueryParams(document.location.search);
        saveGestureSetSimulation({gestureSetId: query.gestureSetId, title: title.trim(), data: commitData}, function (result) {
            if (result.status === RESULT_SUCCESS) {
                removeLocalItem(SIMULATION_RECORDING);
                commitData.id = result.id;
                setLocalItem(RECORDED_SIMULATION, commitData);
                $(modal).trigger('loadRecordedGestureSetSimulation');
                $(modal).modal('hide');
            }
        });
    });

</script>