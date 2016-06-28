/* 
 * form rendering for moderator and tester view
 */


/*
 * dichotomous question
 */
function renderDichotomousQuestionPreview(item, parameters) {
    if (parameters[0] === true) {
        item.find('#select-gestures').removeClass('hidden');
    }
    if (parameters[1] === true) {
        item.find('#justification').removeClass('hidden');
    }
}

function renderDichotomousQuestionInput(item, parameters) {
    if (parameters[1] === true) {
        item.find('#justification').removeClass('hidden');
    }
}

/*
 * grouping question
 */
function renderGroupingQuestionPreview(source, item, parameters, options) {
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

function renderGroupingQuestionInput(item, parameters, options) {
    var optionType = parameters[0] === true ? 'checkbox' : 'radio';
    for (var i = 0; i < options.length; i++) {
        var option = $(item).find('#btn-' + optionType).clone().removeClass('hidden').removeAttr('id');
        option.find('.option-text').text(options[i]);
        $(item).find('.option-container').append(option);
    }

    if (parameters[1] === true) {
        var option = $(item).find('#btn-' + optionType + '-optionalanswer').clone().removeClass('hidden').removeAttr('id');
        $(item).find('.option-container').append(option);
    }
}

/*
 * grouping question GUS
 */
function renderGroupingQuestionGUSPreview(source, item, parameters, options) {
    if (parameters[0] === true) {
        item.find('#multiselect').removeClass('hidden');
    }
    if (parameters[1] === true) {
        item.find('#justification').removeClass('hidden');
    }

    for (var i = 0; i < options.length; i++) {
        var optionItem = $(source).find('#option-item').clone(false).removeAttr('id');
        item.find('.option-container').append(optionItem);

        if (parameters[2] === 'triggers') {
            var trigger = getTriggerById(options[i]);
            optionItem.text(trigger.title);
        }

        if (parameters[2] === 'gestures') {
            var gesture = getGestureById(options[i]);
            optionItem.text(gesture.title);
        }
    }
}

function renderGroupingQuestionGUSInput(item, parameters, options) {
    var optionType = parameters[0] === true ? 'checkbox' : 'radio';
    for (var i = 0; i < options.length; i++) {
        var option = $(item).find('#option-item-' + optionType).clone().removeClass('hidden').removeAttr('id');
        $(item).find('.option-container').append(option);

        if (parameters[2] === 'triggers') {
            var trigger = getTriggerById(options[i]);
            option.find('.option-text').text(trigger.title);
        }

        if (parameters[2] === 'gestures') {
            var gesture = getGestureById(options[i]);
            option.find('.option-text').text(gesture.title);

            var button = $(item).find('#btn-show-gesture').clone().removeClass('hidden').removeAttr('id');
            button.attr('name', gesture.id);
            option.append(button);
        }
    }

    if (parameters[1] === true) {
        var option = $(item).find('#option-item-justification').clone().removeClass('hidden').removeAttr('id');
        $(item).find('.option-container').append(option);
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
            var optionItem = $('#item-container-inputs').find('#rating-scale-item').clone(false).removeAttr('id');
            optionItem.find('.option-text').text(options[j][k]);
            ratingItem.find('#scales-container').append(optionItem);
        }

        item.find('.option-container').append(ratingItem);
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


    for (var j = 0; j < options.length; j++) {
        var optionItem = $(source).find('#option-item').clone(false).removeAttr('id');
        optionItem.text(options[j]);
        item.find('.option-container').append(optionItem);
    }
}

function renderSumQuestionInput(item, parameters, options) {
    for (var j = 0; j < options.length; j++) {
        var sumQuestionItem = $('#item-container-inputs').find('#sumQuestion-item').clone().removeAttr('id');
        sumQuestionItem.find('.option-text').html(options[j]);
        sumQuestionItem.find('.btn-stepper-increase').val(parameters[1]);
        item.find('.option-container').append(sumQuestionItem);

        $(sumQuestionItem).find('.stepper-text').on('change', function (event) {
            event.preventDefault();
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
    for (var j = 0; j < options.length; j++) {
        var ratingItem = $('#item-container-inputs').find('#ranking-item').clone().removeAttr('id');
        ratingItem.find('.option-text').html(options[j]);
        item.find('.option-container').append(ratingItem);
        checkCurrentListState(item.find('.option-container'));
    }
}

/*
 * alternative question
 */
function renderAlternativeQuestionPreview(source, item, parameters) {
    $(item).find('#alternative').removeClass('hidden');
    $(item).find('#alternative').text('Alternative ' + parameters[0]);
    $(item).find('#alternativeFor').removeClass('hidden');
    $(item).find('#alternativeFor').text('für ' + parameters[1]);
    $(item).find('#title').text(parameters[2].title);

    if (parameters[0] === ALTERNATIVE_GESTURES) {
        $(item).find('#gesture-container').removeClass('hidden');
    }
}

function renderAlternativeQuestionInput(item, parameters) {

}