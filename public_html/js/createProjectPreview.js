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
//    console.log(getPreviewItem());
}

function renderModeratorView() {
    var rightContent = getPreviewItem();
    $('#viewModerator .phase-content-right').append(rightContent);
}

function getPreviewItem() {
    var currentPhase = getCurrentPhase();
    var currentPhaseData = getLocalItem(currentPhase.id + '.data');
    var source = getPreviewContainer(currentView);
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
            previewItem = getScenarioPreview(source, container, currentPhaseData)
            break;
    }

//    console.log(previewItem);
    return previewItem;
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
        $(item).find('.question').text(i + 1 + '. ' + data[i].itemText);
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
        $(item).find('.question').text(i + 1 + '. ' + data[i].itemText);
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
    if (data.training.length === 1) {
        $(container).find('#training .panel-heading-text').text("1" + translation.gesture);
        $(container).find('#training #next-gesture').addClass('hidden');
    } else {
        $(container).find('#training .panel-heading-text').text(data.training.length + " " + translation.gestures);
        $(container).find('#training #training-done').addClass('hidden');
    }

    $(container).find('#next-gesture').unbind('click').bind('click', function (event) {
        event.preventDefault();
        nextGesture(source, $(container).find('#training'), data.training);
    });

    $(container).find('#training-done').unbind('click').bind('click', function (event) {
        event.preventDefault();
        nextStep();
    });

    currentGestureIndex = 0;
    nextGesture(source, $(container).find('#training'), data.training);

    // observation section
    if (data.observations && data.observations.length > 0) {
        getQuestionnaireInputs(getPreviewContainer(VIEW_TESTER), $(container).find('#observations'), data.observations);
    }

    return container;
}

var currentGestureIndex = 0;
function nextGesture(source, container, data) {
    source = $('#template-gesture');
    var training = data[currentGestureIndex];
    var gesture = training.gesture;
    var repeats = training.repeats;
    var trigger = training.trigger;
    var feedback = training.feedback;

    var thumbnail = $(source).find('#preview-panel-gesture-training').clone();
    $(container).find('#gestureThumbnailContainer').empty();
    $(container).find('#gestureThumbnailContainer').append(thumbnail);
    thumbnail.attr('id', gesture.id);
    thumbnail.find('#title').text(gesture.title);
    thumbnail.find('#repeats').text(translation.repeats + ": " + repeats);
    thumbnail.find('#trigger').text(translation.trigger + ": " + trigger.title);

    if (feedback) {
        thumbnail.find('#feedback').text(translation.feedback + ": " + feedback.title);
    } else {
        thumbnail.find('#feedback').text(translation.feedback + ": " + translation.nones);
    }
    renderGestureImages(thumbnail.find('.imageContainer'), gesture.images, gesture.previewImage);

    if (currentGestureIndex >= (data.length - 1)) {
        $(container).find('#next-gesture').addClass('hidden');
        $(container).find('#training-done').removeClass('hidden');
    }
    currentGestureIndex++;
}

var currentSceneId;
// scenario section
function getScenarioPreview(source, container, data) {
    console.log('getScenarioPreview: ' + data);

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


// gesture thumbnail
//var currentSlide, prevSlide;
//function renderGestureImages(container, images, preview) {
//    for (var j = 0; j < images.length; j++) {
//        var image = $('#gestureThumbnailImage').clone();
//        image.attr('src', images[j]);
//        image.removeAttr('id');
//        container.append(image);
//
//        if ($(container).hasClass('mouseScrollable')) {
//            $(container).unbind('mousemove').bind('mousemove', function (event) {
////            $('body').on('mousemove', '.mouseScrollable', function (event) {
//                clearTimer();
//                var innerWidth = $(this).innerWidth();
//                var numslides = $(this).children().length;
//
//                if (event.type === 'mousemove') {
//                    var x = event.pageX - $(this).offset().left;
//                    currentSlide = Math.floor(x / (innerWidth / numslides)) + 1;
//
//                    if (currentSlide !== prevSlide) {
//                        $(this).children('.active').addClass('hidden');
//                        $(this).children('.active').removeClass('active');
//                        $(this).find(':nth-child(' + currentSlide + ')').removeClass('hidden');
//                        $(this).find(':nth-child(' + currentSlide + ')').addClass('active');
//                        prevSlide = currentSlide;
//                    }
//                    return false;
//                }
//            });
//        } else {
//            $(container).unbind('mouseenter').bind('mouseenter', function (event) {
//                event.preventDefault();
//                playThroughThumbnails($(this), 0);
//            });
//        }
//
//
//        $(container).unbind('mouseleave').bind('mouseleave', function (event) {
//            event.preventDefault();
//            prevSlide = 0;
//            resetThumbnails($(this));
//        });
//
//        if (j !== preview) {
//            image.addClass('hidden');
//        } else {
//            image.addClass('previewImage');
//            image.addClass('active');
//        }
//    }
//}
//
//function playThroughThumbnails(container, current) {
//    var children = $(container).children();
//
//    if (current >= children.length - 1)
//        current = 0;
//    else
//        current++;
//
//    for (var i = 0; i < children.length; i++) {
//        if (i === current) {
//            $(children[i]).removeClass('hidden');
//            $(children[i]).addClass('active');
//        } else {
//            $(children[i]).addClass('hidden');
//            $(children[i]).removeClass('active');
//        }
//    }
//
//    gestureThumbnail = setTimeout(function () {
//        playThroughThumbnails(container, current);
//    }, GESTURE_THUMBNAIL_SCROLLING_SPEED);
//}
//
//function resetThumbnails(container) {
//    clearTimer();
//    var children = $(container).children();
//    for (var i = 0; i < children.length; i++) {
//        if ($(children[i]).hasClass('previewImage')) {
//            $(children[i]).removeClass('hidden');
//            $(children[i]).addClass('active');
//        } else {
//            $(children[i]).addClass('hidden');
//            $(children[i]).removeClass('active');
//        }
//    }
//}
//
//function clearTimer() {
//    clearTimeout(gestureThumbnail);
//}

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
//                renderRating(source, item, options);
                break;
            case SUM_QUESTION:
//                renderSumQuestion(source, item, parameters, options);
                break;
            case RANKING:
//                renderRanking(source, item, options);
                break;
            case ALTERNATIVE_QUESTION:
//                renderAlternativeQuestion(source, item, parameters);
                break;
        }
    }
    return container;
}

function renderDichotomousQuestionInput(item, parameters) {
    if (parameters[0] === true) {
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
        var option = $(item).find('#option-item-optionalanswer-' + optionType).clone().removeClass('hidden').removeAttr('id');
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