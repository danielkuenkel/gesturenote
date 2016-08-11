/* 
 * form rendering for moderator and tester view
 */


/*
 * dichotomous question
 */
function renderDichotomousQuestionPreview(item, parameters) {
    var showJustification = parameters[0];
    var showJustificationConstraint = parameters[1];

    if (showJustification === true) {
        item.find('#justification').removeClass('hidden');
        item.find('#' + showJustificationConstraint).removeClass('hidden');
    } else {
        item.find('#no-justification').removeClass('hidden');
    }
}

function renderDichotomousQuestionInput(item, parameters) {
    var showJustification = parameters[0];
    var showJustificationConstraint = parameters[1];

    if (showJustification === true) {
        var justification = $('#item-container-inputs').find('#justification').clone().addClass('hidden');
        item.find('.panel-body').append(justification);

        if (showJustificationConstraint === 'always') {
            justification.removeClass('hidden');
        } else {
            $(item).find('.switch').bind('change', function () {
                var activeButton = $(this).find('.active');
                if (showJustificationConstraint === activeButton.attr('id')) {
                    $(item).find('#justification').removeClass('hidden');
                } else {
                    $(item).find('#justification').addClass('hidden');
                }
            });
        }
    }
}

function renderDichotomousQuestionGUSPreview(item, parameters) {
    var showJustification = parameters[2];
    var showJustificationConstraint = parameters[3];

    if (showJustification === true) {
        item.find('#justification').removeClass('hidden');
        item.find('#' + showJustificationConstraint).removeClass('hidden');
    } else {
        item.find('#no-justification').removeClass('hidden');
    }
}

function renderDichotomousQuestionGUSInput(item, parameters) {
    var showJustification = parameters[2];
    var showJustificationConstraint = parameters[3];

    if (showJustification === true) {
        var justification = $('#item-container-inputs').find('#justification').clone().addClass('hidden');
        item.find('.panel-body').append(justification);

        if (showJustificationConstraint === 'always') {
            justification.removeClass('hidden');
        } else {
            $(item).find('.switch').bind('change', function () {
                var activeButton = $(this).find('.active');
                if (showJustificationConstraint === activeButton.attr('id')) {
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
    if (parameters[0] === true) {
        item.find('#multiselect').removeClass('hidden');
    } else {
        item.find('#singleselect').removeClass('hidden');
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

function renderGroupingQuestionInput(item, parameters, options) {
    var optionType = parameters[0] === true ? 'checkbox' : 'radio';

    for (var i = 0; i < options.length; i++) {
        var option = $('#item-container-inputs').find('#' + optionType).clone();
        option.find('.option-text').text(options[i]);
        $(item).find('.option-container').append(option);
        $(item).find('.option-container').append(document.createElement('br'));
    }

    if (parameters[1] === true) {
        var option = $('#item-container-inputs').find('#' + optionType + '-optionalanswer').clone();
        $(item).find('.option-container').append(option);
    }
}

/*
 * grouping question GUS
 */
function renderGroupingQuestionGUSPreview(source, item, parameters) {
    var options;
    switch (parameters[4]) {
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

    if (parameters[1] === true) {
        item.find('#multiselect').removeClass('hidden');
    } else {
        item.find('#singleselect').removeClass('hidden');
    }

    if (parameters[2] === true) {
        item.find('#justification').removeClass('hidden');
        item.find('#' + parameters[3]).removeClass('hidden');
    } else {
        item.find('#no-justification').removeClass('hidden');
    }

    if (options && options.length > 0) {
        for (var i = 0; i < options.length; i++) {
            var optionItem = $(source).find('#option-item').clone(false).removeAttr('id');
            item.find('.option-container').append(optionItem);

            if (parameters[4] === 'triggers') {
                var trigger = getTriggerById(options[i].id);
                optionItem.text(trigger.title);
            }

            if (parameters[4] === 'gestures') {
                var gesture = getGestureById(options[i].id);
                optionItem.text(gesture.title);
            }
        }
    }
}

function renderGroupingQuestionGUSInput(item, parameters) {
    var optionType = parameters[1] === true ? 'checkbox' : 'radio';
    var options;
    switch (parameters[4]) {
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
            var option = $('#item-container-inputs').find('#' + optionType).clone().removeClass('hidden');
            $(item).find('.option-container').append(option);

            var optionItem = null;
            switch (parameters[4]) {
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
            $(item).find('.option-container').append(document.createElement('br'));
        }
    }

    var showJustification = parameters[2];
    var showJustificationConstraint = parameters[3];

    if (showJustification === true) {
        var justification = $('#item-container-inputs').find('#justification').clone().addClass('hidden');
        item.find('.option-container').append(justification);

        if (showJustificationConstraint === 'always') {
            justification.removeClass('hidden');
        } else {
            if (showJustificationConstraint === 'selectNothing') {
                justification.removeClass('hidden');
            }

            $(item).find('.option-container').bind('change', function () {
                var totalCheckboxButtons = $(this).find('.btn-' + optionType);
                var activeCheckboxButtons = $(totalCheckboxButtons).filter('.btn-option-checked');
                if (showJustificationConstraint === 'selectOne' && activeCheckboxButtons.length > 0) {
                    $(item).find('#justification').removeClass('hidden');
                } else if (showJustificationConstraint === 'selectNothing' && activeCheckboxButtons.length === 0) {
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

function renderRatingInput(item, options) {
    for (var j = 0; j < options.length; j++) {
        var ratingItem = $('#item-container-inputs').find('#rating-item').clone().removeAttr('id');
        ratingItem.find('#rating-header').text(options[j][options[j].length - 2]);
        for (var k = 0; k < options[j].length - 2; k++) {
            var optionItem = $('#item-container-inputs').find('#radio').clone(false);
            optionItem.find('.option-text').text(options[j][k]);
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


    for (var i = 0; i < options.length; i++) {
        var optionItem = $(source).find('#option-item').clone(false).removeAttr('id');
        optionItem.text(options[i]);
        item.find('.option-container').append(optionItem);
    }
}

function renderSumQuestionInput(item, parameters, options) {
    for (var i = 0; i < options.length; i++) {
        var maxSum = parameters[1];
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
    for (var j = 0; j < options.length; j++) {
        var optionItem = $(source).find('#option-item').clone(false).removeAttr('id');
        optionItem.text(options[j]);
        item.find('.option-container').append(optionItem);
    }
}

function renderRankingInput(item, options) {
    if (options) {
        for (var j = 0; j < options.length; j++) {
            var ratingItem = $('#item-container-inputs').find('#ranking-item').clone().removeAttr('id');
            ratingItem.find('.option-text').html(options[j]);
            item.find('.option-container').append(ratingItem);
            checkCurrentListState(item.find('.option-container'));
        }
    }
}

/*
 * alternative question
 */
function renderAlternativeQuestionPreview(item, parameters) {
    if (parameters[3] === true) {
        $(item).find('#optionalanswer').removeClass('hidden');
    }

    if (parameters[1] === true) {
        $(item).find('#justification').removeClass('hidden');
        $(item).find('#' + parameters[2]).removeClass('hidden');
    } else {
        $(item).find('#no-justification').removeClass('hidden');
    }

    if (parameters[4] === 'gestures' && parameters[5] === 'gesture') {
        $(item).find('#gesturesForGesture').removeClass('hidden');
    } else if (parameters[4] === 'gestures' && parameters[5] === 'trigger') {
        $(item).find('#gesturesForTrigger').removeClass('hidden');
    } else if (parameters[4] === 'triggers' && parameters[5] === 'trigger') {
        $(item).find('#triggersForTrigger').removeClass('hidden');
    } else {
        $(item).find('#triggersForGesture').removeClass('hidden');
    }
}

function renderAlternativeQuestionInput(item, data) {
    var parameters = data.parameters;
    var options;
    var optionId = null;
    switch (parameters[4]) {
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
                item.find('.option-container').append(optionButton);
                item.find('.option-container').append(document.createElement('br'));

                if (parameters[4] === 'gestures') {
                    var button = $('#item-container-inputs').find('#btn-show-gesture').clone().removeClass('hidden').removeAttr('id');
                    button.attr('name', options[i].id);
                    optionButton.append(button);
                }
            }
        }
    }

    if (parameters[3] === true) {
        var optionalAnswer = $('#item-container-inputs').find('#checkbox-optionalanswer').clone();
        item.find('.option-container').append(optionalAnswer);
    }

    var showJustification = parameters[1];
    var showJustificationConstraint = parameters[2];

    if (showJustification === true) {
        var justification = $('#item-container-inputs').find('#justification').clone().addClass('hidden');
        item.find('.option-container').append(justification);

        if (showJustificationConstraint === 'always') {
            justification.removeClass('hidden');
        } else {
            if (showJustificationConstraint === 'selectNothing') {
                justification.removeClass('hidden');
            }

            $(item).find('.option-container').bind('change', function () {
                var totalCheckboxButtons = $(this).find('.btn-checkbox');
                var activeCheckboxButtons = $(totalCheckboxButtons).filter('.btn-option-checked');
                if (showJustificationConstraint === 'selectOne' && activeCheckboxButtons.length > 0) {
                    $(item).find('#justification').removeClass('hidden');
                } else if (showJustificationConstraint === 'selectNothing' && activeCheckboxButtons.length === 0) {
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
    if (data.parameters[1] === true) {
        $(item).find('#reversed').removeClass('hidden');
    }
    if (data.dimension !== DIMENSION_ANY) {
        $(item).find('#item-factors').removeClass('hidden');
        $(item).find('#factor-primary').text(translation.dimensions[data.dimension]);
        $(item).find('#factor-main').text(translation.mainDimensions[getMainDimensionForDimension(data.dimension)]);
    }
}
function renderGUSSingleInput(item, options) {
    for (var i = 0; i < options.length; i++) {
        var radioButton = $('#item-container-inputs').find('#radio').clone();
        radioButton.find('.option-text').html(options[i]);
        item.find('.option-container').append(radioButton);
        item.find('.option-container').append(document.createElement('br'));
    }
}

var susOptions = ['Stimme gar nicht zu', 'Stimme eher nicht zu', 'Teils-teils', 'Stimme eher zu', 'Stimme voll und ganz zu'];
function renderSusInput(item) {
    for (var i = 0; i < susOptions.length; i++) {
        var radioButton = $('#item-container-inputs').find('#radio').clone();
        radioButton.find('.option-text').html(susOptions[i]);
        item.find('.option-container').append(radioButton);
        item.find('.option-container').append(document.createElement('br'));
    }
}