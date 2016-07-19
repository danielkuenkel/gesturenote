function loginFormhash(form, email, password) {
    if ($(email).val().trim() === '' || $(password).val().trim() === '') {
        showAlert($('#login'), ALERT_MISSING_FIELDS);
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
        showAlert($('#login'), ALERT_MISSING_FIELDS);
        return false;
    }

    form.submit();
}

function registerFormhash(form, usertype) {
    // Check each field has a value

    var forename = $(form).find('#forename');
    var surname = $(form).find('#surname');
    var email = $(form).find('#email');
    var password = $(form).find('#password');
    var passwordconfirm = $(form).find('#confirmPassword');
    var date = $(form).find('#date');
    var month = $(form).find('#month');
    var year = $(form).find('#year');

    if ($(forename).val().trim() === '' ||
            $(surname).val().trim() === '' ||
            $(email).val().trim() === '' ||
            $(password).val().trim() === '' ||
            $(passwordconfirm).val().trim() === '' ||
            $(date).val().trim() === '' ||
            $(month).val().trim() === '' ||
            $(year).val().trim() === '' ||
            usertype === undefined) {
        showAlert($('#modal-register'), ALERT_MISSING_FIELDS);
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
        showAlert($('#modal-register'), ALERT_INVALID_EMAIL);
        return false;
    }

    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if ($(password).val().length < 6) {
        $(password).focus();
        showAlert($('#modal-register'), ALERT_PASSWORD_SHORT);
        return false;
    }

    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 

    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
    if (!re.test($(password).val())) {
        $(password).focus();
        showAlert($('#modal-register'), ALERT_PASSWORD_INVALID);
        return false;
    }

    // Check password and confirmation are the same
    if ($(password).val() !== $(passwordconfirm).val()) {
        $(passwordconfirm).focus();
        showAlert($('#modal-register'), ALERT_PASSWORDS_NOT_MATCHING);
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
        showAlert($('#modal-register'), ALERT_INVALID_BIRTHDAY);
        return false;
    }

    if ((monthString.length < 1 || monthString.length > 2) ||
            isNaN(monthString) ||
            (parseInt(monthString) < 1 || parseInt(monthString) > 12))
    {
        $(month).focus();
        showAlert($('#modal-register'), ALERT_INVALID_BIRTHDAY);
        return false;
    }

    if (yearString.length !== 4 || isNaN(yearString) ||
            isNaN(yearString) ||
            (parseInt(yearString) < 1920 || parseInt(yearString) > now.getFullYear()))
    {
        $(year).focus();
        showAlert($('#modal-register'), ALERT_INVALID_BIRTHDAY);
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
        $(p).val(hex_sha512($(password).val()));
    }

    // Make sure the plaintext password doesn't get sent. 
    $(password).val('');
    $(passwordconfirm).val('');

    // Finally submit the form. 
    form.submit();
}

function validateEmail(email) {
    var re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
    return re.test(email);
}