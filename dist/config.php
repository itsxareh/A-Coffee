<?php 
session_start();
$dbname = "mysql:host=localhost;dbname=a-coffee";
$username = "root";
$password = "";

$conn = new PDO($dbname, $username, $password);

date_default_timezone_set('Asia/Manila');
$currentDateTime = date('m-d-Y H:i:s');
?>