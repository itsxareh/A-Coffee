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
                        $select_products = $conn->prepare("SELECT * FROM products WHERE category = ?");
                        $select_products->execute([$category['category_id']]);
                        $products = $select_products->fetchAll(PDO::FETCH_ASSOC);
                        if (count($products) > 0){ 
                            foreach($products as $product){ ?>
                                <div class="products relative rounded-lg p-4 cursor-pointer shadow-lg bg-dark-brown h-56 " data-id="<?= $product['id'] ?>">
                                    <div class="flex flex-col justify-center">
                                        <div class="rounded-md relative w-full h-40 flex flex-col items-center justify-center">
                                            <div class="blur-bg absolute w-full h-full hidden rounded-md" style="background-color: rgba(0,0,0,0.5);"></div>
                                            <div class="absolute w-1/2">
                                                <form id="add_to_cart" action="add_to_cart.php" method="POST" enctype="multipart/form-data">
                                                    <input type="text" class="hidden" id="uid" name="uid" value="<?= $uid ?>">
                                                    <input type="text" class="hidden" id="pid" name="pid" value="<?= $product['id']?>">
                                                    <input type="text" class="hidden" id="name" name="name" value="<?= $product['name']?>" autocomplete="off">
                                                    <input type="text" class="hidden" id="price" name="price" value="<?= $product['price']?>">
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
                                $check_cart = $conn->prepare("SELECT * FROM cart WHERE uid = ?");
                                $check_cart->bindParam(1, $uid);
                                $check_cart->execute();
                                $carts = $check_cart->fetchAll(PDO::FETCH_ASSOC);

                                if(count($carts) > 0){
                                    foreach($carts as $cart){ ?>
                                        <div class="cart relative rounded-md bg-dark-brown flex flex-start items-center h-28" data-id="<?= $cart['id'] ?>">
                                            <div class="w-28 h-full">
                                                <img class="rounded-tl-md rounded-bl-md w-full h-full object-cover" src="../uploaded_img/<?=$cart['image']?>">
                                            </div>
                                            <div class="flex-1 ml-2 p-2">
                                                <h3 class="text-white font-normal text-sm capitalize rosarivo leading-3"><?= $cart['name']?></h3>
                                                <p class="text-gray-400 rosarivo">₱<span class="price"><?= $cart['price'] * $cart['quantity']?></span></p>
                                                <p class="text-white rosarivo my-1">Quantity</p>
                                                <div class="flex items-center">
                                                <button title="Plus" type="button" class="quantity-btn rounded-tl-md rounded-bl-md px-2 text-gray bg-light-brown w-6 flex items-center justify-center" data-id="<?= $cart['id'] ?>" onclick="addQuantity(<?= $cart['id'] ?>)"><span>+</span></button>
                                                <p class="text-white rosarivo mx-2"><span class="quantity"><?= $cart['quantity']?></span></p>
                                                <button title="Minus" type="button" class="quantity-btn rounded-tr-md rounded-br-md px-2 text-gray bg-light-brown w-6 flex items-center justify-center" data-id="<?= $cart['id'] ?>" onclick="minusQuantity(<?= $cart['id'] ?>)"><span>-</span></button>
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
                                    <div class="text-end">
                                        <button title="Place Order" id="placeOrder" type="button" class="px-8 py-2 rounded-3xl bg-light-brown focus:outline-none focus:ring-2 focus:ring-offset-2 hover:bg-amber-400 focus:ring-amber-400 transition duration-150 ease-in-out  salsa text-xl text-white" onclick="confirmModalHandler(true)">Place order</button>
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
<div class="py-20 transition duration-150 ease-in-out z-10 fixed top-0 right-0 bottom-0 left-0 hidden h-full" id="confirm-modal"> 
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
                $check_cart = $conn->prepare("SELECT * FROM cart WHERE uid = ?");
                $check_cart->bindParam(1, $uid);
                $check_cart->execute();
                $carts = $check_cart->fetchAll(PDO::FETCH_ASSOC);
                if(count($carts) > 0){
                    foreach($carts as $cart){ ?>
                    <div class="mb-4 ms-4">            
                        <div class="flex items-center">
                            <img class="w-14 h-14 rounded-md mr-5" src="../uploaded_img/<?= $cart['image']?>" alt="">
                            <div class="flex-1" data-id="<?= $cart['id'] ?>">
                                <h3 class="flex items-start mb-1 text-lg font-medium text-gray-900"><?= ucwords($cart['name']) ?><p class="salsa bg-blue-100 text-black text-sm font-medium mr-2 px-2.5 py-0.5 rounded ms-3">x<span  id="confirm-quantity" ><?= $cart['quantity'] ?></span></p></h3>
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

</script>
<script>
    const searchInput = document.getElementById('search');
    const productsList = document.getElementById('productsList');

    searchInput.addEventListener('input', function(){
        const searchTerm = this.value.trim();

        fetch(`search_order.php?search=${searchTerm}`)
        .then(response => response.text())
        .then(data => {
            productsList.innerHTML = data;
        })
        .catch(error => {
            console.error('Error fetching products:', error);
        });
    });
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

    function attachDeleteEventListeners() {
    const deleteButtons = document.querySelectorAll(".deleteCart");
    deleteButtons.forEach((button) => {
        button.addEventListener("click", function() {
            const cartId = this.getAttribute("data-id");
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

// Call the function when the page loads
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
        console.log('Received data:', data);
        
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
    const messages = document.getElementById("message");
    const divMessage = document.getElementsByClassName('hide-message')[0];
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
            console.log('Received data:', data);
            if (data.success === true){
                setTimeout(function () {
                    window.location.href = 'index.php?page=dashboard';
                }, 1500);
            }
            if (data.message) {
                divMessage.classList.remove('hidden');
                messages.textContent = data.message;

                setTimeout(()=> {
                    divMessage.classList.add('hidden');
                }, 1500);
            }
            
        })
        .catch(error => {
            console.error('Error adding order:', error);
        });
    }
    const forms = document.querySelectorAll('#add_to_cart');

    // Add event listeners to each form
    forms.forEach((form) => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            addToCart(form);
        });
    });

    function addToCart(form) {
        const formData = new FormData(form); 
        fetch('add_to_cart.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {

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
                cartList.innerHTML = ''; // Clear the cart content

                if (data.cart.length > 0) {
                    data.cart.forEach(cartItem => {
                        const cartHTML = `
                        <div class="cart relative rounded-md bg-dark-brown flex flex-start items-center h-28" data-id="${cartItem.id}">
                            <div class="w-28 h-full">
                                <img class="rounded-tl-md rounded-bl-md w-full h-full object-cover" src="../uploaded_img/${cartItem.image}" />
                            </div>
                            <div class="flex-1 ml-2 p-2">
                                <h3 class="text-white font-normal text-sm capitalize rosarivo leading-3">${cartItem.name}</h3>
                                <p class="text-gray-400 rosarivo">₱<span class="price">${cartItem.price * cartItem.quantity}</span></p>
                                <p class="text-white rosarivo my-1">Quantity</p>
                                <div class="flex items-center">
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
            <div class="text-end mt-4">
                <button title="Place Order" id="placeOrder" type="button" class="px-8 py-2 rounded-3xl bg-light-brown focus:outline-none focus:ring-2 focus:ring-offset-2 hover:bg-amber-400 focus:ring-amber-400 transition duration-150 ease-in-out salsa text-xl text-white" onclick="confirmModalHandler(true)">Place order</button>
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
                            <h3 class="flex items-start mb-1 text-lg font-medium text-gray-900">${cartItem.name}<p class="salsa bg-blue-100 text-black text-sm font-medium mr-2 px-2.5 py-0.5 rounded ms-3">x<span id="confirm-quantity">${cartItem.quantity}</span></p></h3>
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