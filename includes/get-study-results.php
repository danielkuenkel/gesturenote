<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['studyId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $currentStudyId = $_POST['studyId'];

    if ($select_stmt = $mysqli->prepare("SELECT * FROM study_results_tester WHERE study_id = '$currentStudyId' ORDER BY created DESC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $results = null;
            $select_stmt->bind_result($id, $studyId, $userId, $data, $executionPhase, $created);
            while ($select_stmt->fetch()) {
                $results[] = array('id' => $id,
                    'studyId' => $studyId,
                    'userId' => $userId,
                    'data' => json_decode_nice($data, false),
                    'executionPhase' => $executionPhase,
                    'created' => $created);
            }

            echo json_encode(array('status' => 'success', 'studyResults' => $results));
        }
    } else {
        echo json_encode(array('status' => 'statemantError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}