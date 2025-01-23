<?php 
if ($fetch_profile['user_type'] == 1) { ?>
    <div class="hide-message hidden">
        <div class="message rounded-lg p-4 flex items-start">
            <span id="message" class="text-sm text-white"></span>
            <button class="-m-1" onclick="this.parentElement.remove();"><img class="w-5 h-5" src="../images/close-svgrepo-com.svg"></button>
        </div>
    </div>

    <!-- Sales Analytics Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg p-4 shadow-md">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Total Sales</h3>
            <?php
            $total_sales = $conn->query("SELECT SUM(amount) as total FROM sales")->fetch();
            echo "<p class='text-gray-900 text-2xl font-bold'>₱" . number_format($total_sales['total'], 2) . "</p>";
            
            // Calculate growth from previous period
            $prev_period = $conn->query("SELECT SUM(amount) as total FROM sales WHERE STR_TO_DATE(datetime, '%m-%d-%Y') < CURDATE() - INTERVAL 30 DAY")->fetch();
            if ($prev_period['total'] > 0) {
                $growth = ($total_sales['total'] - $prev_period['total']) / $prev_period['total'] * 100;
                echo "<p class='text-sm " . ($growth >= 0 ? 'text-green-600' : 'text-red-600') . "'>" . 
                    ($growth >= 0 ? '↑' : '↓') . abs(round($growth, 1)) . "% from previous period</p>";
            } else {
                echo "<p class='text-sm text-gray-600'>No data for growth calculation</p>";
            }
            ?>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Today's Sales</h3>
            <?php
            $today_sales = $conn->query("SELECT SUM(amount) as total FROM sales WHERE DATE(STR_TO_DATE(datetime, '%m-%d-%Y')) = CURDATE()")->fetch();
            echo "<p class='text-gray-900 text-2xl font-bold'>₱" . number_format($today_sales['total'] ?? 0, 2) . "</p>";
            
            // Compare with yesterday
            $yesterday_sales = $conn->query("SELECT SUM(amount) as total FROM sales WHERE DATE(STR_TO_DATE(datetime, '%m-%d-%Y')) = CURDATE() - INTERVAL 1 DAY")->fetch();
            if ($yesterday_sales['total'] > 0) {
                $daily_growth = ($today_sales['total'] - $yesterday_sales['total']) / $yesterday_sales['total'] * 100;
                echo "<p class='text-sm " . ($daily_growth >= 0 ? 'text-green-600' : 'text-red-600') . "'>" . 
                    ($daily_growth >= 0 ? '↑' : '↓') . abs(round($daily_growth, 1)) . "% vs yesterday</p>";
            } else {
                echo "<p class='text-sm text-gray-600'>No data for daily growth calculation</p>";
            }
            ?>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Average Order Value</h3>
            <?php
            $avg_order = $conn->query("SELECT AVG(amount) as avg FROM sales")->fetch();
            echo "<p class='text-gray-900 text-2xl font-bold'>₱" . number_format($avg_order['avg'] ?? 0, 2) . "</p>";
            
            // Get peak hours
            $peak_hour = $conn->query("
                SELECT HOUR(STR_TO_DATE(datetime, '%m-%d-%Y %H:%i:%s')) as hour, COUNT(*) as count 
                FROM sales 
                GROUP BY HOUR(STR_TO_DATE(datetime, '%m-%d-%Y %H:%i:%s')) 
                ORDER BY count DESC LIMIT 1
            ")->fetch();
            echo "<p class='text-sm text-gray-600'>Peak hour: " . sprintf("%02d:00", $peak_hour['hour']) . "</p>";
            ?>
        </div>
        
    </div>
    <div class="grid grid-cols-2 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-lg p-4 shadow-md mb-6">
            <h3 class="text-lg font-semibold text-gray-600 mb-4">Sales Trend</h3>
            <canvas id="salesChart" height="100"></canvas>
        </div>
        <!-- Sales Trend Chart -->
        <div class="bg-white rounded-lg p-4 shadow-md mb-6">
            <h3 class="text-lg font-semibold text-gray-600 mb-4">Product Trend</h3>
            <canvas id="productChart" height="100"></canvas>
        </div>
    </div>

    <div class="upper flex justify-between mb-4">
        <span class="text-gray text-2xl salsa title">Sales History</span>
        <div class="button-input flex gap-2">
            <select class="rounded-md w-24 px-2 text-black" name="sales" id="sales" onchange="fetchSales()">
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
            <button onclick="printSales()" class="bg-amber-500 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded">
                Print
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="indent-0 border-collapse py-6 px-2 w-full" id="itemsTable">
            <thead>
                <tr>
                    <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Date</th>
                    <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Sales</th>
                    <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Orders</th>
                    <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Avg. Order</th>
                    <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Growth</th>
                </tr>
            </thead>
            <tbody id="salesList">
                <?php 
                    $inventory_log = $conn->prepare("
                        SELECT 
                            STR_TO_DATE(datetime, '%m-%d-%Y') AS date,
                            SUM(amount) AS sales,
                            COUNT(*) as transactions,
                            AVG(amount) as avg_transaction,
                            LAG(SUM(amount)) OVER (ORDER BY STR_TO_DATE(datetime, '%m-%d-%Y')) as prev_sales
                        FROM sales 
                        GROUP BY STR_TO_DATE(datetime, '%m-%d-%Y') 
                        ORDER BY STR_TO_DATE(datetime, '%m-%d-%Y') DESC
                    ");
                    $inventory_log->execute();
                    $log = $inventory_log->fetchAll(PDO::FETCH_ASSOC);
                    if (count($log) > 0){ 
                        foreach ($log as $row) {
                            $growth = $row['prev_sales'] ? (($row['sales'] - $row['prev_sales']) / $row['prev_sales'] * 100) : 0;
                            ?>
                        <tr class="border-color">
                            <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $row['date'] ?></td>
                            <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">₱<?= number_format($row['sales'], 2) ?></td>
                            <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $row['transactions'] ?></td>
                            <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">₱<?= number_format($row['avg_transaction'], 2) ?></td>
                            <td class="text-medium text-sm p-3 py-4 whitespace-nowrap <?= $growth >= 0 ? 'text-green-600' : 'text-red-600' ?>">
                                <?= ($growth >= 0 ? '↑' : '↓') . abs(round($growth, 1)) ?>%
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

    <!-- Print-specific styling -->
    <style media="print">
        .button-input, .hide-message {
            display: none !important;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        @page {
            size: landscape;
        }
    </style>

    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
        // Initialize sales chart
        fetch('get_sales.php')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('salesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.dates,
                        datasets: [{
                            label: 'Sales',
                            data: data.sales,
                            borderColor: 'rgb(245, 158, 11)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });

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

        fetch('fetch_product_data.php')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('productChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Product Sales',
                        data: data.counts,
                        backgroundColor: 'rgba(59, 130, 246, 0.6)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: (ctx) => ctx.raw + ' sales' } }
                    },
                    scales: {
                        x: { title: { display: true, text: 'Products' } },
                        y: { beginAtZero: true, title: { display: true, text: 'Sales Count' } }
                    }
                }
            });
        });
</script>
<script>
    function printSales() {
        const tableContent = document.getElementById('itemsTable').outerHTML;
        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Print Sales</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin: 20px 0;
                    }
                    th, td {
                        border: 1px solid #ddd;
                        padding: 8px;
                        text-align: left;
                    }
                    th {
                        background-color: #f4f4f4;
                        font-weight: bold;
                    }
                    h1 {
                        text-align: center;
                        font-size: 24px;
                        margin-bottom: 20px;
                        color: #333;

                    }
                </style>
            </head>
            <body>
                <h1>A Coffee Sales</h1>
                <table>${tableContent}</table>
                <script>
                    window.print();
                    window.onafterprint = () => { window.close(); };
                <\/script>
            </body>
            </html>
        `);
        printWindow.document.close();
    }
</script>
<?php
} else {
    echo '<p class="text-gray text-medium p-3 py-4 text-center">Error 404: Unauthorized Access.</p>';
}
?>