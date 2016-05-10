function checkStorage() {
    if (getLocalItem(PROJECT_PHASE_STEPS) && getLocalItem(PROJECT_PHASE_STEPS).length > 0) {
        console.log('there are phase steps');
        initialize();
        renderPhases();
    } else {
        console.log('there are no phase steps');
    }
}

function initialize() {
    var project = getLocalItem(PROJECT);
    if (project.surveyType === TYPE_SURVEY_UNMODERATED) {
        $('#btnViewTester').click();
        $('#btnViewModerator').addClass('disabled');
    }
}

function renderPhases() {
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);

    var dropdown = $('body').find('.phaseStepsSelect');
    $(dropdown).find('.option').empty();

    if (phaseSteps && phaseSteps.length > 0) {
        $(dropdown).find('.dropdown-toggle').removeClass('disabled');
        var listItem;

        for (var i = 0; i < phaseSteps.length; i++) {
            listItem = document.createElement('li');
            listItem.setAttribute('id', phaseSteps[i].id);

            var link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(phaseSteps[i].itemText));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);

            if (i === 0) {
                link.click();
            }
        }
        $('body').find('.option-prototype').attr('placeholder', 'Bitte wählen');
    } else {
        $(dropdown).find('.dropdown-toggle').addClass('disabled');
        $('body').find('.option-prototype').attr('placeholder', 'Keine Projektphasen vorhanden');
    }

    var dropdownmenu = dropdown.find('.dropdown-menu');
    var width = dropdownmenu.width() - 35;
    $(dropdownmenu).css('left', -width);
}

function updateProgress() {
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);
    var percentage = Math.round(100 / phaseSteps.length * getCurrentStep());

    $('#progressTop').find('.progress-bar').attr('aria-valuenow', percentage);
    $('#progressTop').find('.progress-bar').css('width', percentage + '%');
    $('#progressTop').find('.progress-bar').text(percentage + '%');

}

function getCurrentStep() {
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);
    var activeStepId = $('#btn-phaseStepSelect .chosen').attr('id');
    console.log(activeStepId);
    for (var i = 0; i < phaseSteps.length; i++) {
        if (activeStepId === phaseSteps[i].id) {
            return i + 1;
        }
    }
}