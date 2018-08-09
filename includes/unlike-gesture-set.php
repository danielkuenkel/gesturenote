<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id']) && isset($_POST['setId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $likeId = $_POST['setId'];
    
    if ($delete_stmt = $mysqli->prepare("DELETE FROM likes_sets WHERE set_id = '$likeId' && user_id = '$sessionUserId'")) {
        if (!$delete_stmt->execute()) {
            echo json_encode(array('status' => 'deleteError'));
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