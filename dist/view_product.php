<?php 
if (isset($_GET['id'])){
    $id = $_GET['id'];
    $select_products = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $select_products->execute([$id]);
    $products = $select_products->fetch(PDO::FETCH_ASSOC); 
    if ($products) {
        $ingredients = explode(', ', $products['ingredients']);
?>
<div class="grid cols-grid-1 cols-grid-2 gap-4">
    <div class="flex items-center" style="min-height:400px; max-height: 500px;">
        <img class="w-full h-full object-cover rounded" src="../uploaded_img/<?= isset($products['image']) ? $products['image'] : ''; ?>">
    </div>
    <div class="flex items-start justify-center flex-col p-4">
        <div class="flex justify-between w-full">
            <div class="">
            <label class="text-white text-md font-medium leading-tight tracking-normal mt-2 block" for="name">Name</label>
            <span class="text-gray text-lg font-medium" id="name"><?= ucwords(isset($products['name'])) ? ucwords( $products['name']) : 'N/A'; ?></span>
            </div>
            <div class="">
                <label class="text-white text-md font-medium leading-tight tracking-normal mt-2 block" for="price">Price</label>
                <span class="text-gray text-lg font-medium" id="price"><?= isset($products['price']) ? '₱'.$products['price'] : 'N/A'; ?></span>
            </div>
        </div>
        <label class="text-white text-md font-medium leading-tight tracking-normal mt-2" for="category">Category</label>
        <span class="text-gray text-lg font-medium" id="category"><?= isset($products['category']) ? ucwords($products['category']) : 'N/A'; ?></span>
        <label class="text-white text-md font-medium leading-tight tracking-normal mt-2" for="ingredients">Ingredients</label>
        <span class="text-gray text-lg font-medium" id="ingredients">    
            <ul>
                <?php foreach ($ingredients as $ingredient): ?>
                    <li class="relative pl-4">
                        <span class="absolute left-0 top-0 h-full flex items-center">•</span>
                        <span class=""><?= ucwords($ingredient) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </span>
        <label class="text-white text-md font-medium leading-tight tracking-normal mt-2" for="description">Description</label>
        <span class="text-gray text-lg font-medium" id="description"><?= ucwords(isset($products['gender'])) ? ucwords($products['description']) : 'N/A'; ?></span>

    </div>
</div>
<?php 
    } else {
        echo "Staff not found.";
    }
}
?>
