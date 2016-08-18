<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'functions.php';
include_once 'psl-config.php';

$target_dir = "../";

session_start();
if (isset($_SESSION['user_id'], $_POST['studyId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $deleteStudyId = $_POST['studyId'];

    if ($select_stmt = $mysqli->prepare("SELECT general_data FROM studies WHERE id = '$deleteStudyId' && user_id = '$sessionUserId'")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($generalData);
            $select_stmt->fetch();

            if ($select_stmt->num_rows == 1) {
                $decodedData = json_decode_nice($generalData, false);
                $deleteFiles = array();

                if (isset($decodedData->assembledScenes)) {
                    $assembledScenes = $decodedData->assembledScenes;
                    foreach ($assembledScenes as $scene) {
                        if ($scene->type === 'image') {
                            array_push($deleteFiles, $scene->data);
                        }
                    }
                }

                if (isset($decodedData->assembledFeedback)) {
                    $assembledFeedback = $decodedData->assembledFeedback;
                    foreach ($assembledFeedback as $feedback) {
                        if ($feedback->type === 'sound') {
                            array_push($deleteFiles, $feedback->data);
                        }
                    }
                }

                if ($delete_stmt = $mysqli->prepare("DELETE FROM studies WHERE id = '$deleteStudyId' && user_id = '$sessionUserId'")) {
                    if (!$delete_stmt->execute()) {
                        echo json_encode(array('status' => 'deleteError'));
                        exit();
                    } else {
                        deleteFiles($target_dir, $deleteFiles);
                        echo json_encode(array('status' => 'success'));
                        exit();
                    }
                } else {
                    echo json_encode(array('status' => 'deleteStatemantError'));
                    exit();
                }
            } else {
                echo json_encode(array('status' => 'fetchError'));
                exit();
            }
        }
    } else {
        echo json_encode(array('status' => 'statemantError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
}