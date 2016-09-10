/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('click', '#btn-open-register', function (event) {
    event.preventDefault();
    $('#modal-register').modal('show');
});

$(document).on('hidden.bs.modal', '#modal-register', function () {
    $(this).find('#register-form').removeClass('hidden');
    $(this).find('#btn-register').removeClass('hidden');
    $(this).find('#userType').removeClass('hidden');
    $(this).find('#btn-close').addClass('hidden');
    $(this).find('input').val('');
    $(this).find('#usertype .btn-option-checked').removeClass('btn-option-checked').mouseleave();
    clearAlerts($(this));
});

$(document).on('click', '#modal-register #btn-close', function (event) {
    event.preventDefault();
    $('#modal-register').modal('hide');
});

$(document).on('click', '#btn-register', function (event) {
    event.preventDefault();
    if (!$(this).hasClass('disabled')) {
        clearAlerts($('#register-form'));
        registerFormhash($('#register-form'));
    }
});

$(document).on('submit', '#register-form', function (event) {
    event.preventDefault();

    disableInputs();
    var formElement = $(this);
    clearAlerts(formElement);

    var forename = $('#register-form #forename').val().trim();
    var surname = $('#register-form #surname').val().trim();
    var email = $('#register-form #email').val().trim();
    var p = $('#register-form #p').val().trim();
    var date = parseInt($('#register-form #date').val().trim());
    var month = parseInt($('#register-form #month').val().trim());
    var year = parseInt($('#register-form #year').val().trim());
    var birthday = year + "-" + month + "-" + date;
    var gender = $('#modal-register #gender').find('.btn-option-checked').attr('id');
    var userType = $('#modal-register #userType').find('.btn-option-checked').attr('id');

    register({forename: forename, surname: surname, email: email, p: p, birthday: birthday, gender: gender, userType: userType}, function (result) {
        clearAlerts(formElement);
        enableInputs();

        if (result.status === 'emailExists') {
            appendAlert($('#modal-register'), ALERT_USER_EXISTS);
        } else if (result.status === 'success') {
            appendAlert($('#modal-register'), ALERT_REGISTER_SUCCESS);
            $('#modal-register').find('#register-form').addClass('hidden');
            $('#modal-register').find('#btn-register').addClass('hidden');
            $('#modal-register').find('#userType').addClass('hidden');
            $('#modal-register').find('#btn-close').removeClass('hidden');
            formElement.trigger('registerSuccess', [result]);
        } else if (result.status === 'error') {
            appendAlert($('#modal-register'), ALERT_GENERAL_ERROR);
        }
    });
});