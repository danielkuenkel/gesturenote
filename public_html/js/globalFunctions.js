/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function showCursor(target, cursor) {
    $(target).css({cursor: cursor});
}

function hideCursor(target, cursor) {
    $(target).css({cursor: cursor});
}

function createRandomColors() {
    colors = randomColor({hue: 'green', count: 25});
}

$(document).on('click', '.select .option li', function (event) {
    event.preventDefault();
    if (!event.handled) {
        event.handled = true;

        console.log('global click select');

        if ($(this).hasClass('dropdown-header') || $(this).hasClass('divider') || $(this).hasClass('selected')) {
            return false;
        }

        var parent = $(this).closest('.select');
        var itemText = $(this).children().text();
        var listItemId = $(this).attr('id');
        $(parent).find('.chosen').attr('id', listItemId);
        $(parent).prev().val(itemText);
        $(this).parent().children('li').removeClass('selected');
        $(this).addClass('selected');

        var disabledElements = $(parent).children('.dropdown-disabled');
        if (disabledElements.length > 0) {
            for (var i = 0; i < disabledElements.length; i++) {
                $(disabledElements[i]).removeClass('disabled');
            }
        }

        if (parent.hasClass('saveGeneralData')) {
            saveGeneralData();
        }
    }
});

$(document).on('click', '.show-dropdown', function (event) {
    event.preventDefault();
    event.stopPropagation();
    $(this).next().find('[data-toggle=dropdown]').dropdown('toggle');
});

$(document).on('click', '.btn-delete', function (event) {
    event.stopPropagation();
    event.preventDefault();
    var element = $(this).closest('.root');
    var parent = $(element).parent();
    currentContainerList = parent;
    $(element).remove();
    checkCurrentListState(parent);
    if ($(this).hasClass('saveGeneralData')) {
        savePhases();
    }
});

$(document).on('click', '.btn-up', function (event) {
    event.preventDefault();
    event.stopPropagation();
    if (!event.handled) {
        event.handled = true;
        moveElement("up", $(this), $(this).hasClass('saveGeneralData'));
        checkCurrentListState($(this).closest('.root').parent());
    }

});

$(document).on('click', '.btn-down', function (event) {
    event.preventDefault();
    event.stopPropagation();
    if (!event.handled) {
        event.handled = true;
        moveElement("down", $(this), $(this).hasClass('saveGeneralData'));
        checkCurrentListState($(this).closest('.root').parent());
    }
});

function moveElement(direction, which, save) {
    var element = $(which).closest('.root');
    var brother;
    switch (direction) {
        case "up":
            brother = $(which).closest('.root').prev();
            $(element).insertBefore(brother);
            break;
        case "down":
            brother = $(which).closest('.root').next();
            $(element).insertAfter(brother);
            break;
    }
    if (save === true) {
        savePhases();
    }
}

function checkCurrentListState(itemContainer) {
    var childList = $(itemContainer).children();
    for (var i = 0; i < childList.length; i++) {
        var child = childList[i];
        var firstElement = $(child).find('.btn-up').first();
        var secondElement = firstElement.next();

        firstElement.removeClass('disabled');
        secondElement.removeClass('disabled');

        if (i === 0) {
            firstElement.addClass('disabled');
        }
        if (i === childList.length - 1) {
            secondElement.addClass('disabled');
        }
    }
}


/* 
 * Check if there are assembled gestures (a gesture set)
 * It's for the alert showing in dichotomous question container 
 * 
 * reset: remove alerts
 */

//$('body').on('click', '.check', function (event) {
//
//    if (event.handled !== true)
//    {
//        event.handled = true;
//        event.preventDefault();
//
//    }
//});
//
//$('body').on('click', '.reset', function (event) {
//    if (event.handled !== true)
//    {
//        event.handled = true;
//        event.preventDefault();
//        $(this).closest('.root').find('.alert-space').empty();
//    }
//});


/*
 * specific switch buttons 
 */
$(document).on('click', '.btn-toggle-checkbox', function (event) {
    event.preventDefault();
    if (!event.handled) {
        event.handled = true;


        if ($(this).hasClass('inactive')) {
            if ($(this).parent().children('.active').length === 0) {
                toggleSwitch(null, $(this));
            } else {
                toggleSwitch($(this).parent().children('.active'), $(this));
            }
        }

        if ($(this).hasClass('saveGeneralData')) {
            saveGeneralData();
        }

        if ($(this).hasClass('btn-toggle-checkbox-panel')) {
            togglePanel($(this));
        }

        if ($(this).hasClass('reset')) {
            $(this).closest('.root').find('.alert-space').empty();
        }

        if ($(this).hasClass('check')) {
            $(this).closest('.root').find('.alert-space').empty();

            if ($(this).hasClass(ALERT_NO_GESTURES_ASSEMBLED) && assembledGestures() === null) {
                appendAlert($(this).closest('.root'), ALERT_NO_GESTURES_ASSEMBLED);
            } else if ($(this).hasClass(ALERT_NO_TRIGGER_ASSEMBLED) && getLocalItem(ASSEMBLED_TRIGGER) === null) {
                appendAlert($(this).closest('.root'), ALERT_NO_TRIGGER_ASSEMBLED);
            }
        }
    }
});

$(document).on('click', '.switchButtonAddon', function (event) {
    event.preventDefault();
    if (!event.handled) {

        event.handled = true;
        var activeButton = $(this).nextAll().filter('.active');
        var inactiveButton = $(this).nextAll().filter('.inactive');

//        console.log(activeButton);


        if (activeButton.length === 0) {
            activeButton = null;
            inactiveButton = $(this).next();

        }
        console.log(inactiveButton);
        inactiveButton.click();
    }
});

function toggleSwitch(activeButton, inactiveButton) {
    if (activeButton) {
        $(activeButton).removeClass('active');
        $(activeButton).addClass('inactive');
        $(activeButton).addClass('btn-default');
        $(activeButton).removeClass($(activeButton).attr('name'));
    }
    $(inactiveButton).removeClass('inactive');
    $(inactiveButton).addClass('active');
    $(inactiveButton).removeClass('btn-default');
    $(inactiveButton).addClass($(inactiveButton).attr('name'));

    var supplements = $(activeButton).parent().children('.supplement');
    if (supplements.length > 0) {
        if ($(supplements).hasClass('hidden')) {
            $(supplements).removeClass('hidden');
        } else {
            $(supplements).addClass('hidden');
        }
    }
}

/* 
 * toggable panel with switch button 
 */

function togglePanel(source) {
    var panelBody = $(source).closest('.root').find('.panel-body');
    if ($(source).attr('id') === 'yes' && panelBody.hasClass('hidden')) {
        togglePanelBody(panelBody);
        togglePanelBadges($(source).closest('.root').find('.badges'));
    } else if ($(source).attr('id') === 'no' && !panelBody.hasClass('hidden')) {
        togglePanelBody(panelBody);
        togglePanelBadges($(source).closest('.root').find('.badges'));
    }
}

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
            showPanelBadges(badges);
        } else {
            hidePanelBadges(badges);
        }
    }
}

function hidePanelBadges(badges) {
    $(badges).addClass('hidden');
}

function showPanelBadges(badges) {
    $(badges).removeClass('hidden');
}


/*
 * simple stepper functions
 */
$(document).on('click', '.simple-stepper .btn-stepper-decrease', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var min = parseInt($(this).val());
        var currentValue = parseInt($(this).closest('.simple-stepper').find('.stepper-text').val());
        if (currentValue > min) {
            currentValue--;
        } else {
            currentValue = min;
        }
        $(this).closest('.simple-stepper').find('.stepper-text').val(currentValue);
        $(this).closest('.simple-stepper').find('.stepper-text').trigger('change');
    }
});

$(document).on('click', '.simple-stepper .btn-stepper-increase', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var max = parseInt($(this).val());
        var currentValue = parseInt($(this).closest('.simple-stepper').find('.stepper-text').val());
        if (currentValue < max) {
            currentValue++;
        } else {
            currentValue = max;
        }
        $(this).closest('.simple-stepper').find('.stepper-text').val(currentValue);
        $(this).closest('.simple-stepper').find('.stepper-text').trigger('change');
    }
});


/* 
 * Actions for the gesture select dropdown
 */

function renderAssembledGestures() {
    var gestures = assembledGestures();
    if (gestures) {
        var dropdown = $('#form-item-container').find('.gestureSelect');
        $(dropdown).find('.option').empty();

        for (var i = 0; i < gestures.length; i++) {
            var listItem = document.createElement('li');
            listItem.setAttribute('id', gestures[i].id);
            var link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(gestures[i].title));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);
            $('#form-item-container').find('.gestureSelect .dropdown-toggle').removeClass('disabled');
            $('#form-item-container').find('.option-gesture').attr('placeholder', 'Bitte wählen');
        }
    } else {
        $('#form-item-container').find('.gestureSelect .dropdown-toggle').addClass('disabled');
        $('#form-item-container').find('.option-gesture').attr('placeholder', 'Kein Gestenset vorhanden');
    }
}

/* 
 * Actions for the feedback select dropdown
 */

function renderPredefinedFeedback() {
    var feedback = getLocalItem(PREDEFINED_GESTURE_FEEDBACK);
    var dropdown = $('#form-item-container').find('.feedbackSelect');
    $(dropdown).find('.option').empty();
    var listItem;

    for (var i = 0; i < feedback.length; i++) {
        if (i === 0) {
            listItem = document.createElement('li');
            listItem.setAttribute('id', 'unselected');

            var link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode('Keines'));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);
        }

        listItem = document.createElement('li');
        listItem.setAttribute('id', feedback[i].id);

        var link = document.createElement('a');
        link.setAttribute('href', '#');
        link.appendChild(document.createTextNode(feedback[i].title));
        listItem.appendChild(link);
        $(dropdown).find('.option').append(listItem);
    }
}

/* 
 * Actions for the trigger select dropdown
 */

function renderAssembledTriggers() {
    var triggers = getLocalItem(ASSEMBLED_TRIGGER);
    var dropdown = $('#form-item-container').find('.triggerSelect');
    $(dropdown).find('.option').empty();

    if (triggers && triggers.length > 0) {
        $(dropdown).find('.dropdown-toggle').removeClass('disabled');
        var listItem;
        for (var i = 0; i < triggers.length; i++) {
            listItem = document.createElement('li');
            listItem.setAttribute('id', triggers[i].id);
//            console.log(triggers[i].id)

            var link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(triggers[i].title));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);
        }
        $('body').find('.option-trigger').attr('placeholder', 'Bitte wählen');
    } else {
        $(dropdown).find('.dropdown-toggle').addClass('disabled');
        $('body').find('.option-trigger').attr('placeholder', 'Kein Triggerset vorhanden');
    }
}

/* 
 * Actions for the prototype select dropdown
 */

function renderAssembledPrototypes() {
    var prototypes = getLocalItem(ASSEMBLED_PROTOTYPES);
    var prototypeDropdown = $('body').find('.prototypeSelect');
    $(prototypeDropdown).find('.option').empty();

    if (prototypes && prototypes.length > 0) {
        $(prototypeDropdown).find('.dropdown-toggle').removeClass('disabled');
        var listItem;

        for (var i = 0; i < prototypes.length; i++) {
            var link = document.createElement('a');
            if (i === 0) {
                listItem = document.createElement('li');
                listItem.setAttribute('id', 'unselected');

                link.setAttribute('href', '#');
                link.appendChild(document.createTextNode('keines'));
                listItem.appendChild(link);
                $(prototypeDropdown).find('.option').append(listItem);
            }

            listItem = document.createElement('li');
            listItem.setAttribute('id', prototypes[i].id);

            link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(prototypes[i].title));
            listItem.appendChild(link);
            $(prototypeDropdown).find('.option').append(listItem);
        }
        $('body').find('.option-prototype').attr('placeholder', 'Bitte wählen');
    } else {
        $(prototypeDropdown).find('.dropdown-toggle').addClass('disabled');
        $('body').find('.option-prototype').attr('placeholder', 'Keine Prototypen vorhanden');
    }
}


var wobbling = false;
function wobble(elements) {
    if (!wobbling) {
        wobbling = true;
        TweenMax.fromTo(elements, 0.3, {x: -3, y: -1}, {x: 3, y: 1, ease: RoughEase.ease.config({strength: 8, points: 20, template: Linear.easeNone, randomize: false}), clearProps: "x", onComplete: onWobbleComplete});
    }
}

function onWobbleComplete() {
    wobbling = false;
}

$(document).on('click', '.btn-checkbox', function (event) {
    if (event.handled !== true)
    {
        console.log($(this).hasClass('btn-checkbox-checked'));
        event.handled = true;
        if ($(this).hasClass('btn-checkbox-checked')) {
            $(this).removeClass('btn-checkbox-checked');
            $(this).find('#over').removeClass('hidden');
            $(this).find('#checked').addClass('hidden');
        } else {
            $(this).addClass('btn-checkbox-checked');
            $(this).find('#over, #normal').addClass('hidden');
            $(this).find('#checked').removeClass('hidden');
        }
    }
});

$(document).on('mouseover', '.btn-checkbox', function (event) {
    if (!$(this).hasClass('btn-checkbox-checked')) {
        $(this).find('#normal, #checked').addClass('hidden');
        $(this).find('#over').removeClass('hidden');
    }

});

$(document).on('mouseleave', '.btn-checkbox', function (event) {
    if (!$(this).hasClass('btn-checkbox-checked')) {
        $(this).find('#normal').removeClass('hidden');
        $(this).find('#over, #checked').addClass('hidden');
    }
});