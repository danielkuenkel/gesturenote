<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

session_start();
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/study-create.css">
        <link rel="stylesheet" href="css/gesture.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="js/bootstrap-datepicker/css/bootstrap-datepicker3.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
        <link rel="stylesheet" href="js/bootstrap-slider/css/bootstrap-slider.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.4.4/randomColor.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>
        <script src="js/chance.min.js"></script>
        <script src="js/filesaver/FileSaver.min.js"></script>
        <script src="js/gifshot/gifshot.min.js"></script>
        <script src="js/color-thief/color-thief.js"></script> 

        <script src="js/bootstrap-slider/js/bootstrap-slider.js"></script>
        <script src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.ar.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.az.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.bg.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.bs.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.ca.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.cs.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.cy.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.da.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.de.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.el.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.en-GB.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.et.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.eu.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.fa.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.fi.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.fo.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.fr.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.fr-CH.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.gl.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.he.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.hr.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.hu.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.hy.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.id.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.is.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.it.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.it-CH.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.ja.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.ka.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.kh.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.kk.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.kr.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.lt.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.lv.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.mk.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.ms.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.nb.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.nl.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.nl-BE.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.no.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.pt.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.ro.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.rs.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.rs-latin.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.ru.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.sk.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.sl.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.sq.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.sr.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.sr-latin.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.sv.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.sw.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.tr.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.uk.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.vi.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-CN.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-TW.min.js" charset="UTF-8"></script>

        <script src="js/sha512.js"></script>
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

        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb" style="padding-top: 40px">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-studies"><i class="fa fa-tasks" aria-hidden="true"></i> <?php echo $lang->breadcrump->studies ?></a></li>
                    <li class="hidden"><a class="breadcrump-btn" id="btn-study"><?php echo $lang->breadcrump->study ?></a></li>
                    <li class="active"><?php echo $lang->breadcrump->createStudy ?></li>
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

        <div class="container-fluid" id="creation-content" style="visibility: hidden;position: absolute; top: 0px; left: 0; width: 100%; height: auto; z-index: 101; padding-top: 110px; padding-bottom: 80px;">
            <div style="background-color: white; width: 100%; height: 100%; display: block; position: relative"></div>

            <div id="overlay-content-placeholder"></div>
        </div>

        <div id="creation-content-background" style="visibility: hidden;position: fixed; background-color: rgba(255,255,255,0.9); top: 0px; left: 0; width: 100%; height: 100%; z-index: 100;"></div>


        <div class="container mainContent">

            <div class="alert-space alert-no-storage-api"></div>

            <ul class="nav nav-tabs" id="create-tab-navigation" style="margin-bottom: 20px">
                <li role="presentation"><a href="#generalData" role="tab" data-toggle="tab"><?php echo $lang->studyCreateNav->general ?></a></li>
                <li role="presentation" class="disabledTab" id="tab-catalogs"><a href="#catalogs" role="tab" data-toggle="tab"><?php echo $lang->studyCreateNav->catalogs ?></a></li>
                <li role="presentation" class="disabledTab" id="tab-phases"><a href="#phases" role="tab" data-toggle="tab"><?php echo $lang->studyCreateNav->phases ?></a></li>
                <li role="presentation" id="tab-introduction" class="pull-right"><a role="button"><i class="fa fa-support"></i> <?php echo $lang->help ?></a></li>
            </ul>

            <div id="loading-indicator" class="text-center" style="margin-top: 10px; margin: 0 auto">
                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
            </div>

            <div class="tab-content" id="create-study-tab-content">

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
                        <div class="input-daterange row" id="datepicker">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $lang->studyRunsFrom ?></label>
                                    <div class="input-group">
                                        <input type="text" class="input form-control readonly" id="start" name="start" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" id="btn-show-datepicker-from" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $lang->studyRunsTo ?></label>
                                    <div class="input-group">
                                        <input type="text" class="input form-control readonly" id="end" name="end" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" id="btn-show-datepicker-to" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!--                    <div class="panel panel-default">
                    
                                            <div class="panel-body" id="panelSurveySwitch" style="padding-top: 0px;">
                                                <div class="form-inline">
                                                    <div class="form-group form-group-no-margin root" style="margin-right: 20px; margin-top: 15px;">
                                                        <label>
                    <?php echo $lang->panelSurvey ?> 
                                                            <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text4 ?>"></i>
                                                        </label><br/>
                    
                                                        <div class="btn-group" id="radio" style="margin: 0">
                                                            <button class="btn btn-default btn-radio btn-option-checked saveGeneralData" name="primary" id="no">
                                                                <span id="icons" style="margin-right: 6px">
                                                                    <i class="fa fa-circle-thin hidden" id="normal"></i>
                                                                    <i class="fa fa-circle hidden" id="over"></i>
                                                                    <i class="fa fa-check-circle" id="checked"></i>
                                                                </span>
                                                                <span class="option-text"><?php echo $lang->no ?></span>
                                                            </button>
                                                        </div>
                                                        <div class="btn-group" id="radio" style="margin: 0">
                                                            <button class="btn btn-default btn-radio saveGeneralData" name="primary" id="yes">
                                                                <span id="icons" style="margin-right: 6px">
                                                                    <i class="fa fa-circle-thin" id="normal"></i>
                                                                    <i class="fa fa-circle hidden" id="over"></i>
                                                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                                                </span>
                                                                <span class="option-text"><?php echo $lang->yes ?></span>
                                                            </button>
                                                        </div>
                                                    </div>
                    
                                                    <div class="form-group form-group-no-margin hidden" id="selectedAgeRange" style="margin-top: 15px;">
                                                        <label>
                    <?php echo $lang->selection ?> 
                                                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text4 ?>"></i>
                                                        </label> <br/>
                                                        <div class="text" style="padding-top: 3px; padding-bottom: 4px"></div>
                                                    </div>
                                                </div>
                    
                                            </div>-->
                    <!--                        <hr style="margin: 0">
                                            <div class="panel-body hidden" id="panel-survey-container" style="padding-top: 0px">
                                                <div class="form-inline">
                                                    <div class="form-group form-group-no-margin root" id="genderSwitch" style="margin-right: 20px;margin-top: 15px">
                                                        <label>
                    <?php echo $lang->gender ?> 
                                                            <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text4 ?>"></i>
                                                        </label><br/>
                                                        <div class="btn-group" id="radio" style="margin: 0">
                                                            <button class="btn btn-default btn-radio btn-option-checked saveGeneralData" name="primary" id="female">
                                                                <span id="icons" style="margin-right: 6px">
                                                                    <i class="fa fa-circle-thin hidden" id="normal"></i>
                                                                    <i class="fa fa-circle hidden" id="over"></i>
                                                                    <i class="fa fa-check-circle" id="checked"></i>
                                                                </span>
                                                                <span class="option-text"><?php echo $lang->genderTypes->female ?></span>
                                                            </button>
                                                        </div>
                                                        <div class="btn-group" id="radio" style="margin: 0">
                                                            <button class="btn btn-default btn-radio saveGeneralData" name="primary" id="male">
                                                                <span id="icons" style="margin-right: 6px">
                                                                    <i class="fa fa-circle-thin" id="normal"></i>
                                                                    <i class="fa fa-circle hidden" id="over"></i>
                                                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                                                </span>
                                                                <span class="option-text"><?php echo $lang->genderTypes->male ?></span>
                                                            </button>
                                                        </div>
                                                        <div class="btn-group" id="radio" style="margin: 0">
                                                            <button class="btn btn-default btn-radio saveGeneralData" name="primary" id="identical">
                                                                <span id="icons" style="margin-right: 6px">
                                                                    <i class="fa fa-circle-thin" id="normal"></i>
                                                                    <i class="fa fa-circle hidden" id="over"></i>
                                                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                                                </span>
                                                                <span class="option-text"><?php echo $lang->genderTypes->identical ?></span>
                                                            </button>
                                                        </div>
                                                    </div>
                    
                                                    <div class="form-group" id="ageSlider" style="margin-top: 15px">
                                                        <label id="age-label">
                    <?php echo $lang->age ?> <span class="age-text"></span> <span><i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text4 ?>"></i></span>
                                                        </label><br/>
                                                        <div style="padding-top: 3px; padding-bottom: 4px">
                                                            <span class="slider-from text"><?php echo $lang->of ?></span>
                                                            <input class="custom-range-slider saveGeneralData" type="text" value="" data-slider-step="1"/>
                                                            <span class="slider-to text"><?php echo $lang->to ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>-->

                    <!--</div>-->
                </div>




                <div role="tabpanel" class="tab-pane" id="catalogs">

                    <div class="row">
                        <div class="col-md-12" id="gestures-catalog">
                            <div style="display: inline">
                                <h4 style="display:inline-block; padding-right: 10px; position: relative; top:2px"><?php echo $lang->studyGestures ?> 
                                    <i class="fa fa-info-circle btn-show-info" for="studyDescription" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->catalogGestures ?>"></i>
                                </h4>
                                <div class="btn-group">
                                    <button style="display:inline-block" class="btn btn-default btn-shadow btn-open-overlay" id="catalog-gestures">
                                        <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->open ?></span>
                                    </button>
                                    <button class="btn btn-default btn-shadow disabled" id="btn-download-as-json" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->downloadAsJSON ?>"><i class="fa fa-download"></i></button>
                                </div>
                            </div>

                            <div style="margin-top: 10px" class="row" id="gestures-list-container"></div>
                            <div class="alert-space alert-no-phase-data"></div>
                        </div>

                        <div class="col-md-6" id="trigger-catalog" style="margin-top: 20px">
                            <div style="display: inline">
                                <h4 style="display:inline-block; padding-right: 10px; position: relative; top:2px"><?php echo $lang->triggers ?> 
                                    <i class="fa fa-info-circle btn-show-info" for="studyDescription" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->catalogTrigger ?>"></i>
                                </h4>
                                <button style="display:inline-block" class="btn btn-default btn-shadow btn-open-overlay" id="catalog-trigger">
                                    <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->open ?></span>
                                </button>
                            </div>

                            <div class="list-container"></div>
                            <div class="alert-space alert-no-phase-data" style="margin-top: 10px"></div>
                        </div>

                        <div class="col-md-6" id="feedback-catalog" style="margin-top: 20px">
                            <div style="display: inline">
                                <h4 style="display:inline-block; padding-right: 10px; position: relative; top:2px"><?php echo $lang->feedback ?> 
                                    <i class="fa fa-info-circle btn-show-info" for="studyDescription" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->catalogFeedback ?>"></i>
                                </h4>
                                <button style="display:inline-block" class="btn btn-default btn-shadow btn-open-overlay" id="catalog-feedback">
                                    <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->open ?></span>
                                </button>
                            </div>

                            <div class="list-container"></div>
                            <div class="alert-space alert-no-phase-data" style="margin-top: 10px"></div>
                        </div>

                        <div class="col-md-12" id="scenes-catalog" style="margin-top: 20px">
                            <div style="display: inline">
                                <h4 style="display:inline-block; padding-right: 10px; position: relative; top:2px"><?php echo $lang->scenes ?> 
                                    <i class="fa fa-info-circle btn-show-info" for="studyDescription" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->catalogScenes ?>"></i>
                                </h4>
                                <button style="display:inline-block" class="btn btn-default btn-shadow btn-open-overlay" id="catalog-scenes">
                                    <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->open ?></span>
                                </button>
                            </div>

                            <div class="list-container"></div>
                            <div class="alert-space alert-no-phase-data" style="margin-top: 10px"></div>
                        </div>
                    </div>
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
                                    <div class="btn-group" data-study-phase="all" data-study-survey-type="moderated">
                                        <div class="btn btn-info btn-add-item btn-shadow font-bold" id="interview">
                                            <i class="fa fa-plus"></i> <?php echo $lang->formats->interview->text ?>
                                            <i class="fa fa-info-circle btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->studyCreate->interview ?>"></i>
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
                            <button class="btn btn-default btn-shadow btn-up saveGeneralData" title="<?php echo $lang->furtherUp ?>">
                                <i class="glyphicon glyphicon-arrow-up"></i>
                            </button>
                            <button class="btn btn-default btn-shadow btn-down saveGeneralData" title="<?php echo $lang->furtherDown ?>">
                                <i class="glyphicon glyphicon-arrow-down"></i>
                            </button>
                            <button class="btn btn-default btn-shadow btn-delete saveGeneralData" title="<?php echo $lang->delete ?>">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                            <button class="btn btn-default btn-shadow btn-text-button btn-open-overlay">
                                <span class="phase-step-format"></span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <div  id="btn-group-submit" style="z-index: 0">
                <hr>

                <!-- submit form button group -->
                <div class="btn-group-vertical btn-block" role="group">
                    <button type="button" class="btn btn-default btn-shadow disabled" id="btn-preview-study"><i class="glyphicon glyphicon-eye-open"></i> <?php echo $lang->studyPreview ?></button>
                    <button type="button" class="btn btn-success btn-shadow" id="btn-save-study"><i class="fa fa-save"></i> <?php echo $lang->saveAndClose ?></button>
                </div>
            </div>

        </div>


        <script>
            var firstInit = false;
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
                    externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    externals.push(['#template-gesture-recorder', PATH_EXTERNALS + 'template-gesture-recorder.php']);
                    loadExternals(externals);
                });
            });

            var editableStudyId = null;
            var studyEditable = false;
            function onAllExternalsLoadedSuccessfully() {
                initTooltips();
                initPopover();

                renderSubPageElements();
                var query = getQueryParams(document.location.search);
                var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                if (query.studyId && query.h === hash) {
                    $('#btn-clear-data').remove();
                    studyEditable = true;
                    editableStudyId = query.studyId;
                    $('#btn-study').parent().removeClass('hidden');

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
                    $('#btn-clear-data').remove();
                    init();
                    studyEditable = true;
                    editableStudyId = query.studyId;
                    $('#btn-study').parent().removeClass('hidden');
                } else {
                    init();
                    studyEditable = false;
                    editableStudyId = null;
                }
            }

            function init() {
                $('#from-To-datepicker .input-daterange').datepicker({
                    calendarWeeks: true,
                    todayHighlight: true,
                    todayBtn: true,
                    clearBtn: true,
                    daysOfWeekHighlighted: "0,6",
                    language: currentLanguage


                });
                $('#from-To-datepicker .input-daterange').on("changeDate", function () {
                    saveGeneralData();
                });
                $('#from-To-datepicker .input-daterange input').on("clearDate", function () {
                    saveGeneralData();
                });
//                getAgeRange(function (result) {
//                    if (result.status === RESULT_SUCCESS) {
//                        if (result.tester && result.tester.length > 0) {
//                            var ageRange = calculateAgeRangeForGender(result.tester, 'identical');
//                            var data = {min: ageRange.min, max: ageRange.max, raw: result.tester};
//                            data.availableGender = getAvailableGender(result.tester);
//                            setLocalItem(STUDY_PANEL, data);
//                        }
//
//                        initAfterAgeRange();
//                    } else {
//                        // error handling
//                        initAfterAgeRange();
//                    }
//                });
//
//                function initAfterAgeRange() {
                checkSessionStorage();

                var status = window.location.hash.substr(1);
                var statusNavMatch = getStatusNavMatch(status);
                if (status !== '' && statusNavMatch !== null) {
                    $('#create-tab-navigation').find('#tab-' + statusNavMatch + ' a').click();
                } else {
                    $('#create-tab-navigation').children().first().find('a').click();
                }
                $('#loading-indicator').remove();

                var showTutorial = parseInt(<?php echo $_SESSION['tutorialStudyCreation'] ?>);
                if (showTutorial === 1) {
                    $('#tab-introduction a').click();
                }
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
                    $('#btn-preview-study').removeClass('disabled');
                } else {
                    $('#btn-preview-study').addClass('disabled');
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
                        checkCurrentListState($('#phaseStepList'));
                        if (callback) {
                            callback();
                        }
                    }, 300);
                } else {
                    $('#phaseStepList').append(clone);
                    checkCurrentListState($('#phaseStepList'));
                    if (callback) {
                        callback();
                    }
                }

                if (animate === true) {
                    //                    console.log(clone);
                    TweenMax.from(clone, 1.2, {y: -50, opacity: 0, delay: .3, ease: Elastic.easeOut});
                    //                    TweenMax.from(clone, .3, {opacity: 0, y: -20, clearProps: 'all'});
                }
            }

//            $('#panelSurveySwitch').on('change', function (event, id) {
//                event.preventDefault();
//                if ($(event.target).attr('id') === 'yes') {
//                    $('#panel-survey-container').removeClass('hidden');
//                    $('#selectedAgeRange').removeClass('hidden');
//                } else {
//                    $('#panel-survey-container').addClass('hidden');
//                    $('#selectedAgeRange').addClass('hidden');
//                }
//            });

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
                loadHTMLintoModal('custom-modal', 'externals/modal-delete-data.php', 'modal-sm');
                $('#custom-modal').unbind('deleteData').bind('deleteData', function () {
                    if ($(button).attr('id') === 'btn-study') {
                        var hash = hex_sha512(parseInt(editableStudyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                        goto("study.php?studyId=" + editableStudyId + "&h=" + hash);
                    } else {
                        $(button).unbind('click').click();
                    }

                    clearSceneImages();
                    clearSounds();
                    clearLocalItems();
                });
            });

            $('#btn-clear-data').click(function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    clearSceneImages();
                    clearSounds();
                    clearLocalItems();
                    location.reload(true);
                }
            });

            $('#btn-preview-study').click(function (event) {
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

            $('#btn-save-study').click(function (event) {
                event.preventDefault();
                if (checkInputs() === true) {
                    var button = $(this);
                    $('#btn-clear-data, #btn-preview-study').addClass('disabled');
                    saveGeneralData();
                    showCursor($('body'), CURSOR_POINTER);
                    if (studyEditable === true) {
                        var updateData = getStudyData();
                        updateData.studyId = editableStudyId;
                        updateStudy(updateData, function (result) {
                            showCursor($('body'), CURSOR_DEFAULT);
                            $(button).removeClass('disabled');
                            $('#btn-clear-data, #btn-preview-study').removeClass('disabled');
                            if (result.status === RESULT_SUCCESS) {
                                clearLocalItems();
                                var hash = hex_sha512(parseInt(result.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                                goto("study.php?studyId=" + result.studyId + "&h=" + hash);
                            } else {
                                //                            appendAlert()
                            }
                        });
                    } else {
                        saveStudy(getStudyData(), function (result) {
                            showCursor($('body'), CURSOR_DEFAULT);
                            $(button).removeClass('disabled');
                            $('#btn-clear-data, #btn-preview-study').removeClass('disabled');
                            if (result.status === RESULT_SUCCESS) {
                                clearLocalItems();
                                var hash = hex_sha512(parseInt(result.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                                goto("study.php?studyId=" + result.studyId + "&h=" + hash);
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
                console.log(activeTab);

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
                    .to($('.mainContent'), .3, {webkitFilter: "blur(5px)", filter: "blur(5px)"}, 'parallel')
                    .to($('#breadcrumb'), .3, {webkitFilter: "blur(5px)", filter: "blur(5px)"}, 'parallel')
                    .to($('#creation-content'), .3, {autoAlpha: 1}, 'parallel')
                    .to($('#creation-content-background'), .3, {autoAlpha: 1}, 'parallel');

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
            });

            function onReverseComplete() {
                resetOverlayContent($('#overlay-content-placeholder'));
            }

            $(document).on('click', '.btn-close-overlay', function (event) {
                event.preventDefault();
                $('html,body').animate({
                    scrollTop: 0
                }, 200);
                overlayTween.reverse();
            });

            $('#gestures-catalog').find('#btn-download-as-json').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $(this).popover('hide');
                    downloadGestureSetAsJSON($('#gestures-catalog').find('#gestures-list-container .gesture-thumbnail'), translation.studyGestureSet);
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