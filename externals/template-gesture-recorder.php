<?php
include '../includes/language.php';
?>

<div id="item-container-gesture-recorder" class="hidden">

    <div id="gesture-recorder-with-introductions" class="row">

        <!-- introduction contents -->
        <div class="col-sm-5 instruction-contents">
            <div class="instruction-content hidden gr-pre-initialize">
                <h3 style="margin: 0" id="headline"><?php echo $lang->gestureRecorderManual->preInitialize->headline ?></h3>
                <hr>
                <p class="text">
                    <?php echo $lang->gestureRecorderManual->preInitialize->description ?>
                </p>
            </div>
            <div class="instruction-content hidden gr-initialize">
                <h3 style="margin: 0" id="headline"><?php echo $lang->gestureRecorderManual->initialize->headline ?></h3>
                <hr>
                <p class="text">
                    <?php echo $lang->gestureRecorderManual->initialize->description ?>
                </p>
            </div>
            <div class="instruction-content hidden gr-record">
                <h3 style="margin: 0" id="headline"><?php echo $lang->gestureRecorderManual->recordGesture->headline ?></h3>
                <hr>
                <p class="text">
                    <?php echo $lang->gestureRecorderManual->recordGesture->description ?>
                </p>
            </div>
            <div class="instruction-content hidden gr-playback">
                <h3 style="margin: 0" id="headline"><?php echo $lang->gestureRecorderManual->previewTrimmingGesture->headline ?></h3>
                <hr>
                <div class="text">
                    <p>
                        <?php echo $lang->gestureRecorderManual->previewTrimmingGesture->descriptionPreview ?>
                    </p>
                    <p>
                        <?php echo $lang->gestureRecorderManual->previewTrimmingGesture->descriptionTrimming ?>
                    </p>
                </div>
            </div>
            <div class="instruction-content hidden gr-save">
                <h3 style="margin: 0" id="headline"><?php echo $lang->gestureRecorderManual->describeAndSave->headline ?></h3>
                <hr>
                <div class="text">
                    <p>
                        <?php echo $lang->gestureRecorderManual->describeAndSave->previewImage ?>
                    </p>
                    <p>
                        <?php echo $lang->gestureRecorderManual->describeAndSave->gestureDescription ?>
                    </p>
                    <p>
                        <?php echo $lang->gestureRecorderManual->describeAndSave->graphicsDescription ?>
                    </p>
                    <p>
                        <?php echo $lang->gestureRecorderManual->describeAndSave->saveDescription ?>
                    </p>
                    <p>
                        <?php echo $lang->gestureRecorderManual->describeAndSave->worstResultDescription ?>
                    </p>
                </div>
            </div>
            <div class="instruction-content hidden gr-save-success">
                <h3 style="margin: 0" id="headline"><?php echo $lang->gestureRecorderManual->savedGesture->headline ?></h3>
                <hr>
                <div class="text">
                    <p>
                        <?php echo $lang->gestureRecorderManual->savedGesture->description ?>
                    </p>
                </div>
            </div>
            <div class="instruction-content hidden gr-delete-success">
                <h3 style="margin: 0" id="headline"><?php echo $lang->gestureRecorderManual->deletedGesture->headline ?></h3>
                <hr>
                <div class="text">
                    <p>
                        <?php echo $lang->gestureRecorderManual->deletedGesture->description ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- recorder contents -->
        <div class="col-sm-7 recorder-contents gesture-recorder-with-introductions">
            <div class="panel panel-shadow">
                <div class="panel-body">

                    <div id="gesture-recorder-nav" class="text-center" style="">
                        <div style="display: inline-block">
                            <ul class="nav nav-pills custom-nav-pills">
                                <li role="presentation" class="disabled"><a href="#" class="btn-gesture-recorder-nav" data-toggle-id="gr-pre-initialize"><div><i class="fa fa-video-camera"></i></div><span class="hidden-xs hidden-sm"><?php echo $lang->gestureRecorderNavigation->preInitialize ?></span></a></li>
                                <li role="presentation" class="disabled"><a href="#" class="btn-gesture-recorder-nav" data-toggle-id="gr-record"><div><i class="fa fa-dot-circle-o"></i></div><span class="hidden-xs hidden-sm"><?php echo $lang->gestureRecorderNavigation->record ?></span></a></li>
                                <li role="presentation" class="disabled"><a href="#" class="btn-gesture-recorder-nav" data-toggle-id="gr-playback"><div><i class="fa fa-scissors"></i></div><span class="hidden-xs hidden-sm"><?php echo $lang->gestureRecorderNavigation->cut ?></span></a></li>
                                <li role="presentation" class="disabled"><a href="#" class="btn-gesture-recorder-nav" data-toggle-id="gr-save"><div><i class="fa fa-pencil"></i></div><span class="hidden-xs hidden-sm"><?php echo $lang->gestureRecorderNavigation->save ?></span></a></li>
                            </ul>
                        </div>
                    </div>


                    <!-- pre initialization -->
                    <div class="recorder-content hidden gr-pre-initialize">

                        <div class="form-group root useWebcamSwitch" style="">
                            <label style="margin: 0">
                                <?php echo $lang->shouldUseWebcam ?> 
                                <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->identificationWebcam ?>"></i>
                            </label><br>

                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="no">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->no ?></span>
                                </button>
                            </div>
                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="yes">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin hidden" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->yes ?></span>
                                </button>
                            </div>

                        </div>

                        <div class="form-group root useSensorSwitch" style="margin-top: 10px">
                            <label style="margin: 0">
                                <?php echo $lang->whatSensorShouldBeUsed ?> 
                                <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->identificationSensor ?>"></i>
                            </label><br>

                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="none">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin hidden" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->none ?></span>
                                </button>
                            </div>
                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="leap">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->sensors->leap->title ?></span>
                                </button>
                            </div>
                        </div>

                        <button class="btn btn-block btn-success btn-shadow disabled" id="btn-initialize-recorder"><?php echo $lang->next ?> <i class="fa fa-arrow-right"></i></button>
                    </div>

                    <!-- initialization -->
                    <div class="recorder-content hidden gr-initialize text-center">
                        <div class="embed-responsive embed-responsive-4by3" style="">
                            <div class="embed-responsive-item" style="display: flex; flex-direction: column; justify-content: center; background-color: #eee; border-radius: 5px">
                                <i class="fa fa-circle-o-notch fa-spin fa-5x"></i>
                            </div>
                            <div class="embed-responsive-item" id="initialize-recorders-list" style="padding-top: 10px"></div>
                        </div>
                    </div>

                    <!-- recording -->
                    <div class="root recorder-content hidden gr-record">
                        <!--                <div id="toggle-gesture-recording-record-source" class="hidden text-center">
                                            <div class="btn-group btn-group-xs">
                                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="webcam" id="btn-webcam"><i class="fa fa-video-camera"></i> <?php echo $lang->sensors->webcam->title ?></button>
                                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="leap" id="btn-leap"><i class="fa fa-code"></i> <?php echo $lang->sensors->leap->title ?></button>
                                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="kinect" id="btn-kinect"><i class="fa fa-code"></i> <?php echo $lang->sensors->kinect->title ?></button>
                                            </div>
                                        </div>-->
                        <div class="sensor-content" style="">
                            <div data-sensor-source="webcam" id="webcam-stream" class="sensor-source-record hidden">
                                <div class="root embed-responsive embed-responsive-4by3" style="background-color: #eeeeee; border-top-left-radius: 5px; border-top-right-radius: 5px">
                                    <div class="embed-responsive-item">
                                        <video class="recorder-webcam-video mirroredHorizontally" autoplay style=" border-top-left-radius: 5px; border-top-right-radius: 5px"></video>
                                    </div>

                                    <div class="btn-group" id="stream-controls" style="position: absolute; bottom: 6px; left: 50%; transform: translate(-50%, 0);">
                                        <button type="button" class="btn btn-sm stream-control" id="btn-config-rtc" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->configRTC ?>"><i class="fa fa-cog"></i> </button>
                                    </div>

                                    <div id="rtc-config-panel" class="hidden" style="border-top-left-radius: 4px; border-top-left-radius: 4px; background-color: rgba(0,0,0,.4); padding: 15px 15px 0px 15px; position: absolute; top:0px; bottom:0px; left: 0px; right: 0px">
                                        <div class="form-group" id="video-input-select">
                                            <label style="margin: 0; color: white"><?php echo $lang->chooseVideoInput ?></label><br>

                                            <div class="input-group">
                                                <input class="form-control item-input-text show-dropdown" tabindex="-1" type="text" value=""/>
                                                <div class="input-group-btn select select-video-input" role="group">
                                                    <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                                    <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-default btn-block btn-shadow" id="btn-close-config"><i class="fa fa-check"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div data-sensor-source="leap" id="leap-record" class="sensor-source-record hidden"></div>
                        </div>

                        <div class="progress hidden" id="record-timer-progress" style="height: 8px; border-top-left-radius: 0px; border-radius: 0px">
                            <div class="progress-bar progress-bar-primary" id="record-timer-progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%; width: 100%"></div>
                        </div>

                        <button class="btn btn-success btn-block btn-shadow disabled" id="btn-record" style="border-top-left-radius: 0px; border-top-right-radius: 0px;"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> <?php echo $lang->startRecording ?></button>
                        <button class="btn btn-danger btn-block btn-shadow hidden" id="btn-record-stop" style="border-top-left-radius: 0px; border-top-right-radius: 0px; margin-top: -20px"><i class="fa fa-stop" aria-hidden="true"></i> <?php echo $lang->stopRecording ?></button>
                    </div>

                    <!-- playback -->
                    <div class="root recorder-content hidden gr-playback" style="">
                        <div id="toggle-gesture-playback-preview-source" class="hidden text-center">
                            <div class="btn-group btn-group-xs">
                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="webcam" id="btn-webcam"><i class="fa fa-video-camera"></i> <?php echo $lang->sensors->webcam->title ?></button>
                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="leap" id="btn-leap"><i class="fa fa-code"></i> <?php echo $lang->sensors->leap->title ?></button>
                                <!--<button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="kinect" id="btn-kinect"><i class="fa fa-code"></i> <?php echo $lang->sensors->kinect->title ?></button>-->
                            </div>
                        </div>

                        <div class="sensor-content" style="">
                            <div data-sensor-source="webcam" id="webcam-preview" class="sensor-source-preview hidden">
                                <div class="root embed-responsive embed-responsive-4by3">
                                    <video class="playback-webcam-video mirroredHorizontally" preload="metadata" style="border-top-left-radius: 5px; border-top-right-radius: 5px"></video>
                                    <div class="controls-container embed-responsive-item">
                                        <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                                        <!--<div class="controls-container-btn application-btn application-btn-bottom-left application-btn-bottom-left-single" id="btn-toggle-cropping"><i class="fa fa-crop"></i> <?php echo $lang->cutGesture ?></div>-->
                                    </div>
                                </div>

                                <div id="playback-webcam-slider-controls" style="margin-top: -10px">
                                    <!--                            <div style="width: 100%;">
                                                                    <input id="webcam-playback-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                                                </div>-->
                                    <div id="playback-webcam-crop-slider-controls" class="hidden" style="width: 100%;">
                                        <input id="webcam-playback-crop-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                    </div>
                                </div>

                                <div class="row">
                                    <!--                            <div class="col-xs-6">
                                                                    <div class="form-group">
                                                                        <label style="">
                                    <?php echo $lang->gestureRecorderNavigation->cut ?> 
                                                                            <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->cut ?>"></i>
                                                                        </label><br>
                                                                        <div class="btn btn-default btn-shadow btn-block" id="btn-toggle-cropping"><i class="fa fa-scissors"></i> <?php echo $lang->cutGesture ?></div>
                                                                    </div>
                                                                </div>-->

                                    <div class="col-xs-6">
                                        <div class="form-group form-group-no-margin" id="keyframeSelect">
                                            <label style="">
                                                <?php echo $lang->imageExportEvery ?> 
                                                <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->fragmentation ?>"></i>
                                            </label><br>
                                            <div class="input-group simple-stepper" id="counter-from" style="max-width: 100%">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default btn-shadow btn-stepper-decrease" value="80">
                                                        <span class="fa fa-minus"></span><span class="sr-only"><?php echo $lang->less ?></span>
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control readonly text-center stepper-text" value="100">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default btn-shadow btn-stepper-increase" value="500">
                                                        <span class="fa fa-plus"></span><span class="sr-only"><?php echo $lang->more ?></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div data-sensor-source="leap" id="leap-preview" class="sensor-source-preview hidden">
                                <div class="embed-responsive embed-responsive-4by3 sensor-canvas">
                                    <div id="renderArea" class="embed-responsive-item"></div>
                                    <div class="controls-container embed-responsive-item">
                                        <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-top-left-first btn-download-as-json" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsJSON ?>"><i class="fa fa-file-code-o"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-top-left-last btn-download-as-compressed" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsCompressed ?>"><i class="fa fa-file-zip-o"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-bottom-left application-btn-bottom-left-single" id="btn-toggle-cropping"><i class="fa fa-crop"></i> <?php echo $lang->cutGesture ?></div>
                                    </div>
                                </div>
                                <div id="playback-leap-slider-controls" style="margin-top: -10px">
                                    <div style="width: 100%;">
                                        <input id="leap-playback-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                    </div>
                                    <div id="playback-leap-crop-slider-controls" class="hidden" style="width: 100%;">
                                        <input id="leap-playback-crop-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="alert-space alert-gesture-too-short"></div>

                        <div id="playpack-export" style="margin-top: 10px">
                            <!--<div class="form-group">-->
                            <!--<div class="btn-group-vertical btn-block">-->
                                <!--<button class="btn btn-block btn-default btn-shadow btn-repeat-recording"><i class="fa fa-repeat" aria-hidden="true"></i> <?php echo $lang->recordNewGesture ?></button>-->
                            <button class="btn btn-block btn-success btn-shadow" id="btn-extract-gesture"><?php echo $lang->next ?> <i class="fa fa-arrow-right"></i></button>
                            <!--</div>-->
                            <!--</div>-->
                        </div>

                    </div>

                    <!-- save screen: form for data -->
                    <div class="root recorder-content hidden gr-save">
                        <div id="toggle-gesture-playback-save-source" class="hidden text-center">
                            <div class="btn-group btn-group-xs">
                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="webcam" id="btn-webcam"><i class="fa fa-video-camera"></i> <?php echo $lang->sensors->webcam->title ?></button>
                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="leap" id="btn-leap"><i class="fa fa-code"></i> <?php echo $lang->sensors->leap->title ?></button>
                            </div>
                        </div>

                        <div class="sensor-content" style="margin-top: 10px; max-width: 400px; margin: 0 auto;">
                            <div data-sensor-source="webcam" id="webcam-save-preview" class="sensor-source-save hidden">
                                <div class="root embed-responsive embed-responsive-4by3">
                                    <div class="webcam-image-container"></div>
                                    <div class="controls-container embed-responsive-item">
                                        <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-top-left-single btn-download-as-gif" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsGIF ?>"><i class="fa fa-file-image-o"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-bottom-left application-btn-bottom-left-single btn-tag-as-preview" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tagAsPreviewImage ?>"><i class="fa fa-bookmark-o"></i> <?php echo $lang->previewImage ?>: <span class="preview-image-index">1</span></div>
                                    </div>
                                </div>

                                <div id="webcam-playback-slider-controls" class="hidden" style="margin-top: -10px" data-visible="true">
                                    <div id="webcam-playback-slider-container" class="webcam-playback-slider-container" style="width: 100%;">
                                        <input id="webcam-playback-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                    </div>
                                </div>
                            </div>

                            <div data-sensor-source="leap" id="leap-save-preview" class="sensor-source-save hidden">

                                <div class="embed-responsive embed-responsive-4by3">
                                    <div id="renderArea" class="embed-responsive-item sensor-canvas"></div>
                                    <div class="controls-container embed-responsive-item">
                                        <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-top-left-first btn-download-as-json" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsJSON ?>"><i class="fa fa-file-code-o"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-top-left-last btn-download-as-compressed" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsCompressed ?>"><i class="fa fa-file-zip-o"></i></div>
                                    </div>
                                </div>

                                <div id="playback-leap-slider-controls" style="margin-top: -10px">
                                    <div style="width: 100%;">
                                        <input id="leap-playback-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div id="gesture-save-form">
                            <div class="alert-space alert-general-error"></div>
                            <div class="alert-space alert-missing-fields"></div>

                            <div class="form-group" style="margin-top: 10px">
                                <label><?php echo $lang->gestureName ?> <sup>*</sup></label>
                                <input type="text" class="form-control" id="gestureName" required>
                            </div>

                            <div class="form-group root" id="gestureNameQualitySelect">
                                <label>
                                    <?php echo $lang->gestureNameQuality ?> 
                                    <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->gestureNameQuality ?>"></i>
                                </label><br>

                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio" name="primary" id="generic">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->gestureNameQualities->generic->title ?></span>
                                    </button>
                                </div>
                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="functional">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin hidden" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->gestureNameQualities->functional->title ?></span>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group root" id="gestureTypeSelect">
                                <label>
                                    <?php echo $lang->gestureExecutionType ?> 
                                    <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->executionType ?>"></i>
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
                                    <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="dynamic">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin hidden" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->gestureTypes->dynamic ?></span>
                                    </button>
                                </div>
                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio" name="primary" id="mixed">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->gestureTypes->mixed ?></span>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group root" id="gestureInteractionTypeSelect">
                                <label>
                                    <?php echo $lang->gestureInteractionType ?> 
                                    <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->interactionType ?>"></i>
                                </label><br>

                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="discrete">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin hidden" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle" id="checked"></i>
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
                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio" name="primary" id="mixed">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->gestureTypes->mixed ?></span>
                                    </button>
                                </div>
                            </div>


                            <div class="form-group root hidden" id="continuousValueTypeSelect" style="">
                                <label>
                                    <?php echo $lang->continuousValueTypeLabel ?> 
                                    <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->continuousValueType ?>"></i>
                                </label><br>

                                <!--<div class="root">-->
                                <div class="btn-group" id="radio" style="margin: 0;">
                                    <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="none">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin hidden" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->none ?></span>
                                    </button>
                                </div>
                                <div class="btn-group" id="radio" style="margin: 0;">
                                    <button class="btn btn-default btn-radio" name="primary" id="percent">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->continuousValueType->percent ?></span>
                                    </button>
                                </div>
                                <div class="btn-group" id="radio" style="margin: 0;">
                                    <button class="btn btn-default btn-radio" name="primary" id="position">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->continuousValueType->position ?></span>
                                    </button>
                                </div>
                                <div class="btn-group" id="radio" style="margin: 0;">
                                    <button class="btn btn-default btn-radio" name="primary" id="mouseSimulation">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->continuousValueType->mouseSimulation ?></span>
                                    </button>
                                </div>
                                <!--</div>-->
                            </div>


                            <div class="form-group">
                                <label><?php echo $lang->gestureContext ?></label> 
                                <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->context ?>"></i>
                                <input type="text" class="form-control" id="gestureContext" required value="<?php echo $lang->notSpecified ?>">
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->gestureAssociation ?></label> 
                                <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->association ?>"></i>
                                <textarea class="form-control" id="gestureAssociation" rows="3" maxlength="1000" required><?php echo $lang->notSpecified ?></textarea>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->gestureDescription ?></label> 
                                <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->description ?>"></i>
                                <textarea class="form-control" id="gestureDescription" rows="3" maxlength="1000" required><?php echo $lang->notSpecified ?></textarea>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->bodyParts ?></label> 
                                <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->bodyParts ?>"></i>
                                <div class="select-joints-humand-body" id="human-body" style="width: 350px; margin: auto">
                                    <div id="joint-container" style="position: absolute"></div>
                                    <img src="img/human_body.svg">
                                </div>
                            </div>

                            <div class="form-group root" id="doubleSidedUseSelect">
                                <label>
                                    <?php echo $lang->doubleSidedUse ?>? 
                                    <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->doubleSidedUse ?>"></i>
                                </label><br>

                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio" name="primary" id="yes">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->yes ?></span>
                                    </button>
                                </div>
                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="no">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin hidden" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->no ?></span>
                                    </button>
                                </div>
                            </div>

                            <div class="alert-space alert-general-error"></div>
                        </div>

                        <button class="btn btn-block btn-success btn-shadow disabled" id="btn-save-gesture"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo $lang->saveGesture ?></button>

                        <div class="hidden" id="gesture-save-progress" style="margin-top: 20px">
                            <div id="progress-images" class="hidden">
                                <label><?php echo $lang->transferImages ?>:</label>
                                <div class="progress" style="margin-bottom: 0px">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
                                        0%
                                    </div>
                                </div>
                            </div>
                            <div id="progress-gif" class="hidden" style="margin-top: 20px">
                                <label><?php echo $lang->transferGIF ?>:</label>
                                <div class="progress" style="margin-bottom: 0px">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
                                        0%
                                    </div>
                                </div>
                            </div>
                            <div id="progress-sensor-data" class="hidden" style="margin-top: 20px">
                                <label><?php echo $lang->transferSensorData ?>:</label>
                                <div class="progress" style="margin-bottom: 0px">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
                                        0%
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- success screen with gesture preview -->
                    <div class="root recorder-content hidden gr-save-success">
                        <div class="alert-space alert-gesture-save-success"></div>
                        <div class="alert-space alert-general-error"></div>

                        <div id="toggle-gesture-save-success-source" class="hidden text-center" style="margin-top: 10px">
                            <div class="btn-group btn-group-xs">
                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="webcam" id="btn-webcam"><i class="fa fa-video-camera"></i> <?php echo $lang->sensors->webcam->title ?></button>
                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="leap" id="btn-leap"><i class="fa fa-code"></i> <?php echo $lang->sensors->leap->title ?></button>
                            </div>
                        </div>

                        <div class="sensor-content" style="margin-top: 10px; max-width: 400px; margin: 0 auto;">
                            <div data-sensor-source="webcam" id="webcam-save-success-preview" class="sensor-source-save-success hidden">
                                <div class="root embed-responsive embed-responsive-4by3">
                                    <div class="webcam-image-container"></div>
                                    <div class="controls-container embed-responsive-item">
                                        <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-top-left-single btn-download-as-gif" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsGIF ?>"><i class="fa fa-file-image-o"></i></div>
                                        <!--<div class="controls-container-btn application-btn application-btn-right btn-tag-as-preview" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tagAsPreviewImage ?>"><i class="fa fa-bookmark-o"></i></div>-->
                                    </div>
                                </div>

                                <div id="webcam-playback-slider-controls" class="hidden" style="margin-top: -10px" data-visible="true">
                                    <div id="webcam-playback-slider-container" class="webcam-playback-slider-container" style="width: 100%;">
                                        <input id="webcam-playback-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                    </div>
                                </div>
                            </div>

                            <div data-sensor-source="leap" id="leap-save-success-preview" class="sensor-source-save-success hidden">

                                <div class="embed-responsive embed-responsive-4by3">
                                    <div id="renderArea" class="embed-responsive-item sensor-canvas"></div>
                                    <div class="controls-container embed-responsive-item">
                                        <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-top-left-first btn-download-as-json" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsJSON ?>"><i class="fa fa-file-code-o"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-top-left-last btn-download-as-compressed" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsCompressed ?>"><i class="fa fa-file-zip-o"></i></div>
                                    </div>
                                </div>

                                <div id="playback-leap-slider-controls" style="margin-top: -10px">
                                    <div style="width: 100%;">
                                        <input id="leap-playback-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="btn-group-vertical btn-block" style="margin-top: 20px">
                            <button class="btn btn-danger btn-shadow" id="btn-delete-saved-gesture"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo $lang->deleteSavedGesture ?></button>
                            <button class="btn btn-default btn-shadow btn-repeat-recording"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php echo $lang->recordMoreGestures ?></button>
                        </div>
                    </div>

                    <!-- delete success screen -->
                    <div class="recorder-content hidden gr-delete-success">
                        <div class="alert-space alert-general-error"></div>
                        <div class="alert-space alert-gesture-delete-success"></div>

                        <div class="btn-group-vertical btn-block" style="margin-top: 10px">
                            <button class="btn btn-default btn-shadow btn-repeat-recording"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php echo $lang->recordGesture ?></button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div id="init-recorder-list-item">
        <span style="margin-right: 2px;">
            <i class="init-wait fa fa-circle-o-notch fa-spin"></i>
            <i class="init-done fa fa-check hidden"></i>
        </span>
        <span class="sensor-title"></span>
    </div>




    <div id="gesture-recorder-without-introductions">

        <!-- recorder contents -->
        <div class="recorder-contents">
            <div class="panel panel-shadow">
                <div class="panel-body">

                    <div id="gesture-recorder-nav" class="text-center" style="">
                        <div style="display: inline-block">
                            <ul class="nav nav-pills custom-nav-pills">
                                <li role="presentation" class="disabled"><a href="#" class="btn-gesture-recorder-nav" data-toggle-id="gr-pre-initialize"><div><i class="fa fa-video-camera"></i></div><span class="hidden-xs hidden-sm"><?php echo $lang->gestureRecorderNavigation->preInitialize ?></span></a></li>
                                <li role="presentation" class="disabled"><a href="#" class="btn-gesture-recorder-nav" data-toggle-id="gr-record"><div><i class="fa fa-dot-circle-o"></i></div><span class="hidden-xs hidden-sm"><?php echo $lang->gestureRecorderNavigation->record ?></span></a></li>
                                <li role="presentation" class="disabled"><a href="#" class="btn-gesture-recorder-nav" data-toggle-id="gr-playback"><div><i class="fa fa-scissors"></i></div><span class="hidden-xs hidden-sm"><?php echo $lang->gestureRecorderNavigation->cut ?></span></a></li>
                                <li role="presentation" class="disabled"><a href="#" class="btn-gesture-recorder-nav" data-toggle-id="gr-save"><div><i class="fa fa-pencil"></i></div><span class="hidden-xs hidden-sm"><?php echo $lang->gestureRecorderNavigation->save ?></span></a></li>
                            </ul>
                        </div>
                    </div>


                    <!-- pre initialization -->
                    <div class="recorder-content hidden gr-pre-initialize">

                        <div class="form-group root useWebcamSwitch" style="margin-top: 10px">
                            <label style="margin: 0">
                                <?php echo $lang->shouldUseWebcam ?> 
                                <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->identificationWebcam ?>"></i>
                            </label><br>

                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="no">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->no ?></span>
                                </button>
                            </div>
                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="yes">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin hidden" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->yes ?></span>
                                </button>
                            </div>

                        </div>

                        <div class="form-group root useSensorSwitch" style="margin-top: 10px">
                            <label style="margin: 0">
                                <?php echo $lang->whatSensorShouldBeUsed ?> 
                                <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->identificationSensor ?>"></i>
                            </label><br>

                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="none">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin hidden" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->none ?></span>
                                </button>
                            </div>
                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="leap">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->sensors->leap->title ?></span>
                                </button>
                            </div>
                        </div>

                        <button class="btn btn-block btn-success btn-shadow disabled" id="btn-initialize-recorder"><?php echo $lang->next ?> <i class="fa fa-arrow-right"></i></button>
                    </div>

                    <!-- initialization -->
                    <div class="recorder-content hidden gr-initialize text-center">
                        <div class="embed-responsive embed-responsive-4by3" style="">
                            <div class="embed-responsive-item" style="display: flex; flex-direction: column; justify-content: center; background-color: #eee; border-radius: 5px">
                                <i class="fa fa-circle-o-notch fa-spin fa-5x"></i>
                            </div>
                            <div class="embed-responsive-item" id="initialize-recorders-list" style="padding-top: 10px"></div>
                        </div>
                    </div>

                    <!-- recording -->
                    <div class="root recorder-content hidden gr-record">
                        <!--                <div id="toggle-gesture-recording-record-source" class="hidden text-center">
                                            <div class="btn-group btn-group-xs">
                                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="webcam" id="btn-webcam"><i class="fa fa-video-camera"></i> <?php echo $lang->sensors->webcam->title ?></button>
                                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="leap" id="btn-leap"><i class="fa fa-code"></i> <?php echo $lang->sensors->leap->title ?></button>
                                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="kinect" id="btn-kinect"><i class="fa fa-code"></i> <?php echo $lang->sensors->kinect->title ?></button>
                                            </div>
                                        </div>-->
                        <div class="sensor-content">
                            <div data-sensor-source="webcam" id="webcam-stream" class="sensor-source-record hidden">
                                <div class="root embed-responsive embed-responsive-4by3" style="background-color: #eeeeee; border-top-left-radius: 5px; border-top-right-radius: 5px">
                                    <div class="embed-responsive-item">
                                        <video class="recorder-webcam-video mirroredHorizontally" autoplay style=" border-top-left-radius: 5px; border-top-right-radius: 5px"></video>
                                    </div>

                                    <div class="btn-group" id="stream-controls" style="position: absolute; bottom: 6px; left: 50%; transform: translate(-50%, 0);">
                                        <button type="button" class="btn btn-sm stream-control" id="btn-config-rtc" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->configRTC ?>"><i class="fa fa-cog"></i> </button>
                                    </div>
                                </div>
                            </div>

                            <div data-sensor-source="leap" id="leap-record" class="sensor-source-record hidden"></div>
                        </div>

                        <div class="progress hidden" id="record-timer-progress" style="height: 8px; border-top-left-radius: 0px; border-radius: 0px">
                            <div class="progress-bar progress-bar-primary" id="record-timer-progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%; width: 100%"></div>
                        </div>

                        <button class="btn btn-success btn-block btn-shadow disabled" id="btn-record" style="border-top-left-radius: 0px; border-top-right-radius: 0px;"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> <?php echo $lang->startRecording ?></button>
                        <button class="btn btn-danger btn-block btn-shadow hidden" id="btn-record-stop" style="border-top-left-radius: 0px; border-top-right-radius: 0px; margin-top: -20px"><i class="fa fa-stop" aria-hidden="true"></i> <?php echo $lang->stopRecording ?></button>
                    </div>

                    <!-- playback -->
                    <div class="root recorder-content hidden gr-playback">
                        <div id="toggle-gesture-playback-preview-source" class="hidden text-center">
                            <div class="btn-group btn-group-xs">
                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="webcam" id="btn-webcam"><i class="fa fa-video-camera"></i> <?php echo $lang->sensors->webcam->title ?></button>
                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="leap" id="btn-leap"><i class="fa fa-code"></i> <?php echo $lang->sensors->leap->title ?></button>
                                <!--<button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="kinect" id="btn-kinect"><i class="fa fa-code"></i> <?php echo $lang->sensors->kinect->title ?></button>-->
                            </div>
                        </div>

                        <div class="sensor-content" style="margin-top: 10px">
                            <div data-sensor-source="webcam" id="webcam-preview" class="sensor-source-preview hidden">
                                <div class="root embed-responsive embed-responsive-4by3">
                                    <video class="playback-webcam-video mirroredHorizontally" preload="metadata" style="border-top-left-radius: 5px; border-top-right-radius: 5px"></video>
                                    <div class="controls-container embed-responsive-item">
                                        <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-bottom-left application-btn-bottom-left-single" id="btn-toggle-cropping"><i class="fa fa-crop"></i> <?php echo $lang->cutGesture ?></div>
                                    </div>
                                </div>

                                <div id="playback-webcam-slider-controls" style="margin-top: -10px">
                                    <div style="width: 100%;">
                                        <input id="webcam-playback-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                    </div>
                                    <div id="playback-webcam-crop-slider-controls" class="hidden" style="width: 100%;">
                                        <input id="webcam-playback-crop-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                    </div>
                                </div>

                                <div class="form-group" id="keyframeSelect" style="margin-top: 10px">
                                    <label style="">
                                        <?php echo $lang->imageExportEvery ?> 
                                        <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->fragmentation ?>"></i>
                                    </label><br>
                                    <div class="input-group simple-stepper" id="counter-from" style="max-width: 140px;">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default btn-shadow btn-stepper-decrease" value="80">
                                                <span class="fa fa-minus"></span><span class="sr-only"><?php echo $lang->less ?></span>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control readonly text-center stepper-text" value="100">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default btn-shadow btn-stepper-increase" value="500">
                                                <span class="fa fa-plus"></span><span class="sr-only"><?php echo $lang->more ?></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div data-sensor-source="leap" id="leap-preview" class="sensor-source-preview hidden">
                                <div class="embed-responsive embed-responsive-4by3 sensor-canvas">
                                    <div id="renderArea" class="embed-responsive-item"></div>
                                    <div class="controls-container embed-responsive-item">
                                        <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-top-left-first btn-download-as-json" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsJSON ?>"><i class="fa fa-file-code-o"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-top-left-last btn-download-as-compressed" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsCompressed ?>"><i class="fa fa-file-zip-o"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-bottom-left application-btn-bottom-left-single" id="btn-toggle-cropping"><i class="fa fa-crop"></i> <?php echo $lang->cutGesture ?></div>
                                    </div>
                                </div>
                                <div id="playback-leap-slider-controls" style="margin-top: -10px">
                                    <div style="width: 100%;">
                                        <input id="leap-playback-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                    </div>
                                    <div id="playback-leap-crop-slider-controls" class="hidden" style="width: 100%;">
                                        <input id="leap-playback-crop-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="alert-space alert-gesture-too-short"></div>

                        <div id="playpack-export" style="margin-top: 10px">
                            <div class="form-group">
                                <div class="btn-group-vertical btn-block">
                                    <!--<button class="btn btn-block btn-default btn-shadow btn-repeat-recording"><i class="fa fa-repeat" aria-hidden="true"></i> <?php echo $lang->recordNewGesture ?></button>-->
                                    <button class="btn btn-block btn-success btn-shadow" id="btn-extract-gesture"><?php echo $lang->next ?> <i class="fa fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- save screen: form for data -->
                    <div class="root recorder-content hidden gr-save">
                        <div id="toggle-gesture-playback-save-source" class="hidden text-center">
                            <div class="btn-group btn-group-xs">
                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="webcam" id="btn-webcam"><i class="fa fa-video-camera"></i> <?php echo $lang->sensors->webcam->title ?></button>
                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="leap" id="btn-leap"><i class="fa fa-code"></i> <?php echo $lang->sensors->leap->title ?></button>
                            </div>
                        </div>

                        <div class="sensor-content" style="margin-top: 10px; max-width: 400px; margin: 0 auto;">
                            <div data-sensor-source="webcam" id="webcam-save-preview" class="sensor-source-save hidden">
                                <div class="root embed-responsive embed-responsive-4by3">
                                    <div class="webcam-image-container"></div>
                                    <div class="controls-container embed-responsive-item">
                                        <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-top-left-single btn-download-as-gif" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsGIF ?>"><i class="fa fa-file-image-o"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-bottom-left application-btn-bottom-left-single btn-tag-as-preview" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tagAsPreviewImage ?>"><i class="fa fa-bookmark-o"></i> <?php echo $lang->previewImage ?>: <span class="preview-image-index">1</span></div>
                                    </div>
                                </div>

                                <div id="webcam-playback-slider-controls" class="hidden" style="margin-top: -10px" data-visible="true">
                                    <div id="webcam-playback-slider-container" class="webcam-playback-slider-container" style="width: 100%;">
                                        <input id="webcam-playback-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                    </div>
                                </div>
                            </div>

                            <div data-sensor-source="leap" id="leap-save-preview" class="sensor-source-save hidden">

                                <div class="embed-responsive embed-responsive-4by3">
                                    <div id="renderArea" class="embed-responsive-item sensor-canvas"></div>
                                    <div class="controls-container embed-responsive-item">
                                        <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-top-left-first btn-download-as-json" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsJSON ?>"><i class="fa fa-file-code-o"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-top-left-last btn-download-as-compressed" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsCompressed ?>"><i class="fa fa-file-zip-o"></i></div>
                                    </div>
                                </div>

                                <div id="playback-leap-slider-controls" style="margin-top: -10px">
                                    <div style="width: 100%;">
                                        <input id="leap-playback-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                    </div>
                                </div>

                            </div>
                        </div>

                        <button class="btn btn-block btn-default btn-shadow disabled hidden" id="btn-recut-recording"><i class="fa fa-crop"></i> <?php echo $lang->recut ?></button>

                        <div id="gesture-save-form">
                            <div class="alert-space alert-general-error"></div>
                            <div class="alert-space alert-missing-fields"></div>

                            <div class="form-group" style="margin-top: 10px">
                                <label><?php echo $lang->gestureName ?> <sup>*</sup></label>
                                <input type="text" class="form-control" id="gestureName" required>
                            </div>

                            <div class="form-group root" id="gestureNameQualitySelect">
                                <label>
                                    <?php echo $lang->gestureNameQuality ?> 
                                    <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->gestureNameQuality ?>"></i>
                                </label><br>

                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio" name="primary" id="generic">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->gestureNameQualities->generic->title ?></span>
                                    </button>
                                </div>
                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="functional">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin hidden" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->gestureNameQualities->functional->title ?></span>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group root" id="gestureTypeSelect">
                                <label>
                                    <?php echo $lang->gestureExecutionType ?> 
                                    <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->executionType ?>"></i>
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
                                    <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="dynamic">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin hidden" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->gestureTypes->dynamic ?></span>
                                    </button>
                                </div>
                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio" name="primary" id="mixed">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->gestureTypes->mixed ?></span>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group root" id="gestureInteractionTypeSelect">
                                <label>
                                    <?php echo $lang->gestureInteractionType ?> 
                                    <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->interactionType ?>"></i>
                                </label><br>

                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="discrete">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin hidden" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle" id="checked"></i>
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
                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio" name="primary" id="mixed">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->gestureTypes->mixed ?></span>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group root hidden" id="continuousValueTypeSelect" style="">
                                <label>
                                    <?php echo $lang->continuousValueTypeLabel ?> 
                                    <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->continuousValueType ?>"></i>
                                </label><br>

                                <!--<div class="root">-->
                                <div class="btn-group" id="radio" style="margin: 0;">
                                    <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="none">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin hidden" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->none ?></span>
                                    </button>
                                </div>
                                <div class="btn-group" id="radio" style="margin: 0;">
                                    <button class="btn btn-default btn-radio" name="primary" id="percent">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->continuousValueType->percent ?></span>
                                    </button>
                                </div>
                                <div class="btn-group" id="radio" style="margin: 0;">
                                    <button class="btn btn-default btn-radio" name="primary" id="position">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->continuousValueType->position ?></span>
                                    </button>
                                </div>
                                <div class="btn-group" id="radio" style="margin: 0;">
                                    <button class="btn btn-default btn-radio" name="primary" id="mouseSimulation">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->continuousValueType->mouseSimulation ?></span>
                                    </button>
                                </div>
                                <!--</div>-->
                            </div>


                            <div class="form-group">
                                <label><?php echo $lang->gestureContext ?></label> 
                                <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->context ?>"></i>
                                <input type="text" class="form-control" id="gestureContext" required value="<?php echo $lang->notSpecified ?>">
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->gestureAssociation ?></label> 
                                <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->association ?>"></i>
                                <textarea class="form-control" id="gestureAssociation" rows="3" maxlength="1000" required><?php echo $lang->notSpecified ?></textarea>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->gestureDescription ?></label> 
                                <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->description ?>"></i>
                                <textarea class="form-control" id="gestureDescription" rows="3" maxlength="1000" required><?php echo $lang->notSpecified ?></textarea>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->bodyParts ?></label> 
                                <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->bodyParts ?>"></i>
                                <div class="select-joints-humand-body" id="human-body" style="width: 350px; margin: auto">
                                    <div id="joint-container" style="position: absolute"></div>
                                    <img src="img/human_body.svg">
                                </div>
                            </div>

                            <div class="form-group root" id="doubleSidedUseSelect">
                                <label>
                                    <?php echo $lang->doubleSidedUse ?>? 
                                    <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->gestures->doubleSidedUse ?>"></i>
                                </label><br>

                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio" name="primary" id="yes">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->yes ?></span>
                                    </button>
                                </div>
                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="no">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin hidden" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->no ?></span>
                                    </button>
                                </div>
                            </div>

                            <div class="alert-space alert-general-error"></div>
                        </div>

                        <button class="btn btn-block btn-success btn-shadow disabled" id="btn-save-gesture"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo $lang->saveGesture ?></button>

                        <div class="hidden" id="gesture-save-progress" style="margin-top: 20px">
                            <div id="progress-images" class="hidden">
                                <label><?php echo $lang->transferImages ?>:</label>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
                                        0%
                                    </div>
                                </div>
                            </div>
                            <div id="progress-gif" class="hidden">
                                <label><?php echo $lang->transferGIF ?>:</label>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
                                        0%
                                    </div>
                                </div>
                            </div>
                            <div id="progress-sensor-data" class="hidden">
                                <label><?php echo $lang->transferSensorData ?>:</label>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
                                        0%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- success screen with gesture preview -->
                    <div class="root recorder-content hidden gr-save-success">
                        <div class="alert-space alert-gesture-save-success"></div>
                        <div class="alert-space alert-general-error"></div>

                        <div id="toggle-gesture-save-success-source" class="hidden text-center" style="margin-top: 10px">
                            <div class="btn-group btn-group-xs">
                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="webcam" id="btn-webcam"><i class="fa fa-video-camera"></i> <?php echo $lang->sensors->webcam->title ?></button>
                                <button type="button" class="btn btn-default btn-toggle-sensor-source hidden" data-toggle-sensor="leap" id="btn-leap"><i class="fa fa-code"></i> <?php echo $lang->sensors->leap->title ?></button>
                            </div>
                        </div>

                        <div class="sensor-content" style="margin-top: 10px; max-width: 400px; margin: 0 auto;">
                            <div data-sensor-source="webcam" id="webcam-save-success-preview" class="sensor-source-save-success hidden">
                                <div class="root embed-responsive embed-responsive-4by3">
                                    <div class="webcam-image-container"></div>
                                    <div class="controls-container embed-responsive-item">
                                        <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-top-left-single btn-download-as-gif" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsGIF ?>"><i class="fa fa-file-image-o"></i></div>
                                        <!--<div class="controls-container-btn application-btn application-btn-right btn-tag-as-preview" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tagAsPreviewImage ?>"><i class="fa fa-bookmark-o"></i></div>-->
                                    </div>
                                </div>

                                <div id="webcam-playback-slider-controls" class="hidden" style="margin-top: -10px" data-visible="true">
                                    <div id="webcam-playback-slider-container" class="webcam-playback-slider-container" style="width: 100%;">
                                        <input id="webcam-playback-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                    </div>
                                </div>
                            </div>

                            <div data-sensor-source="leap" id="leap-save-success-preview" class="sensor-source-save-success hidden">

                                <div class="embed-responsive embed-responsive-4by3">
                                    <div id="renderArea" class="embed-responsive-item sensor-canvas"></div>
                                    <div class="controls-container embed-responsive-item">
                                        <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-top-left-first btn-download-as-json" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsJSON ?>"><i class="fa fa-file-code-o"></i></div>
                                        <div class="controls-container-btn application-btn application-btn-top-left-last btn-download-as-compressed" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsCompressed ?>"><i class="fa fa-file-zip-o"></i></div>
                                    </div>
                                </div>

                                <div id="playback-leap-slider-controls" style="margin-top: -10px">
                                    <div style="width: 100%;">
                                        <input id="leap-playback-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="btn-group-vertical btn-block" style="margin-top: 20px">
                            <button class="btn btn-danger btn-shadow" id="btn-delete-saved-gesture"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo $lang->deleteSavedGesture ?></button>
                            <button class="btn btn-default btn-shadow btn-repeat-recording"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php echo $lang->recordMoreGestures ?></button>
                        </div>
                    </div>

                    <!-- delete success screen -->
                    <div class="recorder-content hidden gr-delete-success">
                        <div class="alert-space alert-general-error"></div>
                        <div class="alert-space alert-gesture-delete-success"></div>

                        <div class="btn-group-vertical btn-block" style="margin-top: 10px">
                            <button class="btn btn-default btn-shadow btn-repeat-recording"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php echo $lang->recordGesture ?></button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div id="init-recorder-list-item">
        <span style="margin-right: 2px;">
            <i class="init-wait fa fa-circle-o-notch fa-spin"></i>
            <i class="init-done fa fa-check hidden"></i>
        </span>
        <span class="sensor-title"></span>
    </div>

</div>