<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'functions.php';
include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['studyId'], $_POST['participantId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $selectStudyId = $_POST['studyId'];
    $selectParticipantId = $_POST['participantId'];

    $studyResultsEvaluator = null;
    if ($select_stmt = $mysqli->prepare("SELECT * FROM study_results_evaluator WHERE study_id = '$selectStudyId' && evaluator_id = '$sessionUserId' && tester_id = '$selectParticipantId' LIMIT 1")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($id, $studyId, $evaluatorId, $testerId, $data, $observations, $notes, $executionPhase, $created);
            $select_stmt->fetch();
            if ($select_stmt->num_rows == 0) {
                echo json_encode(array('status' => 'success', 'evaluatorData' => null));
            } else if ($select_stmt->num_rows == 1) {
                $studyResultsEvaluator = array(
                    'id' => $id,
                    'studyId' => $studyId,
                    'evaluatorId' => $evaluatorId,
                    'testerId' => $testerId,
                    'results' => json_decode_nice($data, false),
                    'observations' => json_decode_nice($observations, false),
                    'notes' => json_decode_nice($notes, false),
                    'executionPhase' => $executionPhase,
                    'created' => $created
                );

                echo json_encode(array('status' => 'success', 'evaluatorData' => $studyResultsEvaluator));
            } else {
                echo json_encode(array('status' => 'rowsError'));
                exit();
            }
        }
    } else {
        echo json_encode(array('status' => 'statemantError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}

