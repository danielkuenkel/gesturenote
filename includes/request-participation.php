<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['studyId'], $_POST['rtcToken'], $_POST['name'])) {
    $currentTesterId = $_SESSION['user_id'];
    $currentStudyId = $_POST['studyId'];
    $currentRTCToken = $_POST['rtcToken'];
    $insertName = $_POST['name'];

    if ($select_stmt = $mysqli->prepare("SELECT * FROM participation_requests WHERE tester_id = '$currentTesterId' && study_id = '$currentStudyId' LIMIT 1")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($id, $studyId, $testerId, $moderatorId, $rtcToken, $name, $created, $current);
            $select_stmt->fetch();
            $data = null;
            if ($select_stmt->num_rows == 1) {
                $data = array('id' => $id, 'studyId' => $studyId, "testerId" => $testerId, "moderatorId" => $moderatorId, "rtcToken" => $rtcToken);
                if ($update_stmt = $mysqli->prepare("UPDATE participation_requests SET current = now(), name = '$insertName' WHERE id = '$id'")) {
                    if (!$update_stmt->execute()) {
                        echo json_encode(array('status' => 'updateError'));
                        exit();
                    } else {
                        echo json_encode(array('status' => 'success', 'data' => $data));
                        exit();
                    }
                } else {
                    echo json_encode(array('status' => 'statemantError'));
                    exit();
                }
            } else {
                if ($insert_stmt = $mysqli->prepare("INSERT INTO participation_requests (study_id, tester_id, rtc_token, name) VALUES ('$currentStudyId','$currentTesterId','$currentRTCToken', '$insertName')")) {
                    if (!$insert_stmt->execute()) {
                        echo json_encode(array('status' => 'insertError'));
                        exit();
                    } else {
                        $data = array("rtcToken" => $currentRTCToken);
                        echo json_encode(array('status' => 'success', 'data' => $data));
                        exit();
                    }
                } else {
                    echo json_encode(array('status' => 'statemantError'));
                    exit();
                }
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