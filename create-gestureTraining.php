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

    <div class="panel panel-default root" id="general">
        <div class="panel-heading clearfix">
            <div class="panel-title">Allgemeines</div>
        </div>
        <div class="panel-body">
            <div class="panel-group" id="generalContainer">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">Titel</span>
                        <label class="sr-only" for="scenarioTitle">Titel</label>
                        <input type="text" class="form-control" id="trainingTitle" placeholder="Titel einfügen">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">Beschreibung</span>
                        <label class="sr-only" for="scenarioDescription">Trainingsbeschreibung</label>
                        <textarea class="form-control" id="trainingDescription" rows="5" placeholder="Trainingsbeschreibung einfügen"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="training">
        <div class="panel-heading clearfix">
            <div class="panel-title">Trainingselemente</div>
        </div>
        <div class="panel-body">
            <div class="panel-group" id="trainingContainer">

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
        
        var training = $('#form-item-container #gestureTraining').clone();
        $('#trainingContainer').append(training);

        if (assembledGestures()) {
            renderAssembledGestures();
        } else {
            appendAlert(training, ALERT_NO_GESTURES_ASSEMBLED);
            $(training).find('.btn-add-gestureTrainingOption').addClass('hidden');
        }

        var trigger = getLocalItem(ASSEMBLED_TRIGGER);
        if (trigger && trigger.length > 0) {
            renderAssembledTriggers();
        } else {
            appendAlert(training, ALERT_NO_TRIGGER_ASSEMBLED);
            $(training).find('.btn-add-gestureTrainingOption').addClass('hidden');
        }

        var feedback = getLocalItem(ASSEMBLED_FEEDBACK);
        if (feedback && feedback.length > 0) {
            renderAssembledFeedback();
        } else {
            appendAlert(training, ALERT_NO_FEEDBACK_ASSEMBLED);
            $(training).find('.btn-add-gestureTrainingOption').addClass('hidden');
        }

        var help = $('#help').clone();
        help.removeAttr('id');
        $('#helpContainer').append(help);

        renderDimensions($('#dimension-controls'), translation.observationsGestureTraining, $('#observations #list-container'));

        var data = getLocalItem(currentIdForModal + '.data');
        if (data) {
            renderData(data);
        }
    });

    function renderData(data)
    {
        var trainingItems = data.training;

        $('#trainingTitle').val(data.title);
        $('#trainingDescription').val(data.description);

        var container;
        if (trainingItems !== undefined && trainingItems.length > 0) {

            container = $('#trainingContainer').find('.option-container');

            for (var i = 0; i < trainingItems.length; i++) {
                var clone = $('#gestureTrainingItem').clone().removeClass('hidden');
                $(clone).removeAttr('id');
                container.append(clone);

                var gesture = getGestureById(trainingItems[i].gestureId);
                if (gesture && isGestureAssembled(gesture.id))
                {
                    $(clone).find('.gestureSelect #' + gesture.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                }

                var trigger = getTriggerById(trainingItems[i].triggerId);
                if (trigger) {
                    if (!getTriggerById(trigger.id)) {
                        appendAlert(clone, ALERT_ASSEMBLED_TRIGGER_REMOVED);
                    } else {
                        $(clone).find('.triggerSelect #' + trigger.id).click();
                    }
                }

                if (trainingItems[i].feedbackId === 'none') {
                    $(clone).find('.feedbackSelect #none').click();
                } else {
                    var feedback = getFeedbackById(trainingItems[i].feedbackId);
                    if (feedback) {
                        $(clone).find('.feedbackSelect #' + feedback.id).click();
                    } else {
                        appendAlert(clone, ALERT_ASSEMBLED_FEEDBACK_REMOVED);
                    }
                }

                var repeats = trainingItems[i].repeats;
                $(clone).find('#repeats-stepper .stepper-text').val(parseInt(repeats));
                if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
                    $(clone).find('#recognition-stepper').removeClass('hidden');
                    var recognitionTime = trainingItems[i].recognitionTime;
                    $(clone).find('#recognition-stepper').val(parseInt(recognitionTime));
                }
            }
            checkCurrentListState(container);
        }

        var obeservationItems = data.observations;
//        if (!forPrefiniedObservation) {
//            obeservationItems
//        } else {
//            obeservationItems = data.gus;
//        }
        if (obeservationItems !== undefined && obeservationItems.length > 0) {
//            if (!forPrefiniedObservation) {
            $('#useObservationsSwitch .switchButtonAddon').click();
//            }

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
        
        var traningItems = $('#trainingContainer').find('.option-container').children();
        var obersvationItems = $('#list-container').children();
        var training = new Object();
        training.title = $('#trainingTitle').val();
        training.description = $('#trainingDescription').val();

        if (traningItems) {
            var set = new Array();
            for (var i = 0; i < traningItems.length; i++) {
                var item = traningItems[i];
                var gestureId = $(item).find('.gestureSelect .chosen').attr('id');
                var gesture = getGestureById(gestureId);
                var triggerId = $(item).find('.triggerSelect .chosen').attr('id');
                var trigger = getTriggerById(triggerId);
                var feedbackId = $(item).find('.feedbackSelect .chosen').attr('id');
                var feedback;
                if (feedbackId === 'unselected' || feedbackId === 'none') {
                    feedback = feedbackId = 'none';
                } else {
                    feedback = getFeedbackById(feedbackId);
                }
                var repeats = $(item).find('#repeats-stepper .stepper-text').val();
                var recognitionTime = $(item).find('#recognition-stepper .stepper-text').val();

//                console.log(feedbackId, gesture, trigger, feedback, $(item).find('.triggerSelect .chosen'));
                if (gesture && trigger && feedback) {
                    set.push({gestureId: gestureId, triggerId: triggerId, feedbackId: feedbackId, repeats: repeats, recognitionTime: recognitionTime});//new TrainingItem(gestureId, triggerId, feedbackId, repeats, recognitionTime));
                }
            }
//            console.log(set);
            training.training = set;
        }

        var obersvationItems = $('#list-container').children();
        if ($('#useObservationsSwitch').find('#yes').hasClass('active') && obersvationItems.length > 0)
        {
            var questionnaire = new Array();
            for (var i = 0; i < obersvationItems.length; i++) {
                questionnaire.push(getFormatData(obersvationItems[i]));
            }
            training.observations = questionnaire;
        }

        setLocalItem(currentIdForModal + ".data", training);
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