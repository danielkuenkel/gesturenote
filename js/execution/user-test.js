UserTest.prototype.options = null;

function UserTest(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}



/*
 * moderator view rendering
 */

UserTest.prototype.renderModeratorView = function () {
    console.log('render moderator view:', SCENARIO.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    triggeredHelp, triggeredWoz = null;
    $(container).find('#general .headline').text(getCurrentPhase().title);
    $(container).find('#general #description').text(data.description);
    if (!currentWOZScene) {
        currentWOZScene = getSceneById(data.scene);
        currentScenarioTask = data.tasks[0];
    }

    if (!previewModeEnabled) {
        var currentPhase = getCurrentPhase();
        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
        tempData.annotations = new Array();
        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
    }

    var checkedScenes = checkSingleScene(data.tasks);

    //woz section
    Moderator.renderWOZ(source, container, data);

    // task assessment section
    Moderator.renderTaskAssessment(source, container, data);

    // help section
    Moderator.renderHelp(source, container, data);

    // observation section
    renderObservations(data, container);

    // controls handling
    if (scenarioPrototypeOpened) {
        Moderator.enableScenarioControls(container);
        $(container).find('#btn-open-prototype').remove();
        $(container).find('#btn-start-screen-sharing').removeClass('hidden');
        $(container).find('#btn-reset-scenes').removeClass('disabled');
    }

    $(container).find('#btn-open-prototype').unbind('click').bind('click', function (event) {
        event.preventDefault();
        scenarioPrototypeOpened = true;

        $(container).find('#btn-open-prototype').remove();
        $(container).find('#btn-start-screen-sharing').removeClass('hidden');
        $(container).find('#btn-reset-scenes').removeClass('disabled');

        openPrototypeScene(currentWOZScene, checkedScenes.single);
    });

    $(container).find('#btn-start-screen-sharing').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            var button = $(this);
            $(button).addClass('disabled');
            if (!previewModeEnabled && peerConnection) {
                $(container).find('#btn-start-screen-sharing').find('.fa-spin').removeClass('hidden');
                peerConnection.shareScreen(function (error) {
                    $(button).removeClass('disabled');
                    $(container).find('#btn-start-screen-sharing').find('.fa-spin').addClass('hidden');
                    console.error(error);
                }, function () {
                    peerConnection.startScreenRecording();
                    $(peerConnection).unbind(MESSAGE_SCREEN_SHARING_ESTABLISHED).bind(MESSAGE_SCREEN_SHARING_ESTABLISHED, function (event) {
                        event.preventDefault();
                        $(container).find('#btn-start-screen-sharing').find('.fa-spin').addClass('hidden');
                        enableControls();
                    });
                    peerConnection.sendMessage(MESSAGE_START_SCENARIO);
                });
            } else {
                if (getBrowser() !== BROWSER_FIREFOX) {

                }
                enableControls();
            }
        }
    });

    function enableControls() {
        scenarioStartTriggered = true;
        $(container).find('#btn-reset-scenes').click();
        $(container).find('#btn-start-screen-sharing').addClass('hidden');
        $(container).find('.btn-feedback-scene').removeClass('disabled');
        $(container).find('.help-container .disabled').removeClass('disabled');
        $(container).find('#assessment-controls-container .disabled').removeClass('disabled');

        Moderator.enableScenarioControls(container);
        wobble([container.find('#woz-controls')]);
        $(container).find('.btn-feedback-scene').removeClass('disabled');
    }

    $(container).find('#btn-stop-screen-sharing').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            screenSharingStopped = true;
            if (peerConnection) {
                peerConnection.stopShareScreen(true);
                peerConnection.sendMessage(MESSAGE_STOP_SCREEN_SHARING);
            }
            $(this).addClass('hidden');
            $(container).find('#btn-done-scenario').removeClass('hidden');
            clearAlerts($(container).find('#general'));
            scenarioPrototypeOpened = false;
            scenarioStartTriggered = false;
            if (prototypeWindow) {
                prototypeWindow.close();
                prototypeWindow = null;
            }
        }
    });

    if (checkedScenes.single === true && checkedScenes.pidoco && checkedScenes.pidoco === true) {
        $(container).find('#btn-reset-scenes').remove();
    }

    $(container).find('#btn-reset-scenes').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            currentWOZScene = getSceneById(data.scene);
            currentScenarioTask = data.tasks[0];
            currentScenarioTaskIndex = 0;
            Moderator.renderWOZ(source, container, data);
            Moderator.renderHelp(source, container, data);

            if (prototypeWindow) {
                if (!previewModeEnabled) {
                    getGMT(function (timestamp) {
                        var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                            tempData.annotations.push({action: ACTION_REFRESH_SCENE, time: timestamp});
                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, scene: currentWOZScene.id, time: timestamp});
                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_TASK, taskId: currentScenarioTask.id, time: timestamp});
                        setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                    });
                }

                openPrototypeScene(currentWOZScene, checkedScenes.single);
//                    prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: currentWOZScene}, 'https://gesturenote.de');
            }
        } else {
            $(document).scrollTop(0);
            wobble(container.find('#general'));
        }
    });

    if (screenSharingStopped === true) {
        $(container).find('#assessment-controls').addClass('hidden');
        $(container).find('#woz-controls').addClass('hidden');
        $(container).find('#help-controls').addClass('hidden');
        $(container).find('#general #description').addClass('hidden');
        $(container).find('#btn-open-prototype').addClass('hidden');
        $(container).find('#btn-done-scenario').removeClass('hidden');
    } else if (scenarioDone === true) {
        $(container).find('#general').removeClass('hidden');
        $(container).find('#assessment-controls').addClass('hidden');
        $(container).find('#woz-controls').addClass('hidden');
        $(container).find('#help-controls').addClass('hidden');
        $(container).find('#general #description').addClass('hidden');
        $(container).find('#btn-start-screen-sharing').addClass('hidden');
        $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
        appendAlert($(container).find('#general'), ALERT_NO_MORE_TASKS);
    } else if (scenarioPrototypeOpened && !scenarioStartTriggered) {
        $(container).find('#btn-reset-scenes').removeClass('disabled');
        $(container).find('#btn-open-prototype').addClass('hidden');
        $(container).find('#btn-stop-screen-sharing').addClass('hidden');
        $(container).find('#btn-start-screen-sharing').removeClass('hidden');
    } else if (scenarioPrototypeOpened && scenarioStartTriggered) {
        $(container).find('#btn-reset-scenes').removeClass('disabled');
        $(container).find('#btn-start-screen-sharing').addClass('hidden');
//            $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
        $(container).find('#assessment-controls-container .disabled').removeClass('disabled');
        $(container).find('#general #description').addClass('hidden');
    }

    $(container).find('#btn-done-scenario').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (peerConnection) {
            peerConnection.sendMessage(MESSAGE_NEXT_STEP);
        }
        nextStep();
    });

    if (!previewModeEnabled && peerConnection) {
        $(peerConnection).unbind(MESSAGE_HELP_CLOSED).bind(MESSAGE_HELP_CLOSED, function (event, payload) {
            $(container).find('.btn-info').removeClass('disabled');
        });
    }

    return container;
};



/*
 * tester view rendering
 */

UserTest.prototype.renderTesterView = function () {
    console.log('render tester view:', SCENARIO.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');



    return container;
};