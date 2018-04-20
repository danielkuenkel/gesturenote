<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['studyId'], $_POST['email'])) {
    $sessionUserId = $_SESSION['user_id'];

    $studyId = $_POST['studyId'];
    $inviteMail = $_POST['email'];
    $inviteURL = $_POST['url'];

    if ($select_stmt = $mysqli->prepare("SELECT users.id, users.email, studies_shared.* FROM users JOIN studies_shared ON users.email = '$inviteMail' LIMIT 1")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($userId, $userMail, $sharedStudyRowId, $sharedStudyId, $sharedStudyOwner, $invitedUserMail, $sharedStudyEditable, $userInvited);
            $select_stmt->fetch();
            
            if ($select_stmt->num_rows === 1) {
                echo json_encode(array('status' => 'userAlreadyInvited'));
                exit();
            } else {
                if ($insert_stmt = $mysqli->prepare("INSERT INTO studies_shared (study_id, owner_id, email) VALUES ('$studyId','$sessionUserId', '$inviteMail')")) {
                    if (!$insert_stmt->execute()) {
                        echo json_encode(array('status' => 'insertError'));
                        exit();
                    } else {
                        if ($select_invited_users_stmt = $mysqli->prepare("SELECT studies_shared.*, users.forename, users.surname FROM studies_shared LEFT JOIN users ON studies_shared.owner_id = users.id WHERE studies_shared.study_id = '$studyId' AND studies_shared.owner_id = '$sessionUserId'")) {
                            if (!$select_invited_users_stmt->execute()) {
                                echo json_encode(array('status' => 'selectSharedStudiesError'));
                                exit();
                            } else {
                                $select_invited_users_stmt->store_result();
                                $select_invited_users_stmt->bind_result($sharedStudyRowId, $sharedStudyId, $sharedStudyOwner, $invitedUserMail, $sharedStudyEditable, $userInvited, $forename, $surname);

                                while ($select_invited_users_stmt->fetch()) {
                                    $invitedUsers[] = array('id' => $sharedStudyRowId,
                                        'ownerId' => $sharedStudyId,
                                        'email' => $invitedUserMail,
                                        'edit' => $sharedStudyEditable,
                                        'created' => $userInvited
                                    );
                                }

                                $to = $inviteMail;
                                $subject = 'Freigabe Gesten-Design-Studie';
                                $message = '<html>
                                    <head>
                                    <title>Sie wurden für eine Gesten-Design-Studie freigegeben</title>
                                    </head>
                                    <body>
                                        <p style="font-weight:bold">Hallo ' . $forename . ' ' . $surname . ',</p>
                                        <p>ein anderer Gesten-Designer hat Ihnen eine Studie freigegeben. Diese Studie wird, solange diese freigegeben ist, in Ihrer Studien-Übersicht angezeigt. Sie gelangen über diesen <a href="https://gesturenote.de/studies.php">Link</a> direkt zur Übersicht.</p>
                                        <p>Mit freundlichen Grüßen,</p>
                                        <p style="font-weight:bold">Ihr GestureNote Team</p>
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
                    echo json_encode(array('status' => 'statemantError'));
                    exit();
                }
                echo json_encode(array('status' => 'success'));
                exit();
            }
        }
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}