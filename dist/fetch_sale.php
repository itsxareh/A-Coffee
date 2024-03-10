<?php 
include "config.php";
if (isset($_GET['option'])) {
    $option = $_GET['option'];
    
    if ($option == "daily") {
        $query = "SELECT STR_TO_DATE(placed_on, '%m-%d-%Y') AS date, SUM(amount) AS sales FROM orders GROUP BY STR_TO_DATE(placed_on, '%m-%d-%Y') ORDER BY STR_TO_DATE(placed_on, '%m-%d-%Y') DESC";
    } elseif ($option == "weekly") {
        $query = "SELECT YEARWEEK(STR_TO_DATE(placed_on, '%m-%d-%Y')) AS date, SUM(amount) AS sales FROM orders GROUP BY YEARWEEK(STR_TO_DATE(placed_on, '%m-%d-%Y')) ORDER BY STR_TO_DATE(placed_on, '%m-%d-%Y') DESC";
    } elseif ($option == "monthly") {
        $query = "SELECT DATE_FORMAT(STR_TO_DATE(placed_on, '%m-%d-%Y'), '%Y-%m') AS date, SUM(amount) AS sales FROM orders GROUP BY DATE_FORMAT(STR_TO_DATE(placed_on, '%m-%d-%Y'), '%Y-%m') ORDER BY STR_TO_DATE(placed_on, '%m-%d-%Y') DESC";
    } elseif ($option == "yearly") {
        $query = "SELECT YEAR(STR_TO_DATE(placed_on, '%m-%d-%Y')) AS date, SUM(amount) AS sales FROM orders GROUP BY YEAR(STR_TO_DATE(placed_on, '%m-%d-%Y')) ORDER BY STR_TO_DATE(placed_on, '%m-%d-%Y') DESC";
    }

    if (isset($query)) {
        $inventory_log = $conn->prepare($query);
        $inventory_log->execute();
        $log = $inventory_log->fetchAll(PDO::FETCH_ASSOC);
        if (count($log) > 0){ 
            foreach ($log as $row) {?>
            <tr class="border-color">
                <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $row['date'] ?></td>
                <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">₱<?= $row['sales']?></td>
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
