<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'functions.php';
include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['gestureId'])) {
    $sessionUserId = $_SESSION['user_id'];
    $currentGestureId = $_POST['gestureId'];

    if ($select_stmt = $mysqli->prepare("SELECT user_id, general_data FROM studies ORDER BY created ASC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectRatingsError'));
            exit();
        } else {
            $hasRated = false;
            $select_stmt->store_result();
            $select_stmt->bind_result($studyOwnerId, $general_data);
            $numResults = $select_stmt->num_rows;
            $sharedInfos = null;
            $usedSharedGestureInOwnProjectsCount = 0;
            $usedSharedGestureInOtherProjectsCount = 0;

            if ($numResults > 0) {
                while ($select_stmt->fetch()) {
                    $generalDataResult = json_decode_nice($general_data, false);

                    if (isset($generalDataResult->assembledGestureSet)) {
                        $assembledGestures = $generalDataResult->assembledGestureSet;
                        foreach ($assembledGestures as $gesture) {
                            if ($currentGestureId === $gesture) {
                                if (intval($sessionUserId) === intval($studyOwnerId)) {
                                    $usedSharedGestureInOwnProjectsCount++;
                                } else {
                                    $usedSharedGestureInOtherProjectsCount++;
                                }
                            }
                        }
                    }
                }
            }

            echo json_encode(array('status' => 'success', 'usedSharedGestureInOwnProjectsCount' => $usedSharedGestureInOwnProjectsCount, 'usedSharedGestureInOtherProjectsCount' => $usedSharedGestureInOtherProjectsCount));
            exit();
        }
    } else {
        echo json_encode(array('status' => 'statemantError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}