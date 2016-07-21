<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

if (isset($_POST['generalData'])) {

    // Serialisieren der Daten
    $string = json_encode($_POST['generalData']);

    // get the ID of the leogged in user
    session_start();
    $userId = $_SESSION['user_id'];
    $urlToken = sha1(time() . $userId);
//    $mysqli->query("INSERT INTO login_attempts(user_id, time) VALUES ('$user_id', '$now')");
    if ($insert_stmt = $mysqli->prepare("INSERT INTO projects (user_id, general_data, url_token) VALUES ('$userId','$string','$urlToken')")) {
        if (!$insert_stmt->execute()) {
            echo json_encode(array('status' => 'insertError'));
            exit();
//                header('Location: ../error.php?err = Registration failure: INSERT');
        }
    }

    echo json_encode(array('status' => 'success'));

//    exit();
//        header('Location: ./register_success.php');
//    }
}    