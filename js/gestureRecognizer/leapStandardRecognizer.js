/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var LEAP_SWIPE_DIRECTION_UP = 'up';
var LEAP_SWIPE_DIRECTION_DOWN = 'down';
var LEAP_SWIPE_DIRECTION_RIGHT = 'right';
var LEAP_SWIPE_DIRECTION_LEFT = 'left';

var EVENT_LEAP_GESTURE = 'leapGesture';
var LEAP_SWIPE_GESTURE = 'leapSwipeGesture';
var LEAP_CIRCLE_GESTURE = 'leapCircleGesture';
var LEAP_SCREEN_TAP_GESTURE = 'leapScreenTapGesture';
var LEAP_KEY_TAP_GESTURE = 'leapKeyTapGesture';

var leapStandardRecognizer = null;
LeapStandardRecognizer.prototype.options = null;

var recognizerTimeout = null;
var timeoutRunning = false;
var currentGesture = null;
function LeapStandardRecognizer(options) {
    if (leapStandardRecognizer) {
        leapStandardRecognizer.destroy();
        leapStandardRecognizer = null;
    }

    leapStandardRecognizer = this;

    if (!options || options === null) {
        options = {};
    }

    var controller = new Leap.Controller({enableGestures: true});
    options.controller = controller;
    controller.connect();

    controller.on('gesture', onGesture);
    function onGesture(gesture, frame)
    {
        if (!timeoutRunning) {
            recognizerTimeout = setTimeout(function () {
                timeoutRunning = false;
            }, 500);

            timeoutRunning = true;

            var id = 0; // hard coded gesture id, which is in the database
            switch (gesture.type) {
                case "keyTap":
                    id = 381;
                    $(leapStandardRecognizer).trigger(EVENT_LEAP_GESTURE, [{id: id, type: LEAP_KEY_TAP_GESTURE}]);
                    break;
                case "screenTap":
                    id = 382;
                    $(leapStandardRecognizer).trigger(EVENT_LEAP_GESTURE, [{id: id, type: LEAP_SCREEN_TAP_GESTURE}]);
                    break;
                case "circle":
                    var isClockwise = (gesture.normal[2] <= 0);
                    id = isClockwise ? 376 : 375;
                    $(leapStandardRecognizer).trigger(EVENT_LEAP_GESTURE, [{id: id, type: LEAP_CIRCLE_GESTURE, isClockwise: isClockwise, progress: gesture.progress}]);
                    break;
                case "swipe":
                    var isHorizontal = Math.abs(gesture.direction[0]) > Math.abs(gesture.direction[1]);
                    var swipeDirection = null;

                    //Classify as right-left or up-down
                    if (isHorizontal) {
                        if (gesture.direction[0] > 0) {
                            swipeDirection = LEAP_SWIPE_DIRECTION_RIGHT;
                            id = 378;
                        } else {
                            swipeDirection = LEAP_SWIPE_DIRECTION_LEFT;
                            id = 377;
                        }
                    } else { //vertical
                        if (gesture.direction[1] > 0) {
                            swipeDirection = LEAP_SWIPE_DIRECTION_UP;
                            id = 379;
                        } else {
                            swipeDirection = LEAP_SWIPE_DIRECTION_DOWN;
                            id = 380;
                        }
                    }
                    $(leapStandardRecognizer).trigger(EVENT_LEAP_GESTURE, [{id: id, type: LEAP_SWIPE_GESTURE, direction: swipeDirection, speed: gesture.speed}]);
                    break;
            }
        }
    }

    leapStandardRecognizer.options = options;
}

LeapStandardRecognizer.prototype.destroy = function () {
    var options = this.options;

    if (options.controller) {
        options.controller.removeAllListeners('gesture');
        options.controller = null;
    }
};