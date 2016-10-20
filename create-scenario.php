<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <h4 class="modal-title">Szenario-basierte Aufgabe</h4>
</div>
<div id="modal-body" class="modal-body">

    <div class="panel panel-default root" id="general">
        <div class="panel-heading clearfix">
            <div class="panel-title">Allgemeines</div>
        </div>
        <div class="panel-body">
            <div class="panel-group" id="generalContainer">
                <div class="form-group">
                    <input type="text" class="form-control" id="scenarioTitle" placeholder="Aufgabentitel einfügen">
                    <label class="sr-only" for="scenarioTitle">Aufgabentitel</label>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="scenarioDescription" rows="5" placeholder="Aufgabenbeschreibung einfügen"></textarea>
                    <label class="sr-only" for="scenarioDescription">Aufgabenbeschreibung</label>
                </div>

                <div class="alert-space alert-assembled-scene-removed"></div>

                <div class="form-group">
                    <div class="input-group"> 
                        <span class="input-group-addon">Start-Zustand</span>
                        <input class="form-control item-input-text show-dropdown readonly" type="text" value="" placeholder="Bitte wählen"/>
                        <div class="input-group-btn select sceneSelect" role="group">
                            <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                            <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--    <div class="panel panel-default root elicitation hidden" id="elicitationPanel">
            <div class="panel-heading clearfix">
                <div>Trigger in der Gestenermittlung</div>
            </div>
            <div class="panel-body">
                <div class="form-group container-root" id="elicitationContainer">
    
                </div>
            </div>
        </div>-->

    <div class="panel panel-default root" id="wozExperimentPanel">
        <div class="panel-heading clearfix">
            <div style="margin-top: 4px; display: inline-block">Wizard-of-Oz-Experiment</div>
            <div class="btn-group pull-right" id="useWozSwitch">
                <button class="btn btn-default switchButtonAddon">Nutzen?</button>
                <button class="btn btn-default btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success">Ja</button>
                <button class="btn btn-warning btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning">Nein</button>
            </div>
        </div>
        <div class="panel-body hidden">
            <div class="alert-space alert-no-scenes-assembled"></div>
            <div class="alert-space alert-no-gestures-assembled"></div>
            <div class="alert-space alert-no-trigger-assembled"></div>
            <div class="alert-space alert-no-feedback-assembled"></div>

            <div class="form-group container-root" id="wozExperimentContainer"></div>
        </div>
    </div>

    <div class="panel panel-default root" id="help-panel">
        <div class="panel-heading clearfix">
            <div style="margin-top: 4px; display: inline-block">Hilfe</div>
            <div class="btn-group pull-right" id="helpSwitch">
                <button class="btn btn-default switchButtonAddon">Nutzen?</button>
                <button class="btn btn-default btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success">Ja</button>
                <button class="btn btn-warning btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning">Nein</button>
            </div>
        </div>
        <div class="panel-body hidden">
            <div class="alert-space alert-no-scenes-assembled"></div>
            <div class="alert-space alert-no-gestures-assembled"></div>

            <div class="form-group container-root" id="helpContainer"></div>
        </div>
    </div>

    <div class="panel panel-default root" id="observations">
        <div class="panel-heading clearfix">
            <div style="margin-top: 4px; display: inline-block">Beobachtungen</div>
            <div class="btn-group pull-right" id="useObservationsSwitch">
                <button class="btn btn-default switchButtonAddon">Nutzen?</button>
                <button class="btn btn-default btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success">Ja</button>
                <button class="btn btn-warning btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning">Nein</button>
            </div>
        </div>
        <div class="panel-body hidden">

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
                    <div class="input-group-btn select" id="addFormatSelect" role="group">
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

            <hr>

            <div class="form-group container-root" id="list-container"></div>
            <!--<button class="btn btn-info btn-shadow pull-right" id="addPredefinedObservations" type="button"><span class="glyphicon glyphicon-plus"></span><span> Vordefiniertes Formular hinzufügen</span></button>-->

            <!--<div class="form-group container-root" id="list-container" style="margin-top: 65px"></div>-->

        </div>
    </div>


</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> Speichern & Schließen</button>
</div>

<!--<script type="text/javascript" src="js/template-create.js"></script>-->
<script>
    $('body').on('change', '#useGestureHelpSwitch', function (event) {
        event.preventDefault();
        var activeButton = $(this).parent().find('.active');

        if (!assembledGestures()) {
            if (activeButton.attr('id') === $(this).parent().find('#yes').attr('id')) {
                appendAlert($(this).closest('.root'), ALERT_NO_GESTURES_ASSEMBLED);
            } else {
                removeAlert($(this).closest('.root'), ALERT_NO_GESTURES_ASSEMBLED);
            }
        } else {
            if (activeButton.attr('id') === $(this).parent().find('#yes').attr('id')) {
                $(this).closest('.root').find('#gesture-help-select').removeClass('hidden');
            } else {
                $(this).closest('.root').find('#gesture-help-select').addClass('hidden');
            }
        }
    });

    $(document).ready(function () {
        var woz = $('#form-item-container #wozExperiment').clone().removeAttr('id');
        $('#wozExperimentContainer').append(woz);

        var help = $('#form-item-container #help').clone().removeAttr('id');
        $('#helpContainer').append(help);

        var scenes = getLocalItem(ASSEMBLED_SCENES);
        renderAssembledScenes();
        if (scenes === null) {
            appendAlert($('#wozExperimentPanel, #help-panel'), ALERT_NO_SCENES_ASSEMBLED);
            $('#wozExperimentContainer').find('.btn-add-woz-experimentOption').addClass('hidden');
            $('#helpContainer').find('.btn-add-helpOption').addClass('hidden');
        }

        renderAssembledGestures();
        if (!assembledGestures()) {
            appendAlert($('#wozExperimentPanel'), ALERT_NO_GESTURES_ASSEMBLED);
            $('#wozExperimentContainer').find('.btn-add-woz-experimentOption').addClass('hidden');
        }

        var trigger = getLocalItem(ASSEMBLED_TRIGGER);
        renderAssembledTriggers();
        if (!trigger) {
            appendAlert($('#wozExperimentPanel'), ALERT_NO_TRIGGER_ASSEMBLED);
            $('#wozExperimentContainer').find('.btn-add-woz-experimentOption').addClass('hidden');
        }

        var feedback = getLocalItem(ASSEMBLED_FEEDBACK);
        renderAssembledFeedback();
        if (!feedback) {
            appendAlert($('#wozExperimentPanel'), ALERT_NO_FEEDBACK_ASSEMBLED);
            $('#wozExperimentContainer').find('.btn-add-woz-experimentOption').addClass('hidden');
        }

        renderDimensions($('#dimension-controls'), translation.observationsScenario, $('#observations #list-container'));

        var data = getLocalItem(currentIdForModal + '.data');
        if (data) {
            renderData(data);
        }
    });

    function renderData(data)
    {
        $('#scenarioTitle').val(data.title);
        $('#scenarioDescription').val(data.description);

        if (data.scene) {

            if (data.scene === 'none') {
                $('#general .sceneSelect').find('#none').click();
            } else {
                var scene = getSceneById(data.scene);
                if (scene) {
                    $('#general .sceneSelect').find('#' + scene.id).click();
                } else {
                    appendAlert($('#general'), ALERT_ASSEMBLED_SCENE_REMOVED);
                }
            }
        }

        var container;
        var wozItems = data.woz;
        if (wozItems && wozItems.length > 0) {
//            if (!forPrefiniedObservation) {
                $('#useWozSwitch .switchButtonAddon').click();
//            }

            container = $('#wozExperimentContainer').find('.option-container');

            for (var i = 0; i < wozItems.length; i++) {
                var clone = $('#form-item-container').find('#wozExperimentItem').clone().removeAttr('id');
                $(clone).removeAttr('id');
                container.append(clone);

                var gesture = getGestureById(wozItems[i].gestureId);
                if (gesture && isGestureAssembled(gesture.id))
                {
                    $(clone).find('.gestureSelect #' + gesture.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                }

                var scene = getSceneById(wozItems[i].sceneId);
                if (scene) {
                    $(clone).find('#woz-scene #' + scene.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_SCENE_REMOVED);
                }

                var trigger = getTriggerById(wozItems[i].triggerId);
                if (trigger && getTriggerById(trigger.id) !== null) {
                    $(clone).find('.triggerSelect #' + trigger.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_TRIGGER_REMOVED);
                }

                if (wozItems[i].feedbackId === 'none') {
                    $(clone).find('.feedbackSelect #none').click();
                } else {
                    var feedback = getFeedbackById(wozItems[i].feedbackId);
                    if (feedback) {
                        $(clone).find('.feedbackSelect #' + feedback.id).click();
                    } else {
                        appendAlert(clone, ALERT_ASSEMBLED_FEEDBACK_REMOVED);
                    }
                }

                if (wozItems[i].transitionId === 'none') {
                    $(clone).find('#transition-scene #none').click();
                } else {
                    var scene = getSceneById(wozItems[i].transitionId);
                    if (scene) {
                        $(clone).find('#transition-scene #' + scene.id).click();
                    } else {
                        appendAlert(clone, ALERT_ASSEMBLED_SCENE_REMOVED);
                    }
                }

                $(clone).find('.stepper-text').val(wozItems[i].recognitionTime);
            }
            checkCurrentListState(container);
        }

        var helpItems = data.help;
        if (helpItems && helpItems.length > 0) {
//            if (!forPrefiniedObservation) {
                $('#helpSwitch .switchButtonAddon').click();
//            }

            container = $('#helpContainer').find('.option-container');
            for (var i = 0; i < helpItems.length; i++) {

                var clone = $('#form-item-container').find('#helpItem').clone().removeClass('id');
                clone.find('.option-text').val(helpItems[i].option);
                $(container).append(clone);

                var scene = getSceneById(helpItems[i].sceneId);
                if (scene) {
                    $(clone).find('.sceneSelect #' + scene.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_SCENE_REMOVED);
                }

                if (helpItems[i].useGestureHelp === true || helpItems[i].useGestureHelp === 'true') {
                    $(clone).find('#useGestureHelpSwitch #yes').click();
                    var gestureId = helpItems[i].gestureId;

                    if (gestureId !== null && !isGestureAssembled(gestureId)) {
                        appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                    } else if (gestureId !== null) {
                        var gesture = getGestureById(gestureId);
                        $(clone).find('.gestureSelect #' + gesture.id).click();
                    }
                }

                checkCurrentListState(container);
            }

            checkCurrentListState(container);
        }

        var obeservationItems = data.observations;

//        if (forPrefiniedObservation) {
//            obeservationItems = data;
//        } else {
//            obeservationItems
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
        var wozItems = $('#wozExperimentContainer').find('.option-container').children();
        var helpItems = $('#helpContainer').find('.option-container').children();

        var scenario = new Object();
        scenario.title = $('#scenarioTitle').val();
        scenario.description = $('#scenarioDescription').val();

        if ($('#general .sceneSelect .chosen').attr('id') !== 'unselected') {
            scenario.scene = $('#general .sceneSelect .chosen').attr('id');
        }

        var elicitatonTrigger = $('#elicitationContainer #elicitation .option-container').children();
        if (getLocalItem(STUDY).phase === TYPE_PHASE_ELICITATION && getLocalItem(ASSEMBLED_TRIGGER) &&
                elicitatonTrigger.length > 0) {
            var triggerArray = new Array();
            for (var i = 0; i < elicitatonTrigger.length; i++) {
                triggerArray.push(getTriggerById($(elicitatonTrigger[i]).find('.triggerSelect .chosen').attr('id')));
            }
            scenario.elicitationTrigger = triggerArray;
        }


        if ($('#useWozSwitch').find('#yes').hasClass('active')) {
            var woz = new Array();
            for (var i = 0; i < wozItems.length; i++) {
                var item = wozItems[i];
                var sceneId = $(item).find('#woz-scene .chosen').attr('id');
                var scene = getSceneById(sceneId);
                var transitionId = $(item).find('#transition-scene .chosen').attr('id');
                if (transitionId === 'unselected') {
                    transitionId = 'none';
                }
                var gestureId = $(item).find('.gestureSelect .chosen').attr('id');
                var gesture = getGestureById(gestureId);
                var triggerId = $(item).find('.triggerSelect .chosen').attr('id');
                var trigger = getTriggerById(triggerId);
                var feedbackId = $(item).find('.feedbackSelect .chosen').attr('id');
                var feedback;
                if (feedbackId === 'none') {
                    feedback = 'none';
                } else {
                    feedback = getFeedbackById(feedbackId);
                }

                if (getLocalItem(STUDY).phase === TYPE_PHASE_ELICITATION) {
                    if (scene && trigger && feedback) {
                        woz.push({sceneId: sceneId, triggerId: triggerId, gestureId: null, feedbackId: feedbackId, transitionId: transitionId});
                    }
                } else {
                    if (scene && trigger && gesture && feedback) {
                        woz.push({sceneId: sceneId, triggerId: triggerId, gestureId: gestureId, feedbackId: feedbackId, transitionId: transitionId});
                    }
                }
            }
            scenario.woz = woz;
        }

        if ($('#helpSwitch').find('#yes').hasClass('active'))
        {
            var scenarioHelp = new Array();
            for (var i = 0; i < helpItems.length; i++) {
                var item = helpItems[i];
                var help = new Object();
                help.sceneId = $(item).find('.sceneSelect .chosen').attr('id');
                help.option = $(item).find('.option-text').val().trim();
                var showGesture = $(item).find('#useGestureHelpSwitch').find('#yes').hasClass('active') ? true : false;
                help.useGestureHelp = showGesture;
                help.gestureId = showGesture === true ? $(item).find('.gestureSelect .chosen').attr('id') : null;

                if (getSceneById(help.sceneId) && help.option !== "") {
                    scenarioHelp.push(help);
                }
            }
            
            if (scenarioHelp.length > 0) {
                scenario.help = scenarioHelp;
            } else {
                scenario.help = null;
            }
        }

        var obersvationItems = $('#list-container').children();
        if ($('#useObservationsSwitch').find('#yes').hasClass('active') && obersvationItems.length > 0)
        {
            var questionnaire = new Array();
            for (var i = obersvationItems.length; i--; ) {
                questionnaire.push(getFormatData(obersvationItems[i]));
            }
            scenario.observations = questionnaire;
        }

        setLocalItem(currentIdForModal + ".data", scenario);
    }

//    $('#addPredefinedObservations').on('click', function () {
//        if (getLocalItem(PREDEFINED_OBSERVATIONS) !== null) {
//            renderData(getLocalItem(PREDEFINED_OBSERVATIONS), true);
//        }
//    });
</script>