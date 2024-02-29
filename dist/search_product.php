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
            echo '<div class="products relative rounded-lg p-4 cursor-pointer shadow-lg bg-dark-brown" style="min-width: 175px; max-width: 300px; height: 264px;" data-id="'.$product['id'].'" onmouseover="showButtons(this)" onmouseout="hideButtons(this)">
                     <div class="absolute flex flex-col items-center top-4 right-4">
                        <button class="edit-btn rounded-md p-2 cursor-pointer hover:block hidden" onclick="showEditModal('.$product['id'] .')">
                           <img class="w-8 h-8 rounded-md" src="../images/edit-svgrepo-com.svg">
                        </button>
                        <button class="delete-btn rounded-md p-2 cursor-pointer hover:block hidden" onclick="showDeleteModal('.$product['id'].')">
                           <img class="w-8 h-8 rounded-md" src="../images/delete-svgrepo-com.svg">
                        </button>
                     </div>
                     <button class="w-full h-full" onclick="showViewModal('.$product['id'].')">
                        <img class="w-full h-full object-cover" src="../uploaded_img/'.$product['image'].'?>">
                     </button>
               </div>';
        }
    } else {
        echo '<p class="text-gray text-2xl">No Products Found!</p>';
    }
} else {
    echo '<p class="text-gray text-2xl">Please enter a search term!</p>';
}
?>
