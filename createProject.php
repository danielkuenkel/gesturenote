<?php
include './includes/language.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GestureNote</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/createProject.css">
        <link rel="stylesheet" href="css/gesture.css">
        <link rel="stylesheet" href="externals/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="bootstrap-datepicker/css/bootstrap-datepicker3.css">
        <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
        <link rel="stylesheet" href="bootstrap-slider/css/bootstrap-slider.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.4.4/randomColor.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>
        <script src="http://chancejs.com/chance.min.js"></script>

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

        <script src="js/globalFunctions.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/localforage.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/language.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/gotoPage.js"></script>        
        <script src="js/thumbscrubber.js"></script>
        <script src="js/subPages.js"></script>
        <script src="js/createProject.js"></script>
        <script src="js/gesture.js"></script>

    </head>
    <body>

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-gesture"></div>
        <div id="template-inputs"></div>

        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index">Home</a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard">Dashboard</a></li>
                    <li><a class="breadcrump-btn" id="btn-projects">Projekte</a></li>
                    <li class="active">Neues Projekt</li>
                </ol>
            </div>
        </div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                </div>
            </div>
        </div>

        <!-- Container (Landing Section) -->
        <!--        <div class="container-fluid text-center bg-grey" id="landingText">
                    <div class="container">
                        <h2>NEUES PROJEKT ERSTELLEN</h2>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>-->

        <div class="container mainContent">
            <div class="row">

                <!-- Formular -->
                <div class="col-sm-12 col-md-7">

                    <h3>Allgemeines</h3>
                    <form role="form">


                        <!-- project name -->

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Projektname</span>
                                <input type="text" class="form-control" id="projectName" placeholder="Projektname einfügen" required>
                                <label class="sr-only" for="projectName">Projektname</label>
                                <span class="input-group-addon" onclick="loadHTMLintoModal('custom-modal', 'info-projectName.html')">
                                    <i class="glyphicon glyphicon-question-sign"></i>
                                </span>
                            </div>
                        </div>


                        <!-- project description -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Projektbeschreibung</span>
                                <textarea class="form-control" id="projectDescription" rows="5" placeholder="Beschreibung einfügen"></textarea>
                                <label class="sr-only" for="projectDescription">Projektbeschreibung</label>
                                <span class="input-group-addon" onclick="loadHTMLintoModal('custom-modal', 'info-projectDescription.html')">
                                    <i class="glyphicon glyphicon-question-sign"></i>
                                </span>
                            </div>
                        </div>


                        <!-- manner dropdowns -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Projektphase</span>
                                <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="Bitte wählen"/>
                                <div class="input-group-btn select saveGeneralData" id="phaseSelect" role="group">
                                    <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                    <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                        <li id="elicitation"><a href="#"><?php echo $lang->phaseType->elicitation ?></a></li>
                                        <li id="evaluation"><a href="#"><?php echo $lang->phaseType->evaluation ?></a></li>
                                    </ul>
                                    <button class="btn btn-addon btn-shadow" id="btn-info-phase">
                                        <i class="glyphicon glyphicon-question-sign"></i>
                                    </button>
                                </div>
<!--                                <span class="input-group-addon" onclick="loadHTMLintoModal('custom-modal', 'info-project-phase.html')">
                                    <i class="glyphicon glyphicon-question-sign"></i>
                                </span>-->
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Befragungsart</span>
                                <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="Bitte wählen"/>
                                <div class="input-group-btn select saveGeneralData" id="surveyTypeSelect" role="group">
                                    <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                    <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                        <li id="moderated"><a href="#"><?php echo $lang->surveyType->moderated ?></a></li>
                                        <li id="unmoderated"><a href="#"><?php echo $lang->surveyType->unmoderated ?></a></li>
                                    </ul>
                                    <button class="btn btn-addon btn-shadow disabled dropdown-disabled" id="btn-info-survey-type">
                                        <i class="glyphicon glyphicon-question-sign"></i>
                                    </button>
                                </div>
<!--                                <span class="input-group-addon" onclick="loadHTMLintoModal('custom-modal', 'info-project-survey-type.html')">
                                    <i class="glyphicon glyphicon-question-sign"></i>
                                </span>-->
                            </div>
                        </div>


                        <hr>

                        <!-- Demonstrator -->
                        <h3>Prototypen & Demonstratoren</h3>
                        <div class="form-group">
                            <div class="btn-group" id="usePrototypesSwitch">
                                <button class="btn btn-default switchButtonAddon">Prototypen benutzen?</button>
                                <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive" id="yes" name="btn-success">Ja</button>
                                <button class="btn btn-warning btn-shadow btn-toggle-checkbox saveGeneralData active" id="no" name="btn-warning">Nein</button>
                                <button class="btn btn-default btn-shadow supplement hidden" id="assemble-prototypes-set">
                                    <i class="glyphicon glyphicon-th"></i> <span class="hidden-md hidden-xs hidden-sm">Prototypen koppeln</span></button>
                                <button class="btn btn-addon" id="btn-prototypes-info">
                                    <i class="glyphicon glyphicon-question-sign"></i>
                                </button>
                            </div>
                        </div>


                        <hr>


                        <!-- Use of well/predefined gestures -->
                        <h3>Verwendung von Gesten und Funktionen</h3>

                        <div class="form-group">
                            <div class="btn-group" id="useGesturesSwitch">
                                <button class="btn btn-default switchButtonAddon">Gesten nutzen?</button>
                                <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive" id="yes" name="btn-success">Ja</button>
                                <button class="btn btn-warning btn-shadow btn-toggle-checkbox saveGeneralData active" id="no" name="btn-warning">Nein</button>
                                <button class="btn btn-default btn-shadow supplement hidden" id="assemble-gesture-set">
                                    <i class="glyphicon glyphicon-th"></i> <span class="hidden-md hidden-xs hidden-sm">Gestenset zusammenstellen</span></button>
                                <button class="btn btn-addon" id="btn-use-gestures-info">
                                    <i class="glyphicon glyphicon-question-sign"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Use of well/predefined trigger -->

                        <div class="form-group">
                            <div class="btn-group" id="useTriggerSwitch">
                                <button class="btn btn-default switchButtonAddon">Trigger nutzen?</button>
                                <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive" id="yes" name="btn-success">Ja</button>
                                <button class="btn btn-warning btn-shadow btn-toggle-checkbox saveGeneralData active" id="no" name="btn-warning">Nein</button>
                                <button class="btn btn-default btn-shadow supplement hidden" id="assemble-trigger-set">
                                    <i class="glyphicon glyphicon-th"></i> <span class="hidden-md hidden-xs hidden-sm">Trigger erstellen</span></button>
                                <button class="btn btn-addon" id="btn-use-trigger-info">
                                    <i class="glyphicon glyphicon-question-sign"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Use of well/predefined feedback -->

                        <div class="form-group">
                            <div class="btn-group" id="useFeedbackSwitch">
                                <button class="btn btn-default switchButtonAddon">Feedback nutzen?</button>
                                <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive" id="yes" name="btn-success">Ja</button>
                                <button class="btn btn-warning btn-shadow btn-toggle-checkbox saveGeneralData active" id="no" name="btn-warning">Nein</button>
                                <button class="btn btn-default btn-shadow supplement hidden" id="assemble-feedback-set">
                                    <i class="glyphicon glyphicon-th"></i> <span class="hidden-md hidden-xs hidden-sm">Feedback erstellen</span></button>
                                <button class="btn btn-addon" id="btn-use-feedback-info">
                                    <i class="glyphicon glyphicon-question-sign"></i>
                                </button>
                            </div>
                        </div>

                        <hr>

                        <!-- project phases with dropdown -->
                        <h3>Leitfaden</h3>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Phasenschritt</span>
                                <input class="form-control item-input-text option-survey-type show-dropdown text-center readonly" type="text" value="Bitte wählen"/>
                                <div class="input-group-btn select saveGeneralData" id="phaseStepSelect"  role="group">
                                    <button class="btn btn-default btn-shadow btn-dropdown" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                    <ul class="dropdown-menu option" role="menu">
                                        <li class="dropdown-header">Fragebögen</li>
                                        <li id="questionnaire"><a href="#"><?php echo $lang->formats->questionnaire ?></a></li>
                                        <li id="gus"><a href="#"><?php echo $lang->formats->gus ?></a></li>
                                        <li id="questionnaireGestures"><a href="#"><?php echo $lang->formats->questionnaireGestures ?></a></li>
                                        <li id="sus"><a href="#"><?php echo $lang->formats->sus ?></a></li>
                                        <li class="divider"></li>
                                        <li class="dropdown-header">Songstiges</li>
                                        <li id="letterOfAcceptance"><a href="#"><?php echo $lang->formats->letterOfAcceptance ?></a></li>
                                        <li id="gestureTraining"><a href="#"><?php echo $lang->formats->gestureTraining ?></a></li>
                                        <li id="scenario"><a href="#"><?php echo $lang->formats->scenario ?></a></li>
                                        <li id="slideshow"><a href="#"><?php echo $lang->formats->slideshow ?></a></li>
                                    </ul>
                                    <button class="btn btn-info btn-shadow disabled dropdown-disabled" id="addPhaseStep" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                    <button class="btn btn-addon btn-shadow disabled dropdown-disabled" id="info-addon-add-phases">
                                        <i class="glyphicon glyphicon-question-sign"></i>
                                    </button>
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
                                <button class="btn btn-addon">
                                    <i class="glyphicon glyphicon-question-sign"></i>
                                </button>
                            </div>
                        </div>

                        <hr>

                        <!-- project phases with dropdown -->
                        <h3>Wer, Was & Wann?</h3>

                        <div class="form-group" id="ageSlider">
                            <span class="slider-from" name="age">von</span>
                            <input class="custom-range-slider saveGeneralData" type="text" value="" data-slider-step="1"/>
                            <span class="slider-to">bis</span>
                        </div>

                        <div class="form-group">
                            <div class="btn-group" id="genderSwitch">
                                <button class="btn btn-default switchButtonAddon">Geschlecht</button>
                                <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive" id="female" name="btn-success">weiblich</button>
                                <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive" id="male" name="btn-success">männlich</button>
                                <button class="btn btn-default btn-shadow btn-toggle-checkbox saveGeneralData inactive" id="identical" name="btn-success">egal</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Aufzeichnung</span>
                                <input class="form-control item-input-text option-record show-dropdown text-center readonly" type="text" value="Bitte wählen"/>
                                <div class="input-group-btn select saveGeneralData" id="recordSelect" role="group">
                                    <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-bottom-right-radius: 0px; border-top-right-radius: 0px;"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                    <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                        <li id="videoAudio"><a href="#">Video & Audio</a></li>
                                        <li id="videoAudioScreen"><a href="#">Video, Audio & Bildschirm</a></li>
                                    </ul>
                                    <button class="btn btn-addon btn-shadow disabled dropdown-disabled" id="info-record">
                                        <i class="glyphicon glyphicon-question-sign"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="from-To-datepicker">
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon">Studie läuft von</span>
                                <input type="text" class="input form-control readonly" id="start" name="start" />
                                <span class="input-group-addon">bis</span>
                                <input type="text" class="input form-control readonly" id="end" name="end" />
                                <span class="input-group-addon" onclick="loadHTMLintoModal('custom-modal', 'info-period.html')">
                                    <i class="glyphicon glyphicon-question-sign"></i>
                                </span>
                            </div>
                        </div>

                        <hr>

                        <!-- submit form button group -->
                        <div class="btn-group-vertical btn-block" role="group">
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger btn-shadow btn-md" id="btn-clear-data"><i class="glyphicon glyphicon-trash"></i> Alle Eingaben löschen</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning btn-shadow btn-md" id="btn-preview-project"><i class="glyphicon glyphicon-eye-open"></i> Vorschau des Projekts</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-shadow btn-lg"><span class="glyphicon glyphicon-save"></span> Projekt erstellen</button>
                            </div>
                        </div>

                    </form>
                </div>

                <!-- Guidelines -->
                <div class="col-sm-12 col-md-4 col-md-offset-1">
                    <div class="gn"><h3>Guidelines</h3></div>
                    <span id="styleguide-info">
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    </span>
                    <br><br>
                    <button type="button" class="btn btn-gn btn-shadow" onclick="loadHTMLintoModal('custom-modal', 'info-styleguides.html');"><span class="glyphicon glyphicon-info-sign"></span> Mehr Informationen</button>
                </div>
            </div>
        </div>

<!--<iframe src="http://www.apple.de" style="width:100%; height: 500px; border:none;" name="test" scrolling="yes" frameborder="0" align=aus marginheight="0" marginwidth="0"></iframe>-->


        <script>
            $(document).ready(function () {
                createRandomColors();

                checkLanguage();

                var externals = new Array();
                externals.push(['#alerts', PATH_EXTERNALS + '/' + currentLanguage + '/alerts.html']);
                externals.push(['#template-gesture', PATH_EXTERNALS + '/' + currentLanguage + '/template-gesture.html']);
                externals.push(['#template-inputs', PATH_EXTERNALS + '/' + currentLanguage + '/template-create.html']);
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

            function onAllExternalsLoadedSuccessfully() {
                // get min and max age from datebase
                var ageMin = 18;
                var ageMax = 100;
                if (getLocalItem(PROJECT) && getLocalItem(PROJECT).ageRange) {
//                    $("#ageSlider .custom-range-slider").slider({min: ageMin, max: ageMax, value: getLocalItem(PROJECT).ageRange.ageRange});
                } else {
                    $("#ageSlider .custom-range-slider").slider({min: ageMin, max: ageMax, value: [23, 50]});
                }

                $('#ageSlider .slider-from').text(translation[$('#ageSlider .slider-from').attr('name')] + " " + translation.from + " " + ageMin);
                $('#ageSlider .slider-to').text(translation.to + " " + ageMax);

                if (typeof (Storage) !== "undefined") {
                    checkSessionStorage();
                } else {
                    console.log("Sorry, your browser do not support Web Session Storage.");
                }
            }

            $('.breadcrumb li a').on('click', function () {
                clearLocalItems();
            });

            $('#assemble-prototypes-set').on('click', function (event) {
                event.preventDefault();
                currentIdForModal = ASSEMBLED_PROTOTYPES;
                loadHTMLintoModal('custom-modal', 'create-prototypes-catalog.html', 'modal-lg');
            });

            $('#usePrototypesSwitch #no, #usePrototypesSwitch .switchButtonAddon').on('click', function (event) {
                event.preventDefault();
                if (!$(this).parent().find('#no').hasClass('active') === true) {
                    removeAssembledPrototypes();
                }
            });

            $('#assemble-gesture-set').on('click', function (event) {
                event.preventDefault();
                currentIdForModal = PREDEFINED_GESTURE_SET;
                loadHTMLintoModal('custom-modal', 'create-gesture-catalog.html', 'modal-lg');
            });

            $('#useGesturesSwitch #no, #useGesturesSwitch .switchButtonAddon').on('click', function (event) {
                event.preventDefault();
                if (!$(this).parent().find('#no').hasClass('active') === true) {
                    removeAssembledGestures();
                }
            });

            $('#assemble-trigger-set').on('click', function (event) {
                event.preventDefault();
                currentIdForModal = ASSEMBLED_TRIGGER;
                loadHTMLintoModal('custom-modal', 'create-trigger-catalog.html', 'modal-lg');
            });

            $('#useTriggerSwitch #no, #useTriggerSwitch .switchButtonAddon').on('click', function (event) {
                event.preventDefault();
                if (!$(this).parent().find('#no').hasClass('active') === true) {
                    removeAssembledTrigger();
                }
            });

            $('#assemble-feedback-set').on('click', function (event) {
                event.preventDefault();
                currentIdForModal = ASSEMBLED_FEEDBACK;
                loadHTMLintoModal('custom-modal', 'create-feedback-catalog.html', 'modal-lg');
            });

            $('#useFeedbackSwitch #no, #useFeedbackSwitch .switchButtonAddon').on('click', function (event) {
                event.preventDefault();
                if (!$(this).parent().find('#no').hasClass('active') === true) {
                    removeAssembledFeedback();
                }
            });

            $('#btn-info-phase').on('click', function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'info-project-phase.html');
            });

            $('#btn-info-survey-type').on('click', function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'info-project-survey-type.html');
            });

            $('#btn-prototypes-info').on('click', function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'info-prototypes.html');
            });

            $('#btn-use-gestures-info').on('click', function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'info-use-gestures.html');
            });

            $('#btn-use-trigger-info').on('click', function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'info-use-trigger.html');
            });

            $('#btn-use-feedback-info').on('click', function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'info-use-feedback.html');
            });

            $('#info-addon-add-phases, #info-record').on('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    var selectedID = $(this).parent().find('.chosen').attr('id');
                    loadHTMLintoModal("custom-modal", "info-" + selectedID + ".html", "modal-md");
                }
            });

            $('#addPhaseStep').on('click', function (event) {
                event.preventDefault();
                var selectedID = $(this).parent().find('.chosen').attr('id');
                if (!$(this).hasClass('disabled') && selectedID !== 'unselected') {
                    var selectedText = $(this).parent().prev().val();
                    addPhaseStep(chance.natural(), selectedID, selectedText, null);
                    savePhases();
                }
            });

            function addPhaseStep(id, selectedID, childText, color) {
                var clone = $('#phaseStepItem').clone();
                clone.removeClass('hidden');
                clone.attr('id', id);
                $('#phaseStepList').append(clone);

                clone.find('.btn-delete').bind("click", {selectedID: selectedID, id: id}, function (event) {
                    event.preventDefault();
                    removeLocalItem(event.data.id + ".data");
                });

                clone.find('.btn-modify').attr('id', selectedID);
                clone.find('.btn-modify').bind("click", {selectedID: selectedID, id: id}, function (event) {
                    event.preventDefault();
                    currentIdForModal = event.data.id;
                    loadHTMLintoModal("custom-modal", "create-" + event.data.selectedID + ".html", "modal-lg");
                });

                clone.find('.glyphicon-tag').css('color', color === null ? color = colors.pop() : color);
                clone.find('.phase-step-format').text(" " + childText);
                clone.find('.btn-text-button').bind("click", {selectedID: selectedID, id: id}, function (event) {
                    event.preventDefault();
                    currentIdForModal = event.data.id;
                    loadHTMLintoModal("custom-modal", "create-" + event.data.selectedID + ".html", "modal-lg");
                });

                clone.find('.btn-addon').bind('click', {selectedID: selectedID}, function (event) {
                    event.preventDefault();
                    loadHTMLintoModal("custom-modal", "info-" + event.data.selectedID + ".html", "modal-md");
                });

                checkCurrentListState($('#phaseStepList'));
            }

            $('#btn-clear-data').on('click', function (event) {
                event.preventDefault();
                clearLocalItems();
                location.reload(true);
            });

            $('#btn-preview-project').on('click', function (event) {
                event.preventDefault();
                if (checkInputs() === true) {
                    saveGeneralData();
                    gotoCreateProjectPreview();
                }
            });

            function checkInputs() {
                resetErrors();
                var errors = 0;

                if ($('#projectName').val().trim() === "") {
                    $('#projectName').closest('.form-group').addClass('has-error');
                    errors++;
                }

                if ($('#projectDescription').val().trim() === "") {
                    $('#projectDescription').closest('.form-group').addClass('has-error');
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
                $('#projectName').closest('.form-group').removeClass('has-error');
                $('#projectDescription').closest('.form-group').removeClass('has-error');
                $('#phaseSelect').closest('.form-group').removeClass('has-error');
                $('#surveyTypeSelect').closest('.form-group').removeClass('has-error');
            }
        </script>

    </body>
</html>