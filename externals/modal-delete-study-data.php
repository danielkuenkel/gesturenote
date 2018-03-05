<?php
include '../includes/language.php';
?>

<div id="modal-body" class="modal-body">
    <div class="text-center text">
        <p>
            <?php echo $lang->deleteStudyModal ?>
        </p>
    </div>

    <div class="btn-group btn-group-justified">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default btn-shadow" id="btn-yes" data-dismiss="modal"><i class="fa fa-check"></i> <?php echo $lang->yes ?></button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn  btn-default btn-shadow" id="btn-no" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang->no ?></button>
        </div>

    </div>
</div>

<script>
    $(document).ready(function () {
        $('#btn-yes').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $('#custom-modal').trigger('deleteData');
            $('#custom-modal').modal('hide');
        });

        $('#btn-no').click(function (event) {
            event.preventDefault();
            $('#custom-modal').trigger('cancel');
            $('#custom-modal').modal('hide');
        });
    });
</script>