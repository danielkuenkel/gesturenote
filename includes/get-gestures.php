<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'])) {
    $sessionUserId = $_SESSION['user_id'];

    if ($select_stmt = $mysqli->prepare("SELECT * FROM gestures WHERE user_id = '$sessionUserId' && scope = 'private' OR scope = 'public'")) {
        // get variables from result.
        $select_stmt->bind_result($id, $userId, $source, $scope, $title, $context, $description, $joints, $previewImage, $images, $created);

        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            while ($select_stmt->fetch()) {
                if ($sessionUserId == $userId) {
                    $gestures[] = array('id' => $id,
                        'userId' => $userId,
                        'source' => $source,
                        'scope' => $scope,
                        'title' => $title,
                        'context' => $context,
                        'description' => $description,
                        'joints' => json_decode($joints),
                        'previewImage' => $previewImage,
                        'images' => json_decode($images),
                        'created' => $created,
                        'isOwner' => true);
                } else {
                    $gestures[] = array('id' => $id,
                        'userId' => $userId,
                        'source' => $source,
                        'scope' => $scope,
                        'title' => $title,
                        'context' => $context,
                        'description' => $description,
                        'joints' => json_decode($joints),
                        'previewImage' => $previewImage,
                        'images' => json_decode($images),
                        'created' => $created,
                        'isOwner' => false);
                }
            }
            echo json_encode(array('status' => 'success', 'gestures' => $gestures));
        }
    } else {
        echo json_encode(array('status' => 'statementError'));
    }
} else {
    echo json_encode(array('status' => 'error'));
}