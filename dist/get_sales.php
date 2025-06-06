<?php
require_once 'config.php';

$query = $conn->query("
    SELECT 
        STR_TO_DATE(datetime, '%m-%d-%Y') AS date,
        SUM(amount) as total
    FROM sales 
    GROUP BY STR_TO_DATE(datetime, '%m-%d-%Y')
    ORDER BY date ASC
    LIMIT 30
");

$dates = [];
$sales = [];

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $dates[] = date('M d', strtotime($row['date']));
    $sales[] = $row['total'];
}

header('Content-Type: application/json');
echo json_encode([
    'dates' => $dates,
    'sales' => $sales
]);
?>