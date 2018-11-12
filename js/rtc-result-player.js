/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var resultsPlayer, player = null;
function RTCResultsPlayer(testerResults, evaluatorResults, wizardResults, phaseData, executionTime, content) {
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
        var buttonStepBackward = $(resultsPlayer).find('#btn-step-backward');
        var buttonStepForward = $(resultsPlayer).find('#btn-step-forward');
        var seekBar = $(resultsPlayer).find('#main-seek-bar');

        var screenShareVideoHolder = null;
        var moderatorVideoHolder = null;
        var testerVideoHolder = null;

        resultsPlayer.find('#video-timeline').addClass('hidden');
        resultsPlayer.find('#loader').removeClass('hidden');

        if (evaluatorResults) {
            if (evaluatorResults.screenRecordUrl || wizardResults.screenRecordUrl) {
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
            var startScreenRecordingTime = 0;
            var endScreenRecordingTime = 0;
            var startTime = 0;
            var screenRecordUrl = evaluatorResults.screenRecordUrl || wizardResults.screenRecordUrl;

            $.get(UPLOADS + screenRecordUrl)
                    .fail(function () {
                        console.warn('file does not exist: ' + UPLOADS + screenRecordUrl);
                        screenRecordingFileExist = false;
                        appendAlert(resultsPlayer, ALERT_RECORD_URL_INVALID);

                        $(resultsPlayer).find('#loader').addClass('hidden');
                        return false;
                    });

            screenShareVideoHolder = $(resultsPlayer).find('#screen-share-video-holder');
            if (screenRecordingFileExist) {
                if (evaluatorResults.screenRecordUrl) {
                    startScreenRecordingTime = evaluatorResults.startScreenRecordingTime;
                    endScreenRecordingTime = evaluatorResults.endScreenRecordingTime;
                    startTime = evaluatorResults.startTime;
//                    console.log('USE evaluator times');
                } else if (wizardResults.screenRecordUrl) {
                    startScreenRecordingTime = wizardResults.startScreenRecordingTime;
                    endScreenRecordingTime = wizardResults.endScreenRecordingTime;
                    startTime = wizardResults.startTime;
//                    console.log('USE wizard times');
                }


                $(screenShareVideoHolder).attr('src', UPLOADS + screenRecordUrl);

                $(screenShareVideoHolder).on('loadedmetadata', function () {
                    // google chrome no-duration workaround
                    if (screenShareVideoHolder[0].duration === Infinity) {
                        var duration = getSeconds(getTimeBetweenTimestamps(startScreenRecordingTime, endScreenRecordingTime), true);
                        if (!moderatorVideoHolder && testerVideoHolder) {
                            var participantsStartGap = getSeconds(getTimeBetweenTimestamps(startTime, testerResults.startTime), true);
                            if (startTime > testerResults.startTime) {
                                participantsStartGap *= -1;
                            }
                            screenSharingStartGap = getSeconds(getTimeBetweenTimestamps(startScreenRecordingTime, testerResults.startTime), true) + participantsStartGap;
                        } else if (moderatorVideoHolder) {
                            screenSharingStartGap = getSeconds(getTimeBetweenTimestamps(startScreenRecordingTime, startTime), true);
                        }

//                        console.log('SCREEN SHARING START GAP:', screenSharingStartGap)
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

                $(screenShareVideoHolder).parent().find('#toggle-overlap-videos').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    $(this).popover('hide');
                    $(this).parent().find('.btn-video-adjustment').removeClass('selected');
                    $(this).addClass('selected');
//                    $(this).addClass('hidden');
//                    $(screenShareVideoHolder).parent().find('#toggle-big-screen').removeClass('hidden');

//                    if ($(this).hasClass('shrinked')) {
//                        $(this).removeClass('shrinked');
//                        $(this).find('.fa').removeClass('fa-window-close-o').addClass('fa-window-maximize');
//                        $(this).closest('#video-timeline').find('#webcam-video-container').removeClass('shrinked');
//                        $(this).closest('#video-timeline').find('#webcam-video-container #tester-video-container').removeClass('shrinked');
//                        $(this).closest('#video-timeline').find('#webcam-video-container #moderator-video-container').removeClass('shrinked');
//                        $(this).attr('data-content', translation.overlapVideos);
//                    } else {
//                        $(this).addClass('shrinked');
//                        $(this).find('.fa').removeClass('fa-window-maximize').addClass('fa-window-close-o');
                    $(this).closest('#video-timeline').find('#webcam-video-container').addClass('shrinked');
                    $(this).closest('#video-timeline').find('#webcam-video-container #tester-video-container').addClass('shrinked');
                    $(this).closest('#video-timeline').find('#webcam-video-container #moderator-video-container').addClass('shrinked');

                    $(this).closest('#video-timeline').find('#screen-share-video-container').removeClass('col-xs-9').addClass('col-xs-12');
                    $(this).closest('#video-timeline').find('#screen-share-video-container .hidden-controls-container-btn').css({top: '65%'});
                    $(this).closest('#video-timeline').find('#webcam-video-container').removeClass('col-xs-3').addClass('col-xs-12').css({marginTop: '30px', marginLeft: '15px'});
                    $(this).closest('#video-timeline').find('#webcam-video-container #tester-video-container').removeClass('col-xs-12').addClass('col-xs-5 col-sm-4');
                    $(this).closest('#video-timeline').find('#webcam-video-container #moderator-video-container').removeClass('col-xs-12').addClass('col-xs-5 col-sm-4 col-xs-offset-2 col-sm-offset-4').css({marginTop: ''});
                });

                $(screenShareVideoHolder).parent().find('#toggle-big-screen').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    $(this).popover('hide');
                    $(this).parent().find('.btn-video-adjustment').removeClass('selected');
                    $(this).addClass('selected');

                    $(this).closest('#video-timeline').find('#webcam-video-container').removeClass('shrinked');
                    $(this).closest('#video-timeline').find('#webcam-video-container #tester-video-container').removeClass('shrinked');
                    $(this).closest('#video-timeline').find('#webcam-video-container #moderator-video-container').removeClass('shrinked');

                    $(this).closest('#video-timeline').find('#screen-share-video-container').removeClass('col-xs-9').addClass('col-xs-12');
                    $(this).closest('#video-timeline').find('#screen-share-video-container .hidden-controls-container-btn').css({top: '50%'});
                    $(this).closest('#video-timeline').find('#webcam-video-container').removeClass('col-xs-3').addClass('col-xs-12').css({marginTop: '10px', marginLeft: ''});
                    $(this).closest('#video-timeline').find('#webcam-video-container #tester-video-container').removeClass('col-xs-12 col-xs-5 col-sm-4').addClass('col-xs-6');
                    $(this).closest('#video-timeline').find('#webcam-video-container #moderator-video-container').removeClass('col-xs-12 col-xs-5 col-sm-4 col-xs-offset-2 col-sm-offset-4').addClass('col-xs-6').css({marginTop: ''});
                });

                $(screenShareVideoHolder).parent().find('#toggle-side-by-side').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    $(this).popover('hide');
                    $(this).parent().find('.btn-video-adjustment').removeClass('selected');
                    $(this).addClass('selected');

                    $(this).closest('#video-timeline').find('#webcam-video-container').removeClass('shrinked');
                    $(this).closest('#video-timeline').find('#webcam-video-container #tester-video-container').removeClass('shrinked');
                    $(this).closest('#video-timeline').find('#webcam-video-container #moderator-video-container').removeClass('shrinked');

                    $(this).closest('#video-timeline').find('#screen-share-video-container').removeClass('col-xs-12').addClass('col-xs-9');
                    $(this).closest('#video-timeline').find('#screen-share-video-container .hidden-controls-container-btn').css({top: '50%'});
                    $(this).closest('#video-timeline').find('#webcam-video-container').removeClass('col-xs-12').addClass('col-xs-3').css({marginTop: '', marginLeft: ''});
                    $(this).closest('#video-timeline').find('#webcam-video-container #tester-video-container').removeClass('col-xs-6 col-xs-5 col-sm-4').addClass('col-xs-12');
                    $(this).closest('#video-timeline').find('#webcam-video-container #moderator-video-container').removeClass('col-xs-6 col-xs-5 col-sm-4 col-xs-offset-2 col-sm-offset-4').addClass('col-xs-12').css({marginTop: '10px'});
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

                    var togglePlayPauseButtons = $('#phase-results').find('.btn-toggle-playback');
//                    console.log('togglePlayPauseButtons', togglePlayPauseButtons);

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


                    // back and forward stepping functionalities

                    var stepInterval = null;
                    $(buttonStepBackward).unbind('click').bind('click', function (event) {
                        event.preventDefault();
                        step('backward');
                    });

                    $(buttonStepBackward).unbind('mousedown').bind('mousedown', function (event) {
                        event.preventDefault();
                        clearInterval(stepInterval);
                        stepInterval = setInterval(function () {
                            step('backward');
                        }, 200);
                    });

                    $(buttonStepBackward).unbind('mouseup').bind('mouseup', function (event) {
                        event.preventDefault();
                        clearInterval(stepInterval);
                    });

                    $(buttonStepForward).unbind('click').bind('click', function (event) {
                        event.preventDefault();
                        step('forward');
                    });

                    $(buttonStepForward).unbind('mousedown').bind('mousedown', function (event) {
                        event.preventDefault();
                        clearInterval(stepInterval);
                        stepInterval = setInterval(function () {
                            step('forward');
                        }, 200);
                    });

                    $(buttonStepForward).unbind('mouseup').bind('mouseup', function (event) {
                        event.preventDefault();
                        clearInterval(stepInterval);
                    });

                    function step(direction) {
                        var video = mainVideo[0];
                        if (video.paused !== true) {
                            video.pause();
                        }

                        if (secondVideo && secondVideo[0].paused !== true) {
                            secondVideo[0].pause();
                        }
//                        console.log(video.currentTime);
                        switch (direction) {
                            case 'backward':
                                video.currentTime = Math.max(video.currentTime - 0.033, 0);
                                break;
                            case 'forward':
                                video.currentTime = Math.min(video.currentTime + 0.033, video.duration);
                                break;
                        }
//                        console.log(video.currentTime);
                        readGapInput();
                    }


                    // streaming button functionalities

                    $(togglePlayPauseButtons).unbind('click').bind('click', function (event) {
                        event.preventDefault();
                        $(playButton).click();
                    });

                    $(mainVideo).unbind('pause').bind('pause', function () {
                        $(playButton).find('.fa').removeClass('fa-pause').addClass('fa-play');
                        $(togglePlayPauseButtons).find('.fa').removeClass('fa-pause').addClass('fa-play');
                        $(playButton).popover('hide');
                        $(playButton).attr('data-content', translation.play);
                    });

                    $(mainVideo).unbind('play').bind('play', function () {
                        $(playButton).find('.fa').removeClass('fa-play').addClass('fa-pause');
                        $(togglePlayPauseButtons).find('.fa').removeClass('fa-play').addClass('fa-pause');
                        $(playButton).popover('hide');
                        $(playButton).attr('data-content', translation.pause);
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
//        console.log('INITIALIZE TIMELINE:', data);

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
//                console.log(tempData.annotations);
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
                autoResize: true,
                minHeight: '60px'
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
    var annotations = [];
    array.push({id: chance.natural(), start: new Date(parseInt(timelineData.phaseResults.startRecordingTime || timelineData.phaseResults.startTime)), className: 'invisible', timestamp: parseInt(timelineData.phaseResults.startRecordingTime || timelineData.phaseResults.startTime)});
    array.push({id: chance.natural(), start: new Date(parseInt(timelineData.phaseResults.endRecordingTime || timelineData.phaseResults.endTime)), className: 'invisible', timestamp: parseInt(timelineData.phaseResults.endRecordingTime || timelineData.phaseResults.endTime)});

    // prepare tester annotations for deleting
    var testerData = getLocalItem(timelineData.phaseResults.id + '.tester');
    if (testerData && testerData.annotations && testerData.annotations.length > 0) {
        for (var i = 0; i < testerData.annotations.length; i++) {
            var annotation = testerData.annotations[i];
            if (!annotation.id) {
                annotation.id = chance.natural();
            }
            annotation.source = VIEW_TESTER;
            annotation.id = annotation.id + '-' + annotation.source;
            annotations.push(annotation);
        }
    }

    // prepare evaluator annotations for deleting
    var evaluatorData = getLocalItem(timelineData.phaseResults.id + '.evaluator');
    if (evaluatorData && evaluatorData.annotations && evaluatorData.annotations.length > 0) {
        for (var i = 0; i < evaluatorData.annotations.length; i++) {
            var annotation = evaluatorData.annotations[i];
            if (!annotation.id) {
                annotation.id = chance.natural();
            }
            annotation.source = 'evaluator';
            annotation.id = annotation.id + '-' + annotation.source;
            annotations.push(annotation);
        }
    }

    // prepare wizard annotations for deleting
    var wizardData = getLocalItem(timelineData.phaseResults.id + '.wizard');
    if (wizardData && wizardData.annotations && wizardData.annotations.length > 0) {
        for (var i = 0; i < wizardData.annotations.length; i++) {
            var annotation = wizardData.annotations[i];
            if (!annotation.id) {
                annotation.id = chance.natural();
            }
            annotation.source = VIEW_WIZARD;
            annotation.id = annotation.id + '-' + annotation.source;
            annotations.push(annotation);
        }
    }

    // prepare observer annotations for deleting
    var observerData = getLocalItem(timelineData.phaseResults.id + '.observer');
    if (observerData && observerData.annotations && observerData.annotations.length > 0) {
        for (var i = 0; i < observerData.annotations.length; i++) {
            var annotation = observerData.annotations[i];
            if (!annotation.id) {
                annotation.id = chance.natural();
            }
            annotation.source = VIEW_OBSERVER;
            annotation.id = annotation.id + '-' + annotation.source;
            annotations.push(annotation);
        }
    }

//    var className = 'item-primary-full';
//    var annotations = timelineData.phaseResults.annotations;
//    
//    if (wizardData && wizardData.annotations) {
//        var evaluatorAnnotations = evaluatorData.annotations;
//        
//        for (var i = 0; i < evaluatorAnnotations.length; i++) {
//            evaluatorAnnotations[i].id = chance.natural();
//        }
//        
//        annotations = annotations.concat(evaluatorAnnotations);
//        console.log('ANNOTATIONS EVAULTOR:', annotations);
//    }

//    var tempData = getLocalItem(timelineData.phaseResults.id + (timelineData.checkedVideos.secondVideo ? '.evaluator' : '.results'));
    if (annotations) {
        for (var i = 0; i < annotations.length; i++) {
            var className = 'item-advanced-primary-full';
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
//                    console.log(annotations[i].gestureId, gesture);
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
                        case ASSESSMENT_COLOR_DARKBLUE:
                            className = 'item-primary-full';
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
                case ACTION_OBSERVER_ANNOTATION:
                    contentText = translation.observatorHint;
                    var color = annotations[i].annotationColor;
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
                        case ASSESSMENT_COLOR_DARKBLUE:
                            className = 'item-primary-full';
                            break;
                    }
                    break;
            }

//            var originalId = annotations[i].id;
//            if (!annotations[i].id) {
//                originalId = chance.natural();
//                tempData.annotations[i].id = originalId;
//            }
            array.push({id: annotations[i].id, content: contentText, start: new Date(parseInt(annotations[i].time)), className: className, timestamp: parseInt(annotations[i].time), source: annotations[i].source});
        }
//        setLocalItem(timelineData.phaseResults.id + (timelineData.checkedVideos.secondVideo ? '.evaluator' : '.results'), tempData);
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
                    $(linkListItem).find('.btn-delete-annotation').attr('data-source', visData[i].source);
                    $(linkListItem).find('.btn-edit-annotation').attr('data-id', visData[i].id);
                    $(linkListItem).find('.btn-edit-annotation').attr('data-source', visData[i].source);
                    $(linkListItem).find('.link-list-item-time').text(secondsToHms(parseInt(seconds)));
                    $(linkListItem).find('.link-list-item-title').text(visData[i].content);
                    $(linkListItem).find('.link-list-item-title').addClass(visData[i].className);
                    $(linkListItem).attr('data-content', visData[i].content);
                    $(linkListItem).attr('data-source', visData[i].source);
                    $(linkListItem).attr('data-color', visData[i].className);

                    $(container).append(linkListItem);
                    $(linkListItem).find('.link-list-item-url').on('click', function (event) {
                        event.preventDefault();
                        var jumpTo = parseFloat($(this).attr('data-jumpto'));
                        var video = timelineData.checkedVideos.mainVideo[0];
                        $(video).trigger('jumpTo', [jumpTo]);
                    });

                    $(linkListItem).find('.btn-delete-annotation').on('click', function (event) {
                        event.preventDefault();
                        if (!$(this).hasClass('disabled')) {
                            var annotationId = $(this).attr('data-id').split('-')[0];
                            deleteAnnotation(annotationId, timelineData, content, $(this).attr('data-source'));
                        }
                    });

                    $(linkListItem).find('.btn-edit-annotation').on('click', function (event) {
                        event.preventDefault();
                        if (!$(this).hasClass('disabled')) {
                            var annotationId = $(this).attr('data-id').split('-')[0];
                            $(this).parent().find('.btn-cancel-edit-annotation').removeClass('hidden');
                            $(this).addClass('hidden');
                            editAnnotation(annotationId, timelineData, content, $(this).attr('data-source'), $(this).parent());
                        }
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

function deleteAnnotation(annotationId, timelineData, content, source) {
//    console.log('delete annoation:', annotationId, source, timelineData);
//    return false;
//    console.log(annotationId, timelineData);
//    if (timelineData.phaseResults) {
//    }

    var tempData = null;
    tempData = getLocalItem(timelineData.phaseResults.id + '.' + source);
//    console.log(tempData);
    if (tempData.annotations && tempData.annotations.length > 0) {
        for (var i = 0; i < tempData.annotations.length; i++) {
            if (parseInt(annotationId) === parseInt(tempData.annotations[i].id)) {
                tempData.annotations.splice(i, 1);
            }
        }
//        console.log(tempData.annotations);

//        timelineData.phaseResults = tempData;
        setLocalItem(tempData.id + '.' + source, tempData);
//        return false;
        saveUpdatedPhaseResults(source);

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

function editAnnotation(annotationId, timelineData, content, source, linkListItem) {
//    console.log('delete annoation:', annotationId, source, timelineData);
//    return false;
//    console.log(annotationId, timelineData);
//    if (timelineData.phaseResults) {
//    }

    var phaseData = getLocalItem(timelineData.phaseResults.id + '.' + source);

    var annotations = phaseData && phaseData.annotations ? phaseData.annotations : null;
    console.log(source, timelineData, phaseData, phaseData.annotations, annotations);
    var annotation = null;
    if (annotations && annotations.length > 0) {
        for (var i = 0; i < annotations.length; i++) {
            if (parseInt(annotationId) === parseInt(annotations[i].id)) {
                annotation = annotations[i];
                break;
            }
        }
    }

    if (annotation) {
        console.log('ANNOTATION:', annotation);

        var selectedColor = 'item-advanced-primary-full';
        var contentText = translation.annotationsList[annotation.action];

        switch (annotation.action) {
            case ACTION_CUSTOM:
                contentText = annotation.content;
                selectedColor = annotation.annotationColor;
                break;
            case ACTION_RENDER_SCENE:
                var scene = getSceneById(annotation.scene);
                contentText = translation.scene + ': ' + scene.title;
                break;
            case ACTION_START_GESTURE_TRAINING:
            case ACTION_START_PERFORM_GESTURE:
            case ACTION_START_PERFORM_TRIGGER_IDENTIFICATION:
            case ACTION_START_PERFORM_GESTURE_STRESS_TEST:
                var gesture = getGestureById(annotation.gestureId);
                contentText = translation.annotationsList[annotation.action] + ': ' + gesture.title;
                break;
            case ACTION_START_PERFORM_GESTURE_IDENTIFICATION:
                var trigger = getTriggerById(annotation.triggerId);
                contentText = translation.annotationsList[annotation.action] + ': ' + trigger.title;
                break;
            case ACTION_SELECT_GESTURE:
                var gesture = getGestureById(annotation.selectedGestureId);
                selectedColor = 'item-success-full';
                contentText = translation.annotationsList[annotation.action] + ': ' + gesture.title;
                break;
            case ACTION_NO_GESTURE_DEMONSTRATED:
            case ACTION_NO_GESTURE_FIT_FOUND:
                selectedColor = 'item-warning-full';
                break;
            case ACTION_START_TASK:
                var task = getTaskById(annotation.taskId);
                contentText = translation.task + ': ' + task.title;
                break;
            case ACTION_ASSESSMENT:
                contentText = timelineData.phaseData.taskAssessments[annotation.assessmentId].title + ': ' + getTaskById(annotation.taskId).title;
                selectedColor = timelineData.phaseData.taskAssessments[annotation.assessmentId].annotationColor;
                break;
            case ACTION_SHOW_FEEDBACK:
                if (annotation.feedback.parameters.negative === 'yes') {
                    selectedColor = 'item-danger-full';
                }
                break;
            case ACTION_HIDE_FEEDBACK:
                break;
            case ACTION_ALL_RECORDER_READY:
                contentText = translation.annotationsList[annotation.action];
                selectedColor = 'item-success-full';
                break;
            case ACTION_RECORDER_LOST:
                contentText = translation.annotationsList[annotation.action];
                selectedColor = 'item-danger-full';
                break;
            case ACTION_SHOW_GESTURE_INFO:
            case ACTION_HIDE_GESTURE_INFO:
                var gesture = getGestureById(annotation.gestureId);
                contentText = translation.annotationsList[annotation.action] + ': ' + gesture.title;
                break;
            case ACTION_SHOW_TRIGGER_INFO:
            case ACTION_HIDE_TRIGGER_INFO:
                var trigger = getTriggerById(annotation.triggerId);
                contentText = translation.annotationsList[annotation.action] + ': ' + trigger.title;
                break;
            case ACTION_OBSERVER_ANNOTATION:
                contentText = translation.observatorHint;
                console.log('OBSERVER COLOR', annotation.annotationColor);
                switch (annotation.annotationColor) {
                    case ASSESSMENT_COLOR_GREEN:
                        selectedColor = 'item-success-full';
                        break;
                    case ASSESSMENT_COLOR_BLUE:
                        selectedColor = 'item-info-full';
                        break;
                    case ASSESSMENT_COLOR_RED:
                        selectedColor = 'item-danger-full';
                        break;
                    case ASSESSMENT_COLOR_YELLOW:
                        selectedColor = 'item-warning-full';
                        break;
                    case ASSESSMENT_COLOR_DARKBLUE:
                        selectedColor = 'item-primary-full';
                        break;
                }

                break;
        }
        console.log('SELECTED COLOR', selectedColor);
        $(content).find('#update-annotation-container .update-annotation-title-input').val(contentText);
        $(content).find('#update-annotation-container [data-id=' + selectedColor + ']').click();


        var submitButton = $(content).find('#update-annotation-container #btn-update-annotation-input');
        $(submitButton).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                annotation.action = ACTION_CUSTOM;
                annotation.content = $(content).find('#update-annotation-container .update-annotation-title-input').val();
                annotation.annotationColor = $(content).find('.update-color-selector .selected').attr('data-id');
                updateAnnotation(annotation);
            }
        });

        var cancelButton = $(content).find('#update-annotation-container #btn-cancel-update-annotation-input');
        $(cancelButton).unbind('click').bind('click', function (event) {
            event.preventDefault();

            $(linkListItem).find('.btn-cancel-edit-annotation').addClass('hidden');
            $(linkListItem).find('.btn-edit-annotation').removeClass('hidden');

            TweenMax.to($(content).find('#update-annotation-container'), .15, {opacity: 0, scaleX: .5, scaleY: .5, ease: Quad.easeOut, clearProps: 'all', onComplete: function () {
                    $(content).find('#update-annotation-container').addClass('hidden');
                    $(content).find('#create-annotation-container').removeClass('hidden');
                    $(content).find('#update-annotation-container .update-annotation-title-input').val('');
                    TweenMax.from($(content).find('#create-annotation-container'), .15, {opacity: 0, scaleX: 1.5, scaleY: 1.5, ease: Quad.easeOut, clearProps: 'all'});
                }});

            $(content).find('#link-list-container .btn-edit-annotation').removeClass('disabled');
            $(content).find('#link-list-container .btn-delete-annotation').removeClass('disabled');
        });

        var listItemCancelButton = $(linkListItem).find('.btn-cancel-edit-annotation');
        $(listItemCancelButton).unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(cancelButton).click();
        });

        TweenMax.to($(content).find('#create-annotation-container'), .15, {opacity: 0, scaleX: 1.5, scaleY: 1.5, ease: Quad.easeIn, clearProps: 'all', onComplete: function () {
                $(content).find('#create-annotation-container').addClass('hidden');
                $(content).find('#update-annotation-container').removeClass('hidden');
                TweenMax.from($(content).find('#update-annotation-container'), .15, {opacity: 0, scaleX: .5, scaleY: .5, ease: Quad.easeIn, clearProps: 'all'});
            }});

        $(content).find('#link-list-container .btn-edit-annotation').addClass('disabled');
        $(content).find('#link-list-container .btn-delete-annotation').addClass('disabled');
    }

    function updateAnnotation(updatedAnnotation) {
        if (phaseData.annotations && phaseData.annotations.length > 0) {

            for (var i = 0; i < phaseData.annotations.length; i++) {
                if (parseInt(updatedAnnotation.id) === parseInt(phaseData.annotations[i].id)) {
                    phaseData.annotations[i] = updatedAnnotation;
                }
            }

//            if (phaseData.annotations.length === 0) {
//                if ($(content).find('#btn-toggle-timeline').hasClass('present')) {
//                    $(content).find('#btn-toggle-timeline').click();
//                }
//
//                if ($(content).find('#btn-toggle-link-list').hasClass('present')) {
//                    $(content).find('#btn-toggle-link-list').click();
//                }
//            }


            var mainVideo = timelineData.checkedVideos.mainVideo[0];
            if (mainVideo.paused === false) {
                $(content).find('#btn-play-pause').click();
            }

            var annotationLabel = $(content).find('.update-annotation-title-input').val().trim();
            if (annotationLabel !== '') {
//                var visData = getVisDataSet(timelineData);
//                timeline.setItems(new vis.DataSet(visData));
//                timeline.redraw();
//                renderSeekbarData(visData, timelineData, content);
//                renderListData(visData, timelineData, content);

                if (!$(content).find('#btn-toggle-timeline').hasClass('present')) {
                    $(content).find('#btn-toggle-timeline').click();
                }
//                updateLinkList(mainVideo.currentTime, content);

                setLocalItem(phaseData.id + '.' + source, phaseData);
                saveUpdatedPhaseResults(source, function () {
                    $(cancelButton).click();

                    // render timeline and other elements
                    var visData = getVisDataSet(timelineData);
                    timeline.setItems(new vis.DataSet(visData));
                    renderSeekbarData(visData, timelineData, content);
                    renderListData(visData, timelineData, content);
                    updateLinkList(timelineData.checkedVideos.mainVideo[0].currentTime, content);
                    searchThroughAnnotations(content);

                });
            } else {
                $(content).find('.update-annotation-title-input').parent().addClass('has-error');
            }
        }

        setInputChangeEvent($(content).find('.update-annotation-title-input'));
        $(content).find('.update-annotation-title-input').unbind('change').bind('change', function (event) {
            event.preventDefault();
            $(content).find('.update-annotation-title-input').parent().removeClass('has-error');
        });
    }
}

function initializeAnnotationHandling(timelineData, content) {
    $(content).find('#btn-add-annotation-input').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(content).find('#btn-reset-search-annotation-input').click();

            console.log(timelineData.phaseResults.id);
            var tempData = getLocalItem(timelineData.phaseResults.id + '.' + timelineData.resultSource);
            var mainVideo = timelineData.checkedVideos.mainVideo[0];
            if (mainVideo.paused === false) {
                $(content).find('#btn-play-pause').click();
            }
            var annotationLabel = $(content).find('.annotation-title-input').val().trim();
            if (annotationLabel !== '') {
                var annotationTime = parseInt(timelineData.phaseResults.startRecordingTime || timelineData.phaseResults.startTime) + Math.floor(mainVideo.currentTime * 1000);
                var annotation = {id: chance.natural(), action: ACTION_CUSTOM, content: annotationLabel, annotationColor: $(content).find('.color-selector .selected').attr('data-id'), time: annotationTime};
                var firstInitializeTimeline = false;

                if (tempData.annotations && tempData.annotations.length > 0) {
                    tempData.annotations.push(annotation);
                } else {
                    firstInitializeTimeline = true;
                    tempData.annotations = [annotation];
                }

//                var visData = getVisDataSet(timelineData);
                if (firstInitializeTimeline) {
                    initializeTimeline(timelineData, content);
                    updateTimeline(timelineData.checkedVideos.mainVideo[0].currentTime, content);
                } else {
//                    timeline.setItems(new vis.DataSet(visData));
//                    timeline.redraw();
//                    renderSeekbarData(visData, timelineData, content);
//                    renderListData(visData, timelineData, content);

                    if (!$(content).find('#btn-toggle-timeline').hasClass('present')) {
                        $(content).find('#btn-toggle-timeline').click();
                    }
                }
//                updateLinkList(mainVideo.currentTime, content);
                timelineData.phaseResults = tempData;
                setLocalItem(timelineData.phaseResults.id + '.' + timelineData.resultSource, tempData);
                saveUpdatedPhaseResults(timelineData.resultSource, function () {
                    // render timeline and other elements
                    var visData = getVisDataSet(timelineData);
                    timeline.setItems(new vis.DataSet(visData));
                    renderSeekbarData(visData, timelineData, content);
                    renderListData(visData, timelineData, content);
                    updateLinkList(timelineData.checkedVideos.mainVideo[0].currentTime, content);
                });

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

    var resetSearchButton = $(content).find('#btn-reset-search-annotation-input');
    var searchInput = $(content).find('#search-annotation-container .annotation-search-title-input');
    var searchColorSelector = $(content).find('#search-annotation-container .search-color-selector');

    $(resetSearchButton).unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(searchInput).val('');
        $(searchColorSelector).find('.none').click();
        searchThroughAnnotations(content, true);
    });

    setInputChangeEvent(searchInput);
    $(searchInput).unbind('change').bind('change', function (event) {
        event.preventDefault();
        searchThroughAnnotations();
    });
    $(searchInput).unbind('change').bind('change', function (event) {
        event.preventDefault();
        searchThroughAnnotations(content);
    });

    $(searchColorSelector).unbind('change').bind('change', function (event) {
        event.preventDefault();
        searchThroughAnnotations(content);
    });

    $('#annotation-nav-pills a').click(function (event) {
        event.preventDefault();
        
        $(content).find('#annotation-nav-tab-content .active').removeClass('active');
//        console.log($(content).find('#annotation-nav-tab-content .active'));
        var activeTab = $(event.currentTarget).attr('href');
        $(content).find('#annotation-nav-tab-content ' + activeTab).addClass('active');
//        console.log('nav pill clicked', $(event.currentTarget).attr('href'),$('#annotation-nav-tab-content').find(activeTab) );
//        $(this).tab('show');
    });
}

function searchThroughAnnotations(contentDom, resetList) {
    var searchInput = $(contentDom).find('#search-annotation-container .annotation-search-title-input');
    var searchColorSelector = $(contentDom).find('#search-annotation-container .search-color-selector');
    var items = $(contentDom).find('#link-list-container').children();

    if (resetList && resetList === true) {
        $(items).removeClass('hidden');
        removeAlert(contentDom, ALERT_NO_SEARCH_RESULTS)
    } else {
        var coloreredItems = [];
        var visibleItems = [];

        var selectedColor = $(searchColorSelector).find('.selected').attr('data-id');
        if (selectedColor && selectedColor !== 'none') {
            // search only through items with this color
            for (var i = 0; i < items.length; i++) {
                if ($(items[i]).attr('data-color') === selectedColor) {
                    coloreredItems.push(items[i]);
                }
            }
        } else {
            coloreredItems = items;
        }

        var searchInputVal = $(searchInput).val();
        if (searchInputVal.trim() !== '' && coloreredItems.length > 0) {
            // search only through items with this content
            for (var i = 0; i < coloreredItems.length; i++) {
                var content = $(coloreredItems[i]).attr('data-content');
                if (content.search(new RegExp(searchInputVal.trim(), "i")) > -1) {
                    visibleItems.push(coloreredItems[i]);
                }
            }
        } else {
            visibleItems = coloreredItems;
        }

        $(items).addClass('hidden');
        if (visibleItems && visibleItems.length > 0) {
            removeAlert(contentDom, ALERT_NO_SEARCH_RESULTS)
            $(visibleItems).removeClass('hidden');
        } else {
            // append alert
            appendAlert(contentDom, ALERT_NO_SEARCH_RESULTS);
        }
    }
}

function saveUpdatedPhaseResults(source, callback) {
    var phaseSteps = getLocalItem(STUDY_PHASE_STEPS);
    var generalStudyResults = getLocalItem(STUDY_RESULTS);
    var saveData = {studySuccessfull: generalStudyResults.executionSuccess, aborted: generalStudyResults.executionAborted, phases: []};

    for (var i = 0; i < phaseSteps.length; i++) {
        saveData.phases.push(getLocalItem(phaseSteps[i].id + '.' + source));
    }

    var evaluatorData = getLocalItem(STUDY_DATA_EVALUATOR);
    switch (source) {
        case 'evaluator':
            saveExecutionModerator({studyId: getLocalItem(STUDY).id, testerId: generalStudyResults.userId, data: saveData}, function (result) {
                console.log('save execution moderator', result);
                if (callback) {
                    callback();
                }
            });
            break;
        case VIEW_TESTER:
            saveExecutionTester({studyId: getLocalItem(STUDY).id, testerId: generalStudyResults.userId, data: saveData}, function (result) {
                console.log('saved execution tester', result);
                if (callback) {
                    callback();
                }
            });
            break;
        case VIEW_WIZARD:
            saveExecutionWizard({studyId: getLocalItem(STUDY).id, testerId: generalStudyResults.userId, data: saveData, evaluatorId: evaluatorData.evaluatorId}, function (result) {
                console.log('saved execution wizard', result);
                if (callback) {
                    callback();
                }
            });
            break;
        case VIEW_OBSERVER:
            saveExecutionObserver({studyId: getLocalItem(STUDY).id, testerId: generalStudyResults.userId, data: saveData, evaluatorId: evaluatorData.evaluatorId}, function (result) {
                console.log('saved execution observer', result);
                if (callback) {
                    callback();
                }
            });
            break;
    }
}