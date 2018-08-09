<?php
include '../includes/language.php';
?>

<div id="modal-body" class="modal-body">

    <div class="row">
        <div class="col-xs-12 root">
            <div data-sensor-source="webcam" id="webcam-preview" class="autoplay">
                <div class="root embed-responsive embed-responsive-4by3 hidden-controls">
                    <div id="" class="webcam-image-container"></div>
                    <div class="controls-container embed-responsive-item">
                        <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                    </div>
                </div>

                <div id="webcam-playback-slider-controls" class="hidden" style="margin-top: -10px" data-visible="true">
                    <div id="webcam-playback-slider-container" class="webcam-playback-slider-container" style="width: 100%;">
                        <input id="webcam-playback-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-shadow btn-default" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
</div>

<script>
    $(document).ready(function () {
        renderModalData();

        $('#custom-modal').bind('hidden.bs.modal', function () {
            console.log('modal hidden');
            gesturePreviewOpened = false;
            $(this).unbind('hidden.bs.modal');
        });
    });

    function renderModalData() {
        var gesture = currentPreviewGesture.gesture;
        if (gesture === null) {
            return false;
        }

        var container = $('#modal-body');
        container.find('#title .text').text(gesture.title);
        container.find('#association .text').text(gesture.association === null ? '-' : gesture.association);
        container.find('#context .text').text(gesture.context);
        container.find('#description .text').text(gesture.description);

        renderGesturePreview(container.find('#webcam-preview'), gesture);

        if (!previewModeEnabled && peerConnection) {
            peerConnection.sendMessage(MESSAGE_GESTURE_INFO_PRESENT);
            $(peerConnection).unbind(MESSAGE_CLOSE_GESTURE_INFO).bind(MESSAGE_CLOSE_GESTURE_INFO, function (event, payload) {
                $('#custom-modal').modal('hide');
            });
        }
    }

    $('#btn-close-modal').unbind('click').bind('click', function (event) {
        event.preventDefault();
        console.log('close modal', $(this).closest('.modal'));
        $(this).closest('.modal').modal('hide');
//        $('#custom-modal').modal('hide');
    });
</script>