<?php 
session_start();
$dbname = "mysql:host=localhost;dbname=a-coffee";
$username = "root";
$password = "";

$conn = new PDO($dbname, $username, $password);

?>