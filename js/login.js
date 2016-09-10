/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var form = null;
$(document).on('click', '#btn-login', function (event) {
    event.preventDefault();
    if (!$(this).hasClass('disabled')) {
        form = 'login';
        clearAlerts($('#login-form'));
        loginFormhash($('#login-form'), $('#login-form #email'), $('#login-form #password'));
    }
});

$(document).on('click', '#btn-forgot', function (event) {
    event.preventDefault();
    if (!$(this).hasClass('disabled')) {
        form = 'forgot';
        clearAlerts($('#login-form'));
        forgotFormhash($('#login-form'), $('#login-form #email'));
    }
});

$(document).on('submit', '#login-form', function (event) {
    event.preventDefault();
    var formElement = $(this);
    clearAlerts(formElement);
    disableInputs();

    if (form === 'login') {
        var data = {email: $('#login-form #email').val().trim(), p: $('#login-form #p').val()};
        login(data, function (result) {
            clearAlerts(formElement);
            enableInputs();

            if (result.status === 'accountLogged') {
                appendAlert($('#login'), ALERT_ACCOUNT_LOGGED);
            } else if (result.status === 'passwordNotCorrect') {
                appendAlert($('#login'), ALERT_WRONG_PASSWORD);
            } else if (result.status === 'loginFailed') {
                appendAlert($('#login'), ALERT_LOGIN_FAILED);
            } else if (result.status === 'noUserExists') {
                appendAlert($('#login'), ALERT_NO_USER_EXISTS);
            } else if (result.status === 'success') {
                formElement.trigger('loginSuccess', [result]);
            } else if (data.status === 'databaseError') {
                appendAlert($('#login'), ALERT_GENERAL_ERROR);
            }
        });
    } else if (form === 'forgot') {
        forgot({email: $('#login-form #email').val().trim()});
    }
});