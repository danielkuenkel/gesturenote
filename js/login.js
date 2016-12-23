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

$(document).on('click', '#btn-forgot-password', function (event) {
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
        console.log('reset password');
        requestPasswordReset({email: $('#login-form #email').val().trim()}, function (result) {
            enableInputs();

            if (result.status === RESULT_SUCCESS) {
                $('#login-form #email').val('');
                appendAlert($('#login'), ALERT_PASSWORD_RESET_SEND);
            } else if (result.status === 'emailDoesntExist') {
                appendAlert($('#login'), ALERT_CHECK_EMAIL);
            } else {
                appendAlert($('#login'), ALERT_GENERAL_ERROR);
            }
        });
    }
});