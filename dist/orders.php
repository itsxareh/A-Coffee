<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);
?>
<div class="hide-message hidden">
    <div class="message rounded-lg p-4 flex items-start">
        <span id="message" class="text-sm text-white"></span>
        <button class="-m-1" onclick="this.parentElement.remove();"><img class="w-5 h-5" src="../images/close-svgrepo-com.svg"></button>
    </div>
</div>
<div class="upper flex justify-between mb-4 h-10">
    <span class="text-gray text-4xl salsa title">Order</span>
    <div class="button-input flex">
        <?php 
        $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE uid = ?");
        $check_cart_numbers->execute([$uid]);
    
        $total = $check_cart_numbers->rowCount();
        ?>
        <a href="index.php?page=cart" class="w-10 h-10  mx-auto transition duration-150 ease-in-out rounded-md relative"><span id="ordersNo" class="absolute text-white bg-red-600 rounded-full px-2 -top-2 -right-2"><?= $total ?></span><img class="w-full h-full" src="../images/cart-shopping-svgrepo-com.svg"></a>
        <input id="search" name="search" class="search ml-4 px-4 py-2 w-48 rounded-md salsa text-black" type="text">
    </div>
</div>
<div id="productsList" class="grid autofit-grid gap-6 justify-start items-start">
    <?php 
    $select_products = $conn->prepare("SELECT * FROM products");
    $select_products->execute();
    $products = $select_products->fetchAll(PDO::FETCH_ASSOC);
    if (count($products) > 0){
        foreach ($products as $product){ ?>
    <div class="products relative rounded-lg p-4 cursor-pointer shadow-lg bg-dark-brown h-96" data-id="<?= $product['id'] ?>" onmouseover="showButtons(this)" onmouseout="hideButtons(this)">
        <div class="flex flex-col justify-center">
            <div class="rounded-md relative w-full h-80 flex flex-col items-center justify-center">
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
            <div class="flex justify-center items-center">
                <p style="padding: 0.25rem;" class="text-white salsa text-md p-1"><?= ucwords($product['name']) ?></p>
            </div>
        </div>
    </div>
        <?php 
        }
    } else{
        echo '<p class="text-gray text-medium font-semibold p-3 py-4 text-center">No products found.</p>';
    }
    ?>
</div>

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
    const messages = document.getElementById("message");
    const divMessage = document.getElementsByClassName('hide-message')[0];
    const forms = document.querySelectorAll('#add_to_cart');
    forms.forEach(form => {
        form.addEventListener('submit', addToCart);
    });

    function addToCart(event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch('add_to_cart.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response data:', data);
            if (data.success === true) {
                if (divMessage) {
                divMessage.classList.remove('hidden');
                }
                messages.textContent = data.message;
                ordersNo.innerHTML = data.total;
                
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
            }, 1000);
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