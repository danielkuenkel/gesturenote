<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close btn-cancel-edit-gesture" >&times;</button>
    <h4 class="modal-title">
        <?php echo $lang->gesturePreview ?>
    </h4>
</div>
<div id="modal-body" class="modal-body">

    <!--     Nav tabs 
        <ul class="nav nav-pills" id="gesture-info-nav-tab" style="display: flex; justify-content: center;">
            <li role="presentation"><a href="#tab-gesture-general" aria-controls="tab-gesture-general" role="tab" data-toggle="pill"><i class="fa fa-bookmark-o" aria-hidden="true"></i> <?php echo $lang->general ?></a></li>
            <li role="presentation"><a href="#tab-gesture-gesture-sets" aria-controls="tab-gesture-gesture-sets" role="tab" data-toggle="pill"><i class="fa fa-paperclip" aria-hidden="true"></i> <?php echo $lang->gestureSets ?></a></li>
            <li role="presentation"><a href="#tab-gesture-comments" aria-controls="tab-gesture-comments" role="tab" data-toggle="pill"><i class="fa fa-comments-o" aria-hidden="true"></i> <?php echo $lang->comments ?></a></li>
        </ul> -->

    <!--    <div class="tab-content" style="margin-top: 20px;">
    
            <div role="tabpanel" class="tab-pane" id="tab-gesture-general">
                <div class="row" id="gesture-general-info-container">
                    <div class="col-md-5 root" style="margin-bottom: 20px">
                        <div id="sensor-content-container" class="hidden" style="margin-bottom: 30px">
                            <div class="sensor-content">
                                <div data-sensor-source="webcam" id="webcam-preview" class="autoplay hidden">
                                    <div class="root embed-responsive embed-responsive-4by3">
                                        <div id="" class="webcam-image-container"></div>
                                        <div class="controls-container embed-responsive-item">
                                            <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                                            <div class="controls-container-btn application-btn application-btn-top-left-single btn-download-as-gif" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsGIF ?>"><i class="fa fa-file-image-o"></i></div>
                                        </div>
                                    </div>
    
                                    <div id="webcam-playback-slider-controls" class="hidden" style="margin-top: -10px" data-visible="true">
                                        <div id="webcam-playback-slider-container" class="webcam-playback-slider-container" style="width: 100%;">
                                            <input id="webcam-playback-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                        </div>
                                    </div>
                                </div>
    
                                <div data-sensor-source="leap" id="leap-recording-container" class="hidden">
    
                                    <div class="embed-responsive embed-responsive-4by3">
                                        <div id="renderArea" class="embed-responsive-item sensor-canvas"></div>
                                        <div class="controls-container embed-responsive-item">
                                            <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                                            <div class="controls-container-btn application-btn application-btn-top-left-first btn-download-as-json" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsJSON ?>"><i class="fa fa-file-code-o"></i></div>
                                            <div class="controls-container-btn application-btn application-btn-top-left-last btn-download-as-compressed" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsCompressed ?>"><i class="fa fa-file-zip-o"></i></div>
                                        </div>
                                    </div>
    
                                    <div id="playback-controls" style="margin-top: -10px">
                                        <div id="leap-playback-slider-container" class="leap-playback-slider-container hidden" style="width: 100%;">
                                            <input id="leap-playback-slider" data-slider-id="sliderLeap" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                        </div>
                                    </div>
    
                                </div>
                            </div>
    
                            <div id="toggle-gesture-recording-source" class="hidden text-center" style="margin-top: 0px">
                                <div class="btn-group btn-group-xs">
                                    <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="webcam" id="btn-webcam"><i class="fa fa-video-camera"></i> <?php echo $lang->sensors->webcam->title ?></button>
                                    <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="leap" id="btn-leap"><i class="fa fa-code"></i> <?php echo $lang->sensors->leap->title ?></button>
                                    <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="kinect" id="btn-kinect"><i class="fa fa-code"></i> <?php echo $lang->sensors->kinect->title ?></button>
                                </div>
                            </div>
                        </div>
    
                        <div class="gesture-rating" id="gesture-rating" style="">
                            <h3 style="margin-top: 0px"><i class="fa fa-star-o"></i> <?php echo $lang->valuation ?></h3>
                            <div class="rating-container rating-physicalContext row" id="rating-physicalContext">
                                <div class="col-xs-5 col-sm-3 col-md-5 rating-stars-container"></div>
                                <div class="col-xs-7 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text"><?php echo $lang->valuationType ?></span></div>
                            </div>
                            <div class="rating-container rating-adaption row" id="rating-adaption">
                                <div class="col-xs-5 col-sm-3 col-md-5 rating-stars-container"></div>
                                <div class="col-xs-7 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text"><?php echo $lang->valuationAdaption ?></span></div>
                            </div>
                            <div class="rating-container rating-fittingTask row" id="rating-fittingTask">
                                <div class="col-xs-5 col-sm-3 col-md-5 rating-stars-container"></div>
                                <div class="col-xs-7 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text"><?php echo $lang->valuationTask ?></span></div>
                            </div>
                            <div id="rating-infos">
                                <span id="rated-by"></span> 
                                <div id="rated-by-myself" class="hidden"><?php echo $lang->gestureRated ?></div>
                                <div class="alert-space alert-rating-submitted" style="margin-top: 10px;"></div>
                            </div>
                            <button type="button" class="btn btn-block btn-default" id="btn-rate-gesture" style="margin-top: 10px;"><i class="fa fa-star"></i> <?php echo $lang->rateGesture ?></button>
                            <div class="btn-group  btn-group-justified hidden" id="rating-submit-buttons" style="margin-top: 0px;">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success" id="btn-submit-gesture-rating"><i class="fa fa-check"></i> <span class="btn-text"><?php echo $lang->submitGestureRating ?></span></button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger" id="btn-cancel-gesture-rating"><i class="fa fa-close"></i> <span class="btn-text"><?php echo $lang->cancel ?></span></button>
                                </div>
                            </div>
                        </div>
    
                        <div id="gesture-likes" style="margin-top: 30px; margin-bottom: 30px">
                            <h3><i class="fa fa-heart-o"></i> <?php echo $lang->likes ?></h3>
                            <span id="liked-by"></span>
                            <div style="display: block">
                                <div class="btn-like" style="display: inline-block; margin-right: 5px; font-size: 16pt; cursor: pointer"><i class="fa fa-heart-o"></i> <span class="amount hidden"></span></div>
                                <div style="display: inline-block" class="liked-self"></div>
                            </div>
                        </div>
    
                        <div style="display: block" id="gesture-sharing">
                            <h3><i class="fa fa-share-alt"></i> <?php echo $lang->share ?></h3>
                            <div style="" class="shared-with-own-projects"></div>
                            <div style="" class="shared-with-other-projects"></div>
                            <div style="margin-top: 10px" class="share-with-all"><label class="text"><?php echo $lang->inviteAllUsersForGesture ?></label></div>
                            <div style="margin-top: -10px" class="share-with-all">
                                <div class="btn-share" style="display: inline-block; cursor: pointer"><span style="font-size: 28pt; line-height: 16px; top: 8px; position: relative;">&infin;</span></div>
                                <div style="display: inline-block" class="shared-self"></div>
                            </div>
    
                            <div id="invited-users" style="margin-top: 10px">
    
                                <div class="form-group" id="invite-users-form">
                                    <label class="text"><?php echo $lang->inviteUserViaMail ?></label>
                                    <div class="alert-space alert-gesture-not-shared"></div>
                                    <div class="alert-space alert-missing-email"></div>
                                    <div class="alert-space alert-invalid-email"></div>
                                    <div class="alert-space alert-user-already-invited"></div>
                                    <div class="alert-space alert-share-gesture-to-yourself"></div>
    
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="input-email" minlength="8" maxlength="50" placeholder="<?php echo $lang->email ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default btn-shadow" type="button" id="btn-invite-user"><i class="fa fa-paper-plane"></i> <span class="btn-text"><?php echo $lang->invite ?></span></button>
                                        </span>
                                    </div>
    
                                    <div id="shared-gesture-list" style="margin-top: 10px"></div>
                                </div>
                            </div>
                        </div>
    
                    </div>
    
                    <div class="col-md-7">
                        <div class="panel panel-shadow" id="gesture-data-preview">
                            <div class="panel-body">
                                <div style="margin: 0; display: flex">
                                    <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                                    <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>
                                </div>
    
                                <div style="margin-top: 10px">
                                    <div id="created"><span class="address"><?php echo $lang->Created ?>:</span> <span class="text"></span></div>
                                    <div id="creator"><?php echo $lang->userTypes->interactionDesigner ?>: <span class="text"></span></div>
                                    <div id="title"><span><?php echo $lang->title ?> <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->gestureNameQuality ?>"></i>:</span> <span class="label label-default" id="gesture-title-quality"></span> <span class="text"></span></div>
                                    <div id="type" style="display:flex"><span><?php echo $lang->gestureType ?> <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->executionType ?>"></i>:</span> <div class="gesture-info-symbol symbol-gesture-execution" style="margin-top: 9px; margin-left: 6px; margin-right: 2px;"></div> <span class="address"></span> <span class="text"></span></div>
                                    <div id="interactionType" style="display:flex"><span><?php echo $lang->gestureInteractionType ?> <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->interactionType ?>"></i>:</span> <div class="gesture-info-symbol symbol-gesture-interaction" style="margin-top: 9px; margin-left: 6px;margin-right: 2px"></div> <span class="address"></span> <span class="text"></span></div>
                                    <div id="context"><span><?php echo $lang->gestureContext ?> <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->context ?>"></i>:</span><span class="address"></span> <span class="text"></span></div>
                                    <div id="association"><span><?php echo $lang->gestureAssociation ?> <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->association ?>"></i>:</span><span class="address"></span> <span class="text"></span></div>
                                    <div id="description"><?php echo $lang->gestureDescription ?>:<span class="address"></span> <span class="text"></span></div>
                                    <div id="doubleSidedUse"><span><?php echo $lang->doubleSidedUse ?> <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->doubleSidedUse ?>"></i>:</span><span class="address"></span> <span class="text"></span></div>
    
                                    <div class="preview-joints-humand-body" id="human-body-preview" style="width: 350px; margin: auto; margin-top: 10px">
                                        <div id="joint-container" style="position: absolute"></div>
                                        <img src="img/human_body.svg">
                                    </div>
                                </div>
    
                                <button type="button" class="btn btn-block btn-default btn-shadow gesture-previewable gesture-owner-controls" id="btn-edit-gesture" style="margin-top: 20px"><i class="fa fa-pencil" aria-hidden="true"></i> <span class="btn-text"></span></button>
    
                            </div>
    
                        </div>
    
                    </div>
                </div>
    
                <div class="row hidden" id="gesture-edit-general-info-container">
                    <div class="col-xs-12 col-md-8 col-md-offset-2">
    
                    </div>
                </div>
            </div>
    
    
    
        </div>-->

    <div class="recorder-content" id="update-gesture-recorder-content"></div>
    <button type="button" class="btn btn-default btn-shadow btn-block btn-cancel-edit-gesture" style="margin-top: 10px"><i class="fa fa-close"></i> <?php echo $lang->gesturePreviewable ?></button>

</div>

<div id="modal-body-delete-gesture" class="modal-body hidden">
    <div class="text-center text">
        <p>
            <?php echo $lang->deleteGestureModal ?>
        </p>
    </div>

    <div class="btn-group btn-group-justified">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default btn-shadow" id="btn-yes"><i class="fa fa-check"></i> <?php echo $lang->yes ?></button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn  btn-default btn-shadow" id="btn-no"><i class="fa fa-close"></i> <?php echo $lang->no ?></button>
        </div>

    </div>
</div>

<!--<div class="hidden panel panel-default panel-sm panel-shadow" id="gesture-comment-item" style="margin-top: 0px; margin-bottom: 8px">
    <div class="panel-heading" style="font-size: 10pt">
        <span id="user"><i class="fa fa-comment" aria-hidden="true"></i> <span class="text"></span></span>
        <span id="created" class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="text"></span></span>
    </div>
    <div class="panel-body" style="color: #303030; font-size: 10pt"></div>
    <div class="panel-footer">
        <button class="btn btn-xs btn-danger" id="btn-delete-comment"><i class="fa fa-trash"></i> <?php echo $lang->deleteComment ?></button>
    </div>
</div>-->

<!--<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-shadow btn-danger pull-left gesture-owner-controls" id="btn-delete-gesture"><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->deleteGesture ?></span></button>
    <div class="" style="display: inline-block; margin-right: 12px">
        <button type="button" class="btn btn-default btn-shadow btn-join-conversation"><span class=""><?php echo $lang->joinConversation ?></span> <i class="fa fa-group"></i></button>
        <button type="button" class="btn btn-default btn-shadow btn-leave-conversation hidden"><span class=""><?php echo $lang->leaveConversation ?></span> 
            <span>
                <i class="fa fa-group"></i>
                <i class="fa fa-ban" style="
                   font-size: 9pt;
                   position: relative;
                   right: 5px;
                   top: -6px;"></i>
            </span>
        </button>
    </div>
    <button type="button" class="btn btn-shadow btn-default" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
</div>-->

<script>
    var gestureUpdateRecorder = null;

    $(document).ready(function () {
        renderGeneralGestureInfo();
    });

    function renderGeneralGestureInfo() {
        var gesture = currentSaveGesture.gesture;
        if (gesture === null) {
            return false;
        }

        var modal = $('#custom-modal');

        var recorder = $('#item-container-gesture-recorder').find('#gesture-recorder-with-introductions').clone().removeAttr('id');
        $(modal).find('#update-gesture-recorder-content').empty().append(recorder);

        var initRecorders = [];
        var startState = GR_STATE_PRE_INITIALIZE;
        if (gesture.images && !isNaN(parseInt(gesture.previewImage))) {
            startState = GR_STATE_SAVE;
            initRecorders.push({type: 'webcam', images: gesture.images, blobs: gesture.blobs, previewImage: gesture.previewImage, gif: gesture.gif, autoplayPlayback: true, autoplaySave: true, autoplaySaveSuccess: true});
        }

        console.log('sensor data', gesture.sensorData);
        if (gesture.sensorData) {
            var sensorData = gesture.sensorData;
            switch (sensorData.sensor) {
                case TYPE_RECORD_LEAP:
                    sensorData.type = sensorData.sensor;
                    sensorData.compressedData = sensorData.url;
                    sensorData.previewOnly = true;
//                    gesture.sensorData = sensorData;
                    break;
            }
        }

        var options = {
            recorderTarget: recorder,
            alertTarget: $('#recorder-content'),
            saveGesture: true,
            updateGesture: true,
//            updateGestureId: gesture.id,
            checkType: true,
            checkInteractionType: true,
            showIntroduction: true,
            startState: startState,
            usedStates: [GR_STATE_PRE_INITIALIZE, GR_STATE_INITIALIZE, GR_STATE_RECORD, 'recordingStopped', GR_STATE_PLAYBACK, GR_STATE_SAVE],
            record: [
                {type: 'webcam', autoplayPlayback: true, autoplaySave: true, autoplaySaveSuccess: true},
                {type: 'leap', autoplayPlayback: true, autoplaySave: true, autoplaySaveSuccess: true} // , renderTarget: $(recorder).find('#leapRecordRenderArea')
            ],
            initRecorders: initRecorders,
            updateData: {
                title: currentSaveGesture.trigger.title,
//                titleQuality: gesture.titleQuality,
//                execution: gesture.type,
//                interaction: gesture.interactionType,
//                context: gesture.context,
//                association: gesture.association,
//                description: gesture.description,
//                joints: gesture.joints,
//                doubleSidedUse: gesture.doubleSidedUse
            },
            userId: currentSaveGesture.userId || null,
//            ownerId: gesture.ownerId,
            source: currentSaveGesture.gestureSource || null,
            originSensorData: gesture.sensorData || null
        };

        console.log(options);

        gestureUpdateRecorder = new GestureRecorder(options);

        $(gestureUpdateRecorder).on('gr-save-progress', function (event) {
            event.preventDefault();
            $(modal).find('.btn-cancel-edit-gesture').addClass('hidden');
        });

        $(gestureUpdateRecorder).on('gr-save-success', function (event, data) {
            event.preventDefault();

            addGestureToCatalog(data);
//            updateGestureById(currentSaveGesture.source, data.id, {title: data.title, titleQuality: data.titleQuality, type: data.type, interactionType: data.interactionType, context: data.context, association: data.association, description: data.description, joints: data.joints, doubleSidedUse: data.doubleSidedUse, images: data.images, previewImage: data.previewImage, gif: data.gif, sensorData: data.sensorData});
            gestureUpdateRecorder.destroy();
            gestureUpdateRecorder = null;

            $(modal).modal('hide');
            $(modal).trigger('gestureSaved', [data]);
            $(modal).find('.btn-cancel-edit-gesture').removeClass('hidden');
        });

        $(modal).find('.btn-cancel-edit-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var modal = $('#custom-modal');

            $(modal).find('.gesture-owner-controls').removeClass('hidden');
            $(modal).find('#gesture-general-info-container').removeClass('hidden');
            $(modal).find('#gesture-edit-general-info-container').addClass('hidden');
            $(modal).find('#gesture-edit-general-info-container .edit-content').empty();

            gestureUpdateRecorder.destroy();
            gestureUpdateRecorder = null;

            $(modal).trigger('saveGestureCanceled');
        });
    }
</script>