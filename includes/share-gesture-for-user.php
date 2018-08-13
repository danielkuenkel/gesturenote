<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once './language.php';
include_once 'db_connect.php';
include_once 'psl-config.php';

if (isset($_SESSION['user_id'], $_POST['gestureId'], $_POST['email'])) {
    $sessionUserId = $_SESSION['user_id'];
    $sessionUserMail = $_SESSION['email'];

    $shareId = $_POST['gestureId'];
    $inviteMail = $_POST['email'];

    if ($sessionUserMail === $inviteMail) {
        echo json_encode(array('status' => 'notInviteYourself'));
        exit();
    }

    if ($select_stmt = $mysqli->prepare("SELECT id FROM gestures_shared WHERE gesture_id = '$shareId' && email = '$inviteMail' LIMIT 1")) {
//    if ($select_stmt = $mysqli->prepare("SELECT users.id, users.email, studies_shared.* FROM users LEFT JOIN studies_shared ON users.email = '$inviteMail' WHERE studies_shared.study_id = '$studyId' && studies_shared.email = '$inviteMail' LIMIT 1")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($sharedStudyRowId);
            $select_stmt->fetch();

            if ($select_stmt->num_rows === 1) {
                echo json_encode(array('status' => 'userAlreadyInvited'));
                exit();
            } else {
                if ($insert_stmt = $mysqli->prepare("INSERT INTO gestures_shared (gesture_id, owner_id, email) VALUES ('$shareId','$sessionUserId','$inviteMail')")) {
                    if (!$insert_stmt->execute()) {
                        echo json_encode(array('status' => 'insertError'));
                        exit();
                    } else {
                        if ($select_invited_users_stmt = $mysqli->prepare("SELECT gestures_shared.*, users.forename, users.surname FROM gestures_shared LEFT JOIN users ON gestures_shared.owner_id = users.id WHERE gestures_shared.gesture_id = '$shareId' AND gestures_shared.owner_id = '$sessionUserId'")) {
                            if (!$select_invited_users_stmt->execute()) {
                                echo json_encode(array('status' => 'selectSharedStudiesError'));
                                exit();
                            } else {
                                $select_invited_users_stmt->store_result();
                                $select_invited_users_stmt->bind_result($sharedStudyRowId, $sharedGestureId, $sharedStudyOwner, $invitedUserMail, $sharedStudyEditable, $userInvited, $forename, $surname);

                                while ($select_invited_users_stmt->fetch()) {
                                    $invitedUsers[] = array('id' => $sharedStudyRowId,
                                        'ownerId' => $sharedStudyOwner,
                                        'gestureId' => $sharedGestureId,
                                        'email' => $invitedUserMail,
                                        'edit' => $sharedStudyEditable,
                                        'created' => $userInvited
                                    );
                                }

                                $to = $inviteMail;
                                $subject = $lang->inviteGestureSetSubject;
                                $message = '<html>
                                    <head>
                                    <title>' . $lang->inviteGestureSetTitle . '</title>
                                    </head>
                                    <body>
                                        <p style="font-weight:bold">' . $lang->hello . ' ' . $forename . ' ' . $surname . ',</p>
                                        <p>' . $lang->inviteGestureSetText . '</p>
                                        <p>' . $lang->inviteGestureSetGreetings . ',</p>
                                        <p style="font-weight:bold">' . $lang->inviteGestureSetTeam . '</p>
                                    </body>
                                    </html>';

                                // für HTML-E-Mails muss der 'Content-type'-Header gesetzt werden
                                $header = 'MIME-Version: 1.0' . "\r\n";
                                $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";

                                // zusätzliche Header
                                $header .= 'From: noreply@gesturenote.de' . "\r\n";
                                $header .= 'Reply-To: admin@gesturenote.de' . "\r\n";

                                mail($to, $subject, $message, $header);

                                echo json_encode(array('status' => 'success', 'invitedUsers' => $invitedUsers));
                                exit();
                            }
                        } else {
                            echo json_encode(array('status' => 'selectStatemantError'));
                            exit();
                        }
                    }
                } else {
                    echo json_encode(array('status' => 'statementError'));
                    exit();
                }
                echo json_encode(array('status' => 'success'));
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