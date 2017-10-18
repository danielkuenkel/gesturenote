/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var resultsPlayer = null;
function RTCResultsPlayer(url, timelineData, evaluatorResults) {
    getTime('GMT', function (time) {
        // This is where you do whatever you want with the time:
        console.log(new Date(time).getTime());
    });

    if (getBrowser() !== 'Safari') {
        resultsPlayer = $('#template-study-container').find('#rtc-video-result').clone().removeAttr('id');
        evaluatorResults.recordUrl = url;

        var screenShareVideoHolder = null;
        var screenSharingStartGap, screenSharingEndGap = null;
        if (evaluatorResults && evaluatorResults.screenRecordUrl) {
            var screenRecordingFileExist = true;
            console.log('handle screen record url', evaluatorResults);
            $(resultsPlayer).find('#screen-share-video-container').removeClass('hidden');
            $(resultsPlayer).find('#webcam-video-container').css({marginTop: '10px'});

            $.get(UPLOADS + evaluatorResults.screenRecordUrl)
                    .fail(function () {
                        console.log('file does not exist: ' + UPLOADS + evaluatorResults.screenRecordUrl);
                        screenRecordingFileExist = false;
                        appendAlert(resultsPlayer, ALERT_RECORD_URL_INVALID);
                    });

            screenShareVideoHolder = $(resultsPlayer).find('#screen-share-video-holder');
            if (screenRecordingFileExist) {
                $(screenShareVideoHolder).attr('src', UPLOADS + evaluatorResults.screenRecordUrl);

                $(screenShareVideoHolder).on('loadedmetadata', function () {
                    // google chrome no-duration workaround
                    if (screenShareVideoHolder[0].duration === Infinity) {
                        var executionTime = getTimeBetweenTimestamps(evaluatorResults.startScreenRecordingTime, evaluatorResults.endScreenRecordingTime);
                        screenSharingStartGap = getSeconds(getTimeBetweenTimestamps(evaluatorResults.startScreenRecordingTime, evaluatorResults.startTime), true);
                        screenSharingEndGap = getSeconds(getTimeBetweenTimestamps(evaluatorResults.endScreenRecordingTime, evaluatorResults.endTime), true);
                        console.log(screenSharingStartGap, screenSharingEndGap);
                        var totalRecordingTime = getSeconds(executionTime);
                        console.log('total screen duration:', totalRecordingTime);
                        screenShareVideoHolder[0].currentTime = totalRecordingTime - 1;
                        screenShareVideoHolder[0].playbackRate = 10;
                        screenShareVideoHolder[0].muted = true;

                        $(screenShareVideoHolder).on('ended', function () {
                            console.log('on screen record ended');
                            $(screenShareVideoHolder).unbind('ended');
                            screenShareVideoHolder[0].playbackRate = 1;
                            screenShareVideoHolder[0].muted = false;
                            screenShareVideoHolder[0].currentTime = 0;
                            showScreenPlayer();
                        });

                        setTimeout(function () {
                            screenShareVideoHolder[0].play();
                        }, 150);
                    } else {
                        showScreenPlayer();
                    }
                });

                $(screenShareVideoHolder).unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    $(resultsPlayer).find('#btn-play-pause').click();
                });
            }
        }

        var moderatorVideoHolder = null;
        if (evaluatorResults && evaluatorResults.recordUrl) {
            var moderatorRecordingFileExist = true;
            console.log('handle moderator record url', evaluatorResults.recordUrl);
            $(resultsPlayer).find('#moderator-video-container').removeClass('hidden');

            $.get(UPLOADS + evaluatorResults.recordUrl)
                    .fail(function () {
                        console.log('file does not exist: ' + UPLOADS + evaluatorResults.recordUrl);
                        moderatorRecordingFileExist = false;
                        appendAlert(resultsPlayer, ALERT_RECORD_URL_INVALID);
                    });

            moderatorVideoHolder = $(resultsPlayer).find('#moderator-video-holder');
            if (moderatorRecordingFileExist) {
                $(moderatorVideoHolder).attr('src', UPLOADS + evaluatorResults.recordUrl);

                $(moderatorVideoHolder).on('loadedmetadata', function () {
                    // google chrome no-duration workaround
                    if (moderatorVideoHolder[0].duration === Infinity) {
                        var executionTime = getTimeBetweenTimestamps(evaluatorResults.startTime, evaluatorResults.endTime);
//                        screenSharingStartGap = getSeconds(getTimeBetweenTimestamps(evaluatorResults.startScreenRecordingTime, evaluatorResults.startTime), true);
//                        screenSharingEndGap = getSeconds(getTimeBetweenTimestamps(evaluatorResults.endScreenRecordingTime, evaluatorResults.endTime), true);
//                        console.log(screenSharingStartGap, screenSharingEndGap);
                        var totalRecordingTime = getSeconds(executionTime);
                        console.log('total moderator duration:', totalRecordingTime);
                        moderatorVideoHolder[0].currentTime = totalRecordingTime - 1;
                        moderatorVideoHolder[0].playbackRate = 10;
                        moderatorVideoHolder[0].muted = true;

                        $(moderatorVideoHolder).on('ended', function () {
                            console.log('on moderator record ended');
                            $(moderatorVideoHolder).unbind('ended');
                            moderatorVideoHolder[0].playbackRate = 1;
                            moderatorVideoHolder[0].muted = false;
                            moderatorVideoHolder[0].currentTime = 0;
                            showModeratorPlayer();
                        });

                        setTimeout(function () {
                            moderatorVideoHolder[0].play();
                        }, 150);
                    } else {
                        showModeratorPlayer();
                    }
                });

                $(moderatorVideoHolder).unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    $(resultsPlayer).find('#btn-play-pause').click();
                });
            }
        }

        var videoHolder = $(resultsPlayer).find('#tester-video-holder');
        var fileExist = true;
        console.log('load video:', UPLOADS + url);
        $.get(UPLOADS + url)
                .fail(function () {
                    fileExist = false;
                    console.log('file does not exist: ' + UPLOADS + url);
                    appendAlert(resultsPlayer, ALERT_RECORD_URL_INVALID);
                });

        if (fileExist) {
            initializeTimeline(timelineData);

            // Buttons
            var playButton = $(resultsPlayer).find('#btn-play-pause');
            var muteButton = $(resultsPlayer).find('#tester-video-container .btn-toggle-mute');
//            var fullScreenButton = $(resultsPlayer).find('#btn-full-screen');
            // Sliders
            var seekBar = $(resultsPlayer).find('#main-seek-bar');
//            var volumeBar = $(resultsPlayer).find('#volume-bar');

            $(videoHolder).attr('src', UPLOADS + url);
            $(videoHolder).on('loadedmetadata', function () {
                // google chrome no-duration workaround
                if (videoHolder[0].duration === Infinity) {
                    console.log('duration is', videoHolder[0].duration);
                    resultsPlayer.find('#video-timeline').addClass('hidden');
                    resultsPlayer.find('#loader').removeClass('hidden');
                    var totalRecordingTime = getSeconds(timelineData.executionTime);
                    console.log('total tester duration:', totalRecordingTime);
                    videoHolder[0].currentTime = totalRecordingTime - 1;
                    videoHolder[0].playbackRate = 10;
                    videoHolder[0].muted = true;

                    $(videoHolder).on('ended', function () {
                        console.log('on tester record ended');
                        $(videoHolder).unbind('ended');
                        videoHolder[0].playbackRate = 1;
                        videoHolder[0].muted = false;
                        videoHolder[0].currentTime = 0;
                        showPlayer();
                    });

                    $(playButton).unbind('click').bind('click', function (event) {
                        event.preventDefault();
                        if (videoHolder[0].paused === true) {
                            videoHolder[0].play();
                            if (moderatorVideoHolder) {
                                moderatorVideoHolder[0].play();
                            }
                        } else {
                            videoHolder[0].pause();
                            if (moderatorVideoHolder) {
                                moderatorVideoHolder[0].pause();
                            }
                        }
                    });

                    $(videoHolder).on('pause', function () {
                        $(playButton).find('.fa').removeClass('fa-pause').addClass('fa-play');
                    });

                    $(videoHolder).on('play', function () {
                        $(playButton).find('.fa').removeClass('fa-play').addClass('fa-pause');
                    });

                    setTimeout(function () {
                        videoHolder[0].play();
                    }, 150);
                } else {
                    showPlayer();
                }
            });

            $(videoHolder).unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(resultsPlayer).find('#btn-play-pause').click();
            });

            function showScreenPlayer() {
                $(resultsPlayer).find('#screen-share-video-container .video-time-code-duration').text(secondsToHms(screenShareVideoHolder[0].duration));
                $(screenShareVideoHolder).on('timeupdate', function () {
                    var percent = this.currentTime / this.duration * 100;
                    $(resultsPlayer).find('#screen-share-video-container .progress-bar').css({width: percent + '%'});
                    $(resultsPlayer).find('#screen-share-video-container .video-time-code-current-time').text(secondsToHms(this.currentTime));
                });
            }

            function showModeratorPlayer() {
                $(resultsPlayer).find('#moderator-video-container .video-time-code-duration').text(secondsToHms(moderatorVideoHolder[0].duration));
                $(moderatorVideoHolder).on('timeupdate', function () {
                    var percent = this.currentTime / this.duration * 100;
                    $(resultsPlayer).find('#moderator-video-container .progress-bar').css({width: percent + '%'});
                    $(resultsPlayer).find('#moderator-video-container .video-time-code-current-time').text(secondsToHms(this.currentTime));
                });
            }

            function showPlayer() {
                resultsPlayer.find('#video-timeline').removeClass('hidden');
                resultsPlayer.find('#loader').addClass('hidden');
                $(resultsPlayer).find('#tester-video-container .video-time-code-duration').text(secondsToHms(videoHolder[0].duration));

                $(videoHolder).on('timeupdate', function () {
                    updateTimeline(this.currentTime);
                    var percent = this.currentTime / this.duration * 100;
                    $(seekBar).find('.progress-bar').css({width: percent + '%'});
                    $(resultsPlayer).find('#tester-video-container .progress-bar').css({width: percent + '%'});
                    $(resultsPlayer).find('#tester-video-container .video-time-code-current-time').text(secondsToHms(this.currentTime));

                    if (screenShareVideoHolder !== null) {
//                        console.log(this.currentTime, this.duration - screenSharingEndGap);
                        if (this.currentTime > screenSharingStartGap && this.currentTime < this.duration - screenSharingEndGap) {
                            screenShareVideoHolder[0].currentTime = this.currentTime - screenSharingStartGap;
                        } else if (this.currentTime <= screenSharingStartGap) {
                            screenShareVideoHolder[0].currentTime = 0;
                        } else {
                            screenShareVideoHolder[0].currentTime = screenShareVideoHolder[0].duration;
                        }
                    }
                });

                $(seekBar).unbind('mousedown').bind('mousedown', function (event) {
                    event.preventDefault();
                    var video = videoHolder[0];
                    video.pause();

                    if (moderatorVideoHolder) {
                        moderatorVideoHolder[0].pause();
                    }

                    $(window).unbind('mousemove').bind('mousemove', function (event) {
                        var positionX = Math.max(0, Math.min(Math.round(event.pageX - $(seekBar).offset().left), $(seekBar).width()));
                        var time = video.duration * (positionX / $(seekBar).width());
                        video.currentTime = Math.min(time, video.duration - 0.0001);
                        var percent = video.currentTime / video.duration * 100;
                        $(seekBar).find('.progress-bar').css({width: percent + '%'});

                        if (moderatorVideoHolder) {
                            moderatorVideoHolder[0].currentTime = Math.min(time, moderatorVideoHolder[0].duration - 0.0001);
                        }
                    });

                    $(window).on('mouseup', function () {
                        $(window).unbind('mouseup');
                        $(window).unbind('mousemove');
                        video.play();

                        if (moderatorVideoHolder) {
                            moderatorVideoHolder[0].play();
                        }
                    });
                });

                $(seekBar).unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    var positionX = Math.abs(event.pageX - $(this).offset().left);
                    var video = videoHolder[0];
                    var time = video.duration * (positionX / $(this).width());
                    video.currentTime = time;

                    if (moderatorVideoHolder) {
                        moderatorVideoHolder[0].currentTime = time;
                    }
                });

                $(muteButton).unbind('click').bind('click', function (event) {
                    if (videoHolder[0].muted === true) {
                        muteButton.find('.fa').removeClass('fa-volume-off').addClass('fa-volume-up');
                        videoHolder[0].muted = false;
                    } else {
                        muteButton.find('.fa').removeClass('fa-volume-up').addClass('fa-volume-off');
                        videoHolder[0].muted = true;
                    }
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
        case EXPLORATION:
            array = getExplorationVisData(timelineData);
            break;
    }
    return new vis.DataSet(array);
}

function getGestureTrainingVisData(timelineData) {
    console.log('getGestureTrainingVisData', timelineData);
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
    console.log('getGestureSlideshowVisData', timelineData);
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
    console.log('getTriggerSlideshowVisData', timelineData);
    var array = new Array();
    var count = 0;
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.startRecordingTime)), className: 'invisible'});
    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.endTime)), className: 'invisible'});
    return array;
}

function getPhysicalStressTestVisData(timelineData) {
    console.log('getPhysicalStressTestVisData', timelineData);

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
    console.log('getScenarioVisData', timelineData);
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

function getExplorationVisData(timelineData) {
    console.log('getExplorationVisData', timelineData);
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