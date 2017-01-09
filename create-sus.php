<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <h4 class="modal-title" id="exampleModalLabel"><?php echo $lang->formats->sus->text ?></h4>
</div>
<div id="modal-body" class="modal-body">
    <div id="list-container"></div>
</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo $lang->saveAndClose ?></button>
</div>

<script>
    $(document).ready(function () {
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
        var itemList = $('#list-container').children();
        var questionnaire = new Array();
        for (var i = 0; i < itemList.length; i++) {
            questionnaire.push(getFormatData(itemList[i]));
        }
        setLocalItem(currentIdForModal + '.data', questionnaire);
    }
</script>