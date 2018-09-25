/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var prototypeWindow = null;
var rtcStreamControlsTween = null;
var continuousMouseManipluationGesture = null;

var Moderator = {
    renderView: function renderView() {
//        $('.alert-space').empty();
        var currentPhase = getCurrentPhase();
        var currentPhaseData = getCurrentPhaseData();
//        var source = getSourceContainer(currentView);
        if (previewModeEnabled === false) {
            setLocalItem(currentPhase.id + '.tempSaveData', {});
            getGMT(function (timestamp) {
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.startTime = timestamp;
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            });
        }
//        console.log('render view', currentPhase);
        Moderator.initializePeerConnection();
        if (currentPhaseData || (currentPhaseData && $.isArray(currentPhaseData) && currentPhaseData.length > 0)) {

//            var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');
//            $(container).find('#column-left').css({'opacity': '0'});
//            var userRole = USER_ROLE_MODERATOR;
            var item = null;
            switch (currentPhase.format) {
                case LETTER_OF_ACCEPTANCE:
                    currentClass = new LetterOfAcceptance();
//                    item = currentClass.renderModeratorView();
//                    item = Moderator.getLetterOfAcceptance(container, currentPhaseData);
                    break;
                case THANKS:
                    currentClass = new Thanks();
//                    item = currentClass.renderModeratorView();
//                    item = Moderator.getThanks(container, currentPhaseData);
                    break;
                case QUESTIONNAIRE:
                    currentClass = new Questionnaire({isPreview: true});
//                    item = currentClass.renderModeratorView();
//                    item = Moderator.getQuestionnaire(source, container, currentPhaseData, true);
                    break;
                case INTERVIEW:
                    currentClass = new Interview();
//                    item = currentClass.renderModeratorView();
//                    item = Moderator.getInterview(source, container, currentPhaseData);
                    break;
                case FOCUS_GROUP_INTERVIEW:
                    currentClass = new FocusGroupInterview();
//                    item = currentClass.renderModeratorView();
//                    item = Moderator.getFocusGroupInterview(source, container, currentPhaseData);
                    break;
                case GUS_SINGLE_GESTURES:
                    currentClass = new GestureUsabilityScaleSingle();
//                    item = currentClass.renderModeratorView();
//                    item = Moderator.getGUS(source, container, currentPhaseData);
                    break;
                case GUS_MULTIPLE_GESTURES:
                    currentClass = new GestureUsabilityScaleMultiple();
//                    item = currentClass.renderModeratorView();
//                    item = Moderator.getQuestionnaire(source, container, currentPhaseData.gus, true);
                    break;
                case SUS:
                    currentClass = new SystemUsabilityScale();
//                    item = currentClass.renderModeratorView();
//                    item = Moderator.getSUS(source, container, currentPhaseData);
                    break;
                case UEQ:
                    currentClass = new UserExperienceQuestionnaire();
//                    item = currentClass.renderModeratorView();
//                    item = Moderator.getQuestionnaire(source, container, currentPhaseData, true);
//                    $(item).find('.headline').text(getCurrentPhase().title);
                    break;
                case GESTURE_TRAINING:
                    currentClass = new GestureTraining();
//                    item = currentClass.renderModeratorView();
//                    item = Moderator.getGestureTraining(source, container, currentPhaseData);
                    break;
                case SCENARIO:
                    currentClass = new UserTest();
//                    item = currentClass.renderModeratorView();
//                    item = Moderator.getScenario(source, container, currentPhaseData);
                    break;
                case SLIDESHOW_GESTURES:
                    currentClass = new GestureSlideshow();
//                    item = currentClass.renderModeratorView();
//                    item = Moderator.getGestureSlideshow(source, container, currentPhaseData);
                    break;
                case SLIDESHOW_TRIGGER:
                    currentClass = new TriggerSlideshow();

//                    item = Moderator.getTriggerSlideshow(source, container, currentPhaseData);
                    break;
                case PHYSICAL_STRESS_TEST:
                    currentClass = new PhysicalStressTest();
//                    item = currentClass.renderModeratorView();
//                    item = Moderator.getPhysicalStressTest(source, container, currentPhaseData);
                    break;
                case IDENTIFICATION:
                    currentClass = new Identification();
//                    item = currentClass.renderModeratorView();
//                    item = Moderator.getIdentification(source, container, currentPhaseData);
                    break;
//                case EXPLORATION:
//                    item = Moderator.getExploration(source, container, currentPhaseData);
//                    break;
                case EXPLORATION:
                    currentClass = new Exploration();
//                    item = currentClass.renderModeratorView();
                    break;
            }
            item = currentClass.renderModeratorView();

            if (item !== false) {
                console.log('append item', item, syncPhaseStep);
                if (!syncPhaseStep || currentPhase.format === THANKS) {
                    $('#viewModerator #phase-content').empty().append(item);
                }
            } else {
                Moderator.renderNoDataView();
            }

            if (currentPhase.format === THANKS) {
                $('.btn-cancel').addClass('disabled');
            } else {
                $('.btn-cancel').removeClass('disabled');
            }
        } else {
            Moderator.renderNoDataView();
        }

        Moderator.initializeRTC();

        $('#viewModerator #column-right').css({y: 0, opacity: 1});
//        Moderator.checkPositioning(currentPhase.format);
        TweenMax.from($('#phase-content #column-right'), .2, {y: -20, opacity: 0, clearProps: 'all'});
//        TweenMax.to($('#phase-content #column-left'), .2, {opacity: 1, clearProps: 'all'});
        if ($(document).scrollTop() > 0) {
            $(document).scrollTop(0);
        }

//        pinRTC();
//        updateRTCHeight($('#phase-content #column-left').width(), true);

        if (isPidocoSocketNeeded() && getBrowser() === BROWSER_FIREFOX &&
                (currentPhase.format === SCENARIO ||
                        currentPhase.format === GESTURE_TRAINING ||
                        currentPhase.format === EXPLORATION ||
                        currentPhase.format === IDENTIFICATION)) {
            console.log('pidoco socket needed');
            initWebSocket();
        } else {
            destroyWebsocket();
        }

    },
    checkPositioning: function checkPositioning(format) {
//        if (previewModeEnabled) {
//            var posY = '70px';
//            switch (format) {
//                case SCENARIO:
//                    posY = '0px';
//                    break;
//            }
//            $('#viewModerator #phase-content').css({marginTop: posY});
//        }
    },
    renderNoDataView: function renderNoDataView() {
        var alert = $(getSourceContainer(currentView)).find('#no-phase-data').clone().removeAttr('id');
        $('#viewModerator #phase-content').append(alert);
        appendAlert(alert, ALERT_NO_PHASE_DATA);
    },
//    getLetterOfAcceptance: function getLetterOfAcceptance(container, data) {
//        $(container).find('.letter-text').text(data);
//        appendAlert(container, ALERT_PLEASE_WAIT);
//        return container;
//    },
//    getThanks: function getThanks(container, data) {
//        removeAlert($('#viewModerator'), ALERT_PLEASE_WAIT);
//        $('#viewModerator').find('#phase-content').removeClass('hidden');
//        $('#viewModerator').find('#pinnedRTC').css({opacity: 1});
//
//        TweenMax.to(container.find('.fa-upload'), .5, {yoyo: true, repeat: -1, opacity: .4});
//        $(container).find('#thanks-text').text(data);
//        $(container).find('.thanks-text').text(data);
//        $(container).find('#btn-leave-survey').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            var query = getQueryParams(document.location.search);
//            if (query.studyId && query.h && query.token) {
//                goto('study-prepare-evaluator.php?studyId=' + query.studyId + '&h=' + query.h + '&token=' + query.token);
//            }
//        });
//
//        $(container).find('#btn-retry-upload').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (previewModeEnabled === false) {
//                submitFinalData(container);
//            }
//        });
//
//        if (previewModeEnabled === false) {
//            checkRTCUploadStatus(container);
//        }
//
//        return container;
//    },
//    getQuestionnaire: function getQuestionnaire(source, container, data, isPreview) {
//        data = getAssembledItems(data);
//        console.log('get questionnaire', data);
//
//        if (data && data.length > 0) {
//            if (isPreview) {
//                renderQuestionnaireAnswers(container, data, currentQuestionnaireAnswers, true);
//            } else {
//                renderQuestionnaire(container, data, currentQuestionnaireAnswers, true);
//            }
//        } else {
//            appendAlert(container, ALERT_NO_PHASE_DATA);
//        }
//
//        var currentPhaseStepFormat = getCurrentPhase().format;
//        if (currentPhaseStepFormat === INTERVIEW || currentPhaseStepFormat === FOCUS_GROUP_INTERVIEW) {
//            $(container).find('.question-container').unbind('questionnaireDone').bind('questionnaireDone', function (event) {
//                event.preventDefault();
//                console.log('questionnaire done triggered');
//
//                $(container).find('#btn-next-step').prev().addClass('hidden');
//                $(container).find('#btn-next-step').addClass('hidden');
//
//                questionnaireDone = true;
//                currentQuestionnaireAnswers = checkCurrentQuestionnaireAnswers(getQuestionnaireAnswers(container.find('.question-container').children(), data));
//
//                if (!previewModeEnabled && peerConnection) {
//                    var currentPhase = getCurrentPhase();
//                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                    tempData.answers = currentQuestionnaireAnswers.answers;
//                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                }
//
//                $(container).find('#btn-next-step').click();
//            });
//
//            $(container).find('.question-container').unbind('nextQuestion').bind('nextQuestion', function (event) {
//                console.log('next question clicked');
//                event.preventDefault();
//                currentQuestionnaireAnswers = checkCurrentQuestionnaireAnswers(getQuestionnaireAnswers(container.find('.question-container').children(), data));
//
//                if (previewModeEnabled === false && peerConnection) {
//                    var currentPhase = getCurrentPhase();
//                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                    tempData.answers = currentQuestionnaireAnswers.answers;
//                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                }
//            });
//
//            $(container).unbind('change').bind('change', function (event) {
//                event.preventDefault();
//                currentQuestionnaireAnswers = checkCurrentQuestionnaireAnswers(getQuestionnaireAnswers(container.find('.question-container').children(), data));
//
//                if (previewModeEnabled === false && peerConnection) {
//                    var currentPhase = getCurrentPhase();
//                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                    tempData.answers = currentQuestionnaireAnswers.answers;
//                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                }
//            });
//        }
//
//        $(container).find('#btn-next-step').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                if (!previewModeEnabled && peerConnection) {
//                    peerConnection.sendMessage(MESSAGE_NEXT_STEP);
//                }
//                nextStep();
//            }
//        });
//
//        if (questionnaireDone) {
//            $(container).find('#btn-next-step').removeClass('disabled');
//        }
//
//        if (!previewModeEnabled && peerConnection) {
//            $(peerConnection).unbind(MESSAGE_QUESTIONNAIRE_DONE).bind(MESSAGE_QUESTIONNAIRE_DONE, function (event, payload) {
//                $(container).find('#btn-next-step').removeClass('disabled');
//            });
//
//            if (getCurrentPhase().format !== PHYSICAL_STRESS_TEST) {
//                $(peerConnection).unbind(MESSAGE_UPDATE_QUESTIONNAIRE).bind(MESSAGE_UPDATE_QUESTIONNAIRE, function (event, payload) {
//                    console.log('update questionnaire', payload);
//                    renderQuestionnaireAnswers(container, data, payload);
//                });
//            }
//        }
//
//        return container;
//    },
//    getInterview: function getInterview(source, container, data) {
//        Moderator.getQuestionnaire(source, container, data, false);
//        return container;
//    },
//    getSUS: function getSUS(source, container, data) {
//        $(container).find('.headline').text(getCurrentPhase().title);
//        Moderator.getQuestionnaire(source, container, data, true);
//        return container;
//    },
//    getGUS: function getGUS(source, container, data) {
//        currentGUSData = data;
//        var gesture = getGestureById(data.gestureId);
//        var trigger = getTriggerById(data.triggerId);
//        var feedback = getFeedbackById(data.feedbackId);
//        if (gesture) {
//            renderGestureImages($(container).find('.previewGesture'), gesture.images, gesture.previewImage, null);
//            $(container).find('#gesture .address').text(translation.gesture + ':');
//            $(container).find('#gesture .text').text(gesture.title);
//            $(container).find('#trigger .address').text(translation.trigger + ':');
//            $(container).find('#trigger .text').text(trigger.title);
//
//
//            if (feedback) {
//                $(container).find('#feedback .address').text(translation.feedback + ':');
//                $(container).find('#feedback .text').text(feedback.title);
//                var icon = document.createElement('i');
//                var label = document.createElement('div');
//                $(label).addClass('label label-default');
//                switch (feedback.type) {
//                    case TYPE_FEEDBACK_SOUND:
//                        $(label).text(' Sound');
//                        $(icon).addClass('fa fa-volume-up');
//                        break;
//                    case TYPE_FEEDBACK_TEXT:
//                        $(label).text(' Text');
//                        $(icon).addClass('fa fa-font');
//                        break;
//                }
//
//                container.find('#feedback .text').text(" " + feedback.title);
//                $(label).prepend(icon);
//                container.find('#feedback .text').prepend(label);
//            }
//        }
//
//        Moderator.getQuestionnaire(source, container, data.gus, true);
//        return container;
//    },
//    getGestureTraining: function getGestureTraining(source, container, data) {
//
//        if (!data.training || data.training.length === 0) {
//            return false;
//        }
//
//        if (!previewModeEnabled) {
//            var currentPhase = getCurrentPhase();
//            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//            tempData.annotations = new Array();
//            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//        }
//
//        // general data section
//        $(container).find('#general .headline').text(getCurrentPhase().title);
//        $(container).find('#general #description').text(data.description);
//
//        // gestures section
//        Moderator.renderGestureTraining(source, container, data.training);
//
//        // observation section
//        renderObservations(data, container);
//        return container;
//    },
//    renderGestureTraining: function renderGestureTraining(source, container, data) {
////        console.log('renderGestureTraining', data);
//        $(container).find('#training .headline').text('Geste ' + (currentGestureTrainingIndex + 1) + ' von ' + data.length);
//        var training = data[currentGestureTrainingIndex];
//        renderTrainingControls(training);
//
//        function checkTransitionScenes(scenesContainer) {
////            $(container).find('#next-gesture, #training-done').addClass('disabled');
//
//            var transitionsLength = $(scenesContainer).find('.btn-trigger-scene').length;
//            var feedbackButtons = $(scenesContainer).find('#transition-feedback-container').find('.btn-trigger-feedback');
//            var leftFeedbackButtons = $(scenesContainer).find('#transition-feedback-container').find('.btn-trigger-feedback').not('.btn-primary');
//            if (leftFeedbackButtons.length === 1) {
//                var feedbackButton = $(leftFeedbackButtons).first();
//                $(feedbackButton).addClass('btn-primary');
//
//                var transitionMode = $(feedbackButton).attr('data-transition-mode');
//                var feedback = getFeedbackById($(feedbackButton).attr('id'));
//                triggeredFeedback = {id: feedback.id, transitionMode: transitionMode};
//
//                if (transitionMode === 'automatically') {
//                    var transitionTime = parseFloat($(feedbackButton).attr('data-transition-time'));
//                    var indicator = $(feedbackButton).find('#transition-indicator').removeClass('hidden');
//                    triggeredFeedback.transitionTime = transitionTime;
//
//                    TweenMax.from(indicator, transitionTime, {width: '0px', ease: Linear.easeNone, onComplete: function () {
//                            $(feedbackButton).find('#waiting-indicator').removeClass('hidden');
//                            if (previewModeEnabled) {
//                                checkTransitionScenes(scenesContainer);
//                            }
//                            TweenMax.to(indicator, .4, {opacity: 0});
//                        }});
//                } else {
//                    $(feedbackButton).find('#waiting-indicator').removeClass('hidden');
//                }
//
//                if (!previewModeEnabled && peerConnection) {
//                    $(peerConnection).unbind(MESSAGE_FEEDBACK_HIDDEN).bind(MESSAGE_FEEDBACK_HIDDEN, function (event, payload) {
//                        if (transitionMode === 'automatically') {
//                            checkTransitionScenes(scenesContainer);
//                        }
//
//                        $(feedbackButton).find('#waiting-indicator').addClass('hidden');
//
//                        getGMT(function (timestamp) {
//                            var currentPhase = getCurrentPhase();
//                            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_HIDE_FEEDBACK, time: timestamp});
//                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                        });
//                    });
//
//                    getGMT(function (timestamp) {
//                        var currentPhase = getCurrentPhase();
//                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_SHOW_FEEDBACK, time: timestamp});
//                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                    });
//
//                    peerConnection.sendMessage(MESSAGE_TRIGGER_FEEDBACK, {triggeredFeedback: triggeredFeedback});
//                }
//
//                if (transitionsLength > 0) {
//                    currentTransitionSceneIndex = 1;
////                    if (transitionsLength > 1) {
////                        $(container).find('#btn-repeat-training').addClass('disabled');
////                        $(container).find('#next-gesture, #training-done').addClass('disabled');
////                    } else {
////                        $(container).find('#btn-repeat-training').removeClass('disabled');
////                        $(container).find('#next-gesture, #training-done').removeClass('disabled');
////                    }
//                } else {
////                    $(container).find('#btn-repeat-training').addClass('disabled');
////                    $(container).find('#next-gesture, #training-done').addClass('disabled');
//                }
//
////                return false;
//            }
//
//            var leftSceneButtons = $(scenesContainer).find('#transition-scene-container').find('.btn-trigger-scene').not('.btn-primary');
////            if (leftFeedbackButtons.length === 0 || !leftSceneButtons) {
////                $(container).find('#btn-repeat-training').removeClass('disabled');
////                $(container).find('#next-gesture, #training-done').removeClass('disabled');
////                return false;
////            } else {
////                $(container).find('#btn-repeat-training').addClass('disabled');
////                $(container).find('#next-gesture, #training-done').addClass('disabled');
////            }
//
//            $(feedbackButtons).find('#waiting-indicator').addClass('hidden');
//            var feedbackLength = $(feedbackButtons).length;
//
//
//            if (transitionsLength === 1) {
//                // this scene has no follow scene
//            } else if (transitionsLength > 2) {
//                currentTransitionSceneIndex = transitionsLength + feedbackLength - leftSceneButtons.length;
//                console.log('transitionsLength', transitionsLength, 'leftSceneButtons', leftSceneButtons.length);
//                if (leftSceneButtons.length > 0) {
//                    var button = $(leftSceneButtons).first();
//                    currentWOZScene = getSceneById($(button).attr('id'));
//
//                    if (transitionsLength - 2 === leftSceneButtons.length) {
//                        $(button).addClass('btn-primary');
//
//                        if (prototypeWindow && prototypeWindow.closed !== true) {
//                            if (currentWOZScene) {
//                                getGMT(function (timestamp) {
//                                    var currentPhase = getCurrentPhase();
//                                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: currentWOZScene.id});
//                                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                                });
//                            }
//
//                            prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: currentWOZScene}, 'https://gesturenote.de');
//                        }
//                    }
//
//                    var transitionMode = $(button).attr('data-transition-mode');
//                    if (transitionMode === 'automatically') {
//                        var transitionTime = parseFloat($(button).attr('data-transition-time'));
//                        var indicator = $(button).find('#transition-indicator').removeClass('hidden');
//                        TweenMax.from(indicator, transitionTime, {width: '0px', ease: Linear.easeNone, onComplete: function () {
//                                checkTransitionScenes(scenesContainer);
//                                TweenMax.to(indicator, .4, {opacity: 0});
//                            }});
//                    }
//                } else {
//                    currentWOZScene = getSceneById($(scenesContainer).find('#follow-scene-container').find('.btn-trigger-scene').attr('id'));
//                    renderFollowScene(scenesContainer);
//                }
//            } else if (transitionsLength === 2) {
//                currentTransitionSceneIndex = transitionsLength + feedbackLength - leftSceneButtons.length;
//                currentWOZScene = getSceneById($(scenesContainer).find('#follow-scene-container').find('.btn-trigger-scene').attr('id'));
//                renderFollowScene(scenesContainer);
//            }
//
//            console.log('enable btn-repeat button', leftSceneButtons.length === 0, currentTrainingIndex < parseInt(training.repeats) - 1);
//            if ((leftSceneButtons && leftSceneButtons.length === 0) || (leftFeedbackButtons && leftFeedbackButtons.length === 0)) {
//                if (currentTrainingIndex < parseInt(training.repeats) - 1) {
//                    $(container).find('#btn-repeat-training').removeClass('hidden disabled');
//                    $(container).find('#next-gesture, #training-done').addClass('disabled');
//                } else {
//                    $(container).find('#btn-repeat-training').addClass('disabled');
//                    $(container).find('#next-gesture, #training-done').removeClass('disabled');
//                }
//            } else {
//                $(container).find('#btn-repeat-training').addClass('disabled');
//                $(container).find('#next-gesture, #training-done').addClass('disabled');
//            }
//        }
//
//        function renderFollowScene(scenesContainer) {
//
//            $(scenesContainer).find('#follow-scene-container').find('.btn-trigger-scene').addClass('btn-primary');
//            if (prototypeWindow && prototypeWindow.closed !== true) {
//                if (!previewModeEnabled && currentWOZScene) {
//                    getGMT(function (timestamp) {
//                        var currentPhase = getCurrentPhase();
//                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: currentWOZScene.id});
//                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                    });
//                }
//                console.log('check transition scenes', currentWOZScene);
//                prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: currentWOZScene}, 'https://gesturenote.de');
//            }
//        }
//
//        function renderTrainingControls(trainingData) {
//            if (trainingData) {
//                if (trainingData.transitionScenes && trainingData.transitionScenes.length > 0) {
//                    currentWOZScene = getSceneById(trainingData.transitionScenes[0].sceneId);
//                    console.log(currentWOZScene);
//                } else {
//                    currentWOZScene = null;
//                }
//
//                removeAlert($(container).find('#training'), ALERT_NO_PHASE_DATA);
//                var item = $(source).find('#trainingItem').clone().removeAttr('id');
//                $(container).find('#trainingContainer').empty().append(item);
//                item.find('#repeats .address').text(translation.repeats + ":");
//
////                if (!areThereScenes(data)) {
//                $(item).find('#btn-repeat-training').addClass('disabled');
//                item.find('#repeats .text').text(trainingData.repeats - currentTrainingIndex - 1);
////                    if (gestureTrainingStartTriggered) {
////                        $(container).find('#next-gesture, #training-done').removeClass('disabled');
////                    }
////                } else {
////                    item.find('#repeats .text').text(trainingData.repeats - currentTrainingIndex - 1);
////                }
//
//                var gesture = getGestureById(trainingData.gestureId);
//                if (parseInt(trainingData.repeats) > 0) {
////                    if (areThereScenes(data)) {
////                        $(item).find('#btn-repeat-training').removeClass('hidden');
////                    } else {
////                        if (currentTrainingIndex >= parseInt(training.repeats) - 1 && areThereScenes(data) === false) {
////                            $(item).find('#btn-repeat-training').addClass('hidden disabled');
////                            $(container).find('#next-gesture, #training-done').removeClass('disabled');
////                        } else {
////                            $(item).find('#btn-repeat-training').removeClass('hidden');
////                        }
////                    }
//
//                    $(item).find('#btn-repeat-training').unbind('click').bind('click', function (event) {
//                        event.preventDefault();
//                        if (!$(this).hasClass('disabled')) {
//                            currentTrainingIndex++;
//                            currentTransitionSceneIndex = 0;
//                            renderTrainingControls(trainingData);
//
//                            console.log(currentTrainingIndex >= parseInt(training.repeats) - 1 && areThereScenes(data) === false);
//
//
//                            if (prototypeWindow && prototypeWindow.closed !== true) {
//                                if (!previewModeEnabled) {
//                                    getGMT(function (timestamp) {
//                                        var currentPhase = getCurrentPhase();
//                                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                        if (currentWOZScene) {
//                                            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: currentWOZScene.id});
//                                        }
//                                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//
//                                    });
//                                }
//
//                                prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: currentWOZScene}, 'https://gesturenote.de');
//                            }
//                        } else {
//                            if (gestureTrainingStartTriggered) {
//                                wobble(item.find('#next-gesture, #training-done'));
//                            } else {
//                                wobble(container.find('#general'));
//                                $(document).scrollTop(0);
//                            }
//                        }
//                    });
//                }
//
//                var trigger = getTriggerById(trainingData.triggerId);
//                item.find('#trigger .address').text(translation.trigger + ":");
//                item.find('#trigger .text').text(trigger.title);
//
//                if (gesture) {
//                    renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage, null);
////                    TweenMax.from($(item).find('.previewGesture').closest('.panel'), .3, {scaleX: 0, scaleY: 0, opacity: 0});
//
//                    if (peerConnection) {
//                        $(peerConnection).unbind(MESSAGE_GESTURE_INFO_PRESENT).bind(MESSAGE_GESTURE_INFO_PRESENT, function (event) {
//                            event.preventDefault();
//                            $(container).find('#btn-quit-gesture-preview .fa').addClass('hidden');
//                            $(container).find('#btn-quit-gesture-preview').removeClass('disabled');
////                            $(container).find('.btn-trigger-scene').removeClass('disabled');
////                            $(container).find('.btn-trigger-feedback').removeClass('disabled');
//                            trainingShowGesture = false;
//                        });
//                    }
//
//                    $(item).find('#btn-show-gesture').unbind('click').bind('click', function (event) {
//                        event.preventDefault();
//                        if (!$(this).hasClass('disabled')) {
//                            var button = $(this);
//                            $(button).addClass('disabled');
//                            $(button).find('.fa').removeClass('hidden');
//                            $(container).find('.btn-trigger-scene').addClass('disabled');
//                            $(container).find('.btn-trigger-feedback').addClass('disabled');
//                            $(container).find('#btn-repeat-training').addClass('disabled');
//                            $(item).find('#btn-quit-gesture-preview').removeClass('disabled');
//
//                            if (!previewModeEnabled && peerConnection) {
//                                $(peerConnection).unbind(MESSAGE_GESTURE_INFO_CLOSED).bind(MESSAGE_GESTURE_INFO_CLOSED, function (event, payload) {
//                                    $(button).find('.fa').addClass('hidden');
//                                    $(button).removeClass('disabled');
//                                    $(container).find('.btn-trigger-scene').removeClass('disabled');
//                                    $(container).find('.btn-trigger-feedback').removeClass('disabled');
//                                    trainingShowGesture = false;
////                                    if (!areThereScenes(data)) {
////                                        $(container).find('#next-gesture, #training-done').removeClass('disabled');
////                                    }
//                                });
//
//                                getGMT(function (timestamp) {
//                                    var currentPhase = getCurrentPhase();
//                                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_GESTURE_TRAINING, gestureId: gesture.id, time: timestamp});
//                                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//
////                                    var currentPhase = getCurrentPhase();
////                                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
////                                    tempData.training.push({gestureId: gesture.id, gestureTrainingStart: timestamp});
////                                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                                });
//
//                                peerConnection.sendMessage(MESSAGE_TRAINING_TRIGGERED, {currentGestureTrainingIndex: currentGestureTrainingIndex});
//                            } else {
//
//                            }
//
//                            trainingShowGesture = true;
//                            trainingTriggered = true;
//                        } else {
//                            if (!gestureTrainingStartTriggered) {
//                                wobble(container.find('#general'));
//                                $(document).scrollTop(0);
//                            }
//                        }
//                    });
//
//                    $(item).find('#btn-quit-gesture-preview').unbind('click').bind('click', function (event) {
//                        event.preventDefault();
//                        if (!$(this).hasClass('disabled')) {
//                            var button = $(this);
//                            $(button).addClass('disabled');
//                            $(button).find('.fa').removeClass('hidden');
//
//                            if (!previewModeEnabled && peerConnection) {
//                                $(peerConnection).unbind(MESSAGE_GESTURE_INFO_CLOSED).bind(MESSAGE_GESTURE_INFO_CLOSED, function (event, payload) {
//                                    $(button).find('.fa').addClass('hidden');
//                                    $(container).find('#btn-show-gesture').removeClass('disabled');
//                                    $(container).find('#btn-show-gesture .fa').addClass('hidden');
//                                    $(container).find('.btn-trigger-scene').removeClass('disabled');
//                                    $(container).find('.btn-trigger-feedback').removeClass('disabled');
////                                    peerConnection.sendMessage(MESSAGE_TRAINING_TRIGGERED, {currentGestureTrainingIndex: currentGestureTrainingIndex});
//                                    wobble(container.find('#transition-scenes'));
////                                    if (!areThereScenes(data)) {
////                                        $(container).find('#next-gesture, #training-done').removeClass('disabled');
////                                    }
//
////                                    getGMT(function (timestamp) {
////                                        var currentPhase = getCurrentPhase();
////                                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
////                                        tempData.training.push({gestureId: gesture.id, gestureTrainingStart: timestamp});
////                                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
////                                    });
//                                });
//
//                                peerConnection.sendMessage(MESSAGE_CLOSE_GESTURE_INFO);
//                            } else {
//                                $(button).find('.fa').addClass('hidden');
//                                $(container).find('#btn-show-gesture').removeClass('disabled');
//                                $(container).find('#btn-show-gesture .fa').addClass('hidden');
//                                $(container).find('.btn-trigger-scene').removeClass('disabled');
//                                $(container).find('.btn-trigger-feedback').removeClass('disabled');
//                                wobble(container.find('#transition-scenes'));
////                                if (!areThereScenes(data)) {
////                                    $(container).find('#next-gesture, #training-done').removeClass('disabled');
////                                }
//                            }
//
//                            trainingShowGesture = false;
//                            trainingTriggered = true;
//                        } else {
//                            if (gestureTrainingStartTriggered) {
//                                wobble($(item).find('#btn-show-gesture'));
//                            } else {
//                                wobble(container.find('#general'));
//                                $(document).scrollTop(0);
//                            }
//                        }
//                    });
//                }
//
//                var hasFeedback = trainingData.feedbackId !== 'none';
//                var transitionScenes = trainingData.transitionScenes;
//                if (transitionScenes && transitionScenes.length > 0) {
//                    $(item).find('#start-scene-header').removeClass('hidden');
//                    $(item).find('#start-scene-container').removeClass('hidden');
//
//                    if (transitionScenes.length > 1) {
//                        var startItem = getWOZTransitionItem(source, transitionScenes[0], false, true);
//                        $(item).find('#start-scene-container').append(startItem);
//                        TweenMax.from(startItem, .3, {y: '-10px', opacity: 0});
//
//                        $(item).find('#follow-scene-header').removeClass('hidden');
//                        $(item).find('#follow-scene-container').removeClass('hidden');
//                        var followItem = getWOZTransitionItem(source, transitionScenes[transitionScenes.length - 1], !gestureTrainingStartTriggered, transitionScenes.length + (hasFeedback ? 1 : 0) === currentTransitionSceneIndex);
//                        $(item).find('#follow-scene-container').append(followItem);
//
//                        if (transitionScenes.length > 2) {
//                            $(item).find('#transition-scene-header').removeClass('hidden');
//                            $(item).find('#transition-scene-container').removeClass('hidden');
//                            for (var j = 1; j < transitionScenes.length - 1; j++) {
//                                var itemBetween = getWOZTransitionItem(source, transitionScenes[j], !gestureTrainingStartTriggered, j + (hasFeedback ? 1 : 0) <= currentTransitionSceneIndex);
//                                $(item).find('#transition-scene-container').append(itemBetween);
//                                if (j < transitionScenes.length - 2) {
//                                    $(item).find('#transition-scene-container').append(document.createElement('br'));
//                                }
//                                TweenMax.from(itemBetween, .3, {y: '-10px', opacity: 0, delay: (j + 1) * .1});
//                            }
//                            TweenMax.from(followItem, .3, {y: '-10px', opacity: 0, delay: (transitionScenes.length * .1) - .1});
//                        } else {
//                            TweenMax.from(followItem, .3, {y: '-10px', opacity: 0, delay: .1});
//                        }
//                    } else {
//                        var startItem = getWOZTransitionItem(source, transitionScenes[0], false, true);
//                        $(item).find('#start-scene-container').append(startItem);
//                        TweenMax.from(startItem, .3, {y: '-10px', opacity: 0});
//                    }
//
//                    if (currentTrainingIndex < parseInt(training.repeats) - 1) {
//                        $(container).find('#btn-repeat-training').removeClass('hidden');
//                    } else {
//                        $(container).find('#btn-repeat-training').addClass('disabled');
//                    }
//                }
//
//                if (gestureTrainingStartTriggered) {
//                    if (trainingTriggered && !trainingShowGesture) {
//                        $(container).find('#btn-show-gesture').removeClass('disabled');
//                    } else if (!trainingTriggered && !trainingShowGesture) {
//                        $(container).find('#btn-show-gesture').removeClass('disabled');
//                    }
//                }
//
//                if (trainingData.feedbackId !== 'none') {
//                    $(item).find('#transition-feedback-header, #transition-feedback-container').removeClass('hidden');
//                    var feedback = getFeedbackById(training.feedbackId);
//                    var feedbackButton = getWOZTransitionFeedbackItem(source, feedback, trainingData.feedbackTransitionMode, trainingData.feedbackTransitionTime, !gestureTrainingStartTriggered && !trainingPrototypeOpened, transitionScenes && transitionScenes.length > 0 && currentTransitionSceneIndex >= 1);
//                    $(item).find('#transition-feedback-container').empty().append(feedbackButton);
//                    TweenMax.from(feedbackButton, .3, {y: '-10px', opacity: 0, delay: .1});
//                }
//
//                item.find('.btn-trigger-scene, .btn-trigger-feedback').unbind('click').bind('click', {data: trainingData}, function (event) {
//                    event.preventDefault();
//                    if (!$(this).hasClass('disabled') && !$(this).hasClass('btn-primary')) {
//                        var button = $(this);
//                        $(button).closest('.root').find('#btn-trigger-woz').addClass('disabled');
//                        checkTransitionScenes($(button).closest('.root').find('#transition-scenes'));
//                    }
//                });
//
//                if (currentTrainingIndex >= parseInt(trainingData.repeats) - 1) {
//                    item.find('#btn-repeat-training').addClass('disabled');
////                    $(item).find('#next-gesture, #training-done').removeClass('disabled');
//                } else {
//                    var leftFeedbackButtons = $(item).find('#transition-feedback-container .btn-trigger-feedback').not('.btn-primary');
//                    var leftSceneButtons = $(item).find('#transition-scenes .btn-trigger-scene').not('.btn-primary');
//                    if (leftFeedbackButtons.length === 0 && leftSceneButtons.length === 0) {
//                        $(item).find('#btn-repeat-training').removeClass('disabled');
//                    }
//                }
//
//                if (currentGestureTrainingIndex >= (data.length - 1)) {
//                    $(item).find('#next-gesture').addClass('hidden');
//                    $(item).find('#training-done').removeClass('hidden');
//                }
//
//                $(item).find('#next-gesture').unbind('click').bind('click', function (event) {
//                    event.preventDefault();
//                    if (!$(this).hasClass('disabled')) {
//                        currentGestureTrainingIndex++;
//                        currentTransitionSceneIndex = 0;
//                        currentTrainingIndex = 0;
//                        trainingTriggered = false;
//                        trainingShowGesture = false;
//                        triggeredFeedback = null;
//                        Moderator.renderGestureTraining(source, container, data);
//                        $(container).find('.btn-trigger-scene').addClass('disabled');
//                        $(container).find('.btn-trigger-feedback').addClass('disabled');
//
//                        if (prototypeWindow && prototypeWindow.closed !== true) {
//                            if (!previewModeEnabled && currentWOZScene) {
//                                getGMT(function (timestamp) {
//                                    var currentPhase = getCurrentPhase();
//                                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: currentWOZScene.id});
//                                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                                });
//                            }
//
//                            prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: currentWOZScene}, 'https://gesturenote.de');
//                        }
//
////                        if (peerConnection) {
////                            var currentPhase = getCurrentPhase();
////                            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
////
////                            for (var i = 0; i < tempData.training.length; i++) {
////                                console.log(tempData.training[i], gesture.id);
////                                var trainingData = tempData.training[i];
////                                if (parseInt(tempData.training[i].gestureId) === parseInt(gesture.id)) {
////                                    getGMT(function (timestamp) {
////                                        trainingData.gestureTrainingEnd = timestamp;
////                                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
////                                    });
////                                }
////                            }
////                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
////                        }
//                    } else {
//                        if (gestureTrainingStartTriggered) {
//                            wobble($(container).find('#transition-scenes'));
//                        } else {
//                            $(document).scrollTop(0);
//                            wobble(container.find('#general'));
//                        }
//                    }
//                });
//
//                $(item).find('#training-done').unbind('click').bind('click', function (event) {
//                    event.preventDefault();
//                    if (!$(this).hasClass('disabled')) {
//                        currentPhaseStepDone = true;
//                        triggeredFeedback = null;
//                        gestureTrainingStartTriggered = false;
//                        currentGestureTrainingIndex = 0;
//                        $(container).find('#training').addClass('hidden');
//                        if (areThereScenes(data)) {
//                            $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
//                        } else {
//                            $(container).find('#btn-done-training').removeClass('hidden disabled');
//                        }
//                        $(document).scrollTop(0);
//                    } else {
//                        if (gestureTrainingStartTriggered) {
//                            wobble($(container).find('#transition-scenes'));
//                        } else {
//                            $(document).scrollTop(0);
//                            wobble(container.find('#general'));
//                        }
//                    }
//                });
//            } else {
//                appendAlert($(container).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
//            }
//        }
//
//        if (areThereScenes(data)) {
//            if (screenSharingStopped) {
//                $(container).find('#training').addClass('hidden');
//                $(container).find('#btn-open-prototype').remove();
//                $(container).find('#btn-start-screen-sharing').addClass('hidden');
//                $(container).find('#btn-stop-screen-sharing').addClass('hidden');
//                $(container).find('#btn-done-training').removeClass('hidden');
//            } else if (currentPhaseStepDone) {
//                $(container).find('#training').addClass('hidden');
//                $(container).find('#btn-open-prototype').remove();
//                $(container).find('#btn-start-screen-sharing').addClass('hidden');
//                $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
//            } else if (trainingPrototypeOpened && !gestureTrainingStartTriggered) {
//                $(container).find('#btn-open-prototype').addClass('hidden');
//                $(container).find('#btn-stop-screen-sharing').addClass('hidden');
//                $(container).find('#btn-start-screen-sharing').removeClass('hidden');
//            } else if (trainingPrototypeOpened && gestureTrainingStartTriggered) {
//                $(container).find('#btn-start-screen-sharing').addClass('hidden');
//                $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
//                $(container).find('.btn-trigger-scene').removeClass('disabled');
//                $(container).find('.btn-trigger-feedback').removeClass('disabled');
//            } else {
//                $(container).find('#btn-open-prototype').removeClass('hidden');
//            }
//        } else if (!gestureTrainingStartTriggered) {
//            container.find('#btn-start-training').removeClass('hidden');
//            container.find('#btn-repeat-training').addClass('disabled');
//        } else if (screenSharingStopped) {
//            $(container).find('#training').addClass('hidden');
//            $(container).find('#btn-open-prototype').remove();
//            $(container).find('#btn-start-screen-sharing').addClass('hidden');
//            $(container).find('#btn-stop-screen-sharing').addClass('hidden');
//            $(container).find('#btn-done-training').removeClass('hidden');
//        } else if (currentPhaseStepDone) {
//            $(container).find('#training').addClass('hidden');
//            $(container).find('#btn-open-prototype').remove();
//            $(container).find('#btn-start-screen-sharing').addClass('hidden');
//            $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
//        }
//
//        $(container).find('#btn-open-prototype').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            trainingPrototypeOpened = true;
//            wobble([container.find('#training')]);
//            $(this).addClass('hidden');
//            $(container).find('#btn-start-screen-sharing, .btn-feedback-scene').removeClass('hidden');
//            console.log(data);
//            var checkedScenes = checkSingleScene(data);
//            openPrototypeScene(currentWOZScene, checkedScenes.single);//data.training && data.training.length === 1);
//        });
//
//        $(container).find('#btn-start-screen-sharing').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                var button = $(this);
//                $(button).addClass('disabled');
//                if (!previewModeEnabled && peerConnection) {
//                    $(container).find('#btn-start-screen-sharing').find('.fa-spin').removeClass('hidden');
//
//                    peerConnection.shareScreen(function (error) {
//                        $(button).removeClass('disabled');
//                        $(container).find('#btn-start-screen-sharing').find('.fa-spin').addClass('hidden');
//                        console.error(error);
//                    }, function () {
//                        peerConnection.startScreenRecording();
//                        $(peerConnection).unbind(MESSAGE_SCREEN_SHARING_ESTABLISHED).bind(MESSAGE_SCREEN_SHARING_ESTABLISHED, function (event) {
//                            console.log(MESSAGE_SCREEN_SHARING_ESTABLISHED);
//                            event.preventDefault();
//                            $(container).find('#btn-start-screen-sharing').find('.fa-spin').addClass('hidden');
//                            enableControls();
//                        });
//
//                        getGMT(function (timestamp) {
//                            var currentPhase = getCurrentPhase();
//                            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                            tempData.startTrainingTime = timestamp;
//                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                        });
//
//                        peerConnection.sendMessage(MESSAGE_START_GESTURE_TRAINING);
//                    });
//                } else {
//                    enableControls();
//                }
//            }
//        });
//
//        function enableControls() {
//            gestureTrainingStartTriggered = true;
//            $(container).find('#btn-start-screen-sharing').addClass('hidden');
//            $(container).find('#btn-show-gesture').removeClass('disabled');
//            if (areThereScenes(data)) {
//                $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
//            }
//            $(container).find('#btn-repeat-training').addClass('disabled');
//        }
//
//        $(container).find('#btn-stop-screen-sharing').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                screenSharingStopped = true;
//                $(this).addClass('hidden');
//                $(container).find('#btn-done-training').removeClass('hidden');
//                triggeredFeedback = null;
//                trainingPrototypeOpened = false;
//                gestureTrainingStartTriggered = false;
//                currentGestureTrainingIndex = 0;
//                if (peerConnection) {
//                    peerConnection.stopShareScreen(true);
//                    peerConnection.sendMessage(MESSAGE_STOP_SCREEN_SHARING);
//                }
//
//                if (prototypeWindow) {
//                    prototypeWindow.close();
//                    prototypeWindow = null;
//                }
//            } else {
//                if (gestureTrainingStartTriggered) {
//                    wobble($(container).find('#training'));
//                } else {
//                    $(document).scrollTop(0);
//                    wobble(container.find('#general'));
//                }
//            }
//        });
//
//        $(container).find('#btn-done-training').unbind('click').bind('click', function (event) {
//            if (peerConnection) {
//                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
//            }
//            nextStep();
//        });
//
//        $(container).find('#btn-start-training').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            $(this).addClass('hidden');
//            enableControls();
////            gestureTrainingStartTriggered = true;
////            $(container).find('#btn-start-screen-sharing').addClass('hidden');
////            $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
////            $(container).find('.btn-trigger-scene').removeClass('disabled');
////            $(container).find('.btn-trigger-feedback').removeClass('disabled');
////            $(container).find('#btn-show-gesture').removeClass('disabled');
////            $(container).find('#btn-repeat-training').removeClass('disabled');
//
//            wobble([container.find('#training')]);
//            if (!previewModeEnabled && peerConnection) {
//                getGMT(function (timestamp) {
//                    var currentPhase = getCurrentPhase();
//                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                    tempData.startTrainingTime = timestamp;
//                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                });
//
//                peerConnection.sendMessage(MESSAGE_START_GESTURE_TRAINING);
//            }
//        });
//    },
//    getGestureSlideshow: function getGestureSlideshow(source, container, data) {
////        console.log('getGestureSlideshow');
//        if (!data.slideshow || data.slideshow.length === 0) {
//            return false;
//        }
//
////        if (!previewModeEnabled) {
////            var currentPhase = getCurrentPhase();
////            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
////            tempData.annotations = new Array();
////            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
////        }
//
//        // general data section
//        $(container).find('#general .headline').text(getCurrentPhase().title);
//        $(container).find('#general #description').text(data.description);
//        // slideshow section
//        Moderator.renderGestureSlide(source, container, data);
//        if (peerConnection) {
//            $(peerConnection).unbind(MESSAGE_REACTIVATE_CONTROLS).bind(MESSAGE_REACTIVATE_CONTROLS, function (event, payload) {
//                loadHTMLintoModal('custom-modal', 'externals/modal-check-gesture.php', 'modal-lg');
//            });
//        }
//
//        // observation section
//        renderObservations(data, container);
//        return container;
//    },
//    renderGestureSlide: function renderGestureSlide(source, container, data) {
//        if (currentSlideIndex > data.slideshow.length - 1) {
//            if (previewModeEnabled) {
//                renderSlide(data.slideshow.length - 1);
//            }
//
//            $(container).find('#btn-done').removeClass('disabled');
//            $(container).find('#trigger-slide').addClass('disabled');
//        } else {
//            renderSlide(currentSlideIndex);
//        }
//
//        function renderSlide(index) {
//            var slide = data.slideshow[index];
//            $(container).find('#slides .headline').text('Slide ' + (index + 1) + ' von ' + data.slideshow.length);
//            $(container).find('#slidesContainer').empty();
//            var item = $(source).find('#gestureSlideshowItem').clone().removeAttr('id');
//            $(container).find('#slidesContainer').append(item);
//            var gesture = getGestureById(slide.gestureId);
//            var trigger = getTriggerById(slide.triggerId);
//            renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage);
////            item.find('.btn-popover-gesture-preview').attr('name', gesture.id);
//            $(item).find('#responseTime').text(slide.recognitionTime + ' Sekunden');
//            var imageContainer;
//            $(item).find('#searched').text(gesture.title);
//            $(item).find('#given').text(trigger.title);
//            imageContainer = $(item).find('.right .previewGesture');
//            $(container).find('#search-gestures').removeClass('hidden');
//            if (slideshowStartTriggered) {
//                $(container).find('#btn-start-slideshow').remove();
//            } else {
//                $(item).find('#trigger-slide').addClass('disabled');
//            }
//        }
//
//        $(container).find('#btn-start-slideshow').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            slideshowStartTriggered = true;
//            slideRestarted = true;
//            $(this).remove();
//            $(container).find('#trigger-slide').removeClass('disabled');
//            wobble(container.find('#slidesContainer'));
//            if (peerConnection) {
//                peerConnection.sendMessage(MESSAGE_START_GESTURE_SLIDESHOW);
//            }
//        });
//
//        $(container).find('#trigger-slide').unbind('click').bind('click', function (event) {
////            console.log('trigger-slide');
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                slideTriggered = true;
//                slideRestarted = false;
//                $(container).find('.right').find('#btn-done, #trigger-slide').addClass('disabled');
//                if (peerConnection) {
//                    peerConnection.sendMessage(MESSAGE_TRIGGER_GESTURE_SLIDE, {currentSlideIndex: currentSlideIndex, slidesRestartCount: slidesRestartCount});
////                    getGMT(function (timestamp) {
////                        var slideData = data.slideshow[currentSlideIndex];
////                        var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
////                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_PERFORM_GESTURE, gestureId: slideData.gestureId, triggerId: slideData.triggerId, time: timestamp});
////                        setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
////
////                        
////                    });
//                }
//            } else {
//                if (slideshowStartTriggered) {
//                    wobble($(container).find('#btn-done'));
//                } else {
//                    $(document).scrollTop(0);
//                    wobble($(container).find('#btn-start-slideshow'));
//                }
//            }
//        });
//
//        $(container).find('#btn-done').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                if (peerConnection) {
//                    peerConnection.sendMessage(MESSAGE_NEXT_STEP);
//                }
//                nextStep();
//            } else {
//                if (slideshowStartTriggered) {
//                    wobble($(container).find('#trigger-slide'));
//                } else {
//                    $(document).scrollTop(0);
//                    wobble($(container).find('#btn-start-slideshow'));
//                }
//            }
//        });
//
//        if (previewModeEnabled && slideTriggered) {
//            slideTriggered = false;
//            loadHTMLintoModal('custom-modal', 'externals/modal-check-gesture.php', 'modal-lg');
//        }
//    },
//    getTriggerSlideshow: function getTriggerSlideshow(source, container, data) {
//        if (data.slideshow.length === 0) {
//            return false;
//        }
//
//        // general data section
//        $(container).find('#general .headline').text(getCurrentPhase().title);
//        $(container).find('#general #description').text(data.description);
//
//        if (slideshowStartTriggered) {
//            $(container).find('#btn-start-slideshow').remove();
//            $(container).find('#btn-done-slideshow').removeClass('hidden');
//            // done button
//            if (testerDoneTriggered) {
//                $(container).find('#btn-done-slideshow').removeClass('disabled');
//            }
//        }
//
//        $(container).find('#btn-start-slideshow').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (peerConnection) {
//                peerConnection.sendMessage(MESSAGE_START_TRIGGER_SLIDESHOW);
//                $(peerConnection).unbind(MESSAGE_UPDATE_QUESTIONNAIRE).bind(MESSAGE_UPDATE_QUESTIONNAIRE, function (event, payload) {
//                    renderSlideshowItems(payload);
//                });
//                $(peerConnection).unbind(MESSAGE_TRIGGER_SLIDESHOW_DONE).bind(MESSAGE_TRIGGER_SLIDESHOW_DONE, function (event, payload) {
//                    if (payload.selectedOptions) {
//                        renderSlideshowItems(payload.selectedOptions);
//                    }
//
//                    $(container).find('#btn-done-slideshow').removeClass('disabled');
//                });
//            }
//            slideshowStartTriggered = true;
//            $(this).remove();
//            $(container).find('#btn-done-slideshow').removeClass('hidden');
//        });
//        $(container).find('#btn-done-slideshow').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                if (!previewModeEnabled && peerConnection) {
//                    peerConnection.sendMessage(MESSAGE_NEXT_STEP);
//                }
//
//                nextStep();
//            }
//        });
//
//        // slideshow section
//        renderSlideshowItems(currentQuestionnaireAnswers);
//        function renderSlideshowItems(answers) {
//            $(container).find('.question-container').empty();
//            for (var i = 0; i < data.slideshow.length; i++) {
//                var item = $(source).find('#triggerSlideshowItem').clone().removeAttr('id');
//                $(container).find('.question-container').append(item);
//                var gesture = getGestureById(data.slideshow[i].gestureId);
//                var trigger = getTriggerById(data.slideshow[i].triggerId);
//                $(item).find('#searched').text(trigger.title);
//                $(item).find('#given').text(gesture.title);
//                $(item).find('.btn-popover-gesture-preview').attr('name', gesture.id);
//                var answer = null;
//
//                if (answers && answers.length > 0) {
//                    for (var j = 0; j < answers.length; j++) {
//                        if (parseInt(answers[j].correctTriggerId) === parseInt(trigger.id)) {
//                            answer = answers[j];
//                            break;
//                        }
//                    }
//                }
//
//                if (answer) {
//                    if (parseInt(answer.selectedId) === parseInt(trigger.id)) {
//                        item.addClass('panel-success');
//                        item.find('#answered-correct').removeClass('hidden');
//                    } else {
//                        item.addClass('panel-danger');
//                        item.find('#answered-wrong').removeClass('hidden');
//                    }
//                } else {
//                    item.find('#not-answered').removeClass('hidden');
//                }
//            }
//        }
//
//
//
//        return container;
//    },
//    getPhysicalStressTest: function getPhysicalStressTest(source, container, data) {
//        if (!data.stressTestItems || data.stressTestItems.length === 0) {
//            return false;
//        }
//
//        // general data section
//        $(container).find('#general .headline').text(getCurrentPhase().title);
//        $(container).find('#general #description').text(data.description);
//
//        // stress test controls section
//        Moderator.renderPhysicalStressTest(source, container, data);
//
//        // observation section
//        renderObservations(data, container);
//        if (!previewModeEnabled && peerConnection) {
//            $(peerConnection).unbind(MESSAGE_REACTIVATE_CONTROLS).bind(MESSAGE_REACTIVATE_CONTROLS, function (event, payload) {
//                if (currentStressTestCount >= data.stressAmount) {
//                    container.find('#btn-next-gesture').removeClass('disabled');
//                } else {
//                    Moderator.renderPhysicalStressTest(source, container, data);
//                }
//            });
//            $(peerConnection).unbind(MESSAGE_UPDATE_QUESTIONNAIRE).bind(MESSAGE_UPDATE_QUESTIONNAIRE, function (event, payload) {
//                console.log('update questionnaire for physical stress test', payload);
//                currentQuestionnaireAnswers = payload;
//                Moderator.renderPhysicalStressTestQuestionnaire(container, data, payload);
//            });
//        }
//
//        return container;
//    },
//    renderPhysicalStressTest: function renderPhysicalStressTest(source, container, data) {
//        $(container).find('#controls .headline').text(translation.gesture + " " + (currentStressTestIndex + 1) + " " + translation.of + " " + data.stressTestItems.length);
//
//        if (stressTestStartTriggered) {
//            container.find('#btn-show-gesture').removeClass('disabled');
//            container.find('#btn-start-stress-test').remove();
//        }
//
//        if (currentStressTestCount >= data.stressAmount) {
//            $(container).find('#btn-next-gesture').removeClass('disabled');
//            $(container).find('#btn-show-gesture, #btn-show-question').addClass('disabled');
//
//            if (!data.sequenceStressQuestions && !data.singleStressQuestions && data.singleStressGraphicsRating === 'none' && data.sequenceStressGraphicsRating === 'none') {
//                $(container).find('#btn-show-question').addClass('hidden');
//            } else {
//                $(container).find('#btn-show-question').removeClass('hidden');
//            }
//        } else {
//            $(container).find('#btn-next-gesture').addClass('disabled');
//
//            if (!data.singleStressQuestions && data.singleStressGraphicsRating === 'none') {
//                $(container).find('#btn-show-question').addClass('hidden');
//            }
//        }
//
//        if (currentStressTestIndex >= data.stressTestItems.length - 1) {
//            $(container).find('#btn-next-gesture .btn-text').text(translation.done);
//            $(container).find('#btn-next-gesture .fa-check').removeClass('hidden');
//            $(container).find('#btn-next-gesture #next-arrow').addClass('hidden');
//        }
//
//        var gesture = getGestureById(data.stressTestItems[currentStressTestIndex]);
//        if (gesture) {
//            renderGestureImages($(container).find('.previewGesture'), gesture.images, gesture.previewImage);
////            container.find('.btn-popover-gesture-preview').attr('name', gesture.id);
//            container.find('#stress-for .text').text(gesture.title);
//        } else {
//            container.find('.btn-popover-gesture-preview').addClass('disabled');
//        }
//
//        container.find('#repeats-left .text').text((data.stressAmount - currentStressTestCount));
//        if (stressTestGestureTriggered) {
//            if ((currentStressTestCount < data.stressAmount && !data.singleStressQuestions && data.singleStressGraphicsRating === 'none') || (currentStressTestCount >= data.stressAmount && !data.sequenceStressQuestions && data.sequenceStressGraphicsRating === 'none')) {
//                container.find('#btn-show-gesture').removeClass('disabled');
//            } else {
//                container.find('#btn-show-gesture').addClass('disabled');
//                container.find('#btn-show-question').removeClass('disabled');
//            }
//        }
//
//        container.find('#btn-start-stress-test').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            $(this).remove();
//            stressTestStartTriggered = true;
//            container.find('#btn-show-gesture').removeClass('disabled');
//            if (peerConnection) {
//                peerConnection.sendMessage(MESSAGE_START_STRESS_TEST);
//            }
//        });
//
//        container.find('#btn-show-gesture').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                $(this).addClass('disabled');
//                $(container).find('#gestures-container').addClass('hidden');
//                container.find('#btn-show-question').removeClass('disabled');
//                stressTestGestureTriggered = true;
//                stressTestQuestionsTriggered = false;
//
//                if ((currentStressTestCount < data.stressAmount && !data.singleStressQuestions && data.singleStressGraphicsRating === 'none') || (currentStressTestCount >= data.stressAmount && !data.sequenceStressQuestions && data.sequenceStressGraphicsRating === 'none')) {
//                    $(this).removeClass('disabled');
////                    currentStressTestCount++;
//
//                    if (previewModeEnabled) {
//                        Moderator.renderPhysicalStressTest(source, container, data);
//                    }
//                }
//
//                if (peerConnection) {
//                    peerConnection.sendMessage(MESSAGE_TRIGGER_STRESS_TEST_GESTURE, {count: currentStressTestCount, index: currentStressTestIndex});
//                }
//            } else {
//                if (stressTestStartTriggered) {
//                    wobble(container.find('#btn-show-question'));
//                } else {
//                    $(document).scrollTop(0);
//                    wobble(container.find('#btn-start-stress-test'));
//                }
//            }
//        });
//
//
//        if (stressTestQuestionsTriggered === true && stressTestGestureTriggered === false) {
//            Moderator.renderPhysicalStressTestQuestionnaire(container, data, currentQuestionnaireAnswers);
//            $(container).find('#gestures-container').removeClass('hidden');
//        }
//
//        container.find('#btn-show-question').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                $(this).addClass('disabled');
//                $(container).find('#btn-show-gesture').addClass('disabled');
//                stressTestQuestionsTriggered = true;
//                stressTestGestureTriggered = false;
//                currentQuestionnaireAnswers = null;
//
//                currentStressTestCount++;
//                Moderator.renderPhysicalStressTestQuestionnaire(container, data, currentQuestionnaireAnswers);
//                $(container).find('#gestures-container').removeClass('hidden');
//
//                if (peerConnection) {
//                    peerConnection.sendMessage(MESSAGE_TRIGGER_STRESS_TEST_QUESTION, {count: currentStressTestCount, index: currentStressTestIndex});
//                }
//
//                if (previewModeEnabled) {
//                    Moderator.renderPhysicalStressTest(source, container, data);
//                }
//            } else {
//                if (!stressTestStartTriggered) {
//                    $(document).scrollTop(0);
//                    wobble(container.find('#btn-start-stress-test'));
//                } else {
//                    wobble(container.find('#btn-show-gesture'));
//                }
//            }
//        });
//
//        container.find('#btn-next-gesture').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                $(this).addClass('disabled');
//                $(container).find('#gestures-container').addClass('hidden');
//
//                if (currentStressTestIndex >= data.stressTestItems.length - 1) {
//                    if (peerConnection) {
//                        peerConnection.sendMessage(MESSAGE_NEXT_STEP);
//                    }
//
//                    nextStep();
//                } else {
//                    currentStressTestIndex++;
//                    currentStressTestCount = 0;
//
//                    if (peerConnection) {
//                        peerConnection.sendMessage(MESSAGE_TRIGGER_NEXT_STRESS_TEST_GESTURE, {count: currentStressTestCount, index: currentStressTestIndex});
//                    }
//
//                    stressTestQuestionsTriggered = false;
//                    stressTestGestureTriggered = false;
//                    Moderator.renderPhysicalStressTest(source, container, data);
//                }
//            } else {
//                if (!stressTestStartTriggered) {
//                    $(document).scrollTop(0);
//                    wobble(container.find('#btn-start-stress-test'));
//                } else {
//                    wobble(container.find('#btn-show-gesture, #btn-show-question'));
//                }
//            }
//        });
//    },
//    renderPhysicalStressTestQuestionnaire: function renderPhysicalStressTestQuestionnaire(container, studyData, resultsData) {
//        console.log('renderPhysicalStressTestQuestionnaire', resultsData);
//        var currentStressTestData = studyData.stressTestItems[currentStressTestIndex];
//        var gesture = getGestureById(currentStressTestData);
//        var item = $('#item-container-moderator').find('#physicalStressTest-item').clone().removeAttr('id');
//        container.find('#gestures-container').empty().append(item);
//        renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage);
//        $(item).find('#gesture .address').text(translation.gesture + ': ');
//        $(item).find('#gesture .text').text(gesture.title);
//        $(item).find('#trigger .address').text(translation.trigger + ': ');
//        $(item).find('#trigger .text').text(trigger.title);
//        $(item).find('#selection .address').text(translation.trigger + ' ' + translation.answer + ': ');
//
//        console.log(studyData, currentStressTestData);
//
//        // single joint section
//        var singleStressGraphicsRating = studyData.singleStressGraphicsRating;
//        if (singleStressGraphicsRating && singleStressGraphicsRating !== 'none') {
//            var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
//            $(jointAnswers).insertAfter($(item).find('#headline-single-questions'));
//            if (singleStressGraphicsRating === 'hands') {
//                $(jointAnswers).find('#joint-answers-body').remove();
//                renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'single');
//            } else if (singleStressGraphicsRating === 'body') {
//                $(jointAnswers).find('#joint-answers-hands').remove();
//                renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'single');
//            } else {
//                renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'single');
//                renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'single');
//            }
//        }
//
//        // single answers section
//        var singleStressQuestionnaire = studyData.singleStressQuestions;
//        if (singleStressQuestionnaire && singleStressQuestionnaire.length > 0) {
//            $(item).find('#single-stress-answers').removeClass('hidden');
//            if (resultsData && resultsData.answers && resultsData.answers.singleAnswers && resultsData.answers.singleAnswers[0]) {
//                renderQuestionnaireAnswers($(item).find('#single-stress-answers'), singleStressQuestionnaire, {answers: resultsData.answers.singleAnswers[0].answers}, false, true);
//            } else {
//                renderQuestionnaireAnswers($(item).find('#single-stress-answers'), singleStressQuestionnaire, null, false);
//            }
//        } else {
////            if (singleStressGraphicsRating && singleStressGraphicsRating !== 'none') {
////                $(item).find('#single-stress-answers').removeClass('hidden');
////            } else {
////                $(item).find('#single-stress-answers').addClass('hidden');
////            }
//        }
//
//        // sequence answers section
//        var sequenceStressQuestionnaire = studyData.sequenceStressQuestions;
//        if (sequenceStressQuestionnaire && sequenceStressQuestionnaire.length > 0) {
//            if (currentStressTestCount >= parseInt(studyData.stressAmount)) {
//                $(item).find('#sequence-stress-answers').removeClass('hidden');
//                if (resultsData && resultsData.answers && resultsData.answers.sequenceAnswers && resultsData.answers.sequenceAnswers[0]) {
//                    renderQuestionnaireAnswers($(item).find('#sequence-stress-answers'), sequenceStressQuestionnaire, {answers: resultsData.answers.sequenceAnswers[0].answers}, false, true);
//                } else {
//                    renderQuestionnaireAnswers($(item).find('#sequence-stress-answers'), sequenceStressQuestionnaire, null, false);
//                }
//            } else {
//                $(item).find('#sequence-stress-answers').addClass('hidden');
//            }
//        } else {
//            $(item).find('#sequence-stress-answers').addClass('hidden');
//        }
//
//        if (currentStressTestCount >= parseInt(studyData.stressAmount)) {
//            $(item).find('#sequence-stress-answers').removeClass('hidden');
//
//            // sequence joint section
//            var sequenceStressGraphicsRating = studyData.sequenceStressGraphicsRating;
//            if (sequenceStressGraphicsRating && sequenceStressGraphicsRating !== 'none') {
//                var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
//                $(jointAnswers).insertAfter($(item).find('#headline-sequence-questions'));
//                if (sequenceStressGraphicsRating === 'hands') {
//                    $(jointAnswers).find('#joint-answers-body').remove();
//                    renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'sequence');
//                } else if (sequenceStressGraphicsRating === 'body') {
//                    $(jointAnswers).find('#joint-answers-hands').remove();
//                    renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'sequence');
//                } else {
//                    renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'sequence');
//                    renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'sequence');
//                }
//            }
//        }
//    },
//    getScenario: function getScenario(source, container, data) {
//        triggeredHelp, triggeredWoz = null;
//        $(container).find('#general .headline').text(getCurrentPhase().title);
//        $(container).find('#general #description').text(data.description);
//        if (!currentWOZScene) {
//            currentWOZScene = getSceneById(data.scene);
//            currentScenarioTask = data.tasks[0];
//        }
//
//        if (!previewModeEnabled) {
//            var currentPhase = getCurrentPhase();
//            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//            tempData.annotations = new Array();
//            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//        }
//
//        var checkedScenes = checkSingleScene(data.tasks);
//
//        //woz section
//        Moderator.renderWOZ(source, container, data);
//
//        // task assessment section
//        Moderator.renderTaskAssessment(source, container, data);
//
//        // help section
//        Moderator.renderHelp(source, container, data);
//
//        // observation section
//        renderObservations(data, container);
//
//        // controls handling
//        if (scenarioPrototypeOpened) {
//            Moderator.enableScenarioControls(container);
//            $(container).find('#btn-open-prototype').remove();
//            $(container).find('#btn-start-screen-sharing').removeClass('hidden');
//            $(container).find('#btn-reset-scenes').removeClass('disabled');
//        }
//
//        $(container).find('#btn-open-prototype').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            scenarioPrototypeOpened = true;
//
//            $(container).find('#btn-open-prototype').remove();
//            $(container).find('#btn-start-screen-sharing').removeClass('hidden');
//            $(container).find('#btn-reset-scenes').removeClass('disabled');
//
//            openPrototypeScene(currentWOZScene, checkedScenes.single);
//        });
//
//        $(container).find('#btn-start-screen-sharing').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                var button = $(this);
//                $(button).addClass('disabled');
//                if (!previewModeEnabled && peerConnection) {
//                    $(container).find('#btn-start-screen-sharing').find('.fa-spin').removeClass('hidden');
//                    peerConnection.shareScreen(function (error) {
//                        $(button).removeClass('disabled');
//                        $(container).find('#btn-start-screen-sharing').find('.fa-spin').addClass('hidden');
//                        console.error(error);
//                    }, function () {
//                        peerConnection.startScreenRecording();
//                        $(peerConnection).unbind(MESSAGE_SCREEN_SHARING_ESTABLISHED).bind(MESSAGE_SCREEN_SHARING_ESTABLISHED, function (event) {
//                            event.preventDefault();
//                            $(container).find('#btn-start-screen-sharing').find('.fa-spin').addClass('hidden');
//                            enableControls();
//                        });
//                        peerConnection.sendMessage(MESSAGE_START_SCENARIO);
//                    });
//                } else {
//                    if (getBrowser() !== BROWSER_FIREFOX) {
//
//                    }
//                    enableControls();
//                }
//            }
//        });
//
//        function enableControls() {
//            scenarioStartTriggered = true;
//            $(container).find('#btn-reset-scenes').click();
//            $(container).find('#btn-start-screen-sharing').addClass('hidden');
//            $(container).find('.btn-feedback-scene').removeClass('disabled');
//            $(container).find('.help-container .disabled').removeClass('disabled');
//            $(container).find('#assessment-controls-container .disabled').removeClass('disabled');
//
//            Moderator.enableScenarioControls(container);
//            wobble([container.find('#woz-controls')]);
//            $(container).find('.btn-feedback-scene').removeClass('disabled');
//        }
//
//        $(container).find('#btn-stop-screen-sharing').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                screenSharingStopped = true;
//                if (peerConnection) {
//                    peerConnection.stopShareScreen(true);
//                    peerConnection.sendMessage(MESSAGE_STOP_SCREEN_SHARING);
//                }
//                $(this).addClass('hidden');
//                $(container).find('#btn-done-scenario').removeClass('hidden');
//                clearAlerts($(container).find('#general'));
//                scenarioPrototypeOpened = false;
//                scenarioStartTriggered = false;
//                if (prototypeWindow) {
//                    prototypeWindow.close();
//                    prototypeWindow = null;
//                }
//            }
//        });
//
//        if (checkedScenes.single === true && checkedScenes.pidoco && checkedScenes.pidoco === true) {
//            $(container).find('#btn-reset-scenes').remove();
//        }
//
//        $(container).find('#btn-reset-scenes').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                currentWOZScene = getSceneById(data.scene);
//                currentScenarioTask = data.tasks[0];
//                currentScenarioTaskIndex = 0;
//                Moderator.renderWOZ(source, container, data);
//                Moderator.renderHelp(source, container, data);
//
//                if (prototypeWindow) {
//                    if (!previewModeEnabled) {
//                        getGMT(function (timestamp) {
//                            var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
////                            tempData.annotations.push({action: ACTION_REFRESH_SCENE, time: timestamp});
//                            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, scene: currentWOZScene.id, time: timestamp});
//                            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_TASK, taskId: currentScenarioTask.id, time: timestamp});
//                            setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
//                        });
//                    }
//
//                    openPrototypeScene(currentWOZScene, checkedScenes.single);
////                    prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: currentWOZScene}, 'https://gesturenote.de');
//                }
//            } else {
//                $(document).scrollTop(0);
//                wobble(container.find('#general'));
//            }
//        });
//
//        if (screenSharingStopped === true) {
//            $(container).find('#assessment-controls').addClass('hidden');
//            $(container).find('#woz-controls').addClass('hidden');
//            $(container).find('#help-controls').addClass('hidden');
//            $(container).find('#general #description').addClass('hidden');
//            $(container).find('#btn-open-prototype').addClass('hidden');
//            $(container).find('#btn-done-scenario').removeClass('hidden');
//        } else if (scenarioDone === true) {
//            $(container).find('#general').removeClass('hidden');
//            $(container).find('#assessment-controls').addClass('hidden');
//            $(container).find('#woz-controls').addClass('hidden');
//            $(container).find('#help-controls').addClass('hidden');
//            $(container).find('#general #description').addClass('hidden');
//            $(container).find('#btn-start-screen-sharing').addClass('hidden');
//            $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
//            appendAlert($(container).find('#general'), ALERT_NO_MORE_TASKS);
//        } else if (scenarioPrototypeOpened && !scenarioStartTriggered) {
//            $(container).find('#btn-reset-scenes').removeClass('disabled');
//            $(container).find('#btn-open-prototype').addClass('hidden');
//            $(container).find('#btn-stop-screen-sharing').addClass('hidden');
//            $(container).find('#btn-start-screen-sharing').removeClass('hidden');
//        } else if (scenarioPrototypeOpened && scenarioStartTriggered) {
//            $(container).find('#btn-reset-scenes').removeClass('disabled');
//            $(container).find('#btn-start-screen-sharing').addClass('hidden');
////            $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
//            $(container).find('#assessment-controls-container .disabled').removeClass('disabled');
//            $(container).find('#general #description').addClass('hidden');
//        }
//
//        $(container).find('#btn-done-scenario').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (peerConnection) {
//                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
//            }
//            nextStep();
//        });
//
//        if (!previewModeEnabled && peerConnection) {
//            $(peerConnection).unbind(MESSAGE_HELP_CLOSED).bind(MESSAGE_HELP_CLOSED, function (event, payload) {
//                $(container).find('.btn-info').removeClass('disabled');
//            });
//        }
//
//        return container;
//    },
//    initMousePositionFunctionalities: function initMousePositionFunctionalities() {
//        var shiftKeyDown = false;
//        $(window).keydown(function (event) {
//            if (event.keyCode === 16) {
//                var mouseTarget = previewModeEnabled ? $('body').find('#web-rtc-placeholder') : $('body').find('#video-caller');
//                shiftKeyDown = true;
//                console.log('shift key down', $(mouseTarget), getMainContent());
//                $(mouseTarget).on('mousemove', function (event) {
//                    if (shiftKeyDown === true) {
//                        var targetDimensions = {width: $(mouseTarget).width(), height: $(mouseTarget).height()};
//                        var targetOffset = $(mouseTarget).offset();
//                        var pageCoords = {x: event.pageX, y: event.pageY};
//                        var relPosX = Math.max(0, Math.min(1, (pageCoords.x - targetOffset.left) / targetDimensions.width));
//                        var relPosY = Math.max(0, Math.min(1, (pageCoords.y - targetOffset.top) / targetDimensions.height));
////                        console.log(relPosX, relPosY);
//                        showCursor(mouseTarget, CURSOR_CROSSHAIR);
//                        if (continuousMouseManipluationGesture) {
//                            sendContinuousPosition(continuousMouseManipluationGesture, null, relPosX, relPosY);
//                        } else {
//                            sendContinuousPosition('', PIDOCO_TYPE_MOUSE_SIMULATION, relPosX, relPosY);
//                        }
//
//
//                        $(mouseTarget).on('click', function () {
//                            if (continuousMouseManipluationGesture) {
//                                sendContinuousPosition(continuousMouseManipluationGesture, null, relPosX, relPosY, true);
//                            } else {
//                                sendContinuousPosition('', PIDOCO_TYPE_MOUSE_SIMULATION, relPosX, relPosY, true);
//                            }
//                        });
//                    }
//                });
//
////                    pidocoMouseTrackingActive = true;
//                // check if previewmode is enabled and then 
//            }
//        });
//
//        $(window).keyup(function (event) {
//            var mouseTarget = previewModeEnabled ? $('body').find('#web-rtc-placeholder') : $('body').find('#video-caller');
//            if (event.keyCode === 16) {
////                var tween = $(mouseTarget).attr('data-tween');
////                tween.play();
//                shiftKeyDown = false;
////                $(mouseTarget).unbind('mousemove');
//                console.log('shift key up');
////                    pidocoMouseTrackingActive = false;
//                if ($(mouseTarget).parent().attr('id') === 'draggableRTC') {
//                    showCursor(mouseTarget, CURSOR_MOVE);
//                } else {
//                    showCursor(mouseTarget, CURSOR_DEFAULT);
//                }
//            }
//        });
//    },
//    renderWOZ: function renderWOZ(source, container, data) {
//        function checkTransitionScenes(scenesContainer) {
//
//            var transitionsLength = $(scenesContainer).find('.btn-trigger-scene').length;
//            var leftFeedbackButtons = $(scenesContainer).find('#transition-feedback-container').find('.btn-trigger-feedback').not('.btn-primary');
//            if (leftFeedbackButtons.length === 1) {
//                var feedbackButton = $(leftFeedbackButtons).first();
//                $(feedbackButton).addClass('btn-primary');
//
//                var transitionMode = $(feedbackButton).attr('data-transition-mode');
//                var feedback = getFeedbackById($(feedbackButton).attr('id'));
//                triggeredFeedback = {id: feedback.id, transitionMode: transitionMode};
//
//                if (transitionMode === 'automatically') {
//                    var transitionTime = parseFloat($(feedbackButton).attr('data-transition-time'));
//                    var indicator = $(feedbackButton).find('#transition-indicator').removeClass('hidden');
//                    triggeredFeedback.transitionTime = transitionTime;
//
//                    TweenMax.from(indicator, transitionTime, {width: '0px', ease: Linear.easeNone, onComplete: function () {
//                            $(feedbackButton).find('#waiting-indicator').removeClass('hidden');
//                            if (previewModeEnabled) {
//                                checkTransitionScenes(scenesContainer);
//                            }
//                            TweenMax.to(indicator, .4, {opacity: 0});
//                        }});
//                } else {
//                    $(feedbackButton).find('#waiting-indicator').removeClass('hidden');
//                }
//
//                if (!previewModeEnabled && peerConnection) {
//                    $(peerConnection).unbind(MESSAGE_FEEDBACK_HIDDEN).bind(MESSAGE_FEEDBACK_HIDDEN, function (event, payload) {
//                        if (transitionMode === 'automatically') {
//                            checkTransitionScenes(scenesContainer);
//                        }
//                        $(feedbackButton).find('#waiting-indicator').addClass('hidden');
//
//                        getGMT(function (timestamp) {
//                            var currentPhase = getCurrentPhase();
//                            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_HIDE_FEEDBACK, feeback: feedback, time: timestamp});
//                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                        });
//                    });
//
//                    getGMT(function (timestamp) {
//                        var currentPhase = getCurrentPhase();
//                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_SHOW_FEEDBACK, feeback: feedback, time: timestamp});
//                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                    });
//
//                    peerConnection.sendMessage(MESSAGE_TRIGGER_FEEDBACK, {triggeredFeedback: triggeredFeedback});
//                }
//
//                if (transitionsLength > 0) {
//                    currentTransitionSceneIndex = 1;
//                    if (transitionsLength > 1) {
//                        $(container).find('#btn-repeat-training').addClass('disabled');
//                    } else {
//                        $(container).find('#btn-repeat-training').removeClass('disabled');
//                    }
//                } else {
//                    $(container).find('#btn-repeat-training').addClass('disabled');
//                }
//                return false;
//            }
//
//
//            var transitionsLength = $(scenesContainer).find('.btn-trigger-scene').length;
//            if (transitionsLength === 1) {
//                // this scene has no follow scene, maybe a pidoco prototype
//                if (currentWOZScene.type === SCENE_PIDOCO) {
//                    var gestureId = $(scenesContainer).closest('.row').find('.previewGesture').attr('id');
//                    sendGesture(gestureId);
//                } else {
//                    // if scene has no follow scene and is not a pidoco prototype: delete items
//                    $(container).find('.woz-container').empty();
//                    appendAlert($(container).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
//                    Moderator.renderHelp(source, container, data);
//                }
//            } else if (transitionsLength > 2) {
//                var leftSceneButtons = $(scenesContainer).find('#transition-scene-container').find('.btn-trigger-scene').not('.btn-primary');
//                if (leftSceneButtons.length > 0) {
//                    var button = $(leftSceneButtons).first();
//                    currentWOZScene = getSceneById($(button).attr('id'));
//
//                    if (transitionsLength - 2 === leftSceneButtons.length) {
//                        $(button).addClass('btn-primary');
//                        if (prototypeWindow && prototypeWindow.closed !== true) {
//                            if (!previewModeEnabled) {
//                                getGMT(function (timestamp) {
//                                    var currentPhase = getCurrentPhase();
//                                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, scene: currentWOZScene.id, time: timestamp});
//                                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                                });
//                            }
//                            prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: currentWOZScene}, 'https://gesturenote.de');
//                        }
//                    }
//
//                    var transitionMode = $(button).attr('data-transition-mode');
//                    if (transitionMode === 'automatically') {
//                        var transitionTime = parseFloat($(button).attr('data-transition-time'));
//                        var indicator = $(button).find('#transition-indicator').removeClass('hidden');
//                        TweenMax.from(indicator, transitionTime, {width: '0px', ease: Linear.easeNone, onComplete: function () {
//                                checkTransitionScenes(scenesContainer);
//                                TweenMax.to(indicator, .4, {opacity: 0});
//                            }});
//                    }
//                } else {
//                    currentWOZScene = getSceneById($(scenesContainer).find('#follow-scene-container').find('.btn-trigger-scene').attr('id'));
//                    renderFollowScene(scenesContainer);
//                }
//            } else if (transitionsLength === 2) {
//                currentWOZScene = getSceneById($(scenesContainer).find('#follow-scene-container').find('.btn-trigger-scene').attr('id'));
//                renderFollowScene(scenesContainer);
//            }
//        }
//
//        function renderFollowScene(scenesContainer) {
//            $(scenesContainer).find('#follow-scene-container').find('.btn-trigger-scene').addClass('btn-primary');
//
//            Moderator.renderWOZ(source, container, data);
//            Moderator.renderHelp(source, container, data);
//            console.log('renderFollowScene:', currentWOZScene, prototypeWindow);
//            if (prototypeWindow && prototypeWindow.closed !== true) {
//                if (!previewModeEnabled) {
//                    getGMT(function (timestamp) {
//                        var currentPhase = getCurrentPhase();
//                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, scene: currentWOZScene.id, time: timestamp});
//                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                    });
//                }
//                prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: currentWOZScene}, 'https://gesturenote.de');
//            }
//        }
//
//        if (data.tasks && data.tasks.length > 0) {
//            var checkedScenes = checkSingleScene(data.tasks);
//            $(container).find('#assessment-controls #task').text(currentScenarioTask.task);
//            $(container).find('#assessment-controls .headline').text(translation.task + ' ' + (currentScenarioTaskIndex + 1) + ' ' + translation.of + ' ' + data.tasks.length)
//
//            if (currentScenarioTask.woz) {
//                var wozData = getWOZItemsForSceneId(currentScenarioTask.woz, currentWOZScene.id);
//                console.log('woz data', wozData, currentWOZScene);
//                removeAlert($(container).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
//                $(container).find('.woz-container').empty();
//                if (wozData && wozData.length > 0) {
//
//                    for (var i = 0; i < wozData.length; i++) {
//                        var transitionScenes = wozData[i].transitionScenes;
//                        var item = $(source).find('#wozItemWithScenes').clone().removeAttr('id');
//                        $(container).find('.woz-container').append(item);
//
//                        if (transitionScenes.length > 1) {
//                            var startItem = getWOZTransitionItem(source, transitionScenes[0], false, true);
//                            $(item).find('#start-scene-container').append(startItem);
//                            TweenMax.from(startItem, .3, {y: '-10px', opacity: 0});
//
//                            $(item).find('#follow-scene-header').removeClass('hidden');
//                            $(item).find('#follow-scene-container').removeClass('hidden');
//                            var followItem = getWOZTransitionItem(source, transitionScenes[transitionScenes.length - 1], true, false);
//                            $(item).find('#follow-scene-container').append(followItem);
//
//                            if (transitionScenes.length > 2) {
//                                $(item).find('#transition-scene-header').removeClass('hidden');
//                                $(item).find('#transition-scene-container').removeClass('hidden');
//                                for (var j = 1; j < transitionScenes.length - 1; j++) {
//                                    var itemBetween = getWOZTransitionItem(source, transitionScenes[j], true, false);
//                                    $(item).find('#transition-scene-container').append(itemBetween);
//                                    if (j < transitionScenes.length - 2) {
//                                        $(item).find('#transition-scene-container').append(document.createElement('br'));
//                                    }
//                                    TweenMax.from(itemBetween, .3, {y: '-10px', opacity: 0, delay: (i + 1) * .1});
//                                }
//                                TweenMax.from(followItem, .3, {y: '-10px', opacity: 0, delay: (transitionScenes.length * .1) - .1});
//                            } else {
//                                TweenMax.from(followItem, .3, {y: '-10px', opacity: 0, delay: .1});
//                            }
//                        } else {
//                            // render only gesture item
//                            var startItem = getWOZTransitionItem(source, transitionScenes[0], false, true);
//                            $(item).find('#start-scene-container').append(startItem);
//                            TweenMax.from(startItem, .3, {y: '-10px', opacity: 0});
//                        }
//
//                        if (wozData[i].feedbackId !== 'none') {
//                            $(item).find('#transition-feedback-header, #transition-feedback-container').removeClass('hidden');
//                            var feedback = getFeedbackById(wozData[i].feedbackId);
//                            var feedbackButton = getWOZTransitionFeedbackItem(source, feedback, wozData[i].feedbackTransitionMode, wozData[i].feedbackTransitionTime, !scenarioStartTriggered && !scenarioPrototypeOpened, false);
//                            $(item).find('#transition-feedback-container').empty().append(feedbackButton);
//                            TweenMax.from(feedbackButton, .3, {y: '-10px', opacity: 0, delay: .1});
//                        }
//
//                        var gesture = getGestureById(wozData[i].gestureId);
//                        if (gesture) {
//                            renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage, null);
//                            $(item).find('.previewGesture').attr('id', gesture.id);
//                            checkGestureUI(item, wozData[i]);
//
//                            if (gesture.type && gesture.interactionType) {
//                                item.find('.symbol-gesture-execution').addClass(gesture.type);
//                                item.find('.symbol-container-gesture-execution').attr('data-content', translation.gestureTypes[gesture.type + 's'] + ' ' + translation.gestureType);
//                                item.find('.text-gesture-execution').text(translation.gestureTypes[gesture.type + 'Short']);
//                                item.find('.symbol-gesture-interaction').addClass(gesture.interactionType);
//                                item.find('.symbol-container-gesture-interaction').attr('data-content', translation.gestureInteractionTypes[gesture.interactionType + 's'] + ' ' + translation.gestureInteraction);
//                                item.find('.text-gesture-interaction').text(translation.gestureInteractionTypes[gesture.interactionType + 'Short']);
//                            } else {
//                                item.find('.gesture-info-symbols').addClass('hidden');
//                            }
//                            initPopover();
//
//                            TweenMax.from($(item).find('.previewGesture').closest('.panel'), .3, {scaleX: 0, scaleY: 0, opacity: 0});
//
//
//
//                        }
//
//                        item.find('#btn-trigger-woz, .btn-trigger-woz').unbind('click').bind('click', {wozData: wozData[i]}, function (event) {
//                            event.preventDefault();
//                            var button = $(this);
//                            if (!$(button).hasClass('disabled')) {
//                                $(button).addClass('disabled');
//                                checkTransitionScenes($(button).closest('.root').find('#transition-scenes'));
//                            } else {
//                                if (!scenarioStartTriggered) {
//                                    $(document).scrollTop(0);
//                                    wobble(container.find('#general'));
//                                }
//                            }
//                        });
//
//                        item.find('.btn-trigger-scene, .btn-trigger-feedback').unbind('click').bind('click', {wozData: wozData[i]}, function (event) {
//                            event.preventDefault();
//                            if (!$(this).hasClass('disabled') && !$(this).hasClass('btn-primary')) {
//                                var button = $(this);
//                                $(button).closest('.root').find('#btn-trigger-woz').addClass('disabled');
//                                checkTransitionScenes($(button).closest('.root').find('#transition-scenes'));
//                            }
//                        });
//
//                        if (scenarioPrototypeOpened) {
//                            $(item).find('.disabled').removeClass('disabled');
//                        }
//                    }
//                } else {
//                    appendAlert($(container).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
//                }
//            }
//        } else {
//            appendAlert($(container).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
//        }
//    },
//    renderHelp: function renderHelp(source, container, data) {
//        var helpData = filterHelpDataForCurrentTask(data.help, currentScenarioTask.id, currentWOZScene.id);
//        $(container).find('.help-container').empty();
//        removeAlert($(container).find('#help-controls'), ALERT_NO_PHASE_DATA);
//
//        if (helpData && helpData.length > 0) {
//
//            for (var i = 0; i < helpData.length; i++) {
//                var item = $(source).find('#helpItem').clone();
//                item.removeAttr('id');
//                item.find('.help-title').text((i + 1) + ". " + helpData[i].option);
//                $(container).find('.help-container').append(item);
//                item.find('#offer-help').unbind('click').bind('click', {helpData: helpData[i]}, function (event) {
//                    event.preventDefault();
//                    if (!$(this).hasClass('disabled')) {
//                        triggeredHelp = event.data.helpData;
//                        if (peerConnection) {
//                            peerConnection.sendMessage(MESSAGE_TRIGGER_HELP, {help: triggeredHelp});
//                            $(container).find('.btn-info').addClass('disabled');
//
//                            getGMT(function (timestamp) {
//                                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_REQUEST_HELP, time: timestamp});
//                                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
//                            });
//                        }
//                    } else {
//                        if (!scenarioStartTriggered) {
//                            $(document).scrollTop(0);
//                            wobble(container.find('#general'));
//                        }
//                    }
//                });
//                if (helpData[i].useGestureHelp === true || helpData[i].useGestureHelp === 'true') {
//                    var gesture = getGestureById(helpData[i].gestureId);
//                    item.find('.btn-popover-gesture-preview').removeClass('hidden');
//                    item.find('.btn-popover-gesture-preview').attr('name', gesture.id);
//                } else {
//                    item.find('.btn-popover-gesture-preview').remove();
//                }
//
//                if (scenarioPrototypeOpened && scenarioStartTriggered) {
//                    item.find('#offer-help').removeClass('disabled');
//                }
//            }
//        } else {
//            appendAlert($(container).find('#help-controls'), ALERT_NO_PHASE_DATA);
//        }
//    },
//    renderTaskAssessment: function renderTaskAssessment(source, container, data) {
//        if (!$.isEmptyObject(data.taskAssessments)) {
//            for (var assessment in data.taskAssessments) {
//                var assessmentButton = document.createElement('button');
//                $(assessmentButton).attr('data-trigger', data.taskAssessments[assessment].trigger);
//                $(assessmentButton).attr('data-assessment-id', assessment);
//                $(assessmentButton).html("<span style='color: " + translation.annotationColors[data.taskAssessments[assessment].annotationColor].hex + "'>&#9679;</span> " + data.taskAssessments[assessment].title);
//                $(assessmentButton).addClass('btn btn-default btn-shadow disabled btn-assessment');
//                $(assessmentButton).css({marginRight: '6px', marginBottom: '6px'});
//                $(container).find('#assessment-controls-container').append(assessmentButton);
//            }
//
//            function checkAssessment(trigger) {
//                switch (trigger) {
//                    case 'nextTask':
//                        if (currentScenarioTaskIndex < data.tasks.length - 1) {
//                            currentScenarioTaskIndex++;
//                            currentScenarioTask = data.tasks[currentScenarioTaskIndex];
////                            console.log(currentScenarioTask);
//                            currentWOZScene = getSceneById(currentScenarioTask.woz[0].transitionScenes[0].sceneId);
//                            Moderator.renderWOZ(source, container, data);
//                            Moderator.renderHelp(source, container, data);
//                        } else {
//                            $(container).find('#general').removeClass('hidden');
//                            $(container).find('#assessment-controls').addClass('hidden');
//                            $(container).find('#woz-controls').addClass('hidden');
//                            $(container).find('#help-controls').addClass('hidden');
//                            appendAlert($(container).find('#general'), ALERT_NO_MORE_TASKS);
//                            $(document).scrollTop(0);
//                            scenarioDone = true;
//                            $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
//                        }
//                        break;
//                    case 'nextStep':
//                        $(container).find('#assessment-controls').addClass('hidden');
//                        $(container).find('#woz-controls').addClass('hidden');
//                        $(container).find('#help-controls').addClass('hidden');
//                        appendAlert($(container).find('#general'), ALERT_NO_MORE_TASKS);
//                        $(document).scrollTop(0);
//                        scenarioDone = true;
//                        break;
//                }
//            }
//
//            $(container).find('#assessment-controls-container .btn-assessment').unbind('click').bind('click', function (event) {
//                event.preventDefault();
//                if (!$(this).hasClass('disabled')) {
//                    var trigger = $(this).attr('data-trigger');
//                    var assessmentId = $(this).attr('data-assessment-id');
//
//                    if (!previewModeEnabled) {
//                        getGMT(function (timestamp) {
//                            var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_ASSESSMENT, assessmentId: assessmentId, taskId: currentScenarioTask.id, time: timestamp});
//                            checkAssessment(trigger);
//                            if (scenarioDone === false) {
//                                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_TASK, taskId: currentScenarioTask.id, time: timestamp});
//                            }
//                            setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
//                        });
//                    } else {
//                        checkAssessment(trigger);
//                    }
//                } else {
//                    $(document).scrollTop(0);
//                    wobble(container.find('#general'));
//                }
//            });
//        } else {
//            appendAlert($(container).find('#assessment-controls'), ALERT_NO_PHASE_DATA);
//        }
//    },
//    enableScenarioControls: function enableScenarioControls(container) {
//        $(container).find('#general #description').closest('.read-aloud').remove();
//        $(container).find('#general').addClass('hidden');
//
//        var wozItems = $(container).find('.woz-container .disabled');
//        wozItems.removeClass('disabled');
//
//        var sliders = $(container).find('.woz-container #continuous-slider');
//        $(sliders).slider('enable');
//
//        var helpItems = $(container).find('.help-container .disabled');
//        helpItems.removeClass('disabled');
//    },
//    getIdentification: function getIdentification(source, container, data) {
//        // general data section
//        removeLocalItem(ELICITED_GESTURES);
//        $(container).find('#general .headline').text(getCurrentPhase().title);
//        $(container).find('#general #description').text(data.description);
//        if (data.identificationFor === 'gestures') {
//            $(container).find('#search-gestures').removeClass('hidden');
//        } else {
//            $(container).find('#search-trigger').removeClass('hidden');
//        }
//
//        if (data.identification.length === 0) {
//            return false;
//        }
//
//        if (!previewModeEnabled) {
//            var currentPhase = getCurrentPhase();
//            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//            tempData.annotations = [];
//            if (data.identificationFor === 'gestures') {
//                tempData.gestures = [];
//            } else if (data.identificationFor === 'trigger') {
//                tempData.trigger = [];
//            }
//            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//        }
//
//        // slideshow section
//        Moderator.renderIdentification(source, container, data);
//
//        // observation section
//        renderObservations(data, container);
//        return container;
//    },
//    renderIdentification: function renderIdentification(source, container, data) {
//        gestureRecorder = null;
//
//        renderIdentificationItem(source, container, data);
//        function renderIdentificationItem(source, container, data) {
//            $(container).find('#slides .headline').text(translation.formats.identification.text + " " + (currentIdentificationIndex + 1) + " " + translation.of + " " + data.identification.length);
//            if (data.identification && data.identification.length > 0) {
//                var item = $(source).find('#identificationItem-' + data.identificationFor).clone().removeAttr('id');
//                $(container).find('#identificationContainer').empty().append(item);
//                if (data.identificationFor === 'gestures') {
//                    renderIdentificationForGesturesItem(item, container, data);
//                } else {
//                    renderIdentificationForTriggerItem(item, container, data);
//                }
//            }
//
//            $(item).find('#btn-done').unbind('click').bind('click', function (event) {
//                event.preventDefault();
//                if (!$(this).hasClass('disabled')) {
//                    currentPhaseStepDone = true;
//                    $(this).addClass('hidden');
//
//                    $(container).find('#slides').addClass('hidden');
//                    $(container).find('#identified-gesture, #identified-trigger').addClass('hidden');
//                    wobble([container.find('#general')]);
//                    $(document).scrollTop(0);
//
//                    if (data.identification[currentIdentificationIndex].transitionScenes && data.identification[currentIdentificationIndex].transitionScenes.length > 0) {
//                        $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
//                    } else {
//                        if (peerConnection) {
//                            peerConnection.sendMessage(MESSAGE_NEXT_STEP);
//                        }
//                        nextStep();
//                    }
//                } else if (!identificationStartTriggered) {
//                    wobble([container.find('#slides')]);
//                }
//            });
//        }
//
//        if (data.identification[currentIdentificationIndex].transitionScenes && data.identification[currentIdentificationIndex].transitionScenes.length > 0) {
//            if (screenSharingStopped) {
//                $(container).find('#slides').addClass('hidden');
//                $(container).find('#identified-gesture, #identified-trigger').addClass('hidden');
//                $(container).find('#btn-open-prototype').remove();
//                $(container).find('#btn-start-screen-sharing').addClass('hidden');
//                $(container).find('#btn-stop-screen-sharing').addClass('hidden');
//                $(container).find('#btn-done-identification').removeClass('hidden');
//            } else if (currentPhaseStepDone) {
//                $(container).find('#slides').addClass('hidden');
//                $(container).find('#identified-gesture, #identified-trigger').addClass('hidden');
//                $(container).find('#btn-open-prototype').remove();
//                $(container).find('#btn-start-screen-sharing').addClass('hidden');
//                $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
//            } else if (identificationPrototypeOpened && !identificationStartTriggered) {
//                $(container).find('#btn-open-prototype').addClass('hidden');
//                $(container).find('#btn-start-screen-sharing').removeClass('hidden');
//            } else if (identificationPrototypeOpened && identificationStartTriggered) {
//                $(container).find('#btn-open-prototype').remove();
//                $(container).find('#btn-start-screen-sharing').addClass('hidden');
//                $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
//                $(container).find('.btn-trigger-scene, .btn-reset-scene').removeClass('disabled');
//            } else if (!identificationStartTriggered && !identificationPrototypeOpened) {
//                $(container).find('#btn-open-prototype').removeClass('hidden');
//            }
//        } else {
//            if (!identificationStartTriggered) {
//                $(container).find('#btn-start-elicitation').removeClass('hidden');
//            }
//        }
//
//        function renderGestureRecorder(recordedData) {
//            $(container).find('#file-transfer-loader').addClass('hidden');
//
//            if (!previewModeEnabled) {
//
//                $(container).find('#btn-done, #btn-next-trigger').addClass('disabled');
//                var gestureRecorderContent = $('#item-container-gesture-recorder').find('#gesture-recorder-without-introductions').clone().removeAttr('id');
//                $(gestureRecorderContent).find('#gesture-recorder-nav').remove();
//                container.find('#gesture-recorder-container').empty().append(gestureRecorderContent).removeClass('hidden');
//
//                var options = {
//                    recorderTarget: gestureRecorderContent,
//                    saveGesture: !previewModeEnabled,
//                    allowRerecordGesture: false,
//                    allowDeletingGesture: false,
//                    ownerId: getLocalItem(STUDY).studyOwner,
//                    userId: getLocalItem(STUDY).testerId,
//                    source: SOURCE_GESTURE_TESTER,
//                    context: data.identification[currentIdentificationIndex].context,
//                    checkType: true,
//                    checkInteractionType: true,
//                    startState: GR_STATE_PLAYBACK,
//                    usedStates: [GR_STATE_PLAYBACK, GR_STATE_SAVE, GR_STATE_SAVE_SUCCESS, GR_STATE_DELETE_SUCCESS],
//                    initRecorders: [],
//                    showRecutButton: true
//                };
//
//                for (var i = 0; i < recordedData.length; i++) {
//                    var tempOptions = recordedData[i];
//                    tempOptions.autoplayPlayback = true;
//                    tempOptions.autoplaySave = true;
//                    tempOptions.autoplaySaveSuccess = true;
//                    if (recordedData[i].type === TYPE_RECORD_LEAP) {
//                        tempOptions.previewOnly = true;
//                    }
//                    options.initRecorders.push(tempOptions);
//                }
//
//                gestureRecorder = new GestureRecorder(options);
//
//                $(gestureRecorder).unbind(GR_EVENT_SAVE_SUCCESS).bind(GR_EVENT_SAVE_SUCCESS, function (event, gesture) {
//                    $(container).find('#btn-done, #btn-next-trigger').removeClass('disabled');
//                    event.preventDefault();
//
//                    var currentPhase = getCurrentPhase();
//                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                    var triggerId = data.identification[currentIdentificationIndex].triggerId;
//                    tempData.gestures.push({id: gesture.id, triggerId: triggerId});
//                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//
//                    initRerecordingButton(gestureRecorder, gesture.id);
//                });
//
//                initRerecordingButton(gestureRecorder, null);
//            } else {
//                var dummyImage = document.createElement('img');
//                $(dummyImage).attr('src', translation.gestureRecorderDummyURL);
//                $(dummyImage).css({maxWidth: '672px', width: '100%'});
//                container.find('#gesture-recorder-container').empty().append(dummyImage).removeClass('hidden');
//                container.find('#gesture-recorder-container').addClass('text-center');
//
//                $(container).find('#btn-done, #btn-next-trigger').removeClass('disabled');
//                initRerecordingButton();
//
////                var gestureRecorderPlaceholder = $('#item-container-gesture-recorder').find('#gesture-recorder-without-introductions').clone().removeAttr('id');
////                container.find('#gesture-recorder-container').empty().append(gestureRecorderPlaceholder).removeClass('hidden');
////                container.find('#gesture-recorder-container .gr-playback').removeClass('hidden');
////                $(gestureRecorderPlaceholder).find('#gesture-recorder-nav').remove();
////                renderBodyJoints(gestureRecorderPlaceholder.find('#human-body'));
//
//                appendAlert(container, ALERT_PREVIEW_DUMMY);
//            }
//        }
//
//        function startGestureRecording() {
//            if (data.identification[currentIdentificationIndex].transitionScenes && data.identification[currentIdentificationIndex].transitionScenes.length > 0) {
//                $(container).find('#transition-scenes').addClass('hidden');
//            }
//
//            getGMT(function (timestamp) {
//                var identificationData = data.identification[currentIdentificationIndex];
//                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_PERFORM_GESTURE_IDENTIFICATION, triggerId: identificationData.triggerId, time: timestamp});
//                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
//                peerConnection.sendMessage(MESSAGE_START_RECORDING_GESTURE);
//            });
//        }
//
//        function initRerecordingButton(gestureRecorder, gestureId) {
//            $(container).find('#btn-start-gesture-rerecording').unbind('click').bind('click', function (event) {
//                if (!$(this).hasClass('disabled')) {
//                    $(this).addClass('hidden');
//                    if (gestureRecorder) {
//                        if (gestureId) {
//                            $(gestureRecorder).unbind(GR_EVENT_DELETE_SUCCESS).bind(GR_EVENT_DELETE_SUCCESS, function (event, gestureId) {
//                                event.preventDefault();
//                                console.log('delete success');
//                                gestureRecorder.destroy();
//                                gestureRecorder = null;
//
//                                var currentPhase = getCurrentPhase();
//                                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                var gestures = new Array();
//                                for (var i = 0; i < tempData.gestures.length; i++) {
//                                    if (parseInt(tempData.gestures[i].id) !== parseInt(gestureId)) {
//                                        gestures.push(tempData.gestures[i]);
//                                    }
//                                }
//                                tempData.gestures = gestures;
//                                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//
//                                $(container).find('#btn-done, #btn-next-trigger').removeClass('disabled');
//                                $(container).find('#file-transfer-loader').addClass('hidden');
//                                $(container).find('#identified-gesture').addClass('hidden');
//                                $(container).find('#gesture-recorder-container').addClass('hidden');
//                                $(container).find('#btn-stop-gesture-recording').removeClass('hidden');
//                                $(container).find('#btn-next-trigger, #btn-done').addClass('hidden');
//
//                                if (peerConnection) {
//                                    startGestureRecording();
//                                }
//                            });
//
//                            deleteLastRecordedGesture(gestureId);
//                        } else {
//                            gestureRecorder.destroy();
//                            gestureRecorder = null;
//
//                            $(container).find('#btn-done, #btn-next-trigger').removeClass('disabled');
//                            $(container).find('#file-transfer-loader').addClass('hidden');
//                            $(container).find('#identified-gesture').addClass('hidden');
//                            $(container).find('#gesture-recorder-container').addClass('hidden');
//                            $(container).find('#btn-stop-gesture-recording').removeClass('hidden');
//                            $(container).find('#btn-next-trigger, #btn-done').addClass('hidden');
//
//
//                            if (peerConnection) {
//                                startGestureRecording();
//                            }
//                        }
//                    } else {
//                        removeAlert(container, ALERT_PREVIEW_DUMMY);
//                        $(container).find('#btn-done, #btn-next-trigger').removeClass('disabled');
//                        $(container).find('#file-transfer-loader').addClass('hidden');
//                        $(container).find('#identified-gesture').addClass('hidden');
//                        $(container).find('#gesture-recorder-container').addClass('hidden');
//                        $(container).find('#btn-stop-gesture-recording').removeClass('hidden');
//                        $(container).find('#btn-next-trigger, #btn-done').addClass('hidden');
//                        identificationRecordingStartTriggered = true;
//                        identificationRecordingStopTriggered = false;
//
//                        if (peerConnection) {
//                            startGestureRecording();
//                        }
//                    }
//                } else {
//                    $(document).scrollTop(0);
//                    wobble([container.find('#general')]);
//                }
//            });
//        }
//
//        function renderSceneTriggerItems(item, container, data) {
//            if (data.identification[currentIdentificationIndex] && data.identification[currentIdentificationIndex].transitionScenes) {
//                for (var i = 0; i < data.identification[currentIdentificationIndex].transitionScenes.length; i++) {
//                    var scene = getSceneById(data.identification[currentIdentificationIndex].transitionScenes[i].sceneId);
//                    var transitionItem = $(source).find('#transition-scene-item').clone().attr('id', scene.id);
//                    var itemData = $(source).find('#interactive-scenes-catalog-thumbnail').clone().removeAttr('id');
//                    $(itemData).find('#info-' + scene.type).removeClass('hidden');
//                    $(itemData).find('.btn-text').text(scene.title);
//                    $(itemData).find('.scene-description').text(data.identification[currentIdentificationIndex].transitionScenes[i].description);
//                    $(transitionItem).find('.scene-data').append(itemData);
//                    $(item).find('#transition-scenes').append(transitionItem);
//                    $(item).find('#transition-scenes').append(document.createElement('br'));
//                    if ((currentIdentificationScene > 0 && i === currentIdentificationScene) || (currentIdentificationScene === 0 && i === 0)) {
//                        $(transitionItem).find('.btn-trigger-scene').addClass('btn-primary');
//                        $(transitionItem).find('.scene-description').removeClass('hidden');
//                    }
//
//                    $(itemData).find('.btn-trigger-scene').unbind('click').bind('click', {scene: scene, index: i}, function (event) {
//                        if (!$(this).hasClass('btn-primary') && !$(this).hasClass('disabled')) {
//                            $(this).closest('.root').find('.btn-trigger-scene').removeClass('btn-primary');
//                            $(this).closest('.root').find('.scene-description').addClass('hidden');
//                            $(this).addClass('btn-primary');
//                            $(this).parent().parent().find('.scene-description').removeClass('hidden');
//                            currentIdentificationScene = event.data.index;
//                            openPrototypeScene(event.data.scene, data.identification.length === 1 && data.identification[currentIdentificationIndex].transitionScenes.length === 1, data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].description);
//
//                            if (identificationStartTriggered && !previewModeEnabled) {
//                                getGMT(function (timestamp) {
//                                    var currentPhase = getCurrentPhase();
//                                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                    var scene = getSceneById(data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].sceneId);
//                                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: scene.id});
//                                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                                });
//                            }
//                        }
//
//                        if ($(this).hasClass('disabled')) {
//                            $(document).scrollTop(0);
//                            wobble(container.find('#general'));
//                        }
//                    });
//                }
//
//                if (currentIdentificationIndex > 0) {
//                    $(container).find('.btn-trigger-scene').removeClass('disabled');
//                }
//            }
//        }
//
//        function renderIdentificationForGesturesItem(item, container, data) {
//            renderSceneTriggerItems(item, container, data);
//
//            $(container).find('#btn-start-gesture-recording').removeClass('hidden');
//            var searchedData = getTriggerById(data.identification[currentIdentificationIndex].triggerId);
//            $(item).find('#search-for .address').text(translation.GestureForTrigger + ':');
//            $(item).find('#search-for .text').text(searchedData.title);
//            $(item).find('.btn-popover-gesture-preview').remove();
//
//            if (!screenSharingStopped && identificationPrototypeOpened && currentIdentificationIndex > 0) {
//                $(item).find('#btn-start-gesture-recording').removeClass('disabled');
//                var scene = getSceneById(data.identification[currentIdentificationIndex].transitionScenes[0].sceneId);
//                openPrototypeScene(scene, data.identification.length === 1 && data.identification[currentIdentificationIndex].transitionScenes.length === 1, data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].description);
//
//                if (currentIdentificationIndex >= data.identification.length - 1) {
//                    $(container).find('#btn-next-trigger').remove();
//                }
//
//                if (scene && !previewModeEnabled) {
//                    getGMT(function (timestamp) {
//                        var currentPhase = getCurrentPhase();
//                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: scene.id});
//                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                    });
//                }
//            }
//
//            if (data.identification[currentIdentificationIndex].transitionScenes && data.identification[currentIdentificationIndex].transitionScenes.length > 1) {
//                $(item).find('#transition-scenes-controls').removeClass('hidden');
//            }
//
//            if (identificationStartTriggered) {
//                $(container).find('#btn-start-gesture-recording').removeClass('hidden disabled');
//
//                if (data.sensor !== 'none' && !sensorTypeBanned(data.sensor)) {
//                    $(container).find('#waiting-for-sensor').removeClass('hidden');
//                    $(container).find('#btn-stop-gesture-recording').addClass('hidden');
//                    if (identificationSensorInitialized === true) {
//                        $(container).find('#btn-start-gesture-recording').removeClass('hidden');
//                        $(container).find('#waiting-for-sensor').addClass('hidden');
//                    } else {
//                        $(container).find('#btn-start-gesture-recording').addClass('hidden');
//                    }
//                } else if (identificationRecordingStartTriggered === true) {
//                    $(container).find('#btn-start-gesture-recording').addClass('hidden');
//                    $(container).find('#btn-stop-gesture-recording').removeClass('hidden');
//                } else if (identificationRecordingStopTriggered === true) {
//                    $(container).find('#btn-start-gesture-recording').addClass('hidden');
//                    $(container).find('#btn-start-gesture-rerecording').removeClass('hidden');
//                    $(container).find('#btn-stop-gesture-recording').addClass('hidden');
//                    $(container).find('#identified-gesture').removeClass('hidden');
//                    $(container).find('#file-transfer-loader').addClass('hidden');
//                    renderGestureRecorder();
//                    initRerecordingButton(null);
//
//                    if (currentIdentificationIndex < data.identification.length - 1) {
//                        $(container).find('#btn-next-trigger').removeClass('hidden disabled');
//                    } else {
//                        $(container).find('#btn-done').removeClass('hidden disabled');
//                    }
//                }
//            }
//
//            $(item).find('#btn-start-gesture-recording').unbind('click').bind('click', function (event) {
//                if (!$(this).hasClass('disabled')) {
//                    $(this).addClass('hidden');
//                    $(container).find('#identified-gesture').addClass('hidden');
//                    $(container).find('#gesture-recorder-container').addClass('hidden');
//                    $(container).find('#btn-stop-gesture-recording').removeClass('hidden');
//                    $(container).find('#btn-next-trigger').addClass('hidden');
//                    identificationRecordingStartTriggered = true;
//                    identificationRecordingStopTriggered = false;
//
//                    if (peerConnection) {
//                        startGestureRecording();
//                    }
//                } else {
//                    $(document).scrollTop(0);
//                    wobble([container.find('#general')]);
//                }
//            });
//
//            if (data.sensor !== 'none' && !sensorTypeBanned(data.sensor) && peerConnection) {
//                $(peerConnection).unbind(MESSAGE_ALL_RECORDER_READY).bind(MESSAGE_ALL_RECORDER_READY, function (event) {
//                    event.preventDefault();
//                    console.log('all recorder ready');
//                    identificationSensorInitialized = true;
//                    $(container).find('#btn-start-gesture-recording').removeClass('disabled');
//                    $(container).find('#waiting-for-sensor').addClass('hidden');
//
//                    getGMT(function (timestamp) {
//                        var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_ALL_RECORDER_READY, time: timestamp});
//                        setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
//                    });
//                });
//
//                $(peerConnection).unbind(MESSAGE_RECORDER_LOST).bind(MESSAGE_RECORDER_LOST, function (event) {
//                    event.preventDefault();
//                    identificationSensorInitialized = false;
//                    $(container).find('#btn-start-gesture-recording').addClass('disabled');
//                    $(container).find('#waiting-for-sensor').removeClass('hidden');
//
//                    getGMT(function (timestamp) {
//                        var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RECORDER_LOST, time: timestamp});
//                        setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
//                    });
//                });
//            }
//
//            $(item).find('#btn-stop-gesture-recording').unbind('click').bind('click', function (event) {
//                event.preventDefault();
//                $(this).addClass('hidden');
//                identificationRecordingStartTriggered = false;
//                identificationRecordingStopTriggered = true;
//
//                initRerecordingButton(null);
//
//                if (!previewModeEnabled && peerConnection) {
//                    var receivedGestureData = null;
//                    var receivedWebcamRecording = null;
//
//                    $(peerConnection).unbind(EVENT_FILE_TRANSFER).bind(EVENT_FILE_TRANSFER, function (event, bytesReceived, size) {
//                        event.preventDefault();
//                        $(container).find('#identified-gesture').removeClass('hidden');
//
//                        var percent = Math.round(bytesReceived * 100 / size);
//                        console.log('transfer video file', bytesReceived, size, percent);
//                        $(container).find('#file-transfer-loading-indicator').css({width: percent + "%"});
//                        $(container).find('#file-transfer-loader').removeClass('hidden');
//                    });
//
//                    $(peerConnection).unbind(EVENT_RECEIVED_FILE).bind(EVENT_RECEIVED_FILE, function (event, file, metadata) {
//                        event.preventDefault();
//                        console.log('received video file', file, metadata, receivedGestureData);
//                        $(container).find('#btn-start-gesture-rerecording').removeClass('hidden');
//                        if (currentIdentificationIndex < data.identification.length - 1) {
//                            $(container).find('#btn-next-trigger').removeClass('hidden');
//                        } else {
//                            $(container).find('#btn-done').removeClass('hidden');
//                        }
////                        $(container).find('#file-transfer-loading-indicator').css({width: "100%"});
//                        $(container).find('#file-transfer-loader').addClass('hidden');
//
//                        if (metadata.size > 0) {
//                            receivedWebcamRecording = file;
//                            if (receivedWebcamRecording && receivedGestureData) {
//                                renderGestureRecorder(getGestureRecodingData());
//                            }
//                        } else {
//                            // error handling
//                        }
//                    });
//
//                    $(peerConnection).unbind(MESSAGE_GESTURE_DATA).bind(MESSAGE_GESTURE_DATA, function (event, payload) {
//                        event.preventDefault();
//                        console.log('gesture data received: ', receivedWebcamRecording, payload);
//                        receivedGestureData = payload;
//                        if (receivedWebcamRecording && receivedGestureData) {
//                            renderGestureRecorder(getGestureRecodingData());
//                        }
//                    });
//
//                    $(container).find('#file-transfer-loading-indicator').css({width: "0%"});
//                    $(container).find('#identified-gesture').removeClass('hidden');
//                    $(container).find('#file-transfer-loader').removeClass('hidden');
//                    peerConnection.sendMessage(MESSAGE_STOP_RECORDING_GESTURE);
//
//
//                    function getGestureRecodingData() {
//                        for (var i = 0; i < receivedGestureData.length; i++) {
//                            if (receivedGestureData[i].type === TYPE_RECORD_WEBCAM) {
//                                receivedGestureData[i].data = receivedWebcamRecording;
//                                break;
//                            }
//                        }
//                        return receivedGestureData;
//                    }
//                } else {
//                    $(container).find('#file-transfer-loader').removeClass('hidden');
//                    $(container).find('#identified-gesture').removeClass('hidden');
//                    $(container).find('#file-transfer-loading-indicator').css({width: "0%"});
//                    TweenMax.to($(container).find('#file-transfer-loading-indicator'), 2, {width: "100%", ease: Linear.easeNone, onComplete: function () {
//                            renderGestureRecorder();
//                            initRerecordingButton(null);
//                            $(container).find('#file-transfer-loader').addClass('hidden');
//                            $(container).find('#btn-start-gesture-rerecording').removeClass('hidden');
//                            if (currentIdentificationIndex < data.identification.length - 1) {
//                                $(container).find('#btn-next-trigger').removeClass('hidden disabled');
//                            } else {
//                                $(container).find('#btn-done').removeClass('hidden disabled');
//                            }
//                        }});
//                }
//            });
//
//            $(item).find('#btn-next-trigger').unbind('click').bind('click', function (event) {
//                event.preventDefault();
//                if (!$(this).hasClass('disabled')) {
//                    $(this).addClass('hidden');
//                    removeAlert(container, ALERT_PREVIEW_DUMMY);
//                    $(container).find('#identified-gesture').addClass('hidden');
//                    identificationRecordingStopTriggered = false;
//                    currentIdentificationIndex++;
//                    currentIdentificationScene = 0;
//                    resetRecorder();
//                    renderIdentificationItem(source, container, data);
//                    if (peerConnection) {
//                        peerConnection.sendMessage(MESSAGE_START_IDENTIFICATION);
//                    }
//                } else if (!identificationStartTriggered) {
//                    wobble([container.find('#general')]);
//                    $(document).scrollTop(0);
//                }
//            });
//        }
//
//        function startTriggerRecording() {
//            getGMT(function (timestamp) {
//                var identificationData = data.identification[currentIdentificationIndex];
//                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_PERFORM_TRIGGER_IDENTIFICATION, gestureId: identificationData.gestureId, time: timestamp});
//                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
//                peerConnection.sendMessage(MESSAGE_REQUEST_TRIGGER, {currentIdentificationIndex: currentIdentificationIndex});
//            });
//        }
//
//        function renderIdentificationForTriggerItem(item, container, data) {
//            renderSceneTriggerItems(item, container, data);
//
//            var searchedData = getGestureById(data.identification[currentIdentificationIndex].gestureId);
//            $(item).find('#search-for .address').text(translation.TriggerForGesture + ':');
//            $(item).find('#search-for .text').text(searchedData.title);
//            item.find('.btn-popover-gesture-preview').attr('name', searchedData.id);
//
//            if (!screenSharingStopped && identificationPrototypeOpened && currentIdentificationIndex > 0) {
//                var scene = getSceneById(data.identification[currentIdentificationIndex].transitionScenes[0].sceneId);
//                openPrototypeScene(scene, data.identification.length === 1 && data.identification[currentIdentificationIndex].transitionScenes.length === 1, data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].description);
//
//                if (currentIdentificationIndex >= data.identification.length - 1) {
//                    $(container).find('#btn-next-trigger').remove();
//                }
//            }
//
//            if (identificationStartTriggered) {
//                $(container).find('.btn-trigger-scene, .btn-reset-scene, #btn-request-trigger').removeClass('disabled');
//            }
//
//            $(item).find('#btn-request-trigger').unbind('click').bind('click', function (event) {
//                event.preventDefault();
//                if (!$(this).hasClass('disabled')) {
//                    $(this).addClass('hidden');
//                    $(container).find('#identified-trigger').removeClass('hidden');
//                    appendAlert($(container).find('#identified-trigger'), ALERT_WAITING_FOR_TESTER);
//                    identificationTriggerRequest = true;
//                    console.log('request trigger', currentIdentificationIndex);
//                    if (peerConnection) {
//                        startTriggerRecording();
//                    }
//                } else if (!identificationStartTriggered) {
//                    wobble([$(container).find('#general')]);
//                    $(document).scrollTop(0);
//                }
//            });
//
//            if (identificationTriggerRequest) {
//                identificationTriggerRequest = false;
//                clearAlerts($(container).find('#identified-trigger'));
//                $(container).find('#identified-trigger').removeClass('hidden');
//                $(item).find('#btn-request-trigger').addClass('hidden');
//                renderQuestionnaireAnswers($(container).find('#identified-trigger'), currentQuestionnaireAnswers.data, currentQuestionnaireAnswers.answers, false);
//
//                if (currentIdentificationIndex < data.identification.length - 1) {
//                    $(container).find('#btn-next-trigger').removeClass('hidden disabled');
//                } else {
//                    $(container).find('#btn-done').removeClass('hidden disabled');
//                }
//            }
//
//            if (peerConnection) {
//                $(peerConnection).unbind(MESSAGE_RESPONSE_TRIGGER).bind(MESSAGE_RESPONSE_TRIGGER, function (event, payload) {
//                    event.preventDefault();
//                    clearAlerts($(container).find('#identified-trigger'));
//                    currentQuestionnaireAnswers = payload.answers;
//                    console.log(payload.answers);
//                    renderQuestionnaireAnswers($(container).find('#identified-trigger'), payload.data, payload.answers, false);
//
//                    if (payload.saveAnswers === true) {
//                        if (currentIdentificationIndex < data.identification.length - 1) {
//                            $(container).find('#btn-next-trigger').removeClass('hidden disabled');
//                        } else {
//                            $(container).find('#btn-done').removeClass('hidden disabled');
//                        }
//
//                        var currentPhase = getCurrentPhase();
//                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                        tempData.trigger.push({gestureId: payload.gestureId, preferredTrigger: payload.answers});
//                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                    }
//                });
//            }
//
//            $(item).find('#btn-next-trigger').unbind('click').bind('click', function (event) {
//                event.preventDefault();
//                $(this).addClass('hidden');
//                $(container).find('#identified-trigger').addClass('hidden');
//                $(container).find('#identified-trigger .question-container').empty();
//                currentQuestionnaireAnswers = null;
//                currentIdentificationIndex++;
//                currentIdentificationScene = 0;
//                identificationTriggerRequest = false;
//                renderIdentificationItem(source, container, data);
//
//                if (peerConnection) {
//                    peerConnection.sendMessage(MESSAGE_START_IDENTIFICATION);
//                }
//            });
//        }
//
//        $(container).find('#btn-start-elicitation').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            $(this).remove();
//            enableControls();
//            if (peerConnection) {
//                peerConnection.sendMessage(MESSAGE_START_IDENTIFICATION);
//            }
//        });
//
//        $(container).find('#btn-open-prototype').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            var currentScene = getSceneById(data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].sceneId);
//            if (currentScene) {
//                identificationPrototypeOpened = true;
//                $(this).remove();
//                $(container).find('#btn-start-screen-sharing').removeClass('hidden');
//                openPrototypeScene(currentScene, data.identification.length === 1 && data.identification[currentIdentificationIndex].transitionScenes.length === 1, data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].description);
//            }
//        });
//
//        $(container).find('#btn-start-screen-sharing').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                var button = $(this);
//                lockButton(button, true);
//
//                if (!previewModeEnabled) {
//                    $(container).find('#btn-start-screen-sharing').find('.fa-spin').removeClass('hidden');
//                    peerConnection.shareScreen(function (error) {
//                        unlockButton(button, true);
//                        console.error('Maybe check installed extension, ERROR: ' + error);
//                    }, function () {
//                        peerConnection.startScreenRecording();
//                        $(peerConnection).unbind(MESSAGE_SCREEN_SHARING_ESTABLISHED).bind(MESSAGE_SCREEN_SHARING_ESTABLISHED, function (event) {
//                            event.preventDefault();
//                            unlockButton(button, true);
//                            enableControls();
//                        });
//                        peerConnection.sendMessage(MESSAGE_START_IDENTIFICATION);
//
//                        var currentScene = getSceneById(data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].sceneId);
//                        if (currentScene) {
//                            getGMT(function (timestamp) {
//                                var currentPhase = getCurrentPhase();
//                                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: currentScene.id});
//                                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                            });
//                        }
//                    });
//                } else {
//                    enableControls();
//                }
//            }
//        });
//
//        function enableControls() {
//            identificationStartTriggered = true;
//            wobble([container.find('#slides')]);
//            $(container).find('.btn-trigger-scene, .btn-reset-scene, #btn-request-trigger').removeClass('disabled');
//
//            if (data.sensor !== 'none' && !sensorTypeBanned(data.sensor)) {
//                if (identificationSensorInitialized === true) {
//                    $(container).find('#waiting-for-sensor').addClass('hidden');
//                    $(container).find('#btn-start-screen-sharing').removeClass('hidden');
//                    $(container).find('#btn-stop-screen-sharing').addClass('hidden');
//                } else  {
//                    $(container).find('#waiting-for-sensor').removeClass('hidden');
//                    $(container).find('#btn-start-screen-sharing').addClass('hidden');
//                    $(container).find('#btn-stop-screen-sharing').addClass('hidden');
//                }
//            } else {
//                $(container).find('#btn-start-gesture-recording').removeClass('disabled');
//            }
//
//            if (data.identification[currentIdentificationIndex].transitionScenes && data.identification[currentIdentificationIndex].transitionScenes.length > 0) {
//                $(container).find('#btn-start-screen-sharing').addClass('hidden');
//                $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
//            }
//        }
//
//        $(container).find('#btn-stop-screen-sharing').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                screenSharingStopped = true;
//                $(this).addClass('hidden');
//                $(container).find('#btn-done-identification').removeClass('hidden');
//                if (peerConnection) {
//                    peerConnection.stopShareScreen(true);
//                    peerConnection.sendMessage(MESSAGE_STOP_SCREEN_SHARING);
//                }
//                identificationPrototypeOpened = false;
//                identificationStartTriggered = false;
//                if (prototypeWindow) {
//                    prototypeWindow.close();
//                    prototypeWindow = null;
//                }
//            } else {
//                if (identificationStartTriggered) {
//                    wobble($(container).find('#slides'));
//                } else {
//                    $(document).scrollTop(0);
//                    wobble(container.find('#general'));
//                }
//            }
//        });
//
//        $(container).find('#btn-done-identification').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                if (peerConnection) {
//                    peerConnection.sendMessage(MESSAGE_NEXT_STEP);
//                }
//                nextStep();
//            }
//        });
//    },
//    getExploration: function getExploration(source, container, data) {
//        if (!data.exploration || (data.exploration && data.exploration.length === 0)) {
//            return false;
//        }
//
//        if (!previewModeEnabled) {
//            var currentPhase = getCurrentPhase();
//            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//            tempData.annotations = new Array();
//            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//        }
//
//        $(container).find('#general .headline').text(getCurrentPhase().title);
//        $(container).find('#general #description').text(data.description);
//
//        // observation section
//        renderObservations(data, container);
//        renderCurrentPhaseState();
//
//        function renderCurrentPhaseState() {
//            if (currentPhaseState === null) {
//                currentPhaseState = 'initialize';
//            }
//
//            switch (currentPhaseState) {
//                case 'initialize':
//                    renderStateInitialize();
//                    break;
//                case 'prototypeOpened':
//                    renderStatePrototypeOpened();
//                    break;
//                case 'explorationStarted':
//                    renderStateExplorationStarted();
//                    break;
//                case 'askPreferredGestures':
//                    renderStateAskPreferredGestures();
//                    break;
//                case 'askResponsePreferredGestures':
//                    renderStateAskResponsePreferredGestures();
//                    break;
//                case 'askPreferredTrigger':
//                    renderStateAskPreferredTrigger();
//                    break;
//                case 'askResponsePreferredTrigger':
//                    renderStateAskResponsePreferredTrigger();
//                    break;
//                case 'screenSharingStopped':
//                    renderStateScreenSharingStopped();
//                    break;
//            }
//        }
//
//        function renderStateInitialize() {
//            console.log('render state: ', currentPhaseState, scenesUsedForExploration(data.exploration));
//
//            if (scenesUsedForExploration(data.exploration) === true) {
//                $(container).find('#btn-start-exploration').remove();
//            } else {
//                $(container).find('#btn-open-prototype').remove();
//                $(container).find('#btn-start-screen-sharing').remove();
//            }
//
//            // open prototype window
//            $(container).find('#btn-open-prototype').unbind('click').bind('click', function (event) {
//                event.preventDefault();
//                // check if there are scenes for this exploration index
//                if (data.exploration[currentExplorationIndex].transitionScenes && data.exploration[currentExplorationIndex].transitionScenes.length > 0) {
//                    var currentScene = getSceneById(data.exploration[currentIdentificationIndex].transitionScenes[currentIdentificationScene].sceneId);
//                    if (currentScene) {
//                        openPrototypeScene(currentScene, data.exploration.length === 1 && data.exploration[currentIdentificationIndex].transitionScenes.length === 1, data.exploration[currentIdentificationIndex].transitionScenes[currentIdentificationScene].description);
//                    }
//                } else {
//                    openPrototypeScene(null, data.exploration.length === 1 && data.exploration[currentExplorationIndex].transitionScenes.length === 1, null, currentExplorationIndex);
//                }
//
//                currentPhaseState = 'prototypeOpened';
//                renderCurrentPhaseState();
//            });
//
//
//            // without screen sharing
//            $(container).find('#btn-start-exploration').unbind('click').bind('click', function (event) {
//                event.preventDefault();
//                currentPhaseState = 'explorationStarted';
//                renderCurrentPhaseState();
//            });
//        }
//
//        function renderStatePrototypeOpened() {
//            console.log('render state: ', currentPhaseState);
//
//            $(container).find('#btn-start-exploration').remove();
//            $(container).find('#btn-open-prototype').remove();
//            $(container).find('#btn-start-screen-sharing').removeClass('hidden');
//
//            $(container).find('#btn-start-screen-sharing').unbind('click').bind('click', function (event) {
//                event.preventDefault();
//                if (!$(this).hasClass('disabled')) {
//                    var button = $(this);
//                    $(button).addClass('disabled');
//
//                    if (!previewModeEnabled && peerConnection) {
//                        $(container).find('#btn-start-screen-sharing').find('.fa-spin').removeClass('hidden');
//                        peerConnection.shareScreen(function (error) {
//                            $(button).removeClass('disabled');
//                            $(container).find('#btn-start-screen-sharing').find('.fa-spin').addClass('hidden');
//                            console.warn(error);
//                        }, function () {
//                            peerConnection.startScreenRecording();
//                            $(peerConnection).unbind(MESSAGE_SCREEN_SHARING_ESTABLISHED).bind(MESSAGE_SCREEN_SHARING_ESTABLISHED, function (event) {
//                                event.preventDefault();
//                                $(container).find('#btn-start-screen-sharing').find('.fa-spin').addClass('hidden');
//                                currentPhaseState = 'explorationStarted';
//                                renderCurrentPhaseState();
//                            });
//                            peerConnection.sendMessage(MESSAGE_START_EXPLORATION);
//                        });
//                    } else {
//                        currentPhaseState = 'explorationStarted';
//                        renderCurrentPhaseState();
//                    }
//                }
//            });
//        }
//
//        function renderStateExplorationStarted() {
//            console.log('render state: ', currentPhaseState);
//
//            $(container).find('#btn-start-exploration').remove();
//            $(container).find('#btn-open-prototype').remove();
//            $(container).find('#btn-start-screen-sharing').remove();
//
//            if (data.explorationType === 'trigger') {
//                currentPreviewTrigger = null;
//                $(container).find('#identified-trigger').addClass('hidden');
//                renderExplorationForTrigger();
//                renderCurrentTriggersToShow();
//            } else if (data.explorationType === 'gestures') {
//                currentPreviewGesture = null;
//                $(container).find('#identified-gestures').addClass('hidden');
//                renderExplorationForGestures();
//                renderCurrentGesturesToShow();
//            }
//
//            enableControls();
//        }
//
//        function renderStateAskPreferredGestures() {
//            console.log('render state: ', currentPhaseState);
//            $(container).find('#btn-start-exploration').remove();
//            $(container).find('#btn-open-prototype').remove();
//            $(container).find('#slides').addClass('hidden');
//            $(container).find('#btn-request-gestures').addClass('hidden');
//            $(container).find('#identified-gestures').removeClass('hidden');
//            $(container).find('#btn-next-trigger').addClass('disabled');
//            $(container).find('#identified-gestures .question-container').empty();
//            appendAlert($(container).find('#identified-gestures'), ALERT_WAITING_FOR_TESTER);
//            currentPreviewGesture = null;
//        }
//
//        function renderStateAskResponsePreferredGestures() {
//            console.log('render state: ', currentPhaseState);
//            $(container).find('#btn-start-exploration').remove();
//            $(container).find('#btn-open-prototype').remove();
//            $(container).find('#slides').addClass('hidden');
//
//            clearAlerts($(container).find('#identified-getures'));
//            $(container).find('#identified-gestures').removeClass('hidden');
//            $(container).find('#btn-request-gestures').addClass('hidden disabled');
//
//            // render selected gestures
//            renderQuestionnaireAnswers($(container).find('#identified-gestures'), currentQuestionnaireAnswers.data, currentQuestionnaireAnswers.answers, false);
//
//            if (currentQuestionnaireAnswers.saveAnswers === true) {
//                $(container).find('#btn-next-trigger').removeClass('disabled');
//                explorationPreferredGesturesRequest = false;
//                $(container).find('#btn-next-trigger').addClass('disabled');
//            }
//
//            if (currentExplorationIndex < data.exploration.length - 1) {
//                $(container).find('#btn-next-trigger').removeClass('hidden disabled');
//            } else {
//                $(container).find('#btn-next-trigger').addClass('hidden');
//                if (scenesUsedForExploration(data.exploration) === true) {
//                    $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
//                } else {
//                    currentPhaseStepDone = true;
//                    $(container).find('#btn-done-exploration').removeClass('hidden disabled');
//                }
//            }
//        }
//
//        function renderStateAskPreferredTrigger() {
//            $(container).find('#btn-start-exploration').remove();
//            $(container).find('#btn-open-prototype').remove();
//            $(container).find('#slides').addClass('hidden');
//            $(container).find('#btn-request-gestures').addClass('hidden');
//            $(container).find('#identified-gestures').removeClass('hidden');
//            $(container).find('#btn-next-trigger').addClass('disabled');
//            $(container).find('#identified-gestures .question-container').empty();
//            appendAlert($(container).find('#identified-gestures'), ALERT_WAITING_FOR_TESTER);
//            currentPreviewTrigger = null;
//        }
//
//        function renderStateAskResponsePreferredTrigger() {
//            $(container).find('#btn-start-exploration').remove();
//            $(container).find('#btn-open-prototype').remove();
//            $(container).find('#slides').addClass('hidden');
//
//            clearAlerts($(container).find('#identified-trigger'));
//            $(container).find('#identified-trigger').removeClass('hidden');
//            $(container).find('#btn-request-trigger').addClass('hidden disabled');
//
//            // render selected trigger
//            renderQuestionnaireAnswers($(container).find('#identified-trigger'), currentQuestionnaireAnswers.data, currentQuestionnaireAnswers.answers, false);
//
//            if (currentQuestionnaireAnswers.saveAnswers === true) {
//                $(container).find('#btn-next-gesture').removeClass('disabled');
//            } else {
//                $(container).find('#btn-next-gesture').addClass('disabled');
//            }
//
//            if (currentExplorationIndex < data.exploration.length - 1) {
//                $(container).find('#btn-next-gesture').removeClass('hidden disabled');
//            } else {
//                $(container).find('#btn-next-gesture').addClass('hidden');
//                if (scenesUsedForExploration(data.exploration) === true) {
//                    $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
//                } else {
//                    $(container).find('#btn-done-exploration').removeClass('hidden disabled');
//                }
//            }
//        }
//
//        function renderStateScreenSharingStopped() {
//            console.log('render state: ', currentPhaseState);
//
//            if (prototypeWindow) {
//                prototypeWindow.close();
//                prototypeWindow = null;
//            }
//
//            $(container).find('#btn-stop-screen-sharing').remove();
//            $(container).find('#btn-done-exploration').removeClass('hidden');
//            $(container).find('#identified-gestures').addClass('hidden');
//            $(container).find('#identified-trigger').addClass('hidden');
//            $(container).find('#slides').addClass('hidden');
//        }
//
//        $(container).find('#btn-stop-screen-sharing').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                if (peerConnection) {
//                    peerConnection.stopShareScreen(true);
//                    peerConnection.sendMessage(MESSAGE_STOP_SCREEN_SHARING);
//                }
//                currentPhaseState = 'screenSharingStopped';
//                renderCurrentPhaseState();
//            } else {
//            }
//        });
//
//        $(container).find('#btn-done-exploration').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (peerConnection) {
//                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
//            }
//
//            nextStep();
//        });
//
//        // live events
//        if (peerConnection) {
//            $(peerConnection).unbind(MESSAGE_RESPONSE_PREFERRED_GESTURES).bind(MESSAGE_RESPONSE_PREFERRED_GESTURES, function (event, payload) {
//                currentQuestionnaireAnswers = {data: payload.data, answers: payload.answers, saveAnswers: payload.saveAnswers || false};
//                currentPhaseState = 'askResponsePreferredGestures';
//                renderCurrentPhaseState();
//            });
//
//            $(peerConnection).unbind(MESSAGE_RESPONSE_PREFERRED_TRIGGER).bind(MESSAGE_RESPONSE_PREFERRED_TRIGGER, function (event, payload) {
//                clearAlerts($(container).find('#identified-trigger'));
//
//                currentQuestionnaireAnswers = {data: payload.data, answers: payload.answers, saveAnswers: payload.saveAnswers || false};
//                currentPhaseState = 'askResponsePreferredTrigger';
//                renderCurrentPhaseState();
//            });
//        }
//
//
//        function renderExplorationForGestures() {
//            $(container).find('#slides .headline').text(translation.userCenteredGestureExtraction + " " + (currentExplorationIndex + 1) + " " + translation.of + " " + data.exploration.length);
//            var item;
////            if (data.askPreferredGesture === 'yes') {
////                item = $(source).find('#explorationItem-ask').clone().removeAttr('id');
////            } else {
//            item = $(source).find('#explorationItem').clone().removeAttr('id');
////            }
//
//            var searchedData = getTriggerById(data.exploration[currentExplorationIndex].triggerId);
//            $(item).find('#search-for .address').text(translation.GestureForTrigger + ':');
//            $(item).find('#search-for .text').text(searchedData.title);
//
//            $(container).find('#exploration-container').empty().append(item);
//            renderSceneTriggerItems(item, container, data);
//
//            if (currentExplorationIndex < data.exploration.length - 1) {
//                if (data.askPreferredGesture === 'yes' && explorationPrototypeOpened) {
//                    $(container).find('#btn-request-gestures').removeClass('hidden');
//                } else if (scenesUsedForExploration(data.exploration) === true && explorationPrototypeOpened) {
//                    $(container).find('#btn-next-trigger').removeClass('hidden');
//                }
//            } else {
//                $(container).find('#btn-next-trigger').addClass('hidden');
//                if (data.askPreferredGesture === 'yes') {
//                    $(container).find('#btn-request-gestures').removeClass('hidden');
//                } else {
//                    if (scenesUsedForExploration(data.exploration) === true) {
//                        $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
//                    } else {
//                        currentPhaseStepDone = true;
//                        $(container).find('#btn-done-exploration').removeClass('hidden disabled');
//                    }
//                }
//            }
//
//            if (!data.exploration[currentExplorationIndex].transitionScenes) {
//                $(item).find('.scenes-container').remove();
//            }
//        }
//
//        function renderExplorationForTrigger() {
//            $(container).find('#slides .headline').text(translation.userCenteredTriggerExtraction + " " + (currentExplorationIndex + 1) + " " + translation.of + " " + data.exploration.length);
//            var item;
////            if (data.askPreferredTrigger === 'yes') {
////                item = $(source).find('#explorationItem-trigger-ask').clone().removeAttr('id');
////            } else {
//            item = $(source).find('#explorationItem-trigger').clone().removeAttr('id');
////            }
//
//            var searchedData = getGestureById(data.exploration[currentExplorationIndex].gestureId);
////            $(item).find('#search-for .address').text(translation.TriggerForGesture + ':');
////            $(item).find('#search-for .text').text(searchedData.title);
//
//            var gestureThumbnail = $('#item-container-moderator').find('#present-gesture-item').clone().removeAttr('id');
//            $(gestureThumbnail).css({marginBottom: '10px'});
//            $(gestureThumbnail).find('.thumbnail-container').empty().append(getSimpleGestureListThumbnail(searchedData, 'simple-gesture-thumbnail', 'col-xs-12'));
//            $(gestureThumbnail).find('.btn-present-gesture').attr('data-gesture-id', searchedData.id);
//            $(gestureThumbnail).find('.btn-quite-gesture-info').attr('data-gesture-id', searchedData.id);
//            $(gestureThumbnail).find('.gesture-thumbnail').css({marginBottom: '10px'});
//            $(gestureThumbnail).insertBefore($(item).find('#assembled-trigger-container'));
//
//            if (currentPreviewGesture && parseInt(currentPreviewGesture.gesture.id) === parseInt(searchedData.id)) {
//                $(gestureThumbnail).find('.btn-present-gesture').click();
//            }
//
//            $(container).find('#exploration-container').empty().append(item);
//            renderSceneTriggerItems(item, container, data);
//
//            if (currentExplorationIndex < data.exploration.length - 1) {
//                if (data.askPreferredTrigger === 'yes') {
//                    $(container).find('#btn-request-trigger').removeClass('hidden');
//                } else {
//                    if (explorationStartTriggered) {
//                        $(container).find('#btn-next-gesture').removeClass('hidden');
//                    }
//                }
//                $(container).find('#btn-stop-screen-sharing').addClass('hidden');
//            } else {
//                $(container).find('#btn-next-gesture').remove();
//                if (data.askPreferredTrigger === 'yes') {
//                    $(container).find('#btn-request-trigger').removeClass('hidden');
//                } else {
//                    if (scenesUsedForExploration(data.exploration) === true) {
//                        $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
//                    } else {
//                        currentPhaseStepDone = true;
//                        $(container).find('#btn-done-exploration').removeClass('hidden disabled');
//                    }
//                }
//            }
//
//            if (!data.exploration[currentExplorationIndex].transitionScenes) {
//                $(item).find('.scenes-container').remove();
//            }
//        }
//
//        // scene buttons
//        function renderSceneTriggerItems(item, container, data) {
//            if (data.exploration && data.exploration[currentExplorationIndex].transitionScenes && data.exploration[currentExplorationIndex].transitionScenes.length > 0) {
//                for (var i = 0; i < data.exploration[currentExplorationIndex].transitionScenes.length; i++) {
//                    var scene = getSceneById(data.exploration[currentExplorationIndex].transitionScenes[i].sceneId);
//                    var transitionItem = $(source).find('#transition-scene-item').clone().attr('id', scene.id);
//                    var itemData = $(source).find('#interactive-scenes-catalog-thumbnail').clone().removeAttr('id');
//                    $(itemData).find('#info-' + scene.type).removeClass('hidden');
//                    $(itemData).find('.btn-text').text(scene.title);
//                    $(itemData).find('.scene-description').text(data.exploration[currentExplorationIndex].transitionScenes[i].description);
//                    $(transitionItem).find('.scene-data').append(itemData);
//                    $(item).find('#transition-scenes').append(transitionItem);
//                    $(item).find('#transition-scenes').append(document.createElement('br'));
//                    $(itemData).find('.btn-trigger-scene').removeClass('disabled');
//
//                    $(itemData).find('.btn-trigger-scene').unbind('click').bind('click', {scene: scene, index: i}, function (event) {
//                        if (!$(this).hasClass('btn-primary') && !$(this).hasClass('disabled')) {
//                            $(this).closest('.root').find('.btn-trigger-scene').removeClass('btn-primary');
//                            $(this).closest('.root').find('.scene-description').addClass('hidden');
//                            $(this).addClass('btn-primary');
//                            $(this).parent().parent().find('.scene-description').removeClass('hidden');
//                            currentExplorationScene = event.data.index;
//                            openPrototypeScene(event.data.scene, data.exploration.length === 1 && data.exploration[currentExplorationIndex].transitionScenes.length === 1, data.exploration[currentExplorationIndex].transitionScenes[currentExplorationScene].description);
//
//                            if (event.data.scene && !previewModeEnabled) {
//                                getGMT(function (timestamp) {
//                                    var currentPhase = getCurrentPhase();
//                                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: event.data.scene.id});
//                                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                                });
//                            }
//                        }
//
//                        if ($(this).hasClass('disabled')) {
//                            $(document).scrollTop(0);
//                            wobble(container.find('#general'));
//                        }
//                    });
//
//                    if ((currentExplorationScene > 0 && i === currentExplorationScene) || (currentExplorationScene === 0 && i === 0)) {
//                        $(itemData).find('.btn-trigger-scene').click();
//                        $(transitionItem).find('.btn-trigger-scene').addClass('btn-primary');
//                        $(transitionItem).find('.scene-description').removeClass('hidden');
//                    }
//                }
//            }
//        }
//
//        function scenesUsedForExploration(data) {
//            if (data && data.length > 0) {
//                for (var i = 0; i < data.length; i++) {
//                    if (data[i].transitionScenes && data[i].transitionScenes.length > 0) {
//                        return true;
//                    }
//                }
//            }
//            return false;
//        }
//
//
//
//        // gesture requestion functionalities
//
//        function renderCurrentGesturesToShow() {
//            var gesturesToShow = data.exploration[currentExplorationIndex].gestures;
//
//            if (gesturesToShow.length > 0) {
//                for (var i = 0; i < gesturesToShow.length; i++) {
//                    var gesture = getGestureById(gesturesToShow[i]);
//                    var presentItem = $('#item-container-moderator').find('#present-gesture-item').clone().removeAttr('id');
//                    $(presentItem).css({marginBottom: '10px'});
//                    $(presentItem).find('.thumbnail-container').empty().append(getSimpleGestureListThumbnail(gesture, 'simple-gesture-thumbnail', 'col-xs-12'));
//                    $(presentItem).find('.btn-present-gesture').attr('data-gesture-id', gesture.id);
//                    $(presentItem).find('.btn-quite-gesture-info').attr('data-gesture-id', gesture.id);
//                    $(presentItem).find('.gesture-thumbnail').css({marginBottom: '10px'});
//                    $(container).find('#assembled-gestures').append(presentItem);
//                    initPopover();
//
//                    if (currentPreviewGesture && parseInt(currentPreviewGesture.gesture.id) === parseInt(gesture.id)) {
//                        $(presentItem).find('.btn-present-gesture').click();
//                    }
//                }
//
//                var activePresentButton = null;
//                var activeQuitButton = null;
//                if (!previewModeEnabled && peerConnection) {
//                    $(peerConnection).unbind(MESSAGE_GESTURE_INFO_PRESENT).bind(MESSAGE_GESTURE_INFO_PRESENT, function (event) {
//                        event.preventDefault();
//                        unlockButton(activePresentButton, true);
//                        $(activePresentButton).addClass('hidden');
//                        $(activePresentButton).parent().find('.btn-quit-gesture-info').removeClass('hidden');
//                    });
//
//                    $(peerConnection).unbind(MESSAGE_GESTURE_INFO_CLOSED).bind(MESSAGE_GESTURE_INFO_CLOSED, function (event, payload) {
//                        event.preventDefault();
//                        unlockButton(activeQuitButton, true);
//                        $(activeQuitButton).addClass('hidden');
//                        $(activeQuitButton).closest('.root').find('.btn-present-gesture').removeClass('hidden disabled');
//
//                        var gestureId = payload.gestureId;
//                        if (gestureId && !previewModeEnabled) {
//                            getGMT(function (timestamp) {
//                                var currentPhase = getCurrentPhase();
//                                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_HIDE_GESTURE_INFO, time: timestamp, gestureId: gestureId});
//                                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                            });
//                        }
//                    });
//                }
//
//                initPreviewGestureButtons();
//
////                $(container).find('.btn-present-gesture').unbind('click').bind('click', function (event) {
////                    event.preventDefault();
////                    activePresentButton = $(this);
////                    activeQuitButton = $(this).parent().find('.btn-quit-gesture-info');
////                    if (!$(activePresentButton).hasClass('disabled')) {
////                        var gestureId = $(this).attr('data-gesture-id');
////                        currentPreviewGesture = {gesture: getGestureById(gestureId)};
////
////                        $(activePresentButton).closest('.root').find('.btn-present-gesture').addClass('disabled');
////                        if (!previewModeEnabled && peerConnection) {
////                            lockButton(activePresentButton, true);
////                            peerConnection.sendMessage(MESSAGE_OPEN_GESTURE_INFO, {id: gestureId});
////                        } else {
////                            $(activePresentButton).addClass('hidden');
////                            $(activePresentButton).parent().find('.btn-quit-gesture-info').removeClass('hidden');
////                        }
////
////                        if (gestureId && !previewModeEnabled) {
////                            getGMT(function (timestamp) {
////                                var currentPhase = getCurrentPhase();
////                                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
////                                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_SHOW_GESTURE_INFO, time: timestamp, gestureId: gestureId});
////                                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
////                            });
////                        }
////                    }
////                });
////
////                $(container).find('.btn-quit-gesture-info').unbind('click').bind('click', function (event) {
////                    event.preventDefault();
////                    activeQuitButton = $(this);
////                    if (!$(activeQuitButton).hasClass('disabled')) {
////                        var gestureId = $(this).attr('data-gesture-id');
////                        currentPreviewGesture = null;
////
////                        if (!previewModeEnabled && peerConnection) {
////                            lockButton(activeQuitButton, true);
////                            peerConnection.sendMessage(MESSAGE_CLOSE_GESTURE_INFO, {id: gestureId});
////                        } else {
////                            $(activeQuitButton).addClass('hidden');
////                            $(activeQuitButton).closest('.root').find('.btn-present-gesture').removeClass('hidden disabled');
////                        }
////                    }
////                });
//            }
//        }
//
//        $(container).find('#btn-request-gestures').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                currentPhaseState = 'askPreferredGestures';
//                renderCurrentPhaseState();
//
//                if (peerConnection) {
//                    peerConnection.sendMessage(MESSAGE_REQUEST_PREFERRED_GESTURES, {currentExplorationIndex: currentExplorationIndex});
//                }
//            } else {
//                wobble([$(container).find('#general')]);
//                $(document).scrollTop(0);
//            }
//        });
//
//        $(container).find('#btn-next-trigger').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                $(this).addClass('hidden');
//                currentExplorationIndex++;
//                currentExplorationScene = 0;
//                currentPhaseState = 'explorationStarted';
//                renderCurrentPhaseState();
//
//                if (peerConnection) {
//                    peerConnection.sendMessage(MESSAGE_START_EXPLORATION);
//                }
//            } else if (!explorationStartTriggered) {
//                wobble([container.find('#general')]);
//                $(document).scrollTop(0);
//            } else {
//                wobble($(container).find('#identified-gestures'));
//            }
//        });
//
//
//
//
//
//
//
//        // trigger request functionalities
//
//        function renderCurrentTriggersToShow() {
//            var triggerToShow = data.exploration[currentExplorationIndex].trigger;
//
//            if (triggerToShow.length > 0) {
//
//                for (var i = 0; i < triggerToShow.length; i++) {
//                    var trigger = getTriggerById(triggerToShow[i]);
//                    var presentItem = $('#item-container-moderator').find('#present-trigger-item').clone().removeAttr('id');
//                    $(presentItem).find('.trigger-title').text(trigger.title);
//                    $(presentItem).find('.btn-present-trigger').attr('data-trigger-id', trigger.id);
//                    $(presentItem).find('.btn-quite-trigger-info').attr('data-trigger-id', trigger.id);
//                    $(container).find('#assembled-trigger').append(presentItem);
//
//                    if (currentPreviewTrigger && parseInt(currentPreviewTrigger.id) === parseInt(trigger.id)) {
//                        $(presentItem).find('.btn-present-trigger').click();
//                    }
//                }
//
//                var activePresentButton = null;
//                var activeQuitButton = null;
//                if (!previewModeEnabled && peerConnection) {
//                    $(peerConnection).unbind(MESSAGE_TRIGGER_INFO_PRESENT).bind(MESSAGE_TRIGGER_INFO_PRESENT, function (event) {
//                        event.preventDefault();
//                        unlockButton(activePresentButton, true);
//                        $(activePresentButton).addClass('hidden');
//                        $(activePresentButton).parent().find('.btn-quit-trigger-info').removeClass('hidden');
//                    });
//
//                    $(peerConnection).unbind(MESSAGE_TRIGGER_INFO_CLOSED).bind(MESSAGE_TRIGGER_INFO_CLOSED, function (event) {
//                        event.preventDefault();
//                        unlockButton(activeQuitButton, true);
//                        $(activeQuitButton).addClass('hidden');
//                        $(activeQuitButton).closest('.root').find('.btn-present-trigger').removeClass('hidden disabled');
//
//                        var triggerId = payload.triggerId;
//                        if (gestureId && !previewModeEnabled) {
//                            getGMT(function (timestamp) {
//                                var currentPhase = getCurrentPhase();
//                                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_HIDE_TRIGGER_INFO, time: timestamp, triggerId: triggerId});
//                                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                            });
//                        }
//                    });
//                }
//
//                initPreviewGestureButtons();
//
//                $(container).find('.btn-present-trigger').unbind('click').bind('click', function (event) {
//                    event.preventDefault();
//                    activePresentButton = $(this);
//                    activeQuitButton = $(this).parent().find('.btn-quit-trigger-info');
//
//                    if (!$(activePresentButton).hasClass('disabled')) {
//                        var triggerId = $(this).attr('data-trigger-id');
//                        currentPreviewTrigger = getTriggerById(triggerId);
//
//                        $(activePresentButton).closest('.root').find('.btn-present-trigger').addClass('disabled');
//                        $(container).find('.btn-present-gesture').addClass('disabled');
//
//                        if (!previewModeEnabled && peerConnection) {
//                            lockButton(activePresentButton, true);
//                            peerConnection.sendMessage(MESSAGE_OPEN_TRIGGER_INFO, {id: triggerId});
//
//                            getGMT(function (timestamp) {
//                                var currentPhase = getCurrentPhase();
//                                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_SHOW_TRIGGER_INFO, time: timestamp, triggerId: triggerId});
//                                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                            });
//                        } else {
//                            $(activePresentButton).addClass('hidden');
//                            $(activePresentButton).parent().find('.btn-quit-trigger-info').removeClass('hidden');
//                        }
//                    }
//                });
//
//                $(container).find('.btn-quit-trigger-info').unbind('click').bind('click', function (event) {
//                    event.preventDefault();
//                    activeQuitButton = $(this);
//                    if (!$(activeQuitButton).hasClass('disabled')) {
//                        var triggerId = $(this).attr('data-trigger-id');
//                        currentPreviewTrigger = null;
//
//                        if (!previewModeEnabled && peerConnection) {
//                            lockButton(activeQuitButton, true);
//                            peerConnection.sendMessage(MESSAGE_CLOSE_TRIGGER_INFO, {id: triggerId});
//                        } else {
//                            $(activeQuitButton).addClass('hidden');
//                            $(activeQuitButton).closest('.root').find('.btn-present-trigger').removeClass('hidden disabled');
//                            $(container).find('.btn-present-gesture').removeClass('hidden disabled');
//                        }
//                    }
//                });
//            }
//        }
//
//        $(container).find('#btn-request-trigger').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                currentPhaseState = 'askPreferredTrigger';
//                renderCurrentPhaseState();
//                if (peerConnection) {
//                    peerConnection.sendMessage(MESSAGE_REQUEST_PREFERRED_TRIGGER, {currentExplorationIndex: currentExplorationIndex});
//                }
//            } else {
//                wobble([$(container).find('#general')]);
//                $(document).scrollTop(0);
//            }
//        });
//
//        $(container).find('#btn-next-gesture').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                $(this).addClass('hidden');
//                currentExplorationIndex++;
//                currentExplorationScene = 0;
//                currentPhaseState = 'explorationStarted';
//                renderCurrentPhaseState();
//
//                if (peerConnection) {
//                    peerConnection.sendMessage(MESSAGE_START_EXPLORATION);
//                }
//            } else if (!explorationStartTriggered) {
//                wobble([container.find('#general')]);
//                $(document).scrollTop(0);
//            } else {
//                wobble($(container).find('#identified-trigger'));
//            }
//        });
//
//        function initPreviewGestureButtons() {
//            var activePresentButton, activeQuitButton;
//            $(container).find('.btn-present-gesture').unbind('click').bind('click', function (event) {
//                event.preventDefault();
//                activePresentButton = $(this);
//                activeQuitButton = $(this).parent().find('.btn-quit-gesture-info');
//                if (!$(activePresentButton).hasClass('disabled')) {
//                    var gestureId = $(this).attr('data-gesture-id');
//                    currentPreviewGesture = {gesture: getGestureById(gestureId)};
//
//                    $(activePresentButton).closest('.root').find('.btn-present-gesture').addClass('disabled');
//                    $(activePresentButton).closest('.root').find('.btn-present-trigger').addClass('disabled');
//
//                    if (!previewModeEnabled && peerConnection) {
//                        lockButton(activePresentButton, true);
//                        peerConnection.sendMessage(MESSAGE_OPEN_GESTURE_INFO, {id: gestureId});
//                    } else {
//                        $(activePresentButton).addClass('hidden');
//                        $(activePresentButton).parent().find('.btn-quit-gesture-info').removeClass('hidden');
//                    }
//
//                    if (gestureId && !previewModeEnabled) {
//                        getGMT(function (timestamp) {
//                            var currentPhase = getCurrentPhase();
//                            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_SHOW_GESTURE_INFO, time: timestamp, gestureId: gestureId});
//                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                        });
//                    }
//                }
//            });
//
//            $(container).find('.btn-quit-gesture-info').unbind('click').bind('click', function (event) {
//                event.preventDefault();
//                var activeQuitButton = $(this);
//                if (!$(activeQuitButton).hasClass('disabled')) {
//                    var gestureId = $(this).attr('data-gesture-id');
//                    currentPreviewGesture = null;
//
//                    if (!previewModeEnabled && peerConnection) {
//                        lockButton(activeQuitButton, true);
//                        peerConnection.sendMessage(MESSAGE_CLOSE_GESTURE_INFO, {id: gestureId});
//                    } else {
//                        $(activeQuitButton).addClass('hidden');
//                        $(activeQuitButton).closest('.root').find('.btn-present-gesture').removeClass('hidden disabled');
//                        $(activeQuitButton).closest('.root').find('.btn-present-trigger').removeClass('hidden disabled');
//                    }
//                }
//            });
//        }
//
//
//
//
//        function enableControls() {
//            $(container).find('#slides').removeClass('hidden');
//            wobble([container.find('#slides')]);
//
//            $(container).find('.btn-trigger-scene, .btn-reset-scene').removeClass('disabled');
//
//            if (data.exploration.length === 1) {
//                if (data.askPreferredGesture === 'yes') {
//                    $(container).find('#btn-request-gestures').removeClass('hidden disabled');
//                } else if (data.askPreferredTrigger === 'yes') {
//                    $(container).find('#btn-request-trigger').removeClass('hidden disabled');
//                } else {
//
//                }
//            } else {
//                if (data.askPreferredGesture === 'yes') {
//                    $(container).find('#btn-request-gestures').removeClass('hidden disabled');
//                } else if (data.askPreferredTrigger === 'yes') {
//                    $(container).find('#btn-request-trigger').removeClass('hidden disabled');
//                } else {
//                    if (data.exploration.length > 1) {
//                        $(container).find('#btn-next-' + (data.explorationType === 'gestures' ? 'trigger' : 'gesture')).removeClass('hidden disabled');
//                    }
//                }
//            }
//        }
//
//        return container;
//    },
//    getFocusGroupInterview: function getFocusGroupInterview(source, container, data) {
//        if (!previewModeEnabled) {
//            var currentPhase = getCurrentPhase();
//            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//            tempData.annotations = new Array();
//            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//        }
//
//        $(container).find('#general .headline').text(getCurrentPhase().title);
//        $(container).find('#general #description').text(data.description);
//
//        // key questions section
//        Moderator.getQuestionnaire(source, $(container).find('#keyQuestions'), data.keyQuestions, false);
//        renderCurrentPhaseState();
//
//        function renderCurrentPhaseState() {
//            if (currentPhaseState === null) {
//                currentPhaseState = 'initialize';
//            }
//
//            switch (currentPhaseState) {
//                case 'initialize':
//                    renderStateInitialize();
//                    break;
//                case 'prototypeOpened':
//                    renderStatePrototypeOpened();
//                    break;
//                case 'focusGroupStarted':
//                    renderStateFocusGroupStarted();
//                    break;
////                case 'askPreferredGestures':
////                    renderStateAskPreferredGestures();
////                    break;
////                case 'askResponsePreferredGestures':
////                    renderStateAskResponsePreferredGestures();
////                    break;
////                case 'askPreferredTrigger':
////                    renderStateAskPreferredTrigger();
////                    break;
////                case 'askResponsePreferredTrigger':
////                    renderStateAskResponsePreferredTrigger();
////                    break;
//                case 'screenSharingStopped':
//                    renderStateScreenSharingStopped();
//                    break;
//            }
//        }
//
//        function renderStateInitialize() {
//            console.log('render state: ', currentPhaseState, scenesUsedForPhaseStep(data.scenes));
//
//            if (scenesUsedForPhaseStep(data.scenes) === true) {
//                $(container).find('#btn-start-focus-group').remove();
//
//                // open prototype window
//                $(container).find('#btn-open-prototype').unbind('click').bind('click', function (event) {
//                    event.preventDefault();
//                    // check if there are scenes for this exploration index
////                    if (data.exploration[currentExplorationIndex].transitionScenes && data.exploration[currentExplorationIndex].transitionScenes.length > 0) {
//                    var currentScene = getSceneById(data.scenes[0]);
//                    if (currentScene) {
//                        openPrototypeScene(currentScene, data.scenes.length === 1);
//                    }
////                    } else {
////                        openPrototypeScene(null, data.exploration.length === 1 && data.exploration[currentExplorationIndex].transitionScenes.length === 1, null, currentExplorationIndex);
////                    }
//
//                    currentPhaseState = 'prototypeOpened';
//                    renderCurrentPhaseState();
//                });
//            } else {
//                $(container).find('#btn-open-prototype').remove();
//                $(container).find('#btn-start-screen-sharing').remove();
//            }
//
//            // without screen sharing
//            $(container).find('#btn-start-focus-group').unbind('click').bind('click', function (event) {
//                event.preventDefault();
//                currentPhaseState = 'focusGroupStarted';
//                renderCurrentPhaseState();
//            });
//        }
//
//        function renderStatePrototypeOpened() {
//            console.log('render state: ', currentPhaseState);
//
//            $(container).find('#btn-start-exploration').remove();
//            $(container).find('#btn-open-prototype').remove();
//            $(container).find('#btn-start-screen-sharing').removeClass('hidden');
//
//            $(container).find('#btn-start-screen-sharing').unbind('click').bind('click', function (event) {
//                event.preventDefault();
//                if (!$(this).hasClass('disabled')) {
//                    var button = $(this);
//                    $(button).addClass('disabled');
//
//                    if (!previewModeEnabled && peerConnection) {
//                        $(container).find('#btn-start-screen-sharing').find('.fa-spin').removeClass('hidden');
//                        peerConnection.shareScreen(function (error) {
//                            $(button).removeClass('disabled');
//                            $(container).find('#btn-start-screen-sharing').find('.fa-spin').addClass('hidden');
//                            console.warn(error);
//                        }, function () {
//                            peerConnection.startScreenRecording();
//                            $(peerConnection).unbind(MESSAGE_SCREEN_SHARING_ESTABLISHED).bind(MESSAGE_SCREEN_SHARING_ESTABLISHED, function (event) {
//                                event.preventDefault();
//                                $(container).find('#btn-start-screen-sharing').find('.fa-spin').addClass('hidden');
//                                currentPhaseState = 'explorationStarted';
//                                renderCurrentPhaseState();
//                            });
//                            peerConnection.sendMessage(MESSAGE_START_EXPLORATION);
//                        });
//                    } else {
//                        currentPhaseState = 'focusGroupStarted';
//                        renderCurrentPhaseState();
//                    }
//                }
//            });
//        }
//
//        function renderStateFocusGroupStarted() {
//            console.log('render state: ', currentPhaseState);
//
//            $(container).find('#general').remove();
//            $(container).find('#btn-start-focus-group').remove();
//            $(container).find('#btn-open-prototype').remove();
//            $(container).find('#btn-start-screen-sharing').remove();
//
//            if (data.annotations && data.annotations.length > 0) {
//                for (var i = 0; i < data.annotations.length; i++) {
//                    var annotationButton = document.createElement('button');
//                    $(annotationButton).attr('data-assessment-id', data.annotations[i].id);
//                    $(annotationButton).html("<span style='color: " + data.annotations[i].annotationColor + "'>&#9679;</span> " + data.annotations[i].title);
//                    $(annotationButton).addClass('btn btn-default btn-shadow btn-annotation');
//                    $(annotationButton).css({marginRight: '6px', marginBottom: '6px'});
//                    $(container).find('#annotations-container').append(annotationButton);
//                }
//
//                $(container).find('#annotations-container .btn-annotation').unbind('click').bind('click', function (event) {
//                    event.preventDefault();
//                    var assessmentId = $(this).attr('data-assessment-id');
//
//                    if (!previewModeEnabled) {
//                        getGMT(function (timestamp) {
//                            var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_ASSESSMENT, assessmentId: assessmentId, taskId: currentScenarioTask.id, time: timestamp});
//                            setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
//                        });
//                    }
//                });
//
//                $(container).find('#annotation-controls').removeClass('hidden');
//                wobble([container.find('#annotation-controls')]);
//            } else {
//                // append alert
//            }
//
//
//            var hasCatalogData = false;
//            // check if there is study gestures to render
//            if (data.gestures && data.gestures.length > 0) {
//                $(container).find('#catalogs-study-gestures').removeClass('hidden');
//                hasCatalogData = true;
//                renderCatalogGestures();
//            }
//
//            // check if there is trigger to render
//            if (data.trigger && data.trigger.length > 0) {
//                $(container).find('#catalogs-trigger').removeClass('hidden');
//                hasCatalogData = true;
//            }
//
//            // check if there is scenes to render
//            if (data.scenes && data.scenes.length > 0) {
//                $(container).find('#catalogs-scenes').removeClass('hidden');
//                hasCatalogData = true;
//            }
//
//            // check if there is feedback to render
//            if (data.feedback && data.feedback.length > 0) {
//                $(container).find('#catalogs-feedback').removeClass('hidden');
//                hasCatalogData = true;
//            }
//
//            if (hasCatalogData === true) {
//                $(container).find('#catalog-data').removeClass('hidden');
//                wobble([$(container).find('#catalog-data')], true);
//            } else {
//                // append alert
//            }
//        }
//
//        function renderCatalogGestures() {
//            for (var i = 0; i < data.gestures; i++) {
//                var gesture = getGestureById(gesturesToShow[i]);
//                var presentItem = $('#item-container-moderator').find('#present-gesture-item').clone().removeAttr('id');
//                $(presentItem).css({marginBottom: '10px'});
//                $(presentItem).find('.thumbnail-container').empty().append(getSimpleGestureListThumbnail(gesture, 'simple-gesture-thumbnail', 'col-xs-12'));
//                $(presentItem).find('.btn-present-gesture').attr('data-gesture-id', gesture.id);
//                $(presentItem).find('.btn-quite-gesture-info').attr('data-gesture-id', gesture.id);
//                $(presentItem).find('.gesture-thumbnail').css({marginBottom: '10px'});
//                $(container).find('#assembled-gestures').append(presentItem);
//                initPopover();
//
//                if (currentPreviewGesture && parseInt(currentPreviewGesture.gesture.id) === parseInt(gesture.id)) {
//                    $(presentItem).find('.btn-present-gesture').click();
//                }
//            }
//
//            var activePresentButton = null;
//            var activeQuitButton = null;
//            if (!previewModeEnabled && peerConnection) {
//                $(peerConnection).unbind(MESSAGE_GESTURE_INFO_PRESENT).bind(MESSAGE_GESTURE_INFO_PRESENT, function (event) {
//                    event.preventDefault();
//                    unlockButton(activePresentButton, true);
//                    $(activePresentButton).addClass('hidden');
//                    $(activePresentButton).parent().find('.btn-quit-gesture-info').removeClass('hidden');
//                });
//
//                $(peerConnection).unbind(MESSAGE_GESTURE_INFO_CLOSED).bind(MESSAGE_GESTURE_INFO_CLOSED, function (event, payload) {
//                    event.preventDefault();
//                    unlockButton(activeQuitButton, true);
//                    $(activeQuitButton).addClass('hidden');
//                    $(activeQuitButton).closest('.root').find('.btn-present-gesture').removeClass('hidden disabled');
//
//                    var gestureId = payload.gestureId;
//                    if (gestureId && !previewModeEnabled) {
//                        getGMT(function (timestamp) {
//                            var currentPhase = getCurrentPhase();
//                            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_HIDE_GESTURE_INFO, time: timestamp, gestureId: gestureId});
//                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                        });
//                    }
//                });
//            }
//
//            initPreviewGestureButtons();
//        }
//
////        function renderStateAskPreferredGestures() {
////            console.log('render state: ', currentPhaseState);
////            $(container).find('#btn-start-exploration').remove();
////            $(container).find('#btn-open-prototype').remove();
////            $(container).find('#slides').addClass('hidden');
////            $(container).find('#btn-request-gestures').addClass('hidden');
////            $(container).find('#identified-gestures').removeClass('hidden');
////            $(container).find('#btn-next-trigger').addClass('disabled');
////            $(container).find('#identified-gestures .question-container').empty();
////            appendAlert($(container).find('#identified-gestures'), ALERT_WAITING_FOR_TESTER);
////            currentPreviewGesture = null;
////        }
////
////        function renderStateAskResponsePreferredGestures() {
////            console.log('render state: ', currentPhaseState);
////            $(container).find('#btn-start-exploration').remove();
////            $(container).find('#btn-open-prototype').remove();
////            $(container).find('#slides').addClass('hidden');
////
////            clearAlerts($(container).find('#identified-getures'));
////            $(container).find('#identified-gestures').removeClass('hidden');
////            $(container).find('#btn-request-gestures').addClass('hidden disabled');
////
////            // render selected gestures
////            renderQuestionnaireAnswers($(container).find('#identified-gestures'), currentQuestionnaireAnswers.data, currentQuestionnaireAnswers.answers, false);
////
////            if (currentQuestionnaireAnswers.saveAnswers === true) {
////                $(container).find('#btn-next-trigger').removeClass('disabled');
////                explorationPreferredGesturesRequest = false;
////                $(container).find('#btn-next-trigger').addClass('disabled');
////            }
////
////            if (currentExplorationIndex < data.exploration.length - 1) {
////                $(container).find('#btn-next-trigger').removeClass('hidden disabled');
////            } else {
////                $(container).find('#btn-next-trigger').addClass('hidden');
////                if (scenesUsedForExploration(data.exploration) === true) {
////                    $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
////                } else {
////                    currentPhaseStepDone = true;
////                    $(container).find('#btn-done-exploration').removeClass('hidden disabled');
////                }
////            }
////        }
////
////        function renderStateAskPreferredTrigger() {
////            $(container).find('#btn-start-exploration').remove();
////            $(container).find('#btn-open-prototype').remove();
////            $(container).find('#slides').addClass('hidden');
////            $(container).find('#btn-request-gestures').addClass('hidden');
////            $(container).find('#identified-gestures').removeClass('hidden');
////            $(container).find('#btn-next-trigger').addClass('disabled');
////            $(container).find('#identified-gestures .question-container').empty();
////            appendAlert($(container).find('#identified-gestures'), ALERT_WAITING_FOR_TESTER);
////            currentPreviewTrigger = null;
////        }
////
////        function renderStateAskResponsePreferredTrigger() {
////            $(container).find('#btn-start-exploration').remove();
////            $(container).find('#btn-open-prototype').remove();
////            $(container).find('#slides').addClass('hidden');
////
////            clearAlerts($(container).find('#identified-trigger'));
////            $(container).find('#identified-trigger').removeClass('hidden');
////            $(container).find('#btn-request-trigger').addClass('hidden disabled');
////
////            // render selected trigger
////            renderQuestionnaireAnswers($(container).find('#identified-trigger'), currentQuestionnaireAnswers.data, currentQuestionnaireAnswers.answers, false);
////
////            if (currentQuestionnaireAnswers.saveAnswers === true) {
////                $(container).find('#btn-next-gesture').removeClass('disabled');
////            } else {
////                $(container).find('#btn-next-gesture').addClass('disabled');
////            }
////
////            if (currentExplorationIndex < data.exploration.length - 1) {
////                $(container).find('#btn-next-gesture').removeClass('hidden disabled');
////            } else {
////                $(container).find('#btn-next-gesture').addClass('hidden');
////                if (scenesUsedForExploration(data.exploration) === true) {
////                    $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
////                } else {
////                    $(container).find('#btn-done-exploration').removeClass('hidden disabled');
////                }
////            }
////        }
//
//        function renderStateScreenSharingStopped() {
//            console.log('render state: ', currentPhaseState);
//
//            if (prototypeWindow) {
//                prototypeWindow.close();
//                prototypeWindow = null;
//            }
//
//            $(container).find('#btn-stop-screen-sharing').remove();
//            $(container).find('#btn-done-focus-group').removeClass('hidden');
////            $(container).find('#identified-gestures').addClass('hidden');
////            $(container).find('#identified-trigger').addClass('hidden');
//            $(container).find('#slides').addClass('hidden');
//        }
//
//        $(container).find('#btn-stop-screen-sharing').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                if (peerConnection) {
//                    peerConnection.stopShareScreen(true);
//                    peerConnection.sendMessage(MESSAGE_STOP_SCREEN_SHARING);
//                }
//                currentPhaseState = 'screenSharingStopped';
//                renderCurrentPhaseState();
//            } else {
//            }
//        });
//
//        $(container).find('#btn-done-focus-group').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (peerConnection) {
//                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
//            }
//
//            nextStep();
//        });
//
//        // live events
//        if (peerConnection) {
//            $(peerConnection).unbind(MESSAGE_RESPONSE_PREFERRED_GESTURES).bind(MESSAGE_RESPONSE_PREFERRED_GESTURES, function (event, payload) {
//                currentQuestionnaireAnswers = {data: payload.data, answers: payload.answers, saveAnswers: payload.saveAnswers || false};
//                currentPhaseState = 'askResponsePreferredGestures';
//                renderCurrentPhaseState();
//            });
//
//            $(peerConnection).unbind(MESSAGE_RESPONSE_PREFERRED_TRIGGER).bind(MESSAGE_RESPONSE_PREFERRED_TRIGGER, function (event, payload) {
//                clearAlerts($(container).find('#identified-trigger'));
//
//                currentQuestionnaireAnswers = {data: payload.data, answers: payload.answers, saveAnswers: payload.saveAnswers || false};
//                currentPhaseState = 'askResponsePreferredTrigger';
//                renderCurrentPhaseState();
//            });
//        }
//
//
//        function renderExplorationForGestures() {
//            $(container).find('#slides .headline').text(translation.userCenteredGestureExtraction + " " + (currentExplorationIndex + 1) + " " + translation.of + " " + data.exploration.length);
//            var item;
////            if (data.askPreferredGesture === 'yes') {
////                item = $(source).find('#explorationItem-ask').clone().removeAttr('id');
////            } else {
//            item = $(source).find('#explorationItem').clone().removeAttr('id');
////            }
//
//            var searchedData = getTriggerById(data.exploration[currentExplorationIndex].triggerId);
//            $(item).find('#search-for .address').text(translation.GestureForTrigger + ':');
//            $(item).find('#search-for .text').text(searchedData.title);
//
//            $(container).find('#exploration-container').empty().append(item);
//            renderSceneTriggerItems(item, container, data);
//
//            if (currentExplorationIndex < data.exploration.length - 1) {
//                if (data.askPreferredGesture === 'yes' && explorationPrototypeOpened) {
//                    $(container).find('#btn-request-gestures').removeClass('hidden');
//                } else if (scenesUsedForExploration(data.exploration) === true && explorationPrototypeOpened) {
//                    $(container).find('#btn-next-trigger').removeClass('hidden');
//                }
//            } else {
//                $(container).find('#btn-next-trigger').addClass('hidden');
//                if (data.askPreferredGesture === 'yes') {
//                    $(container).find('#btn-request-gestures').removeClass('hidden');
//                } else {
//                    if (scenesUsedForExploration(data.exploration) === true) {
//                        $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
//                    } else {
//                        currentPhaseStepDone = true;
//                        $(container).find('#btn-done-exploration').removeClass('hidden disabled');
//                    }
//                }
//            }
//
//            if (!data.exploration[currentExplorationIndex].transitionScenes) {
//                $(item).find('.scenes-container').remove();
//            }
//        }
//
//        function renderExplorationForTrigger() {
//            $(container).find('#slides .headline').text(translation.userCenteredTriggerExtraction + " " + (currentExplorationIndex + 1) + " " + translation.of + " " + data.exploration.length);
//            var item;
////            if (data.askPreferredTrigger === 'yes') {
////                item = $(source).find('#explorationItem-trigger-ask').clone().removeAttr('id');
////            } else {
//            item = $(source).find('#explorationItem-trigger').clone().removeAttr('id');
////            }
//
//            var searchedData = getGestureById(data.exploration[currentExplorationIndex].gestureId);
////            $(item).find('#search-for .address').text(translation.TriggerForGesture + ':');
////            $(item).find('#search-for .text').text(searchedData.title);
//
//            var gestureThumbnail = $('#item-container-moderator').find('#present-gesture-item').clone().removeAttr('id');
//            $(gestureThumbnail).css({marginBottom: '10px'});
//            $(gestureThumbnail).find('.thumbnail-container').empty().append(getSimpleGestureListThumbnail(searchedData, 'simple-gesture-thumbnail', 'col-xs-12'));
//            $(gestureThumbnail).find('.btn-present-gesture').attr('data-gesture-id', searchedData.id);
//            $(gestureThumbnail).find('.btn-quite-gesture-info').attr('data-gesture-id', searchedData.id);
//            $(gestureThumbnail).find('.gesture-thumbnail').css({marginBottom: '10px'});
//            $(gestureThumbnail).insertBefore($(item).find('#assembled-trigger-container'));
//
//            if (currentPreviewGesture && parseInt(currentPreviewGesture.gesture.id) === parseInt(searchedData.id)) {
//                $(gestureThumbnail).find('.btn-present-gesture').click();
//            }
//
//            $(container).find('#exploration-container').empty().append(item);
//            renderSceneTriggerItems(item, container, data);
//
//            if (currentExplorationIndex < data.exploration.length - 1) {
//                if (data.askPreferredTrigger === 'yes') {
//                    $(container).find('#btn-request-trigger').removeClass('hidden');
//                } else {
//                    if (explorationStartTriggered) {
//                        $(container).find('#btn-next-gesture').removeClass('hidden');
//                    }
//                }
//                $(container).find('#btn-stop-screen-sharing').addClass('hidden');
//            } else {
//                $(container).find('#btn-next-gesture').remove();
//                if (data.askPreferredTrigger === 'yes') {
//                    $(container).find('#btn-request-trigger').removeClass('hidden');
//                } else {
//                    if (scenesUsedForExploration(data.exploration) === true) {
//                        $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
//                    } else {
//                        currentPhaseStepDone = true;
//                        $(container).find('#btn-done-exploration').removeClass('hidden disabled');
//                    }
//                }
//            }
//
//            if (!data.exploration[currentExplorationIndex].transitionScenes) {
//                $(item).find('.scenes-container').remove();
//            }
//        }
//
//        // scene buttons
//        function renderSceneTriggerItems(item, container, data) {
//            if (data.exploration && data.exploration[currentExplorationIndex].transitionScenes && data.exploration[currentExplorationIndex].transitionScenes.length > 0) {
//                for (var i = 0; i < data.exploration[currentExplorationIndex].transitionScenes.length; i++) {
//                    var scene = getSceneById(data.exploration[currentExplorationIndex].transitionScenes[i].sceneId);
//                    var transitionItem = $(source).find('#transition-scene-item').clone().attr('id', scene.id);
//                    var itemData = $(source).find('#interactive-scenes-catalog-thumbnail').clone().removeAttr('id');
//                    $(itemData).find('#info-' + scene.type).removeClass('hidden');
//                    $(itemData).find('.btn-text').text(scene.title);
//                    $(itemData).find('.scene-description').text(data.exploration[currentExplorationIndex].transitionScenes[i].description);
//                    $(transitionItem).find('.scene-data').append(itemData);
//                    $(item).find('#transition-scenes').append(transitionItem);
//                    $(item).find('#transition-scenes').append(document.createElement('br'));
//                    $(itemData).find('.btn-trigger-scene').removeClass('disabled');
//
//                    $(itemData).find('.btn-trigger-scene').unbind('click').bind('click', {scene: scene, index: i}, function (event) {
//                        if (!$(this).hasClass('btn-primary') && !$(this).hasClass('disabled')) {
//                            $(this).closest('.root').find('.btn-trigger-scene').removeClass('btn-primary');
//                            $(this).closest('.root').find('.scene-description').addClass('hidden');
//                            $(this).addClass('btn-primary');
//                            $(this).parent().parent().find('.scene-description').removeClass('hidden');
//                            currentExplorationScene = event.data.index;
//                            openPrototypeScene(event.data.scene, data.exploration.length === 1 && data.exploration[currentExplorationIndex].transitionScenes.length === 1, data.exploration[currentExplorationIndex].transitionScenes[currentExplorationScene].description);
//
//                            if (event.data.scene && !previewModeEnabled) {
//                                getGMT(function (timestamp) {
//                                    var currentPhase = getCurrentPhase();
//                                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: event.data.scene.id});
//                                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                                });
//                            }
//                        }
//
//                        if ($(this).hasClass('disabled')) {
//                            $(document).scrollTop(0);
//                            wobble(container.find('#general'));
//                        }
//                    });
//
//                    if ((currentExplorationScene > 0 && i === currentExplorationScene) || (currentExplorationScene === 0 && i === 0)) {
//                        $(itemData).find('.btn-trigger-scene').click();
//                        $(transitionItem).find('.btn-trigger-scene').addClass('btn-primary');
//                        $(transitionItem).find('.scene-description').removeClass('hidden');
//                    }
//                }
//            }
//        }
//
//        function scenesUsedForPhaseStep(data) {
//            if (data && data.length > 0) {
//                for (var i = 0; i < data.length; i++) {
//                    return true;
//                }
//            }
//            return false;
//        }
//
//
//
//        // gesture requestion functionalities
//
//        function renderCurrentGesturesToShow() {
//            var gesturesToShow = data.exploration[currentExplorationIndex].gestures;
//
//            if (gesturesToShow.length > 0) {
//                for (var i = 0; i < gesturesToShow.length; i++) {
//                    var gesture = getGestureById(gesturesToShow[i]);
//                    var presentItem = $('#item-container-moderator').find('#present-gesture-item').clone().removeAttr('id');
//                    $(presentItem).css({marginBottom: '10px'});
//                    $(presentItem).find('.thumbnail-container').empty().append(getSimpleGestureListThumbnail(gesture, 'simple-gesture-thumbnail', 'col-xs-12'));
//                    $(presentItem).find('.btn-present-gesture').attr('data-gesture-id', gesture.id);
//                    $(presentItem).find('.btn-quite-gesture-info').attr('data-gesture-id', gesture.id);
//                    $(presentItem).find('.gesture-thumbnail').css({marginBottom: '10px'});
//                    $(container).find('#assembled-gestures').append(presentItem);
//                    initPopover();
//
//                    if (currentPreviewGesture && parseInt(currentPreviewGesture.gesture.id) === parseInt(gesture.id)) {
//                        $(presentItem).find('.btn-present-gesture').click();
//                    }
//                }
//
//                var activePresentButton = null;
//                var activeQuitButton = null;
//                if (!previewModeEnabled && peerConnection) {
//                    $(peerConnection).unbind(MESSAGE_GESTURE_INFO_PRESENT).bind(MESSAGE_GESTURE_INFO_PRESENT, function (event) {
//                        event.preventDefault();
//                        unlockButton(activePresentButton, true);
//                        $(activePresentButton).addClass('hidden');
//                        $(activePresentButton).parent().find('.btn-quit-gesture-info').removeClass('hidden');
//                    });
//
//                    $(peerConnection).unbind(MESSAGE_GESTURE_INFO_CLOSED).bind(MESSAGE_GESTURE_INFO_CLOSED, function (event, payload) {
//                        event.preventDefault();
//                        unlockButton(activeQuitButton, true);
//                        $(activeQuitButton).addClass('hidden');
//                        $(activeQuitButton).closest('.root').find('.btn-present-gesture').removeClass('hidden disabled');
//
//                        var gestureId = payload.gestureId;
//                        if (gestureId && !previewModeEnabled) {
//                            getGMT(function (timestamp) {
//                                var currentPhase = getCurrentPhase();
//                                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_HIDE_GESTURE_INFO, time: timestamp, gestureId: gestureId});
//                                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                            });
//                        }
//                    });
//                }
//
//                initPreviewGestureButtons();
//
////                $(container).find('.btn-present-gesture').unbind('click').bind('click', function (event) {
////                    event.preventDefault();
////                    activePresentButton = $(this);
////                    activeQuitButton = $(this).parent().find('.btn-quit-gesture-info');
////                    if (!$(activePresentButton).hasClass('disabled')) {
////                        var gestureId = $(this).attr('data-gesture-id');
////                        currentPreviewGesture = {gesture: getGestureById(gestureId)};
////
////                        $(activePresentButton).closest('.root').find('.btn-present-gesture').addClass('disabled');
////                        if (!previewModeEnabled && peerConnection) {
////                            lockButton(activePresentButton, true);
////                            peerConnection.sendMessage(MESSAGE_OPEN_GESTURE_INFO, {id: gestureId});
////                        } else {
////                            $(activePresentButton).addClass('hidden');
////                            $(activePresentButton).parent().find('.btn-quit-gesture-info').removeClass('hidden');
////                        }
////
////                        if (gestureId && !previewModeEnabled) {
////                            getGMT(function (timestamp) {
////                                var currentPhase = getCurrentPhase();
////                                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
////                                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_SHOW_GESTURE_INFO, time: timestamp, gestureId: gestureId});
////                                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
////                            });
////                        }
////                    }
////                });
////
////                $(container).find('.btn-quit-gesture-info').unbind('click').bind('click', function (event) {
////                    event.preventDefault();
////                    activeQuitButton = $(this);
////                    if (!$(activeQuitButton).hasClass('disabled')) {
////                        var gestureId = $(this).attr('data-gesture-id');
////                        currentPreviewGesture = null;
////
////                        if (!previewModeEnabled && peerConnection) {
////                            lockButton(activeQuitButton, true);
////                            peerConnection.sendMessage(MESSAGE_CLOSE_GESTURE_INFO, {id: gestureId});
////                        } else {
////                            $(activeQuitButton).addClass('hidden');
////                            $(activeQuitButton).closest('.root').find('.btn-present-gesture').removeClass('hidden disabled');
////                        }
////                    }
////                });
//            }
//        }
//
////        $(container).find('#btn-request-gestures').unbind('click').bind('click', function (event) {
////            event.preventDefault();
////            if (!$(this).hasClass('disabled')) {
////                currentPhaseState = 'askPreferredGestures';
////                renderCurrentPhaseState();
////
////                if (peerConnection) {
////                    peerConnection.sendMessage(MESSAGE_REQUEST_PREFERRED_GESTURES, {currentExplorationIndex: currentExplorationIndex});
////                }
////            } else {
////                wobble([$(container).find('#general')]);
////                $(document).scrollTop(0);
////            }
////        });
//
////        $(container).find('#btn-next-trigger').unbind('click').bind('click', function (event) {
////            event.preventDefault();
////            if (!$(this).hasClass('disabled')) {
////                $(this).addClass('hidden');
////                currentExplorationIndex++;
////                currentExplorationScene = 0;
////                currentPhaseState = 'explorationStarted';
////                renderCurrentPhaseState();
////
////                if (peerConnection) {
////                    peerConnection.sendMessage(MESSAGE_START_EXPLORATION);
////                }
////            } else if (!explorationStartTriggered) {
////                wobble([container.find('#general')]);
////                $(document).scrollTop(0);
////            } else {
////                wobble($(container).find('#identified-gestures'));
////            }
////        });
//
//
//
//
//
//
//
//        // trigger request functionalities
//
//        function renderCurrentTriggersToShow() {
//            var triggerToShow = data.exploration[currentExplorationIndex].trigger;
//
//            if (triggerToShow.length > 0) {
//
//                for (var i = 0; i < triggerToShow.length; i++) {
//                    var trigger = getTriggerById(triggerToShow[i]);
//                    var presentItem = $('#item-container-moderator').find('#present-trigger-item').clone().removeAttr('id');
//                    $(presentItem).find('.trigger-title').text(trigger.title);
//                    $(presentItem).find('.btn-present-trigger').attr('data-trigger-id', trigger.id);
//                    $(presentItem).find('.btn-quite-trigger-info').attr('data-trigger-id', trigger.id);
//                    $(container).find('#assembled-trigger').append(presentItem);
//
//                    if (currentPreviewTrigger && parseInt(currentPreviewTrigger.id) === parseInt(trigger.id)) {
//                        $(presentItem).find('.btn-present-trigger').click();
//                    }
//                }
//
//                var activePresentButton = null;
//                var activeQuitButton = null;
//                if (!previewModeEnabled && peerConnection) {
//                    $(peerConnection).unbind(MESSAGE_TRIGGER_INFO_PRESENT).bind(MESSAGE_TRIGGER_INFO_PRESENT, function (event) {
//                        event.preventDefault();
//                        unlockButton(activePresentButton, true);
//                        $(activePresentButton).addClass('hidden');
//                        $(activePresentButton).parent().find('.btn-quit-trigger-info').removeClass('hidden');
//                    });
//
//                    $(peerConnection).unbind(MESSAGE_TRIGGER_INFO_CLOSED).bind(MESSAGE_TRIGGER_INFO_CLOSED, function (event) {
//                        event.preventDefault();
//                        unlockButton(activeQuitButton, true);
//                        $(activeQuitButton).addClass('hidden');
//                        $(activeQuitButton).closest('.root').find('.btn-present-trigger').removeClass('hidden disabled');
//
//                        var triggerId = payload.triggerId;
//                        if (gestureId && !previewModeEnabled) {
//                            getGMT(function (timestamp) {
//                                var currentPhase = getCurrentPhase();
//                                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_HIDE_TRIGGER_INFO, time: timestamp, triggerId: triggerId});
//                                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                            });
//                        }
//                    });
//                }
//
//                initPreviewGestureButtons();
//
//                $(container).find('.btn-present-trigger').unbind('click').bind('click', function (event) {
//                    event.preventDefault();
//                    activePresentButton = $(this);
//                    activeQuitButton = $(this).parent().find('.btn-quit-trigger-info');
//
//                    if (!$(activePresentButton).hasClass('disabled')) {
//                        var triggerId = $(this).attr('data-trigger-id');
//                        currentPreviewTrigger = getTriggerById(triggerId);
//
//                        $(activePresentButton).closest('.root').find('.btn-present-trigger').addClass('disabled');
//                        $(container).find('.btn-present-gesture').addClass('disabled');
//
//                        if (!previewModeEnabled && peerConnection) {
//                            lockButton(activePresentButton, true);
//                            peerConnection.sendMessage(MESSAGE_OPEN_TRIGGER_INFO, {id: triggerId});
//
//                            getGMT(function (timestamp) {
//                                var currentPhase = getCurrentPhase();
//                                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_SHOW_TRIGGER_INFO, time: timestamp, triggerId: triggerId});
//                                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                            });
//                        } else {
//                            $(activePresentButton).addClass('hidden');
//                            $(activePresentButton).parent().find('.btn-quit-trigger-info').removeClass('hidden');
//                        }
//                    }
//                });
//
//                $(container).find('.btn-quit-trigger-info').unbind('click').bind('click', function (event) {
//                    event.preventDefault();
//                    activeQuitButton = $(this);
//                    if (!$(activeQuitButton).hasClass('disabled')) {
//                        var triggerId = $(this).attr('data-trigger-id');
//                        currentPreviewTrigger = null;
//
//                        if (!previewModeEnabled && peerConnection) {
//                            lockButton(activeQuitButton, true);
//                            peerConnection.sendMessage(MESSAGE_CLOSE_TRIGGER_INFO, {id: triggerId});
//                        } else {
//                            $(activeQuitButton).addClass('hidden');
//                            $(activeQuitButton).closest('.root').find('.btn-present-trigger').removeClass('hidden disabled');
//                            $(container).find('.btn-present-gesture').removeClass('hidden disabled');
//                        }
//                    }
//                });
//            }
//        }
//
////        $(container).find('#btn-request-trigger').unbind('click').bind('click', function (event) {
////            event.preventDefault();
////            if (!$(this).hasClass('disabled')) {
////                currentPhaseState = 'askPreferredTrigger';
////                renderCurrentPhaseState();
////                if (peerConnection) {
////                    peerConnection.sendMessage(MESSAGE_REQUEST_PREFERRED_TRIGGER, {currentExplorationIndex: currentExplorationIndex});
////                }
////            } else {
////                wobble([$(container).find('#general')]);
////                $(document).scrollTop(0);
////            }
////        });
////
////        $(container).find('#btn-next-gesture').unbind('click').bind('click', function (event) {
////            event.preventDefault();
////            if (!$(this).hasClass('disabled')) {
////                $(this).addClass('hidden');
////                currentExplorationIndex++;
////                currentExplorationScene = 0;
////                currentPhaseState = 'explorationStarted';
////                renderCurrentPhaseState();
////
////                if (peerConnection) {
////                    peerConnection.sendMessage(MESSAGE_START_EXPLORATION);
////                }
////            } else if (!explorationStartTriggered) {
////                wobble([container.find('#general')]);
////                $(document).scrollTop(0);
////            } else {
////                wobble($(container).find('#identified-trigger'));
////            }
////        });
//
//        function initPreviewGestureButtons() {
//            var activePresentButton, activeQuitButton;
//            $(container).find('.btn-present-gesture').unbind('click').bind('click', function (event) {
//                event.preventDefault();
//                activePresentButton = $(this);
//                activeQuitButton = $(this).parent().find('.btn-quit-gesture-info');
//                if (!$(activePresentButton).hasClass('disabled')) {
//                    var gestureId = $(this).attr('data-gesture-id');
//                    currentPreviewGesture = {gesture: getGestureById(gestureId)};
//
//                    $(activePresentButton).closest('.root').find('.btn-present-gesture').addClass('disabled');
//                    $(activePresentButton).closest('.root').find('.btn-present-trigger').addClass('disabled');
//
//                    if (!previewModeEnabled && peerConnection) {
//                        lockButton(activePresentButton, true);
//                        peerConnection.sendMessage(MESSAGE_OPEN_GESTURE_INFO, {id: gestureId});
//                    } else {
//                        $(activePresentButton).addClass('hidden');
//                        $(activePresentButton).parent().find('.btn-quit-gesture-info').removeClass('hidden');
//                    }
//
//                    if (gestureId && !previewModeEnabled) {
//                        getGMT(function (timestamp) {
//                            var currentPhase = getCurrentPhase();
//                            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_SHOW_GESTURE_INFO, time: timestamp, gestureId: gestureId});
//                            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                        });
//                    }
//                }
//            });
//
//            $(container).find('.btn-quit-gesture-info').unbind('click').bind('click', function (event) {
//                event.preventDefault();
//                var activeQuitButton = $(this);
//                if (!$(activeQuitButton).hasClass('disabled')) {
//                    var gestureId = $(this).attr('data-gesture-id');
//                    currentPreviewGesture = null;
//
//                    if (!previewModeEnabled && peerConnection) {
//                        lockButton(activeQuitButton, true);
//                        peerConnection.sendMessage(MESSAGE_CLOSE_GESTURE_INFO, {id: gestureId});
//                    } else {
//                        $(activeQuitButton).addClass('hidden');
//                        $(activeQuitButton).closest('.root').find('.btn-present-gesture').removeClass('hidden disabled');
//                        $(activeQuitButton).closest('.root').find('.btn-present-trigger').removeClass('hidden disabled');
//                    }
//                }
//            });
//        }
//
//
//
//
////        function enableControls() {
////            $(container).find('#slides').removeClass('hidden');
////            wobble([container.find('#slides')]);
////
////            $(container).find('.btn-trigger-scene, .btn-reset-scene').removeClass('disabled');
////
////            if (data.exploration.length === 1) {
////                if (data.askPreferredGesture === 'yes') {
////                    $(container).find('#btn-request-gestures').removeClass('hidden disabled');
////                } else if (data.askPreferredTrigger === 'yes') {
////                    $(container).find('#btn-request-trigger').removeClass('hidden disabled');
////                } else {
////
////                }
////            } else {
////                if (data.askPreferredGesture === 'yes') {
////                    $(container).find('#btn-request-gestures').removeClass('hidden disabled');
////                } else if (data.askPreferredTrigger === 'yes') {
////                    $(container).find('#btn-request-trigger').removeClass('hidden disabled');
////                } else {
////                    if (data.exploration.length > 1) {
////                        $(container).find('#btn-next-' + (data.explorationType === 'gestures' ? 'trigger' : 'gesture')).removeClass('hidden disabled');
////                    }
////                }
////            }
////        }
//
//        return container;
//    },
    initializePeerConnection: function initializePeerConnection() {
        if (!peerConnection && !previewModeEnabled) {
            peerConnection = new PeerConnection(false);
            $(peerConnection).unbind(MESSAGE_NEXT_STEP).bind(MESSAGE_NEXT_STEP, function (event, payload) {
                nextStep();
            });

            $(peerConnection).unbind(MESSAGE_CANCEL_SURVEY).bind(MESSAGE_CANCEL_SURVEY, function (event, payload) {
                var currentPhase = getCurrentPhase();
                if (currentPhase.format === IDENTIFICATION || currentPhase.format === EXPLORATION || currentPhase.format === GESTURE_TRAINING || currentPhase.format === SCENARIO) {
                    if (prototypeWindow) {
                        peerConnection.stopShareScreen(true, function () {
                            prototypeWindow.close();
                            prototypeWindow = null;
                            console.log('screen stopped for canceling');

                            saveCurrentStatus(false);
                            peerConnection.stopRecording(function () {
                                console.log('recording stopped for canceling');
                                currentPhaseStepIndex = getThanksStepIndex();
                                renderPhaseStep();
                                updateProgress();
                            }, true);
                        });
                        peerConnection.sendMessage(MESSAGE_STOP_SCREEN_SHARING);
                    }
                } else {
                    saveCurrentStatus(false);
                    peerConnection.stopRecording(function () {
                        currentPhaseStepIndex = getThanksStepIndex();
                        renderPhaseStep();
                        updateProgress();
                    }, true);
                }
            });

            $(peerConnection).unbind(MESSAGE_REQUEST_SYNC).bind(MESSAGE_REQUEST_SYNC, function (event, payload) {
                console.log('on sync request');

                resetConstraints();
                peerConnection.sendMessage(MESSAGE_SYNC_PHASE_STEP, {index: currentPhaseStepIndex});

                $('#custom-modal').find('.modal-content').empty();
                $('#custom-modal').modal('hide');

                renderPhaseStep();
            });

            $(peerConnection).unbind(MESSAGE_SYNC_PHASE_STEP).bind(MESSAGE_SYNC_PHASE_STEP, function (event, payload) {
                console.log('sync phase step', payload.index);

                if (prototypeWindow) {
                    prototypeWindow.close();
                    prototypeWindow = null;
                }

                syncPhaseStep = false;
                currentPhaseStepIndex = payload.index;
                renderPhaseStep();
                updateProgress();
            });

            $(peerConnection).unbind('videoAdded').bind('videoAdded', function () {
                if (syncPhaseStep) {
                    peerConnection.sendMessage(MESSAGE_REQUEST_SYNC, {index: currentPhaseStepIndex});
                }
            });

            $(peerConnection).unbind(CONNECTION_STATE_CONNECTED).bind(CONNECTION_STATE_CONNECTED, function () {
                console.log('connected: ', CONNECTION_STATE_CONNECTED);
                removeAlert($('#viewModerator'), ALERT_GENERAL_PLEASE_WAIT);
                $('#viewModerator').find('#phase-content').removeClass('hidden');
                $('#viewModerator').find('#pinnedRTC').css({opacity: 1});
                pinRTC();
                updateRTCHeight($('#viewModerator #column-left').width(), true);
            });

            $(peerConnection).unbind(CONNECTION_STATE_DISCONNECTED).bind(CONNECTION_STATE_DISCONNECTED, function () {
                console.log('disconnected: ', CONNECTION_STATE_DISCONNECTED);
                removeAlert($('#viewModerator'), ALERT_GENERAL_PLEASE_WAIT);

                resetConstraints();
                peerConnection.stopShareScreen();
                if (prototypeWindow) {
                    prototypeWindow.close();
                    prototypeWindow = null;
                }

                if (getCurrentPhase().format !== THANKS) {
                    console.log('append alert please wait', $('#viewModerator'));
                    appendAlert($('#viewModerator'), ALERT_GENERAL_PLEASE_WAIT);
                    $('#viewModerator').find('#phase-content').addClass('hidden');
                    $('#viewModerator').find('#pinnedRTC').css({opacity: 0});
                }
            });

            $(peerConnection).unbind('videoRemoved').bind('videoRemoved', function () {
                console.log('videoRemoved');
                removeAlert($('#viewModerator'), ALERT_GENERAL_PLEASE_WAIT);
                if (getCurrentPhase().format !== THANKS) {
                    appendAlert($('#viewModerator'), ALERT_GENERAL_PLEASE_WAIT);
                    $('#viewModerator').find('#phase-content').addClass('hidden');
                    $('#viewModerator').find('#pinnedRTC').css({opacity: 0});
                }
            });
        }
    },
    initializeRTC: function initializeRTC() {
        // check preview or live mode, and check if webRTC is needed
        $('#animatableRTC').addClass('hidden');
        initPopover();
        if (isWebRTCNeededInFuture()) {
            if (previewModeEnabled === true) {
                Moderator.appendRTCPreviewStream();
            } else {
                Moderator.appendRTCLiveStream();
            }
        } else {
            resetLiveStream();
        }
    },
    appendRTCPreviewStream: function appendRTCPreviewStream() {
        var source = getSourceContainer(currentView);
        var target = $('#viewModerator').find('.pinnedRTC');
        var callerElement = $(source).find('#moderator-web-rtc-placeholder').clone().attr('id', 'web-rtc-placeholder');
        $(target).empty().prepend(callerElement);
        pinRTC();
        updateRTCHeight($('#viewModerator #column-left').width(), true);

        var currentPhase = getCurrentPhase();
        var options = getPhaseStepOptions(currentPhase.format);
        console.log('options: ', options);
        if (options.moderator.recordStream === 'yes') {
            showRecordIndicator();
        } else {
            hideRecordIndicator();
        }

        // init mouse events and pidoco tracking, for live execution the peer connection class handles this
        var tween = new TweenMax($(callerElement).find('.stream-controls'), .3, {opacity: 1.0, paused: true});
        $(callerElement).on('mouseenter', function (event) {
            event.preventDefault();
            tween.play();
        });

        $(callerElement).on('mouseleave', function (event) {
            event.preventDefault();
            tween.reverse();
        });
    },
    appendRTCLiveStream: function appendRTCLiveStream() {
        var currentPhase = getCurrentPhase();
        var options = getPhaseStepOptions(currentPhase.format);
        var query = getQueryParams(document.location.search);
        var mainElement = $('#video-caller');
        console.log('append rtc live stream', iceTransports);

        var callerOptions = {
            target: $('#viewModerator').find('#pinnedRTC'),
            callerElement: mainElement,
            localVideoElement: 'local-stream',
            remoteVideoElement: 'remote-stream',
            sharingVideoElement: '#screen-stream',
            streamControls: $(mainElement).find('#stream-controls'),
            localMuteElement: $(mainElement).find('#btn-stream-local-mute'),
            pauseStreamElement: $(mainElement).find('#btn-pause-stream'),
            remoteMuteElement: $(mainElement).find('#btn-stream-remote-mute'),
            togglePinnedElement: $(mainElement).find('#btn-toggle-rtc-fixed'),
            indicator: $(mainElement).find('#stream-control-indicator'),
            enableWebcamStream: true,
            enableDataChannels: options.enableDataChannels && options.enableDataChannels === 'yes' || false,
            autoRequestMedia: true,
            roomId: query.roomId,
            iceTransports: iceTransports || null,
            localStream: {audio: options.moderator.audio, video: options.moderator.video, visualize: options.moderator.visualizeStream, record: options.moderator.recordStream},
            remoteStream: {audio: options.tester.audio, video: options.tester.video}
        };

        $(callerOptions.target).prepend(callerOptions.callerElement);
        pinRTC();
        updateRTCHeight($('#viewModerator #column-left').width(), true);

        peerConnection.update(callerOptions);
        Moderator.keepStreamsPlaying(callerOptions.callerElement);
    },
    keepStreamsPlaying: function keepStreamsPlaying(element) {
        if (peerConnection.status !== STATUS_UNINITIALIZED) {
            var videos = $(element).find('video');
            for (var i = 0; i < videos.length; i++) {
//                if (new String($(videos[i]).attr('id')).includes('video') && !videos[i].playing) {
                videos[i].play();
//                }
            }
        }
    }
};

function checkRTCUploadStatus(container) {
    if (uploadQueue && !uploadQueue.allFilesUploaded() && !uploadQueue.allFilesUploaded() && uploadQueue.uploadPending() === true) {
        console.log('sumbmit final data with upload queue, some files where not uploaded yet!');
        submitFinalData(container, false);
    } else {
        console.log('sumbmit final data without upload queue, or all files where uploaded.');
        submitFinalData(container, true);
    }
}

function submitFinalData(container, areAllRTCsUploaded) {
    $(container).find('#upload-instructions').removeClass('hidden');
    $(container).find('#upload-done, #upload-retry, #btn-leave-survey').addClass('hidden');
    if (!areAllRTCsUploaded) {
        $(container).find('#rtc-uploads').addClass('hidden');
    } else {
        $(container).find('#rtc-uploads').removeClass('hidden');
    }

    saveCurrentStatus(areAllRTCsUploaded, function (result) {
        if (result.status === RESULT_SUCCESS) {
            if (areAllRTCsUploaded) {
                $(container).find('#upload-instructions').addClass('hidden');
                $(container).find('#upload-done, #btn-leave-survey').removeClass('hidden');
            } else {
                $(container).find('#rtc-uploads').removeClass('hidden');
            }
        } else {
            $(container).find('#upload-instructions').addClass('hidden');
            $(container).find('#upload-retry').removeClass('hidden');
        }
    });
}

function renderObservations(data, container) {
    if (data.observations && data.observations.length > 0) {
        if (!previewModeEnabled) {
            var savedObservations = getObservationResults(getCurrentPhase().id);
            console.log('render observations with answers: ', savedObservations, data.observations);
            if (savedObservations && savedObservations.length > 0) {
                renderEditableObservations($(container).find('#observations .question-container'), data.observations, savedObservations);
            } else {
                var questionnaire = new Questionnaire({isPreview: false, questions: data.observations, source: $('#item-container-inputs'), container: $(container).find('#observations')});
                questionnaire.renderModeratorView();
//                Moderator.getQuestionnaire($('#item-container-inputs'), $(container).find('#observations'), data.observations, false);
            }

            $(container).find('#observations').on('change', function () {
                var study = getLocalItem(STUDY);
                console.log('save observation answers');
                saveObservationAnwers($(container).find('#observations .question-container'), study.id, study.testerId, getCurrentPhase().id);
            });
        } else {
            console.log('render observations');
//            Moderator.getQuestionnaire($('#item-container-inputs'), $(container).find('#observations'), data.observations, false);
            var questionnaire = new Questionnaire({isPreview: false, questions: data.observations, source: $('#item-container-inputs'), container: $(container).find('#observations')});
            questionnaire.renderModeratorView();
        }

        $(container).find('#observations').css({marginBottom: '30px'});
    } else {
        appendAlert($(container).find('#observations'), ALERT_NO_PHASE_DATA);
    }
}

function checkSingleScene(data) {
    var sceneCount = 0;
    var sceneIds = [];
    var currentPhase = getCurrentPhase();

    switch (currentPhase.format) {
        case SCENARIO:
            for (var i = 0; i < data.length; i++) {
                if (data[i].woz && data[i].woz.length > 0) {
                    for (var j = 0; j < data[i].woz.length; j++) {
                        for (var k = 0; k < data[i].woz[j].transitionScenes.length; k++) {
                            sceneIds.push(data[i].woz[j].transitionScenes[k].sceneId);
                        }

                    }
                    sceneCount += data[i].woz.length;
                }
            }
            break;
        case GESTURE_TRAINING:
            console.log(data);
            data && data.length === 1;
            if (data && data.length > 0) {
                for (var i = 0; i < data.length; i++) {
                    if (data[i].transitionScenes && data[i].transitionScenes.length > 0) {
                        for (var j = 0; j < data[i].transitionScenes.length; j++) {
                            sceneIds.push(data[i].transitionScenes[j].sceneId);
                        }
                    }
                }
            }

            break;
    }

    sceneIds = unique(sceneIds);

    console.log('check single scene: ', sceneIds.length);

    if (sceneIds.length === 1) {
        return {single: true, pidoco: getSceneById(sceneIds[0]).type === SCENE_PIDOCO};
    }
    return {single: sceneIds.length === 1};
}

function openPrototypeScene(scene, isSingleScene, description, index) {
    var windowSpecs = "location=no,menubar=no,status=no,toolbar=no";
    console.log('open prototype window', scene, isSingleScene, prototypeWindow);
    var currentPhase = getCurrentPhase();
    if (scene !== null) {
        if (prototypeWindow && !prototypeWindow.closed && !isSingleScene) {
            console.log('has prototype window');
            prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: scene}, 'https://gesturenote.de');
        } else if (!prototypeWindow && !isSingleScene) {
            console.log('has no prototype window, no single scene');
            prototypeWindow = window.open("study-execution-prototype-sharing.php?phaseId=" + currentPhase.id + "&type=" + currentPhase.format, "_blank", windowSpecs);
        } else if (!prototypeWindow && isSingleScene === true && (scene.type === SCENE_WEB || scene.type === SCENE_PIDOCO)) {
            console.log('has no prototype window, single scene, ', scene.type);
            prototypeWindow = window.open(scene.parameters.url, "_blank", windowSpecs);
        } else if (prototypeWindow && isSingleScene) {

        } else {
            console.log('else');
            prototypeWindow = window.open("study-execution-prototype-sharing.php?phaseId=" + currentPhase.id + "&type=" + currentPhase.format, "_blank", windowSpecs);
        }
    } else {
        if (prototypeWindow) {
            console.log('no scene, but prototype window');
            prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: scene}, 'https://gesturenote.de');
        } else {
            console.log('no scene, else');
            prototypeWindow = window.open("study-execution-prototype-sharing.php?phaseId=" + currentPhase.id + "&type=" + currentPhase.format, "_blank", windowSpecs);
        }
    }

    if (!previewModeEnabled && peerConnection) {
        peerConnection.sendMessage(MESSAGE_RENDER_SCENE, {description: description, index: index});
    }
}


function getWOZTransitionItem(source, transitionScene, disabled, active) {
    var scene = getSceneById(transitionScene.sceneId);
    var btn = $(source).find('#wozItemWithScenesButton').clone().removeAttr('id');
    $(btn).find('.btn-text').text(scene.title);
    $(btn).find('.btn-trigger-scene').attr('id', scene.id);
    $(btn).find('.btn-trigger-scene').attr('data-transition-scene-id', scene.id);
    $(btn).find('.btn-trigger-scene').attr('data-transition-mode', transitionScene.transitionMode);
    $(btn).find('.btn-trigger-scene').attr('data-transition-type', 'scene');
    $(btn).find('.btn-trigger-scene #scene-' + scene.type).removeClass('hidden');

    if (transitionScene.transitionMode === 'automatically') {
        $(btn).find('.btn-trigger-scene').attr('data-transition-time', transitionScene.transitionTime);
        $(btn).find('.btn-trigger-scene').find('.transition-time').text(transitionScene.transitionTime + 's');
    }

    if (disabled === false) {
        $(btn).find('.btn-trigger-scene').removeClass('disabled');
    }

    if (active === true) {
        $(btn).find('.btn-trigger-scene').addClass('btn-primary');
    }

    return btn;
}

function getWOZTransitionFeedbackItem(source, feedback, transitionMode, time, disabled, active) {
    var btn = $(source).find('#wozFeedbackItemButton').clone().removeAttr('id');
    $(btn).find('.btn-text').text(feedback.title);
    $(btn).find('.btn-trigger-feedback').attr('id', feedback.id);
    $(btn).find('.btn-trigger-feedback').attr('data-transition-mode', transitionMode);
    $(btn).find('.btn-trigger-feedback').attr('data-transition-type', 'feedback');
    $(btn).find('.btn-trigger-feedback #feedback-' + feedback.type).removeClass('hidden');
    if (transitionMode === 'automatically') {
        $(btn).find('.btn-trigger-feedback').attr('data-transition-time', time);
        $(btn).find('.btn-trigger-feedback').find('.transition-time').text(time + 's');
    }

    if (disabled === false) {
        $(btn).find('.btn-trigger-feedback').removeClass('disabled');
    }

    if (active === true) {
        $(btn).find('.btn-trigger-feedback').addClass('btn-primary');
    }

    return btn;
}

//function initNextStepButton(container) {
//    $(container).find('#btn-next-step').unbind('click').bind('click', function (event) {
//        event.preventDefault();
//        if (!previewModeEnabled && peerConnection) {
//            peerConnection.sendMessage(MESSAGE_NEXT_STEP);
//        }
//        nextStep();
//    });
//}