<?php

include_once 'functions.php';
session_start();

//$lang = $_SESSION['lang'];
//$cookiesAccepted = $_SESSION['cookiesAccepted'];
// Unset all session values 
//$_SESSION = array();
// get session parameters 
//$params = session_get_cookie_params();

// Delete the actual cookie. 
//setcookie(session_name(),
//        '', time() - 42000, 
//        $params["path"], 
//        $params["domain"], 
//        $params["secure"], 
//        $params["httponly"]);
// Destroy session 
//session_destroy();
unset($_SESSION['user_id']);
unset($_SESSION['forename']);
unset($_SESSION['surname']);
unset($_SESSION['email']);
unset($_SESSION['login_string']);
unset($_SESSION['usertype']);
unset($_SESSION['user_id']);
unset($_SESSION['user_id']);
unset($_SESSION['user_id']);
unset($_SESSION['user_id']);
unset($_SESSION['user_id']);
//$_SESSION['user_id'] = $user_id;
//$_SESSION['forename'] = $forename;
//$_SESSION['surname'] = $surname;
//$_SESSION['email'] = $email;
//$_SESSION['login_string'] = hash('sha512', $db_password . $user_browser);
//$_SESSION['usertype'] = $usertype;
//$_SESSION['tutorialStudyCreation'] = $tutorialStudyCreation;
//$_SESSION['tutorialStudyPreview'] = $tutorialStudyPreview;
//$_SESSION['tutorialStudy'] = $tutorialStudy;
//$_SESSION['tutorialExtraction'] = $tutorialExtraction;
//$_SESSION['tutorialParticipant'] = $tutorialParticipant;
//$_SESSION['tutorialGestureCatalog'] = $tutorialGestureCatalog;

//$_SESSION['lang'] = $lang;
//$_SESSION['cookiesAccepted'] = $cookiesAccepted;
header('Location: ../index.php');
exit();
