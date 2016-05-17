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
//    console.log(getPreviewItem());
}

function renderModeratorView() {
    var rightContent = getPreviewItem();
    $('#viewModerator .phase-content-right').append(rightContent);
}

function getPreviewItem() {
    var currentPhase = getCurrentPhase();
    var currentPhaseData = getLocalItem(currentPhase.id + '.data');
    var source = getPreviewContainer();
    console.log('clone: ' + currentPhase.selectedId + ', from: ' + source.attr('id'));
    var container = $(source).find('#' + currentPhase.selectedId).clone(false).removeAttr('id');
    console.log(currentPhaseData);
    var previewItem = null;

    switch (currentPhase.selectedId) {
        case QUESTIONNAIRE:
            previewItem = getQuestionnairePreview(source, container, currentPhaseData);
            break;
        case GUS_SINGLE_GESTURES:
            previewItem = getGUSPreview(source, container, currentPhaseData);
            break;
        case GUS_MULTIPLE_GESTURES:
            previewItem = getQuestionnairePreview(source, container, currentPhaseData);
            break;
        case SUS:
            previewItem = getSUSPreview(source, container, currentPhaseData);
            break;
        case LETTER_OF_ACCEPTANCE:
            previewItem = getLetterOfAcceptancePreview(container, currentPhaseData);
            break;
        case GESTURE_TRAINING:
            previewItem = getGestureTrainingPreview(source, container, currentPhaseData);
            break;
        case SCENARIO:
            break;
    }

    console.log(previewItem);
    return previewItem;
}

function getPreviewContainer() {
    return currentView === VIEW_MODERATOR ? $('#preview-item-container') : $('#input-item-container');
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
        $(item).find('.question').text(i + 1 + '. ' + data[i].itemText);
        $(container).find('.question-container').append(item);
        if (data[i].reversed === true) {
            $(item).find('#reversed').removeClass('hidden');
            $(item).find('#reversed').text(translation.reversed);
        }
    }
    return container;
}

function getGUSPreview(source, container, data) {
    for (var i = 0; i < data.length; i++) {
        var item = $(source).find('#gusItem').clone(false).removeAttr('id');
        $(item).find('.question').text(i + 1 + '. ' + data[i].itemText);
        $(container).find('.question-container').append(item);
        if (data[i].reversed === true) {
            $(item).find('#reversed').removeClass('hidden');
            $(item).find('#reversed').text(translation.reversed);
        }
        if (data[i].dimension !== DIMENSION_ANY) {
            $(item).find('#dimension').removeClass('hidden');
            $(item).find('#dimension').text(translation.dimensions[data[i].dimension]);
        }
    }
    return container;
}

function getLetterOfAcceptancePreview(container, data) {
    $(container).find('.panel-heading').text(translation.formats.letterOfAcceptance);
    $(container).find('.letter-text').text(data);
    return container;
}

function getGestureTrainingPreview(source, container, data) {
    $(container).find('#general .panel-heading').text(data.title);
    $(container).find('#general #description').text(data.description);
    if(data.useSingleTraining === true) {
        $(container).find('#trainingSteps').text(translation.singleGestureTraining);
    } else {
        $(container).find('#trainingSteps').text(translation.multiGestureTraining);
    }
    
    return container;
}

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
        ratingItem.find('#rating-header').text(options[j][options[j].length - 1]);
        for (var k = 0; k < options[j].length - 1; k++) {
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