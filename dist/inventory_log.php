<?php 
if ($fetch_profile['user_type'] == 1) {  ?>
    <div class="hide-message hidden">
        <div class="message rounded-lg p-4 flex items-start">
            <span id="message" class="text-sm text-white"></span>
            <button class="-m-1" onclick="this.parentElement.remove();"><img class="w-5 h-5" src="../images/close-svgrepo-com.svg"></button>
        </div>
    </div>
    <div class="upper flex justify-between mb-4">
        <span class="text-gray text-2xl salsa title">Inventory Log</span>
        <div class="button-input flex">
            <input title="Search" id="search" name="search" placeholder="Search" class="search ml-4 px-4 py-2 w-48 rounded-md salsa text-black" type="text">
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="indent-0 border-collapse py-6 px-2  w-full" id="itemsTable">
            <thead>
                <tr>
                    <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Date</th>
                    <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Staff</th>
                    <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Item</th>
                    <th class="text-semibold text-sm salsa shadow-lg p-3 text-white text-left">Quantity</th>
                </tr>
            </thead>
            <tbody id="itemsList">
                <?php 
                    $inventory_log = $conn->prepare("SELECT i.*, u.name as name, inv.name as itemName FROM `inventory-log` i LEFT JOIN users u ON i.uid = u.uid LEFT JOIN inventory inv ON i.item_id = inv.id ORDER BY i.date DESC");
                    $inventory_log->execute();
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
                        echo '<tr><td colspan="6" class="text-gray text-medium font-semibold p-3 py-4 text-center">No items found.</td></tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
<?php
} else {
    echo '<p class="text-gray text-medium p-3 py-4 text-center">Error 404: Unauthorized Access.</p>';
}   
?>
<script>
    const searchInput = document.getElementById('search');
    const itemsList = document.getElementById('itemsList');

    searchInput.addEventListener('input', function(){
        const searchTerm = this.value.trim();

        fetch(`search_log.php?search=${searchTerm}`)
        .then(response => response.text())
        .then(data => {
            itemsList.innerHTML = data;
        })
        .catch(error => {
            console.error('Error fetching items:', error);
        });
    });
</script>