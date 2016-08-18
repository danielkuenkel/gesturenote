<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'functions.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['data'], $_POST['studyId'])) {

    // Serialisieren der Daten
    $studyData = mysqli_real_escape_string($mysqli, json_encode($_POST['data']));
    $updateStudyId = $_POST['studyId'];
    $sessionUserId = $_SESSION['user_id'];

    if ($update_stmt = $mysqli->prepare("UPDATE studies SET general_data = '$studyData' WHERE id = '$updateStudyId' && user_id = '$sessionUserId'")) {
        if (!$update_stmt->execute()) {
            echo json_encode(array('status' => 'updateError'));
            exit();
        } else {
            echo json_encode(array('status' => 'success', 'studyId' => $updateStudyId));
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