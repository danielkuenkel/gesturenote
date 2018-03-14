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
        autoPlay: options.autoplay || false,
        recording: options.recording || false,
        requiredProtocolVersion: 6,
        pauseOnHand: options.pauseOnHand || false,
        overlay: false
    });
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

    if (options.loadRecordingElement) {
        $(options.loadRecordingElement).unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(options.loadInputElement).find('.fileUpload').click();
        });
    }

    if (options.loadInputElement || options.recording) {
        controller.on('playback.ajax:complete', function (frames) {
//            console.log('load complete', frames);
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

    if (options.rawData) {
        leapRecorder.importRawSensorData('json', function () {
            leapRecorder.initializePlaybackControls(leapRecorder.options.controller, leapRecorder.options);
        });
    }
}

LeapRecorder.prototype.importRawSensorData = function (format, callback) {
    if (leapRecorder.options.rawData && leapRecorder.options.controller && leapRecorder.options.controller.plugins && leapRecorder.options.controller.plugins.playback.player) {
        leapRecorder.options.controller.plugins.playback.player.importFrameData(leapRecorder.options.rawData, format || 'json', callback);
    }
};

LeapRecorder.prototype.crops = {};
LeapRecorder.prototype.initializePlaybackControls = function (controller, options) {
    leapRecorder.resetPlaybackControls();
    var autoPlay = controller.plugins.playback.player.autoPlay;
    leapRecorder.crops = {left: 0, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition - 1, 0)};

    function initPlaybackSlider(highlightRange) {
        var frameLength = Math.max(controller.plugins.playback.player.recording.frameData.length - 1, 0);
//        var crops = {left: controller.plugins.playback.player.recording.leftCropPosition, };
        var sliderOptions = {
            min: 0,
            max: frameLength,
            step: 1,
            value: leapRecorder.crops.left
        };
        if (highlightRange === true && (leapRecorder.crops.left > 0 || leapRecorder.crops.right < frameLength)) {
            sliderOptions.rangeHighlights = [{start: leapRecorder.crops.left, end: leapRecorder.crops.right, class: "isGesture"}];
        }
        
        $(options.playbackSliderElement).unbind('change');
        $(options.playbackSliderElement).slider(sliderOptions);
        $(options.playbackSliderElement).slider('destroy');
        $(options.playbackSliderElement).slider(sliderOptions);

        $(options.playbackSliderElement).unbind('slide').bind('slide', function (event) {
            if (controller.plugins.playback.player.state === 'playing') {
                if (options.playbackElement) {
                    $(options.playbackElement).click();
                }
            } else {
                controller.plugins.playback.player.setFrameIndex(parseInt(event.value, 10));
            }
        });

        controller.removeAllListeners('playback.beforeSendFrame');
        controller.on('playback.beforeSendFrame', function () {
            $(options.playbackSliderElement).slider('setValue', controller.plugins.playback.player.recording.frameIndex);
        });
    }

    if (options.playbackSliderElement) {
        $(options.playbackSliderElement).parent().removeClass('hidden disabled');
        initPlaybackSlider();

        $(options.playbackElement).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if ($(options.cropRecordElement).hasClass('cropping')) {
                $(options.cropRecordElement).click();
            }

            if (controller.plugins.playback.player.state === 'playing') {
                $(this).find('.fa').removeClass('fa-pause').addClass('fa-play');
                controller.plugins.playback.player.pause();
            } else if (controller.plugins.playback.player.state === 'idle') {
                $(this).find('.fa').removeClass('fa-play').addClass('fa-pause');

                if (options.cropRecordElement) {
                    $(options.cropRecordElement).removeClass('cropping');
                }
                if (options.playbackSliderElement) {
                    $(options.playbackSliderElement).parent().removeClass('hidden disabled');
                }

                if (options.cropSliderElement) {
                    $(options.cropSliderElement).addClass('hidden');
                }

//                var crops = {left: controller.plugins.playback.player.recording.leftCropPosition, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition - 1, 0)};
                var currentFrame = controller.plugins.playback.player.recording.frameIndex;
                if (currentFrame < leapRecorder.crops.left || currentFrame > leapRecorder.crops.right) {
                    controller.plugins.playback.player.setFrameIndex(parseInt(leapRecorder.crops.left, 10));
                }

                controller.plugins.playback.player.play();
            }
        });
    }

    if (options.cropRecordElement) {
        $(options.cropRecordElement).removeClass('disabled');

        $(options.cropRecordElement).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                if (controller.plugins.playback.player.state === 'playing') {
                    $(options.playbackElement).click();
                }

                if ($(this).hasClass('cropping')) {
                    $(this).removeClass('cropping');

                    if (options.playbackSliderElement) {
                        $(options.playbackSliderElement).slider('destroy');
                        $(options.playbackSliderElement).parent().removeClass('hidden');
                    }

                    if (options.cropSliderElement) {
                        $(options.cropSliderElement).slider('destroy');
                        $(options.cropSliderElement).parent().addClass('hidden');
                    }

                    initPlaybackSlider(true);
                } else {
                    $(this).addClass('cropping');
                    if (options.playbackSliderElement) {
                        $(options.playbackSliderElement).parent().addClass('hidden');
                    }
                    if (options.cropSliderElement) {
                        $(options.cropSliderElement).parent().removeClass('hidden disabled');

                        var frameLength = Math.max(controller.plugins.playback.player.recording.frameData.length, 0);
                        var cropPositions = {left: controller.plugins.playback.player.recording.leftCropPosition, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition, 0)};
                        $(options.cropSliderElement).slider({
                            min: 0,
                            max: frameLength,
                            value: [cropPositions.left, cropPositions.right]
                        });

//                        $(options.cropSliderElement).unbind('slide').bind('slide', function (event) {
//                            var cropPositions = {left: controller.plugins.playback.player.recording.leftCropPosition, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition, 0)};
//                            updateCropping(cropPositions, event.value);
//                        });

                        $(options.cropSliderElement).unbind('change').bind('change', function (event) {
                            updateCropping(event.value.newValue);
//                            updateCropping(controller.plugins.playback.player.recording.leftCropPosition, Math.max(controller.plugins.playback.player.recording.rightCropPosition, 0));
//                            var cropPositions = {left: controller.plugins.playback.player.recording.leftCropPosition, right: };
//                            updateCropping(cropPositions, event.value.newValue);
                        });
                    }
                }
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
        }
    }

    if (options.playbackElement) {
        var crops = {left: controller.plugins.playback.player.recording.leftCropPosition, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition - 1, 0)};
        controller.plugins.playback.player.setFrameIndex(parseInt(crops.left, 10));
        $(options.playbackElement).removeClass('disabled');

        if (autoPlay) {
            $(options.playbackElement).find('.fa').removeClass('fa-play').addClass('fa-pause');
            controller.plugins.playback.player.play();
        }
    }
};

LeapRecorder.prototype.resetPlaybackControls = function () {
    var preview = $(leapRecorder.options.parent).find('.gr-playback #leap-preview');
    var playbackVideo = $(preview).find('#renderArea');
    $(playbackVideo).css({borderBottomLeftRadius: "0px", borderBottomRightRadius: "0px"});

    $(preview).find('.controls-container').removeClass('hidden');
    $(preview).find('#playback-leap-slider-controls').removeClass('hidden');
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
        if (options.stopRecordElement) {
            $(options.stopRecordElement).click();
        } else {
            options.controller.plugins.playback.player.stopRecord();
        }
    }
};

var recordedFrameData = null;
var croppedRecordedFrameData = null;
LeapRecorder.prototype.playback = function () {
    console.log('playback leap');
    leapRecorder.resetPlaybackControls();
    var currentOptions = leapRecorder.options;
//    leapRecorder.destroy();
    var container = $(currentOptions.parent).find('.gr-playback #leap-preview');

    var options = {
        controller: currentOptions.controller,
        parent: currentOptions.parent,
//        previewOnly: true,
//        pauseOnHands: false,
//        autoplay: true,
        rawData: recordedFrameData,
////        recordEmptyHands: true,
////            recording: currentPreviewGesture.gesture.sensorData.url,
////        overlays: $(container).find('#leap-alert-space'),
//        renderTarget: $(container).find('#renderArea'),
////            recordElement: $(container).find('#btn-start-recording'),
////            stopRecordElement: $(container).find('#btn-stop-recording'),
        playbackElement: $(container).find('#btn-toggle-playback'),
        downloadJsonElement: $(container).find('.btn-download-as-json'),
        downloadCompressedElement: $(container).find('.btn-download-as-compressed'),
////            loadRecordingElement: $(container).find('#btn-load-recording'),
////            loadInputElement: $(container).find('#upload-leap-recording'),
        playbackSliderElement: $(container).find('#leap-playback-slider'),
        cropRecordElement: $(container).find('#btn-toggle-cropping'),
        cropSliderElement: $(container).find('#leap-playback-crop-slider')
    };
    leapRecorder.options = options;
//
//    leapRecorder = new LeapRecorder(options);
//    $(document).trigger('instanceUpdated', ['leap', leapRecorder]);
    leapRecorder.importRawSensorData('json', function () {
        leapRecorder.updateRenderTarget($(container).find('#renderArea'));
        leapRecorder.initializePlaybackControls(options.controller, options);
        $(leapRecorder).trigger('playbackReady', ['leap']);
    });
};

var leapSaveGestureData = null;
LeapRecorder.prototype.extract = function () {
    extractionStopped = false;

    var preview = $(leapRecorder.options.parent).find('.gr-playback #leap-preview');
    var playbackVideo = $(preview).find('#renderArea');
    $(playbackVideo).css({borderRadius: "4px"});

    var toggleCroppingButton = $(preview).find('#btn-toggle-cropping');
    if ($(toggleCroppingButton).hasClass('cropping')) {
        $(toggleCroppingButton).click();
    }

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
    leapRecorder.resetPlaybackControls();
    var currentOptions = leapRecorder.options;
    var container = $(currentOptions.parent).find('.gr-save #leap-save-preview');

    var options = {
        controller: currentOptions.controller,
        parent: currentOptions.parent,
        rawData: croppedRecordedFrameData,
        playbackElement: $(container).find('#btn-toggle-playback'),
        downloadJsonElement: $(container).find('.btn-download-as-json'),
        downloadCompressedElement: $(container).find('.btn-download-as-compressed'),
        playbackSliderElement: $(container).find('#leap-playback-slider')
    };
    leapRecorder.options = options;
    leapRecorder.importRawSensorData('json', function () {
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

        // upload leap motion data as compressed lz file
        var filename = hex_sha512(new Date().getTime().toString()) + ".lz";
        uploadQueue.upload([leapSaveGestureData.sensorData], filename);
    } else {
        saveData.sensorData = {sensor: 'leap', url: leapSaveGestureData.sensorData};
        $(leapRecorder).trigger('saveDataAttached', ['leap', saveData]);
    }

};

LeapRecorder.prototype.showSaveSuccess = function () {
    leapRecorder.resetPlaybackControls();
    var currentOptions = leapRecorder.options;
    leapRecorder.destroy();
    var container = $(currentOptions.parent).find('.gr-save-success #leap-save-success-preview');

    var options = {
        controller: currentOptions.controller,
        parent: currentOptions.parent,
        rawData: croppedRecordedFrameData,
        playbackElement: $(container).find('#btn-toggle-playback'),
        downloadJsonElement: $(container).find('.btn-download-as-json'),
        downloadCompressedElement: $(container).find('.btn-download-as-compressed'),
        playbackSliderElement: $(container).find('#leap-playback-slider')
    };
    leapRecorder.options = options;
    leapRecorder.importRawSensorData('json', function () {
        leapRecorder.updateRenderTarget($(container).find('#renderArea'));
        leapRecorder.initializePlaybackControls(options.controller, options);
    });
};

LeapRecorder.prototype.recording = function (format) {
    var options = this.options;
    if (options.controller && options.controller.plugins.playback) {
        return options.controller.plugins.playback.player.recording.export(format);
//        if (format === 'lz') {
//            return new File([frameData], "tempframedata.json.lz", {type: "application/x-gzip;charset=utf-8"});
//        }
//        return new File([frameData], "tempframedata.json", {type: "text/JSON;charset=utf-8"});
    }
};

LeapRecorder.prototype.updateRenderTarget = function (target) {
    var options = this.options;
//    console.log(options.controller && options.controller.plugins.riggedHand);
    if (options.controller && options.controller.plugins.riggedHand) {
        options.controller.plugins.riggedHand.updateRenderTarget(target);
//        console.log(options.controller.plugins.riggedHand);
    }
};

LeapRecorder.prototype.destroy = function (destroyRecord) {
    var options = this.options;

    if (destroyRecord && destroyRecord === true) {
        leapSaveGestureData = null;
        croppedRecordedFrameData = null;
    }

    if (options.controller) {
        options.controller.connection.removeAllListeners('frame');
        options.controller.removeAllListeners('connect');
        options.controller.removeAllListeners('deviceAttached');
        options.controller.removeAllListeners('deviceRemoved');
        options.controller.removeAllListeners('deviceStreaming');
        options.controller.removeAllListeners('deviceStopped');
        options.controller.removeAllListeners('blur');
        options.controller.removeAllListeners('playback.beforeSendFrame');
        options.controller.stopUsing('playback');
        options.controller.stopUsing('riggedHand');
        options.controller = null;
    }

    if (options.renderTarget) {
        $(options.renderTarget).find('canvas').remove();
    } else {
        $('body').find('canvas').remove();
    }
};