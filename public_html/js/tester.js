/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var singleGUSGesture = null;
var Tester = {
    renderView: function renderView() {
        $('.alert-space').empty();
        var currentPhase = getCurrentPhase();
        var currentPhaseData = getLocalItem(currentPhase.id + '.data');
        var source = getSourceContainer(currentView);
        console.log('clone: ' + currentPhase.selectedId + ', from: ' + source.attr('id'));
        var container = $(source).find('#' + currentPhase.selectedId).clone(false).removeAttr('id');
//        console.log(currentPhaseData);
        var item = null;
        switch (currentPhase.selectedId) {
            case QUESTIONNAIRE:
                item = Tester.getQuestionnaire(container, currentPhaseData);
                break;
            case GUS_SINGLE_GESTURES:
                item = Tester.getGUS(container, currentPhaseData);
                break;
            case GUS_MULTIPLE_GESTURES:
                item = Tester.getQuestionnaire(container, currentPhaseData.gus);
                break;
            case SUS:
                item = Tester.getSUS(source, container, currentPhaseData);
                break;
            case GESTURE_TRAINING:
                item = Tester.getGestureTraining(source, container, currentPhaseData);
                break;
            case LETTER_OF_ACCEPTANCE:
                item = Tester.getLetterOfAcceptance(container, currentPhaseData);
                break;
            case SLIDESHOW:
                item = Tester.getSlideshow(source, container, currentPhaseData);
                break;
        }

        $('#viewTester #phase-content').empty().append(item);
        TweenMax.from($('#phase-content'), .2, {y: -60, opacity: 0});
        if ($(document).scrollTop() > 0) {
            $(document).scrollTop(0);
        }
    },
    getLetterOfAcceptance: function getLetterOfAcceptance(container, data) {
        $(container).find('.letter-text').text(data);
        $(container).find('#letter-agreed').on('click', function (event) {
            event.preventDefault();
            nextStep();
        });
        return container;
    },
    getQuestionnaire: function getQuestionnaire(container, data) {
        for (var i = 0; i < data.length; i++) {

//            console.log(data);
            var item = $('#item-container-inputs').find('#' + data[i].type).clone(false).removeAttr('id');
            $(item).find('.question').text(i + 1 + '. ' + data[i].question);
            $(container).find('.question-container').append(item);


            if (data[i].dimension !== DIMENSION_ANY) {
                $(item).find('#dimension').removeClass('hidden');
                $(item).find('#dimension').text(translation.dimensions[data[i].dimension]);
            }

            var parameters = data[i].parameters;
            var options = data[i].options;

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
            }
        }
        return container;
    },
    getGUS: function getGUS(container, data) {
        var gesture = getGestureById(data.gestureId);
        if (gesture) {
            singleGUSGesture = gesture;
            container.find('#title').text(gesture.title);
            renderGestureImages(container.find('.imageContainer'), gesture.images, gesture.previewImage, null);
        }

        container = Tester.getQuestionnaire(container, data.gus);
        return container;
    },
    getSUS: function getSUS(source, container, data) {
        for (var i = 0; i < data.length; i++) {
            var item = $(source).find('#susItem').clone(false).removeAttr('id');
            $(item).find('.question').text(i + 1 + '. ' + data[i].question);
            renderSusInput(item);
            $(container).find('.question-container').append(item);
        }
        return container;
    },
    getGestureTraining: function getGestureTraining(source, container, data) {

        // general data section
        $(container).find('.headline').text(data.title);
        $(container).find('.description').text(data.description);

        if (data.training.length === 0) {
            appendAlert($('#mainContent'), ALERT_NO_PHASE_DATA);
            return false;
        }

        // gestures section
        if (getLocalItem(PROJECT).surveyType === TYPE_SURVEY_UNMODERATED) {
            Tester.renderUnmoderatedTraining(source, container, data.training);
        } else {
            if (trainingTriggered) {
                Tester.renderModeratedTraining(source, container, data.training);
            } else {
                appendAlert($(container), ALERT_WAITING_FOR_TRAINING_GESTURE);
            }
        }

        return container;
    },
    renderModeratedTraining: function renderModeratedTraining(source, container, data) {
        var trainingData = data[currentGestureTrainingIndex];
        var item = $(source).find('#trainingItemModerated').clone().removeAttr('id');
        $(container).append(item);

        item.find('#title').text(translation.title + ": " + trainingData.gesture.title);
        item.find('#repeats').text(translation.repeats + ": " + trainingData.repeats);
        item.find('#trigger').text(translation.trigger + ": " + trainingData.trigger.title);

        if (trainingData.feedback) {
            item.find('#feedback').text(translation.feedback + ": " + trainingData.feedback.title);
        } else {
            item.find('#feedback').text(translation.feedback + ": " + translation.nones);
        }

        renderGestureImages(item.find('.imageContainer'), trainingData.gesture.images, trainingData.gesture.previewImage, null);
    },
    renderUnmoderatedTraining: function renderUnmoderatedTraining(source, container, data) {
        var trainingData = data[currentGestureTrainingIndex];
        var item = $(source).find('#trainingItemUnmoderated').clone().removeAttr('id');
        $(container).find('#trainingContainer').empty();
        $(container).find('#trainingContainer').append(item);
        item.find('#title').text(translation.title + ": " + trainingData.gesture.title);
        item.find('#repeats').text(translation.repeats + ": " + trainingData.repeats);
        item.find('#trigger').text(translation.trigger + ": " + trainingData.trigger.title);

        if (trainingData.feedback) {
            item.find('#feedback').text(translation.feedback + ": " + trainingData.feedback.title);
        } else {
            item.find('#feedback').text(translation.feedback + ": " + translation.nones);
        }

        renderGestureImages(item.find('.imageContainer'), trainingData.gesture.images, trainingData.gesture.previewImage, null);
        if (data.length === 1 || currentGestureTrainingIndex >= data.length - 1) {
            item.find('#training-done').removeClass('hidden');
        } else {
            item.find('#next-gesture').removeClass('hidden');
        }

        item.find('#next-gesture').on('click', function (event) {
            event.preventDefault();
            currentGestureTrainingIndex++;
            Tester.renderUnmoderatedTraining(source, container, data);
        });
        item.find('#training-done').on('click', function (event) {
            event.preventDefault();
            currentGestureTrainingIndex = 0;
            nextStep();
        });
    },
    getSlideshow: function getSlideshow(source, container, data) {
        // general data section
        $(container).find('.headline').text(data.title);
        $(container).find('.description').text(data.description);

        if (data.slideshow.length === 0) {
            appendAlert($('#mainContent'), ALERT_NO_PHASE_DATA);
            return false;
        }

        if (getLocalItem(PROJECT).surveyType === TYPE_SURVEY_UNMODERATED) {
            Tester.renderUnmoderatedSlideshow(source, container, data);
        } else {
            if (slideTriggered) {
                Tester.renderModeratedSlideshow(source, container, data);
            } else {
                appendAlert($(container), ALERT_WAITING_FORT_SLIDESHOW);
            }
        }
        return container;
    },
    renderModeratedSlideshow: function renderModeratedSlideshow(source, container, data) {
        var slideData = data.slideshow[currentSlideIndex];
        var item = $(source).find('#slideshowItemModerated').clone().removeAttr('id');
        $(container).find('#slideshowContainer').append(item);

        var progress = $(container).find('.progress');
        progress.removeClass('active');
        progress.removeClass('hidden');

        var timeline = new TimelineMax({paused: true, delay: 1, onComplete: onAnswerTimeExpired, onCompleteParams: [container]});
        timeline.add("start", 0)
                .to(progress.find('.progress-bar'), parseInt(data.answerTime), {width: '0%', autoRound: false, backgroundColor: "#d9534f", ease: Power0.easeNone}, "start")
                .to($(container).find('.gestureContainer .headline, .triggerContainer .headline'), parseInt(data.answerTime), {color: '#d9534f', ease: Power0.easeNone}, "start");

        if (data.slideshowFor === 'trigger') {
            $(item).find('.gestureContainer').removeClass('hidden');
            renderGestureImages(item.find('.imageContainer'), slideData.gesture.images, slideData.gesture.previewImage, function () {
                timeline.play();
            });
        } else {
            $(item).find('.triggerContainer').removeClass('hidden');
            $(item).find('.triggerContainer .trigger-title').text(slideData.trigger.title);
            timeline.play();
        }
    },
    renderUnmoderatedSlideshow: function renderUnmoderatedSlideshow(source, container, data, trainingIsActive) {
        var item = $(source).find('#slideshowItemUnmoderated').clone().removeAttr('id');
        $(container).find('#slideshowContainer').empty().append(item);
        if (currentSlideIndex === data.slideshow.length) {
            $(item).find('#startSlideshow').text(translation.next);
        }

        console.log(currentSlideIndex + ". " + data.slideshow.length);

        if (trainingIsActive) {
            var slideData = data.slideshow[currentSlideIndex];

            var progress = $(container).find('.progress');
            console.log(progress);
            progress.removeClass('active');
            progress.removeClass('hidden');

            var timeline = new TimelineMax({paused: true, delay: 1, onComplete: onUnmoderatedAnswerTimeExpired, onCompleteParams: [source, container, data]});
            timeline.add("start", 0)
                    .to(progress.find('.progress-bar'), parseInt(data.answerTime), {width: '0%', autoRound: false, backgroundColor: "#d9534f", ease: Power0.easeNone}, "start")
                    .to($(container).find('.gestureContainer .headline, .triggerContainer .headline'), parseInt(data.answerTime), {color: '#d9534f', ease: Power0.easeNone}, "start");

            if (data.slideshowFor === 'trigger') {
                $(item).find('.gestureContainer').removeClass('hidden');
                renderGestureImages(item.find('.imageContainer'), slideData.gesture.images, slideData.gesture.previewImage, function () {
                    timeline.play();
                });
            } else {
                $(item).find('.triggerContainer').removeClass('hidden');
                $(item).find('.triggerContainer .trigger-title').text(slideData.trigger.title);
                timeline.play();
            }
        } else {
            $(item).find('#startSlideshow').removeClass('hidden');
        }

        $(item).find('#startSlideshow').click(function (event) {
            event.preventDefault();
            if (currentSlideIndex >= data.slideshow.length) {
                currentSlideIndex = 0;
                nextStep();
            } else {
                Tester.renderUnmoderatedSlideshow(source, container, data, true);
            }
        });
    }
};

function onAnswerTimeExpired(container) {
    $(container).find('.gestureContainer .headline, .triggerContainer .headline').text(translation.timesUp);
    TweenMax.to(container.find('.imageContainer, .trigger-title'), .1, {autoAlpha: 0});
    TweenMax.to(container.find('#slideshowContainer, .progress'), .1, {delay: 2, autoAlpha: 0, onComplete: onHideSlideComplete, onCompleteParams: [container]});
}

function onHideSlideComplete(container) {
    container.find('#slideshowContainer').addClass('hidden');
    appendAlert($(container), ALERT_WAITING_FORT_SLIDESHOW);
}

function onUnmoderatedAnswerTimeExpired(source, container, data) {
    currentSlideIndex++;
    $(container).find('.gestureContainer .headline, .triggerContainer .headline').text(translation.timesUp);
    TweenMax.to(container.find('.imageContainer, .trigger-title'), .1, {autoAlpha: 0});
    TweenMax.to(container.find('#slideshowContainer, .progress'), .1, {delay: 2, autoAlpha: 0, onComplete: onHideUnmoderatedSlideComplete, onCompleteParams: [source, container, data]});
}

function onHideUnmoderatedSlideComplete(source, container, data) {
    var progress = container.find('.progress');
    progress.css({opacity: 1, visibility: 'visible'});
    progress.addClass('hidden');
    progress.find('.progress-bar').css({width: '100%', backgroundColor: "#5bb85c"});
    TweenMax.to(container.find('#slideshowContainer'), 0, {autoAlpha: 1});
    Tester.renderUnmoderatedSlideshow(source, container, data, false);
}