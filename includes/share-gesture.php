<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id']) && isset($_POST['gestureId'])) {
    $gestureId = $_POST['gestureId'];
    $userId = $_SESSION['user_id'];

    if ($select_stmt = $mysqli->prepare("UPDATE gestures SET scope ='public' WHERE id = '$gestureId' && user_id = '$userId'")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'updateError'));
            exit();
        } else {
            echo json_encode(array('status' => 'success'));
        }
    } else {
        echo json_encode(array('status' => 'statemantError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
}