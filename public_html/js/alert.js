/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// alert constants
var ALERT_NO_WEBSOCKETS = 'no-websockets';

function appendAlert(target, alertType) {
    var children = $(target).find('.alert-' + alertType).find('#' + alertType);
    
    if (children.length === 0) {
        var alert = $('#alert-container').find('#' + alertType).clone();
        console.log('append alert: ' + $('#alert-container'));
        $(target).find('.alert-' + alert.attr('id')).append(alert);
    }
}

function removeAlert(target, alertType) {
    $(target).find('.alert-' + alertType).empty();
}