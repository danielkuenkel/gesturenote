<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['studyId'], $_POST['title'])) {
    $userSessionId = $_SESSION['user_id'];
    $studyId = $_POST['studyId'];
    $title = mysqli_real_escape_string($mysqli, json_encode($_POST['title']));


    if ($insert_stmt = $mysqli->prepare("INSERT INTO gesture_sets (study_id, user_id, title) VALUES ('$studyId','$userSessionId','$title')")) {
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