/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

LeapMotionRecorder.prototype.options = null;

function LeapMotionRecorder(options) {
    var leapMotionRecorder = this;
    if (options) {
        leapMotionRecorder.options = options;
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

    if ((!options.previewOnly || options.previewOnly === false) && options.overlays) {
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
        }

        controller.on('deviceStopped', onDeviceStopped);
        function onDeviceStopped()
        {
            console.log("device stopped ");
            appendAlert(options.overlays, ALERT_PLEASE_WAIT);
        }

        controller.on('deviceStreaming', onDeviceStreaming);
        function onDeviceStreaming()
        {
            console.log("device streaming ");
            clearAlerts(options.overlays);
            $(leapMotionRecorder).trigger('deviceStreaming');
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
        initializeControls(controller, options);
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
        controller.on('playback.ajax:complete', function () {
            initializeControls(controller, options);
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
                        controller.plugins.playback.player.recording.readFileData(evt.target.result, uploadFiles, function () {
                            console.log('file loaded successfully ');
                            initializeControls(controller, options);
                        });
                    };
                    fr.readAsText($(this)[0].files[0]);
                }
            }
        });
    }

    if (options.rawData && controller && controller.plugins && controller.plugins.playback.player) {
        controller.plugins.playback.player.importFrameData(options.rawData, 'json', function () {
            console.log('raw data imported successfully ');
            initializeControls(controller, options);
        });
    }
}

function initializeControls(controller, options) {
    var autoPlay = controller.plugins.playback.player.autoPlay;
    function initPlaybackSlider(highlightRange) {
        var frameLength = Math.max(controller.plugins.playback.player.recording.frameData.length - 1, 0);
        var crops = {left: controller.plugins.playback.player.recording.leftCropPosition, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition - 1, 0)};
        var sliderOptions = {
            min: 0,
            max: frameLength,
            step: 1,
            value: crops.left
        };
        if (highlightRange === true && (crops.left > 0 || crops.right < frameLength)) {
            sliderOptions.rangeHighlights = [{start: crops.left, end: crops.right, class: "category1"}];
        }
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

                var crops = {left: controller.plugins.playback.player.recording.leftCropPosition, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition - 1, 0)};
                var currentFrame = controller.plugins.playback.player.recording.frameIndex;
                if (currentFrame < crops.left || currentFrame > crops.right) {
                    controller.plugins.playback.player.setFrameIndex(parseInt(crops.left, 10));
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

                        $(options.cropSliderElement).unbind('slide').bind('slide', function (event) {
                            var cropPositions = {left: controller.plugins.playback.player.recording.leftCropPosition, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition, 0)};
                            updateCropping(cropPositions, event.value);
                        });

                        $(options.cropSliderElement).unbind('change').bind('change', function (event) {
                            var cropPositions = {left: controller.plugins.playback.player.recording.leftCropPosition, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition, 0)};
                            updateCropping(cropPositions, event.value.newValue);
                        });
                    }
                }
            }
        });
    }

    function updateCropping(cropPositions, newValues) {
        if (parseInt(cropPositions.left) !== parseInt(newValues[0])) {
            controller.plugins.playback.player.setFrameIndex(parseInt(newValues[0], 10));
            controller.plugins.playback.player.recording.leftCrop();
        } else if (parseInt(cropPositions.right) !== parseInt(newValues[1])) {
            controller.plugins.playback.player.setFrameIndex(parseInt(newValues[1], 10));
            controller.plugins.playback.player.recording.rightCrop();
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
}

LeapMotionRecorder.prototype.record = function () {
    var options = this.options;
    if (options.controller && options.controller.plugins.playback) {
        if (options.recordElement) {
            $(options.recordElement).click();
        } else {
            options.controller.plugins.playback.player.record();
        }
    }
};

LeapMotionRecorder.prototype.stopRecord = function () {
    var options = this.options;
    if (options.controller && options.controller.plugins.playback) {
        if (options.stopRecordElement) {
            $(options.stopRecordElement).click();
        } else {
            options.controller.plugins.playback.player.stopRecord();
        }
    }
};

LeapMotionRecorder.prototype.recording = function (format) {
    var options = this.options;
    if (options.controller && options.controller.plugins.playback) {
        return options.controller.plugins.playback.player.recording.export(format);
        if (format === 'lz') {
            return new File([frameData], "tempframedata.json.lz", {type: "application/x-gzip;charset=utf-8"});
        }
        return new File([frameData], "tempframedata.json", {type: "text/JSON;charset=utf-8"});
    }
};

LeapMotionRecorder.prototype.updateRenderTarget = function (target) {
    var options = this.options;
    if (options.controller && options.controller.plugins.riggedHand) {
        options.controller.plugins.riggedHand.updateRenderTarget(target);
        console.log(options.controller.plugins.riggedHand);
    }
};

LeapMotionRecorder.prototype.destroy = function () {
    var options = this.options;
    if (options.playbackSliderElement) {
        $(options.playbackSliderElement).slider('destroy');
    }

    if (options.cropSliderElement) {
        $(options.cropSliderElement).slider('destroy');
    }

    if (options.controller) {
        options.controller.removeAllListeners('playback.beforeSendFrame');
        options.controller.stopUsing('playback');
        options.controller.stopUsing('riggedHand');
        options.controller = null;
    }
    
    if(options.renderTarget) {
        $(options.renderTarget).find('canvas').remove();
    }else {
        $('body').find('canvas').remove();
    }
};