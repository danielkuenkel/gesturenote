<?php
include '../includes/language.php';
?>

<div id="form-item-container" class="hidden">

    <div class="panel panel-default root" id="openQuestion">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span><?php echo $lang->questionFormats->openQuestion->text ?> <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">
            <div class="hidden" style="width: 100%; margin-bottom: 10px;" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <div class="label label-info" id="factor-primary"></div>
            </div>

            <div class="form-group form-group-no-margin">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->demandRequest ?></span>
                    <input class="form-control item-input-text question" type="text" value="" placeholder="<?php echo $lang->demandOrRequest ?>"/>
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow btn-show-hole-text" data-toggle="tooltip"><i class="glyphicon glyphicon-eye-open"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root not-used" id="openQuestionGUS">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete hidden"><span class="glyphicon glyphicon-trash"></span></button>
                <button class="btn btn-default btn-shadow btn-use not-used"><span class="glyphicon glyphicon-star"></span></button>
            </div>
            <span><?php echo $lang->questionFormats->openQuestion->text ?> <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">
            <div class="hidden" style="width: 100%; margin-bottom: 10px;" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <div class="label label-info" id="factor-primary"></div>
            </div>

            <div class="form-group form-group-no-margin">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->demandRequest ?></span>
                    <input class="form-control item-input-text question" type="text" value="" placeholder="<?php echo $lang->demandOrRequest ?>"/>
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow btn-show-hole-text" data-toggle="tooltip"><i class="glyphicon glyphicon-eye-open"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="dichotomousQuestion">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span><?php echo $lang->questionFormats->dichotomousQuestion->text ?> <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">

            <div class="hidden" style="width: 100%; margin-bottom: 10px;" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <div class="label label-info" id="factor-primary"></div>
            </div>

            <div class="form-group form-group-no-margin">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->question ?></span>
                    <input class="form-control item-input-text question" type="text" value="" placeholder="<?php echo $lang->questionFormats->dichotomousQuestion->text ?>"/>
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow btn-show-hole-text" data-toggle="tooltip"><i class="glyphicon glyphicon-eye-open"></i></button>
                    </div>
                </div>
            </div>

            <div class="alert-space alert-no-gestures-assembled"></div>

            <div class="form-group form-group-no-margin" style="margin-top: 10px">

                <div class="btn-group justification" style="margin-bottom: 10px; margin-right: 15px;">
                    <button class="btn btn-default switchButtonAddon"><?php echo $lang->justification ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                    <button class="btn btn-warning btn-shadow btn-toggle-checkbox active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                </div>

                <div class="btn-group justification-for" style="margin-bottom: 10px; margin-right: 15px;">
                    <button class="btn btn-default switchButtonAddon"><?php echo $lang->justificationFor ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                    <button class="btn btn-success btn-shadow btn-toggle-checkbox active" id="no" name="btn-success"><?php echo $lang->no ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="always" name="btn-success"><?php echo $lang->always ?></button>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root not-used" id="alternativeQuestion">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete hidden"><span class="glyphicon glyphicon-trash"></span></button>
                <button class="btn btn-default btn-shadow btn-use not-used"><span class="glyphicon glyphicon-star"></span></button>
            </div>
            <span><?php echo $lang->questionFormats->alternativeQuestion->text ?> <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">
            <div class="hidden" style="width: 100%; margin-bottom: 10px;" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <div class="label label-info" id="factor-primary"></div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->item ?></span>
                    <input class="form-control item-input-text question" type="text" value="" placeholder=""/>
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow btn-show-hole-text" data-toggle="tooltip"><i class="glyphicon glyphicon-eye-open"></i></button>
                    </div>
                </div>
            </div>

            <div class="alert-space alert-no-gestures-assembled"></div>
            <div class="alert-space alert-assembled-gesture-removed"></div>
            <div class="alert-space alert-no-trigger-assembled"></div>
            <div class="alert-space alert-assembled-trigger-removed"></div>
            <div class="alert-space alert-no-feedback-assembled"></div>
            <div class="alert-space alert-assembled-feedback-removed"></div>

            <div class="form-group form-group-no-margin">
                <div class="btn-group alternative" style="margin-right: 15px;margin-bottom: 10px;">
                    <button class="btn btn-default switchButtonAddon"><?php echo $lang->alternative ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox check no-gestures-assembled inactive" id="gestures" name="btn-success"><?php echo $lang->gestures ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox check no-trigger-assembled inactive" id="triggers" name="btn-success"><?php echo $lang->triggers ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox check no-feedback-assembled inactive" id="feedbacks" name="btn-success"><?php echo $lang->feedback ?></button>
                </div>
                <div class="btn-group alternativeFor" style="margin-right: 15px; margin-bottom: 10px;">
                    <button class="btn btn-default switchButtonAddon"><?php echo $lang->for ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox check no-gestures-assembled inactive" id="alternativeGesture" name="btn-success"><?php echo $lang->theGesture ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox check no-trigger-assembled inactive" id="alternativeTrigger" name="btn-success"><?php echo $lang->theTrigger ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox check no-feedback-assembled inactive" id="alternativeFeedback" name="btn-success"><?php echo $lang->theFeedback ?></button>
                </div>
                <div class="btn-group justification" style="margin-right: 15px; margin-bottom: 10px;">
                    <button class="btn btn-default switchButtonAddon"><?php echo $lang->justification ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                    <button class="btn btn-warning btn-shadow btn-toggle-checkbox active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                </div>
                <div class="btn-group justification-for" style="margin-right: 15px; margin-bottom: 10px;">
                    <button class="btn btn-default switchButtonAddon"><?php echo $lang->justificationFor ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="selectOne" name="btn-success">Auswahl einer Alternative</button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="selectNothing" name="btn-success">Keiner Auswahl</button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="always" name="btn-success">Immer</button>
                </div>
                <div class="btn-group optionalanswer" style="margin-right: 15px; margin-bottom: 10px;">
                    <button class="btn btn-default switchButtonAddon"><?php echo $lang->ownAnswerAllowed ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                    <button class="btn btn-warning btn-shadow btn-toggle-checkbox active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                </div>
            </div>

            <div class="form-group form-group-no-margin alternativeGestureSelect hidden">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->gesture ?></span>
                    <input class="form-control item-input-text option-gesture show-dropdown readonly" type="text" value=""/>
                    <div class="input-group-btn select gestureSelect" role="group">
                        <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                        </ul>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-no-margin alternativeTriggerSelect hidden">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->trigger ?></span>
                    <input class="form-control item-input-text option-trigger show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                    <div class="input-group-btn select triggerSelect" role="group">
                        <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-no-margin alternativeFeedbackSelect hidden">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->feedback ?></span>
                    <input class="form-control item-input-text option-feedback show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                    <div class="input-group-btn select feedbackSelect" role="group">
                        <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="panel panel-default root" id="counter">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span><?php echo $lang->questionFormats->counter->text ?> <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">
            <div class="form-group form-group-no-margin">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->demandRequest ?></span>
                    <input class="form-control item-input-text question" type="text" value="" placeholder="<?php echo $lang->demandOrRequest ?>"/>
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow btn-show-hole-text" data-toggle="tooltip"><i class="glyphicon glyphicon-eye-open"></i></button>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-margin-top">
                <div class="input-group simple-stepper" id="counter-from" style="max-width: 260px; float: left; margin-bottom: 10px; margin-right: 10px;">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default btn-addon">
                            <span>Zähler von</span>
                        </button>
                        <button type="button" class="btn btn-default btn-shadow btn-stepper-decrease" value="0">
                            <span class="glyphicon glyphicon-minus"></span><span class="sr-only"><?php echo $lang->less ?></span>
                        </button>
                    </div>
                    <input type="text" class="form-control readonly text-center stepper-text" value="0">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default btn-shadow btn-stepper-increase" value="1000">
                            <span class="glyphicon glyphicon-plus"></span><span class="sr-only"><?php echo $lang->more ?></span>
                        </button>
                    </div>
                </div>
                <div class="input-group simple-stepper" id="counter-to" style="max-width: 260px;  float: left;">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default btn-addon">
                            <span>Zähler bis</span>
                        </button>
                        <button type="button" class="btn btn-default btn-shadow btn-stepper-decrease" value="0">
                            <span class="glyphicon glyphicon-minus"></span><span class="sr-only"><?php echo $lang->less ?></span>
                        </button>
                    </div>
                    <input type="text" class="form-control readonly text-center stepper-text" value="0">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default btn-shadow btn-stepper-increase" value="1000">
                            <span class="glyphicon glyphicon-plus"></span><span class="sr-only"><?php echo $lang->more ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="groupingQuestion">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span><?php echo $lang->questionFormats->groupingQuestion->text ?> <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">
            <div class="hidden" style="width: 100%; margin-bottom: 10px;" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <div class="label label-info" id="factor-primary"></div>
            </div>

            <div class="form-group form-group-no-margin">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->demandRequest ?></span>
                    <input class="form-control item-input-text question" type="text" value="" placeholder="<?php echo $lang->demandOrRequest ?>"/>
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow btn-show-hole-text" data-toggle="tooltip"><i class="glyphicon glyphicon-eye-open"></i></button>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-margin-top" style="margin-top: 10px;">
                <div class="btn-group multiselect" style="margin-bottom: 10px; margin-right: 10px;">
                    <button class="btn btn-default switchButtonAddon"><?php echo $lang->multipleAnswersAllowed ?></button>
                    <button class="btn btn-default btn-toggle-checkbox inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                    <button class="btn btn-warning btn-toggle-checkbox active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                </div>

                <div class="btn-group optionalanswer" style="margin-bottom: 10px;">
                    <button class="btn btn-default switchButtonAddon"><?php echo $lang->ownAnswerAllowed ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                    <button class="btn btn-warning btn-shadow btn-toggle-checkbox active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                </div>
            </div>

            <hr style="margin-top: 10px">



            <div class="panel panel-default">
                <div class="panel-body option-container">
                    Eingruppierungs-Optionen
                </div>
            </div>

            <button type="button" class="btn btn-info btn-shadow pull-right btn-add-groupingQuestionOption"><span class="glyphicon glyphicon-plus"></span> Neue Auswahloption hinzufügen</button>
        </div>
    </div>

    <div class="form-group form-group-margin-top root"  id="groupingQuestionItem">
        <div class="input-group">
            <div class="input-group-btn">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <input class="form-control item-input-text option" type="text" value="" placeholder="Auswahloption"/>
        </div>
    </div>

    <div class="panel panel-default root not-used" id="groupingQuestionGUS">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete hidden"><span class="glyphicon glyphicon-trash"></span></button>
                <button class="btn btn-default btn-shadow btn-use not-used"><span class="glyphicon glyphicon-star"></span></button>
            </div>
            <span><?php echo $lang->questionFormats->groupingQuestion->text ?> <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">

            <div class="hidden" style="width: 100%; margin-bottom: 10px;" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <div class="label label-info" id="factor-primary"></div>
            </div>

            <div class="alert-space alert-no-gestures-assembled"></div>
            <div class="alert-space alert-assembled-gesture-removed"></div>
            <div class="alert-space alert-no-trigger-assembled"></div>
            <div class="alert-space alert-assembled-trigger-removed"></div>
            <div class="alert-space alert-no-feedback-assembled"></div>
            <div class="alert-space alert-assembled-feedback-removed"></div>

            <div class="form-group form-group-no-margin">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->item ?></span>
                    <input class="form-control item-input-text question readonly" type="text" value="" placeholder="<?php echo $lang->demandOrRequest ?>"/>
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow btn-show-hole-text" data-toggle="tooltip"><i class="glyphicon glyphicon-eye-open"></i></button>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-margin-top">
                <div class="btn-group optionselect" style="margin-right: 15px; margin-bottom: 10px;">
                    <button class="btn btn-default switchButtonAddon"><?php echo $lang->options ?></button>
                    <button class="btn btn-default btn-toggle-checkbox check no-gestures-assembled inactive" id="gestures" name="btn-success"><?php echo $lang->gestures ?></button>
                    <button class="btn btn-default btn-toggle-checkbox check no-trigger-assembled inactive" id="triggers" name="btn-success"><?php echo $lang->triggers ?></button>
                    <button class="btn btn-default btn-toggle-checkbox check no-feedback-assembled inactive" id="feedbacks" name="btn-success"><?php echo $lang->feedback ?></button>
                </div>

                <div class="btn-group multiselect" style="margin-right: 15px; margin-bottom: 10px;">
                    <button class="btn btn-default switchButtonAddon"><?php echo $lang->multipleOptionsAllowed ?></button>
                    <button class="btn btn-default btn-toggle-checkbox inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                    <button class="btn btn-warning btn-toggle-checkbox active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                </div>

                <div class="btn-group justification" style="margin-right: 15px; margin-bottom: 10px;">
                    <button class="btn btn-default switchButtonAddon"><?php echo $lang->justification ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                    <button class="btn btn-warning btn-shadow btn-toggle-checkbox active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                </div>

                <div class="btn-group justification-for" style="margin-right: 15px; margin-bottom: 10px;">
                    <button class="btn btn-default switchButtonAddon"><?php echo $lang->justificationFor ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="selectOne" name="btn-success">Auswahl einer Option</button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="selectNothing" name="btn-success">Keiner Auswahl</button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="always" name="btn-success"><?php echo $lang->always ?></button>
                </div>
            </div>

        </div>
    </div>

    <div class="panel panel-default root" id="rating">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span><?php echo $lang->questionFormats->rating->text ?> <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">
            <div class="hidden" style="width: 100%; margin-bottom: 10px;" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <div class="label label-info" id="factor-primary"></div>
            </div>

            <div class="form-group form-group-no-margin">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->demandRequest ?></span>
                    <input class="form-control item-input-text question" type="text" value="" placeholder="<?php echo $lang->demandOrRequest ?>"/>
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow btn-show-hole-text" data-toggle="tooltip"><i class="glyphicon glyphicon-eye-open"></i></button>
                    </div>
                </div>
            </div>

            <hr>

            <div class="panel panel-default">
                <div class="panel-body option-container">
                    Rating-Optionen
                </div>
            </div>

            <button type="button" class="btn btn-info btn-shadow pull-right btn-add-ratingOption"><span class="glyphicon glyphicon-plus"></span> Neue Ratingoption hinzufügen</button>
        </div>
    </div>



    <div class="form-group form-group-margin-top root"  id="ratingItem" style="margin-bottom: 20px;">
        <div class="input-group">
            <div class="input-group-btn">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>


            </div>
            <span class="input-group-addon"><?php echo $lang->option ?></span>
            <input class="form-control item-input-text optionQuestion" type="text" value="" placeholder="Option"/>
        </div>
        <div class="input-group" style="margin-top: 10px;">

            <div class="input-group-btn negative">
                <button class="btn btn-default switchButtonAddon"><?php echo $lang->negativeQuestionmark ?></button>
                <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="yes" name="btn-danger"><?php echo $lang->yes ?></button>
                <button class="btn btn-success btn-shadow btn-toggle-checkbox active" id="no" name="btn-success"><?php echo $lang->no ?></button>
            </div>

            <span class="input-group-addon"><?php echo $lang->scale ?></span>
            <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value=""/>

            <div class="input-group-btn select scaleSelect" role="group">
                <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen" id="unselected"></span><span class="caret"></span></button>
                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                    <li id="scale_3"><a href="#">3</a></li>
                    <li id="scale_4"><a href="#">4</a></li>
                    <li id="scale_5"><a href="#">5</a></li>
                    <li id="scale_6"><a href="#">6</a></li>
                    <li id="scale_7"><a href="#">7</a></li>
                </ul>
            </div>


        </div>

        <div class="ratingScaleItemContainer">
        </div>
    </div>

    <div class="form-group form-group-margin-top" id="ratingScaleItem">
        <div class="input-group">
            <span class="input-group-addon"></span>
            <input class="form-control item-input-text option" type="text" value="" placeholder=""/>
        </div>
    </div>

    <div class="panel panel-default root" id="sumQuestion">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span><?php echo $lang->questionFormats->sumQuestion->text ?> <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">
            <div class="hidden" style="width: 100%; margin-bottom: 10px;" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <div class="label label-info" id="factor-primary"></div>
            </div>

            <div class="form-group form-group-no-margin">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->demandRequest ?></span>
                    <input class="form-control item-input-text question" type="text" value="" placeholder="<?php echo $lang->demandOrRequest ?>"/>
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow btn-show-hole-text" data-toggle="tooltip"><i class="glyphicon glyphicon-eye-open"></i></button>
                    </div>
                </div>

                <!--<div class="container">-->
                <div class="row" style="margin-top: 10px">
                    <div class="form-group form-group-no-margin col-md-6" style="margin-bottom: 10px;">
                        <div class="input-group">
                            <span class="input-group-addon">Verteilung in</span>
                            <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="Prozent"/>

                            <div class="input-group-btn select allocationSelect" role="group">
                                <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen" id="percent"></span><span class="caret"></span></button>
                                <!--<button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen allocation" id="percent">Prozent </span><span class="caret"></span></button>-->
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                    <li id="percent"><a href="#"><?php echo $lang->scaleTypes->percent ?> </a></li>
                                    <li id="points"><a href="#"><?php echo $lang->scaleTypes->points ?> </a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="form-group form-group-no-margin col-md-6" style="margin-bottom: 10px;">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $lang->maximum ?></span>
                            <input class="form-control item-input-text maximum" type="text" value="" placeholder="<?php echo $lang->forExample100 ?>"/>
                        </div> 
                    </div>

                </div>
                <!--</div>-->

            </div>

            <hr style="margin-top: 10px">



            <div class="panel panel-default">
                <div class="panel-body option-container">
                    Antworten der Summenfrage
                </div>
            </div>

            <button type="button" class="btn btn-info btn-shadow pull-right btn-add-sumQuestionOption"><span class="glyphicon glyphicon-plus"></span> Neue Antwort hinzufügen</button>
        </div>
    </div>

    <div class="form-group form-group-margin-top root" id="sumQuestionItem">
        <div class="input-group">
            <div class="input-group-btn">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span class="input-group-addon"><?php echo $lang->answer ?></span>
            <input class="form-control item-input-text option" type="text" value="" placeholder="Antwort"/>
        </div>
    </div>



    <div class="panel panel-default root" id="ranking">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span><?php echo $lang->questionFormats->ranking->text ?> <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">
            <div class="hidden" style="width: 100%; margin-bottom: 10px;" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <div class="label label-info" id="factor-primary"></div>
            </div>

            <div class="form-group form-group-no-margin">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->demandRequest ?></span>
                    <input class="form-control item-input-text question" type="text" value="" placeholder="<?php echo $lang->demandOrRequest ?>"/>
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow btn-show-hole-text" data-toggle="tooltip"><i class="glyphicon glyphicon-eye-open"></i></button>
                    </div>
                </div>
            </div>

            <hr>



            <div class="panel panel-default">
                <div class="panel-body option-container">
                    Ranking-Optionen
                </div>
            </div>

            <button type="button" class="btn btn-info btn-shadow pull-right btn-add-rankingOption"><span class="glyphicon glyphicon-plus"></span> Neue Rankingoption hinzufügen</button>
        </div>
    </div>

    <div class="form-group form-group-margin-top root"  id="rankingItem">
        <div class="input-group">
            <div class="input-group-btn">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span class="input-group-addon"><?php echo $lang->option ?></span>
            <input class="form-control item-input-text option" type="text" value="" placeholder="Rankingoption"/>
        </div>
    </div>

    <div class="root" id="help">
        <div class="option-container"></div>
        <button type="button" class="btn btn-info btn-shadow pull-right btn-add-helpOption"><span class="glyphicon glyphicon-plus"></span> <span>Hilfe hinzufügen</span></button>
    </div>

    <div class="panel panel-default root" id="helpItem">
        <div class="panel-body">

            <div class="alert-space alert-no-scenes-assembled"></div>
            <div class="alert-space alert-assembled-scene-removed"></div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                        <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                        <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
                    </div>
                    <span class="input-group-addon"><?php echo $lang->scene ?></span>
                    <input class="form-control item-input-text show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                    <div class="input-group-btn select sceneSelect no-none" role="group">
                        <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                    </div>
                </div>

                <!--<div class="form-group">-->
                <div class="input-group" style="margin-top: 10px;">
                    <span class="input-group-addon">Hilfetext</span>
                    <input class="form-control option-text" type="text" value="" placeholder=""/>
                </div>
                <!--</div>-->

                <div class="alert-space alert-no-gestures-assembled"></div>
                <div class="alert-space alert-assembled-gesture-removed"></div>

                <div class="col-md-6 evaluation" style="padding: 0; margin-top: 10px;">
                    <div class="btn-group" id="useGestureHelpSwitch">
                        <button class="btn btn-default switchButtonAddon">Geste bei Bedarf nochmals anzeigen?</button>
                        <button class="btn btn-default btn-shadow btn-toggle-checkbox check no-gestures-assembled inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                        <button class="btn btn-warning btn-shadow btn-toggle-checkbox reset no-gestures-assembled active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                    </div>
                </div>
                <div class="col-md-6 evaluation hidden" style="padding: 0px; margin-top: 10px;" id="gesture-help-select">
                    <div class="input-group">
                        <span class="input-group-addon"><?php echo $lang->gesture ?></span>
                        <input class="form-control ellipsis item-input-text option-gesture show-dropdown readonly" type="text" value=""/>
                        <div class="input-group-btn select gestureSelect" role="group">
                            <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <div class="root" id="wozExperiment">
        <div class="option-container"></div>
        <button class="btn btn-info btn-shadow pull-right btn-add-woz-experimentOption" type="button"><span class="glyphicon glyphicon-plus"></span> <span>WoZ-Element hinzufügen</span></button>
    </div>

    <div class="form-group root" id="wozExperimentItem">
        <div class="panel panel-default">
            <div class="panel-body">

                <div class="alert-space alert-assembled-gesture-removed"></div>
                <div class="alert-space alert-assembled-trigger-removed"></div>
                <div class="alert-space alert-assembled-feedback-removed"></div>
                <div class="alert-space alert-assembled-scene-removed"></div>

                <div class="input-group">
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                        <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                        <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
                    </div>
                    <span class="input-group-addon"><?php echo $lang->scene ?></span>
                    <input class="form-control item-input-text show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                    <div class="input-group-btn select sceneSelect no-none" id="woz-scene" role="group">
                        <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                    </div>

                </div>

                <div class="input-group trigger" style="margin-top: 10px;">
                    <span class="input-group-addon"><?php echo $lang->trigger ?></span>
                    <input class="form-control item-input-text option-trigger show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                    <div class="input-group-btn select triggerSelect wozTriggerSelect" role="group">
                        <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                    </div>
                </div>

                <div class="input-group evaluation" style="margin-top: 10px;">
                    <span class="input-group-addon"><?php echo $lang->gesture ?></span>
                    <input class="form-control item-input-text option-gesture show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                    <div class="input-group-btn select gestureSelect" role="group">
                        <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                    </div>
                </div>

                <div class="feedback-input" style="padding: 0; margin-top: 10px;">
                    <div class="input-group">
                        <span class="input-group-addon"><?php echo $lang->feedback ?></span>
                        <input class="form-control item-input-text option-feedback show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                        <div class="input-group-btn select feedbackSelect" role="group">
                            <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                            <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 scene-input" style="padding: 0; margin-top: 10px;">
                    <div class="input-group">
                        <span class="input-group-addon"><?php echo $lang->subsequentScene ?></span>
                        <input class="form-control item-input-text show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                        <div class="input-group-btn select sceneSelect" id="transition-scene" role="group">
                            <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                            <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="root" id="trigger">
        <div class="option-container"></div>
        <div class="text-right">
            <button type="button" class="btn btn-info btn-shadow btn-add-triggerOption"><span class="glyphicon glyphicon-plus"></span> <span>Funktion hinzufügen</span></button>
        </div>
    </div>

    <div class="form-group root" id="triggerItem">
        <div class="input-group">
            <div class="input-group-btn">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span class="input-group-addon"><?php echo $lang->triggerName ?></span>
            <input class="form-control item-input-text option" type="text" value="" placeholder=""/>
        </div>
    </div>


    <div class="root" id="identification">
        <div class="alert-space alert-no-gestures-assembled"></div>
        <div class="alert-space alert-no-trigger-assembled"></div>
        <div class="alert-space alert-no-scenes-assembled"></div>

        <div class="option-container hidden"></div>

        <button class="btn btn-info btn-shadow pull-right hidden btn-add-identificationOption" type="button" style="margin-top: 10px"><span class="glyphicon glyphicon-plus"></span> <span>Identifikationselement hinzufügen</span></button>
    </div>

    <div class="panel panel-default root" id="identificationItem-gestures" style="margin-bottom: 15px">

        <div class="panel-body">
            <div class="alert-space alert-assembled-trigger-removed"></div>
            <div class="alert-space alert-assembled-scene-removed"></div>

            <div class="input-group">
                <div class="input-group-btn">
                    <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                    <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                    <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
                </div>
                <span class="input-group-addon"><?php echo $lang->trigger ?></span>
                <input class="form-control item-input-text option-trigger show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                <div class="input-group-btn select triggerSelect" role="group">
                    <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                    <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                </div>
            </div>

            <div class="input-group" style="margin-top: 10px">
                <span class="input-group-addon"><?php echo $lang->gestureContext ?></span>
                <input class="form-control" id="context-input" placeholder="Wo soll die Geste genutzt werden?" />
            </div>

            <div class="input-group" style="margin-top: 10px">
                <span class="input-group-addon"><?php echo $lang->scene ?></span>
                <input class="form-control item-input-text show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                <div class="input-group-btn select sceneSelect" id="transition-scene" role="group">
                    <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                    <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                </div>
            </div>
            
            <div class="input-group" style="margin-top: 10px">
                <span class="input-group-addon">Beschreibung</span>
                <!--<label class="sr-only" for="identificationDescription">Beschreibung</label>-->
                <textarea class="form-control" id="sceneDescription" rows="5" placeholder="Beschreibung einfügen"></textarea>
            </div>

        </div>

    </div>

    <div class="form-group root" id="identificationItem-trigger">

        <div class="alert-space alert-assembled-gesture-removed"></div>

        <div class="input-group">
            <div class="input-group-btn">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>

            <span class="input-group-addon"><?php echo $lang->gesture ?></span>
            <input class="form-control item-input-text option-gesture show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
            <div class="input-group-btn select gestureSelect" role="group">
                <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
            </div>
        </div>
    </div>


    <div class="root" id="gestureTraining">
        <div class="alert-space alert-no-gestures-assembled"></div>
        <div class="alert-space alert-no-trigger-assembled"></div>
        <div class="alert-space alert-no-feedback-assembled"></div>

        <div class="option-container"></div>

        <button class="btn btn-info btn-shadow pull-right btn-add-gestureTrainingOption" type="button"><span class="glyphicon glyphicon-plus"></span> <span>Trainingselement hinzufügen</span></button>
    </div>

    <div class="form-group root" id="gestureTrainingItem">
        <div class="panel panel-default">
            <div class="panel-body">

                <div class="alert-space alert-assembled-gesture-removed"></div>
                <div class="alert-space alert-assembled-trigger-removed"></div>
                <div class="alert-space alert-assembled-feedback-removed"></div>

                <div class="input-group">
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                        <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                        <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
                    </div>
                    <span class="input-group-addon"><?php echo $lang->trigger ?></span>
                    <input class="form-control item-input-text option-trigger show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                    <div class="input-group-btn select triggerSelect" role="group">
                        <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                    </div>
                </div>

                <div class="input-group evaluation" style="margin-top: 10px;">
                    <span class="input-group-addon"><?php echo $lang->gesture ?></span>
                    <input class="form-control item-input-text option-gesture show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                    <div class="input-group-btn select gestureSelect" role="group">
                        <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                    </div>
                </div>

                <div style="padding: 0; margin-top: 10px;">
                    <div class="input-group">
                        <span class="input-group-addon"><?php echo $lang->feedback ?></span>
                        <input class="form-control item-input-text option-feedback show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                        <div class="input-group-btn select feedbackSelect" role="group">
                            <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                            <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 10px">

                    <div class="col-md-6" id="repeats-stepper" style="margin-bottom: 10px">
                        <div class="input-group simple-stepper">
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-shadow btn-addon">Wiederholungen der Geste</button>
                                <button type="button" class="btn btn-default btn-shadow btn-stepper-decrease" value="1">
                                    <span class="glyphicon glyphicon-minus"></span><span class="sr-only"><?php echo $lang->oneLess ?></span>
                                </button>
                            </div>
                            <input type="text" class="form-control readonly text-center stepper-text" value="5">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default btn-shadow btn-stepper-increase" value="10">
                                    <span class="glyphicon glyphicon-plus"></span><span class="sr-only"><?php echo $lang->oneMore ?></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 hidden" id="recognition-stepper" style="margin-bottom: 10px">
                        <div class="input-group simple-stepper">
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-addon">Reaktionszeit (Sekunden)</button>
                                <button type="button" class="btn btn-default btn-shadow btn-stepper-decrease" value="1">
                                    <span class="glyphicon glyphicon-minus"></span><span class="sr-only"><?php echo $lang->oneSecondLess ?></span>
                                </button>
                            </div>
                            <input type="text" class="form-control readonly text-center stepper-text" value="3">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default btn-shadow btn-stepper-increase" value="10">
                                    <span class="glyphicon glyphicon-plus"></span><span class="sr-only"><?php echo $lang->oneSecondMore ?></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- gesture slideshow -->

    <div class="root" id="gesture-slideshow">
        <div class="alert-space alert-no-gestures-assembled"></div>
        <div class="alert-space alert-no-trigger-assembled"></div>

        <div class="option-container"></div>

        <button class="btn btn-info btn-shadow pull-right btn-add-slideshowOption" type="button"><span class="glyphicon glyphicon-plus"></span> <span>Slideshowelement hinzufügen</span></button>
    </div>


    <!-- trigger slideshow -->

    <div class="root" id="trigger-slideshow">
        <div class="alert-space alert-no-gestures-assembled"></div>
        <div class="alert-space alert-no-trigger-assembled"></div>

        <div class="option-container"></div>

        <button class="btn btn-info btn-shadow pull-right btn-add-slideshowOption" type="button"><span class="glyphicon glyphicon-plus"></span> <span>Slideshowelement hinzufügen</span></button>
    </div>


    <!-- slideshow gesture item -->

    <div class="form-group root" id="slideshow-gesture-item">
        <div class="panel panel-default">
            <div class="panel-body">

                <div class="alert-space alert-assembled-gesture-removed"></div>
                <div class="alert-space alert-assembled-trigger-removed"></div>

                <div class="input-group">
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                        <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                        <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
                    </div>
                    <span class="input-group-addon"><?php echo $lang->trigger ?></span>
                    <input class="form-control item-input-text option-trigger show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                    <div class="input-group-btn select triggerSelect" role="group">
                        <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                    </div>
                </div>

                <div class="input-group evaluation" style="margin-top: 10px;">
                    <span class="input-group-addon"><?php echo $lang->gesture ?></span>
                    <input class="form-control item-input-text option-gesture show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                    <div class="input-group-btn select gestureSelect" role="group">
                        <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                    </div>
                </div>

                <div class="form-group form-group-margin-top" id="recognition-stepper">
                    <div class="input-group simple-stepper">
                        <div class="input-group-btn">
                            <button class="btn btn-default btn-addon">Reaktionszeit (Sekunden)</button>
                            <button type="button" class="btn btn-default btn-shadow btn-stepper-decrease" value="1">
                                <span class="glyphicon glyphicon-minus"></span><span class="sr-only"><?php echo $lang->oneSecondLess ?></span>
                            </button>
                        </div>
                        <input type="text" class="form-control readonly text-center stepper-text" value="3">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default btn-shadow btn-stepper-increase" value="20">
                                <span class="glyphicon glyphicon-plus"></span><span class="sr-only"><?php echo $lang->oneSecondMore ?></span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- slideshow trigger item -->

    <div class="form-group root" id="slideshow-trigger-item">
        <div class="panel panel-default">
            <div class="panel-body">

                <div class="alert-space alert-assembled-gesture-removed"></div>
                <div class="alert-space alert-assembled-trigger-removed"></div>

                <div class="input-group">
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                        <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                        <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
                    </div>
                    <span class="input-group-addon"><?php echo $lang->trigger ?></span>
                    <input class="form-control item-input-text option-trigger show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                    <div class="input-group-btn select triggerSelect" role="group">
                        <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                    </div>
                </div>

                <div class="input-group evaluation" style="margin-top: 10px;">
                    <span class="input-group-addon"><?php echo $lang->gesture ?></span>
                    <input class="form-control item-input-text option-gesture show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                    <div class="input-group-btn select gestureSelect" role="group">
                        <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- physical stress test -->

    <div class="root" id="physicalStressTest">
        <div class="alert-space alert-no-gestures-assembled"></div>
        <div class="option-container"></div>
        <button class="btn btn-info btn-shadow pull-right" id="btn-add-physicalStressTestOption" type="button"><span class="glyphicon glyphicon-plus"></span> <span>Geste hinzufügen</span></button>
    </div>

    <div class="form-group root" id="physicalStressTestItem">

        <div class="alert-space alert-assembled-gesture-removed"></div>

        <div class="input-group">
            <div class="input-group-btn">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span class="input-group-addon"><?php echo $lang->gesture ?></span>
            <input class="form-control item-input-text option-gesture show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
            <div class="input-group-btn select gestureSelect" role="group">
                <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
            </div>
        </div>
    </div>


    <div class="panel panel-default root" id="pidoco">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span>Pidoco <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <div class="alert-space alert-no-title"></div>
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->title ?></span>
                    <input class="form-control item-input-text title" type="text" value="" placeholder="<?php echo $lang->title ?>"/>
                </div>
            </div>
            <div class="form-group">
                <div class="alert-space alert-pidoco-edit-url-invalid"></div>

                <div class="input-group">
                    <span class="input-group-addon">Bearbeitungs-URL</span>
                    <input class="form-control item-input-text pidoco-edit-url enter-key" type="text" value="" placeholder="Pidoco Bearbeitungs-URL"/>
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow checkInput checkPidocoEditURL"><i class="btn-icon glyphicon glyphicon-check"></i> <span class="btn-text">Überprüfen</span></button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="alert-space alert-pidoco-embed-url-invalid"></div>

                <div class="input-group">
                    <span class="input-group-addon">Simulations-URL</span>
                    <input class="form-control item-input-text pidoco-embed-url enter-key" type="text" value="" placeholder="Pidoco Simulations-URL"/>
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow checkInput checkPidocoEmbedURL"><i class="btn-icon glyphicon glyphicon-check"></i> <span class="btn-text">Überprüfen</span></button>
                    </div>
                </div>
            </div>

            <div class="alert-space alert-no-gestures-assembled"></div>

            <div class="form-group">
                <div class="btn-group transmit-gestures-select hidden" style="margin-right: 10px;">
                    <button class="btn btn-default switchButtonAddon">Gestenset an Pidoco koppeln?</button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox check no-gestures-assembled inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                    <button class="btn btn-warning btn-shadow btn-toggle-checkbox reset no-gestures-assembled active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                </div>
                <button class="btn btn-default btn-shadow hidden" id="transmitGestures"><i class="glyphicon glyphicon-share-alt"></i> <span>Gesten an Pidoco übertragen</span></button>
            </div>
        </div>
    </div>


    <div class="panel panel-default root" id="web">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span>Webseite <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">
            <div class="alert-space alert-no-title"></div>
            <div class="form-group form-group-no-margin">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->title ?></span>
                    <input class="form-control item-input-text title" type="text" value="" placeholder="<?php echo $lang->title ?>"/>
                </div>
            </div>
            <div class="form-group form-group-margin-top">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->url ?></span>
                    <input class="form-control item-input-text website-url" type="text" value="" placeholder="Webseiten-URL"/>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="image">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span>Bild <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">
            <div class="alert-space alert-no-title"></div>
            <div class="form-group form-group-no-margin">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->title ?></span>
                    <input class="form-control item-input-text title" type="text" value="" placeholder="<?php echo $lang->title ?>"/>
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow chooseSceneImage"><i class="btn-icon glyphicon glyphicon-picture"></i> <span class="btn-text">Bild auswählen</span></button>
                    </div>
                </div>

                <form enctype="multipart/form-data" id="upload-image-form" class="hidden">
                    <input class="imageUpload hidden" name="image" type="file" accept="image/jpeg, image/gif, image/png" />
                </form>

                <div class="imageArea hidden" style="margin-top: 10px; width: 100%; height: auto; position: relative;">
                    <button class="btn btn-danger btn-shadow btn-delete-image" style="position: absolute; margin: 10px; right: 0px;"><span class="glyphicon glyphicon-trash"></span> Bild löschen</button>
                    <img class="imageAreaContent" src="" alt="..." style="width: 100%; height: auto; border-radius: 4px;" />
                </div>
            </div>
        </div>
    </div>

    <!--    <div class="panel panel-default root" id="video">
            <div class="panel-heading">
                <div class="btn-group" style="margin-right: 10px">
                    <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                    <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                    <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
                </div>
                <span>Video <span class="badge badgeId">0</span> von <span class="badge badgeQuantity">0</span></span>
            </div>
            <div class="panel-body">
                <div class="alert-space alert-no-title"></div>
                <div class="form-group form-group-no-margin">
                    <div class="input-group">
                        <span class="input-group-addon">Titel</span>
                        <input class="form-control item-input-text title" type="text" value="" placeholder="Titel"/>
                        <div class="input-group-btn">
                            <button class="btn btn-default btn-shadow choosePrototypeVideo"><i class="btn-icon glyphicon glyphicon-picture"></i> <span class="btn-text">Video auswählen</span></button>
                        </div>
                    </div>
    
                    <input class="videoUpload hidden" name="" type="file" accept="video/mp4" />
                    <div class="videoArea hidden" style="margin-top: 10px; width: 100%; height: auto; position: relative;">
                        <video class="videoAreaContent" style="width: 100%; border-radius: 4px;" controls>
                        </video>
                    </div>
                </div>
            </div>
        </div>-->

    <div class="panel panel-default root" id="videoEmbed">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span>Videoeinbettung <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">
            <div class="alert-space alert-no-title"></div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->title ?></span>
                    <input class="form-control item-input-text title" type="text" value="" placeholder="<?php echo $lang->title ?>"/>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">Verhältnis</span>
                    <input class="form-control item-input-text option-ratio show-dropdown readonly" type="text" value="16:9" placeholder=""/>
                    <div class="input-group-btn select ratioSelect" role="group">
                        <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="ratio_16_9"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            <li id="ratio_16_9"><a href="#">16:9</a></li>
                            <li id="ratio_4_3"><a href="#">4:3</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="alert-space alert-video-embed-url-invalid"></div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->url ?></span>
                    <input class="form-control item-input-text video-embed-url enter-key" type="text" value="" placeholder="Videoeinbettungs-URL"/>
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow checkInput checkVideoEmbedURL"><i class="btn-icon glyphicon glyphicon-check"></i> <span class="btn-text">Überprüfen</span></button>
                    </div>
                </div>
            </div>

            <div class="videoContainer embed-responsive embed-responsive-16by9 hidden" style="margin-top: 10px; margin-bottom: 0px;"></div>
        </div>
    </div>

    <div class="panel panel-default root not-used" id="gusSingle">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete hidden"><span class="glyphicon glyphicon-trash"></span></button>
                <button class="btn btn-default btn-shadow btn-use not-used"><span class="glyphicon glyphicon-star"></span></button>
            </div>
            <span><?php echo $lang->questionFormats->rating->text ?> <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">
            <div>
                <div style="width: 100%" id="item-factors">
                    <div class="label label-primary" id="factor-main"></div>
                    <img src="img/factor-transition.jpg" style="margin-left: -3px; margin-right: -3px">
                    <div class="label label-info" id="factor-primary"></div>
                </div>

                <div class="input-group" style="margin-top: 5px;">
                    <span class="input-group-addon"><?php echo $lang->item ?></span>
                    <input class="form-control item-input-text question readonly" type="text" value=""/>

                    <div class="input-group-btn negative">
                        <button class="btn btn-default btn-shadow btn-show-hole-text" data-toggle="tooltip"><i class="glyphicon glyphicon-eye-open"></i></button>
                        <button class="btn btn-default switchButtonAddon"><?php echo $lang->negativeQuestionmark ?></button>
                        <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="yes" name="btn-danger"><?php echo $lang->yes ?></button>
                        <button class="btn btn-success btn-shadow btn-toggle-checkbox active" id="no" name="btn-success"><?php echo $lang->no ?></button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="panel panel-default root not-used" id="dichotomousQuestionGUS">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete hidden"><span class="glyphicon glyphicon-trash"></span></button>
                <button class="btn btn-default btn-shadow btn-use not-used"><span class="glyphicon glyphicon-star"></span></button>
            </div>
            <span><?php echo $lang->questionFormats->dichotomousQuestion->text ?> <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">

            <div style="width: 100%" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <div class="label label-info" id="factor-primary"></div>
            </div>

            <div class="input-group" style="margin-top: 5px;">
                <span class="input-group-addon"><?php echo $lang->item ?></span>
                <input class="form-control item-input-text question readonly" type="text" value=""/>

                <div class="input-group-btn">
                    <button class="btn btn-default btn-shadow btn-show-hole-text" data-toggle="tooltip"><i class="glyphicon glyphicon-eye-open"></i></button>
                    <!--                    <button class="btn btn-default switchButtonAddon">Negativ?</button>
                                        <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="yes" name="btn-danger">Ja</button>
                                        <button class="btn btn-success btn-shadow btn-toggle-checkbox active" id="no" name="btn-success">Nein</button>-->
                </div>
            </div>

            <div class="form-group form-group-margin-top">
                <div class="btn-group justification" style="margin-bottom: 10px; margin-right: 15px;">
                    <button class="btn btn-default switchButtonAddon"><?php echo $lang->justification ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                    <button class="btn btn-warning btn-shadow btn-toggle-checkbox active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                </div>

                <div class="btn-group justification-for" style="margin-bottom: 10px; margin-right: 15px;">
                    <button class="btn btn-default switchButtonAddon"><?php echo $lang->justificationFor ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="no" name="btn-success"><?php echo $lang->no ?></button>
                    <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="always" name="btn-success"><?php echo $lang->always ?></button>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group root" id="susItem">
        <div class="input-group">
            <span class="input-group-addon"><?php echo $lang->item ?></span>
            <input class="form-control item-input-text question readonly" type="text" value=""/>

            <div class="input-group-btn negative">
                <button class="btn btn-default btn-shadow btn-show-hole-text" data-toggle="tooltip"><i class="glyphicon glyphicon-eye-open"></i></button>
                <button class="btn btn-default switchButtonAddon"><?php echo $lang->negativeQuestionmark ?></button>
                <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="yes" name="btn-danger"><?php echo $lang->yes ?></button>
                <button class="btn btn-success btn-shadow btn-toggle-checkbox active" id="no" name="btn-success"><?php echo $lang->no ?></button>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="text">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span>Text <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">
            <div>
                <div class="input-group" style="margin-top: 5px;">

                    <span class="input-group-addon">Rückmeldungstext</span>
                    <input class="form-control item-input-text" type="text" value=""/>

                    <div class="input-group-btn negative">
                        <button class="btn btn-default switchButtonAddon"><?php echo $lang->negativeQuestionmark ?></button>
                        <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="yes" name="btn-danger"><?php echo $lang->yes ?></button>
                        <button class="btn btn-success btn-shadow btn-toggle-checkbox active" id="no" name="btn-success"><?php echo $lang->no ?></button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="sound">
        <div class="panel-heading">
            <div class="btn-group" style="margin-right: 10px">
                <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
            </div>
            <span>Sound <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
        </div>
        <div class="panel-body">
            <div class="alert-space alert-no-title"></div>
            <div class="form-group form-group-no-margin">
                <div class="input-group">

                    <span class="input-group-addon"><?php echo $lang->title ?></span>
                    <input class="form-control item-input-text title" type="text" value="" placeholder="<?php echo $lang->title ?>"/>
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-shadow chooseFeedbackSound"><i class="btn-icon fa fa-volume-up"></i> <span class="btn-text">Sounddatei auswählen</span></button>
                    </div>
                </div>

                <form enctype="multipart/form-data" id="upload-sound-form" method="post" class="hidden">
                    <input class="soundUpload hidden" name="sound" type="file" accept="audio/mp3" />
                </form>

                <div class="audioPlayer hidden" style="margin-top: 10px">
                    <div class="btn-group">
                        <button class="btn btn-default btn-shadow" id="play"><i class="glyphicon glyphicon-play"></i></button>
                        <button class="btn btn-default btn-shadow" id="pause"><i class="glyphicon glyphicon-pause"></i></button>
                        <button class="btn btn-default btn-shadow" id="stop"><i class="glyphicon glyphicon-stop"></i></button>
                        <button class="btn btn-danger btn-shadow btn-delete-sound"><i class="fa fa-trash"></i> Sound löschen</button>
                    </div>

                    <audio class="audio-holder" src="" preload="auto"></audio>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default gesture-thumbnail root" id="gesture-thumbnail">
        <div class="panel-heading" style=" text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">

            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-default btn-shadow gesture-assemble"><i class="glyphicon glyphicon-star"></i></button>
                <button type="button" class="btn btn-default btn-shadow gesture-details"><i class="glyphicon glyphicon-eye-open"></i></button>
            </div>
            <span class="title-text ellipsis" style="margin-left: 10px; position: relative; top: 2px;"></span>

            <div class="panel-title pull-right">
                <span class="label label-default" id="gesture-source" style="position: relative; top: -1px;"></span>
                <span class="label label-default" id="gesture-scope" style="position: relative; top: -1px;"></span>
            </div>
            <div class="clearfix"></div>

        </div>

        <div class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="previewGesture mouseScrollable btn-shadow autoplay"></div>
                        <div class="progress gesture-progress">
                            <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                        </div>
                        <div class="text-center gestureControls">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                                <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                                <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                                <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div id="title">Titel:<span class="address"></span> <span class="text"></span></div>
                        <div id="context">Kontext:<span class="address"></span> <span class="text"></span></div>
                        <div id="description">Beschreibung:<span class="address"></span> <span class="text"></span></div>

                        <div class="select-joints-humand-body" id="human-body" style="width: 400px; margin: auto; margin-top: 10px">
                            <div id="joint-container" style="position: absolute"></div>
                            <img src="img/human_body.svg">
                        </div>

                        <div style="margin-top: 15px;">
                            <button type="button" class="btn btn-success btn-shadow gesture-assemble-description btn-block"><i class="glyphicon glyphicon-star"></i> Zum Set hinzufügen</button>
                            <button type="button" class="btn btn-danger btn-shadow gesture-unassemble-description btn-block hidden"><i class="glyphicon glyphicon-star-empty"></i> Vom Set entfernen</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="panel panel-default gesture-thumbnail root" id="gesture-thumbnail-assembled">
        <div class="panel-heading" style=" text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">

            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-default btn-shadow gesture-reassemble"><i class="fa fa-times" aria-hidden="true"></i></button>
                <button type="button" class="btn btn-default btn-shadow gesture-details"><i class="glyphicon glyphicon-eye-open"></i></button>
            </div>
            <span class="title-text ellipsis" style="margin-left: 10px; position: relative; top: 2px;"></span>

            <div class="panel-title pull-right">
                <span class="label label-default" id="gesture-source" style="position: relative; top: -1px;"></span>
                <span class="label label-default" id="gesture-scope" style="position: relative; top: -1px;"></span>
            </div>
            <div class="clearfix"></div>

        </div>

        <div class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="previewGesture mouseScrollable btn-shadow autoplay"></div>
                        <div class="progress gesture-progress">
                            <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                        </div>
                        <div class="text-center gestureControls">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                                <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                                <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                                <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div id="title">Titel:<span class="address"></span> <span class="text"></span></div>
                        <div id="context">Kontext:<span class="address"></span> <span class="text"></span></div>
                        <div id="description">Beschreibung:<span class="address"></span> <span class="text"></span></div>

                        <div class="select-joints-humand-body" id="human-body" style="width: 400px; margin: auto; margin-top: 10px">
                            <div id="joint-container" style="position: absolute"></div>
                            <img src="img/human_body.svg">
                        </div>
                        <div style="margin-top: 15px;">
                            <button type="button" class="btn btn-danger btn-shadow gesture-reassemble btn-block"><i class="glyphicon glyphicon-star-empty"></i> Vom Set entfernen</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
