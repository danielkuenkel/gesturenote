/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
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

    $('body').on('click', '#btn-gesture-styleguides', function (event) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
            gotoGestureStyleguides();
        }
    });

    $('body').on('click', '#btn-gesture-catalog', function (event) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
            gotoGesturesCatalog();
        }
    });
});


function gotoDashboard() {
    goto('dashboard-evaluator.php');
}

function gotoStudies() {
    goto('studies.php');
}

function gotoProfile() {
    goto('profile.php');
}

function gotoGestureStyleguides() {
    goto('gesture-styleguides.php');
}

function gotoGesturesCatalog() {
    goto('gestures-catalog.php');
}

function gotoCreateStudy() {
    goto('study-create.php');
}

function gotoCreateStudyPreview() {
    goto('study-preview.php');
}