<?php
include 'config.php';
$uid = $_SESSION['uid'];

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $itemId = $_GET['id'];
    
    $delete_item = $conn->prepare("UPDATE inventory SET delete_flag = 1 WHERE id = ?");
    $delete_item->execute([$itemId]);

    $select_item = $conn->prepare("SELECT * FROM inventory WHERE id = ?");
    $select_item->execute([$itemId]);
    $item = $select_item->fetch(PDO::FETCH_ASSOC);
    $name = $item['name'];
    
    $log = $_SESSION['name']. " deleted an item in inventory: ". ucwords($name) .".";
    $insert_log = $conn->prepare("INSERT INTO activity_log(uid, log, datetime) VALUES (?,?,?)");
    $insert_log->bindParam(1, $uid);
    $insert_log->bindParam(2, $log);
    $insert_log->bindParam(3, $currentDateTime);
    $insert_log->execute();

    echo 'Item deleted successfully';
} else {
    echo 'Invalid request';
}
?>