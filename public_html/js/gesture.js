/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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

    $('body').on('click', '#play', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            playThroughThumbnails($(this).closest('.root').find('.imageContainer'), 0);
        }
    });

    $('body').on('click', '#stop', function (event) {
        event.preventDefault();
        resetPlayButton();
        resetThumbnails($(this).closest('.root').find('.imageContainer'));
    });

    $('body').on('click', '#stepForward', function (event) {
        event.preventDefault();
        clearTimer();
        resetPlayButton();
        stepForward($(this).closest('.root').find('.imageContainer'));
    });

    var mouseDownInterval;
    $('body').on('mousedown', '#stepForward', function (event) {
        event.preventDefault();
        clearTimer();
        resetPlayButton();
        mouseDownInterval = setInterval(function (container) {
            console.log(container);
            stepForward(container);
        }, 100, $(this).closest('.root').find('.imageContainer'));
    });

    $('body').on('mouseup', '#stepForward, #stepBackward', function (event) {
        event.preventDefault();
        clearTimer();
        resetPlayButton();
        clearInterval(mouseDownInterval);
    });

    $('body').on('click', '#stepBackward', function (event) {
        event.preventDefault();
        resetPlayButton();
        stepBackward($(this).closest('.root').find('.imageContainer'));
    });

    $('body').on('mousedown', '#stepBackward', function (event) {
        event.preventDefault();
        clearTimer();
        mouseDownInterval = setInterval(function (container) {
            console.log(container);
            stepBackward(container);
        }, 100, $(this).closest('.root').find('.imageContainer'));
    });
});


function resetPlayButton() {
    $('#play').removeClass('active');
}

function renderGestureImages(container, images, preview) {
    for (var j = 0; j < images.length; j++) {
        var image = $('#gestureThumbnailImage').clone().removeClass('hidden');
        image.attr('src', images[j]);
        image.removeAttr('id');
        container.append(image);

        if (j !== preview) {
            image.addClass('hidden');
        } else {
            image.addClass('previewImage');
            image.addClass('active');
        }
    }
    if($(container).hasClass('autoplay')) {
        playThroughThumbnails(container);
    }
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