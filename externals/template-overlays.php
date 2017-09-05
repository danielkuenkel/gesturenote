<?php
include '../includes/language.php';
?>

<div id="overlays-item-container" class="hidden">

    <div id="letterOfAcceptance">
        <div class="btn-close-overlay hidden-xs hidden-sm pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>

        <div class="row">
            <div class="col-md-7">
                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3><span id="phase-step-title">Einverständniserklärung</span></h3>
                    </div>

                    <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
                </div>

                <textarea class="form-control" id="declaration" rows="10" placeholder="Erklärung einfügen"></textarea>
            </div>
            <div class="col-md-5">
                <div class="toggle-affix">
                </div>
            </div>
        </div>

        <div class="btn-close-overlay hidden-md hidden-lg pull-right" style="margin-top: 10px"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
    </div>

    <div id="thanks">
        <div class="btn-close-overlay hidden-xs hidden-sm pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>

        <div class="row">
            <div class="col-md-7">
                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3><span id="phase-step-title">Danksagung</span></h3>
                    </div>

                    <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
                </div>

                <textarea class="form-control" id="declaration" rows="10" placeholder="Danksagung einfügen"></textarea>
            </div>
            <div class="col-md-5">
                <div class="toggle-affix">
                </div>
            </div>
        </div>

        <div class="btn-close-overlay hidden-md hidden-lg pull-right" style="margin-top: 10px"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
    </div>


    <div id="questionnaire">
        <div class="btn-close-overlay hidden-xs hidden-sm pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>

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

                    <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
                </div>

                <div style="margin-top: 20px">
                    <div class="alert-space alert-no-data-questionnaire"></div>
                    <div class="container-root" id="list-container"></div>
                </div>
            </div>
            <div class="col-md-5">

                <div class="add-button-group toggle-affix" id="add-question-button-group" style="margin-top: 10px">
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                            <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                            <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                            <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                            <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                            <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                            <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                            <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                            <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                            <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <br/>
        <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
    </div>


    <div id="gus">
        <div class="btn-close-overlay hidden-xs hidden-sm pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>

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

                    <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
                </div>

                <div id="general" style="margin-top: 16px">
                    <div class="alert-space alert-assembled-gesture-removed"></div>
                    <div class="alert-space alert-assembled-trigger-removed"></div>

                    <div class="form-group" id="forGesture">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $lang->gesture ?></span>
                            <input class="form-control item-input-text option-gesture show-dropdown readonly" type="text" value=""/>
                            <div class="input-group-btn select gestureSelect" role="group">
                                <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                </ul>
                            </div>
                        </div>

                        <div class="input-group" id="gesture-trigger" style="margin-top: 10px">
                            <span class="input-group-addon"><?php echo $lang->trigger ?></span>
                            <input class="form-control item-input-text option-trigger show-dropdown readonly" type="text" value="" placeholder="Bitte wählen"/>
                            <div class="input-group-btn select triggerSelect" role="group">
                                <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                            </div>
                        </div>

                        <div class="input-group" id="gesture-feedback" style="margin-top: 10px">
                            <span class="input-group-addon"><?php echo $lang->feedback ?></span>
                            <input class="form-control item-input-text option-feedback show-dropdown readonly" type="text" value="" placeholder="Bitte wählen"/>
                            <div class="input-group-btn select feedbackSelect no-none" role="group">
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

                <div id="dimension-controls" class="toggle-affix">
                    <div class="dimension-container" id="container-effectiveness">
                        <h4 style=""><?php echo $lang->mainDimensions->effectiveness ?></h4>
                        <div class="dimension-btn-group">
                            <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                        </div>
                    </div>
                    <div class="dimension-container" id="container-efficiency">
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
                    </div>
                </div>

            </div>
        </div>

        <br/>
        <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
    </div>

    <div id="questionnaireGestures">
        <div class="btn-close-overlay hidden-xs hidden-sm pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>

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

                    <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
                </div>

                <div style="margin-top: 16px">
                    <div class="alert-space alert-no-data-gus-questionnaire"></div>
                    <div class="container-root" id="list-container"></div>
                </div>
            </div>
            <div class="col-md-5">

                <div id="dimension-controls" class="toggle-affix">
                    <div class="dimension-container" id="container-effectiveness">
                        <h4 style=""><?php echo $lang->mainDimensions->effectiveness ?></h4>
                        <div class="dimension-btn-group">
                            <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                        </div>
                    </div>
                    <div class="dimension-container" id="container-efficiency">
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
                    </div>
                </div>

            </div>
        </div>

        <br/>
        <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
    </div>

    <div id="sus">
        <div class="btn-close-overlay hidden-xs hidden-sm pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>

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

                    <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
                </div>

                <div style="margin-top: 16px">
                    <div class="alert-space alert-no-data-sus"></div>
                    <div class="container-root" id="list-container"></div>
                </div>
            </div>

            <div class="col-md-5">

            </div>

        </div>

        <br/>
        <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
    </div>











    <div id="gestureTraining">
        <div class="btn-close-overlay hidden-xs hidden-sm pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>

        <div class="row" style="margin-bottom: 30px;">
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

                    <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
                </div>

                <div id="general" style="margin-top: 16px">
                    <div class="form-group">
                        <label for="trainingTitle"><?php echo $lang->title ?></label>
                        <input type="text" class="form-control" id="trainingTitle" placeholder="Titel einfügen">
                    </div>
                    <div class="form-group">
                        <label for="trainingDescription">Trainingsbeschreibung</label>
                        <textarea class="form-control" id="trainingDescription" rows="7" placeholder="Trainingsbeschreibung einfügen" style="resize: none"></textarea>
                    </div>
                </div>

            </div>

            <div class="col-md-5"></div>
        </div>


        <h3 style="margin-top: 20px;">Trainingselemente</h3>
        <div class="row">
            <div class="col-md-11">
                <hr style="margin-top: 10px">
            </div>
        </div>
        <div class="row" id="training" style="margin-bottom: 30px;">
            <div class="col-md-7">
                <div id="trainingContainer">
                    <div class="alert-space alert-no-gestures-assembled"></div>
                    <div class="alert-space alert-no-trigger-assembled"></div>
                    <div class="alert-space alert-no-feedback-assembled"></div>
                    <div class="alert-space alert-no-phase-data"></div>

                    <div class="option-container"></div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <button class="btn btn-info btn-shadow font-bold btn-add-gestureTrainingOption" type="button" style="z-index: 3000"><span class="glyphicon glyphicon-plus"></span> <span>Trainingselement hinzufügen</span></button>
                </div>
            </div>
        </div>

        <div style="display: inline;">
            <h3 style="display:inline-block">Beobachtungsbogen</h3>
            <div class="btn-group" id="useObservationsSwitch" style="margin-top: -9px; margin-left: 10px">
                <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-11">
                <hr style="margin-top: 10px">
            </div>
        </div>

        <div class="row hidden" id="observations">
            <div class="col-md-7">
                <div class="alert-space alert-no-data-questionnaire"></div>
                <div class="form-group container-root" id="list-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <div id="dimension-controls">
                        <div class="dimension-container" id="container-effectiveness">
                            <h4 style=""><?php echo $lang->mainDimensions->effectiveness ?></h4>
                            <div class="dimension-btn-group">
                                <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                            </div>
                        </div>
                        <div class="dimension-container" id="container-efficiency">
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
                        </div>
                    </div>

                    <h4>Benutzerdefiniert</h4>
                    <div class="add-button-group" id="add-observation-button-group">
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!--        <div style="display: inline;">
                    <h3 style="display:inline-block">Beobachtungsbogen Test</h3>
                    <div class="btn-group" id="useObservationsSwitch" style="margin-top: -9px; margin-left: 10px">
                        <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                        <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-11">
                        <hr style="margin-top: 10px">
                    </div>
                </div>
                <div class="row" id="test">
                    <div class="col-md-7" style="height:700px">
                        <div class="alert-space alert-no-data-questionnaire"></div>
                        <div class="form-group container-root" id="list-container"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="toggle-dynamic-affix">
                            <div id="dimension-controls">
                                <div class="dimension-container" id="container-effectiveness">
                                    <h4 style="margin-top: 0px; color: #3379b7"><?php echo $lang->mainDimensions->effectiveness ?></h4>
                                    <div class="dimension-btn-group">
                                        <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                                    </div>
                                </div>
                                <div class="dimension-container" id="container-efficiency">
                                    <h4 style="color: #3379b7"><?php echo $lang->mainDimensions->efficiency ?></h4>
                                    <div class="dimension-btn-group">
                                        <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                                    </div>
                                </div>
                                <div class="dimension-container" id="container-satisfaction">
                                    <h4 style="color: #3379b7"><?php echo $lang->mainDimensions->satisfaction ?></h4>
                                    <div class="dimension-btn-group">
                                        <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                                    </div>
                                </div>
                            </div>
        
                        </div>
        
                    </div>
                </div>-->

        <br/>
        <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
    </div>

    <div id="scenario">
        <div class="btn-close-overlay hidden-xs hidden-sm pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>

        <div class="row" style="margin-bottom: 30px;">
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

                    <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
                </div>

                <div id="general" style="margin-top: 16px">
                    <div class="form-group">
                        <label for="scenarioTitle">Aufgabentitel</label>
                        <input type="text" class="form-control" id="scenarioTitle" placeholder="Aufgabentitel einfügen">
                    </div>
                    <div class="form-group">
                        <label for="scenarioDescription">Aufgabenbeschreibung</label>
                        <textarea class="form-control" id="scenarioDescription" rows="7" placeholder="Aufgabenbeschreibung einfügen" style="resize: none"></textarea>
                    </div>

                    <div class="alert-space alert-assembled-scene-removed"></div>

                    <div class="form-group" id="start-scene-select">
                        <label for="scenarioDescription">Start-Zustand</label>
                        <div class="input-group"> 
                            <input class="form-control item-input-text show-dropdown option-scene readonly" type="text" value="" placeholder="Bitte wählen"/>
                            <div class="input-group-btn select sceneSelect" role="group">
                                <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">



            </div>
        </div>


        <div style="display: inline;">
            <h3 style="display:inline-block">Wizard-of-Oz-Experiment</h3>
            <div class="btn-group" id="useWOZSwitch" style="margin-top: -9px; margin-left: 10px">
                <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-11">
                <hr style="margin-top: 10px">
            </div>
        </div>
        <div class="row hidden" id="wozExperiment" style="margin-bottom: 30px;">
            <div class="col-md-7">
                <div class="alert-space alert-no-scenes-assembled"></div>
                <div class="alert-space alert-no-gestures-assembled"></div>
                <div class="alert-space alert-no-trigger-assembled"></div>
                <div class="alert-space alert-no-feedback-assembled"></div>
                <div class="alert-space alert-no-phase-data"></div>

                <div class="option-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <button class="btn btn-info btn-shadow font-bold btn-add-woz-experimentOption" type="button" style="z-index: 1000"><span class="glyphicon glyphicon-plus"></span> <span>WoZ-Element hinzufügen</span></button>
                </div>
            </div>
        </div>


        <div style="display: inline;">
            <h3 style="display:inline-block">Hilfe</h3>
            <div class="btn-group" id="useHelpSwitch" style="margin-top: -9px; margin-left: 10px">
                <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-11">
                <hr style="margin-top: 10px">
            </div>
        </div>
        <div class="row hidden" id="help" style="margin-bottom: 30px;">
            <div class="col-md-7">
                <div class="alert-space alert-no-scenes-assembled"></div>
                <div class="alert-space alert-no-gestures-assembled"></div>
                <div class="alert-space alert-no-trigger-assembled"></div>
                <div class="alert-space alert-no-feedback-assembled"></div>
                <div class="alert-space alert-no-phase-data"></div>

                <div class="option-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <button type="button" class="btn btn-info btn-shadow font-bold btn-add-helpOption" style="z-index: 1000"><span class="glyphicon glyphicon-plus"></span> <span>Hilfe hinzufügen</span></button>
                </div>
            </div>
        </div>


        <div style="display: inline;">
            <h3 style="display:inline-block">Beobachtungsbogen</h3>
            <div class="btn-group" id="useObservationsSwitch" style="margin-top: -9px; margin-left: 10px">
                <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-11">
                <hr style="margin-top: 10px">
            </div>
        </div>
        <div class="row hidden" id="observations">
            <div class="col-md-7">
                <div class="alert-space alert-no-data-questionnaire"></div>
                <div class="form-group container-root" id="list-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <div id="dimension-controls">
                        <div class="dimension-container" id="container-effectiveness">
                            <h4 style=""><?php echo $lang->mainDimensions->effectiveness ?></h4>
                            <div class="dimension-btn-group">
                                <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                            </div>
                        </div>
                        <div class="dimension-container" id="container-efficiency">
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
                        </div>
                    </div>

                    <h4>Benutzerdefiniert</h4>
                    <div class="add-button-group" id="add-observation-button-group">
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <br/>
        <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
    </div>

    <div id="gestureSlideshow">
        <div class="btn-close-overlay hidden-xs hidden-sm pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>

        <div class="row" style="margin-bottom: 30px;">
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

                    <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
                </div>

                <div id="general" style="margin-top: 16px">
                    <div class="form-group">
                        <label for="slideshowTitle"><?php echo $lang->title ?></label>
                        <input type="text" class="form-control" id="slideshowTitle" placeholder="<?php echo $lang->insertTitle ?>">
                    </div>
                    <div class="form-group">
                        <label for="slideshowDescription"><?php echo $lang->description ?></label>
                        <textarea class="form-control" id="slideshowDescription" rows="7" placeholder="<?php echo $lang->insertDescription ?>" style="resize: none"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-5"></div>
        </div>


        <h3 style="margin-top: 20px;"><?php echo $lang->elements ?></h3>
        <div class="row">
            <div class="col-md-11">
                <hr style="margin-top: 10px">
            </div>
        </div>

        <div class="row" id="slideshow" style="margin-bottom: 30px;">
            <div class="col-md-7">
                <div class="alert-space alert-no-gestures-assembled"></div>
                <div class="alert-space alert-no-trigger-assembled"></div>
                <div class="alert-space alert-no-phase-data"></div>

                <div class="option-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <button class="btn btn-info btn-shadow font-bold btn-add-slideshowOption" type="button" style="z-index: 1000"><span class="glyphicon glyphicon-plus"></span> <span>Slideshowelement hinzufügen</span></button>
                </div>
            </div>
        </div>





        <div style="display: inline;">
            <h3 style="display:inline-block">Beobachtungsbogen</h3>
            <div class="btn-group" id="useObservationsSwitch" style="margin-top: -9px; margin-left: 10px">
                <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-11">
                <hr style="margin-top: 10px">
            </div>
        </div>
        <div class="row hidden" id="observations">
            <div class="col-md-7">
                <div class="alert-space alert-no-data-questionnaire"></div>
                <div class="form-group container-root" id="list-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <div id="dimension-controls">
                        <div class="dimension-container" id="container-effectiveness">
                            <h4 style=""><?php echo $lang->mainDimensions->effectiveness ?></h4>
                            <div class="dimension-btn-group">
                                <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                            </div>
                        </div>
                        <div class="dimension-container" id="container-efficiency">
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
                        </div>
                    </div>

                    <h4 style="margin-bottom: 0">Benutzerdefiniert</h4>
                    <div class="add-button-group" id="add-observation-button-group">
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <br/>
        <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
    </div>

    <div id="triggerSlideshow">
        <div class="btn-close-overlay hidden-xs hidden-sm pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>

        <div class="row" style="margin-bottom: 30px;">
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

                    <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
                </div>

                <div id="general" style="margin-top: 16px">
                    <div class="form-group">
                        <label for="slideshowTitle"><?php echo $lang->title ?></label>
                        <input type="text" class="form-control" id="slideshowTitle" placeholder="<?php echo $lang->insertTitle ?>">
                    </div>
                    <div class="form-group">
                        <label for="slideshowDescription"><?php echo $lang->description ?></label>
                        <textarea class="form-control" id="slideshowDescription" rows="7" placeholder="<?php echo $lang->insertDescription ?>" style="resize: none"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-5"></div>
        </div>




        <h3 style="margin-top: 20px;"><?php echo $lang->elements ?></h3>
        <div class="row">
            <div class="col-md-11">
                <hr style="margin-top: 10px">
            </div>
        </div>
        <div class="row" id="slideshow" style="margin-bottom: 30px;">
            <div class="col-md-7">
                <div class="alert-space alert-no-gestures-assembled"></div>
                <div class="alert-space alert-no-trigger-assembled"></div>
                <div class="alert-space alert-no-phase-data"></div>

                <div class="option-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <button class="btn btn-info btn-shadow font-bold btn-add-slideshowOption" type="button" style="z-index: 1000"><span class="glyphicon glyphicon-plus"></span> <span>Slideshowelement hinzufügen</span></button>
                </div>
            </div>
        </div>




        <div style="display: inline;">
            <h3 style="display:inline-block">Beobachtungsbogen</h3>
            <div class="btn-group" id="useObservationsSwitch" style="margin-top: -9px; margin-left: 10px">
                <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-11">
                <hr style="margin-top: 10px">
            </div>
        </div>
        <div class="row hidden" id="observations">
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
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <br/>
        <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
    </div>

    <div id="physicalStressTest">
        <div class="btn-close-overlay hidden-xs hidden-sm pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>

        <div class="row" style="margin-bottom: 30px;">
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

                    <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
                </div>

                <div id="general" style="margin-top: 16px">
                    <div class="form-group">
                        <label for="stressTestTitle"><?php echo $lang->title ?></label>
                        <input type="text" class="form-control" id="stressTestTitle" placeholder="<?php echo $lang->insertTitle ?>">
                    </div>
                    <div class="form-group">
                        <label for="stressTestDescription"><?php echo $lang->description ?></label>
                        <textarea class="form-control" id="stressTestDescription" rows="7" placeholder="<?php echo $lang->insertDescription ?>" style="resize: none"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Durchläufe pro Geste</label>
                        <div class="input-group simple-stepper">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default btn-shadow btn-stepper-decrease" value="2">
                                    <span class="glyphicon glyphicon-minus"></span><span class="sr-only">Einer weniger</span>
                                </button>
                            </div>
                            <input type="text" class="form-control readonly text-center stepper-text" id="totalStressAmount" value="10">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default btn-shadow btn-stepper-increase" value="300">
                                    <span class="glyphicon glyphicon-plus"></span><span class="sr-only">Einer mehr</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="col-md-5"></div>
        </div>




        <h3 style="margin-top: 20px;"><?php echo $lang->gestures ?></h3>
        <div class="row">
            <div class="col-md-11">
                <hr style="margin-top: 10px">
            </div>
        </div>
        <div class="row" id="stressTest" style="margin-bottom: 30px;">
            <div class="col-md-7">
                <div class="alert-space alert-no-gestures-assembled"></div>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="option-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <button class="btn btn-info btn-shadow font-bold btn-add-physicalStressTestOption" type="button" style="z-index: 1000"><span class="glyphicon glyphicon-plus"></span> <span>Geste hinzufügen</span></button>
                </div>
            </div>
        </div>




        <div style="display: inline;">
            <h3 style="display:inline-block">Fragen nach jeder Geste</h3>
            <div class="btn-group" id="useSingleStressQuestionsSwitch" style="margin-top: -9px; margin-left: 10px">
                <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-11">
                <hr style="margin-top: 10px">
            </div>
        </div>
        <div class="row hidden" id="singleStressQuestions">
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
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group root" id="useGraphicalSingleStressSwitch">
                        <label style="margin: 0">
                            Mit interaktiven Grafik über Anstrengung befragen 
                            <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text4 ?>"></i>
                        </label><br>

                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio" name="primary" id="body">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text">Körper</span>
                            </button>
                        </div>
                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio" name="primary" id="hands">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text">Hände</span>
                            </button>
                        </div>
                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio" name="primary" id="bodyHands">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text">Körper & Hände</span>
                            </button>
                        </div>
                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="none">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin hidden" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle" id="checked"></i>
                                </span>
                                <span class="option-text">Keine</span>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>




        <div style="display: inline;">
            <h3 style="display:inline-block">Fragen nach einer Gesten-Sequenz</h3>
            <div class="btn-group" id="useSequenceStressQuestionsSwitch" style="margin-top: -9px; margin-left: 10px">
                <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-11">
                <hr style="margin-top: 10px">
            </div>
        </div>
        <div class="row hidden" id="sequenceStressQuestions">
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
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group root" id="useGraphicalSequenceStressSwitch">
                        <label style="margin: 0" >
                            Mit interaktiven Grafik über Anstrengung befragen 
                            <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text4 ?>"></i>
                        </label><br>

                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio" name="primary" id="body">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text">Körper</span>
                            </button>
                        </div>
                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio" name="primary" id="hands">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text">Hände</span>
                            </button>
                        </div>
                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio" name="primary" id="bodyHands">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text">Körper & Hände</span>
                            </button>
                        </div>
                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="none">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin hidden" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle" id="checked"></i>
                                </span>
                                <span class="option-text">Keine</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>




        <div style="display: inline;">
            <h3 style="display:inline-block">Beobachtungsbogen</h3>
            <div class="btn-group" id="useObservationsSwitch" style="margin-top: -9px; margin-left: 10px">
                <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-11">
                <hr style="margin-top: 10px">
            </div>
        </div>
        <div class="row hidden" id="observations">
            <div class="col-md-7">
                <div class="alert-space alert-no-data-questionnaire"></div>
                <div class="form-group container-root" id="list-container"></div>
            </div>
            <div class="col-md-5">
                <div class="toggle-dynamic-affix">
                    <div id="dimension-controls">
                        <div class="dimension-container" id="container-effectiveness">
                            <h4 style=""><?php echo $lang->mainDimensions->effectiveness ?></h4>
                            <div class="dimension-btn-group">
                                <button type="button" class="btn btn-default btn-shadow btn-toggle" id="all"><?php echo $lang->all ?></button>
                            </div>
                        </div>
                        <div class="dimension-container" id="container-efficiency">
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
                        </div>
                    </div>

                    <h4 style="">Benutzerdefiniert</h4>
                    <div class="add-button-group" id="add-observation-button-group">
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>







    <div id="identification">
        <div class="btn-close-overlay hidden-xs hidden-sm pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>

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

                    <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
                </div>

                <div id="general" style="margin-top: 16px">
                    <div class="form-group">
                        <label for="identificationTitle"><?php echo $lang->title ?></label>
                        <input type="text" class="form-control" id="identificationTitle" placeholder="<?php echo $lang->insertTitle ?>">
                    </div>
                    <div class="form-group">
                        <label for="identificationDescription"><?php echo $lang->description ?></label>
                        <textarea class="form-control" id="identificationDescription" rows="7" placeholder="<?php echo $lang->insertDescription ?>" style="resize: none"></textarea>
                    </div>
                </div>
            </div>
        </div>




        <h3 style="margin-top: 20px;">Elemente</h3>
        <div class="row">
            <div class="col-md-11">
                <hr style="margin-top: 10px">
            </div>
        </div>
        <div class="row" id="identificationElements" style="margin-bottom: 30px;">
            <div class="col-md-8 col-lg-9">
                <div class="alert-space alert-no-gestures-assembled"></div>
                <div class="alert-space alert-no-trigger-assembled"></div>
                <div class="alert-space alert-no-scenes-assembled"></div>
                <div class="alert-space alert-no-phase-data"></div>

                <div class="option-container"></div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="toggle-dynamic-affix">
                    <div class="form-group root" id="identificationTypeSwitch">
                        <label style="margin: 0"  >
                            Was soll identifiziert werden? 
                            <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text4 ?>"></i>
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

                    <button class="btn btn-info btn-shadow btn-add-identificationOption font-bold disabled" type="button"><span class="glyphicon glyphicon-plus" style="z-index: 1000"></span> <span>Identifikationselement hinzufügen</span></button>
                </div>
            </div>
        </div>




        <div style="display: inline;">
            <h3 style="display:inline-block">Beobachtungsbogen</h3>
            <div class="btn-group" id="useObservationsSwitch" style="margin-top: -9px; margin-left: 10px">
                <button class="btn btn-warning btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                <button class="btn btn-default btn-sm btn-shadow btn-toggle-checkbox btn-toggle-checkbox-panel inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-11">
                <hr style="margin-top: 10px">
            </div>
        </div>
        <div class="row hidden" id="observations">
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
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <br/>
        <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
    </div>





    <div id="catalog-gestures">
        <div class="btn-close-overlay hidden-xs hidden-sm pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>

        <div class="row root">
            <div class="col-md-9">
                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 id="overlay-title" style="margin: 0; height:34px"></h3>
                    </div>

                    <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
                </div>

                <ul class="nav nav-pills hidden-md hidden-lg gesture-catalogs-nav-tab" id="gesture-catalogs-nav-tab-small">
                    <li role="presentation" class="active" style="margin-right: 20px; margin-top: 10px"><a href="#study-gesture-set" role="tab" data-toggle="tab">Studien-Gesten-Set <span class="badge" id="study-gesture-set-badge"></span></a></li>
                    <li role="presentation" style="margin-top: 10px"><a href="#gesture-catalog" role="tab" data-toggle="tab">Gesten-Katalog <span class="badge" id="gesture-catalog-badge"></span></a></li>
                    <li role="presentation" style="margin-top: 10px"><a href="#gesture-sets" role="tab" data-toggle="tab">Gesten-Sets <span class="badge" id="gesture-sets-badge"></span></a></li>
                    <li role="presentation" style="margin-top: 10px"><a href="#gesture-recorder-content" role="tab" data-toggle="tab">Gesten-Recorder</a></li>
                </ul>

                <div class="tab-content" style="margin-top: 10px">
                    <div role="tabpanel" class="tab-pane active" id="tab-study-gesture-set">
                        <div id="item-view">
                            <div>
                                <div class="form-group form-group-no-margin">
                                    <div class="input-group">
                                        <span class="input-group-addon">Filter</span>
                                        <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Alle"/>
                                        <div class="input-group-btn select filter" id="filter" role="group">
                                            <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="all"></span><span class="caret"></span></button>
                                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                <li id="all" class="selected"><a href="#">Alle</a></li>
                                                <li id="recorded"><a href="#">Eigene Aufgezeichnete</a></li>
                                                <li id="tester"><a href="#">Tester</a></li>
                                                <li id="public"><a href="#">Öffentlich</a></li>
                                            </ul>
                                        </div>
                                        <span class="input-group-addon">Sortierung</span>
                                        <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Neueste zuerst"/>
                                        <div class="input-group-btn select sort" id="sort" role="group">
                                            <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                <li class="dropdown-header">Datum</li>
                                                <li id="oldest"><a href="#">Älteste zuerst</a></li>
                                                <li id="newest"><a href="#">Neueste zuerst</a></li>
                                                <li class="divider"></li>
                                                <li class="dropdown-header">Gestentitel</li>
                                                <li id="asc"><a href="#">A bis Z</a></li>
                                                <li id="desc"><a href="#">Z bis A</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-group-margin-top">
                                    <div class="input-group">
                                        <span class="input-group-addon">Suchen</span>
                                        <input class="form-control item-input-text search search-input" id="searched-input" autocomplete="off" type="search" value="" placeholder="Suchbegriff eingeben"/>
                                        <span class="input-group-addon">Einträge pro Seite</span>
                                        <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="16"/>
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
                                    <ul class="pagination pagination-custom" itemprop="clipping_2">
                                        <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                                        <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                        <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                        <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                                    </ul>
                                </nav>
                            </div>


                            <div class="container-root row root" id="gesture-list-container" style="margin-top: 10px;"></div>

                            <div class="alert-space alert-no-search-results"></div>
                            <div class="alert-space alert-no-study-gestures-assembled"></div>

                            <div class="text-center custom-pagination" id="pager-bottom" style="margin: 0">
                                <nav>
                                    <ul class="pagination pagination-custom" itemprop="clipping_2">
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
                        <div id="item-view">
                            <div>
                                <div class="form-group form-group-no-margin">
                                    <div class="input-group">
                                        <span class="input-group-addon">Filter</span>
                                        <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Alle"/>
                                        <div class="input-group-btn select filter" id="filter" role="group">
                                            <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="all"></span><span class="caret"></span></button>
                                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                <li id="all" class="selected"><a href="#">Alle</a></li>
                                                <li id="recorded"><a href="#">Eigene Aufgezeichnete</a></li>
                                                <li id="tester"><a href="#">Tester</a></li>
                                                <li id="public"><a href="#">Öffentlich</a></li>
                                            </ul>
                                        </div>
                                        <span class="input-group-addon">Sortierung</span>
                                        <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Neueste zuerst"/>
                                        <div class="input-group-btn select sort" id="sort" role="group">
                                            <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                <li class="dropdown-header">Datum</li>
                                                <li id="oldest"><a href="#">Älteste zuerst</a></li>
                                                <li id="newest"><a href="#">Neueste zuerst</a></li>
                                                <li class="divider"></li>
                                                <li class="dropdown-header">Gestentitel</li>
                                                <li id="asc"><a href="#">A bis Z</a></li>
                                                <li id="desc"><a href="#">Z bis A</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-group-margin-top">
                                    <div class="input-group">
                                        <span class="input-group-addon">Suchen</span>
                                        <input class="form-control item-input-text search search-input" id="searched-input" autocomplete="off" type="search" value="" placeholder="Suchbegriff eingeben"/>
                                        <span class="input-group-addon">Einträge pro Seite</span>
                                        <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="16"/>
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
                                    <ul class="pagination pagination-custom" itemprop="clipping_7">
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
                                    <ul class="pagination pagination-custom" itemprop="clipping_7">
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
                            <label class="text">Neues Gesten-Set anlegen</label>

                            <div class="alert-space alert-gesture-set-title-too-short"></div>

                            <div class="input-group">
                                <input type="text" class="form-control" id="input-new-set-title" minlength="8" maxlength="60" placeholder="Name des Gesten-Sets (mindestens 8 Zeichen)">
                                <span class="input-group-btn">
                                    <button class="btn btn-info btn-add-gesture-set" type="button" id="btn-add-gesture-set"><i class="fa fa-plus"></i></button>
                                </span>
                            </div>
                        </div>

                        <hr>

                        <div id="item-view">

                            <div>
                                <div class="form-group form-group-no-margin">
                                    <div class="input-group">
                                        <span class="input-group-addon">Sortierung</span>
                                        <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Neueste zuerst"/>
                                        <div class="input-group-btn select sort" id="sort" role="group">
                                            <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                <li class="dropdown-header">Datum</li>
                                                <li id="oldest"><a href="#">Älteste zuerst</a></li>
                                                <li id="newest"><a href="#">Neueste zuerst</a></li>
                                                <li class="divider"></li>
                                                <li class="dropdown-header">Gestentitel</li>
                                                <li id="asc"><a href="#">A bis Z</a></li>
                                                <li id="desc"><a href="#">Z bis A</a></li>
                                            </ul>
                                        </div>
                                        <span class="input-group-addon">Einträge pro Seite</span>
                                        <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="4"/>
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
                                <div class="form-group form-group-margin-top">
                                    <div class="input-group">
                                        <span class="input-group-addon">Suchen</span>
                                        <input class="form-control item-input-text search search-input" id="searched-input" autocomplete="off" type="search" value="" placeholder="Suchbegriff eingeben"/>

                                    </div>
                                </div>
                            </div>

                            <div class="text-center custom-pagination" id="pager-top">
                                <nav>
                                    <ul class="pagination pagination-custom" itemprop="clipping_2">
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
                                    <ul class="pagination pagination-custom" itemprop="clipping_2">
                                        <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                                        <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                        <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                        <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="tab-gesture-recorder-content"></div>
                </div>
            </div>

            <div class="col-md-3 hidden-xs hidden-sm">
                <div class="toggle-affix">
                    <ul class="nav nav-pills nav-stacked gesture-catalogs-nav-tab" id="gesture-catalogs-nav-tab">
                        <li role="presentation" class="active"><a href="#study-gesture-set" role="tab" data-toggle="tab">Studien-Gesten-Set <span class="badge" id="study-gesture-set-badge"></span></a></li>
                        <h4 style="margin-top: 20px">Studien-Gesten wählen</h4>
                        <li role="presentation"><a href="#gesture-catalog" role="tab" data-toggle="tab">Gesten-Katalog <span class="badge" id="gesture-catalog-badge"></span></a></li>
                        <li role="presentation"><a href="#gesture-sets" role="tab" data-toggle="tab">Gesten-Sets <span class="badge" id="gesture-sets-badge"></span></a></li>
                        <li role="presentation"><a href="#gesture-recorder-content" role="tab" data-toggle="tab">Gesten-Recorder</a></li>
                    </ul>
                </div>
            </div>

        </div>


        <br/>
        <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
    </div>

<!--    <div id="gesture-info">
        <button type="button" class="btn btn-default" id="btn-back"><i class="fa fa-angle-left" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->previous ?></span></button>

        <div class="row" id="general-gesture-info" style="margin-top: 20px">
            <div class="col-md-5 root">
                <div class="previewGesture mouseScrollable btn-shadow autoplay"></div>
                <div class="progress gesture-progress">
                    <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                </div>
                <div class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
                <hr>
                <div class="gesture-rating" id="gesture-rating" style="margin-top: 20px;">
                    <h3><i class="fa fa-star-o"></i> Bewertung</h3>
                    <div class="rating-container rating-physicalContext row" id="rating-physicalContext">
                        <div class="col-xs-4 col-sm-3 col-md-5 rating-stars-container"></div>
                        <div class="col-xs-8 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text">Gestentyp für Kontext stimmig? (z.B. Ganzkörper-Geste für Arbeitsplatz stimmig?)</span></div>
                    </div>
                    <div class="rating-container rating-adaption row" id="rating-adaption">
                        <div class="col-xs-4 col-sm-3 col-md-5 rating-stars-container"></div>
                        <div class="col-xs-8 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text">Kontext-Adaption (Könnte die Geste auch woanders eingesetzt werden?)</span></div>
                    </div>
                    <div class="rating-container rating-fittingTask row" id="rating-fittingTask">
                        <div class="col-xs-4 col-sm-3 col-md-5 rating-stars-container"></div>
                        <div class="col-xs-8 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text">Passt die Geste zur beschriebenen Aufgabe?</span></div>
                    </div>
                    <div id="rating-infos">
                        <span id="rated-by"></span> <span id="rating-users-count"></span> <span id="rated-by-users"></span>
                        <div class="alert-space alert-rating-submitted" style="margin-top: 10px;"></div>
                    </div>
                    <button type="button" class="btn btn-block btn-warning" id="btn-rate-gesture" style="margin-top: 10px;">Geste bewerten</button>
                    <div class="btn-group-vertical btn-block hidden" id="rating-submit-buttons" style="margin-top: 0px;">
                        <button type="button" class="btn btn-success" id="btn-submit-gesture-rating">Bewertung abgeben</button>
                        <button type="button" class="btn btn-danger" id="btn-cancel-gesture-rating">Abbrechen</button>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <h3 style="margin-top: 0"><i class="fa fa-bookmark-o"></i> Allgemeines</h3>
                <div id="gesture-data-preview">
                    <div id="created"><span class="address">Erstellt:</span> <span class="text"></span></div>
                    <div id="title">Titel:<span class="address"></span> <span class="text"></span></div>
                    <div id="type">Gesten-Typ:<span class="address"></span> <span class="text"></span></div>
                    <div id="interactionType">Gesten-Interaktions-Typ:<span class="address"></span> <span class="text"></span></div>
                    <div id="context">Kontext:<span class="address"></span> <span class="text"></span></div>
                    <div id="association">Assoziation:<span class="address"></span> <span class="text"></span></div>
                    <div id="description">Beschreibung:<span class="address"></span> <span class="text"></span></div>

                    <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                    <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>

                    <div class="preview-joints-humand-body" id="human-body" style="width: 400px; margin: auto; margin-top: 10px">
                        <div id="joint-container" style="position: absolute"></div>
                        <img src="img/human_body.svg">
                    </div>
                </div>

                <div id="gesture-data-edit" class="hidden">
                    <div class="alert-space alert-missing-fields"></div>

                    <div class="form-group">
                        <label><?php echo $lang->gestureName ?></label>
                        <input type="text" class="form-control" id="gesture-name-input" required>
                    </div>

                    <div class="form-group" style="margin-top: 10px">
                        <label><?php echo $lang->gestureType ?></label>
                        <div class="input-group">
                            <input class="form-control item-input-text option-gesture-type show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                            <div class="input-group-btn select gestureTypeSelect" role="group" id="gestureTypeSelect">
                                <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                    <li id="0"><a href="#"><?php echo $lang->gestureTypes->pose ?></a></li>
                                    <li id="1"><a href="#"><?php echo $lang->gestureTypes->dynamic ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 10px">
                        <label><?php echo $lang->gestureInteractionType ?></label>
                        <div class="input-group">
                            <input class="form-control item-input-text option-gesture-interaction-type show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                            <div class="input-group-btn select gestureInteractionTypeSelect" role="group" id="gestureInteractionTypeSelect">
                                <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                    <li id="0"><a href="#"><?php echo $lang->gestureInteractionTypes->discrete ?></a></li>
                                    <li id="1"><a href="#"><?php echo $lang->gestureInteractionTypes->continuous ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->gestureContext ?></label>
                        <input type="text" class="form-control" placeholder="Wo soll die Geste eingesetzt werden?" id="gesture-context-input" required>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->gestureAssociation ?></label>
                        <textarea class="form-control" id="gesture-association-input" rows="3" maxlength="500" required></textarea>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->gestureDescription ?></label>
                        <textarea class="form-control" id="gesture-description-input" rows="3" maxlength="500" required></textarea>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->gestureGraphicsQuestion ?></label>
                        <div class="select-joints-humand-body" id="select-joints-human-body" style="width: 400px; margin: auto; margin-top: 10px">
                            <div id="joint-container" style="position: absolute"></div>
                            <img src="img/human_body.svg">
                        </div>
                    </div>
                </div>

                <div class="btn-group-vertical btn-block" style="margin-top: 20px" id="gesture-owner-controls">
                    <button type="button" class="btn btn-default gesture-previewable" id="btn-edit-gesture"><i class="fa fa-pencil" aria-hidden="true"></i> <span class="btn-text"></span></button>
                    <button type="button" class="btn btn-info" id="btn-share-gesture"><i class="fa" aria-hidden="true"></i> <span class="btn-text"></span></button>
                    <button type="button" class="btn btn-danger" id="btn-delete-gesture"><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-text">Geste löschen</span></button>
                </div>

            </div>
        </div>

        <hr style="">

        <div id="gesture-set-body">
            <div id="attached-gesture-sets" style="margin-top: 30px; margin-bottom: 30px">
                <h3><i class="fa fa-paperclip"></i> Zuweisung zu Gesten-Sets</h3>

                <div id="add-to-gesture-set">
                    <div class="create-gesture-set-input">
                        <label class="text">Neues Gesten-Set anlegen</label>

                        <div class="alert-space alert-gesture-set-title-too-short"></div>

                        <div class="input-group">
                            <input type="text" class="form-control" id="input-new-set-title" minlength="8" maxlength="60" placeholder="Name des Gesten-Sets (mindestens 8 Zeichen)">
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-add-gesture-set" type="button" id="btn-add-gesture-set"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                    </div>

                    <div class="row text-center" style="margin-top: 10px">
                        <label class="uppercase" style="font-size: 10pt"><?php echo $lang->or ?></label>
                    </div>

                    <div style="margin-top: 0px">
                        <label class="text">Zu vorhandenen Gesten-Sets zuweisen</label>

                        <div id="existing-sets-container">
                            <div class="option-container root"></div>
                        </div>
                        <div class="alert-space alert-no-gesture-sets-for-study"></div>
                    </div>

                </div>
            </div>
        </div>

        <hr style="">

        <div id="discussion-body" class="row">
            <div class="col-xs-12">
                <h3 style="margin-bottom: 20px"><i class="fa fa-comments-o" aria-hidden="true"></i> Mitreden</h3>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <textarea class="form-control" id="comment" rows="4" maxlength="500" placeholder="Kommentar einfügen" required></textarea>
                </div>
                <button type="button" class="btn btn-default btn-block" id="btn-comment-gesture"><i class="fa fa-commenting" aria-hidden="true"></i> <span class="btn-text">Kommentar abschicken</span></button>
            </div>
            <div class="col-md-7">
                <div class="alert-space alert-no-comments"></div>
                <div id="comments-list"></div>
            </div>
        </div>

    </div>-->

    <div id="catalog-trigger">
        <div class="btn-close-overlay hidden-xs hidden-sm pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>

        <div class="row">
            <div class="col-md-7">
                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 id="overlay-title" style="margin: 0; height:34px"></h3>
                    </div>

                    <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
                </div>

                <div style="margin-top: 20px">
                    <div class="alert-space alert-no-phase-data"></div>
                    <div class="container-root" id="list-container"></div>
                </div>
            </div>

            <div class="col-md-5">

                <div class="add-button-group toggle-affix" id="add-trigger-button-group" style="margin-top: 10px">
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item font-bold" id="triggerItem">
                            <i class="fa fa-plus"></i> Funktion hinzufügen
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        <br/>
        <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
    </div>

    <div id="catalog-feedback">
        <div class="btn-close-overlay hidden-xs hidden-sm pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>

        <div class="row">
            <div class="col-md-7">
                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 id="overlay-title" style="margin: 0; height:34px"></h3>
                    </div>

                    <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
                </div>

                <div style="margin-top: 20px">
                    <div class="alert-space alert-no-phase-data"></div>
                    <div class="container-root" id="list-container"></div>
                </div>
            </div>

            <div class="col-md-5">

                <div class="add-button-group toggle-affix" id="add-feedback-button-group" style="margin-top: 10px">
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item font-bold" id="text">
                            <i class="fa fa-plus"></i> <?php echo $lang->text ?> 
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item font-bold" id="sound">
                            <i class="fa fa-plus"></i> <?php echo $lang->sound ?>
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        <br/>
        <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
    </div>

    <div id="catalog-scenes">
        <div class="btn-close-overlay hidden-xs hidden-sm pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>

        <div class="row">
            <div class="col-md-7">
                <div class="overlay-header">
                    <div class="overlay-header-container">
                        <h3 id="overlay-title" style="margin: 0; height:34px"></h3>
                    </div>

                    <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
                </div>

                <div style="margin-top: 20px">
                    <div class="alert-space alert-no-phase-data"></div>
                    <div class="container-root" id="list-container"></div>
                </div>
            </div>

            <div class="col-md-5">

                <div class="add-button-group toggle-affix" id="add-scenes-button-group" style="margin-top: 10px">
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item font-bold" id="web">
                            <i class="fa fa-plus"></i> <?php echo $lang->sceneTypes->web ?> 
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item font-bold" id="image">
                            <i class="fa fa-plus"></i> <?php echo $lang->sceneTypes->image ?>
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item font-bold" id="videoEmbed">
                            <i class="fa fa-plus"></i> <?php echo $lang->sceneTypes->videoEmbed ?>
                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        <br/>
        <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
    </div>

</div>