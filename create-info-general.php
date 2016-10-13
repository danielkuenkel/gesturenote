<?php
include './includes/language.php';
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->studyCreateNav->general ?></h4>
</div>
<div id="modal-body" class="modal-body text">
    <div>
        <div style="font-weight: bold"><?php echo $lang->studyTitle ?></div>
        <span><?php echo $lang->createStudyInfos->general->text1 ?></span>
    </div>
    <div style="margin-top: 20px">
        <div style="font-weight: bold"><?php echo $lang->studyDescription ?></div>
        <span><?php echo $lang->createStudyInfos->general->text2 ?></span>
    </div>
    <div style="margin-top: 20px">
        <div style="font-weight: bold"><?php echo $lang->studyPhase ?></div>
        <span><?php echo $lang->createStudyInfos->general->text3 ?></span>
    </div>
    <div style="margin-top: 20px">
        <div style="font-weight: bold"><?php echo $lang->studySurveyType ?></div>
        <span><?php echo $lang->createStudyInfos->general->text4 ?></span>
    </div>
</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow pull-left"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <?php echo $lang->manual ?></button>
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal"><?php echo $lang->close ?></button>
</div>