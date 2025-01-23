<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    date_default_timezone_set('Asia/Manila');
    $current_time = date('m-d-Y H:i:s');
    $name = trim($_POST['name']);
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $quantity = isset($_POST['quantity']) ? str_replace(" ", "", $_POST['quantity']) : '';
    $uid = $_SESSION['uid'];
    $id = $_POST['id'];
    $data = array();

    if (!isset($id) || $id === '') {
        $insert_item = $conn->prepare("INSERT INTO `inventory`(name, description, quantity, added_at) VALUES (?,?,?,?)");
        $insert_item->bindParam(1, $name);
        $insert_item->bindParam(2, $description);
        $insert_item->bindParam(3, $quantity);
        $insert_item->bindParam(4, $current_time);
        $insert_item->execute();

        $last_insert_id = $conn->lastInsertId();

        $select_new_item = $conn->prepare("SELECT * FROM inventory WHERE id = ?");
        $select_new_item->bindParam(1, $last_insert_id);
        $select_new_item->execute();

        if ($insert_item) {
            $item = $select_new_item->fetch(PDO::FETCH_ASSOC);
            if ($item) {
                $log = $_SESSION['name']. " added a new item: ". $name .".";
                $insert_log = $conn->prepare("INSERT INTO activity_log(uid, log, datetime) VALUES (?,?,?)");
                $insert_log->bindParam(1, $uid);
                $insert_log->bindParam(2, $log);
                $insert_log->bindParam(3, $currentDateTime);
                $insert_log->execute();
                
                $stmt = $conn->prepare("SELECT id, name, description, quantity FROM inventory WHERE id = ?");
                $stmt->bindParam(1, $item['id']);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $data['message'] = "Item added successfully";
                $data['insert'] = true;
            } else {
                $data['message'] = "Item in inventory not found.";
                $data['insert'] = false;
            }
        }
    } else {
        // Fetch current quantity in the database
        $select_item = $conn->prepare("SELECT quantity, name FROM `inventory` WHERE id = ?");
        $select_item->bindParam(1, $id);
        $select_item->execute();
        $select_quantity = $select_item->fetch(PDO::FETCH_ASSOC);
        $quantity_db = $select_quantity['quantity'];

        if ($quantity === '') {
            // Only update name and description, keep quantity unchanged
            $update_item = $conn->prepare("UPDATE `inventory` SET name = ?, description = ?, updated_at = ? WHERE id = ?");
            $update_item->bindParam(1, $name);
            $update_item->bindParam(2, $description);
            $update_item->bindParam(3, $currentDateTime);
            $update_item->bindParam(4, $id);
        } else {
            $db_value = 0;
            $db_unit = '';
            $quantity_value = 0;
            $quantity_unit = '';

            if (preg_match('/(\d*\.?\d+)\s*([a-zA-Z]+)/', $quantity_db, $matches)) {
                $db_value = (float)$matches[1];
                $db_unit = strtolower($matches[2]);
            } else {
                $db_value = (float)$quantity_db;
            }

            if (preg_match('/(\d*\.?\d+)\s*([a-zA-Z]+)/', $quantity, $match)) {
                $quantity_value = (float)$match[1];
                $quantity_unit = strtolower($match[2]);
            } else {
                $quantity_value = (float)$quantity;
            }

            if ($db_unit && $quantity_unit) {
                $standard_quantity = convertToBaseUnit($quantity_value, $quantity_unit, $db_unit);
            } else {
                $standard_quantity = $quantity_value;
            }

            $total_quantity = number_format((float)($standard_quantity + $db_value), 3, '.', '');
            if ($db_unit) {
                $total_quantity .= $db_unit;
            }

            $update_item = $conn->prepare("UPDATE `inventory` SET name = ?, description = ?, quantity = ?, quantity_before = ?, updated_at = ? WHERE id = ?");
            $update_item->bindParam(1, $name);
            $update_item->bindParam(2, $description);
            $update_item->bindParam(3, $total_quantity);
            $update_item->bindParam(4, $quantity_db);
            $update_item->bindParam(5, $current_time);
            $update_item->bindParam(6, $id);
        }

        $update_item->execute();

        if ($update_item) {
            $log = $_SESSION['name']. " updated ". $name ." information.";
            $insert_log = $conn->prepare("INSERT INTO activity_log(uid, log, datetime) VALUES (?,?,?)");
            $insert_log->bindParam(1, $uid);
            $insert_log->bindParam(2, $log);
            $insert_log->bindParam(3, $currentDateTime);
            $insert_log->execute();

            if ($quantity !== '') {
                $log = $_SESSION['name']. " updated ". $select_quantity['name'] . "'s quantity: ". $quantity . ".";
                $insert_log = $conn->prepare("INSERT INTO activity_log(uid, log, datetime) VALUES (?,?,?)");
                $insert_log->bindParam(1, $uid);
                $insert_log->bindParam(2, $log);
                $insert_log->bindParam(3, $currentDateTime);
                $insert_log->execute();
            }

            $select_new_item = $conn->prepare("SELECT * FROM inventory WHERE id = ?");
            $select_new_item->bindParam(1, $id);
            $select_new_item->execute();
            
            if ($update_item) {
                $item = $select_new_item->fetch(PDO::FETCH_ASSOC);
                if ($item) {
                    $stmt = $conn->prepare("SELECT id, name, description, quantity, quantity_before, updated_at, added_at FROM inventory WHERE id = ?");
                    $stmt->bindParam(1, $id);
                    $stmt->execute();
                    $data = $stmt->fetch(PDO::FETCH_ASSOC);
                    $data['quantity_changed'] = boolval(empty($quantity)); 
                    $data['message'] = "Updated item successfully";
                    $data['update'] = true;
                } else {
                    $data['message'] = "Item in inventory not found.";
                    $data['insert'] = false;
                }
            }
        }
    }

    echo json_encode($data);
}


function convertToBaseUnit($quantity, $unit, $unitDb) {
    $validUnits = ['l', 'ml', 'kg', 'g', 'cup', 'oz', 'tbsp'];

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