<?php
include 'config.php';
error_reporting(E_ALL); 
ini_set('display_errors', 1);

$searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '';

if ($searchTerm !== '') {
    $inventory_log = $conn->prepare("SELECT * FROM activity_log WHERE log LIKE ? ORDER BY id DESC ");
    $inventory_log->execute([$searchTerm]);
    $log = $inventory_log->fetchAll(PDO::FETCH_ASSOC);
    if (count($log) > 0){ 
        foreach ($log as $row) {?>
                    <tr class="border-color" data-id="<?= $row['id']; ?>">
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= DateTime::createFromFormat('m-d-Y H:i:s', $row['datetime'])->format("F d Y h:i A")?></td>
                        <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= ($row['log'])?></td>
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
