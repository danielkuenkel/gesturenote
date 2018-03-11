/*
 * create WebcamRecorder instance with new WebcamRecorder(options).
 * Use the GestureRecorder class for controlling this recorder.
 */

var webcamRecorder;
WebcamRecorder.prototype.options = null;
WebcamRecorder.prototype.mediaStream = null;
WebcamRecorder.prototype.mediaRecorder = null;
WebcamRecorder.prototype.recordingChunks = [];
WebcamRecorder.prototype.startRecordingTime = null;
WebcamRecorder.prototype.endRecordingTime = null;

function WebcamRecorder(options) {
    this.options = options;
    webcamRecorder = this;

    navigator.getUserMedia = navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia;

    if (navigator.getUserMedia) {
        if (getBrowser() === "Chrome") {
            var constraints = {"audio": false, "video": {"mandatory": {"minWidth": 320, "maxWidth": 320, "minHeight": 240, "maxHeight": 240}, "optional": []}};
        } else if (getBrowser() === "Firefox") {
            var constraints = {audio: false, video: {width: {min: 320, ideal: 320, max: 320}, height: {min: 240, ideal: 240, max: 240}}};
        }

        navigator.getUserMedia(constraints, onSuccess, onError);
    } else {
        appendAlert(options.alertTarget, ALERT_WEB_RTC_NOT_SUPPORTED);
        console.warn('Native device media streaming (getUserMedia) not supported in this browser.');
    }
}

function onError(error) {
    console.log(error);
}

function onSuccess(stream) {
    webcamRecorder.mediaStream = stream;
    var video = $(webcamRecorder.options.parent).find('.recorder-webcam-video');
    $(video)[0].onloadedmetadata = function () {
        $(webcamRecorder).trigger('ready', [TYPE_RECORD_WEBCAM]);
    };

    try {
        video[0].srcObject = stream;
    } catch (error) {
        video[0].src = URL.createObjectURL(stream);
    }

    if (!webcamRecorder.mediaRecorder || webcamRecorder.mediaRecorder === undefined) {
        webcamRecorder.mediaRecorder = new MediaRecorder(stream);

        webcamRecorder.mediaRecorder.onstart = function () {
            console.log('start recording webcam ... ');
            webcamRecorder.startRecordingTime = new Date().getTime();
            webcamRecorder.recordingChunks = [];
            $(webcamRecorder).trigger('recordingStarted', [TYPE_RECORD_WEBCAM]);
        };

        webcamRecorder.mediaRecorder.ondataavailable = function (event) {
            console.log('on data available');

            if (event.data && event.data.size > 0) {
                var chunks = getLocalItem('recordingChunks');
                webcamRecorder.recordingChunks.push(event.data);
            }
        };

        webcamRecorder.mediaRecorder.onstop = function () {
            console.log('Stopped recording, state = ' + webcamRecorder.mediaRecorder.state);
            webcamRecorder.endRecordingTime = new Date().getTime();
            try {
                video[0].srcObject = null;
            } catch (error) {
                video[0].src = null;
            }
            $(webcamRecorder).trigger('recordingStopped', [TYPE_RECORD_WEBCAM]);
        };

        webcamRecorder.mediaRecorder.onerror = function (e) {
            console.log('Error: ', e);
        };

        webcamRecorder.mediaRecorder.onwarning = function (e) {
            console.log('Warning: ' + e);
        };
    }
}

WebcamRecorder.prototype.record = function () {
    var playbackVideo = $(webcamRecorder.options.parent).find('#webcam-preview .playback-webcam-video');
    $(playbackVideo).attr('src', '');
    $(playbackVideo).unbind('timeupdate');

    if (webcamRecorder.mediaRecorder) {
        webcamRecorder.mediaRecorder.start(1000);
    }
};

var stopRecordingCallback = null;
WebcamRecorder.prototype.stopRecord = function (callback) {
    if (webcamRecorder.mediaRecorder) {
        webcamRecorder.mediaRecorder.stop();

        if (webcamRecorder.mediaStream) {
            if (webcamRecorder.mediaStream.getAudioTracks()[0])
                webcamRecorder.mediaStream.getAudioTracks()[0].stop();
            if (webcamRecorder.mediaStream.getVideoTracks()[0])
                webcamRecorder.mediaStream.getVideoTracks()[0].stop();
        }
    }
};

WebcamRecorder.prototype.playback = function () {
    var video = $(webcamRecorder.options.parent).find('.gr-playback .playback-webcam-video');

    var file = new File(webcamRecorder.recordingChunks, 'webcam', {type: "video/webm"});
    var obj_url = window.URL.createObjectURL(file);
    $(video).attr('src', obj_url);
    var duration = getSeconds(getTimeBetweenTimestamps(webcamRecorder.startRecordingTime, webcamRecorder.endRecordingTime), true);

    $(video)[0].onloadedmetadata = function () {
        if (video[0].duration === Infinity) {
            $(video).removeAttr('loop');
            video[0].playbackRate = 2;
            video[0].currentTime = duration - 2;

            $(video).bind('ended', function () {
                console.log('video ended -> duration: ', this.duration);
                $(video).unbind('ended');
                $(video).attr('loop', 'loop');
                video[0].playbackRate = 1;
                video[0].currentTime = 0;
                initializePlaybackControls();
                if (video[0].duration !== Infinity) {
                    $(webcamRecorder).trigger('playbackReady', [TYPE_RECORD_WEBCAM]);
                    window.URL.revokeObjectURL(obj_url);
                }
            });

            setTimeout(function () {
                video[0].play();
            }, 150);
        } else {
            initializePlaybackControls();
            $(webcamRecorder).trigger('playbackReady', [TYPE_RECORD_WEBCAM]);
        }
    };
};

WebcamRecorder.prototype.play = function () {
    if (!$(webcamRecorder.options.parent).find('#btn-toggle-playback').hasClass('playing')) {
        $(webcamRecorder.options.parent).find('#btn-toggle-playback').click();
    }
};

WebcamRecorder.prototype.stop = function () {
    if ($(webcamRecorder.options.parent).find('#btn-toggle-playback').hasClass('playing')) {
        $(webcamRecorder.options.parent).find('#btn-toggle-playback').click();
    }
};

var crops = {};
function initializePlaybackControls() {
    resetPlaybackControls();
    var togglePlaybackButton = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview #btn-toggle-playback');
    var playbackVideo = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview .playback-webcam-video');
    var playbackSlider = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview #webcam-playback-slider');
    var toggleCroppingButton = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview #btn-toggle-cropping');
    var cropSlider = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview #webcam-crop-slider');
    crops = {left: 0, right: playbackVideo[0].duration};

    function initPlaybackSlider(highlightRange) {
        var sliderOptions = {
            min: 0,
            max: playbackVideo[0].duration,
            step: 0.001,
            precision: 3,
            value: 0
        };

        if (highlightRange === true && (crops.left > 0 || crops.right < sliderOptions.max)) {
            sliderOptions.rangeHighlights = [{start: crops.left, end: crops.right, class: "isGesture"}];
        }

        $(playbackVideo).unbind('timeupdate');
        $(playbackSlider).unbind('change');
        $(playbackSlider).slider(sliderOptions);
        $(playbackSlider).slider('destroy');
        $(playbackSlider).slider(sliderOptions);

        $(playbackSlider).unbind('change').bind('change', function (event) {
            $(playbackSlider).addClass('sliding');
            event.preventDefault();
            $(playbackSlider).addClass('sliding');
            if ($(togglePlaybackButton).hasClass('playing')) {
                $(togglePlaybackButton).click();
            }
            $(playbackVideo)[0].currentTime = event.value.newValue;
        });

        $(playbackVideo).unbind('timeupdate').bind('timeupdate', function () {
            if (!$(playbackSlider).hasClass('sliding')) {
                if (playbackVideo[0].currentTime < crops.left || playbackVideo[0].currentTime > crops.right) {
                    playbackVideo[0].currentTime = crops.left;
                }
                $(playbackSlider).slider('setValue', $(playbackVideo)[0].currentTime);
            }
        });
    }

    initPlaybackSlider();

    $(togglePlaybackButton).unbind('click').bind('click', function (event) {
        event.preventDefault();

        if ($(toggleCroppingButton).hasClass('cropping')) {
            $(toggleCroppingButton).click();
            $(playbackSlider).slider('setValue', crops.left);
        }

        if ($(togglePlaybackButton).hasClass('playing')) {

            $(togglePlaybackButton).removeClass('playing');
            $(this).find('.fa').removeClass('fa-pause').addClass('fa-play');
            playbackVideo[0].pause();
        } else {
            $(togglePlaybackButton).addClass('playing');
            $(this).find('.fa').removeClass('fa-play').addClass('fa-pause');

            if (playbackVideo[0].currentTime < crops.left || playbackVideo[0].currentTime > crops.right) {
                playbackVideo[0].currentTime = crops.left;
            }
            $(playbackSlider).removeClass('sliding');
            playbackVideo[0].play();
        }
    });

    if (toggleCroppingButton) {

        $(toggleCroppingButton).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                if ($(togglePlaybackButton).hasClass('playing')) {
                    $(togglePlaybackButton).click();
                }

                if ($(this).hasClass('cropping')) {
                    $(this).removeClass('cropping');

                    $(playbackSlider).slider('destroy');
                    $(playbackSlider).parent().removeClass('hidden');

                    $(cropSlider).slider('destroy');
                    $(cropSlider).parent().addClass('hidden');

                    initPlaybackSlider(true);
                    $(playbackSlider).slider('setValue', crops.left);
                } else {
                    $(this).addClass('cropping');
                    $(playbackSlider).parent().addClass('hidden');
                    $(cropSlider).parent().removeClass('hidden disabled');

                    $(cropSlider).slider({
                        min: 0,
                        max: playbackVideo[0].duration,
                        step: 0.001,
                        precision: 3,
                        value: [crops.left, crops.right]
                    });

                    $(cropSlider).unbind('change').bind('change', function (event) {
                        updateCropping(event.value.newValue);
                    });
                }
            }
        });
    }

    function updateCropping(newValues) {
        if (crops.left !== newValues[0]) {
            crops.left = newValues[0];
            $(playbackVideo)[0].currentTime = crops.left;
        } else if (crops.right !== newValues[1]) {
            crops.right = newValues[1];
            $(playbackVideo)[0].currentTime = crops.right;
        }
    }
}

function resetPlaybackControls() {
    var playbackVideo = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview .playback-webcam-video');
    $(playbackVideo).attr('loop', 'loop');
    $(playbackVideo).css({borderBottomLeftRadius: "0px", borderBottomRightRadius: "0px"});

    var preview = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview');
    $(preview).find('.gr-playback .controls-container').removeClass('hidden');
    $(preview).find('.gr-playback #recorder-webcam-slider-controls').removeClass('hidden');
    $(preview).find('.gr-playback #keyframeSelect').removeClass('hidden');
}

var draw_interval = null;
var saveGestureData = null;
var reachTimeout = null;
WebcamRecorder.prototype.extract = function () {
    extractionStopped = false;

    var togglePlaybackButton = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview #btn-toggle-playback');
    var playbackVideo = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview .playback-webcam-video');

    $(playbackVideo).removeAttr('loop');
    $(playbackVideo).css({borderRadius: "4px"});

    if ($(togglePlaybackButton).hasClass('playing')) {
        $(togglePlaybackButton).click();
    }
    $(playbackVideo)[0].currentTime = crops.left;

    var preview = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview');
    $(preview).find('.controls-container').addClass('hidden');
    $(preview).find('#recorder-webcam-slider-controls').addClass('hidden');
    $(preview).find('#keyframeSelect').addClass('hidden');
    var keyframes = Math.min(Math.max(parseInt($(preview).find('#keyframeSelect .stepper-text').val()), 80), 500);
    var shotsArray = [], blobsArray = [];

    $(playbackVideo)[0].addEventListener('play', handleKeyframeExtraction(keyframes, shotsArray, blobsArray), false);

    $(togglePlaybackButton).click();
    reachTimeout = setTimeout(offsetReached, (crops.right - crops.left) * 1000);

    function offsetReached() {
        clearInterval(draw_interval);
        if ($(togglePlaybackButton).hasClass('playing')) {
            $(togglePlaybackButton).click();
        }
        if (shotsArray.length > 0) {
            if (!extractionStopped) {
                saveGestureData = {images: shotsArray, blobs: blobsArray, previewImage: 0};
                $(webcamRecorder).trigger('dataExtracted', [TYPE_RECORD_WEBCAM]);
            }
        } else {
            $(webcamRecorder).trigger(GR_EVENT_GESTURE_TOO_SHORT, [TYPE_RECORD_WEBCAM]);
            resetPlaybackControls();
        }
    }
};

var handleKeyframeExtraction = function (keyframes, shotsArray, blobsArray) {
    var playbackVideo = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview .playback-webcam-video');

    var canvas = document.createElement('canvas');
    canvas.width = $(playbackVideo).width();
    canvas.height = $(playbackVideo).height();
    var ctx_draw = canvas.getContext('2d');
    draw_interval = setInterval(function () {
        ctx_draw.drawImage($(playbackVideo)[0], 0, 0, canvas.width, canvas.height);
        canvas.toBlob(function (blob) {
            var url = URL.createObjectURL(blob);
            var colorThief = new ColorThief();
            var dominantColor = colorThief.getColor(canvas);
            
            // black frame detection
            if (dominantColor && (dominantColor[0] + dominantColor[1] + dominantColor[2]) > 0) {
                shotsArray.push(url);
                blobsArray.push(blob);
            } else {
                console.log('black frame ignored');
            }
        }, 'image/jpeg', 0.8);
    }, keyframes);
};

var extractionStopped = false;
WebcamRecorder.prototype.stopExtraction = function () {
    extractionStopped = true;
    var playbackVideo = $(webcamRecorder.options.parent).find('#webcam-preview .playback-webcam-video');
    $(playbackVideo)[0].removeEventListener('play', handleKeyframeExtraction);
    if (reachTimeout) {
        clearTimeout(reachTimeout);
    }
};

WebcamRecorder.prototype.showSave = function () {
    var preview = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview');
    $(preview).find('.controls-container').removeClass('hidden');
    $(preview).find('#recorder-webcam-slider-controls').removeClass('hidden');
    $(preview).find('#keyframeSelect').removeClass('hidden');

    var playbackVideo = $(preview).find('.playback-webcam-video');
    $(playbackVideo).attr('loop', 'loop');
    $(playbackVideo).css({borderRadius: "4px 4px 0px 0px"});

    renderGesturePreview($(webcamRecorder.options.parent).find('.gr-save #webcam-save-preview'), saveGestureData);
    if (webcamRecorder.options.context) {
        $(webcamRecorder.options.parent).find('.gr-save #gestureContext').val(webcamRecorder.options.context);
    }
};

WebcamRecorder.prototype.attachSaveData = function (uploadFiles) {
    var saveData = {};
    saveData.previewImage = $(webcamRecorder.options.parent).find('.gr-save #webcam-save-preview .webcam-image-container .previewImage').attr('data-index');

    if (uploadFiles && uploadFiles === true) {
        var uploadQueue = new UploadQueue();
        $(uploadQueue).bind(EVENT_ALL_FILES_UPLOADED, function () {
            saveData.images = uploadQueue.getUploadURLs();
            var gifUploadQueue = new UploadQueue();
            $(gifUploadQueue).bind(EVENT_ALL_FILES_UPLOADED, function () {
                saveData.gif = gifUploadQueue.getUploadURLs()[0];
                $(webcamRecorder).trigger('saveDataAttached', [TYPE_RECORD_WEBCAM, saveData]);
            });

            // create gif from gesture images and upload it
            var filename = hex_sha512(new Date().getTime() + "" + i) + ".gif";
            createGIF(saveGestureData.images, filename, false, function (blob) {
                gifUploadQueue.upload([blob], filename);
            });

        });

        // upload gesture images
        for (var i = 0; i < saveGestureData.blobs.length; i++) {
            var filename = hex_sha512(new Date().getTime() + "" + i) + ".jpg";
            console.log(saveGestureData.blobs[i]);
            uploadQueue.upload([saveGestureData.blobs[i]], filename);
        }
    } else {
        saveData.images = saveGestureData.images;
        createGIF(saveGestureData.images, null, false, function (blob) {
            saveData.gif = blob;
            $(webcamRecorder).trigger('saveDataAttached', [TYPE_RECORD_WEBCAM, saveData]);
        });
    }
};


WebcamRecorder.prototype.showSaveSuccess = function (saveData) {
    var preview = $(webcamRecorder.options.parent).find('#webcam-save-success-preview');
    renderGesturePreview(preview, saveData);
};

WebcamRecorder.prototype.destroy = function () {
    if (webcamRecorder.mediaStream) {
        if (webcamRecorder.mediaStream.getAudioTracks()[0])
            webcamRecorder.mediaStream.getAudioTracks()[0].stop();
        if (webcamRecorder.mediaStream.getVideoTracks()[0])
            webcamRecorder.mediaStream.getVideoTracks()[0].stop();
    }

    var playbackVideo = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview .playback-webcam-video');
    if (playbackVideo) {
        $(playbackVideo).stop();
        $(playbackVideo).removeAttr('src');
    }

    webcamRecorder.stop();
};
function resetRecorder() {
    webcamRecorder.destroy();
}

function initializeLeapmotionRecorder() {
    var container = $(webcamRecorder.options.recorderTarget).find('#leap-recording-container');
    var options = {
        offset: {x: 0, y: 200, z: 0},
        previewOnly: false,
        pauseOnHands: false,
        autoplay: true,
        recordEmptyHands: true,
//            recording: currentPreviewGesture.gesture.sensorData.url,
        overlays: $(container).find('#leap-alert-space')
//            renderTarget: $(container).find('#renderArea'),
//            recordElement: $(container).find('#btn-start-recording'),
//            stopRecordElement: $(container).find('#btn-stop-recording'),
//        playbackElement: $(container).find('#btn-toggle-playback'),
//            downloadJsonElement: $(container).find('.btn-download-as-json'),
//            downloadCompressedElement: $(container).find('.btn-download-as-compressed'),
//            loadRecordingElement: $(container).find('#btn-load-recording'),
//            loadInputElement: $(container).find('#upload-leap-recording'),
//        playbackSliderElement: $(container).find('#leap-playback-slider'),
//        cropRecordElement: $(container).find('#btn-crop-recording'),
//        cropSliderElement: $(container).find('#leap-playback-crop-slider')
    };
    sensorRecorder = new LeapMotionRecorder(options);
}

function initializeLeapmotionPreview(recordedFrameData) {
    var container = $(webcamRecorder.options.recorderTarget).find('#leap-preview-container');
//    console.log(recordedFrameData);
    setTimeout(function () {
        var options = {
            offset: {x: 0, y: 200, z: 0},
            previewOnly: true,
            pauseOnHands: false,
            autoplay: true,
            rawData: recordedFrameData,
//        recordEmptyHands: true,
//            recording: currentPreviewGesture.gesture.sensorData.url,
//        overlays: $(container).find('#leap-alert-space'),
            renderTarget: $(container).find('#renderArea'),
//            recordElement: $(container).find('#btn-start-recording'),
//            stopRecordElement: $(container).find('#btn-stop-recording'),
            playbackElement: $(container).find('#btn-toggle-playback'),
//            downloadJsonElement: $(container).find('.btn-download-as-json'),
//            downloadCompressedElement: $(container).find('.btn-download-as-compressed'),
//            loadRecordingElement: $(container).find('#btn-load-recording'),
//            loadInputElement: $(container).find('#upload-leap-recording'),
            playbackSliderElement: $(container).find('#leap-playback-slider'),
            cropRecordElement: $(container).find('#btn-crop-recording'),
            cropSliderElement: $(container).find('#leap-playback-crop-slider')
        };
        sensorPreview = new LeapMotionRecorder(options);
    }, 1000);
}