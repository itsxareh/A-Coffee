<?php 
include 'config.php';
$uid = $_SESSION['uid'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["cartId"]) && isset($_POST["action"])) {
        $cartId = $_POST["cartId"];
        $action = $_POST["action"]; 
        
        $stmt = $conn->prepare("SELECT quantity, price FROM cart WHERE id = ?");
        $stmt->execute([$cartId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $currentQuantity = $row["quantity"];
        $price = $row["price"];

        if ($action === "add") {
            $newQuantity = $currentQuantity + 1;
        } elseif ($action === "minus" && $currentQuantity > 1) {
            $newQuantity = $currentQuantity - 1;
        } else {
            $newQuantity = $currentQuantity;
        }
        $updateStmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
        $updateStmt->execute([$newQuantity, $cartId]);

        $totalPriceStmt = $conn->prepare("SELECT SUM(price * quantity) AS total FROM cart WHERE uid = ?");
        $totalPriceStmt->execute([$uid]);
        $totalPriceRow = $totalPriceStmt->fetch(PDO::FETCH_ASSOC);
        $totalPrice = $totalPriceRow['total'];

        $updatedCartStmt = $conn->prepare("SELECT * FROM cart WHERE id = ?");
        $updatedCartStmt->execute([$cartId]);
        $updatedCart = $updatedCartStmt->fetch(PDO::FETCH_ASSOC);

        $updatedCart['total'] = $totalPrice;

        echo json_encode($updatedCart);
    } else {
        http_response_code(400);
        echo json_encode(array("error" => "Invalid request parameters"));
    }
} else {
    http_response_code(405);
    echo json_encode(array("error" => "Method Not Allowed"));
}
?>
