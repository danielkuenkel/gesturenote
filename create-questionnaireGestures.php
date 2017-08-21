<?php
include './includes/language.php';
?>

<div class="modal-header" id="index">
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
    <div class="container-root" id="list-container"></div>
</div>

<hr id="factor-seperator" style="margin: 0;">

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

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> Speichern & Schließen</button>
</div>

<!--<script type="text/javascript" src="js/template-create.js"></script>-->
<script type="text/javascript">
    $(document).ready(function () {
        currentGUS = GUS_MULTIPLE_GESTURES;
        renderModalTitle($('#custom-modal').find('#modal-titel'), $('#custom-modal').find('#phase-step-title-input-container'));
        renderDimensions($('#dimension-controls'), translation.multipleGUS, $('#list-container'));

        renderAssembledGestures();
        renderAssembledTriggers();

        var data = getLocalItem(currentIdForModal + '.data');
        if (data !== null && data.gus && data.gus.length > 0) {
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
        $('#custom-modal').find('#btn-save-phase-step-title').click();
        
        var itemList = $('#list-container').children();
        var questionnaire = new Array();
        for (var i = 0; i < itemList.length; i++) {
            questionnaire.push(getFormatData(itemList[i]));
        }
        setLocalItem(currentIdForModal + '.data', {gus: questionnaire});
    }

    $('#dimension-controls').unbind('listItemAdded').bind('listItemAdded', function (event) {
        event.preventDefault();
        console.log('listitem added');
        var scrollTarget = $(this).closest('.modal');
        var newScrollTop = Math.max(0, scrollTarget.find('.modal-content').height() - scrollTarget.height() + 60);
        $(scrollTarget).animate({
            scrollTop: newScrollTop
        }, 200);
    });
</script>