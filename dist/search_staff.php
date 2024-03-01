<?php
include 'config.php';
error_reporting(E_ALL); 
ini_set('display_errors', 1);

$searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '';

if ($searchTerm !== '') {
    $select_staffs = $conn->prepare("SELECT u.id, u.image, u.name, u.uid, SUM(o.amount) AS total, SUM(o.amount) AS quantity FROM users u LEFT JOIN orders o ON u.uid = o.uid WHERE name LIKE ? GROUP BY u.uid");
    $select_staffs->execute([$searchTerm]);

    $staffs = $select_staffs->fetchAll(PDO::FETCH_ASSOC);
    if (count($staffs) > 0) {
        foreach ($staffs as $staff) {
            echo '<tr class="border-color" data-id="'.$staff['id'].'">';
                echo '<td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">';
                    echo '<a class="cursor-pointer" href="index.php?page=view_staff&id='.$staff['id'].'">';
                        echo '<img class="w-16 h-16 object-cover" src="../uploaded_img/'.$staff['image'].'">';
                    echo '</a>';
                echo '</td>';
                echo '<td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">'.ucwords($staff['name']).'</td>';
                echo '<td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">'.$staff['uid'].'</td>';
                echo '<td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">'.($staff['quantity'] ? $staff['quantity'] : "0") .'</td>';
                echo '<td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">'.($staff['total'] ? $staff['total'] : "0") .'</td>';
                echo '<td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">';
                    echo '<div class="flex items-center gap-4">';
                        echo '<button class="w-6 h-6" onclick="showEditModal('.$staff['id'].')"><img src="../images/edit-svgrepo-com.svg" alt=""></button>';
                        echo '<button  class="w-6 h-6 deleteModalBtn" onclick="showDeleteModal('.$staff['id'].')"><img src="../images/delete-svgrepo-com.svg" alt=""></button>';
                    echo '</div>';
                echo '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="6" class="text-gray text-medium font-semibold p-3 py-4 text-center">No staff found.</td></tr>';
    }
} else {
    echo '<tr class="text-gray text-2xl">Please enter a search term!</tr>';
}
?>
<div class="py-12 transition duration-150 ease-in-out z-10 absolute top-0 right-0 bottom-0 left-0 hidden h-full" id="delete-modal">
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

const deleteModal = document.getElementById("delete-modal");
const deleteModalBtns = document.querySelectorAll(".deleteModalBtn");

function showDeleteModal(staffId) {
    console.log('Delete button clicked');
    const deleteBtn = deleteModal.querySelector(".deleteStaff");
    deleteBtn.setAttribute("data-id", staffId);
    fadeIn(deleteModal);
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

const form = document.querySelector('form');
form.addEventListener('submit', submitForm);

function submitForm(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form); 

    fetch('add_staff.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log('Response data:', data);
        staffsList.innerHTML += data;
        form.reset();
        modalHandler(false);
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

staffsList.addEventListener('click', function(event) {
    if (event.target.classList.contains('deleteStaff')) {
        const staffId = event.target.closest("tr").dataset.id;
        const deleteBtn = deleteModal.querySelector(".deleteStaff");
        deleteBtn.setAttribute("data-id", staffId);
        fadeIn(deleteModal);
    }
});



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
