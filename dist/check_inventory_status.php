<?php
require_once 'config.php';

header('Content-Type: application/json');

class QuantityParser {
    private static function standardizeUnit($unit) {
        // Convert unit to lowercase for standardization
        $unit = strtolower(trim($unit));
        
        // Map common unit variations
        $unitMap = [
            'l' => 'l',
            'liter' => 'l',
            'litre' => 'l',
            'kg' => 'kg',
            'kilogram' => 'kg',
            '' => 'units'  // For numeric-only values
        ];
        
        return isset($unitMap[$unit]) ? $unitMap[$unit] : $unit;
    }
    
    public static function parseQuantity($quantityStr) {
        // Remove any spaces
        $quantityStr = trim($quantityStr);
        
        // Extract number and unit using regex
        if (preg_match('/^(\d+\.?\d*)([a-zA-Z]*)$/', $quantityStr, $matches)) {
            $value = (float)$matches[1];
            $unit = self::standardizeUnit($matches[2]);
            
            return [
                'value' => $value,
                'unit' => $unit,
                'original' => $quantityStr
            ];
        }
        
        // Return null if parsing fails
        return null;
    }
}

try {
    
    $THRESHOLDS = [
        'l' => 5.0,    // 10 liters
        'kg' => 10.0,   // 15 kilograms
        'units' => 20   // 20 pieces
    ];
    
    $query = "SELECT id, name, quantity FROM inventory WHERE delete_flag = 0";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    $lowStockItems = [];
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $parsedQuantity = QuantityParser::parseQuantity($row['quantity']);
        
        if ($parsedQuantity) {
            $threshold = isset($THRESHOLDS[$parsedQuantity['unit']]) 
                ? $THRESHOLDS[$parsedQuantity['unit']] 
                : 10.0; // Default threshold
            
            if ($parsedQuantity['value'] <= $threshold) {
                $lowStockItems[] = [
                    'product_id' => $row['id'],
                    'product_name' => $row['name'],
                    'current_quantity' => $parsedQuantity['original'],
                    'threshold' => $threshold . $parsedQuantity['unit']
                ];
            }
        }
    }
    
    $response = [
        'status' => 'ok',
        'notification' => '',
    ];
    
    if (count($lowStockItems) > 0) {
        $response['status'] = 'low';
        $response['notification'] = 'Low stock alert: ' . count($lowStockItems) . ' items need attention!';
        $response['items'] = $lowStockItems;
    }
    
    echo json_encode($response);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error occurred',
    ]);
}
?>