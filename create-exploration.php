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

    <div class="panel panel-default root" id="general">
        <div class="panel-heading clearfix">
            <div class="panel-title">Allgemeines</div>
        </div>
        <div class="panel-body">
            <div class="panel-group" id="generalContainer">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">Titel</span>
                        <label class="sr-only" for="explorationTitle">Titel</label>
                        <input type="text" class="form-control" id="explorationTitle" placeholder="Titel einfügen">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">Beschreibung</span>
                        <label class="sr-only" for="explorationDescription">Beschreibung</label>
                        <textarea class="form-control" id="explorationDescription" rows="5" placeholder="Explorationsbeschreibung einfügen"></textarea>
                    </div>
                </div>

                <div class="btn-group" id="grouping-select">
                    <button class="btn btn-default switchButtonAddon">Darstellung</button>
                    <button class="btn btn-success btn-shadow btn-toggle-checkbox check no-gestures-assembled active" id="grouped" name="btn-success">Gruppiert (Zuständen zugewiesen)</button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox reset no-gestures-assembled inactive" id="ungrouped" name="btn-success">Nicht gruppiert</button>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="exploration">
        <div class="panel-heading clearfix">
            <div class="panel-title">Explorationselemente</div>
        </div>
        <div class="panel-body">
            <div class="panel-group" id="explorationContainer">

            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="observations">
        <div class="panel-heading clearfix">
            <div style="margin-top: 4px; display: inline-block">Beobachtungen</div>
            <div class="btn-group pull-right" id="useObservationsSwitch">
                <button class="btn btn-default switchButtonAddon">Nutzen?</button>
                <button class="btn btn-default btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                <button class="btn btn-warning btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
            </div>
        </div>
        <div class="panel-body hidden">

            <div class="form-group container-root" id="list-container"></div>

            <hr>

            <div class="form-group" style="margin-top: 20px">
                <div class="input-group">
                    <span class="input-group-addon">Beobachtungsformat</span>
                    <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="Bitte wählen"/>
                    <div class="input-group-btn select dropup" id="addFormatSelect" role="group">
                        <button class="btn btn-default btn-shadow btn-dropdown" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            <li id="counter"><a href="#"><?php echo $lang->questionFormats->counter->text ?></a></li>
                            <li id="openQuestion"><a href="#"><?php echo $lang->questionFormats->openQuestion->text ?></a></li>
                            <li id="dichotomousQuestion"><a href="#"><?php echo $lang->questionFormats->dichotomousQuestion->text ?></a></li>
                            <li id="groupingQuestion"><a href="#"><?php echo $lang->questionFormats->groupingQuestion->text ?></a></li>
                            <li id="rating"><a href="#"><?php echo $lang->questionFormats->rating->text ?></a></li>
                            <li id="sumQuestion"><a href="#"><?php echo $lang->questionFormats->sumQuestion->text ?></a></li>
                            <li id="ranking"><a href="#"><?php echo $lang->questionFormats->ranking->text ?></a></li>
                        </ul>
                        <button class="btn btn-info btn-shadow disabled dropdown-disabled" id="addFormat" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo $lang->saveAndClose ?></button>
</div>


<!--<script type="text/javascript" src="js/template-create.js"></script>-->
<script>
    $(document).ready(function () {
        renderModalTitle($('#custom-modal').find('#modal-titel'), $('#custom-modal').find('#phase-step-title-input-container'));
        
        var exploration = $('#form-item-container #exploration').clone();
        $('#explorationContainer').append(exploration);

        if (assembledGestures()) {
            renderAssembledGestures();
        } else {
            appendAlert(exploration, ALERT_NO_GESTURES_ASSEMBLED);
            $(exploration).find('.btn-add-explorationOption').addClass('hidden');
        }

//        var trigger = getLocalItem(ASSEMBLED_TRIGGER);
//        if (trigger && trigger.length > 0) {
        renderAssembledTriggers(null, true);
//        } else {
//            appendAlert(exploration, ALERT_NO_TRIGGER_ASSEMBLED);
//            $(exploration).find('.btn-add-explorationOption').addClass('hidden');
//        }

//        var scenes = getLocalItem(ASSEMBLED_SCENES);
//        if (scenes && scenes.length > 0) {
        renderAssembledScenes(null, true);
//        } else {
//            appendAlert(exploration, ALERT_NO_FEEDBACK_ASSEMBLED);
//            $(exploration).find('.btn-add-explorationOption').addClass('hidden');
//        }

        var data = getLocalItem(currentIdForModal + '.data');
        if (data) {
            renderData(data);
        }

        $('.btn-add-explorationOption').unbind('click').bind('click', function (event) {

            if (event.handled !== true)
            {
                event.handled = true;
                event.preventDefault();
                var item = $('#form-item-container').find('#explorationItem').clone().removeAttr('id');
                console.log('.btn-add-explorationOption', item);
                $(this).closest('.root').find('.option-container').append(item);
                checkCurrentListState($(this).closest('.root').find('.option-container'));
                TweenMax.from(item, .2, {y: -10, opacity: 0, clearProps: 'all'});
            }
        });
    });

    function renderData(data)
    {
        var items = data.exploration;

        $('#explorationTitle').val(data.title);
        $('#explorationDescription').val(data.description);
        $('#grouping-select').find('#' + data.grouping).click();

        var container;
        if (items !== undefined && items.length > 0) {

            container = $('#explorationContainer').find('.option-container');

            for (var i = 0; i < items.length; i++) {
                var clone = $('#form-item-container').find('#explorationItem').clone().removeAttr('id');
                $(clone).removeAttr('id');
                container.append(clone);

                if (items[i].sceneId === 'none') {
                    $(clone).find('.sceneSelect #none').click();
                } else {
                    var scene = getSceneById(items[i].sceneId);
                    if (scene) {
                        $(clone).find('.sceneSelect #' + scene.id).click();
                    } else {
                        appendAlert(clone, ALERT_ASSEMBLED_SCENE_REMOVED);
                    }
                }

                var gesture = getGestureById(items[i].gestureId);
                if (gesture && isGestureAssembled(gesture.id))
                {
                    $(clone).find('.gestureSelect #' + gesture.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                }

                var trigger = getTriggerById(items[i].triggerId);
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

        var obeservationItems = data.observations;
        if (obeservationItems !== undefined && obeservationItems.length > 0) {
            $('#useObservationsSwitch .switchButtonAddon').click();
            container = $('#list-container');

            var listContainer = $('#list-container');
            for (var i = 0; i < obeservationItems.length; i++) {
                renderFormatItem(listContainer, obeservationItems[i]);
                updateBadges(listContainer, obeservationItems[i].format);
            }
            checkCurrentListState(listContainer);
            checkDimensionItems($('#dimension-controls .dimension-container'));
        }
    }

    function saveData() {
        $('#custom-modal').find('#btn-save-phase-step-title').click();
        
        var explorationItem = $('#explorationContainer').find('.option-container').children();
        var obersvationItems = $('#list-container').children();
        var data = new Object();
        data.title = $('#explorationTitle').val();
        data.description = $('#explorationDescription').val();
        data.grouping = $('#grouping-select').find('.active').attr('id');

        if (explorationItem) {
            var set = new Array();
            for (var i = 0; i < explorationItem.length; i++) {
                var item = explorationItem[i];
                var gestureId = $(item).find('.gestureSelect .chosen').attr('id');
                var gesture = getGestureById(gestureId);
                
                var triggerId = $(item).find('.triggerSelect .chosen').attr('id');
                var trigger = getTriggerById(triggerId);
                if (triggerId === 'unselected' || triggerId === 'none') {
                    trigger = triggerId = 'none';
                } else {
                    trigger = getTriggerById(triggerId);
                }

                var sceneId = $(item).find('.sceneSelect .chosen').attr('id');
                var scene;
                if (sceneId === 'unselected' || sceneId === 'none') {
                    scene = sceneId = 'none';
                } else {
                    scene = getSceneById(sceneId);
                }
//                var repeats = $(item).find('#repeats-stepper .stepper-text').val();
//                var recognitionTime = $(item).find('#recognition-stepper .stepper-text').val();

//                console.log(feedbackId, gesture, trigger, feedback, $(item).find('.triggerSelect .chosen'));
                if (gesture && trigger && scene) {
                    set.push({sceneId: sceneId, triggerId: triggerId, gestureId: gestureId});
                }
            }
//            console.log(set);
            data.exploration = set;
        }

        var obersvationItems = $('#list-container').children();
        if ($('#useObservationsSwitch').find('#yes').hasClass('active') && obersvationItems.length > 0)
        {
            var questionnaire = new Array();
            for (var i = 0; i < obersvationItems.length; i++) {
                questionnaire.push(getFormatData(obersvationItems[i]));
            }
            data.observations = questionnaire;
        }

        setLocalItem(currentIdForModal + ".data", data);
    }

    $('#modal-body #observations #list-container').unbind('listItemAdded').bind('listItemAdded', function (event) {
        event.preventDefault();
        var scrollTarget = $(this).closest('.modal');
        var newScrollTop = Math.max(0, scrollTarget.find('.modal-content').height() - scrollTarget.height() + 60);
        $(scrollTarget).animate({
            scrollTop: newScrollTop
        }, 200);
    });
</script>