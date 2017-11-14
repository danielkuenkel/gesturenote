<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id']) && isset($_POST['gestureId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $likeId = $_POST['gestureId'];

    if ($insert_stmt = $mysqli->prepare("INSERT INTO likes (user_id, gesture_id) VALUES ('$sessionUserId', '$likeId')")) {
        if (!$insert_stmt->execute()) {
            echo json_encode(array('status' => 'insertError'));
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
    echo json_encode(array('status' => 'error'));
}