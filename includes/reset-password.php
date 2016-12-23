<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_POST['email'], $_POST['p'], $_POST['hash'])) {

    // Serialisieren der Daten
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    $hash = filter_input(INPUT_POST, 'hash', FILTER_SANITIZE_STRING);


    if ($select_stmt = $mysqli->prepare("SELECT id, forename, surname, email, password_reset FROM users WHERE email = '$email' && password_reset = '$hash' LIMIT 1")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($id, $forename, $surname, $email, $resetPassword);
            $select_stmt->fetch();

            $str = hash('sha512', $id . $forename . $surname . $email);

//            if ($resetPassword === NULL) {
//                echo json_encode(array('status' => 'resetPasswordError', 'reset' => $resetPassword));
//                exit();
//            } else {
            if ($select_stmt->num_rows == 1 && strcmp($str, $hash) == 0) {
                if ($update_stmt = $mysqli->prepare("UPDATE users SET password = '$password', password_reset = NULL WHERE id = '$id'")) {
                    if (!$update_stmt->execute()) {
                        echo json_encode(array('status' => 'updateError'));
                        exit();
                    } else {
                        echo json_encode(array('status' => 'success'));
                        exit();
                    }
                } else {
                    echo json_encode(array('status' => 'statemantError'));
                    exit();
                }
            } else {
                echo json_encode(array('status' => 'resetPasswordError'));
                exit();
            }
//            }
        }
    } else {
        echo json_encode(array('status' => 'statemantError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}