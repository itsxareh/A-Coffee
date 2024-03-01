<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $itemId = $_GET['id'];
    
    $delete_item = $conn->prepare("DELETE FROM inventory WHERE id = ?");
    $delete_item->execute([$itemId]);
    
    echo 'Item deleted successfully';
} else {
    echo 'Invalid request';
}
?>