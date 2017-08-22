<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <h4 class="modal-title" id="exampleModalLabel">Einverständniserklärung</h4>
</div>
<div id="modal-body" class="modal-body">
    <div class="form-group">
        <textarea class="form-control" id="declaration" rows="10" placeholder="Erklärung einfügen"></textarea>
        <label class="sr-only" for="declaration">Einverständniserklärung</label>
    </div>
</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> Speichern & Schließen</button>
</div>


<!--<script type="text/javascript" src="js/template-create.js"></script>-->
<script>
    $(document).ready(function () {
        var data = getLocalItem(currentIdForModal + '.data');
        if (data !== null) {
            renderData(data);
        }
    });

    function renderData(data) {
        $('#declaration').val(data);
    }

    function saveData() {
        setLocalItem(currentIdForModal + ".data", $('#declaration').val());
    }
</script>