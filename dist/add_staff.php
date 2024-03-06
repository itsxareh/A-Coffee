<?php
include 'config.php';

function generateUID() {
    $prefix = "CA";
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
        $insert_staff = $conn->prepare("INSERT INTO `users`(uid, name, pnumber, password, email, gender, birthdate, user_type, address, joined_at) VALUES (?,?,?,?,?,?,?,?,?,?)");
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
        $insert_staff->execute();

        $last_insert_id = $conn->lastInsertId();
        $select_new_staff = $conn->prepare("SELECT * FROM users WHERE uid = ?");
        $select_new_staff->bindParam(1, $last_insert_id);
        $select_new_staff->execute();
        if ($select_new_staff) {
            $staff = $select_new_staff->fetch(PDO::FETCH_ASSOC);
            if ($staff) {
                $select_staff = $conn->prepare("SELECT * FROM users WHERE uid = ?");
                $select_staff->bindParam(1, $last_insert_id);
                $select_staff->execute();
                $data['message'] = "New staff added.";
                $data['insert'] = true;
            } else {    
                $data['message'] = "Staff not found.";
                $data['insert'] = false;
            }
        }
    } else {
        $update_staff = $conn->prepare("UPDATE `users` SET name = :name, pnumber = :pnumber, password = :password, email = :email, gender = :gender, birthdate = :birthdate, user_type = :user_type, address = :address, joined_at = :current_time WHERE uid = :uid");
        $params = array(':name' => $name, ':pnumber' => $pnumber,':password' => password_hash($password, PASSWORD_DEFAULT), ':email' => $email, ':gender' => $gender, ':birthdate' => $birthdate, ':user_type' => $user_type, ':address' => $address, ':current_time' => $current_time, ':uid' => $uid);
        foreach ($params as $key => &$value) {
            $update_staff->bindParam($key, $value);
        }
        $update_staff->execute();
        $select_staff = $conn->prepare("SELECT * FROM users WHERE uid = ?");
        $select_staff->bindParam(1, $uid);
        $select_staff->execute();

        if ($insert_staff || $update_staff) {
            $staff = $select_staff->fetch(PDO::FETCH_ASSOC);
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
                        $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE uid = ?");
                        $update_image->bindParam(1, $image);
                        $update_image->bindParam(2, $uid);
                        $update_image->execute();

                        if (!empty($old_image) && file_exists('../uploaded_img/' . $old_image)) {
                            unlink('../uploaded_img/' . $old_image);
                        }
                        $message[] = 'Image updated successfully!';
                    } else {
                        $message[] = 'Failed to move uploaded image!';
                    }
                }
            } else {
                
            }
            if ($staff) {
                var_dump($staff['uid']);
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
