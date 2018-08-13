<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

$target_dir = "../";

session_start();
if (isset($_SESSION['user_id']) && isset($_POST['setId'])) {
    $setId = $_POST['setId'];
    $userId = $_SESSION['user_id'];

    if ($delete_stmt = $mysqli->prepare("DELETE FROM gesture_sets WHERE id = '$setId'")) {
        if (!$delete_stmt->execute()) {
            echo json_encode(array('status' => 'deleteError'));
            exit();
        } else {
            if ($delete_stmt = $mysqli->prepare("DELETE FROM comments_gesture_sets WHERE set_id = '$setId'")) {
                if (!$delete_stmt->execute()) {
                    echo json_encode(array('status' => 'deleteError'));
                    exit();
                }
            } else {
                echo json_encode(array('status' => 'deleteCommentsStatemantError'));
                exit();
            }

            if ($delete_stmt = $mysqli->prepare("DELETE FROM likes_sets WHERE set_id = '$setId'")) {
                if (!$delete_stmt->execute()) {
                    echo json_encode(array('status' => 'deleteError'));
                    exit();
                }
            } else {
                echo json_encode(array('status' => 'deleteLikesStatemantError'));
                exit();
            }

            if ($delete_stmt = $mysqli->prepare("DELETE FROM gesture_sets_shared WHERE set_id = '$setId'")) {
                if (!$delete_stmt->execute()) {
                    echo json_encode(array('status' => 'deleteError'));
                    exit();
                }
            } else {
                echo json_encode(array('status' => 'deleteSharedStatemantError'));
                exit();
            }

            echo json_encode(array('status' => 'success'));
            exit();
        }
    }
} else {
    echo json_encode(array('status' => 'error'));
}