<?php
include 'config.php';
$uid = $_SESSION['uid'];
header('Content-Type: application/json');

$check_cart = $conn->prepare("SELECT * FROM `cart` WHERE uid = ?");
$check_cart->execute([$uid]);
$cart = $check_cart->fetchAll(PDO::FETCH_ASSOC);
$ordersNo = count($cart);

if(count($cart) === 0){
    $html = '<p class="text-black text-medium font-semibold p-3 py-4 text-center">Your cart is empty.</p>';
    $ordersNo = 0; 
    $total = 0;
} else {
    ob_start();
    ?>
    <ol class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5">                  
        <?php
        foreach($carts as $cart){ ?>
            <li class="mb-8 ms-8">            
                <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                    <svg width="800px" height="800px" viewBox="-50 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#000000"
                            d="M822.592 192h14.272a32 32 0 0 1 31.616 26.752l21.312 128A32 32 0 0 1 858.24 384h-49.344l-39.04 546.304A32 32 0 0 1 737.92 960H285.824a32 32 0 0 1-32-29.696L214.912 384H165.76a32 32 0 0 1-31.552-37.248l21.312-128A32 32 0 0 1 187.136 192h14.016l-6.72-93.696A32 32 0 0 1 226.368 64h571.008a32 32 0 0 1 31.936 34.304L822.592 192zm-64.128 0 4.544-64H260.736l4.544 64h493.184zm-548.16 128H820.48l-10.688-64H214.208l-10.688 64h6.784zm68.736 64 36.544 512H708.16l36.544-512H279.04z" />
                    </svg>
                </span>
                <div class="flex items-center">
                    <img class="w-14 h-14 rounded-md mr-5" src="../uploaded_img/<?= $cart['image']?>" alt="">
                    <div class="flex-1" data-id="<?= $cart['id'] ?>">
                        <h3 class="flex items-start mb-1 text-lg font-semibold text-gray-900 dark:text-white"><?= ucwords($cart['name']) ?><p class="salsa bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">x<span  id="confirm-quantity" ><?= $cart['quantity'] ?></span></p></h3>
                        <p class="block mb-3 text-sm font-normal leading-none text-gray-500 dark:text-gray-400">₱<span id="confirm-price" class="salsa"><?= $cart['price'] * $cart['quantity'] ?></span></p>
                    </div>               
                </div>
            </li>
        <?php
        }
        ?>
    </ol>

    <?php
    $check_cart = $conn->prepare("SELECT *, SUM(price * quantity) as total FROM cart WHERE uid = ?");
    $check_cart->execute([$uid]);
    $carts = $check_cart->fetchAll(PDO::FETCH_ASSOC);
    if(count($carts) > 0){
        $total = $carts[0]['total'];
        foreach($carts as $cart){ ?>
            <div class="flex justify-end items-center">
                <div class="pr-5">
                    <p class="text-gray-500 text-sm font-medium leading-tight tracking-normal salsa" for="total">Total</p>
                    <p id="total"  class="salsa block mb-3 text-md font-normal leading-none text-gray-800 dark:text-gray-700">₱<span id="confirm-total"><?= $cart['total'] ?></span></p>
                </div>
                <form id="add_order" action="add_order.php" method="POST">
                    <input type="text" class="hidden" name="uid" id="uid" value="<?= $cart['uid'] ?>">
                    <button type="submit" id="submitBtn" class="addToOrder bg-light-brown border border-light-brown px-5 py-2 text-sm  font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-amber-400" data-id=<?= $cart['id']; ?> >Confirm</button>
                </form>
            </div>
        <?php
        }
    }
    $html = ob_get_clean();
}

$response = [
    'html' => $html,
    'total' => $total,
    'ordersNo' => $ordersNo,
];

echo json_encode($response);
?>