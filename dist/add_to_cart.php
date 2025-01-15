<?php 
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];
    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image = $_POST['image'];

    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE product_id = ? AND uid = ?");
    $check_cart->execute([$pid, $uid]);
 
    if($check_cart->rowCount() > 0){
        $response['success'] = false;
        $response['message'] = 'Already added to cart!';
    }else{
       $insert_cart = $conn->prepare("INSERT INTO `cart`(uid, product_id, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
       $insert_cart->execute([$uid, $pid, $name, $price, $quantity, $image]);
       $response['success'] = true;
       $response['message'] = 'Added to cart!';
    }
    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE uid = ?");
    $check_cart_numbers->execute([$uid]);

    $total = $check_cart_numbers->rowCount();

    $response['total'] = $total;
    $response['cart'] = $check_cart_numbers->fetchAll(PDO::FETCH_ASSOC);
}
echo json_encode($response);
?>