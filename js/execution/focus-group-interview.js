FocusGroupInterview.prototype.options = null;

function FocusGroupInterview(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}



/*
 * moderator view rendering
 */

FocusGroupInterview.prototype.renderModeratorView = function () {
    console.log('render moderator view:', FOCUS_GROUP_INTERVIEW.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');



    return container;
};



/*
 * tester view rendering
 */

FocusGroupInterview.prototype.renderTesterView = function () {
    console.log('render tester view:', FOCUS_GROUP_INTERVIEW.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');



    return container;
};