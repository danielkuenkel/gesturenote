<?php
include '../includes/language.php';
?>

<div id="item-container-moderator" class="hidden">

    <!--    <div id="moderator-web-rtc-placeholder" class="web-rtc-placeholder embed-responsive embed-responsive-4by3" style="position: absolute">
            <div class="root embed-responsive embed-responsive-4by3" style="background-color: #eeeeee; border-top-left-radius: 5px; border-top-right-radius: 5px">
            <div class="embed-responsive-item" style="border-radius: 8px; background-color: #eee;display: flex; justify-content: center; align-items: center;">
                <i class="fa fa-circle-o-notch fa-spin fa-3x"></i>
            </div>
    
            <div class="embed-responsive-item" id="alerts-container" style="padding: 15px">
                <div class="alert-space alert-rtc-permission-denied"></div>
            </div>
    
            <div class="embed-responsive-item">
                <video class="recorder-webcam-video mirroredHorizontally" autoplay ></video>
            </div>
    
    
                    <div id="remote-stream" class="rtc-remote-container rtc-stream embed-responsive-item" style="border-radius: 8px;"></div>
                    <div class="rtc-local-container embed-responsive-item">
                        <video autoplay id="local-stream" class="rtc-stream" style="display:block;"></video>
                    </div>
            <div class="btn-group" id="stream-controls" style="position: absolute; bottom: 6px; left: 50%; transform: translate(-50%, 0); opacity: 0">
                <button type="button" class="btn btn-sm stream-control disabled" id="btn-stream-local-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->muteMicrofone ?>"><i class="fa fa-microphone-slash"></i> </button>
                <button type="button" class="btn btn-sm stream-control disabled" id="btn-pause-stream" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOwnWebRTC ?>"><i class="fa fa-pause"></i> </button>
                <button type="button" class="btn btn-sm stream-control disabled" id="btn-stream-remote-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOtherWebRTC ?>"><i class="fa fa-volume-up"></i> </button>
                <button type="button" class="btn btn-sm stream-control pinned" id="btn-toggle-rtc-fixed" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->dragRTC ?>"><i class="fa fa-window-restore"></i> </button>
                <button type="button" class="btn btn-sm stream-control" id="btn-config-rtc" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->configRTC ?>"><i class="fa fa-cog"></i> </button>
            </div>
    
            <div class="record-stream-indicator" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->recordingStream ?>"><i class="fa fa-video-camera"></i></div>
    
            <div id="stream-control-indicator">
                <div style="position: absolute; top: 4px; display: block; left: 10px; opacity: 1; color: white">
                    <i id="mute-local-audio" class="hidden fa fa-microphone-slash" style="margin-right: 3px"></i>
                    <i id="pause-local-stream" class="hidden fa fa-pause"></i>
                </div>
                <div style="position: absolute; top: 4px; display: block; right: 10px; opacity: 1; color: white">
                    <i id="mute-remote-audio" class="hidden fa fa-microphone-slash"></i>
                    <i id="pause-remote-stream" class="hidden fa fa-pause" style="margin-left: 3px"></i>
                </div>
            </div>
    
            <div id="rtc-config-panel" class="hidden" style="border-radius: 8px; background-color: rgba(0,0,0,.4); padding: 15px 15px 0px 15px; position: absolute; top:0px; bottom:0px; left: 0px; right: 0px">
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
                <div class="form-group" id="audio-input-select">
                    <label style="margin: 0; color: white"><?php echo $lang->chooseAudioInput ?></label><br>
    
                    <div class="input-group">
                        <input class="form-control item-input-text show-dropdown" tabindex="-1" type="text" value=""/>
                        <div class="input-group-btn select select-audio-input" role="group">
                            <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            </ul>
                        </div>
                    </div>
                </div>
    
                <button class="btn btn-default btn-block btn-shadow" id="btn-close-config"><i class="fa fa-check"></i></button>
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
        </div>-->




    <div id="moderator-web-rtc-placeholder" class="web-rtc-placeholder embed-responsive embed-responsive-4by3" style="position: absolute">

        <img class="embed-responsive-item" src="img/web-rtc-placeholder.png" style="width: 30%; height: auto; box-shadow: 0 0 10px rgba(0,0,0,.2); border-radius: 5px; left: 5px; top: 5px;">
        <div style="left: 10px; top: 2px; position: absolute;"><?php echo $lang->userTypes->evaluator ?></div>
        </img>

        <div style="right: 10px; top: 2px; position: absolute;"><?php echo $lang->userTypes->tester ?></div>


        <img class="embed-responsive-item" src="img/web-rtc-placeholder.png" width="100%" height="auto"/>
        <div class="btn-group stream-controls" id="stream-controls" style="position: absolute; bottom: 6px; left: 50%; transform: translate(-50%, 0); opacity: 0; display:flex">
            <button type="button" class="btn btn-sm stream-control" id="btn-stream-local-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->muteMicrofone ?>"><i class="fa fa-microphone-slash"></i> </button>
            <button type="button" class="btn btn-sm stream-control" id="btn-pause-stream" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOwnWebRTC ?>"><i class="fa fa-pause"></i> </button>
            <button type="button" class="btn btn-sm stream-control" id="btn-stream-remote-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOtherWebRTC ?>"><i class="fa fa-volume-up"></i> </button>
            <button type="button" class="btn btn-sm stream-control pinned" id="btn-toggle-rtc-fixed" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->dragRTC ?>"><i class="fa fa-window-restore"></i> </button>
        </div>
        <div class="hidden record-stream-indicator" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->recordingStream ?>"><i class="fa fa-video-camera"></i></div>

        <img class="hidden" src="img/resize.png" id="resize-sign" style="position: absolute; bottom: 0; right: 0;"/>
    </div>

    <!-- alerts -->
    <div class="row root" id="no-phase-data">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <div class="alert-space alert-no-phase-data"></div>
            <button class="btn btn-success pull-right" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <!-- execution preparation -->
    <div class="container root" id="executionPreparation">
        <div class="row">
            <div class="col-xs-12">
                <h2 id="preparation-study-headline" style="margin-top: 0; margin-bottom: 0px"></h2>
                <div class="label label-default" id="preparation-type-phase"></div>
                <div class="label label-default" id="preparation-type-survey"></div>
            </div>
        </div>

        <div class="row" id="preparation-study-details" style="margin-bottom: 15px">
            <div class="col-sm-5 col-md-6 col-lg-5" style="margin-bottom: 40px">
                <div id="preparation-study-description">
                    <h3 class="address"></h3>
                    <p class="text"></p>
                </div>

                <div class="hidden preparation-study-plan"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>
            </div>

            <div class="col-sm-7 col-md-6 col-lg-7">

                <div id="preparation-alert-hints" class="">
                    <div class="alert-space alert-study-over-range"></div>
                    <div class="alert-space alert-study-under-range"></div>
                    <div class="alert-space alert-study-unmoderated"></div>
                    <div class="alert-space alert-web-rtc-not-supported"></div>
                    <div class="alert-space alert-another-browser-needed-for-web-rtc"></div>
                    <div class="alert-space alert-contact-support"></div>
                </div>

                <div id="preparation-role-selection-container" class="">
                    <h3><?php echo $lang->roleSelection ?></h3>
                    <div class="alert-space alert-select-role-hint"></div>
                    <div class="alert-space alert-duplicated-role-detected"></div>
                    <div class="form-group root preparation-roleSelect">
                        <!--                            <label style="margin: 0">
                                                        <span><?php echo $lang->roleSelection ?></span> 
                                                        <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->physicalStressTestSingleGraphic ?>"></i>
                                                    </label><br>-->

                        <div class="btn-group" id="radio" style="">
                            <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="moderator">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin hidden" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle" id="checked"></i>
                                </span>
                                <span class="option-text"><?php echo $lang->userTypes->evaluator ?></span>
                            </button>
                        </div>
                        <div class="btn-group" id="radio" style="">
                            <button class="btn btn-default btn-radio disabled" name="primary" id="observer">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text"><?php echo $lang->userTypes->observer ?></span>
                            </button>
                        </div>
                        <div class="btn-group" id="radio" style="">
                            <button class="btn btn-default btn-radio disabled" name="primary" id="wizard">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text"><?php echo $lang->userTypes->wizard ?></span>
                            </button>
                        </div>

                    </div>

                    <button class="btn btn-block btn-default btn-shadow" id="btn-preparation-check-rtc"><?php echo $lang->applySelection ?></button>
                </div>

                <div id="preparation-check-rtc-status" class="hidden">
                    <h3><?php echo $lang->technicalTest ?></h3>
                    <div class="check-web-rtc">
                        <span class="status-check-indicator">
                            <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                            <i class="status-warn fa fa-warning warning hidden"></i>
                            <i class="status-supported fa fa-check success hidden"></i>
                        </span>
                        <span class="status-check-text text"><?php echo $lang->webrtc ?></span>
                    </div>
                    <div class="check-webcam">
                        <span class="status-check-indicator">
                            <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                            <i class="status-warn fa fa-warning warning hidden"></i>
                            <i class="status-supported fa fa-check success hidden"></i>
                        </span>
                        <span class="status-check-text text"><?php echo $lang->webcam ?></span>
                    </div>
                    <div class="check-microphone">
                        <span class="status-check-indicator">
                            <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                            <i class="status-warn fa fa-warning warning hidden"></i>
                            <i class="status-supported fa fa-check success hidden"></i>
                        </span>
                        <span class="status-check-text text"><?php echo $lang->audioInput ?></span>
                    </div>
                    <div class="check-speakers">
                        <span class="status-check-indicator">
                            <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                            <i class="status-warn fa fa-warning warning hidden"></i>
                            <i class="status-supported fa fa-check success hidden"></i>
                        </span>
                        <span class="status-check-text text"><?php echo $lang->audioOutput ?></span>
                    </div>
                    <div class="check-screen-capturing">
                        <span class="status-check-indicator">
                            <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                            <i class="status-warn fa fa-warning warning hidden"></i>
                            <i class="status-supported fa fa-check success hidden"></i>
                        </span>
                        <span class="status-check-text text"><?php echo $lang->screensharing ?></span>
                    </div>
                </div>

                <div id="preparation-participation-queue" class="hidden" style="margin-top: 40px">
                    <h3><?php echo $lang->waitingParticipants ?></h3>
                    <div class="alert-space alert-select-participant-hint"></div>

                    <div class="form-group hidden root preparation-iceTransportsSelect">
                        <label style="margin: 0">
                            <span><?php echo $lang->bypassFirewall ?></span> 
                            <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->execution->bypassFirewall ?>"></i>
                        </label><br>

                        <div class="btn-group" id="radio" style="">
                            <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="no">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin hidden" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle" id="checked"></i>
                                </span>
                                <span class="option-text"><?php echo $lang->no ?></span>
                            </button>
                        </div>
                        <div class="btn-group" id="radio" style="">
                            <button class="btn btn-default btn-radio" name="primary" id="yes">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text"><?php echo $lang->yes ?></span>
                            </button>
                        </div>

                    </div>

                    <div class="alert-space alert-search-participation-requests"></div>
                    <div id="preparation-list-container" class="row">
                        <div class="root col-xs-12" id="dummy-participant">
                            <div class="panel panel-shadow panel-sm btn-shadow">
                                <div class="panel-body">
                                    <span id="" style="font-size: 9pt;"><span class="" style="font-weight: bold; color: black;">Max Mustermann</span> <span class=""><?php echo $lang->waiting ?>:</span> <span class="text">5M 12s</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="preparation-call-screen" class="row hidden">

                    <div class="col-xs-12">
                        <div class="alert-space alert-welcome-participant-hint"></div>

                        <div class="embed-responsive embed-responsive-4by3" id="preparation-video-caller">
                            <img class="embed-responsive-item" src="img/web-rtc-placeholder.png" style="width: 30%; height: auto; box-shadow: 0 0 10px rgba(0,0,0,.2); border-radius: 5px; left: 5px; top: 5px;">
                            <div style="left: 10px; top: 2px; position: absolute;"><?php echo $lang->userTypes->evaluator ?></div>
                            </img>

                            <div style="right: 10px; top: 2px; position: absolute;"><?php echo $lang->userTypes->tester ?></div>

                            <img class="embed-responsive-item" src="img/web-rtc-placeholder.png" width="100%" height="auto" style="border-radius:8px; border: 1px solid #eeeeee;"/>
                            <!--                            <div class="embed-responsive-item" style="border-radius: 8px; background-color: #eee;display: flex; justify-content: center; align-items: center;">
                                                            <i class="fa fa-circle-o-notch fa-spin fa-3x"></i>
                                                        </div>
                                                        <div id="preparation-remote-stream" class="rtc-remote-container rtc-stream embed-responsive-item" style="border-radius: 8px;"></div>
                                                        <div class="rtc-local-container embed-responsive-item">
                                                            <video autoplay id="preparation-local-stream" class="preparation-rtc-stream" style="display:block;"></video>
                                                        </div>
                                                        <div class="btn-group" id="preparation-stream-controls" style="position: absolute; bottom: 6px; left: 50%; transform: translate(-50%, 0); opacity: 0">
                                                            <button type="button" class="btn btn-sm stream-control" id="btn-preparation-stream-local-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->muteMicrofone ?>"><i class="fa fa-microphone-slash"></i> </button>
                                                            <button type="button" class="btn btn-sm stream-control" id="btn-preparation-pause-stream" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOwnWebRTC ?>"><i class="fa fa-pause"></i> </button>
                                                            <button type="button" class="btn btn-sm stream-control" id="btn-preparation-stream-remote-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOtherWebRTC ?>"><i class="fa fa-volume-up"></i> </button>
                                                            <button type="button" class="btn btn-sm stream-control" id="btn-preparation-config-rtc" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->configRTC ?>"><i class="fa fa-cog"></i> </button>
                                                        </div>
                            
                                                        <div id="preparation-stream-control-indicator">
                                                            <div style="position: absolute; top: 4px; display: block; left: 10px; opacity: 1; color: white">
                                                                <i id="preparation-mute-local-audio" class="hidden fa fa-microphone-slash" style="margin-right: 3px"></i>
                                                                <i id="preparation-pause-local-stream" class="hidden fa fa-pause"></i>
                                                            </div>
                                                            <div style="position: absolute; top: 4px; display: block; right: 10px; opacity: 1; color: white">
                                                                <i id="preparation-mute-remote-audio" class="hidden fa fa-microphone-slash"></i>
                                                                <i id="preparation-pause-remote-stream" class="hidden fa fa-pause" style="margin-left: 3px"></i>
                                                            </div>
                                                        </div>
                            
                                                        <div id="preparation-rtc-config-panel" class="hidden" style="border-radius: 8px; background-color: rgba(0,0,0,.4); padding: 15px 15px 0px 15px; position: absolute; top:0px; bottom:0px; left: 0px; right: 0px">
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
                                                            <div class="form-group" id="audio-input-select">
                                                                <label style="margin: 0; color: white"><?php echo $lang->chooseAudioInput ?></label><br>
                            
                                                                <div class="input-group">
                                                                    <input class="form-control item-input-text show-dropdown" tabindex="-1" type="text" value=""/>
                                                                    <div class="input-group-btn select select-audio-input" role="group">
                                                                        <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                                                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                            
                                                            <button class="btn btn-default btn-block btn-shadow" id="btn-close-config"><i class="fa fa-check"></i></button>
                                                        </div>-->

                        </div>



                    </div>
                    <div class="col-xs-12 hidden" id="preparation-technical-check" style="margin-top: 10px">
                        <div id="preparation-initialize-recorders-list" class="text-center"></div>
                    </div>
                    <div class="col-xs-12 text-center" style="margin-top: 10px;">
                        <div class="btn-group">
                            <button class="btn btn-danger btn-shadow" id="btn-preparation-close-call"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
                            <button class="btn btn-success btn-shadow" id="btn-preparation-enter-study"><i class="fa fa-chevron-right"></i> <?php echo $lang->enterStudyAsModerator ?></button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>


    <!-- questionnaire container -->
    <div class="row root" id="questionnaire">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <h3 style="margin-top: 0"><?php echo $lang->questionnaire ?></h3>
            <div class="question-container"></div>
            <div class="clearfix" style="margin-top: 10px; margin-bottom: 15px">
                <button class="next-step btn btn-success btn-block pull-right disabled" id="btn-next-step" style="margin-top: 10px; "><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
            </div>
        </div>
    </div>


    <!-- interview container -->
    <div class="row root" id="interview">
        <div class="col-md-4 rtc-scalable" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <h3 style="margin-top: 0"><?php echo $lang->formats->interview->text ?></h3>
            <div class="question-container"></div>
            <div class="clearfix" style="margin-top: 10px;  margin-bottom: 15px">
                <button class="btn btn-success btn-shadow hidden btn-next-question pull-right"><?php echo $lang->next ?> <span aria-hidden="true">&rarr;</span></button>
                <button class="btn btn-success btn-shadow hidden btn-questionnaire-done pull-right" id="btn-next-step"><i class="fa fa-check"></i> <?php echo $lang->done ?></button>
            </div>
            <!--<button class="next-step btn btn-success btn-block pull-right" id="btn-next-step" style="margin-top: 10px"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>-->
        </div>
    </div>


    <!-- single question format items -->
    <span class="label label-default" id="option-item" style="margin-right: 3px; display: inline-block"></span>

    <div id="rating-item">
        <span id="rating-header"></span> 
        <!--<span class="label label-danger hidden" id="reversed"><?php echo $lang->negated ?></span>-->
        <div id="scales-container" style="margin-top: -6px;"></div>
    </div>


    <!-- single question formats -->
    <div class="panel panel-default panel-shadow root" id="counter" style="margin-bottom: 5px;">
        <div class="panel-body">
            <!--<span class="label label-default" id="format"><span class="format-text"></span></span>-->
            <div class="question text"></div>
            <!--<span class="label label-default" id="counter-label"><span class="counter-from"></span> <span class="counter-to"></span></span>-->
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="openQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <!--<span class="label label-default" id="format"><span class="format-text"></span></span>-->
            <div class="question text"></div>
            <span class="label label-default hidden" id="dimension"></span>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="openQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div class="question text"></div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <!--                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">-->
                <div class="label label-primary" id="factor-primary"></div>
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="dichotomousQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <!--<span class="label label-default" id="format"><span class="format-text"></span></span>-->
            <div class="question text"></div>
<!--            <span class="label label-default hidden" id="select-gestures"><?php echo $lang->selectOneOrMoreGestures ?></span>
            <span class="label label-default hidden" id="justification"><?php echo $lang->withJustification ?></span>
            <span class="label label-default hidden" id="no-justification"><?php echo $lang->withoutJustification ?></span>
            <span class="label label-default hidden" id="yes"><?php echo $lang->justificationForYes ?></span>
            <span class="label label-default hidden" id="no"><?php echo $lang->justificationForNo ?></span>
            <span class="label label-default hidden" id="always"><?php echo $lang->justificationAlways ?></span>-->
            <span class="label label-default hidden" id="dimension"></span>
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="dichotomousQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <!--<span class="label label-default" id="format"><span class="format-text"></span></span>-->
            <div class="question text"></div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <!--                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">-->
                <div class="label label-primary" id="factor-primary"></div>
            </div>
<!--            <span class="label label-default hidden" id="select-gestures"><?php echo $lang->selectOneOrMoreGestures ?></span>
            <span class="label label-default hidden" id="justification"<?php echo $lang->withJustification ?></span>
            <span class="label label-default hidden" id="no-justification"><?php echo $lang->withoutJustification ?></span>
            <span class="label label-default hidden" id="yes"><?php echo $lang->justificationForYes ?></span>
            <span class="label label-default hidden" id="no"><?php echo $lang->justificationForNo ?></span>
            <span class="label label-default hidden" id="always"><?php echo $lang->justificationAlways ?></span>-->
            <span class="label label-default hidden" id="dimension"></span>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="alternativeQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <!--<span class="label label-default" id="format"><span class="format-text"></span></span>-->
            <div class="question text"></div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <!--                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">-->
                <div class="label label-primary" id="factor-primary"></div>
            </div>
<!--            <span class="label label-default hidden" id="optionalanswer"><?php echo $lang->ownAnswerAllowed ?></span>
            <span class="label label-default hidden" id="justification"><?php echo $lang->withJustification ?></span>
            <span class="label label-default hidden" id="no-justification"><?php echo $lang->withoutJustification ?></span>
            <span class="label label-default hidden" id="selectOne"><?php echo $lang->justificationForAChoice ?></span>
            <span class="label label-default hidden" id="selectNothing"><?php echo $lang->justificationNoChoice ?></span>
            <span class="label label-default hidden" id="always"><?php echo $lang->justificationAlways ?></span>
            <span class="label label-default hidden" id="gesturesForGesture"><?php echo $lang->alternativeGesturesForGesture ?></span>
            <span class="label label-default hidden" id="triggersForGesture"><?php echo $lang->alternativeTriggerForGesture ?></span>
            <span class="label label-default hidden" id="triggersForTrigger"><?php echo $lang->alternativeTriggerForTrigger ?></span>
            <span class="label label-default hidden" id="gesturesForTrigger"><?php echo $lang->alternativeGesturesForTrigger ?></span>-->
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="groupingQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <!--<span class="label label-default" id="format"><span class="format-text"></span></span>-->
            <div class="question text"></div>
<!--            <span class="label label-default hidden" id="multiselect"><?php echo $lang->multipleSelectionsAllowed ?></span>
            <span class="label label-default hidden" id="singleselect"><?php echo $lang->singleSelectionsAllowed ?></span>
            <span class="label label-default hidden" id="justification"><?php echo $lang->withJustification ?></span>
            <span class="label label-default hidden" id="no-justification"><?php echo $lang->withoutJustification ?></span>
            <span class="label label-default hidden" id="selectOne"><?php echo $lang->justificationForAChoice ?></span>
            <span class="label label-default hidden" id="selectNothing"><?php echo $lang->justificationNoChoice ?></span>
            <span class="label label-default hidden" id="always"><?php echo $lang->justificationAlways ?></span>
            <span class="label label-default hidden" id="optionalanswer"><?php echo $lang->ownAnswerAllowed ?></span>-->
            <span class="label label-default hidden" id="dimension"></span>
            <div><?php echo $lang->groupingOptions ?></div>
            <div class="option-container" style="display: grid"></div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="groupingQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <!--<span class="label label-default" id="format"><span class="format-text"></span></span>-->
            <div class="question text"></div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <!--                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">-->
                <div class="label label-primary" id="factor-primary"></div>
            </div>
<!--            <span class="label label-default hidden" id="multiselect"><?php echo $lang->multipleSelectionsAllowed ?></span>
            <span class="label label-default hidden" id="singleselect"><?php echo $lang->singleSelectionsAllowed ?></span>
            <span class="label label-default hidden" id="justification"><?php echo $lang->withJustification ?></span>
            <span class="label label-default hidden" id="no-justification"><?php echo $lang->withoutJustification ?></span>
            <span class="label label-default hidden" id="selectOne"><?php echo $lang->justificationForAChoice ?></span>
            <span class="label label-default hidden" id="selectNothing"><?php echo $lang->justificationNoChoice ?></span>
            <span class="label label-default hidden" id="always"><?php echo $lang->justificationAlways ?></span>
            <span class="label label-default hidden" id="optionalanswer"><?php echo $lang->ownAnswerAllowed ?></span>-->
            <div><?php echo $lang->groupingOptions ?></div>
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="groupingQuestionOptions" style="margin-bottom: 5px;">
        <div class="panel-body">
            <!--<span class="label label-default" id="format"><span class="format-text"></span></span>-->
            <div class="question text"></div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <!--                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">-->
                <div class="label label-primary" id="factor-primary"></div>
            </div>
<!--            <span class="label label-default hidden" id="multiselect"><?php echo $lang->multipleSelectionsAllowed ?></span>
            <span class="label label-default hidden" id="singleselect"><?php echo $lang->singleSelectionsAllowed ?></span>
            <span class="label label-default hidden" id="justification"><?php echo $lang->withJustification ?></span>
            <span class="label label-default hidden" id="no-justification"><?php echo $lang->withoutJustification ?></span>
            <span class="label label-default hidden" id="selectOne"><?php echo $lang->justificationForAChoice ?></span>
            <span class="label label-default hidden" id="selectNothing"><?php echo $lang->justificationNoChoice ?></span>
            <span class="label label-default hidden" id="always"><?php echo $lang->justificationAlways ?></span>
            <span class="label label-default hidden" id="optionalanswer"><?php echo $lang->ownAnswerAllowed ?></span>-->
            <div><?php echo $lang->groupingOptions ?></div>
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="rating" style="margin-bottom: 5px;">
        <div class="panel-body">
            <!--<span class="label label-default" id="format"><span class="format-text"></span></span>-->
            <div class="question text"></div>
            <span class="label label-default hidden" id="dimension"></span>
            <div><?php echo $lang->ratingOptions ?></div>
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="sumQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div class="question text"></div>
            <span class="label label-default hidden" id="dimension"></span>
            <div id="distribution-container"></div>
            <div><?php echo $lang->sumQuestionAnswers ?> </div>
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="ranking" style="margin-bottom: 5px;">
        <div class="panel-body">
            <!--<span class="label label-default" id="format"><span class="format-text"></span></span>-->
            <div class="question text"></div>
            <span class="label label-default hidden" id="dimension"></span>
            <div><?php echo $lang->rankingOptions ?></div>
            <div class="option-container"></div>
        </div>
    </div>


    <!-- SUS container & item -->
    <div class="row root" id="sus">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <h3 class="headline" style="margin-top: 0"></h3>
            <div class="question-container"></div>
            <div class="clearfix" style="margin-top: 10px; margin-bottom: 15px">
                <button class="next-step btn btn-success btn-block pull-right disabled" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="susItem" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="question text"></span> 
            <span class="label label-danger hidden" id="reversed" style="margin-left: 4px"><?php echo $lang->negated ?></span>
        </div>
    </div>

    <div class="row root" id="ueq">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <h3 class="headline" style="margin-top: 0"></h3>
            <div class="question-container" ></div>
            <div class="clearfix" style="margin-top: 10px; margin-bottom: 15px">
                <button class="next-step btn btn-success btn-block pull-right disabled" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
            </div>
        </div>
    </div>

    <!--    <div class="panel panel-default root" id="ueqItem" style="margin-bottom: 5px;">
            <div class="panel-body">
                <span class="question text"></span> 
                <span class="label label-danger hidden" id="reversed" style="margin-left: 4px"><?php echo $lang->negated ?></span>
            </div>
        </div>-->


    <!-- GUS container & item -->
    <div class="row root" id="gus">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px" ></div>
        <div class="col-md-8" id="column-right" style="margin-bottom: 15px" >
            <h3 style="margin-top: 0"><?php echo $lang->gus ?></h3>
            <div class="row">
                <div class="col-sm-6">
                    <div id="gesture"><span class="address"></span> <span class="text"></span></div>
                    <div id="trigger"><span class="address"></span> <span class="text"></span></div>
                    <div id="feedback"><span class="address"></span> <span class="text"></span></div>
                </div>

                <div class="col-sm-6">
                    <div class="previewGesture autoplay mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
                    <div class="text-center gestureControls">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                            <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 question-container" style="margin-top: 10px"></div>
            </div>
            <div class="clearfix" style="margin-top: 10px; margin-bottom: 15px">
                <button class="next-step btn btn-success btn-block pull-right disabled" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="gusSingle" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
            <div style="display: inline;">
                <div class="hidden" id="item-factors" style="display: inline-block">
                    <div class="label label-primary" id="factor-primary"></div>
                </div>
                <div class="label label-danger hidden" id="reversed" style="display: inline-block"><?php echo $lang->negated ?></div>
            </div>
        </div>
    </div>

    <!-- gesture questionnaire container -->
    <div class="row root" id="questionnaireGestures">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">

            <h3 style="margin-top: 0"><?php echo $lang->gus ?></h3>

            <div class="question-container"></div>

            <div class="clearfix" style="margin-top: 10px; margin-bottom: 15px">
                <button class="next-step btn btn-success btn-block pull-right disabled" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
            </div>
        </div>
    </div>


    <div class="row root" id="letterOfAcceptance">
        <div class="col-md-6 col-lg-4 rtc-scalable" id="column-left">
        </div>
        <div class="col-md-6 col-lg-8" id="column-right" style="margin-bottom: 15px">
            <div class="">
                <div class="">
                    <h3 style="margin-top: 0"><?php echo $lang->formats->letterOfAcceptance->text ?></h3>
                </div>
                <div class="">
                    <p class="text letter-text" style="white-space:pre-wrap;"></p>
                    <div class="alert-space alert-please-wait"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row root" id="thanks">

        <div class="col-sm-5 col-md-4 rtc-scalable" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-sm-7 col-md-8" id="column-right" style="margin-bottom: 15px;">
            <h3 class="headline" style="margin-top: 0"><?php echo $lang->thanksHeadline ?></h3>
            <div class="row " style="margin-top: 20px">

                <div class="col-sm-12" id="upload-instructions" style="margin-bottom: 20px;">
                    <i class="fa fa-upload" aria-hidden="true" style="font-size: 70pt; color: #777"></i>
                    <div class="text">
                        <?php echo $lang->thanksWait ?>
                    </div>
                    <div id="rtc-uploads-status" class="hidden text" style="margin-top: 20px">
                        <div id="progress-thanks" class="">
                            <label><?php echo $lang->transferData ?>:</label>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
                                    0%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 hidden" id="upload-retry" style="margin-bottom: 20px;">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size: 70pt; color: #d9534f"></i>
                    <div class="text">
                        <p><?php echo $lang->thanksSaveError ?></p>
                        <button type="button" class="btn btn-danger btn-shadow" id="btn-retry-upload"><i class="fa fa-refresh" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->thanksResave ?></span></button>
                    </div>
                </div>
                <div class="col-sm-12 hidden" style="margin-bottom: 20px;" id="upload-done">
                    <i class="fa fa-check" aria-hidden="true" style="font-size: 70pt; color: #5cb85c"></i>
                    <div class="text">
                        <?php echo $lang->thanksSaveSuccess ?>
                    </div>
                </div>
            </div>

            <button class="btn btn-success btn-block btn-shadow hidden" id="btn-leave-survey"><?php echo $lang->leaveExecution ?></button>
        </div>
    </div>


    <!-- gesture training container -->
    <div class="row root" id="gestureTraining">
        <div class="col-md-6 col-lg-5 rtc-scalable" id="column-left" style="margin-bottom: 20px">
            <div class="" id="observations">
                <h3 class="panel-heading-text"><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>                  
            </div>
        </div>
        <div class="col-md-6 col-lg-7" id="column-right" style="margin-bottom: 15px">
            <div id="general" class="hidden">
                <h3 class="headline" style="margin-top: 0"></h3>    
                <div class="text read-aloud"><span class="read-aloud-icon" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->readAloudText ?>"><i class="fa fa-info-circle text btn-show-info"></i></span> <span class="read-aloud-text" id="description"></span></div>

                <div style="margin-top: 6px">
                    <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-start-training" style=""><?php echo $lang->startNow ?></button>
                    <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-open-prototype" style=""><?php echo $lang->openPrototype ?></button>
                    <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-start-screen-sharing" style=""><i class="fa"></i> <?php echo $lang->startScreensharing ?></button>
                </div>
            </div>

            <div id="training" class="hidden">
                <h3 class="headline" style="margin-top: 0px"></h3>
                <div id="trainingContainer"></div>
                <div class="alert-space alert-no-phase-data"></div>
            </div>

            <div class="alert-space alert-quit-screen-sharing"></div>
            <div class="alert-space alert-phase-step-done"></div>
            <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-stop-screen-sharing" style="margin-top: 0px;"><?php echo $lang->stopScreensharing ?></button>
            <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-done-training" style="margin-top: 0px;"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></button>
        </div>
    </div>

    <div class="row root"  id="trainingItem">
        <div class="col-xs-5 col-sm-6 col-md-4">
            <div id="thumbnail-container" class="row"></div>
            <div class="" style="margin-top: 0px">
                <button type="button" class="btn btn-default btn-block btn-shadow" id="btn-show-gesture" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->execution->trainingShowGesture ?>"><span class="btn-text"><?php echo $lang->request ?></span></button>
                <button type="button" class="btn btn-default btn-block btn-shadow hidden" id="btn-quit-gesture-preview" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->execution->trainingHideGesture ?>"><i class="fa"></i> <span class="btn-text"><?php echo $lang->quitGesturePreview ?></span></button>
            </div>

        </div>
        <div class="col-xs-7 col-sm-6 col-md-8">
            <div id="training-info" class="hidden">
                <div class="text read-aloud"><span class="read-aloud-icon" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->readAloudText ?>"><i class="fa fa-info-circle text btn-show-info"></i></span> <span class="read-aloud-text" id="training-description"></span></div>
<!--                <div id="trigger"><span class="address"><?php echo $lang->trigger ?>:</span> <span class="text"></span></div>
                <div id="repeats" style="margin-top: -6px"><span class="address"><?php echo $lang->repeats ?>:</span> <span class="text"></span></div>-->
            </div>
            <div id="transition-scenes" style="margin-top: 10px">
                <div class="bs-example hidden" id="start-scene">
                    <div class="bs-example-headline"><?php echo $lang->stateCharts->inputState ?></div>
                    <div class="bs-example-body" id="start-scene-container"></div>
                </div>
                <div class="bs-example hidden" id="transition-feedback" style="margin-top: 10px">
                    <div class="bs-example-headline"><?php echo $lang->stateCharts->transitionFeedback ?></div>
                    <div class="bs-example-body" id="transition-feedback-container"></div>
                </div>
                <div class="bs-example hidden" id="transition-scenes" style="margin-top: 10px">
                    <div class="bs-example-headline"><?php echo $lang->stateCharts->intermediateStates ?></div>
                    <div class="bs-example-body" id="transition-scene-container"></div>
                </div>
                <div class="bs-example hidden" id="follow-scenes" style="margin-top: 10px">
                    <div class="bs-example-headline"><?php echo $lang->stateCharts->entryAction ?></div>
                    <div class="bs-example-body" id="follow-scene-container"></div>
                </div>
            </div>

            <!--<button type="button" class="btn btn-default btn-shadow btn-block hidden" id="btn-repeat-training"  style="margin-top: 10px"><span class="btn-text"><?php echo $lang->repeatTraining ?></span></button>-->
        </div>
        <div class="col-xs-12 hidden" id="next-training-controls">
            <hr>
            <button type="button" class="btn btn-success btn-shadow btn-block hidden" id="btn-next-gesture"><span class="btn-text"><?php echo $lang->nextGesture ?></span> <span aria-hidden="true">&rarr;</span></button>
            <button type="button" class="btn btn-success btn-shadow btn-block hidden" id="btn-no-more-training-items"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>



    <!-- slideshow container -->

    <div class="row root" id="gestureSlideshow">
        <div class="col-md-5 rtc-scalable" id="column-left">
            <div class="" id="observations">
                <h3 class="panel-heading-text"><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>
            </div>
        </div>
        <div class="col-md-7" id="column-right" style="margin-bottom: 15px">
            <div class="" id="general" class="hidden">
                <h3 class="headline" style="margin-top: 0px"></h3>
                <div class="text read-aloud"><span class="read-aloud-icon" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->readAloudText ?>"><i class="fa fa-info-circle text btn-show-info"></i></span> <span class="read-aloud-text" id="description"></span></div>
                <button type="button" class="btn btn-success btn-block btn-shadow" id="btn-show-overview" style="margin-top: 6px;"><?php echo $lang->startNow ?></button>
            </div>

            <div id="slides" class="hidden">
                <h3 class="headline" style="margin-top: 0px"><?php echo $lang->overview ?></h3>
                <div class="text read-aloud"><span class="read-aloud-icon" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->readAloudText ?>"><i class="fa fa-info-circle text btn-show-info"></i></span> <span class="read-aloud-text" id=""><?php echo $lang->readSlideshowOverview ?></span></div>
                <div class="row slide-container"></div>
                <button type="button" class="btn btn-success btn-block btn-shadow" id="btn-start-slideshow" style="margin-top: 6px;"><?php echo $lang->startNow ?></button>
            </div>

            <div id="slide" class="hidden">
                <h3 class="headline" style="margin-top: 0px"></h3>
                <div class="row slide-container"></div>
            </div>

            <div class="alert-space alert-phase-step-done"></div>
            <button type="button" class="btn btn-success btn-shadow btn-block hidden" id="btn-done"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div id="gestureSlideshowItem" class="row" style="padding-left: 15px; padding-right: 15px; margin-top: 10px;">
        <div class="col-xs-6 col-lg-4">
            <div class="row" id="thumbnail-container"></div>

            <div class="" id="gesture-slide-controls" style="margin-top: 0px">
                <button type="button" class="btn btn-default btn-shadow btn-block hidden" id="trigger-slide" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->execution->slideshowAskGesture ?>"><i class="fa"></i> <span class="btn-text"><?php echo $lang->request ?></span></button>
                <button type="button" class="btn btn-default btn-shadow btn-block hidden" id="btn-restart-slideshow"><i class="fa fa-check" aria-hidden="true"></i> <span>Neu starten</span></button>
            </div>

        </div>
        <div class="col-xs-6 col-lg-8" style="margin-bottom: 10px;">
            <div class="triggerContainer">
                <div><?php echo $lang->triggerShown ?>: <span id="given" style="color: #303030"></span></div>
                <div><?php echo $lang->gestureInquired ?>: <span id="searched" style="color: #303030"></span></div>
                <div><?php echo $lang->answerPeriod ?>: <span id="responseTime" style="color: #303030"></span></div>
            </div>
        </div>

    </div>


    <!-- slideshow container -->

    <div class="row root" id="triggerSlideshow">
        <div class="col-md-4 rtc-scalable" id="column-left">
            <div class="" id="observations">
                <h3 class="panel-heading-text"><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>
            </div>
        </div>
        <div class="col-md-8" id="column-right">

            <div id="general" class="hidden">
                <h3 class="headline" style="margin-top: 0px"></h3>
                <div class="text read-aloud"><span class="read-aloud-icon" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->readAloudText ?>"><i class="fa fa-info-circle text btn-show-info"></i></span> <span class="read-aloud-text" id="description"></span></div>
                <button type="button" class="btn btn-success btn-block btn-shadow" id="btn-start-slideshow" style="margin-top: 6px;"><?php echo $lang->startNow ?></button>
            </div>

            <div id="elements" class="hidden">
                <h3 style="margin-top: 0px"><?php echo $lang->studyCatalogs->trigger ?></h3>
                <div class="question-container" style="margin-top: 20px"></div>
            </div>

            <button type="button" class="btn btn-success btn-block btn-shadow disabled hidden" id="btn-done-slideshow" style="margin-top: 20px;"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div id="gestureSlideshowItem" class="panel panel-default panel-shadow" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div><?php echo $lang->triggerInquired ?>: <span id="searched" style="color: #303030"></span></div>
            <div><?php echo $lang->gestureShow ?>: <span id="given" style="color: #303030"></span></div>
        </div>
    </div>

    <div id="triggerSlideshowItem" class="panel panel-default panel-shadow" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div class="label label-success hidden" id="answered-correct"><i class="fa fa-check"></i> <span class="label-text"><?php echo $lang->answeredCorrect ?></span></div>
            <div class="label label-danger hidden" id="answered-wrong"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->answeredWrong ?></span></div>
            <div class="label label-warning hidden" id="not-answered"><i class="fa fa-ellipsis-h"></i> <span class="label-text"><?php echo $lang->notAnswered ?></span></div>
            <div><?php echo $lang->triggerInquired ?>: <span id="searched" style="color: #303030"></span></div>
            <div style="margin-right: 10px; float: left"><?php echo $lang->gestureShow ?>: <span id="given" style="color: #303030"></span>
                <button style="height: auto" type="button" class="btn btn-xs btn-default btn-shadow btn-popover-gesture-preview"><i class="fa fa-eye"></i> <span class="btn-text"><?php echo $lang->showGesture ?></span></button>
            </div>
        </div>
    </div>


    <!-- physical stress test container -->

    <div class="row root" id="physicalStressTest">
        <div class="col-md-5 rtc-scalable" id="column-left">
            <div class="" id="observations">
                <h3 class="panel-heading-text"><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>
            </div>
        </div>
        <div class="col-md-7" id="column-right">

            <div id="general" class="hidden">
                <h3 class="headline" style="margin-top: 0px"></h3>
                <div class="text read-aloud"><span class="read-aloud-icon" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->readAloudText ?>"><i class="fa fa-info-circle text btn-show-info"></i></span> <span class="read-aloud-text" id="description"></span></div>
                <button type="button" class="btn btn-success btn-block btn-shadow" id="btn-start-stress-test" style="margin-top: 6px;"><?php echo $lang->startNow ?></button>
            </div>

            <div id="stress-test-controls" class="hidden">
                <h3 class="headline" style="margin-top: 0px"></h3>
                <div class="row" id="stress-test-controls-container"></div>
            </div>

            <div id="question-container" class="hidden" style="margin-top: 10px"></div>

            <div class="alert-space alert-phase-step-done"></div>

            <div style="margin-top: 0px; margin-bottom: 15px">
                <button type="button" class="btn btn-default btn-block btn-shadow hidden" id="btn-repeat-stress-test"><i class="fa fa-repeat"></i> <span class="btn-text"><?php echo $lang->repeatStressTest ?></span></button>
                <button type="button" class="btn btn-default btn-block btn-shadow hidden" id="btn-show-question"><?php echo $lang->showQuestions ?></button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-next-gesture"><span class="btn-text"><?php echo $lang->nextGestureSequence ?></span> <span aria-hidden="true">&rarr;</span></button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-done-questionnaire"><i class="fa fa-check"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-stress-test-done"><i class="fa fa-check"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
            </div>

        </div>
    </div>

    <div id="physical-stress-test-thumbnail-controls" class="col-xs-6 col-lg-4">
        <div class="thumbnail-container row"></div>

        <div class="" style="margin-top: 0px">
            <button type="button" class="btn btn-default btn-block btn-shadow hidden" id="btn-show-gesture"><i class="fa"></i> <?php echo $lang->request ?></button>
            <button type="button" class="btn btn-default btn-block btn-shadow hidden" id="btn-hide-gesture"><i class="fa"></i> <?php echo $lang->quitGesturePreview ?></button>
        </div>
    </div>

    <div class="" id="physical-stress-test-questions" style="margin-bottom: 20px">

        <hr>

        <div id="stress-test-questionnaire">
            <div id="single-stress-answers" class="hidden">
                <h3 id="headline-single-questions"><?php echo $lang->singleAnswers ?></h3>
                <div class="question-container"></div>
            </div>
            <div id="sequence-stress-answers" class="hidden" style="margin-top: 30px">
                <h3 id="headline-sequence-questions"><?php echo $lang->multipleAnswers ?></h3>
                <div class="question-container"></div>
            </div>

        </div>
    </div>


    <!-- scenario container -->

    <div  class="row root" id="scenario">
        <div class="col-sm-6 col-md-5 rtc-scalable" id="column-left">
            <div class="" id="observations">
                <h3 class="panel-heading-text"><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>
            </div>
        </div>

        <div id="fixed-user-test-controls" class="hidden">
            <div class="btn-group-vertical">
                <div>
                    <button class="btn btn-lg btn-default btn-shadow" id="btn-show-assessment-controls"  data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->execution->showAssessmentControls ?>" style="border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px"><i class="fa fa-check"></i></button>
                </div>
                <div>
                    <button class="btn btn-lg btn-default btn-shadow disabled" id="btn-show-help-controls" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->execution->offerHelp ?>" style="border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-top-left-radius: 0px"><i class="fa fa-support"></i></button>
                </div>
            </div>
        </div>


        <div id="assessment-controls-container" class="text-center">
            <h4 style="margin: 0"><?php echo $lang->taskAssessment ?></h4>
            <div class="option-container" style="margin-top: 10px"></div>
            <button class="btn btn-shadow" id="btn-close-assessment-controls" style="width: 100%"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
        </div>

        <div id="help-controls-container" class="hidden">
            <h4 style="margin: 0" class="text-center"><?php echo $lang->offerHelp ?></h4>
            <div class="option-container" style="margin-top: 10px"></div>
            <button class="btn btn-shadow" id="btn-close-help-controls" style="width: 100%"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
        </div>

        <div class="col-sm-6 col-md-7" id="column-right">
            <div class="hidden" id="general" style="margin-bottom: 20px">
                <h3 class="headline" style="margin-top: 0px"><?php echo $lang->general ?></h3>
                <div class="">
                    <div class="alert-space alert-no-more-tasks"></div>
                    <div class="read-aloud"><span class="read-aloud-icon" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->readAloudScenario ?>"><i class="fa fa-info-circle text btn-show-info"></i></span> <span class="read-aloud-text" id="description"></span></div>
                    <!--<div id="description"><span class="address"></span>: <span class="text font-bold"></span></div>-->
                    <div>
                        <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-open-prototype"><?php echo $lang->openPrototype ?></button>
                        <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-start-screen-sharing" ><i class="fa"></i> <?php echo $lang->startScreensharing ?></button>
                        <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-start-scenario"><?php echo $lang->startNow ?></button>
                    </div>

                </div>
            </div>

            <div class="hidden" id="scenario-controls">
                <div id="task-controls">
                    <h3 id="task-headline" style="margin-top: 0"><?php echo $lang->task ?> </h3>
                    <!--<div style="padding-bottom: 0">-->
                    <div class="alert-space alert-no-phase-data"></div>
                    <div class="read-aloud"><span class="read-aloud-icon" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->readAloudTask ?>"><i class="fa fa-info-circle text btn-show-info"></i></span> <span class="read-aloud-text" id="task"></span></div>
                    <!--<div id="task"><span class="text font-bold"></span></div>-->

                    <!--</div>-->
                    <button class="btn btn-success btn-shadow btn-block" id="btn-read-out-task"><i class="fa fa-check"></i> Aufgabe vorgelesen</button>
                </div>
                <div class="hidden" id="woz-controls">
                    <h3><?php echo $lang->wozControlElements ?> 
                        <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->execution->whichGestureWasDemonstrated ?>"></i>
                        <button class="btn btn-xs btn-default pull-right" id="btn-reset-scenes"><i class="fa fa-refresh"></i> <?php echo $lang->reset ?></button>
                    </h3>
                    <div class="" style="padding-bottom: 0">
                        <div id="wozExperiment" style="margin-bottom: 20px;">
                            <div style="margin-bottom: 10px" class="text"><?php // echo $lang->whichGestureWasDemonstrated            ?></div>
                            <div class="alert-space alert-no-phase-data"></div>
                            <div class="alert-space alert-no-more-woz-states"></div>
                            <div class="row woz-container"></div>
                            <!--<button type="button" class="btn btn-default btn-block btn-other-gesture-fit" id="no-gesture-fit-found" style="margin-top: 20px"><?php echo $lang->anotherGestureWasDemonstrated ?></button>-->
                        </div>
                    </div>
                </div>
                <!--                <div class="" id="help-controls">
                                    <h3><?php echo $lang->help ?></h3>
                                    <div class="" style="padding-bottom: 0">
                                        <div class="alert-space alert-no-phase-data"></div>
                                        <div class="help-container"></div>
                                    </div>
                                </div>-->
            </div>

            <div id="scene-container" class="text-center hidden" style="position: absolute; right:15px; left:15px; border-radius:8px" allowtransparency></div>

            <div class="alert-space alert-quit-screen-sharing"></div>
            <div class="alert-space alert-phase-step-done"></div>
            <div style="margin-top: 0px">
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-stop-screen-sharing" ><?php echo $lang->stopScreensharing ?></button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-done-scenario"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
            </div>

        </div>
    </div>

    <div class="col-xs-6 col-sm-4 col-md-4 root" id="wozItem">
        <div class="panel panel-default panel-shadow btn-shadow">
            <div class="btn-shadow">
                <div class="previewGesture mousePlayable embed-responsive embed-responsive-4by3" style="border-radius: 0px; border-top-left-radius: 8px; border-top-right-radius: 8px"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                    </div>
                </div>

                <button type="button" class="btn btn-success btn-block disabled" id="btn-trigger-woz" style="border-top-left-radius: 0px; border-top-right-radius: 0px"><?php echo $lang->thisGesture ?></button>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-lg-12 root" id="wozItemWithScenes" style="padding-bottom: 15px">
        <div class="row">
            <div class="col-xs-5 col-sm-6 col-md-4">
                <div class="embed-responsive embed-responsive-4by3">
                    <div class="previewGesture mousePlayable embed-responsive-item" style="border-radius: 0px; border-top-left-radius: 8px; border-top-right-radius: 8px;"></div>
                    <div class="text-center hidden gestureControls">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                            <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                        </div>
                    </div>
                    <div class="continuous-gesture-controls hidden" style="">
                        <div class="control-continuous-slider-status">0%</div>
                        <div class="btn-invert-slider-values" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->execution->valuesNotInverted ?>"><i class="fa fa-exchange"></i></div>
                    </div>

                    <div class="gesture-info-symbols">
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
                <div id="control-continuous-slider" class="hidden" style="margin-top: -10px; margin-bottom: 18px">
                    <input id="continuous-slider" style="width: 100%; height: 34px" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                </div>

                <button type="button" class="btn btn-success btn-block btn-shadow disabled" id="btn-trigger-woz" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px"><?php echo $lang->thisGesture ?></button>

                <div class="btn-group btn-group-justified hidden static-continuous-controls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-shadow disabled btn-start-static-continuous-gesture" style="border-radius: 0px; border-bottom-left-radius: 8px;"><i class="fa fa-play"></i></button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-shadow disabled btn-stop-static-continuous-gesture" style="border-radius: 0px; border-bottom-right-radius: 8px;"><i class="fa fa-stop"></i></button>
                    </div>
                </div>

                <button type="button" class="btn btn-default btn-block btn-shadow disabled hidden btn-trigger-continuous-mouse-manipulation" data-activated="false" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px"><i class="fa fa-mouse-pointer"></i> <?php echo $lang->cursor ?></button>

            </div>
            <div class="col-xs-7 col-sm-6 col-md-8 transition-scenes" id="transition-scenes">
                <div id="transition-scenes">
                    <div class="bs-example hidden" id="start-scene" style="margin-bottom: 10px">
                        <div class="bs-example-headline"><?php echo $lang->stateCharts->inputState ?></div>
                        <div class="bs-example-body" id="start-scene-container"></div>
                    </div>
                    <div class="bs-example hidden" id="transition-feedback" style="margin-bottom: 10px">
                        <div class="bs-example-headline"><?php echo $lang->stateCharts->transitionFeedback ?></div>
                        <div class="bs-example-body" id="transition-feedback-container"></div>
                    </div>
                    <div class="bs-example hidden" id="transition-scenes" style="margin-bottom: 10px">
                        <div class="bs-example-headline"><?php echo $lang->stateCharts->intermediateStates ?></div>
                        <div class="bs-example-body" id="transition-scene-container"></div>
                    </div>
                    <div class="bs-example hidden" id="follow-scenes">
                        <div class="bs-example-headline"><?php echo $lang->stateCharts->entryAction ?></div>
                        <div class="bs-example-body" id="follow-scene-container"></div>
                    </div>
                </div>
    <!--                <h4 style="margin:0"><?php echo $lang->stateCharts->currentState ?></h4>
                    <div id="start-scene-container"></div>
                    <h4 style="margin-bottom: 0" id="transition-feedback-header" class="hidden"><?php echo $lang->stateCharts->transitionFeedback ?></h4>
                    <div class="hidden" id="transition-feedback-container"></div>
                    <h4 style="margin-bottom: 0" id="transition-scene-header" class="hidden"><?php echo $lang->stateCharts->intermediateStates ?></h4>
                    <div class="hidden" id="transition-scene-container"></div>
                    <h4 style="margin-bottom: 0" id="follow-scene-header" class="hidden"><?php echo $lang->stateCharts->entryAction ?></h4>
                    <div id="follow-scene-container" class="hidden"></div>-->
            </div>
        </div>

    </div>

    <div class="btn-group" id="wozItemWithScenesButton">
        <button type="button" class="btn btn-default btn-shadow disabled btn-trigger-scene">
            <i class="hidden fa fa-image" id="scene-image"></i> 
            <i class="hidden fa fa-link" id="scene-web"></i> 
            <i class="hidden fa fa-link" id="scene-pidoco"></i> 
            <i class="hidden fa fa-film" id="scene-videoEmbed"></i> 
            <span class="btn-text ellipsis"></span> <span class="badge transition-time"></span>
            <div id="transition-indicator" class="hidden" style="position: absolute; bottom: 0; height: 3px; left: 0; right: 0; background-color: white"></div>
        </button>
    </div>

    <div class="btn-group" id="wozFeedbackItemButton">
        <button type="button" class="btn btn-default btn-shadow disabled btn-trigger-feedback">
            <i class="hidden fa fa-circle-o-notch fa-spin" id="waiting-indicator"></i> 
            <i class="hidden fa fa-font" id="feedback-text"></i> 
            <i class="hidden fa fa-volume-up" id="feedback-sound"></i> 
            <span class="btn-text ellipsis"></span> <span class="badge transition-time"></span>
            <div id="transition-indicator" class="hidden" style="position: absolute; bottom: 0; height: 3px; left: 0; right: 0; background-color: white"></div>
        </button>
    </div>

    <div id="helpItem" style="margin-bottom: 16px;">
        <div class="help-title"></div>
        <div class="btn-group" style="margin-top: 10px;">
            <button type="button" class="btn btn-default btn-shadow" id="offer-help" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->execution->offerHelpText ?>"><i class="fa fa-life-ring"></i> <span class="btn-text"><?php echo $lang->offerHelp ?></span></button>
            <!--<button type="button" class="btn btn-default btn-shadow hidden" id="unoffer-help" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->execution->unofferHelpText ?>"><i class="fa fa-life-ring"></i> <?php echo $lang->closeHelp ?></button>-->
            <button type="button" class="btn btn-default btn-shadow hidden" id="btn-gesture-preview"><i class="fa fa-eye"></i> <span class="btn-text"><?php echo $lang->gesture ?></span></button>
        </div>
    </div>


    <!-- identification container -->

    <div class="row root" id="identification">
        <div class="col-md-6 col-lg-5 rtc-scalable" id="column-left">
            <div class="" id="observations">
                <!--<div class="panel-heading">-->
                <h3 class="panel-heading-text"><?php echo $lang->observations ?></h3>
                <!--</div>-->
                <!--<div class="panel-body">-->
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>
                <!--</div>-->
            </div>
        </div>
        <div class="col-md-6 col-lg-7" id="column-right" style="padding-bottom: 15px">
            <div class="hidden" id="general">
                <h3 class="headline" style="margin-top: 0"></h3>
                <div style="margin-bottom: 10px">
                    <span class="label label-default hidden" id="search-gestures"><?php echo $lang->gesturesAreElicited ?></span> 
                    <span class="label label-default hidden" id="search-trigger"><?php echo $lang->triggerAreElicited ?></span>
                </div>
                <div class="text read-aloud"><span class="read-aloud-icon" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->readAloudText ?>"><i class="fa fa-info-circle text btn-show-info"></i></span> <span class="read-aloud-text" id="description"></span></div>
                <div style="margin-top: 6px">
                    <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-start-identification"><?php echo $lang->startNow ?></button>
                    <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-open-prototype" ><?php echo $lang->openPrototype ?></button>
                    <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-start-screen-sharing"><i class="fa fa-circle-o-notch fa-spin hidden"></i> <?php echo $lang->startScreensharing ?></button>
                </div>
            </div>

            <div class="hidden" id="slides">
                <h3 class="headline" style="margin-top: 0px"></h3>
                <div id="identificationContainer"></div>
            </div>

            <div class="hidden" id="identified-gesture">
                <h3 class="headline" style="margin-top: 0px"><?php echo $lang->saveRecordedGesture ?></h3>
                <div id="file-transfer-loader">
                    <p class="text"><i class="fa fa-circle-o-notch fa-spin"></i> <?php echo $lang->transmitGesture ?></p>
                    <div id="file-transfer-loading-indicator" style="height: 10px; width:0%; background-color: #3379b7; border-radius: 4px">
                    </div>
                </div>
                <div class="alert-space alert-preview-dummy"></div>
                <div class="hidden" id="gesture-recorder-container"></div>
            </div>

            <div class="hidden" id="identified-trigger">
                <h3 class="headline" style="margin-top: 0px"><?php echo $lang->favoriteTrigger ?></h3>
                <div class="alert-space alert-waiting-for-tester"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="row" id="thumbnail-container"></div>
                    </div>
                    <div class="col-md-8">
                        <div class="question-container"></div>
                    </div>
                </div>
            </div>



            <div class="alert-space alert-quit-screen-sharing"></div>
            <div class="alert-space alert-phase-step-done"></div>

            <div id="identification-controls" style="margin-bottom: 15px">
                <div style="margin-top: 20px;">
                    <button class="btn btn-block btn-success btn-shadow hidden" id="btn-start-gesture-recording" name="btn-success" style=""><i class="fa fa-dot-circle-o"></i> <?php echo $lang->recordGesture ?></button>
                    <!--<button class="btn btn-block btn-default btn-shadow hidden" id="btn-start-gesture-rerecording" name="btn-success" style="margin-top: 20px;"><i class="fa fa-dot-circle-o"></i> <?php echo $lang->rerecordGesture ?></button>-->
                    <button class="btn btn-block btn-danger btn-shadow hidden" id="btn-stop-gesture-recording" name="btn-success"><i class="fa fa-stop"></i> <?php echo $lang->stopRecordGesture ?></span></button>
                </div>
                <div style="margin-top: 10px">
                    <button class="btn btn-block btn-success btn-shadow hidden" id="btn-next-gesture" name="btn-success"><?php echo $lang->nextGesture ?> &rarr;</button>
                    <button class="btn btn-block btn-success btn-shadow hidden" id="btn-next-trigger" name="btn-success"><?php echo $lang->nextTrigger ?> &rarr;</button>
                    <button class="btn btn-block btn-success btn-shadow hidden" id="btn-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
                </div>
            </div>

            <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-stop-screen-sharing"><?php echo $lang->stopScreensharing ?></button>
            <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-done-identification"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></button>
        </div>
    </div>

    <div id="identificationItem-gestures">
        <div id="search-for"><span class="address"></span> <span class="text"></span></div>
        <div id="transition-scenes-container" class="root">
            <div class="bs-example hidden" id="start-scene">
                <div class="bs-example-headline"><?php echo $lang->stateCharts->inputState ?></div>
                <div class="bs-example-body" id="start-scene-container"></div>
            </div>
            <div class="bs-example hidden" id="transition-scenes" style="margin-top: 10px">
                <div class="bs-example-headline"><?php echo $lang->stateCharts->intermediateStates ?></div>
                <div class="bs-example-body" id="transition-scene-container"></div>
            </div>
            <div class="bs-example hidden" id="follow-scenes" style="margin-top: 10px">
                <div class="bs-example-headline"><?php echo $lang->stateCharts->entryAction ?></div>
                <div class="bs-example-body" id="follow-scene-container"></div>
            </div>
        </div>
        <div id="waiting-for-sensor" class="hidden"><i class="fa fa-spin fa-circle-o-notch"></i> <?php echo $lang->waitForSensorData ?></div>
    </div>

    <div id="identificationItem-trigger">
        <div id="search-for"><span class="address"></span> <span class="text"></span> 
            <button type="button" class="btn btn-xs btn-default btn-popover-gesture-preview" style="height: 22px; margin-left: 5px"><i class="fa fa-eye"></i> <span class="btn-text"><?php echo $lang->showGesture ?></span></button>
        </div> 
        <div id="transition-scenes-container" class="root">
            <div class="bs-example hidden" id="start-scene">
                <div class="bs-example-headline"><?php echo $lang->stateCharts->inputState ?></div>
                <div class="bs-example-body" id="start-scene-container"></div>
            </div>
            <div class="bs-example hidden" id="transition-scenes" style="margin-top: 10px">
                <div class="bs-example-headline"><?php echo $lang->stateCharts->intermediateStates ?></div>
                <div class="bs-example-body" id="transition-scene-container"></div>
            </div>
            <div class="bs-example hidden" id="follow-scenes" style="margin-top: 10px">
                <div class="bs-example-headline"><?php echo $lang->stateCharts->entryAction ?></div>
                <div class="bs-example-body" id="follow-scene-container"></div>
            </div>
        </div>
        <div style="margin-top: 10px">
            <button class="btn btn-block btn-success btn-shadow disabled" id="btn-request-trigger" name="btn-success"><?php echo $lang->inquireTrigger ?></span></button>
            <!--<button class="btn btn-block btn-success btn-shadow disabled hidden" id="btn-next-trigger" name="btn-success"><?php echo $lang->nextGesture ?> &rarr;</button>-->
            <!--<button class="btn btn-block btn-success btn-shadow disabled hidden" id="btn-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>-->
        </div>
    </div>

    <div id="transition-scene-item" style="display: inline">
        <div class="selected-icon hidden" style="display: inline-block"></div>
        <div class="scene-data" style="display: inline-block"></div>
    </div>


    <!-- exploration container -->
    <div class="row root" id="exploration">
        <div class="col-md-6 col-lg-5 rtc-scalable" id="column-left">
            <div class="" id="observations">
                <h3 class="panel-heading-text"><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>
            </div>
        </div>
        <div class="col-md-6 col-lg-7" id="column-right">
            <div class="hidden" id="general">
                <h3 class="headline" style="margin-top: 0"></h3>
                <div style="margin-bottom: 10px">
                    <span class="label label-default hidden" id="search-gestures"><?php echo $lang->gesturesAreElicited ?></span> 
                    <span class="label label-default hidden" id="search-trigger"><?php echo $lang->triggerAreElicited ?></span>
                </div>
                <div class="text read-aloud"><span class="read-aloud-icon" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->readAloudText ?>"><i class="fa fa-info-circle text btn-show-info"></i></span> <span class="read-aloud-text" id="description"></span></div>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-start-exploration" style="margin-top: 6px;"><?php echo $lang->startNow ?></button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-open-prototype" style="margin-top: 6px;"><?php echo $lang->openPrototype ?></button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-start-screen-sharing" style="margin-top: 6px;"><i class="fa fa-circle-o-notch fa-spin hidden"></i> <?php echo $lang->startScreensharing ?></button>
                <!--<button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-done-exploration" style="margin-top: 6px;"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></button>-->
            </div>

            <div class="hidden" id="slides">
                <h3 class="headline" style="margin-top: 0px"></h3>
                <div id="exploration-container"></div>
            </div>

            <div class="hidden" id="identified-gestures">
                <h3 class="headline" style="margin-top: 0px"><?php echo $lang->favoriteGestures ?></h3>
                <div class="alert-space alert-waiting-for-tester"></div>
                <div class="question-container"></div>
            </div>

            <div class="hidden" id="identified-trigger">
                <h3 class="headline" style="margin-top: 0px"><?php echo $lang->favoriteTrigger ?></h3>
                <div class="alert-space alert-waiting-for-tester"></div>
                <div class="row" id="answer-container">
                    <div class="col-md-4">
                        <div class="row" id="thumbnail-container"></div>
                    </div>
                    <div class="col-md-8">
                        <div class="question-container"></div>
                    </div>
                </div>
            </div>


            <div class="alert-space alert-quit-screen-sharing"></div>
            <div class="alert-space alert-phase-step-done"></div>

            <div style="margin-top: 20px; margin-bottom: 15px">
                <button type="button" class="btn btn-block btn-success btn-shadow hidden" id="btn-request-gestures" name="btn-success"><?php echo $lang->inquireFavoriteGestures ?></span></button>
                <button type="button" class="btn btn-block btn-success btn-shadow hidden" id="btn-request-trigger" name="btn-success"><?php echo $lang->inquireFavoriteTrigger ?></span></button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-next-trigger" name="btn-success"><?php echo $lang->nextTrigger ?> &rarr;</button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-next-gesture" name="btn-success"><?php echo $lang->nextGesture ?> &rarr;</button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <?php echo $lang->done ?></button>
            </div>

            <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-stop-screen-sharing" style="margin-top: 6px;"><?php echo $lang->stopScreensharing ?></button>
            <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-done-exploration" style="margin-top: 6px;"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></button>
        </div>
    </div>

    <div id="explorationItem">
        <div class="scenes-container" style="margin-bottom: 20px">
            <div><?php echo $lang->scenes ?></div>
            <div id="transition-scenes-container" class="root">
                <div class="bs-example hidden" id="start-scene">
                    <div class="bs-example-headline"><?php echo $lang->stateCharts->inputState ?></div>
                    <div class="bs-example-body" id="start-scene-container"></div>
                </div>
                <div class="bs-example hidden" id="transition-scenes" style="margin-top: 10px">
                    <div class="bs-example-headline"><?php echo $lang->stateCharts->intermediateStates ?></div>
                    <div class="bs-example-body" id="transition-scene-container"></div>
                </div>
                <div class="bs-example hidden" id="follow-scenes" style="margin-top: 10px">
                    <div class="bs-example-headline"><?php echo $lang->stateCharts->entryAction ?></div>
                    <div class="bs-example-body" id="follow-scene-container"></div>
                </div>
            </div>
        </div>

        <div class="assembled-gestures-container">
            <div id="search-for"><span class="address" style="margin-top: 20px"></span> <span class="text"></span></div>
            <div id="assembled-gestures" class="root row" style="margin-top: 5px"></div>
        </div>

        <!--<div style="margin-top: 10px">-->
            <!--<button class="btn btn-block btn-success btn-shadow disabled" id="btn-show-gestures" name="btn-success"><?php echo $lang->showGestures ?></span></button>-->

<!--<button class="btn btn-block btn-success btn-shadow disabled hidden" id="btn-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>-->
        <!--</div>-->
    </div>

    <!--    <div id="explorationItem-ask">
            <div class="scenes-container" style="margin-bottom: 20px">
                <div><?php echo $lang->scenes ?></div>
                <div id="transition-scenes" class="root"></div>
            </div>
            <div class="assembled-gestures-container">
                <div id="search-for"><span class="address" style="margin-top: 20px"></span> <span class="text"></span></div>
                <div id="assembled-gestures" class="root row"></div>
            </div>-->
    <!--<div style="margin-top: 20px">-->
<!--            <button class="btn btn-block btn-success btn-shadow disabled" id="btn-request-gestures" name="btn-success"><?php echo $lang->inquireFavoriteGestures ?></span></button>-->
<!--            <button class="btn btn-block btn-success btn-shadow hidden" id="btn-next-trigger" name="btn-success"><?php echo $lang->nextTrigger ?> &rarr;</button>
        <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-done-exploration" style="margin-top: 6px;"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></button>-->
        <!--<button class="btn btn-block btn-success btn-shadow disabled hidden" id="btn-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>-->
    <!--</div>-->
    <!--</div>-->

    <div id="explorationItem-trigger">
        <div class="scenes-container" style="margin-bottom: 20px">
            <div><?php echo $lang->scenes ?></div>
            <div id="transition-scenes-container" class="root">
                <div class="bs-example hidden" id="start-scene">
                    <div class="bs-example-headline"><?php echo $lang->stateCharts->inputState ?></div>
                    <div class="bs-example-body" id="start-scene-container"></div>
                </div>
                <div class="bs-example hidden" id="transition-scenes" style="margin-top: 10px">
                    <div class="bs-example-headline"><?php echo $lang->stateCharts->intermediateStates ?></div>
                    <div class="bs-example-body" id="transition-scene-container"></div>
                </div>
                <div class="bs-example hidden" id="follow-scenes" style="margin-top: 10px">
                    <div class="bs-example-headline"><?php echo $lang->stateCharts->entryAction ?></div>
                    <div class="bs-example-body" id="follow-scene-container"></div>
                </div>
            </div>
        </div>

        <div class="assembled-trigger-container" style="margin-top: 20px">
            <div class="row container-root">
                <div class="col-xs-12 col-sm-8" id="assembled-trigger-container">
                    <div id="search-for"><span class="address"><?php echo $lang->triggerForGesture ?></span></div>
                    <div id="assembled-trigger" class="root"></div>
                </div>
            </div>

        </div>
        <!--<div style="margin-top: 10px">-->
            <!--<button class="btn btn-block btn-success btn-shadow disabled" id="btn-show-trigger" name="btn-success"><?php echo $lang->showTrigger ?></span></button>-->
    <!--            <button class="btn btn-block btn-success btn-shadow hidden" id="btn-next-gesture" name="btn-success"><?php echo $lang->nextGesture ?> &rarr;</button>
            <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-done-exploration" style="margin-top: 6px;"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></button>-->
            <!--<button class="btn btn-block btn-success btn-shadow disabled hidden" id="btn-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>-->
        <!--</div>-->
    </div>
    <!--
        <div id="explorationItem-trigger-ask">
            <div class="scenes-container" style="margin-bottom: 20px">
                <div><?php echo $lang->scenes ?></div>
                <div id="transition-scenes" class="root"></div>
            </div>
            <div class="assembled-trigger-container">
                <div id="search-for"><span class="address" style="margin-top: 20px"></span> <span class="text"></span></div>
                <div id="assembled-trigger" class="root"></div>
            </div>-->
    <!--<div style="margin-top: 20px">-->

<!--            <button class="btn btn-block btn-success btn-shadow hidden" id="btn-next-gesture" name="btn-success"><?php echo $lang->nextGesture ?> &rarr;</button>
<button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-done-exploration" style="margin-top: 6px;"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></button>-->
<!--<button class="btn btn-block btn-success btn-shadow disabled hidden" id="btn-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>-->
    <!--</div>-->
    <!--</div>-->

    <div id="present-gesture-item" class="col-xs-6 col-sm-4 col-md-6 col-lg-4">
        <div class="thumbnail-container row"></div>
        <button class="btn btn-block btn-default btn-shadow btn-present-gesture" id="btn-present-gesture"><i class="fa"></i> <span class="btn-text">Zeige Geste</span></button>
        <button class="btn btn-block btn-success btn-shadow btn-quit-gesture-info hidden" id="btn-quit-gesture-info" style="margin-top: 0"><i class="fa"></i> <span class="btn-text">Vorschau beenden</span></button>
    </div>

    <div id="present-trigger-item" class="text" style="display: flex">
        <div class="trigger-title" style="margin-right: 10px"></div>
        <div>
            <button class="btn btn-xs btn-default btn-shadow btn-present-trigger" id="btn-present-trigger"><i class="fa"></i> <span class="btn-text">Zeige Funktion</span></button>
            <button class="btn btn-xs btn-success btn-shadow btn-quit-trigger-info hidden" id="btn-quit-trigger-info" style="margin-top: 0"><i class="fa"></i> <span class="btn-text">Vorschau beenden</span></button>
        </div>
    </div>


    <div id="trigger-catalog-thumbnail" class="text"></div>

    <div id="scenes-catalog-thumbnail">
        <div id="info-pidoco" class="hidden" style="float: left;">
            <span class="label label-default"><i class="fa fa-link"></i> <span class="label-text"></span></span>
            <span class="text"></span>
        </div>
        <div id="info-web" class="hidden" style="float: left;">
            <span class="label label-default"><i class="fa fa-link"></i> <span class="label-text"></span></span>
            <span class="text"></span>
        </div>
        <div id="info-image" class="hidden" style="float: left;">
            <span class="label label-default"><i class="fa fa-image"></i> <span class="label-text"></span></span>
            <span class="text"></span>
        </div>
        <div id="info-videoEmbed" class="hidden" style="float: left;">
            <span class="label label-default"><i class="fa fa-film"></i> <span class="label-text"></span></span>
            <span class="text"></span>
        </div>
        <div style="float: left; margin-left: 10px;">
            <button type="button" class="btn btn-default btn-xs" id="btn-preview-scene"><i class="fa fa-eye"></i> <span class="btn-text"><?php echo $lang->statePreview ?></span></button>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div id="interactive-scenes-catalog-thumbnail">
        <div class="btn-group hidden" id="info-pidoco">
            <button class="btn btn-default btn-trigger-scene">
                <span class="badge"><i class="fa fa-link"></i> <?php echo $lang->sceneTypes->pidoco ?></span> 
                <span class="btn-text" style="margin-left: 5px"></span>
            </button>
        </div>             
        <div class="btn-group hidden" id="info-web">
            <button class="btn btn-default btn-trigger-scene">
                <span class="badge"><i class="fa fa-link" style=""></i> <?php echo $lang->sceneTypes->web ?></span> 
                <span class="btn-text" style="margin-left: 5px"></span>
            </button>
        </div>
        <div class="btn-group hidden" id="info-image">
            <button class="btn btn-default btn-trigger-scene">
                <span class="badge"><i class="fa fa-image"></i> <?php echo $lang->sceneTypes->image ?></span> 
                <span class="btn-text" style="margin-left: 5px"></span>
            </button>
        </div>
        <div class="btn-group hidden" id="info-videoEmbed">
            <button class="btn btn-default btn-trigger-scene">
                <span class="badge"><i class="fa fa-film"></i> <?php echo $lang->sceneTypes->videoEmbed ?></span> 
                <span class="btn-text" style="margin-left: 5px"></span>
            </button>
        </div>
        <div class="scene-description text" style=""></div>
    </div>




    <!-- focus group interview container -->
    <div class="row root" id="focusGroupInterview">
        <div class="col-md-6 col-lg-5 rtc-scalable" id="column-left">
            <div class="" id="keyQuestions">
                <h3 class="panel-heading-text"><?php echo $lang->focusGroupForm ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>
            </div>
        </div>
        <div class="col-md-6 col-lg-7" id="column-right">
            <div class="" id="general">
                <h3 class="headline" style="margin-top: 0"></h3>
                <div style="margin-bottom: 10px">
                    <span class="label label-default hidden" id="search-gestures"><?php echo $lang->gesturesAreElicited ?></span> 
                    <span class="label label-default hidden" id="search-trigger"><?php echo $lang->triggerAreElicited ?></span>
                </div>
                <div class="text read-aloud"><span class="read-aloud-icon" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->readAloudText ?>"><i class="fa fa-info-circle text btn-show-info"></i></span> <span class="read-aloud-text" id="description"></span></div>
                <button type="button" class="btn btn-success btn-block btn-shadow" id="btn-start-focus-group" style="margin-top: 6px;"><?php echo $lang->startNow ?></button>
                <button type="button" class="btn btn-success btn-block btn-shadow" id="btn-open-prototype" style="margin-top: 6px;"><?php echo $lang->openPrototype ?></button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-start-screen-sharing" style="margin-top: 6px;"><i class="fa fa-circle-o-notch fa-spin hidden"></i> <?php echo $lang->startScreensharing ?></button>
            </div>

            <div class="hidden" id="annotation-controls" style="margin-bottom: 30px">
                <h3 class="headline" style="margin-top: 0px"><?php echo $lang->annotations ?></h3>
                <div id="annotations-container"></div>
            </div>

            <div class="hidden" id="catalog-data">
                <h3 class="headline" style="margin-top: 0px"><?php echo $lang->studyCreateNav->catalogs ?></h3>
                <div class="hidden" id="catalogs-study-gestures">
                    <h4 style="margin-top: 0px"><?php echo $lang->studyCatalogs->gestures ?></h4>
                    <div class="alert-space alert-no-study-gestures-assembled-link-warning"></div>
                    <div class="row option-container"></div>
                </div>

                <div class="hidden" id="catalogs-trigger" style="margin-top: 25px">
                    <h4 style="margin-top: 0px"><?php echo $lang->studyCatalogs->trigger ?></h4>
                    <div class="alert-space alert-no-trigger-assembled-link-warning"></div>
                    <div class="option-container"></div>
                </div>

                <div class="hidden" id="catalogs-scenes" style="margin-top: 40px">
                    <h4 style="margin-top: 0px"><?php echo $lang->studyCatalogs->scenes ?></h4>
                    <div class="alert-space alert-no-scenes-assembled-link-warning"></div>
                    <div class="option-container"></div>
                </div>

                <div class="hidden" id="catalogs-feedback" style="margin-top: 40px">
                    <h4 style="margin-top: 0px"><?php echo $lang->studyCatalogs->feedback ?></h4>
                    <div class="alert-space alert-no-feedback-assembled-link-warning"></div>
                    <div class="option-container"></div>
                </div>    
            </div>

            <div style="margin-top: 10px">
                <!--<button type="button" class="btn btn-block btn-success btn-shadow hidden disabled" id="btn-request-gestures" name="btn-success"><?php echo $lang->inquireFavoriteGestures ?></span></button>-->
                <!--<button type="button" class="btn btn-block btn-success btn-shadow hidden disabled" id="btn-request-trigger" name="btn-success"><?php echo $lang->inquireFavoriteTrigger ?></span></button>-->
                <!--<button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-next-trigger" name="btn-success"><?php echo $lang->nextTrigger ?> &rarr;</button>-->
                <!--<button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-next-gesture" name="btn-success"><?php echo $lang->nextGesture ?> &rarr;</button>-->
                <button type="button" class="btn btn-success btn-block btn-shadow hidden disabled" id="btn-stop-screen-sharing" style="margin-top: 6px;"><?php echo $lang->stopScreensharing ?></button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-done-focus-group" style="margin-top: 6px;"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></button>
            </div>
        </div>
    </div>




    <div id="web">
        <span><?php echo $lang->title ?>: </span><span class="title"></span><br/>
        <span><?php echo $lang->type ?>: </span><div class="label label-default type"><i class="fa fa-link"></i> <span class="label-text"></span></div><br/><br/>
        <iframe class="web-frame" src="" frameborder="0" scrolling="no" style="width: 100%; height: 400px; pointer-events: none;"></iframe>
        <button type="button" class="btn btn-default btn-shadow btn-block btn-url" aria-label="<?php echo $lang->openUrlInNewWindow ?>"><i class="fa fa-link"></i> <?php echo $lang->openUrlInNewWindow ?></button>
    </div>

    <div id="pidoco">
        <span><?php echo $lang->title ?>: </span><span class="title"></span><br/>
        <span><?php echo $lang->type ?>: </span><div class="label label-default type"><i class="fa fa-link"></i> <span class="label-text"></span></div><br/><br/>
        <iframe class="web-frame" src="" frameborder="0" scrolling="no" style="width: 100%; height: 400px; pointer-events: none;"></iframe>
        <button type="button" class="btn btn-default btn-shadow btn-block btn-url" aria-label="<?php echo $lang->openUrlInNewWindow ?>"><i class="fa fa-link"></i> <?php echo $lang->openUrlInNewWindow ?></button>
    </div>

    <div id="image">
        <span><?php echo $lang->title ?>: </span><span class="title"></span><br/>
        <span><?php echo $lang->type ?>: </span><div class="label label-default type"><i class="fa fa-image"></i> <span class="label-text"></span></div><br/><br/>
        <img class="imageAreaContent" src="" alt="..." style="width: 100%; height: auto; border-radius: 8px;" />
    </div>

    <div id="videoEmbed">
        <span><?php echo $lang->title ?>: </span><span class="title"></span><br/>
        <span><?php echo $lang->type ?>: </span><div class="label label-default type"><i class="fa fa-film"></i> <span class="label-text"></span></div><br/><br/>
        <div class="videoContainer embed-responsive"></div>
    </div>

</div>






















<div id="item-container-observer" class="hidden">

    <div class="root" id="notes" style="">
        <h3 id="headline" style="margin-top: 0"><?php echo $lang->notes ?></h3>
        <textarea class="form-control" id="notes-input" rows="5"></textarea>
    </div>



    <div id="observer-web-rtc-placeholder" class="web-rtc-placeholder embed-responsive embed-responsive-4by3" style="position: absolute">
        <img class="embed-responsive-item" src="img/web-rtc-placeholder.png" width="100%" height="auto"/>
        <div class="btn-group stream-controls" id="stream-controls" style="position: absolute; bottom: 6px; left: 50%; transform: translate(-50%, 0); opacity: 0; display:flex">
            <button type="button" class="btn btn-sm stream-control" id="btn-stream-local-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->muteMicrofone ?>"><i class="fa fa-microphone-slash"></i> </button>
            <button type="button" class="btn btn-sm stream-control" id="btn-pause-stream" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOwnWebRTC ?>"><i class="fa fa-pause"></i> </button>
            <button type="button" class="btn btn-sm stream-control" id="btn-stream-remote-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOtherWebRTC ?>"><i class="fa fa-volume-up"></i> </button>
            <button type="button" class="btn btn-sm stream-control pinned" id="btn-toggle-rtc-fixed" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->dragRTC ?>"><i class="fa fa-window-restore"></i> </button>
        </div>
        <div class="hidden record-stream-indicator" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->recordingStream ?>"><i class="fa fa-video-camera"></i></div>

        <img class="hidden" src="img/resize.png" id="resize-sign" style="position: absolute; bottom: 0; right: 0;"/>
    </div>

    <div class="row root" id="no-phase-data">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <div class="alert-space alert-no-phase-data"></div>
        </div>
    </div>


    <div class="row root" id="letterOfAcceptance">
        <div class="col-md-6 col-lg-4 rtc-scalable" id="column-left">
        </div>
        <div class="col-md-6 col-lg-8" id="column-right" style="margin-bottom: 15px">
            <div class="">
                <div class="">
                    <h3 style="margin-top: 0"><?php echo $lang->formats->letterOfAcceptance->text ?></h3>
                </div>
                <div class="">
                    <p class="text letter-text" style="white-space:pre-wrap;"></p>
                    <div class="alert-space alert-please-wait"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row root" id="thanks">

        <div class="col-sm-5 col-md-4 rtc-scalable" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-sm-7 col-md-8" id="column-right" style="margin-bottom: 15px;">
            <h3 class="headline" style="margin-top: 0"><?php echo $lang->thanksHeadline ?></h3>
            <div class="row " style="margin-top: 20px">

                <div class="col-sm-12" style="margin-bottom: 20px;" id="upload-done">
                    <i class="fa fa-check" aria-hidden="true" style="font-size: 70pt; color: #5cb85c"></i>
                    <div class="text">
                        <?php echo $lang->thanksSaveSuccess ?>
                    </div>
                </div>
            </div>

            <button class="btn btn-success btn-block btn-shadow" id="btn-leave-survey"><?php echo $lang->leaveExecution ?></button>
        </div>
    </div>



    <div class="root row" id="identification" style="">

        <div class="col-md-5 col-lg-5 rtc-scalable" id="column-left" style="margin-bottom: 15px;">
            <div class="" id="observation-annotations">
                <h3 class="panel-heading-text"><?php echo $lang->annotations ?></h3>
                <div class="observation-annotation-select">
                    <div class="btn-observer-color-selector darkblue" data-id='darkblue'></div>
                    <div class="btn-observer-color-selector green" data-id='green'></div>
                    <div class="btn-observer-color-selector blue" data-id='blue'></div>
                    <div class="btn-observer-color-selector yellow" data-id='yellow'></div>
                    <div class="btn-observer-color-selector red" data-id='red'></div>
                </div>
            </div>
            <div class="" id="observations">
                <h3 class="panel-heading-text"><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>                  
            </div>
            <div class="" id="notes-container"></div>
        </div>
        <div class="col-md-7 col-lg-7" id="column-right" style="margin-bottom: 15px" data-original-col-specs="col-md-7 col-lg-7">
            <div class="alert-space alert-please-wait"></div>
            <div class="hidden" id="identified-trigger">
                <h3 class="headline" style="margin-top: 0px"><?php echo $lang->favoriteTrigger ?></h3>
                <div class="alert-space alert-waiting-for-tester"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="row" id="thumbnail-container"></div>
                    </div>
                    <div class="col-md-8">
                        <div class="question-container"></div>
                    </div>
                </div>
            </div>
            <div id="scene-container" class="text-center hidden" style="position: absolute; right:15px; left:15px; border-radius: 8px" allowtransparency></div>
        </div>

    </div>


    <div class="root row" id="exploration" style="">

        <div class="col-md-5 col-lg-5 rtc-scalable" id="column-left" style="margin-bottom: 15px;">
            <div class="" id="observation-annotations">
                <h3 class="panel-heading-text"><?php echo $lang->annotations ?></h3>
                <div class="observation-annotation-select">
                    <div class="btn-observer-color-selector darkblue" data-id='darkblue'></div>
                    <div class="btn-observer-color-selector green" data-id='green'></div>
                    <div class="btn-observer-color-selector blue" data-id='blue'></div>
                    <div class="btn-observer-color-selector yellow" data-id='yellow'></div>
                    <div class="btn-observer-color-selector red" data-id='red'></div>
                </div>
            </div>
            <div class="" id="observations">
                <h3 class="panel-heading-text"><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>                  
            </div>
            <div class="" id="notes-container"></div>
        </div>
        <div class="col-md-7 col-lg-7" id="column-right" style="margin-bottom: 15px" data-original-col-specs="col-md-7 col-lg-7">
            <div class="alert-space alert-please-wait"></div>
            <div id="scene-container" class="text-center hidden" style="position: absolute; right:15px; left:15px; border-radius: 8px" allowtransparency></div>

            <div class="hidden" id="identified-gestures">
                <h3 class="headline" style="margin-top: 0px"><?php echo $lang->favoriteGestures ?></h3>
                <div class="alert-space alert-waiting-for-tester"></div>
                <div class="question-container"></div>
            </div>

            <div class="hidden" id="identified-trigger">
                <h3 class="headline" style="margin-top: 0px"><?php echo $lang->favoriteTrigger ?></h3>
                <div class="alert-space alert-waiting-for-tester"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="row" id="thumbnail-container"></div>
                    </div>
                    <div class="col-md-8">
                        <div class="question-container"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <div class="root row" id="gestureTraining" style="">

        <div class="col-md-5 col-lg-5 rtc-scalable" id="column-left" style="margin-bottom: 15px;">
            <div class="" id="observation-annotations">
                <h3 class="panel-heading-text"><?php echo $lang->annotations ?></h3>
                <div class="observation-annotation-select">
                    <div class="btn-observer-color-selector darkblue" data-id='darkblue'></div>
                    <div class="btn-observer-color-selector green" data-id='green'></div>
                    <div class="btn-observer-color-selector blue" data-id='blue'></div>
                    <div class="btn-observer-color-selector yellow" data-id='yellow'></div>
                    <div class="btn-observer-color-selector red" data-id='red'></div>
                </div>
            </div>
            <div class="" id="observations">
                <h3 class="panel-heading-text"><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>                  
            </div>
            <div class="" id="notes-container"></div>
        </div>
        <div class="col-md-7 col-lg-7" id="column-right" style="margin-bottom: 15px" data-original-col-specs="col-md-7 col-lg-7">
            <div class="alert-space alert-please-wait"></div>
            <div id="scene-container" class="text-center hidden" style="position: absolute; right:15px; left:15px; border-radius: 8px" allowtransparency></div>
        </div>

    </div>



    <div class="root row" id="scenario" style="">

        <div class="col-md-5 col-lg-5 rtc-scalable" id="column-left" style="margin-bottom: 15px;">
            <div class="" id="observation-annotations">
                <h3 class="panel-heading-text"><?php echo $lang->annotations ?></h3>
                <div class="observation-annotation-select">
                    <div class="btn-observer-color-selector darkblue" data-id='darkblue'></div>
                    <div class="btn-observer-color-selector green" data-id='green'></div>
                    <div class="btn-observer-color-selector blue" data-id='blue'></div>
                    <div class="btn-observer-color-selector yellow" data-id='yellow'></div>
                    <div class="btn-observer-color-selector red" data-id='red'></div>
                </div>
            </div>
            <div class="" id="observations">
                <h3 class="panel-heading-text"><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>
            </div>
            <div class="" id="notes-container"></div>
        </div>
        <div class="col-md-7 col-lg-7" id="column-right" style="margin-bottom: 15px" data-original-col-specs="col-md-7 col-lg-7">
            <div class="alert-space alert-please-wait"></div>
            <div id="scene-container" class="text-center hidden" style="position: absolute; right:15px; left:15px; border-radius: 8px" allowtransparency></div>
        </div>

    </div>



    <div class="root row" id="gestureSlideshow" style="">

        <div class="col-md-5 col-lg-5 rtc-scalable" id="column-left" style="margin-bottom: 15px;">
            <div class="" id="observation-annotations">
                <h3 class="panel-heading-text"><?php echo $lang->annotations ?></h3>
                <div class="observation-annotation-select">
                    <div class="btn-observer-color-selector darkblue" data-id='darkblue'></div>
                    <div class="btn-observer-color-selector green" data-id='green'></div>
                    <div class="btn-observer-color-selector blue" data-id='blue'></div>
                    <div class="btn-observer-color-selector yellow" data-id='yellow'></div>
                    <div class="btn-observer-color-selector red" data-id='red'></div>
                </div>
            </div>
            <div class="" id="observations">
                <h3 class="panel-heading-text"><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>
            </div>
            <div class="" id="notes-container"></div>
        </div>
        <div class="col-md-7 col-lg-7" id="column-right" style="margin-bottom: 15px" data-original-col-specs="col-md-7 col-lg-7">
            <div class="alert-space alert-please-wait"></div>
            <div class="row hidden" id="slideshowContainer"></div>

            <div id="ask-gesture-container" class="hidden">
                <div class="progress progress-slideshow hidden" style="border-radius: 10px;">
                    <div class="progress-bar progress-bar-slideshow progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 100%"></div>
                </div>
                <div class="trigger-title text-center" style="font-size: 30pt; color: #303030; font-weight: bold; line-height: 1.3em;"></div>
            </div>
        </div>

    </div>



    <div class="root row" id="triggerSlideshow" style="">

        <div class="col-md-5 col-lg-5 rtc-scalable" id="column-left" style="margin-bottom: 15px;">
            <div class="" id="observation-annotations">
                <h3 class="panel-heading-text"><?php echo $lang->annotations ?></h3>
                <div class="observation-annotation-select">
                    <div class="btn-observer-color-selector darkblue" data-id='darkblue'></div>
                    <div class="btn-observer-color-selector green" data-id='green'></div>
                    <div class="btn-observer-color-selector blue" data-id='blue'></div>
                    <div class="btn-observer-color-selector yellow" data-id='yellow'></div>
                    <div class="btn-observer-color-selector red" data-id='red'></div>
                </div>
            </div>
            <div class="" id="observations">
                <h3 class="panel-heading-text"><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>
            </div>
            <div class="" id="notes-container"></div>
        </div>
        <div class="col-md-7 col-lg-7" id="column-right" style="margin-bottom: 15px" data-original-col-specs="col-md-7 col-lg-7">
            <div class="alert-space alert-please-wait"></div>

            <div id="elements" class="hidden">
                <h3 style="margin-top: 0px"><?php echo $lang->studyCatalogs->trigger ?></h3>
                <div class="question-container" style="margin-top: 20px"></div>
            </div>

        </div>

    </div>



    <div class="root row" id="physicalStressTest" style="">

        <div class="col-md-5 col-lg-5 rtc-scalable" id="column-left" style="margin-bottom: 15px;">
            <div class="" id="observation-annotations">
                <h3 class="panel-heading-text"><?php echo $lang->annotations ?></h3>
                <div class="observation-annotation-select">
                    <div class="btn-observer-color-selector darkblue" data-id='darkblue'></div>
                    <div class="btn-observer-color-selector green" data-id='green'></div>
                    <div class="btn-observer-color-selector blue" data-id='blue'></div>
                    <div class="btn-observer-color-selector yellow" data-id='yellow'></div>
                    <div class="btn-observer-color-selector red" data-id='red'></div>
                </div>
            </div>
            <div class="" id="observations">
                <h3 class="panel-heading-text"><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>
            </div>
            <div class="" id="notes-container"></div>
        </div>
        <div class="col-md-7 col-lg-7" id="column-right" style="margin-bottom: 15px" data-original-col-specs="col-md-7 col-lg-7">
            <div class="alert-space alert-please-wait"></div>
            <div id="stress-test-controls" class="hidden">
                <h3 class="headline" style="margin-top: 0px"></h3>
                <div class="row" id="stress-test-controls-container"></div>
            </div>

            <div id="question-container" class="hidden" style="margin-top: 10px"></div>
        </div>

    </div>




    <div class="row root" id="gus">
        <div class="col-md-5 rtc-scalable" id="column-left" style="margin-bottom: 15px;">
            <div class="" id="notes-container"></div>
        </div>
        <div class="col-md-7" id="column-right" style="margin-bottom: 15px">
            <h3 style="margin-top: 0"><?php echo $lang->formats->gus->text ?></h3>
            <div class="row">
                <div class="col-sm-6">
                    <div id="gesture"><span class="address"></span> <span class="text"></span></div>
                    <div id="trigger"><span class="address"></span> <span class="text"></span></div>
                    <div id="feedback"><span class="address"></span> <span class="text"></span></div>
                </div>

                <div class="col-sm-6">
                    <div class="previewGesture autoplay mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
                    <div class="text-center gestureControls">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                            <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 question-container" style="margin-top: 10px"></div>
            </div>
        </div>
    </div>

    <div class="row root" id="questionnaireGestures">
        <div class="col-md-5 rtc-scalable" id="column-left" style="margin-bottom: 15px;">
            <div class="" id="notes-container"></div>
        </div>
        <div class="col-md-7" id="column-right">
            <h3 style="margin-top: 0"><?php echo $lang->formats->questionnaireGestures->text ?></h3>
            <div class="question-container" style="margin-top: 10px"></div>
        </div>
    </div>

    <div class="row root" id="sus">
        <div class="col-md-5 rtc-scalable" id="column-left" style="margin-bottom: 15px;">
            <div class="" id="notes-container"></div>
        </div>
        <div class="col-md-7" id="column-right">
            <h3 style="margin-top: 0"><?php echo $lang->formats->sus->text ?></h3>
            <div class="question-container" style="margin-top: 10px"></div>
        </div>
    </div>

    <div class="row root" id="ueq">
        <div class="col-md-5 rtc-scalable" id="column-left" style="margin-bottom: 15px;">
            <div class="" id="notes-container"></div>
        </div>
        <div class="col-md-7" id="column-right">
            <h3 style="margin-top: 0"><?php echo $lang->formats->ueq->text ?></h3>
            <div class="question-container" style="margin-top: 10px"></div>
        </div>
    </div>

    <div class="row root" id="questionnaire">
        <div class="col-md-5 rtc-scalable" id="column-left" style="margin-bottom: 15px;">
            <div class="" id="notes-container"></div>
        </div>
        <div class="col-md-7" id="column-right">
            <h3 style="margin-top: 0"><?php echo $lang->formats->questionnaire->text ?></h3>
            <div class="question-container" style="margin-top: 10px"></div>
        </div>
    </div>

    <div class="row root" id="interview">
        <div class="col-md-5 rtc-scalable" id="column-left" style="margin-bottom: 15px;">
            <div class="" id="observation-annotations">
                <h3 class="panel-heading-text"><?php echo $lang->annotations ?></h3>
                <div class="observation-annotation-select">
                    <div class="btn-observer-color-selector darkblue" data-id='darkblue'></div>
                    <div class="btn-observer-color-selector green" data-id='green'></div>
                    <div class="btn-observer-color-selector blue" data-id='blue'></div>
                    <div class="btn-observer-color-selector yellow" data-id='yellow'></div>
                    <div class="btn-observer-color-selector red" data-id='red'></div>
                </div>
            </div>
            <div class="" id="notes-container"></div>
        </div>
        <div class="col-md-7" id="column-right">
            <h3 style="margin-top: 0"><?php echo $lang->formats->interview->text ?></h3>
            <div class="question-container" style="margin-top: 10px"></div>
        </div>
    </div>


</div>





















<div id="item-container-wizard" class="hidden">

    <div class="root" id="notes" style="">
        <h3 id="headline" style="margin-top: 0"><?php echo $lang->notes ?></h3>
        <textarea class="form-control" id="notes-input" rows="5"></textarea>
    </div>



    <div id="observer-web-rtc-placeholder" class="web-rtc-placeholder embed-responsive embed-responsive-4by3" style="position: absolute">
        <img class="embed-responsive-item" src="img/web-rtc-placeholder.png" width="100%" height="auto"/>
        <div class="btn-group stream-controls" id="stream-controls" style="position: absolute; bottom: 6px; left: 50%; transform: translate(-50%, 0); opacity: 0; display:flex">
            <button type="button" class="btn btn-sm stream-control" id="btn-stream-local-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->muteMicrofone ?>"><i class="fa fa-microphone-slash"></i> </button>
            <button type="button" class="btn btn-sm stream-control" id="btn-pause-stream" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOwnWebRTC ?>"><i class="fa fa-pause"></i> </button>
            <button type="button" class="btn btn-sm stream-control" id="btn-stream-remote-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOtherWebRTC ?>"><i class="fa fa-volume-up"></i> </button>
            <button type="button" class="btn btn-sm stream-control pinned" id="btn-toggle-rtc-fixed" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->dragRTC ?>"><i class="fa fa-window-restore"></i> </button>
        </div>
        <div class="hidden record-stream-indicator" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->recordingStream ?>"><i class="fa fa-video-camera"></i></div>

        <img class="hidden" src="img/resize.png" id="resize-sign" style="position: absolute; bottom: 0; right: 0;"/>
    </div>

    <div class="row root" id="no-phase-data">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <div class="alert-space alert-no-phase-data"></div>
        </div>
    </div>


    <div class="row root" id="letterOfAcceptance">
        <div class="col-md-6 col-lg-4 rtc-scalable" id="column-left">
        </div>
        <div class="col-md-6 col-lg-8" id="column-right" style="margin-bottom: 15px">
            <div class="">
                <div class="">
                    <h3 style="margin-top: 0"><?php echo $lang->formats->letterOfAcceptance->text ?></h3>
                </div>
                <div class="">
                    <p class="text letter-text" style="white-space:pre-wrap;"></p>
                    <div class="alert-space alert-please-wait"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row root" id="thanks">

        <div class="col-sm-5 col-md-4 rtc-scalable" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-sm-7 col-md-8" id="column-right" style="margin-bottom: 15px;">
            <h3 class="headline" style="margin-top: 0"><?php echo $lang->thanksHeadline ?></h3>
            <div class="row" style="margin-top: 20px">

                <div class="col-sm-12" id="upload-instructions" style="margin-bottom: 20px;">
                    <i class="fa fa-upload" aria-hidden="true" style="font-size: 70pt; color: #777"></i>
                    <div class="text">
                        <?php echo $lang->thanksWait ?>
                    </div>
                    <div id="rtc-uploads-status" class="hidden text" style="margin-top: 20px">

                        <div id="progress-thanks" class="">
                            <label><?php echo $lang->transferData ?>:</label>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
                                    0%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 hidden" id="upload-retry" style="margin-bottom: 20px;">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size: 70pt; color: #d9534f"></i>
                    <div class="text">
                        <p><?php echo $lang->thanksSaveError ?></p>
                        <button type="button" class="btn btn-danger btn-shadow" id="btn-retry-upload"><i class="fa fa-refresh" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->thanksResave ?></span></button>
                    </div>
                </div>
                <div class="col-sm-12 hidden" style="margin-bottom: 20px;" id="upload-done">
                    <i class="fa fa-check" aria-hidden="true" style="font-size: 70pt; color: #5cb85c"></i>
                    <div class="text">
                        <?php echo $lang->thanksSaveSuccess ?>
                    </div>
                </div>
            </div>

            <button class="btn btn-success btn-block btn-shadow" id="btn-leave-survey"><?php echo $lang->leaveExecution ?></button>
        </div>
    </div>




    <!-- scenario container -->

    <div  class="row root" id="scenario">
        <div class="col-sm-6 col-md-5 rtc-scalable" id="column-left">
            <!--            <div class="" id="observations">
                            <h3 class="panel-heading-text"><?php echo $lang->observations ?></h3>
                            <div class="alert-space alert-no-phase-data"></div>
                            <div class="question-container"></div>
                        </div>-->
        </div>

        <div class="col-sm-6 col-md-7" id="column-right">
            <div class="hidden" id="general" style="margin-bottom: 20px">
                <h3 class="headline" style="margin-top: 0px"><?php echo $lang->general ?></h3>
                <div class="">
                    <div class="alert-space alert-no-more-tasks"></div>
                    <div class="read-aloud">
                        <span class="read-aloud-text" id="description" style="padding-left: 0"></span>
                    </div>
                    <!--<div id="description"><span class="address"></span>: <span class="text font-bold"></span></div>-->
                    <div>
                        <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-open-prototype"><?php echo $lang->openPrototype ?></button>
                        <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-start-screen-sharing" ><i class="fa"></i> <?php echo $lang->startScreensharing ?></button>
                        <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-start-scenario"><?php echo $lang->startNow ?></button>
                    </div>

                </div>
            </div>
            <div class="hidden" id="scenario-controls">
                <div class="" id="assessment-controls">
                    <h3 class="headline" style="margin-top: 0"><?php echo $lang->task ?> </h3>
                    <div class="" style="padding-bottom: 0">
                        <div class="alert-space alert-no-phase-data"></div>
                        <div class="read-aloud"><span class="read-aloud-text" id="task" style="padding-left: 0"></span></div>
                        <!--<div id="task"><span class="text font-bold"></span></div>-->
                        <!--<div id="asassessment-controls-containersessment-controls-container" style=""></div>-->
                    </div>
                </div>
                <div class="" id="woz-controls">
                    <h3><?php echo $lang->wozControlElements ?> 
                        <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->execution->whichGestureWasDemonstrated ?>"></i>
                        <button class="btn btn-xs btn-default pull-right" id="btn-reset-scenes"><i class="fa fa-refresh"></i> <?php echo $lang->reset ?></button>
                    </h3>
                    <div class="" style="padding-bottom: 0">
                        <div id="wozExperiment" style="margin-bottom: 20px;">
                            <!--<div style="margin-bottom: 10px" class="text"><?php echo $lang->whichGestureWasDemonstrated ?></div>-->
                            <div class="alert-space alert-no-phase-data"></div>
                            <div class="row woz-container"></div>
                            <!--<button type="button" class="btn btn-default btn-block btn-other-gesture-fit" id="no-gesture-fit-found" style="margin-top: 20px"><?php echo $lang->anotherGestureWasDemonstrated ?></button>-->
                        </div>
                    </div>
                </div>
                <!--                <div class="" id="help-controls">
                                    <h3><?php echo $lang->help ?></h3>
                                    <div class="" style="padding-bottom: 0">
                                        <div class="alert-space alert-no-phase-data"></div>
                                        <div class="help-container"></div>
                                    </div>
                                </div>-->
            </div>

            <div class="alert-space alert-quit-screen-sharing"></div>
            <div class="alert-space alert-phase-step-done"></div>
            <div style="margin-top: 0px">
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-stop-screen-sharing" ><?php echo $lang->stopScreensharing ?></button>
                <!--<button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-done-scenario"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>-->
            </div>

        </div>
    </div>



</div>





















<div id="item-container-tester" class="hidden">

    <!-- alerts -->
    <div class="row root" id="no-phase-data">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <div class="alert-space alert-no-phase-data"></div>
        </div>
    </div>
    <!--    <div class="container root" id="no-phase-data" style="margin-top: 80px;">
            <div class="alert-space alert-no-phase-data"></div>
        </div>-->


    <!-- rtc preview -->
    <!--        <div id="tester-web-rtc-placeholder" class="web-rtc-placeholder" style="width: 100%;">
                <img src="img/web-rtc-placeholder.png" style="width: 100%; height: auto;" />
            </div>-->

    <!--    <div id="tester-web-rtc-placeholder" class="web-rtc-placeholder embed-responsive embed-responsive-4by3" style="position: absolute">
            <div class="root embed-responsive embed-responsive-4by3" style="background-color: #eeeeee; border-top-left-radius: 5px; border-top-right-radius: 5px">
            <div class="embed-responsive-item" style="border-radius: 8px; background-color: #eee;display: flex; justify-content: center; align-items: center;">
                <i class="fa fa-circle-o-notch fa-spin fa-3x"></i>
            </div>
    
            <div class="embed-responsive-item" id="alerts-container" style="padding: 15px">
                <div class="alert-space alert-rtc-permission-denied"></div>
            </div>
    
            <div class="embed-responsive-item">
                <video class="recorder-webcam-video mirroredHorizontally" autoplay ></video>
            </div>
    
    
                    <div id="remote-stream" class="rtc-remote-container rtc-stream embed-responsive-item" style="border-radius: 8px;"></div>
                    <div class="rtc-local-container embed-responsive-item">
                        <video autoplay id="local-stream" class="rtc-stream" style="display:block;"></video>
                    </div>
            <div class="btn-group" id="stream-controls" style="position: absolute; bottom: 6px; left: 50%; transform: translate(-50%, 0); opacity: 0">
                <button type="button" class="btn btn-sm stream-control disabled" id="btn-stream-local-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->muteMicrofone ?>"><i class="fa fa-microphone-slash"></i> </button>
                <button type="button" class="btn btn-sm stream-control disabled" id="btn-pause-stream" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOwnWebRTC ?>"><i class="fa fa-pause"></i> </button>
                <button type="button" class="btn btn-sm stream-control disabled" id="btn-stream-remote-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOtherWebRTC ?>"><i class="fa fa-volume-up"></i> </button>
                <button type="button" class="btn btn-sm stream-control pinned" id="btn-toggle-rtc-fixed" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->dragRTC ?>"><i class="fa fa-window-restore"></i> </button>
                <button type="button" class="btn btn-sm stream-control" id="btn-config-rtc" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->configRTC ?>"><i class="fa fa-cog"></i> </button>
            </div>
    
            <div class="record-stream-indicator" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->recordingStream ?>"><i class="fa fa-video-camera"></i></div>
    
            <div id="stream-control-indicator">
                <div style="position: absolute; top: 4px; display: block; left: 10px; opacity: 1; color: white">
                    <i id="mute-local-audio" class="hidden fa fa-microphone-slash" style="margin-right: 3px"></i>
                    <i id="pause-local-stream" class="hidden fa fa-pause"></i>
                </div>
                <div style="position: absolute; top: 4px; display: block; right: 10px; opacity: 1; color: white">
                    <i id="mute-remote-audio" class="hidden fa fa-microphone-slash"></i>
                    <i id="pause-remote-stream" class="hidden fa fa-pause" style="margin-left: 3px"></i>
                </div>
            </div>
    
            <div id="rtc-config-panel" class="hidden" style="border-radius: 8px; background-color: rgba(0,0,0,.4); padding: 15px 15px 0px 15px; position: absolute; top:0px; bottom:0px; left: 0px; right: 0px">
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
                <div class="form-group" id="audio-input-select">
                    <label style="margin: 0; color: white"><?php echo $lang->chooseAudioInput ?></label><br>
    
                    <div class="input-group">
                        <input class="form-control item-input-text show-dropdown" tabindex="-1" type="text" value=""/>
                        <div class="input-group-btn select select-audio-input" role="group">
                            <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            </ul>
                        </div>
                    </div>
                </div>
    
                <button class="btn btn-default btn-block btn-shadow" id="btn-close-config"><i class="fa fa-check"></i></button>
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
    
        </div>-->

    <div id="tester-web-rtc-placeholder" class="web-rtc-placeholder embed-responsive embed-responsive-4by3" style="position: absolute">
        <img class="embed-responsive-item" src="img/web-rtc-placeholder.png" style="width: 30%; height: auto; box-shadow: 0 0 10px rgba(0,0,0,.2); border-radius: 5px; left: 5px; top: 5px;">
        <div style="left: 10px; top: 2px; position: absolute;"><?php echo $lang->userTypes->tester ?></div>
        </img>

        <div style="right: 10px; top: 2px; position: absolute;"><?php echo $lang->userTypes->evaluator ?></div>

        <img class="embed-responsive-item" src="img/web-rtc-placeholder.png" width="100%" height="auto"/>
        <div class="btn-group stream-controls" id="stream-controls" style="position: absolute; bottom: 6px; left: 50%; transform: translate(-50%, 0); opacity: 0; display:flex">
            <button type="button" class="btn btn-sm stream-control" id="btn-hide-stream" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->hideStream ?>"><i class="fa fa-close"></i> </button>
            <button type="button" class="btn btn-sm stream-control" id="btn-stream-local-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->muteMicrofone ?>"><i class="fa fa-microphone-slash"></i> </button>
            <button type="button" class="btn btn-sm stream-control" id="btn-pause-stream" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOwnWebRTC ?>"><i class="fa fa-pause"></i> </button>
            <button type="button" class="btn btn-sm stream-control" id="btn-stream-remote-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOtherWebRTC ?>"><i class="fa fa-volume-up"></i> </button>
            <button type="button" class="btn btn-sm stream-control pinned" id="btn-toggle-rtc-fixed" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->dragRTC ?>"><i class="fa fa-window-restore"></i> </button>
        </div>
        <div class="record-stream-indicator hidden" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->recordingStream ?>"><i class="fa fa-video-camera"></i></div>

        <img class="hidden" src="img/resize.png" id="resize-sign" style="position: absolute; bottom: 0; right: 0;"/>
    </div>








    <!-- main formats -->

    <!-- execution preparation -->
    <div class="root container" id="executionPreparation" style="">
        <div class="row" id="preparation-study-details">
            <div class="col-xs-12">
                <h2 id="preparation-study-headline" style="margin-top: 0"></h2>
                <hr style="">

                <div class="row">
                    <div class="col-sm-5 col-md-6" id="preparation-study-details-container">
                        <div class="alert-space alert-study-over-range"></div>
                        <div class="alert-space alert-study-under-range"></div>

                        <div id="preparation-study-description">
                            <p class="text"></p>
                        </div>

                        <div class="hidden preparation-study-plan"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>
                        <button class="btn btn-block btn-info btn-shadow" id="btn-preparation-enter-study"><?php echo $lang->enterStudyAsTester ?></button>
                    </div>
                    <div class="col-sm-7 col-md-6" id="preparation-study-participation">
                        <div class="row">
                            <div class="col-xs-12">
                                <div id="preparation-participant-name">
                                    <div class="alert-space alert-insert-name" style=""></div>
                                    <div class="form-group">
                                        <label><?php echo $lang->name ?></label>
                                        <div class="alert-space alert-missing-name" style=""></div>
                                        <input type="text"class="form-control" id="preparation-name-input" maxlength="100">
                                    </div>

                                    <button type="button" class="btn btn-block btn-default btn-shadow" id="btn-preparation-request-participation">Teilnahme anfragen</button>
                                </div>

                                <div id="preparation-check-rtc-status" class="hidden">
                                    <h3>Technische Überprüfung</h3>
                                    <div class="preparation-check-web-rtc">
                                        <span class="status-check-indicator">
                                            <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                                            <i class="status-warn fa fa-warning warning hidden"></i>
                                            <i class="status-supported fa fa-check success hidden"></i>
                                        </span>
                                        <span class="status-check-text text">WebRTC</span>
                                    </div>
                                    <div class="check-webcam">
                                        <span class="status-check-indicator">
                                            <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                                            <i class="status-warn fa fa-warning warning hidden"></i>
                                            <i class="status-supported fa fa-check success hidden"></i>
                                        </span>
                                        <span class="status-check-text text">Webcam</span>
                                    </div>
                                    <div class="check-microphone">
                                        <span class="status-check-indicator">
                                            <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                                            <i class="status-warn fa fa-warning warning hidden"></i>
                                            <i class="status-supported fa fa-check success hidden"></i>
                                        </span>
                                        <span class="status-check-text text">Mikrofon</span>
                                    </div>
                                    <div class="check-speakers">
                                        <span class="status-check-indicator">
                                            <i class="status-wait fa fa-circle-o-notch fa-spin"></i>
                                            <i class="status-warn fa fa-warning warning hidden"></i>
                                            <i class="status-supported fa fa-check success hidden"></i>
                                        </span>
                                        <span class="status-check-text text">Audioausgabe</span>
                                    </div>

                                    <div id="preparation-init-timer-progress" class="hidden">
                                        <div class="progress" style="height: 10px; border-radius: 8px; margin-top: 10px">
                                            <div class="progress-bar progress-bar-primary" id="preparation-init-timer-progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%; width: 100%; background-color: #5cb85c"></div>
                                        </div>
                                        <div class="text-center" style="margin-top: -20px; margin-bottom: 20px">initialisieren …</div>
                                    </div>

                                </div>

                                <div class="hidden" id="preparation-video-caller-container">
                                    <div class="embed-responsive embed-responsive-4by3" id="preparation-video-caller">
                                        <img class="embed-responsive-item" src="img/web-rtc-placeholder.png" style="width: 30%; height: auto; box-shadow: 0 0 10px rgba(0,0,0,.2); border-radius: 5px; left: 5px; top: 5px;">
                                        <div style="left: 10px; top: 2px; position: absolute;"><?php echo $lang->userTypes->tester ?></div>
                                        </img>

                                        <div style="right: 10px; top: 2px; position: absolute;"><?php echo $lang->userTypes->evaluator ?></div>

                                        <img class="embed-responsive-item" src="img/web-rtc-placeholder.png" width="100%" height="auto" style="border-radius:8px; border: 1px solid #eeeeee;"/>

                                        <!--                                        <div class="embed-responsive-item" style="border-radius: 8px; background-color: #eee;display: flex; justify-content: center; align-items: center;">
                                                                                    <i class="fa fa-circle-o-notch fa-spin fa-3x"></i>
                                                                                </div>
                                                                                <div id="preparation-remote-stream" class="rtc-remote-container rtc-stream embed-responsive-item" style="border-radius: 8px;"></div>
                                                                                <div class="rtc-local-container embed-responsive-item">
                                                                                    <video autoplay id="preparation-local-stream" class="preparation-rtc-stream" style="display:block;"></video>
                                                                                </div>
                                                                                <div class="btn-group" id="preparation-stream-controls" style="position: absolute; bottom: 6px; left: 50%; transform: translate(-50%, 0); opacity: 0">
                                                                                    <button type="button" class="btn btn-sm stream-control" id="btn-preparation-stream-local-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->muteMicrofone ?>"><i class="fa fa-microphone-slash"></i> </button>
                                                                                    <button type="button" class="btn btn-sm stream-control" id="btn-preparation-pause-stream" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOwnWebRTC ?>"><i class="fa fa-pause"></i> </button>
                                                                                    <button type="button" class="btn btn-sm stream-control" id="btn-preparation-stream-remote-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOtherWebRTC ?>"><i class="fa fa-volume-up"></i> </button>
                                                                                    <button type="button" class="btn btn-sm stream-control" id="btn-preparation-config-rtc" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->configRTC ?>"><i class="fa fa-cog"></i> </button>
                                                                                </div>
                                                                                <div id="preparation-stream-control-indicator">
                                                                                    <div style="position: absolute; top: 4px; display: block; left: 10px; opacity: 1; color: white">
                                                                                        <i id="preparation-mute-local-audio" class="hidden fa fa-microphone-slash" style="margin-right: 3px"></i>
                                                                                        <i id="preparation-pause-local-stream" class="hidden fa fa-pause"></i>
                                                                                    </div>
                                                                                    <div style="position: absolute; top: 4px; display: block; right: 10px; opacity: 1; color: white">
                                                                                        <i id="preparation-mute-remote-audio" class="hidden fa fa-microphone-slash"></i>
                                                                                        <i id="preparation-pause-remote-stream" class="hidden fa fa-pause" style="margin-left: 3px"></i>
                                                                                    </div>
                                                                                </div>
                                        
                                                                                <div id="preparation-rtc-config-panel" class="hidden" style="border-radius: 8px; background-color: rgba(0,0,0,.4); padding: 15px 15px 0px 15px; position: absolute; top:0px; bottom:0px; left: 0px; right: 0px">
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
                                                                                    <div class="form-group" id="audio-input-select">
                                                                                        <label style="margin: 0; color: white"><?php echo $lang->chooseAudioInput ?></label><br>
                                        
                                                                                        <div class="input-group">
                                                                                            <input class="form-control item-input-text show-dropdown" tabindex="-1" type="text" value=""/>
                                                                                            <div class="input-group-btn select select-audio-input" role="group">
                                                                                                <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                                                                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                        
                                                                                    <button class="btn btn-default btn-block btn-shadow" id="btn-close-config"><i class="fa fa-check"></i></button>
                                                                                </div>-->
                                    </div>

                                    <div class="alert-space alert-waiting-for-moderator" style="margin-top: 10px"></div>
                                </div>
                            </div>
                            <div class="col-xs-12" style="margin-top: 10px">
                                <div id="preparation-alert-hints">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>






    <div class="root" id="letterOfAcceptance" style=""></div>

    <div id="letterOfAcceptance-moderated" class="row">
        <div class="col-md-5 col-lg-4 rtc-scalable" id="column-left" style="margin-bottom: 15px;"></div>

        <div class="col-md-7 col-lg-8" id="column-right" style="margin-bottom: 15px" data-original-col-specs="col-md-8 col-lg-9">
            <h3 class="headline" style="margin-top: 0" ><?php echo $lang->formats->letterOfAcceptance->text ?></h3>
            <div class="letter-text text" style="white-space:pre-wrap;"></div>
            <div style="margin-top: 20px">
                <button type="button" class="btn btn-success btn-shadow" id="letter-agreed"><i class="fa fa-check"></i> <?php echo $lang->letterOfAcceptanceAccept ?></button>
                <button type="button" class="btn btn-danger btn-shadow pull-right" id="letter-decline"><i class="fa fa-close"></i> <?php echo $lang->letterOfAcceptanceNotAccept ?></button>
            </div>
        </div>
    </div>


    <div class="" id="letterOfAcceptance-unmoderated">
        <h3 class="headline" style="margin-top: 0"><?php echo $lang->formats->letterOfAcceptance->text ?></h3>
        <div class="letter-text" style="white-space:pre-wrap;"></div>
        <div style="margin-top: 20px">
            <button type="button" class="btn btn-success btn-shadow" id="letter-agreed"><i class="fa fa-check"></i> <?php echo $lang->letterOfAcceptanceAccept ?></button>
            <button type="button" class="btn btn-danger btn-shadow pull-right" id="letter-decline"><i class="fa fa-close"></i> <?php echo $lang->letterOfAcceptanceNotAccept ?></button>
        </div>
    </div>


    <div class="root" id="questionnaire" style=""></div>
    <div class="root" id="ueq" style=""></div>

    <div id="questionnaire-moderated" class="row">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right" style="margin-bottom: 15px;" data-original-col-specs="col-md-8">
            <h3 class="headline" style="margin-top: 0"><?php echo $lang->questionnaire ?></h3>
            <div class="alert-space alert-waiting-for-moderator"></div>
            <div class="question-container"></div>
            <div class="clearfix" style="margin-top: 10px;">
                <button class="btn btn-success btn-shadow hidden btn-next-question pull-right"><?php echo $lang->next ?> <span aria-hidden="true">&rarr;</span></button>
                <button class="btn btn-success btn-shadow hidden btn-questionnaire-done pull-right" id="btn-next-step"><i class="fa fa-check"></i> <?php echo $lang->done ?></button>
            </div>
        </div>
    </div>

    <div class="container" id="questionnaire-unmoderated">
        <h3 class="headline" style="margin-top: 0"><?php echo $lang->questionnaire ?></h3>
        <div class="question-container"></div>
        <button class="next-step btn btn-success pull-right" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
    </div>


    <!-- interview container & item -->
    <div class="root row" id="interview" style="">
        <div class="col-md-5" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-7" id="column-right" style="margin-bottom: 15px;" data-original-col-specs="col-md-7">
            <h3 class="headline" style="margin-top: 0"><?php echo $lang->formats->interview->text ?></h3>
            <div class="question-container"></div>
        </div>
    </div>


    <!-- SUS container & item -->
    <div class="root" id="sus" style=""></div>

    <div id="sus-moderated" class="row">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right" style="" data-original-col-specs="col-md-8">
            <div class="alert-space alert-waiting-for-moderator"></div>
            <h3 class="headline" style="margin-top: 0"><?php echo $lang->questionnaireSystem ?></h3>
            <div class="question-container"></div>
            <button class="next-step btn btn-success pull-right btn-questionnaire-done" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div class="container" id="sus-unmoderated">
        <h3 class="headline" style="margin-top: 0"><?php echo $lang->questionnaireSystem ?></h3>
        <div class="question-container"></div>
        <button class="next-step btn btn-success pull-right" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
    </div>

    <!-- GUS container & item -->
    <div class="root" id="gus" style=""></div>

    <div id="gus-moderated" class="row">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right" style="margin-bottom: 15px" data-original-col-specs="col-md-8">
            <div class="alert-space alert-waiting-for-moderator"></div>
            <div id="gus-questionnaire-content">
                <div class="row">
                    <div class="col-sm-6 right" style="margin-bottom: 10px;">
                        <div id="gesture"><span class="address"></span> <span class="text"></span></div>
                        <div id="trigger"><span class="address"></span> <span class="text"></span></div>
                        <div id="feedback"><span class="address"></span> <span class="text"></span></div>
                    </div>
                    <div class="col-sm-6 left" id="gesturePreview">
                        <div class="previewGesture autoplay mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
                        <div class="text-center gestureControls">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                                <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="question-container" style="margin-top: 20px; margin-bottom: 10px"></div>
                <button class="next-step btn btn-success pull-right btn-questionnaire-done"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
            </div>

        </div>
    </div>

    <div class="container" id="gus-unmoderated">
        <h3 class="headline" style="margin-top: 0"><?php echo $lang->questionnaireGesture ?></h3>
        <div class="row">
            <div class="col-sm-6 right" style="margin-bottom: 10px;">
                <div id="gesture"><span class="address"></span> <span class="text"></span></div>
                <div id="trigger"><span class="address"></span> <span class="text"></span></div>
                <div id="feedback"><span class="address"></span> <span class="text"></span></div>
            </div>
            <div class="col-sm-6 left" id="gesturePreview">
                <div class="previewGesture autoplay mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <!--<hr>-->
        <div class="question-container" style="margin-top: 20px; margin-bottom: 10px"></div>
        <!--<hr>-->
        <button class="next-step btn btn-success pull-right" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
    </div>


    <!-- gesture questionnaire container & item -->
    <div class="root" id="questionnaireGestures" style=""></div>

    <div id="questionnaireGestures-moderated" class="row">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right" style="margin-bottom: 15px" data-original-col-specs="col-md-8">
            <h3 class="headline" style="margin-top: 0"><?php echo $lang->questionnaireGestures ?></h3>
            <!--<hr>-->
            <div class="question-container"></div>
            <!--<hr>-->
            <button class="next-step btn btn-success pull-right" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div class="container" id="questionnaireGestures-unmoderated">
        <h3 class="headline" style="margin-top: 0"><?php echo $lang->questionnaireGestures ?></h3>
        <!--<hr>-->
        <div class="question-container"></div>
        <!--<hr>-->
        <button class="next-step btn btn-success pull-right" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
    </div>

    <!-- gesture training container -->
    <!--    <div class="root" id="gestureTraining" style="margin-top: 80px;">
            <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
            <div class="row">
            <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
            <div class="col-md-8" id="column-right" style="margin-bottom: 80px;">
                <div id="general">
                    <h3 class="headline" style="margin: 0"></h3>
                    <div class="description"></div>
                    <hr>
                </div>
                <div class="alert-space alert-please-wait"></div>
                <div class="row" id="trainingContainer"></div>
            </div>
            </div>
        </div>-->

    <div class="root row" id="gestureTraining" style="">

        <div class="col-md-4 col-lg-3" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8 col-lg-9" id="column-right" style="margin-bottom: 15px" data-original-col-specs="col-md-8 col-lg-9">
            <div class="alert-space alert-please-wait"></div>
            <div id="scene-container" class="text-center hidden" style="position: absolute; right:15px; left:15px; border-radius: 8px; background-color: #eee" allowtransparency></div>
        </div>


        <!--<div id="fixed-rtc-preview" class="rtc-shadow" style="position: fixed; width: 300px; left: 10px; pointer-events: none; opacity: 0.8"></div>-->
        <!--        <div id="scene-container" class="text-center" style="position: fixed; top:-55px; width: 100%;" allowtransparency></div>
        
                <div id="fixed-rtc-preview" class="hidden rtc-shadow" style="position: fixed; width: 300px; top: 5px; left: 10px; pointer-events: none; opacity: 0.8"></div>-->

        <!--        <div class="" style="margin-top: 55px; padding: 20px">
                    <div class="alert-space alert-please-wait"></div>
                </div>-->
    </div>

    <!--    <div class="root" id="gestureTraining" style="width: 100%; margin-top: 54px">
    
            <div id="scene-container" class="text-center" style="position: fixed; top:0px; width: 100%;" allowtransparency></div>
            <div id="fixed-rtc-preview" class="rtc-shadow" style="position: fixed; width: 300px; left: 10px; pointer-events: none; opacity: 0.8"></div>
                    <div id="scene-container" class="text-center" style="position: fixed; top:-55px; width: 100%;" allowtransparency></div>
            
                    <div id="fixed-rtc-preview" class="hidden rtc-shadow" style="position: fixed; width: 300px; top: 5px; left: 10px; pointer-events: none; opacity: 0.8"></div>
    
            <div class="" style="margin-top: 55px; padding: 20px">
                <div class="alert-space alert-please-wait"></div>
            </div>
        </div>-->

    <!--    <div id="trainingItemModerated">
            <div class="col-sm-6" style="margin-bottom: 10px;">
                <div>
                <div id="title"><span class="address"></span> <span class="text"></span></div>
                <div id="repeats"><span class="address"></span> <span class="text"></span></div>
                <div id="trigger"><span class="address"></span> <span class="text"></span></div>
                <div id="feedback"><span class="address"></span> <span class="text"></span></div>
                </div>
            </div>
            <div class="col-sm-6" style="margin-bottom: 20px;">
                <div class="previewGesture autoplay embed-responsive embed-responsive-4by3"></div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="fa fa-stop"></i></button>
                    </div>
                </div>
            </div>
        </div>-->

    <div id="trainingItemUnmoderated">
        <div class="hidden" id="training-data">
            <div class="col-sm-12 col-lg-6" style="margin-top: 20px">
                <div style="margin-bottom: 10px;">
                    <div id="title"><span class="address"></span> <span class="text"></span></div>
                    <div id="repeats"><span class="address"></span> <span class="text"></span></div>
                    <div id="trigger"><span class="address"></span> <span class="text"></span></div>
                    <div id="feedback"><span class="address"></span> <span class="text"></span></div>
                </div>
            </div>

            <div class="col-sm-12 col-lg-6" style="margin-top: 20px">
                <div class="previewGesture autoplay embed-responsive embed-responsive-4by3" style="margin:auto;"></div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12" style="margin-top: 10px">
            <div id="training-controls">
                <button class="btn btn-block btn-success btn-shadow" id="start-training" name="btn-success"><span class="btn-text"><?php echo $lang->startNow ?></span></button>
                <button class="btn btn-block btn-success btn-shadow hidden" id="start-single-training" name="btn-success"><span class="btn-text">Gesten-Training beginnen</span></button>
                <button class="btn btn-block btn-info btn-shadow hidden" id="repeat-training" name="btn-success"><span class="btn-text">Geste nochmal ausführen</span></button>
                <button class="btn btn-block btn-success btn-shadow hidden" id="next-gesture" name="btn-success"><span class="btn-text"><?php echo $lang->nextGesture ?></span> <span aria-hidden="true">&rarr;</span></button>
                <button class="btn btn-block btn-success btn-shadow hidden" id="training-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
            </div>
            <div class="progress progress-training hidden" style="border-radius: 10px">
                <div class="progress-bar progress-bar-training progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 100%"></div>
            </div>
        </div>
    </div>


    <!-- gesture slideshow container -->

    <div class="root row" id="gestureSlideshow" style="">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right" style="margin-bottom: 15px;">
            <!--            <div id="general">
                            <h3 style="margin-top: 0" class="headline"></h3>
                            <div class="description"></div>
                            <hr>
                        </div>-->
            <!--            <div id="restart" class="hidden">
                            <h3 style="" class="headline"><?php pleaseRestart ?></h3>
                            <hr>
                        </div>-->
            <div class="alert-space alert-please-wait"></div>
            <div class="row hidden" id="slideshowContainer"></div>

            <div id="ask-gesture-container" class="hidden">
                <div class="progress progress-slideshow hidden" style="border-radius: 10px;">
                    <div class="progress-bar progress-bar-slideshow progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 100%"></div>
                </div>
                <div class="trigger-title text-center" style="font-size: 30pt; color: #303030; font-weight: bold; line-height: 1.3em;"></div>
            </div>

        </div>
    </div>


    <!-- moderated gesture slideshow items -->

    <div id="gestureSlideshowOverviewItemModerated" class="col-xs-6 col-sm-4 col-md-6 col-lg-4 root">
        <div data-sensor-source="webcam" id="webcam-preview" class="autoplay">
            <div class="root embed-responsive embed-responsive-4by3">
                <div id="" class="webcam-image-container"></div>
                <div class="controls-container embed-responsive-item">
                    <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused"><i class="fa fa-play fa-2x"></i></div>
                    <!--<div class="controls-container-btn application-btn application-btn-top-left-single btn-download-as-gif" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsGIF ?>"><i class="fa fa-file-image-o"></i></div>-->
                </div>
            </div>

            <div id="webcam-playback-slider-controls" class="hidden" style="margin-top: -11px" data-visible="true">
                <div id="webcam-playback-slider-container" class="webcam-playback-slider-container" style="width: 100%;">
                    <input id="webcam-playback-slider" style="width: 100%" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide" />
                </div>
            </div>
        </div>
        <!--        <div class="previewGesture mousePlayable btn-shadow embed-responsive embed-responsive-4by3">
        
                </div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                    </div>
                </div>-->
    </div>

    <!--    <div id="gestureSlideshowItemModerated" class="text-center">
            <div class="triggerContainer hidden">
    <div class="trigger-title" style="font-size: 30pt; color: #303030; font-weight: bold; line-height: 1.3em;"></div>
            </div>
        </div>-->


    <!-- unmoderated gesture slideshow items -->

    <div id="gestureSlideshowOverviewItemUnmoderated" class="col-xs-6 col-sm-4 col-md-6 col-lg-4 root" style="margin-bottom: 15px;">
        <div class="previewGesture mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
        <div class="text-center gestureControls">
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
            </div>
        </div>
    </div>

    <!--    <div id="gestureSlideshowItemUnmoderated" class="text-center col-xs-12">
            <button class="btn btn-block btn-success btn-shadow hidden" id="startSlideshow" name="btn-success"><?php echo $lang->startNow ?></button>
    
            <div class="triggerContainer hidden">
                <div class="trigger-title" style="font-size: 30pt; color: #303030; font-weight: bold; line-height: 1.3em;"></div>
            </div>
        </div>-->


    <!-- trigger slideshow container -->

    <div class="root row" id="triggerSlideshow" style="">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right" style="margin-bottom: 15px;">
            <div class="alert-space alert-please-wait"></div>

            <div class="hidden" id="trigger-questions">
                <div style="width: 300px; height: auto; margin: 0 auto;">
                    <div class="embed-responsive embed-responsive-4by3" style="border-radius: 8px">
                        <div class="previewGesture mousePlayable"></div>
                    </div>
                    <div class="text-center gestureControls">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                            <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 20px">
                    <div class="question-container"></div>
                    <div style="margin-top: 20px">
                        <button class="btn btn-block btn-success btn-shadow hidden" id="btn-next-slide" name="btn-success"><span class="btn-text">Nächste Geste</span> <span aria-hidden="true">&rarr;</span></button>
                        <button class="btn btn-block btn-success btn-shadow hidden" id="btn-done-slide" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
                    </div>
                </div>    

            </div>
        </div>
    </div>

    <!--    <div id="triggerSlideshow-moderated">
            <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
            <div class="col-md-8" id="column-right">
                <div id="general">
                    <h3 style="margin-top: 0"  class="headline"></h3>
                    <div class="description"></div>
                    <hr>
                </div>
                <div class="alert-space alert-please-wait"></div>
                <div class="progress progress-slideshow hidden" style="border-radius: 10px;">
                    <div class="progress-bar progress-bar-slideshow progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 100%"></div>
                </div>
                <div class="row hidden" id="slideshowContainer"></div>
                <button class="btn btn-block btn-success btn-shadow" id="startSlideshow" name="btn-success"><?php echo $lang->startNow ?></button>
            </div>
        </div>
    
        <div class="container" id="triggerSlideshow-unmoderated">
            <div id="general">
                <h3 style="margin-top: 0"  class="headline"></h3>
                <div class="description"></div>
                <hr>
            </div>
            <div class="alert-space alert-please-wait"></div>
            <div class="progress progress-slideshow hidden" style="border-radius: 10px;">
                <div class="progress-bar progress-bar-slideshow progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 100%"></div>
            </div>
            <div class="row hidden" id="slideshowContainer"></div>
            <button class="btn btn-block btn-success btn-shadow" id="startSlideshow" name="btn-success"><?php echo $lang->startNow ?></button>
        </div>-->


    <!-- unmoderated trigger slideshow items -->

    <!--    <div id="triggerSlideshowItemUnmoderated">
            
        </div>-->


    <!-- exploration -->

    <div class="root row" id="exploration" style="">
        <div class="col-md-4 col-lg-3" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8 col-lg-9" id="column-right" style="margin-bottom: 15px" data-original-col-specs="col-md-8 col-lg-9">
            <div class="alert-space alert-please-wait"></div>
            <div id="scene-container" class="text-center hidden" style="position: absolute; right:15px; left:15px; border-radius: 8px; background-color: #eee" allowtransparency></div>
        </div>
    </div>

    <!--    <div id="exploration-moderated" class="row">
            <div id="scene-container" class="text-center" style="position: fixed; top:0px; width: 100%;" allowtransparency></div>
            <div class="text-shadow-black text-center hidden" id="scene-description" style="position: absolute;  left: 50%; margin-left: -225px; width: 450px; color:white; padding: 5px; background-color: rgba(0,0,0,.4); border-radius: 10px"><h4 style="color:white">Beschreibung</h4><p></p></div>
            <div id="fixed-rtc-preview" class="rtc-shadow" style="position: fixed; width: 300px; left: 10px; pointer-events: none; opacity: 0.8"></div>
    
                    <div id="scene-container" class="text-center" style="position: fixed; top:-55px; width: 100%;" allowtransparency></div>
                    <div class="text-shadow-black text-center" id="scene-description" style="position: absolute; top: 5px; left: 50%; margin-left: -225px; width: 450px; color:white; padding: 5px; background-color: rgba(0,0,0,.4); border-radius: 10px"><h4 style="color:white">Beschreibung</h4><p></p></div>
            
                    <div id="fixed-rtc-preview" class="hidden rtc-shadow" style="position: fixed; width: 300px; top: 5px; left: 10px; pointer-events: none; opacity: 0.8"></div>
    
            <div class="row" style="margin-top: 55px; padding: 20px">
                <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3"></div>
                <div class="col-xs-12 col-sm-7 col-md-8 col-lg-9">
                    <div class="alert-space alert-please-wait"></div>
                </div>
    
            </div>
        </div>-->
    <!--
        <div id="exploration-unmoderated" class="">
            <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
            <div class="col-md-8" id="column-right" style="margin-bottom: 80px;">
                <div id="general">
                    <h3 style="margin-top: 0"  class="headline"></h3>
                    <div class="description"></div>
                    <hr>
                </div>
    
                <div id="exploration-items-container"></div>
                <hr>
                <button class="btn btn-success btn-shadow pull-right" id="btn-exploration-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
            </div>
        </div>-->





    <!-- identification container -->
    <div class="root row" id="identification" style="">
        <div class="col-md-4 col-lg-3" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8 col-lg-9" id="column-right" style="margin-bottom: 15px" data-original-col-specs="col-md-8 col-lg-9">
            <div class="alert-space alert-please-wait"></div>
            <div id="scene-container" class="text-center hidden" style="position: absolute; right:15px; left:15px; border-radius: 8px; background-color: #eee" allowtransparency></div>
        </div>
    </div>


    <!--    <div class="row" id="identificationModerated">
            <div id="scene-container" class="text-center" style="position: fixed; top:0px; width: 100%;" allowtransparency></div>
            <div class="text-shadow-black text-center" id="scene-description" style="position: absolute;  left: 50%; margin-left: -225px; width: 450px; color:white; padding: 5px; background-color: rgba(0,0,0,.4); border-radius: 10px"><h4 style="color:white">Beschreibung</h4><p></p></div>
            <div id="fixed-rtc-preview" class="rtc-shadow" style="position: fixed; width: 300px; left: 10px; pointer-events: none; opacity: 0.8"></div>
    
                    <div class="" style="margin-top: 55px; padding: 20px">
                        <div class="alert-space alert-please-wait"></div>
                    </div>
    
            <div id="gesture-recorder-container" class="hidden"></div>
        </div>
    
        <div class="container" id="identificationUnmoderated" style="position: relative; top: 80px">
            <div class="row">
                <div class="col-xs-12" style="margin-bottom: 15px;" id="general">
                    <div>
                        <h3 class="headline" style="margin-top: 0"></h3>
                        <div class="description" style="color: #303030"></div>
                        <hr>
                        <button class="btn btn-block btn-success btn-shadow" id="btn-start-identification" style="margin-top: 20px"><?php echo $lang->startNow ?></button>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div id="identificationContainer" class="row"></div>
                </div>
            </div>
    
        </div>-->

    <!--    <div id="identificationItemUnmoderated">
    
            <div id="identification-content" class="hidden">
                <div id="trigger-identification">
                    <div class="col-sm-5 col-md-6 text-center" style="margin-bottom: 15px">
                        <div class="previewGesture previewProgress autoplay mousePlayable btn-shadow embed-responsive embed-responsive-4by3" style="max-width: 500px;"></div>
                        <div class="progress gesture-progress" style="max-width: 500px; margin: auto">
                            <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                        </div>
                        <div class="text-center gestureControls">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                                <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7 col-md-6">
                        <p class="text"><?php echo $lang->askTrigger ?></p>
                        <div class="form-group">
                            <label for="trigger-name"><?php echo $lang->trigger ?></label>
                            <input class="form-control" name="trigger-name" id="trigger-name">
                        </div>
                        <div class="form-group">
                            <label for="trigger-name"><?php echo $lang->justification ?></label>
                            <textarea class="form-control" rows="5" id="trigger-justification"></textarea>
                        </div>
                        <div style="margin-top: 20px;" id="next-controls" class="hidden">
                        <button type="button" class="btn btn-success btn-block btn-shadow" id="next-identification"><span class="btn-text"><span class="btn-text"><?php echo $lang->nextGesture ?></span> <span aria-hidden="true">&rarr;</span></button>
                        <button type="button" class="btn btn-success btn-block btn-shadow" id="done-identification"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
                        </div>
    
                    </div>
                </div>
    
                <div id="gesture-identification">
                    <div class="col-sm-6">
                        <div id="recorder-description" class="hidden"></div>
                    </div>
                    <div class="col-sm-6" style="margin-bottom: 80px">
                        <div style="width: 100%" class="text-center">
                            <h3 class="" id="trigger" style="margin: 0;"><span class="address"></span> <span id="text"></span></h3>
                        </div>
                        <div id="gesture-recorder-container" style="width: 450px; margin: auto; margin-top: 15px;"></div>
                        <div style="margin-top: 20px;" id="next-controls" class="hidden">
                            <button type="button" class="btn btn-success btn-block btn-shadow" id="next-identification"><span class="btn-text"><?php echo $lang->nextTrigger ?></span> <span aria-hidden="true">&rarr;</span></button>
                            <button type="button" class="btn btn-success btn-block btn-shadow" id="done-identification"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
                        </div>
                    </div>
                </div>
            </div>
    
        </div>-->

    <div class="container text-center" id="identification-description" style="height: 100%; top: 40px">
        <div style="position: relative; top: 50%; -webkit-transform: translateY(-50%); -ms-transform: translateY(-50%); transform: translateY(-50%);">
            <h3 id="description-text" class="text-shadow-black" style="color: white; width: 400px; margin: auto"></h3>
            <button type="button" class="btn btn-info btn-shadow" id="btn-start-gesture-recording" style="margin-top: 15px"><span class="btn-text"><?php echo $lang->recordGestureNow ?></span></button>
        </div>
    </div>


    <!-- stress test container -->

    <div class="root row" id="physicalStressTest" style="">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right" style="margin-bottom: 80px;">
            <div class="alert-space alert-please-wait"></div>
            <div class="" id="stressTestContainer"></div>
        </div>
    </div>

    <div class="root" id="physicalStressTestModerated">
        <div class="row" id="gestures-list-container"></div>

        <div class="hidden" id="stress-test-questionnaire" style="margin-top: 30px">
            <div id="questionnaire-heading" class="hidden">
                <h3 class="headline" style="margin-top: 0"><?php echo $lang->pleaseAnswerQuestions ?></h3>
            </div>
            <div id="single-questions" class="hidden">

                <div id="single-joint-selection" class="hidden">
                    <div class="panel panel-default panel-shadow" id="human-body-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question text"><?php echo $lang->stressOfBodyTesterQuestion ?></p>
                            <div class="select-joints-humand-body" id="human-body" style="max-width: 350px; width:350px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_body.svg">
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default panel-shadow" id="hand-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question text"><?php echo $lang->stressOfHandTesterQuestion ?></p>
                            <div class="select-joints-humand-hand" id="human-hand" style="max-width: 350px; width:350px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_hand.svg">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="question-container"></div>
            </div>

            <div id="sequence-questions" class="hidden" style="margin-top: 0px">

                <div id="sequence-joint-selection" class="hidden">
                    <div class="panel panel-default panel-shadow" id="human-body-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question text"><?php echo $lang->stressOfBodyTotalTesterQuestion ?></p>
                            <div class="select-joints-humand-body" id="human-body" style="max-width: 350px; width:350px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_body.svg">
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default panel-shadow" id="hand-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question text"><?php echo $lang->stressOfHandTotalTesterQuestion ?></p>
                            <div class="select-joints-humand-hand" id="human-hand" style="max-width: 350px; width:350px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_hand.svg">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="question-container"></div>
            </div>

            <button class="btn btn-block btn-success btn-shadow" id="btn-done-questionnaire" name="btn-success" style="margin-top: 20px"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>

    </div>

    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 root" id="physicalStressTestItem-gesture">
        <div class="previewGesture previewProgress mousePlayable embed-responsive embed-responsive-4by3" style="border-radius: 8px"></div>
        <div class="text-center gestureControls">
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
            </div>
        </div>
    </div>

    <div class="root row" id="physicalStressTestUnmoderated">
        <div class="col-xs-12">
            <div id="general-repeats">
                <h3 class="headline" style="margin-top: 0">Bitte die Geste ausführen</h3>
                <hr>
            </div>
            <div id="questionnaire-heading" class="hidden">
                <h3 class="headline" style="margin: 0" >Bitte die Fragen beantworten</h3>
                <hr>
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-6 col-md-offset-3 text-center" style="margin-bottom: 15px;">
            <div class="previewGesture previewProgress autoplay embed-responsive embed-responsive-4by3"></div>
            <div class="progress gesture-progress">
                <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <div class="gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                    <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                </div>
            </div>
        </div>

        <div class="col-sm-12 hidden" id="stress-test-questionnaire">
            <div id="single-questions" class="hidden">

                <div id="single-joint-selection" class="hidden">
                    <div class="panel panel-default panel-shadow" id="human-body-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question text">Welche Teile des Körpers wurden <u>GERADE EBEN</u> besonders beansprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                            <div class="select-joints-humand-body" id="human-body" style="width: 350px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_body.svg">
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default panel-shadow" id="hand-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question text">Welche Teile der Hand oder Hände wurden <u>GERADE EBEN</u> besonders beansprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                            <div class="select-joints-humand-hand" id="human-hand" style="width: 350px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_hand.svg">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="question-container"></div>
            </div>

            <div id="sequence-questions" class="hidden" style="margin-top: 30px">

                <div id="sequence-joint-selection" class="hidden">
                    <div class="panel panel-default panel-shadow" id="human-body-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question text">Welche Teile des Körpers wurden <u>INSGESAMT</u> besonders beansprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                            <div class="select-joints-humand-body" id="human-body" style="width: 350px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_body.svg">
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default panel-shadow" id="hand-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question text">Welche Teile der Hand oder Hände wurden <u>INSGESAMT</u> besonders beansprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                            <div class="select-joints-humand-hand" id="human-hand" style="width: 350px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_hand.svg">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="question-container"></div>
            </div>

        </div>

        <div class="col-xs-12">
            <button class="btn btn-block btn-success btn-shadow" id="btn-gesture-done" name="btn-success">Geste wurde ausgeführt</button>
            <button class="btn btn-block btn-success btn-shadow hidden" id="btn-questionnaire-done" name="btn-success"><?php echo $lang->next ?></button>
            <button class="btn btn-block btn-success btn-shadow hidden" id="btn-next-gesture" name="btn-success"><span class="btn-text"><?php echo $lang->nextGesture ?></span> <span aria-hidden="true">&rarr;</span></button>
            <button class="btn btn-block btn-success btn-shadow hidden" id="btn-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>

    </div>


    <!-- scenario container -->
    <div class="root row" id="scenario" style="">

        <div class="col-md-4 col-lg-3" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8 col-lg-9" id="column-right" style="margin-bottom: 15px" data-original-col-specs="col-md-8 col-lg-9">
            <div class="alert-space alert-please-wait"></div>
            <div id="scene-container" class="text-center hidden" style="position: absolute; right:15px; left:15px; border-radius: 8px; background-color: #eee" allowtransparency></div>
        </div>

        <!--        <div id="scene-container" class="text-center" style="position: fixed; top:0px; width: 100%;" allowtransparency></div>
                <div id="fixed-rtc-preview" class="rtc-shadow" style="position: fixed; width: 300px; left: 10px; pointer-events: none; opacity: 0.8"></div>
        
                <div class="" style="margin-top: 55px; padding: 20px">
                    <div class="alert-space alert-please-wait"></div>
                </div>-->
    </div>

    <!--    <div id="scenario-panel-moderated">
            
        </div>-->

    <!--    <div id="scenario-panel-unmoderated" style="width: 100%">
            <div class="hidden" id="generalPanel" style="width: 100%"></div>
    
            <div id="info-content" class="hidden" style="width: 100%">
                <div id="task-header"></div>
                <div id="task-text" style="color: #303030; line-height: 1.2em"></div>
                <hr>
            </div>
    
            <div class="hidden" id="normal-controls">
                <div class="pull-left">
                    <button class="btn btn-link" id="btn-show-scenario-info"><i class="fa fa-angle-down text-center"></i> <span id="more-text"></span></button>
                    <button class="btn btn-link pull-left hidden" id="btn-hide-scenario-info"><i class="fa fa-angle-up text-center"></i> <span id="less-text"></span></button>
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-success" id="btn-done"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
                    <button type="button" class="btn btn-info" id="btn-refresh-scene"><i class="fa fa-refresh"></i> <span class="btn-text"><?php echo $lang->reload ?></span></button>
                    <button type="button" class="btn btn-info" id="btn-getting-help"><i class="fa fa-life-ring"></i> <span class="btn-text"><?php echo $lang->help ?></span></button>
                </div>
                <div class="text-center" style="overflow: hidden">
                    <button type="button" class="btn btn-success hidden" id="btn-perform-gesture"><span class="btn-text">Geste ausführen</span></button>
                    <button type="button" class="btn btn-danger hidden" id="btn-stop-perform-gesture"><span class="btn-text">Geste ausgeführt</span></button>
    
                </div>
            </div>
    
            <div class="text-center hidden" id="start-controls">
                <button type="button" class="btn btn-success btn-block" id="start-scene"><span class="btn-text"><?php echo $lang->startNow ?></span></button>
            </div>
        </div>    -->

    <iframe id="web" class="web-frame" src="" frameborder="0" style="width: 100%;" scrolling="yes"></iframe>

    <iframe id="pidoco" class="web-frame" src="" frameborder="0" style="width: 100%;" scrolling="yes"></iframe>

    <img id="image" style="height: 100%; width: 100%; object-fit: contain;">

    <!-- embed-responsive-16by9 or embed-responsive-4by3 -->
    <div id="videoEmbed" style="margin: auto">
        <div class="videoContainer embed-responsive"></div>
    </div>


    <!-- hints and hint contents-->
    <div id="feedback-hint" class="hint">
        <div class="hint-content">
            <button type="button" class="btn btn-info btn-block" id="btn-close-hint" style="margin-top: 20px"><span class="btn-text">Okay</span></button>
            <div class="progress progress-hint" style="height: 73px; border-radius: 10px; margin-top: 20px">
                <div class="progress-bar progress-bar-info progress-bar-hint" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 100%"></div>
            </div>
        </div>
    </div>

    <div id="feedback-hint-text-content">
        <span id="feedback-title"></span>
    </div>

    <div id="feedback-hint-sound-content">
        <div id="feedback-title"></div>
        <i class="fa fa-volume-up" style="font-size: 80pt"></i>
        <audio class="audio-holder" src="" preload="auto"></audio>
    </div>

    <div class="root" id="thanks" style="">
    </div>

    <div id="thanks-moderated" class="row">
        <div class="col-sm-5 col-md-4 rtc-scalable" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-sm-7 col-md-8" id="column-right" style="margin-bottom: 15px;">
            <h3 class="headline" style="margin-top: 0"><?php echo $lang->thanksHeadline ?></h3>
            <!--<hr>-->
            <div class="row">
                <div class="col-sm-12" style="margin-bottom: 20px;">
                    <i class="fa fa-heart" id="heart-icon" style="font-size: 70pt; color: #ca3667"></i>
                    <div class="text" id="thanks-text"></div>
                </div>
                <div class="col-sm-12" id="upload-instructions" style="margin-bottom: 20px;">
                    <i class="fa fa-upload" aria-hidden="true" style="font-size: 70pt; color: #777"></i>
                    <div class="text">
                        <?php echo $lang->thanksWait ?>
                    </div>
                    <div id="rtc-uploads-status" class="hidden text" style="margin-top: 20px">

                        <div id="progress-thanks" class="">
                            <label><?php echo $lang->transferData ?>:</label>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
                                    0%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 hidden" id="upload-retry" style="margin-bottom: 20px;">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size: 70pt; color: #d9534f"></i>
                    <div class="text">
                        <p><?php echo $lang->thanksSaveError ?></p>
                        <button type="button" class="btn btn-danger btn-shadow" id="btn-retry-upload"><i class="fa fa-refresh" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->thanksResave ?></span></button>
                    </div>
                </div>
                <div class="col-sm-6 hidden" style="margin-bottom: 20px;" id="upload-done">
                    <i class="fa fa-check" aria-hidden="true" style="font-size: 70pt; color: #5cb85c"></i>
                    <div class="text">
                        <?php echo $lang->thanksSaveSuccess ?>
                    </div>
                </div>
            </div>

            <div class="hidden" id="study-share">
                <i class="fa fa-share" aria-hidden="true" style="font-size: 70pt; color: #777"></i>
                <p class="text" id="static-study-url"></p>
                <p class="text"><?php echo $lang->thanksShare ?></p>
            </div>

            <button type="button" class="btn btn-success btn-shadow pull-right hidden" id="btn-execution-done"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div class="container" id="thanks-unmoderated">
        <h3 class="headline" style="margin-top: 0"><?php echo $lang->thanksHeadline ?></h3>

        <div class="row">
            <div class="col-sm-6" style="margin-bottom: 20px;">
                <i class="fa fa-heart" id="heart-icon" style="font-size: 70pt; color: #ca3667"></i>
                <div class="text" id="thanks-text"></div>
            </div>
            <div class="col-sm-6" id="upload-instructions" style="margin-bottom: 20px;">
                <i class="fa fa-upload" aria-hidden="true" style="font-size: 70pt; color: #777"></i>
                <div class="text">
                    <?php echo $lang->thanksWait ?>
                </div>
                <div id="rtc-uploads-status" class="hidden text" style="margin-top: 20px">
                    <div id="progress-thanks" class="">
                        <label><?php echo $lang->transferData ?>:</label>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
                                0%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 hidden" id="upload-retry" style="margin-bottom: 20px;">
                <i class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size: 70pt; color: #d9534f"></i>
                <div class="text">
                    <p><?php echo $lang->thanksSaveError ?></p>
                    <button type="button" class="btn btn-danger btn-shadow" id="btn-retry-upload"><i class="fa fa-refresh" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->thanksResave ?></span></button>
                </div>
            </div>
            <div class="col-sm-6 hidden" style="margin-bottom: 20px;" id="upload-done">
                <i class="fa fa-check" aria-hidden="true" style="font-size: 70pt; color: #5cb85c"></i>
                <div class="text">
                    <?php echo $lang->thanksSaveSuccess ?>
                </div>
            </div>
        </div>

        <div class="hidden" id="study-share">
            <hr>
            <i class="fa fa-share" aria-hidden="true" style="font-size: 70pt; color: #777"></i>
            <p class="text" id="static-study-url"></p>
            <p class="text"><?php echo $lang->thanksShare ?></p>
            <hr>
        </div>

        <button type="button" class="btn btn-success btn-shadow pull-right hidden" id="btn-execution-done"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
    </div>

</div>





















<div id="item-container-inputs" class="hidden">

    <div class="panel panel-default panel-shadow root" id="openQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div class="form-group form-group-no-margin">
                <label class="question text"></label> 
                <textarea class="form-control" id="openQuestionInput" rows="5" placeholder=""></textarea>
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="openQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div class="form-group form-group-no-margin">
                <label class="question text"></label> 
                <textarea class="form-control" id="openQuestionInput" rows="5" placeholder=""></textarea>
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="dichotomousQuestion" style="margin-bottom: 5px;">
        <div class="panel-body" id="panel-body">
            <div class="form-group form-group-no-margin">
                <label class="question text"></label> 
                <div class="switch root">
                    <div class="btn-group" style="margin: 0">
                        <button class="btn btn-default btn-radio" name="primary" id="yes">
                            <span id="icons" style="margin-right: 6px">
                                <i class="fa fa-circle-thin" id="normal"></i>
                                <i class="fa fa-circle hidden" id="over"></i>
                                <i class="fa fa-check-circle hidden" id="checked"></i>
                            </span>
                            <span class="option-text"><?php echo $lang->yes ?></span>
                        </button>
                    </div>
                    <div class="btn-group" style="margin: 0">
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
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="dichotomousQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div class="form-group form-group-no-margin" style="margin-bottom: 0px">
                <label class="question text"></label> 
                <div class="switch root">
                    <div class="btn-group" style="margin: 0">
                        <button class="btn btn-default btn-radio" name="primary" id="yes">
                            <span id="icons" style="margin-right: 6px">
                                <i class="fa fa-circle-thin" id="normal"></i>
                                <i class="fa fa-circle hidden" id="over"></i>
                                <i class="fa fa-check-circle hidden" id="checked"></i>
                            </span>
                            <span class="option-text"><?php echo $lang->yes ?></span>
                        </button>
                    </div>
                    <div class="btn-group" style="margin: 0">
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
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="groupingQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <label class="question text"></label>
            <div class="option-container root"></div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="groupingQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <label class="question text"></label>
            <div class="option-container root"></div>
        </div>
    </div>
    <div class="panel panel-default panel-shadow root" id="groupingQuestionOptions" style="margin-bottom: 5px;">
        <div class="panel-body">
            <label class="question text"></label>
            <div class="option-container root"></div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="counter" style="margin-bottom: 5px;">
        <div class="panel-body">
            <label class="question text"></label>
            <div class="input-group simple-stepper" style="max-width: 130px;">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default btn-shadow btn-stepper-decrease" data-min='0'>
                        <span class="fa fa-minus"></span><span class="sr-only"><?php echo $lang->less ?></span>
                    </button>
                </div>
                <input type="text" class="form-control text-center stepper-text" value="0">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default btn-shadow btn-stepper-increase" data-max='10'>
                        <span class="fa fa-plus"></span><span class="sr-only"><?php echo $lang->more ?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="susItem" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <label class="question text"></label>
                <div class="option-container root"></div>
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="gusSingle" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <label class="question text"></label>
                <div class="option-container root"></div>
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="rating" style="margin-bottom: 5px;">
        <div class="panel-body">
            <label class="question text"></label>
            <div class="option-container root"></div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow root" id="matrix" style="margin-bottom: 5px;">
        <div class="panel-body">
            <label class="question text"></label>
            <div class="option-container root"></div>
        </div>
    </div>

    <div id="rating-item">
        <div id="rating-header"></div>
        <div class="root scales-container" id="scales-container"></div>
    </div>

    <div class="panel panel-default panel-shadow root" id="sumQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <label class="question text"></label>
            <div class="option-container root"></div>
        </div>
    </div>

    <div id="sumQuestion-item" style="margin-bottom: 5px; display: inline">
        <div class="input-group simple-stepper" style="max-width: 140px; float: left;  clear: left">
            <div class="input-group-btn">
                <button type="button" class="btn btn-default btn-shadow btn-stepper-decrease" data-min='0'>
                    <span class="fa fa-minus"></span><span class="sr-only"><?php echo $lang->less ?></span>
                </button>
            </div>
            <input type="text" class="form-control text-center stepper-text" value="0">
            <div class="input-group-btn">
                <button type="button" class="btn btn-default btn-shadow btn-stepper-increase" data-max='10'>
                    <span class="fa fa-plus"></span><span class="sr-only"><?php echo $lang->more ?></span>
                </button>
            </div>
        </div>
        <span class="option-text text" style="margin-left: 8px; float: left; margin-top: 4px; margin-bottom: 12px"></span>
    </div>

    <div class="panel panel-default panel-shadow root" id="ranking" style="margin-bottom: 5px;">
        <div class="panel-body">
            <label class="question text"></label>
            <div class="option-container root"></div>
        </div>
    </div>

    <div class="root" id="ranking-item" style="">
        <div class="btn-group" style="margin-top: 5px">
            <button class="btn btn-default btn-shadow btn-up" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->moveUp ?>"><i class="fa fa-arrow-up"></i></button>
            <button class="btn btn-default btn-shadow btn-down" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->moveDown ?>"><i class="fa fa-arrow-down"></i></button>
        </div>
        <span class="option-text text" style="margin-left: 8px; position: relative; top: 7px"></span>
    </div>



    <div class="root" id="ueqItem" style="margin-bottom: 15px; display: table-row">       
        <!--<div class="row">-->
        <!--<div class="col-sm-3 col-md-4 opposite-left text" style="text-align: right; margin-top: 0px"></div>-->
        <div class=" opposite-left text" style="text-align: right; margin-top: 0px; display: table-cell"></div>
        <div class=" text-center" style="display: table-cell; padding: 0px 10px"><div class="option-container root"></div></div>
        <div class=" opposite-right text" style="margin-top: 0px; display: table-cell"></div>
        <!--</div>-->

    </div>

    <div class="panel panel-default panel-shadow root" id="alternativeQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <label class="question text"></label>
            <div class="option-container root"></div>
        </div>
    </div>



    <div class="btn-group" id="checkbox">
        <button class="btn btn-default btn-checkbox list-btn" name="primary">
            <span id="icons" style="margin-right: 6px">
                <i class="fa fa-square-o" id="normal"></i>
                <i class="fa fa-square hidden" id="over"></i>
                <i class="fa fa-check-square hidden" id="checked"></i>
            </span>
            <span class="option-text ellipsis"></span></button>
    </div>

    <div id="checkbox-optionalanswer" style="width: 100%">
        <button class="btn btn-default btn-checkbox" name="primary" style="border-bottom-left-radius: 0px; border-bottom-right-radius: 0px">
            <span id="icons" style="margin-right: 6px">
                <i class="fa fa-square-o" id="normal"></i>
                <i class="fa fa-square hidden" id="over"></i>
                <i class="fa fa-check-square hidden" id="checked"></i>
            </span>
            <span class="option-text"><?php echo $lang->ownAnswers ?></span>
        </button>
        <textarea class="form-control optionalInput" rows="3" style="border-top-left-radius: 0px;"></textarea>
    </div>

    <div class="btn-group" id="radio">
        <button class="btn btn-default btn-radio list-btn" name="primary">
            <span id="icons" style="margin-right: 6px">
                <i class="fa fa-circle-thin" id="normal"></i>
                <i class="fa fa-circle hidden" id="over"></i>
                <i class="fa fa-check-circle hidden" id="checked"></i>
            </span>
            <span class="option-text ellipsis"></span>
        </button>
    </div>

    <div id="radio-optionalanswer" style="width: 100%">
        <button class="btn btn-default btn-radio" name="primary" style="border-bottom-left-radius: 0px; border-bottom-right-radius: 0px">
            <span id="icons" style="margin-right: 6px">
                <i class="fa fa-circle-thin" id="normal"></i>
                <i class="fa fa-circle hidden" id="over"></i>
                <i class="fa fa-check-circle hidden" id="checked"></i>
            </span>
            <span class="option-text"><?php echo $lang->ownAnswers ?></span>
        </button>
        <textarea class="form-control optionalInput" rows="3" style="border-top-left-radius: 0px;"></textarea>
    </div>

    <div id="justification">
        <label for="justificationInput" class="text"><?php echo $lang->justifications ?></label>
        <textarea class="form-control" id="justificationInput" rows="3"></textarea>
    </div>

    <button type="button" class="btn btn-default btn-popover-gesture-preview" id="btn-show-gesture" style="border: none; height: 34px; background-color: #eee"><i class="fa fa-eye"></i> <span class="btn-text"><?php echo $lang->showGesture ?></span></button>

</div>












<div id="item-container-prepare" class="hidden">

    <div id="initialize-recorders-list-item">
        <i class="init-icon fa fa-spin fa-circle-o-notch"></i> <span class="text" style="margin-right: 10px"></span> <span class="btn btn-danger btn-shadow btn-xs btn-ban-sensor"><i class="fa fa-ban"></i> <span class="btn-text"><?php echo $lang->banSensor ?></span></span>
    </div>

</div>