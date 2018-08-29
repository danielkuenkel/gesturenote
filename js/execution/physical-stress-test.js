PhysicalStressTest.prototype.options = null;

function PhysicalStressTest(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}



/*
 * moderator view rendering
 */

PhysicalStressTest.prototype.renderModeratorView = function () {
    console.log('render moderator view:', PHYSICAL_STRESS_TEST.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    

    return container;
};



/*
 * tester view rendering
 */

PhysicalStressTest.prototype.renderTesterView = function () {
    console.log('render tester view:', PHYSICAL_STRESS_TEST.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    

    return container;
};