<?php
include 'config.php';

try {
    if (isset($_POST['cart_id']) && isset($_POST['temperature'])) {
        $cart_id = $_POST['cart_id'];
        $temperature = $_POST['temperature'];
        
        $stmt = $conn->prepare("UPDATE cart SET temperature = ? WHERE id = ?");
        $stmt->execute([$temperature, $cart_id]);
        
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    }
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>