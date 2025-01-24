<?php 
include 'config.php';
$uid = $_SESSION['uid'];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["orderId"]) && isset($_POST["status"]) && isset($_SESSION["uid"])) {
    $status = $_POST["status"];
    $delete_flag = 0;
    $orderId = $_POST['orderId'];
    $update_sql = "UPDATE orders SET status = :status WHERE id = :id AND delete_flag = :delete_flag AND uid = :uid";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->execute(['status' => $status, 'id' => $orderId, 'delete_flag' => $delete_flag, 'uid' => $uid]);
    
    $log = $_SESSION['name'] . " marked as done the order $orderId." ;
    $insert_log = $conn->prepare("INSERT INTO `activity_log`(uid, log, datetime) VALUES (?,?,?)");
    $insert_log->bindParam(1, $uid);
    $insert_log->bindParam(2, $log);
    $insert_log->bindParam(3, $currentDateTime);
    $insert_log->execute();

    $order_amount = $conn->prepare("SELECT * FROM orders WHERE id = ? and delete_flag = ?");
    $order_amount->execute([$orderId, $delete_flag]);
    $order_amount_data = $order_amount->fetch(PDO::FETCH_ASSOC);
    $cart_total = $order_amount_data['amount'];
    
    $insert_sale = $conn->prepare("INSERT INTO `sales` (order_id, amount, datetime) VALUES (?,?,?)");
    $insert_sale->execute([$orderId, $cart_total, $currentDateTime]);

    $get_total = $conn->prepare("SELECT SUM(o.amount) AS total_amount FROM orders o WHERE o.status = 1 AND DATE(STR_TO_DATE(o.placed_on, '%m-%d-%Y %H:%i:%s')) = CURDATE();");
    $get_total->execute();
    $get_total_amount = $get_total->fetch(PDO::FETCH_ASSOC);
    $total_amount = $get_total_amount['total_amount'];

    echo json_encode(array('success' => true, 'id' => $orderId, 'status' => $status, 'message' => 'Order '.$orderId.' marked as done',  'dailySalesAmount' => $total_amount));
} else {
    http_response_code(405);
    echo json_encode(array("error" => "Method Not Allowed"));
}
?>
