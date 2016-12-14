<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Gesten-Klassifizierung</h4>
</div>
<div id="modal-body" class="modal-body text">
    <div>
        <div style="font-weight: bold"><?php echo $lang->studyCatalogs->gestures ?></div>
        <span><?php echo $lang->createStudyInfos->catalogs->text1 ?></span>
    </div>
</div>
<div id="modal-footer" class="modal-footer">
    <!--<button type="button" class="btn btn-default btn-shadow" id="btn-more-help">Mehr Hilfe</button>-->
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal">Schließen</button>
</div>