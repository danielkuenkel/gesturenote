<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'functions.php';

session_start();

if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p']; // The hashed password.
    echo login($email, $password, $mysqli);
//    if ($result == 'accountLocked') {
//        echo json_encode(array('status' => 'accountLogged'));
//        exit();
//    } else if ($result == 'passwordNotCorrect') {
//        echo json_encode(array('status' => 'passwordNotCorrect'));
//        exit();
//    } else if ($result == 'noUserExists') {
//        echo json_encode(array('status' => 'noUserExists'));
//        exit();
//    } else if ($result == 'success') {
//        echo json_encode(array('status' => 'success'));
//        exit();
//    } else {
//        echo json_encode(array('status' => 'loginFailed'));
//    }
} else {
    // The correct POST variables were not sent to this page. 
    echo json_encode(array('status' => 'databaseError'));
}