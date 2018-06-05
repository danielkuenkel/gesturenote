<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->preview ?></h4>
</div>
<div id="modal-body" class="modal-body">
    <div class="alert-space alert-waiting-for-moderator"></div>
    <div class="question-container container-root"></div>
    <div class="clearfix" style="margin-top: 10px">
        <button class="btn btn-success btn-shadow hidden btn-next-question pull-right"><?php echo $lang->next ?> <span aria-hidden="true">&rarr;</span></button>
        <button class="btn btn-success btn-shadow hidden btn-questionnaire-done pull-right"><i class="fa fa-check"></i> <?php echo $lang->done ?></button>
    </div>
</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
</div>

<script>
    $(document).ready(function () {
        if (currentPreviewData) {
            currentQuestionIndex = 0;
            renderQuestionnaire($('#custom-modal'), currentPreviewData, null, true);
            if (currentPreviewData.length === 1) {
                var modal = $('#custom-modal');
                $(modal).find('.panel').removeClass('panel panel-default');
                $(modal).find('.panel-body').css({padding: 0});
                $(modal).find('.modal-body').css({paddingBottom: 0});
                $(modal).find('.btn-next-question').remove();
                $(modal).find('.btn-questionnaire-done').remove();
            }
        }
    });
</script>