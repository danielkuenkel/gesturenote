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

function sortByKey(array, key, reverse) {
    return array.sort(function (a, b) {
        var x = a[key];
        var y = b[key];
        if (reverse) {
            x = b[key];
            y = a[key];
        }

        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
    });
}

$(document).on('click', '.select .option li', function (event) {
    event.preventDefault();
    if (!event.handled) {
        event.handled = true;

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
        if (!$(this).hasClass('disabled')) {
            moveElement("up", $(this), $(this).hasClass('saveGeneralData'));
        }
    }
});

$(document).on('click', '.btn-down', function (event) {
    event.preventDefault();
    event.stopPropagation();
    if (!event.handled) {
        event.handled = true;
        if (!$(this).hasClass('disabled')) {
            moveElement("down", $(this), $(this).hasClass('saveGeneralData'));
        }
    }
});

function moveElement(direction, which, save) {
    var element = $(which).closest('.root');
    var brother;

    $(element).find('.btn-up').addClass('disabled');
    $(element).find('.btn-down').addClass('disabled');
    $(element).find('.btn-delete').addClass('disabled');

    switch (direction) {
        case "up":
            brother = $(which).closest('.root').prev();
            $(brother).find('.btn-up').addClass('disabled');
            $(brother).find('.btn-down').addClass('disabled');
            $(brother).find('.btn-delete').addClass('disabled');

            var offset = element.offset().top - brother.offset().top;
            var heightBrother = brother.outerHeight(true);
            var heightElement = element.outerHeight(true);

            var timeline = new TimelineMax({onComplete: onMoveUpComplete, onCompleteParams: [element, brother, save]});
            timeline.add("start", 0)
                    .to(element, .2, {y: -offset}, "start")
                    .to(brother, .2, {y: heightBrother === heightElement ? offset : heightElement}, "start")
                    .to(element, ELEMENT_MOVE_TRANSITION_DURATION / 2, {opacity: .2}, "start")
                    .to(element, ELEMENT_MOVE_TRANSITION_DURATION / 2, {opacity: 1, delay: ELEMENT_MOVE_TRANSITION_DURATION / 2}, "start")
                    .to(brother, ELEMENT_MOVE_TRANSITION_DURATION / 2, {opacity: .2}, "start")
                    .to(brother, ELEMENT_MOVE_TRANSITION_DURATION / 2, {opacity: 1, delay: ELEMENT_MOVE_TRANSITION_DURATION / 2}, "start");
            break;
        case "down":
            brother = $(which).closest('.root').next();
            $(brother).find('.btn-up').addClass('disabled');
            $(brother).find('.btn-down').addClass('disabled');
            $(brother).find('.btn-delete').addClass('disabled');

            var offset = brother.offset().top - element.offset().top;
            var heightBrother = brother.outerHeight(true);
            var heightElement = element.outerHeight(true);

            var timeline = new TimelineMax({onComplete: onMoveDownComplete, onCompleteParams: [element, brother, save]});
            timeline.add("start", 0)
                    .to(element, ELEMENT_MOVE_TRANSITION_DURATION, {y: heightBrother === heightElement ? offset : heightBrother}, "start")
                    .to(brother, ELEMENT_MOVE_TRANSITION_DURATION, {y: -offset}, "start")
                    .to(element, ELEMENT_MOVE_TRANSITION_DURATION / 2, {opacity: .2}, "start")
                    .to(element, ELEMENT_MOVE_TRANSITION_DURATION / 2, {opacity: 1, delay: ELEMENT_MOVE_TRANSITION_DURATION / 2}, "start")
                    .to(brother, ELEMENT_MOVE_TRANSITION_DURATION / 2, {opacity: .2}, "start")
                    .to(brother, ELEMENT_MOVE_TRANSITION_DURATION / 2, {opacity: 1, delay: ELEMENT_MOVE_TRANSITION_DURATION / 2}, "start");

            break;
    }
}

function onMoveUpComplete(element, brother, save) {
    var timeline = new TimelineMax();
    timeline.add("start", 0)
            .to(element, 0, {y: 0}, "start")
            .to(brother, 0, {y: 0}, "start");
    $(element).insertBefore(brother);

    if (save === true) {
        savePhases();
    }

    $(element).find('.btn-delete').removeClass('disabled');
    $(brother).find('.btn-delete').removeClass('disabled');
    checkCurrentListState(element.closest('.root').parent());
    if (element.parent().find('.badge').length > 0) {
        updateBadges(element.parent(), element.attr('id'));
    }
}

function onMoveDownComplete(element, brother, save) {
    var timeline = new TimelineMax();
    timeline.add("start", 0)
            .to(element, 0, {y: 0}, "start")
            .to(brother, 0, {y: 0}, "start");
    $(element).insertAfter(brother);

    if (save === true) {
        savePhases();
    }

    $(element).find('.btn-delete').removeClass('disabled');
    $(brother).find('.btn-delete').removeClass('disabled');
    checkCurrentListState(element.closest('.root').parent());
    if (element.parent().find('.badge').length > 0) {
        updateBadges(element.parent(), element.attr('id'));
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
            } else if ($(this).hasClass(ALERT_NO_FEEDBACK_ASSEMBLED) && getLocalItem(ASSEMBLED_FEEDBACK) === null) {
                appendAlert($(this).closest('.root'), ALERT_NO_FEEDBACK_ASSEMBLED);
            }
        }
    }
});

$(document).on('click', '.switchButtonAddon', function (event) {
    event.preventDefault();
    if (!event.handled) {
        event.handled = true;
        var activeButton = $(this).nextAll().filter('.active');

        if (activeButton.nextAll().filter('.btn-toggle-checkbox').length === 0 || activeButton.length === 0) {
            activeButton = null;
            inactiveButton = $(this).next();

        } else {
            inactiveButton = activeButton.next();
        }
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

function renderAssembledGestures(targetContainer) {
    var gestures = assembledGestures();
    var target = targetContainer === undefined ? $('#form-item-container') : targetContainer;
    if (gestures !== null) {
        var dropdown = target === null ? $('#form-item-container').find('.gestureSelect') : $(target).find('.gestureSelect');
        $(dropdown).find('.option').empty();

        for (var i = 0; i < gestures.length; i++) {
            var listItem = document.createElement('li');
            listItem.setAttribute('id', gestures[i].id);
            var link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(gestures[i].title));
            listItem.appendChild(link);

            $(dropdown).find('.option').append(listItem);
            $(target).find('.gestureSelect .dropdown-toggle').removeClass('disabled');
            $(target).find('.option-gesture').attr('placeholder', 'Bitte wählen');
        }
    } else {
        $(target).find('.gestureSelect .dropdown-toggle').addClass('disabled');
        $(target).find('.option-gesture').attr('placeholder', 'Kein Gestenset vorhanden');
    }
}

/* 
 * Actions for the feedback select dropdown
 */

//function renderPredefinedFeedback() {
//    var feedback = getLocalItem(PREDEFINED_GESTURE_FEEDBACK);
//    var dropdown = $('#form-item-container').find('.feedbackSelect');
//    $(dropdown).find('.option').empty();
//    var listItem;
//
//    for (var i = 0; i < feedback.length; i++) {
//        if (i === 0) {
//            listItem = document.createElement('li');
//            listItem.setAttribute('id', 'unselected');
//
//            var link = document.createElement('a');
//            link.setAttribute('href', '#');
//            link.appendChild(document.createTextNode('Keines'));
//            listItem.appendChild(link);
//            $(dropdown).find('.option').append(listItem);
//        }
//
//        listItem = document.createElement('li');
//        listItem.setAttribute('id', feedback[i].id);
//
//        var link = document.createElement('a');
//        link.setAttribute('href', '#');
//        link.appendChild(document.createTextNode(feedback[i].title));
//        listItem.appendChild(link);
//        $(dropdown).find('.option').append(listItem);
//    }
//}

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

/* 
 * Actions for the feedback selection dropdown
 */

function renderAssembledFeedback(targetContainer) {
    var feedback = getLocalItem(ASSEMBLED_FEEDBACK);
    var target = targetContainer === undefined ? $('#form-item-container') : targetContainer;
    if (feedback !== null) {
//        console.log(feedback);
        feedback = sortByKey(feedback, 'type', true);
        var currentType = null;
//        console.log(feedback);

        var dropdown = target === null ? $('#form-item-container').find('.feedbackSelect') : $(target).find('.feedbackSelect');
        $(dropdown).find('.option').empty();

        for (var i = 0; i < feedback.length; i++) {
            var type = feedback[i].type;
            if (currentType !== type) {
                currentType = type;

                if (i > 0) {
                    var divider = document.createElement('li');
                    $(divider).addClass('divider');
                    $(dropdown).find('.option').append(divider);
                }

                var header = document.createElement('li');
                $(header).addClass('dropdown-header');
                $(header).text(translation[type]);
                $(dropdown).find('.option').append(header);
            }

            var listItem = document.createElement('li');
            listItem.setAttribute('id', feedback[i].id);
            var link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(feedback[i].title));
            listItem.appendChild(link);

            $(dropdown).find('.option').append(listItem);
            $(target).find('.feedbackSelect .dropdown-toggle').removeClass('disabled');
            $(target).find('.option-feedback').attr('placeholder', 'Bitte wählen');
        }
    } else {
        $(target).find('.feedbackSelect .dropdown-toggle').addClass('disabled');
        $(target).find('.option-feedback').attr('placeholder', 'Keine Feedbacks vorhanden');
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

$(document).on('click', '.btn-checkbox, .btn-radio', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        if ($(this).hasClass('btn-checkbox') && $(this).hasClass('btn-option-checked')) {
            $(this).removeClass('btn-option-checked');
            $(this).find('#normal').removeClass('hidden');
            $(this).find('#checked').addClass('hidden');
        } else {
            if ($(this).hasClass('btn-radio')) {
                var children = $(this).closest('.root').children('#radio, #radio-optionalanswer').find('.btn-radio');
                $(children).removeClass('btn-option-checked');
                $(children).find('#normal').removeClass('hidden');
                $(children).find('#checked').addClass('hidden');
            }

            $(this).addClass('btn-option-checked');
            $(this).find('#over, #normal').addClass('hidden');
            $(this).find('#checked').removeClass('hidden');
        }
    }
});

$(document).on('focus focusin select', '.optionalInput', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        if (($(this).val().trim() === '' && !$(this).parent().find('.btn-radio, .btn-checkbox').hasClass('btn-option-checked')) ||
                ($(this).val().trim() !== '' && !$(this).parent().find('.btn-radio, .btn-checkbox').hasClass('btn-option-checked'))) {
            $(this).parent().find('.btn-radio, .btn-checkbox').click();
        }
    }
});

$(document).on('focusout', '.optionalInput', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        var btnChecked = $(this).parent().find('.btn-option-checked');
        if ($(this).val().trim() === '') {
            btnChecked.click();
        }
    }
});

$(document).on('mouseover', '.btn-checkbox, .btn-radio', function () {
    if (!$(this).hasClass('btn-option-checked')) {
        $(this).find('#normal, #checked').addClass('hidden');
        $(this).find('#over').removeClass('hidden');
    }

});

$(document).on('mouseleave', '.btn-checkbox, .btn-radio', function () {
    if (!$(this).hasClass('btn-option-checked')) {
        $(this).find('#normal').removeClass('hidden');
        $(this).find('#over, #checked').addClass('hidden');
    }
});

$(document).on('slide change', '.custom-range-slider', function () {
    if ($(this).hasClass('saveGeneralData')) {
        saveGeneralData();
    }
});