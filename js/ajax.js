/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function login(data) {
    $.ajax({
        url: 'includes/process_login.php',
        data: data,
        type: 'post',
        success: function (data) {

            resetAlerts();
            if (data.status === 'accountLogged') {
                showAlert($('#login'), ALERT_ACCOUNT_LOGGED);
            } else if (data.status === 'passwordNotCorrect') {
                showAlert($('#login'), ALERT_WRONG_PASSWORD);
            } else if (data.status === 'loginFailed') {
                showAlert($('#login'), ALERT_LOGIN_FAILED);
            } else if (data.status === 'noUserExists') {
                showAlert($('#login'), ALERT_NO_USER_EXISTS);
            } else if (data.status === 'success') {
                window.location.replace('dashboard.php');
            } else if (data.status === 'databaseError') {
                showAlert($('#login'), ALERT_GENERAL_ERROR);
            }
        },
        error: function (xhr, desc, err) {
            showAlert($('#login'), ALERT_GENERAL_ERROR);
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });
}

function register(data) {
    $.ajax({
        url: 'includes/register.php',
        data: data,
        type: 'post',
        success: function (data) {
            resetAlerts();
            if (data.status === 'emailExists') {
                showAlert($('#modal-register'), ALERT_USER_EXISTS);
            } else if (data.status === 'success') {
                showAlert($('#modal-register'), ALERT_REGISTER_SUCCESS);
                $('#modal-register').find('#register-form').addClass('hidden');
                $('#modal-register').find('#btn-register').addClass('hidden');
                $('#modal-register').find('#userType').addClass('hidden');
                $('#modal-register').find('#btn-close').removeClass('hidden');
            } else if (data.status === 'error') {
                showAlert($('#modal-register'), ALERT_GENERAL_ERROR);
            }
        },
        error: function (xhr, desc, err) {
            showAlert($('#modal-register'), ALERT_GENERAL_ERROR);
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });
}

function saveProject(data) {
    $.ajax({
        url: 'includes/save-project.php',
        data: data,
        type: 'post',
        success: function (data) {
            console.log(data);
            if (data.status === 'success') {
//                appendAlert($('body'), ALERT_REGISTER_SUCCESS);

            } else if (data.status === 'error') {
                appendAlert($('body'), ALERT_GENERAL_ERROR);
            }
        },
        error: function (xhr, desc, err) {
            appendAlert($('body'), ALERT_GENERAL_ERROR);
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });
}