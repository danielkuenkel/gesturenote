/*
 * 
 * @param {type} target
 * @param {type} data
 * @returns {undefined}
 */

$(document).on('change', '.scaleSelect', function (event, result) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var scaleItemContainer = $(this).closest('.root').find('.ratingScaleItemContainer');
        renderScaleItems(scaleItemContainer, result.split('_')[1], undefined);
    }
});
function renderScaleItems(container, count, text)
{
    $(container).empty();
    for (var i = 0; i < count; i++)
    {
        var scaleItem = $('#form-item-container').find('#ratingScaleItem').clone();
        $(container).append(scaleItem);
        if (i === 0) {
            $(scaleItem).find('.input-group-addon').text(translation.of + ' ' + (i + 1));
            $(scaleItem).find('.item-input-text').attr('placeholder', translation.defaultScales[0]);
        } else if (i === count - 1) {
            $(scaleItem).find('.input-group-addon').text(translation.to + ' ' + (i + 1));
            $(scaleItem).find('.item-input-text').attr('placeholder', translation.defaultScales[2]);
        } else {
            $(scaleItem).find('.input-group-addon').text(i + 1);
        }
        if (text !== undefined) {
            $(scaleItem).find('.item-input-text').val(text[i]);
        }
    }
}

function updateBadges(container, selector) {
    if (selector !== null) {
        var children = $(container).children('#' + selector);
        for (var i = 0; i < children.length; i++) {
            $(children[i]).find('.badgeId').text(i + 1);
            $(children[i]).find('.badgeQuantity').text(children.length);
        }
    }
}


/*
 * render the format item for study creation
 */

function renderFormatItem(target, data) {
    var clone = $('#form-item-container').find('#' + data.format).clone();
    $(clone).find('.question').val(data.question);
    clone.addClass(data.dimension);
    target.append(clone);
    
    var parameters = data.parameters;
    var options = data.options;
    switch (data.format) {
        case SUS_ITEM:
            $(clone).find('.negative #' + parameters.negative).click();
            break;
        case COUNTER:
            $(clone).find('#counter-from .stepper-text').val(parameters.countFrom);
            $(clone).find('#counter-to .stepper-text').val(parameters.countTo);
            break;
        case OPEN_QUESTION_GUS:
            if (parameters.used === 'used') {
                $(clone).find('.btn-use').click();
            }
            break;
        case DICHOTOMOUS_QUESTION:
            $(clone).find('.justification #' + parameters.justification).click();
            $(clone).find('.justification-for #' + parameters.justificationFor).click();
            break;
        case DICHOTOMOUS_QUESTION_GUS:
            if (parameters.used === 'used') {
                $(clone).find('.btn-use').click();
            }
            $(clone).find('.justification #' + parameters.justification).click();
            $(clone).find('.justification-for #' + parameters.justificationFor).click();
            break;
        case GROUPING_QUESTION:
            $(clone).find('.multiselect #' + parameters.multiselect).click();
            $(clone).find('.optionalanswer #' + parameters.optionalanswer).click();

            if (options) {
                for (var j = 0; j < options.length; j++) {
                    var option = $('#groupingQuestionItem').clone().removeClass('hidden');
                    $(option).find('.option').val(options[j].title);
                    $(option).attr('id', options[j].id);
                    $(clone).find('.option-container').append(option);
                    checkCurrentListState($(clone).find('.option-container'));
                }
            }
            break;
        case GROUPING_QUESTION_GUS:
            if (parameters.used === 'used') {
                $(clone).find('.btn-use').click();
            }
            $(clone).find('.multiselect .switchButtonAddon').click();
            $(clone).find('.justification #' + parameters.justification).click();
            $(clone).find('.justification-for #' + parameters.justificationFor).click();
            $(clone).find('.optionselect #' + parameters.optionSource).click();
            break;
        case RATING:
            if (options) {
                for (var j = 0; j < options.length; j++) {
                    var option = $('#ratingItem').clone().removeClass('hidden');
                    $(option).find('.option').val(options[j]);
                    $(clone).find('.option-container').append(option);
                    $(option).find('.optionQuestion').val(options[j].option);
                    $(option).find('.chosen').attr('id', (options[j].scales.length));
                    $(option).find('.show-dropdown').val(options[j].scales.length);
                    $(option).find('#scale_' + (options[j].scales.length)).addClass('selected');
                    checkCurrentListState($(clone).find('.option-container'));
                    renderScaleItems($(option).find('.ratingScaleItemContainer'), options[j].scales.length, options[j].scales);
                    $(option).find('#' + options[j].negative).click();
                }
            }
            break;
        case SUM_QUESTION:
            $(clone).find('.allocationSelect #' + parameters.allocation).click();
            $(clone).find('.maximum').val(parameters.maximum);
            if (options) {
                for (var j = 0; j < options.length; j++) {
                    var option = $('#sumQuestionItem').clone().removeClass('hidden');
                    $(option).find('.option').val(options[j]);
                    $(clone).find('.option-container').append(option);
                    checkCurrentListState($(clone).find('.option-container'));
                }
            }
            break;
        case RANKING:
            if (options) {
                for (var j = 0; j < options.length; j++) {
                    var option = $('#rankingItem').clone().removeClass('hidden');
                    $(option).attr('id', options[j].id);
                    $(option).find('.option').val(options[j].text);
                    $(clone).find('.option-container').append(option);
                    checkCurrentListState($(clone).find('.option-container'));
                }
            }
            break;
        case ALTERNATIVE_QUESTION:
            if (parameters.used === 'used') {
                $(clone).find('.btn-use').click();
            }
            $(clone).find('.justification #' + parameters.justification).click();
            $(clone).find('.justification-for #' + parameters.justificationFor).click();
            $(clone).find('.optionalanswer #' + parameters.optionalanswer).click();
            $(clone).find('.alternative #' + parameters.alternative).click();
            var currentPhase = getPhaseById(currentIdForModal);
            if (currentPhase && currentPhase.format === GUS_SINGLE_GESTURES) {
                $(clone).find('#alternativeTrigger').remove();
                $(clone).find('.alternativeFor').addClass('hidden');
                break;
            }

            $(clone).find('#' + parameters.alternativeFor).click();
            if (parameters.alternativeFor === 'alternativeGesture') {
                var gesture = getGestureById(parameters.alternativeForId);
                if (gesture) {
                    if (isGestureAssembled(gesture.id)) {
                        $(clone).find('.option-gesture').val(gesture.title);
                        $(clone).find('.gestureSelect .chosen').attr('id', gesture.id);
                    } else {
                        appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                    }
                }

            } else if (parameters.alternativeFor === 'alternativeTrigger') {

                var trigger = getTriggerById(parameters.alternativeForId);
                if (trigger) {
                    $(clone).find('.option-trigger').val(trigger.title);
                    $(clone).find('.triggerSelect .chosen').attr('id', trigger.id);
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_TRIGGER_REMOVED);
                }
            } else if (parameters.alternativeFor === 'alternativeFeedback') {
                var feedback = getFeedbackById(parameters.alternativeForId);
                if (feedback) {
                    $(clone).find('.option-feedback').val(feedback.title);
                    $(clone).find('.feedbackSelect .chosen').attr('id', feedback.id);
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_FEEDBACK_REMOVED);
                }
            }
            break;
        case GUS_SINGLE:
            if (parameters.used === 'used') {
                $(clone).find('.btn-use').click();
            }
            $(clone).find('.negative #' + parameters.negative).click();
            break;
    }

    var dimension = data.dimension;
    if (dimension !== DIMENSION_ANY) {
        $(clone).find('#item-factors').removeClass('hidden');
        var dimensionButton = $('.dimension-btn-group').find('#' + dimension);
        if (dimensionButton) {
            $(dimensionButton).addClass('active');
            $(dimensionButton).addClass('btn-info');
            $(dimensionButton).removeClass('inactive');
        }
        var dimensions = translation.dimensions;
        var mainDimensions = translation.mainDimensions;
        $(clone).find('#factor-primary').text(dimensions[dimension]);
        $(clone).find('#factor-main').text(mainDimensions[getMainDimensionForDimension(dimension)]);
    }

    TweenMax.from(clone, .3, {y: -20, opacity: 0, clearProps: 'all'});
}


/*
 * get the format item data for study creation
 */
function getFormatData(element) {
    var format = $(element).attr('id');
    var dimension = getDimensionByElement($(element));
    var question = $(element).find('.question').val();
    var parameters = null;
    var options = null;
    switch (format) {
        case SUS_ITEM:
            parameters = {negative: $(element).find('.negative .active').attr('id')};
            break;
        case COUNTER:
            var countFrom = parseInt($(element).find('#counter-from .stepper-text').val());
            var countTo = parseInt($(element).find('#counter-to .stepper-text').val());
            parameters = {countFrom: isNaN(countFrom) ? 0 : parseInt(countFrom), countTo: isNaN(countTo) ? 0 : parseInt(countTo)};
            break;
        case OPEN_QUESTION_GUS:
            parameters = {used: $(element).find('.btn-use').hasClass('used') ? 'used' : 'not-used'};
            break;
        case DICHOTOMOUS_QUESTION:
            parameters = {justification: $(element).find('.justification .active').attr('id'),
                justificationFor: $(element).find('.justification-for .active').attr('id')};
            break;
        case DICHOTOMOUS_QUESTION_GUS:
            parameters = {used: $(element).find('.btn-use').hasClass('used') ? 'used' : 'not-used',
                justification: $(element).find('.justification .active').attr('id'),
                justificationFor: $(element).find('.justification-for .active').attr('id')};
            break;
        case GROUPING_QUESTION:
            parameters = {multiselect: $(element).find('.multiselect .active').attr('id'),
                optionalanswer: $(element).find('.optionalanswer .active').attr('id')};
            options = new Array();
            var groupingOptions = $(element).find('.option-container').children();
            for (var j = 0; j < groupingOptions.length; j++) {
                options.push({id: $(groupingOptions[j]).attr('id'), title: $(groupingOptions[j]).find('.option').val()});
            }
            break;
        case GROUPING_QUESTION_GUS:
            parameters = {used: $(element).find('.btn-use').hasClass('used') ? 'used' : 'not-used',
                multiselect: $(element).find('.multiselect .active').attr('id'),
                optionSource: $(element).find('.optionselect .active').attr('id'),
                justification: $(element).find('.justification .active').attr('id'),
                justificationFor: $(element).find('.justification-for .active').attr('id')};
            break;
        case RATING:
            options = new Array();
            var optionList = $(element).find('.option-container').children();
            for (var j = 0; j < optionList.length; j++) {
                var ratingOptions = ($(optionList[j]).find('.ratingScaleItemContainer').children());
                var tempArray = new Array();
                for (var k = 0; k < ratingOptions.length; k++) {
                    tempArray.push($(ratingOptions[k]).find('.option').val());
                }
                options.push({option: $(optionList[j]).find('.optionQuestion').val(), negative: $(optionList[j]).find('.negative').find('.active').attr('id'), scales: tempArray});
            }
            break;
        case SUM_QUESTION:
            parameters = {allocation: $(element).find('.allocationSelect .chosen').attr('id'),
                maximum: $(element).find('.maximum').val()};
            options = new Array();
            var sumQuestionOptions = $(element).find('.option-container').children();
            for (var j = 0; j < sumQuestionOptions.length; j++) {
                options.push($(sumQuestionOptions[j]).find('.option').val());
            }
            break;
        case RANKING:
            options = new Array();
            var rankingOptions = $(element).find('.option-container').children();
            for (var j = 0; j < rankingOptions.length; j++) {
                var optionId = $(rankingOptions[j]).attr('id');
                options.push({id: optionId, text: $(rankingOptions[j]).find('.option').val()});
            }
            break;
        case ALTERNATIVE_QUESTION:
            parameters = {used: $(element).find('.btn-use').hasClass('used') ? 'used' : 'not-used',
                optionalanswer: $(element).find('.optionalanswer .active').attr('id'),
                justification: $(element).find('.justification .active').attr('id'),
                justificationFor: $(element).find('.justification-for .active').attr('id'),
                alternative: $(element).find('.alternative').find('.active').attr('id')};
            var aGestures = assembledGestures();
            var aTriggers = getLocalItem(ASSEMBLED_TRIGGER);
            var currentPhase = getPhaseById(currentIdForModal);
            if (currentPhase && currentPhase.format === GUS_SINGLE_GESTURES) {
                parameters.alternativeFor = 'alternativeGesture';
                break;
            }

            if (aGestures && $(element).find('.alternativeFor .active').attr('id') === 'alternativeGesture') {
                var gestureId = $(element).find('.alternativeGestureSelect .chosen').attr('id');
                if (gestureId !== 'unselected') {
                    parameters.alternativeFor = 'alternativeGesture';
                    parameters.alternativeForId = gestureId;
                }
            } else if (aTriggers && $(element).find('.alternativeFor .active').attr('id') === 'alternativeTrigger') {
                var triggerId = $(element).find('.triggerSelect .chosen').attr('id');
                if (triggerId !== 'unselected') {
                    parameters.alternativeFor = 'alternativeTrigger';
                    parameters.alternativeForId = triggerId;
                }
            } else if (aTriggers && $(element).find('.alternativeFor .active').attr('id') === 'alternativeFeedback') {
                var feedbackId = $(element).find('.feebackSelect .chosen').attr('id');
                if (feedbackId !== 'unselected') {
                    parameters.alternativeFor = 'alternativeFeedback';
                    parameters.alternativeForId = feedbackId;
                }
            }
            break;
        case GUS_SINGLE:
            parameters = {used: $(element).find('.btn-use').hasClass('used') ? 'used' : 'not-used',
                negative: $(element).find('.negative .active').attr('id')};
            break;
    }
    return {format: format, dimension: dimension, question: question, parameters: parameters, options: options};
//    return new QuestionnaireItem(format, dimension, question, parameters, options);
}


/* 
 * get questionnaire form answers
 */

function getQuestionnaireAnswers(questionnaire) {
    var questionnaireAnswers = new Array();
    for (var i = 0; i < questionnaire.length; i++) {
        var format = $(questionnaire[i]).attr('id');
        switch (format) {
            case COUNTER:
                questionnaireAnswers.push(getCounterAnswers($(questionnaire[i])));
                break;
            case OPEN_QUESTION:
            case OPEN_QUESTION_GUS:
                questionnaireAnswers.push(getOpenQuestionAnswers($(questionnaire[i])));
                break;
            case DICHOTOMOUS_QUESTION:
            case DICHOTOMOUS_QUESTION_GUS:
                questionnaireAnswers.push(getDichotomousQuestionAnswers($(questionnaire[i])));
                break;
            case GROUPING_QUESTION:
                questionnaireAnswers.push(getGroupingQuestionAnswers($(questionnaire[i])));
                break;
            case GROUPING_QUESTION_GUS:
                questionnaireAnswers.push(getGroupingQuestionGUSAnswers($(questionnaire[i])));
                break;
            case RATING:
                questionnaireAnswers.push(getRatingAnswers($(questionnaire[i])));
                break;
            case SUM_QUESTION:
                questionnaireAnswers.push(getSumQuestionAnswers($(questionnaire[i])));
                break;
            case RANKING:
                questionnaireAnswers.push(getRankingAnswers($(questionnaire[i])));
                break;
            case ALTERNATIVE_QUESTION:
                questionnaireAnswers.push(getAlternativeQuestionAnswers($(questionnaire[i])));
                break;
            case GUS_SINGLE:
                questionnaireAnswers.push(getSingleUSAnswers($(questionnaire[i])));
                break;
            case SUS_ITEM:
                questionnaireAnswers.push(getSingleUSAnswers($(questionnaire[i])));
                break;
        }
    }
    return questionnaireAnswers;
}

function getCounterAnswers(source) {
    return {count: $(source).find('.stepper-text').val()};
}

function getOpenQuestionAnswers(source) {
    return {openAnswer: $(source).find('#openQuestionInput').val()};
}

function getDichotomousQuestionAnswers(source) {
    var data = new Object();
    data.selectedSwitch = $(source).find('.switch .active').attr('id') === undefined ? 'none' : $(source).find('.switch .active').attr('id');
    var justificationInput = $(source).find('#justificationInput');
    if (justificationInput && justificationInput.length > 0) {
        data.justification = $(source).find('#justificationInput').val();
    } else {
        data.justification = '';
    }
    return data;
}

function getGroupingQuestionAnswers(source) {
    var data = new Object();
    var selectedOptions = $(source).find('.option-container .btn-option-checked');
    var array = new Array();
    for (var i = 0; i < selectedOptions.length; i++) {
        var selectedId = $(selectedOptions[i]).attr('id');
        if ($(selectedOptions[i]).parent().attr('id') !== 'checkbox-optionalanswer') {
            array.push(selectedId);
        }
    }
    if (array.length === 0) {
        data.selectedOptions = -1;
    } else {
        data.selectedOptions = array;
    }
    data.optionalAnswer = $(source).find('.optionalInput').val();
    return data;
}

function getGroupingQuestionGUSAnswers(source) {
    var data = new Object();
    var selectedOptions = $(source).find('.option-container .btn-option-checked');
    var array = new Array();
    for (var i = 0; i < selectedOptions.length; i++) {
        if ($(selectedOptions[i]).parent().attr('id') !== 'checkbox-optionalanswer') {
            array.push($(selectedOptions[i]).find('.option-text').attr('id'));
        }
    }
    data.selectedOptions = array;
    data.optionalAnswer = $(source).find('.optionalInput').val();
    var justificationInput = $(source).find('#justificationInput');
    if (justificationInput && justificationInput.length > 0) {
        data.justification = $(source).find('#justificationInput').val();
    } else {
        data.justification = '';
    }

    return data;
}

function getRatingAnswers(source) {
    var data = new Object();
    var array = new Array();
    var scalesContainer = $(source).find('.scales-container');
    for (var i = 0; i < scalesContainer.length; i++) {
        array.push($(scalesContainer[i]).find('.btn-option-checked').closest('.btn-group').index() >> 1);
    }
    data.scales = array;
    return data;
}

function getSumQuestionAnswers(source) {
    var data = new Object();
    var array = new Array();
    var sumOptions = $(source).find('.option-container').children();
    for (var i = 0; i < sumOptions.length; i++) {
        array.push($(sumOptions[i]).find('.stepper-text').val());
    }
    data.sumCounts = array;
    return data;
}

function getRankingAnswers(source) {
    var data = new Object();
    var items = $(source).find('.option-container').children();
    var array = new Array();
    for (var i = 0; i < items.length; i++) {
        array.push($(items[i]).attr('id'));
    }
    data.arrangement = array;
    return data;
}

function getAlternativeQuestionAnswers(source) {
    var data = new Object();
    var selectedOptions = $(source).find('.option-container .btn-option-checked');
    var array = new Array();
    for (var i = 0; i < selectedOptions.length; i++) {
        if ($(selectedOptions[i]).parent().attr('id') !== 'checkbox-optionalanswer') {
            array.push($(selectedOptions[i]).find('.option-text').attr('id'));
        }
    }
    data.selectedOptions = array;
    data.optionalAnswer = $(source).find('.optionalInput').val();
    data.justification = $(source).find('#justificationInput').val();
    return data;
}

function getSingleUSAnswers(source) {
    return {selectedOption: $(source).find('.option-container .btn-option-checked').closest('.btn-group').index() >> 1};
}



/*
 * render questionnaire answers
 */

function renderQuestionnaireAnswers(content, studyData, resultsData) {
    for (var i = 0; i < studyData.length; i++) {
        var listItem = $('#template-study-container').find('#' + studyData[i].format).clone();
        listItem.find('#format .format-text').text(translation.questionFormats[studyData[i].format].text);
        $(content).find('.list-container').append(listItem);
        if (studyData[i].dimension !== DIMENSION_ANY) {
            $(listItem).find('#item-factors').removeClass('hidden');
            $(listItem).find('#factor-primary').text(translation.dimensions[studyData[i].dimension]);
            $(listItem).find('#factor-main').text(translation.mainDimensions[getMainDimensionForDimension(studyData[i].dimension)]);
        }

        switch (studyData[i].format) {
            case COUNTER:
                renderCounter(listItem, studyData[i], resultsData.answers[i]);
                break;
            case OPEN_QUESTION:
            case OPEN_QUESTION_GUS:
                renderOpenQuestion(listItem, studyData[i], resultsData.answers[i]);
                break;
            case DICHOTOMOUS_QUESTION:
                renderDichotomousQuestion(listItem, studyData[i], resultsData.answers[i]);
                break;
            case DICHOTOMOUS_QUESTION_GUS:
                renderDichotomousQuestion(listItem, studyData[i], resultsData.answers[i]);
                break;
            case GROUPING_QUESTION:
                renderGroupingQuestion(listItem, studyData[i], resultsData.answers[i]);
                break;
            case GROUPING_QUESTION_GUS:
                renderGroupingQuestionGUS(listItem, studyData[i], resultsData.answers[i]);
                break;
            case RATING:
                renderRating(listItem, studyData[i], resultsData.answers[i]);
                break;
            case SUM_QUESTION:
                renderSumQuestion(listItem, studyData[i], resultsData.answers[i]);
                break;
            case RANKING:
                renderRanking(listItem, studyData[i], resultsData.answers[i]);
                break;
            case ALTERNATIVE_QUESTION:
                renderAlternativeQuestion(listItem, studyData[i], resultsData.answers[i]);
                break;
            case GUS_SINGLE:
                renderGUS(listItem, studyData[i], resultsData.answers[i]);
                break;
            case SUS_ITEM:
                renderSUSItem(listItem, studyData[i], resultsData.answers[i]);
                break;
        }
        $(listItem).css({y: 0, opacity: 1});
        TweenMax.from(listItem, .1, {delay: i * .1, opacity: 0, y: -10});
    }
}

function renderCounter(item, studyData, resultsData) {
    var parameters = studyData.parameters;
    $(item).find('.question').text(studyData.question);
    $(item).find('#counter-label .counter-from').text(translation.of + ' ' + translation.atLeast + ' ' + parameters.countFrom);
    $(item).find('#counter-label .counter-to').text(translation.to + ' ' + translation.maximal + ' ' + parameters.countTo);
    if (resultsData.count && resultsData.count !== '') {
        $(item).find('.answer').text(resultsData.count);
    } else {
        $(item).find('#no-answer').removeClass('hidden');
    }
}

function renderEditableCounter(item, question, answer) {
    var parameters = question.parameters;
    $(item).find('.question').text(question.question);
    renderCounterInput(item, parameters);
    $(item).find('#counter-label .counter-from').text(translation.of + ' ' + translation.atLeast + ' ' + parameters.countFrom);
    $(item).find('#counter-label .counter-to').text(translation.to + ' ' + translation.maximal + ' ' + parameters.countTo);
    if (answer && !isNaN(parseInt(answer.count))) {
        $(item).find('.stepper-text').val(answer.count);
    }
}

function renderOpenQuestion(item, studyData, resultsData) {
    $(item).find('.question').text(studyData.question);
    if (resultsData.openAnswer && resultsData.openAnswer !== '') {
        $(item).find('.answer').text(resultsData.openAnswer);
    } else {
        $(item).find('#no-answer').removeClass('hidden');
    }
}

function renderEditableOpenQuestion(item, question, answer) {
    $(item).find('.question').text(question.question);
    renderOpenQuestionInput(item);
    if (answer) {
        $(item).find('#openQuestionInput').val(answer.openAnswer);
    }
}

function renderDichotomousQuestion(item, studyData, resultsData) {
//                console.log(studyData, resultsData);
    $(item).find('.question').text(studyData.question);
    if (resultsData.selectedSwitch === 'none') {
        $(item).find('#no-answer').removeClass('hidden');
        $(item).find('#selection').remove();
    } else {
//                    console.log(translation[resultsData.selectedSwitch])
        $(item).find('#selection .text').text(translation[resultsData.selectedSwitch]);
    }

    if (studyData.parameters.justification === 'yes') {
        $(item).find('#justification').removeClass('hidden');
        $(item).find('#' + studyData.parameters.justificationFor).removeClass('hidden');
        if ((resultsData.selectedSwitch === studyData.parameters.justificationFor || studyData.parameters.justificationFor === 'always') && resultsData.justification !== '') {
            $(item).find('#justification-content').removeClass('hidden');
            $(item).find('#justification-content .text').text(resultsData.justification);
        } else if (resultsData.justification === '' && (resultsData.selectedSwitch === studyData.parameters.justificationFor || studyData.parameters.justificationFor === 'always')) {
            $(item).find('#no-justification-result').removeClass('hidden');
        }
    } else {
        $(item).find('#no-justification').removeClass('hidden');
    }
}

function renderEditableDichotomousQuestion(item, question, answer) {
    $(item).find('.question').text(question.question);
    var parameters = question.parameters;
    renderDichotomousQuestionInput(item, parameters);
    if (answer && answer.selectedSwitch) {
        setTimeout(function () {
            $(item).find('.switch #' + answer.selectedSwitch).click();
        }, 10);
    }

    if (parameters.justification === 'yes') {
        $(item).find('#label-justification').removeClass('hidden');
        $(item).find('#label-' + parameters.justificationFor).removeClass('hidden');
        if (answer) {
            $(item).find('#justificationInput').val(answer.justification);
        }
    } else {
        $(item).find('#label-no-justification').removeClass('hidden');
    }
}

function renderGroupingQuestion(item, studyData, resultsData) {
//    console.log(studyData, resultsData);
    $(item).find('.question').text(studyData.question);
    if (studyData.parameters.multiselect === 'yes') {
        $(item).find('#multiselect').removeClass('hidden');
    } else {
        $(item).find('#singleselect').removeClass('hidden');
    }

    if (studyData.parameters.optionalanswer === 'yes') {
//                    $(item).find('#optionalanswer, #optionalanswer-headline').removeClass('hidden');

        if (resultsData.optionalAnswer !== '') {
            $(item).find('#optionalanswer-content').removeClass('hidden');
            $(item).find('#optionalanswer-content .text').text(resultsData.optionalAnswer);
        } else {
            $(item).find('#no-optional-answer').removeClass('hidden');
        }
    }

    if ((resultsData.selectedOptions && parseInt(resultsData.selectedOptions) === -1) || !resultsData.selectedOptions) {
        $(item).find('#no-answer').removeClass('hidden');
    }

    for (var i = 0; i < studyData.options.length; i++) {
        var optionItem = $('#template-study-container').find('#grouping-question-item').clone();
        $(optionItem).text(studyData.options[i].title);
        $(item).find('.option-container').append(optionItem);
        if (i < studyData.options.length - 1) {
            item.find('.option-container').append(document.createElement('br'));
        }

        if (resultsData.selectedOptions && resultsData.selectedOptions.length > 0) {
//                        console.log(resultsData.selectedOptions);
            for (var j = 0; j < resultsData.selectedOptions.length; j++) {
                if (parseInt(resultsData.selectedOptions[j]) === parseInt(studyData.options[i].id)) {
                    $(optionItem).addClass('bordered-scale-item');
                    if (i > 0) {
                        $(optionItem).css({marginTop: '5px'});
                    }
                    break;
                } else {
//                                $(optionItem).css({paddingLeft: "0px"});
                }
            }
        } else {
            $(optionItem).css({paddingLeft: "0px"});
        }
    }
}

function renderEditableGroupingQuestion(item, question, answer) {
    $(item).find('.question').text(question.question);
    var parameters = question.parameters;
    var options = question.options;
    renderGroupingQuestionInput(item, parameters, options);
    if (parameters.multiselect === 'yes') {
        $(item).find('#multiselect').removeClass('hidden');
    } else {
        $(item).find('#singleselect').removeClass('hidden');
    }

    if (answer && answer.selectedOptions && answer.selectedOptions !== '-1' && answer.selectedOptions.length) {
        for (var i = 0; i < answer.selectedOptions.length; i++) {
            setTimeout(function () {

            }, 10);
            setTimeout(function (target, element) {
                $(target).find('#' + element).click();
            }, 100, item, answer.selectedOptions[i]);
        }

//        console.log('optional answer', answer.optionalAnswer);

    }

    if (answer && answer.optionalAnswer && answer.optionalAnswer !== '') {
//        console.log($(item).find('#checkbox-optionalanswer .btn-checkbox'))
        setTimeout(function () {
            var optionType = parameters.multiselect === 'yes' ? 'checkbox' : 'radio';
//            console.log($(item), optionType)
            $(item).find('#' + optionType + '-optionalanswer .btn-' + optionType).click();
        }, 10);
        $(item).find('.optionalInput').val(answer.optionalAnswer);
    }
}


function renderGroupingQuestionGUS(item, studyData, resultsData) {
    //                console.log(studyData, resultsData);
    $(item).find('.question').text(studyData.question);
    var options;
    switch (studyData.parameters.optionSource) {
        case 'gestures':
            options = assembledGestures();
            break;
        case 'triggers':
            options = getLocalItem(ASSEMBLED_TRIGGER);
            break;
        case 'feedbacks':
            options = getLocalItem(ASSEMBLED_FEEDBACK);
            break;
    }

    if (studyData.parameters.multiselect === 'yes') {
        item.find('#multiselect').removeClass('hidden');
    } else {
        item.find('#singleselect').removeClass('hidden');
    }

    if (studyData.parameters.justification === 'yes') {
        item.find('#justification').removeClass('hidden');
        item.find('#' + studyData.parameters.justificationFor).removeClass('hidden');
        if (studyData.parameters.justificationFor === 'selectOne' && resultsData.selectedOptions && resultsData.selectedOptions.length > 0 && resultsData.justification !== '') {
            $(item).find('#justification-content').removeClass('hidden');
            $(item).find('#justification-content .text').text(resultsData.justification);
        } else if (studyData.parameters.justificationFor === 'selectNothing' && !resultsData.selectedOptions && resultsData.justification !== '') {
            $(item).find('#justification-content').removeClass('hidden');
            $(item).find('#justification-content .text').text(resultsData.justification);
        } else if (studyData.parameters.justificationFor === 'always' && resultsData.justification !== '') {
            $(item).find('#justification-content').removeClass('hidden');
            $(item).find('#justification-content .text').text(resultsData.justification);
        } else if (resultsData.selectedOptions && resultsData.selectedOptions.length > 0 && resultsData.justification === '') {
            $(item).find('#no-answer').removeClass('hidden');
        }
    } else {
        item.find('#no-justification').removeClass('hidden');
    }


    if (options && options.length > 0) {
        for (var i = 0; i < options.length; i++) {
            var optionItem = $('#template-study-container').find('#grouping-question-gus-' + studyData.parameters.optionSource + '-option').clone(false);
            optionItem.attr('id', options[i].id);
            optionItem.find('.text').text(options[i].title);
            item.find('.option-container').append(optionItem);
            if (i < options.length - 1) {
                item.find('.option-container').append(document.createElement('br'));
            }

            if (studyData.parameters.optionSource === 'gestures') {
                $(optionItem).find('.btn-popover-gesture-preview').attr('name', options[i].id);
            }

            if (resultsData.selectedOptions && resultsData.selectedOptions.length > 0) {
                for (var j = 0; j < resultsData.selectedOptions.length; j++) {
                    if (parseInt(resultsData.selectedOptions[j]) === parseInt(options[i].id)) {
                        $(optionItem).addClass('bordered-scale-item');
                        break;
                    } else {
                        //                                    $(optionItem).css({paddingLeft: "0px"});
                    }
                }
            } else {
                $(optionItem).css({paddingLeft: "0px"});
            }
        }
    }
}


function renderEditableGroupingQuestionGUS(item, question, answer) {
    $(item).find('.question').text(question.question);
    var parameters = question.parameters;
//    var options = question.options;
    renderGroupingQuestionGUSInput(item, parameters);
    if (parameters.multiselect === 'yes') {
        $(item).find('#multiselect').removeClass('hidden');
    } else {
        $(item).find('#singleselect').removeClass('hidden');
    }

    if (answer && answer.selectedOptions && answer.selectedOptions !== '-1' && answer.selectedOptions.length) {
        for (var i = 0; i < answer.selectedOptions.length; i++) {
            setTimeout(function () {
                $(item).find('#' + answer.selectedOptions[i]).click();
            }, 10);
        }

        if (answer.optionalAnswer !== '') {
            $(item).find('#checkbox-optionalanswer .btn-checkbox').click();
            $(item).find('.optionalInput').val(answer.optionalAnswer);
        }
    }
}

function renderRating(item, studyData, resultsData) {
//    console.log('render rating:', studyData, resultsData);
    $(item).find('.question').text(studyData.question);
    for (var i = 0; i < studyData.options.length; i++) {
        var optionItem = $('#template-study-container').find('#rating-item').clone();
        $(optionItem).find('#rating-option').text(studyData.options[i].option);
        $(item).find('.option-container').append(optionItem);
        var score = 0;
        var maxScore = studyData.options[i].scales.length;
        var selectedScale = parseInt(resultsData.scales[i]);
        if (studyData.options[i].negative === 'yes') {
            $(optionItem).find('#negative').removeClass('hidden');
            score = studyData.options[i].scales.length - selectedScale;
        } else {
            $(optionItem).find('#positive').removeClass('hidden');
            score = selectedScale + 1;
        }

        if (i < studyData.options.length - 1) {
            var hr = document.createElement('hr');
            $(hr).css({marginTop: "15px", marginBottom: "5px"});
            $(item).find('.option-container').append(hr);
        }


//        console.log('selectedScale', selectedScale === -1)

        if (selectedScale === -1) {
            $(item).find('#score-container').remove();
            $(item).find('#no-answer').removeClass('hidden');
        } else {
//            console.log('rating score: ', optionItem, selectedScale, score, maxScore);
            renderRatingSigns($(optionItem).find('#score-container'), score, maxScore);
            $(item).find('#no-answer').remove();
        }

        for (var j = 0; j < studyData.options[i].scales.length; j++) {
            var scaleItem = $('#template-study-container').find('#rating-scale-item').clone();
            $(optionItem).find('#scale-container').append(scaleItem);
            $(scaleItem).text((j + 1) + '. ' + studyData.options[i].scales[j]);
            if (j === selectedScale) {
                $(scaleItem).addClass('bordered-scale-item');
            } else if (j === 0) {
                $(scaleItem).css({paddingLeft: "0px"});
            }
        }
    }
}

function renderEditableRating(item, question, answer) {
    $(item).find('.question').text(question.question);
    renderRatingInput(item, question.options);
    if (answer && answer.scales && answer.scales.length > 0) {
        for (var i = 0; i < answer.scales.length; i++) {
            if (answer.scales[i] !== '-1') {
                var container = $(item).find('.scales-container')[i];
                setTimeout(function (target, index) {
                    $(target).find('.btn-radio')[index].click();
                }, 100, container, parseInt(answer.scales[i]));
            }
        }
    }
}

function renderSumQuestion(item, studyData, resultsData) {
    $(item).find('.question').text(studyData.question);
    $(item).find('#maximum .label-text').text(translation.maximum + ': ' + studyData.parameters.maximum);
    $(item).find('#allocation .label-text').text(translation.scaleTypes[studyData.parameters.allocation]);
    var count = 0;
    for (var i = 0; i < resultsData.sumCounts.length; i++) {
        var listItemAnswer = $('#template-study-container').find('#sum-question-item').clone();
        count += parseInt(resultsData.sumCounts[i]);
        $(listItemAnswer).text(studyData.options[i] + ': ' + resultsData.sumCounts[i] + ' ' + translation.scaleTypes[studyData.parameters.allocation]);
        $(item).find('.option-container').append(listItemAnswer);
    }

    if (count === parseInt(studyData.parameters.maximum)) {
        $(item).find('#distributeAllPoints').removeClass('hidden');
    } else {
        $(item).find('#distributeNotAllPoints').removeClass('hidden');
    }
}

function renderEditableSumQuestion(item, question, answer) {
    var parameters = question.parameters;
    var options = question.options;
    $(item).find('.question').text(question.question);
    $(item).find('#maximum .label-text').text(translation.maximum + ': ' + parameters.maximum);
    $(item).find('#allocation .label-text').text(translation.scaleTypes[parameters.allocation]);
    renderSumQuestionInput(item, parameters, options);
    if (answer && answer.sumCounts && answer.sumCounts.length > 0) {
        for (var i = 0; i < answer.sumCounts.length; i++) {
            $($(item).find('.option-container').find('.stepper-text')[i]).val(answer.sumCounts[i]);
        }
    }
}

function renderRanking(item, studyData, resultsData) {
//    console.log(studyData, resultsData);
    $(item).find('.question').text(studyData.question);
    for (var i = 0; i < resultsData.arrangement.length; i++) {
        var listItemAnswer = $('#template-study-container').find('#ranking-item').clone();
        var text = '';
        var optionsId = parseInt(resultsData.arrangement[i]);
        for (var j = 0; j < studyData.options.length; j++) {
            if (optionsId === parseInt(studyData.options[j].id)) {
                text = studyData.options[j].text;
            }
        }
        $(listItemAnswer).text((i + 1) + '. ' + text);
        $(item).find('.option-container').append(listItemAnswer);
    }
}

function renderEditableRanking(item, question, answer) {
    $(item).find('.question').text(question.question);
    var options = question.options;
    if (answer && answer.arrangement && answer.arrangement.length > 0) {
        var tempOptions = new Array();
        for (var i = 0; i < answer.arrangement.length; i++) {
            for (var j = 0; j < options.length; j++) {
                if (parseInt(options[j].id) === parseInt(answer.arrangement[i])) {
                    tempOptions.push(options[j]);
                }
            }
        }
        options = tempOptions;
    }
    renderRankingInput(item, options);
}

function renderAlternativeQuestion(item, studyData, resultsData) {
    //                console.log(studyData, resultsData);

    $(item).find('.question').text(studyData.question);
    if (studyData.parameters.optionalanswer === 'yes') {
        $(item).find('#optionalanswer').removeClass('hidden');
    }

    if (studyData.parameters.justification === 'yes') {
        $(item).find('#justification').removeClass('hidden');
        $(item).find('#' + studyData.parameters.justificationFor).removeClass('hidden');
        if (studyData.parameters.justificationFor === 'selectOne' && resultsData.selectedOptions && resultsData.selectedOptions.length > 0 && resultsData.justification !== '') {
            $(item).find('#justification-content').removeClass('hidden');
            $(item).find('#justification-content .text').text(resultsData.justification);
        } else if (studyData.parameters.justificationFor === 'selectNothing' && !resultsData.selectedOptions && resultsData.justification !== '') {
            $(item).find('#justification-content').removeClass('hidden');
            $(item).find('#justification-content .text').text(resultsData.justification);
        } else if (studyData.parameters.justificationFor === 'always' && resultsData.justification !== '') {
            $(item).find('#justification-content').removeClass('hidden');
            $(item).find('#justification-content .text').text(resultsData.justification);
        } else if (resultsData.selectedOptions && resultsData.selectedOptions.length > 0 && resultsData.justification === '') {
            $(item).find('#no-answer').removeClass('hidden');
        }
    } else {
        $(item).find('#no-justification').removeClass('hidden');
    }

    if (studyData.parameters.alternative === 'gestures' && studyData.parameters.alternativeFor === 'alternativeGesture') {
        $(item).find('#gesturesForGesture').removeClass('hidden');
    } else if (studyData.parameters.alternative === 'gestures' && studyData.parameters.alternativeFor === 'alternativeTrigger') {
        $(item).find('#gesturesForTrigger').removeClass('hidden');
    } else if (studyData.parameters.alternative === 'triggers' && studyData.parameters.alternativeFor === 'alternativeTrigger') {
        $(item).find('#triggersForTrigger').removeClass('hidden');
    } else {
        $(item).find('#triggersForGesture').removeClass('hidden');
    }

    var options = null;
    var cloneItem = null;
    if (studyData.parameters.alternative === 'triggers') {
        options = getLocalItem(ASSEMBLED_TRIGGER);
        cloneItem = '#alternativeQuestion-trigger-item';
    } else if (studyData.parameters.alternative === 'gestures') {
        options = assembledGestures();
        cloneItem = '#alternativeQuestion-gesture-item';
    }

    for (var i = 0; i < options.length; i++) {
        if (parseInt(options[i].id) !== parseInt(currentGUSData.gestureId)) {
            var optionItem = $('#template-study-container').find(cloneItem).clone();
            $(optionItem).find('.text').text(options[i].title);
            $(item).find('.option-container').append(optionItem);
            if (i < options.length - 1) {
                $(item).find('.option-container').append(document.createElement('br'));
            }

            if (studyData.parameters.alternative === 'gestures') {
                $(optionItem).find('.btn-popover-gesture-preview').attr('name', options[i].id);
            }

            if (resultsData.selectedOptions && resultsData.selectedOptions.length > 0) {
                for (var j = 0; j < resultsData.selectedOptions.length; j++) {
                    if (parseInt(resultsData.selectedOptions[j]) === parseInt(options[i].id)) {
                        $(optionItem).addClass('bordered-scale-item');
                        break;
                    }
                }
            } else {
                if (i === 0) {
                    //                                $(optionItem).css({paddingLeft: "0px"});
                }
            }
        }
    }

    if (resultsData.optionalAnswer !== '') {
        $(item).find('#optionalanswer-content').removeClass('hidden');
        $(item).find('#optionalanswer-content .text').text(resultsData.optionalAnswer);
    } else {
        $(item).find('#no-optional-answer').removeClass('hidden');
    }
}

function renderGUS(item, studyData, resultsData) {
    $(item).find('.question').text(studyData.question);
    var score = 0;
    if (studyData.parameters.negative === 'yes') {
        $(item).find('#negative').removeClass('hidden');
        score = translation.gusOptions.length - parseInt(resultsData.selectedOption);
    } else {
        $(item).find('#positive').removeClass('hidden');
        score = parseInt(resultsData.selectedOption) + 1;
    }

    var options = translation.gusOptions;
    var selectedOption = parseInt(resultsData.selectedOption);
    if (selectedOption === -1) {
        $(item).find('#score-container').remove();
        $(item).find('#no-answer').removeClass('hidden');
    } else {
        renderRatingSigns($(item).find('#score-container'), score, options.length);
    }


    for (var i = 0; i < options.length; i++) {
        var option = $('#template-study-container').find('#gus-single-item-option').clone();
        $(option).text(options[i]);
        $(item).find('.option-container').append(option);
        if (i === selectedOption) {
            $(option).addClass('bordered-scale-item');
        } else if (i === 0) {
            $(option).css({paddingLeft: "0px"});
        }
    }
}

function renderSUSItem(item, studyData, resultsData) {
    $(item).find('.question').text(studyData.question);
    var score = 0;
    if (studyData.parameters.negative === 'yes') {
        $(item).find('#negative').removeClass('hidden');
        score = translation.susOptions.length - parseInt(resultsData.selectedOption);
    } else {
        $(item).find('#positive').removeClass('hidden');
        score = parseInt(resultsData.selectedOption) + 1;
    }

    var options = translation.susOptions;
    var maxScore = options.length;
    var selectedOption = parseInt(resultsData.selectedOption);
    if (selectedOption === -1) {
        $(item).find('#score-container').remove();
        $(item).find('#no-answer').removeClass('hidden');
    } else {
        renderRatingSigns($(item).find('#score-container'), score, maxScore);
    }


    for (var i = 0; i < options.length; i++) {
        var option = $('#template-study-container').find('#sus-item-option').clone();
        $(option).text(options[i]);
        $(item).find('.option-container').append(option);
        if (i === selectedOption) {
            $(option).addClass('bordered-scale-item');
        } else if (i === 0) {
            $(option).css({paddingLeft: "0px"});
        }
    }
}

function renderRatingSigns(container, score, maxScore) {
    $(container).find('.score-text').text(score);
    var balance = Math.floor(maxScore / 2) + (maxScore % 2);
    console.log('maxScore', $(container), score, balance);
    if (score > balance) {
        $(container).find('.fa').addClass('fa-thumbs-up');
    } else if (score === balance) {
        $(container).find('.fa').addClass('fa-caret-left');
    } else {
        $(container).find('.fa').addClass('fa-thumbs-down');
    }
}




/* 
 * form rendering for moderator, tester and participant results view
 */


/*
 * open question 
 */
function renderOpenQuestionInput(item) {
    setInputChangeEvent(item.find('#openQuestionInput'), 1000);
}

/*
 * counter 
 */
function renderCounterInput(item, parameters) {
    var counterFrom = parseInt(parameters.countFrom);
    var counterTo = parseInt(parameters.countTo);
    if (isNaN(counterFrom) || isNaN(counterTo)) {
        item.find('.btn-stepper-decrease').attr('value', 0);
        item.find('.btn-stepper-increase').attr('value', 100);
        item.find('.stepper-text').val(0);
    } else {
        item.find('.btn-stepper-decrease').attr('value', counterFrom);
        item.find('.btn-stepper-increase').attr('value', counterTo);
        item.find('.stepper-text').val(counterFrom);
    }
}

function renderCounterPreview(item, parameters) {
    $(item).find('#counter-label .counter-from').text(translation.of + ' ' + translation.atLeast + ' ' + parameters.countFrom);
    $(item).find('#counter-label .counter-to').text(translation.to + ' ' + translation.maximal + ' ' + parameters.countTo);
}

/*
 * dichotomous question
 */
function renderDichotomousQuestionPreview(item, parameters) {
    if (parameters.justification === 'yes') {
        item.find('#justification').removeClass('hidden');
        item.find('#' + parameters.justificationFor).removeClass('hidden');
    } else {
        item.find('#no-justification').removeClass('hidden');
    }
}

function renderDichotomousQuestionInput(item, parameters) {
    if (parameters.justification === 'yes') {
        var justification = $('#item-container-inputs').find('#justification').clone().addClass('hidden');
        justification.css({marginTop: '10px'});
        item.find('#panel-body').append(justification);
        setInputChangeEvent(justification.find('#justificationInput'), 1000);
        if (parameters.justificationFor === 'always') {
            justification.removeClass('hidden');
        } else {
            $(item).find('.switch').bind('change', function () {
                var activeButton = $(this).find('.active');
                if (parameters.justificationFor === activeButton.attr('id')) {
                    $(item).find('#justification').removeClass('hidden');
                } else {
                    $(item).find('#justification').addClass('hidden');
                }
            });
        }
    }
}

function renderDichotomousQuestionGUSPreview(item, parameters) {
    if (parameters.justification === 'yes') {
        item.find('#justification').removeClass('hidden');
        item.find('#' + parameters.justificationFor).removeClass('hidden');
    } else {
        item.find('#no-justification').removeClass('hidden');
    }
}

function renderDichotomousQuestionGUSInput(item, parameters) {
    if (parameters.justification === 'yes') {
        var justification = $('#item-container-inputs').find('#justification').clone().addClass('hidden');
        item.find('.panel-body').append(justification);
        if (parameters.justificationFor === 'always') {
            justification.removeClass('hidden');
        } else {
            $(item).find('.switch').bind('change', function () {
                var activeButton = $(this).find('.active');
                if (parameters.justificationFor === activeButton.attr('id')) {
                    $(item).find('#justification').removeClass('hidden');
                } else {
                    $(item).find('#justification').addClass('hidden');
                }
            });
        }
    }
}

/*
 * grouping question
 */
function renderGroupingQuestionPreview(source, item, parameters, options) {
    if (parameters.multiselect === 'yes') {
        item.find('#multiselect').removeClass('hidden');
    } else {
        item.find('#singleselect').removeClass('hidden');
    }

    if (parameters.optionalanswer === 'yes') {
        item.find('#optionalanswer').removeClass('hidden');
    }

    for (var j = 0; j < options.length; j++) {
        var optionItem = $(source).find('#option-item').clone(false).removeAttr('id');
        optionItem.text(options[j].title);
        item.find('.option-container').append(optionItem);
    }
}

function renderGroupingQuestionInput(item, parameters, options) {
    var optionType = parameters.multiselect === 'yes' ? 'checkbox' : 'radio';
    for (var i = 0; i < options.length; i++) {
        var option = $('#item-container-inputs').find('#' + optionType).clone();
        option.find('.option-text').text(options[i].title);
        option.find('.btn-' + optionType).attr('id', options[i].id);
        $(item).find('.option-container').append(option);
        $(item).find('.option-container').append(document.createElement('br'));
    }

    if (parameters.optionalanswer === 'yes') {
        var option = $('#item-container-inputs').find('#' + optionType + '-optionalanswer').clone();
        $(item).find('.option-container').append(option);
        setInputChangeEvent(option.find('.optionalInput'), 1000);
    }
}

/*
 * grouping question GUS
 */
function renderGroupingQuestionGUSPreview(source, item, parameters) {
    var options;
    switch (parameters.optionSource) {
        case 'gestures':
            options = assembledGestures();
            break;
        case 'triggers':
            options = getLocalItem(ASSEMBLED_TRIGGER);
            break;
        case 'feedbacks':
            options = getLocalItem(ASSEMBLED_FEEDBACK);
            break;
    }

    if (parameters.multiselect === 'yes') {
        item.find('#multiselect').removeClass('hidden');
    } else {
        item.find('#singleselect').removeClass('hidden');
    }

    if (parameters.justification === 'yes') {
        item.find('#justification').removeClass('hidden');
        item.find('#' + parameters.justificationFor).removeClass('hidden');
    } else {
        item.find('#no-justification').removeClass('hidden');
    }

    if (options && options.length > 0) {
        for (var i = 0; i < options.length; i++) {
            var optionItem = $(source).find('#option-item').clone(false);
            optionItem.attr('id', options[i].id);
            item.find('.option-container').append(optionItem);
            if (parameters.optionSource === 'triggers') {
                var trigger = getTriggerById(options[i].id);
                optionItem.text(trigger.title);
            }

            if (parameters.optionSource === 'gestures') {
                var gesture = getGestureById(options[i].id);
                optionItem.text(gesture.title);
            }

            if (parameters.optionSource === 'feeedbacks') {
                var feedback = getFeedbackById(options[i].id);
                optionItem.text(feedback.title);
            }
        }
    }
}

function renderGroupingQuestionGUSInput(item, parameters) {
    var optionType = parameters.multiselect === 'yes' ? 'checkbox' : 'radio';
    var options;
    switch (parameters.optionSource) {
        case 'gestures':
            options = assembledGestures();
            break;
        case 'triggers':
            options = getLocalItem(ASSEMBLED_TRIGGER);
            break;
        case 'feedbacks':
            options = getLocalItem(ASSEMBLED_FEEDBACK);
            break;
    }

    if (options && options.length > 0) {
        for (var i = 0; i < options.length; i++) {
            var option = $('#item-container-inputs').find('#' + optionType).clone();
            $(item).find('.option-container').append(option);
            var optionItem = null;
            switch (parameters.optionSource) {
                case 'gestures':
                    optionItem = getGestureById(options[i].id);
                    var button = $('#item-container-inputs').find('#btn-show-gesture').clone().removeClass('hidden').removeAttr('id');
                    button.attr('name', optionItem.id);
                    option.append(button);
                    break;
                case 'triggers':
                    optionItem = getTriggerById(options[i].id);
                    break;
                case 'feedbacks':
                    optionItem = getFeedbackById(options[i].id);
                    break;
            }
            option.find('.option-text').text(optionItem.title);
            option.find('.option-text').attr('id', optionItem.id);
            $(item).find('.option-container').append(document.createElement('br'));
        }
    }

    if (parameters.justification === 'yes') {
        var justification = $('#item-container-inputs').find('#justification').clone().addClass('hidden');
        item.find('.option-container').append(justification);
        if (parameters.justificationFor === 'always') {
            justification.removeClass('hidden');
        } else {
            if (parameters.justificationFor === 'selectNothing') {
                justification.removeClass('hidden');
            }

            $(item).find('.option-container').bind('change', function () {
                var totalCheckboxButtons = $(this).find('.btn-' + optionType);
                var activeCheckboxButtons = $(totalCheckboxButtons).filter('.btn-option-checked');
                if (parameters.justificationFor === 'selectOne' && activeCheckboxButtons.length > 0) {
                    $(item).find('#justification').removeClass('hidden');
                } else if (parameters.justificationFor === 'selectNothing' && activeCheckboxButtons.length === 0) {
                    $(item).find('#justification').removeClass('hidden');
                } else {
                    $(item).find('#justification').addClass('hidden');
                }
            });
        }
    }
}


/*
 * rating
 */
function renderRatingPreview(source, item, options) {
    for (var j = 0; j < options.length; j++) {
        var ratingItem = $(source).find('#rating-item').clone().removeAttr('id');
        if (options[j].negative === 'yes') {
            ratingItem.find('#reversed').removeClass('hidden');
        }

        ratingItem.find('#rating-header').text(options[j].option);
        for (var k = 0; k < options[j].scales.length; k++) {
            var optionItem = $(source).find('#option-item').clone(false).removeAttr('id');
            optionItem.text(options[j].scales[k]);
            ratingItem.find('#scales-container').append(optionItem);
        }

        item.find('.option-container').append(ratingItem);
    }
}

function renderRatingInput(item, options) {
    for (var j = 0; j < options.length; j++) {
        var ratingItem = $('#item-container-inputs').find('#rating-item').clone().removeAttr('id');
        ratingItem.find('#rating-header').text(options[j].option);
        for (var k = 0; k < options[j].scales.length; k++) {
            var optionItem = $('#item-container-inputs').find('#radio').clone(false);
            optionItem.find('.option-text').text(options[j].scales[k]);
            ratingItem.find('#scales-container').append(optionItem);
            ratingItem.find('#scales-container').append(document.createElement('br'));
        }

        item.find('.option-container').append(ratingItem);
        if (j < options.length - 1) {
            var horizontalLine = document.createElement('hr');
            item.find('.option-container').append(horizontalLine);
        }
    }
}

/*
 * sum question
 */
function renderSumQuestionPreview(source, item, parameters, options) {
    if (parameters.maximum !== null) {
        var maximum = $(source).find('#option-item').clone(false).removeAttr('id');
        maximum.text(translation.maximum + ': ' + parameters.maximum);
        item.find('#distribution-container').append(maximum);
    }

    if (parameters.allocation !== null) {
        var percent = $(source).find('#option-item').clone(false).removeAttr('id');
        percent.text(translation.scaleTypes[parameters.allocation]);
        item.find('#distribution-container').append(percent);
    }

    for (var i = 0; i < options.length; i++) {
        var optionItem = $(source).find('#option-item').clone(false).removeAttr('id');
        optionItem.text(options[i]);
        item.find('.option-container').append(optionItem);
    }
}

function renderSumQuestionInput(item, parameters, options) {
    for (var i = 0; i < options.length; i++) {
        var maxSum = parseInt(parameters.maximum);
        var sumQuestionItem = $('#item-container-inputs').find('#sumQuestion-item').clone().removeAttr('id');
        sumQuestionItem.find('.option-text').html(options[i]);
        sumQuestionItem.find('.btn-stepper-increase').val(maxSum);
        item.find('.option-container').append(sumQuestionItem);
        $(sumQuestionItem).find('.stepper-text').on('change', function (event) {
            event.preventDefault();
            var steppers = item.find('.option-container .simple-stepper .stepper-text');
            var sum = 0;
            for (var j = 0; j < steppers.length; j++) {
                sum += parseInt($(steppers[j]).val());
            }
            if (sum > maxSum) {
                $(this).val(parseInt($(this).val()) - 1);
            }
        });
    }
}

/*
 * ranking
 */
function renderRankingPreview(source, item, options) {
    for (var i = 0; i < options.length; i++) {
        var optionItem = $(source).find('#option-item').clone(false).removeAttr('id');
        optionItem.text(options[i].text);
        item.find('.option-container').append(optionItem);
    }
}

function renderRankingInput(item, options) {
    if (options) {
        for (var i = 0; i < options.length; i++) {
            var rankingItem = $('#item-container-inputs').find('#ranking-item').clone().removeAttr('id');
            rankingItem.find('.option-text').html(options[i].text);
            rankingItem.attr('id', options[i].id);
            item.find('.option-container').append(rankingItem);
            checkCurrentListState(item.find('.option-container'));
        }
    }
}

/*
 * alternative question
 */
function renderAlternativeQuestionPreview(item, parameters) {
    if (parameters.optionalanswer === 'yes') {
        $(item).find('#optionalanswer').removeClass('hidden');
    }

    if (parameters.justification === 'yes') {
        $(item).find('#justification').removeClass('hidden');
        $(item).find('#' + parameters.justificationFor).removeClass('hidden');
    } else {
        $(item).find('#no-justification').removeClass('hidden');
    }

    if (parameters.alternative === 'gestures' && parameters.alternativeFor === 'alternativeGesture') {
        $(item).find('#gesturesForGesture').removeClass('hidden');
    } else if (parameters.alternative === 'gestures' && parameters.alternativeFor === 'alternativeTrigger') {
        $(item).find('#gesturesForTrigger').removeClass('hidden');
    } else if (parameters.alternative === 'triggers' && parameters.alternativeFor === 'alternativeTrigger') {
        $(item).find('#triggersForTrigger').removeClass('hidden');
    } else {
        $(item).find('#triggersForGesture').removeClass('hidden');
    }
}

function renderAlternativeQuestionInput(item, data) {
    var parameters = data.parameters;
    var options;
    var optionId = null;
    switch (parameters.alternative) {
        case 'gestures':
            options = assembledGestures();
            if (singleGUSGesture) {
                optionId = singleGUSGesture.gestureId;
            }
            break;
        case 'triggers':
            options = getLocalItem(ASSEMBLED_TRIGGER);
            if (singleGUSGesture) {
                optionId = singleGUSGesture.triggerId;
            }
            break;
        case 'feedbacks':
            options = getLocalItem(ASSEMBLED_FEEDBACK);
            if (singleGUSGesture) {
                optionId = singleGUSGesture.feedbackId;
            }
            break;
    }

    if (options) {
        for (var i = 0; i < options.length; i++) {
            if (optionId === null || (parseInt(optionId) !== parseInt(options[i].id))) {
                var optionButton = $('#item-container-inputs').find('#checkbox').clone();
                optionButton.find('.option-text').html(options[i].title);
                optionButton.find('.option-text').attr('id', options[i].id);
                item.find('.option-container').append(optionButton);
                item.find('.option-container').append(document.createElement('br'));
                if (parameters.alternative === 'gestures') {
                    var button = $('#item-container-inputs').find('#btn-show-gesture').clone().removeClass('hidden').removeAttr('id');
                    button.attr('name', options[i].id);
                    optionButton.append(button);
                }
            }
        }
    }

    if (parameters.optionalanswer === 'yes') {
        var optionalAnswer = $('#item-container-inputs').find('#checkbox-optionalanswer').clone();
        item.find('.option-container').append(optionalAnswer);
    }

    if (parameters.justification === 'yes') {
        var justification = $('#item-container-inputs').find('#justification').clone().addClass('hidden');
        item.find('.option-container').append(justification);
        if (parameters.justificationFor === 'always') {
            justification.removeClass('hidden');
        } else {
            if (parameters.justificationFor === 'selectNothing') {
                justification.removeClass('hidden');
            }

            $(item).find('.option-container').bind('change', function () {
                var totalCheckboxButtons = $(this).find('.btn-checkbox');
                var activeCheckboxButtons = $(totalCheckboxButtons).filter('.btn-option-checked');
                if (parameters.justificationFor === 'selectOne' && activeCheckboxButtons.length > 0) {
                    $(item).find('#justification').removeClass('hidden');
                } else if (parameters.justificationFor === 'selectNothing' && activeCheckboxButtons.length === 0) {
                    $(item).find('#justification').removeClass('hidden');
                } else {
                    $(item).find('#justification').addClass('hidden');
                }
            });
        }
    }
}

/*
 * gus & sus
 */

function renderGUSSinglePreview(item, data) {
    if (data.parameters.negative === 'yes') {
        $(item).find('#reversed').removeClass('hidden');
    }
    if (data.dimension !== DIMENSION_ANY) {
        $(item).find('#item-factors').removeClass('hidden');
        $(item).find('#factor-primary').text(translation.dimensions[data.dimension]);
        $(item).find('#factor-main').text(translation.mainDimensions[getMainDimensionForDimension(data.dimension)]);
    }
}
function renderGUSSingleInput(item) {
    var options = translation.gusOptions;
    for (var i = 0; i < options.length; i++) {
        var radioButton = $('#item-container-inputs').find('#radio').clone();
        radioButton.find('.option-text').html(options[i]);
        item.find('.option-container').append(radioButton);
        item.find('.option-container').append(document.createElement('br'));
    }
}

function renderSusInput(item) {
    var options = translation.susOptions;
    for (var i = 0; i < options.length; i++) {
        var radioButton = $('#item-container-inputs').find('#radio').clone();
        radioButton.find('.option-text').html(options[i]);
        item.find('.option-container').append(radioButton);
        item.find('.option-container').append(document.createElement('br'));
    }
}

function renderSUSPreview(item, parameters) {
    if (parameters.negative === 'yes') {
        $(item).find('#reversed').removeClass('hidden');
    }
}


var changeTriggerTimer = null;
function setInputChangeEvent(target, milliseconds) {
    $(target).keypress(function (event) {
        clearTimeout(changeTriggerTimer);
        changeTriggerTimer = setTimeout(function () {
            clearTimeout(changeTriggerTimer);
            $(target).trigger('change');
        }, milliseconds);
    });
}


/*
 * observations
 */
function getObservationResults(currentPhaseId) {
    var observations = getLocalItem(STUDY_EVALUATOR_OBSERVATIONS);
    if (observations && observations.length) {
        for (var i = 0; i < observations.length; i++) {
            if (parseInt(currentPhaseId) === parseInt(observations[i].id) && observations[i].answers) {
                return observations[i].answers;
            }
        }
    }
    return null;
}

function renderEditableObservations(target, studyData, resultData) {
    if (studyData && studyData.length > 0) {
        for (var i = 0; i < studyData.length; i++) {
            var listItem = $('#item-container-inputs').find('#' + studyData[i].format).clone();
            $(target).append(listItem);
            if (studyData[i].dimension !== DIMENSION_ANY) {
                $(listItem).find('#item-factors').removeClass('hidden');
                $(listItem).find('#factor-primary').text(translation.dimensions[studyData[i].dimension]);
                $(listItem).find('#factor-main').text(translation.mainDimensions[getMainDimensionForDimension(studyData[i].dimension)]);
            }

            var answer = resultData ? resultData[i] : null;
//            console.log('renderEditableObservations', studyData[i].format, answer);
            switch (studyData[i].format) {
                case COUNTER:
                    renderEditableCounter(listItem, studyData[i], answer);
                    break;
                case OPEN_QUESTION:
                case OPEN_QUESTION_GUS:
                    renderEditableOpenQuestion(listItem, studyData[i], answer);
                    break;
                case DICHOTOMOUS_QUESTION:
                case DICHOTOMOUS_QUESTION_GUS:
                    renderEditableDichotomousQuestion(listItem, studyData[i], answer);
                    break;
                case GROUPING_QUESTION:
                    renderEditableGroupingQuestion(listItem, studyData[i], answer);
                    break;
                case GROUPING_QUESTION_GUS:
                    renderEditableGroupingQuestionGUS(listItem, studyData[i], answer);
                    break;
                case RATING:
                    renderEditableRating(listItem, studyData[i], answer);
                    break;
                case SUM_QUESTION:
                    renderEditableSumQuestion(listItem, studyData[i], answer);
                    break;
                case RANKING:
                    renderEditableRanking(listItem, studyData[i], answer);
                    break;
            }
        }
    }
}

function saveObservationAnwers(target, studyId, testerId, currentPhaseId) {
    var observationAnswerItems = $(target).children();
//    var currentPhaseId = getCurrentPhase().id; //$('#phase-results-nav').find('.active').attr('id');
//    console.log(observationAnswerItems, currentPhaseId);
    var answers = getQuestionnaireAnswers(observationAnswerItems);
//    console.log("answers", observationAnswerItems, answers)
    var observations = getLocalItem(STUDY_EVALUATOR_OBSERVATIONS);
    if (observations && answers) {
        if (isObservationPresent(currentPhaseId)) {
            for (var i = 0; i < observations.length; i++) {
                if (parseInt(currentPhaseId) === parseInt(observations[i].id)) {
                    observations[i] = {id: currentPhaseId, answers: answers};
                }
            }
        } else {
            observations.push({id: currentPhaseId, answers: answers});
        }
    } else {
        observations = new Array();
        observations.push({id: currentPhaseId, answers: answers});
    }
    setLocalItem(STUDY_EVALUATOR_OBSERVATIONS, observations);
//    console.log(currentPhaseId, observations, studyId, testerId);

    saveObservations({studyId: studyId, testerId: testerId, observations: observations});
}

function isObservationPresent(phaseId) {
    var observations = getLocalItem(STUDY_EVALUATOR_OBSERVATIONS);
    if (observations && observations.length > 0) {
        for (var i = 0; i < observations.length; i++) {
            if (parseInt(phaseId) === parseInt(observations[i].id)) {
                return true;
            }
        }
    }
    return false;
}