<?php
include '../includes/language.php';
?>

<div id="template-study-container" class="hidden">

    <div class="panel panel-shadow panel-default deleteable" id="study-gesture-set-panel">
        <div class="panel-heading">
            <span class="panel-heading-text"></span>
            <div class="btn-group pull-right hole-set-control-buttons">
                <button class="btn btn-sm btn-default btn-shadow" id="btn-download-as-json" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsPidocoJSON ?>"><i class="fa fa-download"></i></button>
<!--                 <button class="btn btn-sm btn-default btn-shadow" id="btn-download-as-exchangeable" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsExchangeable ?>"><i class="fa fa-file-archive-o"></i></button>-->
                <button class="btn btn-sm btn-default btn-shadow" id="btn-show-hide-video" data-preview-present="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showHideGestureVideo ?>"><i class="fa fa-compress"></i></button>
            </div>
            <div style="clear: both"></div>
        </div>

        <div class="panel-body" id="item-view" style="padding-bottom: 0px">
            <div class="alert-space alert-empty-gesture-set"></div>
            <div class="alert-space alert-set-missing-gestures"></div>
            <div class="row" id="gestures-list-container">

            </div>
        </div>
    </div>



    <div class="root deleteable" id="gestures-catalog-thumbnail">
        <div class="thumbnail gesture-thumbnail btn-gesture-shadow">
            <div class="gesture-preview-data">
                <div class="embed-responsive embed-responsive-4by3" style="">
                    <div class="previewGesture"></div>
                    <div class="text-center hidden gestureControls">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                            <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                            <button type="button" class="btn btn-default btn-step-backward-gesture"><i class="fa fa-backward"></i></button>
                            <button type="button" class="btn btn-default btn-step-forward-gesture"><i class="fa fa-forward"></i></button>
                        </div>
                    </div>
                    <div class="continuous-gesture-controls hidden" style="">
                        <div class="control-continuous-slider-status">50%</div>
                        <!--<div class="btn-invert-slider-values" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->execution->valuesNotInverted ?>"><i class="fa fa-exchange"></i></div>-->
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
                <!--<div class="" >-->
                <div class="col-xs-12" style="margin-top: 15px">
                    <div id="control-continuous-slider" class="hidden" style="margin-top: -7px; margin-bottom: 18px;">
                        <input id="continuous-slider" style="width: 100%; height: 34px;" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="50" data-slider-tooltip="hide" />
                    </div>
                    <div class="btn-group btn-group-justified hidden static-continuous-controls " role="group" aria-label="...">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default btn-shadow btn-start-static-continuous-gesture"><i class="fa fa-play"></i></button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default btn-shadow disabled btn-stop-static-continuous-gesture"><i class="fa fa-stop"></i></button>
                        </div>
                    </div>
                    <div class="btn-group btn-group-justified simulator-trigger text-center hidden">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-shadow" id="btn-trigger-gesture" style="border-radius: 8px;">
                                <i class="fa fa-hand-o-up" aria-hidden="true"></i>
                                <span class="btn-text"><?php echo $lang->simulateGesture ?></span>
                            </button>
                        </div>
                    </div>
                    <div class="btn-group btn-group-justified simulator-continuous-trigger text-center hidden">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-shadow" id="btn-trigger-continuous-gesture" style="border-radius: 8px;">
                                <i class="fa Example of arrows-alt fa-arrows-alt" aria-hidden="true"></i>
                                <span class="btn-text"><?php echo $lang->simulateGestureFree ?> (Shift <i class="fa fa-arrow-up"></i>)</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!--</div>-->

                <div class="caption text-center" style="display: flow-root">
                    <p class="gesture-name ellipsis" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""></p><div class="btn-show-gesture-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->showAllGestureInfos ?>"><i class="fa fa-ellipsis-h"></i></div>
                </div>
            </div>


            <div class="mouse-simulation-pad hidden text-center readonly-without-mouse" style="position: absolute; top: 0px; left: 15px; right: 15px; bottom: 20px; border-radius: 8px; z-index: 100; border: 3px solid rgb(56, 129, 185);">
                <div style="top: 50%; position: relative; transform: translateY(-50%);" class="text"><i class="fa fa-mouse-pointer"></i> <?php echo $lang->simulateGestureMouse ?></div>
                <div class="position-printing" style="position: absolute; bottom: 5px; width: 100%; left: 50%; transform: translateX(-50%); font-size: 10pt"><span>x-Position:</span> <span class="text x-position"></span>, <span>y-Position:</span> <span class="text y-position"></span></div>
            </div>
            
            <div class="mouse-simulation-slider hidden text-center readonly-without-mouse" style="position: absolute; top: 0px; left: 15px; right: 15px; bottom: 20px; border-radius: 8px; z-index: 100; border: 3px solid rgb(56, 129, 185);"></div>
        </div>
    </div>

</div>