function formhash(form, password) {
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
 
    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
 
    // Finally submit the form. 
    form.submit();
}
 
function regformhash(form, forename, surename, email, password, passwordconfirm, usertype) {
     // Check each field has a value
            if ($(forename).val() == ''     || 
          $(surename).val() == ''           || 
          $(email).val() == ''              || 
          $(password).val() == ''           || 
          $(passwordconfirm).val() == ''    ||
          usertype == null) {
 
        alert('You must provide all the requested details. Please try again');
        return false;
    }
 
    // Check the forename
 
//    re = "([a-zA-Z]{3,30}\s*)+"; 
//    if(!re.test($(forename).val())) { 
//        alert("Username must contain only letters, numbers and underscores. Please try again"); 
//        $(forename).focus();
//        return false; 
//    }
 
    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if ($(password).val().length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        $(password).focus();
        return false;
    }
 
    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test($(password).val())) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }
 
    // Check password and confirmation are the same
    if ($(password).val() !== $(passwordconfirm).val()) {
        alert('Your password and confirmation do not match. Please try again');
        (password).focus();
        return false;
    }
 
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
 
    // Add the new element to our form. 
    $(form).append(p);
    p.setAttribute('name', 'p');
    p.setAttribute('type', 'hidden');
    p.setAttribute('value', hex_sha512($(password).val()));
 
    // Make sure the plaintext password doesn't get sent. 
    $(password).val("");
    $(passwordconfirm).val("");
    
//    var usertype = document.createElement("input");
//    $(form).append(usertype);
//    usertype.setAttribute('name', 'usertype');
//    usertype.setAttribute('type', 'hidden');
//    usertype.setAttribute('value', usertype);
    
    // Finally submit the form. 
    form.submit();
    return true;
}