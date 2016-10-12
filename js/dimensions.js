/* 
 * This functions handle the dimensions group list.
 */


/*
 * dimensions list handling
 */ 
function renderDimensions(target, questionnaire) {
    var dimensions = translation.dimensions;
    for (var key in dimensions) {
        if (dimensions.hasOwnProperty(key)) {
            var value = dimensions[key];
            var mainDimension = getMainDimensionForDimension(key);
            var button = document.createElement('button');
            $(button).addClass('btn btn-default btn-shadow btn-toggle btn-dimension hidden');
            $(button).attr('id', key);
            $(button).text(value);
            $(target).find('#container-' + mainDimension + " .dimension-btn-group").prepend(button);
        }
    }

    var dimensionContainer = $(target).find('.dimension-container');
    for (var i = 0; i < dimensionContainer.length; i++) {
        if ($(dimensionContainer[i]).find('.btn-dimension').length === 0) {
            $(dimensionContainer[i]).addClass('hidden');
        }
    }

    if (questionnaire && questionnaire.length > 0) {
        for (var i = 0; i < questionnaire.length; i++) {
            if ($(target).find('#' + questionnaire[i].dimension)) {
                $(target).find('#' + questionnaire[i].dimension).removeClass('hidden');
                $(target).find('#' + questionnaire[i].dimension).addClass('inactive');
            }
        }
    } else {
        dimensionContainer.addClass('hidden');
    }
}

$(document).on('click', '.dimension-btn-group .btn-toggle', function (event) {
    if (event.handled !== true)
    {

        event.handled = true;
        var dimensionContainer = $(this).closest('.dimension-container');
        var mainDimension = $(this).closest('.dimension-container').attr('id').split('-')[1];
//        console.log(dimensionContainer);
        if ($(this).hasClass('active')) {
            removeQuestionaireItems(mainDimension, $(this).attr('id'));
            $(this).removeClass('active');
            $(this).removeClass('btn-info');
            $(this).addClass('inactive');
            if ($(this).attr('id') === 'all') {
//                $('#factor-seperator').addClass('hidden');

                var children = $(dimensionContainer).find('.btn-toggle');
                $(children).removeClass('btn-info active').addClass('inactive');
                $(this).text('Alle');
            } else {
                $(this).parent().find('#all').removeClass('active btn-info');
                $(this).parent().find('#all').text('Alle');
                checkDimensionItems(dimensionContainer);
            }
        } else {

            addQuestionnaireItems(dimensionContainer, $(this).attr('id'));
            $(this).addClass('active');
            $(this).addClass('btn-info');
            $(this).removeClass('inactive');
            if ($(this).attr('id') === 'all') {
//                $('#factor-seperator').removeClass('hidden');

                var children = $(this).parent().children('.btn-toggle');
                $(children).removeClass('inactive').addClass('btn-info active');
                $(this).text('Keine');
            } else {
                checkDimensionItems(dimensionContainer);
            }
        }
    }
});

function checkDimensionItems(dimensionContainer) {

    for (var i = 0; i < dimensionContainer.length; i++) {
        var container = $(dimensionContainer[i]).find('.dimension-btn-group');
        var dimensions = $(container).children('.btn-dimension');
        var hiddenDimensions = $(container).find('.hidden');
        var inactiveDimensions = dimensions.filter('.inactive');
        if (hiddenDimensions.length < dimensions.length && inactiveDimensions.length === 0) {
            $(container).find('#all').removeClass('inactive').addClass('active btn-info');
            $(container).find('#all').text('Keine');
        }
    }
}

function addQuestionnaireItems(container, dimension) {
    if (dimension === 'all') {
        var dimensions = $(container).find('.btn-dimension');
        for (var i = 0; i < dimensions.length; i++) {
            var dimensionButton = dimensions[i];
            if (!$(dimensionButton).hasClass('hidden') && !$(dimensionButton).hasClass('active')) {
                renderData(getPredefinedQuestionnaireItemsByDimension($(dimensionButton).attr('id')), true);
            }
        }
    } else {
        renderData(getPredefinedQuestionnaireItemsByDimension(dimension), true);
    }
}

var currentGUS = null;
function getPredefinedQuestionnaireItemsByDimension(dimension) {
    var predefinedQuestionnaire = currentGUS === GUS_SINGLE_GESTURES ? getLocalItem(STUDY_ORIGIN_GUS) : getLocalItem(PREDEFINED_GESTURE_QUESTIONNAIRE);
    var questionnaire = new Array();
    for (var i = 0; i < predefinedQuestionnaire.length; i++) {
        if (predefinedQuestionnaire[i].dimension === dimension) {
            questionnaire.push(predefinedQuestionnaire[i]);
        }
    }
    return {gus: questionnaire};
}

function removeQuestionaireItems(mainDimension, dimension) {
    var itemList = $('#list-container').children();
    for (var i = 0; i < itemList.length; i++) {
        var item = itemList[i];
        var itemDimension = getDimensionByElement($(item));
        if (itemDimension !== DIMENSION_ANY) {
            if ((dimension === 'all' && mainDimension === getMainDimensionForDimension(itemDimension)) || itemDimension === dimension) {
                var itemId = $(item).attr('id');
                $(item).find('.btn-delete').click();
                updateBadges($('#list-container'), itemId);
            }
        }
    }
}

$(document).on('click', '.btn-use', function (event) {
    event.preventDefault();
    if (!event.handled) {
        event.handled = true;
        if ($(this).hasClass('used')) {
            $(this).removeClass('used btn-success').addClass('not-used');
            $(this).closest('.root').removeClass('used');
            $(this).closest('.root').addClass('not-used');
        } else {
            $(this).removeClass('not-used').addClass('used btn-success');
            $(this).closest('.root').removeClass('not-used');
            $(this).closest('.root').addClass('used');
        }
        checkUsedItems($(this).closest('.root'));
    }
});

function checkUsedItems(element) {
    var dimension = getDimensionByElement(element);
//    var mainDimension = getMainDimensionForDimension(dimension);
    var usedDimensionElements = element.parent().children('.' + dimension).find('.used');
    if (usedDimensionElements.length > 0) {

    } else {
        $('#dimension-controls #' + dimension).click();
    }
}