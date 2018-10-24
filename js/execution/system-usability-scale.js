SystemUsabilityScale.prototype.options = null;

function SystemUsabilityScale(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}



/*
 * moderator view rendering
 */

SystemUsabilityScale.prototype.renderModeratorView = function () {
    console.log('render moderator view:', SUS.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');
    console.log(container, $(container).find('.headline'), currentPhase.title)
    $(container).find('.headline').text(currentPhase.title);

    var questionnaire = new Questionnaire({isPreview: true, container: container});
    container = questionnaire.renderModeratorView();
//        Moderator.getQuestionnaire(source, container, data, true);
    return container;
};



/*
 * observer view rendering
 */

SystemUsabilityScale.prototype.renderObserverView = function () {
    console.log('render moderator view:', SUS.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');
    console.log(container, $(container).find('.headline'), currentPhase.title)
    $(container).find('.headline').text(currentPhase.title);

    var questionnaire = new Questionnaire({isPreview: true, container: container});
    container = questionnaire.renderObserverView();
    return container;
};



/*
 * tester view rendering
 */

SystemUsabilityScale.prototype.renderTesterView = function () {
    console.log('render tester view:', SUS.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
//    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    var content = $(getSourceContainer(VIEW_TESTER)).find('#sus-' + getLocalItem(STUDY).surveyType).clone();
    $(container).append(content);
//    container = Tester.getQuestionnaire(container, data, false);
//    return container;

    var questionnaire = new Questionnaire({isPreview: false, container: container});
    container = questionnaire.renderTesterView();
    return container;
};