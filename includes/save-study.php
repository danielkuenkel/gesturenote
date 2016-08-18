<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'functions.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['data'])) {
    
    // Serialisieren der Daten
    $studyData = mysqli_real_escape_string($mysqli, json_encode($_POST['data']));
    $userId = $_SESSION['user_id'];
    $urlToken = sha1(time() . $userId);

    if ($insert_stmt = $mysqli->prepare("INSERT INTO studies (user_id, general_data, url_token) VALUES ('$userId','$studyData','$urlToken')")) {
        if (!$insert_stmt->execute()) {
            echo json_encode(array('status' => 'insertError'));
            exit();
        } else {
            $studyId = $mysqli->insert_id;
            echo json_encode(array('status' => 'success', 'studyId' => $studyId));
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