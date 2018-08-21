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

    if ($select_stmt = $mysqli->prepare("SELECT * FROM gesture_sets WHERE (user_id = '$sessionUserId' && scope = 'private') OR scope = 'public' ORDER BY created DESC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($id, $studyId, $userId, $scope, $title, $gestures, $sensorData, $created);

            $gestureSets;

            while ($select_stmt->fetch()) {
                $commentCount = 0;
                $hasCommented = false;
                if ($comment_select = $mysqli2->prepare("SELECT user_id FROM comments_gesture_sets WHERE set_id = '$id'")) {
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
                if ($likes_select = $mysqli2->prepare("SELECT user_id FROM likes_sets WHERE set_id = '$id'")) {
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

                $sharedCount = 0;
                $hasShared = false;
//                if ($shares_select = $mysqli2->prepare("SELECT user_id FROM gesture_set_shared WHERE set_id = '$id'")) {
//                    if (!$shares_select->execute()) {
//                        echo json_encode(array('status' => 'selectError'));
//                        exit();
//                    } else {
//                        $shares_select->bind_result($sharedUserId);
//                        while ($shares_select->fetch()) {
//                            $sharedCount++;
//                            $hasShared = true;
//                        }
//                    }
//                }

                $invitedUsers = null;
                if ($select_invited_users_stmt = $mysqli2->prepare("SELECT gesture_sets_shared.*, users.forename, users.surname FROM gesture_sets_shared LEFT JOIN users ON gesture_sets_shared.owner_id = users.id WHERE gesture_sets_shared.set_id = '$id' AND gesture_sets_shared.owner_id = '$sessionUserId'")) {
                    if (!$select_invited_users_stmt->execute()) {
                        echo json_encode(array('status' => 'selectSharedStudiesError'));
                        exit();
                    } else {
                        $select_invited_users_stmt->store_result();
                        $select_invited_users_stmt->bind_result($sharedStudyRowId, $sharedSetId, $sharedStudyOwner, $invitedUserMail, $sharedStudyEditable, $userInvited, $forename, $surname);

                        while ($select_invited_users_stmt->fetch()) {
                            $sharedCount++;
                            $hasShared = true;

                            $invitedUsers[] = array('id' => $sharedStudyRowId,
                                'ownerId' => $sharedStudyOwner,
                                'setId' => $sharedSetId,
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

                $gestureSets[] = array(
                    'id' => $id,
                    'studyId' => $studyId,
                    'userId' => $userId,
                    'scope' => $scope,
                    'title' => json_decode_nice($title, false),
                    'gestures' => json_decode_nice($gestures, false),
                    'hasLiked' => $hasLiked,
                    'likeAmount' => $likeCount,
                    'isOwner' => $sessionUserId == $userId,
                    'commentAmount' => $commentCount,
                    'hasCommented' => $hasCommented,
                    'created' => $created,
                    'invitedUsers' => $invitedUsers
                );
            }
        }
    } else {
        echo json_encode(array('status' => 'statemantCommentsError'));
        exit();
    }


    // get all gesture sets, which were shared with you
    if ($select_shared_stmt = $mysqli->prepare("SELECT gesture_sets.* FROM gesture_sets LEFT JOIN gesture_sets_shared ON gesture_sets.id = gesture_sets_shared.set_id WHERE gesture_sets_shared.email = '$sessionUserMail' GROUP BY gesture_sets.id ORDER BY gesture_sets.created ASC")) {
        if (!$select_shared_stmt->execute()) {
            echo json_encode(array('status' => 'selectInvitedError'));
            exit();
        } else {
            $select_shared_stmt->bind_result($id, $studyId, $userId, $scope, $title, $gestures, $sensorData, $created);
            $invitedGestureSets = null;

            while ($select_shared_stmt->fetch()) {
                $commentCount = 0;
                $hasCommented = false;
                if ($comment_select = $mysqli2->prepare("SELECT user_id FROM comments_gesture_sets WHERE set_id = '$id'")) {
                    if (!$comment_select->execute()) {
                        echo json_encode(array('status' => 'selectError'));
                        exit();
                    } else {
                        $comment_select->bind_result($commentUserId);
                        while ($comment_select->fetch()) {
                            $commentCount++;
                            if (intval($commentUserId) == intval($sessionUserId)) {
                                $hasCommented = true;
                            }
                        }
                    }
                }

                $likeCount = 0;
                $hasLiked = false;
                if ($likes_select = $mysqli2->prepare("SELECT user_id FROM likes_sets WHERE set_id = '$id'")) {
                    if (!$likes_select->execute()) {
                        echo json_encode(array('status' => 'selectError'));
                        exit();
                    } else {
                        $likes_select->bind_result($likeUserId);
                        while ($likes_select->fetch()) {
                            $likeCount++;
                            if (intval($likeUserId) == intval($sessionUserId)) {
                                $hasLiked = true;
                            }
                        }
                    }
                }

                $sharedCount = 0;
                $hasShared = false;
                $invitedUsers = null;
                if ($select_invited_users_stmt = $mysqli2->prepare("SELECT gesture_sets_shared.*, users.forename, users.surname FROM gesture_sets_shared LEFT JOIN users ON gesture_sets_shared.owner_id = users.id WHERE gesture_sets_shared.set_id = '$id' AND gesture_sets_shared.owner_id = '$userId'")) {
                    if (!$select_invited_users_stmt->execute()) {
                        echo json_encode(array('status' => 'selectSharedStudiesError'));
                        exit();
                    } else {
                        $select_invited_users_stmt->store_result();
                        $select_invited_users_stmt->bind_result($sharedStudyRowId, $sharedSetId, $sharedStudyOwner, $invitedUserMail, $sharedStudyEditable, $userInvited, $forename, $surname);

                        while ($select_invited_users_stmt->fetch()) {
                            $sharedCount++;
                            $hasShared = true;

                            $invitedUsers[] = array('id' => $sharedStudyRowId,
                                'ownerId' => $sharedStudyOwner,
                                'setId' => $sharedSetId,
                                'email' => $invitedUserMail,
                                'edit' => $sharedStudyEditable,
                                'created' => $userInvited
                            );
                        }
                    }
                } else {
                    echo json_encode(array('status' => 'statementError'));
                    exit();
                }

//                echo json_encode(array('status' => 'success', 'gestureSets' => $invitedUsers));
//                exit();
//                if ($select_invited_users_stmt = $mysqli->prepare("SELECT * FROM gesture_sets_shared WHERE set_id = '$id' ORDER BY created ASC")) {// gesture_sets_shared.*, users.forename, users.surname FROM gesture_sets_shared LEFT JOIN users ON gesture_sets_shared.email = users.email WHERE gesture_sets_shared.set_id = '$id'")) {
//                    if (!$select_invited_users_stmt->execute()) {
//                        echo json_encode(array('status' => 'selectSharedStudiesError'));
//                        exit();
//                    } else {
//                        $select_invited_users_stmt->store_result();
//                        $select_invited_users_stmt->bind_result($sharedStudyRowId, $sharedSetId, $sharedStudyOwner, $invitedUserMail, $sharedStudyEditable, $userInvited, $forename, $surname);
//
//                        while ($select_invited_users_stmt->fetch()) {
//                            $invitedUsers[] = array('id' => $sharedStudyRowId,
//                                'ownerId' => $sharedStudyOwner,
//                                'setId' => $sharedSetId,
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
//                print_r($invitedShareUsers);



                $invitedGestureSets[] = array(
                    'id' => $id,
                    'studyId' => $studyId,
                    'userId' => $userId,
                    'title' => json_decode_nice($title, false),
                    'gestures' => json_decode_nice($gestures, false),
                    'hasLiked' => $hasLiked,
                    'likeAmount' => $likeCount,
                    'scope' => $scope,
                    'isOwner' => $sessionUserId == $userId,
                    'commentAmount' => $commentCount,
                    'hasCommented' => $hasCommented,
                    'created' => $created,
                    'invitedUsers' => $invitedUsers
                );
            }

            $result = [];
            if ($gestureSets && count($gestureSets) > 0 && $invitedGestureSets && count($invitedGestureSets) > 0) {
                $result = array_merge($gestureSets, $invitedGestureSets);
            } else if ($gestureSets && count($gestureSets) > 0) {
                $result = $gestureSets;
            } else if ($invitedGestureSets && count($invitedGestureSets) > 0) {
                $result = $invitedGestureSets;
            }

            echo json_encode(array('status' => 'success', 'gestureSets' => $result));
            exit();
        }
    } else {
        echo json_encode(array('status' => 'statementInvitedError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}