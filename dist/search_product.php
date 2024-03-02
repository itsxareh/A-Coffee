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
        foreach ($products as $product) { ?>
        <div class="products relative rounded-lg p-4 cursor-pointer shadow-lg bg-dark-brown" style="height: 264px;" data-id="<?= $product['id'] ?>" onmouseover="showButtons(this)" onmouseout="hideButtons(this)">
            <div class="relative flex w-full h-full flex-col items-center justify-center">
                <div class="blur-bg absolute w-full h-full hidden rounded-md" style="background-color: rgba(0,0,0,0.5);"></div>
                <div class="absolute flex flex-col items-center top-4 right-4 z-10">
                    <button class="edit-btn rounded-md p-2 cursor-pointer hover:block hidden" onclick="showEditModal(<?= $product['id'] ?>)">
                        <img class="w-8 h-8 rounded-md" src="../images/edit-svgrepo-com.svg">
                    </button>
                    <button class="delete-btn rounded-md p-2 cursor-pointer hover:block hidden" onclick="showDeleteModal(<?= $product['id'] ?>)">
                        <img class="w-8 h-8 rounded-md" src="../images/delete-svgrepo-com.svg">
                    </button>
                </div>
                <button type="button" id="view-btn" class="view-btn w-full h-full absolute cart-btn rounded-md cursor-pointer hidden" onclick="showViewModal(<?= $product['id'] ?>)">
                    <center><img class="rounded-md w-1/3 h-1/3 text-center" src="../images/view-svgrepo-com.svg"></center>
                </button>
                <img class="w-full h-full object-cover rounded-md" src="../uploaded_img/<?= $product['image'] ?>">
            </div>
        </div>
        <?php
        }
    } else {
        echo '<p class="text-gray text-medium font-semibold p-3 py-4 text-center">No products found.</p>';
    }
} else {
    echo '<p class="text-gray text-2xl">Please enter a search term!</p>';
}
?>
