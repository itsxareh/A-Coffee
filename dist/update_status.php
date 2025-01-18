<?php 
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["orderId"]) && isset($_POST["status"]) && isset($_SESSION["uid"])) {
    date_default_timezone_set('Asia/Manila');
    $current_time = date('m-d-Y h:i:s');
    $uid = $_SESSION['uid'];
    $orderId = $_POST["orderId"];
    $status = $_POST["status"];

    $select_cart = $conn->prepare("SELECT * FROM `orders` WHERE id = ? AND uid = ? AND delete_flag = 0");
    $select_cart->execute([$orderId, $uid]);

    if ($select_cart->rowCount() > 0) {
        $cart_item = $select_cart->fetch(PDO::FETCH_ASSOC);
        $productsString = $cart_item['products'];
        $products = explode(", ", $productsString);

        if (empty($products)) {
            $response = array("success" => false, "message" => 'The order is empty');
        } else {
            $update_order = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ? AND delete_flag = 0");
            $check_inventory = $conn->prepare("SELECT quantity, name FROM `inventory`");

            $conn->beginTransaction();
            $should_process_order = true;

            foreach ($products as $product) { 
                $productParts = explode(" ", $product, 2);
                $productQuantity = $productParts[0];
                if (preg_match('/(.+?)\s*\((.*?)\)\s*\((.*?)\)$/', $productParts[1], $matches)) {
                    $productName = trim($matches[1]);       // Product name
                    $productVar = trim($matches[2]);        // Product variation (e.g., 12oz)
                    $productTemp = trim($matches[3]);       // Product temperature (e.g., Hot/Ice)
                } elseif (preg_match('/(.+?)\s*\((.*?)\)$/', $productParts[1], $matches)) {
                    $productName = trim($matches[1]);       // Product name
                    $productVar = trim($matches[2]);        // Product variation (e.g., 16oz)
                    $productTemp = "";                      // No temperature provided
                } else {
                    $productName = trim($productParts[1]);  // Product name only
                    $productVar = "Regular";                // Default variation
                    $productTemp = "";                      // Default temperature
                }
                $select_ingredients = $conn->prepare("SELECT product_variations.ingredients FROM product_variations LEFT JOIN products ON product_variations.product_id = products.id WHERE product_variations.size = ? AND name = ?");
                $select_ingredients->execute([$productVar, $productName]);
                $ingredientRow = $select_ingredients->fetch(PDO::FETCH_ASSOC);
                $ingredientsString = $ingredientRow['ingredients'];
                $ingredients = explode(", ", $ingredientsString);
                $parsed_ingredients = [];

                foreach ($ingredients as $ingredient) { 
                    $matches = [];
                    $pattern = '/(?:(\d*\.?\d+)\s*([a-z]*)\s+)?(.+)/i';
                    preg_match($pattern, trim($ingredient), $matches);
                    $quantity = !empty($matches[1]) ? (float)$matches[1] : $productQuantity;
                    $unit = !empty($matches[2]) ? $matches[2] : '';
                    $itemName = $matches[3]; 
                    $inventory_query = $conn->prepare("SELECT quantity FROM `inventory` WHERE name = ?");
                    $inventory_query->execute([$itemName]);
                    $current_quantity = $inventory_query->fetchColumn();
                    preg_match('/(\d*\.?\d+)\s*([a-zA-Z]+)/', $current_quantity, $matches);
                    $db_value = (float)$matches[1];
                    $db_unit = strtolower($matches[2]);
                    $standard_quantity = convertToBaseUnit($quantity, $unit, $db_unit);
                    $total_quantity = number_format(floatval($db_value) - (floatval($standard_quantity)), 3, '.', '').''.$db_unit;
                    if ($db_value === false) {
                        $should_process_order = false;
                        $response = array("success" => false, "message" => "Failed to retrieve quantity for " . ucwords($itemName));
                        break 2;
                    } elseif ($db_value < $standard_quantity) {
                        $should_process_order = false;
                        $response = array("success" => false, "message" => "Insufficient quantity for " . ucwords($itemName));
                        break 2;
                    } else { 
                        $update_inventory = $conn->prepare("UPDATE `inventory` SET quantity = ? WHERE name = ?");
                        $update_inventory->execute([$total_quantity, $itemName]);
                    }
                }
            }

            if ($should_process_order) { 
                $update_order->execute([$status, $orderId]);
                $check_inventory->execute();
                $item_inventory = '';
                if ($check_inventory->rowCount() > 0) {
                    while ($item = $check_inventory->fetch(PDO::FETCH_ASSOC)) {
                        $quantity = $item['quantity'];
                        $matches = [];
                        if (preg_match('/(\d*\.?\d+)\s*([a-zA-Z]+)/', $quantity, $matches)) {
                            $db_value = (float)$matches[1];
                            $db_unit = strtolower($matches[2]);
                        } else {
                            $db_value = (float)$quantity;
                            $db_unit = 'piece/s';
                        }
                        if (($db_value <= 0.25 && $db_unit == "l") || ($db_value <= 0.25 && $db_unit == "kg")){
                            $item_inventory .= $item['name'].' - '.$db_value.' '.strtoupper($db_unit).' left';
                            $item_inventory .= ', ';
                        }
                    }
                    $item_inventory = rtrim($item_inventory, ', ');
                }
                $conn->commit();
                $response = array("success" => true, "message" => "Order {$orderId} marked as done", "notification" => $item_inventory ? $item_inventory : '');
            }
        }
    } else {
        $response = array("success" => false, "message" => "No order found");
    }
} else {
    $response = array("success" => false, "message" => "Invalid request");
}

header("Content-Type: application/json");
echo json_encode($response);

function convertToBaseUnit($quantity, $unit, $unitDb) {

    if ($unitDb == $unit) {
        return $quantity * 1; 
    } else if ($unitDb == "l" && $unit == 'ml' || $unitDb == "kg" && $unit == "g") {
        return $quantity / 1000;
    } else if ($unitDb == "kg" && $unit == "cup"){
        return $quantity * 0.236;
    } else if ($unitDb == "oz" && $unit == "tbsp"){
        return $quantity * 0.5216;
    }
    return $quantity;
}
?>
