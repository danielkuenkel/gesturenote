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
        <title>GestureNote</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/study-create.css">
        <link rel="stylesheet" href="css/gesture.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="bootstrap-datepicker/css/bootstrap-datepicker3.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
        <link rel="stylesheet" href="bootstrap-slider/css/bootstrap-slider.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.4.4/randomColor.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>
        <script src="js/chance.min.js"></script>

        <script src="bootstrap-slider/js/bootstrap-slider.js"></script>
        <script src="bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.ar.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.az.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.bg.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.bs.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.ca.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.cs.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.cy.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.da.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.de.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.el.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.en-GB.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.es.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.et.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.eu.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.fa.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.fi.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.fo.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.fr.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.fr-CH.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.gl.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.he.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.hr.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.hu.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.hy.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.id.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.is.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.it.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.it-CH.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.ja.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.ka.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.kh.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.kk.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.kr.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.lt.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.lv.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.mk.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.ms.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.nb.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.nl.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.nl-BE.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.no.min.js" charset="UTF-8"></script>
        <!--<script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.pl.js" charset="UTF-8"></script>-->
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.pt.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.ro.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.rs.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.rs-latin.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.ru.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.sk.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.sl.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.sq.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.sr.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.sr-latin.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.sv.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.sw.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.tr.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.uk.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.vi.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-CN.min.js" charset="UTF-8"></script>
        <script src="bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-TW.min.js" charset="UTF-8"></script>

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


        <!-- gesture recorder sources -->
        <script src="https://cdn.WebRTC-Experiment.com/RecordRTC.js"></script>
        <script src="https://cdn.webrtc-experiment.com/gumadapter.js"></script>
        <script src="https://cdn.webrtc-experiment.com/RecordRTC/Whammy.js"></script>
    </head>
    <body>

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-gesture"></div>
        <div id="template-inputs"></div>
        <div id="template-overlays"></div>
        <div id="template-subpages"></div>
        <div id="template-gesture-recorder"></div>

        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb" style="padding-top: 40px">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-studies"><?php echo $lang->breadcrump->studies ?></a></li>
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

            <!--<div class="hidden-xs hidden-sm btn-close-overlay" style="z-index: 100;right:15px; top:90px; position: fixed"><?php echo $lang->close ?> <i class="fa fa-close"></i></div>-->
            <div id="overlay-content-placeholder">

            </div>
        </div>

        <div id="creation-content-background" style="visibility: hidden;position: fixed; background-color: rgba(255,255,255,0.9); top: 0px; left: 0; width: 100%; height: 100%; z-index: 100;"></div>


        <div class="container mainContent">

            <div class="alert-space alert-no-storage-api"></div>

            <!--<div class="row">-->

            <!--<div class="col-sm-12 col-md-7">-->

            <ul class="nav nav-tabs" id="create-tab-navigation" style="margin-bottom: 30px">
                <li role="presentation" id="general"><a href="#"><?php echo $lang->studyCreateNav->general ?></a></li>
                <li role="presentation" id="catalogs" class="disabled"><a href="#"><?php echo $lang->studyCreateNav->catalogs ?></a></li>
                <li role="presentation" id="phases" class="disabled"><a href="#"><?php echo $lang->studyCreateNav->phases ?></a></li>
                <!--<li role="presentation" id="panel"><a href="#"><?php echo $lang->studyCreateNav->panel ?></a></li>-->
            </ul>

            <!--            <div class="root" id="752947396870144">
                            <button type="button" class="btn btn-default btn-open-overlay" id="questionnaire" name="questionnaire">Overlay öffnen</button>
                        </div>-->

            <!-- tab general study data -->

            <div class="tab-content hidden tab-general">

                <p id="styleguide-info" class="text">
                    <?php echo $lang->createStudyInfos->general->overview ?>
                </p>
                <p id="styleguide-info" class="text">
                    <?php echo $lang->createStudyInfos->panel->overview ?>
                </p>

                <!-- study name -->
                <div class="form-group">
                    <label for="studyTitle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text1 ?>">
                        <?php echo $lang->studyTitle ?>
                        <i class="fa fa-info-circle text"></i>
                    </label>
                    <input type="text" class="form-control" id="studyTitle" placeholder="<?php echo $lang->insertTitle ?>" required>
                </div>


                <!-- study description -->
                <div class="form-group" style="margin-bottom: 0px">
                    <label for="studyDescription" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text2 ?>">
                        <?php echo $lang->studyDescription ?>
                        <i class="fa fa-info-circle text"></i>
                    </label>
                    <textarea class="form-control" id="studyDescription" rows="5" placeholder="<?php echo $lang->insertDescription ?>"></textarea>
                </div>


                <!-- manner dropdowns -->
                <!--<div class="form-group">-->
                <form class="form-inline" style="margin-top: 0px">


                    <div class="form-group root" id="phaseSelect" style="margin-right: 20px; margin-top: 15px">

                        <label style="margin: 0" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text3 ?>">
                            <?php echo $lang->studyPhase ?> 
                            <i class="fa fa-info-circle text"></i>
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

                    <!--                    <div class="input-group">
                    
                                            <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="<?php echo $lang->pleaseSelect ?>"/>
                                            <div class="input-group-btn select saveGeneralData" id="phaseSelect" role="group">
                                                <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                    <li id="elicitation"><a href="#"><?php echo $lang->phaseType->elicitation ?></a></li>
                                                    <li id="extraction"><a href="#"><?php echo $lang->phaseType->extraction ?></a></li>
                                                    <li id="evaluation"><a href="#"><?php echo $lang->phaseType->evaluation ?></a></li>
                                                </ul>
                                            </div>
                                        </div>-->
                    <!--</div>-->

                    <div class="form-group root" id="surveyMethodSelect" style="margin-right: 20px; margin-top: 15px">
                        <label style="margin: 0"  data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text4 ?>">
                            <?php echo $lang->studySurveyMethod ?>
                            <i class="fa fa-info-circle text"></i>
                        </label><br>

                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio btn-option-checked saveGeneralData" name="primary" id="singleInterview">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin hidden" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle" id="checked"></i>
                                </span>
                                <span class="option-text"><?php echo $lang->surveyMethod->singleInterview ?></span>
                            </button>
                        </div>
                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio disabled" name="primary" id="focusGroup">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
                                </span>
                                <span class="option-text"><?php echo $lang->surveyMethod->focusGroup ?></span>
                            </button>
                        </div>

                        <!--                    <div class="input-group">
                                                <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="<?php echo $lang->pleaseSelect ?>"/>
                                                <div class="input-group-btn select saveGeneralData" id="surveyMethodSelect" role="group">
                                                    <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                                    <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                        <li id="singleInterview"><a href="#"><?php echo $lang->surveyMethod->singleInterview ?></a></li>
                                                        <li id="focusGroup" class="disabled"><a href="#"><?php echo $lang->surveyMethod->focusGroup ?></a></li>
                                                    </ul>
                                                </div>
                                            </div>-->
                    </div>

                    <div class="form-group root" id="surveyTypeSelect" style="margin-top: 15px">
                        <label style="margin: 0"  data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text5 ?>">
                            <?php echo $lang->studySurveyType ?>
                            <i class="fa fa-info-circle text"></i>
                        </label><br>

                        <div class="btn-group" id="radio" style="margin: 0">
                            <button class="btn btn-default btn-radio saveGeneralData" name="primary" id="moderated">
                                <span id="icons" style="margin-right: 6px">
                                    <i class="fa fa-circle-thin" id="normal"></i>
                                    <i class="fa fa-circle hidden" id="over"></i>
                                    <i class="fa fa-check-circle hidden" id="checked"></i>
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

                        <!--                        <div class="input-group">
                                                    <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="<?php echo $lang->pleaseSelect ?>"/>
                                                    <div class="input-group-btn select saveGeneralData" id="surveyTypeSelect" role="group">
                                                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                            <li id="moderated"><a href="#"><?php echo $lang->surveyType->moderated ?></a></li>
                                                            <li id="unmoderated"><a href="#"><?php echo $lang->surveyType->unmoderated ?></a></li>
                                                        </ul>
                                                    </div>
                                                </div>-->
                    </div>

                </form>





                <!--                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">Aufzeichnung</span>
                                                <input class="form-control item-input-text option-record show-dropdown text-center readonly" type="text" value="Bitte wählen"/>
                                                <div class="input-group-btn select saveGeneralData" id="recordSelect" role="group">
                                                    <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                                    <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                        <li id="videoAudio"><a href="#">Video & Audio</a></li>
                                                        <li id="videoAudioScreen"><a href="#">Video, Audio & Bildschirm</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>-->

                <div id="from-To-datepicker">

                    <div class="input-daterange row" id="datepicker">
                        <div class="col-sm-6" style="margin-top: 15px">
                            <label><?php echo $lang->studyRunsFrom ?></label>
                            <div class="input-group">
                                <input type="text" class="input form-control readonly" id="start" name="start" />
                                <span class="input-group-btn">
                                    <button class="btn btn-default" id="btn-show-datepicker-from" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-6" style="margin-top: 15px">
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

                <div class="panel panel-default" style="margin-top: 25px">

                    <div class="panel-body" id="panelSurveySwitch" style="padding-top: 0px;">
                        <div class="form-inline">
                            <div class="form-group form-group-no-margin root" style="margin-right: 20px; margin-top: 15px;">
                                <label><?php echo $lang->panelSurvey ?></label><br/>

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
                                <label><?php echo $lang->selection ?></label><br/>
                                <div class="text" style="padding-top: 3px; padding-bottom: 4px"></div>
                            </div>
                        </div>

                    </div>
                    <hr style="margin: 0">
                    <div class="panel-body hidden" id="panel-survey-container" style="padding-top: 0px">
                        <div class="form-inline">
                            <div class="form-group form-group-no-margin root" id="genderSwitch" style="margin-right: 20px;margin-top: 15px">
                                <label><?php echo $lang->gender ?></label><br/>
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
                                <label id="age-label"><?php echo $lang->age ?> <span class="age-text"></span></label><br/>
                                <div style="padding-top: 3px; padding-bottom: 4px">
                                    <span class="slider-from text"><?php echo $lang->of ?></span>
                                    <input class="custom-range-slider saveGeneralData" type="text" value="" data-slider-step="1"/>
                                    <span class="slider-to text"><?php echo $lang->to ?></span>
                                </div>
                            </div>
                        </div>

                        <!--                        <div class="form-group">
                                                    <div class="btn-group" id="genderSwitch">
                                                        <button class="btn btn-default switchButtonAddon"><?php echo $lang->gender ?></button>
                                                        <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive disabled" id="female" name="btn-success"><i class="fa fa-venus" aria-hidden="true"></i> <?php echo $lang->genderTypes->female ?></button>
                                                        <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive disabled" id="male" name="btn-success"><i class="fa fa-mars" aria-hidden="true"></i> <?php echo $lang->genderTypes->male ?></button>
                                                        <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive disabled" id="identical" name="btn-success"><i class="fa fa-genderless" aria-hidden="true"></i> <?php echo $lang->genderTypes->identical ?></button>
                                                    </div>
                                                </div>-->

                    </div>

                </div>
            </div>


            <!-- tab catalogs -->

            <div class="tab-content hidden tab-catalogs">

                <p id="styleguide-info" class="text">
                    <?php echo $lang->createStudyInfos->catalogs->overview ?>
                </p>

                <!-- Use of well/predefined gestures -->


                <div class="form-group" id="gestures-catalog"> 
                    <label for="studyDescription" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->catalogs->text1 ?>">
                        <?php echo $lang->gestures ?> 
                        <i class="fa fa-info-circle text"></i>
                    </label><br/>
                    <!--<div class="btn-group">-->
                    <!--                        <button class="btn btn-default btn-shadow hidden" id="btn-clear-study-gestures">
                                                <i class="fa fa-refresh" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->reset ?></span>
                                            </button>-->
                    <button class="btn btn-default btn-shadow" id="btn-assemble-study-gestures">
                        <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->open ?></span>
                    </button>
                    <!--</div>-->
                </div>

                <!-- Use of well/predefined trigger -->


                <div class="form-group" id="trigger-catalog">
                    <label for="studyDescription" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->catalogs->text2 ?>">
                        <?php echo $lang->triggers ?> 
                        <i class="fa fa-info-circle text" ></i>
                    </label><br/>
                    <!--<div class="btn-group">-->
                    <!--                        <button class="btn btn-default btn-shadow" id="btn-clear-trigger">
                                                <i class="fa fa-refresh" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->reset ?></span>
                                            </button>-->
                    <button class="btn btn-default btn-shadow" id="btn-assemble-trigger">
                        <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->open ?></span>
                    </button>
                    <!--</div>-->
                </div>

                <!-- Use of well/predefined feedback -->


                <div class="form-group" id="feedback-catalog">
                    <label for="studyDescription" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->catalogs->text4 ?>">
                        <?php echo $lang->feedback ?> 
                        <i class="fa fa-info-circle" ></i>
                    </label><br/>
                    <!--<div class="btn-group">-->
                    <!--                        <button class="btn btn-default btn-shadow" id="btn-clear-feedback">
                                                <i class="fa fa-refresh" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->reset ?></span>
                                            </button>-->
                    <button class="btn btn-default btn-shadow" id="btn-assemble-feedback">
                        <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->open ?></span>
                    </button>
                    <!--</div>-->
                </div>

                <!-- Use of well/predefined scenes -->


                <div class="form-group" id="scenes-catalog">
                    <label for="studyDescription" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->catalogs->text3 ?>">
                        <?php echo $lang->scenes ?> 
                        <i class="fa fa-info-circle text"></i>
                    </label><br/>

                    <!--<div class="btn-group">-->
                    <!--                        <button class="btn btn-default btn-shadow" id="btn-clear-scenes">
                                                <i class="fa fa-refresh" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->reset ?></span>
                                            </button>-->
                    <button class="btn btn-default btn-shadow" id="btn-assemble-scenes">
                        <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->open ?></span>
                    </button>
                    <!--</div>-->
                </div>

            </div>


            <!-- tab guide & phases -->

            <div class="tab-content hidden tab-phases">
                <p id="styleguide-info" class="text">
                    <?php echo $lang->createStudyInfos->phases->overview ?>
                </p>
                <div class="row">
                    <div class="col-sm-7 col-md-6">


                        <!--                <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><?php echo $lang->phaseStep ?></span>
                                                <input class="form-control item-input-text option-survey-type show-dropdown text-center readonly" type="text" value="<?php echo $lang->pleaseSelect ?>"/>
                                                <div class="input-group-btn select saveGeneralData" id="phaseStepSelect"  role="group">
                                                    <button class="btn btn-default btn-shadow btn-dropdown" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                                    <ul class="dropdown-menu option" role="menu">
                        
                                                        <li class="dropdown-header"><?php echo $lang->questionnaires ?></li>
                                                        <li id="questionnaire"><a href="#"><?php echo $lang->formats->questionnaire->text ?></a></li>
                                                        <li id="gus" class="evaluation"><a href="#"><?php echo $lang->formats->gus->text ?></a></li>
                                                        <li id="questionnaireGestures" class="evaluation"><a href="#"><?php echo $lang->formats->questionnaireGestures->text ?></a></li>
                                                        <li id="sus" class="evaluation"><a href="#"><?php echo $lang->formats->sus->text ?></a></li>
                                                        <li id="favoriteGestures" class="extraction"><a href="#"><?php echo $lang->formats->favoriteGestures->text ?></a></li>
                        
                                                        <li class="divider"></li>
                        
                                                        <li class="dropdown-header"><?php echo $lang->miscellaneous ?></li>
                                                        <li id="identification" class="elicitation"><a href="#"><?php echo $lang->formats->identification->text ?></a></li>
                                                        <li id="gestureTraining" class="evaluation"><a href="#"><?php echo $lang->formats->gestureTraining->text ?></a></li>
                                                        <li id="scenario" class="evaluation"><a href="#"><?php echo $lang->formats->scenario->text ?></a></li>
                                                        <li id="gestureSlideshow" class="evaluation"><a href="#"><?php echo $lang->formats->gestureSlideshow->text ?></a></li>
                                                        <li id="triggerSlideshow" class="evaluation"><a href="#"><?php echo $lang->formats->triggerSlideshow->text ?></a></li>
                                                        <li id="physicalStressTest" class="evaluation"><a href="#"><?php echo $lang->formats->physicalStressTest->text ?></a></li>
                                                        <li id="exploration" class="extraction"><a href="#"><?php echo $lang->formats->exploration->text ?></a></li>
                                                    </ul>
                                                    <button class="btn btn-info btn-shadow disabled dropdown-disabled" id="addPhaseStep" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                                </div>
                                            </div>
                                        </div>-->

                        <!-- phase step list items -->

                        <div class="" id="phaseStepList"></div>
                        <hr class="hidden-sm hidden-md hidden-lg" id="seperatorPhaseStepList" style="margin-bottom: 10px">
                    </div>



                    <div class="col-sm-5 col-md-6">
                        <div id="phaseStepSelect">
                            <h4><?php echo $lang->questionnaires ?></h4>

                            <div class="add-button-group" id="add-phase-step-format-group-questionnaires">
                                <div class="btn-group">
                                    <div class="btn btn-info btn-add-item btn-shadow font-bold" id="questionnaire">
                                        <i class="fa fa-plus"></i> <?php echo $lang->formats->questionnaire->text ?>
                                        <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->phases->questionnaire ?>"></i>
                                    </div>
                                </div>
                                <div class="btn-group evaluation">
                                    <div class="btn btn-info btn-add-item btn-shadow font-bold" id="gus">
                                        <i class="fa fa-plus"></i> <?php echo $lang->formats->gus->text ?>
                                        <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->phases->gus ?>"></i>
                                    </div>
                                </div>
                                <div class="btn-group evaluation">
                                    <div class="btn btn-info btn-add-item btn-shadow font-bold" id="questionnaireGestures">
                                        <i class="fa fa-plus"></i> <?php echo $lang->formats->questionnaireGestures->text ?>
                                        <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->phases->questionnaireGestures ?>"></i>
                                    </div>
                                </div>
                                <div class="btn-group evaluation">
                                    <div class="btn btn-info btn-add-item btn-shadow font-bold" id="sus">
                                        <i class="fa fa-plus"></i> <?php echo $lang->formats->sus->text ?>
                                        <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->phases->sus ?>"></i>
                                    </div>
                                </div>
                            </div>

                            <h4 style="margin-top: 20px"><?php echo $lang->miscellaneous ?></h4>
                            <div class="add-button-group" id="add-phase-step-format-group-miscellaneous">
                                <div class="btn-group elicitation">
                                    <div class="btn btn-info btn-add-item btn-shadow font-bold" id="identification">
                                        <i class="fa fa-plus"></i> <?php echo $lang->formats->identification->text ?>
                                        <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->phases->identification ?>"></i>
                                    </div>
                                </div>
                                <div class="btn-group evaluation">
                                    <div class="btn btn-info btn-add-item btn-shadow font-bold" id="gestureTraining">
                                        <i class="fa fa-plus"></i> <?php echo $lang->formats->gestureTraining->text ?>
                                        <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->phases->gestureTraining ?>"></i>
                                    </div>
                                </div>
                                <div class="btn-group evaluation">
                                    <div class="btn btn-info btn-add-item btn-shadow font-bold" id="scenario">
                                        <i class="fa fa-plus"></i> <?php echo $lang->formats->scenario->text ?>
                                        <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->phases->scenario ?>"></i>
                                    </div>
                                </div>
                                <div class="btn-group evaluation">
                                    <div class="btn btn-info btn-add-item btn-shadow font-bold" id="gestureSlideshow">
                                        <i class="fa fa-plus"></i> <?php echo $lang->formats->gestureSlideshow->text ?>
                                        <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->phases->gestureSlideshow ?>"></i>
                                    </div>
                                </div>
                                <div class="btn-group evaluation">
                                    <div class="btn btn-info btn-add-item btn-shadow font-bold" id="triggerSlideshow">
                                        <i class="fa fa-plus"></i> <?php echo $lang->formats->triggerSlideshow->text ?>
                                        <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->phases->triggerSlideshow ?>"></i>
                                    </div>
                                </div>
                                <div class="btn-group evaluation">
                                    <div class="btn btn-info btn-add-item btn-shadow font-bold" id="physicalStressTest">
                                        <i class="fa fa-plus"></i> <?php echo $lang->formats->physicalStressTest->text ?>
                                        <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->phases->physicalStressTest ?>"></i>
                                    </div>
                                </div>
                                <div class="btn-group extraction">
                                    <div class="btn btn-info btn-add-item btn-shadow font-bold" id="exploration">
                                        <i class="fa fa-plus"></i> <?php echo $lang->formats->exploration->text ?>
                                        <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->phases->exploration ?>"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group hidden root" id="phaseStepItem" style="margin-bottom: 0px; margin-top: 10px">
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
                            <!--<span class="glyphicon glyphicon-tag"></span>-->
                            <!--<i class="glyphicon glyphicon-cog " data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->generalEdit ?>"></i>--> 
                            <span class="phase-step-format"></span>
                        </button>
                    </div>
                </div>

            </div>


            <!-- tab panels & survey data -->

            <div class="tab-content hidden tab-panel">

                <p id="styleguide-info" class="text">
                    <?php echo $lang->createStudyInfos->panel->overview ?>
                </p>



            </div>

            <div  id="btn-group-submit" style="z-index: 0">
                <hr>

                <!-- submit form button group -->
                <div class="btn-group-vertical btn-block" role="group">
                    <!--<button type="button" class="btn btn-danger btn-shadow btn-md" id="btn-clear-data"><i class="glyphicon glyphicon-trash"></i> <?php echo $lang->deleteAllData ?></button>-->
                    <button type="button" class="btn btn-warning btn-shadow btn-md disabled" id="btn-preview-study"><i class="glyphicon glyphicon-eye-open"></i> <?php echo $lang->studyPreview ?></button>
                    <button type="button" class="btn btn-success btn-shadow btn-lg" id="btn-save-study"><i class="fa fa-check"></i> <?php echo $lang->done ?></button>
                </div>
            </div>

            <!--</div>-->






            <!-- Guidelines -->
            <!--                <div class="col-sm-12 col-md-5" style="margin-top: 20px">
                                <div class="col-md-11 col-md-offset-1">
                                <div class="tab-content hidden tab-general">
                                    <div><h3><?php echo $lang->studyCreateNav->general ?></h3></div>
                                    <span id="styleguide-info" class="text">
            <?php echo $lang->createStudyInfos->general->overview ?>
                                    </span>
                                    <br><br>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-shadow" onclick="loadHTMLintoModal('custom-modal', 'create-info-general.php');"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $lang->moreInfos ?></button>
                                    </div>
                                </div>
            
                                <div class="tab-content hidden tab-catalogs">
                                    <div><h3><?php echo $lang->studyCreateNav->catalogs ?></h3></div>
                                    <span id="styleguide-info" class="text">
            <?php echo $lang->createStudyInfos->catalogs->overview ?>
                                    </span>
                                    <br><br>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-shadow" id="btn-more-infos-catalogs"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $lang->moreInfos ?></button>
                                    </div>
                                </div>
            
                                <div class="tab-content hidden tab-phases">
                                    <div><h3><?php echo $lang->studyCreateNav->phases ?></h3></div>
                                    <span id="styleguide-info" class="text">
            <?php echo $lang->createStudyInfos->phases->overview ?>
                                    </span>
                                    <br><br>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-shadow" id="btn-more-infos-phases"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $lang->moreInfos ?></button>
                                    </div>
                                </div>
            
                                <div class="tab-content hidden tab-panel">
                                    <div><h3><?php echo $lang->studyCreateNav->panel ?></h3></div>
                                    <span id="styleguide-info" class="text">
            <?php echo $lang->createStudyInfos->panel->overview ?>
                                    </span>
                                    <br><br>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-shadow" onclick="loadHTMLintoModal('custom-modal', 'create-info-panel.php');"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $lang->moreInfos ?></button>
                                    </div>
                                </div>
                                </div>
                            </div>-->
            <!--</div>-->
        </div>


        <script>
            var firstInit = false;
            $(document).ready(function () {
                firstInit = true;
                checkDomain();
                keepSessionAlive();
                $('[data-toggle="popover"]').popover({container: 'body', delay: {"show": 300, "hide": 0}});

                checkLanguage(function () {
                    createRandomColors();

                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-gesture', PATH_EXTERNALS + 'template-gesture.php']);
                    externals.push(['#template-inputs', PATH_EXTERNALS + 'template-create.php']);
                    externals.push(['#template-overlays', PATH_EXTERNALS + 'template-overlays.php']);
                    externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    externals.push(['#template-gesture-recorder', PATH_EXTERNALS + 'template-gesture-recorder.php']);
                    loadExternals(externals);

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
                });
            });

            var editableStudyId = null;
            var studyEditable = false;
            function onAllExternalsLoadedSuccessfully() {
                initTooltips();

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
                getAgeRange(function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        if (result.tester && result.tester.length > 0) {
                            var ageRange = calculateAgeRangeForGender(result.tester, 'identical');
                            var data = {min: ageRange.min, max: ageRange.max, raw: result.tester};
                            data.availableGender = getAvailableGender(result.tester);
                            setLocalItem(STUDY_PANEL, data);
                        }

                        initAfterAgeRange();
                    } else {
                        // error handling
                        initAfterAgeRange();
                    }
                });

                function initAfterAgeRange() {
                    checkSessionStorage();

                    var status = window.location.hash.substr(1);
                    var statusNavMatch = getStatusNavMatch(status);
                    if (status !== '' && statusNavMatch !== null) {
                        $('#create-tab-navigation').find('#' + statusNavMatch).click();
                    } else {
                        $('#create-tab-navigation').find('#general').click();
                    }
                }
            }

            function getStatusNavMatch(status) {
                var tabs = $('#create-tab-navigation').children();
                for (var i = 0; i < tabs.length; i++) {
                    if ($(tabs[i]).attr('id') === status) {
                        return $(tabs[i]).attr('id');
                    }
                }
                return null;
            }

            $('#custom-modal').on('hidden.bs.modal', function () {
                $(this).find('.modal-content').empty();
            });

            // scenes handling
            $('#btn-assemble-scenes').click(function (event) {
                event.preventDefault();
                currentIdForModal = ASSEMBLED_SCENES;
                loadHTMLintoModal('custom-modal', 'create-scenes-catalog.php', 'modal-lg');
            });

            $('#btn-clear-scenes').click(function (event) {
                event.preventDefault();
                removeAssembledScenes();
                updateCatalogButtons();
            });

            // gesture catalog handling
            $('#btn-assemble-study-gestures').click(function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'create-gesture-catalog.php', 'modal-lg');
            });

            //            $('#btn-study-gestures').click(function (event) {
            //                event.preventDefault();
            //                loadHTMLintoModal("custom-modal", "create-study-gestures.php", "modal-lg");
            //            });

            $('#btn-clear-study-gestures').click(function (event) {
                event.preventDefault();
                removeAssembledGestures();
                updateCatalogButtons();
            });

            //            $('#btn-record-gestures').click(function (event) {
            //                event.preventDefault();
            //                loadHTMLintoModal('custom-modal', 'create-gesture-recorder.php', 'modal-md');
            //                $('#custom-modal').unbind('saveSuccess').bind('saveSuccess', function (event, gestureId) {
            //                    if (!event.handled) {
            //                        event.handled = true;
            //                        assembleGesture(gestureId);
            //                        getGestureCatalog();
            //                        updateCatalogButtons();
            //                    }
            //                });
            //                $('#custom-modal').unbind('deleteSuccess').bind('deleteSuccess', function (event, gestureId) {
            //                    if (!event.handled) {
            //                        event.handled = true;
            //                        reassembleGesture(gestureId);
            //                        getGestureCatalog();
            //                        updateCatalogButtons();
            //                    }
            //                });
            //            });

            // trigger catalog handling
            $('#btn-assemble-trigger').click(function (event) {
                event.preventDefault();
                //                currentIdForModal = ASSEMBLED_TRIGGER;
                loadHTMLintoModal('custom-modal', 'create-trigger-catalog.php', 'modal-lg');
            });

            $('#btn-clear-trigger').click(function (event) {
                event.preventDefault();
                removeAssembledTrigger();
                updateCatalogButtons();
            });

            // feedback catalog handling
            $('#btn-assemble-feedback').click(function (event) {
                event.preventDefault();
                //                currentIdForModal = ASSEMBLED_FEEDBACK;
                loadHTMLintoModal('custom-modal', 'create-feedback-catalog.php', 'modal-lg');
            });

            $('#btn-clear-feedback').click(function (event) {
                event.preventDefault();
                removeAssembledFeedback();
                updateCatalogButtons();
            });

            //            $('#addPhaseStep').click(function (event) {
            //                event.preventDefault();
            //                if (!$(this).hasClass('disabled') && format !== 'unselected') {
            //                    var format = $(this).parent().find('.chosen').attr('id');
            //                    addPhaseStep(chance.natural(), format, null, null, true);
            //                    savePhases();
            //                    checkPreviewAvailability();
            //                }
            //            });

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

                //                clone.find('.btn-text-button, .btn-open-overlay').bind("click", {format: format, id: id}, function (event) {
                //                    event.preventDefault();
                //                    currentIdForModal = event.data.id;
                //                    loadHTMLintoModal("custom-modal", "create-" + event.data.format + ".php", "modal-lg");
                //                });

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

                if (prependItem && prependItem === true) {
                    setTimeout(function () {
                        $(clone).insertBefore($('#phaseStepList').find('.form-group').last());
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

            $('#panelSurveySwitch').on('change', function (event, id) {
                event.preventDefault();
                if ($(event.target).attr('id') === 'yes') {
                    $('#panel-survey-container').removeClass('hidden');
                    $('#selectedAgeRange').removeClass('hidden');
                } else {
                    $('#panel-survey-container').addClass('hidden');
                    $('#selectedAgeRange').addClass('hidden');
                }
            });

            $('#phaseSelect').on('change', function (event) {
                event.preventDefault();
                var id = $(event.target).attr('id');
                var catalogsNav = $('#create-tab-navigation #catalogs');
                var phasesNav = $('#create-tab-navigation #phases');
                if ($(phasesNav).hasClass('disabled') && $(catalogsNav).hasClass('disabled')) {
                    $(phasesNav).removeClass('disabled');
                    $(catalogsNav).removeClass('disabled');
                    if (firstInit) {
                        firstInit = false;
                        TweenMax.to(catalogsNav, .1, {y: -20});
                        TweenMax.to(catalogsNav, .5, {delay: .1, y: 0, ease: Bounce.easeOut});
                        TweenMax.to(phasesNav, .1, {delay: .1, y: -20});
                        TweenMax.to(phasesNav, .5, {delay: .2, y: 0, ease: Bounce.easeOut});
                    }
                }

                $('#phaseStepSelect').find('.' + id).removeClass('hidden');
                if (id === TYPE_PHASE_ELICITATION) {
                    $('#phaseStepSelect').find('.' + TYPE_PHASE_EXTRACTION).addClass('hidden');
                    $('#phaseStepSelect').find('.' + TYPE_PHASE_EVALUATION).addClass('hidden');
                    $('#feedback-catalog').addClass('hidden');
                } else if (id === TYPE_PHASE_EVALUATION) {
                    $('#phaseStepSelect').find('.' + TYPE_PHASE_ELICITATION).addClass('hidden');
                    $('#phaseStepSelect').find('.' + TYPE_PHASE_EXTRACTION).addClass('hidden');
                    $('#feedback-catalog').removeClass('hidden');
                } else if (id === TYPE_PHASE_EXTRACTION) {
                    $('#phaseStepSelect').find('.' + TYPE_PHASE_EVALUATION).addClass('hidden');
                    $('#phaseStepSelect').find('.' + TYPE_PHASE_ELICITATION).addClass('hidden');
                    $('#feedback-catalog').addClass('hidden');
                }

                saveGeneralData();
                renderPhaseSteps();
            });

            $('.breadcrumb li a').click(function (event) {
                var button = $(this);
                event.stopImmediatePropagation();
                loadHTMLintoModal('custom-modal', 'modal-delete-data.php', 'modal-sm');
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
                    $('#create-tab-navigation').find('#general').click();
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
                    $('#create-tab-navigation').find('#general').click();
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

            $('#create-tab-navigation').on('change', function () {
                $('.tab-content').addClass('hidden');
                var activeTapId = $(this).find('.active').attr('id');
                var activeTaps = $('.tab-' + activeTapId);
                activeTaps.removeClass('hidden');
                for (var i = 0; i < activeTaps.length; i++) {
                    $(activeTaps[i]).css({zIndex: 100});
                    TweenMax.from(activeTaps[i], .2, {delay: (i * .1), opacity: 0, y: -20, clearProps: 'all'});
                }
                TweenMax.from($('#btn-group-submit'), .3, {y: -20});
                $("html, body").animate({scrollTop: 0}, 100);
                window.location.hash = activeTapId;
            });

            //            $('#btn-more-infos-phases').on('click', function (event) {
            //                event.preventDefault();
            //                switch (getLocalItem(STUDY).phase) {
            //                    case TYPE_PHASE_EVALUATION:
            //                        loadHTMLintoModal('custom-modal', 'create-info-phases-evaluation.php');
            //                        break;
            //                    case TYPE_PHASE_ELICITATION:
            //                        loadHTMLintoModal('custom-modal', 'create-info-phases-identification.php');
            //                        break;
            //                    case TYPE_PHASE_EXTRACTION:
            //                        loadHTMLintoModal('custom-modal', 'create-info-phases-extraction.php');
            //                        break;
            //                }
            //            });
            //
            //            $('#btn-more-infos-catalogs').on('click', function (event) {
            //                event.preventDefault();
            //                if (getLocalItem(STUDY).phase === TYPE_PHASE_EVALUATION) {
            //                    loadHTMLintoModal('custom-modal', 'create-info-catalogs-evaluation.php');
            //                } else {
            //                    loadHTMLintoModal('custom-modal', 'create-info-catalogs-identification.php');
            //                }
            //            });

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
                initOverlayContent($(this).attr('id'), $(this).closest('.root').attr('id'));
                overlayTween.play();
                setTimeout(function () {
                    $('body').animate({
                        scrollTop: 0
                    }, 200);
                }, 300);
            });

            function onReverseComplete() {
                resetOverlayContent($('#overlay-content-placeholder'));
            }

            $(document).on('click', '.btn-close-overlay', function (event) {
                event.preventDefault();
                $('body').animate({
                    scrollTop: 0
                }, 200);
                overlayTween.reverse();
            });

            $('#btn-show-datepicker-from').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!event.handled) {
                    event.handled = true;
                    console.log($(this).hasClass('.active'));
                    if (!$(this).hasClass('active')) {
                        $('#from-To-datepicker #start').datepicker('show');
                    }
                    else {
                        $('#from-To-datepicker #start').datepicker('hide');
                    }
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
                    if (!$(this).hasClass('activeactive')) {
                        $('#from-To-datepicker #end').datepicker('show');
                    } else {
                        $('#from-To-datepicker #end').datepicker('hide');
                    }
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