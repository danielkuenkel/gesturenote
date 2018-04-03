<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'functions.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'])) {
    $sessionUserId = $_SESSION['user_id'];

    if ($select_stmt = $mysqli->prepare("SELECT studies.*, COUNT(study_results_tester.id) AS Total FROM studies LEFT JOIN study_results_tester ON studies.id = study_results_tester.study_id GROUP BY studies.id")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->bind_result($id, $userId, $data, $urlToken, $created, $results);
            $studies = null;
            while ($select_stmt->fetch()) {

                $studies[] = array('id' => $id,
                    'userId' => $userId,
                    'data' => json_decode_nice($data),
                    'urlToken' => $urlToken,
                    'created' => $created,
                    'participants' => $results);
            }

            echo json_encode(array('status' => 'success', 'studies' => $studies));
        }
    } else {
        echo json_encode(array('status' => 'statementError'));
    }
} else {
    echo json_encode(array('status' => 'error'));
}