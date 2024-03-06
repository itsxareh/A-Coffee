<?php
include 'config.php';
error_reporting(E_ALL); 
ini_set('display_errors', 1);
if($_SERVER["REQUEST_METHOD"] == "POST"){
   $id = $_POST['id'];
   $name = trim($_POST['name']);
   $price = trim($_POST['price']);
   $category = trim($_POST['category']);
   $ingredients = $_POST['ingredients'];
   $description = $_POST['description'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;
      
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
   } else {
      $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, category = ?, description = ?, ingredients = ? WHERE id = ?");
      $update_product->bindParam(1, $name);
      $update_product->bindParam(2, $price);
      $update_product->bindParam(3, $category);
      $update_product->bindParam(4, $description);
      $update_product->bindParam(5, $ingredients);
      $update_product->bindParam(6, $id);
      $update_product->execute();
   }

   if ($insert_product || $update_product) {
      $image = $_FILES['image']['name'];
      $image_size = $_FILES['image']['size'];
      $image_tmp_name = $_FILES['image']['tmp_name'];
      $image_folder = '../uploaded_img/' . $image;
      $old_image = $_POST['old_image'];

      if (!empty($image)) {
          if ($image_size > 10000000) {
              $message[] = 'Image size is too large!';
          } else {
              if (move_uploaded_file($image_tmp_name, $image_folder)) {
                  $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
                  $update_image->bindParam(1, $image);
                  $update_image->bindParam(2, $id);
                  $update_image->execute();

                  if (!empty($old_image) && file_exists('../uploaded_img/' . $old_image)) {
                      unlink('../uploaded_img/' . $old_image);
                  }
                  $message[] = 'Image updated successfully!';
              } else {
                  $message[] = 'Failed to move uploaded image!';
              }
          }
      }
      $select_new_product = $conn->prepare("SELECT * FROM products WHERE id = ?");
      $select_new_product->bindParam(1, $id);
      $select_new_product->execute();
      $product = $select_new_product->fetch(PDO::FETCH_ASSOC);
         if ($product){
            echo '<div class="products relative rounded-lg p-4 cursor-pointer shadow-lg bg-dark-brown" style="min-width: 175px; max-width: 300px; height: 264px;" data-id="'.$product['id'].'" onmouseover="showButtons(this)" onmouseout="hideButtons(this)">
                     <div class="absolute flex flex-col items-center top-4 right-4">
                        <button class="edit-btn rounded-md p-2 cursor-pointer hover:block hidden" onclick="showEditModal('.$product['id'] .')">
                           <img class="w-8 h-8 rounded-md" src="../images/edit-svgrepo-com.svg">
                        </button>
                        <button class="delete-btn rounded-md p-2 cursor-pointer hover:block hidden" onclick="showDeleteModal('.$product['id'].')">
                           <img class="w-8 h-8 rounded-md" src="../images/delete-svgrepo-com.svg">
                        </button>
                     </div>
                     <button class="w-full h-full" onclick="showViewModal('.$product['id'].')">
                        <img class="w-full h-full object-cover" src="../uploaded_img/'.$product['image'].'?>">
                     </button>
               </div>';
         } else {
            echo '<p class="text-gray text-medium font-semibold p-3 py-4 text-center">No product data found.</p>';
        } 
      } else {
      echo 'Error: Unable to add product. Please try again.';
   }
}
?>
