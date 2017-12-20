/*
 * constants
 */
var EVENT_GR_UPDATE_STATE = 'updateState';
var EVENT_GR_STATE_RECORD = 'stateRecord';
var EVENT_GR_STATE_PLAYBACK = 'statePlayback';
var EVENT_GR_STATE_PREVIEW = 'statePreview';
var EVENT_GR_STATE_SAVE = 'stateSave';
var EVENT_GR_STATE_SAVE_SUCCESS = 'stateSaveSuccess';
var EVENT_GR_STATE_DELETE_SUCCESS = 'stateDeleteSuccess';

var EVENT_GR_SAVE_SUCCESS = 'saveSuccess';
var EVENT_GR_DELETE_SUCCESS = 'deleteSuccess';

GestureRecorder.prototype.options = null;

var recorder = null;
function GestureRecorder(options) {
    this.options = options;
    recorder = this;

    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        initializeRecorder();
    } else {
        appendAlert(options.alertTarget, ALERT_WEB_RTC_NOT_SUPPORTED);
        console.log('Native device media streaming (getUserMedia) not supported in this browser.');
    }
}


function resetRecorder() {
    if (recordRTC) {
        recordRTC.clearRecordedData();
    }

    if (liveStream) {
        if (liveStream.getAudioTracks()[0])
            liveStream.getAudioTracks()[0].stop();
        if (liveStream.getVideoTracks()[0])
            liveStream.getVideoTracks()[0].stop();
    }
}

function initializeRecorder() {
    clearAlerts(recorder.options.alertTarget);
    resetRecorder();

    if (recorder.options.initMediaStream === false) {
        successCallback(null);
    } else {
        var mediaConstraints = {video: true, audio: false};
        navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
    }
}

function errorCallback(error) {
    alert(error);
    // maybe another application is using the device
}

var recordRTC, liveStream;
function successCallback(stream) {
    switch (recorder.options.startState) {
        case EVENT_GR_STATE_PLAYBACK:
            initPlayback(recorder.options.videoUrl);
//            $('.recorder #recorder-video').attr('src', recorder.options.videoUrl);
//            showPlayback();
            break;
        default:
            liveStream = stream;
            $(recorder.options.recorderTarget).find('#recorder-video').attr('src', URL.createObjectURL(stream));
            showRecord();
            break;
    }
}

var timerTween = null;
function showRecord() {
    $(recorder.options.recorderTarget).trigger(EVENT_GR_UPDATE_STATE, [EVENT_GR_STATE_RECORD]);
    $(recorder.options.recorderTarget).find('.recorder #btn-record').removeClass('hidden');
    $(recorder.options.recorderTarget).find('.recorder #btn-record-stop').addClass('hidden');
    $(recorder.options.recorderTarget).find('.recorder #recorder-video').removeClass('hidden');
    $(recorder.options.recorderTarget).find('.recorder .gesture-recorder-controls').removeClass('hidden');
    $(recorder.options.recorderTarget).find('.recorder #recorder-video').removeAttr('loop');
    $(recorder.options.recorderTarget).find('#recorder-video').css({borderRadius: "4px", borderBottomLeftRadius: "0px", borderBottomRightRadius: "0px"});
    $(recorder.options.recorderTarget).find('.recorder #record-controls').removeClass('hidden');
    $(recorder.options.recorderTarget).find('.recorder #playback-controls').addClass('hidden');
    $(recorder.options.recorderTarget).find('.recorder #preview-controls').addClass('hidden');
    $(recorder.options.recorderTarget).find('.recorder #trim-controls').addClass('hidden');
    $(recorder.options.recorderTarget).find('#record-timer-progress').removeClass('hidden');
    $(recorder.options.recorderTarget).find('#record-timer-progress-bar').css({width: '100%'});
    hideSave();
    resetTrimControls();

    $(recorder.options.recorderTarget).find('#btn-record').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(this).addClass('hidden');
        $(recorder.options.recorderTarget).find('#btn-record-stop').removeClass('hidden');

        var options = {
            type: 'video',
            mimeType: 'video/webm', // or video/mp4 or audio/ogg
            video: {
                width: 320,
                height: 240
            },
            recorderType: RecordRTC.WhammyRecorder,
            frameInterval: 40   // setTimeout interval, quality strength
        };
        recordRTC = RecordRTC(liveStream, options);
        recordRTC.startRecording();

        timerTween = TweenMax.to($(recorder.options.recorderTarget).find('#record-timer-progress-bar'), 20, {width: '0%', ease: Linear.easeNone, onComplete: onRecordingTimesUp});
    });

    function onRecordingTimesUp() {
        $(recorder.options.recorderTarget).find('#btn-record-stop').click();
    }

    $(recorder.options.recorderTarget).find('#btn-record-stop').unbind('click').bind('click', function (event) {
        if (timerTween) {
            timerTween.kill();
        }

        event.preventDefault();
        if (liveStream) {
            liveStream.getVideoTracks()[0].stop();
        }

        if (recordRTC) {
            recordRTC.stopRecording(function (videoUrl) {
                initPlayback(videoUrl);
            });
        }
    });

    $(recorder.options.recorderTarget).find('.btn-repeat-recording').unbind('click').bind('click', function (event) {
        event.preventDefault();
        initializeRecorder();
    });
}

function initPlayback(videoUrl) {
    var videoHolder = $(recorder.options.recorderTarget).find('#recorder-video');
    $(videoHolder).attr('src', videoUrl);
    $(videoHolder).on('loadedmetadata', function () {
        // google chrome no-duration workaround
        if (videoHolder[0].duration === Infinity) {
//            var duration = getSeconds(getTimeBetweenTimestamps(testerResults.startRecordingTime, testerResults.endRecordingTime), true);
            console.log('no duration!');
//            videoHolder[0].currentTime = duration - 2;
            videoHolder[0].playbackRate = 100;
            videoHolder[0].muted = true;

            $(videoHolder).on('ended', function () {
                console.log('on gesture record play ended');
                $(videoHolder).unbind('ended');
                videoHolder[0].playbackRate = 1;
                videoHolder[0].muted = false;
                videoHolder[0].currentTime = 0;
                showPlayback();
            });

            setTimeout(function () {
                videoHolder[0].play();
            }, 150);
        } else {
            showPlayback();
        }
    });
}

var gestureStartMarked = false;
function showPlayback() {
    $(recorder.options.recorderTarget).trigger(EVENT_GR_UPDATE_STATE, [EVENT_GR_STATE_PLAYBACK]);
    $(recorder.options.recorderTarget).find('.recorder #recorder-video').attr('loop', 'loop');
    $(recorder.options.recorderTarget).find('#recorder-video').css({borderRadius: "4px", borderBottomLeftRadius: "0px", borderBottomRightRadius: "0px"});
    $(recorder.options.recorderTarget).find('.recorder #record-controls').addClass('hidden');
    $(recorder.options.recorderTarget).find('.recorder #preview-controls').addClass('hidden');
    $(recorder.options.recorderTarget).find('.recorder #playback-controls, .recorder .gesture-recorder-controls, .recorder #recorder-video').removeClass('hidden');
    $(recorder.options.recorderTarget).find('#record-timer-progress').addClass('hidden');
    hideSave();

    $(recorder.options.recorderTarget).find('.recorder #recorder-video').unbind('timeupdate').bind('timeupdate', function () {
        var percent = $(this)[0].currentTime / $(this)[0].duration * 100;
        $(recorder.options.recorderTarget).find('.recorder #seek-bar .progress-bar').css({width: percent + '%'});
    });

    if (recorder.options.allowRerecordGesture === false) {
        $(recorder.options.recorderTarget).find('.btn-repeat-recording').remove();
    }
    $(recorder.options.recorderTarget).find('.recorder #btn-play').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(recorder.options.recorderTarget).find('.recorder #recorder-video')[0].play();
    });
    $(recorder.options.recorderTarget).find('.recorder #btn-pause').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(recorder.options.recorderTarget).find('.recorder #recorder-video')[0].pause();
    });
    $(recorder.options.recorderTarget).find('.recorder #btn-stop').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(recorder.options.recorderTarget).find('.recorder #recorder-video')[0].pause();
        $(recorder.options.recorderTarget).find('.recorder #recorder-video')[0].currentTime = 0;
    });

    $(recorder.options.recorderTarget).find('#btn-repeat-trimming').unbind('click').bind('click', function (event) {
        event.preventDefault();
        showPlayback();
    });

    // seekbar operations
    $(recorder.options.recorderTarget).find('.recorder #seek-bar, .recorder #trim-bar').unbind('mousedown').bind('mousedown', function (event) {
        event.preventDefault();
        var video = $(recorder.options.recorderTarget).find('#recorder-video')[0];
        var seekbar = $(recorder.options.recorderTarget).find('#seek-bar');
        video.pause();
        $(window).unbind('mousemove').bind('mousemove', function (event) {
            var positionX = Math.max(0, Math.min(Math.round(event.pageX - $(seekbar).offset().left), $(seekbar).width()));

            var time = video.duration * (positionX / $(seekbar).width());
            video.currentTime = Math.min(time, video.duration - 0.0001);
        });
        $(window).on('mouseup', function () {
            $(window).unbind('mousemove');
        });
        clearAlerts($(recorder.options.recorderTarget).find('#playback-controls'));
    });

    $(recorder.options.recorderTarget).find('#seek-bar, .recorder #trim-bar').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var positionX = Math.abs(event.pageX - $(this).offset().left);
        var video = $(recorder.options.recorderTarget).find('#recorder-video')[0];
        var time = video.duration * (positionX / $(this).width());
        video.currentTime = time;
        clearAlerts($(recorder.options.recorderTarget).find('#playback-controls'));
    });

    // trim operations
    $(recorder.options.recorderTarget).find('.recorder #btn-mark-start').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var video = $(recorder.options.recorderTarget).find('#recorder-video')[0];
        video.pause();

        var totalWidth = $(recorder.options.recorderTarget).find('#seek-bar').width();
        var beginningWidth = $(recorder.options.recorderTarget).find('#seek-bar .progress-bar').width();
        if (!gestureStartMarked) {
            gestureStartMarked = true;
            $('.recorder #btn-mark-end').removeClass('disabled');
        }
        var currentBeginningWidth = $(recorder.options.recorderTarget).find('#gesture-beginning').width();
        var currentGestureWidth = $(recorder.options.recorderTarget).find('#gesture-execution').width();
        if (beginningWidth < currentBeginningWidth + currentGestureWidth) {
            var currentEndingWidth = $(recorder.options.recorderTarget).find('#gesture-ending').width();
            $(recorder.options.recorderTarget).find('#gesture-beginning').css({width: beginningWidth + 'px'});
            $(recorder.options.recorderTarget).find('#gesture-execution').css({width: (totalWidth - currentEndingWidth - beginningWidth) + 'px'});
        }
        clearAlerts($(recorder.options.recorderTarget).find('#playback-controls'));
    });

    $(recorder.options.recorderTarget).find('.recorder #btn-mark-end').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var video = $(recorder.options.recorderTarget).find('#recorder-video')[0];
        video.pause();

        var currentSeekWidth = $(recorder.options.recorderTarget).find('#seek-bar .progress-bar').width();
        var beginningWidth = $(recorder.options.recorderTarget).find('#gesture-beginning').width();
        if (gestureStartMarked && currentSeekWidth > beginningWidth) {
            $(recorder.options.recorderTarget).find('#btn-extract-gesture').removeClass('disabled');

            var totalWidth = $(recorder.options.recorderTarget).find('#seek-bar').width();
            var gestureWidth = currentSeekWidth - beginningWidth;
            var endingWidth = totalWidth - (beginningWidth + gestureWidth);
            $(recorder.options.recorderTarget).find('#gesture-execution').css({width: gestureWidth + 'px'});
            $(recorder.options.recorderTarget).find('#gesture-ending').css({width: endingWidth + 'px'});
        } else if (!gestureStartMarked) {
            wobble($(recorder.options.recorderTarget).find('#btn-mark-start'));
        }
        clearAlerts($(recorder.options.recorderTarget).find('#playback-controls'));
    });

    // trim operations, take screenshots and render the gesture preview based on the images (screenshots)
    $('.recorder #btn-extract-gesture').unbind('click').bind('click', function (event) {
        event.preventDefault();

        if (!$(this).hasClass('disabled')) {
            var video = $(recorder.options.recorderTarget).find('#recorder-video')[0];

            $(recorder.options.recorderTarget).find('#recorder-video').removeAttr('loop');
            $(recorder.options.recorderTarget).find('#recorder-video').css({borderRadius: "4px"});
            $(recorder.options.recorderTarget).find('#btn-stop').click();

            var totalWidth = $(recorder.options.recorderTarget).find('#seek-bar').width();
            var startTimeOffset = ($(recorder.options.recorderTarget).find('#gesture-beginning').width() / totalWidth) * video.duration;
            var endTimeOffset = (($(recorder.options.recorderTarget).find('#gesture-beginning').width() + $(recorder.options.recorderTarget).find('#gesture-execution').width()) / totalWidth) * video.duration;
            $(recorder.options.recorderTarget).find('#playback-controls').addClass('hidden');

            // take screenshots every x milliseconds (based on the chosen milliseconds)
            var keyframes = $(recorder.options.recorderTarget).find('#keyframeSelect .chosen').attr('id').split('_')[1];
            var shotsArray = new Array();
            video.currentTime = startTimeOffset;

            video.addEventListener('play', function () {
                var canvas = document.createElement('canvas');
                canvas.width = $(recorder.options.recorderTarget).find('#recorder-video').width();
                canvas.height = $(recorder.options.recorderTarget).find('#recorder-video').height();
                var ctx_draw = canvas.getContext('2d');
                draw_interval = setInterval(function () {
                    ctx_draw.drawImage(video, 0, 0, canvas.width, canvas.height);
                    shotsArray.push(canvas.toDataURL('image/jpeg'));
                }, keyframes);
            }, false);

            $(recorder.options.recorderTarget).find('#btn-play').click();

            setTimeout(offsetReached, (endTimeOffset - startTimeOffset) * 1000);
            function offsetReached() {
                clearInterval(draw_interval);
                video.pause();
                if (shotsArray.length > 0) {
                    console.log(shotsArray.length, shotsArray);
                    renderGestureImages($(recorder.options.recorderTarget).find('#preview-controls .previewGesture'), shotsArray, 0, function () {
                        showPreview();
                        showSave();
                    });
                } else {
                    console.log('gesture too short');
                    appendAlert($(recorder.options.recorderTarget).find('#playback-controls'), ALERT_GESTURE_TOO_SHORT);
                    showPlayback();
                }
            }
        } else {
            wobble($(recorder.options.recorderTarget).find('#btn-mark-start,#btn-mark-end'));
        }
    });
}

function resetTrimControls() {
    gestureStartMarked = false;
    $(recorder.options.recorderTarget).find('#gesture-beginning').css({width: '100%'});
    $(recorder.options.recorderTarget).find('#gesture-execution').css({width: '0%'});
    $(recorder.options.recorderTarget).find('#gesture-ending').css({width: '0%'});
    $(recorder.options.recorderTarget).find('#btn-mark-end, #btn-extract-gesture').addClass('disabled');
}

function showPreview() {
    $(recorder.options.recorderTarget).find('#preview-controls').removeClass('hidden');
    $(recorder.options.recorderTarget).find('#preview-controls #gesturePreview').addClass('previewProgress');
    $(recorder.options.recorderTarget).find('#recorder-video').addClass('hidden');
    $(recorder.options.recorderTarget).find('.gesture-recorder-controls').addClass('hidden');
}

function showSave() {
    $(recorder.options.recorderTarget).trigger(EVENT_GR_UPDATE_STATE, [EVENT_GR_STATE_SAVE]);
    $(recorder.options.recorderTarget).find('#save-controls').removeClass('hidden');

    if (recorder.options.context) {
        $(recorder.options.recorderTarget).find('#gestureContext').val(recorder.options.context);
    }

    $('#gestureName, #gestureContext, #gestureAssociation, #gestureDescription').unbind('input').bind('input', function () {
        if (gestureInputsValid()) {
            $(recorder.options.recorderTarget).find('#btn-save-gesture').removeClass('disabled');
        } else {
            $(recorder.options.recorderTarget).find('#btn-save-gesture').addClass('disabled');
        }
    });

    $('#gestureTypeSelect, #gestureInteractionTypeSelect').unbind('change').bind('change', function () {
//        console.log('on change');
        if (gestureInputsValid()) {
            $(recorder.options.recorderTarget).find('#btn-save-gesture').removeClass('disabled');
        } else {
            $(recorder.options.recorderTarget).find('#btn-save-gesture').addClass('disabled');
        }
    });

    $('#save-controls #human-body').unbind('change').bind('change', function () {
        if (gestureInputsValid()) {
            $(recorder.options.recorderTarget).find('#btn-save-gesture').removeClass('disabled');
        } else {
            $(recorder.options.recorderTarget).find('#btn-save-gesture').addClass('disabled');
        }
    });

    if ($(recorder.options.recorderTarget).find('#btn-choose-preview-image').hasClass('active')) {
        $(recorder.options.recorderTarget).find('#btn-choose-preview-image').removeClass('active');
        $(recorder.options.recorderTarget).find('#btn-choose-preview-image').find('.text').text(translation.choosePreviewImage);
        $(recorder.options.recorderTarget).find('#btn-choose-preview-image').find('.fa').removeClass('fa-check').addClass('fa-bookmark');
    }

    $(recorder.options.recorderTarget).find('#btn-choose-preview-image').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if ($(this).hasClass('active')) {
            $('.recorder #preview-controls').find('#btn-stop-gesture').click();
            $(this).removeClass('active');
            $(this).find('.text').text(translation.choosePreviewImage);
            $(this).find('.fa').removeClass('fa-check').addClass('fa-bookmark');
            $('.recorder #gesturePreview').removeClass('mouseScrollable');
            $('.recorder #gesturePreview').unbind('click');
        } else {
            $('.recorder #preview-controls').find('#btn-stop-gesture').click();
            $(this).addClass('active');
            $(this).find('.text').text(translation.stopChoosePreviewImage);
            $(this).find('.fa').removeClass('fa-bookmark').addClass('fa-check');
            $('.recorder #gesturePreview').addClass('mouseScrollable');

            $('.recorder #gesturePreview').unbind('click').bind('click', function (event) {
                event.preventDefault();
                var previewImage = $(this).children('.previewImage');
                previewImage.removeClass('previewImage');
                var visibleImage = $(this).children('.active');
                visibleImage.addClass('previewImage');
            });
        }
    });

    $(recorder.options.recorderTarget).find('#btn-save-gesture').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var button = $(this);
        clearAlerts(recorder.options.alertTarget);

        if (gestureInputsValid(true) && !$(this).hasClass('disabled')) {
            lockButton(button, true, 'fa-floppy-o');
//            $(button).addClass('disabled');
            showCursor($('body'), CURSOR_PROGRESS);

            $(recorder.options.recorderTarget).find('#btn-choose-preview-image').removeClass('active');

            var gestureImagesData = getGestureImagesData($(recorder.options.recorderTarget).find('#gesturePreview'));
            var previewImageIndex = getGesturePreviewIndex($(recorder.options.recorderTarget).find('#gesturePreview'));
            var title = $(recorder.options.recorderTarget).find('#gestureName').val().trim();
            var type = null;
            var interactionType = null;
            var context = $(recorder.options.recorderTarget).find('#gestureContext').val().trim();
            var association = $(recorder.options.recorderTarget).find('#gestureAssociation').val().trim();
            var description = $(recorder.options.recorderTarget).find('#gestureDescription').val().trim();
            var joints = getSelectedJoints($(recorder.options.recorderTarget).find('#human-body #joint-container'));

            if (recorder.options.checkType && recorder.options.checkType === true) {
                type = $(recorder.options.recorderTarget).find('#gestureTypeSelect .btn-option-checked').attr('id');
            }

            if (recorder.options.checkInteractionType && recorder.options.checkInteractionType === true) {
                interactionType = $(recorder.options.recorderTarget).find('#gestureInteractionTypeSelect .btn-option-checked').attr('id');
            }

            if (recorder.options.saveGestures && recorder.options.saveGestures === true) {
                if (gestureImagesData && gestureImagesData.length > 0) {
                    var uploadQueue = new UploadQueue();
                    $(uploadQueue).bind(EVENT_ALL_FILES_UPLOADED, function () {
                        var imagesURLs = uploadQueue.getUploadURLs();

                        var gifUploadQueue = new UploadQueue();
                        $(gifUploadQueue).bind(EVENT_ALL_FILES_UPLOADED, function () {
                            var gifUrl = gifUploadQueue.getUploadURLs();

                            var ownerId = recorder.options.ownerId || null;
                            saveRecordedGesture({title: title, type: type, interactionType: interactionType, context: context, association: association, description: description, joints: joints, previewImage: previewImageIndex, gestureImages: imagesURLs, ownerId: ownerId, gif: gifUrl[0]}, function (result) {
                                showCursor($('body'), CURSOR_DEFAULT);
                                unlockButton(button, true, 'fa-floppy-o');

                                if (result.status === RESULT_SUCCESS) {
                                    var gesture = {
                                        id: result.gestureId,
                                        title: title,
                                        context: context,
                                        association: association,
                                        description: description,
                                        joints: joints,
                                        previewImage: previewImageIndex,
                                        images: imagesURLs
                                    };

                                    $(recorder.options.recorderTarget).trigger(EVENT_GR_SAVE_SUCCESS, [gesture]);
                                    $(recorder.options.recorderTarget).find('#success-controls #btn-delete-saved-gesture').attr('name', result.gestureId);
                                    renderGestureImages($(recorder.options.recorderTarget).find('#success-controls .previewGesture'), result.images, result.previewImage, null);
                                    showSaveSuccess();
                                } else if (result.status === RESULT_ERROR) {
                                    appendAlert(recorder.options.alertTarget, ALERT_GENERAL_ERROR);
                                }
                            });
                        });

                        // create gif from gesture images
                        gifshot.createGIF({
                            gifWidth: 320,
                            gifHeight: 240,
                            images: imagesURLs,
                            interval: 0.1,
                            numFrames: 10,
                            frameDuration: 1,
                            sampleInterval: 3,
                            numWorkers: 2
                        }, function (obj) {
                            if (!obj.error) {
                                var blob = dataURItoBlob(obj.image);
                                var filename = hex_sha512(new Date().getTime() + "" + i) + ".gif";
                                gifUploadQueue.upload([blob], filename);
                            }
                        });
                    });

                    for (var i = 0; i < gestureImagesData.length; i++) {
                        var blob = dataURItoBlob(gestureImagesData[i]);
                        var filename = hex_sha512(new Date().getTime() + "" + i) + ".jpg";
                        uploadQueue.upload([blob], filename);
                    }
                }
            } else {
                showCursor($('body'), CURSOR_DEFAULT);
                $(button).removeClass('disabled');
                $(recorder.options.recorderTarget).find('#success-controls #btn-delete-saved-gesture').addClass('disabled');
                renderGestureImages($(recorder.options.recorderTarget).find('#success-controls .previewGesture'), gestureImagesData, previewImageIndex, null);
                $(recorder.options.recorderTarget).trigger(EVENT_GR_SAVE_SUCCESS);
                showSaveSuccess();
            }
        }
    });
}

function hideSave() {
    $(recorder.options.recorderTarget).find('#save-controls').addClass('hidden');
    $(recorder.options.recorderTarget).find('#btn-save-gesture').unbind('click');
}

function resetInputs() {
    $(recorder.options.recorderTarget).find('#gestureName').val('');
    $(recorder.options.recorderTarget).find('#gestureContext').val('');
    $(recorder.options.recorderTarget).find('#gestureAssociation').val('');
    $(recorder.options.recorderTarget).find('#gestureTypeSelect .chosen').attr('id', 'unselected');
    $(recorder.options.recorderTarget).find('#gestureTypeSelect .selected').removeClass('selected');
    $(recorder.options.recorderTarget).find('.option-gesture-type').val('');
    $(recorder.options.recorderTarget).find('#gestureInteractionTypeSelect .chosen').attr('id', 'unselected');
    $(recorder.options.recorderTarget).find('#gestureInteractionTypeSelect .selected').removeClass('selected');
    $(recorder.options.recorderTarget).find('.option-gesture-interaction-type').val('');
    $(recorder.options.recorderTarget).find('#gestureDescription').val('');
    $(recorder.options.recorderTarget).find('#save-controls #human-body #joint-container').children('.active').click();
    $(recorder.options.recorderTarget).find('#save-controls #btn-save-gesture').addClass('disabled');
}

function gestureInputsValid(showErrors) {
    var title = $(recorder.options.recorderTarget).find('#gestureName').val();
    if (title !== undefined && title.trim() === '') {
        if (showErrors) {
            appendAlert($(recorder.options.recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        } else {
            removeAlert($(recorder.options.recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        }
        return false;
    }

    if (recorder.options.checkType && recorder.options.checkType === true) {
        var type = $(recorder.options.recorderTarget).find('#gestureTypeSelect .btn-option-checked').attr('id');
        if (type === undefined) {
            if (showErrors) {
                appendAlert($(recorder.options.recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
            } else {
                removeAlert($(recorder.options.recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
            }
            return false;
        }
    }

    if (recorder.options.checkInteractionType && recorder.options.checkInteractionType === true) {
        var interactionType = $(recorder.options.recorderTarget).find('#gestureInteractionTypeSelect .btn-option-checked').attr('id');
        if (interactionType === undefined) {
            if (showErrors) {
                appendAlert($(recorder.options.recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
            } else {
                removeAlert($(recorder.options.recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
            }
            return false;
        }
    }

    var context = $(recorder.options.recorderTarget).find('#gestureContext').val();
    if (context !== undefined && context.trim() === '') {
        if (showErrors) {
            appendAlert($(recorder.options.recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        } else {
            removeAlert($(recorder.options.recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        }
        return false;
    }

    var association = $(recorder.options.recorderTarget).find('#gestureAssociation').val();
    if (association !== undefined && association.trim() === '') {
        if (showErrors) {
            appendAlert($(recorder.options.recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        } else {
            removeAlert($(recorder.options.recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        }
        return false;
    }

    var description = $(recorder.options.recorderTarget).find('#gestureDescription').val();
    if (description !== undefined && description.trim() === "") {
        if (showErrors) {
            appendAlert($(recorder.options.recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        } else {
            removeAlert($(recorder.options.recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        }
        return false;
    }

    var selectedJoints = getSelectedJoints($(recorder.options.recorderTarget).find('#save-controls #human-body #joint-container'));
    if (selectedJoints.length === 0) {
        if (showErrors) {
            appendAlert($(recorder.options.recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        } else {
            removeAlert($(recorder.options.recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        }
        return false;
    }

//    var gestureImagesData = getGestureImagesData($(recorder.options.recorderTarget).find('.recorder #gesturePreview'));
//    if (gestureImagesData.length === 0) {
//        if (showErrors) {
//            appendAlert($(recorder.options.recorderTarget).find('#preview-controls'), ALERT_GESTURE_TOO_SHORT);
//        } else {
//            removeAlert($(recorder.options.recorderTarget).find('#preview-controls'), ALERT_GESTURE_TOO_SHORT);
//        }
//        return false;
//    }
    return true;
}

function showSaveSuccess() {
    $(recorder.options.recorderTarget).trigger(EVENT_GR_UPDATE_STATE, [EVENT_GR_STATE_SAVE_SUCCESS]);
    resetInputs();
    appendAlert($(recorder.options.recorderTarget).find('#success-controls'), ALERT_GESTURE_SAVE_SUCCESS);
    $(recorder.options.recorderTarget).find('#success-controls').removeClass('hidden');
    $(recorder.options.recorderTarget).find('.recorder').addClass('hidden');
    hideSave();

    if (recorder.options.allowDeletingGesture === false) {
        $(recorder.options.recorderTarget).find('#success-controls #btn-delete-saved-gesture').addClass('hidden');
    }
    $(recorder.options.recorderTarget).find('#success-controls #btn-delete-saved-gesture').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            var button = $(this);
            $(button).addClass('disabled');

            var gestureId = $(this).attr('name');
            deleteLastRecordedGesture(gestureId, button);
        } else {
//            $(this).removeClass('disabled');
        }
    });

    if (recorder.options.allowRerecordGesture === false) {
        $(recorder.options.recorderTarget).find('#success-controls #btn-record-new-gesture').remove();
    }
    $(recorder.options.recorderTarget).find('#success-controls #btn-record-new-gesture').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(recorder.options.recorderTarget).find('.recorder').removeClass('hidden');
        $(recorder.options.recorderTarget).find('#success-controls').addClass('hidden');
        initializeRecorder();
    });
}

function deleteLastRecordedGesture(gestureId, deleteButton) {
    showCursor($('body'), CURSOR_PROGRESS);
    deleteGesture({gestureId: gestureId}, function (result) {
        showCursor($('body'), CURSOR_DEFAULT);
        $(deleteButton).removeClass('disabled');

        if (result.status === RESULT_SUCCESS) {
            $(recorder.options.recorderTarget).trigger(EVENT_GR_DELETE_SUCCESS, [gestureId]);
            $(recorder.options.recorderTarget).find('#success-controls').addClass('hidden');
            showDeleteSuccess();
        } else {
            appendAlert(recorder.options.alertTarget, ALERT_GENERAL_ERROR);
        }
    });
}

function showDeleteSuccess() {
    $(recorder.options.recorderTarget).trigger(EVENT_GR_UPDATE_STATE, [EVENT_GR_STATE_DELETE_SUCCESS]);
    appendAlert($(recorder.options.recorderTarget).find('#delete-success-controls'), ALERT_GESTURE_DELETE_SUCCESS);
    $(recorder.options.recorderTarget).find('#delete-success-controls').removeClass('hidden');
    $(recorder.options.recorderTarget).find('#delete-success-controls #btn-record-new-gesture').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(recorder.options.recorderTarget).find('.recorder').removeClass('hidden');
        $(recorder.options.recorderTarget).find('#delete-success-controls').addClass('hidden');
        initializeRecorder();
    });
}

//function download() {
//    var blob = new Blob(recordedBlobs, {type: 'video/webm'});
//    var url = window.URL.createObjectURL(blob);
//    var a = document.createElement('a');
//    a.style.display = 'none';
//    a.href = url;
//    a.download = 'test.webm';
//    document.body.appendChild(a);
//    a.click();
//    setTimeout(function () {
//        document.body.removeChild(a);
//        window.URL.revokeObjectURL(url);
//    }, 100);
//}