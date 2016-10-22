<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['requestId'])) {
//    $moderatorId = $_SESSION['user_id'];
    $requestId = $_POST['requestId'];

    if ($select_stmt = $mysqli->prepare("SELECT id FROM participation_requests WHERE id = '$requestId' LIMIT 1")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->fetch();

            if ($select_stmt->num_rows == 1) {
//                $select_stmt->bind_result($id, $studyId, $testerId, $moderatorId, $rtcToken, $created, $current);
//                $data = array('id' => $id, 'studyId' => $studyId, "testerId" => $testerId, "moderatorId" => $moderatorId, "rtcToken" => $rtcToken);
                if ($update_stmt = $mysqli->prepare("UPDATE participation_requests SET moderator_id = NULL WHERE id = '$requestId'")) {
                    if (!$update_stmt->execute()) {
                        echo json_encode(array('status' => 'updateError'));
                        exit();
                    } else {
                        echo json_encode(array('status' => 'success', 'requestId' => $requestId));
                        exit();
                    }
                } else {
                    echo json_encode(array('status' => 'statemantError'));
                    exit();
                }
            } else {
                echo json_encode(array('status' => 'noRequestAvalailableAnymore', 'requestId' => $requestId));
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