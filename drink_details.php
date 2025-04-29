<?php
header('Content-Type: application/json');
try {
  // Open the same SQLite DB
  $db = new PDO('sqlite:' . __DIR__ . '/db/test.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if (empty($_GET['brand'])) {
    throw new Exception('No brand specified');
  }
  $brand = $_GET['brand'];

  // Fetch all columns for this brand
  $stmt = $db->prepare('SELECT * FROM drinks WHERE brand = ?');
  $stmt->execute([$brand]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$row) {
    throw new Exception("Drink not found: $brand");
  }

  echo json_encode($row);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}
