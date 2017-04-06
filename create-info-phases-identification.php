<?php
include './includes/language.php';
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->studyCreateNav->phases ?> (<?php echo $lang->gestureElicitation ?>)</h4>
</div>
<div id="modal-body" class="modal-body text">
    <div>
        <div style="font-weight: bold"><?php echo $lang->formats->letterOfAcceptance->text ?></div>
        <span><?php echo $lang->createStudyInfos->phases->letterOfAcceptance ?></span>
    </div>
    <div style="margin-top: 20px">
        <div style="font-weight: bold"><?php echo $lang->formats->thanks->text ?></div>
        <span><?php echo $lang->createStudyInfos->phases->thanks ?></span>
    </div>
    <div style="margin-top: 20px">
        <div style="font-weight: bold"><?php echo $lang->formats->questionnaire->text ?></div>
        <span><?php echo $lang->createStudyInfos->phases->questionnaire ?></span>
        <ul>
            <li><?php echo $lang->createStudyInfos->phases->counter ?></li>
            <li><?php echo $lang->createStudyInfos->phases->openQuestion ?></li>
            <li><?php echo $lang->createStudyInfos->phases->dichotomousQuestion ?></li>
            <li><?php echo $lang->createStudyInfos->phases->groupingQuestion ?></li>
            <li><?php echo $lang->createStudyInfos->phases->groupingQuestionOptions ?></li>
            <li><?php echo $lang->createStudyInfos->phases->sumQuestion ?></li>
            <li><?php echo $lang->createStudyInfos->phases->ranking ?></li>
            <li><?php echo $lang->createStudyInfos->phases->rating ?></li>
            <li><?php echo $lang->createStudyInfos->phases->matrix ?></li>
        </ul>
    </div>
    <div style="margin-top: 20px">
        <div style="font-weight: bold"><?php echo $lang->formats->identification->text ?></div>
        <p><?php echo $lang->createStudyInfos->phases->identification ?></p>
        <p><?php echo $lang->createStudyInfos->phases->identificationGestures ?></p>
        <span><?php echo $lang->createStudyInfos->phases->identificationTrigger ?></span>
    </div>
</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow pull-left disabled"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <?php echo $lang->manual ?></button>
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal"><?php echo $lang->close ?></button>
</div>