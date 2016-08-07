<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

$target_dir = "../";

session_start();
if (isset($_SESSION['user_id']) && isset($_POST['gestureId'])) {
    $gestureId = $_POST['gestureId'];
    $userId = $_SESSION['user_id'];

    if ($select_stmt = $mysqli->prepare("SELECT `images` FROM gestures WHERE id = '$gestureId' && user_id = '$userId'")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($imageURLs);
            $select_stmt->fetch();

            if ($select_stmt->num_rows == 1) {
                deleteImages($target_dir, json_decode($imageURLs));

                if ($delete_stmt = $mysqli->prepare("DELETE FROM gestures WHERE id = ?")) {
                    $delete_stmt->bind_param('i', $gestureId);
                    if (!$delete_stmt->execute()) {
                        echo json_encode(array('status' => 'deleteError'));
                        exit();
                    } else {
                        echo json_encode(array('status' => 'success'));
                        exit();
                    }
                } else {
                    echo json_encode(array('status' => 'deleteStatemantError'));
                    exit();
                }
            } else {
                echo json_encode(array('status' => 'fetchError'));
            }
        }
    } else {
        echo json_encode(array('status' => 'statemantError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
}

function deleteImages($targetUrl, $images) {
    foreach ($images as $url) {
        unlink($targetUrl . $url);
    }
}
