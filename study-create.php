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
        <title><?php echo $lang->gestureNoteCreateStudy ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- third party sources -->
        <link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/greensock/TweenMax.min.js"></script>


        <script src="js/sha512.js"></script>
        <script src="js/chance.min.js"></script>
        <script src="js/filesaver/FileSaver.min.js"></script>
        <script src="js/gifshot/gifshot.min.js"></script>
        <script src="js/color-thief/color-thief.js"></script> 
        <script src="js/randomColor/randomColor.js"></script>
        <script src="js/jszip/jszip.min.js"></script>
        <script src="js/jszip/jszip-utils.min.js"></script>

        <!-- gesturenote specific sources -->
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/study-create.css">
        <link rel="stylesheet" href="css/gesture.css">

        <script src="js/moment/moment.js"></script>
        <link rel="stylesheet" href="js/bootstrap-datepicker/css/bootstrap-datetimepicker.css">
        <script src="js/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="js/moment/locale/de.js" charset="UTF-8"></script>
        <script src="js/moment/locale/en-gb.js" charset="UTF-8"></script>

        <script src="js/globalFunctions.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/refreshSession.js"></script>
        <script src="js/localforage.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/language.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>       
        <script src="js/ajax.js"></script> 
        <script src="js/gesture.js"></script>
        <script src="js/uploads.js"></script>
        <script src="js/dimensions.js"></script>
        <script src="js/forms.js"></script>
        <script src="js/joint-selection.js"></script>
        <script src="js/overlays.js"></script>
        <script src="js/study-create.js"></script>
        <script src="js/upload-queue.js"></script>
        <script src="js/gesture-importer.js"></script>

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
    <body>

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-general"></div>
        <div id="template-gesture"></div>
        <div id="template-inputs"></div>
        <div id="template-overlays"></div>
        <div id="template-study"></div>
        <div id="template-previews"></div>
        <div id="template-subpages"></div>
        <div id="template-gesture-recorder"></div>


        <div class="hidden-xs hidden-sm study-edit-controls" id="fixed-study-edit-controls" style="position: fixed; top: 50%; transform: translateY(-50%); z-index: 1; opacity: 0">
            <div class="btn-group-vertical">
                <button type="button" class="btn btn-lg btn-default btn-shadow btn-preview-study" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->studyPreview ?>" style="border-top-left-radius: 0px; border-top-right-radius: 8px"><i class="fa fa-eye"></i></button>
                <button type="button" class="btn btn-lg btn-default btn-shadow btn-cache-study" id="" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->cache ?>"><i class="fa fa-folder-open-o"></i></button>
                <button type="button" class="btn btn-lg btn-default btn-shadow btn-save-study" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->saveAndClose ?>" style="border-bottom-left-radius: 0px; border-bottom-right-radius: 8px"><i class="fa fa-save"></i></button>
            </div>
        </div>

        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb" style="">
            <div class="row">
                <ol class="breadcrumb">
                    <!--<li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>-->
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-studies"><i class="fa fa-tasks" aria-hidden="true"></i> <?php echo $lang->breadcrump->studies ?></a></li>
                    <li class="hidden"><a class="breadcrump-btn" id="btn-study"><i class="fa fa-clipboard"></i> <?php echo $lang->breadcrump->study ?></a></li>
                    <li class="active" id="btn-new-study"><i class="fa fa-pencil"></i> <span class="btn-text"><?php echo $lang->breadcrump->createStudy ?></span></li>
                </ol>
            </div>
        </div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content root">
                </div>
            </div>
        </div>

        <div class="container-fluid" id="creation-content" style="visibility: hidden; position: absolute; top: 0px; left: 0; width: 100%; height: auto; z-index: 101; padding-top: 70px; padding-bottom: 20px;">
            <div style="background-color: white; width: 100%; height: 100%; display: block; position: relative"></div>

            <div id="overlay-content-placeholder"></div>
        </div>

        <div id="creation-content-background" style="visibility: hidden;position: fixed; background-color: rgba(255,255,255,1); top: 0px; left: 0; width: 100%; height: 100%; z-index: 100;"></div>


        <div class="container mainContent">

            <div class="alert-space alert-no-storage-api"></div>

            <ul class="nav nav-tabs" id="create-tab-navigation" style="margin-bottom: 20px">
                <li role="presentation"><a href="#generalData" role="tab" data-toggle="tab"><?php echo $lang->studyCreateNav->general ?></a></li>
                <li role="presentation" class="disabledTab" id="tab-catalogs"><a href="#catalogs" role="tab" data-toggle="tab"><?php echo $lang->studyCreateNav->catalogs ?></a></li>
                <li role="presentation" class="disabledTab" id="tab-phases"><a href="#phases" role="tab" data-toggle="tab"><?php echo $lang->studyCreateNav->phases ?></a></li>
                <li role="presentation" id="tab-introduction" class="pull-right"><a role="button"><i class="fa fa-support"></i> <?php echo $lang->help ?></a></li>
            </ul>

            <div id="loading-indicator" class="window-sized-loading text-center">
                <i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw"></i>
            </div>

            <div class="tab-content hidden" id="create-study-tab-content">

                <div role="tabpanel" class="tab-pane" id="generalData">

                    <!-- manner selections -->
                    <form class="row" style="">
                        <div class="col-sm-7 col-md-6 col-lg-5">
                            <div class="form-group root" id="phaseSelect">

                                <label style="margin: 0">
                                    <?php echo $lang->studyPhase ?> 
                                    <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->phase ?>"></i>
                                </label><br>

                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio saveGeneralData" name="primary" id="elicitation">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->phaseType->elicitation ?></span>
                                    </button>
                                </div>
                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio saveGeneralData" name="primary" id="extraction">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->phaseType->extraction ?></span>
                                    </button>
                                </div>
                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio saveGeneralData" name="primary" id="evaluation">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->phaseType->evaluation ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5 col-md-6 col-lg-7">
                            <div class="form-group root" id="surveyTypeSelect">
                                <label style="margin: 0">
                                    <?php echo $lang->studySurveyType ?>
                                    <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->surveyType ?>"></i>
                                </label><br>

                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio saveGeneralData btn-option-checked" name="primary" id="moderated">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin hidden" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->surveyType->moderated ?></span>
                                    </button>
                                </div>
                                <div class="btn-group" id="radio" style="margin: 0">
                                    <button class="btn btn-default btn-radio saveGeneralData" name="primary" id="unmoderated">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->surveyType->unmoderated ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>

                    <!-- study title -->
                    <div class="form-group">
                        <label for="studyTitle" >
                            <?php echo $lang->studyTitle ?>
                            <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->title ?>"></i>
                        </label>
                        <input type="text" class="form-control" id="studyTitle" placeholder="<?php echo $lang->insertTitle ?>" required>
                    </div>


                    <!-- study description -->
                    <div class="form-group" style="margin-bottom: 0px">
                        <label for="studyDescription">
                            <?php echo $lang->studyDescription ?>
                            <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->description ?>"></i>
                        </label>
                        <textarea class="form-control" id="studyDescription" rows="5" placeholder="<?php echo $lang->insertDescription ?>"></textarea>
                    </div>

                    <div id="from-To-datepicker" style="margin-top: 15px">
                        <div class="row">
                            <div class='col-sm-6'>
                                <div class="form-group">
                                    <label><?php echo $lang->studyRunsFrom ?></label>
                                    <div class='input-group date' id='from-date-picker' style="width: 100%; background-color: #F8F8F8; padding: 10px; border-radius: 8px">
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-6'>
                                <div class="form-group">
                                    <label><?php echo $lang->studyRunsTo ?></label>
                                    <div class='input-group date' id='to-date-picker' style="width: 100%; background-color: #F8F8F8; padding: 10px; border-radius: 8px">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hidden study-plan"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>
                    </div>

                </div>




                <div role="tabpanel" class="tab-pane" id="catalogs">

                    <!--<div class="row">-->
                    <div class="" id="gestures-catalog">
                        <div style="display: inline">
                            <h4 style="display:inline-block; padding-right: 10px; position: relative; top:2px"><?php echo $lang->studyGestures ?> 
                                <i class="fa fa-info-circle btn-show-info" for="studyDescription" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->catalogGestures ?>"></i>
                            </h4>
                            <div class="btn-group">
                                <button style="display:inline-block" class="btn btn-default btn-shadow btn-open-overlay" id="catalog-gestures">
                                    <i class="fa fa-pencil" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->editCatalog ?></span>
                                </button>
                                <button class="btn btn-default btn-shadow disabled" id="btn-download-as-json" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsPidocoJSON ?>"><i class="fa fa-download"></i></button>
                                <button class="btn btn-default btn-shadow disabled" id="btn-download-as-exchangeable" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsExchangeable ?>"><i class="fa fa-file-archive-o"></i></button>
                            </div>
                        </div>

                        <div style="margin-top: 10px" class="row" id="gestures-list-container"></div>
                        <div class="alert-space alert-no-phase-data"></div>
                    </div>

                    <div class="" id="trigger-catalog" style="margin-top: 40px">
                        <div style="display: inline">
                            <h4 style="display:inline-block; padding-right: 10px; position: relative; top:2px"><?php echo $lang->triggers ?> 
                                <i class="fa fa-info-circle btn-show-info" for="studyDescription" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->catalogTrigger ?>"></i>
                            </h4>
                            <button style="display:inline-block" class="btn btn-default btn-shadow btn-open-overlay" id="catalog-trigger">
                                <i class="fa fa-pencil" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->editCatalog ?></span>
                            </button>
                        </div>

                        <div class="list-container"></div>
                        <div class="alert-space alert-no-phase-data" style="margin-top: 10px"></div>
                    </div>

                    <div class="" id="scenes-catalog" style="margin-top: 40px">
                        <div style="display: inline">
                            <h4 style="display:inline-block; padding-right: 10px; position: relative; top:2px"><?php echo $lang->scenes ?> 
                                <i class="fa fa-info-circle btn-show-info" for="studyDescription" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->catalogScenes ?>"></i>
                            </h4>
                            <button style="display:inline-block" class="btn btn-default btn-shadow btn-open-overlay" id="catalog-scenes">
                                <i class="fa fa-pencil" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->editCatalog ?></span>
                            </button>
                        </div>

                        <div class="list-container"></div>
                        <div class="alert-space alert-no-phase-data" style="margin-top: 10px"></div>
                    </div>

                    <div class="" id="feedback-catalog" style="margin-top: 40px">
                        <div style="display: inline">
                            <h4 style="display:inline-block; padding-right: 10px; position: relative; top:2px"><?php echo $lang->feedbacks ?> 
                                <i class="fa fa-info-circle btn-show-info" for="studyDescription" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->catalogFeedback ?>"></i>
                            </h4>
                            <button style="display:inline-block" class="btn btn-default btn-shadow btn-open-overlay" id="catalog-feedback">
                                <i class="fa fa-pencil" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->editCatalog ?></span>
                            </button>
                        </div>

                        <div class="list-container"></div>
                        <div class="alert-space alert-no-phase-data" style="margin-top: 10px"></div>
                    </div>
                    <!--</div>-->
                </div>






                <div role="tabpanel" class="tab-pane" id="phases">
                    <div class="row">
                        <div class="col-sm-7 col-md-6">
                            <div class="" id="phaseStepList"></div>
                            <hr class="hidden-sm hidden-md hidden-lg" id="seperatorPhaseStepList" style="margin-bottom: 10px">
                        </div>



                        <div class="col-sm-5 col-md-6">
                            <div id="phaseStepSelect">
                                <h4><?php echo $lang->questionnaires ?></h4>

                                <div class="add-button-group" id="add-phase-step-format-group-questionnaires">
                                    <div class="btn-group" data-study-phase="all" data-study-survey-type="all">
                                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="questionnaire">
                                            <i class="fa fa-plus"></i> <?php echo $lang->formats->questionnaire->text ?>
                                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->questionnaire ?>"></i>
                                        </div>
                                    </div>
                                    <div class="btn-group" data-study-phase="evaluation" data-study-survey-type="all">
                                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="gus">
                                            <i class="fa fa-plus"></i> <?php echo $lang->formats->gus->text ?>
                                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->gus ?>"></i>
                                        </div>
                                    </div>
                                    <div class="btn-group" data-study-phase="evaluation" data-study-survey-type="all">
                                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="questionnaireGestures">
                                            <i class="fa fa-plus"></i> <?php echo $lang->formats->questionnaireGestures->text ?>
                                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->questionnaireGestures ?>"></i>
                                        </div>
                                    </div>
                                    <div class="btn-group" data-study-phase="evaluation" data-study-survey-type="all">
                                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sus">
                                            <i class="fa fa-plus"></i> <?php echo $lang->formats->sus->text ?>
                                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->sus ?>"></i>
                                        </div>
                                    </div>
                                    <div class="btn-group" data-study-phase="evaluation" data-study-survey-type="all">
                                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="ueq">
                                            <i class="fa fa-plus"></i> <?php echo $lang->formats->ueq->text ?>
                                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->ueq ?>"></i>
                                        </div>
                                    </div>
                                </div>

                                <h4 style="margin-top: 20px"><?php echo $lang->miscellaneous ?></h4>
                                <div class="add-button-group" id="add-phase-step-format-group-miscellaneous">
                                    <div class="btn-group" data-study-phase="all" data-study-survey-type="moderated">
                                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="interview">
                                            <i class="fa fa-plus"></i> <?php echo $lang->formats->interview->text ?>
                                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->interview ?>"></i>
                                        </div>
                                    </div>
                                    <div class="btn-group" data-study-phase="all" data-study-survey-type="moderated">
                                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="focusGroupInterview">
                                            <i class="fa fa-plus"></i> <?php echo $lang->formats->focusGroupInterview->text ?>
                                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->focusGroupInterview ?>"></i>
                                        </div>
                                    </div>
                                    <div class="btn-group" data-study-phase="elicitation" data-study-survey-type="moderated">
                                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="identification">
                                            <i class="fa fa-plus"></i> <?php echo $lang->formats->identification->text ?>
                                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->identification ?>"></i>
                                        </div>
                                    </div>
                                    <div class="btn-group" data-study-phase="evaluation" data-study-survey-type="moderated">
                                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="gestureTraining">
                                            <i class="fa fa-plus"></i> <?php echo $lang->formats->gestureTraining->text ?>
                                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->gestureTraining ?>"></i>
                                        </div>
                                    </div>
                                    <div class="btn-group" data-study-phase="evaluation" data-study-survey-type="moderated">
                                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="scenario">
                                            <i class="fa fa-plus"></i> <?php echo $lang->formats->scenario->text ?>
                                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->scenario ?>"></i>
                                        </div>
                                    </div>
                                    <div class="btn-group" data-study-phase="evaluation" data-study-survey-type="moderated">
                                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="gestureSlideshow">
                                            <i class="fa fa-plus"></i> <?php echo $lang->formats->gestureSlideshow->text ?>
                                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->gestureSlideshow ?>"></i>
                                        </div>
                                    </div>
                                    <div class="btn-group" data-study-phase="evaluation" data-study-survey-type="moderated">
                                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="triggerSlideshow">
                                            <i class="fa fa-plus"></i> <?php echo $lang->formats->triggerSlideshow->text ?>
                                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->triggerSlideshow ?>"></i>
                                        </div>
                                    </div>
                                    <div class="btn-group" data-study-phase="evaluation" data-study-survey-type="all">
                                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="physicalStressTest">
                                            <i class="fa fa-plus"></i> <?php echo $lang->formats->physicalStressTest->text ?>
                                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->physicalStressTest ?>"></i>
                                        </div>
                                    </div>
                                    <div class="btn-group" data-study-phase="extraction" data-study-survey-type="moderated">
                                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="exploration">
                                            <i class="fa fa-plus"></i> <?php echo $lang->formats->exploration->text ?>
                                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->exploration ?>"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-margin-top hidden root" id="phaseStepItem" style="">
                        <div class="btn-group">
                            <button class="btn btn-default btn-shadow btn-up saveGeneralData" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->moveUp ?>">
                                <i class="fa fa-arrow-up"></i>
                            </button>
                            <button class="btn btn-default btn-shadow btn-down saveGeneralData" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->moveDown ?>">
                                <i class="fa fa-arrow-down"></i>
                            </button>
                            <button class="btn btn-default btn-shadow btn-delete saveGeneralData" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->delete ?>">
                                <i class="fa fa-trash"></i>
                            </button>
                            <button class="btn btn-default btn-shadow btn-text-button btn-open-overlay" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->editPhasestep ?>">
                                <span class="phase-step-format"></span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="hidden-md hidden-lg study-edit-controls" id="btn-group-submit" style="z-index: 0; opacity: 0">
                <hr>

                <!-- submit form button group -->
                <div class="btn-group-vertical btn-block" role="group">
                    <button type="button" class="btn btn-default btn-shadow disabled btn-preview-study"><i class="fa fa-eye"></i> <?php echo $lang->studyPreview ?></button>
                    <button type="button" class="btn btn-default btn-shadow btn-cache-study"><i class="fa fa-folder-open-o"></i> <?php echo $lang->cache ?></button>

                </div>
                <div class="btn-group-vertical btn-block" style="margin-top: 20px">
                    <button type="button" class="btn btn-default btn-shadow btn-save-study"><i class="fa fa-save"></i> <?php echo $lang->saveAndClose ?></button>
                </div>
            </div>

        </div>


        <script>
            var firstInit = false;
            var jumpToId = null;

            $(document).ready(function () {
                firstInit = true;
                checkDomain();
                keepSessionAlive();

                checkLanguage(function () {
                    createRandomColors();

                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                    externals.push(['#template-gesture', PATH_EXTERNALS + 'template-gesture.php']);
                    externals.push(['#template-inputs', PATH_EXTERNALS + 'template-create.php']);
                    externals.push(['#template-overlays', PATH_EXTERNALS + 'template-overlays.php']);
                    externals.push(['#template-study', PATH_EXTERNALS + 'template-study.php']);
                    externals.push(['#template-previews', PATH_EXTERNALS + 'template-previews.php']);
                    externals.push(['#template-gesture-recorder', PATH_EXTERNALS + 'template-gesture-recorder.php']);
                    loadExternals(externals);
                });
            });

            var editableStudyId = null;
            var studyEditable = false;
            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
                var query = getQueryParams(document.location.search);
                var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                if (query.studyId && query.h === hash) {
//                    $('#btn-clear-data').remove();
                    studyEditable = true;
                    editableStudyId = query.studyId;
                    $('#btn-study').parent().removeClass('hidden');
                    $('#btn-new-study').find('.btn-text').text('Bearbeiten');
                    $('.btn-study').removeClass('hidden');

                    if (getLocalItem(STUDY)) {
                        init();
                    } else {
                        getStudyById({studyId: query.studyId}, function (result) {
                            if (result.status === RESULT_SUCCESS) {
                                setStudyData(result);
                                init();
                            }
                        });
                    }
                } else if (query.edit && (query.edit === true || query.edit === "true") && query.studyId) {
//                    $('#btn-clear-data').remove();
                    studyEditable = true;
                    editableStudyId = query.studyId;
                    $('#btn-study').parent().removeClass('hidden');
                    $('#btn-new-study').find('.btn-text').text('Bearbeiten');
                    $('.btn-study').removeClass('hidden');
                    init();
                } else {
                    studyEditable = false;
                    editableStudyId = null;
                    init();
                }

                animateBreadcrump();
            }

            function init() {
                var study = getLocalItem(STUDY);
                var minDate = false;
                var now = new Date();
                now.setHours(0, 0, 0);
                now.setMilliseconds(0);

                if (studyEditable === false || !study) {
                    // set min date to current date
                    minDate = now;
                } else {
                    // set min date to saved beginning date
                    if (parseInt(study.dateFrom) * 1000 > now.getTime()) {
                        minDate = now;
                    } else {
                        minDate = new Date(parseInt(study.dateFrom) * 1000);
                    }
                }

                $('#from-date-picker').datetimepicker({
                    format: 'DD/MM/YYYY',
                    inline: true,
                    useCurrent: !study,
                    defaultDate: study && study.dateFrom ? new Date(parseInt(study.dateFrom) * 1000) : false,
                    minDate: minDate,
                    locale: translation.languages[currentLanguage].locale
                });

                $('#to-date-picker').datetimepicker({
                    format: 'DD/MM/YYYY',
                    inline: true,
                    useCurrent: !study, //Important! See issue #1075
                    defaultDate: study && study.dateTo ? new Date(parseInt(study.dateTo) * 1000) : false,
                    minDate: minDate,
                    locale: translation.languages[currentLanguage].locale
                });

                $("#from-date-picker").on("dp.change", function (e) {
                    var selectedDate = e.date;
                    $('#to-date-picker').data("DateTimePicker").minDate(selectedDate);
                    selectedDate = new Date(selectedDate);
                    var selectedDateTo = $("#to-date-picker").data("DateTimePicker").viewDate();
                    selectedDateTo = new Date(selectedDateTo._d);
                    selectedDateTo.setHours(0);
                    selectedDateTo.setMinutes(0);
                    selectedDateTo.setSeconds(0);
                    selectedDateTo.setMilliseconds(0);

                    if (selectedDate.getTime() >= selectedDateTo.getTime()) {
                        $('#to-date-picker').data('DateTimePicker').defaultDate(selectedDate);
                    }
                    updateScheduleInfo();
                    saveGeneralData();
                });

                $("#to-date-picker").on("dp.change", function (e) {
//                    $('#from-date-picker').data("DateTimePicker").maxDate(e.date);
                    updateScheduleInfo();
                    saveGeneralData();
                });

                updateScheduleInfo();
                checkSessionStorage();

                var status = window.location.hash.substr(1);
                var statusNavMatch = getStatusNavMatch(status);
                if (status !== '' && statusNavMatch !== null) {
                    $('#create-tab-navigation').find('#tab-' + statusNavMatch + ' a').click();
                } else {
                    $('#create-tab-navigation').children().first().find('a').click();
                }
//                $('#loading-indicator').remove();

                var showTutorial = parseInt(<?php echo $_SESSION['tutorialStudyCreation'] ?>);
                if (showTutorial === 1) {
                    $('#tab-introduction a').click();
                }

                showPageContent();
                initTooltips();
                initPopover();
            }

            function showPageContent() {
                $('#create-study-tab-content').removeClass('hidden');
                TweenMax.to($('#loading-indicator'), .4, {opacity: 0, onComplete: function () {
                        $('#loading-indicator').remove();
                    }});
                TweenMax.from($('#create-study-tab-content'), .3, {delay: .3, opacity: 0});

                TweenMax.to($('.study-edit-controls'), .3, {autoAlpha: 1});
                TweenMax.to($('#fixed-study-edit-controls'), .3, {opacity: 1});
                TweenMax.from($('#fixed-study-edit-controls'), .3, {x: -20, ease: Quad.easeInOut});
            }

            function updateScheduleInfo() {
                var dateFromInput = $('#from-date-picker').data("DateTimePicker").viewDate();
                var dateFrom = new Date(new Date(dateFromInput._d).toDateString());
                var dateToInput = $('#to-date-picker').data("DateTimePicker").viewDate();
                var dateTo = addDays(new Date(new Date(dateToInput._d).toDateString()), 1);
                var totalDays = rangeDays(dateFrom.getTime(), dateTo.getTime());
                var renderDateTo = addSeconds(dateTo, -1);

                $('.study-plan').find('.address').text(translation.studyRun + ": ");
                $('.study-plan').find('.text').text(totalDays + " " + (totalDays === 1 ? translation.day : translation.days) + ", " + translation.from + ' ' + dateFrom.toLocaleDateString() + ' (' + translation.zeroOClick + ') ' + translation.to + " " + renderDateTo.toLocaleDateString() + ' (' + renderDateTo.getHours() + ':' + renderDateTo.getMinutes() + ')');
                $('.study-plan').removeClass('hidden');
            }

            function getStatusNavMatch(status) {
                var tabs = $('#create-tab-navigation').children();
                for (var i = 0; i < tabs.length; i++) {
                    if ($(tabs[i]).attr('id') === 'tab-' + status) {
                        return status;
                    }
                }
                return null;
            }

            $('#custom-modal').on('hidden.bs.modal', function () {
                $(this).find('.modal-content').empty();
            });

            function checkPreviewAvailability() {
                var phaseSteps = getLocalItem(STUDY_PHASE_STEPS);
                if (phaseSteps && phaseSteps.length > 0) {
                    $('.btn-preview-study').removeClass('disabled');
                } else {
                    $('.btn-preview-study').addClass('disabled');
                }
            }

            function addPhaseStep(id, format, title, animate, prependItem, callback) {

                if (title === null || title === undefined) {
                    title = translation.formats[format].text;
                }

                var clone = $('#phaseStepItem').clone().removeAttr('id');
                clone.removeClass('hidden').addClass(translation.formats[format].class);
                clone.attr('id', id);
                clone.find('.btn-open-overlay').attr('id', format);
                clone.find('.phase-step-format').text(title);

                if (format === THANKS || format === LETTER_OF_ACCEPTANCE) {
                    clone.find('.btn-delete, .btn-up, .btn-down').remove();
                } else {
                    clone.find('.btn-delete').bind("click", {format: format, id: id}, function (event) {
                        event.preventDefault();
                        removeLocalItem(event.data.id + ".data");
                        checkPreviewAvailability();
                    });

                    switch (format) {
                        case SUS:
                            setLocalItem(id + ".data", translation.sus);
                            break;
                        case FAVORITE_GESTURES:
                            setLocalItem(id + ".data", translation.favoriteGesturesQuestionnaire);
                            break;
                    }
                }

//                console.log('add phase step', prependItem, clone, $('#phaseStepList').find('.form-group').last());
                if (prependItem && prependItem === true) {
                    setTimeout(function () {
                        $(clone).insertBefore($('#phaseStepList').children().last());
                        initPopover();
                        checkCurrentListState($('#phaseStepList'));
                        if (callback) {
                            callback();
                        }
                    }, 300);
                } else {
                    $('#phaseStepList').append(clone);
                    initPopover();
                    checkCurrentListState($('#phaseStepList'));
                    if (callback) {
                        callback();
                    }
                }

                if (animate === true) {
                    TweenMax.from(clone, 1.2, {y: -50, opacity: 0, delay: .3, ease: Elastic.easeOut});
                }
            }

            $('#phaseSelect').on('change', function (event) {
                event.preventDefault();

                var catalogsNav = $('#create-tab-navigation #tab-catalogs');
                var phasesNav = $('#create-tab-navigation #tab-phases');
                if ($(phasesNav).hasClass('disabledTab') && $(catalogsNav).hasClass('disabledTab')) {
                    $(phasesNav).removeClass('disabledTab');
                    $(catalogsNav).removeClass('disabledTab');
                    if (firstInit) {
                        firstInit = false;
                        TweenMax.to(catalogsNav, .1, {y: -20});
                        TweenMax.to(catalogsNav, .5, {delay: .1, y: 0, ease: Bounce.easeOut});
                        TweenMax.to(phasesNav, .1, {delay: .1, y: -20});
                        TweenMax.to(phasesNav, .5, {delay: .2, y: 0, ease: Bounce.easeOut});
                    }
                }

                checkSelectedGeneralStudyProperties();
                saveGeneralData();
                renderPhaseSteps();
            });

            $('#surveyTypeSelect').on('change', function (event) {
                event.preventDefault();
                checkSelectedGeneralStudyProperties();
                saveGeneralData();
                renderPhaseSteps();
            });

            function checkSelectedGeneralStudyProperties() {
                var phaseId = $('#phaseSelect').find('.btn-option-checked').attr('id');
                if (phaseId === TYPE_PHASE_ELICITATION || phaseId === TYPE_PHASE_EXTRACTION) {
                    $('#surveyTypeSelect').find('#unmoderated').addClass('disabled');
                    if ($('#surveyTypeSelect').find('.btn-option-checked').attr('id') === 'unmoderated') {
                        $('#surveyTypeSelect').find('#moderated').click();
                    }
                } else {
                    $('#surveyTypeSelect').find('#unmoderated').removeClass('disabled');
                }

                var surveyTypeId = $('#surveyTypeSelect').find('.btn-option-checked').attr('id');

                var addPhaseButtons = $('#phaseStepSelect').find('.btn-group');
                for (var i = 0; i < addPhaseButtons.length; i++) {
                    var button = addPhaseButtons[i];
                    if (($(button).attr('data-study-phase') === phaseId || $(button).attr('data-study-phase') === 'all') && ($(button).attr('data-study-survey-type') === surveyTypeId || $(button).attr('data-study-survey-type') === 'all')) {
                        $(button).removeClass('hidden');
                    } else {
                        $(button).addClass('hidden');
                    }
                }
            }

            $('.breadcrumb li a').click(function (event) {
                var button = $(this);
                event.stopImmediatePropagation();
                var clickedId = $(button).attr('id');
                jumpToId = clickedId;
                loadHTMLintoModal('custom-modal', 'externals/modal-delete-data.php', 'modal-md');

                $('#custom-modal').unbind('deleteData').bind('deleteData', function () {
                    if (editableStudyId === null) {
                        clearSceneImages();
                        clearSounds();
                    }

                    clearLocalItems();
                    checkJumpId();
                });

                $('#custom-modal').unbind('saveDataClose').bind('saveDataClose', function () {
                    $('.btn-save-study').click();
                });
            });

            $('body').on('click', '.main-burger-menu li a', function (event) {
                var button = $(this);
                event.stopImmediatePropagation();
                var clickedId = $(button).parent().attr('data-id');
                jumpToId = clickedId;
                loadHTMLintoModal('custom-modal', 'externals/modal-delete-data.php', 'modal-md');

                $('#custom-modal').unbind('saveDataClose').bind('saveDataClose', function () {
                    $('.btn-save-study').click();
                });

                $('#custom-modal').unbind('deleteData').bind('deleteData', function () {
                    if (editableStudyId === null) {
                        clearSceneImages();
                        clearSounds();
                    }

                    clearLocalItems();
                    checkJumpId();
                });
            });

            function checkJumpId() {
                if (jumpToId !== null) {
                    if (jumpToId === 'btn-study') {
                        var hash = hex_sha512(parseInt(editableStudyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                        goto("study.php?studyId=" + editableStudyId + "&h=" + hash);
                    } else {
                        switch (jumpToId) {
                            case 'btn-dashboard':
                                gotoDashboard();
                                break;
                            case 'btn-studies':
                                gotoStudies();
                                break;
                            case 'btn-gesture-styleguides':
                                gotoGestureStyleguides();
                                break;
                            case 'btn-gesture-catalog':
                                gotoGesturesCatalog();
                                break;
                            case 'btn-news':
                                gotoNews();
                                break;
                            case 'btn-publications':
                                gotoPublications();
                                break;
                            case 'btn-profile':
                                gotoProfile();
                                break;
                            case 'btn-support':
                                gotoSupport();
                                break;
                            case 'btn-informations':
                                gotoInformations();
                                break;
                            case 'btn-imprint':
                                gotoImprint();
                                break;
                        }
                    }
                }

                jumpToId = null;
            }

            $('.btn-preview-study').click(function (event) {
                event.preventDefault();
                if (checkInputs() === true && !$(this).hasClass('disabled')) {
                    saveGeneralData();
                    if (studyEditable === true) {
                        goto("study-preview.php?edit=true&studyId=" + editableStudyId);
                    } else {
                        gotoCreateStudyPreview();
                    }
                } else {
                    $('#create-tab-navigation').children().first().find('a').click();
                }
            });

            $('.btn-save-study').click(function (event) {
                event.preventDefault();
                if (checkInputs() === true) {
                    var button = $(this);
                    $('.btn-preview-study').addClass('disabled');
                    saveGeneralData();
                    showCursor($('body'), CURSOR_POINTER);
                    if (studyEditable === true) {
                        var updateData = getStudyData();
                        updateData.studyId = editableStudyId;
                        updateStudy(updateData, function (result) {
                            showCursor($('body'), CURSOR_DEFAULT);
                            $(button).removeClass('disabled');
                            $('.btn-cache-study, .btn-preview-study').removeClass('disabled');
                            if (result.status === RESULT_SUCCESS) {
                                clearLocalItems();

                                if (jumpToId !== null) {
                                    checkJumpId();
                                } else {
                                    var hash = hex_sha512(parseInt(result.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                                    goto("study.php?studyId=" + result.studyId + "&h=" + hash);
                                }
                            }
                        });
                    } else {
                        saveStudy(getStudyData(), function (result) {
                            showCursor($('body'), CURSOR_DEFAULT);
                            $(button).removeClass('disabled');
                            $('.btn-cache-study, .btn-preview-study').removeClass('disabled');
                            if (result.status === RESULT_SUCCESS) {
                                clearLocalItems();

                                if (jumpToId !== null) {
                                    checkJumpId();
                                } else {
                                    var hash = hex_sha512(parseInt(result.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                                    goto("study.php?studyId=" + result.studyId + "&h=" + hash);
                                }
                            }
                        });
                    }
                } else {
                    $('#create-tab-navigation').children().first().find('a').click();
                }
            });

            $('.btn-cache-study').click(function (event) {
                event.preventDefault();
                if (checkInputs() === true) {
                    var button = $(this);
                    $('.btn-save-study, .btn-preview-study').addClass('disabled');
                    saveGeneralData();
                    showCursor($('body'), CURSOR_POINTER);
                    lockButton(button, true, 'fa-save');
                    if (studyEditable === true) {
                        var updateData = getStudyData();
                        updateData.studyId = editableStudyId;
                        updateStudy(updateData, function (result) {
                            showCursor($('body'), CURSOR_DEFAULT);
                            $(button).removeClass('disabled');
                            $('.btn-save-study, .btn-preview-study').removeClass('disabled');
                            unlockButton(button, true, 'fa-save');
                            if (result.status === RESULT_SUCCESS) {
//                                clearLocalItems();
//                                var hash = hex_sha512(parseInt(result.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
//                                goto("study.php?studyId=" + result.studyId + "&h=" + hash);
                            } else {
                                //                            appendAlert()
                            }
                        });
                    } else {
                        saveStudy(getStudyData(), function (result) {
                            showCursor($('body'), CURSOR_DEFAULT);
                            $(button).removeClass('disabled');
                            $('.tn-save-study, .btn-preview-study').removeClass('disabled');
                            unlockButton(button, true, 'fa-save');
                            if (result.status === RESULT_SUCCESS) {
//                                clearLocalItems();
//                                var hash = hex_sha512(parseInt(result.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
//                                goto("study.php?studyId=" + result.studyId + "&h=" + hash);
                            } else {
                                //                            appendAlert()
                            }
                        });
                    }
                } else {
                    $('#create-tab-navigation').children().first().find('a').click();
                }
            });

            function checkInputs() {
                resetErrors();
                var errors = 0;
                $('.tab-general').find('.has-error').removeClass('has-error');
                if ($('#studyTitle').val().trim() === "") {
                    $('#studyTitle').closest('.form-group').addClass('has-error');
                    errors++;
                }

                if ($('#studyDescription').val().trim() === "") {
                    $('#studyDescription').closest('.form-group').addClass('has-error');
                    errors++;
                }

                if ($('#phaseSelect').find('.chosen').attr('id') === 'unselected') {
                    $('#phaseSelect').closest('.form-group').addClass('has-error');
                    errors++;
                }

                if ($('#surveyMethodSelect').find('.chosen').attr('id') === 'unselected') {
                    $('#surveyMethodSelect').closest('.form-group').addClass('has-error');
                    errors++;
                }

                if ($('#surveyTypeSelect').find('.chosen').attr('id') === 'unselected') {
                    $('#surveyTypeSelect').closest('.form-group').addClass('has-error');
                    errors++;
                }

                return errors === 0;
            }

            function resetErrors() {
                $('#studyTitle').closest('.form-group').removeClass('has-error');
                $('#studyDescription').closest('.form-group').removeClass('has-error');
                $('#phaseSelect').closest('.form-group').removeClass('has-error');
                $('#surveyTypeSelect').closest('.form-group').removeClass('has-error');
            }

            $('#create-tab-navigation').on('show.bs.tab', function (event) {
                var activeTabContent = $('#create-study-tab-content').find($(event.target).attr('href'));
                TweenMax.from(activeTabContent, .2, {opacity: 0, y: -20, clearProps: 'all'});
                TweenMax.from($('#btn-group-submit'), .3, {y: -20});
                $("html, body").animate({scrollTop: 0}, 100);
                window.location.hash = $(event.target).attr('href');
            });

            $('#tab-introduction a').on('click', function (event) {
                event.preventDefault();
                var activeTab = $('#create-tab-navigation').find('.active a').attr('href');
                if (activeTab !== '#generalData') {
                    switch (activeTab) {
                        case '#catalogs':
                            $('#custom-modal').attr('data-start-tab-id', 'catalogs');
                            break;
                        case '#phases':
                            $('#custom-modal').attr('data-start-tab-id', 'phases');
                            break;
                    }
                }
//                console.log(activeTab);

                $('#custom-modal').attr('data-help-items-key', 'introductionCreateStudy');
                $('#custom-modal').attr('data-help-context', 'studyCreation');
                $('#custom-modal').attr('data-help-show-tutorial', parseInt(<?php echo $_SESSION['tutorialStudyCreation'] ?>));
                loadHTMLintoModal('custom-modal', 'externals/modal-introduction.php', 'modal-lg');
            });

            $('#phaseStepSelect').on('change', function (event) {
                var itemType = $(event.target).attr('id');
                addPhaseStep(chance.natural(), itemType, null, true, true, function () {
                    savePhases();
                });

                checkPreviewAvailability();

                var tweenTargetOffset = $('#phaseStepList').find('.btn-group').last().offset();
                var tweenElementOffset = $(event.target).offset();
                var tweenOffset = {offsetY: tweenTargetOffset.top - tweenElementOffset.top, offsetX: tweenTargetOffset.left - tweenElementOffset.left};
                var alphaY = tweenOffset.offsetY < 0 ? '' + tweenOffset.offsetY : '+' + tweenOffset.offsetY;
                var alphaX = tweenOffset.offsetX < 0 ? '' + tweenOffset.offsetX : '+' + tweenOffset.offsetX;
                TweenMax.to($(event.target), .3, {x: alphaX, y: alphaY, opacity: 0, clearProps: 'all', ease: Quad.easeIn, onComplete: onMovePhaseStepComplete});
            });

            function onMovePhaseStepComplete() {
                $('#phaseStepList').trigger('listItemAdded');
            }

            $('#phaseStepList').unbind('listItemAdded').bind('listItemAdded', function (event) {
                event.preventDefault();
                var scrollTarget = $('body');
                var newScrollTop = Math.max(0, scrollTarget.height());
                $(scrollTarget).animate({
                    scrollTop: newScrollTop
                }, 400);
            });

            var overlayTween = new TimelineMax({paused: true, onReverseComplete: onReverseComplete});
            overlayTween.add("parallel", .3)
                    .to($('.sub-page-header'), .3, {autoAlpha: 0}, 'parallel')
                    .to($('.mainContent'), .3, {autoAlpha: 0}, 'parallel')
                    .to($('#breadcrumb'), .3, {autoAlpha: 0}, 'parallel')
//                    .to($('.mainContent'), .3, {webkitFilter: "blur(5px)", filter: "blur(5px)"}, 'parallel')
//                    .to($('#breadcrumb'), .3, {webkitFilter: "blur(5px)", filter: "blur(5px)"}, 'parallel')
                    .to($('#creation-content'), .3, {autoAlpha: 1}, 'parallel')
                    .to($('#fixed-study-edit-controls'), .2, {autoAlpha: 0, x: -20}, 'parallel')
//                    .to($('#creation-content-background'), .3, {autoAlpha: 1}, 'parallel');

            $(document).on('click', '.btn-open-overlay', function (event) {
                event.preventDefault();
                var format = $(this).attr('id');
                var id = $(this).closest('.root').attr('id');
                if (format && id) {
                    initOverlayContent(format, id);
                } else if (format) {
                    initOverlayContentByFormat(format);
                }
                overlayTween.play();
                setTimeout(function () {
                    $('html,body').animate({
                        scrollTop: 0
                    }, 200);
                }, 300);
                $('.mainContent').addClass('hidden');
            });

            function onReverseComplete() {
                resetOverlayContent($('#overlay-content-placeholder'));
            }

            $(document).on('click', '.btn-close-overlay, .btn-cancel-overlay', function (event) {
                event.preventDefault();
                $('html,body').animate({
                    scrollTop: 0
                }, 200);
                overlayTween.reverse();
                $('.mainContent').removeClass('hidden');
            });

            $('#gestures-catalog').find('#btn-download-as-json').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $(this).popover('hide');
                    downloadGestureSetAsJSON($('#gestures-catalog').find('#gestures-list-container .gesture-thumbnail'), translation.studyGestureSet);
                }
            });

            $('#gestures-catalog').find('#btn-download-as-exchangeable').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $(this).popover('hide');
                    downloadGestureSetAsExchangeable($('#gestures-catalog').find('#gestures-list-container .gesture-thumbnail'), translation.exchangeableGestureSet);
                }
            });

            var datePickerFromOpened = false;
            $('#btn-show-datepicker-from').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!event.handled) {
                    event.handled = true;
                    $('#from-To-datepicker #start').datepicker('show');
                }
            });

            $('#from-To-datepicker #start').on('show', function (event) {
                $('#btn-show-datepicker-from').addClass('active');
            });

            $('#from-To-datepicker #start').on('hide', function (event) {
                $('#btn-show-datepicker-from').removeClass('active');
            });

            $('#btn-show-datepicker-to').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!event.handled) {
                    event.handled = true;
                    $('#from-To-datepicker #end').datepicker('show');
                }
            });

            $('#from-To-datepicker #end').on('show', function (event) {
                $('#btn-show-datepicker-to').addClass('active');
            });

            $('#from-To-datepicker #end').on('hide', function (event) {
                $('#btn-show-datepicker-to').removeClass('active');
            });
        </script>

    </body>
</html>