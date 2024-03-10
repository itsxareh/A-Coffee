<div class="hide-message hidden">
    <div class="message rounded-lg p-4 flex items-start">
        <span id="message" class="text-sm text-white"></span>
        <button class="-m-1" onclick="this.parentElement.remove();"><img class="w-5 h-5" src="../images/close-svgrepo-com.svg"></button>
    </div>
</div>
<div class="upper flex justify-between mb-4">
    <span class="text-gray text-2xl salsa title">Products</span>
    <div class="button-input flex">
        <button title="Add product" class="focus:outline-none focus:ring-2 focus:ring-offset-2 hover:bg-amber-400 focus:ring-amber-400 mx-auto transition duration-150 ease-in-out bg-light-brown rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm salsa" onclick="modalHandler(true)" id="openModalBtn">Add product</button>
        <input placeholder="Search" title="Search" id="search" name="search" class="search ml-4 px-4 py-2 w-48 rounded-md salsa text-black" type="text">
    </div>
</div>
<div id="productsList" class="grid autofit-grid gap-6 justify-start items-start">
    <?php 
    $select_products = $conn->prepare("SELECT * FROM products");
    $select_products->execute();
    $products = $select_products->fetchAll(PDO::FETCH_ASSOC);
    if (count($products) > 0){
        foreach ($products as $product){ ?>
    <div class="products relative rounded-lg p-4 cursor-pointer shadow-lg bg-dark-brown h-96 max-w-lg" title="<?= ucwords($product['name']) ?>" data-id="<?= $product['id'] ?>" onmouseover="showButtons(this)" onmouseout="hideButtons(this)">
        <div class="relative flex w-full h-full flex-col items-center justify-center">
            <div class="blur-bg absolute w-full h-full hidden rounded-md" style="background-color: rgba(0,0,0,0.5);"></div>
            <div class="absolute flex flex-col items-center top-4 right-4 z-10">
                <button title="Edit" class="edit-btn rounded-md p-2 cursor-pointer hover:block hidden" onclick="showEditModal(<?= $product['id'] ?>)">
                    <img class="w-8 h-8 rounded-md" src="../images/edit-svgrepo-com.svg">
                </button>
                <button title="Delete" class="delete-btn rounded-md p-2 cursor-pointer hover:block hidden" onclick="showDeleteModal(<?= $product['id'] ?>)">
                    <img class="w-8 h-8 rounded-md" src="../images/delete-svgrepo-com.svg">
                </button>
            </div>
            <button type="button" id="view-btn" class="view-btn w-full h-full absolute cart-btn rounded-md cursor-pointer hidden" onclick="showViewModal(<?= $product['id'] ?>)">
                <center><img title="View" class="rounded-md w-12 h-12 text-center" src="../images/details-more-svgrepo-com.svg"></center>
            </button>
            <img class="productImg w-full h-full object-cover rounded-md" src="../uploaded_img/<?= $product['image'] ?>">
        </div>
    </div>
        <?php 
        }
    } else{
        echo '<p class="text-gray text-2xl">No Products Added Yet!</p>';
    }
    ?>
</div>
<div class="py-20 transition duration-150 ease-in-out z-10 fixed top-0 right-0 bottom-0 left-0 hidden h-full" id="add-modal">
   	<div class="absolute opacity-80 inset-0 z-0" style="background-color: rgba(0, 0, 0, 0.7);"></div>
    <div role="alert" class="container mx-auto w-11/12 md:w-2/3 max-w-3xl">
        <div class="relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400">
            <h1 class="text-gray-800 font-lg font-medium tracking-normal leading-tight mb-4">Enter Product Details</h1>
            <form id="add_product" action="add_product.php" method="POST" enctype="multipart/form-data">
                <input type="text" class="hidden" name="id" id="id">
                <div class="mt-10 grid cols-grid-1 cols-grid-2 gap-x-2">
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
                        <input title="Name" id="name" name="name" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" autocomplete="off" placeholder="Cappuccino" type="text" required>
                    </div>
                    <div class="col-span-1">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="price">Price</label>
                        <div class="relative mb-5 mt-2">
                            <div class="absolute text-gray-600 flex items-center px-2 border-r h-full">
                                <img width="16px"  src="../images/peso-svgrepo-com.svg" alt="">
                            </div>
                            <input title="Price" name="price" id="price" class="text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-12 text-sm border-gray-300 rounded border" placeholder="150" required/>
                        </div>
                        <div id="priceError" class="text-red-500 salsa"></div>
                    </div>

                    <div class="col-span-1">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="category">Category</label>
                        <input title="Category" id="category" name="category"class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-600 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" placeholder="Iced Coffee" type="text" required>
                    </div>
                    <div class="col-span-full">
                        <label title="Ingredients" class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="ingredients">Ingredients</label>
                        <textarea id="ingredients" name="ingredients" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-600 font-normal w-full flex items-center pl-3 py-2 text-sm border-gray-300 rounded border" rows="3"  placeholder="Milk, Brewed Coffee, Vanilla Syrup" required></textarea>
                    </div>
                    <div class="col-span-full">
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
    <div class="w-full  max-w-xl p-5 relative mx-auto my-auto rounded-xl shadow-lg  bg-white ">
        <div class="">
        <div class="flex flex-row items-center">
                <div class="w-2/5">
                    <img class="w-full h-auto object-cover rounded-lg" id="viewImage" src="">
                </div>
                <div class="w-3/5 p-5">
                    <div>
                        <h3 id="viewName" class="text-2xl font-semibold text-gray-800  capitalize rosarivo"></h3>
                        <p id="viewCategory" class="mb-2 text-gray-800 capitalize rosarivo"></p>
                        <p id="viewPrice" class="mb-2 rosarivo"></p>
                        <p id="viewIngredients" class="mb-2 text-sm text-gray-700 capitalize rosarivo"></p>
                        <p id="viewDescription" class="mb-2 text-sm text-gray-700 normal-case rosarivo"></p>
                    </div>
                </div>
            </div>
            <div class="p-3  mt-2 text-center space-x-4 md:block">
                    <button class="mb-2 md:mb-0 bg-light-brown px-5 py-2 text-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-amber-400" onclick="viewModalHandler()">Okay</button>
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
                <button title="Delete" class="deleteProduct mb-2 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600" data-id=<?= $product['id']; ?> >Delete</button>
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
                newProduct.setAttribute('class', 'products relative rounded-lg p-4 cursor-pointer shadow-lg bg-dark-brown h-96 max-w-lg');
                newProduct.setAttribute('data-id', data.id);
                newProduct.setAttribute('title', data.name);
                newProduct.setAttribute('onmouseover', 'showButtons(this)');
                newProduct.setAttribute('onmouseout', 'hideButtons(this)');
                newProduct.innerHTML = `
                    <div class="relative flex w-full h-full flex-col items-center justify-center">
                        <div class="blur-bg absolute w-full h-full hidden rounded-md" style="background-color: rgba(0,0,0,0.5);"></div>
                        <div class="absolute flex flex-col items-center top-4 right-4 z-10">
                            <button title="Edit" class="edit-btn rounded-md p-2 cursor-pointer hover:block hidden" onclick="showEditModal(${data.id})">
                                <img class="w-8 h-8 rounded-md" src="../images/edit-svgrepo-com.svg">
                            </button>
                            <button title="Delete" class="delete-btn rounded-md p-2 cursor-pointer hover:block hidden" onclick="showDeleteModal(${data.id})">
                                <img class="w-8 h-8 rounded-md" src="../images/delete-svgrepo-com.svg">
                            </button>
                        </div>
                        <button type="button" id="view-btn" class="view-btn w-full h-full absolute cart-btn rounded-md cursor-pointer hidden" onclick="showViewModal(${data.id})">
                            <center><img title="View" class="rounded-md w-12 h-12 text-center" src="../images/details-more-svgrepo-com.svg"></center>
                        </button>
                        <img class="productImg w-full h-full object-cover rounded-md" src="../uploaded_img/${data.image}">
                    </div>
                `;
                productsList.appendChild(newProduct);
                if (divMessage) {
                    divMessage.classList.remove('hidden');
                }
                messages.textContent = data.message;
            } else if (data.update === true) {
                const updatedRow = document.querySelector(`div[data-id="${data.id}"]`);
                updatedRow.querySelector('.productImg').src = '../uploaded_img/' + data.image;  
                updatedRow.querySelector('button.edit-btn').setAttribute('onclick', `showEditModal(${data.id})`);
                updatedRow.querySelector('button.delete-btn').setAttribute('onclick', `showDeleteModal(${data.id})`);
                updatedRow.querySelector('button.view-btn').setAttribute('onclick', `showViewModal(${data.id})`);
                if (divMessage) {
                    divMessage.classList.remove('hidden');
                }
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
    function showViewModal(id) {
        fetch('fetch_viewProduct.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('viewName').innerHTML = data.name;
                document.getElementById('viewPrice').innerHTML = '₱' + data.price;
                document.getElementById('viewCategory').innerHTML = data.category;
                document.getElementById('viewIngredients').innerHTML = data.ingredients;
                document.getElementById('viewDescription').innerHTML = data.description;
                document.getElementById('viewImage').src = '../uploaded_img/'+ data.image;
                fadeIn(viewModal);
            })
            .catch(error => console.error('Error fetching data:', error));
    }
    function showEditModal(id) {
        fetch('fetch_product.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('id').value = data.id;
                document.getElementById('name').value = data.name;
                document.getElementById('price').value =  data.price;
                document.getElementById('category').value = data.category;
                document.getElementById('ingredients').value = data.ingredients;
                document.getElementById('description').value = data.description;
                document.getElementById('old_image').value =  data.image;
                document.getElementById('previewImage').src = '../uploaded_img/'+ data.image;
                fadeIn(modal);
            })
            .catch(error => console.error('Error fetching data:', error));
    }
    function showDeleteModal(productId) {
        const deleteBtn = deleteModal.querySelector(".deleteProduct");
        deleteBtn.setAttribute("data-id", productId);
        fadeIn(deleteModal);
    }
    const confirmDeleteBtn = deleteModal.querySelector(".deleteProduct");
    confirmDeleteBtn.addEventListener("click", () => {
        const productId = confirmDeleteBtn.getAttribute("data-id");
    
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