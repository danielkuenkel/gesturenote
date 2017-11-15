<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['gestureId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $currentGestureId = $_POST['gestureId'];


    if ($select_stmt = $mysqli->prepare("SELECT * FROM gesture_ratings WHERE gesture_id = '$currentGestureId' ORDER BY submitted ASC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectRatingsError'));
            exit();
        } else {
            $gestureRatings = null;
            $hasRated = false;
            $select_stmt->store_result();
            $num_rows_ratings = $select_stmt->num_rows;

            if ($num_rows_ratings > 0) {
                $select_stmt->bind_result($id, $userId, $gestureId, $ratings, $submitted);
                while ($select_stmt->fetch()) {
                    if ($sessionUserId == $userId) {
                        $hasRated = true;
                    }
                    $gestureRatings[] = array('id' => $id,
                        'userId' => $userId,
                        'gestureId' => $gestureId,
                        'ratings' => json_decode($ratings),
                        'submitted' => $submitted);
                }
            }

            echo json_encode(array('status' => 'success', 'hasRated' => $hasRated, 'ratings' => $gestureRatings));
            exit();
        }
    } else {
        echo json_encode(array('status' => 'statemantRatingsError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}