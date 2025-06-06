<?php
include 'config.php';

$name = $_GET['name'] ?? '';
$id = $_GET['id'] ?? null;

if ($name) {
    try {
        if ($id) {
            $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM category WHERE category_name = ? AND id != ? AND delete_flag = 0");
            $stmt->execute([$name, $id]);
        } else {
            $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM category WHERE category_name = ? AND delete_flag = 0");
            $stmt->execute([$name]);
        }
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $exists = $result['count'] > 0;

        echo json_encode(['exists' => $exists]);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No name provided.']);
}
?>