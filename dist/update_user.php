<?php 
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = array();
    
    if (!isset($_POST['uid'])) {
        $data['message'] = 'UID parameter is missing';
        $data['update'] = false;
        echo json_encode($data);
        exit;
    }

    $uid = $_POST['uid'];
    $name = trim($_POST['name']);
    $pnumber = trim($_POST['pnumber']);
    $password = trim($_POST['password']);
    $npassword = trim($_POST['npassword']);
    $email = trim($_POST['email']);
    $gender = $_POST['gender'];
    $birthdate = date('m-d-Y', strtotime($_POST['birthdate']));
    $user_type = $_POST['usertype'];
    $address = $_POST['address'];

    $select_staff = $conn->prepare("SELECT * FROM users WHERE uid = ? AND delete_flag = 0");
    $select_staff->bindParam(1, $uid);
    $select_staff->execute();

    if ($select_staff->rowCount() > 0) {
        $staff = $select_staff->fetch(PDO::FETCH_ASSOC);

        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $image_size = $_FILES['image']['size'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_folder = '../uploaded_img/' . uniqid() . '-' . $image;
            $old_image = $_POST['old_image'];

            if ($image_size > 10000000) {
                $data['message'] = 'Image size is too large!';
                $data['update'] = false;
                echo json_encode($data);
                exit;
            }

            if (move_uploaded_file($image_tmp_name, $image_folder)) {
                $update_image = $conn->prepare("UPDATE users SET image = ? WHERE uid = ? AND delete_flag = 0");
                $update_image->bindParam(1, $image_folder);
                $update_image->bindParam(2, $uid);
                $update_image->execute();

                if (!empty($old_image) && file_exists($old_image)) {
                    unlink($old_image);
                }
                $data['message'] = 'Image updated successfully!';
            } else {
                $data['message'] = 'Failed to move uploaded image!';
                $data['update'] = false;
                echo json_encode($data);
                exit;
            }
        }

        // Handle password update
        if (password_verify($password, $staff['password'])) {
            if (!empty($npassword)) {
                $hashed_password = password_hash($npassword, PASSWORD_DEFAULT);
                $update_password = $conn->prepare("UPDATE users SET password = ? WHERE uid = ? AND delete_flag = 0");
                $update_password->bindParam(1, $hashed_password);
                $update_password->bindParam(2, $uid);
                $update_password->execute();
                $data['message'] = "Password changed";
            }

            // Update other profile information
            $update_staff = $conn->prepare("UPDATE users SET 
                name = :name, 
                pnumber = :pnumber, 
                email = :email, 
                gender = :gender, 
                birthdate = :birthdate, 
                user_type = :user_type, 
                address = :address 
                WHERE uid = :uid AND delete_flag = 0");

            $params = array(
                ':name' => $name,
                ':pnumber' => $pnumber,
                ':email' => $email,
                ':gender' => $gender,
                ':birthdate' => $birthdate,
                ':user_type' => $user_type,
                ':address' => $address,
                ':uid' => $uid
            );

            foreach ($params as $key => &$value) {
                $update_staff->bindParam($key, $value);
            }

            if ($update_staff->execute()) {
                $select_updated = $conn->prepare("SELECT *, DATE_FORMAT(STR_TO_DATE(birthdate, '%m-%d-%Y'), '%Y-%m-%d') AS bdate 
                    FROM users WHERE uid = ? AND delete_flag = 0");
                $select_updated->bindParam(1, $uid);
                $select_updated->execute();
                $data = array_merge($data, $select_updated->fetch(PDO::FETCH_ASSOC));
                $data['message'] = isset($data['message']) ? $data['message'] . " Profile updated." : "Profile updated.";
                $data['update'] = true;
            } else {
                $data['message'] = "Error updating profile.";
                $data['update'] = false;
            }
        } else {
            $data['message'] = "Invalid current password";
            $data['update'] = false;
        }
    } else {
        $data['message'] = "User not found";
        $data['update'] = false;
    }
    
    echo json_encode($data);
}
?>