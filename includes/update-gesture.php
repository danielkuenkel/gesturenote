<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['gestureId'], $_POST['title'], $_POST['type'], $_POST['interactionType'], $_POST['context'], $_POST['association'], $_POST['description'], $_POST['joints'], $_POST['previewImageIndex'])) {
    $sessionUserId = $_SESSION['user_id'];
    $gestureId = $_POST['gestureId'];
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $interactionType = filter_input(INPUT_POST, 'interactionType', FILTER_SANITIZE_STRING);
    $context = filter_input(INPUT_POST, 'context', FILTER_SANITIZE_STRING);
    $association = filter_input(INPUT_POST, 'association', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $joints = json_encode($_POST['joints']);
    $previewImage = $_POST['previewImageIndex'];

    if ($update_stmt = $mysqli->prepare("UPDATE gestures SET title = '$title', type = '$type', interaction_type = '$interactionType', context = '$context', association = '$association', description = '$description', joints = '$joints', preview_image = '$previewImage' WHERE id = '$gestureId' && owner_id = '$sessionUserId'")) {
        if (!$update_stmt->execute()) {
            echo json_encode(array('status' => 'updateError'));
            exit();
        } else {
            echo json_encode(array('status' => 'success', 'id' => $gestureId, 'title' => $title, 'type' => $type, 'interactionType' => $interactionType, 'context' => $context, 'association' => $association, 'description' => $description, 'joints' => json_decode($joints), 'previewImage' => $previewImage));
            exit();

//            if ($select_stmt = $mysqli->prepare("SELECT * FROM gestures WHERE owner_id = '$sessionUserId' && scope = 'private' OR scope = 'public'")) {
//                // get variables from result.
//                $select_stmt->bind_result($id, $userId, $ownerId, $source, $scope, $title, $context, $description, $joints, $previewImage, $images, $created);
//
//                if (!$select_stmt->execute()) {
//                    echo json_encode(array('status' => 'selectError'));
//                    exit();
//                } else {
//                    while ($select_stmt->fetch()) {
//                        $gestures[] = array('id' => $id,
//                            'userId' => $userId,
//                            'source' => $source,
//                            'scope' => $scope,
//                            'title' => $title,
//                            'context' => $context,
//                            'description' => $description,
//                            'joints' => json_decode($joints),
//                            'previewImage' => $previewImage,
//                            'images' => json_decode($images),
//                            'created' => $created,
//                            'isOwner' => $sessionUserId == $ownerId);
//                    }
//                    echo json_encode(array('status' => 'success', 'gestures' => $gestures));
//                    exit();
//                }
//            } else {
//                echo json_encode(array('status' => 'statementError'));
//                exit();
//            }
        }
    } else {
        echo json_encode(array('status' => 'statemantError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}    