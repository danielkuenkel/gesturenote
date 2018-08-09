<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['setId'], $_POST['commentId'])) {
    $commentGestureSetId = $_POST['setId'];
    $deleteCommentId = $_POST['commentId'];
    $sessionUserId = $_SESSION['user_id'];

    if ($delete_stmt = $mysqli->prepare("DELETE FROM comments_gesture_sets WHERE id = '$deleteCommentId' && user_id = '$sessionUserId' && set_id = '$commentGestureSetId'")) {
        if (!$delete_stmt->execute()) {
            echo json_encode(array('status' => 'deleteError'));
            exit();
        } else {
            if ($select_stmt = $mysqli->prepare("SELECT comments_gesture_sets.*, users.forename, users.surname FROM comments_gesture_sets JOIN users ON comments_gesture_sets.set_id = '$commentGestureSetId' AND comments_gesture_sets.user_id = users.id ORDER BY comments_gesture_sets.created ASC")) {
                $select_stmt->bind_result($id, $userId, $setId, $comment, $created, $forename, $surname);
                if (!$select_stmt->execute()) {
                    echo json_encode(array('status' => 'selectError'));
                    exit();
                } else {
                    $select_stmt->store_result();
                    if ($select_stmt->num_rows > 0) {
                        while ($select_stmt->fetch()) {
                            $comments[] = array('id' => $id,
                                'userId' => $userId,
                                'setId' => $setId,
                                'comment' => $comment,
                                'created' => $created,
                                'forename' => $forename,
                                'surname' => $surname,
                                'isOwner' => $sessionUserId == $userId);
                        }
                    } else {
                        $comments = null;
                    }

                    echo json_encode(array('status' => 'success', 'comments' => $comments));
                    exit();
                }
            } else {
                echo json_encode(array('status' => 'selectError'));
            }
        }
    } else {
        echo json_encode(array('status' => 'statemantError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
}