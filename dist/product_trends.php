<div class="hide-message hidden">
    <div class="message rounded-lg p-4 flex items-start">
        <span id="message" class="text-sm text-white"></span>
        <button class="-m-1" onclick="this.parentElement.remove();"><img class="w-5 h-5" src="../images/close-svgrepo-com.svg"></button>
    </div>
</div>
<div class="upper flex justify-between mb-4">
    <span class="text-gray text-2xl salsa title">Product Trends</span>
    <div class="button-input flex">
        <input title="Date" class="text-center mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 text-sm border-gray-300 rounded border" id="dateTrend" name="dateTrend" type="date" onchange="fetchTrends()">
    </div>
</div>
<div class="overflow-x-auto">
    <table class="indent-0 border-collapse py-6 px-2  w-full" id="itemsTable">
        <thead>
            <tr>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Name</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Quantity</th>
                <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Sales</th>
            </tr>
        </thead>
        <tbody id="trendsList">
            <?php 
                $product_trends = $conn->prepare(
                    "SELECT p.id, p.image, p.price,
                        p.name AS name,
                        COALESCE(SUM(op.total_quantity), 0) AS total_quantity
                    FROM products p
                    LEFT JOIN (
                        SELECT 
                            product_name,
                            SUM(quantity) AS total_quantity
                        FROM (
                            SELECT 
                                SUBSTRING_INDEX(item, ' ', 1) AS quantity,
                                TRIM(SUBSTRING(item, LENGTH(SUBSTRING_INDEX(item, ' ', 1)) + 2)) AS product_name
                            FROM (
                                SELECT 
                                    TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(products, ',', numbers.n), ',', -1)) AS item
                                FROM
                                    (SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) AS numbers
                                JOIN orders ON CHAR_LENGTH(products) - CHAR_LENGTH(REPLACE(products, ',', '')) >= numbers.n - 1
                            ) AS order_details
                        ) AS quantities_per_product
                        GROUP BY product_name
                    ) AS op ON p.name = op.product_name
                    GROUP BY p.name
                    ORDER BY total_quantity DESC");
                $product_trends->execute();
                $trends = $product_trends->fetchAll(PDO::FETCH_ASSOC);
                if (count($trends) > 0){ 
                    foreach ($trends as $trend) {?>
                    <tr class="border-color">
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $trend['name'] ?></td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $trend['total_quantity'] ?></td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">₱<?= $trend['total_quantity'] * $trend['price'] ?></td>
                    </tr>   
                <?php
                    }
                } else {
                    echo '<tr><td colspan="6" class="text-gray text-medium font-semibold p-3 py-4 text-center">No orders found.</td></tr>';
                }
            ?>
        </tbody>
    </table>
</div>

<script>
function fetchTrends() {
    var dateTrend = document.getElementById("dateTrend").value;
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_trend.php?date=" + dateTrend, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("trendsList").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}
</script>