Interview.prototype.options = null;

function Interview(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}



/*
 * moderator view rendering
 */

Interview.prototype.renderModeratorView = function () {
    console.log('render moderator view:', INTERVIEW.toUpperCase());

    var questionnaire = new Questionnaire({isPreview: false});
    var container = questionnaire.renderModeratorView();

    return container;
};



/*
 * tester view rendering
 */

Interview.prototype.renderTesterView = function () {
    console.log('render tester view:', INTERVIEW.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    if (!data || (data && data.length === 0)) {
        return false;
    }

    $(container).find('.headline').text(getCurrentPhase().title);

    for (var i = 0; i < data.length; i++) {
        var questionItem = document.createElement('div');
        $(questionItem).addClass('panel panel-shadow');
        $(questionItem).css({marginBottom: '5px'});
        var panelBody = document.createElement('div');
        $(panelBody).addClass('panel-body text');
        $(panelBody).text((i + 1) + '. ' + data[i].question);
        $(questionItem).append(panelBody);
        $(container).find('.question-container').append(questionItem);
    }

    return container;
};