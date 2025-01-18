<?php
include 'config.php';

$searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '';

$select_products = $conn->prepare("
    SELECT DISTINCT 
        p.*, 
        c.category_name,
        c.id as category_id
    FROM 
        products p
    LEFT JOIN 
        category c ON p.category = c.id
    WHERE 
        p.name LIKE ?
        AND p.delete_flag = 0
    ORDER BY 
        c.id, p.name
");

$select_products->execute([$searchTerm]);
$products = $select_products->fetchAll(PDO::FETCH_ASSOC);

if (count($products) > 0) {
    $current_category = null;
    
    foreach ($products as $product) {
        if ($current_category !== $product['category_id']) {
            if ($current_category !== null) {
                echo '</div></div></div>'; 
            }
            $current_category = $product['category_id'];
            ?>
            <div class="category-section w-full">
                <h2 class="text-gray text-xl font-semibold mb-4 salsa text-center w-full cursor-pointer category-header flex items-center gap-2" 
                    data-category="<?= $product['category_id']?>">
                    <span><?= ucwords($product['category_name'])?></span>
                    <svg class="w-4 h-4 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </h2>
                <div class="products-container" data-category="<?= $product['category_id']?>">
                    <div class="grid autofit-grid gap-6 justify-start items-start">
        <?php
        }
        $check_product_variation = $conn->prepare("SELECT *, pv.id as vid, pv.price as price, p.image FROM product_variations pv LEFT JOIN products p ON pv.product_id = p.id WHERE pv.product_id = ?");
        $check_product_variation->execute([$product['id']]);
        $product_variations = $check_product_variation->fetchAll(PDO::FETCH_ASSOC);

        if (count($product_variations) > 1) {
            ?>
            <div class="products relative rounded-lg p-4 cursor-pointer shadow-lg bg-dark-brown h-56" data-id="<?= $product['id'] ?>">
                <div class="flex flex-col justify-center">
                    <div class="rounded-md relative w-full h-36 flex flex-col items-center justify-center">
                        <div class="blur-bg absolute w-full h-full hidden rounded-md" style="background-color: rgba(0,0,0,0.5);"></div>
                        <div class="absolute w-1/2">
                            <button id="variationBtn" class="cart-btn rounded-md p-2 cursor-pointer hidden" onclick="showVariationModal(<?= $product['id'] ?>)">
                                <img class="rounded-md" src="../images/cart-arrow-down-svgrepo-com.svg">
                            </button>
                        </div>
                        <img class="w-full h-full object-cover rounded-md" src="../uploaded_img/<?= $product['image'] ?>"/>
                    </div>
                    <div class="flex justify-center items-center">
                        <p style="padding: 0.25rem;" class="text-center text-white salsa text-md p-1"><?= ucwords($product['name']) ?></p>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="products relative rounded-lg p-4 cursor-pointer shadow-lg bg-dark-brown h-56" data-id="<?= $product_variations[0]['id'] ?>">
                <div class="flex flex-col justify-center">
                    <div class="rounded-md relative w-full h-36 flex flex-col items-center justify-center">
                        <div class="blur-bg absolute w-full h-full hidden rounded-md" style="background-color: rgba(0,0,0,0.5);"></div>
                        <div class="absolute w-1/2">
                            <form id="add_to_cart" action="add_to_cart.php" method="POST" enctype="multipart/form-data">
                                <input type="text" class="hidden" id="pid" name="pid" value="<?= $product_variations[0]['product_id']?>">
                                <input type="text" class="hidden" id="vid" name="vid" value="<?= $product_variations[0]['vid'] ?>">
                                <input type="text" class="hidden" id="name" name="name" value="<?= $product['name']?>" autocomplete="off">
                                <input type="text" class="hidden" id="price" name="price" value="<?= $product_variations[0]['price']?>">
                                <input type="text" class="hidden" id="quantity" name="quantity" value="1">
                                <input type="text" class="hidden" id="image" name="image" value="<?= $product['image']?>">
                                <button type="submit" id="cartBtn" class="cart-btn rounded-md p-2 cursor-pointer hidden">
                                    <img class="rounded-md" src="../images/cart-arrow-down-svgrepo-com.svg">
                                </button>
                            </form>
                        </div>
                        <img class="w-full h-full object-cover rounded-md" src="../uploaded_img/<?= $product['image'] ?>"/>
                    </div>
                    <div class="flex justify-center items-center">
                        <p style="padding: 0.25rem;" class="text-white salsa text-md p-1"><?= ucwords($product['name']) ?></p>
                    </div>
                </div>
            </div>
        <?php }
    }
    echo '</div></div></div>';
} else {
    echo '<p class="text-gray text-medium font-semibold p-3 py-4 text-center">No products found.</p>';
}
?>