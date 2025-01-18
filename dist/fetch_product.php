<?php
include 'config.php';

try {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        $stmt = $conn->prepare("SELECT *, category.id as category_id FROM products LEFT JOIN category ON products.category = category.id WHERE products.id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt_variations = $conn->prepare("SELECT * FROM product_variations WHERE product_id = ?");
        $stmt_variations->execute([$id]);
        $variations = $stmt_variations->fetchAll(PDO::FETCH_ASSOC);
        
        $response = [
            'id' => $product['id'],
            'name' => $product['name'],
            'category' => $product['category_id'],
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
