<?php
include "config.php";
$user_type = $_SESSION['user_type'];
$uid = $_SESSION['uid'];
if (isset($_GET['option'])) {
    $option = $_GET['option'];
    $query = "";

    $userCondition = ($user_type == 0) ? "AND orders.uid = '$uid'" : "";

    switch ($option) {
        case "today":
            $query = "SELECT *,
                    orders.id as id 
                    FROM orders 
                    LEFT JOIN users ON orders.uid = users.uid
                    WHERE DATE(STR_TO_DATE(placed_on, '%m-%d-%Y %H:%i:%s')) = CURDATE() 
                    AND orders.delete_flag = 0 
                    $userCondition 
                    ORDER BY orders.id DESC;";
            break;
        case "yesterday":
            $query = "SELECT *,
                    orders.id as id 
                    FROM orders 
                    LEFT JOIN users ON orders.uid = users.uid
                    WHERE DATE(STR_TO_DATE(placed_on, '%m-%d-%Y %H:%i:%s')) = CURDATE() - INTERVAL 1 DAY 
                    AND orders.delete_flag = 0 
                    $userCondition 
                    ORDER BY orders.id DESC;";
            break;
        case "week":
            $query = "SELECT *,
                    orders.id as id  
                    FROM orders 
                    LEFT JOIN users ON orders.uid = users.uid
                    WHERE WEEK(STR_TO_DATE(placed_on, '%m-%d-%Y %H:%i:%s'), 1) = WEEK(CURDATE(), 1) 
                    AND YEAR(STR_TO_DATE(placed_on, '%m-%d-%Y %H:%i:%s')) = YEAR(CURDATE()) 
                    AND orders.delete_flag = 0 
                    $userCondition 
                    ORDER BY orders.id DESC;";
            break;
        case "all":
        default:
            $query = "SELECT *,
                    orders.id as id  
                    FROM orders 
                    LEFT JOIN users ON orders.uid = users.uid
                    WHERE orders.delete_flag = 0 
                    $userCondition 
                    ORDER BY orders.id DESC;";
            break;
    }

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    function getRelativeTime($placedOn) {
        $timestamp = strtotime($placedOn);
        $now = time();
        $diff = $now - $timestamp;
    
        if ($diff < 60) {
            return 'Just now';
        } elseif ($diff < 3600) {
            $minutes = floor($diff / 60);
            return $minutes . 'm ago';
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . 'h ago';
        } elseif ($diff < 2592000) {
            $days = floor($diff / 86400);
            return $days . 'd ago';
        } elseif ($diff < 31536000) {
            $months = floor($diff / 2592000);
            return $months . 'mo ago';
        } 
        $years = floor($diff / 31536000);
        return $years . 'y ago';
    }
    // Generate the table rows dynamically

    if (count($orders) > 0) {
        foreach ($orders as $order) {
            echo "
                <tr class='border-color' data-id='{$order['id']}'>
                    <td class='text-gray text-medium text-sm p-3 py-4 whitespace-nowrap'>{$order['id']}</td>
                    <td class='text-gray text-medium text-sm p-3 py-4 whitespace-wrap'>{$order['products']}</td>
                    <td class='text-gray text-medium text-sm p-3 py-4 whitespace-nowrap'>₱{$order['amount']}</td>
                    <td class='placed_on' data-timestamp='{$order['placed_on']}'>" . getRelativeTime($order['placed_on']) . "</td>
                    ";
                    if ($_SESSION['user_type'] == 1) echo '
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap rosarivo">' . $order['name'] . '</td>';
                echo "
                    <td class='text-gray text-medium text-sm p-3 py-4 whitespace-nowrap'>";
                    if ($_SESSION['user_type'] == 1) {
                        echo $order['status'] == 1 ? 'Done' : 'On process';
                    } else {
                        if ($order['status']===2) { ?>
                            <select class="text-white text-medium text-sm bg-transparent whitespace-nowrap rosarivo status-select" name="status" id="status" data-id="<?= $order['id'] ?>" <?= $order['uid'] !== $uid ? 'disabled': ''?>>
                                <option class="text-black text-medium rosarivo " value="2" <?= $order['status'] == 2 ? 'selected' : '' ?>>On Process</option>
                                <option class="text-black text-medium rosarivo " value="1" <?= $order['status'] == 1 ? 'selected' : '' ?>>Done</option>
                            </select>
                            <?php
                        } else {
                            echo 'Done';
                        }
                    }     
                echo " 
                    </td>
                    <td class='text-gray text-medium text-sm p-3 py-4 whitespace-nowrap'>
                        <button class='receiptModalBtn w-6 h-6' title='View Receipt' onclick='showReceiptModal({$order['id']})'>
                            <img src='../images/receipt-svgrepo-com.svg' alt='View Receipt'>
                        </button>
                    </td>
                </tr>";
        }
    } else {
        echo '<tr><td colspan="7" class="text-gray text-medium font-semibold p-3 py-4 text-center">No orders found.</td></tr>';
    }
} else {
    echo '<tr><td colspan="7" class="text-gray text-medium font-semibold p-3 py-4 text-center">Option not set.</td></tr>';
}
?>