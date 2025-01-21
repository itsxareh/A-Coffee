<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);
?>
<style>
.category-header svg {
    transition: transform 0.3s ease;
}
.category-header.collapsed svg {
    transform: rotate(-90deg);
}
.products-container {
    transition: all 0.3s ease;
    margin-bottom: 10px;
}
.products-container.hidden {
    display: none;
}


</style>
<div class="hide-message hidden">
    <div class="message rounded-lg p-4 flex items-start">
        <span id="message" class="text-sm text-white"></span>
        <button class="-m-1" onclick="this.parentElement.remove();"><img class="w-5 h-5" src="../images/close-svgrepo-com.svg"></button>
    </div>
</div>
<div class="upper flex justify-between mb-4">
    <span class="text-gray text-2xl salsa">Order</span>
    <div class="button-input flex">
        <?php 
        $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE uid = ?");
        $check_cart_numbers->execute([$uid]);
    
        $total = $check_cart_numbers->rowCount();
        ?>
        <input id="search" name="search" class="search ml-4 px-4 py-2 w-48 rounded-md salsa text-black" type="text">
    </div>
</div>
<div id="productsList" class="flex flex-col gap-2">
    <?php 
    $select_category = $conn->prepare("SELECT 
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
            category.delete_flag = 0
        GROUP BY 
            category.id, category.category_name
        ORDER BY 
            category.id;");
    $select_category->execute();
    $category = $select_category->fetchAll(PDO::FETCH_ASSOC);
    if (count($category) > 0){
        foreach ($category as $category){ ?>
            <div class="category-section w-full">
                <h2 class="text-gray text-xl font-semibold mb-4 salsa text-center w-full cursor-pointer category-header flex items-center gap-2" 
                    data-category="<?= $category['category_id']?>">
                    <span><?= ucwords($category['category_name'])?>(<?= $category['product_count']?>)</span>
                    <svg class="w-4 h-4 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </h2>
                <div class="products-container" data-category="<?= $category['category_id']?>">
                    <div class="grid autofit-grid gap-6 justify-start items-start">
                        <?php 
                        $select_products = $conn->prepare("SELECT * FROM products WHERE category = ? AND delete_flag = 0");
                        $select_products->execute([$category['category_id']]);
                        $products = $select_products->fetchAll(PDO::FETCH_ASSOC);
                        if (count($products) > 0){ 
                            foreach($products as $product){
                                $check_product_variation = $conn->prepare("SELECT *, pv.id as vid, pv.price as price, p.image FROM product_variations pv LEFT JOIN products p ON pv.product_id = p.id WHERE pv.product_id = ?");
                                $check_product_variation->execute([$product['id']]);
                                $product_variations = $check_product_variation->fetchAll(PDO::FETCH_ASSOC);
                                if (count($product_variations) > 1){ ?>
                                    <div class="products relative rounded-lg p-4 cursor-pointer shadow-lg bg-dark-brown h-56" data-id="<?= $product['id'] ?>">
                                        <div class="flex flex-col justify-center">
                                            <div class="rounded-md relative w-full h-36 flex flex-col items-center justify-center">
                                                <div class="blur-bg absolute w-full h-full hidden rounded-md" style="background-color: rgba(0,0,0,0.5);"></div>
                                                <div class="absolute w-1/2">
                                                    <button id="variationBtn" class="cart-btn rounded-md p-2 cursor-pointer hidden" onclick="showVariationModal(<?= $product['id'] ?>)">
                                                        <img class="rounded-md" src="../images/cart-arrow-down-svgrepo-com.svg">
                                                    </button>
                                                </div>
                                                <img class="w-full h-full object-cover rounded-md" src="../uploaded_img/<?= isset($product['image']) ? $product['image'] : 'IcedCappuccino.jpg' ?>"/>
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
                                                    <input type="text" class="hidden" id="image" name="image" value="<?= isset($product['image']) ? $product['image'] : 'IcedCappuccino.jpg'?>">
                                                    <button type="submit" id="cartBtn" class="cart-btn rounded-md p-2 cursor-pointer hidden">
                                                        <img class="rounded-md" src="../images/cart-arrow-down-svgrepo-com.svg">
                                                    </button>
                                                </form>
                                            </div>
                                            <img class="w-full h-full object-cover rounded-md" src="../uploaded_img/<?= isset($product['image']) ? $product['image'] : 'IcedCappuccino.jpg' ?>"/>
                                        </div>
                                        <div class="flex justify-center items-center">
                                            <p style="padding: 0.25rem;" class="text-white salsa text-md p-1"><?= ucwords($product['name']) ?></p>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
    <?php }
    } else {
        echo '<p class="text-gray text-medium font-semibold p-3 py-4 text-center">No products found.</p>';
    }
    ?>
</div>
<div class="py-20 px-4 transition duration-150 ease-in-out z-10 fixed top-0 right-0 bottom-0 left-0 hidden h-full" id="variation-modal"> 
    <div class="absolute opacity-80 inset-0 z-0" style="background-color: rgba(0, 0, 0, 0.7);"></div>
    <div class="w-full max-w-xl relative mx-auto my-auto rounded-xl shadow-lg  bg-white ">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-4 border-b rounded-t">
                <h3 class="text-lg font-normal text-gray-900 rosarivo">
                    Select a variation
                </h3>
                <button title="Close" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="variationModalHandler()">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div id="variationLists" class="p-4 md:p-5">
                <div id="variation-modal-content"></div>
                <div id="variationModal" class="flex justify-end items-center">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="cart-container fixed right-8 bottom-8">
        <div class="relative">
            <button id="cartButton" title="Cart" class="w-12 h-12 p-2 bg-white transition duration-150 ease-in-out rounded-full relative">
                <span id="ordersNo" class="absolute text-white bg-red-600 rounded-full px-2 -top-2 -right-2"><?= $total ?></span>
                <img class="w-full h-full" src="../images/cart-shopping-svgrepo-com.svg">
            </button>
            <div id="orderCart" class="order-cart absolute max-w-lg bg-white rounded-md shadow-lg z-50">
                <div class="relative">
                    <div class="cart-container px-4 rounded-md bg-white right-0">
                        <div class="cart-header flex items-center justify-between text-gray salsa text-md font-semibold py-2">
                            <span class="text-black salsa text-xl">Orders</span>
                            <button class="close-cart p-2 cursor-pointer" onclick="hideCart()">
                                <img class="w-4 h-4" src="../images/close-svgrepo-com.svg">
                            </button>
                        </div>
                        <div class="cart-body py-2">
                            <div id="list-cart" class="grid relative autofit-grid1 gap-3 max-h-xl overflow-y-auto">
                            <?php
                                $check_cart = $conn->prepare("SELECT *, cart.id as id, product_variations.size as variation FROM `cart` LEFT JOIN product_variations ON cart.variation_id = product_variations.id WHERE uid = ?");
                                $check_cart->bindParam(1, $uid);
                                $check_cart->execute();
                                $carts = $check_cart->fetchAll(PDO::FETCH_ASSOC);
                                $total_cart = $conn->prepare("SELECT *, SUM(price * quantity) as total FROM cart WHERE uid = ?");
                                $total_cart->execute([$uid]);
                                $totalCart = $total_cart->fetch(PDO::FETCH_ASSOC);

                                if(count($carts) > 0){
                                    foreach($carts as $cart){ ?>
                                        <div class="cart relative rounded-md bg-dark-brown flex flex-start items-center h-28" data-id="<?= $cart['id'] ?>">
                                            <div class="w-28 h-full">
                                                <img class="rounded-tl-md rounded-bl-md w-full h-full object-cover" src="../uploaded_img/<?=$cart['image']?>">
                                            </div>
                                            <div class="flex-1 ml-2 p-2">
                                                <h3 class="text-white font-normal text-sm capitalize rosarivo leading-3">
                                                    <?= $cart['name']?> <?= isset($cart['variation']) ? '('.$cart['variation'].')' : '' ?>
                                                </h3>
                                                <p class="text-gray-400 rosarivo">₱<span class="price"><?= $cart['price'] * $cart['quantity']?></span></p>
                                                
                                                <div class="flex items-center gap-2 my-1">
                                                    <div class="flex bg-light-brown rounded-md">
                                                        <button 
                                                            type="button" 
                                                            class="temperature-btn px-2 py-1 text-sm rosarivo rounded-l-md <?= $cart['temperature'] === 'Hot' ? 'bg-amber-600 text-white' : 'text-white' ?>"
                                                            onclick="updateTemperature(<?= $cart['id'] ?>, 'Hot')"
                                                        >
                                                            Hot
                                                        </button>
                                                        <button 
                                                            type="button" 
                                                            class="temperature-btn px-2 py-1 text-sm rosarivo rounded-r-md <?= $cart['temperature'] === 'Ice' ? 'bg-amber-600 text-white' : 'text-white' ?>"
                                                            onclick="updateTemperature(<?= $cart['id'] ?>, 'Ice')"
                                                        >
                                                            Ice
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="flex items-center mt-1">
                                                    <span class="text-white rosarivo mr-2">Quantity:</span>
                                                    <button title="Plus" type="button" class="quantity-btn rounded-tl-md rounded-bl-md px-2 text-gray bg-light-brown w-6 flex items-center justify-center" onclick="addQuantity(<?= $cart['id'] ?>)"><span>+</span></button>
                                                    <p class="text-white rosarivo mx-2"><span class="quantity"><?= $cart['quantity']?></span></p>
                                                    <button title="Minus" type="button" class="quantity-btn rounded-tr-md rounded-br-md px-2 text-gray bg-light-brown w-6 flex items-center justify-center" onclick="minusQuantity(<?= $cart['id'] ?>)"><span>-</span></button>
                                                </div>
                                            </div>
                                            <div class="absolute bottom-2 right-2">
                                                <button title="Delete" type="button" class="delete-btn deleteCart rounded-md p-2 cursor-pointer" data-id="<?= $cart['id'] ?>">
                                                    <img class="w-6 h-6 rounded-md" src="../images/delete-svgrepo-com.svg">
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <?php
                                    }
                                    ?>
                                    <div class="flex justify-between">
                                        <p class="text-md text-gray-600 rosarivo font-normal my-auto">Total: <span id="totalPlaceOrder" class="rosarivo font-bold text-gray-900"><?= $totalCart['total'] === 0 ? '₱0.00' : '₱'.number_format($totalCart['total'], 2) ?></span></p>
                                        <button title="Place Order" id="placeOrder" type="button" class="mt-0 px-8 py-2 rounded-3xl bg-light-brown focus:outline-none hover:bg-amber-400 transition duration-150 ease-in-out  salsa text-xl text-white" onclick="confirmModalHandler(true)">Place order</button>
                                    </div>
                                    <?php
                                } else {
                                    echo '
                                    <p class="text-black text-medium font-semibold p-3 py-4 text-center">Your cart is empty.</p>';
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="py-20 px-4 transition duration-150 ease-in-out z-10 fixed top-0 right-0 bottom-0 left-0 h-full hidden" id="notification-modal">
   	<div class="absolute opacity-80 inset-0 z-0" style="background-color: rgba(0, 0, 0, 0.7);"></div>
    <div class="w-full  max-w-lg p-5 relative mx-auto h-auto rounded-xl shadow-lg  bg-white ">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-whit" onclick="notificationModalHandler()">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 h-full flex flex-col justify-between">
                <h3 class="mb-4 text-xl font-bold text-gray-900">Approaching Low Quantity</h3>
                <p class="text-gray-500 text-md font-normal dark:text-gray-400 mb-6">The following item/s have low inventory quantity. Please restocking soon:<p>
                <div class="text-center"><span id="notification" class="text-md font-medium text-gray-900 mb-6"></span></div>
                <div class="p-3  mt-2 text-center space-x-4 md:block">
                    <button class="mb-2 md:mb-0 bg-light-brown px-5 py-2 text-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-amber-400" onclick="notificationModalHandler()">Okay</button>
                </div>
        </div>
    </div>
</div> 
<div class="py-20 px-4 transition duration-150 ease-in-out z-10 fixed top-0 right-0 bottom-0 left-0 hidden h-full" id="confirm-modal"> 
    <div class="absolute opacity-80 inset-0 z-0" style="background-color: rgba(0, 0, 0, 0.7);"></div>
    <div class="w-full max-w-4xl relative mx-auto my-auto rounded-xl shadow-lg  bg-white ">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-4 border-b rounded-t">
                <h3 class="text-lg font-normal text-gray-900 rosarivo">
                    Confirm Order
                </h3>
                <button title="Close" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="confirmModalHandler()">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div id="cartLists" class="p-4 md:p-5">
                <div id="cartListConfirmModal" class="grid autofit-grid1 gap-3">
                <?php
                $check_cart = $conn->prepare("SELECT *, cart.id as id, product_variations.size as variation FROM `cart` LEFT JOIN product_variations ON cart.variation_id = product_variations.id WHERE uid = ?");
                $check_cart->bindParam(1, $uid);
                $check_cart->execute();
                $carts = $check_cart->fetchAll(PDO::FETCH_ASSOC);
                if(count($carts) > 0){
                    foreach($carts as $cart){ ?>
                    <div class="mb-4 ms-4">            
                        <div class="flex items-center">
                            <img class="w-14 h-14 rounded-md mr-5" src="../uploaded_img/<?= $cart['image']?>" alt="">
                            <div class="flex-1 cart-item" data-id="<?= $cart['id'] ?>">
                                <h3 class="flex items-start mb-1 text-lg font-medium text-gray-900"><?= ucwords($cart['name']) ?> <?= !empty($cart['variation']) ? '('.$cart['variation'].')' : '' ?> 
                                <p class="ml-1" id="confirm-temperature">
                                    <?= !empty($cart['temperature']) ? '('.$cart['temperature'].')' : '' ?>
                                </p>
                                <p class="salsa bg-blue-100 text-black text-sm font-medium mr-2 px-2.5 py-0.5 rounded ms-3">x<span  id="confirm-quantity" ><?= $cart['quantity'] ?></span></p></h3>
                                <p class="block mb-3 text-sm font-normal leading-none text-gray-500">₱<span id="confirm-price" class="salsa"><?= $cart['price'] * $cart['quantity'] ?></span></p>
                            </div>               
                        </div>
                    </div>
                <?php
                    }
                }
                ?>
                </div>
                <?php
                $check_cart = $conn->prepare("SELECT *, SUM(price * quantity) as total FROM cart WHERE uid = ?");
                $check_cart->bindParam(1, $uid);
                $check_cart->execute();
                $carts = $check_cart->fetchAll(PDO::FETCH_ASSOC);
                if(count($carts) > 0){
                    foreach($carts as $cart){ ?>
                <div id="totalConfirmModal" class="flex justify-end items-center">
                    <div class="pr-5">
                        <p class="text-gray-500 text-sm font-medium leading-tight tracking-normal salsa" for="total">Total</p>
                        <p id="total"  class="salsa block mb-3 text-md font-normal leading-none text-gray-800 dark:text-gray-700">₱<span id="confirm-total" class="text-gray-800 salsa mb-3 text-md font-normal leading-none"><?= number_format($cart['total'], 2) ?></span></p>
                    </div>
                    <form id="add_order" action="" method="POST">
                        <input type="text" class="hidden" name="uid" id="uid" value="<?= $cart['uid'] ?>" title="uid" placeholder="">
                        <button title="Confirm" type="submit" id="submitBtn" class="addToOrder bg-light-brown border border-light-brown px-5 py-2 text-sm  font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-amber-400" data-id=<?= $cart['id']; ?> >Confirm</button>
                    </form>
                </div>
                <?php
                    }
                } 
                ?>
            </div>
        </div>
    </div>
</div>
<script>
const messages = document.getElementById("message");
const divMessage = document.getElementsByClassName('hide-message')[0];
const notification = document.getElementById("notification");
const divNotification = document.getElementById("notification-modal");
document.addEventListener('DOMContentLoaded', function() {
    const categoryHeaders = document.querySelectorAll('.category-header');
    
    categoryHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-category');
            const productsContainer = document.querySelector(`.products-container[data-category="${categoryId}"]`);
            
            productsContainer.classList.toggle('hidden');
            this.classList.toggle('collapsed');
            const isCollapsed = this.classList.contains('collapsed');
            localStorage.setItem(`category-${categoryId}-collapsed`, isCollapsed);
        });
        
        const categoryId = header.getAttribute('data-category');
        const isCollapsed = localStorage.getItem(`category-${categoryId}-collapsed`) === 'true';
        if (isCollapsed) {
            header.classList.add('collapsed');
            const productsContainer = document.querySelector(`.products-container[data-category="${categoryId}"]`);
            productsContainer.classList.add('hidden');
        }
    });
});

function updateTemperature(cartId, temperature) {
    fetch('update_temperature.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `cart_id=${cartId}&temperature=${temperature}`
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.success) {
            // Update temperature in the confirmation modal
            const confirmOrderModal = document.getElementById('confirm-modal');
            const cartItemInModal = confirmOrderModal.querySelector(`[data-id="${cartId}"]`);
            console.log(cartItemInModal);
            if (cartItemInModal) {
                const temperatureElement = cartItemInModal.querySelector('#confirm-temperature');
                if (temperatureElement) {
                    temperatureElement.textContent = ` (${temperature}) `;
                }
            } else {
                console.warn(`Cart item with ID ${cartId} not found in the confirmation modal.`);
            }

            // Update temperature buttons in the main cart UI
            const cartItemInCart = document.querySelector(`.cart[data-id="${cartId}"]`);
            if (cartItemInCart) {
                const buttons = cartItemInCart.querySelectorAll('.temperature-btn');
                buttons.forEach(btn => {
                    if (btn.textContent.trim() === temperature) {
                        btn.classList.add('bg-amber-600', 'text-white');
                    } else {
                        btn.classList.remove('bg-amber-600', 'text-white');
                    }
                });
            } else {
                console.warn(`Cart item with ID ${cartId} not found in the main cart.`);
            }
        } else {
            console.error('Failed to update temperature on the server:', data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
<script>
function handleInventoryResponse(data) {
    if (data.status === 'low' && data.items && data.items.length > 0) {
        let messageHTML = '';
        data.items.forEach((item, index) => {
            messageHTML += `
                <div class="mb-2 text-left">
                    <span class="font-medium">${index + 1}. ${item.product_name}</span>
                    <br>
                    <span class="text-red-500">Current stock: ${item.current_quantity}</span>
                    <br>
                    <span class="text-gray-600">Threshold: ${item.threshold}</span>
                </div>
            `;
        });
        showNotification(messageHTML);
    }
}

function showNotification(message) {
    notification.innerHTML = message;
    divNotification.classList.remove('hidden');
}

// Check inventory periodically
const INVENTORY_CHECK_INTERVAL = 30000; // 30 seconds
let inventoryChecker = setInterval(checkInventory, INVENTORY_CHECK_INTERVAL);

// Initial check when page loads
document.addEventListener('DOMContentLoaded', checkInventory);

// Cleanup interval when page unloads
window.addEventListener('unload', () => {
    clearInterval(inventoryChecker);
});

// Close modal with Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !divNotification.classList.contains('hidden')) {
        notificationModalHandler(false);
    }
});

function notificationModalHandler(val) {
    if (val) {
        fadeIn(divNotification);
    } else {
        fadeOut(divNotification);
    }
}
const searchInput = document.getElementById('search');
const productsList = document.getElementById('productsList');
let searchTimeout;

searchInput.addEventListener('input', function() {
    const searchTerm = this.value.trim();
    
    clearTimeout(searchTimeout);
    
    searchTimeout = setTimeout(() => {
        fetch(`search_order.php?search=${encodeURIComponent(searchTerm)}`)
        .then(response => response.text())
        .then(data => {
            productsList.innerHTML = data;
            
            initializeProductEventListeners();
        })
        .catch(error => {
            console.error('Error fetching products:', error);
        });
    }, 300); 
});

function initializeProductEventListeners() {
    document.querySelectorAll('.category-header').forEach(header => {
        header.addEventListener('click', function() {
            const categoryId = this.dataset.category;
            const container = document.querySelector(`.products-container[data-category="${categoryId}"]`);
            container.classList.toggle('hidden');
            this.querySelector('svg').classList.toggle('rotate-180');
        });
    });

    document.querySelectorAll('.products').forEach(product => {
        product.addEventListener('mouseenter', function() {
            this.querySelector('.blur-bg').classList.remove('hidden');
            this.querySelector('.cart-btn').classList.remove('hidden');
        });

        product.addEventListener('mouseleave', function() {
            this.querySelector('.blur-bg').classList.add('hidden');
            this.querySelector('.cart-btn').classList.add('hidden');
        });
    });

    document.querySelectorAll('#add_to_cart').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('add_to_cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(variationModalHandler){
                    variationModalHandler(false);
                }
                if (data.success === true) {
                    orderCart.classList.toggle('visible');
                    if (divMessage) {
                        divMessage.classList.remove('hidden');
                    }
                    messages.textContent = data.message;
                    ordersNo.innerHTML = data.total; 

                    // Update cart UI
                    const cartList = document.getElementById('list-cart');
                    if (cartList) {
                        cartList.innerHTML = '';

                        if (data.cart.length > 0) {
                            data.cart.forEach(cartItem => {
                                const cartHTML = `
                                <div class="cart relative rounded-md bg-dark-brown flex flex-start items-center h-28" data-id="${cartItem.id}">
                                    <div class="w-28 h-full">
                                        <img class="rounded-tl-md rounded-bl-md w-full h-full object-cover" src="../uploaded_img/${cartItem.image}" />
                                    </div>
                                    <div class="flex-1 ml-2 p-2">
                                        <h3 class="text-white font-normal text-sm capitalize rosarivo leading-3">${cartItem.name} ${cartItem.variation ? '(' + cartItem.variation + ')' : ''}</h3>
                                        <p class="text-gray-400 rosarivo">₱<span class="price">${cartItem.price * cartItem.quantity}</span></p>

                                        <div class="flex items-center gap-2 my-1">
                                            <div class="flex bg-light-brown rounded-md">
                                                <button 
                                                    type="button" 
                                                    class="temperature-btn px-2 py-1 text-sm rosarivo rounded-l-md ${cartItem.temperature === 'Hot' ? 'bg-amber-600 text-white' : 'text-white' }"
                                                    onclick="updateTemperature(${cartItem.id}, 'Hot')"
                                                >
                                                    Hot
                                                </button>
                                                <button 
                                                    type="button" 
                                                    class="temperature-btn px-2 py-1 text-sm rosarivo rounded-r-md ${cartItem.temperature === 'Ice' ? 'bg-amber-600 text-white' : 'text-white' }"
                                                    onclick="updateTemperature(${cartItem.id}, 'Ice')"
                                                >
                                                    Ice
                                                </button>
                                            </div>
                                        </div>

                                        <div class="flex items-center mt-1">
                                            <span class="text-white rosarivo mr-2">Quantity</span>
                                            <button title="Plus" type="button" class="quantity-btn rounded-tl-md rounded-bl-md px-2 text-gray bg-light-brown w-6 flex items-center justify-center" data-id="${cartItem.id}" onclick="addQuantity(${cartItem.id})"><span>+</span></button>
                                            <p class="text-white rosarivo mx-2"><span class="quantity">${cartItem.quantity}</span></p>
                                            <button title="Minus" type="button" class="quantity-btn rounded-tr-md rounded-br-md px-2 text-gray bg-light-brown w-6 flex items-center justify-center" data-id="${cartItem.id}" onclick="minusQuantity(${cartItem.id})"><span>-</span></button>
                                        </div>
                                    </div> 
                                    <div class="absolute bottom-2 right-2">
                                        <button title="Delete" type="button" class="delete-btn deleteCart rounded-md p-2 cursor-pointer" data-id="${cartItem.id}">
                                            <img class="w-6 h-6 rounded-md" src="../images/delete-svgrepo-com.svg">
                                        </button>
                                    </div>
                                </div>
                                `;
                                cartList.insertAdjacentHTML('beforeend', cartHTML);
                            });
                        } else {
                            cartList.innerHTML = '<p class="text-center text-gray-400">Your cart is empty.</p>';
                        }
                    } else {
                        console.error('Element with ID "list-cart" not found.');
                    }
                    const placeOrderButtonHTML = `
                    <div class="flex justify-between">
                        <p class="text-md text-gray-600 rosarivo font-normal my-auto">Total: <span id="totalPlaceOrder" class="rosarivo font-bold text-gray-900"></span></p>
                        <button title="Place Order" id="placeOrder" type="button" class="mt-0 px-8 py-2 rounded-3xl bg-light-brown focus:outline-none hover:bg-amber-400 transition duration-150 ease-in-out  salsa text-xl text-white" onclick="confirmModalHandler(true)">Place order</button>
                    </div>`;
                    cartList.insertAdjacentHTML('beforeend', placeOrderButtonHTML);
 
                    const totalPlaceOrder = document.getElementById('totalPlaceOrder');
                    if (totalPlaceOrder) {
                        totalPlaceOrder.textContent = '₱' + (parseFloat(data.totalPlaceOrder) || 0).toFixed(2);
                    }
                    console.log(cartList);

                    const cartListConfirmModal = document.getElementById('cartListConfirmModal');
                    cartListConfirmModal.innerHTML = '';
                    let total = 0;

                    data.cart.forEach(cartItem => {
                        total += cartItem.price * cartItem.quantity;
                        const confirmHTML = `
                        <div class="mb-4 ms-4">            
                            <div class="flex items-center">
                                <img class="w-14 h-14 rounded-md mr-5" src="../uploaded_img/${cartItem.image}" alt=""/>
                                <div class="flex-1" data-id="${cartItem.id}">
                                    <h3 class="flex items-start mb-1 text-lg font-medium text-gray-900">${cartItem.name} ${cartItem.variation ? '(' + cartItem.variation + ')' : ''}<p class="salsa bg-blue-100 text-black text-sm font-medium mr-2 px-2.5 py-0.5 rounded ms-3">x<span id="confirm-quantity">${cartItem.quantity}</span></p></h3>
                                    <p class="block mb-3 text-sm font-normal leading-none text-gray-500">₱<span id="confirm-price" class="salsa">${cartItem.price * cartItem.quantity}</span></p>
                                </div>               
                            </div>
                        </div>`;
                        cartListConfirmModal.insertAdjacentHTML('beforeend', confirmHTML);
                    });
                    console.log(cartListConfirmModal);

                    const totalConfirmModal = document.getElementById('totalConfirmModal');
                    totalConfirmModal.innerHTML = '';
                    const confirmTotalHTML = `
                        <div class="flex justify-end items-center">
                            <div class="pr-5">
                                <p class="text-gray-500 text-sm font-medium leading-tight tracking-normal salsa" for="total">Total</p>
                                <p id="total" class="salsa block mb-3 text-md font-normal leading-none text-gray-800 dark:text-gray-700">
                                    ₱<span id="confirm-total" class="text-gray-800 salsa mb-3 text-md font-normal leading-none">${total.toFixed(2)}</span>
                                </p>
                            </div>
                            <form id="add_order" action="" method="POST">
                                <input type="text" class="hidden" name="uid" id="uid" value="<?= $_SESSION['uid'] ?>" title="uid" placeholder="">
                                <button title="Confirm" type="submit" id="submitBtn" class="addToOrder bg-light-brown border border-light-brown px-5 py-2 text-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-amber-400" data-id="${data.cart[0].id}">Confirm</button>
                            </form>
                        </div>
                    `;
                    totalConfirmModal.insertAdjacentHTML('beforeend', confirmTotalHTML);
                    const formOrder = totalConfirmModal.querySelector('#add_order');
                    formOrder.addEventListener('submit', addOrder);

                    attachDeleteEventListeners();

                } else {
                    if (divMessage) {
                        divMessage.classList.remove('hidden');
                    }
                    messages.textContent = data.message;
                }
                setTimeout(function() {
                    if (divMessage) {
                        divMessage.classList.add('hidden');
                    }
                }, 2000);
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
            });
        });
    });
}

</script>
<script>
const confirmModal = document.getElementById("confirm-modal");
function showConfirmModal() {
    fadeIn(confirmModal);
}
function confirmModalHandler(val) {
    if (val) {
        fadeIn(confirmModal);
    } else {
        fadeOut(confirmModal);
    }
}
const variationModal = document.getElementById("variation-modal");
function showVariationModal(productId) {
    fadeIn(variationModal);
    console.log(productId);
    fetchProductVariation(productId);
}
function variationModalHandler(val) {
    if (val) {
        fadeIn(variationModal);
    } else {
        fadeOut(variationModal);
    }
}
function deleteModalHandler(val) {
    if (val) {
        fadeIn(deleteModal);
    } else {
        fadeOut(deleteModal);
    }
}
function fadeOut(el) {
    el.style.opacity = 1;
    (function fade() {
        if ((el.style.opacity -= 0.1) <= 0) {
            el.style.display = "none";
        } else {
            requestAnimationFrame(fade);
        }
    })();
}
function fadeIn(el, display) {
    el.style.opacity = 0;
    el.style.display = display || "flex";
    (function fade() {
        let val = parseFloat(el.style.opacity);
        if (!((val += 0.2) > 1)) {
            el.style.opacity = val;
            requestAnimationFrame(fade);
        }
    })();
}
function fetchProductVariation(productId) {
    if (productId) {
        fetch('get_product_variation.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${productId}`
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.error) {
                console.error(data.error);
                return;
            }
            
            const variationModalContent = document.getElementById('variation-modal-content');
            variationModalContent.innerHTML = '';
            
            if (data.variations && data.variations.length > 0) {
                variationModalContent.innerHTML = `
                    <form id="add_to_cart_variation">
                        <input type="hidden" name="pid" value="${productId}">
                        <input type="hidden" name="vid" id="selected_variation_id">
                        <input type="hidden" name="name" id="selected_variation_name" value="${data.variations[0].name}">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="image" id="selected_variation_image" value="${data.variations[0].image}">
                        <input type="hidden" name="price" id="selected_variation_price">
                        
                        <div id="variations-container">
                            ${data.variations.map(variation => `
                                <div class="flex items-center mb-4">
                                    <input type="radio" name="variation" 
                                        id="variation-${variation.id}" 
                                        value="${variation.id}"
                                        data-price="${variation.price}"
                                        data-image="${variation.image}"
                                        data-name="${variation.name}"
                                        onchange="handleVariationSelect(this)">
                                    <label for="variation-${variation.id}" class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-700">
                                        ${variation.size} - ₱${variation.price}
                                    </label>
                                </div>
                            `).join('')}
                        </div>
                    </form>
                `;
            }
        })
        .catch(error => {
            console.error('Error fetching product variation:', error);
        });
    }
}
function handleVariationSelect(radio) {
    document.getElementById('selected_variation_name').value = radio.dataset.name;
    document.getElementById('selected_variation_image').value = radio.dataset.image;
    document.getElementById('selected_variation_id').value = radio.value;
    document.getElementById('selected_variation_price').value = radio.dataset.price;

    const form = document.getElementById('add_to_cart_variation');
    addToCart(form);
}
function attachDeleteEventListeners() {
    const deleteButtons = document.querySelectorAll(".deleteCart");
    deleteButtons.forEach((button) => {
        button.addEventListener("click", function() {
            const cartId = this.getAttribute("data-id");
            console.log(cartId);    
            if (cartId) {
                fetch(`delete_cart.php?id=${cartId}`, {
                    method: "DELETE",
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(
                            `Failed to delete product from cart (Status ${response.status})`
                        );
                    }

                    // Remove item from cart display
                    const cartItem = this.closest('.cart');
                    if (cartItem) {
                        cartItem.remove();
                    }

                    // Remove item from confirm modal
                    const deletedConfirmItem = document
                        .querySelector(
                            `#cartListConfirmModal [data-id="${cartId}"]`
                        )
                        ?.closest(".mb-4");
                    if (deletedConfirmItem) {
                        deletedConfirmItem.remove();
                    }

                    // Fetch updated cart data
                    fetch('get_cart.php')
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        const ordersNoElement = document.querySelector('#ordersNo');
                        const listCart = document.querySelector('#list-cart');
                        const cartListConfirmModal = document.querySelector('#cartListConfirmModal');
                        const totalConfirmModal = document.querySelector('#totalConfirmModal');

                        // Update order count
                        if (ordersNoElement) {
                            ordersNoElement.textContent = data.ordersNo;
                        }
                        const totalPlaceOrder = document.getElementById('totalPlaceOrder');
                        if (totalPlaceOrder) {
                            totalPlaceOrder.textContent = '₱' + (parseFloat(data.total) || 0).toFixed(2);
                        }

                        // Check if cart is empty
                        const remainingCarts = listCart.querySelectorAll('.cart');
                        if (remainingCarts.length === 0) {
                            listCart.innerHTML = '<p class="text-black text-medium font-semibold p-3 py-4 text-center">Your cart is empty.</p>';
                            cartListConfirmModal.innerHTML = '';
                            totalConfirmModal.innerHTML = '';
                        } else {
                            // Update total in confirm modal
                            if (data.total !== undefined && totalConfirmModal) {
                                const totalHTML = `
                                    <div class="flex justify-end items-center">
                                        <div class="pr-5">
                                            <p class="text-gray-500 text-sm font-medium leading-tight tracking-normal salsa" for="total">Total</p>
                                            <p id="total" class="salsa block mb-3 text-md font-normal leading-none text-gray-800 dark:text-gray-700">
                                                ₱<span id="confirm-total" class="text-gray-800 salsa mb-3 text-md font-normal leading-none">${parseFloat(data.total).toFixed(2)}</span>
                                            </p>
                                        </div>
                                        <form id="add_order" action="" method="POST">
                                            <input type="text" class="hidden" name="uid" id="uid" value="${data.uid}" title="uid">
                                            <button title="Confirm" type="submit" id="submitBtn" class="addToOrder bg-light-brown border border-light-brown px-5 py-2 text-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-amber-400">Confirm</button>
                                        </form>
                                    </div>
                                `;
                                totalConfirmModal.innerHTML = totalHTML;
                                const formOrder = totalConfirmModal.querySelector('#add_order');
                                formOrder.addEventListener('submit', addOrder);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching updated cart information:', error);
                    });
                })
                .catch((error) => {
                    console.error("Error deleting product from cart:", error);
                });
            }
        });
    });
}
document.addEventListener('DOMContentLoaded', attachDeleteEventListeners);
function addQuantity(cartId) {
    updateQuantity(cartId, 'add');
}
function minusQuantity(cartId) {
    updateQuantity(cartId, 'minus');
}
function updateQuantity(cartId, action) {
    const formData = new FormData();
    formData.append('cartId', cartId);
    formData.append('action', action);

    fetch('update_quantity.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        const price = parseFloat(data.price) || 0;
        const quantity = parseInt(data.quantity) || 0;
        const total = parseFloat(data.total) || 0;
        
        const subtotal = (price * quantity);

        const quantityElement = document.querySelector(`[data-id="${cartId}"] .quantity`);
        if (quantityElement) {
            quantityElement.textContent = quantity;
        }

        const priceElement = document.querySelector(`[data-id="${cartId}"] .price`);
        if (priceElement) {
            priceElement.textContent = subtotal;
        }

        const confirmQuantity = document.querySelector(`[data-id="${cartId}"] #confirm-quantity`);
        if (confirmQuantity) {
            confirmQuantity.textContent = quantity;
        }

        const confirmPrice = document.querySelector(`[data-id="${cartId}"] #confirm-price`);
        if (confirmPrice) {
            confirmPrice.textContent = subtotal;
        }

        const confirmTotal = document.querySelector('#confirm-total');
        if (confirmTotal) {
            confirmTotal.textContent = total.toFixed(2);
        }
        const totalPlaceOrder = document.getElementById('totalPlaceOrder');
        if (totalPlaceOrder) {
            totalPlaceOrder.textContent = '₱' + total.toFixed(2);
        }
    })
    .catch(error => {
        console.error('Error updating quantity:', error);
        alert('Failed to update quantity. Please try again.');
    });
}
document.addEventListener('click', function(event) {
    const orderCart = document.getElementById('orderCart');
    const cartButton = document.getElementById('cartButton');
    
    const isClickOutside = !orderCart.contains(event.target) && !cartButton.contains(event.target);
    
    if (orderCart.classList.contains('visible') && isClickOutside) {
        orderCart.classList.remove('visible');
    }
});
document.getElementById('cartButton').addEventListener('click', function () {
    const orderCart = document.getElementById('orderCart');
    if (orderCart.classList.contains('visible')) {
        orderCart.classList.remove('visible');
    } else {
        orderCart.classList.add('visible');
    }
});
function hideCart() {
    const orderCart = document.getElementById('orderCart');
    orderCart.classList.remove('visible');
}
document.querySelectorAll('.products').forEach(product => {
    product.addEventListener('mouseover', function () {
        showButtons(this);
    });
    product.addEventListener('mouseout', function () {
        hideButtons(this);
    });
});

const totalConfirmModal = document.getElementById('totalConfirmModal');
const formOrder = totalConfirmModal.querySelector('#add_order'); 
formOrder.addEventListener('submit', addOrder);

function addOrder() {
    event.preventDefault();
    const formData = new FormData(formOrder); 

    fetch('add_order.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success === true){
            handleInventoryResponse(data);
            const ordersNo = document.querySelector('#ordersNo');
            const listCart = document.querySelector('#list-cart');
            const cartListConfirmModal = document.querySelector('#cartListConfirmModal');
            const totalConfirmModal = document.querySelector('#totalConfirmModal');

            ordersNo.textContent = 0;
            listCart.innerHTML = '<p class="text-black text-medium font-semibold p-3 py-4 text-center">Your cart is empty.</p>';
            cartListConfirmModal.innerHTML = '';
            totalConfirmModal.innerHTML = '';
        }
        if (data.message) {
            divMessage.classList.remove('hidden');
            messages.textContent = data.message;

            setTimeout(()=> {
                divMessage.classList.add('hidden');
            }, 1500);
        }
        fadeOut(confirmModal);

        
    })
    .catch(error => {
        console.error('Error adding order:', error);
        showNotification('Error checking inventory. Please try again later.');
    });
}

const forms = document.querySelectorAll('#add_to_cart');
forms.forEach((form) => {
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        addToCart(form);
    });
});

function addToCart(form) {
    const formData = new FormData(form); 

    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }
    fetch('add_to_cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Received data:', data);
        if(variationModalHandler){
            variationModalHandler(false);
        }
        if (data.success === true) {
            orderCart.classList.toggle('visible');
            if (divMessage) {
                divMessage.classList.remove('hidden');
            }
            messages.textContent = data.message;
            ordersNo.innerHTML = data.total;
            // Update cart UI
            const cartList = document.getElementById('list-cart');
            if (cartList) {
                cartList.innerHTML = '';

                if (data.cart.length > 0) {
                    data.cart.forEach(cartItem => {
                        const cartHTML = `
                        <div class="cart relative rounded-md bg-dark-brown flex flex-start items-center h-28" data-id="${cartItem.id}">
                            <div class="w-28 h-full">
                                <img class="rounded-tl-md rounded-bl-md w-full h-full object-cover" src="../uploaded_img/${cartItem.image}" />
                            </div>
                            <div class="flex-1 ml-2 p-2">
                                <h3 class="text-white font-normal text-sm capitalize rosarivo leading-3">${cartItem.name} ${cartItem.variation ? '(' + cartItem.variation + ')' : ''}</h3>
                                <p class="text-gray-400 rosarivo">₱<span class="price">${cartItem.price * cartItem.quantity}</span></p>

                                <div class="flex items-center gap-2 my-1">
                                    <div class="flex bg-light-brown rounded-md">
                                        <button 
                                            type="button" 
                                            class="temperature-btn px-2 py-1 text-sm rosarivo rounded-l-md ${cartItem.temperature === 'Hot' ? 'bg-amber-600 text-white' : 'text-white' }"
                                            onclick="updateTemperature(${cartItem.id}, 'Hot')"
                                        >
                                            Hot
                                        </button>
                                        <button 
                                            type="button" 
                                            class="temperature-btn px-2 py-1 text-sm rosarivo rounded-r-md ${cartItem.temperature === 'Ice' ? 'bg-amber-600 text-white' : 'text-white' }"
                                            onclick="updateTemperature(${cartItem.id}, 'Ice')"
                                        >
                                            Ice
                                        </button>
                                    </div>
                                </div>

                                <div class="flex items-center mt-1">
                                    <span class="text-white rosarivo mr-2">Quantity</span>
                                    <button title="Plus" type="button" class="quantity-btn rounded-tl-md rounded-bl-md px-2 text-gray bg-light-brown w-6 flex items-center justify-center" data-id="${cartItem.id}" onclick="addQuantity(${cartItem.id})"><span>+</span></button>
                                    <p class="text-white rosarivo mx-2"><span class="quantity">${cartItem.quantity}</span></p>
                                    <button title="Minus" type="button" class="quantity-btn rounded-tr-md rounded-br-md px-2 text-gray bg-light-brown w-6 flex items-center justify-center" data-id="${cartItem.id}" onclick="minusQuantity(${cartItem.id})"><span>-</span></button>
                                </div>
                            </div> 
                            <div class="absolute bottom-2 right-2">
                                <button title="Delete" type="button" class="delete-btn deleteCart rounded-md p-2 cursor-pointer" data-id="${cartItem.id}">
                                    <img class="w-6 h-6 rounded-md" src="../images/delete-svgrepo-com.svg">
                                </button>
                            </div>
                        </div>
                        `;
                        cartList.insertAdjacentHTML('beforeend', cartHTML);
                    });
                } else {
                    cartList.innerHTML = '<p class="text-center text-gray-400">Your cart is empty.</p>';
                }
            } else {
                console.error('Element with ID "list-cart" not found.');
            }
            const placeOrderButtonHTML = `
            <div class="flex justify-between">
                <p class="text-md text-gray-600 rosarivo font-normal my-auto">Total: <span id="totalPlaceOrder" class="rosarivo font-bold text-gray-900"></span></p>
                <button title="Place Order" id="placeOrder" type="button" class="mt-0 px-8 py-2 rounded-3xl bg-light-brown focus:outline-none hover:bg-amber-400 transition duration-150 ease-in-out  salsa text-xl text-white" onclick="confirmModalHandler(true)">Place order</button>
            </div>`;
            cartList.insertAdjacentHTML('beforeend', placeOrderButtonHTML);

            console.log(cartList);

            const cartListConfirmModal = document.getElementById('cartListConfirmModal');
            cartListConfirmModal.innerHTML = '';
            let total = 0;

            data.cart.forEach(cartItem => {
                total += cartItem.price * cartItem.quantity;
                const confirmHTML = `
                <div class="mb-4 ms-4">            
                    <div class="flex items-center">
                        <img class="w-14 h-14 rounded-md mr-5" src="../uploaded_img/${cartItem.image}" alt=""/>
                        <div class="flex-1" data-id="${cartItem.id}">
                            <h3 class="flex items-start mb-1 text-lg font-medium text-gray-900">${cartItem.name} ${cartItem.variation ? '(' + cartItem.variation + ')' : ''}
                            <p class="ml-1" id="confirm-temperature">
                                ${cartItem.temperature ? '(' + cartItem.temperature + ')' : ''}
                            </p>
                            <p class="salsa bg-blue-100 text-black text-sm font-medium mr-2 px-2.5 py-0.5 rounded ms-3">x<span id="confirm-quantity">${cartItem.quantity}</span></p></h3>
                            <p class="block mb-3 text-sm font-normal leading-none text-gray-500">₱<span id="confirm-price" class="salsa">${cartItem.price * cartItem.quantity}</span></p>
                        </div>               
                    </div>
                </div>`;
                cartListConfirmModal.insertAdjacentHTML('beforeend', confirmHTML);
            });
             
            const totalPlaceOrder = document.getElementById('totalPlaceOrder');
            if (totalPlaceOrder) {
                totalPlaceOrder.textContent = '₱' + (parseFloat(data.totalPlaceOrder) || 0).toFixed(2);
            }
            console.log(cartListConfirmModal);

            const totalConfirmModal = document.getElementById('totalConfirmModal');
            totalConfirmModal.innerHTML = '';
            const confirmTotalHTML = `
                <div class="flex justify-end items-center">
                    <div class="pr-5">
                        <p class="text-gray-500 text-sm font-medium leading-tight tracking-normal salsa" for="total">Total</p>
                        <p id="total" class="salsa block mb-3 text-md font-normal leading-none text-gray-800 dark:text-gray-700">
                            ₱<span id="confirm-total" class="text-gray-800 salsa mb-3 text-md font-normal leading-none">${total.toFixed(2)}</span>
                        </p>
                    </div>
                    <form id="add_order" action="" method="POST">
                        <input type="text" class="hidden" name="uid" id="uid" value="<?= $_SESSION['uid'] ?>" title="uid" placeholder="">
                        <button title="Confirm" type="submit" id="submitBtn" class="addToOrder bg-light-brown border border-light-brown px-5 py-2 text-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-amber-400" data-id="${data.cart[0].id}">Confirm</button>
                    </form>
                </div>
            `;
            totalConfirmModal.insertAdjacentHTML('beforeend', confirmTotalHTML);
            const formOrder = totalConfirmModal.querySelector('#add_order');
            formOrder.addEventListener('submit', addOrder);

            attachDeleteEventListeners();

        } else {
            if (divMessage) {
                divMessage.classList.remove('hidden');
            }
            messages.textContent = data.message;
        }
        setTimeout(function() {
            if (divMessage) {
                divMessage.classList.add('hidden');
            }
        }, 2000);
    })
    .catch(error => {
        console.error('Error submitting form:', error);
    });
}

const priceInput = document.getElementById('price');
const priceError = document.getElementById('priceError');
priceInput.addEventListener('input', function() {
    const priceValue = this.value.trim(); 
    const isValid = /^[0-9]+(\.[0-9]{1,2})?$/.test(priceValue); 

    if (!isValid) {
        priceError.textContent = 'Please enter a valid price';
        priceInput.classList.add('border-red-500');
    } else {
        priceError.textContent = '';
        priceInput.classList.remove('border-red-500');
    }
});

function showButtons(element) {
    element.querySelector('.cart-btn').classList.remove('hidden');
    element.querySelector('.blur-bg').classList.remove('hidden');
}

function hideButtons(element) {
    element.querySelector('.cart-btn').classList.add('hidden');
    element.querySelector('.blur-bg').classList.add('hidden');
}
</script>