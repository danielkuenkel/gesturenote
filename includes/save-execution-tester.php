<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['studyId'], $_POST['data'])) {

    // Serialisieren der Daten
    $studyId = $_POST['studyId'];
    $userId = $_SESSION['user_id'];
    if(isset($_POST['testerId'])) {
        $userId = $_POST['testerId'] ;
    }
    
    $executionData = mysqli_real_escape_string($mysqli, json_encode($_POST['data']));

    if ($select_stmt = $mysqli->prepare("SELECT id FROM study_results_tester WHERE user_id = '$userId' && study_id = $studyId LIMIT 1")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($id);
            $select_stmt->fetch();

            if ($select_stmt->num_rows == 1) {
                if ($update_stmt = $mysqli->prepare("UPDATE study_results_tester SET data = '$executionData' WHERE id = '$id'")) {
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
                if ($insert_stmt = $mysqli->prepare("INSERT INTO study_results_tester (study_id, user_id, data) VALUES ('$studyId','$userId','$executionData')")) {
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