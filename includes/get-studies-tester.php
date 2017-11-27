<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'functions.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'])) {
    $sessionUserId = $_SESSION['user_id'];

    if ($select_stmt = $mysqli->prepare("SELECT * FROM studies ORDER BY created ASC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->bind_result($id, $userId, $data, $urlToken, $created);
            $studies = null;

            $age = floor((time() - intval($_SESSION['birthday'])) / 31556926);
            $gender = $_SESSION['gender'];

            while ($select_stmt->fetch()) {
                $decodedData = json_decode_nice($data, false);

                if (isset($decodedData->generalData, $decodedData->generalData->panelSurvey, $decodedData->generalData->ageRange, $decodedData->generalData->gender) && $decodedData->generalData->panelSurvey == "yes" && $decodedData->generalData->ageRange != "" && $decodedData->generalData->gender != "") {
                    $genderConstraint = $decodedData->generalData->gender;
//                    $ageConstraint = explode(",", $decodedData->generalData->ageRange);
                    $ageFrom = intval($decodedData->generalData->ageRange->min);
                    $ageTo = intval($decodedData->generalData->ageRange->max);
                    $now = time();
                    $dateFrom = intval($decodedData->generalData->dateFrom);
                    $dateTo = intval($decodedData->generalData->dateTo);

                    if ($ageConstraint != "" && ($genderConstraint != "" && ($genderConstraint == 'identical' || strcmp($genderConstraint, $gender) == 0)) && $dateFrom != "" && $dateTo != "" && $age >= $ageFrom && $age <= $ageTo) {
                        if ($dateTo > $now) {
                            $studies[] = array('id' => $id,
                                'userId' => $userId,
                                'data' => $decodedData,
                                'urlToken' => $urlToken,
                                'created' => $created);
                        }
                    }
                }
            }
            echo json_encode(array('status' => 'success', 'studies' => $studies, 'birthday' => $age));
        }
    } else {
        echo json_encode(array('status' => 'statementError'));
    }
} else {
    echo json_encode(array('status' => 'error'));
}    