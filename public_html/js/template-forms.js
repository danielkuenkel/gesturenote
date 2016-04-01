/* 
 * Close function which called when click save or close button. NOTE: Not called
 * when clicked outside of a modal 
 */

function onCloseClick() {
    saveData();
    currentIdForModal = null;
}



/* 
 * common form format functions 
 */

$('#addFormat').on('click', function (event) {
    event.preventDefault();

    var brotherID = $(this).parent().prevAll(".select:first").attr('id');
    var selectedID = $('#' + brotherID + ' .selected').attr('id');

    if (selectedID !== 'unselected') {
        var clone = $('#form-item-container').find('#' + selectedID).clone(true);
        $('#list-container').append(clone);
        checkCurrentListState($('#list-container'));
    }
    updateBadges($('#list-container'), selectedID);
});

$('.btn-add-groupingQuestionOption').unbind('click').bind('click', function (event) {
    event.preventDefault();
    var clone = $('#groupingQuestionItem').clone().removeClass('hidden');
    $(this).prev().find('.panel-body').append(clone);
    checkCurrentListState($(this).prev().find('.panel-body'));
});

$('.btn-add-ratingOption').unbind('click').bind('click', function (event) {
    event.preventDefault();
    var clone = $('#ratingItem').clone().removeClass('hidden');
    clone.removeAttr('id');
    $(this).prev().find('.panel-body').append(clone);
    checkCurrentListState($(this).prev().find('.panel-body'));
    renderScaleItems($(clone).find('.ratingScaleItemContainer'), 3);
    return false;
});

$('.btn-add-sumQuestionOption').unbind('click').bind('click', function (event) {
    event.preventDefault();
    var clone = $('#sumQuestionItem').clone().removeClass('hidden');
    $(this).prev().find('.panel-body').append(clone);
    checkCurrentListState($(this).prev().find('.panel-body'));
});

$('.btn-add-rankingOption').unbind('click').bind('click', function (event) {
    event.preventDefault();
    var clone = $('#rankingItem').clone().removeClass('hidden');
    $(this).prev().find('.panel-body').append(clone);
    checkCurrentListState($(this).prev().find('.panel-body'));
});

$('body').on('click', '.btn-add-woz-experimentOption', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        $(this).prev().append($('#wozExperimentItem').clone().removeClass('hidden'));
        checkCurrentListState($(this).prev());
    }
});

$('body').on('click', '.btn-add-helpOption', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        $(this).prev().append($('#helpItem').clone().removeClass('hidden'));
        checkCurrentListState($(this).prev());
        updateHelpItemCounter($(this).prev());
    }
});

$('body').on('click', '.select .option li', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        console.log('test');
        var parent = $(this).closest('.select');
        if ($(parent).hasClass('scaleSelect')) {
            var scaleItemContainer = $(this).parents('.root').first().find('.ratingScaleItemContainer');
            var scaleSelectCount = $(this).children().text().trim();
            renderScaleItems(scaleItemContainer, scaleSelectCount, undefined);
        }
    }
});

function renderScaleItems(container, count, text)
{
    $(container).empty();
    for (var i = 0; i < count; i++)
    {
        var scaleItem = $('#ratingScaleItem').clone();
        scaleItem.removeClass('hidden');
        $(container).append(scaleItem);

        if (i === 0) {
            $(scaleItem).find('.input-group-addon').text("von " + (i + 1));
            $(scaleItem).find('.item-input-text').attr('placeholder', 'z.B. trifft zu');
        } else if (i === count - 1) {
            $(scaleItem).find('.input-group-addon').text("bis " + (i + 1));
            $(scaleItem).find('.item-input-text').attr('placeholder', 'z.B. trifft nicht zu');
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
        var children = container.children('#' + selector);
        for (var i = 0; i < children.length; i++) {
            $(children[i]).find('.badgeId').text(i + 1);
            $(children[i]).find('.badgeQuantity').text(children.length);
        }
    }
}

$('body').on('click', '.btn-up', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        updateBadges($(this).closest('.container-root'), $(this).closest('.root').attr('id'));
    }
});

$('body').on('click', '.btn-down', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        updateBadges($(this).closest('.container-root'), $(this).closest('.root').attr('id'));
    }
});

$('body').on('click', '.btn-delete', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        updateBadges(currentContainerList, $(this).closest('.root').attr('id'));
    }
});


/* 
 * specific help up/down button actions 
 */

$('body').on('click', '#help .btn-up', function (event) {
    event.preventDefault();
    updateHelpItemCounter($(this).closest('.option-container'));
});

$('body').on('click', '#help .btn-down', function (event) {
    event.preventDefault();
    updateHelpItemCounter($(this).closest('.option-container'));
});

function updateHelpItemCounter(container) {
    var children = container.children();
    for (var i = 0; i < children.length; i++) {
        $(children[i]).find('.count-text').text(i + 1);
    }
}

/* 
 * Check if there are assembled gestures (a gesture set)
 * It's for the alert showing in dichotomous question container 
 */

$('.checkAssembledGestures').unbind('click').bind('click', function (event) {
    console.log('checkAssembledGestures: ');
    
    event.preventDefault();
    var aGestures = assembledGestures();
    if (!aGestures || aGestures.length === 0) {
        event.stopPropagation();
        if ($(this).attr('id') === 'success') {
            $(this).parent().find('.switchButtonAddon').click();
            $(this).closest('.panel-body').find('#no-gestures-assembled').removeClass('hidden');
        } else if ($(this).hasClass('switchButtonAddon')) {
            var activeButton = $(this).nextAll().filter('#success');
            var inactiveButton = $(this).nextAll().filter('#warning');
            $(this).closest('.panel-body').find('#no-gestures-assembled').removeClass('hidden');
            toggleSwitch(activeButton, inactiveButton);
        }
    }
});


/* 
 * toggable panel with switch button 
 */

$('.switchButtonAddonPanel').unbind('click').bind('click', function (event) {
    console.log('switchButtonAddonPanel');
    event.preventDefault();
    togglePanelBody($(this).closest('.root').find('.panel-body'));
    togglePanelBadges($(this).closest('.root').find('.badges'));
});

$('.btn-toggle-checkbox-panel').unbind('click').bind('click', function (event) {
    console.log('btn-toggle-checkbox-panel');
    event.preventDefault();
    if (!$(this).hasClass('active')) {
        togglePanelBody($(this).closest('.root').find('.panel-body'));
        togglePanelBadges($(this).closest('.root').find('.badges'));
    }
});

function togglePanelBody(panelBody) {
    if ($(panelBody).hasClass('hidden')) {
        $(panelBody).removeClass('hidden');
    } else {
        $(panelBody).addClass('hidden');
    }
}

function togglePanelBadges(badges) {
    if (badges !== undefined || badges !== null) {
        if ($(badges).hasClass('hidden')) {
            $(badges).removeClass('hidden');
        } else {
            $(badges).addClass('hidden');
        }
    }
}


/* 
 * Actions for the gesture select dropdown
 */

$('body').on('click', '.gestureSelect .option li, .wozTriggerSelect .option li', function () {
    var parent = $(this).closest('.select');
    var itemText = $(this).children().text();
    var listItemId = $(this).attr('id');
    $(parent).find('.selected').attr('id', listItemId);
    $(parent).prev().val(itemText);
});