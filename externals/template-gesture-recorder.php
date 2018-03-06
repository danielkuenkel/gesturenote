<?php
include '../includes/language.php';
?>

<script src="js/resumable/resumable.js"></script>
<script src="js/sha512.js"></script>
<div id="item-container-gesture-recorder" class="hidden">

    <div id="gesture-recorder">
        <div class="alert-space alert-web-rtc-not-supported"></div>

        <div class="recorder text-center" style="border-radius: 4px; max-width: 600px; margin: auto">
            <video autoplay id="recorder-video" style="width: 100%; height: auto; overflow: hidden; border-top-left-radius: 4px; border-top-right-radius: 4px"></video>
            <div class="progress hidden" id="record-timer-progress" style="margin-top: -8px; height: 8px; border-top-left-radius: 0px; border-radius: 0px">
                <div class="progress-bar progress-bar-info" id="record-timer-progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%; width: 100%"></div>
            </div>

            <div class="gesture-recorder-controls">
                <div class="hidden" id="record-controls" style="margin-top: -20px">
                    <button class="btn btn-success btn-block btn-shadow hidden" id="btn-record" style="border-top-left-radius: 0px; border-top-right-radius: 0px;"><i class="glyphicon glyphicon-record" aria-hidden="true"></i> <?php echo $lang->startRecording ?></button>
                    <button class="btn btn-danger btn-block btn-shadow hidden" id="btn-record-stop" style="border-top-left-radius: 0px; border-top-right-radius: 0px; margin-top: -8px"><i class="glyphicon glyphicon-stop" aria-hidden="true"></i> <?php echo $lang->stopRecording ?></button>
                </div>
                <div class="hidden" id="playback-controls" style="margin-top: -8px">
                    <div class="progress" id="seek-bar" style="height: 8px; border-top-left-radius: 0px; border-radius: 0px">
                        <div class="progress-bar progress-bar-success" id="seek-bar-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%"></div>
                    </div>
                    <div class="progress" id="trim-bar" style="border-top-left-radius: 0px; border-top-right-radius: 0px; margin-top: -20px">
                        <div class="progress-bar progress-bar-danger" id="gesture-beginning" style="width: 100%; height: 100%"></div>
                        <div class="progress-bar progress-bar-info" id="gesture-execution" style="width: 0%; height: 100%"><?php echo $lang->gesture ?></div>
                        <div class="progress-bar progress-bar-danger" id="gesture-ending" style="width: 0%; height: 100%"></div>
                    </div>
                    <div class="form-group">
                        <div class="btn-group">
                            <button class="btn btn-default btn-shadow" id="btn-play"><i class="fa fa-play" aria-hidden="true"></i></button>
                            <button class="btn btn-default btn-shadow" id="btn-pause"><i class="fa fa-pause" aria-hidden="true"></i></button>
                            <button class="btn btn-default btn-shadow" id="btn-stop"><i class="fa fa-stop" aria-hidden="true"></i></button>
                            <button class="btn btn-success btn-shadow" id="btn-mark-start"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i> <?php echo $lang->start ?></button>
                            <button class="btn btn-danger btn-shadow disabled" id="btn-mark-end"><?php echo $lang->end ?> <i class="fa fa-chevron-circle-down" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="alert-space alert-gesture-too-short"></div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $lang->imageExportEvery ?></span>
                            <input class="form-control item-input-text option-gesture show-dropdown readonly" type="text" value="80 <?php echo $lang->times->milliseconds ?>"/>
                            <div class="input-group-btn dropup select" id="keyframeSelect" role="group">
                                <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="keyframe_80"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                    <li id="keyframe_80"><a href="#">80 <?php echo $lang->times->milliseconds ?></a></li>
                                    <li id="keyframe_100"><a href="#">100 <?php echo $lang->times->milliseconds ?></a></li>
                                    <li id="keyframe_150"><a href="#">150 <?php echo $lang->times->milliseconds ?></a></li>
                                    <li id="keyframe_200"><a href="#">200 <?php echo $lang->times->milliseconds ?></a></li>
                                    <li id="keyframe_300"><a href="#">300 <?php echo $lang->times->milliseconds ?></a></li>
                                    <li id="keyframe_400"><a href="#">400 <?php echo $lang->times->milliseconds ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="btn-group-vertical btn-block">
                            <button class="btn btn-block btn-default btn-shadow btn-repeat-recording"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $lang->recordNewGesture ?></button>
                            <button class="btn btn-block btn-success btn-shadow disabled" id="btn-extract-gesture"><i class="glyphicon glyphicon-scissors"></i> <?php echo $lang->cutGesture ?></button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="preview-controls" class="hidden root">
                <div style="max-width: 600px">
                    <div class="previewGesture previewProgress autoplay embed-responsive embed-responsive-4by3" id="gesturePreview"></div>
                    <div class="progress gesture-progress">
                        <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                    </div>
                    <div class="text-center gestureControls">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="fa fa-play"></i></button>
                            <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="fa fa-stop"></i></button>
                            <button type="button" class="btn btn-default btn-shadow" id="btn-choose-preview-image"><i class="fa fa-bookmark" aria-hidden="true"></i> <span class="text"><?php echo $lang->selectPreviewImage ?></span></button>
                        </div>
                    </div>
                </div>

                <div class="text-center btn-group" style="margin-top: 10px;">
                    <button type="button" class="btn btn-default btn-shadow" id="btn-repeat-trimming"><i class="glyphicon glyphicon-scissors"></i> <?php echo $lang->recut ?></button>
                    <button type="button" class="btn btn-default btn-repeat-recording btn-shadow"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $lang->reRecord ?></button>
                </div>
            </div>

        </div>

        <div class="hidden" id="save-controls">
            <hr>
            <div>
                <div class="alert-space alert-missing-fields"></div>

                <div class="form-group" style="margin-top: 10px">
                    <label><?php echo $lang->gestureName ?></label>
                    <input type="text" class="form-control" id="gestureName" required>
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
                    <input type="text" class="form-control" placeholder="<?php echo $lang->gestureContextQuestion ?>" id="gestureContext" required>
                </div>

                <div class="form-group">
                    <label><?php echo $lang->gestureAssociation ?></label>
                    <textarea class="form-control" id="gestureAssociation" rows="3" maxlength="1000"  placeholder="<?php echo $lang->gestureAssociationQuestion ?>" required></textarea>
                </div>

                <div class="form-group">
                    <label><?php echo $lang->gestureDescription ?></label>
                    <textarea class="form-control" id="gestureDescription" rows="3" maxlength="1000" required></textarea>
                </div>

                <div class="form-group">
                    <label><?php echo $lang->gestureGraphicsQuestion ?></label>
                    <div class="select-joints-humand-body" id="human-body" style="width: 350px; margin: auto">
                        <div id="joint-container" style="position: absolute"></div>
                        <img src="img/human_body.svg">
                    </div>
                </div>

                <div class="alert-space alert-general-error"></div>
                <button class="btn btn-block btn-success btn-shadow disabled" id="btn-save-gesture"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo $lang->saveGesture ?></button>
            </div>
        </div>

        <div class="hidden root" id="success-controls">
            <div class="alert-space alert-gesture-save-success"></div>
            <div class="alert-space alert-general-error"></div>

            <div style="max-width: 600px; margin: auto">
                <div class="previewGesture previewProgress previewProgress autoplay embed-responsive embed-responsive-4by3"></div>
                <div class="progress gesture-progress">
                    <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                </div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="fa fa-stop"></i></button>
                    </div>
                </div>
            </div>

            <div class="btn-group-vertical btn-block" style="margin-top: 20px">
                <button class="btn btn-danger btn-shadow" id="btn-delete-saved-gesture"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo $lang->deleteSavedGesture ?></button>
                <button class="btn btn-default btn-shadow" id="btn-record-new-gesture"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php echo $lang->recordMoreGestures ?></button>
            </div>
        </div>

        <div class="hidden root" id="delete-success-controls">
            <div class="alert-space alert-gesture-delete-success"></div>

            <div class="btn-group-vertical btn-block" style="margin-top: 10px">
                <button class="btn btn-default btn-shadow" id="btn-record-new-gesture"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php echo $lang->recordGesture ?></button>
            </div>
        </div>
    </div>


    <div id="gesture-recorder-tester">
        <div class="alert-space alert-web-rtc-not-supported"></div>

        <div class="recorder text-center" style="border-radius: 4px; max-width: 500px; margin: auto">
            <video autoplay id="recorder-video" style="width: 100%; height: auto; overflow: hidden; border-top-left-radius: 4px; border-top-right-radius: 4px"></video>
            <div class="progress hidden" id="record-timer-progress" style="margin-top: -8px; height: 8px; border-top-left-radius: 0px; border-radius: 0px">
                <div class="progress-bar progress-bar-info" id="record-timer-progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%; width: 100%"></div>
            </div>

            <div class="gesture-recorder-controls">
                <div class="hidden" id="record-controls" style="margin-top: -20px">
                    <button class="btn btn-success btn-block btn-shadow hidden" id="btn-record" style="border-top-left-radius: 0px; border-top-right-radius: 0px;"><i class="glyphicon glyphicon-record" aria-hidden="true"></i> <?php echo $lang->startRecording ?></button>
                    <button class="btn btn-danger btn-block btn-shadow hidden" id="btn-record-stop" style="border-top-left-radius: 0px; border-top-right-radius: 0px; margin-top: -8px"><i class="glyphicon glyphicon-stop" aria-hidden="true"></i> <?php echo $lang->stopRecording ?></button>
                </div>
                <div class="hidden" id="playback-controls" style="margin-top: -8px">
                    <div class="progress" id="seek-bar" style="height: 8px; border-top-left-radius: 0px; border-radius: 0px">
                        <div class="progress-bar progress-bar-success" id="seek-bar-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%"></div>
                    </div>
                    <div class="progress" id="trim-bar" style="border-top-left-radius: 0px; border-top-right-radius: 0px; margin-top: -20px">
                        <div class="progress-bar progress-bar-danger" id="gesture-beginning" style="width: 100%; height: 100%"></div>
                        <div class="progress-bar progress-bar-info" id="gesture-execution" style="width: 0%; height: 100%"><?php echo $lang->gesture ?></div>
                        <div class="progress-bar progress-bar-danger" id="gesture-ending" style="width: 0%; height: 100%"></div>
                    </div>
                    <div class="form-group">
                        <div class="btn-group">
                            <button class="btn btn-default btn-shadow" id="btn-play"><i class="fa fa-play" aria-hidden="true"></i></button>
                            <button class="btn btn-default btn-shadow" id="btn-pause"><i class="fa fa-pause" aria-hidden="true"></i></button>
                            <button class="btn btn-default btn-shadow" id="btn-stop"><i class="fa fa-stop" aria-hidden="true"></i></button>
                            <button class="btn btn-success btn-shadow" id="btn-mark-start"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i> <?php echo $lang->start ?></button>
                            <button class="btn btn-danger disabled" id="btn-mark-end"><?php echo $lang->end ?> <i class="fa fa-chevron-circle-down" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="alert-space alert-gesture-too-short"></div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $lang->imageExportEvery ?></span>
                            <input class="form-control item-input-text option-gesture show-dropdown readonly" type="text" value="80 <?php echo $lang->times->milliseconds ?>"/>
                            <div class="input-group-btn dropup select" id="keyframeSelect" role="group">
                                <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="keyframe_80"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                    <li id="keyframe_80"><a href="#">80 <?php echo $lang->times->milliseconds ?></a></li>
                                    <li id="keyframe_100"><a href="#">100 <?php echo $lang->times->milliseconds ?></a></li>
                                    <li id="keyframe_150"><a href="#">150 <?php echo $lang->times->milliseconds ?></a></li>
                                    <li id="keyframe_200"><a href="#">200 <?php echo $lang->times->milliseconds ?></a></li>
                                    <li id="keyframe_300"><a href="#">300 <?php echo $lang->times->milliseconds ?></a></li>
                                    <li id="keyframe_400"><a href="#">400 <?php echo $lang->times->milliseconds ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="btn-group-vertical btn-block">
                            <button class="btn btn-block btn-default btn-shadow btn-repeat-recording"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $lang->recordNewGesture ?></button>
                            <button class="btn btn-block btn-success btn-shadow disabled" id="btn-extract-gesture"><i class="glyphicon glyphicon-scissors"></i> <?php echo $lang->cutGesture ?></button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="preview-controls" class="hidden root">
                <div class="alert-space alert-gesture-too-short"></div>

                <div style="max-width: 600px">
                    <div class="previewGesture autoplay mousePlayable embed-responsive embed-responsive-4by3" id="gesturePreview"></div>
                    <div class="progress gesture-progress">
                        <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                    </div>
                    <div class="text-center gestureControls">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="fa fa-play"></i></button>
                            <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="fa fa-stop"></i></button>
                            <button type="button" class="btn btn-default btn-shadow" id="btn-choose-preview-image"><i class="fa fa-bookmark" aria-hidden="true"></i> <span class="text"><?php echo $lang->selectPreviewImage ?></span></button>

                        </div>
                    </div>
                </div>

                <div class="text-center btn-group" style="margin-top: 10px;">
                    <button type="button" class="btn btn-default btn-shadow" id="btn-repeat-trimming"><i class="glyphicon glyphicon-scissors"></i> <?php echo $lang->recut ?></button>
                    <button type="button" class="btn btn-default btn-shadow btn-repeat-recording"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $lang->reRecord ?></button>
                </div>
            </div>

        </div>

        <div class="hidden" id="save-controls">
            <hr>
            <div>
                <div class="alert-space alert-missing-fields"></div>

                <div class="form-group" style="margin-top: 10px">
                    <label><?php echo $lang->gestureName ?></label>
                    <input type="text" class="form-control" id="gestureName" required>
                </div>

                <div class="form-group">
                    <label><?php echo $lang->gestureContext ?></label>
                    <input type="text" class="form-control" placeholder="<?php echo $lang->gestureContextQuestion ?>" id="gestureContext" required>
                </div>

                <div class="form-group">
                    <label><?php echo $lang->gestureAssociation ?></label>
                    <textarea class="form-control" id="gestureAssociation" rows="3" maxlength="1000"  placeholder="<?php echo $lang->gestureAssociationQuestion ?>" required></textarea>
                </div>

                <div class="form-group">
                    <label><?php echo $lang->gestureDescription ?></label>
                    <textarea class="form-control" id="gestureDescription" rows="3" maxlength="500" required></textarea>
                </div>

                <div class="form-group">
                    <label><?php echo $lang->gestureGraphicsQuestion ?></label>
                    <div class="select-joints-humand-body" id="human-body" style="width: 350px; margin: auto">
                        <div id="joint-container" style="position: absolute"></div>
                        <img src="img/human_body.svg">
                    </div>
                </div>

                <div class="alert-space alert-general-error"></div>
                <button class="btn btn-block btn-success btn-shadow disabled" id="btn-save-gesture"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo $lang->saveGesture ?></button>
            </div>
        </div>

        <div class="hidden root" id="success-controls">
            <div class="alert-space alert-gesture-save-success"></div>
            <div class="alert-space alert-general-error"></div>

            <div style="max-width: 600px; margin: auto">
                <div class="previewGesture previewProgress autoplay embed-responsive embed-responsive-4by3"></div>
                <div class="progress gesture-progress">
                    <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                </div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="fa fa-stop"></i></button>
                    </div>
                </div>
            </div>

            <button class="btn btn-danger btn-shadow" id="btn-delete-saved-gesture" style="margin-top: 20px"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo $lang->deleteSavedGesture ?></button>

        </div>

        <div class="hidden root" id="delete-success-controls">
            <div class="alert-space alert-gesture-delete-success"></div>

            <div class="btn-group-vertical btn-block" style="margin-top: 10px">
                <button class="btn btn-default btn-shadow" id="btn-record-new-gesture"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php echo $lang->recordGesture ?></button>
            </div>
        </div>
    </div>

    <div id="gesture-recorder-description" style="margin-bottom: 20px">
    </div>

    <div id="stateRecord">
        <h3 style="margin: 0" id="headline"><?php echo $lang->gestureRecorderManual->recordGesture->headline ?></h3>
        <hr>
        <p class="text" id="instructions">
            <?php echo $lang->gestureRecorderManual->recordGesture->description ?>
        </p>
    </div>

    <div id="statePlayback">
        <h3 style="margin: 0" id="headline"><?php echo $lang->gestureRecorderManual->previewTrimmingGesture->headline ?></h3>
        <hr>
        <div class="text" id="instructions">
            <p>
                <?php echo $lang->gestureRecorderManual->previewTrimmingGesture->descriptionPreview ?>
            </p>
            <p>
                <?php echo $lang->gestureRecorderManual->previewTrimmingGesture->descriptionTrimming ?>
            </p>
        </div>
    </div>

    <div id="stateSave">
        <h3 style="margin: 0" id="headline"><?php echo $lang->gestureRecorderManual->describeAndSave->headline ?></h3>
        <hr>
        <div class="text" id="instructions">
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

    <div id="stateSaveSuccess">
        <h3 style="margin: 0" id="headline"><?php echo $lang->gestureRecorderManual->savedGesture->headline ?></h3>
        <hr>
        <div class="text" id="instructions">
            <p>
                <?php echo $lang->gestureRecorderManual->savedGesture->description ?>
            </p>
        </div>
    </div>

    <div id="stateDeleteSuccess">
        <h3 style="margin: 0" id="headline"><?php echo $lang->gestureRecorderManual->deletedGesture->headline ?></h3>
        <hr>
        <div class="text" id="instructions">
            <p>
                <?php echo $lang->gestureRecorderManual->deletedGesture->description ?>
            </p>
        </div>
    </div>

</div>