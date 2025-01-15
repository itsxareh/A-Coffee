<?php 
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST"){
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

    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;
    $old_image = $_POST['old_image'];

    $select_staff = $conn->prepare("SELECT * FROM users WHERE uid = ?");
    $select_staff->bindParam(1, $uid);
    $select_staff->execute();
    $staff = $select_staff->fetch(PDO::FETCH_ASSOC);
    if ($select_staff){
        if (!empty($image)) {
            if ($image_size > 10000000) {
                $message[] = 'Image size is too large!';
            } else {
                if (move_uploaded_file($image_tmp_name, $image_folder)) {
                    $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE uid = ?");
                    $update_image->bindParam(1, $image);
                    $update_image->bindParam(2, $staff['uid']);
                    $update_image->execute();

                    if (!empty($old_image) && file_exists('../uploaded_img/' . $old_image)) {
                        unlink('../uploaded_img/' . $old_image);
                    }
                    $message[] = 'Image updated successfully!';
                } else {
                    $message[] = 'Failed to move uploaded image!';
                }
            }
        }
        if (password_verify($password, $staff['password'])){
            if (!empty($npassword)){
                $select_staff = $conn->prepare("UPDATE users SET password = ? WHERE uid = ?");
                $select_staff->bindParam(1, $uid);
                $npassword = password_hash($npassword, PASSWORD_DEFAULT);
                $select_staff->bindParam(2, $npassword);
                $select_staff->execute();
                $data['message'] = "Password changed";
                $data['update'] = true;
            }
            $update_staff = $conn->prepare("UPDATE `users` SET name = :name, pnumber = :pnumber, email = :email, gender = :gender, birthdate = :birthdate, user_type = :user_type, address = :address WHERE uid = :uid");
            $params = array(':name' => $name, ':pnumber' => $pnumber, ':email' => $email, ':gender' => $gender, ':birthdate' => $birthdate, ':user_type' => $user_type, ':address' => $address, ':uid' => $uid);
            foreach ($params as $key => &$value) {
                $update_staff->bindParam($key, $value);
            }
            $update_staff->execute();
            if ($update_staff){
                $select_staff = $conn->prepare("SELECT *, DATE_FORMAT(STR_TO_DATE(birthdate, '%m-%d-%Y'), '%Y-%m-%d') AS bdate FROM users WHERE uid = ?");
                $select_staff->bindParam(1, $uid);
                $select_staff->execute();
                $data = $select_staff->fetch(PDO::FETCH_ASSOC);
                $data['message'] = "Profile updated.";
                $data['update'] = true;
            } else {
                $data['message'] = "Error updating profile.";
                $data['update'] = false;
            }
        }
    } else {
        $data['error'] = 'UID parameter is missing';
    }   
    echo json_encode($data);
}
?>