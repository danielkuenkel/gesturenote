<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <h4 class="modal-title" id="exampleModalLabel">Fragebogen</h4>
</div>
<div id="modal-body" class="modal-body">

    <div class="form-group form-group-no-margin">
        <div class="input-group">
            <span class="input-group-addon">Format</span>
            <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="Bitte wählen"/>
            <div class="input-group-btn select" id="addFormatSelect" role="group">
                <button class="btn btn-default btn-shadow btn-dropdown" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                    <li id="openQuestion"><a href="#"><?php echo $lang->questionFormats->openQuestion->text ?></a></li>
                    <li id="dichotomousQuestion"><a href="#"><?php echo $lang->questionFormats->dichotomousQuestion->text ?></a></li>
                    <li id="groupingQuestion"><a href="#"><?php echo $lang->questionFormats->groupingQuestion->text ?></a></li>
                    <li id="rating"><a href="#"><?php echo $lang->questionFormats->rating->text ?></a></li>
                    <li id="sumQuestion"><a href="#"><?php echo $lang->questionFormats->sumQuestion->text ?></a></li>
                    <li id="ranking"><a href="#"><?php echo $lang->questionFormats->ranking->text ?></a></li>
                    <li id="counter"><a href="#"><?php echo $lang->questionFormats->counter->text ?></a></li>
                </ul>
                <button class="btn btn-info btn-shadow disabled dropdown-disabled" id="addFormat" type="button"><span class="glyphicon glyphicon-plus"></span></button>
            </div>
        </div>
    </div>
</div>
<hr style="margin: 0;">
<div id="modal-body" class="modal-body">
    <div class="container-root" id="list-container"></div>
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
            var listContainer = $('#list-container');
            for (var i = 0; i < data.length; i++) {
                console.log(data[i]);
                renderFormatItem(listContainer, data[i]);
                updateBadges(listContainer, data[i].format);
            }
            checkCurrentListState(listContainer);
        }

        function saveData() {
            var itemList = $('#list-container').children();
            var questionnaire = new Array();
            for (var i = itemList.length; i--; ) {
                questionnaire.push(getFormatData(itemList[i]));
            }
            setLocalItem(currentIdForModal + '.data', questionnaire);
        }
</script>