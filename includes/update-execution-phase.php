<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['participantId'], $_POST['executionPhase'])) {
    $sessionUserId = $_SESSION['user_id'];
    $participantId = $_POST['participantId'];
    $executionPhase = $_POST['executionPhase'];
    $evaluatorId = isset($_POST['evaluatorId']) ? $_POST['evaluatorId'] : null;

    if ($update_participant_stmt = $mysqli->prepare("UPDATE study_results_tester SET execution_phase = '$executionPhase' WHERE id = '$participantId'")) {
        if (!$update_participant_stmt->execute()) {
            echo json_encode(array('status' => 'updateError'));
            exit();
        }
    } else {
        echo json_encode(array('status' => 'statemantError'));
        exit();
    }

    if ($evaluatorId !== null) {
        if ($update_evaluator_stmt = $mysqli2->prepare("UPDATE study_results_evaluator SET execution_phase = '$executionPhase' WHERE id = '$evaluatorId'")) {
            if (!$update_evaluator_stmt->execute()) {
                echo json_encode(array('status' => 'updateError'));
                exit();
            }
        } else {
            echo json_encode(array('status' => 'statemantError'));
            exit();
        }
    }

    echo json_encode(array('status' => 'success', 'evaluatorId' => $evaluatorId));
    exit();
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}    