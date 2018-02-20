/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var prototypeWindow = null;
var Moderator = {
    renderView: function renderView() {
//        $('.alert-space').empty();
        var currentPhase = getCurrentPhase();
        var currentPhaseData = getCurrentPhaseData();
        var source = getSourceContainer(currentView);
        if (previewModeEnabled === false) {
            setLocalItem(currentPhase.id + '.tempSaveData', {});
            getGMT(function (timestamp) {
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.startTime = timestamp;
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            });
        }

        Moderator.initializePeerConnection();
        if (currentPhaseData || (currentPhaseData && $.isArray(currentPhaseData) && currentPhaseData.length > 0)) {

            var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');
            $(container).find('#column-left').css('opacity', '0');
            var item = null;
            switch (currentPhase.format) {
                case LETTER_OF_ACCEPTANCE:
                    item = Moderator.getLetterOfAcceptance(container, currentPhaseData);
                    break;
                case THANKS:
                    item = Moderator.getThanks(container, currentPhaseData);
                    break;
                case QUESTIONNAIRE:
                    item = Moderator.getQuestionnaire(source, container, currentPhaseData, true);
                    break;
                case INTERVIEW:
                    item = Moderator.getInterview(source, container, currentPhaseData);
                    break;
                case GUS_SINGLE_GESTURES:
                    item = Moderator.getGUS(source, container, currentPhaseData);
                    break;
                case GUS_MULTIPLE_GESTURES:
                    item = Moderator.getQuestionnaire(source, container, currentPhaseData.gus, true);
                    break;
                case SUS:
                    item = Moderator.getSUS(source, container, currentPhaseData);
                    break;
                case GESTURE_TRAINING:
                    item = Moderator.getGestureTraining(source, container, currentPhaseData);
                    break;
                case SCENARIO:
                    item = Moderator.getScenario(source, container, currentPhaseData);
                    break;
                case SLIDESHOW_GESTURES:
                    item = Moderator.getGestureSlideshow(source, container, currentPhaseData);
                    break;
                case SLIDESHOW_TRIGGER:
                    item = Moderator.getTriggerSlideshow(source, container, currentPhaseData);
                    break;
                case PHYSICAL_STRESS_TEST:
                    item = Moderator.getPhysicalStressTest(source, container, currentPhaseData);
                    break;
                case IDENTIFICATION:
                    item = Moderator.getIdentification(source, container, currentPhaseData);
                    break;
                case EXPLORATION:
                    item = Moderator.getExploration(source, container, currentPhaseData);
                    break;
            }

            if (item !== false) {
                if (!syncPhaseStep) {
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
        Moderator.checkPositioning(currentPhase.format);
        TweenMax.from($('#phase-content #column-right'), .2, {y: -60, opacity: 0, clearProps: 'all'});
        if ($(document).scrollTop() > 0) {
            $(document).scrollTop(0);
        }

        updateRTCHeight($('#phase-content #column-left').width());

        if (isPidocoSocketNeeded()) {
            console.log('pidoco socket needed');
            initWebSocket();
        }
    },
    checkPositioning: function checkPositioning(format) {
        if (previewModeEnabled) {
            var posY = '74px';
//            switch (format) {
//                case SCENARIO:
//                    posY = '0px';
//                    break;
//            }
            $('#viewModerator #phase-content').css({marginTop: posY});
        }
    },
    renderNoDataView: function renderNoDataView() {
        var alert = $(getSourceContainer(currentView)).find('#no-phase-data').clone().removeAttr('id');
        $('#viewModerator #phase-content').append(alert);
        appendAlert(alert, ALERT_NO_PHASE_DATA);
    },
    getLetterOfAcceptance: function getLetterOfAcceptance(container, data) {
        $(container).find('.letter-text').text(data);
        appendAlert(container, ALERT_PLEASE_WAIT);
        return container;
    },
    getThanks: function getThanks(container, data) {
        TweenMax.to(container.find('.fa-upload'), .5, {yoyo: true, repeat: -1, opacity: .4});
        $(container).find('#thanks-text').text(data);
        $(container).find('.thanks-text').text(data);
        $(container).find('#btn-leave-survey').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var query = getQueryParams(document.location.search);
            if (query.studyId && query.h && query.token) {
                goto('study-prepare-evaluator.php?studyId=' + query.studyId + '&h=' + query.h + '&token=' + query.token);
            }
        });

        $(container).find('#btn-retry-upload').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (previewModeEnabled === false) {
                submitFinalData(container);
            }
        });

        if (previewModeEnabled === false) {
            checkRTCUploadStatus(container);
        }

        return container;
    },
    getQuestionnaire: function getQuestionnaire(source, container, data, isPreview) {
        data = getAssembledItems(data);
        if (data && data.length > 0) {
            if (isPreview) {
                console.log(data);
                renderQuestionnaireAnswers(container, data, currentQuestionnaireAnswers, true);
            } else {
                for (var i = 0; i < data.length; i++) {
                    var item = $(source).find('#' + data[i].format).clone();
                    item.attr('name', data[i].id);
                    if (data.length > 1) {
                        $(item).find('.question').text((i + 1) + '. ' + data[i].question);
                    } else {
                        $(item).find('.question').text(data[i].question);
                    }

                    $(container).find('.question-container').append(item);
                    if (data[i].dimension !== DIMENSION_ANY) {
                        $(item).find('#item-factors').removeClass('hidden');
                        $(item).find('#factor-primary').text(translation.dimensions[data[i].dimension]);
                    }

                    var parameters = data[i].parameters;
                    var options = data[i].options;
                    switch (data[i].format) {
                        case OPEN_QUESTION:
                            renderOpenQuestionInput(item);
                            break;
                        case COUNTER:
                            renderCounterInput(item, parameters);
                            break;
                        case DICHOTOMOUS_QUESTION:
                            renderDichotomousQuestionInput(item, parameters);
                            break;
                        case DICHOTOMOUS_QUESTION_GUS:
                            renderDichotomousQuestionInput(item, parameters);
                            break;
                        case GROUPING_QUESTION:
                            renderGroupingQuestionInput(item, parameters, options);
                            break;
                        case GROUPING_QUESTION_GUS:
                        case GROUPING_QUESTION_OPTIONS:
                            renderGroupingQuestionGUSInput(item, parameters, options);
                            break;
                        case RATING:
                            renderRatingInput(item, options);
                            break;
                        case MATRIX:
                            renderMatrixInput(item, options);
                            break;
                        case SUM_QUESTION:
                            renderSumQuestionInput(item, parameters, options);
                            break;
                        case RANKING:
                            renderRankingInput(item, options);
                            break;
                        case ALTERNATIVE_QUESTION:
                            renderAlternativeQuestionInput(item, parameters);
                            break;
                    }
                }
            }
        }

        if (questionnaireDone) {
            $(container).find('#btn-next-step').removeClass('disabled');
        }

        initNextStepButton(container);

        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_QUESTIONNAIRE_DONE).bind(MESSAGE_QUESTIONNAIRE_DONE, function (event, payload) {
//                console.log('questionnaire done');
                $(container).find('#btn-next-step').removeClass('disabled');
            });

            if (getCurrentPhase().format !== PHYSICAL_STRESS_TEST) {
                $(peerConnection).unbind(MESSAGE_UPDATE_QUESTIONNAIRE).bind(MESSAGE_UPDATE_QUESTIONNAIRE, function (event, payload) {
//                    console.log('update questionnaire', payload);
                    renderQuestionnaireAnswers(container, data, payload);
                });
            }
        }

        return container;
    },
    getInterview: function getInterview(source, container, data) {
        container = renderQuestionnaire(container, data, currentQuestionnaireAnswers);
        initNextStepButton(container);
        $(container).find('#btn-next-step').on('click', function (event) {
            event.preventDefault();

            var answers = getQuestionnaireAnswers($(container).find('.question-container').children());
            if (!previewModeEnabled) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.answers = answers;
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                console.log('on next step clicked', tempData);
            }


        });
        return container;
    },
    getSUS: function getSUS(source, container, data) {
        $(container).find('.headline').text(getCurrentPhase().title);
        Moderator.getQuestionnaire(source, container, data, true);
        return container;
    },
    getGUS: function getGUS(source, container, data) {
        currentGUSData = data;
        var gesture = getGestureById(data.gestureId);
        var trigger = getTriggerById(data.triggerId);
        var feedback = getFeedbackById(data.feedbackId);
        if (gesture) {
            renderGestureImages($(container).find('.previewGesture'), gesture.images, gesture.previewImage, null);
            $(container).find('#gesture .address').text(translation.gesture + ':');
            $(container).find('#gesture .text').text(gesture.title);
            $(container).find('#trigger .address').text(translation.trigger + ':');
            $(container).find('#trigger .text').text(trigger.title);
            $(container).find('#feedback .address').text(translation.feedback + ':');
            $(container).find('#feedback .text').text(feedback.title);
            if (feedback) {
                var icon = document.createElement('i');
                var label = document.createElement('div');
                $(label).addClass('label label-default');
                switch (feedback.type) {
                    case TYPE_FEEDBACK_SOUND:
                        $(label).text(' Sound');
                        $(icon).addClass('fa fa-volume-up');
                        break;
                    case TYPE_FEEDBACK_TEXT:
                        $(label).text(' Text');
                        $(icon).addClass('fa fa-font');
                        break;
                }

                container.find('#feedback .text').text(" " + feedback.title);
                $(label).prepend(icon);
                container.find('#feedback .text').prepend(label);
            }
        }

        Moderator.getQuestionnaire(source, container, data.gus, true);
        return container;
    },
    getGestureTraining: function getGestureTraining(source, container, data) {

        if (!data.training || data.training.length === 0) {
            return false;
        }

        if (!previewModeEnabled) {
            var currentPhase = getCurrentPhase();
            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//            tempData.training = new Array();
            tempData.annotations = new Array();
            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
        }

        // general data section
        $(container).find('#general .headline').text(getCurrentPhase().title);
        $(container).find('#general #description').text(data.description);
        // gestures section
        Moderator.renderGestureTraining(source, container, data.training);
        // observation section
        renderObservations(data, container);
        return container;
    },
    renderGestureTraining: function renderGestureTraining(source, container, data) {
//        console.log('renderGestureTraining', data);
        $(container).find('#training .headline').text('Geste ' + (currentGestureTrainingIndex + 1) + ' von ' + data.length);
        var training = data[currentGestureTrainingIndex];
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
                    if (transitionsLength > 1) {
                        $(container).find('#btn-repeat-training').addClass('disabled');
                        $(container).find('#next-gesture, #training-done').addClass('disabled');
                    } else {
                        $(container).find('#btn-repeat-training').removeClass('disabled');
                        $(container).find('#next-gesture, #training-done').removeClass('disabled');
                    }
                } else {
                    $(container).find('#btn-repeat-training').addClass('disabled');
                    $(container).find('#next-gesture, #training-done').addClass('disabled');
                }

                return false;
            }

            $(feedbackButtons).find('#waiting-indicator').addClass('hidden');
            var feedbackLength = $(feedbackButtons).length;

            var leftSceneButtons = $(scenesContainer).find('#transition-scene-container').find('.btn-trigger-scene').not('.btn-primary');
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

            if (leftSceneButtons.length === 0) {
                if (currentTrainingIndex < training.repeats - 1) {
                    $(container).find('#btn-repeat-training').removeClass('disabled');
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

                if (!areThereScenes(data)) {
                    $(item).find('#btn-repeat-training').addClass('hidden disabled');
                    item.find('#repeats .text').text(trainingData.repeats);
//                    if (gestureTrainingStartTriggered) {
//                        $(container).find('#next-gesture, #training-done').removeClass('disabled');
//                    }
                } else {
                    item.find('#repeats .text').text(trainingData.repeats - currentTrainingIndex - 1);
                }

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
                                    if (!areThereScenes(data)) {
                                        $(container).find('#next-gesture, #training-done').removeClass('disabled');
                                    }
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
                                    if (!areThereScenes(data)) {
                                        $(container).find('#next-gesture, #training-done').removeClass('disabled');
                                    }

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
                                if (!areThereScenes(data)) {
                                    $(container).find('#next-gesture, #training-done').removeClass('disabled');
                                }
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

                    if (currentTrainingIndex < training.repeats - 1) {
                        $(container).find('#btn-repeat-training').removeClass('hidden');
                    } else {
                        $(container).find('#btn-repeat-training').addClass('hidden');
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
            openPrototypeScene(currentWOZScene, data.training && data.training.length === 1);
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
    },
    getGestureSlideshow: function getGestureSlideshow(source, container, data) {
//        console.log('getGestureSlideshow');
        if (!data.slideshow || data.slideshow.length === 0) {
            return false;
        }

//        if (!previewModeEnabled) {
//            var currentPhase = getCurrentPhase();
//            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//            tempData.annotations = new Array();
//            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//        }

        // general data section
        $(container).find('#general .headline').text(getCurrentPhase().title);
        $(container).find('#general #description').text(data.description);
        // slideshow section
        Moderator.renderGestureSlide(source, container, data);
        if (peerConnection) {
            $(peerConnection).unbind(MESSAGE_REACTIVATE_CONTROLS).bind(MESSAGE_REACTIVATE_CONTROLS, function (event, payload) {
                loadHTMLintoModal('custom-modal', 'modal-check-gesture.php', 'modal-lg');
            });
        }

        // observation section
        renderObservations(data, container);
        return container;
    },
    renderGestureSlide: function renderGestureSlide(source, container, data) {
        if (currentSlideIndex > data.slideshow.length - 1) {
            if (previewModeEnabled) {
                renderSlide(data.slideshow.length - 1);
            }

            $(container).find('#btn-done').removeClass('disabled');
            $(container).find('#trigger-slide').addClass('disabled');
        } else {
            renderSlide(currentSlideIndex);
        }

        function renderSlide(index) {
            var slide = data.slideshow[index];
            $(container).find('#slides .headline').text('Slide ' + (index + 1) + ' von ' + data.slideshow.length);
            $(container).find('#slidesContainer').empty();
            var item = $(source).find('#gestureSlideshowItem').clone().removeAttr('id');
            $(container).find('#slidesContainer').append(item);
            var gesture = getGestureById(slide.gestureId);
            var trigger = getTriggerById(slide.triggerId);
            renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage);
//            item.find('.btn-popover-gesture-preview').attr('name', gesture.id);
            $(item).find('#responseTime').text(slide.recognitionTime + ' Sekunden');
            var imageContainer;
            $(item).find('#searched').text(gesture.title);
            $(item).find('#given').text(trigger.title);
            imageContainer = $(item).find('.right .previewGesture');
            $(container).find('#search-gestures').removeClass('hidden');
            if (slideshowStartTriggered) {
                $(container).find('#btn-start-slideshow').remove();
            } else {
                $(item).find('#trigger-slide').addClass('disabled');
            }
        }

        $(container).find('#btn-start-slideshow').unbind('click').bind('click', function (event) {
            event.preventDefault();
            slideshowStartTriggered = true;
            slideRestarted = true;
            $(this).remove();
            $(container).find('#trigger-slide').removeClass('disabled');
            wobble(container.find('#slidesContainer'));
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_START_GESTURE_SLIDESHOW);
            }
        });

        $(container).find('#trigger-slide').unbind('click').bind('click', function (event) {
//            console.log('trigger-slide');
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                slideTriggered = true;
                slideRestarted = false;
                $(container).find('.right').find('#btn-done, #trigger-slide').addClass('disabled');
                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_TRIGGER_GESTURE_SLIDE, {currentSlideIndex: currentSlideIndex, slidesRestartCount: slidesRestartCount});
//                    getGMT(function (timestamp) {
//                        var slideData = data.slideshow[currentSlideIndex];
//                        var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_PERFORM_GESTURE, gestureId: slideData.gestureId, triggerId: slideData.triggerId, time: timestamp});
//                        setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
//
//                        
//                    });
                }
            } else {
                if (slideshowStartTriggered) {
                    wobble($(container).find('#btn-done'));
                } else {
                    $(document).scrollTop(0);
                    wobble($(container).find('#btn-start-slideshow'));
                }
            }
        });

        $(container).find('#btn-done').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_NEXT_STEP);
                }
                nextStep();
            } else {
                if (slideshowStartTriggered) {
                    wobble($(container).find('#trigger-slide'));
                } else {
                    $(document).scrollTop(0);
                    wobble($(container).find('#btn-start-slideshow'));
                }
            }
        });

        if (previewModeEnabled && slideTriggered) {
            slideTriggered = false;
            loadHTMLintoModal('custom-modal', 'modal-check-gesture.php', 'modal-lg');
        }
    },
    getTriggerSlideshow: function getTriggerSlideshow(source, container, data) {
        if (data.slideshow.length === 0) {
            return false;
        }

        // general data section
        $(container).find('#general .headline').text(getCurrentPhase().title);
        $(container).find('#general #description').text(data.description);

        if (slideshowStartTriggered) {
            $(container).find('#btn-start-slideshow').remove();
            $(container).find('#btn-done-slideshow').removeClass('hidden');
            // done button
            if (testerDoneTriggered) {
                $(container).find('#btn-done-slideshow').removeClass('disabled');
            }
        }

        $(container).find('#btn-start-slideshow').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_START_TRIGGER_SLIDESHOW);
                $(peerConnection).unbind(MESSAGE_UPDATE_QUESTIONNAIRE).bind(MESSAGE_UPDATE_QUESTIONNAIRE, function (event, payload) {
                    renderSlideshowItems(payload);
                });
                $(peerConnection).unbind(MESSAGE_TRIGGER_SLIDESHOW_DONE).bind(MESSAGE_TRIGGER_SLIDESHOW_DONE, function (event, payload) {
                    if (payload.selectedOptions) {
                        renderSlideshowItems(payload.selectedOptions);
                    }

                    $(container).find('#btn-done-slideshow').removeClass('disabled');
                });
            }
            slideshowStartTriggered = true;
            $(this).remove();
            $(container).find('#btn-done-slideshow').removeClass('hidden');
        });
        $(container).find('#btn-done-slideshow').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                if (!previewModeEnabled && peerConnection) {
                    peerConnection.sendMessage(MESSAGE_NEXT_STEP);
                }

                nextStep();
            }
        });

        // slideshow section
        renderSlideshowItems(currentQuestionnaireAnswers);
        function renderSlideshowItems(answers) {
            $(container).find('.question-container').empty();
            for (var i = 0; i < data.slideshow.length; i++) {
                var item = $(source).find('#triggerSlideshowItem').clone().removeAttr('id');
                $(container).find('.question-container').append(item);
                var gesture = getGestureById(data.slideshow[i].gestureId);
                var trigger = getTriggerById(data.slideshow[i].triggerId);
                $(item).find('#searched').text(trigger.title);
                $(item).find('#given').text(gesture.title);
                $(item).find('.btn-popover-gesture-preview').attr('name', gesture.id);
                var answer = null;

                if (answers && answers.length > 0) {
                    for (var j = 0; j < answers.length; j++) {
                        if (parseInt(answers[j].correctTriggerId) === parseInt(trigger.id)) {
                            answer = answers[j];
                            break;
                        }
                    }
                }

                if (answer) {
                    if (parseInt(answer.selectedId) === parseInt(trigger.id)) {
                        item.addClass('panel-success');
                        item.find('#answered-correct').removeClass('hidden');
                    } else {
                        item.addClass('panel-danger');
                        item.find('#answered-wrong').removeClass('hidden');
                    }
                } else {
                    item.find('#not-answered').removeClass('hidden');
                }
            }
        }



        return container;
    },
    getPhysicalStressTest: function getPhysicalStressTest(source, container, data) {
        if (!data.stressTestItems || data.stressTestItems.length === 0) {
            return false;
        }

        // general data section
        $(container).find('#general .headline').text(getCurrentPhase().title);
        $(container).find('#general #description').text(data.description);

        // stress test controls section
        Moderator.renderPhysicalStressTest(source, container, data);

        // observation section
        renderObservations(data, container);
        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_REACTIVATE_CONTROLS).bind(MESSAGE_REACTIVATE_CONTROLS, function (event, payload) {
                if (currentStressTestCount >= data.stressAmount) {
                    container.find('#btn-next-gesture').removeClass('disabled');
                } else {
                    Moderator.renderPhysicalStressTest(source, container, data);
                }
            });
            $(peerConnection).unbind(MESSAGE_UPDATE_QUESTIONNAIRE).bind(MESSAGE_UPDATE_QUESTIONNAIRE, function (event, payload) {
                console.log('update questionnaire for physical stress test', payload);
                currentQuestionnaireAnswers = payload;
                Moderator.renderPhysicalStressTestQuestionnaire(container, data, payload);
            });
        }

        return container;
    },
    renderPhysicalStressTest: function renderPhysicalStressTest(source, container, data) {
        $(container).find('#controls .headline').text(translation.gesture + " " + (currentStressTestIndex + 1) + " " + translation.of + " " + data.stressTestItems.length);

        if (stressTestStartTriggered) {
            container.find('#btn-show-gesture').removeClass('disabled');
            container.find('#btn-start-stress-test').remove();
        }

        if (currentStressTestCount >= data.stressAmount) {
            $(container).find('#btn-next-gesture').removeClass('disabled');
            $(container).find('#btn-show-gesture, #btn-show-question').addClass('disabled');

            if (!data.sequenceStressQuestions && !data.singleStressQuestions && data.singleStressGraphicsRating === 'none' && data.sequenceStressGraphicsRating === 'none') {
                $(container).find('#btn-show-question').addClass('hidden');
            } else {
                $(container).find('#btn-show-question').removeClass('hidden');
            }
        } else {
            $(container).find('#btn-next-gesture').addClass('disabled');

            if (!data.singleStressQuestions && data.singleStressGraphicsRating === 'none') {
                $(container).find('#btn-show-question').addClass('hidden');
            }
        }

        if (currentStressTestIndex >= data.stressTestItems.length - 1) {
            $(container).find('#btn-next-gesture .btn-text').text(translation.done);
            $(container).find('#btn-next-gesture .fa-check').removeClass('hidden');
            $(container).find('#btn-next-gesture #next-arrow').addClass('hidden');
        }

        var gesture = getGestureById(data.stressTestItems[currentStressTestIndex]);
        if (gesture) {
            renderGestureImages($(container).find('.previewGesture'), gesture.images, gesture.previewImage);
//            container.find('.btn-popover-gesture-preview').attr('name', gesture.id);
            container.find('#stress-for .text').text(gesture.title);
        } else {
            container.find('.btn-popover-gesture-preview').addClass('disabled');
        }

        container.find('#repeats-left .text').text((data.stressAmount - currentStressTestCount));
        if (stressTestGestureTriggered) {
            if ((currentStressTestCount < data.stressAmount && !data.singleStressQuestions && data.singleStressGraphicsRating === 'none') || (currentStressTestCount >= data.stressAmount && !data.sequenceStressQuestions && data.sequenceStressGraphicsRating === 'none')) {
                container.find('#btn-show-gesture').removeClass('disabled');
            } else {
                container.find('#btn-show-gesture').addClass('disabled');
                container.find('#btn-show-question').removeClass('disabled');
            }
        }

        container.find('#btn-start-stress-test').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(this).remove();
            stressTestStartTriggered = true;
            container.find('#btn-show-gesture').removeClass('disabled');
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_START_STRESS_TEST);
            }
        });

        container.find('#btn-show-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(this).addClass('disabled');
                $(container).find('#gestures-container').addClass('hidden');
                container.find('#btn-show-question').removeClass('disabled');
                stressTestGestureTriggered = true;
                stressTestQuestionsTriggered = false;

                if ((currentStressTestCount < data.stressAmount && !data.singleStressQuestions && data.singleStressGraphicsRating === 'none') || (currentStressTestCount >= data.stressAmount && !data.sequenceStressQuestions && data.sequenceStressGraphicsRating === 'none')) {
                    $(this).removeClass('disabled');
//                    currentStressTestCount++;

                    if (previewModeEnabled) {
                        Moderator.renderPhysicalStressTest(source, container, data);
                    }
                }

                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_TRIGGER_STRESS_TEST_GESTURE, {count: currentStressTestCount, index: currentStressTestIndex});
                }
            } else {
                if (stressTestStartTriggered) {
                    wobble(container.find('#btn-show-question'));
                } else {
                    $(document).scrollTop(0);
                    wobble(container.find('#btn-start-stress-test'));
                }
            }
        });


        if (stressTestQuestionsTriggered === true && stressTestGestureTriggered === false) {
            Moderator.renderPhysicalStressTestQuestionnaire(container, data, currentQuestionnaireAnswers);
            $(container).find('#gestures-container').removeClass('hidden');
        }

        container.find('#btn-show-question').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(this).addClass('disabled');
                $(container).find('#btn-show-gesture').addClass('disabled');
                stressTestQuestionsTriggered = true;
                stressTestGestureTriggered = false;
                currentQuestionnaireAnswers = null;

                currentStressTestCount++;
                Moderator.renderPhysicalStressTestQuestionnaire(container, data, currentQuestionnaireAnswers);
                $(container).find('#gestures-container').removeClass('hidden');

                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_TRIGGER_STRESS_TEST_QUESTION, {count: currentStressTestCount, index: currentStressTestIndex});
                }

                if (previewModeEnabled) {
                    Moderator.renderPhysicalStressTest(source, container, data);
                }
            } else {
                if (!stressTestStartTriggered) {
                    $(document).scrollTop(0);
                    wobble(container.find('#btn-start-stress-test'));
                } else {
                    wobble(container.find('#btn-show-gesture'));
                }
            }
        });

        container.find('#btn-next-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(this).addClass('disabled');
                $(container).find('#gestures-container').addClass('hidden');

                if (currentStressTestIndex >= data.stressTestItems.length - 1) {
                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_NEXT_STEP);
                    }

                    nextStep();
                } else {
                    currentStressTestIndex++;
                    currentStressTestCount = 0;

                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_TRIGGER_NEXT_STRESS_TEST_GESTURE, {count: currentStressTestCount, index: currentStressTestIndex});
                    }

                    stressTestQuestionsTriggered = false;
                    stressTestGestureTriggered = false;
                    Moderator.renderPhysicalStressTest(source, container, data);
                }
            } else {
                if (!stressTestStartTriggered) {
                    $(document).scrollTop(0);
                    wobble(container.find('#btn-start-stress-test'));
                } else {
                    wobble(container.find('#btn-show-gesture, #btn-show-question'));
                }
            }
        });
    },
    renderPhysicalStressTestQuestionnaire: function renderPhysicalStressTestQuestionnaire(container, studyData, resultsData) {
        console.log('renderPhysicalStressTestQuestionnaire', resultsData);
        var currentStressTestData = studyData.stressTestItems[currentStressTestIndex];
        var gesture = getGestureById(currentStressTestData);
        var item = $('#item-container-moderator').find('#physicalStressTest-item').clone().removeAttr('id');
        container.find('#gestures-container').empty().append(item);
        renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage);
        $(item).find('#gesture .address').text(translation.gesture + ': ');
        $(item).find('#gesture .text').text(gesture.title);
        $(item).find('#trigger .address').text(translation.trigger + ': ');
        $(item).find('#trigger .text').text(trigger.title);
        $(item).find('#selection .address').text(translation.trigger + ' ' + translation.answer + ': ');

        console.log(studyData, currentStressTestData);

        // single joint section
        var singleStressGraphicsRating = studyData.singleStressGraphicsRating;
        if (singleStressGraphicsRating && singleStressGraphicsRating !== 'none') {
            var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
            $(jointAnswers).insertAfter($(item).find('#headline-single-questions'));
            if (singleStressGraphicsRating === 'hands') {
                $(jointAnswers).find('#joint-answers-body').remove();
                renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'single');
            } else if (singleStressGraphicsRating === 'body') {
                $(jointAnswers).find('#joint-answers-hands').remove();
                renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'single');
            } else {
                renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'single');
                renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'single');
            }
        }

        // single answers section
        var singleStressQuestionnaire = studyData.singleStressQuestions;
        if (singleStressQuestionnaire && singleStressQuestionnaire.length > 0) {
            $(item).find('#single-stress-answers').removeClass('hidden');
            if (resultsData && resultsData.answers && resultsData.answers.singleAnswers && resultsData.answers.singleAnswers[0]) {
                renderQuestionnaireAnswers($(item).find('#single-stress-answers'), singleStressQuestionnaire, {answers: resultsData.answers.singleAnswers[0].answers}, false, true);
            } else {
                renderQuestionnaireAnswers($(item).find('#single-stress-answers'), singleStressQuestionnaire, null, false);
            }
        } else {
//            if (singleStressGraphicsRating && singleStressGraphicsRating !== 'none') {
//                $(item).find('#single-stress-answers').removeClass('hidden');
//            } else {
//                $(item).find('#single-stress-answers').addClass('hidden');
//            }
        }

        // sequence answers section
        var sequenceStressQuestionnaire = studyData.sequenceStressQuestions;
        if (sequenceStressQuestionnaire && sequenceStressQuestionnaire.length > 0) {
            if (currentStressTestCount >= parseInt(studyData.stressAmount)) {
                $(item).find('#sequence-stress-answers').removeClass('hidden');
                if (resultsData && resultsData.answers && resultsData.answers.sequenceAnswers && resultsData.answers.sequenceAnswers[0]) {
                    renderQuestionnaireAnswers($(item).find('#sequence-stress-answers'), sequenceStressQuestionnaire, {answers: resultsData.answers.sequenceAnswers[0].answers}, false, true);
                } else {
                    renderQuestionnaireAnswers($(item).find('#sequence-stress-answers'), sequenceStressQuestionnaire, null, false);
                }
            } else {
                $(item).find('#sequence-stress-answers').addClass('hidden');
            }
        } else {
            $(item).find('#sequence-stress-answers').addClass('hidden');
        }

        if (currentStressTestCount >= parseInt(studyData.stressAmount)) {
            $(item).find('#sequence-stress-answers').removeClass('hidden');

            // sequence joint section
            var sequenceStressGraphicsRating = studyData.sequenceStressGraphicsRating;
            if (sequenceStressGraphicsRating && sequenceStressGraphicsRating !== 'none') {
                var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
                $(jointAnswers).insertAfter($(item).find('#headline-sequence-questions'));
                if (sequenceStressGraphicsRating === 'hands') {
                    $(jointAnswers).find('#joint-answers-body').remove();
                    renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'sequence');
                } else if (sequenceStressGraphicsRating === 'body') {
                    $(jointAnswers).find('#joint-answers-hands').remove();
                    renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'sequence');
                } else {
                    renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'sequence');
                    renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'sequence');
                }
            }
        }
    },
    getScenario: function getScenario(source, container, data) {
        triggeredHelp, triggeredWoz = null;
//        $(container).find('#general #task .address').text(translation.scenarioTitle);
//        $(container).find('#general #task .text').text(data.title);
        $(container).find('#general .headline').text(getCurrentPhase().title);
        $(container).find('#general #description .address').text(translation.scenarioDescription);
        $(container).find('#general #description .text').text(data.description);
        if (!currentWOZScene) {
            currentWOZScene = getSceneById(data.scene);
            currentScenarioTask = data.tasks[0];
        }

        if (!previewModeEnabled) {
            var currentPhase = getCurrentPhase();
            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
            tempData.annotations = new Array();
//            tempData.transitions = new Array();
//            tempData.assessments = new Array();
            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
        }

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
        }

//        var query = getQueryParams(document.location.search);
        $(container).find('#btn-open-prototype').unbind('click').bind('click', function (event) {
            event.preventDefault();
            Moderator.enableScenarioControls(container);
            scenarioPrototypeOpened = true;
            wobble([container.find('#woz-controls')]);
            $(container).find('#btn-start-screen-sharing').removeClass('hidden');
            $(container).find('#btn-reset-scenes').removeClass('disabled');
            $(container).find('.btn-feedback-scene').removeClass('disabled');

            openPrototypeScene(currentWOZScene, checkSingleScene(data.tasks));
        });

        function checkSingleScene(tasks) {
            var sceneCount = 0;
            for (var i = 0; i < tasks.length; i++) {
                if (tasks[i].woz && tasks[i].woz.length > 0) {
                    sceneCount += tasks[i].woz.length;
                }
            }

            if (sceneCount <= 1) {
                return true;
            }
            return false;
        }

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
                    enableControls();
                }
            }
        });


        function enableControls() {
            scenarioStartTriggered = true;
            $(container).find('#btn-reset-scenes').click();
            $(container).find('#btn-start-screen-sharing').addClass('hidden');
            $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
            $(container).find('.btn-feedback-scene').removeClass('disabled');
            $(container).find('.help-container .disabled').removeClass('disabled');
            $(container).find('#assessment-controls-container .disabled').removeClass('disabled');
            $(container).find('#general #description').addClass('hidden');

//            if (!previewModeEnabled && peerConnection) {
//                getGMT(function (timestamp) {
//                    var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                    
////                    tempData.annotations.push({action: ACTION_RENDER_SCENE, scene: currentWOZScene.id, time: timestamp});
////                    tempData.transitions.push({scene: currentWOZScene.id, time: timestamp});
//                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
//                });
//            }
        }

        $(container).find('#btn-stop-screen-sharing').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                screenSharingStopped = true;
                if (peerConnection) {
                    peerConnection.stopShareScreen(true);
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
                    prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: currentWOZScene}, 'https://gesturenote.de');
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
            $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
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
    },
    renderWOZ: function renderWOZ(source, container, data) {
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
                    sendGesture(gestureId, null);
                } else {
                    // if scene has no follow scene and is not a pidoco prototype: delete items
                    $(container).find('.woz-container').empty();
                    appendAlert($(container).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
                    Moderator.renderHelp(source, container, data);
                }
            } else if (transitionsLength > 2) {
                var leftSceneButtons = $(scenesContainer).find('#transition-scene-container').find('.btn-trigger-scene').not('.btn-primary');
                console.log('transitionsLength', transitionsLength, 'leftSceneButtons', leftSceneButtons.length);
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

            Moderator.renderWOZ(source, container, data);
            Moderator.renderHelp(source, container, data);
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
            $(container).find('#assessment-controls #task .text').text(currentScenarioTask.task);
            $(container).find('#assessment-controls .headline').text(translation.task + ' ' + (currentScenarioTaskIndex + 1) + ' ' + translation.of + ' ' + data.tasks.length)

            if (currentScenarioTask.woz) {
                var wozData = getWOZItemsForSceneId(currentScenarioTask.woz, currentWOZScene.id);
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
                            item.find('#btn-trigger-woz, .btn-trigger-scene, .btn-trigger-feedback').removeClass('disabled');
                        }
                    }
                } else {
                    appendAlert($(container).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
                }
            }
        } else {
            appendAlert($(container).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
        }
    },
    renderHelp: function renderHelp(source, container, data) {
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
    },
    renderTaskAssessment: function renderTaskAssessment(source, container, data) {
        if (!$.isEmptyObject(data.taskAssessments)) {
            for (var assessment in data.taskAssessments) {
                var assessmentButton = document.createElement('button');
                $(assessmentButton).attr('data-trigger', data.taskAssessments[assessment].trigger);
                $(assessmentButton).attr('data-assessment-id', assessment);
                $(assessmentButton).html("<span style='color: " + data.taskAssessments[assessment].annotationColor + "'>&#9679;</span> " + data.taskAssessments[assessment].title);
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
                            Moderator.renderWOZ(source, container, data);
                            Moderator.renderHelp(source, container, data);
                        } else {
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
    },
    enableScenarioControls: function enableScenarioControls(container) {
        $(container).find('#btn-open-prototype').remove();
        $(container).find('#btn-start-screen-sharing').removeClass('hidden');
        var wozItems = $(container).find('.woz-container .disabled');
        wozItems.removeClass('disabled');
        var helpItems = $(container).find('.help-container .disabled');
        helpItems.removeClass('disabled');
    },
    getIdentification: function getIdentification(source, container, data) {
        // general data section
        removeLocalItem(ELICITED_GESTURES);
        $(container).find('#general .headline').text(getCurrentPhase().title);
        $(container).find('#general #description').text(data.description);
        if (data.identificationFor === 'gestures') {
            $(container).find('#search-gestures').removeClass('hidden');
        } else {
            $(container).find('#search-trigger').removeClass('hidden');
        }

        if (data.identification.length === 0) {
            return false;
        }

        if (!previewModeEnabled) {
            var currentPhase = getCurrentPhase();
            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
            if (data.identificationFor === 'gestures') {
                tempData.gestures = [];
            } else if (data.identificationFor === 'trigger') {
                tempData.trigger = [];
            }
            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
        }

        // slideshow section
        Moderator.renderIdentification(source, container, data);

        // observation section
        renderObservations(data, container);
        return container;
    },
    renderIdentification: function renderIdentification(source, container, data) {
        var recorder = null;

        renderIdentificationItem(source, container, data);
        function renderIdentificationItem(source, container, data) {
            $(container).find('#slides .headline').text(translation.formats.identification.text + " " + (currentIdentificationIndex + 1) + " " + translation.of + " " + data.identification.length);
            if (data.identification && data.identification.length > 0) {
                var item = $(source).find('#identificationItem-' + data.identificationFor).clone().removeAttr('id');
                $(container).find('#identificationContainer').empty().append(item);
                if (data.identificationFor === 'gestures') {
                    renderIdentificationForGesturesItem(item, container, data);
                } else {
                    renderIdentificationForTriggerItem(item, container, data);
                }
            }

            $(item).find('#btn-done').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    currentPhaseStepDone = true;
                    $(this).addClass('hidden');

                    $(container).find('#slides').addClass('hidden');
                    $(container).find('#identified-gesture, #identified-trigger').addClass('hidden');
                    wobble([container.find('#general')]);
                    $(document).scrollTop(0);

                    if (data.identification[currentIdentificationIndex].transitionScenes && data.identification[currentIdentificationIndex].transitionScenes.length > 0) {
                        $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
                    } else {
                        if (peerConnection) {
                            peerConnection.sendMessage(MESSAGE_NEXT_STEP);
                        }
                        nextStep();
                    }
                } else if (!identificationStartTriggered) {
                    wobble([container.find('#slides')]);
                }
            });
        }

        if (data.identification[currentIdentificationIndex].transitionScenes && data.identification[currentIdentificationIndex].transitionScenes.length > 0) {
            if (screenSharingStopped) {
                $(container).find('#slides').addClass('hidden');
                $(container).find('#identified-gesture, #identified-trigger').addClass('hidden');
                $(container).find('#btn-open-prototype').remove();
                $(container).find('#btn-start-screen-sharing').addClass('hidden');
                $(container).find('#btn-stop-screen-sharing').addClass('hidden');
                $(container).find('#btn-done-identification').removeClass('hidden');
            } else if (currentPhaseStepDone) {
                $(container).find('#slides').addClass('hidden');
                $(container).find('#identified-gesture, #identified-trigger').addClass('hidden');
                $(container).find('#btn-open-prototype').remove();
                $(container).find('#btn-start-screen-sharing').addClass('hidden');
                $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
            } else if (identificationPrototypeOpened && !identificationStartTriggered) {
                $(container).find('#btn-open-prototype').addClass('hidden');
                $(container).find('#btn-start-screen-sharing').removeClass('hidden');
            } else if (identificationPrototypeOpened && identificationStartTriggered) {
                $(container).find('#btn-open-prototype').remove();
                $(container).find('#btn-start-screen-sharing').addClass('hidden');
                $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
                $(container).find('.btn-trigger-scene, .btn-reset-scene').removeClass('disabled');
            } else if (!identificationStartTriggered && !identificationPrototypeOpened) {
                $(container).find('#btn-open-prototype').removeClass('hidden');
            }
        } else {
            if (!identificationStartTriggered) {
                $(container).find('#btn-start-elicitation').removeClass('hidden');
            }
        }

        function renderGestureRecorder(videoURL) {
//            $(container).find('#file-transfer-loading-indicator').css({width: '0%'});
            $(container).find('#file-transfer-loader').addClass('hidden');

            if (!previewModeEnabled) {
                $(container).find('#btn-done, #btn-next-trigger').addClass('disabled');
                var gestureRecorder = $('#item-container-gesture-recorder').find('#gesture-recorder').clone().removeAttr('id');
                container.find('#gesture-recorder-container').empty().append(gestureRecorder).removeClass('hidden');
                var options = {
                    alertTarget: container.find('#gesture-recorder-container'),
                    recorderTarget: gestureRecorder,
                    saveGestures: !previewModeEnabled,
                    ownerId: getLocalItem(STUDY).studyOwner,
                    context: data.identification[currentIdentificationIndex].context,
                    checkType: true,
                    checkInteractionType: true,
                    startState: EVENT_GR_STATE_PLAYBACK,
                    videoUrl: videoURL,
                    initMediaStream: false,
                    allowRerecordGesture: false,
                    allowDeletingGesture: false
                };
                recorder = new GestureRecorder(options);
                renderBodyJoints(gestureRecorder.find('#human-body'));
                initPopover();

                $(gestureRecorder).unbind(EVENT_GR_SAVE_SUCCESS).bind(EVENT_GR_SAVE_SUCCESS, function (event, gesture) {
                    $(container).find('#btn-done, #btn-next-trigger').removeClass('disabled');
                    event.preventDefault();

                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    var triggerId = data.identification[currentIdentificationIndex].triggerId;
                    tempData.gestures.push({id: gesture.id, triggerId: triggerId});
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);

                    initRerecordingButton(gestureRecorder, gesture.id);
                });

                initRerecordingButton(gestureRecorder, null);
            } else {
                $(container).find('#btn-done, #btn-next-trigger').removeClass('disabled');
                initRerecordingButton();

                var gestureRecorder = $('#item-container-gesture-recorder').find('#gesture-recorder').clone().removeAttr('id');
                container.find('#gesture-recorder-container').empty().append(gestureRecorder).removeClass('hidden');
                container.find('#gesture-recorder-container #save-controls').removeClass('hidden');
                container.find('#gesture-recorder-container .recorder').addClass('hidden');
                renderBodyJoints(gestureRecorder.find('#human-body'));

                appendAlert(container, ALERT_PREVIEW_DUMMY);
            }
        }

        function initRerecordingButton(gestureRecorder, gestureId) {
            $(container).find('#btn-start-gesture-rerecording').unbind('click').bind('click', function (event) {
                if (!$(this).hasClass('disabled')) {
                    $(this).addClass('hidden');
                    if (gestureRecorder) {
                        if (gestureId) {
                            $(gestureRecorder).unbind(EVENT_GR_DELETE_SUCCESS).bind(EVENT_GR_DELETE_SUCCESS, function (event, gestureId) {
                                event.preventDefault();
                                console.log('delete success');

                                var currentPhase = getCurrentPhase();
                                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                                var gestures = new Array();
                                for (var i = 0; i < tempData.gestures.length; i++) {
                                    if (parseInt(tempData.gestures[i].id) !== parseInt(gestureId)) {
                                        gestures.push(tempData.gestures[i]);
                                    }
                                }
                                tempData.gestures = gestures;
                                setLocalItem(currentPhase.id + '.tempSaveData', tempData);

                                $(container).find('#btn-done, #btn-next-trigger').removeClass('disabled');
                                $(container).find('#file-transfer-loader').addClass('hidden');
                                $(container).find('#identified-gesture').addClass('hidden');
                                $(container).find('#gesture-recorder-container').addClass('hidden');
                                $(container).find('#btn-stop-gesture-recording').removeClass('hidden');
                                $(container).find('#btn-next-trigger, #btn-done').addClass('hidden');

                                if (peerConnection) {
                                    peerConnection.sendMessage(MESSAGE_START_RECORDING_GESTURE);
                                }
                            });

                            deleteLastRecordedGesture(gestureId);
                        } else {
                            $(container).find('#btn-done, #btn-next-trigger').removeClass('disabled');
                            $(container).find('#file-transfer-loader').addClass('hidden');
                            $(container).find('#identified-gesture').addClass('hidden');
                            $(container).find('#gesture-recorder-container').addClass('hidden');
                            $(container).find('#btn-stop-gesture-recording').removeClass('hidden');
                            $(container).find('#btn-next-trigger, #btn-done').addClass('hidden');

                            if (peerConnection) {
                                peerConnection.sendMessage(MESSAGE_START_RECORDING_GESTURE);
                            }
                        }
                    } else {
                        removeAlert(container, ALERT_PREVIEW_DUMMY);
                        $(container).find('#btn-done, #btn-next-trigger').removeClass('disabled');
                        $(container).find('#file-transfer-loader').addClass('hidden');
                        $(container).find('#identified-gesture').addClass('hidden');
                        $(container).find('#gesture-recorder-container').addClass('hidden');
                        $(container).find('#btn-stop-gesture-recording').removeClass('hidden');
                        $(container).find('#btn-next-trigger, #btn-done').addClass('hidden');
                        identificationRecordingStartTriggered = true;
                        identificationRecordingStopTriggered = false;

                        if (peerConnection) {
                            peerConnection.sendMessage(MESSAGE_START_RECORDING_GESTURE);
                        }
                    }
                } else {
                    $(document).scrollTop(0);
                    wobble([container.find('#general')]);
                }
            });
        }

        function renderSceneTriggerItems(item, container, data) {
            if (data.identification[currentIdentificationIndex] && data.identification[currentIdentificationIndex].transitionScenes) {
                for (var i = 0; i < data.identification[currentIdentificationIndex].transitionScenes.length; i++) {
                    var scene = getSceneById(data.identification[currentIdentificationIndex].transitionScenes[i].sceneId);
                    var transitionItem = $(source).find('#transition-scene-item').clone().attr('id', scene.id);
                    var itemData = $(source).find('#interactive-scenes-catalog-thumbnail').clone().removeAttr('id');
                    $(itemData).find('#info-' + scene.type).removeClass('hidden');
                    $(itemData).find('.btn-text').text(scene.title);
                    $(itemData).find('.scene-description').text(data.identification[currentIdentificationIndex].transitionScenes[i].description);
                    $(transitionItem).find('.scene-data').append(itemData);
                    $(item).find('#transition-scenes').append(transitionItem);
                    $(item).find('#transition-scenes').append(document.createElement('br'));
                    if ((currentIdentificationScene > 0 && i === currentIdentificationScene) || (currentIdentificationScene === 0 && i === 0)) {
                        $(transitionItem).find('.btn-trigger-scene').addClass('btn-primary');
                        $(transitionItem).find('.scene-description').removeClass('hidden');
                    }

                    $(itemData).find('.btn-trigger-scene').unbind('click').bind('click', {scene: scene, index: i}, function (event) {
                        if (!$(this).hasClass('btn-primary') && !$(this).hasClass('disabled')) {
                            $(this).closest('.root').find('.btn-trigger-scene').removeClass('btn-primary');
                            $(this).closest('.root').find('.scene-description').addClass('hidden');
                            $(this).addClass('btn-primary');
                            $(this).parent().parent().find('.scene-description').removeClass('hidden');
                            currentIdentificationScene = event.data.index;
                            openPrototypeScene(event.data.scene, data.identification.length === 1, data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].description);
                        }

                        if ($(this).hasClass('disabled')) {
                            $(document).scrollTop(0);
                            wobble(container.find('#general'));
                        }
                    });
                }

                if (currentIdentificationIndex > 0) {
                    $(container).find('.btn-trigger-scene').removeClass('disabled');
                }
            }
        }

        function renderIdentificationForGesturesItem(item, container, data) {
            renderSceneTriggerItems(item, container, data);

            $(container).find('#btn-start-gesture-recording').removeClass('hidden');
            var searchedData = getTriggerById(data.identification[currentIdentificationIndex].triggerId);
            $(item).find('#search-for .address').text(translation.GestureForTrigger + ':');
            $(item).find('#search-for .text').text(searchedData.title);
            $(item).find('.btn-popover-gesture-preview').remove();

            if (!screenSharingStopped && identificationPrototypeOpened && currentIdentificationIndex > 0) {
                $(item).find('#btn-start-gesture-recording').removeClass('disabled');
                var scene = getSceneById(data.identification[currentIdentificationIndex].transitionScenes[0].sceneId);
                openPrototypeScene(scene, data.identification.length === 1, data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].description);

                if (currentIdentificationIndex >= data.identification.length - 1) {
                    $(container).find('#btn-next-trigger').remove();
                }
            }

            if (data.identification[currentIdentificationIndex].transitionScenes && data.identification[currentIdentificationIndex].transitionScenes.length > 1) {
                $(item).find('#transition-scenes-controls').removeClass('hidden');
            }

            if (identificationStartTriggered) {
                $(container).find('#btn-start-gesture-recording').removeClass('hidden disabled');

                if (identificationRecordingStartTriggered === true) {
                    $(container).find('#btn-start-gesture-recording').addClass('hidden');
                    $(container).find('#btn-stop-gesture-recording').removeClass('hidden');
                }

                if (identificationRecordingStopTriggered === true) {
                    $(container).find('#btn-start-gesture-recording').addClass('hidden');
                    $(container).find('#btn-start-gesture-rerecording').removeClass('hidden');
                    $(container).find('#btn-stop-gesture-recording').addClass('hidden');
                    $(container).find('#identified-gesture').removeClass('hidden');
                    $(container).find('#file-transfer-loader').addClass('hidden');
                    renderGestureRecorder();
                    initRerecordingButton(null);

                    if (currentIdentificationIndex < data.identification.length - 1) {
                        $(container).find('#btn-next-trigger').removeClass('hidden disabled');
                    } else {
                        $(container).find('#btn-done').removeClass('hidden disabled');
                    }
                }
            }

            $(item).find('#btn-start-gesture-recording').unbind('click').bind('click', function (event) {
                if (!$(this).hasClass('disabled')) {
                    $(this).addClass('hidden');
                    $(container).find('#identified-gesture').addClass('hidden');
                    $(container).find('#gesture-recorder-container').addClass('hidden');
                    $(container).find('#btn-stop-gesture-recording').removeClass('hidden');
                    $(container).find('#btn-next-trigger').addClass('hidden');
                    identificationRecordingStartTriggered = true;
                    identificationRecordingStopTriggered = false;

                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_START_RECORDING_GESTURE);
                    }
                } else {
                    $(document).scrollTop(0);
                    wobble([container.find('#general')]);
                }
            });

            $(item).find('#btn-stop-gesture-recording').unbind('click').bind('click', function (event) {
                $(this).addClass('hidden');
                identificationRecordingStartTriggered = false;
                identificationRecordingStopTriggered = true;

                initRerecordingButton(null);

                if (!previewModeEnabled && peerConnection) {
//                    $(peerConnection).unbind(MESSAGE_GESTURE_IDENTIFIED).bind(MESSAGE_GESTURE_IDENTIFIED, function (event, payload) {
//                        console.log('gesture identified');
//                        
////                        $(container).find('#file-transfer-loader').removeClass('hidden');
////                        $(container).find('#btn-start-gesture-rerecording').removeClass('hidden');
////                        if (currentIdentificationIndex < data.identification.length - 1) {
////                            $(container).find('#btn-next-trigger').removeClass('hidden');
////                        } else {
////                            $(container).find('#btn-done').removeClass('hidden');
////                        }
//                    });

                    $(peerConnection).unbind(EVENT_FILE_TRANSFER).bind(EVENT_FILE_TRANSFER, function (event, bytesReceived, size) {
                        $(container).find('#identified-gesture').removeClass('hidden');

                        var percent = Math.round(bytesReceived * 100 / size);
                        console.log('transfer video file', bytesReceived, size, percent);
                        $(container).find('#file-transfer-loading-indicator').css({width: percent + "%"});
                        $(container).find('#file-transfer-loader').removeClass('hidden');
                    });

                    $(peerConnection).unbind(EVENT_RECEIVED_FILE).bind(EVENT_RECEIVED_FILE, function (event, file, metadata) {
                        console.log('received video file', file, metadata);
                        $(container).find('#btn-start-gesture-rerecording').removeClass('hidden');
                        if (currentIdentificationIndex < data.identification.length - 1) {
                            $(container).find('#btn-next-trigger').removeClass('hidden');
                        } else {
                            $(container).find('#btn-done').removeClass('hidden');
                        }
//                        $(container).find('#file-transfer-loading-indicator').css({width: "100%"});
                        $(container).find('#file-transfer-loader').addClass('hidden');

                        if (metadata.size > 0) {
                            var blobUrl = URL.createObjectURL(file);
                            renderGestureRecorder(blobUrl);
                        } else {
                            // error handling
                        }
                    });

                    $(container).find('#file-transfer-loading-indicator').css({width: "0%"});
                    $(container).find('#identified-gesture').removeClass('hidden');
                    $(container).find('#file-transfer-loader').removeClass('hidden');
                    peerConnection.sendMessage(MESSAGE_STOP_RECORDING_GESTURE);
                } else {
                    $(container).find('#file-transfer-loader').removeClass('hidden');
                    $(container).find('#identified-gesture').removeClass('hidden');
                    $(container).find('#file-transfer-loading-indicator').css({width: "0%"});
                    TweenMax.to($(container).find('#file-transfer-loading-indicator'), 2, {width: "100%", ease: Linear.easeNone, onComplete: function () {
                            renderGestureRecorder();
                            initRerecordingButton(null);
                            $(container).find('#file-transfer-loader').addClass('hidden');
                            $(container).find('#btn-start-gesture-rerecording').removeClass('hidden');
                            if (currentIdentificationIndex < data.identification.length - 1) {
                                $(container).find('#btn-next-trigger').removeClass('hidden disabled');
                            } else {
                                $(container).find('#btn-done').removeClass('hidden disabled');
                            }
                        }});
                }
            });

            $(item).find('#btn-next-trigger').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $(this).addClass('hidden');
                    removeAlert(container, ALERT_PREVIEW_DUMMY);
                    $(container).find('#identified-gesture').addClass('hidden');
                    identificationRecordingStopTriggered = false;
                    currentIdentificationIndex++;
                    currentIdentificationScene = 0;
                    renderIdentificationItem(source, container, data);
                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_START_IDENTIFICATION);
                    }
                } else if (!identificationStartTriggered) {
                    wobble([container.find('#general')]);
                    $(document).scrollTop(0);
                }
            });
        }

        function renderIdentificationForTriggerItem(item, container, data) {
            console.log(data);
            renderSceneTriggerItems(item, container, data);

            var searchedData = getGestureById(data.identification[currentIdentificationIndex].gestureId);
            $(item).find('#search-for .address').text(translation.TriggerForGesture + ':');
            $(item).find('#search-for .text').text(searchedData.title);
            item.find('.btn-popover-gesture-preview').attr('name', searchedData.id);

            if (identificationStartTriggered) {
                $(container).find('.btn-trigger-scene, .btn-reset-scene, #btn-request-trigger').removeClass('disabled');
            }

            $(item).find('#btn-request-trigger').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $(this).addClass('hidden');
                    $(container).find('#identified-trigger').removeClass('hidden');
                    appendAlert($(container).find('#identified-trigger'), ALERT_WAITING_FOR_TESTER);
                    identificationTriggerRequest = true;
                    console.log('request trigger', currentIdentificationIndex);
                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_REQUEST_TRIGGER, {currentIdentificationIndex: currentIdentificationIndex});
                    }
                } else if (!identificationStartTriggered) {
                    wobble([$(container).find('#general')]);
                    $(document).scrollTop(0);
                }
            });

            if (identificationTriggerRequest) {
                identificationTriggerRequest = false;
                clearAlerts($(container).find('#identified-trigger'));
                $(container).find('#identified-trigger').removeClass('hidden');
                $(item).find('#btn-request-trigger').addClass('hidden');
                renderQuestionnaireAnswers($(container).find('#identified-trigger'), currentQuestionnaireAnswers.data, currentQuestionnaireAnswers.answers, false);

                if (currentIdentificationIndex < data.identification.length - 1) {
                    $(container).find('#btn-next-trigger').removeClass('hidden disabled');
                } else {
                    $(container).find('#btn-done').removeClass('hidden disabled');
                }
            }

            if (peerConnection) {
                $(peerConnection).unbind(MESSAGE_RESPONSE_TRIGGER).bind(MESSAGE_RESPONSE_TRIGGER, function (event, payload) {
                    event.preventDefault();
                    clearAlerts($(container).find('#identified-trigger'));
                    currentQuestionnaireAnswers = payload.answers;
                    console.log(payload.answers);
                    renderQuestionnaireAnswers($(container).find('#identified-trigger'), payload.data, payload.answers, false);

                    if (payload.saveAnswers === true) {
                        if (currentIdentificationIndex < data.identification.length - 1) {
                            $(container).find('#btn-next-trigger').removeClass('hidden disabled');
                        } else {
                            $(container).find('#btn-done').removeClass('hidden disabled');
                        }

                        var currentPhase = getCurrentPhase();
                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                        tempData.trigger.push({gestureId: payload.gestureId, preferredTrigger: payload.answers});
                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                    }
                });
            }

            $(item).find('#btn-next-trigger').unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(this).addClass('hidden');
                $(container).find('#identified-trigger').addClass('hidden');
                $(container).find('#identified-trigger .question-container').empty();
                currentQuestionnaireAnswers = null;
                currentIdentificationIndex++;
                currentIdentificationScene = 0;
                identificationTriggerRequest = false;
                renderIdentificationItem(source, container, data);

                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_START_IDENTIFICATION);
                }
            });
        }

        $(container).find('#btn-start-elicitation').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(this).remove();
            enableControls();
        });

        $(container).find('#btn-open-prototype').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var currentScene = getSceneById(data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].sceneId);
            if (currentScene) {
                identificationPrototypeOpened = true;
                $(this).remove();
                $(container).find('#btn-start-screen-sharing').removeClass('hidden');
                openPrototypeScene(currentScene, data.identification.length === 1, data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].description);
            }
        });

        $(container).find('#btn-start-screen-sharing').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(this).addClass('disabled');
                if (!previewModeEnabled) {
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
                        peerConnection.sendMessage(MESSAGE_START_IDENTIFICATION);
                    });
                } else {
                    enableControls();
                }
            }
        });

        function enableControls() {
            identificationStartTriggered = true;
            wobble([container.find('#slides')]);
            $(container).find('.btn-trigger-scene, .btn-reset-scene, #btn-request-trigger').removeClass('disabled');
            $(container).find('#btn-start-gesture-recording').removeClass('disabled');

            if (data.identification[currentIdentificationIndex].transitionScenes && data.identification[currentIdentificationIndex].transitionScenes.length > 0) {
                $(container).find('#btn-start-screen-sharing').addClass('hidden');
                $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
            }
        }

        $(container).find('#btn-stop-screen-sharing').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                screenSharingStopped = true;
                $(this).addClass('hidden');
                $(container).find('#btn-done-identification').removeClass('hidden');
                if (peerConnection) {
                    peerConnection.stopShareScreen(true);
                }
                identificationPrototypeOpened = false;
                identificationStartTriggered = false;
                if (prototypeWindow) {
                    prototypeWindow.close();
                    prototypeWindow = null;
                }
            } else {
                if (identificationStartTriggered) {
                    wobble($(container).find('#slides'));
                } else {
                    $(document).scrollTop(0);
                    wobble(container.find('#general'));
                }
            }
        });

        $(container).find('#btn-done-identification').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_NEXT_STEP);
                }
                nextStep();
            }
        });
    },
    getExploration: function getExploration(source, container, data) {
        if (!data.exploration || (data.exploration && data.exploration.length === 0)) {
            return false;
        }

        $(container).find('#general .headline').text(getCurrentPhase().title);
        $(container).find('#general #description').text(data.description);

        // observation section
        renderObservations(data, container);

        renderExplorationControls();
        function renderExplorationControls() {
            if (data.explorationType === 'gestures') {
                renderExplorationForGestures();
            } else {
                renderExplorationForTrigger();
            }
            initGenericButtons();
        }

        function renderExplorationForGestures() {
            $(container).find('#slides .headline').text(translation.userCenteredGestureExtraction + " " + (currentExplorationIndex + 1) + " " + translation.of + " " + data.exploration.length);
            var item;
            if (data.askPreferredGesture === 'yes') {
                item = $(source).find('#explorationItem-ask').clone().removeAttr('id');
            } else {
                item = $(source).find('#explorationItem').clone().removeAttr('id');
            }

            var searchedData = getTriggerById(data.exploration[currentExplorationIndex].triggerId);
            $(item).find('#search-for .address').text(translation.GestureForTrigger + ':');
            $(item).find('#search-for .text').text(searchedData.title);

            $(container).find('#exploration-container').empty().append(item);
            renderSceneTriggerItems(item, container, data);

            if (explorationStartTriggered) {
                if (data.exploration.length === 1) {
                    if (data.askPreferredGesture === 'yes') {
                        $(container).find('#btn-request-gestures').removeClass('disabled');
                    } else {
                        $(container).find('#btn-stop-screen-sharing').removeClass('disabled');
                    }
                } else {
                    if (data.askPreferredGesture === 'yes') {
                        $(container).find('#btn-request-gestures').removeClass('disabled');
                    } else {
                        $(container).find('#btn-next-trigger').removeClass('disabled');
                    }
                }
                $(container).find('.btn-trigger-scene, .btn-reset-scene').removeClass('disabled');
            }

            if (currentExplorationIndex < data.exploration.length - 1) {
                if (data.askPreferredGesture === 'yes') {
                    $(container).find('#btn-request-gestures').removeClass('hidden');
                } else {
                    $(container).find('#btn-next-trigger').removeClass('hidden');
                }
            } else {
                $(container).find('#btn-next-trigger').addClass('hidden');
                if (data.askPreferredGesture === 'yes') {
                    $(container).find('#btn-request-gestures').removeClass('hidden');
                } else {
                    if (scenesUsedForExploration(data.exploration) === true) {
                        $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
                    } else {
                        currentPhaseStepDone = true;
                        $(container).find('#btn-done-exploration').removeClass('hidden disabled');
                    }
                }
            }


            // init questionnaire data
//            var trigger = getTriggerById(data.exploration[currentExplorationIndex].triggerId);
//            var gestures = data.exploration[currentExplorationIndex].gestures;
//            var options = [];
//            for (var i = 0; i < gestures.length; i++) {
//                options.push(getGestureById(gestures[i]));
//            }

            if (explorationPreferredGesturesRequest) {
                explorationPreferredGesturesRequest = false;
                clearAlerts($(container).find('#identified-getures'));
                $(container).find('#identified-gestures').removeClass('hidden');
                $(item).find('#btn-request-gestures').addClass('hidden');
                $(container).find('#btn-next-trigger').addClass('disabled');
                $(container).find('#btn-stop-screen-sharing').addClass('disabled');

                // render selected gestures
                renderQuestionnaireAnswers($(container).find('#identified-gestures'), currentQuestionnaireAnswers.data, currentQuestionnaireAnswers.answers, false);

                if (currentExplorationIndex < data.exploration.length - 1) {
                    $(container).find('#btn-next-trigger').removeClass('hidden disabled');
                } else {
                    if (scenesUsedForExploration(data.exploration) === true) {
                        $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
                    } else {
                        currentPhaseStepDone = true;
                        $(container).find('#btn-done-exploration').removeClass('hidden disabled');
                    }
                }
            }
        }

        function renderExplorationForTrigger() {
            $(container).find('#slides .headline').text(translation.userCenteredTriggerExtraction + " " + (currentExplorationIndex + 1) + " " + translation.of + " " + data.exploration.length);
            var item;
            if (data.askPreferredTrigger === 'yes') {
                item = $(source).find('#explorationItem-trigger-ask').clone().removeAttr('id');
            } else {
                item = $(source).find('#explorationItem-trigger').clone().removeAttr('id');
            }

            var searchedData = getGestureById(data.exploration[currentExplorationIndex].gestureId);
            $(item).find('#search-for .address').text(translation.TriggerForGesture + ':');
            $(item).find('#search-for .text').text(searchedData.title);

            $(container).find('#exploration-container').empty().append(item);
            renderSceneTriggerItems(item, container, data);

            if (explorationStartTriggered) {
                if (data.exploration.length === 1) {
                    if (data.askPreferredTrigger === 'yes') {
                        $(container).find('#btn-request-trigger').removeClass('disabled');
                    } else {
                        $(container).find('#btn-stop-screen-sharing').removeClass('disabled');
                    }
                } else {
                    if (data.askPreferredTrigger === 'yes') {
                        $(container).find('#btn-request-trigger').removeClass('disabled');
                    } else {
                        $(container).find('#btn-next-gesture').removeClass('disabled');
                    }
                }
                $(container).find('.btn-trigger-scene, .btn-reset-scene').removeClass('disabled');
            }

            if (currentExplorationIndex < data.exploration.length - 1) {
                if (data.askPreferredTrigger === 'yes') {
                    $(container).find('#btn-request-trigger').removeClass('hidden');
                } else {
                    $(container).find('#btn-next-gesture').removeClass('hidden');
                }
                $(container).find('#btn-stop-screen-sharing').addClass('hidden');
            } else {
                $(container).find('#btn-next-gesture').addClass('hidden');
                if (data.askPreferredTrigger === 'yes') {
                    $(container).find('#btn-request-trigger').removeClass('hidden');
                } else {
                    if (scenesUsedForExploration(data.exploration) === true) {
                        $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
                    } else {
                        currentPhaseStepDone = true;
                        $(container).find('#btn-done-exploration').removeClass('hidden disabled');
                    }
                }
            }


            // init questionnaire data
//            var gesture = getGestureById(data.exploration[currentExplorationIndex].gestureId);
//            var trigger = data.exploration[currentExplorationIndex].trigger;
//            var options = [];
//            for (var i = 0; i < trigger.length; i++) {
//                options.push(getTriggerById(trigger[i]));
//            }

            if (explorationPreferredGesturesRequest) {
                explorationPreferredGesturesRequest = false;
                clearAlerts($(container).find('#identified-trigger'));
                $(container).find('#identified-trigger').removeClass('hidden');
                $(item).find('#btn-request-trigger').addClass('hidden');
                $(container).find('#btn-next-gesture').addClass('disabled');
                $(container).find('#btn-stop-screen-sharing').addClass('disabled');

                // render selected gestures
                renderQuestionnaireAnswers($(container).find('#identified-trigger'), currentQuestionnaireAnswers.data, currentQuestionnaireAnswers.answers, false);

                if (currentExplorationIndex < data.exploration.length - 1) {
                    $(container).find('#btn-next-gesture').removeClass('hidden disabled');
                } else {
                    if (scenesUsedForExploration(data.exploration) === true) {
                        $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
                    } else {
                        currentPhaseStepDone = true;
                        $(container).find('#btn-done-exploration').removeClass('hidden disabled');
                    }
                }
            }
        }


        // check preview buttons
        if (scenesUsedForExploration(data.exploration) === true) {
            if (screenSharingStopped) {
                $(container).find('#slides').addClass('hidden');
                $(container).find('#btn-open-prototype').remove();
                $(container).find('#btn-start-screen-sharing').addClass('hidden');
                $(container).find('#btn-stop-screen-sharing').addClass('hidden');
                $(container).find('#btn-done-exploration').removeClass('hidden');
            } else if (currentPhaseStepDone) {
                $(container).find('#slides').addClass('hidden');
                $(container).find('#btn-open-prototype').remove();
                $(container).find('#btn-start-screen-sharing').addClass('hidden');
                $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
            } else if (explorationPrototypeOpened && !explorationStartTriggered) {
                $(container).find('#btn-open-prototype').addClass('hidden');
                $(container).find('#btn-start-screen-sharing').removeClass('hidden');
            } else if (explorationPrototypeOpened && explorationStartTriggered) {
                $(container).find('#btn-open-prototype').remove();
                $(container).find('#btn-start-screen-sharing').addClass('hidden');
                $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
                $(container).find('.btn-trigger-scene, .btn-reset-scene').removeClass('disabled');
            }
        } else {
            if (explorationStartTriggered) {
                $(container).find('#btn-start-exploration').remove();
                if (currentPhaseStepDone) {
                    $(container).find('#btn-done-exploration').removeClass('hidden');
                    $(container).find('#identified-gestures').removeClass('hidden');
                    $(container).find('#btn-request-gestures').addClass('hidden');
                }

//                // render selected gestures
//                if (currentQuestionnaireAnswers) {
//                    renderQuestionnaireAnswers($(container).find('#identified-gestures'), currentQuestionnaireAnswers.data, currentQuestionnaireAnswers.answers, false);
//                }
            } else {
                $(container).find('#btn-start-exploration').removeClass('hidden');
            }
        }



        // scene buttons
        function renderSceneTriggerItems(item, container, data) {
            if (data.exploration && data.exploration[currentExplorationIndex].transitionScenes && data.exploration[currentExplorationIndex].transitionScenes.length > 0) {
                for (var i = 0; i < data.exploration[currentExplorationIndex].transitionScenes.length; i++) {
                    var scene = getSceneById(data.exploration[currentExplorationIndex].transitionScenes[i].sceneId);
                    var transitionItem = $(source).find('#transition-scene-item').clone().attr('id', scene.id);
                    var itemData = $(source).find('#interactive-scenes-catalog-thumbnail').clone().removeAttr('id');
                    $(itemData).find('#info-' + scene.type).removeClass('hidden');
                    $(itemData).find('.btn-text').text(scene.title);
                    $(itemData).find('.scene-description').text(data.exploration[currentExplorationIndex].transitionScenes[i].description);
                    $(transitionItem).find('.scene-data').append(itemData);
                    $(item).find('#transition-scenes').append(transitionItem);
                    $(item).find('#transition-scenes').append(document.createElement('br'));
                    if ((currentExplorationScene > 0 && i === currentExplorationScene) || (currentExplorationScene === 0 && i === 0)) {
                        $(transitionItem).find('.btn-trigger-scene').addClass('btn-primary');
                        $(transitionItem).find('.scene-description').removeClass('hidden');
                    }

                    $(itemData).find('.btn-trigger-scene').unbind('click').bind('click', {scene: scene, index: i}, function (event) {
                        if (!$(this).hasClass('btn-primary') && !$(this).hasClass('disabled')) {
                            $(this).closest('.root').find('.btn-trigger-scene').removeClass('btn-primary');
                            $(this).closest('.root').find('.scene-description').addClass('hidden');
                            $(this).addClass('btn-primary');
                            $(this).parent().parent().find('.scene-description').removeClass('hidden');
                            currentExplorationScene = event.data.index;
                            openPrototypeScene(event.data.scene, data.exploration.length === 1, data.exploration[currentExplorationIndex].transitionScenes[currentExplorationScene].description);
                        }

                        if ($(this).hasClass('disabled')) {
                            $(document).scrollTop(0);
                            wobble(container.find('#general'));
                        }
                    });
                }

                if (currentExplorationIndex > 0) {
                    $(container).find('.btn-trigger-scene').removeClass('disabled');
                }
            } else {
                if (scenesUsedForExploration(data.exploration) === true) {
                    // no scenes available for current exploration item
                    openPrototypeScene(null, data.exploration.length === 1, null, currentExplorationIndex);
                } else {
                    // no scenes used at all
                    $(container).find('#btn-open-prototype').remove();
                    $(container).find('#btn-start-exploration').removeClass('hidden');
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


        // generic buttons
        function initGenericButtons() {
//            $(container).find('#btn-done').unbind('click').bind('click', function (event) {
//                event.preventDefault();
//                if (!$(this).hasClass('disabled')) {
//                    currentPhaseStepDone = true;
//                    $(this).addClass('hidden');
//                    $(container).find('#slides').addClass('hidden');
//                    $(container).find('#identified-gestures').addClass('hidden');
//                    $(container).find('#identified-trigger').addClass('hidden');
//                    $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
//                    wobble([container.find('#general')]);
//                    $(document).scrollTop(0);
//                } else {
//                    if (explorationStartTriggered) {
//                        wobble([container.find('#slides')]);
//                    } else {
//                        wobble([container.find('#general')]);
//                        $(document).scrollTop(0);
//                    }
//                }
//            });

            $(container).find('#btn-next-trigger').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $(this).addClass('hidden');
                    $(container).find('#identified-gestures').addClass('hidden');
                    currentExplorationIndex++;
                    currentExplorationScene = 0;
                    renderExplorationControls();
                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_START_EXPLORATION);
                    }
                } else if (!explorationStartTriggered) {
                    wobble([container.find('#general')]);
                    $(document).scrollTop(0);
                } else {
                    wobble($(container).find('#identified-gestures'));
                }
            });

            $(container).find('#btn-next-gesture').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $(this).addClass('hidden');
                    $(container).find('#identified-trigger').addClass('hidden');
                    currentExplorationIndex++;
                    currentExplorationScene = 0;
                    renderExplorationControls();
                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_START_EXPLORATION);
                    }
                } else if (!explorationStartTriggered) {
                    wobble([container.find('#general')]);
                    $(document).scrollTop(0);
                } else {
                    wobble($(container).find('#identified-trigger'));
                }
            });

            $(container).find('#btn-request-gestures').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $(this).addClass('hidden');
                    $(container).find('#identified-gestures').removeClass('hidden');
                    $(container).find('#btn-next-trigger').addClass('disabled');
                    $(container).find('#btn-stop-screen-sharing').addClass('disabled');
                    $(container).find('#identified-gestures .question-container').empty();
                    appendAlert($(container).find('#identified-gestures'), ALERT_WAITING_FOR_TESTER);
                    explorationPreferredGesturesRequest = true;
                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_REQUEST_PREFERRED_GESTURES, {currentExplorationIndex: currentExplorationIndex});
                    }
                } else {
                    wobble([$(container).find('#general')]);
                    $(document).scrollTop(0);
                }
            });

            $(container).find('#btn-request-trigger').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $(this).addClass('hidden');
                    $(container).find('#identified-trigger').removeClass('hidden');
                    $(container).find('#btn-next-gesture').addClass('disabled');
                    $(container).find('#btn-stop-screen-sharing').addClass('disabled');
                    $(container).find('#identified-trigger .question-container').empty();
                    appendAlert($(container).find('#identified-trigger'), ALERT_WAITING_FOR_TESTER);
                    explorationPreferredGesturesRequest = true;
                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_REQUEST_PREFERRED_TRIGGER, {currentExplorationIndex: currentExplorationIndex});
                    }
                } else {
                    wobble([$(container).find('#general')]);
                    $(document).scrollTop(0);
                }
            });

            $(container).find('#btn-done-exploration').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_NEXT_STEP);
                }

                nextStep();
            });
        }



        // live 
        if (peerConnection) {
            $(peerConnection).unbind(MESSAGE_RESPONSE_PREFERRED_GESTURES).bind(MESSAGE_RESPONSE_PREFERRED_GESTURES, function (event, payload) {
                clearAlerts($(container).find('#identified-gestures'));
                currentQuestionnaireAnswers = payload.answers;

                if (payload.saveAnswers === true) {
                    $(container).find('#btn-next-trigger').removeClass('disabled');
                    $(container).find('#btn-stop-screen-sharing').removeClass('disabled');
                    $(container).find('#btn-done-exploration').removeClass('disabled');
                } else {
                    explorationPreferredGesturesRequest = false;
                    $(container).find('#btn-next-trigger').addClass('disabled');
                    $(container).find('#btn-stop-screen-sharing').addClass('disabled');
                    $(container).find('#btn-done-exploration').addClass('disabled');
                }

                // render selected gestures
                renderQuestionnaireAnswers($(container).find('#identified-gestures'), payload.data, payload.answers, false);

                if (currentExplorationIndex < data.exploration.length - 1) {
                    $(container).find('#btn-next-trigger').removeClass('hidden');
                } else {
                    if (scenesUsedForExploration(data.exploration) === true) {
                        $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
                    } else {
                        $(container).find('#btn-done-exploration').removeClass('hidden');
                    }
                }
            });

            $(peerConnection).unbind(MESSAGE_RESPONSE_PREFERRED_TRIGGER).bind(MESSAGE_RESPONSE_PREFERRED_TRIGGER, function (event, payload) {
                clearAlerts($(container).find('#identified-trigger'));
                currentQuestionnaireAnswers = payload.answers;

                if (payload.saveAnswers === true) {
                    $(container).find('#btn-next-gesture').removeClass('disabled');
                    $(container).find('#btn-stop-screen-sharing').removeClass('disabled');
                    $(container).find('#btn-done-exploration').removeClass('disabled');
                } else {
                    explorationPreferredGesturesRequest = false;
                    $(container).find('#btn-next-gesture').addClass('disabled');
                    $(container).find('#btn-stop-screen-sharing').addClass('disabled');
                    $(container).find('#btn-done-exploration').addClass('disabled');
                }

                // render selected trigger
                renderQuestionnaireAnswers($(container).find('#identified-trigger'), payload.data, payload.answers, false);

                if (currentExplorationIndex < data.exploration.length - 1) {
                    $(container).find('#btn-next-gesture').removeClass('hidden');
                } else {
                    if (scenesUsedForExploration(data.exploration) === true) {
                        $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
                    } else {
                        $(container).find('#btn-done-exploration').removeClass('hidden');
                    }
                }
            });
        }

        // without screen sharing
        $(container).find('#btn-start-exploration').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(this).remove();
            enableControls();
        });

        // screen sharing
        var query = getQueryParams(document.location.search);
        $(container).find('#btn-open-prototype').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var currentScene = getSceneById(data.exploration[currentExplorationIndex].transitionScenes[currentExplorationScene].sceneId);
            if (currentScene) {
                explorationPrototypeOpened = true;
                $(this).remove();
                $(container).find('#btn-start-screen-sharing').removeClass('hidden');
                openPrototypeScene(currentScene, data.exploration.length === 1, data.exploration[currentExplorationIndex].transitionScenes[currentExplorationScene].description, currentExplorationIndex);
            }
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
                        console.warn(error);
                    }, function () {
                        peerConnection.startScreenRecording();
                        $(peerConnection).unbind(MESSAGE_SCREEN_SHARING_ESTABLISHED).bind(MESSAGE_SCREEN_SHARING_ESTABLISHED, function (event) {
                            event.preventDefault();
                            $(container).find('#btn-start-screen-sharing').find('.fa-spin').addClass('hidden');
                            enableControls();
                        });
                        peerConnection.sendMessage(MESSAGE_START_EXPLORATION);
                    });
                } else {
                    enableControls();
                }
            }
        });

        function enableControls() {
            explorationStartTriggered = true;
            wobble([container.find('#slides')]);

            if (data.exploration.length === 1) {
                if (data['askPreferred' + (data.explorationType === 'gestures' ? 'Gesture' : 'Trigger')] === 'yes') {
                    $(container).find('#btn-request-gestures').removeClass('disabled');
                    $(container).find('#btn-request-trigger').removeClass('disabled');
                    console.log($(container).find('#btn-request-trigger'));
                } else {
                    $(container).find('#btn-stop-screen-sharing').removeClass('disabled');
                }
            } else {
                if (data['askPreferred' + (data.explorationType === 'gestures' ? 'Gesture' : 'Trigger')] === 'yes') {
                    $(container).find('#btn-request-gestures').removeClass('disabled');
                    $(container).find('#btn-request-trigger').removeClass('disabled');
                } else {
                    $(container).find('#btn-next-trigger, #btn-next-gesture').removeClass('disabled');
                    $(container).find('#btn-stop-screen-sharing').removeClass('disabled');
                }
            }

            if (scenesUsedForExploration(data.exploration) === true) {
                $(container).find('#btn-start-screen-sharing').addClass('hidden');
                $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
            } else {
                $(container).find('#btn-start-exploration').addClass('hidden');
            }
        }

        $(container).find('#btn-stop-screen-sharing').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                screenSharingStopped = true;
                if (peerConnection) {
                    peerConnection.stopShareScreen(true);
                }
                $(this).addClass('hidden');
                $(container).find('#btn-done-exploration').removeClass('hidden');
                explorationPrototypeOpened = false;
                explorationStartTriggered = false;
                if (prototypeWindow) {
                    prototypeWindow.close();
                    prototypeWindow = null;
                }
            } else {
                if (explorationStartTriggered) {
                    wobble($(container).find('#slides'));
                } else {
                    $(document).scrollTop(0);
                    wobble(container.find('#general'));
                }
            }
        });

        return container;
    },
    initializeRTC: function initializeRTC() {
        // check preview or live mode, and check if webRTC is needed
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
        var target = $('#viewModerator').find('#pinnedRTC');
        $(target).empty().prepend($(source).find('#moderator-web-rtc-placeholder').clone().attr('id', 'web-rtc-placeholder'));
    },
    initializePeerConnection: function initializePeerConnection() {
        if (!peerConnection && !previewModeEnabled) {
            peerConnection = new PeerConnection(false);
            $(peerConnection).unbind(MESSAGE_NEXT_STEP).bind(MESSAGE_NEXT_STEP, function (event, payload) {
                nextStep();
            });

            $(peerConnection).unbind(MESSAGE_CANCEL_SURVEY).bind(MESSAGE_CANCEL_SURVEY, function (event, payload) {
                currentPhaseStepIndex = getThanksStepIndex();
                renderPhaseStep();
                updateProgress();
                if (prototypeWindow) {
                    prototypeWindow.close();
                    prototypeWindow = null;
                }
            });

            $(peerConnection).unbind(MESSAGE_REQUEST_SYNC).bind(MESSAGE_REQUEST_SYNC, function (event, payload) {
                console.log('on sync request');
                pinRTC();
                resetConstraints();
                renderPhaseStep();

                peerConnection.sendMessage(MESSAGE_SYNC_PHASE_STEP, {index: currentPhaseStepIndex});

                peerConnection.stopShareScreen();
                peerConnection.reset();

                if (prototypeWindow) {
                    prototypeWindow.close();
                    prototypeWindow = null;
                }

                $('#custom-modal').find('.modal-content').empty();
                $('#custom-modal').modal('hide');
//                Moderator.resetScreenSharing();
            });

            $(peerConnection).unbind(MESSAGE_SYNC_PHASE_STEP).bind(MESSAGE_SYNC_PHASE_STEP, function (event, payload) {
                console.log('sync phase step', payload.index);

                syncPhaseStep = false;
                currentPhaseStepIndex = payload.index;
                renderPhaseStep();
                updateProgress();
                if (prototypeWindow) {
                    prototypeWindow.close();
                    prototypeWindow = null;
                }
//                Moderator.resetScreenSharing();
            });

            $(peerConnection).unbind('videoAdded').bind('videoAdded', function () {
                if (syncPhaseStep) {
                    peerConnection.sendMessage(MESSAGE_REQUEST_SYNC, {index: currentPhaseStepIndex});
                }
            });

            $(peerConnection).unbind(CONNECTION_STATE_CONNECTED).bind(CONNECTION_STATE_CONNECTED, function () {
                clearAlerts($('#viewModerator'));
                $('#viewModerator').find('#phase-content').removeClass('hidden');
                $('#viewModerator').find('#pinnedRTC').css({opacity: 1});
                updateRTCHeight($('#viewModerator #column-left').width());
            });

            $(peerConnection).unbind(CONNECTION_STATE_DISCONNECTED).bind(CONNECTION_STATE_DISCONNECTED, function () {
                console.log(CONNECTION_STATE_DISCONNECTED);
                if (getCurrentPhase().format !== THANKS) {
                    appendAlert($('#viewModerator'), ALERT_PLEASE_WAIT);
                    $('#viewModerator').find('#phase-content').addClass('hidden');
                    $('#viewModerator').find('#pinnedRTC').css({opacity: 0});
                }
            });

            $(peerConnection).unbind('videoRemoved').bind('videoRemoved', function () {
                console.log('videoRemoved');
                if (getCurrentPhase().format !== THANKS) {
                    appendAlert($('#viewModerator'), ALERT_PLEASE_WAIT);
                    $('#viewModerator').find('#phase-content').addClass('hidden');
                    $('#viewModerator').find('#pinnedRTC').css({opacity: 0});
                }
            });
        }
    },
    appendRTCLiveStream: function appendRTCLiveStream() {
        var currentPhase = getCurrentPhase();
        var options = getPhaseStepOptions(currentPhase.format);
        var query = getQueryParams(document.location.search);
//        var enableDataChannels = options.enableDataChannels && enableDataChannels === 'yes' || false;
        var callerOptions = {
            target: $('#viewModerator').find('#pinnedRTC'),
            callerElement: $('#video-caller'),
            localVideoElement: 'local-stream',
            remoteVideoElement: 'remote-stream',
            sharingVideoElement: '#screen-stream',
            streamControls: $('#stream-controls'),
            localMuteElement: $('#btn-stream-local-mute'),
            pauseStreamElement: $('#btn-pause-stream'),
            remoteMuteElement: $('#btn-stream-remote-mute'),
            indicator: $('#stream-control-indicator'),
            enableWebcamStream: true,
            enableDataChannels: options.enableDataChannels && options.enableDataChannels === 'yes' || false,
            autoRequestMedia: true,
            roomId: query.roomId,
            localStream: {audio: options.moderator.audio, video: options.moderator.video, visualize: options.moderator.visualizeStream, record: options.moderator.recordStream},
            remoteStream: {audio: options.tester.audio, video: options.tester.video}
        };

        $(callerOptions.target).prepend(callerOptions.callerElement);

        peerConnection.update(callerOptions);
        Moderator.keepStreamsPlaying(callerOptions.callerElement);
    },
    keepStreamsPlaying: function keepStreamsPlaying(element) {
        if (peerConnection.status !== STATUS_UNINITIALIZED) {
            var videos = $(element).find('video');
            for (var i = 0; i < videos.length; i++) {
                videos[i].play();
            }
        }
    }
//    initScreenSharing: function initScreenSharing(recordingNeeded) {
//        if (!peerConnectionSharing) {
//            var query = getQueryParams(document.location.search);
//            var roomId = 'screenSharingRoom';
//            if (query.roomId) {
//                roomId = query.roomId + 'sharing';
//            }
//            var callerOptions = {
////                        target: $('#viewModerator').find('#pinnedRTC'),
////                        callerElement: $('#video-caller'),
//                localVideoElement: '',
//                remoteVideoElement: '',
//                sharingVideoElement: '#video-embed',
//                enableWebcamStream: false,
//                enableDataChannels: false,
//                autoRequestMedia: false,
//                roomId: roomId,
//                shareScreen: true,
//                localStream: {audio: 'no', video: 'no', visualize: 'no'},
//                remoteStream: {audio: 'no', video: 'no'}
//            };
//
//            peerConnectionSharing = new PeerConnectionSharing();
//            peerConnectionSharing.initialize(callerOptions);
//        }

//        if (!screenSharingModerator) {
//            var query = getQueryParams(document.location.search);
//            if (query.roomId === undefined) {
//                screenSharingModerator = new ScreenSharing('previewRoom', false);
//            } else {
//                screenSharingModerator = new ScreenSharing(query.roomId + "screensharing", true);
//            }
//        }
//
//        $(screenSharingModerator).unbind('started').bind('started', {message: establishMessage}, function (event) {
//            console.log('screen sharing started: message -> ', event.data.message);
//
//            if (peerConnection) {
//                setTimeout(function () {
//                    $(peerConnection).unbind(MESSAGE_SCREEN_SHARING_ESTABLISHED).bind(MESSAGE_SCREEN_SHARING_ESTABLISHED, function (event) {
//                        event.preventDefault();
//
//                        if (callback) {
//                            callback();
//                        }
//                    });
//
//                    peerConnection.sendMessage(establishMessage);
//                }, 3000);
//            }
//        });
//
//        screenSharingModerator.start();
//    }
//    resetScreenSharing: function resetScreenSharing() {
//        if (screenSharingModerator) {
//            screenSharingModerator.stop();
//            screenSharingModerator = null;
//            $('#screenSharingTarget').empty();
//        }
//    }
};
function renderObservations(data, container) {
    if (data.observations && data.observations.length > 0) {
        if (!previewModeEnabled) {
            var savedObservations = getObservationResults(getCurrentPhase().id);
            console.log('render observations with answers: ', savedObservations, data.observations);
            if (savedObservations && savedObservations.length > 0) {
                renderEditableObservations($(container).find('#observations .question-container'), data.observations, savedObservations);
            } else {
                Moderator.getQuestionnaire($('#item-container-inputs'), $(container).find('#observations'), data.observations, false);
            }

            $(container).find('#observations').on('change', function () {
                var study = getLocalItem(STUDY);
                console.log('save observation answers');
                saveObservationAnwers($(container).find('#observations .question-container'), study.id, study.testerId, getCurrentPhase().id);
            });
        } else {
            Moderator.getQuestionnaire($('#item-container-inputs'), $(container).find('#observations'), data.observations, false);
        }
    } else {
        appendAlert($(container).find('#observations'), ALERT_NO_PHASE_DATA);
    }
}

function checkRTCUploadStatus(container) {
    if (!uploadQueue.allFilesUploaded() && !uploadQueue.allFilesUploaded() && uploadQueue.uploadPending() === true) {
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


function openPrototypeScene(scene, isSingleScene, description, index) {
    var windowSpecs = "location=no,menubar=no,status=no,toolbar=no";
    if (scene !== null) {
        if (prototypeWindow && !prototypeWindow.closed && !isSingleScene) {
            prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: scene}, 'https://gesturenote.de');
        } else if (!prototypeWindow && !isSingleScene) {
            prototypeWindow = window.open("study-execution-prototype-sharing.php?phaseId=" + getCurrentPhase().id + "&type=" + getCurrentPhase().format, "_blank", windowSpecs);
        } else if (!prototypeWindow && isSingleScene === true && (scene.type === SCENE_WEB || scene.type === SCENE_PIDOCO)) {
            prototypeWindow = window.open(scene.parameters.url, "_blank", windowSpecs);
        } else {
            prototypeWindow = window.open("study-execution-prototype-sharing.php?phaseId=" + getCurrentPhase().id + "&type=" + getCurrentPhase().format, "_blank", windowSpecs);
        }
    } else {
        if (prototypeWindow) {
            prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: scene}, 'https://gesturenote.de');
        } else {
            prototypeWindow = window.open("study-execution-prototype-sharing.php?phaseId=" + getCurrentPhase().id + "&type=" + getCurrentPhase().format, "_blank", windowSpecs);
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

function initNextStepButton(container) {
    $(container).find('#btn-next-step').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!previewModeEnabled && peerConnection) {
            peerConnection.sendMessage(MESSAGE_NEXT_STEP);
        }
        nextStep();
    });
}