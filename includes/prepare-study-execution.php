<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once './language.php';
include_once 'functions.php';
include_once 'db_connect.php';
include_once 'psl-config.php';

if (isset($_POST['studyId'], $_POST['executionUrl'])) {
    // Sanitize and validate the data passed in
    $studyId = filter_input(INPUT_POST, 'studyId', FILTER_SANITIZE_STRING);
    $executionUrl = filter_input(INPUT_POST, 'executionUrl', FILTER_SANITIZE_STRING);

    if ($select_stmt = $mysqli->prepare("SELECT users.forename,users.surname,users.email,studies.general_data FROM users LEFT JOIN studies ON studies.user_id = users.id WHERE studies.id = '$studyId'")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($forename, $surname, $email, $studyData);
            $select_stmt->fetch();

            if ($select_stmt->num_rows === 1) {
                $decodedData = json_decode_nice($studyData, false);

                $to = $inviteMail;
                $subject = $lang->prepareExecutionSubject;
                $message = '<html>
                                    <head>
                                    <title>' . $lang->prepareExecutionTitle . '</title>
                                    </head>
                                    <body>
                                        <p style="font-weight:bold">' . $lang->hello . ' ' . $forename . ' ' . $surname . ',</p>
                                        <p>' . $lang->prepareExecutionText . '</p>
                                        <p>' . $lang->studyTitle . ': ' . $decodedData->generalData->title . ' <a href="' . $executionUrl . '">' . $lang->executeStudy . '</a></p>
                                        <p>' . $lang->prepareExecutionGreetings . ',</p>
                                        <p style="font-weight:bold">' . $lang->prepareExecutionTeam . '</p>
                                    </body>
                                    </html>';

                // für HTML-E-Mails muss der 'Content-type'-Header gesetzt werden
                $header = 'MIME-Version: 1.0' . "\r\n";
                $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";

                // zusätzliche Header
                $header .= 'From: noreply@gesturenote.de' . "\r\n";

                mail($email, $subject, $message, $header);

                echo json_encode(array('status' => 'success'));
                exit();
            } else {
                echo json_encode(array('status' => 'prepareError'));
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