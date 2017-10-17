/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var screenShareResultsPlayer = null;
function ScreenShareResultsPlayer(resultData) {
    if (getBrowser() !== 'Safari') {
        screenShareResultsPlayer = $('#template-study-container').find('#rtc-video-result').clone().removeAttr('id');
        var videoHolder = $(screenShareResultsPlayer).find('#video-holder');
        var fileExist = true;
        console.log('load video:', UPLOADS + resultData.screenRecordUrl);
        $.get(UPLOADS + resultData.screenRecordUrl)
                .fail(function () {
                    fileExist = false;
                    console.log('file does not exist: ' + UPLOADS + resultData.screenRecordUrl);
                    appendAlert(screenShareResultsPlayer, ALERT_RECORD_URL_INVALID);
                });
//                .done(function () {
//                    console.log('file exist: ' + UPLOADS + url);
//                })


        if (fileExist) {
            $(videoHolder).attr('src', UPLOADS + resultData.screenRecordUrl);

//            initializeTimeline(timelineData);

            $(videoHolder).on('loadedmetadata', function () {
                // google chrome no-duration workaround
                if (videoHolder[0].duration === Infinity) {
                    console.log('duration is', videoHolder[0].duration);
                    screenShareResultsPlayer.find('#video-timeline').addClass('hidden');
                    screenShareResultsPlayer.find('#loader').removeClass('hidden');

                    var executionTime = getTimeBetweenTimestamps(resultData.startScreenRecordingTime, resultData.endScreenRecordingTime);

                    var totalRecordingTime = getSeconds(executionTime);
                    console.log('totalRecordingTime:', totalRecordingTime);
                    videoHolder[0].currentTime = totalRecordingTime - 1;
                    videoHolder[0].playbackRate = 10;
                    videoHolder[0].muted = true;

                    $(videoHolder).on('ended', function () {
                        console.log('on ended');
                        $(videoHolder).unbind('ended');
                        videoHolder[0].playbackRate = 1;
                        videoHolder[0].muted = false;
                        videoHolder[0].currentTime = 0;

                        showPlayer();
                    });

                    $(videoHolder).on('pause', function () {
                        console.log('on video pause');
                    });

                    $(videoHolder).on('play', function () {
                        console.log('on video play');
                    });

//                    console.log(videoHolder[0].paused);
//                    if(videoHolder[0].paused) {
                    setTimeout(function () {
                        videoHolder[0].play();
                    }, 150);

//                    }

                } else {
                    showPlayer();
                }
            });

        }

        function showPlayer() {
            screenShareResultsPlayer.find('#video-timeline').removeClass('hidden');
            screenShareResultsPlayer.find('#loader').addClass('hidden');

//            $(videoHolder).on('timeupdate', function () {
//                updateTimeline(this.currentTime);
//            });
        }

        return screenShareResultsPlayer;
    }

    return null;
}

//var timeline, itemRange = null;
//function initializeTimeline(timelineData) {
//    if (timelineData) {
//        // Create a Timeline
//        timeline = new vis.Timeline($(screenShareResultsPlayer).find('#results-timeline')[0]);
//        timeline.setItems(getVisDataSet(timelineData));
//        itemRange = timeline.getItemRange();
//
//        var options = {
//            zoomable: false,
//            showCurrentTime: false,
//            orientation: 'top',
//            min: itemRange.min,
//            max: itemRange.max,
//            showMajorLabels: false,
//            showMinorLabels: false,
//            zoomMax: 10000,
//            selectable: true
//        };
//        timeline.setOptions(options);
//        timeline.addCustomTime(itemRange.min);
//        timeline.moveTo(itemRange.min);
//    } else {
//        console.warn('no timeline data');
//    }
//}
//
//function updateTimeline(currentTime) {
//    if (timeline) {
//        var min = new Date(itemRange.min);
//        min.setSeconds(min.getSeconds() + Math.ceil(Math.max(0, currentTime - 1)));
//        min.setMilliseconds(min.getMilliseconds() + Math.round(currentTime % 1 * 1000) - 300); // -600 because of the recording start lack
//
//        timeline.setCustomTime(min);
//        timeline.moveTo(min, {animation: false});
//    }
//}
//
//// Create a DataSet (allows two way data-binding)
//function getVisDataSet(timelineData) {
//    var array = {};
//    switch (timelineData.phaseResults.format) {
//        case GESTURE_TRAINING:
//            array = getGestureTrainingVisData(timelineData);
//            break;
//        case SLIDESHOW_GESTURES:
//            array = getGestureSlideshowVisData(timelineData);
//            break;
////        case SLIDESHOW_TRIGGER:
////            array = getTriggerSlideshowVisData(timelineData);
////            break;
//        case PHYSICAL_STRESS_TEST:
//            array = getPhysicalStressTestVisData(timelineData);
//            break;
//        case SCENARIO:
//            array = getScenarioVisData(timelineData);
//            break;
//    }
//    return new vis.DataSet(array);
//}
//
//function getGestureTrainingVisData(timelineData) {
//    console.log(timelineData);
//    var array = new Array();
//    var count = 0;
//    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.startRecordingTime)), className: 'invisible'});
//    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.endTime)), className: 'invisible'});
//    var className = 'item-primary-full';
//
//    if (timelineData.phaseResults.training && timelineData.phaseResults.training.length > 0) {
//        for (var i = 0; i < timelineData.phaseResults.training.length; i++) {
//            var gesture = getGestureById(timelineData.phaseResults.training[i].gestureId);
//            if (gesture) {
//                var startTime = timelineData.phaseResults.training[i].gestureTrainingStart;
//                var endTime = timelineData.phaseResults.training[i].gestureTrainingEnd;
//                var trainingExecution = getTimeBetweenTimestamps(startTime, endTime);
//                var contentText = translation.visLabels.training + ': ' + gesture.title + ' (' + getTimeString(trainingExecution) + ')';
//                if (startTime && endTime) {
//                    array.push({id: count++, content: contentText, start: new Date(parseInt(startTime)), end: new Date(parseInt(endTime)), className: className});
//                } else {
//                    array.push({id: count++, content: contentText, start: new Date(parseInt(startTime)), className: className});
//                }
//            }
//        }
//    }
//
//    return array;
//}
//
//function getGestureSlideshowVisData(timelineData) {
////    console.log(timelineData);
//    var array = new Array();
//    var count = 0;
//    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.startRecordingTime)), className: 'invisible'});
//    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.endTime)), className: 'invisible'});
//    var actions = timelineData.phaseResults.actions;
//
//    if (actions) {
//        for (var i = 0; i < actions.length; i++) {
//            var className = 'item-primary-full';
//            var gesture = null;
//            var contentText = translation.actions[actions[i].action];
//
//            if (actions[i].action === ACTION_SELECT_GESTURE) {
//                gesture = getGestureById(actions[i].selectedGestureId);
//                if (actions[i].fit === 'true') {
//                    className = 'item-success-full';
//                } else {
//                    className = 'item-danger-full';
//                    array.push({id: count++, content: translation.restart, start: new Date(parseInt(actions[i].time)), className: className});
//                }
//            } else if (actions[i].action === ACTION_NO_GESTURE_DEMONSTRATED || actions[i].action === ACTION_NO_GESTURE_FIT_FOUND) {
//                className = 'item-warning-full';
//                contentText = translation.actions[actions[i].action];
//            } else {
//                gesture = getGestureById(actions[i].gestureId);
//
//            }
//
//            if (gesture) {
//                contentText += ': ' + gesture.title;
//            }
//
//            array.push({id: count++, content: contentText, start: new Date(parseInt(actions[i].time)), className: className});
//        }
//    }
//
//    return array;
//}
//
//function getTriggerSlideshowVisData(timelineData) {
////    console.log(timelineData);
//    var array = new Array();
//    var count = 0;
//    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.startRecordingTime)), className: 'invisible'});
//    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.endTime)), className: 'invisible'});
//
//    return array;
//}
//
//function getPhysicalStressTestVisData(timelineData) {
////    console.log(timelineData);
//
//    var array = new Array();
//    var count = 0;
//    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.startRecordingTime)), className: 'invisible'});
//    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.endTime)), className: 'invisible'});
//    var actions = timelineData.phaseResults.actions;
//
//    if (actions) {
//        for (var i = 0; i < actions.length; i++) {
//            var className = 'item-primary-full';
//            var gesture = getGestureById(actions[i].gestureId);
//            var contentText = translation.actions[actions[i].action] + ': ' + gesture.title;
//            array.push({id: count++, content: contentText, start: new Date(parseInt(actions[i].time)), className: className});
//        }
//    }
//
//    return array;
//}
//
//function getScenarioVisData(timelineData) {
//    console.log(timelineData);
//    var array = new Array();
//    var count = 0;
//    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.startRecordingTime)), className: 'invisible'});
//    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.endTime)), className: 'invisible'});
//    var actions = timelineData.phaseResults.actions;
//
//    if (actions) {
//        for (var i = 0; i < actions.length; i++) {
//            var className = 'item-primary-full';
////            var gesture = getGestureById(actions[i].gestureId);
//            var contentText = translation.actions[actions[i].action];
//            array.push({id: count++, content: contentText, start: new Date(parseInt(actions[i].time)), className: className});
//        }
//    }
//
//    return array;
//}