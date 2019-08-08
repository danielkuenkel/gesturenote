<?php

include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

$h = getv('h');
$studyId = getv('studyId');
$serverhost = 'https://gesturenote.de/';
if (isLocalhost()) {
    $serverhost = 'http://localhost/gesturenote/';
}

if ($h && $studyId) {
    if (login_check($mysqli) == true) {
        if (isset($_SESSION['usertype'], $_SESSION['user_id'])) {
            $hash = hash('sha512', $studyId . $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname']);
            header('Location: ' . $serverhost . 'study-prepare-moderator.php?studyId=' . $studyId . '&token=' . $h . '&h=' . $hash);
        } else {
            header('Location: ' . $serverhost . 'study-prepare-fallback.php?studyId=' . $studyId . '&h=' . $h);
        }
    } else {
        header('Location: ' . $serverhost . 'study-prepare-fallback.php?studyId=' . $studyId . '&h=' . $h);
    }
} else {
    header('Location: ' . $serverhost . 'study-prepare-failure.php');
}
?>
