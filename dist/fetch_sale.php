<?php 
include "config.php";
if (isset($_GET['option'])) {
    $option = $_GET['option'];

    if ($option == "daily") {
        $query = "
            SELECT 
                STR_TO_DATE(datetime, '%m-%d-%Y') AS date, 
                SUM(amount) AS sales, 
                COUNT(*) AS transactions, 
                AVG(amount) AS avg_transaction, 
                LAG(SUM(amount)) OVER (ORDER BY STR_TO_DATE(datetime, '%m-%d-%Y')) AS prev_sales
            FROM sales 
            GROUP BY STR_TO_DATE(datetime, '%m-%d-%Y') 
            ORDER BY STR_TO_DATE(datetime, '%m-%d-%Y') DESC
        ";
    } elseif ($option == "weekly") {
        $query = "
            SELECT 
                YEARWEEK(STR_TO_DATE(datetime, '%m-%d-%Y')) AS date, 
                SUM(amount) AS sales, 
                COUNT(*) AS transactions, 
                AVG(amount) AS avg_transaction, 
                LAG(SUM(amount)) OVER (ORDER BY YEARWEEK(STR_TO_DATE(datetime, '%m-%d-%Y'))) AS prev_sales
            FROM sales 
            GROUP BY YEARWEEK(STR_TO_DATE(datetime, '%m-%d-%Y')) 
            ORDER BY YEARWEEK(STR_TO_DATE(datetime, '%m-%d-%Y')) DESC
        ";
    } elseif ($option == "monthly") {
        $query = "
            SELECT 
                DATE_FORMAT(STR_TO_DATE(datetime, '%m-%d-%Y'), '%Y-%m') AS date, 
                SUM(amount) AS sales, 
                COUNT(*) AS transactions, 
                AVG(amount) AS avg_transaction, 
                LAG(SUM(amount)) OVER (ORDER BY DATE_FORMAT(STR_TO_DATE(datetime, '%m-%d-%Y'), '%Y-%m')) AS prev_sales
            FROM sales 
            GROUP BY DATE_FORMAT(STR_TO_DATE(datetime, '%m-%d-%Y'), '%Y-%m') 
            ORDER BY DATE_FORMAT(STR_TO_DATE(datetime, '%m-%d-%Y'), '%Y-%m') DESC
        ";
    } elseif ($option == "yearly") {
        $query = "
            SELECT 
                YEAR(STR_TO_DATE(datetime, '%m-%d-%Y')) AS date, 
                SUM(amount) AS sales, 
                COUNT(*) AS transactions, 
                AVG(amount) AS avg_transaction, 
                LAG(SUM(amount)) OVER (ORDER BY YEAR(STR_TO_DATE(datetime, '%m-%d-%Y'))) AS prev_sales
            FROM sales 
            GROUP BY YEAR(STR_TO_DATE(datetime, '%m-%d-%Y')) 
            ORDER BY YEAR(STR_TO_DATE(datetime, '%m-%d-%Y')) DESC
        ";
    }

    if (isset($query)) {
        $inventory_log = $conn->prepare($query);
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
            echo '<tr><td colspan="6" class="text-gray text-medium font-semibold p-3 py-4 text-center">No sales found.</td></tr>';
        }
    } else {
        echo '<tr><td colspan="6" class="text-gray text-medium font-semibold p-3 py-4 text-center">Invalid option.</td></tr>';
    }
} else {
    echo '<tr><td colspan="6" class="text-gray text-medium font-semibold p-3 py-4 text-center">Option not set.</td></tr>';
}
?>