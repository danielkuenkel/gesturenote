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
        if (!event.handled) {
            event.handled = true;
            gotoPublications();
        }
    });

    $('body').on('click', '#btn-support', function (event) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
            gotoSupport();
        }
    });

    $('body').on('click', '#btn-informations', function (event) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
            gotoInformations();
        }
    });
});


function gotoDashboard() {
    clearLocalItems();
    goto('dashboard.php');
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

function gotoSupport() {
    clearLocalItems();
    goto('help-catalog.php');
}

function gotoInformations() {
    clearLocalItems();
    goto('informations.php');
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

function gotoCreateExtractionStudy() {
    clearLocalItems();
    goto('extraction-create.php');
}

function gotoCreateStudyPreview() {
    goto('study-preview.php');
}

function gotoPublications() {
    goto('publications.php');
}