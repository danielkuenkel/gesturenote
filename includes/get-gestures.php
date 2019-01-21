<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

session_start();
if (isset($_SESSION['user_id'])) {
    $sessionUserId = $_SESSION['user_id'];
    $sessionUserMail = $_SESSION['email'];


    // get all own and public gestures
    $gestures = null;
    if ($select_stmt = $mysqli->prepare("SELECT gestures.*, users.forename, users.surname FROM gestures JOIN users ON gestures.owner_id = users.id WHERE ((owner_id = '$sessionUserId' && scope = 'private') OR scope = 'public') ORDER BY created DESC")) {
        $select_stmt->bind_result($id, $userId, $ownerId, $source, $scope, $title, $titleQuality, $type, $interactionType, $context, $association, $description, $joints, $doubleSidedUse, $previewImage, $images, $gif, $sensorData, $created, $forename, $surname);

        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
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

                $invitedUsers = null;
                if ($select_invited_users_stmt = $mysqli2->prepare("SELECT gestures_shared.*, users.forename, users.surname FROM gestures_shared LEFT JOIN users ON gestures_shared.owner_id = users.id WHERE gestures_shared.gesture_id = '$id' AND gestures_shared.owner_id = '$sessionUserId'")) {
                    if (!$select_invited_users_stmt->execute()) {
                        echo json_encode(array('status' => 'selectSharedStudiesError'));
                        exit();
                    } else {
                        $select_invited_users_stmt->store_result();
                        $select_invited_users_stmt->bind_result($sharedStudyRowId, $sharedSetId, $sharedStudyOwner, $invitedUserMail, $sharedStudyEditable, $userInvited, $forenameShared, $surnameShared);

                        while ($select_invited_users_stmt->fetch()) {
                            $hasShared = true;

                            $invitedUsers[] = array('id' => $sharedStudyRowId,
                                'ownerId' => $sharedStudyOwner,
                                'gestureId' => $sharedSetId,
                                'email' => $invitedUserMail,
                                'edit' => $sharedStudyEditable,
                                'created' => $userInvited
                            );
                        }
                    }
                }

                $inviteCount = 0;
                if ($invitedUsers && count($invitedUsers) > 0) {
                    $inviteCount = count($invitedUsers);
                }

                $gestures[] = array(
                    'id' => $id,
                    'userId' => $userId,
                    'ownerId' => $ownerId,
                    'source' => $source,
                    'setOnly' => false,
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
                    'invitedUsers' => $invitedUsers,
                    'forename' => $forename,
                    'surname' => $surname[0] . '.'
                );
            }
        }
    } else {
        echo json_encode(array('status' => 'statementError1'));
        exit();
    }


    // get all explicitly shared gestures with this user
    $sharedGestures = null;
    if ($select_stmt = $mysqli->prepare("SELECT gestures.*, users.forename, users.surname FROM gestures LEFT JOIN gestures_shared ON gestures.id = gestures_shared.gesture_id JOIN users ON users.id = gestures.owner_id WHERE gestures_shared.email = '$sessionUserMail' GROUP BY gestures.id ORDER BY gestures.created ASC")) {
        $select_stmt->bind_result($id, $userId, $ownerId, $source, $scope, $title, $titleQuality, $type, $interactionType, $context, $association, $description, $joints, $doubleSidedUse, $previewImage, $images, $gif, $sensorData, $created, $forename, $surname);

        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
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

                $invitedUsers = null;
//                if ($select_invited_users_stmt = $mysqli2->prepare("SELECT gestures_shared.*, users.forename, users.surname FROM gestures_shared LEFT JOIN users ON gestures_shared.owner_id = users.id WHERE gestures_shared.gesture_id = '$id' AND gestures_shared.owner_id = '$sessionUserId'")) {
//                    if (!$select_invited_users_stmt->execute()) {
//                        echo json_encode(array('status' => 'selectSharedStudiesError'));
//                        exit();
//                    } else {
//                        $select_invited_users_stmt->store_result();
//                        $select_invited_users_stmt->bind_result($sharedStudyRowId, $sharedSetId, $sharedStudyOwner, $invitedUserMail, $sharedStudyEditable, $userInvited, $forenameShared, $surnameShared);
//
//                        while ($select_invited_users_stmt->fetch()) {
//                            $hasShared = true;
//
//                            $invitedUsers[] = array('id' => $sharedStudyRowId,
//                                'ownerId' => $sharedStudyOwner,
//                                'gestureId' => $sharedSetId,
//                                'email' => $invitedUserMail,
//                                'edit' => $sharedStudyEditable,
//                                'created' => $userInvited
//                            );
//                        }
//                    }
//                }

                $inviteCount = 0;
                if ($invitedUsers && count($invitedUsers) > 0) {
                    $inviteCount = count($invitedUsers);
                }

                $sharedGestures[] = array(
                    'id' => $id,
                    'userId' => $userId,
                    'ownerId' => $ownerId,
                    'source' => $source,
                    'setOnly' => false,
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
                    'invitedUsers' => $invitedUsers,
                    'forename' => $forename,
                    'surname' => $surname[0] . '.'
                );
            }
        }
    } else {
        echo json_encode(array('status' => 'statementError1'));
        exit();
    }


    // get all gestures in shared gesture sets, which are shared explicitly
    $sharedSetGesturesArray = null;
    if ($select_shared_stmt = $mysqli->prepare("SELECT gesture_sets.gestures FROM gesture_sets LEFT JOIN gesture_sets_shared ON gesture_sets.id = gesture_sets_shared.set_id WHERE gesture_sets_shared.email = '$sessionUserMail' OR gesture_sets.scope = 'public' GROUP BY gesture_sets.id ORDER BY gesture_sets.created ASC")) {
        $select_shared_stmt->bind_result($sharedSetGestures);

        if (!$select_shared_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_shared_stmt->store_result();

            $select_shared_stmt->store_result();
            if ($select_shared_stmt->num_rows > 0) {
                while ($select_shared_stmt->fetch()) {
                    $decodedGestures = json_decode($sharedSetGestures);
                    if ($decodedGestures) {
                        $comma_separated = implode(",", $decodedGestures);

                        if ($select_stmt = $mysqli2->prepare("SELECT gestures.*, users.forename, users.surname FROM gestures JOIN users ON gestures.owner_id = users.id WHERE gestures.id IN ($comma_separated) ORDER BY created DESC")) {
                            $select_stmt->bind_result($id, $userId, $ownerId, $source, $scope, $title, $titleQuality, $type, $interactionType, $context, $association, $description, $joints, $doubleSidedUse, $previewImage, $images, $gif, $sensorData, $created, $forename, $surname);

                            if (!$select_stmt->execute()) {
                                echo json_encode(array('status' => 'selectErrorCommaGestures'));
                                exit();
                            } else {
                                while ($row = $select_stmt->fetch()) {
                                    $commentCount = 0;
                                    $hasCommented = false;

                                    if ($comment_select = $mysqli3->prepare("SELECT user_id FROM comments WHERE gesture_id = '$id'")) {
                                        if (!$comment_select->execute()) {
                                            echo json_encode(array('status' => 'selectCommentsError'));
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
                                    if ($likes_select = $mysqli3->prepare("SELECT user_id FROM likes WHERE gesture_id = '$id'")) {
                                        if (!$likes_select->execute()) {
                                            echo json_encode(array('status' => 'selectLikesError'));
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
                                    if ($rating_select = $mysqli3->prepare("SELECT user_id, ratings FROM gesture_ratings WHERE gesture_id = '$id'")) {
                                        if (!$rating_select->execute()) {
                                            echo json_encode(array('status' => 'selectRatingsError'));
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

                                    $invitedUsers = null;
                                    if ($select_invited_users_stmt = $mysqli3->prepare("SELECT gestures_shared.*, users.forename, users.surname FROM gestures_shared LEFT JOIN users ON gestures_shared.owner_id = users.id WHERE gestures_shared.gesture_id = '$id'")) {
                                        if (!$select_invited_users_stmt->execute()) {
                                            echo json_encode(array('status' => 'selectSharedStudiesError'));
                                            exit();
                                        } else {
                                            $select_invited_users_stmt->store_result();
                                            $select_invited_users_stmt->bind_result($sharedStudyRowId, $sharedSetId, $sharedStudyOwner, $invitedUserMail, $sharedStudyEditable, $userInvited, $forenameShared, $surnameShared);

                                            while ($select_invited_users_stmt->fetch()) {
                                                $hasShared = true;

                                                $invitedUsers[] = array('id' => $sharedStudyRowId,
                                                    'ownerId' => $sharedStudyOwner,
                                                    'gestureId' => $sharedSetId,
                                                    'email' => $invitedUserMail,
                                                    'edit' => $sharedStudyEditable,
                                                    'created' => $userInvited
                                                );
                                            }
                                        }
                                    }

                                    $inviteCount = 0;
                                    if ($invitedUsers && count($invitedUsers) > 0) {
                                        $inviteCount = count($invitedUsers);
                                    }

                                    $sharedSetGesturesArray[] = array(
                                        'id' => $id,
                                        'userId' => $userId,
                                        'ownerId' => $ownerId,
                                        'source' => $source,
                                        'setOnly' => true,
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
                                        'invitedUsers' => $invitedUsers,
                                        'forename' => $forename,
                                        'surname' => $surname[0] . '.'
                                    );
                                }
                            }
                        } else {
                            echo json_encode(array('status' => 'statementError2'));
                            exit();
                        }
                    }
                }
            } else {
                
            }
        }
    } else {
        echo json_encode(array('status' => 'statementError3'));
        exit();
    }



    // get all gestures (private and public) in gesture sets, which are not shared explicitly
    $unsharedSetGesturesArray = null;
    if ($select_shared_stmt = $mysqli->prepare("SELECT gestures FROM gesture_sets WHERE user_id = '$sessionUserId' AND scope = 'private' ORDER BY created ASC")) {
        $select_shared_stmt->bind_result($unsharedSetGestures);

        if (!$select_shared_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_shared_stmt->store_result();

            $select_shared_stmt->store_result();
            if ($select_shared_stmt->num_rows > 0) {
                while ($select_shared_stmt->fetch()) {
                    $decodedGestures = json_decode($unsharedSetGestures);
                    if ($decodedGestures) {
                        $comma_separated = implode(",", $decodedGestures);

                        if ($select_stmt = $mysqli2->prepare("SELECT gestures.*, users.forename, users.surname FROM gestures JOIN users ON gestures.owner_id = users.id WHERE gestures.id IN ($comma_separated) ORDER BY created DESC")) {
                            $select_stmt->bind_result($id, $userId, $ownerId, $source, $scope, $title, $titleQuality, $type, $interactionType, $context, $association, $description, $joints, $doubleSidedUse, $previewImage, $images, $gif, $sensorData, $created, $forename, $surname);

                            if (!$select_stmt->execute()) {
                                echo json_encode(array('status' => 'selectErrorCommaGestures'));
                                exit();
                            } else {
                                while ($row = $select_stmt->fetch()) {

                                    $commentCount = 0;
                                    $hasCommented = false;

                                    if ($comment_select = $mysqli3->prepare("SELECT user_id FROM comments WHERE gesture_id = '$id'")) {
                                        if (!$comment_select->execute()) {
                                            echo json_encode(array('status' => 'selectCommentsError'));
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
                                    if ($likes_select = $mysqli3->prepare("SELECT user_id FROM likes WHERE gesture_id = '$id'")) {
                                        if (!$likes_select->execute()) {
                                            echo json_encode(array('status' => 'selectLikesError'));
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
                                    if ($rating_select = $mysqli3->prepare("SELECT user_id, ratings FROM gesture_ratings WHERE gesture_id = '$id'")) {
                                        if (!$rating_select->execute()) {
                                            echo json_encode(array('status' => 'selectRatingsError'));
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

                                    $invitedUsers = null;
                                    if ($select_invited_users_stmt = $mysqli3->prepare("SELECT gestures_shared.*, users.forename, users.surname FROM gestures_shared LEFT JOIN users ON gestures_shared.owner_id = users.id WHERE gestures_shared.gesture_id = '$id'")) {
                                        if (!$select_invited_users_stmt->execute()) {
                                            echo json_encode(array('status' => 'selectSharedStudiesError'));
                                            exit();
                                        } else {
                                            $select_invited_users_stmt->store_result();
                                            $select_invited_users_stmt->bind_result($sharedStudyRowId, $sharedSetId, $sharedStudyOwner, $invitedUserMail, $sharedStudyEditable, $userInvited, $forenameShared, $surnameShared);

                                            while ($select_invited_users_stmt->fetch()) {
                                                $hasShared = true;

                                                $invitedUsers[] = array('id' => $sharedStudyRowId,
                                                    'ownerId' => $sharedStudyOwner,
                                                    'gestureId' => $sharedSetId,
                                                    'email' => $invitedUserMail,
                                                    'edit' => $sharedStudyEditable,
                                                    'created' => $userInvited
                                                );
                                            }
                                        }
                                    }

                                    $inviteCount = 0;
                                    if ($invitedUsers && count($invitedUsers) > 0) {
                                        $inviteCount = count($invitedUsers);
                                    }

                                    if (intval($ownerId) !== intval($sessionUserId)) {
                                        $unsharedSetGesturesArray[] = array(
                                            'id' => $id,
                                            'userId' => $userId,
                                            'ownerId' => $ownerId,
                                            'source' => $source,
                                            'setOnly' => true,
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
                                            'invitedUsers' => $invitedUsers,
                                            'forename' => $forename,
                                            'surname' => $surname[0] . '.'
                                        );
                                    }
                                }
                            }
                        } else {
                            echo json_encode(array('status' => 'statementError2'));
                            exit();
                        }
                    }
                }
            } else {
                
            }
        }
    } else {
        echo json_encode(array('status' => 'statementError4'));
        exit();
    }

    echo json_encode(array('status' => 'success', 'gestures' => $gestures, 'sharedSetGestures' => $sharedSetGesturesArray, 'sharedGestures' => $sharedGestures, 'unsharedSetGestures' => $unsharedSetGesturesArray));
    exit();
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}