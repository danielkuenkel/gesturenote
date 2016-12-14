<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <h4 class="modal-title">Identifikation</h4>
</div>
<div id="modal-body" class="modal-body">

    <div class="panel panel-default root" id="general">
        <div class="panel-heading clearfix">
            <div class="panel-title">Allgemeines</div>
        </div>
        <div class="panel-body">
            <div class="panel-group" id="generalContainer">
                <div class="form-group">
                    <label class="sr-only" for="identificationTitle">Titel</label>
                    <input type="text" class="form-control" id="identificationTitle" placeholder="Titel einfügen">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="identificationDescription">Einleitung</label>
                    <textarea class="form-control" id="identificationDescription" rows="5" placeholder="Einleitung einfügen"></textarea>
                </div>
                <!--<div class="row">-->
                <!--<div class="col-md-6">-->
                <div class="btn-group" id="identificationTypeSwitch">
                    <button class="btn btn-default switchButtonAddon">Was soll identifiziert werden?</button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="gestures" name="btn-success">Gesten</button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="trigger" name="btn-success">Funktionen</button>
                </div>
                <!--</div>-->
                <!--</div>-->
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="identification">
        <div class="panel-heading clearfix">
            <div class="panel-title">Elemente</div>
        </div>
        <div class="panel-body">
            <div class="panel-group" id="identificationContainer">

            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="observations">
        <div class="panel-heading clearfix">
            <div style="margin-top: 4px; display: inline-block">Beobachtungen</div>
            <div class="btn-group pull-right" id="useObservationsSwitch">
                <button class="btn btn-default switchButtonAddon switchButtonAddonPanel">Nutzen?</button>
                <button class="btn btn-default btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success">Ja</button>
                <button class="btn btn-warning btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning">Nein</button>
            </div>
        </div>
        <div class="panel-body hidden">

            <!--            <div id="dimension-controls">
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
                        </div>-->

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

            <!--<button class="btn btn-info pull-right" id="addPredefinedObservations" type="button"><span class="glyphicon glyphicon-plus"></span><span> Vordefiniertes Formular hinzufügen</span></button>-->
        </div>
    </div>

</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> Speichern & Schließen</button>
</div>


<!--<script type="text/javascript" src="js/template-create.js"></script>-->
<script>
    $('#identificationTypeSwitch').on('change', function () {
        var container = $('#identificationContainer');
        clearAlerts(container);

        var activeId = $(this).find('.active').attr('id');
        var idenficationItems = $(container).find('.option-container').children();
        $(idenficationItems).remove();
//        $(idenficationItems).has('#group-' + activeId).remove();

        if ($(this).find('.active').attr('id') === $('#identificationTypeSwitch #gestures').attr('id')) {
            var trigger = getLocalItem(ASSEMBLED_TRIGGER);
            var scenes = getLocalItem(ASSEMBLED_SCENES);

            if (trigger && trigger.length > 0 && scenes && scenes.length > 0) {
                renderAssembledTriggers();
                renderAssembledScenes();
                $(container).find('.btn-add-identificationOption').removeClass('hidden');
                $(container).find('.option-container').removeClass('hidden');
            } else {
                if (!trigger || trigger.length === 0) {
                    appendAlert(container, ALERT_NO_TRIGGER_ASSEMBLED);
                }

                if (!scenes || scenes.length === 0) {
                    appendAlert(container, ALERT_NO_SCENES_ASSEMBLED);
                }

                $(container).find('.btn-add-identificationOption').addClass('hidden');
                $(container).find('.option-container').addClass('hidden');
            }
        } else {
            if (assembledGestures()) {
                renderAssembledGestures();
                $(container).find('.btn-add-identificationOption').removeClass('hidden');
                $(container).find('.option-container').removeClass('hidden');
            } else {
                appendAlert(container, ALERT_NO_GESTURES_ASSEMBLED);
                $(container).find('.btn-add-identificationOption').addClass('hidden');
                $(container).find('.option-container').addClass('hidden');
            }
        }
    });

    $(document).ready(function () {
        var identification = $('#form-item-container #identification').clone();
        $('#identificationContainer').append(identification);

//            renderDimensions($('#dimension-controls'), getLocalItem(STUDY_ORIGIN_GUS), $('#observations #list-container'));

        var data = getLocalItem(currentIdForModal + '.data');
        if (data) {
            renderData(data, false);
        }
    });


    function renderData(data, forPrefiniedObservation)
    {
        var identificationItems = data.identification;

        $('#identificationTitle').val(data.title);
        $('#identificationDescription').val(data.description);
        $('#identificationTypeSwitch #' + data.identificationFor).click();

        var container;
        if (identificationItems !== undefined && identificationItems.length > 0) {

            container = $('#identificationContainer').find('.option-container');
            for (var i = 0; i < identificationItems.length; i++) {
                var clone = $('#form-item-container').find('#identificationItem-' + data.identificationFor).clone();
                $(clone).removeAttr('id');
                container.append(clone);

                if (data.identificationFor === 'gestures') {
//                    $(clone).find('#group-gestures').remove();
                    var trigger = getTriggerById(identificationItems[i].triggerId);
                    if (trigger && isTriggerAssembled(trigger.id)) {
                        $(clone).find('.triggerSelect #' + trigger.id).click();
                    } else {
                        appendAlert(clone, ALERT_ASSEMBLED_TRIGGER_REMOVED);
                    }

                    var scene = getSceneById(identificationItems[i].sceneId);
                    if (scene && isSceneAssembled(scene.id)) {
                        $(clone).find('.sceneSelect #' + scene.id).click();
                    } else {
                        appendAlert(clone, ALERT_ASSEMBLED_SCENE_REMOVED);
                    }
//                    console.log(isTriggerAssembled(trigger.id), isSceneAssembled(scene.id));

                    $(clone).find('#context-input').val(identificationItems[i].context);
                    $(clone).find('#sceneDescription').val(identificationItems[i].sceneDescription);
                } else {
//                    $(clone).find('#group-trigger').remove();
                    var gesture = getGestureById(identificationItems[i].gestureId);
                    if (gesture && isGestureAssembled(gesture.id)) {
                        $(clone).find('.gestureSelect #' + gesture.id).click();
                    } else {
                        appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                    }
                }

            }
            checkCurrentListState(container);
        }


        var obeservationItems;
        if (!forPrefiniedObservation) {
            obeservationItems = data.observations;
        } else {
            obeservationItems = data.gus;
        }
        if (obeservationItems !== undefined && obeservationItems.length > 0) {
            if (!forPrefiniedObservation) {
                $('#useObservationsSwitch .switchButtonAddon').click();
            }

            container = $('#list-container');

            var listContainer = $('#list-container');
            for (var i = 0; i < obeservationItems.length; i++) {
                renderFormatItem(listContainer, obeservationItems[i]);
                updateBadges(listContainer, obeservationItems[i].format);
            }
            checkDimensionItems($('#dimension-controls .dimension-container'));
            checkCurrentListState(listContainer);
        }
    }

    function saveData() {
        var identificationItems = $('#identificationContainer').find('.option-container').children();
        var obersvationItems = $('#list-container').children();

        var identification = new Object();
        identification.title = $('#identificationTitle').val();
        identification.description = $('#identificationDescription').val();
        identification.identificationFor = $('#identificationTypeSwitch .active').attr('id');

        if (identificationItems) {
            var set = new Array();
            for (var i = 0; i < identificationItems.length; i++) {
                var item = identificationItems[i];
                if ($('#identificationTypeSwitch .active').attr('id') === 'gestures') {
                    var triggerId = $(item).find('.triggerSelect .chosen').attr('id');
                    var context = $(item).find('#context-input').val();
                    var sceneId = $(item).find('.sceneSelect .chosen').attr('id');
                    var description = $(item).find('#sceneDescription').val();
                    set.push({triggerId: triggerId, context: context, sceneId: sceneId, sceneDescription: description});
                } else {
                    var gestureId = $(item).find('.gestureSelect .chosen').attr('id');
                    set.push({gestureId: gestureId});
                }
            }

            console.log(set);
            identification.identification = set;
        }

        var obersvationItems = $('#list-container').children();
        if ($('#useObservationsSwitch').find('#yes').hasClass('active') && obersvationItems.length > 0)
        {
            var questionnaire = new Array();
            for (var i = obersvationItems.length; i--; ) {
                questionnaire.push(getFormatData(obersvationItems[i]));
            }
            identification.observations = questionnaire;
        }

        setLocalItem(currentIdForModal + ".data", identification);
    }


    $(document).on('click', '.btn-add-identificationOption', function (event) {
        if (event.handled !== true)
        {
            event.handled = true;
            event.preventDefault();
            var type = $('#identificationTypeSwitch .active').attr('id');
            var item = $('#form-item-container').find('#identificationItem-' + type).clone().removeAttr('id');
            $(this).prev().append(item);
            var identificationFor = $('#identificationTypeSwitch').find('.active').attr('id');
            if (identificationFor === 'gestures') {
                $(item).find('#group-gestures').remove();
//            $(item).find('#group-trigger').removeClass('hidden');
            } else {
                $(item).find('#group-trigger').remove();
//            $(item).find('#group-gestures').removeClass('hidden');
            }
            checkCurrentListState($(this).prev());
            TweenMax.from(item, .2, {y: -10, opacity: 0, clearProps: 'all'});
        }
    });
</script>