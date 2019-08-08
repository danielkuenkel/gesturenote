<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['title'], $_POST['gestureSetId'], $_POST['data'])) {
    $userSessionId = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($mysqli, json_encode($_POST['title']));
    $gestureSetId = mysqli_real_escape_string($mysqli, $_POST['gestureSetId']);
    $data = mysqli_real_escape_string($mysqli, json_encode($_POST['data']));

    if ($insert_stmt = $mysqli->prepare("INSERT INTO gesture_set_simulation (user_id, gesture_set_id, title, data) VALUES ('$userSessionId','$gestureSetId','$title','$data')")) {
        if (!$insert_stmt->execute()) {
            echo json_encode(array('status' => 'insertError'));
            exit();
        } else {
            $insertId = $mysqli->insert_id;
            echo json_encode(array('status' => 'success', 'id' => $insertId));
            exit();
        }
    } else {
        echo json_encode(array('status' => 'statemantError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}