<?php
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
   date_default_timezone_set('Asia/Manila');
   $current_time = date('m-d-Y h:m:s');
   $uid = $_POST['uid'];
   $status = '2';
   $cart_total = 0;
   $cart_products[] = '';

   $select_cart = $conn->prepare("SELECT c.*, p.ingredients, p.name AS product_name FROM `cart` c LEFT JOIN  products p ON p.id = c.product_id WHERE uid = ?");
   $select_cart->execute([$uid]);
   if($select_cart->rowCount() > 0){
      while($cart_item = $select_cart->fetch(PDO::FETCH_ASSOC)){
         $cart_products[] = $cart_item['product_name'].' ('.$cart_item['quantity'].')';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      };
   };

   $total_products = $cart_products[0];
   
   for ($i = 1; $i < count($cart_products); $i++) {
      $total_products .= ', ' . $cart_products[$i];
   }
   $order_query = $conn->prepare("SELECT * FROM `orders` WHERE uid = ? AND products = ? AND amount = ? AND status = ?");
   $order_query->execute([$uid, $total_products, $cart_total, $status]);
   
   if ($cart_total == 0) {
      $response['message'] = 'Your cart is empty';
   } elseif ($order_query->rowCount() > 0) {
      $response['message'] = 'Order placed already!';
   } else {
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE uid = ?");
      $insert_order = $conn->prepare("INSERT INTO `orders`(uid, products, amount, status, placed_on) VALUES(?,?,?,?,?)");
      
      $conn->beginTransaction();
      $cart_query = $conn->prepare("SELECT c.*, p.ingredients FROM `cart` c LEFT JOIN  products p ON p.id = c.product_id WHERE uid = ?");
      $cart_query->execute([$uid]);
      while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
            $product_id = $cart_item['product_id'];
            $product_quantity = $cart_item['quantity'];
            $ingredients = $cart_item['ingredients'];
            $ingredientList = explode(', ', $ingredients);

            foreach ($ingredientList as $ingredient) {
               list($ingredient_quantity, $itemName) = explode(' ', $ingredient, 2);
               $ingredient_quantity *= $product_quantity;
               $inventory_query = $conn->prepare("SELECT quantity FROM `inventory` WHERE name = ?");
               $inventory_query->execute([$itemName]);
               $current_quantity = $inventory_query->fetchColumn();
               if ($current_quantity === false) {
                  $response['message'] = "Failed to retrieve quantity for {$itemName}";
              } elseif ($current_quantity < $ingredient_quantity) {
                  $response['message'] = "Insufficient quantity for {$itemName}";
              } else {
                  $new_quantity = $current_quantity - $ingredient_quantity;
                  $update_inventory = $conn->prepare("UPDATE `inventory` SET quantity = ? WHERE name = ?");
                  $update_inventory->execute([$new_quantity, $itemName]);
              }
            }
      }
      $insert_order->execute([$uid, $total_products, $cart_total, $status, $current_time]);
      $delete_cart->execute([$uid]);
      $conn->commit();
      $response['message'] = "Product added to cart successfully";
   }  
}
?>