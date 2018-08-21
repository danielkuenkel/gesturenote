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
    initPopover();
    initTooltips();
}

function initOverlayContentByFormat(format) {
    var formatClone = $('#overlays-item-container').find('#' + format).clone().removeAttr('id');
    $('#overlay-content-placeholder').empty().append(formatClone);
    console.log(format, formatClone);
    $(window).unbind('scroll resize');
    initOverlayContentFunctionalitiesByFormat(format, formatClone);
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
        case INTERVIEW:
            initInterviewOverlay(id, formatClone);
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
        case UEQ:
            initUEQOvlerlay(id, formatClone);
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
            initElicitationOverlay(id, formatClone);
            break;
        case EXPLORATION:
            initExplorationOverlay(id, formatClone);
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
    var listContainer = $(formatClone).find('#list-container');
    $('[data-toggle="popover"]').popover({container: 'body', delay: {"show": 300, "hide": 0}});
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    initQuestionnaireButtonGroup(formatClone, $(formatClone).find('#add-question-button-group'), listContainer, $(formatClone), true, true, ALERT_NO_DATA_QUESTIONNAIRE);
    $(listContainer).attr('data-allow-filters', 'true');

    var data = getLocalItem(id + '.data');
    if (data !== null && data.length > 0) {
        renderData(data);
    } else {
        appendAlert($(formatClone), ALERT_NO_DATA_QUESTIONNAIRE);
    }

    function renderData(data) {
        for (var i = 0; i < data.length; i++) {
            renderFormatItem(listContainer, data[i], null, true);
            updateBadges(listContainer, data[i].format);
        }
        checkCurrentListState(listContainer);
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(formatClone).find('#btn-save-phase-step-title').click();
        var itemList = $(listContainer).children();
        var questionnaire = new Array();
        for (var i = 0; i < itemList.length; i++) {
            questionnaire.push(getFormatData(itemList[i]));
        }
        setLocalItem(id + '.data', questionnaire);
    });

    initQuestionnairePreview($(formatClone).find('.btn-preview-questionnaire'), listContainer);
}


function initQuestionnairePreview(button, list, getAssembledGestures, additionalFunction, currentPhaseFormat) {
    $(button).unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            var itemList = $(list).children();
            var questionnaire = new Array();
            for (var i = 0; i < itemList.length; i++) {
                questionnaire.push(getFormatData(itemList[i], currentPhaseFormat));
            }

            currentPreviewData = questionnaire;
            if (getAssembledGestures === true) {
                currentPreviewData = getAssembledItems(questionnaire);
            }

            $('#custom-modal').on('shown.bs.modal', function () {
                if (currentPhaseFormat === UEQ) {
                    $('#custom-modal').find('.question-container').css({display: 'table', margin: '0 auto'});
                } else {
                    $('#custom-modal').find('.question-container').css({display: '', margin: ''});
                }
            });

            loadHTMLintoModal('custom-modal', 'externals/modal-preview.php', 'modal-lg');
        }
    });

    if ($(list).children().length === 0) {
        $(button).addClass('disabled');
    }

    $(list).bind('change listItemAdded', function (event, data) {

        console.log('change listItemAdded', event);
        if ($(this).children().length > 0) {
            $(button).removeClass('disabled');
            if (additionalFunction) {
                additionalFunction();
            }
        } else {
            $(button).addClass('disabled');
        }

        var allowFilterOptions = $(list).attr('data-allow-filters') === 'true';
        console.log('list allowFilterOptions', allowFilterOptions);
        if (allowFilterOptions) {
            if (event.type === 'change' && data && data.type === 'delete') {
                var deleteFilterElement = $(list).find('.filter-options-container').find('.dropdown-toggle #' + data.id).closest('.root');
                $(deleteFilterElement).find('.btn-delete').click();
                checkFilterOptions(list);
            } else if (event.type === 'change' && data && data.type === 'moved') {
                checkFilterOptions(list);

                var addFilterButtons = $(event.target).find('.btn-add-filter-option');
                for (var i = 0; i < addFilterButtons.length; i++) {
                    if (!$(addFilterButtons[i]).closest('.filter-options').hasClass('hidden')) {
                        var root = $(addFilterButtons[i]).closest('.root');
                        var dataRoot = root;
                        var element = $(event.target);

                        if ($(addFilterButtons[i]).attr('data-root-lookups') !== undefined) {
                            var rootLookups = parseInt($(addFilterButtons[i]).attr('data-root-lookups'));
                            dataRoot = $(dataRoot).parents().eq(rootLookups);
                        }

                        var formatData = getFormatData(dataRoot);
                        var filterOptionData = getFilterOptions(formatData.format, root);

                        if (filterOptionData && filterOptionData.length > 0) {
                            var filterOption = null;
                            for (var j = 0; j < filterOptionData.length; j++) {
                                if (parseInt($(element).attr('id')) === parseInt(filterOptionData[j].id)) {
                                    filterOption = filterOptionData[j];
                                    break;
                                }
                            }
                            console.log(filterOptionData, filterOption, element);
                            updateAvailableFilterOptions(formatData, dataRoot, root, element, filterOption);
                        }
                    }
                }
            } else if (event.type === 'listItemAdded') {
                console.log('list item added');
                checkFilterOptions(list);
            }
        } else {
            $(list).find('.filter-options').remove();
        }
    });
}

function initInterviewOverlay(id, formatClone) {
    var listContainer = $(formatClone).find('#list-container');
    $('[data-toggle="popover"]').popover({container: 'body', delay: {"show": 300, "hide": 0}});
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    initQuestionnaireButtonGroup(formatClone, $(formatClone).find('#add-question-button-group'), listContainer, $(formatClone), true, true, ALERT_NO_DATA_QUESTIONNAIRE);
    $(listContainer).attr('data-allow-filters', 'true');

    var data = getLocalItem(id + '.data');
    if (data !== null && data.length > 0) {
        renderData(data);
    } else {
        appendAlert($(formatClone), ALERT_NO_DATA_QUESTIONNAIRE);
    }

    function renderData(data) {
        for (var i = 0; i < data.length; i++) {
            renderFormatItem(listContainer, data[i], null, true);
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

    initQuestionnairePreview($(formatClone).find('.btn-preview-questionnaire'), $(formatClone).find('#list-container'));
}

function initGUSSingleGesturesOverlay(id, formatClone) {
    renderAssembledGestures($(formatClone).find('#forGesture'));
    renderAssembledTriggers($(formatClone).find('#gesture-trigger'));
    renderAssembledFeedback($(formatClone).find('#gesture-feedback'), [{id: 'none', title: translation.none}]);
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    renderDimensions($(formatClone).find('#dimension-controls'), translation.singleGUS, $(formatClone).find('#list-container'), translation.dimensions);
    initQuestionnaireDimensionControl(formatClone, $(formatClone).find('#dimension-controls'), $(formatClone).find('#list-container'), $(formatClone), true, true, ALERT_NO_DATA_GUS);

    var data = getLocalItem(id + '.data');
    if (data !== null) {
        renderData(data);
    } else {
        appendAlert(formatClone, ALERT_NO_DATA_GUS);
    }

    function renderData(data) {
        if (data.gestureId) {
            if (isGestureAssembled(data.gestureId)) {
                $(formatClone).find('#forGesture').find('#' + data.gestureId).click();
            } else {
                $(formatClone).find('.btn-preview-questionnaire').addClass('disabled');
                appendAlert($(formatClone).find('#general'), ALERT_ASSEMBLED_GESTURE_REMOVED);
            }
        } else {
            $(formatClone).find('.btn-preview-questionnaire').addClass('disabled');
        }

        if (data.triggerId) {
            var trigger = getTriggerById(data.triggerId);
            if (trigger === null) {
                appendAlert($(formatClone).find('#general'), ALERT_ASSEMBLED_TRIGGER_REMOVED);
                $(formatClone).find('.btn-preview-questionnaire').addClass('disabled');
            } else {
                $(formatClone).find('#gesture-trigger').find('#' + data.triggerId).click();
            }
        } else {
            $(formatClone).find('.btn-preview-questionnaire').addClass('disabled');
        }

        if (data.feedbackId) {
            var feedback = getFeedbackById(data.feedbackId);
            if (feedback === null) {
                appendAlert($(formatClone).find('#general'), ALERT_ASSEMBLED_FEEDBACK_REMOVED);
                $(formatClone).find('.btn-preview-questionnaire').addClass('disabled');
            } else {
                $(formatClone).find('#gesture-feedback').find('#' + data.feedbackId).click();
            }
        } else {
            $(formatClone).find('.btn-preview-questionnaire').addClass('disabled');
        }
        checkSingleGestureGeneralData();


        if (data !== null && data.gus && data.gus.length > 0) {
            var listContainer = $(formatClone).find('#list-container');
            for (var i = 0; i < data.gus.length; i++) {
                renderFormatItem(listContainer, data.gus[i], GUS_SINGLE_GESTURES);
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
            questionnaire.push(getFormatData(itemList[i], GUS_SINGLE_GESTURES));
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

    $(formatClone).find('#general').unbind('change').bind('change', function () {
        checkSingleGestureGeneralData();
    });

    function checkSingleGestureGeneralData() {
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

        if (gestureId === null || triggerId === null || feedbackId === null) {
            $(formatClone).find('.btn-preview-questionnaire').addClass('disabled');
        } else {
            $(formatClone).find('.btn-preview-questionnaire').removeClass('disabled');
        }

        singleGUSGesture = {gestureId: gestureId, triggerId: triggerId, feedbackId: feedbackId};
    }

    initQuestionnairePreview($(formatClone).find('.btn-preview-questionnaire'), $(formatClone).find('#list-container'), true, checkSingleGestureGeneralData(), GUS_SINGLE_GESTURES);
    $(formatClone).find('.btn-preview-questionnaire').on('click', function (event) {
//        console.log('btn-preview-questionnaire');
        if ($(this).hasClass('disabled')) {
            wobble(formatClone.find('#general'));
        }
    });
}

function initGUSMultipleGesturesOverlay(id, formatClone) {
    renderAssembledGestures($(formatClone).find('#forGesture'));
    renderAssembledTriggers($(formatClone).find('#gesture-trigger'));
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    renderDimensions($(formatClone).find('#dimension-controls'), translation.multipleGUS, $(formatClone).find('#list-container'), translation.dimensions);
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
            renderFormatItem(listContainer, data.gus[i], GUS_MULTIPLE_GESTURES);
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
            questionnaire.push(getFormatData(itemList[i], GUS_MULTIPLE_GESTURES));
        }

        setLocalItem(id + '.data', {gus: questionnaire});
    });

    initQuestionnairePreview($(formatClone).find('.btn-preview-questionnaire'), $(formatClone).find('#list-container'), true, null, GUS_MULTIPLE_GESTURES);
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

    initQuestionnairePreview($(formatClone).find('.btn-preview-questionnaire'), $(formatClone).find('#list-container'));
}

function initUEQOvlerlay(id, formatClone) {
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    renderDimensions($(formatClone).find('#dimension-controls'), translation.ueqItems, $(formatClone).find('#list-container'), translation.ueqDimensions);
    initQuestionnaireDimensionControl(formatClone, $(formatClone).find('#dimension-controls'), $(formatClone).find('#list-container'), $(formatClone), true, true, ALERT_NO_DATA_UEQ_QUESTIONNAIRE);

    var data = getLocalItem(id + '.data');
    if (data !== null) {
        renderData(data);
    } else {
        appendAlert(formatClone, ALERT_NO_DATA_UEQ_QUESTIONNAIRE);
    }

    function renderData(data) {
        var listContainer = $(formatClone).find('#list-container');
        for (var i = 0; i < data.length; i++) {
            renderFormatItem(listContainer, data[i]);
            updateBadges(listContainer, data[i].format);
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

        setLocalItem(id + '.data', questionnaire);
    });

    initQuestionnairePreview($(formatClone).find('.btn-preview-questionnaire'), $(formatClone).find('#list-container'), null, null, UEQ);
}




/*
 * init gesture specific format overlays
 */

function initGestureTrainingOverlay(id, formatClone) {
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    renderDimensions($(formatClone).find('#dimension-controls'), translation.observationsGestureTraining, $(formatClone).find('#observations #list-container'), translation.dimensions);
    initQuestionnaireButtonGroup(formatClone, $(formatClone).find('#add-observation-button-group'), $(formatClone).find('#observations #list-container'), $(formatClone).find('#observations'), true, true, ALERT_NO_DATA_QUESTIONNAIRE);
    initQuestionnaireDimensionControl(formatClone, $(formatClone).find('#dimension-controls'), $(formatClone).find('#list-container'), $(formatClone).find('#observations'));
    initToggleSwitch(formatClone, $(formatClone).find('#useObservationsSwitch'), $(formatClone).find('#observations'));
    if (assembledGestures()) {
        renderAssembledGestures();
    } else {
        appendAlert($(formatClone).find('#training'), ALERT_NO_STUDY_GESTURES_ASSEMBLED_LINK);
        $(formatClone).find('#training .btn-add-gestureTrainingOption').addClass('hidden');
        $(formatClone).find('#btn-assemble-study-gesture-set').on('click', function (event) {
            event.preventDefault();
            $(formatClone).find('.btn-close-overlay').click();
            $('.mainContent').find('#catalogs #gestures-catalog .btn-open-overlay').click();
        });
    }

    var trigger = getLocalItem(ASSEMBLED_TRIGGER);
    if (trigger && trigger.length > 0) {
        renderAssembledTriggers();
    } else {
        appendAlert($(formatClone).find('#training'), ALERT_NO_TRIGGER_ASSEMBLED_LINK);
        $(formatClone).find('#training .btn-add-gestureTrainingOption').addClass('hidden');
        $(formatClone).find('#btn-assemble-trigger').on('click', function (event) {
            event.preventDefault();
            $(formatClone).find('.btn-close-overlay').click();
            $('.mainContent').find('#catalogs #trigger-catalog .btn-open-overlay').click();
        });
    }

    renderAssembledScenes();
    renderAssembledFeedback(null, [{id: 'none', title: translation.none}]);


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
//        $(formatClone).find('#trainingTitle').val(data.title);
        $(formatClone).find('#trainingDescription').val(data.description);
        var container;
        if (trainingItems !== undefined && trainingItems.length > 0) {

            container = $(formatClone).find('#trainingContainer .option-container');
            for (var i = 0; i < trainingItems.length; i++) {
                var clone = $('#form-item-container').find('#gestureTrainingItem').clone().removeClass('hidden');
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

                initTransitionFeedbackMode(clone, formatClone);
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

                $(clone).find('.transitionFeedback-mode #' + trainingItems[i].feedbackTransitionMode).click();
                $(clone).find('.transitionFeedback-time-stepper .stepper-text').val(trainingItems[i].feedbackTransitionTime);

                var repeats = trainingItems[i].repeats;
                $(clone).find('#repeats-stepper .stepper-text').val(parseInt(repeats));
                if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_UNMODERATED) {
                    $(clone).find('#recognition-stepper').removeClass('hidden');
                    var recognitionTime = trainingItems[i].recognitionTime;
                    $(clone).find('#recognition-stepper').val(parseInt(recognitionTime));
                }

                if (trainingItems[i].transitionScenes && trainingItems[i].transitionScenes.length > 0) {
                    for (var j = 0; j < trainingItems[i].transitionScenes.length; j++) {
                        var scene = getSceneById(trainingItems[i].transitionScenes[j].sceneId);
                        var item = $('#form-item-container').find('#woz-transition-scene-option').clone().removeAttr('id');
                        $(clone).find('.transition-scenes-option-container').append(item);
                        initTransitionWOZSceneSelect(item);
                        if (scene) {
                            $(item).find('.sceneSelect #' + scene.id).click();
                            if (scene.type === SCENE_PIDOCO) {
                                $(item).find('.event-bus-settings').removeClass('hidden');
                            }
                            $(item).find('.use-event-bus #' + trainingItems[i].transitionScenes[j].useEventBus).click();
                            $(item).find('.continuous-value-type #' + trainingItems[i].transitionScenes[j].continuousValueType).click();
                        } else if (trainingItems[i].transitionScenes[j].sceneId !== 'unselected') {
                            appendAlert(item, ALERT_ASSEMBLED_SCENE_REMOVED);
                        }

                        if (j > 0 && j < trainingItems[i].transitionScenes.length - 1) {
                            $(item).find('.transition-mode').removeClass('hidden');
                            $(item).find('.transition-mode #' + trainingItems[i].transitionScenes[j].transitionMode).click();
                            if (trainingItems[i].transitionScenes[j].transitionMode === 'automatically') {
                                $(item).find('.transition-time-stepper').removeClass('hidden');
                            }
                            $(item).find('.transition-time-stepper .stepper-text').val(trainingItems[i].transitionScenes[j].transitionTime);
                        }
                    }
                    checkCurrentListState($(clone).find('.transition-scenes-option-container'));
                }

                initAddTransitionSceneButton(clone, formatClone);
            }

            updateBadges(container, 'gestureTrainingItem');
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
//        training.title = $(formatClone).find('#trainingTitle').val();
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
                if (feedbackId === 'unselected') {
                    feedbackId = 'none';
                }
                var feedbackTransitionMode = $(item).find('.transitionFeedback-mode .btn-option-checked').attr('id');
                var feedbackTransitionTime = $(item).find('.transitionFeedback-time-stepper .stepper-text').val();

                var transitionScenes = [];
                var transitionItems = $(item).find('.transition-scenes-option-container').children();
                for (var j = 0; j < transitionItems.length; j++) {
                    var object = {sceneId: $(transitionItems[j]).find('.sceneSelect .chosen').attr('id')};
                    if (j > 0 && j < transitionItems.length - 1) {
                        object.transitionMode = $(transitionItems[j]).find('.transition-mode .btn-option-checked').attr('id');
                        if (object.transitionMode === 'automatically') {
                            object.transitionTime = $(transitionItems[j]).find('.stepper-text').val();
                        }
                    }
                    transitionScenes.push(object);
                }


                var repeats = $(item).find('#repeats-stepper .stepper-text').val();
                var recognitionTime = $(item).find('#recognition-stepper .stepper-text').val();
                if (gesture && trigger) {
                    set.push({gestureId: gestureId,
                        triggerId: triggerId,
                        feedbackId: feedbackId,
                        repeats: repeats,
                        recognitionTime: recognitionTime,
                        feedbackTransitionMode: feedbackTransitionMode,
                        feedbackTransitionTime: feedbackTransitionTime,
                        transitionScenes: transitionScenes
                    });
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
            var item = $('#form-item-container').find('#gestureTrainingItem').clone();
            tweenAndAppend(item, $(this), $(formatClone), $(formatClone).find('#training .option-container'), 'gestureTrainingItem', true);
            initTransitionFeedbackMode(item, formatClone);
            initAddTransitionSceneButton(item, formatClone);

            setTimeout(function () {
                $(item).find('.btn-expand').click();
            }, 400);
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
    initQuestionnairePreview($(formatClone).find('#observations .btn-preview-questionnaire'), $(formatClone).find('#observations #list-container'), true);

//    function initTransitionFeedbackMode(item) {
//        $(item).find('.feedbackSelect').unbind('change').bind('change', function (event) {
//            var selectedId = $(this).find('.chosen').attr('id');
//            if (selectedId === 'unselected' || selectedId === 'none') {
//                $(item).find('.transitionFeedback-mode').addClass('hidden');
//                $(item).find('.transitionFeedback-time-stepper').addClass('hidden');
//            } else {
//                $(item).find('.transitionFeedback-mode').removeClass('hidden');
//                if ($(item).find('.transitionFeedback-mode .btn-option-checked').attr('id') === 'automatically') {
//                    $(item).find('.transitionFeedback-time-stepper').removeClass('hidden');
//                } else {
//                    $(item).find('.transitionFeedback-time-stepper').addClass('hidden');
//                }
//            }
//        });
//
//        $(item).find('.transitionFeedback-mode').unbind('change').bind('change', function (event) {
////            console.log('feedback transition mode changed', $(this).find('.btn-option-checked').attr('id'));
//            event.preventDefault();
//            var selectedId = $(item).find('.feedbackSelect .chosen').attr('id');
//            if ($(this).find('.btn-option-checked').attr('id') === 'automatically' && selectedId !== 'unselected' && selectedId !== 'none') {
//                $(this).closest('.row').find('.transitionFeedback-time-stepper').removeClass('hidden');
//            } else {
//                $(this).closest('.row').find('.transitionFeedback-time-stepper').addClass('hidden');
//            }
//
//            resetDynamicAffixScrolling(formatClone);
//        });
//    }

//    function initAddTransitionSceneButton(clone) {
//        var scenes = getLocalItem(ASSEMBLED_SCENES);
//        if (scenes === null) {
//            $(clone).find('.btn-add-transition-scene').addClass('disabled');
//            appendAlert($(clone).find('#scenes'), ALERT_NO_SCENES_ASSEMBLED_LINK);
//
//            $(formatClone).find('#btn-assemble-scenes').on('click', function (event) {
//                event.preventDefault();
//                $(formatClone).find('.btn-close-overlay').click();
//                $('.mainContent').find('#catalogs #scenes-catalog .btn-open-overlay').click();
//            });
//        }
//
//        $(clone).find('.btn-add-transition-scene').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (event.handled !== true && !$(this).hasClass('disabled'))
//            {
//                event.handled = true;
//                clearAlerts($(clone).find('#scenes'));
//                var item = $('#form-item-container').find('#woz-transition-scene-option').clone().removeAttr('id');
//                tweenAndAppend(item, $(this), $(clone), $(clone).find('#scenes .transition-scenes-option-container'), null, true);
//            }
//        });
//
//        initQuestionnaireListChange(formatClone, $(clone).find('.transition-scenes-option-container'), clone.find('#scenes'));
//        initQuestionnaireListItemAdded($(clone).find('.transition-scenes-option-container'), clone);
//        $(clone).find('.transition-scenes-option-container').on('listItemAdded change', function (event) {
//            event.stopImmediatePropagation();
//            var optionItems = $(this).children();
//            $(optionItems).find('.transition-mode').removeClass('hidden');
//            $(optionItems).first().find('.transition-mode').addClass('hidden');
//            $(optionItems).last().find('.transition-mode').addClass('hidden');
//            $(optionItems).first().find('.transition-time-stepper').addClass('hidden');
//            $(optionItems).last().find('.transition-time-stepper').addClass('hidden');
//            resetDynamicAffixScrolling(formatClone);
//        });
//
//        $(clone).find('.transition-mode').unbind('change').bind('change', function (event) {
////            console.log('transition mode changed', $(this).find('.btn-option-checked').attr('id'));
//            event.preventDefault();
//            if ($(this).find('.btn-option-checked').attr('id') === 'automatically') {
//                $(this).closest('.row').find('.transition-time-stepper').removeClass('hidden');
//            } else {
//                $(this).closest('.row').find('.transition-time-stepper').addClass('hidden');
//            }
//
//            resetDynamicAffixScrolling(formatClone);
//        });
//    }
}

function initScenarioOverlay(id, formatClone) {
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    renderDimensions($(formatClone).find('#dimension-controls'), translation.observationsScenario, $(formatClone).find('#observations #list-container'), translation.dimensions);
    initQuestionnaireButtonGroup(formatClone, $(formatClone).find('#add-observation-button-group'), $(formatClone).find('#observations #list-container'), $(formatClone).find('#observations'), true, true, ALERT_NO_DATA_QUESTIONNAIRE);
    initQuestionnaireDimensionControl(formatClone, $(formatClone).find('#dimension-controls'), $(formatClone).find('#list-container'), $(formatClone).find('#observations'));
//    initToggleSwitch(formatClone, $(formatClone).find('#useWOZSwitch'), $(formatClone).find('#wozExperiment'));
//    initToggleSwitch(formatClone, $(formatClone).find('#useWorstCasesSwitch'), $(formatClone).find('#worstCases'));
    initToggleSwitch(formatClone, $(formatClone).find('#useHelpSwitch'), $(formatClone).find('#help'));
    initToggleSwitch(formatClone, $(formatClone).find('#useObservationsSwitch'), $(formatClone).find('#observations'));
    var scenes = getLocalItem(ASSEMBLED_SCENES);
    renderAssembledScenes($(formatClone).find('#start-scene-select'));
    renderAssembledScenes();
    if (scenes === null) {
        appendAlert($(formatClone).find('#wozExperiment'), ALERT_NO_SCENES_ASSEMBLED_LINK);
        $(formatClone).find('#wozExperiment .btn-add-woz-experimentOption').addClass('hidden');
//        $(formatClone).find('#help .btn-add-helpOption').addClass('hidden');
        $(formatClone).find('#btn-assemble-scenes').on('click', function (event) {
            event.preventDefault();
            $(formatClone).find('.btn-close-overlay').click();
            $('.mainContent').find('#catalogs #scenes-catalog .btn-open-overlay').click();
        });
    }

//    renderAssembledGestures(null, [{id: 'wrongGesture', title: translation.wrongGesture}]);
    renderAssembledGestures();
    if (!assembledGestures()) {
        appendAlert($(formatClone).find('#wozExperiment'), ALERT_NO_STUDY_GESTURES_ASSEMBLED_LINK);
        $(formatClone).find('#wozExperiment .btn-add-woz-experimentOption').addClass('hidden');
        $(formatClone).find('#btn-assemble-study-gesture-set').on('click', function (event) {
            event.preventDefault();
            $(formatClone).find('.btn-close-overlay').click();
            $('.mainContent').find('#catalogs #gestures-catalog .btn-open-overlay').click();
        });
    }

    var trigger = getLocalItem(ASSEMBLED_TRIGGER);
    renderAssembledTriggers();
    if (!trigger) {
        appendAlert($(formatClone).find('#wozExperiment'), ALERT_NO_TRIGGER_ASSEMBLED_LINK);
        $(formatClone).find('#wozExperiment .btn-add-woz-experimentOption').addClass('hidden');
        $(formatClone).find('#btn-assemble-trigger').on('click', function (event) {
            event.preventDefault();
            $(formatClone).find('.btn-close-overlay').click();
            $('.mainContent').find('#catalogs #trigger-catalog .btn-open-overlay').click();
        });
    }

//    var feedback = getLocalItem(ASSEMBLED_FEEDBACK);
    renderAssembledFeedback(null, [{id: 'none', title: translation.none}]);
//    if (!feedback) {
//        appendAlert($(formatClone).find('#wozExperiment'), ALERT_NO_FEEDBACK_ASSEMBLED_LINK);
//        $(formatClone).find('#wozExperiment .btn-add-woz-experimentOption').addClass('hidden');
//    }

    var data = getLocalItem(id + '.data');
    if (data) {
        renderData(data);
    } else {
        appendAlert($(formatClone).find('#tasks-container'), ALERT_NO_PHASE_DATA);
        appendAlert($(formatClone).find('#help'), ALERT_NO_PHASE_DATA);
    }

    renderTaskAssessments(data);
    initDynamicAffixScrolling(formatClone);

    function renderData(data)
    {
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
        var tasks = data.tasks;


        if (tasks && tasks.length > 0) {
            for (var i = 0; i < tasks.length; i++) {
                var wozItems = tasks[i].woz;

                var taskItem = $('#form-item-container').find('#taskItem').clone();
                $(taskItem).find('#taskTitle').val(tasks[i].title);
                $(taskItem).find('#task').val(tasks[i].task);
                if (!tasks[i].id) {
                    $(taskItem).attr('data-id', chance.natural());
                } else {
                    $(taskItem).attr('data-id', tasks[i].id);
                }
                $(formatClone).find('#tasks-container .task-option-container').append(taskItem);

                initAddWOZButton(taskItem);
//                initExpandTaskButton(taskItem);
                initTaskTitleChange(taskItem);

                if (wozItems && wozItems.length > 0) {
                    container = $(taskItem).find('#woz-item-container .option-container');
                    for (var j = 0; j < wozItems.length; j++) {
                        var clone = $('#form-item-container').find('#wozExperimentItem').clone().removeAttr('id');
                        $(clone).removeAttr('id');
                        container.append(clone);
                        var gesture = getGestureById(wozItems[j].gestureId);
                        if (gesture && isGestureAssembled(gesture.id)) {
                            $(clone).find('.gestureSelect #' + gesture.id).click();
                        } else {
                            appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                        }

                        $(clone).find('.invert-continuous-values #' + wozItems[j].invertValues).click();

                        var trigger = getTriggerById(wozItems[j].triggerId);
                        if (trigger && getTriggerById(trigger.id) !== null) {
                            $(clone).find('.triggerSelect #' + trigger.id).click();
                        } else {
                            appendAlert(clone, ALERT_ASSEMBLED_TRIGGER_REMOVED);
                        }

                        initTransitionFeedbackMode(clone, formatClone);
                        if (wozItems[j].feedbackId === 'none') {
                            $(clone).find('.feedbackSelect #none').click();
                        } else {
                            var feedback = getFeedbackById(wozItems[j].feedbackId);
                            if (feedback) {
                                $(clone).find('.feedbackSelect #' + feedback.id).click();
                            } else {
                                appendAlert(clone, ALERT_ASSEMBLED_FEEDBACK_REMOVED);
                            }
                        }

                        $(clone).find('.transitionFeedback-mode #' + wozItems[j].feedbackTransitionMode).click();
                        $(clone).find('.transitionFeedback-time-stepper .stepper-text').val(wozItems[j].feedbackTransitionTime);
                        if (wozItems[j].transitionScenes && wozItems[j].transitionScenes.length > 0) {
                            for (var k = 0; k < wozItems[j].transitionScenes.length; k++) {
                                scene = getSceneById(wozItems[j].transitionScenes[k].sceneId);
                                var item = $('#form-item-container').find('#woz-transition-scene-option').clone().removeAttr('id');
                                $(item).attr('id', wozItems[j].transitionScenes[k].id || chance.natural());
                                $(clone).find('.transition-scenes-option-container').append(item);
                                initTransitionWOZSceneSelect(item);
                                if (scene) {
                                    $(item).find('.sceneSelect #' + scene.id).click();
                                    if (scene.type === SCENE_PIDOCO) {
                                        $(item).find('.event-bus-settings').removeClass('hidden');
                                    }
                                    $(item).find('.use-event-bus #' + wozItems[j].transitionScenes[k].useEventBus).click();
                                    $(item).find('.continuous-value-type #' + wozItems[j].transitionScenes[k].continuousValueType).click();
                                } else if (wozItems[j].transitionScenes[k].sceneId !== 'unselected') {
                                    appendAlert(item, ALERT_ASSEMBLED_SCENE_REMOVED);
                                }

                                if (k > 0 && k < wozItems[j].transitionScenes.length - 1) {
                                    $(item).find('.transition-mode').removeClass('hidden');
                                    $(item).find('.transition-mode #' + wozItems[j].transitionScenes[k].transitionMode).click();
                                    if (wozItems[j].transitionScenes[k].transitionMode === 'automatically') {
                                        $(item).find('.transition-time-stepper').removeClass('hidden');
                                    }
                                    $(item).find('.transition-time-stepper .stepper-text').val(wozItems[j].transitionScenes[k].transitionTime);
                                }
                            }
                            checkCurrentListState($(clone).find('.transition-scenes-option-container'));
                        }
                        initAddTransitionSceneButton(clone, formatClone);
                    }
                    checkCurrentListState(container);
                }
            }

            updateBadges($(formatClone).find('#tasks-container .task-option-container'), 'taskItem');
            renderAssembledTasks(getAssembledTasks());
            checkCurrentListState($(formatClone).find('#tasks-container .task-option-container'));
//            $(formatClone).find('#tasks-container .task-option-container .panel-body').addClass('hidden');
//            $(formatClone).find('#tasks-container .task-option-container .btn-expand').removeClass('hidden');
        } else {
            appendAlert($(formatClone).find('#tasks-container'), ALERT_NO_PHASE_DATA);
        }

        var helpItems = data.help;
        if (helpItems && helpItems.length > 0) {

            $(formatClone).find('#useHelpSwitch #yes').click();
            container = $(formatClone).find('#help .option-container');
            for (var i = 0; i < helpItems.length; i++) {

                var clone = $('#form-item-container').find('#helpItem').clone().removeClass('id');
                clone.find('.option-text').val(helpItems[i].option);
                $(container).append(clone);

                var task = getTaskById(helpItems[i].taskId);
                if (task) {
                    $(clone).find('.taskSelect #' + task.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_TASK_REMOVED);
                }

                var scene = getSceneById(helpItems[i].sceneId);
                if (scene) {
                    $(clone).find('.sceneSelect #' + scene.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_SCENE_REMOVED);
                }

                initGestureHelpSwitchChange(clone);
                if (helpItems[i].useGestureHelp === true || helpItems[i].useGestureHelp === 'true') {
                    $(clone).find('.useGestureHelpSwitch #yes').click();
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

            updateBadges(container, 'helpItem');
            checkCurrentListState(container);
        } else {
            appendAlert($(formatClone).find('#help'), ALERT_NO_PHASE_DATA);
        }

        renderObservations(formatClone, data.observations);
    }

    function renderTaskAssessments(data) {
        var container = $(formatClone).find('#wozExperiment .option-container');

        var taskAssessments = translation.taskAssessments;
        if (data) {
            taskAssessments = data.taskAssessments;

            if (!taskAssessments) {
                taskAssessments = translation.taskAssessments;
            } else if (taskAssessments) {
                if ($.isEmptyObject(taskAssessments)) {
                    appendAlert($(formatClone).find('#task-assessment-container'), ALERT_NO_PHASE_DATA);
                }
            }
        }

        if (taskAssessments) {
            container = $(formatClone).find('#task-assessment-container .option-container');
            for (var assessment in taskAssessments) {
                var clone = $('#form-item-container').find('#task-assessment-item').clone().removeClass('id');
                $(container).append(clone);
                $(clone).find('.input-title').val(taskAssessments[assessment].title);
                $(clone).find('.assessmentTriggerSelect #' + taskAssessments[assessment].trigger).click();
                $(clone).attr('data-assessment-id', assessment);
                $(clone).find('.color-selector .' + taskAssessments[assessment].annotationColor).click();
            }

            updateBadges(container, 'task-assessment-item');
            checkCurrentListState(container);
        }
    }

    function getTaskById(id) {
        var tasks = getAssembledTasks();
        for (var i = 0; i < tasks.length; i++) {
            if (parseInt(id) === parseInt(tasks[i].id)) {
                return tasks[i];
            }
        }
        return null;
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        $(formatClone).find('#btn-save-phase-step-title').click();
        var scenario = new Object();
//        scenario.title = $(formatClone).find('#scenarioTitle').val();
        scenario.description = $(formatClone).find('#scenarioDescription').val();
        if ($(formatClone).find('#general .sceneSelect .chosen').attr('id') !== 'unselected') {
            scenario.scene = $(formatClone).find('#general .sceneSelect .chosen').attr('id');
        }

        var taskItems = $(formatClone).find('#tasks-container .task-option-container').children();
        var tasks = new Array();
        for (var i = 0; i < taskItems.length; i++) {
            var taskItem = taskItems[i];
            var task = {};
            task.title = $(taskItem).find('#taskTitle').val().trim();
            task.task = $(taskItem).find('#task').val().trim();
            task.id = $(taskItem).attr('data-id');

            var wozItems = $(taskItem).find('#woz-item-container .option-container').children();
            var woz = new Array();
            for (var j = 0; j < wozItems.length; j++) {
                var item = wozItems[j];
                var triggerId = $(item).find('.triggerSelect .chosen').attr('id');
                var trigger = getTriggerById(triggerId);
                var gestureId = $(item).find('.gestureSelect .chosen').attr('id');
                var gesture = getGestureById(gestureId);
                var invertContinuousValues = $(item).find('.invert-continuous-values .btn-option-checked').attr('id');
//                console.log('continuousValueType', continuousValueType);

                var feedbackId = $(item).find('.feedbackSelect .chosen').attr('id');
                if (feedbackId === 'unselected') {
                    feedbackId = 'none';
                }
                var feedbackTransitionMode = $(item).find('.transitionFeedback-mode .btn-option-checked').attr('id');
                var feedbackTransitionTime = $(item).find('.transitionFeedback-time-stepper .stepper-text').val();
                var transitionScenes = [];
                var transitionItems = $(item).find('.transition-scenes-option-container').children();
                for (var k = 0; k < transitionItems.length; k++) {
                    var object = {id: $(transitionItems[k]).attr('id'), sceneId: $(transitionItems[k]).find('.sceneSelect .chosen').attr('id')};
                    if (k > 0 && k < transitionItems.length - 1) {
                        object.transitionMode = $(transitionItems[k]).find('.transition-mode .btn-option-checked').attr('id');

                        if (object.transitionMode === 'automatically') {
                            object.transitionTime = $(transitionItems[k]).find('.stepper-text').val();
                        }
                    }

                    object.useEventBus = $(transitionItems[k]).find('.use-event-bus .btn-option-checked').attr('id');
                    if (object.useEventBus === 'yes') {
                        object.continuousValueType = $(transitionItems[k]).find('.continuous-value-type .btn-option-checked').attr('id');
                    }

                    transitionScenes.push(object);
                }

                if (trigger && gesture && transitionScenes.length > 0) {
                    woz.push({triggerId: triggerId,
                        gestureId: gestureId,
                        invertValues: invertContinuousValues,
//                        useEventBus: useEventBus,
//                        continuousValueType: continuousValueType,
                        feedbackId: feedbackId,
                        feedbackTransitionMode: feedbackTransitionMode,
                        feedbackTransitionTime: feedbackTransitionTime,
                        transitionScenes: transitionScenes});
                }
            }

            task.woz = woz;

            if (task.title !== '' && task.task !== '') {
                tasks.push(task);
            }
        }

        scenario.tasks = tasks;

        var assessmentItems = $(formatClone).find('#task-assessment-container .option-container').children();
        var assessments = new Object();
        for (var i = 0; i < assessmentItems.length; i++) {
            var item = $(assessmentItems[i]);
            var title = $(item).find('.input-title').val().trim();
            var selected = $(item).find('.assessmentTriggerSelect .chosen').attr('id');
            if (title !== '' && selected !== 'unselected') {
                assessments[$(item).attr('data-assessment-id')] = {title: title, trigger: selected, annotationColor: $(item).find('.color-selector .selected').attr('data-id')};
            }
        }

        scenario.taskAssessments = assessments;

        var helpItems = $(formatClone).find('#help .option-container').children();
        if ($(formatClone).find('#useHelpSwitch #yes').hasClass('active'))
        {
            var scenarioHelp = new Array();
            for (var i = 0; i < helpItems.length; i++) {
                var item = helpItems[i];
                var help = new Object();
                help.taskId = $(item).find('.taskSelect .chosen').attr('id');
                help.sceneId = $(item).find('.sceneSelect .chosen').attr('id');
                help.option = $(item).find('.option-text').val().trim();
                var showGesture = $(item).find('.useGestureHelpSwitch .btn-option-checked').attr('id') === 'yes' ? true : false;
                help.useGestureHelp = showGesture;
                help.gestureId = showGesture === true ? $(item).find('.gestureSelect .chosen').attr('id') : null;
                if (help.taskId && getSceneById(help.sceneId) && help.option !== "") {
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

    function getAssembledTasks() {
        var taskItems = $(formatClone).find('#tasks-container .task-option-container').children();
        var tasks = new Array();

        for (var i = 0; i < taskItems.length; i++) {
            var task = {};
            task.title = $(taskItems[i]).find('#taskTitle').val().trim();
            task.id = $(taskItems[i]).attr('data-id');
            tasks.push(task);
        }
        return tasks;
    }

    $(formatClone).find('.btn-add-taskOption').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (event.handled !== true)
        {
            event.handled = true;
            clearAlerts($(formatClone).find('#tasks-container'));
            var item = $('#form-item-container').find('#taskItem').clone();
//            $(formatClone).find('#tasks-container .task-option-container .panel-body').addClass('hidden');
//            $(formatClone).find('#tasks-container .task-option-container .btn-expand').removeClass('hidden');
            $(item).attr('data-id', chance.natural());
//            $(item).find('.btn-expand').addClass('hidden');
            tweenAndAppend(item, $(this), $(formatClone), $(formatClone).find('#tasks-container .task-option-container'), 'taskItem', true);
            initAddWOZButton(item);
//            initExpandTaskButton(item);
            initTaskTitleChange(item);

            setTimeout(function () {
                $(item).find('.btn-expand').click();
            }, 400);
        }
    });

    initQuestionnaireListChange(formatClone, $(formatClone).find('#tasks-container .task-option-container'), $(formatClone).find('#tasks-container'), ALERT_NO_PHASE_DATA);
    initQuestionnaireListItemAdded($(formatClone).find('#tasks-container .task-option-container'), $(formatClone).find('#tasks-container'));

    function initTaskTitleChange(item) {
        setInputChangeEvent(item.find('#taskTitle'), 1000);
        $(item).find('#taskTitle').unbind('change').bind('change', function (event) {
            event.preventDefault();
            renderAssembledTasks(getAssembledTasks(), $(formatClone).find('#help .option-container'));
        });
    }

//    function initExpandTaskButton(item) {
//        $(item).find('.btn-expand').bind('click', function (event) {
//            event.preventDefault();
//            if ($(this).closest('.root').find('.panel-body').hasClass('hidden')) {
//                $(this).closest('.task-option-container').find('.panel-body').addClass('hidden');
//                $(this).closest('.task-option-container').find('.btn-expand').removeClass('hidden');
//                $(this).closest('.root').find('.panel-body').removeClass('hidden');
//                $(this).closest('.root').find('.btn-expand').addClass('hidden');
//            }
//        });
//    }

    $(formatClone).find('.btn-add-taskAssessmentOption').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (event.handled !== true)
        {
            event.handled = true;
            clearAlerts($(formatClone).find('#task-assessment-container'));
            var item = $('#form-item-container').find('#task-assessment-item').clone();
            $(item).attr('data-assessment-id', chance.natural());
            tweenAndAppend(item, $(this), $(formatClone), $(formatClone).find('#task-assessment-container .option-container'), 'task-assessment-item', true);
            $(item).find('.color-selector .darkblue').addClass('selected');

            setTimeout(function () {
                $(item).find('.btn-expand').click();
            }, 400);
        }
    });

    initQuestionnaireListChange(formatClone, $(formatClone).find('#task-assessment-container .option-container'), $(formatClone).find('#task-assessment-container'), ALERT_NO_PHASE_DATA);
    initQuestionnaireListItemAdded($(formatClone).find('#task-assessment-container .option-container'), $(formatClone).find('#task-assessment-container'));

    function initAddWOZButton(taskItem) {
        $(taskItem).find('.btn-add-woz-experimentOption').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (event.handled !== true)
            {
                event.handled = true;
                clearAlerts($(taskItem).find('#woz-item-container'));
                var item = $('#form-item-container').find('#wozExperimentItem').clone().removeAttr('id');
                tweenAndAppend(item, $(this), $(formatClone), $(taskItem).find('#woz-item-container .option-container'), null, true);
                initTransitionFeedbackMode(item, formatClone);
                initAddTransitionSceneButton(item, formatClone);
                $(item).find('.btn-add-transition-scene').click();
            }
        });

        initQuestionnaireListChange(taskItem, $(taskItem).find('#woz-item-container .option-container'), $(taskItem).find('#woz-item-container'), ALERT_NO_PHASE_DATA);
        initQuestionnaireListItemAdded($(taskItem).find('#woz-item-container .option-container'), $(taskItem).find('#woz-item-container'));
        initAddTransitionSceneButton(taskItem, formatClone);
    }

    $(formatClone).find('.btn-add-helpOption').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (event.handled !== true)
        {
            renderAssembledTasks(getAssembledTasks());
            event.handled = true;
            clearAlerts($(formatClone).find('#help'));
            var item = $('#form-item-container').find('#helpItem').clone();
            tweenAndAppend(item, $(this), $(formatClone), $(formatClone).find('#help .option-container'), 'helpItem', true);
            initGestureHelpSwitchChange(item);

            setTimeout(function () {
                $(item).find('.btn-expand').click();
            }, 400);
        }
    });

    initQuestionnaireListChange(formatClone, $(formatClone).find('#help .option-container'), $(formatClone).find('#help'), ALERT_NO_PHASE_DATA);
    initQuestionnaireListItemAdded($(formatClone).find('#help .option-container'), $(formatClone).find('#help'));

    function initGestureHelpSwitchChange(clone) {
        $(clone).find('.useGestureHelpSwitch').unbind('change').bind('change', function (event) {
            event.preventDefault();
            var activeId = $(this).find('.btn-option-checked').attr('id');
            if (!assembledGestures()) {
                if (activeId === 'yes') {
                    appendAlert($(this).closest('.root'), ALERT_NO_STUDY_GESTURES_ASSEMBLED_LINK);
                } else {
                    removeAlert($(this).closest('.root'), ALERT_NO_STUDY_GESTURES_ASSEMBLED_LINK);
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

    initQuestionnairePreview($(formatClone).find('#observations .btn-preview-questionnaire'), $(formatClone).find('#observations #list-container'), true);
}

/*
 * transition scene specific functions
 */

function initTransitionWOZSceneSelect(target) {
    $(target).find('.sceneSelect').unbind('change').bind('change', function (event) {
        event.preventDefault();
        var sceneId = $(this).find('.chosen').attr('id');
        var scene = getSceneById(sceneId);
        if (scene.type === SCENE_PIDOCO) {
            $(target).find('.event-bus-settings').removeClass('hidden');
        } else {
            $(target).find('.event-bus-settings').addClass('hidden');
        }
    });

    $(target).find('.use-event-bus').unbind('change').bind('change', function (event) {
        event.preventDefault();
        var selectedId = $(this).find('.btn-option-checked').attr('id');
        if (selectedId === 'yes') {
            $(target).find('.continuous-value-type').removeClass('hidden');
        } else {
            $(target).find('.continuous-value-type').addClass('hidden');
        }
    });
}

function initTransitionFeedbackMode(item, formatClone) {
    $(item).find('.feedbackSelect').unbind('change').bind('change', function (event) {
        var selectedId = $(this).find('.chosen').attr('id');
        if (selectedId === 'unselected' || selectedId === 'none') {
            $(item).find('.transitionFeedback-mode').addClass('hidden');
            $(item).find('.transitionFeedback-time-stepper').addClass('hidden');
        } else {
            $(item).find('.transitionFeedback-mode').removeClass('hidden');
            if ($(item).find('.transitionFeedback-mode .btn-option-checked').attr('id') === 'automatically') {
                $(item).find('.transitionFeedback-time-stepper').removeClass('hidden');
            } else {
                $(item).find('.transitionFeedback-time-stepper').addClass('hidden');
            }
        }
    });

    $(item).find('.transitionFeedback-mode').unbind('change').bind('change', function (event) {
        event.preventDefault();
        var selectedId = $(item).find('.feedbackSelect .chosen').attr('id');
        if ($(this).find('.btn-option-checked').attr('id') === 'automatically' && selectedId !== 'unselected' && selectedId !== 'none') {
            $(this).closest('.row').find('.transitionFeedback-time-stepper').removeClass('hidden');
        } else {
            $(this).closest('.row').find('.transitionFeedback-time-stepper').addClass('hidden');
        }

        resetDynamicAffixScrolling(formatClone);
    });
}

function initAddTransitionSceneButton(clone, formatClone) {
    $(clone).find('.btn-add-transition-scene').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (event.handled !== true)
        {
            event.handled = true;
            clearAlerts($(clone).find('#scenes'));
            var item = $('#form-item-container').find('#woz-transition-scene-option').clone().removeAttr('id');
            $(item).attr('data-id', chance.natural());
            tweenAndAppend(item, $(this), $(clone), $(clone).find('#scenes .transition-scenes-option-container'), null, true);
            initSceneTransitionMode(clone);
            initTransitionWOZSceneSelect(item);
        }
    });

    initQuestionnaireListChange(formatClone, $(clone).find('.transition-scenes-option-container'), clone.find('#scenes'), ALERT_NO_PHASE_DATA);
    initQuestionnaireListItemAdded($(clone).find('.transition-scenes-option-container'), clone);
    initSceneTransitionMode(clone);

    $(clone).find('.transition-scenes-option-container').on('listItemAdded change', function (event) {
        event.stopImmediatePropagation();
        var optionItems = $(this).children();
        $(optionItems).find('.transition-mode').removeClass('hidden');
        $(optionItems).first().find('.transition-mode').addClass('hidden');
        $(optionItems).last().find('.transition-mode').addClass('hidden');
        $(optionItems).first().find('.transition-time-stepper').addClass('hidden');
        $(optionItems).last().find('.transition-time-stepper').addClass('hidden');
        resetDynamicAffixScrolling(formatClone);
    });

    function initSceneTransitionMode(clone) {
        $(clone).find('.transition-mode').unbind('change').bind('change', function (event) {
            event.preventDefault();
            if ($(this).find('.btn-option-checked').attr('id') === 'automatically') {
                $(this).closest('.row').find('.transition-time-stepper .stepper-text').attr('value', 1);
                $(this).closest('.row').find('.transition-time-stepper .stepper-text').val(1);
                $(this).closest('.row').find('.transition-time-stepper').removeClass('hidden');
            } else {
                $(this).closest('.row').find('.transition-time-stepper').addClass('hidden');
            }

            resetDynamicAffixScrolling(formatClone);
        });
    }
}



/*
 * gesture slideshow
 */

function initGestureSlideshowOverlay(id, formatClone) {
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    renderDimensions($(formatClone).find('#dimension-controls'), translation.observationsGestureSlideshow, $(formatClone).find('#observations #list-container'), translation.dimensions);
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
//        $(formatClone).find('#slideshowTitle').val(data.title);
        $(formatClone).find('#slideshowDescription').val(data.description);
        $(formatClone).find('#answerTime').val(data.answerTime);
        var container = $(formatClone).find('#slideshow .option-container');
        if (slideshowItems !== undefined && slideshowItems.length > 0) {
            for (var i = 0; i < slideshowItems.length; i++) {
                var gesture = getGestureById(slideshowItems[i].gestureId);
                var trigger = getTriggerById(slideshowItems[i].triggerId);
                var clone = $('#form-item-container').find('#slideshow-gesture-item').clone();
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

            updateBadges(container, 'slideshow-gesture-item');
            checkCurrentListState(container);
        } else {
            appendAlert($(formatClone).find('#slideshow'), ALERT_NO_PHASE_DATA);
        }

        renderObservations(formatClone, data.observations);
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        $(formatClone).find('#btn-save-phase-step-title').click();
        var slideshow = new Object();
//        slideshow.title = $(formatClone).find('#slideshowTitle').val();
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
            var item = $('#form-item-container').find('#slideshow-gesture-item').clone();
            tweenAndAppend(item, $(this), $(formatClone), $(formatClone).find('#slideshow .option-container'), 'slideshow-gesture-item', true);

            setTimeout(function () {
                $(item).find('.btn-expand').click();
            }, 400);
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
    initQuestionnairePreview($(formatClone).find('#observations .btn-preview-questionnaire'), $(formatClone).find('#observations #list-container'), true);
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
//        $(formatClone).find('#slideshowTitle').val(data.title);
        $(formatClone).find('#slideshowDescription').val(data.description);
        var container = $(formatClone).find('#slideshow .option-container');
        if (slideshowItems !== undefined && slideshowItems.length > 0) {
            for (var i = 0; i < slideshowItems.length; i++) {
                var gesture = getGestureById(slideshowItems[i].gestureId);
                var trigger = getTriggerById(slideshowItems[i].triggerId);
                var clone = $('#form-item-container').find('#slideshow-trigger-item').clone();
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

            updateBadges(container, 'slideshow-trigger-item');
            checkCurrentListState(container);
        } else {
            appendAlert($(formatClone).find('#slideshow'), ALERT_NO_PHASE_DATA);
        }

        renderObservations(formatClone, data.observations);
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        $(formatClone).find('#btn-save-phase-step-title').click();
        var slideshow = new Object();
//        slideshow.title = $(formatClone).find('#slideshowTitle').val();
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
            var item = $('#form-item-container').find('#slideshow-trigger-item').clone();
            tweenAndAppend(item, $(this), $(formatClone), $(formatClone).find('#slideshow .option-container'), 'slideshow-trigger-item', true);

            setTimeout(function () {
                $(item).find('.btn-expand').click();
            }, 400);
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
    initQuestionnairePreview($(formatClone).find('#observations .btn-preview-questionnaire'), $(formatClone).find('#observations #list-container'));
}

function initPhysicalStressTestOverlay(id, formatClone) {
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    renderDimensions($(formatClone).find('#observations #dimension-controls'), translation.observationsPhysicalStressTest, $(formatClone).find('#observations #list-container'), translation.dimensions);
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
        appendAlert($(formatClone).find('#stressTest'), ALERT_NO_PHASE_DATA);
        appendAlert($(formatClone).find('#singleStressQuestions'), ALERT_NO_DATA_QUESTIONNAIRE);
        appendAlert($(formatClone).find('#sequenceStressQuestions'), ALERT_NO_DATA_QUESTIONNAIRE);
        appendAlert($(formatClone).find('#observations'), ALERT_NO_DATA_QUESTIONNAIRE);
    }

    initDynamicAffixScrolling(formatClone);
    function renderData(data)
    {
        var items = data.stressTestItems;
//        $(formatClone).find('#stressTestTitle').val(data.title);
        $(formatClone).find('#stressTestDescription').val(data.description);
        $(formatClone).find('#randomizeSwitch #' + (data.randomized === true ? 'yes' : 'no')).click();
        $(formatClone).find('#totalStressAmount').val(data.stressAmount);
        var container = $(formatClone).find('#stressTest .option-container');
        if (items !== undefined && items.length > 0) {
            for (var i = 0; i < items.length; i++) {
                var gesture = getGestureById(items[i]);
                var clone = $('#form-item-container').find('#physicalStressTestItem').clone().removeClass('hidden');
                container.append(clone);
                if (gesture && isGestureAssembled(gesture.id)) {
                    $(clone).find('.gestureSelect #' + gesture.id).click();
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                }
            }

            updateBadges(container, 'physicalStressTestItem');
            checkCurrentListState(container);
        } else {
            appendAlert($(formatClone).find('#stressTest'), ALERT_NO_PHASE_DATA);
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
        } else {
            appendAlert($(formatClone).find('#singleStressQuestions'), ALERT_NO_DATA_QUESTIONNAIRE);
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
        } else {
            appendAlert($(formatClone).find('#sequenceStressQuestions'), ALERT_NO_DATA_QUESTIONNAIRE);
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
            var item = $('#form-item-container').find('#physicalStressTestItem').clone();
            tweenAndAppend(item, $(this), $(formatClone), $(formatClone).find('#stressTest .option-container'), 'physicalStressTestItem', true);

            setTimeout(function () {
                $(item).find('.btn-expand').click();
            }, 400);
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
    initQuestionnairePreview($(formatClone).find('#singleStressQuestions .btn-preview-questionnaire'), $(formatClone).find('#singleStressQuestions #list-container'));
    initQuestionnairePreview($(formatClone).find('#sequenceStressQuestions .btn-preview-questionnaire'), $(formatClone).find('#sequenceStressQuestions #list-container'));
    initQuestionnairePreview($(formatClone).find('#observations .btn-preview-questionnaire'), $(formatClone).find('#observations #list-container'), true);
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
            if (trigger && trigger.length > 0) {
                renderAssembledTriggers();
                $(container).find('.btn-add-identificationOption').removeClass('disabled');
            } else {
                if (!trigger || trigger.length === 0) {
                    appendAlert(container, ALERT_NO_TRIGGER_ASSEMBLED_LINK);
                    $(formatClone).find('#btn-assemble-trigger').on('click', function (event) {
                        event.preventDefault();
                        $(formatClone).find('.btn-close-overlay').click();
                        $('.mainContent').find('#catalogs #trigger-catalog .btn-open-overlay').click();
                    });
                }
                $(container).find('.btn-add-identificationOption').addClass('disabled');
            }
            $(container).find('#useSensorSwitch').removeClass('hidden');
        } else {
            if (assembledGestures()) {
                renderAssembledGestures();
                $(container).find('.btn-add-identificationOption').removeClass('disabled');
            } else {
                appendAlert(container, ALERT_NO_STUDY_GESTURES_ASSEMBLED_LINK);
                $(container).find('.btn-add-identificationOption').addClass('disabled');
                $(formatClone).find('#btn-assemble-study-gesture-set').on('click', function (event) {
                    event.preventDefault();
                    $(formatClone).find('.btn-close-overlay').click();
                    $('.mainContent').find('#catalogs #gestures-catalog .btn-open-overlay').click();
                });
            }
            $(container).find('#useSensorSwitch').addClass('hidden');
        }
    });

    renderAssembledScenes();

    var data = getLocalItem(id + '.data');
    if (data) {
        renderData(data, false);
    } else {
        appendAlert($(formatClone).find('#identificationElements'), ALERT_NO_PHASE_DATA);
        appendAlert($(formatClone).find('#observations'), ALERT_NO_DATA_QUESTIONNAIRE);
    }

    initDynamicAffixScrolling(formatClone);
    function renderData(data) {
//        $(formatClone).find('#identificationTitle').val(data.title);
        $(formatClone).find('#identificationDescription').val(data.description);
        $(formatClone).find('#identificationTypeSwitch #' + data.identificationFor).click();
        var identificationItems = data.identification;
        if (identificationItems !== undefined && identificationItems.length > 0) {
            clearAlerts($(formatClone).find('#identificationElements'));
            var container = $(formatClone).find('#identificationElements .option-container');
            $(formatClone).find('#identificationElements .btn-add-identificationOption').removeClass('disabled');

            for (var i = 0; i < identificationItems.length; i++) {
                var clone = $('#form-item-container').find('#identificationItem-' + data.identificationFor).clone();
                container.append(clone);
                if (data.identificationFor === 'gestures') {
                    var trigger = getTriggerById(identificationItems[i].triggerId);
                    if (trigger && isTriggerAssembled(trigger.id)) {
                        $(clone).find('.triggerSelect #' + trigger.id).click();
                    } else if (trigger !== null) {
                        appendAlert(clone, ALERT_ASSEMBLED_TRIGGER_REMOVED);
                    }
                    $(formatClone).find('#useSensorSwitch #' + data.sensor).click();
                    $(clone).find('#context-input').val(identificationItems[i].context);
                } else {
                    var gesture = getGestureById(identificationItems[i].gestureId);
                    if (gesture && isGestureAssembled(gesture.id)) {
                        $(clone).find('.gestureSelect #' + gesture.id).click();
                    } else if (gesture !== null) {
                        appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                    }
                }

                if (identificationItems[i].transitionScenes && identificationItems[i].transitionScenes.length > 0) {
                    for (var j = 0; j < identificationItems[i].transitionScenes.length; j++) {
                        var scene = getSceneById(identificationItems[i].transitionScenes[j].sceneId);
                        var item = $('#form-item-container').find('#transition-scene-option').clone().removeAttr('id');
                        $(clone).find('.transition-scenes-option-container').append(item);
                        $(item).find('#scene-description').val(identificationItems[i].transitionScenes[j].description);
                        if (scene) {
                            $(item).find('.sceneSelect #' + scene.id).click();
                        } else if (identificationItems[i].transitionScenes[j].sceneId !== 'unselected') {
                            appendAlert(item, ALERT_ASSEMBLED_SCENE_REMOVED);
                        }
                    }
                    checkCurrentListState($(clone).find('.transition-scenes-option-container'));
                }
                initAddTransitionSceneButton(clone);
            }

            updateBadges(container, 'identificationItem-' + data.identificationFor);
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

        identification.description = $(formatClone).find('#identificationDescription').val();
        identification.identificationFor = $(formatClone).find('#identificationTypeSwitch .btn-option-checked').attr('id');
        var identificationItems = $(formatClone).find('#identificationElements .option-container').children();
        if (identificationItems) {
            var set = new Array();
            for (var i = 0; i < identificationItems.length; i++) {
                var item = identificationItems[i];
                var transitionScenes = [];
                $(item).find('.transition-scenes-option-container').children().each(function () {
                    transitionScenes.push({sceneId: $(this).find('.sceneSelect .chosen').attr('id'),
                        description: $(this).find('#scene-description').val()});
                });
                if ($(formatClone).find('#identificationTypeSwitch .btn-option-checked').attr('id') === 'gestures') {
                    var triggerId = $(item).find('.triggerSelect .chosen').attr('id');
                    var context = $(item).find('#context-input').val().trim();
                    if (triggerId && context !== '') {
                        set.push({triggerId: triggerId, context: context, transitionScenes: transitionScenes});
                    }
                    identification.sensor = $(formatClone).find('#useSensorSwitch .btn-option-checked').attr('id');
                } else {
                    var gestureId = $(item).find('.gestureSelect .chosen').attr('id');
                    if (gestureId) {
                        set.push({gestureId: gestureId, transitionScenes: transitionScenes});
                    }
                    identification.sensor = null;
                }
            }

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
                var item = $('#form-item-container').find('#identificationItem-' + type).clone();
                tweenAndAppend(item, $(this), $(formatClone), $(formatClone).find('#identificationElements .option-container'), 'identificationItem-' + type, true);
                initAddTransitionSceneButton(item);

                setTimeout(function () {
                    $(item).find('.btn-expand').click();
                }, 400);
            } else {
                wobble($(formatClone).find('#identificationTypeSwitch'));
            }
        }
    });

    function initAddTransitionSceneButton(clone) {
        $(clone).find('.btn-add-transition-scene').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (event.handled !== true)
            {
                event.handled = true;
                var scenes = getLocalItem(ASSEMBLED_SCENES);
                if (scenes && scenes.length > 0) {
                    clearAlerts($(clone).find('#scenes'));
                    var item = $('#form-item-container').find('#transition-scene-option').clone().removeAttr('id');
                    tweenAndAppend(item, $(this), $(clone), $(clone).find('#scenes .transition-scenes-option-container'), null, true);
                } else {
                    appendAlert($(clone).find('#scenes'), ALERT_NO_SCENES_ASSEMBLED_LINK);
                    $(clone).find('#scenes #btn-assemble-scenes').on('click', function (event) {
                        event.preventDefault();
                        $(formatClone).find('.btn-close-overlay').click();
                        $('.mainContent').find('#catalogs #scenes-catalog .btn-open-overlay').click();
                    });
                }
            }
        });
        $(clone).find('.transition-scenes-option-container').on('listItemAdded change', function (event) {
            event.stopImmediatePropagation();
        });
        initQuestionnaireListChange(formatClone, $(clone).find('.transition-scenes-option-container'), clone.find('#scenes'), ALERT_NO_PHASE_DATA);
        initQuestionnaireListItemAdded($(clone).find('.transition-scenes-option-container'), clone);
    }

    initQuestionnaireListChange(formatClone, $(formatClone).find('#identificationElements .option-container'), $(formatClone).find('#identificationElements'), ALERT_NO_PHASE_DATA);
    initQuestionnaireListItemAdded($(formatClone).find('#identificationElements .option-container'), $(formatClone).find('#identificationElements'));
    initQuestionnairePreview($(formatClone).find('#observations .btn-preview-questionnaire'), $(formatClone).find('#observations #list-container'));
}

function initExplorationOverlay(id, formatClone) {
    renderOverlayTitle(id, $(formatClone).find('#overlay-title'), $(formatClone).find('#phase-step-title-input-container'));
    initQuestionnaireButtonGroup(formatClone, $(formatClone).find('#observations #add-observation-button-group'), $(formatClone).find('#observations #list-container'), $(formatClone).find('#observations'), true, true, ALERT_NO_DATA_QUESTIONNAIRE);
    initToggleSwitch(formatClone, $(formatClone).find('#useObservationsSwitch'), $(formatClone).find('#observations'));
    renderAssembledGestures();
    var assemGestures = assembledGestures();
    if (assemGestures === null || (assemGestures && assemGestures.length === 0)) {
        appendAlert($(formatClone).find('#explorationElements'), ALERT_NO_STUDY_GESTURES_ASSEMBLED_LINK);
        $(formatClone).find('#explorationElements .btn-add-explorationOption').addClass('disabled');
        $(formatClone).find('#btn-assemble-study-gesture-set').on('click', function (event) {
            event.preventDefault();
            $(formatClone).find('.btn-close-overlay').click();
            $('.mainContent').find('#catalogs #gestures-catalog .btn-open-overlay').click();
        });
    }

    renderAssembledTriggers();
    var assembledTrigger = getLocalItem(ASSEMBLED_TRIGGER);
    if (assembledTrigger === null || (assembledTrigger && assembledTrigger.length === 0)) {
        appendAlert($(formatClone).find('#explorationElements'), ALERT_NO_TRIGGER_ASSEMBLED_LINK);
        $(formatClone).find('#explorationElements .btn-add-explorationOption').addClass('disabled');
        $(formatClone).find('#btn-assemble-trigger').on('click', function (event) {
            event.preventDefault();
            $(formatClone).find('.btn-close-overlay').click();
            $('.mainContent').find('#catalogs #trigger-catalog .btn-open-overlay').click();
        });
    }

    renderAssembledScenes();
//    renderAssembledScenes($('#form-item-container').find('#explorationItem #transition-scene'), [{id: 'none', title: translation.noner}]);
//    renderAssembledScenes($(formatClone).find('#general'));
    var assembledScenes = getLocalItem(ASSEMBLED_SCENES);
//    if (assembledScenes === null || (assembledScenes && assembledScenes.length === 0)) {
//        appendAlert($(formatClone).find('#explorationElements'), ALERT_NO_SCENES_ASSEMBLED_LINK);
//        $(formatClone).find('#explorationElements .btn-add-explorationOption').addClass('disabled');
//        $(formatClone).find('#btn-assemble-scenes').on('click', function (event) {
//            event.preventDefault();
//            $(formatClone).find('.btn-close-overlay').click();
//            $('.mainContent').find('#catalogs #scenes-catalog .btn-open-overlay').click();
//        });
//    }

//    console.log(assembledTrigger, assembledScenes);

    var data = getLocalItem(id + '.data');
//    console.log(data);
    if (data) {
        renderData(data);
    } else if (assembledGestures() !== null && assembledTrigger && assembledScenes) {
        appendAlert($(formatClone).find('#explorationElements'), ALERT_NO_PHASE_DATA);
    }


    initDynamicAffixScrolling(formatClone);
    function renderData(data) {
//        $(formatClone).find('#explorationTitle').val(data.title);
        $(formatClone).find('#explorationDescription').val(data.description);
        $(formatClone).find('#explorationTypeSwitch #' + data.explorationType).click();
        if (data.explorationType === 'gestures') {
            $(formatClone).find('#explorationElements .btn-add-explorationOption').removeClass('disabled');
            $(formatClone).find('#askPreferredGestureSwitch').removeClass('hidden');
            $(formatClone).find('#askPreferredGestureSwitch #' + data.askPreferredGesture).click();
        } else {
            $(formatClone).find('#explorationElements .btn-add-explorationOption').removeClass('disabled');
            $(formatClone).find('#askPreferredTriggerSwitch').removeClass('hidden');
            $(formatClone).find('#askPreferredTriggerSwitch #' + data.askPreferredTrigger).click();
        }

        renderExplorationItems(data.exploration);
        renderObservations(formatClone, data.observations);
    }

//    function initExpandTaskButtonForTrigger(item) {
//        $(item).find('.btn-expand').bind('click', function (event) {
//            event.preventDefault();
//            if ($(this).closest('.root').find('.panel-body').hasClass('hidden')) {
//                $(this).closest('.task-option-container').find('.panel-body').addClass('hidden');
//                $(this).closest('.task-option-container').find('.btn-expand').removeClass('hidden');
//                $(this).closest('.root').find('.panel-body').removeClass('hidden');
//                $(this).closest('.root').find('.btn-expand').addClass('hidden');
//            }
//        });
//    }
//    function initExpandTaskButtonForGesture(item) {
//        $(item).find('.btn-expand').bind('click', function (event) {
//            event.preventDefault();
//            if ($(this).closest('.root').find('.panel-body').hasClass('hidden')) {
//                $(this).closest('.task-option-container').find('.panel-body').addClass('hidden');
//                $(this).closest('.task-option-container').find('.btn-expand').removeClass('hidden');
//                $(this).closest('.root').find('.panel-body').removeClass('hidden');
//                $(this).closest('.root').find('.btn-expand').addClass('hidden');
//            }
//        });
//    }

    function renderExplorationItems(items) {
        if (items !== undefined && items.length > 0) {
//            console.log(data.explorationType, items);
            var container = $(formatClone).find('#explorationElements .option-container');
            for (var i = 0; i < items.length; i++) {
                var clone = $('#form-item-container').find('#explorationItem-' + data.explorationType).clone();
                container.append(clone);
                if (data.explorationType === 'gestures') {
                    var trigger = getTriggerById(items[i].triggerId);
                    if (trigger !== null) {
                        $(clone).find('.triggerSelect #' + trigger.id).click();
                    } else if (items[i].triggerId !== 'unselected') {
                        appendAlert(clone, ALERT_ASSEMBLED_TRIGGER_REMOVED);
                    }

                    renderAssembledGesturesItems(clone.find('#assembled-gestures-container'), items[i].gestures);
//                    initExpandTaskButtonForTrigger(clone);
                } else {
                    var gesture = getGestureById(items[i].gestureId);
                    if (gesture) {
                        $(clone).find('.gestureSelect #' + gesture.id).click();
                    } else if (items[i].gestureId !== 'unselected') {
                        appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                    }

                    renderAssembledTriggerItems(clone.find('#assembled-trigger-container'), items[i].trigger);
//                    initExpandTaskButtonForGesture(clone);
                }

                if (items[i].transitionScenes && items[i].transitionScenes.length > 0) {
                    for (var j = 0; j < items[i].transitionScenes.length; j++) {
                        var scene = getSceneById(items[i].transitionScenes[j].sceneId);
                        var item = $('#form-item-container').find('#transition-scene-option').clone().removeAttr('id');
                        $(clone).find('.transition-scenes-option-container').append(item);
                        if (scene) {
                            $(item).find('.sceneSelect #' + scene.id).click();
                        } else if (items[i].transitionScenes[j].sceneId !== 'unselected') {
                            appendAlert(item, ALERT_ASSEMBLED_SCENE_REMOVED);
                        }

                        $(item).find('#scene-description').val(items[i].transitionScenes[j].description);
                    }
                    checkCurrentListState($(clone).find('.transition-scenes-option-container'));
                }
                initAddTransitionSceneButton(clone);
            }
            updateBadges(container, 'explorationItem-' + data.explorationType);
            checkCurrentListState(container);
        } else {
            appendAlert($(formatClone).find('#explorationElements'), ALERT_NO_PHASE_DATA);
        }
    }

    function renderAssembledGesturesItems(container, gestureIds, preselect) {
        var assemGestures = assembledGestures();
        for (var i = 0; i < assemGestures.length; i++) {
            var thumbnail = getGestureSceneListThumbnail(assemGestures[i], 'add-gesture-to-scene-thumbnail', 'col-xs-6 col-sm-4 col-md-6 col-lg-4');
            $(container).append(thumbnail);
        }
        initPopover(300);

        if (preselect && preselect === true) {
            setTimeout(function () {
                $(container).find('.btn-add-gesture-to-scene').click();
            }, 500);
        }


        if (gestureIds && gestureIds.length > 0) {
            for (var i = 0; i < gestureIds.length; i++) {
                $(container).find('#' + gestureIds[i] + ' .btn-add-gesture-to-scene').click();
            }
        }
    }

    function renderAssembledTriggerItems(container, triggerIds, preselect) {
        var assemTrigger = getLocalItem(ASSEMBLED_TRIGGER);
        for (var i = 0; i < assemTrigger.length; i++) {
            var item = $('#form-item-container').find('#assembled-trigger-option').clone().removeAttr('id');
            $(item).attr('id', assemTrigger[i].id);
            $(item).find('.trigger-title').text(assemTrigger[i].title);
            $(container).append(item);
            if (i > 0) {
                $(item).css({marginTop: '5px'});
            }

            $(item).find('.btn-add-trigger-to-gesture').on('click', function (event) {
                event.preventDefault();
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    $(this).find('.fa').removeClass('fa-minus-square').addClass('fa-plus-square');
                    $(this).parent().find('.trigger-title').removeClass('text');
                } else {
                    $(this).addClass('selected');
                    $(this).find('.fa').removeClass('fa-plus-square').addClass('fa-minus-square');
                    $(this).parent().find('.trigger-title').addClass('text');
                }
            });
        }

        if (preselect && preselect === true) {
            setTimeout(function () {
                $(container).find('.btn-add-trigger-to-gesture').click();
            }, 500);
        }

        if (triggerIds && triggerIds.length > 0) {
            for (var i = 0; i < triggerIds.length; i++) {
                $(container).find('#' + triggerIds[i] + ' .btn-add-trigger-to-gesture').click();
            }
        }
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        $(formatClone).find('#btn-save-phase-step-title').click();
        var data = new Object();
//        data.title = $(formatClone).find('#explorationTitle').val();
        data.description = $(formatClone).find('#explorationDescription').val();
        data.explorationType = $(formatClone).find('#explorationTypeSwitch .btn-option-checked').attr('id');
        if (data.explorationType === 'gestures') {
            data.askPreferredGesture = $(formatClone).find('#askPreferredGestureSwitch .btn-option-checked').attr('id');
        } else {
            data.askPreferredTrigger = $(formatClone).find('#askPreferredTriggerSwitch .btn-option-checked').attr('id');
        }

        saveExplorationItems(data);
        saveObservations(formatClone, $(formatClone).find('#observations #list-container').children(), data);
        setLocalItem(id + ".data", data);
    });

    function saveExplorationItems(data) {
        var explorationItem = $(formatClone).find('#explorationElements .option-container').children();
        if (explorationItem) {
            var set = new Array();
            for (var i = 0; i < explorationItem.length; i++) {
                var item = explorationItem[i];
                var transitionScenes = [];
                var transitionItems = $(item).find('.transition-scenes-option-container').children();
                for (var j = 0; j < transitionItems.length; j++) {
                    transitionScenes.push({sceneId: $(transitionItems[j]).find('.sceneSelect .chosen').attr('id'), description: $(transitionItems[j]).find('#scene-description').val().trim()});
                }

                if (data.explorationType === 'gestures') {
                    var triggerId = $(item).find('.triggerSelect .chosen').attr('id');
                    var trigger = getTriggerById(triggerId);
                    var gestureIds = [];
                    $(item).find('#assembled-gestures-container .gesture-thumbnail.assembled').each(function () {
                        gestureIds.push($(this).closest('.root').attr("id"));
                    });
//                    console.log(triggerId, gestureIds, transitionScenes);

                    if (trigger && gestureIds.length > 0) {
                        set.push({triggerId: triggerId, gestures: gestureIds, transitionScenes: transitionScenes});
                    }
                } else {
                    var gestureId = $(item).find('.gestureSelect .chosen').attr('id');
                    var gesture = getGestureById(gestureId);
                    var triggerIds = [];
                    $(item).find('#assembled-trigger-container .selected').each(function () {
                        triggerIds.push($(this).closest('.root').attr("id"));
                    });
//                    console.log(gesture, triggerIds, transitionScenes);

                    if (gesture && triggerIds.length > 0) {
                        set.push({gestureId: gestureId, trigger: triggerIds, transitionScenes: transitionScenes});
                    }
                }
            }
            data.exploration = set;
        }
    }

    $(formatClone).find('#explorationTypeSwitch').unbind('change').bind('change', function (event) {
        event.preventDefault();
        $(formatClone).find('#explorationElements .option-container').empty();
        if ($(this).find('.btn-option-checked').attr('id') === 'gestures') {
            $(formatClone).find('#askPreferredGestureSwitch').removeClass('hidden');
            $(formatClone).find('#askPreferredTriggerSwitch').addClass('hidden');
        } else {
            $(formatClone).find('#askPreferredTriggerSwitch').removeClass('hidden');
            $(formatClone).find('#askPreferredGestureSwitch').addClass('hidden');
        }
        $(formatClone).find('#explorationElements .option-container').trigger('change');
        $(formatClone).find('#explorationElements .btn-add-explorationOption').removeClass('disabled');
    });

    $(formatClone).find('#explorationElements .btn-add-explorationOption').on('click', function (event) {
        event.preventDefault();
        if (event.handled !== true)
        {
            event.handled = true;
            if (!$(this).hasClass('disabled')) {
                clearAlerts($(formatClone).find('#explorationElements'));
                var explorationType = $(formatClone).find('#explorationTypeSwitch .btn-option-checked').attr('id');
                var item = $('#form-item-container').find('#explorationItem-' + explorationType).clone();
                tweenAndAppend(item, $(this), $(formatClone), $(formatClone).find('#explorationElements .option-container'), 'explorationItem-' + explorationType, true);
                if (explorationType === 'gestures') {
                    renderAssembledGesturesItems(item.find('#assembled-gestures-container'), null, true);
                    initAddTransitionSceneButton(item);
                } else {
                    renderAssembledTriggerItems(item.find('#assembled-trigger-container'), null, true);
                    initAddTransitionSceneButton(item);
                }

                setTimeout(function () {
                    $(item).find('.btn-expand').click();
                }, 400);

            } else {
                wobble($(formatClone).find('#explorationTypeSwitch'));
            }
        }
    });

    function initAddTransitionSceneButton(clone) {
        $(clone).find('.btn-add-transition-scene').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (event.handled !== true)
            {
//                console.log('add transition scenes');
                event.handled = true;
                var scenes = getLocalItem(ASSEMBLED_SCENES);
                if (scenes && scenes.length > 0) {
                    clearAlerts($(clone).find('#scenes'));
                    var item = $('#form-item-container').find('#transition-scene-option').clone().removeAttr('id');
                    tweenAndAppend(item, $(this), $(clone), $(clone).find('#scenes .transition-scenes-option-container'), null, true);
                } else {
                    appendAlert($(clone).find('#scenes'), ALERT_NO_SCENES_ASSEMBLED_LINK);
                    $(clone).find('#scenes #btn-assemble-scenes').on('click', function (event) {
                        event.preventDefault();
                        $(formatClone).find('.btn-close-overlay').click();
                        $('.mainContent').find('#catalogs #scenes-catalog .btn-open-overlay').click();
                    });
                }
            }
        });
        $(clone).find('.transition-scenes-option-container').on('listItemAdded change', function (event) {
            event.stopImmediatePropagation();
        });
        initQuestionnaireListChange(formatClone, $(clone).find('.transition-scenes-option-container'), clone.find('#scenes'), ALERT_NO_PHASE_DATA);
        initQuestionnaireListItemAdded($(clone).find('.transition-scenes-option-container'), clone);
    }

    initQuestionnaireListChange(formatClone, $(formatClone).find('#explorationElements .option-container'), $(formatClone).find('#explorationElements'), ALERT_NO_PHASE_DATA);
    initQuestionnaireListItemAdded($(formatClone).find('#explorationElements .option-container'), $(formatClone).find('#explorationElements'));
    initQuestionnairePreview($(formatClone).find('#observations .btn-preview-questionnaire'), $(formatClone).find('#observations #list-container'));
}










function initOverlayContentFunctionalitiesByFormat(format, formatClone) {
//    console.log
    switch (format) {
        case CATALOG_GESTURES:
            initCatalogGesturesOverlay(formatClone);
            break;
        case CATALOG_TRIGGER:
            initCatalogTriggerOverlay(formatClone);
            break;
        case CATALOG_FEEDBACK:
            initCatalogFeedbackOverlay(formatClone);
            break;
        case CATALOG_SCENES:
            initCatalogScenesOverlay(formatClone);
            break;
    }
}

var currentFilterList;
function initCatalogGesturesOverlay(formatClone) {
    $(formatClone).find('#overlay-title').text(translation.studyCatalogs.gestures);
    initDynamicAffixScrolling(formatClone);
    getGestureSets(function (result) {
        if (result.status === RESULT_SUCCESS) {
            setLocalItem(GESTURE_SETS, result.gestureSets);
            getGestureCatalog(function (result) {
                if (result.status === RESULT_SUCCESS) {
                    setLocalItem(GESTURE_CATALOG, result.gestures);
                    $(formatClone).find('#gesture-catalogs-nav-tab a[href="#study-gesture-set"]').tab('show');
                    getWholeStudyGestures();
                    updateNavBadges();
                }
            });
        }
    });

    function renderData(data, animation) {
        var currentActiveTab = getCurrentActiveTab();
        currentFilterData = data;
        $(currentFilterList).empty();
        var index = getCurrentPaginationIndex();
        var listCount = parseInt($(currentPaginationData.filter.countSelect).find('.chosen').attr('id').split('_')[1]);
        var viewFromIndex = index * listCount;
        var viewToIndex = Math.min((index + 1) * listCount, currentFilterData.length);
        var count = 0;

        if (currentFilterData.length > 0) {
            clearAlerts($(currentActiveTab).find('#item-view'));
            for (var i = viewFromIndex; i < viewToIndex; i++) {
                var clone;
                switch ($(currentActiveTab).attr('id')) {
                    case 'gesture-sets':
                        clone = getGestureSetPanel(currentFilterData[i], 'favorite-gesture-catalog-thumbnail');
                        $(currentFilterList).append(clone);
                        if (animation && animation === true) {
                            TweenMax.from(clone, .2, {delay: count * .03, opacity: 0, y: -10});
                        }
                        break;
                    case 'study-gesture-set':
                    case 'gesture-catalog':
                        clone = getCreateStudyGestureListThumbnail(currentFilterData[i], 'favorite-gesture-catalog-thumbnail', 'col-xs-6 col-sm-4 col-md-4 col-lg-3');
                        $(currentFilterList).append(clone);
                        if (animation && animation === true) {
                            TweenMax.from(clone, .2, {delay: count * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                        }

                        break;
                }
                count++;
            }
        } else {
            appendAlert($(currentActiveTab).find('#item-view'), ALERT_NO_SEARCH_RESULTS);
            $(currentActiveTab).find('#item-view #pager-top .pagination').addClass('hidden');
            $(currentActiveTab).find('#item-view #pager-bottom .pagination').addClass('hidden');
        }

        initPopover();
        initTooltips();
        updateNavBadges();
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        resetRecorder();
        renderCatalogOverview();
    });

    $(formatClone).find('.tab-content #tab-study-gesture-set').attr('id', 'study-gesture-set');
    $(formatClone).find('.tab-content #tab-gesture-catalog').attr('id', 'gesture-catalog');
    $(formatClone).find('.tab-content #tab-gesture-sets').attr('id', 'gesture-sets');
    $(formatClone).find('.tab-content #tab-gesture-recorder-content').attr('id', 'gesture-recorder-content');
    $(formatClone).find('.tab-content #tab-gesture-importer').attr('id', 'gesture-importer');

    // synchronize two navigation bars
    $(formatClone).find('.nav-pills').on('shown.bs.tab', function (event) {
        var activeTabIndex = $(event.target).closest('.nav').find('a').index($(event.target));
        $(this).closest('.root').find('.nav').find("li").removeClass('active');
        $(this).closest('.root').find('.nav').find("li:eq( " + activeTabIndex + " )").addClass('active');
        $(formatClone).find($(event.target).attr('href')).find('#sort .active').removeClass('selected');
        $(formatClone).find('.search-input').val('');
        $('#custom-modal').unbind('gestureSetsUpdated');
        resetRecorder();
        console.log($(event.target).attr('href'))
        switch ($(event.target).attr('href')) {
            case '#study-gesture-set':
                getWholeStudyGestures();
                break;
            case '#gesture-catalog':
                getWholeGestureCatalog();
                break;
            case '#gesture-sets':
                getWholeGestureSets();
                break;
            case '#gesture-recorder-content':
                getWholeGestureRecorder();
                break;
            case '#gesture-importer':
                getWholeGestureImporter();
                break;
        }
        updateNavBadges();
    });

    function getCurrentActiveTab() {
        return $(formatClone).find('#gesture-catalogs-nav-tab').find('.active a').attr('href');
    }

    $(formatClone).find('.filter').unbind('change').bind('change', function (event) {
        event.preventDefault();
        currentFilterData = sort();
        updatePaginationItems();
        if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
            $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
        } else {
            renderData(currentFilterData, true);
        }
    });

    $(formatClone).find('.sort').unbind('change').bind('change', function (event) {
        event.preventDefault();
        currentFilterData = sort();
        updatePaginationItems();
        if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
            $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
        } else {
            renderData(currentFilterData, true);
        }
    });

    $(formatClone).find('.resultsCountSelect').unbind('change').bind('change', function (event) {
        event.preventDefault();
        currentFilterData = sort();
        updatePaginationItems();
        if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
            $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
        } else {
            renderData(currentFilterData, true);
        }
    });

    $(formatClone).unbind('indexChanged').bind('indexChanged', '.pagination', function (event, index) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
            renderData(sort(), true);
        }
    });

    function updateNavBadges() {
        var studyGestures = getLocalItem(ASSEMBLED_GESTURE_SET);
        var studyGesturesLength = 0;
        if (studyGestures && studyGestures.length > 0) {
            studyGesturesLength = studyGestures.length;
        }
        $(formatClone).find('#gesture-catalogs-nav-tab-small').find('#study-gesture-set-badge').text(studyGesturesLength);
        $(formatClone).find('#gesture-catalogs-nav-tab').find('#study-gesture-set-badge').text(studyGesturesLength);
        var catalog = getLocalItem(GESTURE_CATALOG);
        var catalogLength = 0;
        if (catalog.length > 0) {
            catalogLength = catalog.length;
        }
        $(formatClone).find('#gesture-catalogs-nav-tab-small').find('#gesture-catalog-badge').text(catalogLength);
        $(formatClone).find('#gesture-catalogs-nav-tab').find('#gesture-catalog-badge').text(catalogLength);
        var gestureSets = getLocalItem(GESTURE_SETS);
        var gestureSetsLength = 0;
        if (gestureSets.length > 0) {
            gestureSetsLength = gestureSets.length;
        }
        $(formatClone).find('#gesture-catalogs-nav-tab-small').find('#gesture-sets-badge').text(gestureSetsLength);
        $(formatClone).find('#gesture-catalogs-nav-tab').find('#gesture-sets-badge').text(gestureSetsLength);
    }

    function getWholeStudyGestures() {
        currentFilterList = $(formatClone).find('#study-gesture-set #gesture-list-container');
        currentFilterList.empty();
        originalFilterData = assembledGestures();
        if (originalFilterData && originalFilterData.length > 0) {
            $(formatClone).find('#study-gesture-set #filter-controls').removeClass('hidden');
            clearAlerts($(formatClone).find('#study-gesture-set'));
            var data = {
                pager: {
                    top: $(formatClone).find('#study-gesture-set #pager-top .pagination'),
                    bottom: $(formatClone).find('#study-gesture-set #pager-bottom .pagination'),
                    dataLength: originalFilterData.length,
                    maxElements: parseInt($(formatClone).find('#study-gesture-set #resultsCountSelect .chosen').attr('id').split('_')[1])
                },
                filter: {
                    countSelect: $(formatClone).find('#study-gesture-set #resultsCountSelect'),
                    filter: $(formatClone).find('#study-gesture-set #filter'),
                    sort: $(formatClone).find('#study-gesture-set #sort')
                }
            };
            initPagination(data);
            $(currentFilterList).unbind('change').bind('change', function (event, gestureId, assemble) {
//                console.log('study gestures changed', gestureId);
                TweenMax.to($(event.target).closest('.root'), .2, {scale: 0, opacity: 0, clearProps: 'all', ease: Quad.easeIn, onComplete: function () {
                        reassembleGesture(gestureId);
                        updateCatalogButtons();
                        updateNavBadges();
                        originalFilterData = assembledGestures();
                        if (originalFilterData && originalFilterData.length > 0) {
                            currentFilterData = sort();
                            updatePaginationItems();
                            renderData(originalFilterData);
                            $(formatClone).find('#study-gesture-set #filter-controls').removeClass('hidden');
                        } else {
                            currentFilterList.empty();
                            $(formatClone).find('#study-gesture-set #pager-top .pagination').addClass('hidden');
                            $(formatClone).find('#study-gesture-set #pager-bottom .pagination').addClass('hidden');
                            $(formatClone).find('#study-gesture-set #filter-controls').addClass('hidden');
                            appendAlert($(formatClone).find('#study-gesture-set'), ALERT_NO_STUDY_GESTURES_ASSEMBLED);
                        }
                    }
                });
            });
            $(formatClone).find('#study-gesture-set #sort #newest').removeClass('selected');
            $(formatClone).find('#study-gesture-set #sort #newest').click();
        } else {
            $(formatClone).find('#study-gesture-set #pager-top .pagination').addClass('hidden');
            $(formatClone).find('#study-gesture-set #pager-bottom .pagination').addClass('hidden');
            $(formatClone).find('#study-gesture-set #filter-controls').addClass('hidden');
            appendAlert($(formatClone).find('#study-gesture-set'), ALERT_NO_STUDY_GESTURES_ASSEMBLED);
        }

        $(currentFilterList).unbind('renderData').bind('renderData', function (event, data) {
            renderData(data);
        });
    }

    function getWholeGestureCatalog() {
        currentFilterList = $(formatClone).find('#gesture-catalog #gesture-list-container');
        currentFilterList.empty();
        getGestureCatalog(function (result) {
            if (result.status === RESULT_SUCCESS) {
                originalFilterData = result.gestures;
                if (originalFilterData && originalFilterData.length > 0) {
                    var data = {
                        pager: {
                            top: $(formatClone).find('#gesture-catalog #pager-top .pagination'),
                            bottom: $(formatClone).find('#gesture-catalog #pager-bottom .pagination'),
                            dataLength: originalFilterData.length,
                            maxElements: parseInt($(formatClone).find('#gesture-catalog #resultsCountSelect .chosen').attr('id').split('_')[1])
                        },
                        filter: {
                            countSelect: $(formatClone).find('#gesture-catalog #resultsCountSelect'),
                            filter: $(formatClone).find('#gesture-catalog #filter'),
                            sort: $(formatClone).find('#gesture-catalog #sort')
                        }
                    };
                    initPagination(data);
                    $(formatClone).find('#gesture-catalog #sort #newest').removeClass('selected');
                    $(formatClone).find('#gesture-catalog #sort #newest').click();
                } else {
                    // show alert that no data is there
                }
            }
        });

        $(currentFilterList).unbind('change').bind('change', function (event, gestureId, assemble) {
            event.preventDefault();
            var tweenParams = initAddGestureToStudyGestures($(event.target), formatClone);
            if (assemble) {
                assembleGesture(gestureId);
                TweenMax.to(tweenParams.tweenElement, .4, {x: tweenParams.alphaX, y: tweenParams.alphaY, opacity: 0, scale: 0, rotation: tweenParams.rotation, transformOrigin: "left top", clearProps: 'all', ease: Quad.easeOut, onComplete: updateNavBadges});
            } else {
                reassembleGesture(gestureId);
                updateNavBadges();
//                TweenMax.from(tweenElement, .4, {x: alphaX, y: alphaY, opacity: 0, scale: 0, rotation: rotation, transformOrigin: "left top", clearProps: 'all', ease: Quad.easeIn, onComplete: updateNavBadges});
            }
            updateCatalogButtons();
        });

        $(currentFilterList).unbind('renderData').bind('renderData', function (event, data) {
            renderData(data);
        });
    }

    function initAddGestureToStudyGestures(element, formatClone) {
        var object = {};
        object.tweenElement = $(element).closest('.root').css({zIndex: '1000'});
        var offset = $(object.tweenElement).offset();
        var target = $(formatClone).find('#gesture-catalogs-nav-tab').children().first();
        var targetOffset = $(formatClone).find('#gesture-catalogs-nav-tab').children().first().offset();
        var tweenOffset = {offsetY: targetOffset.top - offset.top + ($(target).height() * .5), offsetX: targetOffset.left - offset.left + ($(target).width() * .5)};
        if ($(window).width() <= 992) {
            target = $(formatClone).find('#gesture-catalogs-nav-tab-small').children().first();
            targetOffset = $(formatClone).find('#gesture-catalogs-nav-tab-small').children().first().offset();
            var scrollTop = $('html, body').scrollTop();
            tweenOffset.offsetY = targetOffset.top - offset.top - scrollTop + ($(target).height() * .5);
            tweenOffset.offsetX = targetOffset.left - offset.left + ($(target).width() * .5);
        }

        object.alphaY = tweenOffset.offsetY < 0 ? '' + tweenOffset.offsetY : '+' + tweenOffset.offsetY;
        object.alphaX = tweenOffset.offsetX < 0 ? '' + tweenOffset.offsetX : '+' + tweenOffset.offsetX;
        object.rotation = chance.natural({min: 5, max: 20});
        return object;
    }

    function getWholeGestureSets() {
        currentFilterList = $(formatClone).find('#gesture-sets #gesture-sets-container');
        currentFilterList.empty();

        getGestureSets(function (result) {
            if (result.status === RESULT_SUCCESS) {
                originalFilterData = result.gestureSets;
                setLocalItem(GESTURE_SETS, result.gestureSets);
                if (originalFilterData && originalFilterData.length > 0) {
                    var data = {
                        pager: {
                            top: $(formatClone).find('#gesture-sets #pager-top .pagination'),
                            bottom: $(formatClone).find('#gesture-sets #pager-bottom .pagination'),
                            dataLength: originalFilterData.length,
                            maxElements: parseInt($(formatClone).find('#gesture-sets').find('#resultsCountSelect .chosen').attr('id').split('_')[1])
                        },
                        filter: {
                            countSelect: $(formatClone).find('#gesture-sets #resultsCountSelect'),
                            filter: $('#gesture-sets').find('#filter'),
                            sort: $(formatClone).find('#gesture-sets #sort')
                        }
                    };
                    initPagination(data);
                    $(formatClone).find('#gesture-sets #sort #newest').removeClass('selected');
                    $(formatClone).find('#gesture-sets #sort #newest').click();
                } else {
                    // show alert that no data is there
                }
            }
        });

        $(currentFilterList).unbind('change').bind('change', function (event, gestureId, assemble, rerender) {
            event.preventDefault();
            var tweenParams = initAddGestureToStudyGestures($(event.target), formatClone);
            if (assemble) {
                assembleGesture(gestureId);
                TweenMax.to(tweenParams.tweenElement, .4, {x: tweenParams.alphaX, y: tweenParams.alphaY, opacity: 0, scale: 0, rotation: tweenParams.rotation, transformOrigin: "left top", clearProps: 'all', ease: Quad.easeOut, onComplete: function () {
                        if (rerender) {
                            renderData(originalFilterData);
                        }
                        updateCatalogButtons();
                        updateNavBadges();
                    }});
            } else {
                reassembleGesture(gestureId);
                if (rerender) {
                    renderData(originalFilterData);
                }
                updateCatalogButtons();
                updateNavBadges();
            }
        });

        $(formatClone).find('#gesture-sets .create-gesture-set-input').unbind('gestureSetCreated').bind('gestureSetCreated', function (event) {
//            console.log('gesture set created');
            getWholeGestureSets();
        });

        $(formatClone).find('#gesture-sets #gesture-sets-container').unbind('gestureSetDeleted').bind('gestureSetDeleted', function (event) {
//            console.log('gesture set deleted');
            getWholeGestureSets();
        });

        $('#custom-modal').unbind('gestureSetsUpdated').bind('gestureSetsUpdated', function (event) {
//            console.log('gesture set updated');
            getGestureSets(function (result) {
                if (result.status === RESULT_SUCCESS) {
                    originalFilterData = result.gestureSets;
                    setLocalItem(GESTURE_SETS, result.gestureSets);
                    renderData(originalFilterData);
                }
            });
        });

        $(currentFilterList).unbind('renderData').bind('renderData', function (event, data) {
            renderData(data);
        });
    }

    function getWholeGestureRecorder() {
        var recorder = $('#item-container-gesture-recorder').find('#gesture-recorder-with-introductions').clone().removeAttr('id');
        $(formatClone).find('#gesture-recorder-container').empty().append(recorder);
//            renderBodyJoints($(recorder).find('#human-body'));

        var options = {
            recorderTarget: recorder,
            alertTarget: $(formatClone).find('#gesture-recorder-container'),
            saveGesture: true,
            checkType: true,
            checkInteractionType: true,
            showIntroduction: true,
            record: [
                {type: 'webcam', autoplayPlayback: true, autoplaySave: true, autoplaySaveSuccess: true},
                {type: 'leap', autoplayPlayback: true, autoplaySave: true, autoplaySaveSuccess: true}
            ]
        };

        gestureRecorder = new GestureRecorder(options);

//        var recorder = $('#item-container-gesture-recorder').find('#gesture-recorder').clone().removeAttr('id');
//        $(formatClone).find('#gesture-recorder-container').empty().append(recorder);
//        renderBodyJoints($(recorder).find('#human-body'));
//        var options = {
//            alertTarget: $(formatClone).find('#gesture-recorder-container'),
//            recorderTarget: recorder,
//            saveGestures: true,
//            checkType: true,
//            checkInteractionType: true
//        };
//        new GestureRecorder(options);

//        var recorderDescription = $('#item-container-gesture-recorder').find('#gesture-recorder-description').clone();
//        formatClone.find('#recorder-description').empty().append(recorderDescription);
//        $(gestureRecorder).unbind(EVENT_GR_UPDATE_STATE).bind(EVENT_GR_UPDATE_STATE, function (event, type) {
//            var descriptions = $('#item-container-gesture-recorder').find('#' + type).clone();
//            recorderDescription.empty().append(descriptions);
//            TweenMax.from(descriptions, .3, {y: -20, opacity: 0, clearProps: 'all'});
//        });

        $(gestureRecorder).unbind(GR_EVENT_SAVE_SUCCESS).bind(GR_EVENT_SAVE_SUCCESS, function (event, savedGesture) {
            event.preventDefault();
            if (savedGesture) {
//                console.log(savedGesture);
                assembleGesture(savedGesture.id);
                getGestureCatalog(function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        setLocalItem(GESTURE_CATALOG, result.gestures);
                        updateNavBadges();
                    }
                });
                updateCatalogButtons();
            }
        });

        $(gestureRecorder).unbind(GR_EVENT_DELETE_SUCCESS).bind(GR_EVENT_DELETE_SUCCESS, function (event, gestureId) {
//            console.log(GR_EVENT_DELETE_SUCCESS, gestureId);
            event.preventDefault();
            reassembleGesture(gestureId);
            getGestureCatalog(function (result) {
                if (result.status === RESULT_SUCCESS) {
                    setLocalItem(GESTURE_CATALOG, result.gestures);
                    updateNavBadges();
                }
            });
            updateCatalogButtons();
        });
    }

    function getWholeGestureImporter() {
        console.log(formatClone, $(formatClone).find('#gesture-importer-content'));
        var importer = $('#template-gesture').find('#gesture-importer-template').clone().removeAttr('id');
        $(formatClone).find('#gesture-importer').empty().append(importer);
        appendAlert($(formatClone).find('#gesture-importer'), ALERT_NO_EXCHANGEABLE_FILE_SELECTED);
    }
}

function initCatalogTriggerOverlay(formatClone) {
    $(formatClone).find('#overlay-title').text(translation.studyCatalogs.trigger);
    initDynamicAffixScrolling(formatClone);
    var data = getLocalItem(ASSEMBLED_TRIGGER);
    if (data && data.length > 0) {
        renderData(data);
    } else {
        appendAlert($(formatClone), ALERT_NO_PHASE_DATA);
    }

    function renderData(data) {
        for (var i = 0; i < data.length; i++) {
            var clone = $('#triggerItem').clone().removeClass('hidden');
            clone.find('.option').val(data[i].title);
            clone.attr('id', data[i].type);
            clone.attr('name', data[i].id);
            $(formatClone).find('#list-container').append(clone);
        }
        checkCurrentListState($(formatClone).find('#list-container'));
    }

    function saveData() {
        var trigger = new Array();
        var elements = $(formatClone).find('#list-container').children();
        for (var i = 0; i < elements.length; i++) {
            var triggerId = $(element).attr('name');
            var element = elements[i];
            var title = $(elements[i]).find('.option').val();
            if (triggerId === undefined) {
                triggerId = chance.natural();
            }
            if (title.trim() !== "") {
                trigger.push({id: triggerId, type: TYPE_TRIGGER, title: title}); //new Trigger(triggerId, TYPE_TRIGGER, $(elements[i]).find('.option').val()));
            }
        }
        setLocalItem(ASSEMBLED_TRIGGER, trigger);
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        saveData();
        renderCatalogOverview();
    });
    initQuestionnaireButtonGroup(formatClone, $(formatClone).find('#add-trigger-button-group'), $(formatClone).find('#list-container'), formatClone, true, true, ALERT_NO_PHASE_DATA);
}

function initCatalogFeedbackOverlay(formatClone) {
    $(formatClone).find('#overlay-title').text(translation.studyCatalogs.feedback);
    initDynamicAffixScrolling(formatClone);
    var data = getLocalItem(ASSEMBLED_FEEDBACK);
    if (data && data.length > 0) {
        renderData(data);
    } else {
        appendAlert(formatClone, ALERT_NO_PHASE_DATA);
    }

    function renderData(data) {
        for (var i = 0; i < data.length; i++) {
            var item = data[i];
            var clone = $('#form-item-container').find('#' + item.type).clone();
            clone.find('.item-input-text').val(item.title);
            clone.attr('name', item.id);
            $(formatClone).find('#list-container').append(clone);
            updateBadges($(formatClone).find('#list-container'), item.type);
            switch (item.type) {
                case TYPE_FEEDBACK_TEXT:
//                    $(clone).find('.negative #' + data[i].parameters.negative).click();
                    break;
                case TYPE_FEEDBACK_SOUND:
                    if (data[i].parameters && data[i].parameters.url) {
                        $(clone).find('.audio-holder').attr('src', data[i].parameters.url);
                        $(clone).find('.audioPlayer').removeClass('hidden');
                        $(clone).find('.chooseFeedbackSound .btn-text').text('Andere Sounddatei auswählen');
                        $(clone).find('.chooseFeedbackSound .btn-icon').removeClass('fa fa-volume-up');
                        $(clone).find('.chooseFeedbackSound .btn-icon').addClass('fa fa-refresh');
                    }
                    break;
            }
        }

        checkCurrentListState($(formatClone).find('#list-container'));
    }

    function saveData() {
        var assembledData = new Array();
        var items = $(formatClone).find('#list-container').children();
        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            var type = $(item).attr('id');
            var id = $(item).attr('name') === undefined || null ? chance.natural() : $(item).attr('name');
            var title = $(item).find('.item-input-text').val().trim();
            var parameters = null;

            switch (type) {
                case TYPE_FEEDBACK_TEXT:
//                    parameters = {negative: $(item).find('.negative .btn-option-checked').attr('id')};
                    break;
                case TYPE_FEEDBACK_SOUND:
                    var url = $(item).find('.audio-holder').attr('src');
                    if (url.trim() !== '') {
                        parameters = {url: url.trim()};
                    }

                    break;
            }

            if (title !== '') {
                assembledData.push({id: id, type: type, title: title, parameters: parameters});
            }
        }
        setLocalItem(ASSEMBLED_FEEDBACK, assembledData);
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        saveData();
        renderCatalogOverview();
    });
    $(formatClone).find('#list-container').unbind('saveData').bind('saveData', function (event) {
//        console.log('save data catched');
        saveData();
    });
    initQuestionnaireButtonGroup(formatClone, $(formatClone).find('#add-feedback-button-group'), $(formatClone).find('#list-container'), formatClone, true, true, ALERT_NO_PHASE_DATA);
}

function initCatalogScenesOverlay(formatClone) {
    $(formatClone).find('#overlay-title').text(translation.studyCatalogs.scenes);
    initDynamicAffixScrolling(formatClone);
    var data = getLocalItem(ASSEMBLED_SCENES);
    if (data && data.length > 0) {
        renderData(data);
    } else {
        appendAlert(formatClone, ALERT_NO_PHASE_DATA);
    }

    function renderData(data) {
        for (var i = 0; i < data.length; i++) {
            var item = data[i];
            var clone = $('#form-item-container').find('#' + item.type).clone();
            clone.find('.title').val(item.title);
            clone.attr('name', item.id);
            $(formatClone).find('#list-container').append(clone);
            updateBadges($(formatClone).find('#list-container'), item.type);

            switch (item.type) {
                case SCENE_PIDOCO:
                    if (item.parameters && item.parameters.url) {
                        $(clone).find('.pidoco-embed-url').val(item.parameters.url);
                        $(clone).find('.checkPidocoEmbedURL').click();
                    }
                    break;
                case SCENE_WEB:
                    if (item.parameters && item.parameters.url) {
                        $(clone).find('.website-url').val(item.parameters.url);
                    }
                    break;
                case SCENE_IMAGE:
                    if (item.parameters && item.parameters.url) {
                        $(clone).find('.imageAreaContent').attr("src", item.parameters.url);
                        $(clone).find('.imageArea').removeClass('hidden');
                        $(clone).find('.chooseSceneImage .btn-text').text('Anderes Bild auswählen');
                        $(clone).find('.chooseSceneImage .btn-icon').removeClass('fa-picture');
                        $(clone).find('.chooseSceneImage .btn-icon').addClass('fa-refresh');
                    }
                    break;
                case SCENE_VIDEO_EMBED:
                    if (item.parameters && item.parameters.url && item.parameters.ratio) {
                        $(clone).find('.video-embed-url').val(item.parameters.url);
                        $(clone).find('.checkVideoEmbedURL').click();
                        $(clone).find('.ratioSelect #' + item.parameters.ratio).click();
                    }
                    break;
            }
        }

        checkCurrentListState($(formatClone).find('#list-container'));
    }

    function saveData() {
        var assembledData = new Array();
        var items = $(formatClone).find('#list-container').children();
        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            var type = $(item).attr('id');
            var name = $(item).attr('name');
            var title = $(item).find('.title').val();
            var parameters = {};
//            var data = new Array();
            if (name === undefined || name === null) {
                name = chance.natural();
            }

            switch (type) {
                case SCENE_PIDOCO:
                    var pidocoEmbedUrl = $(item).find('.pidoco-embed-url').val();
                    if (urlIsValid(pidocoEmbedUrl, TYPE_URL_PIDOCO_EMBED)) {
                        parameters.url = pidocoEmbedUrl;
                    }
                    break;
                case SCENE_WEB:
                    parameters.url = $(item).find('.website-url').val();
                    break;
                case SCENE_IMAGE:
                    if ($(item).find('.imageArea').hasClass('hidden') !== true) {
                        parameters.url = $(item).find('.imageAreaContent').attr('src');
                    }
                    break;
                case SCENE_VIDEO_EMBED:
                    var videoEmbedUrl = $(item).find('.video-embed-url').val();
                    parameters.ratio = $(item).find('.ratioSelect .chosen').attr('id');
                    if (urlIsValid(videoEmbedUrl, TYPE_URL_VIDEO_EMBED)) {
                        parameters.url = videoEmbedUrl;
                    }
                    break;
            }

//            console.log(parameters);
            assembledData.push({id: name, type: type, title: title, parameters: parameters});
        }
        setLocalItem(ASSEMBLED_SCENES, assembledData);
    }

    $(formatClone).find('.btn-close-overlay').unbind('click').bind('click', function (event) {
        saveData();
        renderCatalogOverview();
    });

    $(formatClone).find('#list-container').unbind('saveData').bind('saveData', function (event) {
//        console.log('save data catched');
        initControlButtons();
        saveData();
    });

    function initControlButtons() {
        $(formatClone).find('.btn-increase-image').unbind('click').bind('click', function (event) {
            event.preventDefault();
            TweenMax.to($(this).closest('.imageArea'), .3, {width: '100%'});
        });

        $(formatClone).find('.btn-decrease-image').unbind('click').bind('click', function (event) {
            event.preventDefault();
            TweenMax.to($(this).closest('.imageArea'), .3, {width: '400px'});
        });

        $(formatClone).find('.btn-increase-video-embed').unbind('click').bind('click', function (event) {
            event.preventDefault();
            TweenMax.to($(this).closest('.root'), .3, {width: '100%'});
        });

        $(formatClone).find('.btn-decrease-video-embed').unbind('click').bind('click', function (event) {
            event.preventDefault();
            TweenMax.to($(this).closest('.root'), .3, {width: '400px'});
        });
    }

    initControlButtons();
    initPopover();
    initQuestionnaireButtonGroup(formatClone, $(formatClone).find('#add-scenes-button-group'), $(formatClone).find('#list-container'), formatClone, true, true, ALERT_NO_PHASE_DATA);
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
//    console.log('on move complete');
    $(listContainer).append(clone);
    checkCurrentListState(listContainer);
    if (itemType) {
        updateBadges(listContainer, itemType);
    }

    if (fixDynamicAffixScrolling && fixDynamicAffixScrolling === true) {
        resetDynamicAffixScrolling(formatClone);
    }

//    TweenMax.from(clone, 1, {y: -40, opacity: 0, ease: Elastic.easeOut, clearProps: 'all'});
    $(listContainer).trigger('listItemAdded', [clone]);
    initPopover();
}

function initDynamicAffixScrolling(target) {
    resetDynamicAffixScrolling(target);
    $(window).unbind('scroll resize').bind('scroll resize', function (event) {
        if (event.type === 'resize') {
            resetDynamicAffixScrolling(target);
        } else {
            var dynamicAffix = $(target).find('.toggle-dynamic-affix');
            for (var i = 0; i < dynamicAffix.length; i++) {
                var bodyelem = $("html,body");
                if (getBrowser() === BROWSER_SAFARI)
                    bodyelem = $("body");

                var documentScroll = $(bodyelem).scrollTop();
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
        clone.attr('id', itemType);
        clone.attr('name', chance.natural());
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
        $('html,body').animate({
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
//        if (!event.handled) {
        var addedElement = $(event.target).children().last();
        initializeItemType(addedElement);
        clearAlerts(alertContainer);
        var newScrollTop = Math.max(0, $(addedElement).offset().top + $(addedElement).height() - $(window).height()); // 190 due to padding-top 110px + padding-bottom 80px
        $('html,body').animate({
            scrollTop: newScrollTop
        }, 200);
//        }
    });
}

function initQuestionnaireListChange(formatClone, listContainer, alertContainer, alertFormat) {
    $(listContainer).unbind('change').bind('change', function (event) {
        event.preventDefault();
        if ($(this).children().length > 0) {
            clearAlerts(alertContainer);
        } else if (alertFormat) {
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
            renderFormatItem(listContainer, obeservationItems[i], null, false);
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
//        console.log(questionnaire);
    }
}