<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'])) {
    $sessionUserId = $_SESSION['user_id'];

    if ($select_stmt = $mysqli->prepare("SELECT * FROM users WHERE id = '$sessionUserId' LIMIT 1")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->bind_result($id, $forename, $surname, $email, $password, $birthday, $gender, $userType, $created, $passwordReset, $tutorialStudyCreation, $tutorialStudyPreview, $tutorialStudy, $tutorialParticipant, $tutorialGestureCatalog);
            $select_stmt->store_result();
            $select_stmt->fetch();
            if ($select_stmt->num_rows == 1) {

                $totalStudies = 0;
                if ($studies_select_stmt = $mysqli2->prepare("SELECT id FROM studies WHERE user_id = '$sessionUserId'")) {
                    if (!$studies_select_stmt->execute()) {
                        echo json_encode(array('status' => 'selectError'));
                        exit();
                    } else {
                        $studies_select_stmt->store_result();
                        $studies_select_stmt->fetch();
                        $totalStudies = $studies_select_stmt->num_rows;
                    }
                }

                $totalGestures = 0;
                if ($gestures_select_stmt = $mysqli2->prepare("SELECT id FROM gestures WHERE user_id = '$sessionUserId'")) {
                    if (!$gestures_select_stmt->execute()) {
                        echo json_encode(array('status' => 'selectError'));
                        exit();
                    } else {
                        $gestures_select_stmt->store_result();
                        $gestures_select_stmt->fetch();
                        $totalGestures = $gestures_select_stmt->num_rows;
                    }
                }

                $sharedGestures = 0;
                if ($shared_gestures_select_stmt = $mysqli2->prepare("SELECT id FROM gestures WHERE user_id = '$sessionUserId' AND scope='public'")) {
                    if (!$shared_gestures_select_stmt->execute()) {
                        echo json_encode(array('status' => 'selectError'));
                        exit();
                    } else {
                        $shared_gestures_select_stmt->store_result();
                        $shared_gestures_select_stmt->fetch();
                        $sharedGestures = $shared_gestures_select_stmt->num_rows;
                    }
                }

                $likedGestures = 0;
                if ($liked_gestures_select_stmt = $mysqli2->prepare("SELECT id FROM likes WHERE user_id = '$sessionUserId'")) {
                    if (!$liked_gestures_select_stmt->execute()) {
                        echo json_encode(array('status' => 'selectError'));
                        exit();
                    } else {
                        $liked_gestures_select_stmt->store_result();
                        $liked_gestures_select_stmt->fetch();
                        $likedGestures = $liked_gestures_select_stmt->num_rows;
                    }
                }

                $ratedGestures = 0;
                if ($rated_gestures_select_stmt = $mysqli2->prepare("SELECT id FROM gesture_ratings WHERE user_id = '$sessionUserId'")) {
                    if (!$rated_gestures_select_stmt->execute()) {
                        echo json_encode(array('status' => 'selectError'));
                        exit();
                    } else {
                        $rated_gestures_select_stmt->store_result();
                        $rated_gestures_select_stmt->fetch();
                        $ratedGestures = $rated_gestures_select_stmt->num_rows;
                    }
                }

                $statistics = array('totalStudies' => $totalStudies, 'totalGestures' => $totalGestures, 'sharedGestures' => $sharedGestures, 'likedGestures' => $likedGestures, 'ratedGestures' => $ratedGestures);

                $user[] = array('id' => $id,
                    'forename' => $forename,
                    'surname' => $surname,
                    'email' => $email,
//                    'birthday' => $birthday,
//                    'gender' => $userType,
//                    'userType' => $userType,
                    'created' => $created,
                    'tutorialStudyCreation' => $tutorialStudyCreation,
                    'tutorialStudyPreview' => $tutorialStudyPreview,
                    'tutorialStudy' => $tutorialStudy,
                    'tutorialParticipant' => $tutorialParticipant,
                    'tutorialGestureCatalog' => $tutorialGestureCatalog,
                    'statistics' => $statistics);

                echo json_encode(array('status' => 'success', 'user' => $user));
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