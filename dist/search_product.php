<?php
include 'config.php';
error_reporting(E_ALL); 
ini_set('display_errors', 1);

$searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '';

if ($searchTerm !== '') {
    $select_products = $conn->prepare("SELECT * FROM products WHERE name LIKE ? OR category LIKE ?");
    $select_products->execute([$searchTerm, $searchTerm]);

    $products = $select_products->fetchAll(PDO::FETCH_ASSOC);

    if (count($products) > 0) {
        foreach ($products as $product) {
            echo '<a href="index.php?page=view_product&id=' . $product['id'] . '" class="rounded-lg p-4 cursor-pointer shadow-lg bg-dark-brown" style="min-width: 175px; max-width: 300px; height: 264px;">';
            echo '<img class="w-full h-full object-cover" src="../uploaded_img/' . $product['image'] . '">';
            echo '</a>';
        }
    } else {
        echo '<p class="text-gray text-2xl">No Products Found!</p>';
    }
} else {
    echo '<p class="text-gray text-2xl">Please enter a search term!</p>';
}
?>
