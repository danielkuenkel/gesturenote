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
//            console.log(currentPreviewData, $('#custom-modal').find('#list-container'));
            renderQuestionnaire($('#custom-modal'), currentPreviewData, null);
        }
    });
</script>