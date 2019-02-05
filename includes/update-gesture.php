<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['id'], $_POST['title'], $_POST['titleQuality'], $_POST['type'], $_POST['interactionType'], $_POST['continuousValueType'], $_POST['context'], $_POST['association'], $_POST['description'], $_POST['doubleSidedUse'], $_POST['images'], $_POST['previewImage'], $_POST['gif'], $_POST['ownerId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $gestureId = $_POST['id'];
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $titleQuality = $_POST['titleQuality'];
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $interactionType = filter_input(INPUT_POST, 'interactionType', FILTER_SANITIZE_STRING);
    $continuousValueType = filter_input(INPUT_POST, 'continuousValueType', FILTER_SANITIZE_STRING);
    $context = filter_input(INPUT_POST, 'context', FILTER_SANITIZE_STRING);
    $association = filter_input(INPUT_POST, 'association', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $doubleSidedUse = $_POST['doubleSidedUse'];
    $previewImage = $_POST['previewImage'];
    $gif = $_POST['gif'];

    $sensorData = NULL;
    if (isset($_POST['sensorData']) && $_POST['sensorData'] !== '') {
        $encodedSensorData = json_encode($_POST['sensorData']);
        $sensorData = $encodedSensorData === '' ? NULL : $encodedSensorData;
    }

    if (isset($_POST['joints'])) {
        $joints = json_encode($_POST['joints']);
    } else {
        $joints = json_encode(array());
    }

    $imageURLs = $_POST['images'];
    $dbImageURLs = json_encode($imageURLs);
    $ownerId = $_POST['ownerId'];

    if ($update_stmt = $mysqli->prepare("UPDATE gestures SET title = '$title', title_quality ='$titleQuality', type = '$type', interaction_type = '$interactionType', continuous_value_type = '$continuousValueType', context = '$context', association = '$association', description = '$description', joints = '$joints', double_sided_use = '$doubleSidedUse' ,preview_image = '$previewImage', images = '$dbImageURLs', gif = '$gif', sensor_data = '$sensorData' WHERE id = '$gestureId' && owner_id = '$ownerId'")) {
        if (!$update_stmt->execute()) {
            echo json_encode(array('status' => 'updateError'));
            exit();
        } else {
            echo json_encode(array('status' => 'success', 'id' => $gestureId, 'title' => $title, 'titleQuality' => $titleQuality, 'type' => $type, 'interactionType' => $interactionType, 'continuousValueType' => $continuousValueType, 'context' => $context, 'association' => $association, 'description' => $description, 'joints' => json_decode($joints), 'doubleSidedUse' => $doubleSidedUse, 'previewImage' => $previewImage));
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