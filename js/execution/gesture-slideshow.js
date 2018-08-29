GestureSlideshow.prototype.options = null;

function GestureSlideshow(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}



/*
 * moderator view rendering
 */

GestureSlideshow.prototype.renderModeratorView = function () {
    console.log('render moderator view:', SLIDESHOW_GESTURES.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    

    return container;
};



/*
 * tester view rendering
 */

GestureSlideshow.prototype.renderTesterView = function () {
    console.log('render tester view:', SLIDESHOW_TRIGGER.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    

    return container;
};