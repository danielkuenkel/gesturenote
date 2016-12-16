<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'])) {
    $sessionUserId = $_SESSION['user_id'];
    if ($gestures_stmt = $mysqli->prepare("SELECT * FROM gestures ORDER BY created ASC")) {
        if (!$gestures_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $gestures_stmt->store_result();
            $totalGestures = $gestures_stmt->num_rows;
            $userGestures = 0;
            $elicitedGestures = 0;
            $publicGestures = 0;
            $publicUserGestures = 0;

            $gestures_stmt->bind_result($id, $userId, $ownerId, $source, $scope, $title, $type, $interactionType, $context, $association, $description, $joints, $previewImage, $images, $created);
            while ($gestures_stmt->fetch()) {
                if ($sessionUserId == $ownerId) {
                    if ($source == 'evaluator') {
                        $userGestures++;
                    } else if ($source == 'tester') {
                        $elicitedGestures++;
                    }

                    if ($source == 'evaluator' && $scope == 'public') {
                        $publicUserGestures++;
                    }
                } else if ($scope === 'public') {
                    $publicGestures++;
                }
            }

            echo json_encode(array('status' => 'success', 'totalGestures' => $totalGestures, 'userGestures' => $userGestures, 'elicitedGestures' => $elicitedGestures, 'publicGestures' => $publicGestures, 'publicUserGestures' => $publicUserGestures));
        }
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}