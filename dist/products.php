<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);
?>
<div class="upper flex justify-between mb-4">
    <span class="text-gray text-4xl salsa title">Products</span>
    <div class="button-input flex">
        <button class="focus:outline-none focus:ring-2 focus:ring-offset-2 hover:bg-amber-400 focus:ring-amber-400 mx-auto transition duration-150 ease-in-out bg-light-brown rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm salsa" id="openModalBtn">Add product</button>
        <input id="search" name="search" class="search ml-4 px-4 py-2 w-48 rounded-md salsa text-black" type="text">
    </div>
</div>
<div id="productsList" class="grid autofit-grid gap-6 justify-start items-start">
    <?php 
    $select_products = $conn->prepare("SELECT * FROM products ");
    $select_products->execute();

    if($select_products->rowCount() > 0){
        while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
    ?>
        <a href="index.php?page=view_product&id=<?= $fetch_products['id'] ?>" class="rounded-lg p-4 cursor-pointer shadow-lg bg-dark-brown" style="min-width: 175px; max-width: 300px; height: 264px;">
            <img class="w-full h-full object-cover" src="../uploaded_img/<?= $fetch_products['image'] ?>">
        </a>
    <?php 
        }
    } else{
        echo '<p class="text-gray text-2xl">No Products Added Yet!</p>';
    }
    ?>
</div>
<div class="py-12 transition duration-150 ease-in-out z-10 absolute top-0 right-0 bottom-0 left-0 hidden h-full" style="background-color: rgba(0, 0, 0, 0.7);" id="modal">
    <div role="alert" class="container mx-auto w-11/12 md:w-2/3 max-w-lg">
        <div class="relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400">
            <h1 class="text-gray-800 font-lg font-medium tracking-normal leading-tight mb-4">Enter Product Details</h1>
            <form action="add_product.php" method="POST" enctype="multipart/form-data">
                <div class="mt-10 grid cols-grid-1 cols-grid-2 gap-x-2">
                    <div class="col-span-full flex justify-center">
                        <div class="text-center">
                            <img id="previewImage" class="w-48 h-48 rounded-full bg-center object-cover" src="../images/default-coffee.svg">
                            <label class="relative cursor-pointer rounded-lg float-end" for="image">
                                <img class="w-6 h-6" src="../images/upload-minimalistic-svgrepo-com.svg">
                                <input id="image" name="image" class="sr-only" type="file" accept="image/jpg, image/jpeg, image/png" onchange="previewFile()" required>
                            </label>
                        </div>
                    </div>
                    <div class="col-span-1">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="name">Name</label>
                        <input id="name" name="name" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" autocomplete="off" placeholder="Cappuccino" type="text" required>
                    </div>
                    <div class="col-span-1">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="price">Price</label>
                        <div class="relative mb-5 mt-2">
                            <div class="absolute text-gray-600 flex items-center px-2 border-r h-full">
                                <img width="16px"  src="../images/peso-svgrepo-com.svg" alt="">
                            </div>
                            <input name="price" id="price" class="text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-12 text-sm border-gray-300 rounded border" placeholder="150" />
                        </div>
                        <div id="priceError" class="text-red-500 salsa"></div>
                    </div>

                    <div class="col-span-1">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="category">Category</label>
                        <input id="category" name="category"class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-600 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" placeholder="Iced Coffee" type="text" required>
                    </div>
                    <div class="col-span-full">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="ingredients">Ingredients</label>
                        <textarea id="ingredients" name="ingredients" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-600 font-normal w-full flex items-center pl-3 py-2 text-sm border-gray-300 rounded border" rows="3"  placeholder="Milk, Brewed Coffee, Vanilla Syrup" required></textarea>
                    </div>
                    <div class="col-span-full">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa"class="text-gray-800 text-sm font-semibold leading-tight tracking-normal salsa" for="description">Description</label>
                        <textarea id="description" name="description" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-600 font-normal w-full flex items-center pl-3 py-2 text-sm border-gray-300 rounded border" rows="3" required></textarea>
                    </div>
                </div>
                <div class="flex items-center justify-start w-full">
                    <button type="submit" name="submit" class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 transition duration-150 ease-in-out bg-light-brown rounded text-white px-8 py-2 text-sm">Submit</button>
                    <button class="focus:outline-none focus:ring-2 focus:ring-offset-2  focus:ring-gray-400 ml-3 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm" onclick="modalHandler()">Cancel</button>
                </div>
                <button class="cursor-pointer absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600" onclick="modalHandler()" aria-label="close modal" role="button">
                    <img class="w-5 h-5" src="../images/close-svgrepo-com.svg" alt="">
                </button>
            </form>
        </div>
    </div>
</div>
<script>
const modal = document.getElementById("modal");
const openModalBtn = document.getElementById("openModalBtn");

openModalBtn.addEventListener("click", () => {
    fadeIn(modal);
});

function modalHandler(val) {
    if (val) {
        fadeIn(modal);
    } else {
        fadeOut(modal);
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
</script>
<script>
    const searchInput = document.getElementById('search');
    const productsList = document.getElementById('productsList');

    searchInput.addEventListener('input', function(){
        const searchTerm = this.value.trim();

        fetch(`search_product.php?search=${searchTerm}`)
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
    function submitForm(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form); 

        fetch('add_product.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log('Response data:', data);
            productsList.innerHTML += data;
            form.reset();
            modalHandler(false);
        })
        .catch(error => {
            console.error('Error submitting form:', error);
        });
    }

    const form = document.querySelector('form');
    form.addEventListener('submit', submitForm);
</script>
<script>
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
</script>