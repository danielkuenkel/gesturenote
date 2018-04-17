/* 
 * This functions handle the dimensions group list.
 */

var predefinedQuestionnaire = null;
var questionsContainer = null;
var dimensionList = null;
function renderDimensions(target, questionnaire, container, dimensions) {
    dimensionList = target;
    predefinedQuestionnaire = questionnaire;
    questionsContainer = container;

    for (var key in dimensions) {
        if (dimensions.hasOwnProperty(key)) {
            var value = dimensions[key];
//            var mainDimension = getMainDimensionForDimension(key);
            var button = document.createElement('button');
            $(button).addClass('btn btn-default btn-shadow btn-toggle btn-dimension hidden');
            $(button).attr('id', key);
            var btnText = document.createElement('span');
            $(btnText).text(value.title);
            $(button).append(btnText);
            if (value.popover) {
                var popover = document.createElement('i');
                $(popover).addClass('fa fa-info-circle btn-show-info');
                $(popover).attr('data-toggle', 'popover');
                $(popover).attr('data-trigger', 'hover');
                $(popover).attr('data-placement', 'auto');
                $(popover).attr('data-content', value.popover);
                $(popover).css({marginLeft: '3px'});
                $(button).append(popover);
            }
            $(target).find('.dimension-btn-group').prepend(button);
        }
    }
    initPopover();

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

    checkDimensionItems($(dimensionList).find('.dimension-container'));
}

$(document).on('click', '.dimension-btn-group .btn-toggle', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        var dimensionContainer = $(this).closest('.dimension-container');
//        var mainDimension = $(this).closest('.dimension-container').attr('id').split('-')[1];

        if ($(this).hasClass('active')) {
            removeQuestionaireItems($(this).attr('id'));
            $(this).removeClass('active btn-info').addClass('inactive');

            if ($(this).attr('id') === 'all') {
                var children = $(dimensionContainer).find('.btn-toggle').not('.hidden');
                $(children).removeClass('btn-info active').addClass('inactive');
                $(this).text(translation.all);
            } else {
                $(this).parent().find('#all').removeClass('active btn-info');
                $(this).parent().find('#all').text('Alle');
                checkDimensionItems(dimensionContainer);
            }
        } else {
            addQuestionnaireItems(dimensionContainer, $(this).attr('id'));
            $(this).removeClass('inactive').addClass('active btn-info');

            if ($(this).attr('id') === 'all') {
                var children = $(this).parent().children('.btn-toggle').not('.hidden');
                $(children).removeClass('inactive').addClass('btn-info active');
                $(this).text(translation.none);
            } else {
                checkDimensionItems(dimensionContainer);
            }

            $(this).trigger('listItemAdded');
        }
    }
});

function checkDimensionItems(dimensionContainer) {
    for (var i = 0; i < dimensionContainer.length; i++) {
        var container = $(dimensionContainer[i]).find('.dimension-btn-group');
        var dimensions = $(container).children('.btn-dimension');
        var hiddenDimensions = $(container).find('.hidden');
        var inactiveDimensions = dimensions.filter('.inactive');

        if (hiddenDimensions.length === dimensions.length) {
            $(container).closest('.dimension-container').addClass('hidden');
        } else if (hiddenDimensions.length < dimensions.length && inactiveDimensions.length === 0) {
            $(container).find('#all').removeClass('inactive').addClass('active btn-info').text(translation.none);
        }
    }
}

function addQuestionnaireItems(container, dimension) {
    if (dimension === 'all') {
        var dimensions = $(container).find('.btn-dimension');
        for (var i = 0; i < dimensions.length; i++) {
            var dimensionButton = dimensions[i];
            if (!$(dimensionButton).hasClass('hidden') && !$(dimensionButton).hasClass('active')) {
                renderQuesitonnaireItemsForDimension($(dimensionButton).attr('id'));
            }
        }
    } else {
        renderQuesitonnaireItemsForDimension(dimension);
    }
}

function renderQuesitonnaireItemsForDimension(dimension) {
    var items = getPredefinedQuestionnaireItemsByDimension(dimension);
    console.log(items);
    for (var i = 0; i < items.length; i++) {
        renderFormatItem(questionsContainer, items[i]);
        updateBadges(questionsContainer, items[i].format);
    }
    checkCurrentListState(questionsContainer);
    checkDimensionItems($(dimensionList).find('.dimension-container'));
}

function getPredefinedQuestionnaireItemsByDimension(dimension) {
    var questionnaire = new Array();
    for (var i = 0; i < predefinedQuestionnaire.length; i++) {
        if (predefinedQuestionnaire[i].dimension === dimension) {
            questionnaire.push(predefinedQuestionnaire[i]);
        }
    }
    return questionnaire;
}

function removeQuestionaireItems(dimension) {
    var itemList = $(questionsContainer).children();
    for (var i = 0; i < itemList.length; i++) {
        var item = itemList[i];
        var itemDimension = getDimensionByElement($(item));
        if (itemDimension !== DIMENSION_ANY) {
            if (dimension === 'all' || itemDimension === dimension) {
                var itemId = $(item).attr('id');
                $(item).find('.btn-delete').click();
                updateBadges(questionsContainer, itemId);
            }
        }
    }
}

$(document).on('click', '.btn-use', function (event) {
    event.preventDefault();
    if (!event.handled) {
        event.handled = true;
        $(this).popover('hide');
        if ($(this).hasClass('used')) {
            $(this).find('.fa').removeClass('fa-star').addClass('fa-star-o');
            $(this).attr('data-content', translation.tooltips.general.useQuestion).data('bs.popover').setContent();
            $(this).removeClass('used btn-success').addClass('not-used');
            $(this).closest('.root').removeClass('used').addClass('not-used');
            if ($(this).closest('.root').find('.hide-when-unused').length > 0) {
                $(this).closest('.root').find('.hide-when-unused').addClass('hidden');
            }
        } else {
            $(this).find('.fa').removeClass('fa-star-o').addClass('fa-star');
            $(this).attr('data-content', translation.tooltips.general.dontUseQuestion).data('bs.popover').setContent();
            $(this).removeClass('not-used').addClass('used btn-success');
            $(this).closest('.root').removeClass('not-used').addClass('used');
            if ($(this).closest('.root').find('.hide-when-unused').length > 0) {
                $(this).closest('.root').find('.hide-when-unused').removeClass('hidden');
            }
        }
        checkUsedItems($(this).closest('.root'));
        $(this).trigger('change');
    }
});

function checkUsedItems(element) {
    var dimension = getDimensionByElement(element);
    var usedDimensionElements = element.parent().children('[data-dimension=' + dimension + ']').find('.used');
    if (usedDimensionElements.length === 0) {
        $('#dimension-controls #' + dimension).click();
    }
}