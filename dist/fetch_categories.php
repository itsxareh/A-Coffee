<?php
include 'config.php';

try {
    $stmt = $conn->prepare("SELECT id, category_name FROM category WHERE delete_flag = 0 ORDER BY category_name");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($categories);
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>