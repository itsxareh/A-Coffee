<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    date_default_timezone_set('Asia/Manila');
    $current_time = date('m-d-Y h:i:s');
    $name = trim($_POST['name']);
    $uid = $_POST['uid'];
    $id = $_POST['id'];
    $data = array();
    
    if (!isset($id) || $id === '') {
        $insert_item = $conn->prepare("INSERT INTO category (category_name) VALUES (?)");
        $insert_item->bindParam(1, $name);
        $insert_item->execute();

        $last_insert_id = $conn->lastInsertId();

        $select_new_item = $conn->prepare("SELECT * FROM category WHERE id = ?");
        $select_new_item->bindParam(1, $last_insert_id);
        $select_new_item->execute();

        if ($insert_item) {
            $item = $select_new_item->fetch(PDO::FETCH_ASSOC);
            if ($item) {
                $log = "You added new category: ". $item['category_name'];
                $conn->prepare("INSERT INTO `activity_log`(uid, log, datetime) VALUES (?,?,?)")->execute([$uid, $log, $current_time]);
                $stmt = $conn->prepare("SELECT id, category_name FROM category WHERE id = ?");
                $stmt->bindParam(1, $item['id']);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $data['message'] = "New category added.";
                $data['insert'] = true;
            } else {
                $data['message'] = "Category not found.";
                $data['insert'] = false;
            }
        }
    } else {
        $update_item = $conn->prepare("UPDATE `category` SET category_name = ? WHERE id = ?");
        $update_item->bindParam(1, $name);
        $update_item->bindParam(2, $id);
        $update_item->execute();

        if ($update_item){
            $log = "You updated category: ". $name;
            $insert_item = $conn->prepare("INSERT INTO `activity_log`(uid, log, datetime) VALUES (?,?,?)");
            $insert_item->bindParam(1, $uid);
            $insert_item->bindParam(2, $id);
            $insert_item->bindParam(3, $current_time);
            $insert_item->execute();
        }
        $select_new_item = $conn->prepare("SELECT * FROM category WHERE id = ?");
        $select_new_item->bindParam(1, $id);
        $select_new_item->execute();
        
        if ($insert_item || $update_item) {
            $item = $select_new_item->fetch(PDO::FETCH_ASSOC);
            if ($item) {
                $stmt = $conn->prepare("SELECT id, category_name FROM category WHERE id = ?");
                $stmt->bindParam(1, $id);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $data['message'] = $update_item ? "Updated category." : "New category added.";
                $data[$update_item ? 'update' : 'insert'] = true;
            } else {
                $data['message'] = "Category not found.";
                $data['insert'] = false;
            }
        } else {
            $data['error'] = 'ID parameter is missing';
        }
    }
    echo json_encode($data);
}
?>