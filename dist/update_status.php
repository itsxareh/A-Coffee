<?php 
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["orderId"]) && isset($_POST["status"])) {
    $orderId = $_POST["orderId"];
    $status = $_POST["status"];

    // Update the status in the database
    $update_query = $conn->prepare("UPDATE orders SET status = :status WHERE id = :orderId");
    $update_query->bindParam(":status", $status);
    $update_query->bindParam(":orderId", $orderId);
    if ($update_query->execute()) {
        $response = array("success" => true);
    } else {
        $response = array("success" => false);
    }
} else {
    $response = array("success" => false, "message" => "Invalid request");
}

header("Content-Type: application/json");
echo json_encode($response);
?>