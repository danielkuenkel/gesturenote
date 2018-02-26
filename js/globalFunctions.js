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

/*
 * language indicator
 */
function updateLanguageIndicator(target) {
    $(target).find('#' + currentLanguage).addClass('selected');
    $(target).find('.language-indicator').text(translation.languages[currentLanguage].language);
    $(target).find('.dropdown-toggle img').attr('src', 'img/flags/' + currentLanguage + '.png');
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

function renderSubPageElements(hasTopNavbar, hasNoImprint) {
    var header = $('#header-footer-container').find('#sub-page-header').clone().removeAttr('id');
    header.insertBefore($('body').find('#breadcrumb'));
    header.find('#btn-sign-out').on('click', function (event) {
        event.preventDefault();
        clearLocalItems();
        goto('includes/logout.php');
    });

    header.find('#logo').on('click', function (event) {
        event.preventDefault();
        gotoIndex();
    });

    var footer = $('#header-footer-container').find('#sub-page-footer').clone().removeAttr('id');
    $('body').append(footer);

    if (hasTopNavbar === false) {
        header.find('.navbar-right').addClass('hidden');
    }

    if (hasNoImprint === true) {
        footer.find('#btn-imprint').addClass('hidden');
    }

    updateLanguageIndicator($(footer).find('#language-selection'));
}

$(document).on('click', '#language-selection li a', function (event) {
    event.preventDefault();
    if (!$(this).hasClass('selected')) {
        $(this).closest('.dropdown-menu').find('a').removeClass('selected');
        $(this).addClass('selected');
        changeLanguage({lang: $(this).attr('id')}, function (result) {
            if (result.status === RESULT_SUCCESS) {
                location.reload();
            }
        });
    }
});

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

        $(this).closest('.input-group').find('.item-input-text').attr('placeholder', '');

        if (parent.hasClass('saveGeneralData')) {
            saveGeneralData();
        }

        $(this).trigger('change', [listItemId]);
    }
});

$(document).on('click', '.add-button-group .btn-add-item', function (event) {
    if (!$(this).hasClass('disabled')) {
        $(this).trigger('change');
        $(this).find('[data-toggle="popover"]').popover('hide');
    }
});

function initTooltips(delayShow, delayHide) {
    $('[data-toggle="tooltip"]').tooltip({container: 'body', delay: {"show": delayShow ? delayShow : 300, "hide": delayHide ? delayHide : 0}});
}

function initPopover(delayShow, delayHide) {
    $('[data-toggle="popover"]').popover({container: 'body', delay: {"show": delayShow ? delayShow : 300, "hide": delayHide ? delayHide : 0}});
}

$(document).on('mouseenter', '.btn-show-hole-text', function (event) {
    if (!event.handled) {
        initTooltips();
        event.handled = true;
        var inputVal = $(this).closest('.input-group').find('input').val();
        if (inputVal.trim() !== '') {
            console.log($(this).offset());
            $(this).attr('data-original-title', inputVal);
            $(this).tooltip({container: 'body'});
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
            var timeline = new TimelineMax({onComplete: onMoveUpComplete, onCompleteParams: [element, brother, save]});
            timeline.add("start", 0)
                    .to(element, .2, {y: -offset, clearProps: 'all'}, "start")
                    .to(brother, .2, {y: heightBrother === heightElement ? offset : heightElement, clearProps: 'all'}, "start");
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
                    .to(element, ELEMENT_MOVE_TRANSITION_DURATION, {y: heightBrother === heightElement ? offset : heightBrother, clearProps: 'all'}, "start")
                    .to(brother, ELEMENT_MOVE_TRANSITION_DURATION, {y: -offset, clearProps: 'all'}, "start");
            break;
    }
}

function onMoveUpComplete(element, brother, save) {
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

var currentPreviewData = null;
$(document).on('click', '.btn-preview', function (event) {
    event.preventDefault();
    if (!$(this).hasClass('disabled')) {
        $(this).popover('hide');
        var formatData = getFormatData($(this).closest('.root'));
        currentPreviewData = [formatData];
        loadHTMLintoModal('custom-modal', 'modal-preview.php', 'modal-lg');
    }
});

function checkCurrentListState(itemContainer) {
    var childList = $(itemContainer).children();
    for (var i = 0; i < childList.length; i++) {
        var child = childList[i];
        var btnUp = $(child).find('.btn-up').first();
        var btnDown = btnUp.next();
        btnUp.removeClass('disabled');
        btnDown.removeClass('disabled');

        if (i === 0) {
            btnUp.addClass('disabled');
        } else if ($(child).prev().find('.btn-down').length === 0) {
            btnUp.addClass('disabled');
        }

        if (i === childList.length - 1) {
            btnDown.addClass('disabled');
        } else if ($(child).next().find('.btn-up').length === 0) {
            btnDown.addClass('disabled');
        }
    }
    initPopover();
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
        if (currentValue === "" || isNaN(currentValue)) {
            currentValue = min;
        } else if (currentValue > min) {
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
        var min = parseInt($(this).closest('.simple-stepper').find('.btn-stepper-decrease').val());
        var currentValue = parseInt($(this).closest('.simple-stepper').find('.stepper-text').val());

        if (currentValue === "" || isNaN(currentValue)) {
            currentValue = min;
        } else if (currentValue < max) {
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

    var dropdown = target === null ? $('#form-item-container').find('.gestureSelect') : $(target).find('.gestureSelect');
    $(dropdown).find('.option').empty();

    if (gestures !== null) {
        $(target).find('.gestureSelect .dropdown-toggle').removeClass('disabled');
        $(target).find('.option-gesture').attr('placeholder', translation.pleaseSelect);

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
        if (optionalSelections && optionalSelections.length > 0) {
            $(target).find('.gestureSelect .dropdown-toggle').removeClass('disabled');
            $(target).find('.option-gesture').attr('placeholder', translation.pleaseSelect);

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
        } else {
            $(target).find('.gestureSelect .dropdown-toggle').addClass('disabled');
            $(target).find('.option-gesture').attr('placeholder', translation.noGestureSetPresent);
        }
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
    var dropdown = target === null ? $('#form-item-container').find('.triggerSelect') : $(target).find('.triggerSelect');
    $(dropdown).find('.option').empty();

    if (triggers && triggers.length > 0) {
        $(dropdown).find('.dropdown-toggle').removeClass('disabled');
        $(target).find('.triggerSelect .dropdown-toggle').removeClass('disabled');
        $(target).find('.option-trigger').attr('placeholder', translation.pleaseSelect);

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
        if (addNoneItem === true) {
            $(target).find('.triggerSelect .dropdown-toggle').removeClass('disabled');
            $(target).find('.option-trigger').attr('placeholder', translation.pleaseSelect);

            link = document.createElement('a');
            listItem = document.createElement('li');
            listItem.setAttribute('id', 'none');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(translation.none));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);
        } else {
            $(target).find('.triggerSelect .dropdown-toggle').addClass('disabled');
            $(target).find('.option-trigger').attr('placeholder', translation.noTriggerPresent);
        }
    }
}


/* 
 * Actions for the prototype select dropdown
 */

function renderAssembledScenes(targetContainer, optionalSelections) {
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
        $(target).find('.option-scene').attr('placeholder', translation.pleaseSelect);

        for (var i = 0; i < scenes.length; i++) {
            listItem = document.createElement('li');
            listItem.setAttribute('id', scenes[i].id);
            link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(scenes[i].title));
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
        if (optionalSelections && optionalSelections.length > 0) {
            $(target).find('.sceneSelect .dropdown-toggle').removeClass('disabled');
            $(target).find('.option-scene').attr('placeholder', translation.pleaseSelect);

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
        } else {
            $(target).find('.sceneSelect .dropdown-toggle').addClass('disabled');
            $(target).find('.option-scene').attr('placeholder', translation.noScenesPresent);
        }
    }
}

/* 
 * Actions for the feedback selection dropdown
 */

function renderAssembledFeedback(targetContainer, optionalSelections) {
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
            $(target).find('.option-feedback').attr('placeholder', translation.pleaseSelect);
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
        if (optionalSelections && optionalSelections.length > 0) {
            $(target).find('.sceneSelect .dropdown-toggle').removeClass('disabled');
            $(target).find('.option-scene').attr('placeholder', translation.pleaseSelect);

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
        } else {
            $(target).find('.sceneSelect .dropdown-toggle').addClass('disabled');
            $(target).find('.option-scene').attr('placeholder', translation.noFeedbackPresent);
        }
    }
}


/*
 * actions for scenario help item with tasks
 */
function renderAssembledTasks(tasks, targetContainer, addNoneItem) {
    var target = $('#form-item-container');
    if (targetContainer !== undefined && targetContainer !== null) {
        target = targetContainer;
    }

    var listItem, link;
    var dropdown = target === null ? $('#form-item-container').find('.taskSelect') : $(target).find('.taskSelect');
    var selectedItem = $(dropdown).find('.selected').attr('id');
    $(dropdown).find('.option').empty();

    if (tasks && tasks.length > 0) {
        $(dropdown).find('.dropdown-toggle').removeClass('disabled');
        $(target).find('.taskSelect .dropdown-toggle').removeClass('disabled');
        $(target).find('.item-input-text').attr('placeholder', translation.pleaseSelect);

        for (var i = 0; i < tasks.length; i++) {
            listItem = document.createElement('li');
            listItem.setAttribute('id', tasks[i].id);
            link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(tasks[i].title));
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
        if (addNoneItem === true) {
            $(target).find('.taskSelect .dropdown-toggle').removeClass('disabled');
            $(target).find('.item-input-text').attr('placeholder', translation.pleaseSelect);

            link = document.createElement('a');
            listItem = document.createElement('li');
            listItem.setAttribute('id', 'none');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(translation.none));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);
        } else {
            $(target).find('.taskSelect .dropdown-toggle').addClass('disabled');
            $(target).find('.item-input-text').attr('placeholder', translation.noTasksPresent);
        }
    }
    
    if(selectedItem) {
        $(dropdown).find('#' + selectedItem).addClass('selected');
        $(dropdown).parent().find('.item-input-text').val($(target).find('#' + selectedItem + ' a').text());
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
    event.preventDefault();
    if (event.handled !== true && !$(this).hasClass('disabled'))
    {
        event.handled = true;
        if ($(this).hasClass('btn-checkbox') && $(this).hasClass('btn-option-checked')) {
            uncheckOption($(this));
        } else {
            checkOption($(this));
        }

        if ($(this).hasClass('saveGeneralData')) {
            saveGeneralData();
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
        var children = $(optionItem).closest('.root').find('.btn-radio');
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
    if (data.id !== 'none') {
        removeHint($(target).find('#hint'));
        var hint = $(source).find('#feedback-hint').clone();
        hint.attr('id', 'hint');
        $('body').append(hint);
        renderDataForHint(data, hint, source, surveyType);

        return hint;
    }

    return null;
}

function renderDataForHint(data, hint, source, surveyType) {
    var feedback = getFeedbackById(data.id);

    if (data.transitionMode === 'automatically') {
        hint.find('#btn-close-hint').remove();
    } else {
        hint.find('.progress-hint').remove();
    }

    switch (feedback.type) {
        case TYPE_FEEDBACK_TEXT:
            hint.find('.hint-content').prepend($(source).find('#feedback-hint-text-content').clone().removeAttr('id'));
            hint.find('#feedback-title').text(feedback.title);

            if (data.transitionMode === 'automatically') {
                TweenMax.to(hint.find('.progress-bar'), data.transitionTime, {width: '0%', autoRound: false, ease: Power0.easeNone, onComplete: hideHint, onCompleteParams: [hint]});
            }
            break;
        case TYPE_FEEDBACK_SOUND:
            $(hint).addClass('hidden');
            hint.find('.hint-content').prepend($(source).find('#feedback-hint-sound-content').clone().removeAttr('id'));
            var audioHolder = hint.find('.audio-holder')[0];
            hint.find('#feedback-title').text(feedback.title);
            $(audioHolder).attr('src', feedback.data);
            audioHolder.addEventListener("loadedmetadata", function () {
                audioHolder.play();
                if (surveyType === TYPE_SURVEY_MODERATED) {
                    TweenMax.to(hint.find('.progress-bar'), audioHolder.duration, {width: '0%', autoRound: false, ease: Power0.easeNone, onComplete: hideHint, onCompleteParams: [hint]});
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
    TweenMax.to(hint, .2, {autoAlpha: 0, onComplete: function () {
            $(hint).trigger('hint.hidden');
            removeHint(hint);
        }});
}

function removeHint(hint) {
    $(hint).remove();
}


// pagination handling
currentPaginationData = null;
triggerPaginationChangeEvents = true;
function initPagination(data) {
    currentPaginationData = data;

    var maxPages = Math.ceil(data.pager.dataLength / data.pager.maxElements);
    var paginationClipping = null;

    if (data.pager.top) {
        paginationClipping = parseInt($(data.pager.top).attr('data-clipping'));
        $(data.pager.top).children('.clickable-pagination-item').remove();
        $(data.pager.top).attr('data-max-pages', maxPages);

        if (maxPages <= 1) {
            $(data.pager.top).addClass('hidden');
        } else {
            $(data.pager.top).removeClass('hidden');
        }
    }

    if (data.pager.bottom) {
        paginationClipping = parseInt($(data.pager.top).attr('data-clipping'));
        $(data.pager.bottom).children('.clickable-pagination-item').remove();
        $(data.pager.bottom).attr('data-max-pages', maxPages);

        if (maxPages <= 1) {
            $(data.pager.bottom).addClass('hidden');
        } else {
            $(data.pager.bottom).removeClass('hidden');
        }
    }

    var currentIndex = isNaN(getCurrentPaginationIndex()) ? 0 : getCurrentPaginationIndex();
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

    var currentMaxPages = parseInt($(mainPager).attr('data-max-pages'));
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
    var currentMaxPages = parseInt($(pagination).attr('data-max-pages'));
    var maxPages = Math.ceil(dataLength / maxElements);

    if (maxPages !== currentMaxPages) {
        var paginationItems = $(pagination).children('.clickable-pagination-item');
        for (var i = 0; i < paginationItems.length; i++) {
            $(paginationItems[i]).removeClass('active');
            if (i === (maxPages - 1)) {
                $(paginationItems[i]).addClass('active');
            }
        }

        currentPaginationData.pager.dataLength = dataLength;
        currentPaginationData.pager.maxElements = maxElements;
        initPagination(currentPaginationData);
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

        var maxPages = parseInt($(mainPager).attr('data-max-pages'));

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
        var maxPages = parseInt($(mainPager).attr('data-max-pages'));
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
        var maxPages = parseInt($(mainPager).attr('data-max-pages'));
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
$(document).on('click', '.nav-tabs li.disabled > a[data-toggle=tab]', function (e) {
    e.stopImmediatePropagation();
});


function getAssembledItems(source) {
    var array = new Array();
    if (source && source.length > 0) {
        for (var i = 0; i < source.length; i++) {
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


/*
 * gesture thumbnail handling
 */

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

        var rerender = !$(this).attr('data-rerender');

        var assemble = false;
        var gestureId = $(this).closest('.root').attr('id');
        $(this).popover('hide');

        if (!$(this).hasClass('assembled')) {
            $(this).attr('data-content', translation.removeFromStudyGestureSet).data('bs.popover').setContent();
            $(this).addClass('assembled');
            $(this).find('.fa').removeClass('fa-plus-square').addClass('fa-minus-square');
            $(this).closest('.gesture-thumbnail').addClass('assembled');
            assemble = true;
        } else {
            $(this).attr('data-content', translation.addToStudyGestureSet).data('bs.popover').setContent();
            $(this).removeClass('assembled');
            $(this).find('.fa').removeClass('fa-minus-square').addClass('fa-plus-square');
            $(this).closest('.gesture-thumbnail').removeClass('assembled');
        }

        $(this).trigger('change', [gestureId, assemble, rerender]);
    }
});

$(document).on('click', '.btn-add-gesture-to-scene', function (event) {
    event.preventDefault();

    if (!event.handled) {
        event.handled = true;

        var assemble = false;
        var gestureId = $(this).closest('.root').attr('id');
        $(this).popover('hide');
        if (!$(this).hasClass('assembled')) {
            $(this).attr('data-content', translation.removeFromState).data('bs.popover').setContent();
            $(this).addClass('assembled');
            $(this).find('.fa').removeClass('fa-plus-square').addClass('fa-minus-square');
            $(this).closest('.gesture-thumbnail').addClass('assembled');
            assemble = true;
        } else {
            $(this).attr('data-content', translation.addToState).data('bs.popover').setContent();
            $(this).removeClass('assembled');
            $(this).find('.fa').removeClass('fa-minus-square').addClass('fa-plus-square');
            $(this).closest('.gesture-thumbnail').removeClass('assembled');
        }

        $(this).trigger('change', [gestureId, assemble]);
    }
});



/*
 * sorting
 */

var originalFilterData = null;
var currentFilterData = null;

function sort() {
    if (currentPaginationData) {
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
    } else {
        return originalFilterData;
    }
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
            } else if (scope === SCOPE_GESTURE_LIKED && originalFilterData[i].hasLiked === true) {
                array.push(originalFilterData[i]);
            } else if (scope === SCOPE_GESTURE_RATED && originalFilterData[i].hasRated === true) {
                array.push(originalFilterData[i]);
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
            $(this).trigger('saveData');
            saveData();
        }

        var filter = $(this).val();
        var container = currentFilterList;
        if (filter.trim() !== "" && event.keyCode !== 27) {
            var matched = searchThroughArray(sort(), filter.trim());
//            if (matched.length > 0) {
//                container.removeClass('hidden');
//                removeAlert(container.closest('#item-view'), ALERT_NO_SEARCH_RESULTS);
            currentFilterData = matched;
            updatePaginationItems();
            $(container).trigger('renderData', [matched]);
//            } else {
//                container.addClass('hidden');
//                appendAlert(container.closest('#item-view'), ALERT_NO_SEARCH_RESULTS);
//            }
        } else {
//            container.removeClass('hidden');
//            removeAlert(container.closest('#item-view'), ALERT_NO_SEARCH_RESULTS);
            currentFilterData = sort();
            updatePaginationItems();
            $(container).trigger('renderData', [currentFilterData]);

            if (event.keyCode === 27) {
                $(this).val('');
            }
        }
    }
});

function searchThroughArray(array, filter) {
    var result = new Array();
    for (var i = 0; i < array.length; i++) {
        var title = null;
        if (array[i].title) {
            title = array[i].title;
        } else if (array[i].data && array[i].data.generalData && array[i].data.generalData.title) {
            title = array[i].data.generalData.title;
        }

        if (title.search(new RegExp(filter, "i")) > -1) {
            result.push(array[i]);
        }
    }

    return result;
}




/*
 * time and date functions
 */

function addDays(date, amount) {
    return new Date(new Date(date).getTime() + (1000 * 60 * 60 * 24 * amount));
}

function rangeDays(dateFrom, dateTo) {
    return Math.round((dateTo - dateFrom) / (1000 * 60 * 60 * 24));
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

function getSeconds(executionTime, getMillis) {
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

    if (getMillis === true) {
        if (executionTime.milliseconds) {
            seconds += executionTime.milliseconds / 1000;
        } else {
            seconds += 0.0;
        }

    }
//    console.log(seconds, executionTime);
    return parseFloat(seconds);
}

function secondsToHms(d) {
    d = Number(d);

    var h = Math.floor(d / 3600);
    var m = Math.floor(d % 3600 / 60);
    var s = Math.floor(d % 3600 % 60);

    return ('0' + h).slice(-2) + ":" + ('0' + m).slice(-2) + ":" + ('0' + s).slice(-2);
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
                timeString += object[key] + '' + translation.timesShort[key] + ' ';
            } else {
                if (parseInt(object[key]) === 1) {
                    timeString += object[key] + '' + translation.timesSingular[key] + ' ';
                } else {
                    timeString += object[key] + '' + translation.times[key] + ' ';
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

    var clone = initGestureThumbnail(data, typeId, layout, panelStyle);

    initMoreInfoGesture($(clone).find('.btn-show-gesture-info'), clone, data, source, modalId);
    initCommentGesture($(clone).find('.btn-comment'), clone, source, data);
    initShareGesture($(clone).find('.btn-share'), clone, source, data);
    initLikeGesture($(clone).find('.btn-like'), source, data);
    initRatingGesture($(clone).find('.btn-rate'), clone, source, data);
    initGestureSet($(clone).find('.btn-edit-gesture-set'), clone, source, data);
    initPopover(300);
    return clone;
}

function initGestureThumbnail(data, typeId, layout, panelStyle) {
    var clone;
    if (typeId && typeId !== null) {
        clone = $('#' + typeId).clone().removeClass('hidden').removeAttr('id');
    } else {
        clone = $('#gestures-catalog-thumbnail').clone().removeClass('hidden').removeAttr('id');
    }
    clone.attr('id', data.id);
    clone.find('.gesture-name').text(data.title);
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
    
//    if (!clone.hasClass('deleteable')) {
//        gesturePreviewDeleteable = false;
//    }
    
    renderGestureImages(clone.find('.previewGesture'), data.images, data.previewImage, null);

    $(clone).find('.gesture-thumbnail').mouseenter(function (event) {
        event.preventDefault();
        if (gesturePreviewOpened === false) {
            playThroughThumbnails($(this).find('.previewGesture'), 0);
        }
    });

    $(clone).find('.gesture-thumbnail').mouseleave(function (event) {
        event.preventDefault();
        if (gesturePreviewOpened === false) {
            resetThumbnails($(this).find('.previewGesture'));
        }
    });
    return clone;
}

function initMoreInfoGesture(button, clone, data, source, modalId) {
    $(button).click(function (event) {
        event.preventDefault();
        $(button).popover('hide');
        resetThumbnails($(clone).find('.previewGesture'));
        currentPreviewGesture = {gesture: getGestureById(data.id, source), source: source, thumbnail: clone};
        gesturePreviewOpened = true;
        $(clone).find('#btn-stop-gesture').click();

        $('#custom-modal').on('gesture-deleted', function () {
            checkPagination($('#custom-pager .pagination'), currentFilterData.length, parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]));
            renderData(currentFilterData);
        });

        if (modalId) {
            loadHTMLintoModal('custom-modal', modalId + '.php', 'modal-lg');
        } else {
            loadHTMLintoModal('custom-modal', 'modal-gesture.php', 'modal-lg');
        }
    });
}

function initCommentGesture(button, clone, source, data) {
    $(button).find('.amount').text(parseInt(data.commentAmount) > 0 ? data.commentAmount : '');
    if (data.hasCommented === 'true' || data.hasCommented === true) {
        $(button).find('.fa').removeClass('fa-comment-o').addClass('fa-comments');
    }

    $(button).click(function (event) {
        event.preventDefault();
        $(button).popover('hide');
        resetThumbnails($(clone).find('.previewGesture'));
        currentPreviewGesture = {gesture: getGestureById(data.id, source), source: source, thumbnail: clone, startTab: 'comments'};
        gesturePreviewOpened = true;
        $(clone).find('#btn-stop-gesture').click();
        loadHTMLintoModal('custom-modal', 'modal-gesture.php', 'modal-lg');
    });
}

function initGestureSet(button, clone, source, data) {
    if (button && button !== undefined) {
        $(button).click(function (event) {
            event.preventDefault();
            $(button).popover('hide');
            resetThumbnails($(clone).find('.previewGesture'));
            currentPreviewGesture = {gesture: getGestureById(data.id, source), source: source, thumbnail: clone, startTab: 'gestureSets'};
            gesturePreviewOpened = true;
            $(clone).find('#btn-stop-gesture').click();
            loadHTMLintoModal('custom-modal', 'modal-gesture.php', 'modal-lg');
        });
    }
}

function initShareGesture(button, clone, source, data, callback) {
    if (data.isOwner) {
        if (data.scope === SCOPE_GESTURE_PUBLIC) {
            button.addClass('gesture-shared');
            button.attr('data-content', translation.gestureShared);
        }
    } else {
        $(button).remove();
    }

    $(button).click(function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(button).popover('hide');
            lockButton(button, true, 'fa-share-alt');
            showCursor($('body'), CURSOR_PROGRESS);

            if (!$(this).hasClass('gesture-shared')) {
                shareGesture({gestureId: data.id}, function (result) {
                    showCursor($('body'), CURSOR_DEFAULT);
                    unlockButton(button, true, 'fa-share-alt');

                    if (result.status === RESULT_SUCCESS) {
                        $(button).addClass('gesture-shared');
                        $(button).attr('data-content', translation.unshareGesture);
                        clone.find('#gesture-scope .label-text').text(translation.gestureScopes[SCOPE_GESTURE_PUBLIC]);
                        clone.find('#gesture-scope .fa').addClass('hidden');
                        clone.find('#gesture-scope #' + SCOPE_GESTURE_PUBLIC).removeClass('hidden');

                        updateGestureById(source, data.id, {scope: 'public'});

                        // check if update list needed after updateGesture() call
                        if ($(button).hasClass('update-list-view')) {
                            getGestureCatalog(function (result) {
                                if (result.status === RESULT_SUCCESS) {
                                    originalFilterData = result.gestures;
                                }

                                if (callback) {
                                    callback();
                                }
                            });
                        } else {
                            if (callback) {
                                callback();
                            }
                        }
                    }
                });
            } else {
                unshareGesture({gestureId: data.id}, function (result) {
                    showCursor($('body'), CURSOR_DEFAULT);
                    unlockButton(button, true, 'fa-share-alt');

                    if (result.status === RESULT_SUCCESS) {
                        $(button).removeClass('gesture-shared');
                        $(button).attr('data-content', translation.shareGesture);
                        clone.find('#gesture-scope .label-text').text(translation.gestureScopes[SCOPE_GESTURE_PRIVATE]);
                        clone.find('#gesture-scope .fa').addClass('hidden');
                        clone.find('#gesture-scope #' + SCOPE_GESTURE_PRIVATE).removeClass('hidden');

                        updateGestureById(source, data.id, {scope: 'private'});

                        // check if this is needed after updateGesture() call
                        if ($(button).hasClass('update-list-view')) {
                            getGestureCatalog(function (result) {
                                if (result.status === RESULT_SUCCESS) {
                                    originalFilterData = result.gestures;
                                }

                                if (callback) {
                                    callback();
                                }
                            });
                        } else {
                            if (callback) {
                                callback();
                            }
                        }
                    }
                });
            }

            initPopover();
        }
    });
}

function initLikeGesture(button, source, data, callback) {
    $(button).find('.amount').text(parseInt(data.likeAmount) === 0 ? '' : data.likeAmount);
    if (data.hasLiked) {
        $(button).attr('data-content', translation.unlikeGesture);
        $(button).addClass('gesture-liked');
        $(button).find('.fa').removeClass('fa-heart-o').addClass('fa-heart');
    } else {
        $(button).attr('data-content', translation.likeGesture);
    }

    $(button).unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(button).popover('hide');
            showCursor($('body'), CURSOR_PROGRESS);

            if (!$(this).hasClass('gesture-liked')) {
                lockButton(button, true, 'fa-heart-o');
                likeGesture({gestureId: data.id}, function (result) {
                    showCursor($('body'), CURSOR_DEFAULT);
                    unlockButton(button, true, 'fa-heart-o');

                    if (result.status === RESULT_SUCCESS) {
                        $(button).addClass('gesture-liked');
                        $(button).find('.fa').removeClass('fa-heart-o').addClass('fa-heart');
                        $(button).attr('data-content', translation.unlikeGesture);
                        var newAmount = (parseInt($(button).find('.amount').text()) || 0) + 1;
                        $(button).find('.amount').text(newAmount);
                        updateGestureById(source, data.id, {hasLiked: true, likeAmount: newAmount});

                        // check if this is needed after updateGesture() call
                        if ($(button).hasClass('update-list-view')) {
                            getGestureCatalog(function (result) {
                                if (result.status === RESULT_SUCCESS) {
                                    originalFilterData = result.gestures;
                                }

                                if (callback) {
                                    callback();
                                }
                            });
                        } else {
                            if (callback) {
                                callback();
                            }
                        }
                    }
                });
            } else {
                lockButton(button, true, 'fa-heart');
                unlikeGesture({gestureId: data.id}, function (result) {
                    showCursor($('body'), CURSOR_DEFAULT);
                    unlockButton(button, true, 'fa-heart');

                    if (result.status === RESULT_SUCCESS) {
                        $(button).removeClass('gesture-liked');
                        $(button).find('.fa').removeClass('fa-heart').addClass('fa-heart-o');
                        $(button).attr('data-content', translation.likeGesture);
                        var newAmount = Math.max(0, (parseInt($(button).find('.amount').text()) || 0) - 1);
                        $(button).find('.amount').text(newAmount === 0 ? '' : newAmount);
                        updateGestureById(source, data.id, {hasLiked: false, likeAmount: newAmount});

                        // check if this is needed after updateGesture() call
                        if ($(button).hasClass('update-list-view')) {
                            getGestureCatalog(function (result) {
                                if (result.status === RESULT_SUCCESS) {
                                    originalFilterData = result.gestures;
                                }

                                if (callback) {
                                    callback();
                                }
                            });
                        } else {
                            if (callback) {
                                callback();
                            }
                        }
                    }
                });
            }

            initPopover();
        }
    });
}

function initRatingGesture(button, clone, source, data) {
    $(button).find('.amount').text(parseInt(data.ratingAmount) === 0 ? '' : data.ratingAmount);

    if (data.isOwner === true) {
        if (parseInt(data.ratingAmount) === 0) {
            $(button).attr('data-content', translation.gestureNotRated);
        } else {
            $(button).attr('data-content', translation.showRatings);
        }
    } else {
        if (data.hasRated) {
            $(button).attr('data-content', translation.gestureRated);
            $(button).addClass('gesture-rated');
            $(button).find('.fa').removeClass('fa-star-o').addClass('fa-star');
        } else {
            $(button).attr('data-content', translation.rateGesture);
        }
    }

    $(button).unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(button).popover('hide');
        resetThumbnails($(clone).find('.previewGesture'));
        currentPreviewGesture = {gesture: getGestureById(data.id, source), source: source, thumbnail: clone, startTab: 'rating'};
        gesturePreviewOpened = true;
        $(clone).find('#btn-stop-gesture').click();
        loadHTMLintoModal('custom-modal', 'modal-gesture.php', 'modal-lg');
    });
}

function getCreateStudyGestureListThumbnail(data, typeId, layout, source, panelStyle, modalId) {
    if (!source || source === null || source === undefined) {
        source = GESTURE_CATALOG;
    }

    var clone = initGestureThumbnail(data, typeId, layout, panelStyle);
    initMoreInfoGesture($(clone).find('.btn-show-gesture-info'), clone, data, source, modalId);

    var isGestureAss = isGestureAssembled(data.id);
    if (isGestureAss) {
        clone.find('.btn-tag-as-favorite-gesture').attr('data-content', 'Vom Studien-Gesten-Set entfernen');
        clone.find('.gesture-thumbnail').addClass('assembled');
        clone.find('.btn-tag-as-favorite-gesture').addClass('assembled');
        clone.find('.btn-tag-as-favorite-gesture .fa').removeClass('fa-plus-square').addClass('fa-minus-square');
    }

    return clone;
}

function getGestureSceneListThumbnail(data, typeId, layout, source, panelStyle) {
    if (!source || source === null || source === undefined) {
        source = GESTURE_CATALOG;
    }

    var clone = initGestureThumbnail(data, typeId, layout, panelStyle);
    initMoreInfoGesture($(clone).find('.btn-show-gesture-info'), clone, data, source);

    return clone;
}

function getSimpleGestureListThumbnail(data, typeId, layout) {
    var clone = initGestureThumbnail(data, typeId, layout);
    return clone;
}


/*
 * study catalog list items
 */

function getStudiesCatalogListThumbnail(data) {
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
                $(clone).find('.study-started').removeClass('hidden').find('.text').text(translation.studyStarted + ', ' + translation.still + ' ' + left.days + ' ' + (left.days + 1 === 1 ? translation.day : translation.days) + ', ' + left.hours + ' ' + (left.hours === 1 ? translation.hour : translation.hours));
                $(clone).find('.progress-bar').addClass('progress-bar-success');
            } else if (now < dateFrom) {
                progress = 100;
                var daysToStart = Math.round((dateFrom - now) / (1000 * 60 * 60 * 24));
                $(clone).find('.study-not-started').removeClass('hidden').find('.text').text(translation.studyNotStarted + ', ' + translation.startsAt + ' ' + daysToStart + ' ' + (daysToStart === 1 ? translation.day : translation.daysn));
                $(clone).find('.progress-bar').addClass('progress-bar-warning');
            } else if (now > dateTo) {
                progress = 100;
                $(clone).find('#study-range-days .address').text(translation.studyRuns + ": ");
                $(clone).find('.study-ended').removeClass('hidden').find('.text').text(translation.studyEnded);
                $(clone).find('.progress-bar').addClass('progress-bar-info');
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


function getGestureSetPanel(data) {
    var panel = $('#create-study-gesture-set-panel').clone();
    $(panel).find('.panel-heading .panel-heading-text').text(data.title);

    if (data.gestures !== null) {
        clearAlerts(panel);
        for (var j = 0; j < data.gestures.length; j++) {
            var gesture = getGestureById(data.gestures[j]);
            var isGestureAss = isGestureAssembled(gesture.id);
            var gestureThumbnail = getCreateStudyGestureListThumbnail(gesture, 'favorite-gesture-catalog-thumbnail', 'col-xs-6 col-md-3', null, isGestureAss ? 'panel-info' : null);
            $(panel).find('#gestures-list-container').append(gestureThumbnail);

//            if (isGestureAss) {
//                gestureThumbnail.find('#btn-tag-as-favorite-gesture').removeClass('btn-info').addClass('selected btn-danger');
//                gestureThumbnail.find('#btn-tag-as-favorite-gesture .fa').removeClass('fa-plus').addClass('fa-minus');
//            }
        }
        var assembledGesturesLength = $(panel).find('#gestures-list-container .gesture-thumbnail.assembled').length;
        if (assembledGesturesLength === $(panel).find('#gestures-list-container .gesture-thumbnail').length) {
            console.log(assembledGesturesLength);
            $(panel).find('#btn-mark-hole-set').addClass('marked');
            $(panel).find('#btn-mark-hole-set').find('.fa').removeClass('fa-plus').addClass('fa-minus');
//            $(panel).find('#btn-unmark-hole-set').removeClass('hidden');
        }

    } else {
        $(panel).find('#btn-mark-hole-set').addClass('hidden');
        $(panel).find('#btn-download-as-json').addClass('hidden');
        appendAlert(panel, ALERT_EMPTY_GESTURE_SET);
    }

    initPopover();

    $(panel).find('#btn-delete-gesture-set').unbind('click').bind('click', {setId: data.id}, function (event) {
        event.preventDefault();
        var button = $(this);
        if (!$(button).hasClass('disabled')) {
            lockButton(button, true, 'fa-trash');

            deleteGestureSet({setId: event.data.setId}, function (result) {
                unlockButton(button, true, 'fa-trash');
                $(this).popover('hide');
                if (result.status === RESULT_SUCCESS) {
                    $(button).trigger('gestureSetDeleted');
                } else {
                    // append alert
                }
            });
        }
    });

    $(panel).find('#btn-mark-hole-set').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(this).popover('hide');
        if ($(this).hasClass('marked')) {
            $(this).removeClass('marked');
            $(this).find('.fa').removeClass('fa-minus').addClass('fa-plus');
            $(this).attr('data-content', translation.addAllGesturesToStudyGestureSet).data('bs.popover').setContent();
            var assembledGestures = $(panel).find('#gestures-list-container .btn-tag-as-favorite-gesture.assembled');
            for (var i = 0; i < assembledGestures.length; i++) {
                if (i < assembledGestures.length - 1) {
                    $(assembledGestures[i]).attr('data-rerender', 'true');
                }
                $(assembledGestures[i]).click();
            }
        } else {
            $(this).addClass('marked');
            $(this).find('.fa').removeClass('fa-plus').addClass('fa-minus');
            $(this).attr('data-content', translation.removeAllGesturesFromStudyGestureSet).data('bs.popover').setContent();
            var unassembledGestures = $(panel).find('#gestures-list-container .btn-tag-as-favorite-gesture:not(.assembled)');
            $(unassembledGestures).click();
        }
    });

    $(panel).find('#btn-download-as-json').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(this).popover('hide');
        downloadGestureSetAsJSON($(panel).find('.gesture-thumbnail'), data.title);
    });

    return panel;
}

function downloadGestureSetAsJSON(gestureThumbnails, title) {
    var actions = [];
    for (var i = 0; i < gestureThumbnails.length; i++) {
        var gestureId = $(gestureThumbnails[i]).closest('.root').attr('id');
        var gesture = getGestureById(gestureId);
        if (gesture.gif && gesture.gif !== null) {
            actions.push({id: gesture.id, name: gesture.title, description: gesture.description, image: 'https://gesturenote.de/' + gesture.gif});
        } else {
            actions.push({id: gesture.id, name: gesture.title, description: gesture.description});
        }
    }

    // create json file and download it
    var jsonSet = GESTURE_SET_JSON;
    jsonSet.actions = actions;
    var blob = new Blob([JSON.stringify(jsonSet)], {type: "text/json;charset=utf-8"});
    saveAs(blob, title + ".json");
}

function getGestureCatalogGestureSetPanel(data, type, layout) {
    var panel = $('#study-gesture-set-panel').clone();
    $(panel).find('.panel-heading .panel-heading-text').text(data.title);

    if (data.gestures !== null) {
        clearAlerts(panel);
        for (var j = 0; j < data.gestures.length; j++) {
            var gesture = getGestureById(data.gestures[j]);
            var gestureThumbnail = getGestureCatalogListThumbnail(gesture, type ? type : null, layout ? layout : 'col-xs-6 col-sm-6 col-lg-3');
            $(panel).find('#gestures-list-container').append(gestureThumbnail);
        }
    } else {
        $(panel).find('#btn-mark-hole-set').addClass('hidden');
        appendAlert(panel, ALERT_EMPTY_GESTURE_SET);
    }

    $(panel).find('#btn-delete-gesture-set').unbind('click').bind('click', {setId: data.id}, function (event) {
        event.preventDefault();
        var button = $(this);

        if (!$(button).hasClass('disabled')) {
            lockButton(button, true, 'fa-trash');
            $(button).popover('hide');

            deleteGestureSet({setId: event.data.setId}, function (result) {
                unlockButton(button, true, 'fa-trash');
                if (result.status === RESULT_SUCCESS) {
                    $(button).trigger('gestureSetDeleted');
                } else {
                    // append alert
                }
            });
        }
    });

    return panel;
}

$(document).on('click', '.btn-add-gesture-set', function (event) {
    event.preventDefault();
    var titleInput = $(this).closest('.input-group').find('#input-new-set-title');
    var title = titleInput.val();
    var button = $(this);
    if (!$(button).hasClass('disabled')) {
        lockButton(button, true, 'fa-plus');
        if (title && title !== undefined && title.trim() !== '') {
            if (title.trim().length > 7) {
                clearAlerts($(this).closest('.create-gesture-set-input'));
                saveGestureSetForStudyId({studyId: null, title: title}, function (result) {
                    unlockButton(button, true, 'fa-plus');
                    if (result.status === RESULT_SUCCESS) {
                        titleInput.val('');
                        titleInput.trigger('gestureSetCreated', [result.id]);
                    }
                });
            } else {
                unlockButton(button, true, 'fa-plus');
                appendAlert($(this).closest('.create-gesture-set-input'), ALERT_GESTURE_SET_TITLE_TOO_SHORT);
            }
        } else {
            unlockButton(button, true, 'fa-plus');
            // show errors for invalid input 
        }
    }
});

function addToGestureSet(setId, gestureId) {
    var sets = getLocalItem(GESTURE_SETS);
    for (var i = 0; i < sets.length; i++) {
        if (parseInt(sets[i].id) === parseInt(setId)) {
            var gestureIsAvailable = false;
            if (sets[i].gestures && sets[i].gestures !== null && sets[i].gestures.length > 0) {
                for (var j = 0; j < sets[i].gestures.length; j++) {
                    if (parseInt(gestureId) === parseInt(sets[i].gestures[j])) {
                        gestureIsAvailable = true;
                        break;
                    }
                }
            }

            if (!gestureIsAvailable) {
                if (sets[i].gestures && sets[i].gestures !== null && sets[i].gestures.length > 0) {
                    sets[i].gestures.push(gestureId);
                } else {
                    sets[i].gestures = [gestureId];
                }
            }
        }
    }

    setLocalItem(GESTURE_SETS, sets);
}

function removeFromGestureSet(setId, gestureId) {
    var sets = getLocalItem(GESTURE_SETS);
    for (var i = 0; i < sets.length; i++) {
        if (parseInt(sets[i].id) === parseInt(setId)) {
            if (sets[i].gestures && sets[i].gestures !== null && sets[i].gestures.length > 0) {
                for (var j = 0; j < sets[i].gestures.length; j++) {
                    if (parseInt(gestureId) === parseInt(sets[i].gestures[j])) {
                        sets[i].gestures.splice(j, 1);
                        if (sets[i].gestures.length === 0) {
                            sets[i].gestures = null;
                        }
                        break;
                    }
                }
            }
        }
    }

    setLocalItem(GESTURE_SETS, sets);
}

function getAttachedGestureSets(gestureId) {
    var sets = getLocalItem(GESTURE_SETS);
    if (sets && sets.length > 0) {
        var array = new Array();
        for (var i = 0; i < sets.length; i++) {
            if (sets[i].gestures && sets[i].gestures.length > 0) {
                for (var j = 0; j < sets[i].gestures.length; j++) {
                    if (parseInt(sets[i].gestures[j]) === parseInt(gestureId)) {
                        array.push(sets[i]);
                        break;
                    }
                }
            }
        }
        return array;
    }
    return null;
}

function checkSetAssignment(gestures, gestureId) {
    if (gestures && gestures.length > 0) {
        for (var j = 0; j < gestures.length; j++) {
            if (parseInt(gestureId) === parseInt(gestures[j])) {
                return true;
            }
        }
    }
    return false;
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



/*
 * webRTC specific functions
 */

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
        if (options.tester.stream === 'yes' || options.tester.visualizeStream === 'yes' || options.tester.recordStream === 'yes') {
            return true;
        }
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

        if ((currentView === VIEW_TESTER && options.tester.recordStream === 'yes') ||
                (currentView === VIEW_MODERATOR && options.moderator.recordStream === 'yes')) {
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

/*
 * check if pidoco prototypes are used and websockets are needed for this
 */
function isPidocoSocketNeeded() {
    var phaseSteps = getContextualPhaseSteps();
    if (phaseSteps && phaseSteps.length > 0) {
        for (var i = 0; i < phaseSteps.length; i++) {
            if (isPidocoSocketNeededForPhaseStep(phaseSteps[i])) {
                return true;
            }
        }
    }
    return false;
}

function isPidocoSocketNeededForPhaseStep(phaseStep) {
    var socketNeeded = false;
    if (phaseStep) {
        var phaseStepData = getLocalItem(phaseStep.id + '.data');
        switch (phaseStep.format) {
            case IDENTIFICATION:
                break;
            case EXPLORATION:
                break;
            case GESTURE_TRAINING:
                break;
            case SCENARIO:
                socketNeeded = isPidocoSocketNeededForScenario(phaseStepData.woz);
                break;
        }
    }
    return socketNeeded;
}

function isPidocoSocketNeededForScenario(wozData) {
    if (wozData && wozData.length > 0) {
        for (var i = 0; i < wozData.length; i++) {
            if (wozData[i].transitionScenes && wozData[i].transitionScenes.length > 0) {
                for (var j = 0; j < wozData[i].transitionScenes.length; j++) {
                    var scene = getSceneById(wozData[i].transitionScenes[j].sceneId);
                    if (scene.type === SCENE_PIDOCO) {
                        return true;
                    }
                }
            }
        }
    }
    return false;
}


/*
 * for sus score visualisation
 */

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


/*
 * get current server time. This is important for the study execution
 */

function getGMT(callback) {
    getServerTime(function (result) {
        if (result.time && callback) {
            callback(result.time * 1000);
        }
    });
}


/*
 * (un)lock buttons, if waiting for system functionalitity (e.g. database update)
 */

function lockButton(button, showLoadingIndicator, originalIcon) {
    $(button).addClass('disabled');
    if (showLoadingIndicator && showLoadingIndicator === true && originalIcon) {
        $(button).find('.fa').removeClass(originalIcon).addClass('fa-spin fa-circle-o-notch');
    } else if(showLoadingIndicator && showLoadingIndicator) {
        $(button).find('.fa').addClass('fa-spin fa-circle-o-notch');
    }
}

function unlockButton(button, hideLoadingIndicator, originalIcon) {
    $(button).removeClass('disabled');
    if (hideLoadingIndicator && hideLoadingIndicator === true && originalIcon) {
        $(button).find('.fa').removeClass('fa-spin fa-circle-o-notch').addClass(originalIcon);
    } else if(hideLoadingIndicator && hideLoadingIndicator === true) {
        $(button).find('.fa').removeClass('fa-spin fa-circle-o-notch');
    }
}


/*
 * 
 */
function getGesturePreviewIndex(source) {
    var gestureImages = $(source).find('.gestureImage');
    for (var i = 0; i < gestureImages.length; i++) {
        if ($(gestureImages[i]).hasClass('previewImage')) {
            return i;
        }
    }
}

/*
 * color selector
 */

$(document).on('click', '.btn-color-selector', function (event) {
    event.preventDefault();
    if (!$(this).hasClass('selected')) {
        $(this).parent().children().removeClass('selected');
        $(this).addClass('selected');
    }
});