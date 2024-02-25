<div class="sidebar  text-center fixed left-0 bottom-0 top-16 w-80" style="background-color: rgba(0,0,0,0.5);">
    <div class="datetime my-10">
        <div id="date" class="text-xl text-white rosarivo"></div>
        <div id="time" class="text-xl text-white rosarivo"></div>
    </div>
    <div class="nav">
        <div class="dashboard">
            <img class="w-10 h-10" src="" alt="">
            <a href="./dashboard.php">Dashboard</a>
        </div>
        <div class="orders">
            <img class="w-10 h-10" src="" alt="">
            <a href="./orders.php">Orders</a>
        </div>
        <div class="inventory">
            <img class="w-10 h-10" src="" alt="">
            <a href="./inventory.php">Inventory</a>
        </div>
        <div class="products">
            <img class="w-10 h-10" src="" alt="">
            <a href="./products.php">Products</a>
        </div>
        <div class="sales">
            <img class="w-10 h-10" src="" alt="">
            <a href="./sales.php">Sales</a>
        </div>
        <div class="staffs">
            <img class="w-10 h-10" src="" alt="">
            <a href="./staffs.php">Staffs</a>
        </div>
    </div>
</div>
<script>
function displayPhilippinesTime() {
    const now = new Date().toLocaleString("en-US", { timeZone: "Asia/Manila" });
    const date = new Date(now);

    const formattedDate = new Intl.DateTimeFormat("en-US", {
        weekday: 'long',
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
setInterval(displayPhilippinesTime, 1000);

</script>