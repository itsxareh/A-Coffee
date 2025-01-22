<?php
include 'config.php';
error_reporting(E_ALL); 
ini_set('display_errors', 1);

$searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '';

if ($searchTerm !== '') {
    $select_items = $conn->prepare("SELECT * FROM inventory WHERE name LIKE ? AND delete_flag = 0");
    $select_items->execute([$searchTerm]);

    $items = $select_items->fetchAll(PDO::FETCH_ASSOC);

    if (count($items) > 0) {
        foreach ($items as $item) {
            $quantity = $item['quantity'];
            $matches = [];
            if (preg_match('/(\d*\.?\d+)\s*([a-zA-Z]+)/', $quantity, $matches)) {
                $quantity_value = (float)$matches[1];
                $quantity_unit = strtoupper($matches[2]);
            } else {
                $quantity_value = (float)$quantity;
                $quantity_unit = 'piece/s';
            } ?>
        <tr class="border-color" data-id="<?= $item['id']; ?>">
            <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= ucwords($item['name']); ?></td>
            <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $quantity_value.''.$quantity_unit ?></td>
            <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $item['description'] === '' ? 'N/A' : $item['description']; ?></td>
            <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $item['updated_at'] === '' ? 'N/A' :  DateTime::createFromFormat("m-d-Y H:i:s", $item['updated_at'])->format("F d Y h:i A"); ?></td>
            <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                <div class="flex items-center gap-4">
                    <?php 
                    if (!empty($item['updated_at'])) {
                        $updated = DateTime::createFromFormat("m-d-Y H:i:s", $item['updated_at']);
                        $now = new DateTime();
                        $diff = $now->getTimestamp() - $updated->getTimestamp();
                        if ($diff <= 86400) {
                            ?>
                            <button id="undoModalBtn" class="w-6 h-6" onclick="showUndoModal(<?= $item['id'] ?>)">
                                <img src="../images/undo-left-svgrepo-com.svg" alt="">
                            </button>
                            <?php
                        }
                    }
                    ?>
                    <button id="editModalBtn" class="w-6 h-6" onclick="showEditModal(<?= $item['id'] ?>)"><img src="../images/edit-svgrepo-com.svg" alt=""></button>
                    <button id="deleteModalBtn" class="w-6 h-6" onclick="showDeleteModal(<?= $item['id'] ?>)"><img src="../images/delete-svgrepo-com.svg" alt=""></button>
                </div>
            </td>
        </tr>  
        <?php 
        }
    } else {
        echo '<tr><td colspan="6" class="text-gray text-medium font-semibold p-3 py-4 text-center">No item found.</td></tr>';
    }
} else {
    echo '<tr class="text-gray text-2xl">Please enter a search term!</tr>';
}
?>
