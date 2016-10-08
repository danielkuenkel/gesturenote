/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var resultsPlayer = null;
function RTCResultsPlayer(url, timelineData) {
    if (getBrowser() !== 'Safari') {
        resultsPlayer = $('#template-study-container').find('#rtc-video-result').clone().removeAttr('id');
        var videoHolder = $(resultsPlayer).find('#video-holder');
        $(videoHolder).attr('src', UPLOADS + url);

        initializeTimeline(timelineData);

        $(videoHolder).on('loadedmetadata', function () {
            // google chrome no-duration workaround
            if (videoHolder[0].duration === Infinity) {
                var totalRecordingTime = getSeconds(timelineData.executionTime);
                videoHolder[0].currentTime = totalRecordingTime - 2;
                videoHolder[0].playbackRate = 3;
                videoHolder[0].muted = true;
                $(videoHolder).on('ended', function () {
                    $(videoHolder).unbind('ended');
                    videoHolder[0].playbackRate = 1;
                    videoHolder[0].muted = false;
                    videoHolder[0].currentTime = 0;
                });
                videoHolder[0].play();
            }
        });
        $(videoHolder).on('timeupdate', function () {
            updateTimeline(this.currentTime);
        });

        return resultsPlayer;
    }

    return null;
}

var timeline, itemRange = null;
function initializeTimeline(timelineData) {
    if (timelineData) {
        // Create a Timeline
        timeline = new vis.Timeline($(resultsPlayer).find('#results-timeline')[0]);
        timeline.setItems(getVisDataSet(timelineData));
        itemRange = timeline.getItemRange();

        var options = {
            zoomable: false,
            showCurrentTime: false,
            orientation: 'top',
            min: itemRange.min,
            max: itemRange.max,
            showMajorLabels: false,
            showMinorLabels: false,
            zoomMax: 10000,
            selectable: false
        };
        timeline.setOptions(options);
        timeline.addCustomTime(itemRange.min);
        timeline.moveTo(itemRange.min);
    }
}

function updateTimeline(currentTime) {
    var min = new Date(itemRange.min);
    min.setSeconds(min.getSeconds() + Math.ceil(Math.max(0, currentTime - 1)));
    min.setMilliseconds(min.getMilliseconds() + Math.round(currentTime % 1 * 1000) - 300); // -600 because of the recording start lack
    timeline.setCustomTime(min);
    timeline.moveTo(min, {animation: false});
}

// Create a DataSet (allows two way data-binding)
function getVisDataSet(timelineData) {
    var array = {};
    switch (timelineData.phaseResults.format) {
        case GESTURE_TRAINING:
            array = getGestureTrainingVisData(timelineData);
            break;
        case SLIDESHOW_GESTURES:
            array = getGestureSlideshowVisData(timelineData);
            break;
//        case SLIDESHOW_TRIGGER:
//            array = getTriggerSlideshowVisData(timelineData);
//            break;
        case PHYSICAL_STRESS_TEST:
            array = getPhysicalStressTestVisData(timelineData);
            break;
    }
    return new vis.DataSet(array);
}

function getGestureTrainingVisData(timelineData) {
    console.log(timelineData);
    var array = new Array();
    var count = 0;
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.startRecordingTime)), className: 'invisible'});
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.endTime)), className: 'invisible'});
    var className = 'standard-action-full';

    for (var i = 0; i < timelineData.phaseResults.training.length; i++) {
        var gesture = getGestureById(timelineData.phaseResults.training[i].gestureId);
        var startTime = timelineData.phaseResults.training[i].gestureTrainingStart;
        var endTime = timelineData.phaseResults.training[i].gestureTrainingEnd;
        var trainingExecution = getTimeBetweenTimestamps(startTime, endTime);
        var contentText = translation.visLabels.training + ': ' + gesture.title + ' (' + getTimeString(trainingExecution) + ')';
        if (startTime && endTime) {
            array.push({id: count++, content: contentText, start: new Date(parseInt(startTime)), end: new Date(parseInt(endTime)), className: className});
        } else {
            array.push({id: count++, content: contentText, start: new Date(parseInt(startTime)), className: className});
        }
    }

    return array;
}

function getGestureSlideshowVisData(timelineData) {
    console.log(timelineData);
    var array = new Array();
    var count = 0;
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.startRecordingTime)), className: 'invisible'});
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.endTime)), className: 'invisible'});
    var actions = timelineData.phaseResults.actions;

    if (actions) {
        for (var i = 0; i < actions.length; i++) {
            var className = 'standard-action-full';
            var gesture = null;
            if (actions[i].action === ACTION_SELECT_GESTURE) {
                gesture = getGestureById(actions[i].selectedGestureId);
                if (actions[i].fit === 'true') {
                    className = 'correct-selected-gesture-full';
                } else {
                    className = 'wrong-selected-gesture-full';
                    array.push({id: count++, content: translation.restart, start: new Date(parseInt(actions[i].time)), className: className});
                }
            } else {
                gesture = getGestureById(actions[i].gestureId);
            }
//            var trigger = getTriggerById(actions[i].triggerId);
            var contentText = translation.actions[actions[i].action] + ': ' + gesture.title;
            array.push({id: count++, content: contentText, start: new Date(parseInt(actions[i].time)), className: className});
        }
    }

    return array;
}

function getTriggerSlideshowVisData(timelineData) {
    console.log(timelineData);
    var array = new Array();
    var count = 0;
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.startRecordingTime)), className: 'invisible'});
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.endTime)), className: 'invisible'});

    return array;
}

function getPhysicalStressTestVisData(timelineData) {
    console.log(timelineData);

    var array = new Array();
    var count = 0;
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.startRecordingTime)), className: 'invisible'});
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.endTime)), className: 'invisible'});
    var actions = timelineData.phaseResults.actions;

    if (actions) {
        for (var i = 0; i < actions.length; i++) {
            var className = 'standard-action-full';
            var gesture = getGestureById(actions[i].gestureId);
//            var trigger = getTriggerById(actions[i].triggerId);
            var contentText = translation.actions[actions[i].action] + ': ' + gesture.title;
            array.push({id: count++, content: contentText, start: new Date(parseInt(actions[i].time)), className: className});
        }
    }

    return array;
}