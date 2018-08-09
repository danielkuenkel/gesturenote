<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'])) {
    $sessionUserId = $_SESSION['user_id'];

    if ($select_stmt = $mysqli->prepare("SELECT * FROM gestures WHERE (owner_id = '$sessionUserId' && scope = 'private') OR scope = 'public' ORDER BY created DESC")) {
        // get variables from result.
        $select_stmt->bind_result($id, $userId, $ownerId, $source, $scope, $title, $type, $interactionType, $context, $association, $description, $joints, $previewImage, $images, $gif, $sensorData, $created);

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
                    'type' => $type,
                    'interactionType' => $interactionType,
                    'context' => $context,
                    'association' => $association,
                    'description' => $description,
                    'joints' => json_decode($joints),
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
                    'hasRated' => $hasRated);
            }
            echo json_encode(array('status' => 'success', 'gestures' => $gestures));
            exit();
        }
    } else {
        echo json_encode(array('status' => 'statementError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}