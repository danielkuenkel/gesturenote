<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['studyId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $studyId = $_POST['studyId'];

    if ($select_stmt = $mysqli->prepare("SELECT * FROM gesture_sets WHERE study_id = $studyId && user_id = $sessionUserId ORDER BY created DESC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($id, $studyId, $userId, $title, $gestures, $created);

            $gestureSets;

            while ($select_stmt->fetch()) {
                $gestureSets[] = array('id' => $id,
                    'studyId' => $studyId,
                    'userId' => $userId,
                    'title' => json_decode_nice($title, false),
                    'gestures' => json_decode_nice($gestures, false),
                    'created' => $created);
            }

            echo json_encode(array('status' => 'success', 'gestureSets' => $gestureSets));
            exit();
        }
    } else {
        echo json_encode(array('status' => 'statemantCommentsError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}