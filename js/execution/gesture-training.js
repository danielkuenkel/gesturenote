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
                renderStateShowGesture();
                break;
            case 'showScenes':
                renderStateShowScenes();
                break;
            case 'noMoreTrainingRepeats':
                renderStateNoMoreTrainingRepeats();
                break;
            case 'noMoreTrainingItems':
                renderStateNoMoreTrainingItems();
                break;
            case 'screenSharingStopped':
                renderStateScreenSharingStopped();
                break;
            case 'trainingDone':
                renderStateGestureTraningDone();
                break;
        }
    }

    function renderStateInitialize() {
        console.log('render moderator state: ', currentPhaseState, areThereScenes(data.training));

        if (!previewModeEnabled) {
            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
            tempData.annotations = new Array();
            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
        }

        $(container).find('#general').removeClass('hidden');
        $(container).find('#general .headline').text(currentPhase.title);
        $(container).find('#general #description').text(data.description);

        if (areThereScenes(data.training) === true) {
            $(container).find('#btn-start-training').remove();

            $(container).find('#btn-open-prototype').removeClass('hidden');
            $(container).find('#btn-open-prototype').unbind('click').bind('click', function (event) {
                event.preventDefault();

                $(this).addClass('hidden');
                var checkedScenes = checkSingleScene(data);
                openPrototypeScene(null, checkedScenes.single);

                currentPhaseState = 'prototypeOpened';
                renderCurrentPhaseState();
            });
        } else {
            $(container).find('#btn-open-prototype').remove();
            $(container).find('#btn-start-screen-sharing').remove();
            $(container).find('#btn-start-training').removeClass('hidden');

            // without screen sharing
            $(container).find('#btn-start-training').unbind('click').bind('click', function (event) {
                event.preventDefault();

                if (!previewModeEnabled && peerConnection) {
                    getGMT(function (timestamp) {
                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                        tempData.startTrainingTime = timestamp;
                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                    });

                    peerConnection.sendMessage(MESSAGE_START_GESTURE_TRAINING);
                }

                currentPhaseState = 'gestureTrainingStarted';
                renderCurrentPhaseState();
            });
        }
    }

    function renderStatePrototypeOpened() {
        console.log('render moderator state: ', currentPhaseState);

        $(container).find('#general').removeClass('hidden');
        $(container).find('#general .headline').text(currentPhase.title);
        $(container).find('#general #description').text(data.description);
        $(container).find('#btn-open-prototype').remove();
        $(container).find('#btn-start-screen-sharing').removeClass('hidden');

        $(container).find('#btn-start-screen-sharing').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var button = $(this);
            lockButton(button, true);

            if (!previewModeEnabled && peerConnection) {
                lockButton(button, true);
                peerConnection.shareScreen(function (error) {
                    unlockButton(button, true);
                    console.warn(error);
                }, function () {
                    peerConnection.startScreenRecording();
                    $(peerConnection).unbind(MESSAGE_SCREEN_SHARING_ESTABLISHED).bind(MESSAGE_SCREEN_SHARING_ESTABLISHED, function (event) {
                        event.preventDefault();
                        unlockButton(button, true);
                        currentPhaseState = 'gestureTrainingStarted';
                        renderCurrentPhaseState();
                    });

                    getGMT(function (timestamp) {
                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                        tempData.startTrainingTime = timestamp;
                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                    });

                    peerConnection.sendMessage(MESSAGE_START_GESTURE_TRAINING);
                });
            } else {
                unlockButton(button, true);
                currentPhaseState = 'gestureTrainingStarted';
                renderCurrentPhaseState();
            }
        });
    }

    function renderStateGestureTrainingStarted() {
        console.log('render moderator state: ', currentPhaseState);

        $(container).find('#general').addClass('hidden');
        $(container).find('#training').removeClass('hidden');
        $(container).find('#btn-open-prototype').addClass('hidden');
        $(container).find('.btn-feedback-scene').removeClass('hidden');

        resetToStartScene();
        renderTrainingData(true);
        initShowGestureButton();
        wobble([container.find('#training')]);
    }

    function renderStateShowGesture() {
        console.log('render moderator state: ', currentPhaseState);

        $(container).find('#training').removeClass('hidden');
        $(container).find('.btn-trigger-scene').addClass('disabled');
        $(container).find('.btn-trigger-feedback').addClass('disabled');
        var showGestureButton = $(container).find('#btn-show-gesture');
        var quitGesturePreviewButton = $(container).find('#btn-quit-gesture-preview');

        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_GESTURE_INFO_PRESENT).bind(MESSAGE_GESTURE_INFO_PRESENT, function (event, payload) {
                $(showGestureButton).addClass('hidden');
                unlockButton(showGestureButton, true, 'fa-eye');
                $(quitGesturePreviewButton).removeClass('hidden');

                $(container).find('.btn-trigger-scene').removeClass('disabled');
                $(container).find('.btn-trigger-feedback').removeClass('disabled');
            });

            $(peerConnection).unbind(MESSAGE_GESTURE_INFO_CLOSED).bind(MESSAGE_GESTURE_INFO_CLOSED, function (event, payload) {
                unlockButton($(container).find('#btn-show-gesture'), true, 'fa-eye');
                $(quitGesturePreviewButton).addClass('hidden');

                currentPhaseState = 'showScenes';
                renderCurrentPhaseState();
            });

            var trainingData = data.training[currentTrainingIndex];
            var gesture = getGestureById(trainingData.gestureId);
            getGMT(function (timestamp) {
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_GESTURE_TRAINING, gestureId: gesture.id, time: timestamp});
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            });

            peerConnection.sendMessage(MESSAGE_OPEN_GESTURE_INFO, {currentTrainingIndex: currentTrainingIndex});
        } else {
            $(showGestureButton).addClass('hidden');
            unlockButton(showGestureButton, true, 'fa-eye');
            $(quitGesturePreviewButton).removeClass('hidden');
        }

        $(container).find('#btn-quit-gesture-preview').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                var button = $(this);
                lockButton(button, true);

                if (!previewModeEnabled && peerConnection) {
                    $(peerConnection).unbind(MESSAGE_GESTURE_INFO_CLOSED).bind(MESSAGE_GESTURE_INFO_CLOSED, function (event, payload) {
                        unlockButton(button, true);
                        $(button).addClass('hidden');
                        currentPhaseState = 'showScenes';
                        renderCurrentPhaseState();
                    });

                    peerConnection.sendMessage(MESSAGE_CLOSE_GESTURE_INFO);
                } else {
                    $(button).addClass('hidden');
                    unlockButton(button, true);
                    currentPhaseState = 'showScenes';
                    renderCurrentPhaseState();
                }
            }
        });
    }

    function renderStateShowScenes() {
        console.log('render moderator state: ', currentPhaseState);

        if ($(container).find('#training').hasClass('hidden')) {
            $(container).find('#training').removeClass('hidden');
            renderTrainingData(true);
        }
        initShowGestureButton();

        $(container).find('.btn-trigger-scene').removeClass('disabled');
        $(container).find('.btn-trigger-feedback').removeClass('disabled');
        $(container).find('#btn-show-gesture').removeClass('hidden');
        wobble(container.find('#transition-scenes'));

        $(container).find('#btn-repeat-training').unbind('click').bind('click', function (event) {
            event.preventDefault();
            currentTrainingRepeatCount++;
            currentTransitionSceneIndex = 0;

            resetToStartScene();
            renderTrainingControls();

            $(container).find('#btn-next-gesture, #btn-no-more-training-items').addClass('hidden');

            currentPhaseState = 'showScenes';
            renderCurrentPhaseState();
        });

        $(container).find('#btn-next-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                currentTrainingIndex++;
                currentTransitionSceneIndex = 0;
                currentTrainingRepeatCount = 0;

                currentPhaseState = 'gestureTrainingStarted';
                renderCurrentPhaseState();
            }
        });

        $(container).find('#btn-no-more-training-items').unbind('click').bind('click', function (event) {
            event.preventDefault();
            currentPhaseState = 'noMoreTrainingItems';
            renderCurrentPhaseState();
        });
    }

    function renderStateNoMoreTrainingRepeats() {
        console.log('render moderator state: ', currentPhaseState);

        if ($(container).find('#training').hasClass('hidden')) {
            $(container).find('#training').removeClass('hidden');
            renderTrainingData(true);
        }

        $(container).find('.btn-trigger-scene').addClass('disabled');
        $(container).find('.btn-trigger-feedback').addClass('disabled');
        $(container).find('#btn-repeat-training').addClass('hidden');
        $(container).find('#btn-show-gesture').addClass('hidden');

        if (currentTrainingIndex < data.training.length - 1) {
            $(container).find('#btn-next-gesture').removeClass('hidden');
        } else {
            $(container).find('#btn-no-more-training-items').removeClass('hidden');

            var offsetTop = $(container).find('#btn-no-more-training-items').offset().top + $(container).find('#btn-no-more-training-items').height() + 25;
            var scrollOffset = offsetTop - $(window).height();
            $('html,body').animate({scrollTop: scrollOffset < 0 ? 0 : scrollOffset}, 300);
        }
    }

    function renderStateNoMoreTrainingItems() {
        console.log('render moderator state: ', currentPhaseState);

        $(container).find('#training').addClass('hidden');

        if (areThereScenes(data.training)) {
            appendAlert(container, ALERT_QUIT_SCREENSHARING);

            $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
            $(container).find('#btn-stop-screen-sharing').unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(this).addClass('hidden');

                if (peerConnection) {
                    peerConnection.stopShareScreen(true);
                    peerConnection.sendMessage(MESSAGE_STOP_SCREEN_SHARING);
                }

                if (prototypeWindow) {
                    prototypeWindow.close();
                    prototypeWindow = null;
                }

                currentPhaseState = 'trainingDone';
                renderCurrentPhaseState();
            });
        } else {
            $(container).find('#btn-no-more-training-items').removeClass('hidden');
            $(container).find('#btn-no-more-training-items').unbind('click').bind('click', function (event) {
                event.preventDefault();
                currentTrainingIndex = 0;

                currentPhaseState = 'trainingDone';
                renderCurrentPhaseState();
            });
        }

        $('html,body').animate({scrollTop: 0}, 300);
    }

    function renderStateGestureTraningDone() {
        console.log('render moderator state: ', currentPhaseState);

        clearAlerts($(container).find('#column-right'));
        appendAlert(container, ALERT_PHASE_STEP_DONE);

        $(container).find('#btn-done-training').removeClass('hidden');
        $(container).find('#btn-done-training').unbind('click').bind('click', function (event) {
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
            }
            nextStep();
        });

        $('html,body').animate({scrollTop: 0}, 300);
    }










    // state independant functions

    function renderTrainingData(disableButtons) {
        var trainingData = data.training[currentTrainingIndex];
        var item = $(source).find('#trainingItem').clone().removeAttr('id');
        $(container).find('#trainingContainer').empty().append(item);

        item.find('#repeats .text').text(trainingData.repeats - currentTrainingRepeatCount - 1);

        var trigger = getTriggerById(trainingData.triggerId);
        item.find('#trigger .text').text(trigger.title);

        var gesture = getGestureById(trainingData.gestureId);
        if (gesture) {
            var thumbnail = getSimpleGestureListThumbnail(gesture, 'simple-gesture-thumbnail', 'col-xs-12');
            $(item).find('#thumbnail-container').empty().append(thumbnail);
        }

        renderTrainingControls(disableButtons);
    }

    function initShowGestureButton() {
        $(container).find('#btn-show-gesture').removeClass('hidden');
        $(container).find('#btn-show-gesture').on('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                var button = $(this);
                lockButton(button, true, 'fa-eye');
                currentPhaseState = 'showGesture';
                renderCurrentPhaseState();
            }
        });
    }

    function resetToStartScene() {
        var trainingData = data.training[currentTrainingIndex];


        if (trainingData.transitionScenes && trainingData.transitionScenes.length > 0) {
            currentWOZScene = getSceneById(trainingData.transitionScenes[0].sceneId);
//            console.log('currentTransitionSceneIndex', currentTransitionSceneIndex);
//            currentWOZScene = getSceneById(trainingData.transitionScenes[currentTransitionSceneIndex].sceneId);
            prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: currentWOZScene}, getPopupOrigin());
//            console.log(currentWOZScene);

            if (!previewModeEnabled && prototypeWindow && prototypeWindow.closed !== true && currentWOZScene) {
                getGMT(function (timestamp) {
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: currentWOZScene.id});
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                });
            }
        } else {

        }
    }

    function renderTrainingControls(disableButtons) {

        $(container).find('#training .headline').text(translation.gesture + ' ' + (currentTrainingIndex + 1) + ' ' + translation.of + ' ' + data.training.length);
//        console.log('render training controls', currentWOZScene, currentTransitionSceneIndex);

        var trainingData = data.training[currentTrainingIndex];


        var hasFeedback = trainingData.feedbackId !== 'none';
        var transitionScenes = trainingData.transitionScenes;
        if (transitionScenes && transitionScenes.length > 0) {
            $(container).find('#start-scene').removeClass('hidden');
//            $(container).find('#start-scene-header').removeClass('hidden');
//            $(container).find('#start-scene-container').removeClass('hidden');

            if (transitionScenes.length > 1) {
                var startItem = getWOZTransitionItem(source, transitionScenes[0], false, true);
                $(container).find('#start-scene-container').empty().append(startItem);

                $(container).find('#follow-scenes').removeClass('hidden');
//                $(container).find('#follow-scene-container').removeClass('hidden');
                var followItem = getWOZTransitionItem(source, transitionScenes[transitionScenes.length - 1], true, transitionScenes.length + (hasFeedback ? 1 : 0) === currentTransitionSceneIndex);
                $(container).find('#follow-scene-container').empty().append(followItem);

                if (transitionScenes.length > 2) {
                    $(container).find('#transition-scenes').removeClass('hidden');
                    $(container).find('#transition-scene-container').empty();
                    for (var j = 1; j < transitionScenes.length - 1; j++) {
                        var itemBetween = getWOZTransitionItem(source, transitionScenes[j], true); //  j + (hasFeedback ? 1 : 0) <= currentTransitionSceneIndex
                        $(container).find('#transition-scene-container').append(itemBetween);
                        if (j > 1) {
                            $(itemBetween).css({marginTop: '6px'});
                        }

                        if (j < transitionScenes.length - 2) {
                            $(container).find('#transition-scene-container').append(document.createElement('br'));
                        }
                    }
                }
            } else {
                var startItem = getWOZTransitionItem(source, transitionScenes[0], false, true);
                $(container).find('#start-scene-container').empty().append(startItem);
            }
        }

        if (trainingData.feedbackId !== 'none') {
            $(container).find('#transition-feedback').removeClass('hidden');
            var feedback = getFeedbackById(trainingData.feedbackId);
            var feedbackButton = getWOZTransitionFeedbackItem(source, feedback, trainingData.feedbackTransitionMode, trainingData.feedbackTransitionTime, true); //transitionScenes && transitionScenes.length > 0 && currentTransitionSceneIndex >= 1
            $(container).find('#transition-feedback-container').empty().append(feedbackButton);
        }

        $(container).find('.btn-trigger-scene, .btn-trigger-feedback').unbind('click').bind('click', {data: trainingData}, function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled') && !$(this).hasClass('btn-primary')) {
                var button = $(this);
                $(button).closest('.root').find('#btn-trigger-woz').addClass('disabled');
                checkTransitionScenes($(button).closest('.root').find('#transition-scenes'));
            }
        });

        if (currentTrainingRepeatCount >= parseInt(trainingData.repeats) - 1) {
            $(container).find('#btn-repeat-training').addClass('hidden');
            $(container).find('.btn-trigger-feedback, .btn-trigger-scene').addClass('disabled');
        }

        // check current woz scene
        if (currentWOZScene) {
            var sceneButtons = $(container).find('#transition-scenes .btn-trigger-scene');
//            console.log('sceneButtons', sceneButtons.length, sceneButtons);
            var feedbackButtons = $(container).find('#transition-feedback-container .btn-trigger-feedback');
            var breakCount = 0;
            for (var i = 0; i < sceneButtons.length; i++) {
//                console.log('activate scene button', $(sceneButtons[i]));
                $(sceneButtons[i]).addClass('btn-primary');
                if (parseInt($(sceneButtons[i]).attr('data-transition-scene-id')) === parseInt(currentWOZScene.id)) {
                    breakCount = i;
                    break;
                }
            }

            if (breakCount > 0) {
                $(feedbackButtons).addClass('btn-primary');
            }
        }


        var leftFeedbackButtons = $(container).find('#transition-feedback-container .btn-trigger-feedback').not('.btn-primary');
        var leftSceneButtons = $(container).find('#transition-scenes .btn-trigger-scene').not('.btn-primary');
        if (leftFeedbackButtons.length === 0 && leftSceneButtons.length === 0) {
            $(container).find('#btn-repeat-training').removeClass('hidden');

            if (currentTrainingIndex < data.training.length - 1) {
                $(container).find('#btn-next-gesture').removeClass('hidden');
            } else {
                $(container).find('#btn-no-more-training-items').removeClass('hidden');
            }
        } else {

        }

        if (disableButtons && disableButtons === true) {
            $(container).find('.btn-trigger-scene').addClass('disabled');
            $(container).find('.btn-trigger-feedback').addClass('disabled');
        }
    }

    function checkTransitionScenes(scenesContainer) {
        var trainingData = data.training[currentTrainingIndex];
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
                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_HIDE_FEEDBACK, time: timestamp});
                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                    });
                });

                getGMT(function (timestamp) {
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_SHOW_FEEDBACK, time: timestamp});
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                });

                peerConnection.sendMessage(MESSAGE_TRIGGER_FEEDBACK, {triggeredFeedback: triggeredFeedback});
            }

//            if (transitionsLength > 0) {
//                currentTransitionSceneIndex = 1;
//            }

            return false;
        }

        var leftSceneButtons = $(scenesContainer).find('.btn-trigger-scene').not('.btn-primary');

        $(feedbackButtons).find('#waiting-indicator').addClass('hidden');
        var feedbackLength = $(feedbackButtons).length;


        if (transitionsLength === 1) {
            // this scene has no follow scene
        } else if (transitionsLength > 2) {
//            currentTransitionSceneIndex = Math.min(transitionsLength + feedbackLength - leftSceneButtons.length, transitionsLength - 1);
            console.log('transitionsLength', transitionsLength, 'leftSceneButtons', leftSceneButtons.length, 'currentTransitionSceneIndex', currentTransitionSceneIndex);
            if (leftSceneButtons.length > 0) {
                var button = $(leftSceneButtons).first();
                currentWOZScene = getSceneById($(button).attr('id'));
                $(button).addClass('btn-primary');
                renderFollowScene();
//                if (transitionsLength - 2 === leftSceneButtons.length) {


//                if (prototypeWindow && prototypeWindow.closed !== true) {
//                    if (!previewModeEnabled && currentWOZScene) {
//                        getGMT(function (timestamp) {
//                            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: currentWOZScene.id});
//                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                        });
//                    }
//
//                    prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: currentWOZScene}, getPopupOrigin());
//                }
//                }

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
                $(this).closest('#transition-scenes').find('.btn-primary').removeClass('btn-primary');
//                $(scenesContainer).find('#follow-scene-container').find('.btn-trigger-scene').addClass('btn-primary');
                renderFollowScene();
            }
        } else if (transitionsLength === 2) {
//            currentTransitionSceneIndex = Math.min(transitionsLength + feedbackLength - leftSceneButtons.length, transitionsLength - 1);
            currentWOZScene = getSceneById($(scenesContainer).find('#follow-scene-container').find('.btn-trigger-scene').attr('id'));
            $(scenesContainer).find('#follow-scene-container').find('.btn-trigger-scene').addClass('btn-primary');
            renderFollowScene();
        }

        if (leftSceneButtons.length === 1 && leftFeedbackButtons.length === 0) {
            if (currentTrainingRepeatCount < parseInt(trainingData.repeats) - 1) {
                $(container).find('#btn-repeat-training').removeClass('hidden');
                if (currentTrainingIndex < data.training.length - 1) {
                    $(container).find('#btn-next-gesture').removeClass('hidden');
                } else {
                    $(container).find('#btn-no-more-training-items').removeClass('hidden');
                }

                var offsetTop = $(container).find('#training').offset().top + $(container).find('#training').height();
                var scrollOffset = offsetTop - $(window).height();
                $('html,body').animate({scrollTop: scrollOffset < 0 ? 0 : scrollOffset}, 300);
            } else {
                currentPhaseState = 'noMoreTrainingRepeats';
                renderCurrentPhaseState();
            }
        }

        if (currentWOZScene) {
            var button = $(scenesContainer).find('[data-transition-scene-id=' + currentWOZScene.id + ']');
            console.log('current active woz Button', button);
        }
    }

    function renderFollowScene() {
        if (prototypeWindow && prototypeWindow.closed !== true) {
            if (!previewModeEnabled && currentWOZScene) {
                getGMT(function (timestamp) {
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: currentWOZScene.id});
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                });
            }
            console.log('check transition scenes', currentWOZScene);

            prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: currentWOZScene}, getPopupOrigin());
        }
    }

    return container;
};









/*
 * tester view rendering
 */

GestureTraining.prototype.renderTesterView = function () {
    console.log('render tester view:', GESTURE_TRAINING.toUpperCase(), currentPhaseState);

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    if (!data.training || data.training.length === 0) {
        return false;
    }

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
                renderStateShowGesture();
                break;
            case 'showScenes':
                renderStateShowScenes();
                break;
            case 'noMoreTrainingRepeats':
            case 'noMoreTrainingItems':
            case 'screenSharingStopped':
            case 'trainingDone':
                renderStateGestureTraningDone();
                break;
        }
    }

    function renderStateInitialize() {
        console.log('render tester state: ', currentPhaseState);
        appendAlert(container, ALERT_PLEASE_WAIT);

        if (!previewModeEnabled && peerConnection) {
            initScreenSharing($(container).find('#scene-container'));

            $(peerConnection).unbind(MESSAGE_START_GESTURE_TRAINING).bind(MESSAGE_START_GESTURE_TRAINING, function () {
                currentPhaseState = 'gestureTrainingStarted';
                renderCurrentPhaseState();
            });
        }
    }

    function renderStatePrototypeOpened() {
        console.log('render tester state: ', currentPhaseState);
        appendAlert(container, ALERT_PLEASE_WAIT);
    }

    function renderStateGestureTrainingStarted() {
        console.log('render tester state: ', currentPhaseState);
        clearAlerts(container);
        checkScenes();

        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_OPEN_GESTURE_INFO).bind(MESSAGE_OPEN_GESTURE_INFO, function (event, payload) {
                currentTrainingIndex = payload.currentTrainingIndex;
                currentPhaseState = 'showGesture';
                renderCurrentPhaseState();
            });

            $(peerConnection).unbind(MESSAGE_STOP_SCREEN_SHARING).bind(MESSAGE_STOP_SCREEN_SHARING, function () {
                $(peerConnection).unbind(MESSAGE_STOP_SCREEN_SHARING);
                currentPhaseState = 'trainingDone';
                renderCurrentPhaseState();
            });
        }
    }

    function renderStateShowGesture() {
        console.log('render tester state: ', currentPhaseState);
        clearAlerts(container);
        checkScenes();

        currentPreviewGesture = {gesture: getGestureById(data.training[currentTrainingIndex].gestureId)};
        loadHTMLintoModal('custom-modal', 'externals/modal-gesture-info.php', 'modal-md');
        $('#custom-modal').unbind('hide.bs.modal').bind('hide.bs.modal', function () {
            if (!previewModeEnabled && peerConnection) {
                peerConnection.sendMessage(MESSAGE_GESTURE_INFO_CLOSED, {gestureId: currentPreviewGesture.id});
            }

            currentPhaseState = 'showScenes';
            renderCurrentPhaseState();
        });
    }

    function renderStateShowScenes() {
        console.log('render tester state: ', currentPhaseState);
        clearAlerts(container);
        checkScenes();

        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_TRIGGER_FEEDBACK).bind(MESSAGE_TRIGGER_FEEDBACK, function (event, payload) {
                triggeredFeedback = payload.triggeredFeedback;
                checkFeedback();
            });
        } else {
            checkFeedback();
        }
    }

    function renderStateNoMoreTrainingRepeats() {
        console.log('render tester state: ', currentPhaseState);
        clearAlerts(container);
        checkScenes();
    }

    function renderStateGestureTraningDone() {
        console.log('render tester state: ', currentPhaseState);
        appendAlert(container, ALERT_PLEASE_WAIT);
        $(container).find('#scene-container').addClass('hidden');
        showStream();
    }



    // state independent functions

    function checkScenes() {
        if (areThereScenes(data.training) === true) {
            $(container).find('#scene-container').removeClass('hidden');

            if (previewModeEnabled && currentWOZScene) {
                // render scene manually
                var sceneItem = renderSceneItem(source, container, currentWOZScene.id);
                console.log(sceneItem);
            }
        }
    }

    function checkFeedback() {
        if (triggeredFeedback) {
            console.log(triggeredFeedback);
            var hint = appendHint(source, $('body'), triggeredFeedback, TYPE_SURVEY_MODERATED);
            if (hint !== null) {
                $(hint).on('hint.hidden', function () {
                    triggeredFeedback = null;
                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_FEEDBACK_HIDDEN);
                    }
//                    else if (currentWOZScene) {
//                        renderSceneItem(source, container, currentWOZScene.id);
//                    }
                });
            } else {
                triggeredFeedback = null;
                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_FEEDBACK_HIDDEN);
                }
//                else {
//                    renderSceneItem(source, container, currentWOZScene.id);
//                }
            }
        }
    }

    return container;
};