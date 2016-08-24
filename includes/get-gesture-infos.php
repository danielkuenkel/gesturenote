<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['gestureId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $currentGestureId = $_POST['gestureId'];
    $comments = null;
    $gestureRatings = null;

    if ($select_stmt = $mysqli->prepare("SELECT comments.*, users.forename, users.surname FROM comments JOIN users ON comments.gesture_id = '$currentGestureId' AND comments.user_id = users.id ORDER BY comments.created ASC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectCommentsError'));
            exit();
        } else {
            $select_stmt->store_result();
            $num_rows_comments = $select_stmt->num_rows;
            if ($num_rows_comments > 0) {

                $select_stmt->bind_result($id, $userId, $gestureId, $comment, $created, $forename, $surname);
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
            }
        }
    } else {
        echo json_encode(array('status' => 'statemantCommentsError'));
        exit();
    }

    if ($select_stmt = $mysqli->prepare("SELECT * FROM gesture_ratings WHERE gesture_id = '$currentGestureId' ORDER BY submitted ASC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectRatingsError'));
            exit();
        } else {
            $select_stmt->store_result();
            $num_rows_ratings = $select_stmt->num_rows;
            if ($num_rows_ratings > 0) {

                $select_stmt->bind_result($id, $userId, $gestureId, $ratings, $submitted);
                while ($select_stmt->fetch()) {
                    $gestureRatings[] = array('id' => $id,
                        'userId' => $userId,
                        'gestureId' => $gestureId,
                        'ratings' => json_decode($ratings),
                        'submitted' => $submitted);
                }
            }
        }
    } else {
        echo json_encode(array('status' => 'statemantRatingsError'));
        exit();
    }


    if ($comments && $gestureRatings) {
        echo json_encode(array('status' => 'success', 'userId' => $sessionUserId, 'comments' => $comments, 'ratings' => $gestureRatings));
        exit();
    } else if ($comments && $num_rows_ratings === 0) {
        echo json_encode(array('status' => 'success', 'userId' => $sessionUserId, 'comments' => $comments, 'ratings' => null));
        exit();
    } else if ($num_rows_comments === 0 && $gestureRatings) {
        echo json_encode(array('status' => 'success', 'userId' => $sessionUserId, 'comments' => null, 'ratings' => $gestureRatings));
        exit();
    } else {
        echo json_encode(array('status' => 'success', 'userId' => $sessionUserId, 'comments' => null, 'ratings' => null));
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}