<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <h4 class="modal-title modal-title-editable" id="modal-titel"><span id="phase-step-title"></span> <i class="fa fa-pencil" id="btn-edit-phase-step-title"></i></h4>
    <div class="input-group hidden" id="phase-step-title-input-container" style="padding-right: 20px">
        <input class="form-control item-input-text" id="phase-step-title-input" type="text" value="" maxlength="30"/>
        <div class="input-group-btn">
            <button class="btn btn-default btn-success btn-shadow" id="btn-save-phase-step-title" data-toggle="tooltip"><i class="fa fa-check"></i></button>
        </div>
    </div>
</div>
<div id="modal-body" class="modal-body">
    <div id="list-container"></div>
</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo $lang->saveAndClose ?></button>
</div>

<script>
    $(document).ready(function () {
        renderModalTitle($('#custom-modal').find('#modal-titel'), $('#custom-modal').find('#phase-step-title-input-container'));
        
        var originData = getLocalItem(STUDY_ORIGIN_SUS);
        var customData = getLocalItem(currentIdForModal + '.data');

        if (customData !== null) {
            renderData(customData);
        } else if (originData !== null) {
            renderData(originData);
        } else {
            alert("No predefined data there");
        }
    });

    function renderData(data) {
        var listContainer = $('#list-container');
        for (var i = 0; i < data.length; i++) {
            renderFormatItem(listContainer, data[i]);
        }
        checkCurrentListState(listContainer);
    }

    function saveData() {
        $('#custom-modal').find('#btn-save-phase-step-title').click();
        
        var itemList = $('#list-container').children();
        var questionnaire = new Array();
        for (var i = 0; i < itemList.length; i++) {
            questionnaire.push(getFormatData(itemList[i]));
        }
        setLocalItem(currentIdForModal + '.data', questionnaire);
    }
</script>