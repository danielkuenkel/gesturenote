<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['gestureId'], $_POST['comment'])) {

    $sessionUserId = $_SESSION['user_id'];
    $commentGestureId = $_POST['gestureId'];
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

    if ($insert_stmt = $mysqli->prepare("INSERT INTO comments (user_id, gesture_id, comment) VALUES ('$sessionUserId','$commentGestureId','$comment')")) {
        if (!$insert_stmt->execute()) {
            echo json_encode(array('status' => 'insertError'));
            exit();
        } else {
            if ($select_stmt = $mysqli->prepare("SELECT comments.*, users.forename, users.surname FROM comments JOIN users ON comments.gesture_id = '$commentGestureId' AND comments.user_id = users.id ORDER BY comments.created ASC")) {
                $select_stmt->bind_result($id, $userId, $gestureId, $comment, $created, $forename, $surname);
                if (!$select_stmt->execute()) {
                    echo json_encode(array('status' => 'selectError'));
                    exit();
                } else {
                    while ($select_stmt->fetch()) {
                        $comments[] = array('id' => $id,
                            'userId' => $userId,
                            'gestureId' => $gestureId,
                            'comment' => $comment,
                            'created' => $created,
                            'forename' => $forename,
                            'surname' => $surname,
                            'isOwner' => $sessionUserId == $userId);
                    }
                    echo json_encode(array('status' => 'success', 'comments' => $comments));
                    exit();
                }
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