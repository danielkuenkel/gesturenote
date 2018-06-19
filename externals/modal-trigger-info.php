<?php
include '../includes/language.php';
?>

<div id="modal-body" class="modal-body">
    <div id="trigger-title" class="text text-center" style="font-size: 18pt; font-weight: bold">

    </div>
</div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" id="btn-close-modal"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
</div>

<script>
    $(document).ready(function () {
        renderModalData();

        $('#custom-modal').bind('hidden.bs.modal', function () {
//            currentPreviewTrigger = null;
            triggerPreviewOpened = false;
            $(this).unbind('hidden.bs.modal');
        });
    });

    function renderModalData() {
        if (currentPreviewTrigger === null) {
            return false;
        }

        var container = $('#modal-body');
        container.find('#trigger-title').text(currentPreviewTrigger.title);
//        container.find('#association .text').text(gesture.association === null ? '-' : gesture.association);
//        container.find('#context .text').text(gesture.context);
//        container.find('#description .text').text(gesture.description);

//        renderGesturePreview(container.find('#webcam-preview'), gesture);

        if (!previewModeEnabled && peerConnection) {
            peerConnection.sendMessage(MESSAGE_TRIGGER_INFO_PRESENT);
            $(peerConnection).unbind(MESSAGE_CLOSE_TRIGGER_INFO).bind(MESSAGE_CLOSE_TRIGGER_INFO, function (event, payload) {
                $('#custom-modal').modal('hide');
            });
        }
    }
</script>