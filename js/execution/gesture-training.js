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

    // general data section
    $(container).find('#general .headline').text(getCurrentPhase().title);
    $(container).find('#general #description').text(data.description);

    // gestures section
    currentClass.renderGestureTraining(source, container, data.training);

    // observation section
    renderObservations(data, container);

    return container;
};

GestureTraining.prototype.renderGestureTraining = function (source, container, data) {
    $(container).find('#training .headline').text('Geste ' + (currentGestureTrainingIndex + 1) + ' von ' + data.length);
    var training = data[currentGestureTrainingIndex];
    renderTrainingControls(training);

    function checkTransitionScenes(scenesContainer) {
//            $(container).find('#next-gesture, #training-done').addClass('disabled');

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
//                    if (transitionsLength > 1) {
//                        $(container).find('#btn-repeat-training').addClass('disabled');
//                        $(container).find('#next-gesture, #training-done').addClass('disabled');
//                    } else {
//                        $(container).find('#btn-repeat-training').removeClass('disabled');
//                        $(container).find('#next-gesture, #training-done').removeClass('disabled');
//                    }
            } else {
//                    $(container).find('#btn-repeat-training').addClass('disabled');
//                    $(container).find('#next-gesture, #training-done').addClass('disabled');
            }

//                return false;
        }

        var leftSceneButtons = $(scenesContainer).find('#transition-scene-container').find('.btn-trigger-scene').not('.btn-primary');
//            if (leftFeedbackButtons.length === 0 || !leftSceneButtons) {
//                $(container).find('#btn-repeat-training').removeClass('disabled');
//                $(container).find('#next-gesture, #training-done').removeClass('disabled');
//                return false;
//            } else {
//                $(container).find('#btn-repeat-training').addClass('disabled');
//                $(container).find('#next-gesture, #training-done').addClass('disabled');
//            }

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
            item.find('#repeats .address').text(translation.repeats + ":");

//                if (!areThereScenes(data)) {
            $(item).find('#btn-repeat-training').addClass('disabled');
            item.find('#repeats .text').text(trainingData.repeats - currentTrainingIndex - 1);
//                    if (gestureTrainingStartTriggered) {
//                        $(container).find('#next-gesture, #training-done').removeClass('disabled');
//                    }
//                } else {
//                    item.find('#repeats .text').text(trainingData.repeats - currentTrainingIndex - 1);
//                }

            var gesture = getGestureById(trainingData.gestureId);
            if (parseInt(trainingData.repeats) > 0) {
//                    if (areThereScenes(data)) {
//                        $(item).find('#btn-repeat-training').removeClass('hidden');
//                    } else {
//                        if (currentTrainingIndex >= parseInt(training.repeats) - 1 && areThereScenes(data) === false) {
//                            $(item).find('#btn-repeat-training').addClass('hidden disabled');
//                            $(container).find('#next-gesture, #training-done').removeClass('disabled');
//                        } else {
//                            $(item).find('#btn-repeat-training').removeClass('hidden');
//                        }
//                    }

                $(item).find('#btn-repeat-training').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
                        currentTrainingIndex++;
                        currentTransitionSceneIndex = 0;
                        renderTrainingControls(trainingData);

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
                        if (gestureTrainingStartTriggered) {
                            wobble(item.find('#next-gesture, #training-done'));
                        } else {
                            wobble(container.find('#general'));
                            $(document).scrollTop(0);
                        }
                    }
                });
            }

            var trigger = getTriggerById(trainingData.triggerId);
            item.find('#trigger .address').text(translation.trigger + ":");
            item.find('#trigger .text').text(trigger.title);

            if (gesture) {
                renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage, null);
//                    TweenMax.from($(item).find('.previewGesture').closest('.panel'), .3, {scaleX: 0, scaleY: 0, opacity: 0});

                if (peerConnection) {
                    $(peerConnection).unbind(MESSAGE_GESTURE_INFO_PRESENT).bind(MESSAGE_GESTURE_INFO_PRESENT, function (event) {
                        event.preventDefault();
                        $(container).find('#btn-quit-gesture-preview .fa').addClass('hidden');
                        $(container).find('#btn-quit-gesture-preview').removeClass('disabled');
//                            $(container).find('.btn-trigger-scene').removeClass('disabled');
//                            $(container).find('.btn-trigger-feedback').removeClass('disabled');
                        trainingShowGesture = false;
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
                                trainingShowGesture = false;
//                                    if (!areThereScenes(data)) {
//                                        $(container).find('#next-gesture, #training-done').removeClass('disabled');
//                                    }
                            });

                            getGMT(function (timestamp) {
                                var currentPhase = getCurrentPhase();
                                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_GESTURE_TRAINING, gestureId: gesture.id, time: timestamp});
                                setLocalItem(currentPhase.id + '.tempSaveData', tempData);

//                                    var currentPhase = getCurrentPhase();
//                                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                    tempData.training.push({gestureId: gesture.id, gestureTrainingStart: timestamp});
//                                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                            });

                            peerConnection.sendMessage(MESSAGE_TRAINING_TRIGGERED, {currentGestureTrainingIndex: currentGestureTrainingIndex});
                        } else {

                        }

                        trainingShowGesture = true;
                        trainingTriggered = true;
                    } else {
                        if (!gestureTrainingStartTriggered) {
                            wobble(container.find('#general'));
                            $(document).scrollTop(0);
                        }
                    }
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
//                                    peerConnection.sendMessage(MESSAGE_TRAINING_TRIGGERED, {currentGestureTrainingIndex: currentGestureTrainingIndex});
                                wobble(container.find('#transition-scenes'));
//                                    if (!areThereScenes(data)) {
//                                        $(container).find('#next-gesture, #training-done').removeClass('disabled');
//                                    }

//                                    getGMT(function (timestamp) {
//                                        var currentPhase = getCurrentPhase();
//                                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                        tempData.training.push({gestureId: gesture.id, gestureTrainingStart: timestamp});
//                                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                                    });
                            });

                            peerConnection.sendMessage(MESSAGE_CLOSE_GESTURE_INFO);
                        } else {
                            $(button).find('.fa').addClass('hidden');
                            $(container).find('#btn-show-gesture').removeClass('disabled');
                            $(container).find('#btn-show-gesture .fa').addClass('hidden');
                            $(container).find('.btn-trigger-scene').removeClass('disabled');
                            $(container).find('.btn-trigger-feedback').removeClass('disabled');
                            wobble(container.find('#transition-scenes'));
//                                if (!areThereScenes(data)) {
//                                    $(container).find('#next-gesture, #training-done').removeClass('disabled');
//                                }
                        }

                        trainingShowGesture = false;
                        trainingTriggered = true;
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

            if (gestureTrainingStartTriggered) {
                if (trainingTriggered && !trainingShowGesture) {
                    $(container).find('#btn-show-gesture').removeClass('disabled');
                } else if (!trainingTriggered && !trainingShowGesture) {
                    $(container).find('#btn-show-gesture').removeClass('disabled');
                }
            }

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
//                    $(item).find('#next-gesture, #training-done').removeClass('disabled');
            } else {
                var leftFeedbackButtons = $(item).find('#transition-feedback-container .btn-trigger-feedback').not('.btn-primary');
                var leftSceneButtons = $(item).find('#transition-scenes .btn-trigger-scene').not('.btn-primary');
                if (leftFeedbackButtons.length === 0 && leftSceneButtons.length === 0) {
                    $(item).find('#btn-repeat-training').removeClass('disabled');
                }
            }

            if (currentGestureTrainingIndex >= (data.length - 1)) {
                $(item).find('#next-gesture').addClass('hidden');
                $(item).find('#training-done').removeClass('hidden');
            }

            $(item).find('#next-gesture').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    currentGestureTrainingIndex++;
                    currentTransitionSceneIndex = 0;
                    currentTrainingIndex = 0;
                    trainingTriggered = false;
                    trainingShowGesture = false;
                    triggeredFeedback = null;
                    Moderator.renderGestureTraining(source, container, data);
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

//                        if (peerConnection) {
//                            var currentPhase = getCurrentPhase();
//                            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//
//                            for (var i = 0; i < tempData.training.length; i++) {
//                                console.log(tempData.training[i], gesture.id);
//                                var trainingData = tempData.training[i];
//                                if (parseInt(tempData.training[i].gestureId) === parseInt(gesture.id)) {
//                                    getGMT(function (timestamp) {
//                                        trainingData.gestureTrainingEnd = timestamp;
//                                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                                    });
//                                }
//                            }
//                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                        }
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
                    currentPhaseStepDone = true;
                    triggeredFeedback = null;
                    gestureTrainingStartTriggered = false;
                    currentGestureTrainingIndex = 0;
                    $(container).find('#training').addClass('hidden');
                    if (areThereScenes(data)) {
                        $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
                    } else {
                        $(container).find('#btn-done-training').removeClass('hidden disabled');
                    }
                    $(document).scrollTop(0);
                } else {
                    if (gestureTrainingStartTriggered) {
                        wobble($(container).find('#transition-scenes'));
                    } else {
                        $(document).scrollTop(0);
                        wobble(container.find('#general'));
                    }
                }
            });
        } else {
            appendAlert($(container).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
        }
    }

    if (areThereScenes(data)) {
        if (screenSharingStopped) {
            $(container).find('#training').addClass('hidden');
            $(container).find('#btn-open-prototype').remove();
            $(container).find('#btn-start-screen-sharing').addClass('hidden');
            $(container).find('#btn-stop-screen-sharing').addClass('hidden');
            $(container).find('#btn-done-training').removeClass('hidden');
        } else if (currentPhaseStepDone) {
            $(container).find('#training').addClass('hidden');
            $(container).find('#btn-open-prototype').remove();
            $(container).find('#btn-start-screen-sharing').addClass('hidden');
            $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
        } else if (trainingPrototypeOpened && !gestureTrainingStartTriggered) {
            $(container).find('#btn-open-prototype').addClass('hidden');
            $(container).find('#btn-stop-screen-sharing').addClass('hidden');
            $(container).find('#btn-start-screen-sharing').removeClass('hidden');
        } else if (trainingPrototypeOpened && gestureTrainingStartTriggered) {
            $(container).find('#btn-start-screen-sharing').addClass('hidden');
            $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
            $(container).find('.btn-trigger-scene').removeClass('disabled');
            $(container).find('.btn-trigger-feedback').removeClass('disabled');
        } else {
            $(container).find('#btn-open-prototype').removeClass('hidden');
        }
    } else if (!gestureTrainingStartTriggered) {
        container.find('#btn-start-training').removeClass('hidden');
        container.find('#btn-repeat-training').addClass('disabled');
    } else if (screenSharingStopped) {
        $(container).find('#training').addClass('hidden');
        $(container).find('#btn-open-prototype').remove();
        $(container).find('#btn-start-screen-sharing').addClass('hidden');
        $(container).find('#btn-stop-screen-sharing').addClass('hidden');
        $(container).find('#btn-done-training').removeClass('hidden');
    } else if (currentPhaseStepDone) {
        $(container).find('#training').addClass('hidden');
        $(container).find('#btn-open-prototype').remove();
        $(container).find('#btn-start-screen-sharing').addClass('hidden');
        $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
    }

    $(container).find('#btn-open-prototype').unbind('click').bind('click', function (event) {
        event.preventDefault();
        trainingPrototypeOpened = true;
        wobble([container.find('#training')]);
        $(this).addClass('hidden');
        $(container).find('#btn-start-screen-sharing, .btn-feedback-scene').removeClass('hidden');
        console.log(data);
        var checkedScenes = checkSingleScene(data);
        openPrototypeScene(currentWOZScene, checkedScenes.single);//data.training && data.training.length === 1);
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
                        console.log(MESSAGE_SCREEN_SHARING_ESTABLISHED);
                        event.preventDefault();
                        $(container).find('#btn-start-screen-sharing').find('.fa-spin').addClass('hidden');
                        enableControls();
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
                enableControls();
            }
        }
    });

    function enableControls() {
        gestureTrainingStartTriggered = true;
        $(container).find('#btn-start-screen-sharing').addClass('hidden');
        $(container).find('#btn-show-gesture').removeClass('disabled');
        if (areThereScenes(data)) {
            $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
        }
        $(container).find('#btn-repeat-training').addClass('disabled');
    }

    $(container).find('#btn-stop-screen-sharing').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            screenSharingStopped = true;
            $(this).addClass('hidden');
            $(container).find('#btn-done-training').removeClass('hidden');
            triggeredFeedback = null;
            trainingPrototypeOpened = false;
            gestureTrainingStartTriggered = false;
            currentGestureTrainingIndex = 0;
            if (peerConnection) {
                peerConnection.stopShareScreen(true);
                peerConnection.sendMessage(MESSAGE_STOP_SCREEN_SHARING);
            }

            if (prototypeWindow) {
                prototypeWindow.close();
                prototypeWindow = null;
            }
        } else {
            if (gestureTrainingStartTriggered) {
                wobble($(container).find('#training'));
            } else {
                $(document).scrollTop(0);
                wobble(container.find('#general'));
            }
        }
    });

    $(container).find('#btn-done-training').unbind('click').bind('click', function (event) {
        if (peerConnection) {
            peerConnection.sendMessage(MESSAGE_NEXT_STEP);
        }
        nextStep();
    });

    $(container).find('#btn-start-training').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(this).addClass('hidden');
        enableControls();
//            gestureTrainingStartTriggered = true;
//            $(container).find('#btn-start-screen-sharing').addClass('hidden');
//            $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
//            $(container).find('.btn-trigger-scene').removeClass('disabled');
//            $(container).find('.btn-trigger-feedback').removeClass('disabled');
//            $(container).find('#btn-show-gesture').removeClass('disabled');
//            $(container).find('#btn-repeat-training').removeClass('disabled');

        wobble([container.find('#training')]);
        if (!previewModeEnabled && peerConnection) {
            getGMT(function (timestamp) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.startTrainingTime = timestamp;
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            });

            peerConnection.sendMessage(MESSAGE_START_GESTURE_TRAINING);
        }
    });
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