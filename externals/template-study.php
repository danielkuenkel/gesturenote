<div id="template-study-container" class="hidden">

    <div class="root" id="gestures-catalog-thumbnail">
        <div class="panel panel-default btn-shadow">
            <div class="panel-heading" style="text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">
                <span class="title-text ellipsis" style="position: relative; top: 1px;"></span>
            </div>

            <div class="panel-body">
                <div class="previewGesture"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
                <div class="text-center">
                    <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                    <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>
                </div>
            </div>
            <div class="panel-footer">
                <div class="btn-group btn-group-justified">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-info" id="btn-share-gesture"><i class="fa" aria-hidden="true"></i> <span class="btn-text"></span></button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" id="btn-show-gesture-info"><span class="btn-text">Mehr</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="scenes-catalog-thumbnail">

        <div id="pidoco" class="hidden" style="float: left;">
            <span class="label label-default"><i class="fa fa-link"></i> <span class="label-text"></span></span>
            <span class="text"></span>
        </div>
        <div id="web" class="hidden" style="float: left;">
            <span class="label label-default"><i class="fa fa-link"></i> <span class="label-text"></span></span>
            <span class="text"></span>
        </div>
        <div id="image" class="hidden" style="float: left;">
            <span class="label label-default"><i class="fa fa-image"></i> <span class="label-text"></span></span>
            <span class="text"></span>
        </div>
        <div id="videoEmbed" class="hidden" style="float: left;">
            <span class="label label-default"><i class="fa fa-film"></i> <span class="label-text"></span></span>
            <span class="text"></span>
        </div>
        <div style="float: left; margin-left: 10px;">
            <button type="button" class="btn btn-default btn-xs" id="btn-preview-scene"><i class="fa fa-eye"></i> <span class="btn-text">Zustands-Vorschau</span></button>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div id="trigger-catalog-thumbnail" class="text"></div>

    <div id="feedback-catalog-thumbnail">
        <div id="sound" class="hidden">
            <!--<span class="address"></span>--> 
            <span class="label label-default"><i class="fa fa-volume-up"></i> Sound</span>
            <span class="text"></span>

            <div class="audioPlayer" style="display: inline; margin-left: 10px">
                <div class="btn-group btn-group-xs">
                    <button class="btn btn-default btn-shadow" id="play"><i class="glyphicon glyphicon-play"></i></button>
                    <button class="btn btn-default btn-shadow" id="pause"><i class="glyphicon glyphicon-pause"></i></button>
                    <button class="btn btn-default btn-shadow" id="stop"><i class="glyphicon glyphicon-stop"></i></button>
                </div>

                <audio class="audio-holder" src="" preload="auto"></audio>
            </div>
        </div>

        <div id="text" class="hidden">
            <!--<span class="address"></span>--> 
            <span class="label label-default"><i class="fa fa-font"></i> Text</span>
            <span class="text"></span>
        </div>
    </div>

    <div class="root col-xs-6 col-sm-4 col-lg-3" id="participant-thumbnail">
        <div class="panel panel-default btn-shadow">
            <div class="panel-heading"></div>

            <div class="panel-body">
                <span class="label label-default" id="user"><i class="fa fa-user"></i> <span class="label-text"></span></span>
                <span class="label label-success hidden" id="execution-success"><i class="fa fa-check"></i> <span class="label-text hidden-xs hidden-sm"></span></span>
                <span class="label label-warning hidden" id="execution-error"><i class="fa fa-bolt"></i> <span class="label-text hidden-xs hidden-sm"></span></span>
                <span class="label label-danger hidden" id="execution-fault"><i class="fa fa-bolt"></i> <span class="label-text hidden-xs hidden-sm"></span></span>
            </div>
        </div>
    </div>

    <div class="root" id="no-phase-results">
        <div class="alert alert-warning" role="alert"><i class="glyphicon glyphicon-info-sign"></i> Für diesen Schritt sind keine Daten verfügbar.</div>
    </div>

    <div class="root" id="notes" style="margin-top: 30px;">
        <h3 id="headline">Notizen</h3>
        <hr>
        <textarea class="form-control" id="notes-input" rows="5"></textarea>
        <!--<button class="btn btn-default btn-block btn-shadow" id="btn-save-notes" style="margin-top: 10px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> <span class="btn-text">Notizen speichern</span></button>-->
    </div>

    <div class="root" id="letterOfAcceptance">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr>
        <span class="label label-success hidden" id="letter-accepted"><i class="fa fa-check"></i> <span class="label-text">Einverständniserklärung akzeptiert</span></span>
        <span class="label label-danger hidden" id="letter-not-accepted"><i class="fa fa-bolt"></i> <span class="label-text">Einverständniserklärung abgelehnt</span></span>
        <p id="letter-text" class="text" style="margin-top: 15px"></p>
    </div>

    <div class="root" id="thanks">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr>
        <p id="thanks-text" class="text"></p>
    </div>

    <div class="root" id="identification">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr>
        <span class="label label-default hidden" id="search-gestures">Es wurden Gesten ermittelt</span> 
        <span class="label label-default hidden" id="search-trigger">Es wurden Funktionen ermittelt</span>
        <div id="item-view" style="margin-top: 30px;">
            <div class="alert-space alert-no-phase-data"></div>
            <div class="list-container row" id="gestures-list-container"></div>
        </div>
    </div>

    <div class="row" id="trigger-identification">
        <div class="col-xs-6 col-lg-8">
            <div id="trigger-name"><span class="address"></span> <span class="text"></span></div>
            <div id="trigger-justification"><span class="address"></span> <span class="text"></span></div>
        </div>
    </div>

    <div class="root" id="sus">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr>
        <div class="range-container" style="margin-top: 20px">
            <div class="alert-space alert-sus-invalid"></div>
            <div id="sus-score-results">
                <div class="text-center">
                    <div style="font-size: 100pt; line-height: 100pt; margin-top: 0" id="average-score"></div>
                    <div id="score-adjective" style="margin-top: 0"><span class="address"></span> <span class="text"></span> <span class="tail"></span></div>
                </div>
                <i class="fa fa-chevron-down text" id="sus-score-pointer" aria-hidden="true" style="position: relative;"></i>
                <div class="progress" id="sus-score-progress" style="margin: 0; margin-top: -4px"></div>

                <div id="sus-marker-container" style="margin-top: 3px; margin-bottom: 100px"></div>
            </div>
        </div>
        <hr>
        <div class="list-container"></div>
    </div>

    <div class="text" id="sus-marker-item" style="position: absolute; display: inline-block">
        <div class="text-center">
            <i class="fa fa-long-arrow-up" style="font-size: 20pt; line-height: 20pt;" aria-hidden="true"></i>
            <div class="text" style="font-size: 9pt; line-height: 9pt;"></div>
            <div class="score" style="font-size: 9pt; line-height: 9pt;"></div>
        </div>
    </div>

    <div class="root" id="gus">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr>
        <span class="label label-default hidden" id="search-gestures">Es wurden Gesten ermittelt</span> 
        <span class="label label-default hidden" id="search-trigger">Es wurden Funktionen ermittelt</span>

        <div class="row">
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
        </div>

        <div class="list-container" style="margin-top: 30px;"></div>
    </div>

    <div class="root" id="questionnaireGestures">
        <h3 id="headline" style="margin-top: 0"></h3>
        <div class="list-container" style="margin-top: 20px;"></div>
    </div>

    <div class="root" id="questionnaire">
        <h3 id="headline" style="margin-top: 0"></h3>
        <div class="list-container" style="margin-top: 20px;"></div>
    </div>

    <div class="panel panel-default" id="counter" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <span class="label label-default" id="counter-label"><span class="counter-from"></span> <span class="counter-to"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <span class="answer text"></span>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text">Keine Antwort</span></span>
        </div>
    </div>

    <div class="panel panel-default" id="openQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <span class="answer text"></span>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text">Keine Antwort</span></span>
        </div>
    </div>

    <div class="panel panel-default" id="openQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <span class="answer text"></span>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text">Keine Antwort</span></span>
        </div>
    </div>

    <div class="panel panel-default" id="dichotomousQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <span class="label label-default hidden" id="justification">Mit Begründung</span>
            <span class="label label-default hidden" id="no-justification">Ohne Begründung</span>
            <span class="label label-default hidden" id="yes">Begründung bei Auswahl <em>Ja</em></span>
            <span class="label label-default hidden" id="no">Begründung bei Auswahl <em>Nein</em></span>
            <span class="label label-default hidden" id="always">Begründung <em>Immer</em></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text">Keine Antwort</span></span>
            <div id="selection"><span id="address">Auswahl:</span> <span class="text"></span></div>
            <div class="hidden" id="justification-content"><span class="address">Begründung(en):</span> <span class="text"></span></div>
            <span class="label label-danger hidden" id="no-justification-result"><i class="fa fa-bolt"></i> <span class="label-text">Keine Begründung</span></span>
        </div>
    </div>

    <div class="panel panel-default" id="dichotomousQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <span class="label label-default hidden" id="justification">Mit Begründung</span>
            <span class="label label-default hidden" id="no-justification">Ohne Begründung</span>
            <span class="label label-default hidden" id="yes">Begründung bei Auswahl <em>Ja</em></span>
            <span class="label label-default hidden" id="no">Begründung bei Auswahl <em>Nein</em></span>
            <span class="label label-default hidden" id="always">Begründung <em>Immer</em></span>
            <div class="hidden" style="width: 100%" id="item-factors">
                <span class="label label-primary" id="factor-main"></span>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <span class="label label-info" id="factor-primary"></span>
            </div>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text">Keine Antwort</span></span>
            <div id="selection"><span id="address">Auswahl:</span> <span class="text"></span></div>
            <div class="hidden" id="justification-content"><span class="address">Begründung(en):</span> <span class="text"></span></div>
            <span class="label label-danger hidden" id="no-justification-result"><i class="fa fa-bolt"></i> <span class="label-text">Keine Begründung</span></span>
        </div>
    </div>

    <div class="panel panel-default" id="groupingQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <span class="label label-default hidden" id="multiselect">Auswahl mehrerer Antworten erlaubt</span>
            <span class="label label-default hidden" id="singleselect">Auswahl einer Antwort erlaubt</span>
            <span class="label label-default hidden" id="optionalanswer">Eigene Antwort erlaubt</span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text">Keine Antwort</span></span>
            <div class="hidden" id="optionalanswer-content" style="margin-top: 17px;"><span class="address">Eigene Antwort(en):</span> <span class="text"></span></div>
            <span class="label label-warning hidden" id="no-optional-answer"><span class="label-text">Keine eigene Antwort(en)</span></span>
        </div>
    </div>

    <span id="grouping-question-item" class="text" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"></span>

    <div class="panel panel-default" id="groupingQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <span class="label label-default hidden" id="multiselect">Auswahl mehrerer Antworten erlaubt</span>
            <span class="label label-default hidden" id="singleselect">Auswahl einer Antwort erlaubt</span>
            <span class="label label-default hidden" id="justification">Mit Begründung</span>
            <span class="label label-default hidden" id="no-justification">Ohne Begründung</span>
            <span class="label label-default hidden" id="selectOne">Begründung bei mindestens einer Auswahl</span>
            <span class="label label-default hidden" id="selectNothing">Begründung bei keiner Auswahl</span>
            <span class="label label-default hidden" id="always">Begründung <em>Immer</em></span>
            <div class="hidden" style="width: 100%" id="item-factors">
                <span class="label label-primary" id="factor-main"></span>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <span class="label label-info" id="factor-primary"></span>
            </div>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <div class="hidden" id="justification-content"><span class="address">Begründung(en):</span> <span class="text"></span></div>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text">Keine Begründung(en)</span></span>
        </div>
    </div>

    <div id="grouping-question-gus-triggers-option" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block; margin-bottom: 5px"><span class="text"></span></div>
    <div id="grouping-question-gus-feedbacks-option" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block; margin-bottom: 5px"><span class="text"></span></div>
    <div id="grouping-question-gus-gestures-option" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block; margin-bottom: 5px">
        <span class="text"></span>
        <button type="button" class="btn btn-default btn-shadow btn-popover-gesture-preview" style="margin-left: 5px"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text">Geste zeigen</span></button>
    </div>

    <div class="panel panel-default" id="rating" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
        </div>
    </div>

    <div id="rating-item" class="text">
        <span id="rating-option" style="margin-right: 5px"></span>
        <span class="label label-success hidden" id="positive"><span class="label-text">positiv</span></span>
        <span class="label label-danger hidden" id="negative"><span class="label-text">negativ</span></span>
        <div class="pull-right text" id="score-container" style="margin-top: 9px"><span class="score-text"></span> <i class="fa" aria-hidden="true"></i></div>
        <div id="scale-container" style="margin-top: 10px;"></div>
        <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text">Keine Antwort</span></span>
    </div>

    <span id="rating-scale-item" class="text" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"></span>
    <!--<span id="rating-scale-item" class="text" style="padding: 7px; border-radius: 4px;"></span>-->

    <div class="panel panel-default" id="sumQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <span class="label label-default" id="maximum"><span class="label-text"></span></span>
            <span class="label label-default" id="allocation"><span class="label-text"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <div class="label label-success hidden" id="distributeAllPoints"><i class="fa fa-check"></i> <span class="label-text">Alle Punkte verteilt</span></div>
            <div class="label label-danger hidden" id="distributeNotAllPoints"><i class="fa fa-bolt"></i> <span class="label-text">Nicht alle Punkte verteilt</span></div>
        </div>
    </div>

    <div id="sum-question-item" class="text"></div>

    <div class="panel panel-default" id="ranking" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
        </div>
    </div>

    <div id="ranking-item" class="text"></div>

    <div class="panel panel-default" id="alternativeQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
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
            <div class="hidden" style="width: 100%" id="item-factors">
                <span class="label label-primary" id="factor-main"></span>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <span class="label label-info" id="factor-primary"></span>
            </div>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <div class="hidden" id="optionalanswer-content" style="margin-top: 17px;"><span class="address">Eigene Antwort(en):</span> <span class="text"></span></div>
            <span class="label label-warning hidden" id="no-optional-answer"><span class="label-text">Keine eigene Antwort(en)</span></span>
            <div class="hidden" id="justification-content"><span class="address">Begründung(en):</span> <span class="text"></span></div>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text">Keine Begründung(en)</span></span>
        </div>
    </div>

    <div id="alternativeQuestion-gesture-item" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block; margin-bottom: 5px">
        <span class="text"></span>
        <button type="button" class="btn btn-default btn-shadow btn-popover-gesture-preview" style="margin-left: 5px"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text">Geste zeigen</span></button>
    </div>

    <div id="alternativeQuestion-trigger-item" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"><span class="text"></span></div>

    <div class="panel panel-default" id="gusSingle" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <span class="label label-success hidden" id="positive"><span class="label-text">positiv</span></span>
            <span class="label label-danger hidden" id="negative"><span class="label-text">negativ</span></span>
            <div class="hidden" style="width: 100%" id="item-factors">
                <span class="label label-primary" id="factor-main"></span>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <span class="label label-info" id="factor-primary"></span>
            </div>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="pull-right text" id="score-container" style="margin-top: 9px"><span class="score-text"></span> <i class="fa" aria-hidden="true"></i></div>
            <div class="option-container"></div>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text">Keine Antwort</span></span>
        </div>
    </div>

    <span id="gus-single-item-option" class="text" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"></span>

    <div class="panel panel-default" id="susItem" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <span class="label label-success hidden" id="positive"><span class="label-text">positiv</span></span>
            <span class="label label-danger hidden" id="negative"><span class="label-text">negativ</span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="pull-right text" id="score-container" style="margin-top: 9px"><span class="score-text"></span> <i class="fa" aria-hidden="true"></i></div>
            <div class="option-container"></div>
            <span class="label label-danger hidden" id="no-answer"><i class="fa fa-bolt"></i> <span class="label-text">Keine Antwort</span></span>
        </div>
    </div>

    <span id="sus-item-option" class="text" style="padding: 7px; border-radius: 4px; margin-right: 6px; display: inline-block"></span>




    <div id="rtc-video-result">
        <div class="alert-space alert-record-url-invalid"></div>
        <div id="loader" class="hidden text-center">
            <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
            <div class="text">
                Einen Moment bitte... Videodaten werden geladen.
            </div>
        </div>
        <div id="video-timeline" class="hidden">
            <video id="video-holder" controls preload="auto" autoplay="false" style="width: 100%; height: auto; border-top-left-radius: 4px; border-top-right-radius: 4px"></video>
            <div id="results-timeline" style="margin-top: -8px; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"></div>
        </div>

    </div>

    <div class="root" id="gestureTraining">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr id="horizontalLine">
        <div class="alert-space alert-no-record"></div>
        <div class="alert-space alert-webm-unsupported"></div>
        <h3 id="headline-gestures">Gesten</h3>
        <hr>
        <div id="gestures-container"></div>
        <h3 id="headline-observations">Beobachtungen</h3>
        <hr>
        <div id="observations-container"></div>
    </div>

    <div class="row" id="training-gesture-item" style="margin-bottom: 30px">
        <div class="col-sm-6 root">
            <div class="previewGesture mousePlayable btn-shadow"></div>
            <div class="text-center gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div id="gesture"><span class="address"></span> <span class="text"></span></div>
            <div id="trigger"><span class="address"></span> <span class="text"></span></div>
            <div id="feedback"><span class="address"></span> <span class="content" style="display: inline-block"></span></div>
            <div id="recognition-time"><span class="address"></span> <span class="text"></span></div>
            <div id="repeats"><span class="address"></span> <span class="text"></span></div>
            <div id="training-time"><span class="address"></span> <span class="text"></span></div>
        </div>
    </div>



    <div class="root" id="gestureSlideshow">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr id="horizontalLine">
        <div class="alert-space alert-no-record"></div>
        <div class="alert-space alert-webm-unsupported"></div>
        <h3 id="headline-summary">Zusammenfassung</h3>
        <hr>
        <div id="summary-container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="text text-center" id="restarts">
                        <div class="text" style="font-size: 120pt; line-height: 110pt"></div>
                        <div class="address" style="font-size: 20pt">Neustarts</div>
                    </div>
                </div>
                <div class="col-sm-6 text-center">
                    Je weniger Neustarts es bei einer Gesten-Slideshow gab, desto besser. Dieser Scorewert kann mit der Erinnerbarkeit und Intuitivität eines Gestensets in Verbindung gebracht werden.
                </div>
            </div>

            <div id="gestures-container" style="margin-top: 40px"></div>
        </div>
        <h3 id="headline-observations">Beobachtungen</h3>
        <hr>
        <div id="observations-container"></div>
    </div>

    <div class="row" id="slideshow-gesture-item" style="margin-bottom: 30px">
        <div class="col-sm-6 root">
            <div class="previewGesture mousePlayable btn-shadow"></div>
            <div class="text-center gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div id="gesture"><span class="address"></span> <span class="text"></span></div>
            <div id="trigger"><span class="address"></span> <span class="text"></span></div>
            <div id="feedback"><span class="address"></span> <span class="content"></span></div>
            <div id="recognition-time"><span class="address"></span> <span class="text"></span></div>
            <div id="fits-false" class="hidden"><span class="address"></span> <span class="text" style="color: #d9534f"></span> <i class="fa fa-exclamation-triangle" style="color: #d9534f"></i></div>
            <div id="fits-correct" class="hidden"><span class="address"></span> <span class="text" style="color: #5cb85c"></span> <i class="fa fa-check" style="color: #5cb85c"></i></div>
        </div>
    </div>





    <div class="root" id="triggerSlideshow">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr id="horizontalLine">
        <div class="alert-space alert-webm-unsupported"></div>
        <div id="summary-container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="text text-center" id="score">
                        <div id="error" class="hidden">
                            <p><i class="fa fa-bolt text" style="font-size: 120pt; line-height: 110pt"></i></p>
                            <p>Der Scorewert kann nicht berechnet werden.</p>
                        </div>
                        <div class="address" style="font-size: 20pt"></div>
                        <div class="text" style="font-size: 120pt; line-height: 110pt"></div>
                    </div>
                </div>
                <div class="col-sm-6 text-center">
                    Je mehr korrekte Zuordnungen es bei einer Trigger-Slideshow gab, desto besser. Der Scorewert berechnet sich wie folgt: Falsche Zuordnungen / Anzahl der Gesten. Er liegt zwischen 0 (alles richtig zugeordnet) und 1 (alles falsch zugeordnet). Dieser Wert kann mit der Semantischen Verknüpfung, Genrealisierbarkeit und Intuitivität eines Gestensets in Verbindung gebracht werden.
                </div>
            </div>

            <div id="gestures-container" style="margin-top: 40px"></div>
        </div>
    </div>

    <div class="row" id="slideshow-trigger-item" style="margin-bottom: 30px">
        <div class="col-sm-6 root">
            <div class="previewGesture mousePlayable btn-shadow"></div>
            <div class="text-center gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div id="gesture"><span class="address"></span> <span class="text"></span></div>
            <div id="trigger"><span class="address"></span> <span class="text"></span></div>
            <div id="feedback"><span class="address"></span> <span class="content"></span></div>
            <div id="selection"><span class="address"></span> 
                <span id="fits-false" class="hidden"><span class="text" style="color: #d9534f"></span> <i class="fa fa-exclamation-triangle" style="color: #d9534f"></i></span>
                <span id="fits-correct" class="hidden"><span class="text" style="color: #5cb85c"></span> <i class="fa fa-check" style="color: #5cb85c"></i></span>
                <span id="no-answer" class="hidden"><span class="text" style="color: #ec971f"></span> <i class="fa fa-bolt" style="color: #ec971f"></i></span>
            </div>

        </div>
    </div>



    <div class="root" id="physicalStressTest">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr id="horizontalLine">
        <div class="alert-space alert-no-record"></div>
        <div class="alert-space alert-webm-unsupported"></div>
        <h3 id="headline-summary">Zusammenfassung</h3>
        <hr>
        <span class="label label-default hidden" id="repeats"><span class="address"></span> <span class="text"></span></span> 
        <span class="label label-default hidden" id="ask-single-questions"><span class="address"></span> <span class="text"></span></span>
        <span class="label label-default hidden" id="ask-sequence-questions"><span class="address"></span> <span class="text"></span></span>
        <div id="gestures-container"></div>
        <h3 id="headline-observations">Beobachtungen</h3>
        <hr>
        <div id="observations-container"></div>
        <!--<button class="btn btn-info btn-block btn-add-observations"><i class="fa fa-plus"></i> <span class="btn-text">Beobachtungen hinzufügen</span></button>-->
    </div>

    <div class="row" id="physicalStressTest-item" style="margin-bottom: 30px">
        <div class="col-sm-5 root">
            <div class="previewGesture mousePlayable btn-shadow"></div>
            <div class="text-center gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                </div>
            </div>
        </div>

        <div class="col-sm-7">
            <div id="gesture"><span class="address"></span> <span class="text"></span></div>
            <div id="single-stress-answers">
                <h4 id="headline-single-questions">Einzel-Antworten</h4>
                <div class="list-container"></div>
            </div>
            <div id="sequence-stress-answers" style="margin-top: 40px">
                <h4 id="headline-sequence-questions">Abschließende Antworten</h4>
                <div class="list-container"></div>
            </div>

            <!--<div id="trigger"><span class="address"></span> <span class="text"></span></div>-->
            <!--<div id="feedback"><span class="address"></span> <span class="content"></span></div>-->
            <!--            <div id="selection"><span class="address"></span> 
                            <span id="fits-false" class="hidden"><span class="text" style="color: #d9534f"></span> <i class="fa fa-exclamation-triangle" style="color: #d9534f"></i></span>
                            <span id="fits-correct" class="hidden"><span class="text" style="color: #5cb85c"></span> <i class="fa fa-check" style="color: #5cb85c"></i></span>
                            <span id="no-answer" class="hidden"><span class="text" style="color: #ec971f"></span> <i class="fa fa-bolt" style="color: #ec971f"></i></span>
                        </div>-->

        </div>
    </div>

    <div id="joint-answers">
        <div id="joint-answers-body" style="margin-bottom: 20px">
            <p class="question text">Welche Teile des Körpers wurden besonders beansprucht?</p>
            <div class="select-joints-humand-body" id="human-body" style="width: 450px; margin: auto">
                <div id="joint-container" style="position: absolute"></div>
                <img src="img/human_body.svg">
            </div>
        </div>

        <div id="joint-answers-hands" style="margin-bottom: 20px">
            <p class="question text">Welche Teile der Hand oder Hände wurden besonders beansprucht?</p>
            <div class="select-joints-humand-hand" id="human-hand" style="width: 450px; margin: auto">
                <div id="joint-container" style="position: absolute"></div>
                <img src="img/human_hand.svg">
            </div>
        </div>
    </div>




    <div class="root" id="scenario">
        <h3 id="headline" style="margin-top: 0"></h3>
        <hr id="horizontalLine">
        <div class="alert-space alert-no-record"></div>
        <div class="alert-space alert-webm-unsupported"></div>
        <div class="list-container" style="margin-top: 30px;"></div>
        <h3 id="headline-observations">Beobachtungen</h3>
        <hr>
        <div id="observations-container"></div>
    </div>


    <div id="add-observations-dropdown" style="margin-top: 20px">
        <div class="input-group">
            <span class="input-group-addon">Beobachtungsformat</span>
            <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="Bitte wählen"/>
            <div class="input-group-btn select" id="addFormatSelect" role="group">
                <button class="btn btn-default btn-shadow btn-dropdown" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                    <li id="counter"><a href="#"><?php echo $lang->questionFormats->counter->text ?></a></li>
                    <li id="openQuestion"><a href="#"><?php echo $lang->questionFormats->openQuestion->text ?></a></li>
                    <li id="dichotomousQuestion"><a href="#"><?php echo $lang->questionFormats->dichotomousQuestion->text ?></a></li>
                    <li id="groupingQuestion"><a href="#"><?php echo $lang->questionFormats->groupingQuestion->text ?></a></li>
                    <li id="rating"><a href="#"><?php echo $lang->questionFormats->rating->text ?></a></li>
                    <li id="sumQuestion"><a href="#"><?php echo $lang->questionFormats->sumQuestion->text ?></a></li>
                    <li id="ranking"><a href="#"><?php echo $lang->questionFormats->ranking->text ?></a></li>
                </ul>
                <button class="btn btn-info btn-shadow disabled dropdown-disabled" id="btn-add-observation" type="button"><span class="glyphicon glyphicon-plus"></span></button>
            </div>
        </div>
    </div>




    <div id="amount-container-appearance-trigger" style="margin-bottom: 30px">
        <h4 id="headline" style="margin-top: 0"><span class="text"></span> <span class="badge"></span></h4> 
        <!--<hr>-->
        <div id="item-view"></div>
    </div>

    <div id="appearance-trigger-gesture" class="panel panel-default" style="margin-bottom: 40px">
        <div class="panel-heading" id="headline-main-gesture"></div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-md-4 col-lg-5 root" id="main-gesture" style="margin-bottom: 15px">
                    <div class="previewGesture mousePlayable btn-shadow"></div>
                    <div class="text-center hidden gestureControls">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                            <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                            <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                            <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-8 col-lg-7" id="potential-parameters"></div>
            </div>
        </div>

        <hr style="margin: 0">

        <div class="panel-body">
            <div><span>Klassifizierte Gesten</span></div>
            <div class="row" style="margin-top: 10px">
                <div id="gestures-list-container"></div>
            </div>
        </div>

    </div>

    <div id="potential-gesture-parameters">
        <div id="parameters-amount">
            <div><h4 style="margin: 0"><i class="fa fa-pie-chart" aria-hidden="true"></i> Anzahl</h4></div>
            <span class="text" id="justification"></span>
            <br/>
            <span class="hidden success" id="well"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span>geeignet</span></span>
            <span class="hidden warning" id="even"><i class="fa fa-caret-right" aria-hidden="true"></i> <span>weder noch</span></span>
            <span class="hidden danger" id="less-well"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span>nicht geeignet</span></span>
        </div>
        <div id="parameters-agreement-measures" style="margin-top: 20px">
            <div><h4 style="margin: 0"><i class="fa fa-percent" aria-hidden="true"></i> Maß der Vermutung</h4></div>
            <div id="agreement"><span id="label">Schätzbarkeit:</span> <span class="text"></span></div>
        </div>
        <div id="parameters-guessability" class="hidden" style="margin-top: 20px">
            <div><h4 style="margin: 0"><i class="fa fa-users" aria-hidden="true"></i> Maß der Zustimmung</h4></div>
            <div id="accordance"><span id="label">Übereinstimmung:</span> <span class="text"></span></div>
        </div>
        <div id="parameters-cognitive-relationships" style="margin-top: 20px">
            <div><h4 style="margin: 0"><i class="fa fa-flash" aria-hidden="true"></i> Sinnzusammenhänge</h4></div>
            <div style="margin-top: 8px">
                <button type="button" class="btn btn-default btn-shadow" id="btn-open-cognitive-relationships"><i class="fa fa-check-square-o"></i> Überprüfen</button>
                <div style="margin-left: 10px">
                    <span class="hidden success" id="well"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span>geeignet</span></span>
                    <span class="hidden warning" id="even"><i class="fa fa-caret-right" aria-hidden="true"></i> <span>weder noch</span></span>
                    <span class="hidden danger" id="less-well"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span>nicht geeignet</span></span>
                </div>
            </div>
        </div>
        <div id="parameters-checklist" class="hidden" style="margin-top: 20px">
            <div><h4 style="margin: 0"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Checkliste</h4></div>
            <div style="margin-top: 8px">
                <button type="button" class="btn btn-default btn-shadow" id="btn-open-checklist"><i class="fa fa-check-square-o"></i> Überprüfen</button>
                <div style="margin-left: 10px">
                    <span class="hidden success" id="well"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span>geeignet</span></span>
                    <span class="hidden warning" id="even"><i class="fa fa-caret-right" aria-hidden="true"></i> <span>weder noch</span></span>
                    <span class="hidden danger" id="less-well"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span>nicht geeignet</span></span>
                </div>
            </div>
        </div>

    </div>


</div>











<div id="template-study-editable-container" class="hidden">

    <div class="panel panel-default" id="counter" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <span class="label label-default" id="counter-label"><span class="counter-from"></span> <span class="counter-to"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
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

    <!--    <div class="panel panel-default root" id="openQuestion" style="margin-bottom: 5px;">
            <div class="panel-heading">
                <div class="btn-group" style="margin-right: 10px">
                    <button class="btn btn-default btn-shadow btn-up"><span class="glyphicon glyphicon-arrow-up"></span></button>
                    <button class="btn btn-default btn-shadow btn-down"><span class="glyphicon glyphicon-arrow-down"></span></button>
                    <button class="btn btn-default btn-shadow btn-delete"><span class="glyphicon glyphicon-trash"></span></button>
                </div>
                <span>Offene Frage <span class="badgeId">0</span> von <span class="badgeQuantity">0</span></span>
            </div>
            <div class="panel-body">
                <div class="hidden" style="width: 100%; margin-bottom: 10px;" id="item-factors">
                    <div class="label label-primary" id="factor-main"></div>
                    <img src="img/factor-transition.jpg" class="item-factors-separator">
                    <div class="label label-info" id="factor-primary"></div>
                </div>
    
                <div class="form-group form-group-no-margin">
                    <div class="input-group">
                        <span class="input-group-addon">Frage/Aufforderung</span>
                        <input class="form-control item-input-text question" type="text" value="" placeholder="Frage oder Aufforderung"/>
                        <div class="input-group-btn">
                            <button class="btn btn-default btn-shadow show-hole-text" data-toggle="tooltip" title=""><span class="glyphicon glyphicon-eye-open"></span></button>
                        </div>
                    </div>
                </div>
            </div>
            <hr style="margin: 0">
            <div class="panel-body" id="answer">
                <textarea class="form-control" id="openQuestionInput" rows="5" placeholder=""></textarea>
            </div>
        </div>-->

    <div class="panel panel-default" id="openQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <textarea class="form-control" id="openQuestionInput" rows="5" placeholder=""></textarea>
        </div>
    </div>

    <div class="panel panel-default" id="dichotomousQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <span class="label label-default hidden" id="label-justification">Mit Begründung</span>
            <span class="label label-default hidden" id="label-no-justification">Ohne Begründung</span>
            <span class="label label-default hidden" id="label-yes">Begründung bei Auswahl <em>Ja</em></span>
            <span class="label label-default hidden" id="label-no">Begründung bei Auswahl <em>Nein</em></span>
            <span class="label label-default hidden" id="label-always">Begründung <em>Immer</em></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body" id="panel-body">
            <div class="btn-group switch">
                <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="yes" name="btn-success">Ja</button>
                <button class="btn btn-default btn-shadow btn-toggle-checkbox inactive" id="no" name="btn-success">Nein</button>
            </div>
        </div>
    </div>

    <div class="panel panel-default" id="groupingQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <span class="label label-default hidden" id="multiselect">Auswahl mehrerer Antworten erlaubt</span>
            <span class="label label-default hidden" id="singleselect">Auswahl einer Antwort erlaubt</span>
            <span class="label label-default hidden" id="optionalanswer">Eigene Antwort erlaubt</span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container root"></div>
        </div>
    </div>

    <div class="panel panel-default" id="rating" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default" id="sumQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <span class="label label-default" id="maximum"><span class="label-text"></span></span>
            <span class="label label-default" id="allocation"><span class="label-text"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
            <!--            <div class="label label-success hidden" id="distributeAllPoints"><i class="fa fa-check"></i> <span class="label-text">Alle Punkte verteilt</span></div>
                        <div class="label label-danger hidden" id="distributeNotAllPoints"><i class="fa fa-bolt"></i> <span class="label-text">Nicht alle Punkte verteilt</span></div>-->
        </div>
    </div>

    <div class="panel panel-default" id="ranking" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
        </div>
        <hr style="margin: 0">
        <div class="panel-body">
            <div class="option-container"></div>
        </div>
    </div>

</div>


<div id="item-container-moderator" class="hidden">
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