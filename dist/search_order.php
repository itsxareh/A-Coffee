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
            <div style="height: 14rem;" class="relative w-full h-full flex flex-col items-center justify-center">
            <div class="blur-bg absolute w-full h-full hidden rounded-md" style="background-color: rgba(0,0,0,0.5);"></div>
            <div class="absolute w-1/2">
                <form id="add_to_cart" action="add_to_cart.php" method="POST" enctype="multipart/form-data">
                    <input type="text" class="hidden" id="uid" name="uid" value="<?= $uid ?>">
                    <input type="text" class="hidden" id="pid" name="pid" value="<?= $product['id']?>">
                    <input type="text" class="hidden" id="name" name="name" value="<?= $product['name']?>">
                    <input type="text" class="hidden" id="price" name="price" value="<?= $product['price']?>">
                    <input type="text" class="hidden" id="quantity" name="quantity" value="1">
                    <input type="text" class="hidden" id="image" name="image" value="<?= $product['image']?>">
                    <button type="submit" id="cartBtn" class="cart-btn rounded-md p-2 cursor-pointer hidden">
                        <img class="rounded-md" src="../images/cart-arrow-down-svgrepo-com.svg">
                    </button>
                </form>
            </div>
            <img class="w-full h-full object-cover rounded-md" src="../uploaded_img/<?= $product['image'] ?>">
        </div>
        <p style="padding: 0.25rem;" class="text-white salsa text-xl p-1"><?= ucwords($product['name']) ?></p>
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
