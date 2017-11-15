<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['gestureId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $currentGestureId = $_POST['gestureId'];


    if ($select_stmt = $mysqli->prepare("SELECT * FROM likes WHERE gesture_id = '$currentGestureId'")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $hasLiked = false;
            $likesCount = 0;
            $select_stmt->bind_result($id, $userId, $gestureId);

            while ($select_stmt->fetch()) {
                if ($sessionUserId == $userId) {
                    $hasLiked = true;
                }
                $likesCount++;
            }

            echo json_encode(array('status' => 'success', 'hasLiked' => $hasLiked, 'likeAmount' => $likesCount));
            exit();
        }
    } else {
        echo json_encode(array('status' => 'statementError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}