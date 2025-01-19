<?php 
include 'config.php';

$uid = $_SESSION['uid'];
$log = $_SESSION['name'].' logged out.';
$insert_log = $conn->prepare("INSERT INTO `activity_log`(uid, log, datetime) VALUES (?,?,?)");
$insert_log->bindParam(1, $uid);
$insert_log->bindParam(2, $log);
$insert_log->bindParam(3, $currentDateTime);
$insert_log->execute();

session_unset();
session_destroy();

header('location:login.php');
?>