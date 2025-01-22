<?php 
include 'config.php';

class QuantityParser {
    private static function standardizeUnit($unit) {
        $unit = strtolower(trim($unit));
        
        $unitMap = [
            'l' => 'l',
            'liter' => 'l',
            'litre' => 'l',
            'kg' => 'kg',
            'kilogram' => 'kg',
            '' => 'units'
        ];
        
        return isset($unitMap[$unit]) ? $unitMap[$unit] : $unit;
    }
    
    public static function parseQuantity($quantityStr) {
        $quantityStr = trim($quantityStr);
        
        if (preg_match('/^(\d+\.?\d*)([a-zA-Z]*)$/', $quantityStr, $matches)) {
            $value = (float)$matches[1];
            $unit = self::standardizeUnit($matches[2]);
            
            return [
                'value' => $value,
                'unit' => $unit,
                'original' => $quantityStr
            ];
        }
        
        return null;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    date_default_timezone_set('Asia/Manila');
    $current_time = date('m-d-Y H:i:s');
    $uid = $_SESSION['uid'];
    $amount = (float)$_POST['amount'];
    $cart_total = 0;
    $cart_products = [];

    $select_price = $conn->prepare("SELECT *, SUM(price * quantity) as total FROM cart WHERE uid = ?");
    $select_price->bindParam(1, $uid);
    $select_price->execute();
    $cart_amount = $select_price->fetch(PDO::FETCH_ASSOC);
    $cart_total_amount = (float)$cart_amount['total'];

    if ($amount < $cart_total_amount) {
        echo json_encode([
            'success' => false,
            'message' => "Invalid amount: entered amount (₱{$amount}) is less than the total cart amount (₱{$cart_total}).",
        ]);
        exit;
    }
    
    $select_cart = $conn->prepare("SELECT c.*, pv.size as variation, pv.ingredients, p.name AS product_name FROM `cart` c LEFT JOIN product_variations pv ON pv.id = c.variation_id LEFT JOIN products p ON p.id = c.product_id WHERE uid = ?");
    $select_cart->bindParam(1, $uid);
    $select_cart->execute();

    if ($select_cart->rowCount() > 0) {
        while ($cart_item = $select_cart->fetch(PDO::FETCH_ASSOC)) {
            $cart_products[] = $cart_item;
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE uid = ?");
        $check_inventory = $conn->prepare("SELECT id, quantity, name FROM `inventory` WHERE delete_flag = 0");
        $insert_order = $conn->prepare("INSERT INTO `orders`(uid, products, amount, cash, placed_on) VALUES(?,?,?,?,?)");
        $insert_log = $conn->prepare("INSERT INTO `activity_log`(uid, log, datetime) VALUES (?,?,?)");
        
        $conn->beginTransaction();
        $should_process_order = true;

        foreach ($cart_products as $cart_item) {
            $product_id = $cart_item['product_id'];
            $product_quantity = $cart_item['quantity'];
            $ingredients = $cart_item['ingredients'];
            if (empty($ingredients)){
                $should_process_order = true;
                break;
            }
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
                $inventory_query = $conn->prepare("SELECT quantity FROM `inventory` WHERE name = ? AND delete_flag = 0");
                $inventory_query->bindParam(1, $itemName);
                $inventory_query->execute();

                if ($inventory_query->rowCount() === 0) {
                    $response['message'] = "Failed to retrieve quantity for " . ucwords($itemName);
                    $should_process_order = false;
                } else {
                    $current_quantity = $inventory_query->fetchColumn();
                    preg_match('/(\d*\.?\d+)\s*([a-zA-Z]+)/', $current_quantity, $matches);
                    $db_value = (float)$matches[1];
                    $db_unit = strtolower($matches[2]);
                    $standard_quantity = convertToBaseUnit($ingredient_quantity, $unit, $db_unit);
                    $total_quantity = number_format((floatval($db_value) - floatval($standard_quantity)), 3, '.', '') . '' . $db_unit;
                    if ($db_value === false || $db_value === 0) {
                        $response['message'] = "Failed to retrieve quantity for " . ucwords($itemName);
                        $should_process_order = false;
                    } elseif ($db_value < $standard_quantity) {
                        $response['message'] = "Insufficient quantity for " . ucwords($itemName);
                        $should_process_order = false;
                    } else { 
                        $update_inventory = $conn->prepare("UPDATE `inventory` SET quantity = ? WHERE name = ?");
                        $update_inventory->execute([$total_quantity, $itemName]);
                    }
                }
            }
        }
        if ($should_process_order) {
            $products_string = '';
            foreach ($cart_products as $index => $product) {    
                $productName = !empty($product['product_name']) ? $product['product_name']  : $product['name'];
                $productVar = !empty($product['variation']) ? '('.$product['variation'].')' : '';
                $productTemp = !empty($product['temperature']) ? ' ('.$product['temperature'].')' : '';
                $product_info = $product['quantity'] . ' ' . $productName . ' ' . $productVar . '' . $productTemp;
                $products_string .= $product_info;
                if ($index < count($cart_products) - 1) {
                    $products_string .= ', ';
                }
            }
            try {
                $insert_order->bindParam(1, $uid);
                $insert_order->bindParam(2, $products_string);
                $insert_order->bindParam(3, $cart_total);
                $insert_order->bindParam(4, $amount);
                $insert_order->bindParam(5, $current_time);
                $insert_order->execute();

                $order_id = $conn->lastInsertId();

                $log = $_SESSION['name'] . " order placed($order_id): " . $products_string;
                $insert_log->bindParam(1, $uid);
                $insert_log->bindParam(2, $log);
                $insert_log->bindParam(3, $currentDateTime);
                $insert_log->execute();

                $delete_cart->bindParam(1, $uid);
                $delete_cart->execute();


                $THRESHOLDS = [
                    'l' => 5.0,    // 10 liters
                    'kg' => 10.0,   // 15 kilograms
                    'units' => 20   // 20 pieces
                ];

                $check_inventory->execute();
                $lowStockItems = [];
                
                while ($row = $check_inventory->fetch(PDO::FETCH_ASSOC)) {
                    $parsedQuantity = QuantityParser::parseQuantity($row['quantity']);
                    
                    if ($parsedQuantity) {
                        $threshold = isset($THRESHOLDS[$parsedQuantity['unit']]) 
                            ? $THRESHOLDS[$parsedQuantity['unit']] 
                            : 10.0; // Default threshold
                        
                        if ($parsedQuantity['value'] <= $threshold) {
                            $lowStockItems[] = [
                                'product_id' => $row['id'],
                                'product_name' => $row['name'],
                                'current_quantity' => $parsedQuantity['original'],
                                'threshold' => $threshold . $parsedQuantity['unit']
                            ];
                        }
                    }
                }
                
                $response = [
                    'status' => 'ok',
                    'notification' => '',
                ];

                if (count($lowStockItems) > 0) {
                    $response['status'] = 'low';
                    $response['notification'] = 'Low stock alert: ' . count($lowStockItems) . ' items need attention!';
                    $response['items'] = $lowStockItems;
                }
                $conn->commit();
        
                $response['success'] = true;
                $response['message'] = "Product Ordered successfully";
                $response['msg'] = $parsed_ingredients;
            } catch (PDOException $e) {
                $conn->rollBack();
                $response['success'] = false;
                $response['message'] = "Error processing order: ".$e->getMessage();
                error_log($e->getMessage());
            }
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Your cart is empty!';
    }
        
}
echo json_encode($response);

function convertToBaseUnit($quantity, $unit, $unitDb)
{
    if ($unitDb == $unit) {
        return $quantity * 1;
    } elseif ($unitDb == "l" && $unit == 'ml' || $unitDb == "kg" && $unit == "g") {
        return $quantity / 1000;
    } elseif ($unitDb == "kg" && $unit == "cup") {
        return $quantity * 0.236;
    } elseif ($unitDb == "oz" && $unit == "tbsp") {
        return $quantity * 0.5216;
    }
    return $quantity;
}

?>