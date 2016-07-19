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
//        console.log('clone: ' + currentPhase.selectedId + ', from: ' + source.attr('id'));
        var container = $(source).find('#' + currentPhase.selectedId).clone(false).removeAttr('id');
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
            case SCENARIO:
                item = Tester.getScenario(container, currentPhaseData);
                break;
        }

        $('#viewTester #phase-content').empty().append(item);
        TweenMax.from($('#phase-content'), .2, {y: -60, opacity: 0});
        if ($(document).scrollTop() > 0) {
            $(document).scrollTop(0);
        }
    },
    renderNoDataView: function renderNoDataView() {
        var alert = $(getSourceContainer(currentView)).find('#no-phase-data').clone().removeAttr('id');
        $('#viewTester #phase-content').empty().append(alert);
        appendAlert(alert, ALERT_NO_PHASE_DATA);
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

//        item.find('#title').text(translation.title + ": " + trainingData.gesture.title);
//        item.find('#repeats').text(translation.repeats + ": " + trainingData.repeats);
//        item.find('#trigger').text(translation.trigger + ": " + trainingData.trigger.title);
//
//        if (trainingData.feedback) {
//            item.find('#feedback').text(translation.feedback + ": " + trainingData.feedback.title);
//        } else {
//            item.find('#feedback').text(translation.feedback + ": " + translation.nones);
//        }

        if (triggeredFeedback) {
            appendHint(source, $('body'), trainingData, TYPE_SURVEY_MODERATED);
            triggeredFeedback = null;
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
        var repeatsLeft = trainingData.repeats;

        renderGestureImages(item.find('.imageContainer'), trainingData.gesture.images, trainingData.gesture.previewImage, null);

//        if (trainingData.feedback) {
//            item.find('#feedback').text(translation.feedback + ": " + trainingData.feedback.title);
//        } else {
//            item.find('#feedback').text(translation.feedback + ": " + translation.nones);
//        }
        // training handler
        item.find('#start-training, #repeat-training').on('click', function (event) {
            event.preventDefault();
//            currentGestureTrainingIndex++;
//            Tester.renderUnmoderatedTraining(source, container, data);
            $(item).find('#training-controls').addClass('hidden');
            $(item).find('.progress-training').removeClass('hidden');
            TweenMax.to(item.find('.progress-bar'), trainingData.recognitionTime, {width: '0%', autoRound: false, ease: Power0.easeNone, onComplete: onTrainingTimesUp});
        });

        function onTrainingTimesUp() {
            repeatsLeft--;

            appendHint(source, $('body'), trainingData, TYPE_SURVEY_UNMODERATED);
            $(item).find('#training-controls').removeClass('hidden');
            $(item).find('.progress-training').addClass('hidden');
            item.find('.progress-bar').css({width: "100%"});

            if (repeatsLeft === 0) {
                item.find('#start-training, #repeat-training').addClass('hidden');
                if (data.length === 1 || currentGestureTrainingIndex >= data.length - 1) {
                    item.find('#training-done').removeClass('hidden');
                } else {
                    item.find('#next-gesture').removeClass('hidden');
                }
            } else {
                item.find('#start-training').addClass('hidden');
                item.find('#repeat-training').removeClass('hidden');
            }
        }

        // done & next step
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
                appendAlert($(container), ALERT_WAITING_FOR_SLIDESHOW);
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

        if (trainingIsActive) {
            var slideData = data.slideshow[currentSlideIndex];

            var progress = $(container).find('.progress');
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
    },
    getScenario: function getScenario(container, data) {
//        console.log(data);
        var scene = getPrototypeById(data.scene);
//        console.log(scene);
//        console.log(container);
        var sceneItem = $('#item-container-tester').find('#' + scene.type).clone().removeAttr('id');
        container.find('#scene-container').append(sceneItem);
        container.find('#more-text').text(translation.more);
        container.find('#less-text').text(translation.less);
        container.find('#task-header').text(translation.task + ":");
        container.find('#task-text').text(data.description);
        container.find('#generalPanel #btn-show-scenario-info').on('click', function (event) {
            event.preventDefault();
            showScenarioInfos(container.find('#generalPanel'));
            $(this).addClass('hidden');
        });
        container.find('#generalPanel #btn-hide-scenario-info').on('click', function (event) {
            event.preventDefault();
            hideScenarioInfos(container.find('#generalPanel'));
            $(this).addClass('hidden');
        });

        switch (scene.type) {
            case PROTOTYPE_WEB:
                sceneItem.attr('src', scene.options[0]);
                break;
            case PROTOTYPE_IMAGE:
                sceneItem[0].onload = function () {
                    var image = sceneItem[0];
                    var colorThief = new ColorThief();
                    var dominantColor = colorThief.getColor(image);
                    container.find('#scene-container').css("backgroundColor", "rgb(" + dominantColor[0] + "," + dominantColor[1] + "," + dominantColor[2] + ")");
                };
                sceneItem[0].src = scene.data;
                break;
            case PROTOTYPE_PIDOCO:
                break;
            case PROTOTYPE_VIDEO_EMBED:
                break;
        }

        $(window).resize(function () {
            var height = $(window).height() - 145 - 54;
            sceneItem.height(height);
            $(container).find('#woz-scenario-text-container').height(height);
        }).resize();

        if (getLocalItem(PROJECT).surveyType === TYPE_SURVEY_UNMODERATED) {
            container.find('#generalPanelContent').removeClass('hidden');
            container.find('#generalPanel #btn-show-scenario-info').click();
            container.find('#start-controls').removeClass('hidden');
            sceneItem.addClass('hidden');

            container.find('#start-scene').click(function (event) {
                container.find('#start-controls').addClass('hidden');
                container.find('#normal-controls').removeClass('hidden');
                sceneItem.removeClass('hidden');
                container.find('#generalPanel #btn-hide-scenario-info').click();
            });
        } else {
            container.find('#getting-help').remove();
            container.find('#normal-controls').removeClass('hidden');

            // handle scenario start state
            if (scenarioStartTriggered) {
                sceneItem.removeClass('hidden');
                container.find('.alert-space').remove();
            } else {
                sceneItem.addClass('hidden');
                appendAlert($(container), ALERT_WAITING_FOR_SCENARIO_START);
                container.find('#generalPanel #btn-show-scenario-info').click();
                container.find('#generalPanelContent').removeClass('hidden');
            }

            // handle triggered help
            if (triggeredHelp) {
                var helpModal = $('body').find('#help-modal');
//                console.log(triggeredHelp);
                helpModal.find('#help-text').text(triggeredHelp.option);

                if (triggeredHelp.useGestureHelp === true && triggeredHelp.gestureId) {
                    var gesture = getGestureById(triggeredHelp.gestureId);
                    helpModal.find('.imageContainer').removeClass('hidden');
                    renderGestureImages(helpModal.find('.imageContainer'), gesture.images, gesture.previewImage);
                } else {
                    helpModal.find('.imageContainer').addClass('hidden');
                }

                helpModal.modal('show');

                helpModal.on('hidden.bs.modal', function () {
                    triggeredHelp = null;
                });
            }

            // handle triggered woz
            if (triggeredWoz && scene.type !== PROTOTYPE_PIDOCO) {
//                console.log(triggeredWoz);
                $(container).find('#woz-scenario-text-container').removeClass('hidden');
                $(container).find('#text-start').text(translation.gesture + " ");
                $(container).find('#gesture-title').text(triggeredWoz.gesture.title + " ");
                $(container).find('#gesture-for').text(translation.for + " ");
                $(container).find('#trigger-title').text(triggeredWoz.trigger.title + " ");
                $(container).find('#feedback-title').text(triggeredWoz.feedback.title);
                var hideTween = TweenMax.to($(container).find('#woz-scenario-text-container'), .3, {autoAlpha: 0, paused: true});
                triggeredWoz = null;

                $(container).find('#btn-close-woz-hint').click(function (event) {
                    event.preventDefault();
                    hideTween.play();
                });
            }
        }

        return container;
    }
};

function onAnswerTimeExpired(container) {
    $(container).find('.gestureContainer .headline, .triggerContainer .headline').text(translation.timesUp);
    TweenMax.to(container.find('.imageContainer, .trigger-title'), .1, {autoAlpha: 0});
    TweenMax.to(container.find('#slideshowContainer, .progress'), .1, {delay: 2, autoAlpha: 0, onComplete: onHideSlideComplete, onCompleteParams: [container]});
}

function onHideSlideComplete(container) {
    container.find('#slideshowContainer').addClass('hidden');
    appendAlert($(container), ALERT_WAITING_FOR_SLIDESHOW);
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


function showScenarioInfos(target) {
    $(target).find('#btn-hide-scenario-info').removeClass('hidden');
    $(target).find('#generalPanelContent').removeClass('hidden');
}

function hideScenarioInfos(target) {
    $(target).find('#btn-show-scenario-info').removeClass('hidden');
    $(target).find('#generalPanelContent').addClass('hidden');
}