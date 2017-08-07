var currentPhaseStepIndex = 0;

var questionnaireDone = false;
var currentGestureTrainingIndex = 0;
var currentTrainingIndex = 0;
var trainingTriggered = false;
var triggeredFeedback = null;
var slidesRestartCount = 0;
var slideshowStartTriggered = false;
var slideRestarted = false;
var triggerSlideshowDone = false;
var currentSlideIndex = 0;
var slideTriggered = false;
var currentWOZScene = null;
var currentSceneId;
var scenarioStartTriggered = false;
var scenarioPrototypeOpened = false;
var triggeredWoz = null;
var triggeredHelp = null;
var currentTriggeredSceneId = null;
var gestureTrainingStartTriggered = false;
var currentIdentificationIndex = 0;
var identificationTriggered = false;
var identificationStartTriggered = false;
var identificationDone = false;
var explorationStartTriggered = false;
var explorationDone = false;

var currentStressTestCount = 0;
var currentStressTestIndex = 0;
var stressTestStartTriggered = false;
var stressTestGestureTriggered = false;
var stressTestQuestionsTriggered = false;

var testerDoneTriggered = false;
var previewModeEnabled = false;

var currentGUSData = null;

var syncPhaseStep = false;
var peerConnection = null;

var currentQuestionnaireAnswers = null;

function checkStorage() {
    if (isLocalStorageSupported()) {
        var phaseSteps = getContextualPhaseSteps();
        if (phaseSteps && phaseSteps.length > 0) {
            initialize();

            if (previewModeEnabled) {
                renderPhases();
            }
        } else {
//        console.log('there are no phase steps');
        }
    } else {
        console.log("Sorry, your browser do not support Web Session Storage.");
    }
}

var uploadQueue = null;
function initialize() {
    var study = getLocalItem(STUDY);
    if (previewModeEnabled === true) {
        if (study.surveyType === TYPE_SURVEY_UNMODERATED) {
            showTesterView();
            $('#btnViewModerator').addClass('disabled');
        } else {
            showModeratorView();
        }
    } else {
        uploadQueue = new UploadQueue();
        $(uploadQueue).unbind(EVENT_FILE_SAVED).bind(EVENT_FILE_SAVED, function (event, result) {
            var phaseStepData = getLocalItem(result.phaseStepId + '.saveData');
            console.log(result.phaseStepId, phaseStepData);
            if (phaseStepData) {
                phaseStepData.recordUrl = result.filename;
                setLocalItem(result.phaseStepId + '.saveData', phaseStepData);

                var phases = getContextualPhaseSteps();
                if (currentPhaseStepIndex < phases.length - 1 && getCurrentPhase().format !== THANKS) {
                    saveCurrentStatus(false);
                }
            }
        });

        var study = getLocalItem(STUDY);
        study.aborted = 'no';
        setLocalItem(STUDY, study);

        setLocalItem('startExecutionTime', new Date().getTime());
        renderPhaseStep();
        updateProgress();
    }

    $('.btn-cancel').click(function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            loadHTMLintoModal('custom-modal', 'modal-cancel-study.php', 'modal-sm');
        }
    });

    if (study.surveyType === TYPE_SURVEY_UNMODERATED) {
        $(document).on('click', '.next-step', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                nextStep();
            }
        });
    }

    if (previewModeEnabled) {
        $(document).on('click', '.next', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                nextStep();
            }
        });
    }
}

function renderPhases() {
    var phaseSteps = getContextualPhaseSteps();

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
            link.appendChild(document.createTextNode(phaseSteps[i].title));
            $(listItem).append(link);
            $(dropdown).find('.option').append(listItem);

            if (i === currentPhaseStepIndex) {
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
    resetConstraints();
    resetRecorder();

    var phases = getContextualPhaseSteps();
    if (phases && phases.length > 0) {
        currentPhaseStepIndex = Math.max(currentPhaseStepIndex - 1, 0);
    }

    if (previewModeEnabled === true) {
        $('.phaseStepsSelect .dropdown-menu .selected').prev().click();
    }
}

function nextStep() {
    console.log('next step called');
    resetConstraints();
    if (currentView === VIEW_TESTER) {
        resetRecorder();
    }

    var phases = getContextualPhaseSteps();
    if (previewModeEnabled === false) {
        if (currentPhaseStepIndex < phases.length - 1) {
            saveCurrentStatus(false);
        }

        if (isUploadRecordingNeededForPhaseStep(getCurrentPhase())) {
            peerConnection.stopRecording(function () {
                console.log('recording stopped, now decrease and render phase step');
                currentPhaseStepIndex = Math.min(currentPhaseStepIndex + 1, phases.length - 1);
//                currentPhaseStepIndex++;
//                if (currentPhaseStepIndex < phases.length) {
                renderPhaseStep();
//                }
                updateProgress();
            }, true);
        } else {
            console.log('no stop recording needed, render phase step now');
            currentPhaseStepIndex = Math.min(currentPhaseStepIndex + 1, phases.length - 1);
//            if (currentPhaseStepIndex < phases.length) {
            renderPhaseStep();
//            }
            updateProgress();
        }
    } else {
        currentPhaseStepIndex = Math.min(currentPhaseStepIndex + 1, phases.length - 1);
        $('.phaseStepsSelect .dropdown-menu .selected').next().click();
    }
}

function resetConstraints() {
//    TweenMax.killAll();
    questionnaireDone = false;
    testerDoneTriggered = false;

    gestureTrainingStartTriggered = false;
    currentGestureTrainingIndex = 0;
    currentTrainingIndex = 0;

    slideshowStartTriggered = false;
    slideTriggered = false;
    currentSlideIndex = 0;
    slideRestarted = false;
    slidesRestartCount = 0;
    triggerSlideshowDone = false;

    scenarioStartTriggered = false;
    scenarioPrototypeOpened = false;
    triggeredHelp = null;
    triggeredWoz = null;

    currentStressTestCount = 0;
    currentStressTestIndex = 0;
    stressTestStartTriggered = false;
    stressTestGestureTriggered = false;
    stressTestQuestionsTriggered = false;

    currentIdentificationIndex = 0;
    identificationTriggered = false;
    identificationStartTriggered = false;
    identificationDone = false;

    explorationStartTriggered = false;
    explorationDone = false;

    singleGUSGesture = null;
    currentGUSData = null;
    
    currentQuestionnaireAnswers = null;
}

function rescueVideoCaller() {
//    var study = getLocalItem(STUDY);
    if (!previewModeEnabled && currentView === VIEW_TESTER) {
//        console.log('rescue video caller', $('#video-caller-holder'));
        $('#video-caller-holder').append($('#video-caller'));
//        console.log($('#video-caller-holder'));

    }
}

function updatePager() {
    var phaseSteps = getContextualPhaseSteps();
    if (phaseSteps && phaseSteps.length > 1) {
        if (currentPhaseStepIndex <= 0) {
            $('.previous').addClass('disabled');
            $('.next').removeClass('disabled');
        } else if (currentPhaseStepIndex >= phaseSteps.length - 1) {
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
    var phaseSteps = getContextualPhaseSteps();
    var percentage = Math.round(100 / phaseSteps.length * (currentPhaseStepIndex + 1));
    $('#progressTop').find('.progress-bar').attr('aria-valuenow', percentage);
    $('#progressTop').find('.progress-bar').css('width', percentage + '%');
    $('#progressTop').find('.progress-bar').text(percentage + '%');
}

function getCurrentPhaseStepIndex() {
    var phaseSteps = getContextualPhaseSteps();
    var currentStepId = $('#btn-phaseStepSelect .chosen').attr('id');
    for (var i = 0; i < phaseSteps.length; i++) {
        if (currentStepId === phaseSteps[i].id) {
            return i;
        }
    }
}

function getThanksStepIndex() {
    var phaseSteps = getContextualPhaseSteps();
    for (var i = 0; i < phaseSteps.length; i++) {
        if (phaseSteps[i].format === THANKS) {
            return i;
        }
    }
    return null;
}

function getCurrentPhase() {
    var phaseSteps = getContextualPhaseSteps();
    return phaseSteps[currentPhaseStepIndex];
}

function getCurrentPhaseData() {
    var currentPhase = getCurrentPhase();
    if (currentPhase) {
        return getLocalItem(currentPhase.id + '.data');
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
    $('#web-rtc-placeholder').width(DRAGGABLE_MIN_WIDTH + 50);
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

function getItemsForSceneId(data, sceneId) {
    if (data && data.length > 0) {
        var array = new Array();
        for (var i = 0; i < data.length; i++) {
            if (parseInt(data[i].sceneId) === parseInt(sceneId)) {
                array.push(data[i]);
            }
        }
        return array;
    }
    return null;
}

function getUngroupedExplorationGestures(data) {
    if (data && data.length > 0) {
        var items = new Array();
        for (var i = 0; i < data.length; i++) {
            if (data[i].gestureId && data[i].gestureId !== '') {
                items.push(data[i].gestureId);
            }
        }
        items = unique(items);
        return items;
    }

    return null;
}

function getUngroupedExplorationTrigger(data) {
    if (data && data.length > 0) {
        var items = new Array();
        for (var i = 0; i < data.length; i++) {
            if (data[i].triggerId && data[i].triggerId !== '' && data[i].triggerId !== 'none') {
                items.push(data[i].triggerId);
            }
        }
        items = unique(items);
        return items;
    }

    return null;
}

function getUngroupedExplorationScenes(data) {
    if (data && data.length > 0) {
        var items = new Array();
        for (var i = 0; i < data.length; i++) {
            if (data[i].sceneId && data[i].sceneId !== '' && data[i].sceneId !== 'none') {
                items.push(data[i].sceneId);
            }
        }
        items = unique(items);
        return items;
    }

    return null;
}

function renderExplorationItems(target, data, modalId) {
    if (data.grouping === 'ungrouped') {
        var gestures = getUngroupedExplorationGestures(data.exploration);
        var triggers = getUngroupedExplorationTrigger(data.exploration);
        var scenes = getUngroupedExplorationScenes(data.exploration);
        var itemContainer, item;
//        console.log(data);
        if (scenes && scenes.length > 0) {
//            console.log('there are scenes');
            itemContainer = $(getSourceContainer(VIEW_MODERATOR)).find('#ungrouped-exploration-scene-panel').clone();
            $(target).find('#exploration-items-container').append(itemContainer);

            for (var i = 0; i < scenes.length; i++) {
                var scene = getSceneById(scenes[i]);
                item = $(getSourceContainer(VIEW_MODERATOR)).find('#scenes-catalog-thumbnail').clone().removeAttr('id');
                item.find('.text').text(scene.title);
                item.find('.label-text').text(translation.sceneTypes[scene.type]);
                item.find('#info-' + scene.type).removeClass('hidden');
                itemContainer.find('#panel-container').append(item);
                
//                TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                $(item).find('#btn-preview-scene').click({sceneId: scene.id}, function (event) {
                    event.preventDefault();
                    currentSceneId = event.data.sceneId;
                    loadHTMLintoModal('custom-modal', 'modal-scene.php', 'modal-lg');
                });
            }
        }

        if (triggers && triggers.length > 0) {
//            console.log('there are trigger', triggers);
            itemContainer = $(getSourceContainer(VIEW_MODERATOR)).find('#ungrouped-exploration-trigger-panel').clone();
            $(target).find('#exploration-items-container').append(itemContainer);
            for (var i = 0; i < triggers.length; i++) {
                var trigger = getTriggerById(triggers[i]);
//                console.log('trigger', trigger)
                item = $(getSourceContainer(VIEW_MODERATOR)).find('#trigger-catalog-thumbnail').clone().removeAttr('id');
                item.text(trigger.title);
                itemContainer.find('#panel-container').append(item);
            }
        }

        if (gestures && gestures.length > 0) {
            itemContainer = $(getSourceContainer(VIEW_MODERATOR)).find('#ungrouped-exploration-gesture-panel').clone();
            $(target).find('#exploration-items-container').append(itemContainer);

            for (var i = 0; i < gestures.length; i++) {
                var gesture = getGestureById(gestures[i]);
                item = getGestureCatalogListThumbnail(gesture, 'exploration-gestures-catalog-thumbnail', null, null, null, modalId);
                itemContainer.find('#panel-container').append(item);
            }
        }
    } else {

    }
}