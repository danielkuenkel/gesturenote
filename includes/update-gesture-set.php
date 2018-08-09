<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['setId'], $_POST['title'], $_POST['gestures'], $_POST['ownerId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $setId = $_POST['setId'];
    $title = mysqli_real_escape_string($mysqli, json_encode($_POST['title']));
    $gestures = mysqli_real_escape_string($mysqli, json_encode($_POST['gestures']));
//    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
//    $interactionType = filter_input(INPUT_POST, 'interactionType', FILTER_SANITIZE_STRING);
//    $context = filter_input(INPUT_POST, 'context', FILTER_SANITIZE_STRING);
//    $association = filter_input(INPUT_POST, 'association', FILTER_SANITIZE_STRING);
//    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
//    $joints = json_encode($_POST['joints']);
//    $previewImage = $_POST['previewImage'];
//    $gif = $_POST['gif'];
//    $encodedSensorData = json_encode($_POST['sensorData']);
//    $sensorData = $encodedSensorData === '' ? NULL : $encodedSensorData;
//    $imageURLs = $_POST['images'];
//    $dbImageURLs = json_encode($imageURLs);
    $ownerId = $_POST['ownerId'];

    if ($update_stmt = $mysqli->prepare("UPDATE gesture_sets SET title = '$title', gestures = '$gestures' WHERE id = '$setId' && user_id = '$ownerId'")) {
        if (!$update_stmt->execute()) {
            echo json_encode(array('status' => 'updateError'));
            exit();
        } else {
            echo json_encode(array('status' => 'success', 'id' => $setId, 'title' => $title));
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