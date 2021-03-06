<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once './language.php';
include_once 'db_connect.php';
include_once 'psl-config.php';

if (isset($_SESSION['user_id'], $_POST['studyId'], $_POST['email'])) {
    $sessionUserId = $_SESSION['user_id'];
    $sessionUserMail = $_SESSION['email'];

    $studyId = $_POST['studyId'];
    $inviteMail = $_POST['email'];

    if ($sessionUserMail === $inviteMail) {
        echo json_encode(array('status' => 'notInviteYourself'));
        exit();
    }

    if ($select_stmt = $mysqli->prepare("SELECT * FROM studies_shared WHERE studies_shared.study_id = '$studyId' && studies_shared.email = '$inviteMail' LIMIT 1")) {
//    if ($select_stmt = $mysqli->prepare("SELECT users.id, users.email, studies_shared.* FROM users LEFT JOIN studies_shared ON users.email = '$inviteMail' WHERE studies_shared.study_id = '$studyId' && studies_shared.email = '$inviteMail' LIMIT 1")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($sharedStudyRowId, $sharedStudyId, $sharedStudyOwner, $invitedUserMail, $sharedStudyEditable, $userInvited);
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
                        if ($select_invited_users_stmt = $mysqli->prepare("SELECT studies_shared.*, users.forename, users.surname FROM studies_shared LEFT JOIN users ON studies_shared.email = users.email WHERE studies_shared.study_id = '$studyId' AND studies_shared.owner_id = '$sessionUserId'")) {
                            if (!$select_invited_users_stmt->execute()) {
                                echo json_encode(array('status' => 'selectSharedStudiesError'));
                                exit();
                            } else {
                                $select_invited_users_stmt->store_result();
                                $select_invited_users_stmt->bind_result($sharedStudyRowId, $sharedStudyId, $sharedStudyOwner, $invitedUserMail, $sharedStudyEditable, $userInvited, $forename, $surname);
                                $invitedForename = '';
                                $invitedSurname = '';
                                
                                while ($select_invited_users_stmt->fetch()) {
                                    if ($invitedUserMail === $inviteMail) {
                                        $invitedForename = $forename;
                                        $invitedSurname = $surname;
                                    }
                                    
                                    $invitedUsers[] = array('id' => $sharedStudyRowId,
                                        'ownerId' => $sharedStudyId,
                                        'email' => $invitedUserMail,
                                        'edit' => $sharedStudyEditable,
                                        'created' => $userInvited
                                    );
                                }

                                $to = $inviteMail;
                                $subject = $lang->inviteSubject;
                                $message = '<html>
                                    <head>
                                    <title>' . $lang->inviteTitle . '</title>
                                    </head>
                                    <body>
                                        <p>' . $lang->hello . ' ' . $invitedForename . ' ' . $invitedSurname . ',</p>
                                        <p>' . $lang->inviteText . '</p>
                                        <p>' . $lang->mailGreetings . ',</p>
                                        <p>' . $lang->gestureNoteTeam . '</p>
                                    </body>
                                    </html>';

                                // f??r HTML-E-Mails muss der 'Content-type'-Header gesetzt werden
                                $header = 'MIME-Version: 1.0' . "\r\n";
                                $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";

                                // zus??tzliche Header
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
    } else {
        echo json_encode(array('status' => 'statementError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}