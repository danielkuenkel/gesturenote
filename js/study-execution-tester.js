/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var singleGUSGesture = null;
var screenSharingTester = null;
var Tester = {
    renderView: function renderView() {

        console.log('render view');
//        $('.alert-space').empty();
        var source = getSourceContainer(currentView);
        var item = null;
        var currentPhase = getCurrentPhase();
        var currentPhaseData = getCurrentPhaseData();
        // save start time
        if (previewModeEnabled === false) {
            setLocalItem(currentPhase.id + '.tempSaveData', {});
            getGMT(function (timestamp) {
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.startTime = timestamp;
//                delete tempData.endRecordingTime;
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            });
        }

        Tester.initializePeerConnection();
        if (currentPhaseData || (currentPhaseData && $.isArray(currentPhaseData) && currentPhaseData.length > 0)) {

//            Tester.resetScreenSharing();
//            if (!previewModeEnabled) {
//                loadScreenSharingScript();
//            }
            //        console.log('clone: ' + currentPhase.format + ', from: ' + source.attr('id'));
            var container = $(source).find('#' + currentPhase.format).clone(false);
            switch (currentPhase.format) {
                case LETTER_OF_ACCEPTANCE:
                    currentClass = new LetterOfAcceptance();
                    item = currentClass.renderTesterView();
//                    item = Tester.getLetterOfAcceptance(container, currentPhaseData);
                    break;
                case THANKS:
                    currentClass = new Thanks();
                    item = currentClass.renderTesterView();
//                    item = Tester.getThanks(container, currentPhaseData);
                    break;
                case QUESTIONNAIRE:
                    currentClass = new Questionnaire({isPreview: false, append: true});
                    item = currentClass.renderTesterView();
//                    item = Tester.getQuestionnaire(container, currentPhaseData, true);
                    break;
                case UEQ:
                    currentClass = new UserExperienceQuestionnaire();
                    item = currentClass.renderTesterView();
//                    item = Tester.getQuestionnaire(container, currentPhaseData, true);
                    $(item).find('.question-container').css({display: 'table', margin: '0 auto'});
                    break;
                case INTERVIEW:
                    currentClass = new Interview();
                    item = currentClass.renderTesterView();
//                    item = Tester.getInterview(container, currentPhaseData);
                    break;
                case IDENTIFICATION:
                    item = Tester.getIdentification(source, container, currentPhaseData);
                    break;
                case GUS_SINGLE_GESTURES:
                    currentClass = new GestureUsabilityScaleSingle();
                    item = currentClass.renderTesterView();
//                    item = Tester.getGUS(container, currentPhaseData);
                    break;
                case GUS_MULTIPLE_GESTURES:
                    currentClass = new GestureUsabilityScaleMultiple();
                    item = currentClass.renderTesterView();
//                    item = Tester.getQuestionnaire(container, getAssembledItems(currentPhaseData.gus), true);
                    break;
                case SUS:
                    currentClass = new SystemUsabilityScale();
                    item = currentClass.renderTesterView();
//                    item = Tester.getSUS(source, container, currentPhaseData);
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
                case EXPLORATION:
                    currentClass = new Exploration();
                    item = currentClass.renderTesterView();
//                    item = Tester.getExploration(source, container, currentPhaseData);
                    break;
            }

            if (item !== false || item !== null) {
                if (!syncPhaseStep) {
                    $('#viewTester #phase-content').empty().append(item);
                }
                Tester.initializeRTC(item);
            }

            if (currentPhase.format === THANKS) {
                $('.btn-cancel').addClass('disabled');
            } else {
                $('.btn-cancel').removeClass('disabled');
            }
        } else {
            Tester.renderNoDataView();
        }

        $('#viewTester #phase-content').css({y: 0, opacity: 1});
//        Tester.checkPositioning(currentPhase.format);
        TweenMax.from($('#viewTester #phase-content'), .2, {delay: 0, y: -40, opacity: 0, clearProps: 'all'});
        if ($(document).scrollTop() > 0) {
            $(document).scrollTop(0);
        }
    },
//    checkPositioning: function checkPositioning(format) {
//        var posY = '0px';
//        if (previewModeEnabled === false) {
//            switch (format) {
//                case SCENARIO:
//                    break;
//                default:
//                    posY = '90px';
//                    break;
//            }
////            $('#viewTester #phase-content').css({marginTop: posY});
//        } else {
//            switch (format) {
//                case SCENARIO:
//                    break;
//                default:
//                    posY = '40px';
//                    break;
//            }
//        }
//        console.log('check positioning', posY);
//        $('#viewTester #phase-content').css({marginTop: posY});
//    },
    renderNoDataView: function renderNoDataView() {
        var alert = $(getSourceContainer(currentView)).find('#no-phase-data').clone().removeAttr('id');
        $('#viewTester #phase-content').append(alert);
        appendAlert(alert, ALERT_NO_PHASE_DATA);
    },
//    getLetterOfAcceptance: function getLetterOfAcceptance(container, data) {
//        var source = getSourceContainer(VIEW_TESTER);
//        var content = $(source).find('#letterOfAcceptance-' + getLocalItem(STUDY).surveyType).clone().removeAttr('id');
//        $(container).append(content);
//        $(container).find('.letter-text').text(data);
//        $(container).find('#letter-agreed').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!previewModeEnabled) {
//                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                tempData.accepted = 'yes';
//                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
//                if (peerConnection) {
//                    peerConnection.sendMessage(MESSAGE_NEXT_STEP);
//                }
//            }
//
//            nextStep();
//        });
//        
//        $(container).find('#letter-decline').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!previewModeEnabled) {
//                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                tempData.accepted = 'no';
//                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
//            }
//
//            $('.btn-cancel').click();
//        });
//        return container;
//    },
//    getThanks: function getThanks(container, data) {
//
//        var content = $(getSourceContainer(VIEW_TESTER)).find('#thanks-' + getLocalItem(STUDY).surveyType).clone().removeAttr('id');
//        $(container).append(content);
//        TweenMax.to(container.find('.fa-upload'), .5, {yoyo: true, repeat: -1, opacity: .4});
//        $(container).find('#thanks-text').text(data);
//        var study = getLocalItem(STUDY);
//        var absoluteStaticStudyUrl = 'https://gesturenote.de/study-prepare.php?studyId=' + study.id + '&h=' + study.urlToken;
//        $(container).find('#static-study-url').text(absoluteStaticStudyUrl);
//        $(container).find('#btn-execution-done').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            gotoIndex();
//        });
//
//        $(container).find('#static-study-url').unbind('click').bind('click', function () {
//            $(container).find('#static-study-url').select();
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
//        // heart icon animation
//        var heartIcon = $(content).find('#heart-icon');
//        $(heartIcon).css({cursor: 'pointer'});
//        function animateHeartIcon() {
//            var heartOffset = $(heartIcon).offset();
//            console.log(heartOffset);
//            for (var i = 0; i < 4; i++) {
//                var heartCopy = $(heartIcon).clone().removeAttr('id');
//                $(heartCopy).insertAfter(heartIcon);
//                $(heartCopy).css({position: 'fixed', top: heartOffset.top, left: heartOffset.left, opacity: .4});
//                TweenMax.to(heartCopy, .5, {delay: i * .2, scaleX: 1.5, scaleY: 1.5, opacity: 0, onCompleteParams: [heartCopy], onComplete: function (element) {
//                        $(element).remove();
//                    }});
//            }
//        }
//
//        setTimeout(animateHeartIcon, 1000);
//        $(heartIcon).on('click', function (event) {
//            console.log('heart icon clicked');
//            event.preventDefault();
//            animateHeartIcon();
//        });
//
//        return container;
//    },
//    getQuestionnaire: function getQuestionnaire(container, data, appendContainer) {
//        if (appendContainer === true) {
//            var content = $(getSourceContainer(VIEW_TESTER)).find('#questionnaire-' + getLocalItem(STUDY).surveyType).clone().removeAttr('id');
//            $(container).append(content);
//        }
//
//        console.log('currentQuestionnaireAnswers', currentQuestionnaireAnswers);
//        container = renderQuestionnaire(container, data, currentQuestionnaireAnswers, true);
//        $(container).find('.headline').text(getCurrentPhase().title);
//
//        $(container).find('.question-container').unbind('questionnaireDone').bind('questionnaireDone', function (event) {
//            event.preventDefault();
//            console.log('questionnaire done triggered');
//            $(container).find('#btn-next-step').prev().addClass('hidden');
//            $(container).find('#btn-next-step').addClass('hidden');
//            questionnaireDone = true;
//            currentQuestionnaireAnswers = checkCurrentQuestionnaireAnswers(getQuestionnaireAnswers(container.find('.question-container').children(), data));
//            if (!previewModeEnabled && peerConnection) {
//                var currentPhase = getCurrentPhase();
//                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                tempData.answers = currentQuestionnaireAnswers.answers;
//                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                peerConnection.sendMessage(MESSAGE_QUESTIONNAIRE_DONE);
//            }
//        });
//
//        $(container).find('.question-container').unbind('nextQuestion').bind('nextQuestion', function (event) {
//            console.log('next question clicked');
//            event.preventDefault();
//            currentQuestionnaireAnswers = checkCurrentQuestionnaireAnswers(getQuestionnaireAnswers(container.find('.question-container').children(), data));
//            if (previewModeEnabled === false && peerConnection) {
//                var currentPhase = getCurrentPhase();
//                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                tempData.answers = currentQuestionnaireAnswers.answers;
//                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                peerConnection.sendMessage(MESSAGE_UPDATE_QUESTIONNAIRE, currentQuestionnaireAnswers);
//            }
//        });
//
//        if (questionnaireDone) {
//            $(container).find('#btn-next-step').prev().addClass('hidden');
//            $(container).find('#btn-next-step').addClass('hidden');
//            appendAlert(container, ALERT_WAITING_FOR_MODERATOR);
//        }
//
//        var currentPhase = getCurrentPhase();
//        if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_MODERATED && currentPhase.format !== PHYSICAL_STRESS_TEST && currentPhase.format !== SLIDESHOW_TRIGGER) {
//            $(container).unbind('change').bind('change', function (event) {
//                event.preventDefault();
//                currentQuestionnaireAnswers = checkCurrentQuestionnaireAnswers(getQuestionnaireAnswers(container.find('.question-container').children(), data));
//                if (previewModeEnabled === false && peerConnection) {
//                    var currentPhase = getCurrentPhase();
//                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                    tempData.answers = currentQuestionnaireAnswers.answers;
//                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                    peerConnection.sendMessage(MESSAGE_UPDATE_QUESTIONNAIRE, currentQuestionnaireAnswers);
//                }
//            });
//        }
//
//        return container;
//    },
//    getInterview: function getInterview(container, data) {
//        if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_MODERATED) {
//            var content = $(getSourceContainer(VIEW_TESTER)).find('#interview-' + getLocalItem(STUDY).surveyType).clone();
//            $(content).find('.headline').text(getCurrentPhase().title);
//            $(container).append(content);
//
//            for (var i = 0; i < data.length; i++) {
//                var questionItem = document.createElement('div');
//                $(questionItem).addClass('panel panel-shadow');
//                $(questionItem).css({marginBottom: '5px'});
//                var panelBody = document.createElement('div');
//                $(panelBody).addClass('panel-body text');
//                $(panelBody).text((i + 1) + '. ' + data[i].question);
//                $(questionItem).append(panelBody);
//                $(content).find('.question-container').append(questionItem);
//            }
//        }
//        return container;
//    },
//    getGUS: function getGUS(container, data) {
//        currentGUSData = data;
//        var content = $(getSourceContainer(VIEW_TESTER)).find('#gus-' + getLocalItem(STUDY).surveyType).clone().removeAttr('id');
//        $(container).append(content);
//        var gesture = getGestureById(data.gestureId);
//        if (gesture && isGestureAssembled(data.gestureId)) {
//            singleGUSGesture = {gestureId: data.gestureId, triggerId: data.triggerId, feedbackId: data.feedbackId};
//            container.find('#title').text(gesture.title);
//            renderGestureImages(container.find('.previewGesture'), gesture.images, gesture.previewImage, null);
//            var trigger = getTriggerById(data.triggerId);
//            var feedback = getFeedbackById(data.feedbackId);
//            $(container).find('#gesture .address').text(translation.gesture + ':');
//            $(container).find('#gesture .text').text(gesture.title);
//            $(container).find('#trigger .address').text(translation.trigger + ':');
//            $(container).find('#trigger .text').text(trigger.title);
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
//
//        } else {
//            $(container).find('#gesturePreview').addClass('hidden');
//        }
//
//        container = Tester.getQuestionnaire(container, getAssembledItems(data.gus), false);
//        return container;
//    },
//    getSUS: function getSUS(source, container, data) {
//        var content = $(getSourceContainer(VIEW_TESTER)).find('#sus-' + getLocalItem(STUDY).surveyType).clone();
//        $(container).append(content);
//        container = Tester.getQuestionnaire(container, data, false);
//        return container;
//    },
    getGestureTraining: function getGestureTraining(source, container, data) {
        // general data section
//        $(container).find('.headline').text(data.title);
//        $(container).find('.description').text(data.description);
        if (!data.training || data.training.length === 0) {
            return false;
        }

        // gestures section
        if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
            if (!previewModeEnabled) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                tempData.training = new Array();
                tempData.annotations = new Array();
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            }

            Tester.renderUnmoderatedTraining(source, container, data.training);
        } else {
            Tester.renderModeratedTraining(source, container, data.training);
            Tester.initScreenSharing(container.find('#scene-container'));
        }

        return container;
    },
    renderModeratedTraining: function renderModeratedTraining(source, container, data) {
        if (previewModeEnabled) {
//            $(container).find('#scene-container').css({top: '-108px'});
        }

        // handle states in preview mode
        if (gestureTrainingStartTriggered === true) {
//            clearAlerts(container);
//            $(container).find('#fixed-rtc-preview').removeClass('hidden');
            $(container).find('#scene-container').removeClass('hidden');
            if (previewModeEnabled && currentWOZScene) {
                // render scene manually
                renderSceneItem(source, container, currentWOZScene.id);
            }
        } else {
//            appendAlert($(container), ALERT_PLEASE_WAIT);
//            $(container).find('#fixed-rtc-preview').addClass('hidden');
            $(container).find('#scene-container').addClass('hidden');
        }

        // handle triggered help & woz
        if (previewModeEnabled && gestureTrainingStartTriggered === true) {
            checkFeedback();
            if (trainingTriggered && trainingShowGesture) {
                onTrainingTriggered();
            }
        } else {
            $(peerConnection).unbind(MESSAGE_TRIGGER_FEEDBACK).bind(MESSAGE_TRIGGER_FEEDBACK, function (event, payload) {
                triggeredFeedback = payload.triggeredFeedback;
                checkFeedback();
//                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                tempData.annotations.push({action: ACTION_SELECT_GESTURE, time: getGMT()});
//                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
            });
            $(peerConnection).unbind(MESSAGE_START_GESTURE_TRAINING).bind(MESSAGE_START_GESTURE_TRAINING, function (event, payload) {
//                console.log('start gesture training');
                gestureTrainingStartTriggered = true;
//                clearAlerts(container);
//                $(container).find('#fixed-rtc-preview').removeClass('hidden');
                $(container).find('#scene-container').removeClass('hidden');
//                var currentPhase = getCurrentPhase();
//                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                tempData.startTrainingTime = getGMT();
//                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            });
            $(peerConnection).unbind(MESSAGE_TRAINING_TRIGGERED).bind(MESSAGE_TRAINING_TRIGGERED, function (event, payload) {
                trainingTriggered = true;
                trainingShowGesture = true;
                currentGestureTrainingIndex = payload.currentGestureTrainingIndex;
                onTrainingTriggered();
//                var currentPhase = getCurrentPhase();
//                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                tempData.training.push({gestureId: payload.gestureId, gestureTrainingStart: getGMT()});
//                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            });
            $(peerConnection).unbind(MESSAGE_STOP_SCREEN_SHARING).bind(MESSAGE_STOP_SCREEN_SHARING, function (event, payload) {
                $(container).find('#scene-container').addClass('hidden');
            });
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
                        } else if (currentWOZScene) {
                            renderSceneItem(source, container, currentWOZScene.id);
                        }
                    });
                } else {
                    triggeredFeedback = null;
                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_FEEDBACK_HIDDEN);
                    } else {
                        renderSceneItem(source, container, currentWOZScene.id);
                    }
                }
            }
        }

        function onTrainingTriggered() {
            currentPreviewGesture = {gesture: getGestureById(data[currentGestureTrainingIndex].gestureId)};
            loadHTMLintoModal('custom-modal', 'externals/modal-gesture-info.php', 'modal-md');
            $('#custom-modal').unbind('hide.bs.modal').bind('hide.bs.modal', function () {
                if (!previewModeEnabled && peerConnection) {
                    peerConnection.sendMessage(MESSAGE_GESTURE_INFO_CLOSED, {gestureId: data[currentGestureTrainingIndex].gestureId});
                }
                gesturePreviewOpened = false;
                trainingShowGesture = false;
            });
        }
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
                getGMT(function (timestamp) {
                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    tempData.startTrainingTime = timestamp;
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                });
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
            if (!$(this).hasClass('disabled')) {

                if ($(this).attr('id') === 'start-single-training' && !previewModeEnabled) {
                    getGMT(function (timestamp) {
                        var currentPhase = getCurrentPhase();
                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_GESTURE_TRAINING, gestureId: gesture.id, time: timestamp});
                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                    });
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
            tempData.annotations = new Array();
            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
        }

        if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
            slideRestarted = true;
            Tester.renderUnmoderatedGestureSlideshow(source, container, data);
        } else {
            $(peerConnection).unbind(MESSAGE_START_GESTURE_SLIDESHOW).bind(MESSAGE_START_GESTURE_SLIDESHOW, function (event, payload) {
                slideRestarted = true;
                Tester.renderModeratedGestureSlideshowOverview(source, container, data);
            });
            $(peerConnection).unbind(MESSAGE_TRIGGER_GESTURE_SLIDE).bind(MESSAGE_TRIGGER_GESTURE_SLIDE, function (event, payload) {
                slideRestarted = false;
                slideTriggered = true;
                currentSlideIndex = parseInt(payload.currentSlideIndex);
                slidesRestartCount = payload.slidesRestartCount;
                getGMT(function (timestamp) {
                    var slideData = data.slideshow[currentSlideIndex];
                    var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_PERFORM_GESTURE, gestureId: slideData.gestureId, triggerId: slideData.triggerId, time: timestamp});
                    tempData.restarts = slidesRestartCount;
                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                    Tester.renderModeratedGestureSlideshow(source, container, data);
                });
            });
            $(peerConnection).unbind(MESSAGE_GESTURE_FIT_FOUND).bind(MESSAGE_GESTURE_FIT_FOUND, function (event, payload) {
                slideRestarted = false;
                slideTriggered = false;
                appendAlert($(container), ALERT_PLEASE_WAIT);
                getGMT(function (timestamp) {
                    var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                    var annotationData = payload.annotationData;
                    annotationData.id = tempData.annotations.length;
                    annotationData.time = timestamp;
                    tempData.annotations.push(annotationData);
                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                });
            });
            $(peerConnection).unbind(MESSAGE_NO_GESTURE_FIT_FOUND).bind(MESSAGE_NO_GESTURE_FIT_FOUND, function (event, payload) {
                slideRestarted = true;
                slideTriggered = false;
                currentSlideIndex = parseInt(payload.currentSlideIndex);
                slidesRestartCount = parseInt(payload.slidesRestartCount);
                getGMT(function (timestamp) {
                    var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                    var annotationData = payload.annotationData;
                    annotationData.id = tempData.annotations.length;
                    annotationData.time = timestamp;
                    tempData.annotations.push(annotationData);
                    tempData.restarts = slidesRestartCount;
                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                    Tester.renderModeratedGestureSlideshowOverview(source, container, data);
                });
            });
//            $(peerConnection).unbind(MESSAGE_GESTURE_PERFORMED).bind(MESSAGE_GESTURE_PERFORMED, function (event, payload) {
////                console.log(payload);
//                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                tempData.restarts = parseInt(payload.restartCount);
//                if (payload.fit) {
//                    getGMT(function (timestamp) {
//                        tempData.annotations.push({action: payload.action, gestureId: payload.gestureId, triggerId: payload.triggerId, selectedGestureId: payload.selectedGestureId, fit: payload.fit, time: timestamp});
//                    });
//
//                } else {
//                    getGMT(function (timestamp) {
//                        tempData.annotations.push({action: payload.action, gestureId: payload.gestureId, triggerId: payload.triggerId, selectedGestureId: null, time: timestamp});
//                    });
//                }
//
//                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
//            });

            if (slideshowStartTriggered) {
                if (slideRestarted) {
                    Tester.renderModeratedGestureSlideshowOverview(source, container, data);
                } else if (slideTriggered) {
                    Tester.renderModeratedGestureSlideshow(source, container, data);
                } else {
                    appendAlert($(container), ALERT_PLEASE_WAIT);
                }
            } else {
                appendAlert($(container), ALERT_PLEASE_WAIT);
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
            $(item).css({marginBottom: '20px'});
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
                getGMT(function (timestamp) {
                    var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_PERFORM_GESTURE, gestureId: slideData.gestureId, triggerId: slideData.triggerId, time: timestamp});
                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                });
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
            Tester.renderTriggerSlideshow(source, container, data);
        } else {
            $(container).find('#startSlideshow').remove();
            $(peerConnection).unbind(MESSAGE_START_TRIGGER_SLIDESHOW).bind(MESSAGE_START_TRIGGER_SLIDESHOW, function (event, payload) {
                slideshowStartTriggered = true;
                Tester.renderTriggerSlideshow(source, container, data);
            });
            if (slideshowStartTriggered) {
                Tester.renderTriggerSlideshow(source, container, data);
            } else {
                appendAlert($(container), ALERT_PLEASE_WAIT);
            }
        }

        return container;
    },
    renderTriggerSlideshow: function renderTriggerSlideshow(source, container, data) {
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
            $(container).find('#btn-next-slide').addClass('hidden');
            $(container).find('#btn-done-slide').removeClass('hidden');
            $(container).find('#btn-next-slide').text(translation.done);
        } else {
            $(container).find('#btn-next-slide').removeClass('hidden');
        }

        $(container).find('#btn-next-slide').unbind('click').bind('click', function (event) {
            event.preventDefault();
//            if (!previewModeEnabled) {
            saveTriggerSlideshowAnswer(container);
//            }

            if (currentSlideIndex < data.slideshow.length - 1) {
                currentSlideIndex++;
                Tester.renderTriggerSlideshow(source, container, data);
            }
        });
        if (testerDoneTriggered) {
            $(container).find('#slideshowContainer').addClass('hidden');
            appendAlert($(container), ALERT_PLEASE_WAIT);
        }

        $(container).find('#btn-done-slide').unbind('click').bind('click', function (event) {
            event.preventDefault();
//            if (!previewModeEnabled) {
            saveTriggerSlideshowAnswer(container);
//            }

            testerDoneTriggered = true;
            $(container).find('#slideshowContainer').addClass('hidden');
            appendAlert($(container), ALERT_PLEASE_WAIT);
            var currentPhase = getCurrentPhase();
            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
            if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
                nextStep();
            } else {
                if (!previewModeEnabled && peerConnection) {
                    peerConnection.sendMessage(MESSAGE_TRIGGER_SLIDESHOW_DONE, tempData);
                } else {
                    triggerSlideshowDone = true;
                }
            }
        });
        $(container).find('#startSlideshow').unbind('click').bind('click', function (event) {
            event.preventDefault();
            slideshowStartTriggered = true;
            Tester.renderTriggerSlideshow(source, container, data);
        });
        function saveTriggerSlideshowAnswer(container) {
            var selectedOption = $(container).find('.option-container .btn-option-checked').attr('id');
            selectedOption = selectedOption === undefined ? -1 : selectedOption;
            if (!previewModeEnabled && peerConnection) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                if (tempData.selectedOptions !== null && tempData.selectedOptions !== undefined) {
                    tempData.selectedOptions.push({correctTriggerId: slideData.triggerId, selectedId: selectedOption});
                } else {
                    var array = new Array();
                    array.push({correctTriggerId: slideData.triggerId, selectedId: selectedOption});
                    tempData.selectedOptions = array;
                }

                console.log(currentQuestionnaireAnswers, tempData.selectedOptions);
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                peerConnection.sendMessage(MESSAGE_UPDATE_QUESTIONNAIRE, tempData.selectedOptions);
            } else {
                console.log(currentQuestionnaireAnswers);
                if (currentQuestionnaireAnswers) {
                    currentQuestionnaireAnswers.push({correctTriggerId: slideData.triggerId, selectedId: selectedOption});
                } else {
                    currentQuestionnaireAnswers = [{correctTriggerId: slideData.triggerId, selectedId: selectedOption}];
                }
            }
        }
    },
    getIdentification: function getIdentification(source, container, data) {
        if (!data.identification || data.identification.length === 0) {
            return false;
        }

        // general data
        if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
            if (!previewModeEnabled) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                tempData.annotations = [];
                if (data.identificationFor === 'gestures') {
                    tempData.gestures = [];
                } else if (data.identificationFor === 'trigger') {
                    tempData.trigger = [];
                }
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            }

            Tester.renderUnmoderatedIdentification(source, container, data);
        } else {
            Tester.renderModeratedIdentification(source, container, data);
            Tester.initScreenSharing(container.find('#scene-container'));
        }

        return container;
    },
    renderModeratedIdentification: function renderModeratedIdentification(source, container, data) {
        container.empty().append($(source).find('#identificationModerated').clone().removeAttr('id'));
        if (previewModeEnabled) {
//            $(container).find('#scene-container').css({top: '-108px'});
        }

        var hasScences = data.identification[currentIdentificationIndex].transitionScenes && data.identification[currentIdentificationIndex].transitionScenes.length > 0;
        // handle states in preview mode
        if (identificationStartTriggered === true) {
            if (hasScences) {
//                clearAlerts(container);
//                $(container).find('#fixed-rtc-preview').removeClass('hidden');
                $(container).find('#scene-description p').text(data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].description);
                $(container).find('#scene-description').removeClass('hidden');
                if (data.identificationFor === 'gestures') {
                    if (identificationRecordingStartTriggered === true) {
//                        animateLiveStream($(container).find('#fixed-rtc-preview'), true);
                        $(container).find('#scene-description').addClass('hidden');
                        $(container).find('#scene-container').removeClass('hidden');
                    }

                    if (identificationRecordingStopTriggered === true) {
//                        appendAlert($(container), ALERT_PLEASE_WAIT);
//                        $(container).find('#fixed-rtc-preview').addClass('hidden');
                        $(container).find('#scene-description').addClass('hidden');
                        $(container).find('#scene-container').addClass('hidden');
                    }
                } else {

                }

                if (previewModeEnabled) {
                    // render scene manually
                    renderSceneItem(source, container, data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].sceneId);
                }
            } else {
                $(container).find('#scene-description').addClass('hidden');
            }
        } else {
//            appendAlert($(container), ALERT_PLEASE_WAIT);
//            $(container).find('#fixed-rtc-preview').addClass('hidden');
            $(container).find('#scene-description').addClass('hidden');
            $(container).find('#scene-container').addClass('hidden');
        }



        // generic identification live events
        var gestureRecorder = null;
        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_START_IDENTIFICATION).bind(MESSAGE_START_IDENTIFICATION, function (event, payload) {
                clearAlerts(container);
                identificationStartTriggered = true;
//                $(container).find('#fixed-rtc-preview').removeClass('hidden');

                if (hasScences) {
                    $(container).find('#scene-description').removeClass('hidden');
                    $(container).find('#scene-container').removeClass('hidden');
                }

                var gestureRecorderContent = $('#item-container-gesture-recorder').find('#gesture-recorder-without-introductions').clone().removeAttr('id');
                container.find('#gesture-recorder-container').empty().append(gestureRecorderContent);
                var options = {
                    recorderTarget: gestureRecorderContent,
                    startState: GR_STATE_INITIALIZE,
                    usedStates: [GR_STATE_INITIALIZE, GR_STATE_RECORD],
                    record: [
                        {type: 'webcam'}
                    ],
                    initRecorders: [
                        {type: 'webcam'}
                    ]
                };
                if (data.sensor !== 'none' && !sensorTypeBanned(data.sensor)) {
                    options.record.push({type: data.sensor});
                    options.initRecorders.push({type: data.sensor});
                }

                gestureRecorder = new GestureRecorder(options);
                $(gestureRecorder).unbind('allRecorderReady').bind('allRecorderReady', function (event) {
                    event.preventDefault();
                    peerConnection.sendMessage(MESSAGE_ALL_RECORDER_READY);
                });
                $(gestureRecorder).unbind('recorderDisconnected').bind('recorderDisconnected', function (event) {
                    event.preventDefault();
                    peerConnection.sendMessage(MESSAGE_RECORDER_LOST);
                });
            });
            $(peerConnection).unbind(MESSAGE_RENDER_SCENE).bind(MESSAGE_RENDER_SCENE, function (event, payload) {
                currentIdentificationIndex = payload.index;
                currentIdentificationScene = payload.sceneIndex;
                if (hasScences) {
                    $(container).find('#scene-description p').text(payload.description);
                    $(container).find('#scene-container').removeClass('hidden');
                }
            });
            $(peerConnection).unbind(MESSAGE_STOP_SCREEN_SHARING).bind(MESSAGE_STOP_SCREEN_SHARING, function (event, payload) {
                $(container).find('#scene-container').addClass('hidden');
            });
        }

        // handle live mode
        if (data.identificationFor === 'gestures') {
            if (!previewModeEnabled && peerConnection) {
//                peerConnection.initSeparateChunksRecording();

                $(peerConnection).unbind(MESSAGE_START_RECORDING_GESTURE).bind(MESSAGE_START_RECORDING_GESTURE, function (event, payload) {
//                    clearAlerts(container);

                    if (hasScences) {
                        $(container).find('#scene-description').addClass('hidden');
                        $(container).find('#scene-container').removeClass('hidden');
                    }

//                    animateLiveStream($(container).find('#fixed-rtc-preview'), true, VIEW_TESTER, function () {
                    gestureRecorder.record();
//                    });
//                    $(container).find('#fixed-rtc-preview').removeClass('hidden');
                });
                $(peerConnection).unbind(MESSAGE_STOP_RECORDING_GESTURE).bind(MESSAGE_STOP_RECORDING_GESTURE, function (event, payload) {
                    event.preventDefault();
                    $(gestureRecorder).unbind('recorderStopped').bind('recorderStopped', function (event) {
                        event.preventDefault();
                        var recordedData = gestureRecorder.recordedData();
//                        console.log('recorder stopped: ', recordedData);
                        for (var i = 0; i < recordedData.length; i++) {
                            if (recordedData[i].type === TYPE_RECORD_WEBCAM) {
                                peerConnection.transferFile(recordedData[i].data);
                                recordedData[i].data = null;
                                break;
                            }
                        }

                        peerConnection.sendMessage(MESSAGE_GESTURE_DATA, recordedData);
                    });
//                    console.log('stop record gesture');
                    gestureRecorder.stopRecord();
//                    animateLiveStream($(container).find('#fixed-rtc-preview'), false, VIEW_MODERATOR);
                    $(container).find('#scene-description').addClass('hidden');
                    $(container).find('#scene-container').addClass('hidden');
                });
            } else {
                if (hasScences) {
                    $(container).find('#scene-description p').text(data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].description);
                } else {
                    appendAlert($(container), ALERT_PLEASE_WAIT);
                }
            }
        } else {
            if (!previewModeEnabled && peerConnection) {
                $(peerConnection).unbind(MESSAGE_REQUEST_TRIGGER).bind(MESSAGE_REQUEST_TRIGGER, function (event, payload) {
                    $(container).find('#scene-description').addClass('hidden');
//                    console.log(payload);
                    currentIdentificationIndex = payload.currentIdentificationIndex;
                    $('#custom-modal').unbind('hidden.bs.modal').bind('hidden.bs.modal', function (event) {
                        event.preventDefault();
                        if (currentIdentificationIndex >= data.identification.length - 1) {
//                            appendAlert($(container), ALERT_PLEASE_WAIT);
//                            $(container).find('#fixed-rtc-preview').addClass('hidden');
                            $(container).find('#scene-description').addClass('hidden');
                            $(container).find('#scene-container').addClass('hidden');
                        } else {
                            console.log('there is more to identify');
                        }
                    });
                    loadHTMLintoModal('custom-modal', 'externals/modal-request-trigger.php', 'modal-md');
                });
            } else {
                $(container).find('#scene-description').addClass('hidden');
                if (identificationTriggerRequest) {
                    $('#custom-modal').unbind('hidden.bs.modal').bind('hidden.bs.modal', function (event) {
                        event.preventDefault();
                        if (currentIdentificationIndex >= data.identification.length - 1) {
//                            appendAlert($(container), ALERT_PLEASE_WAIT);
//                            $(container).find('#fixed-rtc-preview').addClass('hidden');
                            $(container).find('#scene-description').addClass('hidden');
                            $(container).find('#scene-container').addClass('hidden');
                        } else {
                            console.log('there is more to identify');
                        }
                    });
                    loadHTMLintoModal('custom-modal', 'externals/modal-request-trigger.php', 'modal-md');
                }
            }
        }
    },
    renderUnmoderatedIdentification: function renderUnmoderatedIdentification(source, container, data) {
        container.append($(source).find('#identificationUnmoderated').clone().removeAttr('id'));
        var item = $(source).find('#identificationItemUnmoderated').clone().removeAttr('id');
        $(container).find('#identificationContainer').empty().append(item);
        function renderIdentificationScene(source, container, sceneId) {
//            console.log('renderIdentificationScene', sceneId);
            $(container).find('#recorder-description').removeClass('hidden');
            $(container).css({position: 'fixed'});
            var sceneItem = renderSceneItem(source, container, sceneId);
            var description = $(source).find('#identification-description').clone();
            $(description).height($(sceneItem).height());
            $(description).find('#description-text').text(data.identification[currentIdentificationIndex].sceneDescription);
            $(container).append(description);
            $(window).on('resize', function (event) {
                event.preventDefault();
                $(description).height($(sceneItem).height());
            });
            $(container).find('#btn-start-gesture-recording').on('click', function (event) {
                event.preventDefault();
                $(item).find('#identification-content').removeClass('hidden');
                $(description).remove();
                TweenMax.to(container.find('#scenePanel'), .3, {opacity: 0, onComplete: function () {
                        container.find('#scene-container').empty();
                        container.find('#scenePanel').css({opacity: "1"});
                        $(container).css({position: 'relative'});
                    }});
            });
        }

        $(container).find('#btn-start-identification').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (data.identificationFor === 'gestures') {
                renderIdentificationScene(source, container, data.identification[currentIdentificationIndex].sceneId);
            } else {
                $(item).find('#identification-content').removeClass('hidden');
            }

            identificationStartTriggered = true;
            $(this).remove();
            $(container).find('#general').addClass('hidden');
        });
        if (identificationStartTriggered) {
            clearAlerts(container);
            $(container).find('#general').addClass('hidden');
            $(item).find('#btn-start-identification').remove();
            if (data.identificationFor === 'gestures') {
                renderIdentificationScene(source, container, data.identification[currentIdentificationIndex].sceneId);
            } else {
                $(item).find('#identification-content').removeClass('hidden');
            }
        } else {
            appendAlert(container, ALERT_PLEASE_WAIT);
        }

        var gesture = getGestureById(data.identification[currentIdentificationIndex].gestureId);
        var trigger = getTriggerById(data.identification[currentIdentificationIndex].triggerId);
        if (data.identificationFor === 'gestures') {
            $(item).find('#trigger-identification').remove();
            item.find('#trigger #text').text(trigger.title);
            var gestureRecorder = $('#item-container-gesture-recorder').find('#gesture-recorder-tester').clone().removeAttr('id');
            item.find('#gesture-recorder-container').empty().append(gestureRecorder);
            var options = {
                alertTarget: item.find('#gesture-recorder-container'),
                recorderTarget: gestureRecorder,
                saveGestures: !previewModeEnabled,
                ownerId: getLocalItem(STUDY).studyOwner,
                context: data.identification[currentIdentificationIndex].context,
                checkType: false,
                checkInteractionType: false
            };
            new GestureRecorder(options);
            renderBodyJoints(gestureRecorder.find('#human-body'));
            var recorderDescription = $('#item-container-gesture-recorder').find('#gesture-recorder-description').clone();
            container.find('#recorder-description').empty().append(recorderDescription);
            $(gestureRecorder).unbind(EVENT_GR_UPDATE_STATE).bind(EVENT_GR_UPDATE_STATE, function (event, type) {
                var descriptions = $('#item-container-gesture-recorder').find('#' + type).clone();
                recorderDescription.empty().append(descriptions);
                TweenMax.from(descriptions, .3, {y: -20, opacity: 0, clearProps: 'all'});
            });
            $(gestureRecorder).unbind(EVENT_GR_SAVE_SUCCESS).bind(EVENT_GR_SAVE_SUCCESS, function (event, gesture) {
                event.preventDefault();
                $(item).find('#next-controls').removeClass('hidden');
                if (!previewModeEnabled) {
                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    console.log(tempData, gesture);
//                    if (tempData.gestures !== null && tempData.gestures !== undefined) {
                    tempData.gestures.push({id: gesture.id, triggerId: trigger.id});
//                    } else {
//                        var array = new Array();
//                        array.push(parseInt({id: gesture.id, triggerId: trigger.id}));
//                        tempData.gestures = array;
//                    }
                    console.log('after update', tempData);
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//                    if (peerConnection) {
//                        peerConnection.sendMessage(MESSAGE_GESTURE_IDENTIFIED, {gesture: gesture, index: currentIdentificationIndex});
//                    }
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
                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_IDENTIFIED_GESTURE_DELETED, {gestureId: gestureId, index: currentIdentificationIndex});
                    }
                }
            });
        } else {
            $(item).find('#gesture-identification').remove();
            renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage, null);
        }

        if (data.identification.length === 1 || currentIdentificationIndex >= data.identification.length - 1) {
            $(item).find('#next-identification').remove();
            $(item).find('#done-identification').unbind('click').bind('click', function (event) {
                event.preventDefault();
                currentIdentificationIndex++;
                if (data.identificationFor === 'trigger' && !previewModeEnabled) {
                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    var triggerName = $(item).find('#trigger-identification #trigger-name').val();
                    var triggerJustification = $(item).find('#trigger-identification #trigger-justification').val();
//                    if (tempData && tempData.trigger) {
                    tempData.trigger.push({name: triggerName, justification: triggerJustification, gestureId: gesture.id});
//                    } else {
//                        var trigger = new Array();
//                        trigger.push({name: triggerName, justification: triggerJusticigation, gestureId: gesture.id});
//                        tempData.trigger = trigger;
//                    }

                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                }

                if (!previewModeEnabled && peerConnection) {
                    peerConnection.sendMessage(MESSAGE_IDENTIFICATION_DONE);
                }

                identificationDone = true;
                if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
                    nextStep();
                } else {
                    $(container).find('#identificationContainer').empty();
                    appendAlert(container, ALERT_PLEASE_WAIT);
                    $(container).find('hr').remove();
                    $(container).find('.headline').remove();
                    $(container).find('.description').remove();
                    $(container).find('#general').removeClass('hidden');
                }
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
                        tempData.trigger.push({name: triggerName, justification: triggerJustification, gestureId: gesture.id});
                    } else {
                        var trigger = new Array();
                        trigger.push({name: triggerName, justification: triggerJustification, gestureId: gesture.id});
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
            appendAlert($('#mainContent'), ALERT_NO_PHASE_DATA);
            return container;
        }

        // general data section
        $(container).find('.headline').text(data.title);
        $(container).find('.description').text(data.description);
        if (stressTestStartTriggered) {
            $(container).find('#general').remove();
        }

        if (!previewModeEnabled) {
            var currentPhase = getCurrentPhase();
            getGMT(function (timestamp) {
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.startStressTestTime = timestamp;
                tempData.annotations = new Array();
                tempData.answers = {singleAnswers: [], sequenceAnswers: []};
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            });
        }

        if (currentQuestionnaireAnswers === null) {
            currentQuestionnaireAnswers = {answers: []};
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
                        appendAlert($(container), ALERT_PLEASE_WAIT);
                        stressTestGestureTriggered = false;
                        stressTestQuestionsTriggered = false;
                        $(container).find('#stressTestContainer').empty();
                    });
                }

                appendAlert($(container), ALERT_PLEASE_WAIT);
            }
        }

        return container;
    },
    renderModeratedPhysicalStressTest: function renderModeratedPhysicalStressTest(source, container, data) {
        var item = $(source).find('#physicalStressTestModerated').clone().removeAttr('id');
        $(container).find('#stressTestContainer').removeClass('hidden').empty().append(item);
        var gesture = getGestureById(data.stressTestItems[currentStressTestIndex]);
        renderGestureImages($(container).find('.previewGesture'), gesture.images, gesture.previewImage, null);
        if (stressTestGestureTriggered) {
            if (!previewModeEnabled) {
                getGMT(function (timestamp) {
                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_PERFORM_GESTURE_STRESS_TEST, gestureId: gesture.id, time: timestamp});
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                });
            }
        }

        var questionContainer = $(container).find('#stress-test-questionnaire');
        if (stressTestQuestionsTriggered) {
            questionContainer.removeClass('hidden');
            if (!previewModeEnabled) {
                getGMT(function (timestamp) {
                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                    tempData.annotations.push({action: ACTION_END_PERFORM_GESTURE, gestureId: gesture.id, time: timestamp});
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_QUESTIONNAIRE, gestureId: gesture.id, time: timestamp});
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                });
            }

            // single questions section
//            if (currentStressTestCount <= parseInt(data.stressAmount)) {
            if (data.singleStressQuestions && data.singleStressQuestions.length > 0 || data.singleStressGraphicsRating !== 'none') {
//                    $(questionContainer).removeClass('hidden');
                $(item).find('#btn-questionnaire-done, #questionnaire-heading, #single-questions').removeClass('hidden');
                $(item).find('#general-repeats, #btn-gesture-done').addClass('hidden');
                $(item).find('#gesturePreview').removeClass('col-sm-12').addClass('col-sm-5');
                if (data.singleStressQuestions && data.singleStressQuestions.length > 0) {
                    Tester.getQuestionnaire(questionContainer.find('#single-questions'), data.singleStressQuestions, false);
                }
            }

            if (data.singleStressGraphicsRating && data.singleStressGraphicsRating !== 'none') {
                renderSelectionRatingGraphics($(item).find('#single-joint-selection'), data.singleStressGraphicsRating);
            }
//            }

            // sequence questions section, only if last currentStressTestCount were reached
            if (currentStressTestCount >= parseInt(data.stressAmount)) {
                console.log('sequenceStressGraphicsRating', data.sequenceStressGraphicsRating);
                if (data.sequenceStressQuestions && data.sequenceStressQuestions.length > 0 || data.sequenceStressGraphicsRating !== 'none') {
//                    $(questionContainer).removeClass('hidden');
                    $(item).find('#btn-questionnaire-done, #questionnaire-heading, #sequence-questions').removeClass('hidden');
                    $(item).find('#general-repeats, #btn-gesture-done').addClass('hidden');
                    $(item).find('#gesturePreview').removeClass('col-sm-12').addClass('col-sm-5');
                    if (data.sequenceStressQuestions && data.sequenceStressQuestions.length > 0) {
                        Tester.getQuestionnaire(questionContainer.find('#sequence-questions'), data.sequenceStressQuestions, false);
                    }
                }

                if (data.sequenceStressGraphicsRating && data.sequenceStressGraphicsRating !== 'none') {
                    renderSelectionRatingGraphics($(item).find('#sequence-joint-selection'), data.sequenceStressGraphicsRating);
                }
            }
        } else {
            questionContainer.addClass('hidden');
        }

        $(container).find('#btn-done-questionnaire').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(container).find('#stressTestContainer').addClass('hidden');
            Tester.savePhysicalStressTestAnswers(item, data, gesture, true);
            appendAlert($(container), ALERT_PLEASE_WAIT);
            questionContainer.addClass('hidden');
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_REACTIVATE_CONTROLS);
            }
        });
        if (!previewModeEnabled && peerConnection) {
            $(container).unbind('change').bind('change', function (event) {
                event.preventDefault();
                Tester.savePhysicalStressTestAnswers(item, data, gesture);
            });
        }
    },
    renderUnmoderatedPhysicalStressTest: function renderUnmoderatedPhysicalStressTest(source, container, data) {
        var item = $(source).find('#physicalStressTestUnmoderated').clone().removeAttr('id');
        $(container).find('#stressTestContainer').empty().append(item);
        var gesture = getGestureById(data.stressTestItems[currentStressTestIndex]);
        renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage, null);
        if (!previewModeEnabled) {
            getGMT(function (timestamp) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_PERFORM_GESTURE_STRESS_TEST, gestureId: gesture.id, time: timestamp});
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            });
        }

        $(item).find('#btn-gesture-done').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!previewModeEnabled) {
                getGMT(function (timestamp) {
                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//                    tempData.annotations.push({action: ACTION_END_PERFORM_GESTURE, gestureId: gesture.id, time: timestamp});
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_QUESTIONNAIRE, gestureId: gesture.id, time: timestamp});
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                });
            }

            // single questions section
            var questionContainer = $(container).find('#stress-test-questionnaire');
//            if (currentStressTestCount <= parseInt(data.stressAmount) - 1) {
            if (data.singleStressQuestions && data.singleStressQuestions.length > 0 || data.singleStressGraphicsRating !== 'none') {
                $(questionContainer).removeClass('hidden');
                $(item).find('#btn-questionnaire-done, #questionnaire-heading, #single-questions').removeClass('hidden');
                $(item).find('#general-repeats, #btn-gesture-done').addClass('hidden');
                $(item).find('#gesturePreview').removeClass('col-sm-12').addClass('col-sm-5');
                if (data.singleStressQuestions && data.singleStressQuestions.length > 0) {
                    Tester.getQuestionnaire(questionContainer.find('#single-questions'), data.singleStressQuestions);
                }
                renderSelectionRatingGraphics($(item).find('#single-joint-selection'), data.singleStressGraphicsRating);
            }
//            }

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
                    renderSelectionRatingGraphics($(item).find('#sequence-joint-selection'), data.sequenceStressGraphicsRating);
                }
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
            Tester.savePhysicalStressTestAnswers(item, data, gesture, true);
            currentStressTestCount++;
            $(item).find('#general-repeats').removeClass('hidden');
            $(item).find('#questionnaire-heading').addClass('hidden');
            $(this).addClass('hidden');
            $(item).find('#btn-gesture-done').removeClass('hidden');
            $(item).find('#gesturePreview').removeClass('col-sm-5').addClass('col-sm-12');
            $(item).find('#stress-test-questionnaire').addClass('hidden');
            if (!previewModeEnabled) {
                getGMT(function (timestamp) {
                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_PERFORM_GESTURE_STRESS_TEST, gestureId: gesture.id, time: timestamp});
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                });
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
            Tester.savePhysicalStressTestAnswers(item, data, gesture, true);
            nextStep();
        });
        $(item).find('#stress-test-questionnaire').unbind('change').bind('change', function (event) {
            console.log('stress-test-questionnaire changed');
            Tester.savePhysicalStressTestAnswers(item, data, gesture);
        });
    },
    savePhysicalStressTestAnswers: function savePhysicalStressTestAnswers(target, data, gesture, saveDoneState) {
        console.log(data, currentStressTestCount, data.stressAmount);
        var singleAnswer = {};
        if (data.singleStressQuestions && data.singleStressQuestions.length > 0) {
            var singleQuestionnaire = $(target).find('#single-questions .question-container').children();
            var singleQuestionAnswers = getQuestionnaireAnswers(singleQuestionnaire, data.singleStressQuestions);
            singleAnswer.gestureId = gesture.id;
            singleAnswer.answers = singleQuestionAnswers;
            getJointSelectionRatings(singleAnswer, data.singleStressGraphicsRating, $(target).find('#single-joint-selection'));
            console.log('singleQuestionAnswers', singleQuestionAnswers);
        } else if (data.singleStressGraphicsRating) {
            console.log('graphics rating');
            singleAnswer.gestureId = gesture.id;
            getJointSelectionRatings(singleAnswer, data.singleStressGraphicsRating, $(target).find('#single-joint-selection'));
        }

        var sequenceAnswer = {};
        if (currentStressTestCount >= parseInt(data.stressAmount) - 1) {
            if (data.sequenceStressQuestions && data.sequenceStressQuestions.length > 0) {
                var sequenceQuestionnaire = $(target).find('#sequence-questions .question-container').children();
                var sequenceQuestionAnswers = getQuestionnaireAnswers(sequenceQuestionnaire, data.sequenceStressQuestions);
                console.log('sequenceQuestionAnswers', sequenceQuestionAnswers);
                sequenceAnswer.gestureId = gesture.id;
                sequenceAnswer.answers = sequenceQuestionAnswers;
                getJointSelectionRatings(sequenceAnswer, data.sequenceStressGraphicsRating, $(target).find('#sequence-joint-selection'));
            } else if (data.sequenceStressGraphicsRating) {
                sequenceAnswer.gestureId = gesture.id;
                getJointSelectionRatings(sequenceAnswer, data.sequenceStressGraphicsRating, $(target).find('#sequence-joint-selection'));
            }
        }



//        var answerIndex = currentStressTestIndex == 0 ? currentStressTestIndex + currentStressTestCount - 1 : currentStressTestIndex + currentStressTestCount;
        currentQuestionnaireAnswers = {};
        currentQuestionnaireAnswers.answers = {singleAnswers: $.isEmptyObject(singleAnswer) ? null : [singleAnswer], sequenceAnswers: $.isEmptyObject(sequenceAnswer) ? null : [sequenceAnswer]};
//        console.log(currentStressTestIndex, currentStressTestCount, answerIndex);
        console.log('current Questionnaire Answers:', currentQuestionnaireAnswers);
        if (!previewModeEnabled) {

            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_UPDATE_QUESTIONNAIRE, currentQuestionnaireAnswers);
            }

            // save joints and questionnaire answers if in live mode
//            if (saveToLocalDB === true) {
            console.log(currentStressTestIndex, currentStressTestCount);
            var answerIndex = currentStressTestIndex === 0 ? currentStressTestCount : currentStressTestIndex + 1 + currentStressTestCount;
            var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//            if (currentStressTestIndex < data.stressTestItems.length - 1) {
//                getGMT(function (timestamp) {
//                    if (saveDoneState && saveDoneState === true) {
//                        tempData.annotations.push({action: ACTION_END_QUESTIONNAIRE, gestureId: gesture.id, time: timestamp});
//                    }
//                    tempData.answers.singleAnswers[answerIndex] = singleAnswer;
//                    tempData.answers.sequenceAnswers[currentStressTestIndex] = sequenceAnswer;
//                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
//                });
//            } else {
            tempData.answers.singleAnswers[answerIndex] = singleAnswer;
            tempData.answers.sequenceAnswers[currentStressTestIndex] = sequenceAnswer;
            setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
//            }
//            }
        }
    },
    getScenario: function getScenario(source, container, data) {
        if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
            if (!data.scene || !data.woz) {
                return false;
            }

            if (!previewModeEnabled) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.annotations = new Array();
//                tempData.transitions = new Array();
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            }

            Tester.renderUnmoderatedScenario(source, container, data);
        } else {
            Tester.renderModeratedScenario(source, container, data);
            Tester.initScreenSharing(container.find('#scene-container'));
            $(peerConnection).unbind(MESSAGE_START_SCENARIO).bind(MESSAGE_START_SCENARIO, function (event, payload) {
                event.preventDefault();
                scenarioStartTriggered = true;
                Tester.renderModeratedScenario(source, container, data);
            });
        }

        return container;
    },
    renderModeratedScenario: function renderModeratedScenario(source, container, data) {
        if (previewModeEnabled) {
//            $(container).find('#scene-container').css({top: '-108px'});
        }

        // handle states in preview mode
        if (scenarioDone === true) {
//            appendAlert($(container), ALERT_PLEASE_WAIT);
//            $(container).find('#fixed-rtc-preview').addClass('hidden');
            $(container).find('#scene-container').addClass('hidden');
        } else if (scenarioStartTriggered === true) {
//            clearAlerts(container);
//            $(container).find('#fixed-rtc-preview').removeClass('hidden');
            $(container).find('#scene-container').removeClass('hidden');
            if (previewModeEnabled) {
                // render scene manually
                renderSceneItem(source, container, currentWOZScene.id);
            }
        } else {
//            appendAlert($(container), ALERT_PLEASE_WAIT);
//            $(container).find('#fixed-rtc-preview').addClass('hidden');
            $(container).find('#scene-container').addClass('hidden');
        }

        // handle triggered help & woz
        if (previewModeEnabled && scenarioStartTriggered === true) {
            checkHelp();
            checkFeedback();
        } else {
            $(peerConnection).unbind(MESSAGE_TRIGGER_HELP).bind(MESSAGE_TRIGGER_HELP, function (event, payload) {
                triggeredHelp = payload.help;
                checkHelp();
            });
//            $(peerConnection).unbind(MESSAGE_TRIGGER_WOZ).bind(MESSAGE_TRIGGER_WOZ, function (event, payload) {
//                console.log(payload);
//                triggeredWoz = payload.triggeredWOZ;

//                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                tempData.annotations.push({action: ACTION_END_PERFORM_GESTURE, time: getGMT()});
//                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
//            });

            $(peerConnection).unbind(MESSAGE_TRIGGER_FEEDBACK).bind(MESSAGE_TRIGGER_FEEDBACK, function (event, payload) {
                console.log(payload);
                triggeredFeedback = payload.triggeredFeedback;
                checkFeedback();
//                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
//                tempData.annotations.push({action: ACTION_END_PERFORM_GESTURE, time: getGMT()});
//                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
            });
            $(peerConnection).unbind(MESSAGE_STOP_SCREEN_SHARING).bind(MESSAGE_STOP_SCREEN_SHARING, function (event, payload) {
                $(container).find('#scene-container').addClass('hidden');
            });
        }

        function checkHelp() {
            if (triggeredHelp) {
                loadHTMLintoModal('custom-modal', 'externals/modal-help.php', 'modal-md');
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
                        } else {
                            renderSceneItem(source, container, currentWOZScene.id);
                        }
                    });
                } else {
                    triggeredFeedback = null;
                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_FEEDBACK_HIDDEN);
                    } else {
                        renderSceneItem(source, container, currentWOZScene.id);
                    }
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
                    getGMT(function (timestamp) {
                        var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_SHOW_INFO, time: timestamp});
                        setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                    });
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
                    getGMT(function (timestamp) {
                        var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_HIDE_INFO, time: timestamp});
                        setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                    });
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
                getGMT(function (timestamp) {
                    var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_TASK, time: timestamp});
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, scene: data.scene, time: timestamp});
                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                });
            }

            container.find('#start-controls').addClass('hidden');
            container.find('#normal-controls').removeClass('hidden');
            sceneItem = renderSceneItem(source, container, data.scene);
            sceneItem.removeClass('hidden');
            container.find('#btn-hide-scenario-info').click();
            scenarioStartTriggered = true;
            currentWOZScene = getSceneById(data.scene);
//            container.find('#fixed-rtc-preview').removeClass('hidden');
        });

        $(container).find('#btn-refresh-scene').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!previewModeEnabled) {
                getGMT(function (timestamp) {
                    var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_REFRESH_SCENE, scene: data.scene, time: timestamp});
                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                });
            }

            renderUnmoderatedScenario(source, container, data);
        });

        $(panelContent).find('#btn-perform-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(this).addClass('hidden');
            if (!previewModeEnabled) {
                getGMT(function (timestamp) {
                    var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_PERFORM_GESTURE, time: timestamp});
                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                });
            }

            $(panelContent).find('#btn-stop-perform-gesture').removeClass('hidden');
        });

        $(panelContent).find('#btn-stop-perform-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(this).addClass('hidden');
            if (!previewModeEnabled) {
                getGMT(function (timestamp) {
                    var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_END_PERFORM_GESTURE, time: timestamp});
                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                });
            }

            $(panelContent).find('#btn-perform-gesture').removeClass('hidden');
            loadHTMLintoModal('custom-modal', 'externals/modal-select-transition.php', 'modal-lg');
        });

        $(panelContent).find('#btn-getting-help').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!previewModeEnabled) {
                getGMT(function (timestamp) {
                    var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_REQUEST_HELP, time: timestamp});
                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                });
            }

            loadHTMLintoModal('custom-modal', 'externals/modal-help.php', 'modal-md');
        });

        $(panelContent).find('#btn-done').unbind('click').bind('click', function (event) {
            event.preventDefault();
            nextStep();
        });
    },
//    getExploration: function getExploration(source, container, data) {
//        if (!data.exploration || (data.exploration && data.exploration.length === 0)) {
//            return false;
//        }
//
//        container.empty().append($(source).find('#exploration-moderated').clone().removeAttr('id'));
//
//        renderCurrentPhaseState();
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
//                case 'explorationDone':
//                    renderStateExplorationDone();
//                    break;
//            }
//        }
//
//        function renderStateInitialize() {
//            console.log('render state: ', currentPhaseState, scenesUsedForExploration(data.exploration));
//            if (scenesUsedForExploration(data.exploration) === true) {
//                Tester.initScreenSharing(container.find('#scene-container'));
//            } else {
//
//            }
//
//            appendAlert($(container), ALERT_PLEASE_WAIT);
//        }
//
//        function renderStatePrototypeOpened() {
//            console.log('render state: ', currentPhaseState);
//            appendAlert($(container), ALERT_PLEASE_WAIT);
//        }
//
//        function renderStateExplorationStarted() {
//            console.log('render state: ', currentPhaseState);
//            renderCurrentScene();
//            clearAlerts($(container));
//
//            // check if there are previews triggered in study preview
//            if (currentPreviewGesture) {
//                $('#custom-modal').unbind('hide.bs.modal').bind('hide.bs.modal', function () {
//                    $('#custom-modal').unbind('hide.bs.modal');
//                    console.log('hide.bs.modal gesture info');
//                    if (!previewModeEnabled && peerConnection) {
//                        peerConnection.sendMessage(MESSAGE_GESTURE_INFO_CLOSED, {gestureId: currentPreviewGesture.gesture.id});
//                    }
//                    currentPreviewGesture = null;
//                });
//                loadHTMLintoModal('custom-modal', 'externals/modal-gesture-info.php', 'modal-md');
//            }
//
//            if (data.explorationType === 'trigger' && currentPreviewTrigger) {
//                $('#custom-modal').unbind('hide.bs.modal').bind('hide.bs.modal', function (event) {
//                    $('#custom-modal').unbind('hide.bs.modal');
//                    currentPreviewTrigger = null;
//                    if (!previewModeEnabled && peerConnection) {
//                        peerConnection.sendMessage(MESSAGE_TRIGGER_INFO_CLOSED, {triggerId: currentPreviewTrigger.id});
//                    }
//                });
//                loadHTMLintoModal('custom-modal', 'externals/modal-trigger-info.php', 'modal-sm');
//            }
//        }
//
//        function renderStateAskPreferredGestures() {
//            console.log('render state: ', currentPhaseState);
//
//            $('#custom-modal').unbind('hidden.bs.modal').bind('hidden.bs.modal', function () {
//                $('#custom-modal').unbind('hidden.bs.modal');
//                console.log('hide.bs.modal ask prefered gestures');
//                currentPhaseState = 'askResponsePreferredGestures';
//                renderCurrentPhaseState();
//            });
//            loadHTMLintoModal('custom-modal', 'externals/modal-preferred-gestures.php', 'modal-md');
//        }
//
//        function renderStateAskResponsePreferredGestures() {
//            console.log('render state: ', currentPhaseState);
//            $(container).find('#scene-description').addClass('hidden');
//            $(container).find('#scene-container').addClass('hidden');
//            appendAlert($(container), ALERT_PLEASE_WAIT);
//        }
//
//        function renderStateAskPreferredTrigger() {
//            console.log('render state: ', currentPhaseState);
//
//            $('#custom-modal').unbind('hidden.bs.modal').bind('hidden.bs.modal', function () {
//                $('#custom-modal').unbind('hidden.bs.modal');
//                currentPhaseState = 'askResponsePreferredTrigger';
//                renderCurrentPhaseState();
//            });
//            loadHTMLintoModal('custom-modal', 'externals/modal-preferred-gestures.php', 'modal-md');
//        }
//
//        function renderStateAskResponsePreferredTrigger() {
//            console.log('render state: ', currentPhaseState);
//            $(container).find('#scene-description').addClass('hidden');
//            $(container).find('#scene-container').addClass('hidden');
//            appendAlert($(container), ALERT_PLEASE_WAIT);
//        }
//
//        function renderStateScreenSharingStopped() {
//            console.log('render state: ', currentPhaseState);
//            appendAlert($(container), ALERT_PLEASE_WAIT);
//        }
//
//        function renderStateExplorationDone() {
//            console.log('render state: ', currentPhaseState);
//            appendAlert($(container), ALERT_PLEASE_WAIT);
//        }
//
//        function renderCurrentScene() {
//            if (scenesUsedForExploration(data.exploration) === true) {
//                if (data.exploration[currentExplorationIndex].transitionScenes && data.exploration[currentExplorationIndex].transitionScenes[currentExplorationScene] && data.exploration[currentExplorationIndex].transitionScenes[currentExplorationScene].description !== '') {
//                    $(container).find('#scene-description p').text(data.exploration[currentExplorationIndex].transitionScenes[currentExplorationScene].description);
//                    $(container).find('#scene-description').removeClass('hidden');
//                } else {
//                    $(container).find('#scene-description').addClass('hidden');
//                }
//
//                if (previewModeEnabled) {
//                    // render scene manually
//                    console.log('render scene manually:', data.exploration[currentExplorationIndex]);
//                    if (data.exploration[currentExplorationIndex] && data.exploration[currentExplorationIndex].transitionScenes && data.exploration[currentExplorationIndex].transitionScenes.length > 0) {
//                        renderSceneItem(source, container, data.exploration[currentExplorationIndex].transitionScenes[currentExplorationScene].sceneId);
//                    } else {
//                        renderSceneItem(source, container, null);
//                    }
//                }
//
//                $(container).find('#scene-container').removeClass('hidden');
//            } else {
//                $(container).find('#scene-description').addClass('hidden');
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
//        // exploration live events
//        if (!previewModeEnabled && peerConnection) {
//            $(peerConnection).unbind(MESSAGE_START_EXPLORATION).bind(MESSAGE_START_EXPLORATION, function (event, payload) {
//                currentPhaseState = 'explorationStarted';
//                renderCurrentStatePhase();
//            });
//
//            $(peerConnection).unbind(MESSAGE_RENDER_SCENE).bind(MESSAGE_RENDER_SCENE, function (event, payload) {
//                currentExplorationIndex = payload.index;
//                currentExplorationScene = payload.sceneIndex;
//
//                if (payload.description) {
//                    $(container).find('#scene-description p').text(payload.description);
//                    $(container).find('#scene-container').removeClass('hidden');
//                } else {
//                    $(container).find('#scene-container').addClass('hidden');
//                }
//            });
//
//            $(peerConnection).unbind(MESSAGE_OPEN_GESTURE_INFO).bind(MESSAGE_OPEN_GESTURE_INFO, function (event, payload) {
//                console.log('open gesture info', payload);
//
//                currentPreviewGesture = {gesture: getGestureById(payload.id)};
//                $('#custom-modal').unbind('hide.bs.modal').bind('hide.bs.modal', function () {
//                    currentPreviewGesture = null;
//                    $('#custom-modal').unbind('hide.bs.modal');
//                    if (!previewModeEnabled && peerConnection) {
//                        peerConnection.sendMessage(MESSAGE_GESTURE_INFO_CLOSED, {gestureId: currentPreviewGesture.gesture.id});
//                    }
//                });
//                loadHTMLintoModal('custom-modal', 'externals/modal-gesture-info.php', 'modal-md');
//            });
//
//            $(peerConnection).unbind(MESSAGE_OPEN_TRIGGER_INFO).bind(MESSAGE_OPEN_TRIGGER_INFO, function (event, payload) {
//                console.log('open trigger info', payload);
//
//                currentPreviewTrigger = getTriggerById(payload.id);
//                $('#custom-modal').unbind('hide.bs.modal').bind('hide.bs.modal', function () {
//                    currentPreviewTrigger = null;
//                    $('#custom-modal').unbind('hide.bs.modal');
//                    if (!previewModeEnabled && peerConnection) {
//                        peerConnection.sendMessage(MESSAGE_TRIGGER_INFO_CLOSED, {triggerId: currentPreviewTrigger.id});
//                    }
//                });
//                loadHTMLintoModal('custom-modal', 'externals/modal-trigger-info.php', 'modal-sm');
//            });
//
//            $(peerConnection).unbind(MESSAGE_STOP_SCREEN_SHARING).bind(MESSAGE_STOP_SCREEN_SHARING, function (event, payload) {
//                currentPhaseState = 'screenSharingStopped';
//                renderCurrentPhaseState();
//            });
//
//            if (data.explorationType === 'gestures') {
//                $(peerConnection).unbind(MESSAGE_REQUEST_PREFERRED_GESTURES).bind(MESSAGE_REQUEST_PREFERRED_GESTURES, function (event, payload) {
////                    $(container).find('#fixed-rtc-preview').addClass('hidden');
//                    $('#custom-modal').unbind('hidden.bs.modal').bind('hidden.bs.modal', function (event) {
//                        event.preventDefault();
//                        $('#custom-modal').unbind('hide.bs.modal');
//                        currentPhaseState = 'askResponsePreferredGestures';
//                        renderCurrentPhaseState();
////                        appendAlert($(container), ALERT_PLEASE_WAIT);
////                        $(container).find('#scene-description').addClass('hidden');
////                        $(container).find('#scene-container').addClass('hidden');
//                    });
//                    currentExplorationIndex = payload.currentExplorationIndex;
//                    loadHTMLintoModal('custom-modal', 'externals/modal-preferred-gestures.php', 'modal-md');
//                });
//            } else {
//                $(peerConnection).unbind(MESSAGE_REQUEST_PREFERRED_TRIGGER).bind(MESSAGE_REQUEST_PREFERRED_TRIGGER, function (event, payload) {
////                    $(container).find('#fixed-rtc-preview').addClass('hidden');
//                    $('#custom-modal').unbind('hidden.bs.modal').bind('hidden.bs.modal', function (event) {
//                        event.preventDefault();
//                        $('#custom-modal').unbind('hide.bs.modal');
//                        currentPhaseState = 'askResponsePreferredTrigger';
//                        renderCurrentPhaseState();
////                        appendAlert($(container), ALERT_PLEASE_WAIT);
////                        $(container).find('#scene-description').addClass('hidden');
////                        $(container).find('#scene-container').addClass('hidden');
//                    });
//                    currentExplorationIndex = payload.currentExplorationIndex;
//                    loadHTMLintoModal('custom-modal', 'externals/modal-preferred-trigger.php', 'modal-md');
//                });
//            }
//        }
//
//        return container;
//    },
    initializeRTC: function initializeRTC(container) {
        // check preview or live mode, and check if webRTC is needed
        initPopover();
        if (isWebRTCNeededInFuture()) {
            if (previewModeEnabled === true) {
                Tester.appendRTCPreviewStream(container);
            } else {
                Tester.appendRTCLiveStream();
            }
        } else {
//            resetLiveStream();
        }

//        updateRTCHeight($('#viewTester #column-left').width(), true);
    },
    appendRTCPreviewStream: function appendRTCPreviewStream(container) {
        var currentPhase = getCurrentPhase();
        var source = getSourceContainer(currentView);
        var target = $('#viewTester').find('#column-left');
        switch (currentPhase.format) {
            case SCENARIO:
            case IDENTIFICATION:
            case EXPLORATION:
            case GESTURE_TRAINING:
                target = $(container).find('#fixed-rtc-preview');
                $(target).find('#video-caller').css({width: '100%', height: 'auto'});
                break;
            default:
                pinRTC();
                break;
        }
//        console.log('appendRTCPreviewStream', target);
        $(target).empty().append($(source).find('#tester-web-rtc-placeholder').clone().removeAttr('id'));
//        var source = getSourceContainer(currentView);
//        var target = $('#viewTester').find('#fixedRTC');
//        $(target).empty().prepend($(source).find('#tester-web-rtc-placeholder').clone().attr('id', 'web-rtc-placeholder'));
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

                    $('#custom-modal').find('.modal-content').empty();
                    $('#custom-modal').modal('hide');
                });

                $(peerConnection).unbind(MESSAGE_SYNC_PHASE_STEP).bind(MESSAGE_SYNC_PHASE_STEP, function (event, payload) {
                    console.log('on sync phase step', payload.index);
                    syncPhaseStep = false;
                    currentPhaseStepIndex = payload.index;
                    renderPhaseStep();
                    updateProgress();
                });

                $(peerConnection).unbind('videoAdded').bind('videoAdded', function (event, video) {
                    event.preventDefault();
                    if (syncPhaseStep) {
                        peerConnection.sendMessage(MESSAGE_REQUEST_SYNC, {index: currentPhaseStepIndex});

                    }

                    resetRTC();
//                    console.log('video added');
//                    if (peerConnection) {
                    peerConnection.takeSnapshot(true);
//                    }
                });
                $(peerConnection).unbind(CONNECTION_STATE_CONNECTED).bind(CONNECTION_STATE_CONNECTED, function () {
                    console.log('connected');
                    clearAlerts($('#viewTester'));
                    if (getCurrentPhase().format !== THANKS) {
                        $('#viewTester').find('#phase-content').removeClass('hidden');
                        $('#viewTester').find('#pinnedRTC').css({opacity: 1});
                    }
                    resetRTC();

//                    TweenMax.to($('#viewTester #phase-content'), 0, {y: -40, opacity: 0});
//                    TweenMax.to($('#viewTester #phase-content'), .2, {delay: .2, y: 0, opacity: 1});
//                    if ($(document).scrollTop() > 0) {
//                        $(document).scrollTop(0);
//                    }
                });

                $(peerConnection).unbind(CONNECTION_STATE_DISCONNECTED).bind(CONNECTION_STATE_DISCONNECTED, function () {
                    console.log('disconnected');
                    clearAlerts($('#viewTester'));
                    if (getCurrentPhase().format !== THANKS) {
                        appendAlert($('#viewTester'), ALERT_PLEASE_WAIT);
                        $('#viewTester').find('#phase-content').addClass('hidden');
                        $('#viewTester').find('#pinnedRTC').css({opacity: 0});
                    }
                });

                $(peerConnection).unbind('videoRemoved').bind('videoRemoved', function () {
                    console.log('videoRemoved');
                    clearAlerts($('#viewTester'));
                    if (getCurrentPhase().format !== THANKS) {
                        appendAlert($('#viewTester'), ALERT_PLEASE_WAIT);
                        $('#viewTester').find('#phase-content').addClass('hidden');
                        $('#viewTester').find('#pinnedRTC').css({opacity: 0});
                    }
                });
            } else {
                clearAlerts($('#viewTester'));
                $('#viewTester').find('#phase-content').removeClass('hidden');
                $('#viewTester').find('#pinnedRTC').css({opacity: 1});
                updateRTCHeight($('#viewTester #column-left').width());
            }
        }
    },
    appendRTCLiveStream: function appendRTCLiveStream() {
        var currentPhase = getCurrentPhase();
        var target = $('#viewTester').find('#pinnedRTC');
        var updateRTCHeightBool = false;
        switch (currentPhase.format) {
            case SCENARIO:
            case IDENTIFICATION:
            case EXPLORATION:
            case GESTURE_TRAINING:
            case INTERVIEW:
                target = $('#viewTester').find('#fixed-rtc-preview');
//                console.log('set fixed width for fixed rtc', target,$(target).find('#video-caller'));
                break;
            default:
                pinRTC();
                updateRTCHeightBool = true;
                updateRTCHeight($('#viewTester #column-left').width());
                break;
        }

        console.log('append rtc live stream', target);
        var options = getPhaseStepOptions(currentPhase.format);
        var query = getQueryParams(document.location.search);
        var mainElement = $('#video-caller');
        var callerOptions = {
            target: target,
            callerElement: mainElement,
            localVideoElement: 'local-stream',
            remoteVideoElement: 'remote-stream',
            streamControls: $(mainElement).find('#stream-controls'),
            localMuteElement: $(mainElement).find('#btn-stream-local-mute'),
            pauseStreamElement: $(mainElement).find('#btn-pause-stream'),
            remoteMuteElement: $(mainElement).find('#btn-stream-remote-mute'),
            indicator: $(mainElement).find('#stream-control-indicator'),
            enableWebcamStream: true,
            enableDataChannels: options.enableDataChannels && options.enableDataChannels === 'yes' || false,
            autoRequestMedia: true,
            roomId: query.roomId,
            localStream: {audio: options.tester.audio, video: options.tester.video, visualize: options.tester.visualizeStream, record: options.tester.recordStream},
            remoteStream: {audio: options.moderator.audio, video: options.moderator.video}
        };
        if (callerOptions.localStream.video === 'yes' || callerOptions.remoteStream.video === 'yes') {
            $(callerOptions.target).prepend(callerOptions.callerElement);
            if (updateRTCHeightBool) {
                updateRTCHeight($('#viewTester #column-left').width());
            } else {
                $(target).find('#video-caller').css({width: '100%', height: 'auto'});
            }
        } else {
            console.log('dont add video-caller');
        }

        peerConnection.update(callerOptions);
//        var source = getSourceContainer(currentView);
//        $(target).empty().append(callerOptions.callerElement);
        Tester.keepStreamsPlaying(callerOptions.callerElement);
    },
    keepStreamsPlaying: function keepStreamsPlaying(element) {
        if (peerConnection.status !== STATUS_UNINITIALIZED) {
            var videos = $(element).find('video');
            for (var i = 0; i < videos.length; i++) {
//                if (videos[i].paused) {
                videos[i].play();
//                }
            }
        }
    },
    initScreenSharing: function initScreenSharing(container) {
        $(peerConnection).unbind(MESSAGE_SHARED_SCREEN_ADDED).bind(MESSAGE_SHARED_SCREEN_ADDED, function (event, video) {
            console.log('on add screen', video);
//            var videoClone = $(video).clone();
//            $('#video-caller').find('#remote-stream').append(videoClone);

            $(container).empty().append(video);
            var newHeight = $(window).height();
            $(container).css({height: newHeight + "px"});
            $(video).css({height: '100%', width: '100%', objectFit: 'contain'});
            $(video).removeAttr('controls');
            $(video).removeAttr('id');
            $(window).on('resize', function () {
                var newHeight = $(window).height();
                $(container).css({height: newHeight + "px"});
            });
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_SCREEN_SHARING_ESTABLISHED);
            }
            Tester.keepStreamsPlaying($('#video-caller'));
            Tester.keepStreamsPlaying(container);
        });
    }
};
function checkRTCUploadStatus(container) {
    if (isUploadRecordingNeeded() && uploadQueue && !uploadQueue.allFilesUploaded() && uploadQueue.uploadPending() === true) {
        console.log('sumbmit final data with upload queue, some files where not uploaded yet!');
        submitFinalData(container, false);
//        $(uploadQueue).unbind(EVENT_ALL_FILES_UPLOADED).bind(EVENT_ALL_FILES_UPLOADED, function () {
//            console.log('Tester: all videos uploaded -> submit final data');
//            $(uploadQueue).unbind(EVENT_ALL_FILES_UPLOADED);
//            submitFinalData(container, true);
//        });
    } else {
        console.log('sumbmit final data without upload queue, or all files where uploaded.');
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

function getJointSelectionRatings(answers, selectionRating, container) {
    if (selectionRating !== 'none') {
        var selectedBodyJoints = null;
        var selectedHandJoints = null;
        switch (selectionRating) {
            case 'body':
                selectedBodyJoints = getSelectedJoints($(container).find('#human-body-selection-rating'));
                answers.selectedBodyJoints = selectedBodyJoints;
                break;
            case 'hands':
                selectedHandJoints = getSelectedJoints($(container).find('#hand-selection-rating'));
                answers.selectedHandJoints = selectedHandJoints;
                break;
            case 'bodyHands':
                selectedBodyJoints = getSelectedJoints($(container).find('#human-body-selection-rating'));
                selectedHandJoints = getSelectedJoints($(container).find('#hand-selection-rating'));
                answers.selectedBodyJoints = selectedBodyJoints;
                answers.selectedHandJoints = selectedHandJoints;
                break;
        }

        console.log('getJointSelectionRatings', answers);
    }
    return answers;
}

function renderSceneItem(source, container, sceneId) {
    container.find('#scene-container').empty();
    console.log('renderSceneItem', sceneId);
    if (sceneId && (sceneId !== 'none' || sceneId !== null)) {
        $(container).find('#btn-refresh-scene').removeClass('hidden');
        var scene = getSceneById(sceneId);
        var sceneItem = $(source).find('#' + scene.type).clone().removeAttr('id');
        container.find('#scene-container').empty().append(sceneItem);
        var currentPhaseData = getCurrentPhaseData();
        var helpData = getItemsForSceneId(currentPhaseData, scene.id);
        if (helpData && helpData.length > 0) {
            $(container).find('#btn-getting-help').removeClass('hidden');
        } else {
            $(container).find('#btn-getting-help').addClass('hidden');
        }

        var wozData = getWOZItemsForSceneId(currentPhaseData.woz, scene.id);
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
                sceneItem.attr('src', scene.parameters.url);
                break;
            case SCENE_IMAGE:
                sceneItem[0].onload = function () {
                    var image = sceneItem[0];
                    var colorThief = new ColorThief();
                    var dominantColor = colorThief.getColor(image);
                    container.find('#scene-container').css("backgroundColor", "rgb(" + dominantColor[0] + "," + dominantColor[1] + "," + dominantColor[2] + ")");
                };
                sceneItem[0].src = scene.parameters.url;
                break;
            case SCENE_PIDOCO:
                sceneItem[0].src = scene.parameters.url;
                break;
            case SCENE_VIDEO_EMBED:
                sceneItem.find('.videoContainer').addClass(scene.options[0] === 'ratio_16_9' ? 'embed-responsive-16by9' : 'embed-responsive-4by3');
                sceneItem.find('.videoContainer').html(scene.parameters.url);
                var video = $(sceneItem).find('iframe');
                var src = video.attr('src');
                video.attr('src', src + "?autoplay=1");
                $(video).addClass('embed-responsive-item');
                container.find('#scene-container').css("backgroundColor", "rgb(0,0,0)");
                break;
        }

// scene positioning
        var containerOffsetTop = container.offset().top;
        var generalPanelHeight = previewModeEnabled ? 107 : 54;
        var study = getLocalItem(STUDY);
//        if(!previewModeEnabled === false) {
//            generalPanelHeight = 0;
//        }
//        console.log(containerOffsetTop);
        sceneItem.css({marginTop: generalPanelHeight + 'px'});
        // calcuation of the new window height if resizing the window
        $(window).resize(function () {

            var height;
            if (study.surveyType === TYPE_SURVEY_UNMODERATED) {
                height = $(window).height() - containerOffsetTop - generalPanelHeight;
            } else {
                if (study.phase === TYPE_PHASE_ELICITATION && scene.type === SCENE_VIDEO_EMBED) {
                    height = $(window).height() - containerOffsetTop - generalPanelHeight - generalPanelHeight;
                } else {
                    height = $(window).height() - generalPanelHeight;
                }
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

        if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
            getGMT(function (timestamp) {
                var slideData = data.slideshow[currentSlideIndex];
                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_END_PERFORM_GESTURE, gestureId: slideData.gestureId, triggerId: slideData.triggerId, time: timestamp});
                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_REACTIVATE_CONTROLS);
                }
            });
        } else {
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_REACTIVATE_CONTROLS);
            }
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
    appendAlert($(container), ALERT_PLEASE_WAIT);
}

function onUnmoderatedAnswerTimeExpired(source, container, data) {
    if (!previewModeEnabled) {
        getGMT(function (timestamp) {
            var slideData = data.slideshow[currentSlideIndex];
            var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_END_PERFORM_GESTURE, gestureId: slideData.gestureId, triggerId: slideData.triggerId, time: timestamp});
            setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
            loadHTMLintoModal('custom-modal', 'externals/modal-check-gesture.php', 'modal-lg');
        });
    }

    $(container).find('.gestureContainer .headline, .triggerContainer .headline').text(translation.timesUp);
    TweenMax.to(container.find('.previewGesture, .trigger-title'), .1, {opacity: 0});
    TweenMax.to(container.find('#slideshowContainer, .progress'), .1, {opacity: 0, onComplete: onHideUnmoderatedSlideComplete, onCompleteParams: [source, container, data]});
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

function animateLiveStream(target, zoom, swap, callback) {
    if (zoom === true) {
        var dimensions = calcDimensions();
        TweenMax.to(target, .3, {width: dimensions.width + 'px', top: dimensions.top + 'px', left: dimensions.left + 'px', opacity: 1, onComplete: function () {
                $(window).on('resize', function () {
                    var dimensions = calcDimensions();
                    target.css({width: dimensions.width + 'px', top: dimensions.top + 'px', left: dimensions.left + 'px'});
                });
                if (callback) {
                    callback();
                }
            }});
    } else {
        TweenMax.to(target, .2, {width: 300 + 'px', top: '60px', left: '10px', opacity: .8, onComplete: function () {
            }});
    }

    if (swap) {
        if (swap === VIEW_TESTER) {
            $(target).find(".rtc-local-container").after($(target).find(".rtc-remote-container"));
            $(target).find("#local-stream").css({width: '100%', top: '0px', left: '0px'});
            $(target).find("#remote-stream").css({width: '30%', height: '30%', top: '5px', left: '5px'});
        } else if (swap === VIEW_MODERATOR) {
            $(target).find(".rtc-remote-container").after($(target).find(".rtc-local-container"));
            $(target).find("#local-stream").css({width: '30%', top: '5px', left: '5px'});
            $(target).find("#remote-stream").css({width: '100%', height: '100%', top: '0px', left: '0px'});
        }
        keepStreamsAlive(target);
    }
}

function calcDimensions() {
    var screenSize = {width: $(window).width(), height: $(window).height()};
    var maxHeight = screenSize.height - 200;
    var maxWidth = maxHeight * 4 / 3;
    var ratio = screenSize.width / screenSize.height;
    if (ratio < 1) {
        maxWidth = screenSize.width - 50;
        maxHeight = maxWidth * 3 / 4;
    }

    var newTop = previewModeEnabled ? ((screenSize.height - maxHeight) / 2) - 88 : ((screenSize.height - maxHeight) / 2) + 20;
    var newLeft = (screenSize.width - maxWidth) / 2;
    return {width: maxWidth, height: maxHeight, top: newTop, left: newLeft};
}