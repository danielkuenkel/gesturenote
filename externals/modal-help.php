<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->help ?></h4>
</div>
<div id="modal-body" class="modal-body">
    <div class="container-root" id="list-container"></div>

    <div class="root hidden" id="tester-help-item">
        <div class="text" id="text"></div>
        <div data-sensor-source="webcam" id="webcam-preview" class="autoplay hidden" style="margin-top: 15px">
            <div class="root embed-responsive embed-responsive-4by3 hidden-controls">
                <div id="" class="webcam-image-container"></div>
                <div class="controls-container embed-responsive-item" style="opacity: 0">
                    <div class="hidden-control text-center btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
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
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" id="btn-more-help"><?php echo $lang->moreHelp ?></button>
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
</div>

<script>
    var currentHelpIndex = 0;
    $(document).ready(function () {

        renderHelpItem();

        if (triggeredHelp) {
            $('#btn-more-help').addClass('hidden');
        } else {
            $('#btn-more-help').click(function (event) {
                event.preventDefault();
                currentHelpIndex++;
                renderHelpItem();
            });
        }

        $('#modal-body').closest('.modal').on('hidden.bs.modal', function () {
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_HELP_CLOSED);
            }
            triggeredHelp = null;
        });
        
        if(!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_CLOSE_HELP).bind(MESSAGE_CLOSE_HELP, function() {
                $('#modal-body').closest('.modal').modal('hide');
            });
        }
    });

    function renderHelpItem() {
        $('#list-container').empty();
        var data;

        if (triggeredHelp) {
            data = triggeredHelp;
        } else {
            var currentPhaseData = getCurrentPhaseData();
            var items = getItemsForSceneId(currentPhaseData.help, currentWOZScene.id);

            if (items && items.length > 0) {
                if (currentHelpIndex >= items.length - 1) {
                    $('#btn-more-help').addClass('hidden');
                }
            }
            data = items[currentHelpIndex];
        }

        if (data) {
            var clone = $('#tester-help-item').clone().removeClass('hidden').removeAttr('id');
            clone.find('#text').text(data.option);
            $('#list-container').append(clone);

            if (data.useGestureHelp === true || data.useGestureHelp === 'true') {
                $(clone).find('#webcam-preview').removeClass('hidden');
                var gesture = getGestureById(data.gestureId);
                renderGesturePreview($(clone).find('#webcam-preview'), gesture);
            }
        }
    }
</script>