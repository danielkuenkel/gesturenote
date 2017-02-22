<?php
include '../includes/language.php';
?>

<div id="template-gesture" class="hidden">

    <!-- gesture image thumbnail -->
    <img class="gestureImage" id="gestureThumbnailImage">


    <div class="" id="popover-gesture-preview" style="position: absolute; opacity: 0; width: 300px;">
        <div class="previewGesture"></div>
    </div>

    <div class="root hidden deleteable" id="gestures-catalog-thumbnail">
        <div class="panel panel-default btn-shadow">
            <div class="panel-heading" style=" text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">
                <span class="title-text ellipsis" style="position: relative; top: 1px;"></span>
            </div>

            <div class="panel-body">
                <div class="previewGesture"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
                <div class="text-center">
                    <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                    <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>
                </div>
            </div>
            <div class="panel-footer">
                <div class="btn-group btn-group-justified">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-info update-list-view" id="btn-share-gesture"><i class="fa" aria-hidden="true"></i> <span class="btn-text hidden-sm hidden-xs"></span></button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" id="btn-show-gesture-info">Mehr</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="root" id="classified-gestures-catalog-thumbnail">
        <div class="panel panel-default btn-shadow">
            <div class="panel-heading" style="text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">
                <span class="title-text ellipsis" style="position: relative; top: 1px;"></span>
            </div>

            <div class="panel-body">
                <div class="previewGesture"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
                <div class="text-center">
                    <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                    <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>
                </div>
            </div>
            <div class="panel-footer">
                <div class="btn-group btn-group-justified">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default btn-tag-as-main-gesture" id="btn-tag-as-main-gesture"><i class="fa fa-tag" aria-hidden="true"></i> <span class="btn-text hidden-sm hidden-xs hidden-lg"><?php echo $lang->rep ?></span><span class="btn-text hidden-md"><?php echo $lang->repShort ?></span></button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" id="btn-show-gesture-info"><span class="btn-text">Mehr</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="root" id="simple-gesture-thumbnail">
        <div class="panel panel-default btn-shadow">
            <div class="panel-heading" style="text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">
                <span class="title-text ellipsis" style="position: relative; top: 1px;"></span>
            </div>

            <div class="panel-body">
                <div class="previewGesture"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
                <div class="text-center">
                    <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                    <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>
                </div>
            </div>
        </div>
    </div>

    <div class="root" id="rudimentary-gesture-thumbnail">
        <div class="previewGesture btn-shadow mousePlayable"></div>
        <div class="text-center hidden gestureControls">
            <div class="btn-group">
                <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
            </div>
        </div>
    </div>
    
    <div class="root" id="exploration-gestures-catalog-thumbnail">
        <div class="panel panel-default btn-shadow">
            <div class="panel-heading" style="text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">
                <span class="title-text ellipsis" style="position: relative; top: 1px;"></span>
            </div>

            <div class="panel-body">
                <div class="previewGesture"></div>
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
        <div class="panel panel-default btn-shadow">
            <div class="panel-heading" style="text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">
                <span class="title-text ellipsis" style="position: relative; top: 1px;"></span>
            </div>

            <div class="panel-body">
                <div class="previewGesture"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
<!--                <div class="text-center">
                    <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text hidden-lg hiddel-md"></span></span>
                    <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text hidden-lg hiddel-md"></span></span>
                </div>-->
            </div>
            <div class="panel-footer">
                <div class="btn-group btn-group-justified">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default btn-tag-as-favorite-gesture" id="btn-tag-as-favorite-gesture"><i class="fa fa-star" aria-hidden="true"></i></button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" id="btn-show-gesture-info"><span class="btn-text">Mehr</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="root" id="study-gesture-catalog-thumbnail">
        <div class="panel panel-default btn-shadow">
            <div class="panel-heading" style="text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">
                <span class="title-text ellipsis" style="position: relative; top: 1px;"></span>
            </div>

            <div class="panel-body">
                <div class="previewGesture"></div>
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
                        <button type="button" class="btn btn-default" id="btn-show-gesture-info"><span class="btn-text">Mehr</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>