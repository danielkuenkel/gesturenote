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
        <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.4.4/randomColor.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
        <script src="http://chancejs.com/chance.min.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/thumbscrubber.js"></script>
        <script src="js/gotoPage.js"></script>
        <script src="js/subPages.js"></script>
        <script src="js/createProject.js"></script>
    </head>
    <body>

        <div w3-include-HTML="template-forms.html"></div>

        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" onclick="gotoIndex()">Home</a></li>
                    <li><a class="breadcrump-btn" onclick="gotoMainLanding()">Hauptmenü</a></li>
                    <li><a class="breadcrump-btn" onclick="gotoProjects()">Projekte</a></li>
                    <li class="active">Neues Projekt</li>
                </ol>
            </div>
        </div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">

                </div>
            </div>
        </div>

        <!-- Container (Landing Section) -->
        <div class="container-fluid text-center bg-grey" id="landingText">
            <div class="container">
                <h2>NEUES PROJEKT ERSTELLEN</h2>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
            </div>
        </div>

        <div class="container mainContent">
            <div class="row">

                <!-- Formular -->
                <div class="col-sm-12 col-md-7">

                    <h3>Allgemeines</h3>
                    <form role="form">


                        <!-- project name -->
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" id="projectName" placeholder="Projektname einfügen">
                                <label class="sr-only" for="projectName">Projektname</label>
                                <span class="input-group-addon" onclick="loadHTMLintoModal('custom-modal', 'info-projectName.html')">
                                    <i class="glyphicon glyphicon-question-sign"></i>
                                </span>
                            </div>
                        </div>


                        <!-- project description -->
                        <div class="form-group">
                            <div class="input-group">
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
                                <input class="form-control item-input-text option-phase text-center readonly" type="text" value="Bitte wählen"/>
                                <div class="input-group-btn select saveGeneralData" id="phaseSelect" role="group">
                                    <button class="btn btn-default btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="selected hidden" id="unselected"></span><span class="caret"></span></button>
                                    <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                        <li id="elicitation"><a href="#">Ermittlung</a></li>
                                        <li id="evaluation"><a href="#">Evaluierung</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Befragungsart</span>
                                <input class="form-control item-input-text option-survey-type text-center readonly" type="text" value="Bitte wählen"/>
                                <div class="input-group-btn select saveGeneralData" id="surveyTypeSelect" role="group">
                                    <button class="btn btn-default btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="selected hidden" id="unselected"></span><span class="caret"></span></button>
                                    <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                        <li id="moderated"><a href="#">Moderiert</a></li>
                                        <li id="unmoderated"><a href="#">Unmoderiert</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <!--                        <div class="dropdown">
                                                    <div class="btn-group btn-group-justified">-->

<!--                                <span class="input-group-addon">Projektphase</span>
                                <div class="btn-group select" id="phaseSelect" role="group">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span class="selected" id="unselected">Bitte wählen</span><span class="pull-right"><span class="caret"></span></span></button>
                                    <ul class="dropdown-menu option" role="menu">
                                        <li id="elicitation"><a href="#">Ermittlung</a></li>
                                        <li id="evaluation"><a href="#">Evaluierung</a></li>
                                    </ul>
                                </div>-->

<!--                                <span class="input-group-addon">Befragungsart</span>
                                <div class="btn-group select" id="surveyTypeSelect" role="group">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span class="selected" id="unselected">Bitte wählen</span><span class="pull-right"><span class="caret"></span></span></button>
                                    <ul class="dropdown-menu option" role="menu">
                                        <li id="moderated"><a href="#">Moderiert</a></li>
                                        <li id="unmoderated"><a href="#">Unmoderiert</a></li>
                                    </ul>
                                </div>-->
                        <!--                            </div>
                                                </div>-->

                        <hr>

                        <!-- Demonstrator -->
                        <h3>Prototypen & Demonstratoren</h3>
                        <div class="form-group">
                            <div class="btn-group" id="usePrototypesSwitch">
                                <button class="btn btn-default switchButtonAddon">Prototypen benutzen?</button>
                                <button class="btn btn-default btn-toggle-checkbox saveGeneralData inactive" id="yes" name="btn-success">Ja</button>
                                <button class="btn btn-warning btn-toggle-checkbox saveGeneralData active" id="no" name="btn-warning">Nein</button>
                                <button class="btn btn-default supplement hidden" id="assemble-prototypes-set">
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
                                <button class="btn btn-default btn-toggle-checkbox saveGeneralData inactive" id="yes" name="btn-success">Ja</button>
                                <button class="btn btn-warning btn-toggle-checkbox saveGeneralData active" id="no" name="btn-warning">Nein</button>
                                <button class="btn btn-default supplement hidden" id="assemble-gesture-set">
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
                                <button class="btn btn-default btn-toggle-checkbox saveGeneralData inactive" id="yes" name="btn-success">Ja</button>
                                <button class="btn btn-warning btn-toggle-checkbox saveGeneralData active" id="no" name="btn-warning">Nein</button>
                                <button class="btn btn-default supplement hidden" id="assemble-trigger-set">
                                    <i class="glyphicon glyphicon-th"></i> <span class="hidden-md hidden-xs hidden-sm">Trigger erstellen</span></button>
                                <button class="btn btn-addon" id="btn-use-trigger-info">
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
                                <input class="form-control item-input-text option-survey-type text-center readonly" type="text" value="Bitte wählen"/>
                                <div class="input-group-btn select saveGeneralData" id="phaseStepSelect"  role="group">
                                    <button class="btn btn-default btn-dropdown" type="button" data-toggle="dropdown"><span class="selected hidden" id="unselected"></span><span class="caret"></span></button>
                                    <ul class="dropdown-menu option" role="menu">
                                        <li class="dropdown-header">Fragebögen</li>
                                        <li id="questionnaire"><a href="#">Fragebogen</a></li>
                                        <li id="gus"><a href="#">GUS (einzelne Geste)</a></li>
                                        <li id="questionnaire-gestures"><a href="#">GUS (Allgemeine Fragen)</a></li>
                                        <li id="sus"><a href="#">SUS</a></li>
                                        <li class="divider"></li>
                                        <li class="dropdown-header">Songstiges</li>
                                        <li id="letterOfAcceptance"><a href="#">Einverständniserklärung</a></li>
                                        <li id="gestureTraining"><a href="#">Gestentraining</a></li>
                                        <li id="scenario"><a href="#">Szenario-basierte Aufgabe</a></li>
                                    </ul>
                                    <button class="btn btn-info disabled dropdown-disabled" id="addPhaseStep" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                    <button class="btn btn-addon disabled dropdown-disabled" id="info-addon-add-phases">
                                        <i class="glyphicon glyphicon-question-sign"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!--                        <div class="form-group">
                                                    <div class="btn-group btn-group-justified" role="group">
                        
                                                        <span class="input-group-addon" id="addPhaseStepSelectAddon">Phasenschritt</span>
                        
                                                        <div class="btn-group select dropup" id="addPhaseStepSelect" role="group">
                                                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span class="selected" id="unselected">Bitte wählen</span><span class="pull-right"><span class="caret"></span></span></button>
                                                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                                                <li class="dropdown-header">Fragebögen</li>
                                                                <li id="questionnaire"><a href="#">Fragebogen</a></li>
                                                                <li id="gus"><a href="#">GUS (einzelne Geste)</a></li>
                                                                <li id="questionnaire-gestures"><a href="#">GUS (Allgemeine Fragen)</a></li>
                                                                <li id="sus"><a href="#">SUS</a></li>
                                                                <li class="divider"></li>
                                                                <li class="dropdown-header">Songstiges</li>
                                                                <li id="letterOfAcceptance"><a href="#">Einverständniserklärung</a></li>
                                                                <li id="gestureTraining"><a href="#">Gestentraining</a></li>
                                                                <li id="scenario"><a href="#">Szenario-basierte Aufgabe</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="btn-group" role="group">
                                                            <button class="btn btn-info disabled toggable-button" id="addPhaseStep" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                                        </div>
                                                        <span class="input-group-addon info-addon info-addon-disabled toggable-info" id="info-addon-add-phases">
                                                            <i class="glyphicon glyphicon-question-sign"></i>
                                                        </span>
                                                    </div>
                                                </div>-->


                        <!-- phase step list items -->
                        <div class="form-group" id="phaseStepList"></div>

                        <div class="form-group hidden root" id="phaseStepItem">
                            <div class="btn-group">
                                <button class="btn btn-default btn-up" title="Weiter nach oben">
                                    <i class="glyphicon glyphicon-arrow-up"></i>
                                </button>
                                <button class="btn btn-default btn-down" title="Weiter nach unten">
                                    <i class="glyphicon glyphicon-arrow-down"></i>
                                </button>
                                <button class="btn btn-default btn-delete" title="Löschen">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                                <button class="btn btn-default btn-modify" title="Bearbeiten">
                                    <i class="glyphicon glyphicon-cog"></i>
                                </button>
                                <button class="btn btn-default btn-text-button">
                                    <span class="glyphicon glyphicon-tag"></span><span class="phase-step-format"></span>
                                </button>
                                <button class="btn btn-addon">
                                    <i class="glyphicon glyphicon-question-sign"></i>
                                </button>
                            </div>
                        </div>

                        <hr>

                        <!-- project phases with dropdown -->
                        <h3>Was & Wer?</h3>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Aufzeichnung</span>
                                <input class="form-control item-input-text option-record text-center readonly" type="text" value="Bitte wählen"/>
                                <div class="input-group-btn select saveGeneralData" id="recordSelect" role="group">
                                    <button class="btn btn-default btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="selected hidden" id="unselected"></span><span class="caret"></span></button>
                                    <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                        <li id="videoAudio"><a href="#">Video & Audio</a></li>
                                        <li id="videoAudioScreen"><a href="#">Video, Audio & Bildschirm</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- submit form button group -->
                        <div class="btn-group-vertical btn-block" role="group">
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger btn-md" onclick="clearLocalItems()"><i class="glyphicon glyphicon-trash"></i> Alle Eingaben löschen</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning btn-md"><i class="glyphicon glyphicon-eye-open"></i> Vorschau des Projekts</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-save"></span> Projekt erstellen</button>
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
                    <button type="button" class="btn btn-gn" onclick="loadHTMLintoModal('custom-modal', 'info-styleguides.html');"><span class="glyphicon glyphicon-info-sign"></span> Mehr Informationen</button>
                </div>
            </div>
        </div>

<!--<iframe src="http://www.apple.de" style="width:100%; height: 500px; border:none;" name="test" scrolling="yes" frameborder="0" align=aus marginheight="0" marginwidth="0"></iframe>-->


        <script>
            $(document).ready(function () {
                createRandomColors();

                if (typeof (Storage) !== "undefined") {
                    checkSessionStorage();
                } else {
                    console.log("Sorry, your browser do not support Web Session Storage.");
                }
            });


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

            $('body').on('click', '.select .option li', function (event) {
                event.preventDefault();

                if ($(this).hasClass('dropdown-header') || $(this).hasClass('divider')) {
                    return false;
                }

                var parent = $(this).closest('.select');
                var itemText = $(this).children().text();
                var listItemId = $(this).attr('id');
                $(parent).find('.selected').attr('id', listItemId);
                $(parent).prev().val(itemText);

                var disabledElements = $(parent).children('.dropdown-disabled');
                if (disabledElements.length > 0) {
                    for (var i = 0; i < disabledElements.length; i++) {
                        $(disabledElements[i]).removeClass('disabled');
                    }
                }
                
                if(parent.hasClass('saveGeneralData')) {
                    saveGeneralData();
                }
            });


            $('#info-addon-add-phases').on('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    var selectedID = $(this).parent().find('.selected').attr('id');
                    loadHTMLintoModal("custom-modal", "info-" + selectedID + ".html", "modal-md");
                }
            });

            $('#addPhaseStep').on('click', function (event) {
                event.preventDefault();
                var selectedID = $(this).parent().find('.selected').attr('id');
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

            function checkCurrentListState(itemContainer) {
                var childList = $(itemContainer).children();
                for (var i = 0; i < childList.length; i++) {
                    var child = childList[i];
                    var firstElement = $(child).find('.btn-up').first();
                    var secondElement = firstElement.next();

                    firstElement.removeClass('disabled');
                    secondElement.removeClass('disabled');

                    if (i === 0) {
                        firstElement.addClass('disabled');
                    }
                    if (i === childList.length - 1) {
                        secondElement.addClass('disabled');
                    }
                }
            }

            $('body').on('click', '.btn-delete', function (event) {
                event.stopPropagation();
                event.preventDefault();
                var element = $(this).closest('.root');
                var parent = $(element).parent();
                currentContainerList = parent;
                $(element).remove();
                checkCurrentListState(parent);
                savePhases();
            });

            $('body').on('click', '.btn-up', function (event) {
                event.stopPropagation();
                event.preventDefault();
                moveElement("up", $(this));
                checkCurrentListState($(this).closest('.root').parent());
            });

            $('body').on('click', '.btn-down', function (event) {
                event.stopPropagation();
                event.preventDefault();
                moveElement("down", $(this));
                checkCurrentListState($(this).closest('.root').parent());
            });

            $('body').on('click', '.btn-toggle-checkbox', function (event) {
                event.preventDefault();
                if ($(this).hasClass('inactive')) {
                    if ($(this).parent().children('.active').length === 0) {
                        toggleSwitch(null, $(this));
                    } else {
                        toggleSwitch($(this).parent().children('.active'), $(this));
                    }
                }

                if ($(this).hasClass('saveGeneralData')) {
                    saveGeneralData();
                }
            });

            $('body').on('click', '.switchButtonAddon', function (event) {
                event.preventDefault();
                var activeButton = $(this).nextAll().filter('.active');
                var inactiveButton = $(this).nextAll().filter('.inactive');

                if (activeButton.length === 0) {
                    activeButton = null;
                    inactiveButton = $(this).next();

                }
                inactiveButton.click();
            });

            function toggleSwitch(activeButton, inactiveButton) {
                if (activeButton) {
                    $(activeButton).removeClass('active');
                    $(activeButton).addClass('inactive');
                    $(activeButton).addClass('btn-default');
                    $(activeButton).removeClass($(activeButton).attr('name'));
                }
                $(inactiveButton).removeClass('inactive');
                $(inactiveButton).addClass('active');
                $(inactiveButton).removeClass('btn-default');
                $(inactiveButton).addClass($(inactiveButton).attr('name'));

                var supplements = $(activeButton).parent().children('.supplement');
                if (supplements.length > 0) {
                    if ($(supplements).hasClass('hidden')) {
                        $(supplements).removeClass('hidden');
                    } else {
                        $(supplements).addClass('hidden');
                    }
                }
            }

            function moveElement(direction, which) {
                var element = $(which).closest('.root');
                var brother;
                switch (direction) {
                    case "up":
                        brother = $(which).closest('.root').prev();
                        $(element).insertBefore(brother);
                        break;
                    case "down":
                        brother = $(which).closest('.root').next();
                        $(element).insertAfter(brother);
                        break;
                }
                savePhases();
            }

            function loadHTMLintoModal(modalId, url, modalSize) {
                $.get(url, modalId, function (data) {
                    $('#' + modalId).find('.modal-content').html(data);
                });
                $('#' + modalId).modal('show');
                $('#' + modalId).find('.modal-dialog').addClass(modalSize);
                $('#' + modalId).on('hidden.bs.modal', function () {
                    $(this).removeData('bs.modal');
                    $(this).find('.modal-dialog').removeClass(modalSize);
                });
            }

        </script>
        <script src="js/w3-include-HTML.js"></script>

    </body>
</html>