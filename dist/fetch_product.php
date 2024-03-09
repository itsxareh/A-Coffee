<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT id, name, price, category, ingredients, description, image  FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);
} else {
    echo json_encode(array('error' => 'ID parameter is missing'));
}
?>
