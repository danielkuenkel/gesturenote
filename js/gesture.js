/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var GESTURE_THUMBNAIL_SCROLLING_SPEED = 100;
var popoverVisible = false;
$(window).load(function () {
    $('body').on('mouseenter', '.previewGesture', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('mouseScrollable')) {
            clearTimer();
            playThroughThumbnails($(this), 0);
        }
    });

    $('body').on('mouseleave', '.previewGesture', function (event) {
        event.preventDefault();
        prevSlide = 0;
        resetThumbnails($(this));
    });

    var currentSlide, prevSlide;
    $('body').on('mousemove', '.mouseScrollable', function (event) {
        clearTimer();
        resetPlayButton();
        var innerWidth = $(this).innerWidth();
        var numslides = $(this).children().length;

        if (event.type === 'mousemove') {
            var x = event.pageX - $(this).offset().left;
            currentSlide = Math.floor(x / (innerWidth / numslides)) + 1;

            if (currentSlide !== prevSlide) {
                $(this).children('.active').addClass('hidden');
                $(this).children('.active').removeClass('active');
                $(this).find(':nth-child(' + currentSlide + ')').removeClass('hidden');
                $(this).find(':nth-child(' + currentSlide + ')').addClass('active');
                prevSlide = currentSlide;
                updateModalProgress($(this));
            }
            return false;
        }
    });

    $('body').on('click', '#btn-play-gesture', function (event) {
        event.preventDefault();
        event.stopPropagation();
        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            playThroughThumbnails($(this).closest('.root').find('.imageContainer'), 0);
        }
    });

    $('body').on('click', '#btn-stop-gesture', function (event) {
        event.preventDefault();
        event.stopPropagation();
        currentGestureContainer = $(this).parent();
        resetPlayButton();
        resetThumbnails($(this).closest('.root').find('.imageContainer'));
    });

    $('body').on('click', '#btn-step-forward-gesture', function (event) {
        event.preventDefault();
        event.stopPropagation();
        clearTimer();
        currentGestureContainer = $(this).parent();
        resetPlayButton();
        stepForward($(this).closest('.root').find('.imageContainer'));
    });

    var mouseDownInterval;
    $('body').on('mousedown', '#btn-step-forward-gesture', function (event) {
        event.preventDefault();
        event.stopPropagation();
        clearTimer();
        currentGestureContainer = $(this).parent();
        resetPlayButton();
        mouseDownInterval = setInterval(function (container) {
            stepForward(container);
        }, 200, $(this).closest('.root').find('.imageContainer'));
    });

    $('body').on('mouseup', '#btn-step-forward-gesture, #btn-step-backward-gesture', function (event) {
        event.preventDefault();
        event.stopPropagation();
        clearTimer();
        currentGestureContainer = $(this).parent();
        resetPlayButton();
        clearInterval(mouseDownInterval);
    });

    $('body').on('click', '#btn-step-backward-gesture', function (event) {
        event.preventDefault();
        event.stopPropagation();
        currentGestureContainer = $(this).parent();
        resetPlayButton();
        stepBackward($(this).closest('.root').find('.imageContainer'));
    });

    $('body').on('mousedown', '#btn-step-backward-gesture', function (event) {
        event.preventDefault();
        event.stopPropagation();
        clearTimer();
        mouseDownInterval = setInterval(function (container) {
            console.log(container);
            stepBackward(container);
        }, 200, $(this).closest('.root').find('.imageContainer'));
    });

    $('body').on('click', '.btn-popover-gesture-preview', function (event) {
        event.preventDefault();
        var gesture = getGestureById($(this).attr('name'));

        if (!popoverVisible && !$(this).hasClass('disabled')) {
            showCursor($(this), CURSOR_PROGRESS);
            popoverVisible = true;
            $(this).addClass('active');
            var btn = $(this);

            renderGesturePopoverPreview(gesture, function () {
                var popover = $('#popover-gesture');
                var top = btn.offset().top - (popover.height()) + 0;
                var left = btn.offset().left + (btn.width() / 2) - ((popover.width() - 27) / 2);
                popover.css({left: left, top: top});
                playThroughThumbnails(popover.find('.imageContainer'));
                TweenMax.to(popover, .2, {autoAlpha: 1});
                hideCursor(btn, CURSOR_POINTER);
            });
        } else {
            resetPopover();
            $(this).removeClass('active');
        }
    });

    $('body').on('mouseleave', '.btn-popover-gesture-preview', function (event) {
        event.preventDefault();
        $(this).removeClass('active');
        resetPopover();
    });
});

function resetPopover() {
    var popover = $('#popover-gesture');
    popoverVisible = false;
    resetThumbnails(popover.find('.imageContainer'));
    TweenMax.to(popover, .1, {autoAlpha: 0, onComplete: onResetTweenComplete()});
}

function onResetTweenComplete() {
    $('#popover-gesture').remove();

}

function resetPlayButton() {
    $(currentGestureContainer).parent().find('#btn-play-gesture').removeClass('active');
}

var originalImageWidth = 0;
function renderGestureImages(container, images, preview, callback) {
    var numImagesLoaded = 0;
    currentGestureContainer = container;
    $(container).empty();
    for (var i = 0; i < images.length; i++) {
        var image = document.createElement('img');
        $(image).addClass('gestureImage');
        container.append(image);
        if (i === preview) {
            $(image).addClass('previewImage active');

        } else {
            $(image).addClass('hidden');
        }

        image.onload = function () {
            if (numImagesLoaded === images.length - 1) {
                resetThumbnails(container);
                if ($(container).hasClass('autoplay')) {
                    playThroughThumbnails(container);
                }
                if (callback !== null && callback !== undefined) {
                    callback();
                }
//                setTimeout(callback(), 500);
            }
            numImagesLoaded++;
        };
        image.src = images[i];
    }
}

function renderGesturePopoverPreview(gesture, callback) {
    var popover = $('#popover-gesture-preview').clone();
    popover.attr('id', 'popover-gesture');
    $('body').append(popover);

    renderGestureImages($(popover).find('.imageContainer'), gesture.images, gesture.previewImage, function () {
        popover.find('.panel-heading').text(gesture.title);
        callback();
    });
}

var gestureThumbnailTimer;
function playThroughThumbnails(container) {
    stepForward(container);
    gestureThumbnailTimer = setTimeout(function () {
        playThroughThumbnails(container);
    }, GESTURE_THUMBNAIL_SCROLLING_SPEED);
}

function stepForward(container) {
    var active = $(container).find('.active');
    var next = active.next();
    if (next.length === 0) {
        next = $(container).children().first();
    }
    active.addClass('hidden');
    active.removeClass('active');
    next.removeClass('hidden');
    next.addClass('active');
    updateModalProgress(container);
}

function stepBackward(container) {
    var active = $(container).find('.active');
    var prev = active.prev();
    if (prev.length === 0) {
        prev = $(container).children().last();
    }
    active.addClass('hidden');
    active.removeClass('active');
    prev.removeClass('hidden');
    prev.addClass('active');
    updateModalProgress(container);
}

function resetThumbnails(container) {
    clearTimer();
    var children = $(container).children();
    for (var i = 0; i < children.length; i++) {
        if ($(children[i]).hasClass('previewImage')) {
            $(children[i]).removeClass('hidden');
            $(children[i]).addClass('active');
        } else {
            $(children[i]).addClass('hidden');
            $(children[i]).removeClass('active');
        }
    }
    updateModalProgress(container);
}

function clearTimer() {
    clearTimeout(gestureThumbnailTimer);
}

function updateModalProgress(container) {
    var children = container.children().length;
    var currentActiveIndex = container.find('.active').index();
    var percent = 100 / (children - 1) * currentActiveIndex;

    if (container.next().hasClass('progress')) {
        container.next().find('.progress-bar').css('width', percent + '%');
    }
}