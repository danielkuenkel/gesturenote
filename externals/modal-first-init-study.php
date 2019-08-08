<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
        <?php echo $lang->pleaseNote ?>
    </h4>
</div>

<div id="modal-body" class="modal-body">
    <div class="text">
        <p>
            <?php echo $lang->createNewStudyFirstInit ?>
        </p>
    </div>
</div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-shadow btn-default" data-dismiss="modal"><i class="fa fa-check"></i> OK</button>
</div>

<script>
    $(document).ready(function () {
        
    });
</script>