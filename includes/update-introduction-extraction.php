<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['dontShowIntroduction'])) {

    // Serialisieren der Daten
    $sessionUserId = $_SESSION['user_id'];
    $dontShowIntroduction = filter_input(INPUT_POST, 'dontShowIntroduction', FILTER_SANITIZE_STRING);

    if ($select_stmt = $mysqli->prepare("SELECT tutorial_extraction FROM users WHERE id = '$sessionUserId' LIMIT 1")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->fetch();

            if ($select_stmt->num_rows == 1) {
                if ($update_stmt = $mysqli->prepare("UPDATE users SET tutorial_extraction = '$dontShowIntroduction' WHERE id = '$sessionUserId'")) {
                    if (!$update_stmt->execute()) {
                        echo json_encode(array('status' => 'updateError'));
                        exit();
                    } else {
                        $_SESSION['tutorialExtraction'] = $dontShowIntroduction;
                        echo json_encode(array('status' => 'success'));
                        exit();
                    }
                } else {
                    echo json_encode(array('status' => 'statemantError'));
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
    echo json_encode(array('status' => 'error'));
    exit();
}