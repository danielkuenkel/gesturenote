<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title" id="exampleModalLabel">Kataloge</h4>
</div>
<div id="modal-body" class="modal-body text">
    <div>
        <div style="font-weight: bold"><?php echo $lang->studyCatalogs->gestures ?></div>
        <span><?php echo $lang->createStudyInfos->catalogs->text1 ?></span>
    </div>
    <div style="margin-top: 20px">
        <div style="font-weight: bold"><?php echo $lang->studyCatalogs->trigger ?></div>
        <span><?php echo $lang->createStudyInfos->catalogs->text2 ?></span>
    </div>
    <div style="margin-top: 20px">
        <div style="font-weight: bold"><?php echo $lang->studyCatalogs->feedback ?></div>

        <span><?php echo $lang->createStudyInfos->catalogs->text4 ?></span>
    </div>
    <div style="margin-top: 20px">
        <div style="font-weight: bold"><?php echo $lang->studyCatalogs->scenes ?></div>
        <span><?php echo $lang->createStudyInfos->catalogs->text3 ?></span>
        <ul>
            <li><?php echo $lang->createStudyInfos->catalogs->text3Image ?></li>
            <li><?php echo $lang->createStudyInfos->catalogs->text3Web ?></li>
            <li><?php echo $lang->createStudyInfos->catalogs->text3VideoEmbed ?></li>
            <li><?php echo $lang->createStudyInfos->catalogs->text3Pidoco ?></li>
        </ul>
    </div>
</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow pull-left"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <?php echo $lang->manual ?></button>
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal"><?php echo $lang->close ?></button>
</div>