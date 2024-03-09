<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $staffId = $_GET['id'];
    
    $delete_staff = $conn->prepare("DELETE FROM users WHERE id = ?");
    $delete_staff->execute([$staffId]);
    
    echo 'Staff deleted successfully';
} else {
    echo 'Invalid request';
}
?>