<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'functions.php';
include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_POST['studyId'])) {
    if (isset($_SESSION['user_id'])) {
        $sessionUserId = $_SESSION['user_id'];
    } else {
        $sessionUserId = 'guest';
    }

    $selectStudyId = $_POST['studyId'];

    if ($select_stmt = $mysqli->prepare("SELECT * FROM studies WHERE id = '$selectStudyId' LIMIT 1")) {
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

                    if ($select_stmt = $mysqli->prepare("SELECT * FROM gestures ORDER BY created DESC")) {
                        if (!$select_stmt->execute()) {
                            echo json_encode(array('status' => 'selectGesturesError'));
                        } else {
                            $select_stmt->bind_result($gestureId, $gestureUserId, $gestureOwnerId, $gestureSource, $gestureScope, $gestureTitle, $gestureType, $gestureInteractionType, $gestureContext, $gestureAssociation, $gestureDescription, $gestureJoints, $gesturePreviewImage, $gestureImages, $gestureCreated);
                            while ($select_stmt->fetch()) {
                                foreach ($assembledGestures as $assembledGestureId) {
                                    if (strcmp($gestureId, $assembledGestureId) == 0) {
                                        $gestures[] = array('id' => $gestureId,
                                            'userId' => $gestureUserId,
                                            'ownerId' => $gestureOwnerId,
                                            'source' => $gestureSource,
                                            'scope' => $gestureScope,
                                            'title' => $gestureTitle,
                                            'type' => $gestureType,
                                            'interactionType' => $gestureInteractionType,
                                            'context' => $gestureContext,
                                            'association' => $gestureAssociation,
                                            'description' => $gestureDescription,
                                            'joints' => json_decode($gestureJoints),
                                            'previewImage' => $gesturePreviewImage,
                                            'images' => json_decode($gestureImages),
                                            'created' => $gestureCreated,
                                            'isOwner' => $sessionUserId == $gestureOwnerId);
                                    }
                                }
                            }
                        }
                    }
                }

                echo json_encode(array('status' => 'success', 'id' => $studyId, 'userId' => $studyUserId, 'studyData' => $decodedData, 'urlToken' => $urlToken, 'created' => $studyCreated, 'gestureCatalog' => $gestures));
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
