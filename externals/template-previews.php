<div id="item-container-moderator" class="hidden">

    <!-- alerts -->
    <div class="row root" id="no-phase-data">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <div class="alert-space alert-no-phase-data"></div>
        </div>
    </div>


    <!-- questionnaire container -->
    <div class="row root" id="questionnaire">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Fragen & Aufforderungen
                </div>
                <div class="panel-body question-container"></div>
            </div>
        </div>
    </div>


    <!-- single question format items -->
    <span class="label label-default" id="option-item" style="margin-right: 3px; display: inline-block"></span>

    <div id="rating-item">
        <span id="rating-header"></span> <span class="label label-danger hidden" id="reversed">negiert</span>
        <div id="scales-container" style="margin-top: -6px;"></div>
    </div>


    <!-- single question formats -->
    <div class="panel panel-default root" id="counter" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question"></div>
            <span class="label label-default" id="counter-label"><span class="counter-from"></span> <span class="counter-to"></span></span>
        </div>
    </div>

    <div class="panel panel-default root" id="openQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question"></div>
            <span class="label label-default hidden" id="dimension"></span>
        </div>
    </div>

    <div class="panel panel-default root" id="openQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div class="question"></div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" style="margin-left: -3px; margin-right: -3px">
                <div class="label label-info" id="factor-primary"></div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="dichotomousQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question"></div>
            <span class="label label-default hidden" id="select-gestures">Auswahl einer oder mehrerer Gesten</span>
            <span class="label label-default hidden" id="justification">Mit Begründung</span>
            <span class="label label-default hidden" id="no-justification">Ohne Begründung</span>
            <span class="label label-default hidden" id="yes">Begründung bei Auswahl <em>Ja</em></span>
            <span class="label label-default hidden" id="no">Begründung bei Auswahl <em>Nein</em></span>
            <span class="label label-default hidden" id="always">Begründung <em>Immer</em></span>
            <span class="label label-default hidden" id="dimension"></span>
        </div>
    </div>

    <div class="panel panel-default root" id="dichotomousQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question"></div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" style="margin-left: -3px; margin-right: -3px">
                <div class="label label-info" id="factor-primary"></div>
            </div>
            <span class="label label-default hidden" id="select-gestures">Auswahl einer oder mehrerer Gesten</span>
            <span class="label label-default hidden" id="justification">Mit Begründung</span>
            <span class="label label-default hidden" id="no-justification">Ohne Begründung</span>
            <span class="label label-default hidden" id="yes">Begründung bei Auswahl <em>Ja</em></span>
            <span class="label label-default hidden" id="no">Begründung bei Auswahl <em>Nein</em></span>
            <span class="label label-default hidden" id="always">Begründung <em>Immer</em></span>
            <span class="label label-default hidden" id="dimension"></span>
        </div>
    </div>

    <div class="panel panel-default root" id="alternativeQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question"></div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" style="margin-left: -3px; margin-right: -3px">
                <div class="label label-info" id="factor-primary"></div>
            </div>
            <span class="label label-default hidden" id="optionalanswer">Eigene Antwort erlaubt</span>
            <span class="label label-default hidden" id="justification">Mit Begründung</span>
            <span class="label label-default hidden" id="no-justification">Ohne Begründung</span>
            <span class="label label-default hidden" id="selectOne">Begründung bei mindestens einer Auswahl</span>
            <span class="label label-default hidden" id="selectNothing">Begründung bei keiner Auswahl</span>
            <span class="label label-default hidden" id="always">Begründung <em>Immer</em></span>
            <span class="label label-default hidden" id="gesturesForGesture">Es werden alternative Gesten für die Geste gesucht</span>
            <span class="label label-default hidden" id="triggersForGesture">Es werden alternative Funktionen für die Geste gesucht</span>
            <span class="label label-default hidden" id="triggersForTrigger">Es werden alternative Funktionen für die Funktion gesucht</span>
            <span class="label label-default hidden" id="gesturesForTrigger">Es werden alternative Gesten für die Funktion gesucht</span>
        </div>
    </div>

    <div class="panel panel-default root" id="groupingQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question"></div>
            <span class="label label-default hidden" id="multiselect">Auswahl mehrerer Antworten erlaubt</span>
            <span class="label label-default hidden" id="singleselect">Auswahl einer Antwort erlaubt</span>
            <span class="label label-default hidden" id="optionalanswer">Eigene Antwort erlaubt</span>
            <span class="label label-default hidden" id="dimension"></span>
            <div>Eingruppierungs-Optionen</div>
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default root" id="groupingQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question"></div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" style="margin-left: -3px; margin-right: -3px">
                <div class="label label-info" id="factor-primary"></div>
            </div>
            <span class="label label-default hidden" id="multiselect">Auswahl mehrerer Antworten erlaubt</span>
            <span class="label label-default hidden" id="singleselect">Auswahl einer Antwort erlaubt</span>
            <span class="label label-default hidden" id="justification">Mit Begründung</span>
            <span class="label label-default hidden" id="no-justification">Ohne Begründung</span>
            <span class="label label-default hidden" id="selectOne">Begründung bei mindestens einer Auswahl</span>
            <span class="label label-default hidden" id="selectNothing">Begründung bei keiner Auswahl</span>
            <span class="label label-default hidden" id="always">Begründung <em>Immer</em></span>
            <div>Eingruppierungs-Optionen</div>
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default root" id="rating" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question"></div>
            <span class="label label-default hidden" id="dimension"></span>
            <div>Rating-Optionen</div>
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default root" id="sumQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div class="question"></div>
            <span class="label label-default hidden" id="dimension"></span>
            <div id="distribution-container"></div>
            <div>Antworten der Summenfrage</div>
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default root" id="ranking" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question"></div>
            <span class="label label-default hidden" id="dimension"></span>
            <div>Ranking-Optionen</div>
            <div class="option-container"></div>
        </div>
    </div>


    <!-- SUS container & item -->
    <div class="row root" id="sus">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <div class="panel panel-default">
                <div class="panel-heading">
                    System Usability Scale Items
                </div>
                <div class="panel-body question-container"></div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="susItem" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question"></div> 
            <span class="label label-danger hidden" id="reversed">negiert</span>
        </div>
    </div>


    <!-- GUS container & item -->
    <div class="row root" id="gus">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Gesture Usability Scale Items
                </div>
                <div class="panel-body row">
                    <div class="col-sm-6">
                        <div id="gesture"><span class="address"></span> <span class="text"></span></div>
                        <div id="trigger"><span class="address"></span> <span class="text"></span></div>
                        <div id="feedback"><span class="address"></span> <span class="text"></span></div>
                    </div>

                    <div class="col-sm-6">
                        <div class="previewGesture autoplay mousePlayable btn-shadow"></div>
                        <div class="text-center gestureControls">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                                <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 question-container" style="margin-top: 20px"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="gusSingle" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question"></div>
            <div style="display: inline;">
                <div class="hidden" id="item-factors" style="display: inline-block">
                    <div class="label label-primary" id="factor-main"></div>
                    <img src="img/factor-transition.jpg" style="margin-left: -3px; margin-right: -3px">
                    <div class="label label-info" id="factor-primary"></div>
                </div>
                <div class="label label-danger hidden" id="reversed" style="display: inline-block">negiert</div>
            </div>
        </div>
    </div>

    <!-- gesture questionnaire container -->
    <div class="row root" id="questionnaireGestures">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Fragen & Aufforderungen
                </div>
                <div class="panel-body question-container"></div>
            </div>
        </div>
    </div>


    <div class="row root" id="letterOfAcceptance">
        <div class="col-md-6 col-lg-4" id="column-left"></div>
        <div class="col-md-6 col-lg-8" id="column-right">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Einverständniserklärung
                </div>
                <div class="panel-body letter-text"></div>
            </div>
        </div>
    </div>


    <!-- gesture training container -->
    <div class="row root" id="gestureTraining">
        <div class="col-md-6 rtc-scalable" id="column-left">
            <div class="panel panel-default" id="training">
                <div class="panel-heading">
                    <span class="panel-heading-text"></span>
                </div>
                <div class="panel-body">
                    <div id="trainingContainer"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6" id="column-right">
            <div class="panel panel-default" id="general">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <div id="description"></div>
                    <button type="button" class="btn btn-lg btn-success btn-block btn-shadow" id="btn-start-training" style="margin-top: 6px;">Jetzt starten</button>
                </div>
            </div>
            <div class="panel panel-default" id="observations">
                <div class="panel-heading">
                    Beobachtungen
                </div>
                <div class="panel-body question-container"></div>
            </div>
        </div>
    </div>

    <div id="trainingItem" class="row">
        <div class="col-sm-6 col-md-12 col-lg-6 left" style="margin-bottom: 10px;">
            <!--<div class="previewGesture"></div>-->
            <div>
                <div id="title"><span class="address"></span> <span class="text"></span></div>
                <div id="repeats"><span class="address"></span> <span class="text"></span></div>
                <div id="trigger"><span class="address"></span> <span class="text"></span></div>
                <div id="feedback"><span class="address"></span> <span class="text"></span></div>
            </div>

            <button type="button" class="btn btn-default btn-shadow btn-block btn-popover-gesture-preview" style="margin-top: 10px"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text">Geste zeigen</span></button>
        </div>
        <div class="col-sm-6 col-md-12 col-lg-6 right">
            <div class="btn-group-vertical btn-block">

                <button type="button" class="btn btn-info btn-shadow disabled" id="trigger-training"><span class="btn-text">Trainieren</span></button>
                <button type="button" class="btn btn-info btn-shadow disabled" id="trigger-feedback"><span class="btn-text">Feedback geben</span></button>
            </div>

            <button type="button" class="btn btn-success btn-shadow btn-block disabled" id="next-gesture"><span class="btn-text">Nächste Geste</span> <span aria-hidden="true">&rarr;</span></button>
            <button type="button" class="btn btn-success btn-shadow btn-block disabled hidden" id="training-done"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text">Fertig</span></button>
        </div>
    </div>


    <!-- slideshow container -->

    <div class="row root" id="gestureSlideshow">
        <div class="col-md-6 rtc-scalable" id="column-left">
            <div class="panel panel-default" id="slides">
                <div class="panel-heading">
                    <span class="panel-heading-text"></span>
                </div>
                <div class="panel-body">
                    <div class="row" id="slidesContainer"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6" id="column-right">
            <div class="panel panel-default" id="general">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <p id="description"></p>
                    <button type="button" class="btn btn-lg btn-success btn-block btn-shadow" id="btn-start-slideshow" style="margin-top: 6px;">Jetzt starten</button>
                </div>
            </div>

            <div class="panel panel-default" id="observations">
                <div class="panel-heading">
                    Beobachtungen
                </div>
                <div class="panel-body question-container"></div>
            </div>
        </div>
    </div>

    <div id="gestureSlideshowItem" class="row" style="padding-left: 15px; padding-right: 15px;">
        <div class="col-xs-6 left" style="margin-bottom: 10px;">
            <div class="triggerContainer">
                <div>Erfragt wird Geste: <span id="searched" style="color: #303030"></span></div>
                <div>Gezeigt wird Funktion: <span id="given" style="color: #303030"></span></div>
                <div>Antwortzeit: <span id="responseTime" style="color: #303030"></span></div>
            </div>
            <div class="btn-group-vertical btn-block" style="margin-top: 10px">
                <button type="button" class="btn btn-default btn-shadow btn-popover-gesture-preview"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text">Geste zeigen</span></button>

            </div>
        </div>
        <div class="col-xs-6 right">
            <div class="btn-group-vertical btn-block">
                <button type="button" class="btn btn-info btn-shadow" id="trigger-slide"><span class="btn-text">Auffordern</span></button>
                <button type="button" class="btn btn-danger btn-shadow disabled" id="wrong-slide"><span class="btn-text">Falsch</span></button>
                <button type="button" class="btn btn-success btn-shadow disabled" id="correct-slide"><span class="btn-text">Richtig</span></button>
                <button type="button" class="btn btn-warning btn-shadow disabled" id="next-slide"><span class="btn-text">Überspringen</span></button>
            </div>
        </div>
    </div>


    <!-- slideshow container -->

    <div class="row root" id="triggerSlideshow">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <div class="panel panel-default" id="general">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <p id="description"></p>
                    <button type="button" class="btn btn-lg btn-success btn-block btn-shadow" id="btn-start-slideshow" style="margin-top: 6px;">Jetzt starten</button>
                </div>
            </div>

            <div class="panel panel-default" id="observations">
                <div class="panel-heading">Elemente</div>
                <div class="panel-body question-container"></div>
            </div>

            <button type="button" class="btn btn-lg btn-success btn-block btn-shadow hidden" id="btn-done-slideshow" style="margin-top: 6px;"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text">Fertig</span></button>
        </div>
    </div>

    <div id="triggerSlideshowItem" class="panel panel-default" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>Erfragt wird Funktion: <span id="searched" style="color: #303030"></span></div>
            <div>Gezeigt wird Geste: <span id="given" style="color: #303030"></span></div>
        </div>
    </div>


    <!-- identification container -->
    <div class="row root" id="identification">
        <div class="col-md-6 rtc-scalable" id="column-left">
            <div class="panel panel-default" id="slides">
                <div class="panel-heading">
                    <span class="panel-heading-text"></span>
                </div>
                <div class="panel-body">
                    <div class="row" id="identificationContainer"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6" id="column-right">
            <div class="panel panel-default" id="general">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <p id="description"></p>
                    <span class="label label-default hidden" id="search-gestures">Es werden Gesten ermittelt</span> 
                    <span class="label label-default hidden" id="search-trigger">Es werden Funktionen ermittelt</span>
                    <button type="button" class="btn btn-lg btn-success btn-block btn-shadow" id="btn-start-identification" style="margin-top: 6px;">Jetzt starten</button>
                </div>
            </div>

            <div class="panel panel-default" id="observations">
                <div class="panel-heading">
                    Beobachtungen
                </div>
                <div class="panel-body question-container"></div>
            </div>
        </div>
    </div>

    <div id="identificationItem" class="row" style="padding-left: 15px; padding-right: 15px;">
        <div class="col-xs-6 left" style="margin-bottom: 10px;">
            <div class="triggerContainer">
                <div id="search"><span class="address">Ermittelt wird:</span> <span class="text"></span></div>
                <div id="search-for"><span class="address">Für:</span> <span class="text"></span></div>
                <!--<div id="gesture-repeats" class="hidden"><span class="address">Geste wiederholen:</span> <span class="text"></span></div>-->
            </div>
        </div>
        <div class="col-xs-6 right">
            <div class="btn-group-vertical btn-block">
                <button type="button" class="btn btn-default btn-shadow btn-popover-gesture-preview"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text">Geste zeigen</span></button>
                <button type="button" class="btn btn-info btn-shadow" id="trigger-identification"><span class="btn-text">Auffordern</span></button>
                <button type="button" class="btn btn-success btn-shadow disabled" id="next-identification"><span class="btn-text"><span class="btn-text">Weiter</span> <span aria-hidden="true">&rarr;</span></button>
                <button type="button" class="btn btn-success btn-shadow disabled" id="done-identification"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text">Fertig</span></button>
            </div>
        </div>
    </div>


    <!-- physical stress test container -->

    <div class="row root" id="physicalStressTest">
        <div class="col-md-6 rtc-scalable" id="column-left">
            <div class="panel panel-default" id="controls">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="repeats-left"><span class="address">Wiederholungen übrig:</span> <span class="text"></span></div>
                            <div id="stress-for"><span class="address">Gezeigt wird Geste:</span> <span class="text"></span></div>
                            <button type="button" class="btn btn-default btn-block btn-shadow btn-popover-gesture-preview"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text">Geste zeigen</span></button>
                        </div>

                        <div class="col-md-6">
                            <div class="btn-group-vertical btn-block">
                                <button type="button" class="btn btn-info btn-shadow disabled" id="btn-show-gesture">Auffordern</button>
                                <button type="button" class="btn btn-info btn-shadow disabled" id="btn-show-question">Fragen zeigen</button>
                                <button type="button" class="btn btn-success btn-shadow disabled" id="btn-next-gesture"><span class="btn-text">Nächste Geste</span> <span aria-hidden="true">&rarr;</span></button>
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
        <div class="col-md-6" id="column-right">
            <div class="panel panel-default" id="general">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <p id="description"></p>
                    <button type="button" class="btn btn-lg btn-success btn-block btn-shadow" id="btn-start-stress-test" style="margin-top: 6px;">Jetzt starten</button>
                </div>
            </div>

            <div class="panel panel-default" id="singleStressQuestions">
                <div class="panel-heading">Fragen nach jeder Geste</div>
                <div class="panel-body question-container"></div>
            </div>

            <div class="panel panel-default" id="sequenceStressQuestions">
                <div class="panel-heading">Fragen nach einer Gesten-Squenz</div>
                <div class="panel-body question-container"></div>
            </div>

            <div class="panel panel-default" id="observations">
                <div class="panel-heading">Beobachtungen</div>
                <div class="panel-body question-container"></div>
            </div>
        </div>
    </div>


    <!-- scenario container -->

    <div  class="row root" id="scenario">
        <div class="col-md-7 col-lg-8 rtc-scalable" id="column-left">
            <div class="panel panel-default" id="woz-controls">
                <div class="panel-heading">Wizard-of-Oz-Experiment</div>
                <div class="panel-body">
                    Aktuelle Szene: <span class="label label-default">
                        <i class="fa fa-link hidden" id="icon-pidoco"></i>
                        <i class="fa fa-link hidden" id="icon-web"></i>
                        <i class="fa fa-image hidden" id="icon-image"></i>
                        <i class="fa fa-film hidden" id="icon-videoEmbed"></i> <span class="label-text"></span></span> <span id="current-scene" class="text"></span>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6" id="wozExperiment" style="margin-bottom: 20px;">
                            <h4 style="margin-top: 0px; margin-bottom: 10px">Simulationselemente</h4>
                            <div class="alert-space alert-no-phase-data"></div>
                            <div class="row woz-container"></div>
                        </div>

                        <div class="col-lg-6" id="help">
                            <h4 style="margin-top: 0px; margin-bottom: 10px">Hilfe</h4>
                            <div class="alert-space alert-no-phase-data"></div>
                            <div class="help-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5 col-lg-4" id="column-right">
            <div class="panel panel-default" id="general">
                <div class="panel-heading">Allgemeines</div>
                <div class="panel-body">
                    <div id="task"><span class="address"></span>: <span class="text"></span></div>
                    <div id="description"><span class="address"></span>: <span class="text"></span></div>
                    <button type="button" class="btn btn-default btn-shadow btn-block hidden" id="btn-preview-scene" style="margin-top: 6px;"><i class="glyphicon glyphicon-eye-open"></i> Hinterlegte Start-Szene anzeigen</button>
                    <button type="button" class="btn btn-lg btn-success btn-block btn-shadow" id="btn-start-scenario" style="margin-top: 6px;">Jetzt starten</button>
                </div>
            </div>
            <div class="panel panel-default" id="observations">
                <div class="panel-heading">
                    Beobachtungen
                </div>
                <div class="panel-body question-container"></div>
            </div>
        </div>
    </div>

    <div class="col-xs-6 col-sm-4 col-md-6" id="wozItem" style="margin-bottom: 10px;">

        <!--<div id="task"></div>-->
        <!--<div id="description"></div>-->
        <!--        <div id="gesture-title" style=""></div>
                <div id="trigger-title" style=""></div>-->
        <div class="btn-group-vertical btn-block">
            <button type="button" class="btn btn-default btn-shadow btn-popover-gesture-preview"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text">Geste zeigen</span></button>
            <button type="button" class="btn btn-default btn-shadow" id="btn-show-transition-scene"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text">Folge-Zustand zeigen</span></button>
            <button type="button" class="btn btn-info btn-shadow ellipsis disabled" id="trigger-woz">Simulieren</button>
        </div>
    </div> 

    <div id="helpItem" style="margin-bottom: 6px;">
        <div class="help-title"></div>
        <div class="btn-group" style="margin-top: 10px;">
            <button type="button" class="btn btn-info btn-shadow disabled" id="offer-help"><i class="fa fa-life-ring"></i> Hilfe anbieten</button>
            <button type="button" class="btn btn-default btn-shadow btn-popover-gesture-preview hidden"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text">Geste zeigen</span></button>
        </div>
    </div>

    <div id="web">
        <span>Titel: </span><span class="title"></span><br/>
        <span>Typ: </span><div class="label label-default type"><i class="fa fa-link"></i> <span class="label-text"></span></div><br/><br/>
        <iframe class="web-frame" src="" frameborder="0" scrolling="no" style="width: 100%; height: 400px; pointer-events: none;"></iframe>
        <button type="button" class="btn btn-default btn-shadow btn-block btn-url" aria-label="Link in neuem Fenster öffnen"><i class="glyphicon glyphicon-link"></i> Link in neuem Fenster öffnen</button>
    </div>

    <div id="pidoco">
        <span>Titel: </span><span class="title"></span><br/>
        <span>Typ: </span><div class="label label-default type"><i class="fa fa-link"></i> <span class="label-text"></span></div><br/><br/>
        <iframe class="web-frame" src="" frameborder="0" scrolling="no" style="width: 100%; height: 400px; pointer-events: none;"></iframe>
        <button type="button" class="btn btn-default btn-shadow btn-block btn-url" aria-label="Link in neuem Fenster öffnen"><i class="glyphicon glyphicon-link"></i> Link in neuem Fenster öffnen</button>
    </div>

    <div id="image">
        <span>Titel: </span><span class="title"></span><br/>
        <span>Typ: </span><div class="label label-default type"><i class="fa fa-image"></i> <span class="label-text"></span></div><br/><br/>
        <img class="imageAreaContent" src="" alt="..." style="width: 100%; height: auto; border-radius: 4px;" />
    </div>

    <div id="videoEmbed">
        <span>Titel: </span><span class="title"></span><br/>
        <span>Typ: </span><div class="label label-default type"><i class="fa fa-film"></i> <span class="label-text"></span></div><br/><br/>

        <!-- embed-responsive-16by9 or embed-responsive-4by3 -->
        <div class="videoContainer embed-responsive"></div>
    </div>

</div>






















<div id="item-container-tester" class="hidden">

    <!-- alerts -->
    <div class="container root" id="no-phase-data">
        <div class="alert-space alert-no-phase-data"></div>
    </div>


    <!-- rtc preview -->
    <div id="tester-web-rtc-placeholder" class="web-rtc-placeholder" style="width: 100%">
        <img src="img/web-rtc-placeholder.jpg" style="width: 100%; height: auto" />
    </div>

    <!-- rtc live stream -->
    <div id="web-rtc-live-stream" style="width: 100%">
        <video autoplay class="rtc-stream" style="width: 100%; height: auto; overflow: hidden; border-radius: 4px;"></video>
    </div>

    <!-- main formats -->

    <div class="container root" id="letterOfAcceptance">
        <h3 class="headline" style="margin: 0" >Einverständniserklärung</h3>
        <hr>
        <div class="letter-text"></div>
        <hr>
        <div>
            <button type="button" class="btn btn-success btn-shadow" id="letter-agreed">Ich bin einverstanden</button>
            <button type="button" class="btn btn-danger btn-shadow pull-right" id="letter-decline">Ich bin nicht einverstanden</button>
        </div>
    </div>

    <div class="container root" id="questionnaire">
        <h3 class="headline" style="margin: 0" >Fragebogen</h3>
        <hr>
        <div class="question-container"></div>
        <hr>
        <button class="next btn btn-success pull-right" id="btn-next-phase-step"><span class="btn-text">Weiter</span> <span aria-hidden="true">&rarr;</span></button>
    </div>


    <!-- SUS container & item -->
    <div class="container root" id="sus">
        <h3 class="headline" style="margin: 0">Fragebogen zum System</h3>
        <hr>
        <div class="question-container"></div>
        <hr>
        <button class="next btn btn-success pull-right" id="btn-next-phase-step"><span class="btn-text">Weiter</span> <span aria-hidden="true">&rarr;</span></button>
    </div>

    <div class="panel panel-default root" id="susItem" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <span class="question"></span> 
                <div class="option-container root"></div>
            </div>
        </div>
    </div>

    <!-- GUS container & item -->
    <div class="container root" id="gus">
        <h3 class="headline" style="margin: 0" >Fragebogen zur Geste</h3>
        <div class="row">
            <div class="col-sm-6 right" style="margin-bottom: 10px;">
                <div id="gesture"><span class="address"></span> <span class="text"></span></div>
                <div id="trigger"><span class="address"></span> <span class="text"></span></div>
                <div id="feedback"><span class="address"></span> <span class="text"></span></div>
            </div>
            <div class="col-sm-6 left" id="gesturePreview">
                <div class="previewGesture autoplay mousePlayable btn-shadow"></div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="question-container"></div>
        <hr>
        <button class="next btn btn-success pull-right" id="btn-next-phase-step"><span class="btn-text">Weiter</span> <span aria-hidden="true">&rarr;</span></button>
    </div>


    <!-- gesture questionnaire container & item -->
    <div class="container root" id="questionnaireGestures">
        <h3 class="headline" style="margin: 0" >Fragebogen zu den Gesten</h3>
        <hr>
        <div class="question-container"></div>
        <hr>
        <button class="next btn btn-success pull-right" id="btn-next-phase-step"><span class="btn-text">Weiter</span> <span aria-hidden="true">&rarr;</span></button>
    </div>

    <!-- gesture training container -->
    <div class="root" id="gestureTraining">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <!--<div class="row">-->
        <!--<div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>-->
        <div class="col-md-8" id="column-right">
            <div id="general">
                <h3 class="headline" style="margin: 0"></h3>
                <div class="description"></div>
                <hr>
            </div>
            <div class="alert-space alert-waiting-for-training-gesture"></div>
            <div class="row" id="trainingContainer"></div>
        </div>
        <!--</div>-->
    </div>

    <div id="trainingItemModerated">
        <div class="col-sm-6" style="margin-bottom: 10px;">
            <!--<div>-->
            <div id="title"><span class="address"></span> <span class="text"></span></div>
            <div id="repeats"><span class="address"></span> <span class="text"></span></div>
            <div id="trigger"><span class="address"></span> <span class="text"></span></div>
            <div id="feedback"><span class="address"></span> <span class="text"></span></div>
            <!--</div>-->
        </div>
        <div class="col-sm-6" style="margin-bottom: 20px;">
            <div class="previewGesture autoplay"></div>
            <div class="text-center gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div id="trainingItemUnmoderated">
        <div class="hidden" id="training-data">
            <div class="col-sm-12 col-lg-6" style="margin-top: 20px">
                <div style="margin-bottom: 10px;">
                    <div id="title"><span class="address"></span> <span class="text"></span></div>
                    <div id="repeats"><span class="address"></span> <span class="text"></span></div>
                    <div id="trigger"><span class="address"></span> <span class="text"></span></div>
                    <div id="feedback"><span class="address"></span> <span class="text"></span></div>
                </div>
            </div>

            <div class="col-sm-12 col-lg-6" style="margin-top: 20px">
                <div class="previewGesture autoplay" style="margin:auto;"></div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12" style="margin-top: 10px">
            <div id="training-controls">
                <button class="btn btn-lg btn-block btn-success btn-shadow" id="start-training" name="btn-success"><span class="btn-text">Jetzt Starten</span></button>
                <button class="btn btn-lg btn-block btn-success btn-shadow hidden" id="start-single-training" name="btn-success"><span class="btn-text">Gesten-Training beginnen</span></button>
                <button class="btn btn-lg btn-block btn-info btn-shadow hidden" id="repeat-training" name="btn-success"><span class="btn-text">Geste nochmal ausführen</span></button>
                <button class="btn btn-lg btn-block btn-success btn-shadow hidden" id="next-gesture" name="btn-success"><span class="btn-text">Nächste Geste</span> <span aria-hidden="true">&rarr;</span></button>
                <button class="btn btn-lg btn-block btn-success btn-shadow hidden" id="training-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text">Fertig</span></button>
            </div>
            <div class="progress progress-training hidden" style="border-radius: 10px">
                <div class="progress-bar progress-bar-training progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 100%"></div>
            </div>
        </div>
    </div>


    <!-- gesture slideshow container -->

    <div class="root" id="gestureSlideshow">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right">
            <div id="general">
                <h3 style="margin: 0" class="headline"></h3>
                <div class="description"></div>
                <hr>
            </div>
            <div id="restart" class="hidden">
                <h3 style="margin: 0" class="headline">Bitte noch einmal neu starten</h3>
                <hr>
            </div>
            <div class="alert-space alert-waiting-for-slideshow"></div>
            <div class="progress progress-slideshow hidden" style="border-radius: 10px;">
                <div class="progress-bar progress-bar-slideshow progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 100%"></div>
            </div>
            <div class="row" id="slideshowContainer"></div>
        </div>
    </div>


    <!-- moderated gesture slideshow items -->

    <div id="gestureSlideshowOverviewItemModerated" class="col-xs-6 col-sm-4 col-md-6 col-lg-4 root">
        <div class="previewGesture mousePlayable btn-shadow"></div>
        <div class="text-center gestureControls">
            <div class="btn-group">
                <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
            </div>
        </div>
    </div>

    <div id="gestureSlideshowItemModerated" class="text-center">
        <div class="triggerContainer hidden">
            <div class="trigger-title" style="font-size: 30pt; color: #303030; font-weight: bold; line-height: 1.3em;"></div>
        </div>
    </div>


    <!-- unmoderated gesture slideshow items -->

    <div id="gestureSlideshowOverviewItemUnmoderated" class="col-xs-6 col-sm-4 col-md-6 col-lg-4 root" style="margin-bottom: 15px;">
        <div class="previewGesture mousePlayable btn-shadow"></div>
        <div class="text-center gestureControls">
            <div class="btn-group">
                <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
            </div>
        </div>
    </div>

    <div id="gestureSlideshowItemUnmoderated" class="text-center col-xs-12">
        <button class="btn btn-lg btn-block btn-success btn-shadow hidden" id="startSlideshow" name="btn-success">Jetzt Starten</button>

        <div class="triggerContainer hidden">
            <div class="trigger-title" style="font-size: 30pt; color: #303030; font-weight: bold; line-height: 1.3em;"></div>
        </div>
    </div>


    <!-- trigger slideshow container -->

    <div class="container root" id="triggerSlideshow">
        <div id="general">
            <h3 style="margin: 0"  class="headline"></h3>
            <div class="description"></div>
            <hr>
        </div>
        <div class="alert-space alert-waiting-for-slideshow"></div>
        <div class="progress progress-slideshow hidden" style="border-radius: 10px;">
            <div class="progress-bar progress-bar-slideshow progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 100%"></div>
        </div>
        <div class="row hidden" id="slideshowContainer"></div>
        <button class="btn btn-lg btn-block btn-success btn-shadow" id="startSlideshow" name="btn-success">Jetzt Starten</button>
    </div>


    <!-- unmoderated gesture slideshow items -->

    <div id="triggerSlideshowItemUnmoderated">
        <div class="col-sm-5 text-center" style="margin-bottom: 15px;" id="gesturePreview">
            <div class="previewGesture autoplay"></div>
            <div class="text-center gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="question-container"></div>
            <button class="btn btn-lg btn-block btn-success btn-shadow hidden" id="btn-next-slide" name="btn-success"><span class="btn-text">Nächste Geste</span> <span aria-hidden="true">&rarr;</span></button>
            <button class="btn btn-lg btn-block btn-success btn-shadow hidden" id="btn-done-slide" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text">Fertig</span></button>
        </div>        
    </div>


    <!-- identification container -->

    <div class="root container" id="identification"></div>

    <div class="row root" id="identificationModerated">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right">
            <div id="general">
                <h3 class="headline"></h3>
                <div class="description"></div>
                <hr>
            </div>
            <div class="alert-space alert-waiting-for-identification"></div>
            <div class="progress progress-identification hidden" style="border-radius: 10px; height: 73px;">
                <div class="progress-bar progress-bar-identification progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 100%"></div>
            </div>
            <div id="identificationContainer"></div>
        </div>
    </div>

    <div id="identificationItemModerated">
        <div id="trigger-identification">
            <div class="col-lg-6 text-center">
                <div class="previewGesture autoplay" style="max-width: 600px; min-width: 200px; margin:auto;"></div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="trigger-name">Funktion</label>
                    <input class="form-control" name="trigger-name" id="trigger-name">
                </div>
                <div class="form-group">
                    <label for="trigger-name">Begründung</label>
                    <textarea class="form-control" rows="5"></textarea>
                </div>
            </div>
        </div>

        <div id="gesture-identification" class="text-center">
            <span id="trigger"><span id="text" style="font-size: 40pt; font-weight: bold; line-height: 1.3em;"></span></span>
        </div>
    </div>

    <div class="row root" id="identificationUnmoderated">
        <div class="col-xs-12" style="margin-bottom: 15px;" id="general">
            <div>
                <h3 class="headline" style="margin: 0"></h3>
                <div class="description" style="color: #303030"></div>
                <hr>
                <button class="btn btn-lg btn-block btn-success btn-shadow" id="btn-start-identification" style="margin-top: 20px">Jetzt Starten</button>
            </div>
        </div>
        <div class="col-xs-12">
            <div id="identificationContainer"></div>
        </div>
    </div>

    <div id="identificationItemUnmoderated">

        <div id="identification-content" class="hidden">
            <div id="trigger-identification">
                <div class="col-sm-5 col-md-6 text-center" style="margin-bottom: 15px">
                    <div class="previewGesture previewProgress autoplay mousePlayable btn-shadow" style="max-width: 500px;"></div>
                    <div class="progress gesture-progress" style="max-width: 500px; margin: auto">
                        <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                    </div>
                    <div class="text-center gestureControls">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                            <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7 col-md-6">
                    <p class="text">Welche Funktion könnte auf diese Geste passen? Bitte tragen Sie Ihren Vorschlag bei Funktion ein und begründen Sie anschließend Ihre Entscheiden.</p>
                    <div class="form-group">
                        <label for="trigger-name">Funktion</label>
                        <input class="form-control" name="trigger-name" id="trigger-name">
                    </div>
                    <div class="form-group">
                        <label for="trigger-name">Begründung</label>
                        <textarea class="form-control" rows="5" id="trigger-justification"></textarea>
                    </div>
                    <button type="button" class="btn btn-success btn-block btn-shadow" id="next-identification"><span class="btn-text"><span class="btn-text">Nächste Geste</span> <span aria-hidden="true">&rarr;</span></button>
                    <button type="button" class="btn btn-success btn-block btn-shadow" id="done-identification"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text">Fertig</span></button>
                </div>
            </div>

            <div id="gesture-identification">
                <div class="col-sm-6">
                    <div id="recorder-description" class="hidden"></div>
                </div>
                <div class="col-sm-6">
                    <div style="width: 100%" class="text-center">
                        <h3 id="trigger" style="margin: 0"><span class="address"></span> <span id="text"></span></h3>
                    </div>
                    <div id="gesture-recorder-container" style="width: 450px; margin: auto; margin-top: 15px;"></div>
                    <div style="margin-top: 20px;" id="next-controls" class="hidden">
                        <button type="button" class="btn btn-lg btn-success btn-block btn-shadow" id="next-identification"><span class="btn-text">Nächste Funktion</span> <span aria-hidden="true">&rarr;</span></button>
                        <button type="button" class="btn btn-lg btn-success btn-block btn-shadow" id="done-identification"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text">Fertig</span></button>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <!-- stress test container -->

    <div class="root" id="physicalStressTest">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right" style="margin-bottom: 25px;">
            <div id="general">
                <h3 class="headline" style="margin: 0"></h3>
                <div class="description"></div>
                <hr>
            </div>
            <div class="alert-space alert-waiting-for-identification"></div>

            <div class="row" id="stressTestContainer"></div>

            <button class="btn btn-lg btn-block btn-success btn-shadow hidden" id="btn-start-stress-test" name="btn-success">Jetzt Starten</button>
        </div>
    </div>

    <div class="root" id="physicalStressTestModerated">
        <div class="col-sm-5 col-lg-6 text-center" style="margin-bottom: 15px;">
            <div class="previewGesture previewProgress autoplay" style="max-width: 400px"></div>
            <div class="progress gesture-progress" style="max-width: 400px; margin: auto">
                <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <div class="text-center gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                </div>
            </div>
        </div>

        <div class="col-sm-7 col-lg-6" id="stress-test-questionnaire">
            <div class="question-container"></div>

            <div class="panel panel-default hidden" id="human-body-selection-rating" style="margin-bottom: 5px;">
                <div class="panel-body">
                    <p class="question">Welche Teile des Körpers wurden besonders beantsprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                    <div class="select-joints-humand-body" id="human-body" style="width: 450px; margin: auto">
                        <div id="joint-container" style="position: absolute"></div>
                        <img src="img/human_body.svg">
                    </div>
                </div>
            </div>

            <div class="panel panel-default hidden" id="hand-selection-rating" style="margin-bottom: 5px;">
                <div class="panel-body">
                    <p class="question">Welche Teile der Hand oder Hände wurden besonders beantsprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                    <div class="select-joints-humand-hand" id="human-hand" style="width: 450px; margin: auto">
                        <div id="joint-container" style="position: absolute"></div>
                        <img src="img/human_hand.svg">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="root" id="physicalStressTestUnmoderated">
        <div class="col-sm-12">
            <div id="general-repeats">
                <h3 class="headline" style="margin: 0">Bitte die Geste ausführen</h3>
                <hr>
            </div>
            <div id="questionnaire-heading" class="hidden">
                <h3 class="headline" style="margin: 0" >Bitte die Fragen beantworten</h3>
                <hr>
            </div>
        </div>

        <div class="col-sm-12 text-center" style="margin-bottom: 15px;" id="gesturePreview">
            <div class="previewGesture previewProgress autoplay" style="max-width: 400px"></div>
            <div class="progress gesture-progress" style="max-width: 400px; margin: auto">
                <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <div class="gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                </div>
            </div>
        </div>

        <div class="col-sm-7 hidden" id="stress-test-questionnaire">
            <div id="single-questions" class="hidden">
                <h4 id="headline-single-questions" style="margin-top: 0">Einzel-Fragen</h4>

                <div id="single-joint-selection" class="hidden">
                    <div class="panel panel-default" id="human-body-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question">Welche Teile des Körpers wurden <u>GERADE EBEN</u> besonders beansprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                            <div class="select-joints-humand-body" id="human-body" style="width: 450px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_body.svg">
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default" id="hand-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question">Welche Teile der Hand oder Hände wurden <u>GERADE EBEN</u> besonders beansprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                            <div class="select-joints-humand-hand" id="human-hand" style="width: 450px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_hand.svg">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="question-container"></div>
            </div>

            <div id="sequence-questions" class="hidden" style="margin-top: 30px">
                <h4 id="headline-sequence-questions">Sequenz-Fragen</h4>

                <div id="sequence-joint-selection" class="hidden">
                    <div class="panel panel-default" id="human-body-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question">Welche Teile des Körpers wurden <u>INSGESAMT</u> besonders beansprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                            <div class="select-joints-humand-body" id="human-body" style="width: 450px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_body.svg">
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default" id="hand-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question">Welche Teile der Hand oder Hände wurden <u>INSGESAMT</u> besonders beansprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                            <div class="select-joints-humand-hand" id="human-hand" style="width: 450px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_hand.svg">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="question-container"></div>
            </div>

        </div>

        <div class="col-xs-12">
            <button class="btn btn-lg btn-block btn-success btn-shadow" id="btn-gesture-done" name="btn-success">Geste wurde ausgeführt</button>
            <button class="btn btn-lg btn-block btn-success btn-shadow hidden" id="btn-questionnaire-done" name="btn-success">Weiter</button>
            <button class="btn btn-lg btn-block btn-success btn-shadow hidden" id="btn-next-gesture" name="btn-success"><span class="btn-text">Nächste Geste</span> <span aria-hidden="true">&rarr;</span></button>
            <button class="btn btn-lg btn-block btn-success btn-shadow hidden" id="btn-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text">Fertig</span></button>
        </div>

    </div>


    <!-- scenario container -->
    <div class="root" id="scenario" style="width: 100%;">

        <div style="position: absolute; width: 100%; height:auto;" id="scenePanel">
            <div id="scene-container" class="text-center" style="position: absolute; width: 100%; height:auto; overflow:auto"></div>
        </div>

        <div id="fixed-rtc-preview" class="hidden" style="position: fixed; width: 300px; top: 10px; left: 10px;"></div>

        <div class="hidden" id="generalPanel" style="width: 100%"></div>
    </div>

    <div id="scenario-panel-moderated">
        <div class="alert-space alert-waiting-for-scenario-start" style="margin-top: 10px"></div>
    </div>

    <div id="scenario-panel-unmoderated" style="width: 100%">
        <div id="info-content" class="hidden" style="width: 100%">
            <div id="task-header"></div>
            <div id="task-text" style="color: #303030; line-height: 1.2em"></div>
            <hr>
        </div>

        <div class="hidden" id="normal-controls">
            <div class="pull-left">
                <button class="btn btn-link" id="btn-show-scenario-info"><i class="glyphicon glyphicon-menu-down text-center"></i> <span id="more-text"></span></button>
                <button class="btn btn-link pull-left hidden" id="btn-hide-scenario-info"><i class="glyphicon glyphicon-menu-up text-center"></i> <span id="less-text"></span></button>
            </div>
            <div class="pull-right">
                <button type="button" class="btn btn-success" id="btn-done"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text">Fertig</span></button>
                <button type="button" class="btn btn-info" id="btn-refresh-scene"><i class="glyphicon glyphicon-refresh"></i> <span class="btn-text">Neu laden</span></button>
                <button type="button" class="btn btn-info" id="btn-getting-help"><i class="fa fa-life-ring"></i> <span class="btn-text">Hilfe</span></button>
            </div>
            <div class="text-center" style="overflow: hidden">
                <button type="button" class="btn btn-success hidden" id="btn-perform-gesture"><span class="btn-text">Geste ausführen</span></button>
                <button type="button" class="btn btn-danger hidden" id="btn-stop-perform-gesture"><span class="btn-text">Geste ausgeführt</span></button>

            </div>
        </div>

        <div class="text-center hidden" id="start-controls">
            <button type="button" class="btn btn-success btn-block btn-lg" id="start-scene"><span class="btn-text">Jetzt starten</span></button>
        </div>
    </div>    

    <iframe id="web" class="web-frame" src="" frameborder="0" style="width: 100%;" scrolling="yes"></iframe>

    <iframe id="pidoco" class="web-frame" src="" frameborder="0" style="width: 100%;" scrolling="yes"></iframe>

    <img id="image" style="width: auto;">

    <!-- embed-responsive-16by9 or embed-responsive-4by3 -->
    <div id="videoEmbed" style="margin: auto">
        <div class="videoContainer embed-responsive"></div>
    </div>


    <!-- hints and hint contents-->
    <div id="feedback-hint" class="hint">
        <div class="hint-content">
            <button type="button" class="btn btn-lg btn-info btn-block" id="btn-close-hint" style="margin-top: 20px"><span class="btn-text">Okay</span></button>
            <div class="progress progress-hint" style="height: 73px; border-radius: 10px; margin-top: 20px">
                <div class="progress-bar progress-bar-info progress-bar-hint" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 100%"></div>
            </div>
        </div>
    </div>

    <div id="feedback-hint-text-content">
        <span id="feedback-title"></span>
    </div>

    <div id="feedback-hint-sound-content">
        <div id="feedback-title"></div>
        <i class="fa fa-volume-up" style="font-size: 80pt"></i>
        <audio class="audio-holder" src="" preload="auto"></audio>
    </div>

    <div class="container root"  id="thanks">
        <h3 class="headline text" style="margin: 0">Danke für die Teilnahme</h3>
        <hr>
        <div class="row">
            <div class="col-sm-6" style="margin-bottom: 20px;">
                <i class="fa fa-heart" style="font-size: 70pt; color: #ca3667"></i>
                <div class="text" id="thanks-text"></div>
            </div>
            <div class="col-sm-6" id="upload-instructions" style="margin-bottom: 20px;">
                <i class="fa fa-upload" aria-hidden="true" style="font-size: 70pt; color: #777"></i>
                <div class="text">
                    Bitte warten! Die Daten werden nun gespeichert. Bitte nicht dieses Fenster oder den Browser schließen. Wenn die Daten gespeichert sind, erscheint eine Meldung.
                </div>
                <div id="rtc-uploads-status" class="hidden text">
                    Bitte warten… Videodaten werden gespeichert.
                </div>
            </div>
            <div class="col-sm-6 hidden" id="upload-retry" style="margin-bottom: 20px;">
                <i class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size: 70pt; color: #d9534f"></i>
                <div class="text">
                    <p>Es gab einen Fehler. Die Daten konnten nicht gespeichert werden. Bitte noch einmal probieren.</p>
                    <button type="button" class="btn btn-danger btn-shadow" id="btn-retry-upload"><i class="fa fa-refresh" aria-hidden="true"></i> <span class="btn-text">Noch einmal probieren</span></button>
                </div>
            </div>
            <div class="col-sm-6 hidden" style="margin-bottom: 20px;" id="upload-done">
                <i class="fa fa-check" aria-hidden="true" style="font-size: 70pt; color: #5cb85c"></i>
                <div class="text">
                    Die Studien-Daten wurden erfolgreich übertragen. Sie können das Fenster nun schließen oder an weiteren Studien teilnehmen.
                </div>
            </div>
        </div>

        <div class="hidden" id="study-share">
            <hr>
            <i class="fa fa-share" aria-hidden="true" style="font-size: 70pt; color: #777"></i>
            <p class="text" id="static-study-url"></p>
            <p class="text">Um die Studie zu teilen einfach den Link kopieren.</p>

            <!--            <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-share" aria-hidden="true"></i> Weitersagen</div>
                            <input type="text" class="form-control readonly" >
                        </div>-->
            <hr>
        </div>


        <button type="button" class="btn btn-success btn-shadow pull-right hidden" id="btn-execution-done"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text">Fertig</span></button>
    </div>

</div>





















<div id="item-container-inputs" class="hidden">

    <div class="panel panel-default root" id="openQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <p class="question"></p> 
            <textarea class="form-control" id="openQuestionInput" rows="5" placeholder=""></textarea>
        </div>
    </div>

    <div class="panel panel-default root" id="openQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <p class="question"></p> 
            <textarea class="form-control" id="openQuestionInput" rows="5" placeholder=""></textarea>
        </div>
    </div>

    <div class="panel panel-default root" id="dichotomousQuestion" style="margin-bottom: 5px;">
        <div class="panel-body" id="panel-body">
            <p class="question"></p>
            <div class="btn-group switch">
                <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="yes" name="btn-success">Ja</button>
                <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="no" name="btn-success">Nein</button>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="dichotomousQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <p class="question"></p>
            <div class="btn-group switch">
                <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="yes" name="btn-success">Ja</button>
                <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="no" name="btn-success">Nein</button>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="groupingQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <p class="question"></p> 
            <div class="option-container root"></div>
        </div>
    </div>

    <div class="panel panel-default root" id="groupingQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <p class="question"></p> 
            <div class="option-container root"></div>
        </div>
    </div>

    <div class="panel panel-default root" id="counter" style="margin-bottom: 5px;">
        <div class="panel-body">
            <p class="question"></p>
            <div class="input-group simple-stepper" style="max-width: 130px;">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default btn-shadow btn-stepper-decrease" value="0">
                        <span class="glyphicon glyphicon-minus"></span><span class="sr-only">weniger</span>
                    </button>
                </div>
                <input type="text" class="form-control readonly text-center stepper-text" value="0">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default btn-shadow btn-stepper-increase" value="10">
                        <span class="glyphicon glyphicon-plus"></span><span class="sr-only">mehr</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="gusSingle" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <span class="question"></span> 
                <div class="option-container root"></div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="rating" style="margin-bottom: 5px;">
        <div class="panel-body">
            <p class="question"></p> 
            <div class="option-container root"></div>
        </div>
    </div>

    <div id="rating-item">
        <div id="rating-header"></div>
        <div class="root scales-container" id="scales-container"></div>
    </div>

    <div class="panel panel-default root" id="sumQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <p class="question"></p> 
            <div class="option-container root"></div>
        </div>
    </div>

    <div id="sumQuestion-item" style="margin-bottom: 5px; display: inline">
        <div class="input-group simple-stepper" style="max-width: 140px; float: left;  clear: left">
            <div class="input-group-btn">
                <button type="button" class="btn btn-default btn-shadow btn-stepper-decrease" value="0">
                    <span class="glyphicon glyphicon-minus"></span><span class="sr-only">weniger</span>
                </button>
            </div>
            <input type="text" class="form-control readonly text-center stepper-text" value="0">
            <div class="input-group-btn">
                <button type="button" class="btn btn-default btn-shadow btn-stepper-increase" value="0">
                    <span class="glyphicon glyphicon-plus"></span><span class="sr-only">mehr</span>
                </button>
            </div>
        </div>
        <span class="option-text text" style="margin-left: 8px; float: left; margin-top: 4px; margin-bottom: 12px"></span>
    </div>

    <div class="panel panel-default root" id="ranking" style="margin-bottom: 5px;">
        <div class="panel-body">
            <p class="question"></p> 
            <div class="option-container root"></div>
        </div>
    </div>

    <div class="root" id="ranking-item" style="margin-bottom: 5px;">
        <div class="btn-group">
            <button class="btn btn-default btn-shadow btn-up"><i class="glyphicon glyphicon-arrow-up"></i></button>
            <button class="btn btn-default btn-shadow btn-down"><i class="glyphicon glyphicon-arrow-down"></i></button> 
        </div>
        <span class="option-text text" style="margin-left: 8px; margin-top: 10px"></span>
    </div>

    <div class="panel panel-default root" id="alternativeQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <p class="question"></p>
            <div class="option-container root"></div>
        </div>
    </div>



    <div class="btn-group" id="checkbox">
        <button class="btn btn-default btn-checkbox" name="primary">
            <span id="icons" style="margin-right: 6px">
                <i class="fa fa-square-o" id="normal"></i>
                <i class="fa fa-square hidden" id="over"></i>
                <i class="fa fa-check-square hidden" id="checked"></i>
            </span>
            <span class="option-text"></span></button>
    </div>

    <div id="checkbox-optionalanswer" style="width: 100%">
        <button class="btn btn-default btn-checkbox" name="primary" style="border-bottom-left-radius: 0px; border-bottom-right-radius: 0px">
            <span id="icons" style="margin-right: 6px">
                <i class="fa fa-square-o" id="normal"></i>
                <i class="fa fa-square hidden" id="over"></i>
                <i class="fa fa-check-square hidden" id="checked"></i>
            </span>
            <span class="option-text">Eigene Antwort(en)</span>
        </button>
        <textarea class="form-control optionalInput" rows="3" style="border-top-left-radius: 0px;"></textarea>
    </div>

    <div class="btn-group" id="radio">
        <button class="btn btn-default btn-radio" name="primary">
            <span id="icons" style="margin-right: 6px">
                <i class="fa fa-circle-thin" id="normal"></i>
                <i class="fa fa-circle hidden" id="over"></i>
                <i class="fa fa-check-circle hidden" id="checked"></i>
            </span>
            <span class="option-text"></span>
        </button>
    </div>

    <div id="radio-optionalanswer" style="width: 100%">
        <button class="btn btn-default btn-radio" name="primary" style="border-bottom-left-radius: 0px; border-bottom-right-radius: 0px">
            <span id="icons" style="margin-right: 6px">
                <i class="fa fa-circle-thin" id="normal"></i>
                <i class="fa fa-circle hidden" id="over"></i>
                <i class="fa fa-check-circle hidden" id="checked"></i>
            </span>
            <span class="option-text">Eigene Antwort(en)</span>
        </button>
        <textarea class="form-control optionalInput" rows="3" style="border-top-left-radius: 0px;"></textarea>
    </div>

    <div id="justification">
        <label for="justificationInput" class="text">Begründung(en)</label>
        <textarea class="form-control" id="justificationInput" rows="3"></textarea>
    </div>

    <button type="button" class="btn btn-default btn-popover-gesture-preview" id="btn-show-gesture" style="border: none; height: 39px"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text">Geste zeigen</span></button>

</div>