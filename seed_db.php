<?php
try {
    // Open the same SQLite DB
    $db = new PDO('sqlite:' . __DIR__ . '/db/test.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  


    // Insert three drinks if they don't already exist
    $stmt = $db->prepare("
      INSERT OR IGNORE INTO drinks
        (brand, modelPath, secondModelPath, soundPath, secondSoundPath, animation)
      VALUES
        (:brand, :modelPath, :secondModelPath, :soundPath, :secondSoundPath, :animation)
    ");

    $drinks = [
      [
        'brand'            => 'coke',
        'modelPath'        => 'assets/3D/cokeCan.glb',
        'secondModelPath'  => 'assets/3D/cokeCancrush.glb',
        'soundPath'        => 'assets/sounds/open.mp3',
        'secondSoundPath'  => 'assets/sounds/crush.mp3',
        'animation'        => 1,
      ],
      [
        'brand'            => 'sprite',
        'modelPath'        => 'assets/3D/spriteice.glb',
        'secondModelPath'  => null,
        'soundPath'        => 'assets/sounds/crush.mp3',
        'secondSoundPath'  => null,
        'animation'        => 1,
      ],
      [
        'brand'            => 'pepper',
        'modelPath'        => 'assets/3D/cancondensation.glb',
        'secondModelPath'  => null,
        'soundPath'        => 'assets/sounds/crush.mp3',
        'secondSoundPath'  => null,
        'animation'        => 1,
      ],
    ];

    foreach ($drinks as $d) {
      $stmt->execute([
        ':brand'           => $d['brand'],
        ':modelPath'       => $d['modelPath'],
        ':secondModelPath' => $d['secondModelPath'],
        ':soundPath'       => $d['soundPath'],
        ':secondSoundPath' => $d['secondSoundPath'],
        ':animation'       => $d['animation'],
      ]);
    }

    echo "✅ Seed data inserted.";
} catch (PDOException $e) {
    echo "❌ Seed error: " . $e->getMessage();
}
