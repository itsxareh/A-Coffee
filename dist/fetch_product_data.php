<?php
include "config.php";

// Fetch products and variations
$query = "SELECT orders.products FROM orders WHERE delete_flag = 0";
$result = $conn->query($query);
$data = [];

if ($result) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $products = explode(',', $row['products']);
        foreach ($products as $item) {
            preg_match('/(\d+)\s+([^()]+)(?:\(([^()]+)\))?(?:\((Hot|Cold)\))?/', trim($item), $matches);
            if (count($matches) > 1) {
                $quantity = (int)$matches[1];
                $name = trim($matches[2]);
                $variation = isset($matches[3]) ? '('.trim($matches[3]).')' : '';
                $temperature = isset($matches[4]) ? '('.trim($matches[4]).')' : '';
                
                $key = "$name$variation$temperature";
                if (!isset($data[$key])) {
                    $data[$key] = 0;
                }
                $data[$key] += $quantity;
            }
        }
    }
}

arsort($data);
$data = array_slice($data, 0, 10, true); 

// Prepare data for Chart.js
$labels = array_keys($data);
$counts = array_values($data);

echo json_encode([
    "labels" => $labels,
    "counts" => $counts,
]);
?>