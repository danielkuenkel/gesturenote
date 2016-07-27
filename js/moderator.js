/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var Moderator = {
    renderView: function renderView() {
        $('.alert-space').empty();
        var currentPhase = getCurrentPhase();
        var currentPhaseData = getLocalItem(currentPhase.id + '.data');
        var source = getSourceContainer(currentView);
//        console.log('clone: ' + currentPhase.selectedId + ', from: ' + source.attr('id'));
        var container = $(source).find('#' + currentPhase.selectedId).clone(false).removeAttr('id');
        $(container).find('#column-left').css('opacity', '0');

        var item = null;
        switch (currentPhase.selectedId) {
            case QUESTIONNAIRE:
                item = Moderator.getQuestionnaire(source, container, currentPhaseData, true);
                break;
            case GUS_SINGLE_GESTURES:
                item = Moderator.getQuestionnaire(source, container, getAssembledItems(currentPhaseData.gus), true);
                break;
            case GUS_MULTIPLE_GESTURES:
                item = Moderator.getQuestionnaire(source, container, getAssembledItems(currentPhaseData.gus), true);
                break;
            case SUS:
                item = Moderator.getSUS(source, container, currentPhaseData);
                break;
            case LETTER_OF_ACCEPTANCE:
                item = Moderator.getLetterOfAcceptance(container, currentPhaseData);
                break;
            case GESTURE_TRAINING:
                item = Moderator.getGestureTraining(source, container, currentPhaseData);
                break;
            case SCENARIO:
                item = Moderator.getScenario(source, container, currentPhaseData);
                break;
            case SLIDESHOW:
                item = Moderator.getSlideshow(source, container, currentPhaseData);
                break;
            case IDENTIFICATION:
                item = Moderator.getIdentification(source, container, currentPhaseData);
                break;
        }

        $('#viewModerator #phase-content').empty().append(item);
        TweenMax.from($('#phase-content #column-right'), .2, {y: -60, opacity: 0});

        if ($(document).scrollTop() > 0) {
            $(document).scrollTop(0);
        }

        updateRTCHeight($('#phase-content #column-left').width());
    },
    renderNoDataView: function renderNoDataView() {
        var alert = $(getSourceContainer(currentView)).find('#no-phase-data').clone().removeAttr('id');
        $('#viewModerator #phase-content').append(alert);
        appendAlert(alert, ALERT_NO_PHASE_DATA);

        TweenMax.from($('#phase-content #column-right'), .2, {y: -60, opacity: 0});

        if ($(document).scrollTop() > 0) {
            $(document).scrollTop(0);
        }

        updateRTCHeight($('#phase-content #column-left').width());
    },
    getLetterOfAcceptance: function getLetterOfAcceptance(container, data) {
        $(container).find('.letter-text').text(data);
        return container;
    },
    getQuestionnaire: function getQuestionnaire(source, container, data, isPreview) {
        for (var i = 0; i < data.length; i++) {
            var item = $(source).find('#' + data[i].type).clone().removeAttr('id');
//            console.log('clone: ' + data[i].type + " form: " + source.attr('id'));
            $(item).find('.question').text(data.length - i + '. ' + data[i].question);
            $(container).find('.question-container').prepend(item);

            if (data[i].dimension !== DIMENSION_ANY) {
                $(item).find('#item-factors').removeClass('hidden');
                $(item).find('#factor-primary').text(translation.dimensions[data[i].dimension]);
                $(item).find('#factor-main').text(translation.mainDimensions[getMainDimensionForDimension(data[i].dimension)]);
            }

            var parameters = data[i].parameters;
            var options = data[i].options;

            if (isPreview) {
                switch (data[i].type) {
                    case DICHOTOMOUS_QUESTION:
                        renderDichotomousQuestionPreview(item, parameters);
                        break;
                    case GROUPING_QUESTION:
                        renderGroupingQuestionPreview(source, item, parameters, options);
                        break;
                    case GUS_SINGLE:
                        renderGUSSinglePreview(item, data[i]);
                        break;
                    case GROUPING_QUESTION_GUS:
                        renderGroupingQuestionGUSPreview(source, item, parameters, options);
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
                switch (data[i].type) {
                    case DICHOTOMOUS_QUESTION:
                        renderDichotomousQuestionInput(item, parameters);
                        break;
                    case GROUPING_QUESTION:
                        renderGroupingQuestionInput(item, parameters, options);
                        break;
                    case GROUPING_QUESTION_GUS:
                        renderGroupingQuestionGUSInput(item, parameters, options);
                        break;
                    case RATING:
                        renderRatingInput(source, item, options);
                        break;
                    case SUM_QUESTION:
                        renderSumQuestionInput(item, parameters, options);
                        break;
                    case RANKING:
                        renderRankingInput(item, options);
                        break;
                    case ALTERNATIVE_QUESTION:
                        renderAlternativeQuestionInput(source, item, parameters);
                        break;
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
            if (data[i].reversed === true) {
                $(item).find('#reversed').removeClass('hidden');
            }
        }
        return container;
    },
    getGUS: function getGUS(source, container, data) {
        if (data.gus && data.gus.length > 0)
        {
            for (var i = 0; i < data.gus.length; i++) {
                var item = $(source).find('#gusItem').clone(false).removeAttr('id');
                $(item).find('.question').text(i + 1 + '. ' + data.gus[i].question);
                $(container).find('.question-container').append(item);
                if (data.gus[i].reversed === true) {
                    $(item).find('#reversed').removeClass('hidden');
                }
                if (data.gus[i].dimension !== DIMENSION_ANY) {
                    $(item).find('#item-factors').removeClass('hidden');
                    $(item).find('#factor-primary').text(translation.dimensions[data.gus[i].dimension]);
                    $(item).find('#factor-main').text(translation.mainDimensions[data.gus[i].dimension]);
                }
            }
        }
        return container;
    },
    getGestureTraining: function getGestureTraining(source, container, data) {
        // general data section
        $(container).find('#general .panel-heading').text(data.title);
        $(container).find('#general #description').text(data.description);

        // gestures section
        Moderator.renderGestureTraining(source, container, data.training);

        // observation section
        if (data.observations && data.observations.length > 0) {
            Moderator.getQuestionnaire($('#item-container-inputs'), $(container).find('#observations'), data.observations, false);
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
//        item.find('#title .address').text(translation.title + ":");
//        item.find('#title .text').text(gesture.title);
//        item.find('#repeats .address').text(translation.repeats + ":");
//        item.find('#repeats .text').text(repeats);
//        item.find('#trigger .address').text(translation.trigger + ":");
//        item.find('#trigger .text').text(trigger.title);
//        item.find('.btn-popover-gesture-preview').attr('name', gesture.id);
//        item.find('#feedback .address').text(translation.feedback + ":");

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

        container.find('#btn-start-training').click(function (event) {
            event.preventDefault();
            $(this).addClass('hidden');
            gestureTrainingStartTriggered = true;
            item.find('#trigger-training').removeClass('disabled');
            wobble([container.find('#trainingContainer'), $('#web-rtc-placeholder')]);
        });

        item.find('#trigger-training').on('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(item).find('#trigger-feedback').removeClass('disabled');
                $(this).addClass('disabled');
                trainingTriggered = true;
            } else {
                if (gestureTrainingStartTriggered) {
                    wobble(item.find('#trigger-feedback'));
                } else {
                    wobble(container.find('#btn-start-training'));
                }
            }
        });

        item.find('#trigger-feedback').on('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(item).find('#next-gesture, #training-done').removeClass('disabled');
//                $(this).addClass('disabled');
//                feedbackTriggered = true;
                triggeredFeedback = feedback;
            } else if (triggeredFeedback === null) {
                if (gestureTrainingStartTriggered) {
                    wobble(item.find('#trigger-training'));
                } else {
                    wobble(container.find('#btn-start-training'));
                }
            }
        });

        item.find('#next-gesture').on('click', function (event) {
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

        item.find('#training-done').on('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                trainingTriggered = false;
                triggeredFeedback = null;
                gestureTrainingStartTriggered = false;
                currentGestureTrainingIndex = 0;
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
    getSlideshow: function getSlideshow(source, container, data) {
        // general data section
        $(container).find('#general .panel-heading').text(data.title);
        $(container).find('#general #description').text(data.description);

        // slideshow section
        Moderator.renderSlide(source, container, data);

        // observation section
        if (data.observations && data.observations.length > 0) {
            Moderator.getQuestionnaire($('#item-container-inputs'), $(container).find('#observations'), data.observations, false);
        }
        return container;
    },
    renderSlide: function renderSlide(source, container, data) {
        var slide = data.slideshow[currentSlideIndex];
        var gesture = getGestureById(slide.gestureId);
        var trigger = getTriggerById(slide.triggerId);

        $(container).find('#slides .panel-heading-text').text('Slide ' + (currentSlideIndex + 1) + ' von ' + data.slideshow.length);
        $(container).find('#slidesContainer').empty();
        var item = $(source).find('#slideshowItem').clone().removeAttr('id');
        $(container).find('#slidesContainer').append(item);

        item.find('.btn-popover-gesture-preview').attr('name', gesture.id);
        $(item).find('#responseTime').text(data.answerTime + ' Sekunden');

        var imageContainer;
        if (data.slideshowFor === 'trigger') {
            $(item).find('#searched').text(trigger.title);
            $(item).find('#given').text(gesture.title);
            $(item).find('.btn-popover-gesture-preview').remove();
            $(container).find('#search-trigger').removeClass('hidden');
            imageContainer = $(item).find('.left .imageContainer');
        } else {
            $(item).find('#searched').text(gesture.title);
            $(item).find('#given').text(trigger.title);
            imageContainer = $(item).find('.right .imageContainer');
            $(container).find('#search-gestures').removeClass('hidden');
        }

        if (slideshowStartTriggered) {
            $(container).find('#btn-start-slideshow').remove();
        } else {
            $(item).find('#trigger-slide').addClass('disabled');
        }

        $(container).find('#btn-start-slideshow').click(function (event) {
            event.preventDefault();
            slideshowStartTriggered = true;
            $(this).remove();
            $(item).find('#trigger-slide').removeClass('disabled');
            wobble([container.find('#slidesContainer'), $('#web-rtc-placeholder')]);
        });

        $(item).find('#trigger-slide').on('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                slideTriggered = true;
                $(item).find('.disabled').removeClass('disabled');
                $(this).addClass('disabled');
            } else {
                if (slideshowStartTriggered) {
                    wobble($(item).find('#correct-slide, #next-slide, #wrong-slide'));
                } else {
                    wobble($(container).find('#btn-start-slideshow'));
                }
            }
        });

        $(item).find('#wrong-slide').on('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                currentSlideIndex = 0;
                slideTriggered = false;
                $(item).find('.disabled').removeClass('disabled');
                Moderator.renderSlide(source, container, data);
            } else {
                if (slideshowStartTriggered) {
                    wobble($(item).find('#trigger-slide'));
                } else {
                    wobble($(container).find('#btn-start-slideshow'));
                }
            }
        });

        if (slideTriggered) {
            $(item).find('.disabled').removeClass('disabled');
            item.find('#trigger-slide').addClass('disabled');
        }

        if (data.slideshow.length === 1 || currentSlideIndex >= data.slideshow.length - 1) {
            $(item).find('#correct-slide, #next-slide').on('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    currentSlideIndex = 0;
                    slideTriggered = false;
                    nextStep();
                } else {
                    if (slideshowStartTriggered) {
                        wobble($(item).find('#trigger-slide'));
                    } else {
                        wobble($(container).find('#btn-start-slideshow'));
                    }
                }
            });
        } else if (currentSlideIndex < data.slideshow.length) {
            $(item).find('#correct-slide, #next-slide').on('click', function (event) {
                event.preventDefault();
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    slideTriggered = false;
                    currentSlideIndex++;
                    Moderator.renderSlide(source, container, data);
                } else {
                    if (slideshowStartTriggered) {
                        wobble($(item).find('#trigger-slide'));
                    } else {
                        wobble($(container).find('#btn-start-slideshow'));
                    }
                }
            });
        }
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

        // slideshow section
        Moderator.renderIdentification(source, container, data);

        // observation section
        if (data.observations && data.observations.length > 0) {
            Moderator.getQuestionnaire($('#item-container-inputs'), $(container).find('#observations'), data.observations, false);
        }
        return container;
    },
    renderIdentification: function renderIdentification(source, container, data) {
        var identificationId = data.identification[currentIdentificationIndex];
        var searchedData;
        if (data.identificationFor === 'gestures') {
            searchedData = getTriggerById(identificationId);
        } else {
            searchedData = getGestureById(identificationId);
        }

        $(container).find('#slides .panel-heading-text').text(translation.formats.identification + ' ' + (currentIdentificationIndex + 1) + ' ' + translation.of + ' ' + data.identification.length);
        var item = $(source).find('#identificationItem').clone().removeAttr('id');
        $(container).find('#identificationContainer').empty().append(item);

        if (data.identificationFor === 'gestures') {
            $(item).find('#search .address').text(translation.identified + ':');
            $(item).find('#search .text').text(translation.gesture);
            $(item).find('#search-for .address').text(translation.For + ' ' + translation.trigger + ':');
            $(item).find('#search-for .text').text(searchedData.title);
            $(item).find('#gesture-repeats').removeClass('hidden');
            $(item).find('#gesture-repeats .text').text(data.identificationRepeats);
            $(item).find('.btn-popover-gesture-preview').remove();
        } else {
            $(item).find('#search .address').text(translation.identified + ':');
            $(item).find('#search .text').text(translation.trigger);
            $(item).find('#search-for .address').text(translation.For + ' ' + translation.gesture + ':');
            $(item).find('#search-for .text').text(searchedData.title);
            item.find('.btn-popover-gesture-preview').attr('name', searchedData.id);
        }


        if (identificationStartTriggered) {
            $(container).find('#btn-start-identification').remove();
        } else {
            $(item).find('#trigger-identification').addClass('disabled');
        }

        $(container).find('#btn-start-identification').click(function (event) {
            event.preventDefault();
            identificationStartTriggered = true;
            $(this).remove();
            $(item).find('#trigger-identification').removeClass('disabled');
            wobble([container.find('#identificationContainer'), $('#web-rtc-placeholder')]);
        });

        $(item).find('#trigger-identification').on('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                identificationTriggered = true;
                $(item).find('.disabled').removeClass('disabled');
                $(this).addClass('disabled');
            } else {
                if (identificationStartTriggered) {
                    wobble($(item).find('#next-identification, #done-identification'));
                } else {
                    wobble($(container).find('#btn-start-identification'));
                }
            }
        });

        if (identificationTriggered) {
            $(item).find('.disabled').removeClass('disabled');
            item.find('#trigger-identification').addClass('disabled');
        }

        if (data.identification.length === 1 || currentIdentificationIndex >= data.identification.length - 1) {
            $(item).find('#next-identification').remove();
            $(item).find('#done-identification').on('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    currentIdentificationIndex = 0;
                    identificationTriggered = false;
                    identificationStartTriggered = false;
                    nextStep();
                } else {
                    if (identificationStartTriggered) {
                        wobble($(item).find('#trigger-identification'));
                    } else {
                        wobble($(container).find('#btn-start-identification'));
                    }
                }
            });
        } else if (currentIdentificationIndex < data.identification.length) {
            $(item).find('#done-identification').remove();
            $(item).find('#next-identification').on('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    identificationTriggered = false;
                    currentIdentificationIndex++;
                    Moderator.renderIdentification(source, container, data);
                } else {
                    if (identificationStartTriggered) {
                        wobble($(item).find('#trigger-identification'));
                    } else {
                        wobble($(container).find('#btn-start-identification'));
                    }
                }
            });
        }
    },
    getScenario: function getScenario(source, container, data) {
        triggeredHelp, triggeredWoz = null;
        $(container).find('#general #task').text(translation.taskTitle + ": " + data.title);
        $(container).find('#general #description').text(translation.task + ": " + data.description);

        //scene
        if (data.scene) {
            $(container).find('#general #scene').removeClass('hidden');
            $(container).find('#general #scene').on('click', function (event) {
                event.preventDefault();
                currentSceneId = data.scene;
                loadHTMLintoModal('scene-modal', 'preview-scene.html', 'modal-lg');
            });
        }

        //woz section
        if (data.woz && data.woz.length > 0) {
            Moderator.renderWOZ(source, container, data.woz);
        }

        // help section
        if (data.help && data.help.length > 0) {
            Moderator.renderHelp(source, container, data.help);
        } else {
            $(container).find('#help').remove();
            $(container).find('#wozExperiment').removeClass('col-lg-6').addClass('col-lg-12');
        }

        // observation section
        if (data.observations && data.observations.length > 0) {
            Moderator.getQuestionnaire($('#item-container-inputs'), $(container).find('#observations'), data.observations, false);
        }

        // controls handling
        if (scenarioStartTriggered) {
            enableControls();
        } else {
            $(container).find('#start-scenario').click(function (event) {
                event.preventDefault();
                enableControls();
                scenarioStartTriggered = true;
                wobble([container.find('#woz-controls'), $('#web-rtc-placeholder')]);
            });
        }

        function enableControls() {
            $(container).find('#start-scenario').remove();

            var wozItems = $(container).find('.woz-container .disabled');
            wozItems.removeClass('disabled');

            var helpItems = $(container).find('.help-container .disabled');
            helpItems.removeClass('disabled');
        }

        return container;
    },
    renderWOZ: function renderWOZ(source, container, data) {
        for (var i = 0; i < data.length; i++) {
            var item = $(source).find('#wozItem').clone();
            item.removeAttr('id');
            $(container).find('.woz-container').append(item);


            item.find('#trigger-woz').click({wozData: data[i]}, function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    triggeredHelp = null;
                    triggeredWoz = event.data.wozData;
                } else {
                    $(document).scrollTop(0);
                    wobble(container.find('#general'));
                }
            });

            var trigger = getTriggerById(data[i].triggerId);
            if (trigger) {
                item.find('#trigger-title').text(trigger.title);
            } else {
                item.find('#trigger-title').remove();
            }

            var gesture = getGestureById(data[i].gestureId);
            if (gesture) {
                item.find('#gesture-title').text(gesture.title);
                item.find('.btn-popover-gesture-preview').attr('name', gesture.id);
            } else {
                item.find('#gesture-title').remove();
                item.find('.btn-popover-gesture-preview').remove();
            }

            var transitionScene = getSceneById(data[i].transitionId);
            if (transitionScene) {
                item.find('#btn-show-transition-scene').click({sceneId: data[i].transitionId}, function (event) {
                    event.preventDefault();
                    currentSceneId = event.data.sceneId;
                    loadHTMLintoModal('scene-modal', 'preview-scene.html', 'modal-lg');
                });
            } else {
                item.find('#btn-show-transition-scene').remove();
            }
        }
        return container;
    },
    renderHelp: function renderHelp(source, container, data) {
        var seperator = document.createElement('hr');
        for (var i = 0; i < data.length; i++) {
            var item = $(source).find('#helpItem').clone();
            item.removeAttr('id');
            item.find('.help-title').text((i + 1) + ". " + data[i].option);
            $(container).find('.help-container').append(item);

            item.find('#offer-help').click({helpData: data[i]}, function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    triggeredWoz = null;
                    triggeredHelp = event.data.helpData;
                } else {
                    $(document).scrollTop(0);
                    wobble(container.find('#general'));
                }
            });

            if (data[i].useGestureHelp === true) {
                var gesture = getGestureById(data[i].gestureId);
                item.find('.btn-popover-gesture-preview').removeClass('hidden');
                item.find('.btn-popover-gesture-preview').attr('name', gesture.id);
            } else {
                item.find('.btn-popover-gesture-preview').remove();
            }

            if (i < data.length - 1) {
                $(container).find('.help-container').append(seperator);
            }
        }
        return container;
    }
};
