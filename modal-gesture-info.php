<?php
include 'includes/language.php';
?>

<!--<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Gesten-Vorschau</h4>
</div>-->
<div id="modal-body" class="modal-body">

    <div class="row">
        <div class="col-xs-12 root">
            <div class="previewGesture mouseScrollable btn-shadow autoplay"></div>
            <div class="progress gesture-progress">
                <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <div class="text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                    <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                    <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
</div>

<script>
    $(document).ready(function () {
        renderModalData();

        $('#custom-modal').bind('hidden.bs.modal', function () {
            currentPreviewGesture = null;
            gesturePreviewOpened = false;
            $(this).unbind('hidden.bs.modal');
        });
    });

    function renderModalData() {
//        console.log(currentPreviewGesture);
        var gesture = currentPreviewGesture.gesture;
        if (gesture === null) {
            return false;
        }

        var container = $('#modal-body');
        container.find('#title .text').text(gesture.title);
        container.find('#association .text').text(gesture.association === null ? '-' : gesture.association);
        container.find('#context .text').text(gesture.context);
        container.find('#description .text').text(gesture.description);

        renderGestureImages(container.find('.previewGesture'), gesture.images, gesture.previewImage, null);
//        renderBodyJointsPreview(container.find('#human-body'), gesture.joints);

        if (peerConnection) {
            peerConnection.sendMessage(MESSAGE_GESTURE_INFO_PRESENT);
            $(peerConnection).unbind(MESSAGE_CLOSE_GESTURE_INFO).bind(MESSAGE_CLOSE_GESTURE_INFO, function (event, payload) {
                $('#custom-modal').modal('hide');
            });
        }
    }
</script>