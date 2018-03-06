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
        if ($(this).hasClass('mousePlayable')) {
            $(this).parent().find('#btn-play-gesture').click();
        }
    });

    $('body').on('mouseleave', '.previewGesture', function (event) {
        event.preventDefault();
        if ($(this).hasClass('mouseScrollable') || $(this).hasClass('mousePlayable')) {
            $(this).parent().find('#btn-stop-gesture').click();
        }
    });

    var currentSlide, prevSlide;
    $('body').on('mousemove', '.mouseScrollable', function (event) {
        clearTimer();
        resetPlayButton($(this));
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
        event.stopImmediatePropagation();
        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            playThroughThumbnails($(this).closest('.root').find('.previewGesture'), 0);
        }
    });

    $('body').on('click', '#btn-stop-gesture', function (event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();
        resetPlayButton($(this));
        resetThumbnails($(this).closest('.root').find('.previewGesture'));
    });

    $('body').on('click', '#btn-step-forward-gesture', function (event) {
        event.preventDefault();
        event.stopPropagation();
        clearTimer();
        resetPlayButton($(this));
        stepForward($(this).closest('.root').find('.previewGesture'));
    });

    var mouseDownInterval;
    $('body').on('mousedown', '#btn-step-forward-gesture', function (event) {
        event.preventDefault();
        event.stopPropagation();
        clearTimer();
        resetPlayButton($(this));
        mouseDownInterval = setInterval(function (container) {
            stepForward(container);
        }, 200, $(this).closest('.root').find('.previewGesture'));
    });

    $('body').on('mouseup', '#btn-step-forward-gesture, #btn-step-backward-gesture', function (event) {
        event.preventDefault();
        event.stopPropagation();
        clearTimer();
        resetPlayButton($(this));
        clearInterval(mouseDownInterval);
    });

    $('body').on('click', '#btn-step-backward-gesture', function (event) {
        event.preventDefault();
        event.stopPropagation();
        resetPlayButton($(this));
        stepBackward($(this).closest('.root').find('.previewGesture'));
    });

    $('body').on('mousedown', '#btn-step-backward-gesture', function (event) {
        event.preventDefault();
        event.stopPropagation();
        clearTimer();
        mouseDownInterval = setInterval(function (container) {
            console.log(container);
            stepBackward(container);
        }, 200, $(this).closest('.root').find('.previewGesture'));
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
                popover.css({left: left, top: top, zIndex: 10000});
                playThroughThumbnails(popover.find('.previewGesture'));
                TweenMax.to(popover, .2, {autoAlpha: 1});
                showCursor(btn, CURSOR_POINTER);
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
    resetThumbnails(popover.find('.previewGesture'));
    TweenMax.to(popover, .1, {autoAlpha: 0, onComplete: onResetTweenComplete()});
}

function onResetTweenComplete() {
    $('#popover-gesture').remove();

}

function resetPlayButton(source) {
    $(source).closest('.root').find('#btn-play-gesture').removeClass('active');
}

var originalImageWidth = 0;
function renderGestureImages(container, images, preview, callback) {
    var numImagesLoaded = 0;
    $(container).empty();
    $(container).addClass('text-center');

    $(container).addClass('hidden');
    addLoadingIcon($(container).parent());

    for (var i = 0; i < images.length; i++) {
        var image = document.createElement('img');
        $(image).addClass('gestureImage mirroredHorizontally embed-responsive-item');
        container.append(image);
        if (i === parseInt(preview)) {
            $(image).addClass('previewImage active');
        } else {
            $(image).addClass('hidden');
        }

        image.onload = function () {
            if (numImagesLoaded === images.length - 1) {
                resetThumbnails(container);

                removeLoadingIcon($(container).parent());
                $(container).removeClass('hidden');

                if ($(container).hasClass('autoplay')) {
                    $(container).parent().find('#btn-stop-gesture').click();
                    $(container).parent().find('#btn-play-gesture').click();
                }
                if (callback !== null && callback !== undefined) {
                    callback();
                }
//                setTimeout(callback(), 500);
            }
            numImagesLoaded++;
        };
        image.src = images[i];
//        console.log(image.width);
    }
}

function renderGesturePreview(container, gesture, callback) {
    var numImagesLoaded = 0;
//    $(container).find('.webcam-image-container').empty().addClass('hidden');

//    addLoadingIcon($(container).parent());    
    var imageContainer = $(container).find('.webcam-image-container');
    $(imageContainer).empty();

    if (gesture.images && gesture.images.length > 0) {
        for (var i = 0; i < gesture.images.length; i++) {
            var image = document.createElement('img');
            $(image).addClass('gestureImage mirroredHorizontally embed-responsive-item roundedTop');
            $(image).attr('data-index', i);
            $(imageContainer).append(image);
            $(image).addClass(i === parseInt(gesture.previewImage) ? 'previewImage active' : 'hidden');

            image.onload = function () {
                if (numImagesLoaded === gesture.images.length - 1) {
//                    resetThumbnails(container);

//                    removeLoadingIcon($(container).parent());
                    $(imageContainer).removeClass('hidden');

//                    if ($(container).hasClass('autoplay')) {
//                        $(container).parent().find('#btn-stop-gesture').click();
//                        $(container).parent().find('#btn-play-gesture').click();
//                    }

                    if (callback !== null && callback !== undefined) {
                        callback();
                    }
//                setTimeout(callback(), 500);
                }
                numImagesLoaded++;
            };
            image.src = gesture.images[i];
        }
    }

    var togglePlaybackButton = $(container).find('#btn-toggle-playback');
    if (togglePlaybackButton) {
        $(togglePlaybackButton).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                if ($(this).attr('data-state') === 'playing') {
                    $(this).attr('data-state', 'paused');
                    $(this).find('.fa').removeClass('fa-pause').addClass('fa-play');
                    stopPlayThroughThumbnails();
//                    resetThumbnails(imageContainer);
                } else {
                    $(this).attr('data-state', 'playing');
                    $(this).find('.fa').removeClass('fa-play').addClass('fa-pause');
                    playThroughThumbnails(imageContainer);
                }
            }
        });
    }

    if ($(container).hasClass('autoplay')) {
        if (togglePlaybackButton) {
            $(togglePlaybackButton).click();
        } else {
            playThroughThumbnails(imageContainer);
        }
    }

    var slider = $(container).find('#webcam-playback-slider');
    if (slider && $(container).find('#webcam-playback-slider-controls').attr('data-visible') === 'true') {
        $(container).find('#webcam-playback-slider-controls').removeClass('hidden');
        var sliderOptions = {
            min: 0,
            max: gesture.images.length - 1,
            step: 1,
            value: gesture.preview
        };
        $(slider).slider(sliderOptions);

        $(imageContainer).unbind('imageChange').bind('imageChange', function (event, index) {
            $(slider).slider('setValue', index);
        });

        $(slider).unbind('slide').bind('slide', function (event) {
            if (togglePlaybackButton && $(togglePlaybackButton).attr('data-state') === 'playing') {
                $(togglePlaybackButton).click();
            }
            $(imageContainer).children().removeClass('active').addClass('hidden');
            $($(imageContainer).children()[event.value]).addClass('active').removeClass('hidden');
        });

        $(slider).unbind('change').bind('change', function (event) {
            if (togglePlaybackButton && $(togglePlaybackButton).attr('data-state') === 'playing') {
                $(togglePlaybackButton).click();
            }
            $(imageContainer).children().removeClass('active').addClass('hidden');
            $($(imageContainer).children()[event.value.newValue]).addClass('active').removeClass('hidden');
        });
    }
}

function renderGesturePopoverPreview(gesture, callback) {
    var popover = $('#popover-gesture-preview').clone();
    popover.attr('id', 'popover-gesture');
    $('body').append(popover);

    if (gesture) {
        renderGestureImages($(popover).find('.previewGesture'), gesture.images, gesture.previewImage, function () {
            popover.find('.panel-heading').text(gesture.title);
            callback();
        });
    }
}

var gestureThumbnailTimer;
function playThroughThumbnails(container) {
    clearTimer();
    stepForward(container);
    gestureThumbnailTimer = setTimeout(function () {
        playThroughThumbnails(container);
    }, GESTURE_THUMBNAIL_SCROLLING_SPEED);
}

function stopPlayThroughThumbnails() {
    clearTimer();
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
    $(container).trigger('imageChange', [parseInt(next.attr('data-index'))]);
//    updateModalProgress(container);
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
    $(container).trigger('imageChange', [parseInt(prev.attr('data-index'))]);
//    updateModalProgress(container);
}

function resetThumbnails(container) {
    clearTimer();
    var previewIndex;
    var children = $(container).children();
    for (var i = 0; i < children.length; i++) {
        if ($(children[i]).hasClass('previewImage')) {
            previewIndex = $(children[i]).attr('data-index');
            $(children[i]).removeClass('hidden');
            $(children[i]).addClass('active');
        } else {
            $(children[i]).addClass('hidden');
            $(children[i]).removeClass('active');
        }
    }
    $(container).trigger('imageChange', [parseInt(previewIndex)]);
//    updateModalProgress(container);
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

function addLoadingIcon(target) {
    var icon = document.createElement('i');
    $(icon).addClass('fa fa-circle-o-notch fa-spin fa-3x fa-fw');
//    $(icon).css({position: 'relative', margin: '0 auto'});
    $(icon).attr('id', 'loading-icon');
    $(target).append(icon);
}

function removeLoadingIcon(target) {
    $(target).find('#loading-icon').remove();
}

function getGestureImagesData(source) {
    var gestureImages = $(source).find('.gestureImage');
    var srcArray = new Array();
    for (var i = 0; i < gestureImages.length; i++) {
        var url = $(gestureImages[i]).attr('src');
//        srcArray.push(url.replace("data:image/jpeg;base64,/", ""));
        srcArray.push(url);
    }

    return srcArray;
}