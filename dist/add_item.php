<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    date_default_timezone_set('Asia/Manila');
    $current_time = date('m-d-Y h:i:s');
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $quantity = intval(trim($_POST['quantity']));
    $uid = $_POST['uid'];
    $id = $_POST['id'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;
    $old_image = $_POST['old_image'];
    
    $data = array();
    
    if (!isset($id) || $id === '') {
        $insert_item = $conn->prepare("INSERT INTO `inventory`(name, description, quantity, added_at) VALUES (?,?,?,?)");
        $insert_item->execute([$name, $description, $quantity, $current_time]);

        $last_insert_id = $conn->lastInsertId();

        $select_new_item = $conn->prepare("SELECT * FROM inventory WHERE id = ?");
        $select_new_item->execute([$last_insert_id]);

        if ($insert_item) {
            $item = $select_new_item->fetch(PDO::FETCH_ASSOC);
            if (!empty($image)) {
                if ($image_size > 10000000) {
                    $data['message'] = 'Image size is too large!';
                } else {
                    if (move_uploaded_file($image_tmp_name, $image_folder)) {
                        $conn->prepare("UPDATE `inventory` SET image = ? WHERE id = ?")->execute([$image, $item['id']]);
                        if (!empty($old_image) && file_exists('../uploaded_img/' . $old_image)) {
                            unlink('../uploaded_img/' . $old_image);
                        }
                        $data['message'] = 'Image updated successfully!';
                    } else {
                        $data['message'] = 'Failed to move uploaded image!';
                    }
                }
            }
            if ($item) {
                $conn->prepare("INSERT INTO `inventory-log`(uid, item_id, quantity, date) VALUES (?,?,?,?)")->execute([$uid, $item['id'], $quantity, $current_time]);
                $stmt = $conn->prepare("SELECT id, image, name, description, quantity FROM inventory WHERE id = ?");
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
        $total_quantity = $quantity + $select_quantity['quantity'];

        $update_item = $conn->prepare("UPDATE `inventory` SET name = ?, description = ?, quantity = ? WHERE id = ?");
        $update_item->execute([$name, $description, $total_quantity, $id]);

        if ($update_item){
            $insert_item = $conn->prepare("INSERT INTO `inventory-log`(uid, item_id, quantity, date) VALUES (?,?,?,?)");
            $insert_item->execute([$uid, $id, $quantity, $current_time]);
        }

        $select_new_item = $conn->prepare("SELECT * FROM inventory WHERE id = ?");
        $select_new_item->execute([$id]);
        
        if ($insert_item || $update_item) {
            $item = $select_new_item->fetch(PDO::FETCH_ASSOC);
            if (!empty($image)) {
                if ($image_size > 10000000) {
                    $data['message'] = 'Image size is too large!';
                } else {
                    if (move_uploaded_file($image_tmp_name, $image_folder)) {
                        $conn->prepare("UPDATE `inventory` SET image = ? WHERE id = ?")->execute([$image, $item['id']]);
                        if (!empty($old_image) && file_exists('../uploaded_img/' . $old_image)) {
                            unlink('../uploaded_img/' . $old_image);
                        }
                        $data['message'] = 'Image updated successfully!';
                    } else {
                        $data['message'] = 'Failed to move uploaded image!';
                    }
                }
            }
            if ($item) {
                $stmt = $conn->prepare("SELECT id, image, name, description, quantity FROM inventory WHERE id = ?");
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
?>
