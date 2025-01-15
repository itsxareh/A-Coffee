<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $data = json_decode(file_get_contents('php://input'), true);
    $order_id = $data['order_id'] ?? null;

    if ($order_id) {
        // Fetch the order details including the products string
        $get_order = $conn->prepare("SELECT o.id, o.placed_on, o.products FROM orders o WHERE o.id = ?");
        $get_order->execute([$order_id]);
        $order = $get_order->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            $products = explode(', ', $order['products']); 
            $product_details = [];
            $total_amount = 0;

            foreach ($products as $product) {
                // Extract quantity and name from the product string
                preg_match('/^(\\d+)\\s(.+)$/', $product, $matches);
                $quantity = (int) $matches[1];
                $name = $matches[2];

                // Fetch the product price
                $get_price = $conn->prepare("SELECT price FROM products WHERE name = ?");
                $get_price->execute([$name]);
                $product_data = $get_price->fetch(PDO::FETCH_ASSOC);

                if ($product_data) {
                    $price = $product_data['price'];
                    $subtotal = $price * $quantity;
                    $total_amount += $subtotal;

                    $product_details[] = [
                        'name' => $name,
                        'price' => $price,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal
                    ];
                }
            }

            // Prepare the response
            $response = [
                'success' => true,
                'order_id' => $order['id'],
                'placed_on' => DateTime::createFromFormat("m-d-Y H:i:s", $order['placed_on'])->format("F d Y h:i A"),
                'amount' => $total_amount,
                'products' => $product_details
            ];
        } else {
            $response = ['success' => false, 'message' => 'Order not found.'];
        }
    } else {
        $response = ['success' => false, 'message' => 'Invalid request.'];
    }

    echo json_encode($response);
    exit;
}
?>
