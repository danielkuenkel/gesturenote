<div id="item-container-gesture-recorder" class="hidden">

    <div id="gesture-recorder">
        <div class="alert-space alert-web-rtc-not-supported"></div>

        <div class="recorder text-center" style="border-radius: 4px; max-width: 600px; margin: auto">
            <video autoplay id="recorder-video" style="width: 100%; height: auto; overflow: hidden; border-top-left-radius: 4px; border-top-right-radius: 4px"></video>

            <div class="gesture-recorder-controls">
                <div class="hidden" id="record-controls" style="margin-top: -8px">
                    <button class="btn btn-success btn-block btn-shadow hidden" id="btn-record" style="border-top-left-radius: 0px; border-top-right-radius: 0px;"><i class="glyphicon glyphicon-record" aria-hidden="true"></i> Aufzeichnung starten</button>
                    <button class="btn btn-danger btn-block btn-shadow hidden" id="btn-record-stop" style="border-top-left-radius: 0px; border-top-right-radius: 0px; margin-top: -8px"><i class="glyphicon glyphicon-stop" aria-hidden="true"></i> Aufzeichnung beenden</button>
                </div>
                <div class="hidden" id="playback-controls" style="margin-top: -8px">
                    <div class="progress" id="seek-bar" style="height: 8px; border-top-left-radius: 0px; border-radius: 0px">
                        <div class="progress-bar progress-bar-success" id="seek-bar-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%"></div>
                    </div>
                    <div class="progress" id="trim-bar" style="border-top-left-radius: 0px; border-top-right-radius: 0px; margin-top: -20px">
                        <div class="progress-bar progress-bar-danger" id="gesture-beginning" style="width: 100%; height: 100%"></div>
                        <div class="progress-bar progress-bar-info" id="gesture-execution" style="width: 0%; height: 100%">Geste</div>
                        <div class="progress-bar progress-bar-danger" id="gesture-ending" style="width: 0%; height: 100%"></div>
                    </div>
                    <div class="form-group">
                        <div class="btn-group">
                            <button class="btn btn-default btn-shadow" id="btn-play"><i class="glyphicon glyphicon-play" aria-hidden="true"></i></button>
                            <button class="btn btn-default btn-shadow" id="btn-pause"><i class="glyphicon glyphicon-pause" aria-hidden="true"></i></button>
                            <button class="btn btn-default btn-shadow" id="btn-stop"><i class="glyphicon glyphicon-stop" aria-hidden="true"></i></button>
                            <button class="btn btn-success btn-shadow" id="btn-mark-start"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i> Start</button>
                            <button class="btn btn-danger btn-shadow disabled" id="btn-mark-end">Ende <i class="fa fa-chevron-circle-down" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Bild-Export alle</span>
                            <input class="form-control item-input-text option-gesture show-dropdown readonly" type="text" value="150 Millisekunden"/>
                            <div class="input-group-btn dropup select" id="keyframeSelect" role="group">
                                <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="keyframe_150"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                    <li id="keyframe_80"><a href="#">80 Millisekunden</a></li>
                                    <li id="keyframe_100"><a href="#">100 Millisekunden</a></li>
                                    <li id="keyframe_150"><a href="#">150 Millisekunden</a></li>
                                    <li id="keyframe_200"><a href="#">200 Millisekunden</a></li>
                                    <li id="keyframe_300"><a href="#">300 Millisekunden</a></li>
                                    <li id="keyframe_400"><a href="#">400 Millisekunden</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="btn-group-vertical btn-block">
                            <button class="btn btn-block btn-default btn-shadow btn-repeat-recording"><i class="fa fa-refresh" aria-hidden="true"></i> Geste neu aufzeichnen</button>
                            <button class="btn btn-block btn-success btn-shadow disabled" id="btn-extract-gesture"><i class="glyphicon glyphicon-scissors"></i> Geste schneiden</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="preview-controls" class="hidden">
                <div class="alert-space alert-gesture-too-short"></div>
                <div class="previewGesture previewProgress autoplay" id="gesturePreview" style="max-width: 600px"></div>
                <div class="progress gesture-progress">
                    <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                </div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-shadow" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default btn-shadow" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default btn-shadow" id="btn-choose-preview-image"><i class="fa fa-bookmark" aria-hidden="true"></i> <span class="text">Vorschaubild wählen</span></button>

                    </div>
                </div>
                <div class="text-center btn-group" style="margin-top: 10px;">
                    <button type="button" class="btn btn-default btn-shadow" id="btn-repeat-trimming"><i class="glyphicon glyphicon-scissors"></i> Neu schneiden</button>
                    <button type="button" class="btn btn-default btn-repeat-recording btn-shadow"><i class="fa fa-refresh" aria-hidden="true"></i> Neue Aufzeichnung</button>
                </div>
            </div>

        </div>

        <div class="hidden" id="save-controls">
            <hr>
            <div>
                <div class="alert-space alert-missing-fields"></div>

                <div class="form-group" style="margin-top: 10px">
                    <label>Gesten-Name</label>
                    <input type="text" class="form-control" id="gestureName" required>
                </div>
                <div class="form-group">
                    <label>Gesten-Kontext</label>
                    <input type="text" class="form-control" placeholder="Wo soll die Geste eingesetzt werden?" id="gestureContext" required>
                </div>
                <div class="form-group">
                    <label>Gesten-Beschreibung</label>
                    <textarea class="form-control" id="gestureDescription" rows="3" maxlength="500" required></textarea>
                </div>

                <div class="form-group">
                    <label>Welche Teile des Körpers werden für die Geste genutzt?</label>
                    <div class="select-joints-humand-body" id="human-body" style="width: 450px; margin: auto">
                        <div id="joint-container" style="position: absolute"></div>
                        <img src="img/human_body.svg">
                    </div>
                </div>

                <div class="alert-space alert-general-error"></div>
                <button class="btn btn-block btn-success btn-shadow disabled" id="btn-save-gesture"><i class="fa fa-floppy-o" aria-hidden="true"></i> Geste speichern</button>
            </div>
        </div>

        <div class="hidden root" id="success-controls">
            <div class="alert-space alert-gesture-save-success"></div>
            <div class="alert-space alert-general-error"></div>

            <div class="previewGesture previewProgress previewProgress autoplay" style="max-width: 600px"></div>
            <div class="progress gesture-progress">
                <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <div class="text-center gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-shadow" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default btn-shadow" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                </div>
            </div>
            <div class="btn-group-vertical btn-block" style="margin-top: 10px">
                <button class="btn btn-danger btn-shadow" id="btn-delete-saved-gesture"><i class="fa fa-trash" aria-hidden="true"></i> Gespeicherte Geste löschen</button>
                <button class="btn btn-default btn-shadow" id="btn-record-new-gesture"><i class="fa fa-video-camera" aria-hidden="true"></i> Weitere Geste aufzeichnen</button>
            </div>
        </div>

        <div class="hidden root" id="delete-success-controls">
            <div class="alert-space alert-gesture-delete-success"></div>

            <div class="btn-group-vertical btn-block" style="margin-top: 10px">
                <button class="btn btn-default btn-shadow" id="btn-record-new-gesture"><i class="fa fa-video-camera" aria-hidden="true"></i> Geste aufzeichnen</button>
            </div>
        </div>
    </div>


    <div id="gesture-recorder-tester">
        <div class="alert-space alert-web-rtc-not-supported"></div>

        <div class="recorder text-center" style="border-radius: 5px; max-width: 500px; margin: auto">
            <video autoplay id="recorder-video" style="width: 100%; height: auto; overflow: hidden; border-top-left-radius: 4px; border-top-right-radius: 4px"></video>
            <div class="gesture-recorder-controls">
                <div class="hidden" id="record-controls" style="margin-top: -8px">
                    <button class="btn btn-success btn-block btn-shadow hidden" id="btn-record" style="border-top-left-radius: 0px; border-top-right-radius: 0px;"><i class="glyphicon glyphicon-record" aria-hidden="true"></i> Aufzeichnung starten</button>
                    <button class="btn btn-danger btn-block btn-shadow hidden" id="btn-record-stop" style="border-top-left-radius: 0px; border-top-right-radius: 0px; margin-top: -8px"><i class="glyphicon glyphicon-stop" aria-hidden="true"></i> Aufzeichnung beenden</button>
                </div>
                <div class="hidden" id="playback-controls" style="margin-top: -8px">
                    <div class="progress" id="seek-bar" style="height: 8px; border-top-left-radius: 0px; border-radius: 0px">
                        <div class="progress-bar progress-bar-success" id="seek-bar-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%"></div>
                    </div>
                    <div class="progress" id="trim-bar" style="border-top-left-radius: 0px; border-top-right-radius: 0px; margin-top: -20px">
                        <div class="progress-bar progress-bar-danger" id="gesture-beginning" style="width: 100%; height: 100%"></div>
                        <div class="progress-bar progress-bar-info" id="gesture-execution" style="width: 0%; height: 100%">Geste</div>
                        <div class="progress-bar progress-bar-danger" id="gesture-ending" style="width: 0%; height: 100%"></div>
                    </div>
                    <div class="form-group">
                        <div class="btn-group">
                            <button class="btn btn-default btn-shadow" id="btn-play"><i class="glyphicon glyphicon-play" aria-hidden="true"></i></button>
                            <button class="btn btn-default btn-shadow" id="btn-pause"><i class="glyphicon glyphicon-pause" aria-hidden="true"></i></button>
                            <button class="btn btn-default btn-shadow" id="btn-stop"><i class="glyphicon glyphicon-stop" aria-hidden="true"></i></button>
                            <button class="btn btn-success btn-shadow" id="btn-mark-start"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i> Start</button>
                            <button class="btn btn-danger disabled" id="btn-mark-end">Ende <i class="fa fa-chevron-circle-down" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Bild-Export alle</span>
                            <input class="form-control item-input-text option-gesture show-dropdown readonly" type="text" value="150 Millisekunden"/>
                            <div class="input-group-btn dropup select" id="keyframeSelect" role="group">
                                <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="keyframe_150"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                    <li id="keyframe_80"><a href="#">80 Millisekunden</a></li>
                                    <li id="keyframe_100"><a href="#">100 Millisekunden</a></li>
                                    <li id="keyframe_150"><a href="#">150 Millisekunden</a></li>
                                    <li id="keyframe_200"><a href="#">200 Millisekunden</a></li>
                                    <li id="keyframe_300"><a href="#">300 Millisekunden</a></li>
                                    <li id="keyframe_400"><a href="#">400 Millisekunden</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="btn-group-vertical btn-block">
                            <button class="btn btn-block btn-default btn-shadow btn-repeat-recording"><i class="fa fa-refresh" aria-hidden="true"></i> Geste neu aufzeichnen</button>
                            <button class="btn btn-block btn-success btn-shadow disabled" id="btn-extract-gesture"><i class="glyphicon glyphicon-scissors"></i> Geste schneiden</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="preview-controls" class="hidden">
                <div class="alert-space alert-gesture-too-short"></div>
                <div class="previewGesture  autoplay" id="gesturePreview" style="max-width: 600px"></div>
                <div class="progress gesture-progress">
                    <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                </div>
                <div class="text-center gestureControls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-shadow" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default btn-shadow" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default btn-shadow" id="btn-choose-preview-image"><i class="fa fa-bookmark" aria-hidden="true"></i> <span class="text">Vorschaubild wählen</span></button>

                    </div>
                </div>
                <div class="text-center btn-group" style="margin-top: 10px;">
                    <button type="button" class="btn btn-default btn-shadow" id="btn-repeat-trimming"><i class="glyphicon glyphicon-scissors"></i> Neu schneiden</button>
                    <button type="button" class="btn btn-default btn-shadow btn-repeat-recording"><i class="fa fa-refresh" aria-hidden="true"></i> Neue Aufzeichnung</button>
                </div>
            </div>

        </div>

        <div class="hidden" id="save-controls">
            <hr>
            <div>
                <div class="alert-space alert-missing-fields"></div>

                <div class="form-group" style="margin-top: 10px">
                    <label>Gesten-Name</label>
                    <input type="text" class="form-control" id="gestureName" required>
                </div>
                <div class="form-group">
                    <label>Gesten-Kontext</label>
                    <input type="text" class="form-control" placeholder="Wo soll die Geste eingesetzt werden?" id="gestureContext" required>
                </div>
                <div class="form-group">
                    <label>Gesten-Beschreibung</label>
                    <textarea class="form-control" id="gestureDescription" rows="3" maxlength="500" required></textarea>
                </div>

                <div class="form-group">
                    <label>Welche Teile des Körpers werden für die Geste genutzt?</label>
                    <div class="select-joints-humand-body" id="human-body" style="width: 450px; margin: auto">
                        <div id="joint-container" style="position: absolute"></div>
                        <img src="img/human_body.svg">
                    </div>
                </div>

                <div class="alert-space alert-general-error"></div>
                <button class="btn btn-block btn-success btn-shadow disabled" id="btn-save-gesture"><i class="fa fa-floppy-o" aria-hidden="true"></i> Geste speichern</button>
            </div>
        </div>

        <div class="hidden root" id="success-controls">
            <div class="alert-space alert-gesture-save-success"></div>
            <div class="alert-space alert-general-error"></div>

            <div class="previewGesture previewProgress autoplay" style="max-width: 600px"></div>
            <div class="progress gesture-progress">
                <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <div class="text-center gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-shadow" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default btn-shadow" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                    <button class="btn btn-danger btn-shadow" id="btn-delete-saved-gesture"><i class="fa fa-trash" aria-hidden="true"></i> Gespeicherte Geste löschen</button>
                </div>
            </div>
        </div>

        <div class="hidden root" id="delete-success-controls">
            <div class="alert-space alert-gesture-delete-success"></div>

            <div class="btn-group-vertical btn-block" style="margin-top: 10px">
                <button class="btn btn-default btn-shadow" id="btn-record-new-gesture"><i class="fa fa-video-camera" aria-hidden="true"></i> Geste aufzeichnen</button>
            </div>
        </div>
    </div>

    <div id="gesture-recorder-description">
    </div>

    <div id="stateRecord">
        <h3 style="margin: 0" id="headline">Eine Geste aufzeichnen</h3>
        <hr>
        <p class="text" id="instructions">
            Um eine Geste aufzuzeichnen …
        </p>
    </div>

    <div id="statePlayback">
        <h3 style="margin: 0" id="headline">Ansehen und Schneiden einer Geste</h3>
        <hr>
        <p class="text" id="instructions">
            Anleitung & Besonderheiten
        </p>
    </div>

    <div id="stateSave">
        <h3 style="margin: 0" id="headline">Beschreiben und Speichern einer Geste</h3>
        <hr>
        <p class="text" id="instructions">
            Anleitung & Besonderheiten
        </p>
    </div>

    <div id="stateSaveSuccess">
        <h3 style="margin: 0" id="headline">Gespeicherte Geste</h3>
        <hr>
        <p class="text" id="instructions">
            Anleitung & Besonderheiten
        </p>
    </div>

    <div id="stateDeleteSuccess">
        <h3 style="margin: 0" id="headline">Gelöschte Geste</h3>
        <hr>
        <p class="text" id="instructions">
            Anleitung & Besonderheiten
        </p>
    </div>

</div>