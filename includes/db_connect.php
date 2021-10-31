<?php
include_once 'psl-config.php'; 

// Create database connection
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

// Check the database connection first
if ($conn->connect_error) {
    var_dump(HOST, USER, PASSWORD, DATABASE);
    die("Connection failed: " . $conn->connect_error);
}

$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
$mysqli2 = new mysqli(HOST, USER, PASSWORD, DATABASE);
$mysqli3 = new mysqli(HOST, USER, PASSWORD, DATABASE);