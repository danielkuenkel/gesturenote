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
                $invitedUsers = null;
                $decodedData = json_decode_nice($studyData, false);

                if ($select_invited_users_stmt = $mysqli->prepare("SELECT * FROM studies_shared WHERE study_id = '$studyId' AND owner_id = '$sessionUserId'")) {
                    if (!$select_invited_users_stmt->execute()) {
                        echo json_encode(array('status' => 'selectSharedStudiesError'));
                    } else {
                        $select_invited_users_stmt->store_result();
                        $select_invited_users_stmt->bind_result($sharedStudyRowId, $sharedStudyId, $sharedStudyOwner, $invitedUserMail, $sharedStudyEditable, $userInvited);

                        while ($select_invited_users_stmt->fetch()) {
                            $invitedUsers[] = array('id' => $sharedStudyRowId,
                                'ownerId' => $sharedStudyId,
                                'email' => $invitedUserMail,
                                'edit' => $sharedStudyEditable,
                                'created' => $userInvited
                            );
                        }
                    }
                }

                if ($select_gesture_stmt = $mysqli->prepare("SELECT gestures.*, users.forename, users.surname FROM gestures JOIN users ON users.id = gestures.owner_id")) {
                    if (!$select_gesture_stmt->execute()) {
                        echo json_encode(array('status' => 'selectGesturesError'));
                    } else {

                        $select_gesture_stmt->store_result();
                        $select_gesture_stmt->bind_result($originalGestureId, $gestureUserId, $gestureOwnerId, $gestureSource, $gestureScope, $gestureTitle, $gestureTitleQuality, $gestureType, $gestureInteractionType, $gestureContinuousValueType, $gestureContext, $gestureAssociation, $gestureDescription, $gestureJoints, $doubleSidedUse, $gesturePreviewImage, $gestureImages, $gestureGIF, $sensorData, $gestureCreated, $forename, $surname);

                        while ($select_gesture_stmt->fetch()) {
                            $commentCount = 0;
                            $hasCommented = false;
                            if ($comment_select = $mysqli2->prepare("SELECT user_id FROM comments WHERE gesture_id = '$originalGestureId'")) {
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
                            if ($likes_select = $mysqli2->prepare("SELECT user_id FROM likes WHERE gesture_id = '$originalGestureId'")) {
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
                            if ($rating_select = $mysqli2->prepare("SELECT user_id, ratings FROM gesture_ratings WHERE gesture_id = '$originalGestureId'")) {
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

                            $gestures[] = array('id' => $originalGestureId,
                                'userId' => $gestureUserId,
                                'ownerId' => $gestureOwnerId,
                                'source' => $gestureSource,
                                'scope' => $gestureScope,
                                'title' => $gestureTitle,
                                'titleQuality' => $gestureTitleQuality,
                                'type' => $gestureType,
                                'interactionType' => $gestureInteractionType,
                                'continuousValueType' => $gestureContinuousValueType,
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
                                'commentAmount' => $commentCount,
                                'hasCommented' => $hasCommented,
                                'likeAmount' => $likeCount,
                                'hasLiked' => $hasLiked,
                                'ratingAmount' => $ratingCount,
                                'hasRated' => $hasRated,
                                'isOwner' => strcmp($gestureOwnerId, $sessionUserId) == 0,
                                'forename' => $forename,
                                'surname' => $surname[0] . '.');
                        }
                    }
                }

                $isStudyOwner = intval($sessionUserId) === intval($studyUserId);
                echo json_encode(array('status' => 'success', 'id' => $studyId, 'userId' => $studyUserId, 'sessionUserId' => $sessionUserId, 'isOwner' => $isStudyOwner, 'studyData' => $decodedData, 'urlToken' => $urlToken, 'created' => $studyCreated, 'invitedUsers' => $invitedUsers, 'gestureCatalog' => $gestures));
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
    