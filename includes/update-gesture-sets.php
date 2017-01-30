<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['sets'])) {
    $sessionUserId = $_SESSION['user_id'];
    $updateSets = $_POST['sets'];

    foreach ($updateSets as $set) {
        $gestures = json_encode($set["gestures"]);
        $updateId = $set["id"];

        $update_stmt = $mysqli->prepare("UPDATE gesture_sets SET gestures = '$gestures' WHERE id = '$updateId' && user_id = '$sessionUserId'");
        if (!is_array($set["gestures"])) {
            $update_stmt = $mysqli->prepare("UPDATE gesture_sets SET gestures = NULL WHERE id = '$updateId' && user_id = '$sessionUserId'");
        }

        if ($update_stmt) {
            if (!$update_stmt->execute()) {
                echo json_encode(array('status' => 'updateError'));
                exit();
            }
        } else {
            echo json_encode(array('status' => 'statemantError'));
            exit();
        }
    }

    echo json_encode(array('status' => 'success'));
    exit();
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}