<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

$target_dir = "../uploads/";
$target_preview_dir = "uploads/";

session_start();
if (isset($_SESSION['user_id'], $_POST['sound'])) {
    if (isLocalhost()) {
        $target_dir = "http://localhost/gesturenote/";
    }
    deleteFiles($target_dir, $_POST['sound']);
    echo json_encode(array('status' => 'success'));
} else {
    echo json_encode(array('status' => 'error'));
}