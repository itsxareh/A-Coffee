<div class="hide-message hidden">
    <div class="message rounded-lg p-4 flex items-start">
        <span id="message" class="text-sm text-white"></span>
        <button class="-m-1" onclick="this.parentElement.remove();"><img class="w-5 h-5" src="../images/close-svgrepo-com.svg"></button>
    </div>
</div><div class="upper flex justify-between mb-4">
    <span class="text-gray text-4xl salsa title">Staffs</span>
    <div class="button-input flex">
        <button class="focus:outline-none focus:ring-2 focus:ring-offset-2 hover:bg-amber-400 focus:ring-amber-400 mx-auto transition duration-150 ease-in-out bg-light-brown rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm salsa" onclick="modalHandler(true)" id="addModalBtn">Add staff</button>
        <input id="search" name="search" class="search ml-4 px-4 py-2 w-48 rounded-md salsa text-black" type="text">
    </div>
</div>
<div class="overflow-x-auto">
    <table class="indent-0 border-collapse py-6 px-2  w-full">
        <thead>
            <tr>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Profile</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Name</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">UID</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Received Orders</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Total Sales</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Action</th>
            </tr>
        </thead>
        <tbody id="staffsList">
            <?php 
                $select_staffs = $conn->prepare("SELECT u.id, u.image, u.name, u.uid, SUM(o.amount) AS total, COUNT(o.uid) AS quantity FROM users u LEFT JOIN orders o ON u.uid = o.uid GROUP BY u.uid");
                $select_staffs->execute();
                $staffs = $select_staffs->fetchAll(PDO::FETCH_ASSOC);
                if (count($staffs) > 0){
                    foreach ($staffs as $staff){ ?>
                    
                    <tr class="border-color" data-id="<?= $staff['id']; ?>">
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                            <a class="cursor-pointer" href="index.php?page=view_staff&id=<?= $staff['id']; ?>" title="View Staff Details">
                                <img class="w-16 h-16 object-cover" src="../uploaded_img/<?= $staff['image']; ?>">
                            </a>
                        </td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= ucwords($staff['name']); ?></td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $staff['uid']; ?></td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= ($staff['quantity'] ? $staff['quantity'] : "0") ?></td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">₱<?= ($staff['total'] ? $staff['total'] : "0") ?></td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <button id="editModalBtn" class="w-6 h-6" onclick="showEditModal(<?= $staff['id'] ?>)"><img src="../images/edit-svgrepo-com.svg" alt=""></button>
                                <button id="deleteModalBtn" class="w-6 h-6" onclick="showDeleteModal(<?= $staff['id'] ?>)"><img src="../images/delete-svgrepo-com.svg" alt=""></button>
                            </div>
                        </td>
                    </tr>   
                <?php
                    }
                } else {
                    echo '<tr><td colspan="6" class="text-gray text-medium font-semibold p-3 py-4 text-center">No staffs found.</td></tr>';
                }
            ?>
        </tbody>
    </table>
</div>
<div class="py-20 transition duration-150 ease-in-out z-10 absolute top-0 right-0 bottom-0 left-0 hidden h-full" style="background-color: rgba(0, 0, 0, 0.7);" id="add-modal">
    <div role="alert" class="container mx-auto w-11/12 md:w-2/3 max-w-xl">
        <div class="relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400">
            <h1 class="text-gray-800 font-lg font-medium tracking-normal leading-tight mb-4">Enter Staff Details</h1>
            <form id="add_staff" action="add_staff.php" method="POST" enctype="multipart/form-data">
                <input type="text" class="hidden" name="uid" id="uid">
                <div class="mt-5 grid cols-grid-1 cols-grid-2 gap-x-2">
                    <div class="col-span-full flex justify-center">
                        <div class="text-center">
                            <img id="previewImage" class="w-48 h-48 rounded-full bg-center object-cover" src="../images/image-svgrepo-com.svg">
                            <label class="relative cursor-pointer rounded-lg float-end" for="image">
                                <img class="w-6 h-6" src="../images/upload-minimalistic-svgrepo-com.svg">
                                <input id="image" name="image" class="sr-only" type="file" accept="image/jpg, image/jpeg, image/png" onchange="previewFile()" required>
                                <input type="hidden" name="old_image" id="old_image">
                            </label>
                        </div>
                    </div>
                    <div class="col-span-1">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="name">Name</label>
                        <input name="name" id="name" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" placeholder="Juan Dela Cruz" type="text" autocomplete="off" required>
                    </div>
                    <div class="col-span-1">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="pnumber">Phone number</label>
                        <div class="relative mb-5 mt-2">
                            <div class="absolute text-gray-600 flex items-center px-2 border-r h-full">
                                <p class="text-sm text-gray-600 font-normal ">+63</p>
                            </div>
                            <input name="pnumber" id="pnumber" class="text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-12 text-sm border-gray-300 rounded border" placeholder="9123456789" />
                        </div>
                        <div id="pnumberError" class="text-red-500 salsa"></div>
                    </div>
                    <div class="col-span-1">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="gender">Gender</label>
                        <select name="gender" id="gender" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                            <option value="male" selected>Male</option> 
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="col-span-1">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="email">Email address</label>
                        <input name="email" id="email" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-600 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" autocomplete="off" placeholder="juandelacruz@gmail.com" type="email" required>
                    </div>
                    <div class="col-span-1">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="password">Password</label>
                        <input name="password" id="password" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" placeholder="********" type="password" autocomplete="off" required>
                    </div>
                    <div class="col-span-1">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="birthdate">Birthdate</label>
                        <input name="birthdate" id="birthdate" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" type="date" required>
                    </div>
                    <div class="col-span-1">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="usertype">User Type</label>
                        <select name="usertype" id="usertype" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                            <option class="0" value="0" selected>Staff</option> 
                            <option class="1" value="1">Manager</option>
                        </select>
                    </div>
                    <div class="col-span-full">
                        <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="address">Address</label>
                        <textarea name="address" id="address" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-600 font-normal w-full flex items-center pl-3 py-2 text-sm border-gray-300 rounded border" rows="3" autocomplete="off" placeholder="12 Zamora St. Sampaloc, Manila City" required></textarea>
                    </div>
                </div>
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

<div class="py-20 transition duration-150 ease-in-out z-10 fixed top-0 right-0 bottom-0 left-0 hidden h-full" id="delete-modal">
   	<div class="absolute opacity-80 inset-0 z-0" style="background-color: rgba(0, 0, 0, 0.7);"></div>
    <div class="w-full  max-w-lg p-5 relative mx-auto h-80 rounded-xl shadow-lg  bg-white ">
        <div class="">
            <div class="text-center p-5 flex-auto justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -m-1 flex items-center text-red-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 flex items-center text-red-500 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <h2 class="text-xl font-bold py-4 ">Are you sure?</h3>
                <p class="text-sm text-gray-500 px-8">Do you really want to this delete this staff? This process cannot be undone</p>    
            </div>
            <div class="p-3  mt-2 text-center space-x-4 md:block">
                <button class="deleteStaff mb-2 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600" data-id=<?= $staff['id']; ?> >Delete</button>
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
    const staffsList = document.getElementById('staffsList');

    searchInput.addEventListener('input', function(){
        const searchTerm = this.value.trim();

        fetch(`search_staff.php?search=${searchTerm}`)
        .then(response => response.text())
        .then(data => {
            staffsList.innerHTML = data;
        })
        .catch(error => {
            console.error('Error fetching staffs:', error);
        });
    });
    function showDeleteModal(staffId) {
        const deleteBtn = deleteModal.querySelector(".deleteStaff");
        deleteBtn.setAttribute("data-id", staffId);
        fadeIn(deleteModal);
    }
    function showEditModal(id) {
        fetch('fetch_staff.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('uid').value = data.uid;
                document.getElementById('name').value = data.name;
                document.getElementById('pnumber').value = data.pnumber;
                document.getElementById('gender').value = data.gender;
                document.getElementById('email').value = data.email;
                document.getElementById('password').value = data.password;
                document.getElementById('birthdate').value = data.birthdate;
                document.getElementById('usertype').value = data.user_type;
                document.getElementById('address').value = data.address;
                document.getElementById('old_image').value = data.image;
                document.getElementById('previewImage').src = '../uploaded_img/'+ data.image;
                fadeIn(modal);
            })
            .catch(error => console.error('Error fetching data:', error));
    }
    const submitBtn = document.getElementById('submitBtn');
    const formElement = document.getElementById('add_staff'); 
    submitBtn.addEventListener('click', submitForm);

    function submitForm(event) {
        modalHandler(false);
        event.preventDefault();
        const formData = new FormData(formElement); 
        
        fetch('add_staff.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            formElement.reset();
            console.log(data);
            if (data.insert === true) {
                const newRow = document.createElement('tr');
                newRow.setAttribute('class', 'border-color');
                newRow.setAttribute('data-id', data.id);
                newRow.innerHTML = `
                    <tr class="border-color" data-id="${data.id}">
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                            <a class="cursor-pointer" href="index.php?page=view_staff&id=${data.id}" title="View Staff Details">
                                <img class="w-16 h-16 object-cover" src="../uploaded_img/${data.image}">
                            </a>
                        </td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">${data.name}</td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">${data.uid}</td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">${data.quantity}</td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">₱${data.total}</td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <button id="editModalBtn" class="w-6 h-6" onclick="showEditModal(${data.id})"><img src="../images/edit-svgrepo-com.svg" alt=""></button>
                                <button id="deleteModalBtn" class="w-6 h-6" onclick="showDeleteModal(${data.id})"><img src="../images/delete-svgrepo-com.svg" alt=""></button>
                            </div>
                        </td>
                    </tr>
                `;
                const tbody = document.getElementById('staffsList');
                tbody.appendChild(newRow);
                if (divMessage) {
                    divMessage.classList.remove('hidden');
                }
                messages.textContent = data.message;
            } else if (data.update === true) {
                const updatedRow = document.querySelector(`tr[data-id="${data.id}"]`);
                updatedRow.innerHTML = `
                    <tr class="border-color" data-id="${data.id}">
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                            <a class="cursor-pointer" href="index.php?page=view_staff&id=${data.id}" title="View Staff Details">
                                <img class="w-16 h-16 object-cover" src="../uploaded_img/${data.image}">
                            </a>
                        </td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">${data.name}</td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">${data.uid}</td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">${data.quantity}</td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">₱${data.total}</td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <button id="editModalBtn" class="w-6 h-6" onclick="showEditModal(${data.id})"><img src="../images/edit-svgrepo-com.svg" alt=""></button>
                                <button id="deleteModalBtn" class="w-6 h-6" onclick="showDeleteModal(${data.id})"><img src="../images/delete-svgrepo-com.svg" alt=""></button>
                            </div>
                        </td>
                    </tr>
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
        })
        .catch(error => {
            console.error('Error submitting form:', error);
        });
    }
    
    const pnumberInput = document.getElementById('pnumber');
    const pnumberError = document.getElementById('pnumberError');

    if (pnumberInput && pnumberError) {
        pnumberInput.addEventListener('input', function() {
        const pnumberValue = this.value.trim(); 
        const isValid = /^[0-9]+(\.[0-9]{1,2})?$/.test(pnumberValue); 
        if (!isValid) {
            pnumberError.textContent = 'Please enter a valid phone number';
            pnumberInput.classList.add('border-red-500');
        } else {
            pnumberError.textContent = '';
            pnumberInput.classList.remove('border-red-500');
        }
        });
    } 

    const confirmDeleteBtn = deleteModal.querySelector(".deleteStaff");
    confirmDeleteBtn.addEventListener("click", () => {
        const staffId = confirmDeleteBtn.getAttribute("data-id");
    
        fetch(`delete_staff.php?id=${staffId}`, {
            method: "DELETE",
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Failed to delete staff (Status ${response.status})`);
            }
            const rowToDelete = document.querySelector(`tr[data-id="${staffId}"]`);
            if (rowToDelete) {
                rowToDelete.remove();
            }
            fadeOut(deleteModal);
        })
        .catch(error => {
            console.error("Error deleting staff:", error);
        });
    });
</script>