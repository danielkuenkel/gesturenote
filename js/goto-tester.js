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
});

function gotoDashboard() {
    goto("dashboard-tester.php");
}

function gotoStudies() {
    goto("studies-tester.php");
}

function gotoProfile() {
    goto("profile-tester.php");
}