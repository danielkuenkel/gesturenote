<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'functions.php';
include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'])) {
    $sessionUserId = $_SESSION['user_id'];

    if ($select_stmt = $mysqli->prepare("SELECT * FROM gesture_set_simulation WHERE user_id = '$sessionUserId' ORDER BY created ASC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();

            $select_stmt->bind_result($id, $gestureSetId, $userId, $title, $data, $created);
            while ($select_stmt->fetch()) {
                $recordings[] = array('id' => $id,
                    'gestureSetId' => $gestureSetId,
                    'title' => json_decode_nice($title, false),
                    'data' => json_decode_nice($data, false),
                    'created' => $created);
            }
            echo json_encode(array('status' => 'success', 'recordings' => $recordings));
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