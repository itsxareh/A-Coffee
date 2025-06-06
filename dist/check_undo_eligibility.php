<?php
// check_undo_eligibility.php
require_once 'config.php';

$id = $_GET['id'];
$response = ['eligible' => false];

try {
    $stmt = $conn->prepare("SELECT updated_at FROM inventory WHERE id = ? AND delete_flag = 0");
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($item && !empty($item['updated_at'])) {
        $updated = DateTime::createFromFormat('m-d-Y H:i:s', $item['updated_at']);
        if ($updated) {
            $updated_timestamp = $updated->getTimestamp();
            $now = time();
            $diff = $now - $updated_timestamp;
            
            // Check if update was within last 24 hours
            $response['eligible'] = $diff <= 86400; // 24 hours in seconds
        }
    }
} catch(PDOException $e) {
    $response['error'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>