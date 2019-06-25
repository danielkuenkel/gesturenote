<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->extractionContent->editWeightingModalHeadline ?></h4>
</div>
<div id="modal-body-controls" class="modal-body text">
    <div class="row">
        <div class="col-xs-4 col-sm-4"><div class="row"><div id="edit-weight-gesture-left"></div></div></div>

        <div class="col-xs-4 col-sm-4 text-center" id="match-controls">
            <div id="edit-classification-switch" style="">
                <label class="text"><?php echo $lang->extractionContent->secondCompareGestureQuestion ?></label> 
                <div class="switch root" style="display: inline-block">
                    <div class="btn-group" style="margin: 0; display: flex">
                        <button class="btn btn-default btn-radio" name="primary" id="notAtAll">
                            <span id="icons" style="margin-right: 6px">
                                <i class="fa fa-circle-thin" id="normal"></i>
                                <i class="fa fa-circle hidden" id="over"></i>
                                <i class="fa fa-check-circle hidden" id="checked"></i>
                            </span>
                            <span class="option-text"><?php echo $lang->tooltips->extraction->titleNotAtAll ?></span>
                            <i class="fa fa-info-circle btn-show-info" style="top: -4px; position: relative; margin-left: 7px;" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->extraction->notAtAll ?>"></i>
                        </button>
                    </div>
                    <div class="btn-group" style="margin: 0; margin-top: 3px; display: flex">
                        <button class="btn btn-default btn-radio" name="primary" id="little">
                            <span id="icons" style="margin-right: 6px">
                                <i class="fa fa-circle-thin" id="normal"></i>
                                <i class="fa fa-circle hidden" id="over"></i>
                                <i class="fa fa-check-circle hidden" id="checked"></i>
                            </span>
                            <span class="option-text"><?php echo $lang->tooltips->extraction->titleLittle ?></span>
                            <i class="fa fa-info-circle btn-show-info" style="top: -4px; position: relative; margin-left: 7px;" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->extraction->little ?>"></i>
                        </button>
                    </div>
                    <div class="btn-group" style="margin: 0; margin-top: 3px; display: flex">
                        <button class="btn btn-default btn-radio" name="primary" id="conditioned">
                            <span id="icons" style="margin-right: 6px">
                                <i class="fa fa-circle-thin" id="normal"></i>
                                <i class="fa fa-circle hidden" id="over"></i>
                                <i class="fa fa-check-circle hidden" id="checked"></i>
                            </span>
                            <span class="option-text"><?php echo $lang->tooltips->extraction->titleConditioned ?></span>
                            <i class="fa fa-info-circle btn-show-info" style="top: -4px; position: relative; margin-left: 7px;" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->extraction->contitioned ?>"></i>
                        </button>
                    </div>
                    <div class="btn-group" style="margin: 0; margin-top: 3px; display: flex">
                        <button class="btn btn-default btn-radio" name="primary" id="strong">
                            <span id="icons" style="margin-right: 6px">
                                <i class="fa fa-circle-thin" id="normal"></i>
                                <i class="fa fa-circle hidden" id="over"></i>
                                <i class="fa fa-check-circle hidden" id="checked"></i>
                            </span>
                            <span class="option-text"><?php echo $lang->tooltips->extraction->titleStrong ?></span>
                            <i class="fa fa-info-circle btn-show-info" style="top: -4px; position: relative; margin-left: 7px;" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->extraction->strong ?>"></i>
                        </button>
                    </div>
                    <div class="btn-group" style="margin: 0; margin-top: 3px; display: flex">
                        <button class="btn btn-default btn-radio" name="primary" id="veryStrong">
                            <span id="icons" style="margin-right: 6px">
                                <i class="fa fa-circle-thin" id="normal"></i>
                                <i class="fa fa-circle hidden" id="over"></i>
                                <i class="fa fa-check-circle hidden" id="checked"></i>
                            </span>
                            <span class="option-text"><?php echo $lang->tooltips->extraction->titleVeryStrong ?></span>
                            <i class="fa fa-info-circle btn-show-info" style="top: -4px; position: relative; margin-left: 7px;" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->extraction->veryStrong ?>"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-4 col-sm-4"><div class="row"><div id="edit-weight-gesture-right"></div></div></div>
    </div>

    <div class="alert-space alert-reinitialize-gesture-classification"></div>
</div>

<div id="modal-body-accept-reinitialization" class="modal-body hidden text">
    <label><?php echo $lang->extractionContent->resetGestureClassificationQuestion ?></label>
    <div class="btn-group btn-group-justified" role="group">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default btn-shadow" id="btn-reinitialize-gesture-classification"><?php echo $lang->yes ?></button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default btn-shadow" id="btn-cancel-reinitialize-gesture-classification"><?php echo $lang->no ?></button>
        </div>
    </div>
</div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
</div>

<script>
    var currentSelectedWeighting = null;
    var modal = $('#custom-modal');

    $(document).ready(function () {
        console.log(currentPreviewGesture);

        switch (parseInt(currentPreviewGesture.weighting)) {
            case 4:
                $(modal).find('#veryStrong').click();
                break;
            case 3:
                $(modal).find('#strong').click();
                break;
            case 2:
                $(modal).find('#conditioned').click();
                break;
        }

        var leftGesture = currentPreviewGesture.gesture;
        var leftItem = getGestureCatalogListThumbnail(leftGesture, 'gestures-catalog-thumbnail', 'col-xs-12', ELICITED_GESTURES);
        $(leftItem).removeClass('deleteable').attr('data-trigger-id', leftGesture.triggerId);
        $(leftItem).find('.thumbnail-footer').remove();
        $(leftItem).find('.caption').css({paddingBottom: '9px'});
        $('#edit-weight-gesture-left').empty().append(leftItem);

        var rightGesture = getGestureById(currentPreviewGesture.mainGestureId, ELICITED_GESTURES);
        var rightItem = getGestureCatalogListThumbnail(rightGesture, 'gestures-catalog-thumbnail', 'col-xs-12', ELICITED_GESTURES);
        $(rightItem).removeClass('deleteable').attr('data-trigger-id', rightGesture.triggerId);
        $(rightItem).find('.thumbnail-footer').remove();
        $(rightItem).find('.caption').css({paddingBottom: '9px'});
        $('#edit-weight-gesture-right').empty().append(rightItem);

        initPopover();

        $(modal).find('#edit-classification-switch').unbind('change').bind('change', function (event) {
            currentSelectedWeighting = $(event.target).attr('id');
            clearAlerts(modal);

            switch (currentSelectedWeighting) {
                case 'notAtAll':
                case 'little':
                    // reinitialize classification for this gesture
                    appendAlert(modal, ALERT_REINITIALIZE_GESTURE_CLASSIFICATION);
                    break;
                case 'conditioned':
                    updateGestureWeighting(2);
                    break;
                case 'strong':
                    updateGestureWeighting(3);
                    break;
                case 'veryStrong':
                    updateGestureWeighting(4);
                    break;
            }
        });
    });

    $(modal).unbind('hide.bs.modal').bind('hide.bs.modal', function (event) {
        if (currentSelectedWeighting === 'notAtAll' || currentSelectedWeighting === 'little') {
            event.preventDefault();
            event.stopImmediatePropagation();
            TweenMax.to($(modal).find('#modal-body-controls'), .3, {scale: .5, opacity: 0, clearProps: 'all', onComplete: function () {
                    $(modal).find('#modal-body-controls').addClass('hidden');
                    $(modal).find('#modal-body-accept-reinitialization').removeClass('hidden');
                    TweenMax.from($(modal).find('#modal-body-accept-reinitialization'), .3, {scale: .5, opacity: 0});
                }});

            $(modal).find('#btn-reinitialize-gesture-classification').unbind('click').bind('click', function (event) {
                event.preventDefault();
                currentSelectedWeighting = null;
                $(currentPreviewGesture.thumbnail).find('.btn-delete-from-classification').click();
                $(modal).unbind('hide.bs.modal');
                $(modal).modal('hide');
            });

            $(modal).find('#btn-cancel-reinitialize-gesture-classification').unbind('click').bind('click', function (event) {
                event.preventDefault();

                TweenMax.to($(modal).find('#modal-body-accept-reinitialization'), .3, {scale: .5, opacity: 0, clearProps: 'all', onComplete: function () {
                        $(modal).find('#modal-body-controls').removeClass('hidden');
                        $(modal).find('#modal-body-accept-reinitialization').addClass('hidden');
                        TweenMax.from($(modal).find('#modal-body-controls'), .3, {scale: .5, opacity: 0});
                    }});
            });
        } else {
            $(modal).unbind('hide.bs.modal');
        }
    });

    function updateGestureWeighting(weighting) {
        $(currentPreviewGesture.thumbnail).attr('data-weighting', weighting);
        $(currentPreviewGesture.thumbnail).find('.weighting-text').text(weighting);

        var classification = getLocalItem(CLASSIFICATION_GESTURES);
        for (var i = 0; i < classification.assignments.length; i++) {
            if (parseInt(currentPreviewGesture.gesture.triggerId) === parseInt(classification.assignments[i].triggerId)) {
                for (var j = 0; j < classification.assignments[i].gestures.length; j++) {
                    if (parseInt(classification.assignments[i].gestures[j].id) === parseInt(currentPreviewGesture.gesture.id)) {
                        classification.assignments[i].gestures[j].weighting = weighting;
                        setLocalItem(CLASSIFICATION_GESTURES, classification);
                        saveClassification();
                        break;
                    }
                }
            }
        }
    }
</script>