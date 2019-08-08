<?php
include '../includes/language.php';
?>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->helpStudyPreview->title ?></h4>
</div>

<div id="modal-body" class="modal-body text">
</div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow pull-left" id="btn-more-infos"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $lang->moreInfos ?></button>
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
</div>

<script>
    $(document).ready(function () {
        $('#custom-modal').find('#modal-body').html(translation.helpStudyPreview.content);
        $('#custom-modal').find('#btn-more-infos').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $('#custom-modal').trigger('showHelp');
        });
    });
</script>