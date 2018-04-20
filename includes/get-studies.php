<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'functions.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'])) {
    $sessionUserId = $_SESSION['user_id'];
    $sessionUserMail = $_SESSION['email'];

    if ($select_stmt = $mysqli->prepare("SELECT studies.*, COUNT(study_results_tester.id) AS Total, COUNT(studies_shared.id) AS sharedTotal FROM studies LEFT JOIN study_results_tester ON studies.id = study_results_tester.study_id LEFT JOIN studies_shared ON studies.id = studies_shared.study_id WHERE studies.user_id = '$sessionUserId' GROUP BY studies.id ORDER BY studies.created ASC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->bind_result($id, $userId, $data, $urlToken, $created, $participants, $sharedStudies);
            $studies = null;
            while ($select_stmt->fetch()) {
                $studies[] = array('id' => $id,
                    'userId' => $userId,
                    'isOwner' => intval($userId) === intval($sessionUserId),
                    'data' => json_decode_nice($data),
                    'urlToken' => $urlToken,
                    'created' => $created,
                    'participants' => $participants,
                    'shared' => $sharedStudies);
            }

            
        }
    } else {
        echo json_encode(array('status' => 'statementError'));
        exit();
    }

    if ($select_stmt = $mysqli->prepare("SELECT studies.*, COUNT(study_results_tester.id) AS Total FROM studies LEFT JOIN studies_shared ON studies.id = studies_shared.study_id LEFT JOIN study_results_tester ON studies.id = study_results_tester.study_id WHERE studies_shared.email = '$sessionUserMail' GROUP BY studies.id ORDER BY studies.created ASC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectInvitedError'));
            exit();
        } else {
            $select_stmt->bind_result($id, $userId, $data, $urlToken, $created, $participants);
            $invitedStudies = null;
            while ($select_stmt->fetch()) {
                $invitedStudies[] = array('id' => $id,
                    'userId' => $userId,
                    'isOwner' => intval($userId) === intval($sessionUserId),
                    'data' => json_decode_nice($data),
                    'urlToken' => $urlToken,
                    'created' => $created,
                    'participants' => $participants);
            }
            
            $result = [];
            if(count($studies) > 0 && count($invitedStudies) > 0) {
                $result = array_merge($studies, $invitedStudies);
            } else if(count($studies) > 0) {
                $result = $studies;
            } else if(count($invitedStudies) > 0) {
                $result = $invitedStudies;
            }
            echo json_encode(array('status' => 'success', 'studies' => $result));
            exit();
        }
    } else {
        echo json_encode(array('status' => 'statementInvitedError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}