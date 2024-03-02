
<div class="hide-message hidden">
    <div class="message rounded-lg p-4 flex items-start">
        <span id="message" class="text-sm text-white"></span>
        <button class="-m-1" onclick="this.parentElement.remove();"><img class="w-5 h-5" src="../images/close-svgrepo-com.svg"></button>
    </div>
</div>
<div class="grid autofit-grid1 gap-3">
<?php
    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE uid = ?");
    $check_cart->execute([$uid]);
    $carts = $check_cart->fetchAll(PDO::FETCH_ASSOC);

    if(count($carts) > 0){
        foreach($carts as $cart){ ?>
            <div class="relative rounded-md bg-dark-brown flex flex-start items-center h-28" data-id="<?= $cart['id'] ?>">
                <div class="w-28 h-28">
                    <img class="rounded-tl-md rounded-bl-md w-full h-full object-cover" src="../uploaded_img/<?=$cart['image']?>">
                </div>
                <div class="ml-2 p-2">
                    <h3 class="text-white text-xl font-medium  capitalize rosarivo leading-none"><?= $cart['name']?></h3>
                    <p class="text-white rosarivo">₱<span class="price"><?= $cart['price'] * $cart['quantity']?></span></p>
                    <p class="text-white rosarivo text-sm my-1">Quantity</p>
                    <div class="flex items-center">
                    <button type="button" class="quantity-btn rounded-tl-md rounded-bl-md px-2 text-gray bg-light-brown w-6 flex items-center justify-center" data-id="<?= $cart['id'] ?>" onclick="addQuantity(<?= $cart['id'] ?>)"><span>+</span></button>
                    <p class="text-white rosarivo mx-2"><span class="quantity"><?= $cart['quantity']?></span></p>
                    <button type="button" class="quantity-btn rounded-tr-md rounded-br-md px-2 text-gray bg-light-brown w-6 flex items-center justify-center" data-id="<?= $cart['id'] ?>" onclick="minusQuantity(<?= $cart['id'] ?>)"><span>-</span></button>
                    </div>
                </div>
                <div class="absolute bottom-2 right-2">
                    <button type="button" class="delete-btn rounded-md p-2 cursor-pointer" onclick="showDeleteModal(<?= $cart['id'] ?>)">
                        <img class="w-8 h-8 rounded-md" src="../images/delete-svgrepo-com.svg">
                    </button>
                </div>
            </div>
            <div class="fixed right-16 bottom-8">
                <button id="placeOrderBtn" type="button" class="px-8 py-2 rounded-3xl bg-light-brown focus:outline-none focus:ring-2 focus:ring-offset-2 hover:bg-amber-400 focus:ring-amber-400 transition duration-150 ease-in-out  salsa text-xl text-white" onclick="confirmModalHandler(true)">Place order</button>
            </div>
            <?php
        }
    } else {
        echo '<p class="text-gray text-medium font-semibold p-3 py-4 text-center">Your cart is empty.</p>';
    }
?>
</div>


    <div class="py-20 transition duration-150 ease-in-out z-10 absolute top-0 right-0 bottom-0 left-0 hidden h-full" id="confirm-modal">
        <div class="absolute opacity-80 inset-0 z-0" style="background-color: rgba(0, 0, 0, 0.7);"></div>
        <div class="w-full max-w-xl relative mx-auto my-auto rounded-xl shadow-lg  bg-white ">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white rosarivo">
                        Confirm Order
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="confirmModalHandler()">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div id="cartLists" class="p-4 md:p-5">
                    <ol class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5">                  
                    <?php
                    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE uid = ?");
                    $check_cart->execute([$uid]);
                    $carts = $check_cart->fetchAll(PDO::FETCH_ASSOC);
                    if(count($carts) > 0){
                        foreach($carts as $cart){ ?>
                        <li class="mb-8 ms-8">            
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                            <svg width="800px" height="800px" viewBox="-50 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#000000"
                                    d="M822.592 192h14.272a32 32 0 0 1 31.616 26.752l21.312 128A32 32 0 0 1 858.24 384h-49.344l-39.04 546.304A32 32 0 0 1 737.92 960H285.824a32 32 0 0 1-32-29.696L214.912 384H165.76a32 32 0 0 1-31.552-37.248l21.312-128A32 32 0 0 1 187.136 192h14.016l-6.72-93.696A32 32 0 0 1 226.368 64h571.008a32 32 0 0 1 31.936 34.304L822.592 192zm-64.128 0 4.544-64H260.736l4.544 64h493.184zm-548.16 128H820.48l-10.688-64H214.208l-10.688 64h6.784zm68.736 64 36.544 512H708.16l36.544-512H279.04z" />
                            </svg>
                            </span>
                            <div class="flex items-center">
                                <img class="w-14 h-14 rounded-md mr-5" src="../uploaded_img/<?= $cart['image']?>" alt="">
                                <div class="flex-1" data-id="<?= $cart['id'] ?>">
                                    <h3 class="flex items-start mb-1 text-lg font-semibold text-gray-900 dark:text-white"><?= ucwords($cart['name']) ?><p class="salsa bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">x<span  id="confirm-quantity" ><?= $cart['quantity'] ?></span></p></h3>
                                    <p class="block mb-3 text-sm font-normal leading-none text-gray-500 dark:text-gray-400">₱<span id="confirm-price" class="salsa"><?= $cart['price'] * $cart['quantity'] ?></span></p>
                                </div>               
                            </div>
                        </li>
                    <?php
                        }
                    }
                    ?>
                    </ol>
                    <?php
                    $check_cart = $conn->prepare("SELECT *, SUM(price * quantity) as total FROM cart WHERE uid = ?");
                    $check_cart->execute([$uid]);
                    $carts = $check_cart->fetchAll(PDO::FETCH_ASSOC);
                    if(count($carts) > 0){
                        foreach($carts as $cart){ ?>
                    <div class="flex justify-end items-center">
                        <div class="pr-5">
                            <p class="text-gray-500 text-sm font-medium leading-tight tracking-normal salsa" for="total">Total</p>
                            <p id="total"  class="salsa block mb-3 text-md font-normal leading-none text-gray-800 dark:text-gray-700">₱<span id="confirm-total"><?= $cart['total'] ?></span></p>
                        </div>
                        <form id="add_order" action="add_order.php" method="POST">
                            <input type="text" class="hidden" name="uid" id="uid" value="<?= $cart['uid'] ?>">
                            <button type="submit" id="submitBtn" class="addToOrder bg-light-brown border border-light-brown px-5 py-2 text-sm  font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-amber-400" data-id=<?= $cart['id']; ?> >Confirm</button>
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
    <div class="py-20 transition duration-150 ease-in-out z-10 fixed top-0 right-0 bottom-0 left-0 hidden h-full" id="delete-modal">
        <div class="absolute opacity-80 inset-0 z-0" style="background-color: rgba(0, 0, 0, 0.7);"></div>
        <div class="w-full max-w-xl p-5 relative mx-auto my-auto rounded-xl shadow-lg  bg-white ">
            <div class="">
                <div class="text-center p-5 flex-auto justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -m-1 flex items-center text-red-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 flex items-center text-red-500 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <h2 class="text-xl font-bold py-4 ">Are you sure?</h3>
                    <p class="text-sm text-gray-500 px-8">Do you really want to this delete this product from cart? This process cannot be undone</p>    
                </div>
                <div class="p-3  mt-2 text-center space-x-4 md:block">
                    <button type="button" class="deleteCart mb-2 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600" data-id=<?= $cart['id']; ?> >Delete</button>
                    <button type="button" class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100" onclick="deleteModalHandler()">Cancel</button>
                </div>
            </div>
        </div>
    </div>

<script>
    const placeOrderBtn = document.querySelector('#placeOrderBtn');
    placeOrderBtn.addEventListener('click', function() {
        confirmModalHandler(true);
    });
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
    .then(response => response.json())
    .then(data => {
        console.log(data);
        const quantityElement = document.querySelector(`[data-id="${cartId}"] .quantity`);
        if (quantityElement) {
            quantityElement.textContent = data.quantity;
        }
        const priceElement = document.querySelector(`[data-id="${cartId}"] .price`);
        if (priceElement) {
            priceElement.textContent = data.price.toFixed(2) * data.quantity;
        }
        const confirmQuantity = document.querySelector(`[data-id="${cartId}"] #confirm-quantity`);
        if (confirmQuantity) {
            confirmQuantity.textContent = data.quantity;
        }
        const confirmPrice = document.querySelector(`[data-id="${cartId}"] #confirm-price`);
        if (confirmPrice) {
            confirmPrice.textContent = data.price.toFixed(2) * data.quantity;
        }
        const confirmTotal = document.querySelector(`#confirm-total`);
        if (confirmTotal) {
            confirmTotal.textContent = parseFloat(data.total).toFixed(2);
        }
    })
    .catch(error => {
        console.error('Error updating quantity:', error);
    });
}
const messages = document.getElementById("message");
const divMessage = document.getElementsByClassName('hide-message')[0];
const submitBtn = document.getElementById('submitBtn');
const formOrder = document.getElementById('add_order'); 
submitBtn.addEventListener('click', addToCart);

function addToCart() {
    event.preventDefault();
    const formData = new FormData(formOrder); 

    fetch('add_order.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.success === true){
            setTimeout(function() {
            window.location.href = 'index.php?page=dashboard';
        }, 1000);
        }
        if (divMessage) {
            divMessage.classList.remove('hidden');
            messages.textContent = data.message;
        }
        setTimeout(function() {
        if (divMessage) {
            divMessage.classList.add('hidden');
        }
        }, 1000);
    })
    .catch(error => {
        console.error('Error adding order:', error);
    });
}
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

const deleteModal = document.getElementById("delete-modal");
function hidePlaceOrderBtn() {
    document.getElementById('placeOrderBtn').style.display = 'none';
}

function showPlaceOrderBtn() {
    document.getElementById('placeOrderBtn').style.display = 'block';
}

function showDeleteModal(cartId) {
    const deleteBtn = deleteModal.querySelector(".deleteCart");
    deleteBtn.setAttribute("data-id", cartId);
    fadeIn(deleteModal);
}

const confirmDeleteBtn = deleteModal.querySelector(".deleteCart");
confirmDeleteBtn.addEventListener("click", () => {
    const cartId = confirmDeleteBtn.getAttribute("data-id");

    fetch(`delete_cart.php?id=${cartId}`, {
        method: "DELETE",
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Failed to delete product from cart (Status ${response.status})`);
        }
        const deletedCartItem = document.querySelector(`[data-id="${cartId}"]`);
        if (deletedCartItem) {
            deletedCartItem.remove();
        }
        fadeOut(deleteModal);
        fetch('get_cart.php')
        .then(response => response.text())
        .then(html => {
            const confirmModalContent = document.querySelector('#confirm-modal #cartLists');
            if (confirmModalContent) {
                confirmModalContent.innerHTML = html;
            }
            console.log(html);
        })
        .catch(error => {
            console.error('Error fetching updated cart information:', error);
        });
    })
    .catch(error => {
        console.error('Error deleting product from cart:', error);
    });
});
</script>