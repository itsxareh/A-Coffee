<div class="hide-message hidden">
    <div class="message rounded-lg p-4 flex items-start">
        <span id="message" class="text-sm text-white"></span>
        <button class="-m-1" onclick="this.parentElement.remove();"><img class="w-5 h-5" src="../images/close-svgrepo-com.svg"></button>
    </div>
</div>
<div class="upper flex justify-between mb-4">
    <span class="text-gray text-2xl salsa title">Products</span>
    <div class="button-input flex">
        <button title="Add product" class="focus:outline-none focus:ring-2 focus:ring-offset-2 hover:bg-amber-400 focus:ring-amber-400 mx-auto transition duration-150 ease-in-out bg-light-brown rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm salsa" onclick="modalHandler(true)" id="openModalBtn">Add new</button>
        <input placeholder="Search" title="Search" id="search" name="search" class="search ml-4 px-4 py-2 w-48 rounded-md salsa text-black" type="text">
    </div>
</div>
<div id="productsList" class="grid autofit-grid gap-6 justify-start items-start">
    <?php 
    $select_products = $conn->prepare("SELECT * FROM products WHERE delete_flag = 0");
    $select_products->execute();
    $products = $select_products->fetchAll(PDO::FETCH_ASSOC);
    if (count($products) > 0){
        foreach ($products as $product){ ?>
        <div class="products relative rounded-lg p-4 cursor-pointer shadow-lg bg-dark-brown h-40 max-w-lg" title="<?= ucwords($product['name']) ?>" data-id="<?= $product['id'] ?>" onmouseover="showButtons(this)" onmouseout="hideButtons(this)">
            <div class="relative flex w-full h-full flex-col items-center justify-center">
                <div class="blur-bg absolute w-full h-full hidden rounded-md" style="background-color: rgba(0,0,0,0.5);"></div>
                <div class="absolute flex flex-col items-center top-0 right-0 z-10">
                    <button title="Edit" class="edit-btn rounded-md p-2 cursor-pointer hover:block hidden" onclick="showEditModal(<?= $product['id'] ?>)">
                        <img class="w-5 h-5 rounded-md" src="../images/edit-svgrepo-com.svg">
                    </button>
                    <button title="Delete" class="delete-btn rounded-md p-2 cursor-pointer hover:block hidden" onclick="showDeleteModal(<?= $product['id'] ?>)">
                        <img class="w-5 h-5 rounded-md" src="../images/delete-svgrepo-com.svg">
                    </button>
                </div>  
                <button type="button" id="view-btn" class="view-btn w-full h-full absolute cart-btn rounded-md cursor-pointer hidden" onclick="showViewModal(<?= $product['id'] ?>)">
                    <center><img title="View" class="rounded-md w-12 h-12 text-center" src="../images/details-more-svgrepo-com.svg"></center>
                </button>
                <img class="productImg w-full h-full object-cover rounded-md" src="../uploaded_img/<?= isset($product['image']) ? $product['image'] : 'IcedCappuccino.jpg' ?>">
            </div>
        </div>
        <?php 
        }
    } else{
        echo '<p class="text-gray text-2xl">No Products Added Yet!</p>';
    }
    ?>
</div>
<div class="py-20 transition duration-150 ease-in-out z-10 fixed top-0 right-0 bottom-0 left-0 hidden" id="add-modal">
   	<div class="absolute opacity-80 inset-0 z-0" style="background-color: rgba(0, 0, 0, 0.7);"></div>
    <div role="alert" class="container my-auto mx-auto w-11/12 md:w-2/3 max-w-3xl" style="max-height: 900px;">
        <div class="relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400">
            <h1 class="text-gray-800 font-lg font-medium tracking-normal leading-tight">Enter Product Details</h1>
            <form id="add_product" action="add_product.php" method="POST" enctype="multipart/form-data">
                <input type="text" class="hidden" name="id" id="id">
                <div class=" grid cols-grid-1 cols-grid-2 gap-x-2">
                    <div class="col-span-full flex justify-center">
                        <div class="text-center">
                            <img id="previewImage" class="w-48 h-48 rounded-full bg-center object-cover" src="../images/image-svgrepo-com.svg">
                            <label class="relative cursor-pointer rounded-lg float-end" for="image">
                                <img class="w-6 h-6" src="../images/upload-minimalistic-svgrepo-com.svg">
                                <input id="image" name="image" class="sr-only" type="file" accept="image/jpg, image/jpeg, image/png" onchange="previewFile()" >
                                <input type="hidden" name="old_image" id="old_image">
                            </label>
                        </div>
                    </div>
                    <div class="col-span-1">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="name">Name</label>
                        <input title="Name" id="name" name="name" class="mb-2 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" autocomplete="off" placeholder="Cappuccino" type="text" required>
                    </div>
                    <div class="col-span-1">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="category">Category</label>
                        <select title="Category" id="category" name="category"class="mb-2 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-600 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" required>
                            <?php 
                                $select_category = $conn->prepare("SELECT * FROM category WHERE delete_flag = 0");
                                $select_category->execute();
                                $categories = $select_category->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($categories as $category){?>
                                    <option value="<?php echo $category['id'];?>"><?php echo ucwords($category['category_name']);?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-span-full">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa">Product Variations</label>
                        <div id="variations-container">
                            <div class="variation-row mb-4">
                                <div class="grid cols-grid-2 gap-x-2">
                                    <div class="col-span-1">
                                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa">Size</label>
                                        <input type="text" name="variations[0][size]" 
                                            class="mt-1 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                    </div>
                                    <div class="col-span-1">
                                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa">Price</label>
                                        <div class="relative">
                                            <div class="absolute text-gray-600 flex items-center px-2 border-r h-10">
                                                <img width="12px" src="../images/peso-svgrepo-com.svg" alt="">
                                            </div>
                                            <input type="number" name="variations[0][price]"
                                                class="mt-1 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-12 text-sm border-gray-300 rounded border">
                                        </div>
                                    </div>
                                    <div class="col-span-full">
                                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa">Ingredients</label>
                                        <textarea name="variations[0][ingredients]" 
                                            class="mt-1 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full flex items-center pl-3 py-2 text-sm border-gray-300 rounded border" 
                                            rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="mt-2 flex justify-end">
                                    <button type="button" class="remove-variation text-gray-800">Remove Variation</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-variation" class="focus:outline-none hover:bg-amber-400  transition duration-150 ease-in-out bg-light-brown rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm salsa">Add Variation</button>
                    </div>
                    <div class="col-span-full mt-2">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa"class="text-gray-800 text-sm font-semibold leading-tight tracking-normal salsa" for="description">Description</label>
                        <textarea title="Description" id="description" name="description" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-600 font-normal w-full flex items-center pl-3 py-2 text-sm border-gray-300 rounded border" rows="3" required></textarea>
                    </div>
                </div>
                <div class="flex items-center justify-start w-full">
                    <button title="Submit" type="submit" name="submit" id="submitBtn" class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 transition duration-150 ease-in-out bg-light-brown rounded text-white px-8 py-2 text-sm">Submit</button>
                    <button title="Cancel" type="button" class="focus:outline-none focus:ring-2 focus:ring-offset-2  focus:ring-gray-400 ml-3 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm" onclick="modalHandler()">Cancel</button>
                </div>
                <button title="Close" type="button" class="cursor-pointer absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600" onclick="modalHandler()" aria-label="close modal" role="button">
                    <img class="w-5 h-5" src="../images/close-svgrepo-com.svg" alt="">
                </button>
            </form>
        </div>
    </div>
</div>
<div class="py-20 transition duration-150 ease-in-out z-10 fixed top-0 right-0 bottom-0 left-0 hidden h-full" id="view-modal">
    <div class="absolute opacity-80 inset-0 z-0" style="background-color: rgba(0, 0, 0, 0.7);"></div>
    <div class="w-full max-w-xl p-5 relative mx-auto my-auto rounded-xl shadow-lg bg-white">
        <div class="">
            <div class="flex flex-row items-center">
                <div class="w-2/5">
                    <img class="w-full h-auto object-cover rounded-lg" id="viewImage" src="">
                </div>
                <div class="w-3/5 p-5">
                    <div>
                        <h3 id="viewName" class="text-2xl font-semibold text-gray-800 capitalize rosarivo"></h3>
                        <p id="viewCategory" class="mb-2 text-gray-800 capitalize rosarivo"></p>
                        <p id="viewDescription" class="mb-4 text-sm text-gray-700 normal-case rosarivo"></p>
                        
                        <!-- Variations Slider Section -->
                        <div class="mb-4">
                            <h4 class="text-md font-medium text-gray-800 mb-2 rosarivo">Available Variations</h4>
                            <div class="relative">
                                <div class="overflow-hidden">
                                    <div id="variationsContainer" class="flex transition-transform duration-300 ease-in-out">
                                        <!-- Variations will be inserted here -->
                                    </div>
                                </div>
                                <button id="prevBtn" class="absolute -left-3 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-md z-10 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="#000" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button id="nextBtn" class="absolute -right-3 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-md z-10 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="#000" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                            <div id="dotsContainer" class="flex justify-center space-x-2 mt-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 mt-2 text-center space-x-4 md:block">
                <button class="mb-2 md:mb-0 bg-light-brown px-5 py-2 text-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-amber-400" onclick="viewModalHandler()">Close</button>
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
                <p class="text-sm text-gray-500 px-8">Do you really want to this delete this product? This process cannot be undone</p>    
            </div>
            <div class="p-3  mt-2 text-center space-x-4 md:block">
                <button title="Delete" id="deleteProduct" onclick="deleteProduct()" class="deleteProduct mb-2 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600">Delete</button>
                <button title="Cancel" class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100" onclick="deleteModalHandler()">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
const modal = document.getElementById("add-modal");
const viewModal = document.getElementById("view-modal");
const deleteModal = document.getElementById("delete-modal");
const openModalBtn = document.getElementById("openModalBtn");

openModalBtn.addEventListener("click", () => {
    formElement.reset();
    fadeIn(modal);
});

function modalHandler(val) {
    if (val) {
        fadeIn(modal);
    } else {
        fadeOut(modal);
    }
}
function viewModalHandler(val) {
    if (val) {
        fadeIn(viewModal);
    } else {
        fadeOut(viewModal);
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
            console.log(searchTerm);
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
const submitBtn = document.getElementById('submitBtn');
const formElement = document.getElementById('add_product'); 
submitBtn.addEventListener('click', submitForm);

function submitForm(event) {
    event.preventDefault();
    const formData = new FormData(formElement);
    const container = document.getElementById('variations-container');
    const variations = container.querySelectorAll('.variation-row');
    let isValid = true;
    
    variations.forEach((row, index) => {
        const size = row.querySelector(`input[name="variations[${index}][size]"]`).value;
        const price = row.querySelector(`input[name="variations[${index}][price]"]`).value;
        const ingredients = row.querySelector(`textarea[name="variations[${index}][ingredients]"]`).value;
        
        if (!size || !price || !ingredients) {
            isValid = false;
        }
    });
    if (variations.length > 0) {
        divMessage.classList.remove('hidden');
        messages.textContent = "Product variation is required."
    }
    if (!isValid) {
        alert('Please fill all variation fields');
        return;
    }
    fetch('add_product.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.insert === true) {
                const productsList = document.getElementById('productsList');
                const newProduct = document.createElement('div');
                newProduct.setAttribute('class', 'products relative rounded-lg p-4 cursor-pointer shadow-lg bg-dark-brown h-40 max-w-lg');
                newProduct.setAttribute('data-id', data.id);
                newProduct.setAttribute('title', data.name);
                newProduct.setAttribute('onmouseover', 'showButtons(this)');
                newProduct.setAttribute('onmouseout', 'hideButtons(this)');
                newProduct.innerHTML = `
                    <div class="relative flex w-full h-full flex-col items-center justify-center">
                        <div class="blur-bg absolute w-full h-full hidden rounded-md" style="background-color: rgba(0,0,0,0.5);"></div>
                        <div class="absolute flex flex-col items-center top-0 right-0 z-10">
                            <button title="Edit" class="edit-btn rounded-md p-2 cursor-pointer hover:block hidden" onclick="showEditModal(${data.id})">
                                <img class="w-5 h-5 rounded-md" src="../images/edit-svgrepo-com.svg">
                            </button>
                            <button title="Delete" class="delete-btn rounded-md p-2 cursor-pointer hover:block hidden" onclick="showDeleteModal(${data.id})">
                                <img class="w-5 h-5 rounded-md" src="../images/delete-svgrepo-com.svg">
                            </button>
                        </div>
                        <button type="button" id="view-btn" class="view-btn w-full h-full absolute cart-btn rounded-md cursor-pointer hidden" onclick="showViewModal(${data.id})">
                            <center><img title="View" class="rounded-md w-12 h-12 text-center" src="../images/details-more-svgrepo-com.svg"></center>
                        </button>
                        <img class="productImg w-full h-full object-cover rounded-md" src="../uploaded_img/${data.image ? data.image : 'IcedCappuccino.jpg'}">
                    </div>
                `;
                productsList.appendChild(newProduct);
                if (divMessage) {
                    divMessage.classList.remove('hidden');
                }
                messages.textContent = data.message;
            } else if (data.update === true) {
                const updatedRow = document.querySelector(`div[data-id="${data.id}"]`);
                updatedRow.querySelector('.productImg').src = '../uploaded_img/' + data.image !== null ? data.image : 'IcedCappuccino.jpg';  
                updatedRow.querySelector('button.edit-btn').setAttribute('onclick', `showEditModal(${data.id})`);
                updatedRow.querySelector('button.delete-btn').setAttribute('onclick', `showDeleteModal(${data.id})`);
                updatedRow.querySelector('button.view-btn').setAttribute('onclick', `showViewModal(${data.id})`);
                if (divMessage) {
                    divMessage.classList.remove('hidden');
                }
                messages.textContent = data.message;
            } else {
                messages.textContent = data.message;
            }
            setTimeout(function () {
                if (divMessage) {
                    divMessage.classList.add('hidden');
                }
            }, 1000);
            modalHandler(false);
        })
        .catch(error => {
            console.error('Error submitting form:', error);
        });
}

</script>
<script>
    function showEditModal(id) {
        fetch('fetch_product.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById('id').value = data.id;
                document.getElementById('name').value = data.name;
                const categorySelect = document.getElementById('category');
                if (categorySelect) {
                    categorySelect.innerHTML = '';
                    
                    fetch('fetch_categories.php')
                        .then(response => response.json())
                        .then(categories => {

                            categories.forEach(category => {
                                const option = document.createElement('option');
                                option.value = category.id;
                                option.textContent = category.category_name.charAt(0).toUpperCase() + category.category_name.slice(1);
                                categorySelect.appendChild(option);
                            });

                            categorySelect.value = data.category;
                        })
                        .catch(error => console.error('Error fetching categories:', error));
                }
                document.getElementById('description').value = data.description;
                const defaultImage = '../uploaded_img/IcedCappuccino.jpg';
                const imagePath = data.image ? '../uploaded_img/' + data.image : defaultImage;

                document.getElementById('old_image').value = data.image || 'IcedCappuccino.jpg'; // Store the default name if null
                document.getElementById('previewImage').src = imagePath;

                // Clear existing variations
                const variationsContainer = document.getElementById('variations-container');
                variationsContainer.innerHTML = '';

                // Add each variation from the fetched data
                data.variations.forEach((variation, index) => {
                    addVariation(index, variation);
                });

                fadeIn(modal);
            })
            .catch(error => console.error('Error fetching data:', error));
    }
    function addVariation(index, data = null) {

        const container = document.getElementById('variations-container');
        const newVariation = document.createElement('div');
        newVariation.className = 'variation-row mb-4';
        
        newVariation.innerHTML = `
            <div class="grid cols-grid-2 gap-x-2">
                <div class="col-span-1">
                    <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa">Size</label>
                    <input type="text" name="variations[${index}][size]" 
                        value="${data ? data.size : ''}"
                        class="mt-1 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                </div>
                <div class="col-span-1">
                    <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa">Price</label>
                    <div class="relative">
                        <div class="absolute text-gray-600 flex items-center px-2 border-r h-10">
                            <img width="12px" src="../images/peso-svgrepo-com.svg" alt="">
                        </div>
                        <input type="number" name="variations[${index}][price]"
                            value="${data ? data.price : ''}"
                            class="mt-1 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-12 text-sm border-gray-300 rounded border">
                    </div>
                </div>
                <div class="col-span-full">
                    <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa">Ingredients</label>
                    <textarea name="variations[${index}][ingredients]" 
                        class="mt-1 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full flex items-center pl-3 py-2 text-sm border-gray-300 rounded border" 
                        rows="2">${data ? data.ingredients : ''}</textarea>
                </div>
            </div>
            <div class="mt-2 flex justify-end">
                <button type="button" class="remove-variation text-gray-800">Remove Variation</button>
            </div>
        `;

        container.appendChild(newVariation);

        const removeButton = newVariation.querySelector('.remove-variation');
        removeButton.addEventListener('click', () => {
            newVariation.remove();
            updateVariationIndexes();
        });
    }

    // Function to update variation indexes after removal
    function updateVariationIndexes() {
        const container = document.getElementById('variations-container');
        const variations = container.getElementsByClassName('variation-row');
        
        Array.from(variations).forEach((variation, index) => {
            const inputs = variation.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                }
            });
        });
        
    }
    document.getElementById('add-variation').addEventListener('click', () => {
        const container = document.getElementById('variations-container');
        const currentCount = container.getElementsByClassName('variation-row').length;
        addVariation(currentCount);
    });

    function showDeleteModal(productId) {
        const deleteBtn = deleteModal.querySelector(".deleteProduct");
        deleteBtn.setAttribute("data-id", productId);

        deleteBtn.onclick = function () {
            deleteProduct(productId);
        };
        fadeIn(deleteModal);
    }
    function deleteProduct(productId) {
        console.log("Deleting product with ID:", productId);
        fetch(`delete_product.php?id=${productId}`, {
            method: "DELETE",
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Failed to delete product (Status ${response.status})`);
                }

                const divToDelete = document.querySelector(`div[data-id="${productId}"]`);
                if (divToDelete) {
                    divToDelete.remove();
                }

                fadeOut(deleteModal); 
            })
            .catch(error => {
                console.error("Error deleting product:", error);
            });
    }
    const sliderState = {
    currentSlide: 0,
    totalSlides: 0
};

// Initialize the slider controls
function initializeSliderControls() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    // Add event listeners for navigation buttons
    if (prevBtn && nextBtn) {
        prevBtn.onclick = () => previousSlide();
        nextBtn.onclick = () => nextSlide();
    }
}

function showViewModal(id) {
    // Reset slider state
    sliderState.currentSlide = 0;
    sliderState.totalSlides = 0;
    
    fetch('fetch_viewProduct.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            // Set basic product information
            document.getElementById('viewName').innerHTML = data.name;
            document.getElementById('viewCategory').innerHTML = data.category_name;
            document.getElementById('viewDescription').innerHTML = data.description;
            document.getElementById('viewImage').src = '../uploaded_img/' + data.image;

            // Handle variations
            const variationsContainer = document.getElementById('variationsContainer');
            const dotsContainer = document.getElementById('dotsContainer');
            variationsContainer.innerHTML = ''; // Clear existing variations
            dotsContainer.innerHTML = ''; // Clear existing dots
            
            if (data.variations && data.variations.length > 0) {
                sliderState.totalSlides = data.variations.length;
                
                // Add each variation
                data.variations.forEach((variation, index) => {
                    const variationElement = document.createElement('div');
                    variationElement.className = 'flex-none w-full px-2';
                    variationElement.innerHTML = `
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="font-medium text-gray-800 rosarivo">${variation.size}</span>
                                    <p class="text-sm text-gray-600 mt-1 rosarivo">₱${parseFloat(variation.price).toFixed(2)}</p>
                                </div>
                            </div>
                            ${variation.ingredients ? `
                                <div class="mt-2">
                                    <p class="text-sm text-gray-700 rosarivo">${variation.ingredients}</p>
                                </div>
                            ` : ''}
                        </div>
                    `;
                    variationsContainer.appendChild(variationElement);
                    
                    // Add dot indicator
                    const dot = document.createElement('button');
                    dot.className = `h-2 w-2 rounded-full ${index === 0 ? 'bg-gray-800' : 'bg-gray-300'}`;
                    dot.onclick = () => goToSlide(index);
                    dotsContainer.appendChild(dot);
                });
                
                // Initialize controls and update navigation state
                initializeSliderControls();
                updateNavigationState();
                
            } else {
                variationsContainer.innerHTML = '<div class="w-full text-center"><p class="text-gray-500 italic">No variations available</p></div>';
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');
                if (prevBtn) prevBtn.style.display = 'none';
                if (nextBtn) nextBtn.style.display = 'none';
            }

            fadeIn(viewModal);
        })
        .catch(error => console.error('Error fetching data:', error));
}

function updateNavigationState() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dots = document.getElementById('dotsContainer').children;
    
    // Update navigation buttons
    if (prevBtn) prevBtn.disabled = sliderState.currentSlide === 0;
    if (nextBtn) nextBtn.disabled = sliderState.currentSlide === sliderState.totalSlides - 1;
    
    // Update dots
    Array.from(dots).forEach((dot, index) => {
        dot.className = `h-2 w-2 rounded-full ${index === sliderState.currentSlide ? 'bg-gray-800' : 'bg-gray-300'}`;
    });
    
    // Update slides position
    const container = document.getElementById('variationsContainer');
    if (container) {
        container.style.transform = `translateX(-${sliderState.currentSlide * 100}%)`;
    }
}

function previousSlide() {
    if (sliderState.currentSlide > 0) {
        sliderState.currentSlide--;
        updateNavigationState();
    }
}

function nextSlide() {
    if (sliderState.currentSlide < sliderState.totalSlides - 1) {
        sliderState.currentSlide++;
        updateNavigationState();
    }
}

function goToSlide(index) {
    sliderState.currentSlide = index;
    updateNavigationState();
}

// Ensure DOM is fully loaded before initializing
document.addEventListener('DOMContentLoaded', function() {
    initializeSliderControls();
});
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
        element.querySelector('.delete-btn').classList.remove('hidden');
        element.querySelector('.edit-btn').classList.remove('hidden');
        element.querySelector('.view-btn').classList.remove('hidden');
        element.querySelector('.blur-bg').classList.remove('hidden');
    }

    function hideButtons(element) {
        element.querySelector('.delete-btn').classList.add('hidden');
        element.querySelector('.edit-btn').classList.add('hidden');
        element.querySelector('.view-btn').classList.add('hidden');
        element.querySelector('.blur-bg').classList.add('hidden');
    }
</script>