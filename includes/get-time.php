<?php
header("Content-Type: application/json; charset=UTF-8");

$serverTime = microtime(true);
echo json_encode(array('time' => $serverTime));