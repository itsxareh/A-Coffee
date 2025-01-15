<?php
include 'config.php';
error_reporting(E_ALL); 
ini_set('display_errors', 1);

$searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '';

if ($searchTerm !== '') {
    $inventory_log = $conn->prepare("SELECT i.*, u.name as name, inv.name as itemName FROM `inventory-log` i LEFT JOIN users u ON i.uid = u.uid LEFT JOIN inventory inv ON i.item_id = inv.id WHERE u.name LIKE ? OR inv.name LIKE ? OR i.date LIKE ? OR i.quantity LIKE ?");
    $inventory_log->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    $log = $inventory_log->fetchAll(PDO::FETCH_ASSOC);
    if (count($log) > 0){ 
        foreach ($log as $row) {?>
                    <tr class="border-color" data-id="<?= $row['id']; ?>">
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= ucwords($row['date']); ?></td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= ucwords($row['name'])?></td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= ucwords($row['itemName']) ? ucwords($row['itemName']) : 'N/A' ?></td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= ucwords($row['quantity']) ? ucwords($row['quantity']) : 'N/A' ?></td>
                    </tr>   
        <?php 
        }
    } else {
        echo '<tr><td colspan="6" class="text-gray text-medium font-semibold p-3 py-4 text-center">No activity log found.</td></tr>';
    }
} else {
    echo '<tr class="text-gray text-2xl">Please enter a search term!</tr>';
}
?>
