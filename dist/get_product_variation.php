<?php
include 'config.php';

// Ensure we're sending JSON response
header('Content-Type: application/json');

if (isset($_POST['id'])) {
    $product_id = $_POST['id'];
    
    try {
        $check_variation = $conn->prepare("SELECT *, product_variations.price as price, product_variations.id as id FROM `product_variations` LEFT JOIN products ON products.id = product_variations.product_id  WHERE product_variations.product_id = ?");
        $check_variation->execute([$product_id]);
        $variations = $check_variation->fetchAll(PDO::FETCH_ASSOC);

        if (empty($variations)) {
            echo json_encode([
                'error' => 'No variations found for this product'
            ]);
            exit;
        }
        
        $variations_data = array_map(function($variation) {
            return [
                'id' => $variation['id'],
                'name' => $variation['name'],
                'size' => $variation['size'],
                'price' => $variation['price'],
                'image' => $variation['image'],
            ];
        }, $variations);
        
        echo json_encode([
            'success' => true,
            'variations' => $variations_data
        ]);
        
    } catch (PDOException $e) {
        echo json_encode([
            'error' => 'Database error: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'error' => 'Product ID not provided'
    ]);
}