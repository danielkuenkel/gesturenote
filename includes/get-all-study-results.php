<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['studyId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $currentStudyId = $_POST['studyId'];

    if ($select_stmt = $mysqli->prepare("SELECT * FROM study_results_tester WHERE study_id = '$currentStudyId' ORDER BY created DESC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $results = null;
            $select_stmt->store_result();
            $select_stmt->bind_result($id, $studyId, $userId, $data, $executionPhase, $created);
            while ($select_stmt->fetch()) {

                $encodedEvaluatorResultData = null;
                if ($select_evaluator_stmt = $mysqli2->prepare("SELECT data, observations, notes FROM study_results_evaluator WHERE tester_id = '$userId' AND execution_phase = 'real' LIMIT 1")) {
                    if (!$select_evaluator_stmt->execute()) {
                        echo json_encode(array('status' => 'selectEvaluatorError'));
                        exit();
                    } else {
                        $select_evaluator_stmt->store_result();
                        $select_evaluator_stmt->bind_result($evaluatorResultData, $evaluatorObservations, $evaluatorNotes);
                        $select_evaluator_stmt->fetch();

                        if ($select_evaluator_stmt->num_rows == 1) {
                            $encodedEvaluatorResultData = json_decode_nice($evaluatorResultData);
                            $encodedEvaluatorResultData['observations'] = json_decode_nice($evaluatorObservations);
                            $encodedEvaluatorResultData['notes'] = json_decode_nice($evaluatorNotes);
                        }
                    }
                } else {
                    echo json_encode(array('status' => 'evaluatorStatemantError', 'forUser' => $userId));
                    exit();
                }

                $encodedObserverResultData = null;
                if ($select_evaluator_stmt = $mysqli2->prepare("SELECT data FROM study_results_observer WHERE tester_id = '$userId' AND execution_phase = 'real' LIMIT 1")) {
                    if (!$select_evaluator_stmt->execute()) {
                        echo json_encode(array('status' => 'selectObserverError'));
                        exit();
                    } else {
                        $select_evaluator_stmt->store_result();
                        $select_evaluator_stmt->bind_result($observerResultData);
                        $select_evaluator_stmt->fetch();

                        if ($select_evaluator_stmt->num_rows == 1) {
                            $encodedObserverResultData = json_decode_nice($observerResultData);
                        }
                    }
                } else {
                    echo json_encode(array('status' => 'observerStatemantError', 'forUser' => $userId));
                    exit();
                }

                $encodedWizardResultData = null;
                if ($select_evaluator_stmt = $mysqli2->prepare("SELECT data FROM study_results_wizard WHERE tester_id = '$userId' AND execution_phase = 'real' LIMIT 1")) {
                    if (!$select_evaluator_stmt->execute()) {
                        echo json_encode(array('status' => 'selectWizardError'));
                        exit();
                    } else {
                        $select_evaluator_stmt->store_result();
                        $select_evaluator_stmt->bind_result($wizardResultData);
                        $select_evaluator_stmt->fetch();

                        if ($select_evaluator_stmt->num_rows == 1) {
                            $encodedWizardResultData = json_decode_nice($wizardResultData);
                        }
                    }
                } else {
                    echo json_encode(array('status' => 'wizardStatemantError', 'forUser' => $userId));
                    exit();
                }

                $encodedTesterResultData = json_decode_nice($data, false);

                $results[] = array(
                    'id' => $id,
                    'studyId' => $studyId,
                    'userId' => $userId,
                    'testerResultData' => $encodedTesterResultData,
                    'evaluatorResultData' => $encodedEvaluatorResultData,
                    'observerResultData' => $encodedObserverResultData,
                    'wizardResultData' => $encodedWizardResultData,
                    'created' => $created);
            }

            if ($select_stmt = $mysqli->prepare("SELECT gestures.*, users.forename, users.surname FROM gestures JOIN users ON users.id = gestures.owner_id ORDER BY created DESC")) {
                if (!$select_stmt->execute()) {
                    echo json_encode(array('status' => 'selectGesturesError'));
                    exit();
                } else {
                    $select_stmt->bind_result($gestureId, $gestureUserId, $gestureOwnerId, $gestureSource, $gestureScope, $gestureTitle, $gestureTitleQuality, $gestureType, $gestureInteractionType, $continuousValueType, $gestureContext, $gestureAssociation, $gestureDescription, $gestureJoints, $doubleSidedUse, $gesturePreviewImage, $gestureImages, $gestureGIF, $sensorData, $gestureCreated, $forename, $surname);
                    while ($select_stmt->fetch()) {
                        $gestureCatalog[] = array('id' => $gestureId,
                            'userId' => $gestureUserId,
                            'ownerId' => $gestureOwnerId,
                            'source' => $gestureSource,
                            'scope' => $gestureScope,
                            'title' => $gestureTitle,
                            'titleQuality' => $gestureTitleQuality,
                            'type' => $gestureType,
                            'interactionType' => $gestureInteractionType,
                            'continuousValueType' => $continuousValueType,
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
                            'isOwner' => strcmp($gestureOwnerId, $sessionUserId) == 0,
                            'forename' => $forename,
                            'surname' => $surname[0] . '.');
                    }
                }
            } else {
                echo json_encode(array('status' => 'selectGesturesStatementError'));
                exit();
            }

            $decodedStudyData = null;
            $isStudyOwner = false;
            
            if ($select_stmt = $mysqli->prepare("SELECT user_id, general_data FROM studies WHERE id = '$currentStudyId' LIMIT 1")) {
                if (!$select_stmt->execute()) {
                    echo json_encode(array('status' => 'selectStudyError'));
                    exit();
                } else {
                    $select_stmt->bind_result($studyUserId, $studyData);
                    $select_stmt->store_result();
                    $select_stmt->fetch();
                    if ($select_stmt->num_rows == 1) {
                        $decodedStudyData = json_decode_nice($studyData, false);
                        $isStudyOwner = intval($sessionUserId) === intval($studyUserId);
                    }
                }
            } else {
                echo json_encode(array('status' => 'selectStudyStatementError'));
                exit();
            }

            echo json_encode(array('status' => 'success', 'allStudyResults' => $results, 'gestureCatalog' => $gestureCatalog, 'studyData' => $decodedStudyData, 'isOwner' => $isStudyOwner));
            exit();
        }
    } else {
        echo json_encode(array('status' => 'statemantError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}