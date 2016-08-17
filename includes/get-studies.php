<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connect.php';
include_once 'psl-config.php';

session_start();
if (isset($_SESSION['user_id'])) {
    $sessionUserId = $_SESSION['user_id'];

    if ($select_stmt = $mysqli->prepare("SELECT * FROM studies WHERE user_id = '$sessionUserId' ORDER BY created ASC")) {
        if (!$select_stmt->execute()) {
            echo json_encode(array('status' => 'selectError'));
            exit();
        } else {
            $select_stmt->bind_result($id, $userId, $data, $urlToken, $created);
            while ($select_stmt->fetch()) {
                $studies[] = array('id' => $id,
                    'userId' => $userId,
                    'data' => json_decode_nice($data),
                    'urlToken' => $urlToken,
                    'created' => $created);
            }
            echo json_encode(array('status' => 'success', 'studies' => $studies));
        }
    } else {
        echo json_encode(array('status' => 'statementError'));
    }
} else {
    echo json_encode(array('status' => 'error'));
}

function json_decode_nice($json, $assoc = TRUE) {
    $json = str_replace(array("\n", "\r"), "\\n", $json);
    $json = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/', '$1"$3":', $json);
    $json = preg_replace('/(,)\s*}$/', '}', $json);
    return json_decode($json, $assoc);
}
