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
        <title><?php echo $lang->gestureNoteExtractionStudy ?></title>
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
        <!--<script src="js/color-thief/color-thief.js"></script>--> 
        <!--<script src="js/randomColor/randomColor.js"></script>-->
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
        <script src="js/extraction-create.js"></script>
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

        <!-- peer connection with webrtc -->
        <script src="js/collaborativeVideo.js"></script>
        <script src="js/peerConnection.js"></script>
        <script src="js/andyet/simplewebrtc.bundle.js"></script>

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


        <div class="hidden-xs hidden-sm study-edit-controls" id="fixed-study-edit-controls" style="position: fixed; top: 50%; transform: translateY(-50%); z-index: 100; opacity: 0; left:-205px">
            <div class="btn-group-vertical">
                <div>
                    <button type="button" class="btn btn-lg btn-default btn-shadow btn-cache-study" style="position: relative; float: right; border-radius: 0px; border-top-right-radius: 8px"><?php echo $lang->cache ?> <i class="fa fa-folder-open-o" style="margin-left: 15px"></i></button>
                </div>
                <div>
                    <button type="button" class="btn btn-lg btn-default btn-shadow btn-join-conversation" style="position: relative;  float: right; border-radius: 0px;"><?php echo $lang->joinConversation ?> <i class="fa fa-group" style="margin-left: 15px"></i></button>
                </div>
                <div>
                    <button type="button" class="btn btn-lg btn-default btn-shadow btn-leave-conversation hidden" style="position: relative;  float: right; border-radius: 0px;"><?php echo $lang->leaveConversation ?> 
                        <span style="margin-left: 15px">
                            <i class="fa fa-group"></i>
                            <i class="fa fa-ban" style="
                               font-size: 9pt;
                               position: absolute;
                               right: 9px;
                               top: 9px;"></i>
                        </span></button>
                </div>
                <div>
                    <button type="button" class="btn btn-lg btn-default btn-shadow btn-save-study" style="position: relative; float: right; border-radius: 0px; border-bottom-right-radius: 8px"><?php echo $lang->saveAndClose ?> <i class="fa fa-save" style="margin-left: 15px"></i></button>
                </div>
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
                    <li class="active" id="btn-new-extraction-study"><i class="fa fa-pencil"></i> <span class="btn-text"><?php echo $lang->breadcrump->createStudy ?></span></li>
                </ol>
            </div>
        </div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" data-backdrop="static" data-keyboard="false" role="dialog" data-conv-allowed="false">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content root">
                </div>
            </div>
        </div>

        <div class="container-fluid" id="creation-content" style="visibility: hidden; position: absolute; top: 30px; left: 0; width: 100%; height: auto; z-index: 101; padding-bottom: 20px;">
            <div style="background-color: white; width: 100%; height: 100%; display: block; position: relative"></div>

            <div id="overlay-content-placeholder"></div>
        </div>

        <div id="creation-content-background" style="visibility: hidden;position: fixed; background-color: rgba(255,255,255,1); top: 0px; left: 0; width: 100%; height: 100%; z-index: 100;"></div>


        <div class="container mainContent">

            <div class="alert-space alert-no-storage-api"></div>

            <ul class="nav nav-tabs" id="create-tab-navigation" style="margin-bottom: 20px">
                <li role="presentation"><a href="#generalData" role="tab" data-toggle="tab"><?php echo $lang->studyCreateNav->general ?></a></li>
                <li role="presentation" class="" id="tab-catalogs"><a href="#catalogs" role="tab" data-toggle="tab"><?php echo $lang->studyCreateNav->catalogs ?></a></li>
                <li role="presentation" class="disabledTab" id="tab-mapping"><a href="#mapping" role="tab" data-toggle="tab"><?php echo $lang->studyCreateNav->mapping ?></a></li>
                <li role="presentation" id="tab-introduction" class="pull-right"><a role="button"><i class="fa fa-support"></i> <?php echo $lang->help ?></a></li>
            </ul>

            <div id="loading-indicator" class="window-sized-loading text-center">
                <i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw"></i>
            </div>

            <div class="tab-content hidden" id="create-study-tab-content">

                <div role="tabpanel" class="tab-pane" id="generalData">

                    <!-- manner selections -->
                    <!--                    <form class="row" style="">
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
                    
                                        </form>-->

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

                    <!--                    <div id="from-To-datepicker" style="margin-top: 15px">
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
                                        </div>-->

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

                    <!--                    <div class="" id="scenes-catalog" style="margin-top: 40px">
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
                                        </div>-->
                    <!--</div>-->
                </div>






                <div role="tabpanel" class="tab-pane" id="mapping">
                    <div class="row">
                        <div class="col-sm-8 col-md-8" style="margin-bottom: 20px">
                            <div class="" id="mappingList"></div>
                            <!--<hr class="hidden-sm hidden-md hidden-lg" id="seperatorPhaseStepList" style="margin-bottom: 10px">-->
                        </div>



                        <div class="col-sm-4 col-md-4">
                            <div id="mappingSelect" style="position: fixed">
                                <!--<h4><?php echo $lang->questionnaires ?></h4>-->

                                <div class="add-button-group" id="">
                                    <div class="btn-group" >
                                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="mapping">
                                            <i class="fa fa-plus"></i> <?php echo $lang->formats->mapping->text ?>
                                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyExtractionCreate->mapping ?>"></i>
                                        </div>
                                    </div>
                                    <!--                                    <div class="btn-group" data-study-phase="evaluation" data-study-survey-type="all">
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
                                                                        </div>-->
                                </div>

<!--                                <h4 style="margin-top: 20px"><?php echo $lang->miscellaneous ?></h4>
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
                                    <div class="btn-group" data-study-phase="evaluation" data-study-survey-type="moderated">
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
                                    </div>-->
                                <!--</div>-->
                            </div>
                        </div>
                    </div>

                    <!--                    <div class="form-group-margin-top hidden root" id="mappingItem" style="">
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
                                                    <i class="fa"></i> <span class="phase-step-format"></span>
                                                </button>
                                            </div>
                                        </div>-->
                </div>

            </div>

            <div class="hidden-md hidden-lg study-edit-controls" id="btn-group-submit" style="z-index: 0; opacity: 0">
                <hr>

                <!-- submit form button group -->
                <div class="btn-group-vertical btn-block" role="group">
                    <!--<button type="button" class="btn btn-default btn-shadow disabled btn-preview-study"><i class="fa fa-eye"></i> <?php echo $lang->studyPreview ?></button>-->
                    <button type="button" class="btn btn-default btn-shadow btn-cache-study"><i class="fa fa-folder-open-o"></i> <?php echo $lang->cache ?></button>

                </div>
                <div class="btn-group-vertical btn-block" style="margin-top: 20px">
                    <button type="button" class="btn btn-default btn-shadow btn-save-study"><i class="fa fa-save"></i> <?php echo $lang->saveAndClose ?></button>
                </div>
            </div>

        </div>






        <div id="draggableCollaborativeRTC" class="hidden" style="position: fixed; z-index: 10002; top: 150px; left:100px; display: block; opacity: .7">
            <div style="width: 300px; border-radius: 8px" id="video-caller-container" class="shadow">
                <div class="embed-responsive embed-responsive-4by3" id="video-caller">

                    <div class="embed-responsive-item" style="border-radius: 8px; background-color: #eee; display: flex; justify-content: center; align-items: center;">
                        <i class="fa fa-circle-o-notch fa-spin fa-3x"></i>
                    </div>

                    <div id="remoteVideo" class="rtc-remote-container rtc-stream embed-responsive-item" style="border-radius: 8px;"></div>

                    <div class="rtc-local-container embed-responsive-item">
                        <video autoplay id="localVideo" class="rtc-stream" style="position: relative; height: auto"></video>
                    </div>

                    <div class="btn-group" id="stream-controls" style="position: absolute; bottom: 6px; left: 50%; transform: translate(-50%, 0); opacity: 0">
                        <button type="button" class="btn btn-sm stream-control" id="btn-stream-local-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->muteMicrofone ?>"><i class="fa fa-microphone-slash"></i> </button>
                        <button type="button" class="btn btn-sm stream-control" id="btn-pause-stream" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOwnWebRTC ?>"><i class="fa fa-pause"></i> </button>
                        <button type="button" class="btn btn-sm stream-control disabled" id="btn-stream-remote-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOtherWebRTC ?>"><i class="fa fa-volume-up"></i> </button>
                        <button type="button" class="btn btn-sm stream-control" id="btn-config-rtc" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->configRTC ?>"><i class="fa fa-cog"></i> </button>
                    </div>

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

            </div>

            <img src="img/resize-white.png" id="resize-sign" style="position: absolute; bottom: 0; right: 0;"/>
            <div id="btn-leave-room" class="" style="font-size: 14pt; position: absolute; top: -5px; right: 4px; cursor: pointer; color: white; text-shadow: 0px 0px 3px rgba(0, 0, 0, 1.0);"><i class="fa fa-close"></i></div>

        </div>

        <div id="mappingItem" class="root hidden panel panel-default panel-shadow">
            <div class="panel-heading">
                <div class="btn-group btn-group-sm btn-group-root" style="margin-right: 10px">
                    <button class="btn btn-default btn-shadow btn-up saveGeneralData" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->moveUp ?>"><i class="fa fa-arrow-up"></i></button>
                    <button class="btn btn-default btn-shadow btn-down saveGeneralData" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->moveDown ?>"><i class="fa fa-arrow-down"></i></button>
                    <button class="btn btn-default btn-shadow btn-delete saveGeneralData" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->delete ?>"><i class="fa fa-trash"></i></button>
                </div>
                <span><?php echo $lang->formats->mapping->text ?> <span class="badgeId">0</span> <?php echo $lang->of ?> <span class="badgeQuantity">0</span></span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label><?php echo $lang->trigger ?></label>
                            <div class="input-group" id="gesture-trigger">
                                <input class="form-control item-input-text option-trigger show-dropdown" tabindex="-1" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                                <div class="input-group-btn select triggerSelect" role="group">
                                    <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                    <ul class="dropdown-menu option dropdown-menu-right" role="menu"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label><?php echo $lang->gesture ?></label>
                            <div class="input-group">
                                <!--<span class="input-group-addon"></span>-->
                                <input class="form-control item-input-text option-gesture show-dropdown" tabindex="-1" type="text" value=""/>
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
        </div>

        <script>
            var firstInit = false;
            var jumpToId = null;

            $(document).ready(function () {
                firstInit = true;
                checkDomain();
                keepSessionAlive();

                checkLanguage(function () {
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


            // fixed buttons tweening

            var cacheButton = $('#fixed-study-edit-controls .btn-cache-study');
            var cacheButtonTimeline = new TimelineMax({paused: true, onStart: function () {
                    $(cacheButton).css({borderBottomRightRadius: '8px'});
                    $(cacheButton).addClass('btn-primary');
                }, onReverseComplete: function () {
                    $(cacheButton).css({borderBottomRightRadius: '0px'});
                    $(cacheButton).removeClass('btn-primary');
                }});

            cacheButtonTimeline.add("cacheStudy", 0)
                    .to(cacheButton, .3, {left: +173, ease: Quad.easeInOut}, "cacheStudy");

            $(cacheButton).unbind('mouseenter').bind('mouseenter', function (event) {
                event.preventDefault();
                cacheButtonTimeline.play();
            });

            $(cacheButton).unbind('mouseleave').bind('mouseleave', function (event) {
                event.preventDefault();
                cacheButtonTimeline.reverse();
            });


            var saveStudyButton = ('#fixed-study-edit-controls .btn-save-study');
            var saveButtonTimeline = new TimelineMax({paused: true, onStart: function () {
                    $(saveStudyButton).css({borderTopRightRadius: '8px'});
                    $(saveStudyButton).addClass('btn-primary');
                }, onReverseComplete: function () {
                    $(saveStudyButton).css({borderTopRightRadius: '0px'});
                    $(saveStudyButton).removeClass('btn-primary');
                }});

            saveButtonTimeline.add("saveStudy", 0)
                    .to(saveStudyButton, .3, {left: +192, ease: Quad.easeInOut}, "saveStudy");

            $(saveStudyButton).unbind('mouseenter').bind('mouseenter', function (event) {
                event.preventDefault();
                saveButtonTimeline.play();
            });

            $(saveStudyButton).unbind('mouseleave').bind('mouseleave', function (event) {
                event.preventDefault();
                saveButtonTimeline.reverse();
            });


            var joinConversationButton = $('#fixed-study-edit-controls .btn-join-conversation');
            var conversationButtonTimeline = new TimelineMax({paused: true, onStart: function () {
                    $(joinConversationButton).css({borderBottomRightRadius: '8px', borderTopRightRadius: '8px'});
                    $(joinConversationButton).addClass('btn-primary');
                }, onReverseComplete: function () {
                    $(joinConversationButton).css({borderBottomRightRadius: '0px', borderTopRightRadius: '0px'});
                    $(joinConversationButton).removeClass('btn-primary');
                }});

            conversationButtonTimeline.add("saveStudy", 0)
                    .to(joinConversationButton, .3, {left: +202, ease: Quad.easeInOut}, "saveStudy");

            $(joinConversationButton).unbind('mouseenter').bind('mouseenter', function (event) {
                event.preventDefault();
                conversationButtonTimeline.play();
            });

            $(joinConversationButton).unbind('mouseleave').bind('mouseleave', function (event) {
                event.preventDefault();
                conversationButtonTimeline.reverse();
            });


            var leaveConversationButton = $('#fixed-study-edit-controls .btn-leave-conversation');
            var leaveConversationButtonTimeline = new TimelineMax({paused: true, onStart: function () {
                    $(leaveConversationButton).css({borderBottomRightRadius: '8px', borderTopRightRadius: '8px'});
                    $(leaveConversationButton).addClass('btn-danger');
                }, onReverseComplete: function () {
                    $(leaveConversationButton).css({borderBottomRightRadius: '0px', borderTopRightRadius: '0px'});
                    $(leaveConversationButton).removeClass('btn-danger');
                }});

            leaveConversationButtonTimeline.add("saveStudy", 0)
                    .to(leaveConversationButton, .3, {left: +203, ease: Quad.easeInOut}, "saveStudy");

            $(leaveConversationButton).unbind('mouseenter').bind('mouseenter', function (event) {
                event.preventDefault();
                leaveConversationButtonTimeline.play();
            });

            $(leaveConversationButton).unbind('mouseleave').bind('mouseleave', function (event) {
                event.preventDefault();
                leaveConversationButtonTimeline.reverse();
            });


            $(joinConversationButton).unbind('click').bind('click', function (event) {
                event.preventDefault();
                var query = getQueryParams(document.location.search);
                initCollaborativeVideoCaller('study' + query.studyId);
            });

            $(leaveConversationButton).unbind('click').bind('click', function (event) {
                event.preventDefault();
                leaveCollaborativeVideoCaller();
            });





            // rendering

            var editableStudyId = null;
            var studyEditable = false;
            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
                var query = getQueryParams(document.location.search);
                var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                if (query.studyId && query.h === hash) {
                    studyEditable = true;
                    editableStudyId = query.studyId;
                    $('#btn-study').parent().removeClass('hidden');
                    $('#btn-new-study').find('.btn-text').text('Bearbeiten');
                    $('.btn-study').removeClass('hidden');

//                    if (getLocalItem(STUDY)) {
//                        init();
//                    } else {
                        getStudyById({studyId: query.studyId}, function (result) {
                            if (result.status === RESULT_SUCCESS) {
                                setStudyData(result);
                                init();
                            }
                        });
//                    }
                } else if (query.edit && (query.edit === true || query.edit === "true") && query.studyId) {
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
                checkSessionStorage();

                var status = window.location.hash.substr(1);
                var statusNavMatch = getStatusNavMatch(status);
                if (status !== '' && statusNavMatch !== null) {
                    $('#create-tab-navigation').find('#tab-' + statusNavMatch + ' a').click();
                } else {
                    $('#create-tab-navigation').children().first().find('a').click();
                }

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
                updateAssembledData();
            });



            // add mapping items

            $('#mappingSelect').on('change', function (event) {
                addMapping(chance.natural(), true, function () {
                    saveMapping();
                    updateAssembledData();
                });

                var tweenTargetOffset = $('#mappingList').children().last().offset();
                var tweenElementOffset = $(event.target).offset();
                var tweenOffset = {offsetY: tweenTargetOffset.top - tweenElementOffset.top, offsetX: tweenTargetOffset.left - tweenElementOffset.left};
                var alphaY = tweenOffset.offsetY < 0 ? '' + tweenOffset.offsetY : '+' + tweenOffset.offsetY;
                var alphaX = tweenOffset.offsetX < 0 ? '' + tweenOffset.offsetX : '+' + tweenOffset.offsetX;
                TweenMax.to($(event.target), .3, {x: alphaX, y: alphaY, opacity: 0, clearProps: 'all', ease: Quad.easeIn, onComplete: onMovePhaseStepComplete});
            });

            function onMovePhaseStepComplete() {
                $('#mappingList').trigger('listItemAdded');
            }

            $('#mappingList').unbind('listItemAdded').bind('listItemAdded', function (event) {
                event.preventDefault();
                var scrollTarget = $(event.target).children().last();
                var newScrollTop = Math.max(0, $(scrollTarget).offset().top);
                $('html, body').animate({
                    scrollTop: newScrollTop
                }, 400);
            });

            $('#mappingList').unbind('change').bind('change', function (event) {
                saveMapping();
            });

            function addMapping(id, animate, callback) {
                var clone = $('#mappingItem').clone().removeAttr('id');
                clone.removeClass('hidden').attr('id', 'mapping');
                clone.removeClass('hidden').attr('data-id', id);

//                if (format === THANKS || format === LETTER_OF_ACCEPTANCE) {
//                    clone.find('.btn-delete, .btn-up, .btn-down').remove();
//                } else {
                clone.find('.btn-delete').bind("click", {id: id}, function (event) {
                    event.preventDefault();
                });

//                    switch (format) {
//                        case SUS:
//                            setLocalItem(id + ".data", translation.sus);
//                            break;
//                        case FAVORITE_GESTURES:
//                            setLocalItem(id + ".data", translation.favoriteGesturesQuestionnaire);
//                            break;
//                    }
//                }

//                if (prependItem && prependItem === true) {
//                    setTimeout(function () {
//                        $(clone).insertBefore($('#mappingList').children().last());
//                        initPopover();
//                        checkCurrentListState($('#mappingList'));
//                        if (callback) {
//                            callback();
//                        }
//                    }, 300);
//                } else {
                $('#mappingList').append(clone);
                initPopover();
                checkCurrentListState($('#mappingList'));
                updateBadges($('#mappingList'), 'mapping');
                if (callback) {
                    callback(clone);
                }
//                }

                if (animate === true) {
                    TweenMax.from(clone, 1.2, {y: -50, opacity: 0, delay: .3, ease: Elastic.easeOut});
                }
            }
////
////            $('#phaseSelect').on('change', function (event) {
////                event.preventDefault();
////
////                var catalogsNav = $('#create-tab-navigation #tab-catalogs');
////                var phasesNav = $('#create-tab-navigation #tab-phases');
////                if ($(phasesNav).hasClass('disabledTab') && $(catalogsNav).hasClass('disabledTab')) {
////                    $(phasesNav).removeClass('disabledTab');
////                    $(catalogsNav).removeClass('disabledTab');
////                    if (firstInit) {
////                        firstInit = false;
////                        TweenMax.to(catalogsNav, .1, {y: -20});
////                        TweenMax.to(catalogsNav, .5, {delay: .1, y: 0, ease: Bounce.easeOut});
////                        TweenMax.to(phasesNav, .1, {delay: .1, y: -20});
////                        TweenMax.to(phasesNav, .5, {delay: .2, y: 0, ease: Bounce.easeOut});
////                    }
////                }
////
////                checkSelectedGeneralStudyProperties();
////                saveGeneralData();
////                renderPhaseSteps();
////            });
////
////            $('#surveyTypeSelect').on('change', function (event) {
////                event.preventDefault();
////                checkSelectedGeneralStudyProperties();
////                saveGeneralData();
////                renderPhaseSteps();
////            });
//
//            function checkSelectedGeneralStudyProperties() {
//                var phaseId = $('#phaseSelect').find('.btn-option-checked').attr('id');
//                if (phaseId === TYPE_PHASE_ELICITATION || phaseId === TYPE_PHASE_EXTRACTION) {
//                    $('#surveyTypeSelect').find('#unmoderated').addClass('disabled');
//                    if ($('#surveyTypeSelect').find('.btn-option-checked').attr('id') === 'unmoderated') {
//                        $('#surveyTypeSelect').find('#moderated').click();
//                    }
//                } else {
//                    $('#surveyTypeSelect').find('#unmoderated').removeClass('disabled');
//                }
//
//                var surveyTypeId = $('#surveyTypeSelect').find('.btn-option-checked').attr('id');
//
//                var addPhaseButtons = $('#phaseStepSelect').find('.btn-group');
//                for (var i = 0; i < addPhaseButtons.length; i++) {
//                    var button = addPhaseButtons[i];
//                    if (($(button).attr('data-study-phase') === phaseId || $(button).attr('data-study-phase') === 'all') && ($(button).attr('data-study-survey-type') === surveyTypeId || $(button).attr('data-study-survey-type') === 'all')) {
//                        $(button).removeClass('hidden');
//                    } else {
//                        $(button).addClass('hidden');
//                    }
//                }
//            }

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
                    $('#fixed-study-edit-controls').find('.btn-save-study').click();
                });
            });

            $('body').on('click', '.main-burger-menu li a', function (event) {
                var button = $(this);
                event.stopImmediatePropagation();
                var clickedId = $(button).parent().attr('data-id');
                jumpToId = clickedId;
                loadHTMLintoModal('custom-modal', 'externals/modal-delete-data.php', 'modal-md');

                $('#custom-modal').unbind('saveDataClose').bind('saveDataClose', function () {
                    $('#fixed-study-edit-controls').find('.btn-save-study').click();
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
                        goto("extraction-study.php?studyId=" + editableStudyId + "&h=" + hash + "&joinedConv=" + joinedRoom + getWebRTCSources());
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

//            $('.btn-preview-study').click(function (event) {
//                event.preventDefault();
//                if (checkInputs() === true && !$(this).hasClass('disabled')) {
//                    saveGeneralData();
//                    if (studyEditable === true) {
//                        goto("study-preview.php?edit=true&studyId=" + editableStudyId + "&joinedConv=" + joinedRoom + "&view=moderator" + getWebRTCSources());
//                    } else {
//                        gotoCreateStudyPreview();
//                    }
//                } else {
//                    $('#create-tab-navigation').children().first().find('a').click();
//                }
//            });

            $('.btn-save-study').click(function (event) {
                event.preventDefault();
                if (checkInputs() === true) {
                    var button = $(this);
//                    $('.btn-preview-study').addClass('disabled');
                    saveGeneralData();
                    showCursor($('body'), CURSOR_POINTER);
                    if (studyEditable === true) {
                        var updateData = getExtractionStudyData();
                        updateData.studyId = editableStudyId;
                        updateStudy(updateData, function (result) {
                            showCursor($('body'), CURSOR_DEFAULT);
                            $(button).removeClass('disabled');
                            $('.btn-cache-study').removeClass('disabled');
                            if (result.status === RESULT_SUCCESS) {
                                clearLocalItems();

                                if (jumpToId !== null) {
                                    checkJumpId();
                                } else {
                                    var hash = hex_sha512(parseInt(result.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                                    goto("extraction-study.php?studyId=" + result.studyId + "&h=" + hash + "&joinedConv=" + joinedRoom + getWebRTCSources());
                                }
                            }
                        });
                    } else {
                        saveStudy(getExtractionStudyData(), function (result) {
                            showCursor($('body'), CURSOR_DEFAULT);
                            $(button).removeClass('disabled');
                            $('.btn-cache-study').removeClass('disabled');
                            if (result.status === RESULT_SUCCESS) {
                                clearLocalItems();

                                if (jumpToId !== null) {
                                    checkJumpId();
                                } else {
                                    var hash = hex_sha512(parseInt(result.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                                    goto("extraction-study.php?studyId=" + result.studyId + "&h=" + hash + "&joinedConv=" + joinedRoom + getWebRTCSources());
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
                    $('.btn-save-study').addClass('disabled');
                    saveGeneralData();
                    showCursor($('body'), CURSOR_POINTER);
                    lockButton(button, true, 'fa-save');
                    if (studyEditable === true) {
                        var updateData = getExtractionStudyData();
                        updateData.studyId = editableStudyId;
                        updateStudy(updateData, function (result) {
                            showCursor($('body'), CURSOR_DEFAULT);
                            $(button).removeClass('disabled');
                            $('.btn-save-study').removeClass('disabled');
                            unlockButton(button, true, 'fa-save');
//                            if (result.status === RESULT_SUCCESS) {
////                                clearLocalItems();
////                                var hash = hex_sha512(parseInt(result.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
////                                goto("study.php?studyId=" + result.studyId + "&h=" + hash);
//                            } else {
//                                //                            appendAlert()
//                            }
                        });
                    } else {
                        saveStudy(getExtractionStudyData(), function (result) {
                            showCursor($('body'), CURSOR_DEFAULT);
                            $(button).removeClass('disabled');
                            $('.btn-save-study').removeClass('disabled');
                            unlockButton(button, true, 'fa-save');
                            if (result.status === RESULT_SUCCESS) {
                                clearLocalItems();
                                var hash = hex_sha512(parseInt(result.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                                goto("extraction-create.php?studyId=" + result.studyId + "&h=" + hash + "&joinedConv=" + joinedRoom + getWebRTCSources());
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

                return errors === 0;
            }

            function resetErrors() {
                $('#studyTitle').closest('.form-group').removeClass('has-error');
                $('#studyDescription').closest('.form-group').removeClass('has-error');
            }

            $('#create-tab-navigation').on('show.bs.tab', function (event) {
//                console.log($(event.target).attr('href'));
                if($(event.target).attr('href') === '#mapping') {
                    renderMapping();
                }
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

                $('#custom-modal').attr('data-help-items-key', 'introductionCreateExtractionStudy');
                $('#custom-modal').attr('data-help-context', 'studyExtractionCreation');
                $('#custom-modal').attr('data-help-show-tutorial', parseInt(<?php echo $_SESSION['tutorialStudyExtractionCreation'] ?>));
                loadHTMLintoModal('custom-modal', 'externals/modal-introduction.php', 'modal-lg');
            });


            var overlayTween = new TimelineMax({paused: true, onReverseComplete: onReverseComplete});
            overlayTween.add("parallel")
                    .to($('.sub-page-header'), .3, {autoAlpha: 0}, 'parallel')
                    .to($('.mainContent'), .3, {autoAlpha: 0}, 'parallel')
                    .to($('#breadcrumb'), .3, {autoAlpha: 0}, 'parallel')
                    .to($('#creation-content'), .3, {autoAlpha: 1}, 'parallel')
                    .to($('#fixed-study-edit-controls'), .2, {autoAlpha: 0, x: -20}, 'parallel');

            $(document).on('click', '.btn-open-overlay', function (event) {
                event.preventDefault();
                var button = $(this);
                lockButton(button, true);
                $(button).popover('hide');
                var deleteButton = $(button).parent().find('.btn-delete');
                lockButton(deleteButton);


                setTimeout(function () {
                    var format = $(button).attr('id');
                    var id = $(button).closest('.root').attr('id');
                    if (format && id) {
                        initOverlayContent(format, id);
                    } else if (format) {
                        initOverlayContentByFormat(format);
                    }
                    overlayTween.play();
                    unlockButton(button, true);
                    unlockButton(deleteButton);

                    $('html,body').animate({
                        scrollTop: 0
                    }, 200);
                    $('.mainContent').addClass('hidden');
                }, 200);
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
        </script>

    </body>
</html>