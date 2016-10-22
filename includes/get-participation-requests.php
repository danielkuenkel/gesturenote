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
if (isset($_SESSION['user_id'], $_POST['studyId'])) {
    $studyId = $_POST['studyId'];

    if ($select_stmt = $mysqli->prepare("SELECT * FROM participation_requests WHERE study_id = '$studyId' ORDER BY created DESC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->bind_result($id, $studyId, $testerId, $moderatorId, $rtcToken, $created, $current);

            if (!$select_stmt->execute()) {
                echo json_encode(array('status' => 'selectError'));
                exit();
            } else {
                $requests = null;
                while ($select_stmt->fetch()) {
                    $requests[] = array('id' => $id,
                        'studyId' => $studyId,
                        'testerId' => $testerId,
                        'moderatorId' => $moderatorId,
                        'rtcToken' => $rtcToken,
                        'created' => $created,
                        'current' => $current);
                }
                echo json_encode(array('status' => 'success', 'requests' => $requests));
            }

//            if ($select_stmt->num_rows == 1) {
//                if ($update_stmt = $mysqli->prepare("UPDATE participation_requests SET created = now() WHERE id = '$id'")) {
//                    if (!$update_stmt->execute()) {
//                        echo json_encode(array('status' => 'updateError'));
//                        exit();
//                    } else {
//                        echo json_encode(array('status' => 'success', 'data' => $data));
//                        exit();
//                    }
//                } else {
//                    echo json_encode(array('status' => 'statemantError'));
//                    exit();
//                }
//            } else {
//                if ($insert_stmt = $mysqli->prepare("INSERT INTO participation_requests (study_id, tester_id, rtc_token) VALUES ('$studyId','$testerId','$rtcToken')")) {
//                    if (!$insert_stmt->execute()) {
//                        echo json_encode(array('status' => 'insertError'));
//                        exit();
//                    } else {
//                        echo json_encode(array('status' => 'success', 'data' => $data));
//                        exit();
//                    }
//                } else {
//                    echo json_encode(array('status' => 'statemantError'));
//                    exit();
//                }
//            }
        }
    } else {
        echo json_encode(array('status' => 'statemantError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}