/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function showCursor(target, cursor) {
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

function renderSubPageElements() {
    var header = $('#header-footer-container').find('#sub-page-header').clone().removeAttr('id');
    header.insertBefore($('body').find('#breadcrumb'));
    var footer = $('#header-footer-container').find('#sub-page-footer').clone().removeAttr('id');
    $('body').append(footer);
    footer.find('#btn-imprint').text(translation.imprint);
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

        $(this).trigger('change');
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

    if ($(element).attr('id') === SCENE_IMAGE) {
        var url = ["../" + $(element).find('.imageAreaContent').attr('src')];
        deleteSceneImage({image: url}, null);
    }

    if ($(element).attr('id') === TYPE_FEEDBACK_SOUND) {
        var url = ["../" + $(element).find('.audio-holder').attr('src')];
        deleteSound({sound: url}, null);
    }

    currentContainerList = parent;
    $(element).remove();
    checkCurrentListState(parent);

    if ($(this).hasClass('saveGeneralData')) {
        savePhases();
    }

    updateBadges(currentContainerList, $(this).closest('.root').attr('id'));
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
            var opacityElement = $(element).css('opacity');
            var opacityBrother = $(brother).css('opacity');
            var timeline = new TimelineMax({onComplete: onMoveUpComplete, onCompleteParams: [element, brother, save]});
            timeline.add("start", 0)
                    .to(element, .2, {y: -offset}, "start")
                    .to(brother, .2, {y: heightBrother === heightElement ? offset : heightElement}, "start");
//                    .to(element, ELEMENT_MOVE_TRANSITION_DURATION / 2, {}, "start")
//                    .to(element, ELEMENT_MOVE_TRANSITION_DURATION / 2, {delay: ELEMENT_MOVE_TRANSITION_DURATION / 2}, "start")
//                    .to(brother, ELEMENT_MOVE_TRANSITION_DURATION / 2, {}, "start")
//                    .to(brother, ELEMENT_MOVE_TRANSITION_DURATION / 2, {delay: ELEMENT_MOVE_TRANSITION_DURATION / 2}, "start");
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
                    .to(brother, ELEMENT_MOVE_TRANSITION_DURATION, {y: -offset}, "start");
//                    .to(element, ELEMENT_MOVE_TRANSITION_DURATION / 2, {}, "start")
//                    .to(element, ELEMENT_MOVE_TRANSITION_DURATION / 2, {delay: ELEMENT_MOVE_TRANSITION_DURATION / 2}, "start")
//                    .to(brother, ELEMENT_MOVE_TRANSITION_DURATION / 2, {}, "start")
//                    .to(brother, ELEMENT_MOVE_TRANSITION_DURATION / 2, {delay: ELEMENT_MOVE_TRANSITION_DURATION / 2}, "start");

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
    if (element.parent().find('.badgeId').length > 0) {
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
    if (element.parent().find('.badgeId').length > 0) {
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

        $(this).trigger('change');
    }
});
$(document).on('click', '.switchButtonAddon', function (event) {
    event.preventDefault();
    if (!event.handled) {
        event.handled = true;
        var inactiveButton;
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

var mouseDownInterval;
var mouseDownTimer;
var mouseHoldInterval = 800;
$(document).on('mousedown', '.simple-stepper .btn-stepper-increase', function (event) {
    event.preventDefault();
    event.stopPropagation();
    var button = $(this);

    mouseDownInterval = setInterval(function () {
        mouseHoldInterval = 50;
        button.click();
        clearInterval(mouseDownInterval);
        mouseDownInterval = setInterval(function () {
            button.click();
        }, mouseHoldInterval);
    }, mouseHoldInterval);
});

$(document).on('mouseup', '.simple-stepper .btn-stepper-increase', function (event) {
    event.preventDefault();
    event.stopPropagation();
    clearInterval(mouseDownInterval);
    mouseHoldInterval = 800;
});

$(document).on('mousedown', '.simple-stepper .btn-stepper-decrease', function (event) {
    event.preventDefault();
    event.stopPropagation();
    var button = $(this);

    mouseDownInterval = setInterval(function () {
        mouseHoldInterval = 50;
        button.click();
        clearInterval(mouseDownInterval);
        mouseDownInterval = setInterval(function () {
            button.click();
        }, mouseHoldInterval);
    }, mouseHoldInterval);
});

$(document).on('mouseup', '.simple-stepper .btn-stepper-decrease', function (event) {
    event.preventDefault();
    event.stopPropagation();
    clearInterval(mouseDownInterval);
    mouseHoldInterval = 800;
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
        $(target).find('.gestureSelect .dropdown-toggle').removeClass('disabled');
        $(target).find('.option-gesture').attr('placeholder', 'Bitte wählen');
        for (var i = 0; i < gestures.length; i++) {
            var gesture = gestures[i];
            var listItem = document.createElement('li');
            listItem.setAttribute('id', gesture.id);
            var link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(gesture.title));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);
        }
    } else {
        $(target).find('.gestureSelect .dropdown-toggle').addClass('disabled');
        $(target).find('.option-gesture').attr('placeholder', 'Kein Gestenset vorhanden');
    }
}

/* 
 * Actions for the trigger select dropdown
 */

function renderAssembledTriggers(targetContainer) {
    var triggers = getLocalItem(ASSEMBLED_TRIGGER);
    var target = targetContainer === undefined ? $('#form-item-container') : targetContainer;

    if (triggers && triggers.length > 0) {
        var dropdown = target === null ? $('#form-item-container').find('.triggerSelect') : $(target).find('.triggerSelect');
        $(dropdown).find('.option').empty();
        $(dropdown).find('.dropdown-toggle').removeClass('disabled');
        $(target).find('.triggerSelect .dropdown-toggle').removeClass('disabled');
        $(target).find('.option-trigger').attr('placeholder', 'Bitte wählen');
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
        $('body').find('.option-trigger').attr('placeholder', 'Keine Funktionen vorhanden');
    }
}

/* 
 * Actions for the prototype select dropdown
 */

function renderAssembledScenes() {
    var scenes = getLocalItem(ASSEMBLED_SCENES);
    var dropdowns = $('body').find('.sceneSelect');
    $(dropdowns).find('.option').empty();

    if (scenes && scenes.length > 0) {
        for (var j = 0; j < dropdowns.length; j++) {
            var dropdown = dropdowns[j];
            $(dropdown).find('.dropdown-toggle').removeClass('disabled');
            var listItem;
            for (var i = 0; i < scenes.length; i++) {
                var link = document.createElement('a');

                if (i === 0 && !$(dropdown).hasClass('no-none')) {
                    listItem = document.createElement('li');
                    listItem.setAttribute('id', 'none');
                    link.setAttribute('href', '#');
                    link.appendChild(document.createTextNode(translation.none));
                    listItem.appendChild(link);
                    $(dropdown).find('.option').append(listItem);
                }

                listItem = document.createElement('li');
                listItem.setAttribute('id', scenes[i].id);
                link = document.createElement('a');
                link.setAttribute('href', '#');
                link.appendChild(document.createTextNode(scenes[i].title));
                listItem.appendChild(link);
                $(dropdown).find('.option').append(listItem);
            }
            $('body').find('.item-input-text').attr('placeholder', 'Bitte wählen');
        }
    } else {
        $(dropdowns).find('.dropdown-toggle').addClass('disabled');
        $('body').find('.item-input-text').attr('placeholder', 'Keine Szene vorhanden');
    }
}

/* 
 * Actions for the feedback selection dropdown
 */

function renderAssembledFeedback(targetContainer) {
    var feedback = getLocalItem(ASSEMBLED_FEEDBACK);
    var target = targetContainer === undefined ? $('#form-item-container') : targetContainer;
    if (feedback !== null) {
        feedback = sortByKey(feedback, 'type', true);
        var currentType = null;

        var dropdown = target === null ? $('#form-item-container').find('.feedbackSelect') : $(target).find('.feedbackSelect');
        $(dropdown).find('.option').empty();
        var listItem;
        for (var i = 0; i < feedback.length; i++) {
            var link = document.createElement('a');
            if (i === 0 && !$(dropdown).hasClass('no-none')) {
                listItem = document.createElement('li');
                listItem.setAttribute('id', 'none');
                link.setAttribute('href', '#');
                link.appendChild(document.createTextNode(translation.nones));
                listItem.appendChild(link);
                $(dropdown).find('.option').append(listItem);
            }

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

            listItem = document.createElement('li');
            listItem.setAttribute('id', feedback[i].id);
            link = document.createElement('a');
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

        $(this).trigger('change');
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

// hint handling
function appendHint(source, target, data, surveyType) {
    if (data.feedbackId !== 'none') {
        removeHint($(target).find('#hint'));
        var hint = $(source).find('#feedback-hint').clone();
        hint.attr('id', 'hint');
        $('body').append(hint);
        renderDataForHint(data, hint, source, surveyType);
        switch (surveyType) {
            case TYPE_SURVEY_MODERATED:
                hint.find('#btn-close-hint').remove();
                break;
            case TYPE_SURVEY_UNMODERATED:
                hint.find('.progress-hint').remove();
                break;
        }
        return hint;
    }

    return null;
}

function renderDataForHint(data, hint, source, surveyType) {
    var feedback = getFeedbackById(data.feedbackId);
    switch (feedback.type) {
        case TYPE_FEEDBACK_TEXT:
            hint.find('.hint-content').prepend($(source).find('#feedback-hint-text-content').clone().removeAttr('id'));
            hint.find('#feedback-title').text(feedback.title);
            if (surveyType === TYPE_SURVEY_MODERATED) {
                TweenMax.to(hint.find('.progress-bar'), 5, {width: '0%', autoRound: false, ease: Power0.easeNone, onComplete: hideHint, onCompleteParams: [hint]});
            }
            break;
        case TYPE_FEEDBACK_SOUND:
            hint.find('.hint-content').prepend($(source).find('#feedback-hint-sound-content').clone().removeAttr('id'));
            var audioHolder = hint.find('.audio-holder')[0];
            hint.find('#feedback-title').text(feedback.title);
            $(audioHolder).attr('src', feedback.data);
            audioHolder.addEventListener("loadedmetadata", function () {
                audioHolder.play();
                if (surveyType === TYPE_SURVEY_MODERATED) {
                    TweenMax.to(hint.find('.progress-bar'), audioHolder.duration, {delay: .3, width: '0%', autoRound: false, ease: Power0.easeNone, onComplete: hideHint, onCompleteParams: [hint]});
                }
            });
            break;
    }

    hint.find('#btn-close-hint').on('click', function (event) {
        event.preventDefault();
        hideHint(hint);
    });
}

function hideHint(hint) {
    TweenMax.to(hint, .2, {autoAlpha: 0, onComplete: onhideHintComplete, onCompleteParams: [hint]});
}

function onhideHintComplete(hint) {
    $(hint).trigger('hint.hidden');
    removeHint(hint);
}

function removeHint(hint) {
    $(hint).remove();
}


// pagination handling
function initPagination(pagination, dataLength, maxElements) {
    $(pagination).children('.clickable-pagination-item').remove();

    var maxPages = Math.ceil(dataLength / maxElements);
    $(pagination).attr('maxPages', maxPages);

    if (maxPages <= 1) {
        $(pagination).addClass('hidden');
    } else {
        $(pagination).removeClass('hidden');
    }

    var paginationClipping = parseInt($(pagination).attr('itemprop').split('_')[1]);
    var currentIndex = isNaN(getCurrentPaginationIndex()) ? 0 : getCurrentPaginationIndex();
    for (var i = 0; i < Math.min(paginationClipping, maxPages); i++) {
        var listItem = getPaginationItem(i + 1);
        $(listItem).insertBefore($(pagination).find('#btn-next-page'));
        if (currentIndex !== null && currentIndex === i) {
            $(listItem).click();
        }
    }
}

function checkPagination(pagination, dataLength, maxElements) {
    var currentMaxPages = parseInt($(pagination).attr('maxPages'));
    var maxPages = Math.ceil(dataLength / maxElements);

    if (maxPages !== currentMaxPages) {
        var paginationItems = $(pagination).children('.clickable-pagination-item');
        for (var i = 0; i < paginationItems.length; i++) {
            $(paginationItems[i]).removeClass('active');
            if (i === (maxPages - 1)) {
                $(paginationItems[i]).addClass('active');
            }
        }
        initPagination(pagination, dataLength, maxElements);
    }
}

function getCurrentPaginationIndex(pagination) {
    return parseInt($(pagination).find('.active').text()) - 1;
}

$(document).on('click', '.pagination li', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var pagination = $(this).closest('.pagination');
        var maxPages = parseInt($(pagination).attr('maxPages'));

        if (!$(this).hasClass('active') && $(this).hasClass('clickable-pagination-item')) {
            $(pagination).find('.active').removeClass('active');
            $(this).addClass('active');
            $(this).trigger('indexChanged', [parseInt($(this).text()) - 1]);
        } else {
            var direction = $(this).attr('id');
            var currentIndex = parseInt($(this).closest('.pagination').find('.active').text());
            switch (direction) {
                case 'btn-first-page':
                    shiftPaginationFirstPage(pagination);
                    break;
                case 'btn-previous-page':
                    var previousIndexButton = $(pagination).find('.active').prev();
                    if ($(previousIndexButton).hasClass('clickable-pagination-item')) {
                        $(previousIndexButton).click();
                    } else if (currentIndex > 1) {
                        shiftPaginationBackward(pagination);
                    }
                    break;
                case 'btn-next-page':
                    var nextIndexButton = $(pagination).find('.active').next();
                    if ($(nextIndexButton).hasClass('clickable-pagination-item')) {
                        $(nextIndexButton).click();
                    } else if (currentIndex < maxPages) {
                        shiftPaginationForward(pagination);
                    }
                    break;
                case 'btn-last-page':
                    shiftPaginationLastPage(pagination);
                    break;
            }
        }
    }
});
function shiftPaginationForward(pagination) {
    var paginationItems = $(pagination).find('.clickable-pagination-item');
    for (var i = 0; i < paginationItems.length; i++) {
        var item = paginationItems[i];
        $(item).find('#index-text').text(parseInt($(item).text()) + 1);
    }
    $(pagination).find('.active').removeClass('active').click();
}

function shiftPaginationBackward(pagination) {
    var paginationItems = $(pagination).find('.clickable-pagination-item');
    for (var i = 0; i < paginationItems.length; i++) {
        var item = paginationItems[i];
        $(item).find('#index-text').text(parseInt($(item).text()) - 1);
    }
    $(pagination).find('.active').removeClass('active').click();
}

function shiftPaginationLastPage(pagination) {
    var maxPages = parseInt($(pagination).attr('maxPages'));
    var paginationItems = $(pagination).find('.clickable-pagination-item');

    if (paginationItems.length === maxPages) {
        $(pagination).find('#btn-next-page').prev().click();
    } else {

        var indexStart = (maxPages + 1) - paginationItems.length;
        for (var i = 0; i < paginationItems.length; i++) {
            var item = paginationItems[i];
            $(item).find('#index-text').text(indexStart++);
            if (i === paginationItems.length - 1) {
                $(pagination).find('#btn-next-page').prev().click();
            }
        }
    }
}
function shiftPaginationFirstPage(pagination) {
    var maxPages = parseInt($(pagination).attr('maxPages'));
    var paginationItems = $(pagination).find('.clickable-pagination-item');

    if (paginationItems.length === maxPages) {
        $(pagination).find('#btn-previous-page').next().click();
    } else {
        for (var i = 0; i < paginationItems.length; i++) {
            var item = paginationItems[i];
            $(item).find('#index-text').text(i + 1);
            if (i === paginationItems.length - 1) {
                $(pagination).find('#btn-previous-page').next().click();
            }
        }
    }
}

function getPaginationItem(text) {
    var listItem = document.createElement('li');
    $(listItem).addClass('clickable-pagination-item');
    var href = document.createElement('a');
    $(href).text(text);
    $(href).attr('id', 'index-text');
    $(href).attr('href', '#');
    $(listItem).append(href);
    return listItem;
}

function getMainDimensionForDimension(dimension) {
    var mainDimensions = translation.mainDimensionsForDimension;
    return mainDimensions[dimension];
}

function getDimensionByElement(element) {
    var dimensions = translation.dimensions;

    for (var dimension in dimensions) {
        if ($(element).hasClass(dimension) === true) {
            return dimension;
        }
    }

    return DIMENSION_ANY;
}

// tab navigation handling
$(document).on('click', '.nav-tabs li', function (event) {
    event.preventDefault();
    if (!event.handled && !$(this).hasClass('active')) {
        event.handled = true;
        $(this).parent().find('.active').removeClass('active');
        $(this).addClass('active');
        $(this).trigger('change');
    }
});

function getAssembledItems(source) {
    var array = new Array();
    if (source && source.length > 0) {
        for (var i = 0; i < source.length; i++) {
//            console.log(source[i].dimension);
            if (source[i].dimension !== DIMENSION_ANY && source[i].parameters[0] === true) {
                array.push(source[i]);
            } else if (source[i].dimension === DIMENSION_ANY) {
                array.push(source[i]);
            }
        }
        return array;
    }
    return null;
}


// gesture thumbnail handling
$(document).on('click', '.gesture-thumbnail, .gesture-details', function (event) {
    event.preventDefault();
    if (!event.handled) {
        event.handled = true;

        if (!$(this).find('.panel-collapse').hasClass('in')) {
            toggleGestureThumbnailCollapse($(this).closest('.root').find('.panel-collapse'));
        } else {
            return false;
        }

        if ($(this).find('.panel-collapse').hasClass('in')) {
            var gestureId = $(this).closest('.gesture-thumbnail').attr('id');
            var gesture = getGestureById(gestureId);
            renderGestureImages($(this).closest('.gesture-thumbnail').find('.previewGesture'), gesture.images, gesture.previewImage, null);
        }
    }
});

function toggleGestureThumbnailCollapse(element) {
    if (!$(element).hasClass('in')) {
        var brothers = $(element).closest('.container-root').children();
        for (var i = 0; i < brothers.length; i++) {
            $(brothers[i]).find('.panel-collapse').removeClass('in');
            $(brothers[i]).find('#btn-stop-gesture').click();
        }
        $(element).addClass('in');
    } else {
        $(element).removeClass('in');
    }
}

$(document).on('click', '.gesture-assemble, .gesture-assemble-description, .gesture-unassemble-description', function (event) {
    event.preventDefault();
    if (!event.handled) {
        event.handled = true;
        var thumbnail = $(this).closest('.gesture-thumbnail');

        if (!$(thumbnail).hasClass('selected')) {
            thumbnail.addClass('selected');
            thumbnail.addClass('panel-success');
            thumbnail.find('.gesture-assemble').addClass('btn-success');
            thumbnail.find('.gesture-assemble-description').addClass('hidden');
            thumbnail.find('.gesture-unassemble-description').removeClass('hidden');
            thumbnail.find('#gesture-source, #gesture-scope').addClass('label-success');
        } else {
            thumbnail.removeClass('selected');
            thumbnail.removeClass('panel-success');
            thumbnail.find('.gesture-assemble').removeClass('btn-success');
            thumbnail.find('.gesture-assemble-description').removeClass('hidden');
            thumbnail.find('.gesture-unassemble-description').addClass('hidden');
            thumbnail.find('#gesture-source').removeClass('label-success');
        }
    }
});

$(document).on('click', '.gesture-reassemble, .gesture-unassemble-description', function (event) {
    event.preventDefault();
    if (!event.handled) {
        event.handled = true;
        var thumbnail = $(this).closest('.gesture-thumbnail');
        var gestureId = thumbnail.attr('id');
        reassembleGesture(gestureId);
        saveData();
        renderData(assembledGestures());
    }
});



/*
 * sorting
 */

var originalFilterData = null;
var currentFilterData = null;

function sort() {
    var array = filter($('#filter .chosen').attr('id'));
    var sortType = $('#sort .chosen').attr('id');

    if (array && array.length > 0) {
        switch (sortType) {
            case SORT_ASC:
                array = sortByKey(array, 'title', false);
                break;
            case SORT_DESC:
                array = sortByKey(array, 'title', true);
                break;
            case SORT_NEWEST:
                array = sortByKey(array, 'created', true);
                break;
            case SORT_OLDEST:
                array = sortByKey(array, 'created', false);
                break;
        }
    }

    return array;
}


/*
 * filtering
 */

function filter(scope) {
    var array = new Array();
    if (!scope) {
        scope = $('#filter').find('.chosen').attr('id');
    }

    if (scope === 'all') {
        return originalFilterData;
    } else {
        for (var i = 0; i < originalFilterData.length; i++) {
            if (scope === SOURCE_GESTURE_RECORDED && originalFilterData[i].isOwner === true) {
                if (originalFilterData[i].source === SOURCE_GESTURE_EVALUATOR) {
                    array.push(originalFilterData[i]);
                }
            } else if (originalFilterData[i].scope === scope || originalFilterData[i].source === scope) {
                array.push(originalFilterData[i]);
            }
        }
    }
    return array;
}


/*
 * searching
 */

$(document).on('keyup', '.search-input', function (event) {
    event.preventDefault();
    if (!event.handled) {
        event.handled = true;

        if ($(this).hasClass('save-data')) {
            saveData();
        }

        var filter = $(this).val();
        var container = $('#list-container');
        container.removeClass('hidden');

        if (filter.trim() !== "" && event.keyCode !== 27) {
            var matched = searchThroughArray(sort(), filter.trim());
            if (matched.length > 0) {
                removeAlert($('#item-view'), ALERT_NO_SEARCH_RESULTS);
                renderData(matched, true);
            } else {
                container.addClass('hidden');
                appendAlert($('#item-view'), ALERT_NO_SEARCH_RESULTS);
            }
        } else {
            removeAlert($('#item-view'), ALERT_NO_SEARCH_RESULTS);
            renderData(sort());

            if (event.keyCode === 27) {
                $(this).val('');
            }
        }
    }
});

function searchThroughArray(array, filter) {
    var result = new Array();
    for (var i = 0; i < array.length; i++) {
        if (array[i].title.search(new RegExp(filter, "i")) > -1) {
            result.push(array[i]);
        }
    }
    return result;
}







function getGestureListThumbnail(data) {
    var clone = $('#form-item-container').find('#gesture-thumbnail').clone();
    clone.attr('id', data.id);
    clone.find('.title-text').text(data.title + " ");
    clone.find('#title .text').text(data.title);
    clone.find('#context .text').text(data.context);
    clone.find('#description .text').text(data.description);


    if (data.isOwner === true) {
        if (data.source !== SOURCE_GESTURE_TESTER) {
            clone.find('#gesture-source').text(translation.gestureSources[SOURCE_GESTURE_RECORDED]);
        } else {
            clone.find('#gesture-source').text(translation.gestureSources[data.source]);
        }
    }
    clone.find('#gesture-scope').text(translation.gestureScopes[data.scope]);

    renderBodyJointsPreview(clone.find('#human-body'), data.joints);

    return clone;
}

function getGestureListThumbnailPreview(data) {
    var clone = $('#form-item-container').find('#gesture-thumbnail-assembled').clone();
    clone.attr('id', data.id);
    clone.find('.title-text').text(data.title + " ");
    clone.find('#title .text').text(data.title);
    clone.find('#context .text').text(data.context);
    clone.find('#description .text').text(data.description);

    if (data.isOwner === true) {
        if (data.source !== SOURCE_GESTURE_TESTER) {
            clone.find('#gesture-source').text(translation.gestureSources[SOURCE_GESTURE_RECORDED]);
        } else {
            clone.find('#gesture-source').text(translation.gestureSources[data.source]);
        }
    }
    clone.find('#gesture-scope').text(translation.gestureScopes[data.scope]);

    renderBodyJointsPreview(clone.find('#human-body'), data.joints);

    return clone;
}