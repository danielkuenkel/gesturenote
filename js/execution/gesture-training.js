GestureTraining.prototype.options = null;

function GestureTraining(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}



/*
 * moderator view rendering
 */

GestureTraining.prototype.renderModeratorView = function () {
    console.log('render moderator view:', GESTURE_TRAINING.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    if (!data.training || data.training.length === 0) {
        return false;
    }

    if (!previewModeEnabled) {
        var currentPhase = getCurrentPhase();
        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
        tempData.annotations = new Array();
        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
    }

    // observation section
    renderObservations(data, container);

    renderCurrentPhaseState();

    function renderCurrentPhaseState() {
        if (currentPhaseState === null) {
            currentPhaseState = 'initialize';
        }

        switch (currentPhaseState) {
            case 'initialize':
                renderStateInitialize();
                break;
            case 'prototypeOpened':
                renderStatePrototypeOpened();
                break;
            case 'gestureTrainingStarted':
                renderStateGestureTrainingStarted();
                break;
            case 'showGesture':

                break;
            case 'trainingDone':
                renderStateTrainingDone();
                break;
            case 'screenSharingStopped':
                renderStateScreenSharingStopped();
                break;
        }
    }

    function renderStateInitialize() {
        console.log('render state: ', currentPhaseState, areThereScenes(data.training));
        $(container).find('#general').removeClass('hidden');
        $(container).find('#general .headline').text(getCurrentPhase().title);
        $(container).find('#general #description').text(data.description);

        if (areThereScenes(data.training) === true) {
            $(container).find('#btn-open-prototype').removeClass('hidden');
            $(container).find('#btn-start-training').remove();
        } else {
            $(container).find('#btn-start-training').removeClass('hidden');
            $(container).find('#btn-open-prototype').remove();
            $(container).find('#btn-start-screen-sharing').remove();
        }

        $(container).find('#btn-open-prototype').unbind('click').bind('click', function (event) {
            event.preventDefault();

            if (data.training[currentGestureTrainingIndex].transitionScenes && data.training[currentGestureTrainingIndex].transitionScenes.length > 0) {
                currentWOZScene = getSceneById(data.training[currentGestureTrainingIndex].transitionScenes[0].sceneId);
                console.log(currentWOZScene);
            } else {
                currentWOZScene = null;
            }

            var checkedScenes = checkSingleScene(data);
            openPrototypeScene(currentWOZScene, checkedScenes.single);

            currentPhaseState = 'prototypeOpened';
            renderCurrentPhaseState();
        });

        // without screen sharing
        $(container).find('#btn-start-training').unbind('click').bind('click', function (event) {
            event.preventDefault();

            if (!previewModeEnabled && peerConnection) {
                getGMT(function (timestamp) {
                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    tempData.startTrainingTime = timestamp;
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                });

                peerConnection.sendMessage(MESSAGE_START_GESTURE_TRAINING);
            }

            currentPhaseState = 'explorationStarted';
            renderCurrentPhaseState();
        });
    }

    function renderStatePrototypeOpened() {
        console.log('render state: ', currentPhaseState);

        $(container).find('#btn-open-prototype').remove();
        $(container).find('#btn-start-screen-sharing').removeClass('hidden');

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
                        console.warn(error);
                    }, function () {
                        peerConnection.startScreenRecording();
                        $(peerConnection).unbind(MESSAGE_SCREEN_SHARING_ESTABLISHED).bind(MESSAGE_SCREEN_SHARING_ESTABLISHED, function (event) {
                            event.preventDefault();
                            $(container).find('#btn-start-screen-sharing').find('.fa-spin').addClass('hidden');
                            currentPhaseState = 'gestureTrainingStarted';
                            renderCurrentPhaseState();
                        });

                        getGMT(function (timestamp) {
                            var currentPhase = getCurrentPhase();
                            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                            tempData.startTrainingTime = timestamp;
                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                        });

                        peerConnection.sendMessage(MESSAGE_START_GESTURE_TRAINING);
                    });
                } else {
                    currentPhaseState = 'gestureTrainingStarted';
                    renderCurrentPhaseState();
                }
            }
        });
    }

    function renderStateGestureTrainingStarted() {
        console.log('render state: ', currentPhaseState);
        $(container).find('#general').addClass('hidden');
        $(container).find('#training').removeClass('hidden');
        $(container).find('#btn-open-prototype').addClass('hidden');
        $(container).find('#btn-start-screen-sharing, .btn-feedback-scene').removeClass('hidden');
        wobble([container.find('#training')]);

        $(container).find('#training .headline').text(translation.gesture + ' ' + (currentGestureTrainingIndex + 1) + ' ' + translation.of + ' ' + data.training.length);
        var training = data.training[currentGestureTrainingIndex];
        renderTrainingControls(training);

        function checkTransitionScenes(scenesContainer) {
            var transitionsLength = $(scenesContainer).find('.btn-trigger-scene').length;
            var feedbackButtons = $(scenesContainer).find('#transition-feedback-container').find('.btn-trigger-feedback');
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
                            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_HIDE_FEEDBACK, time: timestamp});
                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                        });
                    });

                    getGMT(function (timestamp) {
                        var currentPhase = getCurrentPhase();
                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_SHOW_FEEDBACK, time: timestamp});
                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                    });

                    peerConnection.sendMessage(MESSAGE_TRIGGER_FEEDBACK, {triggeredFeedback: triggeredFeedback});
                }

                if (transitionsLength > 0) {
                    currentTransitionSceneIndex = 1;
                }
            }

            var leftSceneButtons = $(scenesContainer).find('#transition-scene-container').find('.btn-trigger-scene').not('.btn-primary');

            $(feedbackButtons).find('#waiting-indicator').addClass('hidden');
            var feedbackLength = $(feedbackButtons).length;


            if (transitionsLength === 1) {
                // this scene has no follow scene
            } else if (transitionsLength > 2) {
                currentTransitionSceneIndex = transitionsLength + feedbackLength - leftSceneButtons.length;
                console.log('transitionsLength', transitionsLength, 'leftSceneButtons', leftSceneButtons.length);
                if (leftSceneButtons.length > 0) {
                    var button = $(leftSceneButtons).first();
                    currentWOZScene = getSceneById($(button).attr('id'));

                    if (transitionsLength - 2 === leftSceneButtons.length) {
                        $(button).addClass('btn-primary');

                        if (prototypeWindow && prototypeWindow.closed !== true) {
                            if (currentWOZScene) {
                                getGMT(function (timestamp) {
                                    var currentPhase = getCurrentPhase();
                                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: currentWOZScene.id});
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
                currentTransitionSceneIndex = transitionsLength + feedbackLength - leftSceneButtons.length;
                currentWOZScene = getSceneById($(scenesContainer).find('#follow-scene-container').find('.btn-trigger-scene').attr('id'));
                renderFollowScene(scenesContainer);
            }

            console.log('enable btn-repeat button', leftSceneButtons.length === 0, currentTrainingIndex < parseInt(training.repeats) - 1);
            if ((leftSceneButtons && leftSceneButtons.length === 0) || (leftFeedbackButtons && leftFeedbackButtons.length === 0)) {
                if (currentTrainingIndex < parseInt(training.repeats) - 1) {
                    $(container).find('#btn-repeat-training').removeClass('hidden disabled');
                    $(container).find('#next-gesture, #training-done').addClass('disabled');
                } else {
                    $(container).find('#btn-repeat-training').addClass('disabled');
                    $(container).find('#next-gesture, #training-done').removeClass('disabled');
                }
            } else {
                $(container).find('#btn-repeat-training').addClass('disabled');
                $(container).find('#next-gesture, #training-done').addClass('disabled');
            }
        }

        function renderFollowScene(scenesContainer) {
            $(scenesContainer).find('#follow-scene-container').find('.btn-trigger-scene').addClass('btn-primary');
            if (prototypeWindow && prototypeWindow.closed !== true) {
                if (!previewModeEnabled && currentWOZScene) {
                    getGMT(function (timestamp) {
                        var currentPhase = getCurrentPhase();
                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: currentWOZScene.id});
                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                    });
                }
                console.log('check transition scenes', currentWOZScene);
                prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: currentWOZScene}, 'https://gesturenote.de');
            }
        }

        function renderTrainingControls(trainingData) {
            if (trainingData) {
                if (trainingData.transitionScenes && trainingData.transitionScenes.length > 0) {
                    currentWOZScene = getSceneById(trainingData.transitionScenes[0].sceneId);
                    console.log(currentWOZScene);
                } else {
                    currentWOZScene = null;
                }

                removeAlert($(container).find('#training'), ALERT_NO_PHASE_DATA);
                var item = $(source).find('#trainingItem').clone().removeAttr('id');
                $(container).find('#trainingContainer').empty().append(item);

                $(item).find('#btn-repeat-training').addClass('disabled');
                item.find('#repeats .text').text(trainingData.repeats - currentTrainingIndex - 1);

                if (parseInt(trainingData.repeats) > 0) {

                    $(item).find('#btn-repeat-training').unbind('click').bind('click', function (event) {
                        event.preventDefault();
                        if (!$(this).hasClass('disabled')) {
                            currentTrainingIndex++;
                            currentTransitionSceneIndex = 0;
                            renderTrainingControls(trainingData);

                            $(container).find('.btn-trigger-scene').removeClass('disabled');
                            $(container).find('.btn-trigger-feedback').removeClass('disabled');

                            console.log(currentTrainingIndex >= parseInt(training.repeats) - 1 && areThereScenes(data) === false);

                            if (prototypeWindow && prototypeWindow.closed !== true) {
                                if (!previewModeEnabled) {
                                    getGMT(function (timestamp) {
                                        var currentPhase = getCurrentPhase();
                                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                                        if (currentWOZScene) {
                                            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: currentWOZScene.id});
                                        }
                                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);

                                    });
                                }

                                prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: currentWOZScene}, 'https://gesturenote.de');
                            }
                        } else {
//                            if (gestureTrainingStartTriggered) {
                            wobble(item.find('#next-gesture, #training-done'));
//                            } else {
//                                wobble(container.find('#general'));
//                                $(document).scrollTop(0);
//                            }
                        }
                    });
                }

                var trigger = getTriggerById(trainingData.triggerId);
                item.find('#trigger .text').text(trigger.title);

                var gesture = getGestureById(trainingData.gestureId);
                if (gesture) {
                    renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage, null);

                    if (peerConnection) {
                        $(peerConnection).unbind(MESSAGE_GESTURE_INFO_PRESENT).bind(MESSAGE_GESTURE_INFO_PRESENT, function (event) {
                            event.preventDefault();
                            $(container).find('#btn-quit-gesture-preview .fa').addClass('hidden');
                            $(container).find('#btn-quit-gesture-preview').removeClass('disabled');
//                            trainingShowGesture = false;
                        });
                    }

                    $(item).find('#btn-show-gesture').unbind('click').bind('click', function (event) {
                        event.preventDefault();
                        if (!$(this).hasClass('disabled')) {
                            var button = $(this);
                            $(button).addClass('disabled');
                            $(button).find('.fa').removeClass('hidden');
                            $(container).find('.btn-trigger-scene').addClass('disabled');
                            $(container).find('.btn-trigger-feedback').addClass('disabled');
                            $(container).find('#btn-repeat-training').addClass('disabled');
                            $(item).find('#btn-quit-gesture-preview').removeClass('disabled');

                            if (!previewModeEnabled && peerConnection) {
                                $(peerConnection).unbind(MESSAGE_GESTURE_INFO_CLOSED).bind(MESSAGE_GESTURE_INFO_CLOSED, function (event, payload) {
                                    $(button).find('.fa').addClass('hidden');
                                    $(button).removeClass('disabled');
                                    $(container).find('.btn-trigger-scene').removeClass('disabled');
                                    $(container).find('.btn-trigger-feedback').removeClass('disabled');
//                                    trainingShowGesture = false;
                                });

                                getGMT(function (timestamp) {
                                    var currentPhase = getCurrentPhase();
                                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_GESTURE_TRAINING, gestureId: gesture.id, time: timestamp});
                                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                                });

                                peerConnection.sendMessage(MESSAGE_TRAINING_TRIGGERED, {currentGestureTrainingIndex: currentGestureTrainingIndex});
                            } else {

                            }

//                            trainingShowGesture = true;
//                            trainingTriggered = true;
                        }
//                        else {
//                            if (!gestureTrainingStartTriggered) {
//                                wobble(container.find('#general'));
//                                $(document).scrollTop(0);
//                            }
//                        }
                    });

                    $(item).find('#btn-quit-gesture-preview').unbind('click').bind('click', function (event) {
                        event.preventDefault();
                        if (!$(this).hasClass('disabled')) {
                            var button = $(this);
                            $(button).addClass('disabled');
                            $(button).find('.fa').removeClass('hidden');

                            if (!previewModeEnabled && peerConnection) {
                                $(peerConnection).unbind(MESSAGE_GESTURE_INFO_CLOSED).bind(MESSAGE_GESTURE_INFO_CLOSED, function (event, payload) {
                                    $(button).find('.fa').addClass('hidden');
                                    $(container).find('#btn-show-gesture').removeClass('disabled');
                                    $(container).find('#btn-show-gesture .fa').addClass('hidden');
                                    $(container).find('.btn-trigger-scene').removeClass('disabled');
                                    $(container).find('.btn-trigger-feedback').removeClass('disabled');
                                    wobble(container.find('#transition-scenes'));
                                });

                                peerConnection.sendMessage(MESSAGE_CLOSE_GESTURE_INFO);
                            } else {
                                $(button).find('.fa').addClass('hidden');
                                $(container).find('#btn-show-gesture').removeClass('disabled');
                                $(container).find('#btn-show-gesture .fa').addClass('hidden');
                                $(container).find('.btn-trigger-scene').removeClass('disabled');
                                $(container).find('.btn-trigger-feedback').removeClass('disabled');
                                wobble(container.find('#transition-scenes'));
                            }

//                            trainingShowGesture = false;
//                            trainingTriggered = true;
                        } else {
                            if (gestureTrainingStartTriggered) {
                                wobble($(item).find('#btn-show-gesture'));
                            } else {
                                wobble(container.find('#general'));
                                $(document).scrollTop(0);
                            }
                        }
                    });
                }

                var hasFeedback = trainingData.feedbackId !== 'none';
                var transitionScenes = trainingData.transitionScenes;
                if (transitionScenes && transitionScenes.length > 0) {
                    $(item).find('#start-scene-header').removeClass('hidden');
                    $(item).find('#start-scene-container').removeClass('hidden');

                    if (transitionScenes.length > 1) {
                        var startItem = getWOZTransitionItem(source, transitionScenes[0], false, true);
                        $(item).find('#start-scene-container').append(startItem);
                        TweenMax.from(startItem, .3, {y: '-10px', opacity: 0});

                        $(item).find('#follow-scene-header').removeClass('hidden');
                        $(item).find('#follow-scene-container').removeClass('hidden');
                        var followItem = getWOZTransitionItem(source, transitionScenes[transitionScenes.length - 1], !gestureTrainingStartTriggered, transitionScenes.length + (hasFeedback ? 1 : 0) === currentTransitionSceneIndex);
                        $(item).find('#follow-scene-container').append(followItem);

                        if (transitionScenes.length > 2) {
                            $(item).find('#transition-scene-header').removeClass('hidden');
                            $(item).find('#transition-scene-container').removeClass('hidden');
                            for (var j = 1; j < transitionScenes.length - 1; j++) {
                                var itemBetween = getWOZTransitionItem(source, transitionScenes[j], !gestureTrainingStartTriggered, j + (hasFeedback ? 1 : 0) <= currentTransitionSceneIndex);
                                $(item).find('#transition-scene-container').append(itemBetween);
                                if (j < transitionScenes.length - 2) {
                                    $(item).find('#transition-scene-container').append(document.createElement('br'));
                                }
                                TweenMax.from(itemBetween, .3, {y: '-10px', opacity: 0, delay: (j + 1) * .1});
                            }
                            TweenMax.from(followItem, .3, {y: '-10px', opacity: 0, delay: (transitionScenes.length * .1) - .1});
                        } else {
                            TweenMax.from(followItem, .3, {y: '-10px', opacity: 0, delay: .1});
                        }
                    } else {
                        var startItem = getWOZTransitionItem(source, transitionScenes[0], false, true);
                        $(item).find('#start-scene-container').append(startItem);
                        TweenMax.from(startItem, .3, {y: '-10px', opacity: 0});
                    }

                    if (currentTrainingIndex < parseInt(training.repeats) - 1) {
                        $(container).find('#btn-repeat-training').removeClass('hidden');
                    } else {
                        $(container).find('#btn-repeat-training').addClass('disabled');
                    }
                }

//                if (gestureTrainingStartTriggered) {
//                    if (trainingTriggered && !trainingShowGesture) {
//                        $(container).find('#btn-show-gesture').removeClass('disabled');
//                    } else if (!trainingTriggered && !trainingShowGesture) {
//                        $(container).find('#btn-show-gesture').removeClass('disabled');
//                    }
//                }

                if (trainingData.feedbackId !== 'none') {
                    $(item).find('#transition-feedback-header, #transition-feedback-container').removeClass('hidden');
                    var feedback = getFeedbackById(training.feedbackId);
                    var feedbackButton = getWOZTransitionFeedbackItem(source, feedback, trainingData.feedbackTransitionMode, trainingData.feedbackTransitionTime, !gestureTrainingStartTriggered && !trainingPrototypeOpened, transitionScenes && transitionScenes.length > 0 && currentTransitionSceneIndex >= 1);
                    $(item).find('#transition-feedback-container').empty().append(feedbackButton);
                    TweenMax.from(feedbackButton, .3, {y: '-10px', opacity: 0, delay: .1});
                }

                item.find('.btn-trigger-scene, .btn-trigger-feedback').unbind('click').bind('click', {data: trainingData}, function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled') && !$(this).hasClass('btn-primary')) {
                        var button = $(this);
                        $(button).closest('.root').find('#btn-trigger-woz').addClass('disabled');
                        checkTransitionScenes($(button).closest('.root').find('#transition-scenes'));
                    }
                });

                if (currentTrainingIndex >= parseInt(trainingData.repeats) - 1) {
                    item.find('#btn-repeat-training').addClass('disabled');
                } else {
                    var leftFeedbackButtons = $(item).find('#transition-feedback-container .btn-trigger-feedback').not('.btn-primary');
                    var leftSceneButtons = $(item).find('#transition-scenes .btn-trigger-scene').not('.btn-primary');
                    if (leftFeedbackButtons.length === 0 && leftSceneButtons.length === 0) {
                        $(item).find('#btn-repeat-training').removeClass('disabled');
                    }
                }

                console.log('check gesture index', currentGestureTrainingIndex >= (data.training.length - 1));
                if (currentGestureTrainingIndex >= (data.training.length - 1)) {
                    $(item).find('#next-gesture').addClass('hidden');
                    $(item).find('#training-done').removeClass('hidden');
                }

                $(item).find('#next-gesture').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
                        currentGestureTrainingIndex++;
                        currentTransitionSceneIndex = 0;
                        currentTrainingIndex = 0;
//                        trainingTriggered = false;
//                        trainingShowGesture = false;
//                        triggeredFeedback = null;
                        renderStateGestureTrainingStarted();
                        $(container).find('.btn-trigger-scene').addClass('disabled');
                        $(container).find('.btn-trigger-feedback').addClass('disabled');

                        if (prototypeWindow && prototypeWindow.closed !== true) {
                            if (!previewModeEnabled && currentWOZScene) {
                                getGMT(function (timestamp) {
                                    var currentPhase = getCurrentPhase();
                                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: currentWOZScene.id});
                                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                                });
                            }

                            prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: currentWOZScene}, 'https://gesturenote.de');
                        }
                    } else {
                        if (gestureTrainingStartTriggered) {
                            wobble($(container).find('#transition-scenes'));
                        } else {
                            $(document).scrollTop(0);
                            wobble(container.find('#general'));
                        }
                    }
                });

                $(item).find('#training-done').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
//                        currentPhaseStepDone = true;
//                        triggeredFeedback = null;
//                        gestureTrainingStartTriggered = false;
                        currentGestureTrainingIndex = 0;

                        currentPhaseState = 'trainingDone';
                        renderCurrentPhaseState();
                    } else {
                        wobble($(container).find('#transition-scenes'));
                    }
                });
            } else {
                appendAlert($(container).find('#training'), ALERT_NO_PHASE_DATA);
            }
        }
    }

    function renderStateTrainingDone() {
        console.log('render state: ', currentPhaseState);
        $(document).scrollTop(0);
        $(container).find('#general').removeClass('hidden');
        $(container).find('#general .read-aloud').remove();
        $(container).find('#training').addClass('hidden');
        $(container).find('#btn-start-screen-sharing').addClass('hidden');

        if (areThereScenes(data.training)) {
            $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
        } else {
            $(container).find('#btn-done-training').removeClass('hidden');
        }

        $(container).find('#btn-stop-screen-sharing').unbind('click').bind('click', function (event) {
            event.preventDefault();
//            screenSharingStopped = true;
//            triggeredFeedback = null;
//            trainingPrototypeOpened = false;
//            gestureTrainingStartTriggered = false;
            currentGestureTrainingIndex = 0;

            if (peerConnection) {
                peerConnection.stopShareScreen(true);
                peerConnection.sendMessage(MESSAGE_STOP_SCREEN_SHARING);
            }

            if (prototypeWindow) {
                prototypeWindow.close();
                prototypeWindow = null;
            }

            currentPhaseState = 'screenSharingStopped';
            renderCurrentPhaseState();
        });
    }

    function renderStateScreenSharingStopped() {
        console.log('render state: ', currentPhaseState);
        $(container).find('#general').removeClass('hidden');
        $(container).find('#general .read-aloud').remove();
        $(container).find('#training').addClass('hidden');
        $(container).find('#btn-start-screen-sharing').addClass('hidden');
        $(container).find('#btn-stop-screen-sharing').addClass('hidden');


        renderCurrentPhaseState();
    }

    function renderStateGestureTraningDone() {
        console.log('render moderator state: ', currentPhaseState);

        appendAlert(container, ALERT_PHASE_STEP_DONE);

        $(document).scrollTop(0);
        $(container).find('#btn-done-training').removeClass('hidden');
        $(container).find('#btn-done-training').unbind('click').bind('click', function (event) {
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
            }
            nextStep();
        });
    }





    return container;
};




/*
 * tester view rendering
 */

GestureTraining.prototype.renderTesterView = function () {
    console.log('render tester view:', GESTURE_TRAINING.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');



    return container;
};