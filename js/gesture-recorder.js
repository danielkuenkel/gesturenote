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

/*
 * global gesture variables
 */
var alertTarget = null;
var saveGesture = false;
var recorderTarget = null;
var ownerId = null;

function initCheckRecorder(aTarget, rTarget, canSaveGesture, oId) {
    alertTarget = aTarget;
    recorderTarget = rTarget;
    saveGesture = canSaveGesture;
    ownerId = oId;

    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        initializeRecorder();
    } else {
        appendAlert(alertTarget, ALERT_WEB_RTC_NOT_SUPPORTED);
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
    clearAlerts(alertTarget);
    resetRecorder();

    var mediaConstraints = {video: true, audio: false};
    navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
}

function errorCallback(error) {
    alert(error);
    // maybe another application is using the device
}

var recordRTC, liveStream;
function successCallback(stream) {
    liveStream = stream;
    $(recorderTarget).find('#recorder-video').attr('src', URL.createObjectURL(stream));
    showRecord();
}

var timerTween = null;
function showRecord() {
    $(recorderTarget).trigger(EVENT_GR_UPDATE_STATE, [EVENT_GR_STATE_RECORD]);
    $(recorderTarget).find('.recorder #btn-record').removeClass('hidden');
    $(recorderTarget).find('.recorder #btn-record-stop').addClass('hidden');
    $(recorderTarget).find('.recorder #recorder-video').removeClass('hidden');
    $(recorderTarget).find('.recorder .gesture-recorder-controls').removeClass('hidden');
    $(recorderTarget).find('.recorder #recorder-video').removeAttr('loop');
    $(recorderTarget).find('#recorder-video').css({borderRadius: "4px", borderBottomLeftRadius: "0px", borderBottomRightRadius: "0px"});
    $(recorderTarget).find('.recorder #record-controls').removeClass('hidden');
    $(recorderTarget).find('.recorder #playback-controls').addClass('hidden');
    $(recorderTarget).find('.recorder #preview-controls').addClass('hidden');
    $(recorderTarget).find('.recorder #trim-controls').addClass('hidden');
    $(recorderTarget).find('#record-timer-progress').removeClass('hidden');
    $(recorderTarget).find('#record-timer-progress-bar').css({width: '100%'});
    hideSave();
    resetTrimControls();

    $(recorderTarget).find('#btn-record').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(this).addClass('hidden');
        $(recorderTarget).find('#btn-record-stop').removeClass('hidden');

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

        timerTween = TweenMax.to($(recorderTarget).find('#record-timer-progress-bar'), 20, {width: '0%', ease: Linear.easeNone, onComplete: onRecordingTimesUp});
    });

    function onRecordingTimesUp() {
        $(recorderTarget).find('#btn-record-stop').click();
    }

    $(recorderTarget).find('#btn-record-stop').unbind('click').bind('click', function (event) {
        if (timerTween) {
            timerTween.kill();
        }

        event.preventDefault();
        if (liveStream) {
            liveStream.getVideoTracks()[0].stop();
        }

        if (recordRTC) {
            recordRTC.stopRecording(function (videoUrl) {
                $('.recorder #recorder-video').attr('src', videoUrl);
                showPlayback();
            });
        }
    });

    $(recorderTarget).find('.btn-repeat-recording').unbind('click').bind('click', function (event) {
        event.preventDefault();
        initializeRecorder();
    });
}

var gestureStartMarked = false;
function showPlayback() {
    $(recorderTarget).trigger(EVENT_GR_UPDATE_STATE, [EVENT_GR_STATE_PLAYBACK]);
    $(recorderTarget).find('.recorder #recorder-video').attr('loop', 'loop');
    $(recorderTarget).find('#recorder-video').css({borderRadius: "4px", borderBottomLeftRadius: "0px", borderBottomRightRadius: "0px"});
    $(recorderTarget).find('.recorder #record-controls').addClass('hidden');
    $(recorderTarget).find('.recorder #preview-controls').addClass('hidden');
    $(recorderTarget).find('.recorder #playback-controls, .recorder .gesture-recorder-controls, .recorder #recorder-video').removeClass('hidden');
    $(recorderTarget).find('#record-timer-progress').addClass('hidden');
    hideSave();

    $(recorderTarget).find('.recorder #recorder-video').unbind('timeupdate').bind('timeupdate', function () {
        var percent = $(this)[0].currentTime / $(this)[0].duration * 100;
        $(recorderTarget).find('.recorder #seek-bar .progress-bar').css({width: percent + '%'});
    });

    $(recorderTarget).find('.recorder #btn-play').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(recorderTarget).find('.recorder #recorder-video')[0].play();
    });
    $(recorderTarget).find('.recorder #btn-pause').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(recorderTarget).find('.recorder #recorder-video')[0].pause();
    });
    $(recorderTarget).find('.recorder #btn-stop').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(recorderTarget).find('.recorder #recorder-video')[0].pause();
        $(recorderTarget).find('.recorder #recorder-video')[0].currentTime = 0;
    });

    $(recorderTarget).find('#btn-repeat-trimming').unbind('click').bind('click', function (event) {
        event.preventDefault();
        showPlayback();
    });

    // seekbar operations
    $(recorderTarget).find('.recorder #seek-bar, .recorder #trim-bar').unbind('mousedown').bind('mousedown', function (event) {
        event.preventDefault();
        var video = $(recorderTarget).find('#recorder-video')[0];
        var seekbar = $(recorderTarget).find('#seek-bar');
        video.pause();
        $(window).unbind('mousemove').bind('mousemove', function (event) {
            var positionX = Math.max(0, Math.min(Math.round(event.pageX - $(seekbar).offset().left), $(seekbar).width()));

            var time = video.duration * (positionX / $(seekbar).width());
            video.currentTime = Math.min(time, video.duration - 0.0001);
        });
        $(window).on('mouseup', function () {
            $(window).unbind('mousemove');
        });
    });
    $(recorderTarget).find('#seek-bar, .recorder #trim-bar').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var positionX = Math.abs(event.pageX - $(this).offset().left);
        var video = $(recorderTarget).find('#recorder-video')[0];
        var time = video.duration * (positionX / $(this).width());
        video.currentTime = time;
    });

    // trim operations
    $(recorderTarget).find('.recorder #btn-mark-start').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var video = $(recorderTarget).find('#recorder-video')[0];
        video.pause();

        var totalWidth = $(recorderTarget).find('#seek-bar').width();
        var beginningWidth = $(recorderTarget).find('#seek-bar .progress-bar').width();
        if (!gestureStartMarked) {
            gestureStartMarked = true;
            $('.recorder #btn-mark-end').removeClass('disabled');
        }
        var currentBeginningWidth = $(recorderTarget).find('#gesture-beginning').width();
        var currentGestureWidth = $(recorderTarget).find('#gesture-execution').width();
        if (beginningWidth < currentBeginningWidth + currentGestureWidth) {
            var currentEndingWidth = $(recorderTarget).find('#gesture-ending').width();
            $(recorderTarget).find('#gesture-beginning').css({width: beginningWidth + 'px'});
            $(recorderTarget).find('#gesture-execution').css({width: (totalWidth - currentEndingWidth - beginningWidth) + 'px'});
        }
    });

    $(recorderTarget).find('.recorder #btn-mark-end').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var video = $(recorderTarget).find('#recorder-video')[0];
        video.pause();

        var currentSeekWidth = $(recorderTarget).find('#seek-bar .progress-bar').width();
        var beginningWidth = $(recorderTarget).find('#gesture-beginning').width();
        if (gestureStartMarked && currentSeekWidth > beginningWidth) {
            $(recorderTarget).find('#btn-extract-gesture').removeClass('disabled');

            var totalWidth = $(recorderTarget).find('#seek-bar').width();
            var gestureWidth = currentSeekWidth - beginningWidth;
            var endingWidth = totalWidth - (beginningWidth + gestureWidth);
            $(recorderTarget).find('#gesture-execution').css({width: gestureWidth + 'px'});
            $(recorderTarget).find('#gesture-ending').css({width: endingWidth + 'px'});
        } else if (!gestureStartMarked) {
            wobble($(recorderTarget).find('#btn-mark-start'));
        }
    });

    // trim operations, take screenshots and render the gesture preview based on the images (screenshots)
    $('.recorder #btn-extract-gesture').unbind('click').bind('click', function (event) {
        event.preventDefault();

        if (!$(this).hasClass('disabled')) {
            var video = $(recorderTarget).find('#recorder-video')[0];

            $(recorderTarget).find('#recorder-video').removeAttr('loop');
            $(recorderTarget).find('#recorder-video').css({borderRadius: "4px"});
            $(recorderTarget).find('#btn-stop').click();

            var totalWidth = $(recorderTarget).find('#seek-bar').width();
            var startTimeOffset = ($(recorderTarget).find('#gesture-beginning').width() / totalWidth) * video.duration;
            var endTimeOffset = (($(recorderTarget).find('#gesture-beginning').width() + $(recorderTarget).find('#gesture-execution').width()) / totalWidth) * video.duration;
            $(recorderTarget).find('#playback-controls').addClass('hidden');

            // take screenshots every x milliseconds (based on the chosen milliseconds)
            var keyframes = $(recorderTarget).find('#keyframeSelect .chosen').attr('id').split('_')[1];
            var shotsArray = new Array();
            video.currentTime = startTimeOffset;

            video.addEventListener('play', function () {
                var canvas = document.createElement('canvas');
                canvas.width = $(recorderTarget).find('#recorder-video').width();
                canvas.height = $(recorderTarget).find('#recorder-video').height();
                var ctx_draw = canvas.getContext('2d');
                draw_interval = setInterval(function () {
                    ctx_draw.drawImage(video, 0, 0, canvas.width, canvas.height);
                    shotsArray.push(canvas.toDataURL('image/jpeg'));
                }, keyframes);
            }, false);
            $(recorderTarget).find('#btn-play').click();

            setTimeout(offsetReached, (endTimeOffset - startTimeOffset) * 1000);
            function offsetReached() {
                clearInterval(draw_interval);
                video.pause();
                renderGestureImages($(recorderTarget).find('#preview-controls .previewGesture'), shotsArray, 0, function () {
                    showPreview();
                    showSave();
                });
            }
        } else {
            wobble($(recorderTarget).find('#btn-mark-start,#btn-mark-end'));
        }
    });
}

function resetTrimControls() {
    gestureStartMarked = false;
    $(recorderTarget).find('#gesture-beginning').css({width: '100%'});
    $(recorderTarget).find('#gesture-execution').css({width: '0%'});
    $(recorderTarget).find('#gesture-ending').css({width: '0%'});
    $(recorderTarget).find('#btn-mark-end, #btn-extract-gesture').addClass('disabled');
}

function showPreview() {
    $(recorderTarget).find('#preview-controls').removeClass('hidden');
    $(recorderTarget).find('#preview-controls #gesturePreview').addClass('previewProgress');
    $(recorderTarget).find('#recorder-video').addClass('hidden');
    $(recorderTarget).find('.gesture-recorder-controls').addClass('hidden');
}

function showSave() {
    $(recorderTarget).trigger(EVENT_GR_UPDATE_STATE, [EVENT_GR_STATE_SAVE]);
    $(recorderTarget).find('#save-controls').removeClass('hidden');

    $('#gestureName, #gestureContext, #gestureDescription').unbind('input').bind('input', function () {
        if (inputsValid()) {
            $(recorderTarget).find('#btn-save-gesture').removeClass('disabled');
        } else {
            $(recorderTarget).find('#btn-save-gesture').addClass('disabled');
        }
    });

    $('#save-controls #human-body').unbind('change').bind('change', function () {
        if (inputsValid()) {
            $(recorderTarget).find('#btn-save-gesture').removeClass('disabled');
        } else {
            $(recorderTarget).find('#btn-save-gesture').addClass('disabled');
        }
    });

    $(recorderTarget).find('#btn-choose-preview-image').unbind('click').bind('click', function (event) {
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

    $(recorderTarget).find('#btn-save-gesture').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var button = $(this);
        clearAlerts(alertTarget);

        if (inputsValid(true) && !$(this).hasClass('disabled')) {
            $(button).addClass('disabled');
            showCursor($('body'), CURSOR_PROGRESS);

            $(recorderTarget).find('#btn-choose-preview-image').removeClass('active');

            var gestureImagesData = getGestureImagesData($(recorderTarget).find('#gesturePreview'));
            var previewImageIndex = getGesturePreviewIndex($(recorderTarget).find('#gesturePreview'));
            var title = $(recorderTarget).find('#gestureName').val().trim();
            var context = $(recorderTarget).find('#gestureContext').val().trim();
            var description = $(recorderTarget).find('#gestureDescription').val().trim();
            var joints = getSelectedJoints($(recorderTarget).find('#human-body #joint-container'));

            if (saveGesture) {
                saveRecordedGesture({title: title, context: context, description: description, joints: joints, previewImage: previewImageIndex, gestureImages: gestureImagesData, ownerId: ownerId}, function (result) {
                    showCursor($('body'), CURSOR_DEFAULT);
                    $(button).removeClass('disabled');

                    if (result.status === RESULT_SUCCESS) {
                        $(recorderTarget).trigger(EVENT_GR_SAVE_SUCCESS, [result.gestureId]);
                        $(recorderTarget).find('#success-controls #btn-delete-saved-gesture').attr('name', result.gestureId);
                        renderGestureImages($(recorderTarget).find('#success-controls .previewGesture'), result.images, result.previewImage, null);
                        showSaveSuccess();
                    } else if (result.status === RESULT_ERROR) {
                        appendAlert(alertTarget, ALERT_GENERAL_ERROR);
                    }
                });
            } else {
                showCursor($('body'), CURSOR_DEFAULT);
                $(button).removeClass('disabled');
                $(recorderTarget).find('#success-controls #btn-delete-saved-gesture').addClass('disabled');
                renderGestureImages($(recorderTarget).find('#success-controls .previewGesture'), gestureImagesData, previewImageIndex, null);
                $(recorderTarget).trigger(EVENT_GR_SAVE_SUCCESS);
                showSaveSuccess();
            }
        }
    });
}

function hideSave() {
    $(recorderTarget).find('#save-controls').addClass('hidden');
    $(recorderTarget).find('#btn-save-gesture').unbind('click');
}

function resetInputs() {
    $(recorderTarget).find('#gestureName').val('');
    $(recorderTarget).find('#gestureContext').val('');
    $(recorderTarget).find('#gestureDescription').val('');
    $(recorderTarget).find('#save-controls #human-body #joint-container').children('.active').click();
    $(recorderTarget).find('#save-controls #btn-save-gesture').addClass('disabled');
}

function inputsValid(showErrors) {
    var title = $(recorderTarget).find('#gestureName').val();
    if (title !== undefined && title.trim() === '') {
        if (showErrors) {
            appendAlert($(recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        } else {
            removeAlert($(recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        }
        return false;
    }

    var context = $(recorderTarget).find('#gestureContext').val();
    if (context !== undefined && context.trim() === '') {
        if (showErrors) {
            appendAlert($(recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        } else {
            removeAlert($(recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        }
        return false;
    }

    var description = $(recorderTarget).find('#gestureDescription').val();
    if (description !== undefined && description.trim() === "") {
        if (showErrors) {
            appendAlert($(recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        } else {
            removeAlert($(recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        }
        return false;
    }

    var selectedJoints = getSelectedJoints($(recorderTarget).find('#save-controls #human-body #joint-container'));
    if (selectedJoints.length === 0) {
        if (showErrors) {
            appendAlert($(recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        } else {
            removeAlert($(recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        }
        return false;
    }

    var gestureImagesData = getGestureImagesData($(recorderTarget).find('.recorder #gesturePreview'));
    if (gestureImagesData.length === 0) {
        if (showErrors) {
            appendAlert($(recorderTarget).find('#preview-controls'), ALERT_GESTURE_TOO_SHORT);
        } else {
            removeAlert($(recorderTarget).find('#preview-controls'), ALERT_GESTURE_TOO_SHORT);
        }
        return false;
    }
    return true;
}

function showSaveSuccess() {
    $(recorderTarget).trigger(EVENT_GR_UPDATE_STATE, [EVENT_GR_STATE_SAVE_SUCCESS]);
    resetInputs();
    appendAlert($(recorderTarget).find('#success-controls'), ALERT_GESTURE_SAVE_SUCCESS);
    $(recorderTarget).find('#success-controls').removeClass('hidden');
    $(recorderTarget).find('.recorder').addClass('hidden');
    hideSave();

    $(recorderTarget).find('#success-controls #btn-delete-saved-gesture').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            var button = $(this);
            $(button).addClass('disabled');
            showCursor($('body'), CURSOR_PROGRESS);
            var gestureId = $(this).attr('name');
            deleteGesture({gestureId: gestureId}, function (result) {
                showCursor($('body'), CURSOR_DEFAULT);
                $(button).removeClass('disabled');

                if (result.status === RESULT_SUCCESS) {
                    $(recorderTarget).trigger(EVENT_GR_DELETE_SUCCESS, [gestureId]);
                    $(recorderTarget).find('#success-controls').addClass('hidden');
                    showDeleteSuccess();
                } else {
                    appendAlert(alertTarget, ALERT_GENERAL_ERROR);
                }
            });
        } else {
//            $(this).removeClass('disabled');
        }
    });

    $(recorderTarget).find('#success-controls #btn-record-new-gesture').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(recorderTarget).find('.recorder').removeClass('hidden');
        $(recorderTarget).find('#success-controls').addClass('hidden');
        initializeRecorder();
    });
}

function showDeleteSuccess() {
    $(recorderTarget).trigger(EVENT_GR_UPDATE_STATE, [EVENT_GR_STATE_DELETE_SUCCESS]);
    appendAlert($(recorderTarget).find('#delete-success-controls'), ALERT_GESTURE_DELETE_SUCCESS);
    $(recorderTarget).find('#delete-success-controls').removeClass('hidden');
    $(recorderTarget).find('#delete-success-controls #btn-record-new-gesture').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(recorderTarget).find('.recorder').removeClass('hidden');
        $(recorderTarget).find('#delete-success-controls').addClass('hidden');
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