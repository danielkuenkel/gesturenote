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

    if ($select_stmt = $mysqli->prepare("SELECT * FROM participation_requests WHERE study_id = '$studyId' ORDER BY created ASC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->bind_result($id, $studyId, $testerId, $moderatorId, $rtcToken, $name, $created, $current);

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
                        'name' => $name,
                        'created' => $created,
                        'current' => $current);
                }
                echo json_encode(array('status' => 'success', 'requests' => $requests));
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