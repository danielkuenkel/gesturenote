<?php
include '../includes/language.php';
?>

<div id="template-gesture" class="hidden">

    <div class="" id="popover-gesture-preview" style="position: absolute; opacity: 0; width: 200px;">
        <div class="previewGesture embed-responsive embed-responsive-4by3"></div>
    </div>


    <li id="attached-gesture-set-item" class="text">
        <span id="gesture-set-title"></span>
    </li>

    <div class="root deleteable" id="gestures-catalog-thumbnail">
        <div class="thumbnail gesture-thumbnail btn-gesture-shadow">
            <div class="embed-responsive embed-responsive-4by3">
                <div class="previewGesture"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                        <button type="button" class="btn btn-default btn-step-backward-gesture"><i class="fa fa-backward"></i></button>
                        <button type="button" class="btn btn-default btn-step-forward-gesture"><i class="fa fa-forward"></i></button>
                    </div>
                </div>
                <div class="gesture-info-symbols">
                    <span class="symbol-container-sensor hidden" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="" style="display: flex; cursor: pointer; margin-right: 6px;">
                        <span class="gesture-info-symbol-text text-sensor">
                            <span class="text-sensor-leap hidden"><?php echo $lang->sensors->leap->titleShort ?></span>
                            <span class="text-sensor-kinect hidden"><?php echo $lang->sensors->kinect->titleShort ?></span>
                        </span>
                    </span>
                    <span class="symbol-container-gesture-execution" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-execution"></span>
                        <div class="gesture-info-symbol symbol-gesture-execution"></div>
                    </span>
                    <span class="symbol-container-gesture-interaction" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-interaction"></span>
                        <div class="gesture-info-symbol symbol-gesture-interaction"></div>
                    </span>
                </div>
            </div>
            <div class="caption text-center">
                <p class="gesture-name ellipsis" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""></p>
<!--                <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>-->
            </div>

            <div class="thumbnail-footer text-center">
                <div class="btn-rate" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->rateGesture ?>"><i class="fa fa-star-o"></i> <span class="amount"></span></div>
                <div class="btn-like update-list-view" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->likeGesture ?>"><i class="fa fa-heart-o"></i> <span class="amount"></span></div>
                <div class="btn-share update-list-view" data-toggle="popover" data-trigger="hover" data-placement="auto" title="<?php echo $lang->gestureSharedWith ?>" data-content="<?php echo $lang->shareGesture ?>"><i class="fa fa-share-alt"></i> <span class="amount"></span></div>
                <div class="btn-edit-gesture-set" data-toggle="popover" data-trigger="hover" data-placement="auto" title="<?php echo $lang->assignmentToGestureSets ?>" data-content=""><i class="fa fa-paperclip"></i> <span class="amount"></span></div>
                <div class="btn-comment" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->commentGesture ?>"><i class="fa fa-comment-o"></i> <span class="amount"></span></div>
                <div class="btn-show-gesture-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showAllGestureInfos ?>"><i class="fa fa-ellipsis-h"></i></div>
            </div>
        </div>
    </div>

    <div class="root deleteable" id="gesture-set-thumbnail">
        <div class="thumbnail gesture-thumbnail btn-gesture-shadow">
            <div class="embed-responsive embed-responsive-4by3">
                <div class="previewGesture"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                        <button type="button" class="btn btn-default btn-step-backward-gesture"><i class="fa fa-backward"></i></button>
                        <button type="button" class="btn btn-default btn-step-forward-gesture"><i class="fa fa-forward"></i></button>
                    </div>
                </div>
                <div class="gesture-info-symbols">
                    <span class="symbol-container-sensor hidden" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="" style="display: flex; cursor: pointer; margin-right: 6px;">
                        <span class="gesture-info-symbol-text text-sensor">
                            <span class="text-sensor-leap hidden"><?php echo $lang->sensors->leap->titleShort ?></span>
                            <span class="text-sensor-kinect hidden"><?php echo $lang->sensors->kinect->titleShort ?></span>
                        </span>
                    </span>
                    <span class="symbol-container-gesture-execution" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-execution"></span>
                        <div class="gesture-info-symbol symbol-gesture-execution"></div>
                    </span>
                    <span class="symbol-container-gesture-interaction" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-interaction"></span>
                        <div class="gesture-info-symbol symbol-gesture-interaction"></div>
                    </span>
                </div>
            </div>
            <div class="caption text-center">
                <p class="gesture-name ellipsis" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""></p>
            </div>

            <div class="thumbnail-footer text-center">
                <div class="btn-delete-gesture-from-set" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->deleteGestureFromSet ?>" data-content=""><i class="fa fa-trash"></i></div>
                <div class="btn-rate" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->rateGesture ?>"><i class="fa fa-star-o"></i> <span class="amount"></span></div>
                <div class="btn-like update-list-view" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->likeGesture ?>"><i class="fa fa-heart-o"></i> <span class="amount"></span></div>
                <div class="btn-share update-list-view" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->shareGesture ?>"><i class="fa fa-share-alt"></i></div>
                <div class="btn-comment" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->commentGesture ?>"><i class="fa fa-comment-o"></i> <span class="amount"></span></div>
                <div class="btn-show-gesture-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showAllGestureInfos ?>"><i class="fa fa-ellipsis-h"></i></div>
            </div>
        </div>
    </div>

    <div class="root" id="classified-gestures-catalog-thumbnail">
        <div class="thumbnail gesture-thumbnail btn-gesture-shadow">
            <div class="embed-responsive embed-responsive-4by3">
                <div class="previewGesture"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                        <button type="button" class="btn btn-default btn-step-backward-gesture"><i class="fa fa-backward"></i></button>
                        <button type="button" class="btn btn-default btn-step-forward-gesture"><i class="fa fa-forward"></i></button>
                    </div>
                </div>
                <div class="weighting-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->extractionContent->weightingInfo ?>" style="display: flex; position: absolute; padding: 4px 7px; background-color: rgba(255,255,255,1); border-bottom-right-radius: 10px; border-top-left-radius: 6px; font-size: 8pt;">
                    <div class="weighting-text"></div>
                </div>
                <div class="gesture-info-symbols">
                    <span class="symbol-container-sensor hidden" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="" style="display: flex; cursor: pointer; margin-right: 6px;">
                        <span class="gesture-info-symbol-text text-sensor">
                            <span class="text-sensor-leap hidden"><?php echo $lang->sensors->leap->titleShort ?></span>
                            <span class="text-sensor-kinect hidden"><?php echo $lang->sensors->kinect->titleShort ?></span>
                        </span>
                    </span>
                    <span class="symbol-container-gesture-execution" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-execution"></span>
                        <div class="gesture-info-symbol symbol-gesture-execution"></div>
                    </span>
                    <span class="symbol-container-gesture-interaction" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-interaction"></span>
                        <div class="gesture-info-symbol symbol-gesture-interaction"></div>
                    </span>
<!--                    <span class="symbol-container-gesture-sets" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-sets-info-symbol-text">SETS</span>
                    </span>-->
                </div>
            </div>
            <div class="caption text-center">
                <p class="gesture-name ellipsis" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""></p>
<!--                <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>-->
            </div>

            <div class="thumbnail-footer text-center">
                <div class="btn-tag-as-main-gesture" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tagAsMainGesture ?>"><i class="fa fa-tag"></i></div>
                <div class="btn-delete-from-classification" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->deleteFromClassification ?>"><i class="fa fa-trash"></i></div>
                <!--<div class="btn-rate" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->rateGesture ?>"><i class="fa fa-star-o"></i> <span class="amount"></span></div>-->
                <!--<div class="btn-like update-list-view" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->likeGesture ?>"><i class="fa fa-heart-o"></i> <span class="amount"></span></div>-->
                <!--<div class="btn-share update-list-view" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->shareGesture ?>"><i class="fa fa-share-alt"></i></div>-->
                <!--<div class="btn-comment" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->commentGesture ?>"><i class="fa fa-comment-o"></i> <span class="amount"></span></div>-->
                <div class="btn-edit-gesture-set" data-toggle="popover" data-trigger="hover" data-placement="auto" title="<?php echo $lang->assignmentToGestureSets ?>" data-content=""><i class="fa fa-paperclip"></i> <span class="amount"></span></div>
                <div class="btn-show-gesture-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showAllGestureInfos ?>"><i class="fa fa-ellipsis-h"></i></div>
            </div>
        </div>
    </div>

    <div class="root" id="potential-gestures-catalog-thumbnail">
        <div class="thumbnail gesture-thumbnail btn-gesture-shadow">
            <div class="embed-responsive embed-responsive-4by3">
                <div class="previewGesture"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                        <button type="button" class="btn btn-default btn-step-backward-gesture"><i class="fa fa-backward"></i></button>
                        <button type="button" class="btn btn-default btn-step-forward-gesture"><i class="fa fa-forward"></i></button>
                    </div>
                </div>
                <div class="weighting-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->extractionContent->weightingInfo ?>" style="display: flex; position: absolute; padding: 4px 7px; background-color: rgba(255,255,255,1); border-bottom-right-radius: 10px; border-top-left-radius: 6px; font-size: 8pt;">
                    <div class="weighting-text"></div>
                </div>
                <div class="gesture-info-symbols">
                    <span class="symbol-container-sensor hidden" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="" style="display: flex; cursor: pointer; margin-right: 6px;">
                        <span class="gesture-info-symbol-text text-sensor">
                            <span class="text-sensor-leap hidden"><?php echo $lang->sensors->leap->titleShort ?></span>
                            <span class="text-sensor-kinect hidden"><?php echo $lang->sensors->kinect->titleShort ?></span>
                        </span>
                    </span>
                    <span class="symbol-container-gesture-execution" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-execution"></span>
                        <div class="gesture-info-symbol symbol-gesture-execution"></div>
                    </span>
                    <span class="symbol-container-gesture-interaction" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-interaction"></span>
                        <div class="gesture-info-symbol symbol-gesture-interaction"></div>
                    </span>
<!--                    <span class="symbol-container-gesture-sets" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-sets-info-symbol-text">SETS</span>
                    </span>-->
                </div>
            </div>
            <div class="caption text-center">
                <p class="gesture-name ellipsis" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""></p>
<!--                <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>-->
            </div>

            <div class="thumbnail-footer text-center">
                <div class="btn-rate" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->rateGesture ?>"><i class="fa fa-star-o"></i> <span class="amount"></span></div>
                <div class="btn-like update-list-view" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->likeGesture ?>"><i class="fa fa-heart-o"></i> <span class="amount"></span></div>
                <div class="btn-share update-list-view" data-toggle="popover" data-trigger="hover" data-placement="auto" title="<?php echo $lang->gestureSharedWith ?>" data-content="<?php echo $lang->shareGesture ?>"><i class="fa fa-share-alt"></i></div>
                <div class="btn-edit-gesture-set" data-toggle="popover" data-trigger="hover" data-placement="auto" title="<?php echo $lang->assignmentToGestureSets ?>" data-content=""><i class="fa fa-paperclip"></i> <span class="amount"></span></div>
                <div class="btn-comment" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->commentGesture ?>"><i class="fa fa-comment-o"></i> <span class="amount"></span></div>
                <div class="btn-show-gesture-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showAllGestureInfos ?>"><i class="fa fa-ellipsis-h"></i></div>
            </div>
        </div>
    </div>

    <div class="root" id="simple-gesture-thumbnail">
        <div class="thumbnail gesture-thumbnail btn-gesture-shadow">
            <div class="embed-responsive embed-responsive-4by3">
                <div class="previewGesture"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                        <button type="button" class="btn btn-default btn-step-backward-gesture"><i class="fa fa-backward"></i></button>
                        <button type="button" class="btn btn-default btn-step-forward-gesture"><i class="fa fa-forward"></i></button>
                    </div>
                </div>
                <div class="gesture-info-symbols">
                    <span class="symbol-container-sensor hidden" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="" style="display: flex; cursor: pointer; margin-right: 6px;">
                        <span class="gesture-info-symbol-text text-sensor">
                            <span class="text-sensor-leap hidden"><?php echo $lang->sensors->leap->titleShort ?></span>
                            <span class="text-sensor-kinect hidden"><?php echo $lang->sensors->kinect->titleShort ?></span>
                        </span>
                    </span>
                    <span class="symbol-container-gesture-execution" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-execution"></span>
                        <div class="gesture-info-symbol symbol-gesture-execution"></div>
                    </span>
                    <span class="symbol-container-gesture-interaction" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-interaction"></span>
                        <div class="gesture-info-symbol symbol-gesture-interaction"></div>
                    </span>
                </div>
            </div>
            <div class="caption text-center" style="padding-bottom: 10px">
                <p class="gesture-name ellipsis" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""></p>
<!--                <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>-->
            </div>
        </div>
    </div>

    <div class="root" id="exchangeable-gesture-thumbnail">
        <div class="thumbnail gesture-thumbnail btn-gesture-shadow">
            <div class="embed-responsive embed-responsive-4by3">
                <div class="previewGesture"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                        <button type="button" class="btn btn-default btn-step-backward-gesture"><i class="fa fa-backward"></i></button>
                        <button type="button" class="btn btn-default btn-step-forward-gesture"><i class="fa fa-forward"></i></button>
                    </div>
                </div>
                <div class="gesture-info-symbols">
                    <span class="symbol-container-sensor hidden" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="" style="display: flex; cursor: pointer; margin-right: 6px;">
                        <span class="gesture-info-symbol-text text-sensor">
                            <span class="text-sensor-leap hidden"><?php echo $lang->sensors->leap->titleShort ?></span>
                            <span class="text-sensor-kinect hidden"><?php echo $lang->sensors->kinect->titleShort ?></span>
                        </span>
                    </span>
                    <span class="symbol-container-gesture-execution" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-execution"></span>
                        <div class="gesture-info-symbol symbol-gesture-execution"></div>
                    </span>
                    <span class="symbol-container-gesture-interaction" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-interaction"></span>
                        <div class="gesture-info-symbol symbol-gesture-interaction"></div>
                    </span>
                </div>
            </div>
            <div class="caption text-center" style="">
                <p class="gesture-name ellipsis" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""></p>
            </div>
            <div class="thumbnail-footer text-center">
                <div class="btn-delete-exchangeable-gesture" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->deleteExchangeableGesture ?>"><i class="fa fa-trash"></i></div>
            </div>
        </div>
    </div>

    <div class="root " id="rudimentary-gesture-thumbnail">
        <div class="gesture-thumbnail btn-gesture-shadow">
            <div class="embed-responsive embed-responsive-4by3">
                <div class="previewGesture"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                        <button type="button" class="btn btn-default btn-step-backward-gesture"><i class="fa fa-backward"></i></button>
                        <button type="button" class="btn btn-default btn-step-forward-gesture"><i class="fa fa-forward"></i></button>
                    </div>
                </div>
            </div>
            <!--<div class="caption text-center" style="padding-bottom: 10px">-->
<!--                <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text hidden-xs"></span></span>
                <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text hidden-xs"></span></span>-->
            <!--</div>-->
        </div>
    </div>

    <!--    <div class="root" id="exploration-gestures-catalog-thumbnail">
            <div class="panel panel-default btn-gesture-shadow">
                <div class="panel-heading" style="text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">
                    <span class="title-text ellipsis" style="position: relative; top: 1px;"></span>
                </div>
    
                <div class="panel-body">
                    <div class="embed-responsive embed-responsive-4by3">
                        <div class="previewGesture"></div>
                        <div class="text-center hidden gestureControls">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                                <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                                <button type="button" class="btn btn-default btn-step-backward-gesture"><i class="fa fa-backward"></i></button>
                                <button type="button" class="btn btn-default btn-step-forward-gesture"><i class="fa fa-forward"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="btn-group btn-group-justified">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" id="btn-show-gesture-info"><span class="btn-text">Mehr</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->

    <div class="root" id="favorite-gesture-catalog-thumbnail">
        <div class="thumbnail gesture-thumbnail btn-gesture-shadow">
            <div class="embed-responsive embed-responsive-4by3">
                <div class="previewGesture"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                        <button type="button" class="btn btn-default btn-step-backward-gesture"><i class="fa fa-backward"></i></button>
                        <button type="button" class="btn btn-default btn-step-forward-gesture"><i class="fa fa-forward"></i></button>
                    </div>
                </div>
                <div class="tagged-symbol hidden" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                    <i class="fa fa-asterisk"></i>
                </div>
                <div class="gesture-info-symbols">
                    <span class="symbol-container-sensor hidden" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="" style="display: flex; cursor: pointer; margin-right: 6px;">
                        <span class="gesture-info-symbol-text text-sensor">
                            <span class="text-sensor-leap hidden"><?php echo $lang->sensors->leap->titleShort ?></span>
                            <span class="text-sensor-kinect hidden"><?php echo $lang->sensors->kinect->titleShort ?></span>
                        </span>
                    </span>
                    <span class="symbol-container-gesture-execution" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-execution"></span>
                        <div class="gesture-info-symbol symbol-gesture-execution"></div>
                    </span>
                    <span class="symbol-container-gesture-interaction" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-interaction"></span>
                        <div class="gesture-info-symbol symbol-gesture-interaction"></div>
                    </span>
<!--                    <span class="symbol-container-gesture-sets" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-sets-info-symbol-text">SETS</span>
                    </span>-->
                </div>
            </div>
            <div class="caption text-center">
                <p class="gesture-name ellipsis" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""></p>
                <!--<span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text hidden-xs"></span></span>-->
                <!--<span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text hidden-xs"></span></span>-->
            </div>
            <div class="thumbnail-footer text-center">
                <div class="btn-tag-as-favorite-gesture" data-toggle="popover"  data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->addToStudyGestureSet ?>"><i class="fa fa-plus-square"></i></span></div>
                <div class="btn-edit-gesture-set" data-toggle="popover" data-trigger="hover" data-placement="auto" title="<?php echo $lang->assignmentToGestureSets ?>" data-content=""><i class="fa fa-paperclip"></i> <span class="amount"></span></div>
                <div class="btn-show-gesture-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showAllGestureInfos ?>"><i class="fa fa-ellipsis-h"></i></div>
            </div>
        </div>
    </div>

    <div class="root" id="mapping-gesture-catalog-thumbnail">
        <div class="thumbnail gesture-thumbnail btn-gesture-shadow">
            <div class="embed-responsive embed-responsive-4by3">
                <div class="previewGesture"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                        <button type="button" class="btn btn-default btn-step-backward-gesture"><i class="fa fa-backward"></i></button>
                        <button type="button" class="btn btn-default btn-step-forward-gesture"><i class="fa fa-forward"></i></button>
                    </div>
                </div>
                <div class="tagged-symbol hidden" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                    <i class="fa fa-asterisk"></i>
                </div>
                <div class="gesture-info-symbols">
                    <span class="symbol-container-sensor hidden" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="" style="display: flex; cursor: pointer; margin-right: 6px;">
                        <span class="gesture-info-symbol-text text-sensor">
                            <span class="text-sensor-leap hidden"><?php echo $lang->sensors->leap->titleShort ?></span>
                            <span class="text-sensor-kinect hidden"><?php echo $lang->sensors->kinect->titleShort ?></span>
                        </span>
                    </span>
                    <span class="symbol-container-gesture-execution" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-execution"></span>
                        <div class="gesture-info-symbol symbol-gesture-execution"></div>
                    </span>
                    <span class="symbol-container-gesture-interaction" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-interaction"></span>
                        <div class="gesture-info-symbol symbol-gesture-interaction"></div>
                    </span>
                </div>
            </div>
            <div class="caption text-center">
                <p class="gesture-name ellipsis" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""></p>
            </div>
            <div class="thumbnail-footer text-center">
                <div class="btn-tag-as-mapping-gesture" data-toggle="popover"  data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->addToMapping ?>"><i class="fa fa-plus-square"></i></span></div>
                <div class="btn-edit-gesture-set" data-toggle="popover" data-trigger="hover" data-placement="auto" title="<?php echo $lang->assignmentToGestureSets ?>" data-content=""><i class="fa fa-paperclip"></i> <span class="amount"></span></div>
                <div class="btn-show-gesture-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showAllGestureInfos ?>"><i class="fa fa-ellipsis-h"></i></div>
            </div>
        </div>
    </div>

    <!--    <div class="root" id="study-gesture-catalog-thumbnail">
            <div class="panel panel-default btn-gesture-shadow">
                <div class="panel-heading" style="text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">
                    <span class="title-text ellipsis" style="position: relative; top: 1px;"></span>
                </div>
    
                <div class="panel-body">
                    <div class="previewGesture embed-responsive embed-responsive-4by3"></div>
                    <div class="text-center hidden gestureControls">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                            <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                            <button type="button" class="btn btn-default btn-step-backward-gesture"><i class="fa fa-backward"></i></button>
                            <button type="button" class="btn btn-default btn-step-forward-gesture"><i class="fa fa-forward"></i></button>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="btn-group btn-group-justified">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-untag-as-favorite-gesture" id="btn-untag-as-favorite-gesture"><i class="fa fa-close" aria-hidden="true"></i></button>
                        </div>
                        <div class="btn-group" role="group">
                            <div class="btn-show-gesture-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showAllGestureInfos ?>"><i class="fa fa-ellipsis-h"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->


    <div class="root" id="add-gesture-to-scene-thumbnail">
        <div class="thumbnail gesture-thumbnail btn-gesture-shadow">
            <div class="embed-responsive embed-responsive-4by3">
                <div class="previewGesture"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                        <button type="button" class="btn btn-default btn-step-backward-gesture"><i class="fa fa-backward"></i></button>
                        <button type="button" class="btn btn-default btn-step-forward-gesture"><i class="fa fa-forward"></i></button>
                    </div>
                </div>
                <div class="tagged-symbol hidden">
                    <i class="fa fa-asterisk"></i>
                </div>
                <div class="gesture-info-symbols">
                    <span class="symbol-container-sensor hidden" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="" style="display: flex; cursor: pointer; margin-right: 6px;">
                        <span class="gesture-info-symbol-text text-sensor">
                            <span class="text-sensor-leap hidden"><?php echo $lang->sensors->leap->titleShort ?></span>
                            <span class="text-sensor-kinect hidden"><?php echo $lang->sensors->kinect->titleShort ?></span>
                        </span>
                    </span>
                    <span class="symbol-container-gesture-execution" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-execution"></span>
                        <div class="gesture-info-symbol symbol-gesture-execution"></div>
                    </span>
                    <span class="symbol-container-gesture-interaction" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-info-symbol-text text-gesture-interaction"></span>
                        <div class="gesture-info-symbol symbol-gesture-interaction"></div>
                    </span>
<!--                    <span class="symbol-container-gesture-sets" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="">
                        <span class="gesture-sets-info-symbol-text">SETS</span>
                    </span>-->
                </div>
            </div>
            <div class="caption text-center">
                <p class="gesture-name ellipsis" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""></p>
                <!--<span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>-->
                <!--<span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>-->
            </div>

            <div class="thumbnail-footer text-center">
                <div class="btn-add-gesture-to-scene" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->addToTrigger ?>"><i class="fa fa-plus-square"></i></span></div>
                <div class="btn-edit-gesture-set" data-toggle="popover" data-trigger="hover" data-placement="auto" title="<?php echo $lang->assignmentToGestureSets ?>" data-content=""><i class="fa fa-paperclip"></i> <span class="amount"></span></div>
                <div class="btn-show-gesture-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showAllGestureInfos ?>"><i class="fa fa-ellipsis-h"></i></div>
            </div>
        </div>

    </div>

    <div class="panel panel-default panel-shadow" id="create-study-gesture-set-panel">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-sm btn-default btn-shadow" id="btn-delete-gesture-set" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->deleteGestureSet ?>"><span class="fa fa-trash"></span></button>
            </div>
            <span class="panel-heading-text"></span>
            <div class="btn-group pull-right hole-set-control-buttons">
                <button class="btn btn-sm btn-default btn-shadow" id="btn-mark-hole-set" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->addAllGesturesToStudyGestureSet ?>"><i class="fa fa-plus-square"></i></button>
                <button class="btn btn-sm btn-default btn-shadow" id="btn-download-as-json" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsPidocoJSON ?>"><i class="fa fa-download"></i></button>
                <button class="btn btn-sm btn-default btn-shadow" id="btn-download-as-exchangeable" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsExchangeable ?>"><i class="fa fa-file-archive-o"></i></button>
            </div>
            <div style="clear: both"></div>
        </div>

        <div class="panel-body" id="item-view" style="padding-bottom: 0px">
            <div class="alert-space alert-empty-gesture-set"></div>
            <div class="alert-space alert-set-missing-gestures"></div>
            <div class="row" id="gestures-list-container">

            </div>
        </div>

        <div class="panel-footer panel-footer-gesture-set">
            <div class="gesture-set-footer-controls text-center">
                <!--<div class="btn-rate" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->rateGesture ?>"><i class="fa fa-star-o"></i> <span class="amount"></span></div>-->
                <div class="btn-like-set update-list-view" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->likeGesture ?>"><i class="fa fa-heart-o"></i> <span class="amount"></span></div>
                <div class="btn-share-set" data-toggle="popover" data-trigger="hover" data-placement="auto" title="<?php echo $lang->gestureSetSharedWith ?>" data-content="<?php echo $lang->shareGesture ?>"><i class="fa fa-share-alt"></i> <span class="amount"></span></div>
                <div class="btn-comment-set" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->commentGesture ?>"><i class="fa fa-comment-o"></i> <span class="amount"></span></div>
                <div class="btn-show-set-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showAllGestureInfos ?>"><i class="fa fa-ellipsis-h"></i></div>
            </div>
        </div>
    </div>

    <div class="panel panel-shadow panel-default deleteable" id="study-gesture-set-panel">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-sm btn-default btn-shadow" id="btn-delete-gesture-set" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->deleteGestureSet ?>"><span class="fa fa-trash"></span></button>
            </div>
            <span class="panel-heading-text"></span>
            <div class="btn-group pull-right hole-set-control-buttons">
                <button class="btn btn-sm btn-default btn-shadow" id="btn-download-as-json" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsPidocoJSON ?>"><i class="fa fa-download"></i></button>
                <button class="btn btn-sm btn-default btn-shadow" id="btn-download-as-exchangeable" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsExchangeable ?>"><i class="fa fa-file-archive-o"></i></button>
                <button class="btn btn-sm btn-default btn-shadow" id="btn-simulate-gesture-set" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->simulatorGestureSet ?>"><i class="fa fa-sign-language"></i></button>
            </div>
            <div style="clear: both"></div>
        </div>

        <div class="panel-body" id="item-view" style="padding-bottom: 0px">
            <div class="alert-space alert-empty-gesture-set"></div>
            <div class="alert-space alert-set-missing-gestures"></div>
            <div class="row" id="gestures-list-container">

            </div>
        </div>
        <div class="panel-footer panel-footer-gesture-set">
            <div class="gesture-set-footer-controls text-center">
                <!--<div class="btn-rate" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->rateGesture ?>"><i class="fa fa-star-o"></i> <span class="amount"></span></div>-->
                <div class="btn-like-set update-list-view" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->likeGesture ?>"><i class="fa fa-heart-o"></i> <span class="amount"></span></div>
                <div class="btn-share-set" data-toggle="popover" data-trigger="hover" data-placement="auto" title="<?php echo $lang->gestureSharedWith ?>" data-content="<?php echo $lang->shareGesture ?>"><i class="fa fa-share-alt"></i> <span class="amount"></span></div>
                <div class="btn-comment-set" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->commentGesture ?>"><i class="fa fa-comment-o"></i> <span class="amount"></span></div>
                <div class="btn-show-set-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showAllGestureInfos ?>"><i class="fa fa-ellipsis-h"></i></div>
            </div>
        </div>
    </div>

    <div class="root" id="gesture-importer-template">
        <div class="row">
            <div class="col-sm-4 col-md-3">
                <button class="btn btn-default btn-shadow chooseExchangeableFile"><i class="btn-icon fa fa-file-o"></i> <span class="btn-text"><?php echo $lang->chooseExchangeableFile ?></span></button>

                <form enctype="multipart/form-data" id="upload-exchangeable-form" class="hidden">
                    <input class="exchangeableFileUpload hidden" name="exchangeableFile" type="file" accept="application/x-zip-compressed" />
                </form>
            </div>
            <div class="col-sm-8 col-md-9 file-info">
                <div class="info-file-name"><span>Name:</span> <span class="text">-</span></div>
                <div class="info-file-size"><span>Größe:</span> <span class="text">-</span></div>
                <div class="info-file-last-modified"><span>Modifiziert:</span> <span class="text">-</span></div>
                <div class="info-gestures-count"><span>Anzahl Gesten:</span> <span class="text">-</span></div>
            </div>

        </div>

        <hr>

        <div class="alert-space alert-general-error"></div>
        <div class="alert-space alert-no-exchangeable-file-selected"></div>
        <div class="alert-space alert-exchangeable-gestures-imported-success"></div>
        <div id="item-view" class="row">

        </div>

        <hr>


        <div class="row">
            <div class="col-sm-4 col-md-3">
                <div class="form-group root createExchangeableGestureSet">
                    <label style="margin: 0">
                        <?php echo $lang->createNewGestureSet ?>? 
                        <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->physicalStressTestSingleGraphic ?>"></i>
                    </label><br>

                    <div class="btn-group" id="radio" style="">
                        <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="yes">
                            <span id="icons" style="margin-right: 6px">
                                <i class="fa fa-circle-thin hidden" id="normal"></i>
                                <i class="fa fa-circle hidden" id="over"></i>
                                <i class="fa fa-check-circle" id="checked"></i>
                            </span>
                            <span class="option-text"><?php echo $lang->yes ?></span>
                        </button>
                    </div>
                    <div class="btn-group" id="radio" style="">
                        <button class="btn btn-default btn-radio" name="primary" id="no">
                            <span id="icons" style="margin-right: 6px">
                                <i class="fa fa-circle-thin" id="normal"></i>
                                <i class="fa fa-circle hidden" id="over"></i>
                                <i class="fa fa-check-circle hidden" id="checked"></i>
                            </span>
                            <span class="option-text"><?php echo $lang->no ?></span>
                        </button>
                    </div>

                </div>
            </div>
            <div class="col-sm-8 col-md-9">
                <div class="form-group exchangeableGestureSetTitle">
                    <label class="text"><?php echo $lang->name ?></label>

                    <div class="alert-space alert-gesture-set-title-too-short"></div>

                    <!--<div class="input-group">-->
                    <input type="text" class="form-control" id="input-exchangeable-set-title" minlength="8" maxlength="60" placeholder="<?php echo $lang->createNewGestureSetPlaceholder ?>">
    <!--                <span class="input-group-btn">
                        <button class="btn btn-info btn-add-gesture-set" type="button" id="btn-add-gesture-set"><i class="fa fa-plus"></i></button>
                    </span>-->
                    <!--</div>-->
                </div>
            </div>


        </div>



        <button class="btn btn-default btn-shadow disabled btn-import-exchangeable-gestures"><i class="btn-icon fa fa-cloud-upload"></i> <span class="btn-text"><?php echo $lang->importExchangeableFile ?></span></button>

        <div id="temp-image-container" class="hidden"></div>
    </div>

    <div id="shared-gesture-set-list-item" class="shared-list-item"><span class="shared-gesture-set-item-email text"></span> <span class="btn-uninvite-user"><i class="fa fa-trash"></i> <?php echo $lang->delete ?></span></div>
    <div id="shared-gesture-list-item" class="shared-list-item"><span class="shared-gesture-item-email text"></span> <span class="btn-uninvite-user"><i class="fa fa-trash"></i> <?php echo $lang->delete ?></span></div>

</div>