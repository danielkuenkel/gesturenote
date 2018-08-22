/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var resultsPlayer, player = null;
function RTCResultsPlayer(testerResults, evaluatorResults, phaseData, executionTime, content) {
//    getTime('GMT', function (time) {
//        // This is where you do whatever you want with the time:
//        console.log(new Date(time).getTime());
//    });
//    getGMT(function(timestamp) {
//        console.log('server time: ', timestamp);
//    });
//    console.log('tester results:', testerResults);
//    console.log('evaluator results:', evaluatorResults);
//    console.log('phase data results:', phaseData);
//    console.log('execution time:', executionTime);

    var screenSharingStartGap = 0;
    var screenSharingEndGap = 0;
    var videoCount = 0;
    var videosLoadedSuccessfully = 0;
    player = this;

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




        // screen share video player

        function initScreenSharingVideoPlayer() {
            var screenRecordingFileExist = true;

            $.get(UPLOADS + evaluatorResults.screenRecordUrl)
                    .fail(function () {
                        console.warn('file does not exist: ' + UPLOADS + evaluatorResults.screenRecordUrl);
                        screenRecordingFileExist = false;
                        appendAlert(resultsPlayer, ALERT_RECORD_URL_INVALID);

                        $(resultsPlayer).find('#loader').addClass('hidden');
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

                        console.log('total screen duration:', duration);
                        screenShareVideoHolder[0].currentTime = duration - 2;
                        screenShareVideoHolder[0].playbackRate = 10;
                        screenShareVideoHolder[0].muted = true;

                        $(screenShareVideoHolder).on('ended', function () {
                            $(screenShareVideoHolder).unbind('ended');
                            screenShareVideoHolder[0].playbackRate = 1;
                            screenShareVideoHolder[0].muted = false;
                            screenShareVideoHolder[0].currentTime = 0;
                            showScreenPlayer();
                        });

                        setTimeout(function () {
                            screenSharePlayPromise = screenShareVideoHolder[0].play();
                        }, 150);
                    } else {
                        showScreenPlayer();
                    }
                });

                $(screenShareVideoHolder).parent().find('#toggle-shrink-videos').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    $(this).popover('hide');
                    if ($(this).hasClass('shrinked')) {
                        $(this).removeClass('shrinked');
                        $(this).find('.fa').removeClass('fa-window-close-o').addClass('fa-window-maximize');
                        $(this).closest('#video-timeline').find('#webcam-video-container').removeClass('shrinked');
                        $(this).closest('#video-timeline').find('#webcam-video-container #tester-video-container').removeClass('shrinked');
                        $(this).closest('#video-timeline').find('#webcam-video-container #moderator-video-container').removeClass('shrinked');
                        $(this).attr('data-content', translation.overlapVideos);
                    } else {
                        $(this).addClass('shrinked');
                        $(this).find('.fa').removeClass('fa-window-maximize').addClass('fa-window-close-o');
                        $(this).closest('#video-timeline').find('#webcam-video-container').addClass('shrinked');
                        $(this).closest('#video-timeline').find('#webcam-video-container #tester-video-container').addClass('shrinked');
                        $(this).closest('#video-timeline').find('#webcam-video-container #moderator-video-container').addClass('shrinked');
                        $(this).attr('data-content', translation.singleVideos);
                    }
                });
            }
        }

        function showScreenPlayer() {
            $(resultsPlayer.domElement).find('#screen-share-video-container').removeClass('hidden');
            $(resultsPlayer.domElement).find('#webcam-video-container').css({marginTop: '10px'});
            $(resultsPlayer.domElement).find('#screen-share-video-container .video-time-code-duration').text(secondsToHms(screenShareVideoHolder[0].duration));

            $(screenShareVideoHolder).unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(resultsPlayer.domElement).find('#btn-play-pause').click();
            });

            videosLoadedSuccessfully++;
            checkMainVideoPlayer();
        }




        // moderator video player 

        function initModeratorVideoPlayer() {
            var moderatorRecordingFileExist = true;

            $.get(UPLOADS + evaluatorResults.recordUrl)
                    .fail(function () {
                        console.warn('file does not exist: ' + UPLOADS + evaluatorResults.recordUrl);
                        moderatorRecordingFileExist = false;
                        appendAlert(resultsPlayer, ALERT_RECORD_URL_INVALID);

                        $(resultsPlayer).find('#loader').addClass('hidden');
                        return false;
                    });


            moderatorVideoHolder = $(resultsPlayer).find('#moderator-video-holder');
            if (moderatorRecordingFileExist) {
                $(moderatorVideoHolder).attr('src', UPLOADS + evaluatorResults.recordUrl);

                $(moderatorVideoHolder).on('loadedmetadata', function () {
                    // google chrome no-duration workaround
                    if (moderatorVideoHolder[0].duration === Infinity) {
                        var duration = getSeconds(getTimeBetweenTimestamps(evaluatorResults.startRecordingTime || evaluatorResults.startTime, evaluatorResults.endRecordingTime || evaluatorResults.endTime), true);
                        console.log('total moderator duration:', duration);
                        moderatorVideoHolder[0].currentTime = duration - 2;
                        moderatorVideoHolder[0].playbackRate = 10;
                        moderatorVideoHolder[0].muted = true;

                        $(moderatorVideoHolder).on('ended', function () {
                            $(moderatorVideoHolder).unbind('ended');
                            moderatorVideoHolder[0].playbackRate = 1;
                            moderatorVideoHolder[0].muted = false;
                            moderatorVideoHolder[0].currentTime = 0;
                            showModeratorPlayer();
                        });

                        setTimeout(function () {
                            moderatorPlayPromise = moderatorVideoHolder[0].play();
                        }, 150);
                    } else {
                        showModeratorPlayer();
                    }
                });
            }
        }

        function showModeratorPlayer() {
            $(resultsPlayer.domElement).find('#moderator-video-container').removeClass('hidden');
            $(resultsPlayer.domElement).find('#moderator-video-container .video-time-code-duration').text(secondsToHms(moderatorVideoHolder[0].duration));

            $(moderatorVideoHolder).unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(resultsPlayer.domElement).find('#btn-play-pause').click();
            });

            var muteButton = $(resultsPlayer.domElement).find('#moderator-video-container .btn-toggle-mute');
            $(muteButton).unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(muteButton).popover('hide');
                if (moderatorVideoHolder[0].muted === true) {
                    muteButton.find('.fa').removeClass('fa-volume-off').addClass('fa-volume-up');
                    moderatorVideoHolder[0].muted = false;
                    $(muteButton).attr('data-content', translation.turnOffAudio);
                } else {
                    muteButton.find('.fa').removeClass('fa-volume-up').addClass('fa-volume-off');
                    moderatorVideoHolder[0].muted = true;
                    $(muteButton).attr('data-content', translation.turnOnAudio);
                }
            });

            videosLoadedSuccessfully++;
            checkMainVideoPlayer();
        }




        // tester video player

        function initTesterVideoPlayer() {
            var testerRecordingFileExist = true;

            $.get(UPLOADS + testerResults.recordUrl)
                    .fail(function () {
                        testerRecordingFileExist = false;
                        console.warn('file does not exist: ' + UPLOADS + testerResults.recordUrl);
                        appendAlert(resultsPlayer, ALERT_RECORD_URL_INVALID);

                        $(resultsPlayer).find('#loader').addClass('hidden');
                        return false;
                    });


            testerVideoHolder = $(resultsPlayer).find('#tester-video-holder');
            if (testerRecordingFileExist) {

                $(testerVideoHolder).attr('src', UPLOADS + testerResults.recordUrl);
                $(testerVideoHolder).on('loadedmetadata', function () {
                    // google chrome no-duration workaround
                    if (testerVideoHolder[0].duration === Infinity) {
                        var duration = getSeconds(getTimeBetweenTimestamps(testerResults.startRecordingTime || testerResults.startTime, testerResults.endRecordingTime || testerResults.endTime), true);
                        console.log('total tester duration:', duration);
                        testerVideoHolder[0].currentTime = duration - 2;
                        testerVideoHolder[0].playbackRate = 10;
                        testerVideoHolder[0].muted = true;

                        $(testerVideoHolder).on('ended', function () {
                            $(testerVideoHolder).unbind('ended');
                            testerVideoHolder[0].playbackRate = 1;
                            testerVideoHolder[0].muted = false;
                            testerVideoHolder[0].currentTime = 0;
                            showTesterPlayer();
                        });

                        setTimeout(function () {
                            testerPlayPromise = testerVideoHolder[0].play();
                        }, 150);
                    } else {
                        showTesterPlayer();
                    }
                });
            }
        }

        function showTesterPlayer() {
            $(resultsPlayer.domElement).find('#tester-video-container').removeClass('hidden');
            $(resultsPlayer.domElement).find('#tester-video-container .video-time-code-duration').text(secondsToHms(testerVideoHolder[0].duration));

            $(testerVideoHolder).unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(resultsPlayer.domElement).find('#btn-play-pause').click();
            });

            var muteButton = $(resultsPlayer.domElement).find('#tester-video-container .btn-toggle-mute');
            $(muteButton).unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(muteButton).popover('hide');
                if (testerVideoHolder[0].muted === true) {
                    muteButton.find('.fa').removeClass('fa-volume-off').addClass('fa-volume-up');
                    testerVideoHolder[0].muted = false;
                    $(muteButton).attr('data-content', translation.turnOffAudio);
                } else {
                    muteButton.find('.fa').removeClass('fa-volume-up').addClass('fa-volume-off');
                    testerVideoHolder[0].muted = true;
                    $(muteButton).attr('data-content', translation.turnOnAudio);
                }
            });

            videosLoadedSuccessfully++;
            checkMainVideoPlayer();
        }




        // main video player functionalitities

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
                    $(resultsPlayer.domElement).find('#video-timeline').removeClass('hidden');
                    $(resultsPlayer.domElement).find('#loader').addClass('hidden');

                    if (!secondVideo) {
                        $(mainVideo).parent().removeClass('col-xs-6').addClass('col-xs-12');
                    }

                    $(mainVideo).unbind('timeupdate').bind('timeupdate', function () {
                        updateTimeline(this.currentTime, content);
                        updateLinkList(this.currentTime, content);

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

                    $(mainVideo).unbind('jumpTo').bind('jumpTo', function (event, jumpTo) {
                        event.preventDefault();
                        var video = mainVideo[0];
                        video.currentTime = Math.min(jumpTo, video.duration - 0.0001);
                        readGapInput();
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
                                video.play();
                            }
                        });
                    });

//                    $(seekBar).unbind('click').bind('click', function (event) {
//                        event.preventDefault();
//                        var video = mainVideo[0];
//
//                        var positionX = Math.abs(event.pageX - $(this).offset().left);
//                        var video = mainVideo[0];
//                        var time = video.duration * (positionX / $(this).width());
//                        video.currentTime = time;
//                        readGapInput();
//
//                        var percent = video.currentTime / video.duration * 100;
//                        $(seekBar).find('.progress-bar').css({width: percent + '%'});
//                    });

                    $(playButton).unbind('click').bind('click', function (event) {
                        event.preventDefault();

                        var video = mainVideo[0];
                        if (video.ended === true) {
                            video.currentTime = 0;
                            if (secondVideo && secondVideo[0].paused === false) {
                                secondVideo[0].pause();
                            }
                            readGapInput();
                        }

                        video.paused === true ? video.play() : video.pause();

                        if (secondVideo) {
                            secondVideo[0].paused === true ? secondVideo[0].play() : secondVideo[0].pause();
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

                        $(resultsPlayer.domElement).find('#video-controls #gap-input').val(gap.start);

                        $(resultsPlayer.domElement).find('#btn-lock-unlock-gap-input').unbind('click').bind('click', function (event) {
                            event.preventDefault();
                            if ($(this).find('.fa').hasClass('fa-pencil')) {
                                if (mainVideo[0].paused === false) {
                                    $(playButton).click();
                                }

                                $(this).find('.fa').removeClass('fa-pencil').addClass('fa-check');
                                $(this).addClass('btn-success');
                                $(resultsPlayer.domElement).find('#gap-input').removeAttr('readonly');

                                $(resultsPlayer.domElement).find('#gap-input').bind('change input', function (event) {
                                    readGapInput();
                                });
                            } else {
                                $(this).find('.fa').removeClass('fa-check').addClass('fa-pencil');
                                $(this).removeClass('btn-success');
                                $(resultsPlayer.domElement).find('#gap-input').attr('readonly', 'true');
                                $(resultsPlayer.domElement).find('#gap-input').unbind('change input');
                                readGapInput();
                            }
                        });
                    }

                    var timelineData = secondVideo ? {phaseData: phaseData, phaseResults: evaluatorResults, resultSource: 'evaluator', executionTime: executionTime, duration: getTimeBetweenTimestamps(evaluatorResults.startRecordingTime || evaluatorResults.startTime, evaluatorResults.endRecordingTime || evaluatorResults.endTime), checkedVideos: checkedVideos} : {phaseData: phaseData, phaseResults: testerResults, resultSource: 'results', executionTime: executionTime, duration: getTimeBetweenTimestamps(testerResults.startRecordingTime || testerResults.startTime, testerResults.endRecordingTime || testerResults.endTime), checkedVideos: checkedVideos};
                    initializeTimeline(timelineData, content);
                    initializeAnnotationHandling(timelineData, content);
                } else {
                    console.warn('no main video player');
                }

                function readGapInput() {
                    var gapInput = parseFloat($(resultsPlayer.domElement).find('#video-controls #gap-input').val());
                    if (isFinite(gapInput)) {
                        if (secondVideo) {
                            if (gapInput < 0 && mainVideo[0].currentTime < gapInput * -1) {
                                mainVideo[0].currentTime = mainVideo[0].currentTime + gapInput * -1;
                            }

                            secondVideo[0].currentTime = Math.max(0, Math.min(mainVideo[0].duration, mainVideo[0].currentTime + gapInput));

                            var percent = secondVideo[0].currentTime / secondVideo[0].duration * 100;
                            $(secondVideo).parent().find('.progress-bar').css({width: percent + '%'});
                            $(secondVideo).parent().find('.video-time-code-current-time').text(secondsToHms(secondVideo[0].currentTime));
                        }
                    } else {
                        $(resultsPlayer.domElement).find('#video-controls #gap-input').val(0.00);
                    }
                }

                function updateScreenRecord() {
                    if (screenShareVideoHolder !== null) {
                        var screenVideo = screenShareVideoHolder[0];
                        if (mainVideo[0].currentTime > screenSharingStartGap && mainVideo[0].currentTime < screenSharingStartGap + screenVideo.duration) {
                            screenVideo.currentTime = mainVideo[0].currentTime - screenSharingStartGap;
                        } else if (mainVideo[0].currentTime <= screenSharingStartGap) {
                            screenVideo.currentTime = 0;
                        } else {
                            screenVideo.currentTime = screenVideo.duration;
                        }

                        var percent = screenVideo.currentTime / screenVideo.duration * 100;
                        $(resultsPlayer.domElement).find('#screen-share-video-container .progress-bar').css({width: percent + '%'});
                        $(resultsPlayer.domElement).find('#screen-share-video-container .video-time-code-current-time').text(secondsToHms(screenVideo.currentTime));
                    }
                }
            }
        }

        function getMainVideoPlayer() {
            if (screenShareVideoHolder) {
                if (moderatorVideoHolder && testerVideoHolder) {
                    var start = getSeconds(getTimeBetweenTimestamps(evaluatorResults.startRecordingTime || evaluatorResults.startTime, testerResults.startRecordingTime || testerResults.startTime), true);
                    var end = getSeconds(getTimeBetweenTimestamps(evaluatorResults.endRecordingTime || evaluatorResults.endTime, testerResults.endRecordingTime || testerResults.endTime), true);

                    if (evaluatorResults.startRecordingTime < testerResults.startRecordingTime) {
                        start *= -1;
                    }

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

                return {mainVideo: moderatorVideoHolder, secondVideo: testerVideoHolder, gap: {start: start, end: end}};
            } else {
                $(resultsPlayer.domElement).find('#gap-input-container').remove();
                $(resultsPlayer.domElement).find('#seek-bar-container').removeClass('col-xs-7 col-sm-8 col-lg-9').addClass('col-xs-10 col-lg-11');
                return {mainVideo: testerVideoHolder, secondVideo: null, gap: null};
            }

            return null;
        }

        return {domElement: resultsPlayer, player: player};
    }

    return null;
}

var timeline, itemRange, currentVisData = null;
function initializeTimeline(timelineData, content) {
    if (timelineData) {
        // Create a Timeline
        var data = getVisDataSet(timelineData);
        currentVisData = data;

        $(player).trigger('initialized');

        // for removing unused timeline
        $(content).find('#btn-toggle-timeline').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if ($(this).hasClass('present')) {
                removeAlert($(content).find('#timeline-content'), ALERT_NO_ANNOTATIONS);
                $(this).removeClass('present');
                $(content).find('#results-timeline').addClass('hidden');
                $(this).find('.text').text(translation.showTimeline);
                $(this).find('.fa').removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                $(this).addClass('present');
                $(this).find('.text').text(translation.hideTimeline);
                $(this).find('.fa').removeClass('fa-eye').addClass('fa-eye-slash');
//                console.log(data);
                var tempData = getLocalItem(timelineData.phaseResults.id + '.' + timelineData.resultSource);
                console.log(tempData.annotations);
                if ((tempData && tempData.annotations && tempData.annotations.length > 0) || (data && data.length > 2)) {
                    clearAlerts();
                    $(content).find('#results-timeline').removeClass('hidden');
                    updateTimeline(timelineData.checkedVideos.mainVideo[0].currentTime, content);
                } else {
                    appendAlert($(content).find('#timeline-content'), ALERT_NO_ANNOTATIONS);
                }
            }
        });

        if (data && data.length > 2) {
            itemRange = {min: new Date(parseInt(timelineData.phaseResults.startTime)), max: new Date(parseInt(timelineData.phaseResults.endTime)), gap: getTimeBetweenTimestamps(parseInt(timelineData.phaseResults.startTime), parseInt(timelineData.phaseResults.startRecordingTime)), startRecording: data[0].timestamp, endRecording: data[1].timestamp};//timeline.getItemRange();
            var options = {
                zoomable: false,
                showCurrentTime: false,
                orientation: 'top',
                min: itemRange.min,
                start: itemRange.min,
                max: itemRange.max,
                end: itemRange.max,
                showMajorLabels: false,
                showMinorLabels: false,
                zoomMax: 10000,
                selectable: false,
                autoResize: true
            };

            timeline = new vis.Timeline($(resultsPlayer.domElement).find('#results-timeline').empty()[0], new vis.DataSet(data), options);
            timeline.addCustomTime(itemRange.min);

            renderSeekbarData(data, timelineData, content);
            renderListData(data, timelineData, content);

            if (!$(content).find('#btn-toggle-timeline').hasClass('present')) {
                $(content).find('#btn-toggle-timeline').click();
            }
        } else {
            console.warn('no timeline data extracted');
            $(content).find('#btn-toggle-timeline').click();
            renderListData(data, null, content);
        }
    } else {
        console.warn('no timeline data');
        $(content).find('#btn-toggle-timeline').click();
    }
}

function updateTimeline(currentTime, content) {
    if (timeline && itemRange && $(content).find('#btn-toggle-timeline').hasClass('present')) {
        var customTime = new Date(itemRange.startRecording + Math.round(parseFloat(currentTime) * 1000));
//        console.log(customTime);

//        var min = new Date(itemRange.min);
//        min.setSeconds(min.getSeconds() + Math.ceil(Math.max(0, currentTime)));
//        min.setMilliseconds(min.getMilliseconds() + Math.round(currentTime % 1 * 1000) - 1000); // -1000 because of the recording start lack
        timeline.setCustomTime(customTime);
        timeline.moveTo(customTime, {animation: false});
    }
}

RTCResultsPlayer.prototype.visData = function () {
    return currentVisData;
};

// Create a DataSet (allows two way data-binding)
function getVisDataSet(timelineData) {
    var array = [];
    array.push({id: chance.natural(), start: new Date(parseInt(timelineData.phaseResults.startRecordingTime || timelineData.phaseResults.startTime)), className: 'invisible', timestamp: parseInt(timelineData.phaseResults.startRecordingTime || timelineData.phaseResults.startTime)});
    array.push({id: chance.natural(), start: new Date(parseInt(timelineData.phaseResults.endRecordingTime || timelineData.phaseResults.endTime)), className: 'invisible', timestamp: parseInt(timelineData.phaseResults.endRecordingTime || timelineData.phaseResults.endTime)});

    var className = 'item-primary-full';
    var annotations = timelineData.phaseResults.annotations;
    var tempData = getLocalItem(timelineData.phaseResults.id + (timelineData.checkedVideos.secondVideo ? '.evaluator' : '.results'));
    if (annotations) {
        for (var i = 0; i < annotations.length; i++) {
            var className = 'item-primary-full';
            var contentText = translation.annotationsList[annotations[i].action];
            switch (annotations[i].action) {
                case ACTION_CUSTOM:
                    contentText = annotations[i].content;
                    className = annotations[i].annotationColor;
                    break;
                case ACTION_RENDER_SCENE:
                    var scene = getSceneById(annotations[i].scene);
                    contentText = translation.scene + ': ' + scene.title;
                    break;
                case ACTION_START_GESTURE_TRAINING:
                case ACTION_START_PERFORM_GESTURE:
                case ACTION_START_PERFORM_TRIGGER_IDENTIFICATION:
                case ACTION_START_PERFORM_GESTURE_STRESS_TEST:
                    var gesture = getGestureById(annotations[i].gestureId);
                    contentText = translation.annotationsList[annotations[i].action] + ': ' + gesture.title;
                    break;
//                case ACTION_START_PERFORM_GESTURE:
//                    var gesture = getGestureById(annotations[i].gestureId);
//                    contentText = translation.annotationsList[annotations[i].action] + ': ' + gesture.title;
//                    break;
                case ACTION_START_PERFORM_GESTURE_IDENTIFICATION:
//                    console.log(annotations[i].triggerId);
                    var trigger = getTriggerById(annotations[i].triggerId);
                    contentText = translation.annotationsList[annotations[i].action] + ': ' + trigger.title;
                    break;
//                case ACTION_START_PERFORM_TRIGGER_IDENTIFICATION:
//                    var gesture = getGestureById(annotations[i].gestureId);
//                    contentText = translation.annotationsList[annotations[i].action] + ': ' + gesture.title;
//                    break;
                case ACTION_SELECT_GESTURE:
                    var gesture = getGestureById(annotations[i].selectedGestureId);
                    className = 'item-success-full';
                    contentText = translation.annotationsList[annotations[i].action] + ': ' + gesture.title;
                    break;
                case ACTION_NO_GESTURE_DEMONSTRATED:
                case ACTION_NO_GESTURE_FIT_FOUND:
                    className = 'item-warning-full';
                    break;
//                case ACTION_START_PERFORM_GESTURE_STRESS_TEST:
//                    var gesture = getGestureById(annotations[i].gestureId);
//                    contentText = translation.annotationsList[annotations[i].action] + ': ' + gesture.title;
//                    break;
                case ACTION_START_TASK:
                    var task = getTaskById(annotations[i].taskId);
                    contentText = translation.task + ': ' + task.title;
                    break;
                case ACTION_ASSESSMENT:
                    contentText = timelineData.phaseData.taskAssessments[annotations[i].assessmentId].title + ': ' + getTaskById(annotations[i].taskId).title;
                    var color = timelineData.phaseData.taskAssessments[annotations[i].assessmentId].annotationColor;
                    switch (color) {
                        case ASSESSMENT_COLOR_GREEN:
                            className = 'item-success-full';
                            break;
                        case ASSESSMENT_COLOR_BLUE:
                            className = 'item-info-full';
                            break;
                        case ASSESSMENT_COLOR_RED:
                            className = 'item-danger-full';
                            break;
                        case ASSESSMENT_COLOR_YELLOW:
                            className = 'item-warning-full';
                            break;
                    }
                    break;
                case ACTION_SHOW_FEEDBACK:
                    if (annotations[i].feedback.parameters.negative === 'yes') {
                        className = 'item-danger-full';
                    }
                    break;
                case ACTION_HIDE_FEEDBACK:
                    break;
                case ACTION_ALL_RECORDER_READY:
                    contentText = translation.annotationsList[annotations[i].action];
                    className = 'item-success-full';
                    break;
                case ACTION_RECORDER_LOST:
                    contentText = translation.annotationsList[annotations[i].action];
                    className = 'item-danger-full';
                    break;
                case ACTION_SHOW_GESTURE_INFO:
                case ACTION_HIDE_GESTURE_INFO:
                    var gesture = getGestureById(annotations[i].gestureId);
                    contentText = translation.annotationsList[annotations[i].action] + ': ' + gesture.title;
                    break;
                case ACTION_SHOW_TRIGGER_INFO:
                case ACTION_HIDE_TRIGGER_INFO:
                    var trigger = getTriggerById(annotations[i].triggerId);
                    contentText = translation.annotationsList[annotations[i].action] + ': ' + trigger.title;
                    break;
            }

            var originalId = annotations[i].id;
            if (!annotations[i].id) {
                originalId = chance.natural();
                tempData.annotations[i].id = originalId;
            }
            array.push({id: originalId, content: contentText, start: new Date(parseInt(annotations[i].time)), className: className, timestamp: parseInt(annotations[i].time)});
        }
        setLocalItem(timelineData.phaseResults.id + (timelineData.checkedVideos.secondVideo ? '.evaluator' : '.results'), tempData);
    }

    function getTaskById(id) {
        for (var i = 0; i < timelineData.phaseData.tasks.length; i++) {
            if (parseInt(timelineData.phaseData.tasks[i].id) === parseInt(id)) {
                return timelineData.phaseData.tasks[i];
            }
        }
        return null;
    }

    return array;
}

function renderSeekbarData(visData, timelineData, content) {
    var duration = getSeconds(timelineData.duration, true);
    visData = sortByKey(visData, 'start');

    var seekbar = $(content).find('#seek-bar-meta-info-container');
    $(seekbar).empty();

    if (visData && visData.length > 0) {
        var lastTime = 0;
//        console.log('render seekbar data', visData, seekbar);
        for (var i = 0; i < visData.length; i++) {
            if (visData[i].className !== 'invisible' && visData[i].timestamp) {
                var gap = getSeconds(getTimeBetweenTimestamps(timelineData.phaseResults.startRecordingTime || timelineData.phaseResults.startTime, visData[i].timestamp), true);
                var xPercentage = gap / duration * 100;
                var infoDataItem = document.createElement('div');
                $(infoDataItem).addClass('seekbarInfoData');
                $(infoDataItem).addClass(visData[i].className);
                $(infoDataItem).css({left: xPercentage + '%'});

                var currentTime = visData[i].start.getTime();
                if (currentTime - lastTime === 0) {
                    $(seekbar).children().last().css({opacity: '0.5'});
                    $(infoDataItem).css({height: '15px'});
                } else {
                    lastTime = currentTime;
                    $(infoDataItem).css({opacity: '1.0'});
                }

                $(seekbar).append(infoDataItem);
            }
        }
    } else {
        $(content).find('#timeline-content').addClass('hidden');
    }
}

function renderListData(visData, timelineData, content) {
    $(content).find('#btn-toggle-link-list').unbind('click').bind('click', function (event) {
        event.preventDefault();
//        console.log('btn toggle link list clicked ', $(this).hasClass('present'));
        if ($(this).hasClass('present')) {
            removeAlert($(content).find('#link-list-content'), ALERT_NO_ANNOTATIONS);
            $(this).removeClass('present');
            $(content).find('#link-list-container').addClass('hidden');
            $(this).find('.fa').removeClass('fa-eye-slash').addClass('fa-eye');
            $(this).find('.text').text(translation.showLinklist);
        } else {
            $(this).addClass('present');
            $(content).find('#link-list-container').removeClass('hidden');
            $(this).find('.fa').removeClass('fa-eye').addClass('fa-eye-slash');
            $(this).find('.text').text(translation.hideLinklist);

            if (visData && visData.length > 2) {
                clearAlerts();
                updateLinkList(timelineData.checkedVideos.mainVideo[0].currentTime, content);
            } else {
                appendAlert($(content).find('#link-list-content'), ALERT_NO_ANNOTATIONS);
            }
        }
    });

    if (timelineData) {
        visData = sortByKey(visData, 'start');
        var container = $(content).find('#link-list-container');
        $(container).empty();
        if (visData && visData.length > 2) {

            if (!$(content).find('#btn-toggle-link-list').hasClass('present')) {
                $(content).find('#btn-toggle-link-list').click();
            }

            for (var i = 0; i < visData.length; i++) {
                if (visData[i].className !== 'invisible' && visData[i].timestamp) {
                    var seconds = getSeconds(getTimeBetweenTimestamps(timelineData.phaseResults.startRecordingTime || timelineData.phaseResults.startTime, visData[i].timestamp), true);
                    var linkListItem = $('#template-study-container').find('#link-list-item').clone().removeAttr('id');
                    $(linkListItem).find('.link-list-item-url').attr('data-jumpto', seconds);
                    $(linkListItem).find('.btn-delete-annotation').attr('data-id', visData[i].id);
                    $(linkListItem).find('.link-list-item-time').text(secondsToHms(parseInt(seconds)));
                    $(linkListItem).find('.link-list-item-title').text(visData[i].content);
                    $(linkListItem).find('.link-list-item-title').addClass(visData[i].className);

                    $(container).append(linkListItem);
                    $(linkListItem).find('.link-list-item-url').on('click', function (event) {
                        event.preventDefault();
                        var jumpTo = parseFloat($(this).attr('data-jumpto'));
                        var video = timelineData.checkedVideos.mainVideo[0];
                        $(video).trigger('jumpTo', [jumpTo]);
                    });

                    $(linkListItem).find('.btn-delete-annotation').on('click', function (event) {
                        event.preventDefault();
//                    console.log('delete annotation', $(this).attr('data-id'), checkedVideos.secondVideo);
                        deleteAnnotation($(this).attr('data-id'), timelineData, content);
                    });
                }
            }


        } else {
//        $(content).find('#btn-toggle-link-list').click();
//        $(content).find('#link-list-content').addClass('hidden');
        }
    } else {

    }
}

function updateLinkList(currentTime, content) {
    if ($(content).find('#btn-toggle-link-list').hasClass('present')) {
        var linkItems = $(content).find('#link-list-container').children();
        linkItems.find('.link-list-item-url').removeClass('font-bold');
        for (var i = 0; i < linkItems.length; i++) {
            var linkListItem = $(linkItems[i]);
            var jumpTo = parseFloat($(linkListItem).find('.link-list-item-url').attr('data-jumpto'));
            if (currentTime >= jumpTo) {
                $(linkListItem).find('.link-list-item-url').addClass('font-bold');
            }
        }
    }
}

function deleteAnnotation(annotationId, timelineData, content) {
//    console.log(annotationId, timelineData);
//    if (timelineData.phaseResults) {
//    }

    var tempData = null;
    tempData = getLocalItem(timelineData.phaseResults.id + '.' + timelineData.resultSource);
    if (tempData.annotations && tempData.annotations.length > 0) {
        for (var i = 0; i < tempData.annotations.length; i++) {
            if (parseInt(annotationId) === parseInt(tempData.annotations[i].id)) {
                tempData.annotations.splice(i, 1);
            }
        }
//        console.log(tempData.annotations);
        timelineData.phaseResults = tempData;
        setLocalItem(tempData.id + '.' + timelineData.resultSource, tempData);
        saveUpdatedPhaseResults(timelineData);

        if (tempData.annotations.length === 0) {
            if ($(content).find('#btn-toggle-timeline').hasClass('present')) {
                $(content).find('#btn-toggle-timeline').click();
            }

            if ($(content).find('#btn-toggle-link-list').hasClass('present')) {
                $(content).find('#btn-toggle-link-list').click();
            }
        }

        // render timeline and other elements
        var visData = getVisDataSet(timelineData);
        timeline.setItems(new vis.DataSet(visData));
        renderSeekbarData(visData, timelineData, content);
        renderListData(visData, timelineData, content);
        updateLinkList(timelineData.checkedVideos.mainVideo[0].currentTime, content);
    }
}

function initializeAnnotationHandling(timelineData, content) {
    $(content).find('#btn-add-annotation-input').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            var mainVideo = timelineData.checkedVideos.mainVideo[0];
            if (mainVideo.paused === false) {
                $(content).find('#btn-play-pause').click();
            }
            var annotationLabel = $(content).find('.annotation-title-input').val().trim();
            if (annotationLabel !== '') {
                var annotationTime = parseInt(timelineData.phaseResults.startRecordingTime || timelineData.phaseResults.startTime) + Math.floor(mainVideo.currentTime * 1000);
                var annotation = {id: chance.natural(), action: ACTION_CUSTOM, content: annotationLabel, annotationColor: $(content).find('.color-selector .selected').attr('data-id'), time: annotationTime};
                var firstInitializeTimeline = false;

                if (timelineData.phaseResults.annotations && timelineData.phaseResults.annotations.length > 0) {
                    timelineData.phaseResults.annotations.push(annotation);
                } else {
                    firstInitializeTimeline = true;
                    timelineData.phaseResults.annotations = [annotation];
                }

                var visData = getVisDataSet(timelineData);
                if (firstInitializeTimeline) {
                    initializeTimeline(timelineData, content);
                    updateTimeline(timelineData.checkedVideos.mainVideo[0].currentTime, content);
                } else {
                    timeline.setItems(new vis.DataSet(visData));
                    timeline.redraw();
                    renderSeekbarData(visData, timelineData, content);
                    renderListData(visData, timelineData, content);

                    if (!$(content).find('#btn-toggle-timeline').hasClass('present')) {
                        $(content).find('#btn-toggle-timeline').click();
                    }
                }
                updateLinkList(mainVideo.currentTime, content);

                setLocalItem(timelineData.phaseResults.id + '.' + timelineData.resultSource, timelineData.phaseResults);
                saveUpdatedPhaseResults(timelineData);

                $(content).find('.annotation-title-input').val('');
            } else {
                $(content).find('.annotation-title-input').parent().addClass('has-error');
            }
        }

        setInputChangeEvent($(content).find('.annotation-title-input'));
        $(content).find('.annotation-title-input').unbind('change').bind('change', function (event) {
            event.preventDefault();
            $(content).find('.annotation-title-input').parent().removeClass('has-error');
        });
    });
}

function saveUpdatedPhaseResults(timelineData) {
    var phaseSteps = getLocalItem(STUDY_PHASE_STEPS);
    var generalStudyResults = getLocalItem(STUDY_RESULTS);
    var saveData = {studySuccessfull: generalStudyResults.executionSuccess, aborted: generalStudyResults.executionAborted, phases: []};

    for (var i = 0; i < phaseSteps.length; i++) {
        saveData.phases.push(getLocalItem(phaseSteps[i].id + '.' + timelineData.resultSource));
    }

    if (timelineData.resultSource === 'evaluator') {
        saveExecutionModerator({studyId: getLocalItem(STUDY).id, testerId: generalStudyResults.userId, data: saveData}, function (result) {
            console.log('saveExecutionModerator', result);
        });
    } else {
        saveExecutionTester({studyId: getLocalItem(STUDY).id, testerId: generalStudyResults.userId, data: saveData}, function (result) {
            console.log('saveExecutionTester', result);
        });
    }

//    console.log('saveData', saveData);
}