/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var TYPE_RECORD_WEBCAM = 'webcam';
var TYPE_RECORD_LEAP = 'leap';

var GR_STATE_PRE_INITIALIZE = 'gr-pre-initialize';
var GR_STATE_INITIALIZE = 'gr-initialize';
var GR_STATE_RECORD = 'gr-record';
var GR_STATE_PLAYBACK = 'gr-playback';
var GR_STATE_SAVE = 'gr-save';
var GR_STATE_SAVE_SUCCESS = 'gr-save-success';
var GR_STATE_DELETE_SUCCESS = 'gr-delete-success';

var GR_EVENT_SAVE_SUCCESS = 'gr-save-success';
var GR_EVENT_DELETE_SUCCESS = 'gr-delete-success';
var GR_EVENT_GESTURE_TOO_SHORT = 'gr-gesture-too-short';

var recorders = [];
var recorder = null;
GestureRecorder.prototype.state = null;
function GestureRecorder(options) {
    recorder = this;
    recorder.options = options;
    initRecorderEvents();
    setState(GR_STATE_PRE_INITIALIZE);
    initPopover();
}

GestureRecorder.prototype.destroy = function () {
    if (recorders.length > 0) {
        for (var i = 0; i < recorders.length; i++) {
            if (recorders[i].instance) {
                recorders[i].instance.destroy();
                recorders[i].instance = null;
            }
        }
        recorders = [];
    }
};

function getRecorderOptionsByType(type) {
    if (recorder.options.record && recorder.options.record.length > 0) {
        for (var i = 0; i < recorder.options.record.length; i++) {
            if (recorder.options.record[i].type === type) {
                return recorder.options.record[i];
            }
        }
    }
    return null;
}

GestureRecorder.prototype.currentRecorderContent = null;
GestureRecorder.prototype.currentInstructionContent = null;
function setState(state) {
    $(recorder.options.recorderTarget).find('.recorder-contents .recorder-content').addClass('hidden');
    $(recorder.options.recorderTarget).find('.instruction-contents .instruction-content').addClass('hidden');

    recorder.state = state;
    recorder.currentRecorderContent = $(recorder.options.recorderTarget).find('.recorder-contents .' + state);
    recorder.currentInstructionContent = $(recorder.options.recorderTarget).find('.instruction-contents .' + state);
    console.log('set state: ', state);
    switch (state) {
        case GR_STATE_PRE_INITIALIZE:
            renderStatePreInitialize();
            break;
        case GR_STATE_INITIALIZE:
            renderStateInitialize();
            break;
        case GR_STATE_RECORD:
            renderStateRecord();
            break;
        case GR_STATE_PLAYBACK:
            renderStatePlayback();
            break;
        case GR_STATE_SAVE:
            renderStateSave();
            break;
        case GR_STATE_SAVE_SUCCESS:
            renderStateSaveSuccess();
            break;
        case GR_STATE_DELETE_SUCCESS:
            renderStateDeleteSuccess();
            break;
    }

    $(recorder.options.recorderTarget).find('.recorder-contents .' + state).removeClass('hidden');
    $(recorder.options.recorderTarget).find('.instruction-contents .' + state).removeClass('hidden');
    updateRecorderNavigation();
}

function updateRecorderNavigation() {
    var navigation = $(recorder.options.recorderTarget).find('#gesture-recorder-nav');
    $(navigation).find('.btn-gesture-recorder-nav').parent().removeClass('active').addClass('disabled');

    switch (recorder.state) {
        case GR_STATE_PRE_INITIALIZE:
            $(navigation).find('[data-toggle-id="gr-pre-initialize"]').parent().removeClass('disabled');
            $(navigation).find('[data-toggle-id="gr-pre-initialize"]').parent().addClass('active');
            break;
        case GR_STATE_RECORD:
            $(navigation).find('[data-toggle-id="gr-pre-initialize"]').parent().removeClass('disabled');
            $(navigation).find('[data-toggle-id="gr-record"]').parent().removeClass('disabled');
            $(navigation).find('[data-toggle-id="gr-record"]').parent().addClass('active');
            break;
        case GR_STATE_PLAYBACK:
            $(navigation).find('[data-toggle-id="gr-pre-initialize"]').parent().removeClass('disabled');
            $(navigation).find('[data-toggle-id="gr-record"]').parent().removeClass('disabled');
            $(navigation).find('[data-toggle-id="gr-crop"]').parent().removeClass('disabled');
            $(navigation).find('[data-toggle-id="gr-crop"]').parent().addClass('active');
            break;
        case GR_STATE_SAVE:
            $(navigation).find('[data-toggle-id="gr-pre-initialize"]').parent().removeClass('disabled');
            $(navigation).find('[data-toggle-id="gr-record"]').parent().removeClass('disabled');
            $(navigation).find('[data-toggle-id="gr-crop"]').parent().removeClass('disabled');
            $(navigation).find('[data-toggle-id="gr-save"]').parent().removeClass('disabled');
            $(navigation).find('[data-toggle-id="gr-save"]').parent().addClass('active');
            break;
        case GR_STATE_SAVE_SUCCESS:
        case GR_STATE_DELETE_SUCCESS:
            $(navigation).find('[data-toggle-id="gr-record"]').parent().removeClass('disabled');
            break;
    }
}

function initRecorderEvents() {
    $(recorder.options.recorderTarget).find('.btn-repeat-recording').unbind('click').bind('click', function (event) {
        event.preventDefault();
        setState(GR_STATE_INITIALIZE);
    });

    $(recorder.options.recorderTarget).find('.btn-gesture-recorder-nav').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).parent().hasClass('disabled') && !$(this).parent().hasClass('active')) {
            var activeId = $(this).attr('data-toggle-id');
            switch (activeId) {
                case GR_STATE_PRE_INITIALIZE:
                    setState(GR_STATE_PRE_INITIALIZE);
                    break;
                case GR_STATE_RECORD:
                    setState(GR_STATE_INITIALIZE);
                    break;
                case GR_STATE_PLAYBACK:
                    setState(GR_STATE_PLAYBACK);
                    break;
            }
        }
    });
}





/*
 * initialize state functionalities
 */

function renderStatePreInitialize() {
    recorder.destroy();
    var initializeButton = $(recorder.currentRecorderContent).find('#btn-initialize-recorder');
    var webcamSwitch = $(recorder.currentRecorderContent).find('.useWebcamSwitch');
    var sensorSwitch = $(recorder.currentRecorderContent).find('.useSensorSwitch');

    $(webcamSwitch).unbind('change').bind('change', function (event) {
        event.preventDefault();
        checkInitButton();
    });

    $(sensorSwitch).unbind('change').bind('change', function (event) {
        event.preventDefault();
        checkInitButton();
    });

    $(initializeButton).unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            var webcamSource = $(webcamSwitch).find('.btn-option-checked').attr('id') === 'yes';
            var sensorSource = $(sensorSwitch).find('.btn-option-checked').attr('id');
            recorder.options.initRecorders = [];
            if (webcamSource) {
                var webcamOptions = getRecorderOptionsByType(TYPE_RECORD_WEBCAM);
                recorder.options.initRecorders.push({type: TYPE_RECORD_WEBCAM,
                    autoplayPlayback: webcamOptions.autoplayPlayback || false,
                    autoplaySave: webcamOptions.autoplaySave || false,
                    autoplaySaveSuccess: webcamOptions.autoplaySaveSuccess || false
                });
            }
            if (sensorSource !== 'none') {
                var sensorOptions = getRecorderOptionsByType(sensorSource);
                recorder.options.initRecorders.push({type: sensorSource,
                    autoplayPlayback: sensorOptions.autoplayPlayback || false,
                    autoplaySave: sensorOptions.autoplaySave || false,
                    autoplaySaveSuccess: sensorOptions.autoplaySaveSuccess || false
                });
            }
            setState(GR_STATE_INITIALIZE);
        }
    });

    function checkInitButton() {
        var webcamSource = $(webcamSwitch).find('.btn-option-checked').attr('id') === 'yes';
        var sensorSource = $(sensorSwitch).find('.btn-option-checked').attr('id') !== 'none';
        sensorSource || webcamSource ? $(initializeButton).removeClass('disabled') : $(initializeButton).addClass('disabled');
    }
    checkInitButton();
}





/*
 * initialize state functionalities
 */

function renderStateInitialize() {
    console.warn('init instance');
    recorder.destroy();

    if (recorder.options.initRecorders && recorder.options.initRecorders.length > 0) {
        for (var i = 0; i < recorder.options.initRecorders.length; i++) {
            var recordType = recorder.options.initRecorders[i].type;
            console.log('init: ', recordType);
            switch (recordType) {
                case TYPE_RECORD_WEBCAM:
                    initWebcamRecorder(recorder.options.initRecorders[i]);
                    break;
                case TYPE_RECORD_LEAP:
                    initLeapRecorder(recorder.options.initRecorders[i]);
                    break;
            }
            initInstanceEvents();
        }
    } else {
        console.warn('There are no recorder options for this GestureRecorder. Try option like: record:[{type:"webcam"}]');
    }

    $(recorder.options.recorderTarget).find('.gr-record #btn-record').addClass('disabled');
}

function initInstanceEvents() {
    if (recorders && recorders.length > 0) {
        for (var i = 0; i < recorders.length; i++) {
            if (recorders[i].instance && recorders[i].state !== 'ready') {
                $(recorders[i].instance).unbind('ready').bind('ready', onRecorderInstanceReady);
                $(recorders[i].instance).unbind('recordingStopped').bind('recordingStopped', onRecorderInstanceRecordingStopped);
                $(recorders[i].instance).unbind('playbackReady').bind('playbackReady', onRecorderInstancePlaybackReady);
                $(recorders[i].instance).unbind(GR_EVENT_GESTURE_TOO_SHORT).bind(GR_EVENT_GESTURE_TOO_SHORT, onRecorderInstanceGestureTooShort);
                $(recorders[i].instance).unbind('dataExtracted').bind('dataExtracted', onRecorderInstanceDataExtracted);
                $(recorders[i].instance).unbind('saveDataAttached').bind('saveDataAttached', onRecorderInstanceSaveDataAttached);
            }
        }
    }
}

function initWebcamRecorder(recorderOptions) {
    var recorderObject = {type: TYPE_RECORD_WEBCAM, state: 'uninitialized'};
    var options = {
        parent: recorder.options.recorderTarget,
        autoplayPlayback: recorderOptions.autoplayPlayback,
        autoplaySave: recorderOptions.autoplaySave,
        autoplaySaveSuccess: recorderOptions.autoplaySaveSuccess
    };
    var instance = new WebcamRecorder(options);
    recorderObject.instance = instance;
    recorders.push(recorderObject);
}

function initLeapRecorder(recorderOptions) {
    var recorderObject = {type: TYPE_RECORD_LEAP, state: 'uninitialized'};
    var options = {
        offset: {x: 0, y: 200, z: 0},
        previewOnly: false,
        pauseOnHands: false,
        autoplay: true,
        recordEmptyHands: true,
        parent: recorder.options.recorderTarget,
        autoplayPlayback: recorderOptions.autoplayPlayback,
        autoplaySave: recorderOptions.autoplaySave,
        autoplaySaveSuccess: recorderOptions.autoplaySaveSuccess
    };
    var instance = new LeapRecorder(options);
    recorderObject.instance = instance;
    recorders.push(recorderObject);

}

var instanceCount = 0;
function onRecorderInstanceReady(event, type) {
    event.preventDefault();
    console.log('on recorder instance ready: ', type);
    $(recorder.options.recorderTarget).find('.gr-record .sensor-source-record').addClass('hidden');

    for (var i = 0; i < recorders.length; i++) {
        if (recorders[i].type === type) {
            $(recorder.options.recorderTarget).find('.gr-record [data-sensor-source=' + type + ']').removeClass('hidden');
            $(recorder.options.recorderTarget).find('.gr-record [data-toggle-sensor=' + type + ']').removeClass('hidden');
            if (i === 0) {
                $(recorder.options.recorderTarget).find('.gr-record [data-toggle-sensor=' + type + ']').click();
            }
            recorders[i].state = 'initialized';
            instanceCount++;
        }
    }
    
    console.log(instanceCount, recorders.length);
    if (instanceCount === recorders.length) {
        console.log('all recorders ready for recording');
        instanceCount = 0;
        setState(GR_STATE_RECORD);
    } else {
//        setState(GR_STATE_INITIALIZE);
    }
    
    if (recorders.length > 1) {
        $(recorder.options.recorderTarget).find('.gr-record #toggle-gesture-recording-record-source').removeClass('hidden');
    }
}




/*
 * record state functionalities
 */

var recordDurationTween = null;
function renderStateRecord() {
    resetInputs(true);
    var recordButton = $(recorder.currentRecorderContent).find('#btn-record');
    var stopRecordButton = $(recorder.currentRecorderContent).find('#btn-record-stop');
    var timerProgress = $(recorder.options.recorderTarget).find('#record-timer-progress');
    var progressBar = $(recorder.currentRecorderContent).find('#record-timer-progress-bar');


    $(recordButton).unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(recordButton).hasClass('disabled')) {
            $(recordButton).addClass('hidden');
            $(stopRecordButton).removeClass('hidden');
            $(timerProgress).removeClass('hidden');
            $(progressBar).css({width: '100%'});
            recordDurationTween = TweenMax.to(progressBar, 20, {width: '0%', ease: Linear.easeNone, onComplete: onRecordingTimesUp});
            record();
        }
    });

    $(stopRecordButton).unbind('click').bind('click', function (event) {
        event.preventDefault();
        lockButton(stopRecordButton, true, 'fa-stop');
        if (recordDurationTween) {
            recordDurationTween.kill();
        }

        stopRecord();
    });

    function onRecordingTimesUp() {
        $(stopRecordButton).click();
    }
}

function record() {
    if (recorders && recorders.length > 0) {
        for (var i = 0; i < recorders.length; i++) {
            if (recorders[i].instance && recorders[i].state === 'initialized') {
                recorders[i].state = 'recording';
                recorders[i].instance.record();
            }
        }
    }
}

function stopRecord() {
    if (recorders && recorders.length > 0) {
        for (var i = 0; i < recorders.length; i++) {
            if (recorders[i].instance && recorders[i].state === 'recording') {
                recorders[i].instance.stopRecord();
            }
        }
    }
}

function onRecorderInstanceRecordingStopped(event, type) {
    event.preventDefault();

    for (var i = 0; i < recorders.length; i++) {
        if (recorders[i].type === type && recorders[i].state === 'recording') {
            recorders[i].state = 'recordingStopped';
            recorders[i].instance.playback();
            instanceCount++;
        }
    }

    if (instanceCount === recorders.length) {
        console.log('all recorders stopped recording');
        instanceCount = 0;
    }
}

function onRecorderInstancePlaybackReady(event, type) {
    event.preventDefault();
    $(recorder.options.recorderTarget).find('.gr-playback .sensor-source-preview').addClass('hidden');

    for (var i = 0; i < recorders.length; i++) {
        if (recorders[i].type === type && recorders[i].state === 'recordingStopped') {
            $(recorder.options.recorderTarget).find('.gr-playback [data-sensor-source=' + type + ']').removeClass('hidden');
            $(recorder.options.recorderTarget).find('.gr-playback [data-toggle-sensor=' + type + ']').removeClass('hidden');
            if (i === 0) {
                $(recorder.options.recorderTarget).find('.gr-playback [data-toggle-sensor=' + type + ']').click();
            }
            recorders[i].state = 'playback';

            instanceCount++;
        }
    }

    if (instanceCount === recorders.length) {
        console.log('all recorders ready for playback');
        instanceCount = 0;
        setState(GR_STATE_PLAYBACK);
    }

    if (recorders.length > 1) {
        $(recorder.options.recorderTarget).find('.gr-playback #toggle-gesture-recording-preview-source').removeClass('hidden');
    }
}






/*
 * playback state functionalities
 */

function renderStatePlayback() {
    resetInputs();
    var extractButton = $(recorder.currentRecorderContent).find('#btn-extract-gesture');

    $(extractButton).unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            clearAlerts($(recorder.options.recorderTarget));
            lockButton(extractButton, true, 'fa-arrow-right');

            for (var i = 0; i < recorders.length; i++) {
                if (recorders[i].state === 'playback' || recorders[i].state === 'saving') {
                    recorders[i].state = 'extracting';
                    recorders[i].instance.extract();
                }
            }
        }
    });
}

function onRecorderInstanceGestureTooShort(event, type) {
    event.preventDefault();
    console.log('stop extraction');
    for (var i = 0; i < recorders.length; i++) {
        if (recorders[i].state === 'extracting') {
            recorders[i].instance.stopExtraction();
            recorders[i].state = 'playback';
        }
    }

    setState(GR_STATE_PLAYBACK);
    appendAlert($(recorder.currentRecorderContent), ALERT_GESTURE_TOO_SHORT);
}

function onRecorderInstanceDataExtracted(event, type) {
    event.preventDefault();
    $(recorder.options.recorderTarget).find('.gr-save .sensor-source-save').addClass('hidden');

    for (var i = 0; i < recorders.length; i++) {
        if (recorders[i].type === type && recorders[i].state === 'extracting') {
            $(recorder.options.recorderTarget).find('.gr-save [data-sensor-source=' + type + ']').removeClass('hidden');
            $(recorder.options.recorderTarget).find('.gr-save [data-toggle-sensor=' + type + ']').removeClass('hidden');
            if (i === 0) {
                $(recorder.options.recorderTarget).find('.gr-save [data-toggle-sensor=' + type + ']').click();
            }
            recorders[i].state = 'saving';
            recorders[i].instance.showSave();
            instanceCount++;
        }
    }

    if (instanceCount === recorders.length) {
        console.log('all recorders extracted data successfully');
        instanceCount = 0;
        setState(GR_STATE_SAVE);
    }
}







/*
 * save state functionalities
 */

var gestureSaveData = null;
function renderStateSave() {
    resetInputs(true);
    var saveButton = $(recorder.currentRecorderContent).find('#btn-save-gesture');
    var titleInput = $(recorder.currentRecorderContent).find('#gestureName');
    var typeInput = $(recorder.currentRecorderContent).find('#gestureTypeSelect');
    var interactionTypeInput = $(recorder.currentRecorderContent).find('#gestureInteractionTypeSelect');
    var contextInput = $(recorder.currentRecorderContent).find('#gestureContext');
    var associationInput = $(recorder.currentRecorderContent).find('#gestureAssociation');
    var descriptionInput = $(recorder.currentRecorderContent).find('#gestureDescription');
    var jointsInput = $(recorder.currentRecorderContent).find('#gesture-save-form #human-body #joint-container');

//    $('#gestureName, #gestureContext, #gestureAssociation, #gestureDescription').unbind('input').bind('input', function () {
//        if (gestureInputsValid()) {
//            $(recorder.options.recorderTarget).find('.gr-save #btn-save-gesture').removeClass('disabled');
//        } else {
//            $(recorder.options.recorderTarget).find('.gr-save #btn-save-gesture').addClass('disabled');
//        }
//    });

    $(recorder.currentRecorderContent).find('#gesture-save-form').unbind('change').bind('change', function () {
        if (gestureInputsValid()) {
            $(saveButton).removeClass('disabled');
        } else {
            $(saveButton).addClass('disabled');
        }
    });

    $(saveButton).unbind('click').bind('click', function (event) {
        event.preventDefault();
        clearAlerts(recorder.currentRecorderContent);

        if (gestureInputsValid(true) && !$(this).hasClass('disabled')) {
            lockButton(saveButton, true, 'fa-floppy-o');

            var title = $(titleInput).val().trim();
            var type = recorder.options.checkType && recorder.options.checkType === true ? $(typeInput).find('.btn-option-checked').attr('id') : null;
            var interactionType = recorder.options.checkInteractionType && recorder.options.checkInteractionType === true ? $(interactionTypeInput).find('.btn-option-checked').attr('id') : null;
            var context = $(contextInput).val().trim();
            var association = $(associationInput).val().trim();
            var description = $(descriptionInput).val().trim();
            var joints = getSelectedJoints(jointsInput);
            var ownerId = recorder.options.ownerId || null;

            gestureSaveData = {
                title: title,
                type: type,
                interactionType: interactionType,
                context: context,
                association: association,
                description: description,
                joints: joints,
                ownerId: ownerId,
                images: null,
                previewImage: null,
                gif: null,
                sensorData: null
            };

            for (var i = 0; i < recorders.length; i++) {
                if (recorders[i].state === 'saving') {
                    recorders[i].instance.attachSaveData(true);
                }
            }
        }
    });

    function gestureInputsValid(showErrors) {
        var title = $(titleInput).val();
        if (title !== undefined && title.trim() === '') {
            if (showErrors) {
                appendAlert($(recorder.currentRecorderContent).find('#gesture-save-form'), ALERT_MISSING_FIELDS);
            } else {
                removeAlert($(recorder.currentRecorderContent).find('#gesture-save-form'), ALERT_MISSING_FIELDS);
            }
            return false;
        }

        if (recorder.options.checkType && recorder.options.checkType === true) {
            var type = $(typeInput).find('.btn-option-checked').attr('id');
            if (type === undefined) {
                if (showErrors) {
                    appendAlert($(recorder.currentRecorderContent).find('#gesture-save-form'), ALERT_MISSING_FIELDS);
                } else {
                    removeAlert($(recorder.currentRecorderContent).find('#gesture-save-form'), ALERT_MISSING_FIELDS);
                }
                return false;
            }
        }

        if (recorder.options.checkInteractionType && recorder.options.checkInteractionType === true) {
            var interactionType = $(interactionTypeInput).find('.btn-option-checked').attr('id');
            if (interactionType === undefined) {
                if (showErrors) {
                    appendAlert($(recorder.currentRecorderContent).find('#gesture-save-form'), ALERT_MISSING_FIELDS);
                } else {
                    removeAlert($(recorder.currentRecorderContent).find('#gesture-save-form'), ALERT_MISSING_FIELDS);
                }
                return false;
            }
        }

        var context = $(contextInput).val();
        if (context !== undefined && context.trim() === '') {
            if (showErrors) {
                appendAlert($(recorder.currentRecorderContent).find('#gesture-save-form'), ALERT_MISSING_FIELDS);
            } else {
                removeAlert($(recorder.currentRecorderContent).find('#gesture-save-form'), ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var association = $(associationInput).val();
        if (association !== undefined && association.trim() === '') {
            if (showErrors) {
                appendAlert($(recorder.currentRecorderContent).find('#gesture-save-form'), ALERT_MISSING_FIELDS);
            } else {
                removeAlert($(recorder.currentRecorderContent).find('#gesture-save-form'), ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var description = $(descriptionInput).val();
        if (description !== undefined && description.trim() === "") {
            if (showErrors) {
                appendAlert($(recorder.currentRecorderContent).find('#gesture-save-form'), ALERT_MISSING_FIELDS);
            } else {
                removeAlert($(recorder.currentRecorderContent).find('#gesture-save-form'), ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var selectedJoints = getSelectedJoints(jointsInput);
        if (selectedJoints.length === 0) {
            if (showErrors) {
                appendAlert($(recorder.currentRecorderContent).find('#gesture-save-form'), ALERT_MISSING_FIELDS);
            } else {
                removeAlert($(recorder.currentRecorderContent).find('#gesture-save-form'), ALERT_MISSING_FIELDS);
            }
            return false;
        }

        return true;
    }
}

function resetInputs(resetInputs) {
    clearAlerts($(recorder.options.recorderTarget));
    var repeatRecordingButton = $(recorder.options.recorderTarget).find('.btn-repeat-recording');
    unlockButton(repeatRecordingButton);

    // record inputs
    var recordButton = $(recorder.options.recorderTarget).find('.gr-record #btn-record');
    $(recordButton).removeClass('hidden disabled');

    var stopRecordButton = $(recorder.options.recorderTarget).find('.gr-record #btn-record-stop');
    $(stopRecordButton).addClass('hidden');
    unlockButton($(stopRecordButton), true, 'fa-stop');

    var timerProgress = $(recorder.options.recorderTarget).find('.gr-record #record-timer-progress');
    $(timerProgress).addClass('hidden');

    // playback inputs
    var extractButton = $(recorder.options.recorderTarget).find('#btn-extract-gesture');
    unlockButton(extractButton, true, 'fa-arrow-right');

    // save inputs
    var saveButton = $(recorder.options.recorderTarget).find('.gr-save #btn-save-gesture').addClass('disabled');
    unlockButton(saveButton, true, 'fa-floppy-o');
    if (resetInputs && resetInputs === true) {
        var titleInput = $(recorder.options.recorderTarget).find('.gr-save #gestureName');
        var contextInput = $(recorder.options.recorderTarget).find('.gr-save #gestureContext');
        var associationInput = $(recorder.options.recorderTarget).find('.gr-save #gestureAssociation');
        var descriptionInput = $(recorder.options.recorderTarget).find('.gr-save #gestureDescription');
        var jointsInput = $(recorder.options.recorderTarget).find('.gr-save #gesture-save-form #human-body #joint-container');

        $(titleInput).val('');
        $(contextInput).val('');
        $(associationInput).val('');
        $(descriptionInput).val('');
        $(jointsInput).children('.active').click();
        $(recorder.options.recorderTarget).find('.gr-save #btn-save-gesture').addClass('disabled');
    }

    // success save inputs
    var deleteButton = $(recorder.options.recorderTarget).find('.gr-save-success #btn-delete-saved-gesture');
    unlockButton(deleteButton, true, 'fa-trash');
}

function onRecorderInstanceSaveDataAttached(event, type, updateSaveData) {
    event.preventDefault();

    var saveGestureData = null;
    for (var i = 0; i < recorders.length; i++) {
        if (recorders[i].type === type && recorders[i].state === 'saving') {
            recorders[i].state = 'saveDataAttached';
            for (var key in updateSaveData) {
                if (updateSaveData.hasOwnProperty(key)) {
                    gestureSaveData[key] = updateSaveData[key];
                }
            }
            instanceCount++;
        }
    }

    if (instanceCount === recorders.length) {
        console.log('all recorders has data attached successfully');
        if (recorder.options.saveGesture && recorder.options.saveGesture === true) {
            saveGesture(saveGestureData);
        } else {
            setState(GR_STATE_SAVE_SUCCESS);
        }
    }
}

function saveGesture() {
    console.log('save gesture', gestureSaveData);
    saveRecordedGesture(gestureSaveData, function (result) {
        if (result.status === RESULT_SUCCESS) {
            resetInputs(true);
            gestureSaveData.id = result.gestureId;
            setState(GR_STATE_SAVE_SUCCESS);
        } else {
            resetInputs();
            appendAlert($(recorder.currentRecorderContent).find('.gr-save'), ALERT_GENERAL_ERROR);
        }
    });
}







/*
 * save success state functionalities
 */

function renderStateSaveSuccess() {
    resetInputs();
    appendAlert($(recorder.currentRecorderContent), ALERT_GESTURE_SAVE_SUCCESS);

    for (var i = 0; i < recorders.length; i++) {
        if (recorders[i].state === 'saveDataAttached') {
            $(recorder.currentRecorderContent).find('[data-sensor-source=' + recorders[i].type + ']').removeClass('hidden');
            $(recorder.currentRecorderContent).find('[data-toggle-sensor=' + recorders[i].type + ']').removeClass('hidden');
            if (i === 0) {
                $(recorder.currentRecorderContent).find('[data-toggle-sensor=' + recorders[i].type + ']').click();
            }
            recorders[i].state = 'saveSuccess';
            recorders[i].instance.showSaveSuccess(gestureSaveData);
        }
    }

    var deleteButton = $(recorder.currentRecorderContent).find('#btn-delete-saved-gesture');
    if (recorder.options.allowDeletingGesture === false) {
        $(deleteButton).addClass('hidden');
    } else {
        $(deleteButton).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                lockButton(deleteButton, true, 'fa-trash');

                deleteGesture({gestureId: gestureSaveData.id}, function (result) {
                    resetInputs();
                    if (result.status === RESULT_SUCCESS) {
                        setState(GR_STATE_DELETE_SUCCESS);
                    } else {
                        appendAlert($(recorder.currentRecorderContent), ALERT_GENERAL_ERROR);
                    }
                });
            }
        });
    }
}

function renderStateDeleteSuccess() {
    resetInputs();
    appendAlert($(recorder.currentRecorderContent), ALERT_GESTURE_DELETE_SUCCESS);
}