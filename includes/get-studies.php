<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'functions.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'])) {
    $sessionUserId = $_SESSION['user_id'];
    $sessionUserMail = $_SESSION['email'];

    // get all studies, which you are the owner of
    if ($select_stmt = $mysqli->prepare("SELECT	studies.*, COALESCE(totalParticipants, 0) AS totalParticipants,	COALESCE(totalShared, 0) AS totalShared FROM studies LEFT JOIN (SELECT study_id, COUNT(*) AS totalParticipants FROM study_results_tester GROUP BY study_id) totalParticipants ON totalParticipants.study_id = studies.id LEFT JOIN (SELECT study_id, COUNT(*) AS totalShared FROM studies_shared GROUP BY study_id) totalShared ON totalShared.study_id = studies.id WHERE studies.user_id = '$sessionUserId' ORDER BY studies.created ASC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->bind_result($id, $userId, $data, $urlToken, $created, $participants, $sharedStudies);
            $studies = null;
            while ($select_stmt->fetch()) {
                $invitedUsers = null;
                if ($select_invited_users_stmt = $mysqli2->prepare("SELECT studies_shared.*, users.forename, users.surname FROM studies_shared LEFT JOIN users ON studies_shared.owner_id = users.id WHERE studies_shared.study_id = '$id' AND studies_shared.owner_id = '$sessionUserId'")) {
                    if (!$select_invited_users_stmt->execute()) {
                        echo json_encode(array('status' => 'selectSharedStudiesError'));
                        exit();
                    } else {
                        $select_invited_users_stmt->store_result();
                        $select_invited_users_stmt->bind_result($sharedStudyRowId, $sharedId, $sharedStudyOwner, $invitedUserMail, $sharedStudyEditable, $userInvited, $forename, $surname);

                        while ($select_invited_users_stmt->fetch()) {
                            $hasShared = true;

                            $invitedUsers[] = array('id' => $sharedStudyRowId,
                                'ownerId' => $sharedStudyOwner,
                                'studyId' => $sharedId,
                                'email' => $invitedUserMail,
                                'edit' => $sharedStudyEditable,
                                'created' => $userInvited
                            );
                        }
                    }
                }

                $studies[] = array('id' => $id,
                    'userId' => $userId,
                    'isOwner' => intval($userId) === intval($sessionUserId),
                    'data' => json_decode_nice($data),
                    'urlToken' => $urlToken,
                    'created' => $created,
                    'participants' => $participants,
                    'invitedUsers' => $invitedUsers);
            }
        }
    } else {
        echo json_encode(array('status' => 'statementError'));
        exit();
    }

    // get all studies, which were shared with you
    if ($select_stmt = $mysqli->prepare("SELECT studies.*, COUNT(study_results_tester.id) AS totalShared FROM studies LEFT JOIN studies_shared ON studies.id = studies_shared.study_id LEFT JOIN study_results_tester ON studies.id = study_results_tester.study_id WHERE studies_shared.email = '$sessionUserMail' GROUP BY studies.id ORDER BY studies.created ASC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectInvitedError'));
            exit();
        } else {
            $select_stmt->bind_result($id, $userId, $data, $urlToken, $created, $participants);
            $invitedStudies = null;
            while ($select_stmt->fetch()) {
                $invitedStudies[] = array('id' => $id,
                    'userId' => $userId,
                    'isOwner' => intval($userId) === intval($sessionUserId),
                    'data' => json_decode_nice($data),
                    'urlToken' => $urlToken,
                    'created' => $created,
                    'participants' => $participants);
            }

            $result = [];
            if ($studies && count($studies) > 0 && $invitedStudies && count($invitedStudies) > 0) {
                $result = array_merge($studies, $invitedStudies);
            } else if ($studies && count($studies) > 0) {
                $result = $studies;
            } else if ($invitedStudies && count($invitedStudies) > 0) {
                $result = $invitedStudies;
            }
            echo json_encode(array('status' => 'success', 'studies' => $result));
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