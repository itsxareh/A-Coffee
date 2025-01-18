<?php
include 'config.php';

try {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        $stmt = $conn->prepare("
            SELECT p.*, c.category_name, c.id as category_id 
            FROM products p 
            LEFT JOIN category c ON p.category = c.id 
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt_variations = $conn->prepare("
            SELECT size, price, ingredients 
            FROM product_variations 
            WHERE product_id = ? 
            ORDER BY CAST(price AS DECIMAL(10,2))
        ");
        $stmt_variations->execute([$id]);
        $variations = $stmt_variations->fetchAll(PDO::FETCH_ASSOC);
        
        $response = [
            'id' => $product['id'],
            'name' => $product['name'],
            'category' => $product['category_id'],
            'category_name' => $product['category_name'],
            'description' => $product['description'],
            'image' => $product['image'],
            'variations' => $variations
        ];
        
        echo json_encode($response);
    }
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>