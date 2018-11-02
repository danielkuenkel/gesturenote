<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['testerId'], $_POST['studyId'], $_POST['evaluatorId'], $_POST['data'])) {

    // serialisation of input data
    $userId = $_SESSION['user_id'];
    $studyId = $_POST['studyId'];
    $testerId = $_POST['testerId'];
    $evaluatorId = $_POST['evaluatorId'];
    $executionData = mysqli_real_escape_string($mysqli, json_encode($_POST['data']));

    if ($select_stmt = $mysqli->prepare("SELECT id FROM study_results_wizard WHERE evaluator_id = '$evaluatorId' && tester_id = '$testerId' && study_id = $studyId LIMIT 1")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($id);
            $select_stmt->fetch();

            if ($select_stmt->num_rows == 1) {
                if ($update_stmt = $mysqli->prepare("UPDATE study_results_wizard SET data = '$executionData' WHERE id = '$id'")) {
                    if (!$update_stmt->execute()) {
                        echo json_encode(array('status' => 'updateError'));
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
                if ($insert_stmt = $mysqli->prepare("INSERT INTO study_results_wizard (study_id, evaluator_id, tester_id, data) VALUES ('$studyId','$evaluatorId','$testerId','$executionData')")) {
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
            }
        }
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}    