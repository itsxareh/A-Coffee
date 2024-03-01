<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    date_default_timezone_set('Asia/Manila');
    $current_time = date('m-d-Y');
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $quantity = intval(trim($_POST['quantity']));
    $uid = $_POST['uid'];
    $id = $_POST['id'];
    $insert_item = null;
    $update_item = null;

    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;
    $old_image = $_POST['old_image'];
    
    if (!isset($id) || $id === '') {
        $insert_item = $conn->prepare("INSERT INTO `inventory`(name, description, quantity, added_at) VALUES (?,?,?,?)");
        $insert_item->execute([$name, $description, $quantity, $current_time]);

        // Fetch the last inserted row ID
        $last_insert_id = $conn->lastInsertId();

        // Use the last inserted row ID to fetch the new item details
        $select_new_item = $conn->prepare("SELECT * FROM inventory WHERE id = ?");
        $select_new_item->execute([$last_insert_id]);
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

        // Use the existing item ID to fetch the updated item details
        $select_new_item = $conn->prepare("SELECT * FROM inventory WHERE id = ?");
        $select_new_item->execute([$id]);
    }

    if ($insert_item || $update_item) {
        $item = $select_new_item->fetch(PDO::FETCH_ASSOC);

        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../uploaded_img/' . $image;
        $old_image = $_POST['old_image'];
        if (!empty($image)) {
            if ($image_size > 10000000) {
                $message[] = 'Image size is too large!';
            } else {
                if (move_uploaded_file($image_tmp_name, $image_folder)) {
                    $update_image = $conn->prepare("UPDATE `inventory` SET image = ? WHERE id = ?");
                    $update_image->execute([$image, $item['id']]);
  
                    if (!empty($old_image) && file_exists('../uploaded_img/' . $old_image)) {
                        unlink('../uploaded_img/' . $old_image);
                    }
                    $message[] = 'Image updated successfully!';
                } else {
                    $message[] = 'Failed to move uploaded image!';
                }
            }
        }
        if ($item) {
            echo '<tr class="border-color" data-id="'.$item['id'].'">
                    <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                        <img class="w-16 h-16 object-cover" src="../uploaded_img/'.$item['image'].'">
                    </td>
                    <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">'.ucwords($item['name']).'</td>
                    <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">'.$item['description'].'</td>
                    <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">'.($item['quantity'] ? $item['quantity'] : "0") .'</td>
                    <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-4">
                            <button id="editModalBtn" class="w-6 h-6" onclick="showEditModal('.$item['id'].')"><img src="../images/edit-svgrepo-com.svg" alt=""></button>
                            <button id="deleteModalBtn" class="w-6 h-6" onclick="showDeleteModal('.$item['id'].')"><img src="../images/delete-svgrepo-com.svg" alt=""></button>
                        </div>
                    </td>
                </tr>';
        } else {
            echo '<tr><td colspan="6" class="text-gray text-medium font-semibold p-3 py-4 text-center">No item data found.</td></tr>';
        } 
    } else {
        echo "Error executing SQL query.";
    }
}
?>
