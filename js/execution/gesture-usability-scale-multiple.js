GestureUsabilityScaleMultiple.prototype.options = null;

function GestureUsabilityScaleMultiple(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}



/*
 * moderator view rendering
 */

GestureUsabilityScaleMultiple.prototype.renderModeratorView = function () {
    console.log('render moderator view:', GUS_MULTIPLE_GESTURES.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    var questionnaire = new Questionnaire({isPreview: true, questions: getAssembledItems(data.gus), container: container});
    container = questionnaire.renderModeratorView();
    return container;
};



/*
 * tester view rendering
 */

GestureUsabilityScaleMultiple.prototype.renderTesterView = function () {
    console.log('render tester view:', GUS_MULTIPLE_GESTURES.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

//    console.log(getAssembledItems(data.gus), container)
    var questionnaire = new Questionnaire({append: true, questions: getAssembledItems(data.gus), container: container});
    container = questionnaire.renderTesterView();
    return container;
};