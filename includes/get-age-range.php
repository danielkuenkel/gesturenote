<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'functions.php';
include_once 'db_connect.php';
include_once 'psl-config.php';

if ($select_stmt = $mysqli->prepare("SELECT birthday, gender FROM users WHERE usertype = 'tester' && birthday != 0 ORDER BY birthday ASC")) {
    if (!$select_stmt->execute()) {
        echo json_encode(array('status' => 'selectError'));
        exit();
    } else {
        $select_stmt->store_result();
        $select_stmt->bind_result($birthday, $gender);
        $tester = null;
        while ($select_stmt->fetch()) {
            $tester[] = array('birthday' => $birthday,
                'gender' => $gender);
        }

        echo json_encode(array('status' => 'success', 'tester' => $tester));
        exit();
    }
} else {
    echo json_encode(array('status' => 'statementError'));
    exit();
}