/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var resultsPlayer = null;
function RTCResultsPlayer(url, timelineData, evaluatorResults) {
    if (getBrowser() !== 'Safari') {
        resultsPlayer = $('#template-study-container').find('#rtc-video-result').clone().removeAttr('id');

        if (evaluatorResults && evaluatorResults.screenRecordUrl) {
            console.log('handle screen record url', evaluatorResults.screenRecordUrl);
            $(resultsPlayer).find('#screen-share-video-holder').removeClass('hidden');
            $(resultsPlayer).find('#video-holder').css({width:'30%'});

            $.get(UPLOADS + evaluatorResults.screenRecordUrl)
                    .fail(function () {
                        console.log('file does not exist: ' + UPLOADS + evaluatorResults.screenRecordUrl);
                        appendAlert(resultsPlayer, ALERT_RECORD_URL_INVALID);
                    })
                    .done(function () {
                        $(resultsPlayer).find('#screen-share-video-holder').attr('src', UPLOADS + evaluatorResults.screenRecordUrl);
                    });
        }


        var videoHolder = $(resultsPlayer).find('#video-holder');
        var fileExist = true;
        console.log('load video:', UPLOADS + url);
        $.get(UPLOADS + url)
                .fail(function () {
                    fileExist = false;
                    console.log('file does not exist: ' + UPLOADS + url);
                    appendAlert(resultsPlayer, ALERT_RECORD_URL_INVALID);
                });
//                .done(function () {
//                    console.log('file exist: ' + UPLOADS + url);
//                })


        if (fileExist) {
            initializeTimeline(timelineData);
            $(videoHolder).attr('src', UPLOADS + url);

            // Buttons
            var playButton = $(resultsPlayer).find('#btn-play-pause');
            var muteButton = $(resultsPlayer).find('#btn-mute');
            var fullScreenButton = $(resultsPlayer).find('#btn-full-screen');

            // Sliders
            var seekBar = $(resultsPlayer).find('#seek-bar');
            var volumeBar = $(resultsPlayer).find('#volume-bar');

            $(videoHolder).on('loadedmetadata', function () {
                // google chrome no-duration workaround
                if (videoHolder[0].duration === Infinity) {
                    console.log('duration is', videoHolder[0].duration);
                    resultsPlayer.find('#video-timeline').addClass('hidden');
                    resultsPlayer.find('#loader').removeClass('hidden');

                    var totalRecordingTime = getSeconds(timelineData.executionTime);
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

                    $(playButton).unbind('click').bind('click', function (event) {
                        event.preventDefault();
                        if (videoHolder[0].paused === true) {
                            // Play the video
                            videoHolder[0].play();

                            // Update the button to 'Pause'
//                            $(playButton).find('.fa').removeClass('fa-play').addClass('fa-pause');
                        } else {
                            // Pause the video
                            videoHolder[0].pause();

                            // Update the button to 'Play'
//                            $(playButton).find('.fa').removeClass('fa-pause').addClass('fa-play');
                        }
                    });

                    $(muteButton).unbind('click').bind('click', function (event) {
                        event.preventDefault();
                        console.log('on mute clicked');
                        if (videoHolder[0].muted === false) {
                            // Mute the video
                            videoHolder[0].muted = true;

                            // Update the button text
                            $(muteButton).find('.fa').removeClass('fa-volume-off').addClass('fa-volume-up');
                        } else {
                            // Unmute the video
                            videoHolder[0].muted = false;

                            // Update the button text
                            $(muteButton).find('.fa').removeClass('fa-volume-up').addClass('fa-volume-off');
                        }
                    });

                    $(videoHolder).on('pause', function () {
//                        console.log('on video pause');
                        $(playButton).find('.fa').removeClass('fa-pause').addClass('fa-play');

                    });

                    $(videoHolder).on('play', function () {
//                        console.log('on video play');
                        $(playButton).find('.fa').removeClass('fa-play').addClass('fa-pause');
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

            function showPlayer() {
                resultsPlayer.find('#video-timeline').removeClass('hidden');
                resultsPlayer.find('#loader').addClass('hidden');

                $(videoHolder).on('timeupdate', function () {
                    updateTimeline(this.currentTime);

//                    var value = (100 / this.duration) * this.currentTime;
                    var percent = this.currentTime / this.duration * 100;
                    $(seekBar).find('.progress-bar').css({width: percent + '%'});
                    // Update the slider value
//                    seekBar.value = value;
//                    console.log('timeupdate', value);
                });

//                // Pause the video when the slider handle is being dragged
//                $(seekBar).on('mousedown', function () {
//                    videoHolder[0].pause();
//                });
//
//                // Play the video when the slider handle is dropped
//                $(seekBar).on('mouseup', function () {
//                    videoHolder[0].play();
//                });
//
//                $(seekBar).on('change', function () {
//                    
//                    var time = videoHolder[0].duration * (seekBar.value / 100);
//                    console.log('seekbar changed', time);
//                    // Update the video time
//                    videoHolder[0].currentTime = time;
//                });

// seekbar operations

                $(seekBar).unbind('mousedown').bind('mousedown', function (event) {
                    event.preventDefault();
                    var video = videoHolder[0];
                    video.pause();
                    $(window).unbind('mousemove').bind('mousemove', function (event) {
                        var positionX = Math.max(0, Math.min(Math.round(event.pageX - $(seekBar).offset().left), $(seekBar).width()));

                        var time = video.duration * (positionX / $(seekBar).width());
                        video.currentTime = Math.min(time, video.duration - 0.0001);

                        var percent = video.currentTime / video.duration * 100;
                        $(seekBar).find('.progress-bar').css({width: percent + '%'});
                    });
                    $(window).on('mouseup', function () {
                        $(window).unbind('mouseup');
                        $(window).unbind('mousemove');
                        video.play();
                    });
                });

                $(seekBar).unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    var positionX = Math.abs(event.pageX - $(this).offset().left);
                    var video = videoHolder[0];
                    var time = video.duration * (positionX / $(this).width());
                    video.currentTime = time;
                });
            }

        }

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
            selectable: true
        };
        timeline.setOptions(options);
        timeline.addCustomTime(itemRange.min);
        timeline.moveTo(itemRange.min);
    } else {
        console.warn('no timeline data');
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
        case SCENARIO:
            array = getScenarioVisData(timelineData);
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
    var className = 'item-primary-full';

    if (timelineData.phaseResults.training && timelineData.phaseResults.training.length > 0) {
        for (var i = 0; i < timelineData.phaseResults.training.length; i++) {
            var gesture = getGestureById(timelineData.phaseResults.training[i].gestureId);
            if (gesture) {
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
        }
    }

    return array;
}

function getGestureSlideshowVisData(timelineData) {
//    console.log(timelineData);
    var array = new Array();
    var count = 0;
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.startRecordingTime)), className: 'invisible'});
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.endTime)), className: 'invisible'});
    var actions = timelineData.phaseResults.actions;

    if (actions) {
        for (var i = 0; i < actions.length; i++) {
            var className = 'item-primary-full';
            var gesture = null;
            var contentText = translation.actions[actions[i].action];

            if (actions[i].action === ACTION_SELECT_GESTURE) {
                gesture = getGestureById(actions[i].selectedGestureId);
                if (actions[i].fit === 'true') {
                    className = 'item-success-full';
                } else {
                    className = 'item-danger-full';
                    array.push({id: count++, content: translation.restart, start: new Date(parseInt(actions[i].time)), className: className});
                }
            } else if (actions[i].action === ACTION_NO_GESTURE_DEMONSTRATED || actions[i].action === ACTION_NO_GESTURE_FIT_FOUND) {
                className = 'item-warning-full';
                contentText = translation.actions[actions[i].action];
            } else {
                gesture = getGestureById(actions[i].gestureId);

            }

            if (gesture) {
                contentText += ': ' + gesture.title;
            }

            array.push({id: count++, content: contentText, start: new Date(parseInt(actions[i].time)), className: className});
        }
    }

    return array;
}

function getTriggerSlideshowVisData(timelineData) {
//    console.log(timelineData);
    var array = new Array();
    var count = 0;
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.startRecordingTime)), className: 'invisible'});
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.endTime)), className: 'invisible'});

    return array;
}

function getPhysicalStressTestVisData(timelineData) {
//    console.log(timelineData);

    var array = new Array();
    var count = 0;
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.startRecordingTime)), className: 'invisible'});
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.endTime)), className: 'invisible'});
    var actions = timelineData.phaseResults.actions;

    if (actions) {
        for (var i = 0; i < actions.length; i++) {
            var className = 'item-primary-full';
            var gesture = getGestureById(actions[i].gestureId);
            var contentText = translation.actions[actions[i].action] + ': ' + gesture.title;
            array.push({id: count++, content: contentText, start: new Date(parseInt(actions[i].time)), className: className});
        }
    }

    return array;
}

function getScenarioVisData(timelineData) {
    console.log(timelineData);
    var array = new Array();
    var count = 0;
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.startRecordingTime)), className: 'invisible'});
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.endTime)), className: 'invisible'});
    var actions = timelineData.phaseResults.actions;

    if (actions) {
        for (var i = 0; i < actions.length; i++) {
            var className = 'item-primary-full';
//            var gesture = getGestureById(actions[i].gestureId);
            var contentText = translation.actions[actions[i].action];
            array.push({id: count++, content: contentText, start: new Date(parseInt(actions[i].time)), className: className});
        }
    }

    return array;
}