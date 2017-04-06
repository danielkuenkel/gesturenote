<?php
include './includes/language.php';
?>
<div id="modal-body" class="modal-body">
    <div class="text-center text">
        <p>
            Die Erstellung dieser Studie wirklich beenden? Es werden alle Daten gelöscht!
        </p>
    </div>

    <div class="btn-group btn-group-justified">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-danger btn-shadow" id="btn-yes" data-dismiss="modal"><?php echo $lang->yes ?></button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-success btn-shadow" id="btn-no" data-dismiss="modal"><?php echo $lang->no ?></button>
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
            $('#custom-modal').modal('hide');
        });
    });
</script>