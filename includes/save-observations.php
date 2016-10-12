<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['studyId'], $_POST['testerId'], $_POST['observations'])) {
    $observations = mysqli_real_escape_string($mysqli, json_encode($_POST['observations']));
    $studyId = $_POST['studyId'];
    $testerId = $_POST['testerId'];
    $userSessionId = $_SESSION['user_id'];

    if ($select_stmt = $mysqli->prepare("SELECT id FROM study_results_evaluator WHERE study_id = '$studyId' && tester_id = '$testerId' && evaluator_id = '$userSessionId' LIMIT 1")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($rowId);
            $select_stmt->fetch();

            if ($select_stmt->num_rows == 1) {
                if ($update_stmt = $mysqli->prepare("UPDATE study_results_evaluator SET observations = '$observations' WHERE id = '$rowId'")) {
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
                exit();
            } else {
                if ($insert_stmt = $mysqli->prepare("INSERT INTO study_results_evaluator (study_id, evaluator_id, tester_id, observations) VALUES ('$studyId','$userSessionId','$testerId', '$observations')")) {
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