<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'])) {
    $sessionUserId = $_SESSION['user_id'];

    if ($select_stmt = $mysqli->prepare("SELECT * FROM gestures WHERE owner_id = '$sessionUserId' && scope = 'private' OR scope = 'public' ORDER BY created DESC")) {
        // get variables from result.
        $select_stmt->bind_result($id, $userId, $ownerId, $source, $scope, $title, $context, $description, $joints, $previewImage, $images, $created);

        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $gestures = null;
            while ($select_stmt->fetch()) {
                $gestures[] = array('id' => $id,
                    'userId' => $userId,
                    'ownerId' => $ownerId,
                    'source' => $source,
                    'scope' => $scope,
                    'title' => $title,
                    'context' => $context,
                    'description' => $description,
                    'joints' => json_decode($joints),
                    'previewImage' => $previewImage,
                    'images' => json_decode($images),
                    'created' => $created,
                    'isOwner' => $sessionUserId == $ownerId);
            }
            echo json_encode(array('status' => 'success', 'gestures' => $gestures));
        }
    } else {
        echo json_encode(array('status' => 'statementError'));
    }
} else {
    echo json_encode(array('status' => 'error'));
}