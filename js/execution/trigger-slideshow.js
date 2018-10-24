TriggerSlideshow.prototype.options = null;

function TriggerSlideshow(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}



/*
 * moderator view rendering
 */

TriggerSlideshow.prototype.renderModeratorView = function () {
    console.log('render moderator view:', SLIDESHOW_TRIGGER.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    if (data.slideshow.length === 0) {
        return false;
    }

    if (!data.slideshow || data.slideshow.length === 0) {
        return false;
    }

    // general data section
    $(container).find('#general .headline').text(currentPhase.title);
    $(container).find('#general #description').text(data.description);

    if (!previewModeEnabled) {
        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
        tempData.annotations = new Array();
        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
    }

    // observation section
    renderObservations(data, container);

    renderCurrentPhaseState();

    function renderCurrentPhaseState() {
        if (currentPhaseState === null) {
            currentPhaseState = 'initialize';
        }

        switch (currentPhaseState) {
            case 'initialize':
                renderStateInitialize();
                break;
            case 'slideshowStarted':
                renderStateSlideshowStarted();
                break;
            case 'slideshowDone':
                renderStateSlideshowDone();
                break;
        }
    }

    function renderStateInitialize() {
        console.log('render moderator state: ', currentPhaseState);

        $(document).scrollTop(0);
        $(container).find('#general').removeClass('hidden');

        $(container).find('#btn-start-slideshow').unbind('click').bind('click', function (event) {
            event.preventDefault();

            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_START_TRIGGER_SLIDESHOW);
            }
            currentPhaseState = 'slideshowStarted';
            renderCurrentPhaseState();
        });
    }

    function renderStateSlideshowStarted() {
        console.log('render moderator state: ', currentPhaseState);

        $(container).find('#btn-start-slideshow').addClass('hidden');
        $(container).find('#btn-done-slideshow').removeClass('hidden');
        $(container).find('#general').remove();
        $(container).find('#elements').removeClass('hidden');

        renderSlideshowItems(currentQuestionnaireAnswers);

        if (!previewModeEnabled) {
            $(peerConnection).unbind(MESSAGE_UPDATE_QUESTIONNAIRE).bind(MESSAGE_UPDATE_QUESTIONNAIRE, function (event, payload) {
                event.preventDefault();
                currentQuestionnaireAnswers = payload;
                renderSlideshowItems(payload);
            });

            $(peerConnection).unbind(MESSAGE_TRIGGER_SLIDESHOW_DONE).bind(MESSAGE_TRIGGER_SLIDESHOW_DONE, function (event, payload) {
                event.preventDefault();
                currentQuestionnaireAnswers = payload;
                currentPhaseState = 'slideshowDone';
                renderCurrentPhaseState();
            });
        }


    }

    function renderStateSlideshowDone() {
        console.log('render moderator state: ', currentPhaseState, currentQuestionnaireAnswers);

        renderSlideshowItems(currentQuestionnaireAnswers);
        appendAlert(container, ALERT_PHASE_STEP_DONE);

        $(container).find('#elements').removeClass('hidden');
        $(container).find('#btn-done-slideshow').removeClass('hidden disabled');
        $(container).find('#btn-done-slideshow').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                if (!previewModeEnabled && peerConnection) {
                    peerConnection.sendMessage(MESSAGE_NEXT_STEP);
                }

                nextStep();
            }
        });
    }

    function renderSlideshowItems(answers) {
        $(container).find('#elements .question-container').empty();
        console.log("renderSlideshowItems()", currentQuestionnaireAnswers);

        for (var i = 0; i < data.slideshow.length; i++) {
            var item = $(source).find('#triggerSlideshowItem').clone().removeAttr('id');
            $(container).find('#elements .question-container').append(item);
            var gesture = getGestureById(data.slideshow[i].gestureId);
            var trigger = getTriggerById(data.slideshow[i].triggerId);
            $(item).find('#searched').text(trigger.title);
            $(item).find('#given').text(gesture.title);
            $(item).find('.btn-popover-gesture-preview').attr('name', gesture.id);
            var answer = null;

            if (answers && answers.length > 0) {
                for (var j = 0; j < answers.length; j++) {
                    if (parseInt(answers[j].correctTriggerId) === parseInt(trigger.id)) {
                        answer = answers[j];
                        break;
                    }
                }
            }

            if (answer) {
                if (parseInt(answer.selectedId) === parseInt(trigger.id)) {
                    item.addClass('panel-success');
                    item.find('#answered-correct').removeClass('hidden');
                } else {
                    item.addClass('panel-danger');
                    item.find('#answered-wrong').removeClass('hidden');
                }
            } else {
                item.find('#not-answered').removeClass('hidden');
            }
        }
    }

    return container;
};



/*
 * tester view rendering
 */

TriggerSlideshow.prototype.renderTesterView = function () {
    console.log('render tester view:', SLIDESHOW_TRIGGER.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    if (!data.slideshow || data.slideshow.length === 0) {
        return false;
    }

    if (!previewModeEnabled) {
        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
        tempData.selectedOptions = [];
        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
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
            case 'slideshowStarted':
                renderStateSlideshowStarted();
                break;
            case 'slideshowDone':
                renderStateSlideshowDone();
                break;
        }
    }

    function renderStateInitialize() {
        console.log('render tester state: ', currentPhaseState);
        appendAlert($(container), ALERT_PLEASE_WAIT);

        $(peerConnection).unbind(MESSAGE_START_TRIGGER_SLIDESHOW).bind(MESSAGE_START_TRIGGER_SLIDESHOW, function (event, payload) {
            currentPhaseState = 'slideshowStarted';
            renderCurrentPhaseState();
        });
    }

    function renderStateSlideshowStarted() {
        console.log('render tester state: ', currentPhaseState);

        clearAlerts(container);
        $(container).find('#trigger-questions').removeClass('hidden');
        var slideData = data.slideshow[currentSlideIndex];

        var gesture = getGestureById(slideData.gestureId);
        renderGestureImages($(container).find('.previewGesture'), gesture.images, gesture.previewImage, null);
        var options = new Array();
        for (var i = 0; i < data.slideshow.length; i++) {
            var trigger = getTriggerById(data.slideshow[i].triggerId);
            options.push(trigger);
        }

        var questions = new Array();
        questions.push({format: GROUPING_QUESTION, dimension: DIMENSION_ANY, question: translation.questionTriggerSlideshow, parameters: {multiselect: 'no', optionalanswer: 'no'}, options: options});
        renderQuestionnaire(container, questions, currentQuestionnaireAnswers, false);
        $(container).find('.question-container').unbind('change').bind('change', function (event) {
            saveTriggerSlideshowAnswer(container);
        });

        if (currentSlideIndex >= data.slideshow.length - 1) {
            $(container).find('#btn-done-slide').removeClass('hidden');
            $(container).find('#btn-next-slide').addClass('hidden');
        } else {
            $(container).find('#btn-next-slide').addClass('hidden');
            $(container).find('#btn-next-slide').removeClass('hidden');
        }

        $(container).find('#btn-next-slide').unbind('click').bind('click', function (event) {
            event.preventDefault();
            saveTriggerSlideshowAnswer(container);

            currentSlideIndex++;
            renderCurrentPhaseState();
        });

        $(container).find('#btn-done-slide').unbind('click').bind('click', function (event) {
            event.preventDefault();
            saveTriggerSlideshowAnswer(container);

            if (!previewModeEnabled && peerConnection) {
                peerConnection.sendMessage(MESSAGE_TRIGGER_SLIDESHOW_DONE, currentQuestionnaireAnswers);
            }

            currentPhaseState = 'slideshowDone';
            renderCurrentPhaseState();
        });
    }

    function renderStateSlideshowDone() {
        console.log('render tester state: ', currentPhaseState);
        $(container).find('#trigger-questions').addClass('hidden');
        appendAlert($(container), ALERT_PLEASE_WAIT);
    }

    function saveTriggerSlideshowAnswer(container) {
        var slideData = data.slideshow[currentSlideIndex];
        var selectedOption = $(container).find('.option-container .btn-option-checked').attr('id');
        selectedOption = selectedOption === undefined ? -1 : selectedOption;

        if (!previewModeEnabled && peerConnection) {
            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
            tempData.selectedOptions[currentSlideIndex] = {correctTriggerId: slideData.triggerId, selectedId: selectedOption};
            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            
            currentQuestionnaireAnswers = tempData.selectedOptions;
            peerConnection.sendMessage(MESSAGE_UPDATE_QUESTIONNAIRE, tempData.selectedOptions);
        } else {
            if (currentQuestionnaireAnswers) {
                currentQuestionnaireAnswers[currentSlideIndex] = {correctTriggerId: slideData.triggerId, selectedId: selectedOption};
            } else {
                currentQuestionnaireAnswers = [{correctTriggerId: slideData.triggerId, selectedId: selectedOption}];
            }
        }
    }

    return container;
};






/*
 * observer view rendering
 */

TriggerSlideshow.prototype.renderObserverView = function () {
    console.log('render observer view:', SLIDESHOW_TRIGGER.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    if (data.slideshow.length === 0) {
        return false;
    }

    if (!data.slideshow || data.slideshow.length === 0) {
        return false;
    }

    // observation section
    renderObservations(data, container);

    // init annotation controls
    renderAnnotationControls(container);

    renderCurrentPhaseState();

    function renderCurrentPhaseState() {
        if (currentPhaseState === null) {
            currentPhaseState = 'initialize';
        }

        switch (currentPhaseState) {
            case 'initialize':
                renderStateInitialize();
                break;
            case 'slideshowStarted':
                renderStateSlideshowStarted();
                break;
            case 'slideshowDone':
                renderStateSlideshowDone();
                break;
        }
    }

    function renderStateInitialize() {
        console.log('render observer state: ', currentPhaseState);

        appendAlert(container, ALERT_PLEASE_WAIT);
        $(document).scrollTop(0);
//        $(container).find('#general').removeClass('hidden');

        if (peerConnection) {
            $(peerConnection).unbind(MESSAGE_START_TRIGGER_SLIDESHOW).bind(MESSAGE_START_TRIGGER_SLIDESHOW, function (event) {
                currentPhaseState = 'slideshowStarted';
                renderCurrentPhaseState();
            });
        }
    }

    function renderStateSlideshowStarted() {
        console.log('render observer state: ', currentPhaseState);
        clearAlerts(container);

//        $(container).find('#btn-start-slideshow').addClass('hidden');
//        $(container).find('#btn-done-slideshow').removeClass('hidden');
        $(container).find('#general').remove();
        $(container).find('#elements').removeClass('hidden');

        renderSlideshowItems(currentQuestionnaireAnswers);

        if (!previewModeEnabled) {
            $(peerConnection).unbind(MESSAGE_UPDATE_QUESTIONNAIRE).bind(MESSAGE_UPDATE_QUESTIONNAIRE, function (event, payload) {
                currentQuestionnaireAnswers = payload;
                renderSlideshowItems(payload);
            });

            $(peerConnection).unbind(MESSAGE_TRIGGER_SLIDESHOW_DONE).bind(MESSAGE_TRIGGER_SLIDESHOW_DONE, function (event, payload) {
                currentQuestionnaireAnswers = payload;
                currentPhaseState = 'slideshowDone';
                renderCurrentPhaseState();
            });
        }


    }

    function renderStateSlideshowDone() {
        console.log('render observer state: ', currentPhaseState);

        appendAlert(container, ALERT_PLEASE_WAIT);

        $(container).find('#elements').addClass('hidden');
    }

    function renderSlideshowItems(answers) {
        $(container).find('#elements .question-container').empty();

        for (var i = 0; i < data.slideshow.length; i++) {
            var item = $(getSourceContainer(VIEW_MODERATOR)).find('#triggerSlideshowItem').clone().removeAttr('id');
            $(container).find('#elements .question-container').append(item);
            var gesture = getGestureById(data.slideshow[i].gestureId);
            var trigger = getTriggerById(data.slideshow[i].triggerId);
            $(item).find('#searched').text(trigger.title);
            $(item).find('#given').text(gesture.title);
            $(item).find('.btn-popover-gesture-preview').attr('name', gesture.id);
            var answer = null;

            if (answers && answers.length > 0) {
                for (var j = 0; j < answers.length; j++) {
                    if (parseInt(answers[j].correctTriggerId) === parseInt(trigger.id)) {
                        answer = answers[j];
                        break;
                    }
                }
            }

            if (answer) {
                if (parseInt(answer.selectedId) === parseInt(trigger.id)) {
                    item.addClass('panel-success');
                    item.find('#answered-correct').removeClass('hidden');
                } else {
                    item.addClass('panel-danger');
                    item.find('#answered-wrong').removeClass('hidden');
                }
            } else {
                item.find('#not-answered').removeClass('hidden');
            }
        }
    }

    return container;
};