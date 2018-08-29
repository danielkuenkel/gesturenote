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

    

    return container;
};