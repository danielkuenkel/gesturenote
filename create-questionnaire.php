<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <h4 class="modal-title modal-title-editable" id="modal-titel"><span id="phase-step-title"></span> <i class="fa fa-pencil" id="btn-edit-phase-step-title"></i></h4>
    <div class="input-group hidden" id="phase-step-title-input-container" style="padding-right: 20px">
        <input class="form-control item-input-text" id="phase-step-title-input" type="text" value="" maxlength="30"/>
        <div class="input-group-btn">
            <button class="btn btn-default btn-shadow" id="btn-save-phase-step-title" data-toggle="tooltip"><i class="fa fa-check"></i></button>
        </div>
    </div>
</div>
<div id="modal-body" class="modal-body">
    <div class="container-root" id="list-container"></div>
</div>
<hr style="margin: 0;">
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
                    <li id="groupingQuestionOptions"><a href="#"><?php echo $lang->questionFormats->groupingQuestionOptions->text ?></a></li>
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
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo $lang->saveAndClose ?></button>
</div>

<script>
    $(document).ready(function () {
        var data = getLocalItem(currentIdForModal + '.data');
        if (data !== null) {
            renderData(data);
        }

        renderModalTitle($('#custom-modal').find('#modal-titel'), $('#custom-modal').find('#phase-step-title-input-container'));
    });

    function renderData(data) {
        var listContainer = $('#list-container');
        for (var i = 0; i < data.length; i++) {
            renderFormatItem(listContainer, data[i]);
            updateBadges(listContainer, data[i].format);
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

    $('#list-container').unbind('listItemAdded').bind('listItemAdded', function (event) {
        event.preventDefault();
        var scrollTarget = $(this).closest('.modal');
        var newScrollTop = Math.max(0, scrollTarget.find('.modal-content').height() - scrollTarget.height() + 60);
        $(scrollTarget).animate({
            scrollTop: newScrollTop
        }, 200);
    });
</script>