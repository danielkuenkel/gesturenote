<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title" id="exampleModalLabel">Gesten aufzeichnen</h4>
</div>
<div id="modal-body" class="modal-body"></div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal">Schließen</button>
</div>

<script src="js/gesture-recorder.js"></script>
<script>
    $(document).ready(function () {
        var recorder = $('#item-container-gesture-recorder').find('#gesture-recorder').clone().removeAttr('id');
        $('#modal-body').append(recorder);
        renderBodyJoints($(recorder).find('#human-body'));
        initCheckRecorder($('#modal-body'), recorder, true);

        $('#custom-modal').bind('hidden.bs.modal', function () {
            resetRecorder();
            $(this).unbind('hidden.bs.modal');
        });
    });
</script>