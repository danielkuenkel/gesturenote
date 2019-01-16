<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

$target_dir = "../";

session_start();
if (isset($_SESSION['user_id']) && isset($_POST['gestureId'])) {
    $gestureId = $_POST['gestureId'];
    $userId = $_SESSION['user_id'];

    if (isLocalhost()) {
        $target_dir = "http://localhost/gesturenote/";
    }

    if ($select_stmt = $mysqli->prepare("SELECT `images`, `gif`, `sensor_data` FROM gestures WHERE id = '$gestureId'")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($imageURLs, $gifUrl, $sensorData);
            $select_stmt->fetch();

            if ($select_stmt->num_rows == 1) {
                if ($delete_stmt = $mysqli->prepare("DELETE FROM gestures WHERE id = '$gestureId'")) {
//                    $delete_stmt->bind_param('ii', $gestureId, $gestureId);
                    if (!$delete_stmt->execute()) {
                        echo json_encode(array('status' => 'deleteError'));
                        exit();
                    } else {
                        $deleteFiles = array();
                        if ($delete_stmt = $mysqli->prepare("DELETE FROM comments WHERE gesture_id = '$gestureId'")) {
                            if (!$delete_stmt->execute()) {
                                echo json_encode(array('status' => 'deleteError'));
                                exit();
                            } else {
                                if ($imageURLs !== NULL || $imageURLs !== '') {
                                    $deleteFiles = json_decode($imageURLs);
                                }
                                if ($gifUrl !== NULL || $imageURLs !== '') {
                                    array_push($deleteFiles, $gifUrl);
                                }
                                $parseSensorData = json_decode($sensorData);
                                if ($sensorData !== NULL && $sensorData !== '' && $parseSensorData->url) {
                                    array_push($deleteFiles, $parseSensorData->url);
                                }

                                $deleteFiles = array_filter($deleteFiles);
                                if (!empty($deleteFiles)) {
                                    deleteFiles($target_dir, $deleteFiles);
                                }
                            }
                        } else {
                            echo json_encode(array('status' => 'deleteCommentsStatemantError'));
                            exit();
                        }

                        if ($delete_stmt = $mysqli->prepare("DELETE FROM gesture_ratings WHERE gesture_id = '$gestureId'")) {
                            if (!$delete_stmt->execute()) {
                                echo json_encode(array('status' => 'deleteError'));
                                exit();
                            }
                        } else {
                            echo json_encode(array('status' => 'deleteRatingsStatemantError'));
                            exit();
                        }

                        if ($delete_stmt = $mysqli->prepare("DELETE FROM likes WHERE gesture_id = '$gestureId'")) {
                            if (!$delete_stmt->execute()) {
                                echo json_encode(array('status' => 'deleteError'));
                                exit();
                            }
                        } else {
                            echo json_encode(array('status' => 'deleteLikeStatemantError'));
                            exit();
                        }
                        
                        if ($delete_stmt = $mysqli->prepare("DELETE FROM gestures_shared WHERE gesture_id = '$gestureId'")) {
                            if (!$delete_stmt->execute()) {
                                echo json_encode(array('status' => 'deleteError'));
                                exit();
                            }
                        } else {
                            echo json_encode(array('status' => 'deleteSharedStatemantError'));
                            exit();
                        }

                        echo json_encode(array('status' => 'success', 'gestureId' => $gestureId));
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