Questionnaire.prototype.options = null;

var classInternal = null;
function Questionnaire(options) {
    classInternal = this;
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = options.questions ? options.questions : getCurrentPhaseData();
    this.options.source = options.source ? options.source : getSourceContainer(currentView);
    this.options.container = options.container || null;

    return this;
}



/*
 * moderator view rendering
 */

Questionnaire.prototype.renderModeratorView = function () {
    console.log('render moderator view:', QUESTIONNAIRE.toUpperCase());

    var currentPhase = classInternal.options.currentPhase;
    var data = classInternal.options.questions ? classInternal.options.questions : classInternal.options.currentPhaseData;
    var source = classInternal.options.source;
    var isPreview = classInternal.options.isPreview || false;
    var container = classInternal.options.container !== null ? classInternal.options.container : $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');
    
//    console.log(data, data.length)
    if (data && data.length > 0) {
        if (isPreview) {
            console.log('render questionnaire answers');
            renderQuestionnaireAnswers(container, data, currentQuestionnaireAnswers, true);
        } else {
            console.log('render questionnaire');
            renderQuestionnaire(container, data, currentQuestionnaireAnswers, true);
        }
    } else {
        appendAlert(container, ALERT_NO_PHASE_DATA);
    }

    if (currentPhase.format === INTERVIEW || currentPhase.format === FOCUS_GROUP_INTERVIEW) {
        $(container).find('.question-container').unbind('questionnaireDone').bind('questionnaireDone', function (event) {
            event.preventDefault();
            console.log('questionnaire done triggered');

            $(container).find('#btn-next-step').prev().addClass('hidden');
            $(container).find('#btn-next-step').addClass('hidden');

            questionnaireDone = true;
            currentQuestionnaireAnswers = checkCurrentQuestionnaireAnswers(getQuestionnaireAnswers(container.find('.question-container').children(), data));

            if (!previewModeEnabled && peerConnection) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.answers = currentQuestionnaireAnswers.answers;
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            }

            $(container).find('#btn-next-step').click();
        });

        $(container).find('.question-container').unbind('nextQuestion').bind('nextQuestion', function (event) {
            console.log('next question clicked');
            event.preventDefault();
            currentQuestionnaireAnswers = checkCurrentQuestionnaireAnswers(getQuestionnaireAnswers(container.find('.question-container').children(), data));

            if (previewModeEnabled === false && peerConnection) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.answers = currentQuestionnaireAnswers.answers;
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            }
        });

        $(container).unbind('change').bind('change', function (event) {
            event.preventDefault();
            currentQuestionnaireAnswers = checkCurrentQuestionnaireAnswers(getQuestionnaireAnswers(container.find('.question-container').children(), data));

            if (previewModeEnabled === false && peerConnection) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.answers = currentQuestionnaireAnswers.answers;
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            }
        });
    }

    $(container).find('#btn-next-step').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            if (!previewModeEnabled && peerConnection) {
                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
            }
            nextStep();
        }
    });

    if (questionnaireDone) {
        $(container).find('#btn-next-step').removeClass('disabled');
    }

    if (!previewModeEnabled && peerConnection) {
        $(peerConnection).unbind(MESSAGE_QUESTIONNAIRE_DONE).bind(MESSAGE_QUESTIONNAIRE_DONE, function (event, payload) {
            $(container).find('#btn-next-step').removeClass('disabled');
        });

        if (getCurrentPhase().format !== PHYSICAL_STRESS_TEST) {
            $(peerConnection).unbind(MESSAGE_UPDATE_QUESTIONNAIRE).bind(MESSAGE_UPDATE_QUESTIONNAIRE, function (event, payload) {
                console.log('update questionnaire', payload);
                renderQuestionnaireAnswers(container, data, payload);
            });
        }
    }

    return container;
};



/*
 * tester view rendering
 */

Questionnaire.prototype.renderTesterView = function () {
    console.log('render tester view:', QUESTIONNAIRE.toUpperCase());

    var currentPhase = classInternal.options.currentPhase;
    var data = classInternal.options.questions ? classInternal.options.questions : classInternal.options.currentPhaseData;
    var source = classInternal.options.source;
    var container = classInternal.options.container !== null ? classInternal.options.container : $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');
    var append = classInternal.options.append || false;

    if (append === true) {
        var content = $(getSourceContainer(VIEW_TESTER)).find('#questionnaire-' + getLocalItem(STUDY).surveyType).clone().removeAttr('id');
        $(container).append(content);
    }

//    console.log('currentQuestionnaireAnswers', currentQuestionnaireAnswers);
    container = renderQuestionnaire(container, data, currentQuestionnaireAnswers, true);
    $(container).find('.headline').text(currentPhase.title);

    $(container).find('.question-container').unbind('questionnaireDone').bind('questionnaireDone', function (event) {
        event.preventDefault();
        console.log('questionnaire done triggered');
        $(container).find('#btn-next-step').prev().addClass('hidden');
        $(container).find('#btn-next-step').addClass('hidden');
        questionnaireDone = true;
        currentQuestionnaireAnswers = checkCurrentQuestionnaireAnswers(getQuestionnaireAnswers(container.find('.question-container').children(), data));
        if (!previewModeEnabled && peerConnection) {
            var currentPhase = getCurrentPhase();
            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
            tempData.answers = currentQuestionnaireAnswers.answers;
            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            peerConnection.sendMessage(MESSAGE_QUESTIONNAIRE_DONE);
        }
    });

    $(container).find('.question-container').unbind('nextQuestion').bind('nextQuestion', function (event) {
        console.log('next question clicked');
        event.preventDefault();
        currentQuestionnaireAnswers = checkCurrentQuestionnaireAnswers(getQuestionnaireAnswers(container.find('.question-container').children(), data));
        if (previewModeEnabled === false && peerConnection) {
            var currentPhase = getCurrentPhase();
            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
            tempData.answers = currentQuestionnaireAnswers.answers;
            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            peerConnection.sendMessage(MESSAGE_UPDATE_QUESTIONNAIRE, currentQuestionnaireAnswers);
        }
    });

    if (questionnaireDone) {
        $(container).find('.question-container').addClass('hidden');
        $(container).find('#btn-next-step').prev().addClass('hidden');
        $(container).find('#btn-next-step').addClass('hidden');
        appendAlert(container, ALERT_WAITING_FOR_MODERATOR);
    }

    if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_MODERATED && currentPhase.format !== PHYSICAL_STRESS_TEST && currentPhase.format !== SLIDESHOW_TRIGGER) {
        $(container).unbind('change').bind('change', function (event) {
            event.preventDefault();
            currentQuestionnaireAnswers = checkCurrentQuestionnaireAnswers(getQuestionnaireAnswers(container.find('.question-container').children(), data));
            if (previewModeEnabled === false && peerConnection) {
                var currentPhase = getCurrentPhase();
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.answers = currentQuestionnaireAnswers.answers;
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                peerConnection.sendMessage(MESSAGE_UPDATE_QUESTIONNAIRE, currentQuestionnaireAnswers);
            }
        });
    }

    return container;
};