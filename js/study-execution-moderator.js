/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var Moderator = {
    renderView: function renderView() {
        $('.alert-space').empty();
        var currentPhase = getCurrentPhase();
        var currentPhaseData = getCurrentPhaseData();
        var source = getSourceContainer(currentView);
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
        $(container).find('.thanks-text').text(data);
        $(container).find('#btn-leave-survey').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var query = getQueryParams(document.location.search);
            if (query.studyId && query.h && query.token) {
                goto('study-prepare-evaluator.php?studyId=' + query.studyId + '&h=' + query.h + '&token=' + query.token);
            }
        });
        return container;
    },
    getQuestionnaire: function getQuestionnaire(source, container, data, isPreview) {
        data = getAssembledItems(data);
        if (data && data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                var item = $(source).find('#' + data[i].format).clone();

//            console.log('clone: ' + data[i].format + " form: " + source.attr('id'));
                if (data.length > 1) {
                    $(item).find('.question').text(data.length - i + '. ' + data[i].question);
                } else {
                    $(item).find('.question').text(data[i].question);
                }

                $(container).find('.question-container').prepend(item);
                if (data[i].dimension !== DIMENSION_ANY) {
                    $(item).find('#item-factors').removeClass('hidden');
                    $(item).find('#factor-primary').text(translation.dimensions[data[i].dimension]);
                    $(item).find('#factor-main').text(translation.mainDimensions[getMainDimensionForDimension(data[i].dimension)]);
                }

                var parameters = data[i].parameters;
                var options = data[i].options;
                if (isPreview) {
                    item.find('#format .format-text').text(translation.questionFormats[data[i].format].text);
                    switch (data[i].format) {
                        case COUNTER:
                            renderCounterPreview(item, parameters);
                            break;
                        case DICHOTOMOUS_QUESTION:
                            renderDichotomousQuestionPreview(item, parameters);
                            break;
                        case DICHOTOMOUS_QUESTION_GUS:
                            renderDichotomousQuestionGUSPreview(item, parameters);
                            break;
                        case GROUPING_QUESTION:
                            renderGroupingQuestionPreview(source, item, parameters, options);
                            break;
                        case GROUPING_QUESTION_GUS:
                            renderGroupingQuestionGUSPreview(source, item, parameters);
                            break;
                        case GUS_SINGLE:
                            renderGUSSinglePreview(item, data[i]);
                            break;
                        case RATING:
                            renderRatingPreview(source, item, options);
                            break;
                        case SUM_QUESTION:
                            renderSumQuestionPreview(source, item, parameters, options);
                            break;
                        case RANKING:
                            renderRankingPreview(source, item, options);
                            break;
                        case ALTERNATIVE_QUESTION:
                            renderAlternativeQuestionPreview(item, parameters);
                            break;
                    }
                } else {
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
                            renderGroupingQuestionGUSInput(item, parameters, options);
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
                            renderAlternativeQuestionInput(item, parameters);
                            break;
                    }
                }
            }
        }

        return container;
    },
    getSUS: function getSUS(source, container, data) {
        for (var i = 0; i < data.length; i++) {
            var item = $(source).find('#susItem').clone(false).removeAttr('id');
            $(item).find('.question').text(i + 1 + '. ' + data[i].question);
            $(container).find('.question-container').append(item);
            if (data[i].parameters.negative === 'yes') {
                $(item).find('#reversed').removeClass('hidden');
            }
        }
        return container;
    },
    getGUS: function getGUS(source, container, data) {
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
        if (data.observations && data.observations.length > 0) {
            Moderator.getQuestionnaire($('#item-container-inputs'), $(container).find('#observations'), data.observations, false);

            $(container).find('#observations').on('change', function () {
                var study = getLocalItem(STUDY);
                saveObservationAnwers($(container).find('#observations .question-container'), study.id, study.testerId);
            });
        }

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
        $(container).find('#trainingContainer').empty();
        $(container).find('#trainingContainer').append(item);
        item.find('#title .address').text(translation.title + ":");
        item.find('#title .text').text(gesture.title);
        item.find('#repeats .address').text(translation.repeats + ":");
        item.find('#repeats .text').text(repeats);
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
//                $(container).find('#')
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
                    peerConnection.sendMessage(MESSAGE_TRAINING_TRIGGERED, {currentGestureTrainingIndex: currentGestureTrainingIndex});
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
                $(item).find('#next-gesture, #training-done').removeClass('disabled');
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
        if (triggeredFeedback !== null) {

        } else if (trainingTriggered) {
            $(item).find('#next-gesture, #training-done, #trigger-feedback').removeClass('disabled');
            item.find('#trigger-training').addClass('disabled');
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
        }

        $(container).find('#btn-start-slideshow').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_START_TRIGGER_SLIDESHOW);
            }
            slideshowStartTriggered = true;
            $(this).remove();
        });

        // done button
        if (testerDoneTriggered) {
            $(container).find('#btn-done-slideshow').removeClass('hidden');
        }

        $(container).find('#btn-done-slideshow').unbind('click').bind('click', function (event) {
            event.preventDefault();
            nextStep();
        });

        // slideshow section
        for (var i = 0; i < data.slideshow.length; i++) {
            var item = $(source).find('#triggerSlideshowItem').clone().removeAttr('id');
            $(container).find('.question-container').append(item);
            var gesture = getGestureById(data.slideshow[i].gestureId);
            var trigger = getTriggerById(data.slideshow[i].triggerId);
            $(item).find('#searched').text(trigger.title);
            $(item).find('#given').text(gesture.title);
        }

        return container;
    },
    getIdentification: function getIdentification(source, container, data) {
        // general data section
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
//        if (data.observations && data.observations.length > 0) {
//            Moderator.getQuestionnaire($('#item-container-inputs'), $(container).find('#observations'), data.observations, false);
//
//            $(container).find('#observations').on('change', function () {
//                var study = getLocalItem(STUDY);
//                saveObservationAnwers($(container).find('#observations .question-container'), study.id, study.testerId, getCurrentPhase().id);
//            });
//        }
        return container;
    },
    renderIdentification: function renderIdentification(source, container, data) {
//        var identificationId = data.identification[currentIdentificationIndex];
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
                    searchedData = getTriggerById(data.identification[i]);
                    $(item).find('#search .address').text(translation.identified + ':');
                    $(item).find('#search .text').text(translation.gesture);
                    $(item).find('#search-for .address').text(translation.For + ' ' + translation.trigger + ':');
                    $(item).find('#search-for .text').text(searchedData.title);
                    $(item).find('#gesture-repeats').removeClass('hidden');
                    $(item).find('#gesture-repeats .text').text(data.identificationRepeats);
                    $(item).find('.btn-popover-gesture-preview').remove();
                } else {
                    searchedData = getGestureById(data.identification[i]);
                    $(item).find('#search .address').text(translation.identified + ':');
                    $(item).find('#search .text').text(translation.trigger);
                    $(item).find('#search-for .address').text(translation.For + ' ' + translation.gesture + ':');
                    $(item).find('#search-for .text').text(searchedData.title);
                    item.find('.btn-popover-gesture-preview').attr('name', searchedData.id);
                }
            }
        }
//        if (identificationId) {


//        $(container).find('#slides .panel-heading-text').text(translation.formats.identification.text + ' ' + (currentIdentificationIndex + 1) + ' ' + translation.of + ' ' + data.identification.length);
//        var item = $(source).find('#identificationItem').clone().removeAttr('id');
//        $(container).find('#identificationContainer').empty().append(item);
//        if (data.identificationFor === 'gestures') {
//            $(item).find('#search .address').text(translation.identified + ':');
//            $(item).find('#search .text').text(translation.gesture);
//            $(item).find('#search-for .address').text(translation.For + ' ' + translation.trigger + ':');
//            $(item).find('#search-for .text').text(searchedData.title);
//            $(item).find('#gesture-repeats').removeClass('hidden');
//            $(item).find('#gesture-repeats .text').text(data.identificationRepeats);
//            $(item).find('.btn-popover-gesture-preview').remove();
//        } else {
//            $(item).find('#search .address').text(translation.identified + ':');
//            $(item).find('#search .text').text(translation.trigger);
//            $(item).find('#search-for .address').text(translation.For + ' ' + translation.gesture + ':');
//            $(item).find('#search-for .text').text(searchedData.title);
//            item.find('.btn-popover-gesture-preview').attr('name', searchedData.id);
//        }
//        }

        if (identificationStartTriggered) {
            $(container).find('#btn-start-identification').remove();
        }
//        else {
//            $(item).find('#trigger-identification').addClass('disabled');
//        }

        $(container).find('#btn-start-identification').unbind('click').bind('click', function (event) {
            event.preventDefault();
            identificationStartTriggered = true;
            $(this).remove();
//            $(item).find('#trigger-identification').removeClass('disabled');
            wobble([container.find('#identificationContainer')]);
        });

//        $(item).find('#trigger-identification').on('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                identificationTriggered = true;
//                $(item).find('.disabled').removeClass('disabled');
//                $(this).addClass('disabled');
//            } else {
//                if (identificationStartTriggered) {
//                    wobble($(item).find('#next-identification, #done-identification'));
//                } else {
//                    wobble($(container).find('#btn-start-identification'));
//                }
//            }
//        });
//        if (identificationTriggered) {
//            $(item).find('.disabled').removeClass('disabled');
//            item.find('#trigger-identification').addClass('disabled');
//        }

//        if (data.identification.length === 1 || currentIdentificationIndex >= data.identification.length - 1) {
//            $(item).find('#next-identification').remove();
//            $(item).find('#done-identification').on('click', function (event) {
//                event.preventDefault();
//                if (!$(this).hasClass('disabled')) {
//                    currentIdentificationIndex = 0;
//                    identificationTriggered = false;
//                    identificationStartTriggered = false;
//                    nextStep();
//                } else {
//                    if (identificationStartTriggered) {
//                        wobble($(item).find('#trigger-identification'));
//                    } else {
//                        wobble($(container).find('#btn-start-identification'));
//                    }
//                }
//            });
//        } else if (currentIdentificationIndex < data.identification.length) {
//            $(item).find('#done-identification').remove();
//            $(item).find('#next-identification').on('click', function (event) {
//                event.preventDefault();
//                if (!$(this).hasClass('disabled')) {
//                    identificationTriggered = false;
//                    currentIdentificationIndex++;
//                    Moderator.renderIdentification(source, container, data);
//                } else {
//                    if (identificationStartTriggered) {
//                        wobble($(item).find('#trigger-identification'));
//                    } else {
//                        wobble($(container).find('#btn-start-identification'));
//                    }
//                }
//            });
//        }
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

        // single stress questions
        if (data.singleStressQuestions && data.singleStressQuestions.length > 0) {
            Moderator.getQuestionnaire($('#item-container-moderator'), $(container).find('#singleStressQuestions'), data.singleStressQuestions, true);
        }

        // sequence stress questions
        if (data.sequenceStressQuestions && data.sequenceStressQuestions.length > 0) {
            Moderator.getQuestionnaire($('#item-container-moderator'), $(container).find('#sequenceStressQuestions'), data.sequenceStressQuestions, true);
        }

        // observation section
        renderObservations(data, container);
//        if (data.observations && data.observations.length > 0) {
//            Moderator.getQuestionnaire($('#item-container-inputs'), $(container).find('#observations'), data.observations, false);
//
//            $(container).find('#observations').on('change', function () {
//                var study = getLocalItem(STUDY);
//                saveObservationAnwers($(container).find('#observations .question-container'), study.id, study.testerId, getCurrentPhase().id);
//            });
//        }

        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_REACTIVATE_CONTROLS).bind(MESSAGE_REACTIVATE_CONTROLS, function (event, payload) {
                if (currentStressTestCount >= data.stressAmount) {
                    container.find('#btn-next-gesture').removeClass('disabled');
                } else {
                    Moderator.renderPhysicalStressTest(source, container, data);
                }
            });
        }

        return container;
    },
    renderPhysicalStressTest: function renderPhysicalStressTest(source, container, data) {
        $(container).find('#controls .panel-heading').text(translation.gesture + " " + (currentStressTestIndex + 1) + " " + translation.of + " " + data.stressTestItems.length);

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
            $(container).find('#btn-next-gesture').text(translation.done);
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

                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_TRIGGER_STRESS_TEST_QUESTION, {count: currentStressTestCount, index: currentStressTestIndex});
                }

                currentStressTestCount++;
                stressTestQuestionsTriggered = true;
                stressTestGestureTriggered = false;

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
    getScenario: function getScenario(source, container, data) {
        if (!data.scene || !data.woz) {
            return false;
        }

        triggeredHelp, triggeredWoz = null;
        $(container).find('#general #task .address').text(translation.taskTitle);
        $(container).find('#general #task .text').text(data.title);
        $(container).find('#general #description .address').text(translation.task);
        $(container).find('#general #description .text').text(data.description);
        //scene
        if (data.scene) {
            $(container).find('#general #btn-preview-scene').removeClass('hidden');
            $(container).find('#general #btn-preview-scene').unbind('click').bind('click', function (event) {
                event.preventDefault();
                currentSceneId = data.scene;
                loadHTMLintoModal('custom-modal', 'modal-scene.php', 'modal-lg');
            });
        }

        if (!currentWOZScene) {
            currentWOZScene = getSceneById(data.scene);
        }

        updateCurrentScene(container);

        //woz section
        Moderator.renderWOZ(source, container, data);

        // help section
        Moderator.renderHelp(source, container, data);

        // observation section
        renderObservations(data, container);
//        if (data.observations && data.observations.length > 0) {
//            var savedObservations = getObservationResults(getCurrentPhase().id);
//            console.log(savedObservations);
//
//            Moderator.getQuestionnaire($('#item-container-inputs'), $(container).find('#observations'), data.observations, false);
//
//            $(container).find('#observations').on('change', function () {
//                var study = getLocalItem(STUDY);
//                saveObservationAnwers($(container).find('#observations .question-container'), study.id, study.testerId, getCurrentPhase().id);
//            });
//        }

        // controls handling
        if (scenarioStartTriggered) {
            enableScenarioControls(container);
        }

        $(container).find('#btn-start-scenario').unbind('click').bind('click', function (event) {
            event.preventDefault();
            enableScenarioControls(container);
            scenarioStartTriggered = true;
            wobble([container.find('#woz-controls')]);

            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_START_SCENARIO);
            }
        });

        $(container).find('#btn-done-scenario').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
            }
            nextStep();
        });

        $(container).find('#btn-reload-scene').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_RELOAD_SCENE);
            }
        });

        if (peerConnection) {
            $(peerConnection).unbind(MESSAGE_HELP_CLOSED).bind(MESSAGE_HELP_CLOSED, function (event, payload) {
//                if (messageData.message === MESSAGE_HELP_CLOSED) {
                $(container).find('.btn-info').removeClass('disabled');
//                }
            });
        }

        return container;
    },
    renderWOZ: function renderWOZ(source, container, data) {
        var wozData = getItemsForSceneId(data.woz, currentWOZScene.id);
        removeAlert($(container).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
        $(container).find('.woz-container').empty();
        if (data.woz && data.woz.length > 0) {

            for (var i = 0; i < wozData.length; i++) {
                var item = $(source).find('#wozItem').clone();
                item.removeAttr('id');
                $(container).find('.woz-container').append(item);
                item.find('#trigger-woz').unbind('click').bind('click', {wozData: wozData[i], originalData: data}, function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {

//                    triggeredHelp = null;
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

                        if (peerConnection) {
                            peerConnection.sendMessage(MESSAGE_TRIGGER_WOZ, {triggeredWOZ: triggeredWoz, currentWOZScene: currentWOZScene});
                        }
                    } else {
                        if (!scenarioStartTriggered) {
                            $(document).scrollTop(0);
                            wobble(container.find('#general'));
                        }
                    }
                });
                var trigger = getTriggerById(wozData[i].triggerId);
                if (trigger) {
                    item.find('#trigger-woz').text(trigger.title);
//                item.find('#trigger-title').text(trigger.title);
                } else {
//                item.find('#trigger-title').remove();
                }

                var gesture = getGestureById(wozData[i].gestureId);
                if (gesture) {
//                item.find('#gesture-title').text(gesture.title);
                    item.find('.btn-popover-gesture-preview').attr('name', gesture.id);
                } else {
//                item.find('#gesture-title').remove();
                    item.find('.btn-popover-gesture-preview').remove();
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
            }
        } else {
            appendAlert($(container).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
        }

        return container;
    },
    renderHelp: function renderHelp(source, container, data) {
        var helpData = getItemsForSceneId(data.help, currentWOZScene.id);
        var seperator = document.createElement('hr');
        $(container).find('.help-container').empty();
        removeAlert($(container).find('#help'), ALERT_NO_PHASE_DATA);
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

                if (i < helpData.length - 1) {
                    $(container).find('.help-container').append(seperator);
                }
            }
        } else {
            appendAlert($(container).find('#help'), ALERT_NO_PHASE_DATA);
        }

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
        var enableDataChannels = options.enableDataChannels && enableDataChannels === 'yes' || false;
        var callerOptions = {
            target: $('#viewModerator').find('#pinnedRTC'),
            callerElement: $('#video-caller'),
            localVideoElement: 'local-stream',
            remoteVideoElement: 'remote-stream',
            enableDataChannels: options.enableDataChannels && options.enableDataChannels === 'yes' || false,
            roomId: query.roomId,
            localStream: {audio: options.moderator.audio, video: options.moderator.video, visualize: options.moderator.visualizeStream},
            remoteStream: {audio: options.tester.audio, video: options.tester.video}
        };
        $(callerOptions.target).prepend(callerOptions.callerElement);

        if (peerConnection.status === STATUS_UNINITIALIZED) {
            peerConnection.update(callerOptions);
        } else {
            peerConnection.update(callerOptions);
            var videos = $(callerOptions.callerElement).find('video');
            for (var i = 0; i < videos.length; i++) {
                videos[i].play();
            }
        }
    },
};

function enableScenarioControls(container) {
    $(container).find('#btn-start-scenario').remove();
    $(container).find('#btn-done-scenario').removeClass('hidden');
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
            if (savedObservations && savedObservations.length > 0) {
                renderEditableObservations($(container).find('#observations .question-container'), data.observations.reverse(), savedObservations);
            } else {
                Moderator.getQuestionnaire($('#item-container-inputs'), $(container).find('#observations'), data.observations, false);
            }

            $(container).find('#observations').on('change', function () {
                var study = getLocalItem(STUDY);
                saveObservationAnwers($(container).find('#observations .question-container'), study.id, study.testerId, getCurrentPhase().id);
            });
        } else {
            Moderator.getQuestionnaire($('#item-container-inputs'), $(container).find('#observations'), data.observations, false);
        }
    }
}