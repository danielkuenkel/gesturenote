<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['studyId'], $_POST['testerId'], $_POST['notes'])) {
    $notes = json_encode($_POST['notes']);
    $studyId = $_POST['studyId'];
    $testerId = $_POST['testerId'];

    if ($select_stmt = $mysqli->prepare("SELECT id FROM study_results_evaluator WHERE id = '$studyId' && tester_id = '$testerId' LIMIT 1")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->bind_result($evaluatorResultId);
            $select_stmt->store_result();
            $select_stmt->fetch();
            if ($select_stmt->num_rows == 1) {
                echo json_encode(array('status' => 'update row'));
                exit();
            } else {
                echo json_encode(array('status' => 'insert new row'));
                exit();
            }
        }
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}