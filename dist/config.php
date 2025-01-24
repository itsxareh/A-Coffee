<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$dbConfig = [
    'host' => 'localhost',
    'dbname' => 'a-coffee',
    'username' => 'root',
    'password' => '',
];

try {
    $conn = new PDO(
        "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};",
        $dbConfig['username'],
        $dbConfig['password'],
    );

    date_default_timezone_set('Asia/Manila');
    $currentDateTime = date('d-m-Y H:i:s');
} catch (PDOException $e) {
    error_log("Database Connection Error: " . $e->getMessage());
    exit("Database connection failed. Please try again later.");
}
?>