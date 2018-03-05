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
        recordEmptyHands: true,
        recording: options.recording || false,
        requiredProtocolVersion: 6,
        pauseOnHand: false,
        overlay: false
    });
    controller.use('riggedHand', {
        checkWebGL: false,
        offset: {x: 0, y: 150, z: 0}
    });
    controller.connect();

    if (!options.previewOnly || options.previewOnly === false) {
        controller.on('connect', onConnect);
        function onConnect()
        {
            console.log("controller connected ");
            clearAlerts($('.mainContent'));
        }

        controller.on('deviceAttached', onAttached);
        function onAttached()
        {
            console.log("device attached");
            clearAlerts($('.mainContent'));
        }

        controller.on('deviceRemoved', onDeviceRemoved);
        function onDeviceRemoved()
        {
            console.log("device removed ");
            appendAlert($('.mainContent'), ALERT_PLEASE_WAIT);
        }

        controller.on('deviceStopped', onDeviceStopped);
        function onDeviceStopped()
        {
            console.log("device stopped ");
            appendAlert($('.mainContent'), ALERT_PLEASE_WAIT);
        }

        controller.on('deviceStreaming', onDeviceStreaming);
        function onDeviceStreaming()
        {
            console.log("device streaming ");
            clearAlerts($('.mainContent'));
        }

        controller.on('blur', onBlur);
        function onBlur()
        {
            console.log("controller blur event");
        }
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
            if (options.cropRecordElement) {
                $('#btn-crop-recording').addClass('disabled');
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
            $('#upload-leap-recording').find('.fileUpload').click();
        });
    }



    if (options.loadInputElement || options.recording) {
        controller.on('playback.ajax:complete', function () {
            initializeControls(controller, options);
            controller.on('playback.beforeSendFrame', function () {
                if (options.playbackSliderElement) {
//                    console.log(options.playbackSliderElement);
                    $(options.playbackSliderElement).slider('setValue', controller.plugins.playback.player.recording.frameIndex);
                }
            });
        });
    }

    if (options.loadInputElement) {
        $(options.loadInputElement).find('.fileUpload').on('change', function (event) {
            event.preventDefault();
            if (event.handled !== true)
            {
                event.handled = true;
                var uploadFiles = $(this)[0].files[0];
                if (uploadFiles) {
                    var fr = new FileReader();
                    fr.onload = function (evt) {
                        controller.plugins.playback.player.recording.readFileData(evt.target.result, uploadFiles, function (frames) {
                            console.log('file loaded successfully ');
                            initializeControls(controller, options);
                        });
                    };
                    fr.readAsText($(this)[0].files[0]);
                }
            }
        });
    }

    if (options.playbackElement) {

    }
}

function initializeControls(controller, options) {
    console.log('initialize controls');
    var autoPlay = controller.plugins.playback.player.autoPlay;
    function initPlaybackSlider(highlightRange) {
        var frameLength = Math.max(controller.plugins.playback.player.recording.frameData.length - 1, 0);
        var crops = {left: controller.plugins.playback.player.recording.leftCropPosition, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition - 1, 0)};
        var options = {
            min: 0,
            max: frameLength,
            step: 1,
            value: crops.left
        };
        if (highlightRange === true && (crops.left > 0 || crops.right < frameLength)) {
            options.rangeHighlights = [{start: crops.left, end: crops.right, class: "category1"}];
        }
        $(options.playbackSliderElement).slider(options);
        console.log('slider initialized');
        $(options.playbackSliderElement).unbind('slide').bind('slide', function (event) {
            if (controller.plugins.playback.player.state === 'playing') {
                if (options.playbackElement) {
                    $(options.playbackElement).click();
                }
            } else {
                controller.plugins.playback.player.setFrameIndex(parseInt(event.value, 10));
            }
        });
        controller.plugins.playback.player.setFrameIndex(parseInt(crops.left, 10));
    }

    controller.on('playback.recordingFinished', function () {
        $(options.recordElement).removeClass('disabled');
        $(options.cropRecordElement).removeClass('disabled');
        initPlaybackSlider();
    });

    if (autoPlay) {
        $(options.playbackElement).find('.fa').removeClass('fa-play').addClass('fa-pause');
    }

    if (options.playbackSliderElement) {
        $(options.playbackSliderElement).parent().removeClass('hidden');
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
                controller.plugins.playback.player.play();
                if (options.cropRecordElement) {
                    $(options.cropRecordElement).removeClass('cropping');
                }
                if (options.playbackSliderElement) {
                    $(options.playbackSliderElement).parent().removeClass('hidden');
                }

                if (options.cropSliderElement) {
                    $(options.cropSliderElement).addClass('hidden');
                }
            }
        });
    }


    if (options.cropRecordElement) {
        $(options.cropRecordElement).removeClass('disabled');
    }

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
                    $(options.cropSliderElement).parent().addClass('hidden');
                }
                initPlaybackSlider(true);
            } else {
                $(this).addClass('cropping');
                if (options.playbackSliderElement) {
                    $(options.playbackSliderElement).parent().addClass('hidden');
                }
                if (options.cropSliderElement) {
                    $(options.cropSliderElement).parent().removeClass('hidden');

                    var currentCropValues;
                    $(options.cropSliderElement).slider({
                        min: 0,
                        max: controller.plugins.playback.player.recording.rightCropPosition,
                        value: [0, controller.plugins.playback.player.recording.rightCropPosition]
                    });

                    $(options.cropSliderElement).unbind('slide').bind('slide', function (event) {
                        var cropPositions = {left: controller.plugins.playback.player.recording.leftCropPosition, right: Math.max(controller.plugins.playback.player.recording.rightCropPosition, 0)};
                        if (!currentCropValues) {
                            currentCropValues = cropPositions;
                        } else {
                            if (parseInt(currentCropValues.left) !== parseInt(cropPositions.left)) {
                                controller.plugins.playback.player.setFrameIndex(parseInt(event.value[0], 10));
                                controller.plugins.playback.player.recording.leftCrop();
                            } else if (parseInt(currentCropValues.right) !== parseInt(cropPositions.right)) {
                                controller.plugins.playback.player.setFrameIndex(parseInt(event.value[1], 10));
                                controller.plugins.playback.player.recording.rightCrop();
                            }
                            currentCropValues = {left: event.value[0], right: event.value[1]};
                        }
                    });
                }
            }
        }
    });
}