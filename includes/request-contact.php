<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';

if (isset($_POST['email'], $_POST['name'], $_POST['comment'])) {
    // Sanitize and validate the data passed in
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $name = $_POST['name'];
    $responder = "admin@gesturenote.de";
    $subject = "Anfrage über GestureNote";
    $from = "From: " . $name . " <" . $email . ">";
    $comment = $_POST['comment'];

    mail($responder, $subject, $comment, $from);

    echo json_encode(array('status' => 'success'));
    exit();
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}    