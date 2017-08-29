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
                            <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                            <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                            <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                            <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                            <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                            <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                            <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                            <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                            <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                            <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                            <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                            <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                            <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                            <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                            <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                            <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                            <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
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
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
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
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
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
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
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
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
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
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group root" id="useGraphicalSingleStressSwitch">
                        <label style="margin: 0"  data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text4 ?>">
                            Mit interaktiven Grafik über Anstrengung befragen 
                            <i class="fa fa-info-circle text"></i>
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
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group root" id="useGraphicalSequenceStressSwitch">
                        <label style="margin: 0"  data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text4 ?>">
                            Mit interaktiven Grafik über Anstrengung befragen 
                            <i class="fa fa-info-circle text"></i>
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
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
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
                        <label style="margin: 0"  data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text4 ?>">
                            Was soll identifiziert werden? 
                            <i class="fa fa-info-circle text"></i>
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
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                            </div>
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
                            <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item font-bold" id="image">
                            <i class="fa fa-plus"></i> <?php echo $lang->sceneTypes->image ?>
                            <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="btn btn-info btn-add-item font-bold" id="videoEmbed">
                            <i class="fa fa-plus"></i> <?php echo $lang->sceneTypes->videoEmbed ?>
                            <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                        </div>
                    </div>
                </div>

                <!--                    <div class="add-button-group" id="add-observation-button-group">
                                        <div class="btn-group">
                                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="openQuestion">
                                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->openQuestion->text ?> 
                                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="dichotomousQuestion">
                                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->dichotomousQuestion->text ?> 
                                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestion">
                                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestion->text ?> 
                                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="groupingQuestionOptions">
                                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->groupingQuestionOptions->text ?> 
                                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="rating">
                                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->rating->text ?> 
                                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="matrix">
                                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->matrix->text ?> 
                                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sumQuestion">
                                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->sumQuestion->text ?> 
                                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ranking">
                                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->ranking->text ?> 
                                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <div class="btn btn-info btn-add-item btn-shadow font-bold" id="counter">
                                                <i class="fa fa-plus"></i> <?php echo $lang->questionFormats->counter->text ?> 
                                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
                                            </div>
                                        </div>
                                    </div>-->
            </div>

        </div>


        <br/>
        <div class="btn-close-overlay hidden-md hidden-lg pull-right"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>
    </div>

</div>