<?php
include '../includes/language.php';
?>

<div id="template-gesture" class="hidden">

    <div class="" id="popover-gesture-preview" style="position: absolute; opacity: 0; width: 300px;">
        <div class="previewGesture embed-responsive embed-responsive-4by3"></div>
    </div>


    <li id="attached-gesture-set-item" class="text">
        <span id="gesture-set-title"></span>
    </li>

    <div class="root deleteable" id="gestures-catalog-thumbnail">
        <div class="thumbnail gesture-thumbnail btn-shadow">
            <div class="">
                <div class="previewGesture embed-responsive embed-responsive-4by3"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
            </div>
            <div class="caption text-center">
                <p class="gesture-name ellipsis"></p>
                <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>
            </div>

            <div class="thumbnail-footer text-center">
                <div class="btn-rate" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->rateGesture ?>"><i class="fa fa-star-o"></i> <span class="amount"></span></div>
                <div class="btn-like update-list-view" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->likeGesture ?>"><i class="fa fa-heart-o"></i> <span class="amount"></span></div>
                <div class="btn-share update-list-view" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->shareGesture ?>"><i class="fa fa-share-alt"></i></div>
                <div class="btn-comment" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->commentGesture ?>"><i class="fa fa-comment-o"></i> <span class="amount"></span></div>
                <div class="btn-show-gesture-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showAllGestureInfos ?>"><i class="fa fa-ellipsis-h"></i></div>
            </div>
        </div>
    </div>

    <div class="root" id="classified-gestures-catalog-thumbnail">
        <div class="thumbnail gesture-thumbnail btn-shadow">
            <div class="">
                <div class="previewGesture embed-responsive embed-responsive-4by3"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
            </div>
            <div class="caption text-center">
                <p class="gesture-name ellipsis"></p>
                <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>
            </div>

            <div class="thumbnail-footer text-center">
                <div class="btn-tag-as-main-gesture" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tagAsMainGesture ?>"><i class="fa fa-tag"></i></div>
                <div class="btn-rate" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->rateGesture ?>"><i class="fa fa-star-o"></i> <span class="amount"></span></div>
                <div class="btn-like update-list-view" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->likeGesture ?>"><i class="fa fa-heart-o"></i> <span class="amount"></span></div>
                <div class="btn-share update-list-view" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->shareGesture ?>"><i class="fa fa-share-alt"></i></div>
                <div class="btn-comment" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->commentGesture ?>"><i class="fa fa-comment-o"></i> <span class="amount"></span></div>
                <div class="btn-show-gesture-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showAllGestureInfos ?>"><i class="fa fa-ellipsis-h"></i></div>
            </div>
        </div>
    </div>

    <div class="root" id="potential-gestures-catalog-thumbnail">
        <div class="thumbnail gesture-thumbnail btn-shadow">
            <div class="">
                <div class="previewGesture embed-responsive embed-responsive-4by3"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
            </div>
            <div class="caption text-center">
                <p class="gesture-name ellipsis"></p>
                <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>
            </div>

            <div class="thumbnail-footer text-center">
                <div class="btn-edit-gesture-set" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->addToGestureset ?>"><i class="fa fa-paperclip"></i></div>
                <div class="btn-rate" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->rateGesture ?>"><i class="fa fa-star-o"></i> <span class="amount"></span></div>
                <div class="btn-like update-list-view" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->likeGesture ?>"><i class="fa fa-heart-o"></i> <span class="amount"></span></div>
                <div class="btn-share update-list-view" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->shareGesture ?>"><i class="fa fa-share-alt"></i></div>
                <div class="btn-comment" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->commentGesture ?>"><i class="fa fa-comment-o"></i> <span class="amount"></span></div>
                <div class="btn-show-gesture-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showAllGestureInfos ?>"><i class="fa fa-ellipsis-h"></i></div>
            </div>
        </div>
    </div>

    <div class="root" id="simple-gesture-thumbnail">
        <div class="thumbnail gesture-thumbnail btn-shadow">
            <div class="">
                <div class="previewGesture embed-responsive embed-responsive-4by3"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
            </div>
            <div class="caption text-center" style="padding-bottom: 10px">
                <p class="gesture-name ellipsis"></p>
                <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>
            </div>
        </div>
    </div>

    <div class="root" id="rudimentary-gesture-thumbnail">
        <div class="thumbnail gesture-thumbnail btn-shadow">
            <div class="">
                <div class="previewGesture embed-responsive embed-responsive-4by3"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
            </div>
            <div class="caption text-center" style="padding-bottom: 10px">
                <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text hidden-xs"></span></span>
                <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text hidden-xs"></span></span>
            </div>
        </div>
    </div>

    <div class="root" id="exploration-gestures-catalog-thumbnail">
        <div class="panel panel-default btn-shadow">
            <div class="panel-heading" style="text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">
                <span class="title-text ellipsis" style="position: relative; top: 1px;"></span>
            </div>

            <div class="panel-body">
                <div class="previewGesture embed-responsive embed-responsive-4by3"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
                <!--                <div class="text-center">
                                    <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                                    <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>
                                </div>-->
            </div>
            <div class="panel-footer">
                <div class="btn-group btn-group-justified">
                    <!--                    <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-default btn-tag-as-main-gesture" id="btn-tag-as-main-gesture"><i class="fa fa-tag" aria-hidden="true"></i> <span class="btn-text hidden-sm hidden-xs hidden-lg"><?php echo $lang->rep ?></span><span class="btn-text hidden-md"><?php echo $lang->repShort ?></span></button>
                                        </div>-->
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" id="btn-show-gesture-info"><span class="btn-text">Mehr</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="root" id="favorite-gesture-catalog-thumbnail">
        <div class="thumbnail gesture-thumbnail btn-shadow">
            <div class="">
                <div class="previewGesture embed-responsive embed-responsive-4by3"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
            </div>
            <div class="caption text-center">
                <p class="gesture-name ellipsis"></p>
                <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>
            </div>

            <div class="thumbnail-footer text-center">
                <div class="btn-tag-as-favorite-gesture" data-toggle="popover"  data-trigger="hover" data-placement="auto" data-content="Zum Studien-Gesten-Set hinzufügen"><i class="fa fa-plus-square-o"></i></span></div>
                <div class="btn-show-gesture-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Alle Infos aufrufen"><i class="fa fa-ellipsis-h"></i></div>
            </div>
        </div>
    </div>

    <div class="root" id="study-gesture-catalog-thumbnail">
        <div class="panel panel-default btn-shadow">
            <div class="panel-heading" style="text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">
                <span class="title-text ellipsis" style="position: relative; top: 1px;"></span>
            </div>

            <div class="panel-body">
                <div class="previewGesture embed-responsive embed-responsive-4by3"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="btn-group btn-group-justified">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-danger btn-untag-as-favorite-gesture" id="btn-untag-as-favorite-gesture"><i class="fa fa-close" aria-hidden="true"></i></button>
                    </div>
                    <div class="btn-group" role="group">
                        <div class="btn-show-gesture-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Alle Infos aufrufen"><i class="fa fa-ellipsis-h"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="root" id="add-gesture-to-scene-thumbnail">
        <div class="thumbnail gesture-thumbnail btn-shadow">
            <div class="">
                <div class="previewGesture embed-responsive embed-responsive-4by3"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
            </div>
            <div class="caption text-center">
                <p class="gesture-name ellipsis"></p>
                <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>
            </div>

            <div class="thumbnail-footer text-center">

                <div class="btn-add-gesture-to-scene" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Zum Zustand hinzufügen"><i class="fa fa-plus-square-o"></i></span></div>
                <div class="btn-show-gesture-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Alle Infos aufrufen"><i class="fa fa-ellipsis-h"></i></div>
            </div>
        </div>

    </div>

    <div class="panel panel-default" id="create-study-gesture-set-panel">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow" id="btn-delete-gesture-set"><span class="fa fa-trash"></span></button>
            </div>
            <span class="panel-heading-text"></span>
            <button class="btn btn-default btn-shadow pull-right" id="btn-mark-hole-set"><i class="fa fa-plus"></i> <span class="btn-text">Alle Gesten zum Studien-Gesten-Set hinzufügen</span></button>
            <button class="btn btn-default btn-shadow pull-right hidden" id="btn-unmark-hole-set"><i class="fa fa-minus"></i> <span class="btn-text">Alle Gesten vom Studien-Gesten-Set entfernen</span></button>
            <div style="clear: both"></div>
        </div>

        <div class="panel-body" id="item-view" style="padding-bottom: 0px">
            <div class="alert-space alert-empty-gesture-set"></div>
            <div class="row" id="gestures-list-container">

            </div>
        </div>
    </div>

    <div class="panel panel-default" id="study-gesture-set-panel">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow" id="btn-delete-gesture-set"><span class="fa fa-trash"></span></button>
            </div>
            <span class="panel-heading-text"></span>
        </div>

        <div class="panel-body" id="item-view" style="padding-bottom: 0px">
            <div class="alert-space alert-empty-gesture-set"></div>
            <div class="row" id="gestures-list-container">

            </div>
        </div>
    </div>

</div>