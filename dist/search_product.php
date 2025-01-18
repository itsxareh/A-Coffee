<?php
include 'config.php';
error_reporting(E_ALL); 
ini_set('display_errors', 1);

$searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '';

if ($searchTerm !== '') {
    $select_products = $conn->prepare("SELECT * FROM products WHERE (name LIKE ? OR category LIKE ?) AND delete_flag = 0 ");
    $select_products->execute([$searchTerm, $searchTerm]);

    $products = $select_products->fetchAll(PDO::FETCH_ASSOC);

    if (count($products) > 0) {
        foreach ($products as $product) { ?>
        <div class="products relative rounded-lg p-4 cursor-pointer shadow-lg bg-dark-brown h-40 max-w-lg" title="<?= ucwords($product['name']) ?>" data-id="<?= $product['id'] ?>" onmouseover="showButtons(this)" onmouseout="hideButtons(this)">
            <div class="relative flex w-full h-full flex-col items-center justify-center">
                <div class="blur-bg absolute w-full h-full hidden rounded-md" style="background-color: rgba(0,0,0,0.5);"></div>
                <div class="absolute flex flex-col items-center top-0 right-0 z-10">
                    <button title="Edit" class="edit-btn rounded-md p-2 cursor-pointer hover:block hidden" onclick="showEditModal(<?= $product['id'] ?>)">
                        <img class="w-5 h-5 rounded-md" src="../images/edit-svgrepo-com.svg">
                    </button>
                    <button title="Delete" class="delete-btn rounded-md p-2 cursor-pointer hover:block hidden" onclick="showDeleteModal(<?= $product['id'] ?>)">
                        <img class="w-5 h-5 rounded-md" src="../images/delete-svgrepo-com.svg">
                    </button>
                </div>
                <button type="button" id="view-btn" class="view-btn w-full h-full absolute cart-btn rounded-md cursor-pointer hidden" onclick="showViewModal(<?= $product['id'] ?>)">
                    <center><img title="View" class="rounded-md w-12 h-12 text-center" src="../images/details-more-svgrepo-com.svg"></center>
                </button>
                <img class="productImg w-full h-full object-cover rounded-md" src="../uploaded_img/<?= isset($product['image']) ? $product['image'] : 'IcedCappuccino.jpg' ?>">
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
