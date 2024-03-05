<div class="hide-message hidden">
    <div class="message rounded-lg p-4 flex items-start">
        <span id="message" class="text-sm text-white"></span>
        <button class="-m-1" onclick="this.parentElement.remove();"><img class="w-5 h-5" src="../images/close-svgrepo-com.svg"></button>
    </div>
</div>
<div class="grid autofit-grid2 gap-12 p-2 mb-8">
    <?php 
        $get_orders = $conn->prepare("SELECT o.uid  FROM orders o LEFT JOIN users u ON o.uid = u.uid WHERE o.uid = ?");
        $get_orders->execute([$uid]);
        $total_orders = $get_orders->rowCount();
    ?>
    <div class="rounded-lg shadow-lg bg-dark-brown text-center flex flex-col justify-around h-52">
        <p class="text-white text-5xl"><?= $total_orders ?></p>
        <span class="text-gray text-2xl">Total Orders</span>
    </div>
    <?php 
        $get_products = $conn->prepare("SELECT * FROM products");
        $get_products->execute();
        $total_products = $get_products->rowCount();
    ?>
    <div class="rounded-lg shadow-lg bg-dark-brown text-center flex flex-col justify-around h-52">
        <p class="text-white text-5xl"><?= $total_products ?></p>
        <span class="text-gray text-2xl">Products</span>
    </div>
    <?php
        $get_total = $conn->prepare("SELECT SUM(o.amount) AS total_amount FROM orders o LEFT JOIN users u ON o.uid = u.uid WHERE o.status = 1 AND o.uid = ?");
        $get_total->execute([$uid]);
        $get_total_amount = $get_total->fetch(PDO::FETCH_ASSOC);
        $total_amount = $get_total_amount['total_amount'];
    ?>
    <div class="rounded-lg shadow-lg bg-dark-brown text-center flex flex-col justify-around h-52">
        <p class="text-white text-5xl line-clamp-1 hover:line-clamp-1">₱<?= $total_amount ? $total_amount : 0 ?></p>
        <span class="text-gray text-2xl">Total Sales</span>        
    </div>
</div>
<div class="text-3xl text-center text-white rosarivo">Orders</div>
<div class="overflow-x-auto">
    <table class="orderLists indent-0 border-collapse py-6 px-2  w-full">
        <thead>
            <tr>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Order ID</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left min-w-48 max-w-72">Orders</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Price</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Status</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $get_orders = $conn->prepare("SELECT * FROM `orders` WHERE uid = ? ORDER BY CASE WHEN status = 2 THEN 0 WHEN status = 1 THEN 1 END, CASE WHEN status = 1 THEN id END DESC;");
            $get_orders->execute([$uid]);
            $orders = $get_orders->fetchAll(PDO::FETCH_ASSOC);
            if (count($orders) > 0){
                foreach($orders as $order){ ?>
                <tr class="border-color" data-id="<?= $order['id'] ?>">
                    <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap rosarivo"><?= $order['id'] ?></td>
                    <td class="text-gray text-medium text-sm p-3 py-4 whitespace-wrap rosarivo min-w-48 max-w-72"><?= $order['products']?></td>
                    <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap rosarivo">₱<?= $order['amount']; ?></td>
                    <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap text-balance rosarivo">
                    <?php if ($order['status']===2) { ?>
                        <select class="text-white text-medium text-sm bg-transparent whitespace-nowrap rosarivo status-select" name="status" data-id="<?= $order['id'] ?>">
                            <option class="text-black text-medium rosarivo " value="2" <?= $order['status'] == 2 ? 'selected' : '' ?>>On Process</option>
                            <option class="text-black text-medium rosarivo " value="1" <?= $order['status'] == 1 ? 'selected' : '' ?>>Done</option>
                        </select>
                        <?php
                    } else {
                        echo 'Done';
                    }?>
                    </td>
                    <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap rosarivo">
                        <div class="flex items-center gap-4">
                            <?php if ($order['status'] == 2): ?>
                                <button id="statusBtn" class="statusBtn w-6 h-6" title="Save" data-id="<?= $order['id'] ?>"><img src="../images/edit-svgrepo-com.svg" alt=""></button>
                                <button id="deleteModalBtn" class="deleteModalBtn w-6 h-6" title="Delete" onclick="showDeleteModal(<?= $order['id'] ?>)"><img src="../images/delete-svgrepo-com.svg" alt=""></button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php
                } 
            } else { ?>
                <tr><td colspan="5" class=" text-gray text-medium font-semibold p-3 py-4 text-center">No orders found.</td></tr>
            <?php }
            ?>
        </tbody>
    </table>
</div>

<div class="py-20 transition duration-150 ease-in-out z-10 fixed top-0 right-0 bottom-0 left-0 h-full hidden" id="notification-modal">
   	<div class="absolute opacity-80 inset-0 z-0" style="background-color: rgba(0, 0, 0, 0.7);"></div>
    <div class="w-full  max-w-lg p-5 relative mx-auto h-80 rounded-xl shadow-lg  bg-white ">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-whit" onclick="notificationModalHandler()">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 h-full flex flex-col justify-between">
                <h3 class="mb-4 text-xl font-bold text-gray-90">Approaching Low Quantity</h3>
                <p class="text-gray-500 text-md font-normal dark:text-gray-400 mb-6">The following item/s have low inventory quantity. Please restocking soon:<p>
                <div class="text-center"><span id="notification" class="text-md font-medium text-gray-900 mb-6"></span></div>
                <div class="p-3  mt-2 text-center space-x-4 md:block">
                    <button class="mb-2 md:mb-0 bg-light-brown px-5 py-2 text-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-amber-400" onclick="notificationModalHandler()">Okay</button>
                </div>
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
                <p class="text-sm text-gray-500 px-8">Do you really want to this delete this order? This process cannot be undone</p>    
            </div>
            <div class="p-3  mt-2 text-center space-x-4 md:block">
                <button class="deleteOrder mb-2 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600" data-id=<?= $order['id']; ?> >Delete</button>
                <button class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100" onclick="deleteModalHandler()">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
const messages = document.getElementById("message");
const divMessage = document.getElementsByClassName('hide-message')[0];
const notification = document.getElementById("notification");
const divNotification = document.getElementById("notification-modal");
document.querySelectorAll('.statusBtn').forEach(button => {
    button.addEventListener('click', function() {
        const orderId = this.getAttribute('data-id');
        const statusSelect = document.querySelector(`.status-select[data-id="${orderId}"]`);
        const status = statusSelect.value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_status.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success === true) {
                        const row = button.closest('tr');
                        const tbody = row.parentNode;
                        tbody.appendChild(row);

                        if (divMessage) {
                            divMessage.classList.remove('hidden');
                            messages.textContent = response.message;
                        }
                        setTimeout(function() {
                            if (divMessage) {
                                divMessage.classList.add('hidden');
                            }
                        }, 1500); 
                    if (response.notification !== '' || !empty(response.notification)) {
                        divNotification.classList.remove('hidden');
                        notification.textContent = response.notification;
                    }
                } else {
                    console.error('Error updating status');
                }
            }
        };
        xhr.send('orderId=' + orderId + '&status=' + status);
    });
});
    const deleteModal = document.getElementById("delete-modal");
    const deleteModalBtn = document.getElementById("deleteModalBtn");
    function deleteModalHandler(val) {
        if (val) {
            fadeIn(deleteModal);
        } else {
            fadeOut(deleteModal);
        }
    }
    function notificationModalHandler(val) {
        if (val) {
            fadeIn(divNotification);
        } else {
            fadeOut(divNotification);
            window.location.reload();
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
   
    function showDeleteModal(orderId) {
        const deleteBtn = deleteModal.querySelector(".deleteOrder");
        deleteBtn.setAttribute("data-id", orderId);
        fadeIn(deleteModal);
    }
    const confirmDeleteBtn = deleteModal.querySelector(".deleteOrder");
    confirmDeleteBtn.addEventListener("click", () => {
        const orderId = confirmDeleteBtn.getAttribute("data-id");
    
        fetch(`delete_order.php?id=${orderId}`, {
            method: "DELETE",
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Failed to delete order (Status ${response.status})`);
            }
            const rowToDelete = document.querySelector(`tr[data-id="${orderId}"]`);
            if (rowToDelete) {
                rowToDelete.remove();
            }
            fadeOut(deleteModal);
        })
        .catch(error => {
            console.error("Error deleting order:", error);
        });
    });
</script>