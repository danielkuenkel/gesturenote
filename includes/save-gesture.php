<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

$target_dir = "../uploads/";
$target_preview_dir = "uploads/";

session_start();
if (isset($_SESSION['usertype'], $_POST['title'], $_POST['context'], $_POST['association'], $_POST['description'], $_POST['joints'], $_POST['previewImage'], $_POST['images'], $_POST['gif'], $_POST['sensorData'])) {
    $userId = $_SESSION['user_id'];
    $ownerId = $_SESSION['user_id'];
    if (isset($_POST['ownerId']) && $_POST['ownerId'] != null) {
        $ownerId = $_POST['ownerId'];
    }
    
    $source = $_SESSION['usertype'];
    $scope = 'private';
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $context = filter_input(INPUT_POST, 'context', FILTER_SANITIZE_STRING);
    $association = filter_input(INPUT_POST, 'association', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $joints = json_encode($_POST['joints']);
    $imageURLs = $_POST['images'];
    $previewImage = $_POST['previewImage'];
    $gif = $_POST['gif'];
    $encodedSensorData = json_encode($_POST['sensorData']);
    $sensorData = $encodedSensorData === '' ? NULL : $encodedSensorData;
    $dbImageURLs = json_encode($imageURLs);

    if (isset($_POST['type'])) {
        $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    } else {
        $type = null;
    }

    if (isset($_POST['interactionType'])) {
        $interactionType = filter_input(INPUT_POST, 'interactionType', FILTER_SANITIZE_STRING);
    } else {
        $interactionType = null;
    }

    if ($insert_stmt = $mysqli->prepare("INSERT INTO gestures (user_id, owner_id, source, scope, title, type, interaction_type, context, association, description, joints, preview_image, images, gif, sensor_data) VALUES ('$userId', '$ownerId', '$source','$scope','$title','$type','$interactionType','$context','$association','$description','$joints','$previewImage','$dbImageURLs', '$gif', '$sensorData')")) {
        if (!$insert_stmt->execute()) {
            deleteFiles($target_dir, $imageURLs);
            echo json_encode(array('status' => 'insertError'));
            exit();
        } else {
            $insertId = $mysqli->insert_id;
            echo json_encode(array('status' => 'success', 'gestureId' => $insertId, 'images' => $imageURLs, 'previewImage' => $previewImage, 'gif' => $gif));
            exit();
        }
    } else {
        deleteFiles($target_dir, $imageURLs);
        echo json_encode(array('status' => 'statemantError'));
    }
} else {
    echo json_encode(array('status' => 'error'));
}