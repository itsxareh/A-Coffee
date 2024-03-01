
    <div class="grid autofit-grid1 gap-3">
    <?php
        $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE uid = ?");
        $check_cart->execute([$uid]);
        $carts = $check_cart->fetchAll(PDO::FETCH_ASSOC);

        if(count($carts) > 0){
            foreach($carts as $cart){ ?>
                <div class="relative rounded-md bg-dark-brown flex flex-start items-center h-28" data-id="<?= $cart['id'] ?>">
                    <div class="w-28 h-28">
                        <img class="rounded-tl-md w-full h-full object-cover" src="../uploaded_img/c.jpg">
                    </div>
                    <div class="ml-2 p-2">

                        <input type="text" class="hidden" name="pid" id="pid" value="<?= $cart['id'] ?>">
                        <input type="text" class="hidden" name="price" id="price" value="<?= $cart['price'] * $cart['quantity']?>">
                        <input type="text" class="hidden" name="quantity" id="quantity" value="<?= $cart['quantity']?>">
                        <h3 class="text-white text-xl font-medium  capitalize rosarivo leading-none"><?= $cart['name']?></h3>
                        <p class="text-white rosarivo">₱<span class="price"><?= $cart['price'] * $cart['quantity']?></span></p>
                        <p class="text-white rosarivo text-sm my-1">Quantity</p>
                        <div class="flex items-center">
                        <button type="button" class="quantity-btn rounded-tl-md rounded-bl-md px-2 text-gray bg-light-brown w-6 flex items-center justify-center" data-id="<?= $cart['id'] ?>" onclick="addQuantity(<?= $cart['id'] ?>)"><span>+</span></button>
                        <p class="text-white rosarivo mx-1"><span class="quantity"><?= $cart['quantity']?></span></p>
                        <button type="button" class="quantity-btn rounded-tr-md rounded-br-md px-2 text-gray bg-light-brown w-6 flex items-center justify-center" data-id="<?= $cart['id'] ?>" onclick="minusQuantity(<?= $cart['id'] ?>)"><span>-</span></button>
                        </div>
                    </div>
                    <div class="absolute bottom-2 right-2">
                        <button type="button" class="delete-btn rounded-md p-2 cursor-pointer" onclick="showDeleteModal(<?= $cart['id'] ?>)">
                            <img class="w-8 h-8 rounded-md" src="../images/delete-svgrepo-com.svg">
                        </button>
                    </div>
                </div>
            <?php
            }
        }
    ?>
    </div>
    <form id="add_order" action="add_order.php" method="POST">
        <input type="text" class="hidden" name="uid" id="uid" value="<?= $cart['uid'] ?>">
        <div class="fixed right-16 bottom-8">
            <button type="submit" id="submitBtn" class="px-8 py-2 rounded-3xl bg-light-brown focus:outline-none focus:ring-2 focus:ring-offset-2 hover:bg-amber-400 focus:ring-amber-400 transition duration-150 ease-in-out  salsa text-xl text-white">Place order</button>
        </div>
    </form>
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
    })
    .catch(error => {
        console.error('Error updating quantity:', error);
    });
}
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
    .then(response => response.text())
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('Error adding order:', error);
    });
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
        if ((el.style.opacity -= 0.1) < 0) {
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
            const divToDelete = document.querySelector(`div[data-id="${cartId}"]`);
            if (divToDelete) {
                divToDelete.remove();
            }
            fadeOut(deleteModal);
        })
        .catch(error => {
            console.error("Error deleting product from cart:", error);
        });
    });
</script>