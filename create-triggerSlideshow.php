<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <h4 class="modal-title">Funktionen erraten (Slideshow)</h4>
</div>
<div id="modal-body" class="modal-body">

    <div class="panel panel-default root" id="general">
        <div class="panel-heading clearfix">
            <div class="panel-title">Allgemeines</div>
        </div>
        <div class="panel-body">
            <div class="panel-group" id="generalContainer">
                <div class="form-group">
                    <label class="sr-only" for="slideshowTitle">Titel</label>
                    <input type="text" class="form-control" id="slideshowTitle" placeholder="Titel einfügen">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="slideshowDescription">Beschreibung</label>
                    <textarea class="form-control" id="slideshowDescription" rows="5" placeholder="Slideshowbeschreibung einfügen"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="slideshow">
        <div class="panel-heading clearfix">
            <div class="panel-title">Elemente</div>
        </div>
        <div class="panel-body">
            <div class="panel-group" id="slideshowContainer">

            </div>
        </div>
    </div>

<!--    <div class="panel panel-default root" id="observations">
        <div class="panel-heading clearfix">
            <div style="margin-top: 4px; display: inline-block">Beobachtungen</div>
            <div class="btn-group pull-right" id="useObservationsSwitch">
                <button class="btn btn-default switchButtonAddon switchButtonAddonPanel">Nutzen?</button>
                <button class="btn btn-default btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success">Ja</button>
                <button class="btn btn-warning btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning">Nein</button>
            </div>
        </div>
        <div class="panel-body hidden">

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">Beobachtungsformat</span>
                    <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="Bitte wählen"/>
                    <div class="input-group-btn select" id="addFormatSelect" role="group">
                        <button class="btn btn-default btn-shadow btn-dropdown" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            <li id="counter"><a href="#">Zähler</a></li>
                            <li id="openQuestion"><a href="#">Offene Frage</a></li>
                            <li id="dichotomousQuestion"><a href="#">Ja/nein-Frage</a></li>
                            <li id="groupingQuestion"><a href="#">Eingruppierungs-Frage</a></li>
                        </ul>
                        <button class="btn btn-info btn-shadow disabled dropdown-disabled" id="addFormat" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                    </div>
                </div>
            </div>

            <div class="form-group container-root" id="list-container"></div>

            <button class="btn btn-info pull-right" id="addPredefinedObservations" type="button"><span class="glyphicon glyphicon-plus"></span><span> Vordefiniertes Formular hinzufügen</span></button>
        </div>
    </div>-->

</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> Speichern & Schließen</button>
</div>


<script type="text/javascript" src="js/template-create.js"></script>
<script>
        $(document).ready(function () {
            var slideshow = $('#form-item-container #trigger-slideshow').clone();
            $('#slideshowContainer').append(slideshow);

            if (assembledGestures()) {
                renderAssembledGestures();
            } else {
                appendAlert(slideshow, ALERT_NO_GESTURES_ASSEMBLED);
                $(slideshow).find('.btn-add-slideshowOption').addClass('hidden');
            }

            var trigger = getLocalItem(ASSEMBLED_TRIGGER);
            if (trigger && trigger.length > 0) {
                renderAssembledTriggers();
            } else {
                appendAlert(slideshow, ALERT_NO_TRIGGER_ASSEMBLED);
                $(slideshow).find('.btn-add-slideshowOption').addClass('hidden');
            }


            var data = getLocalItem(currentIdForModal + '.data');
            if (data) {
                renderData(data, false);
            }
        });

        function renderData(data, forPrefiniedObservation)
        {
            var slideshowItems = data.slideshow;

            $('#slideshowTitle').val(data.title);
            $('#slideshowDescription').val(data.description);
//            $('#slideshowTypeSwitch #' + data.slideshowFor).click();
//            $('#answerTime').val(data.answerTime);

            var container;

            if (slideshowItems !== undefined && slideshowItems.length > 0) {

                container = $('#slideshowContainer').find('.option-container');

                for (var i = 0; i < slideshowItems.length; i++) {
                    var gesture = getGestureById(slideshowItems[i].gestureId);
                    var trigger = getTriggerById(slideshowItems[i].triggerId);

                    var clone = $('#form-item-container').find('#slideshow-trigger-item').clone().removeAttr('id');
                    container.append(clone);

                    if (gesture && isGestureAssembled(gesture.id))
                    {
                        $(clone).find('.gestureSelect #' + gesture.id).click();
                    } else {
                        appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                    }

                    if (trigger) {
                        if (!getTriggerById(trigger.id)) {
                            appendAlert(clone, ALERT_ASSEMBLED_TRIGGER_REMOVED);
                        } else {
                            $(clone).find('.triggerSelect #' + trigger.id).click();
                        }
                    }
                }
                checkCurrentListState(container);
            }


//            var obeservationItems;
//            if (!forPrefiniedObservation) {
//                obeservationItems = data.observations;
//            } else {
//                obeservationItems = data;
//            }
//            if (obeservationItems !== undefined && obeservationItems.length > 0) {
//                if (!forPrefiniedObservation) {
//                    $('#useObservationsSwitch .switchButtonAddon').click();
//                }
//
//                container = $('#list-container');
//
//                var listContainer = $('#list-container');
//                for (var i = 0; i < obeservationItems.length; i++) {
//                    renderFormatItem(listContainer, obeservationItems[i]);
//                    updateBadges(listContainer, obeservationItems[i].format);
//                }
//                checkCurrentListState(listContainer);
//            }
        }

        function saveData() {
            var slideshowItems = $('#slideshowContainer').find('.option-container').children();
            var obersvationItems = $('#list-container').children();

            var slideshow = new Slideshow();
            slideshow.title = $('#slideshowTitle').val();
            slideshow.description = $('#slideshowDescription').val();
//            slideshow.slideshowFor = $('#slideshowTypeSwitch .active').attr('id');
//            slideshow.answerTime = $('#answerTime').val();

            if (slideshowItems) {
                var set = new Array();
                for (var i = 0; i < slideshowItems.length; i++) {
                    var item = slideshowItems[i];
                    var gestureId = $(item).find('.gestureSelect .chosen').attr('id');
                    var gesture = getGestureById(gestureId);
                    var triggerId = $(item).find('.triggerSelect .chosen').attr('id');
                    var trigger = getTriggerById(triggerId);
//                    var feedbackId = $(item).find('.feedbackSelect .chosen').attr('id');
//                    var feedback = getFeedbackById(feedbackId);

                    if (gesture && trigger) {
                        set.push(new SlideshowItem(gestureId, triggerId));
                    }
                }
                slideshow.slideshow = set;
            }

//            var obersvationItems = $('#list-container').children();
//            if ($('#useObservationsSwitch').find('#yes').hasClass('active') && obersvationItems.length > 0)
//            {
//                var questionnaire = new Array();
//                for (var i = obersvationItems.length; i--; ) {
//                    questionnaire.push(getFormatData(obersvationItems[i]));
//                }
//                slideshow.observations = questionnaire;
//            }

            setLocalItem(currentIdForModal + ".data", slideshow);
        }

//        $('#addPredefinedObservations').on('click', function () {
//            if (getLocalItem(PREDEFINED_OBSERVATIONS) !== null) {
//                renderData(getLocalItem(PREDEFINED_OBSERVATIONS), true);
//            }
//        });

        $('body').on('click', '.btn-add-slideshowOption', function (event) {
            if (event.handled !== true)
            {
                event.handled = true;
                event.preventDefault();
                $(this).prev().append($('#form-item-container').find('#slideshow-trigger-item').clone().removeAttr('id'));
                checkCurrentListState($(this).prev());
            }
        });
</script>