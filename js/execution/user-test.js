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
    currentClass.renderWOZ(source, container, data);

    // task assessment section
    currentClass.renderTaskAssessment(source, container, data);

    // help section
    currentClass.renderHelp(source, container, data);

    // observation section
    renderObservations(data, container);

    // controls handling
    if (scenarioPrototypeOpened) {
        currentClass.enableScenarioControls(container);
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

        currentClass.enableScenarioControls(container);
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
            currentClass.renderWOZ(source, container, data);
            currentClass.renderHelp(source, container, data);

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

UserTest.prototype.renderWOZ = function (source, container, data) {
    function checkTransitionScenes(scenesContainer) {

        var transitionsLength = $(scenesContainer).find('.btn-trigger-scene').length;
        var leftFeedbackButtons = $(scenesContainer).find('#transition-feedback-container').find('.btn-trigger-feedback').not('.btn-primary');
        if (leftFeedbackButtons.length === 1) {
            var feedbackButton = $(leftFeedbackButtons).first();
            $(feedbackButton).addClass('btn-primary');

            var transitionMode = $(feedbackButton).attr('data-transition-mode');
            var feedback = getFeedbackById($(feedbackButton).attr('id'));
            triggeredFeedback = {id: feedback.id, transitionMode: transitionMode};

            if (transitionMode === 'automatically') {
                var transitionTime = parseFloat($(feedbackButton).attr('data-transition-time'));
                var indicator = $(feedbackButton).find('#transition-indicator').removeClass('hidden');
                triggeredFeedback.transitionTime = transitionTime;

                TweenMax.from(indicator, transitionTime, {width: '0px', ease: Linear.easeNone, onComplete: function () {
                        $(feedbackButton).find('#waiting-indicator').removeClass('hidden');
                        if (previewModeEnabled) {
                            checkTransitionScenes(scenesContainer);
                        }
                        TweenMax.to(indicator, .4, {opacity: 0});
                    }});
            } else {
                $(feedbackButton).find('#waiting-indicator').removeClass('hidden');
            }

            if (!previewModeEnabled && peerConnection) {
                $(peerConnection).unbind(MESSAGE_FEEDBACK_HIDDEN).bind(MESSAGE_FEEDBACK_HIDDEN, function (event, payload) {
                    if (transitionMode === 'automatically') {
                        checkTransitionScenes(scenesContainer);
                    }
                    $(feedbackButton).find('#waiting-indicator').addClass('hidden');

                    getGMT(function (timestamp) {
                        var currentPhase = getCurrentPhase();
                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_HIDE_FEEDBACK, feeback: feedback, time: timestamp});
                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                    });
                });

                getGMT(function (timestamp) {
                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_SHOW_FEEDBACK, feeback: feedback, time: timestamp});
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                });

                peerConnection.sendMessage(MESSAGE_TRIGGER_FEEDBACK, {triggeredFeedback: triggeredFeedback});
            }

            if (transitionsLength > 0) {
                currentTransitionSceneIndex = 1;
                if (transitionsLength > 1) {
                    $(container).find('#btn-repeat-training').addClass('disabled');
                } else {
                    $(container).find('#btn-repeat-training').removeClass('disabled');
                }
            } else {
                $(container).find('#btn-repeat-training').addClass('disabled');
            }
            return false;
        }


        var transitionsLength = $(scenesContainer).find('.btn-trigger-scene').length;
        if (transitionsLength === 1) {
            // this scene has no follow scene, maybe a pidoco prototype
            if (currentWOZScene.type === SCENE_PIDOCO) {
                var gestureId = $(scenesContainer).closest('.row').find('.previewGesture').attr('id');
                sendGesture(gestureId);
            } else {
                // if scene has no follow scene and is not a pidoco prototype: delete items
                $(container).find('.woz-container').empty();
                appendAlert($(container).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
                currentClass.renderHelp(source, container, data);
            }
        } else if (transitionsLength > 2) {
            var leftSceneButtons = $(scenesContainer).find('#transition-scene-container').find('.btn-trigger-scene').not('.btn-primary');
            if (leftSceneButtons.length > 0) {
                var button = $(leftSceneButtons).first();
                currentWOZScene = getSceneById($(button).attr('id'));

                if (transitionsLength - 2 === leftSceneButtons.length) {
                    $(button).addClass('btn-primary');
                    if (prototypeWindow && prototypeWindow.closed !== true) {
                        if (!previewModeEnabled) {
                            getGMT(function (timestamp) {
                                var currentPhase = getCurrentPhase();
                                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, scene: currentWOZScene.id, time: timestamp});
                                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                            });
                        }
                        prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: currentWOZScene}, 'https://gesturenote.de');
                    }
                }

                var transitionMode = $(button).attr('data-transition-mode');
                if (transitionMode === 'automatically') {
                    var transitionTime = parseFloat($(button).attr('data-transition-time'));
                    var indicator = $(button).find('#transition-indicator').removeClass('hidden');
                    TweenMax.from(indicator, transitionTime, {width: '0px', ease: Linear.easeNone, onComplete: function () {
                            checkTransitionScenes(scenesContainer);
                            TweenMax.to(indicator, .4, {opacity: 0});
                        }});
                }
            } else {
                currentWOZScene = getSceneById($(scenesContainer).find('#follow-scene-container').find('.btn-trigger-scene').attr('id'));
                renderFollowScene(scenesContainer);
            }
        } else if (transitionsLength === 2) {
            currentWOZScene = getSceneById($(scenesContainer).find('#follow-scene-container').find('.btn-trigger-scene').attr('id'));
            renderFollowScene(scenesContainer);
        }
    }

    function renderFollowScene(scenesContainer) {
        $(scenesContainer).find('#follow-scene-container').find('.btn-trigger-scene').addClass('btn-primary');

        currentClass.renderWOZ(source, container, data);
        currentClass.renderHelp(source, container, data);
        console.log('renderFollowScene:', currentWOZScene, prototypeWindow);
        if (prototypeWindow && prototypeWindow.closed !== true) {
            if (!previewModeEnabled) {
                getGMT(function (timestamp) {
                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, scene: currentWOZScene.id, time: timestamp});
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                });
            }
            prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: currentWOZScene}, 'https://gesturenote.de');
        }
    }

    if (data.tasks && data.tasks.length > 0) {
        var checkedScenes = checkSingleScene(data.tasks);
        $(container).find('#assessment-controls #task').text(currentScenarioTask.task);
        $(container).find('#assessment-controls .headline').text(translation.task + ' ' + (currentScenarioTaskIndex + 1) + ' ' + translation.of + ' ' + data.tasks.length)

        if (currentScenarioTask.woz) {
            var wozData = getWOZItemsForSceneId(currentScenarioTask.woz, currentWOZScene.id);
            console.log('woz data', wozData, currentWOZScene);
            removeAlert($(container).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
            $(container).find('.woz-container').empty();
            if (wozData && wozData.length > 0) {

                for (var i = 0; i < wozData.length; i++) {
                    var transitionScenes = wozData[i].transitionScenes;
                    var item = $(source).find('#wozItemWithScenes').clone().removeAttr('id');
                    $(container).find('.woz-container').append(item);

                    if (transitionScenes.length > 1) {
                        var startItem = getWOZTransitionItem(source, transitionScenes[0], false, true);
                        $(item).find('#start-scene-container').append(startItem);
                        TweenMax.from(startItem, .3, {y: '-10px', opacity: 0});

                        $(item).find('#follow-scene-header').removeClass('hidden');
                        $(item).find('#follow-scene-container').removeClass('hidden');
                        var followItem = getWOZTransitionItem(source, transitionScenes[transitionScenes.length - 1], true, false);
                        $(item).find('#follow-scene-container').append(followItem);

                        if (transitionScenes.length > 2) {
                            $(item).find('#transition-scene-header').removeClass('hidden');
                            $(item).find('#transition-scene-container').removeClass('hidden');
                            for (var j = 1; j < transitionScenes.length - 1; j++) {
                                var itemBetween = getWOZTransitionItem(source, transitionScenes[j], true, false);
                                $(item).find('#transition-scene-container').append(itemBetween);
                                if (j < transitionScenes.length - 2) {
                                    $(item).find('#transition-scene-container').append(document.createElement('br'));
                                }
                                TweenMax.from(itemBetween, .3, {y: '-10px', opacity: 0, delay: (i + 1) * .1});
                            }
                            TweenMax.from(followItem, .3, {y: '-10px', opacity: 0, delay: (transitionScenes.length * .1) - .1});
                        } else {
                            TweenMax.from(followItem, .3, {y: '-10px', opacity: 0, delay: .1});
                        }
                    } else {
                        // render only gesture item
                        var startItem = getWOZTransitionItem(source, transitionScenes[0], false, true);
                        $(item).find('#start-scene-container').append(startItem);
                        TweenMax.from(startItem, .3, {y: '-10px', opacity: 0});
                    }

                    if (wozData[i].feedbackId !== 'none') {
                        $(item).find('#transition-feedback-header, #transition-feedback-container').removeClass('hidden');
                        var feedback = getFeedbackById(wozData[i].feedbackId);
                        var feedbackButton = getWOZTransitionFeedbackItem(source, feedback, wozData[i].feedbackTransitionMode, wozData[i].feedbackTransitionTime, !scenarioStartTriggered && !scenarioPrototypeOpened, false);
                        $(item).find('#transition-feedback-container').empty().append(feedbackButton);
                        TweenMax.from(feedbackButton, .3, {y: '-10px', opacity: 0, delay: .1});
                    }

                    var gesture = getGestureById(wozData[i].gestureId);
                    if (gesture) {
                        renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage, null);
                        $(item).find('.previewGesture').attr('id', gesture.id);
                        currentClass.checkGestureUI(item, wozData[i]);

                        if (gesture.type && gesture.interactionType) {
                            item.find('.symbol-gesture-execution').addClass(gesture.type);
                            item.find('.symbol-container-gesture-execution').attr('data-content', translation.gestureTypes[gesture.type + 's'] + ' ' + translation.gestureType);
                            item.find('.text-gesture-execution').text(translation.gestureTypes[gesture.type + 'Short']);
                            item.find('.symbol-gesture-interaction').addClass(gesture.interactionType);
                            item.find('.symbol-container-gesture-interaction').attr('data-content', translation.gestureInteractionTypes[gesture.interactionType + 's'] + ' ' + translation.gestureInteraction);
                            item.find('.text-gesture-interaction').text(translation.gestureInteractionTypes[gesture.interactionType + 'Short']);
                        } else {
                            item.find('.gesture-info-symbols').addClass('hidden');
                        }
                        initPopover();

                        TweenMax.from($(item).find('.previewGesture').closest('.panel'), .3, {scaleX: 0, scaleY: 0, opacity: 0});



                    }

                    item.find('#btn-trigger-woz, .btn-trigger-woz').unbind('click').bind('click', {wozData: wozData[i]}, function (event) {
                        event.preventDefault();
                        var button = $(this);
                        if (!$(button).hasClass('disabled')) {
                            $(button).addClass('disabled');
                            checkTransitionScenes($(button).closest('.root').find('#transition-scenes'));
                        } else {
                            if (!scenarioStartTriggered) {
                                $(document).scrollTop(0);
                                wobble(container.find('#general'));
                            }
                        }
                    });

                    item.find('.btn-trigger-scene, .btn-trigger-feedback').unbind('click').bind('click', {wozData: wozData[i]}, function (event) {
                        event.preventDefault();
                        if (!$(this).hasClass('disabled') && !$(this).hasClass('btn-primary')) {
                            var button = $(this);
                            $(button).closest('.root').find('#btn-trigger-woz').addClass('disabled');
                            checkTransitionScenes($(button).closest('.root').find('#transition-scenes'));
                        }
                    });

                    if (scenarioPrototypeOpened) {
                        $(item).find('.disabled').removeClass('disabled');
                    }
                }
            } else {
                appendAlert($(container).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
            }
        }
    } else {
        appendAlert($(container).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
    }
};

UserTest.prototype.renderHelp = function (source, container, data) {
    var helpData = filterHelpDataForCurrentTask(data.help, currentScenarioTask.id, currentWOZScene.id);
    $(container).find('.help-container').empty();
    removeAlert($(container).find('#help-controls'), ALERT_NO_PHASE_DATA);

    if (helpData && helpData.length > 0) {

        for (var i = 0; i < helpData.length; i++) {
            var item = $(source).find('#helpItem').clone();
            item.removeAttr('id');
            item.find('.help-title').text((i + 1) + ". " + helpData[i].option);
            $(container).find('.help-container').append(item);
            item.find('#offer-help').unbind('click').bind('click', {helpData: helpData[i]}, function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    triggeredHelp = event.data.helpData;
                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_TRIGGER_HELP, {help: triggeredHelp});
                        $(container).find('.btn-info').addClass('disabled');

                        getGMT(function (timestamp) {
                            var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_REQUEST_HELP, time: timestamp});
                            setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                        });
                    }
                } else {
                    if (!scenarioStartTriggered) {
                        $(document).scrollTop(0);
                        wobble(container.find('#general'));
                    }
                }
            });
            if (helpData[i].useGestureHelp === true || helpData[i].useGestureHelp === 'true') {
                var gesture = getGestureById(helpData[i].gestureId);
                item.find('.btn-popover-gesture-preview').removeClass('hidden');
                item.find('.btn-popover-gesture-preview').attr('name', gesture.id);
            } else {
                item.find('.btn-popover-gesture-preview').remove();
            }

            if (scenarioPrototypeOpened && scenarioStartTriggered) {
                item.find('#offer-help').removeClass('disabled');
            }
        }
    } else {
        appendAlert($(container).find('#help-controls'), ALERT_NO_PHASE_DATA);
    }
};

UserTest.prototype.renderTaskAssessment = function (source, container, data) {
    if (!$.isEmptyObject(data.taskAssessments)) {
        for (var assessment in data.taskAssessments) {
            var assessmentButton = document.createElement('button');
            $(assessmentButton).attr('data-trigger', data.taskAssessments[assessment].trigger);
            $(assessmentButton).attr('data-assessment-id', assessment);
            $(assessmentButton).html("<span style='color: " + translation.annotationColors[data.taskAssessments[assessment].annotationColor].hex + "'>&#9679;</span> " + data.taskAssessments[assessment].title);
            $(assessmentButton).addClass('btn btn-default btn-shadow disabled btn-assessment');
            $(assessmentButton).css({marginRight: '6px', marginBottom: '6px'});
            $(container).find('#assessment-controls-container').append(assessmentButton);
        }

        function checkAssessment(trigger) {
            switch (trigger) {
                case 'nextTask':
                    if (currentScenarioTaskIndex < data.tasks.length - 1) {
                        currentScenarioTaskIndex++;
                        currentScenarioTask = data.tasks[currentScenarioTaskIndex];
//                            console.log(currentScenarioTask);
                        currentWOZScene = getSceneById(currentScenarioTask.woz[0].transitionScenes[0].sceneId);
                        currentClass.renderWOZ(source, container, data);
                        currentClass.renderHelp(source, container, data);
                    } else {
                        $(container).find('#general').removeClass('hidden');
                        $(container).find('#assessment-controls').addClass('hidden');
                        $(container).find('#woz-controls').addClass('hidden');
                        $(container).find('#help-controls').addClass('hidden');
                        appendAlert($(container).find('#general'), ALERT_NO_MORE_TASKS);
                        $(document).scrollTop(0);
                        scenarioDone = true;
                        $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
                    }
                    break;
                case 'nextStep':
                    $(container).find('#assessment-controls').addClass('hidden');
                    $(container).find('#woz-controls').addClass('hidden');
                    $(container).find('#help-controls').addClass('hidden');
                    appendAlert($(container).find('#general'), ALERT_NO_MORE_TASKS);
                    $(document).scrollTop(0);
                    scenarioDone = true;
                    break;
            }
        }

        $(container).find('#assessment-controls-container .btn-assessment').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                var trigger = $(this).attr('data-trigger');
                var assessmentId = $(this).attr('data-assessment-id');

                if (!previewModeEnabled) {
                    getGMT(function (timestamp) {
                        var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_ASSESSMENT, assessmentId: assessmentId, taskId: currentScenarioTask.id, time: timestamp});
                        checkAssessment(trigger);
                        if (scenarioDone === false) {
                            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_TASK, taskId: currentScenarioTask.id, time: timestamp});
                        }
                        setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                    });
                } else {
                    checkAssessment(trigger);
                }
            } else {
                $(document).scrollTop(0);
                wobble(container.find('#general'));
            }
        });
    } else {
        appendAlert($(container).find('#assessment-controls'), ALERT_NO_PHASE_DATA);
    }
};

UserTest.prototype.enableScenarioControls = function (container) {
    $(container).find('#general #description').closest('.read-aloud').remove();
    $(container).find('#general').addClass('hidden');

    var wozItems = $(container).find('.woz-container .disabled');
    wozItems.removeClass('disabled');

    var sliders = $(container).find('.woz-container #continuous-slider');
    $(sliders).slider('enable');

    var helpItems = $(container).find('.help-container .disabled');
    helpItems.removeClass('disabled');
};

UserTest.prototype.checkGestureUI = function (item, wozData) {
    var currentActiveBtn = $(item).find('.btn-primary').last();
    var gesture = getGestureById($(item).find('.previewGesture').attr('id'));
    console.log('gesture', gesture, wozData, currentActiveBtn, $(currentActiveBtn).attr('data-transition-scene-id'));
    if (gesture) {

        // find current active transition id for this woz element
        var activeTransitionScene = null;
        for (var i = 0; i < wozData.transitionScenes.length; i++) {
            if (parseInt(wozData.transitionScenes[i].sceneId) === parseInt($(currentActiveBtn).attr('data-transition-scene-id'))) {
                activeTransitionScene = wozData.transitionScenes[i];
            }
        }

        console.log('activeTransitionScene', activeTransitionScene);
        var scene = getSceneById(activeTransitionScene.sceneId);

        if (activeTransitionScene.useEventBus === 'yes' && scene.type === SCENE_PIDOCO) {

            Moderator.initMousePositionFunctionalities();
            console.log('show event bus specific controls');
//            var sceneType = $(currentActiveBtn).attr('data-scene-type');
            console.log('sceneType', scene.type);

            if (activeTransitionScene.continuousValueType === 'none') {
                if (gesture.type === TYPE_GESTURE_POSE && gesture.interactionType === TYPE_GESTURE_CONTINUOUS) {
                    $(item).find('#btn-trigger-woz').remove();
                    $(item).find('#control-continuous-slider').remove();
                    $(item).find('.continuous-gesture-controls').remove();
                    $(item).find('.btn-trigger-continuous-mouse-manipulation').remove();
                    $(item).find('.static-continuous-controls').removeClass('hidden');

                    var staticContinuousTimer = null;
                    $(item).find('.btn-start-static-continuous-gesture').unbind('click').bind('click', {gesture: gesture}, function (event) {
                        event.preventDefault();
                        if (!$(this).hasClass('disabled')) {
                            $(this).addClass('disabled');
                            $(this).closest('.static-continuous-controls').find('.btn-stop-static-continuous-gesture').removeClass('disabled');
                            staticContinuousTimer = setInterval(function () {
                                sendGesture(gesture.id);
                            }, 500);
                        }
                    });

                    $(item).find('.btn-stop-static-continuous-gesture').unbind('click').bind('click', {gesture: gesture}, function (event) {
                        event.preventDefault();
                        if (!$(this).hasClass('disabled')) {
                            $(this).addClass('disabled');
                            $(this).closest('.static-continuous-controls').find('.btn-start-static-continuous-gesture').removeClass('disabled');
                            if (staticContinuousTimer) {
                                clearInterval(staticContinuousTimer);
                            }
                        }
                    });
                }
            } else {
                $(item).find('#btn-trigger-woz').remove();
                $(item).find('.static-continuous-controls').remove();

                if (activeTransitionScene.continuousValueType === 'manipulationPercent') {

//                if (activeTransitionScene.continuousValueType === 'manipulationPercent') {
                    $(item).find('#control-continuous-slider').removeClass('hidden');
                    $(item).find('.continuous-gesture-controls').removeClass('hidden');
                    $(item).find('#control-continuous-slider-status').removeClass('hidden');
                    $(item).find('.btn-trigger-continuous-mouse-manipulation').remove();

                    var continuousSlider = $(item).find('#control-continuous-slider #continuous-slider');

                    var sliderOptions = {
                        value: 0,
                        min: 0,
                        max: 100,
                        enabled: scenarioStartTriggered
                    };

                    $(continuousSlider).slider(sliderOptions);
                    $(continuousSlider).unbind('change').bind('change', {gesture: gesture}, function (event) {
                        event.preventDefault();
                        var inverted = $(this).hasClass('inverted');
                        var percent = parseInt(event.value.newValue);
                        var imagePercent = inverted ? (100 - percent) : percent;
                        var gestureId = event.data.gesture.id;
                        $(continuousSlider).closest('.root').find('.control-continuous-slider-status').text(percent + '%');
                        var gestureImages = $(continuousSlider).closest('.root').find('.gestureImage');
                        $(gestureImages).removeClass('active').addClass('hidden');
                        $($(gestureImages)[Math.max(0, (Math.min(parseInt(gestureImages.length * imagePercent / 100), gestureImages.length - 1)))]).addClass('active').removeClass('hidden');
                        sendContinuousGesture(gestureId, percent);
                    });

                    var invertValuesButton = $(item).find('.btn-invert-slider-values');
                    $(invertValuesButton).unbind('click').bind('click', {slider: continuousSlider}, function (event) {
                        event.preventDefault();
                        $(this).popover('hide');
                        if ($(event.data.slider).hasClass('inverted')) {
                            $(event.data.slider).removeClass('inverted');
                            $(this).attr('data-content', translation.tooltips.execution.valuesNotInverted);
                            TweenMax.to($(this).find('.fa'), .4, {rotationY: '+=180', color: "#fff"});
                        } else {
                            $(event.data.slider).addClass('inverted');
                            $(this).attr('data-content', translation.tooltips.execution.valuesInverted);
                            TweenMax.to($(this).find('.fa'), .4, {rotationY: '+=180', color: "#5bc0de"});
                        }
                    });

                    if (wozData.invertValues === 'yes') {
                        $(invertValuesButton).click();
                    }

                    initPopover();
                } else if (activeTransitionScene.continuousValueType === 'manipulationMouse') {
                    $(item).find('#control-continuous-slider').remove();
                    $(item).find('.continuous-gesture-controls').remove();
                    var toggleButton = $(item).find('.btn-trigger-continuous-mouse-manipulation');
                    var wozContainer = $(toggleButton).closest('.woz-container');
                    $(toggleButton).removeClass('hidden');
                    $(toggleButton).unbind('click').bind('click', {gestureId: gesture.id}, function (event) {
                        event.preventDefault();
                        if (!$(this).hasClass('disabled')) {
                            if ($(this).attr('data-activated') === 'true') {
                                $(wozContainer).find('.btn-trigger-continuous-mouse-manipulation').attr('data-activated', false);
                                $(wozContainer).find('.btn-trigger-continuous-mouse-manipulation').removeClass('btn-success');
                                continuousMouseManipluationGesture = null;
                            } else {
                                $(wozContainer).find('.btn-trigger-continuous-mouse-manipulation').attr('data-activated', false);
                                $(wozContainer).find('.btn-trigger-continuous-mouse-manipulation').removeClass('btn-success');
                                $(this).attr('data-activated', true);
                                $(this).addClass('btn-success');
                                continuousMouseManipluationGesture = event.data.gestureId;
                            }
                        }
                    });
                } else {
                    $(item).find('#control-continuous-slider').remove();
                    $(item).find('.continuous-gesture-controls').remove();
                    $(item).find('.static-continuous-controls').remove();
                    $(item).find('.btn-trigger-continuous-mouse-manipulation').remove();
                }
            }

        } else {
            console.log('show standard controls');

            $(item).find('#control-continuous-slider').remove();
            $(item).find('.continuous-gesture-controls').remove();
            $(item).find('.static-continuous-controls').remove();
            $(item).find('.btn-trigger-continuous-mouse-manipulation').remove();
        }

//        if (checkedScenes.single === true && checkedScenes.pidoco && checkedScenes.pidoco === true) {
//
//        } else {
//            
//        }
    }

}



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