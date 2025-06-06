<?php
require_once 'config.php';
$uid = $_SESSION['uid'];
$response = ['success' => false];

try {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        
        $conn->beginTransaction();
        
        $stmt = $conn->prepare("SELECT * FROM inventory WHERE id = ? AND delete_flag = 0");
        $stmt->execute([$id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($item && $item['quantity_before']) {
            $updated = DateTime::createFromFormat('m-d-Y H:i:s', $item['updated_at']);
            if ($updated) {
                $diff = time() - $updated->getTimestamp();
                if ($diff <= 86400) {
                    $stmt = $conn->prepare("UPDATE inventory SET 
                        quantity = ?, 
                        updated_at = NULL,
                        quantity_before = NULL 
                        WHERE id = ?");
                    $stmt->execute([$item['quantity_before'], $id]);

                    $log = $_SESSION['name']. " undo the changes of an item: ". ucwords($item['name']) .".";
                    $insert_log = $conn->prepare("INSERT INTO activity_log(uid, log, datetime) VALUES (?,?,?)");
                    $insert_log->bindParam(1, $uid);
                    $insert_log->bindParam(2, $log);
                    $insert_log->bindParam(3, $currentDateTime);
                    $insert_log->execute();

                    $conn->commit();
                    
                    $response['success'] = true;
                    $response['quantity'] = $item['quantity_before'];
                    $response['updated_at'] = 'N/A';
                    $response['message'] = 'Successfully undone changes';
                } else {
                    throw new Exception('Changes can only be undone within 24 hours');
                }
            } else {
                throw new Exception('Invalid date format');
            }
        } else {
            throw new Exception('No previous quantity found or item not eligible for undo');
        }
    }
} catch(Exception $e) {
    $conn->rollBack();
    $response['message'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>