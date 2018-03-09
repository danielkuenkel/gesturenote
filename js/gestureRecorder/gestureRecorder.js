/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var TYPE_RECORD_WEBCAM = 'webcam';
var TYPE_RECORD_LEAP = 'leap';

var GR_STATE_INITIALIZE = 'gr-initialize';
var GR_STATE_RECORD = 'gr-record';
var GR_STATE_PLAYBACK = 'gr-playback';
var GR_STATE_SAVE = 'gr-save';
var GR_STATE_SAVE_SUCCESS = 'gr-save-success';
var GR_STATE_DELETE = 'gr.delete';
var GR_STATE_DELETE_SUCCESS = 'gr-delete-success';

var GR_EVENT_SAVE_SUCCESS = 'gr-save-success';
var GR_EVENT_DELETE_SUCCESS = 'gr-delete-success';

var recorders = [];
var recorder = null;
GestureRecorder.prototype.state = null;
function GestureRecorder(options) {
    this.options = options;
    recorder = this;
    setState(GR_STATE_INITIALIZE);

    if (options.record && options.record.length > 0) {
        for (var i = 0; i < options.record.length; i++) {
            var recordType = options.record[i].type;
            switch (recordType) {
                case TYPE_RECORD_WEBCAM:
                    initWebcamRecorder();
                    break;
                case TYPE_RECORD_LEAP:
                    initSensorSwitch();
                    break;
            }
            initInstanceEvents();
        }
    } else {
        console.warn('There are no record options for this GestureRecorder delivered. Try option like record:[{type:"webcam"}]');
    }
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

function initWebcamRecorder() {
    var recorderObject = {type: TYPE_RECORD_WEBCAM, state: 'uninitialized'};
    var options = {
        parent: recorder.options.recorderTarget
    };
    var instance = new WebcamRecorder(options);
    recorderObject.instance = instance;
    recorders.push(recorderObject);
}

function initLeapRecorder() {
    var recorderObject = {type: TYPE_RECORD_LEAP, state: 'uninitialized'};
    var options = {
        parent: recorder.options.recorderTarget
    };
    var instance = new WebcamRecorder(options);
    recorderObject.instance = instance;
    recorders.push(recorderObject);
}

function initInstanceEvents() {
    if (recorders && recorders.length > 0) {
        for (var i = 0; i < recorders.length; i++) {
            if (recorders[i].instance && recorders[i].state !== 'ready') {
                $(recorders[i].instance).unbind('ready').bind('ready', onRecorderInstanceReady);
                $(recorders[i].instance).unbind('recordingStopped').bind('recordingStopped', onRecorderInstanceRecordingStopped);
            }
        }
    }
}

function onRecorderInstanceReady(event, type) {
    event.preventDefault();
    console.log('instance ready for recording', type);

    var instanceCount = 0;
    for (var i = 0; i < recorders.length; i++) {
        if (recorders[i].type === type) {
            recorders[i].state = 'ready';
            instanceCount++;
        }
    }

    if (instanceCount === recorders.length) {
        setState(GR_STATE_RECORD);
    } else {
        setState(GR_STATE_INITIALIZE);
    }
}

function initSensorSwitch() {
    $(recorder.options.recorderTarget).find('.useSensorSwitch').removeClass('hidden');
    $(recorder.options.recorderTarget).find('.useSensorSwitch').unbind('change').bind('change', function () {
        var sensor = $(this).find('.btn-option-checked').attr('id');
        switch (sensor) {
            case TYPE_RECORD_LEAP:
                initLeapRecorder();
                initInstanceEvents();
                break;
        }
    });
}

function setState(state) {
    recorder.state = state;
    switch (state) {
        case GR_STATE_INITIALIZE:
            renderStateInitialize();
            break;
        case GR_STATE_RECORD:
            renderStateRecord();
            break;
    }
}

function renderStateInitialize() {
    console.log('renderStateInitialize');
    $(recorder.options.recorderTarget).find('#btn-record').addClass('disabled');
}

var recordDurationTween = null;
function renderStateRecord() {
    console.log('renderStateRecord');
    $(recorder.options.recorderTarget).find('#btn-record').removeClass('disabled');

    $(recorder.options.recorderTarget).find('#btn-record').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(this).addClass('hidden');
            $(recorder.options.recorderTarget).find('#btn-record-stop').removeClass('hidden');
            $(recorder.options.recorderTarget).find('#record-timer-progress').removeClass('hidden');
            $(recorder.options.recorderTarget).find('#record-timer-progress-bar').css({width: '100%'});
            recordDurationTween = TweenMax.to($(recorder.options.recorderTarget).find('#record-timer-progress-bar'), 20, {width: '0%', ease: Linear.easeNone, onComplete: onRecordingTimesUp});
            record();
        }
    });

    $(recorder.options.recorderTarget).find('#btn-record-stop').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (recordDurationTween) {
            recordDurationTween.kill();
        }

        stopRecord();
    });

    function onRecordingTimesUp() {
        $(recorder.options.recorderTarget).find('#btn-record-stop').click();
    }
}

function record() {
    if (recorders && recorders.length > 0) {
        for (var i = 0; i < recorders.length; i++) {
            if (recorders[i].instance && recorders[i].state === 'ready') {
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
    console.log('instance recording stopped', type);

    var instanceCount = 0;
    for (var i = 0; i < recorders.length; i++) {
        if (recorders[i].type === type && recorders[i].state === 'recording') {
            recorders[i].state = 'ready';
            instanceCount++;
        }
    }

    if (instanceCount === recorders.length) {
        console.log('all recorders stopped recording');
//        setState(GR_STATE_RECORD);
    } else {
//        setState(GR_STATE_INITIALIZE);
    }
}