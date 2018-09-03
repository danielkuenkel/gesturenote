GestureSlideshow.prototype.options = null;

function GestureSlideshow(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}



/*
 * moderator view rendering
 */

GestureSlideshow.prototype.renderModeratorView = function () {
    console.log('render moderator view:', SLIDESHOW_GESTURES.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    if (!data.slideshow || data.slideshow.length === 0) {
        return false;
    }

    // general data section
    $(container).find('#general .headline').text(currentPhase.title);
    $(container).find('#general #description').text(data.description);

    renderCurrentPhaseState();

    function renderCurrentPhaseState() {
        if (currentPhaseState === null) {
            currentPhaseState = 'initialize';
        }

        switch (currentPhaseState) {
            case 'initialize':
                renderStateInitialize();
                break;
            case 'gestureSlideshowOverview':
                renderStateGestureSlideshowOverview();
                break;
            case 'gestureSlideshowStarted':
                renderStateGestureSlideshowStarted();
                break;
            case 'askGesture':
                renderStateAskGesture();
                break;
            case 'selectGesture':
                renderStateSelectGesture();
                break;
            case 'restartSlideshow':
                renderStateRestartSlideshow();
                break;
            case 'nextSlide':
                renderStateNextSlide();
                break;
            case 'gestureSlideshowDone':
                renderStateGestureSlideshowDone();
                break;
        }
    }

    function renderStateInitialize() {
        console.log('render moderator state: ', currentPhaseState);

        $(document).scrollTop(0);
        $(container).find('#general').removeClass('hidden');

        $(container).find('#btn-show-overview').unbind('click').bind('click', function (event) {
            event.preventDefault();

            currentPhaseState = 'gestureSlideshowOverview';
            renderCurrentPhaseState();
        });
    }

    function renderStateGestureSlideshowOverview() {
        console.log('render moderator state: ', currentPhaseState);

        $(document).scrollTop(0);
        $(container).find('#general, #slide').addClass('hidden');
        $(container).find('#slides').removeClass('hidden');
        $(container).find('#slides .slide-container').empty();
        wobble(container.find('#slides'));

        for (var i = 0; i < data.slideshow.length; i++) {
            renderSlideshowItem($(container).find('#slides'), data.slideshow[i], true);
        }

        $(container).find('#btn-start-slideshow').unbind('click').bind('click', function (event) {
            currentPhaseState = 'gestureSlideshowStarted';
            renderCurrentPhaseState();
        });
    }

    function renderStateGestureSlideshowStarted() {
        console.log('render moderator state: ', currentPhaseState);

        $(document).scrollTop(0);
        renderSlideContents();

        if (!previewModeEnabled) {
            peerConnection.sendMessage(MESSAGE_START_GESTURE_SLIDESHOW);
        }

        $(container).find('#trigger-slide').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                currentPhaseState = 'askGesture';
                renderCurrentPhaseState();

                if (!previewModeEnabled) {
                    peerConnection.sendMessage(MESSAGE_TRIGGER_GESTURE_SLIDE, {currentSlideIndex: currentSlideIndex, slidesRestartCount: slidesRestartCount});
                }
            }
        });
    }

    function renderStateAskGesture() {
        console.log('render moderator state: ', currentPhaseState);

        $(document).scrollTop(0);
        renderSlideContents();

        var triggerButton = $(container).find('#slide #trigger-slide');
        lockButton(triggerButton, true);
        $(triggerButton).addClass('disabled');

        if (peerConnection) {
            $(peerConnection).unbind(MESSAGE_REACTIVATE_CONTROLS).bind(MESSAGE_REACTIVATE_CONTROLS, function (event, payload) {
                currentPhaseState = 'selectGesture';
                renderCurrentPhaseState();
            });
        }
    }

    function renderStateSelectGesture() {
        console.log('render moderator state: ', currentPhaseState);

        $(document).scrollTop(0);
        renderSlideContents();

        $('#custom-modal').unbind('noGestureFitFound').bind('noGestureFitFound', function (event, payload) {
            console.log('no gesture fit found', payload);
            $('#custom-modal').unbind('noGestureFitFound');
            $('#custom-modal').modal('hide');

            if (payload.action === ACTION_NO_GESTURE_FIT_FOUND) {
                slidesRestartCount++;
                currentSlideIndex = 0;
            }

            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_NO_GESTURE_FIT_FOUND, {annotationData: {action: payload.action, gestureId: payload.correctGesture.id, triggerId: payload.triggerId, selectedGestureId: null}, slidesRestartCount: slidesRestartCount, currentSlideIndex: currentSlideIndex});
            }

            currentPhaseState = 'gestureSlideshowOverview';
            renderCurrentPhaseState();
        });

        $('#custom-modal').unbind('selectGesture').bind('selectGesture', function (event, payload) {
            console.log('gesture fit found', payload);
            $('#custom-modal').unbind('selectGesture');
            $('#custom-modal').modal('hide');

            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_GESTURE_FIT_FOUND, {annotationData: {action: ACTION_SELECT_GESTURE, gestureId: payload.correctGestureId, triggerId: payload.triggerId, selectedGestureId: payload.gestureId, fit: payload.fit}});
            }

            if (payload.fit === true) {
                currentSlideIndex++;
                if (currentSlideIndex >= data.slideshow.length) {
                    currentPhaseState = 'gestureSlideshowDone';
                } else {
                    currentPhaseState = 'gestureSlideshowStarted';
                }
                renderCurrentPhaseState();
            } else {
                currentPhaseState = 'restartSlideshow';
                renderCurrentPhaseState();
            }
        });

        loadHTMLintoModal('custom-modal', 'externals/modal-check-gesture.php', 'modal-lg');
    }

    function renderStateRestartSlideshow() {
        console.log('render moderator state: ', currentPhaseState);

        $(document).scrollTop(0);
        renderSlideContents();

        $(container).find('#slide #btn-restart-slideshow').removeClass('hidden');
    }

    function renderStateGestureSlideshowDone() {
        console.log('render moderator state: ', currentPhaseState);

        appendAlert(container, ALERT_PHASE_STEP_DONE);

        $(document).scrollTop(0);
        $(container).find('#general, #slides, #slide').addClass('hidden');
        $(container).find('#btn-done').removeClass('hidden');
        $(container).find('#btn-done').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
            }
            nextStep();
        });
    }

    function renderSlideContents() {
        $(container).find('#general').addClass('hidden');
        $(container).find('#slides').addClass('hidden');
        $(container).find('#slide').removeClass('hidden');
        $(container).find('#slide .headline').text(translation.gesture + ' ' + (currentSlideIndex + 1) + ' von ' + data.slideshow.length);
        $(container).find('#slide .slide-container').empty();
        renderSlideshowItem($(container).find('#slide'), data.slideshow[currentSlideIndex]);
        $(container).find('#trigger-slide').removeClass('hidden');
    }

    // render current slideshow item
    function renderSlideshowItem(target, slideData, isOverview) {

        var item = $(source).find('#gestureSlideshowItem').clone().removeAttr('id');
        $(target).find('.slide-container').append(item);

        var gesture = getGestureById(slideData.gestureId);
        var trigger = getTriggerById(slideData.triggerId);
        var thumbnail = getSimpleGestureListThumbnail(gesture, 'simple-gesture-thumbnail', 'col-xs-12');
        $(item).find('#thumbnail-container').empty().append(thumbnail);

        $(item).find('#responseTime').text(slideData.recognitionTime + ' Sekunden');
        $(item).find('#searched').text(gesture.title);
        $(item).find('#given').text(trigger.title);
        $(container).find('#search-gestures').removeClass('hidden');

        if (isOverview) {
            $(item).find('#gesture-slide-controls').remove();
        }
    }

    // observation section
    renderObservations(data, container);

    return container;
};








/*
 * tester view rendering
 */

GestureSlideshow.prototype.renderTesterView = function () {
    console.log('render tester view:', SLIDESHOW_TRIGGER.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    $(container).find('#general .headline').text(data.title);
    $(container).find('#general .description').text(data.description);
    if (!data.slideshow || data.slideshow.length === 0) {
        return false;
    }

    renderCurrentPhaseState();

    function renderCurrentPhaseState() {
        if (currentPhaseState === null) {
            currentPhaseState = 'initialize';
        }

        switch (currentPhaseState) {
            case 'initialize':
                renderStateInitialize();
                break;
            case 'gestureSlideshowOverview':
                renderStateGestureSlideshowOverview();
                break;
            case 'gestureSlideshowStarted':
                renderStateGestureSlideshowStarted();
                break;
            case 'askGesture':
                renderStateAskGesture();
                break;
            case 'selectGesture':
                renderStateSelectGesture();
                break;
            case 'gestureSlideshowDone':
                renderStateGestureSlideshowDone();
                break;
        }
    }

    function renderStateInitialize() {
        console.log('render tester state: ', currentPhaseState);

        if (!previewModeEnabled) {
            var currentPhase = getCurrentPhase();
            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
            tempData.annotations = new Array();
            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
        }
        appendAlert($(container), ALERT_PLEASE_WAIT);
    }

    function renderStateGestureSlideshowOverview() {
        console.log('render tester state: ', currentPhaseState);

        if (!previewModeEnabled) {
            $(peerConnection).unbind(MESSAGE_START_GESTURE_SLIDESHOW).bind(MESSAGE_START_GESTURE_SLIDESHOW, function (event, payload) {
                currentPhaseState = 'gestureSlideshowStarted';
                renderCurrentPhaseState();
            });
        }

        clearAlerts($(container));
        $(container).find('#slideshowContainer').removeClass('hidden').empty();
        $(container).find('#general').addClass('hidden');

        for (var i = 0; i < data.slideshow.length; i++) {
            var item = $(source).find('#gestureSlideshowOverviewItemModerated').clone().removeAttr('id');
            $(item).css({marginBottom: '20px'});
            $(container).find('#slideshowContainer').append(item);
            var gesture = getGestureById(data.slideshow[i].gestureId);
            renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage, null);
        }
    }

    function renderStateGestureSlideshowStarted() {
        console.log('render tester state: ', currentPhaseState);
        $(container).find('#general').addClass('hidden');
        appendAlert($(container), ALERT_PLEASE_WAIT);

        if (!previewModeEnabled) {
            $(peerConnection).unbind(MESSAGE_TRIGGER_GESTURE_SLIDE).bind(MESSAGE_TRIGGER_GESTURE_SLIDE, function (event, payload) {
                currentSlideIndex = parseInt(payload.currentSlideIndex);
                slidesRestartCount = payload.slidesRestartCount;
                getGMT(function (timestamp) {
                    var slideData = data.slideshow[currentSlideIndex];
                    var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_PERFORM_GESTURE, gestureId: slideData.gestureId, triggerId: slideData.triggerId, time: timestamp});
                    tempData.restarts = slidesRestartCount;
                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                    Tester.renderModeratedGestureSlideshow(source, container, data);

                    currentPhaseState = 'askGesture';
                    renderCurrentPhaseState();
                });
            });
        }

    }

    function renderStateAskGesture() {
        console.log('render tester state: ', currentPhaseState);

        $(container).find('#general').addClass('hidden');
        clearAlerts($(container));

        var slideData = data.slideshow[currentSlideIndex];
        var progress = $(container).find('.progress');
        progress.removeClass('active hidden');
        progress.find('.progress-bar').css({width: '100%', backgroundColor: '#5cb85c'});

        var trigger = getTriggerById(slideData.triggerId);
        $(container).find('#ask-gesture-container').removeClass('hidden');
        $(container).find('.trigger-title').text(trigger.title);

        var timeline = new TimelineMax({paused: true, delay: 1, onComplete: onAnswerTimeExpired, onCompleteParams: [container, data]});
        timeline.add("start", 0)
                .to(progress.find('.progress-bar'), parseInt(slideData.recognitionTime), {width: '0%', autoRound: false, backgroundColor: "#d9534f", ease: Power0.easeNone}, "start");
        timeline.play();

        function onAnswerTimeExpired(container, data) {
            if (!previewModeEnabled && peerConnection) {
                peerConnection.sendMessage(MESSAGE_REACTIVATE_CONTROLS);
            }

            currentPhaseState = 'selectGesture';
            renderCurrentPhaseState();
        }
    }

    function renderStateSelectGesture() {
        console.log('render tester state: ', currentPhaseState);

        $(container).find('#general').addClass('hidden');
        $(container).find('#ask-gesture-container').addClass('hidden');
        appendAlert($(container), ALERT_PLEASE_WAIT);

        if (!previewModeEnabled) {
            $(peerConnection).unbind(MESSAGE_GESTURE_FIT_FOUND).bind(MESSAGE_GESTURE_FIT_FOUND, function (event, payload) {
                getGMT(function (timestamp) {
                    var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                    var annotationData = payload.annotationData;
                    annotationData.id = tempData.annotations.length;
                    annotationData.time = timestamp;
                    tempData.annotations.push(annotationData);
                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);

                    currentPhaseState = 'gestureSlideshowStarted';
                    renderCurrentPhaseState();
                });
            });

            $(peerConnection).unbind(MESSAGE_NO_GESTURE_FIT_FOUND).bind(MESSAGE_NO_GESTURE_FIT_FOUND, function (event, payload) {
                event.preventDefault();
                currentSlideIndex = parseInt(payload.currentSlideIndex);
                slidesRestartCount = parseInt(payload.slidesRestartCount);

                getGMT(function (timestamp) {
                    var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                    var annotationData = payload.annotationData;
                    annotationData.id = tempData.annotations.length;
                    annotationData.time = timestamp;
                    tempData.annotations.push(annotationData);
                    tempData.restarts = slidesRestartCount;
                    setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);

                    currentPhaseState = 'gestureSlideshowOverview';
                    renderCurrentPhaseState();
                });
            });
        }
    }

    function renderStateGestureSlideshowDone() {
        (container).find('#general').addClass('hidden');
        $(container).find('#ask-gesture-container').addClass('hidden');
        appendAlert($(container), ALERT_PLEASE_WAIT);
    }

    return container;
};