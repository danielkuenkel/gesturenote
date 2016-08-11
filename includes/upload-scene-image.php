<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

$target_dir = "../uploads/";
$target_preview_dir = "uploads/";

session_start();
if (isset($_SESSION['user_id']) && $_FILES['image']['name']) {
    $file_name = md5(microtime());
    $imageUrl = $target_preview_dir . $file_name . '.jpg';
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $file_name . '.jpg')) {
        echo json_encode(array('status' => 'success', 'imageUrl' => $imageUrl));
        exit();
    } else {
        echo json_encode(array('status' => 'uploadError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error', '$_FILES' => $_FILES));
}