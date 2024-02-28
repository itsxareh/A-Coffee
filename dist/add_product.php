<?php
include 'config.php';
error_reporting(E_ALL); 
ini_set('display_errors', 1);
if($_SERVER["REQUEST_METHOD"] == "POST"){
   $name = trim($_POST['name']);
   $price = trim($_POST['price']);
   $category = trim($_POST['category']);
   $ingredients = $_POST['ingredients'];
   $description = $_POST['description'];

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;
   
   $insert_product = $conn->prepare("INSERT INTO `products`(name, price, category, description, ingredients, image) VALUES (?,?,?,?,?,?)");
   $insert_product->execute([$name, $price, $category, $description, $ingredients, $image]);

   if($insert_product){
      if($image_size > 10000000){
         echo 'Image size is too large!';
      } else {
         move_uploaded_file($image_tmp_name, $image_folder);
         $new_product_id = $conn->lastInsertId();
         $select_new_product = $conn->prepare("SELECT * FROM products WHERE id = ?");
         $select_new_product->execute([$new_product_id]);
         $new_product = $select_new_product->fetch(PDO::FETCH_ASSOC);
         
         echo '<a href="index.php?page=view_product&id='.$new_product['id'].'" class="rounded-lg p-4 cursor-pointer shadow-lg bg-dark-brown" style="min-width: 175px; max-width: 300px; height: 264px;">';
         echo '<img class="w-full h-full object-cover" src="../uploaded_img/'.$new_product['image'].'">';
         echo '</a>';
      }
   } else {
      echo 'Error: Unable to add product. Please try again.';
   }
}
?>
