<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <h4 class="modal-title" id="exampleModalLabel">Gesture Usability Scale - Fragen zu einzelner Geste</h4>
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

    <div id="dimension-controls">
        <div class="dimension-container" id="container-effectiveness">
            <h4 style="margin-top: 0px; color: #3379b7">Zweckmäßigkeit</h4>
            <div class="dimension-btn-group">
                <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all">Alle</button>
            </div>
        </div>
        <div class="dimension-container" id="container-efficiency">
            <h4 style="color: #3379b7">Effizienz</h4>
            <div class="dimension-btn-group">
                <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all">Alle</button>
            </div>
        </div>
        <div class="dimension-container" id="container-satisfaction">
            <h4 style="color: #3379b7">Zufriedenheit</h4>
            <div class="dimension-btn-group">
                <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all">Alle</button>
            </div>
        </div>
    </div>


    <!--    <div id="dimension-btn-group">
            <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all">Alle</button>
        </div>-->


</div>
<hr id="factor-seperator" style="margin: 0;">
<div id="modal-body" class="modal-body">

    <div class="container-root" id="list-container"></div>

    <!--<button type="button" class="btn btn-warning btn-shadow" id="btn-reset-origin-data"><span class="glyphicon glyphicon-repeat"></span> Original GUS wiederherstellen</button>-->
    <!--<button type="button" class="btn btn-info btn-shadow pull-right" id="btn-add-gus-item"><span class="glyphicon glyphicon-plus"></span> Ein neues Item hinzufügen</button>-->

</div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> Speichern & Schließen</button>
</div>


<script type="text/javascript" src="js/template-create.js"></script>
<script>
        $(document).ready(function () {
            currentGUS = GUS_SINGLE_GESTURES;
            renderDimensions($('#dimension-controls'), getLocalItem(STUDY_ORIGIN_GUS));
            renderAssembledGestures($('#forGesture'));
            renderAssembledTriggers($('#gesture-trigger'));
            renderAssembledFeedback($('#gesture-feedback'));

            var data = getLocalItem(currentIdForModal + '.data');
            if (data !== null) {
                renderData(data);
            }
        });

        $('.show-hole-text').tooltip({
            container: 'body',
            placement: "top"
        });

        var gusGestureId = null;
        function renderData(data) {
            if (data.gestureId) {
                if (isGestureAssembled(data.gestureId)) {
                    gusGestureId = data.gestureId;
                    $('#forGesture').find('#' + data.gestureId).click();
                } else {
                    appendAlert($('#general'), ALERT_ASSEMBLED_GESTURE_REMOVED);
                }
            } else {
                gusGestureId = null;
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
            var itemList = $('#list-container').children();
            var questionnaire = new Array();
            for (var i = itemList.length; i--; ) {
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

//        $('#btn-add-gus-item').on('click', function () {
//            var item = $('#form-item-container').find('#gusSingle').clone();
//            $('#list-container').append(item);
//            checkCurrentListState($('#list-container'));
//        });

//        $('#btn-reset-origin-data').on('click', function () {
//            var data = getLocalItem(STUDY_ORIGIN_GUS);
//            if (data !== null) {
//                $('#list-container').empty();
//                renderData(data);
//            }
//            checkCurrentListState($('#list-container'));
//        });
</script>