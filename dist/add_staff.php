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
        $insert_staff->execute([$uid, $name, $pnumber, password_hash($password, PASSWORD_DEFAULT), $email, $gender, $birthdate, $user_type, $address, $current_time]);
    } else {
    $update_staff = $conn->prepare("UPDATE `users` SET name = ?, pnumber = ?, password = ?, email = ?, gender = ?, birthdate = ?, user_type = ?, address = ?, joined_at = ? WHERE uid = ?");
    $update_staff->execute([$name, $pnumber, password_hash($password, PASSWORD_DEFAULT), $email, $gender, $birthdate, $user_type, $address, $current_time, $uid]);
    }

    if ($insert_staff || $update_staff) {
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
                    $update_image->execute([$image, $uid]);

                    if (!empty($old_image) && file_exists('../uploaded_img/' . $old_image)) {
                        unlink('../uploaded_img/' . $old_image);
                    }
                    $message[] = 'Image updated successfully!';
                } else {
                    $message[] = 'Failed to move uploaded image!';
                }
            }
        }

        $select_new_staff = $conn->prepare("SELECT u.id, u.image, u.name, u.uid, SUM(o.amount) AS total, SUM(o.amount) AS quantity FROM users u LEFT JOIN orders o ON u.uid = o.uid WHERE u.uid = ? GROUP BY u.uid");
        $select_new_staff->execute([$uid]);
        $staff = $select_new_staff->fetch(PDO::FETCH_ASSOC);

        if ($staff) {
            echo '<tr class="border-color" data-id="' . $staff['id'] . '">';
            echo '<td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">';
            echo '<a class="cursor-pointer" href="index.php?page=view_staff&id=' . $staff['id'] . 'title="View Staff Details">';
            echo '<img class="w-16 h-16 object-cover" src="../uploaded_img/' . $staff['image'] . '">';
            echo '</a>';
            echo '</td>';
            echo '<td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">' . ucwords($staff['name']) . '</td>';
            echo '<td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">' . $staff['uid'] . '</td>';
            echo '<td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">' . ($staff['quantity'] ? $staff['quantity'] : "0") . '</td>';
            echo '<td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">' . ($staff['total'] ? $staff['total'] : "0") . '</td>';
            echo '<td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">';
            echo '<div class="flex items-center gap-4">';
            echo '<button class="w-6 h-6"><img src="../images/edit-svgrepo-com.svg" alt=""></button>';
            echo '<button id="deleteModalBtn" class="w-6 h-6"><img src="../images/delete-svgrepo-com.svg" alt=""></button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
        } else {
            echo '<tr><td colspan="6" class="text-gray text-medium font-semibold p-3 py-4 text-center">No staff data found.</td></tr>';
        } 
    } else {
        echo "Error executing SQL query.";
    }
}
?>
