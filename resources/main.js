/**
 * Created by north on 2015-11-26.
 */
var $nav    = $('#nav'),
    offset_val = 50;


// Method
// =================================================

function navSlide() {
    var scroll_top = $(window).scrollTop();
    if (scroll_top >= offset_val) { // the detection!
        $nav.addClass('on-top');
    } else {
        $nav.removeClass('on-top');
    }

    console.log("scrolll");
}

// Handler
// =================================================

$(window).scroll(navSlide);
console.log("loaded");