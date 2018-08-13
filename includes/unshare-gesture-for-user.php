<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once './language.php';
include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['gestureId'], $_POST['id'], $_POST['email'])) {
    $sessionUserId = $_SESSION['user_id'];

    $inviteId = $_POST['id'];
    $inviteMail = $_POST['email'];
    $shareId = $_POST['gestureId'];

    if ($delete_stmt = $mysqli->prepare("DELETE FROM gestures_shared WHERE id = '$inviteId'")) {
        if (!$delete_stmt->execute()) {
            echo json_encode(array('status' => 'deleteError'));
            exit();
        } else {
            if ($select_invited_users_stmt = $mysqli->prepare("SELECT * FROM gestures_shared WHERE gesture_id = '$shareId' AND owner_id = '$sessionUserId'")) {
                if (!$select_invited_users_stmt->execute()) {
                    echo json_encode(array('status' => 'selectSharedStudiesError'));
                    exit();
                } else {
                    $select_invited_users_stmt->store_result();
                    $select_invited_users_stmt->bind_result($sharedStudyRowId, $sharedStudyId, $sharedStudyOwner, $invitedUserMail, $sharedStudyEditable, $userInvited);
                    $invitedUsers = null;

                    while ($select_invited_users_stmt->fetch()) {
                        $invitedUsers[] = array(
                            'id' => $sharedStudyRowId,
                            'ownerId' => $sharedStudyId,
                            'email' => $invitedUserMail,
                            'edit' => $sharedStudyEditable,
                            'created' => $userInvited
                        );
                    }

                    $to = $inviteMail;
                    $subject = $lang->uninviteGestureSetSubject;
                    $message = '<html>
                                    <head>
                                    <title>' . $lang->uninviteGestureSetTitle . '</title>
                                    </head>
                                    <body>
                                        <p style="font-weight:bold">' . $lang->hello . ',</p>
                                        <p>' . $lang->uninviteGestureSetText . '</p>
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
        echo json_encode(array('status' => 'deleteStatemantError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}