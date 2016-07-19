/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(window).load(function () {
    var ts_prevslide, ts_currslide;

    // use .on() to support ajax loaded elements
    $(document.body).on('mousemove mouseleave', '.thumbscrubber', function (e) {
        var width = $(this).innerWidth();
        var $slides = $('.ts-inner', this).children();
        var numslides = $slides.length;

        if (e.type === 'mousemove') {
            x = e.pageX - $(this).offset().left;
            ts_currslide = Math.floor(x / (width / numslides)) + 1;
            // don't add/remove class if mouse inside current slide threshold
            if (ts_currslide !== ts_prevslide) {
                ts_prevslide = ts_currslide;
                $('.ts-inner > .ts-currslide', this).removeClass('ts-currslide');
                $('.ts-inner > :nth-child(' + ts_currslide + ')', this).addClass('ts-currslide');
            }
            return false;
        }
        // on mouseleave, reset back to ts-currslide slide
        else if (e.type === 'mouseleave') {
            ts_currslide = parseInt($('.preview', this).text()) + 1;
            ts_prevslide = 0;
            $('.ts-inner > .ts-currslide', $(this)).removeClass('ts-currslide');
            $('.ts-inner > :nth-child(' + ts_currslide + ')', $(this)).addClass('ts-currslide');

        }
    });
});