<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'functions.php';
include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['studyId'])) {
    $selectStudyId = $_POST['studyId'];
    $sessionUserId = $_SESSION['user_id'];

    if ($select_stmt = $mysqli->prepare("SELECT data FROM study_results_tester WHERE study_id = '$selectStudyId'")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($data);
            $studies = null;
            $elicitedGestures = null;
            while ($select_stmt->fetch()) {
                $decodedResults = json_decode_nice($data, false);
                if (isset($decodedResults->phases)) {
                    $phases = $decodedResults->phases;

                    foreach ($phases as $item) {

                        if ($item->format === "identification" && isset($item->gestures)) {
                            $gestures = $item->gestures;
                            $count = 0;
                            foreach ($gestures as $gesture) {
                                $gestureId = $gesture->id;
                                $triggerId = $gesture->triggerId;
                                if ($select_gesture_stmt = $mysqli->prepare("SELECT * FROM gestures WHERE id = '$gestureId' LIMIT 1")) {
                                    if (!$select_gesture_stmt->execute()) {
                                        echo json_encode(array('status' => 'selectGesturesError'));
                                    } else {

                                        $select_gesture_stmt->store_result();
                                        $select_gesture_stmt->bind_result($originalGestureId, $gestureUserId, $gestureOwnerId, $gestureSource, $gestureScope, $gestureTitle, $gestureContext, $gestureDescription, $gestureJoints, $gesturePreviewImage, $gestureImages, $gestureCreated);
                                        $select_gesture_stmt->fetch();

                                        $elicitedGestures[] = array('id' => $originalGestureId,
                                            'userId' => $gestureUserId,
                                            'ownerId' => $gestureOwnerId,
                                            'source' => $gestureSource,
                                            'scope' => $gestureScope,
                                            'title' => $gestureTitle,
                                            'context' => $gestureContext,
                                            'description' => $gestureDescription,
                                            'joints' => json_decode($gestureJoints),
                                            'previewImage' => $gesturePreviewImage,
                                            'images' => json_decode($gestureImages),
                                            'created' => $gestureCreated,
                                            'isOwner' => $sessionUserId == $gestureOwnerId,
                                            'triggerId' => $triggerId);
                                    }
                                    $count++;
                                } else {
                                    echo json_encode(array('status' => 'selectGestureStatementError'));
                                    exit();
                                }
                            }
                        }
                    }
                }
            }


            if ($select_stmt = $mysqli->prepare("SELECT * FROM classification WHERE study_id = '$selectStudyId' LIMIT 1")) {
                if (!$select_stmt->execute()) {
                    echo json_encode(array('status' => 'selectError'));
                    exit();
                } else {
                    $classification = null;
                    $select_stmt->store_result();
                    $select_stmt->bind_result($id, $studyId, $data);
                    $select_stmt->fetch();

                    if ($select_stmt->num_rows == 1) {
                        $classification = array('id' => $id,
                            'studyId' => $studyId,
                            'data' => json_decode_nice($data));
                    }

                    echo json_encode(array('status' => 'success', 'elicitedGestures' => $elicitedGestures, 'classification' => $classification));
                    exit();
                }
            } else {
                echo json_encode(array('status' => 'extractionStatementError'));
                exit();
            }
        }
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}    