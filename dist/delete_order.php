<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $orderId = $_GET['id'];
    
    $delete_order = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $delete_order->execute([$orderId]);
    echo 'Order deleted successfully';
} else {
    echo 'Invalid request';
}
?>