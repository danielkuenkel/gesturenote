<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['gestureId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $commentGestureId = $_POST['gestureId'];

    if ($select_stmt = $mysqli->prepare("SELECT comments.*, users.forename, users.surname FROM comments JOIN users ON comments.gesture_id = '$commentGestureId' AND comments.user_id = users.id ORDER BY comments.created ASC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $num_rows = $select_stmt->num_rows;
            if ($num_rows === 0) {
                echo json_encode(array('status' => 'success', 'comments' => null));
                exit();
            } else {
                $select_stmt->bind_result($id, $userId, $gestureId, $comment, $created, $forename, $surname);
                while ($select_stmt->fetch()) {
                    $comments[] = array('id' => $id,
                        'userId' => $userId,
                        'gestureId' => $gestureId,
                        'comment' => $comment,
                        'created' => $created,
                        'forename' => $forename,
                        'surname' => $surname[0] . '.',
                        'isOwner' => $sessionUserId == $userId);
                }
                echo json_encode(array('status' => 'success', 'comments' => $comments));
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