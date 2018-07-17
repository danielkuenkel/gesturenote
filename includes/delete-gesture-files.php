<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

$target_dir = "../";

session_start();
if (isset($_SESSION['user_id']) && isset($_POST['gestureId'])) {
    $gestureId = $_POST['gestureId'];
    $userId = $_SESSION['user_id'];

    if ($select_stmt = $mysqli->prepare("SELECT `images`, `gif`, `sensor_data` FROM gestures WHERE id = '$gestureId'")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($imageURLs, $gifUrl, $sensorData);
            $select_stmt->fetch();

            if ($select_stmt->num_rows == 1) {
                if ($imageURLs !== NULL) {
                    deleteFiles($target_dir, json_decode($imageURLs));
                }
                if ($gifUrl !== NULL) {
                    deleteFiles($target_dir, array($gifUrl));
                }
                $parseSensorData = json_decode($sensorData);
                if ($sensorData !== NULL && $parseSensorData->url) {
                    deleteFiles($target_dir, array($parseSensorData->url));
                }
                echo json_encode(array('status' => 'success'));
                exit();
            } else {
                echo json_encode(array('status' => 'fetchError'));
                exit();
            }
        }
    } else {
        echo json_encode(array('status' => 'statemantError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
}