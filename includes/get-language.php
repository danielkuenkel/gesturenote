<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
session_start();
if (isset($_SESSION['lang'])) {
    $sessionLang = $_SESSION['lang'];
    echo json_encode(array('status' => 'success', 'lang' => $sessionLang));
    exit();
} else {
    $browserLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    echo json_encode(array('status' => 'success', 'lang' => $browserLanguage));
    exit();
}