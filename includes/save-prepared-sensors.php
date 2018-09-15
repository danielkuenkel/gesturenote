<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_POST['preparedSensors'])) {
    $_SESSION['preparedSensors'] = $_POST['preparedSensors'];
    echo json_encode(array('status' => 'success'));
    exit();
} else {
    $_SESSION['preparedSensors'] = null;
    echo json_encode(array('status' => 'error'));
    exit();
}