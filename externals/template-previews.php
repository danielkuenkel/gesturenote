<?php
include '../includes/language.php';
?>

<div id="item-container-moderator" class="hidden">

    <div id="moderator-web-rtc-placeholder" class="web-rtc-placeholder" style="width: 100%">
        <img src="img/web-rtc-placeholder.jpg" width="100%" height="auto"/>
        <div id="rtc-controls" class="btn-group" style="position: absolute; top: 0; right: 0;">
            <button type="button" id="btn-toggle-rtc-fixed" class="btn btn-link btn-no-shadow btn-toggle-rtc-fixed"><i class="glyphicon glyphicon-new-window"></i></button>
        </div>
    </div>

    <!-- alerts -->
    <div class="row root" id="no-phase-data">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <div class="alert-space alert-no-phase-data"></div>
        </div>
    </div>

    <!-- gesture thumbnail -->
    <div class="root gesture-thumbnail col-xs-6 col-sm-4" id="gesture-thumbnail">
        <div class="panel panel-default btn-shadow">
            <div class="panel-heading" style=" text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">
                <span class="title-text ellipsis" style="position: relative; top: 1px;"></span>
            </div>

            <div class="panel-body">
                <div class="previewGesture mousePlayable embed-responsive embed-responsive-4by3"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="btn-group btn-group-justified">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" id="btn-show-gesture-info"><span class="btn-text">Mehr</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- questionnaire container -->
    <div class="row root" id="questionnaire">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <h3 style="margin-top: 0"><?php echo $lang->questionnaire ?></h3>
            <div class="question-container"></div>
            <button class="next-step btn btn-success btn-block pull-right disabled" id="btn-next-step" style="margin-top: 10px"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
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
            <div class="question text"></div>
            <span class="label label-default" id="counter-label"><span class="counter-from"></span> <span class="counter-to"></span></span>
        </div>
    </div>

    <div class="panel panel-default root" id="openQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
            <span class="label label-default hidden" id="dimension"></span>
        </div>
    </div>

    <div class="panel panel-default root" id="openQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div class="question text"></div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <div class="label label-info" id="factor-primary"></div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="dichotomousQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
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
            <div class="question text"></div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
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
            <div class="question text"></div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
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
            <div class="question text"></div>
            <span class="label label-default hidden" id="multiselect">Auswahl mehrerer Antworten erlaubt</span>
            <span class="label label-default hidden" id="singleselect">Auswahl einer Antwort erlaubt</span>
            <span class="label label-default hidden" id="justification">Mit Begründung</span>
            <span class="label label-default hidden" id="no-justification">Ohne Begründung</span>
            <span class="label label-default hidden" id="selectOne">Begründung bei mindestens einer Auswahl</span>
            <span class="label label-default hidden" id="selectNothing">Begründung bei keiner Auswahl</span>
            <span class="label label-default hidden" id="always">Begründung <em>Immer</em></span>
            <span class="label label-default hidden" id="optionalanswer">Eigene Antwort erlaubt</span>
            <span class="label label-default hidden" id="dimension"></span>
            <div>Eingruppierungs-Optionen</div>
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default root" id="groupingQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <div class="label label-info" id="factor-primary"></div>
            </div>
            <span class="label label-default hidden" id="multiselect">Auswahl mehrerer Antworten erlaubt</span>
            <span class="label label-default hidden" id="singleselect">Auswahl einer Antwort erlaubt</span>
            <span class="label label-default hidden" id="justification">Mit Begründung</span>
            <span class="label label-default hidden" id="no-justification">Ohne Begründung</span>
            <span class="label label-default hidden" id="selectOne">Begründung bei mindestens einer Auswahl</span>
            <span class="label label-default hidden" id="selectNothing">Begründung bei keiner Auswahl</span>
            <span class="label label-default hidden" id="always">Begründung <em>Immer</em></span>
            <span class="label label-default hidden" id="optionalanswer">Eigene Antwort erlaubt</span>
            <div>Eingruppierungs-Optionen</div>
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default root" id="groupingQuestionOptions" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
            <div class="hidden" style="width: 100%" id="item-factors">
                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">
                <div class="label label-info" id="factor-primary"></div>
            </div>
            <span class="label label-default hidden" id="multiselect">Auswahl mehrerer Antworten erlaubt</span>
            <span class="label label-default hidden" id="singleselect">Auswahl einer Antwort erlaubt</span>
            <span class="label label-default hidden" id="justification">Mit Begründung</span>
            <span class="label label-default hidden" id="no-justification">Ohne Begründung</span>
            <span class="label label-default hidden" id="selectOne">Begründung bei mindestens einer Auswahl</span>
            <span class="label label-default hidden" id="selectNothing">Begründung bei keiner Auswahl</span>
            <span class="label label-default hidden" id="always">Begründung <em>Immer</em></span>
            <span class="label label-default hidden" id="optionalanswer">Eigene Antwort erlaubt</span>
            <div>Eingruppierungs-Optionen</div>
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default root" id="rating" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
            <span class="label label-default hidden" id="dimension"></span>
            <div>Rating-Optionen</div>
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default root" id="sumQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div class="question text"></div>
            <span class="label label-default hidden" id="dimension"></span>
            <div id="distribution-container"></div>
            <div>Antworten der Summenfrage</div>
            <div class="option-container"></div>
        </div>
    </div>

    <div class="panel panel-default root" id="ranking" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
            <span class="label label-default hidden" id="dimension"></span>
            <div>Ranking-Optionen</div>
            <div class="option-container"></div>
        </div>
    </div>


    <!-- SUS container & item -->
    <div class="row root" id="sus">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <h3 style="margin-top: 0">System Usability Scale</h3>
            <div class="question-container"></div>
            <button class="next-step btn btn-success btn-block pull-right disabled" id="btn-next-step" style="margin-top: 10px"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div class="panel panel-default root" id="susItem" style="margin-bottom: 5px;">
        <div class="panel-body">
            <!--<span class="label label-default" id="format"><span class="format-text"></span></span>-->
            <span class="question text"></span> 
            <span class="label label-danger hidden" id="reversed" style="margin-left: 4px">negiert</span>
        </div>
    </div>


    <!-- GUS container & item -->
    <div class="row root" id="gus">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">
            <!--<div class="panel panel-default">-->
            <!--<div class="panel-heading">-->
            <h3 style="margin-top: 0">Gesture Usability Scale</h3>
            <!--</div>-->
            <div class="row">
                <div class="col-sm-6">
                    <div id="gesture"><span class="address"></span> <span class="text"></span></div>
                    <div id="trigger"><span class="address"></span> <span class="text"></span></div>
                    <div id="feedback"><span class="address"></span> <span class="text"></span></div>
                </div>

                <div class="col-sm-6">
                    <div class="previewGesture autoplay mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
                    <div class="text-center gestureControls">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                            <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 question-container" style="margin-top: 10px"></div>
            </div>
            <!--</div>-->
            <button class="next-step btn btn-success btn-block pull-right disabled" id="btn-next-step" style="margin-top: 10px"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div class="panel panel-default root" id="gusSingle" style="margin-bottom: 5px;">
        <div class="panel-body">
            <span class="label label-default" id="format"><span class="format-text"></span></span>
            <div class="question text"></div>
            <div style="display: inline;">
                <div class="hidden" id="item-factors" style="display: inline-block">
                    <div class="label label-primary" id="factor-main"></div>
                    <img src="img/factor-transition.jpg" class="item-factors-separator">
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

            <h3 style="margin-top: 0">Gesture Usability Scale</h3>

            <div class="question-container"></div>

            <button class="next-step btn btn-success btn-block pull-right disabled" id="btn-next-step" style="margin-top: 10px"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>


    <div class="row root" id="letterOfAcceptance">
        <div class="col-md-6 col-lg-4 rtc-scalable" id="column-left">
            <!--            <div class="panel panel-default">
                            <div class="panel-heading">
                                Test Panel
                            </div>
                            <div class="panel-body letter-text"></div>
                        </div>-->
        </div>
        <div class="col-md-6 col-lg-8" id="column-right">
            <div class="">
                <div class="">
                    <h3 style="margin-top: 0">Einverständniserklärung</h3>
                </div>
                <div class="">
                    <p class="text letter-text"></p>
                    <div class="alert-space alert-please-wait"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row root" id="thanks">
        <!--        <div class="col-md-7 col-lg-4" id="column-left"></div>
                <div class="col-md-5 col-lg-8" id="column-right">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Danksagung
                        </div>
                        <div class="panel-body">
                            <p class="text thanks-text"></p>
                            <button class="btn btn-success btn-block btn-shadow" id="btn-leave-survey">Befragung verlassen</button>
                        </div>
                    </div>
                </div>-->

        <div class="col-sm-5 col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-sm-7 col-md-8" id="column-right" style="margin-bottom: 80px;">
            <h3 class="headline" style="margin: 0">Danke für die Teilnahme</h3>
            <div class="row " style="margin-top: 20px">
                <!--                <div class="col-sm-6" style="margin-bottom: 20px;">
                                    <i class="fa fa-heart" style="font-size: 70pt; color: #ca3667"></i>
                                    <div class="text" id="thanks-text"></div>
                                </div>-->
                <div class="col-sm-12" id="upload-instructions" style="margin-bottom: 20px;">
                    <i class="fa fa-upload" aria-hidden="true" style="font-size: 70pt; color: #777"></i>
                    <div class="text">
                        Bitte warten! Die Daten werden nun gespeichert. Bitte nicht dieses Fenster, bzw. den Browser schließen oder neu laden. Wenn die Daten gespeichert sind, erscheint eine Meldung.
                    </div>
                    <div id="rtc-uploads-status" class="hidden text">
                        Bitte warten… Videodaten werden gespeichert.
                    </div>
                </div>
                <div class="col-sm-12 hidden" id="upload-retry" style="margin-bottom: 20px;">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size: 70pt; color: #d9534f"></i>
                    <div class="text">
                        <p>Es gab einen Fehler. Die Daten konnten nicht gespeichert werden. Bitte noch einmal versuchen.</p>
                        <button type="button" class="btn btn-danger btn-shadow" id="btn-retry-upload"><i class="fa fa-refresh" aria-hidden="true"></i> <span class="btn-text">Noch einmal probieren</span></button>
                    </div>
                </div>
                <div class="col-sm-12 hidden" style="margin-bottom: 20px;" id="upload-done">
                    <i class="fa fa-check" aria-hidden="true" style="font-size: 70pt; color: #5cb85c"></i>
                    <div class="text">
                        Die Studien-Daten wurden erfolgreich übertragen. Sie können das Fenster nun schließen oder an weiteren Studien teilnehmen.
                    </div>
                </div>
            </div>

            <button class="btn btn-success btn-block btn-shadow hidden" id="btn-leave-survey">Befragung verlassen</button>
        </div>
    </div>


    <!-- gesture training container -->
    <div class="row root" id="gestureTraining">
        <div class="col-md-6 col-lg-5 rtc-scalable" id="column-left" style="margin-bottom: 20px">
            <div class="panel panel panel-default" id="training">
                <div class="panel-heading">
                    <span class="panel-heading-text"></span>
                </div>
                <div class="panel-body">
                    <div id="trainingContainer"></div>
                    <div class="alert-space alert-no-phase-data"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-7" id="column-right">
            <div class="" id="general">
                <h3 id="heading" style="margin-top: 0"></h3>
                <div id="description"></div>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-start-training" style="margin-top: 6px;">Jetzt starten</button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-open-prototype" style="margin-top: 6px;">Prototyp öffnen</button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-start-screen-sharing" style="margin-top: 6px;"><i class="fa fa-circle-o-notch fa-spin hidden"></i> Screensharing starten</button>
                <button type="button" class="btn btn-success btn-block btn-shadow disabled hidden" id="btn-stop-screen-sharing" style="margin-top: 6px;">Screensharing beenden</button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-done-training" style="margin-top: 6px;"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></button>
            </div>
            <div class="" id="observations">
                <h3><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>
            </div>
        </div>
    </div>

    <!--    <div id="trainingItem" class="row">
            <div class="col-sm-6 col-md-12 col-lg-6 left" style="margin-bottom: 10px;">
                <div class="previewGesture embed-responsive embed-responsive-4by3"></div>
                <div>
                    <div id="title"><span class="address"></span> <span class="text"></span></div>
                    <div id="repeats"><span class="address"></span> <span class="text"></span></div>
                    <div id="trigger"><span class="address"></span> <span class="text"></span></div>
                    <div id="feedback"><span class="address"></span> <span class="text"></span></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-12 col-lg-6 right">
                <div class="btn-group-vertical btn-block">
                    <button type="button" class="btn btn-default btn-shadow btn-block btn-popover-gesture-preview" style="margin-top: 10px"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text">Geste zeigen</span></button>
                    <button type="button" class="btn btn-info btn-shadow disabled" id="trigger-training"><span class="btn-text">Trainieren</span></button>
                    <button type="button" class="btn btn-info btn-shadow disabled" id="trigger-feedback"><span class="btn-text">Feedback geben</span></button>
                </div>
    
                <button type="button" class="btn btn-success btn-shadow btn-block disabled" id="next-gesture"><span class="btn-text">Nächste Geste</span> <span aria-hidden="true">&rarr;</span></button>
                <button type="button" class="btn btn-success btn-shadow btn-block disabled hidden" id="training-done"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
            </div>
        </div>-->

    <!--<div class="col-xs-12 ">-->
    <div class="row root"  id="trainingItem">
        <div class="col-xs-5 col-sm-6 col-md-4">
            <div id="trigger"><span class="address"></span> <span class="text"></span></div>
            <div id="repeats"><span class="address"></span> <span class="text"></span></div>
            <div class="btn-shadow">
                <!--<div class="panel-body">-->
                <div class="previewGesture mousePlayable embed-responsive embed-responsive-4by3"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                    </div>
                </div>

                <!--<button type="button" class="btn btn-success btn-block disabled" id="btn-trigger-woz" style="margin-top: 10px;">Diese</button>-->
                <!--</div>-->
            </div>
            <button type="button" class="btn btn-default btn-block btn-shadow disabled" id="btn-show-gesture" style="margin-top: 10px"><i class="fa fa-circle-o-notch fa-spin hidden"></i> <span class="btn-text">Geste zeigen</span></button>

        </div>
        <div class="col-xs-7 col-sm-6 col-md-8" id="transition-scenes">
            <h4 id="start-scene-header" class="hidden" style="margin:0">Zustand</h4>
            <div class="hidden" id="start-scene-container" style="margin-bottom: 10px"></div>
            <h4 style="margin: 0" id="transition-feedback-header" class="hidden">Feedback</h4>
            <div class="hidden" id="transition-feedback-container" style="margin-bottom: 10px"></div>
            <h4 style="margin: 0" id="transition-scene-header" class="hidden">Zwischenzustände</h4>
            <div class="hidden" id="transition-scene-container" style="margin-bottom: 10px"></div>
            <h4 style="margin: 0" id="follow-scene-header" class="hidden">Folgezustand</h4>
            <div id="follow-scene-container" class="hidden"></div>
            <button type="button" class="btn btn-default btn-shadow btn-block disabled hidden" id="btn-repeat-training"  style="margin-top: 10px"><span class="btn-text">Training wiederholen</span></button>
        </div>
        <div class="col-xs-12" style="margin-top: 10px">
            <button type="button" class="btn btn-success btn-shadow btn-block disabled" id="next-gesture"><span class="btn-text">Nächste Geste</span> <span aria-hidden="true">&rarr;</span></button>
            <button type="button" class="btn btn-success btn-shadow btn-block disabled hidden" id="training-done"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <!--</div>-->


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
            <div class="" id="general">
                <h3 class="headline" style="margin: 0"></h3>
                <p id="description"></p>
                <button type="button" class="btn btn-success btn-block btn-shadow" id="btn-start-slideshow" style="margin-top: 6px;">Jetzt starten</button>
            </div>

            <div class="" id="observations">
                <h3><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>
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
    <!--                <button type="button" class="btn btn-danger btn-shadow disabled" id="wrong-slide"><span class="btn-text">Falsch</span></button>
                <button type="button" class="btn btn-success btn-shadow disabled" id="correct-slide"><span class="btn-text">Richtig</span></button>-->
                <button type="button" class="btn btn-success btn-shadow disabled" id="btn-done"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
            </div>
        </div>
    </div>


    <!-- slideshow container -->

    <div class="row root" id="triggerSlideshow">
        <div class="col-md-4" id="column-left"></div>
        <div class="col-md-8" id="column-right">

            <div id="general">
                <h3 class="headline" style="margin: 0"></h3>
                <p id="description"></p>
                <button type="button" class="btn btn-success btn-block btn-shadow" id="btn-start-slideshow" style="margin-top: 6px;">Jetzt starten</button>
            </div>

            <div >
                <h3>Elemente</h3>
                <div class="question-container"></div>
            </div>

            <button type="button" class="btn btn-success btn-block btn-shadow disabled hidden" id="btn-done-slideshow" style="margin-top: 6px;"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div id="gestureSlideshowItem" class="panel panel-default" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>Erfragt wird Funktion: <span id="searched" style="color: #303030"></span></div>
            <div>Gezeigt wird Geste: <span id="given" style="color: #303030"></span></div>
        </div>
    </div>

    <div id="triggerSlideshowItem" class="panel panel-default" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div class="label label-success hidden" id="answered-correct"><i class="fa fa-check"></i> <span class="label-text"><?php echo $lang->answeredCorrect ?></span></div>
            <div class="label label-danger hidden" id="answered-wrong"><i class="fa fa-bolt"></i> <span class="label-text"><?php echo $lang->answeredWrong ?></span></div>
            <div class="label label-warning hidden" id="not-answered"><i class="fa fa-ellipsis-h"></i> <span class="label-text"><?php echo $lang->notAnswered ?></span></div>
            <div>Erfragt wird Funktion: <span id="searched" style="color: #303030"></span></div>
            <div style="margin-right: 10px; float: left">Gezeigt wird Geste: <span id="given" style="color: #303030"></span>
                <button style="height: auto" type="button" class="btn btn-xs btn-default btn-shadow btn-popover-gesture-preview"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text">Geste zeigen</span></button>
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
                                <button type="button" class="btn btn-success btn-shadow disabled" id="btn-next-gesture"><i class="fa fa-check hidden"></i> <span class="btn-text">Nächste Geste</span> <span id="next-arrow" aria-hidden="true">&rarr;</span></button>
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
        <div class="col-md-6" id="column-right">

            <div id="general">
                <h3 class="headline" style="margin: 0"></h3>
                <p id="description"></p>
                <button type="button" class="btn btn-success btn-block btn-shadow" id="btn-start-stress-test" style="margin-top: 6px;">Jetzt starten</button>
            </div>

            <div id="gestures-container" style="margin-top: 30px"></div>

            <div class="" id="observations">
                <h3><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>
            </div>
        </div>
    </div>

    <div class="" id="physicalStressTest-item" style="margin-bottom: 40px">
        <div class="root">
            <div style="max-width: 300px; margin: 0 auto">
                <div class="previewGesture mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="">
            <!--<div id="gesture"><span class="address"></span> <span class="text"></span></div>-->
            <div id="single-stress-answers">
                <h3 id="headline-single-questions">Einzel-Antworten</h3>
                <div class="question-container"></div>
            </div>
            <div id="sequence-stress-answers" style="margin-top: 40px">
                <h3 id="headline-sequence-questions">Abschließende Antworten</h3>
                <div class="question-container"></div>
            </div>

        </div>
    </div>


    <!-- scenario container -->

    <div  class="row root" id="scenario">
        <div class="col-sm-6 col-md-7 col-lg-6 rtc-scalable" id="column-left">
            <div class="panel panel-default" id="woz-controls">
                <div class="panel-heading">Wizard-of-Oz-Experiment <button class="btn btn-xs btn-default disabled pull-right" id="btn-reset-scenes"><i class="fa fa-refresh"></i> <?php echo $lang->reset ?></button></div>

                <div class="panel-body" style="padding-bottom: 0">
                    <div id="wozExperiment" style="margin-bottom: 20px;">
                        <div style="margin-bottom: 10px" class="text">Welche Geste hat der Proband vorgeführt?</div>
                        <div class="alert-space alert-no-phase-data"></div>
                        <div class="row woz-container"></div>
                        <button type="button" class="btn btn-default btn-block btn-other-gesture-fit" id="no-gesture-fit-found" style="margin-top: 20px">Es wurde eine ganz andere Geste vorgeführt</button>
                    </div>
                </div>
            </div>
            <div class="panel panel-default" id="help-controls">
                <div class="panel-heading">Hilfe</div>
                <div class="panel-body" style="padding-bottom: 0">
                    <div class="alert-space alert-no-phase-data"></div>
                    <div class="help-container"></div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-5 col-lg-6" id="column-right">
            <div class="" id="general">
                <h3 class="headline" style="margin-top: 0px">Allgemeines</h3>
                <div class="">
                    <div id="task"><span class="address"></span>: <span class="text"></span></div>
                    <div id="description"><span class="address"></span>: <span class="text"></span></div>
                    <button type="button" class="btn btn-success btn-block btn-shadow" id="btn-open-prototype" style="margin-top: 6px;">Prototyp öffnen</button>
                    <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-start-screen-sharing" style="margin-top: 6px;"><i class="fa fa-circle-o-notch fa-spin hidden"></i> Screensharing starten</button>
                    <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-stop-screen-sharing" style="margin-top: 6px;">Screensharing beenden</button>
                    <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-done-scenario" style="margin-top: 6px;"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
                </div>
            </div>
            <div class="" id="observations">
                <h3><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>
            </div>
        </div>
    </div>

    <div class="col-xs-6 col-sm-4 col-md-4 root" id="wozItem">
        <div class="panel panel-default btn-shadow">
            <div class="panel-body">
                <div class="previewGesture mousePlayable embed-responsive embed-responsive-4by3"></div>
                <div class="text-center hidden gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                    </div>
                </div>

                <button type="button" class="btn btn-success btn-block disabled" id="btn-trigger-woz" style="margin-top: 10px;">Diese</button>
            </div>
        </div>
    </div>

    <div class="col-xs-12 root" id="wozItemWithScenes">
        <div class="row">
            <div class="col-xs-5 col-sm-6 col-md-4">
                <div class="btn-shadow">


                    <div class="previewGesture mousePlayable embed-responsive embed-responsive-4by3" style="border-radius: 0px; border-top-left-radius: 4px; border-top-right-radius: 4px"></div>
                    <div class="text-center  hidden gestureControls">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                            <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success btn-block disabled" id="btn-trigger-woz" style="border-top-left-radius: 0px; border-top-right-radius: 0px">Diese</button>
                </div>
            </div>
            <div class="col-xs-7 col-sm-6 col-md-8" id="transition-scenes">
                <h4 style="margin:0">Aktueller Zustand</h4>
                <div id="start-scene-container"></div>
                <h4 style="margin-bottom: 0" id="transition-feedback-header" class="hidden">Feedback</h4>
                <div class="hidden" id="transition-feedback-container"></div>
                <h4 style="margin-bottom: 0" id="transition-scene-header" class="hidden">Zwischenzustände</h4>
                <div class="hidden" id="transition-scene-container"></div>
                <h4 style="margin-bottom: 0" id="follow-scene-header" class="hidden">Folgezustand</h4>
                <div id="follow-scene-container" class="hidden"></div>
            </div>
        </div>

    </div>

    <div class="btn-group" id="wozItemWithScenesButton" style="margin-top: 8px">
        <button type="button" class="btn btn-default btn-shadow disabled btn-trigger-scene">
            <i class="hidden fa fa-image" id="scene-image"></i> 
            <i class="hidden fa fa-link" id="scene-web"></i> 
            <i class="hidden fa fa-link" id="scene-pidoco"></i> 
            <i class="hidden fa fa-film" id="scene-videoEmbed"></i> 
            <span class="btn-text ellipsis"></span> <span class="badge transition-time"></span>
            <div id="transition-indicator" class="hidden" style="position: absolute; bottom: 0; height: 3px; left: 0; right: 0; background-color: white"></div>
        </button>
    </div>

    <div class="btn-group" id="wozFeedbackItemButton" style="margin-top: 8px">
        <button type="button" class="btn btn-default btn-shadow disabled btn-trigger-feedback">
            <i class="hidden fa fa-circle-o-notch fa-spin" id="waiting-indicator"></i> 
            <i class="hidden fa fa-font" id="feedback-text"></i> 
            <i class="hidden fa fa-volume-up" id="feedback-sound"></i> 
            <span class="btn-text ellipsis"></span> <span class="badge transition-time"></span>
            <div id="transition-indicator" class="hidden" style="position: absolute; bottom: 0; height: 3px; left: 0; right: 0; background-color: white"></div>
        </button>
    </div>

    <div id="helpItem" style="margin-bottom: 16px;">
        <div class="help-title"></div>
        <div class="btn-group" style="margin-top: 10px;">
            <button type="button" class="btn btn-info btn-shadow disabled" id="offer-help"><i class="fa fa-life-ring"></i> Hilfe anbieten</button>
            <button type="button" class="btn btn-default btn-shadow btn-popover-gesture-preview hidden"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text">Geste zeigen</span></button>
        </div>
    </div>


    <!-- identification container -->

    <div class="row root" id="identification">
        <div class="col-md-6 col-lg-5 rtc-scalable" id="column-left">
            <div class="panel panel-default" id="slides">
                <div class="panel-heading">
                    <span class="panel-heading-text"></span>
                </div>
                <div class="panel-body">
                    <div id="identificationContainer"></div>
                </div>
            </div>

            <div class="panel panel-default hidden" id="identified-gesture">
                <div class="panel-heading">
                    <span class="panel-heading-text">Aufgezeichnete Geste speichern</span>
                </div>
                <div class="panel-body">
                    <div id="file-transfer-loader">
                        <p class="text"><i class="fa fa-circle-o-notch fa-spin"></i> Geste wird übertragen …</p>
                        <div id="file-transfer-loading-indicator" style="height: 10px; width:100%; background-color: #3379b7; border-radius: 4px"></div>
                    </div>
                    <div class="hidden" id="gesture-recorder-container"></div>
                </div>
            </div>

            <div class="panel panel-default hidden" id="identified-trigger">
                <div class="panel-heading">
                    <span class="panel-heading-text">Favorisierte Funktion(en)</span>
                </div>
                <div class="panel-body">
                    <div class="alert-space alert-waiting-for-tester"></div>
                    <div class="question-container"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-7" id="column-right">
            <div class="" id="general">
                <h3 class="headline" style="margin: 0"></h3>
                <div>
                    <span class="label label-default hidden" id="search-gestures">Es werden Gesten ermittelt</span> 
                    <span class="label label-default hidden" id="search-trigger">Es werden Funktionen ermittelt</span>
                </div>
                <p id="description"></p>
                <button type="button" class="btn btn-success btn-block btn-shadow" id="btn-open-prototype" style="margin-top: 6px;">Prototyp öffnen</button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-start-screen-sharing" style="margin-top: 6px;"><i class="fa fa-circle-o-notch fa-spin hidden"></i> Screensharing starten</button>
                <button type="button" class="btn btn-success btn-block btn-shadow disabled hidden" id="btn-stop-screen-sharing" style="margin-top: 6px;">Screensharing beenden</button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-done-identification" style="margin-top: 6px;"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></button>
            </div>

            <div class="" id="observations">
                <h3><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>
            </div>
        </div>
    </div>

    <div id="identificationItem-gestures">
        <div id="search-for"><span class="address"></span> <span class="text"></span></div>
        <div id="transition-scenes" class="root"></div>
        <div style="margin-top: 10px">
            <button class="btn btn-block btn-success btn-shadow disabled" id="btn-start-gesture-recording" name="btn-success"><i class="glyphicon glyphicon-record"></i> Geste aufzeichnen</button>
            <button class="btn btn-block btn-default btn-shadow hidden" id="btn-start-gesture-rerecording" name="btn-success"><i class="glyphicon glyphicon-record"></i> Geste neu aufzeichnen</button>
            <button class="btn btn-block btn-success btn-shadow hidden" id="btn-stop-gesture-recording" name="btn-success"><i class="glyphicon glyphicon-stop"></i> Aufzeichnung stoppen</span></button>
            <button class="btn btn-block btn-success btn-shadow disabled hidden" id="btn-next-trigger" name="btn-success">Nächste Funktion &rarr;</button>
            <button class="btn btn-block btn-success btn-shadow disabled hidden" id="btn-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div id="identificationItem-trigger">
        <div id="search-for"><span class="address"></span> <span class="text"></span> 
            <button type="button" class="btn btn-xs btn-default btn-popover-gesture-preview" style="height: 22px; margin-left: 5px"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text">Geste zeigen</span></button>
        </div> 
        <div id="transition-scenes" class="root"></div>
        <div style="margin-top: 10px">
            <button class="btn btn-block btn-success btn-shadow disabled" id="btn-request-trigger" name="btn-success">Funktion erfragen</span></button>
            <button class="btn btn-block btn-success btn-shadow disabled hidden" id="btn-next-trigger" name="btn-success">Nächste Geste &rarr;</button>
            <button class="btn btn-block btn-success btn-shadow disabled hidden" id="btn-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div id="transition-scene-item" style="display: inline">
        <div class="selected-icon hidden" style="display: inline-block"></div>
        <div class="scene-data" style="display: inline-block"></div>
    </div>


    <!-- exploration container -->

    <!--    <div class="row root" id="exploration">
            <div class="col-md-6 rtc-scalable" id="column-left">
    
                <div class="panel panel-default" id="exploration-controls">
                    <div class="panel-heading">Exploration</div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <div style="margin-bottom: 20px;">
                            <div style="float: left;  margin-right: 10px; ">
                                Aktuelle Szene: <span class="label label-default">
                                    <i class="fa fa-link hidden" id="icon-pidoco"></i>
                                    <i class="fa fa-link hidden" id="icon-web"></i>
                                    <i class="fa fa-image hidden" id="icon-image"></i>
                                    <i class="fa fa-film hidden" id="icon-videoEmbed"></i> <span class="label-text"></span></span> <span id="current-scene" class="text">
                                </span>
                            </div>
                            <div class="btn-group" style="float: left;margin-top: 4px">
                                <button type="button" class="btn btn-default btn-shadow btn-xs" id="btn-preview-scene"><i class="fa fa-eye"></i> <span class="btn-text">Zustands-Vorschau</span></button>
                                <button type="button" class="btn btn-default btn-shadow btn-xs" id="btn-reload-scene"><i class="glyphicon glyphicon-refresh"></i> <span class="btn-text">Zustand neu laden</span></button>
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                    <hr style="margin: 0">
                    <div class="panel-body" style="padding-bottom: 0">
                        <div style="margin-bottom: 20px;">
                            <h4 style="margin-top: 0px; margin-bottom: 10px">Simulationselemente</h4>
                            <div class="text">Welche Geste stehen zur Auswahl?</div>
                            <div class="alert-space alert-no-phase-data"></div>
                            <div class="row" id="exploration-items-container" style="margin-top: 10px"></div>
                            <button type="button" class="btn btn-default btn-block btn-shadow disabled" id="btn-show-gestures">Gestenauswahl starten</button>
                            <button type="button" class="btn btn-default btn-block btn-shadow hidden disabled" id="btn-next-scene">Nächste Scene</button>
                            <button type="button" class="btn btn-success btn-block btn-shadow hidden disabled" id="btn-next-step" style="margin-top: 6px;"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6" id="column-right">
                <div id="general">
                    <h3 class="headline" style="margin-top: 0px">Allgemeines</h3>
                    <p id="description"></p>
                    <button type="button" class="btn btn-success btn-block btn-shadow" id="btn-start-exploration" style="margin-top: 6px;">Jetzt starten</button>
                </div>
    
                <div class="" id="observations">
                    <h3><?php echo $lang->observations ?></h3>
                    <div class="alert-space alert-no-phase-data"></div>
                    <div class="question-container"></div>
                </div>
            </div>
        </div>-->

    <div class="row root" id="exploration">
        <div class="col-md-6 col-lg-5 rtc-scalable" id="column-left">
            <div class="panel panel-default" id="slides">
                <div class="panel-heading">
                    <span class="panel-heading-text"></span>
                </div>
                <div class="panel-body">
                    <div id="exploration-container"></div>
                </div>
            </div>

            <div class="panel panel-default hidden" id="identified-gestures">
                <div class="panel-heading">
                    <span class="panel-heading-text">Favorisierte Geste(n)</span>
                </div>
                <div class="panel-body">
                    <div class="alert-space alert-waiting-for-tester"></div>
                    <div class="question-container"></div>
                </div>
            </div>

            <div class="panel panel-default hidden" id="identified-trigger">
                <div class="panel-heading">
                    <span class="panel-heading-text">Favorisierte Funktion(en)</span>
                </div>
                <div class="panel-body">
                    <div class="alert-space alert-waiting-for-tester"></div>
                    <div class="question-container"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-7" id="column-right">
            <div class="" id="general">
                <h3 class="headline" style="margin: 0"></h3>
                <p id="description"></p>
                <button type="button" class="btn btn-success btn-block btn-shadow" id="btn-open-prototype" style="margin-top: 6px;">Prototyp öffnen</button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-start-screen-sharing" style="margin-top: 6px;"><i class="fa fa-circle-o-notch fa-spin hidden"></i> Screensharing starten</button>
                <button type="button" class="btn btn-success btn-block btn-shadow disabled hidden" id="btn-stop-screen-sharing" style="margin-top: 6px;">Screensharing beenden</button>
                <button type="button" class="btn btn-success btn-block btn-shadow hidden" id="btn-done-exploration" style="margin-top: 6px;"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></button>
            </div>

            <div class="" id="observations">
                <h3><?php echo $lang->observations ?></h3>
                <div class="alert-space alert-no-phase-data"></div>
                <div class="question-container"></div>
            </div>
        </div>
    </div>

    <div id="explorationItem">
        <div id="search-for"><span class="address"></span> <span class="text"></span></div>
        <div id="transition-scenes" class="root"></div>
        <div style="margin-top: 10px">
            <button class="btn btn-block btn-success btn-shadow disabled" id="btn-next-trigger" name="btn-success">Nächste Funktion &rarr;</button>
            <button class="btn btn-block btn-success btn-shadow disabled hidden" id="btn-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div id="explorationItem-ask">
        <div id="search-for"><span class="address"></span> <span class="text"></span></div>
        <div id="transition-scenes" class="root"></div>
        <div style="margin-top: 10px">
            <button class="btn btn-block btn-success btn-shadow disabled" id="btn-request-gestures" name="btn-success">Favorisierte Geste(n) erfragen</span></button>
            <button class="btn btn-block btn-success btn-shadow disabled hidden" id="btn-next-trigger" name="btn-success">Nächste Funktion &rarr;</button>
            <button class="btn btn-block btn-success btn-shadow disabled hidden" id="btn-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div id="explorationItem-trigger">
        <div id="search-for"><span class="address"></span> <span class="text"></span></div>
        <div id="transition-scenes" class="root"></div>
        <div style="margin-top: 10px">
            <button class="btn btn-block btn-success btn-shadow disabled" id="btn-next-gesture" name="btn-success">Nächste Geste &rarr;</button>
            <button class="btn btn-block btn-success btn-shadow disabled hidden" id="btn-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div id="explorationItem-trigger-ask">
        <div id="search-for"><span class="address"></span> <span class="text"></span></div>
        <div id="transition-scenes" class="root"></div>
        <div style="margin-top: 10px">
            <button class="btn btn-block btn-success btn-shadow disabled" id="btn-request-trigger" name="btn-success">Favorisierte Funktion(en) erfragen</span></button>
            <button class="btn btn-block btn-success btn-shadow disabled hidden" id="btn-next-gesture" name="btn-success">Nächste Geste &rarr;</button>
            <button class="btn btn-block btn-success btn-shadow disabled hidden" id="btn-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>



    <div id="trigger-catalog-thumbnail" class="text"></div>

    <div id="scenes-catalog-thumbnail">
        <div id="info-pidoco" class="hidden" style="float: left;">
            <span class="label label-default"><i class="fa fa-link"></i> <span class="label-text"></span></span>
            <span class="text"></span>
        </div>
        <div id="info-web" class="hidden" style="float: left;">
            <span class="label label-default"><i class="fa fa-link"></i> <span class="label-text"></span></span>
            <span class="text"></span>
        </div>
        <div id="info-image" class="hidden" style="float: left;">
            <span class="label label-default"><i class="fa fa-image"></i> <span class="label-text"></span></span>
            <span class="text"></span>
        </div>
        <div id="info-videoEmbed" class="hidden" style="float: left;">
            <span class="label label-default"><i class="fa fa-film"></i> <span class="label-text"></span></span>
            <span class="text"></span>
        </div>
        <div style="float: left; margin-left: 10px;">
            <button type="button" class="btn btn-default btn-xs" id="btn-preview-scene"><i class="fa fa-eye"></i> <span class="btn-text">Zustands-Vorschau</span></button>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div id="interactive-scenes-catalog-thumbnail" style="margin-top: 8px">
        <div class="btn-group hidden" id="info-pidoco">
            <!--<button class="btn btn-default btn-reset-scene disabled"><i class="fa fa-refresh"></i></button>-->
            <button class="btn btn-default btn-trigger-scene disabled">
                <span class="badge"><i class="fa fa-link"></i> <?php echo $lang->sceneTypes->pidoco ?></span> 
                <span class="btn-text" style="margin-left: 5px"></span>
            </button>
        </div>             
        <div class="btn-group hidden" id="info-web">
            <!--<button class="btn btn-default btn-reset-scene disabled"><i class="fa fa-refresh"></i></button>-->
            <button class="btn btn-default btn-trigger-scene disabled">
                <span class="badge"><i class="fa fa-link" style=""></i> <?php echo $lang->sceneTypes->web ?></span> 
                <span class="btn-text" style="margin-left: 5px"></span>
            </button>
        </div>
        <div class="btn-group hidden" id="info-image">
            <!--<button class="btn btn-default btn-reset-scene disabled"><i class="fa fa-refresh"></i></button>-->
            <button class="btn btn-default btn-trigger-scene disabled">
                <span class="badge"><i class="fa fa-image"></i> <?php echo $lang->sceneTypes->image ?></span> 
                <span class="btn-text" style="margin-left: 5px"></span>
            </button>
        </div>
        <div class="btn-group hidden" id="info-videoEmbed">
            <!--<button class="btn btn-default btn-reset-scene disabled"><i class="fa fa-refresh"></i></button>-->
            <button class="btn btn-default btn-trigger-scene disabled">
                <span class="badge"><i class="fa fa-film"></i> <?php echo $lang->sceneTypes->videoEmbed ?></span> 
                <span class="btn-text" style="margin-left: 5px"></span>
            </button>
        </div>
        <div class="scene-description hidden text" style="margin-bottom: 10px">
            test test
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
    <div class="container root" id="no-phase-data" style="margin-top: 80px;">
        <div class="alert-space alert-no-phase-data"></div>
    </div>


    <!-- rtc preview -->
    <div id="tester-web-rtc-placeholder" class="web-rtc-placeholder" style="width: 100%;">
        <img src="img/web-rtc-placeholder.jpg" style="width: 100%; height: auto;" />
    </div>

    <!-- main formats -->
    <div class="root" id="letterOfAcceptance" style="margin-top: 80px;"></div>

    <div id="letterOfAcceptance-moderated">
        <div class="col-md-5" id="column-left" style="margin-bottom: 15px;">
        </div>

        <div class="col-md-7" id="column-right" style="margin-bottom: 60px">
            <h3 class="headline" style="margin: 0" >Einverständniserklärung</h3>
            <hr>
            <div class="letter-text text"></div>
            <hr>
            <div>
                <button type="button" class="btn btn-success btn-shadow" id="letter-agreed">Ich bin einverstanden</button>
                <button type="button" class="btn btn-danger btn-shadow pull-right" id="letter-decline">Ich bin nicht einverstanden</button>
            </div>
        </div>
    </div>


    <div class="container" id="letterOfAcceptance-unmoderated">
        <h3 class="headline" style="margin: 0" >Einverständniserklärung</h3>
        <hr>
        <div class="letter-text"></div>
        <hr>
        <div>
            <button type="button" class="btn btn-success btn-shadow" id="letter-agreed">Ich bin einverstanden</button>
            <button type="button" class="btn btn-danger btn-shadow pull-right" id="letter-decline">Ich bin nicht einverstanden</button>
        </div>
    </div>


    <div class="root" id="questionnaire" style="margin-top: 80px;"></div>

    <div id="questionnaire-moderated">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right" style="margin-bottom: 80px;">
            <h3 class="headline" style="margin: 0"><?php echo $lang->questionnaire ?></h3>
            <hr>
            <div class="question-container"></div>
            <hr>
            <button class="next-step btn btn-success pull-right" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div class="container" id="questionnaire-unmoderated">
        <h3 class="headline" style="margin: 0" >Fragebogen</h3>
        <hr>
        <div class="question-container"></div>
        <hr>
        <button class="next-step btn btn-success pull-right" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
    </div>


    <!-- SUS container & item -->
    <div class="root" id="sus" style="margin-top: 80px;"></div>

    <div id="sus-moderated">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right" style="margin-bottom: 80px;">
            <h3 class="headline" style="margin: 0">Fragebogen zum System</h3>
            <hr>
            <div class="question-container"></div>
            <hr>
            <button class="next-step btn btn-success pull-right" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div class="container" id="sus-unmoderated">
        <h3 class="headline" style="margin: 0">Fragebogen zum System</h3>
        <hr>
        <div class="question-container"></div>
        <hr>
        <button class="next-step btn btn-success pull-right" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
    </div>

    <!-- GUS container & item -->
    <div class="root" id="gus" style="margin-top: 80px;"></div>

    <div id="gus-moderated">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right" style="margin-bottom: 80px;">
            <h3 class="headline" style="margin: 0" >Fragebogen zur Geste</h3>
            <div class="row">
                <div class="col-sm-6 right" style="margin-bottom: 10px;">
                    <div id="gesture"><span class="address"></span> <span class="text"></span></div>
                    <div id="trigger"><span class="address"></span> <span class="text"></span></div>
                    <div id="feedback"><span class="address"></span> <span class="text"></span></div>
                </div>
                <div class="col-sm-6 left" id="gesturePreview">
                    <div class="previewGesture autoplay mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
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
            <button class="next-step btn btn-success pull-right" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div class="container" id="gus-unmoderated">
        <h3 class="headline" style="margin: 0" >Fragebogen zur Geste</h3>
        <div class="row">
            <div class="col-sm-6 right" style="margin-bottom: 10px;">
                <div id="gesture"><span class="address"></span> <span class="text"></span></div>
                <div id="trigger"><span class="address"></span> <span class="text"></span></div>
                <div id="feedback"><span class="address"></span> <span class="text"></span></div>
            </div>
            <div class="col-sm-6 left" id="gesturePreview">
                <div class="previewGesture autoplay mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
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
        <button class="next-step btn btn-success pull-right" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
    </div>


    <!-- gesture questionnaire container & item -->
    <div class="root" id="questionnaireGestures" style="margin-top: 80px;"></div>

    <div id="questionnaireGestures-moderated">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right" style="margin-bottom: 80px;">
            <h3 class="headline" style="margin: 0" >Fragebogen zu den Gesten</h3>
            <hr>
            <div class="question-container"></div>
            <hr>
            <button class="next-step btn btn-success pull-right" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div class="container" id="questionnaireGestures-unmoderated">
        <h3 class="headline" style="margin: 0" >Fragebogen zu den Gesten</h3>
        <hr>
        <div class="question-container"></div>
        <hr>
        <button class="next-step btn btn-success pull-right" id="btn-next-step"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
    </div>

    <!-- gesture training container -->
    <!--    <div class="root" id="gestureTraining" style="margin-top: 80px;">
            <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
            <div class="row">
            <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
            <div class="col-md-8" id="column-right" style="margin-bottom: 80px;">
                <div id="general">
                    <h3 class="headline" style="margin: 0"></h3>
                    <div class="description"></div>
                    <hr>
                </div>
                <div class="alert-space alert-please-wait"></div>
                <div class="row" id="trainingContainer"></div>
            </div>
            </div>
        </div>-->

    <div class="root" id="gestureTraining" style="width: 100%; margin-top: 54px">

        <div id="scene-container" class="text-center" style="position: fixed; top:-55px; width: 100%;" allowtransparency></div>

        <div id="fixed-rtc-preview" class="hidden rtc-shadow" style="position: fixed; width: 300px; top: 5px; left: 10px; pointer-events: none; opacity: 0.8"></div>

        <div class="" style="margin-top: 55px; padding: 20px">
            <div class="alert-space alert-please-wait"></div>
        </div>
    </div>

    <!--    <div id="trainingItemModerated">
            <div class="col-sm-6" style="margin-bottom: 10px;">
                <div>
                <div id="title"><span class="address"></span> <span class="text"></span></div>
                <div id="repeats"><span class="address"></span> <span class="text"></span></div>
                <div id="trigger"><span class="address"></span> <span class="text"></span></div>
                <div id="feedback"><span class="address"></span> <span class="text"></span></div>
                </div>
            </div>
            <div class="col-sm-6" style="margin-bottom: 20px;">
                <div class="previewGesture autoplay embed-responsive embed-responsive-4by3"></div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                    </div>
                </div>
            </div>
        </div>-->

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
                <div class="previewGesture autoplay embed-responsive embed-responsive-4by3" style="margin:auto;"></div>
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
                <button class="btn btn-block btn-success btn-shadow" id="start-training" name="btn-success"><span class="btn-text">Jetzt Starten</span></button>
                <button class="btn btn-block btn-success btn-shadow hidden" id="start-single-training" name="btn-success"><span class="btn-text">Gesten-Training beginnen</span></button>
                <button class="btn btn-block btn-info btn-shadow hidden" id="repeat-training" name="btn-success"><span class="btn-text">Geste nochmal ausführen</span></button>
                <button class="btn btn-block btn-success btn-shadow hidden" id="next-gesture" name="btn-success"><span class="btn-text">Nächste Geste</span> <span aria-hidden="true">&rarr;</span></button>
                <button class="btn btn-block btn-success btn-shadow hidden" id="training-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
            </div>
            <div class="progress progress-training hidden" style="border-radius: 10px">
                <div class="progress-bar progress-bar-training progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 100%"></div>
            </div>
        </div>
    </div>


    <!-- gesture slideshow container -->

    <div class="root" id="gestureSlideshow" style="margin-top: 80px;">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right" style="margin-bottom: 80px;">
            <div id="general">
                <h3 style="margin: 0" class="headline"></h3>
                <div class="description"></div>
                <hr>
            </div>
            <div id="restart" class="hidden">
                <h3 style="margin: 0" class="headline">Bitte noch einmal neu starten</h3>
                <hr>
            </div>
            <div class="alert-space alert-please-wait"></div>
            <div class="progress progress-slideshow hidden" style="border-radius: 10px;">
                <div class="progress-bar progress-bar-slideshow progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 100%"></div>
            </div>
            <div class="row" id="slideshowContainer"></div>
        </div>
    </div>


    <!-- moderated gesture slideshow items -->

    <div id="gestureSlideshowOverviewItemModerated" class="col-xs-6 col-sm-4 col-md-6 col-lg-4 root">
        <div class="previewGesture mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
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
        <div class="previewGesture mousePlayable btn-shadow embed-responsive embed-responsive-4by3"></div>
        <div class="text-center gestureControls">
            <div class="btn-group">
                <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
            </div>
        </div>
    </div>

    <div id="gestureSlideshowItemUnmoderated" class="text-center col-xs-12">
        <button class="btn btn-block btn-success btn-shadow hidden" id="startSlideshow" name="btn-success">Jetzt Starten</button>

        <div class="triggerContainer hidden">
            <div class="trigger-title" style="font-size: 30pt; color: #303030; font-weight: bold; line-height: 1.3em;"></div>
        </div>
    </div>


    <!-- trigger slideshow container -->

    <div class="root" id="triggerSlideshow" style="margin-top: 80px;"></div>

    <div id="triggerSlideshow-moderated">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right">
            <div id="general">
                <h3 style="margin: 0"  class="headline"></h3>
                <div class="description"></div>
                <hr>
            </div>
            <div class="alert-space alert-please-wait"></div>
            <div class="progress progress-slideshow hidden" style="border-radius: 10px;">
                <div class="progress-bar progress-bar-slideshow progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 100%"></div>
            </div>
            <div class="row hidden" id="slideshowContainer"></div>
            <button class="btn btn-block btn-success btn-shadow" id="startSlideshow" name="btn-success">Jetzt Starten</button>
        </div>
    </div>

    <div class="container" id="triggerSlideshow-unmoderated">
        <div id="general">
            <h3 style="margin: 0"  class="headline"></h3>
            <div class="description"></div>
            <hr>
        </div>
        <div class="alert-space alert-please-wait"></div>
        <div class="progress progress-slideshow hidden" style="border-radius: 10px;">
            <div class="progress-bar progress-bar-slideshow progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 100%"></div>
        </div>
        <div class="row hidden" id="slideshowContainer"></div>
        <button class="btn btn-block btn-success btn-shadow" id="startSlideshow" name="btn-success">Jetzt Starten</button>
    </div>


    <!-- unmoderated trigger slideshow items -->

    <div id="triggerSlideshowItemUnmoderated">
        <div class="col-sm-5 text-center" style="margin-bottom: 15px;" id="gesturePreview">
            <div class="previewGesture autoplay embed-responsive embed-responsive-4by3"></div>
            <div class="text-center gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="question-container"></div>
            <button class="btn btn-block btn-success btn-shadow hidden" id="btn-next-slide" name="btn-success"><span class="btn-text">Nächste Geste</span> <span aria-hidden="true">&rarr;</span></button>
            <button class="btn btn-block btn-success btn-shadow hidden" id="btn-done-slide" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>        
    </div>


    <!-- exploration -->

    <div class="root" id="exploration" style="width: 100%; margin-top: 54px"></div>

    <div id="exploration-moderated">
        <div id="scene-container" class="text-center" style="position: fixed; top:-55px; width: 100%;" allowtransparency></div>
        <div class="text-shadow-black text-center" id="scene-description" style="position: absolute; top: 5px; left: 50%; margin-left: -225px; width: 450px; color:white; padding: 5px; background-color: rgba(0,0,0,.4); border-radius: 10px"><h4 style="color:white">Beschreibung</h4><p></p></div>

        <div id="fixed-rtc-preview" class="hidden rtc-shadow" style="position: fixed; width: 300px; top: 5px; left: 10px; pointer-events: none; opacity: 0.8"></div>

        <div class="" style="margin-top: 55px; padding: 20px">
            <div class="alert-space alert-please-wait"></div>
        </div>
    </div>

    <div id="exploration-unmoderated">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right" style="margin-bottom: 80px;">
            <div id="general">
                <h3 style="margin: 0"  class="headline"></h3>
                <div class="description"></div>
                <hr>
            </div>

            <div id="exploration-items-container"></div>
            <hr>
            <button class="btn btn-success btn-shadow pull-right" id="btn-exploration-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>




    <!-- identification container -->
    <div class="root" id="identification" style="width: 100%; margin-top: 54px"></div>


    <div class="" id="identificationModerated">
        <div id="scene-container" class="text-center" style="position: fixed; top:-55px; width: 100%;" allowtransparency></div>
        <div class="text-shadow-black text-center" id="scene-description" style="position: absolute; top: 5px; left: 50%; margin-left: -225px; width: 450px; color:white; padding: 5px; background-color: rgba(0,0,0,.4); border-radius: 10px"><h4 style="color:white">Beschreibung</h4><p></p></div>

        <div id="fixed-rtc-preview" class="hidden rtc-shadow" style="position: fixed; width: 300px; top: 5px; left: 10px; pointer-events: none; opacity: 0.8"></div>

        <div class="" style="margin-top: 55px; padding: 20px">
            <div class="alert-space alert-please-wait"></div>
        </div>
    </div>

    <div class="container" id="identificationUnmoderated" style="position: relative; top: 80px">
        <div class="row">
            <div class="col-xs-12" style="margin-bottom: 15px;" id="general">
                <div>
                    <h3 class="headline" style="margin: 0"></h3>
                    <div class="description" style="color: #303030"></div>
                    <hr>
                    <button class="btn btn-block btn-success btn-shadow" id="btn-start-identification" style="margin-top: 20px">Jetzt Starten</button>
                </div>
            </div>
            <div class="col-xs-12">
                <div id="identificationContainer" class="row"></div>
            </div>
        </div>

    </div>

    <div id="identificationItemUnmoderated">

        <div id="identification-content" class="hidden">
            <div id="trigger-identification">
                <div class="col-sm-5 col-md-6 text-center" style="margin-bottom: 15px">
                    <div class="previewGesture previewProgress autoplay mousePlayable btn-shadow embed-responsive embed-responsive-4by3" style="max-width: 500px;"></div>
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
                    <p class="text">Welche Funktion könnte auf diese Geste passen? Bitte tragen Sie Ihren Vorschlag bei Funktion ein und begründen Sie anschließend Ihre Entscheidung.</p>
                    <div class="form-group">
                        <label for="trigger-name">Funktion</label>
                        <input class="form-control" name="trigger-name" id="trigger-name">
                    </div>
                    <div class="form-group">
                        <label for="trigger-name">Begründung</label>
                        <textarea class="form-control" rows="5" id="trigger-justification"></textarea>
                    </div>
                    <!--<div style="margin-top: 20px;" id="next-controls" class="hidden">-->
                    <button type="button" class="btn btn-success btn-block btn-shadow" id="next-identification"><span class="btn-text"><span class="btn-text">Nächste Geste</span> <span aria-hidden="true">&rarr;</span></button>
                    <button type="button" class="btn btn-success btn-block btn-shadow" id="done-identification"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
                    <!--</div>-->

                </div>
            </div>

            <div id="gesture-identification">
                <div class="col-sm-6">
                    <div id="recorder-description" class="hidden"></div>
                </div>
                <div class="col-sm-6" style="margin-bottom: 80px">
                    <div style="width: 100%" class="text-center">
                        <h3 class="" id="trigger" style="margin: 0;"><span class="address"></span> <span id="text"></span></h3>
                    </div>
                    <div id="gesture-recorder-container" style="width: 450px; margin: auto; margin-top: 15px;"></div>
                    <div style="margin-top: 20px;" id="next-controls" class="hidden">
                        <button type="button" class="btn btn-success btn-block btn-shadow" id="next-identification"><span class="btn-text">Nächste Funktion</span> <span aria-hidden="true">&rarr;</span></button>
                        <button type="button" class="btn btn-success btn-block btn-shadow" id="done-identification"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="container text-center" id="identification-description" style="height: 100%; top: 40px">
        <div style="position: relative; top: 50%; -webkit-transform: translateY(-50%); -ms-transform: translateY(-50%); transform: translateY(-50%);">
            <h3 id="description-text" class="text-shadow-black" style="color: white; width: 400px; margin: auto">Test</h3>
            <button type="button" class="btn btn-info btn-shadow" id="btn-start-gesture-recording" style="margin-top: 15px"><span class="btn-text">Jetzt die Geste aufzeichnen</span></button>
        </div>
    </div>


    <!-- stress test container -->

    <div class="root" id="physicalStressTest" style="margin-top: 80px;">
        <div class="col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-md-8" id="column-right" style="margin-bottom: 80px;">
            <div id="general">
                <h3 class="headline" style="margin: 0"></h3>
                <div class="description"></div>
                <hr>
            </div>
            <div class="alert-space alert-please-wait"></div>

            <div class="row" id="stressTestContainer"></div>

            <button class="btn btn-block btn-success btn-shadow hidden" id="btn-start-stress-test" name="btn-success">Jetzt Starten</button>
        </div>
    </div>

    <div class="root" id="physicalStressTestModerated">
        <div class="col-sm-12 text-center" style="margin-bottom: 15px;">
            <div style="max-width: 400px; margin: 0 auto">
                <div class="previewGesture previewProgress autoplay embed-responsive embed-responsive-4by3" style=""></div>
                <div class="progress gesture-progress">
                    <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                </div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-sm-12 hidden" id="stress-test-questionnaire">
            <div id="questionnaire-heading" class="hidden">
                <h3 class="headline" style="margin: 0" >Bitte die Fragen beantworten</h3>
                <hr>
            </div>
            <div id="single-questions" class="hidden">
                <!--<h4 id="headline-single-questions" style="margin-top: 0">Einzel-Fragen</h4>-->

                <div id="single-joint-selection" class="hidden">
                    <div class="panel panel-default" id="human-body-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question text">Welche Teile des Körpers wurden <u>GERADE EBEN</u> besonders beansprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                            <div class="select-joints-humand-body" id="human-body" style="max-width: 350px; width:350px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_body.svg">
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default" id="hand-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question text">Welche Teile der Hand oder Hände wurden <u>GERADE EBEN</u> besonders beansprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                            <div class="select-joints-humand-hand" id="human-hand" style="max-width: 350px; width:350px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_hand.svg">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="question-container"></div>
            </div>

            <div id="sequence-questions" class="hidden" style="margin-top: 30px">
                <!--<h4 id="headline-sequence-questions">Sequenz-Fragen</h4>-->

                <div id="sequence-joint-selection" class="hidden">
                    <div class="panel panel-default" id="human-body-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question text">Welche Teile des Körpers wurden <u>INSGESAMT</u> besonders beansprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                            <div class="select-joints-humand-body" id="human-body" style="max-width: 350px; width:350px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_body.svg">
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default" id="hand-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question text">Welche Teile der Hand oder Hände wurden <u>INSGESAMT</u> besonders beansprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                            <div class="select-joints-humand-hand" id="human-hand" style="max-width: 350px; width:350px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_hand.svg">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="question-container"></div>


            </div>

            <hr>

            <button class="btn btn-block btn-success btn-shadow" id="btn-done-questionnaire" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
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

        <div class="col-sm-12 text-center" style="margin-bottom: 15px;">
            <div class="previewGesture previewProgress autoplay embed-responsive embed-responsive-4by3" style="max-width: 400px"></div>
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

        <div class="col-sm-12 hidden" id="stress-test-questionnaire">
            <div id="single-questions" class="hidden">
                <!--<h4 id="headline-single-questions" style="margin-top: 0">Einzel-Fragen</h4>-->

                <div id="single-joint-selection" class="hidden">
                    <div class="panel panel-default" id="human-body-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question text">Welche Teile des Körpers wurden <u>GERADE EBEN</u> besonders beansprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                            <div class="select-joints-humand-body" id="human-body" style="width: 350px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_body.svg">
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default" id="hand-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question text">Welche Teile der Hand oder Hände wurden <u>GERADE EBEN</u> besonders beansprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                            <div class="select-joints-humand-hand" id="human-hand" style="width: 350px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_hand.svg">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="question-container"></div>
            </div>

            <div id="sequence-questions" class="hidden" style="margin-top: 30px">
                <!--<h4 id="headline-sequence-questions">Sequenz-Fragen</h4>-->

                <div id="sequence-joint-selection" class="hidden">
                    <div class="panel panel-default" id="human-body-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question text">Welche Teile des Körpers wurden <u>INSGESAMT</u> besonders beansprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                            <div class="select-joints-humand-body" id="human-body" style="width: 350px; margin: auto">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_body.svg">
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default" id="hand-selection-rating" style="margin-bottom: 5px;">
                        <div class="panel-body">
                            <p class="question text">Welche Teile der Hand oder Hände wurden <u>INSGESAMT</u> besonders beansprucht? Klicken Sie auf die entsprechenden Stellen. Falls es Ihrer Ansicht nach keine Beanspruchung gab, markieren Sie nichts.</p>
                            <div class="select-joints-humand-hand" id="human-hand" style="width: 350px; margin: auto">
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
            <button class="btn btn-block btn-success btn-shadow" id="btn-gesture-done" name="btn-success">Geste wurde ausgeführt</button>
            <button class="btn btn-block btn-success btn-shadow hidden" id="btn-questionnaire-done" name="btn-success">Weiter</button>
            <button class="btn btn-block btn-success btn-shadow hidden" id="btn-next-gesture" name="btn-success"><span class="btn-text">Nächste Geste</span> <span aria-hidden="true">&rarr;</span></button>
            <button class="btn btn-block btn-success btn-shadow hidden" id="btn-done" name="btn-success"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>

    </div>


    <!-- scenario container -->
    <div class="root" id="scenario" style="">

        <!--<div style="">-->
        <div id="scene-container" class="text-center" style="position: fixed; top:-55px; width: 100%;" allowtransparency></div>
        <!--</div>-->

        <div id="fixed-rtc-preview" class="hidden rtc-shadow" style="position: fixed; width: 300px; top: 5px; left: 10px; pointer-events: none; opacity: 0.8"></div>

        <div class="" style="margin-top: 55px; padding: 20px">
            <div class="alert-space alert-please-wait"></div>
        </div>
    </div>

    <!--    <div id="scenario-panel-moderated">
            
        </div>-->

    <div id="scenario-panel-unmoderated" style="width: 100%">
        <div class="hidden" id="generalPanel" style="width: 100%"></div>

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
                <button type="button" class="btn btn-success" id="btn-done"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
                <button type="button" class="btn btn-info" id="btn-refresh-scene"><i class="glyphicon glyphicon-refresh"></i> <span class="btn-text">Neu laden</span></button>
                <button type="button" class="btn btn-info" id="btn-getting-help"><i class="fa fa-life-ring"></i> <span class="btn-text">Hilfe</span></button>
            </div>
            <div class="text-center" style="overflow: hidden">
                <button type="button" class="btn btn-success hidden" id="btn-perform-gesture"><span class="btn-text">Geste ausführen</span></button>
                <button type="button" class="btn btn-danger hidden" id="btn-stop-perform-gesture"><span class="btn-text">Geste ausgeführt</span></button>

            </div>
        </div>

        <div class="text-center hidden" id="start-controls">
            <button type="button" class="btn btn-success btn-block" id="start-scene"><span class="btn-text">Jetzt starten</span></button>
        </div>
    </div>    

    <iframe id="web" class="web-frame" src="" frameborder="0" style="width: 100%;" scrolling="yes"></iframe>

    <iframe id="pidoco" class="web-frame" src="" frameborder="0" style="width: 100%;" scrolling="yes"></iframe>

    <img id="image" style="height: 100%; width: 100%; object-fit: contain;">

    <!-- embed-responsive-16by9 or embed-responsive-4by3 -->
    <div id="videoEmbed" style="margin: auto">
        <div class="videoContainer embed-responsive"></div>
    </div>


    <!-- hints and hint contents-->
    <div id="feedback-hint" class="hint">
        <div class="hint-content">
            <button type="button" class="btn btn-info btn-block" id="btn-close-hint" style="margin-top: 20px"><span class="btn-text">Okay</span></button>
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

    <div class="root" id="thanks" style="margin-top: 80px;">
    </div>

    <div id="thanks-moderated">
        <div class="col-sm-5 col-md-4" id="column-left" style="margin-bottom: 15px;"></div>
        <div class="col-sm-7 col-md-8" id="column-right" style="margin-bottom: 80px;">
            <h3 class="headline" style="margin: 0">Danke für die Teilnahme</h3>
            <hr>
            <div class="row">
                <div class="col-sm-6" style="margin-bottom: 20px;">
                    <i class="fa fa-heart" style="font-size: 70pt; color: #ca3667"></i>
                    <div class="text" id="thanks-text"></div>
                </div>
                <div class="col-sm-6" id="upload-instructions" style="margin-bottom: 20px;">
                    <i class="fa fa-upload" aria-hidden="true" style="font-size: 70pt; color: #777"></i>
                    <div class="text">
                        Bitte warten! Die Daten werden nun gespeichert. Bitte nicht dieses Fenster, bzw. den Browser schließen oder neu laden. Wenn die Daten gespeichert sind, erscheint eine Meldung.
                    </div>
                    <div id="rtc-uploads-status" class="hidden text">
                        Bitte warten… Videodaten werden gespeichert.
                    </div>
                </div>
                <div class="col-sm-6 hidden" id="upload-retry" style="margin-bottom: 20px;">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size: 70pt; color: #d9534f"></i>
                    <div class="text">
                        <p>Es gab einen Fehler. Die Daten konnten nicht gespeichert werden. Bitte noch einmal versuchen.</p>
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
                <p class="text">Einfach den Link kopieren um die Studie zu teilen.</p>

                <!--            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-share" aria-hidden="true"></i> Weitersagen</div>
                                <input type="text" class="form-control readonly" >
                            </div>-->
                <hr>
            </div>

            <button type="button" class="btn btn-success btn-shadow pull-right hidden" id="btn-execution-done"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
        </div>
    </div>

    <div class="container" id="thanks-unmoderated">
        <h3 class="headline" style="margin: 0">Danke für die Teilnahme</h3>
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
            <p class="text">Einfach den Link kopieren um die Studie zu teilen.</p>

            <!--            <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-share" aria-hidden="true"></i> Weitersagen</div>
                            <input type="text" class="form-control readonly" >
                        </div>-->
            <hr>
        </div>

        <button type="button" class="btn btn-success btn-shadow pull-right hidden" id="btn-execution-done"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->done ?></span></button>
    </div>

</div>





















<div id="item-container-inputs" class="hidden">

    <div class="panel panel-default root" id="openQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div class="form-group">
                <label class="question text"></label> 
                <textarea class="form-control" id="openQuestionInput" rows="5" placeholder=""></textarea>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="openQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div class="form-group">
                <label class="question text"></label> 
                <textarea class="form-control" id="openQuestionInput" rows="5" placeholder=""></textarea>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="dichotomousQuestion" style="margin-bottom: 5px;">
        <div class="panel-body" id="panel-body">
            <div class="form-group">
                <label class="question text"></label> 
                <div class="switch root">
                    <div class="btn-group" style="margin: 0">
                        <button class="btn btn-default btn-radio" name="primary" id="yes">
                            <span id="icons" style="margin-right: 6px">
                                <i class="fa fa-circle-thin" id="normal"></i>
                                <i class="fa fa-circle hidden" id="over"></i>
                                <i class="fa fa-check-circle hidden" id="checked"></i>
                            </span>
                            <span class="option-text"><?php echo $lang->yes ?></span>
                        </button>
                    </div>
                    <div class="btn-group" style="margin: 0">
                        <button class="btn btn-default btn-radio" name="primary" id="no">
                            <span id="icons" style="margin-right: 6px">
                                <i class="fa fa-circle-thin" id="normal"></i>
                                <i class="fa fa-circle hidden" id="over"></i>
                                <i class="fa fa-check-circle hidden" id="checked"></i>
                            </span>
                            <span class="option-text"><?php echo $lang->no ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="dichotomousQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div class="form-group">
                <label class="question text"></label> 
                <div class="switch root">
                    <div class="btn-group" style="margin: 0">
                        <button class="btn btn-default btn-radio" name="primary" id="yes">
                            <span id="icons" style="margin-right: 6px">
                                <i class="fa fa-circle-thin" id="normal"></i>
                                <i class="fa fa-circle hidden" id="over"></i>
                                <i class="fa fa-check-circle hidden" id="checked"></i>
                            </span>
                            <span class="option-text"><?php echo $lang->yes ?></span>
                        </button>
                    </div>
                    <div class="btn-group" style="margin: 0">
                        <button class="btn btn-default btn-radio" name="primary" id="no">
                            <span id="icons" style="margin-right: 6px">
                                <i class="fa fa-circle-thin" id="normal"></i>
                                <i class="fa fa-circle hidden" id="over"></i>
                                <i class="fa fa-check-circle hidden" id="checked"></i>
                            </span>
                            <span class="option-text"><?php echo $lang->no ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="groupingQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <label class="question text"></label>
            <div class="option-container root"></div>
        </div>
    </div>

    <div class="panel panel-default root" id="groupingQuestionGUS" style="margin-bottom: 5px;">
        <div class="panel-body">
            <label class="question text"></label>
            <div class="option-container root"></div>
        </div>
    </div>
    <div class="panel panel-default root" id="groupingQuestionOptions" style="margin-bottom: 5px;">
        <div class="panel-body">
            <label class="question text"></label>
            <div class="option-container root"></div>
        </div>
    </div>

    <div class="panel panel-default root" id="counter" style="margin-bottom: 5px;">
        <div class="panel-body">
            <label class="question text"></label>
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

    <div class="panel panel-default root" id="susItem" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <label class="question text"></label>
                <div class="option-container root"></div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="gusSingle" style="margin-bottom: 5px;">
        <div class="panel-body">
            <div>
                <label class="question text"></label>
                <div class="option-container root"></div>
            </div>
        </div>
    </div>

    <div class="panel panel-default root" id="rating" style="margin-bottom: 5px;">
        <div class="panel-body">
            <label class="question text"></label>
            <div class="option-container root"></div>
        </div>
    </div>

    <div class="panel panel-default root" id="matrix" style="margin-bottom: 5px;">
        <div class="panel-body">
            <label class="question text"></label>
            <div class="option-container root"></div>
        </div>
    </div>

    <div id="rating-item">
        <div id="rating-header"></div>
        <div class="root scales-container" id="scales-container"></div>
    </div>

    <div class="panel panel-default root" id="sumQuestion" style="margin-bottom: 5px;">
        <div class="panel-body">
            <label class="question text"></label>
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
            <label class="question text"></label>
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
            <label class="question text"></label>
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
            <span class="option-text ellipsis"></span></button>
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
            <span class="option-text ellipsis"></span>
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

    <button type="button" class="btn btn-default btn-popover-gesture-preview" id="btn-show-gesture" style="border: none; height: 34px;"><i class="glyphicon glyphicon-eye-open"></i> <span class="btn-text">Geste zeigen</span></button>

</div>