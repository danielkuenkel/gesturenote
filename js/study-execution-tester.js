/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function Tester() {

}

var singleGUSGesture = null;
var Tester = {
    renderView: function renderView() {
        console.log('render view');
        $('.alert-space').empty();
        var source = getSourceContainer(currentView);
        var item = null;
        var currentPhase = getCurrentPhase();
        var currentPhaseData = getCurrentPhaseData();
        // save start time
        if (previewModeEnabled === false) {
            setLocalItem(currentPhase.id + '.tempSaveData', {startTime: new Date().getTime()});
        }

        if (currentPhaseData || (currentPhaseData && $.isArray(currentPhaseData) && currentPhaseData.length > 0)) {
            Tester.initializePeerConnection();
            //        console.log('clone: ' + currentPhase.format + ', from: ' + source.attr('id'));
            var container = $(source).find('#' + currentPhase.format).clone(false);
            switch (currentPhase.format) {
                case LETTER_OF_ACCEPTANCE:
                    item = Tester.getLetterOfAcceptance(container, currentPhaseData);
                    break;
                case THANKS:
                    item = Tester.getThanks(container, currentPhaseData);
                    break;
                case QUESTIONNAIRE:
                    item = Tester.getQuestionnaire(container, currentPhaseData, true);
                    break;
                case IDENTIFICATION:
                    item = Tester.getIdentification(source, container, currentPhaseData);
                    break;
                case GUS_SINGLE_GESTURES:
                    item = Tester.getGUS(container, currentPhaseData);
                    break;
                case GUS_MULTIPLE_GESTURES:
                    item = Tester.getQuestionnaire(container, getAssembledItems(currentPhaseData.gus), true);
                    break;
                case SUS:
                    item = Tester.getSUS(source, container, currentPhaseData);
                    break;
                case GESTURE_TRAINING:
                    item = Tester.getGestureTraining(source, container, currentPhaseData);
                    break;
                case SLIDESHOW_GESTURES:
                    item = Tester.getGestureSlideshow(source, container, currentPhaseData);
                    break;
                case SLIDESHOW_TRIGGER:
                    item = Tester.getTriggerSlideshow(source, container, currentPhaseData);
                    break;
                case SCENARIO:
                    item = Tester.getScenario(source, container, currentPhaseData);
                    break;
                case PHYSICAL_STRESS_TEST:
                    item = Tester.getPhysicalStressTest(source, container, currentPhaseData);
                    break;
            }

            if (item !== false || item !== null) {
                if (!syncPhaseStep) {
                    $('#viewTester #phase-content').empty().append(item);
                }
                Tester.initializeRTC();
            }

            if (currentPhase.format === THANKS) {
                $('.btn-cancel').addClass('disabled');
            } else {
                $('.btn-cancel').removeClass('disabled');
            }
        } else {
            Tester.renderNoDataView();
        }

        Tester.checkPositioning(currentPhase.format);
        TweenMax.from($('#viewTester #phase-content'), .2, {y: -40, opacity: 0});
        if ($(document).scrollTop() > 0) {
            $(document).scrollTop(0);
        }
    },
    checkPositioning: function checkPositioning(format) {
        var posY = '0px';
        if (previewModeEnabled === false) {
            switch (format) {
                case SCENARIO:
                    break;
                default:
                    posY = '90px';
                    break;
            }
//            $('#viewTester #phase-content').css({marginTop: posY});
        } else {
//            switch (format) {
//                case SCENARIO:
//                    break;
//                default:
//                    posY = '40px';
//                    break;
//            }
        }
//        $('#viewTester #phase-content').css({marginTop: posY});
    },
    renderNoDataView: function renderNoDataView() {
        var alert = $(getSourceContainer(currentView)).find('#no-phase-data').clone().removeAttr('id');
        $('#viewTester #phase-content').append(alert);
        appendAlert(alert, ALERT_NO_PHASE_DATA);
    },
    getLetterOfAcceptance: function getLetterOfAcceptance(container, data) {
        var source = getSourceContainer(VIEW_TESTER);
        var content = $(source).find('#letterOfAcceptance-' + getLocalItem(STUDY).surveyType).clone().removeAttr('id');
        $(container).append(content);
        $(container).find('.letter-text').text(data);
        $(container).find('#letter-agreed').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!previewModeEnabled) {
                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                tempData.accepted = 'yes';
                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);

                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_NEXT_STEP);
                }
            }

            nextStep();
        });
        $(container).find('#letter-decline').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!previewModeEnabled) {
                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                tempData.accepted = 'no';
                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
            }

            $('.btn-cancel').click();
        });
        return container;
    },
    getThanks: function getThanks(container, data) {
        console.log('get thanks');
        var content = $(getSourceContainer(VIEW_TESTER)).find('#thanks-' + getLocalItem(STUDY).surveyType).clone().removeAttr('id');
        $(container).append(content);

        TweenMax.to(container.find('.fa-upload'), .5, {yoyo: true, repeat: -1, opacity: .4});
        $(container).find('#thanks-text').text(data);

        var study = getLocalItem(STUDY);
        var absoluteStaticStudyUrl = 'https://gesturenote.de/study-prepare.php?studyId=' + study.id + '&h=' + study.urlToken;
        $(container).find('#static-study-url').text(absoluteStaticStudyUrl);
        $(container).find('#btn-execution-done').unbind('click').bind('click', function (event) {
            event.preventDefault();
            gotoDashboard();
        });

        $(container).find('#static-study-url').unbind('click').bind('click', function () {
            $(container).find('#static-study-url').select();
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
    getQuestionnaire: function getQuestionnaire(container, data, appendContainer) {
        if (appendContainer === true) {
            var content = $(getSourceContainer(VIEW_TESTER)).find('#questionnaire-' + getLocalItem(STUDY).surveyType).clone().removeAttr('id');
            $(container).append(content);
        }

        $(container).find('.question-container').empty();
        if (data && data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                var item = $('#item-container-inputs').find('#' + data[i].format).clone(false);
                if (data.length > 1) {
                    $(item).find('.question').text(data.length - i + '. ' + data[i].question);
                } else {
                    $(item).find('.question').text(data[i].question);
                }

                $(container).find('.question-container').prepend(item);
//                if (data[i].dimension !== DIMENSION_ANY) {
//                    $(item).find('#dimension').removeClass('hidden');
//                    $(item).find('#dimension').text(translation.dimensions[data[i].dimension]);
//                }

                var parameters = data[i].parameters;
                var options = data[i].options;
                switch (data[i].format) {
                    case DICHOTOMOUS_QUESTION:
                        renderDichotomousQuestionInput(item, parameters);
                        break;
                    case DICHOTOMOUS_QUESTION_GUS:
                        renderDichotomousQuestionGUSInput(item, parameters);
                        break;
                    case GROUPING_QUESTION:
                        renderGroupingQuestionInput(item, parameters, options);
                        break;
                    case GROUPING_QUESTION_GUS:
                        renderGroupingQuestionGUSInput(item, parameters);
                        break;
                    case RATING:
                        renderRatingInput(item, options);
                        break;
                    case SUM_QUESTION:
                        renderSumQuestionInput(item, parameters, options);
                        break;
                    case RANKING:
                        renderRankingInput(item, options);
                        break;
                    case ALTERNATIVE_QUESTION:
                        renderAlternativeQuestionInput(item, data[i]);
                        break;
                    case GUS_SINGLE:
                        renderGUSSingleInput(item, options);
                        break;
                    case COUNTER:
                        renderCounterInput(item, parameters);
                        break;
                }
            }
        }

        $(container).find('#btn-next-phase-step').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!previewModeEnabled && peerConnection) {
                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
            }
        });

        return container;
    },
    getGUS: function getGUS(container, data) {
        var content = $(getSourceContainer(VIEW_TESTER)).find('#gus-' + getLocalItem(STUDY).surveyType).clone().removeAttr('id');
        $(container).append(content);

        var gesture = getGestureById(data.gestureId);
        if (gesture && isGestureAssembled(data.gestureId)) {
            singleGUSGesture = {gestureId: data.gestureId, triggerId: data.triggerId, feedbackId: data.feedbackId};
            container.find('#title').text(gesture.title);
            renderGestureImages(container.find('.previewGesture'), gesture.images, gesture.previewImage, null);
            var trigger = getTriggerById(data.triggerId);
            var feedback = getFeedbackById(data.feedbackId);
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

        } else {
            $(container).find('#gesturePreview').addClass('hidden');
        }

        container = Tester.getQuestionnaire(container, getAssembledItems(data.gus), false);
        return container;
    },
    getSUS: function getSUS(source, container, data) {
        var content = $(getSourceContainer(VIEW_TESTER)).find('#sus-' + getLocalItem(STUDY).surveyType).clone();
        $(container).append(content);

        for (var i = 0; i < data.length; i++) {
            var item = $(source).find('#susItem').clone(false).removeAttr('id');
            item.attr('id', SUS_ITEM);
            $(item).find('.question').text(i + 1 + '. ' + data[i].question);
            renderSusInput(item);
            $(container).find('.question-container').append(item);
        }
        $(container).find('#btn-next-phase-step').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!previewModeEnabled && peerConnection) {
                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
            }
        });
        return container;
    },
    getGestureTraining: function getGestureTraining(source, container, data) {
        // general data section
        $(container).find('.headline').text(data.title);
        $(container).find('.description').text(data.description);
        if (!data.training || data.training.length === 0) {
            return false;
        }

        if (!previewModeEnabled) {
            var currentPhase = getCurrentPhase();
            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
            tempData.training = new Array();
            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
        }

        // gestures section
        if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
            Tester.renderUnmoderatedTraining(source, container, data.training);
        } else {
            if (!previewModeEnabled && peerConnection) {
                $(peerConnection).unbind(MESSAGE_START_GESTURE_TRAINING).bind(MESSAGE_START_GESTURE_TRAINING, function (event, payload) {
                    gestureTrainingStartTriggered = true;
                    container.find('#general').addClass('hidden');

                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    tempData.startTrainingTime = new Date().getTime();
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                });

                $(peerConnection).unbind(MESSAGE_TRAINING_TRIGGERED).bind(MESSAGE_TRAINING_TRIGGERED, function (event, payload) {
                    trainingTriggered = true;
                    currentGestureTrainingIndex = payload.currentGestureTrainingIndex;
                    Tester.renderModeratedTraining(source, container, data.training);

                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    tempData.training.push({gestureId: gesture.id, gestureTrainingStart: new Date().getTime()});
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                });

                $(peerConnection).unbind(MESSAGE_FEEDBACK_TRIGGERED).bind(MESSAGE_FEEDBACK_TRIGGERED, function (event, payload) {
                    Tester.renderModeratedTrainingFeedback(source, {feedbackId: payload.feedbackId});

                    var currentPhase = getCurrentPhase(); // save start training time for a specific gesture
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    for (var i = 0; i < tempData.training.length; i++) {
                        if (parseInt(tempData.training[i].gestureId) === parseInt(payload.gestureId)) {
                            tempData.training[i].gestureTrainingEnd = new Date().getTime();
                        }
                    }
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                });
            }

            if (gestureTrainingStartTriggered) {
                container.find('#general').addClass('hidden');
            }

            if (trainingTriggered) {
                Tester.renderModeratedTraining(source, container, data.training);
            } else {
                appendAlert($(container), ALERT_WAITING_FOR_TRAINING_GESTURE);
            }
        }

        return container;
    },
    renderModeratedTraining: function renderModeratedTraining(source, container, data) {
        clearAlerts(container);
        var trainingData = data[currentGestureTrainingIndex];
        var item = $(source).find('#trainingItemModerated').clone().removeAttr('id');
        $(container).append(item);
        var gesture = getGestureById(trainingData.gestureId);
        var trigger = getTriggerById(trainingData.triggerId);
        var feedback = getFeedbackById(trainingData.feedbackId);
        item.find('#title .address').text(translation.title + ":");
        item.find('#title .text').text(gesture.title);
        item.find('#trigger .address').text(translation.trigger + ":");
        item.find('#trigger .text').text(trigger.title);
        item.find('.btn-popover-gesture-preview').attr('name', gesture.id);
        item.find('#feedback .address').text(translation.feedback + ":");
        $(container).find('#trainingContainer').empty().append(item);

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

            item.find('#feedback .text').text(" " + feedback.title);
            $(label).prepend(icon);
            item.find('#feedback .text').prepend(label);
        } else {
            item.find('#feedback .text').text(translation.nones);
        }

        if (triggeredFeedback) {
            Tester.renderModeratedTrainingFeedback(source, trainingData);
        }

        renderGestureImages(item.find('.previewGesture'), gesture.images, gesture.previewImage, null);
    },
    renderModeratedTrainingFeedback: function renderModeratedTrainingFeedback(source, data) {
        appendHint(source, $('body'), data, TYPE_SURVEY_MODERATED);
        triggeredFeedback = null;
    },
    renderUnmoderatedTraining: function renderUnmoderatedTraining(source, container, data) {
        var trainingData = data[currentGestureTrainingIndex];
        var gesture = getGestureById(trainingData.gestureId);
        var trigger = getTriggerById(trainingData.triggerId);
        var feedback = getFeedbackById(trainingData.feedbackId);
        var repeatsLeft = trainingData.repeats;
        var item = $(source).find('#trainingItemUnmoderated').clone().removeAttr('id');
        $(container).find('#trainingContainer').empty().append(item);
        item.find('#title .address').text(translation.title + ":");
        item.find('#title .text').text(gesture.title);
        item.find('#repeats .address').text(translation.repeats + ":");
        item.find('#repeats .text').text(repeatsLeft);
        item.find('#trigger .address').text(translation.trigger + ":");
        item.find('#trigger .text').text(trigger.title);
        item.find('.btn-popover-gesture-preview').attr('name', gesture.id);
        item.find('#feedback .address').text(translation.feedback + ":");
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

            item.find('#feedback .text').text(" " + feedback.title);
            $(label).prepend(icon);
            item.find('#feedback .text').prepend(label);
        } else {
            item.find('#feedback .text').text(translation.nones);
        }

        if (gestureTrainingStartTriggered) {
            container.find('#general').addClass('hidden');
            item.find('#start-training').addClass('hidden');
            item.find('#start-single-training').removeClass('hidden');
            item.find('#start-single-training').addClass('disabled');
            item.find('#training-data').removeClass('hidden');
            renderGestureImages(item.find('.previewGesture'), gesture.images, gesture.previewImage, function () {
                item.find('#start-single-training').removeClass('disabled');
            });
        }

        // start state handling
        item.find('#start-training').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!previewModeEnabled) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.startTrainingTime = new Date().getTime();
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            }

            $(this).addClass('hidden');
            gestureTrainingStartTriggered = true;
            container.find('#general').addClass('hidden');
            item.find('#start-single-training, #training-data').removeClass('hidden');
            item.find('#start-single-training').addClass('disabled');
            renderGestureImages(item.find('.previewGesture'), gesture.images, gesture.previewImage, function () {
                item.find('#start-single-training').removeClass('disabled');
            });
        });
        // training handler
        item.find('#start-single-training, #repeat-training').unbind('click').bind('click', function (event) {
            event.preventDefault();
//            console.log('start single training');
            if (!$(this).hasClass('disabled')) {

                if ($(this).attr('id') === 'start-single-training' && !previewModeEnabled) {
                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    tempData.training.push({gestureId: gesture.id, gestureTrainingStart: new Date().getTime()});
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                }

                $(item).find('#training-controls').addClass('hidden');
                $(item).find('.progress-training').removeClass('hidden');
                TweenMax.to(item.find('.progress-bar-training'), trainingData.recognitionTime, {width: '0%', autoRound: false, ease: Power0.easeNone, onComplete: onTrainingTimesUp});
            }
        });
        function onTrainingTimesUp() {
            repeatsLeft--;
            appendHint(source, $('body'), trainingData, TYPE_SURVEY_UNMODERATED);
            $(item).find('#training-controls').removeClass('hidden');
            $(item).find('.progress-training').addClass('hidden');
            item.find('.progress-bar').css({width: "100%"});
            if (repeatsLeft === 0) {
                if (!previewModeEnabled) { // save end training time for a specific gesture
                    var currentPhase = getCurrentPhase(); // save start training time for a specific gesture
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                    tempData.training.pop();
                    for (var i = 0; i < tempData.training.length; i++) {
                        if (parseInt(tempData.training[i].gestureId) === parseInt(gesture.id)) {
                            tempData.training[i].gestureTrainingEnd = new Date().getTime();
                        }
                    }
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                }

                item.find('#training-data').addClass('hidden');
                item.find('#start-single-training, #repeat-training').addClass('hidden');
                if (data.length === 1 || currentGestureTrainingIndex >= data.length - 1) {
                    item.find('#training-done').removeClass('hidden');
                } else {
                    item.find('#next-gesture').removeClass('hidden');
                }
            } else {
                item.find('#start-single-training').addClass('hidden');
                item.find('#repeat-training').removeClass('hidden');
            }
        }

        // done & next step
        item.find('#next-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            currentGestureTrainingIndex++;
            item.find('#training-data').removeClass('hidden');
            Tester.renderUnmoderatedTraining(source, container, data);
        });
        item.find('#training-done').unbind('click').bind('click', function (event) {
            event.preventDefault();
            currentGestureTrainingIndex = 0;
            gestureTrainingStartTriggered = false;
            nextStep();
        });
    },
    getGestureSlideshow: function getGestureSlideshow(source, container, data) {
        // general data section
        $(container).find('#general .headline').text(data.title);
        $(container).find('#general .description').text(data.description);
        if (!data.slideshow || data.slideshow.length === 0) {
            return false;
        }

        if (slideshowStartTriggered) {
            $(container).find('#general').remove();
        }

        if (!previewModeEnabled) {
            var currentPhase = getCurrentPhase();
            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
            tempData.actions = new Array();
            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
        }

        if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
            slideRestarted = true;
            Tester.renderUnmoderatedGestureSlideshow(source, container, data);
        } else {
            $(peerConnection).unbind(MESSAGE_START_GESTURE_SLIDESHOW).bind(MESSAGE_START_GESTURE_SLIDESHOW, function (event, payload) {
//                console.log('on ' + MESSAGE_START_GESTURE_SLIDESHOW);
                slideRestarted = true;
                Tester.renderModeratedGestureSlideshowOverview(source, container, data);
            });

            $(peerConnection).unbind(MESSAGE_TRIGGER_GESTURE_SLIDE).bind(MESSAGE_TRIGGER_GESTURE_SLIDE, function (event, payload) {
                event.stopPropagation();
                event.stopImmediatePropagation();
                slideRestarted = false;
                slideTriggered = true;
                currentSlideIndex = parseInt(payload.currentSlideIndex);
                Tester.renderModeratedGestureSlideshow(source, container, data);
            });

            $(peerConnection).unbind(MESSAGE_RESTART_GESTURE_SLIDES).bind(MESSAGE_RESTART_GESTURE_SLIDES, function (event, payload) {
                event.stopPropagation();
                event.stopImmediatePropagation();
                slidesRestartCount++;
                slideRestarted = true;
                slideTriggered = false;
                Tester.renderModeratedGestureSlideshowOverview(source, container, data);
            });

            $(peerConnection).unbind(MESSAGE_GESTURE_PERFORMED).bind(MESSAGE_GESTURE_PERFORMED, function (event, payload) {
                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                tempData.restarts = slidesRestartCount;
                if (payload.fit) {
                    tempData.actions.push({action: payload.action, gestureId: payload.gestureId, triggerId: payload.triggerId, selectedGestureId: payload.selectedGestureId, fit: payload.fit, time: new Date().getTime()});
                } else {
                    tempData.actions.push({action: payload.action, gestureId: payload.gestureId, triggerId: payload.triggerId, selectedGestureId: null, time: new Date().getTime()});
                }

                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
            });

            if (slideshowStartTriggered) {
                if (slideRestarted) {
                    Tester.renderModeratedGestureSlideshowOverview(source, container, data);
                } else if (slideTriggered) {
                    Tester.renderModeratedGestureSlideshow(source, container, data);
                } else {
                    appendAlert($(container), ALERT_WAITING_FOR_SLIDESHOW);
                }
            } else {
                appendAlert($(container), ALERT_WAITING_FOR_SLIDESHOW);
            }
        }

        return container;
    },
    renderModeratedGestureSlideshowOverview: function renderModeratedGestureSlideshowOverview(source, container, data) {
//        console.log('renderModeratedGestureSlideshowOverview', $(container));
        clearAlerts($(container));
        $(container).find('#slideshowContainer').removeClass('hidden').empty();
        $(container).find('#general').addClass('hidden');

        for (var i = 0; i < data.slideshow.length; i++) {
            var item = $(source).find('#gestureSlideshowOverviewItemModerated').clone().removeAttr('id');
            $(container).find('#slideshowContainer').append(item);
            var gesture = getGestureById(data.slideshow[i].gestureId);
            renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage, null);
//            console.log(gesture);
        }
    },
    renderModeratedGestureSlideshow: function renderModeratedGestureSlideshow(source, container, data) {
        $(container).find('.progress').removeClass('hidden');
        clearAlerts($(container));
        var slideData = data.slideshow[currentSlideIndex];
        var item = $(source).find('#gestureSlideshowItemModerated').clone().removeAttr('id');
        $(container).find('#slideshowContainer').removeClass('hidden').empty().append(item);

        if (!previewModeEnabled) {
            var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
            tempData.actions.push({action: ACTION_START_PERFORM_GESTURE, gestureId: slideData.gestureId, triggerId: slideData.triggerId, time: new Date().getTime()});
            setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
        }

        var progress = $(container).find('.progress');
        progress.removeClass('active hidden');
        progress.find('.progress-bar').css({width: '100%', backgroundColor: '#5cb85c'});
        var timeline = new TimelineMax({paused: true, delay: 1, onComplete: onAnswerTimeExpired, onCompleteParams: [container, data]});
        timeline.add("start", 0)
                .to(progress.find('.progress-bar'), parseInt(slideData.recognitionTime), {width: '0%', autoRound: false, backgroundColor: "#d9534f", ease: Power0.easeNone}, "start");
        var trigger = getTriggerById(slideData.triggerId);
        $(item).find('.triggerContainer').removeClass('hidden');
        $(item).find('.triggerContainer .trigger-title').text(trigger.title);
        timeline.play();
    },
    renderUnmoderatedGestureSlideshowOverview: function renderUnmoderatedGestureSlideshowOverview(source, container, data) {
        $(container).find('#slideshowContainer').removeClass('hidden').empty();
        for (var i = 0; i < data.slideshow.length; i++) {
            var item = $(source).find('#gestureSlideshowOverviewItemUnmoderated').clone().removeAttr('id');
            $(container).find('#slideshowContainer').append(item);
            var gesture = getGestureById(data.slideshow[i].gestureId);
            renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage, null);
        }
    },
    renderUnmoderatedGestureSlideshow: function renderUnmoderatedGestureSlideshow(source, container, data, isActive) {
        $(container).find('#slideshowContainer').removeClass('hidden').empty();
        if (slideRestarted) {
            Tester.renderUnmoderatedGestureSlideshowOverview(source, container, data);
        }

        var item = $(source).find('#gestureSlideshowItemUnmoderated').clone().removeAttr('id');
        $(container).find('#slideshowContainer').append(item);
        if (currentSlideIndex === data.slideshow.length) {
            $(item).find('#startSlideshow').text(translation.done);
        }

        if (slideshowStartTriggered) {
            $(container).find('#general').remove();
        }

        if (slideshowStartTriggered && slideRestarted) {
            $(container).find('#restart').removeClass('hidden');
        } else {
            $(container).find('#restart').addClass('hidden');
        }

        if (isActive) {
            var slideData = data.slideshow[currentSlideIndex];
            if (!previewModeEnabled) {
                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                tempData.actions.push({action: ACTION_START_PERFORM_GESTURE, gestureId: slideData.gestureId, triggerId: slideData.triggerId, time: new Date().getTime()});
                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
            }

            var progress = $(container).find('.progress');
            progress.removeClass('active hidden');
            var timeline = new TimelineMax({paused: true, delay: 1, onComplete: onUnmoderatedAnswerTimeExpired, onCompleteParams: [source, container, data]});
            timeline.add("start", 0)
                    .to(progress.find('.progress-bar'), parseInt(slideData.recognitionTime), {width: '0%', autoRound: false, backgroundColor: "#d9534f", ease: Power0.easeNone}, "start")
                    .to($(container).find('.gestureContainer .headline, .triggerContainer .headline'), parseInt(data.answerTime), {color: '#d9534f', ease: Power0.easeNone}, "start");
            var trigger = getTriggerById(slideData.triggerId);
            $(item).find('.triggerContainer').removeClass('hidden');
            $(item).find('.triggerContainer .trigger-title').text(trigger.title);
            timeline.play();
        } else {
            $(item).find('#startSlideshow').removeClass('hidden');
        }

        $(item).find('#startSlideshow').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (currentSlideIndex >= data.slideshow.length) {
                currentSlideIndex = 0;
                slideshowStartTriggered = false;
                nextStep();
            } else {
                slideshowStartTriggered = true;
                slideRestarted = false;
                Tester.renderUnmoderatedGestureSlideshow(source, container, data, true);
            }
        });
    },
    getTriggerSlideshow: function getTriggerSlideshow(source, container, data) {
        var content = $(getSourceContainer(VIEW_TESTER)).find('#triggerSlideshow-' + getLocalItem(STUDY).surveyType).clone();
        $(container).append(content);

        // general data section
        $(container).find('#general .headline').text(data.title);
        $(container).find('#general .description').text(data.description);
        if (!data.slideshow || data.slideshow.length === 0) {
            return false;
        }

        if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
            Tester.renderUnmoderatedTriggerSlideshow(source, container, data);
        } else {
            $(container).find('#startSlideshow').remove();

            $(peerConnection).unbind(MESSAGE_START_TRIGGER_SLIDESHOW).bind(MESSAGE_START_TRIGGER_SLIDESHOW, function (event, payload) {
                slideshowStartTriggered = true;
                Tester.renderUnmoderatedTriggerSlideshow(source, container, data);
            });

            if (slideshowStartTriggered) {
                Tester.renderUnmoderatedTriggerSlideshow(source, container, data);
            } else {
                appendAlert($(container), ALERT_WAITING_FOR_SLIDESHOW);
            }
        }

        return container;
    },
    renderUnmoderatedTriggerSlideshow: function renderUnmoderatedTriggerSlideshow(source, container, data) {
        if (slideshowStartTriggered) {
            clearAlerts(container);
            $(container).find('#general').remove();
            $(container).find('#slideshowContainer').removeClass('hidden');
            $(container).find('#startSlideshow').addClass('hidden');
            var item = $(source).find('#triggerSlideshowItemUnmoderated').clone().removeAttr('id');
            $(container).find('#slideshowContainer').empty().append(item);
            var slideData = data.slideshow[currentSlideIndex];
            var gesture = getGestureById(slideData.gestureId);
            renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage, null);
            var options = new Array();
            for (var i = 0; i < data.slideshow.length; i++) {
                var trigger = getTriggerById(data.slideshow[i].triggerId);
                options.push(trigger);
            }
            var questionnaire = new Array();
            questionnaire.push({format: GROUPING_QUESTION, dimension: DIMENSION_ANY, question: translation.questionTriggerSlideshow, parameters: {multiselect: 'no', optionalanswer: 'no'}, options: options});
            Tester.getQuestionnaire(item, questionnaire);
        }

        if (currentSlideIndex >= data.slideshow.length - 1) {
//            if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
            $(container).find('#btn-next-slide').addClass('hidden');
            $(container).find('#btn-done-slide').removeClass('hidden');
            $(container).find('#btn-next-slide').text(translation.done);
//            } else {
//                $(container).find('#btn-next-slide').removeClass('hidden');
//            }
        } else {
            $(container).find('#btn-next-slide').removeClass('hidden');
        }

        $(container).find('#btn-next-slide').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!previewModeEnabled) {
                saveTriggerSlideshowAnswer(container);
            }

//            console.log(currentSlideIndex);
            if (currentSlideIndex < data.slideshow.length - 1) {
                currentSlideIndex++;
                Tester.renderUnmoderatedTriggerSlideshow(source, container, data);
            }
        });
        if (testerDoneTriggered) {
            $(container).find('#btn-done-slide').addClass('disabled');
            $(container).find('.question-container').addClass('hidden');
        }

        $(container).find('#btn-done-slide').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!previewModeEnabled) {
                saveTriggerSlideshowAnswer(container);
            }

            $(this).addClass('disabled');
            testerDoneTriggered = true;
            $(container).find('.question-container').addClass('hidden');

            if (!previewModeEnabled && peerConnection) {
                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
            }

            nextStep();
        });

        $(container).find('#startSlideshow').unbind('click').bind('click', function (event) {
            event.preventDefault();
            slideshowStartTriggered = true;
            Tester.renderUnmoderatedTriggerSlideshow(source, container, data);
        });

        function saveTriggerSlideshowAnswer(container) {
            var selectedOption = $(container).find('.option-container .btn-option-checked').attr('id');
            selectedOption = selectedOption === undefined ? -1 : selectedOption;
            var currentPhase = getCurrentPhase();
            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                console.log(selectedOption);
            if (tempData.selectedOptions !== null && tempData.selectedOptions !== undefined) {
                tempData.selectedOptions.push({correctTriggerId: slideData.triggerId, selectedId: selectedOption});
            } else {
                var array = new Array();
                array.push({correctTriggerId: slideData.triggerId, selectedId: selectedOption});
                tempData.selectedOptions = array;
            }
            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
        }
    },
    getIdentification: function getIdentification(source, container, data) {
        if (!data.identification || data.identification.length === 0) {
            return false;
        }

        // general data section
        if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
            container.append($(source).find('#identificationUnmoderated').clone().removeAttr('id'));
        } else {
            container.append($(source).find('#identificationModerated').clone().removeAttr('id'));
//            Tester.appendRTCPreview(source, container.find('#column-left'));
        }

        $(container).find('.headline').text(data.title);
        $(container).find('.description').text(data.description);
//        if (identificationStartTriggered) {
//            $(container).find('#general').remove();
//        }

//        if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
        Tester.renderUnmoderatedIdentification(source, container, data);
//        } else {

//            if (identificationTriggered) {
//                Tester.renderUnmoderatedIdentification(source, container, data);
//            } else {
//                appendAlert($(container), ALERT_WAITING_FOR_IDENTIFICATION);
//            }
//        }
        return container;
    },
//    renderModeratedIdentification: function renderModeratedIdentification(source, container, data) {
//        var item = $(source).find('#identificationItemModerated').clone().removeAttr('id');
//        $(container).find('#identificationContainer').append(item);
//        if (data.identificationFor === 'gestures') {
//            $(item).find('#trigger-identification').remove();
//            var trigger = getTriggerById(data.identification[currentIdentificationIndex]);
//            item.find('#trigger #text').text(trigger.title);
//        } else {
//            $(item).find('#gesture-identification').remove();
//            var gesture = getGestureById(data.identification[currentIdentificationIndex]);
//            renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage, null);
//        }
//    },
    renderUnmoderatedIdentification: function renderUnmoderatedIdentification(source, container, data) {
        var item = $(source).find('#identificationItemUnmoderated').clone().removeAttr('id');
        $(container).find('#identificationContainer').empty().append(item);
        $(container).find('#btn-start-identification').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (data.identificationFor === 'gestures') {
                $(container).find('#recorder-description').removeClass('hidden');
            }

            identificationStartTriggered = true;
            $(this).remove();
            $(container).find('#general').remove();
            $(item).find('#identification-content').removeClass('hidden');
        });

        if (identificationStartTriggered) {
            clearAlerts(container);
            $(container).find('#general').remove();
            $(item).find('#btn-start-identification').remove();
            $(item).find('#identification-content').removeClass('hidden');
            if (data.identificationFor === 'gestures') {
                $(container).find('#recorder-description').removeClass('hidden');
            }
        } else {
            appendAlert(container, ALERT_WAITING_FOR_IDENTIFICATION);
        }

        if (data.identificationFor === 'gestures') {
            $(item).find('#trigger-identification').remove();
            var trigger = getTriggerById(data.identification[currentIdentificationIndex].triggerId);
            item.find('#trigger #text').text(trigger.title);
            var gestureRecorder = $('#item-container-gesture-recorder').find('#gesture-recorder-tester').clone().removeAttr('id');
            item.find('#gesture-recorder-container').empty().append(gestureRecorder);
            var options = {
                alertTarget: item.find('#gesture-recorder-container'),
                recorderTarget: gestureRecorder,
                saveGestures: !previewModeEnabled,
                ownerId: getLocalItem(STUDY).studyOwner,
                context: data.identification[currentIdentificationIndex].context
            };
            new GestureRecorder(options);
//            initCheckRecorder(item.find('#gesture-recorder-container'), gestureRecorder, !previewModeEnabled, getLocalItem(STUDY).studyOwner);
            renderBodyJoints(gestureRecorder.find('#human-body'));
            var recorderDescription = $('#item-container-gesture-recorder').find('#gesture-recorder-description').clone();
            container.find('#recorder-description').empty().append(recorderDescription);

            $(gestureRecorder).unbind(EVENT_GR_UPDATE_STATE).bind(EVENT_GR_UPDATE_STATE, function (event, type) {
                var descriptions = $('#item-container-gesture-recorder').find('#' + type).clone();
                recorderDescription.empty().append(descriptions);
                TweenMax.from(descriptions, .3, {y: -20, opacity: 0, clearProps: 'all'});
            });

            $(gestureRecorder).unbind(EVENT_GR_SAVE_SUCCESS).bind(EVENT_GR_SAVE_SUCCESS, function (event, gestureId) {
                event.preventDefault();
                $(item).find('#next-controls').removeClass('hidden');
                if (!previewModeEnabled) {
                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    if (tempData.gestures !== null && tempData.gestures !== undefined) {
                        tempData.gestures.push(gestureId);
                    } else {
                        var array = new Array();
                        array.push(parseInt(gestureId));
                        tempData.gestures = array;
                    }
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                }
            });

            $(gestureRecorder).unbind(EVENT_GR_DELETE_SUCCESS).bind(EVENT_GR_DELETE_SUCCESS, function (event, gestureId) {
                event.preventDefault();
                $(item).find('#next-controls').addClass('hidden');

                if (!previewModeEnabled) {
                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    var gestures = new Array();
                    for (var i = 0; i < tempData.gestures.length; i++) {
                        if (parseInt(tempData.gestures[i]) !== parseInt(gestureId)) {
                            gestures.push(tempData.gestures[i]);
                        }
                    }
                    tempData.gestures = gestures;
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                }
            });
        } else {
            $(item).find('#gesture-identification').remove();
            var gesture = getGestureById(data.identification[currentIdentificationIndex].gestureId);
            renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage, function () {
            });
        }

        if (data.identification.length === 1 || currentIdentificationIndex >= data.identification.length - 1) {
            $(item).find('#next-identification').remove();
            $(item).find('#done-identification').unbind('click').bind('click', function (event) {
                event.preventDefault();
                currentIdentificationIndex = 0;
                identificationStartTriggered = false;
                if (data.identificationFor === 'trigger' && !previewModeEnabled) {
                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    var triggerName = $(item).find('#trigger-identification #trigger-name').val();
                    var triggerJusticigation = $(item).find('#trigger-identification #trigger-justification').val();
                    if (tempData && tempData.trigger) {
                        tempData.trigger.push({name: triggerName, justification: triggerJusticigation});
                    } else {
                        var trigger = new Array();
                        trigger.push({name: triggerName, justification: triggerJusticigation});
                        tempData.trigger = trigger;
                    }

                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                }

                nextStep();
            });
        } else if (currentIdentificationIndex < data.identification.length) {
            $(item).find('#done-identification').remove();
            $(item).find('#next-identification').unbind('click').bind('click', function (event) {
                event.preventDefault();
                currentIdentificationIndex++;
                if (!previewModeEnabled && data.identificationFor === 'trigger') {
                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    var triggerName = $(item).find('#trigger-identification #trigger-name').val();
                    var triggerJustification = $(item).find('#trigger-identification #trigger-justification').val();
                    if (tempData && tempData.trigger) {
                        tempData.trigger.push({name: triggerName, justification: triggerJustification});
                    } else {
                        var trigger = new Array();
                        trigger.push({name: triggerName, justification: triggerJustification});
                        tempData.trigger = trigger;
                    }

                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                }

                $(item).find('#next-controls').addClass('hidden');
                Tester.renderUnmoderatedIdentification(source, container, data);
            });
        }
    },
    getPhysicalStressTest: function getPhysicalStressTest(source, container, data) {
        if (!data.stressTestItems || data.stressTestItems.length === 0) {
            return false;
        }

        // general data section
        $(container).find('.headline').text(data.title);
        $(container).find('.description').text(data.description);
        if (data.stressTestItems.length === 0) {
            appendAlert($('#mainContent'), ALERT_NO_PHASE_DATA);
            return container;
        }

        if (stressTestStartTriggered) {
            $(container).find('#general').remove();
        }

        if (!previewModeEnabled) {
            var currentPhase = getCurrentPhase();
            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
            tempData.startStressTestTime = new Date().getTime();
            tempData.actions = new Array();
            tempData.answers = new Array();
            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
        }

        if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
            container.find('#btn-start-stress-test').removeClass('hidden');
            container.find('#btn-start-stress-test').unbind('click').bind('click', function (event) {
                event.preventDefault();

                $(this).remove();
                $(container).find('#general').remove();
                stressTestStartTriggered = true;
                stressTestGestureTriggered = true;
                Tester.renderUnmoderatedPhysicalStressTest(source, container, data);
            });
        } else {
            if (stressTestGestureTriggered || stressTestQuestionsTriggered) {
                Tester.renderModeratedPhysicalStressTest(source, container, data);
            } else {
                if (!previewModeEnabled && peerConnection) {
                    $(peerConnection).unbind(MESSAGE_START_STRESS_TEST).bind(MESSAGE_START_STRESS_TEST, function (event, payload) {
                        stressTestStartTriggered = true;
                        $(container).find('#general').remove();
                    });

                    $(peerConnection).unbind(MESSAGE_TRIGGER_STRESS_TEST_GESTURE).bind(MESSAGE_TRIGGER_STRESS_TEST_GESTURE, function (event, payload) {
                        clearAlerts($(container));
                        stressTestGestureTriggered = true;
                        stressTestQuestionsTriggered = false;
                        currentStressTestCount = parseInt(payload.count);
                        currentStressTestIndex = parseInt(payload.index);
                        Tester.renderModeratedPhysicalStressTest(source, container, data);
                    });

                    $(peerConnection).unbind(MESSAGE_TRIGGER_STRESS_TEST_QUESTION).bind(MESSAGE_TRIGGER_STRESS_TEST_QUESTION, function (event, payload) {
                        stressTestGestureTriggered = false;
                        stressTestQuestionsTriggered = true;
                        currentStressTestCount = parseInt(payload.count);
                        currentStressTestIndex = parseInt(payload.index);
                        Tester.renderModeratedPhysicalStressTest(source, container, data);
                    });

                    $(peerConnection).unbind(MESSAGE_TRIGGER_NEXT_STRESS_TEST_GESTURE).bind(MESSAGE_TRIGGER_NEXT_STRESS_TEST_GESTURE, function (event, payload) {
                        appendAlert($(container), ALERT_WAITING_FOR_IDENTIFICATION);
                        stressTestGestureTriggered = false;
                        stressTestQuestionsTriggered = false;
                        $(container).find('#stressTestContainer').empty();
                    });
                }

                appendAlert($(container), ALERT_WAITING_FOR_IDENTIFICATION);
            }
        }

        return container;
    },
    renderModeratedPhysicalStressTest: function renderModeratedPhysicalStressTest(source, container, data) {
        var item = $(source).find('#physicalStressTestModerated').clone().removeAttr('id');
        $(container).find('#stressTestContainer').removeClass('hidden').empty().append(item);
        var gesture = getGestureById(data.stressTestItems[currentStressTestIndex]);
        renderGestureImages($(container).find('.previewGesture'), gesture.images, gesture.previewImage, null);

        var questionContainer = $(container).find('#stress-test-questionnaire');
        if (stressTestQuestionsTriggered) {
            questionContainer.removeClass('hidden');
            if (!previewModeEnabled) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.actions.push({action: ACTION_END_PERFORM_GESTURE, gestureId: gesture.id, time: new Date().getTime()});
                tempData.actions.push({action: ACTION_START_QUESTIONNAIRE, gestureId: gesture.id, time: new Date().getTime()});
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            }

            // single questions section
            if (currentStressTestCount <= parseInt(data.stressAmount) - 1) {
                console.log('render single stress test questions', data.singleStressQuestions, data.singleStressGraphicsRating);
                if (data.singleStressQuestions && data.singleStressQuestions.length > 0 || data.singleStressGraphicsRating !== 'none') {
                    $(questionContainer).removeClass('hidden');
                    $(item).find('#btn-questionnaire-done, #questionnaire-heading, #single-questions').removeClass('hidden');
                    $(item).find('#general-repeats, #btn-gesture-done').addClass('hidden');
                    $(item).find('#gesturePreview').removeClass('col-sm-12').addClass('col-sm-5');
                    if (data.singleStressQuestions && data.singleStressQuestions.length > 0) {
                        Tester.getQuestionnaire(questionContainer.find('#single-questions'), data.singleStressQuestions, false);
                    }
                }
                renderSelectionRatingGraphics($(item).find('#single-joint-selection'), data.singleStressGraphicsRating);
            }

            // sequence questions section, only if last currenStressTestCount were reached
            if (currentStressTestCount >= parseInt(data.stressAmount) - 1) {
                console.log('render multiple stress test questions');
                if (data.sequenceStressQuestions && data.sequenceStressQuestions.length > 0 || data.sequenceStressGraphicsRating !== 'none') {
                    $(questionContainer).removeClass('hidden');
                    $(item).find('#btn-questionnaire-done, #questionnaire-heading, #sequence-questions').removeClass('hidden');
                    $(item).find('#general-repeats, #btn-gesture-done').addClass('hidden');
                    $(item).find('#gesturePreview').removeClass('col-sm-12').addClass('col-sm-5');
                    if (data.sequenceStressQuestions && data.sequenceStressQuestions.length > 0) {
                        Tester.getQuestionnaire(questionContainer.find('#sequence-questions'), data.sequenceStressQuestions, false);
                    }
                }
                renderSelectionRatingGraphics($(item).find('#sequence-joint-selection'), data.sequenceStressGraphicsRating);
            }
        } else {
            questionContainer.addClass('hidden');
        }

        $(container).find('#btn-done-questionnaire').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(container).find('#stressTestContainer').addClass('hidden');
            Tester.savePhysicalStressTestAnswers(item, data, gesture);
            appendAlert($(container), ALERT_WAITING_FOR_IDENTIFICATION);
            questionContainer.addClass('hidden');

            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_REACTIVATE_CONTROLS);
            }
        });
    },
    renderUnmoderatedPhysicalStressTest: function renderUnmoderatedPhysicalStressTest(source, container, data) {
        var item = $(source).find('#physicalStressTestUnmoderated').clone().removeAttr('id');
        $(container).find('#stressTestContainer').empty().append(item);
        var gesture = getGestureById(data.stressTestItems[currentStressTestIndex]);
        renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage, null);

        if (!previewModeEnabled) {
            var currentPhase = getCurrentPhase();
            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
            tempData.actions.push({action: ACTION_START_PERFORM_GESTURE, gestureId: gesture.id, time: new Date().getTime()});
            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
        }

        $(item).find('#btn-gesture-done').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!previewModeEnabled) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.actions.push({action: ACTION_END_PERFORM_GESTURE, gestureId: gesture.id, time: new Date().getTime()});
                tempData.actions.push({action: ACTION_START_QUESTIONNAIRE, gestureId: gesture.id, time: new Date().getTime()});
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            }

            // single questions section
            var questionContainer = $(container).find('#stress-test-questionnaire');
            if (currentStressTestCount <= parseInt(data.stressAmount) - 1) {
                if (data.singleStressQuestions && data.singleStressQuestions.length > 0 || data.singleStressGraphicsRating !== 'none') {
                    $(questionContainer).removeClass('hidden');
                    $(item).find('#btn-questionnaire-done, #questionnaire-heading, #single-questions').removeClass('hidden');
                    $(item).find('#general-repeats, #btn-gesture-done').addClass('hidden');
                    $(item).find('#gesturePreview').removeClass('col-sm-12').addClass('col-sm-5');
                    if (data.singleStressQuestions && data.singleStressQuestions.length > 0) {
                        Tester.getQuestionnaire(questionContainer.find('#single-questions'), data.singleStressQuestions);
                    }
                }
                renderSelectionRatingGraphics($(item).find('#single-joint-selection'), data.singleStressGraphicsRating);
            }

            // sequence questions section, only if last currenStressTestCount were reached
            if (currentStressTestCount >= parseInt(data.stressAmount) - 1) {
                if (data.sequenceStressQuestions && data.sequenceStressQuestions.length > 0 || data.sequenceStressGraphicsRating !== 'none') {
                    $(questionContainer).removeClass('hidden');
                    $(item).find('#btn-questionnaire-done, #questionnaire-heading, #sequence-questions').removeClass('hidden');
                    $(item).find('#general-repeats, #btn-gesture-done').addClass('hidden');
                    $(item).find('#gesturePreview').removeClass('col-sm-12').addClass('col-sm-5');
                    if (data.sequenceStressQuestions && data.sequenceStressQuestions.length > 0) {
                        Tester.getQuestionnaire(questionContainer.find('#sequence-questions'), data.sequenceStressQuestions);
                    }
                }
                renderSelectionRatingGraphics($(item).find('#sequence-joint-selection'), data.sequenceStressGraphicsRating);
            }

            // check current state
            if (currentStressTestIndex === data.stressTestItems.length - 1 && currentStressTestCount >= parseInt(data.stressAmount) - 1) {
                $(this).addClass('hidden');
                $(item).find('#btn-questionnaire-done').addClass('hidden');
                $(item).find('#btn-done').removeClass('hidden');
            } else if (currentStressTestCount >= parseInt(data.stressAmount) - 1) {
                $(this).addClass('hidden');
                $(item).find('#btn-questionnaire-done').addClass('hidden');
                $(item).find('#btn-next-gesture').removeClass('hidden');
            }
        });

        $(item).find('#btn-questionnaire-done').unbind('click').bind('click', function (event) {
            event.preventDefault();
            Tester.savePhysicalStressTestAnswers(item, data, gesture);
            currentStressTestCount++;
            $(item).find('#general-repeats').removeClass('hidden');
            $(item).find('#questionnaire-heading').addClass('hidden');
            $(this).addClass('hidden');
            $(item).find('#btn-gesture-done').removeClass('hidden');
            $(item).find('#gesturePreview').removeClass('col-sm-5').addClass('col-sm-12');
            $(item).find('#stress-test-questionnaire').addClass('hidden');
            if (!previewModeEnabled) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.actions.push({action: ACTION_START_PERFORM_GESTURE, gestureId: gesture.id, time: new Date().getTime()});
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            }
        });

        $(item).find('#btn-next-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            Tester.savePhysicalStressTestAnswers(item, data, gesture);
            currentStressTestCount = 0;
            currentStressTestIndex++;
            Tester.renderUnmoderatedPhysicalStressTest(source, container, data);
        });

        $(item).find('#btn-done').unbind('click').bind('click', function (event) {
            event.preventDefault();
            Tester.savePhysicalStressTestAnswers(item, data, gesture);
            nextStep();
//            Tester.renderUnmoderatedPhysicalStressTest(source, container, data);
        });
    },
    savePhysicalStressTestAnswers: function savePhysicalStressTestAnswers(target, data, gesture) {
        // save joints and questionnaire answers if in live mode
        if (!previewModeEnabled) {
            var answers = new Object();
            var singleQuestionnaire = $(target).find('#single-questions .question-container').children();
            var singleQuestionAnswers = getQuestionnaireFormData(singleQuestionnaire, {});
//                console.log(data.singleStressGraphicsRating, data.sequenceStressGraphicsRating);

            if (currentStressTestCount < parseInt(data.stressAmount) - 1) {
                if (singleQuestionAnswers.answers && singleQuestionAnswers.answers.length > 0) {
                    answers.singleAnswers = singleQuestionAnswers;
                }

                getJointSelectionRatings(answers.singleAnswers, data.singleStressGraphicsRating, $(target).find('#single-joint-selection'));
            } else {
                if (singleQuestionAnswers.answers && singleQuestionAnswers.answers.length > 0) {
                    answers.singleAnswers = singleQuestionAnswers;
                }
                getJointSelectionRatings(answers.singleAnswers, data.singleStressGraphicsRating, $(target).find('#single-joint-selection'));
                var sequenceQuestionnaire = $(target).find('#sequence-questions .question-container').children();
                var sequenceQuestionAnswers = singleQuestionAnswers = getQuestionnaireFormData(sequenceQuestionnaire, {});
                if (sequenceQuestionAnswers.answers && sequenceQuestionAnswers.answers.length > 0) {
                    answers.sequenceAnswers = sequenceQuestionAnswers;
                }
                getJointSelectionRatings(answers.sequenceAnswers, data.sequenceStressGraphicsRating, $(target).find('#sequence-joint-selection'));
            }

//                answers = getQuestionnaireFormData(questionnaire, answers);
//                answers.selectedBodyJoints = getSelectedJoints($(item).find('#human-body-selection-rating'));
//                answers.selectedHandJoints = getSelectedJoints($(item).find('#hand-selection-rating'));
            answers.gestureId = gesture.id;
            answers.time = new Date().getTime();
            var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                console.log(currentStressTestCount, data.stressAmount, currentStressTestIndex, data.stressTestItems.length);
            if (currentStressTestIndex < data.stressTestItems.length - 1) {
                tempData.actions.push({action: ACTION_END_QUESTIONNAIRE, gestureId: gesture.id, time: new Date().getTime()});
            }
            tempData.answers.push(answers);
            setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
        }
    },
    getScenario: function getScenario(source, container, data) {
        if (!data.scene || !data.woz) {
            return false;
        }

        if (!previewModeEnabled) {
            var currentPhase = getCurrentPhase();
            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
            tempData.actions = new Array();
            tempData.transitions = new Array();
            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
        }

        if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
            Tester.renderUnmoderatedScenario(source, container, data);
        } else {
            Tester.renderModeratedScenario(source, container, data);

            $(peerConnection).unbind(MESSAGE_START_SCENARIO).bind(MESSAGE_START_SCENARIO, function (event, payload) {
                event.preventDefault();
                scenarioStartTriggered = true;
                Tester.renderModeratedScenario(source, container, data);
                
                var time = new Date().getTime();
                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                tempData.actions.push({action: ACTION_START_TASK, time: time});
                tempData.transitions.push({scene: data.scene, time: time});
                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
            });
        }

        return container;
    },
    renderModeratedScenario: function renderModeratedScenario(source, container, data) {
        var sceneItem;
        $(container).css({marginTop: '0px'});
        $(container).find('#fixed-rtc-preview').css({top: '64px', opacity: '0.8'});
        container.find('#generalPanel').css({marginTop: '54px'});

        // handle scenario start state
        if (scenarioStartTriggered) {
            clearAlerts(container);
            $(container).find('#fixed-rtc-preview').removeClass('hidden');
            if (currentTriggeredSceneId) {
                sceneItem = renderSceneItem(source, container, currentTriggeredSceneId);
            } else {
                sceneItem = renderSceneItem(source, container, data.scene);
            }
            container.find('#generalPanel').remove();
            sceneItem.removeClass('hidden');
        } else {
            var panelContent = $(source).find('#scenario-panel-moderated').clone();
            container.find('#generalPanel').append(panelContent);
            container.find('#generalPanel').removeClass('hidden');
            appendAlert($(container), ALERT_WAITING_FOR_SCENARIO_START);
            $(container).find('#fixed-rtc-preview').addClass('hidden');
        }

        // handle triggered help & woz
        if (previewModeEnabled) {
            checkHelp();
            checkWOZ();
        } else {
            $(peerConnection).unbind(MESSAGE_TRIGGER_WOZ).bind(MESSAGE_TRIGGER_WOZ, function (event, payload) {
//                console.log(messageData);
                triggeredWoz = payload.triggeredWOZ;
                currentWOZScene = payload.currentWOZScene;
                
                checkWOZ();
            });

            $(peerConnection).unbind(MESSAGE_TRIGGER_HELP).bind(MESSAGE_TRIGGER_HELP, function (event, payload) {
//                console.log(messageData.options.help);
                triggeredHelp = payload.help;
                checkHelp();
            });

            $(peerConnection).unbind(MESSAGE_RELOAD_SCENE).bind(MESSAGE_RELOAD_SCENE, function (event, payload) {
                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                tempData.actions.push({action: ACTION_REFRESH_SCENE, scene: data.scene, time: new Date().getTime()});
                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                
                renderModeratedScenario(source, container, data);
            });
        }

        function checkHelp() {
            if (triggeredHelp) {
                loadHTMLintoModal('custom-modal', 'modal-help.php', 'modal-md');
            }
        }

        function checkWOZ() {
            if (triggeredWoz && currentWOZScene.type !== SCENE_PIDOCO) {
//            console.log(triggeredWoz.transitionId);
                if (triggeredWoz.transitionId !== 'none') {
                    currentTriggeredSceneId = triggeredWoz.transitionId;
                } else {
                    currentTriggeredSceneId = triggeredWoz.sceneId;
                }

                var transitionScene = getSceneById(currentTriggeredSceneId);
//            console.log(triggeredWoz, transitionScene, currentTriggeredSceneId)

                var hint = appendHint(source, $('body'), triggeredWoz, TYPE_SURVEY_MODERATED);
                if (hint !== null) {
                    $(hint).on('hint.hidden', function () {
                        if (transitionScene) {
                            renderSceneItem(source, container, currentTriggeredSceneId);
                        }
                        triggeredWoz = null;
                    });
                } else {
                    if (transitionScene) {
                        renderSceneItem(source, container, currentTriggeredSceneId);
                    }
                    triggeredWoz = null;
                }
            }
        }
    },
    renderUnmoderatedScenario: function renderUnmoderatedScenario(source, container, data) {
        var panelContent = $(source).find('#scenario-panel-unmoderated').clone();
        container.find('#generalPanel').empty().append(panelContent);
        panelContent.find('#more-text').text(translation.more);
        panelContent.find('#less-text').text(translation.less);
        panelContent.find('#task-header').text(translation.task + ":");
        panelContent.find('#task-text').text(data.description);
        container.find('#generalPanel').removeClass('hidden');
        container.find('#info-content').removeClass('hidden');
        container.find('#start-controls').removeClass('hidden');
        var panelOffset, panelHeight = 0;

        // button functions
        container.find('#btn-show-scenario-info').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('hidden')) {

                $(this).addClass('hidden');
                if (!previewModeEnabled) {
                    var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                    tempData.actions.push({action: ACTION_SHOW_INFO, time: new Date().getTime()});
                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                }
            }

            showScenarioInfos(container);
            panelOffset = container.find('#generalPanel').offset().top;
            panelHeight = container.find('#generalPanel').height();
            container.find('#fixed-rtc-preview').css({marginTop: panelHeight + 20, opacity: .5});
        });

        container.find('#btn-hide-scenario-info').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('hidden')) {

                $(this).addClass('hidden');
                if (!previewModeEnabled) {
                    var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                    tempData.actions.push({action: ACTION_HIDE_INFO, time: new Date().getTime()});
                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                }
            }

            hideScenarioInfos(container);
            panelOffset = container.find('#generalPanel').offset().top;
            panelHeight = container.find('#generalPanel').height();
            container.find('#fixed-rtc-preview').css({marginTop: panelHeight + 20, opacity: .6, pointerEvents: 'none'});
        });

        var sceneItem;
        if (scenarioStartTriggered) {
            if (currentWOZScene) {
                sceneItem = renderSceneItem(source, container, currentWOZScene.id);
            } else {
                sceneItem = renderSceneItem(source, container, data.scene);
            }
            container.find('#start-controls').addClass('hidden');
            container.find('#normal-controls').removeClass('hidden');
            container.find('#btn-hide-scenario-info').click();
        }

        container.find('#start-scene').unbind('click').bind('click', function () {
            if (!previewModeEnabled) {
                var time = new Date().getTime();
                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                tempData.actions.push({action: ACTION_START_TASK, time: time});
                tempData.transitions.push({scene: data.scene, time: time});
                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
            }

            container.find('#start-controls').addClass('hidden');
            container.find('#normal-controls').removeClass('hidden');
            sceneItem = renderSceneItem(source, container, data.scene);
            sceneItem.removeClass('hidden');
            container.find('#btn-hide-scenario-info').click();
            scenarioStartTriggered = true;
            currentWOZScene = getSceneById(data.scene);
            container.find('#fixed-rtc-preview').removeClass('hidden');
        });

        $(container).find('#btn-refresh-scene').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!previewModeEnabled) {
                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                tempData.actions.push({action: ACTION_REFRESH_SCENE, scene: data.scene, time: new Date().getTime()});
                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
            }

            renderUnmoderatedScenario(source, container, data);
        });

        $(panelContent).find('#btn-perform-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(this).addClass('hidden');
            if (!previewModeEnabled) {
                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                tempData.actions.push({action: ACTION_START_PERFORM_GESTURE, time: new Date().getTime()});
                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
            }

            $(panelContent).find('#btn-stop-perform-gesture').removeClass('hidden');
        });

        $(panelContent).find('#btn-stop-perform-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(this).addClass('hidden');
            if (!previewModeEnabled) {
                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                tempData.actions.push({action: ACTION_END_PERFORM_GESTURE, time: new Date().getTime()});
                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
            }

            $(panelContent).find('#btn-perform-gesture').removeClass('hidden');
            loadHTMLintoModal('custom-modal', 'modal-select-transition.php', 'modal-lg');
        });

        $(panelContent).find('#btn-getting-help').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!previewModeEnabled) {
                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                tempData.actions.push({action: ACTION_REQUEST_HELP, time: new Date().getTime()});
                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
            }

            loadHTMLintoModal('custom-modal', 'modal-help.php', 'modal-md');
        });

        $(panelContent).find('#btn-done').unbind('click').bind('click', function (event) {
            event.preventDefault();
            nextStep();
        });
    },
    initializeRTC: function initializeRTC() {
        // check preview or live mode, and check if webRTC is needed
        if (isWebRTCNeededInFuture()) {
            if (previewModeEnabled === true) {
                Tester.appendRTCPreviewStream();
            } else {
                Tester.appendRTCLiveStream();
            }
        } else {
//            resetLiveStream();
        }
    },
    appendRTCPreviewStream: function appendRTCPreviewStream() {
        var currentPhase = getCurrentPhase();
        var source = getSourceContainer(currentView);
        var target = $('#viewTester').find('#column-left');

        switch (currentPhase.format) {
            case SCENARIO:
                target = $('#fixed-rtc-preview');
                break;
        }
//        console.log($(source).find('#tester-web-rtc-placeholder'));
        $(target).empty().append($(source).find('#tester-web-rtc-placeholder').clone().removeAttr('id'));
    },
    initializePeerConnection: function initializePeerConnection() {
        if (!peerConnection && !previewModeEnabled && isWebRTCNeededInFuture()) {
            peerConnection = new PeerConnection(true);

            if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_MODERATED) {
                $(peerConnection).unbind(MESSAGE_NEXT_STEP).bind(MESSAGE_NEXT_STEP, function (event, payload) {
                    console.log('next step received');
                    nextStep();
                });

                $(peerConnection).unbind(MESSAGE_CANCEL_SURVEY).bind(MESSAGE_CANCEL_SURVEY, function (event, payload) {
//                    console.log('on cancel survey');
                    var study = getLocalItem(STUDY);
                    study.aborted = 'yes';
                    setLocalItem(STUDY, study);
                    saveCurrentStatus(false);

                    peerConnection.stopRecording(function () {
                        currentPhaseStepIndex = getThanksStepIndex();
                        renderPhaseStep();
                        updateProgress();
                    }, true);
                });

                $(peerConnection).unbind(MESSAGE_REQUEST_SYNC).bind(MESSAGE_REQUEST_SYNC, function (event, payload) {
                    console.log('on sync request');

                    peerConnection.sendMessage(MESSAGE_SYNC_PHASE_STEP, {index: currentPhaseStepIndex});
                    if (getCurrentPhase().format !== THANKS) {

                        console.log('render phase step: ' + currentPhaseStepIndex);
                        peerConnection.stopRecording(function () {
                            resetConstraints();
                            renderPhaseStep();
                        }, false);
                    }
                });

                $(peerConnection).unbind(MESSAGE_SYNC_PHASE_STEP).bind(MESSAGE_SYNC_PHASE_STEP, function (event, payload) {
                    console.log('on sync phase step', payload.index);
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
            }
        }
    },
    appendRTCLiveStream: function appendRTCLiveStream() {
        var currentPhase = getCurrentPhase();
        var target = $('#viewTester').find('#column-left');
        switch (currentPhase.format) {
            case SCENARIO:
                target = $('#viewTester').find('#fixed-rtc-preview');
                break;
        }

        var options = getPhaseStepOptions(currentPhase.format);
        var query = getQueryParams(document.location.search);
        var callerOptions = {
            target: target,
            callerElement: $('#video-caller'),
            localVideoElement: 'local-stream',
            remoteVideoElement: 'remote-stream',
            enableDataChannels: options.enableDataChannels && options.enableDataChannels === 'yes' || false,
            roomId: query.roomId,
            localStream: {audio: options.tester.audio, video: options.tester.video, visualize: options.tester.visualizeStream, record: options.tester.recordStream},
            remoteStream: {audio: options.moderator.audio, video: options.moderator.video}
        };

        if (callerOptions.localStream.video === 'yes' || callerOptions.remoteStream.video === 'yes') {
            $(callerOptions.target).prepend(callerOptions.callerElement);
        } else {
            console.log('dont add video-caller');
        }

        peerConnection.update(callerOptions);
        if (peerConnection.status !== STATUS_UNINITIALIZED) {
            var videos = $(callerOptions.callerElement).find('video');
            for (var i = 0; i < videos.length; i++) {
                videos[i].play();
            }
        }
    }
};

function checkRTCUploadStatus(container) {
    if (isUploadRecordingNeeded()) {
        console.log('sumbmit final data with upload queue');
        submitFinalData(container, false);
        $(uploadQueue).unbind(EVENT_ALL_FILES_UPLOADED).bind(EVENT_ALL_FILES_UPLOADED, function () {
            console.log('allVideosUploaded');
            $(uploadQueue).unbind(EVENT_ALL_FILES_UPLOADED);
            submitFinalData(container, true);
        });
    } else {
        console.log('sumbmit final data without upload queue');
        submitFinalData(container, true);
    }
}

function submitFinalData(container, areAllRTCsUploaded) {
    $(container).find('#upload-instructions').removeClass('hidden');
    $(container).find('#upload-done, #study-share, #upload-retry, #btn-execution-done').addClass('hidden');
    if (!areAllRTCsUploaded) {
        $(container).find('#rtc-uploads').addClass('hidden');
    } else {
        $(container).find('#rtc-uploads').removeClass('hidden');
    }

    saveCurrentStatus(areAllRTCsUploaded, function (result) {
        if (result.status === RESULT_SUCCESS) {
            if (areAllRTCsUploaded) {
                $(container).find('#upload-instructions').addClass('hidden');
                $(container).find('#upload-done, #study-share, #btn-execution-done').removeClass('hidden');
            } else {
                $(container).find('#rtc-uploads').removeClass('hidden');
            }
        } else {
            $(container).find('#upload-instructions').addClass('hidden');
            $(container).find('#upload-retry').removeClass('hidden');
        }
    });
}

function renderSelectionRatingGraphics(item, selectionRating) {
    if (selectionRating !== 'none') {
        $(item).removeClass('hidden');
        switch (selectionRating) {
            case 'body':
                $(item).find('#hand-selection-rating').addClass('hidden');
                $(item).find('#human-body-selection-rating').removeClass('hidden');
                renderBodyJoints($(item).find('#human-body'));
                break;
            case 'hands':
                $(item).find('#human-body-selection-rating').addClass('hidden');
                $(item).find('#hand-selection-rating').removeClass('hidden');
                renderHandJoints($(item).find('#human-hand'));
                break;
            case 'bodyHands':
                $(item).find('#human-body-selection-rating').removeClass('hidden');
                renderBodyJoints($(item).find('#human-body'));
                $(item).find('#hand-selection-rating').removeClass('hidden');
                renderHandJoints($(item).find('#human-hand'));
                break;
        }
    }
}

function getJointSelectionRatings(data, selectionRating, container) {
//    console.log(container);
    if (selectionRating !== 'none') {
        switch (selectionRating) {
            case 'body':
//                console.log($(container).find('#human-body-selection-rating'));
                data.selectedBodyJoints = getSelectedJoints($(container).find('#human-body-selection-rating'));
                break;
            case 'hands':
                data.selectedHandJoints = getSelectedJoints($(container).find('#hand-selection-rating'));
                break;
            case 'bodyHands':
                data.selectedBodyJoints = getSelectedJoints($(container).find('#human-body-selection-rating'));
                data.selectedHandJoints = getSelectedJoints($(container).find('#hand-selection-rating'));
                break;
        }
    }

//    console.log(data);
    return data;
}

function renderSceneItem(source, container, sceneId) {
    if (sceneId !== 'none' || sceneId !== null) {
        $(container).find('#btn-refresh-scene').removeClass('hidden');
        var scene = getSceneById(sceneId);
        var sceneItem = $(source).find('#' + scene.type).clone().removeAttr('id');
        container.find('#scene-container').empty().append(sceneItem);
        var currentPhaseData = getCurrentPhaseData();
        var helpData = getItemsForSceneId(currentPhaseData.help, scene.id);
        if (helpData && helpData.length > 0) {
            $(container).find('#btn-getting-help').removeClass('hidden');
        } else {
            $(container).find('#btn-getting-help').addClass('hidden');
        }

        var wozData = getItemsForSceneId(currentPhaseData.woz, scene.id);
        if (wozData && wozData.length > 0) {
            $(container).find('#btn-perform-gesture').removeClass('hidden');
//            $(container).find('#btn-done').addClass('hidden');
        } else {
            $(container).find('#btn-perform-gesture').addClass('hidden');
//            $(container).find('#btn-done').removeClass('hidden');
        }

        container.find('#scene-container').css({backgroundColor: "rgb(255,255,255)"});
        switch (scene.type) {
            case SCENE_WEB:
                sceneItem.attr('src', scene.data[0]);
                break;
            case SCENE_IMAGE:
                sceneItem[0].onload = function () {
                    var image = sceneItem[0];
                    var colorThief = new ColorThief();
                    var dominantColor = colorThief.getColor(image);
                    container.find('#scene-container').css("backgroundColor", "rgb(" + dominantColor[0] + "," + dominantColor[1] + "," + dominantColor[2] + ")");
                };
                sceneItem[0].src = scene.data;
                break;
            case SCENE_PIDOCO:
                sceneItem[0].src = scene.data;
                break;
            case SCENE_VIDEO_EMBED:
                sceneItem.find('.videoContainer').addClass(scene.options[0] === 'ratio_16_9' ? 'embed-responsive-16by9' : 'embed-responsive-4by3');
                sceneItem.find('.videoContainer').html(scene.data);
                var video = $(sceneItem).find('iframe');
                var src = video.attr('src');
                video.attr('src', src + "?autoplay=1");
                $(video).addClass('embed-responsive-item');
                container.find('#scene-container').css("backgroundColor", "rgb(0,0,0)");
                break;
        }

// scene positioning
        var containerOffsetTop = container.offset().top;
        var generalPanelHeight = 55;
//        if(!previewModeEnabled === false) {
//            generalPanelHeight = 0;
//        }
//        console.log(containerOffsetTop);
        sceneItem.css({marginTop: generalPanelHeight + 'px'});
        // calcuation of the new window height if resizing the window
        $(window).resize(function () {

            var height;
            if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
                height = $(window).height() - containerOffsetTop - generalPanelHeight;
            } else {
                height = $(window).height() - generalPanelHeight;
            }

            if (scene.type === SCENE_VIDEO_EMBED) {
                var width;
                if (scene.options[0] === 'ratio_16_9') {
                    width = height / 9 * 16;
                } else {
                    width = height / 3 * 4;
                }
                width = Math.min($(window).width(), width);
                sceneItem.width(width);
            }

            sceneItem.height(height);
        }).resize();
        return sceneItem;
    } else {
        $(container).find('#btn-refresh-scene').addClass('hidden');
    }
}

function onAnswerTimeExpired(container, data) {
    if (!previewModeEnabled) {
        var slideData = data.slideshow[currentSlideIndex];
        var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
        tempData.actions.push({action: ACTION_END_PERFORM_GESTURE, gestureId: slideData.gestureId, triggerId: slideData.triggerId, time: new Date().getTime()});
        setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);

        if (peerConnection) {
            peerConnection.sendMessage(MESSAGE_REACTIVATE_CONTROLS);
        }
    }
    $(container).find('.gestureContainer .headline, .triggerContainer .headline').text(translation.timesUp);
    TweenMax.to(container.find('.previewGesture, .trigger-title'), .1, {opacity: 0});
    TweenMax.to(container.find('#slideshowContainer, .progress'), .1, {delay: 2, opacity: 0, onComplete: onHideSlideComplete, onCompleteParams: [container]});
}

function onHideSlideComplete(container) {
    container.find('#slideshowContainer, .progress').addClass('hidden');
    container.find('#slideshowContainer, .progress').css({opacity: 1});
    container.find('.previewGesture, .trigger-title').css({opacity: 1});
    appendAlert($(container), ALERT_WAITING_FOR_SLIDESHOW);
}

function onUnmoderatedAnswerTimeExpired(source, container, data) {
    if (!previewModeEnabled) {
        var slideData = data.slideshow[currentSlideIndex];
        var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
        tempData.actions.push({action: ACTION_END_PERFORM_GESTURE, gestureId: slideData.gestureId, triggerId: slideData.triggerId, time: new Date().getTime()});
        setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
    }

    $(container).find('.gestureContainer .headline, .triggerContainer .headline').text(translation.timesUp);
    TweenMax.to(container.find('.previewGesture, .trigger-title'), .1, {opacity: 0});
    TweenMax.to(container.find('#slideshowContainer, .progress'), .1, {opacity: 0, onComplete: onHideUnmoderatedSlideComplete, onCompleteParams: [source, container, data]});
    loadHTMLintoModal('custom-modal', 'modal-check-gesture.php', 'modal-lg');
}

function onHideUnmoderatedSlideComplete(source, container, data) {
    container.find('#slideshowContainer, .progress').addClass('hidden');
    container.find('#slideshowContainer, .progress').css({opacity: 1});
    container.find('.previewGesture, .trigger-title').css({opacity: 1});
    container.find('.progress-bar').css({width: '100%', backgroundColor: "#5bb85c"});
}


function showScenarioInfos(target) {
    $(target).find('#btn-hide-scenario-info').removeClass('hidden');
    $(target).find('#info-content').removeClass('hidden');
}

function hideScenarioInfos(target) {
    $(target).find('#btn-show-scenario-info').removeClass('hidden');
    $(target).find('#info-content').addClass('hidden');
}

function getSelectionRating(data) {
    if ((getLocalItem(STUDY).surveyType === TYPE_SURVEY_MODERATED && currentStressTestCount < data.stressAmount) || currentStressTestCount < data.stressAmount - 1) {
        return data.singleStressGraphicsRating;
    } else if (currentStressTestCount >= data.stressAmount - 1) {
        if (data.singleStressGraphicsRating === data.sequenceStressGraphicsRating) {
            return data.singleStressGraphicsRating;
        } else if ((data.sequenceStressGraphicsRating === 'bodyHands' && (data.singleStressGraphicsRating === 'hands' || data.singleStressGraphicsRating === 'body')) ||
                (data.singleStressGraphicsRating === 'bodyHands' && (data.sequenceStressGraphicsRating === 'hands' || data.sequenceStressGraphicsRating === 'body')) ||
                (data.singleStressGraphicsRating === 'body' && data.sequenceStressGraphicsRating === 'hands') ||
                (data.singleStressGraphicsRating === 'hands' && data.sequenceStressGraphicsRating === 'body')) {
            return 'bodyHands';
        } else if (data.sequenceStressGraphicsRating === 'none' && data.singleStressGraphicsRating !== 'none') {
            return data.singleStressGraphicsRating;
        } else if (data.sequenceStressGraphicsRating !== 'none' && data.singleStressGraphicsRating === 'none') {
            return data.sequenceStressGraphicsRating;
        }
    }
}
