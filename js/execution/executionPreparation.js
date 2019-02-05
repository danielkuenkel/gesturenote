ExecutionPreparation.prototype.options = null;

function ExecutionPreparation(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}



/*
 * moderator view rendering
 */

ExecutionPreparation.prototype.renderModeratorView = function () {
    console.log('render moderator view:', LETTER_OF_ACCEPTANCE.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    renderCurrentPhaseState();

    function renderCurrentPhaseState() {
        if (currentPhaseState === null) {
            currentPhaseState = 'initialize';
        }

        switch (currentPhaseState) {
            case 'initialize':
                renderStateInitialize();
                break;

        }
    }

    function renderStateInitialize() {
        console.log('render moderator state: ', currentPhaseState, data);
        $(container).find('#preparation-study-headline').text(data.title);
        $(container).find('#preparation-type-survey').text(translation.surveyType[data.surveyType]);
        $(container).find('#preparation-type-phase').text(translation.phaseType[data.phase]);
        $(container).find('#preparation-study-description .address').text(translation.description);
        $(container).find('#preparation-study-description .text').text(data.description);

        // date range view
        var now = new Date().getTime();
        var dateFrom = data.dateFrom * 1000;
        var dateTo = addDays(data.dateTo * 1000, 1);
        var totalDays = rangeDays(dateFrom, dateTo);

        $(container).find('.preparation-study-plan').find('.address').text(now > dateTo ? translation.studyRuns : translation.studyRun + ": ");
        $(container).find('.preparation-study-plan').find('.text').text(totalDays + " " + (totalDays === 1 ? translation.day : translation.days) + ", " + translation.from + ' ' + (totalDays === 1 ? new Date(dateFrom).toLocaleDateString() : new Date(dateFrom).toLocaleDateString() + " " + translation.to + " " + new Date(dateTo).toLocaleDateString()));
        $(container).find('.preparation-study-plan').removeClass('hidden');

        $(container).find('#btn-preparation-check-rtc').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(container).find('#preparation-check-rtc-status').removeClass('hidden');
            setTimeout(function () {
                $(container).find('#preparation-check-rtc-status').addClass('hidden');
                $(container).find('#preparation-participation-queue').removeClass('hidden');
            }, 2000);
        });

        $(container).find('#dummy-participant').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(container).find('#preparation-participation-queue').addClass('hidden');
            $(container).find('#preparation-role-selection-container').addClass('hidden');
            $(container).find('#preparation-call-screen').removeClass('hidden');
        });

        $(container).find('#btn-preparation-close-call').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(container).find('#preparation-participation-queue').removeClass('hidden');
            $(container).find('#preparation-role-selection-container').removeClass('hidden');
            $(container).find('#preparation-call-screen').addClass('hidden');
        });

        $(container).find('#btn-preparation-enter-study').unbind('click').bind('click', function (event) {
            event.preventDefault();
            nextStep();
        });
    }




    return container;
};



/*
 * tester view rendering
 */

ExecutionPreparation.prototype.renderTesterView = function () {
    console.log('render tester view:', LETTER_OF_ACCEPTANCE.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    renderCurrentPhaseState();
    function renderCurrentPhaseState() {
        if (currentPhaseState === null) {
            currentPhaseState = 'initialize';
        }

        switch (currentPhaseState) {
            case 'initialize':
                renderStateInitialize();
                break;

        }
    }

    function renderStateInitialize() {
        console.log('render tester state: ', currentPhaseState, data);

        $(container).find('#preparation-study-headline').text(data.title);
        $(container).find('#preparation-study-description .text').text(data.description);

        // date range view
        var now = new Date().getTime();
        var dateFrom = data.dateFrom * 1000;
        var dateTo = addDays(data.dateTo * 1000, 1);

        if (data.surveyType === TYPE_SURVEY_MODERATED) {
            $(container).find('#btn-preparation-enter-study').addClass('hidden');
        }

        appendAlert($(container).find('#preparation-study-participation'), ALERT_INSERT_NAME);

        $(container).find('#preparation-participant-name #preparation-name-input').keypress(function (event) {
            clearAlerts($(container).find('#preparation-study-participation'));
            if ($(this).val().trim() === '') {
                appendAlert($(container).find('#preparation-study-participation'), ALERT_MISSING_NAME);
            } else if (event.keyCode === 13) {
                $(this).blur();
                $(container).find('#btn-preparation-request-participation').click();
            }
        });

        $(container).find('#btn-preparation-request-participation').on('click', function (event) {
            event.preventDefault();
            $(this).remove();
            clearAlerts($(container).find('#preparation-study-participation'));
            $(container).find('#preparation-check-rtc-status').removeClass('hidden');
            $(container).find('#preparation-init-timer-progress').removeClass('hidden');
            var progressBar = $(container).find('#preparation-init-timer-progress-bar');
            $(progressBar).css({width: '100%'});
            TweenMax.to(progressBar, 3, {width: '0%', ease: Linear.easeNone, onComplete: function () {
                    appendAlert($(container).find('#preparation-video-caller-container'), ALERT_WAITING_FOR_MODERATOR);
                    $(container).find('#preparation-check-rtc-status').addClass('hidden');
                    $(container).find('#preparation-video-caller-container').removeClass('hidden');
                }});
        });
    }

    return container;
};