<?php 
include "config.php";
if (isset($_GET['date'])) {
    $date = $_GET['date'];

    $sql = 
    "SELECT 
    qpl.product_name,
    STR_TO_DATE(qpl.placed_on, '%m-%d-%Y') AS date,
    SUM(qpl.quantity) AS total_quantity,
    p.price
    FROM (
        SELECT 
            SUBSTRING_INDEX(item, ' ', 1) AS quantity,
            TRIM(SUBSTRING(item, LENGTH(SUBSTRING_INDEX(item, ' ', 1)) + 2)) AS product_name,
            placed_on
        FROM (
            SELECT
                TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(products, ',', numbers.n), ',', -1)) AS item,
                orders.placed_on
            FROM
                (SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) AS numbers
            JOIN orders ON CHAR_LENGTH(products) - CHAR_LENGTH(REPLACE(products, ',', '')) >= numbers.n - 1
        ) AS order_details
    ) AS qpl
    JOIN products AS p ON qpl.product_name = p.name
    WHERE DATE(STR_TO_DATE(qpl.placed_on, '%m-%d-%Y')) = ?
    GROUP BY qpl.product_name, STR_TO_DATE(qpl.placed_on, '%m-%d-%Y')
    ORDER BY date DESC";

    if ($sql) {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $date);
        $stmt->execute();
        $trends = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($trends) > 0){ 
            foreach ($trends as $trend) {?>
            <tr class="border-color">
                <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $trend['product_name'] ?></td>
                <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $trend['total_quantity'] ?></td>
                
                <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">₱<?= $trend['total_quantity'] * $trend['price'] ?></td>
            </tr>  
            <?php
            }
        } else {
            echo '<tr><td colspan="6" class="text-gray text-medium font-semibold p-3 py-4 text-center">No orders found.</td></tr>';
        }
    }
}
?>
