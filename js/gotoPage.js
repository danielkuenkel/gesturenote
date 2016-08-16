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
        console.log('test');
        if (!event.handled) {
            event.handled = true;
            gotoDashboard();
        }
    });

    $('body').on('click', '#btn-projects', function (event) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
            gotoProjects();
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


function gotoIndex() {
    goto("index.php");
}

function gotoDashboard() {
    goto("dashboard.php");
}

function gotoProjects() {
    goto("projects.php");
}

function gotoProfile() {
    goto("profile.php");
}

function gotoGestureStyleguides() {
    goto("gesture-styleguides.php");
}

function gotoGesturesCatalog() {
    goto("gestures-catalog.php");
}

function gotoCreateProject() {
    goto("project-create.php");
}

function gotoCreateProjectPreview() {
    goto("project-preview.php");
}

function gotoProjectSavedSuccessfully() {
    goto("project-save-success.php");
}