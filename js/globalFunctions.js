/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function checkDomain() {
    if (location.hostname.includes('localhost')) {

    } else if (!location.protocol.includes('https') || location.hostname.includes('gesturenote.com')) {
        location.href = "https://gesturenote.de";
    }
}

function checkCookies(cookiesAccepted) {
    console.log('check Cookies', cookiesAccepted);
    if (isNaN(cookiesAccepted) || cookiesAccepted === undefined || parseInt(cookiesAccepted) === 0) {
        loadHTMLintoModal('custom-modal', 'externals/modal-cookies.php', 'modal-md');

        $('#custom-modal').unbind('acceptCookies').bind('acceptCookies', function () {
            acceptCookies(function (result) {
                if (result.status === RESULT_SUCCESS) {
                } else {
                }
            });
        });

        $('#custom-modal').unbind('moreInfos').bind('moreInfos', function () {
            gotoImprint();
        });
    }
}

function checkDarkMode(darkModeEnabled) {
    if (darkModeEnabled === 11) {
        $('body').addClass('dark');
        $('body').find('.navbar-fixed-index #toggle-dark-mode .fa').removeClass('fa-moon-o').addClass('fa-sun-o');
        $('body').find('.sub-page-header #toggle-dark-mode .fa').removeClass('fa-moon-o').addClass('fa-sun-o');
        $('body').find('#preview-bar-top #toggle-dark-mode .fa').removeClass('fa-moon-o').addClass('fa-sun-o');
    }
}

function getWindowStatusHash() {
    var status = window.location.hash.substr(1);
    var statusAddressMatch = statusAddressMatchIndex(status);

    var statusHash = '';
    if (status !== '' && statusAddressMatch !== null) {
        statusHash = statusAddressMatch.id;
    }
    return statusHash;
}

function setParam(uri, key, val) {
    var newurl = uri
            .replace(new RegExp("([?&]" + key + "(?=[=&#]|$)[^#&]*|(?=#|$))"), "&" + key + "=" + encodeURIComponent(val))
            .replace(/^([^?&]+)&/, "$1?");
    //prevents browser from storing history with each change:
    window.history.replaceState({}, null, newurl);
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

// return video and audio sources
function getWebRTCSources() {
    var query = getQueryParams(document.location.search);
    var vSource = query.vSource || null;
    var aSource = query.aSource || null;
    var sources = '';
    if (vSource !== null) {
        sources += "&vSource=" + vSource;
    }
    if (aSource !== null) {
        sources += "&aSource=" + aSource;
    }
    return sources;
}

function getDomain(url, subdomain) {
    subdomain = subdomain || false;

    url = url.replace(/(https?:\/\/)?(www.)?/i, '');

    if (!subdomain) {
        url = url.split('.');

        url = url.slice(url.length - 2).join('.');
    }

    if (url.indexOf('/') !== -1) {
        return url.split('/')[0];
    }

    return url;
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
 * check form
 */

function validateEmail(email) {
    var re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
    return re.test(email);
}




/*
 * language indicator
 */
function updateLanguageIndicator(target) {
    $(target).find('#' + currentLanguage).parent().addClass('active');
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
//        $(breadcrumpItems[i]).css({opacity:0});
        TweenMax.from($(breadcrumpItems[i]), .2, {delay: .6 + (i * .05), x: -10, clearProps: 'all'});
        TweenMax.to($(breadcrumpItems[i]), .2, {delay: .6 + (i * .05), opacity: 1});
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

// origin url check for opened screen sharing window
function getPopupOrigin() {
    var origin = window.location.origin;
    return origin.includes('localhost') ? 'http://localhost' : 'https://gesturenote.de';
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

function renderSubPageElements(hasTopNavbar, isStudyCreatePage) {
    console.warn('isStudyCreatePage', isStudyCreatePage);
    var header = $('#header-footer-container').find('#sub-page-header').clone().removeAttr('id');
    header.insertBefore($('body').find('#breadcrumb'));
    header.find('#btn-sign-out').on('click', function (event) {
        event.preventDefault();
        clearLocalItems();
        goto('includes/logout.php');
    });

    header.find('#logo').on('click', function (event) {
        event.preventDefault();
        if (isStudyCreatePage && isStudyCreatePage === true) {
            jumpToId = 'btn-dashboard';

            loadHTMLintoModal('custom-modal', 'externals/modal-delete-data.php', 'modal-md');

            $('#custom-modal').unbind('deleteData').bind('deleteData', function () {
                if (editableStudyId === null) {
                    clearSceneImages();
                    clearSounds();
                }

                clearLocalItems();
                checkJumpId();
            });

            $('#custom-modal').unbind('saveDataClose').bind('saveDataClose', function () {
                $('#fixed-study-edit-controls').find('.btn-save-study').click();
            });
        } else {
            gotoIndex();
        }
    });


    if (hasTopNavbar === false) {
        header.find('#main-navigation-dropdown').addClass('hidden');
    } else {
        $(header).find('#main-navigation-dropdown .dropdown-toggle').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var expanded = $(this).attr('aria-expanded');
            if (expanded === 'false' || expanded === false) {
                var burgerMenuElements = header.find('#main-navigation-dropdown li').not('.divider');
                for (var i = 0; i < burgerMenuElements.length; i++) {
                    TweenMax.from($(burgerMenuElements[i]), .3, {delay: i * .02, opacity: 0, clearProps: 'all'});
                    TweenMax.from($(burgerMenuElements[i]).find('.fa'), .3, {delay: i * .02, x: '-10', clearProps: 'all'});
                }
            }
        });
    }

    $(header).find('#language-selection .dropdown-toggle').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var expanded = $(this).attr('aria-expanded');
        if (expanded === 'false' || expanded === false) {
            var burgerMenuElements = header.find('#language-selection li').not('.divider');
            for (var i = 0; i < burgerMenuElements.length; i++) {
                TweenMax.from($(burgerMenuElements[i]), .3, {delay: i * .02, opacity: 0, clearProps: 'all'});
                TweenMax.from($(burgerMenuElements[i]).find('.flag-small'), .3, {delay: i * .02, x: '-10', clearProps: 'all'});
            }
        }
    });

    updateLanguageIndicator($(header).find('#language-selection'));
    updateMainBurgerMenu($(header).find('.main-burger-menu'), $('body').find('#breadcrumb'));
    initPopover();

//    $(header).css({opacity: 0, position: 'relative', top: '-57px'});
//    TweenMax.to(header, .4, {opacity: 1, top: 0, ease: Quad.easeInOut, delay: .2});
}


$(document).on('click', '#toggle-dark-mode', function (event) {
    event.preventDefault();

    toggleDarkmode({darkmode: $('body').hasClass('dark') ? '0' : '1'});
    if ($('body').hasClass('dark')) {
        $('body').removeClass('dark');
        $(this).find('.fa').removeClass('fa-sun-o').addClass('fa-moon-o');
    } else {
        $('body').addClass('dark');
        $(this).find('.fa').removeClass('fa-moon-o').addClass('fa-sun-o');
    }
});

function updateMainBurgerMenu(target, breadcrump) {
    var activeId = $(breadcrump).find('.active').attr('data-id');
//    console.log(activeId, $(target).find('.' + activeId));
    $(target).find('.active').removeClass('active');
    $(target).find('.' + activeId).addClass('active');
}

$(document).on('click', '.main-burger-menu li a', function (event) {
    event.preventDefault();

    if (!$(this).parent().hasClass('active')) {
        var gotoId = $(this).parent().attr('data-id');
        switch (gotoId) {
            case 'btn-dashboard':
                gotoDashboard();
                break;
            case 'btn-studies':
                gotoStudies();
                break;
            case 'btn-gesture-styleguides':
                gotoGestureStyleguides();
                break;
            case 'btn-gesture-catalog':
                gotoGesturesCatalog();
                break;
            case 'btn-simulator':
                gotoSimulator();
                break;
            case 'btn-news':
                gotoNews();
                break;
            case 'btn-publications':
                gotoPublications();
                break;
            case 'btn-profile':
                gotoProfile();
                break;
            case 'btn-support':
                gotoSupport();
                break;
            case 'btn-informations':
                gotoInformations();
                break;
            case 'btn-imprint':
                gotoImprint();
                break;
        }
    }
});

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


$(document).on('click', '.show-dropdown', function (event) {
    event.preventDefault();
    event.stopPropagation();
    var button = $(this);
    $(button).addClass('readonly');
    $(button).blur();

    var dropdown = $(button).next().find('[data-toggle=dropdown]');
    $(dropdown).parent().unbind('hidden.bs.dropdown').bind('hidden.bs.dropdown', function (event) {
        $(button).removeClass('readonly');
        $(button).blur();
    });
    $(dropdown).dropdown('toggle');
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

$(document).on('mouseenter', '.select .option li', function (event) {
    event.preventDefault();
    if (!event.handled && !$(this).hasClass('disabled')) {
        event.handled = true;
        if ($(this).hasClass('dropdown-header') || $(this).hasClass('divider')) {
            return false;
        }

        var parent = $(this).closest('.select');
        var selectType = null;
        if ($(parent).hasClass('gestureSelect')) {
            selectType = 'gestures';
        } else if ($(parent).hasClass('sceneSelect')) {
            selectType = 'scenes';
        } else if ($(parent).hasClass('gestureDataSelect')) {
            selectType = 'gestureData';
        }
        var button = $(this);

        switch (selectType) {
            case 'gestures':
                var gesture = getGestureById($(this).attr('id'));
                renderGesturePopoverPreview(gesture, function () {
                    var popover = $('#popover-gesture');
                    var top = button.offset().top - popover.height() - 2;
                    var left = button.offset().left + parseInt(((button.width() - popover.width()) / 2));
                    popover.css({left: left, top: top});
                    playThroughThumbnails(popover.find('#gesture-preview-container'));
                    TweenMax.to(popover, .3, {autoAlpha: 1});
                });
                break;
            case 'scenes':
                var scene = getSceneById($(this).attr('id'));
                renderScenePopoverPreview(scene, function () {
                    var popover = $('#popover-scene');
                    var top = button.offset().top - popover.height() - 2;
                    var left = button.offset().left + parseInt(((button.width() - popover.width()) / 2));
                    popover.css({left: left, top: top, zIndex: 10000, position: 'absolute'});
                    TweenMax.to(popover, .3, {autoAlpha: 1});
                });
                break;
            case 'gestureData':
                var dataUrl = $(this).attr('id');
                renderLeapPopoverPreview(dataUrl, function () {
                    var popover = $('#popover-leap');
                    var top = button.offset().top - popover.height() - 2;
                    var left = button.offset().left + parseInt(((button.width() - popover.width()) / 2));
                    popover.css({left: left, top: top, zIndex: 10000, position: 'absolute'});
                    TweenMax.to(popover, .3, {autoAlpha: 1});
                });
                break;
        }
//        console.log('mouse entered', selectType);
    }
});

$(document).on('mouseleave', '.select .option li', function (event) {
    event.preventDefault();
    var parent = $(this).closest('.select');

    if ($(parent).hasClass('gestureSelect')) {
        resetGesturePopover();
    } else if ($(parent).hasClass('sceneSelect')) {
        resetScenePopover();
    } else if ($(parent).hasClass('gestureDataSelect')) {
        resetLeapPopover();
    }
});


function renderScenePopoverPreview(scene, callback) {
    var popover = $('#popover-scene-preview').clone();
    popover.attr('id', 'popover-scene');

    if (scene) {
        var sceneItem = $('#popover-' + scene.type).clone().removeAttr('id');
        $(popover).empty().append(sceneItem);

        switch (scene.type) {
            case SCENE_IMAGE:
                sceneItem.find('.imageAreaContent').attr('src', scene.parameters.url);
                break;
            case SCENE_VIDEO_EMBED:
                sceneItem.find('.videoContainer').addClass(scene.parameters.ratio === 'ratio_16_9' ? 'embed-responsive-16by9' : 'embed-responsive-4by3');
                sceneItem.find('.videoContainer').html(scene.parameters.url);
                var source = $(sceneItem).find('iframe').attr('src');
                var video = $(sceneItem).find('.videoContainer iframe');
                $(video).addClass('embed-responsive-item');
                $(video).attr('src', source + '?autoplay=1');
                break;
            case SCENE_PIDOCO:
                sceneItem.find('.web-frame').attr('src', scene.parameters.url);
                sceneItem.find('.btn-url').on('click', function (event) {
                    event.preventDefault();
                    var win = window.open(scene.parameters.url);
                    if (win) {
                        //Browser has allowed it to be opened
                        win.focus();
                    } else {
                        //Broswer has blocked it
                        alert(translation.pleaseAllowPopups);
                    }
                });
                break;
            case SCENE_WEB:
                sceneItem.find('.web-frame').attr('src', scene.parameters.url);
                break;
        }

        $('body').append(popover);

        if (callback) {
            callback(popover);
        }
    }
}

function resetScenePopover() {
    var popover = $('#popover-scene');
    $(popover).remove();
}


function renderImagePopoverPreview(imageUrl, callback) {
    var popover = $('#popover-image-preview').clone();
    popover.attr('id', 'popover-image-elem');

    if (imageUrl) {
        var image = document.createElement('img');
        $(image).css({width: '100%'}).addClass('mirroredHorizontally');

        image.onload = function () {
            if (callback) {
                callback(popover);
            }
        };

        $(image).attr('src', imageUrl);
        $(popover).empty().append(image);
        $('body').append(popover);
    }
}

function resetImagePopover() {
    var popover = $('#popover-image-elem');
    $(popover).remove();
}

function renderLeapPopoverPreview(dataUrl, callback) {
    var popover = $('#popover-leap-preview').clone();
    popover.attr('id', 'popover-leap');
    $('body').append(popover);

    var container = $(popover).find('#leap-recording-container');
    var options = {
        offset: {x: 0, y: 200, z: 0},
        previewOnly: true,
        pauseOnHands: false,
        autoplay: true,
        recording: dataUrl,
        renderTarget: $(container).find('#renderArea')
//        playbackElement: $(container).find('.btn-toggle-playback')
//        downloadJsonElement: $(popover).find('.btn-download-as-json'),
//        downloadCompressedElement: $(popover).find('.btn-download-as-compressed'),
//        playbackSliderElement: $(popover).find('#leap-playback-slider')
    };
    leapMotionPreview = new LeapRecorder(options);

    if (callback) {
        callback(popover);
    }
}

var leapMotionPreview = null;
function resetLeapPopover() {
    leapMotionPreview.destroy(true);
    leapMotionPreview = null;

    var popover = $('#popover-leap');
    $(popover).remove();
}

$(document).on('click', '.select-update .dropdown-toggle', function (event) {
    event.preventDefault();

    if (!event.handled && !$(this).hasClass('disabled')) {
        event.handled = true;

        var updateOption = $(this).parent().attr('data-update-option');
        if (updateOption !== undefined && $(this).attr('aria-expanded') !== 'false') {
            console.log('select-update');
            switch (updateOption) {
                case 'filter':
                    $(document).trigger('rerenderFilter', [$(this)]);
                    break;
            }
        }
    }
});

$(document).on('rerenderFilter', function (event, target) {
    event.preventDefault();
    var addFilterButton = $(target).closest('.filter-options-container').parent().find('.btn-add-filter-option');
    var root = $(addFilterButton).closest('.root');
    var dataRoot = $(addFilterButton).closest('.root');
    var element = $(target).closest('.root');

    if ($(addFilterButton).attr('data-root-lookups') !== undefined) {
        var rootLookups = parseInt($(addFilterButton).attr('data-root-lookups'));
        dataRoot = $(dataRoot).parents().eq(rootLookups);
    }

    var formatData = getFormatData(dataRoot);

    var filterOptionData = getFilterOptions(formatData.format, root);
    console.log('format data', formatData, filterOptionData);

    if (filterOptionData && filterOptionData.length > 0) {
        var filterOption = null;
        for (var i = 0; i < filterOptionData.length; i++) {
            if (parseInt($(element).attr('id')) === parseInt(filterOptionData[i].id)) {
                filterOption = filterOptionData[i];
                break;
            }
        }
        console.log(filterOptionData, filterOption, element);
        updateAvailableFilterOptions(formatData, dataRoot, root, element, filterOption);
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
    $('[data-toggle="popover"]').attr('data-html', true);
    $('[data-toggle="popover"]').popover({container: 'body', delay: {"show": delayShow ? delayShow : 300, "hide": delayHide ? delayHide : 0}});
}

$(document).on('mouseenter', '.btn-show-hole-text', function (event) {
    if (!event.handled) {
        initTooltips();
        event.handled = true;
        var inputVal = $(this).closest('.input-group').find('input').val();
        if (inputVal.trim() !== '') {
            $(this).attr('data-original-title', inputVal);
            $(this).tooltip({container: 'body'});
            $(this).tooltip('show');
        }
    }
});

$(document).on('click', '.btn-delete', function (event) {
    event.stopPropagation();
    event.preventDefault();
    var element = $(this).closest('.root');
    var parent = $(element).parent();
    $(this).popover('hide');

    if ($(element).attr('id') === SCENE_IMAGE) {
        var url = "../" + $(element).find('.imageAreaContent').attr('src');
        var splitUrl = url.split('/');

        if (splitUrl.length > 1 && splitUrl[1].trim() !== '') {
            deleteFiles({files: [url]}, null);
        }
    }

    if ($(element).attr('id') === TYPE_FEEDBACK_SOUND) {
        var url = ["../" + $(element).find('.audio-holder').attr('src')];
        var splitUrl = url.split('/');

        if (splitUrl.length > 1 && splitUrl[1].trim() !== '') {
            deleteFiles({files: [url]}, null);
        }
    }

    TweenMax.to(element, .15, {opacity: 0, clearProps: 'all', onComplete: onTweenDeleteComplete, onCompleteParams: [element, parent, $(this)]});
});

function onTweenDeleteComplete(element, parent, button) {
    var nextAll = $(element).nextAll();
    var next = $(element).next();
    if (next.length === 1) {
        var nextOffset = $(next).offset().top - $(element).offset().top;
        $(element).remove();

        var timeline = new TimelineMax({onComplete: afterTweenNextElements, paused: true});
        for (var i = 0; i < nextAll.length; i++) {
            timeline.add("start", 0)
                    .from(nextAll[i], .1, {y: +nextOffset, delay: i * .05, clearProps: 'y'}, "start");
        }
        timeline.play();
    } else {
        $(element).remove();
        afterTweenNextElements();
    }

    function afterTweenNextElements() {
        checkCurrentListState(parent);

        var deleteId = $(button).closest('.root').attr('id');
        updateBadges(parent, deleteId);

        if (isNaN(deleteId)) {
            deleteId = $(button).closest('.root').attr('name');
        }

        $(parent).trigger('change', [{type: 'delete', id: deleteId}]);
    }
}

$(document).on('click', '.btn-up', function (event) {
    event.preventDefault();
    event.stopPropagation();
    if (!event.handled) {
        event.handled = true;
        if (!$(this).hasClass('disabled')) {
            $(this).popover('hide');
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
            $(this).popover('hide');
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
                    .to(element, .2, {y: -offset, clearProps: 'y'}, "start")
                    .to(brother, .2, {y: heightBrother === heightElement ? offset : heightElement, clearProps: 'y'}, "start");
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
                    .to(element, ELEMENT_MOVE_TRANSITION_DURATION, {y: heightBrother === heightElement ? offset : heightBrother, clearProps: 'y'}, "start")
                    .to(brother, ELEMENT_MOVE_TRANSITION_DURATION, {y: -offset, clearProps: 'y'}, "start");
            break;
    }
}

function onMoveUpComplete(element, brother, save) {
    $(element).insertBefore(brother);
//    if (save === true) {
//        savePhases();
//    }

    $(element).find('.btn-delete').removeClass('disabled');
    $(brother).find('.btn-delete').removeClass('disabled');
    checkCurrentListState(element.closest('.root').parent());
    if (element.parent().find('.badgeId').length > 0) {
        updateBadges(element.parent(), element.attr('id'));
    }

    $(element).trigger('change', [{type: 'moved', id: $(element).attr('id')}]);

    if ((element).find('.btn-group-root .btn-up').hasClass('scroll-after-move')) {
        $('html, body').animate({
            scrollTop: $(element).offset().top - 70
        }, 300);
    }
}

function onMoveDownComplete(element, brother, save) {
    $(element).insertAfter(brother);
//    if (save === true) {
//        savePhases();
//    }

    $(element).find('.btn-delete').removeClass('disabled');
    $(brother).find('.btn-delete').removeClass('disabled');
    checkCurrentListState(element.closest('.root').parent());
    if (element.parent().find('.badgeId').length > 0) {
        updateBadges(element.parent(), element.attr('id'));
    }

    $(element).trigger('change', [{type: 'moved', id: $(element).attr('id')}]);

    if ($(element).find('.btn-group-root .btn-down').hasClass('scroll-after-move')) {
        $('html, body').animate({
            scrollTop: $(element).offset().top - 70
        }, 300);
    }
}

var currentPreviewData = null;
$(document).on('click', '.btn-preview', function (event) {
    event.preventDefault();
    if (!$(this).hasClass('disabled')) {
        $(this).popover('hide');
        var formatData = getFormatData($(this).closest('.root'));
        currentPreviewData = [formatData];
        loadHTMLintoModal('custom-modal', 'externals/modal-preview.php', 'modal-lg');
    }
});

function checkCurrentListState(itemContainer) {
    var childList = $(itemContainer).children();
    for (var i = 0; i < childList.length; i++) {
        var child = childList[i];
        var btnUp = $(child).find('.btn-up').first();
        var btnDown = btnUp.next();
        initPopover();
        $(btnUp).removeClass('disabled');

//        if ($(btnUp).length > 0) {
//            console.log(btnUp, $(btnUp));
//            $(btnUp).attr('data-content', translation.tooltips.general.moveUp).data('bs.popover').setContent();
//        }

//        if ($(btnDown).length > 0) {
        $(btnDown).removeClass('disabled');
//            $(btnDown).attr('data-content', translation.tooltips.general.moveDown).data('bs.popover').setContent();
//        }

        if (i === 0 || $(child).prev().find('.btn-down').length === 0) {
            $(btnUp).addClass('disabled');

//            if ($(btnUp).length > 0) {
////                $(btnUp).attr('data-content', '').data('bs.popover').setContent();
//            }
        }

        if (i === childList.length - 1 || $(child).next().find('.btn-up').length === 0) {
            $(btnDown).addClass('disabled');

//            if ($(btnDown).length > 0) {
//                $(btnDown).attr('data-content', '').data('bs.popover').setContent();
//            }
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

    console.log(target, gestures);

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
        console.log(targetContainer, optionalSelections);
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
        $(target).find('.option-task').attr('placeholder', translation.pleaseSelect);

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
            $(target).find('.option-task').attr('placeholder', translation.pleaseSelect);

            link = document.createElement('a');
            listItem = document.createElement('li');
            listItem.setAttribute('id', 'none');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(translation.none));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);
        } else {
            $(target).find('.taskSelect .dropdown-toggle').addClass('disabled');
            $(target).find('.option-task').attr('placeholder', translation.noTasksPresent);
        }
    }

    if (selectedItem) {
        $(dropdown).find('#' + selectedItem).addClass('selected');
        $(dropdown).parent().find('.item-input-text').val($(target).find('#' + selectedItem + ' a').text());
    }
}


/*
 * actions for scenario help item with tasks
 */
function renderAssembledGestureSets(gestureSets, targetContainer, addNoneItem) {
    var target = $('#form-item-container');
    if (targetContainer !== undefined && targetContainer !== null) {
        target = targetContainer;
    }

    var listItem, link;
    var dropdown = target === null ? $('#form-item-container').find('.select-gesture-sets') : $(target).find('.select-gesture-sets');
    var selectedItem = $(dropdown).find('.selected').attr('id');
    $(dropdown).find('.option').empty();

    if (gestureSets && gestureSets.length > 0) {
//        $(dropdown).find('.dropdown-toggle').removeClass('disabled');
        $(target).find('.dropdown-toggle').removeClass('disabled');
        $(target).find('.option-gesture-sets').attr('placeholder', translation.pleaseSelect);

        for (var i = 0; i < gestureSets.length; i++) {
            listItem = document.createElement('li');
            listItem.setAttribute('id', gestureSets[i].id);
            link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(gestureSets[i].title));
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
            $(target).find('.dropdown-toggle').removeClass('disabled');
            $(target).find('.option-gesture-sets').attr('placeholder', translation.pleaseSelect);

            link = document.createElement('a');
            listItem = document.createElement('li');
            listItem.setAttribute('id', 'none');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(translation.none));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);
        } else {
            $(target).find('.dropdown-toggle').addClass('disabled');
            $(target).find('.option-task').attr('placeholder', translation.noGestureSetPresent);
        }
    }

    if (selectedItem) {
        $(dropdown).find('#' + selectedItem).addClass('selected');
        $(dropdown).parent().find('.item-input-text').val($(target).find('#' + selectedItem + ' a').text());
    }
}


/*
 * dropdown rendering for video source selection
 */
function renderAssembledVideoSources(dropdown, sources, selectedSourceId) {
    var listItem, link;
    $(dropdown).find('.option').empty();

    if (sources && sources.length > 0) {
        $(dropdown).find('.dropdown-toggle').removeClass('disabled');
        $(dropdown).find('.item-input-text').attr('placeholder', translation.pleaseSelect);

        for (var i = 0; i < sources.length; i++) {
            listItem = document.createElement('li');
            listItem.setAttribute('id', sources[i].deviceId);
            link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(sources[i].label));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);

            if (sources[i].deviceId === selectedSourceId) {
                $(listItem).addClass('selected');
                $(dropdown).find('.item-input-text').val(sources[i].label);
            }
        }
    } else {
        $(dropdown).find('.dropdown-toggle').addClass('disabled');
        $(dropdown).find('.option-task').attr('placeholder', translation.noVideoSourcesPresent);
    }
}

/*
 * dropdown rendering for audio source selection
 */
function renderAssembledAudioSources(dropdown, sources, selectedSourceId) {
    var listItem, link;
    $(dropdown).find('.option').empty();

    if (sources && sources.length > 0) {
        $(dropdown).find('.dropdown-toggle').removeClass('disabled');
        $(dropdown).find('.item-input-text').attr('placeholder', translation.pleaseSelect);

        for (var i = 0; i < sources.length; i++) {
            listItem = document.createElement('li');
            listItem.setAttribute('id', sources[i].deviceId);
            link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(sources[i].label));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);

            if (sources[i].deviceId === selectedSourceId) {
                $(listItem).addClass('selected');
                $(dropdown).find('.item-input-text').val(sources[i].label);
            }
        }
    } else {
        $(dropdown).find('.dropdown-toggle').addClass('disabled');
        $(dropdown).find('.option-task').attr('placeholder', translation.noAudioSourcesPresent);
    }
}

/*
 * dropdown rendering for task assessment selection
 */
function renderAssembledTaskAssessments(dropdown, data, selectedId) {
    var listItem, link;
    $(dropdown).find('.option').empty();
    $(dropdown).find('.dropdown-toggle').removeClass('disabled');
    $(dropdown).find('.item-input-text').attr('placeholder', translation.pleaseSelect);

    if (data !== undefined) {
        for (var assessmentId in data) {
            listItem = document.createElement('li');
            listItem.setAttribute('id', assessmentId);
            link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(data[assessmentId].title));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);

            if (assessmentId === selectedId) {
                $(listItem).addClass('selected');
                $(dropdown).find('.chosen').attr('id', assessmentId);
                $(dropdown).find('.item-input-text').val(data[assessmentId].title);
            }
        }

        if (selectedId === undefined) {
            $($(dropdown).find('.dropdown-menu li')[0]).click();
        }
    }
}

/* 
 * Actions for the start perform gesture annotations
 */

function renderAssembledGesturePerforms(targetContainer) {
    var triggers = getLocalItem(ASSEMBLED_TRIGGER);
    var target = $('#form-item-container');
    if (targetContainer !== undefined && targetContainer !== null) {
        target = targetContainer;
    }

    var listItem, link;
    var dropdown = target === null ? $('#form-item-container').find('.performedSelect') : $(target).find('.performedSelect');
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
    }
}

/* 
 * Actions for the start perform gesture annotations
 */

function renderAssembledSensorData(targetContainer, triggerId, data) {
    var gesturesData = [];
    if (data && data.length > 0) {
        for (var i = 0; i < data.length; i++) {
            if (parseInt(triggerId) === parseInt(data[i].triggerId)) {
                data[i].index = i + 1;
                gesturesData.push(data[i]);
            }
        }
    }

    console.log(data, gesturesData, triggerId);

    var target = $('#form-item-container');
    if (targetContainer !== undefined && targetContainer !== null) {
        target = targetContainer;
    }

    var listItem, link;
    var dropdown = target === null ? $('#form-item-container').find('.gestureDataSelect') : $(target).find('.gestureDataSelect');
    $(dropdown).find('.option').empty();

    if (gesturesData && gesturesData.length > 0) {
        $(targetContainer).removeClass('hidden');
        $(dropdown).find('.dropdown-toggle').removeClass('disabled');
        $(target).find('.option-trigger').attr('placeholder', translation.pleaseSelect);

        console.log(target, dropdown, targetContainer);

        for (var i = 0; i < gesturesData.length; i++) {
            console.log('render item', gesturesData[i]);
            listItem = document.createElement('li');
            listItem.setAttribute('id', gesturesData[i].dataUrl);
            link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode('LEAP ' + gesturesData[i].index));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);
        }

        if (gesturesData.length === 1) {
            $(dropdown).find('.option').children().first().click();
            // select first item
        }
    } else {
        // append alert
        $(targetContainer).addClass('hidden');
    }
}

function resetDropdown(target) {
    $(target).find('.item-input-text').val(translation.pleaseSelect);
    $(target).find('.dropdown-menu .selected').removeClass('selected');
}


/* 
 * Actions for the questionnaire form filters
 */

function renderAtAnswerFilterOptions(target, options) {
    if (options !== null) {
        var dropdown = $(target).find('.select');
        $(dropdown).find('.option').empty();

        for (var i = 0; i < options.length; i++) {
            var listItem = document.createElement('li');
            listItem.setAttribute('id', options[i].id);

            var link = document.createElement('a');
            link.setAttribute('href', '#');
            $(link).addClass('ellipsis');
            link.appendChild(document.createTextNode(options[i].title));
            listItem.appendChild(link);

            if (options.length > 1 && i >= options.length - 1) {
                var devider = document.createElement('li');
                devider.setAttribute('class', 'divider');
                $(dropdown).find('.option').append(devider);
            }

            $(dropdown).find('.option').append(listItem);
            $(target).find('.dropdown-toggle').removeClass('disabled');
            $(target).find('.item-input-text').attr('placeholder', translation.pleaseSelect);
        }
    } else {
        $(target).find('.dropdown-toggle').addClass('disabled');
        $(target).find('.item-input-text').attr('placeholder', translation.noFilterOptionsPresent);
    }
}

function updateJumpToAnswerOptions(target, selectTarget) {
    var nextAllItems = $(target).nextAll();
//    console.log('next all', nextAllItems.length, target, nextAllItems);
    var availableOptions = null;

    if (nextAllItems.length > 0) {

        availableOptions = [];
        for (var i = 0; i < nextAllItems.length; i++) {
            availableOptions.push({id: $(nextAllItems[i]).attr('name'), title: translation.questionFormats[$(nextAllItems[i]).attr('id')].text + ' ' + $(nextAllItems[i]).find('.badgeId').text()});
        }
        availableOptions.push({id: 'nextStep', title: translation.NextStep});

        renderJumpToAnswerOptions(selectTarget, availableOptions);
    } else {
        renderJumpToAnswerOptions(selectTarget, availableOptions);
    }
}

function renderJumpToAnswerOptions(target, options) {
//    console.log('reder jump to options',target, options);
    if (options !== null) {
        var dropdown = $(target).find('.select');
        $(dropdown).find('.option').empty();

        for (var i = 0; i < options.length; i++) {
            var listItem = document.createElement('li');
            listItem.setAttribute('id', options[i].id);

            var link = document.createElement('a');
            link.setAttribute('href', '#');
            $(link).addClass('ellipsis');
            link.appendChild(document.createTextNode(options[i].title));
            listItem.appendChild(link);

            if (i >= options.length - 1) {
                var devider = document.createElement('li');
                devider.setAttribute('class', 'divider');
                $(dropdown).find('.option').append(devider);
            }

            $(dropdown).find('.option').append(listItem);
            $(target).find('.dropdown-toggle').removeClass('disabled');
            $(target).find('.item-input-text').attr('placeholder', translation.pleaseSelect);
        }
    } else {
        $(target).find('.dropdown-toggle').addClass('disabled');
        $(target).find('.item-input-text').attr('placeholder', translation.noFurtherQuestionsPresent);
    }
}

function renderRankingPosition(target, length) {
    if (length > 0) {
        var dropdown = $(target).find('.select');
        $(dropdown).find('.option').empty();

        for (var i = 0; i < length; i++) {
            var listItem = document.createElement('li');
            listItem.setAttribute('id', (i + 1));

            var link = document.createElement('a');
            link.setAttribute('href', '#');
            $(link).addClass('ellipsis');
            link.appendChild(document.createTextNode((i + 1)));
            listItem.appendChild(link);


            $(dropdown).find('.option').append(listItem);
            $(target).find('.dropdown-toggle').removeClass('disabled');
            $(target).find('.item-input-text').attr('placeholder', translation.pleaseSelect);
        }
    } else {
        $(target).find('.dropdown-toggle').addClass('disabled');
        $(target).find('.item-input-text').attr('placeholder', translation.noFurtherQuestionsPresent);
    }
}


var wobbling = false;
function wobble(elements, overrideWobbling) {
    if (!wobbling || (overrideWobbling && overrideWobbling === true)) {
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

$(document).on('mouseleave', '.btn-checkbox, .btn-radio', function (event) {
    event.preventDefault();
    $(this).blur();
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
            $(audioHolder).attr('src', feedback.parameters.url);
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

function getMainDimensionForDimension(dimension, mDimensions) {
    var mainDimensions = translation.mainDimensionsForDimension;
    if (mDimensions) {
        mainDimensions = mDimensions;
    }
    return mainDimensions[dimension];
}

function getDimensionByElement(element) {
    var dimension = $(element).attr('data-dimension');
    if (dimension) {
        return dimension;
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
            $(brothers[i]).find('.btn-pause-gesture').click();
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
            $(this).closest('.gesture-thumbnail').find('.tagged-symbol').removeClass('hidden');
            assemble = true;
        } else {
            $(this).attr('data-content', translation.addToStudyGestureSet).data('bs.popover').setContent();
            $(this).removeClass('assembled');
            $(this).find('.fa').removeClass('fa-minus-square').addClass('fa-plus-square');
            $(this).closest('.gesture-thumbnail').removeClass('assembled');
            $(this).closest('.gesture-thumbnail').find('.tagged-symbol').addClass('hidden');
        }

        $(this).trigger('change', [gestureId, assemble, rerender]);
    }
});

$(document).on('click', '.btn-tag-as-mapping-gesture', function (event) {
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
            $(this).closest('.gesture-thumbnail').find('.tagged-symbol').removeClass('hidden');
            assemble = true;
        } else {
            $(this).attr('data-content', translation.addToStudyGestureSet).data('bs.popover').setContent();
            $(this).removeClass('assembled');
            $(this).find('.fa').removeClass('fa-minus-square').addClass('fa-plus-square');
            $(this).closest('.gesture-thumbnail').removeClass('assembled');
            $(this).closest('.gesture-thumbnail').find('.tagged-symbol').addClass('hidden');
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
            $(this).attr('data-content', translation.removeFromTrigger).data('bs.popover').setContent();
            $(this).addClass('assembled');
            $(this).find('.fa').removeClass('fa-plus-square').addClass('fa-minus-square');
            $(this).closest('.gesture-thumbnail').addClass('assembled');
            $(this).closest('.gesture-thumbnail').find('.tagged-symbol').removeClass('hidden');
            assemble = true;
        } else {
            $(this).attr('data-content', translation.addToTrigger).data('bs.popover').setContent();
            $(this).removeClass('assembled');
            $(this).find('.fa').removeClass('fa-minus-square').addClass('fa-plus-square');
            $(this).closest('.gesture-thumbnail').removeClass('assembled');
            $(this).closest('.gesture-thumbnail').find('.tagged-symbol').addClass('hidden');
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

function filter(filterId) {
    var array = new Array();
    if (!filterId) {
        filterId = $(currentPaginationData.filter.filter).find('.chosen').attr('id');
    }



    if (filterId === 'all') {
        return originalFilterData;
    } else if (originalFilterData && originalFilterData.length > 0) {
        for (var i = 0; i < originalFilterData.length; i++) {
            if (originalFilterData[i].setOnly === false || !originalFilterData[i].setOnly) {
                if (filterId === SOURCE_GESTURE_RECORDED && originalFilterData[i].isOwner === true && originalFilterData[i].source === SOURCE_GESTURE_EVALUATOR) {
//                    if () {
                    array.push(originalFilterData[i]);
//                    }
                } else if (filterId === SCOPE_GESTURE_LIKED && originalFilterData[i].hasLiked === true) {
                    array.push(originalFilterData[i]);
                } else if (filterId === SCOPE_GESTURE_RATED && originalFilterData[i].hasRated === true) {
                    array.push(originalFilterData[i]);
                } else if (originalFilterData[i].data && originalFilterData[i].data.generalData && (originalFilterData[i].data.generalData.phase === filterId || originalFilterData[i].data.generalData.surveyType === filterId)) {
                    array.push(originalFilterData[i]);
                } else if ((filterId === 'generic' && originalFilterData[i].titleQuality === 'generic') || (filterId === 'functional' && originalFilterData[i].titleQuality === 'functional')) {
                    array.push(originalFilterData[i]);
                } else if (filterId === 'public') {
                    if (originalFilterData[i].isOwner === true && (originalFilterData[i].scope === filterId || (originalFilterData[i].invitedUsers && originalFilterData[i].invitedUsers.length > 0))) {
                        array.push(originalFilterData[i]);
                    }
                } else if (filterId === 'sharedWithYou') {
                    if (originalFilterData[i].isOwner === false) {
                        array.push(originalFilterData[i]);
                    }
                } else if (filterId === 'private' && originalFilterData[i].isOwner === true) {
//                    if() {
                    if (originalFilterData[i].scope === filterId && !originalFilterData[i].invitedUsers) {
                        array.push(originalFilterData[i]);
                    } else if (!originalFilterData[i].scope && !originalFilterData[i].invitedUsers) {
                        array.push(originalFilterData[i]);
                    }
//                        else if(!originalFilterData[i].invitedUsers || (originalFilterData[i].invitedUsers && originalFilterData[i].invitedUsers.length === 0)) {
//                            array.push(originalFilterData[i]);
//                        }
//                    }
//                    if (originalFilterData[i].isOwner === true && (originalFilterData[i].scope === filterId || !originalFilterData[i].invitedUsers || (originalFilterData[i].shared && parseInt(originalFilterData[i].shared) > 0))) {
//                        array.push(originalFilterData[i]);
//                    }
                } else if (filterId === 'tester' && originalFilterData[i].source === 'tester') {
                    array.push(originalFilterData[i]);
                }
            }
        }
    }

    console.log('filter', filterId, originalFilterData, array);
    return array;
}



/*
 * searching
 */

var searchfilterTimeout = null;
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
        clearTimeout(searchfilterTimeout);
        if (filter.trim() !== "" && event.keyCode !== 27) {
            var matched = searchThroughArray(sort(), filter.trim());
            searchfilterTimeout = setTimeout(function () {
                currentFilterData = matched;
                updatePaginationItems();
                $(container).trigger('renderData', [matched]);
            }, 500);
        } else {
            if (event.keyCode === 27) {
                $(this).val('');
                currentFilterData = sort();
                updatePaginationItems();
                $(container).trigger('renderData', [currentFilterData]);
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

function addSeconds(date, amount) {
    return new Date(new Date(date).getTime() + (1000 * amount));
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
var currentPreviewTrigger = null;
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
    initDeleteGestureFromSet($(clone).find('.btn-delete-gesture-from-set'), clone, source, data);
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
    clone.find('.gesture-name').attr('data-content', translation.gestureNameQualities[data.titleQuality].title);
    clone.find('#gesture-scope .label-text').text(translation.gestureScopes[data.scope]);
    clone.find('#gesture-scope #' + data.scope).removeClass('hidden');

    if (data.type && data.interactionType) {
        clone.find('.symbol-gesture-execution').addClass(data.type);
        clone.find('.symbol-container-gesture-execution').attr('data-content', translation.gestureTypes[data.type + 's'] + ' ' + translation.gestureType);
        clone.find('.text-gesture-execution').text(translation.gestureTypes[data.type + 'Short']);
        clone.find('.symbol-gesture-interaction').addClass(data.interactionType);
        clone.find('.symbol-container-gesture-interaction').attr('data-content', translation.gestureInteractionTypes[data.interactionType + 's'] + ' ' + translation.gestureInteraction);
        clone.find('.text-gesture-interaction').text(translation.gestureInteractionTypes[data.interactionType + 'Short']);
    } else {
        clone.find('.gesture-info-symbols').addClass('hidden');
    }

    if (data.sensorData) {
        $(clone).find('.symbol-container-sensor').removeClass('hidden');
        $(clone).find('.symbol-container-sensor').attr('data-content', translation.sensors[data.sensorData.sensor].title);

        switch (data.sensorData.sensor) {
            case TYPE_RECORD_LEAP:
                $(clone).find('.symbol-container-sensor .text-sensor-leap').removeClass('hidden');
                break;
            case TYPE_RECORD_KINECT:
                $(clone).find('.symbol-container-sensor .text-sensor-kinect').removeClass('hidden');
                break;
        }
    }

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

    renderGestureImages(clone.find('.previewGesture'), data.images, data.previewImage, null);

    $(clone).find('.gesture-thumbnail').mouseenter(function (event) {
        event.preventDefault();
        var loadedAllImages = $(this).find('.previewGesture').attr('data-loaded-all-images') === 'true';
        if (gesturePreviewOpened === false && loadedAllImages) {
            playThroughThumbnails($(this).find('#gesture-preview-container'), 0);
        }
    });

    $(clone).find('.gesture-thumbnail').mouseleave(function (event) {
        event.preventDefault();
        if (gesturePreviewOpened === false) {
            clearTimer();
            resetThumbnails($(this).find('#gesture-preview-container'));
        }
    });

    initPopover();

    return clone;
}

function initMoreInfoGesture(button, clone, data, source, modalId) {
    $(button).click(function (event) {
        console.log('init more info gesture', button, clone, data, source, modalId);
        event.preventDefault();
        $(button).popover('hide');
        clearTimer();
        resetThumbnails($(clone).find('.previewGesture'));
        currentPreviewGesture = {gesture: getGestureById(data.id, source), source: source, thumbnail: clone};
        gesturePreviewOpened = true;
        $(clone).find('.btn-pause-gesture').click();

        if (modalId) {
            loadHTMLintoModal('custom-modal', 'externals/' + modalId + '.php', 'modal-lg');
        } else {
            loadHTMLintoModal('custom-modal', 'externals/modal-gesture.php', 'modal-lg');
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
        clearTimer();
        resetThumbnails($(clone).find('.previewGesture'));
        currentPreviewGesture = {gesture: getGestureById(data.id, source), source: source, thumbnail: clone, startTab: 'comments'};
        gesturePreviewOpened = true;
        $(clone).find('.btn-pause-gesture').click();
        loadHTMLintoModal('custom-modal', 'externals/modal-gesture.php', 'modal-lg');
    });
}

function initGestureSet(button, clone, source, data) {
    if (button && button !== undefined) {
        var gestureSets = getLocalItem(GESTURE_SETS);
        if (gestureSets) {
            update(gestureSets);
        } else {
            button.remove();
            return false;
        }

        function update(sets) {
            var titles = '';
            var setCount = 0;
            for (var i = 0; i < sets.length; i++) {
                var gestureSetIds = sets[i].gestures;
                if (gestureSetIds) {
                    for (var j = 0; j < gestureSetIds.length; j++) {
                        if (parseInt(data.id) === parseInt(gestureSetIds[j])) {
                            titles += '<div class="ellipsis">' + sets[i].title + '</div>';
                            setCount++;
                        }
                    }
                }
            }
            if (setCount > 0) {
                button.addClass('gesture-is-in-set');
                button.attr('data-content', titles);
                button.find('.amount').text(setCount);
            } else {
                button.attr('data-content', translation.notAssignedToGestureSet);
            }
            initPopover();
        }

        $(button).click(function (event) {
            event.preventDefault();
            $(button).popover('hide');
            clearTimer();
            resetThumbnails($(clone).find('.previewGesture'));
            currentPreviewGesture = {gesture: getGestureById(data.id, source), source: source, thumbnail: clone, startTab: 'gestureSets'};
            gesturePreviewOpened = true;
            $(clone).find('.btn-pause-gesture').click();
            loadHTMLintoModal('custom-modal', 'externals/modal-gesture.php', 'modal-lg');
        });
    }
}

function initShareGesture(button, clone, source, data, callback) {
    updateGestureThumbnailSharing(clone, data);

    $(button).click(function (event) {
        event.preventDefault();
        $(button).popover('hide');
        clearTimer();
        resetThumbnails($(clone).find('.previewGesture'));
        currentPreviewGesture = {gesture: getGestureById(data.id), source: source, thumbnail: clone, startTab: 'shareGesture'};
        gesturePreviewOpened = true;
        $(clone).find('.btn-pause-gesture').click();
        loadHTMLintoModal('custom-modal', 'externals/modal-gesture.php', 'modal-lg');
    });
}

function initShareGestureModalButton(button, clone, source, data, callback) {
    $(button).click(function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(button).popover('hide');
            lockButton(button, true, 'fa-share-alt');
            showCursor($('body'), CURSOR_PROGRESS);
            console.log(currentPreviewGesture.gesture.scope);

            if (currentPreviewGesture.gesture.scope === SCOPE_GESTURE_PRIVATE) {
                shareGesture({gestureId: currentPreviewGesture.gesture.id}, function (result) {
                    showCursor($('body'), CURSOR_DEFAULT);
                    unlockButton(button, true, 'fa-share-alt');

                    if (result.status === RESULT_SUCCESS) {
                        updateGestureById(source, currentPreviewGesture.gesture.id, {scope: SCOPE_GESTURE_PUBLIC});
                        currentPreviewGesture.gesture = getGestureById(currentPreviewGesture.gesture.id, source);
                        updateGestureThumbnailSharing(currentPreviewGesture.thumbnail, currentPreviewGesture.gesture);

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
                unshareGesture({gestureId: currentPreviewGesture.gesture.id}, function (result) {
                    showCursor($('body'), CURSOR_DEFAULT);
                    unlockButton(button, true, 'fa-share-alt');

                    if (result.status === RESULT_SUCCESS) {
                        updateGestureById(source, currentPreviewGesture.gesture.id, {scope: SCOPE_GESTURE_PRIVATE});
                        currentPreviewGesture.gesture = getGestureById(currentPreviewGesture.gesture.id, source);
                        updateGestureThumbnailSharing(currentPreviewGesture.thumbnail, currentPreviewGesture.gesture);

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

function initShareGestureSetModalButton(button, clone, source, data, callback) {
    updateGestureSetThumbnailSharing(clone, data);

    $(button).click(function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(button).popover('hide');
            lockButton(button, true, 'fa-share-alt');
            showCursor($('body'), CURSOR_PROGRESS);
            console.log(currentPreviewGestureSet.set.scope);

            if (currentPreviewGestureSet.set.scope === SCOPE_GESTURE_PRIVATE) {
                shareGestureSet({setId: currentPreviewGestureSet.set.id}, function (result) {
                    showCursor($('body'), CURSOR_DEFAULT);
                    unlockButton(button, true, 'fa-share-alt');

                    if (result.status === RESULT_SUCCESS) {
                        updateGestureSetById(GESTURE_SETS, currentPreviewGestureSet.set.id, {scope: SCOPE_GESTURE_PUBLIC});
                        currentPreviewGestureSet.set = getGestureSetById(currentPreviewGestureSet.set.id);
                        updateGestureSetThumbnailSharing(currentPreviewGestureSet.thumbnail, currentPreviewGestureSet.set);

                        // check if update list needed after updateGesture() call
                        if ($(button).hasClass('update-list-view')) {
                            getGestureSets(function (result) {
                                if (result.status === RESULT_SUCCESS) {
                                    originalFilterData = result.gestureSets;
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
                unshareGestureSet({setId: currentPreviewGestureSet.set.id}, function (result) {
                    showCursor($('body'), CURSOR_DEFAULT);
                    unlockButton(button, true, 'fa-share-alt');

                    if (result.status === RESULT_SUCCESS) {
                        updateGestureSetById(GESTURE_SETS, currentPreviewGestureSet.set.id, {scope: SCOPE_GESTURE_PRIVATE});
                        currentPreviewGestureSet.set = getGestureSetById(currentPreviewGestureSet.set.id);
                        updateGestureSetThumbnailSharing(currentPreviewGestureSet.thumbnail, currentPreviewGestureSet.set);

                        // check if this is needed after updateGesture() call
                        if ($(button).hasClass('update-list-view')) {
                            getGestureCatalog(function (result) {
                                if (result.status === RESULT_SUCCESS) {
                                    originalFilterData = result.gestureSets;
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

function updateGestureThumbnailSharing(thumbnail, gesture) {
    var button = $(thumbnail).find('.btn-share');



    if (gesture.scope === SCOPE_GESTURE_PRIVATE) {
        var shareAmount = gesture.invitedUsers ? gesture.invitedUsers.length : 0;
        $(button).find('.amount').text(shareAmount > 0 ? shareAmount : '');
//console.log('update gesture thumbnail sharing', gesture, shareAmount);

        if (shareAmount > 0) {
            if (gesture.isOwner === true) {
                if (shareAmount > 7) {
                    $(button).attr('data-content', new String(translation.gestureSharedWithOthers).replace('{x}', shareAmount));
                } else {
                    var titles = '';
                    var setCount = 0;
                    for (var i = 0; i < gesture.invitedUsers.length; i++) {
                        var email = gesture.invitedUsers[i].email;
                        if (email) {
                            titles += '<div class="ellipsis">' + email + '</div>';
                            setCount++;
                        }
                    }

                    button.attr('data-content', titles);
                }
            } else {
                $(button).attr('data-content', translation.gestureSharedWithYou);
            }

            $(button).addClass('gesture-shared');
        } else {
            if (gesture.isOwner === true) {
                $(button).removeClass('gesture-shared');
                $(button).attr('data-content', translation.shareGesture);
            } else {
                // not for study gestures, because there were rendered als shared gestures
//                $(button).addClass('gesture-shared');
//                $(button).attr('data-content', translation.gestureSharedWithYou);
            }
        }
    } else {
        $(button).addClass('gesture-shared');
        $(button).find('.amount').html('&infin;');
        $(button).attr('data-content', translation.gestureShared);
    }
}

function updateGestureSetThumbnailSharing(thumbnail, set) {
    var button = $(thumbnail).find('.btn-share-set');

    if (set.scope === SCOPE_GESTURE_PRIVATE) {
        var shareAmount = set.invitedUsers ? set.invitedUsers.length : 0;
        $(button).find('.amount').text(shareAmount > 0 ? shareAmount : '');
        if (shareAmount > 0) {
            if (set.isOwner === true) {
                if (shareAmount > 7) {
                    $(button).attr('data-content', new String(translation.gestureSetSharedWithOthers).replace('{x}', shareAmount));
                } else {
                    var titles = '';
                    var setCount = 0;
                    for (var i = 0; i < set.invitedUsers.length; i++) {
                        var email = set.invitedUsers[i].email;
                        if (email) {
                            titles += '<div class="ellipsis">' + email + '</div>';
                            setCount++;
                        }
                    }

                    button.attr('data-content', titles);
                }
            } else {
                $(button).attr('data-content', translation.gestureSetSharedWithYou);
            }

            $(button).addClass('gesture-set-shared');
        } else {
            $(button).removeClass('gesture-set-shared');
            $(button).attr('data-content', translation.shareSetGesture);
        }
    } else {
        $(button).addClass('gesture-set-shared');
        $(button).find('.amount').html('&infin;');
        $(button).attr('data-content', translation.gestureSetShared);
    }
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
        clearTimer();
        resetThumbnails($(clone).find('.previewGesture'));
        currentPreviewGesture = {gesture: getGestureById(data.id, source), source: source, thumbnail: clone, startTab: 'rating'};
        gesturePreviewOpened = true;
        $(clone).find('.btn-pause-gesture').click();
        loadHTMLintoModal('custom-modal', 'externals/modal-gesture.php', 'modal-lg');
    });
}

function initDeleteGestureFromSet(button, clone, source, data) {
    if (button) {
        $(button).unbind('click').bind('click', function (event) {
            event.preventDefault();
            console.log('delete from set and save set');
            var gestureId = $(button).closest('.root').attr('id');
            lockButton(button, true, 'fa-trash');
            $(button).popover('hide');
            var gestureSet = getGestureSetById(currentPreviewGestureSet.set.id);
            var tempSetGestureIds = [];
            for (var i = 0; i < gestureSet.gestures.length; i++) {
                if (parseInt(gestureId) !== parseInt(gestureSet.gestures[i])) {
                    tempSetGestureIds.push(gestureSet.gestures[i]);
                }
            }
            updateGestureSetById(GESTURE_SETS, currentPreviewGestureSet.set.id, {gestures: tempSetGestureIds.length === 0 ? null : tempSetGestureIds});
            currentPreviewGestureSet.set = getGestureSetById(currentPreviewGestureSet.set.id);
            updateGestureSet({setId: currentPreviewGestureSet.set.id, title: currentPreviewGestureSet.set.title, gestures: currentPreviewGestureSet.set.gestures, ownerId: currentPreviewGestureSet.set.userId}, function (result) {
                unlockButton(button, true, 'fa-trash');
                if (result.status === RESULT_SUCCESS) {
                    console.log('gesture set updated');
                    $(button).trigger('removedGestureFromSet', [gestureId]);
                } else {
                    // append alert
                }
            });
            console.log('temp gestures', tempSetGestureIds);
        });
    }
}

function getCreateStudyGestureListThumbnail(data, typeId, layout, source, panelStyle, modalId) {
    if (!source || source === null || source === undefined) {
        source = GESTURE_CATALOG;
    }

    var clone = initGestureThumbnail(data, typeId, layout, panelStyle);
    initMoreInfoGesture($(clone).find('.btn-show-gesture-info'), clone, data, source, modalId);
    initGestureSet($(clone).find('.btn-edit-gesture-set'), clone, source, data);

    var isGestureAss = isGestureAssembled(data.id);
    if (isGestureAss) {
        clone.find('.btn-tag-as-favorite-gesture').attr('data-content', 'Vom Studien-Gesten-Set entfernen');
        clone.find('.gesture-thumbnail').addClass('assembled');
        clone.find('.btn-tag-as-favorite-gesture').addClass('assembled');
        clone.find('.btn-tag-as-favorite-gesture .fa').removeClass('fa-plus-square').addClass('fa-minus-square');
        clone.find('.tagged-symbol').removeClass('hidden');
        clone.find('.tagged-symbol').attr('data-content', 'Dem Studien-Gesten-Set zugewiesen');
        initPopover();
    }

    return clone;
}

function getCreateExtractionMappingGestureListThumbnail(data, assembledGestures, typeId, layout, source, panelStyle, modalId) {
    if (!source || source === null || source === undefined) {
        source = GESTURE_CATALOG;
    }

    var clone = initGestureThumbnail(data, typeId, layout, panelStyle);
    initMoreInfoGesture($(clone).find('.btn-show-gesture-info'), clone, data, source, modalId);
    initGestureSet($(clone).find('.btn-edit-gesture-set'), clone, source, data);

    console.log(assembledGestures, data.id)
    if (assembledGestures && assembledGestures.length > 0) {
        for (var i = 0; i < assembledGestures.length; i++) {
            if (parseInt(assembledGestures[i]) === parseInt(data.id)) {
                clone.find('.btn-tag-as-mapping-gesture').attr('data-content', 'Zuweisung entfernen');
                clone.find('.gesture-thumbnail').addClass('assembled');
                clone.find('.btn-tag-as-mapping-gesture').addClass('assembled');
                clone.find('.btn-tag-as-mapping-gesture .fa').removeClass('fa-plus-square').addClass('fa-minus-square');
                clone.find('.tagged-symbol').removeClass('hidden');
                clone.find('.tagged-symbol').attr('data-content', 'Dem Studien-Gesten-Set zugewiesen');
                initPopover();
            }
        }
    } else {
        setTimeout(function () {
            $(clone).find('.btn-tag-as-mapping-gesture').click();
        }, 200);
    }

    return clone;
}

function getGestureSceneListThumbnail(data, typeId, layout, source, panelStyle) {
    if (!source || source === null || source === undefined) {
        source = GESTURE_CATALOG;
    }

    var clone = initGestureThumbnail(data, typeId, layout, panelStyle);
    initMoreInfoGesture($(clone).find('.btn-show-gesture-info'), clone, data, source);
    initGestureSet($(clone).find('.btn-edit-gesture-set'), clone, source, data);

    return clone;
}

function getSimpleGestureListThumbnail(data, typeId, layout) {
    var clone = initGestureThumbnail(data, typeId, layout);
    return clone;
}


/*
 * study catalog list items
 */

function getStudiesCatalogListThumbnail(target, data) {
    var clone = $('#studies-catalog-thumbnail').clone().removeClass('hidden').removeAttr('id');
    if (data.data) {
        clone.attr('id', data.id);
        clone.find('.title-text').text(data.data.generalData.title);
        $(target).append(clone);

        initPopover();

        if (data.data.generalData.method === 'userCentered') {

            $(clone).find('#study-plan').removeClass('hidden');

            if ((data.data.generalData.dateFrom !== null && data.data.generalData.dateFrom !== "") &&
                    (data.data.generalData.dateTo !== null && data.data.generalData.dateTo !== "")) {

                var dateFrom = data.data.generalData.dateFrom * 1000;
                var dateTo = addDays(data.data.generalData.dateTo * 1000, 1);
                var totalDays = rangeDays(dateFrom, dateTo);

                var now = new Date().getTime();
                var progress = 0;
                $(clone).find('#study-range-days .address').text(translation.studyRun + ": ");

                if (now > dateFrom && now < dateTo) {
                    var left = getTimeLeftForTimestamp(dateTo, 1);
                    var statusText = $(clone).find('.study-started').removeClass('hidden').find('.status-text');
                    progress = (now - dateFrom) / (dateTo.getTime() - dateFrom) * 100;//daysExpired / totalDays * 100;
                    $(statusText).text(translation.studyStarted + ', ' + translation.still + ' ' + left.days + ' ' + (left.days === 1 ? translation.day : translation.days) + ', ' + left.hours + ' ' + (left.hours === 1 ? translation.hour : translation.hours));
                    $(clone).find('.progress-bar').addClass('progress-bar-success');
                    $(clone).find('#participant-count').removeClass('hidden').find('.label-text').text(0);
                    $(clone).find('#participant-count').attr('data-content', '0 ' + translation.participations).data('bs.popover').setContent();
                    var hourglass = $(clone).find('.study-started .fa');
                    TweenMax.to(hourglass, 2, {rotation: '360', repeat: -1, ease: Quad.easeInOut});
                    TweenMax.to($(statusText), 1, {delay: 0, css: {marginLeft: '8'}, yoyo: true, repeat: -1, ease: Quad.easeIn});
                } else if (now < dateFrom) {
                    progress = 100;
                    var daysToStart = Math.round((dateFrom - now) / (1000 * 60 * 60 * 24));
                    $(clone).find('.study-not-started').removeClass('hidden').find('.status-text').text(translation.startsAt + ' ' + daysToStart + ' ' + (daysToStart === 1 ? translation.day : translation.daysn));
                    $(clone).find('.progress-bar').addClass('progress-bar-warning');
                } else if (now > dateTo) {
                    progress = 100;
                    $(clone).find('#study-range-days .address').text(translation.studyRuns + ": ");
                    $(clone).find('.study-ended').removeClass('hidden').find('.status-text').text(translation.studyEnded);
                    $(clone).find('.progress-bar').addClass('progress-bar-info');
                    $(clone).find('#participant-count').removeClass('hidden').find('.label-text').text(translation.none);
                }

                if (parseInt(data.participants) > 0) {
                    $(clone).find('#participant-count').removeClass('hidden').find('.label-text').text(data.participants);
                    $(clone).find('#participant-count').attr('data-content', data.participants + ' ' + (parseInt(data.participants) === 1 ? translation.participation : translation.participations)).data('bs.popover').setContent();
                }

                $(clone).find('#participant-count').unbind('click').bind('click', {studyId: data.id}, function (event) {
                    event.stopImmediatePropagation();
                    event.preventDefault();
                    $(clone).trigger('gotoStudyParticipants', [{studyId: event.data.studyId}]);
                });

                if (data.isOwner === false) {
                    $(clone).find('#shared-study').removeClass('hidden');
                    $(clone).find('#shared-study').attr('data-content', translation.sharedStudy);
                } else if (data.isOwner === true) {
                    var shareAmount = data.invitedUsers && data.invitedUsers.length > 0 ? data.invitedUsers && data.invitedUsers.length : 0;
                    if (shareAmount > 7) {
                        $(clone).find('#shared-study').removeClass('hidden').find('.label-text').text(data.invitedUsers.length);
                        $(clone).find('#shared-study').attr('data-content', data.invitedUsers.length + ' ' + translation.sharedInfo);
                    } else if (shareAmount > 0) {
                        $(clone).find('#shared-study').removeClass('hidden').find('.label-text').text(data.invitedUsers.length);
                        var titles = '';
                        var setCount = 0;
                        for (var i = 0; i < data.invitedUsers.length; i++) {
                            var email = data.invitedUsers[i].email;
                            if (email) {
                                titles += '<div class="ellipsis">' + email + '</div>';
                                setCount++;
                            }
                        }

                        $(clone).find('#shared-study').attr('data-content', titles);
                    } else {
                        $(clone).find('#shared-study').addClass('hidden');
                    }
                }


                $(clone).find('.progress-bar').css({width: progress + "%"});
                $(clone).find('#study-range-days .text').text(totalDays + ' ' + (parseInt(totalDays) === 1 ? translation.day : translation.days));

                if (now > dateFrom && now < dateTo) {
                    TweenMax.from($(clone).find('.progress-bar'), 1, {delay: .3, width: "0%", opacity: 0});
                }
            } else {
                $(clone).find('#study-range-days .address').text(translation.studyRun + ": ");
                $(clone).find('#study-range-days .status-text').text('0 ' + translation.days);
                $(clone).find('.study-no-plan').removeClass('hidden').find('.text').text(translation.studyNoPlan);
                $(clone).find('.progress-bar').addClass('progress-bar-danger');
            }
        } else if (data.data.generalData.method === 'expertBased') {
            $(clone).find('#study-plan').remove();
            $(clone).find('.panel-body-progress').remove();
        }

        var descriptionText = data.data.generalData.description.length < 100 ? data.data.generalData.description : data.data.generalData.description.substring(0, 200) + ' …';
        $(clone).find('#study-description').text(descriptionText);

        $(clone).find('#type-method').text(translation.methodType[data.data.generalData.method]);
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


/*
 * gesture set panel functionalities
 */

function getGestureCatalogGestureSetPanel(data, type, layout) {
    var panel = initGestureSetPanel(data, 'study-gesture-set-panel');
    initLikeGestureSet($(panel).find('.btn-like-set'), data);
    initShareGestureSet($(panel).find('.btn-share-set'), panel, data);
    initCommentGestureSet($(panel).find('.btn-comment-set'), panel, data);
    initMoreInfoGestureSet($(panel).find('.btn-show-set-info'), panel, data);
    initStandardGestureSetList(panel, data, type, layout);
    initGestureSetSimulation(panel, data);

    if (data.isOwner === true) {
        $(panel).find('#btn-delete-gesture-set').unbind('click').bind('click', {setId: data.id}, function (event) {
            event.preventDefault();
            var button = $(this);
            var setId = event.data.setId;

            if (!$(button).hasClass('disabled')) {
                lockButton(button, true, 'fa-trash');
                $(button).popover('hide');

                $('#custom-modal').unbind('deleteData').bind('deleteData', function (event) {
                    event.preventDefault();

                    deleteGestureSet({setId: setId}, function (result) {
                        unlockButton(button, true, 'fa-trash');
                        if (result.status === RESULT_SUCCESS) {
                            $('#custom-modal').unbind('deleteData');
                            $(button).trigger('gestureSetDeleted');
                        } else {
                            // append alert
                        }
                    });
                });

                $('#custom-modal').unbind('cancel').bind('cancel', function (event) {
                    event.preventDefault();
                    unlockButton(button, true, 'fa-trash');
                });

                loadHTMLintoModal('custom-modal', 'externals/modal-delete-gesture-set.php', 'modal-sm');


            }
        });
    } else {
        $(panel).find('#btn-delete-gesture-set').parent().remove();
    }

    return panel;
}

function getGestureSetPanel(data, type, layout) {
    var panel = initGestureSetPanel(data, 'create-study-gesture-set-panel');
    initLikeGestureSet($(panel).find('.btn-like-set'), data);
    initShareGestureSet($(panel).find('.btn-share-set'), panel, data);
    initCommentGestureSet($(panel).find('.btn-comment-set'), panel, data);
    initMoreInfoGestureSet($(panel).find('.btn-show-set-info'), panel, data);
    initAssembledGestureSetList(panel, data, type, layout);

    $(panel).find('#btn-mark-hole-set').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(this).popover('hide');
        if ($(this).hasClass('marked')) {
            $(this).removeClass('marked');
            $(this).find('.fa').removeClass('fa-minus-square').addClass('fa-plus-square');
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
            $(this).find('.fa').removeClass('fa-plus-square').addClass('fa-minus-square');
            $(this).attr('data-content', translation.removeAllGesturesFromStudyGestureSet).data('bs.popover').setContent();
            var unassembledGestures = $(panel).find('#gestures-list-container .btn-tag-as-favorite-gesture:not(.assembled)');
            $(unassembledGestures).click();
        }
    });

    return panel;
}

function initGestureSetPanel(data, panelId) {
    var panel = null;
    if (panelId) {
        panel = $('#' + panelId).clone();
    } else {
        panel = $('#create-study-gesture-set-panel').clone();
    }
    $(panel).find('.panel-heading .panel-heading-text').text(data.title);

    $(panel).find('#btn-download-as-json').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(this).popover('hide');
        if (!$(this).hasClass('disabled')) {
            downloadGestureSetAsJSON($(panel).find('.gesture-thumbnail'), data.title);
        }
    });

    $(panel).find('#btn-download-as-exchangeable').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(this).popover('hide');
        if (!$(this).hasClass('disabled')) {
            downloadGestureSetAsExchangeable($(panel).find('.gesture-thumbnail'), data.title);
        }
    });

    return panel;
}


function initLikeGestureSet(button, data, callback) {
//    console.log(button, data.hasLiked);
    $(button).find('.amount').text(parseInt(data.likeAmount) === 0 ? '' : data.likeAmount);
    if (data.hasLiked) {
        $(button).attr('data-content', translation.likedGestureSetByMyself);
        $(button).addClass('gesture-set-liked');
        $(button).find('.fa').removeClass('fa-heart-o').addClass('fa-heart');
    } else {
        $(button).attr('data-content', translation.likeGestureSet);
    }

    $(button).unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(button).popover('hide');
            showCursor($('body'), CURSOR_PROGRESS);

            if (!$(this).hasClass('gesture-set-liked')) {
                lockButton(button, true, 'fa-heart-o');
                likeGestureSet({setId: data.id}, function (result) {
                    showCursor($('body'), CURSOR_DEFAULT);
                    unlockButton(button, true, 'fa-heart-o');
//
                    if (result.status === RESULT_SUCCESS) {
                        $(button).addClass('gesture-set-liked');
                        $(button).find('.fa').removeClass('fa-heart-o').addClass('fa-heart');
                        $(button).attr('data-content', translation.unlikeGestureSet);
                        var newAmount = (parseInt($(button).find('.amount').text()) || 0) + 1;
                        $(button).find('.amount').text(newAmount);
                        updateGestureSetById(GESTURE_SETS, data.id, {hasLiked: true, likeAmount: newAmount});

                        // check if this is needed after updateGestureSet() call
                        if ($(button).hasClass('update-list-view')) {
                            getGestureSets(function (result) {
                                if (result.status === RESULT_SUCCESS) {
                                    originalFilterData = result.gestureSets;
                                }
//
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
                unlikeGestureSet({setId: data.id}, function (result) {
                    showCursor($('body'), CURSOR_DEFAULT);
                    unlockButton(button, true, 'fa-heart');

                    if (result.status === RESULT_SUCCESS) {
                        $(button).removeClass('gesture-set-liked');
                        $(button).find('.fa').removeClass('fa-heart').addClass('fa-heart-o');
                        $(button).attr('data-content', translation.likeGesture);
                        var newAmount = Math.max(0, (parseInt($(button).find('.amount').text()) || 0) - 1);
                        $(button).find('.amount').text(newAmount === 0 ? '' : newAmount);
                        updateGestureSetById(GESTURE_SETS, data.id, {hasLiked: false, likeAmount: newAmount});

                        // check if this is needed after updateGestureSet() call
                        if ($(button).hasClass('update-list-view')) {
                            getGestureSets(function (result) {
                                if (result.status === RESULT_SUCCESS) {
                                    originalFilterData = result.gestureSets;
                                }
//
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

function initShareGestureSet(button, panel, data) {
    updateGestureSetThumbnailSharing(panel, data);

    $(button).click(function (event) {
        event.preventDefault();
        $(button).popover('hide');
        clearTimer();
        resetThumbnails($(panel).find('.previewGesture'));
        currentPreviewGestureSet = {set: getGestureSetById(data.id), thumbnail: panel};
        gestureSetPreviewOpened = true;
        $(panel).find('.btn-pause-gesture').click();
        loadHTMLintoModal('custom-modal', 'externals/modal-gesture-set.php', 'modal-lg');
    });
}

function initCommentGestureSet(button, panel, data) {
    $(button).find('.amount').text(parseInt(data.commentAmount) > 0 ? data.commentAmount : '');
    if (data.hasCommented === 'true' || data.hasCommented === true) {
        $(button).find('.fa').removeClass('fa-comment-o').addClass('fa-comments');
    }

    $(button).click(function (event) {
        event.preventDefault();
        $(button).popover('hide');
        clearTimer();
        resetThumbnails($(panel).find('.previewGesture'));
        currentPreviewGestureSet = {set: getGestureSetById(data.id), thumbnail: panel, startTab: 'comments'};
        gestureSetPreviewOpened = true;
        $(panel).find('.btn-pause-gesture').click();
        loadHTMLintoModal('custom-modal', 'externals/modal-gesture-set.php', 'modal-lg');
    });
}

function initMoreInfoGestureSet(button, panel, data) {
    $(button).click(function (event) {
        event.preventDefault();
        $(button).popover('hide');
        clearTimer();
        resetThumbnails($(panel).find('.previewGesture'));
        currentPreviewGestureSet = {set: getGestureSetById(data.id), thumbnail: panel};
        gestureSetPreviewOpened = true;
        $(panel).find('.btn-pause-gesture').click();

        $('#custom-modal').on('gesture-set-deleted', function () {
            checkPagination($('#custom-pager .pagination'), currentFilterData.length, parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]));
            renderData(currentFilterData);
        });

        loadHTMLintoModal('custom-modal', 'externals/modal-gesture-set.php', 'modal-lg');
    });
}

function initStandardGestureSetList(panel, data, type, layout) {
//    console.log('initStandardGestureSetList', data);
    if (data.gestures !== null && data.gestures.length > 0) {
        clearAlerts(panel);
        var missingGestures = 0;
        for (var j = 0; j < data.gestures.length; j++) {
            var gesture = getGestureById(data.gestures[j]);
            if (gesture) {
                var gestureThumbnail = getGestureCatalogListThumbnail(gesture, type ? type : null, layout ? layout : 'col-xs-12 col-sm-6 col-md-4 col-lg-3');
                $(panel).find('#gestures-list-container').append(gestureThumbnail);
            } else {
                missingGestures++;
            }
        }

        if (missingGestures > 0) {
            appendAlert(panel, ALERT_SET_MISSING_GESTURES);
        }
    } else {
        appendAlert(panel, ALERT_EMPTY_GESTURE_SET);
        $(panel).find('#btn-download-as-json, #btn-download-as-exchangeable').addClass('disabled');
    }
}

function initGestureSetSimulation(panel, data) {
    var simulateButton = $(panel).find('#btn-simulate-gesture-set');
    if (data.gestures !== null) {
        $(simulateButton).unbind('click').bind('click', function (event) {
            if (!$(this).hasClass('disabled')) {
                goto('simulator.php?gestureSetId=' + data.id);
            }
        });
    } else {
        $(simulateButton).addClass('disabled');
    }
}

function initAssembledGestureSetList(panel, data, type, layout) {
    if (data.gestures !== null) {
        clearAlerts(panel);
        for (var j = 0; j < data.gestures.length; j++) {
            var gesture = getGestureById(data.gestures[j]);
            if (gesture) {
                var isGestureAss = isGestureAssembled(gesture.id);
                var gestureThumbnail = getCreateStudyGestureListThumbnail(gesture, type ? type : 'favorite-gesture-catalog-thumbnail', layout ? layout : 'col-xs-6 col-md-3', null, isGestureAss ? 'panel-info' : null);
                $(panel).find('#gestures-list-container').append(gestureThumbnail);
            }
        }

        var assembledGesturesLength = $(panel).find('#gestures-list-container .gesture-thumbnail.assembled').length;
        if (assembledGesturesLength === $(panel).find('#gestures-list-container .gesture-thumbnail').length) {
            $(panel).find('#btn-mark-hole-set').addClass('marked');
            $(panel).find('#btn-mark-hole-set').find('.fa').removeClass('fa-plus-square').addClass('fa-minus-square');
            $(panel).find('#btn-mark-hole-set').attr('data-content', translation.removeAllGesturesFromStudyGestureSet);
        }

    } else {
        $(panel).find('.hole-set-control-buttons').addClass('hidden');
        appendAlert(panel, ALERT_EMPTY_GESTURE_SET);
    }

    initPopover();
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


function downloadGestureSetAsExchangeable(gestureThumbnails, title) {
//    var actions = [];
    var zip = new JSZip();
    var gestures = [];

    for (var i = 0; i < gestureThumbnails.length; i++) {
        var gestureId = $(gestureThumbnails[i]).closest('.root').attr('id');
        var gesture = getGestureById(gestureId);
        if (gesture.gif && gesture.gif !== null) {
            attachDataToZip(gesture, 'https://gesturenote.de/' + gesture.gif, i);
//            actions.push({id: gesture.id, name: gesture.title, description: gesture.description, image: 'https://gesturenote.de/' + gesture.gif});
        } else {
//            actions.push({id: gesture.id, name: gesture.title, description: gesture.description});

            createGIF(gesture.images, null, false, function (blob) {
                attachDataToZip(gesture, blob, i);
            });
        }

        function attachDataToZip(attachGesture, gif, index) {
//            zip.folder(index);
            var previews = [];
            for (var j = 0; j < attachGesture.images.length; j++) {
                previews.push(attachGesture.id + "/" + (j + 1) + ".jpg");
                zip.file(previews[j], urlToPromise(attachGesture.images[j]), {
                    binary: true
                });
            }

            zip.file(attachGesture.id + "/preview.gif", urlToPromise(gif), {
                binary: true
            });

            var gesture = {
                ID: attachGesture.id,
                name: attachGesture.title,
                nameQuality: attachGesture.titleQuality,
                style: attachGesture.type,
                type: attachGesture.interactionType,
                description: attachGesture.description,
                association: attachGesture.association,
//                bodypart: attachGesture.bodyType,
                joints: attachGesture.joints,
                context: attachGesture.context,

//                kinectGesture: gesture.kinectGesture,
                gifUrl: attachGesture.id + "/preview.gif",
//                kinectContinuousGesture: gesture.kinectContinuousGesture,
//                kinectContinuousGesture2: gesture.kinectContinuousGesture2,
                preview: previews,
                previewIndex: attachGesture.previewImage
//                continuousValueType: attachGesture.continuousValueType,
//                kinectDb: gesture.kinectDb
            };

            gestures.push(gesture);
        }
    }

    var data = {
        name: title,
        ID: chance.natural(),
        trigger: gestures
    };

    var triggerSet = {
        type: "trigger set",
        data: data
    };
    console.log(json);
    var json = JSON.stringify(triggerSet, null, ' ');
    zip.file(title + ".txt", json);

    zip.generateAsync({
        type: "blob"
    }).then(function (blob) {
        saveAs(blob, title + ".zip");
    });
}

function urlToPromise(url) {
    return new Promise(function (resolve, reject) {
        JSZipUtils.getBinaryContent(url, function (err, data) {
            if (err) {
                reject(err);
            } else {
                resolve(data);
            }
        });
    });
}



/*
 * load exchangeable file
 */
function handleFileSelection(event) {
    var files = event.target.files;
    if (!files) {
        console.log("no Files");
        return;
    }

    var file = files[0];
    if (!file) {
        console.log("Unable to access the file");
        return;
    }

    if (file.size === 0) {
        console.log("File is empty");
        return;
    }

    // nur ZIP-Dateien, mp4 videos, jpg Bilder oder Text-Dateien werden angenommen
    if (!file.type.match('application/x-zip-compressed') && !file.type.match('video/mp4') && !file.type.match('image/jpeg') && !file.type.match('text/plain')) {
        console.log("unknown zip file type : " + file.type);
        console.log(file);
        return;
    }
    startFileRead(file);
}

function startFileRead(fileObject, type) {
    // Zip Datei behandeln
    JSZip.loadAsync(fileObject).then(function (zip) {
        // JSON Datei aus Zip extrahieren
        // Dateiname der JSOn Datei muss identisch zum Name der ZIP-Datei
        // sein
        var filename = fileObject.name;
        // dateiendung abschneiden und durch .txt ersetzten
        filename = filename.substr(0, filename.length - 4);
        filename = filename + '.txt';
        // JSON Datei parsen
        zip.file(filename).async("string").then(function (data) {
            parseFileText(data, zip, type);
        });
    }, function (e) {
        console.log("Error reading " + fileObject.name + " : " + e.message);
    });
}

// JSON Datei parsen
function parseFileText(fileString, zipfile) {
    var JSONObject = JSON.parse(fileString);
    // Gesten Set- verarbeiten
    var setName = JSONObject.data.name;
    var setId = JSONObject.data.ID;
    var trigger = new Array();
    trigger = JSONObject.data.trigger;

    var gestures = new Array();
    // für alle Gesten durchlaufen
    for (var i = 0; i < trigger.length; i++) {
        // durch individuelle Bilder per JSON Datei füllen
        images = new Array();
        // Bilder aus ZIP nehmen
        if (zipfile !== null) {
            var previewArray = trigger[i].preview;
            for (var j = 0; j < previewArray.length; j++) {
                var filepath = previewArray[j];
                // Bilder asyncron aus ZIP laden
                createImgUrlAsync(zipfile, filepath, setId, type);
                // Dateien mit normalen Dataipfad in Array hinterlegen,
                // werden durch async-Aufruf überschrieben
                var tempURL = filepath;
                images.push(tempURL);
            }
        } else {
            // Default Mechanismus von Daniel verwenden
            for (var j = 0; j < 15; j++) {
                images.push(PATH_IMAGES_GESTURES + '1/' + (j + 1) + '.jpg');
            }
        }

        gestures.push(new Gesture(setName, setId, trigger[i].ID, trigger[i].style,
                trigger[i].type, trigger[i].bodypart, trigger[i].name,
                trigger[i].description, images, 1, null, true, trigger[i].kinectDb,
                trigger[i].kinectGesture,
                trigger[i].gifUrl,
                trigger[i].continuousValueType,
                trigger[i].kinectContinuousGesture,
                trigger[i].kinectContinuousGesture2)
                );
    }
}

function createImgUrlAsync(zipObject, filepath, setId, type) {
    zipObject.file(filepath).async("arraybuffer").then(function (data) {
        // temporäres Blob-Element erstellen
        var imgBlob = new Blob([data]);
        var url = URL.createObjectURL(imgBlob);
        // URL des ursprünglichen Bildes austauschen

        // ersetzt auch Bilder auf vorab geladenen Sets
        var img = $("img[title=\'" + setId + "/" + filepath + "\']");
        img.attr("src", url);
        // URL auch in PREDEFINED_GESTURE_SET ändern, damit die temporären
        // Bilder auch im modalen Dialog sichtbar sind
        if (type === "viewer") {
            var gestures = getLocalItem(PREDEFINED_GESTURE_SET);
        } else if (type === "editor") {
            var gestures = getLocalItem(GESTURE_SET_COLLECTION);
        } else if (type === "mapping") {
            var gestures = getLocalItem(GESTURE_MAPPING_COLLECTION);
        }
        for (var i = 0; i < gestures.length; i++) {
            for (var j = 0; j < gestures[i].images.length; j++) {
                if (gestures[i].images[j] == filepath) {
                    gestures[i].images[j] = url;
                }
            }
        }
        if (type === "viewer") {
            setLocalItem(PREDEFINED_GESTURE_SET, gestures);
        } else if (type === "editor") {
            setLocalItem(GESTURE_SET_COLLECTION, gestures);
        } else if (type === "mapping") {
            setLocalItem(GESTURE_MAPPING_COLLECTION, gestures);
        }
    }, function error(e) {
        // handle the error
        console.log("error with zip");
    });
}


function formatBytes(bytes, decimals) {
    if (bytes === 0)
        return '0 Bytes';

    var k = 1024,
            dm = decimals || 2,
            sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
            i = Math.floor(Math.log(bytes) / Math.log(k));

    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
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
//        console.log(options)
        if (options && options.tester && (options.tester.stream === 'yes' || options.tester.visualizeStream === 'yes' || options.tester.recordStream === 'yes')) {
            return true;
        }
    }
    return false;
}

function isWebRTCPlaybackNeededForPhaseStep(phaseStep) {
    if (phaseStep) {
        var options = getPhaseStepOptions(phaseStep.format);
        if (options.tester.recordStream === 'yes' || options.moderator.recordStream === 'yes') {
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
//    var phaseSteps = getContextualPhaseSteps();
    var currentPhase = getCurrentPhase();
    return isPidocoSocketNeededForPhaseStep(currentPhase);
//    if (phaseSteps && phaseSteps.length > 0) {
//        for (var i = 0; i < phaseSteps.length; i++) {
//            if () {
//                return true;
//            }
//        }
//    }
//    return false;
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
//                socketNeeded = isPidocoSocketNeededForGestureTraining(phaseStepData);
                break;
            case SCENARIO:
                socketNeeded = isPidocoSocketNeededForScenario(phaseStepData.tasks);
                break;
        }
    }
    console.log('socketNeeded', phaseStep.format, socketNeeded);

    return socketNeeded;
}

function isPidocoSocketNeededForScenario(tasks) {
    if (tasks && tasks.length > 0) {
        for (var k = 0; k < tasks.length; k++) {
            var wozData = tasks[k].woz;
            for (var i = 0; i < wozData.length; i++) {
                if (wozData[i].transitionScenes && wozData[i].transitionScenes.length > 0) {
                    for (var j = 0; j < wozData[i].transitionScenes.length; j++) {
                        var scene = getSceneById(wozData[i].transitionScenes[j].sceneId);
                        if (scene.type === SCENE_PIDOCO && wozData[i].transitionScenes[j].useEventBus === 'yes') {
                            return true;
                        }
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

    var susGradeScale = translation.susGradeScale;
    var susGrade = susGradeScale[susGradeScale.length - 1].grade;
    for (var i = 0; i < susGradeScale.length; i++) {
        if (score >= parseFloat(susGradeScale[i].score)) {
        } else {
            susGrade = susGradeScale[i].grade;
            break;
        }
    }

    var susAcceptabilityRange = translation.susAcceptabilityRange;
    var susAcceptability = susAcceptabilityRange.acceptable.title;
    for (var key in susAcceptabilityRange) {
        var acceptabilityRange = susAcceptabilityRange[key];
        if (score >= parseFloat(acceptabilityRange.score)) {
        } else {
            susAcceptability = acceptabilityRange.title;
            break;
        }
    }

    return {susAcceptability: susAcceptability, susGrade: susGrade, adjective: adjective};
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
    } else if (showLoadingIndicator && showLoadingIndicator) {
        $(button).find('.fa').addClass('fa-spin fa-circle-o-notch');
    }
}

function unlockButton(button, hideLoadingIndicator, originalIcon) {
    $(button).removeClass('disabled');
    if (hideLoadingIndicator && hideLoadingIndicator === true && originalIcon) {
        $(button).find('.fa').removeClass('fa-spin fa-circle-o-notch').addClass(originalIcon);
    } else if (hideLoadingIndicator && hideLoadingIndicator === true) {
        $(button).find('.fa').removeClass('fa-spin fa-circle-o-notch');
    }
}


/*
 * 
 */
function getGesturePreviewIndex(source) {
    var imageIndex = $(source).find('.previewImage').attr('data-index');
    return imageIndex !== undefined ? imageIndex : 0;
}

/*
 * color selector
 */

$(document).on('click', '.btn-color-selector', function (event) {
    event.preventDefault();
    if (!$(this).hasClass('selected')) {
        $(this).parent().children().removeClass('selected');
        $(this).addClass('selected');
        $(this).trigger('change');
    }
});

$(document).on('click', '.btn-observer-color-selector', function (event) {
    event.preventDefault();
    var button = $(this);
    if (!$(button).hasClass('selected')) {
        $(button).parent().children().removeClass('selected');
        $(button).addClass('selected');
        $(button).trigger('annotationSelected', [$(button).attr('data-id')]);

        TweenMax.to(button, .1, {scaleX: 1.5, scaleY: 1.5, opacity: 0, clearProps: 'all', onComplete: function () {
                $(button).removeClass('selected');
            }});
    }
});

$(document).on('click', '.btn-toggle-sensor-source', function (event) {
    event.preventDefault();
    if (!$(this).hasClass('disabled') && !$(this).hasClass('active')) {
        $(this).parent().children().removeClass('active');
        $(this).addClass('active');

        var showSensor = $(this).attr('data-toggle-sensor');
        $(this).closest('.root').find('.sensor-content').children().addClass('hidden');
        $(this).closest('.root').find('.sensor-content [data-sensor-source=' + showSensor + ']').removeClass('hidden');

        setTimeout(function () {
            window.dispatchEvent(new Event('resize'));
        }, 100);
    }
});

$(document).on('mouseenter', '.controls-container', function (event) {
    event.preventDefault();
    TweenMax.to($(this).find('.hidden-controls-container-btn'), .2, {opacity: .7});
});

$(document).on('mouseleave', '.controls-container', function (event) {
    event.preventDefault();
    TweenMax.to($(this).find('.hidden-controls-container-btn'), .2, {opacity: 0});
});


$(document).on('click', '.btn-download-as-gif', function (event) {
    event.preventDefault();

    if (!$(this).hasClass('disabled')) {
        var button = $(this);
        var gesture = getGestureById($(this).attr('data-gesture-id'));
        if (gesture) {
            lockButton(button, true, 'fa-file-image-o');
            createGIF(gesture.images, gesture.title, true, function () {
                unlockButton(button, true, 'fa-file-image-o');
            });
        } else {
            lockButton(button, true, 'fa-file-image-o');
            var gestureImages = $(this).closest('.root').find('.gestureImage');
            var imageArray = [];
            for (var i = 0; i < gestureImages.length; i++) {
                imageArray.push($(gestureImages[i]).attr('src'));
            }
            var title = sha512(new Date().toDateString());
            createGIF(imageArray, title, true, function () {
                unlockButton(button, true, 'fa-file-image-o');
            });
        }
    }
});

// create gif from gesture images
function createGIF(images, title, downloadGIF, callback) {
    gifshot.createGIF({
        gifWidth: 320,
        gifHeight: 240,
        images: images,
        interval: 0.1,
        numFrames: 10,
        frameDuration: 1,
        sampleInterval: 3,
        numWorkers: 2
    }, function (obj) {
        if (!obj.error) {
            var blob = dataURItoBlob(obj.image);
            if (downloadGIF && downloadGIF === true && title) {
                saveAs(blob, title + ".gif");
            }

            if (callback) {
                callback(blob);
            }
        }
    });
}

$(document).on('click', '.btn-download-as-zip', function (event) {
    event.preventDefault();
    var zip = new JSZip();
    var gesture = getGestureById($(this).attr('data-gesture-id'));
    var previews = [];

    for (var j = 0; j < gesture.images.length; j++) {
        previews.push(gesture.id + "/" + (j + 1) + ".jpg");
        zip.file(previews[j], urlToPromise(gesture.images[j]), {
            binary: true
        });
    }

    zip.generateAsync({type: "blob"})
            .then(function (content) {
                saveAs(content, translation.gesture + '_' + gesture.id + '.zip');
            });
});

$(document).on('click', '.btn-tag-as-preview', function (event) {
    event.preventDefault();

    if (!$(this).hasClass('disabled')) {
        var button = $(this);
        lockButton(button, true, 'fa-bookmark-o');
        var gestureImages = $(this).closest('.root').find('.gestureImage');
        $(gestureImages).removeClass('previewImage');
        $(this).closest('.root').find('.webcam-image-container .active').addClass('previewImage');
        var previewImageIndex = parseInt($(this).closest('.root').find('.previewImage').attr('data-index')) + 1;
        $(this).find('.preview-image-index').text(previewImageIndex);

//        var gesture = getGestureById($(this).attr('data-gesture-id'));
//        if (gesture) {
//
//        } else {
//
//        }

        unlockButton(button, true, 'fa-bookmark-o');
    }
});




/*
 * expanding panel functionalities
 */

$(document).on('click', '.btn-expand', function (event) {
    event.preventDefault();

    if (!$(this).hasClass('disabled')) {
        var panel = $(this).closest('.root');
        var container = $(panel).parent();
        $(this).popover('hide');
//        console.log(panel, $(container).find('.panel-body-expandable'));

        if ($($(panel).find('.panel-body-expandable')[0]).hasClass('hidden')) {
            $(container).find('.panel-body-expandable').addClass('hidden');
            $(container).find('.btn-expand').attr('data-content', translation.expand).data('bs.popover').setContent();
            $(container).find('.btn-expand .fa').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            $(container).find('.panel-heading-expandable').css({borderBottomLeftRadius: '8px', borderBottomRightRadius: '8px'});

            $($(panel).find('.panel-body-expandable')[0]).removeClass('hidden');
            $($(panel).find('.btn-expand')[0]).find('.fa').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            $($(panel).find('.panel-heading-expandable')[0]).css({borderBottomLeftRadius: '', borderBottomRightRadius: ''});
            $($(panel).find('.btn-expand')[0]).attr('data-content', translation.collapse).data('bs.popover').setContent();

            // scroll after expand
            setTimeout(function () {
                $('html, body').animate({
                    scrollTop: $(panel).offset().top - 15
                }, 300);
            }, 300);
        } else {
            $(panel).find('.panel-body-expandable').addClass('hidden');
            $(panel).find('.btn-expand').find('.fa').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            $(panel).find('.panel-heading-expandable').css({borderBottomLeftRadius: '8px', borderBottomRightRadius: '8px'});
            $(panel).find('.btn-expand').attr('data-content', translation.expand).data('bs.popover').setContent();
        }
    }
});

previewModeEnabled = true;
function getCurrentPhase() {
    var phaseSteps = null;
    if (!previewModeEnabled) {
        phaseSteps = getLocalItem(STUDY_PHASE_STEPS);
    } else {
        phaseSteps = getContextualPhaseSteps();
    }
    return phaseSteps[currentPhaseStepIndex];
}

function getCurrentPhaseData() {
    var currentPhase = getCurrentPhase();
    if (currentPhase) {
        return getLocalItem(currentPhase.id + '.data');
    }
    return null;
}
