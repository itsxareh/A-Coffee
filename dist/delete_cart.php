<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $cartId = $_GET['id'];
    
    $delete_cart = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $delete_cart->execute([$cartId]);
    
    echo 'Product deleted from cart successfully';
} else {
    echo 'Invalid request';
}
?>