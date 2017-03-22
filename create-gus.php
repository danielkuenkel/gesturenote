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

<div class="modal-body" id="general">
    <div class="alert-space alert-assembled-gesture-removed"></div>
    <div class="alert-space alert-assembled-trigger-removed"></div>

    <div class="form-group" id="forGesture">
        <div class="input-group">
            <span class="input-group-addon">Geste</span>
            <input class="form-control item-input-text option-gesture show-dropdown readonly" type="text" value=""/>
            <div class="input-group-btn select gestureSelect" role="group">
                <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                </ul>
            </div>
        </div>

        <div class="input-group" id="gesture-trigger" style="margin-top: 10px">
            <span class="input-group-addon">Funktion</span>
            <input class="form-control item-input-text option-trigger show-dropdown readonly" type="text" value="" placeholder="Bitte wählen"/>
            <div class="input-group-btn select triggerSelect" role="group">
                <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
            </div>
        </div>

        <div class="input-group" id="gesture-feedback" style="margin-top: 10px">
            <span class="input-group-addon">Feedback</span>
            <input class="form-control item-input-text option-feedback show-dropdown readonly" type="text" value="" placeholder="Bitte wählen"/>
            <div class="input-group-btn select feedbackSelect no-none" role="group">
                <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
            </div>
        </div>
    </div>

</div>

<hr id="factor-seperator" style="margin: 0;">

<div id="modal-body" class="modal-body">
    <div class="container-root" id="list-container"></div>
</div>

<hr id="factor-seperator" style="margin: 0;">

<div class="modal-body">
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
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> Speichern & Schließen</button>
</div>

<script>
    $(document).ready(function () {
        renderAssembledGestures($('#forGesture'));
        renderAssembledTriggers($('#gesture-trigger'));
        renderAssembledFeedback($('#gesture-feedback'));
        renderModalTitle($('#custom-modal').find('#modal-titel'), $('#custom-modal').find('#phase-step-title-input-container'));

        renderDimensions($('#dimension-controls'), translation.singleGUS, $('#list-container'));

        var data = getLocalItem(currentIdForModal + '.data');
        if (data !== null) {
            renderData(data);
        }
    });

    function renderData(data) {
        if (data.gestureId) {
            if (isGestureAssembled(data.gestureId)) {
                $('#forGesture').find('#' + data.gestureId).click();
            } else {
                appendAlert($('#general'), ALERT_ASSEMBLED_GESTURE_REMOVED);
            }
        }

        if (data.triggerId) {
            var trigger = getTriggerById(data.triggerId);
            if (trigger === null) {
                appendAlert($('#general'), ALERT_ASSEMBLED_TRIGGER_REMOVED);
            } else {
                $('#gesture-trigger').find('#' + data.triggerId).click();
            }
        }
        if (data.feedbackId) {
            var feedback = getFeedbackById(data.feedbackId);
            if (feedback === null) {
                appendAlert($('#general'), ALERT_ASSEMBLED_FEEDBACK_REMOVED);
            } else {
                $('#gesture-feedback').find('#' + data.feedbackId).click();
            }
        }


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

        var gestureId = null;
        var triggerId = null;
        var feedbackId = null;

        if ($('#forGesture .chosen').attr('id') !== 'unselected') {
            gestureId = $('#forGesture .chosen').attr('id');
        }

        if ($('#gesture-trigger .chosen').attr('id') !== 'unselected') {
            triggerId = $('#gesture-trigger .chosen').attr('id');
        }

        if ($('#gesture-feedback .chosen').attr('id') !== 'unselected') {
            feedbackId = $('#gesture-feedback .chosen').attr('id');
        }

        setLocalItem(currentIdForModal + '.data', {gestureId: gestureId, triggerId: triggerId, feedbackId: feedbackId, gus: questionnaire});
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