<?php
include_once 'functions.php';
session_start();
 
$lang = $_SESSION['lang'];
$cookiesAccepted = $_SESSION['cookiesAccepted'];
// Unset all session values 
$_SESSION = array();
 
// get session parameters 
$params = session_get_cookie_params();
 
// Delete the actual cookie. 
setcookie(session_name(),
        '', time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]);
 
// Destroy session 
session_destroy();
$_SESSION['lang'] = $lang;
$_SESSION['cookiesAccepted'] = 1;
header('Location: ../index.php');
exit();