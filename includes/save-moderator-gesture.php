<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

$target_dir = "../uploads/";
$target_preview_dir = "uploads/";

session_start();
if (isset($_SESSION['user_id'], $_POST['title'], $_POST['context'], $_POST['description'], $_POST['joints'], $_POST['previewImage'], $_POST['gestureImages'])) {
    $images = $_POST['gestureImages'];
    $imageURLs = array();

    foreach ($images as $image) {

        $file_name = md5(microtime());
        $imageData = substr($image, 23);

        $im = imagecreatefromstring(base64_decode($imageData)); // php function to create image from string
        // condition check if valid conversion
        if ($im !== false) {
            // saves an image to specific location
            $resp = imagejpeg($im, $target_dir . $file_name . '.jpg');
            array_push($imageURLs, $target_preview_dir . $file_name . '.jpg');
            // frees image from memory
            imagedestroy($im);
        } else {
            // show if any error in bytes data for image
            echo json_encode(array('status' => 'error'));
            exit();
        }
    }

    $userId = $_SESSION['user_id'];
    $source = $_SESSION['usertype'];
    $scope = 'private';
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $context = filter_input(INPUT_POST, 'context', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $joints = json_encode($_POST['joints']);
    $previewImage = $_POST['previewImage'];
    $dbImageURLs = json_encode($imageURLs);

    if ($insert_stmt = $mysqli->prepare("INSERT INTO gestures (user_id, source, scope, title, context, description, joints, preview_image, images) VALUES ('$userId','$source','$scope','$title','$context','$description','$joints','$previewImage','$dbImageURLs')")) {
        if (!$insert_stmt->execute()) {
            deleteImages($target_dir, $imageURLs);
            echo json_encode(array('status' => 'insertError'));
            exit();
        } else {
            $insertId = $mysqli->insert_id;
            echo json_encode(array('status' => 'success', 'gestureId' => $insertId, 'images' => $imageURLs, 'previewImage' => $previewImage));
            exit();
        }
    } else {
        deleteImages($target_dir, $imageURLs);
        echo json_encode(array('status' => 'statemantError'));
    }
} else {
    echo json_encode(array('status' => 'error'));
}

function deleteImages($targetUrl, $images) {
    foreach ($images as $url) {
        unlink($targetUrl . $url);
    }
}
