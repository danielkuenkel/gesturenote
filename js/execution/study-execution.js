var currentPhaseStepIndex = 0;
var currentClass = null;

var questionnaireDone = false;
//var gestureTrainingStartTriggered = false;
var currentTrainingIndex = 0;
var currentTrainingRepeatCount = 0;
//var trainingTriggered = false;
//var trainingShowGesture = false;
//var trainingPrototypeOpened = false;
var triggeredFeedback = null;
var slidesRestartCount = 0;
//var slideshowStartTriggered = false;
//var slideRestarted = false;
//var triggerSlideshowDone = false;
var currentSlideIndex = 0;
//var slideTriggered = false;
var currentWOZScene = null;
var currentScenarioTask = null;
var currentScenarioTaskIndex = 0;
var currentSceneId;
//var scenarioStartTriggered = false;
//var scenarioPrototypeOpened = false;
//var triggeredWoz = null;
var triggeredHelp = null;
//var scenarioDone = false;
var currentTriggeredSceneId = null;
var currentIdentificationIndex = 0;
var currentIdentificationScene = 0;
var gestureRecorder = null;
//var identificationPrototypeOpened = false;
//var identificationSensorInitialized = false;
//var identificationTriggered = false;
//var identificationStartTriggered = false;
//var identificationRecordingStartTriggered = false;
//var identificationRecordingStopTriggered = false;
//var identificationTriggerRequest = false;
//var identificationDone = false;
var recordedIdentificationMedia = [];
var currentExplorationIndex = 0;
var currentExplorationScene = 0;
//var currentPresentGesture = null;
//var currentPresentTrigger = null;
var currentPresentGestureInfoClosed = false;
var explorationShowGestures = false;
//var explorationPrototypeOpened = false;
//var explorationStartTriggered = false;
//var explorationPreferredGesturesRequest = false;
//var explorationDone = false;
var currentStressTestCount = 0;
var currentStressTestIndex = 0;
var currentStressTestGestureIndex = 0;
//var stressTestStartTriggered = false;
//var stressTestGestureTriggered = false;
//var stressTestQuestionsTriggered = false;
//var currentPhaseStepDone = false;
//var screenSharingStopped = false;

//var testerDoneTriggered = false;
var previewModeEnabled = false;

var currentTransitionSceneIndex = 0;
var currentGUSData = null;

var currentPhaseState = null;
var syncPhaseStep = false;

var webcamPreview = null;
var peerConnection = null;

var currentQuestionnaireAnswers = null;
var prototypeWindow = null;
var iceTransports = null;

//var helpScreensharingTriggered = false;

var USER_ROLE_MODERATOR = 'moderator';
var USER_ROLE_TESTER = 'tester';
var USER_ROLE_OBSERVER = 'observer';


function checkStorage() {
    if (isLocalStorageSupported()) {
        var phaseSteps = getContextualPhaseSteps();
        if (phaseSteps && phaseSteps.length > 0) {
            initialize();

            if (previewModeEnabled) {
                renderPhasesDropdown();
            }
        } else {
            console.warn('There are no phase steps');
        }
    } else {
        console.error("Sorry, your browser did not support Web Session Storage.");
    }
}

var uploadQueue = null;
function initialize() {
    var study = getLocalItem(STUDY);
    if (previewModeEnabled === true) {
        if (study.surveyType === TYPE_SURVEY_UNMODERATED) {
            currentView = VIEW_TESTER;
            showTesterView();
            $('#btnViewModerator').addClass('disabled');
        } else {
            if (currentView === VIEW_TESTER) {
                showTesterView();
            } else {
                showModeratorView();
            }
        }
    } else {
        uploadQueue = new UploadQueue();
        $(uploadQueue).unbind(EVENT_FILE_SAVED).bind(EVENT_FILE_SAVED, function (event, result) {
            var tempSaveData = getLocalItem(result.phaseStepId + '.tempSaveData');
            tempSaveData[result.type] = result.filename;
            setLocalItem(result.phaseStepId + '.tempSaveData', tempSaveData);

            var saveData = getLocalItem(result.phaseStepId + '.saveData');
            if (saveData) {
                saveData[result.type] = result.filename;
                setLocalItem(result.phaseStepId + '.saveData', saveData);
            }

            console.log('on file uploaded -> save data:', result, tempSaveData);

            savePhaseStep(result.phaseStepId, function () {
                var phases = getContextualPhaseSteps();
                if (currentPhaseStepIndex < phases.length - 1 && getCurrentPhase().format !== THANKS) {
                    saveCurrentStatus(false);
                } else {
                    checkRTCUploadStatus(getMainContent());
                }
            });
        });

        var study = getLocalItem(STUDY);
        study.aborted = 'no';
        setLocalItem(STUDY, study);

        getGMT(function (timestamp) {
            setLocalItem('startExecutionTime', timestamp);
            renderPhaseStep();
            updateProgress();
        });
    }

    $('.btn-cancel').click(function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            loadHTMLintoModal('custom-modal', 'externals/modal-cancel-execution.php', 'modal-sm');
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

function renderPhasesDropdown() {
    var phaseSteps = getContextualPhaseSteps();

    var dropdown = $('body').find('.phaseStepsSelect');
    $(dropdown).find('.option').empty();

    if (phaseSteps && phaseSteps.length > 0) {
        $(dropdown).find('.dropdown-toggle').removeClass('disabled');
        var listItem;

//        listItem = document.createElement('li');
//        listItem.setAttribute('id', STUDY_EXECUTION_PREPARATION);
//
//        var link = document.createElement('a');
//        link.setAttribute('href', '#');
//        link.appendChild(document.createTextNode('Starten der Durchführung'));
//        $(listItem).append(link);
//        $(dropdown).find('.option').append(listItem);
//
//        if (i === currentPhaseStepIndex) {
//            link.click();
//        }

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
    checkScreenSharingZombies($('#video-caller'));

    var phases = getContextualPhaseSteps();
    if (phases && phases.length > 0) {
        currentPhaseStepIndex = Math.max(currentPhaseStepIndex - 1, 0);
    }

    if (previewModeEnabled === true) {
        $('.phaseStepsSelect .dropdown-menu .selected').prev().click();
    }
}

function nextStep() {
    resetConstraints();
    if (currentView === VIEW_TESTER) {
        checkScreenSharingZombies($('#video-caller'));
        resetRecorder();
    }

    var phases = getContextualPhaseSteps();
    if (previewModeEnabled === false) {
//        if (currentView !== VIEW_OBSERVER) {
        if (currentPhaseStepIndex < phases.length - 1) {
            saveCurrentStatus(false, function () {
                checkIfStopRecordingNeeded(phases);
            });
        } else {
            checkIfStopRecordingNeeded(phases);
        }
//        } else {
//            checkIfStopRecordingNeeded(phases);
//        }
    } else {
        currentPhaseStepIndex = Math.min(currentPhaseStepIndex + 1, phases.length - 1);
        $('.phaseStepsSelect .dropdown-menu .selected').next().click();
    }
}

function checkIfStopRecordingNeeded(phases) {
    if (isUploadRecordingNeededForPhaseStep(getCurrentPhase())) {
        peerConnection.stopRecording(function () {
            console.log('recording stopped, now decrease and render phase step');
            currentPhaseStepIndex = Math.min(currentPhaseStepIndex + 1, phases.length - 1);
            renderPhaseStep();
            updateProgress();
        }, true);
    } else {
        console.log('no stop recording needed, render phase step now');
        currentPhaseStepIndex = Math.min(currentPhaseStepIndex + 1, phases.length - 1);
        renderPhaseStep();
        updateProgress();
    }
}

function resetConstraints() {
    $(window).unbind('keydown');
    $(window).unbind('keyup');

    currentPhaseState = null;

    questionnaireDone = false;
    testerDoneTriggered = false;

//    gestureTrainingStartTriggered = false;
//    trainingPrototypeOpened = false;
//    trainingTriggered = false;
//    trainingShowGesture = false;
    currentTrainingIndex = 0;
    currentTrainingRepeatCount = 0;

//    slideshowStartTriggered = false;
//    slideTriggered = false;
    currentSlideIndex = 0;
//    slideRestarted = false;
    slidesRestartCount = 0;
//    triggerSlideshowDone = false;

    scenarioStartTriggered = false;
    scenarioPrototypeOpened = false;
    triggeredHelp = null;
    triggeredFeedback = null;
//    triggeredWoz = null;
    currentWOZScene = null;
    currentScenarioTask = null;
    currentScenarioTaskIndex = 0;
//    scenarioDone = false;

    currentStressTestCount = 0;
    currentStressTestIndex = 0;
    currentStressTestGestureIndex = 0;
//    stressTestStartTriggered = false;
//    stressTestGestureTriggered = false;
//    stressTestQuestionsTriggered = false;

    currentIdentificationIndex = 0;
//    identificationTriggered = false;
//    identificationDone = false;
//    identificationStartTriggered = false;
//    identificationPrototypeOpened = false;
//    identificationSensorInitialized = false;
//    identificationRecordingStartTriggered = false;
//    identificationRecordingStopTriggered = false;
//    identificationTriggerRequest = false;
    currentIdentificationScene = 0;

//    explorationStartTriggered = false;
//    explorationShowGestures = false;
    currentExplorationIndex = 0;
    currentExplorationScene = 0;
//    explorationPreferredGesturesRequest = false;
//    explorationPrototypeOpened = false;
//    currentPresentGesture = null;
//    currentPresentGestureInfoClosed = false;

    singleGUSGesture = null;
    currentGUSData = null;
    currentTransitionSceneIndex = 0;

    currentQuestionnaireAnswers = null;
//    currentPhaseStepDone = false;
//    screenSharingStopped = false;

    currentQuestionIndex = 0;
    filterQuestionStack = [];

    if (gestureRecorder) {
        gestureRecorder.destroy();
        gestureRecorder = null;
    }

    if (prototypeWindow) {
        prototypeWindow.close();
        prototypeWindow = null;
    }
}

function rescueVideoCaller() {
    if (!previewModeEnabled && currentView === VIEW_TESTER) {
        $('#video-caller-holder').append($('#video-caller'));
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

function getSourceContainer(selector) {
    switch (selector) {
        case VIEW_MODERATOR:
            return $('#item-container-moderator');
        case VIEW_OBSERVER:
            return $('#item-container-observer');
        case VIEW_WIZARD:
            return $('#item-container-wizard');
        case VIEW_TESTER:
            return $('#item-container-tester');
    }
}

function getMainContent() {
    switch (currentView) {
        case VIEW_MODERATOR:
            return $('#viewModerator');
        case VIEW_OBSERVER:
            return $('#viewObserver');
        case VIEW_WIZARD:
            return $('#viewWizard');
        case VIEW_TESTER:
            return $('#viewTester');
    }
}

var draggable = null;
var resizable = false;
var resizing = false;
function dragRTC(opacity) {
    var video = $('#web-rtc-placeholder');
    if (previewModeEnabled !== true) {
        video = $(getMainContent()).find('#video-caller');
    }

    $(video).css({opacity: opacity ? opacity : .7, width: (DRAGGABLE_MIN_WIDTH + 100) + 'px', height: ((DRAGGABLE_MIN_WIDTH + 100) * 3 / 4) + 'px'});
    var toggleButton = $(video).find('#btn-toggle-rtc-fixed');
    $(toggleButton).removeClass('pinned');
    $(toggleButton).find('.fa').removeClass('fa-window-restore').addClass('fa-window-maximize');

    $(video).addClass('shadow');
    $('#draggableRTC').removeClass('hidden');
    $('.pinnedRTC').addClass('hidden');

    $(video).appendTo("#draggableRTC");
    $(video).find('#resize-sign').removeClass('hidden').css({zIndex: 1000});

    if (peerConnection) {
        peerConnection.keepStreamsPlaying();
    }

    TweenMax.to($('#phase-content #column-left'), .2, {css: {marginTop: 0, opacity: 1.0}});

    // check tester view 
    if (currentView === VIEW_TESTER) {
        var currentPhase = getCurrentPhase();
        $('#viewTester').find('#column-left').addClass('hidden');
        var originalColSpecs = $('#viewTester').find('#column-right').attr('data-original-col-specs');
        $('#viewTester').find('#column-right').removeClass(originalColSpecs).addClass('col-xs-12');

        switch (currentPhase.format) {
            case GESTURE_TRAINING:
            case SCENARIO:
            case EXPLORATION:
            case IDENTIFICATION:
            case FOCUS_GROUP_INTERVIEW:
                $('body').attr('scroll', 'no');
                break;
        }
    }

    $('#draggableRTC').unbind('mousemove').bind('mousemove', function (event) {
        var x = event.pageX - $(this).offset().left;
        var y = event.pageY - $(this).offset().top;

        if (!resizing) {
            if (x > this.scrollWidth - 20 && y > this.scrollHeight - 20) {
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
            $('body').addClass('readonly-without-mouse');

            if (resizable) {
                var newWidth = Math.min(Math.max(event.pageX - $('#draggableRTC').offset().left, DRAGGABLE_MIN_WIDTH), DRAGGABLE_MAX_WIDTH);
                $(video).css({width: newWidth + 'px', height: (newWidth * 3 / 4) + 'px'});
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

    $('#draggableRTC').unbind('mousedown').bind('mousedown', function (event) {
        draggable = {offsetLeft: event.pageX - $('#draggableRTC').offset().left, offsetTop: event.pageY - $('#draggableRTC').offset().top};
        if (resizable) {
            resizing = true;
            $('#draggableRTC').unbind('mouseleave');
        }
    });

    $(window).unbind('mouseup').bind('mouseup', function (event) {
        draggable = null;
        $('body').removeClass('readonly-without-mouse');

        if (resizable) {
            resizable = false;
            resizing = false;

            if (peerConnection) {
                peerConnection.checkRemoteStreamsPositions();
            }
        }
    });

    $('#draggableRTC').unbind('mouseleave').bind('mouseleave', function (event) {
        if (draggable) {
            event.stopImmediatePropagation();
        } else {
            event.preventDefault();
            if (!resizing) {
                draggable = null;
                resizable = false;
                showCursor($(this), CURSOR_AUTO);
            }
        }
    });

    if (peerConnection) {
        peerConnection.checkRemoteStreamsPositions();
    }
}

function pinRTC() {
    // check tester view 
    if (currentView === VIEW_TESTER) {
        var currentPhase = getCurrentPhase();
        $('#viewTester').find('#column-left').removeClass('hidden');
        var originalColSpecs = $('#viewTester').find('#column-right').attr('data-original-col-specs');
        $('#viewTester').find('#column-right').removeClass('col-xs-12').addClass(originalColSpecs);

        switch (currentPhase.format) {
            case GESTURE_TRAINING:
            case SCENARIO:
            case EXPLORATION:
            case IDENTIFICATION:
            case FOCUS_GROUP_INTERVIEW:
                $('body').attr('scroll', 'yes');
                break;
        }
    }

    var view = getMainContent();
    var video = $('#web-rtc-placeholder');
    if (previewModeEnabled !== true) {
        video = $('#video-caller');
    }

    $(video).css({opacity: 1});
    var toggleButton = $(video).find('#btn-toggle-rtc-fixed');
    $(toggleButton).addClass('pinned');
    $(toggleButton).find('.fa').removeClass('fa-window-maximize').addClass('fa-window-restore');

    $(video).find('#resize-sign').addClass('hidden');
    $(view).find('.pinnedRTC').removeClass('hidden');
    $('#draggableRTC').addClass('hidden');
    $(video).removeClass('shadow');
    $(video).appendTo($(view).find('.pinnedRTC'));
    $(document).scrollTop(0);

    $('#draggableRTC').css({top: 150, left: 50});
    if (peerConnection) {
        peerConnection.keepStreamsPlaying();
    }
//    else if(previewModeEnabled) {
//        console.log($(video).find('video'));
//        $(video).find('video')[0].play();
//    }

    resetRTC();
}

/*
 * show and hide stream functions for tester execution
 */

function hideStream() {
    dragRTC();
    $('#draggableRTC').addClass('hidden');

    var stream = $('#web-rtc-placeholder');
    if (previewModeEnabled !== true) {
        stream = $('#video-caller');
    }
    $(stream).addClass('hidden');
    $('#btn-show-stream').removeClass('hidden');
}

function showStream() {
    pinRTC();
    var stream = $('#web-rtc-placeholder');
    if (previewModeEnabled !== true) {
        stream = $('#video-caller');
    }
    console.log('show stream', stream);
    $(stream).removeClass('hidden');
    $('#btn-show-stream').addClass('hidden');
}

function showRecordIndicator() {
    console.log('show record indicator');
//    var showStreamButtonIcon = $('#btn-show-stream').find('.fa');
//    var showStreamButtonIcon = $('.record-stream-indicator');
//    TweenMax.to(showStreamButtonIcon, 1, {color: "#ff0000", opacity: 1, yoyo: true, repeat: -1});

    var indicator = $('.record-stream-indicator').removeClass('hidden');
    TweenMax.to(indicator, 1, {color: "#ff0000", opacity: 1, onComplete: function () {
            TweenMax.to(indicator, 1, {opacity: .2, yoyo: true, repeat: -1});
        }});
}

function hideRecordIndicator() {
    console.log('hide record indicator');
//    var showStreamButtonIcon = $('.record-stream-indicator');
//    TweenMax.to(showStreamButtonIcon, .3, {color: "#000000", opacity: 0});

    var indicator = $('.record-stream-indicator');
    TweenMax.to(indicator, .3, {opacity: 0, onComplete: function () {
            $(indicator).addClass('hidden');
        }});
}

function checkScreenSharingZombies(target) {
    if (previewModeEnabled === false) {
        var videos = $(target).find('video');
        for (var i = 0; i < videos.length; i++) {
            var id = $(videos[i]).attr('id');
            if (id !== undefined) {
                if (id.indexOf('screen') !== -1) {
                    console.log('remove video element: ', id);
                    $(videos[i]).remove();
                }
            }
        }
    }
}

function getWOZItemsForSceneId(data, sceneId) {
    if (data && data.length > 0) {
        var array = new Array();
        for (var i = 0; i < data.length; i++) {
            if (parseInt(data[i].transitionScenes[0].sceneId) === parseInt(sceneId)) {
                array.push(data[i]);
            }
        }
        return array;
    }
    return null;
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

function filterHelpDataForCurrentTask(data, taskId, sceneId) {
    if (data && data.length > 0) {
        var array = new Array();
        for (var i = 0; i < data.length; i++) {
            if (parseInt(taskId) === parseInt(data[i].taskId) && parseInt(data[i].sceneId) === parseInt(sceneId)) {
                array.push(data[i]);
            }
        }
        return array;
    }
    return null;
}


function areThereScenes(array) {
    if (array && array.length > 0) {
        for (var i = 0; i < array.length; i++) {
            if (array[i].transitionScenes && array[i].transitionScenes.length > 0) {
                return true;
            }
        }
    }
    return false;
}

function sensorTypeBanned(type) {
    var preparedSensors = getLocalItem('preparedSensors');
    if (preparedSensors && preparedSensors.length > 0) {
        for (var i = 0; i < preparedSensors.length; i++) {
            if (preparedSensors[i].type === type) {
                return preparedSensors[i].banned === 'true' || preparedSensors[i].banned === true;
            }
        }
    }
    return true;
}

function recognizeLeapGestures(data) {
    if (data && data.tasks && data.tasks.length > 0) {
        for (var i = 0; i < data.tasks.length; i++) {
            if (data.tasks[i].woz && data.tasks[i].woz.length > 0) {
                for (var j = 0; j < data.tasks[i].woz.length; j++) {
                    var gestureId = data.tasks[i].woz[j].gestureId;
                    var gesture = getGestureById(gestureId);
                    if (gesture.sensorData && gesture.sensorData !== null && gesture.sensorData.type === 'leap') {
                        return true;
                    }
                }
            }
        }
    }

    return false;
}

function attachSimulationRecording(data) {
    if (data && data.recordedGestureSimulation && data.recordedGestureSimulation.data) {
        var commitedData = data.recordedGestureSimulation.data;
        console.log('attach simulation recording', commitedData);
        if (commitedData && commitedData.track && commitedData.track.length > 0) {
            for (var i = 0; i < commitedData.track.length; i++) {
                if (commitedData.track[i].start === 'true' || commitedData.track[i].start === true) {
                    data.annotations.push({
                        id: data.annotations.length + i,
                        action: ACTION_START_PERFORM_GESTURE,
                        gestureId: commitedData.track[i].gestureId,
                        triggerId: commitedData.track[i].triggerId,
                        time: commitedData.track[i].timestampGMT
                    });
                }
            }

            console.log('temp annotations: ', data);
        }
    }

    return data;
}

function checkScreensharingHelp() {
    var prewiew = getLocalItem('preview');
    if (!prewiew || (prewiew && !prewiew.helpScreensharingTriggered) || (prewiew && prewiew.helpScreensharingTriggered && prewiew.helpScreensharingTriggered === false)) {
        loadHTMLintoModal('custom-modal', 'externals/modal-help-screen-sharing.php', 'modal-lg');
        setLocalItem('preview', {helpScreensharingTriggered: true});
    }
}