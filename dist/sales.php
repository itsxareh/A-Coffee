<div class="hide-message hidden">
    <div class="message rounded-lg p-4 flex items-start">
        <span id="message" class="text-sm text-white"></span>
        <button class="-m-1" onclick="this.parentElement.remove();"><img class="w-5 h-5" src="../images/close-svgrepo-com.svg"></button>
    </div>
</div>
<div class="upper flex justify-between mb-4">
    <span class="text-gray text-2xl salsa title">Sales</span>
    <div class="button-input flex">
        <select class="rounded-md w-24 px-2 text-black" name="sales" id="sales" onchange="fetchSales()">
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
            <option value="yearly">Yearly</option>
        </select>
    </div>
</div>
<div class="overflow-x-auto">
    <table class="indent-0 border-collapse py-6 px-2  w-full" id="itemsTable">
        <thead>
            <tr>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Date</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Sales</th>
            </tr>
        </thead>
        <tbody id="salesList">
            <?php 
                $inventory_log = $conn->prepare("SELECT STR_TO_DATE(placed_on, '%m-%d-%Y') AS date, SUM(amount) AS sales FROM orders GROUP BY STR_TO_DATE(placed_on, '%m-%d-%Y') ORDER BY STR_TO_DATE(placed_on, '%m-%d-%Y') DESC");
                $inventory_log->execute();
                $log = $inventory_log->fetchAll(PDO::FETCH_ASSOC);
                if (count($log) > 0){ 
                    foreach ($log as $row) {?>
                    <tr class="border-color">
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $row['date'] ?></td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">₱<?= $row['sales'] ?></td>
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

<script>
function fetchSales() {
    var selectedOption = document.getElementById("sales").value;
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_sale.php?option=" + selectedOption, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("salesList").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}
</script>