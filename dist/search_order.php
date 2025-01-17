<?php
include 'config.php';
error_reporting(E_ALL); 
ini_set('display_errors', 1);
$uid = $_SESSION['uid'];
$searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '';

if ($searchTerm !== '') {
    $select_categories = $conn->prepare("SELECT 
        category.id AS category_id, 
        category.category_name AS category_name, 
        COUNT(products.id) AS product_count
        FROM 
            category
        LEFT JOIN 
            products 
        ON 
            products.category = category.id
        WHERE 
            products.name LIKE ?
        GROUP BY 
            category.id, category.category_name
        ORDER BY 
            category.id;");
    $select_categories->execute([$searchTerm]);
    $categories = $select_categories->fetchAll(PDO::FETCH_ASSOC);

    if (count($categories) > 0) {
        foreach ($categories as $category) { ?>
            <div class="category-section w-full">
                <h2 class="text-gray text-xl font-semibold mb-4 salsa text-center w-full cursor-pointer category-header flex items-center gap-2" 
                    data-category="<?= $category['category_id'] ?>">
                    <span><?= ucwords($category['category_name']) ?>(<?= $category['product_count'] ?>)</span>
                    <svg class="w-4 h-4 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </h2>
                <div class="products-container" data-category="<?= $category['category_id'] ?>">
                    <div class="grid autofit-grid gap-6 justify-start items-start">
                        <?php
                        $select_products = $conn->prepare("SELECT * FROM products WHERE category = ? AND name LIKE ?");
                        $select_products->execute([$category['category_id'], $searchTerm]);
                        $products = $select_products->fetchAll(PDO::FETCH_ASSOC);

                        if (count($products) > 0) {
                            foreach ($products as $product) { ?>
                                <div class="products relative rounded-lg p-4 cursor-pointer shadow-lg bg-dark-brown h-56 " data-id="<?= $product['id'] ?>">
                                    <div class="flex flex-col justify-center">
                                        <div class="rounded-md relative w-full h-40 flex flex-col items-center justify-center">
                                            <div class="blur-bg absolute w-full h-full hidden rounded-md" style="background-color: rgba(0,0,0,0.5);"></div>
                                            <div class="absolute w-1/2">
                                                <form id="add_to_cart" action="add_to_cart.php" method="POST" enctype="multipart/form-data">
                                                    <input type="text" class="hidden" id="uid" name="uid" value="<?= $uid ?>">
                                                    <input type="text" class="hidden" id="pid" name="pid" value="<?= $product['id'] ?>">
                                                    <input type="text" class="hidden" id="name" name="name" value="<?= $product['name'] ?>">
                                                    <input type="text" class="hidden" id="price" name="price" value="<?= $product['price'] ?>">
                                                    <input type="text" class="hidden" id="quantity" name="quantity" value="1">
                                                    <input type="text" class="hidden" id="image" name="image" value="<?= $product['image'] ?>">
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
                        } else {
                            echo '<p class="text-gray text-medium font-semibold p-3 py-4 text-center">No products found in this category.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php }
    } else {
        echo '<p class="text-gray text-medium font-semibold p-3 py-4 text-center">No products found.</p>';
    }
} else {
    echo '<p class="text-gray text-2xl">Please enter a search term!</p>';
}
?>
<script>

</script>