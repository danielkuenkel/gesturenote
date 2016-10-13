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
        <script src="js/forms.js"></script>
        <script src="js/dimensions.js"></script>
        <script src="js/joint-selection.js"></script>
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
        <div id="templage-subpages"></div>
        <div id="template-gesture-recorder"></div>

        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb" style="padding-top: 40px">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-studies"><?php echo $lang->breadcrump->studies ?></a></li>
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

        <!-- Container (Landing Section) -->
        <!--        <div class="container-fluid text-center bg-grey" id="landingText">
                    <div class="container">
                        <h2>NEUES STUDIE ERSTELLEN</h2>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>-->

        <div class="container mainContent">

            <div class="alert-space alert-no-storage-api"></div>

            <div class="row">

                <div class="col-sm-12 col-md-7">

                    <ul class="nav nav-tabs" id="create-tab-navigation" style="margin-bottom: 30px">
                        <li role="presentation" id="general"><a href="#"><?php echo $lang->studyCreateNav->general ?></a></li>
                        <li role="presentation" id="catalogs" class="hidden"><a href="#"><?php echo $lang->studyCreateNav->catalogs ?></a></li>
                        <li role="presentation" id="phases" class="hidden"><a href="#"><?php echo $lang->studyCreateNav->phases ?></a></li>
                        <li role="presentation" id="panel"><a href="#"><?php echo $lang->studyCreateNav->panel ?></a></li>
                    </ul>


                    <!-- tab general study data -->

                    <div class="tab-content hidden tab-general">

                        <!-- study name -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><?php echo $lang->studyTitle ?></span>
                                <label class="sr-only" for="studyTitle"><?php echo $lang->studyTitle ?></label>
                                <input type="text" class="form-control" id="studyTitle" placeholder="<?php echo $lang->insertStudyTitle ?>" required>
                            </div>
                        </div>


                        <!-- study description -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><?php echo $lang->studyDescription ?></span>
                                <label class="sr-only" for="studyDescription"><?php echo $lang->studyDescription ?></label>
                                <textarea class="form-control" id="studyDescription" rows="5" placeholder="<?php echo $lang->insertStudyDescription ?>"></textarea>
                            </div>
                        </div>


                        <!-- manner dropdowns -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><?php echo $lang->studyPhase ?></span>
                                <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="<?php echo $lang->pleaseSelect ?>"/>
                                <div class="input-group-btn select saveGeneralData" id="phaseSelect" role="group">
                                    <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                    <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                        <li id="elicitation"><a href="#"><?php echo $lang->phaseType->elicitation ?></a></li>
                                        <li id="evaluation"><a href="#"><?php echo $lang->phaseType->evaluation ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><?php echo $lang->studySurveyType ?></span>
                                <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="<?php echo $lang->pleaseSelect ?>"/>
                                <div class="input-group-btn select saveGeneralData" id="surveyTypeSelect" role="group">
                                    <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                    <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                        <li id="moderated"><a href="#"><?php echo $lang->surveyType->moderated ?></a></li>
                                        <li id="unmoderated"><a href="#"><?php echo $lang->surveyType->unmoderated ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- tab catalogs -->

                    <div class="tab-content hidden tab-catalogs">

                        <!-- Use of well/predefined gestures -->
                        <div class="form-group" id="gestures-catalog">
                            <div class="btn-group">
                                <button class="btn btn-default btn-group-addon"><?php echo $lang->gestures ?></button>
                                <button class="btn btn-default btn-shadow hidden" id="btn-clear-study-gestures">
                                    <i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs btn-text"><?php echo $lang->delete ?></span>
                                </button>
                                <button class="btn btn-default btn-shadow hidden" id="btn-study-gestures">
                                    <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->open ?></span>
                                </button>
                                <button class="btn btn-default btn-shadow" id="btn-assemble-study-gestures">
                                    <i class="fa fa-star" aria-hidden="true"></i> <span class=""><span class="hidden-xs btn-text"><?php echo $lang->set ?> </span><?php echo $lang->arrange ?></span>
                                </button>
                                <button class="btn btn-default btn-shadow" id="btn-record-gestures">
                                    <i class="fa fa-video-camera" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->record ?></span>
                                </button>

                            </div>
                        </div>

                        <!-- Use of well/predefined trigger -->
                        <div class="form-group" id="trigger-catalog">
                            <div class="btn-group">
                                <button class="btn btn-default btn-group-addon"><?php echo $lang->triggers ?></button>
                                <button class="btn btn-default btn-shadow" id="btn-clear-trigger">
                                    <i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs btn-text"><?php echo $lang->delete ?></span>
                                </button>
                                <button class="btn btn-default btn-shadow" id="btn-assemble-trigger">
                                    <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->open ?></span>
                                </button>
                            </div>
                        </div>

                        <!-- Use of well/predefined feedback -->
                        <div class="form-group" id="feedback-catalog">
                            <div class="btn-group">
                                <button class="btn btn-default btn-group-addon"><?php echo $lang->feedback ?></button>
                                <button class="btn btn-default btn-shadow" id="btn-clear-feedback">
                                    <i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs btn-text"><?php echo $lang->delete ?></span>
                                </button>
                                <button class="btn btn-default btn-shadow" id="btn-assemble-feedback">
                                    <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->open ?></span>
                                </button>
                            </div>
                        </div>

                        <!-- Use of well/predefined sczenes -->
                        <div class="form-group" id="scenes-catalog">
                            <div class="btn-group">
                                <button class="btn btn-default btn-group-addon"><?php echo $lang->scenes ?></button>
                                <button class="btn btn-default btn-shadow" id="btn-clear-scenes">
                                    <i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs btn-text"><?php echo $lang->delete ?></span>
                                </button>
                                <button class="btn btn-default btn-shadow" id="btn-assemble-scenes">
                                    <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->open ?></span>
                                </button>
                            </div>
                        </div>
                        
                    </div>


                    <!-- tab guide & phases -->

                    <div class="tab-content hidden tab-phases">

                        <div class="form-group">
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
                                        <li class="divider"></li>
                                        <li class="dropdown-header"><?php echo $lang->miscellaneous ?></li>

                                        <li id="identification" class="elicitation"><a href="#"><?php echo $lang->formats->identification->text ?></a></li>
                                        <li id="gestureTraining" class="evaluation"><a href="#"><?php echo $lang->formats->gestureTraining->text ?></a></li>
                                        <li id="scenario" class="evaluation"><a href="#"><?php echo $lang->formats->scenario->text ?></a></li>
                                        <li id="gestureSlideshow" class="evaluation"><a href="#"><?php echo $lang->formats->gestureSlideshow->text ?></a></li>
                                        <li id="triggerSlideshow" class="evaluation"><a href="#"><?php echo $lang->formats->triggerSlideshow->text ?></a></li>
                                        <li id="physicalStressTest" class="evaluation"><a href="#"><?php echo $lang->formats->physicalStressTest->text ?></a></li>

                                    </ul>
                                    <button class="btn btn-info btn-shadow disabled dropdown-disabled" id="addPhaseStep" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                </div>
                            </div>
                        </div>

                        <!-- phase step list items -->
                        <div class="form-group" id="phaseStepList"></div>

                        <div class="form-group hidden root" id="phaseStepItem">
                            <div class="btn-group">
                                <button class="btn btn-default btn-shadow btn-up saveGeneralData" title="<?php echo $lang->furtherUp ?>">
                                    <i class="glyphicon glyphicon-arrow-up"></i>
                                </button>
                                <button class="btn btn-default btn-shadow btn-down saveGeneralData" title="<?php echo $lang->furtherDown ?>">
                                    <i class="glyphicon glyphicon-arrow-down"></i>
                                </button>
                                <button class="btn btn-default btn-shadow btn-modify" title="<?php echo $lang->edit ?>">
                                    <i class="glyphicon glyphicon-cog"></i>
                                </button>
                                <button class="btn btn-default btn-shadow btn-text-button">
                                    <span class="glyphicon glyphicon-tag"></span><span class="phase-step-format"></span>
                                </button>
                                <button class="btn btn-default btn-shadow btn-delete saveGeneralData" title="<?php echo $lang->delete ?>">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>


                    <!-- tab panels & survey data -->

                    <div class="tab-content hidden tab-panel">

                        <div class="form-group">
                            <div class="btn-group" id="panelSurveySwitch">
                                <button class="btn btn-default switchButtonAddon"><?php echo $lang->panelSurvey ?></button>
                                <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive" id="yes" name="btn-success"><?php echo $lang->yes ?></button>
                                <button class="btn btn-warning btn-shadow btn-toggle-checkbox saveGeneralData active" id="no" name="btn-warning"><?php echo $lang->no ?></button>
                            </div>
                        </div>

                        <div id="panel-survey-container" class="hidden">

                            <div class="form-group">
                                <div class="btn-group" id="genderSwitch">
                                    <button class="btn btn-default switchButtonAddon"><?php echo $lang->gender ?></button>
                                    <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive disabled" id="female" name="btn-success"><i class="fa fa-venus" aria-hidden="true"></i> <?php echo $lang->genderTypes->female ?></button>
                                    <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive disabled" id="male" name="btn-success"><i class="fa fa-mars" aria-hidden="true"></i> <?php echo $lang->genderTypes->male ?></button>
                                    <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive disabled" id="identical" name="btn-success"><i class="fa fa-genderless" aria-hidden="true"></i> <?php echo $lang->genderTypes->identical ?></button>
                                </div>
                            </div>

                            <div class="form-group" id="ageSlider">
                                <span class="slider-from" name="age"><?php echo $lang->of ?></span>
                                <input class="custom-range-slider saveGeneralData" type="text" value="" data-slider-step="1"/>
                                <span class="slider-to"><?php echo $lang->to ?></span>
                            </div>

                        </div>

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
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon"><?php echo $lang->studyRunsFrom ?></span>
                                <input type="text" class="input form-control readonly" id="start" name="start" />
                                <span class="input-group-addon"><?php echo $lang->to ?></span>
                                <input type="text" class="input form-control readonly" id="end" name="end" />
                            </div>
                        </div>

                    </div>

                    <div  id="btn-group-submit" style="z-index: 0">
                        <hr>

                        <!-- submit form button group -->
                        <div class="btn-group-vertical btn-block" role="group">
                            <button type="button" class="btn btn-danger btn-shadow btn-md" id="btn-clear-data"><i class="glyphicon glyphicon-trash"></i> <?php echo $lang->deleteAllData ?></button>
                            <button type="button" class="btn btn-warning btn-shadow btn-md disabled" id="btn-preview-study"><i class="glyphicon glyphicon-eye-open"></i> <?php echo $lang->studyPreview ?></button>
                            <button type="button" class="btn btn-success btn-shadow btn-lg" id="btn-save-study"><i class="glyphicon glyphicon-save"></i> <?php echo $lang->saveStudy ?></button>
                        </div>
                    </div>

                </div>

                <!-- Guidelines -->
                <div class="col-sm-12 col-md-5" style="margin-top: 20px">
                    <div class="col-md-11 col-md-offset-1">
                        <div class="tab-content hidden tab-general">
                            <div class="gn"><h3><?php echo $lang->studyCreateNav->general ?></h3></div>
                            <span id="styleguide-info">
                                <?php echo $lang->createStudyInfos->general->overview ?>
                            </span>
                            <br><br>
                            <div class="btn-group">
                                <button type="button" class="btn btn-gn btn-shadow" onclick="loadHTMLintoModal('custom-modal', 'create-info-general.php');"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $lang->moreInfos ?></button>
                            </div>
                        </div>

                        <div class="tab-content hidden tab-catalogs">
                            <div class="gn"><h3><?php echo $lang->studyCreateNav->catalogs ?></h3></div>
                            <span id="styleguide-info">
                                <?php echo $lang->createStudyInfos->catalogs->overview ?>
                            </span>
                            <br><br>
                            <div class="btn-group">
                                <button type="button" class="btn btn-gn btn-shadow" id="btn-more-infos-catalogs"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $lang->moreInfos ?></button>
                            </div>
                        </div>

                        <div class="tab-content hidden tab-phases">
                            <div class="gn"><h3><?php echo $lang->studyCreateNav->phases ?></h3></div>
                            <span id="styleguide-info">
                                <?php echo $lang->createStudyInfos->phases->overview ?>
                            </span>
                            <br><br>
                            <div class="btn-group">
                                <button type="button" class="btn btn-gn btn-shadow" id="btn-more-infos-phases"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $lang->moreInfos ?></button>
                            </div>
                        </div>

                        <div class="tab-content hidden tab-panel">
                            <div class="gn"><h3><?php echo $lang->studyCreateNav->panel ?></h3></div>
                            <span id="styleguide-info">
                                <?php echo $lang->createStudyInfos->panel->overview ?>
                            </span>
                            <br><br>
                            <div class="btn-group">
                                <button type="button" class="btn btn-gn btn-shadow" onclick="loadHTMLintoModal('custom-modal', 'create-info-panel.php');"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $lang->moreInfos ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            $(document).ready(function () {
                checkDomain();
                checkLanguage(function () {
                    createRandomColors();
                    
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-gesture', PATH_EXTERNALS + 'template-gesture.php']);
                    externals.push(['#template-inputs', PATH_EXTERNALS + 'template-create.php']);
                    externals.push(['#templage-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
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
                renderSubPageElements();
                var query = getQueryParams(document.location.search);
                var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                if (query.studyId && query.h === hash) {
                    $('#btn-clear-data').remove();
                    studyEditable = true;
                    editableStudyId = query.studyId;
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
                            var ageMax = calculateAge(new Date(parseInt(result.tester[0].birthday) * 1000));
                            var ageMin = calculateAge(new Date(parseInt(result.tester[result.tester.length - 1].birthday) * 1000));
                            var data = {min: ageMin, max: ageMax};
                            data.availableGender = getAvailableGender(result.tester);
                            setLocalItem(STUDY_PANEL, data);
                        }

                        if (typeof (Storage) !== "undefined") {
                            checkSessionStorage();
                        } else {
                            appendAlert($('#mainContent'), ALERT_NO_STORAGE_API);
                        }


                        var status = window.location.hash.substr(1);
                        var statusNavMatch = getStatusNavMatch(status);
                        if (status !== '' && statusNavMatch !== null) {
                            $('#create-tab-navigation').find('#' + statusNavMatch).click();
                        } else {
                            $('#create-tab-navigation').find('#general').click();
                        }
                    }
                });
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

            $('#btn-study-gestures').click(function (event) {
                event.preventDefault();
                loadHTMLintoModal("custom-modal", "create-study-gestures.php", "modal-lg");
            });

            $('#btn-clear-study-gestures').click(function (event) {
                event.preventDefault();
                removeAssembledGestures();
                updateCatalogButtons();
            });

            $('#btn-record-gestures').click(function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'create-gesture-recorder.php', 'modal-md');
                $('#custom-modal').unbind('gestureSavedSuccessfully').bind('gestureSavedSuccessfully', function (event, gestureId) {
                    if (!event.handled) {
                        event.handled = true;
                        assembleGesture(parseInt(gestureId));
                        getGestureCatalog();
                        updateCatalogButtons();
                    }
                });
            });

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

            $('#addPhaseStep').click(function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled') && format !== 'unselected') {
                    var format = $(this).parent().find('.chosen').attr('id');
                    addPhaseStep(chance.natural(), format, null);
                    savePhases();
                    checkPreviewAvailability();
                }
            });

            function checkPreviewAvailability() {
                var phaseSteps = getLocalItem(STUDY_PHASE_STEPS);
                if (phaseSteps && phaseSteps.length > 0) {
                    $('#btn-preview-study').removeClass('disabled');
                } else {
                    $('#btn-preview-study').addClass('disabled');
                }
            }

            function addPhaseStep(id, format, color) {
                var clone = $('#phaseStepItem').clone().removeAttr('id');
                clone.removeClass('hidden').addClass(translation.formats[format].class);
                clone.attr('id', id);
                $('#phaseStepList').append(clone);
                clone.find('.btn-modify').attr('id', format);
                clone.find('.glyphicon-tag').css('color', color === null ? color = colors.pop() : color);
                clone.find('.phase-step-format').text(" " + translation.formats[format].text);
                clone.find('.btn-text-button, .btn-modify').bind("click", {format: format, id: id}, function (event) {
                    event.preventDefault();
                    currentIdForModal = event.data.id;
                    loadHTMLintoModal("custom-modal", "create-" + event.data.format + ".php", "modal-lg");
                });
                if (format === THANKS || format === LETTER_OF_ACCEPTANCE) {
                    clone.find('.btn-delete').remove();
                } else {
//                    var children = $('#phaseStepList').children().length;
//                    $('#phaseStepList>div:eq(' + children + ')').before(clone);
//                    $(clone).insertBefore($('#phaseStepList').children().last());
                    clone.find('.btn-delete').bind("click", {format: format, id: id}, function (event) {
                        event.preventDefault();
                        removeLocalItem(event.data.id + ".data");
                        checkPreviewAvailability();
                    });
                    if (format === SUS) {
                        setLocalItem(id + ".data", getLocalItem(STUDY_ORIGIN_SUS));
                    }
                }

                checkCurrentListState($('#phaseStepList'));
            }

            $('#panelSurveySwitch').on('change', function (event, id) {
                event.preventDefault();
                if (id === $(this).find('#yes').attr('id')) {
                    $('#panel-survey-container').removeClass('hidden');
                } else {
                    $('#panel-survey-container').addClass('hidden');
                }
            });

            $('#phaseSelect').on('change', function (event, id) {
                event.preventDefault();
                $('#create-tab-navigation #catalogs').removeClass('hidden');
                $('#create-tab-navigation #phases').removeClass('hidden');
                if (id === TYPE_PHASE_ELICITATION) {
                    $('#phaseStepSelect').find('.' + id).removeClass('hidden');
                    $('#phaseStepSelect').find('.' + TYPE_PHASE_EVALUATION).addClass('hidden');
                    $('#scenes-catalog, #feedback-catalog').addClass('hidden');
                } else if (id === TYPE_PHASE_EVALUATION) {
                    $('#phaseStepSelect').find('.' + id).removeClass('hidden');
                    $('#phaseStepSelect').find('.' + TYPE_PHASE_ELICITATION).addClass('hidden');
                    $('#scenes-catalog, #feedback-catalog').removeClass('hidden');
                }

                renderPhaseSteps();
            });

            $('.breadcrumb li').click(function () {
                clearSceneImages();
                clearSounds();
                clearLocalItems();
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
                }
            });

            $('#btn-save-study').click(function (event) {
                event.preventDefault();
                if (checkInputs() === true) {
                    var button = $(this);
//                    $(button).addClass('disabled');
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
                }
            });

            function checkInputs() {
                resetErrors();
                var errors = 0;
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

            $('#btn-more-infos-phases').on('click', function (event) {
                event.preventDefault();
                if (getLocalItem(STUDY).phase === TYPE_PHASE_EVALUATION) {
                    loadHTMLintoModal('custom-modal', 'create-info-phases-evaluation.php');
                } else {
                    loadHTMLintoModal('custom-modal', 'create-info-phases-identification.php');
                }
            });

            $('#btn-more-infos-catalogs').on('click', function (event) {
                event.preventDefault();
                if (getLocalItem(STUDY).phase === TYPE_PHASE_EVALUATION) {
                    loadHTMLintoModal('custom-modal', 'create-info-catalogs-evaluation.php');
                } else {
                    loadHTMLintoModal('custom-modal', 'create-info-catalogs-identification.php');
                }
            });

        </script>

    </body>
</html>