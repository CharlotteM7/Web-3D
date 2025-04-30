<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

try {
    $brand = $_GET['brand'] ?? '';
    if (!$brand) throw new Exception("No brand specified");

    // Connect to DB
    $db = new PDO('sqlite:' . __DIR__ . '/db/test.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "DB Path: " . __DIR__ . '/db/test.db';


    // Prepare and execute query
    $stmt = $db->prepare("SELECT * FROM Model_3D WHERE brandName = ?");
    $stmt->execute([$brand]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result[0] ?? []);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    http_response_code(500);
}
