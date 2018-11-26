
Exploration.prototype.options = null;

function Exploration(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}



/*
 * moderator view rendering
 */

Exploration.prototype.renderModeratorView = function () {
    console.log('render moderator view:', EXPLORATION.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    if (!data.exploration || (data.exploration && data.exploration.length === 0)) {
        return false;
    }

    if (!previewModeEnabled) {
        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
        tempData.annotations = new Array();
        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
    }

    $(container).find('#general .headline').text(getCurrentPhase().title);
    $(container).find('#general #description').text(data.description);

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
            case 'explorationStarted':
                renderStateExplorationStarted();
                break;
            case 'exploreGestures':
                renderStateExploreGestures();
                break;
            case 'askPreferredGestures':
                renderStateAskPreferredGestures();
                break;
            case 'askResponsePreferredGestures':
                renderStateAskResponsePreferredGestures();
                break;
            case 'exploreTrigger':
                renderStateExploreTrigger();
                break;
            case 'askPreferredTrigger':
                renderStateAskPreferredTrigger();
                break;
            case 'askResponsePreferredTrigger':
                renderStateAskResponsePreferredTrigger();
                break;
            case 'noMoreData':
                renderStateNoMoreData();
                break;
            case 'explorationDone':
                renderStateExplorationDone();
                break;
        }
    }

    function renderStateInitialize() {
        console.log('render moderator state: ', currentPhaseState);

        $(container).find('#general').removeClass('hidden');
        if (areThereScenes(data.exploration) === true) {
            $(container).find('#btn-start-exploration').remove();

            // check if there are scenes for this exploration index
            $(container).find('#btn-open-prototype').removeClass('hidden');
            $(container).find('#btn-open-prototype').unbind('click').bind('click', function (event) {
                event.preventDefault();

                if (data.exploration[currentExplorationIndex].transitionScenes && data.exploration[currentExplorationIndex].transitionScenes.length > 0) {
                    var currentScene = getSceneById(data.exploration[currentIdentificationIndex].transitionScenes[currentIdentificationScene].sceneId);
                    if (currentScene) {
                        openPrototypeScene(currentScene, data.exploration.length === 1 && data.exploration[currentIdentificationIndex].transitionScenes.length === 1, data.exploration[currentIdentificationIndex].transitionScenes[currentIdentificationScene].description);
                    }
                } else {
                    openPrototypeScene(null, data.exploration.length === 1 && data.exploration[currentExplorationIndex].transitionScenes.length === 1, null, currentExplorationIndex);
                }

                currentPhaseState = 'prototypeOpened';
                renderCurrentPhaseState();
            });
        } else {
            // without screen sharing
            $(container).find('#btn-open-prototype').remove();
            $(container).find('#btn-start-exploration').removeClass('hidden')

            $(container).find('#btn-start-exploration').unbind('click').bind('click', function (event) {
                event.preventDefault();
                currentPhaseState = 'explorationStarted';
                renderCurrentPhaseState();

                if (!previewModeEnabled && peerConnection) {
                    peerConnection.sendMessage(MESSAGE_START_EXPLORATION);
                }
            });
        }
    }

    function renderStatePrototypeOpened() {
        console.log('render moderator state: ', currentPhaseState);

        $(container).find('#general').removeClass('hidden');
        $(container).find('#btn-start-exploration').remove();
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
                            currentPhaseState = 'explorationStarted';
                            renderCurrentPhaseState();
                        });
                        peerConnection.sendMessage(MESSAGE_START_EXPLORATION);
                    });
                } else {
                    currentPhaseState = 'explorationStarted';
                    renderCurrentPhaseState();
                }
            }
        });
    }

    function renderStateExplorationStarted() {
        if (data.explorationType === 'gestures') {
            currentPhaseState = 'exploreGestures';
        } else if (data.explorationType === 'trigger') {
            currentPhaseState = 'exploreTrigger';
        }

        renderCurrentPhaseState();
    }




    // explore gestures

    function renderStateExploreGestures() {
        console.log('render moderator state: ', currentPhaseState);

        currentPreviewGesture = null;
        $(container).find('#general').addClass('hidden');
        $(container).find('#identified-gestures').addClass('hidden');
        $(container).find('#slides').removeClass('hidden');

        $(container).find('#slides .headline').text(translation.userCenteredGestureExtraction + " " + (currentExplorationIndex + 1) + " " + translation.of + " " + data.exploration.length);
        var item = $(source).find('#explorationItem').clone().removeAttr('id');

        var searchedData = getTriggerById(data.exploration[currentExplorationIndex].triggerId);
        $(item).find('#search-for .address').text(translation.GestureForTrigger + ':');
        $(item).find('#search-for .text').text(searchedData.title);

        $(container).find('#exploration-container').empty().append(item);
        renderSceneTriggerItems(item, container, data);

        renderCurrentGesturesToShow();

        if (data.askPreferredGesture === 'yes') {
            $(container).find('#btn-request-gestures').removeClass('hidden');
            $(container).find('#btn-request-gestures').unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(this).addClass('hidden');
                currentPhaseState = 'askPreferredGestures';
                renderCurrentPhaseState();

                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_REQUEST_PREFERRED_GESTURES, {currentExplorationIndex: currentExplorationIndex});
                }
            });
        } else {
            checkPreferredGesturesResponseControls();
        }
    }

    function renderStateAskPreferredGestures() {
        console.log('render state: ', currentPhaseState);

        $(container).find('#slides').addClass('hidden');
        $(container).find('#identified-gestures').removeClass('hidden');
        $(container).find('#identified-gestures .question-container').empty();
        appendAlert($(container).find('#identified-gestures'), ALERT_WAITING_FOR_TESTER);
        currentPreviewGesture = null;
    }

    function renderStateAskResponsePreferredGestures() {
        console.log('render moderator state: ', currentPhaseState);

        clearAlerts($(container).find('#identified-getures'));
        $(container).find('#slides').addClass('hidden');
        $(container).find('#identified-gestures').removeClass('hidden');

        // render selected gestures
        renderQuestionnaireAnswers($(container).find('#identified-gestures'), currentQuestionnaireAnswers.data, currentQuestionnaireAnswers.answers, false);

        checkPreferredGesturesResponseControls();
    }




    // explore trigger

    function renderStateExploreTrigger() {
        console.log('render moderator state: ', currentPhaseState);

        currentPreviewTrigger = null;
        $(container).find('#general').addClass('hidden');
        $(container).find('#slides').removeClass('hidden');
        $(container).find('#identified-trigger').addClass('hidden');
        $(container).find('#slides .headline').text(translation.userCenteredTriggerExtraction + " " + (currentExplorationIndex + 1) + " " + translation.of + " " + data.exploration.length);
        var item = $(source).find('#explorationItem-trigger').clone().removeAttr('id');

        var searchedData = getGestureById(data.exploration[currentExplorationIndex].gestureId);

        var gestureThumbnail = $('#item-container-moderator').find('#present-gesture-item').clone().removeAttr('id');
        $(gestureThumbnail).css({marginBottom: '10px'});
        $(gestureThumbnail).find('.thumbnail-container').empty().append(getSimpleGestureListThumbnail(searchedData, 'simple-gesture-thumbnail', 'col-xs-12'));
        $(gestureThumbnail).find('.btn-present-gesture').attr('data-gesture-id', searchedData.id);
        $(gestureThumbnail).find('.btn-quite-gesture-info').attr('data-gesture-id', searchedData.id);
        $(gestureThumbnail).find('.gesture-thumbnail').css({marginBottom: '10px'});
        $(gestureThumbnail).insertBefore($(item).find('#assembled-trigger-container'));

        if (currentPreviewGesture && parseInt(currentPreviewGesture.gesture.id) === parseInt(searchedData.id)) {
            $(gestureThumbnail).find('.btn-present-gesture').click();
        }

        $(container).find('#exploration-container').empty().append(item);
        renderSceneTriggerItems(item, container, data);

        renderCurrentTriggersToShow();

        if (data.askPreferredTrigger === 'yes') {
            $(container).find('#btn-request-trigger').removeClass('hidden');
            $(container).find('#btn-request-trigger').unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(this).addClass('hidden');
                currentPhaseState = 'askPreferredTrigger';
                renderCurrentPhaseState();

                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_REQUEST_PREFERRED_TRIGGER, {currentExplorationIndex: currentExplorationIndex});
                }
            });
        } else {
            checkPreferredTriggerResponseControls();
        }

    }

    function renderStateAskPreferredTrigger() {
        console.log('render moderator state: ', currentPhaseState);

        $(container).find('#slides').addClass('hidden');
        $(container).find('#btn-request-gestures').addClass('hidden');
        $(container).find('#identified-trigger').addClass('hidden');
        $(container).find('#identified-trigger .question-container').empty();
        appendAlert($(container).find('#identified-trigger'), ALERT_WAITING_FOR_TESTER);
        currentPreviewTrigger = null;

        var gesture = getGestureById(data.exploration[currentExplorationIndex].gestureId);
        $(container).find('#identified-trigger #thumbnail-container').empty().append(getSimpleGestureListThumbnail(gesture, 'simple-gesture-thumbnail', 'col-xs-12'));
    }

    function renderStateAskResponsePreferredTrigger() {
        console.log('render moderator state: ', currentPhaseState);

        $(container).find('#btn-start-exploration').remove();
        $(container).find('#btn-open-prototype').remove();
        $(container).find('#slides').addClass('hidden');

        clearAlerts($(container).find('#identified-trigger'));
        $(container).find('#identified-trigger').removeClass('hidden');
        $(container).find('#btn-request-trigger').addClass('hidden');

        // render selected trigger
        renderQuestionnaireAnswers($(container).find('#identified-trigger'), currentQuestionnaireAnswers.data, currentQuestionnaireAnswers.answers, false);

        checkPreferredTriggerResponseControls();

        if (!previewModeEnabled) {
            var gesture = getGestureById(data.exploration[currentExplorationIndex].gestureId);
            $(container).find('#identified-trigger #thumbnail-container').empty().append(getSimpleGestureListThumbnail(gesture, 'simple-gesture-thumbnail', 'col-xs-12'));
        }
    }




    function renderStateNoMoreData() {
        console.log('render moderator state: ', currentPhaseState);

        $(container).find('#slides').addClass('hidden');
        $(container).find('#identified-gestures, #identified-trigger').addClass('hidden');

        if (areThereScenes(data.exploration)) {
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

                currentPhaseState = 'explorationDone';
                renderCurrentPhaseState();
            });
        } else {
            currentPhaseState = 'explorationDone';
            renderCurrentPhaseState();
        }

        $('html,body').animate({scrollTop: 0}, 300);
    }

    function renderStateExplorationDone() {
        console.log('render moderator state: ', currentPhaseState);
        clearAlerts(container.find('#column-right'));
        appendAlert(container, ALERT_PHASE_STEP_DONE);

        $(container).find('#btn-done-exploration').removeClass('hidden');
        $(container).find('#btn-done-exploration').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
            }
            nextStep();
        });
    }

    // live events
    if (!previewModeEnabled && peerConnection) {
        $(peerConnection).unbind(MESSAGE_RESPONSE_PREFERRED_GESTURES).bind(MESSAGE_RESPONSE_PREFERRED_GESTURES, function (event, payload) {
            currentQuestionnaireAnswers = {data: payload.data, answers: payload.answers, saveAnswers: payload.saveAnswers || false};
            currentPhaseState = 'askResponsePreferredGestures';
            renderCurrentPhaseState();
        });

        $(peerConnection).unbind(MESSAGE_RESPONSE_PREFERRED_TRIGGER).bind(MESSAGE_RESPONSE_PREFERRED_TRIGGER, function (event, payload) {
            clearAlerts($(container).find('#identified-trigger'));

            currentQuestionnaireAnswers = {data: payload.data, answers: payload.answers, saveAnswers: payload.saveAnswers || false};
            currentPhaseState = 'askResponsePreferredTrigger';
            renderCurrentPhaseState();
        });
    }

    return container;


//    function renderExplorationForGestures() {
//

//        if (currentExplorationIndex < data.exploration.length - 1) {
//            if (data.askPreferredGesture === 'yes' && explorationPrototypeOpened) {
//                $(container).find('#btn-request-gestures').removeClass('hidden');
//            } else if (scenesUsedForExploration(data.exploration) === true && explorationPrototypeOpened) {
//                $(container).find('#btn-next-trigger').removeClass('hidden');
//            }
//        } else {
//            $(container).find('#btn-next-trigger').addClass('hidden');
//            if (data.askPreferredGesture === 'yes') {
//                $(container).find('#btn-request-gestures').removeClass('hidden');
//            } else {
//                if (scenesUsedForExploration(data.exploration) === true) {
//                    $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
//                } else {
//                    currentPhaseStepDone = true;
//                    $(container).find('#btn-done-exploration').removeClass('hidden disabled');
//                }
//            }
//        }
//
//        if (!data.exploration[currentExplorationIndex].transitionScenes) {
//            $(item).find('.scenes-container').remove();
//        }
//    }    




    // gesture request functionalities

    function renderCurrentGesturesToShow() {
        var gesturesToShow = data.exploration[currentExplorationIndex].gestures;

        if (gesturesToShow.length > 0) {
            for (var i = 0; i < gesturesToShow.length; i++) {
                var gesture = getGestureById(gesturesToShow[i]);
                var presentItem = $('#item-container-moderator').find('#present-gesture-item').clone().removeAttr('id');
                $(presentItem).css({marginBottom: '10px'});
                $(presentItem).find('.thumbnail-container').empty().append(getSimpleGestureListThumbnail(gesture, 'simple-gesture-thumbnail', 'col-xs-12'));
                $(presentItem).find('.btn-present-gesture').attr('data-gesture-id', gesture.id);
                $(presentItem).find('.btn-quite-gesture-info').attr('data-gesture-id', gesture.id);
                $(presentItem).find('.gesture-thumbnail').css({marginBottom: '10px'});
                $(container).find('#assembled-gestures').append(presentItem);
                initPopover();

                if (currentPreviewGesture && parseInt(currentPreviewGesture.gesture.id) === parseInt(gesture.id)) {
                    $(presentItem).find('.btn-present-gesture').click();
                }
            }

            initPreviewGestureButtons();
        }
    }

    function checkPreferredGesturesResponseControls() {
        if (currentQuestionnaireAnswers.saveAnswers === true) {
            $(container).find('#btn-next-trigger, #btn-done').removeClass('disabled');
        } else {
            $(container).find('#btn-next-trigger, #btn-done').addClass('disabled');
        }

        if (currentExplorationIndex < data.exploration.length - 1) {
            $(container).find('#btn-next-trigger').removeClass('hidden');
            $(container).find('#btn-next-trigger').unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(this).addClass('hidden');
                currentExplorationIndex++;
                currentExplorationScene = 0;

                currentPhaseState = 'explorationStarted';
                renderCurrentPhaseState();

                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_START_EXPLORATION);
                }
            });
        } else {
            $(container).find('#btn-done').removeClass('hidden');
            $(container).find('#btn-done').unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(this).addClass('hidden');
                currentPhaseState = 'noMoreData';
                renderCurrentPhaseState();
            });
        }
    }










    // trigger request functionalities

    function renderCurrentTriggersToShow() {
        var triggerToShow = data.exploration[currentExplorationIndex].trigger;

        if (triggerToShow.length > 0) {

            for (var i = 0; i < triggerToShow.length; i++) {
                var trigger = getTriggerById(triggerToShow[i]);
                var presentItem = $('#item-container-moderator').find('#present-trigger-item').clone().removeAttr('id');
                $(presentItem).find('.trigger-title').text(trigger.title);
                $(presentItem).find('.btn-present-trigger').attr('data-trigger-id', trigger.id);
                $(presentItem).find('.btn-quite-trigger-info').attr('data-trigger-id', trigger.id);
                $(container).find('#assembled-trigger').append(presentItem);

                if (currentPreviewTrigger && parseInt(currentPreviewTrigger.id) === parseInt(trigger.id)) {
                    $(presentItem).find('.btn-present-trigger').click();
                }
            }

            var activePresentButton = null;
            var activeQuitButton = null;
            if (!previewModeEnabled && peerConnection) {
                $(peerConnection).unbind(MESSAGE_TRIGGER_INFO_PRESENT).bind(MESSAGE_TRIGGER_INFO_PRESENT, function (event) {
                    event.preventDefault();
                    unlockButton(activePresentButton, true);
                    $(activePresentButton).addClass('hidden');
                    $(activePresentButton).parent().find('.btn-quit-trigger-info').removeClass('hidden');
                });

                $(peerConnection).unbind(MESSAGE_TRIGGER_INFO_CLOSED).bind(MESSAGE_TRIGGER_INFO_CLOSED, function (event, payload) {
                    event.preventDefault();
                    unlockButton(activeQuitButton, true);
                    $(activeQuitButton).addClass('hidden');
                    $(activeQuitButton).closest('.root').find('.btn-present-trigger').removeClass('hidden disabled');
                    $(container).find('.btn-present-gesture').removeClass('disabled');

                    var triggerId = payload.triggerId;
                    if (triggerId && !previewModeEnabled) {
                        getGMT(function (timestamp) {
                            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_HIDE_TRIGGER_INFO, time: timestamp, triggerId: triggerId});
                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                        });
                    }
                });
            }

            initPreviewGestureButtons();

            $(container).find('.btn-present-trigger').unbind('click').bind('click', function (event) {
                event.preventDefault();
                activePresentButton = $(this);
                activeQuitButton = $(this).parent().find('.btn-quit-trigger-info');

                if (!$(activePresentButton).hasClass('disabled')) {
                    var triggerId = $(this).attr('data-trigger-id');
                    currentPreviewTrigger = getTriggerById(triggerId);

                    $(activePresentButton).closest('.root').find('.btn-present-trigger').addClass('disabled');
                    $(container).find('.btn-present-gesture').addClass('disabled');

                    if (!previewModeEnabled && peerConnection) {
                        lockButton(activePresentButton, true);
                        peerConnection.sendMessage(MESSAGE_OPEN_TRIGGER_INFO, {id: triggerId});

                        getGMT(function (timestamp) {
                            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_SHOW_TRIGGER_INFO, time: timestamp, triggerId: triggerId});
                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                        });
                    } else {
                        $(activePresentButton).addClass('hidden');
                        $(activePresentButton).parent().find('.btn-quit-trigger-info').removeClass('hidden');
                    }
                }
            });

            $(container).find('.btn-quit-trigger-info').unbind('click').bind('click', function (event) {
                event.preventDefault();
                activeQuitButton = $(this);
                if (!$(activeQuitButton).hasClass('disabled')) {
                    var triggerId = $(this).attr('data-trigger-id');
                    currentPreviewTrigger = null;

                    if (!previewModeEnabled && peerConnection) {
                        lockButton(activeQuitButton, true);
                        peerConnection.sendMessage(MESSAGE_CLOSE_TRIGGER_INFO, {id: triggerId});
                    } else {
                        $(activeQuitButton).addClass('hidden');
                        $(activeQuitButton).closest('.root').find('.btn-present-trigger').removeClass('hidden disabled');
                        $(container).find('.btn-present-gesture').removeClass('hidden disabled');
                    }
                }
            });
        }
    }

    function checkPreferredTriggerResponseControls() {
        if (currentQuestionnaireAnswers.saveAnswers === true) {
            $(container).find('#btn-next-gesture, #btn-done').removeClass('disabled');
        } else {
            $(container).find('#btn-next-gesture, #btn-done').addClass('disabled');
        }

        if (currentExplorationIndex < data.exploration.length - 1) {
            $(container).find('#btn-next-gesture').removeClass('hidden');
            $(container).find('#btn-next-gesture').unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(this).addClass('hidden');
                currentExplorationIndex++;
                currentExplorationScene = 0;

                currentPhaseState = 'explorationStarted';
                renderCurrentPhaseState();

                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_START_EXPLORATION);
                }
            });
        } else {
            $(container).find('#btn-done').removeClass('hidden');
            $(container).find('#btn-done').unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(this).addClass('hidden');
                currentPhaseState = 'noMoreData';
                renderCurrentPhaseState();
            });
        }
    }

    function initPreviewGestureButtons() {
        var activePresentButton = null;
        var activeQuitButton = null;

        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_GESTURE_INFO_PRESENT).bind(MESSAGE_GESTURE_INFO_PRESENT, function (event) {
                event.preventDefault();
                unlockButton(activePresentButton, true);
                $(activePresentButton).addClass('hidden');
                $(activePresentButton).parent().find('.btn-quit-gesture-info').removeClass('hidden');
            });

            $(peerConnection).unbind(MESSAGE_GESTURE_INFO_CLOSED).bind(MESSAGE_GESTURE_INFO_CLOSED, function (event, payload) {
                event.preventDefault();
                unlockButton(activeQuitButton, true);
                $(activeQuitButton).addClass('hidden');
                $(activeQuitButton).closest('.root').find('.btn-present-gesture').removeClass('hidden disabled');
                $(container).find('.btn-present-trigger').removeClass('disabled');

                var gestureId = payload.gestureId;
                if (gestureId) {
                    getGMT(function (timestamp) {
                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_HIDE_GESTURE_INFO, time: timestamp, gestureId: gestureId});
                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                    });
                }
            });
        }


        $(container).find('.btn-present-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            activePresentButton = $(this);
            activeQuitButton = $(this).parent().find('.btn-quit-gesture-info');

            if (!$(activePresentButton).hasClass('disabled')) {
                var gestureId = $(this).attr('data-gesture-id');
                currentPreviewGesture = {gesture: getGestureById(gestureId)};

                $(activePresentButton).closest('.root').find('.btn-present-gesture').addClass('disabled');
                $(activePresentButton).closest('.root').find('.btn-present-trigger').addClass('disabled');

                if (!previewModeEnabled && peerConnection) {
                    lockButton(activePresentButton, true);
                    peerConnection.sendMessage(MESSAGE_OPEN_GESTURE_INFO, {id: gestureId});
                } else {
                    $(activePresentButton).addClass('hidden');
                    $(activePresentButton).parent().find('.btn-quit-gesture-info').removeClass('hidden');
                }

                if (gestureId && !previewModeEnabled) {
                    getGMT(function (timestamp) {
                        var currentPhase = getCurrentPhase();
                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_SHOW_GESTURE_INFO, time: timestamp, gestureId: gestureId});
                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                    });
                }
            }
        });

        $(container).find('.btn-quit-gesture-info').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var activeQuitButton = $(this);
            if (!$(activeQuitButton).hasClass('disabled')) {
                var gestureId = $(this).attr('data-gesture-id');
                currentPreviewGesture = null;

                if (!previewModeEnabled && peerConnection) {
                    lockButton(activeQuitButton, true);
                    peerConnection.sendMessage(MESSAGE_CLOSE_GESTURE_INFO, {id: gestureId});
                } else {
                    $(activeQuitButton).addClass('hidden');
                    $(activeQuitButton).closest('.root').find('.btn-present-gesture').removeClass('hidden disabled');
                    $(activeQuitButton).closest('.root').find('.btn-present-trigger').removeClass('hidden disabled');
                }
            }
        });
    }




//    function enableControls() {
//        $(container).find('#slides').removeClass('hidden');
//        wobble([container.find('#slides')]);
//
//        $(container).find('.btn-trigger-scene, .btn-reset-scene').removeClass('disabled');
//
//        if (data.exploration.length === 1) {
//            if (data.askPreferredGesture === 'yes') {
//                $(container).find('#btn-request-gestures').removeClass('hidden disabled');
//            } else if (data.askPreferredTrigger === 'yes') {
//                $(container).find('#btn-request-trigger').removeClass('hidden disabled');
//            } else {
//
//            }
//        } else {
//            if (data.askPreferredGesture === 'yes') {
//                $(container).find('#btn-request-gestures').removeClass('hidden disabled');
//            } else if (data.askPreferredTrigger === 'yes') {
//                $(container).find('#btn-request-trigger').removeClass('hidden disabled');
//            } else {
//                if (data.exploration.length > 1) {
//                    $(container).find('#btn-next-' + (data.explorationType === 'gestures' ? 'trigger' : 'gesture')).removeClass('hidden disabled');
//                }
//            }
//        }
//    }







    // state independent functions

    // scene buttons

    function renderSceneTriggerItems(item, container, data) {
        if (data.exploration && data.exploration[currentExplorationIndex].transitionScenes && data.exploration[currentExplorationIndex].transitionScenes.length > 0) {
            var transitionScenes = data.exploration[currentExplorationIndex].transitionScenes;

            for (var i = 0; i < transitionScenes.length; i++) {
                var scene = getSceneById(transitionScenes[i].sceneId);
                var transitionItem = $(source).find('#transition-scene-item').clone().attr('id', scene.id);
                var itemData = $(source).find('#interactive-scenes-catalog-thumbnail').clone().removeAttr('id');
                $(itemData).find('#info-' + scene.type).removeClass('hidden');
                $(itemData).find('.btn-text').text(scene.title);
                $(itemData).find('.scene-description').text(transitionScenes[i].description);
                $(itemData).find('.btn-trigger-scene').attr('data-scene-id', scene.id);
                $(transitionItem).find('.scene-data').append(itemData);
//                $(item).find('#transition-scenes').append(transitionItem);
//                $(item).find('#transition-scenes').append(document.createElement('br'));
//                $(itemData).find('.btn-trigger-scene').removeClass('disabled');

                if (i === 0) {
                    $(container).find('#start-scene').removeClass('hidden');
                    $(container).find('#start-scene-container').append(transitionItem);
                } else if (transitionScenes.length > 2 && i > 0 && i < transitionScenes.length - 1) {
                    $(container).find('#transition-scenes').removeClass('hidden');
                    $(container).find('#transition-scene-container').append(transitionItem);
                    $(container).find('#transition-scene-container').append(document.createElement('br'));

                    if (i > 1) {
                        $(transitionItem).find('.scene-data').css({marginTop: '8px'});
                    }
                } else {
                    $(container).find('#follow-scenes').removeClass('hidden');
                    $(container).find('#follow-scene-container').append(transitionItem);
                }

                $(itemData).find('#info-' + scene.type + ' .btn-trigger-scene').unbind('click').bind('click', {index: i}, function (event) {
                    if (!$(this).hasClass('btn-primary') && !$(this).hasClass('disabled')) {
                        $(this).closest('.root').find('.btn-trigger-scene').removeClass('btn-primary');
                        $(this).addClass('btn-primary');
                        var sceneId = $(this).attr('data-scene-id');
                        var scene = getSceneById(sceneId);
                        currentExplorationScene = event.data.index;
                        openPrototypeScene(scene, data.exploration.length === 1 && transitionScenes.length === 1, transitionScenes[currentExplorationScene].description);

                        if (scene && !previewModeEnabled) {
                            getGMT(function (timestamp) {
                                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: sceneId});
                                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                            });
                        }
                    }
                });

                if ((currentExplorationScene > 0 && i === currentExplorationScene) || (currentExplorationScene === 0 && i === 0)) {
                    $(itemData).find('#info-' + scene.type + ' .btn-trigger-scene').click();
                    $(transitionItem).find('.btn-trigger-scene').addClass('btn-primary');
//                    $(transitionItem).find('.scene-description').removeClass('hidden');
                }
            }
        }
    }

    function scenesUsedForExploration(data) {
        if (data && data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                if (data[i].transitionScenes && data[i].transitionScenes.length > 0) {
                    return true;
                }
            }
        }
        return false;
    }

    return container;
};










/*
 * tester view rendering
 */

Exploration.prototype.renderTesterView = function () {
    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');
    console.log('render tester view:', currentPhase.format.toUpperCase());

    if (!data.exploration || (data.exploration && data.exploration.length === 0)) {
        return false;
    }

//    container.empty().append($(source).find('#exploration-moderated').clone().removeAttr('id'));

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
            case 'explorationStarted':
                renderStateExplorationStarted();
                break;
            case 'exploreGestures':
                renderStateExploreGestures();
                break;
            case 'askPreferredGestures':
                renderStateAskPreferredGestures();
                break;
            case 'askResponsePreferredGestures':
                renderStateAskResponsePreferredGestures();
                break;
            case 'exploreTrigger':
                renderStateExploreTrigger();
                break;
            case 'askPreferredTrigger':
                renderStateAskPreferredTrigger();
                break;
            case 'askResponsePreferredTrigger':
                renderStateAskResponsePreferredTrigger();
                break;
            case 'noMoreData':
            case 'explorationDone':
                renderStateExplorationDone();
                break;
        }
    }

    function renderStateInitialize() {
        console.log('render tester state: ', currentPhaseState);

        appendAlert(container, ALERT_PLEASE_WAIT);

        if (!previewModeEnabled && peerConnection) {
            Tester.initScreenSharing($(container).find('#scene-container'));

            $(peerConnection).unbind(MESSAGE_START_EXPLORATION).bind(MESSAGE_START_EXPLORATION, function () {
                currentPhaseState = 'explorationStarted';
                renderCurrentPhaseState();
            });
        }
    }

    function renderStatePrototypeOpened() {
        console.log('render tester state: ', currentPhaseState);
        appendAlert($(container), ALERT_PLEASE_WAIT);
    }

    function renderStateExplorationStarted() {
        console.log('render tester state: ', currentPhaseState);

        appendAlert(container, ALERT_PLEASE_WAIT);

        if (data.explorationType === 'gestures') {
            currentPhaseState = 'exploreGestures';
        } else {
            currentPhaseState = 'exploreTrigger';
        }
        renderCurrentPhaseState();

        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_STOP_SCREEN_SHARING).bind(MESSAGE_STOP_SCREEN_SHARING, function (event, payload) {
                currentPhaseState = 'explorationDone';
                renderCurrentPhaseState();
            });
        }
    }

    function renderStateExploreGestures() {
        console.log('render tester state: ', currentPhaseState);
        clearAlerts(container);
        checkScenes();

        // check if there are previews triggered in study preview
        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_OPEN_GESTURE_INFO).bind(MESSAGE_OPEN_GESTURE_INFO, function (event, payload) {
                console.log('open gesture info', payload);

                currentPreviewGesture = {gesture: getGestureById(payload.id)};
                openGesturePreview();
            });

            $(peerConnection).unbind(MESSAGE_REQUEST_PREFERRED_GESTURES).bind(MESSAGE_REQUEST_PREFERRED_GESTURES, function (event, payload) {
                console.log('requeset preferred gestures');
//                $('#custom-modal').unbind('hidden.bs.modal').bind('hidden.bs.modal', function (event) {
//                    event.preventDefault();
                currentExplorationIndex = payload.currentExplorationIndex;
                currentPhaseState = 'askPreferredGestures';
                renderCurrentPhaseState();
//                });

            });
        } else if (currentPreviewGesture) {
            openGesturePreview();
        }
    }

    function renderStateAskPreferredGestures() {
        console.log('render tester state: ', currentPhaseState);

        clearAlerts(container);
        checkScenes();

        $('#custom-modal').unbind('hidden.bs.modal').bind('hidden.bs.modal', function () {
            $('#custom-modal').unbind('hidden.bs.modal');
            console.log('hide.bs.modal ask prefered gestures');
            currentPhaseState = 'askResponsePreferredGestures';
            renderCurrentPhaseState();
        });
        loadHTMLintoModal('custom-modal', 'externals/modal-preferred-gestures.php', 'modal-md');
    }

    function renderStateAskResponsePreferredGestures() {
        console.log('render tester state: ', currentPhaseState);
        clearAlerts(container);
        checkScenes();
    }

    function renderStateExploreTrigger() {
        console.log('render tester state: ', currentPhaseState);
        clearAlerts(container);
        checkScenes();

        // check if there are previews triggered in study preview
        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_OPEN_GESTURE_INFO).bind(MESSAGE_OPEN_GESTURE_INFO, function (event, payload) {
                console.log('open gesture info', payload);

                currentPreviewGesture = {gesture: getGestureById(payload.id)};
                openGesturePreview();
            });

            $(peerConnection).unbind(MESSAGE_OPEN_TRIGGER_INFO).bind(MESSAGE_OPEN_TRIGGER_INFO, function (event, payload) {
                console.log('open trigger info', payload);

                currentPreviewTrigger = getTriggerById(payload.id);
                openTriggerPreview();
            });

            $(peerConnection).unbind(MESSAGE_REQUEST_PREFERRED_TRIGGER).bind(MESSAGE_REQUEST_PREFERRED_TRIGGER, function (event, payload) {
                event.preventDefault();
                currentExplorationIndex = payload.currentExplorationIndex;
                currentPhaseState = 'askPreferredTrigger';
                renderCurrentPhaseState();
            });
        } else {
            if (currentPreviewGesture) {
                openGesturePreview();
            }

            if (currentPreviewTrigger) {
                openTriggerPreview();
            }
        }
    }

    function renderStateAskPreferredTrigger() {
        console.log('render tester state: ', currentPhaseState);

        clearAlerts(container);
        checkScenes();

        $('#custom-modal').unbind('hidden.bs.modal').bind('hidden.bs.modal', function () {
            $('#custom-modal').unbind('hidden.bs.modal');
            currentPhaseState = 'askResponsePreferredTrigger';
            renderCurrentPhaseState();
        });
        loadHTMLintoModal('custom-modal', 'externals/modal-preferred-trigger.php', 'modal-md');
    }

    function renderStateAskResponsePreferredTrigger() {
        console.log('render tester state: ', currentPhaseState);
        clearAlerts(container);
        checkScenes();
    }

    function renderStateExplorationDone() {
        console.log('render tester state: ', currentPhaseState);
        $(container).find('#scene-container').addClass('hidden');
        appendAlert($(container), ALERT_PLEASE_WAIT);
    }

    return container;






    // state independent functions

    function openGesturePreview() {
        $('#custom-modal').unbind('hide.bs.modal').bind('hide.bs.modal', function () {
            $('#custom-modal').unbind('hide.bs.modal');
            if (!previewModeEnabled && peerConnection) {
                peerConnection.sendMessage(MESSAGE_GESTURE_INFO_CLOSED, {gestureId: currentPreviewGesture.gesture.id});
            }
            currentPreviewGesture = null;
        });
        loadHTMLintoModal('custom-modal', 'externals/modal-gesture-info.php', 'modal-md');
    }

    function openTriggerPreview() {
        $('#custom-modal').unbind('hide.bs.modal').bind('hide.bs.modal', function () {

            $('#custom-modal').unbind('hide.bs.modal');
            if (!previewModeEnabled && peerConnection) {
                peerConnection.sendMessage(MESSAGE_TRIGGER_INFO_CLOSED, {triggerId: currentPreviewTrigger.id});
            }
            currentPreviewTrigger = null;
        });
        loadHTMLintoModal('custom-modal', 'externals/modal-trigger-info.php', 'modal-sm');
    }

    function checkScenes() {

        if (areThereScenes(data.exploration) === true) {
            if (data.exploration[currentExplorationIndex].transitionScenes && data.exploration[currentExplorationIndex].transitionScenes.length > 0) {
                $(container).find('#scene-description p').text(data.exploration[currentExplorationIndex].transitionScenes[currentExplorationScene].description);
                var sceneId = data.exploration[currentExplorationIndex].transitionScenes[currentExplorationScene].sceneId;
                $(container).find('#scene-container').removeClass('hidden');

                if (previewModeEnabled) {
                    // render scene manually
                    var sceneItem = renderSceneItem(source, container, sceneId);
                    console.log(sceneItem);
                }
            } else {
                appendAlert(container, ALERT_PLEASE_WAIT);
            }
        } else {
            appendAlert(container, ALERT_PLEASE_WAIT);
        }
    }
};










/*
 * observer view rendering
 */

Exploration.prototype.renderObserverView = function () {
    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');
    console.log('render observer view:', currentPhase.format.toUpperCase());

    if (!data.exploration || (data.exploration && data.exploration.length === 0)) {
        return false;
    }
    
    if (!previewModeEnabled) {
        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
        tempData.annotations = new Array();
        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
    }

    // observation section
    renderObservations(data, container);

    // init annotation controls
    renderAnnotationControls(container);

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
            case 'explorationStarted':
                renderStateExplorationStarted();
                break;
            case 'exploreGestures':
                renderStateExploreGestures();
                break;
            case 'askPreferredGestures':
                renderStateAskPreferredGestures();
                break;
            case 'askResponsePreferredGestures':
                renderStateAskResponsePreferredGestures();
                break;
            case 'exploreTrigger':
                renderStateExploreTrigger();
                break;
            case 'askPreferredTrigger':
                renderStateAskPreferredTrigger();
                break;
            case 'askResponsePreferredTrigger':
                renderStateAskResponsePreferredTrigger();
                break;
            case 'noMoreData':
            case 'explorationDone':
                renderStateExplorationDone();
                break;
        }
    }

    function renderStateInitialize() {
        console.log('render observer state: ', currentPhaseState);

        appendAlert(container, ALERT_PLEASE_WAIT);

        if (!previewModeEnabled && peerConnection) {
            initScreenSharing($(container).find('#scene-container'));

            $(peerConnection).unbind(MESSAGE_START_EXPLORATION).bind(MESSAGE_START_EXPLORATION, function () {
                currentPhaseState = 'explorationStarted';
                renderCurrentPhaseState();
            });
        }
    }

    function renderStatePrototypeOpened() {
        console.log('render observer state: ', currentPhaseState);
        appendAlert($(container), ALERT_PLEASE_WAIT);
    }

    function renderStateExplorationStarted() {
        console.log('render observer state: ', currentPhaseState);

        appendAlert(container, ALERT_PLEASE_WAIT);

        if (data.explorationType === 'gestures') {
            currentPhaseState = 'exploreGestures';
        } else {
            currentPhaseState = 'exploreTrigger';
        }
        renderCurrentPhaseState();

        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_STOP_SCREEN_SHARING).bind(MESSAGE_STOP_SCREEN_SHARING, function (event, payload) {
                currentPhaseState = 'explorationDone';
                renderCurrentPhaseState();
            });
        }
    }

    function renderStateExploreGestures() {
        console.log('render observer state: ', currentPhaseState);
        clearAlerts(container);
        checkScenes();

        // check if there are previews triggered in study preview
        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_OPEN_GESTURE_INFO).bind(MESSAGE_OPEN_GESTURE_INFO, function (event, payload) {
                console.log('open gesture info', payload);

                currentPreviewGesture = {gesture: getGestureById(payload.id)};
                openGesturePreview();
            });

            $(peerConnection).unbind(MESSAGE_REQUEST_PREFERRED_GESTURES).bind(MESSAGE_REQUEST_PREFERRED_GESTURES, function (event, payload) {
//                $('#custom-modal').unbind('hidden.bs.modal').bind('hidden.bs.modal', function (event) {
//                    event.preventDefault();
//                    
//                });
                currentPhaseState = 'askPreferredGestures';
                renderCurrentPhaseState();
                currentExplorationIndex = payload.currentExplorationIndex;
            });
        } else if (currentPreviewGesture) {
//            openGesturePreview();
        }
    }

    function renderStateAskPreferredGestures() {
        console.log('render observer state: ', currentPhaseState);

        clearAlerts(container);

        $(container).find('#scene-container').addClass('hidden');
        $(container).find('#identified-gestures').removeClass('hidden');
        $(container).find('#identified-gestures .question-container').empty();
        appendAlert($(container).find('#identified-gestures'), ALERT_WAITING_FOR_TESTER);

//        checkScenes();

//        $('#custom-modal').unbind('hidden.bs.modal').bind('hidden.bs.modal', function () {
//            $('#custom-modal').unbind('hidden.bs.modal');
//            console.log('hide.bs.modal ask prefered gestures');
//            currentPhaseState = 'askResponsePreferredGestures';
//            renderCurrentPhaseState();
//        });
//        loadHTMLintoModal('custom-modal', 'externals/modal-preferred-gestures.php', 'modal-md');
    }

    function renderStateAskResponsePreferredGestures() {
        console.log('render observer state: ', currentPhaseState);

        clearAlerts(container);
        clearAlerts($(container).find('#identified-getures'));
        $(container).find('#scene-container').addClass('hidden');
        $(container).find('#identified-gestures').removeClass('hidden');

        // render selected gestures
        renderQuestionnaireAnswers($(container).find('#identified-gestures'), currentQuestionnaireAnswers.data, currentQuestionnaireAnswers.answers, false);
    }

    function renderStateExploreTrigger() {
        console.log('render observer state: ', currentPhaseState);
        clearAlerts(container);
        checkScenes();

        // check if there are previews triggered in study preview
        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_OPEN_GESTURE_INFO).bind(MESSAGE_OPEN_GESTURE_INFO, function (event, payload) {
                console.log('open gesture info', payload);

                currentPreviewGesture = {gesture: getGestureById(payload.id)};
//                openGesturePreview();
            });

            $(peerConnection).unbind(MESSAGE_OPEN_TRIGGER_INFO).bind(MESSAGE_OPEN_TRIGGER_INFO, function (event, payload) {
                console.log('open trigger info', payload);

                currentPreviewTrigger = getTriggerById(payload.id);
//                openTriggerPreview();
            });

            $(peerConnection).unbind(MESSAGE_REQUEST_PREFERRED_TRIGGER).bind(MESSAGE_REQUEST_PREFERRED_TRIGGER, function (event, payload) {
                event.preventDefault();
                currentExplorationIndex = payload.currentExplorationIndex;
                currentPhaseState = 'askPreferredTrigger';
                renderCurrentPhaseState();
            });
        } else {
            if (currentPreviewGesture) {
//                openGesturePreview();
            }

            if (currentPreviewTrigger) {
//                openTriggerPreview();
            }
        }
    }

    function renderStateAskPreferredTrigger() {
        console.log('render observer state: ', currentPhaseState);

//        clearAlerts(container);
//        checkScenes();
//
//        $('#custom-modal').unbind('hidden.bs.modal').bind('hidden.bs.modal', function () {
//            $('#custom-modal').unbind('hidden.bs.modal');
//            currentPhaseState = 'askResponsePreferredTrigger';
//            renderCurrentPhaseState();
//        });
//        loadHTMLintoModal('custom-modal', 'externals/modal-preferred-trigger.php', 'modal-md');


        $(container).find('#scene-container').addClass('hidden');
//        $(container).find('#btn-request-gestures').addClass('hidden');
        $(container).find('#identified-trigger').addClass('hidden');
        $(container).find('#identified-trigger .question-container').empty();
        appendAlert($(container).find('#identified-trigger'), ALERT_WAITING_FOR_TESTER);
        currentPreviewTrigger = null;

        var gesture = getGestureById(data.exploration[currentExplorationIndex].gestureId);
        $(container).find('#identified-trigger #thumbnail-container').empty().append(getSimpleGestureListThumbnail(gesture, 'simple-gesture-thumbnail', 'col-xs-12'));
    }

    function renderStateAskResponsePreferredTrigger() {
        console.log('render state: ', currentPhaseState);

        clearAlerts($(container).find('#identified-trigger'));
        $(container).find('#identified-trigger').removeClass('hidden');

        // render selected trigger
        renderQuestionnaireAnswers($(container).find('#identified-trigger'), currentQuestionnaireAnswers.data, currentQuestionnaireAnswers.answers, false);

        if (!previewModeEnabled) {
            var gesture = getGestureById(data.exploration[currentExplorationIndex].gestureId);
            $(container).find('#identified-trigger #thumbnail-container').empty().append(getSimpleGestureListThumbnail(gesture, 'simple-gesture-thumbnail', 'col-xs-12'));
        }
    }

    function renderStateExplorationDone() {
        console.log('render state: ', currentPhaseState);
        $(container).find('#scene-container').addClass('hidden');
        $(container).find('#identified-trigger').addClass('hidden');
        $(container).find('#identified-gestures').addClass('hidden');
        appendAlert($(container), ALERT_PLEASE_WAIT);
    }




    // live events
    if (!previewModeEnabled && peerConnection) {
        $(peerConnection).unbind(MESSAGE_RESPONSE_PREFERRED_GESTURES).bind(MESSAGE_RESPONSE_PREFERRED_GESTURES, function (event, payload) {
            currentQuestionnaireAnswers = {data: payload.data, answers: payload.answers, saveAnswers: payload.saveAnswers || false};
            currentPhaseState = 'askResponsePreferredGestures';
            renderCurrentPhaseState();
        });

        $(peerConnection).unbind(MESSAGE_RESPONSE_PREFERRED_TRIGGER).bind(MESSAGE_RESPONSE_PREFERRED_TRIGGER, function (event, payload) {
            clearAlerts($(container).find('#identified-trigger'));

            currentQuestionnaireAnswers = {data: payload.data, answers: payload.answers, saveAnswers: payload.saveAnswers || false};
            currentPhaseState = 'askResponsePreferredTrigger';
            renderCurrentPhaseState();
        });
    }

    return container;






    // state independent functions

//    function openGesturePreview() {
//        $('#custom-modal').unbind('hide.bs.modal').bind('hide.bs.modal', function () {
//            $('#custom-modal').unbind('hide.bs.modal');
//            if (!previewModeEnabled && peerConnection) {
//                peerConnection.sendMessage(MESSAGE_GESTURE_INFO_CLOSED, {gestureId: currentPreviewGesture.gesture.id});
//            }
//            currentPreviewGesture = null;
//        });
//        loadHTMLintoModal('custom-modal', 'externals/modal-gesture-info.php', 'modal-md');
//    }
//
//    function openTriggerPreview() {
//        $('#custom-modal').unbind('hide.bs.modal').bind('hide.bs.modal', function () {
//
//            $('#custom-modal').unbind('hide.bs.modal');
//            if (!previewModeEnabled && peerConnection) {
//                peerConnection.sendMessage(MESSAGE_TRIGGER_INFO_CLOSED, {triggerId: currentPreviewTrigger.id});
//            }
//            currentPreviewTrigger = null;
//        });
//        loadHTMLintoModal('custom-modal', 'externals/modal-trigger-info.php', 'modal-sm');
//    }

    function checkScenes() {

        if (areThereScenes(data.exploration) === true) {
            if (data.exploration[currentExplorationIndex].transitionScenes && data.exploration[currentExplorationIndex].transitionScenes.length > 0) {
                $(container).find('#scene-description p').text(data.exploration[currentExplorationIndex].transitionScenes[currentExplorationScene].description);
                var sceneId = data.exploration[currentExplorationIndex].transitionScenes[currentExplorationScene].sceneId;
                $(container).find('#scene-container').removeClass('hidden');

                if (previewModeEnabled) {
                    // render scene manually
                    var sceneItem = renderSceneItem(source, container, sceneId);
                    console.log(sceneItem);
                }
            } else {
                appendAlert(container, ALERT_PLEASE_WAIT);
            }
        } else {
            appendAlert(container, ALERT_PLEASE_WAIT);
        }
    }
};