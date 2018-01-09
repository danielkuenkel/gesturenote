<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['forename'], $_POST['surname'])) {

    // Serialisieren der Daten
    $sessionUserId = $_SESSION['user_id'];
    $forename = filter_input(INPUT_POST, 'forename', FILTER_SANITIZE_STRING);
    $surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
//    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

//    $birthday = strtotime($_POST['birthday']);
//    if($birthday !== 0) {
//        $birthday = strtotime($_POST['birthday']);
//    } else {
//        $birthday = NULL;
//    }
    
//    $birthday = date("Y.m.d", mktime(0, 0, 0, $_POST['month'], $_POST['date'], $_POST['year']));

    if (isset($_POST['p'], $_POST['pO'])) {
        $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
        $currentPassword = filter_input(INPUT_POST, 'pO', FILTER_SANITIZE_STRING);

        if ($select_stmt = $mysqli->prepare("SELECT password FROM users WHERE id = '$sessionUserId' LIMIT 1")) {
            if (!$select_stmt->execute()) {
                echo json_encode(array('status' => 'selectError'));
                exit();
            } else {
                $select_stmt->store_result();
                $select_stmt->bind_result($dbPassword);
                $select_stmt->fetch();

                if ($select_stmt->num_rows == 1) {
                    if (strcmp($currentPassword, $dbPassword) == 0) {
                        if ($update_stmt = $mysqli->prepare("UPDATE users SET forename = '$forename', surname = '$surname', password = '$password' WHERE id = '$sessionUserId'")) {
                            if (!$update_stmt->execute()) {
                                echo json_encode(array('status' => 'updateError'));
                                exit();
                            } else {
                                $user_browser = $_SERVER['HTTP_USER_AGENT'];
                                $_SESSION['forename'] = $forename;
                                $_SESSION['surname'] = $surname;
                                $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                                echo json_encode(array('status' => 'success'));
                                exit();
                            }
                        } else {
                            echo json_encode(array('status' => 'statemantError'));
                            exit();
                        }
                    } else {
                        echo json_encode(array('status' => 'wrongCurrentPassword'));
                        exit();
                    }
                } else {
                    echo json_encode(array('status' => 'error'));
                    exit();
                }
            }
        } else {
            echo json_encode(array('status' => 'statemantError'));
            exit();
        }
    } else {
        if ($update_stmt = $mysqli->prepare("UPDATE users SET forename = '$forename', surname = '$surname' WHERE id = '$sessionUserId'")) {
            if (!$update_stmt->execute()) {
                echo json_encode(array('status' => 'updateError'));
                exit();
            } else {
                $_SESSION['forename'] = $forename;
                $_SESSION['surname'] = $surname;
                echo json_encode(array('status' => 'success'));
                exit();
            }
        } else {
            echo json_encode(array('status' => 'statemantError'));
            exit();
        }
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}