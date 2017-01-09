<?php
include './includes/language.php';
?>

<div class="modal-header" id="index">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <h4 class="modal-title" id="exampleModalLabel">Gesture Usability Scale - Mehrere Gesten</h4>
</div>

<div id="modal-body" class="modal-body">

    <div id="dimension-controls">
        <div class="dimension-container" id="container-effectiveness">
            <h4 style="margin-top: 0px; color: #3379b7"><?php echo $lang->mainDimensions->effectiveness ?></h4>
            <div class="dimension-btn-group">
                <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
            </div>
        </div>
        <div class="dimension-container" id="container-efficiency">
            <h4 style="color: #3379b7"><?php echo $lang->mainDimensions->efficiency ?></h4>
            <div class="dimension-btn-group">
                <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
            </div>
        </div>
        <div class="dimension-container" id="container-satisfaction">
            <h4 style="color: #3379b7"><?php echo $lang->mainDimensions->satisfaction ?></h4>
            <div class="dimension-btn-group">
                <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
            </div>
        </div>
    </div>

</div>
<hr id="factor-seperator" style="margin: 0;">
<div id="modal-body" class="modal-body">

    <div class="container-root" id="list-container"></div>
    <!--<button type="button" class="btn btn-info pull-right" id="btn-add-predefined-gesture-questionnaire"><span class="glyphicon glyphicon-plus"></span> Vordefinierte Fragen hinzufügen</button>-->

</div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> Speichern & Schließen</button>
</div>

<!--<script type="text/javascript" src="js/template-create.js"></script>-->
<script type="text/javascript">
    $(document).ready(function () {
        currentGUS = GUS_MULTIPLE_GESTURES;
        renderDimensions($('#dimension-controls'), translation.multipleGUS, $('#list-container'));

        renderAssembledGestures();
        renderAssembledTriggers();

        var data = getLocalItem(currentIdForModal + '.data');
        if (data !== null) {
            renderData(data);
        }
    });

    function renderData(data) {
        var listContainer = $('#list-container');
        for (var i = 0; i < data.gus.length; i++) {
            renderFormatItem(listContainer, data.gus[i]);
            updateBadges(listContainer, data.gus[i].format);
        }
        checkDimensionItems($('#dimension-controls .dimension-container'));
        checkCurrentListState(listContainer);
    }

    function saveData() {
        var itemList = $('#list-container').children();
        var questionnaire = new Array();
        for (var i = 0; i < itemList.length; i++) {
            questionnaire.push(getFormatData(itemList[i]));
        }
        setLocalItem(currentIdForModal + '.data', {gus: questionnaire});
    }

//        $('#btn-reset-origin-data').on('click', function () {
//            var data = getLocalItem(PREDEFINED_GESTURE_QUESTIONNAIRE);
//            if (data !== null) {
//                $('#list-container').empty();
//                renderData(data);
//            }
//            checkCurrentListState($('#list-container'));
//        });


</script>