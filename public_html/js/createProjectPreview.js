function checkStorage() {
    if (getLocalItem(PROJECT_PHASE_STEPS) && getLocalItem(PROJECT_PHASE_STEPS).length > 0) {
//        console.log('there are phase steps');
        initialize();
        renderPhases();

    } else {
//        console.log('there are no phase steps');
    }
}

function initialize() {
    var project = getLocalItem(PROJECT);
    if (project.surveyType === TYPE_SURVEY_UNMODERATED) {
        showTesterView();
        $('#btnViewModerator').addClass('disabled');
    } else {
        showModeratorView();
    }
}

function renderPhases() {
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);

    var dropdown = $('body').find('.phaseStepsSelect');
    $(dropdown).find('.option').empty();

    if (phaseSteps && phaseSteps.length > 0) {
        $(dropdown).find('.dropdown-toggle').removeClass('disabled');
        var listItem;

        for (var i = 0; i < phaseSteps.length; i++) {
            listItem = document.createElement('li');
            listItem.setAttribute('id', phaseSteps[i].id);

            var link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(translation.formats[phaseSteps[i].selectedId]));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);

            if (i === 0) {
                link.click();
            }
        }
        $('body').find('.option-prototype').attr('placeholder', 'Bitte wählen');
    } else {
        $(dropdown).find('.dropdown-toggle').addClass('disabled');
        $('body').find('.option-prototype').attr('placeholder', 'Keine Projektphasen vorhanden');
    }

    var dropdownmenu = dropdown.find('.dropdown-menu');
    var width = dropdownmenu.width() - 35;
    $(dropdownmenu).css('left', -width);
}

function previousStep() {
    $('.phaseStepsSelect .dropdown-menu .selected').prev().click();
}

function nextStep() {
    $('.phaseStepsSelect .dropdown-menu .selected').next().click();
}

function updatePager() {
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);
    if (phaseSteps && phaseSteps.length > 1) {
        var currentStepCount = getCurrentStep();
        if (currentStepCount <= 0) {
            $('.previous').addClass('disabled');
            $('.next').removeClass('disabled');
        } else if (currentStepCount >= phaseSteps.length - 1) {
            $('.previous').removeClass('disabled');
            $('.next').addClass('disabled');
        } else {
            $('.previous').removeClass('disabled');
            $('.next').removeClass('disabled');
        }
    } else {
        $('.previous').addClass('disabled');
        $('.next').addClass('disabled');
    }
}

function updateProgress() {
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);
    var percentage = Math.round(100 / phaseSteps.length * (getCurrentStep() + 1));

    $('#progressTop').find('.progress-bar').attr('aria-valuenow', percentage);
    $('#progressTop').find('.progress-bar').css('width', percentage + '%');
    $('#progressTop').find('.progress-bar').text(percentage + '%');

}

function getCurrentStep() {
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);
    var currentStepId = $('#btn-phaseStepSelect .chosen').attr('id');
    for (var i = 0; i < phaseSteps.length; i++) {
        if (currentStepId === phaseSteps[i].id) {
            return i;
        }
    }
}

function getCurrentPhase() {
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);
    var currentStepId = $('#btn-phaseStepSelect .chosen').attr('id');
    for (var i = 0; i < phaseSteps.length; i++) {
        if (currentStepId === phaseSteps[i].id) {
            return phaseSteps[i];
        }
    }
    return null;
}

function renderTesterView() {
    $('.alert-space').empty();

    var currentPhase = getCurrentPhase();
    var currentPhaseData = getLocalItem(currentPhase.id + '.data');
    var source = getPreviewContainer(currentView);
    console.log('clone: ' + currentPhase.selectedId + ', from: ' + source.attr('id'));
    var container = $(source).find('#' + currentPhase.selectedId).clone(false).removeAttr('id');
    console.log(currentPhaseData);
    var item = null;

    switch (currentPhase.selectedId) {
        case QUESTIONNAIRE:
            item = getQuestionnaireInputs(source, container, currentPhaseData);
            break;
        case GUS_SINGLE_GESTURES:
            item = getGUSInput(source, container, currentPhaseData);
            break;
        case GUS_MULTIPLE_GESTURES:
            item = getQuestionnaireInputs(source, container, currentPhaseData);
            break;
        case SUS:
            item = getSUSInput(source, container, currentPhaseData);
            break;
        case GESTURE_TRAINING:
            item = getGestureTrainingInput(source, container, currentPhaseData);
            break;
        case LETTER_OF_ACCEPTANCE:
            item = getLetterOfAcceptanceInput(container, currentPhaseData);
            break;
    }

    $('#viewTester #phase-content').empty().append(item);
}

function renderModeratorView() {
    $('.alert-space').empty();

    var currentPhase = getCurrentPhase();
    var currentPhaseData = getLocalItem(currentPhase.id + '.data');
    var source = getPreviewContainer(currentView);
    console.log('clone: ' + currentPhase.selectedId + ', from: ' + source.attr('id'));
    var container = $(source).find('#' + currentPhase.selectedId).clone(false).removeAttr('id');
    console.log(currentPhaseData);
    var item = null;

    switch (currentPhase.selectedId) {
        case QUESTIONNAIRE:
            item = getQuestionnairePreview(source, container, currentPhaseData);
            break;
        case GUS_SINGLE_GESTURES:
            item = getGUSPreview(source, container, currentPhaseData);
            break;
        case GUS_MULTIPLE_GESTURES:
            item = getQuestionnairePreview(source, container, currentPhaseData);
            break;
        case SUS:
            item = getSUSPreview(source, container, currentPhaseData);
            break;
        case LETTER_OF_ACCEPTANCE:
            item = getLetterOfAcceptancePreview(container, currentPhaseData);
            break;
        case GESTURE_TRAINING:
            item = getGestureTrainingPreview(source, container, currentPhaseData);
            break;
        case SCENARIO:
            item = getScenarioPreview(source, container, currentPhaseData);
            break;
        case SLIDESHOW:
            item = getSlideshowPreview(source, container, currentPhaseData);
            break;
    }

    $('#viewModerator #phase-content').empty().append(item);
//    $('#viewModerator #column-left').prepend($('#web-rtc-placeholder').clone().removeAttr('id').removeClass('hidden'));
    $(window).resize();
}

function getPreviewContainer(selector) {
    return selector === VIEW_MODERATOR ? $('#preview-item-container') : $('#input-item-container');
}

function getQuestionnairePreview(source, container, data) {
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

        switch (data[i].type) {
            case DICHOTOMOUS_QUESTION:
                renderDichotomousQuestion(item, parameters);
                break;
            case GROUPING_QUESTION:
                renderGroupingQuestion(source, item, parameters, options);
                break;
            case RATING:
                renderRating(source, item, options);
                break;
            case SUM_QUESTION:
                renderSumQuestion(source, item, parameters, options);
                break;
            case RANKING:
                renderRanking(source, item, options);
                break;
            case ALTERNATIVE_QUESTION:
                renderAlternativeQuestion(source, item, parameters);
                break;
        }
    }
    return container;
}

function getSUSPreview(source, container, data) {
    for (var i = 0; i < data.length; i++) {
        var item = $(source).find('#susItem').clone(false).removeAttr('id');
        $(item).find('.question').text(i + 1 + '. ' + data[i].question);
        $(container).find('.question-container').append(item);
        if (data[i].reversed === true) {
            $(item).find('#reversed').removeClass('hidden');
        }
    }
    return container;
}

function getGUSPreview(source, container, data) {
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
}

function getLetterOfAcceptancePreview(container, data) {
    $(container).find('.letter-text').text(data);
    return container;
}

// gesture training
function getGestureTrainingPreview(source, container, data) {

    // general data section
    $(container).find('#general .panel-heading').text(data.title);
    $(container).find('#general #description').text(data.description);

    // gestures section
//    currentGestureTrainingIndex = 0;
    renderTrainingForModerator(source, 'trainingItemModerator', container, data.training);

    // observation section
    if (data.observations && data.observations.length > 0) {
        getQuestionnaireInputs(getPreviewContainer(VIEW_TESTER), $(container).find('#observations'), data.observations);
    }

    return container;
}


var currentGestureTrainingIndex = 0;
var trainingTriggered = false;
function renderTrainingForModerator(source, itemId, container, data) {
    var training = data[currentGestureTrainingIndex];
    var gesture = training.gesture;
    var repeats = training.repeats;
    var trigger = training.trigger;
    var feedback = training.feedback;

//    console.log(training);

    $(container).find('#training .panel-heading-text').text('Geste ' + (currentGestureTrainingIndex + 1) + ' von ' + data.length);

    var item = $(source).find('#' + itemId).clone().removeAttr('id');
    $(container).find('#trainingContainer').empty();
    $(container).find('#trainingContainer').append(item);
    item.find('#title').text(translation.title + ": " + gesture.title);
    item.find('#repeats').text(translation.repeats + ": " + repeats);
    item.find('#trigger').text(translation.trigger + ": " + trigger.title);

    if (feedback) {
        item.find('#feedback').text(translation.feedback + ": " + feedback.title);
    } else {
        item.find('#feedback').text(translation.feedback + ": " + translation.nones);
    }

    item.find('#trigger-training').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(item).find('.disabled').removeClass('disabled');
            $(this).addClass('disabled');
            trainingTriggered = true;
        } else {
            wobble(item.find('#next-gesture, #training-done'));
        }
    });

    item.find('#next-gesture').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            currentGestureTrainingIndex++;
            trainingTriggered = false;
            renderTrainingForModerator(source, itemId, container, data);
        } else {
            wobble(item.find('#trigger-training'));
        }
    });

    item.find('#training-done').bind('click', function (event) {
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

    renderGestureImages($(container).find('.imageContainer'), gesture.images, gesture.previewImage);
}


//function showGesture(thumbnailId, container, data) {
//    var training;
//    if (currentGestureTrainingIndex === null) {
//        appendAlert(container, ALERT_WAITING_FOR_TRAINING_GESTURE);
//        return false;
//    } else {
//        removeAlert(container, ALERT_WAITING_FOR_TRAINING_GESTURE);
//        training = data[currentGestureTrainingIndex];
//    }
//
//    var gesture = training.gesture;
//
//    var thumbnail = $('#template-gesture').find('#' + thumbnailId).clone();
//    $(container).find('#gestureThumbnailContainer').empty();
//    $(container).find('#gestureThumbnailContainer').append(thumbnail);
//    thumbnail.attr('id', gesture.id);
//    thumbnail.find('#title').text(gesture.title);
//
//    renderGestureImages(thumbnail.find('.imageContainer'), gesture.images, gesture.previewImage);
//}

// gesture training
var currentSlide = 0;
function getSlideshowPreview(source, container, data) {

    // general data section
    $(container).find('#general .panel-heading').text(data.title);
    $(container).find('#general #description').text(data.description);

    // slideshow section
    currentSlide = 0;
    renderSlide(source, 'slideshowItem', container, data);

    // observation section
    if (data.observations && data.observations.length > 0) {
        getQuestionnaireInputs(getPreviewContainer(VIEW_TESTER), $(container).find('#observations'), data.observations);
    }

    return container;
}

function renderSlide(source, itemId, container, data) {
    $(container).find('#slides .panel-heading-text').text('Slide ' + (currentSlide + 1) + ' von ' + data.slideshow.length);
    $(container).find('#slidesContainer').empty();
    var item = $(source).find('#' + itemId).clone().removeAttr('id');
    $(container).find('#slidesContainer').append(item);
    var slide = data.slideshow[currentSlide];

    var imageContainer;
    console.log(data.slideshowFor);
    if (data.slideshowFor === 'trigger') {
        $(item).find('.left .triggerContainer').addClass('hidden');
        imageContainer = $(item).find('.left .imageContainer');
    } else {
        $(item).find('.right .triggerContainer').addClass('hidden');
        imageContainer = $(item).find('.right .imageContainer');
    }

    renderGestureImages(imageContainer, slide.gesture.images, slide.gesture.previewImage);
    $(item).find('.triggerContainer').text(slide.trigger.title);

    $(item).find('#trigger-slide').on('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(item).find('.disabled').removeClass('disabled');
            $(this).addClass('disabled');
        } else {
            wobble($(item).find('#correct-slide, #next-slide, #wrong-slide'));
        }
    });

    $(item).find('#wrong-slide').on('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            currentSlide = 0;
            $(item).find('.disabled').removeClass('disabled');
            renderSlide(source, itemId, container, data);
        } else {
            wobble($(item).find('#trigger-slide'));
        }
    });

    if (data.slideshow.length === 1 || currentSlide >= data.slideshow.length - 1) {
        $(item).find('#correct-slide, #next-slide').on('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                nextStep();
            } else {
                wobble($(item).find('#trigger-slide'));
            }
        });
    } else if (currentSlide < data.slideshow.length) {
        $(item).find('#correct-slide, #next-slide').on('click', function (event) {
            event.preventDefault();
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                currentSlide++;
                renderSlide(source, itemId, container, data);
            } else {
                wobble($(item).find('#trigger-slide'));
            }
        });
    }

}


// scenario section
var currentSceneId;
function getScenarioPreview(source, container, data) {
//    console.log('getScenarioPreview: ' + data);

    $(container).find('#general #task').text(translation.task + ": " + data.title);
    $(container).find('#general #description').text(translation.description + ": " + data.description);

    //scene
    if (data.scene) {
        $(container).find('#general #scene').removeClass('hidden');
        $(container).find('#general #scene').unbind('click').bind('click', function (event) {
//            console.log('scene clicked');
            currentSceneId = data.scene;
            event.preventDefault();
            loadHTMLintoModal('custom-modal', 'preview-scene.html', 'modal-lg');
        });
    }

    //woz section
    if (data.woz && data.woz.length > 0) {
        getWOZPreview(source, container, data.woz);
    }

    // help section
    if (data.help && data.help.length > 0) {
        getHelpPreview(source, container, data.help);
    }

    // observation section
    if (data.observations && data.observations.length > 0) {
        getQuestionnaireInputs(getPreviewContainer(VIEW_TESTER), $(container).find('#observations'), data.observations);
    }

    return container;
}

// dichotomous question
function renderDichotomousQuestion(item, parameters) {
    if (parameters[0] === true) {
        item.find('#select-gestures').removeClass('hidden');
    }
    if (parameters[1] === true) {
        item.find('#justification').removeClass('hidden');
    }
}

function renderGroupingQuestion(source, item, parameters, options) {
    if (parameters[0] === true) {
        item.find('#multiselect').removeClass('hidden');
    }
    if (parameters[1] === true) {
        item.find('#optionalanswer').removeClass('hidden');
    }

    for (var j = 0; j < options.length; j++) {
        var optionItem = $(source).find('#option-item').clone(false).removeAttr('id');
        optionItem.text(options[j]);
        item.find('.option-container').append(optionItem);
    }
}

function renderRating(source, item, options) {
    for (var j = 0; j < options.length; j++) {
        var ratingItem = $(source).find('#rating-item').clone().removeAttr('id');
        if (options[j][options[j].length - 1] === true) {
            ratingItem.find('#reversed').removeClass('hidden');
        }

        ratingItem.find('#rating-header').text(options[j][options[j].length - 2]);
        for (var k = 0; k < options[j].length - 2; k++) {
            var optionItem = $(source).find('#option-item').clone(false).removeAttr('id');
            optionItem.text(options[j][k]);
            ratingItem.find('#scales-container').append(optionItem);
        }

        item.find('.option-container').append(ratingItem);
    }
}

function renderSumQuestion(source, item, parameters, options) {
    if (parameters[1] !== null) {
        var maximum = $(source).find('#option-item').clone(false).removeAttr('id');
        maximum.text(translation.maximum + ': ' + parameters[1]);
        item.find('#distribution-container').append(maximum);
    }
    if (parameters[0] !== null) {
        var percent = $(source).find('#option-item').clone(false).removeAttr('id');
        percent.text(translation.scales[parameters[0]]);
        item.find('#distribution-container').append(percent);
    }


    for (var j = 0; j < options.length; j++) {
        var optionItem = $(source).find('#option-item').clone(false).removeAttr('id');
        optionItem.text(options[j]);
        item.find('.option-container').append(optionItem);
    }
}

function renderRanking(source, item, options) {
    for (var j = 0; j < options.length; j++) {
        var optionItem = $(source).find('#option-item').clone(false).removeAttr('id');
        optionItem.text(options[j]);
        item.find('.option-container').append(optionItem);
    }
}

function renderAlternativeQuestion(source, item, parameters) {
    $(item).find('#alternative').removeClass('hidden');
    $(item).find('#alternative').text('Alternative ' + parameters[0]);
    $(item).find('#alternativeFor').removeClass('hidden');
    $(item).find('#alternativeFor').text('für ' + parameters[1]);
    $(item).find('#title').text(parameters[2].title);

    if (parameters[0] === ALTERNATIVE_GESTURES) {
        $(item).find('#gesture-container').removeClass('hidden');
    }
}

function renderDichotomousQuestionInput(item, parameters) {
    if (parameters[1] === true) {
        item.find('#justification').removeClass('hidden');
    }
}

function renderGroupingQuestionInput(source, item, parameters, options) {
    var optionType = parameters[0] === true ? 'checkbox' : 'radio';
    for (var i = 0; i < options.length; i++) {
        var option = $(item).find('#option-item-' + optionType).clone().removeClass('hidden').removeAttr('id');
        option.find('.option-text').text(options[i]);
        $(item).find('.option-container').append(option);
    }

    if (parameters[1] === true) {
        var option = $(item).find('#option-item-optionalanswer').clone().removeClass('hidden').removeAttr('id');
        $(item).find('.option-container').append(option);
    }
}

function getWOZPreview(source, container, data) {
    source = $("#template-gesture");
    for (var i = 0; i < data.length; i++) {
        var item = $(source).find('#preview-panel-gesture-woz').clone();
        item.removeAttr('id');
        item.find('.help-title').text((i + 1) + ". " + data[i].option);
        $(container).find('.woz-container').append(item);
//        console.log(data);

        if (data[i].gesture) {
            item.find('.panel-heading').text(data[i].gesture.title);
            renderGestureImages(item.find('.imageContainer'), data[i].gesture.images, data[i].gesture.previewImage);
        }

        if (data[i].feedback) {
            item.find('#trigger').text(data[i].feedback.title);
        } else if (data[i].trigger) {
            item.find('#trigger').text(data[i].trigger.title);
        }
    }
    return container;
}

var currentGestureId;
var currentModalId;
function getHelpPreview(source, container, data) {
    for (var i = 0; i < data.length; i++) {
        var item = $(source).find('#helpItem').clone();
        item.removeAttr('id');
        item.find('.help-title').text((i + 1) + ". " + data[i].option);
        $(container).find('.help-container').append(item);
//        console.log(container);

        var gesture = null;
        if (data[i].useGestureHelp === true) {
            gesture = getGestureById(data[i].gestureId);
            item.find('#show-gesture').removeClass('hidden');
            item.find('#show-gesture').attr('name', gesture.id);
            item.find('#show-gesture').on('click', function (event) {
                event.preventDefault();
                currentGestureId = $(this).attr('name');
                currentModalId = '#custom-modal';
                loadHTMLintoModal('custom-modal', 'info-gesture.html', 'modal-lg');
            });
//            console.log(gesture);
        } else {
            item.find('#show-gesture').remove();
        }



    }
    return container;
}


// input items for Tester
function getQuestionnaireInputs(source, container, data) {
    for (var i = 0; i < data.length; i++) {
        var item = $(source).find('#' + data[i].type).clone(false).removeAttr('id');
        $(item).find('.question').text(i + 1 + '. ' + data[i].question);
        $(container).find('.question-container').append(item);

//        console.log('clone: ' + data[i].type + ', from: ' + source.attr('id'));

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
                renderGroupingQuestionInput(source, item, parameters, options);
                break;
            case RATING:
                renderRatingInput(source, item, options);
                break;
            case SUM_QUESTION:
                renderSumQuestionInput(source, item, parameters, options);
                break;
            case RANKING:
                renderRankingInput(source, item, options);
                break;
            case ALTERNATIVE_QUESTION:
//                renderAlternativeQuestion(source, item, parameters);
                break;
        }
    }
    return container;
}

function getGUSInput(source, container, data) {
    for (var i = 0; i < data.length; i++) {
        var item = $(source).find('#gusItem').clone(false).removeAttr('id');
        $(item).find('.question').text(i + 1 + '. ' + data[i].question);
        $(container).find('.question-container').append(item);
    }
    return container;
}

function getSUSInput(source, container, data) {
    for (var i = 0; i < data.length; i++) {
        var item = $(source).find('#susItem').clone(false).removeAttr('id');
        $(item).find('.question').text(i + 1 + '. ' + data[i].question);
        $(container).find('.question-container').append(item);
    }
    return container;
}


function renderRatingInput(source, item, options) {
    for (var j = 0; j < options.length; j++) {
        var ratingItem = $(source).find('#rating-item').clone().removeAttr('id');
        ratingItem.find('#rating-header').text(options[j][options[j].length - 2]);
        for (var k = 0; k < options[j].length - 2; k++) {
            var optionItem = $(source).find('#rating-scale-item').clone(false).removeAttr('id');
            optionItem.find('.option-text').text(options[j][k]);
            ratingItem.find('#scales-container').append(optionItem);
        }

        item.find('.option-container').append(ratingItem);
    }
}

function renderSumQuestionInput(source, item, parameters, options) {
    console.log(parameters);
    for (var j = 0; j < options.length; j++) {
        var sumQuestionItem = $(source).find('#sumQuestion-item').clone().removeAttr('id');
        sumQuestionItem.find('.option-text').html(options[j]);
        sumQuestionItem.find('.btn-stepper-increase').val(parameters[1]);
        item.find('.option-container').append(sumQuestionItem);

        $(sumQuestionItem).find('.stepper-text').bind('change', function (event) {
            event.preventDefault();
        });
    }
}

function renderRankingInput(source, item, options) {
    for (var j = 0; j < options.length; j++) {
        var ratingItem = $(source).find('#ranking-item').clone().removeAttr('id');
        ratingItem.find('.option-text').html(options[j]);
        item.find('.option-container').append(ratingItem);
        checkCurrentListState(item.find('.option-container'));
    }
}

// gesture training for tester
function getGestureTrainingInput(source, container, data) {

    // general data section
    $(container).find('.headline').text(data.title);
    $(container).find('.description').text(data.description);

    if (data.training.length === 0) {
        appendAlert($('#mainContent'), ALERT_NO_PHASE_DATA);
        return false;
    }

    // gestures section
    if (getLocalItem(PROJECT).surveyType === TYPE_SURVEY_UNMODERATED) {
        renderTrainingForUnmoderatedTester(source, container, data.training);
    } else {
        if (trainingTriggered) {
            renderTrainingForModeratedTester(source, container, data.training);
        } else {
            appendAlert($(container), ALERT_WAITING_FOR_TRAINING_GESTURE);
        }
    }

    return container;
}

function renderTrainingForUnmoderatedTester(source, container, data) {
    var trainingData = data[currentGestureTrainingIndex];
    var item = $(source).find('#trainingItemUnmoderatedTester').clone().removeAttr('id');
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

    renderGestureImages(item.find('.imageContainer'), trainingData.gesture.images, trainingData.gesture.previewImage);

    if (data.length === 1 || currentGestureTrainingIndex >= data.length - 1) {
        item.find('#training-done').removeClass('hidden');
    } else {
        item.find('#next-gesture').removeClass('hidden');
    }

    item.find('#next-gesture').on('click', function (event) {
        event.preventDefault();
        currentGestureTrainingIndex++;
        renderTrainingForUnmoderatedTester(source, container, data);
    });

    item.find('#training-done').on('click', function (event) {
        event.preventDefault();
        currentGestureTrainingIndex = 0;
        nextStep();
    });
}

function renderTrainingForModeratedTester(source, container, data) {
    var trainingData = data[currentGestureTrainingIndex];
    var item = $(source).find('#trainingItemModeratedTester').clone().removeAttr('id');
    $(container).append(item);

    item.find('#title').text(translation.title + ": " + trainingData.gesture.title);
    item.find('#repeats').text(translation.repeats + ": " + trainingData.repeats);
    item.find('#trigger').text(translation.trigger + ": " + trainingData.trigger.title);

    if (trainingData.feedback) {
        item.find('#feedback').text(translation.feedback + ": " + trainingData.feedback.title);
    } else {
        item.find('#feedback').text(translation.feedback + ": " + translation.nones);
    }

    renderGestureImages(item.find('.imageContainer'), trainingData.gesture.images, trainingData.gesture.previewImage);
}

function getLetterOfAcceptanceInput(container, data) {
    $(container).find('.letter-text').text(data);
    $(container).find('#letter-agreed').bind('click', function (event) {
        event.preventDefault();
        nextStep();
    });
    return container;
}