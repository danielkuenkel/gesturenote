<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

if (login_check($mysqli) == true) {
    if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'tester') {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $lang->gestureNoteStudy ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- third party sources -->
        <link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/greensock/TweenMax.min.js"></script>
        <script src="js/chart/Chart.bundle.min.js"></script>
        <script src="js/jszip/jszip.min.js"></script>
        <script src="js/jszip/jszip-utils.min.js"></script>

        <!-- gesturenote specific sources -->
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/study.css">
        <link rel="stylesheet" href="css/study-create.css">
        <link rel="stylesheet" href="css/gesture.css">

        <script src="js/filesaver/FileSaver.min.js"></script>
        <script src="js/refreshSession.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/gesture.js"></script>
        <script src="js/joint-selection.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/forms.js"></script>
        <script src="js/dimensions.js"></script>
        <script src="js/sha512.js"></script>
        <script src="js/chance.min.js"></script>
        <script src="js/study.js"></script>

        <!-- leap and plugins -->
        <script src="js/leapjs/leap-0.6.4.min.js"></script>
        <script src="js/leapjs/leap-plugins-0.1.12.min.js"></script>
        <script src="js/three/three.min.js"></script>
        <script src="js/riggedHand/leap.rigged-hand-0.1.7.js"></script>
        <script src="js/leapjs-playback/leap.playback-0.2.1.js"></script>

        <!--gesture recorder--> 
        <script src="js/gestureRecorder/gestureRecorder.js"></script>
        <script src="js/gestureRecorder/webcamRecorder.js"></script>
        <script src="js/gestureRecorder/leapRecorder.js"></script>
        <script src="js/resumable/resumable.js"></script>

        <!-- bootstrap slider -->
        <link rel="stylesheet" href="js/bootstrap-slider/css/bootstrap-slider.css">
        <script src="js/bootstrap-slider/js/bootstrap-slider.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-subpages"></div>
        <div id="template-gesture"></div>
        <div id="template-previews"></div>
        <div id="template-create"></div>
        <div id="template-general"></div>
        <div id="template-study"></div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content root">
                </div>
            </div>
        </div>


        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb" style="padding-top: 40px">
            <div class="row">
                <ol class="breadcrumb">
                    <!--<li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>-->
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-studies"><i class="fa fa-tasks" aria-hidden="true"></i> <?php echo $lang->breadcrump->studies ?></a></li>
                    <li class="active"><i class="fa fa-clipboard"></i> <?php echo $lang->breadcrump->study ?></li>
                </ol>
            </div>
        </div>

        <div class="container">
            <ul class="nav nav-tabs" role="tablist" id="tab-pane">
                <li role="presentation" id="general"><a href="#general-infos" aria-controls="general-infos" role="tab" data-toggle="tab"><?php echo $lang->studyCreateNav->general ?></a></li>
                <li role="presentation" id="catalogs"><a href="#study-catalogs" aria-controls="study-catalogs" role="tab" data-toggle="tab"><?php echo $lang->studyCreateNav->catalogs ?></a></li>
                <li role="presentation" id="phase-steps"><a href="#study-phase-steps" aria-controls="study-phase-steps" role="tab" data-toggle="tab"><?php echo $lang->studyCreateNav->phases ?></a></li>
                <li role="presentation" id="participants"><a href="#study-participants" aria-controls="study-participants" role="tab" data-toggle="tab"><?php echo $lang->participations ?> <span class="badge"></span></a></li>
                <li role="presentation" class="hidden" id="extraction"><a href="#gesture-extraction" aria-controls="gesture-extraction" role="tab" data-toggle="tab"><?php echo $lang->phaseType->extraction ?></a></li>
                <li role="presentation" id="tab-introduction" class="pull-right"><a role="button"><i class="fa fa-support"></i> <?php echo $lang->help ?></a></li>
            </ul>
        </div>


        <!-- Container (Panel Section) -->
        <div class="container mainContent tab-content" id="main-content" style="padding-bottom: 20px">


            <div role="tabpanel" class="tab-pane" id="general-infos">
                <h2 id="study-headline" style="margin-top: 0px; margin-bottom: 0px"></h2>
                <div class="label label-default" id="type-phase"></div>
                <div class="label label-default" id="type-survey"></div>
                <div class="label label-default hidden" id="panel-survey"><?php echo $lang->panelSurvey ?></div>

                <div class="" style="margin-top: 20px">
                    <div class="">
                        <div id="study-description">
                            <h3 class="address"><?php echo $lang->description ?></h3>
                            <p class="text"></p>
                        </div>
                        <div style="margin-top: 0px">
                            <div class="hidden study-no-plan"><i class="fa fa-calendar-times-o" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>
                            <div class="hidden study-plan"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>
                            <div class="hidden panel-survey"><i class="fa fa-users" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>
                        </div>

                    </div>
                </div>

                <div id="invited-users" style="margin-top: 60px">
                    <h3 class="address"><?php echo $lang->sharedStudies ?></h3>

                    <!--<div class="row">-->

                    <div class="">
                        <label>Eingeladene Interaktions-Designer</label>
                        <div class="alert-space alert-no-users-invited"></div>
                        <div id="shared-studies-list"></div>
                    </div>
                    <div class="" id="invite-users-form" style="margin-top: 20px">
                        <label class="text"><?php echo $lang->inviteUserViaMail ?></label>

                        <div class="alert-space alert-missing-email"></div>
                        <div class="alert-space alert-invalid-email"></div>
                        <div class="alert-space alert-user-already-invited"></div>
                        <div class="alert-space alert-invite-yourself"></div>

                        <div class="input-group">
                            <input type="text" class="form-control" id="input-email" minlength="8" maxlength="50" placeholder="<?php echo $lang->email ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="btn-invite-user"><i class="fa fa-paper-plane"></i> <span class="btn-text"><?php echo $lang->invite ?></span></button>
                            </span>
                        </div>
                    </div>
                    <!--</div>-->
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="study-catalogs">
                <div class="alert-space alert-no-phase-data"></div>

                <div id="study-gestures-catalog" class="study-catalog hidden">
                    <h3 class="address" style="margin-top: 0">
                        <?php echo $lang->studyCatalogs->gestures ?>
                        <div class="btn-group" style="margin-left: 10px">
                            <button class="btn btn-default btn-shadow disabled" id="btn-download-as-json" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsPidocoJSON ?>"><i class="fa fa-download"></i></button>
                            <button class="btn btn-default btn-shadow disabled" id="btn-download-as-exchangeable" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsExchangeable ?>"><i class="fa fa-file-archive-o"></i></button>
                        </div>
                    </h3>
                    <div class="list-container row" id="gestures-list-container"></div>
                </div>

                <div id="study-scenes-catalog" class="study-catalog hidden" style="margin-top: 50px;">
                    <h3 class="address" style="margin-top: 0"><?php echo $lang->studyCatalogs->scenes ?></h3>
                    <div class="list-container"></div>
                </div>


                <div id="study-trigger-catalog" class="study-catalog hidden" style="margin-top: 50px">
                    <h3 class="address" style="margin-top: 0"><?php echo $lang->studyCatalogs->trigger ?></h3>
                    <div class="list-container"></div>
                </div>

                <div id="study-feedback-catalog" class="study-catalog hidden" style="margin-top: 50px">
                    <h3 class="address" style="margin-top: 0"><?php echo $lang->studyCatalogs->feedback ?></h3>
                    <div class="list-container"></div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="study-phase-steps">
                <div id="study-phases">
                    <!--<h3 class="address"><?php echo $lang->phases ?></h3>-->
                    <div class="alert-space alert-no-phase-data"></div>
                    <div id="phase-steps-container" style="margin-top: 10px"></div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="study-participants">
                <!--<div class="" style="">-->
                <div class="" id="copy-to-clipboard">
                    <h3 class="address" style="margin-top: 0"><?php echo $lang->studyUrl ?></h3>
                    <p class="text"><?php echo $lang->studyURLDescription ?></p>
                    <div class="alert-space alert-plan-expired"></div>
                    <div class="alert-space alert-plan-not-started"></div>
                    <div class="alert-space alert-no-plan"></div>

                    <div class="input-group">
                        <!--<div class="input-group-addon"><?php echo $lang->studyUrl ?></div>-->
                        <input type="text" class="form-control readonly" id="static-study-url">
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-shadow" type="button" id="btn-open-static-study-url" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->staticStudyURLExecute ?>"><i class="fa fa-external-link" aria-hidden="true"></i> <span><?php echo $lang->openStudyUrl ?></span></button>
                        </span>
                    </div>
                </div>
                <!--</div>-->
                <!--<hr style="">-->

                <div style="margin-top: 50px"><h3><?php echo $lang->participations ?></h3></div>
                <div class="alert-space alert-no-participant-data"></div>

                <div class="row" id="statistic-participants">
                    <div class="col-xs-12 text-center">
                        <div style="border: 1px solid #eee; border-radius: 8px; padding: 15px">
                            <!--<div class="text text-center"><?php echo $lang->studyExecutionStatistic ?></div>-->
                            <canvas id="chart-participant-statistics" style="max-width:400px; margin: 0 auto"></canvas>
                            <div class="text text-center" style="font-size: 10pt">
                                <span id="amount-participants-success"></span>, <span id="amount-participants-aborted"></span>, <span id="amount-participants-total"></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="list-container row" style="margin-top: 20px"></div>
            </div>


            <div role="tabpanel" class="tab-pane" id="gesture-extraction">
                <div class="alert-space alert-no-phase-data"></div>

                <div id="gesture-extraction-content" class="row hidden">

                    <div class="col-sm-4 col-md-3" style="margin-bottom: 20px">
                        <div data-spy="affix" data-offset-top="0" id="gesture-extraction-navigation">
                            <h5 class="text"><?php echo $lang->extractionContent->classification ?></h5>
                            <div class="btn-group-vertical btn-block" id="btns-general">
                                <button class="btn btn-default btn-shadow" type="button" id="btn-all-gestures"><span class="btn-text"><?php echo $lang->extractionContent->allElicitedGestures ?></span></button>
                                <button class="btn btn-default btn-shadow" type="button" id="btn-gesture-classification"><span class="btn-text"><?php echo $lang->extractionContent->gestureClassification ?></span></button>
                                <button class="btn btn-default btn-shadow" type="button" id="btn-checklist"><span class="btn-text"><?php echo $lang->extractionContent->checklist ?></span></button>
                            </div>

                            <h5 class="text" style="margin-top: 20px"><?php echo $lang->extractionContent->analysis ?></h5>
                            <div class="btn-group-vertical btn-block" id="btns-arrange-gesture-sets">
                                <button class="btn btn-default btn-shadow disabled" type="button" id="btn-potential-gestures"><span class="btn-text"><?php echo $lang->extractionContent->potentialGestures ?></span></button>
                                <button class="btn btn-default btn-shadow disabled" type="button" id="btn-gesture-sets"><span class="btn-text"><?php echo $lang->gestureSets ?></span></button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-8 col-md-9" id="extraction-navigation-content" style="margin-top: 5px">
                        <div id="content-btn-all-gestures" class="hidden"></div>

                        <div id="content-btn-gesture-classification" class="hidden">
                            <h4 style="margin-top: 0px"><span class="text"><?php echo $lang->extractionContent->classifyGestures ?></span> 
                                <button type="button" class="btn btn-xs btn-default btn-shadow disabled" id="btn-reclassify-gestures" style="margin-left:5px"><i class="fa fa-refresh" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->extractionContent->reclassify ?></span></button>
                            </h4>
                            <div class="alert-space alert-no-more-gestures-for-classification" style="margin-top:20px"></div>

                            <div id="gesture-classification-parameters" class="hidden text-center" style="margin-top:20px">
                                <div class="form-group root text" id="classification-type">
                                    <label><?php echo $lang->extractionContent->classifyGestureQuestion ?></label><br>

                                    <div class="btn-group" id="radio">
                                        <button class="btn btn-default btn-radio" id="appearance" name="primary">
                                            <span id="icons" style="margin-right: 6px">
                                                <i class="fa fa-circle-thin" id="normal"></i>
                                                <i class="fa fa-circle hidden" id="over"></i>
                                                <i class="fa fa-check-circle hidden" id="checked"></i>
                                            </span>
                                            <span class="option-text"><?php echo $lang->classificationTypes->appearance ?></span>
                                        </button>
                                    </div>

                                    <br/>
                                    <div class="btn-group" id="radio">
                                        <button class="btn btn-default btn-radio btn-option-checked" id="appearanceTrigger" name="primary">
                                            <span id="icons" style="margin-right: 6px">
                                                <i class="fa fa-circle-thin hidden" id="normal"></i>
                                                <i class="fa fa-circle hidden" id="over"></i>
                                                <i class="fa fa-check-circle " id="checked"></i>
                                            </span>
                                            <span class="option-text"><?php echo $lang->classificationTypes->appearanceTrigger ?></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="btn-group-vertical">
                                    <!--<button type="button" class="btn btn-default btn-shadow" id="btn-help-classification"><i class="fa fa-question-circle"></i> <span class="btn-text">Mehr Infos zur Klassifizierung</span></button>-->
                                    <button type="button" class="btn btn-default btn-shadow" id="btn-start-classification"><i class="fa fa-archive"></i> <span class="btn-text"><?php echo $lang->extractionContent->startClassification ?></span></button>
                                </div>
                            </div>

                            <div id="gesture-classification" class="row hidden" style="margin-top:20px">
                                <div class="col-xs-4 col-sm-4"><div class="row"><div id="gesture-left"></div></div></div>
                                <div class="col-xs-4 col-sm-4 text-center" id="match-controls">

                                    <p class="text"><?php echo $lang->extractionContent->compareGestureQuestion ?></p>
                                    <div class="btn-group btn-group-justified" role="group">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-danger btn-shadow" id="btn-gesture-no"><i class="fa fa-thumbs-down"></i> <span class="btn-text"><?php echo $lang->no ?></span></button>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success btn-shadow" id="btn-gesture-yes"><i class="fa fa-thumbs-up"></i> <span class="btn-text"><?php echo $lang->yes ?></span></button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-default disabled btn-block btn-shadow" id="btn-redo" style="margin-top:10px"><i class="fa fa-undo" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->redo ?></span></button>
                                </div>
                                <div class="col-xs-4 col-sm-4"><div class="row"><div id="gesture-right"></div></div></div>
                            </div>
                            <h4 style="margin-top:30px" class="text"><?php echo $lang->ClassifiedGestures ?></h4>
                            <div id="classified-gestures"></div>
                            <div class="alert-space alert-no-gestures-classified"></div>
                        </div>

                        <div id="content-btn-checklist" class="hidden">
                            <span class="text" id="checklist-info"><?php echo $lang->extractionContent->checklistGestureInfo ?></span>

                            <div id="use-checklist-switch" style="margin-top: 10px">
                                <label class="text"><?php echo $lang->useChecklist ?></label> 
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
                            </div>

                            <div id="checklist-container" style="margin-top: 20px"></div>
                        </div>

                        <div id="content-btn-potential-gestures" class="hidden"></div>

                        <div id="content-btn-gesture-sets" class="hidden">
                            <div class="create-gesture-set-input" id="add-new-set">
                                <label class="text"><?php echo $lang->createNewGestureSet ?></label>

                                <div class="alert-space alert-gesture-set-title-too-short"></div>

                                <div class="input-group">
                                    <input type="text" class="form-control" id="input-new-set-title" minlength="8" maxlength="60" placeholder="<?php echo $lang->createNewGestureSetPlaceholder ?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-info" type="button" id="btn-add-gesture-set"><i class="fa fa-plus"></i></button>
                                    </span>
                                </div>
                            </div>

                            <hr>

                            <div id="item-view">

                                <div>
                                    <div class="form-group form-group-no-margin">
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo $lang->filter->name ?></span>
                                            <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="<?php echo $lang->filter->all ?>"/>
                                            <div class="input-group-btn select filter" id="filter" role="group">
                                                <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="all"></span><span class="caret"></span></button>
                                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                    <li id="all" class="selected"><a href="#"><?php echo $lang->filter->all ?></a></li>
                                                    <!--<li id="recorded"><a href="#"><?php echo $lang->filter->ownRecorded ?></a></li>-->
                                                    <!--<li id="tester"><a href="#"><?php echo $lang->filter->tester ?></a></li>-->
                                                    <li id="public"><a href="#"><?php echo $lang->filter->shared ?></a></li>
                                                    <!--<li id="rated"><a href="#"><?php echo $lang->filter->rated ?></a></li>-->
                                                    <li id="liked"><a href="#"><?php echo $lang->filter->liked ?></a></li>
                                                </ul>
                                            </div>
                                            <span class="input-group-addon"><?php echo $lang->sorting->name ?></span>
                                            <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="<?php echo $lang->sorting->ASC ?>"/>
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
                            <!--<div id="gesture-sets-container" class="root" style="margin-top: 20px"></div>-->
                        </div>
                    </div>

                </div>

                <div id="trigger-extraction-content" class="row hidden">

                    <div class="col-sm-4 col-md-3" style="margin-bottom: 20px">
                        <div data-spy="affix" data-offset-top="0" id="trigger-extraction-navigation">
                            <h5 class="text"><?php echo $lang->extractionContent->classification ?></h5>
                            <div class="btn-group-vertical btn-block" id="btns-general">
                                <button class="btn btn-default btn-shadow" type="button" id="btn-all-trigger"><span class="btn-text"><?php echo $lang->extractionContent->allElicitedTrigger ?></span></button>
                                <button class="btn btn-default btn-shadow" type="button" id="btn-trigger-classification"><span class="btn-text"><?php echo $lang->extractionContent->triggerClassification ?></span></button>
                                <button class="btn btn-default btn-shadow" type="button" id="btn-checklist"><span class="btn-text"><?php echo $lang->extractionContent->checklist ?></span></button>
                            </div>

                            <h5 class="text" style="margin-top: 20px"><?php echo $lang->extractionContent->analysis ?></h5>
                            <div class="btn-group-vertical btn-block" id="btns-arrange-trigger-sets">
                                <button class="btn btn-default btn-shadow disabled" type="button" id="btn-potential-trigger"><span class="btn-text"><?php echo $lang->extractionContent->potentialTrigger ?></span></button>
                                <!--<button class="btn btn-default btn-shadow disabled" type="button" id="btn-gesture-sets"><span class="btn-text"><?php echo $lang->gestureSets ?></span></button>-->
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-8 col-md-9" id="extraction-navigation-content" style="margin-top: 5px">
                        <div id="content-btn-all-trigger" class="hidden"></div>

                        <div id="content-btn-trigger-classification" class="hidden">
                            <h4 style="margin-top: 0px"><span class="text"><?php echo $lang->extractionContent->classifyTrigger ?></span> 
                                <button type="button" class="btn btn-xs btn-default btn-shadow disabled" id="btn-reclassify-trigger" style="margin-left:5px"><i class="fa fa-refresh" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->extractionContent->reclassify ?></span></button>
                            </h4>
                            <div class="alert-space alert-no-more-trigger-for-classification" style="margin-top:20px"></div>

                            <div id="trigger-classification-parameters" class="hidden text-center" style="margin-top:20px">
                                <div class="form-group root text" id="trigger-classification-type">
                                    <label><?php echo $lang->extractionContent->classifyTriggerQuestion ?></label><br>

                                    <div class="btn-group" id="radio">
                                        <button class="btn btn-default btn-radio" id="appearance" name="primary">
                                            <span id="icons" style="margin-right: 6px">
                                                <i class="fa fa-circle-thin" id="normal"></i>
                                                <i class="fa fa-circle hidden" id="over"></i>
                                                <i class="fa fa-check-circle hidden" id="checked"></i>
                                            </span>
                                            <span class="option-text"><?php echo $lang->classificationTypes->trigger ?></span>
                                        </button>
                                    </div>

                                    <br/>
                                    <div class="btn-group" id="radio">
                                        <button class="btn btn-default btn-radio btn-option-checked" id="appearanceGesture" name="primary">
                                            <span id="icons" style="margin-right: 6px">
                                                <i class="fa fa-circle-thin hidden" id="normal"></i>
                                                <i class="fa fa-circle hidden" id="over"></i>
                                                <i class="fa fa-check-circle " id="checked"></i>
                                            </span>
                                            <span class="option-text"><?php echo $lang->classificationTypes->appearanceGesture ?></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="btn-group-vertical">
                                    <!--<button type="button" class="btn btn-default btn-shadow" id="btn-help-classification"><i class="fa fa-question-circle"></i> <span class="btn-text">Mehr Infos zur Klassifizierung</span></button>-->
                                    <button type="button" class="btn btn-default btn-shadow" id="btn-start-trigger-classification"><i class="fa fa-archive"></i> <span class="btn-text"><?php echo $lang->extractionContent->startClassification ?></span></button>
                                </div>
                            </div>

                            <div id="trigger-classification" class="row hidden" style="margin-top:20px">
                                <div class="col-xs-4 col-sm-4">
                                    <div id="trigger-left">
                                        <div class="panel panel-default">
                                            <div class="panel-body text-center text font-bold" id="trigger-title" style="padding-bottom: 0px"></div>
                                            <div class="panel-body text-center text" id="justification" style="padding-top: 5px"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 text-center" id="trigger-match-controls">
                                    <p class="text"><?php echo $lang->extractionContent->compareTriggerQuestion ?></p>
                                    <div class="btn-group btn-group-justified" role="group">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-danger btn-shadow" id="btn-trigger-no"><i class="fa fa-thumbs-down"></i> <span class="btn-text"><?php echo $lang->no ?></span></button>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success btn-shadow" id="btn-trigger-yes"><i class="fa fa-thumbs-up"></i> <span class="btn-text"><?php echo $lang->yes ?></span></button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-default disabled btn-block btn-shadow" id="btn-redo" style="margin-top:10px"><i class="fa fa-undo" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->redo ?></span></button>
                                </div>
                                <div class="col-xs-4 col-sm-4">
                                    <div id="trigger-right">
                                        <div class="panel panel-default">
                                            <div class="panel-body text-center text font-bold" id="trigger-title" style="padding-bottom: 0px"></div>
                                            <div class="panel-body text-center text" id="justification" style="padding-top: 5px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 style="margin-top:30px" class="text"><?php echo $lang->ClassifiedTrigger ?></h4>
                            <div id="classified-trigger"></div>
                            <div class="alert-space alert-no-trigger-classified"></div>
                        </div>

                        <div id="content-btn-checklist" class="hidden">
                            <span class="text" id="checklist-info"><?php echo $lang->extractionContent->checklistTriggerInfo ?></span>

                            <div id="use-checklist-switch" style="margin-top: 10px">
                                <label class="text"><?php echo $lang->useChecklist ?></label> 
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
                            </div>


                            <div id="checklist-container" style="margin-top: 20px"></div>
                            <div class="alert-space alert-no-data-questionnaire"></div>

                            <div class="" style="margin-top: 10px" id="add-question-formats">
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

                                <button class="btn btn-default btn-shadow btn-preview-questionnaire" style="margin-top: 10px"><i class="fa fa-eye"></i> <?php echo $lang->previewHoleQuestionnaire ?></button>
                            </div>


                        </div>

                        <div id="content-btn-potential-trigger" class="hidden"></div>

                    </div>

                </div>

            </div>

        </div>


        <div class="container hidden" id="study-owner-controls">
            <hr style="margin-top: 0">
            <div class="btn-group-vertical btn-block" style="margin-top: 20px">
                <button class="btn btn-default btn-shadow" type="button" id="btn-preview-study"><i class="fa fa-eye" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->studyPreview ?></span></button>
                <button class="btn btn-default btn-shadow" type="button" id="btn-edit-study"><i class="fa fa-pencil" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->editStudy ?></span></button>
            </div>
            <div class="btn-group-vertical btn-block" style="margin-top: 20px">
                <button class="btn btn-danger btn-shadow" type="button" id="btn-delete-study"><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->deleteStudy ?></span></button>
            </div>
        </div>


        <div id="btn-scroll-to-top" class="hidden" style="cursor:pointer; display: block; position: fixed; bottom: 65px; right: 15px; padding: 8px 10px; color:white; border-radius: 5px; background-color: rgba(0,0,0,.6)"><i class="fa fa-arrow-up fa-2x"></i></div>


        <script>
            $(document).ready(function () {
                checkDomain();
                keepSessionAlive();
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-gesture', PATH_EXTERNALS + 'template-gesture.php']);
                    externals.push(['#template-previews', PATH_EXTERNALS + 'template-previews.php']);
                    externals.push(['#template-create', PATH_EXTERNALS + 'template-create.php']);
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                    externals.push(['#template-study', PATH_EXTERNALS + 'template-study.php']);
                    loadExternals(externals);
                });
            });

            var showStudyTutorial = 0;
            var showExtractionTutorial = 0;
            var tutorialAutomaticClicked = false;
            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
                var query = getQueryParams(document.location.search);
                var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                if (query.studyId && query.h === hash) {
                    getStudyById({studyId: query.studyId}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            setStudyData(result);
                            showStudyTutorial = parseInt(<?php echo $_SESSION['tutorialStudy'] ?>);
                            showExtractionTutorial = parseInt(<?php echo $_SESSION['tutorialExtraction'] ?>);

                            getGestureSets(function (setResults) {
                                console.log(setResults);
                                setLocalItem(GESTURE_SETS, setResults.gestureSets);

                                renderData(result, hash);
                                initPopover();
                                animateBreadcrump();
                            });
                        }
                    });
                }
            }

            $('#tab-introduction a').on('click', function (event) {
                event.preventDefault();
                var showTutorial = false;

                var activeTab = $('#tab-pane').find('.active a').attr('href');
                if (activeTab !== '#gesture-extraction' && activeTab !== '#study-participants') {
                    $('#study-owner-controls').removeClass('hidden');
                } else {
                    $('#study-owner-controls').addClass('hidden');
                }

                if (tutorialAutomaticClicked === false || (tutorialAutomaticClicked === true && (showStudyTutorial === 1 || showExtractionTutorial === 1))) {

                    var helpContext = 'study';
                    var helpKey = 'introductionStudy';

                    if (activeTab !== '#generalData') {
                        switch (activeTab) {
                            case '#general-infos':
                                $('#custom-modal').removeAttr('data-start-tab-id');
                                showTutorial = tutorialAutomaticClicked === false || showStudyTutorial === 1;
                                break;
                            case '#study-catalogs':
                                $('#custom-modal').attr('data-start-tab-id', 'study-catalogs');
                                showTutorial = tutorialAutomaticClicked === false || showStudyTutorial === 1;
                                break;
                            case '#study-phase-steps':
                                $('#custom-modal').removeAttr('data-start-tab-id');
                                showTutorial = tutorialAutomaticClicked === false || showStudyTutorial === 1;
                                break;
                            case '#study-participants':
                                $('#custom-modal').attr('data-start-tab-id', 'study-participants');
                                showTutorial = tutorialAutomaticClicked === false || showStudyTutorial === 1;
                                break;
                            case '#gesture-extraction':
                                var activeExtractionTab = $('#gesture-extraction-navigation').find('.active').attr('id');

                                switch (activeExtractionTab) {
                                    case 'btn-all-gestures':
                                    case 'btn-gesture-classification':
                                    case 'btn-checklist':
                                        $('#custom-modal').removeAttr('data-start-tab-id');
                                        break;
                                    case 'btn-potential-gestures':
                                    case 'btn-gesture-sets':
                                    case 'btn-potential-trigger':
                                        $('#custom-modal').attr('data-start-tab-id', 'analysis');
                                        break;
                                }

                                helpKey = 'introductionExtraction';
                                helpContext = 'extraction';
                                showTutorial = tutorialAutomaticClicked === false || showExtractionTutorial === 1;
                                break;
                        }
                    }

                    if (showTutorial) {
                        $('#custom-modal').attr('data-help-items-key', helpKey);
                        $('#custom-modal').attr('data-help-context', helpContext);
                        $('#custom-modal').attr('data-help-show-tutorial', parseInt(helpContext === 'study' ? showStudyTutorial : showExtractionTutorial));
                        loadHTMLintoModal('custom-modal', 'externals/modal-introduction.php', 'modal-lg');
                    }
                }
                tutorialAutomaticClicked = false;
            });

            $('#study-gestures-catalog').find('#btn-download-as-json').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $(this).popover('hide');
                    downloadGestureSetAsJSON($('#study-gestures-catalog').find('#gestures-list-container .gesture-thumbnail'), translation.studyGestureSet);
                }
            });

            $('#study-gestures-catalog').find('#btn-download-as-exchangeable').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $(this).popover('hide');
                    downloadGestureSetAsExchangeable($('#study-gestures-catalog').find('#gestures-list-container .gesture-thumbnail'), translation.exchangeableGestureSet);
                }
            });

            $('#btn-scroll-to-top').click(function (event) {
                event.preventDefault();
                $('html, body').animate({scrollTop: 0}, "fast");
            });
        </script>
    </body>
</html>
