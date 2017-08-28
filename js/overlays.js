/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function initOverlayContent(format, id) {
    var formatClone = $('#overlays-item-container').find('#' + format).clone().removeAttr('id');
    $('#overlay-content-placeholder').empty().append(formatClone);
    console.log(format, id, formatClone);
    $(window).unbind('scroll resize');
    initOverlayContentFunctionalities(format, id, formatClone);
}

function resetOverlayContent(target) {
    $(target).empty();
    $(window).unbind('scroll resize');
}

function initOverlayContentFunctionalities(format, id, formatClone) {
    switch (format) {
        case LETTER_OF_ACCEPTANCE:
            initLetterOfAcceptance(id, formatClone);
            break;
        case THANKS:
            initThanksOverlay(id, formatClone);
            break;
        case QUESTIONNAIRE:
            initQuestionnaireOverlay(id, formatClone);
            break;
        case GUS_SINGLE_GESTURES:
            initGUSSingleGesturesOverlay(id, formatClone);
            break;
        case GUS_MULTIPLE_GESTURES:
            initGUSMultipleGesturesOverlay(id, formatClone);
            break;
        case SUS:
            initSUSOvlerlay(id, formatClone);
            break;
        case GESTURE_TRAINING:
            initGestureTrainingOverlay(id, formatClone);
            break;
        case SCENARIO:
            initScenarioOverlay(id, formatClone);
            break;
        case SLIDESHOW_GESTURES:
            initGestureSlideshowOverlay(id, formatClone);
            break;
        case SLIDESHOW_TRIGGER:
            initTriggerSlideshowOverlay(id, formatClone);
            break;
        case PHYSICAL_STRESS_TEST:
            initPhysicalStressTestOverlay(id, formatClone);
            break;
        case IDENTIFICATION:
            initElicitationOverlay(id, formatClone)
            break;
    }
}


/*
 * initialize questionnaire format overlays
 */

function initLetterOfAcceptance(id, formatClone) {
    var data = getLocalItem(id + '.data');
    if (data !== null) {
        $(formatClone).find('#declaration').val(data);
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        setLocalItem(id + ".data", $(formatClone).find('#declaration').val());
    });
}

function initThanksOverlay(id, formatClone) {
    var data = getLocalItem(id + '.data');
    if (data !== null) {
        $(formatClone).find('#declaration').val(data);
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        setLocalItem(id + ".data", $(formatClone).find('#declaration').val());
    });
}

function initQuestionnaireOverlay(id, formatClone) {
//    $(document).ready(function () {
//    closeClicked = false;
    $('[data-toggle="popover"]').popover({container: 'body', delay: {"show": 300, "hide": 0}});
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    initQuestionnaireButtonGroup(formatClone, $(formatClone).find('#add-question-button-group'), $(formatClone).find('#list-container'), $(formatClone), true, true, ALERT_NO_DATA_QUESTIONNAIRE);

    var data = getLocalItem(id + '.data');
    if (data !== null && data.length > 0) {
        renderData(data);
    } else {
        appendAlert($(formatClone), ALERT_NO_DATA_QUESTIONNAIRE);
    }



    function renderData(data) {
        var listContainer = $(formatClone).find('#list-container');
        for (var i = 0; i < data.length; i++) {
            renderFormatItem(listContainer, data[i]);
            updateBadges(listContainer, data[i].format);
        }
        checkCurrentListState(listContainer);
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(formatClone).find('#btn-save-phase-step-title').click();

        var itemList = $(formatClone).find('#list-container').children();
        var questionnaire = new Array();
        for (var i = 0; i < itemList.length; i++) {
            questionnaire.push(getFormatData(itemList[i]));
        }
        setLocalItem(id + '.data', questionnaire);
    });

    $(formatClone).find('.add-button-group').unbind('change').bind('change', function (event) {
        var itemType = $(event.target).attr('id');
        var clone = $('#form-item-container').find('#' + itemType).clone();
        clone.attr('name', itemType);
        initJustificationFormElements(clone);
        tweenAndAppend(clone, $(event.target), $(formatClone), $(formatClone).find('#list-container'), itemType);
    });

    $(formatClone).find('#list-container').unbind('listItemAdded').bind('listItemAdded', function (event) {
        event.preventDefault();
        var addedElement = $(event.target).children().last();
        initializeItemType(addedElement);
        clearAlerts($(formatClone));
        var newScrollTop = Math.max(0, $(formatClone).height() - $(window).height() + 190); // 190 due to padding-top 110px + padding-bottom 80px
        $('body').animate({
            scrollTop: newScrollTop
        }, 200);
    });

    $(formatClone).find('#list-container').unbind('change').bind('change', function (event) {
        if ($(this).children().length > 0) {
            clearAlerts($(formatClone));
        } else {
            appendAlert($(formatClone), ALERT_NO_DATA_QUESTIONNAIRE);
        }
    });

}

function initGUSSingleGesturesOverlay(id, formatClone) {

    renderAssembledGestures($(formatClone).find('#forGesture'));
    renderAssembledTriggers($(formatClone).find('#gesture-trigger'));
    renderAssembledFeedback($(formatClone).find('#gesture-feedback'));
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    renderDimensions($(formatClone).find('#dimension-controls'), translation.singleGUS, $(formatClone).find('#list-container'));
    initQuestionnaireDimensionControl(formatClone, $(formatClone).find('#dimension-controls'), $(formatClone).find('#list-container'), $(formatClone), true, true, ALERT_NO_DATA_GUS);

    var data = getLocalItem(id + '.data');
    if (data !== null) {
        renderData(data);
    }

    function renderData(data) {
        if (data.gestureId) {
            if (isGestureAssembled(data.gestureId)) {
                $(formatClone).find('#forGesture').find('#' + data.gestureId).click();
            } else {
                appendAlert($(formatClone).find('#general'), ALERT_ASSEMBLED_GESTURE_REMOVED);
            }
        }

        if (data.triggerId) {
            var trigger = getTriggerById(data.triggerId);
            if (trigger === null) {
                appendAlert($(formatClone).find('#general'), ALERT_ASSEMBLED_TRIGGER_REMOVED);
            } else {
                $(formatClone).find('#gesture-trigger').find('#' + data.triggerId).click();
            }
        }
        if (data.feedbackId) {
            var feedback = getFeedbackById(data.feedbackId);
            if (feedback === null) {
                appendAlert($(formatClone).find('#general'), ALERT_ASSEMBLED_FEEDBACK_REMOVED);
            } else {
                $(formatClone).find('#gesture-feedback').find('#' + data.feedbackId).click();
            }
        }


        if (data !== null && data.gus && data.gus.length > 0) {
            var listContainer = $(formatClone).find('#list-container');
            for (var i = 0; i < data.gus.length; i++) {
                renderFormatItem(listContainer, data.gus[i]);
                updateBadges(listContainer, data.gus[i].format);
            }
            checkDimensionItems($(formatClone).find('#dimension-controls .dimension-container'));
            checkCurrentListState(listContainer);
        } else {
            appendAlert($(formatClone), ALERT_NO_DATA_GUS);
        }
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        $(formatClone).find('#btn-save-phase-step-title').click();

        var itemList = $(formatClone).find('#list-container').children();
        var questionnaire = new Array();

        for (var i = 0; i < itemList.length; i++) {
            questionnaire.push(getFormatData(itemList[i]));
        }

        var gestureId = null;
        var triggerId = null;
        var feedbackId = null;

        if ($(formatClone).find('#forGesture .chosen').attr('id') !== 'unselected') {
            gestureId = $(formatClone).find('#forGesture .chosen').attr('id');
        }

        if ($(formatClone).find('#gesture-trigger .chosen').attr('id') !== 'unselected') {
            triggerId = $(formatClone).find('#gesture-trigger .chosen').attr('id');
        }

        if ($(formatClone).find('#gesture-feedback .chosen').attr('id') !== 'unselected') {
            feedbackId = $(formatClone).find('#gesture-feedback .chosen').attr('id');
        }

        setLocalItem(id + '.data', {gestureId: gestureId, triggerId: triggerId, feedbackId: feedbackId, gus: questionnaire});
    });

//    $(formatClone).find('#dimension-controls').unbind('listItemAdded').bind('listItemAdded', function (event) {
//        event.preventDefault();
//        clearAlerts($(formatClone));
//        var newScrollTop = Math.max(0, $(formatClone).height() - $(window).height() + 190); // 190 due to padding-top 110px + padding-bottom 80px
//        $('body').animate({
//            scrollTop: newScrollTop
//        }, 200);
//    });
//
//    $(formatClone).find('#list-container').unbind('change').bind('change', function (event) {
//        if ($(this).children().length > 0) {
//            clearAlerts($(formatClone));
//        } else {
//            appendAlert($(formatClone), ALERT_NO_DATA_GUS);
//        }
//    });
}

function initGUSMultipleGesturesOverlay(id, formatClone) {
    renderAssembledGestures($(formatClone).find('#forGesture'));
    renderAssembledTriggers($(formatClone).find('#gesture-trigger'));
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    renderDimensions($(formatClone).find('#dimension-controls'), translation.multipleGUS, $(formatClone).find('#list-container'));
    initQuestionnaireDimensionControl(formatClone, $(formatClone).find('#dimension-controls'), $(formatClone).find('#list-container'), $(formatClone), true, true, ALERT_NO_DATA_GUS_QUESTIONNAIRE);

    var data = getLocalItem(id + '.data');
    if (data !== null && data.gus && data.gus.length > 0) {
        renderData(data);
    } else {
        appendAlert($(formatClone), ALERT_NO_DATA_GUS_QUESTIONNAIRE);
    }

    function renderData(data) {
        var listContainer = $(formatClone).find('#list-container');
        for (var i = 0; i < data.gus.length; i++) {
            renderFormatItem(listContainer, data.gus[i]);
            updateBadges(listContainer, data.gus[i].format);
        }
        checkDimensionItems($(formatClone).find('#dimension-controls .dimension-container'));
        checkCurrentListState(listContainer);
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        $(formatClone).find('#btn-save-phase-step-title').click();

        var itemList = $(formatClone).find('#list-container').children();
        var questionnaire = new Array();
        for (var i = 0; i < itemList.length; i++) {
            questionnaire.push(getFormatData(itemList[i]));
        }

        setLocalItem(id + '.data', {gus: questionnaire});
    });

//    $(formatClone).find('#dimension-controls').unbind('listItemAdded').bind('listItemAdded', function (event) {
//        event.preventDefault();
//        clearAlerts($(formatClone));
//        var newScrollTop = Math.max(0, $(formatClone).height() - $(window).height() + 190); // 190 due to padding-top 110px + padding-bottom 80px
//        $('body').animate({
//            scrollTop: newScrollTop
//        }, 200);
//    });
//
//    $(formatClone).find('#list-container').unbind('change').bind('change', function (event) {
//        if ($(this).children().length > 0) {
//            clearAlerts($(formatClone));
//        } else {
//            appendAlert($(formatClone), ALERT_NO_DATA_GUS_QUESTIONNAIRE);
//        }
//    });
}


function initSUSOvlerlay(id, formatClone) {
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    var originData = getLocalItem(STUDY_ORIGIN_SUS);
    var customData = getLocalItem(id + '.data');

    if (customData !== null) {
        renderData(customData);
    } else if (originData !== null) {
        renderData(originData);
    } else {
        alert("No predefined data there");
    }

    function renderData(data) {
        var listContainer = $(formatClone).find('#list-container');
        for (var i = 0; i < data.length; i++) {
            renderFormatItem(listContainer, data[i]);
            updateBadges(listContainer, data[i].format);
        }
        checkCurrentListState(listContainer);
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        $(formatClone).find('#btn-save-phase-step-title').click();

        var itemList = $(formatClone).find('#list-container').children();
        var questionnaire = new Array();
        for (var i = 0; i < itemList.length; i++) {
            questionnaire.push(getFormatData(itemList[i]));
        }

        setLocalItem(id + '.data', questionnaire);
    });
}





/*
 * init gesture specific format overlays
 */

function initGestureTrainingOverlay(id, formatClone) {
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    renderDimensions($(formatClone).find('#dimension-controls'), translation.observationsGestureTraining, $(formatClone).find('#observations #list-container'));
    initQuestionnaireButtonGroup(formatClone, $(formatClone).find('#add-observation-button-group'), $(formatClone).find('#observations #list-container'), $(formatClone).find('#observations'), true, true, ALERT_NO_DATA_QUESTIONNAIRE);
    initQuestionnaireDimensionControl(formatClone, $(formatClone).find('#dimension-controls'), $(formatClone).find('#list-container'), $(formatClone).find('#observations'));
    initToggleSwitch(formatClone, $(formatClone).find('#useObservationsSwitch'), $(formatClone).find('#observations'));

    if (assembledGestures()) {
        renderAssembledGestures();
    } else {
        appendAlert($(formatClone).find('#training'), ALERT_NO_GESTURES_ASSEMBLED);
        $(formatClone).find('#training .btn-add-gestureTrainingOption').addClass('hidden');
    }

    var trigger = getLocalItem(ASSEMBLED_TRIGGER);
    if (trigger && trigger.length > 0) {
        renderAssembledTriggers();
    } else {
        appendAlert($(formatClone).find('#training'), ALERT_NO_TRIGGER_ASSEMBLED);
        $(formatClone).find('#training .btn-add-gestureTrainingOption').addClass('hidden');
    }

    var feedback = getLocalItem(ASSEMBLED_FEEDBACK);
    if (feedback && feedback.length > 0) {
        renderAssembledFeedback();
    } else {
        appendAlert($(formatClone).find('#training'), ALERT_NO_FEEDBACK_ASSEMBLED);
        $(formatClone).find('#training .btn-add-gestureTrainingOption').addClass('hidden');
    }


    var data = getLocalItem(id + '.data');
    if (data) {
        renderData(data);
    } else {
        appendAlert($(formatClone).find('#training'), ALERT_NO_PHASE_DATA);
        appendAlert($(formatClone).find('#observations'), ALERT_NO_DATA_QUESTIONNAIRE);
    }

    initDynamicAffixScrolling(formatClone);

    function renderData(data)
    {
        var trainingItems = data.training;

        $(formatClone).find('#trainingTitle').val(data.title);
        $(formatClone).find('#trainingDescription').val(data.description);

        var container;
        if (trainingItems !== undefined && trainingItems.length > 0) {

            container = $(formatClone).find('#trainingContainer .option-container');

            for (var i = 0; i < trainingItems.length; i++) {
                var clone = $('#gestureTrainingItem').clone().removeClass('hidden');
                $(clone).removeAttr('id');
                container.append(clone);

                var gesture = getGestureById(trainingItems[i].gestureId);
                if (gesture && isGestureAssembled(gesture.id))
                {
                    $(clone).find('.gestureSelect #' + gesture.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                }

                var trigger = getTriggerById(trainingItems[i].triggerId);
                if (trigger) {
                    if (!getTriggerById(trigger.id)) {
                        appendAlert(clone, ALERT_ASSEMBLED_TRIGGER_REMOVED);
                    } else {
                        $(clone).find('.triggerSelect #' + trigger.id).click();
                    }
                }

                if (trainingItems[i].feedbackId === 'none') {
                    $(clone).find('.feedbackSelect #none').click();
                } else {
                    var feedback = getFeedbackById(trainingItems[i].feedbackId);
                    if (feedback) {
                        $(clone).find('.feedbackSelect #' + feedback.id).click();
                    } else {
                        appendAlert(clone, ALERT_ASSEMBLED_FEEDBACK_REMOVED);
                    }
                }

                var repeats = trainingItems[i].repeats;
                $(clone).find('#repeats-stepper .stepper-text').val(parseInt(repeats));
                if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
                    $(clone).find('#recognition-stepper').removeClass('hidden');
                    var recognitionTime = trainingItems[i].recognitionTime;
                    $(clone).find('#recognition-stepper').val(parseInt(recognitionTime));
                }
            }
            checkCurrentListState(container);
        } else {
            appendAlert($(formatClone).find('#training'), ALERT_NO_PHASE_DATA);
        }

        renderObservations(formatClone, data.observations);
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        $(formatClone).find('#btn-save-phase-step-title').click();

        var traningItems = $(formatClone).find('#trainingContainer .option-container').children();

        var training = new Object();
        training.title = $(formatClone).find('#trainingTitle').val();
        training.description = $(formatClone).find('#trainingDescription').val();

        if (traningItems) {
            var set = new Array();
            for (var i = 0; i < traningItems.length; i++) {
                var item = traningItems[i];
                var gestureId = $(item).find('.gestureSelect .chosen').attr('id');
                var gesture = getGestureById(gestureId);
                var triggerId = $(item).find('.triggerSelect .chosen').attr('id');
                var trigger = getTriggerById(triggerId);
                var feedbackId = $(item).find('.feedbackSelect .chosen').attr('id');
                var feedback;
                if (feedbackId === 'unselected' || feedbackId === 'none') {
                    feedback = feedbackId = 'none';
                } else {
                    feedback = getFeedbackById(feedbackId);
                }
                var repeats = $(item).find('#repeats-stepper .stepper-text').val();
                var recognitionTime = $(item).find('#recognition-stepper .stepper-text').val();

                if (gesture && trigger && feedback) {
                    set.push({gestureId: gestureId, triggerId: triggerId, feedbackId: feedbackId, repeats: repeats, recognitionTime: recognitionTime});//new TrainingItem(gestureId, triggerId, feedbackId, repeats, recognitionTime));
                }
            }
            training.training = set;
        }

        saveObservations($(formatClone), $(formatClone).find('#observations #list-container').children(), training);
        setLocalItem(id + ".data", training);
    });

    $(formatClone).find('.btn-add-gestureTrainingOption').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (event.handled !== true)
        {
            event.handled = true;
            clearAlerts($(formatClone).find('#training'));
            var item = $('#form-item-container').find('#gestureTrainingItem').clone().removeAttr('id');
            tweenAndAppend(item, $(this), $(formatClone), $(formatClone).find('#training .option-container'), null, true);
        }
    });

    $(formatClone).find('#training .option-container').unbind('change').bind('change', function (event) {
        if ($(this).children().length > 0) {
            clearAlerts($(formatClone).find('#training'));
        } else {
            appendAlert($(formatClone).find('#training'), ALERT_NO_PHASE_DATA);
        }
        resetDynamicAffixScrolling(formatClone);
    });

    initQuestionnaireListItemAdded($(formatClone).find('#training .option-container'), $(formatClone).find('#training'));


//    $(formatClone).find('#add-observation-button-group').unbind('change').bind('change', function (event) {
//        var itemType = $(event.target).attr('id');
//        var clone = $('#form-item-container').find('#' + itemType).clone();
//        clone.attr('name', itemType);
//        initJustificationFormElements(clone);
//        tweenAndAppend(clone, $(event.target), $(formatClone), $(formatClone).find('#observations #list-container'), itemType);
//    });
//
//    $(formatClone).find('#observations #list-container').unbind('listItemAdded').bind('listItemAdded', function (event) {
//        event.preventDefault();
//        var addedElement = $(event.target).children().last();
//        initializeItemType(addedElement);
//        clearAlerts($(formatClone).find('#observations'));
//        var newScrollTop = Math.max(0, $(addedElement).offset().top + $(addedElement).height() - $(window).height() + 190); // 190 due to padding-top 110px + padding-bottom 80px
//        $('body').animate({
//            scrollTop: newScrollTop
//        }, 200);
//    });
//
//    $(formatClone).find('#observations #dimension-controls').unbind('listItemAdded').bind('listItemAdded', function (event) {
//        event.preventDefault();
//        var addedElement = $(formatClone).find('#observations #list-container').children().last();
//        clearAlerts($(formatClone).find('#observations #list-container'));
//        var newScrollTop = Math.max(0, $(addedElement).offset().top + $(addedElement).height() - $(window).height() + 190); // 190 due to padding-top 110px + padding-bottom 80px
//        $('body').animate({
//            scrollTop: newScrollTop
//        }, 200);
//    });
//
//    $(formatClone).find('#observations #list-container').unbind('change').bind('change', function (event) {
//        resetDynamicAffixScrolling(formatClone);
//
//        if ($(this).children().length > 0) {
//            clearAlerts($(formatClone).find('#observations'));
//        } else {
//            appendAlert($(formatClone).find('#observations'), ALERT_NO_DATA_QUESTIONNAIRE);
//        }
//    });
}

function initScenarioOverlay(id, formatClone) {
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    renderDimensions($(formatClone).find('#dimension-controls'), translation.observationsScenario, $(formatClone).find('#observations #list-container'));
    initQuestionnaireButtonGroup(formatClone, $(formatClone).find('#add-observation-button-group'), $(formatClone).find('#observations #list-container'), $(formatClone).find('#observations'), true, true, ALERT_NO_DATA_QUESTIONNAIRE);
    initQuestionnaireDimensionControl(formatClone, $(formatClone).find('#dimension-controls'), $(formatClone).find('#list-container'), $(formatClone).find('#observations'));
    initToggleSwitch(formatClone, $(formatClone).find('#useObservationsSwitch'), $(formatClone).find('#observations'));
    initToggleSwitch(formatClone, $(formatClone).find('#useWOZSwitch'), $(formatClone).find('#wozExperiment'));
    initToggleSwitch(formatClone, $(formatClone).find('#useHelpSwitch'), $(formatClone).find('#help'));

    var scenes = getLocalItem(ASSEMBLED_SCENES);
    renderAssembledScenes($(formatClone).find('#start-scene-select'));
    renderAssembledScenes();
    if (scenes === null) {
        appendAlert($(formatClone).find('#wozExperiment'), ALERT_NO_SCENES_ASSEMBLED);
        $(formatClone).find('#wozExperiment .btn-add-woz-experimentOption').addClass('hidden');
        $(formatClone).find$('#help .btn-add-helpOption').addClass('hidden');
    }

    renderAssembledGestures(null, [{id: 'wrongGesture', title: translation.wrongGesture}]);
    if (!assembledGestures()) {
        appendAlert($(formatClone).find('#wozExperiment'), ALERT_NO_GESTURES_ASSEMBLED);
        $(formatClone).find('#wozExperiment .btn-add-woz-experimentOption').addClass('hidden');
    }

    var trigger = getLocalItem(ASSEMBLED_TRIGGER);
    renderAssembledTriggers();
    if (!trigger) {
        appendAlert($(formatClone).find('#wozExperiment'), ALERT_NO_TRIGGER_ASSEMBLED);
        $(formatClone).find('#wozExperiment .btn-add-woz-experimentOption').addClass('hidden');
    }

    var feedback = getLocalItem(ASSEMBLED_FEEDBACK);
    renderAssembledFeedback();
    if (!feedback) {
        appendAlert($(formatClone).find('#wozExperiment'), ALERT_NO_FEEDBACK_ASSEMBLED);
        $(formatClone).find('#wozExperiment .btn-add-woz-experimentOption').addClass('hidden');
    }


//    $(formatClone).find('#useWOZSwitch').unbind('change').bind('change', function (event) {
//        if ($(event.target).attr('id') === 'yes') {
//            $(formatClone).find('#wozExperiment').removeClass('hidden');
//        } else {
//            $(formatClone).find('#wozExperiment').addClass('hidden');
//        }
//        resetDynamicAffixScrolling(formatClone);
//    });
//
//    $(formatClone).find('#useHelpSwitch').unbind('change').bind('change', function (event) {
//        if ($(event.target).attr('id') === 'yes') {
//            $(formatClone).find('#help').removeClass('hidden');
//        } else {
//            $(formatClone).find('#help').addClass('hidden');
//        }
//        resetDynamicAffixScrolling(formatClone);
//    });


    var data = getLocalItem(id + '.data');
    if (data) {
        renderData(data);
    }

    initDynamicAffixScrolling(formatClone);



    function renderData(data)
    {
        $(formatClone).find('#scenarioTitle').val(data.title);
        $(formatClone).find('#scenarioDescription').val(data.description);

        if (data.scene) {

            if (data.scene === 'none') {
                $(formatClone).find('#general .sceneSelect').find('#none').click();
            } else {
                var scene = getSceneById(data.scene);
                if (scene) {
                    $(formatClone).find('#general .sceneSelect').find('#' + scene.id).click();
                } else {
                    appendAlert($(formatClone).find('#general'), ALERT_ASSEMBLED_SCENE_REMOVED);
                }
            }
        }

        var container;
        var wozItems = data.woz;
        if (wozItems && wozItems.length > 0) {
            $(formatClone).find('#useWOZSwitch #yes').click();

            container = $(formatClone).find('#wozExperiment .option-container');

            for (var i = 0; i < wozItems.length; i++) {
                var clone = $('#form-item-container').find('#wozExperimentItem').clone().removeAttr('id');
                $(clone).removeAttr('id');
                container.append(clone);

                var gesture = getGestureById(wozItems[i].gestureId);
                if (gesture && isGestureAssembled(gesture.id))
                {
                    $(clone).find('.gestureSelect #' + gesture.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                }

                var scene = getSceneById(wozItems[i].sceneId);
                if (scene) {
                    $(clone).find('#woz-scene #' + scene.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_SCENE_REMOVED);
                }

                var trigger = getTriggerById(wozItems[i].triggerId);
                if (trigger && getTriggerById(trigger.id) !== null) {
                    $(clone).find('.triggerSelect #' + trigger.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_TRIGGER_REMOVED);
                }

                if (wozItems[i].feedbackId === 'none') {
                    $(clone).find('.feedbackSelect #none').click();
                } else {
                    var feedback = getFeedbackById(wozItems[i].feedbackId);
                    if (feedback) {
                        $(clone).find('.feedbackSelect #' + feedback.id).click();
                    } else {
                        appendAlert(clone, ALERT_ASSEMBLED_FEEDBACK_REMOVED);
                    }
                }

                if (wozItems[i].transitionId === 'none') {
                    $(clone).find('#transition-scene #none').click();
                } else {
                    var scene = getSceneById(wozItems[i].transitionId);
                    if (scene) {
                        $(clone).find('#transition-scene #' + scene.id).click();
                    } else {
                        appendAlert(clone, ALERT_ASSEMBLED_SCENE_REMOVED);
                    }
                }

                $(clone).find('.stepper-text').val(wozItems[i].recognitionTime);
            }
            checkCurrentListState(container);
        } else {
            appendAlert($(formatClone).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
        }

        var helpItems = data.help;
        if (helpItems && helpItems.length > 0) {

            $(formatClone).find('#useHelpSwitch #yes').click();

            container = $(formatClone).find('#help .option-container');
            for (var i = 0; i < helpItems.length; i++) {

                var clone = $('#form-item-container').find('#helpItem').clone().removeClass('id');
                clone.find('.option-text').val(helpItems[i].option);
                $(container).append(clone);

                var scene = getSceneById(helpItems[i].sceneId);
                if (scene) {
                    $(clone).find('.sceneSelect #' + scene.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_SCENE_REMOVED);
                }

                if (helpItems[i].useGestureHelp === true || helpItems[i].useGestureHelp === 'true') {
                    $(clone).find('#useGestureHelpSwitch #yes').click();
                    var gestureId = helpItems[i].gestureId;

                    if (gestureId !== null && !isGestureAssembled(gestureId)) {
                        appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                    } else if (gestureId !== null) {
                        var gesture = getGestureById(gestureId);
                        $(clone).find('.gestureSelect #' + gesture.id).click();
                    }
                }

                checkCurrentListState(container);
            }

            checkCurrentListState(container);
        } else {
            appendAlert($(formatClone).find('#help'), ALERT_NO_PHASE_DATA);
        }

        renderObservations(formatClone, data.observations);
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        $(formatClone).find('#btn-save-phase-step-title').click();

        var scenario = new Object();
        scenario.title = $(formatClone).find('#scenarioTitle').val();
        scenario.description = $(formatClone).find('#scenarioDescription').val();

        if ($(formatClone).find('#general .sceneSelect .chosen').attr('id') !== 'unselected') {
            scenario.scene = $(formatClone).find('#general .sceneSelect .chosen').attr('id');
        }

//        var elicitatonTrigger = $('#elicitationContainer #elicitation .option-container').children();
//        if (getLocalItem(STUDY).phase === TYPE_PHASE_ELICITATION && getLocalItem(ASSEMBLED_TRIGGER) &&
//                elicitatonTrigger.length > 0) {
//            var triggerArray = new Array();
//            for (var i = 0; i < elicitatonTrigger.length; i++) {
//                triggerArray.push(getTriggerById($(elicitatonTrigger[i]).find('.triggerSelect .chosen').attr('id')));
//            }
//            scenario.elicitationTrigger = triggerArray;
//        }

        var wozItems = $(formatClone).find('#wozExperiment .option-container').children();
        if ($(formatClone).find('#useWOZSwitch #yes').hasClass('active')) {
            var woz = new Array();
            for (var i = 0; i < wozItems.length; i++) {
                var item = wozItems[i];
                var sceneId = $(item).find('#woz-scene .chosen').attr('id');
                var scene = getSceneById(sceneId);
                var transitionId = $(item).find('#transition-scene .chosen').attr('id');
                if (transitionId === 'unselected') {
                    transitionId = 'none';
                }
                var gestureId = $(item).find('.gestureSelect .chosen').attr('id');
                var gesture = getGestureById(gestureId);
                var triggerId = $(item).find('.triggerSelect .chosen').attr('id');
                var trigger = getTriggerById(triggerId);
                var feedbackId = $(item).find('.feedbackSelect .chosen').attr('id');
                var feedback;
                if (feedbackId === 'none') {
                    feedback = 'none';
                } else {
                    feedback = getFeedbackById(feedbackId);
                }

                if (getLocalItem(STUDY).phase === TYPE_PHASE_ELICITATION) {
                    if (scene && trigger && feedback) {
                        woz.push({sceneId: sceneId, triggerId: triggerId, gestureId: null, feedbackId: feedbackId, transitionId: transitionId});
                    }
                } else {
                    if (scene && trigger && gesture && feedback) {
                        woz.push({sceneId: sceneId, triggerId: triggerId, gestureId: gestureId, feedbackId: feedbackId, transitionId: transitionId});
                    }
                }
            }
            console.log(woz);
            scenario.woz = woz;
        }


        var helpItems = $(formatClone).find('#help .option-container').children();
        if ($(formatClone).find('#useHelpSwitch #yes').hasClass('active'))
        {
            var scenarioHelp = new Array();
            for (var i = 0; i < helpItems.length; i++) {
                var item = helpItems[i];
                var help = new Object();
                help.sceneId = $(item).find('.sceneSelect .chosen').attr('id');
                help.option = $(item).find('.option-text').val().trim();
                var showGesture = $(item).find('#useGestureHelpSwitch').find('#yes').hasClass('active') ? true : false;
                help.useGestureHelp = showGesture;
                help.gestureId = showGesture === true ? $(item).find('.gestureSelect .chosen').attr('id') : null;

                if (getSceneById(help.sceneId) && help.option !== "") {
                    scenarioHelp.push(help);
                }
            }

            if (scenarioHelp.length > 0) {
                scenario.help = scenarioHelp;
            } else {
                scenario.help = null;
            }
        }

        saveObservations($(formatClone), $(formatClone).find('#observations #list-container').children(), scenario);
        setLocalItem(id + ".data", scenario);
    });


    $(formatClone).find('.btn-add-woz-experimentOption').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (event.handled !== true)
        {
            event.handled = true;
            clearAlerts($(formatClone).find('#wozExperiment'));
            var item = $('#form-item-container').find('#wozExperimentItem').clone().removeAttr('id');
            if (getLocalItem(STUDY).phase === TYPE_PHASE_ELICITATION) {
                $(item).find('.evaluation').addClass('hidden');
            }
            tweenAndAppend(item, $(this), $(formatClone), $(formatClone).find('#wozExperiment .option-container'), null, true);
        }
    });

//    $(formatClone).find('#wozExperiment .option-container').unbind('change').bind('change', function (event) {
//        if ($(this).children().length > 0) {
//            clearAlerts($(formatClone).find('#wozExperiment'));
//        } else {
//            appendAlert($(formatClone).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
//        }
//        resetDynamicAffixScrolling(formatClone);
//    });
    initQuestionnaireListChange(formatClone, $(formatClone).find('#wozExperiment .option-container'), $(formatClone).find('#wozExperiment'), ALERT_NO_PHASE_DATA);
    initQuestionnaireListItemAdded($(formatClone).find('#wozExperiment .option-container'), $(formatClone).find('#wozExperiment'));

    $(formatClone).find('.btn-add-helpOption').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (event.handled !== true)
        {
            event.handled = true;
            clearAlerts($(formatClone).find('#help'));
            var item = $('#form-item-container').find('#helpItem').clone().removeAttr('id');
            tweenAndAppend(item, $(this), $(formatClone), $(formatClone).find('#help .option-container'), null, true);
        }
    });

//    $(formatClone).find('#help .option-container').unbind('change').bind('change', function (event) {
//        if ($(this).children().length > 0) {
//            clearAlerts($(formatClone).find('#help'));
//        } else {
//            appendAlert($(formatClone).find('#help'), ALERT_NO_PHASE_DATA);
//        }
//        resetDynamicAffixScrolling(formatClone);
//    });

    initQuestionnaireListChange(formatClone, $(formatClone).find('#help .option-container'), $(formatClone).find('#help'), ALERT_NO_PHASE_DATA);
    initQuestionnaireListItemAdded($(formatClone).find('#help .option-container'), $(formatClone).find('#help'));

    $(document).on('change', '.useGestureHelpSwitch', function (event) {

        event.preventDefault();
        var activeId = $(this).find('.btn-option-checked').attr('id');
        console.log('use gesture help switch changed', activeId, $(this).closest('.root'));
        if (!assembledGestures()) {
            if (activeId === 'yes') {
                appendAlert($(this).closest('.root'), ALERT_NO_GESTURES_ASSEMBLED);
            } else {
                removeAlert($(this).closest('.root'), ALERT_NO_GESTURES_ASSEMBLED);
            }
        } else {
            if (activeId === 'yes') {
                $(this).closest('.root').find('#gesture-help-select').removeClass('hidden');
            } else {
                $(this).closest('.root').find('#gesture-help-select').addClass('hidden');
            }
        }
    });
}

function initGestureSlideshowOverlay(id, formatClone) {
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    renderDimensions($(formatClone).find('#dimension-controls'), translation.observationsGestureSlideshow, $(formatClone).find('#observations #list-container'));
    initQuestionnaireButtonGroup(formatClone, $(formatClone).find('#add-observation-button-group'), $(formatClone).find('#observations #list-container'), $(formatClone).find('#observations'), true, true, ALERT_NO_DATA_QUESTIONNAIRE);
    initQuestionnaireDimensionControl(formatClone, $(formatClone).find('#dimension-controls'), $(formatClone).find('#list-container'), $(formatClone).find('#observations'));
    initToggleSwitch(formatClone, $(formatClone).find('#useObservationsSwitch'), $(formatClone).find('#observations'));

    if (assembledGestures()) {
        renderAssembledGestures();
    } else {
        appendAlert($(formatClone).find('#slideshow'), ALERT_NO_GESTURES_ASSEMBLED);
        $(formatClone).find('#slideshow .btn-add-slideshowOption').addClass('hidden');
    }

    var trigger = getLocalItem(ASSEMBLED_TRIGGER);
    if (trigger && trigger.length > 0) {
        renderAssembledTriggers();
    } else {
        appendAlert($(formatClone).find('#slideshow'), ALERT_NO_TRIGGER_ASSEMBLED);
        $(formatClone).find('#slideshow .btn-add-slideshowOption').addClass('hidden');
    }

    var data = getLocalItem(id + '.data');
    if (data) {
        renderData(data);
    } else {
        appendAlert($(formatClone).find('#slideshow'), ALERT_NO_PHASE_DATA);
        appendAlert($(formatClone).find('#observations'), ALERT_NO_DATA_QUESTIONNAIRE);
    }
    initDynamicAffixScrolling(formatClone);


    function renderData(data) {
        var slideshowItems = data.slideshow;

        $(formatClone).find('#slideshowTitle').val(data.title);
        $(formatClone).find('#slideshowDescription').val(data.description);
        $(formatClone).find('#answerTime').val(data.answerTime);

        var container = $(formatClone).find('#slideshow .option-container');
        if (slideshowItems !== undefined && slideshowItems.length > 0) {
            for (var i = 0; i < slideshowItems.length; i++) {
                var gesture = getGestureById(slideshowItems[i].gestureId);
                var trigger = getTriggerById(slideshowItems[i].triggerId);

                var clone = $('#form-item-container').find('#slideshow-gesture-item').clone().removeAttr('id');
                container.append(clone);

                if (gesture && isGestureAssembled(gesture.id))
                {
                    $(clone).find('.gestureSelect #' + gesture.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                }

                if (trigger) {
                    if (!getTriggerById(trigger.id)) {
                        appendAlert(clone, ALERT_ASSEMBLED_TRIGGER_REMOVED);
                    } else {
                        $(clone).find('.triggerSelect #' + trigger.id).click();
                    }
                }

                $(clone).find('#recognition-stepper .stepper-text').val(slideshowItems[i].recognitionTime);
            }
            checkCurrentListState(container);
        } else {
            appendAlert($(formatClone).find('#slideshow'), ALERT_NO_PHASE_DATA);
        }

        renderObservations(formatClone, data.observations);
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        $(formatClone).find('#btn-save-phase-step-title').click();

        var slideshow = new Object();
        slideshow.title = $(formatClone).find('#slideshowTitle').val();
        slideshow.description = $(formatClone).find('#slideshowDescription').val();

        var slideshowItems = $(formatClone).find('#slideshow .option-container').children();
        if (slideshowItems) {
            var set = new Array();
            for (var i = 0; i < slideshowItems.length; i++) {
                var item = slideshowItems[i];
                var gestureId = $(item).find('.gestureSelect .chosen').attr('id');
                var gesture = getGestureById(gestureId);
                var triggerId = $(item).find('.triggerSelect .chosen').attr('id');
                var trigger = getTriggerById(triggerId);
                var recognitionTime = parseInt($(item).find('#recognition-stepper .stepper-text').val());

                if (gesture && trigger && !isNaN(recognitionTime) && recognitionTime > 0) {
                    set.push({gestureId: gestureId, triggerId: triggerId, recognitionTime: recognitionTime});
                }
            }
            slideshow.slideshow = set;
        }

        saveObservations($(formatClone), $(formatClone).find('#observations #list-container').children(), slideshow);
        setLocalItem(id + ".data", slideshow);
    });




    $(formatClone).find('.btn-add-slideshowOption').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (event.handled !== true)
        {
            event.handled = true;
            clearAlerts($(formatClone).find('#slideshow'));
            var item = $('#form-item-container').find('#slideshow-gesture-item').clone().removeAttr('id');
            tweenAndAppend(item, $(this), $(formatClone), $(formatClone).find('#slideshow .option-container'), null, true);
        }
    });

    $(formatClone).find('#slideshow .option-container').unbind('change').bind('change', function (event) {
        if ($(this).children().length > 0) {
            clearAlerts($(formatClone).find('#slideshow'));
        } else {
            appendAlert($(formatClone).find('#slideshow'), ALERT_NO_PHASE_DATA);
        }
        resetDynamicAffixScrolling(formatClone);
    });

    initQuestionnaireListItemAdded($(formatClone).find('#slideshow .option-container'), $(formatClone).find('#slideshow'));
}

function initTriggerSlideshowOverlay(id, formatClone) {
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
//    renderDimensions($(formatClone).find('#dimension-controls'), translation.observationsGestureSlideshow, $(formatClone).find('#observations #list-container'));
    initQuestionnaireButtonGroup(formatClone, $(formatClone).find('#add-observation-button-group'), $(formatClone).find('#observations #list-container'), $(formatClone).find('#observations'), true, true, ALERT_NO_DATA_QUESTIONNAIRE);
//    initQuestionnaireDimensionControl(formatClone, $(formatClone).find('#dimension-controls'), $(formatClone).find('#list-container'), $(formatClone).find('#observations'));
    initToggleSwitch(formatClone, $(formatClone).find('#useObservationsSwitch'), $(formatClone).find('#observations'));

    if (assembledGestures()) {
        renderAssembledGestures();
    } else {
        appendAlert($(formatClone).find('#slideshow'), ALERT_NO_GESTURES_ASSEMBLED);
        $(formatClone).find('#slideshow .btn-add-slideshowOption').addClass('hidden');
    }

    var trigger = getLocalItem(ASSEMBLED_TRIGGER);
    if (trigger && trigger.length > 0) {
        renderAssembledTriggers();
    } else {
        appendAlert($(formatClone).find('#slideshow'), ALERT_NO_TRIGGER_ASSEMBLED);
        $(formatClone).find('#slideshow .btn-add-slideshowOption').addClass('hidden');
    }


    var data = getLocalItem(id + '.data');
    if (data) {
        renderData(data);
    } else {
        appendAlert($(formatClone).find('#slideshow'), ALERT_NO_PHASE_DATA);
        appendAlert($(formatClone).find('#observations'), ALERT_NO_DATA_QUESTIONNAIRE);
    }
    initDynamicAffixScrolling(formatClone);


    function renderData(data) {
        var slideshowItems = data.slideshow;

        $(formatClone).find('#slideshowTitle').val(data.title);
        $(formatClone).find('#slideshowDescription').val(data.description);

        var container = $(formatClone).find('#slideshow .option-container');
        if (slideshowItems !== undefined && slideshowItems.length > 0) {
            for (var i = 0; i < slideshowItems.length; i++) {
                var gesture = getGestureById(slideshowItems[i].gestureId);
                var trigger = getTriggerById(slideshowItems[i].triggerId);

                var clone = $('#form-item-container').find('#slideshow-trigger-item').clone().removeAttr('id');
                container.append(clone);

                if (gesture && isGestureAssembled(gesture.id)) {
                    $(clone).find('.gestureSelect #' + gesture.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                }

                if (trigger) {
                    if (!getTriggerById(trigger.id)) {
                        appendAlert(clone, ALERT_ASSEMBLED_TRIGGER_REMOVED);
                    } else {
                        $(clone).find('.triggerSelect #' + trigger.id).click();
                    }
                }
            }
            checkCurrentListState(container);
        } else {
            appendAlert($(formatClone).find('#slideshow'), ALERT_NO_PHASE_DATA);
        }

        renderObservations(formatClone, data.observations);
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        $(formatClone).find('#btn-save-phase-step-title').click();

        var slideshow = new Object();
        slideshow.title = $(formatClone).find('#slideshowTitle').val();
        slideshow.description = $(formatClone).find('#slideshowDescription').val();

        var slideshowItems = $(formatClone).find('#slideshow .option-container').children();
        if (slideshowItems) {
            var set = new Array();
            for (var i = 0; i < slideshowItems.length; i++) {
                var item = slideshowItems[i];
                var gestureId = $(item).find('.gestureSelect .chosen').attr('id');
                var gesture = getGestureById(gestureId);
                var triggerId = $(item).find('.triggerSelect .chosen').attr('id');
                var trigger = getTriggerById(triggerId);

                if (gesture && trigger) {
                    set.push({gestureId: gestureId, triggerId: triggerId});
                }
            }
            slideshow.slideshow = set;
        }

        saveObservations($(formatClone), $(formatClone).find('#observations #list-container').children(), slideshow);
        setLocalItem(id + ".data", slideshow);
    });




    $(formatClone).find('.btn-add-slideshowOption').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (event.handled !== true)
        {
            event.handled = true;
            clearAlerts($(formatClone).find('#slideshow'));
            var item = $('#form-item-container').find('#slideshow-trigger-item').clone().removeAttr('id');
            tweenAndAppend(item, $(this), $(formatClone), $(formatClone).find('#slideshow .option-container'), null, true);
        }
    });

    $(formatClone).find('#slideshow .option-container').unbind('change').bind('change', function (event) {
        if ($(this).children().length > 0) {
            clearAlerts($(formatClone).find('#slideshow'));
        } else {
            appendAlert($(formatClone).find('#slideshow'), ALERT_NO_PHASE_DATA);
        }
        resetDynamicAffixScrolling(formatClone);
    });

    initQuestionnaireListItemAdded($(formatClone).find('#slideshow .option-container'), $(formatClone).find('#slideshow'));
}

function initPhysicalStressTestOverlay(id, formatClone) {
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    renderDimensions($(formatClone).find('#observations #dimension-controls'), translation.observationsPhysicalStressTest, $(formatClone).find('#observations #list-container'));
    initQuestionnaireButtonGroup(formatClone, $(formatClone).find('#add-observation-button-group'), $(formatClone).find('#observations #list-container'), $(formatClone).find('#observations'), true, true, ALERT_NO_DATA_QUESTIONNAIRE);
    initQuestionnaireDimensionControl(formatClone, $(formatClone).find('#dimension-controls'), $(formatClone).find('#list-container'), $(formatClone).find('#observations'));
    initToggleSwitch(formatClone, $(formatClone).find('#useObservationsSwitch'), $(formatClone).find('#observations'));
    initToggleSwitch(formatClone, $(formatClone).find('#useSingleStressQuestionsSwitch'), $(formatClone).find('#singleStressQuestions'));
    initToggleSwitch(formatClone, $(formatClone).find('#useSequenceStressQuestionsSwitch'), $(formatClone).find('#sequenceStressQuestions'));
    initQuestionnaireButtonGroup(formatClone, $(formatClone).find('#singleStressQuestions #add-question-button-group'), $(formatClone).find('#singleStressQuestions #list-container'), $(formatClone).find('#singleStressQuestions'), true, true, ALERT_NO_DATA_QUESTIONNAIRE);
    initQuestionnaireButtonGroup(formatClone, $(formatClone).find('#sequenceStressQuestions #add-question-button-group'), $(formatClone).find('#sequenceStressQuestions #list-container'), $(formatClone).find('#sequenceStressQuestions'), true, true, ALERT_NO_DATA_QUESTIONNAIRE);

    if (assembledGestures()) {
        renderAssembledGestures();
    } else {
        appendAlert($(formatClone).find('#stressTest'), ALERT_NO_GESTURES_ASSEMBLED);
        $(formatClone).find('#stressTest .btn-add-physicalStressTestOption').addClass('hidden');
    }

    var data = getLocalItem(id + '.data');
    if (data) {
        renderData(data, false);
    } else {
        appendAlert($(formatClone).find('#observations'), ALERT_NO_DATA_QUESTIONNAIRE);
    }

    initDynamicAffixScrolling(formatClone);

    function renderData(data)
    {
        var items = data.stressTestItems;

        $(formatClone).find('#stressTestTitle').val(data.title);
        $(formatClone).find('#stressTestDescription').val(data.description);
        $(formatClone).find('#randomizeSwitch #' + (data.randomized === true ? 'yes' : 'no')).click();
        $(formatClone).find('#totalStressAmount').val(data.stressAmount);

        var container = $(formatClone).find('#stressTest .option-container');
        if (items !== undefined && items.length > 0) {
            for (var i = 0; i < items.length; i++) {
                var gesture = getGestureById(items[i]);

                var clone = $('#form-item-container').find('#physicalStressTestItem').clone().removeClass('hidden');
                $(clone).removeAttr('id');
                container.append(clone);

                if (gesture && isGestureAssembled(gesture.id)) {
                    $(clone).find('.gestureSelect #' + gesture.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                }
            }
            checkCurrentListState(container);
        }

        var singleStressQuestions = data.singleStressQuestions;
        if ((singleStressQuestions !== undefined && singleStressQuestions.length > 0) || (data.singleStressGraphicsRating !== undefined && data.singleStressGraphicsRating !== 'none')) {
            $(formatClone).find('#useGraphicalSingleStressSwitch #' + data.singleStressGraphicsRating).click();
            $(formatClone).find('#useSingleStressQuestionsSwitch #yes').click();
            container = $(formatClone).find('#singleStressQuestions #list-container');
            if (singleStressQuestions !== undefined && singleStressQuestions.length > 0) {
                for (var i = 0; i < singleStressQuestions.length; i++) {
                    renderFormatItem(container, singleStressQuestions[i]);
                    updateBadges(container, singleStressQuestions[i].format);
                }
                checkCurrentListState(container);
            }
        }

        var sequenceStressQuestions = data.sequenceStressQuestions;
        if ((sequenceStressQuestions !== undefined && sequenceStressQuestions.length > 0) || (data.sequenceStressGraphicsRating !== undefined && data.sequenceStressGraphicsRating !== 'none')) {
            $(formatClone).find('#useGraphicalSequenceStressSwitch #' + data.sequenceStressGraphicsRating).click();
            $(formatClone).find('#useSequenceStressQuestionsSwitch #yes').click();
            container = $(formatClone).find('#sequenceStressQuestions #list-container');
            if (sequenceStressQuestions !== undefined && sequenceStressQuestions.length > 0) {
                for (var i = 0; i < sequenceStressQuestions.length; i++) {
                    renderFormatItem(container, sequenceStressQuestions[i]);
                    updateBadges(container, sequenceStressQuestions[i].format);
                }
                checkCurrentListState(container);
            }
        }

        renderObservations(formatClone, data.observations);
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        $(formatClone).find('#btn-save-phase-step-title').click();

        var stressTest = new Object();
        stressTest.title = $(formatClone).find('#stressTestTitle').val();
        stressTest.description = $(formatClone).find('#stressTestDescription').val();
        stressTest.randomized = $(formatClone).find('#randomizeSwitch .active').attr('id') === 'yes';
        stressTest.stressAmount = $(formatClone).find('#totalStressAmount').val();

        var items = $(formatClone).find('#stressTest .option-container').children();
        if (items) {
            var set = new Array();
            for (var i = 0; i < items.length; i++) {
                var item = items[i];
                var gestureId = $(item).find('.gestureSelect .chosen').attr('id');
                var gesture = getGestureById(gestureId);

                if (gesture) {
                    set.push(gestureId);
                }
            }
            stressTest.stressTestItems = set;
        }

        var singleStressQuestions = $(formatClone).find('#singleStressQuestions #list-container').children();
        if ($(formatClone).find('#useSingleStressQuestionsSwitch #yes').hasClass('active') &&
                (singleStressQuestions.length > 0 || $(formatClone).find('#useGraphicalSingleStressSwitch .btn-option-checked').attr('id') !== 'none'))
        {
            var questionnaire = new Array();
            for (var i = 0; i < singleStressQuestions.length; i++) {
                questionnaire.push(getFormatData(singleStressQuestions[i]));
            }
            if (questionnaire.length > 0) {
                stressTest.singleStressQuestions = questionnaire;
            }
            stressTest.singleStressGraphicsRating = $(formatClone).find('#useGraphicalSingleStressSwitch .btn-option-checked').attr('id');
        }

        var sequenceStressQuestions = $(formatClone).find('#sequenceStressQuestions #list-container').children();
        if ($(formatClone).find('#useSequenceStressQuestionsSwitch #yes').hasClass('active') &&
                (sequenceStressQuestions.length > 0 || $(formatClone).find('#useGraphicalSequenceStressSwitch .btn-option-checked').attr('id') !== 'none'))
        {
            var questionnaire = new Array();
            for (var i = 0; i < sequenceStressQuestions.length; i++) {
                questionnaire.push(getFormatData(sequenceStressQuestions[i]));
            }
            if (questionnaire.length > 0) {
                stressTest.sequenceStressQuestions = questionnaire;
            }
            stressTest.sequenceStressGraphicsRating = $(formatClone).find('#useGraphicalSequenceStressSwitch .btn-option-checked').attr('id');
        }

        saveObservations($(formatClone), $(formatClone).find('#observations #list-container').children(), stressTest);
        setLocalItem(id + ".data", stressTest);
    });



    $(formatClone).find('#stressTest .btn-add-physicalStressTestOption').on('click', function (event) {
        event.preventDefault();
        if (event.handled !== true)
        {
            event.handled = true;
            clearAlerts($(formatClone).find('#stressTest'));
            var item = $('#form-item-container').find('#physicalStressTestItem').clone().removeAttr('id');
            tweenAndAppend(item, $(this), $(formatClone), $(formatClone).find('#stressTest .option-container'), null, true);
        }
    });

    $(formatClone).find('#stressTest .option-container').unbind('change').bind('change', function (event) {
        if ($(this).children().length > 0) {
            clearAlerts($(formatClone).find('#stressTest'));
        } else {
            appendAlert($(formatClone).find('#stressTest'), ALERT_NO_PHASE_DATA);
        }
        resetDynamicAffixScrolling(formatClone);
    });

    initQuestionnaireListItemAdded($(formatClone).find('#stressTest .option-container'), $(formatClone).find('#stressTest'));
}

function initElicitationOverlay(id, formatClone) {
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    initQuestionnaireButtonGroup(formatClone, $(formatClone).find('#observations #add-observation-button-group'), $(formatClone).find('#observations #list-container'), $(formatClone).find('#observations'), true, true, ALERT_NO_DATA_QUESTIONNAIRE);
    initToggleSwitch(formatClone, $(formatClone).find('#useObservationsSwitch'), $(formatClone).find('#observations'));

    $(formatClone).find('#identificationTypeSwitch').on('change', function () {
        var container = $(formatClone).find('#identificationElements');
        clearAlerts(container);

        var idenficationItems = $(container).find('.option-container').children();
        $(idenficationItems).remove();
        appendAlert(container, ALERT_NO_PHASE_DATA);
        wobble($(container).find('.btn-add-identificationOption'));

        if ($(this).find('.btn-option-checked').attr('id') === $(formatClone).find('#identificationTypeSwitch #gestures').attr('id')) {
            var trigger = getLocalItem(ASSEMBLED_TRIGGER);
            var scenes = getLocalItem(ASSEMBLED_SCENES);

            if (trigger && trigger.length > 0 && scenes && scenes.length > 0) {
                renderAssembledTriggers();
                renderAssembledScenes();
                $(container).find('.btn-add-identificationOption').removeClass('disabled');
            } else {
                if (!trigger || trigger.length === 0) {
                    appendAlert(container, ALERT_NO_TRIGGER_ASSEMBLED);
                }

                if (!scenes || scenes.length === 0) {
                    appendAlert(container, ALERT_NO_SCENES_ASSEMBLED);
                }

                $(container).find('.btn-add-identificationOption').addClass('disabled');
            }
        } else {
            if (assembledGestures()) {
                renderAssembledGestures();
                $(container).find('.btn-add-identificationOption').removeClass('disabled');
            } else {
                appendAlert(container, ALERT_NO_GESTURES_ASSEMBLED);
                $(container).find('.btn-add-identificationOption').addClass('disabled');
            }
        }
    });

    var data = getLocalItem(id + '.data');
    if (data) {
        renderData(data, false);
    } else {
        appendAlert($(formatClone).find('#identificationElements'), ALERT_NO_PHASE_DATA);
        appendAlert($(formatClone).find('#observations'), ALERT_NO_DATA_QUESTIONNAIRE);
    }

    initDynamicAffixScrolling(formatClone);

    function renderData(data) {
        $(formatClone).find('#identificationTitle').val(data.title);
        $(formatClone).find('#identificationDescription').val(data.description);
        $(formatClone).find('#identificationTypeSwitch #' + data.identificationFor).click();
        console.log($(formatClone).find('#identificationTypeSwitch #' + data.identificationFor), data.identificationFor);



        var identificationItems = data.identification;
        if (identificationItems !== undefined && identificationItems.length > 0) {
            clearAlerts($(formatClone).find('#identificationElements'));
            var container = $(formatClone).find('#identificationElements .option-container');
            $(formatClone).find('#identificationElements .btn-add-identificationOption').removeClass('disabled');

            for (var i = 0; i < identificationItems.length; i++) {
                var clone = $('#form-item-container').find('#identificationItem-' + data.identificationFor).clone();
                $(clone).removeAttr('id');
                container.append(clone);

                if (data.identificationFor === 'gestures') {

                    var trigger = getTriggerById(identificationItems[i].triggerId);

                    if (trigger && isTriggerAssembled(trigger.id)) {
                        $(clone).find('.triggerSelect #' + trigger.id).click();
                    } else if (trigger !== null) {
                        appendAlert(clone, ALERT_ASSEMBLED_TRIGGER_REMOVED);
                    }

                    var scene = getSceneById(identificationItems[i].sceneId);
                    console.log(trigger, scene);
                    if (scene && isSceneAssembled(scene.id)) {
                        $(clone).find('.sceneSelect #' + scene.id).click();
                    } else if (scene !== null) {
                        appendAlert(clone, ALERT_ASSEMBLED_SCENE_REMOVED);
                    }
//                    console.log(isTriggerAssembled(trigger.id), isSceneAssembled(scene.id));

                    $(clone).find('#context-input').val(identificationItems[i].context);
                    $(clone).find('#sceneDescription').val(identificationItems[i].sceneDescription);
                } else {
//                    $(clone).find('#group-trigger').remove();
                    var gesture = getGestureById(identificationItems[i].gestureId);
                    if (gesture && isGestureAssembled(gesture.id)) {
                        $(clone).find('.gestureSelect #' + gesture.id).click();
                    } else if (gesture !== null) {
                        appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                    }
                }

            }
            checkCurrentListState(container);
        } else if (data.identificationFor !== undefined) {
            appendAlert($(formatClone).find('#identificationElements'), ALERT_NO_PHASE_DATA);
            $(formatClone).find('#identificationElements .btn-add-identificationOption').removeClass('disabled');
        } else {
            appendAlert($(formatClone).find('#identificationElements'), ALERT_NO_PHASE_DATA);
        }

        renderObservations(formatClone, data.observations);
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        $(formatClone).find('#btn-save-phase-step-title').click();

        var identification = new Object();
        identification.title = $(formatClone).find('#identificationTitle').val();
        identification.description = $(formatClone).find('#identificationDescription').val();
        identification.identificationFor = $(formatClone).find('#identificationTypeSwitch .btn-option-checked').attr('id');

        var identificationItems = $(formatClone).find('#identificationElements .option-container').children();
        if (identificationItems) {
            var set = new Array();
            for (var i = 0; i < identificationItems.length; i++) {
                var item = identificationItems[i];
                if ($(formatClone).find('#identificationTypeSwitch .btn-option-checked').attr('id') === 'gestures') {
                    var triggerId = $(item).find('.triggerSelect .chosen').attr('id');
                    var context = $(item).find('#context-input').val();
                    var sceneId = $(item).find('.sceneSelect .chosen').attr('id');
                    var description = $(item).find('#sceneDescription').val();
                    set.push({triggerId: triggerId, context: context, sceneId: sceneId, sceneDescription: description});
                } else {
                    var gestureId = $(item).find('.gestureSelect .chosen').attr('id');
                    set.push({gestureId: gestureId});
                }
            }

            console.log(set);
            identification.identification = set;
        }

        saveObservations(formatClone, $(formatClone).find('#observations #list-container').children(), identification);
        setLocalItem(id + ".data", identification);
    });


    $(formatClone).find('#identificationElements .btn-add-identificationOption').on('click', function (event) {
        event.preventDefault();
        if (event.handled !== true)
        {
            event.handled = true;
            if (!$(this).hasClass('disabled')) {
                clearAlerts($(formatClone).find('#identificationElements'));
                var type = $(formatClone).find('#identificationTypeSwitch .btn-option-checked').attr('id');
                var item = $('#form-item-container').find('#identificationItem-' + type).clone().removeAttr('id');
                console.log(type, item);
//            if (type === 'gestures') {
//                $(item).find('#group-gestures').remove();
//            } else {
//                $(item).find('#group-trigger').remove();
//            }
                tweenAndAppend(item, $(this), $(formatClone), $(formatClone).find('#identificationElements .option-container'), null, true);
            } else {
                wobble($(formatClone).find('#identificationTypeSwitch'));
            }
        }
    });

    $(formatClone).find('#identificationElements .option-container').unbind('change').bind('change', function (event) {
        if ($(this).children().length > 0) {
            clearAlerts($(formatClone).find('#identificationElements'));
        } else {
            appendAlert($(formatClone).find('#identificationElements'), ALERT_NO_PHASE_DATA);
        }
        resetDynamicAffixScrolling(formatClone);
    });

    initQuestionnaireListItemAdded($(formatClone).find('#identificationElements .option-container'), $(formatClone).find('#identificationElements'));
}







/*
 * functions cound use for all overlay formats
 */

function tweenAndAppend(item, triggerElement, formatClone, container, itemType, fixDynamicAffixScrolling) {
    var tweenTarget = container.children().last();
    var tweenTargetOffset = !tweenTarget || (tweenTarget && tweenTarget.length === 0) ? $(container).offset() : $(tweenTarget).offset();
    var tweenElementOffset = $(triggerElement).offset();
    var tweenOffset = {offsetY: tweenTargetOffset.top - tweenElementOffset.top + tweenTarget.height(), offsetX: tweenTargetOffset.left - tweenElementOffset.left};
    var alphaY = tweenOffset.offsetY < 0 ? '' + tweenOffset.offsetY : '+' + tweenOffset.offsetY;
    var alphaX = tweenOffset.offsetX < 0 ? '' + tweenOffset.offsetX : '+' + tweenOffset.offsetX;
    TweenMax.to($(triggerElement), .3, {x: alphaX, y: alphaY, opacity: 0, clearProps: 'all', ease: Quad.easeIn, onComplete: onMoveComplete, onCompleteParams: [item, formatClone, container, itemType, fixDynamicAffixScrolling]});
}

function onMoveComplete(clone, formatClone, listContainer, itemType, fixDynamicAffixScrolling) {
    $(listContainer).append(clone);
    checkCurrentListState(listContainer);
    if (itemType) {
        updateBadges(listContainer, itemType);
    }

    if (fixDynamicAffixScrolling && fixDynamicAffixScrolling === true) {
        resetDynamicAffixScrolling(formatClone);
    }

    TweenMax.from(clone, 1, {y: -40, opacity: 0, ease: Elastic.easeOut, clearProps: 'all'});
    $(listContainer).trigger('listItemAdded');
}

function initDynamicAffixScrolling(target) {
    resetDynamicAffixScrolling(target);

    $(window).unbind('scroll resize').bind('scroll resize', function (event) {
        if (event.type === 'resize') {
            resetDynamicAffixScrolling(target);
        } else {
            var dynamicAffix = $(target).find('.toggle-dynamic-affix');
            for (var i = 0; i < dynamicAffix.length; i++) {
                var documentScroll = $('body').scrollTop();
                var element = $(dynamicAffix[i]);
                var elementOffset = element.offset();

                var rowHeight = $(element).closest('.row').height();
                if (rowHeight - 40 > $(element).height()) {
                    if (i < dynamicAffix.length - 1 && $(element).hasClass('toggle-affix')) {
                        if (parseInt(element.attr('data-originalTop')) + rowHeight < elementOffset.top + element.height()) {
                            $(element).removeClass('toggle-dynamic-affix-unhidden').addClass('toggle-dynamic-affix-hidden');
                        } else {
                            $(element).removeClass('toggle-dynamic-affix-hidden').addClass('toggle-dynamic-affix-unhidden');
                        }
                    }

                    if (parseInt(element.attr('data-originalTop')) > elementOffset.top) {
                        $(element).removeClass('toggle-affix');
                    } else if (elementOffset.top - documentScroll < 155) {
                        $(element).addClass('toggle-affix');
                    }
                } else {
                    $(element).removeClass('toggle-affix');
                }
            }
        }
    });
}

function resetDynamicAffixScrolling(target) {
    var dynamicAffix = $(target).find('.toggle-dynamic-affix');
    for (var i = 0; i < dynamicAffix.length; i++) {
        var elementOffset = $(dynamicAffix[i]).offset();
        if ($(dynamicAffix[i]).hasClass('toggle-affix')) {
            $(dynamicAffix[i]).removeClass('toggle-affix');
            elementOffset = $(dynamicAffix[i]).offset();
            $(dynamicAffix[i]).attr('data-originalTop', elementOffset.top);
            $(dynamicAffix[i]).addClass('toggle-affix');
        } else {
            $(dynamicAffix[i]).attr('data-originalTop', elementOffset.top);
        }
    }
    $(window).trigger('scroll');
}


function initQuestionnaireButtonGroup(formatClone, buttonGroup, listContainer, alertContainer, initListItemAdded, initChange, alertFormat) {
    $(buttonGroup).unbind('change').bind('change', function (event) {
        var itemType = $(event.target).attr('id');
        var clone = $('#form-item-container').find('#' + itemType).clone();
        clone.attr('name', itemType);
        initJustificationFormElements(clone);
        tweenAndAppend(clone, $(event.target), $(formatClone), listContainer, itemType, true);
    });

    if (initListItemAdded === true) {
        initQuestionnaireListItemAdded(listContainer, alertContainer);
    }

    if (initChange === true) {
        initQuestionnaireListChange(formatClone, listContainer, alertContainer, alertFormat);
    }
}

function initQuestionnaireDimensionControl(formatClone, dimensionControls, listContainer, alertContainer, initListItemAdded, initChange, alertFormat) {
    $(dimensionControls).unbind('listItemAdded').bind('listItemAdded', function (event) {
        event.preventDefault();
        var addedElement = $(listContainer).children().last();
        clearAlerts(alertContainer);
        var newScrollTop = Math.max(0, $(addedElement).offset().top + $(addedElement).height() - $(window).height() + 190); // 190 due to padding-top 110px + padding-bottom 80px
        $('body').animate({
            scrollTop: newScrollTop
        }, 200);
    });

    if (initListItemAdded === true) {
        initQuestionnaireListItemAdded(listContainer, alertContainer);
    }

    if (initChange === true) {
        initQuestionnaireListChange(formatClone, listContainer, alertContainer, alertFormat);
    }
}

function initQuestionnaireListItemAdded(listContainer, alertContainer) {
    $(listContainer).unbind('listItemAdded').bind('listItemAdded', function (event) {
        event.preventDefault();
        var addedElement = $(event.target).children().last();
        initializeItemType(addedElement);
        clearAlerts(alertContainer);
        var newScrollTop = Math.max(0, $(addedElement).offset().top + $(addedElement).height() - $(window).height() + 190); // 190 due to padding-top 110px + padding-bottom 80px
        $('body').animate({
            scrollTop: newScrollTop
        }, 200);
    });
}

function initQuestionnaireListChange(formatClone, listContainer, alertContainer, alertFormat) {
    $(listContainer).unbind('change').bind('change', function (event) {
        if ($(this).children().length > 0) {
            clearAlerts(alertContainer);
        } else {
            appendAlert(alertContainer, alertFormat);
        }
        resetDynamicAffixScrolling(formatClone);
    });
}

function initToggleSwitch(formatClone, switchTarget, toggleTarget) {
    $(switchTarget).unbind('change').bind('change', function (event) {
        if ($(event.target).attr('id') === 'yes') {
            $(toggleTarget).removeClass('hidden');
        } else {
            $(toggleTarget).addClass('hidden');
        }
        resetDynamicAffixScrolling(formatClone);
    });

}

function renderObservations(formatClone, obeservationItems) {
    if (obeservationItems && obeservationItems !== undefined && obeservationItems.length > 0) {
        $(formatClone).find('#useObservationsSwitch #yes').click();

        var listContainer = $(formatClone).find('#observations #list-container');
        for (var i = 0; i < obeservationItems.length; i++) {
            renderFormatItem(listContainer, obeservationItems[i]);
            updateBadges(listContainer, obeservationItems[i].format);
        }
        checkCurrentListState(listContainer);
        checkDimensionItems($(formatClone).find('#dimension-controls .dimension-container'));
    } else {
        appendAlert($(formatClone).find('#observations'), ALERT_NO_DATA_QUESTIONNAIRE);
    }
}

function saveObservations(formatClone, observationItems, data) {
    if ($(formatClone).find('#useObservationsSwitch #yes').hasClass('active') && observationItems.length > 0)
    {
        var questionnaire = new Array();
        for (var i = 0; i < observationItems.length; i++) {
            questionnaire.push(getFormatData(observationItems[i]));
        }
        data.observations = questionnaire;
    }
}