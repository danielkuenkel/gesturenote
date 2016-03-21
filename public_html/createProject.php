<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
if (login_check($mysqli) == true) {
    // Add your protected page content here!
} else {
//    print_r("logged out");
    $_SESSION['user_id'] = 4;
}
//print_r($_SESSION);
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
        <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.4.4/randomColor.js"></script>
        <script src="js/gotoPage.js"></script>
        <script src="js/subPages.js"></script>
        <script src="js/createProject.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

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
                            <div class="checkbox">
                                <label><input type="checkbox" onclick="togglePidocoURLInput()" id="pidocoURLCheckbox">Koppeln an Pidoco Prototypen</label>
                            </div>

                            <div class="form-group collapse" id="pidocoURLInput">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="pidocoURL" placeholder="Pidoco URL eingeben">
                                    <label class="sr-only" for="pidocoURL">Pidoco URL</label>
                                    <span class="input-group-addon" onclick="loadHTMLintoModal('custom-modal', 'info-pidoco.html')">
                                        <i class="glyphicon glyphicon-question-sign"></i>
                                    </span>
                                </div>
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

                        <hr>

                        <!-- submit button -->
                        <button type="submit" class="btn btn-success btn-lg btn-block"><span class="glyphicon glyphicon-save"></span> Projekt erstellen</button>
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
                    <button type="button" class="btn btn-danger" onclick="clearSessionStorage()">Reset Session Storage</button>
                </div>
            </div>
        </div>


        <script>
            $(document).ready(function () {
                createRandomColors();

                if (typeof (Storage) !== "undefined") {
                    checkSessionStorage();
                } else {
                    alert("Sorry, your browser do not support Web Session Storage.");
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
                var parentID = parent.attr('id');

//                console.log(parentID + ", " + itemText + ", "+ listItemId);

                if (parentID !== "phaseSelect" || parentID !== "surveyTypeSelect") {
                    $('#' + parentID).parent().find('.toggable-button').removeClass('disabled');
                    $('#' + parentID).parent().find('.toggable-info').removeClass('info-addon-disabled');
                }

                saveGeneralData();
            });

            function togglePidocoURLInput() {
                if ($("#pidocoURLInput").hasClass('in')) {
                    $("#pidocoURLInput").removeClass("in");
                } else {
                    $("#pidocoURLInput").addClass("in");
                }

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
                var formGroup = document.createElement('div');
                formGroup.setAttribute('class', 'form-group root');
                formGroup.setAttribute('id', id);
                $('#phaseStepList').append(formGroup);

                var buttonGroup = document.createElement('div');
                buttonGroup.setAttribute('class', 'btn-group');
                formGroup.appendChild(buttonGroup);


                var button = document.createElement('button');
                button.setAttribute('class', 'btn btn-default btn-up');
                buttonGroup.appendChild(button);

                var icon = document.createElement('span');
                icon.setAttribute('class', 'glyphicon glyphicon-arrow-up');
                button.appendChild(icon);


                button = document.createElement('button');
                button.setAttribute('class', 'btn btn-default btn-down');
                buttonGroup.appendChild(button);

                icon = document.createElement('span');
                icon.setAttribute('class', 'glyphicon glyphicon-arrow-down');
                button.appendChild(icon);


                button = document.createElement('button');
                button.setAttribute('class', 'btn btn-default btn-delete');
                buttonGroup.appendChild(button);

                icon = document.createElement('span');
                icon.setAttribute('class', 'glyphicon glyphicon-trash');
                button.appendChild(icon);


                button = document.createElement('button');
                button.setAttribute('class', 'btn btn-default btn-modify');
                button.setAttribute('id', selectedID);
                button.onclick = function (event) {
                    event.preventDefault();
                    currentIdForModal = id;
                    loadHTMLintoModal("custom-modal", "create-" + selectedID + ".html", "modal-lg");
                };
                buttonGroup.appendChild(button);

                icon = document.createElement('span');
                icon.setAttribute('class', 'glyphicon glyphicon-cog');
                button.appendChild(icon);

                button = document.createElement('button');
                button.setAttribute('class', 'btn btn-default btn-text-button');
                buttonGroup.appendChild(button);

                button.onclick = function (event) {
                    event.preventDefault();
                    currentIdForModal = id;
                    loadHTMLintoModal("custom-modal", "create-" + selectedID + ".html", "modal-lg");
                };

                if (color === null)
                {
                    color = colors.pop();
                }

                icon = document.createElement('span');
                icon.setAttribute('class', 'glyphicon glyphicon-tag');
                icon.setAttribute('style', 'color: ' + color);
                button.appendChild(icon);
                button.appendChild(document.createTextNode(" " + childText));

                checkCurrentListState($('#phaseStepList'));

                button = document.createElement('button');
                button.setAttribute('class', 'btn btn-default');
                buttonGroup.appendChild(button);
                icon = document.createElement('span');
                icon.setAttribute('class', 'glyphicon glyphicon-question-sign');
                button.appendChild(icon);

                button.onclick = function (event) {
                    event.preventDefault();
                    loadHTMLintoModal("custom-modal", "info-" + selectedID + ".html", "modal-md");
                };
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
                event.stopPropagation();
                event.preventDefault();
                var element = $(this).closest('.root');
                var parent = $(element).parent();
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

            $('body').on('click', '.btn-toggle-checkbox', function () {
                if (!$(this).hasClass('.active')) {
                    if ($(this).attr('id') === 'yes') {
                        $(this).parent().find('#no').removeClass('btn-warning');
                        $(this).parent().find('#no').removeClass('active');
                        $(this).parent().find('#no').addClass('btn-default');
                        $(this).removeClass('btn-default');
                        $(this).addClass('btn-success');
                        $(this).addClass('active');
                    } else {
                        $(this).parent().find('#yes').removeClass('btn-success');
                        $(this).parent().find('#yes').removeClass('active');
                        $(this).parent().find('#yes').addClass('btn-default');
                        $(this).removeClass('btn-default');
                        $(this).addClass('btn-warning');
                        $(this).addClass('active');
                    }
                }
            });

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
        </script>

    </body>
</html>