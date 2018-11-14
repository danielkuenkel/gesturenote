<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['setId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $commentSetId = $_POST['setId'];

    if ($select_stmt = $mysqli->prepare("SELECT comments_gesture_sets.*, users.forename, users.surname FROM comments_gesture_sets JOIN users ON comments_gesture_sets.set_id = '$commentSetId' AND comments_gesture_sets.user_id = users.id ORDER BY comments_gesture_sets.created ASC")) {
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
                $select_stmt->bind_result($id, $userId, $setId, $comment, $created, $forename, $surname);
                while ($select_stmt->fetch()) {
                    $comments[] = array('id' => $id,
                        'userId' => $userId,
                        'setId' => $setId,
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