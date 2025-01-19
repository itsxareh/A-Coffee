<?php 
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_SESSION['uid'];
    $pid = $_POST['pid'];
    $vid = isset($_POST['vid']) ? $_POST['vid'] : 0;
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image = $_POST['image'];

    // $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE product_id = ? AND variation_id = ? AND uid = ?");
    // $check_cart->execute([$pid, $vid, $uid]);

    $insert_cart = $conn->prepare("INSERT INTO `cart`(uid, product_id, variation_id, name, price, quantity, image) VALUES(?,?,?,?,?,?,?)");
    $insert_cart->execute([$uid, $pid, $vid, $name, $price, $quantity, $image]);
    $response['success'] = true;
    
    $response['message'] = 'Added to cart!';
    $check_cart_numbers = $conn->prepare("SELECT *, cart.id as id, product_variations.price as price, product_variations.size as variation FROM `cart` LEFT JOIN product_variations ON cart.variation_id = product_variations.id WHERE uid = ?");
    $check_cart_numbers->execute([$uid]);
    $carts = $check_cart_numbers->fetchAll(PDO::FETCH_ASSOC);

    $totalPlaceOrder = 0;
    foreach ($carts as $cart){
        $totalPlaceOrder += $cart['price'];
    }
    $total = $check_cart_numbers->rowCount();
    $response['product_id'] = $pid;
    $response['totalPlaceOrder'] = $totalPlaceOrder;
    $response['total'] = $total;
    $response['cart'] = $carts;
}
echo json_encode($response);
?>