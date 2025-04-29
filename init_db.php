<?php
try {
    // Open the same SQLite DB
    $db = new PDO('sqlite:' . __DIR__ . '/db/test.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the drinks table if it doesn't exist
    $db->exec("
        CREATE TABLE IF NOT EXISTS drinks (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          brand TEXT UNIQUE NOT NULL,
          modelPath TEXT,
          secondModelPath TEXT,
          soundPath TEXT,
          secondSoundPath TEXT,
          animation INTEGER DEFAULT 0
        );
    ");

    echo "✅ Table `drinks` is ready.";
} catch (PDOException $e) {
    echo "❌ Error creating table: " . $e->getMessage();
}
