/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var screenSharing = null;
var prototypeWindow = null;

var Moderator = {
    renderView: function renderView() {
        $('.alert-space').empty();
        var currentPhase = getCurrentPhase();
        var currentPhaseData = getCurrentPhaseData();
        var source = getSourceContainer(currentView);

        if (previewModeEnabled === false) {
            setLocalItem(currentPhase.id + '.tempSaveData', {startTime: new Date().getTime()});
        }

        if (currentPhaseData || (currentPhaseData && $.isArray(currentPhaseData) && currentPhaseData.length > 0)) {
            Moderator.initializePeerConnection();

//        console.log('clone: ' + currentPhase.format + ', from: ' + source.attr('id'));
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
                case IDENTIFICATION:
                    item = Moderator.getIdentification(source, container, currentPhaseData);
                    break;
                case PHYSICAL_STRESS_TEST:
                    item = Moderator.getPhysicalStressTest(source, container, currentPhaseData);
                    break;
                case EXPLORATION:
                    item = Moderator.getExploration(source, container, currentPhaseData);
                    break;
            }

            if (item !== false) {
                if (!syncPhaseStep) {
                    $('#viewModerator #phase-content').empty().append(item);
                }
                Moderator.initializeRTC();
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

        $('#viewModerator #column-right').css({y: 0, opacity: 1});

        Moderator.checkPositioning(currentPhase.format);
        TweenMax.from($('#phase-content #column-right'), .2, {y: -60, opacity: 0, clearProps: 'all'});
        if ($(document).scrollTop() > 0) {
            $(document).scrollTop(0);
        }

        updateRTCHeight($('#phase-content #column-left').width());
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
                        $(item).find('#factor-main').text(translation.mainDimensions[getMainDimensionForDimension(data[i].dimension)]);
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

        $(container).find('#btn-next-step').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!previewModeEnabled && peerConnection) {
                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
            }
            nextStep();
        });

        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_QUESTIONNAIRE_DONE).bind(MESSAGE_QUESTIONNAIRE_DONE, function (event, payload) {
                console.log('questionnaire done');
                $(container).find('#btn-next-step').removeClass('disabled');
            });

            if (getCurrentPhase().format !== PHYSICAL_STRESS_TEST) {
                $(peerConnection).unbind(MESSAGE_UPDATE_QUESTIONNAIRE).bind(MESSAGE_UPDATE_QUESTIONNAIRE, function (event, payload) {
                    console.log('update questionnaire');
                    renderQuestionnaireAnswers(container, data, payload);
                });
            }
        }

        return container;
    },
    getSUS: function getSUS(source, container, data) {
//        for (var i = 0; i < data.length; i++) {
//            var item = $(source).find('#susItem').clone(false).removeAttr('id');
//            $(item).find('.question').text(i + 1 + '. ' + data[i].question);
//            $(container).find('.question-container').append(item);
//            if (data[i].parameters.negative === 'yes') {
//                $(item).find('#reversed').removeClass('hidden');
//            }
//        }
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

        // general data section
        $(container).find('#general .panel-heading').text(data.title);
        $(container).find('#general #description').text(data.description);

        // gestures section
        Moderator.renderGestureTraining(source, container, data.training);

        // observation section
        renderObservations(data, container);
        return container;
    },
    renderGestureTraining: function renderGestureTraining(source, container, data) {
        var training = data[currentGestureTrainingIndex];
        var gesture = getGestureById(training.gestureId);
        var trigger = getTriggerById(training.triggerId);
        var feedback = getFeedbackById(training.feedbackId);
        var repeats = training.repeats;
        $(container).find('#training .panel-heading-text').text('Geste ' + (currentGestureTrainingIndex + 1) + ' von ' + data.length);

        var item = $(source).find('#trainingItem').clone().removeAttr('id');
        item.find('#title .address').text(translation.title + ":");
        item.find('#title .text').text(gesture.title);
        item.find('#repeats .address').text(translation.repeats + ":");
        item.find('#repeats .text').text(repeats - currentTrainingIndex);
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

        if (gestureTrainingStartTriggered) {
            item.find('#trigger-training').removeClass('disabled');
            container.find('#btn-start-training').addClass('hidden');
        }

        container.find('#btn-start-training').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(this).addClass('hidden');
            gestureTrainingStartTriggered = true;
            item.find('#trigger-training').removeClass('disabled');
            wobble([container.find('#trainingContainer')]);

            if (!previewModeEnabled && peerConnection) {
                peerConnection.sendMessage(MESSAGE_START_GESTURE_TRAINING);
            }
        });

        item.find('#trigger-training').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(item).find('#trigger-feedback').removeClass('disabled');
                $(this).addClass('disabled');
                trainingTriggered = true;

                if (!previewModeEnabled && peerConnection) {
                    peerConnection.sendMessage(MESSAGE_TRAINING_TRIGGERED, {currentGestureTrainingIndex: currentGestureTrainingIndex, gestureId: gesture.id});
                }
            } else {
                if (gestureTrainingStartTriggered) {
                    wobble(item.find('#trigger-feedback'));
                } else {
                    wobble(container.find('#btn-start-training'));
                }
            }
        });

        item.find('#trigger-feedback').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(this).addClass('disabled');
                currentTrainingIndex++;
                item.find('#repeats .text').text(repeats - currentTrainingIndex);
                if (currentTrainingIndex >= repeats) {
                    $(item).find('#next-gesture, #training-done').removeClass('disabled');
                } else {
                    $(item).find('#trigger-training').removeClass('disabled');
                }

//                $(this).addClass('disabled');
//                feedbackTriggered = true;
                triggeredFeedback = feedback;

                if (!previewModeEnabled && peerConnection) {
                    peerConnection.sendMessage(MESSAGE_FEEDBACK_TRIGGERED, {feedbackId: feedback.id, gestureId: gesture.id});
                }
            } else if (triggeredFeedback === null) {
                if (gestureTrainingStartTriggered) {
                    wobble(item.find('#trigger-training'));
                } else {
                    wobble(container.find('#btn-start-training'));
                }
            }
        });

        item.find('#next-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                currentGestureTrainingIndex++;
                currentTrainingIndex = 0;
                trainingTriggered = false;
                triggeredFeedback = null;
                Moderator.renderGestureTraining(source, container, data);
            } else {
                if (gestureTrainingStartTriggered) {
                    wobble(item.find('#trigger-training, #trigger-feedback'));
                } else {
                    wobble(container.find('#btn-start-training'));
                }
            }
        });

        item.find('#training-done').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                trainingTriggered = false;
                triggeredFeedback = null;
                gestureTrainingStartTriggered = false;
                currentGestureTrainingIndex = 0;

                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_NEXT_STEP);
                }

                nextStep();
            } else {
                if (gestureTrainingStartTriggered) {
                    wobble(item.find('#trigger-training, #trigger-feedback'));
                } else {
                    wobble(container.find('#btn-start-training'));
                }
            }
        });

        if (trainingTriggered) {
            $(item).find('#next-gesture, #training-done, #trigger-feedback').removeClass('disabled');
            item.find('#trigger-training').addClass('disabled');
        } else {
            if (currentTrainingIndex >= repeats) {
                item.find('#trigger-training').addClass('disabled');
                $(item).find('#next-gesture, #training-done').removeClass('disabled');
            } else {
                item.find('#trigger-training').removeClass('disabled');
            }
        }

        if (currentGestureTrainingIndex >= (data.length - 1)) {
            $(container).find('#next-gesture').addClass('hidden');
            $(container).find('#training-done').removeClass('hidden');
        }
    },
    getGestureSlideshow: function getGestureSlideshow(source, container, data) {
//        console.log('getGestureSlideshow');
        if (data.slideshow.length === 0) {
            return false;
        }

        // general data section
        $(container).find('#general .panel-heading').text(data.title);
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
            $(container).find('#slides .panel-heading-text').text('Slide ' + (index + 1) + ' von ' + data.slideshow.length);
            $(container).find('#slidesContainer').empty();
            var item = $(source).find('#gestureSlideshowItem').clone().removeAttr('id');
            $(container).find('#slidesContainer').append(item);
            var gesture = getGestureById(slide.gestureId);
            var trigger = getTriggerById(slide.triggerId);
            item.find('.btn-popover-gesture-preview').attr('name', gesture.id);
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
                    peerConnection.sendMessage(MESSAGE_TRIGGER_GESTURE_SLIDE, {currentSlideIndex: currentSlideIndex});
                }
            } else {
                if (slideshowStartTriggered) {
                    wobble($(container).find('#btn-done'));
                } else {
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
        $(container).find('#general .panel-heading').text(data.title);
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
                console.log(answers);
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
    getIdentification: function getIdentification(source, container, data) {
        // general data section
        removeLocalItem(ELICITED_GESTURES);
        $(container).find('#general .panel-heading').text(data.title);
        $(container).find('#general #description').text(data.description);

        if (data.identificationFor === 'gestures') {
            $(container).find('#search-gestures').removeClass('hidden');
        } else {
            $(container).find('#search-trigger').removeClass('hidden');
        }

        if (data.identification.length === 0) {
            return false;
        }

        // slideshow section
        Moderator.renderIdentification(source, container, data);

        // observation section
        renderObservations(data, container);
        return container;
    },
    renderIdentification: function renderIdentification(source, container, data) {
        $(container).find('#slides .panel-heading-text').text(translation.formats.identification.text);
        if (data.identification && data.identification.length > 0) {
            var searchedData;
            for (var i = 0; i < data.identification.length; i++) {
                var item = $(source).find('#identificationItem').clone().removeAttr('id');
                $(item).find('#index').text(i + 1 + '.');

                if (i > 0) {
                    var line = document.createElement('hr');
                    $(line).css({marginTop: "10px", marginBottom: "10px"});
                    $(container).find('#identificationContainer').append(line);
                }

                $(container).find('#identificationContainer').append(item);

                if (data.identificationFor === 'gestures') {
                    searchedData = getTriggerById(data.identification[i].triggerId);
                    $(item).find('#search .address').text(translation.identified + ':');
                    $(item).find('#search .text').text(translation.gesture);
                    $(item).find('#search-for .address').text(translation.For + ' ' + translation.trigger + ':');
                    $(item).find('#search-for .text').text(searchedData.title);
                    $(item).find('#gesture-repeats').removeClass('hidden');
                    $(item).find('#gesture-repeats .text').text(data.identificationRepeats);
                    $(item).find('.btn-popover-gesture-preview').remove();
                } else {
                    searchedData = getGestureById(data.identification[i].gestureId);
                    $(item).find('#search .address').text(translation.identified + ':');
                    $(item).find('#search .text').text(translation.trigger);
                    $(item).find('#search-for .address').text(translation.For + ' ' + translation.gesture + ':');
                    $(item).find('#search-for .text').text(searchedData.title);
                    item.find('.btn-popover-gesture-preview').attr('name', searchedData.id);
                }
            }
        }

        if (identificationStartTriggered) {
            $(container).find('#btn-start-identification').remove();

            var listItems = $(container).find('#identificationContainer .identificationItem');
            if (currentIdentificationIndex > 0 && listItems && listItems.length > 0) {
                for (var i = 0; i < currentIdentificationIndex; i++) {
                    var listItem = listItems[i];
                    $(listItem).addClass('text-green');
                    $(listItem).find('.fa-check').removeClass('hidden');
                }
            }
        }

        $(container).find('#btn-start-identification').unbind('click').bind('click', function (event) {
            event.preventDefault();
            identificationStartTriggered = true;
            $(this).remove();
//            $(item).find('#trigger-identification').removeClass('disabled');
            wobble([container.find('#identificationContainer')]);

            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_START_IDENTIFICATION);
            }
        });

        if (peerConnection) {
            $(peerConnection).unbind(MESSAGE_GESTURE_IDENTIFIED).bind(MESSAGE_GESTURE_IDENTIFIED, function (event, payload) {
                var listItems = $(container).find('#identificationContainer .identificationItem');
                if (listItems && listItems.length > 0) {
                    var listItem = listItems[payload.index];
                    $(listItem).addClass('text-green');
                    $(listItem).find('.fa-check').removeClass('hidden');
                }

                clearAlerts($(container).find('#recordedGestures'));
                console.log('gesture identified', payload, listItems);

                var elicitedGestures = getLocalItem(ELICITED_GESTURES);
                if (elicitedGestures) {
                    elicitedGestures.push(payload.gesture);
                    setLocalItem(ELICITED_GESTURES, elicitedGestures);
                } else {
                    var array = new Array();
                    array.push(payload.gesture);
                    setLocalItem(ELICITED_GESTURES, array);
                }

                var thumbnail = getGestureElicitationListThumbnail($(source).find('#gesture-thumbnail').clone(), payload.gesture, 'col-xs-6 col-sm-4', ELICITED_GESTURES);
                $(container).find('#recordedGestures #gestures-list-container').append(thumbnail);
            });

            $(peerConnection).unbind(MESSAGE_IDENTIFIED_GESTURE_DELETED).bind(MESSAGE_IDENTIFIED_GESTURE_DELETED, function (event, payload) {
                console.log('gestureDeleted', payload);
                var listItems = $(container).find('#identificationContainer .identificationItem');
                if (listItems && listItems.length > 0) {
                    var listItem = listItems[payload.index];
                    $(listItem).removeClass('text-green');
                    $(listItem).find('.fa-check').addClass('hidden');
                }
                $(container).find('#gestures-list-container').find('#' + payload.gestureId).remove();
                var gestures = $(container).find('#recordedContainer').find('.gesture-thumbnail');
                if (!gestures || gestures.length === 0) {
                    appendAlert($(container).find('#recordedGestures'), ALERT_NO_RECORDED_GESTURES);
                }
            });

            $(peerConnection).unbind(MESSAGE_IDENTIFICATION_DONE).bind(MESSAGE_IDENTIFICATION_DONE, function (event, payload) {
                console.log('identification done');
                $(container).find('#btn-done').removeClass('disabled');
            });
        }

        if (identificationDone) {
            $(container).find('#btn-done').removeClass('disabled');
            $(container).find('#btn-start-identification').remove();
        }

        appendAlert($(container).find('#recordedGestures'), ALERT_NO_RECORDED_GESTURES);

        $(container).find('#btn-done').on('click', function (event) {
            if (!$(this).hasClass('disabled')) {
                if (!previewModeEnabled) {
                    peerConnection.sendMessage(MESSAGE_NEXT_STEP);
                }
                nextStep();
            }
        });
    },
    getPhysicalStressTest: function getPhysicalStressTest(source, container, data) {
        if (!data.stressTestItems || data.stressTestItems.length === 0) {
            return false;
        }

        // general data section
        $(container).find('#general .panel-heading').text(data.title);
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
        $(container).find('#controls .panel-heading').text(translation.gesture + " " + (currentStressTestIndex + 1) + " " + translation.of + " " + data.stressTestItems.length);

        Moderator.renderPhysicalStressTestQuestionnaire(container, data, currentQuestionnaireAnswers);

        if (stressTestStartTriggered) {
            container.find('#btn-show-gesture').removeClass('disabled');
            container.find('#btn-start-stress-test').remove();
        }

        if (currentStressTestCount >= data.stressAmount) {
            $(container).find('#btn-next-gesture').removeClass('disabled');
            $(container).find('#btn-show-gesture, #btn-show-question').addClass('disabled');
        } else {
            $(container).find('#btn-next-gesture').addClass('disabled');
        }

        if (currentStressTestIndex >= data.stressTestItems.length - 1) {
            $(container).find('#btn-next-gesture .btn-text').text(translation.done);
            $(container).find('#btn-next-gesture .fa-check').removeClass('hidden');
            $(container).find('#btn-next-gesture #next-arrow').addClass('hidden');
        }

        var gesture = getGestureById(data.stressTestItems[currentStressTestIndex]);
        if (gesture) {
            container.find('.btn-popover-gesture-preview').attr('name', gesture.id);
            container.find('#stress-for .text').text(gesture.title);
        } else {
            container.find('.btn-popover-gesture-preview').addClass('disabled');
        }
        container.find('#repeats-left .text').text((data.stressAmount - currentStressTestCount));

        if (stressTestGestureTriggered) {
            container.find('#btn-show-gesture').addClass('disabled');
            container.find('#btn-show-question').removeClass('disabled');
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
                container.find('#btn-show-question').removeClass('disabled');
                stressTestGestureTriggered = true;
                stressTestQuestionsTriggered = false;

                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_TRIGGER_STRESS_TEST_GESTURE, {count: currentStressTestCount, index: currentStressTestIndex});
                }
            } else {
                if (stressTestStartTriggered) {
                    wobble(container.find('#btn-show-question'));
                } else {
                    wobble(container.find('#btn-start-stress-test'));
                }
            }
        });

        container.find('#btn-show-question').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(this).addClass('disabled');
                $(container).find('#btn-show-gesture').addClass('disabled');

                currentStressTestCount++;
                stressTestQuestionsTriggered = true;
                stressTestGestureTriggered = false;

                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_TRIGGER_STRESS_TEST_QUESTION, {count: currentStressTestCount, index: currentStressTestIndex});
                }

                if (previewModeEnabled) {
                    Moderator.renderPhysicalStressTest(source, container, data);
                }
            } else {
                if (!stressTestStartTriggered) {
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
                if (currentStressTestIndex >= data.stressTestItems.length - 1) {
                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_NEXT_STEP);
                    }

                    nextStep();
                } else {
                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_TRIGGER_NEXT_STRESS_TEST_GESTURE, {count: currentStressTestCount, index: currentStressTestIndex});
                    }

                    stressTestQuestionsTriggered = false;
                    stressTestGestureTriggered = false;
                    currentStressTestCount = 0;
                    currentStressTestIndex++;

                    Moderator.renderPhysicalStressTest(source, container, data);
                }
            } else {
                if (!stressTestStartTriggered) {
                    wobble(container.find('#btn-start-stress-test'));
                } else {
                    wobble(container.find('#btn-show-gesture, #btn-show-question'));
                }

            }
        });
    },
    renderPhysicalStressTestQuestionnaire: function renderPhysicalStressTestQuestionnaire(container, studyData, resultsData) {
        // check if answers are there
//        console.log(studyData, currentStressTestIndex);
        var currentStressTestData = studyData.stressTestItems[currentStressTestIndex];
        container.find('#gestures-container').empty();

//        for (var i = 0; i < studyData.stressTestItems.length; i++) {
        var gesture = getGestureById(currentStressTestData);
        var item = $('#item-container-moderator').find('#physicalStressTest-item').clone().removeAttr('id');
        container.find('#gestures-container').append(item);
        renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage);
        $(item).find('#gesture .address').text(translation.gesture + ': ');
        $(item).find('#gesture .text').text(gesture.title);
        $(item).find('#trigger .address').text(translation.trigger + ': ');
        $(item).find('#trigger .text').text(trigger.title);
        $(item).find('#selection .address').text(translation.trigger + ' ' + translation.answer + ': ');

        // single questions joint section
        if (resultsData && resultsData.answers) {
            var singleStressGraphicsRating = studyData.singleStressGraphicsRating;
            if (singleStressGraphicsRating !== 'none') {
                var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
                $(jointAnswers).insertAfter($(item).find('#headline-single-questions'));
                if (singleStressGraphicsRating === 'hands') {
                    $(jointAnswers).find('#joint-answers-body').remove();
                    renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData.answers, gesture.id, 'single');
                } else if (singleStressGraphicsRating === 'body') {
                    $(jointAnswers).find('#joint-answers-hands').remove();
                    renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData.answers, gesture.id, 'single');
                } else {
                    renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData.answers, gesture.id, 'single');
                    renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData.answers, gesture.id, 'single');
                }
            }

            // sequence questions joint section
            var sequenceStressGraphicsRating = studyData.sequenceStressGraphicsRating;
            if (sequenceStressGraphicsRating !== 'none') {
                var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
                $(jointAnswers).insertAfter($(item).find('#headline-sequence-questions'));

                if (sequenceStressGraphicsRating === 'hands') {
                    $(jointAnswers).find('#joint-answers-body').remove();
                    renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData.answers, gesture.id, 'sequence');
                } else if (sequenceStressGraphicsRating === 'body') {
                    $(jointAnswers).find('#joint-answers-hands').remove();
                    renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData.answers, gesture.id, 'sequence');
                } else {
                    renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData.answers, gesture.id, 'sequence');
                    renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData.answers, gesture.id, 'sequence');
                }
            }
        }


        // single answers section
        var singleStressQuestionnaire = studyData.singleStressQuestions;
        if (singleStressQuestionnaire && singleStressQuestionnaire.length > 0) {
            if (resultsData && resultsData.answers && resultsData.answers.length > 0) {
                var results = new Object();
                results.answers = new Array();
                var questions = new Array();

                for (var j = 0; j < resultsData.answers.length; j++) {
                    if (parseInt(resultsData.answers[j].gestureId) === parseInt(gesture.id) && resultsData.answers[j].singleAnswers) {
                        results.answers = results.answers.concat(resultsData.answers[j].singleAnswers.answers);
                        questions = questions.concat(singleStressQuestionnaire);
                    }
                }
//                console.log(results);
                if (questions.length > 0 && results.answers.length > 0) {
                    renderQuestionnaireAnswers($(item).find('#single-stress-answers'), questions, results, false, true);
                }
            } else {
                renderQuestionnaireAnswers($(item).find('#single-stress-answers'), singleStressQuestionnaire, null, false);
            }
        }

        // sequence answers section
        var sequenceStressQuestionnaire = studyData.sequenceStressQuestions;
        if (sequenceStressQuestionnaire && sequenceStressQuestionnaire.length > 0) {
            if (resultsData && resultsData.answers && resultsData.answers.length > 0) {
                var results = new Object();
                results.answers = new Array();
                var questions = new Array();

                for (var j = 0; j < resultsData.answers.length; j++) {
                    if (parseInt(resultsData.answers[j].gestureId) === parseInt(gesture.id) && resultsData.answers[j].sequenceAnswers) {
                        results.answers = results.answers.concat(resultsData.answers[j].sequenceAnswers.answers);
                        questions = questions.concat(sequenceStressQuestionnaire);
                    }
                }

                if (questions.length > 0 && results.answers.length > 0) {
                    renderQuestionnaireAnswers($(item).find('#sequence-stress-answers'), questions, results, false);
                }
            } else {
                renderQuestionnaireAnswers($(item).find('#sequence-stress-answers'), sequenceStressQuestionnaire, null, false);
            }
        }
//        }
//        else {
//            // single stress questions
//            if (studyData.singleStressQuestions && studyData.singleStressQuestions.length > 0) {
//                Moderator.getQuestionnaire($('#item-container-moderator'), $(container).find('#singleStressQuestions'), studyData.singleStressQuestions, true);
//            }
//
//            // sequence stress questions
//            if (studyData.sequenceStressQuestions && studyData.sequenceStressQuestions.length > 0) {
//                Moderator.getQuestionnaire($('#item-container-moderator'), $(container).find('#sequenceStressQuestions'), studyData.sequenceStressQuestions, true);
//            }
//
//            if (studyData.singleStressGraphicsRating !== 'none') {
//                $(container).find('#singleStressQuestions #parts-' + studyData.singleStressGraphicsRating).removeClass('hidden');
//            }
//
////            console.log(data.singleStressGraphicsRating, data.sequenceStressGraphicsRating);
//            if (studyData.sequenceStressGraphicsRating !== 'none') {
//                $(container).find('#sequenceStressQuestions #parts-' + studyData.sequenceStressGraphicsRating).removeClass('hidden');
//            }
//        }
    },
    getExploration: function getExploration(source, container, data) {
//        console.log(source, container, data);
        $(container).find('#general .panel-heading').text(data.title);
        $(container).find('#general #description').text(data.description);

        // observation section
        renderObservations(data, container);

        // render data (gestures, trigger, scenes)
        renderExplorationItems(container, data, 'modal-gesture-rudimentary');

        if (explorationStartTriggered) {
            $(container).find('#btn-start-exploration').remove();
            $(container).find('#btn-next-step').removeClass('hidden');
        }

        if (explorationDone) {
            $(container).find('#btn-next-step').removeClass('disabled');
        }

        $(container).find('#btn-start-exploration').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(container).find('#btn-next-step').removeClass('hidden');
            explorationStartTriggered = true;
            wobble(container.find('#exploration-items-container'));
            $(this).remove();

            if (!previewModeEnabled && peerConnection) {
                peerConnection.sendMessage(MESSAGE_START_EXPLORATION);

                $(peerConnection).unbind(MESSAGE_REACTIVATE_CONTROLS).bind(MESSAGE_REACTIVATE_CONTROLS, function (event, payload) {
                    $(container).find('#btn-next-step').removeClass('disabled');
                });
            }
        });

        $(container).find('#btn-next-step').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                if (!previewModeEnabled && peerConnection) {
                    peerConnection.sendMessage(MESSAGE_NEXT_STEP);
                }
                nextStep();
            }
        });

        return container;
    },
    getScenario: function getScenario(source, container, data) {
        triggeredHelp, triggeredWoz = null;
        $(container).find('#general #task .address').text(translation.taskTitle);
        $(container).find('#general #task .text').text(data.title);
        $(container).find('#general #description .address').text(translation.task);
        $(container).find('#general #description .text').text(data.description);

        if (!currentWOZScene) {
            currentWOZScene = getSceneById(data.scene);
        }

        if (!previewModeEnabled) {
            var currentPhase = getCurrentPhase();
            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
            tempData.actions = new Array();
            tempData.transitions = new Array();
            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
        }

        updateCurrentScene(container);

        //woz section
        Moderator.renderWOZ(source, container, data);

        // help section
        Moderator.renderHelp(source, container, data);

        // observation section
        renderObservations(data, container);

        // controls handling
        if (scenarioPrototypeOpened) {
            enableScenarioControls(container);
        }

        var query = getQueryParams(document.location.search);
        $(container).find('#btn-open-prototype').unbind('click').bind('click', function (event) {
            event.preventDefault();
            enableScenarioControls(container);
            scenarioPrototypeOpened = true;

            wobble([container.find('#woz-controls')]);
            currentSceneId = data.scene;
            $(container).find('#btn-start-screen-sharing').removeClass('hidden');

            if (currentWOZScene) {
                if (data.woz) {
                    if (peerConnection) {
                        prototypeWindow = window.open("study-execution-prototype-sharing.php?phaseId=" + getCurrentPhase().id + "&roomId=" + query.roomId, "_blank");
                    } else {
                        prototypeWindow = window.open("study-execution-prototype-sharing.php?phaseId=" + getCurrentPhase().id, "_blank");
                    }
                } else {
                    if (peerConnection && currentWOZScene.type !== SCENE_WEB && currentWOZScene.type !== SCENE_PIDOCO) {
                        prototypeWindow = window.open("study-execution-prototype-sharing.php?phaseId=" + getCurrentPhase().id + "&roomId=" + query.roomId, "_blank");
                    } else if (currentWOZScene.type !== SCENE_WEB && currentWOZScene.type !== SCENE_PIDOCO) {
                        prototypeWindow = window.open("study-execution-prototype-sharing.php?phaseId=" + getCurrentPhase().id, "_blank");
                    } else {
                        prototypeWindow = window.open(currentWOZScene.data[0], "_blank");
                    }
                }
            }
        });


        $(container).find('#btn-start-screen-sharing').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (screenSharing === null) {
                if (query.roomId === undefined && previewModeEnabled === true) {
                    screenSharing = new ScreenSharing('previewRoom', false);
                } else {
                    screenSharing = new ScreenSharing(query.roomId + "screensharing", true);
                }

                $(screenSharing).unbind('started').bind('started', function (event) {
                    scenarioStartTriggered = true;
                    $(container).find('#btn-start-screen-sharing').addClass('hidden');
                    $(container).find('#btn-stop-screen-sharing').removeClass('hidden');

                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_START_SCENARIO);

                        var time = new Date().getTime();
                        var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                        tempData.actions.push({action: ACTION_START_TASK, time: time});
                        tempData.transitions.push({scene: data.scene, time: time});
                        setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                    }
                });
            }

            screenSharing.start();
        });

        $(container).find('#btn-stop-screen-sharing').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(this).addClass('hidden');
            $(container).find('#btn-done-scenario').removeClass('hidden');
            screenSharing.stop();
            scenarioPrototypeOpened = false;
            scenarioStartTriggered = false;

            if (prototypeWindow) {
                scenarioPrototypeOpened = false;
                prototypeWindow.close();
            }
        });

        if (scenarioPrototypeOpened && !scenarioStartTriggered) {
            $(container).find('#btn-open-prototype').addClass('hidden');
            $(container).find('#btn-stop-screen-sharing').addClass('hidden')
            $(container).find('#btn-start-screen-sharing').removeClass('hidden');
        } else if (scenarioPrototypeOpened && scenarioStartTriggered && screenSharing && screenSharing.status === STATUS_STARTED) {
            $(container).find('#btn-start-screen-sharing').addClass('hidden');
            $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
        } else if (!scenarioPrototypeOpened && !scenarioStartTriggered && screenSharing && screenSharing.status === STATUS_STOPPED) {
            $(container).find('#btn-start-screen-sharing').addClass('hidden');
            $(container).find('#btn-stop-screen-sharing').addClass('hidden');
            $(container).find('#btn-open-prototype').addClass('hidden');
            $(container).find('#btn-done-scenario').removeClass('hidden');
        }

        $(container).find('#btn-done-scenario').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (peerConnection) {
                screenSharing.upload(function () {
                    screenSharing = null;
                });
                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
            }

            nextStep();
        });

        $(container).find('#btn-reload-scene').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_RELOAD_SCENE);

                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                tempData.actions.push({action: ACTION_REFRESH_SCENE, scene: data.scene, time: new Date().getTime()});
                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                renderModeratedScenario(source, container, data);
            }
        });

        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_HELP_CLOSED).bind(MESSAGE_HELP_CLOSED, function (event, payload) {
                $(container).find('.btn-info').removeClass('disabled');
            });
        }

        return container;
    },
    renderWOZ: function renderWOZ(source, container, data) {
        if (data.woz) {
            var wozData = getItemsForSceneId(data.woz, currentWOZScene.id);
            removeAlert($(container).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
            $(container).find('.woz-container').empty();
            if (data.woz && data.woz.length > 0 && wozData && wozData.length > 0) {

                for (var i = 0; i < wozData.length; i++) {
                    var item = $(source).find('#wozItem').clone().removeAttr('id');
                    $(container).find('.woz-container').append(item);

//                    var trigger = getTriggerById(wozData[i].triggerId);

                    var gesture = getGestureById(wozData[i].gestureId);
                    if (gesture) {
                        renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage, null);
                    } else {
                    }

                    var transitionScene = getSceneById(wozData[i].transitionId);
                    if (transitionScene) {
                        item.find('#btn-show-transition-scene').unbind('click').bind('click', {sceneId: wozData[i].transitionId}, function (event) {
                            event.preventDefault();
                            currentSceneId = event.data.sceneId;
                            loadHTMLintoModal('custom-modal', 'modal-scene.php', 'modal-lg');
                        });
                    } else {
                        item.find('#btn-show-transition-scene').remove();
                    }

                    item.find('#btn-trigger-woz').unbind('click').bind('click', {wozData: wozData[i], originalData: data}, function (event) {
                        event.preventDefault();
                        if (!$(this).hasClass('disabled')) {

                            triggeredWoz = event.data.wozData;
                            currentWOZScene = getSceneById(triggeredWoz.transitionId);
                            if (currentWOZScene) {
                                updateCurrentScene(container);
                                Moderator.renderWOZ(source, container, event.data.originalData);
                                Moderator.renderHelp(source, container, event.data.originalData);
                            } else {
                                currentWOZScene = getSceneById(triggeredWoz.sceneId);
                            }

                            enableScenarioControls(container);

                            prototypeWindow.postMessage({message: MESSAGE_TRIGGER_WOZ, currentWOZScene: currentWOZScene}, 'https://gesturenote.de');
                            if (peerConnection) {
                                peerConnection.sendMessage(MESSAGE_TRIGGER_WOZ, {triggeredWOZ: triggeredWoz, currentWOZScene: currentWOZScene});

                                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                                tempData.actions.push({action: ACTION_END_PERFORM_GESTURE, time: new Date().getTime()});
                                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                            }
                        } else {
                            if (!scenarioStartTriggered) {
                                $(document).scrollTop(0);
                                wobble(container.find('#general'));
                            }
                        }
                    });
                }
            } else {
                appendAlert($(container).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
            }
        } else {
            $(container).find('#woz-controls').remove();
        }
    },
    renderHelp: function renderHelp(source, container, data) {
        var helpData = getItemsForSceneId(data.help, currentWOZScene.id);

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

                            var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                            tempData.actions.push({action: ACTION_REQUEST_HELP, time: new Date().getTime()});
                            setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
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

//                if (i < helpData.length - 1) {
//                    var seperator = document.createElement('hr');
//                    $(container).find('.help-container').append(seperator);
//                }
            }
        } else {
            $(container).find('#help-controls').remove();
//            appendAlert($(container).find('#help-controls'), ALERT_NO_PHASE_DATA);
        }
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
            });

            $(peerConnection).unbind(MESSAGE_REQUEST_SYNC).bind(MESSAGE_REQUEST_SYNC, function (event, payload) {
                console.log('request sync');
                resetConstraints();
                renderPhaseStep();
                peerConnection.sendMessage(MESSAGE_SYNC_PHASE_STEP, {index: currentPhaseStepIndex});
            });

            $(peerConnection).unbind(MESSAGE_SYNC_PHASE_STEP).bind(MESSAGE_SYNC_PHASE_STEP, function (event, payload) {
                console.log('sync phase step', payload.index);
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
            streamControls: $('#stream-controls'),
            localMuteElement: $('#btn-stream-local-mute'),
            pauseStreamElement: $('#btn-pause-stream'),
            remoteMuteElement: $('#btn-stream-remote-mute'),
            indicator: $('#stream-control-indicator'),
            enableWebcamStream: true,
            enableDataChannels: options.enableDataChannels && options.enableDataChannels === 'yes' || false,
            autoRequestMedia: true,
            roomId: query.roomId,
            localStream: {audio: options.moderator.audio, video: options.moderator.video, visualize: options.moderator.visualizeStream},
            remoteStream: {audio: options.tester.audio, video: options.tester.video}
        };
        $(callerOptions.target).prepend(callerOptions.callerElement);

        peerConnection.update(callerOptions);
        if (peerConnection.status !== STATUS_UNINITIALIZED) {
            var videos = $(callerOptions.callerElement).find('video');
            for (var i = 0; i < videos.length; i++) {
                videos[i].play();
            }
        }
    }
};

function enableScenarioControls(container) {
    $(container).find('#btn-open-prototype').remove();
    $(container).find('#btn-start-screen-sharing').removeClass('hidden');
//    $(container).find('#btn-done-scenario').removeClass('hidden');
    var wozItems = $(container).find('.woz-container .disabled');
    wozItems.removeClass('disabled');
    var helpItems = $(container).find('.help-container .disabled');
    helpItems.removeClass('disabled');
}

function updateCurrentScene(container) {
    container.find('.panel-body #icon-' + currentWOZScene.type).removeClass('hidden');
    container.find('.panel-body .label-text').text(translation.sceneTypes[currentWOZScene.type]);
    container.find('#current-scene').text(currentWOZScene.title);

    container.find('#btn-preview-scene').click(function (event) {
        event.preventDefault();

        currentSceneId = currentWOZScene.id;
//        console.log(currentWOZScene, currentSceneId)
        loadHTMLintoModal('custom-modal', 'modal-scene.php', 'modal-lg');
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
    if (!uploadQueue.allFilesUploaded()) {
        console.log('sumbmit final data with upload queue, some files where not uploaded yet!');
        submitFinalData(container, false);
        $(uploadQueue).unbind(EVENT_ALL_FILES_UPLOADED).bind(EVENT_ALL_FILES_UPLOADED, function () {
            console.log('allVideosUploaded');
            $(uploadQueue).unbind(EVENT_ALL_FILES_UPLOADED);
            submitFinalData(container, true);
        });
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