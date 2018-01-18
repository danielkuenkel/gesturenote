<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'functions.php';
include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['studyId'], $_POST['participantId'])) {

    $sessionUserId = $_SESSION['user_id'];
    $selectStudyId = $_POST['studyId'];
    $selectParticipantId = $_POST['participantId'];

    if ($select_stmt = $mysqli->prepare("SELECT * FROM studies WHERE id = '$selectStudyId' LIMIT 1")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->bind_result($originalStudyId, $studyUserId, $studyData, $urlToken, $studyCreated);
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
                            $select_stmt->bind_result($gestureId, $gestureUserId, $gestureOwnerId, $gestureSource, $gestureScope, $gestureTitle, $gestureType, $gestureInteractionType, $gestureContext, $gestureAssociation, $gestureDescription, $gestureJoints, $gesturePreviewImage, $gestureImages, $gestureGIF, $gestureCreated);
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
                                            'gif' => $gestureGIF,
                                            'created' => $gestureCreated,
                                            'isOwner' => strcmp($gestureOwnerId, $sessionUserId) == 0);
                                    }
                                }
                            }
                        }
                    }
                }

                $results = null;
                if ($select_stmt = $mysqli->prepare("SELECT * FROM study_results_tester WHERE study_id = '$selectStudyId' && user_id = '$selectParticipantId' LIMIT 1")) {
                    if (!$select_stmt->execute()) {
                        echo json_encode(array('status' => 'selectError'));
                        exit();
                    } else {

                        $select_stmt->store_result();
                        $select_stmt->bind_result($id, $studyId, $userId, $data, $created);
                        $select_stmt->fetch();

                        if ($select_stmt->num_rows == 1) {
                            $decodedResults = json_decode_nice($data, false);
                            $elicitedGestures = null;
                            $elicitedTrigger = null;

                            if (isset($decodedResults->phases)) {
                                $phases = $decodedResults->phases;

                                foreach ($phases as $item) {

                                    if ($item->format === "identification") {
                                        if (isset($item->gestures)) {
                                            $gestures = $item->gestures;

                                            foreach ($gestures as $gesture) {
                                                $gestureId = $gesture->id;
                                                $triggerId = $gesture->triggerId;

                                                if ($select_gesture_stmt = $mysqli->prepare("SELECT * FROM gestures WHERE id = '$gestureId' LIMIT 1")) {
                                                    if (!$select_gesture_stmt->execute()) {
                                                        echo json_encode(array('status' => 'selectGesturesError'));
                                                    } else {
                                                        $select_gesture_stmt->store_result();
                                                        $select_gesture_stmt->bind_result($gestureId, $gestureUserId, $gestureOwnerId, $gestureSource, $gestureScope, $gestureTitle, $gestureType, $gestureInteractionType, $gestureContext, $gestureAssociation, $gestureDescription, $gestureJoints, $gesturePreviewImage, $gestureImages, $gestureGIF, $gestureCreated);
                                                        $select_gesture_stmt->fetch();
                                                        $elicitedGestures[] = array('id' => $gestureId,
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
                                                            'gif' => $gestureGIF,
                                                            'created' => $gestureCreated,
                                                            'isOwner' => strcmp($gestureOwnerId, $sessionUserId) == 0);
                                                    }
                                                }
                                            }
                                        } else if (isset($item->trigger)) {
                                            $triggers = $item->trigger;
                                            foreach ($triggers as $trigger) {
                                                $triggerId = $trigger->preferredTrigger->answers[0]->id;
                                                $triggerName = $trigger->preferredTrigger->answers[0]->answer->openAnswer;
                                                $gestureId = $trigger->gestureId;
                                                $elicitedTrigger[] = array('id' => $triggerId, 'title' => $triggerName, 'gestureId' => $gestureId);
                                            }
                                        }
                                    }
                                }
                            }

                            $results = array('id' => $id,
                                'userId' => $userId,
                                'results' => json_decode_nice($data, false),
                                'elicitedGestures' => $elicitedGestures,
//                                'elicitedTrigger' => $elicitedTrigger,
                                'created' => $created);
                        } else {
                            echo json_encode(array('status' => 'rowsError'));
                            exit();
                        }
                    }
                } else {
                    echo json_encode(array('status' => 'statemantError'));
                    exit();
                }

                $studyResultsEvaluator = null;
                if ($select_stmt = $mysqli->prepare("SELECT * FROM study_results_evaluator WHERE study_id = '$selectStudyId' && evaluator_id = '$sessionUserId' && tester_id = '$selectParticipantId' LIMIT 1")) {
                    if (!$select_stmt->execute()) {
                        echo json_encode(array('status' => 'selectError'));
                        exit();
                    } else {
                        $select_stmt->store_result();
                        $select_stmt->bind_result($id, $studyId, $evaluatorId, $testerId, $data, $observations, $notes, $created);
                        $select_stmt->fetch();

                        if ($select_stmt->num_rows == 1) {
                            $decodedResults = json_decode_nice($data, false);
                            $elicitedGestures = null;
                            $elicitedTrigger = null;

                            if (isset($decodedResults->phases)) {
                                $phases = $decodedResults->phases;

                                foreach ($phases as $item) {

                                    if ($item->format === "identification") {
                                        if (isset($item->gestures)) {
                                            $gestures = $item->gestures;

                                            foreach ($gestures as $gesture) {
                                                $gestureId = $gesture->id;
                                                $triggerId = $gesture->triggerId;

                                                if ($select_gesture_stmt = $mysqli->prepare("SELECT * FROM gestures WHERE id = '$gestureId' LIMIT 1")) {
                                                    if (!$select_gesture_stmt->execute()) {
                                                        echo json_encode(array('status' => 'selectGesturesError'));
                                                    } else {
                                                        $select_gesture_stmt->store_result();
                                                        $select_gesture_stmt->bind_result($gestureId, $gestureUserId, $gestureOwnerId, $gestureSource, $gestureScope, $gestureTitle, $gestureType, $gestureInteractionType, $gestureContext, $gestureAssociation, $gestureDescription, $gestureJoints, $gesturePreviewImage, $gestureImages, $gestureGIF, $gestureCreated);
                                                        $select_gesture_stmt->fetch();
                                                        $elicitedGestures[] = array('id' => $gestureId,
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
                                                            'gif' => $gestureGIF,
                                                            'created' => $gestureCreated,
                                                            'isOwner' => strcmp($gestureOwnerId, $sessionUserId) == 0);
                                                    }
                                                }
                                            }
                                        } else if (isset($item->trigger)) {
                                            $triggers = $item->trigger;
                                            foreach ($triggers as $trigger) {
                                                $triggerId = $trigger->preferredTrigger->answers[0]->id;
                                                $triggerName = $trigger->preferredTrigger->answers[0]->answer->openAnswer;
                                                $gestureId = $trigger->gestureId;
                                                $elicitedTrigger[] = array('id' => $triggerId, 'title' => $triggerName, 'gestureId' => $gestureId);
                                            }
                                        }
                                    }
                                }
                            }

                            $studyResultsEvaluator = array('id' => $id,
                                'studyId' => $studyId,
                                'evaluatorId' => $evaluatorId,
                                'testerId' => $testerId,
                                'results' => json_decode_nice($data, false),
                                'elicitedGestures' => $elicitedGestures,
//                                'elicitedTrigger' => $elicitedTrigger,
                                'observations' => json_decode_nice($observations, false),
                                'notes' => json_decode_nice($notes, false),
                                'created' => $created);
                        } else {
                            echo json_encode(array('status' => 'rowsError', 'num_rows' => $select_stmt->num_rows, 'studyId' => $selectStudyId, "evaluatorId" => $sessionUserId, 'testerId' => $selectParticipantId));
                            exit();
                        }
                    }
                } else {
                    echo json_encode(array('status' => 'statemantError'));
                    exit();
                }

                echo json_encode(array('status' => 'success', 'id' => $originalStudyId, 'userId' => $studyUserId, 'studyData' => $decodedData, 'resultData' => $results, 'evaluatorData' => $studyResultsEvaluator, 'urlToken' => $urlToken, 'created' => $studyCreated, 'gestureCatalog' => $gestures));
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
    