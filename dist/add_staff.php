<?php
include 'config.php';

function generateUID() {
    $prefix = "AC";
    $randomNumbers = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
    $uid = $prefix . $randomNumbers;
    return $uid;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    date_default_timezone_set('Asia/Manila');
    $current_time = date('m-d-Y');
    $name = trim($_POST['name']);
    $pnumber = trim($_POST['pnumber']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $user_type = $_POST['usertype'];
    $address = $_POST['address'];
    $uid = $_POST['uid'];
    $isUnique = false;

    $insert_staff = null;
    $update_staff = null;

    $uniq_image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $unique_id = rand(00000, 99999);
        $image = $_FILES['image']['name'];
        $uniq_image = $unique_id . "-" . $image;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../uploaded_img/' . $uniq_image;

        if ($image_size > 10000000) {
            $data['message'] = 'Image size is too large!';
            echo json_encode($data);
            exit;
        }
    }

    if (!isset($uid) || $uid === '') {
        while (!$isUnique) {
            $uid = generateUID();
            $check_uid_query = $conn->prepare("SELECT COUNT(*) FROM users WHERE uid = ?");
            $check_uid_query->execute([$uid]);
            $count = $check_uid_query->fetchColumn();
            if ($count == 0) {
                $isUnique = true;
            }
        }
        
        // Handle new staff insertion with image
        $insert_staff = $conn->prepare("INSERT INTO `users`(uid, name, pnumber, password, email, gender, birthdate, user_type, address, joined_at, image) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $insert_staff->bindParam(1, $uid);
        $insert_staff->bindParam(2, $name);
        $insert_staff->bindParam(3, $pnumber);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $insert_staff->bindParam(4, $password);
        $insert_staff->bindParam(5, $email);
        $insert_staff->bindParam(6, $gender);
        $insert_staff->bindParam(7, $birthdate);
        $insert_staff->bindParam(8, $user_type);
        $insert_staff->bindParam(9, $address);
        $insert_staff->bindParam(10, $current_time);
        $insert_staff->bindParam(11, $uniq_image);
        $insert_staff->execute();

        // Move uploaded image if exists
        if ($uniq_image && $image_tmp_name) {
            if (!move_uploaded_file($image_tmp_name, $image_folder)) {
                $data['message'] = 'Failed to move uploaded image!';
                echo json_encode($data);
                exit;
            }
        }

        $last_insert_id = $conn->lastInsertId();
        $select_new_staff = $conn->prepare("SELECT * FROM users WHERE uid = ?");
        $select_new_staff->bindParam(1, $uid);
        $select_new_staff->execute();
        
        if ($select_new_staff) {
            $staff = $select_new_staff->fetch(PDO::FETCH_ASSOC);
            if ($staff) {
                $select_staff = $conn->prepare("SELECT * FROM users WHERE uid = ?");
                $select_staff->bindParam(1, $uid);
                $select_staff->execute();

                $log = $_SESSION['name']. " added a new staff: ". $name;
                $insertLog = $conn->prepare("INSERT INTO activity_log (uid, log, datetime) VALUES (?, ?, ?)");
                $insertLog->bindParam(1, $uid);
                $insertLog->bindParam(2, $log);
                $insertLog->bindParam(3, $currentDateTime);
                $insertLog->execute();

                $data['message'] = "New staff added.";
                $data['insert'] = true;
            } else {    
                $data['message'] = "Staff not found.";
                $data['insert'] = false;
            }
        }
    } else {
        // Update existing staff
        $update_staff = $conn->prepare("UPDATE `users` SET name = :name, pnumber = :pnumber, email = :email, gender = :gender, birthdate = :birthdate, user_type = :user_type, address = :address, joined_at = :current_time WHERE uid = :uid");
        $params = array(':name' => $name, ':pnumber' => $pnumber, ':email' => $email, ':gender' => $gender, ':birthdate' => $birthdate, ':user_type' => $user_type, ':address' => $address, ':current_time' => $current_time, ':uid' => $uid);
        foreach ($params as $key => &$value) {
            $update_staff->bindParam($key, $value);
        }
        $update_staff->execute();

        if (!empty($password)){
            $password = password_hash($password, PASSWORD_DEFAULT);
            $update_password = $conn->prepare("UPDATE `users` SET password = :password WHERE uid = :uid");
            $update_password->bindParam(':password', $password);
            $update_password->bindParam(':uid', $uid);
            $update_password->execute();
        }

        // Handle image update
        if ($uniq_image) {
            $old_image = $_POST['old_image'] ?? '';
            
            if (move_uploaded_file($image_tmp_name, $image_folder)) {
                $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE uid = ?");
                $update_image->bindParam(1, $uniq_image);
                $update_image->bindParam(2, $uid);
                $update_image->execute();

                if (!empty($old_image) && file_exists('../uploaded_img/' . $old_image)) {
                    unlink('../uploaded_img/' . $old_image);
                }
                $data['message'] = 'Staff and image updated successfully!';
            } else {
                $data['message'] = 'Failed to move uploaded image!';
                echo json_encode($data);
                exit;
            }
        }

        $log = $_SESSION['name']. " updated staff information: ". $name;
        $insertLog = $conn->prepare("INSERT INTO activity_log (uid, log, datetime) VALUES (?, ?, ?)");
        $insertLog->bindParam(1, $_SESSION['uid']);
        $insertLog->bindParam(2, $log);
        $insertLog->bindParam(3, $currentDateTime);
        $insertLog->execute();

        $select_staff = $conn->prepare("SELECT * FROM users WHERE uid = ?");
        $select_staff->bindParam(1, $uid);
        $select_staff->execute();

        if ($insert_staff || $update_staff) {
            $staff = $select_staff->fetch(PDO::FETCH_ASSOC);
            if ($staff) {
                $select_staff = $conn->prepare("SELECT u.id, u.image, u.name, u.uid, SUM(o.amount) AS total, COUNT(o.uid) AS quantity FROM users u LEFT JOIN orders o ON u.uid = o.uid WHERE u.uid = ?");
                $select_staff->bindParam(1, $staff['uid']);
                $select_staff->execute();
                $data = $select_staff->fetch(PDO::FETCH_ASSOC);
                if ($data['total'] === NULL) {
                    $data['total'] = 0;
                }
                $data['message'] = $update_staff ? "Updated staff successfully" : "New staff added.";
                $data[$update_staff ? 'update' : 'insert'] = true;
            } else {
                $data['message'] = "Staff not found.";
                $data['insert'] = false;
            }
        } else {
            $data['error'] = 'UID parameter is missing';
        }
    }
    echo json_encode($data);
}
?>