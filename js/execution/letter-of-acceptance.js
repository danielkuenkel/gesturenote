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

    $(container).find('.letter-text').text(data);
    appendAlert(container, ALERT_PLEASE_WAIT);
    return container;

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
    $(container).find('.letter-text').text(data);
    $(container).find('#letter-agreed').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!previewModeEnabled) {
            var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
            tempData.accepted = 'yes';
            setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
            }
        }

        nextStep();
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