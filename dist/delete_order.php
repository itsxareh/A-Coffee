<?php
include 'config.php';
$uid = $_SESSION['uid'];

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $orderId = $_GET['id'];
    
    $delete_order = $conn->prepare("UPDATE orders SET delete_flag = 1 WHERE id = ?");
    $delete_order->execute([$orderId]);

    
    $log = $_SESSION['name']. " deleted an order: ". $orderId .".";
    $insert_log = $conn->prepare("INSERT INTO activity_log(uid, log, datetime) VALUES (?,?,?)");
    $insert_log->bindParam(1, $uid);
    $insert_log->bindParam(2, $log);
    $insert_log->bindParam(3, $currentDateTime);
    $insert_log->execute();
    echo 'Order deleted successfully';
} else {
    echo 'Invalid request';
}
?>