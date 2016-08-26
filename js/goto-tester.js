/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function goto(url) {
    window.location.href = url;
}

$(document).ready(function () {
    $('body').on('click', '#btn-index', function (event) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
            gotoIndex();
        }
    });

    $('body').on('click', '#btn-dashboard', function (event) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
            gotoDashboard();
        }
    });

    $('body').on('click', '#btn-studies', function (event) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
            gotoStudies();
        }
    });

    $('body').on('click', '#btn-profile', function (event) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
            gotoProfile();
        }
    });

//    $('body').on('click', '#btn-gesture-styleguides', function (event) {
//        event.preventDefault();
//        if (!event.handled) {
//            event.handled = true;
//            gotoGestureStyleguides();
//        }
//    });
//
//    $('body').on('click', '#btn-gesture-catalog', function (event) {
//        event.preventDefault();
//        if (!event.handled) {
//            event.handled = true;
//            gotoGesturesCatalog();
//        }
//    });
});


function gotoIndex() {
    goto("index.php");
}

function gotoDashboard() {
    goto("dashboard-tester.php");
}

function gotoStudies() {
    goto("studies-tester.php");
}

function gotoProfile() {
    goto("profile-tester.php");
}

//function gotoGestureStyleguides() {
//    goto("gesture-styleguides.php");
//}
//
//function gotoGesturesCatalog() {
//    goto("gestures-catalog.php");
//}
//
//function gotoCreateStudy() {
//    goto("study-create.php");
//}
//
//function gotoCreateStudyPreview() {
//    goto("study-preview.php");
//}

function getQueryParams(qs) {
    qs = qs.split('+').join(' ');

    var params = {},
            tokens,
            re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
        params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
    }

    return params;
}