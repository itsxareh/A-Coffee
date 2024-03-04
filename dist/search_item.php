<?php
include 'config.php';
error_reporting(E_ALL); 
ini_set('display_errors', 1);

$searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '';

if ($searchTerm !== '') {
    $select_items = $conn->prepare("SELECT * FROM inventory WHERE name LIKE ?");
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
            <!--<td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                    <img class="w-16 h-16 object-cover" src="../uploaded_img/<?= $item['image']; ?>">
            </td>-->
            <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= ucwords($item['name']); ?></td>
            <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $quantity_value.$quantity_unit ?></td>
            <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap"><?= $item['description']; ?></td>
            <td class="text-gray text-medium text-sm p-3 py-4 whitespace-nowrap">
                <div class="flex items-center gap-4">
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
