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

    $('body').on('click', '#btn-news', function (event) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
            gotoNews();
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

    $('body').on('click', '#btn-publications', function (event) {
        event.preventDefault();
        console.log('click')
        if (!event.handled) {
            event.handled = true;
            gotoPublications();
        }
    });
});


function gotoDashboard() {
    clearLocalItems();
    goto('dashboard-evaluator.php');
}

function gotoStudies() {
    clearLocalItems();
    goto('studies.php');
}

function gotoNews() {
    clearLocalItems();
    goto('news.php');
}

function gotoProfile() {
    clearLocalItems();
    goto('profile.php');
}

function gotoGestureStyleguides() {
    clearLocalItems();
    goto('gesture-styleguides.php');
}

function gotoGesturesCatalog() {
    clearLocalItems();
    goto('gestures-catalog.php');
}

function gotoCreateStudy() {
    clearLocalItems();
    goto('study-create.php');
}

function gotoCreateStudyPreview() {
    goto('study-preview.php');
}

function gotoPublications() {
    goto('publications.php');
}