var alertTarget = null;
var saveGesture = false;
var recorderTarget = null;
function initCheckRecorder(aTarget, rTarget, canSaveGesture) {
    alertTarget = aTarget;
    recorderTarget = rTarget;
    saveGesture = canSaveGesture;
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        initializeRecorder();
    } else {
        appendAlert(alertTarget, ALERT_WEB_RTC_NOT_SUPPORTED);
        console.log('Native device media streaming (getUserMedia) not supported in this browser.');
    }
}

function initializeRecorder() {
    clearAlerts(alertTarget);

    if (recordRTC) {
        recordRTC.clearRecordedData();
    }

    if (liveStream) {
        liveStream.getVideoTracks()[0].stop();
    }

    var mediaConstraints = {video: true, audio: false};
    navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
}

function resetRecorder() {
    if (recordRTC) {
        recordRTC.clearRecordedData();
    }

    if (liveStream) {
        liveStream.getVideoTracks()[0].stop();
    }
}

var recordRTC, liveStream;
function successCallback(stream) {
    liveStream = stream;
    $(recorderTarget).find('#recorder-video').attr('src', URL.createObjectURL(stream));
    showRecord();
}

function errorCallback(error) {
    alert(error);
    // maybe another application is using the device
}

//$(document).on('click', '.recorder #btn-record', function(event) {
//    event.preventDefault();
//    console.log('start-recording');
//});

$(document).on('click', '.recorder #btn-record', function (event) {

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
});

var NETWORK_NO_SOURCE = 3;
$(document).on('click', '.recorder #btn-record-stop', function (event) {
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

$(document).on('click', '.recorder .btn-repeat-recording', function (event) {
    event.preventDefault();
    initializeRecorder();
});

$(document).on('click', '.recorder #btn-repeat-trimming', function (event) {
    event.preventDefault();
    showPlayback();
});

$(document).on('click', '.recorder #btn-choose-preview-image', function (event) {
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

        $('.recorder #gesturePreview').bind('click', function (event) {
            event.preventDefault();
            var previewImage = $(this).children('.previewImage');
            previewImage.removeClass('previewImage');
            var visibleImage = $(this).children('.active');
            visibleImage.addClass('previewImage');
        });
    }
});

function showRecord() {
    $(recorderTarget).find('.recorder #btn-record').removeClass('hidden');
    $(recorderTarget).find('.recorder #btn-record-stop').addClass('hidden');
    $(recorderTarget).find('.recorder #recorder-video').removeClass('hidden');
    $(recorderTarget).find('.recorder .gesture-recorder-controls').removeClass('hidden');
    $(recorderTarget).find('.recorder #recorder-video').removeAttr('loop');
    $(recorderTarget).find('.recorder #record-controls').removeClass('hidden');
    $(recorderTarget).find('.recorder #playback-controls').addClass('hidden');
    $(recorderTarget).find('.recorder #preview-controls').addClass('hidden');
    $(recorderTarget).find('.recorder #trim-controls').addClass('hidden');
    hideSave();
    resetTrimControls();
}

var gestureStartMarked = false;
function showPlayback() {
    $(recorderTarget).find('.recorder #recorder-video').attr('loop', 'loop');
    $(recorderTarget).find('.recorder #record-controls').addClass('hidden');
    $(recorderTarget).find('.recorder #preview-controls').addClass('hidden');
    $(recorderTarget).find('.recorder #playback-controls, .recorder .gesture-recorder-controls, .recorder #recorder-video').removeClass('hidden');
    hideSave();

    $(recorderTarget).find('.recorder #recorder-video').on('timeupdate', function () {
        var percent = $(this)[0].currentTime / $(this)[0].duration * 100;
        $(recorderTarget).find('.recorder #seek-bar .progress-bar').css({width: percent + '%'});
    });

    $(recorderTarget).find('.recorder #btn-play').on('click', function (event) {
        event.preventDefault();
        $(recorderTarget).find('.recorder #recorder-video')[0].play();
    });
    $(recorderTarget).find('.recorder #btn-pause').on('click', function (event) {
        event.preventDefault();
        $(recorderTarget).find('.recorder #recorder-video')[0].pause();
    });
    $(recorderTarget).find('.recorder #btn-stop').on('click', function (event) {
        event.preventDefault();
        $(recorderTarget).find('.recorder #recorder-video')[0].pause();
        $(recorderTarget).find('.recorder #recorder-video')[0].currentTime = 0;
    });

    // seekbar operations
    $(recorderTarget).find('.recorder #seek-bar, .recorder #trim-bar').on("mousedown", function (event) {
        event.preventDefault();
        var video = $(recorderTarget).find('#recorder-video')[0];
        var seekbar = $(recorderTarget).find('#seek-bar');
        video.pause();
        $(window).on("mousemove", function (event) {
            var positionX = Math.max(0, Math.min(Math.round(event.pageX - $(seekbar).offset().left), $(seekbar).width()));

            var time = video.duration * (positionX / $(seekbar).width());
            video.currentTime = Math.min(time, video.duration - 0.0001);
        });
        $(window).on('mouseup', function () {
            $(window).unbind('mousemove');
        });
    });
    $(recorderTarget).find('#seek-bar, .recorder #trim-bar').on("click", function (event) {
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
            $(recorderTarget).find('#btn-stop').click();

            var totalWidth = $(recorderTarget).find('#seek-bar').width();
            var startTimeOffset = ($(recorderTarget).find('#gesture-beginning').width() / totalWidth) * video.duration;
            var endTimeOffset = (($(recorderTarget).find('#gesture-beginning').width() + $(recorderTarget).find('#gesture-execution').width()) / totalWidth) * video.duration;
            $(recorderTarget).find('#playback-controls').addClass('hidden');

            // take screenshots every (based on the chosen milliseconds) x milliseconds
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
                console.log(shotsArray.length);
                renderGestureImages($(recorderTarget).find('#preview-controls .previewGesture'), shotsArray, 0, function () {
                    gestureTrimmingDone();
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

function gestureTrimmingDone() {
    showPreview();
    showSave();
}

function showPreview() {
    $(recorderTarget).find('#preview-controls').removeClass('hidden');
    $(recorderTarget).find('#recorder-video').addClass('hidden');
    $(recorderTarget).find('.gesture-recorder-controls').addClass('hidden');
}

function showSave() {
    $(recorderTarget).find('#save-controls').removeClass('hidden');
    $(recorderTarget).find('#btn-save-gesture').bind('click', function (event) {
        event.preventDefault();
        var button = $(this);
        clearAlerts(alertTarget);

        if (inputsValid(true) && !$(this).hasClass('disabled')) {
            $(button).addClass('disabled');
            showCursor($('body'), CURSOR_PROGRESS);

            var gestureImagesData = getGestureImagesData($(recorderTarget).find('#gesturePreview'));
            var previewImageIndex = getGesturePreviewIndex($(recorderTarget).find('#gesturePreview'));
            var title = $(recorderTarget).find('#gestureName').val().trim();
            var context = $(recorderTarget).find('#gestureContext').val().trim();
            var description = $(recorderTarget).find('#gestureDescription').val().trim();
            var joints = getSelectedJoints($(recorderTarget).find('#human-body #joint-container'));

            if (saveGesture) {
                saveModeratorGesture({title: title, context: context, description: description, joints: joints, previewImage: previewImageIndex, gestureImages: gestureImagesData}, function (result) {
                    showCursor($('body'), CURSOR_DEFAULT);
                    $(button).removeClass('disabled');

                    if (result.status === RESULT_SUCCESS) {
                        $(recorderTarget).find('#success-controls #btn-delete-saved-gesture').attr('name', result.gestureId);
                        renderGestureImages($(recorderTarget).find('#success-controls .previewGesture'), result.images, result.previewImage, null);
                        assembleGesture(parseInt(result.gestureId));
                        updateGestureCatalogButtons();
                        getGestureCatalog();
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
                $(recorderTarget).trigger('gestureSavedSuccessfully');
                showSaveSuccess();
            }
        }
    });
}

function hideSave() {
    $(recorderTarget).find('#save-controls').addClass('hidden');
    $(recorderTarget).find('#btn-save-gesture').unbind('click');
}

$(document).on('input', '#gestureName, #gestureContext, #gestureDescription', function () {
    if (inputsValid()) {
        $(recorderTarget).find('#btn-save-gesture').removeClass('disabled');
    } else {
        $(recorderTarget).find('#btn-save-gesture').addClass('disabled');
    }
});

$(document).on('change', '#save-controls #human-body', function () {
    if (inputsValid()) {
        $(recorderTarget).find('#btn-save-gesture').removeClass('disabled');
    } else {
        $(recorderTarget).find('#btn-save-gesture').addClass('disabled');
    }
});

function resetInputs() {
    $(recorderTarget).find('#gestureName').val('');
    $(recorderTarget).find('#gestureContext').val('');
    $(recorderTarget).find('#gestureDescription').val('');
    $(recorderTarget).find('#save-controls #human-body #joint-container').children('.active').click();
    $(recorderTarget).find('#save-controls #btn-save-gesture').addClass('disabled');
}

function inputsValid(showErrors) {
    var title = $(recorderTarget).find('#gestureName').val().trim();
    if (title === '') {
        if (showErrors) {
            appendAlert($(recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        } else {
            removeAlert($(recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        }
        return false;
    }

    var context = $(recorderTarget).find('#gestureContext').val().trim();
    if (context === '') {
        if (showErrors) {
            appendAlert($(recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        } else {
            removeAlert($(recorderTarget).find('#save-controls'), ALERT_MISSING_FIELDS);
        }
        return false;
    }

    var description = $(recorderTarget).find('#gestureDescription').val().trim();
    if (description === '') {
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
    if (gestureImagesData === 0) {
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
    resetInputs();
    appendAlert($(recorderTarget).find('#success-controls'), ALERT_GESTURE_SAVE_SUCCESS);
    $(recorderTarget).find('#success-controls').removeClass('hidden');
    $(recorderTarget).find('.recorder').addClass('hidden');
    hideSave();
    $(recorderTarget).find('#success-controls #btn-delete-saved-gesture').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(this).addClass('disabled');
            showCursor($('body'), CURSOR_PROGRESS);
            var gestureId = $(this).attr('name');
            deleteGesture({gestureId: gestureId}, function (result) {
                showCursor($('body'), CURSOR_DEFAULT);
                if (result.status === RESULT_SUCCESS) {
                    $(recorderTarget).find('#success-controls').addClass('hidden');
                    showDeleteSuccess();
                } else {
                    appendAlert(alertTarget, ALERT_GENERAL_ERROR);
                }
            });
        } else {
            $(this).removeClass('disabled');
        }
    });
    $(recorderTarget).find('#success-controls #btn-record-new-gesture').bind('click', function (event) {
        event.preventDefault();
        $(recorderTarget).find('.recorder').removeClass('hidden');
        $(recorderTarget).find('#success-controls').addClass('hidden');
        initializeRecorder();
    });
}

function showDeleteSuccess() {
    appendAlert($(recorderTarget).find('#delete-success-controls'), ALERT_GESTURE_DELETE_SUCCESS);
    $(recorderTarget).find('#delete-success-controls').removeClass('hidden');
    $(recorderTarget).find('#delete-success-controls #btn-record-new-gesture').bind('click', function (event) {
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