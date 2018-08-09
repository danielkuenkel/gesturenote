<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id']) && isset($_POST['setId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $likeId = $_POST['setId'];

    if ($insert_stmt = $mysqli->prepare("INSERT INTO likes_sets (user_id, set_id) VALUES ('$sessionUserId', '$likeId')")) {
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