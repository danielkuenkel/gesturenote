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
        var count = parseInt(result.split('_')[1]);
        var defaultOptions = translation.threeDefaultScales;

        var existingItems = $(this).closest('.root').find('.ratingScaleItemContainer').children();
        var existingScale = [];
        for (var i = 0; i < existingItems.length; i++) {
            existingScale.push({id: $(existingItems[i]).attr('data-id'), title: $(existingItems[i]).find('.option').val()});
        }
//        console.log(existingScale);

        switch (count) {
            case 4:
                defaultOptions = translation.fourDefaultScales;
                break;
            case 5:
                defaultOptions = translation.fiveDefaultScales;
                break;
            case 6:
                defaultOptions = translation.sixDefaultScales;
                break;
            case 7:
                defaultOptions = translation.sevenDefaultScales;
                break;
        }

        if (existingScale.length > 0) {
            if (existingItems.length > count) {
                defaultOptions = existingScale;
                defaultOptions.splice(count);
            } else {
                var defaultTempOptions = [];
                for (var i = 0; i < count; i++) {
                    if (i < existingScale.length) {
                        defaultTempOptions.push(existingScale[i]);
                    } else {
                        defaultTempOptions.push({id: chance.natural(), title: defaultOptions[i].title});
                    }
                }
                defaultOptions = defaultTempOptions;
            }
        }

//        console.log(count, defaultOptions);

        renderScaleItems(scaleItemContainer, count, defaultOptions);
    }
});

function renderScaleItems(container, count, options) {
    $(container).empty();
    for (var i = 0; i < count; i++)
    {
        var scaleItem = $('#form-item-container').find('#ratingScaleItem').clone();
        $(scaleItem).attr('data-id', options && options[i].id ? options[i].id : chance.natural());
        $(container).append(scaleItem);

        if (i === 0) {
            $(scaleItem).find('.input-group-addon').text(translation.of + ' ' + (i + 1));
//            $(scaleItem).find('.item-input-text').attr('placeholder', translation.defaultScales[0].title);
        } else if (i === count - 1) {
            $(scaleItem).find('.input-group-addon').text(translation.to + ' ' + (i + 1));
//            $(scaleItem).find('.item-input-text').attr('placeholder', translation.defaultScales[2].title);
        } else {
            $(scaleItem).find('.input-group-addon').text(i + 1);
        }

        if (options && options[i].title !== undefined || options[i].title !== '') {
            $(scaleItem).find('.item-input-text').val(options[i].title);
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

function renderFormatItem(target, data, currentPhaseFormat, allowFilters) {
    var clone = $('#form-item-container').find('#' + data.format).clone();
    $(clone).find('.question').val(data.question);
    clone.attr('name', data.id || chance.natural());
    clone.attr('data-dimension', data.dimension);
    $(target).append(clone);
    initPopover();

    var dimensions = translation.dimensions;
    var parameters = data.parameters;
    var options = data.options;

    switch (data.format) {
        case OPEN_QUESTION:
            if (allowFilters && allowFilters === true) {
                renderFilterOptions(clone, clone, data, data.filterOptions);
            }
            break;
        case SUS_ITEM:
            $(clone).find('.negative #' + parameters.negative).click();
            break;
        case COUNTER:
            $(clone).find('#counter-from .stepper-text').val(parameters.countFrom);
            $(clone).find('#counter-to .stepper-text').val(parameters.countTo);
            if (allowFilters && allowFilters === true) {
                renderFilterOptions(clone, clone, data, data.filterOptions);
            }
            break;
        case OPEN_QUESTION_GUS:
            if (parameters.used === 'used') {
                $(clone).find('.btn-use').click();
            } else {
                $(clone).find('.hide-when-unused').addClass('hidden');
            }
            break;
        case DICHOTOMOUS_QUESTION:
            initJustificationFormElements(clone, parameters);
            if (allowFilters && allowFilters === true) {
                renderFilterOptions(clone, clone, data, data.filterOptions);
            }
            break;
        case DICHOTOMOUS_QUESTION_GUS:
            initJustificationFormElements(clone, parameters);
            if (parameters.used === 'used') {
                $(clone).find('.btn-use').click();
            } else {
                $(clone).find('.hide-when-unused').addClass('hidden');
            }
            break;
        case UEQ_ITEM:
//            $(clone).attr('data-ueq-id', data.id);
            dimensions = translation.ueqDimensions;
//            if (parameters.used === 'used') {
//                $(clone).find('.btn-use').click();
//            } else {
//                $(clone).find('.hide-when-unused').addClass('hidden');
//            }

            $(clone).find('.opposites .left').text(translation.ueqOpposites[parameters.opposites.left]);
            $(clone).find('.opposites .left').attr('data-opposite-id', parameters.opposites.left);
            $(clone).find('.opposites .right').text(translation.ueqOpposites[parameters.opposites.right]);
            $(clone).find('.opposites .right').attr('data-opposite-id', parameters.opposites.right);
            $(clone).find('.negative #' + parameters.negative).click();
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
                    initJustificationFormElements(option, options[j]);
                    checkCurrentListState($(clone).find('.option-container'));
                }
            }
            if (allowFilters && allowFilters === true) {
                renderFilterOptions(clone, clone, data, data.filterOptions);
            }
            break;
        case GROUPING_QUESTION_GUS:
        case GROUPING_QUESTION_OPTIONS:
            if (parameters.used && parameters.used === 'used') {
                $(clone).find('.btn-use').click();
            } else {
                $(clone).find('.hide-when-unused').addClass('hidden');
            }
            $(clone).find('.multiselect #' + parameters.multiselect).click();
            $(clone).find('.optionalanswer #' + parameters.optionalanswer).click();
            $(clone).find('.optionselect #' + parameters.optionSource).click();
            initJustificationFormElements(clone, parameters);
            if (data.format === GROUPING_QUESTION_OPTIONS && allowFilters && allowFilters === true) {
                renderFilterOptions(clone, clone, data, data.filterOptions);
            }
            break;
        case RATING:
            $(clone).find('#' + parameters.negative).click();
//            console.log('rating', options);
            if (options) {
                renderScaleItems($(clone).find('.ratingScaleItemContainer'), options.length, options);
                $(clone).find('#scale_' + (options.length)).addClass('selected');
                $(clone).find('.chosen').attr('id', (options.length));
                $(clone).find('.show-dropdown').val(options.length);
            }
            if (allowFilters && allowFilters === true) {
                renderFilterOptions(clone, clone, data, data.filterOptions);
            }
            break;
        case MATRIX:
            if (options) {
                for (var j = 0; j < options.length; j++) {
                    var option = $('#ratingItem').clone().removeClass('hidden');
                    $(option).attr('data-id', options[j].id);
                    $(option).find('.option').val(options[j]);
                    $(clone).find('.option-container').append(option);
                    $(option).find('.optionQuestion').val(options[j].option);
                    $(option).find('.chosen').attr('id', (options[j].scales.length));
                    $(option).find('.show-dropdown').val(options[j].scales.length);
                    $(option).find('#scale_' + (options[j].scales.length)).addClass('selected');
                    checkCurrentListState($(clone).find('.option-container'));
                    renderScaleItems($(option).find('.ratingScaleItemContainer'), options[j].scales.length, options[j].scales);
                    $(option).find('#' + options[j].negative).click();
                    if (allowFilters && allowFilters === true) {
                        renderFilterOptions(clone, option, data, options[j].filterOptions);
                    }
                }
            }
            break;
        case SUM_QUESTION:
            $(clone).find('.allocationSelect #' + parameters.allocation).click();
            $(clone).find('#counter-maximum .stepper-text').val(parameters.maximum);
            if (options) {
                for (var j = 0; j < options.length; j++) {
                    var option = $('#sumQuestionItem').clone().removeClass('hidden');
                    $(option).attr('data-id', options[j].id);
                    $(option).find('.option').val(options[j].title);
                    $(clone).find('.option-container').append(option);
                    checkCurrentListState($(clone).find('.option-container'));
                }
            }
            if (allowFilters && allowFilters === true) {
                renderFilterOptions(clone, clone, data, data.filterOptions);
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
            if (allowFilters && allowFilters === true) {
                renderFilterOptions(clone, clone, data, data.filterOptions);
            }
            break;
        case ALTERNATIVE_QUESTION:
            if (parameters.used === 'used') {
                $(clone).find('.btn-use').click();
            } else {
                $(clone).find('.hide-when-unused').addClass('hidden');
            }
            $(clone).find('.optionalanswer #' + parameters.optionalanswer).click();
            $(clone).find('.alternative #' + parameters.alternative).click();
            initJustificationFormElements(clone, parameters);

            if (currentPhaseFormat === GUS_SINGLE_GESTURES) {
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
            } else {
                $(clone).find('.hide-when-unused').addClass('hidden');
            }
            $(clone).find('.negative #' + parameters.negative).click();
            break;
    }

    if (allowFilters && allowFilters === true) {
        $(clone).find('.filter-options').removeClass('hidden');
    } else {
        $(clone).find('.filter-options').remove();
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

        $(clone).find('#factor-primary').text(dimensions[dimension].title);
    }

    TweenMax.from(clone, .3, {y: -20, opacity: 0, clearProps: 'all'});

    checkFilterOptions(target);
}

function checkFilterOptions(container) {
    console.log('check filter options', container, $(container).attr('data-allow-filters'));
    if ($(container).attr('data-allow-filters') === 'true') {
        var elements = $(container).children();
        for (var i = 0; i < elements.length; i++) {
            if (i < elements.length - 1) {
                $(elements[i]).find('.filter-options').removeClass('hidden');
            } else {
                $(elements[i]).find('.filter-options').addClass('hidden');
            }
        }
    }
}

function renderFilterOptions(root, element, data, filterOptions) {
//    console.log('render filter options', root, element, data, filterOptions);
    if (filterOptions) {
        for (var i = 0; i < filterOptions.length; i++) {
            timeoutCaller(i);
        }
    }

    function timeoutCaller(count) {
//        console.log('timeoutCaller', count);
        setTimeout(function () {
//            console.log(filterOptions[count], data.format);
            addFilterOption(root, element, data, filterOptions[count]);
        }, 200);
    }
}

function initJustificationFormElements(clone, parameters) {
    $(clone).find('.justification').unbind('change').bind('change', function (event) {
        event.preventDefault();
        if ($(event.target).attr('id') === 'yes') {
            $(clone).find('.justification-for').removeClass('hidden');
        } else {
            $(clone).find('.justification-for').addClass('hidden');
        }
    });

    if (parameters && parameters.justification === 'yes') {
        $(clone).find('.justification #yes').click();

        if (parameters.justificationFor) {
            $(clone).find('.justification-for #' + parameters.justificationFor).click();
        }
    }
}


/*
 * get the format item data for study creation
 */
function getFormatData(element, currentPhaseFormat) {
    var format = $(element).attr('id');
    var id = $(element).attr('name');
    var dimension = getDimensionByElement($(element));
    var question = $(element).find('.question').val();
    var parameters = null;
    var options = null;
    var filterOptions = null;

    switch (format) {
        case OPEN_QUESTION:
            filterOptions = getFilterOptions(format, element);
            break;
        case SUS_ITEM:
            parameters = {negative: $(element).find('.negative .btn-option-checked').attr('id')};
            break;
        case COUNTER:
            var countFrom = parseInt($(element).find('#counter-from .stepper-text').val());
            var countTo = parseInt($(element).find('#counter-to .stepper-text').val());
            parameters = {countFrom: isNaN(countFrom) ? 0 : parseInt(countFrom), countTo: isNaN(countTo) ? 0 : parseInt(countTo)};
            filterOptions = getFilterOptions(format, element);
            break;
        case OPEN_QUESTION_GUS:
            parameters = {used: $(element).find('.btn-use').hasClass('used') ? 'used' : 'not-used'};
            break;
        case DICHOTOMOUS_QUESTION:
            parameters = {justification: $(element).find('.justification .btn-option-checked').attr('id'),
                justificationFor: $(element).find('.justification-for .btn-option-checked').attr('id')};
            filterOptions = getFilterOptions(format, element);
            break;
        case DICHOTOMOUS_QUESTION_GUS:
            parameters = {used: $(element).find('.btn-use').hasClass('used') ? 'used' : 'not-used',
                justification: $(element).find('.justification .btn-option-checked').attr('id'),
                justificationFor: $(element).find('.justification-for .btn-option-checked').attr('id')};
            break;
        case GROUPING_QUESTION:
            parameters = {multiselect: $(element).find('.multiselect .btn-option-checked').attr('id'),
                optionalanswer: $(element).find('.optionalanswer .btn-option-checked').attr('id')};
            options = new Array();
            var groupingOptions = $(element).find('.option-container').children();
            for (var j = 0; j < groupingOptions.length; j++) {
                options.push({id: $(groupingOptions[j]).attr('id'), title: $(groupingOptions[j]).find('.option').val(),
                    justification: $(groupingOptions[j]).find('.justification .btn-option-checked').attr('id'),
                    justificationFor: $(groupingOptions[j]).find('.justification-for .btn-option-checked').attr('id')});
            }
            filterOptions = getFilterOptions(format, element);
            break;
        case GROUPING_QUESTION_GUS:
            parameters = {used: $(element).find('.btn-use').hasClass('used') ? 'used' : 'not-used',
                multiselect: $(element).find('.multiselect .btn-option-checked').attr('id'),
                optionSource: $(element).find('.optionselect .btn-option-checked').attr('id'),
                justification: $(element).find('.justification .btn-option-checked').attr('id'),
                justificationFor: $(element).find('.justification-for .btn-option-checked').attr('id'),
                optionalanswer: $(element).find('.optionalanswer .btn-option-checked').attr('id')};
            break;
        case GROUPING_QUESTION_OPTIONS:
            parameters = {multiselect: $(element).find('.multiselect .btn-option-checked').attr('id'),
                optionSource: $(element).find('.optionselect .btn-option-checked').attr('id'),
                justification: $(element).find('.justification .btn-option-checked').attr('id'),
                justificationFor: $(element).find('.justification-for .btn-option-checked').attr('id'),
                optionalanswer: $(element).find('.optionalanswer .btn-option-checked').attr('id')};
            filterOptions = getFilterOptions(format, element);
            break;
        case RATING:
            parameters = {negative: $(element).find('.negative .btn-option-checked').attr('id')};
            var ratingOptions = $(element).find('.ratingScaleItemContainer').children();
            var tempArray = new Array();

            for (var i = 0; i < ratingOptions.length; i++) {
                tempArray.push({id: $(ratingOptions[i]).attr('data-id'), title: $(ratingOptions[i]).find('.option').val()});
            }
            options = tempArray;
            filterOptions = getFilterOptions(format, element);
            break;
        case MATRIX:
            options = new Array();
            var optionList = $(element).find('.option-container').children();
            for (var j = 0; j < optionList.length; j++) {
                var ratingOptions = $(optionList[j]).find('.ratingScaleItemContainer').children();
                filterOptions = getFilterOptions(format, $(optionList[j]));
                var tempArray = new Array();
//                console.log('ratingOptions', ratingOptions);
                for (var k = 0; k < ratingOptions.length; k++) {

                    tempArray.push({id: $(ratingOptions[k]).attr('data-id'), title: $(ratingOptions[k]).find('.option').val()});
                }
                var itemId = $(optionList[j]).attr('data-id');
//                console.log(itemId);
                options.push({id: itemId === undefined ? chance.natural() : itemId, option: $(optionList[j]).find('.optionQuestion').val(), negative: $(optionList[j]).find('.negative').find('.active').attr('id'), scales: tempArray, filterOptions: filterOptions});
            }
            filterOptions = null;
            break;
        case SUM_QUESTION:
            parameters = {allocation: $(element).find('.allocationSelect .btn-option-checked').attr('id'),
                maximum: parseInt($(element).find('#counter-maximum .stepper-text').val())};
            options = new Array();
            var sumQuestionOptions = $(element).find('.option-container').children();
            for (var j = 0; j < sumQuestionOptions.length; j++) {
                options.push({id: $(sumQuestionOptions[j]).attr('data-id'), title: $(sumQuestionOptions[j]).find('.option').val()});
            }
            filterOptions = getFilterOptions(format, element);
            break;
        case RANKING:
            options = new Array();
            var rankingOptions = $(element).find('.option-container').children();
            for (var j = 0; j < rankingOptions.length; j++) {
                var optionId = $(rankingOptions[j]).attr('id');
                options.push({id: optionId, text: $(rankingOptions[j]).find('.option').val()});
            }
            filterOptions = getFilterOptions(format, element);
            break;
        case ALTERNATIVE_QUESTION:
            parameters = {used: $(element).find('.btn-use').hasClass('used') ? 'used' : 'not-used',
                optionalanswer: $(element).find('.optionalanswer .btn-option-checked').attr('id'),
                justification: $(element).find('.justification .btn-option-checked').attr('id'),
                justificationFor: $(element).find('.justification-for .btn-option-checked').attr('id'),
                alternative: $(element).find('.alternative .btn-option-checked').attr('id')};
            var aGestures = assembledGestures();
            var aTriggers = getLocalItem(ASSEMBLED_TRIGGER);
            if (currentPhaseFormat === GUS_SINGLE_GESTURES) {
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
                negative: $(element).find('.negative .btn-option-checked').attr('id')};
            break;
        case UEQ_ITEM:
            parameters = {used: 'used',
                negative: $(element).find('.negative .btn-option-checked').attr('id'),
                opposites: {left: $(element).find('.opposites .left').attr('data-opposite-id'), right: $(element).find('.opposites .right').attr('data-opposite-id')}};
            break;
    }
    return {id: id, format: format, dimension: dimension, question: question, parameters: parameters, options: options, filterOptions: filterOptions};
}

function getFilterOptions(format, element) {
//    console.log('get filter options', format, element);
    var filterOptions = null;

    var filterListItems = $(element).find('.filter-options-container').children();
    if ($(element).find('.filter-options').hasClass('hidden')) {
        console.log('dont save filter options for: ', format);
        return null;
    }

    switch (format) {
        case OPEN_QUESTION:
        case DICHOTOMOUS_QUESTION:
        case GROUPING_QUESTION:
        case GROUPING_QUESTION_OPTIONS:
        case RATING:
        case MATRIX:
            filterOptions = [];
            for (var i = 0; i < filterListItems.length; i++) {
                var id = $(filterListItems[i]).attr('id');
                var filterAtAnswerSelect = $(filterListItems[i]).find('.filterAtAnswerSelect .chosen').attr('id');
                var filterJumpSelect = $(filterListItems[i]).find('.filterJumpSelect .chosen').attr('id');
                filterOptions.push({id: id, filterAtAnswer: filterAtAnswerSelect, filterJump: filterJumpSelect});
            }
            break;
        case RANKING:
            filterOptions = [];
            for (var i = 0; i < filterListItems.length; i++) {
                var id = $(filterListItems[i]).attr('id');
                var filterAtAnswerSelect = $(filterListItems[i]).find('.filterAtAnswerSelect .chosen').attr('id');
                var filterAtPositionSelect = $(filterListItems[i]).find('.filterPositionSelect .chosen').attr('id');
                var filterJumpSelect = $(filterListItems[i]).find('.filterJumpSelect .chosen').attr('id');
                filterOptions.push({id: id, filterAtAnswer: filterAtAnswerSelect, filterJump: filterJumpSelect, filterAtPosition: filterAtPositionSelect});
            }
            break;
        case COUNTER:
            filterOptions = [];
            for (var i = 0; i < filterListItems.length; i++) {
                var id = $(filterListItems[i]).attr('id');
                var operatorSelect = $(filterListItems[i]).find('.operatorSelect .chosen').attr('id');
                var value = $(filterListItems[i]).find('#counter-number .stepper-text').val();
                var filterJumpSelect = $(filterListItems[i]).find('.filterJumpSelect .chosen').attr('id');
                filterOptions.push({id: id, operator: operatorSelect, filterJump: filterJumpSelect, value: value});
            }
            break;
        case SUM_QUESTION:
            filterOptions = [];
            for (var i = 0; i < filterListItems.length; i++) {
                var id = $(filterListItems[i]).attr('id');
                var filterAtAnswerSelect = $(filterListItems[i]).find('.filterAtAnswerSelect .chosen').attr('id');
                var operatorSelect = $(filterListItems[i]).find('.operatorSelect .chosen').attr('id');
                var value = $(filterListItems[i]).find('#counter-number .stepper-text').val();
                var filterJumpSelect = $(filterListItems[i]).find('.filterJumpSelect .chosen').attr('id');
                filterOptions.push({id: id, filterAtAnswer: filterAtAnswerSelect, operator: operatorSelect, filterJump: filterJumpSelect, value: value});
            }
            break;
    }

    return filterOptions;
}

function getFilterOptionsById(filterOptions, id) {
    if (filterOptions && filterOptions.length > 0) {
        var optionFilters = [];
        var noMatterFilters = [];

        for (var i = 0; i < filterOptions.length; i++) {
            if (parseInt(filterOptions[i].filterAtAnswer) === parseInt(id) || filterOptions[i].filterAtAnswer === id || (id === 'all' && filterOptions[i].filterAtAnswer !== 'noMatterAnswer')) {
                optionFilters.push(filterOptions[i]);
            } else if (filterOptions[i].filterAtAnswer === 'noMatterAnswer' || (filterOptions[i].filterAtAnswer === 'noMatterAnswer' && id === 'all')) {
                noMatterFilters.push(filterOptions[i]);
            }
        }
        return {optionFilters: unique(optionFilters), noMatterFilters: unique(noMatterFilters)};
    }
    return null;
}


/*
 * render a simple questionnaire
 * @param {type} questionnaire
 * @returns {Array|getQuestionnaireAnswers.questionnaireAnswers}
 */
var currentQuestionIndex = 0;
function renderQuestionnaire(target, questionnaire, answers, forceFilters) {

    console.log('render questionnaire, force filters:', forceFilters);
    clearAlerts(target);
    var nextQuestionButton = $(target).find('.btn-next-question');
    var doneQuestionnaireButton = $(target).find('.btn-questionnaire-done');


    if (hasFilterQuesitons(questionnaire) && forceFilters && forceFilters === true) {
        if (currentQuestionIndex < questionnaire.length) {
            renderQuestions(target, [questionnaire[currentQuestionIndex]], answers);
            $(nextQuestionButton).removeClass('hidden');
            $(doneQuestionnaireButton).addClass('hidden');
        } else {
            appendAlert(target, ALERT_WAITING_FOR_MODERATOR);
            return target;
        }

        $(nextQuestionButton).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(nextQuestionButton).hasClass('disabled')) {

                $(target).find('.question-container').trigger('nextQuestion');
                currentQuestionIndex = getNextQuestionIndex(target, currentQuestionIndex, questionnaire);

                if (filterQuestionStack.length === 0) {
                    if (currentQuestionIndex >= questionnaire.length) {
                        console.log('finish questionnaire');
                        $(nextQuestionButton).addClass('hidden');
                        $(doneQuestionnaireButton).addClass('hidden');
                        $(target).find('.question-container').empty();
                        appendAlert(target, ALERT_WAITING_FOR_MODERATOR);
                        $(target).find('.question-container').trigger('questionnaireDone');
                    } else if (currentQuestionIndex >= questionnaire.length - 1) {
                        console.log('last question reachead, render question');
                        renderQuestions(target, [questionnaire[currentQuestionIndex]], answers);
                        $(nextQuestionButton).addClass('hidden');
                        $(doneQuestionnaireButton).removeClass('hidden');
                    } else {
                        console.log('stack empty, render question');
                        renderQuestions(target, [questionnaire[currentQuestionIndex]], answers);
                        $(nextQuestionButton).removeClass('hidden');
                        $(doneQuestionnaireButton).addClass('hidden');
                    }
                } else {
                    if (filterQuestionStack.length === 1 && filterQuestionStack[0] === 'nextStep') {
                        console.log('stack not empty, but jump to next step');
                        renderQuestions(target, [questionnaire[currentQuestionIndex]], answers);
                        $(nextQuestionButton).addClass('hidden');
                        $(doneQuestionnaireButton).removeClass('hidden');
                    } else {
                        console.log('stack not empty, render question');
                        renderQuestions(target, [questionnaire[currentQuestionIndex]], answers);
                        $(nextQuestionButton).removeClass('hidden');
                        $(doneQuestionnaireButton).addClass('hidden');
                    }
                }
            }
        });

        $(doneQuestionnaireButton).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled') && !$(this).hasClass('hidden')) {
                $(nextQuestionButton).addClass('hidden');
                $(doneQuestionnaireButton).addClass('hidden');
                $(target).find('.question-container').empty();
                appendAlert(target, ALERT_WAITING_FOR_MODERATOR);
                $(target).find('.question-container').trigger('questionnaireDone');
                currentQuestionIndex = questionnaire.length;
            }
        });
    } else {
//        console.error('no filter questions');
        $(doneQuestionnaireButton).removeClass('hidden');
        renderQuestions(target, questionnaire, answers);

        $(doneQuestionnaireButton).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled') && !$(this).hasClass('hidden')) {
                $(doneQuestionnaireButton).addClass('hidden');
                $(target).find('.question-container').empty();
                appendAlert(target, ALERT_WAITING_FOR_MODERATOR);
                $(target).find('.question-container').trigger('questionnaireDone');
                currentQuestionIndex = questionnaire.length;
            }
        });
    }

    return target;
}

function renderQuestions(target, questionnaire, answers) {
    $(target).find('.question-container').empty();
    if (questionnaire && questionnaire.length > 0) {
        for (var i = 0; i < questionnaire.length; i++) {
            var item = $('#item-container-inputs').find('#' + questionnaire[i].format).clone(false);
//            $(item).addClass('.panel-shadow');
            item.attr('name', questionnaire[i].id);

            if (questionnaire.length > 1) {
                $(item).find('.question').text((i + 1) + '. ' + questionnaire[i].question);
            } else {
//                $(item).removeClass('panel-shadow');
                $(item).find('.question').text(questionnaire[i].question);
            }

            $(target).find('.question-container').append(item);

            var answer = getAnswerForId(questionnaire[i].id, answers);

            var parameters = questionnaire[i].parameters;
            var options = questionnaire[i].options;
            if (answer) {
                switch (questionnaire[i].format) {
                    case OPEN_QUESTION:
                        renderEditableOpenQuestion(item, questionnaire[i], answer);
                        break;
                    case COUNTER:
                        renderEditableCounter(item, questionnaire[i], answer);
                        break;
                    case DICHOTOMOUS_QUESTION:
                    case DICHOTOMOUS_QUESTION_GUS:
                        renderEditableDichotomousQuestion(item, questionnaire[i], answer);
                        break;
                    case GROUPING_QUESTION:
                        renderEditableGroupingQuestion(item, questionnaire[i], answer);
                        break;
                    case GROUPING_QUESTION_GUS:
                    case GROUPING_QUESTION_OPTIONS:
                        renderEditableGroupingQuestionGUS(item, questionnaire[i], answer);
                        break;
                    case RATING:
                        renderEditableRating(item, questionnaire[i], answer);
                        break;
                    case MATRIX:
                        renderEditableMatrix(item, questionnaire[i], answer);
                        break;
                    case SUM_QUESTION:
                        renderEditableSumQuestion(item, questionnaire[i], answer);
                        break;
                    case RANKING:
                        renderEditableRanking(item, questionnaire[i], answer);
                        break;
                    case ALTERNATIVE_QUESTION:
                        renderEditableAlternativeQuestion(item, questionnaire[i], answer);
                        break;
                    case UEQ_ITEM:
                        renderEditableUEQ(item, questionnaire[i], answer);
                        break;
                }
            } else {
                switch (questionnaire[i].format) {
                    case OPEN_QUESTION:
                        renderOpenQuestionInput(item, parameters);
                        break;
                    case COUNTER:
                        renderCounterInput(item, parameters);
                        break;
                    case DICHOTOMOUS_QUESTION:
                        renderDichotomousQuestionInput(item, parameters);
                        break;
                    case DICHOTOMOUS_QUESTION_GUS:
                        renderDichotomousQuestionGUSInput(item, parameters);
                        break;
                    case GROUPING_QUESTION:
                        renderGroupingQuestionInput(item, parameters, options);
                        break;
                    case GROUPING_QUESTION_GUS:
                    case GROUPING_QUESTION_OPTIONS:
                        renderGroupingQuestionGUSInput(item, parameters);
                        break;
                    case RATING:
                        renderRatingInput(item, options);
                        break;
                    case MATRIX:
                        renderMatrixInput(item, options);
                        break;
                    case SUM_QUESTION:
                        renderSumQuestionInput(item, parameters, options);
                        break;
                    case RANKING:
                        renderRankingInput(item, options);
                        break;
                    case ALTERNATIVE_QUESTION:
                        renderAlternativeQuestionInput(item, questionnaire[i]);
                        break;
                    case SUS_ITEM:
                        renderSusInput(item);
                        break;
                    case UEQ_ITEM:
                        renderUEQInput(item, parameters);
                        break;
                }
            }
        }
    }

    return target;
}

function hasFilterQuesitons(questionnaire) {
    if (questionnaire && questionnaire.length > 0) {
        var hasFilters = false;
        for (var i = 0; i < questionnaire.length; i++) {
            var question = questionnaire[i];
            switch (question.format) {
                case OPEN_QUESTION:
                case DICHOTOMOUS_QUESTION:
                case GROUPING_QUESTION:
                case GROUPING_QUESTION_OPTIONS:
                case RATING:
                case RANKING:
                case SUM_QUESTION:
                case COUNTER:
                    if (question.filterOptions && question.filterOptions.length > 0) {
                        hasFilters = true;
                        return hasFilters;
                    }
                    break;
                case MATRIX:
                    if (question.options && question.options.length > 0) {
                        for (var j = 0; j < question.options.length; j++) {
                            var matrixOption = question.options[j];
                            if (matrixOption.filterOptions && matrixOption.filterOptions.length > 0) {
                                hasFilters = true;
                                return hasFilters;
                            }
                        }
                    }
                    break;
            }
        }

        return hasFilters;
    }

    return false;
}

var filterQuestionStack = [];
function getNextQuestionIndex(target, currentQuestionIndex, questionnaire) {
    var question = questionnaire[currentQuestionIndex];
    var container = $(target).find('.question-container');
    var answers = getQuestionnaireAnswers(container.children());
    var filterOptions = null;

    switch (question.format) {
        case OPEN_QUESTION:
        case DICHOTOMOUS_QUESTION:
        case GROUPING_QUESTION:
        case GROUPING_QUESTION_OPTIONS:
        case RATING:
        case RANKING:
        case SUM_QUESTION:
        case COUNTER:
            filterOptions = question.filterOptions;
            break;
        case MATRIX:
            if (question.options && question.options.length > 0) {
                for (var i = 0; i < question.options.length; i++) {
                    var matrixFilterOptions = question.options[i].filterOptions;
                    if (matrixFilterOptions && matrixFilterOptions.length > 0) {
                        if (filterOptions) {
                            filterOptions = filterOptions.concat(matrixFilterOptions);
                        } else {
                            filterOptions = matrixFilterOptions;
                        }
                    }
                }
            }
            break;
    }

    if (filterOptions) {
        var tempJumpIds = [];

        for (var i = 0; i < answers.length; i++) {
            var answer = answers[i].answer;
            for (var j = 0; j < filterOptions.length; j++) {
                var filterOption = filterOptions[j];

                switch (question.format) {
                    case OPEN_QUESTION:
                    case DICHOTOMOUS_QUESTION:
                        if (answer.selectedSwitch === filterOption.filterAtAnswer || filterOption.filterAtAnswer === 'noMatterAnswer') {
                            if (tempJumpIds.length === 0) {
                                tempJumpIds = [filterOption.filterJump];
                            } else {
                                tempJumpIds.push(filterOption.filterJump);
                            }
                        }
                        break;
                    case GROUPING_QUESTION:
                    case GROUPING_QUESTION_OPTIONS:
                        for (var k = 0; k < answer.selections.length; k++) {

                            if (((answer.selections[k].selected === 'yes' && parseInt(answer.selections[k].id) === parseInt(filterOption.filterAtAnswer)) || (answer.selections[k].id === 'optionalAnswer' && filterOption.filterAtAnswer === 'optionalAnswer' && answer.selections[k].content !== '') || filterOption.filterAtAnswer === 'noMatterAnswer')) {
                                if (tempJumpIds.length === 0) {
                                    tempJumpIds = [filterOption.filterJump];
                                } else {
                                    tempJumpIds.push(filterOption.filterJump);
                                }
                            }
                        }
                        tempJumpIds = unique(tempJumpIds);
                        break;
                    case RATING:
                        var scale = parseInt(answer.scales);
                        if (scale !== -1 && parseInt(answer.id) === parseInt(filterOption.filterAtAnswer) || filterOption.filterAtAnswer === 'noMatterAnswer') {
                            if (tempJumpIds.length === 0) {
                                tempJumpIds = [filterOption.filterJump];
                            } else {
                                tempJumpIds.push(filterOption.filterJump);
                            }
                        }
                        tempJumpIds = unique(tempJumpIds);
                        break;
                    case RANKING:
                        if (parseInt(answer.arrangement[parseInt(filterOption.filterAtPosition) - 1]) === parseInt(filterOption.filterAtAnswer) || filterOption.filterAtAnswer === 'noMatterAnswer') {
                            if (tempJumpIds.length === 0) {
                                tempJumpIds = [filterOption.filterJump];
                            } else {
                                tempJumpIds.push(filterOption.filterJump);
                            }
                        }
                        tempJumpIds = unique(tempJumpIds);
                        break;
                    case MATRIX:
                        for (var k = 0; k < answer.scales.length; k++) {
                            if (parseInt(answer.scales[k].id) === parseInt(filterOption.filterAtAnswer) || filterOption.filterAtAnswer === 'noMatterAnswer') {
                                if (tempJumpIds.length === 0) {
                                    tempJumpIds = [filterOption.filterJump];
                                } else {
                                    tempJumpIds.push(filterOption.filterJump);
                                }
                            }
                        }
                        tempJumpIds = unique(tempJumpIds);
                        break;
                    case COUNTER:
                        var value = parseInt(filterOption.value);
                        var count = parseInt(answer.count);
                        var jumpIds = [];
                        switch (filterOption.operator) {
                            case 'equals':
                                if (count === value) {
                                    jumpIds.push(filterOption.filterJump);
                                }
                                break;
                            case 'greater':
                                if (count > value) {
                                    jumpIds.push(filterOption.filterJump);
                                }
                                break;
                            case 'minor':
                                if (count < value) {
                                    jumpIds.push(filterOption.filterJump);
                                }
                                break;
                            case 'equalsGreater':
                                if (count >= value) {
                                    jumpIds.push(filterOption.filterJump);
                                }
                                break;
                            case 'equalsMinor':
                                if (count <= value) {
                                    jumpIds.push(filterOption.filterJump);
                                }
                                break;
                        }

                        if (jumpIds.length > 0) {
                            if (tempJumpIds.length === 0) {
                                tempJumpIds = jumpIds;
                            } else {
                                tempJumpIds = tempJumpIds.concat(jumpIds);
                            }
                            tempJumpIds = unique(tempJumpIds);
                        }
                        break;
                    case SUM_QUESTION:
                        var sumCounts = answer.sumCounts;
                        for (var k = 0; k < sumCounts.length; k++) {
                            if (parseInt(sumCounts[k].id) === parseInt(filterOption.filterAtAnswer) || filterOption.filterAtAnswer === 'noMatterAnswer') {
                                var value = parseInt(filterOption.value);
                                var count = parseInt(sumCounts[k].count);
                                var jumpIds = [];
                                switch (filterOption.operator) {
                                    case 'equals':
                                        if (count === value) {
                                            jumpIds.push(filterOption.filterJump);
                                        }
                                        break;
                                    case 'greater':
                                        if (count > value) {
                                            jumpIds.push(filterOption.filterJump);
                                        }
                                        break;
                                    case 'minor':
                                        if (count < value) {
                                            jumpIds.push(filterOption.filterJump);
                                        }
                                        break;
                                    case 'equalsGreater':
                                        if (count >= value) {
                                            jumpIds.push(filterOption.filterJump);
                                        }
                                        break;
                                    case 'equalsMinor':
                                        if (count <= value) {
                                            jumpIds.push(filterOption.filterJump);
                                        }
                                        break;
                                }

                                if (jumpIds.length > 0) {
                                    if (tempJumpIds.length === 0) {
                                        tempJumpIds = jumpIds;
                                    } else {
                                        tempJumpIds = tempJumpIds.concat(jumpIds);
                                    }
                                }
                            }
                        }
                        tempJumpIds = unique(tempJumpIds);
                        break;
                }
            }
        }

        console.log('tempJumpIds', tempJumpIds);

        if (tempJumpIds.length > 0) {
            if (filterQuestionStack.length === 0) {
                filterQuestionStack = tempJumpIds;
            } else {
                tempJumpIds = tempJumpIds.reverse();
                for (var i = 0; i < tempJumpIds.length; i++) {
                    filterQuestionStack.unshift(tempJumpIds[i]);
                }
            }
        }

        console.log('stack:', filterQuestionStack);
        if (filterQuestionStack.length > 0) {
            var nextQuestionId = filterQuestionStack.shift();
            if (nextQuestionId === 'nextStep') {
                currentQuestionIndex = questionnaire.length;
            } else {
                currentQuestionIndex = getQuestionIndex(questionnaire, nextQuestionId);
            }
        } else {
            currentQuestionIndex++;
        }
    } else {
        if (filterQuestionStack.length > 0) {
            currentQuestionIndex = getQuestionIndex(questionnaire, filterQuestionStack.shift());
        } else {
            currentQuestionIndex++;
        }
    }

    filterQuestionStack = unique(filterQuestionStack);
    return currentQuestionIndex;
}

function getQuestionIndex(questionnaire, id) {
//    console.log('getget question index: ', questionnaire, id);
    if (questionnaire && questionnaire.length > 0) {
        for (var i = 0; i < questionnaire.length; i++) {
            var question = questionnaire[i];
            if (parseInt(question.id) === parseInt(id)) {
                return i;
            }
        }
    }
    return null;
}
/* 
 * get questionnaire form answers
 */

function getQuestionnaireAnswers(questionnaireItems, questionnaire) {
//    if (currentQuestionnaireAnswers) {
//        console.log('get questionnaire answers', currentQuestionnaireAnswers);
//    }

    var questionnaireAnswers = [];
    for (var i = 0; i < questionnaireItems.length; i++) {
        var format = $(questionnaireItems[i]).attr('id');
        var id = $(questionnaireItems[i]).attr('name');
//        var questionIndex = getQuestionIndex(questionnaire, id);
        var answer = null;

        switch (format) {
            case COUNTER:
                answer = getCounterAnswers($(questionnaireItems[i]));
//                questionnaireAnswers.push({id: id, answer: getCounterAnswers($(questionnaireItems[i]))});
                break;
            case OPEN_QUESTION:
            case OPEN_QUESTION_GUS:
                answer = getOpenQuestionAnswers($(questionnaireItems[i]));
//                questionnaireAnswers.push({id: id, answer: getOpenQuestionAnswers($(questionnaireItems[i]))});
                break;
            case DICHOTOMOUS_QUESTION:
            case DICHOTOMOUS_QUESTION_GUS:
                answer = getDichotomousQuestionAnswers($(questionnaireItems[i]));
//                questionnaireAnswers.push({id: id, answer: getDichotomousQuestionAnswers($(questionnaireItems[i]))});
                break;
            case GROUPING_QUESTION:
            case GROUPING_QUESTION_GUS:
            case GROUPING_QUESTION_OPTIONS:
                answer = getGroupingQuestionAnswers($(questionnaireItems[i]));
//                questionnaireAnswers.push({id: id, answer: getGroupingQuestionAnswers($(questionnaireItems[i]))});
                break;
            case RATING:
                answer = getRatingAnswers($(questionnaireItems[i]));
//                questionnaireAnswers.push({id: id, answer: getRatingAnswers($(questionnaireItems[i]))});
                break;
            case MATRIX:
                answer = getMatrixAnswers($(questionnaireItems[i]));
//                questionnaireAnswers.push({id: id, answer: getMatrixAnswers($(questionnaireItems[i]))});
                break;
            case SUM_QUESTION:
                answer = getSumQuestionAnswers($(questionnaireItems[i]));
//                questionnaireAnswers.push({id: id, answer: getSumQuestionAnswers($(questionnaireItems[i]))});
                break;
            case RANKING:
                answer = getRankingAnswers($(questionnaireItems[i]));
//                questionnaireAnswers.push({id: id, answer: getRankingAnswers($(questionnaireItems[i]))});
                break;
            case ALTERNATIVE_QUESTION:
                answer = getGroupingQuestionAnswers($(questionnaireItems[i]));
//                questionnaireAnswers.push({id: id, answer: getGroupingQuestionAnswers($(questionnaireItems[i]))});
                break;
            case GUS_SINGLE:
                answer = getSingleSUSAnswers($(questionnaireItems[i]));
//                questionnaireAnswers.push({id: id, answer: getSingleSUSAnswers($(questionnaireItems[i]))});
                break;
            case SUS_ITEM:
                answer = getSingleSUSAnswers($(questionnaireItems[i]));
//                questionnaireAnswers.push({id: id, answer: getSingleSUSAnswers($(questionnaireItems[i]))});
                break;
            case UEQ_ITEM:
                answer = getUEQAnswers($(questionnaireItems[i]));
//                questionnaireAnswers.push({id: id, answer: getUEQAnswers($(questionnaireItems[i]))});
                break;
        }

//        questionnaireAnswers[questionIndex] = {id: id, answer: answer};
        questionnaireAnswers.push({id: id, answer: answer});
    }

    return questionnaireAnswers;

    // search for existing answers and override it
//    if (questionnaireAnswers && questionnaireAnswers.length > 0) {
//        for (var i = 0; i < questionnaireAnswers.length; i++) {
//            var answerExists = false;
//
//            if (currentQuestionnaireAnswers && currentQuestionnaireAnswers.length > 0) {
//                for (var j = 0; j < currentQuestionnaireAnswers.length; j++) {
//                    if (parseInt(questionnaireAnswers[i].id) === parseInt(currentQuestionnaireAnswers[j].id)) {
//                        currentQuestionnaireAnswers[j].answer = questionnaireAnswers[i];
//                        answerExists = true;
//                        break;
//                    }
//                }
//
//                if (!answerExists) {
//                    currentQuestionnaireAnswers.push(questionnaireAnswers[i]);
//                }
//            } else {
//                currentQuestionnaireAnswers = questionnaireAnswers;
//            }
//        }
//    }

//    if (currentQuestionnaireAnswers && currentQuestionnaireAnswers.length > 0) {
//
//    } else {
//        currentQuestionnaireAnswers = questionnaireAnswers;
//    }
//
//    if (currentQuestionnaireAnswers && currentQuestionnaireAnswers.length > 0) {
//        currentQuestionnaireAnswers = currentQuestionnaireAnswers.concat(questionnaireAnswers);
//        currentQuestionnaireAnswers = unique(currentQuestionnaireAnswers);
//    } else {
//        currentQuestionnaireAnswers = questionnaireAnswers;
//    }


    return currentQuestionnaireAnswers;
}

function checkCurrentQuestionnaireAnswers(questionnaireAnswers) {

    if (questionnaireAnswers && questionnaireAnswers.length > 0) {

        for (var i = 0; i < questionnaireAnswers.length; i++) {
            var answerExists = false;
            console.log('check questionnaire answers:', questionnaireAnswers[i], currentQuestionnaireAnswers);

            if (currentQuestionnaireAnswers && currentQuestionnaireAnswers.answers && currentQuestionnaireAnswers.answers.length > 0) {
//                console.log('check answers');
                for (var j = 0; j < currentQuestionnaireAnswers.answers.length; j++) {
//                    console.log(questionnaireAnswers[i], currentQuestionnaireAnswers.answers[j]);
                    if (parseInt(questionnaireAnswers[i].id) === parseInt(currentQuestionnaireAnswers.answers[j].id)) {
                        currentQuestionnaireAnswers.answers[j].answer = questionnaireAnswers[i].answer;
                        answerExists = true;
                        break;
                    }
                }

                if (!answerExists) {
                    currentQuestionnaireAnswers.answers.push(questionnaireAnswers[i]);
                }
            } else {
                currentQuestionnaireAnswers = {answers: questionnaireAnswers};
            }
        }
    }

    console.log('return: ', currentQuestionnaireAnswers);
    return currentQuestionnaireAnswers;
}

function getCounterAnswers(source) {
    return {count: $(source).find('.stepper-text').val()};
}

function getOpenQuestionAnswers(source) {
    var data = new Object();
    var justificationInput = $(source).find('#justificationInput');
    if (justificationInput && justificationInput.length > 0) {
        data.justification = $(source).find('#justificationInput').val();
    }
    data.openAnswer = $(source).find('#openQuestionInput').val();
    return data;
}

function getDichotomousQuestionAnswers(source) {
    var data = new Object();
    data.selectedSwitch = $(source).find('.switch .btn-option-checked').attr('id') === undefined ? 'none' : $(source).find('.switch .btn-option-checked').attr('id');
    var justificationInput = $(source).find('#justificationInput');
    if (justificationInput && justificationInput.length > 0) {
        data.justification = $(source).find('#justificationInput').val();
    } else {
        data.justification = '';
    }
    return data;
}

function getGroupingQuestionAnswers(source) {
    var data = [];
    var options = $(source).find('.option-container .formgroup');
    for (var i = 0; i < options.length; i++) {
        var params = {};

        params.id = $(options[i]).find('.btn').attr('id');
        params.justification = '';
        var justification = $(options[i]).find('#justification');
        if (justification.length === 1 && justification !== undefined && !$(justification).hasClass('hidden')) {
            params.justification = $(justification).find('#justificationInput').val();
        }

        params.selected = 'no';
        if ($(options[i]).find('.btn-option-checked').length === 1) {
            params.selected = 'yes';
        }

        data.push(params);
    }

    if ($(source).find('#checkbox-optionalanswer .btn-option-checked').length === 1 || $(source).find('#radio-optionalanswer .btn-option-checked').length === 1) {
        data.push({id: 'optionalAnswer', content: $(source).find('.optionalInput').val()});
//        data.optionalAnswer = $(source).find('.optionalInput').val();
    } else {
//        data.optionalAnswer = '';
        data.push({id: 'optionalAnswer', content: ''});
    }

    return {selections: data};
}

function getRatingAnswers(source) {
    var data = new Object();
    var selectedItem = $(source).find('.option-container').find('.btn-option-checked').closest('.btn-group');
    var selectedIndex = $(selectedItem).index() >> 1;
    var selectedId = $(selectedItem).attr('id');
    data.scales = selectedIndex;
    data.id = selectedId;
    return data;
}

function getUEQAnswers(source) {
    var data = new Object();
    var selectedIndex = $(source).find('.option-container').find('.btn-option-checked').closest('.btn-group').index();
    data.selectedOption = selectedIndex;
    return data;
}

function getMatrixAnswers(source) {
    var data = new Object();
    var array = new Array();
    var scalesContainer = $(source).find('.scales-container');
    for (var i = 0; i < scalesContainer.length; i++) {
        var selected = $(scalesContainer[i]).find('.btn-option-checked').closest('.btn-group');
        var id = $(selected).attr('id');
        array.push({id: id, scale: $(selected).index() >> 1});
    }
    data.scales = array;
    return data;
}

function getSumQuestionAnswers(source) {
    var data = new Object();
    var array = new Array();
    var sumOptions = $(source).find('.option-container').children();
    for (var i = 0; i < sumOptions.length; i++) {
        array.push({id: $(sumOptions[i]).attr('id'), count: $(sumOptions[i]).find('.stepper-text').val()});
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

//function getAlternativeQuestionAnswers(source) {
//    var data = new Object();
//    var selectedOptions = $(source).find('.option-container .btn-option-checked');
//    var array = new Array();
//    for (var i = 0; i < selectedOptions.length; i++) {
//        if ($(selectedOptions[i]).parent().attr('id') !== 'checkbox-optionalanswer') {
//            array.push($(selectedOptions[i]).attr('id'));
//        }
//    }
//    data.selectedOptions = array;
//    data.optionalAnswer = $(source).find('.optionalInput').val();
//    data.justification = $(source).find('#justificationInput').val();
//    return data;
//}

function getSingleSUSAnswers(source) {
    return {selectedOption: $(source).find('.option-container .btn-option-checked').closest('.btn-group').index() >> 1};
}



/*
 * render questionnaire answers
 */

function renderQuestionnaireAnswers(content, studyData, resultsData, enableTweening, sequentialAnswerSearch) {
    console.log(studyData);

    $(content).find('.question-container').empty();
    for (var i = 0; i < studyData.length; i++) {
        var listItem = $('#template-study-container').find('#' + studyData[i].format).clone();
        listItem.find('#format .format-text').text(translation.questionFormats[studyData[i].format].text);
        $(listItem).find('.question').text(studyData.length > 1 ? (i + 1) + '. ' + studyData[i].question : studyData[i].question);


//        console.log(studyData[i], listItem)

        $(content).find('.question-container').append(listItem);
//        console.log($(content).find('.question-container'), listItem);

        if (studyData[i].dimension !== DIMENSION_ANY) {
            var dimensions = translation.dimensions;
            if (studyData[i].format === UEQ_ITEM) {
                dimensions = translation.ueqDimensions;
                $(listItem).find('#factor-main').text(translation.ueqMainDimensions[getMainDimensionForDimension(studyData[i].dimension, translation.ueqMainDimensionsForDimension)]);
                $(listItem).find('#factor-primary').removeClass('label-primary').addClass('label-info');
            }
            $(listItem).find('#item-factors').removeClass('hidden');
            $(listItem).find('#factor-primary').text(dimensions[studyData[i].dimension].title);

        }

//console.log(studyData[i].format, getAnswerForId(studyData[i].id, resultsData, sequentialAnswerSearch, i));
        switch (studyData[i].format) {
            case COUNTER:
                renderCounter(listItem, studyData[i], getAnswerForId(studyData[i].id, resultsData, sequentialAnswerSearch, i));
                break;
            case OPEN_QUESTION:
            case OPEN_QUESTION_GUS:
                renderOpenQuestion(listItem, studyData[i], getAnswerForId(studyData[i].id, resultsData, sequentialAnswerSearch, i));
                break;
            case DICHOTOMOUS_QUESTION:
                renderDichotomousQuestion(listItem, studyData[i], getAnswerForId(studyData[i].id, resultsData, sequentialAnswerSearch, i));
                break;
            case DICHOTOMOUS_QUESTION_GUS:
                renderDichotomousQuestion(listItem, studyData[i], getAnswerForId(studyData[i].id, resultsData, sequentialAnswerSearch, i));
                break;
            case GROUPING_QUESTION:
                renderGroupingQuestion(listItem, studyData[i], getAnswerForId(studyData[i].id, resultsData, sequentialAnswerSearch, i));
                break;
            case GROUPING_QUESTION_GUS:
            case GROUPING_QUESTION_OPTIONS:
                renderGroupingQuestionGUS(listItem, studyData[i], getAnswerForId(studyData[i].id, resultsData, sequentialAnswerSearch, i));
                break;
            case RATING:
                renderRating(listItem, studyData[i], getAnswerForId(studyData[i].id, resultsData, sequentialAnswerSearch, i));
                break;
            case MATRIX:
                renderMatrix(listItem, studyData[i], getAnswerForId(studyData[i].id, resultsData, sequentialAnswerSearch, i));
                break;
            case SUM_QUESTION:
                renderSumQuestion(listItem, studyData[i], getAnswerForId(studyData[i].id, resultsData, sequentialAnswerSearch, i));
                break;
            case RANKING:
                renderRanking(listItem, studyData[i], getAnswerForId(studyData[i].id, resultsData, sequentialAnswerSearch, i));
                break;
            case ALTERNATIVE_QUESTION:
                renderAlternativeQuestion(listItem, studyData[i], getAnswerForId(studyData[i].id, resultsData, sequentialAnswerSearch, i));
                break;
            case GUS_SINGLE:
                renderGUS(listItem, studyData[i], getAnswerForId(studyData[i].id, resultsData, sequentialAnswerSearch, i));
                break;
            case SUS_ITEM:
                renderSUSItem(listItem, studyData[i], getAnswerForId(studyData[i].id, resultsData, sequentialAnswerSearch, i));
                break;
            case UEQ_ITEM:
                $(listItem).find('.question').text((i + 1) + '. ' + translation.ueqOpposites[studyData[i].parameters.opposites.left] + ' - ' + translation.ueqOpposites[studyData[i].parameters.opposites.right]);
                $(listItem).find('.original-ueq-item-id').text(studyData[i].id);
                renderUEQItem(listItem, studyData[i], getAnswerForId(studyData[i].id, resultsData, sequentialAnswerSearch, i));
                break;
        }

        if (enableTweening) {
            $(listItem).css({y: 0, opacity: 1});
            TweenMax.from(listItem, .1, {delay: i * .1, opacity: 0, y: -10});
        }

        initPopover();
    }
}

function getAnswerForId(id, data, sequentialAnswerSearch, index) {
//    console.log(id, data, sequentialAnswerSearch);
    if (sequentialAnswerSearch && sequentialAnswerSearch === true) {
        var answer = data.answers[index].answer;
        if (answer) {
            return answer;
        }
    } else if (data && data.answers && data.answers.length > 0) {
        for (var i = 0; i < data.answers.length; i++) {
            if (parseInt(id) === parseInt(data.answers[i].id)) {
//                console.log('answer found for', id, data.answers[i].answer);
                return data.answers[i].answer;
            }
        }
    }

    return null;
}

function renderCounter(item, studyData, answer) {
    var parameters = studyData.parameters;
    $(item).find('#counter-label .counter-from').text(translation.of + ' ' + translation.atLeast + ' ' + parameters.countFrom);
    $(item).find('#counter-label .counter-to').text(translation.to + ' ' + translation.maximal + ' ' + parameters.countTo);
    if (answer && answer.count && answer.count !== '') {
        $(item).find('.answer').text(answer.count);
    } else {
        $(item).find('.answer').text('0');
        $(item).find('#no-answer').removeClass('hidden');
    }

    renderFilterOptionsData(COUNTER, item, getFilterOptionsById(studyData.filterOptions, 'all'));
}

function renderEditableCounter(item, studyData, answer) {
    var parameters = studyData.parameters;

    renderCounterInput(item, parameters);
    $(item).find('#counter-label .counter-from').text(translation.of + ' ' + translation.atLeast + ' ' + parameters.countFrom);
    $(item).find('#counter-label .counter-to').text(translation.to + ' ' + translation.maximal + ' ' + parameters.countTo);

    if (answer && !isNaN(parseInt(answer.count))) {
        $(item).find('.stepper-text').val(answer.count);
    }
}

function renderOpenQuestion(item, studyData, answer) {
//    $(item).find('.question').text(studyData.question);
    if (answer && answer.openAnswer && answer.openAnswer !== '') {
        $(item).find('.answer').text(answer.openAnswer);
    } else {
        $(item).find('#no-answer').removeClass('hidden');
        $(item).find('.answer').text('-');
    }

    if (studyData.parameters && studyData.parameters.justification && studyData.parameters.justification === 'yes') {
        $(item).find('#justification').removeClass('hidden');

        if (answer) {
            if (answer.justification !== '') {
                $(item).find('#justification-content').removeClass('hidden');
                $(item).find('#justification-content .text').text(answer.justification);
            } else if (answer.justification === '') {
                $(item).find('#no-justification-result').removeClass('hidden');
            }
        }
    }

    renderFilterOptionsData(OPEN_QUESTION, item, getFilterOptionsById(studyData.filterOptions, 'all'));
}

function renderEditableOpenQuestion(item, studyData, answer) {
    renderOpenQuestionInput(item, studyData.parameters);
//    console.log(answer);
    if (answer) {
        $(item).find('#openQuestionInput').val(answer.openAnswer);
    }
}

function renderDichotomousQuestion(item, studyData, answer) {
    console.log(studyData, answer);
    var options = [{id: 'yes', title: translation.yes}, {id: 'no', title: translation.no}];
    $(item).find('#no-answer').removeClass('hidden');

    for (var i = 0; i < options.length; i++) {
        var optionItem = $('#template-study-container').find('#dichotomous-question-item').clone();
        $(optionItem).attr('data-id', options[i].id);
        $(optionItem).find('.option-text').text(options[i].title);
        $(item).find('.option-container').append(optionItem);

        if (answer && answer.selectedSwitch === options[i].id) {
            $(item).find('#no-answer').addClass('hidden');
            $(optionItem).find('.option-text').addClass('bordered-scale-item');
        } else {
            $(optionItem).find('.option-text').css({paddingLeft: "0px"});
        }

        renderFilterOptionsData(DICHOTOMOUS_QUESTION, optionItem, getFilterOptionsById(studyData.filterOptions, options[i].id));
    }

    if (studyData.parameters.justification === 'yes') {
        $(item).find('#justification').removeClass('hidden');
        $(item).find('#' + studyData.parameters.justificationFor).removeClass('hidden');

        if (answer) {
            if ((answer.selectedSwitch === studyData.parameters.justificationFor || studyData.parameters.justificationFor === 'always') && answer.justification !== '') {
                $(item).find('#justification-content').removeClass('hidden');
                $(item).find('#justification-content .text').text(answer.justification);
            } else if (answer.justification === '' && (answer.selectedSwitch === studyData.parameters.justificationFor || studyData.parameters.justificationFor === 'always')) {
                $(item).find('#no-justification-result').removeClass('hidden');
            }
        }
    } else {
        $(item).find('#no-justification').removeClass('hidden');
    }
}

function renderEditableDichotomousQuestion(item, studyData, answer) {
    var parameters = studyData.parameters;
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

function renderGroupingQuestion(item, studyData, answer) {
    if (studyData.parameters.multiselect === 'yes') {
        $(item).find('#multiselect').removeClass('hidden');
    } else {
        $(item).find('#singleselect').removeClass('hidden');
    }

//    renderFilterOptionsData(GROUPING_QUESTION, item, studyData.filterOptions, true);

//    console.log('answer:', answer);

    for (var i = 0; i < studyData.options.length; i++) {
        var optionItem = $('#template-study-container').find('#grouping-question-item').clone();
        $(optionItem).attr('data-id', studyData.options[i].id);
        $(optionItem).find('.option-text').text(studyData.options[i].title);
        $(item).find('.option-container').append(optionItem);

        if (i < studyData.options.length - 1) {
            var hr = document.createElement('hr');
            $(hr).css({marginTop: "15px", marginBottom: "5px"});
            $(item).find('.option-container').append(hr);
        }

        var answerValue = null;
        if (answer && answer.selections && answer.selections.length > 0) {
            for (var j = 0; j < answer.selections.length; j++) {
                if (parseInt(answer.selections[j].id) === parseInt(studyData.options[i].id)) {
                    answerValue = answer.selections[j];
                    break;
                }
            }
        }

//        console.log('answer value:', answerValue, optionalAnswerValue);

        if (studyData.options[i].justification === 'yes') {
            optionItem.find('#justification').removeClass('hidden');
            optionItem.find('#' + studyData.options[i].justificationFor).removeClass('hidden');

            if (answerValue) {
                if (studyData.options[i].justificationFor === 'selectOne') {
                    if (answerValue.selected === 'yes' && answerValue.justification !== '') {
                        $(optionItem).find('#justification-content').removeClass('hidden');
                        $(optionItem).find('#justification-content .text').text(answerValue.justification);
                    } else if (answerValue.selected === 'yes') {
                        $(optionItem).find('#no-answer-justification').removeClass('hidden');
                    }
                } else if (studyData.options[i].justificationFor === 'selectNothing') {
                    if (answerValue.selected === 'no' && answerValue.justification !== '') {
                        $(optionItem).find('#justification-content').removeClass('hidden');
                        $(optionItem).find('#justification-content .text').text(answerValue.justification);
                    } else if (answerValue.selected === 'no') {
                        $(optionItem).find('#no-answer-justification').removeClass('hidden');
                    }
                } else if (studyData.options[i].justificationFor === 'always' && answerValue.justification !== '') {
                    $(optionItem).find('#justification-content').removeClass('hidden');
                    $(optionItem).find('#justification-content .text').text(answerValue.justification);
                } else {
                    $(optionItem).find('#no-answer-justification').removeClass('hidden');
                }
            } else {
                $(item).find('#no-answer').removeClass('hidden');
            }
        } else {
            optionItem.find('#no-justification').removeClass('hidden');
        }

        if (answerValue) {

//            console.log(answer, answerValue);
            if (answerValue.selected === 'yes') {
                $(item).find('#no-answer').addClass('hidden');
                $(optionItem).find('.option-text').addClass('bordered-scale-item');
                if (i > 0) {
                    $(optionItem).find('.option-text').css({marginTop: '5px'});
                }
            } else {
                $(optionItem).find('.option-text').css({paddingLeft: "0px"});
            }

        } else {
            $(optionItem).find('.option-text').css({paddingLeft: "0px"});
        }

        renderFilterOptionsData(GROUPING_QUESTION, optionItem, getFilterOptionsById(studyData.filterOptions, studyData.options[i].id));
    }

    if (studyData.parameters.optionalanswer === 'yes') {
//        var hr = document.createElement('hr');
//        $(hr).css({marginTop: "15px", marginBottom: "5px"});
//        $(item).find('.option-container').append(hr);

        var optionalAnswerValue = null;
        if (answer && answer.selections && answer.selections.length > 0) {
            for (var j = 0; j < answer.selections.length; j++) {
                if (answer.selections[j].id === 'optionalAnswer') {
                    optionalAnswerValue = answer.selections[j];
                    break;
                }
            }
        }

//        console.log('optional answer value:', optionalAnswerValue);

        $(item).find('#optionalanswer').removeClass('hidden');
        $(item).find('#optionalanswer-content').removeClass('hidden');

        if (optionalAnswerValue) {
            if (optionalAnswerValue.content !== '') {
                $(item).find('#optionalanswer-content .address').addClass('bordered-scale-item');
                $(item).find('#optionalanswer-content .text').text(optionalAnswerValue.content);
                $(item).find('#no-answer').addClass('hidden');
            } else {
                $(item).find('#optionalanswer-content .address').css({paddingLeft: "0px"});
                $(item).find('#optionalanswer-content .text').text('-');
                $(item).find('#no-optional-answer').removeClass('hidden');
            }
        } else {
            $(item).find('#optionalanswer-content .address').css({paddingLeft: "0px"});
            $(item).find('#optionalanswer-content .text').text('-');
            $(item).find('#no-optional-answer').removeClass('hidden');
        }

        renderFilterOptionsData(GROUPING_QUESTION, $(item).find('#optionalanswer-content'), getFilterOptionsById(studyData.filterOptions, 'optionalAnswer'));
    }
}

function renderEditableGroupingQuestion(item, studyData, answer) {
    var parameters = studyData.parameters;
    var options = studyData.options;
    renderGroupingQuestionInput(item, parameters, options);

    if (parameters.multiselect === 'yes') {
        $(item).find('#multiselect').removeClass('hidden');
    } else {
        $(item).find('#singleselect').removeClass('hidden');
    }

    if (answer) {
        for (var i = 0; i < answer.selections.length; i++) {
            if (answer.selections[i].selected === 'yes' || answer.selections[i].id === 'optionalAnswer') {

                if (answer.selections[i].id === 'optionalAnswer') {
                    if (answer.selections[i].content !== '') {
                        checkOption($(item).find('#checkbox-optionalanswer .btn-checkbox'));
                        checkOption($(item).find('#radio-optionalanswer .btn-radio'));
                        $(item).find('.optionalInput').val(answer.selections[i].content);
                    }
                } else {
                    var optionButton = $(item).find('#' + answer.selections[i].id);
                    checkOption(optionButton);
                    var justificationInput = $(optionButton).closest('.formgroup').find('#justificationInput');
                    $(justificationInput).val(answer.selections[i].justification);
                }
            }
        }
    }
}


function renderGroupingQuestionGUS(item, studyData, answer) {
//    console.log(item, studyData, answer);
    var options;

    if (studyData.parameters.options) {
        options = studyData.parameters.options;
    } else {
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
    }

//    renderFilterOptionsData(GROUPING_QUESTION, item, studyData.filterOptions, true);

//    if (studyData.parameters.multiselect === 'yes') {
//        item.find('#multiselect').removeClass('hidden');
//    } else {
//        item.find('#singleselect').removeClass('hidden');
//    }
//
//    if (studyData.parameters.optionalanswer === 'yes') {
//        $(item).find('#optionalanswer').removeClass('hidden');
//        if (answer) {
//            if (answer.optionalAnswer !== '') {
//                $(item).find('#no-answer').addClass('hidden');
//                $(item).find('#optionalanswer-content').removeClass('hidden');
//                $(item).find('#optionalanswer-content .text').text(answer.optionalAnswer);
//            } else {
//                $(item).find('#no-optional-answer').removeClass('hidden');
//            }
//        }
//    }
//
//    if (options && options.length > 0) {
//        for (var i = 0; i < options.length; i++) {
//            var optionItem = $('#template-study-container').find('#grouping-question-item').clone();
//            $(optionItem).find('.option-text').text(options[i].title);
//            $(item).find('.option-container').append(optionItem);
//
//            if (i < options.length) {
//                var hr = document.createElement('hr');
//                $(hr).css({marginTop: "15px", marginBottom: "5px"});
//                $(item).find('.option-container').append(hr);
//            }
//
//            if (studyData.parameters.justification === 'yes') {
//                optionItem.find('#justification').removeClass('hidden');
//                optionItem.find('#' + studyData.parameters.justificationFor).removeClass('hidden');
//
//                if (answer) {
//                    var values = answer[options[i].id];
//                    if (studyData.parameters.justificationFor === 'selectOne') {
//                        if (values.selected === 'yes' && values.justification !== '') {
//                            $(optionItem).find('#justification-content').removeClass('hidden');
//                            $(optionItem).find('#justification-content .text').text(values.justification);
//                        } else if (values.selected === 'yes') {
//                            $(optionItem).find('#no-answer-justification').removeClass('hidden');
//                        }
//                    } else if (studyData.parameters.justificationFor === 'selectNothing') {
//                        if (values.selected === 'no' && values.justification !== '') {
//                            $(optionItem).find('#justification-content').removeClass('hidden');
//                            $(optionItem).find('#justification-content .text').text(values.justification);
//                        } else if (values.selected === 'no') {
//                            $(optionItem).find('#no-answer-justification').removeClass('hidden');
//                        }
//                    } else if (studyData.parameters.justificationFor === 'always' && values.justification !== '') {
//                        $(optionItem).find('#justification-content').removeClass('hidden');
//                        $(optionItem).find('#justification-content .text').text(values.justification);
//                    } else {
//                        $(optionItem).find('#no-answer-justification').removeClass('hidden');
//                    }
//                } else {
//                    $(item).find('#no-answer').removeClass('hidden');
//                }
//            } else {
//                optionItem.find('#no-justification').removeClass('hidden');
//            }
//
//            if (answer) {
//                var value = answer[options[i].id];
//                if (value.selected === 'yes') {
//                    $(item).find('#no-answer').addClass('hidden');
//                    $(optionItem).find('.option-text').addClass('bordered-scale-item');
//                    if (i > 0) {
//                        $(optionItem).find('.option-text').css({marginTop: '5px'});
//                    }
//                } else {
//                    $(optionItem).find('.option-text').css({paddingLeft: "0px"});
//                }
//
//                if (studyData.parameters.optionSource === 'gestures') {
//                    var gesture = getGestureById(options[i].id);
//                    var button = $('#item-container-inputs').find('#btn-show-gesture').clone().removeClass('hidden').removeAttr('id');
//                    button.attr('name', gesture.id);
//                    $(button).insertAfter($(optionItem).find('.option-text'));
//                    $(button).css({border: '1px solid rgba(0,0,0,0.3)'});
//                }
//            } else {
//                $(optionItem).find('.option-text').css({paddingLeft: "0px"});
//            }
//
//            renderFilterOptionsData(GROUPING_QUESTION_OPTIONS, optionItem, getFilterOptionsById(studyData.filterOptions, options[i].id));
//        }
//    }

    if (studyData.parameters.multiselect === 'yes') {
        $(item).find('#multiselect').removeClass('hidden');
    } else {
        $(item).find('#singleselect').removeClass('hidden');
    }

//    console.log('answer:', answer);

    for (var i = 0; i < options.length; i++) {
        var optionItem = $('#template-study-container').find('#grouping-question-item').clone();
        $(optionItem).find('.option-text').text(options[i].title);
        $(optionItem).attr('data-id', options[i].id);
        $(item).find('.option-container').append(optionItem);

        if (i < options.length - 1) {
            var hr = document.createElement('hr');
            $(hr).css({marginTop: "15px", marginBottom: "5px"});
            $(item).find('.option-container').append(hr);
        }

        var answerValue = null;
        if (answer && answer.selections && answer.selections.length > 0) {
            for (var j = 0; j < answer.selections.length; j++) {
                if (parseInt(answer.selections[j].id) === parseInt(options[i].id)) {
                    answerValue = answer.selections[j];
                    break;
                }
            }
        }

//        console.log('answer value:', answerValue, optionalAnswerValue);

        if (studyData.parameters.justification === 'yes') {
            optionItem.find('#justification').removeClass('hidden');
            optionItem.find('#' + options[i].justificationFor).removeClass('hidden');

            if (answerValue) {
                if (studyData.parameters.justificationFor === 'selectOne') {
                    if (answerValue.selected === 'yes' && answerValue.justification !== '') {
                        $(optionItem).find('#justification-content').removeClass('hidden');
                        $(optionItem).find('#justification-content .text').text(answerValue.justification);
                    } else if (answerValue.selected === 'yes') {
                        $(optionItem).find('#no-answer-justification').removeClass('hidden');
                    }
                } else if (studyData.parameters.justificationFor === 'selectNothing') {
                    if (answerValue.selected === 'no' && answerValue.justification !== '') {
                        $(optionItem).find('#justification-content').removeClass('hidden');
                        $(optionItem).find('#justification-content .text').text(answerValue.justification);
                    } else if (answerValue.selected === 'no') {
                        $(optionItem).find('#no-answer-justification').removeClass('hidden');
                    }
                } else if (studyData.parameters.justificationFor === 'always' && answerValue.justification !== '') {
                    $(optionItem).find('#justification-content').removeClass('hidden');
                    $(optionItem).find('#justification-content .text').text(answerValue.justification);
                } else {
                    $(optionItem).find('#no-answer-justification').removeClass('hidden');
                }
            } else {
                $(item).find('#no-answer').removeClass('hidden');
            }
        } else {
            optionItem.find('#no-justification').removeClass('hidden');
        }

        if (answerValue) {

//            console.log(answer, answerValue);
            if (answerValue.selected === 'yes') {
                $(item).find('#no-answer').addClass('hidden');
                $(optionItem).find('.option-text').addClass('bordered-scale-item');
                if (i > 0) {
                    $(optionItem).find('.option-text').css({marginTop: '5px'});
                }
            } else {
                $(optionItem).find('.option-text').css({paddingLeft: "0px"});
            }

        } else {
            $(optionItem).find('.option-text').css({paddingLeft: "0px"});
        }

        renderFilterOptionsData(GROUPING_QUESTION, optionItem, getFilterOptionsById(studyData.filterOptions, options[i].id));
    }

    if (studyData.parameters.optionalanswer === 'yes') {
//        var hr = document.createElement('hr');
//        $(hr).css({marginTop: "15px", marginBottom: "5px"});
//        $(item).find('.option-container').append(hr);

        var optionalAnswerValue = null;
        if (answer && answer.selections && answer.selections.length > 0) {
            for (var j = 0; j < answer.selections.length; j++) {
                if (answer.selections[j].id === 'optionalAnswer') {
                    optionalAnswerValue = answer.selections[j];
                    break;
                }
            }
        }

//        console.log('optional answer value:', optionalAnswerValue);

        $(item).find('#optionalanswer').removeClass('hidden');
        $(item).find('#optionalanswer-content').removeClass('hidden');

        if (optionalAnswerValue) {
            if (optionalAnswerValue.content !== '') {
                $(item).find('#optionalanswer-content .address').addClass('bordered-scale-item');
                $(item).find('#optionalanswer-content .text').text(optionalAnswerValue.content);
                $(item).find('#no-answer').addClass('hidden');
            } else {
                $(item).find('#optionalanswer-content .address').css({paddingLeft: "0px"});
                $(item).find('#optionalanswer-content .text').text('-');
                $(item).find('#no-optional-answer').removeClass('hidden');
            }
        } else {
            $(item).find('#optionalanswer-content .address').css({paddingLeft: "0px"});
            $(item).find('#optionalanswer-content .text').text('-');
            $(item).find('#no-optional-answer').removeClass('hidden');
        }

        renderFilterOptionsData(GROUPING_QUESTION, $(item).find('#optionalanswer-content'), getFilterOptionsById(studyData.filterOptions, 'optionalAnswer'));
    }

//    renderFilterOptionsData(GROUPING_QUESTION, item, studyData.filterOptions);
}


function renderEditableGroupingQuestionGUS(item, studyData, answer) {
    var parameters = studyData.parameters;
    renderGroupingQuestionGUSInput(item, parameters);
    if (parameters.multiselect === 'yes') {
        $(item).find('#multiselect').removeClass('hidden');
    } else {
        $(item).find('#singleselect').removeClass('hidden');
    }

    if (answer) {

        for (var i = 0; i < answer.selections.length; i++) {
            if (answer.selections[i].selected === 'yes' || answer.selections[i].id === 'optionalAnswer') {
                if (answer.selections[i].id === 'optionalAnswer') {
                    if (answer.selections[i].content !== '') {
                        checkOption($(item).find('#checkbox-optionalanswer .btn-checkbox'));
                        checkOption($(item).find('#radio-optionalanswer .btn-radio'));
                        $(item).find('.optionalInput').val(answer.selections[i].content);
                    }
                } else {
                    var optionButton = $(item).find('#' + answer.selections[i].id);
                    checkOption(optionButton);
                    var justificationInput = $(optionButton).closest('.formgroup').find('#justificationInput');
                    $(justificationInput).val(answer.selections[i].justification);
                }
            }
        }

//        for (var id in answer) {
//            if (answer.hasOwnProperty(id) && answer[id].selected === 'yes') {
//                var optionButton = $(item).find('#' + id);
//                checkOption(optionButton);
//                var justificationInput = $(optionButton).closest('.formgroup').find('#justificationInput');
//                $(justificationInput).val(answer[id].justification);
//            }
//        }
//
//        if (answer.optionalAnswer !== '') {
//            checkOption($(item).find('#checkbox-optionalanswer .btn-checkbox'));
//            checkOption($(item).find('#radio-optionalanswer .btn-radio'));
//            $(item).find('.optionalInput').val(answer.optionalAnswer);
//        }
    }
}

function renderRating(item, studyData, answer) {
    if (studyData.parameters.negative === 'yes') {
        $(item).find('#negative').removeClass('hidden');
    } else {
        $(item).find('#positive').removeClass('hidden');
    }

//    renderFilterOptionsData(RATING, item, studyData.filterOptions, true);

    var optionItem = $('#template-study-container').find('#rating-item').clone();
    $(item).find('.option-container').append(optionItem);

    if (answer) {
        var score = 0;
        var maxScore = studyData.options.length;
        var selectedScale = parseInt(answer.scales);
        if (studyData.parameters.negative === 'yes') {
            score = studyData.options.length - selectedScale;
        } else {
            score = selectedScale + 1;
        }

        if (selectedScale === -1) {
            $(item).find('#score-container').remove();
            $(item).find('#no-answer').removeClass('hidden');
        } else {
            renderRatingSigns($(optionItem).find('#score-container'), score, maxScore);
            $(item).find('#no-answer').remove();
        }


    } else {
//        $(item).find('#scale-container').remove();
        $(item).find('#score-container').remove();
        $(item).find('#no-answer').removeClass('hidden');
    }

    for (var i = 0; i < studyData.options.length; i++) {
        var scaleItem = $('#template-study-container').find('#rating-scale-item').clone();
        $(optionItem).find('#scale-container').append(scaleItem);
        $(scaleItem).find('.option-text').text((i + 1) + '. ' + studyData.options[i].title);
        if (answer && i === selectedScale) {
            $(scaleItem).find('.option-text').addClass('bordered-scale-item');
        } else {
            $(scaleItem).find('.option-text').css({paddingLeft: "0px"});
        }

//        if (i < studyData.options.length - 1) {
//            var breakItem = document.createElement('br');
//            $(optionItem).find('#scale-container').append(breakItem);
//        }

        renderFilterOptionsData(RATING, scaleItem, getFilterOptionsById(studyData.filterOptions, studyData.options[i].id));
    }
}

function renderEditableRating(item, studyData, answer) {
    renderRatingInput(item, studyData.options);
    if (answer && answer.scales) {
        if (parseInt(answer.scales) !== -1) {
            var container = $(item).find('.option-container');
            setTimeout(function (target, index) {
                $(target).find('.btn-radio')[index].click();
            }, 100, container, parseInt(answer.scales));
        }
    }
}

function renderMatrix(item, studyData, answer) {
    for (var i = 0; i < studyData.options.length; i++) {
        var optionItem = $('#template-study-container').find('#matrix-item').clone();
        $(optionItem).find('#rating-option').text(studyData.options[i].option);
        $(item).find('.option-container').append(optionItem);

        if (i < studyData.options.length - 1) {
            var hr = document.createElement('hr');
            $(hr).css({marginTop: "15px", marginBottom: "5px"});
            $(item).find('.option-container').append(hr);
        }

//        renderFilterOptionsData(MATRIX, optionItem, studyData.options[i].filterOptions, true);

        if (answer) {
            var score = 0;
            var maxScore = studyData.options[i].scales.length;
            var selectedScale = parseInt(answer.scales[i].scale);
            if (studyData.options[i].negative === 'yes') {
                $(optionItem).find('#negative').removeClass('hidden');
                score = studyData.options[i].scales.length - selectedScale;
            } else {
                $(optionItem).find('#positive').removeClass('hidden');
                score = selectedScale + 1;
            }

            if (selectedScale === -1) {
                $(optionItem).find('#score-container').remove();
                $(optionItem).find('#no-answer').removeClass('hidden');
            } else {
                renderRatingSigns($(optionItem).find('#score-container'), score, maxScore);
                $(optionItem).find('#no-answer').remove();
            }

            for (var j = 0; j < studyData.options[i].scales.length; j++) {
                var scaleItem = $('#template-study-container').find('#rating-scale-item').clone();
                $(optionItem).find('#scale-container').append(scaleItem);
                $(scaleItem).attr('id', studyData.options[i].scales[j].id);
                $(scaleItem).find('.option-text').text((j + 1) + '. ' + studyData.options[i].scales[j].title);
                if (j === selectedScale) {
                    $(scaleItem).find('.option-text').addClass('bordered-scale-item');
                } else {
                    $(scaleItem).find('.option-text').css({paddingLeft: "0px"});
                }
                renderFilterOptionsData(MATRIX, scaleItem, getFilterOptionsById(studyData.options[i].filterOptions, studyData.options[i].scales[j].id));

//                if (j < studyData.options[i].scales.length - 1) {
//                    var breakItem = document.createElement('br');
//                    $(optionItem).find('#scale-container').append(breakItem);
//                }
            }
        } else {
            $(optionItem).find('#score-container').remove();
            $(item).find('#no-answer').removeClass('hidden');

            if (studyData.options[i].negative === 'yes') {
                $(optionItem).find('#negative').removeClass('hidden');
//                score = studyData.options[i].scales.length - selectedScale;
            } else {
                $(optionItem).find('#positive').removeClass('hidden');
//                score = selectedScale + 1;
            }

            for (var j = 0; j < studyData.options[i].scales.length; j++) {
                var scaleItem = $('#template-study-container').find('#rating-scale-item').clone();
                $(scaleItem).attr('id', studyData.options[i].scales[j].id);
                $(optionItem).find('#scale-container').append(scaleItem);
                $(scaleItem).find('.option-text').text((j + 1) + '. ' + studyData.options[i].scales[j].title);
                $(scaleItem).find('.option-text').css({paddingLeft: "0px"});
                renderFilterOptionsData(MATRIX, scaleItem, getFilterOptionsById(studyData.options[i].filterOptions, studyData.options[i].scales[j].id));

//                if (j < studyData.options[i].scales.length - 1) {
//                    var breakItem = document.createElement('br');
//                    $(optionItem).find('#scale-container').append(breakItem);
//                }
            }
        }
    }
}

function renderEditableMatrix(item, studyData, answer) {
    renderMatrixInput(item, studyData.options);
    if (answer && answer.scales && answer.scales.length > 0) {
        for (var i = 0; i < answer.scales.length; i++) {
//            console.log('selected scales: ', answer.scales[i]);
            if (parseInt(answer.scales[i]) !== -1) {
                var container = $(item).find('.scales-container')[i];
                setTimeout(function (target, id) {
//                    console.log($(target).find('#' + id));
                    $(target).find('#' + id + ' .btn').click();
                }, 100, container, parseInt(answer.scales[i].id));
            }
        }
    }
}

function renderSumQuestion(item, studyData, answer) {
    $(item).find('#maximum .label-text').text(translation.maximum + ': ' + studyData.parameters.maximum);
    $(item).find('#allocation .label-text').text(translation.scaleTypes[studyData.parameters.allocation]);

//    console.log('sumQuestion', studyData.filterOptions);

    if (studyData.options && studyData.options.length > 0) {
        var count = 0;

        for (var i = 0; i < studyData.options.length; i++) {
            var listItemAnswer = $('#template-study-container').find('#sum-question-item').clone();
            $(listItemAnswer).attr('data-id', studyData.options[i].id);
            $(item).find('.option-container').append(listItemAnswer);
            if (answer) {
                count += parseInt(answer.sumCounts[i].count);
                $(listItemAnswer).find('.option-text').text(studyData.options[i].title + ': ' + answer.sumCounts[i].count + ' ' + translation.scaleTypes[studyData.parameters.allocation]);
            } else {
                $(listItemAnswer).find('.option-text').text(studyData.options[i].title + ': 0 ' + translation.scaleTypes[studyData.parameters.allocation]);
                $(item).find('#no-answer').removeClass('hidden');
            }

            renderFilterOptionsData(SUM_QUESTION, $(listItemAnswer), getFilterOptionsById(studyData.filterOptions, studyData.options[i].id));
        }

        if (count === parseInt(studyData.parameters.maximum)) {
            $(item).find('#distributeAllPoints').removeClass('hidden');
        } else {
            $(item).find('#distributeNotAllPoints').removeClass('hidden');
        }
    }


//    for (var i = 0; i < answer.sumCounts.length; i++) {
//        if (answer) {
//
//        } else {
//
//        }
//    }

}

function renderEditableSumQuestion(item, studyData, answer) {
    var parameters = studyData.parameters;
    var options = studyData.options;
    $(item).find('#maximum .label-text').text(translation.maximum + ': ' + parameters.maximum);
    $(item).find('#allocation .label-text').text(translation.scaleTypes[parameters.allocation]);
    renderSumQuestionInput(item, parameters, options);
    if (answer && answer.sumCounts && answer.sumCounts.length > 0) {
        for (var i = 0; i < answer.sumCounts.length; i++) {
            $($(item).find('.option-container').find('.stepper-text')[i]).val(answer.sumCounts[i].count);
        }
    }
}

function renderRanking(item, studyData, answer) {
    if (answer) {
        for (var i = 0; i < answer.arrangement.length; i++) {
            var listItemAnswer = $('#template-study-container').find('#ranking-item').clone();
            var text = '';
            var optionsId = parseInt(answer.arrangement[i]);
            for (var j = 0; j < studyData.options.length; j++) {
                if (optionsId === parseInt(studyData.options[j].id)) {
                    text = studyData.options[j].text;
                    renderFilterOptionsData(RANKING, $(listItemAnswer), getFilterOptionsById(studyData.filterOptions, studyData.options[j].id));
                }
            }

            $(listItemAnswer).find('.option-text').text((i + 1) + '. ' + text);
            $(item).find('.option-container').append(listItemAnswer);
        }
    } else {
        $(item).find('#no-answer').removeClass('hidden');
        for (var j = 0; j < studyData.options.length; j++) {
            var listItemAnswer = $('#template-study-container').find('#ranking-item').clone();
            $(listItemAnswer).find('.option-text').text((j + 1) + '. ' + studyData.options[j].text);
            $(item).find('.option-container').append(listItemAnswer);
            renderFilterOptionsData(RANKING, $(listItemAnswer), getFilterOptionsById(studyData.filterOptions, studyData.options[j].id));
        }
    }
}

function renderEditableRanking(item, studyData, answer) {
    var options = studyData.options;
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

function renderAlternativeQuestion(item, studyData, answer) {
    if (studyData.parameters.optionalanswer === 'yes') {
        $(item).find('#optionalanswer').removeClass('hidden');
    }

    if (studyData.parameters.justification === 'yes') {
        $(item).find('#justification').removeClass('hidden');
        $(item).find('#' + studyData.parameters.justificationFor).removeClass('hidden');

        if (answer) {
            if (studyData.parameters.justificationFor === 'selectOne' && answer.selectedOptions && answer.selectedOptions.length > 0 && answer.justification !== '') {
                $(item).find('#justification-content').removeClass('hidden');
                $(item).find('#justification-content .text').text(answer.justification);
            } else if (studyData.parameters.justificationFor === 'selectNothing' && !answer.selectedOptions && answer.justification !== '') {
                $(item).find('#justification-content').removeClass('hidden');
                $(item).find('#justification-content .text').text(answer.justification);
            } else if (studyData.parameters.justificationFor === 'always' && answer.justification !== '') {
                $(item).find('#justification-content').removeClass('hidden');
                $(item).find('#justification-content .text').text(answer.justification);
            } else if (answer.selectedOptions && answer.selectedOptions.length > 0 && answer.justification === '') {
                $(item).find('#no-justification-result').removeClass('hidden');
            }
        } else {
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

            if (answer && answer.selectedOptions && answer.selectedOptions.length > 0) {
                for (var j = 0; j < answer.selectedOptions.length; j++) {
                    if (parseInt(answer.selectedOptions[j]) === parseInt(options[i].id)) {
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

    if (answer) {
        if (answer.optionalAnswer !== '') {
            $(item).find('#no-answer').addClass('hidden');
            $(item).find('#optionalanswer-content').removeClass('hidden');
            $(item).find('#optionalanswer-content .text').text(answer.optionalAnswer);
        } else {
            $(item).find('#no-optional-answer').removeClass('hidden');
        }
    }
}

function renderEditableAlternativeQuestion(item, studyData, answer) {
    var parameters = studyData.parameters;
    renderAlternativeQuestionInput(item, studyData);
    if (parameters.multiselect === 'yes') {
        $(item).find('#multiselect').removeClass('hidden');
    } else {
        $(item).find('#singleselect').removeClass('hidden');
    }

    if (answer) {
        for (var id in answer) {
            if (answer.hasOwnProperty(id) && answer[id].selected === 'yes') {
                var optionButton = $(item).find('#' + id);
                checkOption(optionButton);
                var justificationInput = $(optionButton).closest('.formgroup').find('#justificationInput');
                $(justificationInput).val(answer[id].justification);
            }
        }

        if (answer.optionalAnswer !== '') {
            checkOption($(item).find('#checkbox-optionalanswer .btn-checkbox'));
            checkOption($(item).find('#radio-optionalanswer .btn-radio'));
            $(item).find('.optionalInput').val(answer.optionalAnswer);
        }
    }
}

function renderGUS(item, studyData, answer) {
    var options = translation.gusOptions;
    if (answer) {
        var score = 0;
        if (studyData.parameters.negative === 'yes') {
            $(item).find('#negative').removeClass('hidden');
            score = translation.gusOptions.length - parseInt(answer.selectedOption);
        } else {
            $(item).find('#positive').removeClass('hidden');
            score = parseInt(answer.selectedOption) + 1;
        }

        var selectedOption = parseInt(answer.selectedOption);
        if (selectedOption === -1) {
            $(item).find('#score-container').remove();
            $(item).find('#no-answer').removeClass('hidden');
        } else {
            renderRatingSigns($(item).find('#score-container'), score, options.length);
        }
    } else {
        $(item).find('#score-container').remove();
        $(item).find('#no-answer').removeClass('hidden');
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

function renderSUSItem(item, studyData, answer) {
    var score = 0;
    if (studyData.parameters.negative === 'yes') {
        $(item).find('#negative').removeClass('hidden');
        if (answer) {
            score = translation.susOptions.length - parseInt(answer.selectedOption);
        }
    } else {
        $(item).find('#positive').removeClass('hidden');
        if (answer) {
            score = parseInt(answer.selectedOption) + 1;
        }
    }


    var options = translation.susOptions;
    if (answer) {
        var maxScore = options.length;
        var selectedOption = parseInt(answer.selectedOption);
        if (selectedOption === -1) {
            $(item).find('#score-container').remove();
            $(item).find('#no-answer').removeClass('hidden');
        } else {
            renderRatingSigns($(item).find('#score-container'), score, maxScore);
        }
    } else {
        $(item).find('#no-answer').removeClass('hidden');
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

function renderUEQItem(item, studyData, answer) {
    var score = 0;
//    console.log(answer);

    if (studyData.parameters.negative === 'yes') {
        $(item).find('#negative').removeClass('hidden');
        if (answer) {
            score = 7 - (parseInt(answer.selectedOption) + 1) - 3;
        }
    } else {
        $(item).find('#positive').removeClass('hidden');
        if (answer) {
            score = parseInt(answer.selectedOption) - 3;
        }
    }

//    console.log(score);

    if (answer) {
        var selectedOption = parseInt(answer.selectedOption);
        if (selectedOption === -1) {
            $(item).find('#score-container').remove();
            $(item).find('#no-answer').removeClass('hidden');
        } else {
            renderRatingSigns($(item).find('#score-container'), score, 7, -4);
        }
    } else {
        $(item).find('#no-answer').removeClass('hidden');
    }
}

function renderEditableUEQ(item, studyData, answer) {
    renderUEQInput(item, studyData.parameters);
    if (answer && parseInt(answer.selectedOption) > -1) {
        var btn = $($(item).find('.option-container').children()[parseInt(answer.selectedOption)]).find('.btn');
        $(btn).addClass('btn-option-checked');
        $(btn).find('#normal').addClass('hidden');
        $(btn).find('#checked').removeClass('hidden');
    }
}

function renderRatingSigns(container, score, maxScore, shifting) {
    $(container).find('.score-text').text(score);
    var balance = 0;

    if (!shifting) {
        shifting = 0;
    }

    if (maxScore % 2 === 0) {
        balance = (maxScore / 2) + .5;
        if (score > (balance + .5)) {
            $(container).find('.fa').addClass('fa-thumbs-up');
        } else if (score < (balance - .5)) {
            $(container).find('.fa').addClass('fa-thumbs-down');
        } else if (score >= (balance - .5) && score <= (balance + .5)) {
            $(container).find('.fa').addClass('fa-caret-left');
        }
    } else {
        balance = Math.floor(maxScore / 2) + (maxScore % 2) + shifting;
        if (score > balance) {
            $(container).find('.fa').addClass('fa-thumbs-up');
        } else if (score < balance) {
            $(container).find('.fa').addClass('fa-thumbs-down');
        } else if (score === balance) {
            $(container).find('.fa').addClass('fa-caret-left');
        }
    }
}




/* 
 * form rendering for moderator, tester and participant results view
 */


/*
 * open question 
 */
function renderOpenQuestionInput(item, parameters) {
    if (parameters) {
        if (parameters.justification && parameters.justification === 'yes') {
            var justification = $('#item-container-inputs').find('#justification').clone();
            justification.css({marginTop: '10px'});

            item.find('.panel-body').append(justification);
            setInputChangeEvent(justification.find('#justificationInput'), 1000);
        }
    }
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


/*
 * dichotomous question
 */

function renderDichotomousQuestionInput(item, parameters) {
    if (parameters.justification === 'yes') {
        var justification = $('#item-container-inputs').find('#justification').clone().addClass('hidden');
        justification.css({marginTop: '10px'});

        item.find('.panel-body').append(justification);
        setInputChangeEvent(justification.find('#justificationInput'), 1000);

        if (parameters.justificationFor === 'always') {
            justification.removeClass('hidden');
        } else {
            $(item).find('.switch').bind('change', function () {
                var activeButton = $(this).find('.btn-option-checked');
                if (parameters.justificationFor === activeButton.attr('id')) {
                    $(item).find('#justification').removeClass('hidden');
                } else {
                    $(item).find('#justification').addClass('hidden');
                }
            });
        }
    }
}

function renderDichotomousQuestionGUSInput(item, parameters) {
    if (parameters.justification === 'yes') {
        var justification = $('#item-container-inputs').find('#justification').clone().addClass('hidden');
        justification.css({marginTop: '10px'});
        item.find('.panel-body').append(justification);
        setInputChangeEvent(justification.find('#justificationInput'), 1000);

        if (parameters.justificationFor === 'always') {
            justification.removeClass('hidden');
        } else {
            $(item).find('.switch').bind('change', function () {
                var activeButton = $(this).find('.btn-option-checked');
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

function renderGroupingQuestionInput(item, parameters, options) {
//    console.log(item, parameters, options);
    var optionType = parameters.multiselect === 'yes' ? 'checkbox' : 'radio';
    for (var i = 0; i < options.length; i++) {
        var formGroup = document.createElement('div');
        $(formGroup).attr('data-justification', options[i].justification);
        $(formGroup).attr('data-justification-for', options[i].justificationFor);
        $(formGroup).addClass('formgroup');

        var option = $('#item-container-inputs').find('#' + optionType).clone();
        option.find('.option-text').text(options[i].title);
        option.find('.btn-' + optionType).attr('id', options[i].id);
        $(formGroup).append(option);
        $(item).find('.option-container').append(formGroup);


        if (options[i].justification === 'yes') {
            var justification = $('#item-container-inputs').find('#justification').clone().addClass('hidden');
            $(justification).css({marginTop: '5px'});
            $(formGroup).append(justification);
            setInputChangeEvent(justification.find('#justificationInput'), 1000);

            if (options[i].justificationFor === 'always' || options[i].justificationFor === 'selectNothing') {
                justification.removeClass('hidden');
            }
        }

        if (options.length > 1 && i < options.length - 1 && options[i].justification === 'yes') {
            $(item).find('.option-container').append(document.createElement('hr'));
        }
    }

    if (parameters.optionalanswer === 'yes') {
        if (options.length > 0) {
            $(item).find('.option-container').append(document.createElement('hr'));
        }
        var option = $('#item-container-inputs').find('#' + optionType + '-optionalanswer').clone();
        $(item).find('.option-container').append(option);
        setInputChangeEvent(option.find('.optionalInput'), 1000);
    }

    $(item).find('.option-container').unbind('change').bind('change', function (event) {
        var formGroups = $(this).closest('.root').find('.formgroup');
        for (var j = 0; j < formGroups.length; j++) {
            var element = $(formGroups[j]);
            if ($(element).attr('data-justification') === 'yes' && $(element).attr('data-justification-for') === 'selectOne' && $(element).find('.btn-' + optionType).hasClass('btn-option-checked')) {
//                console.log('show justification for select one', element);
                $(element).find('#justification').removeClass('hidden');
            } else if ($(element).attr('data-justification') === 'yes' && $(element).attr('data-justification-for') === 'selectNothing' && !$(element).find('.btn-' + optionType).hasClass('btn-option-checked')) {
//                console.log('show justification for select nothing', element);
                $(element).find('#justification').removeClass('hidden');
            } else if ($(element).attr('data-justification') === 'yes' && $(element).attr('data-justification-for') === 'always') {
//                console.log('show justification for always', element);
                $(element).find('#justification').removeClass('hidden');
            } else {
//                console.log('hide justification', element);
                $(element).find('#justification').addClass('hidden');
            }
        }
    });
}


/*
 * grouping question GUS
 */

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

    if (parameters.options) {
        options = parameters.options;
    }

    if (options && options.length > 0) {
        for (var i = 0; i < options.length; i++) {
            var formGroup = document.createElement('div');
            $(formGroup).addClass('formgroup');
            $(formGroup).attr('data-justification', parameters.justification);
            $(formGroup).attr('data-justification-for', parameters.justificationFor);

            var option = $('#item-container-inputs').find('#' + optionType).clone();
            option.find('.btn-' + optionType).attr('id', options[i].id);
            $(formGroup).append(option);
            $(item).find('.option-container').append(formGroup);

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

            if (parameters.justification === 'yes') {
                var justification = $('#item-container-inputs').find('#justification').clone().addClass('hidden');
                $(justification).css({marginTop: '5px'});
                $(formGroup).append(justification);
                setInputChangeEvent(justification.find('#justificationInput'), 1000);

                if (parameters.justificationFor === 'always') {
                    justification.removeClass('hidden');
                } else {
                    if (parameters.justificationFor === 'selectNothing') {
                        justification.removeClass('hidden');
                    }
                }
            }

            if (options.length > 1 && i < options.length - 1 && parameters.justification === 'yes') {
                $(item).find('.option-container').append(document.createElement('hr'));
            }
        }
    }

    if (parameters.optionalanswer === 'yes') {
        if (options.length > 0) {
            $(item).find('.option-container').append(document.createElement('hr'));
        }
        var option = $('#item-container-inputs').find('#' + optionType + '-optionalanswer').clone();
        $(item).find('.option-container').append(option);
        setInputChangeEvent(option.find('.optionalInput'), 1000);
    }

    $(item).find('.option-container').unbind('change').bind('change', function (event) {
        var formGroups = $(this).closest('.root').find('.formgroup');
        for (var j = 0; j < formGroups.length; j++) {
            var element = $(formGroups[j]);
            if ($(element).attr('data-justification') === 'yes' && $(element).attr('data-justification-for') === 'selectOne' && $(element).find('.btn-' + optionType).hasClass('btn-option-checked')) {
//                console.log('show justification for select one', element);
                $(element).find('#justification').removeClass('hidden');
            } else if ($(element).attr('data-justification') === 'yes' && $(element).attr('data-justification-for') === 'selectNothing' && !$(element).find('.btn-' + optionType).hasClass('btn-option-checked')) {
//                console.log('show justification for select nothing', element);
                $(element).find('#justification').removeClass('hidden');
            } else if ($(element).attr('data-justification') === 'yes' && $(element).attr('data-justification-for') === 'always') {
//                console.log('show justification for always', element);
                $(element).find('#justification').removeClass('hidden');
            } else {
//                console.log('hide justification', element);
                $(element).find('#justification').addClass('hidden');
            }
        }
    });
}


/*
 * rating
 */

function renderRatingInput(item, options) {
    for (var j = 0; j < options.length; j++) {
        var optionItem = $('#item-container-inputs').find('#radio').clone(false);
        $(optionItem).attr('id', options[j].id)
        optionItem.find('.option-text').text(options[j].title);
        item.find('.option-container').append(optionItem);
        item.find('.option-container').append(document.createElement('br'));
    }
}



/*
 * matrix
 */

function renderMatrixInput(item, options) {
    for (var j = 0; j < options.length; j++) {
        var ratingItem = $('#item-container-inputs').find('#rating-item').clone().removeAttr('id');
        ratingItem.find('#rating-header').text(options[j].option);
        for (var k = 0; k < options[j].scales.length; k++) {
            var optionItem = $('#item-container-inputs').find('#radio').clone(false);
            $(optionItem).attr('id', options[j].scales[k].id);
            optionItem.find('.option-text').text(options[j].scales[k].title);
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

function renderSumQuestionInput(item, parameters, options) {
    for (var i = 0; i < options.length; i++) {
        var maxSum = parseInt(parameters.maximum);
        var sumQuestionItem = $('#item-container-inputs').find('#sumQuestion-item').clone().removeAttr('id');
        $(sumQuestionItem).attr('id', options[i].id);
        sumQuestionItem.find('.option-text').html(options[i].title);
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
 * ueq
 */

function renderUEQInput(item, parameters) {
    if (parameters) {
        $(item).find('.opposite-left').text(translation.ueqOpposites[parameters.opposites.left]);
        $(item).find('.opposite-right').text(translation.ueqOpposites[parameters.opposites.right]);
        for (var i = 0; i < 7; i++) {
            var radioButton = $('#item-container-inputs').find('#radio').clone();
//            radioButton.find('.option-text').html(options[i]);
            $(radioButton).css({marginTop: 0, marginRight: '1px'});
            $(radioButton).find('.btn').css({height: '26px', paddingLeft: '7px', paddingRight: '7px'});
            $(radioButton).find('.option-text').remove();
            $(radioButton).find('#icons').css({marginRight: 0, fontSize: '11pt'});
            item.find('.option-container').append(radioButton);
//            var rankingItem = $('#item-container-inputs').find('#ueq-item').clone().removeAttr('id');
//            rankingItem.find('.option-text').html(options[i].text);
//            rankingItem.attr('id', options[i].id);
//            item.find('.scales-container').append(rankingItem);
        }
    }
}


/*
 * alternative question
 */

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
                var formGroup = document.createElement('div');
                $(formGroup).addClass('formgroup');

                var option = $('#item-container-inputs').find('#checkbox').clone();
                option.find('.btn-checkbox').attr('id', options[i].id);
                option.find('.option-text').html(options[i].title);
                $(formGroup).append(option);
                $(item).find('.option-container').append(formGroup);

                if (parameters.alternative === 'gestures') {
                    var button = $('#item-container-inputs').find('#btn-show-gesture').clone().removeClass('hidden').removeAttr('id');
                    button.attr('name', options[i].id);
                    option.append(button);
                }

                if (parameters.justification === 'yes') {
                    var justification = $('#item-container-inputs').find('#justification').clone().addClass('hidden');
                    $(justification).css({marginTop: '5px'});
                    $(formGroup).append(justification);
                    setInputChangeEvent(justification.find('#justificationInput'), 1000);

                    if (parameters.justificationFor === 'always') {
                        justification.removeClass('hidden');
                    } else {
                        if (parameters.justificationFor === 'selectNothing') {
                            justification.removeClass('hidden');
                        }

                        $(option).bind('change', {options: parameters}, function (event) {
                            if (event.data.options.justificationFor === 'selectOne' && $(this).find('.btn-checkbox').hasClass('btn-option-checked')) {
                                $(this).closest('.formgroup').find('#justification').removeClass('hidden');
                            } else if (event.data.options.justificationFor === 'selectNothing' && !$(this).find('.btn-checkbox').hasClass('btn-option-checked')) {
                                $(this).closest('.formgroup').find('#justification').removeClass('hidden');
                            } else {
                                $(this).closest('.formgroup').find('#justification').addClass('hidden');
                            }
                        });
                    }
                }

                if (options.length > 1 && i < options.length - 1 && parameters.justification === 'yes') {
                    $(item).find('.option-container').append(document.createElement('hr'));
                }
            }
        }
    }

    if (parameters.optionalanswer === 'yes') {
        if (options.length > 0) {
            $(item).find('.option-container').append(document.createElement('hr'));
        }

        var optionalAnswer = $('#item-container-inputs').find('#checkbox-optionalanswer').clone();
        item.find('.option-container').append(optionalAnswer);
    }
}

/*
 * gus & sus
 */

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

var changeTriggerTimer = null;
function setInputChangeEvent(target, milliseconds) {
    $(target).keypress(function (event) {
        clearTimeout(changeTriggerTimer);
        changeTriggerTimer = setTimeout(function () {
            clearTimeout(changeTriggerTimer);
            $(target).trigger('change');
        }, milliseconds || 100);
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
            $(listItem).find('.question').text(studyData[i].question);
            $(listItem).attr('name', studyData[i].id);
            $(target).append(listItem);

            if (studyData[i].dimension !== DIMENSION_ANY) {
                $(listItem).find('#item-factors').removeClass('hidden');
                $(listItem).find('#factor-primary').text(translation.dimensions[studyData[i].dimension].title);
//                $(listItem).find('#factor-main').text(translation.mainDimensions[getMainDimensionForDimension(studyData[i].dimension)]);
            }

            for (var j = 0; j < resultData.length; j++) {
                if (parseInt(studyData[i].id) === parseInt(resultData[j].id)) {
                    var answer = getAnswerForId(studyData[i].id, resultData);
//                    console.log(studyData[i].format, answer);

                    switch (studyData[i].format) {
                        case COUNTER:
                            renderEditableCounter(listItem, studyData[i], answer);
                            break;
                        case OPEN_QUESTION:
                        case OPEN_QUESTION_GUS:
                            renderEditableOpenQuestion(listItem, answer);
                            break;
                        case DICHOTOMOUS_QUESTION:
                        case DICHOTOMOUS_QUESTION_GUS:
                            renderEditableDichotomousQuestion(listItem, studyData[i], answer);
                            break;
                        case GROUPING_QUESTION:
                            renderEditableGroupingQuestion(listItem, studyData[i], answer);
                            break;
                        case GROUPING_QUESTION_GUS:
                        case GROUPING_QUESTION_OPTIONS:
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

                    break;
                }
            }
        }
    }
}

function saveObservationAnwers(target, studyId, testerId, currentPhaseId) {
    var observationAnswerItems = $(target).children();
    var answers = getQuestionnaireAnswers(observationAnswerItems);
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

function initializeItemType(clone) {
    var itemType = $(clone).attr('id');
    switch (itemType) {
        case MATRIX:
            $(clone).find('.btn-add-ratingOption').click();
            break;
        case GROUPING_QUESTION:
            $(clone).find('.btn-add-groupingQuestionOption').click();
            $(clone).find('.btn-add-groupingQuestionOption').click();
            break;
        case SUM_QUESTION:
            $(clone).find('.btn-add-sumQuestionOption').click();
            $(clone).find('.btn-add-sumQuestionOption').click();
            break;
        case RATING:
            $(clone).find('#scale_3').click();
            break;
        case RANKING:
            $(clone).find('.btn-add-rankingOption').click();
            $(clone).find('.btn-add-rankingOption').click();
            break;
    }
}

$(document).on('click', '.btn-add-groupingQuestionOption', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var item = $('#form-item-container').find('#groupingQuestionItem').clone().removeAttr('id');
        item.attr('id', chance.natural());
        $(this).prev().find('.option-container').append(item);
        initJustificationFormElements(item, null);
        checkCurrentListState($(this).prev().find('.option-container'));
        TweenMax.from(item, .2, {y: -10, opacity: 0});
    }
});

$(document).on('click', '.btn-add-ratingOption', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var item = $('#form-item-container').find('#ratingItem').clone().removeAttr('id');
        $(item).attr('data-id', chance.natural());
        var container = $(this).prev().find('.option-container');
        $(container).append(item);
        checkCurrentListState($(this).prev().find('.option-container'));
        $(item).find('.chosen').attr('id', 3);
        $(item).find('.show-dropdown').val(3);
        $(item).find('#scale_3').addClass('selected');
        renderScaleItems($(item).find('.ratingScaleItemContainer'), 3, translation.threeDefaultScales);
        TweenMax.from(item, .2, {y: -10, opacity: 0});
        checkFilterOptions(container.closest('.container-root'));
    }
});

$(document).on('click', '.btn-add-sumQuestionOption', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var item = $('#form-item-container').find('#sumQuestionItem').clone().removeAttr('id');
        $(item).attr('data-id', chance.natural());
        $(this).prev().find('.option-container').append(item);
        checkCurrentListState($(this).prev().find('.option-container'));
        TweenMax.from(item, .2, {y: -10, opacity: 0});
    }
});

$(document).on('click', '.btn-add-rankingOption', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var item = $('#form-item-container').find('#rankingItem').clone().removeAttr('id');
        $(item).attr('id', chance.natural());
        $(this).prev().find('.option-container').append(item);
        checkCurrentListState($(this).prev().find('.option-container'));
        TweenMax.from(item, .2, {y: -10, opacity: 0});
    }
});

$(document).on('click', '.btn-add-filter-option', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;

        var root = $(this).closest('.root');
        var dataRoot = $(this).closest('.root');
        if ($(this).attr('data-root-lookups') !== undefined) {
            var rootLookups = parseInt($(this).attr('data-root-lookups'));
            dataRoot = $(dataRoot).parents().eq(rootLookups);
        }

        var formatData = getFormatData(dataRoot);
        addFilterOption(dataRoot, root, formatData);
    }
});


function addFilterOption(root, target, formatData, selectData) {
//    console.log('add filter option', formatData.format);

    var item = $('#form-item-container').find('#filter-option-item').clone().removeAttr('id');
    if (formatData.format === RANKING) {
        item = $('#form-item-container').find('#ranking-filter-option-item').clone().removeAttr('id');
    } else if (formatData.format === SUM_QUESTION) {
        item = $('#form-item-container').find('#sum-filter-option-item').clone().removeAttr('id');
    } else if (formatData.format === COUNTER) {
        item = $('#form-item-container').find('#counter-filter-option-item').clone().removeAttr('id');
    }

    item.attr('id', selectData && selectData.id ? selectData.id : chance.natural());
    $(target).find('.filter-options-container').append(item);
    TweenMax.from(item, .2, {y: -10, opacity: 0, clearProps: 'all'});

    updateAvailableFilterOptions(formatData, root, target, item, selectData);
    checkCurrentListState($(target).find('.filter-options-container'));
}

function getAvailableFilterOptions(data, item, target) {
    var availableFilterOptions = [];

    switch (data.format) {
        case DICHOTOMOUS_QUESTION:
            availableFilterOptions.push({id: 'yes', title: translation.yes});
            availableFilterOptions.push({id: 'no', title: translation.no});
            break;
        case GROUPING_QUESTION:
            for (var i = 0; i < data.options.length; i++) {
                availableFilterOptions.push({id: data.options[i].id, title: data.options[i].title});
            }
            availableFilterOptions.push({id: 'optionalAnswer', title: translation.optionalAnswer});
            break;
        case RATING:
        case SUM_QUESTION:
            for (var i = 0; i < data.options.length; i++) {
                availableFilterOptions.push({id: data.options[i].id, title: data.options[i].title});
            }
            break;
        case GROUPING_QUESTION_OPTIONS:
//            console.log(data);
            if (data.parameters && data.parameters.optionSource && data.parameters.optionSource !== undefined) {
                var optionSource = data.parameters.optionSource;
                var options = null;
                switch (optionSource) {
                    case 'feedbacks':
                        options = getLocalItem(ASSEMBLED_FEEDBACK);
                        break;
                    case 'triggers':
                        options = getLocalItem(ASSEMBLED_TRIGGER);
                        break;
                    case 'gestures':
                        options = getLocalItem(ASSEMBLED_GESTURE_SET);
                        break;
                }

                if (options && options.length > 0) {
                    for (var i = 0; i < options.length; i++) {
                        if (optionSource === 'feedbacks' || optionSource === 'triggers') {
                            availableFilterOptions.push({id: options[i].id, title: options[i].title});
                        } else if (optionSource === 'gestures') {

                        }
                    }
                }
            }

            availableFilterOptions.push({id: 'optionalAnswer', title: translation.optionalAnswer});
            break;
        case MATRIX:
            if (data.options && data.options.length > 0) {
                var martixId = parseInt($(target).attr('data-id'));
                for (var i = 0; i < data.options.length; i++) {
                    if (parseInt(data.options[i].id) === martixId) {
                        var scales = data.options[i].scales;
                        for (var j = 0; j < scales.length; j++) {
                            availableFilterOptions.push({id: scales[j].id, title: scales[j].title});
                        }

                        break;
                    }
                }
            }
            break;
        case RANKING:
            for (var i = 0; i < data.options.length; i++) {
                availableFilterOptions.push({id: data.options[i].id, title: data.options[i].text});
            }
            renderRankingPosition($(item).find('.filterPositionSelect'), data.options.length);
            break;
    }

    availableFilterOptions.push({id: 'noMatterAnswer', title: translation.alwaysJumpTo});
    return availableFilterOptions;
}

function updateAvailableFilterOptions(data, root, target, item, selectData) {
    renderAtAnswerFilterOptions($(item).find('.filterAtAnswerSelect'), getAvailableFilterOptions(data, item, target));
    updateJumpToAnswerOptions($(root), item.find('.filterJumpSelect'));
//    console.log($(item), $(item).find('.filterAtAnswerSelect'), data.format, selectData);

    if (selectData) {
        switch (data.format) {
            case OPEN_QUESTION:
            case DICHOTOMOUS_QUESTION:
            case GROUPING_QUESTION:
            case GROUPING_QUESTION_OPTIONS:
            case RATING:
            case MATRIX:
                $(item).find('.filterAtAnswerSelect .option-at-answer').val($(item).find('.filterAtAnswerSelect #' + selectData.filterAtAnswer + ' a').text());
                $(item).find('.filterAtAnswerSelect .chosen').attr('id', selectData.filterAtAnswer);
                $(item).find('.filterAtAnswerSelect #' + selectData.filterAtAnswer).addClass('selected');

                $(item).find('.filterJumpSelect .option-jump-to').val($(item).find('.filterJumpSelect #' + selectData.filterJump + ' a').text());
                $(item).find('.filterJumpSelect .chosen').attr('id', selectData.filterJump);
                $(item).find('.filterJumpSelect #' + selectData.filterJump).addClass('selected');
                break;
            case RANKING:
                $(item).find('.filterAtAnswerSelect .option-at-answer').val($(item).find('.filterAtAnswerSelect #' + selectData.filterAtAnswer + ' a').text());
                $(item).find('.filterAtAnswerSelect .chosen').attr('id', selectData.filterAtAnswer);
                $(item).find('.filterAtAnswerSelect #' + selectData.filterAtAnswer).addClass('selected');

                $(item).find('.filterJumpSelect .option-jump-to').val($(item).find('.filterJumpSelect #' + selectData.filterJump + ' a').text());
                $(item).find('.filterJumpSelect .chosen').attr('id', selectData.filterJump);
                $(item).find('.filterJumpSelect #' + selectData.filterJump).addClass('selected');

                $(item).find('.filterPositionSelect .option-position').val($(item).find('.filterPositionSelect #' + selectData.filterAtPosition + ' a').text());
                $(item).find('.filterPositionSelect .chosen').attr('id', selectData.filterAtPosition);
                $(item).find('.filterPositionSelect #' + selectData.filterAtPosition).addClass('selected');
                break;
            case SUM_QUESTION:
                $(item).find('.filterAtAnswerSelect .option-at-answer').val($(item).find('.filterAtAnswerSelect #' + selectData.filterAtAnswer + ' a').text());
                $(item).find('.filterAtAnswerSelect .chosen').attr('id', selectData.filterAtAnswer);
                $(item).find('.filterAtAnswerSelect #' + selectData.filterAtAnswer).addClass('selected');

                $(item).find('.filterJumpSelect .option-jump-to').val($(item).find('.filterJumpSelect #' + selectData.filterJump + ' a').text());
                $(item).find('.filterJumpSelect .chosen').attr('id', selectData.filterJump);
                $(item).find('.filterJumpSelect #' + selectData.filterJump).addClass('selected');

                $(item).find('.operatorSelect .option-position').val($(item).find('.operatorSelect #' + selectData.operator + ' a').text());
                $(item).find('.operatorSelect .chosen').attr('id', selectData.operator);
                $(item).find('.operatorSelect #' + selectData.operator).addClass('selected');

                $(item).find('#counter-number .stepper-text').val(selectData.value);
                break;
            case COUNTER:
                $(item).find('.filterJumpSelect .option-jump-to').val($(item).find('.filterJumpSelect #' + selectData.filterJump + ' a').text());
                $(item).find('.filterJumpSelect .chosen').attr('id', selectData.filterJump);
                $(item).find('.filterJumpSelect #' + selectData.filterJump).addClass('selected');

                $(item).find('.operatorSelect .option-position').val($(item).find('.operatorSelect #' + selectData.operator + ' a').text());
                $(item).find('.operatorSelect .chosen').attr('id', selectData.operator);
                $(item).find('.operatorSelect #' + selectData.operator).addClass('selected');

                $(item).find('#counter-number .stepper-text').val(selectData.value);
                break;
        }
    }
}

function getQuestionById(questionnaire, id) {
    if (questionnaire && questionnaire.length > 0) {
        for (var i = 0; i < questionnaire.length; i++) {
            if (parseInt(questionnaire[i].id) === parseInt(id)) {
                return questionnaire[i];
            }
        }
    }
    return null;
}

function renderFilterOptionsData(format, target, filters) {
    var status = window.location.hash.substr(1);
    var statusAddressMatch = statusAddressMatchIndex(status);
//    console.log('statusAddressMatch', statusAddressMatch);
    if (statusAddressMatch !== null && statusAddressMatch.index) {
        currentPhaseStepIndex = statusAddressMatch.index;
        console.log(currentPhaseData);
    }

    var currentPhaseData = getCurrentPhaseData();

    console.log('render filter data:', format, filters);

    if (filters && filters.optionFilters && filters.optionFilters.length > 0) {
        var filterOptionDataContent = '';

        for (var i = 0; i < filters.optionFilters.length; i++) {
            var jumpQuestionIndex = 'nextStep';
            if (filters.optionFilters[i].filterJump !== 'nextStep') {
                jumpQuestionIndex = getQuestionIndex(currentPhaseData, filters.optionFilters[i].filterJump) + 1;
            }

//            if (filterOptions[i].filterAtAnswer === 'noMatterAnswer') {
//                console.log('push no-matter-answer filter', format);
//                noMatterFilterOptions.push(filterOptions[i]);
//            } else {
            switch (format) {
                case SUM_QUESTION:
                    filterOptionDataContent += '<div>' + (i === 0 ? translation.Is : translation.is) + ' ' + translation.operators[filters.optionFilters[i].operator].symbol + ' ' + filters.optionFilters[i].value + ': ' + translation.goto + ' ' + translation.question + ' ' + jumpQuestionIndex + (i < filters.optionFilters.length - 1 ? ', ' + translation.or : '') + '</div>';
                    break;
                case COUNTER:
                    filterOptionDataContent += '<div>' + (i === 0 ? translation.Is : translation.is) + ' ' + translation.operators[filters.optionFilters[i].operator].symbol + ' ' + filters.optionFilters[i].value + ': ' + translation.goto + ' ' + translation.question + ' ' + jumpQuestionIndex + (i < filters.optionFilters.length - 1 ? ', ' + translation.or : '') + '</div>';
                    break;
                case DICHOTOMOUS_QUESTION:
                    filterOptionDataContent += '<div>' + translation.ForSelection + ': ' + translation.goto + ' ' + translation.question + ' ' + jumpQuestionIndex + (i < filters.optionFilters.length - 1 ? ', ' + translation.and : '') + '</div>';
                    break;
                case GROUPING_QUESTION:
                case GROUPING_QUESTION_OPTIONS:
//                    var optionItems = $(target).find('.option-container [data-id]');
//                    console.log('option items', optionItems);
                    filterOptionDataContent += '<div>' + translation.ForSelection + ': ' + translation.goto + ' ' + translation.question + ' ' + jumpQuestionIndex + (i < filters.optionFilters.length - 1 ? ', ' + translation.and : '') + '</div>';
                    break;
                case RATING:
                    filterOptionDataContent += '<div>' + (i === 0 ? translation.ForSelection : '') + ': ' + translation.goto + ' ' + translation.question + ' ' + jumpQuestionIndex + (i < filters.optionFilters.length - 1 ? ', ' + translation.and : '') + '</div>';
                    break;
                case RANKING:
                    filterOptionDataContent += '<div>' + (i === 0 ? translation.AtPositionSelect : translation.atPositionSelect) + ' ' + filters.optionFilters[i].filterAtPosition + ': ' + (jumpQuestionIndex === 'nextStep' ? translation.endQuestionnaire : (translation.goto + ' ' + translation.question + ' ' + jumpQuestionIndex)) + (i < filters.optionFilters.length - 1 ? ', ' + translation.or : '') + '</div>';
                    break;
                case MATRIX:
                    filterOptionDataContent += '<div>' + (i === 0 ? translation.ForSelection : '') + ': ' + (jumpQuestionIndex === 'nextStep' ? translation.endQuestionnaire : (translation.goto + ' ' + translation.question + ' ' + jumpQuestionIndex)) + (i < filters.optionFilters.length - 1 ? ', ' + translation.and : '') + '</div>';
                    break;
            }
//            }
        }

        if (filterOptionDataContent !== '') {
            var filterOptionItem = $('#template-study-container').find('#filter-option-item').clone();
            $(target).find('.filter-option').append(filterOptionItem);
            $(filterOptionItem).attr('data-content', filterOptionDataContent);
        }


//        if (noMatterFilterOptions && noMatterFilterOptions.length > 0) {
//            
//        }
    }

    if (filters && filters.noMatterFilters && filters.noMatterFilters.length > 0) {
        var noMatterFilterOptionContent = '';
        var noMatterFilterTarget = $(target).closest('.panel').find('.no-matter-filter-option');

        for (var i = 0; i < filters.noMatterFilters.length; i++) {
            var jumpQuestionIndex = 'nextStep';
            if (filters.noMatterFilters[i].filterJump !== 'nextStep') {
                jumpQuestionIndex = getQuestionIndex(currentPhaseData, filters.noMatterFilters[i].filterJump) + 1;
            }

            switch (format) {
                case OPEN_QUESTION:
                    noMatterFilterTarget = $(target).find('.no-matter-filter-option');
                    noMatterFilterOptionContent += '<div>' + translation.NoMatterAnswer + ': ' + (jumpQuestionIndex === 'nextStep' ? translation.endQuestionnaire : (translation.goto + ' ' + translation.question + ' ' + jumpQuestionIndex)) + (i < filters.noMatterFilters.length - 1 ? ', ' + translation.and : '') + '</div>';
                    break;
                case SUM_QUESTION:
                    noMatterFilterOptionContent += '<div>' + translation.NoMatterAnswer + ' ' + translation.operators[filters.noMatterFilters[i].operator].symbol + ' ' + filters.noMatterFilters[i].value + ': ' + (jumpQuestionIndex === 'nextStep' ? translation.endQuestionnaire : (translation.goto + ' ' + translation.question + ' ' + jumpQuestionIndex)) + (i < filters.noMatterFilters.length - 1 ? ', ' + translation.and : '') + '</div>';
                    break;
                case MATRIX:
                    noMatterFilterTarget = $(target).closest('#matrix-item').find('.no-matter-filter-option');
                    noMatterFilterOptionContent += '<div>' + translation.NoMatterAnswer + ': ' + (jumpQuestionIndex === 'nextStep' ? translation.endQuestionnaire : (translation.goto + ' ' + translation.question + ' ' + jumpQuestionIndex)) + (i < filters.noMatterFilters.length - 1 ? ', ' + translation.and : '') + '</div>';
                    break;
                default:
                    noMatterFilterOptionContent += '<div>' + translation.NoMatterAnswer + ': ' + (jumpQuestionIndex === 'nextStep' ? translation.endQuestionnaire : (translation.goto + ' ' + translation.question + ' ' + jumpQuestionIndex)) + (i < filters.noMatterFilters.length - 1 ? ', ' + translation.and : '') + '</div>';
                    break;
            }
        }
        console.log('there are no matter filters:', format, filters.noMatterFilters, target, noMatterFilterTarget);


//            console.log('no matter filter option content', format, noMatterFilterOptionContent);
//                noMatterFilterOptionContent += 

        $(noMatterFilterTarget).removeClass('hidden');
        $(noMatterFilterTarget).attr('data-content', noMatterFilterOptionContent);
    }
}