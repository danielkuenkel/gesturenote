<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['studyId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $selectStudyId = $_POST['studyId'];

    if ($select_stmt = $mysqli->prepare("SELECT * FROM studies WHERE user_id = '$sessionUserId' AND id = '$selectStudyId' LIMIT 1")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->bind_result($studyId, $studyUserId, $studyData, $urlToken, $studyCreated);
            $select_stmt->store_result();
            $select_stmt->fetch();
            if ($select_stmt->num_rows == 1) {
                $gestures = null;
                $decodedData = json_decode_nice($studyData, false);
                if (isset($decodedData->assembledGestureSet)) {
                    $assembledGestures = $decodedData->assembledGestureSet;

                    if ($select_stmt = $mysqli->prepare("SELECT * FROM gestures WHERE user_id = '$sessionUserId'")) {
                        if (!$select_stmt->execute()) {
                            echo json_encode(array('status' => 'selectGesturesError'));
                        } else {
                            $select_stmt->bind_result($gestureId, $gestureUserId, $gestureSource, $gestureScope, $gestureTitle, $gestureContext, $gestureDescription, $gestureJoints, $gesturePreviewImage, $gestureImages, $gestureCreated);
                            while ($select_stmt->fetch()) {
                                foreach ($assembledGestures as $assembledGestureId) {
                                    if ($gestureId == $assembledGestureId) {
                                        $gestures[] = array('id' => $gestureId,
                                            'userId' => $gestureUserId,
                                            'source' => $gestureSource,
                                            'scope' => $gestureScope,
                                            'title' => $gestureTitle,
                                            'context' => $gestureContext,
                                            'description' => $gestureDescription,
                                            'joints' => json_decode($gestureJoints),
                                            'previewImage' => $gesturePreviewImage,
                                            'images' => json_decode($gestureImages),
                                            'created' => $gestureCreated);
                                    }
                                }
                            }
                        }
                    }
                }

                echo json_encode(array('status' => 'success', 'id' => $studyId, 'userId' => $studyUserId, 'data' => $decodedData, 'urlToken' => $urlToken, 'created' => $studyCreated, 'gestureCatalog' => $gestures));
                exit();
            } else {
                echo json_encode(array('status' => 'rowsError'));
                exit();
            }
        }
    } else {
        echo json_encode(array('status' => 'statementError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}

function json_decode_nice($json, $assoc = TRUE) {
    $json = str_replace(array("\n", "\r"), "\\n", $json);
    $json = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/', '$1"$3":', $json);
    $json = preg_replace('/(,)\s*}$/', '}', $json);
    return json_decode($json, $assoc);
}
