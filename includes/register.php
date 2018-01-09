<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

if (isset($_POST['forename'], $_POST['surname'], $_POST['email'], $_POST['p'])) {
    // Sanitize and validate the data passed in
    $forename = filter_input(INPUT_POST, 'forename', FILTER_SANITIZE_STRING);
    $surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
//    $userType = filter_input(INPUT_POST, 'userType', FILTER_SANITIZE_STRING);

//    if ($userType === 'tester') {
//        if (isset($_POST['birthday'], $_POST['gender'])) {
//            $birthday = strtotime($_POST['birthday']);
//            $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
//        } else {
//            echo json_encode(array('status' => 'error'));
//            exit();
//        }
//    } else {
//        $birthday = null;
//        $gender = null;
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
                echo json_encode(array('status' => 'emailExists'));
                exit();
            }
        }
    } else {
        echo json_encode(array('status' => 'error'));
        exit();
    }

    if ($insert_stmt = $mysqli->prepare("INSERT INTO users (forename, surname, email, password) VALUES ('$forename', '$surname', '$email', '$password')")) {
        if (!$insert_stmt->execute()) {
            echo json_encode(array('status' => 'insertError'));
            exit();
        } else {
            session_start();
            echo login($email, $password, $mysqli);
            exit();
        }
    } else {
        echo json_encode(array('status' => 'statementError'));
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}