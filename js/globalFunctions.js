/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function checkDomain() {
    if (location.hostname.includes("www.gesturenote.de")) {
        location.href = "http://gesturenote.com";
    }
}

// check supported local storage
function isLocalStorageSupported() {
    if (typeof (Storage) !== "undefined") {
        console.log("Yes, your browser supports Web Session Storage.");
        return true;
    } else {
        console.log("Sorry, your browser do not support Web Session Storage.");
        return false;
    }
}


var BROWSER_CHROME = 'Chrome';
var BROWSER_OPERA = 'Opera';
var BROWSER_MSIE = 'MSIE';
var BROWSER_SAFARI = 'Safari';
var BROWSER_FIREFOX = 'Firefox';
//browser ID
function getBrowser() {
    var nVer = navigator.appVersion;
    var nAgt = navigator.userAgent;
    var browserName = navigator.appName;
    var fullVersion = '' + parseFloat(navigator.appVersion);
    var majorVersion = parseInt(navigator.appVersion, 10);
    var nameOffset, verOffset, ix;

    // In Opera, the true version is after "Opera" or after "Version"
    if ((verOffset = nAgt.indexOf(BROWSER_OPERA)) !== -1) {
        browserName = BROWSER_OPERA;
        fullVersion = nAgt.substring(verOffset + 6);
        if ((verOffset = nAgt.indexOf("Version")) !== -1)
            fullVersion = nAgt.substring(verOffset + 8);
    }
    // In MSIE, the true version is after "MSIE" in userAgent
    else if ((verOffset = nAgt.indexOf(BROWSER_MSIE)) !== -1) {
        browserName = BROWSER_MSIE;
        fullVersion = nAgt.substring(verOffset + 5);
    }
    // In Chrome, the true version is after "Chrome"
    else if ((verOffset = nAgt.indexOf(BROWSER_CHROME)) !== -1) {
        browserName = BROWSER_CHROME;
        fullVersion = nAgt.substring(verOffset + 7);
    }
    // In Safari, the true version is after "Safari" or after "Version"
    else if ((verOffset = nAgt.indexOf(BROWSER_SAFARI)) !== -1) {
        browserName = BROWSER_SAFARI;
        fullVersion = nAgt.substring(verOffset + 7);
        if ((verOffset = nAgt.indexOf("Version")) !== -1)
            fullVersion = nAgt.substring(verOffset + 8);
    }
    // In Firefox, the true version is after "Firefox"
    else if ((verOffset = nAgt.indexOf(BROWSER_FIREFOX)) !== -1) {
        browserName = BROWSER_FIREFOX;
        fullVersion = nAgt.substring(verOffset + 8);
    }
    // In most other browsers, "name/version" is at the end of userAgent
    else if ((nameOffset = nAgt.lastIndexOf(' ') + 1) <
            (verOffset = nAgt.lastIndexOf('/')))
    {
        browserName = nAgt.substring(nameOffset, verOffset);
        fullVersion = nAgt.substring(verOffset + 1);
        if (browserName.toLowerCase() === browserName.toUpperCase()) {
            browserName = navigator.appName;
        }
    }
    // trim the fullVersion string at semicolon/space if present
    if ((ix = fullVersion.indexOf(";")) !== -1)
        fullVersion = fullVersion.substring(0, ix);
    if ((ix = fullVersion.indexOf(" ")) !== -1)
        fullVersion = fullVersion.substring(0, ix);

    majorVersion = parseInt('' + fullVersion, 10);
    if (isNaN(majorVersion)) {
        fullVersion = '' + parseFloat(navigator.appVersion);
        majorVersion = parseInt(navigator.appVersion, 10);
    }


    return browserName;
}

function statusAddressMatchIndex(phaseStepId) {
    var phaseSteps = getContextualPhaseSteps();
    if (phaseSteps && phaseSteps.length > 0) {
        for (var i = 0; i < phaseSteps.length; i++) {
            if (parseInt(phaseStepId) === parseInt(phaseSteps[i].id)) {
                return {index: i, id: phaseSteps[i].id};
            }
        }
    }
    return null;
}

function animateBreadcrump() {
    var breadcrumpItems = $('#breadcrumb').find('.breadcrumb').children();
    for (var i = 0; i < breadcrumpItems.length; i++) {
        TweenMax.from($(breadcrumpItems[i]), .2, {delay: 0.2 + (i * .05), x: -10, opacity: 0, clearProps: 'all'});
    }
}

function dataURItoBlob(dataURI) {
    // convert base64/URLEncoded data component to raw binary data held in a string
    var byteString;
    if (dataURI.split(',')[0].indexOf('base64') >= 0)
        byteString = atob(dataURI.split(',')[1]);
    else
        byteString = unescape(dataURI.split(',')[1]);

    // separate out the mime component
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

    // write the bytes of the string to a typed array
    var ia = new Uint8Array(byteString.length);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }

    return new Blob([ia], {type: mimeString});
}

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

function unique(origArr) {
    var newArr = [],
            origLen = origArr.length,
            found,
            x, y;

    for (x = 0; x < origLen; x++) {
        found = undefined;
        for (y = 0; y < newArr.length; y++) {
            if (origArr[x] === newArr[y]) {
                found = true;
                break;
            }
        }
        if (!found)
            newArr.push(origArr[x]);
    }
    return newArr;
}

function renderSubPageElements(hasTopNavbar) {
    var header = $('#header-footer-container').find('#sub-page-header').clone().removeAttr('id');
    header.insertBefore($('body').find('#breadcrumb'));
    header.find('#btn-sign-out .btn-text').text(translation.signOut);
    header.find('#btn-sign-out').on('click', function (event) {
        clearLocalItems();
    });

    header.find('#logo').on('click', function (event) {
        event.preventDefault();
        gotoIndex();
    });

    var footer = $('#header-footer-container').find('#sub-page-footer').clone().removeAttr('id');
    $('body').append(footer);
    footer.find('#btn-imprint').text(translation.imprint);

    if (hasTopNavbar === false) {
        header.find('.navbar-right').addClass('hidden');
    }
}

$(document).on('click', '.select .option li', function (event) {
    event.preventDefault();
    if (!event.handled && !$(this).hasClass('disabled')) {
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

        $(this).trigger('change', [listItemId]);
    }
});

$(document).on('mouseenter', '.btn-show-hole-text', function (event) {
    if (!event.handled) {
        event.handled = true;
        var inputVal = $(this).closest('.input-group').find('input').val();
        if (inputVal.trim() !== '') {
            $(this).attr('title', inputVal);
            $(this).tooltip('show');
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

    if ($(element).attr('id') === SCENE_IMAGE) {
        var url = ["../" + $(element).find('.imageAreaContent').attr('src')];
        deleteSceneImage({image: url}, null);
    }

    if ($(element).attr('id') === TYPE_FEEDBACK_SOUND) {
        var url = ["../" + $(element).find('.audio-holder').attr('src')];
        deleteSound({sound: url}, null);
    }

    TweenMax.to(element, .3, {opacity: 0, clearProps: 'all', onComplete: onTweenDeleteComplete, onCompleteParams: [element, parent, $(this)]});
});

function onTweenDeleteComplete(element, parent, button) {
    $(element).remove();
    checkCurrentListState(parent);

    if ($(button).hasClass('saveGeneralData')) {
        savePhases();
    }

    updateBadges(parent, $(button).closest('.root').attr('id'));
    $(parent).trigger('change');
}

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

    $(element).trigger('change');
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

    $(element).trigger('change');
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
    if (!event.handled && !$(this).hasClass('disabled') && $(this).hasClass('inactive')) {
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

        $(this).trigger('change', [$(this).parent().find('.active').attr('id')]);
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

function renderAssembledGestures(targetContainer, optionalSelections) {
    var gestures = assembledGestures();
    var target = $('#form-item-container');
    if (targetContainer !== undefined && targetContainer !== null) {
        target = targetContainer;
    }

    if (gestures !== null) {
        var dropdown = target === null ? $('#form-item-container').find('.gestureSelect') : $(target).find('.gestureSelect');
        $(dropdown).find('.option').empty();
        $(target).find('.gestureSelect .dropdown-toggle').removeClass('disabled');
        $(target).find('.option-gesture').attr('placeholder', 'Bitte wählen');

        var listItem, link;
        for (var i = 0; i < gestures.length; i++) {
            var gesture = gestures[i];
            listItem = document.createElement('li');
            listItem.setAttribute('id', gesture.id);

            link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(gesture.title));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);
        }

        if (optionalSelections && optionalSelections.length > 0) {
            listItem = document.createElement('li');
            listItem.setAttribute('class', 'divider');
            $(dropdown).find('.option').append(listItem);

            for (var i = 0; i < optionalSelections.length; i++) {
                listItem = document.createElement('li');
                listItem.setAttribute('id', optionalSelections[i].id);

                link = document.createElement('a');
                link.setAttribute('href', '#');
                link.appendChild(document.createTextNode(optionalSelections[i].title));
                listItem.appendChild(link);
                $(dropdown).find('.option').append(listItem);
            }
        }
    } else {
        $(target).find('.gestureSelect .dropdown-toggle').addClass('disabled');
        $(target).find('.option-gesture').attr('placeholder', 'Kein Gestenset vorhanden');
    }
}


/* 
 * Actions for the trigger select dropdown
 */

function renderAssembledTriggers(targetContainer, addNoneItem) {
    var triggers = getLocalItem(ASSEMBLED_TRIGGER);
    var target = $('#form-item-container');
    if (targetContainer !== undefined && targetContainer !== null) {
        target = targetContainer;
    }

    var listItem, link;
    if (triggers && triggers.length > 0) {
        var dropdown = target === null ? $('#form-item-container').find('.triggerSelect') : $(target).find('.triggerSelect');
        $(dropdown).find('.option').empty();
        $(dropdown).find('.dropdown-toggle').removeClass('disabled');
        $(target).find('.triggerSelect .dropdown-toggle').removeClass('disabled');
        $(target).find('.option-trigger').attr('placeholder', 'Bitte wählen');

        for (var i = 0; i < triggers.length; i++) {
            listItem = document.createElement('li');
            listItem.setAttribute('id', triggers[i].id);
            link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(triggers[i].title));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);
        }

        if (addNoneItem) {
            link = document.createElement('a');
            listItem = document.createElement('li');
            listItem.setAttribute('id', 'none');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(translation.none));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);
        }
    } else {
        $(target).find('.triggerSelect .dropdown-toggle').addClass('disabled');
        $(target).find('.option-trigger').attr('placeholder', 'Keine Funktionen vorhanden');
    }


}


/* 
 * Actions for the prototype select dropdown
 */

function renderAssembledScenes(targetContainer, addNoneItem) {
    var scenes = getLocalItem(ASSEMBLED_SCENES);
    var target = $('#form-item-container');
    if (targetContainer !== undefined && targetContainer !== null) {
        target = targetContainer;
    }

    var listItem, link;
    if (scenes && scenes.length > 0) {
        var dropdown = target === null ? $('#form-item-container').find('.sceneSelect') : $(target).find('.sceneSelect');
        $(dropdown).find('.option').empty();
        $(dropdown).find('.dropdown-toggle').removeClass('disabled');
        $(target).find('.sceneSelect .dropdown-toggle').removeClass('disabled');
        $(target).find('.option-scene').attr('placeholder', 'Bitte wählen');


        for (var i = 0; i < scenes.length; i++) {
            listItem = document.createElement('li');
            listItem.setAttribute('id', scenes[i].id);
            link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(scenes[i].title));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);
        }

        if (addNoneItem) {
            link = document.createElement('a');
            listItem = document.createElement('li');
            listItem.setAttribute('id', 'none');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(translation.none));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);
        }
    } else {
//        console.log('disabled scene dropdown');
        $(target).find('.sceneSelect .dropdown-toggle').addClass('disabled');
        $(target).find('.option-scene').attr('placeholder', 'Keine Zustände vorhanden');
    }
}

/* 
 * Actions for the feedback selection dropdown
 */

function renderAssembledFeedback(targetContainer) {
    var feedback = getLocalItem(ASSEMBLED_FEEDBACK);
    var target = targetContainer === undefined || null ? $('#form-item-container') : targetContainer;
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
            uncheckOption($(this));
        } else {
            checkOption($(this));
        }
    }
});

function uncheckOption(optionItem) {
    $(optionItem).removeClass('btn-option-checked');
    $(optionItem).find('#normal').removeClass('hidden');
    $(optionItem).find('#checked').addClass('hidden');
    $(optionItem).trigger('change');
}

function checkOption(optionItem) {
    if ($(optionItem).hasClass('btn-radio')) {
        var children = $(optionItem).closest('.root').children('#radio, #radio-optionalanswer').find('.btn-radio');
        $(children).removeClass('btn-option-checked');
        $(children).find('#normal').removeClass('hidden');
        $(children).find('#checked').addClass('hidden');
    }

    $(optionItem).addClass('btn-option-checked');
    $(optionItem).find('#over, #normal').addClass('hidden');
    $(optionItem).find('#checked').removeClass('hidden');
    $(optionItem).trigger('change');
}

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
//    console.log(data);
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
//    console.log(feedback, data);
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
currentPaginationData = null;
function initPagination(data) {
    console.log('initPagination', data);
    currentPaginationData = data;

    var maxPages = Math.ceil(data.pager.dataLength / data.pager.maxElements);
    var paginationClipping = null;

    if (data.pager.top) {
        paginationClipping = parseInt($(data.pager.top).attr('itemprop').split('_')[1]);
        $(data.pager.top).children('.clickable-pagination-item').remove();
        $(data.pager.top).attr('maxPages', maxPages);

        if (maxPages <= 1) {
            $(data.pager.top).addClass('hidden');
        } else {
            $(data.pager.top).removeClass('hidden');
        }
    }

    if (data.pager.bottom) {
        paginationClipping = parseInt($(data.pager.top).attr('itemprop').split('_')[1]);
        $(data.pager.bottom).children('.clickable-pagination-item').remove();
        $(data.pager.bottom).attr('maxPages', maxPages);

        if (maxPages <= 1) {
            $(data.pager.bottom).addClass('hidden');
        } else {
            $(data.pager.bottom).removeClass('hidden');
        }
    }

    var currentIndex = isNaN(getCurrentPaginationIndex()) ? 0 : getCurrentPaginationIndex();
    console.log(data, currentIndex);
    for (var i = 0; i < Math.min(paginationClipping, maxPages); i++) {
        var listItem;
        if (data.pager.top) {
            listItem = getPaginationItem(i + 1);
            $(listItem).insertBefore($(data.pager.top).find('#btn-next-page'));
        }
        if (data.pager.bottom) {
            listItem = getPaginationItem(i + 1);
            $(listItem).insertBefore($(data.pager.bottom).find('#btn-next-page'));
        }

        if (currentIndex !== null && currentIndex === i) {
            $(listItem).click();
        }
    }

    updatePagination();
}

function updatePagination() {
    var mainPager, secondPager;
    if (currentPaginationData.pager.top) {
        mainPager = currentPaginationData.pager.top;

        if (currentPaginationData.pager.bottom) {
            secondPager = currentPaginationData.pager.bottom;
        }
    } else if (currentPaginationData.pager.bottom) {
        mainPager = currentPaginationData.pager.bottom;
    }

    var currentMaxPages = parseInt($(mainPager).attr('maxPages'));
    var currentIndex = parseInt($(mainPager).find('.active').text()) - 1;

    if (currentIndex === 0 && currentMaxPages <= 1) {
        $(mainPager).find('#btn-first-page, #btn-previous-page').addClass('disabled');
        $(mainPager).find('#btn-last-page, #btn-next-page').addClass('disabled');

        if (secondPager !== undefined) {
            $(secondPager).find('#btn-first-page, #btn-previous-page').addClass('disabled');
            $(secondPager).find('#btn-last-page, #btn-next-page').addClass('disabled');
        }
    } else if (currentIndex === 0) {
        $(mainPager).find('#btn-first-page, #btn-previous-page').addClass('disabled');
        $(mainPager).find('#btn-last-page, #btn-next-page').removeClass('disabled');

        if (secondPager !== undefined) {
            $(secondPager).find('#btn-first-page, #btn-previous-page').addClass('disabled');
            $(secondPager).find('#btn-last-page, #btn-next-page').removeClass('disabled');
        }
    } else if (currentIndex === currentMaxPages - 1) {
        $(mainPager).find('#btn-first-page, #btn-previous-page').removeClass('disabled');
        $(mainPager).find('#btn-last-page, #btn-next-page').addClass('disabled');

        if (secondPager !== undefined) {
            $(secondPager).find('#btn-first-page, #btn-previous-page').removeClass('disabled');
            $(secondPager).find('#btn-last-page, #btn-next-page').addClass('disabled');
        }
    } else {
        $(mainPager).find('#btn-first-page, #btn-previous-page').removeClass('disabled');
        $(mainPager).find('#btn-last-page, #btn-next-page').removeClass('disabled');

        if (secondPager !== undefined) {
            $(secondPager).find('#btn-first-page, #btn-previous-page').removeClass('disabled');
            $(secondPager).find('#btn-last-page, #btn-next-page').removeClass('disabled');
        }
    }
}

function updatePaginationItems() {
    if (currentFilterData && currentFilterData.length > 0) {
        var maxElements = parseInt($(currentPaginationData.filter.countSelect).find('.chosen').attr('id').split('_')[1]);
        currentPaginationData.pager.dataLength = currentFilterData.length;
        currentPaginationData.pager.maxElements = maxElements;
        initPagination(currentPaginationData);
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

function getCurrentPaginationIndex() {
    if (currentPaginationData.pager.top) {
        return parseInt($(currentPaginationData.pager.top).find('.active').text()) - 1;
    } else if (currentPaginationData.pager.bottom) {
        return parseInt($(currentPaginationData.pager.bottom).find('.active').text()) - 1;
    }
    return null;
}

$(document).on('click', '.pagination li', function (event) {
    event.preventDefault();
    if (event.handled !== true && !$(this).hasClass('disabled'))
    {
        event.handled = true;

        var mainPager = null;
        var secondPager = null;
        var paginations = new Array();
        if (currentPaginationData.pager.top) {
            mainPager = currentPaginationData.pager.top;
            if (currentPaginationData.pager.bottom) {
                paginations.push(currentPaginationData.pager.bottom);
                secondPager = currentPaginationData.pager.bottom;
            }
        } else if (currentPaginationData.pager.bottom) {
            mainPager = currentPaginationData.pager.bottom;
        }
        paginations.push(mainPager);

        var maxPages = parseInt($(mainPager).attr('maxPages'));

        if (!$(this).hasClass('active') && $(this).hasClass('clickable-pagination-item')) {
            var newIndex = parseInt($(this).text()) - 1;

            for (var i = 0; i < paginations.length; i++) {
                var pagination = paginations[i];
                var numberedItems = $(pagination).find('.clickable-pagination-item');
                $(pagination).find('.active').removeClass('active');
                for (var j = 0; j < numberedItems.length; j++) {
                    var numberedItem = numberedItems[j];
                    var itemNumber = parseInt($(numberedItem).find('#index-text').text()) - 1;
                    if (itemNumber === newIndex) {
                        $(numberedItem).addClass('active');
                    }
                }
            }

            $(this).trigger('indexChanged', [newIndex]);
        } else {
            var direction = $(this).attr('id');
            var currentIndex = parseInt($(this).closest('.pagination').find('.active').text());
            switch (direction) {
                case 'btn-first-page':
                    shiftPaginationFirstPage(mainPager, secondPager);
                    break;
                case 'btn-previous-page':
                    var previousIndexButton = $(mainPager).find('.active').prev();
                    var previousIndexButtonTwo = $(secondPager).find('.active').prev();
                    if ($(previousIndexButton).hasClass('clickable-pagination-item')) {
                        $(previousIndexButton).click();
                        $(previousIndexButtonTwo).click();
                    } else if (currentIndex > 1) {
                        shiftPaginationBackward(mainPager, secondPager);
                    }
                    break;
                case 'btn-next-page':
                    var nextIndexButton = $(mainPager).find('.active').next();
                    var nextIndexButtonTwo = $(secondPager).find('.active').next();
                    if ($(nextIndexButton).hasClass('clickable-pagination-item')) {
                        $(nextIndexButton).click();
                        $(nextIndexButtonTwo).click();
                    } else if (currentIndex < maxPages) {
                        shiftPaginationForward(mainPager, secondPager);
                    }
                    break;
                case 'btn-last-page':
                    shiftPaginationLastPage(mainPager, secondPager);
                    break;
            }
        }

        updatePagination();
    }
});
function shiftPaginationForward(mainPager, secondPager) {
    if (mainPager) {
        var paginationItems;
        if (secondPager) {
            paginationItems = $(secondPager).find('.clickable-pagination-item');
            for (var i = 0; i < paginationItems.length; i++) {
                var item = paginationItems[i];
                $(item).find('#index-text').text(parseInt($(item).text()) + 1);
            }
        }

        paginationItems = $(mainPager).find('.clickable-pagination-item');
        for (var i = 0; i < paginationItems.length; i++) {
            var item = paginationItems[i];
            $(item).find('#index-text').text(parseInt($(item).text()) + 1);
        }
        $(mainPager).find('.active').removeClass('active').click();
    }
}

function shiftPaginationBackward(mainPager, secondPager) {
    if (mainPager) {
        var paginationItems;
        if (secondPager) {
            paginationItems = $(secondPager).find('.clickable-pagination-item');
            for (var i = 0; i < paginationItems.length; i++) {
                var item = paginationItems[i];
                $(item).find('#index-text').text(parseInt($(item).text()) - 1);
            }
        }

        paginationItems = $(mainPager).find('.clickable-pagination-item');
        for (var i = 0; i < paginationItems.length; i++) {
            var item = paginationItems[i];
            $(item).find('#index-text').text(parseInt($(item).text()) - 1);
        }
        $(mainPager).find('.active').removeClass('active').click();
    }
}

function shiftPaginationLastPage(mainPager, secondPager) {
    if (mainPager) {
        var maxPages = parseInt($(mainPager).attr('maxPages'));
        var paginationItems = $(mainPager).find('.clickable-pagination-item');
        paginationItems.removeClass('active');

        var secondPaginationItems;
        if (secondPager) {
            secondPaginationItems = $(secondPager).find('.clickable-pagination-item');
        }

        if (paginationItems.length !== maxPages) {
            var indexStart = (maxPages + 1) - paginationItems.length;
            for (var i = 0; i < paginationItems.length; i++) {
                var item = paginationItems[i];
                $(item).find('#index-text').text(indexStart);

                if (secondPaginationItems && secondPaginationItems.length > 0) {
                    var secondItem = secondPaginationItems[i];
                    $(secondItem).find('#index-text').text(indexStart);
                }
                indexStart++;
            }
        }
        $(mainPager).find('#btn-next-page').prev().click();
    }
}
function shiftPaginationFirstPage(mainPager, secondPager) {
    if (mainPager) {
        var maxPages = parseInt($(mainPager).attr('maxPages'));
        var paginationItems = $(mainPager).find('.clickable-pagination-item');
        paginationItems.removeClass('active');

        var secondPaginationItems;
        if (secondPager) {
            secondPaginationItems = $(secondPager).find('.clickable-pagination-item');
        }

        if (paginationItems.length !== maxPages) {
            for (var i = 0; i < paginationItems.length; i++) {
                var item = paginationItems[i];
                $(item).find('#index-text').text(i + 1);

                if (secondPaginationItems && secondPaginationItems.length > 0) {
                    var secondItem = secondPaginationItems[i];
                    $(secondItem).find('#index-text').text(i + 1);
                }
            }

        }
        $(mainPager).find('#btn-previous-page').next().click();
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
    if (!event.handled && !$(this).hasClass('active') && !$(this).hasClass('disabled')) {
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
            if (source[i].dimension !== DIMENSION_ANY && source[i].parameters.used === "used") {
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

$(document).on('click', '.btn-tag-as-favorite-gesture', function (event) {
    event.preventDefault();

    if (!event.handled) {
        event.handled = true;

        var assemble = false;
        var gestureId = $(this).closest('.root').attr('id');
        var thumbnail = $(this).closest('.panel');
        if (!$(this).hasClass('selected')) {
            $(this).addClass('selected btn-success');
            $(thumbnail).removeClass('panel-default').addClass('panel-success');
            $(this).find('root').addClass('selected');
            assemble = true;
        } else {
            $(this).removeClass('selected btn-success');
            $(thumbnail).removeClass('panel-success').addClass('panel-default');
            $(this).find('root').removeClass('selected');
        }

        $(this).trigger('change', [gestureId, assemble]);
    }
});

$(document).on('click', '.btn-untag-as-favorite-gesture', function (event) {
    event.preventDefault();

    if (!event.handled) {
        event.handled = true;
        var gestureId = $(this).closest('.root').attr('id');
        $(this).trigger('change', [gestureId]);
    }
});

//$(document).on('click', '.gesture-assemble, .gesture-assemble-description, .gesture-unassemble-description', function (event) {
//    event.preventDefault();
//
//    if (!event.handled) {
//        event.handled = true;
//        var thumbnail = $(this).closest('.gesture-thumbnail');
//
//        if (!$(thumbnail).hasClass('selected')) {
//            thumbnail.addClass('selected');
//            thumbnail.addClass('panel-success');
//            thumbnail.find('.gesture-assemble').addClass('btn-success');
//            thumbnail.find('.gesture-assemble-description').addClass('hidden');
//            thumbnail.find('.gesture-unassemble-description').removeClass('hidden');
//            thumbnail.find('#gesture-source, #gesture-scope').addClass('label-success');
//        } else {
//            thumbnail.removeClass('selected');
//            thumbnail.removeClass('panel-success');
//            thumbnail.find('.gesture-assemble').removeClass('btn-success');
//            thumbnail.find('.gesture-assemble-description').removeClass('hidden');
//            thumbnail.find('.gesture-unassemble-description').addClass('hidden');
//            thumbnail.find('#gesture-source, #gesture-scope').removeClass('label-success');
//        }
//
//
//    }
//});
//
//$(document).on('click', '.gesture-reassemble, .gesture-unassemble-description', function (event) {
//    event.preventDefault();
//    if (!event.handled) {
//        event.handled = true;
//        var thumbnail = $(this).closest('.gesture-thumbnail');
//        var gestureId = thumbnail.attr('id');
//        reassembleGesture(gestureId);
//        saveData();
//        originalFilterData = assembledGestures();
//        if (originalFilterData && originalFilterData.length > 0) {
//            checkPagination($('#custom-pager .pagination'), originalFilterData.length, parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]));
//        } else {
//            checkPagination($('#custom-pager .pagination'), 0, parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]));
//        }
//        renderData(sort());
//    }
//});



/*
 * sorting
 */

var originalFilterData = null;
var currentFilterData = null;

function sort() {
    var array = filter($(currentPaginationData.filter.filter).find('.chosen').attr('id'));
    var sortType = $(currentPaginationData.filter.sort).find('.chosen').attr('id');

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
        scope = $(currentPaginationData.filter.filter).find('.chosen').attr('id');
    }

    if (scope === 'all') {
        return originalFilterData;
    } else if (originalFilterData && originalFilterData.length > 0) {
        for (var i = 0; i < originalFilterData.length; i++) {
            if (scope === SOURCE_GESTURE_RECORDED && originalFilterData[i].isOwner === true) {
                if (originalFilterData[i].source === SOURCE_GESTURE_EVALUATOR) {
                    array.push(originalFilterData[i]);
                }
            } else if (originalFilterData[i].scope === scope || originalFilterData[i].source === scope) {
                array.push(originalFilterData[i]);
            } else if (originalFilterData[i].data && originalFilterData[i].data.generalData && (originalFilterData[i].data.generalData.phase === scope || originalFilterData[i].data.generalData.surveyType === scope)) {
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
    if (!event.handled &&
            event.keyCode !== 16 &&
            event.keyCode !== 9 &&
            event.keyCode !== 20 &&
            event.keyCode !== 18 &&
            event.keyCode !== 91 &&
            event.keyCode !== 32 &&
            event.keyCode !== 93 &&
            event.keyCode !== 37 &&
            event.keyCode !== 38 &&
            event.keyCode !== 39 &&
            event.keyCode !== 40
            ) {
        event.handled = true;

        if ($(this).hasClass('save-data')) {
            saveData();
        }

        var filter = $(this).val();
        var container = currentFilterList;
        if (filter.trim() !== "" && event.keyCode !== 27) {
            var matched = searchThroughArray(sort(), filter.trim());
            if (matched.length > 0) {
                container.removeClass('hidden');
//                $('#pager-top').removeClass('hidden');
//                $('#pager-bottom').removeClass('hidden');
                removeAlert(container.closest('#item-view'), ALERT_NO_SEARCH_RESULTS);
                currentFilterData = matched;
                updatePaginationItems();
                renderData(matched);
            } else {
                container.addClass('hidden');
//                $('#pager-top').addClass('hidden');
//                $('#pager-bottom').addClass('hidden');
                appendAlert(container.closest('#item-view'), ALERT_NO_SEARCH_RESULTS);
            }
        } else {
            container.removeClass('hidden');
            removeAlert(container.closest('#item-view'), ALERT_NO_SEARCH_RESULTS);
            currentFilterData = sort();
            updatePaginationItems();
            renderData(currentFilterData);

            if (event.keyCode === 27) {
                $(this).val('');
            }
        }
    }
});

function searchThroughArray(array, filter) {
    var result = new Array();
    for (var i = 0; i < array.length; i++) {
        if (array[i].title && array[i].title.search(new RegExp(filter, "i")) > -1) {
            result.push(array[i]);
        } else if (array[i].data && array[i].data.generalData && array[i].data.generalData.title && array[i].data.generalData.title.search(new RegExp(filter, "i")) > -1) {
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
    if (data) {
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

    return null;
}


/*
 * time and date functions
 */

function addDays(date, amount) {
    return new Date(new Date(date).getTime() + (1000 * 60 * 60 * 24 * amount));
}

function rangeDays(dateFrom, dateTo) {
    return Math.round((dateTo - dateFrom) / (1000 * 60 * 60 * 24)) + 1;
}

function convertSQLTimestampToDate(sqlTimestamp) {
    var t = sqlTimestamp.split(/[- :]/);

    // Apply each element to the Date function
    return new Date(t[0], t[1] - 1, t[2], t[3], t[4], t[5]);
}

function getTimeLeftForTimestamp(timestamp) {
    var dateNow = new Date();
    var seconds = Math.floor((timestamp - (dateNow)) / 1000);
    var minutes = Math.floor(seconds / 60);
    var hours = Math.floor(minutes / 60);
    var days = Math.floor(hours / 24);
    hours = hours - (days * 24);
    minutes = minutes - (days * 24 * 60) - (hours * 60);
    seconds = seconds - (days * 24 * 60 * 60) - (hours * 60 * 60) - (minutes * 60);
    return {days: days, hours: hours, minutes: minutes, seconds: seconds};
}

function getTimeBetweenTimestamps(timestampA, timestampB) {
    timestampA = parseInt(timestampA);
    timestampB = parseInt(timestampB);
    var a = timestampB > timestampA ? timestampB : timestampA;
    var b = timestampB > timestampA ? timestampA : timestampB;

    if (timestampB === timestampA) {
        return 0;
    }

    var milliseconds = Math.round(((a - b) / 1000) % 1 * 1000);
    var seconds = Math.floor((a - b) / 1000);
    var minutes = Math.floor(seconds / 60);
    var hours = Math.floor(minutes / 60);
    var days = Math.floor(hours / 24);

    hours = hours - (days * 24);
    minutes = minutes - (days * 24 * 60) - (hours * 60);
    seconds = seconds - (days * 24 * 60 * 60) - (hours * 60 * 60) - (minutes * 60);

    var object = new Object;
    if (days > 0) {
        object.days = days;
    }

    if (hours > 0) {
        object.hours = hours;
    }

    if (minutes > 0) {
        object.minutes = minutes;
    }

    if (seconds > 0) {
        object.seconds = seconds;
    }

    if (milliseconds > 0) {
        object.milliseconds = milliseconds;
    }

    return object;
}

function calculateAge(birthday) { // birthday is a date
    var ageDifMs = Date.now() - birthday.getTime();
    var ageDate = new Date(ageDifMs); // miliseconds from epoch
    return Math.abs(ageDate.getUTCFullYear() - 1970);
}

function calculateAgeRangeForGender(raw, gender) { // birthday is a date
    var minAge = null;
    var maxAge = null;
    if (raw && raw.length > 0) {
        for (var i = 0; i < raw.length; i++) {
            var age = calculateAge(new Date(parseInt(raw[i].birthday) * 1000));
            if (gender === raw[i].gender || gender === 'identical') {
                if (age < minAge || minAge === null) {
                    minAge = age;
                }
                if (age > maxAge) {
                    maxAge = age;
                }
            }
        }
    }
    return {min: minAge, max: maxAge};
}

function getSeconds(executionTime) {
    var seconds = 0;
    if (executionTime.days) {
        seconds += 60 * 60 * 24 * executionTime.days;
    }

    if (executionTime.hours) {
        seconds += 60 * 60 * executionTime.hours;
    }

    if (executionTime.minutes) {
        seconds += 60 * executionTime.minutes;
    }

    if (executionTime.seconds > 0) {
        seconds += executionTime.seconds;
    }
//    console.log(seconds, executionTime);
    return seconds;
}

function isEmpty(obj) {
    var length = Object.getOwnPropertyNames(obj).length;
    if (length > 0) {
        if (length > 1) {
            return false;
        } else {
            for (var key in obj) {
                if (length === 1 && key === 'milliseconds') {
                    return true;
                }
            }
        }
    }
    return true;
}

function getTimeString(object, short, milliseconds) {
    var timeString = '';
    for (var key in object) {
        if (key !== 'milliseconds' || milliseconds === true) {
            if (short) {
                timeString += object[key] + ' ' + translation.timesShort[key] + ' ';
            } else {
                if (parseInt(object[key]) === 1) {
                    timeString += object[key] + ' ' + translation.timesSingular[key] + ' ';
                } else {
                    timeString += object[key] + ' ' + translation.times[key] + ' ';
                }
            }
        }
    }

    return timeString;
}



var currentPreviewGesture = null;
var gesturePreviewOpened = false;
var gesturePreviewDeleteable = true;
function getGestureCatalogListThumbnail(data, typeId, layout, source, panelStyle, modalId) {
    if (!source || source === null || source === undefined) {
        source = GESTURE_CATALOG;
    }

    var clone;
    if (typeId && typeId !== null) {
        clone = $('#' + typeId).clone().removeClass('hidden').removeAttr('id');
    } else {
        clone = $('#gestures-catalog-thumbnail').clone().removeClass('hidden').removeAttr('id');
    }
    clone.attr('id', data.id);
    clone.find('.title-text').text(data.title + " ");
    clone.find('#title .text').text(data.title);
    clone.find('#gesture-scope .label-text').text(translation.gestureScopes[data.scope]);
    clone.find('#gesture-scope #' + data.scope).removeClass('hidden');


    if (panelStyle) {
        clone.find('.panel').removeClass('panel-default').addClass(panelStyle);
    }

    if (layout) {
        clone.addClass(layout);
    } else {
        clone.addClass('col-xs-6 col-sm-4 col-lg-3');
    }

    if (data.isOwner === true) {
        if (data.source === SOURCE_GESTURE_EVALUATOR) {
            clone.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_OWN]);
            clone.find('#gesture-source #' + SOURCE_GESTURE_OWN).removeClass('hidden');
        } else {
            clone.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_TESTER]);
            clone.find('#gesture-source #' + SOURCE_GESTURE_TESTER).removeClass('hidden');
        }
    } else {
        if (data.source === SOURCE_GESTURE_EVALUATOR) {
            clone.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_EVALUATOR]);
            clone.find('#gesture-source #' + SOURCE_GESTURE_EVALUATOR).removeClass('hidden');
        } else {
            clone.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_TESTER]);
            clone.find('#gesture-source #' + SOURCE_GESTURE_TESTER).removeClass('hidden');
        }
    }

    if (!clone.hasClass('deleteable')) {
        gesturePreviewDeleteable = false;
    }

    renderGestureImages(clone.find('.previewGesture'), data.images, data.previewImage, null);

    $(clone).find('.panel').mouseenter(function (event) {
        event.preventDefault();
        if (gesturePreviewOpened === false) {
            playThroughThumbnails($(this).find('.previewGesture'), 0);
        }
    });

    $(clone).find('.panel').mouseleave(function (event) {
        event.preventDefault();
        if (gesturePreviewOpened === false) {
            resetThumbnails($(this).find('.previewGesture'));
        }
    });

    $(clone).find('#btn-show-gesture-info').click({gesture: data, clone: clone}, function (event) {
        event.preventDefault();
        resetThumbnails($(event.data.clone).find('.previewGesture'));
        currentPreviewGesture = {gesture: event.data.gesture, source: source};
        gesturePreviewOpened = true;
        $(clone).find('#btn-stop-gesture').click();

        $('#custom-modal').on('gesture-deleted', function () {
            checkPagination($('#custom-pager .pagination'), currentFilterData.length, parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]));
            renderData(currentFilterData);
        });
//        console.log('open modal', modalId);
        if (modalId) {
            loadHTMLintoModal('custom-modal', modalId + '.php', 'modal-lg');
        } else {
            loadHTMLintoModal('custom-modal', 'modal-gesture.php', 'modal-lg');
        }
    });

    if (data.isOwner) {
        var shareButton = $(clone).find('#btn-share-gesture');
        if (data.scope === SCOPE_GESTURE_PRIVATE) {
            shareButton.removeClass('unshare-gesture').addClass('share-gesture');
            shareButton.find('.fa').removeClass('fa-lock').addClass('fa-share-alt');
            shareButton.find('.btn-text').text(translation.share);
        } else {
            shareButton.removeClass('share-gesture').addClass('unshare-gesture');
            shareButton.find('.fa').removeClass('fa-share-alt').addClass('fa-lock');
            shareButton.find('.btn-text').text(translation.unshare);
        }
    } else {
        $(clone).find('#btn-share-gesture').parent().remove();
    }

    $(clone).find('#btn-share-gesture').click({gestureId: data.id}, function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(this).addClass('disabled');
            var button = $(this);
            var updateList = false;

            if ($(this).hasClass('share-gesture')) {
                showCursor($('body'), CURSOR_PROGRESS);

                if ($(this).hasClass('update-list-view')) {
                    updateList = true;
                }

                shareGesture({gestureId: event.data.gestureId}, function (result) {
                    showCursor($('body'), CURSOR_DEFAULT);
                    $(button).removeClass('disabled');
                    if (result.status === RESULT_SUCCESS) {
                        $(button).removeClass('share-gesture').addClass('unshare-gesture');
                        $(button).find('.fa').removeClass('fa-share-alt').addClass('fa-lock');
                        $(button).find('.btn-text').text(translation.unshare);
                        clone.find('#gesture-scope .label-text').text(translation.gestureScopes[SCOPE_GESTURE_PUBLIC]);
                        clone.find('#gesture-scope .fa').addClass('hidden');
                        clone.find('#gesture-scope #' + SCOPE_GESTURE_PUBLIC).removeClass('hidden');

                        updateGestureById(source, result.id, {scope: 'public'});

                        // check if this is needed after updateGesture() call
                        if (updateList === true) {
                            getGestureCatalog(function (result) {
                                if (result.status === RESULT_SUCCESS) {
                                    originalFilterData = result.gestures;
//                                        currentFilterData = sort();
                                }
                            });
                        }
                    }
                });
            } else if ($(this).hasClass('unshare-gesture')) {
                showCursor($('body'), CURSOR_PROGRESS);
                unshareGesture({gestureId: event.data.gestureId}, function (result) {
                    showCursor($('body'), CURSOR_DEFAULT);
                    $(button).removeClass('disabled');
                    if (result.status === RESULT_SUCCESS) {
                        $(button).removeClass('unshare-gesture').addClass('share-gesture');
                        $(button).find('.fa').removeClass('fa-lock').addClass('fa-share-alt');
                        $(button).find('.btn-text').text(translation.share);
                        clone.find('#gesture-scope .label-text').text(translation.gestureScopes[SCOPE_GESTURE_PRIVATE]);
                        clone.find('#gesture-scope .fa').addClass('hidden');
                        clone.find('#gesture-scope #' + SCOPE_GESTURE_PRIVATE).removeClass('hidden');

                        updateGestureById(source, result.id, {scope: 'private'});

                        // check if this is needed after updateGesture() call
                        if (updateList === true) {
                            getGestureCatalog(function (result) {
                                if (result.status === RESULT_SUCCESS) {
                                    originalFilterData = result.gestures;
//                                        currentFilterData = sort();
                                }
                            });
                        }
                    }
                });
            }
        }
    });

    $(clone).find('#btn-unshare-gesture').click(function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(this).addClass('disabled');
        }
    });

    return clone;
}

function getCreateStudyGestureListThumbnail(data, typeId, layout, source, panelStyle, modalId) {
    if (!source || source === null || source === undefined) {
        source = GESTURE_CATALOG;
    }

    var clone;
    if (typeId && typeId !== null) {
        clone = $('#' + typeId).clone().removeClass('hidden').removeAttr('id');
    } else {
        clone = $('#gestures-catalog-thumbnail').clone().removeClass('hidden').removeAttr('id');
    }
    clone.attr('id', data.id);
    clone.find('.title-text').text(data.title + " ");
    clone.find('#title .text').text(data.title);
//    clone.find('#gesture-scope .label-text').text(translation.gestureScopes[data.scope]);
//    clone.find('#gesture-scope #' + data.scope).removeClass('hidden');


    if (panelStyle) {
        clone.find('.panel').removeClass('panel-default').addClass(panelStyle);
    }

    if (layout) {
        clone.addClass(layout);
    } else {
        clone.addClass('col-xs-6 col-sm-4 col-lg-3');
    }

//    if (data.isOwner === true) {
//        if (data.source === SOURCE_GESTURE_EVALUATOR) {
//            clone.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_OWN]);
//            clone.find('#gesture-source #' + SOURCE_GESTURE_OWN).removeClass('hidden');
//        } else {
//            clone.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_TESTER]);
//            clone.find('#gesture-source #' + SOURCE_GESTURE_TESTER).removeClass('hidden');
//        }
//    } else {
//        if (data.source === SOURCE_GESTURE_EVALUATOR) {
//            clone.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_EVALUATOR]);
//            clone.find('#gesture-source #' + SOURCE_GESTURE_EVALUATOR).removeClass('hidden');
//        } else {
//            clone.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_TESTER]);
//            clone.find('#gesture-source #' + SOURCE_GESTURE_TESTER).removeClass('hidden');
//        }
//    }

    if (!clone.hasClass('deleteable')) {
        gesturePreviewDeleteable = false;
    }

    renderGestureImages(clone.find('.previewGesture'), data.images, data.previewImage, null);

    $(clone).find('.panel').mouseenter(function (event) {
        event.preventDefault();
        if (gesturePreviewOpened === false) {
            playThroughThumbnails($(this).find('.previewGesture'), 0);
        }
    });

    $(clone).find('.panel').mouseleave(function (event) {
        event.preventDefault();
        if (gesturePreviewOpened === false) {
            resetThumbnails($(this).find('.previewGesture'));
        }
    });

    $(clone).find('#btn-show-gesture-info').click({gesture: data, clone: clone}, function (event) {
        event.preventDefault();
        resetThumbnails($(event.data.clone).find('.previewGesture'));
        currentPreviewGesture = {gesture: event.data.gesture, source: source};
        gesturePreviewOpened = true;
        $(clone).find('#btn-stop-gesture').click();

        $('#custom-modal').on('gesture-deleted', function () {
            checkPagination($('#custom-pager .pagination'), currentFilterData.length, parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]));
            renderData(currentFilterData);
        });

        $(this).trigger('openGestureInfo');
    });

    return clone;
}

function getGestureElicitationListThumbnail(clone, data, layout, source) {
    clone.attr('id', data.id);
    clone.find('.title-text').text(data.title + " ");
    clone.find('#title .text').text(data.title);

    if (!source) {
        source = ASSEMBLED_GESTURE_SET;
    }

    if (layout) {
        clone.addClass(layout);
    } else {
        clone.addClass('col-xs-6 col-sm-4 col-lg-3');
    }

    if (!clone.hasClass('deleteable')) {
        gesturePreviewDeleteable = false;
    }

    renderGestureImages(clone.find('.previewGesture'), data.images, data.previewImage, null);

    $(clone).find('.panel').mouseenter(function (event) {
        event.preventDefault();
        if (gesturePreviewOpened === false) {
            playThroughThumbnails($(this).find('.previewGesture'), 0);
        }
    });

    $(clone).find('.panel').mouseleave(function (event) {
        event.preventDefault();
        if (gesturePreviewOpened === false) {
            resetThumbnails($(this).find('.previewGesture'));
        }
    });

    $(clone).find('#btn-show-gesture-info').click({gesture: data, clone: clone, source: source}, function (event) {
        event.preventDefault();
        resetThumbnails($(event.data.clone).find('.previewGesture'));
        currentPreviewGesture = event.data;
        gesturePreviewOpened = true;
        $(clone).find('#btn-stop-gesture').click();
        loadHTMLintoModal('custom-modal', 'modal-gesture-rudimentary.php', 'modal-lg');
    });

    return clone;
}

function getGestureElicitationListThumbnail(clone, data, layout, source) {
    clone.attr('id', data.id);
    clone.find('.title-text').text(data.title + " ");
    clone.find('#title .text').text(data.title);

    if (!source) {
        source = ASSEMBLED_GESTURE_SET;
    }

    if (layout) {
        clone.addClass(layout);
    } else {
        clone.addClass('col-xs-6 col-sm-4 col-lg-3');
    }

    if (!clone.hasClass('deleteable')) {
        gesturePreviewDeleteable = false;
    }

    renderGestureImages(clone.find('.previewGesture'), data.images, data.previewImage, null);

    $(clone).find('.panel').mouseenter(function (event) {
        event.preventDefault();
        if (gesturePreviewOpened === false) {
            playThroughThumbnails($(this).find('.previewGesture'), 0);
        }
    });

    $(clone).find('.panel').mouseleave(function (event) {
        event.preventDefault();
        if (gesturePreviewOpened === false) {
            resetThumbnails($(this).find('.previewGesture'));
        }
    });

    $(clone).find('#btn-show-gesture-info').click({gesture: data, clone: clone, source: source}, function (event) {
        event.preventDefault();
        resetThumbnails($(event.data.clone).find('.previewGesture'));
        currentPreviewGesture = event.data;
        gesturePreviewOpened = true;
        $(clone).find('#btn-stop-gesture').click();
        loadHTMLintoModal('custom-modal', 'modal-gesture-rudimentary.php', 'modal-lg');
    });

    return clone;
}

function getSimpleGestureListThumbnail(clone, data, layout, panelStyle) {
    clone.attr('id', data.id);
    clone.find('.title-text').text(data.title + " ");
    clone.find('#title .text').text(data.title);
    clone.find('#gesture-scope .label-text').text(translation.gestureScopes[data.scope]);
    clone.find('#gesture-scope #' + data.scope).removeClass('hidden');

    if (layout) {
        clone.addClass(layout);
    } else {
        clone.addClass('col-xs-6 col-sm-4 col-lg-3');
    }

    if (panelStyle) {
        clone.find('.panel').removeClass('panel-default').addClass(panelStyle);
    }

    if (data.isOwner === true) {
        if (data.source === SOURCE_GESTURE_EVALUATOR) {
            clone.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_OWN]);
            clone.find('#gesture-source #' + SOURCE_GESTURE_OWN).removeClass('hidden');
        } else {
            clone.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_TESTER]);
            clone.find('#gesture-source #' + SOURCE_GESTURE_TESTER).removeClass('hidden');
        }
    } else {
        if (data.source === SOURCE_GESTURE_EVALUATOR) {
            clone.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_EVALUATOR]);
            clone.find('#gesture-source #' + SOURCE_GESTURE_EVALUATOR).removeClass('hidden');
        } else {
            clone.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_TESTER]);
            clone.find('#gesture-source #' + SOURCE_GESTURE_TESTER).removeClass('hidden');
        }
    }

    if (!clone.hasClass('deleteable')) {
        gesturePreviewDeleteable = false;
    }

    renderGestureImages(clone.find('.previewGesture'), data.images, data.previewImage, null);

    $(clone).find('.panel').mouseenter(function (event) {
        event.preventDefault();
        if (gesturePreviewOpened === false) {
            playThroughThumbnails($(this).find('.previewGesture'), 0);
        }
    });

    $(clone).find('.panel').mouseleave(function (event) {
        event.preventDefault();
        if (gesturePreviewOpened === false) {
            resetThumbnails($(this).find('.previewGesture'));
        }
    });

//    $(clone).find('#btn-show-gesture-info').click({gesture: data, clone: clone}, function (event) {
//        event.preventDefault();
//        resetThumbnails($(event.data.clone).find('.previewGesture'));
//        currentPreviewGesture = event.data.gesture;
//        gesturePreviewOpened = true;
//        $(clone).find('#btn-stop-gesture').click();
//
//        $('#custom-modal').on('gesture-deleted', function () {
//            checkPagination($('#custom-pager .pagination'), currentFilterData.length, parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]));
//            renderData(currentFilterData);
//        });
//
//        loadHTMLintoModal('custom-modal', 'modal-gesture-rudimentary.php', 'modal-lg');
//    });

//    if (data.isOwner) {
//        var shareButton = $(clone).find('#btn-share-gesture');
//        if (data.scope === SCOPE_GESTURE_PRIVATE) {
//            shareButton.removeClass('unshare-gesture').addClass('share-gesture');
//            shareButton.find('.fa').removeClass('fa-lock').addClass('fa-share-alt');
//            shareButton.find('.btn-text').text(translation.share);
//        } else {
//            shareButton.removeClass('share-gesture').addClass('unshare-gesture');
//            shareButton.find('.fa').removeClass('fa-share-alt').addClass('fa-lock');
//            shareButton.find('.btn-text').text(translation.unshare);
//        }
//    } else {
//        $(clone).find('#btn-share-gesture').parent().remove();
//    }
//
//    $(clone).find('#btn-share-gesture').click({gestureId: data.id}, function (event) {
//        event.preventDefault();
//        if (!$(this).hasClass('disabled')) {
//            $(this).addClass('disabled');
//            var button = $(this);
//            var updateList = false;
//
//            if ($(this).hasClass('share-gesture')) {
//                showCursor($('body'), CURSOR_PROGRESS);
//
//                if ($(this).hasClass('update-list-view')) {
//                    updateList = true;
//                }
//
//                shareGesture({gestureId: event.data.gestureId}, function (result) {
//                    showCursor($('body'), CURSOR_DEFAULT);
//                    $(button).removeClass('disabled');
//                    if (result.status === RESULT_SUCCESS) {
//                        $(button).removeClass('share-gesture').addClass('unshare-gesture');
//                        $(button).find('.fa').removeClass('fa-share-alt').addClass('fa-lock');
//                        $(button).find('.btn-text').text(translation.unshare);
//                        clone.find('#gesture-scope .label-text').text(translation.gestureScopes[SCOPE_GESTURE_PUBLIC]);
//                        clone.find('#gesture-scope .fa').addClass('hidden');
//                        clone.find('#gesture-scope #' + SCOPE_GESTURE_PUBLIC).removeClass('hidden');
//
//                        updateGestureById(result.id, {scope: 'public'});
//
//                        // check if this is needed after updateGesture() call
//                        if (updateList === true) {
//                            getGestureCatalog(function (result) {
//                                if (result.status === RESULT_SUCCESS) {
//                                    originalFilterData = result.gestures;
////                                        currentFilterData = sort();
//                                }
//                            });
//                        }
//                    }
//                });
//            } else if ($(this).hasClass('unshare-gesture')) {
//                showCursor($('body'), CURSOR_PROGRESS);
//                unshareGesture({gestureId: event.data.gestureId}, function (result) {
//                    showCursor($('body'), CURSOR_DEFAULT);
//                    $(button).removeClass('disabled');
//                    if (result.status === RESULT_SUCCESS) {
//                        $(button).removeClass('unshare-gesture').addClass('share-gesture');
//                        $(button).find('.fa').removeClass('fa-lock').addClass('fa-share-alt');
//                        $(button).find('.btn-text').text(translation.share);
//                        clone.find('#gesture-scope .label-text').text(translation.gestureScopes[SCOPE_GESTURE_PRIVATE]);
//                        clone.find('#gesture-scope .fa').addClass('hidden');
//                        clone.find('#gesture-scope #' + SCOPE_GESTURE_PRIVATE).removeClass('hidden');
//
//                        updateGestureById(result.id, {scope: 'private'});
//
//                        // check if this is needed after updateGesture() call
//                        if (updateList === true) {
//                            getGestureCatalog(function (result) {
//                                if (result.status === RESULT_SUCCESS) {
//                                    originalFilterData = result.gestures;
////                                        currentFilterData = sort();
//                                }
//                            });
//                        }
//                    }
//                });
//            }
//        }
//    });
//
//    $(clone).find('#btn-unshare-gesture').click(function (event) {
//        event.preventDefault();
//        if (!$(this).hasClass('disabled')) {
//            $(this).addClass('disabled');
//        }
//    });

    return clone;
}


function getStudiesCatalogListThumbnail(data) {
    var clone = $('#studies-catalog-thumbnail').clone().removeClass('hidden').removeAttr('id');
    if (data.data) {

        clone.attr('id', data.id);
        clone.find('.title-text').text(data.data.generalData.title);

        if (data.data.generalData.panelSurvey === 'yes') {
            $(clone).find('#panel-survey').removeClass('hidden');
        }

        if ((data.data.generalData.dateFrom !== null && data.data.generalData.dateFrom !== "") &&
                (data.data.generalData.dateTo !== null && data.data.generalData.dateTo !== "")) {

            var dateFrom = data.data.generalData.dateFrom * 1000;
            var dateTo = addDays(data.data.generalData.dateTo * 1000, 1);
            var totalDays = rangeDays(dateFrom, dateTo);

            var now = new Date().getTime();
            var progress = 0;
            $(clone).find('#study-range-days .address').text(translation.studyRun + ": ");

            if (now > dateFrom && now < dateTo) {
                var left = getTimeLeftForTimestamp(addDays(dateTo, 1));
                var daysExpired = Math.round((now - dateFrom) / (1000 * 60 * 60 * 24));
                progress = daysExpired / totalDays * 100;
                $(clone).find('.study-started').removeClass('hidden').find('.text').text(translation.studyStarted + ', ' + translation.still + ' ' + left.days + ' ' + (left.days + 1 === 1 ? translation.day : translation.days) + ', ' + left.hours + ' ' + (left.hours === 1 ? translation.hour : translation.hours));
                $(clone).find('.progress-bar').addClass('progress-bar-info');
            } else if (now < dateFrom) {
                progress = 100;
                var daysToStart = Math.round((dateFrom - now) / (1000 * 60 * 60 * 24));
                $(clone).find('.study-not-started').removeClass('hidden').find('.text').text(translation.studyNotStarted + ', ' + translation.startsAt + ' ' + daysToStart + ' ' + (daysToStart === 1 ? translation.day : translation.daysn));
                $(clone).find('.progress-bar').addClass('progress-bar-warning');
            } else if (now > dateTo) {
                progress = 100;
                $(clone).find('#study-range-days .address').text(translation.studyRuns + ": ");
                $(clone).find('.study-ended').removeClass('hidden').find('.text').text(translation.studyEnded);
                $(clone).find('.progress-bar').addClass('progress-bar-success');
            }

            $(clone).find('.progress-bar').css({width: progress + "%"});
            $(clone).find('#study-range-days .text').text(totalDays + ' ' + (parseInt(totalDays) === 1 ? translation.day : translation.days));

            if (now > dateFrom && now < dateTo) {
                TweenMax.from($(clone).find('.progress-bar'), 1, {delay: .3, width: "0%", opacity: 0});
            }
        } else {
            $(clone).find('#study-range-days .address').text(translation.studyRun + ": ");
            $(clone).find('#study-range-days .text').text('0 ' + translation.days);
            $(clone).find('.study-no-plan').removeClass('hidden').find('.text').text(translation.studyNoPlan);
            $(clone).find('.progress-bar').addClass('progress-bar-danger');
        }

        $(clone).find('#type-survey').text(translation.surveyType[data.data.generalData.surveyType]);
        $(clone).find('#type-phase').text(translation.phaseType[data.data.generalData.phase]);
    }

    return clone;
}

function getStudiesCatalogListTesterThumbnail(data) {
    var clone = $('#studies-catalog-thumbnail').clone().removeClass('hidden').removeAttr('id');
    if (data.data) {

        clone.attr('id', data.id);
        clone.find('.title-text').text(data.data.generalData.title);

//        if (data.data.generalData.panelSurvey === 'yes') {
//            $(clone).find('#panel-survey').removeClass('hidden');
//        }

        if ((data.data.generalData.dateFrom !== null && data.data.generalData.dateFrom !== "") &&
                (data.data.generalData.dateTo !== null && data.data.generalData.dateTo !== "")) {

            var dateFrom = data.data.generalData.dateFrom * 1000;
            var dateTo = addDays(data.data.generalData.dateTo * 1000, 1);
            var totalDays = rangeDays(dateFrom, dateTo);

            var now = new Date().getTime();
            var progress = 0;
            $(clone).find('#study-range-days .address').text(translation.studyRun + ": ");

            if (now > dateFrom && now < dateTo) {
                var left = getTimeLeftForTimestamp(addDays(dateTo, 1));
                var daysExpired = Math.round((now - dateFrom) / (1000 * 60 * 60 * 24));
                progress = daysExpired / totalDays * 100;
                $(clone).find('.study-started').removeClass('hidden').find('.text').text(translation.studyStarted + ', ' + translation.still + ' ' + left.days + ' ' + (left.days === 1 ? translation.day : translation.days) + ', ' + left.hours + ' ' + (left.hours === 1 ? translation.hour : translation.hours));
                $(clone).find('.progress-bar').addClass('progress-bar-info');
            } else if (now < dateFrom) {
                progress = 100;
                var daysToStart = Math.round((dateFrom - now) / (1000 * 60 * 60 * 24));
                $(clone).find('.study-not-started').removeClass('hidden').find('.text').text(translation.studyNotStarted + ', ' + translation.startsAt + ' ' + daysToStart + ' ' + (daysToStart === 1 ? translation.day : translation.daysn));
                $(clone).find('.progress-bar').addClass('progress-bar-warning');
            } else if (now > dateTo) {
                progress = 100;
                $(clone).find('#study-range-days .address').text(translation.studyRuns + ": ");
                $(clone).find('.study-ended').removeClass('hidden').find('.text').text(translation.studyEnded);
                $(clone).find('.progress-bar').addClass('progress-bar-success');
            }

            $(clone).find('.progress-bar').css({width: progress + "%"});
            $(clone).find('#study-range-days .text').text(totalDays + ' ' + (parseInt(totalDays) === 1 ? translation.day : translation.days));

            if (now > dateFrom && now < dateTo) {
                TweenMax.from($(clone).find('.progress-bar'), 1, {delay: .3, width: "0%", opacity: 0});
            }
        } else {
            $(clone).find('#study-range-days .text').text('0 ' + translation.days);
            $(clone).find('.study-no-plan').removeClass('hidden').find('.text').text(translation.studyNoPlan);
            $(clone).find('.progress-bar').addClass('progress-bar-danger');
        }

        $(clone).find('#type-survey').text(translation.surveyType[data.data.generalData.surveyType]);
        $(clone).find('#type-phase').text(translation.phaseType[data.data.generalData.phase]);
    }

    return clone;
}



// sound audio player handling
$(document).on('click', '.audioPlayer #play', function (event) {
    event.preventDefault();
    if (!event.handled) {
        event.handled = true;
        var audioElement = $(this).closest('.audioPlayer').find('.audio-holder')[0];
        audioElement.play();
    }
});
$(document).on('click', '.audioPlayer #pause', function (event) {
    event.preventDefault();
    if (!event.handled) {
        event.handled = true;
        var audioElement = $(this).closest('.audioPlayer').find('.audio-holder')[0];
        audioElement.pause();
    }
});
$(document).on('click', '.audioPlayer #stop', function (event) {
    event.preventDefault();
    if (!event.handled) {
        event.handled = true;
        var audioElement = $(this).closest('.audioPlayer').find('.audio-holder')[0];
        audioElement.pause();
        audioElement.currentTime = 0;
    }
});


// webRTC specific functions
function isWebRTCNeeded() {
    var phaseSteps = getContextualPhaseSteps();
    if (phaseSteps && phaseSteps.length > 0) {
        for (var i = 0; i < phaseSteps.length; i++) {
            if (isWebRTCNeededForPhaseStep(phaseSteps[i])) {
                return true;
            }
        }
    }
    return false;
}

function isWebRTCNeededForPhaseStep(phaseStep) {
    if (phaseStep) {

        var options = getPhaseStepOptions(phaseStep.format);
//        console.log(options);

//        if (phaseStep.format === IDENTIFICATION) {
//            var phaseData = getLocalItem(phaseStep.id + '.data');
////            console.log(phaseData);
//            if (phaseData.identificationFor === 'gestures') {
//                return true;
//            }
//        } else {
        if (options.tester.stream === 'yes' || options.tester.visualizeStream === 'yes' || options.tester.recordStream === 'yes') {
            return true;
        }
//        }
    }
    return false;
}

function isUploadRecordingNeeded() {
    var phaseSteps = getContextualPhaseSteps();
    if (phaseSteps && phaseSteps.length > 0) {
        for (var i = 0; i < phaseSteps.length; i++) {
            if (isUploadRecordingNeededForPhaseStep(phaseSteps[i])) {
                return true;
            }
        }
    }
    return false;
}

function isUploadRecordingNeededForPhaseStep(phaseStep) {
    if (phaseStep) {
        var options = getPhaseStepOptions(phaseStep.format);

        if (options.tester.recordStream === 'yes' && currentView === VIEW_TESTER) {
            return true;
        } else if (options.moderator.recordStream === 'yes' && currentView === VIEW_MODERATOR) {
            return true;
        }
    }
    return false;
}

function getPhaseStepOptions(format) {
    var surveyType = getLocalItem(STUDY).surveyType;
    return translation.formats[format][surveyType];
}

function isWebRTCNeededInFuture() {
    var currentPhase = getCurrentPhase();
    var phaseSteps = getContextualPhaseSteps();
    if (currentPhase && phaseSteps && phaseSteps.length > 0) {
        var futureSteps = false;
        for (var i = 0; i < phaseSteps.length; i++) {
            if (parseInt(phaseSteps[i].id) === parseInt(currentPhase.id)) {
                futureSteps = true;
            }

            if (futureSteps && isWebRTCNeededForPhaseStep(phaseSteps[i])) {
                return true;
            }
        }
    }

    return false;
}

function isWebRTCSupported() {
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        return true;
    }
    return false;
}

function isRecordingNeededInFuture() {
    var currentPhase = getCurrentPhase();
    var phaseSteps = getContextualPhaseSteps();
    if (currentPhase && phaseSteps && phaseSteps.length > 0) {
        var futureSteps = false;
        for (var i = 0; i < phaseSteps.length; i++) {
            if (parseInt(phaseSteps[i].id) === parseInt(currentPhase.id)) {
                futureSteps = true;
            }

            var options = getPhaseStepOptions(phaseSteps[i].format);
            if (futureSteps && (options.tester.recordStream === 'yes' || options.moderator.recordStream === 'yes')) {
                return true;
            }
        }
    }

    return false;
}

function getSUSAdjective(score) {
    var adjective = null;
    for (var i = 0; i < translation.susScores.length; i++) {
        if (i === translation.susScores.length - 1) {
            adjective = translation.susScores[i];
            break;
        }

        if (score < parseFloat(translation.susScores[i + 1].score)) {
            adjective = translation.susScores[i];
            break;
        }
    }
    return adjective;
}