<?php
include '../includes/language.php';
?>

<div id="modal-body" class="modal-body">
    <div class="text-center text">
        <p>
            <?php echo $lang->deleteCreateModal ?>
        </p>
    </div>

    <div class="btn-group btn-group-justified">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default btn-shadow" id="btn-cancel-abort" data-dismiss="modal"><?php echo $lang->cancel ?></button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn  btn-default btn-shadow" id="btn-dont-save-edited-study" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang->no ?></button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default btn-shadow" id="btn-save-edited-study" data-dismiss="modal"><i class="fa fa-check"></i> <?php echo $lang->yes ?></button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#btn-cancel-abort').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $('#custom-modal').modal('hide');
        });

        $('#btn-dont-save-edited-study').click(function (event) {
            event.preventDefault();
            $('#custom-modal').trigger('deleteData');
            $('#custom-modal').modal('hide');
        });

        $('#btn-save-edited-study').click(function (event) {
            event.preventDefault();
            $('#custom-modal').trigger('saveDataClose');
            $('#custom-modal').modal('hide');
        });
    });
</script>