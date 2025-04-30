<?php
try {
   
    $db = new PDO('sqlite:' . __DIR__ . '/db/test.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "✅ SQLite opened successfully at db/test.db";
} catch (PDOException $e) {
    echo "❌ SQLite error: " . $e->getMessage();
}
