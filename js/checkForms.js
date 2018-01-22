function loginFormhash(form, email, password) {
    clearAlerts(form);
    if ($(email).val().trim() === '' || $(password).val().trim() === '') {
        appendAlert($('#login'), ALERT_MISSING_FIELDS);
        return false;
    }

    // Add the new element to our form. 
    var passwordString = password.val() + '-' + $(email).val();
    console.log(passwordString);
    
    if ($(form).find('#p').length > 0) {
        $(form).find('#p').val(hex_sha512(passwordString));
    } else {
        var p = document.createElement("input");
        $(form).append(p);
        $(p).attr('id', 'p');
        $(p).attr('name', 'p');
        $(p).attr('type', 'hidden');
        $(p).val(hex_sha512(passwordString));
    }

    // Make sure the plaintext password doesn't get sent. 
    password.val("");

    // Finally submit the form. 
    form.submit();
}

function forgotFormhash(form, email) {
    clearAlerts(form);
    if ($(email).val().trim() === '') {
        appendAlert(form, ALERT_MISSING_EMAIL);
        $(email).focus();
        return false;
    }

    // validate email
    if (!validateEmail($(email).val().trim())) {
        $(email).focus();
        return false;
    }

    form.submit();
}

function registerFormhash(form) {
    clearAlerts(form);
    // Check each field has a value

    var forename = $(form).find('#forename');
    var surname = $(form).find('#surname');
    var email = $(form).find('#email');
    var password = $(form).find('#password');
    var passwordconfirm = $(form).find('#confirmPassword');
//    var userType = $(form).find('#userType .btn-option-checked').attr('id');
//    var gender = $(form).find('#gender .btn-option-checked').attr('id');
//    var date = $(form).find('#date');
//    var month = $(form).find('#month');
//    var year = $(form).find('#year');

    if ($(forename).val().trim() === '' ||
            $(surname).val().trim() === '' ||
            $(email).val().trim() === '' ||
            $(password).val().trim() === '' ||
            $(passwordconfirm).val().trim() === '')
    {
        appendAlert(form, ALERT_MISSING_FIELDS);
        return false;
    }

    // validate email
    if (!validateEmail($(email).val().trim())) {
        $(email).focus();
        appendAlert(form, ALERT_INVALID_EMAIL);
        return false;
    }

    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if ($(password).val().length < 6) {
        $(password).focus();
        appendAlert(form, ALERT_PASSWORD_SHORT);
        return false;
    }

    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 

    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
    if (!re.test($(password).val())) {
        $(password).focus();
        appendAlert(form, ALERT_PASSWORD_INVALID);
        return false;
    }

    // Check password and confirmation are the same
    if ($(password).val() !== $(passwordconfirm).val()) {
        $(passwordconfirm).focus();
        appendAlert(form, ALERT_PASSWORDS_NOT_MATCHING);
        return false;
    }

//    if (userType === 'tester') {
//        var dateString = $(date).val().trim();
//        var monthString = $(month).val().trim();
//        var yearString = $(year).val().trim();
//        var now = new Date();
//
//        // check birthday input fields
//        if ((dateString.length < 1 || dateString.length > 2) ||
//                isNaN(dateString) ||
//                (parseInt(dateString) < 1 || parseInt(dateString) > 31))
//        {
//            $(date).focus();
//            appendAlert(form, ALERT_INVALID_BIRTHDAY);
//            return false;
//        }
//
//        if ((monthString.length < 1 || monthString.length > 2) ||
//                isNaN(monthString) ||
//                (parseInt(monthString) < 1 || parseInt(monthString) > 12))
//        {
//            $(month).focus();
//            appendAlert(form, ALERT_INVALID_BIRTHDAY);
//            return false;
//        }
//
//        if (yearString.length !== 4 || isNaN(yearString) ||
//                isNaN(yearString) ||
//                (parseInt(yearString) < 1920 || parseInt(yearString) > now.getFullYear()))
//        {
//            $(year).focus();
//            appendAlert(form, ALERT_INVALID_BIRTHDAY);
//            return false;
//        }
//    }

    // Add the new element to our form. 
    var passwordString = password.val() + '-' + $(email).val();
    if ($(form).find('#p').length > 0) {
        $(form).find('#p').val(hex_sha512(passwordString));
    } else {
        var p = document.createElement("input");
        $(form).append(p);
        $(p).attr('id', 'p');
        $(p).attr('name', 'p');
        $(p).attr('type', 'hidden');
        $(p).val(hex_sha512(passwordString));
    }

    // Make sure the plaintext password doesn't get sent. 
    $(password).val('');
    $(passwordconfirm).val('');

    // Finally submit the form. 
    form.submit();
}

function resetPasswordFormhash(form) {
    // Check each field has a value

    var email = $(form).find('#email');
    var password = $(form).find('#password');
    var passwordconfirm = $(form).find('#confirmPassword');


    if ($(email).val().trim() === '' ||
            $(password).val().trim() === '' ||
            $(passwordconfirm).val().trim() === '') {
        appendAlert(form, ALERT_MISSING_FIELDS);
        return false;
    }

    // validate email
    if (!validateEmail($(email).val().trim())) {
        $(email).focus();
        appendAlert(form, ALERT_INVALID_EMAIL);
        return false;
    }

    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if ($(password).val().length < 6) {
        $(password).focus();
        appendAlert(form, ALERT_PASSWORD_SHORT);
        return false;
    }

    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
    if (!re.test($(password).val())) {
        $(password).focus();
        appendAlert(form, ALERT_PASSWORD_INVALID);
        return false;
    }

    // Check password and confirmation are the same
    if ($(password).val() !== $(passwordconfirm).val()) {
        $(passwordconfirm).focus();
        appendAlert(form, ALERT_PASSWORDS_NOT_MATCHING);
        return false;
    }

    // Add the new element to our form. 
    var passwordString = password.val() + '-' + $(email).val();
    if ($(form).find('#p').length > 0) {
        $(form).find('#p').val(hex_sha512(passwordString));
    } else {
        var p = document.createElement("input");
        $(form).append(p);
        $(p).attr('id', 'p');
        $(p).attr('name', 'p');
        $(p).attr('type', 'hidden');
        $(p).val(hex_sha512(passwordString));
    }

    // Make sure the plaintext password doesn't get sent. 
    $(password).val('');
    $(passwordconfirm).val('');

    // Finally submit the form. 
    form.submit();
}

function updateFormhashEvaluator(form) {
    // Check each field has a value

    var forename = $(form).find('#input-forename');
    var surname = $(form).find('#input-surname');

    if ($(forename).val().trim() === '' ||
            $(surname).val().trim() === '') {
        appendAlert(form, ALERT_MISSING_FIELDS);
        return false;
    }

    var currentPassword = $(form).find('#input-current-password');
    var newPassword = $(form).find('#input-new-password');
    var confirmNewPassword = $(form).find('#input-confirm-new-password');

    if ($(newPassword).val().trim() !== '' || $(confirmNewPassword).val().trim() !== '') {
        if ($(currentPassword).val().trim() === '' || $(confirmNewPassword).val().trim() === '' || $(newPassword).val().trim() === '') {
            appendAlert(form, ALERT_MISSING_FIELDS);
            return false;
        } else {
            // Check that the password is sufficiently long (min 6 chars)
            // The check is duplicated below, but this is included to give more
            // specific guidance to the user
            if ($(newPassword).val().length < 6) {
                $(newPassword).focus();
                appendAlert(form, ALERT_PASSWORD_SHORT);
                return false;
            }

            // At least one number, one lowercase and one uppercase letter 
            // At least six characters 
            var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
            if (!re.test($(newPassword).val())) {
                $(newPassword).focus();
                appendAlert(form, ALERT_PASSWORD_INVALID);
                return false;
            }

            // Check password and confirmation are the same
            if ($(newPassword).val() !== $(confirmNewPassword).val()) {
                $(confirmNewPassword).focus();
                appendAlert(form, ALERT_PASSWORDS_NOT_MATCHING);
                return false;
            }

            // Add the new element to our form. 
            var user = getLocalItem(USER);
            var passwordStringNew = $(newPassword).val() + '-' + user.email;
            var passwordStringCurrent = $(currentPassword).val() + '-' + user.email;
            console.log(user.email, hex_sha512($(currentPassword).val() + user.email));
            if ($(form).find('#p').length > 0) {
                $(form).find('#p').val(hex_sha512(passwordStringNew));
                $(form).find('#pO').val(hex_sha512(passwordStringCurrent));
            } else {
                var p = document.createElement("input");
                $(form).append(p);
                $(p).attr('id', 'p');
                $(p).attr('name', 'p');
                $(p).attr('type', 'hidden');
                $(p).val(hex_sha512(passwordStringNew));

                var pO = document.createElement("input");
                $(form).append(pO);
                $(pO).attr('id', 'pO');
                $(pO).attr('name', 'pO');
                $(pO).attr('type', 'hidden');
                $(pO).val(hex_sha512(passwordStringCurrent));
            }

            // Make sure the plaintext password doesn't get sent. 
            $(newPassword).val('');
            $(confirmNewPassword).val('');
        }
    }

    // Finally submit the form. 
    form.submit();
}

function updateFormhash(form) {
    // Check each field has a value

    var forename = $(form).find('#input-forename');
    var surname = $(form).find('#input-surname');
    var date = $(form).find('#input-date');
    var month = $(form).find('#input-month');
    var year = $(form).find('#input-year');

    if ($(forename).val().trim() === '' ||
            $(surname).val().trim() === '' ||
            $(date).val().trim() === '' ||
            $(month).val().trim() === '' ||
            $(year).val().trim() === '') {
        appendAlert(form, ALERT_MISSING_FIELDS);
        return false;
    }

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
        return false;
    }

    var currentPassword = $(form).find('#input-current-password');
    var newPassword = $(form).find('#input-new-password');
    var confirmNewPassword = $(form).find('#input-confirm-new-password');

    if ($(newPassword).val().trim() !== '' || $(confirmNewPassword).val().trim() !== '') {
        if ($(currentPassword).val().trim() === '' || $(confirmNewPassword).val().trim() === '' || $(newPassword).val().trim() === '') {
            appendAlert(form, ALERT_MISSING_FIELDS);
            return false;
        } else {
            // Check that the password is sufficiently long (min 6 chars)
            // The check is duplicated below, but this is included to give more
            // specific guidance to the user
            if ($(newPassword).val().length < 6) {
                $(newPassword).focus();
                appendAlert(form, ALERT_PASSWORD_SHORT);
                return false;
            }

            // At least one number, one lowercase and one uppercase letter 
            // At least six characters 
            var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
            if (!re.test($(newPassword).val())) {
                $(newPassword).focus();
                appendAlert(form, ALERT_PASSWORD_INVALID);
                return false;
            }

            // Check password and confirmation are the same
            if ($(newPassword).val() !== $(confirmNewPassword).val()) {
                $(confirmNewPassword).focus();
                appendAlert(form, ALERT_PASSWORDS_NOT_MATCHING);
                return false;
            }

            // Add the new element to our form. 
            var user = getLocalItem(USER);
            var passwordStringNew = $(newPassword).val() + '-' + user.email;
            var passwordStringCurrent = $(currentPassword).val() + '-' + user.email;
            if ($(form).find('#p').length > 0) {
                $(form).find('#p').val(hex_sha512(passwordStringNew));
                $(form).find('#pO').val(hex_sha512(passwordStringCurrent));
            } else {
                var p = document.createElement("input");
                $(form).append(p);
                $(p).attr('id', 'p');
                $(p).attr('name', 'p');
                $(p).attr('type', 'hidden');
                $(p).val(hex_sha512(passwordStringNew));

                var pO = document.createElement("input");
                $(form).append(pO);
                $(pO).attr('id', 'pO');
                $(pO).attr('name', 'pO');
                $(pO).attr('type', 'hidden');
                $(pO).val(hex_sha512(passwordStringCurrent));
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