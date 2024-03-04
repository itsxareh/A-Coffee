<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    date_default_timezone_set('Asia/Manila');
    $current_time = date('m-d-Y h:i:s');
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $quantity = trim($_POST['quantity']);
    $uid = $_POST['uid'];
    $id = $_POST['id'];
    $data = array();
    
    if (!isset($id) || $id === '') {
        $insert_item = $conn->prepare("INSERT INTO `inventory`(name, description, quantity, added_at) VALUES (?,?,?,?)");
        $insert_item->execute([$name, $description, $quantity, $current_time]);

        $last_insert_id = $conn->lastInsertId();

        $select_new_item = $conn->prepare("SELECT * FROM inventory WHERE id = ?");
        $select_new_item->execute([$last_insert_id]);

        if ($insert_item) {
            $item = $select_new_item->fetch(PDO::FETCH_ASSOC);
            if ($item) {
                $conn->prepare("INSERT INTO `inventory-log`(uid, item_id, quantity, date) VALUES (?,?,?,?)")->execute([$uid, $item['id'], $quantity, $current_time]);
                $stmt = $conn->prepare("SELECT id, name, description, quantity FROM inventory WHERE id = ?");
                $stmt->execute([$item['id']]);
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $data['message'] = "Item added successfully";
                $data['insert'] = true;
            } else {
                $data['message'] = "Item in inventory not found.";
                $data['insert'] = false;
            }
        }
    } else {
        $select_item = $conn->prepare("SELECT quantity FROM `inventory` WHERE id = ?");
        $select_item->execute([$id]);
        $select_quantity = $select_item->fetch(PDO::FETCH_ASSOC);
        $quantity_db = $select_quantity['quantity'];

        preg_match('/(\d*\.?\d+)\s*([a-zA-Z]+)/', $quantity_db, $matches);
        $db_value = (float)$matches[1];
        $db_unit = strtolower($matches[2]);
        preg_match('/(\d*\.?\d+)\s*([a-zA-Z]+)/', $quantity, $match);
        $quantity_value = (float)$match[1];
        $quantity_unit = strtolower($match[2]);
        $standard_quantity = convertToBaseUnit($quantity_value, $quantity_unit, $db_unit);


        $total_quantity = number_format((floatval($standard_quantity) + floatval($db_value)), 3, '.', '').''.$db_unit;
        $update_item = $conn->prepare("UPDATE `inventory` SET name = ?, description = ?, quantity = ? WHERE id = ?");
        $update_item->execute([$name, $description, $total_quantity, $id]);

        if ($update_item){
            $insert_item = $conn->prepare("INSERT INTO `inventory-log`(uid, item_id, quantity, date) VALUES (?,?,?,?)");
            $insert_item->execute([$uid, $id, $total_quantity, $current_time]);
        }
        $select_new_item = $conn->prepare("SELECT * FROM inventory WHERE id = ?");
        $select_new_item->execute([$id]);
        
        if ($insert_item || $update_item) {
            $item = $select_new_item->fetch(PDO::FETCH_ASSOC);
            if ($item) {
                $stmt = $conn->prepare("SELECT id, name, description, quantity FROM inventory WHERE id = ?");
                $stmt->execute([$item['id']]);
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $data['message'] = $update_item ? "Updated item successfully" : "Item added successfully";
                $data[$update_item ? 'update' : 'insert'] = true;
            } else {
                $data['message'] = "Item in inventory not found.";
                $data['insert'] = false;
            }
        } else {
            $data['error'] = 'ID parameter is missing';
        }
    }
    echo json_encode($data);
}

function convertToBaseUnit($quantity, $unit, $unitDb) {

    if ($unitDb == "l" && $unit == 'l' || $unitDb == "kg" && $unit == 'kg') {
        return $quantity * 1; 
    } else if ($unitDb == "l" && $unit == 'ml' || $unitDb == "kg" && $unit == "g") {
        return $quantity / 1000;
    }
    return $quantity;
}
?>