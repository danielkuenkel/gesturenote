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
    } else {
        item.find('#no-justification').removeClass('hidden');
    }
}

function renderDichotomousQuestionInput(item, parameters) {
    if (parameters[1] === true) {
        item.find('.panel-body').append($('#item-container-inputs').find('#justification').clone());
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
        var option = $('#item-container-inputs').find('#' + optionType).clone().removeClass('hidden');
        option.find('.option-text').text(options[i]);
        $(item).find('.option-container').append(option);
        $(item).find('.option-container').append(document.createElement('br'));
    }

    if (parameters[1] === true) {
        var option = $('#item-container-inputs').find('#' + optionType + '-optionalanswer').clone().removeClass('hidden');
        $(item).find('.option-container').append(option);
    }
}

/*
 * grouping question GUS
 */
function renderGroupingQuestionGUSPreview(source, item, parameters, options) {
    if (parameters[0] === true) {
        item.find('#multiselect').removeClass('hidden');
    } else {
        item.find('#singleselect').removeClass('hidden');
    }

    if (parameters[1] === true) {
        item.find('#justification').removeClass('hidden');
    } else {
        item.find('#no-justification').removeClass('hidden');
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
        var option = $('#item-container-inputs').find('#' + optionType).clone().removeClass('hidden');
        $(item).find('.option-container').append(option);

        if (parameters[2] === 'triggers') {
            var trigger = getTriggerById(options[i]);
            option.find('.option-text').text(trigger.title);
        }

        if (parameters[2] === 'gestures') {
            var gesture = getGestureById(options[i]);
            option.find('.option-text').text(gesture.title);

            var button = $('#item-container-inputs').find('#btn-show-gesture').clone().removeClass('hidden').removeAttr('id');
            button.attr('name', gesture.id);
            option.append(button);
        }
        $(item).find('.option-container').append(document.createElement('br'));
    }

    if (parameters[1] === true) {
        var option = $(item).find('#option-item-justification').clone().removeClass('hidden');
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
function renderAlternativeQuestionPreview(item, parameters) {
    if (parameters[1] === true) {
        $(item).find('#optionalanswer').removeClass('hidden');
    }

    if (parameters[0] === true) {
        $(item).find('#justification').removeClass('hidden');
    } else {
        $(item).find('#no-justification').removeClass('hidden');
    }

    if (parameters[2] === 'gestures' && parameters[3] === 'gesture') {
        $(item).find('#gesturesForGesture').removeClass('hidden');
    } else if (parameters[2] === 'gestures' && parameters[3] === 'trigger') {
        $(item).find('#gesturesForTrigger').removeClass('hidden');
    } else if (parameters[2] === 'triggers' && parameters[3] === 'trigger') {
        $(item).find('#triggersForTrigger').removeClass('hidden');
    } else {
        $(item).find('#triggersForGesture').removeClass('hidden');
    }
}

function renderAlternativeQuestionInput(item, data) {
    var parameters = data.parameters;
    var options;
    console.log(parameters)
    if (parameters[2] === 'gestures') {
        options = assembledGestures();
    } else {
        options = getLocalItem(ASSEMBLED_TRIGGER);
    }

    for (var i = 0; i < options.length; i++) {
        if ((singleGUSGesture && singleGUSGesture.id !== options[i].id) || (parameters[4] && parameters[4].id !== options[i].id)) {
            var optionButton = $('#item-container-inputs').find('#checkbox').clone();
            optionButton.find('.option-text').html(options[i].title);
            item.find('.option-container').append(optionButton);
            item.find('.option-container').append(document.createElement('br'));

            if (parameters[2] === 'gestures') {
                var button = $('#item-container-inputs').find('#btn-show-gesture').clone().removeClass('hidden').removeAttr('id');
                button.attr('name', options[i].id);
                optionButton.append(button);
            }
        }
    }

    if (parameters[1] === true) {
        var optionalAnswer = $('#item-container-inputs').find('#checkbox-optionalanswer').clone();
        item.find('.option-container').append(optionalAnswer);
    }

    if (parameters[0] === true) {
        var justification = $('#item-container-inputs').find('#justification').clone();
        item.find('.option-container').append(justification);
    }
}

/*
 * gus & sus
 */

function renderGUSSinglePreview(item, data) {
    console.log(data);
    if (data.parameters[0] === true) {
        $(item).find('#reversed').removeClass('hidden');
    }
    if (data.dimension !== DIMENSION_ANY) {
        $(item).find('#item-factors').removeClass('hidden');
        $(item).find('#factor-primary').text(translation.dimensions[data.dimension]);
        $(item).find('#factor-main').text(translation.mainDimensions[data.dimension]);
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