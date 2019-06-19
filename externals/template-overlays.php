<?php
include '../includes/language.php';
?>

<div id="overlays-item-container" class="hidden">

    <div id="letterOfAcceptance">
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row" style="margin-bottom: 16px">
            <div class="col-md-7">

                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3><span id="phase-step-title"><?php echo $lang->formats->letterOfAcceptance->text ?></span></h3>
                    </div>
                </div>

            </div>
            <div class="col-md-4"></div>
        </div>

        <div class="row" style="margin-bottom: 30px;">

            <div class="col-md-7">
                <div class="form-group">
                    <div class="alert-space alert-script-input-error"></div>
                    <textarea class="form-control" id="declaration" rows="20" placeholder="<?php echo $lang->insertDeclaration ?>" style="margin-top: 6px"></textarea>
                </div>
            </div>

            <div class="col-md-4">
                <div style=""><?php echo $lang->tooltips->studyCreate->letterOfAcceptanceOverlay ?></div>
            </div>
        </div>

        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
    </div>

    <div id="thanks">
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row" style="margin-bottom: 16px">
            <div class="col-md-7">

                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3><span id="phase-step-title"><?php echo $lang->formats->thanks->text ?></span></h3>
                    </div>
                </div>

            </div>
            <div class="col-md-5"></div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <textarea class="form-control" id="declaration" rows="10" placeholder="<?php echo $lang->thanksInput ?>" style="margin-top: 6px"></textarea>
            </div>

            <div class="col-md-5">
                <div style=""><?php echo $lang->tooltips->studyCreate->thanksOverlay ?></div>
            </div>
        </div>

        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
    </div>


    <div id="questionnaire">
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-7">
                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 class="overlay-title-editable" id="overlay-title"><span id="phase-step-title"></span> <i class="fa fa-pencil" id="btn-edit-phase-step-title"></i></h3>

                        <div class="input-group hidden" id="phase-step-title-input-container">
                            <input class="form-control item-input-text" id="phase-step-title-input" type="text" value="" maxlength="30"/>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-success btn-shadow" id="btn-save-phase-step-title" data-toggle="tooltip"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 20px">
                    <div class="alert-space alert-no-data-questionnaire"></div>
                    <div class="container-root" id="list-container"></div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="toggle-affix" style="">
                    <div class="add-button-group" id="add-question-button-group">
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->openQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->dichotomousQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestionOptions ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->rating ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->matrix ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->sumQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->ranking ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->counter ?>"></i>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-default btn-shadow btn-preview-questionnaire" style="margin-top: 10px"><i class="fa fa-eye"></i> <?php echo $lang->previewHoleQuestionnaire ?></button>
                </div>

            </div>
        </div>

        <br/>
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
    </div>

    <div id="interview">
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-7">
                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 class="overlay-title-editable" id="overlay-title"><span id="phase-step-title"></span> <i class="fa fa-pencil" id="btn-edit-phase-step-title"></i></h3>

                        <div class="input-group hidden" id="phase-step-title-input-container">
                            <input class="form-control item-input-text" id="phase-step-title-input" type="text" value="" maxlength="30"/>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-success btn-shadow" id="btn-save-phase-step-title" data-toggle="tooltip"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>

                </div>

                <div style="margin-top: 20px">
                    <div class="alert-space alert-no-data-questionnaire"></div>
                    <div class="container-root" id="list-container"></div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="toggle-affix" style="">
                    <div class="add-button-group" id="add-question-button-group">
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->openQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->dichotomousQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestionOptions ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->rating ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->matrix ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->sumQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->ranking ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->counter ?>"></i>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-default btn-shadow btn-preview-questionnaire" style="margin-top: 10px"><i class="fa fa-eye"></i> <?php echo $lang->previewHoleQuestionnaire ?></button>
                </div>

            </div>
        </div>

        <br/>
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
    </div>


    <div id="gus">
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-7">

                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 class="overlay-title-editable" id="overlay-title"><span id="phase-step-title"></span> <i class="fa fa-pencil" id="btn-edit-phase-step-title"></i></h3>

                        <div class="input-group hidden" id="phase-step-title-input-container">
                            <input class="form-control item-input-text" id="phase-step-title-input" type="text" value="" maxlength="30"/>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-success btn-shadow" id="btn-save-phase-step-title" data-toggle="tooltip"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="general" style="margin-top: 24px">
                    <div class="alert-space alert-assembled-gesture-removed"></div>
                    <div class="alert-space alert-assembled-trigger-removed"></div>

                    <div class="form-group" id="forGesture">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $lang->gesture ?></span>
                            <input class="form-control item-input-text option-gesture show-dropdown" tabindex="-1" type="text" value=""/>
                            <div class="input-group-btn select gestureSelect" role="group">
                                <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                </ul>
                            </div>
                        </div>

                        <div class="input-group" id="gesture-trigger" style="margin-top: 10px">
                            <span class="input-group-addon"><?php echo $lang->trigger ?></span>
                            <input class="form-control item-input-text option-trigger show-dropdown" tabindex="-1" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                            <div class="input-group-btn select triggerSelect" role="group">
                                <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                            </div>
                        </div>

                        <div class="input-group" id="gesture-feedback" style="margin-top: 10px">
                            <span class="input-group-addon"><?php echo $lang->feedback ?></span>
                            <input class="form-control item-input-text option-feedback show-dropdown" tabindex="-1" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                            <div class="input-group-btn select feedbackSelect" role="group">
                                <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="alert-space alert-no-data-gus"></div>
                    <div class="container-root" id="list-container"></div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="toggle-affix">
                    <div id="dimension-controls">
                        <div class="dimension-container">
                            <h4 style="margin-top: 0"><?php echo $lang->aspects ?></h4>
                            <div class="dimension-btn-group">
                                <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-default btn-shadow btn-preview-questionnaire" style="margin-top: 10px"><i class="fa fa-eye"></i> <?php echo $lang->previewHoleQuestionnaire ?></button>
                </div>
            </div>
        </div>

        <br/>
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
    </div>

    <div id="questionnaireGestures">
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-7">

                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 class="overlay-title-editable" id="overlay-title"><span id="phase-step-title"></span> <i class="fa fa-pencil" id="btn-edit-phase-step-title"></i></h3>

                        <div class="input-group hidden" id="phase-step-title-input-container">
                            <input class="form-control item-input-text" id="phase-step-title-input" type="text" value="" maxlength="30"/>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-success btn-shadow" id="btn-save-phase-step-title" data-toggle="tooltip"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>

                </div>

                <div style="margin-top: 24px">
                    <div class="alert-space alert-no-data-gus-questionnaire"></div>
                    <div class="container-root" id="list-container"></div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="toggle-affix">
                    <div id="dimension-controls">
                        <div class="dimension-container">
                            <h4 style="margin-top: 0"><?php echo $lang->aspects ?></h4>
                            <div class="dimension-btn-group">
                                <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-default btn-shadow btn-preview-questionnaire" style="margin-top: 10px"><i class="fa fa-eye"></i> <?php echo $lang->previewHoleQuestionnaire ?></button>
                </div>

            </div>
        </div>

        <br/>
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
    </div>

    <div id="sus">
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-7">

                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 class="overlay-title-editable" id="overlay-title"><span id="phase-step-title"></span> <i class="fa fa-pencil" id="btn-edit-phase-step-title"></i></h3>

                        <div class="input-group hidden" id="phase-step-title-input-container">
                            <input class="form-control item-input-text" id="phase-step-title-input" type="text" value="" maxlength="30"/>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-success btn-shadow" id="btn-save-phase-step-title" data-toggle="tooltip"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>

                </div>

                <div style="margin-top: 20px">
                    <div class="alert-space alert-no-data-sus"></div>
                    <div class="container-root" id="list-container"></div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="toggle-affix">
                    <button class="btn btn-default btn-shadow btn-preview-questionnaire" style=""><i class="fa fa-eye"></i> <?php echo $lang->previewHoleQuestionnaire ?></button>
                </div>
            </div>

        </div>

        <br/>
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
    </div>

    <div id="ueq">
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-7">

                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 class="overlay-title-editable" id="overlay-title"><span id="phase-step-title"></span> <i class="fa fa-pencil" id="btn-edit-phase-step-title"></i></h3>

                        <div class="input-group hidden" id="phase-step-title-input-container">
                            <input class="form-control item-input-text" id="phase-step-title-input" type="text" value="" maxlength="30"/>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-success btn-shadow" id="btn-save-phase-step-title" data-toggle="tooltip"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>

                </div>

                <div style="margin-top: 24px">
                    <div class="alert-space alert-no-data-ueq-questionnaire"></div>
                    <div class="container-root" id="list-container"></div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="toggle-affix">
                    <div id="dimension-controls">
                        <div class="dimension-container">
                            <h4 style="margin-top: 0"><?php echo $lang->aspects ?></h4>
                            <div class="dimension-btn-group">
                                <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-default btn-shadow btn-preview-questionnaire" style="margin-top: 10px"><i class="fa fa-eye"></i> <?php echo $lang->previewHoleQuestionnaire ?></button>
                </div>
            </div>
        </div>

        <br/>
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
    </div>











    <div id="gestureTraining">
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row" style="margin-bottom: 16px">
            <div class="col-md-7">

                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 class="overlay-title-editable" id="overlay-title"><span id="phase-step-title"></span> <i class="fa fa-pencil" id="btn-edit-phase-step-title"></i></h3>

                        <div class="input-group hidden" id="phase-step-title-input-container">
                            <input class="form-control item-input-text" id="phase-step-title-input" type="text" value="" maxlength="30"/>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-success btn-shadow" id="btn-save-phase-step-title" data-toggle="tooltip"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-5"></div>
        </div>

        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-7">

                <div id="general">
                    <div class="form-group">
                        <label for="trainingDescription"><?php echo $lang->trainingDescription ?></label>
                        <textarea class="form-control" id="trainingDescription" rows="7" placeholder="<?php echo $lang->insertTrainingDescription ?>" style="resize: none"></textarea>
                    </div>
                </div>

            </div>

            <div class="col-md-5">
                <div style="margin-top: 24px"><?php echo $lang->tooltips->studyCreate->gestureTrainingOverlay ?></div>
            </div>
        </div>


        <h3 style="margin-top: 20px;"><?php echo $lang->trainingElements ?></h3>

        <hr style="margin-top: 10px">

        <div class="row" id="training" style="margin-bottom: 30px;">
            <div class="col-md-7">
                <div id="trainingContainer">
                    <div class="alert-space alert-no-trigger-assembled-link"></div>
                    <div class="alert-space alert-no-feedback-assembled-link"></div>
                    <div class="alert-space alert-no-study-gestures-assembled-link"></div>
                    <div class="alert-space alert-no-phase-data"></div>

                    <div class="option-container"></div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <button class="btn btn-info btn-shadow font-bold btn-add-gestureTrainingOption" type="button" style="z-index: 3000"><span class="fa fa-plus"></span> <span><?php echo $lang->addTrainingElement ?></span></button>
                </div>
            </div>
        </div>

        <div style="display: inline;">
            <h3 style="display:inline-block"><?php echo $lang->observationForm ?></h3>
        </div>

        <hr style="margin-top: 10px">

        <div class="row" id="observations">
            <div class="col-md-7">
                <div class="alert-space alert-no-data-questionnaire"></div>
                <div class="form-group container-root" id="list-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <div id="dimension-controls">
                        <div class="dimension-container">
                            <h4 style="margin-top: 0"><?php echo $lang->aspects ?></h4>
                            <div class="dimension-btn-group">
                                <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                            </div>
                        </div>
                    </div>

                    <h4><?php echo $lang->userDefined ?></h4>
                    <div class="add-button-group" id="add-observation-button-group">
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->openQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->dichotomousQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestionOptions ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->rating ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->matrix ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->sumQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->ranking ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->counter ?>"></i>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-default btn-shadow btn-preview-questionnaire" style="margin-top: 10px"><i class="fa fa-eye"></i> <?php echo $lang->previewHoleQuestionnaire ?></button>
                </div>

            </div>
        </div>

        <br/>
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
    </div>

    <div id="scenario">
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row" style="margin-bottom: 16px">
            <div class="col-md-6">

                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 class="overlay-title-editable" id="overlay-title"><span id="phase-step-title"></span> <i class="fa fa-pencil" id="btn-edit-phase-step-title"></i></h3>

                        <div class="input-group hidden" id="phase-step-title-input-container">
                            <input class="form-control item-input-text" id="phase-step-title-input" type="text" value="" maxlength="30"/>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-success btn-shadow" id="btn-save-phase-step-title" data-toggle="tooltip"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6"></div>
        </div>

        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-6">

                <div id="general" style="">
                    <div class="form-group">
                        <label for="scenarioDescription"><?php echo $lang->scenarioDescription ?></label>
                        <textarea class="form-control" id="scenarioDescription" rows="7" placeholder="<?php echo $lang->insertScenarioDescription ?>" style="resize: none"></textarea>
                    </div>

                    <div class="alert-space alert-assembled-scene-removed"></div>

                    <div class="form-group" id="start-scene-select">
                        <label><?php echo $lang->stateCharts->inputState ?> <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->scenarioStartScene ?>"></i></label>
                        <div class="input-group"> 
                            <input class="form-control item-input-text show-dropdown option-scene" tabindex="-1" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                            <div class="input-group-btn select sceneSelect" role="group">
                                <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div style="margin-top: 24px"><?php echo $lang->tooltips->studyCreate->scenarioOverlay ?></div>
            </div>
        </div>


        <div style="display: inline;">
            <h3 style="display:inline-block"><?php echo $lang->tasks ?></h3>
        </div>

        <hr style="margin-top: 10px">

        <div class="row" id="tasks-container" style="margin-bottom: 30px;">
            <div class="col-md-7">
                <div class="alert-space alert-no-phase-data"></div>
                <div class="task-option-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <button class="btn btn-info btn-shadow font-bold btn-add-taskOption" type="button" style="z-index: 1000"><span class="fa fa-plus"></span> <span><?php echo $lang->addTaskElement ?></span></button>
                </div>
            </div>
        </div>

        <div style="display: inline;">
            <h3 style="display:inline-block"><?php echo $lang->taskAssessment ?></h3>
        </div>

        <hr style="margin-top: 10px">

        <div class="row" id="task-assessment-container" style="margin-bottom: 30px;">
            <div class="col-md-7">
                <div class="alert-space alert-no-phase-data"></div>
                <div class="option-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <button class="btn btn-info btn-shadow font-bold btn-add-taskAssessmentOption" type="button" style="z-index: 1000"><span class="fa fa-plus"></span> <span><?php echo $lang->addTaskAssessmentElement ?></span></button>
                </div>
            </div>
        </div>

        <div style="display: inline;">
            <h3 style="display:inline-block"><?php echo $lang->help ?></h3>
        </div>

        <hr style="margin-top: 10px">

        <div class="row" id="help" style="margin-bottom: 30px;">
            <div class="col-md-7">
                <div class="alert-space alert-no-phase-data"></div>
                <div class="alert-space alert-no-scenes-assembled-link"></div>
                <div class="alert-space alert-no-study-gestures-assembled-link"></div>
                <div class="option-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <button type="button" class="btn btn-info btn-shadow font-bold btn-add-helpOption" style="z-index: 1000"><span class="fa fa-plus"></span> <span><?php echo $lang->addHelp ?></span></button>
                </div>
            </div>
        </div>


        <div style="display: inline;">
            <h3 style="display:inline-block"><?php echo $lang->observationForm ?></h3>
        </div>

        <hr style="margin-top: 10px">

        <div class="row" id="observations">
            <div class="col-md-7">
                <div class="alert-space alert-no-data-questionnaire"></div>
                <div class="form-group container-root" id="list-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <div id="dimension-controls">
                        <div class="dimension-container">
                            <h4 style="margin-top: 0"><?php echo $lang->aspects ?></h4>
                            <div class="dimension-btn-group">
                                <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                            </div>
                        </div>

                    </div>

                    <h4><?php echo $lang->userDefined ?></h4>
                    <div class="add-button-group" id="add-observation-button-group">
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->openQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->dichotomousQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestionOptions ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->rating ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->matrix ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->sumQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->ranking ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->counter ?>"></i>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-default btn-shadow btn-preview-questionnaire" style="margin-top: 10px"><i class="fa fa-eye"></i> <?php echo $lang->previewHoleQuestionnaire ?></button>
                </div>

            </div>
        </div>


        <br/>
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
    </div>

    <div id="gestureSlideshow">
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row" style="margin-bottom: 16px">
            <div class="col-md-7">

                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 class="overlay-title-editable" id="overlay-title"><span id="phase-step-title"></span> <i class="fa fa-pencil" id="btn-edit-phase-step-title"></i></h3>

                        <div class="input-group hidden" id="phase-step-title-input-container">
                            <input class="form-control item-input-text" id="phase-step-title-input" type="text" value="" maxlength="30"/>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-success btn-shadow" id="btn-save-phase-step-title" data-toggle="tooltip"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-5"></div>
        </div>

        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-7">

                <div id="general" style="">
                    <div class="form-group">
                        <label for="slideshowDescription"><?php echo $lang->description ?></label>
                        <textarea class="form-control" id="slideshowDescription" rows="7" placeholder="<?php echo $lang->insertDescription ?>" style="resize: none"></textarea>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div style="margin-top: 24px"><?php echo $lang->tooltips->studyCreate->gestureSlideshowOverlay ?></div>
            </div>
        </div>


        <h3 style="margin-top: 20px;"><?php echo $lang->elements ?></h3>

        <hr style="margin-top: 10px">

        <div class="row" id="slideshow" style="margin-bottom: 30px;">
            <div class="col-md-7">
                <div class="alert-space alert-no-gestures-assembled"></div>
                <div class="alert-space alert-no-trigger-assembled"></div>
                <div class="alert-space alert-no-phase-data"></div>

                <div class="option-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <button class="btn btn-info btn-shadow font-bold btn-add-slideshowOption" type="button" style="z-index: 1000"><span class="fa fa-plus"></span> <span><?php echo $lang->addSlideshowElement ?></span></button>
                </div>
            </div>
        </div>





        <div style="display: inline;">
            <h3 style="display:inline-block"><?php echo $lang->observationForm ?></h3>
        </div>

        <hr style="margin-top: 10px">

        <div class="row" id="observations">
            <div class="col-md-7">
                <div class="alert-space alert-no-data-questionnaire"></div>
                <div class="form-group container-root" id="list-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <div id="dimension-controls">
                        <div class="dimension-container">
                            <h4 style="margin-top: 0"><?php echo $lang->aspects ?></h4>
                            <div class="dimension-btn-group">
                                <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                            </div>
                        </div>
                    </div>

                    <h4 style=""><?php echo $lang->userDefined ?></h4>
                    <div class="add-button-group" id="add-observation-button-group">
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->openQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->dichotomousQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestionOptions ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->rating ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->matrix ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->sumQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->ranking ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->counter ?>"></i>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-default btn-shadow btn-preview-questionnaire" style="margin-top: 10px"><i class="fa fa-eye"></i> <?php echo $lang->previewHoleQuestionnaire ?></button>
                </div>

            </div>
        </div>


        <br/>
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
    </div>

    <div id="triggerSlideshow">
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row" style="margin-bottom: 16px">
            <div class="col-md-7">

                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 class="overlay-title-editable" id="overlay-title"><span id="phase-step-title"></span> <i class="fa fa-pencil" id="btn-edit-phase-step-title"></i></h3>

                        <div class="input-group hidden" id="phase-step-title-input-container">
                            <input class="form-control item-input-text" id="phase-step-title-input" type="text" value="" maxlength="30"/>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-success btn-shadow" id="btn-save-phase-step-title" data-toggle="tooltip"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-5"></div>
        </div>

        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-7">

                <div id="general" style="">
                    <div class="form-group">
                        <label for="slideshowDescription"><?php echo $lang->description ?></label>
                        <textarea class="form-control" id="slideshowDescription" rows="7" placeholder="<?php echo $lang->insertDescription ?>" style="resize: none"></textarea>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div style="margin-top: 24px"><?php echo $lang->tooltips->studyCreate->triggerSlideshowOverlay ?></div>
            </div>
        </div>




        <h3 style="margin-top: 20px;"><?php echo $lang->elements ?></h3>

        <hr style="margin-top: 10px">

        <div class="row" id="slideshow" style="margin-bottom: 30px;">
            <div class="col-md-7">
                <div class="alert-space alert-no-gestures-assembled"></div>
                <div class="alert-space alert-no-trigger-assembled"></div>
                <div class="alert-space alert-no-phase-data"></div>

                <div class="option-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <button class="btn btn-info btn-shadow font-bold btn-add-slideshowOption" type="button" style="z-index: 1000"><span class="fa fa-plus"></span> <span><?php echo $lang->addSlideshowElement ?></span></button>
                </div>
            </div>
        </div>




        <div style="display: inline;">
            <h3 style="display:inline-block"><?php echo $lang->observationForm ?></h3>
            <!--            <div class="btn-group" id="useObservationsSwitch" style="margin-top: -9px; margin-left: 10px">
                            <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                            <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                        </div>-->
        </div>
        <!--        <div class="row">
                    <div class="col-md-11">-->
        <hr style="margin-top: 10px">
        <!--            </div>
                </div>-->
        <div class="row" id="observations">
            <div class="col-md-7">
                <div class="alert-space alert-no-data-questionnaire"></div>
                <div class="form-group container-root" id="list-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <div class="add-button-group" id="add-observation-button-group">
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->openQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->dichotomousQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestionOptions ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->rating ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->matrix ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->sumQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->ranking ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->counter ?>"></i>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-default btn-shadow btn-preview-questionnaire" style="margin-top: 10px"><i class="fa fa-eye"></i> <?php echo $lang->previewHoleQuestionnaire ?></button>
                </div>

            </div>
        </div>


        <br/>
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
    </div>

    <div id="physicalStressTest">
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row" style="margin-bottom: 16px">
            <div class="col-md-7">

                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 class="overlay-title-editable" id="overlay-title"><span id="phase-step-title"></span> <i class="fa fa-pencil" id="btn-edit-phase-step-title"></i></h3>

                        <div class="input-group hidden" id="phase-step-title-input-container">
                            <input class="form-control item-input-text" id="phase-step-title-input" type="text" value="" maxlength="30"/>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-success btn-shadow" id="btn-save-phase-step-title" data-toggle="tooltip"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>

                    <!--<div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>-->
                </div>
            </div>
            <div class="col-md-5"></div>
        </div>

        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-7">

                <div id="general" style="">
                    <!--                    <div class="form-group">
                                            <label for="stressTestTitle"><?php echo $lang->title ?></label>
                                            <input type="text" class="form-control" id="stressTestTitle" placeholder="<?php echo $lang->insertTitle ?>">
                                        </div>-->
                    <div class="form-group">
                        <label for="stressTestDescription"><?php echo $lang->description ?></label>
                        <textarea class="form-control" id="stressTestDescription" rows="7" placeholder="<?php echo $lang->insertDescription ?>" style="resize: none"></textarea>
                    </div>
                    <div class="form-group">
                        <label><?php echo $lang->runsPerGesture ?></label>
                        <div class="input-group simple-stepper">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default btn-shadow btn-stepper-decrease" value="2">
                                    <span class="fa fa-minus"></span><span class="sr-only"><?php echo $lang->oneLess ?></span>
                                </button>
                            </div>
                            <input type="text" class="form-control readonly text-center stepper-text" id="totalStressAmount" value="10">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default btn-shadow btn-stepper-increase" value="300">
                                    <span class="fa fa-plus"></span><span class="sr-only"><?php echo $lang->oneMore ?></span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-md-5">
                <div style="margin-top: 24px"><?php echo $lang->tooltips->studyCreate->physicalStressTestOverlay ?></div>
            </div>
        </div>




        <h3 style="margin-top: 20px;"><?php echo $lang->gestureSequences ?></h3>
        <!--        <div class="row">
                    <div class="col-md-11">-->
        <hr style="margin-top: 10px">
        <!--            </div>
                </div>-->
        <div class="row" id="stressTest" style="margin-bottom: 30px;">
            <div class="col-md-7">
                <div class="alert-space alert-no-study-gestures-assembled-link"></div>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="option-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <button class="btn btn-info btn-shadow font-bold btn-add-physicalStressTestOption" type="button" style="z-index: 1000"><span class="fa fa-plus"></span> <span><?php echo $lang->addStresstestElement ?></span></button>
                </div>
            </div>
        </div>




        <div style="display: inline;">
            <h3 style="display:inline-block"><?php echo $lang->questionsAfterEveryGesture ?></h3>
            <!--            <div class="btn-group" id="useSingleStressQuestionsSwitch" style="margin-top: -9px; margin-left: 10px">
                            <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                            <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                        </div>-->
        </div>
        <!--        <div class="row">
                    <div class="col-md-11">-->
        <hr style="margin-top: 10px">
        <!--            </div>
                </div>-->
        <div class="row" id="singleStressQuestions">
            <div class="col-md-6 col-lg-7">
                <div class="alert-space alert-no-data-questionnaire"></div>
                <div class="form-group container-root" id="list-container"></div>
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="toggle-dynamic-affix">

                    <div class="add-button-group" id="add-question-button-group">
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->openQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->dichotomousQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestionOptions ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->rating ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->matrix ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->sumQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->ranking ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->counter ?>"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group root" id="useGraphicalSingleStressSwitch">
                        <label style="margin: 0">
                            <?php echo $lang->askWithInteractiveGraphic ?> 
                            <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->physicalStressTestSingleGraphic ?>"></i>
                        </label><br>

                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio" name="primary" id="body">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text"><?php echo $lang->body ?></span>
                            </button>
                        </div>
                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio" name="primary" id="hands">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text"><?php echo $lang->hands ?></span>
                            </button>
                        </div>
                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio" name="primary" id="bodyHands">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text"><?php echo $lang->bodyAndHands ?></span>
                            </button>
                        </div>
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
                    </div>

                    <button class="btn btn-default btn-shadow btn-preview-questionnaire" style="margin-top: 10px"><i class="fa fa-eye"></i> <?php echo $lang->previewHoleQuestionnaire ?></button>
                </div>

            </div>
        </div>




        <div style="display: inline;">
            <h3 style="display:inline-block"><?php echo $lang->questionsAfterGestureSequence ?></h3>
            <!--            <div class="btn-group" id="useSequenceStressQuestionsSwitch" style="margin-top: -9px; margin-left: 10px">
                            <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                            <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                        </div>-->
        </div>
        <!--        <div class="row">
                    <div class="col-md-11">-->
        <hr style="margin-top: 10px">
        <!--            </div>
                </div>-->
        <div class="row" id="sequenceStressQuestions">
            <div class="col-md-6 col-lg-7">
                <div class="alert-space alert-no-data-questionnaire"></div>
                <div class="form-group container-root" id="list-container"></div>
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="toggle-dynamic-affix">


                    <div class="add-button-group" id="add-question-button-group">
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->openQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->dichotomousQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestionOptions ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->rating ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->matrix ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->sumQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->ranking ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->counter ?>"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group root" id="useGraphicalSequenceStressSwitch">
                        <label style="margin: 0" >
                            <?php echo $lang->askWithInteractiveGraphic ?> 
                            <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->physicalStressTestSingleGraphic ?>"></i>
                        </label><br>

                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio" name="primary" id="body">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text"><?php echo $lang->body ?></span>
                            </button>
                        </div>
                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio" name="primary" id="hands">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text"><?php echo $lang->hands ?></span>
                            </button>
                        </div>
                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio" name="primary" id="bodyHands">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text"><?php echo $lang->bodyAndHands ?></span>
                            </button>
                        </div>
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
                    </div>

                    <button class="btn btn-default btn-shadow btn-preview-questionnaire" style="margin-top: 10px"><i class="fa fa-eye"></i> <?php echo $lang->previewHoleQuestionnaire ?></button>
                </div>

            </div>
        </div>




        <div style="display: inline;">
            <h3 style="display:inline-block"><?php echo $lang->observationForm ?></h3>
            <!--            <div class="btn-group" id="useObservationsSwitch" style="margin-top: -9px; margin-left: 10px">
                            <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                            <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                        </div>-->
        </div>
        <!--        <div class="row">
                    <div class="col-md-11">-->
        <hr style="margin-top: 10px">
        <!--            </div>
                </div>-->
        <div class="row" id="observations">
            <div class="col-md-7">
                <div class="alert-space alert-no-data-questionnaire"></div>
                <div class="form-group container-root" id="list-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <div id="dimension-controls">
                        <div class="dimension-container">
                            <h4 style="margin-top: 0"><?php echo $lang->aspects ?></h4>
                            <div class="dimension-btn-group">
                                <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                            </div>
                        </div>
                        <!--                        <div class="dimension-container" id="container-efficiency">
                                                    <h4 style=""><?php echo $lang->mainDimensions->efficiency ?></h4>
                                                    <div class="dimension-btn-group">
                                                        <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                                                    </div>
                                                </div>
                                                <div class="dimension-container" id="container-satisfaction">
                                                    <h4 style=""><?php echo $lang->mainDimensions->satisfaction ?></h4>
                                                    <div class="dimension-btn-group">
                                                        <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                                                    </div>
                                                </div>-->
                    </div>

                    <h4 style=""><?php echo $lang->userDefined ?></h4>
                    <div class="add-button-group" id="add-observation-button-group">
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->openQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->dichotomousQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestionOptions ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->rating ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->matrix ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->sumQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->ranking ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->counter ?>"></i>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-default btn-shadow btn-preview-questionnaire" style="margin-top: 10px"><i class="fa fa-eye"></i> <?php echo $lang->previewHoleQuestionnaire ?></button>
                </div>

            </div>
        </div>

        <br/>
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
    </div>







    <div id="identification">
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row" style="margin-bottom: 16px">
            <div class="col-md-7">

                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 class="overlay-title-editable" id="overlay-title"><span id="phase-step-title"></span> <i class="fa fa-pencil" id="btn-edit-phase-step-title"></i></h3>

                        <div class="input-group hidden" id="phase-step-title-input-container">
                            <input class="form-control item-input-text" id="phase-step-title-input" type="text" value="" maxlength="30"/>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-success btn-shadow" id="btn-save-phase-step-title" data-toggle="tooltip"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>

                    <!--<div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>-->
                </div>
            </div>
            <div class="col-md-5"></div>
        </div>

        <div class="row">
            <div class="col-md-7">

                <div id="general" style="">
                    <!--                    <div class="form-group">
                                            <label for="identificationTitle"><?php echo $lang->title ?></label>
                                            <input type="text" class="form-control" id="identificationTitle" placeholder="<?php echo $lang->insertTitle ?>">
                                        </div>-->
                    <div class="form-group">
                        <label for="identificationDescription"><?php echo $lang->description ?></label>
                        <textarea class="form-control" id="identificationDescription" rows="7" placeholder="<?php echo $lang->insertDescription ?>" style="resize: none"></textarea>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="text" style="margin-top: 24px"><?php echo $lang->tooltips->studyCreate->identificationOverlay ?></div>
            </div>
        </div>




        <h3 style="margin-top: 20px;"><?php echo $lang->elements ?></h3>
        <!--        <div class="row">
                    <div class="col-md-11">-->
        <hr style="margin-top: 10px">
        <!--            </div>
                </div>-->
        <div class="row" id="identificationElements" style="margin-bottom: 30px;">
            <div class="col-md-7">
                <div class="alert-space alert-no-study-gestures-assembled-link"></div>
                <div class="alert-space alert-no-trigger-assembled-link"></div>
                <div class="alert-space alert-no-scenes-assembled-link"></div>
                <div class="alert-space alert-no-phase-data"></div>

                <div class="option-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <div class="form-group root" id="identificationTypeSwitch">
                        <label style="margin: 0"  >
                            <?php echo $lang->whatShouldBeIdentified ?> 
                            <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->identificationFor ?>"></i>
                        </label><br>

                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio" name="primary" id="gestures">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text"><?php echo $lang->gestures ?></span>
                            </button>
                        </div>
                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio" name="primary" id="trigger">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text"><?php echo $lang->triggers ?></span>
                            </button>
                        </div>
                    </div>

                    <div class="form-group root hidden" id="useSensorSwitch">
                        <label style="margin: 0"  >
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

                    <button class="btn btn-info btn-shadow btn-add-identificationOption font-bold disabled" type="button"><span class="fa fa-plus" style="z-index: 1000"></span> <span><?php echo $lang->addIdentificationElement ?></span></button>
                </div>
            </div>
        </div>




        <div style="display: inline;">
            <h3 style="display:inline-block"><?php echo $lang->observationForm ?></h3>
            <!--            <div class="btn-group" id="useObservationsSwitch" style="margin-top: -9px; margin-left: 10px">
                            <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                            <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                        </div>-->
        </div>
        <!--        <div class="row">
                    <div class="col-md-11">-->
        <hr style="margin-top: 10px">
        <!--            </div>
                </div>-->
        <div class="row" id="observations">
            <div class="col-md-7">
                <div class="alert-space alert-no-data-questionnaire"></div>
                <div class="form-group container-root" id="list-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <div class="add-button-group" id="add-observation-button-group">
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->openQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->dichotomousQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestionOptions ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->rating ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->matrix ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->sumQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->ranking ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->counter ?>"></i>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-default btn-shadow btn-preview-questionnaire" style="margin-top: 10px"><i class="fa fa-eye"></i> <?php echo $lang->previewHoleQuestionnaire ?></button>
                </div>

            </div>
        </div>


        <br/>
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
    </div>


    <div id="exploration">
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row" style="margin-bottom: 16px">
            <div class="col-md-7">

                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 class="overlay-title-editable" id="overlay-title"><span id="phase-step-title"></span> <i class="fa fa-pencil" id="btn-edit-phase-step-title"></i></h3>

                        <div class="input-group hidden" id="phase-step-title-input-container">
                            <input class="form-control item-input-text" id="phase-step-title-input" type="text" value="" maxlength="30"/>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-success btn-shadow" id="btn-save-phase-step-title" data-toggle="tooltip"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>

                    <!--<div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>-->
                </div>
            </div>
            <div class="col-md-5"></div>
        </div>

        <div class="row">
            <div class="col-md-7">

                <div id="general" style="">
                    <div class="form-group">
                        <label for="explorationDescription"><?php echo $lang->description ?></label>
                        <textarea class="form-control" id="explorationDescription" rows="7" placeholder="<?php echo $lang->insertDescription ?>" style="resize: none"></textarea>
                    </div>

                </div>
            </div>

            <div class="col-md-5">
                <div style="margin-top: 24px"><?php echo $lang->tooltips->studyCreate->explorationOverlay ?></div>
            </div>
        </div>



        <h3 style="margin-top: 20px;"><?php echo $lang->elements ?></h3>
        <!--        <div class="row">
                    <div class="col-md-11">-->
        <hr style="margin-top: 10px">
        <!--            </div>
                </div>-->
        <div class="row" id="explorationElements" style="margin-bottom: 30px;">
            <div class="col-md-7">
                <div class="alert-space alert-no-study-gestures-assembled-link"></div>
                <div class="alert-space alert-no-trigger-assembled-link"></div>
                <div class="alert-space alert-no-phase-data"></div>

                <div class="option-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <div class="form-group root" id="explorationTypeSwitch">
                        <label style="margin: 0"  >
                            <?php echo $lang->whatShouldBeExtracted ?> 
                            <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->explorationFor ?>"></i>
                        </label><br>

                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio" name="primary" id="gestures">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text"><?php echo $lang->gestures ?></span>
                            </button>
                        </div>
                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio" name="primary" id="trigger">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text"><?php echo $lang->triggers ?></span>
                            </button>
                        </div>
                    </div>

                    <div class="form-group root hidden" id="askPreferredGestureSwitch">
                        <label style="margin: 0"  >
                            <?php echo $lang->queryPreferredGestureDirectly ?> 
                            <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->explorationQuestionnaireGestures ?>"></i>
                        </label><br>

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
                    </div>

                    <div class="form-group root hidden" id="askPreferredTriggerSwitch">
                        <label style="margin: 0"  >
                            <?php echo $lang->queryPreferredTriggerDirectly ?> 
                            <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->explorationQuestionnaireTrigger ?>"></i>
                        </label><br>

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
                    </div>

                    <button class="btn btn-info btn-shadow btn-add-explorationOption font-bold disabled" type="button"><span class="fa fa-plus" style="z-index: 1000"></span> <span><?php echo $lang->addExplorationElement ?></span></button>
                </div>
            </div>
        </div>




        <div style="display: inline;">
            <h3 style="display:inline-block"><?php echo $lang->observationForm ?></h3>

            <!--            <div class="form-group root" id="useObservationsSwitch">
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
                        </div>-->




            <!--
                        <div class="btn-group" id="useObservationsSwitch" style="margin-top: -9px; margin-left: 10px">
                            <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                            <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                        </div>-->
        </div>
        <!--        <div class="row">
                    <div class="col-md-11">-->
        <hr style="margin-top: 10px">
        <!--            </div>
                </div>-->
        <div class="row" id="observations">
            <div class="col-md-7">
                <div class="alert-space alert-no-data-questionnaire"></div>
                <div class="form-group container-root" id="list-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <div class="add-button-group" id="add-observation-button-group">
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->openQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->dichotomousQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestionOptions ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->rating ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->matrix ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->sumQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->ranking ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->counter ?>"></i>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-default btn-shadow btn-preview-questionnaire" style="margin-top: 10px"><i class="fa fa-eye"></i> <?php echo $lang->previewHoleQuestionnaire ?></button>
                </div>

            </div>
        </div>


        <br/>
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>

    </div>








    <div id="focusGroupInterview">
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row" style="margin-bottom: 16px">
            <div class="col-md-6">

                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 class="overlay-title-editable" id="overlay-title"><span id="phase-step-title"></span> <i class="fa fa-pencil" id="btn-edit-phase-step-title"></i></h3>

                        <div class="input-group hidden" id="phase-step-title-input-container">
                            <input class="form-control item-input-text" id="phase-step-title-input" type="text" value="" maxlength="30"/>
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-success btn-shadow" id="btn-save-phase-step-title" data-toggle="tooltip"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>

                    <!--<div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>-->
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>

        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-6">

                <div id="general" style="">
                    <div class="form-group">
                        <label for="focusGroupDescription"><?php echo $lang->description ?></label>
                        <textarea class="form-control" id="focusGroupDescription" rows="7" placeholder="<?php echo $lang->insertDescription ?>" style="resize: none"></textarea>
                    </div>

                    <!--                    <div class="alert-space alert-assembled-scene-removed"></div>
                    
                                        <div class="form-group" id="start-scene-select">
                                            <label><?php echo $lang->stateCharts->inputState ?> <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->scenarioStartScene ?>"></i></label>
                                            <div class="input-group"> 
                                                <input class="form-control item-input-text show-dropdown option-scene readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                                                <div class="input-group-btn select sceneSelect" role="group">
                                                    <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                                    <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                                                </div>
                                            </div>
                                        </div>-->
                </div>
            </div>

            <div class="col-md-6">
                <div style="margin-top: 25px"><?php echo $lang->tooltips->studyCreate->focusGroupInterviewOverlay ?></div>
            </div>
        </div>


        <div style="display: inline;">
            <h3 style="display:inline-block"><?php echo $lang->studyCreateNav->catalogs ?></h3>
        </div>

        <hr style="margin-top: 10px">

        <div class="row" id="catalogs-container" style="margin-bottom: 30px;">
            <div class="col-md-7">
                <div id="catalogs-study-gestures">
                    <h4 style="margin-top: 0px"><?php echo $lang->studyCatalogs->gestures ?></h4>
                    <div class="alert-space alert-no-study-gestures-assembled-link-warning"></div>
                    <div class="row option-container"></div>
                </div>

                <div id="catalogs-trigger" style="margin-top: 25px">
                    <h4 style="margin-top: 0px"><?php echo $lang->studyCatalogs->trigger ?></h4>
                    <div class="alert-space alert-no-trigger-assembled-link-warning"></div>
                    <div class="option-container"></div>
                </div>

                <div id="catalogs-scenes" style="margin-top: 40px">
                    <h4 style="margin-top: 0px"><?php echo $lang->studyCatalogs->scenes ?></h4>
                    <div class="alert-space alert-no-scenes-assembled-link-warning"></div>
                    <div class="option-container"></div>
                </div>

                <div id="catalogs-feedback" style="margin-top: 40px">
                    <h4 style="margin-top: 0px"><?php echo $lang->studyCatalogs->feedback ?></h4>
                    <div class="alert-space alert-no-feedback-assembled-link-warning"></div>
                    <div class="option-container"></div>
                </div>    
            </div>

            <div class="col-md-5">
                Infos dazu stehen hier
            </div>


        </div>

        <div style="display: inline;">
            <h3 style="display:inline-block"><?php echo $lang->annotations ?></h3>
        </div>

        <hr style="margin-top: 10px">

        <div class="row" id="annotations-container" style="margin-bottom: 30px;">
            <div class="col-md-7">
                <div class="alert-space alert-no-annotations"></div>
                <div class="option-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <button class="btn btn-info btn-shadow font-bold btn-add-annotationOption" type="button" style="z-index: 1000"><span class="fa fa-plus"></span> <span><?php echo $lang->addAnnotationElement ?></span></button>
                </div>
            </div>
        </div>

        <!--        <div style="display: inline;">
                    <h3 style="display:inline-block"><?php echo $lang->help ?></h3>
                    <div class="btn-group" id="useHelpSwitch" style="margin-top: -9px; margin-left: 10px">
                        <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                        <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                    </div>
                </div>
                
                <hr style="margin-top: 10px">
        
                <div class="row hidden" id="help" style="margin-bottom: 30px;">
                    <div class="col-md-7">
                        <div class="alert-space alert-no-phase-data"></div>
                        <div class="alert-space alert-no-scenes-assembled-link"></div>
                        <div class="alert-space alert-no-study-gestures-assembled-link"></div>
                        <div class="option-container"></div>
                    </div>
                    <div class="col-md-5">
                        <div class="toggle-dynamic-affix">
                            <button type="button" class="btn btn-info btn-shadow font-bold btn-add-helpOption" style="z-index: 1000"><span class="fa fa-plus"></span> <span><?php echo $lang->addHelp ?></span></button>
                        </div>
                    </div>
                </div>-->


        <div style="display: inline;">
            <h3 style="display:inline-block"><?php echo $lang->focusGroupForm ?></h3>
            <!--            <div class="btn-group" id="useObservationsSwitch" style="margin-top: -9px; margin-left: 10px">
                            <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                            <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                        </div>-->
        </div>

        <hr style="margin-top: 10px">

        <div class="row" id="key-questions">
            <div class="col-md-7">
                <div class="alert-space alert-no-data-questionnaire"></div>
                <div class="form-group container-root" id="list-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <!--                    <div id="dimension-controls">
                                            <div class="dimension-container">
                                                <h4 style="margin-top: 0"><?php echo $lang->aspects ?></h4>
                                                <div class="dimension-btn-group">
                                                    <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                                                </div>
                                            </div>
                    
                                        </div>-->

                    <!--<h4><?php echo $lang->userDefined ?></h4>-->
                    <div class="add-button-group" id="add-question-button-group">
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->openQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->dichotomousQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->groupingQuestionOptions ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->rating ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->matrix ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->sumQuestion ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->ranking ?>"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->counter ?>"></i>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-default btn-shadow btn-preview-questionnaire" style="margin-top: 10px"><i class="fa fa-eye"></i> <?php echo $lang->previewHoleQuestionnaire ?></button>
                </div>

            </div>
        </div>


        <br/>
        <div class="btn-group pull-right">
            <div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>
        </div>
    </div>







    <div id="catalog-gestures">
        <div class="btn-group pull-right">
            <!--<div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>-->
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row root">
            <div class="col-md-9">
                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 id="overlay-title" style="margin: 0; height:34px"></h3>
                    </div>

                    <!--<div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>-->
                </div>

                <ul class="nav nav-pills hidden-md hidden-lg gesture-catalogs-nav-tab" id="gesture-catalogs-nav-tab-small">
                    <li role="presentation" class="active" style="margin-right: 20px; margin-top: 10px"><a href="#study-gesture-set" role="tab" data-toggle="tab"><?php echo $lang->studyGestureSet ?> <span class="badge" id="study-gesture-set-badge"></span></a></li>
                    <li role="presentation" style="margin-top: 10px"><a href="#gesture-catalog" role="tab" data-toggle="tab"><i class="fa fa-sign-language" aria-hidden="true"></i> <?php echo $lang->allGestures ?> <span class="badge" id="gesture-catalog-badge"></span></a></li>
                    <li role="presentation" style="margin-top: 10px"><a href="#gesture-sets" role="tab" data-toggle="tab"><i class="fa fa-paperclip" aria-hidden="true"></i> <?php echo $lang->gestureSets ?> <span class="badge" id="gesture-sets-badge"></span></a></li>
                    <li role="presentation" style="margin-top: 10px"><a href="#gesture-recorder-content" role="tab" data-toggle="tab"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php echo $lang->recordGestures ?></a></li>
                    <li role="presentation" style="margin-top: 10px"><a href="#gesture-importer" role="tab" data-toggle="tab"><i class="fa fa-file-zip-o" aria-hidden="true"></i> <?php echo $lang->gestureImporter ?></a></li>
                </ul>

                <div class="tab-content" style="margin-top: 10px">

                    <div role="tabpanel" class="tab-pane active" id="tab-study-gesture-set">
                        <div class="tab-pane-loading-indicator text-center">
                            <i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw"></i>
                        </div>

                        <div id="item-view" class="hidden">
                            <div class="alert-space alert-no-study-gestures-assembled"></div>

                            <div id="filter-controls" class="hidden">
                                <div class="form-group form-group-no-margin">
                                    <div class="input-group">
                                        <span class="input-group-addon"><?php echo $lang->filter->name ?></span>
                                        <input class="form-control item-input-text text-center show-dropdown" tabindex="-1" type="text" value="<?php echo $lang->filter->all ?>"/>
                                        <div class="input-group-btn select filter" id="filter" role="group">
                                            <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="all"></span><span class="caret"></span></button>
                                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                <li id="all" class="selected"><a href="#"><?php echo $lang->filter->all ?></a></li>
                                                <li id="recorded"><a href="#"><?php echo $lang->filter->ownRecorded ?></a></li>
                                                <li id="tester"><a href="#"><?php echo $lang->filter->tester ?></a></li>
                                                <li id="public"><a href="#"><?php echo $lang->filter->shared ?></a></li>
                                                <li id="sharedWithYou"><a href="#"><?php echo $lang->filter->sharedWithYou ?></a></li>
                                                <li id="private"><a href="#"><?php echo $lang->filter->private ?></a></li>
                                            </ul>
                                        </div>
                                        <span class="input-group-addon"><?php echo $lang->sorting->name ?></span>
                                        <input class="form-control item-input-text text-center show-dropdown" tabindex="-1" type="text" value="<?php echo $lang->sorting->ASC ?>"/>
                                        <div class="input-group-btn select sort" id="sort" role="group">
                                            <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                <li class="dropdown-header"><?php echo $lang->sorting->dateHeadline ?></li>
                                                <li id="oldest"><a href="#"><?php echo $lang->sorting->DESC ?></a></li>
                                                <li id="newest"><a href="#"><?php echo $lang->sorting->ASC ?></a></li>
                                                <li class="divider"></li>
                                                <li class="dropdown-header"><?php echo $lang->sorting->gestureTitleHeadline ?></li>
                                                <li id="asc"><a href="#"><?php echo $lang->sorting->AToZ ?></a></li>
                                                <li id="desc"><a href="#"><?php echo $lang->sorting->ZToA ?></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-group-margin-top">
                                    <div class="input-group">
                                        <span class="input-group-addon"><?php echo $lang->search->name ?></span>
                                        <input class="form-control item-input-text search search-input" id="searched-input" autocomplete="off" type="search" value="" placeholder="<?php echo $lang->search->placeHolder ?>"/>
                                        <span class="input-group-addon"><?php echo $lang->filterItems->name ?></span>
                                        <input class="form-control item-input- text-center show-dropdown" tabindex="-1" type="text" value="16"/>
                                        <div class="input-group-btn select resultsCountSelect" id="resultsCountSelect" role="group">
                                            <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="results_16"></span><span class="caret"></span></button>
                                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                <li id="results_8"><a href="#">8</a></li>
                                                <li id="results_16" class="selected"><a href="#">16</a></li>
                                                <li id="results_40"><a href="#">40</a></li>
                                                <li id="results_100"><a href="#">100</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center custom-pagination" id="pager-top">
                                <nav>
                                    <ul class="pagination pagination-custom" data-clipping="7">
                                        <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                                        <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                        <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                        <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                                    </ul>
                                </nav>
                            </div>


                            <div class="container-root row root" id="gesture-list-container" style="margin-top: 10px;"></div>

                            <div class="alert-space alert-no-search-results"></div>

                            <div class="text-center custom-pagination" id="pager-bottom" style="margin: 0">
                                <nav>
                                    <ul class="pagination pagination-custom" data-clipping="7">
                                        <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                                        <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                        <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                        <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="tab-gesture-catalog">
                        <div class="tab-pane-loading-indicator text-center">
                            <i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw"></i>
                        </div>

                        <div id="item-view">
                            <div>
                                <div class="form-group form-group-no-margin">
                                    <div class="input-group">
                                        <span class="input-group-addon"><?php echo $lang->filter->name ?></span>
                                        <input class="form-control item-input-text text-center show-dropdown" tabindex="-1" type="text" value="<?php echo $lang->filter->all ?>"/>
                                        <div class="input-group-btn select filter" id="filter" role="group">
                                            <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="all"></span><span class="caret"></span></button>
                                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                <li id="all" class="selected"><a href="#"><?php echo $lang->filter->all ?></a></li>
                                                <li id="recorded"><a href="#"><?php echo $lang->filter->ownRecorded ?></a></li>
                                                <li id="tester"><a href="#"><?php echo $lang->filter->tester ?></a></li>
                                                <li id="public"><a href="#"><?php echo $lang->filter->shared ?></a></li>
                                                <li id="sharedWithYou"><a href="#"><?php echo $lang->filter->sharedWithYou ?></a></li>
                                                <li id="private"><a href="#"><?php echo $lang->filter->private ?></a></li>
                                                <li id="rated"><a href="#"><?php echo $lang->filter->rated ?></a></li>
                                                <li id="liked"><a href="#"><?php echo $lang->filter->liked ?></a></li>
                                                <li id="generic"><a href="#"><?php echo $lang->gestureNameQualities->generic->title ?></a></li>
                                                <li id="functional"><a href="#"><?php echo $lang->gestureNameQualities->functional->title ?></a></li>
                                            </ul>
                                        </div>
                                        <span class="input-group-addon"><?php echo $lang->sorting->name ?></span>
                                        <input class="form-control item-input-text text-center show-dropdown" tabindex="-1" type="text" value="<?php echo $lang->sorting->ASC ?>"/>
                                        <div class="input-group-btn select sort" id="sort" role="group">
                                            <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                <li class="dropdown-header"><?php echo $lang->sorting->dateHeadline ?></li>
                                                <li id="oldest"><a href="#"><?php echo $lang->sorting->DESC ?></a></li>
                                                <li id="newest"><a href="#"><?php echo $lang->sorting->ASC ?></a></li>
                                                <li class="divider"></li>
                                                <li class="dropdown-header"><?php echo $lang->sorting->gestureTitleHeadline ?></li>
                                                <li id="asc"><a href="#"><?php echo $lang->sorting->AToZ ?></a></li>
                                                <li id="desc"><a href="#"><?php echo $lang->sorting->ZToA ?></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-group-margin-top">
                                    <div class="input-group">
                                        <span class="input-group-addon"><?php echo $lang->search->name ?></span>
                                        <input class="form-control item-input-text search search-input" id="searched-input" autocomplete="off" type="search" value="" placeholder="<?php echo $lang->search->placeHolder ?>"/>
                                        <span class="input-group-addon"><?php echo $lang->filterItems->name ?></span>
                                        <input class="form-control item-input- text-center show-dropdown" tabindex="-1" type="text" value="16"/>
                                        <div class="input-group-btn select resultsCountSelect" id="resultsCountSelect" role="group">
                                            <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="results_16"></span><span class="caret"></span></button>
                                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                <li id="results_8"><a href="#">8</a></li>
                                                <li id="results_16" class="selected"><a href="#">16</a></li>
                                                <li id="results_40"><a href="#">40</a></li>
                                                <li id="results_100"><a href="#">100</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center custom-pagination" id="pager-top">
                                <nav>
                                    <ul class="pagination pagination-custom" data-clipping="7">
                                        <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                                        <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                        <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                        <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                                    </ul>
                                </nav>
                            </div>


                            <div class="container-root row root" id="gesture-list-container" style="margin-top: 10px;"></div>

                            <div class="alert-space alert-no-search-results"></div>

                            <div class="text-center custom-pagination" id="pager-bottom" style="margin: 0">
                                <nav>
                                    <ul class="pagination pagination-custom" data-clipping="7">
                                        <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                                        <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                        <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                        <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="tab-gesture-sets">
                        <div class="create-gesture-set-input">
                            <label class="text"><?php echo $lang->createNewGestureSet ?></label>

                            <div class="alert-space alert-gesture-set-title-too-short"></div>

                            <div class="input-group">
                                <input type="text" class="form-control" id="input-new-set-title" minlength="8" maxlength="60" placeholder="<?php echo $lang->createNewGestureSetPlaceholder ?>">
                                <span class="input-group-btn">
                                    <button class="btn btn-info btn-add-gesture-set" type="button" id="btn-add-gesture-set"><i class="fa fa-plus"></i></button>
                                </span>
                            </div>
                        </div>

                        <hr>

                        <div class="tab-pane-loading-indicator text-center">
                            <i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw"></i>
                        </div>

                        <div id="item-view">

                            <div>
                                <div class="form-group form-group-no-margin">
                                    <div class="input-group">
                                        <span class="input-group-addon"><?php echo $lang->filter->name ?></span>
                                        <input class="form-control item-input-text text-center show-dropdown" tabindex="-1" type="text" value="<?php echo $lang->filter->all ?>"/>
                                        <div class="input-group-btn select filter" id="filter" role="group">
                                            <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="all"></span><span class="caret"></span></button>
                                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                <li id="all" class="selected"><a href="#"><?php echo $lang->filter->all ?></a></li>
                                                <!--<li id="recorded"><a href="#"><?php echo $lang->filter->ownRecorded ?></a></li>-->
                                                <!--<li id="tester"><a href="#"><?php echo $lang->filter->tester ?></a></li>-->
                                                <li id="public"><a href="#"><?php echo $lang->filter->shared ?></a></li>
                                                <li id="sharedWithYou"><a href="#"><?php echo $lang->filter->sharedWithYou ?></a></li>
                                                <li id="private"><a href="#"><?php echo $lang->filter->private ?></a></li>
                                                    <!--<li id="rated"><a href="#"><?php echo $lang->filter->rated ?></a></li>-->
                                                <li id="liked"><a href="#"><?php echo $lang->filter->liked ?></a></li>
                                            </ul>
                                        </div>
                                        <span class="input-group-addon"><?php echo $lang->sorting->name ?></span>
                                        <input class="form-control item-input-text text-center show-dropdown" tabindex="-1" type="text" value="<?php echo $lang->sorting->ASC ?>"/>
                                        <div class="input-group-btn select sort" id="sort" role="group">
                                            <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                <li class="dropdown-header"><?php echo $lang->sorting->dateHeadline ?></li>
                                                <li id="oldest"><a href="#"><?php echo $lang->sorting->DESC ?></a></li>
                                                <li id="newest"><a href="#"><?php echo $lang->sorting->ASC ?></a></li>
                                                <li class="divider"></li>
                                                <li class="dropdown-header"><?php echo $lang->sorting->titleHeadline ?></li>
                                                <li id="asc"><a href="#"><?php echo $lang->sorting->AToZ ?></a></li>
                                                <li id="desc"><a href="#"><?php echo $lang->sorting->ZToA ?></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-group-margin-top">
                                    <div class="input-group">
                                        <span class="input-group-addon"><?php echo $lang->search->name ?></span>
                                        <input class="form-control item-input-text search search-input" id="searched-input" autocomplete="off" type="search" value="" placeholder="<?php echo $lang->search->placeHolder ?>"/>
                                        <span class="input-group-addon"><?php echo $lang->filterItems->name ?></span>
                                        <input class="form-control item-input-text text-center show-dropdown" tabindex="-1" type="text" value="4"/>
                                        <div class="input-group-btn select resultsCountSelect" id="resultsCountSelect" role="group">
                                            <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="results_4"></span><span class="caret"></span></button>
                                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                <li id="results_2"><a href="#">2</a></li>
                                                <li id="results_4" class="selected"><a href="#">4</a></li>
                                                <li id="results_10"><a href="#">10</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="text-center custom-pagination" id="pager-top">
                                <nav>
                                    <ul class="pagination pagination-custom" data-clipping="7">
                                        <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                                        <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                        <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                        <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                                    </ul>
                                </nav>
                            </div>

                            <div class="container-root root" id="gesture-sets-container" style="margin-top: 10px;"></div>

                            <div class="alert-space alert-no-search-results"></div>

                            <div class="text-center custom-pagination" id="pager-bottom" style="margin: 0">
                                <nav>
                                    <ul class="pagination pagination-custom" data-clipping="7">
                                        <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                                        <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                        <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                        <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="tab-gesture-recorder-content">
                        <!--<div class="row">-->
                        <!--                            <div class="col-sm-6">
                                                        <div id="recorder-description"></div>
                                                    </div>-->
                        <div class="" id="gesture-recorder-container">

                        </div>
                        <!--</div>-->
                    </div>

                    <div role="tabpanel" class="tab-pane" id="tab-gesture-importer"></div>
                </div>
            </div>

            <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
                <div class="" style="margin-top: 36px">
                    <ul class="nav nav-pills nav-stacked gesture-catalogs-nav-tab" id="gesture-catalogs-nav-tab">
                        <li role="presentation" class="active"><a href="#study-gesture-set" role="tab" data-toggle="tab"><?php echo $lang->studyGestureSet ?> <span class="badge" id="study-gesture-set-badge"></span></a></li>
                        <h4 style="margin-top: 20px"><?php echo $lang->chooseStudyGestureSet ?></h4>
                        <li role="presentation"><a href="#gesture-catalog" role="tab" data-toggle="tab"><i class="fa fa-sign-language" aria-hidden="true"></i> <?php echo $lang->allGestures ?> <span class="badge" id="gesture-catalog-badge"></span></a></li>
                        <li role="presentation"><a href="#gesture-sets" role="tab" data-toggle="tab"><i class="fa fa-paperclip" aria-hidden="true"></i> <?php echo $lang->gestureSets ?> <span class="badge" id="gesture-sets-badge"></span></a></li>
                        <li role="presentation"><a href="#gesture-recorder-content" role="tab" data-toggle="tab"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php echo $lang->recordGestures ?></a></li>
                        <li role="presentation"><a href="#gesture-importer" role="tab" data-toggle="tab"><i class="fa fa-file-zip-o" aria-hidden="true"></i> <?php echo $lang->gestureImporter ?></a></li>
                    </ul>
                </div>
            </div>

        </div>


        <br/>
        <div class="btn-group pull-right">
            <!--<div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>-->
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
        </div>

    </div>


    <div id="catalog-trigger">
        <div class="btn-group pull-right">
            <!--<div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>-->
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-7">
                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 id="overlay-title" style="margin: 0; height:34px"></h3>
                    </div>

                    <!--<div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>-->
                </div>

                <div style="margin-top: 20px">
                    <div class="alert-space alert-no-phase-data"></div>
                    <div class="container-root" id="list-container"></div>
                </div>
            </div>

            <div class="col-md-5">

                <div class="add-button-group toggle-affix" id="add-trigger-button-group" style="">
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item font-bold" id="triggerItem">
                            <i class="fa fa-plus"></i> <?php echo $lang->addTrigger ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        <br/>
        <div class="btn-group pull-right">
            <!--<div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>-->
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
        </div>
    </div>

    <div id="catalog-feedback">
        <div class="btn-group pull-right">
            <!--<div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>-->
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-7">
                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 id="overlay-title" style="margin: 0; height:34px"></h3>
                    </div>

                    <!--<div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>-->
                </div>

                <div style="margin-top: 20px">
                    <div class="alert-space alert-no-phase-data"></div>
                    <div class="container-root" id="list-container"></div>
                </div>
            </div>

            <div class="col-md-5">

                <div class="add-button-group toggle-affix" id="add-feedback-button-group" style="">
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item font-bold" id="text">
                            <i class="fa fa-plus"></i> <?php echo $lang->text ?> 
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->text ?>"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item font-bold" id="sound">
                            <i class="fa fa-plus"></i> <?php echo $lang->sound ?>
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->sound ?>"></i>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        <br/>
        <div class="btn-group pull-right">
            <!--<div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>-->
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
        </div>
    </div>

    <div id="catalog-scenes">
        <div class="btn-group pull-right">
            <!--<div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>-->
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-7">
                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 id="overlay-title" style="margin: 0; height:34px"></h3>
                    </div>

                    <!--<div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->acceptAndClose ?> <i class="fa fa-close"></i></div>-->
                </div>

                <div style="margin-top: 20px">
                    <div class="alert-space alert-no-phase-data"></div>
                    <div class="container-root" id="list-container"></div>
                </div>
            </div>

            <div class="col-md-5">

                <div class="add-button-group toggle-affix" id="add-scenes-button-group" style="">
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item font-bold" id="web">
                            <i class="fa fa-plus"></i> <?php echo $lang->sceneTypes->web ?> 
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->web ?>"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item font-bold" id="pidoco">
                            <i class="fa fa-plus"></i> <?php echo $lang->sceneTypes->pidoco ?> 
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->pidoco ?>"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item font-bold" id="image">
                            <i class="fa fa-plus"></i> <?php echo $lang->sceneTypes->image ?>
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->image ?>"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item font-bold" id="videoEmbed">
                            <i class="fa fa-plus"></i> <?php echo $lang->sceneTypes->videoEmbed ?>
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->videoEmbed ?>"></i>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        <br/>
        <div class="btn-group pull-right">
            <!--<div class="btn btn-default btn-shadow btn-cancel-overlay"><?php echo $lang->cancel ?></i></div>-->
            <div class="btn btn-default btn-shadow btn-close-overlay"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
        </div>
    </div>

</div>