<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'functions.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['studyId'], $_POST['classification'])) {
    $sessionUserId = $_SESSION['user_id'];
    $studyId = $_POST['studyId'];
    $data = json_encode($_POST['classification']);
    
    if ($select_stmt = $mysqli->prepare("SELECT id FROM classification WHERE study_id = '$studyId' LIMIT 1")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($rowId);
            $select_stmt->fetch();

            if ($select_stmt->num_rows == 1) {
                if ($update_stmt = $mysqli->prepare("UPDATE classification SET data = '$data' WHERE id = '$rowId'")) {
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
                if ($insert_stmt = $mysqli->prepare("INSERT INTO classification (study_id, data) VALUES ('$studyId','$data')")) {
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
}