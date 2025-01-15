<?php
include 'config.php';

if (isset($_GET['id'])) {
    $cartId = $_GET['id'];

    $get_cart = $conn->prepare("SELECT * FROM cart WHERE id = ?");
    $get_cart->execute([$cartId]);
    $cart = $get_cart->fetch(PDO::FETCH_ASSOC);

    if ($cart) {
        echo json_encode($cart);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode(['error' => 'Product ID is not provided']);
}
?>