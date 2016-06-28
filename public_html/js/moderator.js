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
        console.log('clone: ' + currentPhase.selectedId + ', from: ' + source.attr('id'));
        var container = $(source).find('#' + currentPhase.selectedId).clone(false).removeAttr('id');
        $(container).find('#column-left').css('opacity', '0');

        var item = null;
        switch (currentPhase.selectedId) {
            case QUESTIONNAIRE:
                item = Moderator.getQuestionnaire(source, container, currentPhaseData, true);
                break;
            case GUS_SINGLE_GESTURES:
                item = Moderator.getGUS(source, container, currentPhaseData);
                break;
            case GUS_MULTIPLE_GESTURES:
                item = Moderator.getQuestionnaire(source, container, currentPhaseData, true);
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
        }

        $('#viewModerator #phase-content').empty().append(item);
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
            var item = $(source).find('#' + data[i].type).clone(false).removeAttr('id');
            $(item).find('.question').text(i + 1 + '. ' + data[i].question);
            $(container).find('.question-container').append(item);

            if (data[i].dimension !== DIMENSION_ANY) {
                $(item).find('#dimension').removeClass('hidden');
                $(item).find('#dimension').text(translation.dimensions[data[i].dimension]);
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
                        renderAlternativeQuestionPreview(source, item, parameters);
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
                        renderRankingInput(source, item, options);
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
        for (var i = 0; i < data.length; i++) {
            var item = $(source).find('#gusItem').clone(false).removeAttr('id');
            $(item).find('.question').text(i + 1 + '. ' + data[i].question);
            $(container).find('.question-container').append(item);
            if (data[i].reversed === true) {
                $(item).find('#reversed').removeClass('hidden');
            }
            if (data[i].dimension !== DIMENSION_ANY) {
                $(item).find('#dimension').removeClass('hidden');
                $(item).find('#dimension').text(translation.dimensions[data[i].dimension]);
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
        var gesture = training.gesture;
        var repeats = training.repeats;
        var trigger = training.trigger;
        var feedback = training.feedback;

        $(container).find('#training .panel-heading-text').text('Geste ' + (currentGestureTrainingIndex + 1) + ' von ' + data.length);

        var item = $(source).find('#trainingItem').clone().removeAttr('id');
        $(container).find('#trainingContainer').empty();
        $(container).find('#trainingContainer').append(item);
        item.find('#title').text(translation.title + ": " + gesture.title);
        item.find('#repeats').text(translation.repeats + ": " + repeats);
        item.find('#trigger').text(translation.trigger + ": " + trigger.title);
        item.find('.btn-popover-gesture-preview').attr('name', gesture.id);

        if (feedback) {
            item.find('#feedback').text(translation.feedback + ": " + feedback.title);
        } else {
            item.find('#feedback').text(translation.feedback + ": " + translation.nones);
        }

        item.find('#trigger-training').on('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(item).find('.disabled').removeClass('disabled');
                $(this).addClass('disabled');
                trainingTriggered = true;
            } else {
                wobble(item.find('#next-gesture, #training-done'));
            }
        });

        item.find('#next-gesture').on('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                currentGestureTrainingIndex++;
                trainingTriggered = false;
                Moderator.renderGestureTraining(source, container, data);
            } else {
                wobble(item.find('#trigger-training'));
            }
        });

        item.find('#training-done').on('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                trainingTriggered = false;
                currentGestureTrainingIndex = 0;
                nextStep();
            } else {
                wobble(item.find('#trigger-training'));
            }
        });

        if (trainingTriggered) {
            $(item).find('.disabled').removeClass('disabled');
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

        if (currentView === VIEW_MODERATOR) {
            // slideshow section
            Moderator.renderSlide(source, container, data);

            // observation section
            if (data.observations && data.observations.length > 0) {
                Moderator.getQuestionnaire($('#item-container-inputs'), $(container).find('#observations'), data.observations, false);
            }
        } else {

        }
        return container;
    },
    renderSlide: function renderSlide(source, container, data) {
        $(container).find('#slides .panel-heading-text').text('Slide ' + (currentSlideIndex + 1) + ' von ' + data.slideshow.length);
        $(container).find('#slidesContainer').empty();
        var item = $(source).find('#slideshowItem').clone().removeAttr('id');

        $(container).find('#slidesContainer').append(item);
        var slide = data.slideshow[currentSlideIndex];
        item.find('.btn-popover-gesture-preview').attr('name', slide.gesture.id);
        $(item).find('#responseTime').text(data.answerTime + ' Sekunden');

        var imageContainer;
        if (data.slideshowFor === 'trigger') {
            $(item).find('#searched').text(slide.trigger.title);
            $(item).find('#given').text(slide.gesture.title);
            $(item).find('.btn-popover-gesture-preview').remove();
            $(container).find('#search-trigger').removeClass('hidden');
            imageContainer = $(item).find('.left .imageContainer');
        } else {
            $(item).find('#searched').text(slide.gesture.title);
            $(item).find('#given').text(slide.trigger.title);
            imageContainer = $(item).find('.right .imageContainer');
            $(container).find('#search-gestures').removeClass('hidden');
        }

        $(item).find('#trigger-slide').on('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                slideTriggered = true;
                $(item).find('.disabled').removeClass('disabled');
                $(this).addClass('disabled');
            } else {
                wobble($(item).find('#correct-slide, #next-slide, #wrong-slide'));
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
                wobble($(item).find('#trigger-slide'));
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
                    nextStep();
                } else {
                    wobble($(item).find('#trigger-slide'));
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
                    wobble($(item).find('#trigger-slide'));
                }
            });
        }
    },
    getScenario: function getScenario(source, container, data) {

        $(container).find('#general #task').text(translation.task + ": " + data.title);
        $(container).find('#general #description').text(translation.description + ": " + data.description);

        //scene
        if (data.scene) {
            $(container).find('#general #scene').removeClass('hidden');
            $(container).find('#general #scene').on('click', function (event) {
                event.preventDefault();
                currentSceneId = data.scene;
                loadHTMLintoModal('custom-modal', 'preview-scene.html', 'modal-lg');
            });
        }

        //woz section
        if (data.woz && data.woz.length > 0) {
            Moderator.renderWOZ(source, container, data.woz);
        }

        // help section
        if (data.help && data.help.length > 0) {
            Moderator.renderHelp(source, container, data.help);
        }

        // observation section
        if (data.observations && data.observations.length > 0) {
            Moderator.getQuestionnaire($('#item-container-inputs'), $(container).find('#observations'), data.observations, false);
        }

        return container;
    },
    renderWOZ: function renderWOZ(source, container, data) {
        for (var i = 0; i < data.length; i++) {
            var item = $(source).find('#wozItem').clone();
            item.removeAttr('id');
            $(container).find('.woz-container').append(item);
            var gesture = data[i].gesture;

            if (gesture) {
                item.find('.btn-popover-gesture-preview').attr('name', gesture.id);
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

            var gesture;
            if (data[i].useGestureHelp === true) {
                gesture = getGestureById(data[i].gestureId);
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
