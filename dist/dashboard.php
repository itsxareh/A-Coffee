<div class="grid autofit-grid2 gap-12 p-2 mb-8">
    <?php 
        $get_orders = $conn->prepare("SELECT * FROM orders");
        $get_orders->execute();
        $total_orders = $get_orders->rowCount();
    ?>
    <div class="rounded-lg shadow-lg bg-dark-brown text-center flex flex-col justify-around h-52">
        <p class="text-white text-7xl salsa"><?= $total_orders ?></p>
        <p class="text-gray text-2xl salsa">Total Orders</p>
    </div>
    <?php 
        $get_products = $conn->prepare("SELECT * FROM products");
        $get_products->execute();
        $total_products = $get_products->rowCount();
    ?>
    <div class="rounded-lg shadow-lg bg-dark-brown text-center flex flex-col justify-around h-52">
        <p class="text-white text-7xl salsa"><?= $total_products ?></p>
        <p class="text-gray text-2xl salsa">Products</p>
    </div>
    <?php
        $get_total = $conn->prepare("SELECT SUM(amount) AS total_amount FROM orders");
        $get_total->execute();
        $get_total_amount = $get_total->fetch(PDO::FETCH_ASSOC);
        $total_amount = $get_total_amount['total_amount'];
    ?>
    <div class="rounded-lg shadow-lg bg-dark-brown text-center flex flex-col justify-around h-52">
        <p class="text-white text-4xl salsa">₱<?= $total_amount ?></p>
        <p class="text-gray text-2xl salsa">Total Sales</p>        
    </div>
</div>
<div class="text-3xl text-center text-white rosarivo">Orders</div>
<div class="overflow-x-auto">
    <table class="orderLists indent-0 border-collapse py-6 px-2  w-full" data-id="<?= $item['id']?>">
        <thead>
            <tr>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Order ID</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Orders</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Price</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Status</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $get_orders = $conn->prepare("SELECT * FROM orders ORDER by id DESC");
            $get_orders->execute();
            $orders = $get_orders->fetchAll(PDO::FETCH_ASSOC);
            if (count($orders) > 0){
                foreach($orders as $order){ ?>
                <tr class="border-color" data-id=<?= $order['id']?>>
                    <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $order['id'] ?></td>
                    <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?php $comma = strpos($order['products'], ','); $orders = trim(substr_replace($order['products'], '', $comma, 1)); echo $orders?></td>
                    <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">₱<?= $order['amount'];?></td>
                    <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?php switch($order['status']){ case 1: echo "Done"; break; case 2: echo "On process"; break; default: echo "N/A"; break; }?></td>
                    <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-4">
                        <?php 
                            if (($order['status']) === 2){
                                echo '<button id="editModalBtn" class="w-6 h-6" onclick="showEditModal('.$order['id'].')"><img src="../images/edit-svgrepo-com.svg" alt=""></button>';
                            }
                        ?>
                            <button id="deleteModalBtn" class="w-6 h-6" onclick="showDeleteModal(<?=$order['id']?>)"><img src="../images/delete-svgrepo-com.svg" alt=""></button>
                        </div>
                    </td>
                </tr>
                <?php
                }
            }
            ?>
            
        </tbody>
    </table>
</div>
<div class="py-20 transition duration-150 ease-in-out z-10 absolute top-0 right-0 bottom-0 left-0 hidden h-full" id="delete-modal">
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
    const deleteModal = document.getElementById("delete-modal");
    const deleteModalBtn = document.getElementById("deleteModalBtn");
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