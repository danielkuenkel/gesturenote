/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var leapRecorder;
LeapRecorder.prototype.options = null;

function LeapRecorder(options) {
    leapRecorder = this;
    if (options) {
        leapRecorder.options = options;
    }

    if (options.overlays) {
        appendAlert(options.overlays, ALERT_PLEASE_WAIT);
    }

    var controller = new Leap.Controller({enableGestures: false});
    controller.use('playback', {
        recordEmptyHands: options.recordEmptyHands,
        recording: options.recording || false,
        requiredProtocolVersion: 6,
        pauseOnHand: options.pauseOnHand || false,
        overlay: false
    });

//    console.log('renderTarget', options.renderTarget);

    controller.use('riggedHand', {
        checkWebGL: false,
        offset: options.offset || null,
        renderTarget: options.renderTarget || null
    });


    controller.connect();
    this.options.controller = controller;

    if ((!options.previewOnly || options.previewOnly === false)) {
        controller.on('connect', onConnect);
        function onConnect()
        {
            console.log("controller connected ");
            clearAlerts(options.overlays);
        }

        controller.on('deviceAttached', onAttached);
        function onAttached()
        {
            console.log("device attached");
            clearAlerts(options.overlays);
        }

        controller.on('deviceRemoved', onDeviceRemoved);
        function onDeviceRemoved()
        {
            console.log("device removed ");
            appendAlert(options.overlays, ALERT_PLEASE_WAIT);
            $(leapRecorder).trigger('disconnected', ['leap']);
        }

        controller.on('deviceStopped', onDeviceStopped);
        function onDeviceStopped()
        {
            console.log("device stopped ");
            appendAlert(options.overlays, ALERT_PLEASE_WAIT);
            $(leapRecorder).trigger('disconnected', ['leap']);
        }

        controller.on('deviceStreaming', onDeviceStreaming);
        function onDeviceStreaming()
        {
            console.log("device streaming ");
            clearAlerts(options.overlays);
            $(leapRecorder).trigger('ready', ['leap']);
        }

        controller.on('blur', onBlur);
        function onBlur()
        {
            console.log("controller blur event");
        }
    }

    if (options.pauseOnHand) {
        controller.on('playback.userTakeControl', function () {
            $(options.playbackElement).find('.fa').removeClass('fa-pause').addClass('fa-play');
        });

        controller.on('playback.userReleaseControl', function () {
            $(options.playbackElement).find('.fa').removeClass('fa-play').addClass('fa-pause');
        });
    }

    if (options.recordElement) {
        $(options.recordElement).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                controller.plugins.playback.player.record();
            }
        });

        controller.on('playback.record', function () {
            if (options.recordElement) {
                $(options.recordElement).addClass('disabled');
            }

            if (options.stopRecordElement) {
                $(options.stopRecordElement).removeClass('disabled');
            }

            if (options.cropRecordElement) {
                if ($(options.cropRecordElement).hasClass('cropping')) {
                    $(options.cropRecordElement).click();
                }
                $(options.cropRecordElement).addClass('disabled');
            }

            if (options.playbackElement) {
                $(options.playbackElement).addClass('disabled');
            }

            if (options.playbackSliderElement) {
                $(options.playbackSliderElement).slider();
                $(options.playbackSliderElement).slider('destroy');
                $(options.playbackSliderElement).parent().addClass('hidden');
            }
        });
    }

    controller.on('playback.recordingFinished', function () {
        if (options.recordElement) {
            $(options.recordElement).removeClass('disabled');
        }
        if (options.stopRecordElement) {
            $(options.stopRecordElement).addClass('disabled');
        }

        recordedFrameData = leapRecorder.recording('json');
        if (options.initPlaybackControlsAfterRecord && options.initPlaybackControlsAfterRecord === true) {
            leapRecorder.initializePlaybackControls(controller, options);
        }
        $(leapRecorder).trigger('recordingStopped', ['leap']);
    });

    if (options.stopRecordElement) {
        $(options.stopRecordElement).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                controller.plugins.playback.player.stopRecord();
            }
        });
    }

    if (options.loadRecordingElement) {
        $(options.loadRecordingElement).unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(options.loadInputElement).find('.fileUpload').click();
        });
    }

    if (options.loadInputElement || options.recording) {
        controller.on('playback.ajax:complete', function (frames) {
            console.log('playback.ajax:complete');
            leapRecorder.initializePlaybackControls(controller, options);
        });
    }

    if (options.loadInputElement) {
        $(options.loadInputElement).find('.fileUpload').unbind('change').bind('change', function (event) {
            event.preventDefault();
            if (event.handled !== true)
            {
                event.handled = true;
                var uploadFiles = $(this)[0].files[0];
                if (uploadFiles) {
                    var fr = new FileReader();
                    fr.onload = function (evt) {
                        if (controller.plugins.playback.player.recording) {
                            controller.plugins.playback.player.recording.readFileData(evt.target.result, uploadFiles, function () {
                                console.log('file loaded successfully ');
                                leapRecorder.initializePlaybackControls(controller, options);
                            });
                        } else {
                            var format = 'json';
                            if (uploadFiles.name && uploadFiles.name.split('.')[uploadFiles.name.split('.').length - 1] === 'lz') {
                                format = 'lz';
                            }
                            controller.plugins.playback.player.importFrameData(evt.target.result, format, function () {
                                console.log('raw data imported successfully ');
                                leapRecorder.initializePlaybackControls(controller, options);
                            });
                        }
                    };
                    fr.readAsText($(this)[0].files[0]);
                }
            }
        });
    }

//    console.log(options);
    if (options.rawData) {
        leapRecorder.importRawSensorData(options.rawData, 'json', function (frames) {
            leapRecorder.initializePlaybackControls(leapRecorder.options.controller, leapRecorder.options);
        });
    }

//    if (options.compressedData) {
//        console.log('import compressed sensor data');
//        leapRecorder.importRawSensorData(options.compressedData, 'lz', function (frames) {
//            console.log('compressed data imported successfully', frames);
//            recordedFrameData = frames;
//            leapRecorder.initializePlaybackControls(leapRecorder.options.controller, leapRecorder.options);
//        });
//    }
}

LeapRecorder.prototype.importRawSensorData = function (data, format, callback) {
//    console.log('import sensor data: ', data, format);
    if (leapRecorder.options.controller && leapRecorder.options.controller.plugins && leapRecorder.options.controller.plugins.playback.player) {
        leapRecorder.options.controller.plugins.playback.player.importFrameData(data, format || 'json', callback);
    }
};

LeapRecorder.prototype.crops = {};
LeapRecorder.prototype.tempCrops = null;
LeapRecorder.prototype.initializePlaybackControls = function (controller, options) {
    leapRecorder.resetPlaybackControls();
    var togglePlaybackButton = $(leapRecorder.options.parent).find('.gr-playback #leap-preview .btn-toggle-playback');
    if (options && options.playbackElement) {
        togglePlaybackButton = $(options.playbackElement);
    }

    var playbackSlider = null;
    var cropSlider = null;
//    var cropSlider = $(leapRecorder.options.parent).find('.gr-playback #leap-preview #leap-playback-crop-slider');
    if (options && options.cropSliderElement && options.cropSliderElement.length > 0) {
        cropSlider = $(options.cropSliderElement);
    }

    var frameLength = Math.max(controller.plugins.playback.player.recording.frameData.length - 1, 0);
    console.log('crops', leapRecorder.crops);
    if (!leapRecorder.crops) {
        leapRecorder.crops = {left: 0, right: frameLength};
    }

    console.log('options', options);
    // check if is preview of recorded data or trimming possible

    if (options && options.playbackSliderElement && options.playbackSliderElement.length > 0) {
        playbackSlider = options.playbackSliderElement;
    } else {
        if (leapRecorder.tempCrops) {
            console.log('set temp crops to crop data', leapRecorder.tempCrops);
            leapRecorder.crops = leapRecorder.tempCrops;
            leapRecorder.tempCrops = null;
        }
    }

    leapRecorder.options.controller.removeAllListeners('playback.beforeSendFrame');

    leapRecorder.options.controller.on('playback.beforeSendFrame', function () {
        var currentTime = leapRecorder.options.controller.plugins.playback.player.recording.frameIndex;
        if (cropSlider) {
            if (currentTime < leapRecorder.crops.left || currentTime > leapRecorder.crops.right) {
                controller.plugins.playback.player.setFrameIndex(parseInt(leapRecorder.crops.left, 10));
            }
        } else if (playbackSlider) {
            $(playbackSlider).slider('setValue', currentTime);
        }
    });

    $(togglePlaybackButton).unbind('click').bind('click', function (event) {
        event.preventDefault();
        if ($(togglePlaybackButton).hasClass('playing')) {
            $(togglePlaybackButton).removeClass('playing');
            $(this).find('.fa').removeClass('fa-pause').addClass('fa-play');
            controller.plugins.playback.player.pause();
        } else {
            $(togglePlaybackButton).addClass('playing');
            $(this).find('.fa').removeClass('fa-play').addClass('fa-pause');
            var currentFrame = controller.plugins.playback.player.recording.frameIndex;
            if (currentFrame < leapRecorder.crops.left || currentFrame > leapRecorder.crops.right) {
                controller.plugins.playback.player.setFrameIndex(parseInt(leapRecorder.crops.left, 10));
            }

            controller.plugins.playback.player.play();
        }
    });

    if (options.autoplayPlayback && options.autoplayPlayback === true && $(togglePlaybackButton).attr('data-state') === 'paused') {
        $(togglePlaybackButton).click();
    }

    var slider = null;
    var sliderOptions = {
        min: 0,
        max: frameLength,
        step: 1
    };

    console.log('cropslider?', cropSlider, playbackSlider);
    if (cropSlider) {
        slider = cropSlider;
        sliderOptions.value = [leapRecorder.crops.left, leapRecorder.crops.right];
    } else if (playbackSlider) {
        slider = playbackSlider;
        sliderOptions.value = leapRecorder.crops.left;
    }

    console.log('slideroptions, slider', sliderOptions, slider, options);
    if (sliderOptions && slider) {
        $(slider).parent().removeClass('hidden disabled');
        try {
            $(cropSlider).slider('destroy');
        } catch (error) {
            console.log(error);
        }

        $(slider).slider(sliderOptions);
    }


    $(slider).unbind('change').bind('change', function (event) {
        if (cropSlider) {
            updateCropping(event.value.newValue);
        } else if (playbackSlider) {
            controller.plugins.playback.player.setFrameIndex(parseInt(event.value.newValue, 10));
        }
    });

    $(slider).unbind('slideStart').bind('slideStart', function (event) {
        if ($(togglePlaybackButton).hasClass('playing')) {
            $(togglePlaybackButton).click();
        }
    });

    $(slider).unbind('slideStop').bind('slideStop', function (event) {
        if (!$(togglePlaybackButton).hasClass('playing')) {
            $(togglePlaybackButton).click();
        }
    });

    function updateCropping(newValues) {
        if (leapRecorder.crops.left !== newValues[0]) {
            leapRecorder.crops.left = newValues[0];
            controller.plugins.playback.player.recording.leftCrop();
            controller.plugins.playback.player.setFrameIndex(parseInt(newValues[0], 10));
        } else if (leapRecorder.crops.right !== newValues[1]) {
            leapRecorder.crops.right = newValues[1];
            controller.plugins.playback.player.setFrameIndex(parseInt(newValues[1], 10));
            controller.plugins.playback.player.recording.rightCrop();
        }

//        console.log('update cropping', leapRecorder.crops);
    }

    if (options.downloadJsonElement) {
        $(options.downloadJsonElement).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (controller && controller.plugins && controller.plugins.playback.player) {
                controller.plugins.playback.player.recording.save('json');
            }
        });
    }

    if (options.downloadCompressedElement) {
        $(options.downloadCompressedElement).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (controller && controller.plugins && controller.plugins.playback.player) {
                controller.plugins.playback.player.recording.save('lz');
            }
        });
    }

    return null;
//    function initPlaybackSlider(highlightRange) {
//        var frameLength = Math.max(controller.plugins.playback.player.recording.frameData.length - 1, 0);
////        var crops = {left: controller.plugins.playback.player.recording.leftCropPosition, };
//        var sliderOptions = {
//            min: 0,
//            max: frameLength,
//            step: 1,
//            value: leapRecorder.crops.left
//        };
//        if (highlightRange === true && (leapRecorder.crops.left > 0 || leapRecorder.crops.right < frameLength)) {
//            sliderOptions.rangeHighlights = [{start: leapRecorder.crops.left, end: leapRecorder.crops.right, class: "isGesture"}];
//        }
//
//        $(options.playbackSliderElement).unbind('change');
//        $(options.playbackSliderElement).slider(sliderOptions);
//        $(options.playbackSliderElement).slider('destroy');
//        $(options.playbackSliderElement).slider(sliderOptions);
//
//        $(options.playbackSliderElement).unbind('change').bind('change', function (event) {
//            if ($(options.playbackElement).attr('data-state') === 'playing') {
//                if (options.playbackElement) {
//                    $(options.playbackElement).click();
//                }
//            } else {
//                controller.plugins.playback.player.setFrameIndex(parseInt(event.value.newValue, 10));
//            }
//        });
//
//        leapRecorder.options.controller.removeAllListeners('playback.beforeSendFrame');
//        leapRecorder.options.controller.on('playback.beforeSendFrame', function () {
//            $(options.playbackSliderElement).slider('setValue', leapRecorder.options.controller.plugins.playback.player.recording.frameIndex);
//        });
//    }
//
//    if (options.playbackElement) {
//        if (options.playbackSliderElement) {
//            $(options.playbackSliderElement).parent().removeClass('hidden disabled');
//            initPlaybackSlider();
//        }
//
//        $(options.playbackElement).unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if ($(options.cropRecordElement).hasClass('cropping')) {
//                $(options.cropRecordElement).click();
//            }
//
//            if ($(this).attr('data-state') === 'playing') {
//                $(this).attr('data-state', 'paused');
//                $(this).find('.fa').removeClass('fa-pause').addClass('fa-play');
//                controller.plugins.playback.player.pause();
//            } else if ($(this).attr('data-state') === 'paused') {
//                $(this).attr('data-state', 'playing');
//                $(this).find('.fa').removeClass('fa-play').addClass('fa-pause');
//                if (options.cropRecordElement) {
//                    $(options.cropRecordElement).removeClass('cropping');
//                }
//                if (options.playbackSliderElement) {
//                    $(options.playbackSliderElement).parent().removeClass('hidden disabled');
//                }
//
//                if (options.cropSliderElement) {
//                    $(options.cropSliderElement).addClass('hidden');
//                }
//
////                var crops = {left: controller.plugins.playback.player.recording.leftCropPosition, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition - 1, 0)};
//                var currentFrame = controller.plugins.playback.player.recording.frameIndex;
//                if (currentFrame < leapRecorder.crops.left || currentFrame > leapRecorder.crops.right) {
//                    controller.plugins.playback.player.setFrameIndex(parseInt(leapRecorder.crops.left, 10));
//                }
//
//                controller.plugins.playback.player.play();
//            }
//        });
//    }
//
//    if (options.cropRecordElement) {
//        $(options.cropRecordElement).removeClass('disabled');
//        $(options.cropRecordElement).unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            if (!$(this).hasClass('disabled')) {
//                if ($(options.playbackElement).attr('data-state') === 'playing') {
//                    $(options.playbackElement).click();
//                }
//
//                if ($(this).hasClass('cropping')) {
//                    $(this).removeClass('cropping');
//                    if (options.playbackSliderElement) {
//                        $(options.playbackSliderElement).slider('destroy');
//                        $(options.playbackSliderElement).parent().removeClass('hidden');
//                    }
//
//                    if (options.cropSliderElement) {
//                        $(options.cropSliderElement).slider('destroy');
//                        $(options.cropSliderElement).parent().addClass('hidden');
//                    }
//
//                    initPlaybackSlider(true);
//                } else {
//                    $(this).addClass('cropping');
//                    if (options.playbackSliderElement) {
//                        $(options.playbackSliderElement).parent().addClass('hidden');
//                    }
//                    if (options.cropSliderElement) {
//                        $(options.cropSliderElement).parent().removeClass('hidden disabled');
//                        var frameLength = Math.max(controller.plugins.playback.player.recording.frameData.length, 0);
////                        var cropPositions = {left: controller.plugins.playback.player.recording.leftCropPosition, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition, 0)};
//                        $(options.cropSliderElement).slider({
//                            min: 0,
//                            max: frameLength,
//                            value: [leapRecorder.crops.left, leapRecorder.crops.right]
//                        });
////                        $(options.cropSliderElement).unbind('slide').bind('slide', function (event) {
////                            var cropPositions = {left: controller.plugins.playback.player.recording.leftCropPosition, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition, 0)};
////                            updateCropping(cropPositions, event.value);
////                        });
//
//                        $(options.cropSliderElement).unbind('change').bind('change', function (event) {
//                            updateCropping(event.value.newValue);
////                            updateCropping(controller.plugins.playback.player.recording.leftCropPosition, Math.max(controller.plugins.playback.player.recording.rightCropPosition, 0));
////                            var cropPositions = {left: controller.plugins.playback.player.recording.leftCropPosition, right: };
////                            updateCropping(cropPositions, event.value.newValue);
//                        });
//                    }
//                }
//            }
//        });
//        function updateCropping(newValues) {
//            if (leapRecorder.crops.left !== newValues[0]) {
//                leapRecorder.crops.left = newValues[0];
//                controller.plugins.playback.player.recording.leftCrop();
//                controller.plugins.playback.player.setFrameIndex(parseInt(newValues[0], 10));
//            } else if (leapRecorder.crops.right !== newValues[1]) {
//                leapRecorder.crops.right = newValues[1];
//                controller.plugins.playback.player.setFrameIndex(parseInt(newValues[1], 10));
//                controller.plugins.playback.player.recording.rightCrop();
//            }
//        }
//    }
//
//    if (leapRecorder.options.autoplay === true) {
//        leapRecorder.play();
//    } else {
//        leapRecorder.stop();
//        controller.plugins.playback.player.pause();
//    }
};

LeapRecorder.prototype.resetPlaybackControls = function () {
    var preview = $(leapRecorder.options.parent).find('.gr-playback #leap-preview');
    var playbackVideo = $(preview).find('#renderArea');
    $(playbackVideo).css({borderBottomLeftRadius: "0px", borderBottomRightRadius: "0px"});
    leapRecorder.options.controller.removeAllListeners('playback.beforeSendFrame');
    $(preview).find('.controls-container').removeClass('hidden');
    $(preview).find('#playback-leap-slider-controls').removeClass('hidden');
    leapRecorder.crops = null;
};

LeapRecorder.prototype.record = function () {
    var options = this.options;
    if (options.controller && options.controller.plugins.playback) {
        if (options.recordElement) {
            $(options.recordElement).click();
        } else {
            options.controller.plugins.playback.player.record();
        }
    }
};

LeapRecorder.prototype.stopRecord = function () {
    var options = this.options;
    if (options.controller && options.controller.plugins.playback) {
        leapRecorder.crops = null;
        if (options.stopRecordElement) {
            $(options.stopRecordElement).click();
        } else {
            options.controller.plugins.playback.player.stopRecord();
        }
    }
};

LeapRecorder.prototype.play = function (container) {
    var options = leapRecorder.options;
    if (options.playbackElement && $(options.playbackElement).attr('data-state') === 'paused') {
        $(options.playbackElement).click();
    } else if (!options.playbackElement && options.controller.plugins.playback) {
        options.controller.plugins.playback.player.play();
    }
};
LeapRecorder.prototype.stop = function (container) {
    var options = leapRecorder.options;
    if (options.playbackElement && $(options.playbackElement).attr('data-state') === 'playing') {
        $(options.playbackElement).click();
    } else if (!options.playbackElement && options.controler.plugins.playback) {
        options.controller.plugins.playback.player.pause();
    }
};

var recordedFrameData = null;
var croppedRecordedFrameData = null;
LeapRecorder.prototype.playback = function () {
    leapRecorder.resetPlaybackControls();
    var currentOptions = leapRecorder.options;
    var container = $(currentOptions.parent).find('.gr-playback #leap-preview');
    if (currentOptions.compressedData) {
        leapRecorder.importRawSensorData(currentOptions.compressedData, 'lz', function (frames) {
            recordedFrameData = leapRecorder.recording('json');
            initLeapPlayback();
        });
    } else {
        initLeapPlayback();
    }

    function initLeapPlayback() {
        var options = currentOptions;
        options.autoplay = currentOptions.autoplayPlayback;
        options.controller = currentOptions.controller;
        options.parent = currentOptions.parent;
        options.rawData = recordedFrameData;
        options.playbackElement = $(container).find('.btn-toggle-playback');
        options.downloadJsonElement = $(container).find('.btn-download-as-json');
        options.downloadCompressedElement = $(container).find('.btn-download-as-compressed');
        options.playbackSliderElement = null;
//        options.cropRecordElement = $(container).find('#btn-toggle-cropping');
        options.cropSliderElement = $(container).find('#leap-crop-slider');

        leapRecorder.options = options;
        leapRecorder.importRawSensorData(options.rawData, 'json', function () {
            leapRecorder.updateRenderTarget($(container).find('#renderArea'));
            leapRecorder.initializePlaybackControls(options.controller, options);
            $(leapRecorder).trigger('playbackReady', ['leap']);
        });
    }
};

LeapRecorder.prototype.recordedData = function () {
    return {type: TYPE_RECORD_LEAP, compressedData: leapRecorder.recording('lz')};
};

var leapSaveGestureData = null;
LeapRecorder.prototype.extract = function () {
    extractionStopped = false;
    var preview = $(leapRecorder.options.parent).find('.gr-playback #leap-preview');
    var playbackVideo = $(preview).find('#renderArea');
    $(playbackVideo).css({borderRadius: "8px"});

//    var togglePlaybackButton = $(leapRecorder.options.parent).find('.gr-playback #leap-preview .btn-toggle-playback');
    leapRecorder.stop();
//    if ($(togglePlaybackButton).hasClass('playing')) {
//        $(togglePlaybackButton).click();
//    }

    $(preview).find('.controls-container').addClass('hidden');
    $(preview).find('#playback-leap-slider-controls').addClass('hidden');
    croppedRecordedFrameData = leapRecorder.recording('json');
    leapSaveGestureData = {sensorData: leapRecorder.recording('lz')};
    $(leapRecorder).trigger('dataExtracted', ['leap']);
};

var extractionStopped = false;
LeapRecorder.prototype.stopExtraction = function () {
    extractionStopped = true;
};

LeapRecorder.prototype.showSave = function () {
    console.log('show save');
    leapRecorder.tempCrops = {left: leapRecorder.crops.left, right: leapRecorder.crops.right};
    leapRecorder.resetPlaybackControls();

    var currentOptions = leapRecorder.options;
    var container = $(currentOptions.parent).find('.gr-save #leap-save-preview');
    var options = currentOptions;
    options.autoplay = currentOptions.autoplaySave;
    options.controller = currentOptions.controller;
    options.parent = currentOptions.parent;
    options.rawData = croppedRecordedFrameData;
    options.playbackElement = $(container).find('.btn-toggle-playback');
    options.downloadJsonElement = $(container).find('.btn-download-as-json');
    options.downloadCompressedElement = $(container).find('.btn-download-as-compressed');
    options.playbackSliderElement = $(container).find('#leap-playback-slider');
    options.cropSliderElement = null;

    leapRecorder.options = options;

    leapRecorder.importRawSensorData(options.rawData, 'json', function () {
        leapRecorder.updateRenderTarget($(container).find('#renderArea'));
        leapRecorder.initializePlaybackControls(options.controller, options);
    });
};

LeapRecorder.prototype.attachSaveData = function (uploadFiles) {
    var saveData = {};
    if (uploadFiles && uploadFiles === true) {
        var uploadQueue = new UploadQueue();
        $(uploadQueue).bind(EVENT_ALL_FILES_UPLOADED, function () {
            saveData.sensorData = {sensor: 'leap', url: uploadQueue.getUploadURLs()[0]};
            $(leapRecorder).trigger('saveDataAttached', ['leap', saveData]);
        });
        $(uploadQueue).bind(EVENT_UPLOAD_PROGRESS_ALL, function (event, progress) {
            event.preventDefault();
            updateProgressSensorData(progress);
        });
        // upload leap motion data as compressed lz file
        var filename = sha512(new Date().getTime().toString()) + ".lz";
        uploadQueue.upload([leapSaveGestureData.sensorData], filename);
    } else {
        saveData.sensorData = {sensor: 'leap', url: leapSaveGestureData.sensorData};
        $(leapRecorder).trigger('saveDataAttached', ['leap', saveData]);
    }

    function updateProgressSensorData(progress) {
//        console.log('update progress sensor data', progress);
        $(leapRecorder.options.parent).find('#progress-sensor-data').removeClass('hidden');
        $(leapRecorder.options.parent).find('#progress-sensor-data .progress-bar').attr('aria-valuenow', progress).css({width: progress + '%'}).text(parseInt(progress) + '%');
    }
};

LeapRecorder.prototype.showSaveSuccess = function () {
    leapRecorder.resetPlaybackControls();
    var currentOptions = leapRecorder.options;
    var container = $(currentOptions.parent).find('.gr-save-success #leap-save-success-preview');
    var options = currentOptions;
    options.autoplay = currentOptions.autoplaySaveSuccess;
    options.controller = currentOptions.controller;
    options.parent = currentOptions.parent;
    options.rawData = croppedRecordedFrameData;
    options.playbackElement = $(container).find('.btn-toggle-playback');
    options.downloadJsonElement = $(container).find('.btn-download-as-json');
    options.downloadCompressedElement = $(container).find('.btn-download-as-compressed');
    options.playbackSliderElement = $(container).find('#leap-playback-slider');
    options.cropSliderElement = null;

    leapRecorder.options = options;
    leapRecorder.importRawSensorData(options.rawData, 'json', function () {
        leapRecorder.updateRenderTarget($(container).find('#renderArea'));
        leapRecorder.initializePlaybackControls(options.controller, options);
    });
};

LeapRecorder.prototype.recording = function (format) {
    var options = this.options;
    if (options.controller && options.controller.plugins.playback) {
        return options.controller.plugins.playback.player.recording.export(format);
    }
};

LeapRecorder.prototype.updateRenderTarget = function (target) {
    var options = this.options;
    if (options.controller && options.controller.plugins.riggedHand) {
        options.controller.plugins.riggedHand.updateRenderTarget(target);
    }
};

LeapRecorder.prototype.destroy = function (destroyRecord) {
    var options = this.options;
    if (destroyRecord && destroyRecord === true) {
        leapSaveGestureData = null;
        croppedRecordedFrameData = null;
    }

    if (options.controller) {
        if (options.controller.plugins.playback) {
            options.controller.plugins.playback.player.pause();
        }

        options.controller.removeAllListeners('playback.beforeSendFrame');
        options.controller.connection.removeAllListeners('frame');
        options.controller.removeAllListeners('connect');
        options.controller.removeAllListeners('deviceAttached');
        options.controller.removeAllListeners('deviceRemoved');
        options.controller.removeAllListeners('deviceStreaming');
        options.controller.removeAllListeners('deviceStopped');
        options.controller.removeAllListeners('blur');
        options.controller.stopUsing('playback');
        options.controller.stopUsing('riggedHand');
        options.controller = null;
    }

    if (options.renderTarget) {
        $(options.renderTarget).find('canvas').remove();
    } else {
        $('body').find('canvas').remove();
    }

    if (leapRecorder) {
        if (leapRecorder.crops) {
            leapRecorder.crops = {};
        }
    }
};