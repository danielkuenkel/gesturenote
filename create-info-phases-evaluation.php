<?php
include './includes/language.php';
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title" id="exampleModalLabel">Leitfaden (Gesten-Evaluierung)</h4>
</div>
<div id="modal-body" class="modal-body">
    Was ist das, wofür wird es benötigt?
</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow pull-left"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <?php echo $lang->manual ?></button>
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal"><?php echo $lang->close ?></button>
</div>