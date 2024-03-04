<?php 
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    date_default_timezone_set('Asia/Manila');
    $current_time = date('m-d-Y h:i:s');
    $uid = $_POST['uid'];
    $status = '2';
    $cart_total = 0;
    $cart_products = [];

    $select_cart = $conn->prepare("SELECT c.*, p.ingredients, p.name AS product_name FROM `cart` c LEFT JOIN  products p ON p.id = c.product_id WHERE uid = ?");
    $select_cart->execute([$uid]);

    if ($select_cart->rowCount() > 0) {
        while ($cart_item = $select_cart->fetch(PDO::FETCH_ASSOC)) {
            $cart_products[] = $cart_item;
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    if ($cart_total == 0) {
        $response['message'] = 'Your cart is empty';
    } else {
        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE uid = ?");
        $insert_order = $conn->prepare("INSERT INTO `orders`(uid, products, amount, status, placed_on) VALUES(?,?,?,?,?)");

        $conn->beginTransaction();
        $should_process_order = true;

        foreach ($cart_products as $cart_item) {
            $product_id = $cart_item['product_id'];
            $product_quantity = $cart_item['quantity'];
            $ingredients = $cart_item['ingredients'];
            $ingredients_array = explode(',', $ingredients);
            $parsed_ingredients = [];
        
            foreach ($ingredients_array as $ingredient) {
                if (strpos(trim($ingredient), ' ') === false) {
                    $quantity = $product_quantity;
                    $itemName = trim($ingredient);
                    $unit = '';
                } else {
                    $pattern = '/(?:(\d*\.?\d+)\s*([a-z]*)\s+)?(.+)/i';
                    preg_match($pattern, trim($ingredient), $matches);
        
                    $quantity = !empty($matches[1]) ? (float)$matches[1] : $product_quantity;
                    $unit = !empty($matches[2]) ? $matches[2] : '';
                    $itemName = $matches[3];
                }
        
                $parsed_ingredients[] = [
                    'itemName' => $itemName,
                    'quantity' => $quantity,
                    'unit' => $unit,
                ];
            }
            foreach ($parsed_ingredients as $ingredient) {
                $ingredient_quantity = $ingredient['quantity'];
                $itemName = $ingredient['itemName'];
                $unit = $ingredient['unit'];
                $inventory_query = $conn->prepare("SELECT quantity FROM `inventory` WHERE name = ?");
                $inventory_query->execute([$itemName]);
                $current_quantity = $inventory_query->fetchColumn();
                preg_match('/(\d*\.?\d+)\s*([a-zA-Z]+)/', $current_quantity, $matches);
                $db_value = (float)$matches[1];
                $db_unit = strtolower($matches[2]);
                $standard_quantity = convertToBaseUnit($ingredient_quantity, $unit, $db_unit);
                $total_quantity = number_format((floatval($db_value) - floatval($standard_quantity)), 3, '.', '').''.$db_unit;
                if ($db_value === false) {
                    $response['message'] = "Failed to retrieve quantity for ".ucwords($itemName);
                    $should_process_order = false;
                } elseif ($db_value < $standard_quantity) {
                    $response['message'] = "Insufficient quantity for ".ucwords($itemName);
                    $should_process_order = false;
                }
            }
        }
        if ($should_process_order) {
         $products_string = '';
         foreach ($cart_products as $index => $product) {
             $product_info = $product['quantity'].' '.$product['product_name'].'';
             $products_string .= $product_info;
             if ($index < count($cart_products) - 1) {
                 $products_string .= ', ';
             }
         }
         $insert_order = $conn->prepare("INSERT INTO `orders`(uid, products, amount, status, placed_on) VALUES(?,?,?,?,?)");
         $insert_order->execute([$uid, $products_string, $cart_total, $status, $current_time]);
         $delete_cart->execute([$uid]);
         $conn->commit();
         
         $response['message'] = "Product Ordered successfully";
         $response['success'] = true;
         $response['msg'] = $parsed_ingredients;
     }
    }
}
echo json_encode($response);

function convertToBaseUnit($quantity, $unit, $unitDb) {

    if ($unitDb == $unit) {
        return $quantity * 1; 
    } else if ($unitDb == "l" && $unit == 'ml' || $unitDb == "kg" && $unit == "g") {
        return $quantity / 1000;
    }
    return $quantity;
}
?>