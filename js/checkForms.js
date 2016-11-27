function loginFormhash(form, email, password) {
    if ($(email).val().trim() === '' || $(password).val().trim() === '') {
        appendAlert($('#login'), ALERT_MISSING_FIELDS);
//        showAlert($('#login'), ALERT_MISSING_FIELDS);
        return false;
    }

    // Add the new element to our form. 
    if ($(form).find('#p').length > 0) {
        $(form).find('#p').val(hex_sha512(password.val()));
    } else {
        var p = document.createElement("input");
        $(form).append(p);
        $(p).attr('id', 'p');
        $(p).attr('name', 'p');
        $(p).attr('type', 'hidden');
        $(p).val(hex_sha512(password.val()));
    }

    // Make sure the plaintext password doesn't get sent. 
    password.val("");

    // Finally submit the form. 
    form.submit();
}

function forgotFormhash(form, email) {
    if ($(email).val().trim() === '' || $(password).val().trim() === '') {
        appendAlert($('#login'), ALERT_MISSING_FIELDS);
//        showAlert($('#login'), ALERT_MISSING_FIELDS);
        return false;
    }

    form.submit();
}

function registerFormhash(form) {
    // Check each field has a value

    var forename = $(form).find('#forename');
    var surname = $(form).find('#surname');
    var email = $(form).find('#email');
    var password = $(form).find('#password');
    var passwordconfirm = $(form).find('#confirmPassword');
    var userType = $(form).find('#userType .btn-option-checked').attr('id');
    var gender = $(form).find('#gender .btn-option-checked').attr('id');
    var date = $(form).find('#date');
    var month = $(form).find('#month');
    var year = $(form).find('#year');

    console.log(userType, gender, date, month, year);

    if ($(forename).val().trim() === '' ||
            $(surname).val().trim() === '' ||
            $(email).val().trim() === '' ||
            $(password).val().trim() === '' ||
            $(passwordconfirm).val().trim() === '' ||
            userType === undefined || userType === 'tester' && (
                    (gender === undefined) ||
                    $(date).val().trim() === '' ||
                    $(month).val().trim() === '' ||
                    $(year).val().trim() === '')) {
        appendAlert(form, ALERT_MISSING_FIELDS);
        return false;
    }

    // Check the username

//    re = "([a-zA-Z]{3,30}\s*)+"; 
//    if(!re.test($(username).val())) { 
//        alert("Username must contain only letters, numbers and underscores. Please try again"); 
//        $(username).focus();
//        return false; 
//    }

    // validate email
    if (!validateEmail($(email).val().trim())) {
        $(email).focus();
        appendAlert(form, ALERT_INVALID_EMAIL);
//        showAlert($('#modal-register'), ALERT_INVALID_EMAIL);
        return false;
    }

    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if ($(password).val().length < 6) {
        $(password).focus();
        appendAlert(form, ALERT_PASSWORD_SHORT);
//        showAlert($('#modal-register'), ALERT_PASSWORD_SHORT);
        return false;
    }

    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 

    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
    if (!re.test($(password).val())) {
        $(password).focus();
        appendAlert(form, ALERT_PASSWORD_INVALID);
//        showAlert($('#modal-register'), ALERT_PASSWORD_INVALID);
        return false;
    }

    // Check password and confirmation are the same
    if ($(password).val() !== $(passwordconfirm).val()) {
        $(passwordconfirm).focus();
        appendAlert(form, ALERT_PASSWORDS_NOT_MATCHING);
        return false;
    }

    if (userType === 'tester') {
        var dateString = $(date).val().trim();
        var monthString = $(month).val().trim();
        var yearString = $(year).val().trim();
        var now = new Date();

        // check birthday input fields
        if ((dateString.length < 1 || dateString.length > 2) ||
                isNaN(dateString) ||
                (parseInt(dateString) < 1 || parseInt(dateString) > 31))
        {
            $(date).focus();
            appendAlert(form, ALERT_INVALID_BIRTHDAY);
            return false;
        }

        if ((monthString.length < 1 || monthString.length > 2) ||
                isNaN(monthString) ||
                (parseInt(monthString) < 1 || parseInt(monthString) > 12))
        {
            $(month).focus();
            appendAlert(form, ALERT_INVALID_BIRTHDAY);
            return false;
        }

        if (yearString.length !== 4 || isNaN(yearString) ||
                isNaN(yearString) ||
                (parseInt(yearString) < 1920 || parseInt(yearString) > now.getFullYear()))
        {
            $(year).focus();
            appendAlert(form, ALERT_INVALID_BIRTHDAY);
//        showAlert($('#modal-register'), ALERT_INVALID_BIRTHDAY);
            return false;
        }
    }

    // Add the new element to our form. 
    if ($(form).find('#p').length > 0) {
        $(form).find('#p').val(hex_sha512(password.val()));
    } else {
        var p = document.createElement("input");
        $(form).append(p);
        $(p).attr('id', 'p');
        $(p).attr('name', 'p');
        $(p).attr('type', 'hidden');
        $(p).val(hex_sha512($(password).val()));
    }

    // Make sure the plaintext password doesn't get sent. 
    $(password).val('');
    $(passwordconfirm).val('');

    // Finally submit the form. 
    form.submit();
}

function updateFormhash(form, alertTarget) {
    // Check each field has a value

    var forename = $(form).find('#input-forename');
    var surname = $(form).find('#input-surname');
//    var email = $(form).find('#input-email');
    var date = $(form).find('#input-date');
    var month = $(form).find('#input-month');
    var year = $(form).find('#input-year');

    if ($(forename).val().trim() === '' ||
            $(surname).val().trim() === '' ||
//            $(email).val().trim() === '' ||
            $(date).val().trim() === '' ||
            $(month).val().trim() === '' ||
            $(year).val().trim() === '') {
        appendAlert(alertTarget, ALERT_MISSING_FIELDS);
        return false;
    }

    // validate email
//    if (!validateEmail($(email).val().trim())) {
//        $(email).focus();
//        appendAlert(alertTarget, ALERT_INVALID_EMAIL);
//        return false;
//    }

    var dateString = $(date).val().trim();
    var monthString = $(month).val().trim();
    var yearString = $(year).val().trim();
    var now = new Date();

    // check birthday input fields
    if ((dateString.length < 1 || dateString.length > 2) ||
            isNaN(dateString) ||
            (parseInt(dateString) < 1 || parseInt(dateString) > 31))
    {
        $(date).focus();
        appendAlert(alertTarget, ALERT_INVALID_BIRTHDAY);
        return false;
    }

    if ((monthString.length < 1 || monthString.length > 2) ||
            isNaN(monthString) ||
            (parseInt(monthString) < 1 || parseInt(monthString) > 12))
    {
        $(month).focus();
        appendAlert(alertTarget, ALERT_INVALID_BIRTHDAY);
        return false;
    }

    if (yearString.length !== 4 || isNaN(yearString) ||
            isNaN(yearString) ||
            (parseInt(yearString) < 1920 || parseInt(yearString) > now.getFullYear()))
    {
        $(year).focus();
        appendAlert(alertTarget, ALERT_INVALID_BIRTHDAY);
        return false;
    }

    var currentPassword = $(form).find('#input-current-password');
    var newPassword = $(form).find('#input-new-password');
    var confirmNewPassword = $(form).find('#input-confirm-new-password');

    if ($(newPassword).val().trim() !== '' || $(confirmNewPassword).val().trim() !== '') {
        if ($(currentPassword).val().trim() === '' || $(confirmNewPassword).val().trim() === '' || $(newPassword).val().trim() === '') {
            appendAlert(alertTarget, ALERT_MISSING_FIELDS);
            return false;
        } else {
            // Check that the password is sufficiently long (min 6 chars)
            // The check is duplicated below, but this is included to give more
            // specific guidance to the user
            if ($(newPassword).val().length < 6) {
                $(newPassword).focus();
                appendAlert(alertTarget, ALERT_PASSWORD_SHORT);
                return false;
            }

            // At least one number, one lowercase and one uppercase letter 
            // At least six characters 
            var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
            if (!re.test($(newPassword).val())) {
                $(newPassword).focus();
                appendAlert(alertTarget, ALERT_PASSWORD_INVALID);
                return false;
            }

            // Check password and confirmation are the same
            if ($(newPassword).val() !== $(confirmNewPassword).val()) {
                $(confirmNewPassword).focus();
                appendAlert(alertTarget, ALERT_PASSWORDS_NOT_MATCHING);
                return false;
            }

            // Add the new element to our form. 
            if ($(form).find('#p').length > 0) {
                $(form).find('#p').val(hex_sha512($(newPassword).val()));
                $(form).find('#pO').val(hex_sha512($(currentPassword).val()));
            } else {
                var p = document.createElement("input");
                $(form).append(p);
                $(p).attr('id', 'p');
                $(p).attr('name', 'p');
                $(p).attr('type', 'hidden');
                $(p).val(hex_sha512($(newPassword).val()));

                var pO = document.createElement("input");
                $(form).append(pO);
                $(pO).attr('id', 'pO');
                $(pO).attr('name', 'pO');
                $(pO).attr('type', 'hidden');
                $(pO).val(hex_sha512($(currentPassword).val()));
            }

            // Make sure the plaintext password doesn't get sent. 
            $(newPassword).val('');
            $(confirmNewPassword).val('');
        }
    }

    // Finally submit the form. 
    form.submit();
}

function validateEmail(email) {
    var re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
    return re.test(email);
}

function disableInputs() {
    $('#btn-login, #btn-forgot, #btn-open-register, #btn-register').addClass('disabled');
}

function enableInputs() {
    $('#btn-login, #btn-forgot, #btn-open-register, #btn-register').removeClass('disabled');
}