Thanks.prototype.options = null;

function Thanks(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}



/*
 * moderator view rendering
 */

Thanks.prototype.renderModeratorView = function () {
    console.log('render moderator view:', THANKS.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    removeAlert($('#viewModerator'), ALERT_PLEASE_WAIT);
    $('#viewModerator').find('#phase-content').removeClass('hidden');
    $('#viewModerator').find('#pinnedRTC').css({opacity: 1});

    if (!previewModeEnabled && uploadQueue) {
        $(uploadQueue).unbind(EVENT_UPLOAD_PROGRESS_ALL).bind(EVENT_UPLOAD_PROGRESS_ALL, function (event, progress) {
            event.preventDefault();
            $(container).find('#progress-thanks').removeClass('hidden');
            $(container).find('#progress-thanks .progress-bar').attr('aria-valuenow', progress).css({width: progress + '%'}).text(parseInt(progress) + '%');
        });
    }

    TweenMax.to(container.find('.fa-upload'), .5, {yoyo: true, repeat: -1, opacity: .4});
    $(container).find('#thanks-text').text(data);
    $(container).find('.thanks-text').text(data);
    $(container).find('#btn-leave-survey').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var query = getQueryParams(document.location.search);
        if (query.studyId && query.h && query.token) {
            goto('study-prepare-moderator.php?studyId=' + query.studyId + '&h=' + query.h + '&token=' + query.token);
        }
    });

    $(container).find('#btn-retry-upload').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (previewModeEnabled === false) {
            submitFinalData(container);
        }
    });

    if (previewModeEnabled === false) {
        checkRTCUploadStatus(container);
    }

    return container;
};




/*
 * tester view rendering
 */

Thanks.prototype.renderTesterView = function () {
    console.log('render tester view:', THANKS.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    if (!previewModeEnabled && uploadQueue) {
        $(uploadQueue).unbind(EVENT_UPLOAD_PROGRESS_ALL).bind(EVENT_UPLOAD_PROGRESS_ALL, function (event, progress) {
            event.preventDefault();
            $(container).find('#progress-thanks').removeClass('hidden');
            $(container).find('#progress-thanks .progress-bar').attr('aria-valuenow', progress).css({width: progress + '%'}).text(parseInt(progress) + '%');
        });
    }

    var content = $(getSourceContainer(VIEW_TESTER)).find('#thanks-' + getLocalItem(STUDY).surveyType).clone().removeAttr('id');
    $(container).append(content);
    TweenMax.to(container.find('.fa-upload'), .5, {yoyo: true, repeat: -1, opacity: .4});
    $(container).find('#thanks-text').text(data);
    var study = getLocalItem(STUDY);
    var absoluteStaticStudyUrl = 'https://gesturenote.de/study-prepare.php?studyId=' + study.id + '&h=' + study.urlToken;
    $(container).find('#static-study-url').text(absoluteStaticStudyUrl);

    $(container).find('#btn-execution-done').unbind('click').bind('click', function (event) {
        event.preventDefault();
        gotoIndex();
    });

    $(container).find('#static-study-url').unbind('click').bind('click', function () {
        $(container).find('#static-study-url').select();
    });

    $(container).find('#btn-retry-upload').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (previewModeEnabled === false) {
            submitFinalData(container);
        }
    });

    if (previewModeEnabled === false) {
        checkRTCUploadStatus(container);
    }

    // heart icon animation
    var heartIcon = $(content).find('#heart-icon');
    $(heartIcon).css({cursor: 'pointer'});
    function animateHeartIcon() {
        var heartOffset = $(heartIcon).offset();
        for (var i = 0; i < 4; i++) {
            var heartCopy = $(heartIcon).clone().removeAttr('id');
            $(heartCopy).insertAfter(heartIcon);
            $(heartCopy).css({position: 'fixed', top: heartOffset.top, left: heartOffset.left, opacity: .4});
            TweenMax.to(heartCopy, .5, {delay: i * .2, scaleX: 1.5, scaleY: 1.5, opacity: 0, onCompleteParams: [heartCopy], onComplete: function (element) {
                    $(element).remove();
                }});
        }
    }

    setTimeout(animateHeartIcon, 1000);
    $(heartIcon).on('click', function (event) {
        event.preventDefault();
        animateHeartIcon();
    });

    return container;
};




/*
 * observer view rendering
 */

Thanks.prototype.renderObserverView = function () {
    console.log('render observer view:', THANKS.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    var content = $(getSourceContainer(VIEW_OBSERVER)).find('#thanks-' + getLocalItem(STUDY).surveyType).clone().removeAttr('id');
    $(container).append(content);
    $(container).find('#thanks-text').text(data);

    $(container).find('#btn-leave-survey').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var query = getQueryParams(document.location.search);
        if (query.studyId && query.h && query.token) {
            goto('study-prepare-moderator.php?studyId=' + query.studyId + '&h=' + query.h + '&token=' + query.token);
        }
    });

    $(container).find('#btn-retry-upload').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (previewModeEnabled === false) {
            submitFinalData(container);
        }
    });

    if (previewModeEnabled === false) {
        checkRTCUploadStatus(container);
    }

    return container;
};












/*
 * moderator view rendering
 */

Thanks.prototype.renderWizardView = function () {
    console.log('render wizard view:', THANKS.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    removeAlert($('#viewWizard'), ALERT_PLEASE_WAIT);
    $('#viewWizard').find('#phase-content').removeClass('hidden');
    $('#viewWizard').find('#pinnedRTC').css({opacity: 1});

    if (!previewModeEnabled && uploadQueue) {
        $(uploadQueue).unbind(EVENT_UPLOAD_PROGRESS_ALL).bind(EVENT_UPLOAD_PROGRESS_ALL, function (event, progress) {
            event.preventDefault();
            $(container).find('#progress-thanks').removeClass('hidden');
            $(container).find('#progress-thanks .progress-bar').attr('aria-valuenow', progress).css({width: progress + '%'}).text(parseInt(progress) + '%');
        });
    }

    TweenMax.to(container.find('.fa-upload'), .5, {yoyo: true, repeat: -1, opacity: .4});
    $(container).find('#thanks-text').text(data);
    $(container).find('.thanks-text').text(data);
    $(container).find('#btn-leave-survey').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var query = getQueryParams(document.location.search);
        if (query.studyId && query.h && query.token) {
            goto('study-prepare-moderator.php?studyId=' + query.studyId + '&h=' + query.h + '&token=' + query.token);
        }
    });

    $(container).find('#btn-retry-upload').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (previewModeEnabled === false) {
            submitFinalData(container);
        }
    });

    if (previewModeEnabled === false) {
        checkRTCUploadStatus(container);
    }

    return container;
};