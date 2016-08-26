<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

if (isset($_POST['forename'], $_POST['surname'], $_POST['email'], $_POST['p'], $_POST['birthday'], $_POST['gender'], $_POST['userType'])) {

    // Sanitize and validate the data passed in
    $forename = filter_input(INPUT_POST, 'forename', FILTER_SANITIZE_STRING);
    $surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    $birthday = strtotime($_POST['birthday']);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    $userType = filter_input(INPUT_POST, 'userType', FILTER_SANITIZE_STRING);

//    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
//    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//        // Not a valid email
//        $error_msg .= '<p class="error">The email address you entered is not valid. ' . $email . '</p>';
//    }
//    echo '<p class="error">This is the email: ' . $email . "</p>";
//    exit(0);
//    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
//    if (strlen($password) != 128) {
//        // The hashed pwd should be 128 characters long.
//        // If it's not, something really odd has happened
//        $error_msg .= '<p class="error">Invalid password configuration.</p>';
//    }
    // Username validity and password validity have been checked client side.
    // This should be adequate as nobody gains any advantage from
    // breaking these rules.
    //
    
//    $query = mysqli_query($mysqli, "SELECT * FROM users WHERE email='" . $email . "'");
//
//    if (mysqli_num_rows($query) > 0) {
//        $error_msg .= '<p class="error">That email is already registered.</p>';
//        $query->close();
//    } 
//    else {
//        // do something
//        if (!mysqli_query($con, $query)) {
//            die('Error: ' . mysqli_error($con));
//        }
//    }

    $prep_stmt = "SELECT id FROM users WHERE email = ? LIMIT 1";
    if ($stmt = $mysqli->prepare($prep_stmt)) {
        $stmt->bind_param('s', $email);

        if ($stmt->execute()) {
            $stmt->store_result();
            $email_check = "";
            $stmt->bind_result($email_check);
            $stmt->fetch();

            if ($stmt->num_rows == 1) {
                // A user with this email address already exists
//                $error_msg .= '<p class="error">That email is already registered.</p>';
//                $stmt->close();
                echo json_encode(array('status' => 'emailExists'));
                exit();
            }
        }
    } else {
//        $error_msg .= '<p class="error">Database error Line 39</p>';
//        $stmt->close();
        echo json_encode(array('status' => 'error'));
        exit();
    }


//    $query = "SELECT `email` FROM `tblUser` WHERE email=?";
//
//    if ($stmt = $dbl->prepare($query)) {
//
//        $stmt->bind_param("s", $email);
//
//        if ($stmt->execute()) {
//            $stmt->store_result();
//
//            $email_check = "";
//            $stmt->bind_result($email_check);
//            $stmt->fetch();
//
//            if ($stmt->num_rows == 1) {
//
//                echo "That Email already exists.";
//                exit;
//            }
//        }
//    }
    // check existing username
//    $prep_stmt = "SELECT id FROM user WHERE forename = ? LIMIT 1";
//    $stmt = $mysqli->prepare($prep_stmt);
// 
//    if ($stmt) {
//        $stmt->bind_param('s', $username);
//        $stmt->execute();
//        $stmt->store_result();
// 
//                if ($stmt->num_rows == 1) {
//                        // A user with this username already exists
//                        $error_msg .= '<p class="error">A user with this forename already exists</p>';
//                        $stmt->close();
//                }
//        } else {
//                $error_msg .= '<p class="error">Database error line 55</p>';
//                $stmt->close();
//        }
    // TODO: 
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.
//    if (empty($error_msg)) {
    // Create hashed password using the password_hash function.
    // This function salts it with a random salt and can be verified with
    // the password_verify function.
//    $password = password_hash($password, PASSWORD_BCRYPT);
    // Insert the new user into the database 
    if ($insert_stmt = $mysqli->prepare("INSERT INTO users (forename, surname, email, password, birthday, gender, usertype) VALUES ('$forename', '$surname', '$email', '$password', '$birthday', '$gender', '$userType')")) {
//    if ($insert_stmt = $mysqli->prepare("INSERT INTO users (forename, surname, email, password, usertype) VALUES (?, ?, ?, ?, ?)")) {
//        $insert_stmt->bind_param('sssss', $forename, $surname, $email, $password, $userType);
        // Execute the prepared query.
        if (!$insert_stmt->execute()) {
            echo json_encode(array('status' => 'insertError'));
            exit();
//                header('Location: ../error.php?err=Registration failure: INSERT');
        }
    }

    echo json_encode(array('status' => 'success'));

//    exit();
//        header('Location: ./register_success.php');
//    }
}    