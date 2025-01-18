<?php
include 'config.php';
$uid = $_SESSION['uid'];

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $staffId = $_GET['id'];
    
    $delete_staff = $conn->prepare("UPDATE users SET delete_flag = 1 WHERE id = ?");
    $delete_staff->execute([$staffId]);
    
    $select_item = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $select_item->execute([$itemId]);
    $item = $select_item->fetch(PDO::FETCH_ASSOC);
    $name = $item['name'];
    
    $log = $_SESSION['name']. " deleted a user: ". ucwords($name) .".";
    $insert_log = $conn->prepare("INSERT INTO activity_log(uid, log, datetime) VALUES (?,?,?)");
    $insert_log->bindParam(1, $uid);
    $insert_log->bindParam(2, $log);
    $insert_log->bindParam(3, $currentDateTime);
    $insert_log->execute();
    echo 'User deleted successfully';
} else {
    echo 'Invalid request';
}
?>