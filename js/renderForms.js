/* 
 * form rendering for moderator and tester view
 */

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
        optionItem.text(options[j]);
        item.find('.option-container').append(optionItem);
    }
}

function renderGroupingQuestionInput(item, parameters, options) {
    var optionType = parameters.multiselect === 'yes' ? 'checkbox' : 'radio';

    for (var i = 0; i < options.length; i++) {
        var option = $('#item-container-inputs').find('#' + optionType).clone();
        option.find('.option-text').text(options[i]);
        $(item).find('.option-container').append(option);
        $(item).find('.option-container').append(document.createElement('br'));
    }

    if (parameters.optionalanswer === 'yes') {
        var option = $('#item-container-inputs').find('#' + optionType + '-optionalanswer').clone();
        $(item).find('.option-container').append(option);
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
        percent.text(translation.scales[parameters.allocation]);
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
        optionItem.text(options[i]);
        item.find('.option-container').append(optionItem);
    }
}

function renderRankingInput(item, options) {
    if (options) {
        for (var i = 0; i < options.length; i++) {
            var rankingItem = $('#item-container-inputs').find('#ranking-item').clone().removeAttr('id');
            rankingItem.find('.option-text').html(options[i]);
            rankingItem.attr('id', i);
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