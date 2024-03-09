<?php
include 'config.php';
$uid = $_SESSION['uid'];

$check_cart = $conn->prepare("SELECT * FROM `cart` WHERE uid = ?");
$check_cart->execute([$uid]);
$carts = $check_cart->fetchAll(PDO::FETCH_ASSOC);
if(count($carts) === 0){
    echo '<p class="text-black text-medium font-semibold p-3 py-4 text-center">Your cart is empty.</p>';
} else {
    ?>
<div id="cartLists" class="p-4 md:p-5">
    <div class="grid autofit-grid1 gap-3">               
    <?php
    foreach($carts as $cart){ ?>
        <div class="mb-4 ms-4">            
            <div class="flex items-center">
                <img class="w-14 h-14 rounded-md mr-5" src="../uploaded_img/<?= $cart['image']?>" alt="">
                <div class="flex-1" data-id="<?= $cart['id'] ?>">
                    <h3 class="flex items-start mb-1 text-lg font-medium text-gray-900"><?= ucwords($cart['name']) ?><p class="salsa bg-blue-100 text-black text-sm font-medium mr-2 px-2.5 py-0.5 rounded ms-3">x<span  id="confirm-quantity" ><?= $cart['quantity'] ?></span></p></h3>
                    <p class="block mb-3 text-sm font-normal leading-none text-gray-500">₱<span id="confirm-price" class="salsa"><?= $cart['price'] * $cart['quantity'] ?></span></p>
                </div>               
            </div>
        </div>
        <?php
            }
        }
        ?>
    </div>
    <?php
    $check_cart = $conn->prepare("SELECT *, SUM(price * quantity) as total FROM cart WHERE uid = ?");
    $check_cart->bindParam(1, $uid);
    $check_cart->execute();
    $carts = $check_cart->fetchAll(PDO::FETCH_ASSOC);
    if(count($carts) > 0){
        foreach($carts as $cart){ ?>
    <div class="flex justify-end items-center">
        <div class="pr-5">
            <p class="text-gray-500 text-sm font-medium leading-tight tracking-normal salsa" for="total">Total</p>
            <p id="total"  class="salsa block mb-3 text-md font-normal leading-none text-gray-800 dark:text-gray-700">₱<span id="confirm-total text-gray-800 salsa block mb-3 text-md font-normal leading-none"><?= $cart['total'] ?></span></p>
        </div>
        <form id="add_order" action="add_order.php" method="POST">
            <input type="text" class="hidden" name="uid" id="uid" value="<?= $cart['uid'] ?>" title="uid" placeholder="">
            <button title="Confirm" type="submit" id="submitBtn" class="addToOrder bg-light-brown border border-light-brown px-5 py-2 text-sm  font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-amber-400" data-id=<?= $cart['id']; ?> >Confirm</button>
        </form>
    </div>
    <?php
        }
    } 
    ?>
</div>