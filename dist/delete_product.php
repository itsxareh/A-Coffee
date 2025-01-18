<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $productId = $_GET['id'];
    
    $delete_product = $conn->prepare("UPDATE products SET delete_flag = 1 WHERE id = ?");
    $delete_product->execute([$productId]);
    echo 'Product deleted successfully';
} else {
    echo 'Invalid request';
}
?>