<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
        <?php echo $lang->gesturePreview ?>
    </h4>
</div>
<div id="modal-body" class="modal-body">

    <!-- Nav tabs -->
    <ul class="nav nav-pills" id="gesture-info-nav-tab" style="display: flex; justify-content: center;">
        <li role="presentation"><a href="#tab-gesture-general" aria-controls="tab-gesture-general" role="tab" data-toggle="pill"><i class="fa fa-bookmark-o" aria-hidden="true"></i> <?php echo $lang->general ?></a></li>
        <li role="presentation"><a href="#tab-gesture-gesture-sets" aria-controls="tab-gesture-gesture-sets" role="tab" data-toggle="pill"><i class="fa fa-paperclip" aria-hidden="true"></i> <?php echo $lang->gestureSets ?></a></li>
        <li role="presentation"><a href="#tab-gesture-comments" aria-controls="tab-gesture-comments" role="tab" data-toggle="pill"><i class="fa fa-comments-o" aria-hidden="true"></i> <?php echo $lang->comments ?></a></li>
    </ul> 

    <div class="tab-content" style="margin-top: 20px;">

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
                                        <div class="controls-container-btn application-btn application-btn-top-left-first btn-download-as-gif" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsGIF ?>"><i class="fa fa-file-image-o"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-top-left-last btn-download-as-zip" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadImagesAsZIP ?>"><i class="fa fa-file-zip-o"></i></div>
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
                                <!--<button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="kinect" id="btn-kinect"><i class="fa fa-code"></i> <?php echo $lang->sensors->kinect->title ?></button>-->
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
                        <button type="button" class="btn btn-block btn-shadow btn-default" id="btn-rate-gesture" style="margin-top: 10px;"><i class="fa fa-star"></i> <?php echo $lang->rateGesture ?></button>
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
                                <div id="continuousValueType" style="display:flex"><span><?php echo $lang->continuousValueTypeLabel ?> <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->continuousValueType ?>"></i>:</span> <span class="address"></span> <span class="text"></span></div>
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

            <!--            <div class="row hidden" id="gesture-edit-general-info-container">
                            <div class="col-xs-12 col-md-8 col-md-offset-2">
                                <div class="recorder-content" id="update-gesture-recorder-content"></div>
                                <button type="button" class="btn btn-default btn-shadow btn-block" id="btn-cancel-edit-gesture" style="margin-top: 10px"><i class="fa fa-close"></i> <?php echo $lang->gesturePreviewable ?></button>
                            </div>
                        </div>-->
            <div class="hidden" id="gesture-edit-general-info-container">
                <!--<div class="col-xs-12 col-md-8 col-md-offset-2">-->
                <div class="recorder-content" id="update-gesture-recorder-content"></div>
                <!--</div>-->
            </div>
        </div>

        <div role="tabpanel" class="tab-pane" id="tab-gesture-gesture-sets">
            <div id="attached-gesture-sets">

                <div id="add-to-gesture-set">
                    <div class="create-gesture-set-input">
                        <label class="text"><?php echo $lang->createNewGestureSet ?></label>

                        <div class="alert-space alert-gesture-set-title-too-short"></div>

                        <div class="input-group">
                            <input type="text" class="form-control" id="input-new-set-title" minlength="8" maxlength="60" placeholder="<?php echo $lang->createNewGestureSetPlaceholder ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-shadow btn-add-gesture-set" type="button" id="btn-add-gesture-set"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                    </div>

                    <div class="row text-center" style="margin-top: 20px">
                        <label class="uppercase" style="font-size: 10pt"><?php echo $lang->or ?></label>
                    </div>

                    <div style="margin-top: 10px">
                        <label class="text"><?php echo $lang->assignToGestureSet ?></label>

                        <div id="existing-sets-container">
                            <div id="gesture-set-loading-indicator" class="hidden"><i class="fa fa-circle-o-notch fa-2x fa-spin"></i></div>
                            <div class="option-container root"></div>
                        </div>
                        <div class="alert-space alert-no-gesture-sets-for-study"></div>
                    </div>

                </div>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane" id="tab-gesture-comments">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <textarea class="form-control" id="comment" rows="4" maxlength="500" placeholder="<?php echo $lang->inputComment ?>" required></textarea>
                    </div>
                    <button type="button" class="btn btn-default btn-shadow btn-block" id="btn-comment-gesture"><i class="fa fa-send" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->submitComment ?></span></button>
                </div>
                <div class="col-md-7">
                    <div class="alert-space alert-no-comments"></div>
                    <div id="comments-list"></div>
                </div>
            </div>
        </div>

    </div>

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

<div class="hidden panel panel-default panel-sm panel-shadow" id="gesture-comment-item" style="margin-top: 0px; margin-bottom: 8px">
    <div class="panel-heading" style="font-size: 10pt">
        <span id="user"><i class="fa fa-comment" aria-hidden="true"></i> <span class="text"></span></span>
        <span id="created" class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="text"></span></span>
    </div>
    <div class="panel-body" style="color: #303030; font-size: 10pt"></div>
    <div class="panel-footer">
        <button class="btn btn-xs btn-danger" id="btn-delete-comment"><i class="fa fa-trash"></i> <?php echo $lang->deleteComment ?></button>
    </div>
</div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow hidden" id="btn-cancel-edit-gesture" style="float: left"><i class="fa fa-close"></i> <?php echo $lang->gesturePreviewable ?></button>
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
</div>

<script>
    var testRatings = [{physicalContext: 1, adaption: 0, fittingTask: 3}, {physicalContext: 0, adaption: 3, fittingTask: 4}, {physicalContext: 2, adaption: 0, fittingTask: 3}, {physicalContext: 2, adaption: 2, fittingTask: 3}, {physicalContext: 2, adaption: 1, fittingTask: 1}];
    var currentRatings = [{physicalContext: 0, adaption: 0, fittingTask: 0}];
    var leapMotionPreview = null;
    var gestureUpdateRecorder = null;

    $(document).ready(function () {

        initGestureRating($('#gesture-rating'), 5);

        $('#gesture-info-nav-tab').unbind('shown.bs.tab').bind('shown.bs.tab', function (event) {
            switch ($(event.target).attr('href')) {
                case '#tab-gesture-general':
                    renderSensorData();
                    renderGeneralGestureInfo();
                    renderInvitedGestureUsers();
                    break;
                case '#tab-gesture-gesture-sets':
                    resetGeneralGestureInfo();
                    renderAttachedGestureSets();
                    break;
                case '#tab-gesture-comments':
                    resetGeneralGestureInfo();
                    renderGestureComments();
                    break;
            }
            initPopover();

            if ($('.custom-modal').attr('data-conv-allowed') === 'false') {
                $('.custom-modal').find('.btn-join-conversation').remove();
                $('.custom-modal').find('.btn-leave-conversation').remove();
            } else {
                // join and leave conversation about this gesture
                $('.btn-join-conversation').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    initCollaborativeVideoCaller('gesture' + currentPreviewGesture.gesture.id);
                });

                $('.btn-leave-conversation').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    leaveCollaborativeVideoCaller();
                });
            }
        });

        if (currentPreviewGesture.startTab) {
            switch (currentPreviewGesture.startTab) {
                case 'general':
                    $('#gesture-info-nav-tab a[href="#tab-gesture-general"]').tab('show');
                    break;
                case 'gestureSets':
                    $('#gesture-info-nav-tab a[href="#tab-gesture-gesture-sets"]').tab('show');
                    break;
                case 'comments':
                    $('#gesture-info-nav-tab a[href="#tab-gesture-comments"]').tab('show');
                    break;
                case 'rating':
                    $('#gesture-info-nav-tab a[href="#tab-gesture-general"]').tab('show');

                    setTimeout(function () {
                        var ratingTop = $('#custom-modal').find('#gesture-rating').position().top;
                        $('#custom-modal').animate({
                            scrollTop: ratingTop + 180
                        }, 300);
                    }, 300);

                    break;
                case 'shareGesture':
                    $('#gesture-info-nav-tab a[href="#tab-gesture-general"]').tab('show');

                    setTimeout(function () {
                        var ratingTop = $('#custom-modal').find('#gesture-sharing').position().top;
                        $('#custom-modal').animate({
                            scrollTop: ratingTop + 180
                        }, 300);
                    }, 300);

                    break;
            }
        } else {
            $('#gesture-info-nav-tab a[href="#tab-gesture-general"]').tab('show');
        }

        $('#custom-modal').bind('hidden.bs.modal', function () {
            currentPreviewGesture = null;
            gesturePreviewOpened = false;
            $(this).unbind('hidden.bs.modal');
        });

        $('#custom-modal').bind('hide.bs.modal', function () {
            if (leapMotionPreview && currentPreviewGesture.gesture.sensorData) {
                leapMotionPreview.destroy(true);
                leapMotionPreview = null;
            }

            if (gestureUpdateRecorder) {
                gestureUpdateRecorder.destroy();
                gestureUpdateRecorder = null;
            }

            if ($('.custom-modal').attr('data-conv-allowed') !== 'false') {
                $('.btn-leave-conversation').click();
            }

            $(this).unbind('hide.bs.modal');
        });
    });


    $(document).on('mouseleave', '.rating-stars-container', function (event) {
        event.preventDefault();
        if ($(this).find('.active').length === 0) {
            $(this).find('.btn-gesture-rating-clickable .fa').removeClass('fa-star').addClass('fa-star-o');
        } else {
            $(this).find('.active').find('.fa').removeClass('fa-star-o').addClass('fa-star');
            $(this).find('.active').prevAll().find('.fa').removeClass('fa-star-o').addClass('fa-star');
            $(this).find('.active').nextAll().find('.fa').removeClass('fa-star').addClass('fa-star-o');
        }
    });

    $(document).on('mouseenter', '.btn-gesture-rating-clickable', function (event) {
        event.preventDefault();
        $(this).prevAll().find('.fa').removeClass('fa-star-o').addClass('fa-star');
        $(this).find('.fa').removeClass('fa-star-o').addClass('fa-star');
        $(this).nextAll().find('.fa').removeClass('fa-star').addClass('fa-star-o');
    });

    $(document).on('click', '.btn-gesture-rating-clickable', function (event) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
            $(this).addClass('active');
            $(this).prevAll().removeClass('active');
            $(this).prevAll().find('.fa').removeClass('fa-star-o').addClass('fa-star');
            $(this).find('.fa').removeClass('fa-star-o').addClass('fa-star');
            $(this).nextAll().removeClass('active');
            $(this).nextAll().find('.fa').removeClass('fa-star').addClass('fa-star-o');
        }
    });

    $('#btn-rate-gesture').on('click', function (event) {
        event.preventDefault();
        if (!event.handled && !$(this).hasClass('disabled')) {
            $(this).addClass('hidden');
            $(this).closest('.gesture-rating').find('#rating-submit-buttons').removeClass('hidden');
            $(this).closest('.gesture-rating').find('.btn-gesture-rating .fa').removeClass('fa-star-half-full fa-star').addClass('fa-star-o');
            $(this).closest('.gesture-rating').find('.btn-gesture-rating').addClass('btn-gesture-rating-clickable');
        }
    });

    $('#btn-cancel-gesture-rating').on('click', function (event) {
        event.preventDefault();
        if (!event.handled && !$(this).hasClass('disabled')) {
            $(this).closest('.gesture-rating').find('#rating-submit-buttons').addClass('hidden');
            $(this).closest('.gesture-rating').find('#btn-rate-gesture').removeClass('hidden');
            $(this).closest('.gesture-rating').find('.btn-gesture-rating').removeClass('btn-gesture-rating-clickable active');
            renderGestureRating($(this).closest('.gesture-rating'), currentRatings, false);
        }
    });

    $('#btn-submit-gesture-rating').on('click', function (event) {
        event.preventDefault();
        if (!event.handled && !$(this).hasClass('disabled')) {
            event.handled = true;
            var activeStars = $(this).closest('.gesture-rating').find('.active');
            var container = $(this).closest('.gesture-rating').find('.rating-container');
            var button = $(this);

            if (activeStars.length === container.length) {
                lockButton(button);
                $(this).closest('.gesture-rating').find('#btn-cancel-gesture-rating').addClass('disabled');
                $(this).closest('.gesture-rating').find('.btn-gesture-rating').removeClass('btn-gesture-rating-clickable');
                var ratings = {};

                for (var i = 0; i < container.length; i++) {
                    var id = $(container[i]).attr('id').split('-')[1];
                    var rating = $(container[i]).find('.active').index();
                    ratings[id] = rating;
                }

                submitRatingForGesture({gestureId: currentPreviewGesture.gesture.id, ratings: ratings}, function (result) {
                    unlockButton(button);
                    $(button).closest('.gesture-rating').find('#btn-cancel-gesture-rating').removeClass('disabled');

                    if (result.status === RESULT_SUCCESS) {
                        $(button).closest('.gesture-rating').find('#btn-rate-gesture').remove();
                        $(button).closest('.gesture-rating').find('#rating-submit-buttons').addClass('hidden');
                        $(button).closest('.gesture-rating').find('.btn-gesture-rating').removeClass('btn-gesture-rating-clickable active');
                        renderGestureRating($(button).closest('.gesture-rating'), result.ratings, true);
                        appendAlert($('#gesture-rating'), ALERT_RATING_SUBMITTED);

                        $(currentPreviewGesture.thumbnail).find('.btn-rate').addClass('gesture-rated');
                        $(currentPreviewGesture.thumbnail).find('.btn-rate .fa').removeClass('fa-star-o').addClass('fa-star');
                        $(currentPreviewGesture.thumbnail).find('.btn-rate .amount').text(parseInt(result.ratings.length) === 0 ? '' : result.ratings.length);
                        $(currentPreviewGesture.thumbnail).find('.btn-rate').attr('data-content', translation.gestureRated);
                    }
                });
            }
        }
    });

    function initGestureRating(target, totalStars) {
        for (var i = 0; i < totalStars; i++) {
            var ratingButton = document.createElement('div');
            $(ratingButton).addClass('btn-gesture-rating');
            var emptyStar = document.createElement('i');
            $(emptyStar).addClass('fa fa-star-o');
            $(ratingButton).append(emptyStar);
            $(target).find('.rating-stars-container').append(ratingButton);
        }

//        $('#rated-by').text(translation.ratedBy);
    }

    function renderGestureRating(target, ratings, newData) {
        if (newData) {
            if (ratings === null) {
                ratings = [];
            }
            $('#rating-infos').find('#rated-by').html(new String(parseInt(ratings.length) === 1 ? translation.ratedByUser : translation.ratedByUsers).replace('{x}', ratings.length || 0));

//            $('#rating-users-count').text(ratings !== null ? ratings.length : 0);
//            if (ratings === null) {
//                $('#rated-by-users').text(translation.ratedByUsers);
//            } else {
//                $('#rated-by-users').text(ratings.length === 1 ? translation.ratedByUser : translation.ratedByUsers);
//            }

            ratings = calculateRatings(ratings);
        }

        currentRatings = ratings;

        if (ratings) {
            for (var key in ratings) {
                var value = parseFloat(ratings[key]) + 1;
                var viewValue;
                if (value % .5 === 0) {
                    viewValue = value;
                } else if ((value % 1 >= .25 && value % 1 < .5) || (value % 1 <= .75 && value % 1 > .5)) {
                    viewValue = Math.floor(value) + .5;
                } else {
                    viewValue = Math.round(value);
                }

                var container = $(target).find('.rating-' + key + ' .rating-stars-container');
                var fullStars = parseInt(Math.abs(viewValue));
                var hasHalfStar = viewValue % 1 === .5;
                var nthStar = container.find(".btn-gesture-rating:nth-child(" + fullStars + ")");
                $(nthStar).prevAll().find('.fa').removeClass('fa-star-o').addClass('fa-star');
                $(nthStar).find('.fa').removeClass('fa-star-o').addClass('fa-star');
                $(nthStar).nextAll().find('.fa').removeClass('fa-star').addClass('fa-star-o');

                if (hasHalfStar) {
                    $(nthStar).next().find('.fa').removeClass('fa-star-o').addClass('fa-star-half-full');
                }
            }
        } else {
            $(target).find('.btn-gesture-rating .fa').removeClass('fa-star-half-full fa-star').addClass('fa-star-o');
        }
    }

    function calculateRatings(ratingsArray) {
        var ratings = {physicalContext: 0, adaption: 0, fittingTask: 0};
        if (ratingsArray && ratingsArray.length > 0) {
            for (var key in ratings) {
                for (var i = 0; i < ratingsArray.length; i++) {
                    var currentRating = ratings[key];
                    ratings[key] = currentRating + parseInt(ratingsArray[i].ratings[key]);
                }
                ratings[key] = ratings[key] / ratingsArray.length;
            }
            return ratings;
        }
        return null;
    }

    function renderGeneralGestureInfo() {
        var gesture = currentPreviewGesture.gesture;
        if (gesture === null) {
            return false;
        }

        var thumbnail = $(currentPreviewGesture.thumbnail);

        var container = $('#modal-body');
        container.find('#created .text').text(convertSQLTimestampToDate(gesture.created).toLocaleString());
        container.find('#creator .text').text(gesture.forename + (gesture.surname !== '.' ? ' ' + gesture.surname : ''));
        container.find('#title .text').text(gesture.title);
        container.find('#title #gesture-title-quality').text(translation.gestureNameQualities[gesture.titleQuality].title);
        container.find('#type .text').text(gesture.type === null ? '-' : translation.gestureTypes[gesture.type]);
        container.find('#type .symbol-gesture-execution').removeClass('dynamic pose').addClass(gesture.type);
        container.find('#interactionType .text').text(gesture.interactionType === null ? '-' : translation.gestureInteractionTypes[gesture.interactionType]);
        container.find('#interactionType .symbol-gesture-interaction').removeClass('discrete continuous').addClass(gesture.interactionType);
        container.find('#continuousValueType .text').text(gesture.continuousValueType === null ? '-' : translation.continuousValueType[gesture.continuousValueType]);
        container.find('#context .text').text(gesture.context);
        container.find('#association .text').text(gesture.association === null ? '-' : gesture.association);
        container.find('#description .text').text(gesture.description);
        container.find('#doubleSidedUse .text').text(translation[gesture.doubleSidedUse]);
        container.find('#btn-edit-gesture .btn-text').text(translation.edit);
        container.find('#tab-gesture-general .btn-download-as-gif').attr('data-gesture-id', gesture.id);
        container.find('#tab-gesture-general .btn-download-as-zip').attr('data-gesture-id', gesture.id);

        if (gesture.images && gesture.images.length > 0) {
            renderGesturePreview(container.find('#gesture-general-info-container #webcam-preview'), gesture);
            $(container).find('#sensor-content-container').removeClass('hidden');
            $(container).find('.sensor-content [data-sensor-source=webcam]').removeClass('hidden');
            $(container).find('.sensor-content [data-toggle-sensor=webcam]').click();
        }

        renderBodyJointsPreview(container.find('.preview-joints-humand-body'), gesture.joints);

        updateSharingInfos();
        updateGestureSharing();
        updateGestureRating();
        updateGestureLikes();

        var modal = $('#custom-modal');
        $('#modal-body #btn-edit-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();

            $(modal).find('.gesture-owner-controls').addClass('hidden');
            $(modal).find('#gesture-info-nav-tab').addClass('hidden');

            var playbackButtons = $(modal).find('#gesture-general-info-container .btn-toggle-playback');
            for (var i = 0; i < playbackButtons.length; i++) {
                if ($(playbackButtons[i]).attr('data-state') === 'playing') {
                    $(playbackButtons[i]).click();
                }
            }

            if (leapMotionPreview && currentPreviewGesture.gesture.sensorData) {
                leapMotionPreview.destroy(true);
                leapMotionPreview = null;
            }

            $(modal).find('#btn-cancel-edit-gesture').removeClass('hidden');
            $(modal).find('#gesture-general-info-container').addClass('hidden');
            $(modal).find('#gesture-edit-general-info-container').removeClass('hidden');
            $(modal).find('#gesture-edit-general-info-container #update-gesture-recorder-content').empty();

            var recorder = $('#item-container-gesture-recorder').find('#gesture-recorder-with-introductions').clone().removeAttr('id');
//            var recorder = $('#item-container-gesture-recorder').find('#gesture-recorder-without-introductions').clone().removeAttr('id');
            $(modal).find('#gesture-edit-general-info-container #update-gesture-recorder-content').append(recorder);

            var initRecorders = [];
            var startState = GR_STATE_PRE_INITIALIZE;
            if (gesture.images && !isNaN(parseInt(gesture.previewImage))) {
                startState = GR_STATE_SAVE;
                initRecorders.push({type: 'webcam', images: gesture.images, previewImage: gesture.previewImage, gif: gesture.gif, autoplayPlayback: true, autoplaySave: true, autoplaySaveSuccess: true});
            }

            if (gesture.sensorData) {
                var sensorData = gesture.sensorData;
                switch (sensorData.sensor) {
                    case TYPE_RECORD_LEAP:
                        sensorData.type = sensorData.sensor;
                        sensorData.compressedData = sensorData.url;
                        sensorData.previewOnly = true;
                        break;
                }
            }

            var options = {
                recorderTarget: recorder,
                alertTarget: $('#recorder-content'),
                saveGesture: true,
                updateGesture: true,
                updateGestureId: gesture.id,
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
                    title: gesture.title,
                    titleQuality: gesture.titleQuality,
                    execution: gesture.type,
                    interaction: gesture.interactionType,
                    continuousValueType: gesture.continuousValueType,
                    context: gesture.context,
                    association: gesture.association,
                    description: gesture.description,
                    joints: gesture.joints,
                    doubleSidedUse: gesture.doubleSidedUse
                },
                userId: gesture.userId,
                ownerId: gesture.ownerId,
                source: gesture.source,
                originSensorData: gesture.sensorData || null
            };

            gestureUpdateRecorder = new GestureRecorder(options);
            $(gestureUpdateRecorder).on('gr-update-success', function (event, data) {
                event.preventDefault();

                updateGestureById(currentPreviewGesture.source, data.id, {title: data.title, titleQuality: data.titleQuality, type: data.type, interactionType: data.interactionType, continuousValueType: data.continuousValueType, context: data.context, association: data.association, description: data.description, joints: data.joints, doubleSidedUse: data.doubleSidedUse, images: data.images, previewImage: data.previewImage, gif: data.gif, sensorData: data.sensorData});
                $(thumbnail).find('.gesture-name').text(data.title);
                $(thumbnail).find('.gesture-name').attr('data-content', translation.gestureNameQualities[data.titleQuality].title);
                $(thumbnail).find('.symbol-gesture-execution').removeClass('pose dynamic').addClass(data.type);
                $(thumbnail).find('.symbol-gesture-execution').attr('data-content', translation.gestureTypes[data.type + 's'] + ' ' + translation.gestureType);
                $(thumbnail).find('.text-gesture-execution').text(translation.gestureTypes[data.type + 'Short']);
                $(thumbnail).find('.symbol-gesture-interaction').removeClass('discrete continuous').addClass(data.interactionType);
                $(thumbnail).find('.symbol-gesture-interaction').attr('data-content', translation.gestureInteractionTypes[data.interactionType + 's'] + ' ' + translation.gestureInteraction);
                $(thumbnail).find('.text-gesture-interaction').text(translation.gestureInteractionTypes[data.interactionType + 'Short']);

                currentPreviewGesture.gesture = getGestureById(data.id, currentPreviewGesture.source);
                originalFilterData = getLocalItem(currentPreviewGesture.source);
                renderGestureImages($(thumbnail).find('.previewGesture'), data.images, data.previewImage);
                $(currentPreviewGesture.gesture);

                $(modal).find('.gesture-owner-controls').removeClass('hidden');
                $(modal).find('#gesture-general-info-container').removeClass('hidden');
                $(modal).find('#gesture-edit-general-info-container').addClass('hidden');
                $(modal).find('#gesture-edit-general-info-container .edit-content').empty();

                renderGeneralGestureInfo();
                gestureUpdateRecorder.destroy();
                gestureUpdateRecorder = null;
                renderSensorData();

                $(modal).find('#gesture-info-nav-tab').removeClass('hidden');
                $(modal).find('#btn-cancel-edit-gesture').addClass('hidden');
                $(modal).trigger('gestureUpdated', [currentPreviewGesture.gesture]);
            });
        });

        $(modal).find('#btn-cancel-edit-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(this).addClass('hidden');
            $(modal).find('.gesture-owner-controls').removeClass('hidden');
            $(modal).find('#gesture-general-info-container').removeClass('hidden');
            $(modal).find('#gesture-edit-general-info-container').addClass('hidden');
            $(modal).find('#gesture-edit-general-info-container .edit-content').empty();

            renderGeneralGestureInfo();
            gestureUpdateRecorder.destroy();
            gestureUpdateRecorder = null;
            renderSensorData();
        });

        if ($(thumbnail).hasClass('deleteable')) {
            $(modal).find('#btn-delete-gesture').unbind('click').bind('click', function (event) {
                event.preventDefault();
                var button = $(this);

                if (!event.handled && !$(this).hasClass('disabled')) {

                    event.handled = true;
                    lockButton(button, true, 'fa-trash');

                    $(modal).find('#modal-body').addClass('hidden');
                    $(modal).find('#modal-body-delete-gesture').removeClass('hidden');
                    $(modal).find('#modal-body-delete-gesture #btn-yes').unbind('click').bind('click', function (event) {
                        event.preventDefault();

                        var button = $(this);
                        lockButton(button, true, 'fa-check');
                        showCursor($('body'), CURSOR_PROGRESS);
                        $(modal).find('#modal-body-delete-gesture #btn-no').addClass('disabled');

                        deleteGesture({gestureId: currentPreviewGesture.gesture.id}, function (result) {
                            if (result.status === RESULT_SUCCESS) {
                                getGestureCatalog(function (catalogResult) {
                                    showCursor($('body'), CURSOR_DEFAULT);

                                    unlockButton(button, true, 'fa-check');
                                    $(modal).find('#modal-body-delete-gesture #btn-no').removeClass('disabled');

                                    if (result.status === RESULT_SUCCESS) {
                                        originalFilterData = catalogResult.gestures;
                                        currentFilterData = sort();

                                        $('#custom-modal').trigger('gesture-deleted', [result.gestureId]);
                                        $('#custom-modal').modal('hide');
                                    }
                                });
                            }
                        });
                    });

                    $(modal).find('#modal-body-delete-gesture #btn-no').unbind('click').bind('click', function (event) {
                        event.preventDefault();
                        $(modal).find('#modal-body').removeClass('hidden');
                        $(modal).find('#modal-body-delete-gesture').addClass('hidden');
                        unlockButton(button, true, 'fa-trash');
                    });
                }
            });
        } else {
            $(modal).find('#btn-delete-gesture').remove();
        }
    }

    function resetGeneralGestureInfo() {
        var modal = $('#custom-modal');
        $(modal).find('#gesture-general-info-container').removeClass('hidden');
        $(modal).find('#gesture-edit-general-info-container').addClass('hidden');
        $(modal).find('#gesture-edit-general-info-container .edit-content').empty();

        renderGeneralGestureInfo();
        if (gestureUpdateRecorder) {
            gestureUpdateRecorder.destroy();
            gestureUpdateRecorder = null;
        }

        if (leapMotionPreview && currentPreviewGesture.gesture.sensorData) {
            leapMotionPreview.destroy(true);
            leapMotionPreview = null;
        }

//        renderSensorData();
    }

    function updateSharingInfos() {
        var gesture = currentPreviewGesture.gesture;
        var shareButton = $(modal).find('.btn-share');
        $(modal).find('#gesture-scope #public').addClass('hidden');
        $(modal).find('#gesture-scope #private').addClass('hidden');
        $(modal).find('#gesture-scope #' + gesture.scope).removeClass('hidden');
        $(modal).find('#gesture-scope .label-text').text(translation.gestureScopes[gesture.scope]);

        if (gesture.isOwner === true) {
            $(modal).find('#gesture-rating #btn-rate-gesture').remove();

            $(shareButton).removeClass('hidden');
            if (gesture.scope === SCOPE_GESTURE_PRIVATE) {
                shareButton.removeClass('gesture-shared');
                $(modal).find('#gesture-sharing .shared-self').text(translation.gestureNotShared);
            } else {
                shareButton.addClass('gesture-shared');
                $(modal).find('#gesture-sharing .shared-self').text(translation.gestureShared);
            }

            if (gesture.source !== SOURCE_GESTURE_TESTER) {
                modal.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_OWN]);
                modal.find('#gesture-source #' + SOURCE_GESTURE_OWN).removeClass('hidden');
            } else {
                modal.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_TESTER]);
                modal.find('#gesture-source #' + SOURCE_GESTURE_TESTER).removeClass('hidden');
            }
        } else {
            $(modal).find('.gesture-owner-controls').remove();
            $(shareButton).remove();
            $(modal).find('#gesture-sharing .shared-self').remove();

            if (gesture.source !== SOURCE_GESTURE_TESTER) {
                modal.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_EVALUATOR]);
                modal.find('#gesture-source #' + SOURCE_GESTURE_EVALUATOR).removeClass('hidden');
            } else {
                modal.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_TESTER]);
                modal.find('#gesture-source #' + SOURCE_GESTURE_TESTER).removeClass('hidden');
            }
        }

        if (gesture.invitedUsers && gesture.invitedUsers.length > 0) {
            $(modal).find('#gesture-scope #public').addClass('hidden');
            $(modal).find('#gesture-scope #private').addClass('hidden');
            $(modal).find('#gesture-scope #public').removeClass('hidden');
            $(modal).find('#gesture-scope .label-text').text(translation.gestureScopes.public);
        }
    }

    function updateGestureSharing() {
        var modal = $('#custom-modal');

        getSharedGestureInfos({gestureId: currentPreviewGesture.gesture.id}, function (result) {
            if (result.status === RESULT_SUCCESS) {
                $(modal).find('#gesture-sharing .shared-with-own-projects').html(new String(translation.gestureSharedInOwnProjects).replace('{x}', result.usedSharedGestureInOwnProjectsCount));
                $(modal).find('#gesture-sharing .shared-with-other-projects').html(new String(translation.gestureSharedInOtherProjects).replace('{x}', result.usedSharedGestureInOtherProjectsCount));
            }
        });

        initShareGestureModalButton($(modal).find('#gesture-sharing .btn-share'), currentPreviewGesture.thumbnail, currentPreviewGesture.source, currentPreviewGesture.gesture, function () {
            updateSharingInfos();

            getSharedGestureInfos({gestureId: currentPreviewGesture.gesture.id}, function (result) {
                if (result.status === RESULT_SUCCESS) {
                    $(modal).find('#gesture-sharing .shared-with-own-projects').html(new String(translation.gestureSharedInOwnProjects).replace('{x}', result.usedSharedGestureInOwnProjectsCount));
                    $(modal).find('#gesture-sharing .shared-with-other-projects').html(new String(translation.gestureSharedInOtherProjects).replace('{x}', result.usedSharedGestureInOtherProjectsCount));
                }
            });
        });
    }

    function updateGestureRating() {
        var modal = $('#custom-modal');
        getRatingsForGesture({gestureId: currentPreviewGesture.gesture.id}, function (result) {
            if (result.status === RESULT_SUCCESS) {
                renderGestureRating($(modal).find('#gesture-rating'), result.ratings, true);
                if (result.hasRated && (result.hasRated === true || result.hasRated === 'true')) {
                    $(modal).find('#gesture-rating #rated-by-myself').removeClass('hidden');
                    $(modal).find('#gesture-rating #btn-rate-gesture').remove();
                }
            }
        });
    }

    function updateGestureLikes() {
        getLikesForGesture({gestureId: currentPreviewGesture.gesture.id}, function (result) {
            if (result.status === RESULT_SUCCESS) {
                $('#gesture-likes').find('#liked-by').html(new String(parseInt(result.likeAmount) === 1 ? translation.likedByUser : translation.likedByUsers).replace('{x}', result.likeAmount || 0));

                initLikeGesture($('#gesture-likes').find('.btn-like'), currentPreviewGesture.source, {id: currentPreviewGesture.gesture.id, hasLiked: result.hasLiked, likeAmount: result.likeAmount}, function () {
                    if ($('#gesture-likes').find('.btn-like').hasClass('gesture-liked')) {
                        $('#gesture-likes').find('.liked-self').text(translation.likedByMyself);
                        $(currentPreviewGesture.thumbnail).find('.btn-like .fa').removeClass('fa-heart-o').addClass('fa-heart');
                        $(currentPreviewGesture.thumbnail).find('.btn-like').addClass('gesture-liked');
                    } else {
                        $('#gesture-likes').find('.liked-self').text(translation.notLikedByMyself);
                        $(currentPreviewGesture.thumbnail).find('.btn-like').removeClass('gesture-liked');
                        $(currentPreviewGesture.thumbnail).find('.btn-like .fa').removeClass('fa-heart').addClass('fa-heart-o');
                    }
                    $(currentPreviewGesture.thumbnail).find('.btn-like .amount').text($('#gesture-likes').find('.btn-like .amount').text());
                });

                if (result.hasLiked && (result.hasLiked === true || result.hasLiked === 'true')) {
                    $('#gesture-likes').find('.liked-self').text(translation.likedByMyself);
                    $('#gesture-likes').find('.btn-like').addClass('gesture-liked');
                } else {
                    $('#gesture-likes').find('.liked-self').text(translation.notLikedByMyself);
                    $('#gesture-likes').find('.btn-like').removeClass('gesture-liked');
                }
            }
        });
    }

    function renderGestureComments() {
        getCommentsForGesture({gestureId: currentPreviewGesture.gesture.id}, function (result) {
            if (result.status === RESULT_SUCCESS) {
                renderComments(result.comments);
            }
        });

        $('#tab-gesture-comments #btn-comment-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var button = $(this);
            if (!$(button).hasClass('disabled')) {
                lockButton(button, true, 'fa-send');
                var comment = $('#tab-gesture-comments #comment').val().trim();
                if (comment !== '') {
                    showCursor($('body'), CURSOR_PROGRESS);
                    submitCommentForGesture({gestureId: currentPreviewGesture.gesture.id, comment: comment}, function (result) {
                        showCursor($('body'), CURSOR_DEFAULT);
                        unlockButton(button, true, 'fa-send');
                        if (result.status === RESULT_SUCCESS) {
                            $('#tab-gesture-comments #comment').val('');
                            renderComments(result.comments);
                            $(currentPreviewGesture.thumbnail).find('.btn-comment .fa').removeClass('fa-comment-o').addClass('fa-comments');
                            $(currentPreviewGesture.thumbnail).find('.btn-comment .amount').text(result.comments.length);
                        }
                    });
                } else {
                    unlockButton(button, true, 'fa-send');
                }
            }
        });
    }

    function renderComments(data) {
        var list = $('#tab-gesture-comments #comments-list');
        list.empty();
        if (data && data !== null && data.length > 0) {
            clearAlerts($('#tab-gesture-comments'));

            for (var i = 0; i < data.length; i++) {
                var clone = $('#gesture-comment-item').clone().removeClass('hidden').removeAttr('id');
                clone.find('.panel-heading #user .text').text(data[i].forename + " " + data[i].surname);
                clone.find('.panel-heading #created .text').text(convertSQLTimestampToDate(data[i].created).toLocaleString());
                clone.find('.panel-body').text(data[i].comment);
                list.prepend(clone);

                if (data[i].isOwner === true) {
                    clone.find('#btn-delete-comment').click({commentId: data[i].id, gestureId: data[i].gestureId}, function (event) {
                        var button = $(this);
                        if (!$(button).hasClass('disabled')) {
                            lockButton(button, true, 'fa-trash');
                            event.preventDefault();
                            showCursor($('body'), CURSOR_PROGRESS);
                            deleteComment({commentId: event.data.commentId, gestureId: event.data.gestureId}, function (result) {
                                showCursor($('body'), CURSOR_DEFAULT);
                                unlockButton(button, true, 'fa-trash');
                                if (result.status === RESULT_SUCCESS) {
                                    renderComments(result.comments);
                                    if (!result.comments) {
                                        $(currentPreviewGesture.thumbnail).find('.amount').text('');
                                        $(currentPreviewGesture.thumbnail).find('.btn-comment .fa').removeClass('fa-comments').addClass('fa-comment-o');
                                    } else {
                                        $(currentPreviewGesture.thumbnail).find('.amount').text(result.comments.length);
                                        $(currentPreviewGesture.thumbnail).find('.btn-comment .fa').removeClass('fa-comment-o').addClass('fa-comments');
                                    }
                                }
                            });
                        }
                    });
                } else {
                    clone.find('.panel-footer').remove();
                }
            }
        } else {
            appendAlert($('#tab-gesture-comments'), ALERT_NO_COMMENTS);
        }
    }

    /*
     * gesture set adding and attached rendering
     */
    function renderAttachedGestureSets(preselect, id) {
        $('#existing-sets-container').find('#gesture-set-loading-indicator').removeClass('hidden');
        getGestureSets(function (result) {
            if (result.status === RESULT_SUCCESS) {
                setLocalItem(GESTURE_SETS, result.gestureSets);
                renderModalGestureSets(preselect, id);
                $('#existing-sets-container').find('#gesture-set-loading-indicator').addClass('hidden');
            }
        });
    }

    function renderModalGestureSets(preselect, id) {
        var sets = getLocalItem(GESTURE_SETS);

        if (sets && sets !== null && sets !== '' && sets.length > 0) {
            var container = $('#add-to-gesture-set #existing-sets-container');
            container.find('.option-container').empty();

            var ownSetsCount = 0;
            for (var i = 0; i < sets.length; i++) {
                if (sets[i].isOwner === true) {
                    var option = $('#template-general-container').find('#checkbox').clone();
                    option.find('.option-text').text(sets[i].title);
                    option.find('.btn-checkbox').attr('id', sets[i].id);
                    container.find('.option-container').append(option);
                    container.find('.option-container').append(document.createElement('br'));

                    // preselect item after adding new gesture set
                    if (preselect === true && id && parseInt(id) === parseInt(sets[i].id)) {
                        option.find('.btn-checkbox').click();
                    }

                    // check gestures and make checkbox selected if gesture is in gesture set [i]
                    if (sets[i].gestures && sets[i].gestures.length > 0) {
                        if (checkSetAssignment(sets[i].gestures, currentPreviewGesture.gesture.id)) {
                            option.find('.btn-checkbox').click();
                        }
                    }
                    ownSetsCount++;
                }
            }

            if (ownSetsCount === 0) {
                appendAlert($('#add-to-gesture-set'), ALERT_NO_GESTURE_SETS_FOR_STUDY);
            }

            $('#add-to-gesture-set .create-gesture-set-input').unbind('gestureSetCreated').bind('gestureSetCreated', function (event, newSetId) {
                event.preventDefault();
                getGestureSets(function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        setLocalItem(GESTURE_SETS, result.gestureSets);
                        renderModalGestureSets(true, newSetId);
                    }
                });
            });

            $(container).unbind('change').bind('change', function (event) {
                event.preventDefault();
                saveGestureSets();
            });

            function saveGestureSets() {
                var listItems = $(container).find('.option-container').find('.btn-checkbox');
                for (var i = 0; i < listItems.length; i++) {
                    if ($(listItems[i]).hasClass('btn-option-checked')) {
                        addToGestureSet($(listItems[i]).attr('id'), currentPreviewGesture.gesture.id);
                    } else {
                        removeFromGestureSet($(listItems[i]).attr('id'), currentPreviewGesture.gesture.id);
                    }
                }

                // call ajax update gesture sets, calling php 
                updateGestureSets({sets: getLocalItem(GESTURE_SETS)}, function (result) {
                    var gestureSets = getLocalItem(GESTURE_SETS);
                    if (gestureSets) {
                        var titles = "";
                        var assignCount = 0;

                        for (var i = 0; i < gestureSets.length; i++) {
                            var gestureSetIds = gestureSets[i].gestures;
                            if (gestureSetIds) {
                                for (var j = 0; j < gestureSetIds.length; j++) {
                                    if (parseInt(currentPreviewGesture.gesture.id) === parseInt(gestureSetIds[j])) {
                                        titles += '<div>' + gestureSets[i].title + '</div>';
                                        assignCount++;
                                    }
                                }
                            }
                        }

                        if (assignCount > 0) {
                            $(currentPreviewGesture.thumbnail).find('.btn-edit-gesture-set').addClass('gesture-is-in-set');
                            $(currentPreviewGesture.thumbnail).find('.btn-edit-gesture-set').attr('data-content', titles);
                            $(currentPreviewGesture.thumbnail).find('.btn-edit-gesture-set .amount').text(assignCount);
                        } else {
                            $(currentPreviewGesture.thumbnail).find('.btn-edit-gesture-set').removeClass('gesture-is-in-set');
                            $(currentPreviewGesture.thumbnail).find('.btn-edit-gesture-set').attr('data-content', translation.notAssignedToGestureSet);
                            $(currentPreviewGesture.thumbnail).find('.btn-edit-gesture-set .amount').text('');
                        }
                    }

                    clearAlerts($('#add-to-gesture-set'));
                    $(container).trigger('gestureSetsUpdated', [currentPreviewGesture.gesture.id]);
                });
            }
        } else {
            appendAlert($('#add-to-gesture-set'), ALERT_NO_GESTURE_SETS_FOR_STUDY);
        }
    }

    function inputsValid(showErrors) {
        var container = $('#gesture-data-edit');
        var title = $(container).find('#gestureName').val().trim();
        if (title === '') {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var type = $(container).find('#gestureTypeSelect .btn-option-checked').attr('id');
        if (type === undefined) {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var interactionType = $(container).find('#gestureInteractionTypeSelect .btn-option-checked').attr('id');
        if (interactionType === undefined) {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var context = $(container).find('#gestureContext').val().trim();
        if (context === '') {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var association = $(container).find('#gestureAssociation').val().trim();
        if (association === '') {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var description = $(container).find('#gestureDescription').val().trim();
        if (description === '') {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var selectedJoints = getSelectedJoints($(container).find('#human-body #joint-container'));
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

    function renderSensorData() {
//        console.log('render Sensor data', currentPreviewGesture.gesture);
        if (currentPreviewGesture.gesture.sensorData !== null && currentPreviewGesture.gesture.sensorData !== '') {
            switch (currentPreviewGesture.gesture.sensorData.sensor) {
                case 'leap':
                    initializeLeapmotionPlayer();
                    break;
            }

            if (currentPreviewGesture.gesture.images && currentPreviewGesture.gesture.images.length > 0) {
                $('#custom-modal').find('#toggle-gesture-recording-source').removeClass('hidden');
                $('#custom-modal').find('#toggle-gesture-recording-source [data-toggle-sensor=webcam]').removeClass('hidden');
                $('#custom-modal').find('#toggle-gesture-recording-source [data-toggle-sensor=webcam]').click();
            }
        } else {
            $('#custom-modal').find('#toggle-gesture-recording-source [data-toggle-sensor=webcam]').click();
            $('#custom-modal').find('#toggle-gesture-recording-source').addClass('hidden');
        }
    }

    function initializeLeapmotionPlayer() {
        $('#custom-modal').find('#sensor-content-container').removeClass('hidden');
        if (currentPreviewGesture.gesture.images && currentPreviewGesture.gesture.images.length > 0) {
            $('#custom-modal').find('#toggle-gesture-recording-source #btn-leap').removeClass('hidden');
        } else {
            $('#custom-modal').find('#toggle-gesture-recording-source #btn-leap').click();
        }


        var container = $('#custom-modal').find('#leap-recording-container');
        var options = {
            offset: {x: 0, y: 200, z: 0},
            previewOnly: true,
            pauseOnHands: false,
            autoplay: true,
            recording: currentPreviewGesture.gesture.sensorData.url,
            renderTarget: $(container).find('#renderArea'),
            playbackElement: $(container).find('.btn-toggle-playback'),
            downloadJsonElement: $(container).find('.btn-download-as-json'),
            downloadCompressedElement: $(container).find('.btn-download-as-compressed'),
            playbackSliderElement: $(container).find('#leap-playback-slider')
        };
        leapMotionPreview = new LeapRecorder(options);
    }

    var modal = $('#custom-modal');
    function renderInvitedGestureUsers() {
        if (currentPreviewGesture.gesture.isOwner === true) {
            var invitedUsers = currentPreviewGesture.gesture.invitedUsers;
            $(modal).find('#shared-gesture-list').empty();
            clearAlerts($(modal).find('#invited-users'));

            if (invitedUsers && invitedUsers.length > 0) {
                for (var i = 0; i < invitedUsers.length; i++) {
                    var listItem = $('#shared-gesture-list-item').clone().removeAttr('id');
                    $(listItem).find('.shared-gesture-item-email').text(invitedUsers[i].email);
                    $(listItem).find('.btn-uninvite-user').attr('data-invite-id', invitedUsers[i].id);
                    $(listItem).find('.btn-uninvite-user').attr('data-invite-mail', invitedUsers[i].email);
                    $(modal).find('#shared-gesture-list').append(listItem);
                }
            } else {
                appendAlert($(modal).find('#invited-users'), ALERT_GESTURE_NOT_SHARED);
            }

            $(modal).find('#invited-users #input-email').unbind('keyup').bind('keyup', function (event) {
                event.preventDefault();
                clearAlerts($(modal).find('#invite-users-form'));
            });

            $(modal).find('#invited-users #btn-invite-user').unbind('click').bind('click', function (event) {
                event.preventDefault();
                var button = $(this);
                if (!$(button).hasClass('disabled')) {
                    lockButton(button, true, 'fa-paper-plane');

                    var email = $(modal).find('#invited-users #input-email');
                    if ($(email).val().trim() === '') {
                        appendAlert($(modal).find('#invited-users'), ALERT_MISSING_EMAIL);
                        unlockButton(button, true, 'fa-paper-plane');
                        $(email).focus();
                        return false;
                    }

                    // validate email
                    if (!validateEmail($(email).val().trim())) {
                        appendAlert($(modal).find('#invited-users'), ALERT_INVALID_EMAIL);
                        unlockButton(button, true, 'fa-paper-plane');
                        $(email).focus();
                        return false;
                    }

                    shareGestureForUser({gestureId: currentPreviewGesture.gesture.id, title: currentPreviewGesture.gesture.title, email: email.val().trim()}, function (result) {
                        unlockButton(button, true, 'fa-paper-plane');
                        if (result.status === RESULT_SUCCESS) {
                            updateGestureById(GESTURE_CATALOG, currentPreviewGesture.gesture.id, {invitedUsers: result.invitedUsers});
                            currentPreviewGesture.gesture = getGestureById(currentPreviewGesture.gesture.id);
                            originalFilterData = getLocalItem(GESTURE_SETS);
                            $(email).val('');
                            renderInvitedGestureUsers();
                            updateGestureThumbnailSharing(currentPreviewGesture.thumbnail, currentPreviewGesture.gesture);
                            updateSharingInfos();

//                        $(currentPreviewGesture.thumbnail).find('.btn-share .amount').text(inviteAmount > 0 ? inviteAmount : '');
//                        if (inviteAmount > 0) {
//                            $(currentPreviewGesture.thumbnail).find('.btn-share').addClass('gesture-shared');
//                        } else {
//                            $(currentPreviewGesture.thumbnail).find('.btn-share').removeClass('gesture-shared');
//                        }
                        } else if (result.status === 'userAlreadyInvited') {
                            $(email).val('');
                            appendAlert($(modal).find('#invite-users-form'), ALERT_USER_ALREADY_INVITED);
                        } else if (result.status === 'notInviteYourself') {
                            $(email).val('');
                            appendAlert($(modal).find('#invite-users-form'), ALERT_SHARE_GESTURE_TO_YOURSELF);
                        }
                    });
                }
            });

            $(modal).find('#gesture-sharing .btn-uninvite-user').unbind('click').bind('click', function (event) {
                event.preventDefault();
                var button = $(this);
                if (!$(button).hasClass('disabled')) {
                    lockButton(button, true, 'fa-trash');
                    unshareGestureForUser({gestureId: currentPreviewGesture.gesture.id, id: $(this).attr('data-invite-id'), title: currentPreviewGesture.gesture.title, email: $(this).attr('data-invite-mail')}, function (result) {
                        unlockButton(button, true, 'fa-trash');
                        if (result.status === RESULT_SUCCESS) {
                            updateGestureById(GESTURE_CATALOG, currentPreviewGesture.gesture.id, {invitedUsers: result.invitedUsers});
                            currentPreviewGesture.gesture = getGestureById(currentPreviewGesture.gesture.id);
                            originalFilterData = getLocalItem(GESTURE_CATALOG);
                            renderInvitedGestureUsers();
                            updateGestureThumbnailSharing(currentPreviewGesture.thumbnail, currentPreviewGesture.gesture);
                            renderGeneralGestureInfo();
                            updateSharingInfos();
                        }
                    });
                }
            });
        } else {
            $(modal).find('.share-with-all').remove();
            $(modal).find('#invited-users').remove();
        }
    }


</script>