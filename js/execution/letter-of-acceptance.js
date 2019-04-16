LetterOfAcceptance.prototype.options = null;

function LetterOfAcceptance(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}



/*
 * moderator view rendering
 */

LetterOfAcceptance.prototype.renderModeratorView = function () {
    console.log('render moderator view:', LETTER_OF_ACCEPTANCE.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    $(container).find('.letter-text').html(data);
    appendAlert(container, ALERT_PLEASE_WAIT);
    return container;
};



/*
 * tester view rendering
 */

LetterOfAcceptance.prototype.renderTesterView = function () {
    console.log('render tester view:', LETTER_OF_ACCEPTANCE.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    var content = $(source).find('#letterOfAcceptance-' + getLocalItem(STUDY).surveyType).clone().removeAttr('id');
    $(container).append(content);
    $(container).find('.letter-text').html(data);
    $(container).find('#letter-agreed').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!previewModeEnabled && peerConnection) {
            peerConnection.takeSnapshot(true, function () {
                console.log('snapshot taken and uploaded, now to next step');
                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                tempData.accepted = 'yes';
                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);

                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
                nextStep();
            });
        } else {
            nextStep();
        }
    });

    $(container).find('#letter-decline').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!previewModeEnabled) {
            var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
            tempData.accepted = 'no';
            setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
        }

        $('.btn-cancel').click();
    });

    return container;
};






/*
 * observer view rendering
 */

LetterOfAcceptance.prototype.renderObserverView = function () {
    console.log('render observer view:', LETTER_OF_ACCEPTANCE.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    $(container).find('.letter-text').html(data);
    appendAlert(container, ALERT_PLEASE_WAIT);
    return container;
};







/*
 * observer view rendering
 */

LetterOfAcceptance.prototype.renderWizardView = function () {
    console.log('render wizard view:', LETTER_OF_ACCEPTANCE.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    $(container).find('.letter-text').html(data);
    appendAlert(container, ALERT_PLEASE_WAIT);
    return container;
};

