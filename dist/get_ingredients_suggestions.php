<?php
include 'config.php';

// Get the search term
$term = $_GET['name'] ?? '';

if ($term) {
    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT name FROM inventory WHERE name LIKE :term AND delete_flag = 0 LIMIT 10");
    $stmt->execute(['term' => "%$term%"]);

    // Fetch results
    $suggestions = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Output the results as JSON
    header('Content-Type: application/json');
    echo json_encode($suggestions);
}