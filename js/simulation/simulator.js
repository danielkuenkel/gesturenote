
/*
 * gesture set simulation panel functionalities
 */

function getGestureSimulationSetPanel(data, type, layout) {
    var panel = initGestureSetPanel(data, 'study-gesture-set-panel');
    initStandardGestureSetList(panel, data, type, layout);

    $(panel).find('#btn-show-hide-video').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if ($(this).attr('data-preview-present') === 'true') {
            $(panel).find("#gestures-list-container .embed-responsive").hide();
            $(panel).find('#btn-show-hide-video').find('i').removeClass("fa-compress").addClass("fa-expand");
            $(this).attr('data-preview-present', 'false');
        } else {
            $(panel).find("#gestures-list-container").find(".embed-responsive").show();
            $(panel).find('#btn-show-hide-video').find('i').removeClass("fa-expand").addClass("fa-compress");
            $(this).attr('data-preview-present', 'true');
        }
    });


    // update thumbnail controls for every gesture in the set
    for (var i = data.gestures.length - 1; i >= 0; i--) {
        updateGestureSimluationThumbnail(data.gestures[i], panel);
    }

    // mouse modal functionalities
    $(document).on('click', '.positionArea', function (event) {
        var pos = getMousePosition(this);
        var positionType = $('#viewer_positionScreen_type').val();
        sendContinuousPGPosition($(this).closest('.root').prop('id'), positionType, pos.relPosX, pos.relPosY, true);
    });

    var pauseGetPosition = false;
    $(document).on('mousemove', '.positionArea', function (event) {
        event.preventDefault();
        if (!pauseGetPosition) {
            var pos = getMousePosition(this);
            var positionType = $('#viewer_positionScreen_type').val();
            sendContinuousPGPosition($(this).closest('.root').prop('id'), positionType, pos.relPosX, pos.relPosY, false);
        }
    });

    return panel;
}

var showMouseSimulationPad = false;
var currentMouseSimulationGesture = null;
function updateGestureSimluationThumbnail(gestureId, container) {
    var gesture = getGestureById(gestureId);
    var gestureThumbnail = $(container).find('#' + gestureId);

    // reset the simulation controls
    $(gestureThumbnail).find('.simulator-trigger').addClass("hidden");
    $(gestureThumbnail).find('#control-continuous-slider').addClass('hidden');
    $(gestureThumbnail).find('.continuous-gesture-controls').addClass('hidden');
    $(gestureThumbnail).find('.simulator-continuous-trigger').addClass('hidden');
    $(gestureThumbnail).find('.static-continuous-controls').addClass('hidden');

    console.log('gesture', gesture);
    if (gesture.interactionType === TYPE_GESTURE_DISCRETE) {
        $(gestureThumbnail).find('.simulator-trigger').removeClass("hidden");

        $(gestureThumbnail).find('#btn-trigger-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            TweenMax.to($(this), .3, {opacity: 0, scale: 1.1, clearProps: 'all'});
            var gestureId = $(this).closest('.root').attr('id');
            sendPGGesture(gestureId);
        });
    } else {
        if (gesture.continuousValueType === PERCENT) {
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
                sendContinuousPGGesture(gestureId, percent);
            });
        } else if (gesture.continuousValueType === "position" || gesture.continuousValueType === "mouseSimulation") {
            $(gestureThumbnail).find('.simulator-continuous-trigger').removeClass('hidden');
            $(gestureThumbnail).find('#btn-trigger-continuous-gesture').unbind('click').bind('click', function (event) {
                event.preventDefault();
                var mousePad = $(gestureThumbnail).find('.simple-mouse-simulation-pad');
                $(mousePad).removeClass('hidden');
                $(gestureThumbnail).find('.gesture-preview-data').css({filter: 'blur(5px)', opacity: .3});
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
                var tweenDuration = (parseFloat($(gestureThumbnail).attr('data-tween-speed')) * .5);
                console.log(tweenDuration);
                $(gestureThumbnail).find('.control-continuous-slider-status').text(tweenDuration.toFixed(1) + 's');
                TweenMax.to(slider, tweenDuration, {width: '100%', ease: Linear.easeNone, onComplete: function () {
                        $(slider).css({width: '0%'});
                        sendPGGesture(gesture.id);
                        animateSlider();
                    }});
            }
        }
    }

    $(gestureThumbnail).on('mouseenter', function () {
        currentMouseSimulationGesture = getGestureById($(this).attr('id'));
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
//        console.log('check mouse simulation', showMouseSimulationPad, currentMouseSimulationGesture);
        if (showMouseSimulationPad === true && currentMouseSimulationGesture) {
            var gestureThumbnail = $(container).find('#' + currentMouseSimulationGesture.id);

            if (currentMouseSimulationGesture.interactionType === TYPE_GESTURE_DISCRETE) {
                $(gestureThumbnail).find('#btn-trigger-gesture').click();
                var mousePad = $(gestureThumbnail).find('.mouse-simulation-slider').removeClass('hidden');
                TweenMax.to(mousePad, 0, {opacity: 1});
                TweenMax.to(mousePad, 1, {opacity: 0, onComplete: function () {
                        $(mousePad).addClass('hidden');
                    }});
            } else {
                if (currentMouseSimulationGesture.continuousValueType === "position" || currentMouseSimulationGesture.continuousValueType === "mouseSimulation") {
                    var mousePad = $(gestureThumbnail).find('.mouse-simulation-pad');
                    $(mousePad).removeClass('hidden');
                    $(gestureThumbnail).find('.gesture-preview-data').css({filter: 'blur(5px)', opacity: .3});

                    initMouseSimulationPad(mousePad, gestureThumbnail);
                } else if (currentMouseSimulationGesture.continuousValueType === PERCENT) {
                    var mousePad = $(gestureThumbnail).find('.mouse-simulation-slider');
                    $(mousePad).removeClass('hidden');

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
                    });
                }
            }
        } else {
            $(container).find('.mouse-simulation-pad, .simple-mouse-simulation-pad, .mouse-simulation-slider').addClass('hidden');
            $(container).find('.gesture-preview-data').css({filter: '', opacity: ''});
            $(container).unbind('mousemove');
            $(container).find('.btn-stop-static-continuous-gesture').click();
        }
    }
}

function initMouseSimulationPad(mousePad, gestureThumbnail) {
    $(mousePad).on('mousemove', function (event) {
        var relPositions = getMousePosition(mousePad, event);
        $(mousePad).find('.x-position').text(parseFloat(relPositions.relPosX * 100).toFixed() + '%');
        $(mousePad).find('.y-position').text(parseFloat(relPositions.relPosY * 100).toFixed() + '%');

        showCursor(mousePad, CURSOR_CROSSHAIR);
        sendContinuousPGPosition($(this).closest('.root').prop('id'), currentMouseSimulationGesture.continuousValueType, relPositions.relPosX, relPositions.relPosY, false);
    });

    $(mousePad).unbind('click').bind('click', function (event) {
        var relPositions = getMousePosition(mousePad, event);
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