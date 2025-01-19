<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT id, uid, name, pnumber, gender, email, birthdate, user_type, address, image, DATE_FORMAT(STR_TO_DATE(birthdate, '%m-%d-%Y'), '%Y-%m-%d') AS bdate, joined_at FROM users WHERE id = ? AND delete_flag = 0");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $data['user_type'] = $data['user_type'] == 1 ? 'Admin' : 'Staff';

    echo json_encode($data);
} else {
    echo json_encode(array('error' => 'ID parameter is missing'));
}
?>
