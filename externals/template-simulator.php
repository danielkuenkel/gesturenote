<?php
include '../includes/language.php';
?>

<div id="template-study-container" class="hidden">

	<div class="panel panel-shadow panel-default deleteable" id="study-gesture-set-panel">
        <div class="panel-heading">
            <span class="panel-heading-text"></span>
            <div class="btn-group pull-right hole-set-control-buttons">
                <button class="btn btn-sm btn-default btn-shadow" id="btn-download-as-json" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsPidocoJSON ?>"><i class="fa fa-download"></i></button>
                <button class="btn btn-sm btn-default btn-shadow" id="btn-download-as-exchangeable" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsExchangeable ?>"><i class="fa fa-file-archive-o"></i></button>
                <button class="btn btn-sm btn-default btn-shadow" id="btn-show-hide-video" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showHideGestureVideo ?>"><i class="fa fa-compress"></i></button>
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
                <div class="btn-like-set update-list-view" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->likeGesture ?>"><i class="fa fa-heart-o"></i> <span class="amount"></span></div>
                <div class="btn-share-set" data-toggle="popover" data-trigger="hover" data-placement="auto" title="<?php echo $lang->gestureSharedWith ?>" data-content="<?php echo $lang->shareGesture ?>"><i class="fa fa-share-alt"></i> <span class="amount"></span></div>
                <div class="btn-comment-set" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->commentGesture ?>"><i class="fa fa-comment-o"></i> <span class="amount"></span></div>
                <div class="btn-show-set-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showAllGestureInfos ?>"><i class="fa fa-ellipsis-h"></i></div>
            </div>
        </div>
    </div>



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

</div>