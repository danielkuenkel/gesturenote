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
        var currentPhaseData = getCurrentPhaseData();
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
                item = Tester.getQuestionnaire(container, getAssembledItems(currentPhaseData.gus));
                break;
            case SUS:
                item = Tester.getSUS(source, container, currentPhaseData);
                break;
            case GESTURE_TRAINING:
                item = Tester.getGestureTraining(source, container, currentPhaseData);
                Tester.appendRTCPreview(source, item.find('#column-left'));
                break;
            case LETTER_OF_ACCEPTANCE:
                item = Tester.getLetterOfAcceptance(container, currentPhaseData);
                break;
            case SLIDESHOW:
                item = Tester.getSlideshow(source, container, currentPhaseData);
                Tester.appendRTCPreview(source, item.find('#column-left'));
                break;
            case SCENARIO:
                item = Tester.getScenario(source, container, currentPhaseData);
                Tester.appendRTCPreview(source, item.find('#fixed-rtc-preview'));
                break;
            case IDENTIFICATION:
                item = Tester.getIdentification(source, container, currentPhaseData);
                Tester.appendRTCPreview(source, item.find('#column-left'));
                break;
        }

        $('#viewTester #phase-content').empty().append(item);
        TweenMax.from($('#phase-content'), .2, {y: -60, opacity: 0});
        if ($(document).scrollTop() > 0) {
            $(document).scrollTop(0);
        }
    },
    appendRTCPreview: function appendRTCPreview(source, target) {
        $(target).append($(source).find('#tester-web-rtc-placeholder').clone().removeAttr('id'));
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
            $(item).find('.question').text(data.length - i + '. ' + data[i].question);
            $(container).find('.question-container').prepend(item);

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

        container = Tester.getQuestionnaire(container, getAssembledItems(data.gus));
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
            appendHint(source, $('body'), trainingData, TYPE_SURVEY_MODERATED);
            triggeredFeedback = null;
        }

        renderGestureImages(item.find('.imageContainer'), gesture.images, gesture.previewImage, null);
    },
    renderUnmoderatedTraining: function renderUnmoderatedTraining(source, container, data) {
        var trainingData = data[currentGestureTrainingIndex];
        var gesture = getGestureById(trainingData.gestureId);
        var trigger = getTriggerById(trainingData.triggerId);
        var feedback = getFeedbackById(trainingData.feedbackId);
        var repeatsLeft = trainingData.repeats;
        var item = $(source).find('#trainingItemUnmoderated').clone().removeAttr('id');
        $(container).find('#trainingContainer').empty();
        $(container).find('#trainingContainer').append(item);
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
            renderGestureImages(item.find('.imageContainer'), gesture.images, gesture.previewImage, function () {
                item.find('#start-single-training').removeClass('disabled');
            });
        }

        // start state handling
        item.find('#start-training').on('click', function (event) {
            event.preventDefault();
            $(this).addClass('hidden');
            gestureTrainingStartTriggered = true;
            container.find('#general').addClass('hidden');
            item.find('#start-single-training, #training-data').removeClass('hidden');
            item.find('#start-single-training').addClass('disabled');

            renderGestureImages(item.find('.imageContainer'), gesture.images, gesture.previewImage, function () {
                item.find('#start-single-training').removeClass('disabled');
            });
        });

        // training handler
        item.find('#start-single-training, #repeat-training').on('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
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
        item.find('#next-gesture').on('click', function (event) {
            event.preventDefault();
            currentGestureTrainingIndex++;
            item.find('#training-data').removeClass('hidden');
            Tester.renderUnmoderatedTraining(source, container, data);
        });
        item.find('#training-done').on('click', function (event) {
            event.preventDefault();
            currentGestureTrainingIndex = 0;
            gestureTrainingStartTriggered = false;
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

        if (slideshowStartTriggered) {
            $(container).find('#general').remove();
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
//                .to($(container).find('.gestureContainer .headline, .triggerContainer .headline'), parseInt(data.answerTime), {color: '#d9534f', ease: Power0.easeNone}, "start");

        if (data.slideshowFor === 'trigger') {
            var gesture = getGestureById(slideData.gestureId);
            $(item).find('.gestureContainer').removeClass('hidden');
            renderGestureImages(item.find('.imageContainer'), gesture.images, gesture.previewImage, function () {
                timeline.play();
            });
        } else {
            var trigger = getTriggerById(slideData.triggerId);
            $(item).find('.triggerContainer').removeClass('hidden');
            $(item).find('.triggerContainer .trigger-title').text(trigger.title);
            timeline.play();
        }
    },
    renderUnmoderatedSlideshow: function renderUnmoderatedSlideshow(source, container, data, isActive) {
        var item = $(source).find('#slideshowItemUnmoderated').clone().removeAttr('id');
        $(container).find('#slideshowContainer').empty().append(item);

        if (currentSlideIndex === data.slideshow.length) {
            $(item).find('#startSlideshow').text(translation.next);
        }

        if (slideshowStartTriggered) {
            $(container).find('#general').remove();
        }

        if (isActive) {

            var slideData = data.slideshow[currentSlideIndex];

            var progress = $(container).find('.progress');
            progress.removeClass('active');
            progress.removeClass('hidden');

            var timeline = new TimelineMax({paused: true, delay: 1, onComplete: onUnmoderatedAnswerTimeExpired, onCompleteParams: [source, container, data]});
            timeline.add("start", 0)
                    .to(progress.find('.progress-bar'), parseInt(data.answerTime), {width: '0%', autoRound: false, backgroundColor: "#d9534f", ease: Power0.easeNone}, "start")
                    .to($(container).find('.gestureContainer .headline, .triggerContainer .headline'), parseInt(data.answerTime), {color: '#d9534f', ease: Power0.easeNone}, "start");

            if (data.slideshowFor === 'trigger') {
                var gesture = getGestureById(slideData.gestureId);
                $(item).find('.gestureContainer').removeClass('hidden');
                renderGestureImages(item.find('.imageContainer'), gesture.images, gesture.previewImage, function () {
                    timeline.play();
                });
            } else {
                var trigger = getTriggerById(slideData.triggerId);
                $(item).find('.triggerContainer').removeClass('hidden');
                $(item).find('.triggerContainer .trigger-title').text(trigger.title);
                timeline.play();
            }
        } else {
            $(item).find('#startSlideshow').removeClass('hidden');
        }

        $(item).find('#startSlideshow').click(function (event) {
            event.preventDefault();
            if (currentSlideIndex >= data.slideshow.length) {
                currentSlideIndex = 0;
                slideshowStartTriggered = false;
                nextStep();
            } else {
                slideshowStartTriggered = true;
                Tester.renderUnmoderatedSlideshow(source, container, data, true);
            }
        });
    },
    getIdentification: function getIdentification(source, container, data) {
        // general data section
        $(container).find('.headline').text(data.title);
        $(container).find('.description').text(data.description);

        if (data.identification.length === 0) {
            appendAlert($('#mainContent'), ALERT_NO_PHASE_DATA);
            return false;
        }

        if (identificationStartTriggered) {
            $(container).find('#general').remove();
        }

        if (getLocalItem(PROJECT).surveyType === TYPE_SURVEY_UNMODERATED) {
            Tester.renderUnmoderatedIdentification(source, container, data);
        } else {

            if (identificationTriggered) {
                Tester.renderModeratedIdentification(source, container, data);
            } else {
                appendAlert($(container), ALERT_WAITING_FOR_IDENTIFICATION);
            }
        }
        return container;
    },
    renderModeratedIdentification: function renderModeratedIdentification(source, container, data) {
        var item = $(source).find('#identificationItemModerated').clone().removeAttr('id');
        $(container).find('#identificationContainer').append(item);

        if (data.identificationFor === 'gestures') {
            $(item).find('#trigger-identification').remove();
            var trigger = getTriggerById(data.identification[currentIdentificationIndex]);
            item.find('#trigger #text').text(trigger.title);

        } else {
            $(item).find('#gesture-identification').remove();
            var gesture = getGestureById(data.identification[currentIdentificationIndex]);
            renderGestureImages($(item).find('.imageContainer'), gesture.images, gesture.previewImage, function () {

            });
        }
    },
    renderUnmoderatedIdentification: function renderUnmoderatedIdentification(source, container, data) {
        var item = $(source).find('#identificationItemUnmoderated').clone().removeAttr('id');
        $(container).find('#identificationContainer').empty().append(item);

        $(item).find('#btn-start-identification').click(function (event) {
            event.preventDefault();
            identificationStartTriggered = true;
            $(this).remove();
            $(item).find('#identification-content').removeClass('hidden');
        });

        if (identificationStartTriggered) {
            $(item).find('#btn-start-identification').remove();
            $(item).find('#identification-content').removeClass('hidden');
        }

        if (data.identificationFor === 'gestures') {
            $(item).find('#trigger-identification').remove();
            var trigger = getTriggerById(data.identification[currentIdentificationIndex]);
            item.find('#trigger #text').text(trigger.title);

        } else {
            $(item).find('#gesture-identification').remove();
            var gesture = getGestureById(data.identification[currentIdentificationIndex]);
            renderGestureImages($(item).find('.imageContainer'), gesture.images, gesture.previewImage, function () {

            });
        }

        if (data.identification.length === 1 || currentIdentificationIndex >= data.identification.length - 1) {
            $(item).find('#next-identification').remove();
            $(item).find('#done-identification').on('click', function (event) {
                event.preventDefault();
                currentIdentificationIndex = 0;
                identificationStartTriggered = false;
                nextStep();
            });
        } else if (currentIdentificationIndex < data.identification.length) {
            $(item).find('#done-identification').remove();
            $(item).find('#next-identification').on('click', function (event) {
                event.preventDefault();
                currentIdentificationIndex++;
                Tester.renderUnmoderatedIdentification(source, container, data);
            });
        }
    },
    getScenario: function getScenario(source, container, data) {
        if (getLocalItem(PROJECT).surveyType === TYPE_SURVEY_UNMODERATED) {
            renderUnmoderatedScenario(source, container, data);
        } else {
            renderModeratedScenario(source, container, data);
        }

        return container;
    }
};

function renderModeratedScenario(source, container, data) {
    var sceneItem;
    if (scenarioStartTriggered) {
        $(container).find('#fixed-rtc-preview').removeClass('hidden');
        if (currentTriggeredSceneId) {
            sceneItem = renderSceneItem(source, container, currentTriggeredSceneId);
        } else {
            sceneItem = renderSceneItem(source, container, data.scene);
        }
    } else {
        $(container).find('#fixed-rtc-preview').addClass('hidden');
    }

    // handle scenario start state
    if (scenarioStartTriggered) {
        sceneItem.removeClass('hidden');
        clearAlerts(container);
    } else {
        var panelContent = $(source).find('#scenario-panel-moderated').clone();
        container.find('#generalPanel').append(panelContent);
        container.find('#generalPanel').removeClass('hidden');
        appendAlert($(container), ALERT_WAITING_FOR_SCENARIO_START);
    }

    // handle triggered help
    if (triggeredHelp) {
        var helpModal = $('body').find('#help-modal');
        helpModal.find('#help-text').text(triggeredHelp.option);

        if (triggeredHelp.useGestureHelp === true && triggeredHelp.gestureId) {
            var gesture = getGestureById(triggeredHelp.gestureId);
            helpModal.find('#gesture-preview').removeClass('hidden');
            renderGestureImages(helpModal.find('.previewGesture'), gesture.images, gesture.previewImage, function () {
            });
        } else {
            helpModal.find('.imageContainer').addClass('hidden');
        }

        helpModal.modal('show');

        helpModal.on('hidden.bs.modal', function () {
            triggeredHelp = null;
            $(this).find('#gesture-preview #btn-stop-gesture').click();
        });
    }

    // handle triggered woz
    if (triggeredWoz && currentWOZScene.type !== SCENE_PIDOCO) {
        var hint = appendHint(source, $('body'), triggeredWoz, TYPE_SURVEY_MODERATED);

        var transitionScene = getSceneById(triggeredWoz.transitionId);
        currentTriggeredSceneId = triggeredWoz.transitionId;
        if (hint !== null) {
            $(hint).on('hint.hidden', function () {
                if (transitionScene) {
                    renderSceneItem(source, container, triggeredWoz.transitionId);
                }
                triggeredWoz = null;
            });
        } else {
            if (transitionScene) {
                renderSceneItem(source, container, triggeredWoz.transitionId);
            }
            triggeredWoz = null;
        }
    }
}

function renderUnmoderatedScenario(source, container, data) {
    var panelContent = $(source).find('#scenario-panel-unmoderated').clone();
    container.find('#generalPanel').empty().append(panelContent);
    panelContent.find('#more-text').text(translation.more);
    panelContent.find('#less-text').text(translation.less);
    panelContent.find('#task-header').text(translation.task + ":");
    panelContent.find('#task-text').text(data.description);

    container.find('#generalPanel').removeClass('hidden');
    container.find('#info-content').removeClass('hidden');
    container.find('#start-controls').removeClass('hidden');

    container.find('#btn-show-scenario-info').on('click', function (event) {
        event.preventDefault();
        showScenarioInfos(container);
        $(this).addClass('hidden');
    });
    container.find('#btn-hide-scenario-info').on('click', function (event) {
        event.preventDefault();
        hideScenarioInfos(container);
        $(this).addClass('hidden');
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

    container.find('#start-scene').click(function () {
        container.find('#start-controls').addClass('hidden');
        container.find('#normal-controls').removeClass('hidden');

        sceneItem = renderSceneItem(source, container, data.scene);
        sceneItem.removeClass('hidden');
        container.find('#btn-hide-scenario-info').click();
        scenarioStartTriggered = true;
        currentWOZScene = getSceneById(data.scene);
    });

    $(container).find('#btn-refresh-scene').click(function (event) {
        event.preventDefault();
        renderUnmoderatedScenario(source, container, data);
    });

    $(panelContent).find('#btn-perform-gesture').click(function (event) {
        event.preventDefault();
        $(this).addClass('hidden');
        $(panelContent).find('#btn-stop-perform-gesture').removeClass('hidden');
    });

    $(panelContent).find('#btn-stop-perform-gesture').click(function (event) {
        event.preventDefault();
        $(this).addClass('hidden');
        $(panelContent).find('#btn-perform-gesture').removeClass('hidden');
        loadHTMLintoModal('preview-modal', 'preview-unmoderated-scenes.html', 'modal-lg');
    });
    
    $(panelContent).find('#btn-getting-help').click(function(event) {
        event.preventDefault();
        loadHTMLintoModal('preview-modal', 'preview-help.html', 'modal-md');
    });
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
        } else {
            $(container).find('#btn-perform-gesture').addClass('hidden');
        }

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

        $(window).resize(function () {
            var height;
            if (getLocalItem(PROJECT).surveyType === TYPE_SURVEY_UNMODERATED) {
                sceneItem.css({marginTop: '54px'});
                height = $(window).height() - 145 - 54;
            } else {
                height = $(window).height() - 145;
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
    $(target).find('#info-content').removeClass('hidden');
}

function hideScenarioInfos(target) {
    $(target).find('#btn-show-scenario-info').removeClass('hidden');
    $(target).find('#info-content').addClass('hidden');
}