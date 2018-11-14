<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'functions.php';
include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['studyId'], $_POST['surveyType'])) {
    $selectStudyId = $_POST['studyId'];
    $sessionUserId = $_SESSION['user_id'];
    $surveyType = $_POST['surveyType'];

    if ($surveyType === 'unmoderated') {
        if ($select_stmt = $mysqli->prepare("SELECT data FROM study_results_tester WHERE study_id = '$selectStudyId' AND execution_phase = 'real'")) {
            if (!$select_stmt->execute()) {
                echo json_encode(array('status' => 'selectError'));
                exit();
            } else {
                $select_stmt->store_result();
                $select_stmt->bind_result($data);
                $elicitedGestures = null;
                $elicitedTrigger = null;

                while ($select_stmt->fetch()) {
                    $decodedResults = json_decode_nice($data, false);
                    if (isset($decodedResults->phases)) {
                        $phases = $decodedResults->phases;

                        foreach ($phases as $item) {
                            if ($item->format === "identification") {
                                if (isset($item->gestures)) {
                                    $gestures = $item->gestures;
                                    $count = 0;
                                    foreach ($gestures as $gesture) {
                                        $gestureId = $gesture->id;
                                        $triggerId = $gesture->triggerId;

                                        if ($select_gesture_stmt = $mysqli->prepare("SELECT gestures.*, users.forename, users.surname FROM gestures JOIN users ON gestures.owner_id = users.id AND gestures.id = '$gestureId' LIMIT 1")) {
                                            if (!$select_gesture_stmt->execute()) {
                                                echo json_encode(array('status' => 'selectGesturesError'));
                                            } else {

                                                $select_gesture_stmt->store_result();
                                                $select_gesture_stmt->bind_result($originalGestureId, $gestureUserId, $gestureOwnerId, $gestureSource, $gestureScope, $gestureTitle, $gestureTitleQuality, $gestureType, $gestureInteractionType, $gestureContext, $gestureAssociation, $gestureDescription, $gestureJoints, $doubleSidedUse, $gesturePreviewImage, $gestureImages, $gestureGIF, $sensorData, $gestureCreated, $forename, $surname);
                                                $select_gesture_stmt->fetch();

                                                $elicitedGestures[] = array('id' => $originalGestureId,
                                                    'userId' => $gestureUserId,
                                                    'ownerId' => $gestureOwnerId,
                                                    'source' => $gestureSource,
                                                    'scope' => $gestureScope,
                                                    'title' => $gestureTitle,
                                                    'titleQuality' => $gestureTitleQuality,
                                                    'type' => $gestureType,
                                                    'interactionType' => $gestureInteractionType,
                                                    'context' => $gestureContext,
                                                    'association' => $gestureAssociation,
                                                    'description' => $gestureDescription,
                                                    'joints' => json_decode($gestureJoints),
                                                    'doubleSidedUse' => $doubleSidedUse,
                                                    'previewImage' => $gesturePreviewImage,
                                                    'images' => json_decode($gestureImages),
                                                    'gif' => $gestureGIF,
                                                    'sensorData' => json_decode($sensorData),
                                                    'created' => $gestureCreated,
                                                    'isOwner' => $sessionUserId == $gestureOwnerId,
                                                    'triggerId' => $triggerId,
                                                    'forename' => $forename,
                                                    'surname' => $surname[0] . '.');
                                            }
                                            $count++;
                                        } else {
                                            echo json_encode(array('status' => 'selectGestureStatementError'));
                                            exit();
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
                                'data' => json_decode_nice($data, false));
                        }

                        echo json_encode(array('status' => 'success', 'elicitedGestures' => $elicitedGestures, 'elicitedTrigger' => $elicitedTrigger, 'classification' => $classification));
                        exit();
                    }
                } else {
                    echo json_encode(array('status' => 'extractionStatementError'));
                    exit();
                }
            }
        }
    } else if ($surveyType === 'moderated') {
        if ($select_stmt = $mysqli->prepare("SELECT data FROM study_results_evaluator WHERE study_id = '$selectStudyId' AND execution_phase = 'real'")) {
            if (!$select_stmt->execute()) {
                echo json_encode(array('status' => 'selectError'));
                exit();
            } else {
                $select_stmt->store_result();
                $select_stmt->bind_result($data);
                $elicitedGestures = null;
                $elicitedTrigger = null;

                while ($select_stmt->fetch()) {
                    $decodedResults = json_decode_nice($data, false);
                    if (isset($decodedResults->phases)) {
                        $phases = $decodedResults->phases;

                        foreach ($phases as $item) {

                            if ($item->format === "identification") {
                                if (isset($item->gestures)) {
                                    $gestures = $item->gestures;

                                    $count = 0;
                                    foreach ($gestures as $gesture) {
                                        $elicitedGestures[] = array('triggerId' => $gesture->triggerId, 'gestureId' => $gesture->id);
                                    }
                                } else if (isset($item->trigger)) {
                                    $triggers = $item->trigger;
                                    foreach ($triggers as $trigger) {
                                        $triggerId = $trigger->preferredTrigger->answers[0]->id;
                                        $triggerName = $trigger->preferredTrigger->answers[0]->answer->openAnswer;
                                        $justification = $trigger->preferredTrigger->answers[0]->answer->justification;
                                        $gestureId = $trigger->gestureId;
                                        $elicitedTrigger[] = array('id' => $triggerId, 'title' => $triggerName, 'justification' => $justification, 'gestureId' => $gestureId);
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
                                'data' => json_decode_nice($data, false));
                        }

                        if ($select_stmt = $mysqli->prepare("SELECT gestures.*, users.forename, users.surname FROM gestures JOIN users ON users.id = gestures.user_id WHERE (owner_id = '$sessionUserId' && scope = 'private') OR scope = 'public' ORDER BY created DESC")) {
                            // get variables from result.
                            $select_stmt->bind_result($id, $userId, $ownerId, $source, $scope, $title, $titleQuality, $type, $interactionType, $context, $association, $description, $joints, $doubleSidedUse, $previewImage, $images, $gif, $sensorData, $created, $forename, $surname);

                            if (!$select_stmt->execute()) {
                                echo json_encode(array('status' => 'selectError'));
                                exit();
                            } else {
                                $gestures = null;

                                while ($row = $select_stmt->fetch()) {
                                    $commentCount = 0;
                                    $hasCommented = false;

                                    if ($comment_select = $mysqli2->prepare("SELECT user_id FROM comments WHERE gesture_id = '$id'")) {
                                        if (!$comment_select->execute()) {
                                            echo json_encode(array('status' => 'selectError'));
                                            exit();
                                        } else {
                                            $comment_select->bind_result($commentUserId);
                                            while ($comment_select->fetch()) {
                                                $commentCount++;
                                                if ($commentUserId == $sessionUserId) {
                                                    $hasCommented = true;
                                                }
                                            }
                                        }
                                    }

                                    $likeCount = 0;
                                    $hasLiked = false;
                                    if ($likes_select = $mysqli2->prepare("SELECT user_id FROM likes WHERE gesture_id = '$id'")) {
                                        if (!$likes_select->execute()) {
                                            echo json_encode(array('status' => 'selectError'));
                                            exit();
                                        } else {
                                            $likes_select->bind_result($likeUserId);
                                            while ($likes_select->fetch()) {
                                                $likeCount++;
                                                if ($likeUserId == $sessionUserId) {
                                                    $hasLiked = true;
                                                }
                                            }
                                        }
                                    }

                                    $ratingCount = 0;
                                    $hasRated = false;
                                    if ($rating_select = $mysqli2->prepare("SELECT user_id, ratings FROM gesture_ratings WHERE gesture_id = '$id'")) {
                                        if (!$rating_select->execute()) {
                                            echo json_encode(array('status' => 'selectError'));
                                            exit();
                                        } else {
                                            $rating_select->bind_result($ratedUserId, $userRating);
                                            while ($rating_select->fetch()) {
                                                $ratingCount++;
                                                if ($ratedUserId == $sessionUserId) {
                                                    $hasRated = true;
                                                }
                                            }
                                        }
                                    }

                                    $gestures[] = array('id' => $id,
                                        'userId' => $userId,
                                        'ownerId' => $ownerId,
                                        'source' => $source,
                                        'scope' => $scope,
                                        'title' => $title,
                                        'titleQuality' => $titleQuality,
                                        'type' => $type,
                                        'interactionType' => $interactionType,
                                        'context' => $context,
                                        'association' => $association,
                                        'description' => $description,
                                        'joints' => json_decode($joints),
                                        'doubleSidedUse' => $doubleSidedUse,
                                        'previewImage' => $previewImage,
                                        'images' => json_decode($images),
                                        'gif' => $gif,
                                        'sensorData' => json_decode($sensorData),
                                        'created' => $created,
                                        'isOwner' => $sessionUserId == $ownerId,
                                        'commentAmount' => $commentCount,
                                        'hasCommented' => $hasCommented,
                                        'likeAmount' => $likeCount,
                                        'hasLiked' => $hasLiked,
                                        'ratingAmount' => $ratingCount,
                                        'hasRated' => $hasRated,
                                        'forename' => $forename,
                                        'surname' => $surname[0] . '.');
                                }
                            }
                        } else {
                            echo json_encode(array('status' => 'statementError'));
                            exit();
                        }


                        echo json_encode(array('status' => 'success', 'elicitedGestures' => $elicitedGestures, 'elicitedTrigger' => $elicitedTrigger, 'classification' => $classification, 'gestureCatalog' => $gestures));
                        exit();
                    }
                } else {
                    echo json_encode(array('status' => 'extractionStatementError'));
                    exit();
                }
            }
        }
    } else {
        echo json_encode(array('status' => 'noSurveyTypeError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}    