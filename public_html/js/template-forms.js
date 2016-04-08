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

$('body').on('click', '#addFormat', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();

        var brotherID = $(this).parent().prevAll(".select:first").attr('id');
        var selectedID = $('#' + brotherID + ' .selected').attr('id');

        if (selectedID !== 'unselected') {
            var clone = $('#form-item-container').find('#' + selectedID).clone(true);
            $('#list-container').append(clone);
            checkCurrentListState($('#list-container'));

//            if(selectedID === PROTOTYPE_IMAGE) {
//                clone.find('.imageAreaContent').attr('id', getRandomId());
//                console.log(clone.find('.imageAreaContent').attr('id'));
//            }
        }
        updateBadges($('#list-container'), selectedID);
    }
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

$('body').on('click', '.btn-add-triggerOption', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        var clone = $('#triggerItem').clone();
        clone.removeClass('hidden');
        clone.removeAttr('id');
        $(this).parent().prev().append(clone);
        checkCurrentListState($(this).parent().prev());
    }
});

$('body').on('click', '.btn-add-gestureTrainingOption', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        $(this).prev().append($('#gestureTrainingItem').clone().removeClass('hidden'));
        checkCurrentListState($(this).prev());
    }
});

$('body').on('click', '.btn-add-elicitationOption', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        $(this).prev().append($('#elicitationItem').clone().removeClass('hidden'));
        checkCurrentListState($(this).prev());
    }
});

$('body').on('click', '.select .option li', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
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

$('body').on('click', '#helpContainer .btn-up', function (event) {
    event.preventDefault();
    updateHelpItemCounter($(this).closest('.option-container'));
});

$('body').on('click', '#helpContainer .btn-down', function (event) {
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

$('body').on('click', '.checkAssembledGestures', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
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
            } else {
                $(this).closest('.panel-body').find('#no-gestures-assembled').removeClass('hidden');
            }
        }
    }
});


/* 
 * toggable panel with switch button 
 */

$('.switchButtonAddonPanel').unbind('click').bind('click', function (event) {
//    console.log('switchButtonAddonPanel');
    event.preventDefault();
    togglePanelBody($(this).closest('.root').find('.panel-body'));
    togglePanelBadges($(this).closest('.root').find('.badges'));
});

$('.btn-toggle-checkbox-panel').unbind('click').bind('click', function (event) {
//    console.log('btn-toggle-checkbox-panel');
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

function renderAssembledGestures() {
    var gestures = assembledGestures();

    if (gestures && gestures.length > 0) {
        var wozExperimentItem = $('#form-item-container').find('.gestureSelect');
        $(wozExperimentItem).find('.option').empty();

        for (var i = 0; i < gestures.length; i++) {
            var listItem = document.createElement('li');
            listItem.setAttribute('id', gestures[i].id);
            var link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(gestures[i].title));
            listItem.appendChild(link);
            $(wozExperimentItem).find('.option').append(listItem);
            $('#form-item-container').find('.gestureSelect .dropdown-toggle').removeClass('disabled');
            $('#form-item-container').find('.option-gesture').attr('placeholder', 'Bitte wählen');
        }
    } else {
        console.log('no gestures arranged');
        $('#form-item-container').find('.gestureSelect .dropdown-toggle').addClass('disabled');
        $('#wozExperimentContainer').find('#no-gestures-assembled').removeClass('hidden');
        $('#wozExperimentContainer').find('.btn-add-woz-experiment-item').addClass('hidden');
        $('#form-item-container').find('.gestureSelect .dropdown-toggle').addClass('disabled');
        $('#form-item-container').find('.option-gesture').attr('placeholder', 'Kein Gestenset vorhanden');
    }
}

function renderPredefinedFeedback() {
    var feedback = getLocalItem(PREDEFINED_GESTURE_FEEDBACK);

    var triggerDropdown = $('#form-item-container').find('.feedbackSelect');
    $(triggerDropdown).find('.option').empty();
    var listItem;

    for (var i = 0; i < feedback.length; i++) {
        if (i === 0) {
            listItem = document.createElement('li');
            listItem.setAttribute('id', 'unselected');

            var link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode('Keines'));
            listItem.appendChild(link);
            $(triggerDropdown).find('.option').append(listItem);
        }

        listItem = document.createElement('li');
        listItem.setAttribute('id', feedback[i].id);

        var link = document.createElement('a');
        link.setAttribute('href', '#');
        link.appendChild(document.createTextNode(feedback[i].title));
        listItem.appendChild(link);
        $(triggerDropdown).find('.option').append(listItem);
    }
}

function renderAssembledTriggers() {
    var triggers = getLocalItem(TRIGGER_SET);
    var triggerDropdown = $('#form-item-container').find('.triggerSelect');
    $(triggerDropdown).find('.option').empty();

    if (triggers && triggers.length > 0) {
        $(triggerDropdown).find('.dropdown-toggle').removeClass('disabled');
        var listItem;
        for (var i = 0; i < triggers.length; i++) {
            listItem = document.createElement('li');
            listItem.setAttribute('id', triggers[i].id);

            var link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(triggers[i].title));
            listItem.appendChild(link);
            $(triggerDropdown).find('.option').append(listItem);
        }
        $('body').find('.option-trigger').attr('placeholder', 'Bitte wählen');
    } else {
        $(triggerDropdown).find('.dropdown-toggle').addClass('disabled');
        $('body').find('.option-trigger').attr('placeholder', 'Kein Triggerset vorhanden');
    }
}

$('body').on('click', '.gestureSelect .option li, .triggerSelect .option li, .feedbackSelect .option li, .repeatsSelect .option li', function () {
    var parent = $(this).closest('.select');
    var itemText = $(this).children().text();
    var listItemId = $(this).attr('id');
    $(parent).find('.selected').attr('id', listItemId);
    $(parent).prev().val(itemText);

    if ($(parent).closest('.select').hasClass('gestureSelect')) {
        $(this).closest('.root').find('#assembled-gestures-removed').addClass('hidden');
    }
    if ($(parent).closest('.select').hasClass('triggerSelect')) {
        $(this).closest('.root').find('#assembled-trigger-removed').addClass('hidden');
    }
    if ($(parent).closest('.select').hasClass('feedbackSelect')) {
        if (listItemId === 'unselected') {
            $(parent).find('.selected').val("");
        }
    }
});

$('body').on('click', '.simple-stepper .btn-stepper-decrease', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        var min = parseInt($(this).val());
        var currentValue = parseInt($(this).closest('.simple-stepper').find('.stepper-text').val());
        if (currentValue > min) {
            currentValue--;
        } else {
            currentValue = min;
        }
        $(this).closest('.simple-stepper').find('.stepper-text').val(currentValue);
    }
});

$('body').on('click', '.simple-stepper .btn-stepper-increase', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        var max = parseInt($(this).val());
        var currentValue = parseInt($(this).closest('.simple-stepper').find('.stepper-text').val());
        if (currentValue < max) {
            currentValue++;
        } else {
            currentValue = max;
        }
        $(this).closest('.simple-stepper').find('.stepper-text').val(currentValue);
    }
});

$('.choosePrototypeImage').on('click', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        $(this).closest('.root').find('.imageUpload').click();
    }
});

$('.imageUpload').change(function (event) {
    event.preventDefault();
    var imageAreaContent = $(this).parent().find('.imageAreaContent');
    var imageArea = $(this).parent().find('.imageArea');
    readFile(this.files[0], function (event) {
        $(imageAreaContent).attr("src", event.target.result);
        $(imageArea).removeClass('hidden');
        $(imageArea).parent().find('.choosePrototypeImage .btn-text').text('Anderes Bild auswählen');
        $(imageArea).parent().find('.choosePrototypeImage .btn-icon').removeClass('glyphicon-picture');
        $(imageArea).parent().find('.choosePrototypeImage .btn-icon').addClass('glyphicon-refresh');
    });
});

$('.btn-delete-image').on('click', function(event) {
    if (event.handled !== true)
    {
        event.handled = true;
        $(this).next().attr('src', '');
        $(this).parent().addClass('hidden');
        $(this).closest('.root').find('.choosePrototypeImage .btn-text').text('Bild auswählen');
        $(this).closest('.root').find('.choosePrototypeImage .btn-icon').removeClass('glyphicon-refresh');
        $(this).closest('.root').find('.choosePrototypeImage .btn-icon').addClass('glyphicon-picture');
    }
});

function readFile(file, onLoadCallback) {
    var reader = new FileReader();
    reader.onload = onLoadCallback;
    reader.readAsDataURL(file);
}