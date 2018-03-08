<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Gesten-Vorschau</h4>
</div>
<div id="modal-body" class="modal-body">

    <div class="row">
        <div class="col-md-5 root">

            <div data-sensor-source="webcam" id="webcam-preview" class="autoplay">
                <div class="root embed-responsive embed-responsive-4by3 hidden-controls">
                    <div id="" class="webcam-image-container"></div>
                    <div class="controls-container embed-responsive-item">
                        <div class="hidden-control text-center" id="btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                    </div>
                </div>

                <div id="webcam-playback-slider-controls" class="hidden" style="margin-top: -10px" data-visible="true">
                    <div id="webcam-playback-slider-container" class="webcam-playback-slider-container" style="width: 100%;">
                        <input id="webcam-playback-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                    </div>
                </div>
            </div>
            <!--            <div class="previewGesture mouseScrollable btn-shadow autoplay"></div>
                        <div class="progress gesture-progress">
                            <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                        </div>
                        <div class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="fa fa-play"></i></button>
                                <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="fa fa-stop"></i></button>
                                <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="fa fa-backward"></i></button>
                                <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="fa fa-forward"></i></button>
                            </div><br/>
                            <button type="button" class="btn btn-default hidden" id="btn-choose-preview-image" style="margin-top: 6px"><i class="fa fa-bookmark" aria-hidden="true"></i> <span class="text"><?php echo $lang->selectPreviewImage ?></span></button>
                        </div>-->
            <!--<hr>-->
            <!--            <div class="gesture-rating" id="gesture-rating" style="margin-top: 20px; margin-bottom: 30px">
                            <h3><i class="fa fa-star-o"></i> Bewertung</h3>
                            <div class="rating-container rating-physicalContext row" id="rating-physicalContext">
                                <div class="col-xs-4 col-sm-3 col-md-5 rating-stars-container"></div>
                                <div class="col-xs-8 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text">Gestentyp für Kontext stimmig? (z.B. Ganzkörper-Geste für Arbeitsplatz stimmig?)</span></div>
                            </div>
                            <div class="rating-container rating-adaption row" id="rating-adaption">
                                <div class="col-xs-4 col-sm-3 col-md-5 rating-stars-container"></div>
                                <div class="col-xs-8 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text">Kontext-Adaption (Könnte die Geste auch woanders eingesetzt werden?)</span></div>
                            </div>
                            <div class="rating-container rating-fittingTask row" id="rating-fittingTask">
                                <div class="col-xs-4 col-sm-3 col-md-5 rating-stars-container"></div>
                                <div class="col-xs-8 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text">Passt die Geste zur beschriebenen Aufgabe?</span></div>
                            </div>
                            <div id="rating-infos">
                                <span id="rated-by"></span> <span id="rating-users-count"></span> <span id="rated-by-users"></span>
                                <div class="alert-space alert-rating-submitted" style="margin-top: 10px;"></div>
                            </div>
                            <button type="button" class="btn btn-block btn-warning" id="btn-rate-gesture" style="margin-top: 10px;">Geste bewerten</button>
                            <div class="btn-group-vertical btn-block hidden" id="rating-submit-buttons" style="margin-top: 0px;">
                                <button type="button" class="btn btn-success" id="btn-submit-gesture-rating">Bewertung abgeben</button>
                                <button type="button" class="btn btn-danger" id="btn-cancel-gesture-rating">Abbrechen</button>
                            </div>
                        </div>-->
        </div>
        <div class="col-md-7">
            <h3 style="margin-top: 0"><i class="fa fa-bookmark-o"></i> Allgemeines</h3>
            <div id="gesture-data-preview">
                <div id="created"><span class="address">Erstellt:</span> <span class="text"></span></div>
                <div id="title">Titel:<span class="address"></span> <span class="text"></span></div>
                <div id="type">Gesten-Typ:<span class="address"></span> <span class="text"></span></div>
                <div id="interactionType">Gesten-Interaktions-Typ:<span class="address"></span> <span class="text"></span></div>
                <div id="context">Kontext:<span class="address"></span> <span class="text"></span></div>
                <div id="association">Assoziation:<span class="address"></span> <span class="text"></span></div>
                <div id="description">Beschreibung:<span class="address"></span> <span class="text"></span></div>

                <!--<span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>-->
                <!--<span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>-->

                <div class="preview-joints-humand-body" id="human-body" style="width: 350px; margin: auto; margin-top: 10px">
                    <div id="joint-container" style="position: absolute"></div>
                    <img src="img/human_body.svg">
                </div>
            </div>

            <div id="gesture-data-edit" class="hidden">
                <div class="alert-space alert-missing-fields"></div>

                <div class="form-group">
                    <label><?php echo $lang->gestureName ?></label>
                    <input type="text" class="form-control" id="gesture-name-input" required>
                </div>

                <div class="form-group root" id="gestureTypeSelect">
                    <label>
                        <?php echo $lang->gestureType ?> 
                        <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text4 ?>"></i>
                    </label><br>

                    <div class="btn-group" id="radio" style="margin: 0">
                        <button class="btn btn-default btn-radio" name="primary" id="pose">
                            <span id="icons" style="margin-right: 6px">
                                <i class="fa fa-circle-thin" id="normal"></i>
                                <i class="fa fa-circle hidden" id="over"></i>
                                <i class="fa fa-check-circle hidden" id="checked"></i>
                            </span>
                            <span class="option-text"><?php echo $lang->gestureTypes->pose ?></span>
                        </button>
                    </div>
                    <div class="btn-group" id="radio" style="margin: 0">
                        <button class="btn btn-default btn-radio" name="primary" id="dynamic">
                            <span id="icons" style="margin-right: 6px">
                                <i class="fa fa-circle-thin" id="normal"></i>
                                <i class="fa fa-circle hidden" id="over"></i>
                                <i class="fa fa-check-circle hidden" id="checked"></i>
                            </span>
                            <span class="option-text"><?php echo $lang->gestureTypes->dynamic ?></span>
                        </button>
                    </div>
                </div>

                <div class="form-group root" id="gestureInteractionTypeSelect">
                    <label>
                        <?php echo $lang->gestureInteractionType ?> 
                        <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text4 ?>"></i>
                    </label><br>

                    <div class="btn-group" id="radio" style="margin: 0">
                        <button class="btn btn-default btn-radio" name="primary" id="discrete">
                            <span id="icons" style="margin-right: 6px">
                                <i class="fa fa-circle-thin" id="normal"></i>
                                <i class="fa fa-circle hidden" id="over"></i>
                                <i class="fa fa-check-circle hidden" id="checked"></i>
                            </span>
                            <span class="option-text"><?php echo $lang->gestureInteractionTypes->discrete ?></span>
                        </button>
                    </div>
                    <div class="btn-group" id="radio" style="margin: 0">
                        <button class="btn btn-default btn-radio" name="primary" id="continuous">
                            <span id="icons" style="margin-right: 6px">
                                <i class="fa fa-circle-thin" id="normal"></i>
                                <i class="fa fa-circle hidden" id="over"></i>
                                <i class="fa fa-check-circle hidden" id="checked"></i>
                            </span>
                            <span class="option-text"><?php echo $lang->gestureInteractionTypes->continuous ?></span>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo $lang->gestureContext ?></label>
                    <input type="text" class="form-control" placeholder="Wo soll die Geste eingesetzt werden?" id="gesture-context-input" required>
                </div>

                <div class="form-group">
                    <label><?php echo $lang->gestureAssociation ?></label>
                    <textarea class="form-control" id="gesture-association-input" rows="3" maxlength="500" required></textarea>
                </div>

                <div class="form-group">
                    <label><?php echo $lang->gestureDescription ?></label>
                    <textarea class="form-control" id="gesture-description-input" rows="3" maxlength="500" required></textarea>
                </div>

                <div class="form-group">
                    <label><?php echo $lang->gestureGraphicsQuestion ?></label>
                    <div class="select-joints-humand-body" id="select-joints-human-body" style="width: 350px; margin: auto; margin-top: 10px">
                        <div id="joint-container" style="position: absolute"></div>
                        <img src="img/human_body.svg">
                    </div>
                </div>
            </div>

            <div class="btn-group-vertical btn-block" style="margin-top: 20px" id="gesture-owner-controls">
                <button type="button" class="btn btn-default gesture-previewable" id="btn-edit-gesture"><i class="fa fa-pencil" aria-hidden="true"></i> <span class="btn-text"></span></button>
                <!--<button type="button" class="btn btn-info" id="btn-share-gesture"><i class="fa" aria-hidden="true"></i> <span class="btn-text"></span></button>-->
                <!--<button type="button" class="btn btn-danger" id="btn-delete-gesture"><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-text">Geste löschen</span></button>-->
            </div>

        </div>
    </div>
</div>

<!--<hr style="margin: 0; padding: 0">-->

<!--<div id="discussion-body" class="modal-body">
    <h3 style="margin-bottom: 20px"><i class="fa fa-comments-o" aria-hidden="true"></i> Mitreden</h3>

    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <textarea class="form-control" id="comment" rows="4" maxlength="500" placeholder="Kommentar einfügen" required></textarea>
            </div>
            <button type="button" class="btn btn-default btn-block" id="btn-comment-gesture"><i class="fa fa-commenting" aria-hidden="true"></i> <span class="btn-text">Kommentar abschicken</span></button>
        </div>
        <div class="col-md-7">
            <div class="alert-space alert-no-comments"></div>
            <div id="comments-list"></div>
        </div>
    </div>

</div>

<div class="hidden panel panel-default panel-sm" id="gesture-comment-item" style="margin-top: 0px; margin-bottom: 8px">
    <div class="panel-heading" style="font-size: 10pt">
        <span id="user"><i class="fa fa-comment" aria-hidden="true"></i> <span class="text"></span></span>
        <span id="created" class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="text"></span></span>
    </div>
    <div class="panel-body" style="color: #303030; font-size: 10pt"></div>
    <div class="panel-footer">
        <button class="btn btn-xs btn-danger" id="btn-delete-comment">Kommentar löschen</button>
    </div>
</div>-->

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
</div>

<script>
    var testRatings = [{physicalContext: 1, adaption: 0, fittingTask: 3}, {physicalContext: 0, adaption: 3, fittingTask: 4}, {physicalContext: 2, adaption: 0, fittingTask: 3}, {physicalContext: 2, adaption: 2, fittingTask: 3}, {physicalContext: 2, adaption: 1, fittingTask: 1}];
    var currentRatings = [{physicalContext: 0, adaption: 0, fittingTask: 0}];
    $(document).ready(function () {
//        initGestureRating($('#gesture-rating'), 5);
        renderModalData();´

        $('#custom-modal').bind('hidden.bs.modal', function () {
            currentPreviewGesture = null;
            gesturePreviewOpened = false;
            $(this).unbind('hidden.bs.modal');
        });
    });

    function renderModalData() {
        var gesture = currentPreviewGesture.gesture;
        if (gesture === null) {
            return false;
        }

        var container = $('#modal-body');
        if (gesture.created) {
            container.find('#created .text').text(convertSQLTimestampToDate(gesture.created).toLocaleString());
        } else {
            container.find('#created').addClass('hidden');
        }

        container.find('#title .text').text(gesture.title);
        container.find('#type .text').text(gesture.type === null ? '-' : translation.gestureTypes[gesture.type]);
        container.find('#interactionType .text').text(gesture.interactionType === null ? '-' : translation.gestureInteractionTypes[gesture.interactionType]);
        container.find('#context .text').text(gesture.context);
        container.find('#association .text').text(gesture.association === null ? '-' : gesture.association);
        container.find('#description .text').text(gesture.description);
        container.find('#btn-edit-gesture .btn-text').text(translation.edit);
        container.find('#btn-delete-gesture .btn-text').text(translation.deleteGesture);

        renderGesturePreview(container.find('#webcam-preview'), gesture);
//        renderGestureImages(container.find('.previewGesture'), gesture.images, gesture.previewImage, null);
        renderBodyJointsPreview(container.find('#human-body'), gesture.joints);

        var thumbnail = $('#item-view #gestures-list-container').find('#' + gesture.id);

        $('#modal-body #btn-edit-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var button = $(this);
            if ($(this).hasClass('gesture-editable')) {
                if (!$(this).hasClass('disabled') && inputsValid(true)) {

                    $(button).addClass('disabled');
                    showCursor($('body'), CURSOR_PROGRESS);
                    var previewImageIndex = getGesturePreviewIndex($('#modal-body').find('.previewGesture'));
                    var title = $('#gesture-name-input').val().trim();
                    var type = $(container).find('#gestureTypeSelect .btn-option-checked').attr('id');
                    var interactionType = $(container).find('#gestureInteractionTypeSelect .btn-option-checked').attr('id');
                    var context = $('#gesture-context-input').val().trim();
                    var association = $('#gesture-association-input').val().trim();
                    var description = $('#gesture-description-input').val().trim();
                    var joints = getSelectedJoints($('#select-joints-human-body #joint-container'));

                    updateGesture({gestureId: gesture.id, title: title, type: type, interactionType: interactionType, context: context, association: association, description: description, joints: joints, previewImageIndex: previewImageIndex}, function (result) {

                        showCursor($('body'), CURSOR_DEFAULT);
                        $(button).removeClass('disabled');
                        $('#modal-body #btn-delete-gesture, #modal-body #btn-share-gesture').removeClass('disabled');
                        if (result.status === RESULT_SUCCESS) {
                            updateGestureById(currentPreviewGesture.source, result.id, {title: result.title, type: type, interactionType: interactionType, context: result.context, association: association, description: result.description, joints: result.joints, previewImage: result.previewImage});
                            $(thumbnail).find('.gesture-name').text(title);
                            $('#modal-body #btn-choose-preview-image').addClass('hidden');
                            $(thumbnail).find('.previewGesture .gestureImage').removeClass('previewImage active ');
                            $(thumbnail).find('.previewGesture .gestureImage').addClass('hidden');
                            $($(thumbnail).find('.previewGesture .gestureImage')[previewImageIndex]).addClass('previewImage active');
                            $($(thumbnail).find('.previewGesture .gestureImage')[previewImageIndex]).removeClass('hidden');
                            $(button).removeClass('gesture-editable').addClass('gesture-previewable');
                            $(button).find('.btn-text').text(translation.edit);
                            $('#modal-body #gesture-data-preview').removeClass('hidden');
                            $('#modal-body #gesture-data-edit').addClass('hidden');

//                            setLocalItem(GESTURE_CATALOG, result.gestures);
//                            originalFilterData = getLocalItem(ELICITED_GESTURES);
//                            currentFilterData = sort();
                            currentPreviewGesture.gesture = getGestureById(result.id, ELICITED_GESTURES);
                            renderModalData();
                        } else {
                            appendAlert($('#modal-body'), ALERT_GENERAL_ERROR);
                        }
                    });
                }
            } else {
                $(this).removeClass('gesture-previewable').addClass('gesture-editable');
                $(this).find('.btn-text').text(translation.gesturePreviewable);
                $('#modal-body #gesture-data-preview').addClass('hidden');
                $('#modal-body #gesture-data-edit').removeClass('hidden');
                $('#modal-body #btn-delete-gesture, #modal-body #btn-share-gesture').addClass('disabled');
                $('#modal-body #btn-choose-preview-image').removeClass('hidden');
                $('#gesture-name-input').val(gesture.title);
                $('#gesture-data-edit #gestureTypeSelect').find('#' + gesture.type).click();
                $('#gesture-data-edit #gestureInteractionTypeSelect').find('#' + gesture.interactionType).click();
                $('#gesture-association-input').val(gesture.association);
                $('#gesture-context-input').val(gesture.context);
                $('#gesture-description-input').val(gesture.description);
                renderBodyJoints($('#select-joints-human-body'), gesture.joints);
            }
        });

        if ($(thumbnail).hasClass('deleteable')) {
            $(container).find('#btn-delete-gesture').unbind('click').bind('click', {gestureId: gesture.id}, function (event) {
                event.preventDefault();

                if (!event.handled && !$(this).hasClass('disabled')) {
                    event.handled = true;
                    $(this).addClass('disabled');
                    showCursor($('body'), CURSOR_PROGRESS);
                    deleteGesture({gestureId: event.data.gestureId}, function (result) {
                        showCursor($('body'), CURSOR_DEFAULT);
                        if (result.status === RESULT_SUCCESS) {
                            getGestureCatalog(function (result) {
                                if (result.status === RESULT_SUCCESS) {
                                    originalFilterData = result.gestures;
                                    currentFilterData = sort();
                                    $('#custom-modal').trigger('gesture-deleted');
                                    $('#custom-modal').modal('hide');
                                }
                            });
                        }
                    });
                }
            });
        } else {
            $(container).find('#btn-delete-gesture').remove();
        }
    }

    function inputsValid(showErrors) {
        var container = $('#gesture-data-edit');
        var title = $('#gesture-data-edit #gesture-name-input').val().trim();
        if (title === '') {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var context = $('#gesture-data-edit #gesture-context-input').val().trim();
        if (context === '') {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var description = $('#gesture-data-edit #gesture-description-input').val().trim();
        if (description === '') {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var selectedJoints = getSelectedJoints($('#select-joints-human-body #joint-container'));
        if (selectedJoints.length === 0) {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        return true;
    }

    $('#gesture-data-edit #select-joints-human-body').bind('change', function () {
        if (inputsValid()) {
            $('#btn-edit-gesture').removeClass('disabled');
        } else {
            $('#btn-edit-gesture').addClass('disabled');
        }
    });

    $('#gesture-name-input, #gesture-context-input, #gesture-description-input').bind('input', function () {
        if (inputsValid()) {
            $('#btn-edit-gesture').removeClass('disabled');
        } else {
            $('#btn-edit-gesture').addClass('disabled');
        }
    });
</script>