<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'functions.php';
include_once 'psl-config.php';

$target_dir = "../";

session_start();
if (isset($_SESSION['user_id'], $_POST['studyId'], $_POST['testerId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $deleteStudyId = $_POST['studyId'];
    $testerId = $_POST['testerId'];

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

//                if (isset($decodedData->assembledScenes)) {
//                    $assembledScenes = $decodedData->assembledScenes;
//                    foreach ($assembledScenes as $scene) {
//                        if ($scene->type === 'image') {
//                            array_push($deleteFiles, $scene->data);
//                        }
//                    }
//                }
//
//                if (isset($decodedData->assembledFeedback)) {
//                    $assembledFeedback = $decodedData->assembledFeedback;
//                    foreach ($assembledFeedback as $feedback) {
//                        if ($feedback->type === 'sound') {
//                            array_push($deleteFiles, $feedback->data);
//                        }
//                    }
//                }

                if ($tester_results_select_stmt = $mysqli->prepare("SELECT data FROM study_results_tester WHERE study_id = '$deleteStudyId' && user_id = '$testerId'")) {
                    if (!$tester_results_select_stmt->execute()) {
                        echo json_encode(array('status' => 'testerResultsSelectError'));
                        exit();
                    } else {
                        $tester_results_select_stmt->store_result();
                        $tester_results_select_stmt->bind_result($testerResults);

                        while ($tester_results_select_stmt->fetch()) {
                            $decodedTesterResultData = json_decode_nice($testerResults, false);
                            if (isset($decodedTesterResultData->phases)) {
                                $phases = $decodedTesterResultData->phases;
                                foreach ($phases as $item) {
                                    if (isset($item->recordUrl)) {
                                        $recordUrl = 'uploads/' . $item->recordUrl;
                                        array_push($deleteFiles, $recordUrl);
                                    }
                                }
                            }

                            if (isset($decodedTesterResultData->snapshot)) {
                                array_push($deleteFiles, $decodedTesterResultData->snapshot);
                            }
                        }
                    }
                }

                if ($evaluator_results_select_stmt = $mysqli->prepare("SELECT data FROM study_results_evaluator WHERE study_id = '$deleteStudyId' && tester_id = '$testerId'")) {
                    if (!$evaluator_results_select_stmt->execute()) {
                        echo json_encode(array('status' => 'testerResultsSelectError'));
                        exit();
                    } else {
                        $evaluator_results_select_stmt->store_result();
                        $evaluator_results_select_stmt->bind_result($evaluatorResults);

                        while ($evaluator_results_select_stmt->fetch()) {
                            $decodedEvaluatorResultData = json_decode_nice($evaluatorResults, false);
                            if (isset($decodedEvaluatorResultData->phases)) {
                                $phases = $decodedEvaluatorResultData->phases;
                                foreach ($phases as $item) {
                                    if (isset($item->recordUrl)) {
                                        $recordUrl = 'uploads/' . $item->recordUrl;
                                        array_push($deleteFiles, $recordUrl);
                                    }

                                    if (isset($item->screenRecordUrl)) {
                                        $screenRecordUrl = 'uploads/' . $item->screenRecordUrl;
                                        array_push($deleteFiles, $screenRecordUrl);
                                    }
                                }
                            }
                        }
                    }
                }

                if ($wizard_results_select_stmt = $mysqli->prepare("SELECT data FROM study_results_wizard WHERE study_id = '$deleteStudyId' && tester_id = '$testerId'")) {
                    if (!$wizard_results_select_stmt->execute()) {
                        echo json_encode(array('status' => 'testerResultsSelectError'));
                        exit();
                    } else {
                        $wizard_results_select_stmt->store_result();
                        $wizard_results_select_stmt->bind_result($wizardResults);

                        while ($wizard_results_select_stmt->fetch()) {
                            $decodedWizardResultData = json_decode_nice($wizardResults, false);
                            if (isset($decodedWizardResultData->phases)) {
                                $phases = $decodedWizardResultData->phases;
                                foreach ($phases as $item) {
                                    if (isset($item->recordUrl)) {
                                        $recordUrl = 'uploads/' . $item->recordUrl;
                                        array_push($deleteFiles, $recordUrl);
                                    }

                                    if (isset($item->screenRecordUrl)) {
                                        $screenRecordUrl = 'uploads/' . $item->screenRecordUrl;
                                        array_push($deleteFiles, $screenRecordUrl);
                                    }
                                }
                            }
                        }
                    }
                }

                if ($delete_stmt = $mysqli->prepare("DELETE FROM study_results_tester WHERE study_id = '$deleteStudyId' && user_id = '$testerId'")) {
                    if (!$delete_stmt->execute()) {
                        echo json_encode(array('status' => 'deleteTesterResultsError'));
                        exit();
                    }
                } else {
                    echo json_encode(array('status' => 'deleteTesterResultsStatemantError'));
                    exit();
                }

                if ($delete_stmt = $mysqli->prepare("DELETE FROM study_results_evaluator WHERE study_id = '$deleteStudyId' && tester_id = '$testerId'")) {
                    if (!$delete_stmt->execute()) {
                        echo json_encode(array('status' => 'deleteEvaluatorResultsError'));
                        exit();
                    }
                } else {
                    echo json_encode(array('status' => 'deleteEvaluatorResultsStatemantError'));
                    exit();
                }

                if ($delete_stmt = $mysqli->prepare("DELETE FROM study_results_wizard WHERE study_id = '$deleteStudyId' && tester_id = '$testerId'")) {
                    if (!$delete_stmt->execute()) {
                        echo json_encode(array('status' => 'deleteWizardResultsError'));
                        exit();
                    }
                } else {
                    echo json_encode(array('status' => 'deleteWizardResultsStatemantError'));
                    exit();
                }

                $deleteFiles = array_filter($deleteFiles);
                if (!empty($deleteFiles)) {
                    deleteFiles($target_dir, $deleteFiles);
                }

                echo json_encode(array('status' => 'success', 'deletedFiles' => $deleteFiles));
                exit();

//                if ($delete_stmt = $mysqli->prepare("DELETE FROM studies WHERE id = '$deleteStudyId' && user_id = '$sessionUserId'")) {
//                    if (!$delete_stmt->execute()) {
//                        echo json_encode(array('status' => 'deleteError'));
//                        exit();
//                    } else {
//                        
//                    }
//                } else {
//                    echo json_encode(array('status' => 'deleteStatemantError'));
//                    exit();
//                }
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