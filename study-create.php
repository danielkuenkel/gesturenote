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
        <div class="container" id="breadcrumb">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index">Home</a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard">Dashboard</a></li>
                    <li><a class="breadcrump-btn" id="btn-studies">Studien</a></li>
                    <li class="active">Neue Studie</li>
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
                        <li role="presentation" id="general"><a href="#">Allgemeines</a></li>
                        <li role="presentation" id="catalogs"><a href="#">Kataloge</a></li>
                        <li role="presentation" id="phases"><a href="#">Leidfaden</a></li>
                        <li role="presentation" id="panel"><a href="#">Wer, Was & Wann?</a></li>
                    </ul>


                    <!-- tab general study data -->

                    <div class="tab-content hidden tab-general">

                        <!-- study name -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Studien-Titel</span>
                                <label class="sr-only" for="studyTitle">Studien-Titel</label>
                                <input type="text" class="form-control" id="studyTitle" placeholder="Studien-Titel einfügen" required>
                            </div>
                        </div>


                        <!-- study description -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Studienbeschreibung</span>
                                <label class="sr-only" for="studyDescription">Studienbeschreibung</label>
                                <textarea class="form-control" id="studyDescription" rows="5" placeholder="Beschreibung einfügen"></textarea>
                            </div>
                        </div>


                        <!-- manner dropdowns -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Studienphase</span>
                                <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="Bitte wählen"/>
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
                                <span class="input-group-addon">Befragungsart</span>
                                <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="Bitte wählen"/>
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

                        <!-- Use of well/predefined sczenes -->
                        <div class="form-group" id="scenes-catalog">
                            <div class="btn-group">
                                <button class="btn btn-default btn-group-addon">Szenen</button>
                                <button class="btn btn-default btn-shadow" id="btn-clear-scenes">
                                    <i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs btn-text">Löschen</span>
                                </button>
                                <button class="btn btn-default btn-shadow" id="btn-assemble-scenes">
                                    <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="btn-text">Öffnen</span>
                                </button>
                            </div>
                        </div>

                        <!-- Use of well/predefined gestures -->
                        <div class="form-group" id="gestures-catalog">
                            <div class="btn-group">
                                <button class="btn btn-default btn-group-addon">Gesten</button>
                                <button class="btn btn-default btn-shadow hidden" id="btn-clear-study-gestures">
                                    <i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs btn-text">Löschen</span>
                                </button>
                                <button class="btn btn-default btn-shadow hidden" id="btn-study-gestures">
                                    <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="btn-text">Öffnen</span>
                                </button>
                                <button class="btn btn-default btn-shadow" id="btn-assemble-study-gestures">
                                    <i class="fa fa-star" aria-hidden="true"></i> <span class=""><span class="hidden-xs btn-text">Set </span>Zusammenstellen</span>
                                </button>
                                <button class="btn btn-default btn-shadow" id="btn-record-gestures">
                                    <i class="fa fa-video-camera" aria-hidden="true"></i> <span class="btn-text">Aufzeichnen</span>
                                </button>

                            </div>
                        </div>

                        <!-- Use of well/predefined trigger -->
                        <div class="form-group" id="trigger-catalog">
                            <div class="btn-group">
                                <button class="btn btn-default btn-group-addon">Funktionen</button>
                                <button class="btn btn-default btn-shadow" id="btn-clear-trigger">
                                    <i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs btn-text">Löschen</span>
                                </button>
                                <button class="btn btn-default btn-shadow" id="btn-assemble-trigger">
                                    <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="btn-text">Öffnen</span>
                                </button>
                            </div>
                        </div>

                        <!-- Use of well/predefined feedback -->
                        <div class="form-group" id="feedback-catalog">
                            <div class="btn-group">
                                <button class="btn btn-default btn-group-addon">Feedback</button>
                                <button class="btn btn-default btn-shadow" id="btn-clear-feedback">
                                    <i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs btn-text">Löschen</span>
                                </button>
                                <button class="btn btn-default btn-shadow" id="btn-assemble-feedback">
                                    <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="btn-text">Öffnen</span>
                                </button>
                            </div>
                        </div>
                    </div>


                    <!-- tab guide & phases -->

                    <div class="tab-content hidden tab-phases">

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Phasenschritt</span>
                                <input class="form-control item-input-text option-survey-type show-dropdown text-center readonly" type="text" value="Bitte wählen"/>
                                <div class="input-group-btn select saveGeneralData" id="phaseStepSelect"  role="group">
                                    <button class="btn btn-default btn-shadow btn-dropdown" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                    <ul class="dropdown-menu option" role="menu">
                                        <li class="dropdown-header">Fragebögen</li>
                                        <li id="questionnaire"><a href="#"><?php echo $lang->formats->questionnaire->text ?></a></li>
                                        <li id="gus" class="evaluation"><a href="#"><?php echo $lang->formats->gus->text ?></a></li>
                                        <li id="questionnaireGestures" class="evaluation"><a href="#"><?php echo $lang->formats->questionnaireGestures->text ?></a></li>
                                        <li id="sus" class="evaluation"><a href="#"><?php echo $lang->formats->sus->text ?></a></li>
                                        <li class="divider"></li>
                                        <li class="dropdown-header">Sonstiges</li>
                                        <li id="letterOfAcceptance"><a href="#"><?php echo $lang->formats->letterOfAcceptance->text ?></a></li>
                                        <li id="identification" class="elicitation"><a href="#"><?php echo $lang->formats->identification->text ?></a></li>
                                        <li id="gestureTraining" class="evaluation"><a href="#"><?php echo $lang->formats->gestureTraining->text ?></a></li>
                                        <li id="scenario" class="evaluation"><a href="#"><?php echo $lang->formats->scenario->text ?></a></li>
                                        <li id="gestureSlideshow" class="evaluation"><a href="#"><?php echo $lang->formats->gestureSlideshow->text ?></a></li>
                                        <li id="triggerSlideshow" class="evaluation"><a href="#"><?php echo $lang->formats->triggerSlideshow->text ?></a></li>
                                        <li id="physicalStressTest" class="evaluation"><a href="#"><?php echo $lang->formats->physicalStressTest->text ?></a></li>
                                        <li id="thanks"><a href="#"><?php echo $lang->formats->thanks->text ?></a></li>
                                    </ul>
                                    <button class="btn btn-info btn-shadow disabled dropdown-disabled" id="addPhaseStep" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                </div>
                            </div>
                        </div>

                        <!-- phase step list items -->
                        <div class="form-group" id="phaseStepList"></div>

                        <div class="form-group hidden root" id="phaseStepItem">
                            <div class="btn-group">
                                <button class="btn btn-default btn-shadow btn-up saveGeneralData" title="Weiter nach oben">
                                    <i class="glyphicon glyphicon-arrow-up"></i>
                                </button>
                                <button class="btn btn-default btn-shadow btn-down saveGeneralData" title="Weiter nach unten">
                                    <i class="glyphicon glyphicon-arrow-down"></i>
                                </button>
                                <button class="btn btn-default btn-shadow btn-delete saveGeneralData" title="Löschen">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                                <button class="btn btn-default btn-shadow btn-modify" title="Bearbeiten">
                                    <i class="glyphicon glyphicon-cog"></i>
                                </button>
                                <button class="btn btn-default btn-shadow btn-text-button">
                                    <span class="glyphicon glyphicon-tag"></span><span class="phase-step-format"></span>
                                </button>
                                <!--                                <button class="btn btn-addon">
                                                                    <i class="glyphicon glyphicon-question-sign"></i>
                                                                </button>-->
                            </div>
                        </div>
                    </div>


                    <!-- tab panels & survey data -->

                    <div class="tab-content hidden tab-panel">

                        <div class="form-group">
                            <div class="btn-group" id="panelSurveySwitch">
                                <button class="btn btn-default switchButtonAddon">Panel-Befragung</button>
                                <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive" id="yes" name="btn-success">Ja</button>
                                <button class="btn btn-warning btn-shadow btn-toggle-checkbox saveGeneralData active" id="no" name="btn-warning">Nein</button>
                            </div>
                        </div>

                        <div id="panel-survey-container" class="hidden">
                            <div class="form-group" id="ageSlider">
                                <span class="slider-from" name="age">von</span>
                                <input class="custom-range-slider saveGeneralData" type="text" value="" data-slider-step="1"/>
                                <span class="slider-to">bis</span>
                            </div>

                            <div class="form-group">
                                <div class="btn-group" id="genderSwitch">
                                    <button class="btn btn-default switchButtonAddon">Geschlecht</button>
                                    <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive" id="female" name="btn-success"><i class="fa fa-venus" aria-hidden="true"></i> weiblich</button>
                                    <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive" id="male" name="btn-success"><i class="fa fa-mars" aria-hidden="true"></i> männlich</button>
                                    <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive" id="identical" name="btn-success"><i class="fa fa-genderless" aria-hidden="true"></i> egal</button>
                                </div>
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
                            <button type="button" class="btn btn-danger btn-shadow btn-md" id="btn-clear-data"><i class="glyphicon glyphicon-trash"></i> Alle Eingaben löschen</button>
                            <button type="button" class="btn btn-warning btn-shadow btn-md disabled" id="btn-preview-study"><i class="glyphicon glyphicon-eye-open"></i> Vorschau der Studie</button>
                            <button type="button" class="btn btn-success btn-shadow btn-lg" id="btn-save-study"><i class="glyphicon glyphicon-save"></i> Studie speichern</button>
                        </div>
                    </div>

                </div>

                <!-- Guidelines -->
                <div class="col-sm-12 col-md-5" style="margin-top: 20px">
                    <div class="col-md-11 col-md-offset-1">
                        <div class="tab-content hidden tab-general">
                            <div class="gn"><h3>Allgemeines</h3></div>
                            <span id="styleguide-info">
                                Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                            </span>
                            <br><br>
                            <button type="button" class="btn btn-gn btn-shadow" onclick="loadHTMLintoModal('custom-modal', 'info-styleguides.html');"><span class="glyphicon glyphicon-info-sign"></span> Mehr Informationen</button>
                        </div>

                        <div class="tab-content hidden tab-catalogs">
                            <div class="gn"><h3>Kataloge</h3></div>
                            <span id="styleguide-info">
                                Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor 
                            </span>
                            <br><br>
                            <button type="button" class="btn btn-gn btn-shadow" onclick="loadHTMLintoModal('custom-modal', 'info-styleguides.html');"><span class="glyphicon glyphicon-info-sign"></span> Mehr Informationen</button>
                        </div>

                        <div class="tab-content hidden tab-phases">
                            <div class="gn"><h3>Leitfaden</h3></div>
                            <span id="styleguide-info">
                                Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, 
                            </span>
                            <br><br>
                            <button type="button" class="btn btn-gn btn-shadow" onclick="loadHTMLintoModal('custom-modal', 'info-styleguides.html');"><span class="glyphicon glyphicon-info-sign"></span> Mehr Informationen</button>
                        </div>

                        <div class="tab-content hidden tab-panel">
                            <div class="gn"><h3>Wer, Was & Wann?</h3></div>
                            <span id="styleguide-info">
                                aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.
                            </span>
                            <br><br>
                            <button type="button" class="btn btn-gn btn-shadow" onclick="loadHTMLintoModal('custom-modal', 'info-styleguides.html');"><span class="glyphicon glyphicon-info-sign"></span> Mehr Informationen</button>
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

                    var path = PATH_EXTERNALS + '/' + currentLanguage + '/';
                    var externals = new Array();
                    externals.push(['#alerts', path + '/alerts.html']);
                    externals.push(['#template-gesture', path + '/template-gesture.html']);
                    externals.push(['#template-inputs', path + '/template-create.html']);
                    externals.push(['#templage-subpages', path + '/template-sub-pages.html']);
                    externals.push(['#template-gesture-recorder', path + '/template-gesture-recorder.html']);
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
                    getStudyById({studyId: query.studyId}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            if (result.data) {
                                setStudyData(result);
                                init();
                            }
                        }
                    });
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
                var ageMin = 18;
                var ageMax = 100;
                if (getLocalItem(STUDY) && getLocalItem(STUDY).ageRange) {
//                    $("#ageSlider .custom-range-slider").slider({min: ageMin, max: ageMax, value: getLocalItem(STUDY).ageRange.ageRange});
                } else {
                    $("#ageSlider .custom-range-slider").slider({min: ageMin, max: ageMax, value: [23, 50]});
                }

                $('#ageSlider .slider-from').text(translation[$('#ageSlider .slider-from').attr('name')] + " " + translation.of + " " + ageMin);
                $('#ageSlider .slider-to').text(translation.to + " " + ageMax);

                if (typeof (Storage) !== "undefined") {
                    checkSessionStorage();
                } else {
                    appendAlert($('#mainContent'), ALERT_NO_STORAGE_API);
                }

                $('#create-tab-navigation').find('#general').click();
            }

            $('#custom-modal').on('hidden.bs.modal', function () {
                $(this).find('.modal-content').empty();
            });

            // scenes handling
            $('#btn-assemble-scenes').click(function (event) {
                event.preventDefault();
                currentIdForModal = ASSEMBLED_SCENES;
                loadHTMLintoModal('custom-modal', 'create-scenes-catalog.html', 'modal-lg');
            });

            $('#btn-clear-scenes').click(function (event) {
                event.preventDefault();
                removeAssembledScenes();
                updateCatalogButtons();
            });

            // gesture catalog handling
            $('#btn-assemble-study-gestures').click(function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'create-gesture-catalog.html', 'modal-lg');
            });

            $('#btn-study-gestures').click(function (event) {
                event.preventDefault();
                loadHTMLintoModal("custom-modal", "create-study-gestures.html", "modal-lg");
            });

            $('#btn-clear-study-gestures').click(function (event) {
                event.preventDefault();
                removeAssembledGestures();
                updateCatalogButtons();
            });

            $('#btn-record-gestures').click(function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'create-gesture-recorder.html', 'modal-md');
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
                loadHTMLintoModal('custom-modal', 'create-trigger-catalog.html', 'modal-lg');
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
                loadHTMLintoModal('custom-modal', 'create-feedback-catalog.html', 'modal-lg');
            });

            $('#btn-clear-feedback').click(function (event) {
                event.preventDefault();
                removeAssembledFeedback();
                updateCatalogButtons();
            });

//            $('#useFeedbackSwitch #no, #useFeedbackSwitch .switchButtonAddon').on('click', function (event) {
//                event.preventDefault();
//                if (!$(this).parent().find('#no').hasClass('active') === true) {
//                    removeAssembledFeedback();
//                }
//            });

//            $('#btn-info-phase').on('click', function (event) {
//                event.preventDefault();
//                loadHTMLintoModal('custom-modal', 'info-study-phase.html');
//            });
//
//            $('#btn-info-survey-type').on('click', function (event) {
//                event.preventDefault();
//                loadHTMLintoModal('custom-modal', 'info-study-survey-type.html');
//            });
//
//            $('#btn-scenes-info').on('click', function (event) {
//                event.preventDefault();
//                loadHTMLintoModal('custom-modal', 'info-scenes.html');
//            });
//
//            $('#btn-use-gestures-info').on('click', function (event) {
//                event.preventDefault();
//                loadHTMLintoModal('custom-modal', 'info-use-gestures.html');
//            });
//
//            $('#btn-use-trigger-info').on('click', function (event) {
//                event.preventDefault();
//                loadHTMLintoModal('custom-modal', 'info-use-trigger.html');
//            });
//
//            $('#btn-use-feedback-info').on('click', function (event) {
//                event.preventDefault();
//                loadHTMLintoModal('custom-modal', 'info-use-feedback.html');
//            });
//
//            $('#btn-info-record').on('click', function (event) {
//                event.preventDefault();
//                loadHTMLintoModal('custom-modal', 'info-record.html');
//            });

//            $('#info-addon-add-phases').on('click', function (event) {
//                event.preventDefault();
//                if (!$(this).hasClass('disabled')) {
//                    var format = $(this).parent().find('.chosen').attr('id');
//                    loadHTMLintoModal("custom-modal", "info-" + format + ".html", "modal-md");
//                }
//            });

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

                clone.find('.btn-delete').bind("click", {format: format, id: id}, function (event) {
                    event.preventDefault();
                    removeLocalItem(event.data.id + ".data");
                    checkPreviewAvailability();
                });

                clone.find('.btn-modify').attr('id', format);
//                clone.find('.btn-modify').bind("click", {format: format, id: id}, function (event) {
//                    event.preventDefault();
//                    currentIdForModal = event.data.id;
//                    loadHTMLintoModal("custom-modal", "create-" + event.data.format + ".html", "modal-lg");
//                });

                clone.find('.glyphicon-tag').css('color', color === null ? color = colors.pop() : color);
                clone.find('.phase-step-format').text(" " + translation.formats[format].text);
                clone.find('.btn-text-button, .btn-modify').bind("click", {format: format, id: id}, function (event) {
                    event.preventDefault();
                    currentIdForModal = event.data.id;
                    loadHTMLintoModal("custom-modal", "create-" + event.data.format + ".html", "modal-lg");
                });

                clone.find('.btn-addon').bind('click', {format: format}, function (event) {
                    event.preventDefault();
                    loadHTMLintoModal("custom-modal", "info-" + event.data.format + ".html", "modal-md");
                });

                if (format === SUS) {
                    setLocalItem(id + ".data", getLocalItem(STUDY_ORIGIN_SUS));
                }

                checkCurrentListState($('#phaseStepList'));
            }

            $('#panelSurveySwitch').on('change', function (event, id) {
                if (id === $(this).find('#yes').attr('id')) {
                    $('#panel-survey-container').removeClass('hidden');
                } else {
                    $('#panel-survey-container').addClass('hidden');
                }
            });

            $('#phaseSelect').on('change', function (event, id) {
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
            });

        </script>

    </body>
</html>