<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

if (isset($_POST['generalData'])) {

    // Serialisieren der Daten
    $projectData = json_encode($_POST['generalData']);

    // get the ID of the logged in user
    session_start();
    $userId = $_SESSION['user_id'];
    $urlToken = sha1(time() . $userId);
    if ($insert_stmt = $mysqli->prepare("INSERT INTO studies (user_id, general_data, url_token) VALUES ('$userId','$projectData','$urlToken')")) {
        if (!$insert_stmt->execute()) {
            echo json_encode(array('status' => 'insertError'));
            exit();
        } else {
            echo json_encode(array('status' => 'success'));
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