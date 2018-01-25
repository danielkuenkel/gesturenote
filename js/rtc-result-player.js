/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var resultsPlayer = null;
function RTCResultsPlayer(testerResults, evaluatorResults, phaseData, executionTime) {
//    getTime('GMT', function (time) {
//        // This is where you do whatever you want with the time:
//        console.log(new Date(time).getTime());
//    });
//    getGMT(function(timestamp) {
//        console.log('server time: ', timestamp);
//    });
    console.log('tester results:', testerResults);
    console.log('evaluator results:', evaluatorResults);
    console.log('phase data results:', phaseData);
    console.log('execution time:', executionTime);

    var screenSharingStartGap = 0;
    var screenSharingEndGap = 0;
    var videoCount = 0;
    var videosLoadedSuccessfully = 0;

    if (getBrowser() !== 'Safari') {
        resultsPlayer = $('#template-study-container').find('#rtc-video-result').clone().removeAttr('id');
        var playButton = $(resultsPlayer).find('#btn-play-pause');
        var seekBar = $(resultsPlayer).find('#main-seek-bar');

        var screenShareVideoHolder = null;
        var moderatorVideoHolder = null;
        var testerVideoHolder = null;

        resultsPlayer.find('#video-timeline').addClass('hidden');
        resultsPlayer.find('#loader').removeClass('hidden');

        if (evaluatorResults) {
            if (evaluatorResults.screenRecordUrl) {
                videoCount++;
                initScreenSharingVideoPlayer();
            }

            if (evaluatorResults.recordUrl) {
                videoCount++;
                initModeratorVideoPlayer();
            }
        }

        if (testerResults.recordUrl) {
            videoCount++;
            initTesterVideoPlayer();
        }

        function initScreenSharingVideoPlayer() {
            var screenRecordingFileExist = true;
            console.log('init screen sharing video player', evaluatorResults);

            $.get(UPLOADS + evaluatorResults.screenRecordUrl)
                    .fail(function () {
                        console.log('file does not exist: ' + UPLOADS + evaluatorResults.screenRecordUrl);
                        screenRecordingFileExist = false;
                        appendAlert(resultsPlayer, ALERT_RECORD_URL_INVALID);

                        resultsPlayer.find('#loader').addClass('hidden');
                        return false;
                    });

            screenShareVideoHolder = $(resultsPlayer).find('#screen-share-video-holder');
            if (screenRecordingFileExist) {
                $(screenShareVideoHolder).attr('src', UPLOADS + evaluatorResults.screenRecordUrl);

                $(screenShareVideoHolder).on('loadedmetadata', function () {
                    // google chrome no-duration workaround
                    if (screenShareVideoHolder[0].duration === Infinity) {
                        var duration = getSeconds(getTimeBetweenTimestamps(evaluatorResults.startScreenRecordingTime, evaluatorResults.endScreenRecordingTime), true);
                        if (!moderatorVideoHolder && testerVideoHolder) {
                            var participantsStartGap = getSeconds(getTimeBetweenTimestamps(evaluatorResults.startTime, testerResults.startTime), true);
                            if (evaluatorResults.startTime > testerResults.startTime) {
                                participantsStartGap *= -1;
                            }
                            screenSharingStartGap = getSeconds(getTimeBetweenTimestamps(evaluatorResults.startScreenRecordingTime, testerResults.startTime), true) + participantsStartGap;
                            screenSharingEndGap = getSeconds(getTimeBetweenTimestamps(evaluatorResults.endScreenRecordingTime, evaluatorResults.endTime), true) + participantsStartGap;
                        } else if (moderatorVideoHolder) {
                            screenSharingStartGap = getSeconds(getTimeBetweenTimestamps(evaluatorResults.startScreenRecordingTime, evaluatorResults.startTime), true);
                            screenSharingEndGap = getSeconds(getTimeBetweenTimestamps(evaluatorResults.endScreenRecordingTime, evaluatorResults.endTime), true);
                        }

                        console.log(screenSharingStartGap, screenSharingEndGap);
                        console.log('total screen duration:', duration);
                        screenShareVideoHolder[0].currentTime = duration - 2;
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

        function showScreenPlayer() {
            $(resultsPlayer).find('#screen-share-video-container').removeClass('hidden');
            $(resultsPlayer).find('#webcam-video-container').css({marginTop: '10px'});
            $(resultsPlayer).find('#screen-share-video-container .video-time-code-duration').text(secondsToHms(screenShareVideoHolder[0].duration));

            videosLoadedSuccessfully++;
            checkMainVideoPlayer();
        }



        function initModeratorVideoPlayer() {
            var moderatorRecordingFileExist = true;

            $.get(UPLOADS + evaluatorResults.recordUrl)
                    .fail(function () {
                        console.log('file does not exist: ' + UPLOADS + evaluatorResults.recordUrl);
                        moderatorRecordingFileExist = false;
                        appendAlert(resultsPlayer, ALERT_RECORD_URL_INVALID);

                        resultsPlayer.find('#loader').addClass('hidden');
                        return false;
                    });


            moderatorVideoHolder = $(resultsPlayer).find('#moderator-video-holder');
            if (moderatorRecordingFileExist) {
                $(moderatorVideoHolder).attr('src', UPLOADS + evaluatorResults.recordUrl);

                $(moderatorVideoHolder).on('loadedmetadata', function () {
                    // google chrome no-duration workaround
                    console.log(moderatorVideoHolder, $(resultsPlayer).find('#moderator-video-holder'));
                    if (moderatorVideoHolder[0].duration === Infinity) {
                        var duration = getSeconds(getTimeBetweenTimestamps(evaluatorResults.startRecordingTime, evaluatorResults.endRecordingTime), true);
//                        screenSharingStartGap = getSeconds(getTimeBetweenTimestamps(evaluatorResults.startScreenRecordingTime, evaluatorResults.startTime), true);
//                        screenSharingEndGap = getSeconds(getTimeBetweenTimestamps(evaluatorResults.endScreenRecordingTime, evaluatorResults.endTime), true);
//                        console.log(screenSharingStartGap, screenSharingEndGap);
                        console.log('total moderator duration:', duration);
                        moderatorVideoHolder[0].currentTime = duration - 2;
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
            }
        }

        function showModeratorPlayer() {
            $(resultsPlayer).find('#moderator-video-container').removeClass('hidden');
            $(resultsPlayer).find('#moderator-video-container .video-time-code-duration').text(secondsToHms(moderatorVideoHolder[0].duration));

            $(moderatorVideoHolder).unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(resultsPlayer).find('#btn-play-pause').click();
            });

            var muteButton = $(resultsPlayer).find('#moderator-video-container .btn-toggle-mute');
            $(muteButton).unbind('click').bind('click', function (event) {
                if (moderatorVideoHolder[0].muted === true) {
                    muteButton.find('.fa').removeClass('fa-volume-off').addClass('fa-volume-up');
                    moderatorVideoHolder[0].muted = false;
                } else {
                    muteButton.find('.fa').removeClass('fa-volume-up').addClass('fa-volume-off');
                    moderatorVideoHolder[0].muted = true;
                }
            });

            videosLoadedSuccessfully++;
            checkMainVideoPlayer();
        }

        function initTesterVideoPlayer() {
            var testerRecordingFileExist = true;

            $.get(UPLOADS + testerResults.recordUrl)
                    .fail(function () {
                        testerRecordingFileExist = false;
                        console.log('file does not exist: ' + UPLOADS + testerResults.recordUrl);
                        appendAlert(resultsPlayer, ALERT_RECORD_URL_INVALID);

                        resultsPlayer.find('#loader').addClass('hidden');
                        return false;
                    });


            testerVideoHolder = $(resultsPlayer).find('#tester-video-holder');
            if (testerRecordingFileExist) {
//                initializeTimeline(timelineData);

                $(testerVideoHolder).attr('src', UPLOADS + testerResults.recordUrl);
                $(testerVideoHolder).on('loadedmetadata', function () {
                    // google chrome no-duration workaround
                    if (testerVideoHolder[0].duration === Infinity) {
                        var duration = getSeconds(getTimeBetweenTimestamps(testerResults.startRecordingTime, testerResults.endRecordingTime), true);
                        console.log('total tester duration:', duration);
                        testerVideoHolder[0].currentTime = duration - 2;
                        testerVideoHolder[0].playbackRate = 10;
                        testerVideoHolder[0].muted = true;

                        $(testerVideoHolder).on('ended', function () {
                            console.log('on tester record ended');
                            $(testerVideoHolder).unbind('ended');
                            testerVideoHolder[0].playbackRate = 1;
                            testerVideoHolder[0].muted = false;
                            testerVideoHolder[0].currentTime = 0;
                            showTesterPlayer();
                        });

                        setTimeout(function () {
                            testerVideoHolder[0].play();
                        }, 150);
                    } else {
                        showTesterPlayer();
                    }
                });
            }
        }

        function showTesterPlayer() {
            $(resultsPlayer).find('#tester-video-container').removeClass('hidden');
            $(resultsPlayer).find('#tester-video-container .video-time-code-duration').text(secondsToHms(testerVideoHolder[0].duration));

            $(testerVideoHolder).unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(resultsPlayer).find('#btn-play-pause').click();
            });

            var muteButton = $(resultsPlayer).find('#tester-video-container .btn-toggle-mute');
            $(muteButton).unbind('click').bind('click', function (event) {
                if (testerVideoHolder[0].muted === true) {
                    muteButton.find('.fa').removeClass('fa-volume-off').addClass('fa-volume-up');
                    testerVideoHolder[0].muted = false;
                } else {
                    muteButton.find('.fa').removeClass('fa-volume-up').addClass('fa-volume-off');
                    testerVideoHolder[0].muted = true;
                }
            });

            videosLoadedSuccessfully++;
            checkMainVideoPlayer();
        }

        function checkMainVideoPlayer() {
            if (videosLoadedSuccessfully >= videoCount) {
                var checkedVideos = getMainVideoPlayer();
                var mainVideo = null;
                var secondVideo = null;
                var gap = null;

                if (checkedVideos) {
                    mainVideo = checkedVideos.mainVideo;
                    secondVideo = checkedVideos.secondVideo;
                    gap = checkedVideos.gap;
                } else {
                    return false;
                }

                if (mainVideo) {
                    resultsPlayer.find('#video-timeline').removeClass('hidden');
                    resultsPlayer.find('#loader').addClass('hidden');

                    var timelineData = secondVideo ? {phaseData: phaseData, phaseResults: evaluatorResults, executionTime: executionTime} : {phaseData: phaseData, phaseResults: testerResults, executionTime: executionTime}
                    initializeTimeline(timelineData);

                    $(mainVideo).unbind('timeupdate').bind('timeupdate', function () {
                        updateTimeline(this.currentTime + 2);

                        var percent = this.currentTime / this.duration * 100;
                        $(seekBar).find('.progress-bar').css({width: percent + '%'});
                        $(mainVideo).parent().find('.progress-bar').css({width: percent + '%'});
                        $(mainVideo).parent().find('.video-time-code-current-time').text(secondsToHms(this.currentTime));

                        if (secondVideo) {
                            var secondPercent = secondVideo[0].currentTime / secondVideo[0].duration * 100;
                            $(secondVideo).parent().find('.progress-bar').css({width: secondPercent + '%'});
                            $(secondVideo).parent().find('.video-time-code-current-time').text(secondsToHms(secondVideo[0].currentTime));
                        }

                        updateScreenRecord();
                    });

                    $(seekBar).unbind('mousedown').bind('mousedown', function (event) {
                        event.preventDefault();
                        var resumePlaying = true;
                        var video = mainVideo[0];
                        if (video.paused === true) {
                            resumePlaying = false;
                        }
                        video.pause();

                        if (secondVideo) {
                            secondVideo[0].pause();
                        }

                        $(window).unbind('mousemove').bind('mousemove', function (event) {
                            var positionX = Math.max(0, Math.min(Math.round(event.pageX - $(seekBar).offset().left), $(seekBar).width()));
                            var time = video.duration * (positionX / $(seekBar).width());
                            video.currentTime = Math.min(time, video.duration - 0.0001);
                            var percent = video.currentTime / video.duration * 100;
                            $(seekBar).find('.progress-bar').css({width: percent + '%'});
                            $(mainVideo).parent().find('.progress-bar').css({width: percent + '%'});
                            $(mainVideo).parent().find('.video-time-code-current-time').text(secondsToHms(video.currentTime));
                            readGapInput();
                        });

                        $(window).on('mouseup', function (event) {
                            $(window).unbind('mouseup');
                            $(window).unbind('mousemove');

                            var positionX = Math.abs(event.pageX - $(seekBar).offset().left);
                            var time = video.duration * (positionX / $(seekBar).width());
                            var currentTime = Math.min(time, video.duration - 0.0001);
                            video.currentTime = currentTime;

                            var percent = currentTime / video.duration * 100;
                            $(mainVideo).parent().find('.progress-bar').css({width: percent + '%'});
                            $(mainVideo).parent().find('.video-time-code-current-time').text(secondsToHms(currentTime));

                            if (secondVideo) {
                                readGapInput();
                                var isPlayingValid = secondVideo[0].currentTime < secondVideo[0].duration;
                                if (isPlayingValid && resumePlaying === true) {
                                    secondVideo[0].play();
                                }
                            }

                            if (resumePlaying === true) {
                                console.log('resume playing');
                                video.play();
                            }
                        });
                    });

                    $(seekBar).unbind('click').bind('click', function (event) {
                        event.preventDefault();
//                        var resumeAfterClick = true;
                        var video = mainVideo[0];
//                        if (video.paused === true) {
////                        video.pause();
//                            resumeAfterClick = false;
//                        }

//                        if (secondVideo) {
//                            secondVideo[0].pause();
//                        }

                        var positionX = Math.abs(event.pageX - $(this).offset().left);
                        var video = mainVideo[0];
                        var time = video.duration * (positionX / $(this).width());
                        video.currentTime = time;
                        readGapInput();

                        var percent = video.currentTime / video.duration * 100;
                        $(seekBar).find('.progress-bar').css({width: percent + '%'});

//                        if (resumeAfterClick === true && video.paused === true) {
//                        video.play();
////                        }
//
//                        if (secondVideo) {
//                            secondVideo[0].play();
//                        }
                    });

                    $(playButton).unbind('click').bind('click', function (event) {
                        event.preventDefault();
                        var video = mainVideo[0];
                        if (video.paused === true) {
                            video.play();
                        } else {
                            video.pause();
                        }

                        if (secondVideo) {
//                            readGapInput();
                            if (secondVideo[0].paused === true) {
                                secondVideo[0].play();
                            } else {
                                secondVideo[0].pause();
                            }
                        }
                    });

                    $(mainVideo).unbind('pause').bind('pause', function () {
                        $(playButton).find('.fa').removeClass('fa-pause').addClass('fa-play');
                    });

                    $(mainVideo).unbind('play').bind('play', function () {
                        $(playButton).find('.fa').removeClass('fa-play').addClass('fa-pause');
                    });

                    if (gap) {
                        if (secondVideo && gap.start >= 0) {
                            secondVideo[0].currentTime = gap.start;
                        } else if (mainVideo && secondVideo) {
                            mainVideo[0].currentTime = gap.start * -1;
                        }

                        $(resultsPlayer).find('#video-controls #gap-input').val(gap.start);

                        $(resultsPlayer).find('#btn-lock-unlock-gap-input').unbind('click').bind('click', function (event) {
                            event.preventDefault();
                            if ($(this).find('.fa').hasClass('fa-pencil')) {
                                if (mainVideo[0].paused === false) {
                                    $(playButton).click();
                                }

                                $(this).find('.fa').removeClass('fa-pencil').addClass('fa-check');
                                $(this).addClass('btn-success');
                                $(resultsPlayer).find('#gap-input').removeAttr('readonly');

                                $(resultsPlayer).find('#gap-input').bind('change input', function (event) {
                                    readGapInput();
                                });
                            } else {
                                $(this).find('.fa').removeClass('fa-check').addClass('fa-pencil');
                                $(this).removeClass('btn-success');
                                $(resultsPlayer).find('#gap-input').attr('readonly', 'true');
                                $(resultsPlayer).find('#gap-input').unbind('change input');
                                readGapInput();
                            }
                        });
                    }
                } else {
                    console.warn('no main video player');
                }

                function readGapInput() {
                    var gapInput = parseFloat($(resultsPlayer).find('#video-controls #gap-input').val());
                    if (isFinite(gapInput)) {
                        if (secondVideo) {
                            if (gapInput < 0 && mainVideo[0].currentTime < gapInput * -1) {
                                mainVideo[0].currentTime = mainVideo[0].currentTime + gapInput * -1;
                            } else {
                                secondVideo[0].currentTime = Math.max(0, Math.min(mainVideo[0].duration, mainVideo[0].currentTime + gapInput));
                            }

                            var percent = secondVideo[0].currentTime / secondVideo[0].duration * 100;
                            $(secondVideo).parent().find('.progress-bar').css({width: percent + '%'});
                            $(secondVideo).parent().find('.video-time-code-current-time').text(secondsToHms(secondVideo[0].currentTime));
                        }
                    } else {
                        $(resultsPlayer).find('#video-controls #gap-input').val(0.00);
                    }
                }

                function updateScreenRecord() {
                    if (screenShareVideoHolder !== null) {
                        var screenVideo = screenShareVideoHolder[0];
//                        console.log(this.currentTime, screenShareVideoHolder[0].duration + screenSharingGap.start);
                        if (mainVideo[0].currentTime > screenSharingStartGap && mainVideo[0].currentTime < screenSharingStartGap + screenVideo.duration) {
                            screenVideo.currentTime = mainVideo[0].currentTime - screenSharingStartGap;
//                            if (playScreenRecord) {
//                                screenShareVideoHolder[0].play();
//                            }
                        } else if (mainVideo[0].currentTime <= screenSharingStartGap) {
                            screenVideo.currentTime = 0;
                        } else {
                            screenVideo.currentTime = screenVideo.duration;
                        }

                        var percent = screenVideo.currentTime / screenVideo.duration * 100;
                        $(resultsPlayer).find('#screen-share-video-container .progress-bar').css({width: percent + '%'});
                        $(resultsPlayer).find('#screen-share-video-container .video-time-code-current-time').text(secondsToHms(screenVideo.currentTime));
                    }
                }
            }
        }

        function getMainVideoPlayer() {
            if (screenShareVideoHolder) {
                if (moderatorVideoHolder && testerVideoHolder) {
                    var start = getSeconds(getTimeBetweenTimestamps(evaluatorResults.startRecordingTime, testerResults.startRecordingTime), true);
                    var end = getSeconds(getTimeBetweenTimestamps(evaluatorResults.endRecordingTime, testerResults.endRecordingTime), true);

                    if (evaluatorResults.startRecordingTime < testerResults.startRecordingTime) {
                        start *= -1;
                    }
                    console.log('webcam gap: ', start, end);

                    return {mainVideo: moderatorVideoHolder, secondVideo: testerVideoHolder, gap: {start: start, end: end}};
                } else if (moderatorVideoHolder && !testerVideoHolder) {
                    return {mainVideo: moderatorVideoHolder, secondVideo: null, gap: null};
                } else if (testerVideoHolder) {
                    return {mainVideo: testerVideoHolder, secondVideo: null, gap: null};
                }
            } else if (!screenShareVideoHolder && moderatorVideoHolder && testerVideoHolder) {
                var start = getSeconds(getTimeBetweenTimestamps(evaluatorResults.startRecordingTime, testerResults.startRecordingTime), true);
                var end = getSeconds(getTimeBetweenTimestamps(evaluatorResults.endRecordingTime, testerResults.endRecordingTime), true);

                if (evaluatorResults.startRecordingTime < testerResults.startRecordingTime) {
                    start *= -1;
                }
                console.log('webcam gap: ', start, end);

                return {mainVideo: moderatorVideoHolder, secondVideo: testerVideoHolder, gap: {start: start, end: end}};
            } else {
                $(resultsPlayer).find('#gap-input-container').remove();
                $(resultsPlayer).find('#seek-bar-container').removeClass('col-xs-7 col-sm-8 col-lg-9').addClass('col-xs-10 col-lg-11');
                return {mainVideo: testerVideoHolder, secondVideo: null, gap: null};
            }

            return null;
        }

        return resultsPlayer;
    }

    return null;
}

var timeline, itemRange = null;
function initializeTimeline(timelineData) {
    if (timelineData) {
        // Create a Timeline
        var data = getVisDataSet(timelineData);
        if (data && data.length > 2) {
            timeline = new vis.Timeline($(resultsPlayer).find('#results-timeline')[0]);
            timeline.setItems(data);
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
            console.warn('no timeline data extracted');
            $(resultsPlayer).find('#results-timeline').remove();
        }
    } else {
        console.warn('no timeline data');
        $(resultsPlayer).find('#results-timeline').remove();
    }
}

function updateTimeline(currentTime) {
    if (timeline && itemRange) {
        var min = new Date(itemRange.min);
        min.setSeconds(min.getSeconds() + Math.ceil(Math.max(0, currentTime)));
        min.setMilliseconds(min.getMilliseconds() + Math.round(currentTime % 1 * 1000) - 300); // -300 because of the recording start lack
        timeline.setCustomTime(min);
        timeline.moveTo(min, {animation: false});
    }
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

    var actions = timelineData.phaseResults.actions;
    if (actions) {
        for (var i = 0; i < actions.length; i++) {
            var className = 'item-primary-full';
            var contentText = translation.actions[actions[i].action];
            array.push({id: count++, content: contentText, start: new Date(parseInt(actions[i].time)), className: className});
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

//function getTriggerSlideshowVisData(timelineData) {
//    console.log('getTriggerSlideshowVisData', timelineData);
//    var array = new Array();
//    var count = 0;
//    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.startRecordingTime)), className: 'invisible'});
//    array.push({id: count++, start: new Date(parseInt(timelineData.phaseResults.endTime)), className: 'invisible'});
//    return array;
//}

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