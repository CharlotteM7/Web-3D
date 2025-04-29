<?php
try {
    // Open the SQLite DB
    $db = new PDO('sqlite:' . __DIR__ . '/db/test.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query only the 'brand' column
    $stmt = $db->query("SELECT brand FROM drinks ORDER BY brand");
    $brands = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Return as JSON for easy consumption
    header('Content-Type: application/json');
    echo json_encode($brands);
} catch (PDOException $e) {
    echo "Error fetching brands: " . $e->getMessage();
}
