var STATE_SIMULATOR_SHOW_GESTURE_SET = 'showGestureSet';
var STATE_SIMULATOR_RECORD = 'record';
var STATE_SIMULATOR_PAUSE_RECORDING = 'pauseRecording';
var STATE_SIMULATOR_STOP_RECORDING = 'stopRecording';
var currentSimulationState = null;
var startGesture = true;
/*
 * gesture set simulation panel functionalities
 */

function renderGestureSetContent() {
    var query = getQueryParams(document.location.search);
    var selectedSet = getGestureSetById(query.gestureSetId);
    var currentPreviewGestureSet = {set: selectedSet};

    $('#simulator-content').empty();
    $('#main-tab-pane').find('#btn-player').addClass('disabled');
    $('#main-tab-pane').find('#btn-mapping').addClass('disabled');
    $(recordSimulationButton).addClass('disabled');

    if (selectedSet) {
        var clone = getGestureSimulationSetPanel(currentPreviewGestureSet.set, 'gesture-simulation-catalog-thumbnail');
        $('#simulator-content').append(clone);
        $(recordSimulationButton).removeClass('disabled');
        initPopover();

        // check if current recorded simulation tempData is for this set. delete tempdata if not
        var query = getQueryParams(document.location.search);
        if (parseInt(query.gestureSetId) !== selectedSet.id) {
            removeLocalItem(SIMULATION_RECORDING);
        }

        var recordedSimulation = getLocalItem(RECORDED_SIMULATION);
        if (recordedSimulation) {
            $('#main-tab-pane').find('#btn-player').removeClass('disabled');
        }
    }
}

function getGestureSimulationSetPanel(data, type, layout) {
    var panel = $('#template-simulation-container').find('#simulation-gesture-set-panel').clone();
    $(panel).find('.panel-heading-text').text(data.title);
    initStandardGestureSetList(panel, data, type, layout);

    $('#gestureSetContent').find('#btn-show-hide-video').removeClass('disabled').attr('data-preview-present', 'true');
    $('#gestureSetContent').find('#btn-show-hide-video').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if ($(this).attr('data-preview-present') === 'true') {
            $(panel).find("#gestures-list-container .embed-responsive").hide();
            $(this).find('.fa').removeClass("fa-compress").addClass("fa-expand");
            $(this).attr('data-preview-present', 'false');
        } else {
            $(panel).find("#gestures-list-container").find(".embed-responsive").show();
            $(this).find('.fa').removeClass("fa-expand").addClass("fa-compress");
            $(this).attr('data-preview-present', 'true');
        }
    });

    $('#gestureSetContent').find('#btn-download-as-json').removeClass('disabled');
    $('#gestureSetContent').find('#btn-download-as-json').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(this).popover('hide');
        if (!$(this).hasClass('disabled')) {
            downloadGestureSetAsJSON($(panel).find('.gesture-thumbnail'), data.title);
        }
    });

    // update thumbnail controls for every gesture in the set
    for (var i = data.gestures.length - 1; i >= 0; i--) {
        updateGestureSimluationThumbnail(data.gestures[i], panel, true);
    }

//    // mouse modal functionalities
//    $(document).on('click', '.positionArea', function (event) {
//        var pos = getMousePosition(this);
//        var positionType = $('#viewer_positionScreen_type').val();
//        sendContinuousPGPosition($(this).closest('.root').prop('id'), positionType, pos.relPosX, pos.relPosY, true);
//    });
//
//    var pauseGetPosition = false;
//    $(document).on('mousemove', '.positionArea', function (event) {
//        event.preventDefault();
//        if (!pauseGetPosition) {
//            var pos = getMousePosition(this);
//            var positionType = $('#viewer_positionScreen_type').val();
//            sendContinuousPGPosition($(this).closest('.root').prop('id'), positionType, pos.relPosX, pos.relPosY, false);
//        }
//    });

    return panel;
}

var showMouseSimulationPad = false;
var currentMouseSimulationGesture = null;
function updateGestureSimluationThumbnail(gestureId, container, simulationMode, valueType) {


    var gesture = getGestureById(gestureId);
    var gestureThumbnail = $(container).find('#' + gesture.id);


    var continuousValueType = gesture.continuousValueType;
    if (valueType && valueType !== 'automatically') {
        continuousValueType = valueType;
    }
    $(gestureThumbnail).attr('data-continuous-value-type', continuousValueType);

    console.log('update gesture simulation thumbnail', gesture, valueType, continuousValueType);

    if (continuousValueType === CONTINUOUS_VALUE_TYPE_NONE || gesture.interactionType === TYPE_GESTURE_DISCRETE) {
        $(gestureThumbnail).find('.simulator-trigger').removeClass("hidden");
        $(gestureThumbnail).find('#btn-trigger-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            TweenMax.to($(this), .3, {opacity: 0, scale: 1.1, clearProps: 'all'});
            var gestureId = $(this).closest('.root').attr('id');
            commitSimulationData({gestureId: gestureId});
            startGesture = true;
            sendPGGesture(gestureId);
        });
    } else {
        if (continuousValueType === CONTINUOUS_VALUE_TYPE_PERCENT) {
            $(gestureThumbnail).find('#control-continuous-slider').removeClass('hidden');
            $(gestureThumbnail).find('.continuous-gesture-controls').removeClass('hidden');
            var continuousSlider = $(gestureThumbnail).find('#control-continuous-slider #continuous-slider');

            var sliderOptions = {
                value: 50,
                min: 0,
                max: 100,
                enabled: true
            };

            $(continuousSlider).slider(sliderOptions);
            $(continuousSlider).unbind('change').bind('change', {gesture: gesture}, function (event) {
                event.preventDefault();
                var inverted = $(this).hasClass('inverted');
                var percent = parseInt(event.value.newValue);
                var imagePercent = inverted ? (100 - percent) : percent;
                var gestureId = event.data.gesture.id;
                $(this).closest('.root').find('.btn-pause-gesture').click();
                $(continuousSlider).closest('.root').find('.control-continuous-slider-status').text(percent + '%');
                var gestureImages = $(continuousSlider).closest('.root').find('.gestureImage');
                $(gestureImages).removeClass('active').addClass('hidden');
                $($(gestureImages)[Math.max(0, (Math.min(parseInt(gestureImages.length * imagePercent / 100), gestureImages.length - 1)))]).addClass('active').removeClass('hidden');
                checkCommitTimeout({gestureId: gestureId, value: percent});
                sendContinuousPGGesture(gestureId, percent);
            });
        } else if (continuousValueType === CONTINUOUS_VALUE_TYPE_POSITION || continuousValueType === CONTINUOUS_VALUE_TYPE_MOUSE_SIMULATION) {
            $(gestureThumbnail).find('.simulator-continuous-trigger').removeClass('hidden');
            $(gestureThumbnail).find('#btn-trigger-continuous-gesture').unbind('click').bind('click', function (event) {
                event.preventDefault();
                var mousePad = $(gestureThumbnail).find('.simple-mouse-simulation-pad');
                $(mousePad).removeClass('hidden');
                $(gestureThumbnail).find('.gesture-preview-data').css({filter: 'blur(5px)', opacity: .3});
                startGesture = true;
                initMouseSimulationPad(mousePad, gestureThumbnail);
            });
        } else {
            $(gestureThumbnail).find('.static-continuous-controls').removeClass('hidden');
            $(gestureThumbnail).find('.continuous-gesture-controls').removeClass('hidden').find('.control-continuous-slider-status').text('0.7s');
            var slider = $(gestureThumbnail).find('.static-continuous-indicator');

            $(gestureThumbnail).find('.btn-start-static-continuous-gesture').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $(slider).removeClass('hidden');
                    $(this).addClass('disabled');
                    $(this).closest('.static-continuous-controls').find('.btn-stop-static-continuous-gesture').removeClass('disabled');
                    $(gestureThumbnail).attr('data-tween-speed', 1.4);
                    animateSlider();
                }
            });

            $(gestureThumbnail).find('.btn-stop-static-continuous-gesture').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $(this).addClass('disabled');
                    $(this).closest('.static-continuous-controls').find('.btn-start-static-continuous-gesture').removeClass('disabled');
                    TweenMax.killTweensOf(slider);
                    $(slider).addClass('hidden').css({width: '0%'});
                }
            });

            function animateSlider() {
                startGesture = true;
                var tweenDuration = (parseFloat($(gestureThumbnail).attr('data-tween-speed')) * .5);
                $(gestureThumbnail).find('.control-continuous-slider-status').text(tweenDuration.toFixed(1) + 's');
                var singleTrigger = $(gestureThumbnail).find('.btn-start-static-continuous-gesture').attr('data-trigger-single');
                if (singleTrigger && singleTrigger === 'true') {
                    $(gestureThumbnail).find('.btn-start-static-continuous-gesture').removeClass('disabled');
                    sendPGGesture(gesture.id);
                } else {
                    TweenMax.to(slider, tweenDuration, {width: '100%', ease: Linear.easeNone, onComplete: function () {
                            $(slider).css({width: '0%'});
                            commitSimulationData({gestureId: gesture.id});
                            sendPGGesture(gesture.id);
                            animateSlider();
                        }});
                }
            }
        }
    }

    if (simulationMode && simulationMode === true) {
        $(gestureThumbnail).on('mouseenter', function () {
            var gesture = getGestureById($(this).attr('id'));
            gesture.continuousValueType = $(this).attr('data-continuous-value-type');
            currentMouseSimulationGesture = gesture;
            startGesture = true;
            checkMouseSimulation();
        });

        $(gestureThumbnail).on('mouseleave', function () {
            currentMouseSimulationGesture = null;
            checkMouseSimulation();
        });

        $(window).unbind('keydown').bind('keydown', function (event) {
            if (event.keyCode === 16) {
                showMouseSimulationPad = true;
                checkMouseSimulation();
            }
        });

        $(window).unbind('keyup').bind('keyup', function (event) {
            if (event.keyCode === 16) {
                showMouseSimulationPad = false;
                checkMouseSimulation();
            }
        });

        function checkMouseSimulation() {
            if (showMouseSimulationPad === true && currentMouseSimulationGesture) {
                var gestureThumbnail = $(container).find('#' + currentMouseSimulationGesture.id);
                if (currentMouseSimulationGesture.continuousValueType === CONTINUOUS_VALUE_TYPE_NONE || currentMouseSimulationGesture.interactionType === TYPE_GESTURE_DISCRETE) {
                    $(gestureThumbnail).find('#btn-trigger-gesture').click();
                    var mousePad = $(gestureThumbnail).find('.mouse-simulation-slider').removeClass('hidden');
                    TweenMax.to(mousePad, 0, {opacity: 1});
                    TweenMax.to(mousePad, 1, {opacity: 0, onComplete: function () {
                            $(mousePad).addClass('hidden');
                        }});
                } else {
                    if (currentMouseSimulationGesture.continuousValueType === CONTINUOUS_VALUE_TYPE_POSITION || currentMouseSimulationGesture.continuousValueType === CONTINUOUS_VALUE_TYPE_MOUSE_SIMULATION) {
                        var mousePad = $(gestureThumbnail).find('.mouse-simulation-pad').removeClass('hidden');
                        $(gestureThumbnail).find('.gesture-preview-data').css({filter: 'blur(5px)', opacity: .3});
                        initMouseSimulationPad(mousePad, gestureThumbnail);
                    } else if (currentMouseSimulationGesture.continuousValueType === PERCENT) {
                        var mousePad = $(gestureThumbnail).find('.mouse-simulation-slider').removeClass('hidden');

                        $(mousePad).unbind('mousemove').bind('mousemove', function (event) {
                            var relPositions = getMousePosition(mousePad, event);
                            var continuousSlider = $(gestureThumbnail).find('#control-continuous-slider #continuous-slider');
                            $(continuousSlider).slider('setValue', parseInt(relPositions.relPosX * 100), true, true);
                        });
                    } else if (currentMouseSimulationGesture.interactionType === TYPE_GESTURE_CONTINUOUS && currentMouseSimulationGesture.type === TYPE_GESTURE_POSE) {
                        $(gestureThumbnail).find('.btn-start-static-continuous-gesture').click();
                        var mousePad = $(gestureThumbnail).find('.mouse-simulation-slider').removeClass('hidden');

                        $(mousePad).unbind('mousemove').bind('mousemove', function (event) {
                            var relPositions = getMousePosition(mousePad, event);
                            var tweenSpeed = (.5 * relPositions.relPosX * 2) + 1;
                            $(gestureThumbnail).attr('data-tween-speed', tweenSpeed);
                            var tweenDuration = tweenSpeed * .5;
                            $(gestureThumbnail).find('.control-continuous-slider-status').text(tweenDuration.toFixed(1) + 's');
                        });
                    }
                }
            } else {
                $(container).find('.mouse-simulation-pad, .simple-mouse-simulation-pad, .mouse-simulation-slider').addClass('hidden');
                $(container).find('.gesture-preview-data').css({filter: '', opacity: ''});
                $(container).unbind('mousemove');
                $(container).find('.btn-stop-static-continuous-gesture').click();
                startGesture = true;
            }
        }
    } else {
        $(gestureThumbnail).find('#control-continuous-slider').addClass('hidden');
        $(gestureThumbnail).find('.continuous-gesture-controls').addClass('hidden');
        $(gestureThumbnail).find('#simulation-controls').addClass('hidden');
        $(gestureThumbnail).find('.gesture-info-symbols').addClass('hidden');
        $(gestureThumbnail).find('.caption').addClass('hidden');
        $(gestureThumbnail).find('.gestureImage').css({borderRadius: '8px'});
        $(gestureThumbnail).removeClass('deleteable');
        $(gestureThumbnail).find('.gesture-thumbnail').unbind('mouseenter');
        $(gestureThumbnail).find('.gesture-thumbnail').unbind('mouseleave');
        $(gestureThumbnail).find('.thumbnail').removeClass('btn-gesture-shadow');
    }
}

function initMouseSimulationPad(mousePad, gestureThumbnail) {
    var gesture = getGestureById($(gestureThumbnail).attr('id'));

    $(mousePad).on('mousemove', function (event) {
        var relPositions = getMousePosition(mousePad, event);
        $(mousePad).find('.x-position').text(parseFloat(relPositions.relPosX * 100).toFixed() + '%');
        $(mousePad).find('.y-position').text(parseFloat(relPositions.relPosY * 100).toFixed() + '%');
        showCursor(mousePad, CURSOR_CROSSHAIR);
        checkCommitTimeout({gestureId: gesture.id, value: {relPositions: relPositions, clicked: false}});
        sendContinuousPGPosition($(this).closest('.root').prop('id'), currentMouseSimulationGesture.continuousValueType, relPositions.relPosX, relPositions.relPosY, false);
    });

    $(mousePad).unbind('click').bind('click', function (event) {
        var relPositions = getMousePosition(mousePad, event);
        commitSimulationData({gestureId: gesture.id, value: {relPositions: relPositions, clicked: true}});
        sendContinuousPGPosition($(gestureThumbnail).attr('id'), currentMouseSimulationGesture.continuousValueType, relPositions.relPosX, relPositions.relPosY, true);
    });
}

function getMousePosition(element, event) {
    var targetDimensions = {width: $(element).width(), height: $(element).height()};
    var targetOffset = $(element).offset();
    var pageCoords = {x: event.pageX, y: event.pageY};
    var relPosX = Math.max(0, Math.min(1, (pageCoords.x - targetOffset.left) / targetDimensions.width));
    var relPosY = Math.max(0, Math.min(1, (pageCoords.y - targetOffset.top) / targetDimensions.height));
    return {relPosX: relPosX, relPosY: relPosY};
}

var commitTimeout = null;
function checkCommitTimeout(data) {
    if (commitTimeout === null) {
        commitTimeout = setTimeout(function () {
            commitSimulationData(data);
            commitTimeout = null;
        }, 100); // save data only every 100 milliseconds
    }
}


function commitSimulationData(data) {
//    console.log('commit simulation data');
    if (currentSimulationState === STATE_SIMULATOR_RECORD) {
        var gestureSetId = null;
        if (previewModeEnabled) {
            gestureSetId = currentSimulationGestureSetId;
        } else {
            var query = getQueryParams(document.location.search);
            gestureSetId = query.gestureSetId;
        }

        if (gestureSetId) {
            var simulationRecording = getLocalItem(SIMULATION_RECORDING);
            if (!simulationRecording) {
                simulationRecording = {gestureSetId: gestureSetId, id: null, track: []};
            }

            data.id = chance.natural();
            data.timestamp = new Date().getTime();
            data.start = startGesture;
            simulationRecording.track.push(data);
            setLocalItem(SIMULATION_RECORDING, simulationRecording);
            if (startGesture === true) {
                startGesture = false;
            }
        }
    }
}

function saveSimulationRecording() {
    loadHTMLintoModal('custom-modal', 'externals/modal-save-simulation-recording.php', 'modal-md');
    $('#custom-modal').unbind('loadRecordedGestureSetSimulation').bind('loadRecordedGestureSetSimulation', function (event) {
        event.preventDefault();
        renderRecordedGestureSetSimulation();
        $('#main-tab-pane').find('#btn-player a').click();
    });

    $('#custom-modal').unbind('hidden.bs.modal').bind('hidden.bs.modal', function (event) {
        event.preventDefault();
        currentSimulationState = STATE_SIMULATOR_SHOW_GESTURE_SET;
        setParam(window.location.href, 'state', currentSimulationState);
    });
}

var sliderValues = null;
var lastSimulationStep = null;
var playThroughTimeout = null;
function renderRecordedGestureSetSimulation() {
    var recordedSimulation = getLocalItem(RECORDED_SIMULATION);
    if (recordedSimulation && recordedSimulation.track && recordedSimulation.track.length > 0) {
        $('#simulation-player-content').removeClass('hidden').find('#simulation-thumbnail-container').empty();
        renderMainSimulationItems();
        renderSeekbarMetaData();

        var slider = $('#playback-slider-container').find('#playback-slider');

        var sliderOptions = {
            value: 0,
            min: 0,
            max: recordedSimulation.track[recordedSimulation.track.length - 1].timestamp - recordedSimulation.track[0].timestamp,
            enabled: true
        };

        sliderValues = {min: recordedSimulation.track[0].timestamp, max: recordedSimulation.track[recordedSimulation.track.length - 1].timestamp};
        $(slider).slider(sliderOptions);
        $(slider).slider('refresh', sliderOptions);

        $(slider).unbind('change').bind('change', function (event) {
            event.preventDefault();
            var currentValue = parseInt(sliderValues.min) + parseInt(event.value.newValue);
            updateView(currentValue);
            checkStepperButtons(currentValue);
            checkStepperGestureButtons(currentValue);
        });

        $(slider).unbind('slideStart').bind('slideStart', function (event) {
            event.preventDefault();
            $(slider).attr('data-resume', 'false');
            if (playThroughTimeout) {
                $(slider).attr('data-resume', 'true');
                $(pauseButton).click();
            }
        });

        $(slider).unbind('slideStop').bind('slideStop', function (event) {
            event.preventDefault();
            if ($(slider).attr('data-resume') === 'true') {
                $(playButton).click();
            }
        });

        var playButton = $('#btn-play-simulation');
        $(playButton).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(this).addClass('disabled');
                $(this).closest('.btn-group').addClass('hidden');
                $(pauseButton).removeClass('disabled');
                $(pauseButton).closest('.btn-group').removeClass('hidden');
                if (parseInt(sliderValues.min) + parseInt($(slider).slider('getValue')) >= parseInt(sliderValues.max)) {
                    $(slider).slider('setValue', 0, true, true);
                }
                playThroughSteps();
            }
        });

        var pauseButton = $('#btn-pause-simulation');
        $(pauseButton).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(this).addClass('disabled');
                $(this).closest('.btn-group').addClass('hidden');
                $(playButton).removeClass('disabled');
                $(playButton).closest('.btn-group').removeClass('hidden');
                resetPlayThroughTimeout();
            }
        });

        var stepBackwardButton = $('#btn-step-backward-simulation');
        $(stepBackwardButton).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(pauseButton).click();
                var currentValue = parseInt(sliderValues.min) + parseInt($(slider).slider('getValue'));
                var currentSimulationStep = getCurrentSimulationStep(currentValue);

                var prevStep = null;
                for (var i = 0; i < recordedSimulation.track.length; i++) {
                    if (parseInt(currentSimulationStep.timestamp) === parseInt(recordedSimulation.track[i].timestamp)) {
                        prevStep = recordedSimulation.track[i - 1];
                        break;
                    }
                }

                if (prevStep) {
                    var updateValue = parseInt($(slider).slider('getValue')) + ((parseInt(prevStep.timestamp) - currentValue));
                    $(slider).slider('setValue', updateValue, true, true);
                }
            }
        });

        var stepForwardButton = $('#btn-step-forward-simulation');
        $(stepForwardButton).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(pauseButton).click();
                nextStep();
            }
        });

        function checkStepperButtons(currentValue) {
            if (currentValue <= sliderValues.min) {
                $(stepBackwardButton).addClass('disabled');
                $(stepForwardButton).removeClass('disabled');
            } else if (currentValue >= sliderValues.max) {
                $(stepBackwardButton).removeClass('disabled');
                $(stepForwardButton).addClass('disabled');
            } else {
                $(stepBackwardButton).removeClass('disabled');
                $(stepForwardButton).removeClass('disabled');
            }
        }



        var prevGestureButton = $('#btn-prev-gesture');
        $(prevGestureButton).unbind('click').bind('click', function (event) {
            event.preventDefault();
            console.log(prevGestureButton, '');
            if (!$(this).hasClass('disabled')) {
                $(pauseButton).click();

                var currentValue = parseInt(sliderValues.min) + parseInt($(slider).slider('getValue'));
                var currentSimulationStep = getCurrentSimulationStep(currentValue);

                var prevGesture = null;
                var searchPreviousStarts = false;
                for (var i = recordedSimulation.track.length - 1; i >= 0; i--) {
                    if (parseInt(currentSimulationStep.timestamp) === parseInt(recordedSimulation.track[i].timestamp)) {
                        searchPreviousStarts = true;
                    }

                    if (searchPreviousStarts === true && (recordedSimulation.track[i].start === 'true' || recordedSimulation.track[i].start === true) && parseInt(currentValue) !== parseInt(recordedSimulation.track[i].timestamp)) {
                        prevGesture = recordedSimulation.track[i];
                        break;
                    }
                }

                if (prevGesture) {
                    var updateValue = parseInt($(slider).slider('getValue')) + ((parseInt(prevGesture.timestamp) - currentValue));
                    $(slider).slider('setValue', updateValue, true, true);
                }
            }
        });

        var nextGestureButton = $('#btn-next-gesture');
        $(nextGestureButton).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(pauseButton).click();

                var currentValue = parseInt(sliderValues.min) + parseInt($(slider).slider('getValue'));
                var currentSimulationStep = getCurrentSimulationStep(currentValue);

                var nextGesture = null;
                var searchNextStarts = false;
                for (var i = 0; i < recordedSimulation.track.length; i++) {
                    if (parseInt(currentSimulationStep.timestamp) === parseInt(recordedSimulation.track[i].timestamp)) {
                        searchNextStarts = true;
                    }

                    if (searchNextStarts === true && (recordedSimulation.track[i].start === 'true' || recordedSimulation.track[i].start === true) && parseInt(currentValue) !== parseInt(recordedSimulation.track[i].timestamp)) {
                        nextGesture = recordedSimulation.track[i];
                        break;
                    }
                }

                if (nextGesture) {
                    var updateValue = parseInt($(slider).slider('getValue')) + ((parseInt(nextGesture.timestamp) - currentValue));
                    $(slider).slider('setValue', updateValue, true, true);
                }
            }
        });

        function checkStepperGestureButtons(currentValue) {
            var activeItem = $('#simulation-thumbnail-container .item-active');

            if ($(activeItem).prev().length > 0 || currentValue > sliderValues.min) {
                $(prevGestureButton).removeClass('disabled');
            } else {
                $(prevGestureButton).addClass('disabled');
            }

            if ($(activeItem).next().length > 0) {
                $(nextGestureButton).removeClass('disabled');
            } else {
                $(nextGestureButton).addClass('disabled');
            }
        }

        function playThroughSteps() {
            var timeout = 100;
            var selectedTimeout = $('#update-time-select').find('.selected').attr('data-milliseconds');
            if (selectedTimeout !== 'standard') {
                timeout = parseInt(selectedTimeout);
            }

            var currentValue = parseInt(sliderValues.min) + parseInt($(slider).slider('getValue'));
            var currentSimulationStep = getCurrentSimulationStep(currentValue);
            var gesture = getGestureById(currentSimulationStep.gestureId);
            if (gesture.interactionType === TYPE_GESTURE_DISCRETE) {
                timeout = Math.max(timeout, 2000);
            } else if (gesture.interactionType === TYPE_GESTURE_CONTINUOUS && gesture.type === TYPE_GESTURE_POSE) {
                timeout = Math.max(timeout, 2000);
            }

            playThroughTimeout = setTimeout(function () {
                if (currentValue >= parseInt(sliderValues.max)) {
                    $(pauseButton).click();
                } else {
                    nextStep();
                    playThroughSteps();
                }
            }, timeout);
        }

        function nextStep() {
            resetPlayThroughTimeout();
            var currentValue = parseInt(sliderValues.min) + parseInt($(slider).slider('getValue'));
            var currentSimulationStep = getCurrentSimulationStep(currentValue);
            var nextStep = null;

            for (var i = 0; i < recordedSimulation.track.length; i++) {
                if (parseInt(currentSimulationStep.timestamp) === parseInt(recordedSimulation.track[i].timestamp)) {
                    nextStep = recordedSimulation.track[i + 1];
                    break;
                }
            }

            if (nextStep) {
                var updateValue = parseInt($(slider).slider('getValue')) + ((parseInt(nextStep.timestamp) - currentValue));
                $(slider).slider('setValue', updateValue, true, true);
            }
        }

        function resetPlayThroughTimeout() {
            clearTimeout(playThroughTimeout);
            playThroughTimeout = null;
        }

        // first time initalized
        var currentValue = parseInt(recordedSimulation.track[0].timestamp) + parseInt($(slider).slider('getValue'));
        updateView(currentValue);
        checkStepperButtons(currentValue);
        checkStepperGestureButtons(currentValue);

        var seconds = getSeconds(getTimeBetweenTimestamps(sliderValues.min, sliderValues.max), true);
        var timeCode = secondsToHms(seconds);
        $('#playerContent').find('#current-time-code .time-code-duration').text(timeCode + '.' + seconds.toFixed(3).split('.')[1]);
    } else {

    }

    function renderSeekbarMetaData() {
        var metaInfoContainer = $('#playerContent').find('#seek-bar-meta-info-container');
        $(metaInfoContainer).empty();

        if (recordedSimulation && recordedSimulation.track.length > 0) {
            for (var i = 0; i < recordedSimulation.track.length; i++) {
                if (recordedSimulation.track[i].start === 'true' || recordedSimulation.track[i].start === true) {
                    var xPercentage = (parseInt(recordedSimulation.track[i].timestamp) - parseInt(recordedSimulation.track[0].timestamp)) / (parseInt(recordedSimulation.track[recordedSimulation.track.length - 1].timestamp) - parseInt(recordedSimulation.track[0].timestamp)) * 100;
                    var infoDataItem = document.createElement('div');
                    $(infoDataItem).addClass('simluation-meta-data-item');
                    $(infoDataItem).css({left: xPercentage + '%'});
                    $(metaInfoContainer).append(infoDataItem);
                }
            }
        } else {
            $(metaInfoContainer).addClass('hidden');
        }
    }

    function renderMainSimulationItems() {
        var panel = null;
        for (var i = 0; i < recordedSimulation.track.length; i++) {
            if (recordedSimulation.track[i].start === true || recordedSimulation.track[i].start === 'true') {
                var gesture = getGestureById(recordedSimulation.track[i].gestureId);
                panel = $('#template-simulation-container').find('#gesture-set-simulation-panel').clone();
                var gestureThumbnail = getGestureCatalogListThumbnail(gesture, 'gesture-simulation-catalog-thumbnail', 'col-xs-12');
                $(panel).find('#gesture-thumbnail-container').append(gestureThumbnail);
                updateGestureSimluationThumbnail(gesture.id, panel);

                var seconds = getSeconds(getTimeBetweenTimestamps(recordedSimulation.track[0].timestamp, recordedSimulation.track[i].timestamp), true);
                $(panel).attr('data-id', recordedSimulation.track[i].id);
                $(panel).attr('data-start-time', recordedSimulation.track[i].timestamp);
                $(panel).attr('data-timestamp', recordedSimulation.track[i].timestamp);
                $(panel).attr('data-gesture-id', recordedSimulation.track[i].gestureId);
                $(panel).find('.title').text(gesture.title);
                $(panel).find('.timestamp').text(secondsToHms(parseInt(seconds)));
                $('#simulation-thumbnail-container').append(panel);
            } else if ((i < recordedSimulation.track.length - 1 && (recordedSimulation.track[i + 1].start === true || recordedSimulation.track[i + 1].start === 'true')) || (i === recordedSimulation.track.length - 1 && (recordedSimulation.track[i].start !== true || recordedSimulation.track[i].start !== 'true'))) {
                $(panel).attr('data-end-time', recordedSimulation.track[i].timestamp);
            }
        }
    }

    function updateView(currentValue) {
        var items = $('#simulation-thumbnail-container').children();
        $(items).removeClass('prev-2 prev-1 success next-1 next-2 next-3 col-sm-1 col-sm-3 col-sm-offset-4 col-sm-offset-1 item-active');
        $(items).find('.gesture-thumbnail').css({pointerEvents: 'none'});
        $(items).find('#simulation-controls').addClass('hidden');

        var seconds = getSeconds(getTimeBetweenTimestamps(sliderValues.min, currentValue), true);
        var timeCode = secondsToHms(seconds);
        $('#playerContent').find('#current-time-code .time-code-current-time').text(timeCode + '.' + seconds.toFixed(3).split('.')[1]);

        var tempItems = [];
        for (var i = 0; i < items.length; i++) {
            var itemTimestamp = parseInt($($(items)[i]).attr('data-timestamp'));
            if (itemTimestamp > currentValue) {
                break;
            } else {
                tempItems.push($(items)[i]);
            }
        }

        // update vertical scroll view
        if (tempItems.length > 0) {
            $(tempItems).last().prevAll().find('.btn-pause-gesture').click();
            $(tempItems).last().prevAll().addClass('hidden');
            $(tempItems).last().nextAll().find('.btn-pause-gesture').click();
            $(tempItems).last().nextAll().addClass('hidden');

            var activeItem = $(tempItems).last();
            var gesture = getGestureById($(activeItem).attr('data-gesture-id'));
            if (gesture.continuousValueType !== PERCENT) {
                $(activeItem).find('.btn-play-gesture').click();
            }

            $(activeItem).removeClass('hidden').addClass('col-sm-4 item-active').css({marginLeft: '', opacity: '', filter: '', transform: ''}).find('.gesture-thumbnail').css({pointerEvents: 'all'});

            var prev2Item = $(activeItem).prev().prev();
            $(prev2Item).addClass('prev-2 col-sm-1').removeClass('hidden');

            var prev1Item = $(activeItem).prev();
            $(prev1Item).addClass('prev-1 col-sm-3').removeClass('hidden');

            var next1Item = $(activeItem).next();
            $(next1Item).addClass('next-1 col-sm-3').removeClass('hidden');

            var next2Item = $(activeItem).next().next();
            $(next2Item).addClass('next-2 col-sm-1').removeClass('hidden');

            var prevItemLength = $(activeItem).prevAll().length;
            if (prevItemLength === 0) {
                $(activeItem).addClass('col-sm-offset-4');
            } else if (prevItemLength === 1) {
                $(prev1Item).addClass('col-sm-offset-1');
            }

            // update gesture thumbnail view
            updateGestureThumbnailContainerView(activeItem, $(activeItem).attr('data-id'), currentValue);
            updateGestureThumbnailInfoView(activeItem, $(activeItem).attr('data-id'), currentValue);
            updateLinkList(currentValue);
        }
    }


    function updateGestureThumbnailContainerView(activeItem, dataId, currentValue) {
        var simulationRecording = getRecordedSimulationById(dataId);

        $('#simulation-thumbnail-container').find('.mouse-simulation-pad, .simple-mouse-simulation-pad, .mouse-simulation-slider').addClass('hidden').css({borderWidth: '5px'});
        $('#simulation-thumbnail-container').find('.gesture-preview-data').css({filter: '', opacity: ''});
        var gesture = getGestureById(simulationRecording.gestureId);
        var gestureThumbnail = $(activeItem).find('#' + gesture.id);

        var currentSimulationStep = getCurrentSimulationStep(currentValue);
        if (lastSimulationStep && parseInt(lastSimulationStep.id) !== parseInt(currentSimulationStep.id)) {
            lastSimulationStep = null;
            $(gestureThumbnail).find('#btn-trigger-gesture').removeClass('disabled');
        }


        if (gesture.interactionType === TYPE_GESTURE_DISCRETE) {
            var mousePad = $(gestureThumbnail).find('.mouse-simulation-slider').removeClass('hidden');

            if ((currentSimulationStep.start === true || currentSimulationStep.start === 'true') && (!$(gestureThumbnail).find('#btn-trigger-gesture').hasClass('disabled') && !lastSimulationStep)) {
                $(gestureThumbnail).find('#btn-trigger-gesture').click().addClass('disabled');
                TweenMax.to(mousePad, .2, {scale: 1.08, opacity: 0, clearProps: 'scale,opacity', repeat: 1});
                lastSimulationStep = currentSimulationStep;
            }
        } else {
            // unlock trigger button for discrete gestures
            $('#simulation-thumbnail-container').find('#btn-trigger-gesture').removeClass('disabled');

            if (gesture.continuousValueType === PERCENT) {
                $(gestureThumbnail).find('#simulation-controls').removeClass('hidden');
                if (currentSimulationStep.value) {
                    var mousePad = $(gestureThumbnail).find('.mouse-simulation-slider').removeClass('hidden');
                    var continuousSlider = $(gestureThumbnail).find('#control-continuous-slider #continuous-slider');
                    $(continuousSlider).slider('setValue', parseInt(currentSimulationStep.value), true, true);
                }
            } else if (gesture.continuousValueType === "position" || gesture.continuousValueType === "mouseSimulation") {
                if (currentSimulationStep.value) {
                    var mousePad = $(gestureThumbnail).find('.mouse-simulation-pad').removeClass('hidden');
                    $(mousePad).find('.cursor-simulation').addClass('hidden');
                    $(mousePad).find('.cursor-hint').addClass('hidden');

                    $(gestureThumbnail).find('.gesture-preview-data').css({filter: 'blur(5px)', opacity: .3});
                    var relPosX = parseFloat(currentSimulationStep.value.relPositions.relPosX * 100);
                    var relPosY = parseFloat(currentSimulationStep.value.relPositions.relPosY * 100);
                    $(mousePad).find('.x-position').text(relPosX.toFixed() + '%');
                    $(mousePad).find('.y-position').text(relPosY.toFixed() + '%');
                    $(mousePad).find('.cursor-simulation').removeClass('hidden').css({top: relPosY + '%', left: relPosX + '%'});

                    if ((currentSimulationStep.value.clicked === true || currentSimulationStep.value.clicked === 'true') && !lastSimulationStep) {
                        lastSimulationStep = currentSimulationStep;
                        TweenMax.killTweensOf($(mousePad).find('.cursor-simulation'));
                        TweenMax.to($(mousePad).find('.cursor-simulation'), .05, {scale: 3, yoyo: true, repeat: 1, onComplete: function () {
                                TweenMax.to($(mousePad).find('.cursor-simulation'), 0, {scale: 1});
                            }});
                    } else {
                    }
                } else {
                    $(gestureThumbnail).find('.mouse-simulation-slider').removeClass('hidden');
                }
            } else {
                var mousePad = $(gestureThumbnail).find('.mouse-simulation-slider').removeClass('hidden');
                $(gestureThumbnail).find('.btn-start-static-continuous-gesture').attr('data-trigger-single', 'true');
                if ((currentSimulationStep.start === true || currentSimulationStep.start === 'true') && (!$(gestureThumbnail).find('#btn-trigger-gesture').hasClass('disabled') && !lastSimulationStep)) {
                    $(gestureThumbnail).find('.btn-start-static-continuous-gesture').click();
                    TweenMax.to(mousePad, .2, {scale: 1.08, opacity: 0, clearProps: 'scale,opacity', repeat: 1});
                    lastSimulationStep = currentSimulationStep;
                }
            }
        }
    }

    function updateGestureThumbnailInfoView(activeItem, dataId, currentValue) {
        var activeItemId = parseInt(dataId);
        if (!lastUpdatedInfoInfo || (activeItemId !== lastUpdatedInfoInfo))
        {
            lastUpdatedInfoInfo = activeItemId;

            // render current gesture data
            setTimeout(function () {
                renderThumbnailInfoView(dataId);
                updateThumbailInfoView(currentValue);
                renderLinkList(dataId, currentValue);

                // render gesture duration
                var startTime = parseInt($(activeItem).attr('data-start-time'));
                var endTime = parseInt($(activeItem).attr('data-end-time'));
                if (!isNaN(startTime) && !isNaN(endTime)) {
                    var duration = getSeconds(getTimeBetweenTimestamps(startTime, endTime), true);
                    $('#simulation-thumbnail-info-panel').find('.duration-text').text(new String(duration.toFixed(3)).replace('.', ',') + ' ' + translation.times.seconds);
                } else {
                    $('#simulation-thumbnail-info-panel').find('.duration-text').text('-');
                }
            }, 100);
        } else {
            updateThumbailInfoView(currentValue);
        }
    }
}

var lastUpdatedInfoInfo = null;
var graph2d = null;
var currentPercentItems = null;
function renderThumbnailInfoView(dataId) {
    $('#simulation-thumbnail-info-panel').empty();

    var data = getGestureSimulationData(dataId);
    if (data && data.length > 0) {
        var infoView = null;
        var gesture = getGestureById(data[0].gestureId);

        if (gesture.interactionType === TYPE_GESTURE_DISCRETE) {
            infoView = $('#template-simulation-container').find('#playback-info-view-discrete').clone();
            $('#simulation-thumbnail-info-panel').append(infoView);
        } else {
            if (gesture.continuousValueType === PERCENT) {
                infoView = $('#template-simulation-container').find('#playback-info-view-percent').clone();
                $('#simulation-thumbnail-info-panel').append(infoView);
                var containerWidth = parseInt($(infoView).find('#graph-container').outerWidth());
                var containerHeight = parseInt($(infoView).find('#graph-container').outerHeight());

                var items = [];
                var stepsX = containerWidth / (data.length - 1);
                var startPoint, endPoint = null;
                for (var i = 0; i < data.length; i++) {
                    var posX = i * stepsX;
                    var posY = containerHeight * (100 - data[i].value) / 100;

                    if (i === 0) {
                        startPoint = {xPos: posX, yPos: posY, id: data[i].id};
                        items.push(startPoint);
                    } else if (i > 0 && i < data.length) {
                        endPoint = {xPos: posX, yPos: posY, id: data[i].id};
                        $(infoView).find('#graph-container').line(startPoint.xPos, startPoint.yPos, endPoint.xPos, endPoint.yPos, {color: "#337ab7", stroke: 3, zindex: 0}, function (line) {
                            if (i === 1) {
                            }
                            $(line).attr('data-id', data[i].id);
                        });
                        startPoint = endPoint;
                        items.push(endPoint);
                    }
                }

                currentPercentItems = items;
            } else if (gesture.continuousValueType === "position" || gesture.continuousValueType === "mouseSimulation") {
                infoView = $('#template-simulation-container').find('#playback-info-view-mouse-simulation').clone();
                $('#simulation-thumbnail-info-panel').append(infoView);
                var containerWidth = parseInt($(infoView).find('#mouse-path-container').outerWidth());
                var containerHeight = parseInt($(infoView).find('#mouse-path-container').outerHeight());

                var startPoint, endPoint = null;
                for (var i = 0; i < data.length; i++) {
                    var relPosX = parseFloat(data[i].value.relPositions.relPosX * 100);
                    var relPosY = parseFloat(data[i].value.relPositions.relPosY * 100);

                    if (data[i].value.clicked === 'true' || data[i].value.clicked === true) {
                        var pathPoint = $('#template-simulation-container').find('#mouse-simulation-path-point').clone();
                        $(pathPoint).css({top: relPosY + '%', left: relPosX + '%'});
                        $(pathPoint).attr('data-id', data[i].id);
                        $(infoView).find('#mouse-path').append(pathPoint);
                    }

                    if (i === 0) {
                        startPoint = {xPos: containerWidth * data[i].value.relPositions.relPosX, yPos: containerHeight * data[i].value.relPositions.relPosY};
                    } else if (i > 0 && i < data.length) {
                        endPoint = {xPos: containerWidth * data[i].value.relPositions.relPosX, yPos: containerHeight * data[i].value.relPositions.relPosY};
                        $(infoView).find('#mouse-path-lines').line(startPoint.xPos, startPoint.yPos, endPoint.xPos, endPoint.yPos, {color: "#337ab7", stroke: 3, zindex: 0}, function (line) {
                            if (i === 1) {
                            }
                            $(line).attr('data-id', data[i].id);
                        });
                        startPoint = endPoint;
                    }
                }
            } else {
                infoView = $('#template-simulation-container').find('#playback-info-view-discrete').clone();
                $('#simulation-thumbnail-info-panel').append(infoView);
            }
        }

        var gestureInfoThumbnail = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12');
        $(gestureInfoThumbnail).removeClass('deleteable');
        $(infoView).find('#gesture-thumbnail-info-container').empty().append(gestureInfoThumbnail);
    }
}

function updateThumbailInfoView(currentTime) {
    $('#simulation-thumbnail-info-panel').find('#mouse-path-lines, #graph-container').children().css({opacity: .1});

    var currentSimulationStep = getCurrentSimulationStep(currentTime);
    var gesture = getGestureById(currentSimulationStep.gestureId);

    if (gesture.interactionType === TYPE_GESTURE_DISCRETE) {

    } else {
        if (gesture.continuousValueType === PERCENT) {
            var activeLine = $('#simulation-thumbnail-info-panel').find('#graph-container').find('.simulation-line[data-id=' + currentSimulationStep.id + ']');
            $($(activeLine)[0]).prev().prev().css({opacity: .3});
            $($(activeLine)[0]).prev().css({opacity: .6});
            $(activeLine).css({opacity: 1});

            if (currentPercentItems && currentPercentItems.length > 0) {
                var graphSimulationPoint = $('#simulation-thumbnail-info-panel').find('#graph-simulation-point');
                $(graphSimulationPoint).text(parseInt(currentSimulationStep.value));

                for (var i = 0; i < currentPercentItems.length; i++) {
                    if (parseInt(currentPercentItems[i].id) === parseInt(currentSimulationStep.id)) {
                        $(graphSimulationPoint).css({top: currentPercentItems[i].yPos + 'px', left: currentPercentItems[i].xPos + 'px'});
                        break;
                    }
                }
            }
        } else if (gesture.continuousValueType === "position" || gesture.continuousValueType === "mouseSimulation") {
            var activeLine = $('#simulation-thumbnail-info-panel').find('#mouse-path-lines').find('.simulation-line[data-id=' + currentSimulationStep.id + ']');
            $($(activeLine)[0]).prev().prev().css({opacity: .3});
            $($(activeLine)[0]).prev().css({opacity: .6});
            $(activeLine).css({opacity: 1});
        } else {

        }
    }
}

function renderLinkList(dataId, currentTime) {
    var data = getGestureSimulationData(dataId);

    var recordedSimulation = getLocalItem(RECORDED_SIMULATION).track;
    var container = $('#simulation-thumbnail-info-panel').find('#link-list-container');
    var gesture = getGestureById(data[0].gestureId);
    for (var i = 0; i < data.length; i++) {
        var seconds = getSeconds(getTimeBetweenTimestamps(recordedSimulation[0].timestamp, data[i].timestamp), true);
        var linkListItem = $('#template-simulation-container').find('#link-list-item').clone().removeAttr('id');
        $(linkListItem).find('.link-list-item-url').attr('data-jumpto', (parseInt(data[i].timestamp) - sliderValues.min));
        $(linkListItem).attr('data-id', data[i].id);
        $(linkListItem).find('.link-list-item-time').text(secondsToHms(parseInt(seconds)) + '.' + seconds.toFixed(3).split('.')[1]);
        $(container).append(linkListItem);

        if (gesture.interactionType === TYPE_GESTURE_DISCRETE) {
            $(linkListItem).find('.link-list-item-title').text(translation.gestureDemonstrated);
        } else {
            if (gesture.continuousValueType === PERCENT) {
                $(linkListItem).find('.link-list-item-title').text(data[i].value + '%');
            } else if (gesture.continuousValueType === "position" || gesture.continuousValueType === "mouseSimulation") {
                var posX = (parseFloat(data[i].value.relPositions.relPosX) * 100).toFixed();
                var posY = (parseFloat(data[i].value.relPositions.relPosY) * 100).toFixed();
                if (data[i].value.clicked === 'true' || data[i].value.clicked === true) {
                    $(linkListItem).find('.link-list-item-title').text(translation.relPosX + ': ' + posX + '%, ' + translation.relPosY + ': ' + posY + ', ' + translation.mouseClicked);
                } else {
                    $(linkListItem).find('.link-list-item-title').text(translation.relPosX + ': ' + posX + '%, ' + translation.relPosY + ': ' + posY);
                }
            } else {
                $(linkListItem).find('.link-list-item-title').text(translation.gestureDemonstrated);
            }
        }

        $(linkListItem).find('.link-list-item-url').on('click', function (event) {
            event.preventDefault();
            var jumpTo = parseInt($(this).attr('data-jumpto'));
            var slider = $('#playback-slider-container').find('#playback-slider');
            $(slider).slider('setValue', jumpTo, true, true);
        });
    }
    updateLinkList(currentTime);
}

function updateLinkList(currentTime) {
    var container = $('#simulation-thumbnail-info-panel').find('#link-list-container');
    var currentSimulationStep = getCurrentSimulationStep(currentTime);

    var activeLink = $(container).find('[data-id=' + currentSimulationStep.id + ']');
    if ($(activeLink).length === 0) {
        $(container).children().css({fontWeight: 'bold'});
    } else {
        $(activeLink).prevAll().css({fontWeight: 'bold'});
        $(activeLink).css({fontWeight: 'bold'});
        $(activeLink).nextAll().css({fontWeight: 'normal'});
    }
}




function getRecordedSimulationById(id) {
    var recordings = getLocalItem(RECORDED_SIMULATION);
    if (recordings.track && recordings.track.length > 0) {
        for (var i = 0; i < recordings.track.length; i++) {
            if (parseInt(recordings.track[i].id) === parseInt(id)) {
                return recordings.track[i];
            }
        }
    }
    return null;
}

function getCurrentSimulationStep(timestamp) {
    var recordings = getLocalItem(RECORDED_SIMULATION);
    if (recordings.track && recordings.track.length > 0) {
        for (var i = 0; i < recordings.track.length; i++) {
            if (parseInt(recordings.track[i].timestamp) >= parseInt(timestamp)) {
                return recordings.track[i];
            }
        }
    }
    return null;
}

function getGestureSimulationData(id) {
    var recordings = getLocalItem(RECORDED_SIMULATION);
    var data = null;
    var gestureDataStarted = false;

    if (recordings.track && recordings.track.length > 0) {
        data = [];
        for (var i = 0; i < recordings.track.length; i++) {
            if (parseInt(recordings.track[i].id) === parseInt(id)) {
                data.push(recordings.track[i]);
                gestureDataStarted = true;
            } else if (gestureDataStarted === true && (recordings.track[i].start === 'false' || recordings.track[i].start === false)) {
                data.push(recordings.track[i]);
            } else if (gestureDataStarted === true && (recordings.track[i].start === 'true' || recordings.track[i].start === true)) {
                break;
            }
        }
    }
    return data;
}