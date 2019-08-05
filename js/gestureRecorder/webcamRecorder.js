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

//    setTimeout(function () {
    if (navigator.getUserMedia) {
        navigator.mediaDevices.enumerateDevices()
                .then(gotDevices)
                .catch(errorCallback);
    } else {
        console.warn('Native device media streaming (getUserMedia) not supported in this browser.');
    }
//    }, 3000);


    function gotDevices(deviceInfos) {
        console.log('got devices for webcam recorder', deviceInfos);
        var videoSource = null;
        var audioSource = null;

        var videoSources = [];
        var audioSources = [];
        for (var i = 0; i < deviceInfos.length; i++) {
            if (deviceInfos[i].kind === 'videoinput' && !deviceInfos[i].label.toLowerCase().includes('leap') && !deviceInfos[i].label.toLowerCase().includes('kinect')) {
                videoSources.push(deviceInfos[i]);
            } else if (deviceInfos[i].kind === 'audioinput' && !deviceInfos[i].label.toLowerCase().includes('xbox')) {
                audioSources.push(deviceInfos[i]);
            }
        }

        for (var i = 0; i < deviceInfos.length; i++) {
            if (!videoSource && deviceInfos[i].kind === 'videoinput' && !deviceInfos[i].label.toLowerCase().includes('leap') && !deviceInfos[i].label.toLowerCase().includes('kinect')) {
                console.log('standard video input device:', deviceInfos[i]);
                videoSource = deviceInfos[i].deviceId;
            } else if (!audioSource && deviceInfos[i].kind === 'audioinput' && !deviceInfos[i].label.toLowerCase().includes('xbox')) {
                console.log('standard audio input device:', deviceInfos[i]);
                audioSource = deviceInfos[i].deviceId;
            }

            if (videoSource) {
                break;
            }
        }

        if (options.videoSource && options.videoSource !== null) {
            videoSource = options.videoSource;
        }

        if (webcamRecorder.options && webcamRecorder.options.allowConfig && webcamRecorder.options.allowConfig === true) {
            var configPanel = $(webcamRecorder.options.parent).find('#rtc-config-panel');
            renderAssembledVideoSources($(configPanel).find('#video-input-select'), videoSources, videoSource);
            renderAssembledAudioSources($(configPanel).find('#audio-input-select'), audioSources, audioSource);
        }

        options.sources = {video: videoSource, audio: audioSource};

        // set constraints
        var constraints = null;
        if (getBrowser() === "Chrome") {
            constraints = {audio: false,
                video: {deviceId: {exact: options.sources.video, "mandatory": {"minWidth": 320, "maxWidth": 320, "minHeight": 240, "maxHeight": 240}, frameRate: {ideal: 20, min: 10}, "optional": []}
                }};
        } else if (getBrowser() === "Firefox") {
            constraints = {audio: false,
                video: {deviceId: {exact: options.sources.video, width: {min: 320, ideal: 320, max: 320}, height: {min: 240, ideal: 240, max: 240}}
                }};
        }

        navigator.mediaDevices.getUserMedia(constraints).then(onSuccess).catch(onError);
    }

    function errorCallback(deviceInfos) {
        console.error('error', deviceInfos);
    }

    console.log('webcam options', options);
    if (options.recordedData) {
        console.log('recorded data', options.recordedData);
        webcamSaveGestureData = {images: options.recordedData.images, blobs: options.recordedData.blobs || null, previewImage: options.recordedData.previewImage, gif: options.recordedData.gif};
    }
}

function onError(error) {
    console.error(error);
    if (error.message) {
        var alertsContainer = $(webcamRecorder.options.parent).find('#alerts-container');
        var message = new String(error.message).split(' ').join('').toLowerCase();
        switch (message) {
            case 'permissiondenied':
                appendAlert(alertsContainer, ALERT_RTC_PERMISSION_DENIED);
                break;
        }
    }
}

function onSuccess(stream) {
//    console.log(stream);
//    var videoTracks = stream.getVideoTracks();
    console.log(stream);

    webcamRecorder.mediaStream = stream;
    var video = $(webcamRecorder.options.parent).find('.recorder-webcam-video');
    console.log('on success', video, webcamRecorder.options);
    $(video)[0].onloadedmetadata = function () {
        console.log('webcam recorder is ready');
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

    if (webcamRecorder.options && webcamRecorder.options.allowConfig && webcamRecorder.options.allowConfig === true) {
        var configPanel = $(webcamRecorder.options.parent).find('#rtc-config-panel');
        console.log('ALLOW CONFIG for WEBCAM', configPanel);

        $(webcamRecorder.options.parent).find('#btn-config-rtc').unbind('click').bind('click', function (event) {
            event.preventDefault();

            if (!$(this).hasClass('disabled')) {
                $(this).popover('hide');
                $(this).parent().css({filter: 'blur(2px)'});

                if ($(configPanel).hasClass('hidden')) {
                    $(video).css({filter: 'blur(2px)'});
                    $(configPanel).removeClass('hidden');
                }
            }
            $(this).blur();
        });

        $(configPanel).find('#btn-close-config').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(video).css({filter: ''});
            $(webcamRecorder.options.parent).find('#btn-config-rtc').parent().css({filter: ''});
            $(configPanel).addClass('hidden');
        });

        $(configPanel).find('#video-input-select').unbind('change').bind('change', function (event, activeId) {
            event.preventDefault();

            if (window.history.replaceState) {
                setParam(window.location.href, 'vSource', activeId);
            }

            webcamRecorder.options.videoSource = activeId;
            var options = webcamRecorder.options;
            $(webcamRecorder).trigger('renegotiate', [options]);
        });

        $(configPanel).find('#audio-input-select').unbind('change').bind('change', function (event, activeId) {
            event.preventDefault();

            if (window.history.replaceState) {
                setParam(window.location.href, 'aSource', activeId);
            }

            webcamRecorder.options.audioSource = activeId;
            var options = webcamRecorder.options;
            $(webcamRecorder).trigger('renegotiate', [options]);
        });
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
        webcamRecorder.crops = null;
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
    var file;

    if (webcamRecorder.options.startRecordingTime) {
        webcamRecorder.startRecordingTime = parseInt(webcamRecorder.options.startRecordingTime);
    }

    if (webcamRecorder.options.endRecordingTime) {
        webcamRecorder.endRecordingTime = parseInt(webcamRecorder.options.endRecordingTime);
    }

    if (webcamRecorder.options.rawData) {
        file = webcamRecorder.options.rawData;
        webcamRecorder.startRecordingTime = webcamRecorder.options.startRecordingTime;
        webcamRecorder.endRecordingTime = webcamRecorder.options.endRecordingTime;
    } else {
        file = new File(webcamRecorder.recordingChunks, 'webcam', {type: "video/webm"});
    }

    var obj_url = window.URL.createObjectURL(file);
    $(video).attr('src', obj_url);
    var duration = getSeconds(getTimeBetweenTimestamps(webcamRecorder.startRecordingTime, webcamRecorder.endRecordingTime), true);
    console.log('duration', duration);

    $(video)[0].onloadedmetadata = function () {
        if (video[0].duration === Infinity) {
            $(video).removeAttr('loop');
            video[0].playbackRate = 4;
            video[0].currentTime = duration - 2;

            $(video).bind('ended', function () {
                $(video).unbind('ended');
                $(video).attr('loop', 'loop');
                video[0].playbackRate = 1;
                video[0].currentTime = 0;
                webcamRecorder.initializePlaybackControls();
                if (video[0].duration !== Infinity) {
                    $(webcamRecorder).trigger('playbackReady', [TYPE_RECORD_WEBCAM]);
                }
            });

            setTimeout(function () {
                video[0].play();
            }, 250);
        } else {
            webcamRecorder.initializePlaybackControls();
            $(webcamRecorder).trigger('playbackReady', [TYPE_RECORD_WEBCAM]);
        }
    };
};

WebcamRecorder.prototype.play = function (container) {
    if (!$(container).find('.btn-toggle-playback').hasClass('playing')) {
        $(container).find('.btn-toggle-playback').click();
    }
};

WebcamRecorder.prototype.stop = function (container) {
    if ($(container).find('.btn-toggle-playback').hasClass('playing')) {
        $(container).find('.btn-toggle-playback').click();
    }
};

WebcamRecorder.prototype.crops = null;
WebcamRecorder.prototype.initializePlaybackControls = function () {
    console.log('initialize playback controls');
    webcamRecorder.resetPlaybackControls();
    var togglePlaybackButton = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview .btn-toggle-playback');
    var playbackVideo = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview .playback-webcam-video');
//    var playbackSlider = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview #webcam-playback-slider');
//    var toggleCroppingButton = $(webcamRecorder.options.parent).find('.gr-playback #btn-toggle-cropping');
    var cropSlider = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview #webcam-playback-crop-slider');

    if (!webcamRecorder.crops) {
        webcamRecorder.crops = {left: 0, right: playbackVideo[0].duration};
    }

    $(playbackVideo).unbind('timeupdate').bind('timeupdate', function () {
        if (playbackVideo[0].currentTime < webcamRecorder.crops.left || playbackVideo[0].currentTime > webcamRecorder.crops.right) {
            playbackVideo[0].currentTime = webcamRecorder.crops.left;
        }
    });

    $(togglePlaybackButton).unbind('click').bind('click', function (event) {
        event.preventDefault();

        if ($(togglePlaybackButton).hasClass('playing')) {
            $(togglePlaybackButton).removeClass('playing');
            $(this).find('.fa').removeClass('fa-pause').addClass('fa-play');
            playbackVideo[0].pause();
        } else {
            $(togglePlaybackButton).addClass('playing');
            $(this).find('.fa').removeClass('fa-play').addClass('fa-pause');

            if (playbackVideo[0].currentTime < webcamRecorder.crops.left || playbackVideo[0].currentTime > webcamRecorder.crops.right) {
                playbackVideo[0].currentTime = webcamRecorder.crops.left;
            }

            playbackVideo[0].play();
        }
    });

    if (webcamRecorder.options.autoplayPlayback && webcamRecorder.options.autoplayPlayback === true && $(togglePlaybackButton).attr('data-state') === 'paused') {
        $(togglePlaybackButton).click();
    }

    $(cropSlider).parent().removeClass('hidden disabled');

    try {
        $(cropSlider).slider('destroy');
    } catch (error) {
        console.log(error);
    }

    $(cropSlider).slider({
        min: 0,
        max: playbackVideo[0].duration,
        step: 0.001,
        precision: 3,
        value: [webcamRecorder.crops.left, webcamRecorder.crops.right]
    });


    $(cropSlider).unbind('change').bind('change', function (event) {
        updateCropping(event.value.newValue);
    });

    $(cropSlider).unbind('slideStart').bind('slideStart', function (event) {
        if ($(togglePlaybackButton).hasClass('playing')) {
            $(togglePlaybackButton).click();
        }
    });

    $(cropSlider).unbind('slideStop').bind('slideStop', function (event) {
        if (!$(togglePlaybackButton).hasClass('playing')) {
            $(togglePlaybackButton).click();
        }
    });

    $(playbackVideo)[0].currentTime = webcamRecorder.crops.left;
    function updateCropping(newValues) {
        if (webcamRecorder.crops.left !== newValues[0]) {
            webcamRecorder.crops.left = newValues[0];
            $(playbackVideo)[0].currentTime = webcamRecorder.crops.left;
        } else if (webcamRecorder.crops.right !== newValues[1]) {
            webcamRecorder.crops.right = newValues[1];
            $(playbackVideo)[0].currentTime = webcamRecorder.crops.right;
        }
    }
};

WebcamRecorder.prototype.resetPlaybackControls = function () {
    var playbackVideo = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview .playback-webcam-video');
    $(playbackVideo).unbind('timeupdate');
    $(playbackVideo).attr('loop', 'loop');
    $(playbackVideo).css({borderBottomLeftRadius: "0px", borderBottomRightRadius: "0px"});

    var preview = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview');
    $(preview).find('.gr-playback .controls-container').removeClass('hidden');
    $(preview).find('.gr-playback #recorder-webcam-slider-controls').removeClass('hidden');
    $(preview).find('.gr-playback #keyframeSelect').removeClass('hidden');
};

WebcamRecorder.prototype.recordedData = function () {
    return {type: TYPE_RECORD_WEBCAM, data: new File(webcamRecorder.recordingChunks, 'webcam', {type: "video/webm"}), startRecordingTime: webcamRecorder.startRecordingTime, endRecordingTime: webcamRecorder.endRecordingTime};
};

var webcamSaveGestureData = null;
WebcamRecorder.prototype.extract = function () {
    extractionStopped = false;

    var togglePlaybackButton = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview .btn-toggle-playback');
    var playbackVideo = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview .playback-webcam-video');

    $(playbackVideo).removeAttr('loop');
    $(playbackVideo).css({borderRadius: "8px"});

    if ($(togglePlaybackButton).hasClass('playing')) {
        $(togglePlaybackButton).click();
    }
    $(playbackVideo).unbind('timeupdate');
    $(playbackVideo)[0].currentTime = webcamRecorder.crops.left;

    var preview = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview');
    $(preview).find('.controls-container').addClass('hidden');
    $(preview).find('#playback-webcam-slider-controls').addClass('hidden');
    $(preview).find('#keyframeSelect').addClass('hidden');

    var milliseconds = Math.min(Math.max(parseInt($(preview).find('#keyframeSelect .stepper-text').val()), 80), 500);
    var shotsArray = [], blobsArray = [];

    setTimeout(function () {
        shotsArray = [];
        blobsArray = [];
        generateGestureImage(playbackVideo, milliseconds);
    }, 100);

    // generate one screenshot of the video
    function generateGestureImage(video, milliseconds) {
        var canvas = document.createElement('canvas');
        canvas.width = $(video).width();
        canvas.height = $(video).height();
        var ctx = canvas.getContext('2d');
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage($(video)[0], 0, 0, canvas.width, canvas.height);

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

            if ($(video)[0].currentTime < webcamRecorder.crops.right) {
                // if trimmed duration left not reached, than call next frame
                $(video)[0].currentTime = $(video)[0].currentTime + (milliseconds / 1000);
                setTimeout(function () {
                    generateGestureImage(video, milliseconds);
                }, 100);
            } else {
                if (shotsArray.length > 0) {
                    if (!extractionStopped) {
                        webcamSaveGestureData = {images: shotsArray, blobs: blobsArray, previewImage: 0};
                        $(webcamRecorder).trigger('dataExtracted', [TYPE_RECORD_WEBCAM]);
                    }
                } else {
                    $(webcamRecorder).trigger(GR_EVENT_GESTURE_TOO_SHORT, [TYPE_RECORD_WEBCAM]);
                    webcamRecorder.resetPlaybackControls();
                }
            }
        }, 'image/jpeg', 0.8);
    }
};

var extractionStopped = false;
WebcamRecorder.prototype.stopExtraction = function () {
    extractionStopped = true;
};

WebcamRecorder.prototype.showSave = function () {
    var playbackPreview = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview');
    $(playbackPreview).find('.controls-container').removeClass('hidden');
    $(playbackPreview).find('#playback-webcam-slider-controls').removeClass('hidden');
    $(playbackPreview).find('#keyframeSelect').removeClass('hidden');

    var playbackVideo = $(playbackPreview).find('.playback-webcam-video');
    $(playbackVideo).attr('loop', 'loop');
    $(playbackVideo).css({borderRadius: "8px 8px 0px 0px"});

    renderGesturePreview($(webcamRecorder.options.parent).find('.gr-save #webcam-save-preview'), webcamSaveGestureData);

    var savePreview = $(webcamRecorder.options.parent).find('.gr-save #webcam-save-preview');
    var togglePlaybackButton = $(savePreview).find('.btn-toggle-playback');
    if (webcamRecorder.options.autoplaySave && webcamRecorder.options.autoplaySave === true && $(togglePlaybackButton).attr('data-state') === 'paused') {
        setTimeout(function () {
            $(togglePlaybackButton).click();
        }, 250);
    }

    if (webcamSaveGestureData && webcamSaveGestureData.previewImage) {
        $(webcamRecorder.options.parent).find('.btn-tag-as-preview .preview-image-index').text(parseInt(webcamSaveGestureData.previewImage) + 1);
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

            $(gifUploadQueue).bind(EVENT_UPLOAD_PROGRESS_ALL, function (event, progress) {
                event.preventDefault();
                updateProgressGIF(progress);
            });

            // create gif from gesture images and upload it
            var filename = sha512(new Date().getTime() + "" + i) + ".gif";
            createGIF(webcamSaveGestureData.images, filename, false, function (blob) {
                gifUploadQueue.upload([blob], filename);
            });
        });

        $(uploadQueue).bind(EVENT_UPLOAD_PROGRESS_ALL, function (event, progress) {
            event.preventDefault();
            updateProgressImages(progress);
        });

        // upload gesture images
        console.log('attach saved data', webcamSaveGestureData)
        if (webcamSaveGestureData.blobs && webcamSaveGestureData.blobs.length > 0) {
            for (var i = 0; i < webcamSaveGestureData.blobs.length; i++) {
                var filename = sha512(new Date().getTime() + "" + i) + ".jpg";
                uploadQueue.upload([webcamSaveGestureData.blobs[i]], filename);
            }
        } else {
            if (webcamSaveGestureData.images && webcamSaveGestureData.images.length > 0) {
                saveData.images = webcamSaveGestureData.images;
                if (webcamSaveGestureData.gif) {
                    saveData.gif = webcamSaveGestureData.gif;
                    console.log('attachSaveData', saveData);
                    $(webcamRecorder).trigger('saveDataAttached', [TYPE_RECORD_WEBCAM, saveData]);
                } else {
                    var gifUploadQueue = new UploadQueue();
                    $(gifUploadQueue).bind(EVENT_ALL_FILES_UPLOADED, function () {
                        saveData.gif = gifUploadQueue.getUploadURLs()[0];
                        $(webcamRecorder).trigger('saveDataAttached', [TYPE_RECORD_WEBCAM, saveData]);
                    });

                    // create gif from gesture images and upload it
                    var filename = sha512(new Date().getTime() + "" + i) + ".gif";
                    createGIF(webcamSaveGestureData.images, filename, false, function (blob) {
                        gifUploadQueue.upload([blob], filename);
                    });
                }
            }
        }
    } else {
        saveData.images = webcamSaveGestureData.images;
        if (webcamSaveGestureData.gif) {
            saveData.gif = webcamSaveGestureData.gif;
            $(webcamRecorder).trigger('saveDataAttached', [TYPE_RECORD_WEBCAM, saveData]);
        } else {
            createGIF(webcamSaveGestureData.images, null, false, function (blob) {
                saveData.gif = blob;
                $(webcamRecorder).trigger('saveDataAttached', [TYPE_RECORD_WEBCAM, saveData]);
            });
        }
    }

    function updateProgressImages(progress) {
        $(webcamRecorder.options.parent).find('#progress-images').removeClass('hidden');
        $(webcamRecorder.options.parent).find('#progress-images .progress-bar').attr('aria-valuenow', progress).css({width: progress + '%'}).text(parseInt(progress) + '%');
    }

    function updateProgressGIF(progress) {
        $(webcamRecorder.options.parent).find('#progress-gif').removeClass('hidden');
        $(webcamRecorder.options.parent).find('#progress-gif .progress-bar').attr('aria-valuenow', progress).css({width: progress + '%'}).text(parseInt(progress) + '%');
    }
};


WebcamRecorder.prototype.showSaveSuccess = function (saveData) {
    var preview = $(webcamRecorder.options.parent).find('#webcam-save-success-preview');
    renderGesturePreview(preview, saveData);

    var togglePlaybackButton = $(preview).find('.btn-toggle-playback');
    if (webcamRecorder.options.autoplaySaveSuccess && webcamRecorder.options.autoplaySaveSuccess === true && $(togglePlaybackButton).attr('data-state') === 'paused') {
        $(togglePlaybackButton).click();
    }
};

WebcamRecorder.prototype.destroy = function () {
    webcamSaveGestureData = null;

    if (webcamRecorder) {
        var playbackVideo = $(webcamRecorder.options.parent).find('.gr-playback #webcam-preview .playback-webcam-video');
        if (playbackVideo) {
            $(playbackVideo).unbind('timeupdate');
            $(playbackVideo).stop();
            $(playbackVideo).removeAttr('src');
        }

        if (webcamRecorder.crops) {
            webcamRecorder.crops = {};
        }

        if (webcamRecorder.mediaStream) {
            if (webcamRecorder.mediaStream.getAudioTracks()[0])
                webcamRecorder.mediaStream.getAudioTracks()[0].stop();
            if (webcamRecorder.mediaStream.getVideoTracks()[0])
                webcamRecorder.mediaStream.getVideoTracks()[0].stop();
        }

        webcamRecorder.recordingChunks = [];
        webcamRecorder = null;
    }
};