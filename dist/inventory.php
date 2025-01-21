<div class="hide-message hidden">
    <div class="message rounded-lg p-4 flex items-start">
        <span id="message" class="text-sm text-white"></span>
        <button class="-m-1" onclick="this.parentElement.remove();"><img class="w-5 h-5" src="../images/close-svgrepo-com.svg"></button>
    </div>
</div>
<div class="upper flex justify-between mb-4">
    <span class="text-gray text-2xl salsa ">Inventory</span>
    <div class="button-input flex">
        <button class="focus:outline-none focus:ring-2 focus:ring-offset-2 hover:bg-amber-400 focus:ring-amber-400 mx-auto transition duration-150 ease-in-out bg-light-brown rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm salsa" onclick="modalHandler(true)" id="addModalBtn">Add new</button>
        <input id="search" name="search" class="search ml-4 px-4 py-2 w-48 rounded-md salsa text-black" type="text">
    </div>
</div>
<div class="overflow-x-auto">
    <table class="indent-0 border-collapse py-6 px-2  w-full" id="itemsTable">
        <thead>
            <tr>
                <!-- <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Item</th> -->
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Name</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Quantity</th>
                <!-- <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Before Quantity</th> -->
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Description</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Last Update</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Action</th>
            </tr>
        </thead>
        <tbody id="itemsList">
            <?php 
                $select_items = $conn->prepare("SELECT * FROM inventory WHERE delete_flag = 0 ORDER BY id DESC");
                $select_items->execute();
                $items = $select_items->fetchAll(PDO::FETCH_ASSOC);
                if (count($items) > 0){
                    foreach ($items as $item){                
                        $quantity = $item['quantity'];
                        $matches = [];
                        if (preg_match('/(\d*\.?\d+)\s*([a-zA-Z]+)/', $quantity, $matches)) {
                            $db_value = number_format((float)$matches[1], 3, '.');
                            $db_unit = strtoupper($matches[2]);
                        } else {
                            $db_value = (float)$quantity;
                            $db_unit = 'piece/s';
                        }?>
                    <tr class="border-color" data-id="<?= $item['id']; ?>">
                        <!-- <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                                <img class="w-16 h-16 object-cover" src="../uploaded_img/<?= $item['image']; ?>">
                        </td> -->
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= ucwords($item['name']); ?></td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $db_value.''.$db_unit ?></td>
                        <!-- <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $item['quantity_before'] ? $item['quantity_before'] :  $db_value.''.$db_unit ?></td> -->
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $item['description'] === '' ? 'N/A' : $item['description']; ?></td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $item['updated_at'] === '' ? 'N/A' :  DateTime::createFromFormat("m-d-Y H:i:s", $item['updated_at'])->format("F d Y h:i A"); ?></td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <button id="undoModalBtn" class="w-6 h-6" onclick="showUndoModal(<?= $item['id'] ?>)"><img src="../images/undo-svgrepo-com.svg" alt=""></button>
                                <button id="editModalBtn" class="w-6 h-6" onclick="showEditModal(<?= $item['id'] ?>)"><img src="../images/edit-svgrepo-com.svg" alt=""></button>
                                <button id="deleteModalBtn" class="w-6 h-6" onclick="showDeleteModal(<?= $item['id'] ?>)"><img src="../images/delete-svgrepo-com.svg" alt=""></button>
                            </div>
                        </td>
                    </tr>   
                <?php
                    }
                } else {
                    echo '<tr><td colspan="6" class="text-gray text-medium font-semibold p-3 py-4 text-center">No items found.</td></tr>';
                }
            ?>
        </tbody>
    </table>
</div>
<div class="py-20 px-4 transition duration-150 ease-in-out z-10 fixed top-0 right-0 bottom-0 left-0 hidden h-full" id="add-modal">
   	<div class="absolute opacity-80 inset-0 z-0" style="background-color: rgba(0, 0, 0, 0.7);"></div>
    <div role="alert" class="container mx-auto w-11/12 md:w-2/3 max-w-xl">
        <div class="relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400">
            <h1 class="text-gray-800 font-lg font-medium tracking-normal leading-tight mb-4">Enter Item Details</h1>
            <form id="add_item" action="add_item.php" method="POST" enctype="multipart/form-data">
                <input type="text" class="hidden" name="uid" id="uid" value="<?= $uid ?>">
                <input type="text" class="hidden" name="id" id="id">
                <div class="mt-5 grid cols-grid-1 cols-grid-2 gap-x-2">
                    <div class="col-span-full flex justify-center items-center">
                        <!-- <div class="text-center">
                            <img id="previewImage" class="w-48 h-48 rounded-full bg-center object-cover" src="../images/image-svgrepo-com.svg">
                            <label class="relative cursor-pointer rounded-lg float-end" for="image">
                                <img class="w-6 h-6" src="../images/upload-minimalistic-svgrepo-com.svg">
                                <input id="image" name="image" class="sr-only" type="file" accept="image/jpg, image/jpeg, image/png" onchange="previewFile()" required>
                                <input type="hidden" name="old_image" id="old_image">
                            </label>
                        </div> -->
                    </div>
                    <div class="col-span-1">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="name">Name</label>
                        <input name="name" id="name" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" placeholder="Cup" type="text" autocomplete="off" required>
                    </div>
                    <div class="col-span-1">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="quantity">Quantity</label>
                        <input type="text" name="quantity" id="quantity" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" placeholder="100/10L/10KG"/>
                    </div>
                    <div class="col-span-full">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="description">Description</label>
                        <textarea name="description" id="description" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-600 font-normal w-full flex items-center pl-3 py-2 text-sm border-gray-300 rounded border" rows="3" autocomplete="off" required></textarea>
                    </div>
                </div>
                <i class="text-sm mb-4 text-gray-700">Note: Please be aware that modifying the quantity will increase the existing quantity.</i></p>
                <div class="flex items-center justify-start w-full">
                    <button type="submit" name="submit" id="submitBtn" class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 transition duration-150 ease-in-out bg-light-brown rounded text-white px-8 py-2 text-sm">Submit</button>
                    <button type="button" class="focus:outline-none focus:ring-2 focus:ring-offset-2  focus:ring-gray-400 ml-3 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm" onclick="modalHandler()">Cancel</button>
                </div>
                <button type="button" class="cursor-pointer absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600" onclick="modalHandler()" aria-label="close modal" role="button">
                    <img class="w-5 h-5" src="../images/close-svgrepo-com.svg" alt="">
                </button>
            </form>
        </div>
    </div>
</div>
<div class="py-20 px-4 transition duration-150 ease-in-out z-10 fixed top-0 right-0 bottom-0 left-0 hidden h-full" id="undo-modal">
   	<div class="absolute opacity-80 inset-0 z-0" style="background-color: rgba(0, 0, 0, 0.7);"></div>
    <div class="w-full max-w-lg p-5 relative mx-auto h-80 rounded-xl shadow-lg  bg-white ">
        <div class="">
            <div class="text-center p-5 flex-auto justify-center">
                <div class="w-full">
                <svg class="text-center" width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="Edit / Undo">
                    <path id="Vector" d="M10 8H5V3M5.29102 16.3569C6.22284 17.7918 7.59014 18.8902 9.19218 19.4907C10.7942 20.0913 12.547 20.1624 14.1925 19.6937C15.8379 19.225 17.2893 18.2413 18.3344 16.8867C19.3795 15.5321 19.963 13.878 19.9989 12.1675C20.0347 10.4569 19.5211 8.78001 18.5337 7.38281C17.5462 5.98561 16.1366 4.942 14.5122 4.40479C12.8878 3.86757 11.1341 3.86499 9.5083 4.39795C7.88252 4.93091 6.47059 5.97095 5.47949 7.36556" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                </svg>
                </div>
                <h2 class="text-xl font-bold py-4 text-black">Are you sure?</h3>
                <p class="text-sm text-gray-500 px-8">Do you really want to undo the changes?</p>    
            </div>
            <div class="p-3  mt-2 text-center space-x-4 md:block">
                <button class="undoItem mb-2 md:mb-0 bg-amber-500 border border-amber-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-amber-600" data-id=<?= $item['id']; ?> >Undo changes</button>
                <button class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100" onclick="undoModalHandler()">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="py-20 px-4 transition duration-150 ease-in-out z-10 fixed top-0 right-0 bottom-0 left-0 hidden h-full" id="delete-modal">
   	<div class="absolute opacity-80 inset-0 z-0" style="background-color: rgba(0, 0, 0, 0.7);"></div>
    <div class="w-full max-w-lg p-5 relative mx-auto h-80 rounded-xl shadow-lg  bg-white ">
        <div class="">
            <div class="text-center p-5 flex-auto justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -m-1 flex items-center text-red-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 flex items-center text-red-500 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <h2 class="text-xl font-bold py-4 text-black">Are you sure?</h3>
                <p class="text-sm text-gray-500 px-8">Do you really want to this delete this item? This process cannot be undone</p>    
            </div>
            <div class="p-3  mt-2 text-center space-x-4 md:block">
                <button class="deleteItem mb-2 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600" data-id=<?= $item['id']; ?> >Delete</button>
                <button class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100" onclick="deleteModalHandler()">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
    const modal = document.getElementById("add-modal");
    const openModalBtn = document.getElementById("addModalBtn");
    const deleteModal = document.getElementById("delete-modal");
    const deleteModalBtn = document.getElementById("deleteModalBtn");
    const editModal = document.getElementById("edit-modal");
    const editModalBtn = document.getElementById("editModalBtn");
    const undoModal = document.getElementById("undo-modal");
    const undoModalBtn = document.getElementById("undoModalBtn");
    const messages = document.getElementById("message");
    const divMessage = document.getElementsByClassName('hide-message')[0];
    
    function modalHandler(val) {
        if (val) {
            formElement.reset();
            fadeIn(modal);
        } else {
            fadeOut(modal);
        }
    }
    function deleteModalHandler(val) {
        if (val) {
            fadeIn(deleteModal);
        } else {
            fadeOut(deleteModal);
        }
    }
    function undoModalHandler(val) {
        if (val) {
            fadeIn(undoModal);
        } else {
            fadeOut(undoModal);
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


    const searchInput = document.getElementById('search');
    const itemsList = document.getElementById('itemsList');

    searchInput.addEventListener('input', function(){
        const searchTerm = this.value.trim();

        fetch(`search_item.php?search=${searchTerm}`)
        .then(response => response.text())
        .then(data => {
            itemsList.innerHTML = data;
        })
        .catch(error => {
            console.error('Error fetching items:', error);
        });
    });
    function showDeleteModal(itemId) {
        const deleteBtn = deleteModal.querySelector(".deleteItem");
        deleteBtn.setAttribute("data-id", itemId);
        fadeIn(deleteModal);
    }
    function showUndoModal(itemId) {
        const undoBtn = undoModal.querySelector(".undoItem");
        undoBtn.setAttribute("data-id", itemId);
        fadeIn(undoModal);
    }
    function showEditModal(id) {
        fetch('fetch_item.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('id').value = data.id;
                document.getElementById('name').value = data.name;
                // document.getElementById('quantity').value = data.quantity;
                document.getElementById('description').value = data.description;
                // document.getElementById('old_image').value = data.image;
                // document.getElementById('previewImage').src = '../uploaded_img/'+ data.image;
                fadeIn(modal);
            })
            .catch(error => console.error('Error fetching data:', error));
    }
    const submitBtn = document.getElementById('submitBtn');
    const formElement = document.getElementById('add_item'); 
    submitBtn.addEventListener('click', submitForm);

    function submitForm(event) {
    event.preventDefault();
    const formData = new FormData(formElement);

    fetch('add_item.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        formElement.reset();
        console.log(data);
        if (data.insert === true) {
            const newRow = document.createElement('tr');
            newRow.setAttribute('class', 'border-color');
            newRow.setAttribute('data-id', data.id);
            newRow.innerHTML = `
                <!--<td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                    <img class="w-16 h-16 object-cover" src="../uploaded_img/">
                </td>-->
                <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">${data.name}</td>
                <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">${data.quantity}</td>
                // <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">N/A</td>
                <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">${data.description}</td>
                <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">${data.added_at}</td>
                <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-4">
                        <button id="undoModalBtn" class="w-6 h-6" onclick="showUndoModal(${data.id})"><img src="../images/undo-svgrepo-com.svg" alt=""></button>
                        <button id="editModalBtn" class="w-6 h-6" onclick="showEditModal(${data.id})"><img src="../images/edit-svgrepo-com.svg" alt=""></button>
                        <button id="deleteModalBtn" class="w-6 h-6" onclick="showDeleteModal(${data.id})"><img src="../images/delete-svgrepo-com.svg" alt=""></button>
                    </div>
                </td>
            `;
            const tbody = document.getElementById('itemsList');
            tbody.appendChild(newRow);
            if (divMessage) {
                divMessage.classList.remove('hidden');
            }
            messages.textContent = data.message;
        } else if (data.update === true) {
            const inputDate = data.updated_at;
            const [datePart, timePart] = inputDate.split(" ");
            const [month, day, year] = datePart.split("-");
            const date = new Date(`${year}-${month}-${day}T${timePart}`);

            // Format the date
            const options = { year: "numeric", month: "long", day: "numeric" };
            const formattedDate = date.toLocaleDateString("en-US", options);

            // Format the time
            let hours = date.getHours();
            const minutes = date.getMinutes().toString().padStart(2, "0");
            const ampm = hours >= 12 ? "PM" : "AM";
            hours = hours % 12 || 12;

            const formattedTime = `${hours.toString().padStart(2, "0")}:${minutes} ${ampm}`;

            // Combine the formatted date and time
            const dateResult = `${formattedDate} ${formattedTime}`;
            const updatedRow = document.querySelector(`tr[data-id="${data.id}"]`);
            updatedRow.innerHTML = `
                <!--<td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                    <img class="w-16 h-16 object-cover" src="../uploaded_img/">
                </td>-->
                <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">${data.name}</td>
                <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">${data.quantity}</td>
                // <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">${data.quantity_before}</td>
                <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">${data.description === '' ? 'N/A' : data.description}</td>
                <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">${dateResult}</td>
                <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-4">
                        <button id="undoModalBtn" class="w-6 h-6" onclick="showUndoModal(${data.id})"><img src="../images/undo-svgrepo-com.svg" alt=""></button>
                        <button id="editModalBtn" class="w-6 h-6" onclick="showEditModal(${data.id})"><img src="../images/edit-svgrepo-com.svg" alt=""></button>
                        <button id="deleteModalBtn" class="w-6 h-6" onclick="showDeleteModal(${data.id})"><img src="../images/delete-svgrepo-com.svg" alt=""></button>
                    </div>
                </td>
            `;
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
        modalHandler(false);
    })
    .catch(error => {
        console.error('Error submitting form:', error);
    });
}
    const confirmDeleteBtn = deleteModal.querySelector(".deleteItem");
    confirmDeleteBtn.addEventListener("click", () => {
        const itemId = confirmDeleteBtn.getAttribute("data-id");
    
        fetch(`delete_item.php?id=${itemId}`, {
            method: "DELETE",
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Failed to delete item (Status ${response.status})`);
            }
            const rowToDelete = document.querySelector(`tr[data-id="${itemId}"]`);
            if (rowToDelete) {
                rowToDelete.remove();
            }
            fadeOut(deleteModal);
        })
        .catch(error => {
            console.error("Error deleting item:", error);
        });
    });
</script>