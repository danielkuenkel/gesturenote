UserExperienceQuestionnaire.prototype.options = null;

function UserExperienceQuestionnaire(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}



/*
 * moderator view rendering
 */

UserExperienceQuestionnaire.prototype.renderModeratorView = function () {
    console.log('render moderator view:', UEQ.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');
    $(container).find('.headline').text(currentPhase.title);

    var questionnaire = new Questionnaire({isPreview: true, container: container});
    container = questionnaire.renderModeratorView();
//        Moderator.getQuestionnaire(source, container, data, true);
    return container;
};



/*
 * tester view rendering
 */

UserExperienceQuestionnaire.prototype.renderTesterView = function () {
    console.log('render tester view:', UEQ.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    var questionnaire = new Questionnaire({isPreview:false, append: true, container: container});
    container = questionnaire.renderTesterView();
    $(container).find('.question-container').css({display: 'table', margin: '0 auto'});
    return container;
};