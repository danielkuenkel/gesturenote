<?php

include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

$h = getv('h');
$studyId = getv('studyId');

session_start();
$loggedIn = login_check($mysqli) == true ? true : false;

if ($h && $studyId) {
    if ($loggedIn == true) {
        if (isset($_SESSION['usertype'], $_SESSION['user_id'])) {
            $hash = hash('sha512', $studyId . $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname']);
            if ($_SESSION['usertype'] == 'tester') {
                header('Location: study-prepare-tester.php?studyId=' . $studyId . '&token=' . $h . '&h=' . $hash);
            } else if ($_SESSION['usertype'] == 'evaluator') {
                header('Location: study-prepare-evaluator.php?studyId=' . $studyId . '&token=' . $h . '&h=' . $hash);
            }
        }
    } else {
        header('Location: study-prepare-fallback.php?studyId=' . $studyId . '&h=' . $h);
    }
} else {
    header('Location: study-prepare-failure.php');
}
?>
