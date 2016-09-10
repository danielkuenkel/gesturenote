/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function goto(url) {
    window.location.href = url;
}

$(document).ready(function () {
    $('body').on('click', '#btn-imprint', function (event) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
            gotoImprint();
        }
    });

    $('body').on('click', '#btn-index', function (event) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
            gotoIndex();
        }
    });
});


function gotoIndex() {
    goto('index.php');
}

function gotoImprint() {
    goto('imprint.php');
}