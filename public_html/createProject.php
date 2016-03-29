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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.4.4/randomColor.js"></script>

        <script src="js/thumbscrubber.js"></script>
        <script src="js/gotoPage.js"></script>
        <script src="js/subPages.js"></script>
        <script src="js/createProject.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

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
                        <div class="dropdown">
                            <div class="btn-group btn-group-justified">

                                <span class="input-group-addon">Projektphase</span>
                                <div class="btn-group select" id="phaseSelect" role="group">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span class="selected" id="unselected">Bitte wählen</span><span class="pull-right"><span class="caret"></span></span></button>
                                    <ul class="dropdown-menu option" role="menu">
                                        <li id="elicitation"><a href="#">Ermittlung</a></li>
                                        <li id="evaluation"><a href="#">Evaluierung</a></li>
                                    </ul>
                                </div>

                                <span class="input-group-addon">Befragungsart</span>
                                <div class="btn-group select" id="surveyTypeSelect" role="group">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span class="selected" id="unselected">Bitte wählen</span><span class="pull-right"><span class="caret"></span></span></button>
                                    <ul class="dropdown-menu option" role="menu">
                                        <li id="moderated"><a href="#">Moderiert</a></li>
                                        <li id="unmoderated"><a href="#">Unmoderiert</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Pidoco URL -->
                        <div class="form-group">
                            <div class="btn-group" id="pidocoURLSwitch">
                                <button class="btn btn-default switchButtonAddon" onclick="togglePidocoURLInput()">An Pidoco Prototypen koppeln?</button>
                                <button class="btn btn-default btn-toggle-checkbox inactive" id="success" onclick="showPidocoURLInput()">Ja</button>
                                <button class="btn btn-warning btn-toggle-checkbox active" id="warning" onclick="hidePidocoURLInput()">Nein</button>
                                <button class="btn btn-addon" id="btn-pidoco-info">
                                    <i class="glyphicon glyphicon-question-sign"></i>
                                </button>
                            </div>
                        </div>

                        <form>
                            <div class="form-group hidden" id="pidocoURLInput">
                                <input type="text"  class="form-control" id="pidocoURL" placeholder="Pidoco URL eingeben">
                                <label class="sr-only" for="pidocoURL">Pidoco URL</label>
                            </div> 
                        </form>


                        <hr>


                        <!-- Use of well/predefined gestures -->
                        <h3>Verwendung von Gesten</h3>

                        <div class="form-group">
                            <div class="btn-group" id="useGesturesSwitch">
                                <button class="btn btn-default switchButtonAddon" onclick="toggleGestureCatalog()">Gesten für die Studie nutzen?</button>
                                <button class="btn btn-default btn-toggle-checkbox inactive" id="success" onclick="showAssembleGestures()">Ja</button>
                                <button class="btn btn-warning btn-toggle-checkbox active" id="warning" onclick="hideAssembleGestures()">Nein</button>
                                <button class="btn btn-default hidden" id="assemble-gesture-set" onclick="onAssembleGestureSetClick()">
                                    <i class="glyphicon glyphicon-th"></i> <span class="hidden-md hidden-xs hidden-sm">Gestenset zusammenstellen</span></button>
                                <button class="btn btn-addon" id="btn-use-gestures-info">
                                    <i class="glyphicon glyphicon-question-sign"></i>
                                </button>
                            </div>
                        </div>

                        <hr>

                        <!-- project phases with dropdown -->
                        <h3>Leitfaden</h3>

                        <div class="form-group">
                            <div class="btn-group btn-group-justified" role="group">

                                <span class="input-group-addon" id="addPhaseStepSelectAddon">Phasenschritt</span>

                                <div class="btn-group select dropup" id="addPhaseStepSelect" role="group">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span class="selected" id="unselected">Bitte wählen</span><span class="pull-right"><span class="caret"></span></span></button>
                                    <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                        <li class="dropdown-header">Fragebögen</li>
                                        <li id="questionnaire"><a href="#">Fragebogen</a></li>
                                        <li id="gus"><a href="#">GUS</a></li>
                                        <li id="sus"><a href="#">SUS</a></li>
                                        <li class="divider"></li>
                                        <li class="dropdown-header">Songstiges</li>
                                        <li id="letterOfAcceptance"><a href="#">Einverständniserklärung</a></li>
                                        <li id="gestureTraining"><a href="#">Gestentraining</a></li>
                                        <li id="scenario"><a href="#">Szenario-basierte Aufgabe</a></li>
                                        <!--<li id="observationGuide"><a href="#">Beobachtungsbogen</a></li>-->
                                    </ul>
                                </div>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-info disabled toggable-button" id="addPhaseStep" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                </div>
                                <span class="input-group-addon info-addon info-addon-disabled toggable-info" id="info-addon-add-phases">
                                    <i class="glyphicon glyphicon-question-sign"></i>
                                </span>
                            </div>
                        </div>


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

                        <!-- submit form button group -->
                        <div class="btn-group-vertical btn-block" role="group">
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger btn-md" onclick="clearSessionStorage()"><i class="glyphicon glyphicon-trash"></i> Reset Session Storage</button>
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
                    <button type="button" class="btn btn-gn" onclick="loadHTMLintoModal('custom-modal', 'info-styleguides.html');"><span class="glyphicon glyphicon-info-sign"></span> Mehr Informationen abrufen</button>
                </div>
            </div>
        </div>


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
                clearSessionStorage();
            });

            $('body').on('click', '.select .option li', function (event) {
                event.preventDefault();
                var parent = $(this).closest('.select');
                var itemText = $(this).children().text();
                var listItemId = $(this).attr('id');
                $(parent).find('.selected').attr('id', listItemId);
                $(parent).find('.selected').text(itemText);

                console.log(parent + ", " + itemText + ", " + listItemId);

                if (parent.attr('id') !== "phaseSelect" || parent.attr('id') !== "surveyTypeSelect") {
                    $(parent).parent().find('.toggable-button').removeClass('disabled');
                    $(parent).parent().find('.toggable-info').removeClass('info-addon-disabled');
                }

                saveGeneralData();
            });

            function togglePidocoURLInput() {
                if ($("#pidocoURLInput").hasClass('hidden')) {
                    showPidocoURLInput();
                } else {
                    hidePidocoURLInput();
                }
            }

            function showPidocoURLInput() {
                $("#pidocoURLInput").removeClass("hidden");
                saveGeneralData();
            }

            function hidePidocoURLInput() {
                $("#pidocoURLInput").addClass("hidden");
                saveGeneralData();
            }

            $('#info-addon-add-phases').on('click', function (event) {
                event.preventDefault();
                var brotherID = $(this).prevAll(".select:first").attr('id');
                var selectedID = $('#' + brotherID + ' .selected').attr('id');

                if (selectedID !== "unselected") {
                    loadHTMLintoModal("custom-modal", "info-" + selectedID + ".html", "modal-md");
                }
            });

            $('#addPhaseStep').on('click', function (event) {
                event.preventDefault();

                var brotherID = $(this).parent().prevAll(".select:first").attr('id');
                var selectedID = $('#' + brotherID + ' .selected').attr('id');
                var childText = $('#' + brotherID + ' #' + selectedID).children().text();

                if (selectedID !== 'unselected') {
                    addPhaseStep('singlePhaseStep' + currentPhaseStepCount++, selectedID, childText, null);
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
                    deleteSessionDataById(event.data.id + ".data");
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

            function savePhases() {
                var phases = new Array();
                var itemList = document.getElementById('phaseStepList').childNodes;

                for (var i = 0; i < itemList.length; i++) {
                    var item = itemList[i];
                    var id = $(item).attr('id');
                    var selectedId = $(item).find('.btn-modify').attr('id');
                    var itemText = $(item).find('.btn-text-button').text().trim();
                    var color = $(item).find('.glyphicon-tag').css('color');
                    phases.push(new PhaseItem(id, selectedId, itemText, color));
                }

                sessionStorage.setItem('project.phaseSteps', JSON.stringify(phases));
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
                console.log('on delete click');
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
                    toggleSwitch($(this).parent().children('.active'), $(this).parent().children('.inactive'));
                }
            });

            $('body').on('click', '.switchButtonAddon', function (event) {
                event.preventDefault();
                var activeButton = $(this).nextAll().filter('.active');
                var inactiveButton = $(this).nextAll().filter('.inactive');
                toggleSwitch(activeButton, inactiveButton);
            });

            function toggleSwitch(activeButton, inactiveButton) {
                $(activeButton).removeClass('active');
                $(activeButton).addClass('inactive');
                $(activeButton).addClass('btn-default');
                $(activeButton).removeClass('btn-' + $(activeButton).attr('id'));
                $(inactiveButton).removeClass('inactive');
                $(inactiveButton).addClass('active');
                $(inactiveButton).removeClass('btn-default');
                $(inactiveButton).addClass('btn-' + $(inactiveButton).attr('id'));
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

            $('#projectName, #projectDescription, #pidocoURL').focusout(function () {
                saveGeneralData();
            });

            $('#btn-pidoco-info').on('click', function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'info-pidoco.html');
            });

            $('#btn-use-gestures-info').on('click', function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'info-use-gestures.html');
            });

            function toggleGestureCatalog() {
                if ($("#assemble-gesture-set").hasClass('hidden')) {
                    showAssembleGestures();
                } else {
                    hideAssembleGestures();
                }
            }

            function showAssembleGestures() {
                $("#assemble-gesture-set").removeClass('hidden');
                saveGeneralData();
            }

            function hideAssembleGestures() {
                $("#assemble-gesture-set").addClass('hidden');
                removeAssembledGestures();
                saveGeneralData();
            }

            function onAssembleGestureSetClick() {
                currentIdForModal = 'assembledGestureSet';
                loadHTMLintoModal('custom-modal', 'create-gesture-catalog.html', 'modal-lg');
            }

        </script>
        <script src="js/w3-include-HTML.js"></script>
    </body>
</html>