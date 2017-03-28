<?php

session_start();

if (isset($_SESSION['user_id'], $_SESSION['forename'], $_SESSION['surname'], $_SESSION['login_string'], $_SESSION['gender'], $_SESSION['usertype'], $_SESSION['birthday'])) {
    $_SESSION['user_id'] = $_SESSION['user_id'];
    $_SESSION['forename'] = $_SESSION['forename'];
    $_SESSION['surname'] = $_SESSION['surname'];
    $_SESSION['login_string'] = $_SESSION['login_string'];
    $_SESSION['gender'] = $_SESSION['gender'];
    $_SESSION['usertype'] = $_SESSION['usertype'];
    $_SESSION['birthday'] = $_SESSION['birthday'];
}
?>