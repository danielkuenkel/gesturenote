<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'functions.php';
include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['recordingId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $recordingId = $_POST['recordingId'];

    if ($select_stmt = $mysqli->prepare("SELECT * FROM gesture_set_simulation WHERE user_id = '$sessionUserId' AND id = '$recordingId'")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($id, $gestureSetId, $userId, $title, $data, $created);
            $select_stmt->fetch();
            
            echo json_encode(array('status' => 'success', 'id' => $id, 'gestureSetId' => $gestureSetId, 'userId' => $userId, 'title' => json_decode_nice($title, false), 'data' => json_decode_nice($data, false), 'created' => $created));
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