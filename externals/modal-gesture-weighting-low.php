<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->extractionContent->weightingLowModalHeadline ?></h4>
</div>
<div id="modal-body" class="modal-body text">
    <?php echo $lang->extractionContent->weightingLowModalText ?>
</div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
</div>

<script>
    var modal = $('#custom-modal');
    $(document).ready(function () {
        $(modal).find('.gesture-weighting').text($('#custom-modal').attr('data-gesture-weighting'));
        $('#custom-modal').removeAttr('data-gesture-weighting');
    });
</script>