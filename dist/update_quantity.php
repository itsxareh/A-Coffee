<?php 
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if cartId and action are set
    if (isset($_POST["cartId"]) && isset($_POST["action"])) {
        $cartId = $_POST["cartId"];
        $action = $_POST["action"];

        // Fetch current quantity from database
        $stmt = $conn->prepare("SELECT quantity FROM cart WHERE id = ?");
        $stmt->execute([$cartId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $currentQuantity = $row["quantity"];

        // Update quantity based on action
        if ($action === "add") {
            $newQuantity = $currentQuantity + 1;
        } elseif ($action === "minus" && $currentQuantity > 1) {
            $newQuantity = $currentQuantity - 1;
        } else {
            // No change needed, return the current quantity
            $newQuantity = $currentQuantity;
        }

        // Update the quantity in the database
        $updateStmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
        $updateStmt->execute([$newQuantity, $cartId]);

        // Fetch updated cart data
        $updatedCartStmt = $conn->prepare("SELECT * FROM cart WHERE id = ?");
        $updatedCartStmt->execute([$cartId]);
        $updatedCart = $updatedCartStmt->fetch(PDO::FETCH_ASSOC);

        // Return updated cart data as JSON
        echo json_encode($updatedCart);
    } else {
        // Invalid request
        http_response_code(400);
        echo json_encode(array("error" => "Invalid request parameters"));
    }
} else {
    // Method not allowed
    http_response_code(405);
    echo json_encode(array("error" => "Method Not Allowed"));
}
?>