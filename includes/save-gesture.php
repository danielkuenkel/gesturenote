<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

$target_dir = "../uploads/";
$target_preview_dir = "uploads/";

session_start();
if (isset($_POST['title'], $_POST['titleQuality'], $_POST['context'], $_POST['association'], $_POST['description'], $_POST['doubleSidedUse'], $_POST['previewImage'])) {
    $userId = $_SESSION['user_id'];
    if (isset($_POST['userId']) && $_POST['userId'] != null) {
        $userId = $_POST['userId'];
    }

    $ownerId = $_SESSION['user_id'];
    $source = $_SESSION['usertype'];
    if (isset($_POST['source']) && $_POST['source'] != null) {
        $source = $_POST['source'];
    }

    $scope = 'private';
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $titleQuality = $_POST['titleQuality'];
    $context = filter_input(INPUT_POST, 'context', FILTER_SANITIZE_STRING);
    $association = filter_input(INPUT_POST, 'association', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

    $doubleSidedUse = $_POST['doubleSidedUse'];
    $previewImage = $_POST['previewImage'];
    $gif = isset($_POST['gif']) ? $_POST['gif'] : NULL;
    $encodedSensorData = json_encode($_POST['sensorData']);
    $sensorData = $encodedSensorData === '' ? NULL : $encodedSensorData;
    $imageURLs = isset($_POST['images']) ? $_POST['images'] : NULL;
    $dbImageURLs = $imageURLs ? json_encode($imageURLs) : NULL;
    $created = date('Y-m-d G:i:s');

    if (isset($_POST['joints'])) {
        $joints = json_encode($_POST['joints']);
    } else {
        $joints = json_encode(array());
    }

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

    if (isset($_POST['continuousValueType'])) {
        $continuousValueType = filter_input(INPUT_POST, 'continuousValueType', FILTER_SANITIZE_STRING);
    } else {
        $continuousValueType = null;
    }

    if (isset($_POST['images'], $_POST['gif'])) {
        if ($insert_stmt = $mysqli->prepare("INSERT INTO gestures (user_id, owner_id, source, scope, title, title_quality, type, interaction_type, continuous_value_type, context, association, description, joints, double_sided_use, preview_image, images, gif, sensor_data) VALUES ('$userId', '$ownerId', '$source','$scope','$title','$titleQuality','$type','$interactionType','$continuousValueType','$context','$association','$description','$joints','$doubleSidedUse','$previewImage','$dbImageURLs', '$gif', '$sensorData')")) {
            if (!$insert_stmt->execute()) {
                deleteFiles($target_dir, $imageURLs);
                echo json_encode(array('status' => 'insertError'));
                exit();
            } else {
                $insertId = $mysqli->insert_id;
                echo json_encode(array('status' => 'success', 'gestureId' => $insertId, 'images' => $imageURLs, 'previewImage' => $previewImage, 'gif' => $gif, 'userId' => $userId, 'ownerId' => $ownerId, 'source' => $source, 'scope' => $scope, 'created' => $created));
                exit();
            }
        } else {
            deleteFiles($target_dir, $imageURLs);
            echo json_encode(array('status' => 'statemantError1'));
        }
    } else {
        if ($insert_stmt = $mysqli->prepare("INSERT INTO gestures (user_id, owner_id, source, scope, title, title_quality, type, interaction_type, continuous_value_type,, context, association, description, joints, double_sided_use, preview_image, sensor_data) VALUES ('$userId', '$ownerId', '$source','$scope','$title','$titleQuality','$type','$interactionType','$continuousValueType','$context','$association','$description','$joints','$doubleSidedUse','$previewImage','$sensorData')")) {
            if (!$insert_stmt->execute()) {
                deleteFiles($target_dir, $imageURLs);
                echo json_encode(array('status' => 'insertError'));
                exit();
            } else {
                $insertId = $mysqli->insert_id;
                echo json_encode(array('status' => 'success', 'gestureId' => $insertId, 'previewImage' => $previewImage, 'userId' => $userId, 'ownerId' => $ownerId, 'source' => $source, 'scope' => $scope, 'created' => $created));
                exit();
            }
        } else {
            deleteFiles($target_dir, $imageURLs);
            echo json_encode(array('status' => 'statemantError2'));
        }
    }
} else {
    echo json_encode(array('status' => 'error'));
}