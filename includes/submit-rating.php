<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['gestureId'], $_POST['ratings'])) {
    $sessionUserId = $_SESSION['user_id'];
    $ratingGestureId = $_POST['gestureId'];
    $submitRatings = json_encode($_POST['ratings']);

    if ($insert_stmt = $mysqli->prepare("INSERT INTO gesture_ratings (user_id, gesture_id, ratings) VALUES ('$sessionUserId','$ratingGestureId','$submitRatings')")) {
        if (!$insert_stmt->execute()) {
            echo json_encode(array('status' => 'insertError'));
            exit();
        } else {
            if ($select_stmt = $mysqli->prepare("SELECT * FROM gesture_ratings WHERE gesture_id = '$ratingGestureId' ORDER BY submitted ASC")) {
                if (!$select_stmt->execute()) {
                    echo json_encode(array('status' => 'selectError'));
                    exit();
                } else {
                    $select_stmt->store_result();
                    $select_stmt->bind_result($id, $userId, $gestureId, $ratings, $submitted);
                    
                    while ($select_stmt->fetch()) {
                        $gestureRatings[] = array('id' => $id,
                            'userId' => $userId,
                            'gestureId' => $gestureId,
                            'ratings' => json_decode($ratings),
                            'submitted' => $submitted);
                    }

                    echo json_encode(array('status' => 'success', 'ratings' => $gestureRatings));
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