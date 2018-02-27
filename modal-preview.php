<?php
include 'includes/language.php';
?>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->preview ?></h4>
</div>
<div id="modal-body" class="modal-body">
        <div class="question-container container-root"></div>
</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal"><i class="fa fa-close"></i> Schließen</button>
</div>

<script>
    $(document).ready(function () {
        if (currentPreviewData) {
            renderQuestionnaire($('#custom-modal'), currentPreviewData, null);
            if (currentPreviewData.length === 1) {
                $('#custom-modal').find('.panel').removeClass('panel panel-default');
                $('#custom-modal').find('.panel-body').css({padding: 0});
                $('#custom-modal').find('.modal-body').css({paddingBottom: 0});
            }
        }
    });
</script>