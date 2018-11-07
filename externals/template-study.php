<?php
include '../includes/language.php';
?>

<div id="template-study-container" class="hidden">

    <div id="scenes-catalog-thumbnail">

        <div id="pidoco" class="hidden" style="float: left;">
            <span class="label label-default"><i class="fa fa-link"></i> <span class="label-text"></span></span>
            <span class="text"></span>
        </div>
        <div id="web" class="hidden" style="float: left;">
            <span class="label label-default"><i class="fa fa-link"></i> <span class="label-text"></span></span>
            <span class="text"></span>
        </div>
        <div id="image" class="hidden" style="float: left;">
            <span class="label label-default"><i class="fa fa-image"></i> <span class="label-text"></span></span>
            <span class="text"></span>
        </div>
        <div id="videoEmbed" class="hidden" style="float: left;">
            <span class="label label-default"><i class="fa fa-film"></i> <span class="label-text"></span></span>
            <span class="text"></span>
        </div>
        <div style="float: left; margin-left: 10px;">
            <button type="button" class="btn btn-default btn-xs" id="btn-preview-scene"><i class="fa fa-eye"></i> <span class="btn-text"><?php echo $lang->statePreview ?></span></button>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div id="trigger-catalog-thumbnail" class="text"></div>

    <div id="feedback-catalog-thumbnail">
        <div id="sound" class="hidden">
            <span class="label label-default"><i class="fa fa-volume-up"></i> <?php echo $lang->sound ?></span>
            <span class="text"></span>

            <div class="audioPlayer" style="display: inline; margin-left: 10px">
                <div class="btn-group btn-group-xs">
                    <button class="btn btn-default btn-shadow" id="play"><i class="fa fa-play"></i></button>
                    <button class="btn btn-default btn-shadow" id="pause"><i class="fa fa-pause"></i></button>
                    <button class="btn btn-default btn-shadow" id="stop"><i class="fa fa-stop"></i></button>
                </div>

                <audio class="audio-holder" src="" preload="auto"></audio>
            </div>
        </div>

        <div id="text" class="hidden">
            <span class="label label-default"><i class="fa fa-font"></i> <?php echo $lang->text ?></span>
            <span class="text"></span>
        </div>
    </div>

    <div class="root col-xs-6 col-sm-4 col-md-3" id="participant-thumbnail">
        <div class="panel panel-default btn-shadow btn-panel">
            <div class="panel-body">
                <div class="embed-responsive embed-responsive-4by3" style="border-top-left-radius: 8px; border-top-right-radius: 8px">
                    <div class="embed-responsive-item participant-snapshot" style="position: absolute; background-color: #eee; display: flex; justify-content: center; align-items: center;">
                        <i class="fa fa-user fa-3x"></i>
                    </div>
                    <div class="embed-responsive-item participant-snapshot" style="position: absolute">
                        <img src="" width="100%" height="auto" style="border-top-left-radius: 8px; border-top-right-radius: 8px;" />
                    </div>
                </div>
                <div class="panel-content text-center">
                    <div class="text" id="heading-text"></div>
                    <span class="label label-default hidden" id="execution-phase-pretest" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->execution->participantPretest ?>"><i class="fa fa-user-times"></i> <span class="label-text hidden-xs hidden-sm"><?php echo $lang->pretest ?></span></span>
                    <span class="label label-success hidden" id="execution-success"><i class="fa fa-check"></i> <span class="label-text hidden-xs"></span></span>
                    <span class="label label-warning hidden" id="execution-error"><i class="fa fa-bolt"></i> <span class="label-text hidden-xs"></span></span>
                    <span class="label label-danger hidden"  id="execution-fault"><i class="fa fa-bolt"></i> <span class="label-text hidden-xs"></span></span>
                    <span class="label label-default hidden" id="execution-duration"><i class="fa fa-clock-o"></i> <span class="label-text"></span></span>
                </div>

            </div>

            <!--<div class="panel-body">-->
                <!--<span class="label label-default" id="user"><i class="fa fa-user"></i> <span class="label-text"></span></span>-->

            <!--</div>-->
        </div>
    </div>

    <div class="root" id="no-phase-results">
        <div class="alert alert-warning" role="alert"><i class="fa fa-info-circle"></i> <?php echo $lang->alerts->noDataAvailable->text ?></div>
    </div>

    <div id="elicitation-statistics">
        <div id="headline" class="text-center"><?php echo $lang->whatGesturesWhereElicited ?></div>

        <div class="row">
            <div class="col-md-6">
                <div class="text text-center" style="margin-top: 10px;"><?php echo $lang->gestureType ?></div>
                <canvas class="chart-gesture-execution-type" style="max-width: 300px; margin: 0 auto"></canvas>
                <div class="text text-center" style="font-size: 10pt">
                    <span class="amount-static-gestures"></span>, <span class="amount-dynamic-gestures"></span>, <span class="amount-total-gesture-executions"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text text-center" style="margin-top: 10px;"><?php echo $lang->gestureInteractionType ?></div>
                <canvas class="chart-gesture-interaction-type" style="max-width: 300px; margin: 0 auto"></canvas>
                <div class="text text-center" style="font-size: 10pt">
                    <span class="amount-discrete-gestures"></span>, <span class="amount-continuous-gestures"></span>, <span class="amount-total-gesture-interactions"></span>
                </div>
            </div>
        </div>

        <!--        <div class="progress" style="margin-bottom: 0px">
                    <div class="progress-bar" id="progress-type-static" role="progressbar" style="width:50%">
                        Free Space
                    </div>
                    <div class="progress-bar progress-bar-info" id="progress-type-dynamic" role="progressbar" style="width:40%">
                        Warning
                    </div>
                </div>-->



<!--        <div class="text" style="margin-top: 10px;"><?php echo $lang->gestureInteractionType ?></div>
        <div class="progress" style="margin-bottom: 0px">
            <div class="progress-bar" id="progress-type-discrete" role="progressbar" style="width:50%">
                Free Space
            </div>
            <div class="progress-bar progress-bar-info" id="progress-type-continuous" role="progressbar" style="width:40%">
                Warning
            </div>
        </div>
        <div class="text" style="font-size: 10pt">
            <span id="amount-discrete-gestures"></span>, <span id="amount-continuous-gestures"></span>
        </div>-->

<!--        <div class="text"><?php echo $lang->missingDataForGesture ?></div>
        <div class="progress" id="missing-data">
            <div class="progress-bar" id="progress-complete" role="progressbar" style="width:50%">
                Free Space
            </div>
            <div class="progress-bar progress-bar-warning" id="progress-incomplete" role="progressbar" style="width:40%">
                Warning
            </div>
        </div>-->
    </div>

    <div class="root" id="notes" style="margin-top: 30px;">
        <h3 id="headline"><?php echo $lang->notes ?></h3>
        <hr>
        <textarea class="form-control" id="notes-input" rows="5"></textarea>
    </div>

    <div class="root" id="letterOfAcceptance">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr>
        <span class="label label-success hidden" id="letter-accepted"><i class="fa fa-check"></i> <span class="label-text"><?php echo $lang->letterOfAcceptanceAccepted ?></span></span>
        <span class="label label-danger hidden" id="letter-not-accepted"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->letterOfAcceptanceNotAccepted ?></span></span>
        <p id="letter-text" class="text" style="margin-top: 15px"></p>
    </div>

    <div class="root" id="thanks">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr>
        <p id="thanks-text" class="text"></p>
    </div>

    <div class="root" id="identification">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr id="horizontalLine">
        <div class="alert-space alert-no-record"></div>
        <div class="alert-space alert-webm-unsupported"></div>
        <!--<div id="link-list-container" style="margin-top: 20px"></div>-->

        <h3 style=""><?php echo $lang->gesturesCatalog->elicitedGestures ?></h3>
        <hr>
        <div id="item-view" style="margin-top: 30px;">
            <div class="alert-space alert-no-phase-data"></div>
            <div class="list-container row" id="gestures-list-container"></div>
        </div>
        <div id="observations">
            <h3 id="headline-observations"><?php echo $lang->observations ?></h3>
            <hr>
            <div class="question-container"  id="observations-container"></div>
        </div>
    </div>

    <div class="row" id="trigger-identification">
        <div class="col-xs-6 col-lg-8">
            <div id="trigger-name"><span class="address"></span> <span class="text"></span></div>
            <div id="trigger-justification"><span class="address"></span> <span class="text"></span></div>
        </div>
    </div>


    <span id="filter-option-item" class="filter-options-popover" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""><i class="fa fa-info-circle"></i> Filter</span>



    <div class="root" id="questionnaire">
        <h3 id="headline" style="margin-top: 0"></h3>
        <div class="question-container" style="margin-top: 20px;"></div>
    </div>


    <div class="root" id="interview">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr id="horizontalLine">
        <div class="alert-space alert-no-record"></div>
        <div class="alert-space alert-webm-unsupported"></div>
        <h3 id="headline-observations"><?php echo $lang->questions ?></h3>
        <hr>
        <div class="question-container" style="margin-top: 20px;"></div>
    </div>

    <div class="root" id="sus">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr>
        <div class="range-container" style="margin-top: 20px">
            <div class="alert-space alert-sus-invalid"></div>
            <div id="sus-score-results">
                <div class="text-center">
                    <div style="font-size: 100pt; line-height: 100pt; margin-top: 0" id="average-score"></div>
                    <div id="score-adjective" style="margin-top: 0"><span class="address"></span> <span class="text"></span> <span class="tail"></span></div>
                </div>
                <i class="fa fa-chevron-down text" id="sus-score-pointer" aria-hidden="true" style="position: relative;"></i>
                <div class="progress" id="sus-score-progress" style="margin: 0; margin-top: -4px"></div>

                <div id="sus-marker-container" style="margin-top: 3px; margin-bottom: 100px"></div>
            </div>
        </div>
        <hr>
        <div class="question-container"></div>
    </div>

    <div class="text" id="sus-marker-item" style="position: absolute; display: inline-block">
        <div class="text-center">
            <i class="fa fa-long-arrow-up" style="font-size: 20pt; line-height: 20pt;" aria-hidden="true"></i>
            <div class="text" style="font-size: 9pt; line-height: 9pt;"></div>
            <div class="score" style="font-size: 9pt; line-height: 9pt;"></div>
        </div>
    </div>

    <div class="root" id="gus">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr>
        <span class="label label-default hidden" id="search-gestures"><?php echo $lang->gesturesWhereElicited ?></span> 
        <span class="label label-default hidden" id="search-trigger"><?php echo $lang->triggerWhereElicited ?></span>

        <div class="row">
            <div class="col-sm-6">
                <div id="gesture"><span class="address"></span> <span class="text"></span></div>
                <div id="trigger"><span class="address"></span> <span class="text"></span></div>
                <div id="feedback"><span class="address"></span> <span class="text"></span></div>
            </div>

            <div class="col-sm-6">
                <div class="previewGesture mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
                <div class="text-center gestureControls hidden">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                        <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="question-container" style="margin-top: 30px;"></div>
    </div>


    <div class="root" id="questionnaireGestures">
        <h3 id="headline" style="margin-top: 0"></h3>
        <div class="question-container" style="margin-top: 20px;"></div>
    </div>

    <div class="root" id="ueq">
        <h3 id="headline" style="margin-top: 0"></h3>
        <!--<hr>-->
        <!--        <div class="range-container" style="margin-top: 20px">
                    <div class="alert-space alert-sus-invalid"></div>
                    <div id="sus-score-results">
                        <div class="text-center">
                            <div style="font-size: 100pt; line-height: 100pt; margin-top: 0" id="average-score"></div>
                            <div id="score-adjective" style="margin-top: 0"><span class="address"></span> <span class="text"></span> <span class="tail"></span></div>
                        </div>
                        <i class="fa fa-chevron-down text" id="sus-score-pointer" aria-hidden="true" style="position: relative;"></i>
                        <div class="progress" id="sus-score-progress" style="margin: 0; margin-top: -4px"></div>
        
                        <div id="sus-marker-container" style="margin-top: 3px; margin-bottom: 100px"></div>
                    </div>
                </div>-->
        <div class="row">
            <div class="col-sm-6">
                <label><?php echo $lang->scales ?></label>
                <div class="ueq-scales-statistics">
                    <div class="attractiveness"><span class="address"><?php echo $lang->ueqDimensions->attractiveness->title ?></span> <span role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->ueqDimensions->attractiveness->popover ?>"><i class="fa fa-info-circle"></i></span>: <span class="text"></span> <span class="arrow-green hidden" style="color: #5cb85c"><i class="fa fa-arrow-up"></i></span><span class="arrow-yellow hidden" style="color: #ec971f"><i class="fa fa-arrow-right"></i></span><span class="arrow-red hidden" style="color: #d9534f"><i class="fa fa-arrow-down"></i></span></div>
                    <div class="efficiency"><span class="address"><?php echo $lang->ueqDimensions->efficiency->title ?></span> <span role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->ueqDimensions->efficiency->popover ?>"><i class="fa fa-info-circle"></i></span>: <span class="text"></span> <span class="arrow-green hidden" style="color: #5cb85c"><i class="fa fa-arrow-up"></i></span><span class="arrow-yellow hidden" style="color: #ec971f"><i class="fa fa-arrow-right"></i></span><span class="arrow-red hidden" style="color: #d9534f"><i class="fa fa-arrow-down"></i></span></div>
                    <div class="perspicuity"><span class="address"><?php echo $lang->ueqDimensions->perspicuity->title ?></span> <span role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->ueqDimensions->perspicuity->popover ?>"><i class="fa fa-info-circle"></i></span>: <span class="text"></span> <span class="arrow-green hidden" style="color: #5cb85c"><i class="fa fa-arrow-up"></i></span><span class="arrow-yellow hidden" style="color: #ec971f"><i class="fa fa-arrow-right"></i></span><span class="arrow-red hidden" style="color: #d9534f"><i class="fa fa-arrow-down"></i></span></div>
                    <div class="dependability"><span class="address"><?php echo $lang->ueqDimensions->dependability->title ?></span> <span role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->ueqDimensions->dependability->popover ?>"><i class="fa fa-info-circle"></i></span>: <span class="text"></span> <span class="arrow-green hidden" style="color: #5cb85c"><i class="fa fa-arrow-up"></i></span><span class="arrow-yellow hidden" style="color: #ec971f"><i class="fa fa-arrow-right"></i></span><span class="arrow-red hidden" style="color: #d9534f"><i class="fa fa-arrow-down"></i></span></div>
                    <div class="stimulation"><span class="address"><?php echo $lang->ueqDimensions->stimulation->title ?></span> <span role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->ueqDimensions->stimulation->popover ?>"><i class="fa fa-info-circle"></i></span>: <span class="text"></span> <span class="arrow-green hidden" style="color: #5cb85c"><i class="fa fa-arrow-up"></i></span><span class="arrow-yellow hidden" style="color: #ec971f"><i class="fa fa-arrow-right"></i></span><span class="arrow-red hidden" style="color: #d9534f"><i class="fa fa-arrow-down"></i></span></div>
                    <div class="novelty"><span class="address"><?php echo $lang->ueqDimensions->novelty->title ?></span> <span role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->ueqDimensions->novelty->popover ?>"><i class="fa fa-info-circle"></i></span>: <span class="text"></span> <span class="arrow-green hidden" style="color: #5cb85c"><i class="fa fa-arrow-up"></i></span><span class="arrow-yellow hidden" style="color: #ec971f"><i class="fa fa-arrow-right"></i></span><span class="arrow-red hidden" style="color: #d9534f"><i class="fa fa-arrow-down"></i></span></div>
                </div>
            </div>
            <div class="col-sm-6">
                <label><?php echo $lang->pragmaticHedonicQuality ?></label>
                <div class="ueq-quality-statistics">
                    <div class="attractiveness"><span class="address"><?php echo $lang->ueqMainDimensions->attractiveness ?></span>: <span class="text"></span> <span class="arrow-green hidden" style="color: #5cb85c"><i class="fa fa-arrow-up"></i></span><span class="arrow-yellow hidden" style="color: #ec971f"><i class="fa fa-arrow-right"></i></span><span class="arrow-red hidden" style="color: #d9534f"><i class="fa fa-arrow-down"></i></span></div>
                    <div class="pragmaticQuality"><span class="address"><?php echo $lang->ueqMainDimensions->pragmaticQuality ?></span>: <span class="text"></span> <span class="arrow-green hidden" style="color: #5cb85c"><i class="fa fa-arrow-up"></i></span><span class="arrow-yellow hidden" style="color: #ec971f"><i class="fa fa-arrow-right"></i></span><span class="arrow-red hidden" style="color: #d9534f"><i class="fa fa-arrow-down"></i></span></div>
                    <div class="hedonicQuality"><span class="address"><?php echo $lang->ueqMainDimensions->hedonicQuality ?></span>: <span class="text"></span> <span class="arrow-green hidden" style="color: #5cb85c"><i class="fa fa-arrow-up"></i></span><span class="arrow-yellow hidden" style="color: #ec971f"><i class="fa fa-arrow-right"></i></span><span class="arrow-red hidden" style="color: #d9534f"><i class="fa fa-arrow-down"></i></span></div>
                </div>
            </div>
        </div>
        <hr>
        <div class="question-container"></div>
    </div>


    <div class="panel panel-default panel-shadow" id="counter" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
<!--                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-default" id="counter-label"><span class="counter-from"></span> <span class="counter-to"></span></span>-->
            </div>
            <label class="question"></label>
            <span class="no-matter-filter-option hidden" style="margin-left: 10px" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""><i class="fa fa-info-circle"></i> Filter</span>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div><span class="text answer"></span><span class="filter-option" style="margin-left: 10px"></span></div>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
        </div>
    </div>

    <div class="panel panel-default panel-shadow" id="openQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <!--<span id="filter-option-item" class="filter-options-popover" ></span>-->
                <!--<span class="label label-default" id="format"><span class="format-text"></span></span>-->
            </div>
            <label class="question"></label>
            <span class="no-matter-filter-option hidden" style="margin-left: 10px" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""><i class="fa fa-info-circle"></i> Filter</span>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="answer text"></div>
            <div class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></div>
            <div class="hidden" id="justification-content"><span class="address"><?php echo $lang->justification ?>:</span> <span class="text"></span></div>
            <span class="label label-danger hidden" id="no-justification-result"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noJustification ?></span></span>
        </div>
    </div>

    <div class="panel panel-default panel-shadow" id="openQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <!--<span class="label label-default" id="format"><span class="format-text"></span></span>-->
            </div>
            <label class="question"></label>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <span class="answer text"></span>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
        </div>
    </div>

    <div class="panel panel-default panel-shadow" id="dichotomousQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
<!--                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-default hidden" id="justification"><?php echo $lang->withJustification ?></span>
                <span class="label label-default hidden" id="no-justification"><?php echo $lang->withoutJustification ?></span>
                <span class="label label-default hidden" id="yes"><?php echo $lang->justificationForYes ?></span>
                <span class="label label-default hidden" id="no"><?php echo $lang->justificationForNo ?></span>
                <span class="label label-default hidden" id="always"><?php echo $lang->justificationAlways ?></span>-->
            </div>
            <label class="question"></label>
            <span class="no-matter-filter-option hidden" style="margin-left: 10px" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""><i class="fa fa-info-circle"></i> Filter</span>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <!--            <div class="text">
                            <div class="option-text yes"><?php echo $lang->yes ?></div>
                            <div class="option-text no"><?php echo $lang->no ?></div>
                        </div>-->
                        <!--<div id="selection"><span id="address"><?php echo $lang->selection ?>:</span> <span class="text"></span></div>-->
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
            <div class="hidden" id="justification-content"><span class="address"><?php echo $lang->justification ?>:</span> <span class="text"></span></div>
            <span class="label label-danger hidden" id="no-justification-result"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noJustification ?></span></span>
        </div>
    </div>

    <span id="dichotomous-question-item">
        <div><span class="text option-text" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"></span><span class="filter-option" style="margin-left: 5px"></span></div>
        <!--<div id="option-text" class="text" ></div>-->
    </span>

    <div class="panel panel-default panel-shadow" id="dichotomousQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
<!--                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-default hidden" id="justification"><?php echo $lang->withJustification ?></span>
                <span class="label label-default hidden" id="no-justification"><?php echo $lang->withoutJustification ?></span>
                <span class="label label-default hidden" id="yes"><?php echo $lang->justificationForYes ?></span>
                <span class="label label-default hidden" id="no"><?php echo $lang->justificationForNo ?></span>
                <span class="label label-default hidden" id="always"><?php echo $lang->justificationAlways ?></span>-->
            </div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <!--                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">-->
                <div class="label label-primary" id="factor-primary"></div>
            </div>
            <label class="question"></label>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
            <!--<div id="selection"><span id="address"><?php echo $lang->selection ?>:</span> <span class="text"></span></div>-->
            <div class="hidden" id="justification-content"><span class="address"><?php echo $lang->justification ?>:</span> <span class="text"></span></div>
            <span class="label label-danger hidden" id="no-justification-result"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noJustification ?></span></span>
        </div>
    </div>

    <div class="panel panel-default panel-shadow" id="groupingQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
<!--                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-default hidden" id="multiselect"><?php echo $lang->multipleSelectionsAllowed ?></span>
                <span class="label label-default hidden" id="singleselect"><?php echo $lang->singleSelectionsAllowed ?></span>
                <span class="label label-default hidden" id="optionalanswer"><?php echo $lang->ownAnswerAllowed ?></span>-->
            </div>
            <label class="question"></label>
            <span class="no-matter-filter-option hidden" style="margin-left: 10px" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""><i class="fa fa-info-circle"></i> Filter</span>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <div class="hidden" id="optionalanswer-content" style="margin-top: 15px">
                <hr style="margin-bottom: 5px">
                <div><span class="label label-warning hidden" id="no-optional-answer"><span class="label-text"><?php echo $lang->noOwnAnswers ?></span></span></div>
                <span class="option-text address" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"><?php echo $lang->ownAnswers ?></span> 
                <span class="filter-option" style="margin-left: 5px"></span><br/>
                <span class="text"></span>
            </div>
            <div class="label label-danger" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></div>
        </div>
    </div>

    <span id="grouping-question-item">
        <div>
<!--            <span class="label label-default hidden" id="justification"><?php echo $lang->withJustification ?></span>
            <span class="label label-default hidden" id="no-justification"><?php echo $lang->withoutJustification ?></span>
            <span class="label label-default hidden" id="selectOne"><?php echo $lang->justificationForSelection ?></span>
            <span class="label label-default hidden" id="selectNothing"><?php echo $lang->justificationForNoChoice ?></span>
            <span class="label label-default hidden" id="always"><?php echo $lang->justificationAlways ?></span>-->
        </div>
        <div><span class="text option-text" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"></span><span class="filter-option" style="margin-left: 5px"></span></div>
        <!--<div class="option-text text" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"></div>-->
        <div>
            <div class="hidden" id="justification-content"><span class="address"><?php echo $lang->justification ?>:</span> <span class="text"></span></div>
            <span class="label label-danger hidden" id="no-answer-justification"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noJustification ?></span></span>
        </div>
    </span>

    <div class="panel panel-default panel-shadow" id="groupingQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
<!--                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-default hidden" id="multiselect"><?php echo $lang->multipleSelectionsAllowed ?></span>
                <span class="label label-default hidden" id="singleselect"><?php echo $lang->singleSelectionsAllowed ?></span>
                <span class="label label-default hidden" id="optionalanswer"><?php echo $lang->ownAnswerAllowed ?></span>-->
            </div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <!--                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">-->
                <div class="label label-primary" id="factor-primary"></div>
            </div>
            <label class="question"></label>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <div class="hidden" id="optionalanswer-content" style="margin-top: 15px">
                <hr style="margin-bottom: 5px">
                <div><span class="label label-warning hidden" id="no-optional-answer"><span class="label-text"><?php echo $lang->noOwnAnswers ?></span></span></div>
                <span class="option-text address" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"><?php echo $lang->ownAnswers ?></span> 
                <span class="filter-option" style="margin-left: 5px"></span><br/>
                <span class="text"></span>
            </div>
            <div class="label label-danger" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></div>
        </div>
    </div>

    <div id="grouping-question-gus-triggers-option" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block; margin-bottom: 5px"><span class="text"></span></div>
    <div id="grouping-question-gus-feedbacks-option" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block; margin-bottom: 5px"><span class="text"></span></div>
    <div id="grouping-question-gus-gestures-option" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block; margin-bottom: 5px">
        <span class="text"></span>
        <button type="button" class="btn btn-default btn-shadow btn-popover-gesture-preview" style="margin-left: 5px"><i class="fa fa-eye"></i> <span class="btn-text"><?php echo $lang->showGesture ?></span></button>
    </div>

    <div class="panel panel-default panel-shadow" id="groupingQuestionOptions" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
<!--                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-default hidden" id="multiselect"><?php echo $lang->multipleSelectionsAllowed ?></span>
                <span class="label label-default hidden" id="singleselect"><?php echo $lang->singleSelectionsAllowed ?></span>
                <span class="label label-default hidden" id="optionalanswer"><?php echo $lang->ownAnswerAllowed ?></span>-->
            </div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <!--                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">-->
                <div class="label label-primary" id="factor-primary"></div>
            </div>
            <label class="question"></label>
            <span class="no-matter-filter-option hidden" style="margin-left: 10px" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""><i class="fa fa-info-circle"></i> Filter</span>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <div class="hidden" id="optionalanswer-content" style="margin-top: 15px">
                <hr style="margin-bottom: 5px">
                <div><span class="label label-warning hidden" id="no-optional-answer"><span class="label-text"><?php echo $lang->noOwnAnswers ?></span></span></div>
                <span class="option-text address" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"><?php echo $lang->ownAnswers ?></span> 
                <span class="filter-option" style="margin-left: 5px"></span><br/>
                <span class="text"></span>
            </div>
            <div class="label label-danger" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow" id="rating" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <!--<span class="label label-default" id="format"><span class="format-text"></span></span>-->
                <!--<span class="label label-success hidden" id="positive"><span class="label-text"><?php echo $lang->positive ?></span></span>-->
                <!--<span class="label label-danger hidden" id="negative"><span class="label-text"><?php echo $lang->negative ?></span></span>-->
            </div>
            <label class="question"></label>
            <span class="no-matter-filter-option hidden" style="margin-left: 10px" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""><i class="fa fa-info-circle"></i> Filter</span>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
        </div>
    </div>

    <div id="rating-item">
        <div class="pull-right text" id="score-container"><span class="score-text"></span> <i class="fa" aria-hidden="true"></i></div>
        <div id="scale-container"></div>
    </div>

    <div id="rating-scale-item"><span class="text option-text" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"></span><span class="filter-option" style="margin-left: 5px"></span></div>
    <!--<span id="rating-scale-item" class="text" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"></span>-->

    <div class="panel panel-default panel-shadow" id="matrix" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <!--<span class="label label-default" id="format"><span class="format-text"></span></span>-->
            </div>
            <label class="question"></label>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
        </div>
    </div>

    <div id="matrix-item">
        <span id="rating-option" style="margin-right: 5px"></span>
<!--        <span class="label label-success hidden" id="positive"><span class="label-text"><?php echo $lang->positive ?></span></span>
        <span class="label label-danger hidden" id="negative"><span class="label-text"><?php echo $lang->negative ?></span></span>-->
        <span class="no-matter-filter-option hidden" style="margin-left: 10px" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""><i class="fa fa-info-circle"></i> Filter</span>
        <div class="pull-right text" id="score-container" style="margin-top: 9px"><span class="score-text"></span> <i class="fa" aria-hidden="true"></i></div>
        <div id="scale-container" style="margin-top: 10px;"></div>
        <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
    </div>

    <div class="panel panel-default panel-shadow" id="sumQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
<!--                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-default" id="maximum"><span class="label-text"></span></span>
                <span class="label label-default" id="allocation"><span class="label-text"></span></span>-->
            </div>
            <label class="question"></label>
            <span class="no-matter-filter-option hidden" style="margin-left: 10px" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""><i class="fa fa-info-circle"></i> Filter</span>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
            <div class="label label-success hidden" id="distributeAllPoints"><i class="fa fa-check"></i> <span class="label-text"><?php echo $lang->allPointsDistributed ?></span></div>
            <div class="label label-danger hidden" id="distributeNotAllPoints"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->notAllPointsDistributed ?></span></div>
        </div>
    </div>

    <div id="sum-question-item">
        <span class="text option-text"></span><span class="filter-option" style="margin-left: 10px"></span>
    </div>

    <div class="panel panel-default panel-shadow" id="ranking" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <!--<span class="label label-default" id="format"><span class="format-text"></span></span>-->
            </div>
            <label class="question"></label>
            <span class="no-matter-filter-option hidden" style="margin-left: 10px" role="button" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content=""><i class="fa fa-info-circle"></i> Filter</span>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
        </div>
    </div>

    <div id="ranking-item">
        <span class="text option-text" style="padding: 7px; border-radius: 4px; margin-right: 6px; padding-left: 0px; display: inline-block"></span><span class="filter-option" style="margin-left: 5px"></span>
    </div>

    <div class="panel panel-default panel-shadow" id="alternativeQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
<!--                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-default hidden" id="optionalanswer"><?php echo $lang->ownAnswerAllowed ?></span>
                <span class="label label-default hidden" id="justification"><?php echo $lang->withJustification ?></span>
                <span class="label label-default hidden" id="no-justification"><?php echo $lang->withoutJustification ?></span>
                <span class="label label-default hidden" id="selectOne"><?php echo $lang->justificationForAChoice ?></span>
                <span class="label label-default hidden" id="selectNothing"><?php echo $lang->justificationForNoChoice ?></span>
                <span class="label label-default hidden" id="always"><?php echo $lang->justificationAlways ?></span>
                <span class="label label-default hidden" id="gesturesForGesture"><?php echo $lang->alternativeGesturesForGesture ?></span>
                <span class="label label-default hidden" id="triggersForGesture"><?php echo $lang->alternativeTriggerForGesture ?></span>
                <span class="label label-default hidden" id="triggersForTrigger"><?php echo $lang->alternativeTriggerForTrigger ?></span>
                <span class="label label-default hidden" id="gesturesForTrigger"><?php echo $lang->alternativeGesturesForTrigger ?></span>-->
            </div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <!--                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">-->
                <div class="label label-primary" id="factor-primary"></div>
            </div>
            <label class="question"></label>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
            <div class="hidden" id="optionalanswer-content" style="margin-top: 17px;"><span class="address"><?php echo $lang->ownAnswers ?>:</span> <span class="text"></span></div>
            <span class="label label-warning hidden" id="no-optional-answer"><span class="label-text"><?php echo $lang->noOwnAnswers ?></span></span>
            <div class="hidden" id="justification-content"><span class="address"><?php echo $lang->justification ?>:</span> <span class="text"></span></div>
            <span class="label label-danger hidden" id="no-justification-result"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noJustification ?></span></span>
        </div>
    </div>

    <div id="alternativeQuestion-gesture-item" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block; margin-bottom: 5px">
        <span class="text"></span>
        <button type="button" class="btn btn-default btn-shadow btn-popover-gesture-preview" style="margin-left: 5px"><i class="fa fa-eye"></i> <span class="btn-text"><?php echo $lang->showGesture ?></span></button>
    </div>

    <div id="alternativeQuestion-trigger-item" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"><span class="text"></span></div>

    <div class="panel panel-default panel-shadow" id="gusSingle" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
<!--                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-success hidden" id="positive"><span class="label-text"><?php echo $lang->positive ?></span></span>
                <span class="label label-danger hidden" id="negative"><span class="label-text"><?php echo $lang->negative ?></span></span>-->
            </div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <!--                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">-->
                <div class="label label-primary" id="factor-primary"></div>
            </div>
            <label class="question"></label>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="pull-right text" id="score-container" style="margin-top: 9px"><span class="score-text"></span> <i class="fa" aria-hidden="true"></i></div>
            <div class="option-container"></div>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
        </div>
    </div>

    <span id="gus-single-item-option" class="text" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"></span>

    <div class="panel panel-default panel-shadow" id="susItem" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
<!--                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-success hidden" id="positive"><span class="label-text"><?php echo $lang->positive ?></span></span>
                <span class="label label-danger hidden" id="negative"><span class="label-text"><?php echo $lang->negative ?></span></span>-->
            </div>
            <label class="question"></label>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="pull-right text" id="score-container" style="margin-top: 9px"><span class="score-text"></span> <i class="fa" aria-hidden="true"></i></div>
            <div class="option-container"></div>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
        </div>
    </div>

    <span id="sus-item-option" class="text" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"></span>



    <div class="panel panel-default panel-shadow" id="ueqItem" style="margin-bottom: 5px;">
        <div class="panel-body" style="position: relative">
            <div>
<!--                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-success hidden" id="positive"><span class="label-text"><?php echo $lang->positive ?></span></span>
                <span class="label label-danger hidden" id="negative"><span class="label-text"><?php echo $lang->negative ?></span></span>-->
            </div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <div class="label label-primary" id="factor-primary"></div>
            </div>
            <label class="question"></label> <span class="original-ueq-item-id text-center" style="margin-left: 5px; background-color: #777777; border-radius: 50%; width: 20px; height: 20px; display: inline-block; color: white; font-weight: bold; font-size: 8pt;"></span><br/>
            <div class="text" id="score-container" style="position: absolute; right:15px; bottom:15px"><span class="score-text"></span> <i class="fa" aria-hidden="true"></i></div>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
        </div>
    </div>



    <div id="rtc-video-result">
        <div class="alert-space alert-record-url-invalid"></div>
        <div id="loader" class="hidden text-center">
            <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
            <div class="text">
                <?php echo $lang->videoDataLoading ?>
            </div>
        </div>
        <div id="video-timeline" class="hidden">
            <div id="results-video-container" class="row">
                <div class="col-xs-12 hidden" id="screen-share-video-container" >
                    <video id="screen-share-video-holder" preload="auto" autoplay="false" style="width: 100%; height: auto;  border-top-left-radius: 8px; border-top-right-radius: 8px; position: relative"></video>
                    <div class="progress" style="height: 6px; border-radius: 0; border-bottom-right-radius: 4px; border-bottom-left-radius: 4px; margin: 0; width: 100%; margin-top: -8px">
                        <div class="progress-bar progress-bar-primary" id="seek-bar-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%"></div>
                    </div>
                    <div class="rtc-results-controls-container" style="">
                        <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused" style="border-radius: 50%; background-color: rgba(0,0,0,0.8); color:white; padding: 10px 13px; display: flex; margin: 0 auto; top: 50%; left: 50%; position: absolute; transform: translate(-50%,-48%);"><i class="fa fa-play fa-2x"></i></div>
                    </div>
                    <div class="video-user-type-info" style="position: absolute; top: 0px; border-top-left-radius: 8px; border-bottom-right-radius: 4px; background-color: rgba(0,0,0,0.8); padding-left: 8px; padding-right: 5px; font-size: 8pt; color: white;">
                        <i class="fa fa-tv"></i> <?php echo $lang->screensharing ?>
                    </div>
                    <div class="video-time-code" style="position: absolute; bottom: 6px; left: 15px; border-top-right-radius: 4px; background-color: rgba(0,0,0,0.8); padding-left: 10px; padding-right: 10px; font-size: 8pt; color: white">
                        <span class="video-time-code-current-time">00:00:00</span>
                        <span> / </span>
                        <span class="video-time-code-duration">00:00:00</span>
                    </div>
                    <div style="position: absolute; bottom: 6px; right: 15px; display:inline-flex">
                        <div class="btn-shadow btn-video-adjustment" id="toggle-overlap-videos" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->overlapVideos ?>" style="border-top-left-radius: 4px;">
                            <i class="fa fa-window-restore" style="color: white"></i>
                        </div>
                        <div class="btn-shadow btn-video-adjustment" id="toggle-side-by-side" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->sideBySide ?>" style="">
                            <i class="fa fa-align-justify fa-rotate-90" style="color: white"></i>
                        </div>
                        <div class="btn-shadow btn-video-adjustment selected" id="toggle-big-screen" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->bigScreen ?>" style="">
                            <i class="fa fa-align-justify" style="color: white"></i>
                        </div>
                    </div>
                </div>
                <!--                <div class="row hidden">
                                    <div class="col-xs-12">
                                        
                                    </div>-->


                <div id="webcam-video-container" class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-6 hidden" id="tester-video-container">
                            <video id="tester-video-holder" class="mirroredHorizontally" preload="auto" autoplay="false" style="width: 100%; height: auto; border-top-left-radius: 4px; border-top-right-radius: 4px; position: relative"></video>
                            <div class="progress" style="height: 6px; border-radius: 0; border-bottom-right-radius: 4px; border-bottom-left-radius: 4px; margin: 0; width: 100%; margin-top: -8px">
                                <div class="progress-bar progress-bar-primary" id="seek-bar-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%"></div>
                            </div>
                            <div class="rtc-results-controls-container" style="">
                                <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused" style="border-radius: 50%; background-color: rgba(0,0,0,0.8); color:white; padding: 10px 13px; display: flex; margin: 0 auto; top: 50%; left: 50%; position: absolute; transform: translate(-50%,-48%);"><i class="fa fa-play fa-2x"></i></div>
                            </div>
                            <div class="btn-shadow btn-toggle-mute" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->turnOffAudio ?>" style="position: absolute; top: 0; right:15px; border-top-right-radius: 4px; border-bottom-left-radius: 10px; background-color: rgba(0,0,0,0.8); padding-left: 10px; padding-right: 10px; cursor: pointer">
                                <i class="fa fa-volume-up" style="color: white"></i>
                            </div>
                            <div class="video-user-type-info" style="position: absolute; top: 0px; border-top-left-radius: 4px; border-bottom-right-radius: 4px; background-color: rgba(0,0,0,0.8); padding-left: 7px; padding-right: 5px; font-size: 8pt; color: white;">
                                <i class="fa fa-user"></i> <?php echo $lang->userTypes->tester ?>
                            </div>
                            <div class="video-time-code" style="position: absolute; bottom: 6px; left: 15px; border-top-right-radius: 4px; background-color: rgba(0,0,0,0.8); padding-left: 10px; padding-right: 10px; font-size: 8pt; color: white">
                                <span class="video-time-code-current-time">00:00:00</span>
                                <span> / </span>
                                <span class="video-time-code-duration">00:00:00</span>
                            </div>
                        </div>
                        <div class="col-xs-6 hidden" id="moderator-video-container">
                            <video id="moderator-video-holder" class="mirroredHorizontally" preload="auto" autoplay="false" style="width: 100%; height: auto; border-top-left-radius: 4px; border-top-right-radius: 4px; position: relative"></video>
                            <div class="progress" style="height: 6px; border-radius: 0; border-bottom-right-radius: 4px; border-bottom-left-radius: 4px; margin: 0; width: 100%; margin-top: -8px">
                                <div class="progress-bar progress-bar-primary" id="seek-bar-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%"></div>
                            </div>
                            <div class="rtc-results-controls-container" style="">
                                <div class="hidden-controls-container-btn text-center btn-toggle-playback" data-state="paused" style="border-radius: 50%; background-color: rgba(0,0,0,0.8); color:white; padding: 10px 13px; display: flex; margin: 0 auto; top: 50%; left: 50%; position: absolute; transform: translate(-50%,-48%);"><i class="fa fa-play fa-2x"></i></div>
                            </div>
                            <div class="btn-shadow btn-toggle-mute" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->turnOffAudio ?>" style="position: absolute; top: 0; right:15px; border-top-right-radius: 4px; border-bottom-left-radius: 10px; background-color: rgba(0,0,0,0.8); padding-left: 10px; padding-right: 10px; cursor: pointer">
                                <i class="fa fa-volume-up" style="color: white"></i>
                            </div>
                            <div class="video-user-type-info" style="position: absolute; top: 0px; border-top-left-radius: 4px; border-bottom-right-radius: 4px; background-color: rgba(0,0,0,0.8); padding-left: 7px; padding-right: 5px; font-size: 8pt; color: white;">
                                <i class="fa fa-user"></i> <?php echo $lang->userTypes->evaluator ?>
                            </div>
                            <div class="video-time-code" style="position: absolute; bottom: 6px; left: 15px; border-top-right-radius: 4px; background-color: rgba(0,0,0,0.8); padding-left: 10px; padding-right: 10px; font-size: 8pt; color: white">
                                <span class="video-time-code-current-time">00:00:00</span>
                                <span> / </span>
                                <span class="video-time-code-duration">00:00:00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="video-controls" style="margin-top: 10px">
                <div class="row">
                    <div class="col-xs-3 col-sm-3 col-lg-2" id="gap-input-container">
                        <div class="input-group">
                            <input type="number" class="input-sm form-control text-center" id="gap-input" min="-10" max="10" step="0.01" readonly />
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-sm btn-default btn-shadow" id="btn-lock-unlock-gap-input"  data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->editSyncGap ?>"><i class="fa fa-pencil"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-2 col-lg-2" id="play-pause-container">
                        <div class="btn-group btn-group-justified">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-default btn-shadow" id="btn-step-backward" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->stepBackward ?>"><i class="fa fa-backward"></i></button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-default btn-shadow" id="btn-play-pause" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->play ?>"><i class="fa fa-play"></i></button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-default btn-shadow" id="btn-step-forward" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->stepForward ?>"><i class="fa fa-forward"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-7 col-sm-7 col-lg-8" id="seek-bar-container">
                        <div class="progress" id="main-seek-bar" style="border-radius: 4px; height:30px; margin: 0; cursor: pointer">
                            <div class="progress-bar progress-bar-primary" id="seek-bar-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%"></div>
                        </div>
                        <div id="seek-bar-meta-info-container" class="col-xs-12" style="padding: 0"></div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;" id="timeline-content">
                    <div class="col-xs-12">
                        <button type="button" id="btn-toggle-timeline" class="btn btn-default btn-shadow present" style="display: contents"><i class="fa fa-eye-slash"></i> <span class="text"><?php echo $lang->hideTimeline ?></span></button>
                        <div class="alert-space alert-no-annotations" style="margin-top: 5px"></div>
                        <div id="results-timeline" style="margin-top: 5px"></div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;" id="link-list-content">
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8" style="margin-bottom: 20px">
                        <button type="button" id="btn-toggle-link-list" class="btn btn-default btn-shadow" style="display: contents"><i class="fa fa-eye"></i> <span class="text"><?php echo $lang->showLinklist ?></span></button>
                        <div style="margin-top: 5px">
                            <div class="alert-space alert-no-annotations" style=""></div>
                            <div class="alert-space alert-no-search-results" style=""></div>
                            <div class="hidden" id="link-list-container"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-4" id="add-annotation-container" style="">

                        <div class="bs-example" id="create-annotation-container">
                            <div class="bs-example-headline"><?php echo $lang->annotations ?></div>
                            <div class="bs-example-body">

                                <ul class="nav nav-pills nav-justified" role="tablist" id="annotation-nav-pills">
                                    <li role="presentation" class="active"><a href="#search-annotation-container" aria-controls="search-annotation" role="tab" data-toggle="pill" style="padding: 2px 9px;"><?php echo $lang->searchAnnotation ?></a></li>
                                    <li role="presentation"><a href="#add-annotation-container" aria-controls="add-annotation" role="tab" data-toggle="pill" style="padding: 2px 9px;"><?php echo $lang->addAnnotation ?></a></li>
                                </ul>

                                <div class="tab-content" id="annotation-nav-tab-content" style="margin-top: 10px">
                                    <div role="tabpanel" class="tab-pane active" id="search-annotation-container">
                                        <div class="form-group">
                                            <label><?php echo $lang->annotationSearchLabel ?></label>
                                            <input type="text" class="form-control annotation-search-title-input" maxlength="40" placeholder="" />
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo $lang->annotationColor ?></label>
                                            <div class="search-color-selector text-center">
                                                <div class="btn-color-selector none selected" data-id='none'>
                                                    <!--<i class="fa fa-close" style="position: absolute"></i>-->
                                                    <div style="transform: rotate(45deg); position: relative; top: 8px; left: 1px;">
                                                        <div style="width: 17px; height: 2px; position: absolute; background-color: #d9534f;"></div>
                                                        <div style="width: 17px; height: 2px; position: absolute; background-color: #d9534f; transform: rotate(90deg)"></div>
                                                    </div>
                                                </div>
                                                <div class="btn-color-selector grey" data-id='item-advanced-primary-full'></div>
                                                <div class="btn-color-selector darkblue" data-id='item-primary-full'></div>
                                                <div class="btn-color-selector green" data-id='item-success-full'></div>
                                                <div class="btn-color-selector blue" data-id='item-info-full'></div>
                                                <div class="btn-color-selector yellow" data-id='item-warning-full'></div>
                                                <div class="btn-color-selector red" data-id='item-danger-full'></div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-default btn-block btn-shadow" id="btn-reset-search-annotation-input"><i class="fa fa-refresh"></i> <?php echo $lang->resetSearchAnnotation ?></button>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="add-annotation-container">
                                        <div class="form-group">
                                            <label><?php echo $lang->annotationLabel ?></label>
                                            <input type="text" class="form-control annotation-title-input" maxlength="40" placeholder="<?php echo $lang->addAnnotationLabelInput ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo $lang->annotationColor ?></label>
                                            <div class="color-selector text-center">
                                                <div class="btn-color-selector grey" data-id='item-advanced-primary-full'></div>
                                                <div class="btn-color-selector darkblue selected" data-id='item-primary-full'></div>
                                                <div class="btn-color-selector green" data-id='item-success-full'></div>
                                                <div class="btn-color-selector blue" data-id='item-info-full'></div>
                                                <div class="btn-color-selector yellow" data-id='item-warning-full'></div>
                                                <div class="btn-color-selector red" data-id='item-danger-full'></div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-default btn-block btn-shadow" id="btn-add-annotation-input"><i class="fa fa-plus"></i> <?php echo $lang->addAnnotation ?></button>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <!--<div style="margin-top: 10px">-->
                        <!--                            <div class="bs-example" id="create-annotation-container">
                        
                                                    </div>-->

                        <div class="bs-example hidden" id="update-annotation-container">
                            <div class="bs-example-headline"><?php echo $lang->updateAnnotation ?></div>
                            <div class="bs-example-body">
                                <div class="row">
                                    <div class="col-xs-12 ">
                                        <div class="form-group">
                                            <label><?php echo $lang->annotationLabel ?></label>
                                            <input type="text" class="form-control update-annotation-title-input" maxlength="40" placeholder="<?php echo $lang->addAnnotationLabelInput ?>" />
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label><?php echo $lang->annotationColor ?></label>
                                            <div class="update-color-selector text-center">
                                                <div class="btn-color-selector grey" data-id='item-advanced-primary-full'></div>
                                                <div class="btn-color-selector darkblue" data-id='item-primary-full'></div>
                                                <div class="btn-color-selector green" data-id='item-success-full' data-color="green"></div>
                                                <div class="btn-color-selector blue" data-id='item-info-full' data-color="blue"></div>
                                                <div class="btn-color-selector yellow" data-id='item-warning-full' data-color="yellow"></div>
                                                <div class="btn-color-selector red" data-id='item-danger-full' data-color="red"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="btn-group btn-group-justified">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-danger btn-shadow" id="btn-cancel-update-annotation-input"><i class="fa fa-close"></i> <?php echo $lang->cancel ?></button>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-shadow" id="btn-update-annotation-input"><i class="fa fa-save"></i> <?php echo $lang->accept ?></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!--</div>-->

                    </div>
                </div>
            </div>


        </div>


    </div>

    <div id="link-list-item" class="link-list-item"><span class="link-list-item-url"><span class="link-list-item-time" style="margin-right: 5px"></span> <span class="text link-list-item-title"></span></span> <span class="btn-cancel-edit-annotation hidden" style="margin-right: 5px"><i class="fa fa-close"></i> <?php echo $lang->cancel ?></span> <span class="btn-edit-annotation" style="margin-right: 5px"><i class="fa fa-pencil"></i> <?php echo $lang->edit ?></span> <span class="btn-delete-annotation"><i class="fa fa-trash"></i> <?php echo $lang->delete ?></span></div>

    <div id="shared-list-item" class="shared-list-item"><span class="shared-study-item-email text"></span> <span class="btn-uninvite-user"><i class="fa fa-trash"></i> <?php echo $lang->withdraw ?></span></div>

    <div class="root" id="gestureTraining">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr id="horizontalLine">
        <div class="alert-space alert-no-record"></div>
        <div class="alert-space alert-webm-unsupported"></div>

        <h3 id="headline-gestures"><?php echo $lang->gestures ?></h3>
        <hr>
        <div id="gestures-container"></div>
        <div id="observations">
            <h3 id="headline-observations"><?php echo $lang->observations ?></h3>
            <hr>
            <div class="question-container"  id="observations-container"></div>
        </div>
    </div>

    <div class="row" id="training-gesture-item" style="margin-bottom: 30px">
        <div class="col-sm-5 col-lg-4 root">
            <!--            <div class="previewGesture mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
                        <div class="text-center gestureControls hidden">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                                <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                            </div>
                        </div>-->
            <div class="row gesture-container"></div>
        </div>

        <div class="col-sm-7 col-lg-8">
            <!--<div id="gesture"><span class="address"></span> <span class="text"></span></div>-->
            <div id="trigger"><span class="address"></span> <span class="text"></span></div>
            <div id="feedback"><span class="address"></span> <span class="text" style="display: inline-block"></span></div>
            <!--<div id="recognition-time"><span class="address"></span> <span class="text"></span></div>-->
            <div id="repeats"><span class="address"></span> <span class="text"></span></div>
            <div id="training-time"><span class="address"></span> <span class="text"></span></div>
        </div>
    </div>



    <div class="root" id="gestureSlideshow">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr id="horizontalLine">
        <div class="alert-space alert-no-record"></div>
        <div class="alert-space alert-webm-unsupported"></div>
        <!--<div id="link-list-container" style="margin-top: 20px"></div>-->
        <h3 id="headline-summary"><?php echo $lang->summary ?></h3>
        <hr>
        <div id="summary-container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="text text-center" id="restarts">
                        <div class="text" style="font-size: 120pt; line-height: 110pt"></div>
                        <div class="address" style="font-size: 20pt"><?php echo $lang->restarts ?></div>
                    </div>
                </div>
                <div class="col-sm-6 text-center">
                    <?php echo $lang->gestureSlideshowScoreInfo ?>
                </div>
            </div>

            <div id="gestures-container" style="margin-top: 40px"></div>
        </div>
        <div id="observations">
            <h3 id="headline-observations"><?php echo $lang->observations ?></h3>
            <hr>
            <div class="question-container"  id="observations-container"></div>
        </div>
    </div>

    <div class="row" id="slideshow-gesture-item" style="margin-bottom: 30px">
        <div class="col-sm-5 col-lg-4 root">
            <!--            <div class="previewGesture mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
                        <div class="text-center gestureControls hidden">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                                <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                            </div>
                        </div>-->
            <div class="row gesture-container"></div>
        </div>

        <div class="col-sm-7 col-lg-8">
            <!--<div id="gesture"><span class="address"></span> <span class="text"></span></div>-->
            <div id="trigger"><span class="address"></span> <span class="text"></span></div>
            <div id="feedback"><span class="address"></span> <span class="content"></span></div>
            <div id="recognition-time"><span class="address"></span> <span class="text"></span></div>
            <div id="fits-false" class="hidden"><span class="address"></span> <span class="text" style="color: #d9534f"></span> <i class="fa fa-exclamation-triangle" style="color: #d9534f"></i></div>
            <div id="fits-correct" class="hidden"><span class="address"></span> <span class="text" style="color: #5cb85c"></span> <i class="fa fa-check" style="color: #5cb85c"></i></div>
        </div>
    </div>





    <div class="root" id="triggerSlideshow">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr id="horizontalLine">
        <div class="alert-space alert-webm-unsupported"></div>
        <!--<div id="link-list-container" style="margin-top: 20px"></div>-->
        <div id="summary-container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="text text-center" id="score">
                        <div id="fault-score" class="hidden">
                            <div class="text" style="font-size: 90pt; line-height: 80pt"></div>
                            <div class="address" style="font-size: 20pt"><?php echo $lang->assignedCorrectly ?></div>
                        </div>
                        <div id="no-fault-score" class="hidden">
                            <p><?php echo $lang->noTriggerScoreCalculationPossible ?></p>
                        </div>
                        <!--<div class="address" style="font-size: 20pt"></div>-->
                        <!--<div class="text" style="font-size: 90pt; line-height: 80pt"></div>-->
                    </div>
                </div>
                <div class="col-sm-6 text-center">
                    <?php echo $lang->triggerScoreInfo ?>
                </div>
            </div>

            <div id="gestures-container" style="margin-top: 40px"></div>
        </div>
    </div>

    <div class="row" id="slideshow-trigger-item" style="margin-bottom: 30px">
        <div class="col-sm-5 col-lg-4 root">
            <!--            <div class="previewGesture mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
                        <div class="text-center gestureControls hidden">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                                <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                            </div>
                        </div>-->
            <div class="row gesture-container"></div>
        </div>

        <div class="col-sm-7 col-lg-8">
            <!--<div id="gesture"><span class="address"></span> <span class="text"></span></div>-->
            <div id="trigger"><span class="address"></span> <span class="text"></span></div>
            <div id="feedback"><span class="address"></span> <span class="content"></span></div>
            <div id="selection"><span class="address"></span> 
                <span id="fits-false" class="hidden"><span class="text" style="color: #d9534f"></span> <i class="fa fa-exclamation-triangle" style="color: #d9534f"></i></span>
                <span id="fits-correct" class="hidden"><span class="text" style="color: #5cb85c"></span> <i class="fa fa-check" style="color: #5cb85c"></i></span>
                <span id="no-answer" class="hidden"><span class="text" style="color: #ec971f"></span> <i class="fa fa-bolt" style="color: #ec971f"></i></span>
            </div>

        </div>
    </div>



    <div class="root" id="physicalStressTest">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr id="horizontalLine">
        <div class="alert-space alert-no-record"></div>
        <div class="alert-space alert-webm-unsupported"></div>
        <!--<div id="link-list-container" style="margin-top: 20px"></div>-->
        <h3 id="headline-summary"><?php echo $lang->summary ?></h3>
        <hr>
        <span class="label label-default hidden" id="repeats"><span class="address"></span> <span class="text"></span></span> 
        <span class="label label-default hidden" id="ask-single-questions"><span class="address"></span> <span class="text"></span></span>
        <span class="label label-default hidden" id="ask-sequence-questions"><span class="address"></span> <span class="text"></span></span>
        <div id="gestures-container"></div>
        <div id="observations">
            <h3 id="headline-observations"><?php echo $lang->observations ?></h3>
            <hr>
            <div class="question-container"  id="observations-container"></div>
        </div>
    </div>

    <div class="row" id="physicalStressTest-item" style="margin-bottom: 100px">
        <div class="col-sm-5 col-lg-4 root">
            <!--            <div class="previewGesture mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
                        <div class="text-center gestureControls hidden">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-play-gesture"><i class="fa fa-play"></i></button>
                                <button type="button" class="btn btn-default btn-pause-gesture"><i class="fa fa-stop"></i></button>
                            </div>
                        </div>-->
            <div class="gesture-container row"></div>
        </div>

        <div class="col-sm-7 col-lg-8">
            <!--<div id="gesture"><span class="address"></span> <span class="text"></span></div>-->
            <div id="single-stress-answers">
                <h4 id="headline-single-questions" style="margin-top: 0px"><?php echo $lang->singleAnswers ?></h4>
                <div class="question-container"></div>
            </div>
            <div id="sequence-stress-answers" style="margin-top: 40px">
                <h4 id="headline-sequence-questions" style="margin-top: 0px"><?php echo $lang->multipleAnswers ?></h4>
                <div class="question-container"></div>
            </div>

        </div>
    </div>

    <div id="joint-answers">
        <div id="joint-answers-body" style="margin-bottom: 20px">
            <p class="question text"><?php echo $lang->stressOfBody ?></p>
            <div class="select-joints-humand-body" id="human-body" style="width: 350px; margin: auto">
                <div id="joint-container" style="position: absolute"></div>
                <img src="img/human_body.svg">
            </div>
        </div>

        <div id="joint-answers-hands" style="margin-bottom: 20px">
            <p class="question text"><?php echo $lang->stressOfHands ?></p>
            <div class="select-joints-humand-hand" id="human-hand" style="width: 350px; margin: auto">
                <div id="joint-container" style="position: absolute"></div>
                <img src="img/human_hand.svg">
            </div>
        </div>
    </div>




    <div class="root" id="scenario">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr id="horizontalLine">
        <div class="alert-space alert-no-record"></div>
        <div class="alert-space alert-webm-unsupported"></div>
        <!--<div id="link-list-container" style="margin-top: 20px"></div>-->
        <!--<div class="list-container" style="margin-top: 30px;"></div>-->
        <div id="observations">
            <h3 id="headline-observations"><?php echo $lang->observations ?></h3>
            <hr>
            <div class="question-container"  id="observations-container"></div>
        </div>
    </div>

    <div class="root" id="exploration">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr id="horizontalLine">
        <div class="alert-space alert-no-record"></div>
        <div class="alert-space alert-webm-unsupported"></div>
        <!--<div id="link-list-container" style="margin-top: 20px"></div>-->

        <div class="hidden" id="extraction-item-container">
            <h3 id="headline-extraction-items"></h3>
            <hr>
            <div id="item-view"></div>
        </div>

        <div id="observations">
            <h3 id="headline-observations"><?php echo $lang->observations ?></h3>
            <hr>
            <div class="question-container" id="observations-container"></div>
        </div>
    </div>

    <div id="exploration-answer-item-for-trigger">
        <div class="list-container row" id="gestures-list-container">
            <div class="col-xs-12 col-sm-6 col-md-8 col-lg-9 question-container"></div>
        </div>
    </div>

    <div id="exploration-answer-item-for-gesture">
        <div class="question-container"></div>
    </div>


    <div id="guessability-table">
        <div style="margin-top: -5px"><?php echo $lang->potentialGesturesOverviewTable ?></div>
        <table class="table table-bordered table-sm text">
            <thead>
                <tr class="table-head-row">
                    <th scope="col" class="basic"><?php echo $lang->trigger ?></th>
                    <th scope="col" class="effect"><?php echo $lang->gesture ?></th>
                    <!--<th scope="col"><?php echo $lang->estimability ?></th>-->
                    <th scope="col"><?php echo $lang->approval ?></th>
                </tr>
            </thead>
            <tbody class="table-body"></tbody>
        </table>
    </div>

    <div id="mean-accordance-gestures" class="text-center" style="margin-bottom: 40px">
        <div><?php echo $lang->gestureSetAgreement ?></div>
        <div id="accordance-amount" style="font-size: 100pt; line-height: 100pt; margin-top: -10px; color: #000"></div>
        <div>
            <span class="hidden success veryHighAgreement"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->veryHighAgreement ?></span></span>
            <span class="hidden success highAgreement"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->highAgreement ?></span></span>
            <span class="hidden warning mediumAgreement"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->mediumAgreement ?></span></span>
            <span class="hidden danger lowAgreement"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->lowAgreement ?></span></span>
        </div>
    </div>

    <div id="mean-accordance-trigger" class="text-center" style="margin-bottom: 40px">
        <div><?php echo $lang->triggerSetAgreement ?></div>
        <div id="accordance-amount" style="font-size: 100pt; line-height: 100pt; margin-top: -10px; color: #000"></div>
        <div>
            <span class="hidden success veryHighAgreement"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->veryHighAgreement ?></span></span>
            <span class="hidden success highAgreement"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->highAgreement ?></span></span>
            <span class="hidden warning mediumAgreement"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->mediumAgreement ?></span></span>
            <span class="hidden danger lowAgreement"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->lowAgreement ?></span></span>
        </div>
    </div>

    <div id="potential-gesture-statistics" style="margin-bottom: 40px">
        <div class="text-center"><?php echo $lang->whatGesturesWhereElicitedForClassification ?></div>
        <div class="row">
            <div class="col-md-6">
                <div class="text text-center" style="margin-top: 10px;"><?php echo $lang->gestureType ?></div>
                <canvas class="chart-gesture-execution-type" style="max-width: 300px; margin: 0 auto"></canvas>
                <div class="text text-center" style="font-size: 10pt">
                    <span class="amount-static-gestures"></span>, <span class="amount-dynamic-gestures"></span>, <span class="amount-total-gesture-executions"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text text-center" style="margin-top: 10px;"><?php echo $lang->gestureInteractionType ?></div>
                <canvas class="chart-gesture-interaction-type" style="max-width: 300px; margin: 0 auto"></canvas>
                <div class="text text-center" style="font-size: 10pt">
                    <span class="amount-discrete-gestures"></span>, <span class="amount-continuous-gestures"></span>, <span class="amount-total-gesture-interactions"></span>
                </div>
            </div>
        </div>
    </div>



    <div class="panel panel-default panel-shadow" id="amount-container-appearance-trigger">
        <div class="panel-heading">
            <div id="headline" style="margin: 0"><span class="text" style="margin-right: 5px"></span> <span class="badge"></span></div> 
        </div>

        <!--<hr>-->
        <div class="panel-body">
            <div class="text-center"><?php echo $lang->whatGesturesWhereElicitedForClassificationTrigger ?></div>
            <div class="row specific-gesture-statistics">
                <div class="col-md-6">
                    <div class="text text-center" style="margin-top: 10px;"><?php echo $lang->gestureType ?></div>
                    <canvas class="chart-gesture-execution-type" style="max-width: 300px; margin: 0 auto"></canvas>
                    <div class="text text-center" style="font-size: 10pt">
                        <span class="amount-static-gestures"></span>, <span class="amount-dynamic-gestures"></span>, <span class="amount-total-gesture-executions"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text text-center" style="margin-top: 10px;"><?php echo $lang->gestureInteractionType ?></div>
                    <canvas class="chart-gesture-interaction-type" style="max-width: 300px; margin: 0 auto"></canvas>
                    <div class="text text-center" style="font-size: 10pt">
                        <span class="amount-discrete-gestures"></span>, <span class="amount-continuous-gestures"></span>, <span class="amount-total-gesture-interactions"></span>
                    </div>
                </div>
            </div>
            <hr>
            <div id="item-view"></div>
        </div>

    </div>

    <div id="appearance-trigger-gesture" class="root" style="margin-bottom: 30px">
        <div id="headline-trigger-gesture"></div>

        <div class="row" style="margin-top: 10px">
            <div id="gestures-list-container"></div>
        </div>
    </div>

    <div id="appearance-trigger-gesture-potential" class="root">
        <div id="headline-trigger-gesture"></div>

        <div class="row" id="potential-parameters-container" style="margin-top: 10px">
            <div class="col-xs-12 col-md-7" id="potential-parameters"></div>
        </div>

        <div id="more-classified-gestures" class="hidden" style="margin-top: 10px">
            <p><?php echo $lang->otherAssociatedGestures ?></p>
            <div class="row" style="margin-top: 10px">
                <div id="gestures-list-container"></div>
            </div>
        </div>
    </div>

    <div id="potential-gesture-parameters-appearance-trigger">
        <div id="parameters-amount">
            <div><h4 style="margin: 0"><i class="fa fa-pie-chart" aria-hidden="true"></i> <?php echo $lang->number ?></h4></div>
            <div class="amount-specific"><span class="text"></span> <span class="address"></span></div>
            <div class="trigger"><span class="address"></span> <span class="text"></span></div>
            <div style="font-size: 9pt; margin-top: 4px">
                <span class="text"><em><?php echo $lang->classesForTrigger ?></em></span>
                <div class="amount-minimal-function"><span class="address"></span> <span class="text"></span></div>
                <div class="amount-maximal-function"><span class="address"></span> <span class="text"></span></div>
            </div>

            <span class="hidden success" id="well"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->suitable ?></span></span>
            <span class="hidden warning" id="even"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span><?php echo $lang->notEnoughData ?></span></span>
            <span class="hidden danger" id="less-well"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->notSuitable ?></span></span>
        </div>
        <!--        <div id="parameters-agreement-measures" style="margin-top: 20px">
                    <div><h4 style="margin: 0"><i class="fa fa-percent" aria-hidden="true"></i> <?php echo $lang->measureOfGuess ?></h4></div>
                    <div id="agreement"><span id="label"><span class="text"></span></div>
                </div>-->
        <!--        <div id="parameters-guessability" class="hidden" style="margin-top: 20px">
                    <div><h4 style="margin: 0"><i class="fa fa-users" aria-hidden="true"></i> <?php echo $lang->measureOfApproval ?></h4></div>
                    <span id="accordance" style="margin-right: 4px"><span class="text"></span></span>
                    <span class="hidden success veryHighAgreement"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->veryHighAgreement ?></span></span>
                    <span class="hidden success highAgreement"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->highAgreement ?></span></span>
                    <span class="hidden warning mediumAgreement"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->mediumAgreement ?></span></span>
                    <span class="hidden danger lowAgreement"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->lowAgreement ?></span></span>
                </div>-->
        <div id="parameters-cognitive-relationships" style="margin-top: 20px">
            <div>
                <h4 style="margin: 0; float: left; "><i class="fa fa-puzzle-piece" aria-hidden="true"></i> <?php echo $lang->cognitiveRelations ?></h4>
                <button type="button" class="btn btn-xs btn-default btn-shadow" id="btn-open-cognitive-relationships"style="float: left; margin-left: 10px"><i class="fa fa-check-square-o"></i> <?php echo $lang->check ?></button>
            </div>
            <div style="margin-top: 8px; clear: both">
                <div>
                    <span class="hidden success" id="well"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->suitable ?></span></span>
                    <span class="hidden warning" id="even"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->dontKnow ?></span></span>
                    <span class="hidden danger" id="less-well"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->notSuitable ?></span></span>
                    <span class="hidden warning" id="not-checked"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span><?php echo $lang->notChecked ?></span></span>
                </div>
            </div>
        </div>
        <div id="parameters-checklist" class="hidden" style="margin-top: 20px">
            <div>
                <h4 style="margin: 0; float: left"><i class="fa fa-check-circle-o" aria-hidden="true"></i> <?php echo $lang->checklist ?></h4>
                <button type="button" class="btn btn-xs btn-default btn-shadow" id="btn-open-checklist" style="float: left; margin-left: 10px"><i class="fa fa-check-square-o"></i> <?php echo $lang->check ?></button>
            </div>

            <div style="margin-top: 8px; clear: both">
                <div>
                    <span class="hidden success" id="well"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->suitable ?></span></span>
                    <span class="hidden warning" id="even"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->dontKnow ?></span></span>
                    <span class="hidden danger" id="less-well"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->notSuitable ?></span></span>
                    <span class="hidden warning" id="not-checked"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span><?php echo $lang->notChecked ?></span></span>
                </div>
            </div>
        </div>
        <div id="parameters-gesture-sets" style="margin-top: 20px">
            <div><h4 style="margin: 0"><i class="fa fa-paperclip" aria-hidden="true"></i> <?php echo $lang->assignmentToGestureSets ?></h4></div>
            <span class="hidden warning" id="not-assigned"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span><?php echo $lang->notAssignedToGestureSet ?></span></span>
            <ul id="attached-gesture-sets-container" style="list-style-position: inside; padding-left: 0px; margin-top: 5px"></ul>
        </div>

    </div>

    <div id="potential-gesture-parameters-appearance-trigger-amount-item" style="margin-top: ">
        <span id="trigger-title-label"><?php echo $lang->trigger ?></span>: <span class="text" id="trigger-title"></span><br/>
        <span class="text" id="justification"></span>
        <br/>
        <span class="hidden success" id="well"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->suitable ?></span></span>
        <span class="hidden warning" id="even"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span><?php echo $lang->notEnoughData ?></span></span>
        <span class="hidden danger" id="less-well"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->notSuitable ?></span></span>
    </div>

    <div id="potential-gesture-parameters-appearance">
        <div id="parameters-amount">
            <div><h4 style="margin: 0"><i class="fa fa-pie-chart" aria-hidden="true"></i> Anzahl</h4></div>
            <div id="trigger-container"></div>

        </div>
        <div id="parameters-cognitive-relationships" style="margin-top: 20px">
            <div>
                <h4 style="margin: 0; float: left; "><i class="fa fa-flash" aria-hidden="true"></i> <?php echo $lang->cognitiveRelations ?></h4>
                <button type="button" class="btn btn-xs btn-default btn-shadow" id="btn-open-cognitive-relationships"style="float: left; margin-left: 10px"><i class="fa fa-check-square-o"></i> <?php echo $lang->check ?></button>
            </div>
            <div style="margin-top: 8px; clear: both">
                <div>
                    <span class="hidden success" id="well"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->suitable ?></span></span>
                    <span class="hidden warning" id="even"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->dontKnow ?></span></span>
                    <span class="hidden danger" id="less-well"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->notSuitable ?></span></span>
                    <span class="hidden warning" id="not-checked"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span><?php echo $lang->notChecked ?></span></span>
                </div>
            </div>
        </div>
        <div id="parameters-checklist" class="hidden" style="margin-top: 20px">
            <div>
                <h4 style="margin: 0; float: left"><i class="fa fa-check-circle-o" aria-hidden="true"></i> <?php echo $lang->checklist ?></h4>
                <button type="button" class="btn btn-xs btn-default btn-shadow" id="btn-open-checklist" style="float: left; margin-left: 10px"><i class="fa fa-check-square-o"></i> <?php echo $lang->check ?></button>
            </div>

            <div style="margin-top: 8px; clear: both">
                <div>
                    <span class="hidden success" id="well"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->suitable ?></span></span>
                    <span class="hidden warning" id="even"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->dontKnow ?></span></span>
                    <span class="hidden danger" id="less-well"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->notSuitable ?></span></span>
                    <span class="hidden warning" id="not-checked"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span><?php echo $lang->notChecked ?></span></span>
                </div>
            </div>
        </div>
        <div id="parameters-gesture-sets" style="margin-top: 20px">
            <div><h4 style="margin: 0"><i class="fa fa-paperclip" aria-hidden="true"></i> <?php echo $lang->assignmentToGestureSets ?></h4></div>
            <span class="hidden warning" id="not-assigned"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span><?php echo $lang->notAssignedToGestureSet ?></span></span>
            <ul id="attached-gesture-sets-container" style="list-style-position: inside; padding-left: 0px; margin-top: 5px"></ul>
        </div>

    </div>







    <div class="panel panel-default panel-shadow" id="amount-container-appearance-gesture" style="">
        <div class="panel-heading">
            <div id="headline" style="margin: 0"><span class="text" style="margin-right: 5px"></span> <span class="badge"></span></div> 
        </div>
        <div class="panel-body">
            <div id="item-view"></div>
        </div>

    </div>

    <div id="appearance-gesture-trigger" class="root" style="margin-bottom: 30px">
        <div id="headline-gesture-trigger"></div>

        <div class="row" style="margin-top: 10px">
            <div id="trigger-list-container"></div>
        </div>
    </div>

    <div id="appearance-gesture-trigger-potential" class="root" style="margin-bottom: 30px">
        <div id="headline-gesture-trigger"></div>

        <div class="row" id="potential-parameters-container" style="margin-top: 10px">
            <div class="col-xs-12 col-sm-6" id="potential-parameters"></div>
        </div>

        <!--        <div id="more-classified-trigger" class="hidden" style="margin-top: 20px">
                    <p><?php echo $lang->otherAssociatedGestures ?></p>
                    <div class="row" style="margin-top: 10px">
                        <div id="gestures-list-container"></div>
                    </div>
                </div>-->
    </div>

    <div id="potential-trigger-parameters-appearance-gesture">
        <div id="parameters-amount">
            <div><h4 style="margin: 0"><i class="fa fa-pie-chart" aria-hidden="true"></i> <?php echo $lang->number ?></h4></div>
            <span class="text" id="justification"></span>
            <br/>
            <span class="hidden success" id="well"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->suitable ?></span></span>
            <span class="hidden warning" id="even"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span><?php echo $lang->notEnoughData ?></span></span>
            <span class="hidden danger" id="less-well"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->notSuitable ?></span></span>
        </div>
        <!--        <div id="parameters-agreement-measures" style="margin-top: 20px">
                    <div><h4 style="margin: 0"><i class="fa fa-percent" aria-hidden="true"></i> <?php echo $lang->measureOfGuess ?></h4></div>
                    <div id="agreement"><span id="label"><span class="text"></span></div>
                </div>-->
        <!--        <div id="parameters-guessability" class="hidden" style="margin-top: 20px">
                    <div><h4 style="margin: 0"><i class="fa fa-users" aria-hidden="true"></i> <?php echo $lang->measureOfApproval ?></h4></div>
                    <span id="accordance" style="margin-right: 4px"><span class="text"></span></span>
                    <span class="hidden success veryHighAgreement"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->veryHighAgreement ?></span></span>
                    <span class="hidden success highAgreement"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->highAgreement ?></span></span>
                    <span class="hidden warning mediumAgreement"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->mediumAgreement ?></span></span>
                    <span class="hidden danger lowAgreement"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->lowAgreement ?></span></span>
                </div>-->
        <div id="parameters-cognitive-relationships" style="margin-top: 20px">
            <div>
                <h4 style="margin: 0; float: left; "><i class="fa fa-puzzle-piece" aria-hidden="true"></i> <?php echo $lang->cognitiveRelations ?></h4>
                <button type="button" class="btn btn-xs btn-default btn-shadow" id="btn-open-cognitive-relationships"style="float: left; margin-left: 10px"><i class="fa fa-check-square-o"></i> <?php echo $lang->check ?></button>
            </div>
            <div style="margin-top: 8px; clear: both">
                <div>
                    <span class="hidden success" id="well"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->suitable ?></span></span>
                    <span class="hidden warning" id="even"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->dontKnow ?></span></span>
                    <span class="hidden danger" id="less-well"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->notSuitable ?></span></span>
                    <span class="hidden warning" id="not-checked"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span><?php echo $lang->notChecked ?></span></span>
                </div>
            </div>
        </div>
        <div id="parameters-checklist" class="hidden" style="margin-top: 20px">
            <div>
                <h4 style="margin: 0; float: left"><i class="fa fa-check-circle-o" aria-hidden="true"></i> <?php echo $lang->checklist ?></h4>
                <button type="button" class="btn btn-xs btn-default btn-shadow" id="btn-open-checklist" style="float: left; margin-left: 10px"><i class="fa fa-check-square-o"></i> <?php echo $lang->check ?></button>
            </div>

            <div style="margin-top: 8px; clear: both">
                <div>
                    <span class="hidden success" id="well"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->suitable ?></span></span>
                    <span class="hidden warning" id="even"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->dontKnow ?></span></span>
                    <span class="hidden danger" id="less-well"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->notSuitable ?></span></span>
                    <span class="hidden warning" id="not-checked"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span><?php echo $lang->notChecked ?></span></span>
                </div>
            </div>
        </div>

    </div>

    <div id="potential-trigger-parameters-appearance-gesture-amount-item" style="margin-top: ">
        <span id="gesture-title-label"><?php echo $lang->trigger ?></span>: <span class="text" id="gesture-title"></span><br/>
        <span class="text" id="justification"></span>
        <br/>
        <span class="hidden success" id="well"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->suitable ?></span></span>
        <span class="hidden warning" id="even"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span><?php echo $lang->notEnoughData ?></span></span>
        <span class="hidden danger" id="less-well"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->notSuitable ?></span></span>
    </div>

    <div id="potential-trigger-parameters-appearance">
        <div id="parameters-amount">
            <div><h4 style="margin: 0"><i class="fa fa-pie-chart" aria-hidden="true"></i> Anzahl</h4></div>
            <div id="trigger-container"></div>

        </div>
        <div id="parameters-cognitive-relationships" style="margin-top: 20px">
            <div>
                <h4 style="margin: 0; float: left; "><i class="fa fa-flash" aria-hidden="true"></i> <?php echo $lang->cognitiveRelations ?></h4>
                <button type="button" class="btn btn-xs btn-default btn-shadow" id="btn-open-cognitive-relationships"style="float: left; margin-left: 10px"><i class="fa fa-check-square-o"></i> <?php echo $lang->check ?></button>
            </div>
            <div style="margin-top: 8px; clear: both">
                <div>
                    <span class="hidden success" id="well"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->suitable ?></span></span>
                    <span class="hidden warning" id="even"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->dontKnow ?></span></span>
                    <span class="hidden danger" id="less-well"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->notSuitable ?></span></span>
                    <span class="hidden warning" id="not-checked"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span><?php echo $lang->notChecked ?></span></span>
                </div>
            </div>
        </div>
        <div id="parameters-checklist" class="hidden" style="margin-top: 20px">
            <div>
                <h4 style="margin: 0; float: left"><i class="fa fa-check-circle-o" aria-hidden="true"></i> <?php echo $lang->checklist ?></h4>
                <button type="button" class="btn btn-xs btn-default btn-shadow" id="btn-open-checklist" style="float: left; margin-left: 10px"><i class="fa fa-check-square-o"></i> <?php echo $lang->check ?></button>
            </div>

            <div style="margin-top: 8px; clear: both">
                <div>
                    <span class="hidden success" id="well"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->suitable ?></span></span>
                    <span class="hidden warning" id="even"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->dontKnow ?></span></span>
                    <span class="hidden danger" id="less-well"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->notSuitable ?></span></span>
                    <span class="hidden warning" id="not-checked"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span><?php echo $lang->notChecked ?></span></span>
                </div>
            </div>
        </div>

    </div>


</div>











<div id="template-study-editable-container" class="hidden">

    <div class="panel panel-default panel-shadow" id="counter" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <span class="label label-default" id="counter-label"><span class="counter-from"></span> <span class="counter-to"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="input-group simple-stepper" style="max-width: 130px;">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default btn-shadow btn-stepper-decrease" value="0">
                        <span class="fa fa-minus"></span><span class="sr-only"><?php echo $lang->less ?></span>
                    </button>
                </div>
                <input type="text" class="form-control readonly text-center stepper-text" value="0">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default btn-shadow btn-stepper-increase" value="10">
                        <span class="fa fa-plus"></span><span class="sr-only"><?php echo $lang->more ?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow" id="openQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <textarea class="form-control" id="openQuestionInput" rows="5" placeholder=""></textarea>
        </div>
    </div>

    <div class="panel panel-default panel-shadow" id="dichotomousQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <span class="label label-default hidden" id="label-justification"><?php echo $lang->withJustification ?></span>
            <span class="label label-default hidden" id="label-no-justification"><?php echo $lang->withoutJustification ?></span>
            <span class="label label-default hidden" id="label-yes"><?php echo $lang->justificationForYes ?></span>
            <span class="label label-default hidden" id="label-no"><?php echo $lang->justificationForNo ?></span>
            <span class="label label-default hidden" id="label-always"><?php echo $lang->justificationAlways ?></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body" id="panel-body">
            <div class="btn-group switch">
                <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="no" name="btn-success"><?php echo $lang->no ?></button>
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow" id="groupingQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <span class="label label-default hidden" id="multiselect"><?php echo $lang->multipleSelectionsAllowed ?></span>
            <span class="label label-default hidden" id="singleselect"><?php echo $lang->singleSelectionsAllowed ?></span>
            <span class="label label-default hidden" id="optionalanswer"><?php echo $lang->ownAnswerAllowed ?></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container root"></div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow" id="rating" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow" id="sumQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <span class="label label-default" id="maximum"><span class="label-text"></span></span>
            <span class="label label-default" id="allocation"><span class="label-text"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default panel-shadow" id="ranking" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
        </div>
    </div>

</div>


<div id="item-container-moderator" class="hidden">
    <div id="helpItem" style="margin-bottom: 6px;">
        <div class="help-title"></div>
        <div class="btn-group" style="margin-top: 10px;">
            <button type="button" class="btn btn-info btn-shadow disabled" id="offer-help"><i class="fa fa-life-ring"></i> <?php echo $lang->offerHelp ?></button>
            <button type="button" class="btn btn-default btn-shadow btn-popover-gesture-preview hidden"><i class="fa fa-eye"></i> <span class="btn-text"><?php echo $lang->showGesture ?></span></button>
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
        <img class="imageAreaContent" src="" alt="..." style="width: 100%; height: auto; border-radius: 4px;" />
    </div>

    <div id="videoEmbed">
        <span><?php echo $lang->title ?>: </span><span class="title"></span><br/>
        <span><?php echo $lang->type ?>: </span><div class="label label-default type"><i class="fa fa-film"></i> <span class="label-text"></span></div><br/><br/>
        <div class="videoContainer embed-responsive"></div>
    </div>
</div>