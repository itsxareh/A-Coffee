<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   try {
      $conn->beginTransaction();
      $uid = $_SESSION['uid'];
      $id = $_POST['id'];
      $name = trim($_POST['name']);
      $price = trim($_POST['price'] ?? '0');
      $category = trim($_POST['category']);
      $description = $_POST['description'];

      $insert_product = null;
      $update_product = null;

      if (!isset($id) || $id === '') {
         // Insert new product
         $insert_product = $conn->prepare("INSERT INTO `products`(name, category, description) VALUES (?,?,?)");
         $insert_product->bindParam(1, $name);
         $insert_product->bindParam(2, $category);
         $insert_product->bindParam(3, $description);
         $insert_product->execute();

         $last_insert_id = $conn->lastInsertId();
         
         // Optional: Insert variations if provided
         if (isset($_POST['variations']) && is_array($_POST['variations'])) {
            $insert_variation = $conn->prepare("INSERT INTO `product_variations`(product_id, size, price, ingredients) VALUES (?,?,?,?)");
            
            foreach ($_POST['variations'] as $variation) {
               if (!empty($variation['size']) && !empty($variation['price'])) {
                  $insert_variation->execute([
                     $last_insert_id,
                     trim($variation['size'] ?? ''),
                     trim($variation['price'] ?? ''),
                     trim($variation['ingredients'] ?? '')
                  ]);
               }
            }
         }

         $select_new_product = $conn->prepare("SELECT p.*, GROUP_CONCAT(v.id, ':', v.size, ':', v.price, ':', v.ingredients) as variations 
                                             FROM products p 
                                             LEFT JOIN product_variations v ON p.id = v.product_id 
                                             WHERE p.id = ?
                                             GROUP BY p.id");
         $select_new_product->bindParam(1, $last_insert_id);
         $select_new_product->execute();

         if ($insert_product) {
            $product = $select_new_product->fetch(PDO::FETCH_ASSOC);
            
            // Handle image upload
            $unique_id = rand(000000000, 999999999);
            $image = $_FILES['image']['name'];
            $uniq_image = $unique_id . '-' . $image;
            $image_size = $_FILES['image']['size'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_folder = '../uploaded_img/' . $uniq_image;
            $old_image = $_POST['old_image'];

            if (!empty($image)) {
               if ($image_size > 10000000) {
                  $data['message'] = 'Image size is too large!';
               } else {
                  if (move_uploaded_file($image_tmp_name, $image_folder)) {
                     $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
                     $update_image->bindParam(1, $uniq_image);
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
               $data = $product;
               $log = $_SESSION['name']. " added a new product: ". $product['name'];
               $insertLog = $conn->prepare("INSERT INTO activity_log (uid, log, datetime) VALUES (?, ?, ?)");
               $insertLog->bindParam(1, $uid);
               $insertLog->bindParam(2, $log);
               $insertLog->bindParam(3, $currentDateTime);
               $insertLog->execute();
               
               $data['image'] = !empty($image) ? $uniq_image : NULL;
               $data['message'] = "New product added.";
               $data['insert'] = true;
            } else {
               $data['message'] = "Product not found.";
               $data['insert'] = false;
            }
         }
      } 
      else {
         // Update existing product
         $update_product = $conn->prepare("UPDATE `products` SET name = ?, category = ?, description = ? WHERE id = ?");
         $update_product->bindParam(1, $name);
         $update_product->bindParam(2, $category);
         $update_product->bindParam(3, $description);
         $update_product->bindParam(4, $id);
         $update_product->execute();

         // Delete existing variations
         $delete_variations = $conn->prepare("DELETE FROM `product_variations` WHERE product_id = ?");
         $delete_variations->execute([$id]);

         // Optional: Insert updated variations
         if (isset($_POST['variations']) && is_array($_POST['variations'])) {
            $insert_variation = $conn->prepare("INSERT INTO `product_variations`(product_id, size, price, ingredients) VALUES (?,?,?,?)");
            
            foreach ($_POST['variations'] as $variation) {
               if (!empty($variation['size']) && !empty($variation['price'])) {
                  $insert_variation->execute([
                     $id,
                     trim($variation['size']),
                     trim($variation['price']),
                     trim($variation['ingredients'])
                  ]);
               }
            }
         }

         $select_product = $conn->prepare("SELECT p.*, GROUP_CONCAT(v.id, ':', v.size, ':', v.price, ':', v.ingredients) as variations 
                                         FROM products p 
                                         LEFT JOIN product_variations v ON p.id = v.product_id 
                                         WHERE p.id = ?
                                         GROUP BY p.id");
         $select_product->bindParam(1, $id);
         $select_product->execute();

         if ($update_product) {
            $product = $select_product->fetch(PDO::FETCH_ASSOC);
            
            // Handle image upload for update
            $unique_id = rand(000000000, 999999999);
            $image = $_FILES['image']['name'];
            $uniq_image = $unique_id . '-' . $image;
            $image_size = $_FILES['image']['size'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_folder = '../uploaded_img/' . $uniq_image;
            $old_image = $_POST['old_image'];

            if (!empty($image)) {
               if ($image_size > 10000000) {
                  $data['message'] = 'Image size is too large!';
               } else {
                  if (move_uploaded_file($image_tmp_name, $image_folder)) {
                     $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
                     $update_image->bindParam(1, $uniq_image);
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
               $data = $product;
               $log = $_SESSION['name']. " updated a product: ". $product['name'];
               $insertLog = $conn->prepare("INSERT INTO activity_log (uid, log, datetime) VALUES (?, ?, ?)");
               $insertLog->bindParam(1, $uid);
               $insertLog->bindParam(2, $log);
               $insertLog->bindParam(3, $currentDateTime);
               $insertLog->execute();
               $data['image'] = !empty($image) ? $uniq_image : $product['image'];
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
      
      $conn->commit();
      echo json_encode($data);
      
   } catch (Exception $e) {
      $conn->rollBack();
      $data['error'] = 'Error: ' . $e->getMessage();
      echo json_encode($data);
   }
}
?>