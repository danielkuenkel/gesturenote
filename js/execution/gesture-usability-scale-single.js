GestureUsabilityScaleSingle.prototype.options = null;

function GestureUsabilityScaleSingle(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}










/*
 * moderator view rendering
 */

GestureUsabilityScaleSingle.prototype.renderModeratorView = function () {
    console.log('render moderator view:', GUS_SINGLE_GESTURES.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    currentGUSData = data;
    var gesture = getGestureById(data.gestureId);
    var trigger = getTriggerById(data.triggerId);
    var feedback = getFeedbackById(data.feedbackId);

    if (gesture) {
        renderGestureImages($(container).find('.previewGesture'), gesture.images, gesture.previewImage, null);
        $(container).find('#gesture .address').text(translation.gesture + ':');
        $(container).find('#gesture .text').text(gesture.title);
        $(container).find('#trigger .address').text(translation.trigger + ':');
        $(container).find('#trigger .text').text(trigger.title);


        if (feedback) {
            $(container).find('#feedback .address').text(translation.feedback + ':');
            $(container).find('#feedback .text').text(feedback.title);
            var icon = document.createElement('i');
            var label = document.createElement('div');
            $(label).addClass('label label-default');
            switch (feedback.type) {
                case TYPE_FEEDBACK_SOUND:
                    $(label).text(' Sound');
                    $(icon).addClass('fa fa-volume-up');
                    break;
                case TYPE_FEEDBACK_TEXT:
                    $(label).text(' Text');
                    $(icon).addClass('fa fa-font');
                    break;
            }

            container.find('#feedback .text').text(" " + feedback.title);
            $(label).prepend(icon);
            container.find('#feedback .text').prepend(label);
        }
    }

    var questionnaire = new Questionnaire({isPreview: true, questions: getAssembledItems(data.gus), container: container});
    container = questionnaire.renderModeratorView();
    return container;
};


















/*
 * observer view rendering
 */

GestureUsabilityScaleSingle.prototype.renderObserverView = function () {
    console.log('render observer view:', GUS_SINGLE_GESTURES.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    currentGUSData = data;
    var gesture = getGestureById(data.gestureId);
    var trigger = getTriggerById(data.triggerId);
    var feedback = getFeedbackById(data.feedbackId);

    if (gesture) {
        renderGestureImages($(container).find('.previewGesture'), gesture.images, gesture.previewImage, null);
        $(container).find('#gesture .address').text(translation.gesture + ':');
        $(container).find('#gesture .text').text(gesture.title);
        $(container).find('#trigger .address').text(translation.trigger + ':');
        $(container).find('#trigger .text').text(trigger.title);


        if (feedback) {
            $(container).find('#feedback .address').text(translation.feedback + ':');
            $(container).find('#feedback .text').text(feedback.title);
            var icon = document.createElement('i');
            var label = document.createElement('div');
            $(label).addClass('label label-default');
            switch (feedback.type) {
                case TYPE_FEEDBACK_SOUND:
                    $(label).text(' Sound');
                    $(icon).addClass('fa fa-volume-up');
                    break;
                case TYPE_FEEDBACK_TEXT:
                    $(label).text(' Text');
                    $(icon).addClass('fa fa-font');
                    break;
            }

            container.find('#feedback .text').text(" " + feedback.title);
            $(label).prepend(icon);
            container.find('#feedback .text').prepend(label);
        }
    }

    var questionnaire = new Questionnaire({isPreview: true, questions: getAssembledItems(data.gus), container: container});
    container = questionnaire.renderObserverView();
    return container;
};









/*
 * tester view rendering
 */

GestureUsabilityScaleSingle.prototype.renderTesterView = function () {
    console.log('render tester view:', GUS_SINGLE_GESTURES.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    currentGUSData = data;
    var content = $(getSourceContainer(VIEW_TESTER)).find('#gus-' + getLocalItem(STUDY).surveyType).clone().removeAttr('id');
    $(container).append(content);
    var gesture = getGestureById(data.gestureId);
    if (gesture && isGestureAssembled(data.gestureId)) {
        singleGUSGesture = {gestureId: data.gestureId, triggerId: data.triggerId, feedbackId: data.feedbackId};
        container.find('#title').text(gesture.title);
        renderGestureImages(container.find('.previewGesture'), gesture.images, gesture.previewImage, null);
        var trigger = getTriggerById(data.triggerId);
        var feedback = getFeedbackById(data.feedbackId);
        $(container).find('#gesture .address').text(translation.gesture + ':');
        $(container).find('#gesture .text').text(gesture.title);
        $(container).find('#trigger .address').text(translation.trigger + ':');
        $(container).find('#trigger .text').text(trigger.title);
        if (feedback) {
            $(container).find('#feedback .address').text(translation.feedback + ':');
            $(container).find('#feedback .text').text(feedback.title);
            var icon = document.createElement('i');
            var label = document.createElement('div');
            $(label).addClass('label label-default');
            switch (feedback.type) {
                case TYPE_FEEDBACK_SOUND:
                    $(label).text(' Sound');
                    $(icon).addClass('fa fa-volume-up');
                    break;
                case TYPE_FEEDBACK_TEXT:
                    $(label).text(' Text');
                    $(icon).addClass('fa fa-font');
                    break;
            }

            container.find('#feedback .text').text(" " + feedback.title);
            $(label).prepend(icon);
            container.find('#feedback .text').prepend(label);
        }

    } else {
        $(container).find('#gesturePreview').addClass('hidden');
    }

    var questionnaire = new Questionnaire({isPreview: false, questions: getAssembledItems(data.gus), container: container});
    container = questionnaire.renderTesterView();
    $(container).unbind('questionnaireDone').bind('questionnaireDone', function (event) {
        event.preventDefault();
        console.log('questionnaire done catched');
        appendAlert(container, ALERT_WAITING_FOR_MODERATOR);
        $(container).find('#gus-questionnaire-content').addClass('hidden');
    });
    return container;
};