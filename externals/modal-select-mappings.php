<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->chooseMappings ?></h4>
</div>
<div id="modal-body" class="modal-body">

    <div class="alert-space alert-no-gesture-set-mappings"></div>
    <div id="list-container">

    </div>

</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow pull-left" id="btn-cancel-selection"><i class="fa fa-close"></i> <?php echo $lang->cancel ?></button>
    <button type="button" class="btn btn-default btn-shadow" id="btn-apply-selection"><i class="fa fa-check"></i> <?php echo $lang->applySelection ?></button>
</div>

<script>
    $(document).ready(function () {
        if (currentPreviewGestureSet) {
            renderData();
        }

        $('#modal-body').closest('.modal').on('hidden.bs.modal', function () {
            $('#modal-body').find('#list-container').empty();
        });
    });

    function renderData(data) {
        var modal = $('#custom-modal');
        if (currentPreviewGestureSet.set && currentPreviewGestureSet.set.mappings) {
            var mappings = currentPreviewGestureSet.set.mappings;
            for (var i = 0; i < mappings.length; i++) {
                var container = $('#item-container-moderator').find('#' + data.type).clone().removeAttr('id');
                container.find('.type .label-text').text(translation.sceneTypes[data.type]);
                container.find('.title').text(data.title);
                $(modal).find('#list-container').append(container);
            }
        } else {
            appendAlert($(modal).find('#modal-body'), ALERT_NO_GESTURE_SET_MAPPINGS);
        }
    }

    $('#btn-apply-selection').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var modal = $('#custom-modal');
        var mappings = null;
        $(modal).trigger('mappingsApplied', [mappings]);
        $(modal).modal('hide');
    });

    $('#btn-cancel-selection').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var modal = $('#custom-modal');
        var mappings = null;
        $(modal).trigger('mappingsApplied', [mappings]);
        $(modal).modal('hide');
    });

</script>