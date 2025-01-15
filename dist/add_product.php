<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $id = $_POST['id'];
   $name = trim($_POST['name']);
   $price = trim($_POST['price']);
   $category = trim($_POST['category']);
   $ingredients = $_POST['ingredients'];
   $description = $_POST['description'];

   $insert_product = null;
   $update_product = null;

   if (!isset($id) || $id === '') {
      $insert_product = $conn->prepare("INSERT INTO `products`(name, price, category, description, ingredients) VALUES (?,?,?,?,?)");
      $insert_product->bindParam(1, $name);
      $insert_product->bindParam(2, $price);
      $insert_product->bindParam(3, $category);
      $insert_product->bindParam(4, $description);
      $insert_product->bindParam(5, $ingredients);
      $insert_product->execute();

      $last_insert_id = $conn->lastInsertId();
      $select_new_product = $conn->prepare("SELECT * FROM products WHERE id = ?");
      $select_new_product->bindParam(1, $last_insert_id);
      $select_new_product->execute();
      if ($insert_product) {
         $product = $select_new_product->fetch(PDO::FETCH_ASSOC);
         $image = $_FILES['image']['name'];
         $image_size = $_FILES['image']['size'];
         $image_tmp_name = $_FILES['image']['tmp_name'];
         $image_folder = '../uploaded_img/' . $image;
         $old_image = $_POST['old_image'];
         if (!empty($image)) {
            if ($image_size > 10000000) {
               $data['message'] = 'Image size is too large!';
            } else {
               if (move_uploaded_file($image_tmp_name, $image_folder)) {
                  $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
                  $update_image->bindParam(1, $image);
                  $update_image->bindParam(2, $product['id']);
                  $update_image->execute();

                  if (!empty($old_image) && file_exists('../uploaded_img/' . $old_image)) {
                        unlink('../uploaded_img/' . $old_image);
                  }
                  $data['message'] = 'Image updated successfully!';
               } else {
                  $data['message'] = 'Failed to move uploaded image!';
               }
            }
         }
         if ($product) {
               $select_product = $conn->prepare("SELECT * FROM products WHERE id = ?");
               $select_product->bindParam(1, $product['id']);
               $select_product->execute();
               $data = $select_product->fetch(PDO::FETCH_ASSOC);
               $data['message'] = "New product added.";
               $data['insert'] = true;
         } else {
               $data['message'] = "Product not found.";
               $data['insert'] = false;
         }
      }
   } else {
      $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, category = ?, description = ?, ingredients = ? WHERE id = ?");
      $update_product->bindParam(1, $name);
      $update_product->bindParam(2, $price);
      $update_product->bindParam(3, $category);
      $update_product->bindParam(4, $description);
      $update_product->bindParam(5, $ingredients);
      $update_product->bindParam(6, $id);
      $update_product->execute();

      $select_product = $conn->prepare("SELECT * FROM products WHERE id = ?");
      $select_product->bindParam(1, $id);
      $select_product->execute();

      if ($update_product) {
         $product = $select_product->fetch(PDO::FETCH_ASSOC);
         $image = trim($_FILES['image']['name']);
         $image_size = $_FILES['image']['size'];
         $image_tmp_name = $_FILES['image']['tmp_name'];
         $image_folder = '../uploaded_img/' . $image;
         $old_image = $_POST['old_image'];
         if (!empty($image)) {
               if ($image_size > 10000000) {
                  $data['message'] = 'Image size is too large!';
               } else {
                  if (move_uploaded_file($image_tmp_name, $image_folder)) {
                     $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
                     $update_image->bindParam(1, $image);
                     $update_image->bindParam(2, $product['id']);
                     $update_image->execute();

                     if (!empty($old_image) && file_exists('../uploaded_img/' . $old_image)) {
                           unlink('../uploaded_img/' . $old_image);
                     }
                     $data['message'] = 'Image updated successfully!';
                  } else {
                     $error = error_get_last();
                     $data['message'] = 'Failed to move uploaded image! Error: ' . $error['message'];
                 }
               }
         }
         if ($product) {
               $select_product = $conn->prepare("SELECT id, name, price, category, description, ingredients, image FROM products WHERE id = ?");
               $select_product->bindParam(1, $product['id']);
               $select_product->execute();
               $data = $select_product->fetch(PDO::FETCH_ASSOC);
               $data['message'] =  "Updated product successfully";
               $data['update'] = true;
         } else {
               $data['message'] = "Product not found.";
               $data['update'] = false;
         }
      } else {
         $data['error'] = 'ID parameter is missing';
      }
   }
    echo json_encode($data);
}
?>
