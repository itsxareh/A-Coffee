<div class="sidebar text-center fixed bottom-0 top-16 w-80 bg-dark-brown">
    <div class="datetime p-2 my-10 ">
        <div id="date" class="text-lg text-gray rosarivo"></div>
        <div id="time" class="text-lg text-gray rosarivo"></div>
    </div>
    <div class="nav p-2">
        <a class="flex items-center navigation nav-dashboard rounded-lg w-full p-4" href="./index.php?page=dashboard">
            <img class="w-5 h-5" src="/images/dashboard-4-svgrepo-com.svg" alt="">
            <span class="text-white salsa ml-4">Dashboard</span>
        </a>
        <a class="flex items-center navigation nav-inventory rounded-lg w-full p-4" href="./index.php?page=inventory">
            <img class="w-5 h-5" src="/images/inventory-svgrepo-com.svg" alt="">
            <span class="text-white salsa ml-4">Inventory</span>
        </a>
        <a class="flex items-center navigation nav-products rounded-lg w-full p-4" href="./index.php?page=products">
            <img class="w-5 h-5" src="/images/coffee-svgrepo-com.svg" alt="">
            <span class="text-white salsa ml-4">Products</span>
        </a>
        <?php if ($fetch_profile['user_type'] == 0  ){?>         
        <a class="flex items-center navigation nav-orders rounded-lg w-full p-4" href="./index.php?page=orders">
            <img class="w-5 h-5" src="/images/cart-plus-svgrepo-com.svg" alt="">
            <span class="text-white salsa ml-4">Order</span>
        </a> 
        <?php } ?>
        <?php if ($fetch_profile['user_type'] == 1){?> 
        <a class="flex items-center navigation nav-sales rounded-lg w-full p-4" href="./index.php?page=sales">
            <img class="w-5 h-5" src="/images/sales-up-graph-svgrepo-com.svg" alt="">
            <span class="text-white salsa ml-4">Sales</span>
        </a>
        <a class="flex items-center navigation nav-staffs rounded-lg w-full p-4" href="./index.php?page=staffs">
            <img class="w-5 h-5" src="/images/people-svgrepo-com.svg" alt="">
            <span class="text-white salsa ml-4">Staffs</span>
        </a>
        <?php } ?>
    </div>
</div>
<script>
function displayPhilippinesTime() {
    const now = new Date().toLocaleString("en-US", { timeZone: "Asia/Manila" });
    const date = new Date(now);

    const formattedDate = new Intl.DateTimeFormat("en-US", {
        year: 'numeric', 
        month: 'long',
        day: 'numeric' 
    }).format(date);

    const formattedTime = new Intl.DateTimeFormat("en-US", {
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        hour12: true
    }).format(date);

    document.getElementById("date").innerText = `${formattedDate}`;
    document.getElementById("time").innerText =  `${formattedTime}`;
}

// Update the display every second
setInterval(displayPhilippinesTime, 100);

</script>