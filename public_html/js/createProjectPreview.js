var currentGestureTrainingIndex = 0;
var trainingTriggered = false;
var triggeredFeedback = null;
var currentSlideIndex = 0;
var slideTriggered = false;
var currentSceneId;
var scenarioStartTriggered = false;
var triggeredWoz = null;
var triggeredHelp = null;

function checkStorage() {
    if (getLocalItem(PROJECT_PHASE_STEPS) && getLocalItem(PROJECT_PHASE_STEPS).length > 0) {
//        console.log('there are phase steps');
        initialize();
        renderPhases();

    } else {
//        console.log('there are no phase steps');
    }
}

function initialize() {
    var project = getLocalItem(PROJECT);
    if (project.surveyType === TYPE_SURVEY_UNMODERATED) {
        showTesterView();
        $('#btnViewModerator').addClass('disabled');
    } else {
        showModeratorView();
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
            link.appendChild(document.createTextNode(translation.formats[phaseSteps[i].selectedId]));
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

function previousStep() {
    scenarioStartTriggered = false;
    triggeredHelp = null;
    triggeredWoz = null;
    $('.phaseStepsSelect .dropdown-menu .selected').prev().click();
}

function nextStep() {
    scenarioStartTriggered = false;
    triggeredHelp = null;
    triggeredWoz = null;
    $('.phaseStepsSelect .dropdown-menu .selected').next().click();
}

function updatePager() {
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);
    if (phaseSteps && phaseSteps.length > 1) {
        var currentStepCount = getCurrentStep();
        if (currentStepCount <= 0) {
            $('.previous').addClass('disabled');
            $('.next').removeClass('disabled');
        } else if (currentStepCount >= phaseSteps.length - 1) {
            $('.previous').removeClass('disabled');
            $('.next').addClass('disabled');
        } else {
            $('.previous').removeClass('disabled');
            $('.next').removeClass('disabled');
        }
    } else {
        $('.previous').addClass('disabled');
        $('.next').addClass('disabled');
    }
}

function updateProgress() {
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);
    var percentage = Math.round(100 / phaseSteps.length * (getCurrentStep() + 1));

    $('#progressTop').find('.progress-bar').attr('aria-valuenow', percentage);
    $('#progressTop').find('.progress-bar').css('width', percentage + '%');
    $('#progressTop').find('.progress-bar').text(percentage + '%');

}

function getCurrentStep() {
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);
    var currentStepId = $('#btn-phaseStepSelect .chosen').attr('id');
    for (var i = 0; i < phaseSteps.length; i++) {
        if (currentStepId === phaseSteps[i].id) {
            return i;
        }
    }
}

function getCurrentPhase() {
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);
    var currentStepId = $('#btn-phaseStepSelect .chosen').attr('id');
    for (var i = 0; i < phaseSteps.length; i++) {
        if (currentStepId === phaseSteps[i].id) {
            return phaseSteps[i];
        }
    }
    return null;
}

function getSourceContainer(selector) {
    return selector === VIEW_MODERATOR ? $('#item-container-moderator') : $('#item-container-tester');
}

var draggable = null;
var resizable = false;
var resizing = false;
var DRAGGABLE_MAX_WIDTH = 1250;
var DRAGGABLE_MIN_WIDTH = 250;
function dragRTC() {
    $('#web-rtc-placeholder').width(DRAGGABLE_MAX_WIDTH - 150);
    $('#web-rtc-placeholder').addClass('shadow');
    $('#draggableRTC').removeClass('hidden');
    $('#pinnedRTC').addClass('hidden');
    $('#web-rtc-placeholder').appendTo("#draggableRTC");
    TweenMax.to($('#phase-content #column-left'), .2, {css: {marginTop: 0, opacity: 1.0}});

    $('#draggableRTC').bind('mousemove', function (event) {
        var x = event.pageX - $(this).offset().left;
        var y = event.pageY - $(this).offset().top;

        if (!resizing) {
            if (x > $(this).innerWidth() - 20 && y > $(this).innerHeight() - 20) {
                showCursor($(this), CURSOR_NWSE_RESIZE);
                resizable = true;
            } else {
                resizable = false;
                showCursor($(this), CURSOR_MOVE);
            }
        }
    });

    $(window).mousemove(function (event) {
        event.preventDefault();

        if (draggable) {
            if (resizable) {
                var newWidth = Math.min(Math.max(event.pageX - $('#draggableRTC').offset().left, DRAGGABLE_MIN_WIDTH), DRAGGABLE_MAX_WIDTH);
                $('#web-rtc-placeholder').width(newWidth);
            } else {
                var x = event.pageX - draggable.offsetLeft;
                var y = event.pageY - draggable.offsetTop;
                $('#draggableRTC').offset({
                    left: x,
                    top: y
                });
            }
        }
    });

    $('#draggableRTC').bind('mousedown', function (event) {
        draggable = {offsetLeft: event.pageX - $('#draggableRTC').offset().left, offsetTop: event.pageY - $('#draggableRTC').offset().top};
        if (resizable) {
            resizing = true;
            $('#draggableRTC').unbind('mouseleave');
        }
    });

    $(window).bind('mouseup', function (event) {
        draggable = null;

        if (resizable) {
            resizable = false;
            resizing = false;
        }
    });

    $('#draggableRTC').bind('mouseleave', function (event) {
        event.preventDefault();
        if (!resizing) {
            draggable = null;
            resizable = false;
            showCursor($(this), CURSOR_AUTO);
        }
    });
}

function pinRTC() {
    $('#pinnedRTC').removeClass('hidden');
    $('#draggableRTC').addClass('hidden');
    $('#web-rtc-placeholder').removeClass('shadow');
    $('#web-rtc-placeholder').appendTo("#pinnedRTC");
    $(document).scrollTop(0);
    resetRTC();
    $('#draggableRTC').css({top: 150, left: 50});
}