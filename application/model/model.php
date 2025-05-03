<?php
/**
* Model class for handling database operations for the Web 3D App.
* Uses PDO with SQLite to manage drink data.
*/
class Model
{
    private PDO $db;
    private $dbPath;
    public PDO $dbhandle;

    public function __construct()
    {
        $this->dbPath = __DIR__ . '/../../db/test.db'; // Path to the SQLite database
        $this->dbhandle = new PDO('sqlite:' . $this->dbPath);
        $this->dbhandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    /**
     * Drops and recreates the drinks table.
     */
    public function dbCreateTable(): string
    {
        try {
            $pdo = new PDO('sqlite:' . $this->dbPath);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // 1) Drop the table if it already exists
            $pdo->exec("DROP TABLE IF EXISTS drinks;");

            // 2) Create a fresh drinks table
            $pdo->exec("
                CREATE TABLE drinks (
                    id               INTEGER PRIMARY KEY AUTOINCREMENT,
                    brand            TEXT UNIQUE NOT NULL,
                    modelPath        TEXT,
                    secondModelPath  TEXT,
                    soundPath        TEXT,
                    secondSoundPath  TEXT,
                    animation        INTEGER DEFAULT 0
                );
            ");

            return "✅ Table `drinks` is ready.";
        } catch (PDOException $e) {
            return "❌ Error creating table: " . $e->getMessage();
        }
    }
    /**
     * Inserts seed data into the drinks table.
     */
    public function dbInsertData(): string
    {
        try {
            $pdo = new PDO('sqlite:' . $this->dbPath);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Wipe any old seed data
            $pdo->exec("DELETE FROM drinks;");

            // Prepare the INSERT statement (INSERT OR IGNORE to avoid duplicates)
            $stmt = $pdo->prepare("
                INSERT OR IGNORE INTO drinks
                  (brand, modelPath, secondModelPath, soundPath, secondSoundPath, animation)
                VALUES
                  (:brand, :modelPath, :secondModelPath, :soundPath, :secondSoundPath, :animation)
            ");

            // Define your seed data here:
            $drinks = [
                [
                    'brand' => 'coke',
                    'modelPath' => 'assets/3D/cokeCan.glb',
                    'secondModelPath' => 'assets/3D/cokeCancrush.glb',
                    'soundPath' => 'assets/sounds/open.mp3',
                    'secondSoundPath' => 'assets/sounds/crush.mp3',
                    'animation' => 1
                ],
                [
                    'brand' => 'sprite',
                    'modelPath' => 'assets/3D/spriteiceanimation.glb',
                    'secondModelPath' => '',
                    'soundPath' => '',
                    'secondSoundPath' => '',
                    'animation' => 1
                ],
                [
                    'brand' => 'pepper',
                    'modelPath' => 'assets/3D/cantobottle.glb',
                    'secondModelPath' => 'assets/3D/canroll.glb',
                    'soundPath' => '',
                    'secondSoundPath' => '',
                    'animation' => 1
                ]
            ];

            // Execute the INSERT for each entry
            foreach ($drinks as $d) {
                $stmt->execute([
                    ':brand' => $d['brand'],
                    ':modelPath' => $d['modelPath'],
                    ':secondModelPath' => $d['secondModelPath'],
                    ':soundPath' => $d['soundPath'],
                    ':secondSoundPath' => $d['secondSoundPath'],
                    ':animation' => $d['animation'],
                ]);
            }

            return "✅ Seed data inserted.";
        } catch (PDOException $e) {
            return "❌ Seed error: " . $e->getMessage();
        }
    }

    /**
     * Fetch all rows from the drinks table.
     *
     * @return array  Each element is an associative array of a drink record.
     */
    public function dbGetData(): array
    {
        try {
            $pdo = new PDO('sqlite:' . $this->dbPath);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->query("SELECT * FROM drinks");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // On error, return an empty array
            return [];
        }
    }

    /** 
     * Return an array of all distinct brand names 
     */
    public function getBrands(): array
    {
        $pdo = new PDO('sqlite:' . $this->dbPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->query("SELECT DISTINCT brand FROM drinks");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    /**
     * Gets details of a specific drink by brand.
     */
    public function dbGetDrinkDetails($brand)
    {
        $stmt = $this->dbhandle->prepare("SELECT * FROM drinks WHERE brand = ?");
        $stmt->execute([$brand]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * Gets a list of all drink brand names.
     */
    public function dbGetBrandList()
    {
        $stmt = $this->dbhandle->query("SELECT DISTINCT brand FROM drinks");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    /**
     * Gets image paths for a drink's gallery based on drink brand.
     * Assumes the folder naming convention matches the brand name.
     */
    public function dbGetGalleryImages($drink)
    {
        $dir = "gallery/$drink";
        $images = [];

        if (is_dir($dir)) {
            foreach (scandir($dir) as $file) {
                if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $file)) {
                    $images[] = "$dir/$file";
                }
            }
        }

        return $images;
    }



}
