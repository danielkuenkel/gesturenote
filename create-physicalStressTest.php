<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <h4 class="modal-title">Physischer Belastungstest für Gesten</h4>
</div>
<div id="modal-body" class="modal-body">

    <div class="panel panel-default root" id="general">
        <div class="panel-heading clearfix">
            <div class="panel-title">Allgemeines</div>
        </div>
        <div class="panel-body">
            <div class="panel-group" id="generalContainer" style="margin-bottom: 0">
                <div class="form-group">
                    <label class="sr-only" for="stresTestTitle">Titel</label>
                    <input type="text" class="form-control" id="stressTestTitle" placeholder="Titel einfügen">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="stressTestDescription">Beschreibung</label>
                    <textarea class="form-control" id="stressTestDescription" rows="5" placeholder="Beschreibung einfügen"></textarea>
                </div>
                <div class="row">
                    <!--                    <div class="col-md-6" style="margin-bottom: 10px">
                                            <div class="btn-group" id="randomizeSwitch">
                                                <button class="btn btn-default switchButtonAddon">Gesten randomisiert abfragen?</button>
                                                <button class="btn btn-success btn-shadow btn-toggle-checkbox active" id="yes" name="btn-success">Ja</button>
                                                <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="no" name="btn-warning">Nein</button>
                                            </div>
                                        </div>-->
                    <div class="col-md-6">
                        <div class="input-group simple-stepper">
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-shadow btn-addon">Durchläufe pro Geste</button>
                                <button type="button" class="btn btn-default btn-shadow btn-stepper-decrease" value="2">
                                    <span class="glyphicon glyphicon-minus"></span><span class="sr-only">Einer weniger</span>
                                </button>
                            </div>
                            <input type="text" class="form-control readonly text-center stepper-text" id="totalStressAmount" value="10">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default btn-shadow btn-stepper-increase" value="300">
                                    <span class="glyphicon glyphicon-plus"></span><span class="sr-only">Einer mehr</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="stressTest">
        <div class="panel-heading clearfix">
            <div class="panel-title">Gesten</div>
        </div>
        <div class="panel-body">
            <div class="panel-group" id="stressTestContainer">

            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="singleStressQuestions">
        <div class="panel-heading clearfix">
            <div style="margin-top: 4px; display: inline-block">Fragen nach jeder Geste</div>
            <div class="btn-group pull-right" id="useSingleStressQuestionsSwitch">
                <button class="btn btn-default switchButtonAddon switchButtonAddonPanel">Nutzen?</button>
                <button class="btn btn-default btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success">Ja</button>
                <button class="btn btn-warning btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning">Nein</button>
            </div>
        </div>
        <div class="panel-body hidden">
            <div class="form-group">
                <div class="btn-group" id="useGraphicalSingleStressSwitch">
                    <button class="btn btn-default switchButtonAddon">Nutzer mit Hilfe von Grafik über Anstrengung befragen</button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="body" name="btn-success">Körper</button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="hands" name="btn-success">Hände</button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="bodyHands" name="btn-success">Körper & Hände</button>
                    <button class="btn btn-warning btn-shadow btn-toggle-checkbox active" id="none" name="btn-warning">Keine</button>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">Format</span>
                    <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="Bitte wählen"/>
                    <div class="input-group-btn select" id="addFormatSelect" role="group">
                        <button class="btn btn-default btn-shadow btn-dropdown" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            <li id="openQuestion"><a href="#">Offene Frage</a></li>
                            <li id="dichotomousQuestion"><a href="#">Ja/nein-Frage</a></li>
                            <li id="groupingQuestion"><a href="#">Eingruppierungs-Frage</a></li>
                            <li id="rating"><a href="#">Rating</a></li>
                            <li id="sumQuestion"><a href="#">Summenfrage</a></li>
                            <li id="ranking"><a href="#">Ranking</a></li>
                        </ul>
                        <button class="btn btn-info btn-shadow disabled dropdown-disabled" id="addFormat" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                    </div>
                </div>
            </div>

            <div class="form-group container-root" id="list-container"></div>
        </div>
    </div>

    <div class="panel panel-default root" id="sequenceStressQuestions">
        <div class="panel-heading clearfix">
            <div style="margin-top: 4px; display: inline-block">Fragen nach einer Gesten-Sequenz</div>
            <div class="btn-group pull-right" id="useSequenceStressQuestionsSwitch">
                <button class="btn btn-default switchButtonAddon switchButtonAddonPanel">Nutzen?</button>
                <button class="btn btn-default btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success">Ja</button>
                <button class="btn btn-warning btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning">Nein</button>
            </div>
        </div>
        <div class="panel-body hidden">
            <div class="form-group">
                <div class="btn-group" id="useGraphicalSequenceStressSwitch">
                    <button class="btn btn-default switchButtonAddon">Nutzer mit Hilfe von Grafik über Anstrengung befragen</button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="body" name="btn-success">Körper</button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="hands" name="btn-success">Hände</button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="bodyHands" name="btn-success">Körper & Hände</button>
                    <button class="btn btn-warning btn-shadow btn-toggle-checkbox active" id="none" name="btn-warning">Keine</button>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">Format</span>
                    <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="Bitte wählen"/>
                    <div class="input-group-btn select" id="addFormatSelect" role="group">
                        <button class="btn btn-default btn-shadow btn-dropdown" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            <li id="openQuestion"><a href="#">Offene Frage</a></li>
                            <li id="dichotomousQuestion"><a href="#">Ja/nein-Frage</a></li>
                            <li id="groupingQuestion"><a href="#">Eingruppierungs-Frage</a></li>
                            <li id="rating"><a href="#">Rating</a></li>
                            <li id="sumQuestion"><a href="#">Summenfrage</a></li>
                            <li id="ranking"><a href="#">Ranking</a></li>
                        </ul>
                        <button class="btn btn-info btn-shadow disabled dropdown-disabled" id="addFormat" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                    </div>
                </div>
            </div>
            <div class="form-group container-root" id="list-container"></div>
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

            <!--<button class="btn btn-info pull-right" id="addPredefinedObservations" type="button"><span class="glyphicon glyphicon-plus"></span><span> Vordefiniertes Formular hinzufügen</span></button>-->
        </div>
    </div>

</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> Speichern & Schließen</button>
</div>


<!--<script type="text/javascript" src="js/template-create.js"></script>-->
<script>
    $(document).ready(function () {
        var stressTest = $('#form-item-container #physicalStressTest').clone();
        $('#stressTestContainer').append(stressTest);

        if (assembledGestures()) {
            renderAssembledGestures();
        } else {
            appendAlert(stressTest, ALERT_NO_GESTURES_ASSEMBLED);
            $(stressTest).find('.btn-add-physicalStressTestOption').addClass('hidden');
        }

        renderDimensions($('#dimension-controls'), translation.observationsPhysicalStressTest, $('#observations #list-container'));

        var data = getLocalItem(currentIdForModal + '.data');
        if (data) {
            renderData(data, false);
        }
    });

    function renderData(data, forPrefiniedObservation)
    {
        var items = data.stressTestItems;

        $('#stressTestTitle').val(data.title);
        $('#stressTestDescription').val(data.description);
        $('#randomizeSwitch #' + (data.randomized === true ? 'yes' : 'no')).click();
        $('#totalStressAmount').val(data.stressAmount);

        var container;

        if (items !== undefined && items.length > 0) {

            container = $('#stressTestContainer').find('.option-container');

            for (var i = 0; i < items.length; i++) {
                var gesture = getGestureById(items[i]);

                var clone = $('#form-item-container').find('#physicalStressTestItem').clone().removeClass('hidden');
                $(clone).removeAttr('id');
                container.append(clone);

                if (gesture && isGestureAssembled(gesture.id)) {
                    $(clone).find('.gestureSelect #' + gesture.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                }
            }
            checkCurrentListState(container);
        }

        var singleStressQuestions = data.singleStressQuestions;
        if ((singleStressQuestions !== undefined && singleStressQuestions.length > 0) || (data.singleStressGraphicsRating !== undefined && data.singleStressGraphicsRating !== 'none')) {
            $('#useGraphicalSingleStressSwitch #' + data.singleStressGraphicsRating).click();
            $('#useSingleStressQuestionsSwitch .switchButtonAddon').click();
            var listContainer = $('#singleStressQuestions').find('#list-container');
            if (singleStressQuestions !== undefined && singleStressQuestions.length > 0) {
                for (var i = 0; i < singleStressQuestions.length; i++) {
                    renderFormatItem(listContainer, singleStressQuestions[i]);
                    updateBadges(listContainer, singleStressQuestions[i].format);
                }
                checkCurrentListState(listContainer);
            }
        }

        var sequenceStressQuestions = data.sequenceStressQuestions;
        if ((sequenceStressQuestions !== undefined && sequenceStressQuestions.length > 0) || (data.sequenceStressGraphicsRating !== undefined && data.sequenceStressGraphicsRating !== 'none')) {
            $('#useGraphicalSequenceStressSwitch #' + data.sequenceStressGraphicsRating).click();
            $('#useSequenceStressQuestionsSwitch .switchButtonAddon').click();
            var listContainer = $('#sequenceStressQuestions').find('#list-container');
            if (sequenceStressQuestions !== undefined && sequenceStressQuestions.length > 0) {
                for (var i = 0; i < sequenceStressQuestions.length; i++) {
                    renderFormatItem(listContainer, sequenceStressQuestions[i]);
                    updateBadges(listContainer, sequenceStressQuestions[i].format);
                }
                checkCurrentListState(listContainer);
            }
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

            var listContainer = $('#observations').find('#list-container');
            for (var i = 0; i < obeservationItems.length; i++) {
                renderFormatItem(listContainer, obeservationItems[i]);
                updateBadges(listContainer, obeservationItems[i].format);
            }

            checkDimensionItems($('#dimension-controls .dimension-container'));
            checkCurrentListState(listContainer);
        }
    }

    function saveData() {
        var items = $('#stressTestContainer').find('.option-container').children();
        var obersvationItems = $('#list-container').children();

        var stressTest = new Object();
        stressTest.title = $('#stressTestTitle').val();
        stressTest.description = $('#stressTestDescription').val();
        stressTest.randomized = $('#randomizeSwitch .active').attr('id') === 'yes';
        stressTest.stressAmount = $('#totalStressAmount').val();

        if (items) {
            var set = new Array();
            for (var i = 0; i < items.length; i++) {
                var item = items[i];
                var gestureId = $(item).find('.gestureSelect .chosen').attr('id');
                var gesture = getGestureById(gestureId);

                if (gesture) {
                    set.push(gestureId);
                }
            }
            stressTest.stressTestItems = set;
        }

        var singleStressQuestions = $('#singleStressQuestions').find('#list-container').children();
        if ($('#useSingleStressQuestionsSwitch').find('#yes').hasClass('active') && (singleStressQuestions.length > 0 || $('#useGraphicalSingleStressSwitch').find('.active').attr('id') !== 'none'))
        {
            var questionnaire = new Array();
            for (var i = singleStressQuestions.length; i--; ) {
                questionnaire.push(getFormatData(singleStressQuestions[i]));
            }
            if (questionnaire.length > 0) {
                stressTest.singleStressQuestions = questionnaire;
            }
            stressTest.singleStressGraphicsRating = $('#useGraphicalSingleStressSwitch').find('.active').attr('id');
        }

        var sequenceStressQuestions = $('#sequenceStressQuestions').find('#list-container').children();
        if ($('#useSequenceStressQuestionsSwitch').find('#yes').hasClass('active') && (sequenceStressQuestions.length > 0 || $('#useGraphicalSequenceStressSwitch').find('.active').attr('id') !== 'none'))
        {
            var questionnaire = new Array();
            for (var i = sequenceStressQuestions.length; i--; ) {
                questionnaire.push(getFormatData(sequenceStressQuestions[i]));
            }
            if (questionnaire.length > 0) {
                stressTest.sequenceStressQuestions = questionnaire;
            }
            stressTest.sequenceStressGraphicsRating = $('#useGraphicalSequenceStressSwitch').find('.active').attr('id');
        }

        var obersvationItems = $('#observations').find('#list-container').children();
        if ($('#useObservationsSwitch').find('#yes').hasClass('active') && obersvationItems.length > 0)
        {
            var questionnaire = new Array();
            for (var i = 0; i < obersvationItems.length; i++) {
                questionnaire.push(getFormatData(obersvationItems[i]));
            }
            stressTest.observations = questionnaire;
        }

        setLocalItem(currentIdForModal + ".data", stressTest);
    }

    $('body').on('click', '#btn-add-physicalStressTestOption', function (event) {
        if (event.handled !== true)
        {
            event.handled = true;
            event.preventDefault();
            var item = $('#form-item-container').find('#physicalStressTestItem').clone().removeAttr('id');
            $(this).prev().append(item);
            checkCurrentListState($(this).prev());
            TweenMax.from(item, .2, {y: -10, opacity: 0, clearProps: 'all'});
        }
    });
</script>