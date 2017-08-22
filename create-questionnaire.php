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
<div id="modal-body" class="modal-body" style="padding-bottom: 0px">
    <div class="alert-space alert-no-data-questionnaire"></div>
    <div class="container-root" id="list-container"></div>
</div>
<hr style="margin: 0;">
<div id="modal-body" class="modal-body" style="padding-top: 4px">
    <!--    <div class="form-group form-group-no-margin">
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
                        <li id="matrix"><a href="#"><?php echo $lang->questionFormats->matrix->text ?></a></li>
                        <li id="sumQuestion"><a href="#"><?php echo $lang->questionFormats->sumQuestion->text ?></a></li>
                        <li id="ranking"><a href="#"><?php echo $lang->questionFormats->ranking->text ?></a></li>
                        <li id="counter"><a href="#"><?php echo $lang->questionFormats->counter->text ?></a></li>
                    </ul>
                    <button class="btn btn-info btn-shadow disabled dropdown-disabled" id="addFormat" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                </div>
            </div>
        </div>-->

    <div class="add-button-group" id="add-question-button-group">
        <div class="btn-group">
            <div class="btn btn-info btn-add-item font-bold" id="openQuestion">
                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
            </div>
        </div>
        <div class="btn-group">
            <div class="btn btn-info btn-add-item font-bold" id="dichotomousQuestion">
                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
            </div>
        </div>
        <div class="btn-group">
            <div class="btn btn-info btn-add-item font-bold" id="groupingQuestion">
                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
            </div>
        </div>
        <div class="btn-group">
            <div class="btn btn-info btn-add-item font-bold" id="groupingQuestionOptions">
                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
            </div>
        </div>
        <div class="btn-group">
            <div class="btn btn-info btn-add-item font-bold" id="rating">
                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
            </div>
        </div>
        <div class="btn-group">
            <div class="btn btn-info btn-add-item font-bold" id="matrix">
                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
            </div>
        </div>
        <div class="btn-group">
            <div class="btn btn-info btn-add-item font-bold" id="sumQuestion">
                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
            </div>
        </div>
        <div class="btn-group">
            <div class="btn btn-info btn-add-item font-bold" id="ranking">
                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
            </div>
        </div>
        <div class="btn-group">
            <div class="btn btn-info btn-add-item font-bold" id="counter">
                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
            </div>
        </div>
    </div>
</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo $lang->saveAndClose ?></button>
</div>

<script>
    $(document).ready(function () {
        closeClicked = false;
        $('[data-toggle="popover"]').popover({container: 'body', delay: {"show": 300, "hide": 0}});

        var data = getLocalItem(currentIdForModal + '.data');
        if (data !== null && data.length > 0) {
            renderData(data);
        } else {
            appendAlert($('#custom-modal'), ALERT_NO_DATA_QUESTIONNAIRE);
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

    $('#modal-body .add-button-group').unbind('change').bind('change', function (event) {
        var itemType = $(event.target).attr('id');
        var clone = $('#form-item-container').find('#' + itemType).clone();
        clone.attr('name', itemType);
        initJustificationFormElements(clone);

        var listContainer = $(this).closest('.root').find('#list-container');
        var tweenTarget = listContainer.children().last();
        if (!tweenTarget || (tweenTarget && tweenTarget.length === 0)) {
            TweenMax.to($(event.target), .3, {y: '-=120', opacity: 0, clearProps: 'all', ease: Quad.easeIn, onComplete: onMoveComplete, onCompleteParams: [clone, listContainer, itemType]});
            return null;
        }

        var tweenTargetOffset = $(tweenTarget).offset();
        var tweenElementOffset = $(event.target).offset();
        var tweenOffset = {offsetY: tweenTargetOffset.top - tweenElementOffset.top + tweenTarget.height(), offsetX: tweenTargetOffset.left - tweenElementOffset.left};
        var alphaY = tweenOffset.offsetY < 0 ? '' + tweenOffset.offsetY : '+' + tweenOffset.offsetY;
        var alphaX = tweenOffset.offsetX < 0 ? '' + tweenOffset.offsetX : '+' + tweenOffset.offsetX;
        TweenMax.to($(event.target), .3, {x: alphaX, y: alphaY, opacity: 0, clearProps: 'all', ease: Quad.easeIn, onComplete: onMoveComplete, onCompleteParams: [clone, listContainer, itemType]});
    });


    function onMoveComplete(clone, listContainer, itemType) {
        $(listContainer).append(clone);
        checkCurrentListState(listContainer);
        updateBadges($('#modal-body #list-container'), itemType);

        TweenMax.from(clone, 1, {y: -40, opacity: 0, ease: Elastic.easeOut, clearProps: 'all'});
        $(listContainer).trigger('listItemAdded');
    }

    $('#modal-body #list-container').unbind('listItemAdded').bind('listItemAdded', function (event) {
        event.preventDefault();
        var addedElement = $(event.target).children().last();
        console.log(addedElement);
        initializeItemType(addedElement);
        clearAlerts($('#modal-body'));
        var scrollTarget = $(this).closest('.modal');
        var newScrollTop = Math.max(0, scrollTarget.find('.modal-content').height() - scrollTarget.height() + 60);
        $(scrollTarget).animate({
            scrollTop: newScrollTop
        }, 200);
    });

    $('#modal-body #list-container').unbind('change').bind('change', function (event) {
        if ($(this).children().length > 0) {
            clearAlerts($('#modal-body'));
        } else {
            appendAlert($('#modal-body'), ALERT_NO_DATA_QUESTIONNAIRE);
        }
    });
</script>