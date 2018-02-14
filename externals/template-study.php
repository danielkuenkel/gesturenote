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
                    <button class="btn btn-default btn-shadow" id="play"><i class="glyphicon glyphicon-play"></i></button>
                    <button class="btn btn-default btn-shadow" id="pause"><i class="glyphicon glyphicon-pause"></i></button>
                    <button class="btn btn-default btn-shadow" id="stop"><i class="glyphicon glyphicon-stop"></i></button>
                </div>

                <audio class="audio-holder" src="" preload="auto"></audio>
            </div>
        </div>

        <div id="text" class="hidden">
            <span class="label label-default"><i class="fa fa-font"></i> <?php echo $lang->text ?></span>
            <span class="text"></span>
        </div>
    </div>

    <div class="root col-xs-6 col-sm-4 col-lg-3" id="participant-thumbnail">
        <div class="panel panel-default btn-shadow">
            <div class="panel-heading"></div>

            <div class="panel-body">
                <span class="label label-default" id="user"><i class="fa fa-user"></i> <span class="label-text"></span></span>
                <span class="label label-success hidden" id="execution-success"><i class="fa fa-check"></i> <span class="label-text hidden-xs hidden-sm"></span></span>
                <span class="label label-warning hidden" id="execution-error"><i class="fa fa-bolt"></i> <span class="label-text hidden-xs hidden-sm"></span></span>
                <span class="label label-danger hidden" id="execution-fault"><i class="fa fa-bolt"></i> <span class="label-text hidden-xs hidden-sm"></span></span>
            </div>
        </div>
    </div>

    <div class="root" id="no-phase-results">
        <div class="alert alert-warning" role="alert"><i class="glyphicon glyphicon-info-sign"></i> <?php echo $lang->alerts->noDataAvailable->text ?></div>
    </div>

    <div id="elicitation-statistics">
        <div id="headline"><?php echo $lang->whatGesturesWhereElicited ?></div>

        <div class="text" style="margin-top: 10px;"><?php echo $lang->gestureType ?></div>
        <div class="progress" style="margin-bottom: 0px">
            <div class="progress-bar" id="progress-type-static" role="progressbar" style="width:50%">
                Free Space
            </div>
            <div class="progress-bar progress-bar-info" id="progress-type-dynamic" role="progressbar" style="width:40%">
                Warning
            </div>
        </div>
        <div class="text" style="font-size: 10pt">
            <span id="amount-static-gestures"></span>, <span id="amount-dynamic-gestures"></span>
        </div>

        <div class="text" style="margin-top: 10px;"><?php echo $lang->gestureInteractionType ?></div>
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
        </div>

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
        <div id="link-list-container" style="margin-top: 20px"></div>

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
                <div class="previewGesture autoplay mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
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


    <div class="panel panel-default" id="counter" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-default" id="counter-label"><span class="counter-from"></span> <span class="counter-to"></span></span>
            </div>
            <label class="question"></label>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <span class="answer text"></span>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
        </div>
    </div>

    <div class="panel panel-default" id="openQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <span class="label label-default" id="format"><span class="format-text"></span></span>
            </div>
            <label class="question"></label>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="answer text"></div>
            <div class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></div>
            <div class="hidden" id="justification-content"><span class="address"><?php echo $lang->justification ?>:</span> <span class="text"></span></div>
            <span class="label label-danger hidden" id="no-justification-result"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noJustification ?></span></span>
        </div>
    </div>

    <div class="panel panel-default" id="openQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <span class="label label-default" id="format"><span class="format-text"></span></span>
            </div>
            <label class="question"></label>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <span class="answer text"></span>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
        </div>
    </div>

    <div class="panel panel-default" id="dichotomousQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-default hidden" id="justification"><?php echo $lang->withJustification ?></span>
                <span class="label label-default hidden" id="no-justification"><?php echo $lang->withoutJustification ?></span>
                <span class="label label-default hidden" id="yes"><?php echo $lang->justificationForYes ?></span>
                <span class="label label-default hidden" id="no"><?php echo $lang->justificationForNo ?></span>
                <span class="label label-default hidden" id="always"><?php echo $lang->justificationAlways ?></span>
            </div>
            <label class="question"></label>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
            <div id="selection"><span id="address"><?php echo $lang->selection ?>:</span> <span class="text"></span></div>
            <div class="hidden" id="justification-content"><span class="address"><?php echo $lang->justification ?>:</span> <span class="text"></span></div>
            <span class="label label-danger hidden" id="no-justification-result"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noJustification ?></span></span>
        </div>
    </div>

    <div class="panel panel-default" id="dichotomousQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-default hidden" id="justification"><?php echo $lang->withJustification ?></span>
                <span class="label label-default hidden" id="no-justification"><?php echo $lang->withoutJustification ?></span>
                <span class="label label-default hidden" id="yes"><?php echo $lang->justificationForYes ?></span>
                <span class="label label-default hidden" id="no"><?php echo $lang->justificationForNo ?></span>
                <span class="label label-default hidden" id="always"><?php echo $lang->justificationAlways ?></span>
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
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
            <div id="selection"><span id="address"><?php echo $lang->selection ?>:</span> <span class="text"></span></div>
            <div class="hidden" id="justification-content"><span class="address"><?php echo $lang->justification ?>:</span> <span class="text"></span></div>
            <span class="label label-danger hidden" id="no-justification-result"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noJustification ?></span></span>
        </div>
    </div>

    <div class="panel panel-default" id="groupingQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-default hidden" id="multiselect"><?php echo $lang->multipleSelectionsAllowed ?></span>
                <span class="label label-default hidden" id="singleselect"><?php echo $lang->singleSelectionsAllowed ?></span>
                <span class="label label-default hidden" id="optionalanswer"><?php echo $lang->ownAnswerAllowed ?></span>
            </div>
            <label class="question"></label>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <span class="label label-danger" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
            <div class="hidden" id="optionalanswer-content" style="margin-top: 17px;"><span class="address"><?php echo $lang->ownAnswers ?>:</span> <span class="text"></span></div>
            <span class="label label-warning" id="no-optional-answer"><span class="label-text"><?php echo $lang->noOwnAnswers ?></span></span>
        </div>
    </div>

    <span id="grouping-question-item">
        <div>
            <span class="label label-default hidden" id="justification"><?php echo $lang->withJustification ?></span>
            <span class="label label-default hidden" id="no-justification"><?php echo $lang->withoutJustification ?></span>
            <span class="label label-default hidden" id="selectOne"><?php echo $lang->justificationForSelection ?></span>
            <span class="label label-default hidden" id="selectNothing"><?php echo $lang->justificationForNoChoice ?></span>
            <span class="label label-default hidden" id="always"><?php echo $lang->justificationAlways ?></span>
        </div>
        <div id="option-text" class="text" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"></div>
        <div>
            <div class="hidden" id="justification-content"><span class="address"><?php echo $lang->justification ?>:</span> <span class="text"></span></div>
            <span class="label label-danger hidden" id="no-answer-justification"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noJustification ?></span></span>
        </div>
    </span>

    <div class="panel panel-default" id="groupingQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-default hidden" id="multiselect"><?php echo $lang->multipleSelectionsAllowed ?></span>
                <span class="label label-default hidden" id="singleselect"><?php echo $lang->singleSelectionsAllowed ?></span>
                <span class="label label-default hidden" id="optionalanswer"><?php echo $lang->ownAnswerAllowed ?></span>
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
            <span class="label label-danger" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
            <div class="hidden" id="optionalanswer-content" style="margin-top: 17px;"><span class="address"><?php echo $lang->ownAnswers ?></span> <span class="text"></span></div>
            <span class="label label-warning" id="no-optional-answer"><span class="label-text"><?php echo $lang->noOwnAnswers ?></span></span>
        </div>
    </div>

    <div id="grouping-question-gus-triggers-option" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block; margin-bottom: 5px"><span class="text"></span></div>
    <div id="grouping-question-gus-feedbacks-option" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block; margin-bottom: 5px"><span class="text"></span></div>
    <div id="grouping-question-gus-gestures-option" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block; margin-bottom: 5px">
        <span class="text"></span>
        <button type="button" class="btn btn-default btn-shadow btn-popover-gesture-preview" style="margin-left: 5px"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text"><?php echo $lang->showGesture ?></span></button>
    </div>

    <div class="panel panel-default" id="groupingQuestionOptions" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-default hidden" id="multiselect"><?php echo $lang->multipleSelectionsAllowed ?></span>
                <span class="label label-default hidden" id="singleselect"><?php echo $lang->singleSelectionsAllowed ?></span>
                <span class="label label-default hidden" id="optionalanswer"><?php echo $lang->ownAnswerAllowed ?></span>
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
            <span class="label label-danger" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
            <div class="hidden" id="optionalanswer-content" style="margin-top: 17px;"><span class="address"><?php echo $lang->ownAnswers ?>:</span> <span class="text"></span></div>
            <span class="label label-warning" id="no-optional-answer"><span class="label-text"><?php echo $lang->noOwnAnswers ?></span></span>
        </div>
    </div>

    <div class="panel panel-default" id="rating" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-success hidden" id="positive"><span class="label-text"><?php echo $lang->positive ?></span></span>
                <span class="label label-danger hidden" id="negative"><span class="label-text"><?php echo $lang->negative ?></span></span>
            </div>
            <label class="question"></label>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
        </div>
    </div>

    <div id="rating-item" class="text">
        <div class="pull-right text" id="score-container"><span class="score-text"></span> <i class="fa" aria-hidden="true"></i></div>
        <div id="scale-container"></div>
    </div>

    <span id="rating-scale-item" class="text" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"></span>

    <div class="panel panel-default" id="matrix" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <span class="label label-default" id="format"><span class="format-text"></span></span>
            </div>
            <label class="question"></label>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
        </div>
    </div>

    <div id="matrix-item" class="text">
        <span id="rating-option" style="margin-right: 5px"></span>
        <span class="label label-success hidden" id="positive"><span class="label-text"><?php echo $lang->positive ?></span></span>
        <span class="label label-danger hidden" id="negative"><span class="label-text"><?php echo $lang->negative ?></span></span>
        <div class="pull-right text" id="score-container" style="margin-top: 9px"><span class="score-text"></span> <i class="fa" aria-hidden="true"></i></div>
        <div id="scale-container" style="margin-top: 10px;"></div>
        <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
    </div>

    <div class="panel panel-default" id="sumQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-default" id="maximum"><span class="label-text"></span></span>
                <span class="label label-default" id="allocation"><span class="label-text"></span></span>
            </div>
            <label class="question"></label>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
            <div class="label label-success hidden" id="distributeAllPoints"><i class="fa fa-check"></i> <span class="label-text"><?php echo $lang->allPointsDistributed ?></span></div>
            <div class="label label-danger hidden" id="distributeNotAllPoints"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->notAllPointsDistributed ?></span></div>
        </div>
    </div>

    <div id="sum-question-item" class="text"></div>

    <div class="panel panel-default" id="ranking" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <span class="label label-default" id="format"><span class="format-text"></span></span>
            </div>
            <label class="question"></label>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->noAnswer ?></span></span>
        </div>
    </div>

    <div id="ranking-item" class="text"></div>

    <div class="panel panel-default" id="alternativeQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-default hidden" id="optionalanswer"><?php echo $lang->ownAnswerAllowed ?></span>
                <span class="label label-default hidden" id="justification"><?php echo $lang->withJustification ?></span>
                <span class="label label-default hidden" id="no-justification"><?php echo $lang->withoutJustification ?></span>
                <span class="label label-default hidden" id="selectOne"><?php echo $lang->justificationForAChoice ?></span>
                <span class="label label-default hidden" id="selectNothing"><?php echo $lang->justificationForNoChoice ?></span>
                <span class="label label-default hidden" id="always"><?php echo $lang->justificationAlways ?></span>
                <span class="label label-default hidden" id="gesturesForGesture"><?php echo $lang->alternativeGesturesForGesture ?></span>
                <span class="label label-default hidden" id="triggersForGesture"><?php echo $lang->alternativeTriggerForGesture ?></span>
                <span class="label label-default hidden" id="triggersForTrigger"><?php echo $lang->alternativeTriggerForTrigger ?></span>
                <span class="label label-default hidden" id="gesturesForTrigger"><?php echo $lang->alternativeGesturesForTrigger ?></span>
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
        <button type="button" class="btn btn-default btn-shadow btn-popover-gesture-preview" style="margin-left: 5px"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text"><?php echo $lang->showGesture ?></span></button>
    </div>

    <div id="alternativeQuestion-trigger-item" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"><span class="text"></span></div>

    <div class="panel panel-default" id="gusSingle" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-success hidden" id="positive"><span class="label-text"><?php echo $lang->positive ?></span></span>
                <span class="label label-danger hidden" id="negative"><span class="label-text"><?php echo $lang->negative ?></span></span>
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

    <div class="panel panel-default" id="susItem" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <span class="label label-default" id="format"><span class="format-text"></span></span>
                <span class="label label-success hidden" id="positive"><span class="label-text"><?php echo $lang->positive ?></span></span>
                <span class="label label-danger hidden" id="negative"><span class="label-text"><?php echo $lang->negative ?></span></span>
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




    <div id="rtc-video-result">
        <div class="alert-space alert-record-url-invalid"></div>
        <div id="loader" class="hidden text-center">
            <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
            <div class="text">
                <?php echo $lang->videoDataLoading ?>
            </div>
        </div>
        <div id="video-timeline" class="hidden">
            <div>
                <div class="row hidden" id="screen-share-video-container" >
                    <div class="col-xs-12">
                        <video id="screen-share-video-holder" preload="auto" autoplay="false" style="width: 100%; height: auto;  border-top-left-radius: 10px; border-top-right-radius: 10px; position: relative"></video>
                        <div class="progress" style="height: 6px; border-radius: 0; border-bottom-right-radius: 4px; border-bottom-left-radius: 4px; margin: 0; width: 100%; margin-top: -8px">
                            <div class="progress-bar progress-bar-primary" id="seek-bar-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%"></div>
                        </div>
                        <div class="video-time-code" style="position: absolute; bottom: 6px; left: 15px; border-top-right-radius: 4px; background-color: rgba(0,0,0,0.8); padding-left: 10px; padding-right: 10px; font-size: 8pt; color: white">
                            <span class="video-time-code-current-time">00:00:00</span>
                            <span> / </span>
                            <span class="video-time-code-duration">00:00:00</span>
                        </div>
                    </div>
                </div>

                <div id="webcam-video-container">
                    <div class="row">
                        <div class="col-xs-6 hidden" id="tester-video-container">
                            <video id="tester-video-holder" preload="auto" autoplay="false" style="width: 100%; height: auto; border-top-left-radius: 4px; border-top-right-radius: 4px; position: relative"></video>
                            <div class="progress" style="height: 6px; border-radius: 0; border-bottom-right-radius: 4px; border-bottom-left-radius: 4px; margin: 0; width: 100%; margin-top: -8px">
                                <div class="progress-bar progress-bar-primary" id="seek-bar-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%"></div>
                            </div>
                            <div class="btn-shadow btn-toggle-mute" style="position: absolute; top: 0; right:15px; border-top-right-radius: 4px; border-bottom-left-radius: 10px; background-color: rgba(0,0,0,0.8); padding-left: 10px; padding-right: 10px; cursor: pointer">
                                <i class="fa fa-volume-up" style="color: white"></i>
                            </div>
                            <div class="video-time-code" style="position: absolute; bottom: 6px; left: 15px; border-top-right-radius: 4px; background-color: rgba(0,0,0,0.8); padding-left: 10px; padding-right: 10px; font-size: 8pt; color: white">
                                <span class="video-time-code-current-time">00:00:00</span>
                                <span> / </span>
                                <span class="video-time-code-duration">00:00:00</span>
                            </div>
                        </div>
                        <div class="col-xs-6 hidden" id="moderator-video-container">
                            <video id="moderator-video-holder" preload="auto" autoplay="false" style="width: 100%; height: auto; border-top-left-radius: 4px; border-top-right-radius: 4px; position: relative"></video>
                            <div class="progress" style="height: 6px; border-radius: 0; border-bottom-right-radius: 4px; border-bottom-left-radius: 4px; margin: 0; width: 100%; margin-top: -8px">
                                <div class="progress-bar progress-bar-primary" id="seek-bar-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%"></div>
                            </div>
                            <div class="btn-shadow btn-toggle-mute" style="position: absolute; top: 0; right:15px; border-top-right-radius: 4px; border-bottom-left-radius: 10px; background-color: rgba(0,0,0,0.8); padding-left: 10px; padding-right: 10px; cursor: pointer">
                                <i class="fa fa-volume-up" style="color: white"></i>
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
                    <div class="col-xs-3 col-sm-2 col-lg-2" id="gap-input-container">
                        <div class="input-group">
                            <input type="number" class="form-control text-center" id="gap-input" min="-10" max="10" step="0.01" readonly />
                            <span class="input-group-btn">
                                <button class="btn btn-default" id="btn-lock-unlock-gap-input" type="button" alt="Videos synchronisieren"><i class="fa fa-pencil"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-2 col-lg-1" id="play-pause-container">
                        <button type="button" class="btn btn-block btn-default" id="btn-play-pause"><i class="fa fa-play"></i></button>
                    </div>
                    <div class="col-xs-7 col-sm-8 col-lg-9" id="seek-bar-container">
                        <div class="progress" id="main-seek-bar" style="border-radius: 4px; height:34px; margin: 0; cursor: pointer">
                            <div class="progress-bar progress-bar-primary" id="seek-bar-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%"></div>
                        </div>
                        <div id="seek-bar-meta-info-container" class="col-xs-12" style="padding: 0"></div>
                    </div>
                </div>

            </div>
            <div id="results-timeline" style="margin-top: 20px; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"></div>
        </div>

    </div>

    <div class="root" id="gestureTraining">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr id="horizontalLine">
        <div class="alert-space alert-no-record"></div>
        <div class="alert-space alert-webm-unsupported"></div>
        <div id="link-list-container" style="margin-top: 20px"></div>
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
        <div class="col-sm-6 root">
            <div class="previewGesture mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
            <div class="text-center gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div id="gesture"><span class="address"></span> <span class="text"></span></div>
            <div id="trigger"><span class="address"></span> <span class="text"></span></div>
            <div id="feedback"><span class="address"></span> <span class="content" style="display: inline-block"></span></div>
            <div id="recognition-time"><span class="address"></span> <span class="text"></span></div>
            <div id="repeats"><span class="address"></span> <span class="text"></span></div>
            <div id="training-time"><span class="address"></span> <span class="text"></span></div>
        </div>
    </div>



    <div class="root" id="gestureSlideshow">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr id="horizontalLine">
        <div class="alert-space alert-no-record"></div>
        <div class="alert-space alert-webm-unsupported"></div>
        <div id="link-list-container" style="margin-top: 20px"></div>
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
        <div class="col-sm-6 root">
            <div class="previewGesture mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
            <div class="text-center gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div id="gesture"><span class="address"></span> <span class="text"></span></div>
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
        <div id="link-list-container" style="margin-top: 20px"></div>
        <div id="summary-container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="text text-center" id="score">
                        <div id="error" class="hidden">
                            <p><i class="fa fa-bolt text" style="font-size: 120pt; line-height: 110pt"></i></p>
                            <p><?php echo $lang->noTriggerScoreCalculationPossible ?></p>
                        </div>
                        <div class="address" style="font-size: 20pt"></div>
                        <div class="text" style="font-size: 120pt; line-height: 110pt"></div>
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
        <div class="col-sm-6 root">
            <div class="previewGesture mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
            <div class="text-center gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div id="gesture"><span class="address"></span> <span class="text"></span></div>
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
        <div id="link-list-container" style="margin-top: 20px"></div>
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

    <div id="link-list-item" class="link-list-item" style="font-size: 10pt"><span class="link-list-item-time"></span> - <span class="text link-list-item-title"></span></div>

    <div class="row" id="physicalStressTest-item" style="margin-bottom: 30px">
        <div class="col-sm-5 root">
            <div class="previewGesture mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
            <div class="text-center gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                </div>
            </div>
        </div>

        <div class="col-sm-7">
            <div id="gesture"><span class="address"></span> <span class="text"></span></div>
            <div id="single-stress-answers">
                <h4 id="headline-single-questions"><?php echo $lang->singleAnswers ?></h4>
                <div class="question-container"></div>
            </div>
            <div id="sequence-stress-answers" style="margin-top: 40px">
                <h4 id="headline-sequence-questions"><?php echo $lang->multipleAnswers ?></h4>
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
        <div id="link-list-container" style="margin-top: 20px"></div>
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
        <div id="link-list-container" style="margin-top: 20px"></div>

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
        <div><?php echo $lang->potentialGesturesOverviewTable ?></div>
        <table class="table table-bordered table-sm text">
            <thead>
                <tr class="table-head-row">
                    <th scope="col" class="basic"><?php echo $lang->trigger ?></th>
                    <th scope="col" class="effect"><?php echo $lang->gesture ?></th>
                    <th scope="col"><?php echo $lang->estimability ?></th>
                    <th scope="col"><?php echo $lang->approval ?></th>
                </tr>
            </thead>
            <tbody class="table-body"></tbody>
        </table>
    </div>



    <div id="amount-container-appearance-trigger" style="margin-bottom: 30px">
        <p id="headline" style="margin: 0"><span class="text" style="margin-right: 5px"></span> <span class="badge"></span></p> 
        <hr>
        <div id="item-view"></div>
    </div>

    <div id="appearance-trigger-gesture" class="root" style="margin-bottom: 40px">
        <div id="headline-trigger-gesture"></div>

        <div class="row" style="margin-top: 10px">
            <div id="gestures-list-container"></div>
        </div>
    </div>

    <div id="appearance-trigger-gesture-potential" class="root" style="margin-bottom: 60px">
        <div id="headline-trigger-gesture"></div>

        <div class="row" id="potential-parameters-container" style="margin-top: 10px">
            <div class="col-xs-12 col-md-8" id="potential-parameters"></div>
        </div>

        <div id="more-classified-gestures" class="hidden" style="margin-top: 20px">
            <p><?php echo $lang->otherAssociatedGestures ?></p>
            <div class="row" style="margin-top: 10px">
                <div id="gestures-list-container"></div>
            </div>
        </div>
    </div>

    <div id="potential-gesture-parameters-appearance-trigger">
        <div id="parameters-amount">
            <div><h4 style="margin: 0"><i class="fa fa-pie-chart" aria-hidden="true"></i> <?php echo $lang->number ?></h4></div>
            <span class="text" id="justification"></span>
            <br/>
            <span class="hidden success" id="well"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->suitable ?></span></span>
            <span class="hidden warning" id="even"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->neitherNor ?></span></span>
            <span class="hidden danger" id="less-well"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->notSuitable ?></span></span>
        </div>
        <div id="parameters-agreement-measures" style="margin-top: 20px">
            <div><h4 style="margin: 0"><i class="fa fa-percent" aria-hidden="true"></i> <?php echo $lang->measureOfGuess ?></h4></div>
            <div id="agreement"><span id="label"><?php echo $lang->estimability ?>:</span> <span class="text"></span></div>
        </div>
        <div id="parameters-guessability" class="hidden" style="margin-top: 20px">
            <div><h4 style="margin: 0"><i class="fa fa-users" aria-hidden="true"></i> <?php echo $lang->measureOfApproval ?></h4></div>
            <div id="accordance"><span id="label"><?php echo $lang->approval ?>:</span> <span class="text"></span></div>
            <span class="hidden success veryHighAgreement"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->veryHighAgreement ?></span></span>
            <span class="hidden success highAgreement"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->highAgreement ?></span></span>
            <span class="hidden warning mediumAgreement"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->mediumAgreement ?></span></span>
            <span class="hidden danger lowAgreement"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->lowAgreement ?></span></span>
        </div>
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
        <span class="hidden warning" id="even"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->neitherNor ?></span></span>
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







    <div id="amount-container-appearance-gesture" style="margin-bottom: 30px">
        <p id="headline" style="margin: 0"><span class="text" style="margin-right: 5px"></span> <span class="badge"></span></p> 
        <hr>
        <div id="item-view"></div>
    </div>

    <div id="appearance-gesture-trigger" class="root" style="margin-bottom: 40px">
        <div id="headline-gesture-trigger"></div>

        <div class="row" style="margin-top: 10px">
            <div id="trigger-list-container"></div>
        </div>
    </div>

    <div id="appearance-gesture-trigger-potential" class="root" style="margin-bottom: 60px">
        <div id="headline-trigger-gesture"></div>

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
            <span class="hidden warning" id="even"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->neitherNor ?></span></span>
            <span class="hidden danger" id="less-well"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->notSuitable ?></span></span>
        </div>
        <div id="parameters-agreement-measures" style="margin-top: 20px">
            <div><h4 style="margin: 0"><i class="fa fa-percent" aria-hidden="true"></i> <?php echo $lang->measureOfGuess ?></h4></div>
            <div id="agreement"><span id="label"><?php echo $lang->estimability ?>:</span> <span class="text"></span></div>
        </div>
        <div id="parameters-guessability" class="hidden" style="margin-top: 20px">
            <div><h4 style="margin: 0"><i class="fa fa-users" aria-hidden="true"></i> <?php echo $lang->measureOfApproval ?></h4></div>
            <div id="accordance"><span id="label"><?php echo $lang->approval ?>:</span> <span class="text"></span></div>
            <span class="hidden success veryHighAgreement"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->veryHighAgreement ?></span></span>
            <span class="hidden success highAgreement"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span><?php echo $lang->highAgreement ?></span></span>
            <span class="hidden warning mediumAgreement"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->mediumAgreement ?></span></span>
            <span class="hidden danger lowAgreement"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span><?php echo $lang->lowAgreement ?></span></span>
        </div>
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
        <span class="hidden warning" id="even"><i class="fa fa-caret-right" aria-hidden="true"></i> <span><?php echo $lang->neitherNor ?></span></span>
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






    <div class="panel panel-default" id="panel-gesture-set">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow" id="btn-delete-gesture-set"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span class="panel-heading-text"></span>
        </div>

        <div class="panel-body" id="item-view">
            <div class="row" id="gestures-list-container">

            </div>
        </div>
    </div>

</div>











<div id="template-study-editable-container" class="hidden">

    <div class="panel panel-default" id="counter" style="margin-bottom: 5px;">
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
                        <span class="glyphicon glyphicon-minus"></span><span class="sr-only"><?php echo $lang->less ?></span>
                    </button>
                </div>
                <input type="text" class="form-control readonly text-center stepper-text" value="0">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default btn-shadow btn-stepper-increase" value="10">
                        <span class="glyphicon glyphicon-plus"></span><span class="sr-only"><?php echo $lang->more ?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default" id="openQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <textarea class="form-control" id="openQuestionInput" rows="5" placeholder=""></textarea>
        </div>
    </div>

    <div class="panel panel-default" id="dichotomousQuestion" style="margin-bottom: 5px;">
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

    <div class="panel panel-default" id="groupingQuestion" style="margin-bottom: 5px;">
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

    <div class="panel panel-default" id="rating" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default" id="sumQuestion" style="margin-bottom: 5px;">
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

    <div class="panel panel-default" id="ranking" style="margin-bottom: 5px;">
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
            <button type="button" class="btn btn-default btn-shadow btn-popover-gesture-preview hidden"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text"><?php echo $lang->showGesture ?></span></button>
        </div>
    </div>

    <div id="web">
        <span><?php echo $lang->title ?>: </span><span class="title"></span><br/>
        <span><?php echo $lang->type ?>: </span><div class="label label-default type"><i class="fa fa-link"></i> <span class="label-text"></span></div><br/><br/>
        <iframe class="web-frame" src="" frameborder="0" scrolling="no" style="width: 100%; height: 400px; pointer-events: none;"></iframe>
        <button type="button" class="btn btn-default btn-shadow btn-block btn-url" aria-label="<?php echo $lang->openUrlInNewWindow ?>"><i class="glyphicon glyphicon-link"></i> <?php echo $lang->openUrlInNewWindow ?></button>
    </div>

    <div id="pidoco">
        <span><?php echo $lang->title ?>: </span><span class="title"></span><br/>
        <span><?php echo $lang->type ?>: </span><div class="label label-default type"><i class="fa fa-link"></i> <span class="label-text"></span></div><br/><br/>
        <iframe class="web-frame" src="" frameborder="0" scrolling="no" style="width: 100%; height: 400px; pointer-events: none;"></iframe>
        <button type="button" class="btn btn-default btn-shadow btn-block btn-url" aria-label="<?php echo $lang->openUrlInNewWindow ?>"><i class="glyphicon glyphicon-link"></i> <?php echo $lang->openUrlInNewWindow ?></button>
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