<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'], $_POST['dontShowIntroduction'], $_POST['context'])) {

    // Serialisieren der Daten
    $sessionUserId = $_SESSION['user_id'];
    $dontShowIntroduction = intval($_POST['dontShowIntroduction']);
    $sessionTutorials = $_SESSION['tutorials'];
    $updateContext = $_POST['context'];

    if (!empty($sessionTutorials)) {
        $sessionTutorials->$updateContext = $dontShowIntroduction;
    } else {
        $sessionTutorials = array($updateContext => $dontShowIntroduction);
    }

    $encodedTutorials = json_encode($sessionTutorials);
    $_SESSION['tutorials'] = $sessionTutorials;

    if ($update_stmt = $mysqli->prepare("UPDATE users SET tutorials = '$encodedTutorials' WHERE id = '$sessionUserId'")) {
        if (!$update_stmt->execute()) {
            echo json_encode(array('status' => 'updateError'));
            exit();
        } else {
            echo json_encode(array('status' => 'success'));
            exit();
        }
    } else {
        echo json_encode(array('status' => 'statemantError'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}